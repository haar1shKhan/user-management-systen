<div class="sidebar-wrapper" sidebar-layout="stroke-svg">
    <div>
        <div class="logo-wrapper">
            <a href="{{ route('/') }}">
                <img class="img-fluid for-light" src="{{asset(config('settings.site_logo'))}}" alt="">
                <img class="img-fluid  for-dark" src="{{asset(config('settings.site_logo'))}}" alt="">
            </a>
            <div class="back-btn">
                <i class="fa fa-angle-left"></i>
            </div>
            <div class="toggle-sidebar">
                <i class="status_toggle middle sidebar-toggle" data-feather="grid"></i>
            </div>
        </div>
        <div class="logo-icon-wrapper">
            <a href="{{ route('/') }}">
                <img class="img-fluid" src="{{ asset('assets/images/logo/logo-icon.png') }}" alt="">
            </a>
        </div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow">
                <i data-feather="arrow-left"></i>
            </div>
            <div id="sidebar-menu">

                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn">
                        <div class="mobile-back text-end">
                            <span>Back</span>
                            <i class="fa fa-angle-right ps-2" aria-hidden="true"></i>
                        </div>
                    </li>

                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="lan-1">General</h6>
                        </div>
                    </li>

                    @can("dashboard_access")      
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('admin.dashboard') }}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-home') }}"></use>
                            </svg>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    @endcan

                    @can('leave_management_access')    
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-calendar') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-calendar') }}"></use>
                            </svg>

                            <span>Leave management</span></a>
                        <ul class="sidebar-submenu">
                            @can('long_leave_access')
                            <li>
                                <a class="" href="{{ route('admin.longLeave') }}">Request for Leave</a>
                            </li>
                            @endcan
                            @can('late_attendance_access')
                            <li>
                                <a class="" href="{{ route('admin.lateAttendance') }}">Late Attendance</a>
                            </li>
                            @endcan
                            @can('short_leave_access')
                            <li>
                                <a class="" href="{{ route('admin.short-leave') }}">Short Leave</a>
                            </li>
                            @endcan
                            {{-- <li><a class="" href="{{ route('admin.break') }}">Break</a></li> --}}

                        </ul>
                    </li>
                    @endcan

                    @can('leave_request_access')       
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('admin.leave.requests') }}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-calendar') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-calendar') }}"></use>
                            </svg>
                            <span>Leave Requests @if(config('count.total'))<span  class="text-white badge rounded-pill badge-danger">{{config('count.total')}}@endif</span> </span>
                        </a>
                    </li>
                    @endcan

                    @can("leave_manager_access")   
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-calendar') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-calendar') }}"></use>
                            </svg>

                            <span class="trans_leave_manager">Leave Manager</span>
                        </a>
                        <ul class="sidebar-submenu">
                            @can('leave_policy_access')
                            <li>
                                <a href="{{ route('admin.leaveSettings.leavePolicies') }}" class="trans_leave_policy">Leave Policies</a>
                            </li>
                            @endcan
                            @can('leave_entitlement_access')
                            <li>
                                <a href="{{ route('admin.leaveSettings.leaveEntitlement') }}" class="trans_leave_entitlements">Leave Entitlement</a>
                            </li>
                            @endcan
                        </ul>
                    </li>
                    @endcan


                    @can('system_access')
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-others') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-others') }}"></use>
                            </svg>
                            <span>نظام</span>
                        </a>
                        <ul class="sidebar-submenu">
                            @can('setting_access')
                            <li>
                                <a href="{{ route('admin.settings') }}">إعدادات</a>
                            </li>
                            @endcan
                            @can('user_management_access')
                            <li>
                                <a class="submenu-title" href="#">
                                    إدارة المستخدمين
                                    <span class="sub-arrow">
                                        <i class="fa fa-angle-right"></i>
                                    </span>
                                </a>
                                <ul class="nav-sub-childmenu submenu-content">
                                    @can('user_access')
                                    <li><a class="lan-5" href="{{ route('admin.users') }}">المستخدمين</a></li>
                                    @endcan
                                    @can('role_access')
                                    <li><a class="" href="{{ route('admin.roles') }}">الأدوار والأذونات</a></li>
                                    @endcan
                                    {{-- @can('permission_access')
                                    <li><a class="" href="{{ route('admin.permissions') }}">Permissions</a></li>
                                    @endcan --}}
                                </ul>
                            </li>
                            @endcan
                            {{-- MAINTANANCE PAGES DISABLED --}}
                            {{-- <li><a class="submenu-title" href="#">Maintanance<span class="sub-arrow"><i
                                            class="fa fa-angle-right"></i></span></a>
                                <ul class="nav-sub-childmenu submenu-content">
                                    <li><a href="{{ route('admin.backup') }}">Backup</a></li>
                                    <li><a href="{{ route('admin.error.log') }}">Error Log</a></li>
                                </ul>
                            </li> --}}
                        </ul>
                    </li>
                    @endcan
                    {{-- DISBALED --}}
                    {{-- <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav"
                            href="{{ route('admin.passport') }}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-form') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-form') }}"></use>
                            </svg>
                            <span>Passport Application</span></a>
                    </li>  --}}
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
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
