<aside class="left-sidebar bg-sidebar">
      <div id="sidebar" class="sidebar sidebar-with-footer">
        <!-- Aplication Brand -->
        <div class="app-brand">
          <a href="/index.html">
            <svg class="brand-icon" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid" width="30"
              height="33" viewBox="0 0 30 33">
              <g fill="none" fill-rule="evenodd">
                <path class="logo-fill-blue" fill="#7DBCFF" d="M0 4v25l8 4V0zM22 4v25l8 4V0z" />
                <path class="logo-fill-white" fill="#FFF" d="M11 4v25l8 4V0z" />
              </g>
            </svg>
            <span class="brand-name">Sleek Dashboard</span>
          </a>
        </div>
        <!-- begin sidebar scrollbar -->
        <div class="sidebar-scrollbar">

          <!-- sidebar menu -->
          <ul class="nav sidebar-inner" id="sidebar-menu">

            <li class="<?php if($currentPage =='pending-orders'){echo 'active';}?>">
              <a class="sidenav-item-link" href="index.php">
                <i class="mdi mdi-shopping"></i>
                <span class="nav-text">Pending Orders</span>
              </a>
            </li>

            <li class="<?php if($currentPage =='all-orders'){echo 'active';}?>">
              <a class="sidenav-item-link" href="all-orders.php">
                <i class="mdi mdi-basket"></i>
                <span class="nav-text">All Orders</span>
              </a>
            </li>

            <li class="<?php if($currentPage =='settings'){echo 'active';}?>">
              <a class="sidenav-item-link" href="settings.php">
                <i class="mdi mdi-settings"></i>
                <span class="nav-text">Settings</span>
              </a>
            </li>

            <li class="<?php if($currentPage =='change-password'){echo 'active';}?>">
              <a class="sidenav-item-link" href="change-password.php">
                <i class="mdi mdi-lock"></i>
                <span class="nav-text">Change Password</span>
              </a>
            </li>

          </ul>

        </div>

        <hr class="separator" />

        <ul class="nav sidebar-inner" id="sidebar-menu">
          <li>
            <a class="sidenav-item-link" href="../logout.php?logout">
              <i class="mdi mdi-exit-to-app"></i>
              <span class="nav-text">Logout</span>
            </a>
          </li>
        </ul>

      </div>
    </aside>