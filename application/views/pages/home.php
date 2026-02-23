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
    .status-card.blank{
        background: transparent;
        border: 0;
        box-shadow: 0 0 0;
    }
</style>
<?php
$b=false;
if($this->session->role=='admin'){
    $data=getadmindata();
?>        
<div class="d-lg-block d-md-block">
    <div class="status-wrapper">
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
         <div class="status-card">
            <ul>
                  <li>
                     <div class="status-icon">
                        <svg width="46" height="46" viewBox="0 0 46 46" fill="none">
                              <path d="M9 15C9 12.2386 11.2386 10 14 10H32C34.7614 10 37 12.2386 37 15V31C37 33.7614 34.7614 36 32 36H14C11.2386 36 9 33.7614 9 31V15Z"
                                 stroke="#3AC977" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M9 18H37" stroke="#3AC977" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M32 23C33.6569 23 35 21.6569 35 20C35 18.3431 33.6569 17 32 17C30.3431 17 29 18.3431 29 20C29 21.6569 30.3431 23 32 23Z"
                                 stroke="#3AC977" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                     </div>
                  </li>
                  <li>
                     <h4><?= $this->amount->toDecimal($data['deposits'],true,5); ?></h4>
                     <p>Total Deposits</p>
                  </li>
            </ul>
         </div>
         <div class="status-card">
            <ul>
                  <li>
                     <div class="status-icon">
                        <svg width="46" height="46" viewBox="0 0 46 46" fill="none">
                              <path d="M9 15C9 12.2386 11.2386 10 14 10H32C34.7614 10 37 12.2386 37 15V31C37 33.7614 34.7614 36 32 36H14C11.2386 36 9 33.7614 9 31V15Z"
                                 stroke="#3AC977" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M9 18H37" stroke="#3AC977" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M32 23C33.6569 23 35 21.6569 35 20C35 18.3431 33.6569 17 32 17C30.3431 17 29 18.3431 29 20C29 21.6569 30.3431 23 32 23Z"
                                 stroke="#3AC977" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                     </div>
                  </li>
                  <li>
                     <h4><?= $this->amount->toDecimal($data['withdrawals'],true,5); ?></h4>
                     <p>Total Withdrawals</p>
                  </li>
            </ul>
         </div>
         <div class="status-card">
            <ul>
                  <li>
                     <div class="status-icon">
                        <svg width="46" height="46" viewBox="0 0 46 46" fill="none">
                              <path d="M9 15C9 12.2386 11.2386 10 14 10H32C34.7614 10 37 12.2386 37 15V31C37 33.7614 34.7614 36 32 36H14C11.2386 36 9 33.7614 9 31V15Z"
                                 stroke="#3AC977" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M9 18H37" stroke="#3AC977" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M32 23C33.6569 23 35 21.6569 35 20C35 18.3431 33.6569 17 32 17C30.3431 17 29 18.3431 29 20C29 21.6569 30.3431 23 32 23Z"
                                 stroke="#3AC977" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                     </div>
                  </li>
                  <li>
                     <h4><?= $this->amount->toDecimal($data['topup'],false); ?></h4>
                     <p>Top up Activation ID</p>
                  </li>
            </ul>
         </div>
    </div>
    <div class="status-wrapper">
         <div class="status-card">
            <ul>
                  <li>
                     <div class="status-icon">
                        <svg width="46" height="46" viewBox="0 0 46 46" fill="none">
                              <path d="M9 15C9 12.2386 11.2386 10 14 10H32C34.7614 10 37 12.2386 37 15V31C37 33.7614 34.7614 36 32 36H14C11.2386 36 9 33.7614 9 31V15Z"
                                 stroke="#3AC977" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M9 18H37" stroke="#3AC977" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M32 23C33.6569 23 35 21.6569 35 20C35 18.3431 33.6569 17 32 17C30.3431 17 29 18.3431 29 20C29 21.6569 30.3431 23 32 23Z"
                                 stroke="#3AC977" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                     </div>
                  </li>
                  <li>
                     <h4><?= $this->amount->toDecimal($data['rank_achiever'],false); ?></h4>
                     <p>Rank Achievers</p>
                  </li>
            </ul>
         </div>
         <div class="status-card">
            <ul>
                  <li>
                     <div class="status-icon">
                        <svg width="46" height="46" viewBox="0 0 46 46" fill="none">
                              <path d="M9 15C9 12.2386 11.2386 10 14 10H32C34.7614 10 37 12.2386 37 15V31C37 33.7614 34.7614 36 32 36H14C11.2386 36 9 33.7614 9 31V15Z"
                                 stroke="#3AC977" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M9 18H37" stroke="#3AC977" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M32 23C33.6569 23 35 21.6569 35 20C35 18.3431 33.6569 17 32 17C30.3431 17 29 18.3431 29 20C29 21.6569 30.3431 23 32 23Z"
                                 stroke="#3AC977" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                     </div>
                  </li>
                  <li>
                     <h4><?= $this->amount->toDecimal($data['rank_reward'],true,5); ?></h4>
                     <p>Rank Reward</p>
                  </li>
            </ul>
         </div>
         <div class="status-card">
            <ul>
                  <li>
                     <div class="status-icon">
                        <svg width="46" height="46" viewBox="0 0 46 46" fill="none">
                              <path d="M9 15C9 12.2386 11.2386 10 14 10H32C34.7614 10 37 12.2386 37 15V31C37 33.7614 34.7614 36 32 36H14C11.2386 36 9 33.7614 9 31V15Z"
                                 stroke="#3AC977" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M9 18H37" stroke="#3AC977" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M32 23C33.6569 23 35 21.6569 35 20C35 18.3431 33.6569 17 32 17C30.3431 17 29 18.3431 29 20C29 21.6569 30.3431 23 32 23Z"
                                 stroke="#3AC977" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                     </div>
                  </li>
                  <li>
                     <h4><?= $this->amount->toDecimal($data['spin'],true,5); ?></h4>
                     <p>Spin Bonus</p>
                  </li>
            </ul>
         </div>
         <div class="status-card">
            <ul>
                  <li>
                     <div class="status-icon">
                        <svg width="46" height="46" viewBox="0 0 46 46" fill="none">
                              <path d="M9 15C9 12.2386 11.2386 10 14 10H32C34.7614 10 37 12.2386 37 15V31C37 33.7614 34.7614 36 32 36H14C11.2386 36 9 33.7614 9 31V15Z"
                                 stroke="#3AC977" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M9 18H37" stroke="#3AC977" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M32 23C33.6569 23 35 21.6569 35 20C35 18.3431 33.6569 17 32 17C30.3431 17 29 18.3431 29 20C29 21.6569 30.3431 23 32 23Z"
                                 stroke="#3AC977" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                     </div>
                  </li>
                  <li>
                     <h4><?= $this->amount->toDecimal($data['monthly'],true,5); ?></h4>
                     <p>Monthly Loyalty Income</p>
                  </li>
            </ul>
         </div>
    </div>
    <div class="status-wrapper">
         <div class="status-card">
            <ul>
                  <li>
                     <div class="status-icon">
                        <svg width="46" height="46" viewBox="0 0 46 46" fill="none">
                              <path d="M9 15C9 12.2386 11.2386 10 14 10H32C34.7614 10 37 12.2386 37 15V31C37 33.7614 34.7614 36 32 36H14C11.2386 36 9 33.7614 9 31V15Z"
                                 stroke="#3AC977" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M9 18H37" stroke="#3AC977" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M32 23C33.6569 23 35 21.6569 35 20C35 18.3431 33.6569 17 32 17C30.3431 17 29 18.3431 29 20C29 21.6569 30.3431 23 32 23Z"
                                 stroke="#3AC977" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                     </div>
                  </li>
                  <li>
                     <h4><?= $this->amount->toDecimal($data['t_activation'],true,4); ?></h4>
                     <p>Today Activation</p>
                  </li>
            </ul>
         </div>
         <div class="status-card">
            <ul>
                  <li>
                     <div class="status-icon">
                        <svg width="46" height="46" viewBox="0 0 46 46" fill="none">
                              <path d="M9 15C9 12.2386 11.2386 10 14 10H32C34.7614 10 37 12.2386 37 15V31C37 33.7614 34.7614 36 32 36H14C11.2386 36 9 33.7614 9 31V15Z"
                                 stroke="#3AC977" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M9 18H37" stroke="#3AC977" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M32 23C33.6569 23 35 21.6569 35 20C35 18.3431 33.6569 17 32 17C30.3431 17 29 18.3431 29 20C29 21.6569 30.3431 23 32 23Z"
                                 stroke="#3AC977" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                     </div>
                  </li>
                  <li>
                     <h4><?= $this->amount->toDecimal($data['t_withdrawals'],true,4); ?></h4>
                     <p>Today Withdrawals</p>
                  </li>
            </ul>
         </div>
         <div class="status-card blank">
         </div>
         <div class="status-card blank">
         </div>
    </div>
</div>
<?php
}
else{
    $b=false;
    $text='Booster Timer';
    if($member['status']==1){
        $activation=date('Y-m-d H:i:s',strtotime($member['activation_date'].' '.$member['activation_time']));
        $expiry=date('Y-m-d H:i:s',strtotime($activation.' +7 days 6 hours'));
        $atime=strtotime($activation);
        $etime=strtotime($expiry);
        $remTime=$etime-time();
        $b=true;
        
        if($member['booster']==1){
            $remTime=0;
            $text='Booster';
        }
        if($remTime<=0 && $member['booster']==0){
            $b=false;
        }
    }
    $incomes=getincome();
?>
   <div class="status-cardsection">
       <?php if($b){ ?> 
    <!-- start -->
  <!-- <div class="booster-timer d-flex justify-content-between align-items-center">
   <div class="booster-label">
      <h5 class="mb-0 fw-bold"><?= $text; ?></h5>
   </div>
   <div class="booster-status text-end">
      <div class="booster-status text-end">
         <div class="timer-box d-flex justify-content-end gap-2 <?= ($member['booster']==1)?'d-none':'' ?>" id="timer">
            <div class="time-item"><span id="days">07</span><small>Days</small></div>
            <div class="time-item"><span id="hours">06</span><small>Hrs</small></div>
            <div class="time-item"><span id="minutes">00</span><small>Min</small></div>
            <div class="time-item"><span id="seconds">00</span><small>Sec</small></div>
            <a href="<?= base_url('deposit/booster/'); ?>" class="btn btn-active" id="" style="padding-top: 15px;">Activate</a>
         </div>
         <button class="btn btn-active <?= ($member['booster']==1)?'':'d-none' ?>" id="activeBtn">Active</button>
      </div>
   </div>
</div> -->
    <!-- end -->
       <?php } ?>
    <!-- start -->
<!-- 
  <div class="booster-timer d-flex justify-content-between align-items-center">
   <div class="booster-label">
      <div id="marquee">🚀 Welcome to my website</div>
      <script>
         let pos = 300;
         const el = document.getElementById("marquee");
         
         setInterval(() => {
         pos--;
         el.style.transform = `translateX(${pos}px)`;
         if (pos < -el.offsetWidth) pos = window.innerWidth;
         }, 20);
      </script>
      <style>
         #marquee {
         position: absolute;
         white-space: nowrap;
         }
      </style>
      <div id="tokenInfo" class="">
         <div style="display:flex;align-items:center;gap:10px;">
            <img id="tokenLogo" class="token-logo" src="<?= file_url('assets/images/logo.png'); ?>" height="50" alt="Logo">
            <div>
               <h3>1 FPC = $0.55</h3>
            </div>
         </div>
      </div>
   </div>
</div> -->
    <!-- end -->
     <div class="d-lg-block d-md-block">
      <div class="status-wrapper">
         <div class="status-card">
            <ul>
                  <li>
                     <div class="status-icon">
                        <svg width="46" height="46" viewBox="0 0 46 46" fill="none">
                              <path d="M9 15C9 12.2386 11.2386 10 14 10H32C34.7614 10 37 12.2386 37 15V31C37 33.7614 34.7614 36 32 36H14C11.2386 36 9 33.7614 9 31V15Z"
                                 stroke="#3AC977" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M9 18H37" stroke="#3AC977" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M32 23C33.6569 23 35 21.6569 35 20C35 18.3431 33.6569 17 32 17C30.3431 17 29 18.3431 29 20C29 21.6569 30.3431 23 32 23Z"
                                 stroke="#3AC977" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                     </div>
                  </li>
                  <li>
                     <h4><?= $this->amount->toDecimal($incomes['wallet_balance'],true,5); ?></h4>
                     <p>Wallet Balance</p>
                  </li>
            </ul>
         </div>
         <div class="status-card">
            <ul>
                  <li>
                     <div class="status-icon">
                        <svg width="46" height="46" viewBox="0 0 46 46" fill="none">
                              <path d="M23 40C31.2843 40 38 33.2843 38 25C38 16.7157 31.2843 10 23 10C14.7157 10 8 16.7157 8 25C8 33.2843 14.7157 40 23 40Z"
                                 stroke="#2196F3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M23 30V20" stroke="#2196F3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M19 23L23 19L27 23" stroke="#2196F3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                     </div>
                  </li>
                  <li>
                     <h4><?= $this->amount->toDecimal($incomes['total'],true,5); ?></h4>
                     <p>Total Income</p>
                  </li>
            </ul>
         </div>
         <div class="status-card">
            <ul>
                  <li>
                     <div class="status-icon">
                        <svg width="46" height="46" viewBox="0 0 46 46" fill="none">
                              <path d="M23 28C28.5228 28 33 23.5228 33 18C33 12.4772 28.5228 8 23 8C17.4772 8 13 12.4772 13 18C13 23.5228 17.4772 28 23 28Z"
                                 stroke="#FF9800" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M23 13L24.8 16.8L29 17.3L26 20.1L26.8 24L23 22L19.2 24L20 20.1L17 17.3L21.2 16.8L23 13Z"
                                 stroke="#FF9800" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M17 28L15 36L21 32" stroke="#FF9800" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M29 28L31 36L25 32" stroke="#FF9800" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                     </div>
                  </li>
                  <li>
                     <h4><?= $rank=getrank(); ?></h4>
                     <p>Rank Status</p>
                  </li>
            </ul>
         </div>
         <div class="status-card">
            <ul>
                  <li>
                     <div class="status-icon">
                        <svg width="46" height="46" viewBox="0 0 46 46" fill="none">
                              <path d="M23 40C31.2843 40 38 33.2843 38 25C38 16.7157 31.2843 10 23 10C14.7157 10 8 16.7157 8 25C8 33.2843 14.7157 40 23 40Z"
                                 stroke="#F44336" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M23 20V30" stroke="#F44336" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M19 27L23 31L27 27" stroke="#F44336" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                     </div>
                  </li>
                  <li>
                     <h4><?= $this->amount->toDecimal($incomes['withdrawal'],true,5); ?></h4>
                     <p>Total Withdrawal</p>
                  </li>
            </ul>
         </div>
         <div class="status-card">
            <ul>
                  <li>
                     <div class="status-icon">
                        <svg width="46" height="46" viewBox="0 0 46 46" fill="none">
                              <path d="M23 22C26.3137 22 29 19.3137 29 16C29 12.6863 26.3137 10 23 10C19.6863 10 17 12.6863 17 16C17 19.3137 19.6863 22 23 22Z"
                                 stroke="#9C27B0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M14 32C14 27.5817 17.5817 24 22 24H24C28.4183 24 32 27.5817 32 32"
                                 stroke="#9C27B0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M31 20C33.2091 20 35 18.2091 35 16C35 13.7909 33.2091 12 31 12"
                                 stroke="#9C27B0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M34 28C34 25.2386 31.7614 23 29 23"
                                 stroke="#9C27B0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                     </div>
                  </li>
                  <li>
                     <h4><?= countteam(true); ?></h4>
                     <p>Active Members</p>
                  </li>
            </ul>
         </div>
         <div class="status-card">
            <ul>
                  <li>
                     <div class="status-icon">
                        <svg width="46" height="46" viewBox="0 0 46 46" fill="none">
                              <path d="M23 20C25.7614 20 28 17.7614 28 15C28 12.2386 25.7614 10 23 10C20.2386 10 18 12.2386 18 15C18 17.7614 20.2386 20 23 20Z"
                                 stroke="#009688" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M16 30C16 25.5817 19.5817 22 24 22H22C26.4183 22 30 25.5817 30 30"
                                 stroke="#009688" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M15 21C17.2091 21 19 19.2091 19 17C19 14.7909 17.2091 13 15 13C12.7909 13 11 14.7909 11 17C11 19.2091 12.7909 21 15 21Z"
                                 stroke="#009688" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M10 28C10 25.2386 12.2386 23 15 23"
                                 stroke="#009688" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M31 21C33.2091 21 35 19.2091 35 17C35 14.7909 33.2091 13 31 13C28.7909 13 27 14.7909 27 17C27 19.2091 28.7909 21 31 21Z"
                                 stroke="#009688" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M36 28C36 25.2386 33.7614 23 31 23"
                                 stroke="#009688" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
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
     </div>
       <?php
        if(!empty($rewards)){
        ?>
         <div class="booster-timer d-flex justify-content-between align-items-center mt-2" id="spin-div">
         <div class="booster-label">
            <h5 class="mb-0 fw-bold">Spin Wheel</h5>
         </div>
         <div class="booster-status">
            <div class="timer-box d-flex justify-content-center align-items-center gap-2 " id="timer2">
                <div class="time-item d-none"><span id="days">07</span><small>Days</small></div>
                <div class="time-item d-none"><span id="hours">06</span><small>Hrs</small></div>
                <div class="time-item d-none"><span id="minutes">00</span><small>Min</small></div>
                <div class="time-item d-none"><span id="seconds">00</span><small>Sec</small></div>
                <a href="#" class="btn btn-active" data-bs-toggle="modal"
        data-bs-target="#spinModal" id="">Spin Wheel</a>
            </div>
         </div>
         </div>
        <?php
            $this->load->view('pages/spin');
        }
       ?>
   <!-- mobile device start -->
<div class="d-none d-lg-none d-md-none d-block">
   <div class="mobilestatus-wrapper">
      <div class="mobilestatus-card">
         <ul>
            <li>
               <h4>0.00</h4>
               <p>Wallet Balance</p>
            </li>
            <li>
               <h4>0.00</h4>
               <p>Rank Status</p>
            </li>
             <li>
               <h4>0.00</h4>
               <p>Active Members</p>
            </li>
         </ul>
      </div>
      <div class="mobilestatus-card">
         <div class="mobilewrapper-logo">
            <img src="<?= file_url('assets/images/future-coin.png'); ?>" alt="logo">
         </div>
      </div>
      <div class="mobilestatus-card text-end">
         <ul>
            <li>
               <h4>0.00</h4>
               <p>Total Income</p>
            </li>
            <li>
               <h4>0.00</h4>
               <p>Total Withdrawal</p>
            </li>
            <li>
               <h4>0.00</h4>
               <p>Total Team</p>
            </li>
         </ul>
      </div>
   </div>
</div>
 <!-- mobile device end -->
   </div>
   <div class="Congratulations-section">
      <div class="row">
         <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="dash-user-profile">
               <div class="dash-profile-bg">
                   <?php
                        $photo=$user['photo'];
                        if($rank!='--'){
                            if(file_exists('./assets/images/avatar/'.strtolower($rank).'.webp')){
                                $photo=file_url('assets/images/avatar/'.strtolower($rank).'.webp');
                            }
                        }
                    ?>
                  <img src="<?php echo $photo; ?>" alt="<?php echo $photo; ?>" class="deshpro">
                   <!-- <img src="<?= file_url('assets/images/avatar.jpg'); ?>" alt="<?php echo ($user['photo']); ?>" class="deshpro"> -->
                  <h2><?php echo ($user['username']); ?></h2>
                  <!-- <?= $member['status']==1?'<p class="textActive">Active</p>':'<p class="text-danger">In-Active</p>' ?> -->
              <!-- marquee tag -->
                  <div class="booster-marquee">
                     <div id="marquee"><img src="<?= file_url('assets/images/logo.png'); ?>" alt="logo" class="marquee-logo"> Welcome to Future Pay Coin — Live Rate: <span id="price"></span></div>
                  </div>
                  <script>
                     const el = document.getElementById("marquee");
                     const parent = el.parentElement;
                     
                     let pos = parent.offsetWidth;
                     let speed = .89;
                     let pause = false;
                     parent.addEventListener("mouseenter", () => pause = true);
                     parent.addEventListener("mouseleave", () => pause = false);
                     
                     function animate() {
                        if (!pause) {
                           pos -= speed;
                           el.style.left = pos + "px";
                     
                           if (pos < -el.offsetWidth) {
                                 pos = parent.offsetWidth; 
                           }
                        }
                        requestAnimationFrame(animate);
                     }
                     
                     animate();
                  </script>
                   <!-- marquee tag end -->
                   
                
                   <?php if($b){ ?> 
                    <!-- time booster start -->
                   
                     <div class="booster-timer d-flex justify-content-between align-items-center">
                     <div class="booster-label">
                        <h5 class="mb-0 fw-bold"><?= $text ?></h5>
                     </div>
                     <div class="booster-status">
                        <div class="timer-box d-flex justify-content-center align-items-center gap-2 <?= ($member['booster']==1)?'d-none':'' ?>" id="timer">
                        <div class="time-item"><span id="days">07</span><small>Days</small></div>
                        <div class="time-item"><span id="hours">06</span><small>Hrs</small></div>
                        <div class="time-item"><span id="minutes">00</span><small>Min</small></div>
                        <div class="time-item"><span id="seconds">00</span><small>Sec</small></div>
                            <a href="<?= base_url('deposit/booster/'); ?>" class="btn btn-active" id="" style="padding-top: 15px;">Activate</a>
                        </div>
                         <button class="btn btn-active <?= ($member['booster']==1)?'':'d-none' ?>" id="activeBtn">Active</button>
                     </div>
                     </div>
                     <!-- time booster end -->
                   <?php } ?>
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
                          <tr>
                           <td>Status</td>
                           <td class="left-record"><?= $member['status']==1?'<p class="textActive">Active</p>':'<p class="text-danger">In-Active</p>' ?></td>
                        </tr>
                        <?php /*?><tr>
                           <td>Activation Package</td>
                           <td class="left-record"><?= empty($member['package']) || $member['package']==0?'<p class="text-danger">--</p>':'<p class="textActive">$'.round($member['package'],4).'</p>'; ?></td>
                        </tr>
                        <tr>
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
         <div class="col-lg-6 col-md-12 col-sm-12">
               <?php
                    $legs=getlegbusiness(true);
                    $power=!empty($legs[0]['business'])?$legs[0]['business']:0;
                    $weaker=!empty($legs[1]['business'])?$legs[1]['business']:0;
                ?>
            <div class="staking-section">
            <div class="staking-flex">
            <div class="staking-card">
                  <div class="stakingicon">
                     <img src="<?= file_url('assets/images/future-coin.png'); ?>" width="24">
                  </div>
                  <h5>My Investment</h5>
                  <h2> <?= $this->amount->toDecimal(getdeposits(),true,5); ?></h2>
            </div>
            <div class="staking-card">
                  <div class="stakingicon">
                     <img src="<?= file_url('assets/images/future-coin.png'); ?>" width="24">
                  </div>
                  <h5>Direct Business</h5>
                  <h2> <?= $this->amount->toDecimal(get_direct_business(),true,5); ?></h2>
            </div>
            <div class="staking-card">
                  <div class="stakingicon">
                     <img src="<?= file_url('assets/images/future-coin.png'); ?>" width="24">
                  </div>
                  <h5>Total Team Business</h5>
                  <h2> <?= $this->amount->toDecimal($power+$weaker,true,5); ?></h2>
            </div>
            <div class="staking-card">
                  <div class="stakingicon">
                     <img src="<?= file_url('assets/images/future-coin.png'); ?>" width="24">
                  </div>
                  <h5>Power Leg</h5>
                  <h2> <?= $this->amount->toDecimal($power,true,5); ?></h2>
            </div>
            <div class="staking-card">
                  <div class="stakingicon">
                     <img src="<?= file_url('assets/images/future-coin.png'); ?>" width="24">
                  </div>
                  <h5>Weaker Leg</h5>
                  <h2> <?= $this->amount->toDecimal($weaker,true,5); ?></h2>
            </div>
            <!-- PHP Section -->
            <div class="staking-card">
                  <div class="stakingicon">
                     <img src="<?= file_url('assets/images/future-coin.png'); ?>" width="24">
                  </div>
                  <h5>Staking Reward</h5>
                  <h2> <?= $this->amount->toDecimal($incomes['roiincome'],true,5); ?></h2>
            </div>
            <div class="staking-card">
                  <div class="stakingicon">
                     <img src="<?= file_url('assets/images/future-coin.png'); ?>" width="24">
                  </div>
                  <h5>Level Income</h5>
                  <h2> <?= $this->amount->toDecimal($incomes['level'],true,5); ?></h2>
            </div>
            <div class="staking-card">
                  <div class="stakingicon">
                     <img src="<?= file_url('assets/images/future-coin.png'); ?>" width="24">
                  </div>
                  <h5>Booster Income</h5>
                  <h2> <?= $this->amount->toDecimal($incomes['boosterincome'],true,5); ?></h2>
            </div>
            <div class="staking-card">
                  <div class="stakingicon">
                     <img src="<?= file_url('assets/images/future-coin.png'); ?>" width="24">
                  </div>
                  <h5>Monthly Income Bonus</h5>
                  <h2> <?= $this->amount->toDecimal($incomes['monthly'],true,5); ?></h2>
            </div>
            <div class="staking-card">
                  <div class="stakingicon">
                     <img src="<?= file_url('assets/images/future-coin.png'); ?>" width="24">
                  </div>
                  <h5>Rank & Rewards</h5>
                  <h2> <?= $this->amount->toDecimal($incomes['reward'],true,5); ?></h2>
            </div>
            </div>
         </div>
         </div>
      </div>
       <style>   
    canvas#statusDoughnut {
      display: block;
      max-width: 100%;
      max-height: 240px; 
    }

    .legend-row { display:flex;gap:8px;flex-wrap:wrap;margin-top:12px }
    .legend-item { display:flex;align-items:center;gap:8px;font-size:13px }
    .swatch { width:14px;height:14px;border-radius:3px }
       </style>
      <div class="row">
          <div class="col-12">
              <div class="dash-user-profile">
                  <div class="row">
                      <?php
                        $direct=countdirect(1);
                        $where=['regid'=>$user['id'],'status'=>1];
                        $investments=$this->db->get_where('investments',$where)->result_array();
                        foreach($investments as $investment){
                            $this->db->select_sum('amount');
                            $income=$this->db->get_where('income',['regid'=>$user['id'],'type'=>'roiincome',
                                                                   'inv_id'=>$investment['id']])->unbuffered_row()->amount;
                            $times=1;
                            if($investment['auto']==0){
                                if($member['booster']==0){
                                    $times=$direct==0?2:3;
                                }
                                else{
                                    $times=4;
                                }
                            }
                            $total=$investment['amount']*$times;
                            $rem=$total-$income;
                            $complete=$income*100/$total;
                            $complete=round($complete,2);
                            $rem=100-$complete;
                      ?>
                      <div class="col-md-3 pt-3">
                        <canvas id="statusDoughnut" width="320" height="320"></canvas>
                        <div class="legend-row" id="legend"></div>
                      </div>
                      <?php
                        }
                      ?>
                  </div>
              </div>
          </div>
      </div>
  <!-- Chart.js CDN -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
  <script>
    // labels and data — only Complete and Pending
    const labels = ['Complete', 'Pending'];
    const values = [<?= $complete ?>, <?= $rem ?>];

    // colors for the slices
    const colors = ['#22c55e', '#f59e0b'];

    // Create the doughnut chart
    const ctx = document.getElementById('statusDoughnut').getContext('2d');

    // plugin to draw total in the center
    const totalCenterPlugin = {
      id: 'totalCenter',
      afterDraw(chart) {
        const {ctx, chartArea: {top, right, bottom, left}} = chart;
        ctx.save();
        const total = '<?= $times.'X'; ?>';
        ctx.font = '600 18px system-ui';
        ctx.fillStyle = '#abcdef';
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        const x = (left + right) / 2;
        const y = chart.chartArea.top + (chart.chartArea.bottom - chart.chartArea.top) / 2;
        ctx.fillText(total, x, y - 8);
        ctx.font = '13px system-ui';
        ctx.fillStyle = '#6b7280';
        ctx.fillText('<?= '$'.round($investment['amount'],2) ?>', x, y + 14);
        ctx.restore();
      }
    };

    const myChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: labels,
        datasets: [{
          data: values,
          backgroundColor: colors,
          borderWidth: 0
        }]
      },
      options: {
        maintainAspectRatio: false,
        cutout: '65%',
        plugins: {
          legend: { display: false },
          tooltip: { padding: 8 },
          datalabels: {
            color: '#fff',
            font: { weight: 'bold', size: 14 },
            formatter: (value, context) => `${value}%`
          }
        }
      },
      plugins: [ChartDataLabels, totalCenterPlugin]
    });

    // Build a custom legend below the chart
    const legendEl = document.getElementById('legend');
    labels.forEach((label, i) => {
      const item = document.createElement('div');
      item.className = 'legend-item';
      item.innerHTML = `<span class="swatch" style="background:${colors[i]}"></span><span>${label} — ${values[i]}%</span>`;
      legendEl.appendChild(item);
    });
  </script>
      <!-- <div class="row">
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
                  </li>
               </ul>
            </div>
         </div>
      </div> -->
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
    <script src="https://cdn.jsdelivr.net/npm/web3@1.10.0/dist/web3.min.js"></script>
    <script src="<?= file_url('assets/js/abi.js') ?>"></script>
    <script>
    const RPC_URL = "https://bsc-dataseed.binance.org/"; // BSC Mainnet
    const web3 = new Web3(new Web3.providers.HttpProvider(RPC_URL));
       const ROUTER_ADDRESS = "0x10ED43C718714eb63d5aA57B78B54704E256024E";
       const router = new web3.eth.Contract(ROUTER_ABI, ROUTER_ADDRESS);

        // Replace with your RWC + USDT
        const TOKEN = "<?= TOKEN_ADDRESS ?>";  // Your BEP20 token address
        const USDT  = "0x55d398326f99059fF775485246999027B3197955"; // BSC USDT
        async function getPrice() {
          try {
            const amountIn = web3.utils.toWei("1", "ether"); // 1 RWC
            const path = [TOKEN, USDT];

            const amounts = await router.methods.getAmountsOut(amountIn, path).call();
            var price = web3.utils.fromWei(amounts[1], "ether");
            price=Number(price);
            price=isNaN(price)?0:price;
            
              
            document.getElementById("price").innerText = `$${price.toFixed(5)}`;
          } catch (err) {
            console.error(err);
            document.getElementById("price").innerText = "Error fetching price";
          }
        }

        getPrice();
        setInterval(getPrice, 10000); // Refresh every 10 sec
   </script>
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
                  const countdownDuration = Number('<?= $remTime; ?>')*1000;
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
