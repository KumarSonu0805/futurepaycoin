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
    $b=false;
    if($member['status']==1){
        $activation=date('Y-m-d H:i:s',strtotime($member['activation_date'].' '.$member['activation_time']));
        $expiry=date('Y-m-d H:i:s',strtotime($activation.' +7 days 6 hours'));
        $atime=strtotime($activation);
        $etime=strtotime($expiry);
        $rem=$etime-time();
        $b=true;
    }
?>
<div class="main-deshboard-section">
   <div class="status-cardsection">
       <?php if($b){ ?> 
    <!-- start -->
   <div class="booster-timer d-flex justify-content-between align-items-center">
         <div class="booster-label">
            <h5 class="mb-0 fw-bold">Booster Timer</h5>
         </div>
         <div class="booster-status text-end">
            <div class="booster-status text-end">
            <div class="timer-box d-flex justify-content-end gap-2" id="timer">
         <div class="time-item"><span id="days">07</span><small>Days</small></div>
         <div class="time-item"><span id="hours">00</span><small>Hrs</small></div>
         <div class="time-item"><span id="minutes">00</span><small>Min</small></div>
         <div class="time-item"><span id="seconds">00</span><small>Sec</small></div>
               </div>
               <button class="btn btn-active d-none" id="activeBtn">Active</button>
            </div>
         </div>
   </div>
    <!-- end -->
       <?php } ?>
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
         <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="dash-user-profile">
               <div class="dash-profile-bg">
                  <img src="<?php echo ($user['photo']); ?>" alt="<?php echo ($user['photo']); ?>">
                  <h2><?php echo ($user['username']); ?></h2>
                  <?= $member['status']==1?'<p class="textActive">Active</p>':'<p class="text-danger">In-Active</p>' ?>
                  <div class="row">
                     <div class="col-md-12">
                        <h5>Referral Link</h5>
                        <div class="input-group my-2 referral-link">
                            <div class="d-none" id="copyLink">
                               <?= base_url('register/?sponsor='.$user['username']); ?>
                            </div>
                           <input type="text" class="form-control text-truncate" id="referralInput" 
                              value="<?= base_url('register/?sponsor='.$user['username']); ?>" readonly>
                           <button class="btn addonBtn" type="button" onclick="copyLink()">
                           <i class="fa fa-clipboard"></i> Copy
                           </button>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="table-responsive dashbord-table">
                  <table class="table table-striped-columns table-bordered">
                     <tbody>
                        <tr>
                           <td>Name</td>
                           <td class="left-record"><?= $user['name']; ?></td>
                        </tr>
                        <tr>
                           <td>Wallet Address</td>
                           <td class="left-record"><?= $member['wallet_address']; ?></td>
                        </tr>
                        <tr>
                           <td>Joining</td>
                           <td class="left-record"><?= date('d-m-Y',strtotime($member['date'])) ?></td>
                        </tr>
                        <tr>
                           <td>Activation</td>
                           <td class="left-record"><?= !empty($member['activation_date'])?date('d-m-Y',strtotime($member['activation_date'])):'--' ?></td>
                        </tr>
                        <?php /*?><tr>
                           <td>Direct Team</td>
                           <td class="left-record">Alt 0 <span>Active: </span> 0</td>
                        </tr>
                        <tr>
                           <td>Direct Bussiness</td>
                           <td class="left-record">$0</td>
                        </tr>
                        <tr>
                           <td>All Team</td>
                           <td class="left-record">Alt 0 <span>Active: </span>0</td>
                        </tr>
                        <tr>
                           <td>All Bussiness</td>
                           <td class="left-record">$0</td>
                        </tr><?php */?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
          <?php
            $incomes=getincome();
          ?>
         <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="staking-section">
               <div class="row">
                  <div class="col-lg-4 col-md-6 col-sm-6">
                     <div class="staking-card">
                        <div class="stakingicon">
                           <img src="<?= file_url('assets/images/future-coin.png'); ?>" alt="future-coin" width="24px">
                        </div>
                        <h5>Staking Reward</h5>
                        <h2>
                           $ <?= $this->amount->toDecimal($incomes['roiincome'],true,5); ?>
                        </h2>
                     </div>
                  </div>
                  <div class="col-lg-4 col-md-6 col-sm-6">
                     <div class="staking-card">
                        <div class="stakingicon">
                           <img src="<?= file_url('assets/images/future-coin.png'); ?>" alt="future-coin" width="24px">
                        </div>
                        <h5>Level Income</h5>
                        <h2>
                           $ <?= $this->amount->toDecimal($incomes['level'],true,5); ?>
                        </h2>
                     </div>
                  </div>
                  <div class="col-lg-4 col-md-6 col-sm-6">
                     <div class="staking-card">
                        <div class="stakingicon">
                           <img src="<?= file_url('assets/images/future-coin.png'); ?>" alt="future-coin" width="24px">
                        </div>
                        <h5>Matching Bonus</h5>
                        <h2>
                           $ <?= $this->amount->toDecimal($incomes['matching'],true,5); ?>
                        </h2>
                     </div>
                  </div>
                  <div class="col-lg-4 col-md-6 col-sm-6">
                     <div class="staking-card">
                        <div class="stakingicon">
                           <img src="<?= file_url('assets/images/future-coin.png'); ?>" alt="future-coin" width="24px">
                        </div>
                        <h5>Smart Achievement Bonus</h5>
                        <h2>
                           $ <?= $this->amount->toDecimal($incomes['achievement'],true,5); ?>
                        </h2>
                     </div>
                  </div>
                  <div class="col-lg-4 col-md-6 col-sm-6">
                     <div class="staking-card">
                        <div class="stakingicon">
                           <img src="<?= file_url('assets/images/future-coin.png'); ?>" alt="future-coin" width="24px">
                        </div>
                        <h5>Wheel Bonus</h5>
                        <h2>
                           $ <?= $this->amount->toDecimal($incomes['wheel'],true,5); ?>
                        </h2>
                     </div>
                  </div>
                  <div class="col-lg-4 col-md-6 col-sm-6">
                     <div class="staking-card">
                        <div class="stakingicon">
                           <img src="<?= file_url('assets/images/future-coin.png'); ?>" alt="future-coin" width="24px">
                        </div>
                        <h5>Rank & Rewards</h5>
                        <h2>
                           $ <?= $this->amount->toDecimal($incomes['reward'],true,5); ?>
                        </h2>
                     </div>
                  </div>
                   <?php
                        $legs=$this->income->get_leg_business($user['id']);
                        $power=!empty($legs[0]['business'])?$legs[0]['business']:0;
                        $weaker=!empty($legs[1]['business'])?$legs[1]['business']:0;
                    ?>
                  <div class="col-lg-6 col-md-6 col-sm-6">
                     <div class="staking-card">
                        <div class="stakingicon">
                           <img src="<?= file_url('assets/images/future-coin.png'); ?>" alt="future-coin" width="24px">
                        </div>
                        <h5>Power Leg</h5>
                        <h2>
                           $ <?= $this->amount->toDecimal($power,true,5); ?>
                        </h2>
                     </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6">
                     <div class="staking-card">
                        <div class="stakingicon">
                           <img src="<?= file_url('assets/images/future-coin.png'); ?>" alt="future-coin" width="24px">
                        </div>
                        <h5>Weaker Leg</h5>
                        <h2>
                           $ <?= $this->amount->toDecimal($weaker,true,5); ?>
                        </h2>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-lg-3 col-md-6">
            <div class="wallet-card">
               <ul>
                  <li class="wallet-icon">
                     <i class="fa-solid fa-wallet"></i>
                  </li>
                  <li>
                     <h5>Total Investment</h5>
                     <h2>
                        $ <?= getdeposits(); ?>
                     </h2>
                     <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar w-75"></div>
                     </div>
                  </li>
               </ul>
            </div>
         </div>
         <div class="col-lg-3 col-md-6">
            <div class="wallet-card">
               <ul>
                  <li class="wallet-icon">
                     <i class="fa-solid fa-wallet"></i>
                  </li>
                  <li>
                     <h5>Total Income</h5>
                     <h2>
                        $ <?= $this->amount->toDecimal($incomes['total'],true,5); ?>
                     </h2>
                     <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar w-75"></div>
                     </div>
                  </li>
               </ul>
            </div>
         </div>
         <div class="col-lg-3 col-md-6">
            <div class="wallet-card">
               <ul>
                  <li class="wallet-icon">
                     <i class="fa-solid fa-wallet"></i>
                  </li>
                  <li>
                     <h5>Total Withdrawal</h5>
                     <h2>
                        $ <?= $this->amount->toDecimal($incomes['withdrawal'],true,5); ?>
                     </h2>
                     <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar w-75"></div>
                     </div>
                  </li>
               </ul>
            </div>
         </div>
         <div class="col-lg-3 col-md-6">
            <div class="wallet-card">
               <ul>
                  <li class="wallet-icon">
                     <i class="fa-solid fa-wallet"></i>
                  </li>
                  <li>
                     <h5>Wallet Balance</h5>
                     <h2>
                        $ <?= $this->amount->toDecimal($incomes['wallet_balance'],true,5); ?>
                     </h2>
                     <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar w-75"></div>
                     </div>
                  </li>
               </ul>
            </div>
         </div>
      </div>
   </div>
   <div class="dashboard-datatable d-none">
      <div class="row">
         <div class="col-lg-6">
            <div class="datatable-card">
               <h2>Club Reward</h2>
               <div class="table-responsive">
                  <table class="table table-striped table-hover align-middle fundHistory">
                     <thead>
                        <tr>
                           <th>#</th>
                           <th>Power Business</th>
                           <th>Rest Business</th>
                           <th>Reward</th>
                           <th>Status</th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr>
                           <td><img src="<?= file_url('assets/images/future-coin.png'); ?>" alt="logo" width="24px"></td>
                           <td>$10,000</td>
                           <td>$1000</td>
                           <td class="text-success">Maruti Alto</td>
                           <td><span class="badge-cancelled">Pending</span></td>
                        </tr>
                        <tr>
                           <td><img src="<?= file_url('assets/images/future-coin.png'); ?>" alt="logo" width="24px"></td>
                           <td>$12,000</td>
                           <td>$1,500</td>
                           <td class="text-success">Royal Enfield</td>
                           <td><span class="badge-success">Approved</span></td>
                        </tr>
                        <tr>
                           <td><img src="<?= file_url('assets/images/future-coin.png'); ?>" alt="logo" width="24px"></td>
                           <td>$15,000</td>
                           <td>$2,000</td>
                           <td class="text-success">Laptop</td>
                           <td><span class="badge-cancelled">Pending</span></td>
                        </tr>
                        <tr>
                           <td><img src="<?= file_url('assets/images/future-coin.png'); ?>" alt="logo" width="24px"></td>
                           <td>$18,000</td>
                           <td>$3,000</td>
                           <td class="text-success">iPhone</td>
                           <td><span class="badge-success">Approved</span></td>
                        </tr>
                        <tr>
                           <td><img src="<?= file_url('assets/images/future-coin.png'); ?>" alt="logo" width="24px"></td>
                           <td>$20,000</td>
                           <td>$5,000</td>
                           <td class="text-success">Scooter</td>
                           <td><span class="badge-warning">InProgress</span></td>
                        </tr>
                        <tr>
                           <td><img src="<?= file_url('assets/images/future-coin.png'); ?>" alt="logo" width="24px"></td>
                           <td>$22,000</td>
                           <td>$7,000</td>
                           <td class="text-success">Smartwatch</td>
                           <td><span class="badge-success">Approved</span></td>
                        </tr>
                        <tr>
                           <td><img src="<?= file_url('assets/images/future-coin.png'); ?>" alt="logo" width="24px"></td>
                           <td>$25,000</td>
                           <td>$8,000</td>
                           <td class="text-success">TV</td>
                           <td><span class="badge-cancelled">Pending</span></td>
                        </tr>
                        <tr>
                           <td><img src="<?= file_url('assets/images/future-coin.png'); ?>" alt="logo" width="24px"></td>
                           <td>$28,000</td>
                           <td>$9,000</td>
                           <td class="text-success">Refrigerator</td>
                           <td><span class="badge-success">Approved</span></td>
                        </tr>
                        <tr>
                           <td><img src="<?= file_url('assets/images/future-coin.png'); ?>" alt="logo" width="24px"></td>
                           <td>$30,000</td>
                           <td>$10,000</td>
                           <td class="text-success">Air Conditioner</td>
                           <td><span class="badge-warning">InProgress</span></td>
                        </tr>
                        <tr>
                           <td><img src="<?= file_url('assets/images/future-coin.png'); ?>" alt="logo" width="24px"></td>
                           <td>$32,000</td>
                           <td>$11,000</td>
                           <td class="text-success">Bike</td>
                           <td><span class="badge-success">Approved</span></td>
                        </tr>
                        <tr>
                           <td><img src="<?= file_url('assets/images/future-coin.png'); ?>" alt="logo" width="24px"></td>
                           <td>$35,000</td>
                           <td>$12,000</td>
                           <td class="text-success">Car</td>
                           <td><span class="badge-cancelled">Pending</span></td>
                        </tr>
                        <tr>
                           <td><img src="<?= file_url('assets/images/future-coin.png'); ?>" alt="logo" width="24px"></td>
                           <td>$40,000</td>
                           <td>$15,000</td>
                           <td class="text-success">Trip to Dubai</td>
                           <td><span class="badge-success">Approved</span></td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
         <div class="col-lg-6">
            <div class="datatable-card">
               <h2>Ranks</h2>
               <div class="table-responsive">
                  <table class="table table-striped table-hover align-middle fundHistory">
                     <thead>
                        <tr>
                           <th>#</th>
                           <th>Power Business</th>
                           <th>Rest Business</th>
                           <th>Reward</th>
                           <th>Status</th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr>
                           <td><img src="<?= file_url('assets/images/avatar.jpg'); ?>" alt="logo" width="30px"><span>Avatar</span>
                           </td>
                           <td>$10,000</td>
                           <td>$1000</td>
                           <td class="text-success">Maruti Alto</td>
                           <td><span class="badge-cancelled">Pending</span></td>
                        </tr>
                        <tr>
                           <td><img src="<?= file_url('assets/images/avatar.jpg'); ?>" alt="logo" width="30px">
                              <span>Avatar</span>
                           </td>
                           <td>$12,000</td>
                           <td>$1,500</td>
                           <td class="text-success">Royal Enfield</td>
                           <td><span class="badge-success">Approved</span></td>
                        </tr>
                        <tr>
                           <td><img src="<?= file_url('assets/images/avatar.jpg'); ?>" alt="logo" width="30px">
                              <span>Avatar</span>
                           </td>
                           <td>$15,000</td>
                           <td>$2,000</td>
                           <td class="text-success">Laptop</td>
                           <td><span class="badge-cancelled">Pending</span></td>
                        </tr>
                        <tr>
                           <td><img src="<?= file_url('assets/images/avatar.jpg'); ?>" alt="logo" width="30px">
                              <span>Avatar</span>
                           </td>
                           <td>$18,000</td>
                           <td>$3,000</td>
                           <td class="text-success">iPhone</td>
                           <td><span class="badge-success">Approved</span></td>
                        </tr>
                        <tr>
                           <td><img src="<?= file_url('assets/images/avatar.jpg'); ?>" alt="logo" width="30px">
                              <span>Avatar</span>
                           </td>
                           <td>$15,000</td>
                           <td>$2,000</td>
                           <td class="text-success">Laptop</td>
                           <td><span class="badge-cancelled">Pending</span></td>
                        </tr>
                        <tr>
                           <td><img src="<?= file_url('assets/images/avatar.jpg'); ?>" alt="logo" width="30px">
                              <span>Avatar</span>
                           </td>
                           <td>$18,000</td>
                           <td>$3,000</td>
                           <td class="text-success">iPhone</td>
                           <td><span class="badge-cancelled">Pending</span></td>
                        </tr>
                        <tr>
                           <td><img src="<?= file_url('assets/images/avatar.jpg'); ?>" alt="logo" width="30px">
                              <span>Avatar</span>
                           </td>
                           <td>$20,000</td>
                           <td>$5,000</td>
                           <td class="text-success">Scooter</td>
                           <td><span class="badge-cancelled">Pending</span></td>
                        </tr>
                        <tr>
                           <td><img src="<?= file_url('assets/images/avatar.jpg'); ?>" alt="logo" width="30px">
                              <span>Avatar</span>
                           </td>
                           <td>$22,000</td>
                           <td>$7,000</td>
                           <td class="text-success">Smartwatch</td>
                           <td><span class="badge-cancelled">Pending</span></td>
                        </tr>
                        <tr>
                           <td><img src="<?= file_url('assets/images/avatar.jpg'); ?>" alt="logo" width="30px">
                              <span>Avatar</span>
                           </td>
                           <td>$25,000</td>
                           <td>$8,000</td>
                           <td class="text-success">TV</td>
                           <td><span class="badge-cancelled">Pending</span></td>
                        </tr>
                     </tbody>
                  </table>
               </div>
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
                <?php if($b){ ?>
                <script>
                  const countdownDuration = Number('<?= $rem; ?>')*1000;
                  const endTime = Date.now() + countdownDuration;

                  const timer = setInterval(() => {
                    const now = Date.now();
                    const distance = endTime - now;

                    if (distance <= 0) {
                      clearInterval(timer);
                      document.getElementById("timer").classList.add("d-none");
                      document.getElementById("activeBtn").classList.remove("d-none");
                      return;
                    }

                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                    document.getElementById("days").textContent = days.toString().padStart(2, "0");
                    document.getElementById("hours").textContent = hours.toString().padStart(2, "0");
                    document.getElementById("minutes").textContent = minutes.toString().padStart(2, "0");
                    document.getElementById("seconds").textContent = seconds.toString().padStart(2, "0");
                  }, 1000);
                </script>
                <?php } ?>