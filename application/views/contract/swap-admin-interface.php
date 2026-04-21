
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ethers/5.7.2/ethers.umd.min.js"></script>
<style>

    h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    /* GRID CONTAINER */
    .s-container {
        display: grid;
        grid-template-columns: repeat(3, 1fr); /* ✅ 3 per row */
        gap: 20px;
        margin: auto;
        margin-bottom: 100px;
    }

    /* Tablet */
    @media (max-width: 900px) {
        .s-container {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    /* Mobile */
    @media (max-width: 500px) {
        .s-container {
            grid-template-columns: 1fr;
        }
    }
    /* CARD BOX */
    .box {
        background: #1e293b;
        padding: 20px;
        border-radius: 10px;
    }
    
    .response-box {
        grid-column: span 3;
    }

    button {
        padding: 10px;
        margin-top: 10px;
        width: 100%;
        cursor: pointer;
        border: none;
        border-radius: 5px;
        background: #22c55e;
        color: white;
    }

    .response {
        margin-top: 10px;
        padding: 10px;
        background: #020617;
        border-radius: 5px;
        text-align: left;
        font-size: 13px;
        max-height: 200px;
        overflow-y: auto;
    }
</style>
<h2>FPC ADMIN PANEL</h2>

<div class="s-container">

    <!-- CONNECT + INFO -->
    <div class="box">
        <h3>Wallet & System</h3>

        <button onclick="connectWallet()">Connect Wallet</button>
        <p id="wallet">Not Connected</p>
        <p id="role">Role: -</p>

        <hr>

        <p>FPC Balance: <span id="fpcBal">0</span></p>
        <p>USDT Balance: <span id="usdtBal">0</span></p>

        <p>Price: <span id="price">0</span></p>
        <p>Buy Fee: <span id="buyFee">0</span></p>
        <p>Sell Fee: <span id="sellFee">0</span></p>

        <p>Status: <span id="status">Unknown</span></p>

        <button onclick="refreshAll()">Refresh</button>
    </div>
    
    <!-- RESPONSE -->
    <div class="box">
        <h3>Response</h3>
        <div id="response" class="response"></div>
    </div>


    <!-- ADMIN BLOCK 1 -->
    <div class="box admin-only" style="display:none;">
        <h3>Deposit Liquidity</h3>

        <input id="depFPC" placeholder="FPC Amount" class="form-control my-1">
        <input id="depUSDT" placeholder="USDT Amount" class="form-control my-1">

        <button onclick="handleDeposit()">Deposit</button>
    </div>

    <!-- ADMIN BLOCK 2 -->
    <div class="box admin-only" style="display:none;">
        <h3>Price Control</h3>

        <input id="newPrice" placeholder="New Price (e.g. 0.5)" class="form-control my-1">

        <button onclick="queueNewPrice()">Queue Price</button>
        <button onclick="executeNewPrice()" id="executePriceBtn" disabled>Execute Price</button>

        <hr>

        <p>Pending Price: <span id="pendingPrice">-</span></p>
        <p>Execute In: <span id="countdown">-</span></p>
    </div>

    <!-- ADMIN BLOCK 3 -->
    <div class="box admin-only" style="display:none;">
        <h3>Fees Control</h3>

        <input id="newBuyFee" placeholder="Buy Fee (200 = 2%)" class="form-control my-1">
        <input id="newSellFee" placeholder="Sell Fee" class="form-control my-1">

        <button onclick="queueFees()">Queue Fees</button>
        <button id="executeFeesBtn" onclick="executeFees()" disabled>Execute Fees</button>

        <hr>

        <p>Pending Buy: <span id="pendingBuy">-</span></p>
        <p>Pending Sell: <span id="pendingSell">-</span></p>
        <p>Execute In: <span id="feeCountdown">-</span></p>
    </div>

    <!-- ADMIN BLOCK 4 -->
    <div class="box admin-only" style="display:none;">
        <h3>Pause Control</h3>

        <button id="queuePauseBtn" onclick="queuePause(true)">Queue Pause</button>
        <button id="queueUnpauseBtn" onclick="queuePause(false)">Queue Unpause</button>

        <button id="executePauseBtn" onclick="executePause()" disabled>
            Execute
        </button>

        <hr>

        <p>Current Status: <span id="currentPause">-</span></p>
        <p>Pending: <span id="pendingPause">-</span></p>
        <p>Execute In: <span id="pauseCountdown">-</span></p>
    </div>

    <!-- ADMIN BLOCK 5 -->
    <div class="box admin-only" style="display:none;">
        <h3>Withdraw</h3>

        <select id="withdrawTokenSelect" onchange="setWithdrawToken()" class="form-control my-1">
            <option value="fpc" selected>FPC</option>
            <option value="usdt">USDT</option>
            <option value="custom">Custom Token</option>
        </select>

        <input id="customToken" placeholder="Token Address" style="display:none;" oninput="loadCustomTokenBalance()" 
               class="form-control my-1">
        <p>Available Balance: <span id="withdrawBalance">0</span></p>
        <button onclick="setMaxWithdraw()">Max</button>
        <input id="withdrawAmount" placeholder="Amount" class="form-control my-1">

        <button onclick="withdrawTokens()">Withdraw</button>
    </div>
</div>

<script>

// ================= CONFIG =================
const contractAddress = "0x52447fcdBd04657D79C7f2dCEC2345580FB755fF";
const tokenAddress = "0xB123C666268edA865cC5361BD1785B91536Cbe4F";
const usdtAddress = "0x55d398326f99059fF775485246999027B3197955";

// BNB CHAIN
const BSC_CHAIN = {
    chainId: "0x38"
};

// ABI (READ FUNCTIONS ONLY)
const abi = [
    "function price() view returns(uint256)",
    "function buyFee() view returns(uint256)",
    "function sellFee() view returns(uint256)",
    "function paused() view returns(bool)",
    "function owner() view returns(address)"
];
    
const writeAbi = [
    "function deposit(uint256,uint256)"
];
    
const priceAbi = [
    "function queuePrice(uint256)",
    "function executePrice()",
    "function pendingPrice() view returns(uint256)",
    "function priceExecuteTime() view returns(uint256)"
];

const feesAbi = [
    "function queueFees(uint256,uint256)",
    "function executeFees()",
    "function pendingBuyFee() view returns(uint256)",
    "function pendingSellFee() view returns(uint256)",
    "function feeExecuteTime() view returns(uint256)"
];
    
const pauseAbi = [
    "function queuePause(bool)",
    "function executePause()",
    "function pendingPause() view returns(bool)",
    "function pauseExecuteTime() view returns(uint256)",
    "function paused() view returns(bool)"
];
    
let provider, signer, contract;

// ================= RESPONSE LOG =================
function log(msg) {
    const box = document.getElementById("response");
    box.innerHTML += "• " + msg + "<br>";
    box.scrollTop = box.scrollHeight;
}

// ================= CONNECT =================
async function connectWallet() {
    try {
        provider = new ethers.providers.Web3Provider(window.ethereum);
        await provider.send("eth_requestAccounts", []);

        // Switch to BSC
        try {
            await window.ethereum.request({
                method: "wallet_switchEthereumChain",
                params: [{ chainId: "0x38" }]
            });
        } catch (err) {
            log("⚠️ Please switch to BNB Chain manually");
        }

        signer = provider.getSigner();
        const address = await signer.getAddress();

        document.getElementById("wallet").innerText = address;

        contract = new ethers.Contract(contractAddress, abi, provider);

        log("Wallet connected");
        
        const owner = await contract.owner();

        if (address.toLowerCase() === owner.toLowerCase()) {

            document.getElementById("role").innerText = "Role: Admin";
            log("Admin access granted");

            // ✅ SHOW ALL ADMIN BLOCKS
            document.querySelectorAll(".admin-only").forEach(el => {
                el.style.display = "block";
            });

        } else {

            document.getElementById("role").innerText = "Role: User";
            log("Not admin wallet");

            document.querySelectorAll(".admin-only").forEach(el => {
                el.style.display = "none";
            });
        }

        await refreshAll();
        await loadPriceTimelock();
        await loadFeesTimelock();
        await loadPauseTimelock();
        await initWithdrawSection();

    } catch (err) {
        log("Error: " + err.message);
    }
}

// ================= REFRESH =================
async function refreshAll() {
    try {
        log("Refreshing data...");

        // TOKEN CONTRACTS
        const token = new ethers.Contract(tokenAddress, [
            "function balanceOf(address) view returns(uint256)",
            "function decimals() view returns(uint8)"
        ], provider);

        const usdt = new ethers.Contract(usdtAddress, [
            "function balanceOf(address) view returns(uint256)",
            "function decimals() view returns(uint8)"
        ], provider);


        // BALANCES
        const tBal = await token.balanceOf(contractAddress);
        const uBal = await usdt.balanceOf(contractAddress);

        const tDec = await token.decimals();
        const uDec = await usdt.decimals();

        document.getElementById("fpcBal").innerText =
            ethers.utils.formatUnits(tBal, tDec);

        document.getElementById("usdtBal").innerText =
            ethers.utils.formatUnits(uBal, uDec);

        // CONTRACT DATA
        const price = await contract.price();
        const buyFee = await contract.buyFee();
        const sellFee = await contract.sellFee();
        const paused = await contract.paused();

        document.getElementById("price").innerText =
            ethers.utils.formatUnits(price, 18);

        document.getElementById("buyFee").innerText =
            (buyFee / 100) + "%";

        document.getElementById("sellFee").innerText =
            (sellFee / 100) + "%";

        document.getElementById("status").innerText =
            paused ? "Paused" : "Active";

        log("Data updated");

    } catch (err) {
        log("Error: " + err.message);
    }
}
    
// ================= Deposit Liquidity =================
async function handleDeposit() {
    try {
        log("Starting deposit process...");

        const fpc = document.getElementById("depFPC").value;
        const usdt = document.getElementById("depUSDT").value;
        if (!fpc || !usdt) {
            log("Enter both amounts");
            return;
        }

        // Contracts
        const token = new ethers.Contract(tokenAddress, [
            "function allowance(address,address) view returns(uint256)",
            "function approve(address,uint256) returns(bool)",
            "function decimals() view returns(uint8)"
        ], signer);

        const usdtC = new ethers.Contract(usdtAddress, [
            "function allowance(address,address) view returns(uint256)",
            "function approve(address,uint256) returns(bool)",
            "function decimals() view returns(uint8)"
        ], signer);

        const address = await signer.getAddress();

        // Decimals
        const tDec = await token.decimals();
        const uDec = await usdtC.decimals();

        const tAmount = ethers.utils.parseUnits(fpc, tDec);
        const uAmount = ethers.utils.parseUnits(usdt, uDec);

        // ======================
        // CHECK ALLOWANCE
        // ======================
        const tAllowance = await token.allowance(address, contractAddress);
        const uAllowance = await usdtC.allowance(address, contractAddress);

        // ======================
        // APPROVE IF NEEDED
        // ======================
        if (tAllowance.lt(tAmount)) {
            log("Approving FPC...");
            const tx1 = await token.approve(contractAddress, ethers.constants.MaxUint256);
            await tx1.wait();
            log("FPC Approved");
        } else {
            log("FPC already approved");
        }

        if (uAllowance.lt(uAmount)) {
            log("Approving USDT...");
            const tx2 = await usdtC.approve(contractAddress, ethers.constants.MaxUint256);
            await tx2.wait();
            log("USDT Approved");
        } else {
            log("USDT already approved");
        }

        // ======================
        // DEPOSIT
        // ======================
        log("Depositing...");

        const writeContract = new ethers.Contract(contractAddress, [
            "function deposit(uint256,uint256)"
        ], signer);

        const tx = await writeContract.deposit(tAmount, uAmount);
        await tx.wait();

        log("Deposit successful");
        
        document.getElementById("depFPC").value='';
        document.getElementById("depUSDT").value='';
        
        await refreshAll();

    } catch (err) {
        log("Error: " + err.message);
    }
}
    
// ================= Queue New Price =================
async function queueNewPrice() {
    try {
        const val = document.getElementById("newPrice").value;

        if (!val) {
            log("Enter price");
            return;
        }

        const price = ethers.utils.parseUnits(val, 18);

        const contractW = new ethers.Contract(contractAddress, priceAbi, signer);

        log("Queueing price...");

        const tx = await contractW.queuePrice(price);
        await tx.wait();

        log("Price queued successfully");

        loadPriceTimelock();

    } catch (err) {
        log("Error: " + err.message);
    }
}
    
// ================= Execute New Price =================
async function executeNewPrice() {
    try {

        const contractR = new ethers.Contract(contractAddress, priceAbi, provider);
        const execTime = await contractR.priceExecuteTime();

        const now = Math.floor(Date.now() / 1000);

        if (now < execTime.toNumber()) {
            log("Too early to execute");
            return;
        }

        const contractW = new ethers.Contract(contractAddress, priceAbi, signer);

        log("Executing price...");
        const tx = await contractW.executePrice();
        await tx.wait();

        log("Price updated");

        await refreshAll();
        loadPriceTimelock();

    } catch (err) {
        log("Error: " + err.message);
    }
}
    
// ================= Load Time Lock =================
async function loadPriceTimelock() {
    try {
        const contractR = new ethers.Contract(contractAddress, priceAbi, provider);

        const p = await contractR.pendingPrice();
        const t = await contractR.priceExecuteTime();

        if (p.eq(0)) {
            document.getElementById("pendingPrice").innerText = "None";
            document.getElementById("countdown").innerText = "-";
            return;
        }

        document.getElementById("pendingPrice").innerText =
            ethers.utils.formatUnits(p, 18);

        updateCountdown(t.toNumber());

    } catch (err) {
        log("Error loading timelock");
    }
}
    
// ================= Load Time Lock =================
let timer;

function updateCountdown(execTime) {

    clearInterval(timer);

    timer = setInterval(() => {

        const now = Math.floor(Date.now() / 1000);
        let diff = execTime - now;

        const btn = document.getElementById("executePriceBtn");

        if (diff <= 0) {
            document.getElementById("countdown").innerText = "Ready to execute";
            btn.disabled = false; // ✅ ENABLE BUTTON
            clearInterval(timer);
            return;
        }

        btn.disabled = true; // ❌ DISABLE BUTTON

        const h = Math.floor(diff / 3600);
        const m = Math.floor((diff % 3600) / 60);
        const s = diff % 60;

        document.getElementById("countdown").innerText =
            `${h}h ${m}m ${s}s`;

    }, 1000);
}
    
// ================= Queue Fees =================
async function queueFees() {
    try {
        const buy = document.getElementById("newBuyFee").value;
        const sell = document.getElementById("newSellFee").value;

        if (!buy || !sell) {
            log("Enter both fees");
            return;
        }

        if (buy > 500 || sell > 500) {
            log("Max fee is 5%");
            return;
        }

        const contractW = new ethers.Contract(contractAddress, feesAbi, signer);

        log("Queueing fees...");

        const tx = await contractW.queueFees(buy, sell);
        await tx.wait();

        log("Fees queued");

        loadFeesTimelock();

    } catch (err) {
        log("Error: " + err.message);
    }
}
    
// ================= Execute Fees =================
async function executeFees() {
    try {

        const contractR = new ethers.Contract(contractAddress, feesAbi, provider);
        const execTime = await contractR.feeExecuteTime();

        const now = Math.floor(Date.now() / 1000);

        if (now < execTime.toNumber()) {
            log("Too early to execute");
            return;
        }

        const contractW = new ethers.Contract(contractAddress, feesAbi, signer);

        log("Executing fees...");
        const tx = await contractW.executeFees();
        await tx.wait();

        log("Fees updated");

        await refreshAll();
        loadFeesTimelock();

    } catch (err) {
        log("Error: " + err.message);
    }
}
    
// ================= Fees Time Lock =================
async function loadFeesTimelock() {
    try {
        const contractR = new ethers.Contract(contractAddress, feesAbi, provider);

        const buy = await contractR.pendingBuyFee();
        const sell = await contractR.pendingSellFee();
        const time = await contractR.feeExecuteTime();

        if (buy.eq(0) && sell.eq(0)) {
            document.getElementById("pendingBuy").innerText = "None";
            document.getElementById("pendingSell").innerText = "None";
            document.getElementById("feeCountdown").innerText = "-";
            return;
        }

        document.getElementById("pendingBuy").innerText = (buy / 100) + "%";
        document.getElementById("pendingSell").innerText = (sell / 100) + "%";

        updateFeeCountdown(time.toNumber());

    } catch (err) {
        log("Error loading fee data");
    }
}
    
// ================= Fees Timer =================
let feeTimer;

function updateFeeCountdown(execTime) {

    clearInterval(feeTimer);

    feeTimer = setInterval(() => {

        const now = Math.floor(Date.now() / 1000);
        let diff = execTime - now;

        const btn = document.getElementById("executeFeesBtn");

        if (diff <= 0) {
            document.getElementById("feeCountdown").innerText = "Ready to execute";
            btn.disabled = false; // ✅ ENABLE
            clearInterval(feeTimer);
            return;
        }

        btn.disabled = true; // ❌ DISABLE

        const h = Math.floor(diff / 3600);
        const m = Math.floor((diff % 3600) / 60);
        const s = diff % 60;

        document.getElementById("feeCountdown").innerText =
            `${h}h ${m}m ${s}s`;

    }, 1000);
}
    
// ================= Queue Pause =================
async function queuePause(state) {
    try {
        const contractW = new ethers.Contract(contractAddress, pauseAbi, signer);

        log(state ? "Queueing Pause..." : "Queueing Unpause...");

        const tx = await contractW.queuePause(state);
        await tx.wait();

        log("Pause action queued");

        loadPauseTimelock();

    } catch (err) {
        log("Error: " + err.message);
    }
}
    
// ================= Execute Pause =================
async function executePause() {
    try {
        const contractR = new ethers.Contract(contractAddress, pauseAbi, provider);
        const execTime = await contractR.pauseExecuteTime();

        const now = Math.floor(Date.now() / 1000);

        if (now < execTime.toNumber()) {
            log("Too early to execute");
            return;
        }

        const contractW = new ethers.Contract(contractAddress, pauseAbi, signer);

        log("Executing pause change...");

        const tx = await contractW.executePause();
        await tx.wait();

        log("Pause state updated");

        await refreshAll();
        loadPauseTimelock();

    } catch (err) {
        log("Error: " + err.message);
    }
}
    
// ================= Load Pause Time Lock =================
async function loadPauseTimelock() {
    try {
        const contractR = new ethers.Contract(contractAddress, pauseAbi, provider);

        const current = await contractR.paused();
        const pending = await contractR.pendingPause();
        const time = await contractR.pauseExecuteTime();

        const pauseBtn = document.getElementById("queuePauseBtn");
        const unpauseBtn = document.getElementById("queueUnpauseBtn");

        // =====================
        // CURRENT STATUS
        // =====================
        document.getElementById("currentPause").innerText =
            current ? "Paused" : "Active";

        document.getElementById("pendingPause").innerText =
            time.toNumber() === 0
                ? "None"
                : (pending ? "Pause" : "Unpause");

        // =====================
        // BUTTON LOGIC
        // =====================

        // If something already queued → disable both
        if (time.toNumber() > 0) {
            pauseBtn.disabled = true;
            unpauseBtn.disabled = true;
        } else {
            if (current) {
                // Already paused
                pauseBtn.disabled = true;   // ❌ can't pause again
                unpauseBtn.disabled = false; // ✅ can unpause
            } else {
                // Active
                pauseBtn.disabled = false;  // ✅ can pause
                unpauseBtn.disabled = true; // ❌ can't unpause
            }
        }

        // =====================
        // COUNTDOWN
        // =====================
        if (time.toNumber() === 0) {
            document.getElementById("pauseCountdown").innerText = "-";
            document.getElementById("executePauseBtn").disabled = true;
            return;
        }

        updatePauseCountdown(time.toNumber());

    } catch (err) {
        log("Error loading pause data");
    }
}
    
// ================= Pause Timer =================
let pauseTimer;

function updatePauseCountdown(execTime) {

    clearInterval(pauseTimer);

    pauseTimer = setInterval(() => {

        const now = Math.floor(Date.now() / 1000);
        let diff = execTime - now;

        const btn = document.getElementById("executePauseBtn");

        if (diff <= 0) {
            document.getElementById("pauseCountdown").innerText = "Ready to execute";
            btn.disabled = false;
            clearInterval(pauseTimer);
            return;
        }

        btn.disabled = true;

        const h = Math.floor(diff / 3600);
        const m = Math.floor((diff % 3600) / 60);
        const s = diff % 60;

        document.getElementById("pauseCountdown").innerText =
            `${h}h ${m}m ${s}s`;

    }, 1000);
}
    
// ================= Withdraw Init =================
async function initWithdrawSection() {
    try {
        // Default = FPC
        document.getElementById("withdrawTokenSelect").value = "fpc";

        await setWithdrawToken();

        log("Withdraw section initialized (FPC loaded)");

    } catch (err) {
        log("Error initializing withdraw");
    }
}
    
// ================= Set Token =================
async function setWithdrawToken() {
    try {
        const val = document.getElementById("withdrawTokenSelect").value;
        const customInput = document.getElementById("customToken");
        const balEl = document.getElementById("withdrawBalance");
        document.getElementById("withdrawAmount").value = '';

        let selectedAddress;

        // ======================
        // HANDLE UI
        // ======================
        if (val === "custom") {
            customInput.style.display = "block";
            balEl.innerText = "-";
            return;
        } else {
            customInput.style.display = "none";
        }

        // ======================
        // TOKEN ADDRESS
        // ======================
        if (val === "fpc") {
            selectedAddress = tokenAddress;
        } else if (val === "usdt") {
            selectedAddress = usdtAddress;
        }

        // ======================
        // FETCH BALANCE
        // ======================
        const tokenC = new ethers.Contract(selectedAddress, [
            "function balanceOf(address) view returns(uint256)",
            "function decimals() view returns(uint8)"
        ], provider);

        const bal = await tokenC.balanceOf(contractAddress);
        const dec = await tokenC.decimals();

        var formatted = ethers.utils.formatUnits(bal, dec);

        formatted = parseFloat(formatted).toFixed(4);
        balEl.innerText = formatted;

    } catch (err) {
        log("Error loading balance");
    }
}
        
// ================= Custom Token Balance =================
async function loadCustomTokenBalance() {
    try {
        const addr = document.getElementById("customToken").value;

        if (!addr) return;

        const tokenC = new ethers.Contract(addr, [
            "function balanceOf(address) view returns(uint256)",
            "function decimals() view returns(uint8)"
        ], provider);

        const bal = await tokenC.balanceOf(contractAddress);
        const dec = await tokenC.decimals();

        var formatted = ethers.utils.formatUnits(bal, dec);

        formatted = parseFloat(formatted).toFixed(4);
        
        document.getElementById("withdrawBalance").innerText = formatted;

    } catch (err) {
        log("Invalid token address");
    }
}
        
// ================= Set Max =================
function setMaxWithdraw() {
    const bal = document.getElementById("withdrawBalance").innerText;
    document.getElementById("withdrawAmount").value = bal;
}
        
// ================= Withdraw Token =================
async function withdrawTokens() {
    try {
        let tokenAddressSelected;
        const type = document.getElementById("withdrawTokenSelect").value;
        const amount = document.getElementById("withdrawAmount").value;

        if (!amount) {
            log("Enter amount");
            return;
        }

        // ======================
        // TOKEN SELECTION
        // ======================
        if (type === "fpc") {
            tokenAddressSelected = tokenAddress;
        } else if (type === "usdt") {
            tokenAddressSelected = usdtAddress;
        } else {
            tokenAddressSelected = document.getElementById("customToken").value;

            if (!tokenAddressSelected) {
                log("Enter token address");
                return;
            }
        }

        // ======================
        // TOKEN CONTRACT
        // ======================
        const tokenC = new ethers.Contract(tokenAddressSelected, [
            "function decimals() view returns(uint8)",
            "function balanceOf(address) view returns(uint256)"
        ], provider);

        const dec = await tokenC.decimals();

        const parsedAmount = ethers.utils.parseUnits(amount, dec);

        // ======================
        // BALANCE CHECK (UI SAFETY)
        // ======================
        const contractBal = await tokenC.balanceOf(contractAddress);

        if (parsedAmount.gt(contractBal)) {
            log("Amount exceeds contract balance");
            return;
        }

        // ======================
        // EXECUTE WITHDRAW
        // ======================
        const contractW = new ethers.Contract(contractAddress, [
            "function withdraw(address,uint256)"
        ], signer);

        log("Withdrawing...");

        const tx = await contractW.withdraw(tokenAddressSelected, parsedAmount);
        await tx.wait();

        log("Withdraw successful");

        await refreshAll();

    } catch (err) {
        log("Error: " + err.message);
    }
}
    
</script>
