<!DOCTYPE html>
<html>
<head>
    <title>FPC Swap</title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/ethers/5.7.2/ethers.umd.min.js"></script>

<style>
body {
    font-family: Arial;
    background: #0f172a;
    color: white;
    padding: 20px;
}

h2 {
    text-align: center;
    margin-bottom: 20px;
}

/* GRID → FORCE 3 COLUMNS */
.container {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    max-width: 1200px;
    margin: auto;
}

/* CARD */
.box {
    background: #1e293b;
    padding: 20px;
    border-radius: 10px;
}

/* INPUT */
input {
    width: 100%;
    padding: 12px;
    margin-top: 10px;
    border-radius: 6px;
    border: none;
}

/* BUTTON */
button {
    padding: 12px;
    margin-top: 10px;
    width: 100%;
    cursor: pointer;
    border: none;
    border-radius: 6px;
    background: #22c55e;
    color: white;
    font-weight: bold;
}

.switch-btn {
    background: #334155;
}

/* RESPONSE BOX */
.response {
    margin-top: 10px;
    padding: 10px;
    background: #020617;
    border-radius: 5px;
    text-align: left;
    font-size: 13px;
    max-height: 400px;
    overflow-y: auto;
}
</style>
</head>

<body>

<h2>🚀 FPC SWAP</h2>

<div class="container">

    <!-- WALLET -->
    <div class="box">
        <h3>Wallet</h3>

        <button onclick="connectWallet()">Connect Wallet</button>
        <p id="wallet">Not Connected</p>

        <hr>

        <p>USDT: <span id="usdtBalance">0</span></p>
        <p>FPC: <span id="tokenBalance">0</span></p>

        <button onclick="loadBalances()">Refresh</button>
    </div>

    <!-- SWAP -->
    <div class="box">
        <h3>Swap</h3>

        <p id="swapDirection">USDT → FPC</p>

        <input id="swapAmount" placeholder="Enter amount">

        <p id="swapEstimate"></p>

        <button class="switch-btn" onclick="toggleSwap()">⇅ Switch</button>

        <button id="mainButton" onclick="handleAction()">Approve</button>
    </div>

    <!-- RESPONSE -->
    <div class="box">
        <h3>Response</h3>
        <div id="response" class="response"></div>
    </div>

</div>

<script>

// ================= CONFIG =================
const contractAddress = "0x52447fcdBd04657D79C7f2dCEC2345580FB755fF";
const tokenAddress = "0xB123C666268edA865cC5361BD1785B91536Cbe4F";
const usdtAddress = "0x55d398326f99059fF775485246999027B3197955";

const BSC_CHAIN_ID = "0x38";

// ================= ABI =================
const contractABI = [
    "function price() view returns(uint256)",
    "function buyFee() view returns(uint256)",
    "function sellFee() view returns(uint256)",
    "function paused() view returns(bool)",
    "function owner() view returns(address)"
];

const erc20ABI = [
    "function approve(address,uint256)",
    "function balanceOf(address) view returns(uint256)",
    "function decimals() view returns(uint8)",
    "function allowance(address,address) view returns(uint256)"
];

// ================= GLOBAL =================
let provider, signer, contract;
let isBuying = true;
let needsApproval = true;

// ================= LOG =================
function log(msg) {
    const box = document.getElementById("response");
    box.innerHTML += "• " + msg + "<br>";
    box.scrollTop = box.scrollHeight;
}

// ================= CONNECT =================
async function connectWallet() {
    try {
        if (!window.ethereum) {
            log("❌ MetaMask not installed");
            return;
        }

        log("🔌 Connecting wallet...");

        provider = new ethers.providers.Web3Provider(window.ethereum);

        await provider.send("eth_requestAccounts", []);

        log("🌐 Switching to BSC...");

        try {
            await window.ethereum.request({
                method: "wallet_switchEthereumChain",
                params: [{ chainId: BSC_CHAIN_ID }]
            });
        } catch {
            log("⚠️ Please switch network manually");
        }

        signer = provider.getSigner();
        const address = await signer.getAddress();

        document.getElementById("wallet").innerText = address;

        log("✅ Wallet connected: " + address);

        contract = new ethers.Contract(contractAddress, contractABI, signer);

        await loadBalances();
        await checkAllowance();
        await loadConfig();

    } catch (err) {
        log("❌ " + err.message);
    }
}

// ================= BALANCE =================
async function loadBalances() {
    try {
        if (!signer) return;

        const address = await signer.getAddress();

        log("📊 Loading balances...");

        const usdt = new ethers.Contract(usdtAddress, erc20ABI, provider);
        const token = new ethers.Contract(tokenAddress, erc20ABI, provider);

        const usdtBal = await usdt.balanceOf(address);
        const usdtDec = await usdt.decimals();

        const tokenBal = await token.balanceOf(address);
        const tokenDec = await token.decimals();

        document.getElementById("usdtBalance").innerText =
            parseFloat(ethers.utils.formatUnits(usdtBal, usdtDec)).toFixed(3);

        document.getElementById("tokenBalance").innerText =
            parseFloat(ethers.utils.formatUnits(tokenBal, tokenDec)).toFixed(3);

        log("✅ Balances updated");

    } catch (err) {
        log("❌ Balance error: " + err.message);
    }
}

// ================= TOGGLE =================
function toggleSwap() {
    isBuying = !isBuying;

    document.getElementById("swapDirection").innerText =
        isBuying ? "USDT → FPC" : "FPC → USDT";

    document.getElementById("swapAmount").value = "";
    document.getElementById("swapEstimate").innerText = "";

    log("🔄 Swap direction changed");

    checkAllowance();
}

// ================= ALLOWANCE =================
async function checkAllowance() {
    try {
        if (!signer) return;

        const address = await signer.getAddress();

        const tokenAddr = isBuying ? usdtAddress : tokenAddress;

        const token = new ethers.Contract(tokenAddr, erc20ABI, provider);

        const allowance = await token.allowance(address, contractAddress);

        needsApproval = allowance.eq(0);

        updateButton();

        log("🔍 Allowance checked");

    } catch (err) {
        log("❌ Allowance error: " + err.message);
    }
}

// ================= BUTTON =================
function updateButton() {
    const btn = document.getElementById("mainButton");

    btn.innerText = needsApproval ? "Approve" : "Swap";
}

// ================= MAIN ACTION =================
async function handleAction() {
    if (needsApproval) {
        await approve();
        await checkAllowance();
    } else {
        await swap();
    }
}

// ================= APPROVE =================
async function approve() {
    try {
        const addr = isBuying ? usdtAddress : tokenAddress;

        log("⏳ Approving token...");

        const token = new ethers.Contract(addr, erc20ABI, signer);

        const tx = await token.approve(contractAddress, ethers.constants.MaxUint256);

        log("📤 TX: " + tx.hash);

        await tx.wait();

        log("✅ Approved");

    } catch (err) {
        log("❌ " + err.message);
    }
}

// ================= SWAP =================
async function swap() {
    try {
        const val = document.getElementById("swapAmount").value;

        if (!val) {
            log("⚠️ Enter amount");
            return;
        }

        log("⏳ Processing swap...");

        let tx;

        if (isBuying) {
            tx = await contract.buy(ethers.utils.parseUnits(val, 6), 0);
        } else {
            tx = await contract.sell(ethers.utils.parseUnits(val, 18), 0);
        }

        log("📤 TX: " + tx.hash);

        await tx.wait();

        log("✅ Swap successful");

        loadBalances();
        checkAllowance();

    } catch (err) {
        log("❌ " + err.message);
    }
}
// ================= ESTIMATION =================

let estimateTimeout;

// cache values (loaded once)
let price, buyFee, sellFee;

// ================= LOAD CONFIG =================
async function loadConfig() {
    price = await contract.price();     // 1e18 scaled
    buyFee = await contract.buyFee();   // e.g. 200
    sellFee = await contract.sellFee();

    log("?? Config loaded");
}

// ================= INPUT LISTENER =================
document.getElementById("swapAmount").addEventListener("input", () => {
    clearTimeout(estimateTimeout);
    estimateTimeout = setTimeout(runEstimate, 400);
});

// ================= MAIN ESTIMATE =================
async function runEstimate() {
    try {
        if (!contract) return;

        let val = document.getElementById("swapAmount").value;

        // ===== VALIDATION =====
        if (!val || isNaN(val) || val === "." || val === "0.") {
            document.getElementById("swapEstimate").innerText = "";
            return;
        }

        let result;

        if (isBuying) {
            // ================= BUY =================
            // USDT ? FPC
            const usdt = ethers.utils.parseUnits(val, 6);

            // EXACT contract logic (no custom scaling)
            let tokenAmount = usdt.mul("1000000000000000000").div(price);

            let fee = tokenAmount.mul(buyFee).div(10000);

            let result = tokenAmount.sub(fee);

            document.getElementById("swapEstimate").innerText =
                "You get: " + ethers.utils.formatUnits(result, 18) + " FPC";

        } else {
            // ================= SELL =================
            // FPC ? USDT

            // 1?? FPC (18 decimals)
            const token = ethers.utils.parseUnits(val, 18);

            // 2?? contract formula
            // usdtAmount = (token * price) / 1e18
            let usdt18 = token.mul(price).div(ethers.constants.WeiPerEther);

            // 3?? convert 18 ? 6 decimals
            let usdtAmount = usdt18.div(ethers.BigNumber.from("1000000000000")); // 1e12

            // 4?? fee
            let fee = usdtAmount.mul(sellFee).div(10000);

            // 5?? final
            result = usdtAmount.sub(fee);

            document.getElementById("swapEstimate").innerText =
                "You get: " + ethers.utils.formatUnits(result, 6) + " USDT";
        }

    } catch (e) {
        document.getElementById("swapEstimate").innerText = "?? Invalid amount";
    }
}
</script>

</body>
</html>