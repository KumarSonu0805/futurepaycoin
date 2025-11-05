<style>
    .login-box{
        height: 100vh;
        display: flex;
        align-items: center;
    }
    .card{
        width: 40%;
        margin: 0 auto;
        /* padding: 20px 40px; */
        box-shadow: 0 0 24px 0 rgba(3, 31, 66, 0.1);
    }
    .pop-up {
        background-color: #6185acee;
        box-shadow: 0 0 20px var(--shadow-color);
        padding: 45px 25px;
        border-radius: 10px;
        position: absolute;
        z-index: 2;
        color: #dcbb1a;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    .pop-up i{
        color: #ddb82f;
    }
    body::before{
        z-index: -1;
    }
    body.pop::before{
        content: "";
        background-color: #00000044;
        position: absolute;
        height: 100%;
        z-index: 1;
        width: 100%;
    }
	@media (max-width: 350px){
        .card,.pop-up { 
            width: 95%;
        }
    }
    @media (min-width: 351px) and (max-width: 425px){
        .card,.pop-up { 
            width: 80%;
        }
    }
    @media (min-width: 426px) and (max-width: 768px) {
        .card,.pop-up { 
            width: 70%;
        }
	}
</style>
            <?php
                if($this->session->flashdata('msg')=='Registered Successfully!'){
            ?>
            <div class="pop-up text-center">
                <p class="text-center"><i class="fa fa-check-circle fa-4x"></i></p>
                <h5>Registered Successfully!</h5>
                <h4>Your ID is <?= $user['username']; ?></h4>
                <h4>Password <?= $user['vp']; ?></h4>
                <a href="<?= base_url('home/') ?>" class="btn btn-warning text-white">Go To Dashboard</a>
            </div>
            <script>
                $(document).ready(function(){
                    $('body').addClass('pop');
                });
            </script>
            <?php
                }
            ?>
      <section class="loginsection">
         <div class="container">
             <?= form_open('login/validatelogin'); ?>
            <div class="login-card">
               <div class="login-logo">
                  <img src="<?= file_url('assets/images/future-coin.png'); ?>" alt="future pay" width="100" />
                  <p>Login To your account</p>
               </div>
               <div class="mb-3">
                  <label for="memberid" class="form-label">Wallet Address</label>
                  <input type="text" class="form-control" id="wallet_address" name="wallet_address" placeholder="Wallet Address" <?= (isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST']=='localhost')?'':'readonly' ?> required/>
               </div>
               <div class="mb-3">
                  <label for="username" class="form-label">Username</label>
                  <input type="text" name="username" placeholder="Username" required/>
               </div>
               <div class="mb-3">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" name="password" placeholder="Password" required/>
               </div>
                <div class="text-danger text-center mb-2"><?= $this->session->flashdata('logerr'); ?></div>
                <div class="mb-3">
                  <div class="futureBtn">
                     <button name="login">Login</button>
                  </div>
               </div>
                <?php
                if($this->uri->segment(1)!='Admin'){
                ?>
               <div class="mb-3 createpassword">
                  <div class="row">
                     <div class="col-lg-6">
                        <a href="<?= base_url('register/'); ?>">Register Now</a>
                     </div>
                     <div class="col-lg-6">
                     </div>
                  </div>
               </div>
                <?php
                }
                ?>
            </div>
             <?= form_close(); ?>
         </div>
      </section>
            <script src="https://cdn.jsdelivr.net/gh/ethereum/web3.js/dist/web3.min.js"></script>
            <script src="<?= file_url('includes/custom/switch.js'); ?>"></script>
            <script>
                        // Import Web3.js
                if (typeof window.ethereum !== 'undefined') {
                    const web3 = new Web3(window.ethereum);
                } else {
                    alert('A Web3 wallet (like MetaMask or Trust Wallet or Token Pocket) is required. Please install or open it.');
                }

                const BEP20_CHAIN_ID = '0x38'; // Mainnet Chain ID for Binance Smart Chain
                const BEP20_RPC_URL = 'https://bsc-dataseed.binance.org/'; // RPC URL for Binance Smart Chain Mainnet
                const BEP20_CHAIN_NAME = 'BNB Smart Chain Mainnet';
                const BEP20_SYMBOL = 'BNB';
                const BEP20_DECIMALS = 18;
                const BEP20_BLOCK_EXPLORER_URL = 'https://bscscan.com';

                async function connectToWallet() {
                    try {
                        // Request accounts from MetaMask
                        const accounts = await window.ethereum.request({ method: 'eth_requestAccounts' });

                        // Check the current chain
                        const currentChainId = await window.ethereum.request({ method: 'eth_chainId' });

                        if (currentChainId !== BEP20_CHAIN_ID) {
                            // Prompt user to switch chain
                            try {
                                await window.ethereum.request({
                                    method: 'wallet_switchEthereumChain',
                                    params: [{ chainId: BEP20_CHAIN_ID }],
                                });
                            } catch (switchError) {
                                // If the chain has not been added to MetaMask, add it
                                if (switchError.code === 4902) {
                                    try {
                                        await window.ethereum.request({
                                            method: 'wallet_addEthereumChain',
                                            params: [
                                                {
                                                    chainId: BEP20_CHAIN_ID,
                                                    chainName: BEP20_CHAIN_NAME,
                                                    rpcUrls: [BEP20_RPC_URL],
                                                    nativeCurrency: {
                                                        name: BEP20_SYMBOL,
                                                        symbol: BEP20_SYMBOL,
                                                        decimals: BEP20_DECIMALS,
                                                    },
                                                    blockExplorerUrls: [BEP20_BLOCK_EXPLORER_URL],
                                                },
                                            ],
                                        });
                                    } catch (addError) {
                                        displayError('Unable to add Binance Smart Chain to your wallet. Please try again.');
                                        //resetButton();
                                        return;
                                    }
                                } else {
                                    displayError('Switching to Binance Smart Chain failed. Please check your wallet settings.');
                                    //resetButton();
                                    return;
                                }
                            }
                        }

                        // Successfully connected to wallet and switched chain
                        const walletAddress = accounts[0];
                        localStorage.setItem('wallet', walletAddress);
                        console.log('Wallet Address:', walletAddress);
                        //alert(`Connected Wallet: ${walletAddress}`);
                        $('#wallet_address').val(walletAddress);
                        $('#savebtn').trigger('click');
                    } catch (error) {
                        if (error.code === 4001) {
                            displayError('Connection request was rejected. Please try again.');
                        } else if (error.code === -32002) {
                            displayError('A connection request is already pending. Please check your wallet.');
                        } else {
                            displayError('An error occurred while connecting to your wallet. Please try again.');
                        }
                    } finally {
                        resetButton();
                    }
                }

                function displayError(message) {
                    console.error(message);
                    alert(message);
                }

                // Add a click event to connect button (if any)
                //document.getElementById('connect-wallet').addEventListener('click', connectToWallet);
                window.onload=function(){
                    connectToWallet();
                }
            </script>
