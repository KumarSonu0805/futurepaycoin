<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3 topmenubar">
   <button class="btn btn-outline-secondary d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-controls="mobileSidebar">
      <i class="fas fa-bars"></i>
      </button>
   <h4 class="mb-0">Dashboard</h4>
   <div class="d-flex align-items-center gap-3 topmenuadmin">
      <form class="search-bar d-none" onsubmit="return handleSearch(event)">
         <i class="fas fa-search search-icon" onclick="document.getElementById('searchForm').submit()"></i>
         <input type="text" id="searchInput" class="form-control" placeholder="Search here..." oninput="toggleClearBtn()">
         <button type="button" id="clearBtn" class="clear-btn" onclick="clearSearch()" style="display: none;">×</button>
      </form>
      <div class="dropdown">
         <a href="#" class="d-flex align-items-center text-decoration-none" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
         <img src="<?= file_url('assets/images/future-coin.png'); ?>" alt="Profile" width="36" class="rounded-circle">
         <span class="ms-2 fw-semibold text-dark d-none d-md-inline"></span>
         </a>
      <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
    <li>
        <div class="dropdown-profile d-flex align-items-center px-3 py-2">
            <img src="<?= file_url('assets/images/future-coin.png'); ?>" alt="future-coin">
            <div class="ms-2">
                <h5>Future Coin</h5>
                <p>@future-coin</p>
            </div>
        </div>
    </li>
    <li><hr class="dropdown-divider"></li>
    <li><a class="dropdown-item" href="<?= base_url('profile/') ?>"><i class="fas fa-user me-2"></i> Profile</a></li>
    <li><a class="dropdown-item text-danger" href="<?= base_url('logout/') ?>"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
</ul>

      </div>
   </div>
</div>