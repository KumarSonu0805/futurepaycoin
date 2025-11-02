
  <script src="https://cdn.jsdelivr.net/npm/web3@1.10.0/dist/web3.min.js"></script>
  <style>
    h2, h3 { margin-top: 0; }
      
          /* Top Navigation Styles */
    .top-nav {
      background: linear-gradient(90deg, #e6d363, #a87f30);
      padding: 12px 0;
      box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }

    .nav-container {
      max-width: 1100px;
      margin: 0 auto;
      display: flex;
      justify-content: center;
      gap: 25px;
    }

    .nav-link {
      color: #fff;
      text-decoration: none;
      font-weight: 600;
      font-size: 15px;
      padding: 8px 14px;
      border-radius: 6px;
      transition: background 0.3s ease, transform 0.2s ease;
    }

    .nav-link:hover {
      background: rgba(255,255,255,0.15);
      transform: translateY(-2px);
    }

    /* Mobile friendly */
    @media (max-width: 600px) {
      .nav-container {
        flex-direction: column;
        align-items: center;
        gap: 12px;
      }
    }
    .header {
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .token-logo {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: contain;
      border: 1px solid #ccc;
      background: #fff;
    }
    .card {
      background: linear-gradient(145deg, #ffffff, #f6f7fb);
      border-radius: 12px;
      padding: 15px;
      margin-top: 20px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    }
    .section-divider {
      border-top: 1px solid #ddd;
      margin: 20px 0;
    }
    input, button {
      padding: 8px;
      margin-top: 8px;
      width: 100%;
      box-sizing: border-box;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 14px;
    }
    button {
      cursor: pointer;
      font-weight: bold;
      transition: all 0.2s ease-in-out;
    }
    button:hover {
      transform: translateY(-1px);
      box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    .btn-primary { background: #007bff; color: #fff; border: none; }
    .btn-green { background: #28a745; color: #fff; border: none; }
    .btn-orange { background: #fd7e14; color: #fff; border: none; }
    .result-box {
      margin-top: 8px;
      padding: 8px;
      border-radius: 6px;
      font-size: 14px;
      display: none;
      animation: fadeIn 0.3s ease-in-out;
    }
    .result-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    .result-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    .result-info { background: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; }
    #walletAddress { 
        font-weight: bold; clear: both; 
        margin-top: 15px;
        padding: 10px;
        background-color: #4ca229;
        border: 1px solid #80d13c;
        border-radius: 5px;
        font-size: 1rem;
        text-align: center;
        color: #ffffff;
      }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-5px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>
<!-- Top Navigation Menu -->
<nav class="top-nav d-none">
  <div class="nav-container">
    <a href="user-interface.php" class="nav-link">User Panel</a>
    <a href="admin-interface.php" class="nav-link">Admin Panel</a>
    <a href="liquidity-manager.php" class="nav-link">Liquidity Manager</a>
  </div>
</nav>

  <div class="header">
    <button class="btn-primary" onclick="connectWallet()">Connect Wallet</button>
  </div>
    <div id="walletAddress"></div>

  <div id="tokenInfo" class="card" style="display:none;">
    <div style="display:flex;align-items:center;gap:10px;">
      <img id="tokenLogo" class="token-logo" src="" alt="Logo">
      <div>
        <div id="tokenName" style="font-weight:bold;"></div>
        <div id="tokenSymbol" style="font-size:12px;color:#555;"></div>
      </div>
    </div>
    <div id="contractAddress" style="margin-top:10px;font-size:14px;color:#333;"></div>
    <div id="tokenSupply" style="margin-top:10px;font-size:14px;color:#333;"></div>
  </div>

  <div class="card">

    <div class="section">
      <h4>Check Balance</h4>
      <input type="text" id="balanceOfAddress" placeholder="Address to check balance">
      <button class="btn-primary" onclick="checkBalance()">Check Balance</button>
      <div id="balanceResult" class="result-box result-info"></div>
    </div>

    <div class="section-divider"></div>

    <div class="section">
      <h4>Transfer Tokens</h4>
      <input type="text" id="recipient" placeholder="Recipient Address">
      <input type="text" id="transferAmount" placeholder="Amount">
      <button class="btn-green" onclick="transferToken()">Transfer</button>
      <div id="transferResult" class="result-box result-success"></div>
    </div>

    <div class="section-divider"></div>

    <div class="section d-none">
      <h4>Approve Spender</h4>
      <input type="text" id="spender" placeholder="Spender Address">
      <input type="text" id="approveAmount" placeholder="Amount">
      <button class="btn-orange" onclick="approveSpender()">Approve</button>
      <div id="approveResult" class="result-box result-success"></div>
    </div>

    <div class="section-divider"></div>

    <div class="section d-none">
      <h4>Check Allowance</h4>
      <input type="text" id="allowance-owner" placeholder="Owner address" />
      <input type="text" id="allowance-spender" placeholder="Spender address" />
      <button class="btn-primary" onclick="checkAllowance()">Check Allowance</button>
      <div id="allowanceResult" class="result-box result-info"></div>
    </div>
  </div>
<script src="<?= file_url('includes/custom/switch.js'); ?>"></script>
<script>
const TOKEN_ADDRESS = "0xB123C666268edA865cC5361BD1785B91536Cbe4F"; // Replace with your contract address
const TOKEN_ABI = [
	{
		"inputs": [],
		"name": "acceptOwnership",
		"outputs": [],
		"stateMutability": "nonpayable",
		"type": "function"
	},
	{
		"inputs": [
			{
				"internalType": "address",
				"name": "spender",
				"type": "address"
			},
			{
				"internalType": "uint256",
				"name": "value",
				"type": "uint256"
			}
		],
		"name": "approve",
		"outputs": [
			{
				"internalType": "bool",
				"name": "",
				"type": "bool"
			}
		],
		"stateMutability": "nonpayable",
		"type": "function"
	},
	{
		"inputs": [
			{
				"internalType": "string",
				"name": "name_",
				"type": "string"
			},
			{
				"internalType": "string",
				"name": "symbol_",
				"type": "string"
			},
			{
				"internalType": "uint256",
				"name": "initialSupply_",
				"type": "uint256"
			},
			{
				"internalType": "string",
				"name": "metadataHash_",
				"type": "string"
			},
			{
				"internalType": "address",
				"name": "owner_",
				"type": "address"
			}
		],
		"stateMutability": "nonpayable",
		"type": "constructor"
	},
	{
		"inputs": [
			{
				"internalType": "address",
				"name": "spender",
				"type": "address"
			},
			{
				"internalType": "uint256",
				"name": "allowance",
				"type": "uint256"
			},
			{
				"internalType": "uint256",
				"name": "needed",
				"type": "uint256"
			}
		],
		"name": "ERC20InsufficientAllowance",
		"type": "error"
	},
	{
		"inputs": [
			{
				"internalType": "address",
				"name": "sender",
				"type": "address"
			},
			{
				"internalType": "uint256",
				"name": "balance",
				"type": "uint256"
			},
			{
				"internalType": "uint256",
				"name": "needed",
				"type": "uint256"
			}
		],
		"name": "ERC20InsufficientBalance",
		"type": "error"
	},
	{
		"inputs": [
			{
				"internalType": "address",
				"name": "approver",
				"type": "address"
			}
		],
		"name": "ERC20InvalidApprover",
		"type": "error"
	},
	{
		"inputs": [
			{
				"internalType": "address",
				"name": "receiver",
				"type": "address"
			}
		],
		"name": "ERC20InvalidReceiver",
		"type": "error"
	},
	{
		"inputs": [
			{
				"internalType": "address",
				"name": "sender",
				"type": "address"
			}
		],
		"name": "ERC20InvalidSender",
		"type": "error"
	},
	{
		"inputs": [
			{
				"internalType": "address",
				"name": "spender",
				"type": "address"
			}
		],
		"name": "ERC20InvalidSpender",
		"type": "error"
	},
	{
		"inputs": [],
		"name": "EnforcedPause",
		"type": "error"
	},
	{
		"inputs": [],
		"name": "ExpectedPause",
		"type": "error"
	},
	{
		"inputs": [
			{
				"internalType": "address",
				"name": "to",
				"type": "address"
			},
			{
				"internalType": "uint256",
				"name": "amount",
				"type": "uint256"
			}
		],
		"name": "mint",
		"outputs": [],
		"stateMutability": "nonpayable",
		"type": "function"
	},
	{
		"inputs": [
			{
				"internalType": "address",
				"name": "owner",
				"type": "address"
			}
		],
		"name": "OwnableInvalidOwner",
		"type": "error"
	},
	{
		"inputs": [
			{
				"internalType": "address",
				"name": "account",
				"type": "address"
			}
		],
		"name": "OwnableUnauthorizedAccount",
		"type": "error"
	},
	{
		"inputs": [],
		"name": "ReentrancyGuardReentrantCall",
		"type": "error"
	},
	{
		"inputs": [
			{
				"internalType": "address",
				"name": "token",
				"type": "address"
			}
		],
		"name": "SafeERC20FailedOperation",
		"type": "error"
	},
	{
		"anonymous": false,
		"inputs": [
			{
				"indexed": true,
				"internalType": "address",
				"name": "owner",
				"type": "address"
			},
			{
				"indexed": true,
				"internalType": "address",
				"name": "spender",
				"type": "address"
			},
			{
				"indexed": false,
				"internalType": "uint256",
				"name": "value",
				"type": "uint256"
			}
		],
		"name": "Approval",
		"type": "event"
	},
	{
		"anonymous": false,
		"inputs": [
			{
				"indexed": false,
				"internalType": "address",
				"name": "by",
				"type": "address"
			}
		],
		"name": "ContractPaused",
		"type": "event"
	},
	{
		"anonymous": false,
		"inputs": [
			{
				"indexed": false,
				"internalType": "address",
				"name": "by",
				"type": "address"
			}
		],
		"name": "ContractUnpaused",
		"type": "event"
	},
	{
		"anonymous": false,
		"inputs": [
			{
				"indexed": false,
				"internalType": "string",
				"name": "newHash",
				"type": "string"
			}
		],
		"name": "MetadataHashUpdated",
		"type": "event"
	},
	{
		"anonymous": false,
		"inputs": [
			{
				"indexed": true,
				"internalType": "address",
				"name": "previousOwner",
				"type": "address"
			},
			{
				"indexed": true,
				"internalType": "address",
				"name": "newOwner",
				"type": "address"
			}
		],
		"name": "OwnershipTransferStarted",
		"type": "event"
	},
	{
		"anonymous": false,
		"inputs": [
			{
				"indexed": true,
				"internalType": "address",
				"name": "previousOwner",
				"type": "address"
			},
			{
				"indexed": true,
				"internalType": "address",
				"name": "newOwner",
				"type": "address"
			}
		],
		"name": "OwnershipTransferred",
		"type": "event"
	},
	{
		"inputs": [],
		"name": "pause",
		"outputs": [],
		"stateMutability": "nonpayable",
		"type": "function"
	},
	{
		"anonymous": false,
		"inputs": [
			{
				"indexed": false,
				"internalType": "address",
				"name": "account",
				"type": "address"
			}
		],
		"name": "Paused",
		"type": "event"
	},
	{
		"inputs": [
			{
				"internalType": "contract IERC20",
				"name": "token",
				"type": "address"
			},
			{
				"internalType": "uint256",
				"name": "amount",
				"type": "uint256"
			}
		],
		"name": "recoverTokens",
		"outputs": [],
		"stateMutability": "nonpayable",
		"type": "function"
	},
	{
		"inputs": [],
		"name": "renounceOwnership",
		"outputs": [],
		"stateMutability": "nonpayable",
		"type": "function"
	},
	{
		"anonymous": false,
		"inputs": [
			{
				"indexed": false,
				"internalType": "address",
				"name": "token",
				"type": "address"
			},
			{
				"indexed": false,
				"internalType": "uint256",
				"name": "amount",
				"type": "uint256"
			}
		],
		"name": "TokensRecovered",
		"type": "event"
	},
	{
		"inputs": [
			{
				"internalType": "address",
				"name": "to",
				"type": "address"
			},
			{
				"internalType": "uint256",
				"name": "value",
				"type": "uint256"
			}
		],
		"name": "transfer",
		"outputs": [
			{
				"internalType": "bool",
				"name": "",
				"type": "bool"
			}
		],
		"stateMutability": "nonpayable",
		"type": "function"
	},
	{
		"anonymous": false,
		"inputs": [
			{
				"indexed": true,
				"internalType": "address",
				"name": "from",
				"type": "address"
			},
			{
				"indexed": true,
				"internalType": "address",
				"name": "to",
				"type": "address"
			},
			{
				"indexed": false,
				"internalType": "uint256",
				"name": "value",
				"type": "uint256"
			}
		],
		"name": "Transfer",
		"type": "event"
	},
	{
		"inputs": [
			{
				"internalType": "address",
				"name": "from",
				"type": "address"
			},
			{
				"internalType": "address",
				"name": "to",
				"type": "address"
			},
			{
				"internalType": "uint256",
				"name": "value",
				"type": "uint256"
			}
		],
		"name": "transferFrom",
		"outputs": [
			{
				"internalType": "bool",
				"name": "",
				"type": "bool"
			}
		],
		"stateMutability": "nonpayable",
		"type": "function"
	},
	{
		"inputs": [
			{
				"internalType": "address",
				"name": "newOwner",
				"type": "address"
			}
		],
		"name": "transferOwnership",
		"outputs": [],
		"stateMutability": "nonpayable",
		"type": "function"
	},
	{
		"inputs": [],
		"name": "unpause",
		"outputs": [],
		"stateMutability": "nonpayable",
		"type": "function"
	},
	{
		"anonymous": false,
		"inputs": [
			{
				"indexed": false,
				"internalType": "address",
				"name": "account",
				"type": "address"
			}
		],
		"name": "Unpaused",
		"type": "event"
	},
	{
		"inputs": [
			{
				"internalType": "address",
				"name": "owner",
				"type": "address"
			},
			{
				"internalType": "address",
				"name": "spender",
				"type": "address"
			}
		],
		"name": "allowance",
		"outputs": [
			{
				"internalType": "uint256",
				"name": "",
				"type": "uint256"
			}
		],
		"stateMutability": "view",
		"type": "function"
	},
	{
		"inputs": [
			{
				"internalType": "address",
				"name": "account",
				"type": "address"
			}
		],
		"name": "balanceOf",
		"outputs": [
			{
				"internalType": "uint256",
				"name": "",
				"type": "uint256"
			}
		],
		"stateMutability": "view",
		"type": "function"
	},
	{
		"inputs": [],
		"name": "decimals",
		"outputs": [
			{
				"internalType": "uint8",
				"name": "",
				"type": "uint8"
			}
		],
		"stateMutability": "view",
		"type": "function"
	},
	{
		"inputs": [],
		"name": "metadataHash",
		"outputs": [
			{
				"internalType": "string",
				"name": "",
				"type": "string"
			}
		],
		"stateMutability": "view",
		"type": "function"
	},
	{
		"inputs": [],
		"name": "name",
		"outputs": [
			{
				"internalType": "string",
				"name": "",
				"type": "string"
			}
		],
		"stateMutability": "view",
		"type": "function"
	},
	{
		"inputs": [],
		"name": "owner",
		"outputs": [
			{
				"internalType": "address",
				"name": "",
				"type": "address"
			}
		],
		"stateMutability": "view",
		"type": "function"
	},
	{
		"inputs": [],
		"name": "paused",
		"outputs": [
			{
				"internalType": "bool",
				"name": "",
				"type": "bool"
			}
		],
		"stateMutability": "view",
		"type": "function"
	},
	{
		"inputs": [],
		"name": "pendingOwner",
		"outputs": [
			{
				"internalType": "address",
				"name": "",
				"type": "address"
			}
		],
		"stateMutability": "view",
		"type": "function"
	},
	{
		"inputs": [],
		"name": "symbol",
		"outputs": [
			{
				"internalType": "string",
				"name": "",
				"type": "string"
			}
		],
		"stateMutability": "view",
		"type": "function"
	},
	{
		"inputs": [],
		"name": "totalSupply",
		"outputs": [
			{
				"internalType": "uint256",
				"name": "",
				"type": "uint256"
			}
		],
		"stateMutability": "view",
		"type": "function"
	}
]; // Replace with your ABI

let web3;
let userAccount;
let tokenContract;

async function connectWallet() {
  if (!window.ethereum) { return alert("MetaMask not detected."); }
  const switched = await switchToBSC();
  if (!switched) { showError("Failed to switch to BSC."); return; }
  web3 = new Web3(window.ethereum);
  await window.ethereum.request({ method: 'eth_requestAccounts' });
  const accounts = await web3.eth.getAccounts();
  userAccount = accounts[0];
  tokenContract = new web3.eth.Contract(TOKEN_ABI, TOKEN_ADDRESS);
  document.getElementById("walletAddress").innerText = `Connected: ${userAccount}`;
  document.getElementById("balanceOfAddress").value = userAccount;
  loadTokenInfo();
}

async function loadTokenInfo() {
  try {
    const name = await tokenContract.methods.name().call();
    const symbol = await tokenContract.methods.symbol().call();
    const decimals = await tokenContract.methods.decimals().call();
    const supply = await tokenContract.methods.totalSupply().call();
    var metadataHash = await tokenContract.methods.metadataHash().call();
    metadataHash = metadataHash.replace('ipfs://','');

    document.getElementById("tokenName").innerText = name;
    document.getElementById("tokenSymbol").innerText = symbol;
    document.getElementById("contractAddress").innerText = 'Contract Address: '+TOKEN_ADDRESS;
    document.getElementById("tokenSupply").innerText =
      `Total Supply: ${web3.utils.fromWei(supply, 'ether')} (${decimals} decimals)`;

    // Fetch IPFS JSON and display logo
    const metadataUrl = `https://ipfs.io/ipfs/${metadataHash}`;
    const res = await fetch(metadataUrl);
    const data = await res.json();
    if (data.image) {
      document.getElementById("tokenLogo").src = data.image.replace("ipfs://", "https://ipfs.io/ipfs/");
    }

    document.getElementById("tokenInfo").style.display = "block";
  } catch (err) {
    console.error(err);
  }
}

function showSectionResult(id, type, msg) {
  const el = document.getElementById(id);
  el.className = `result-box result-${type}`;
  el.innerHTML = `${type === "success" ? "✅" : type === "error" ? "❌" : "ℹ️"} ${msg}`;
  el.style.display = "block";
}

async function checkBalance() {
  try {
    const addr = document.getElementById("balanceOfAddress").value;
    const balance = await tokenContract.methods.balanceOf(addr).call();
    showSectionResult("balanceResult", "info", `Balance: ${web3.utils.fromWei(balance, 'ether')}`);
  } catch (err) { showSectionResult("balanceResult", "error", err.message); }
}

async function transferToken() {
  try {
    const to = document.getElementById("recipient").value;
    const amt = web3.utils.toWei(document.getElementById("transferAmount").value);
    await tokenContract.methods.transfer(to, amt).send({ from: userAccount });
    showSectionResult("transferResult", "success", "Transfer successful");
  } catch (err) { showSectionResult("transferResult", "error", err.message); }
}

async function approveSpender() {
  try {
    const spender = document.getElementById("spender").value;
    const amt = web3.utils.toWei(document.getElementById("approveAmount").value);
    await tokenContract.methods.approve(spender, amt).send({ from: userAccount });
    showSectionResult("approveResult", "success", "Approval successful");
  } catch (err) { showSectionResult("approveResult", "error", err.message); }
}

async function checkAllowance() {
  try {
    const owner = document.getElementById("allowance-owner").value;
    const spender = document.getElementById("allowance-spender").value;
    const allowance = await tokenContract.methods.allowance(owner, spender).call();
    showSectionResult("allowanceResult", "info", `Allowance: ${web3.utils.fromWei(allowance, 'ether')}`);
  } catch (err) { showSectionResult("allowanceResult", "error", err.message); }
}
</script>