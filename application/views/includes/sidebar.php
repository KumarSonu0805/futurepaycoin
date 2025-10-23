<nav class="sidebar border-end" id="sidebar">
   <div class="text-center p-4 sidemenulogo">
      <img src="<?= file_url('assets/images/future-coin.png'); ?>" alt="Logo">
      <h5 class="mt-2">Future Pay Coin</h5>
   </div>
   <ul class="nav flex-column" id="sidebarAccordion">
      <div class="nav-linktitle">Member Dashboard</div>
      <li class="nav-item">
         <a class="nav-link" href="<?= base_url('home/'); ?>">
         <i class="fa-solid fa-house"></i> Home
         </a>
      </li>
      <li class="nav-item d-none">
         <a class="nav-link">
         <i class="fa-regular fa-square-plus"></i> New Registration
         </a>
      </li>
        <?php
            if($this->session->role=='member'){
        ?>
      <li class="nav-item">
         <a class="nav-link" data-bs-toggle="collapse" href="#profileMenu" role="button" aria-expanded="false" aria-controls="profileMenu">
         <i class="fa-solid fa-user"></i> Profile
         <i class="fas fa-chevron-down ms-auto"></i>
         </a>
         <div class="collapse" id="profileMenu" data-bs-parent="#sidebarAccordion">
            <ul class="nav flex-column ms-3">
               <li class="nav-item"><a class="nav-link" href="<?= base_url('profile/'); ?>">Profile</a></li>
               <li class="nav-item"><a class="nav-link" href="<?= base_url('changepassword/') ?>">Change Password</a></li>
            </ul>
         </div>
      </li>
        <?php
            }
       else{
        ?>
      <li class="nav-item">
         <a class="nav-link" href="<?= base_url('changepassword/') ?>">
         <i class="fa-regular fa-square-plus"></i> Change Password
         </a>
      </li>
       <?php
       }
        ?>
      <li class="nav-item">
         <a class="nav-link" data-bs-toggle="collapse" href="#membersMenu" role="button" aria-expanded="false" aria-controls="membersMenu">
         <i class="fa-solid fa-users"></i> Members
         <i class="fas fa-chevron-down ms-auto"></i>
         </a>
         <div class="collapse" id="membersMenu" data-bs-parent="#sidebarAccordion">
            <ul class="nav flex-column ms-3">
               <li class="nav-item"><a class="nav-link" href="<?= base_url('members/memberlist/'); ?>">Downline Members</a></li>
                <?php
                    if($this->session->role=='member'){
                ?>
               <li class="nav-item"><a class="nav-link" href="<?= base_url('members/directmembers/'); ?>">Direct Members</a></li>
                <?php
                    }
                ?>
            </ul>
         </div>
      </li>
      <li class="nav-item">
         <a class="nav-link" data-bs-toggle="collapse" href="#depositeMenu" role="button" aria-expanded="false" aria-controls="depositeMenu">
         <i class="fa-solid fa-money-bill-transfer"></i> Deposit
         <i class="fas fa-chevron-down ms-auto"></i>
         </a>
         <div class="collapse" id="depositeMenu" data-bs-parent="#sidebarAccordion">
            <ul class="nav flex-column ms-3">
               <li class="nav-item"><a class="nav-link" href="<?= base_url('deposit/'); ?>">Add Deposit</a></li>
               <li class="nav-item"><a class="nav-link" href="<?= base_url('deposit/depositlist/'); ?>">Deposit History</a></li>
            </ul>
         </div>
      </li>
      <li class="nav-item">
         <a class="nav-link" href="<?= base_url('logout/'); ?>">
         <i class="fa-solid fa-right-from-bracket"></i> Logout
         </a>
      </li>
   </ul>
</nav>