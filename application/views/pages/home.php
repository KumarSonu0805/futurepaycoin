<style>
    .card{
    }
    .img-circle{
        border-radius: 50%;
        height: 150px;
        width: 150px;
    }
    .list-group{
        border: 0;
    }
    .list-group-item{
        border-radius: 0 !important;
    }
    .list-group-item b{
        font-weight: 400;
        font-size: 12px;
        width: 30%;
        display: block;
        float: left;
    }
    .list-group-item a{
        text-decoration: none;
        color: #000;
        font-size: 14px;
    }
    .referral-link{
      background-color: #82caf1;
      font-size: 14px;
      padding: 5px 5px;
      border-radius: 5px;
    }
</style>
<?php
if($this->session->role=='admin'){
?>
            <div class="main-deshboard-section">
               <div class="status-cardsection">
                  <div class="row">
                     <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="status-card">
                           <ul>
                              <li>
                                 <div class="status-icon">
                                    <svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                                       <path d="M34.0396 20.974C36.6552 20.6065 38.6689 18.364 38.6746 15.6471C38.6746 12.9696 36.7227 10.7496 34.1633 10.3296" stroke="#FF5E5E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                       <path d="M37.4912 27.262C40.0243 27.6407 41.7925 28.5276 41.7925 30.3557C41.7925 31.6139 40.96 32.4314 39.6137 32.9451" stroke="#FF5E5E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                       <path fill-rule="evenodd" clip-rule="evenodd" d="M22.7879 28.0373C16.7616 28.0373 11.6147 28.9504 11.6147 32.5973C11.6147 36.2423 16.7297 37.1817 22.7879 37.1817C28.8141 37.1817 33.9591 36.2779 33.9591 32.6292C33.9591 28.9804 28.846 28.0373 22.7879 28.0373Z" stroke="#FF5E5E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                       <path fill-rule="evenodd" clip-rule="evenodd" d="M22.7876 22.8325C26.742 22.8325 29.9483 19.6281 29.9483 15.6719C29.9483 11.7175 26.742 8.51123 22.7876 8.51123C18.8333 8.51123 15.627 11.7175 15.627 15.6719C15.612 19.6131 18.7939 22.8194 22.7351 22.8325H22.7876Z" stroke="#FF5E5E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                       <path d="M11.5344 20.974C8.91691 20.6065 6.90504 18.364 6.89941 15.6471C6.89941 12.9696 8.85129 10.7496 11.4107 10.3296" stroke="#FF5E5E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                       <path d="M8.0825 27.262C5.54937 27.6407 3.78125 28.5276 3.78125 30.3557C3.78125 31.6139 4.61375 32.4314 5.96 32.9451" stroke="#FF5E5E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                 </div>
                              </li>
                              <li>
                                 <h4><?= countdownline(); ?></h4>
                                 <p>Total Team</p>
                              </li>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
               
            </div>

<?php
}
else{
?>
            <div class="main-deshboard-section">
               <div class="status-cardsection">
                  <div class="row">
                     <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="status-card">
                           <ul>
                              <li>
                                 <div class="status-icon">
                                    <svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                                       <path fill-rule="evenodd" clip-rule="evenodd" d="M22.9715 29.3168C15.7197 29.3168 9.52686 30.4132 9.52686 34.8043C9.52686 39.1953 15.6804 40.331 22.9715 40.331C30.2233 40.331 36.4144 39.2328 36.4144 34.8435C36.4144 30.4543 30.2626 29.3168 22.9715 29.3168Z" stroke="#3AC977" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                       <path fill-rule="evenodd" clip-rule="evenodd" d="M22.9714 23.0537C27.7304 23.0537 31.5875 19.1948 31.5875 14.4359C31.5875 9.67694 27.7304 5.81979 22.9714 5.81979C18.2125 5.81979 14.3536 9.67694 14.3536 14.4359C14.3375 19.1787 18.1696 23.0377 22.9107 23.0537H22.9714Z" stroke="#3AC977" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                 </div>
                              </li>
                              <li>
                                 <h4><?= countdirects(); ?></h4>
                                 <p>My Referrals</p>
                              </li>
                           </ul>
                        </div>
                     </div>
                     <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="status-card">
                           <ul>
                              <li>
                                 <div class="status-icon">
                                    <svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                                       <path d="M34.0396 20.974C36.6552 20.6065 38.6689 18.364 38.6746 15.6471C38.6746 12.9696 36.7227 10.7496 34.1633 10.3296" stroke="#FF5E5E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                       <path d="M37.4912 27.262C40.0243 27.6407 41.7925 28.5276 41.7925 30.3557C41.7925 31.6139 40.96 32.4314 39.6137 32.9451" stroke="#FF5E5E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                       <path fill-rule="evenodd" clip-rule="evenodd" d="M22.7879 28.0373C16.7616 28.0373 11.6147 28.9504 11.6147 32.5973C11.6147 36.2423 16.7297 37.1817 22.7879 37.1817C28.8141 37.1817 33.9591 36.2779 33.9591 32.6292C33.9591 28.9804 28.846 28.0373 22.7879 28.0373Z" stroke="#FF5E5E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                       <path fill-rule="evenodd" clip-rule="evenodd" d="M22.7876 22.8325C26.742 22.8325 29.9483 19.6281 29.9483 15.6719C29.9483 11.7175 26.742 8.51123 22.7876 8.51123C18.8333 8.51123 15.627 11.7175 15.627 15.6719C15.612 19.6131 18.7939 22.8194 22.7351 22.8325H22.7876Z" stroke="#FF5E5E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                       <path d="M11.5344 20.974C8.91691 20.6065 6.90504 18.364 6.89941 15.6471C6.89941 12.9696 8.85129 10.7496 11.4107 10.3296" stroke="#FF5E5E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                       <path d="M8.0825 27.262C5.54937 27.6407 3.78125 28.5276 3.78125 30.3557C3.78125 31.6139 4.61375 32.4314 5.96 32.9451" stroke="#FF5E5E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                 </div>
                              </li>
                              <li>
                                 <h4><?= countteam(); ?></h4>
                                 <p>Total Team</p>
                              </li>
                           </ul>
                        </div>
                     </div>
                     <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="status-card">
                           <ul>
                              <li>
                                 <div class="status-icon currentstatus">
                                    <svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                                       <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M22.9717 41.0539C22.9717 41.0539 37.3567 36.6983 37.3567 24.6908C37.3567 12.6814 37.878 11.7439 36.723 10.5889C35.5699 9.43391 24.858 5.69891 22.9717 5.69891C21.0855 5.69891 10.3736 9.43391 9.21863 10.5889C8.0655 11.7439 8.58675 12.6814 8.58675 24.6908C8.58675 36.6983 22.9717 41.0539 22.9717 41.0539Z"
                                          stroke="#2196f3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                       <path d="M26.4945 26.4642L19.4482 19.4179"
                                          stroke="#2196f3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                       <path d="M19.4487 26.4642L26.495 19.4179"
                                          stroke="#2196f3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                 </div>
                              </li>
                              <li>
                                 <h4><?= $member['status']==1?'Active':'In-Active' ?></h4>
                                 <p>Current Status</p>
                              </li>
                           </ul>
                        </div>
                     </div>
                     <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="status-card">
                           <ul>
                              <li>
                                 <div class="status-icon basic">
                                    <svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                                       <path fill-rule="evenodd" clip-rule="evenodd" d="M32.8961 26.5849C34.1612 26.5849 35.223 27.629 35.0296 28.8783C33.8947 36.2283 27.6026 41.6855 20.0138 41.6855C11.6178 41.6855 4.8125 34.8803 4.8125 26.4862C4.8125 19.5704 10.0664 13.1283 15.9816 11.6717C17.2526 11.3579 18.5553 12.252 18.5553 13.5605C18.5553 22.4263 18.8533 24.7197 20.5368 25.9671C22.2204 27.2145 24.2 26.5849 32.8961 26.5849Z" stroke="var(--accent-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                       <path fill-rule="evenodd" clip-rule="evenodd" d="M41.1733 19.2019C41.2739 13.5059 34.2772 4.32428 25.7509 4.48217C25.0877 4.49402 24.5568 5.04665 24.5272 5.70783C24.3121 10.3914 24.6022 16.4605 24.764 19.2118C24.8134 20.0684 25.4864 20.7414 26.341 20.7907C29.1693 20.9526 35.4594 21.1736 40.0759 20.4749C40.7035 20.3802 41.1634 19.8355 41.1733 19.2019Z" stroke="var(--accent-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                 </div>
                              </li>
                              <li>
                                 <h4>--</h4>
                                 <p>Current Rank</p>
                              </li>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
               
               <div class="Congratulations-section">
                  <div class="row">
                     <div class="col-lg-4 col-md-4 col-sm-6">
                           <div class="card card-primary card-outline">
                              <div class="card-body box-profile">
                                 <div class="text-center">
                                       <img class="profile-user-img img-fluid img-circle bg-info" src="<?php echo ($user['photo']); ?>" alt="<?= $user['name']; ?> photo">
                                 </div>

                                 <h5 class="profile-username text-center"><?= $user['username']; ?></h5>

                                 <ul class="list-group list-group-unbordered mb-3">
                                       <li class="list-group-item">
                                          <b>Name</b> <a class="float-right"><?= $user['name']; ?></a>
                                       </li>
                                       <li class="list-group-item">
                                          <b>Wallet Addres</b> <a class="float-right"><?= $member['wallet_address']; ?></a>
                                       </li>
                                       <li class="list-group-item">
                                          <b>Joining</b> <a class="float-right"><?= date('d-m-Y',strtotime($member['date'])) ?></a>
                                       </li>
                                       <li class="list-group-item">
                                          <b>Activation</b> <a class="float-right"><?= !empty($member['activation_date'])?date('d-m-Y',strtotime($member['activation_date'])):'--' ?></a>
                                       </li>
                                       <li class="list-group-item">
                                          <b>Status</b> <a class="float-right text-<?= $member['status']==1?'success':'danger' ?>"><strong><?= $member['status']==1?'Active':'In-Active' ?></strong></a>
                                       </li>
                                 </ul>
                                 <div class="row">
                                       <div class="col-md-12">
                                          <h5 class="">Referral Link</h5>
                                          <div class="lead my-2 referral-link" id="copyLink">
                                             <?= base_url('register/?sponsor='.$user['username']); ?>
                                          </div>
                                          <a href="<?= base_url('register/?sponsor='.$user['username']); ?>" class="btn btn-sm btn-info text-white" target="_blank">Open Link</a>
                                          <button onclick="copyLink()" class="btn btn-sm btn-success">Copy Link</button>
                                       </div>
                                 </div>
                              </div>
                              <!-- /.card-body -->
                           </div>
                     </div>
                     <div class="col-lg-8 col-md-8 col-sm-6">
                        <div class="row">
                           <div class="col-md-4">
                              <div class="wallet-card">
                                 <ul>
                                    <li class="wallet-icon">
                                       <i class="fa-solid fa-wallet"></i>
                                    </li>
                                    <li>
                                       <h5>Fund Wallet</h5>
                                       <h2>
                                          $ <?= getdeposits(); ?>
                                       </h2>
                                       <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                          <div class="progress-bar w-75"></div>
                                       </div>
                                       <p>Total Balance in Fund wallet</p>
                                    </li>
                                 </ul>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="wallet-card">
                                 <ul>
                                    <li class="wallet-icon">
                                       <i class="fa-solid fa-wallet"></i>
                                    </li>
                                    <li>
                                       <h5>Income Wallet</h5>
                                       <h2>
                                          $ 0
                                       </h2>
                                       <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                          <div class="progress-bar w-75"></div>
                                       </div>
                                       <p>Total Balance in Income wallet</p>
                                    </li>
                                 </ul>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="wallet-card">
                                 <ul>
                                    <li class="wallet-icon">
                                       <i class="fa-solid fa-wallet"></i>
                                    </li>
                                    <li>
                                       <h5>Coin Wallet</h5>
                                       <h2>
                                          0 Coin
                                       </h2>
                                       <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                          <div class="progress-bar w-75"></div>
                                       </div>
                                       <p>Total Balance in Coin wallet</p>
                                    </li>
                                 </ul>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row d-none ">
                     <div class="col-lg-6 col-md-6">
                        <div class="Congratulations-card">
                           <div class="row d-flex text-align-center">
                              <div class="col-8 d-flex text-align-center">
                                 <div class="cong-content">
                                    <h5>Congratulations RB123456 !!</h5>
                                    <h3>You are ready for</h3>
                                    <h3>Robo9 Investment</h3>
                                    <a href="#">Member Investment</a>
                                 </div>
                              </div>
                              <div class="col-4">
                                 <div class="cong-img">
                                    <img src="./images/future-coin.png" alt="developer_male">
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-lg-6 col-md-6">
                        <div class="Congratulations-card congRight">
                           <h2>Congratulations</h2>
                           <h5>SBG1</h5>
                           <h5>UID : RB123456</h5>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="staking-section d-none">
                  <div class="row">
                     <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="staking-card">
                           <div class="stakingicon">
                              <img src="./images/future-coin.png" alt="future-coin" width="24px">
                           </div>
                           <h5>Staking</h5>
                           <span>@staking</span>
                           <h2>
                              $ 4000.00
                           </h2>
                        </div>
                     </div>
                     <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="staking-card">
                           <div class="stakingicon">

                              <img src="./images/future-coin.png" alt="future-coin" width="24px">
                           </div>
                           <h5>Staking</h5>
                           <span>@staking</span>
                           <h2>
                              $ 1000.00
                           </h2>
                        </div>
                     </div>
                     <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="staking-card">
                           <div class="stakingicon">
                              <img src="./images/future-coin.png" alt="future-coin" width="24px">
                           </div>
                           <h5>Staking</h5>
                           <span>@staking</span>
                           <h2>
                              $ 2000.00
                           </h2>
                        </div>
                     </div>
                     <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="staking-card">
                           <div class="stakingicon">
                              <img src="./images/future-coin.png" alt="future-coin" width="24px">
                           </div>
                           <h5>Staking</h5>
                           <span>@staking</span>
                           <h2>
                              $ 5000.00
                           </h2>
                        </div>
                     </div>
                  </div>
               </div>
               
            </div>

<?php
}
?>
                <script>
                    function copyLink() {
                      // Select the link text
                      const linkElement = document.getElementById('copyLink');
                      const linkText = linkElement.textContent || linkElement.innerText;

                      // Use navigator.clipboard.writeText for modern browsers
                      navigator.clipboard.writeText(linkText)
                        .then(() => {
                          alert('Referral Link copied!');
                        })
                        .catch((err) => {
                          console.error('Unable to copy link', err);
                        });
                    }
                </script>