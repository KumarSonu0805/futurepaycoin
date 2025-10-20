<nav class="sidebar border-end" id="sidebar">
   <div class="text-center p-4 sidemenulogo">
      <img src="<?= file_url('assets/images/future-coin.png'); ?>" alt="Logo">
      <h5 class="mt-2">Future Pay Coin</h5>
   </div>
   <ul class="nav flex-column" id="sidebarAccordion">
      <div class="nav-linktitle">Member Dashboard</div>
      <li class="nav-item">
         <a class="nav-link">
         <i class="fa-solid fa-house"></i> Dashboards
         </a>
      </li>
      <li class="nav-item">
         <a class="nav-link">
         <i class="fas fa-chart-line"></i> AI Trading
         </a>
      </li>
      <li class="nav-item">
         <a class="nav-link">
         <i class="fa-regular fa-square-plus"></i> New Registration
         </a>
      </li>
      <li class="nav-item">
         <a class="nav-link" data-bs-toggle="collapse" href="#profileMenu" role="button" aria-expanded="false" aria-controls="profileMenu">
         <i class="fa-solid fa-user"></i> Profile
         <i class="fas fa-chevron-down ms-auto"></i>
         </a>
         <div class="collapse" id="profileMenu" data-bs-parent="#sidebarAccordion">
            <ul class="nav flex-column ms-3">
               <li class="nav-item"><a class="nav-link" href="#">User Summary</a></li>
               <li class="nav-item"><a class="nav-link" href="#">Change Password</a></li>
               <li class="nav-item"><a class="nav-link" href="#">Wallet Address</a></li>
            </ul>
         </div>
      </li>
      <li class="nav-item">
         <a class="nav-link" data-bs-toggle="collapse" href="#depositeMenu" role="button" aria-expanded="false" aria-controls="depositeMenu">
         <i class="fa-solid fa-money-bill-transfer"></i> Deposite Section
         <i class="fas fa-chevron-down ms-auto"></i>
         </a>
         <div class="collapse" id="depositeMenu" data-bs-parent="#sidebarAccordion">
            <ul class="nav flex-column ms-3">
               <li class="nav-item"><a class="nav-link" href="#">Deposite Fund</a></li>
               <li class="nav-item"><a class="nav-link" href="#">Deposite Fund History</a></li>
            </ul>
         </div>
      </li>
      <li class="nav-item">
         <a class="nav-link" data-bs-toggle="collapse" href="#stakingMenu" role="button" aria-expanded="false" aria-controls="stakingMenu">
         <i class="fa-solid fa-money-bill-transfer"></i> Staking Section
         <i class="fas fa-chevron-down ms-auto"></i>
         </a>
         <div class="collapse" id="stakingMenu" data-bs-parent="#sidebarAccordion">
            <ul class="nav flex-column ms-3">
               <li class="nav-item"><a class="nav-link" href="#">Staking Fund</a></li>
               <li class="nav-item"><a class="nav-link" href="#">Staking Fund History</a></li>
            </ul>
         </div>
      </li>
      <li class="nav-item">
         <a class="nav-link" data-bs-toggle="collapse" href="#incomeMenu" role="button" aria-expanded="false" aria-controls="incomeMenu">
         <i class="fa-solid fa-money-bill-transfer"></i> Income
         <i class="fas fa-chevron-down ms-auto"></i>
         </a>
         <div class="collapse" id="incomeMenu" data-bs-parent="#sidebarAccordion">
            <ul class="nav flex-column ms-3">
               <li class="nav-item"><a class="nav-link" href="#">Staking Fund</a></li>
               <li class="nav-item"><a class="nav-link" href="#">Staking Fund History</a></li>
            </ul>
         </div>
      </li>
      <li class="nav-item">
         <a class="nav-link" data-bs-toggle="collapse" href="#rewardMenu" role="button" aria-expanded="false" aria-controls="rewardMenu">
         <i class="fa-solid fa-money-bill-transfer"></i> Reward Section
         <i class="fas fa-chevron-down ms-auto"></i>
         </a>
         <div class="collapse" id="rewardMenu" data-bs-parent="#sidebarAccordion">
            <ul class="nav flex-column ms-3">
               <li class="nav-item"><a class="nav-link" href="#">Staking Fund</a></li>
               <li class="nav-item"><a class="nav-link" href="#">Staking Fund History</a></li>
            </ul>
         </div>
      </li>
      <li class="nav-item">
         <a class="nav-link" data-bs-toggle="collapse" href="#royaltyMenu" role="button" aria-expanded="false" aria-controls="royaltyMenu">
         <i class="fa-solid fa-money-bill-transfer"></i> Royalty Section
         <i class="fas fa-chevron-down ms-auto"></i>
         </a>
         <div class="collapse" id="royaltyMenu" data-bs-parent="#sidebarAccordion">
            <ul class="nav flex-column ms-3">
               <li class="nav-item"><a class="nav-link" href="#">Staking Fund</a></li>
               <li class="nav-item"><a class="nav-link" href="#">Staking Fund History</a></li>
            </ul>
         </div>
      </li>
      <li class="nav-item">
         <a class="nav-link" data-bs-toggle="collapse" href="#psecMenu" role="button" aria-expanded="false" aria-controls="psecMenu">
         <i class="fa-solid fa-money-bill-transfer"></i> P2P Section
         <i class="fas fa-chevron-down ms-auto"></i>
         </a>
         <div class="collapse" id="psecMenu" data-bs-parent="#sidebarAccordion">
            <ul class="nav flex-column ms-3">
               <li class="nav-item"><a class="nav-link" href="#">Staking Fund</a></li>
               <li class="nav-item"><a class="nav-link" href="#">Staking Fund History</a></li>
            </ul>
         </div>
      </li>
      <li class="nav-item">
         <a class="nav-link">
         <i class="fa-solid fa-right-from-bracket"></i> Logout
         </a>
      </li>
   </ul>
</nav>