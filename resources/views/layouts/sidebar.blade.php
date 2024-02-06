<div class="sidebar-wrapper" sidebar-layout="stroke-svg">
    <div>
      <div class="logo-wrapper"><a href="{{ route('/')}}"><img class="img-fluid for-light" src="{{ asset('assets/images/logo/logo.png') }}" alt=""><img class="img-fluid for-dark" src="{{ asset('assets/images/logo/logo_dark.png') }}" alt=""></a>
        <div class="back-btn"><i class="fa fa-angle-left"></i></div>
        <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
      </div>
      <div class="logo-icon-wrapper"><a href="{{ route('/')}}"><img class="img-fluid" src="{{ asset('assets/images/logo/logo-icon.png') }}" alt=""></a></div>
      <nav class="sidebar-main">
        <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
        <div id="sidebar-menu">
          
          <ul class="sidebar-links" id="simple-bar">
            <li class="back-btn">
              <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
            </li>


            <li class="sidebar-main-title">
                <div>
                    <h6 class="lan-1">General</h6>
                </div>
            </li>
            <li class="sidebar-list">
                <a class="sidebar-link sidebar-title link-nav" href="#">
                    <svg class="stroke-icon">
                        <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                        <use href="{{ asset('assets/svg/icon-sprite.svg#fill-home') }}"></use>
                    </svg>
                    <span class="lan-3">Dashboard</span></a>
            </li>


            <li class="sidebar-list">
              <a class="sidebar-link sidebar-title"
                  href="#">
                  <svg class="stroke-icon">
                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-calendar') }}"></use>
                </svg>
                <svg class="fill-icon">
                  <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-calendar') }}"></use>
              </svg>

              <span >Leave management</span></a>
              <ul class="sidebar-submenu">
                <li><a class="" href="{{ route('admin.late-attendance') }}">Late Attendance</a></li>
                <li><a class="" href="{{ route('admin.shortLeave') }}">Short Leave</a></li>
                <li><a class="" href="{{ route('admin.longLeave') }}">Request for Leave</a></li>
                <li><a class="submenu-title" href="#">Leave Settings<span class="sub-arrow">
                  <i class="fa fa-angle-right"></i></span></a>
                        <ul class="nav-sub-childmenu submenu-content">
                            <li><a href="{{ route('admin.leaveSettings.leavePolicies') }}">Leave Policies</a></li>
                            <li><a href="{{ route('admin.leaveSettings.leaveEntitlement') }}">Leave Entitlement</a></li>
                        </ul>
               </li>
                  {{-- <li><a class="" href="{{ route('admin.break') }}">Break</a></li> --}}
                 
              </ul>
          </li>

        

          <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
                    <svg class="stroke-icon">
                        <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-others') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                        <use href="{{ asset('assets/svg/icon-sprite.svg#fill-others') }}"></use>
                    </svg><span>System</span></a>
                <ul class="sidebar-submenu">
                    <li><a href="{{ route('admin.settings') }}">Setting </a></li>

                    <li><a class="submenu-title" href="#">Localization<span class="sub-arrow"><i
                                    class="fa fa-angle-right"></i></span></a>
                        <ul class="nav-sub-childmenu submenu-content">
                            <li><a href="{{ route('admin.localization.longLeave') }}">Long Leave</a></li>
                        </ul>
                    </li>

                    <li><a class="submenu-title" href="#">Maintanance<span class="sub-arrow"><i
                                    class="fa fa-angle-right"></i></span></a>
                        <ul class="nav-sub-childmenu submenu-content">
                            <li><a href="{{ route('admin.backup') }}">Backup</a></li>
                            <li><a href="{{ route('admin.error.log') }}">Error Log</a></li>
                        </ul>
                    </li>
                    {{-- <li><a href="{{ route('admin.datatable-ext-autofill') }}">Ex. Data Tables</a></li> --}}
                </ul>
            </li>

          <li class="sidebar-list">
          <a class="sidebar-link sidebar-title link-nav" href="{{ route('admin.passport') }}">
            <svg class="stroke-icon">
                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-form') }}"></use>
            </svg>
            <svg class="fill-icon">
                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-form') }}"></use>
            </svg>
            <span>Passport Application</span>
            </a>
          </li>

          <li class="sidebar-list">
              <a class="sidebar-link sidebar-title"
                  href="#">
                  <svg class="stroke-icon">
                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-user') }}"></use>
                </svg>
                <svg class="fill-icon">
                  <use href="{{ asset('assets/svg/icon-sprite.svg#fill-user') }}"></use>
              </svg>

              <span >User management</span></a>
              <ul class="sidebar-submenu">
                  <li><a class="lan-5" href="{{ route('admin.users') }}">Users</a></li>
                  <li><a class="" href="{{ route('admin.roles') }}">Roles</a></li>
                  <li><a class="" href="{{ route('admin.permissions') }}">Permissions</a></li>
                 
              </ul>
          </li>


           
          

          <li class="sidebar-main-title">
            <div>
                <h6>Support</h6>
            </div>
        </li>
          <li class="sidebar-list"> 
            <a class="sidebar-link sidebar-title link-nav" href="{{ route('admin.feedback') }}">
            <svg class="stroke-icon">
                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-email') }}"></use>
            </svg>
            <svg class="fill-icon">
                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-email') }}"></use>
            </svg><span>Feedback</span></a>
          </li>
          <li class="sidebar-list"> 
            <a class="sidebar-link sidebar-title link-nav" href="{{ route('admin.feedback') }}">
            <svg class="stroke-icon">
                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-email') }}"></use>
            </svg>
            <svg class="fill-icon">
                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-email') }}"></use>
            </svg><span>Raise Support</span></a>
          </li>
            
          </ul>
        </div>
        <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
      </nav>
    </div>
  </div>