<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />

        <title>@yield('title') - {{$generalsetting->name}}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{asset($generalsetting->favicon)}}" />
        <!-- Bootstrap css -->
        <link href="{{asset('public/backend/')}}/assets/css/bootstrap.min.css?ver=1.1" rel="stylesheet" type="text/css" />
        <!-- App css -->
        <link href="{{asset('public/backend/')}}/assets/css/app.min.css?ver=1.8" rel="stylesheet" type="text/css" />
        <!-- icons -->
        <link href="{{asset('public/backend/')}}/assets/css/icons.min.css?ver=1.1" rel="stylesheet" type="text/css" />
        <!-- toastr css -->
        <link rel="stylesheet" href="{{asset('public/backend/')}}/assets/css/toastr.min.css?ver=1.1" />

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap">

        <!-- Summernote css -->
        <link href="{{asset('public/backend/')}}/assets/summernote-lite/summernote-lite.css?ver=1.1" rel="stylesheet" type="text/css" />
        <!-- custom css -->
        <link href="{{asset('public/backend/')}}/assets/css/custom.css?ver=1.10.3" rel="stylesheet" type="text/css" />
        <meta name="csrf-token" content="{{csrf_token()}}" />
<style>

tr:hover {
    background: #f3f5fa;
}

.notification-list .notify-item {
    padding: 12px 20px!important;
    border-bottom: 1px solid #ddd;
}

#sidebar-menu>ul>li>a {
    color: #fff;
}

ul#side-menu li {
    transition: all .8s ease;
}
ul#side-menu li:hover {
    background:#256EFE;
    transition: all .8s ease;
}
#sidebar-menu .menuitem-active .active {
    color: var(--ct-menu-item-active);
    background: #256EFE;
    color: #fff;
}

#sidebar-menu .menu-title {
    color: #fff;
    margin-top: 0 !important;
}
.nav-second-level li a:focus, .nav-second-level li a {
    transition: all .5s ease !important;
}

.nav-second-level li a:focus, .nav-second-level li a:hover {
    background: blue;
    color: #fff;
    transition: all .5s ease !important;
}

.notification-list .notify-item .user-msg {
         margin-left: 0;
}

#sidebar-menu>ul>li>a:active, #sidebar-menu>ul>li>a:focus, #sidebar-menu>ul>li>a:hover {
    color: #fff;
}
.nav-second-level li a {
    color: #fff;
}

  @media only screen and (min-width: 2200px) and (max-width: 2700px) {
     .content-page {
          padding: 25px !important;
          padding-bottom:90px !important;
         }


     }

    @media only screen and (min-width: 320px) and (max-width: 767px) {
        .menu_bar {
            display:block;
            position: absolute !important;
            top: 0 !important;
            left: 62px !important;
            color: #000 !important;
        }
        .footer {
            position: inherit;
        }
        .content-page {
            width: 100%;
        }
        .right-bar.cust_right_bar {
            display: none;
        }
        .overview_inner {
            grid-template-columns: 1fr 1fr;
        }
        .copyright_left p {
            font-size: 14px;
        }
        .footer_menu ul {
            text-align: center;
        }
        .footer_menu li a {
            font-size: 14px;
            color: #606060;
        }
        body {
            padding-bottom: 0;
        }

        .sidebar_footer ul {
            bottom: 120px !important;
        }
    }
    </style>

        <!-- Head js -->
        @yield('css')
        <script src="{{asset('public/backend/')}}/assets/js/head.js"></script>
    </head>

    <!-- body start -->
<body data-layout-mode="default" data-theme="light" data-layout-width="fluid" data-topbar-color="dark" data-menu-position="fixed" data-leftbar-color="light" data-leftbar-size="default" data-sidebar-user="false">
        <!-- Begin page -->
        <div>
            <!-- Topbar Start -->
            <div class="navbar-custom nav_custom">
                <div class="container-fluid">
                    <div class="top_right">
                        <div class="search_inn">
                           <div class="s_left">
                                <ul class="list-unstyled topnav-menu mb-0 ">
                                <li class="d-none d-lg-block master_search_form">
                                    <form class="app-search cust_app_search">
                                        <div class="app-search-box dropdown">
                                            <div class="input-group">
                                                <button class="btn input-group-text" type="submit">
                                                  <img src="{{asset('public/backend')}}/assets/images/search.png" alt="">
                                                </button>
                                                <input type="search" class="form-control search_click" placeholder="Search Here" name="keyword" id="top-search" />
                                            </div>
                                        </div>
                                    </form>
                                    <div class="search_result"></div>
                                </li>

                              </ul>
                              </div>

                        <div class="s_right">
                            <ul class="list-unstyled topnav-menu mb-0 float-end unread_message">

                                @if(auth()->user()->hasRole('Superadmin'))
                                <li class="dropdown notification-list topbar-dropdown">
                                    <a class="nav-link dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                        <img src="{{asset('public/backend')}}/assets/images/comment-customer.png" alt="" width="37">
                                       <span class="count_number">{{$ureadmessage->count()}}</span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end dropdown-lg">

                                        <!-- item-->
                                        <div class="dropdown-item noti-title">
                                            <h5 class="m-0">Uread Message
                                            </h5>
                                        </div>

                                        <div class="noti-scroll" data-simplebar>
                                            @foreach($ureadmessage as $umessage)
                                            <!-- item-->
                                            @if($umessage->order_id != null)
                                            <a href="{{url('admin/order/details/'.$umessage->order_id)}}" class="dropdown-item notify-item active">
                                                <div class="notify-icon">
                                                    <img src="{{asset($umessage->customer->image)}}" class="img-fluid rounded-circle" alt="" /> </div>
                                                <p class="notify-details">{{$umessage->customer->fullName}}</p>
                                                <p class="text-muted mb-0 user-msg">
                                                    <small>{{$umessage->message}}</small>
                                                </p>
                                            </a>
                                            @else
                                            <a href="{{url('admin/support/chat?order_id=0'.'&customer_id='.$umessage->customer_id)}}" class="dropdown-item notify-item active">
                                                <div class="notify-icon">
                                                    <img src="{{asset($umessage->customer->image)}}" class="img-fluid rounded-circle" alt="" /> </div>
                                                <p class="notify-details">{{$umessage->customer->fullName}}</p>
                                                <p class="text-muted mb-0 user-msg">
                                                    <small>{{$umessage->message}}</small>
                                                </p>
                                            </a>
                                            @endif
                                            @endforeach
                                        </div>

                                        <!-- All-->

                                    </div>
                                </li>
                                @else
                                <li class="dropdown notification-list topbar-dropdown">
                                    <a class="nav-link dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                        <img src="{{asset('public/backend')}}/assets/images/comment-customer.png" alt="" width="37">
                                       <span class="count_number">{{$asignureadmessage->count()}}</span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end dropdown-lg">

                                        <!-- item-->
                                        <div class="dropdown-item noti-title">
                                            <h5 class="m-0">Uread Message
                                            </h5>
                                        </div>

                                        <div class="noti-scroll" data-simplebar>
                                            @foreach($asignureadmessage as $asumessage)
                                            <!-- item-->
                                            <a href="{{url('admin/order/details/'.$asumessage->order_id)}}" class="dropdown-item notify-item active">
                                                <div class="notify-icon">
                                                    <img src="{{asset($asumessage->customer->image)}}" class="img-fluid rounded-circle" alt="" /> </div>
                                                <p class="notify-details">{{$asumessage->customer->fullName}}</p>
                                                <p class="text-muted mb-0 user-msg">
                                                    <small>{{$asumessage->message}}</small>
                                                </p>
                                            </a>
                                            @endforeach
                                        </div>

                                        <!-- All-->

                                    </div>
                                </li>
                                @endif

                                @if(auth()->user()->hasRole('Superadmin'))
                                <li class="dropdown notification-list topbar-dropdown">
                                    <a class="nav-link dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                        <img src="{{asset('public/backend')}}/assets/images/bell-customer.png" alt="" width="30">
                                       <span class="count_number">{{$unreadnotifications->count()}}</span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end dropdown-lg">

                                        <!-- item-->
                                        <div class="dropdown-item noti-title">
                                            <h5 class="m-0">Uread Notification
                                            </h5>
                                        </div>

                                        <div class="noti-scroll" data-simplebar>
                                            @foreach($unreadnotifications as $unotification)
                                            <!-- item-->
                                            <a href="{{url($unotification->link)}}" class="dropdown-item notify-item active">
                                                <p class="text-muted mb-0 user-msg">
                                                    <small>{{$unotification->title}}</small>
                                                </p>
                                            </a>
                                            @endforeach
                                        </div>

                                        <!-- All-->

                                    </div>
                                </li>
                                @else
                                <li class="dropdown notification-list topbar-dropdown">
                                    <a class="nav-link dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                        <img src="{{asset('public/backend')}}/assets/images/bell-customer.png" alt="" width="30">
                                       <span class="count_number">{{$asignunreadnotifications->count()}}</span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end dropdown-lg">

                                        <!-- item-->
                                        <div class="dropdown-item noti-title">
                                            <h5 class="m-0">Uread Notification
                                            </h5>
                                        </div>

                                        <div class="noti-scroll" data-simplebar>
                                            @foreach($asignunreadnotifications as $asunotification)
                                            <!-- item-->
                                            <a href="{{url($asunotification->link)}}" class="dropdown-item notify-item active">
                                                <p class="text-muted mb-0 user-msg">
                                                    <small>{{$asunotification->title}}</small>
                                                </p>
                                            </a>
                                            @endforeach
                                        </div>

                                        <!-- All-->

                                    </div>
                                </li>
                                @endif

                            </ul>
                        </div>


                        </div>


                        <ul class="list-unstyled topnav-menu float-start mb-0 ">


                        <li class="dropdown notification-list topbar-dropdown">
                            <a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <img src="{{asset(Auth::user()->image)}}" alt="user-image" class="rounded-circle" />
                                <span class="pro-user-name ms-1 pro_user_name"> {{Auth::user()->name}} <i class="mdi mdi-chevron-down"></i> </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end profile-dropdown">
                                <!-- item-->
                                <div class="dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Welcome !</h6>
                                </div>

                                <!-- item-->
                                <a href="{{route('dashboard')}}" class="dropdown-item notify-item">
                                    <i class="fe-user"></i>
                                    <span>Dashboard</span>
                                </a>

                                <!-- item-->
                                <a href="{{route('change_password')}}" class="dropdown-item notify-item">
                                    <i class="fe-settings"></i>
                                    <span>Change Password</span>
                                </a>

                                <!-- item-->
                                <a href="{{route('locked')}}" class="dropdown-item notify-item">
                                    <i class="fe-lock"></i>
                                    <span>Lock Screen</span>
                                </a>

                                <a href="{{route('support_list')}}" class="dropdown-item notify-item">
                                    <i class="fe-send"></i>
                                    <span>Support Chat <span class="uread_support uread__count">{{$unreadsupport}}</span></span>
                                </a>

                                <div class="dropdown-divider"></div>

                                <!-- item-->
                                <a
                                    href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                                    class="dropdown-item notify-item"
                                >
                                    <i class="fe-log-out me-1"></i>
                                    <span>Logout</span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>


                    </ul>
                    </div>


                    <!-- LOGO -->
                    <div class="logo-box cust_logo">
                        <a href="{{url('admin/dashboard')}}" class="logo logo-dark text-center">
                            <span class="logo-sm">
                                 <img src="{{asset($generalsetting->dark_logo)}}" height="20" width="45" alt=""/>
                            </span>
                            <span class="logo-lg">
                                 <img src="{{asset($generalsetting->dark_logo)}}"  alt=""/>
                            </span>
                        </a>

                        <a href="{{url('admin/dashboard')}}" class="logo logo-light text-center">
                            <span class="logo-sm">
                                 <img src="{{asset($generalsetting->dark_logo)}}" height="20" width="45" alt=""/>
                            </span>
                            <span class="logo-lg">
                                <img src="{{asset($generalsetting->dark_logo)}}" alt=""/>
                            </span>
                        </a>
                    </div>
                    <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
                        <li>
                            <button class="button-menu-mobile waves-effect waves-light menu_bar">
                                <i class="fe-menu"></i>
                            </button>
                        </li>

                        <li>
                            <!-- Mobile menu toggle (Horizontal Layout)-->
                            <a class="navbar-toggle nav-link" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                                <div class="lines">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </a>
                            <!-- End mobile menu toggle-->
                        </li>


                    </ul>
                    <div class="clearfix"></div>

                </div>
            </div>
            <!-- end Topbar -->
            <div class="main_wrapper_area row">
            <!-- ========== Left Sidebar Start ========== -->
            <div class="left-side-menu col-md-2">
                <div class="h-100" data-simplebar>
                    <!-- User box -->
                    <div class="user-box text-center">
                        <img src="{{asset('public/backend/')}}/assets/images/users/user-1.jpg" alt="user-img" title="Mat Helme" class="rounded-circle avatar-md" />
                        <div class="dropdown">
                            <a href="javascript: void(0);" class="text-dark dropdown-toggle h5 mt-2 mb-1 d-block" data-bs-toggle="dropdown">{{Auth::user()->name}}</a>
                            <div class="dropdown-menu user-pro-dropdown">
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="fe-user me-1"></i>
                                    <span>My Account</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="fe-settings me-1"></i>
                                    <span>Settings</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="fe-lock me-1"></i>
                                    <span>Lock Screen</span>
                                </a>

                                <!-- item-->
                                <a
                                    href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();"
                                    class="dropdown-item notify-item"
                                >
                                    <i class="fe-log-out me-1"></i>
                                    <span>Logout</span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                        <p class="text-muted">Admin Head</p>
                    </div>

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <ul id="side-menu">
                            <li>
                                <a href="{{url('admin/dashboard')}}">
                                    <i data-feather="grid"></i>
                                    <span> Dashboard </span>
                                </a>
                            </li>
                            <!-- nav items -->
                            <li>
                                <a href="{{route('ordermanage')}}">
                                    <i data-feather="shopping-bag"></i>
                                    <span>Manage Order</span>
                                </a>
                            </li>
                            <!-- nav items -->

                            <li>
                                <a href="#siebar-invoice" data-bs-toggle="collapse">
                                   <i data-feather="tablet"></i>
                                    <span>Create Invoice </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="siebar-invoice">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="{{route('createinvoice')}}">Create Invoice</a>
                                        </li>
                                        <li>
                                            <a href="{{route('lastestinvoice')}}">Latest Invoice</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!-- nav items -->
                            <li>
                                <a href="#siebar-user" data-bs-toggle="collapse">
                                    <i data-feather="user-plus"></i>
                                    <span>Users & Role</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="siebar-user">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="{{route('users.index')}}">Users</a>
                                        </li>
                                        <li>
                                            <a href="{{route('roles.index')}}">Role</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!-- nav items -->
                            <li>
                                <a href="{{route('permissions.index')}}">
                                    <i data-feather="lock"></i>
                                    <span> Permissions </span>
                                </a>

                            </li>
                            <!-- nav items end -->


                            <li>
                                <a href="#siebar-about" data-bs-toggle="collapse">
                                    <i data-feather="briefcase"></i>
                                    <span> Services </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="siebar-about">
                                    <ul class="nav-second-level">

                                        <li>
                                            <a href="{{route('services.index')}}">All Service</a>
                                        </li>
                                        <li>
                                            <a href="{{route('services.create')}}">New Service</a>
                                        </li>

                                    </ul>
                                </div>
                            </li>

                            <li>
                                <a href="#siebar-services" data-bs-toggle="collapse">
                                    <i data-feather="codesandbox"></i>
                                    <span> Our Products</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="siebar-services">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="{{route('products.index')}}">Products</a>
                                        </li>

                                        <li>
                                            <a href="{{route('researchworks.index')}}">Research Work</a>
                                        </li>
                                        <li>
                                            <a href="{{route('faq.index')}}">Faq</a>
                                        </li>
                                        <li>
                                            <a href="{{route('portfolios.index')}}">Portfolios</a>
                                        </li>

                                    </ul>
                                </div>
                            </li>

                            <li>
                                <a href="#siebar-packages" data-bs-toggle="collapse">
                                    <i data-feather="package"></i>
                                    <span> Pricing</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="siebar-packages">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="{{route('packages.index')}}">Package</a>
                                        </li>
                                        <li>
                                            <a href="{{route('attributes.index')}}">Attribute</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>


                            <li>
                                <a href="{{ route('team.index') }}">
                                    <i data-feather="user-plus"></i>
                                    <span> Team Member </span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="{{ route('partner.index') }}">
                                    <i data-feather="user"></i>
                                    <span> Partner </span>
                                </a>
                            </li>

                            <!-- nav items end -->
                            <li>
                                <a href="{{route('blogcategories.index')}}">
                                    <i data-feather="crosshair"></i>
                                    <span> Blog Category </span>
                                </a>
                            </li>
                            <!-- nav items end -->
                            <li>
                                <a href="{{route('blogs.index')}}">
                                    <i data-feather="dribbble"></i>
                                    <span> Blogs </span>
                                </a>

                            </li>
                            <!-- nav items end -->

                            <li>
                                <a href="{{route('users.customer_list')}}">
                                    <i data-feather="users"></i>
                                    <span>Customers </span>
                                </a>
                            </li>
                            <li>
                                <a href="#siebar-home" data-bs-toggle="collapse">
                                    <i data-feather="home"></i>
                                    <span> Home Page </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="siebar-home">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="{{route('sliders.index')}}">Slider</a>
                                        </li>
                                        <li>
                                            <a href="{{route('startworkings.index')}}">Start Working</a>
                                        </li>
                                        <li>
                                            <a href="{{route('roiseo.index')}}">Roi Seo</a>
                                        </li>
                                        <li>
                                            <a href="{{route('specialservices.index')}}">Special Service</a>
                                        </li>
                                        <li>
                                            <a href="{{route('whychooses.index')}}">Whychoose</a>
                                        </li>
                                        <li>
                                            <a href="{{route('whychooseitems.index')}}">Whychooseitem</a>
                                        </li>
                                        <li>
                                            <a href="{{route('businessgrow.index')}}">Business Grow</a>
                                        </li>
                                        <li>
                                            <a href="{{route('success.index')}}">Success</a>
                                        </li>
                                        <li>
                                            <a href="{{route('testimonials.index')}}">Testimonial</a>
                                        </li>
                                        <li>
                                            <a href="{{route('clients.index')}}">Clients</a>
                                        </li>
                                        <li>
                                            <a href="{{route('analysis.index')}}">Analysis</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!-- nav items end -->
                            <li>
                                <a href="#siebar-about" data-bs-toggle="collapse">
                                    <i data-feather="user-check"></i>
                                    <span> About Page </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="siebar-about">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="{{route('about.index')}}">About</a>
                                        </li>
                                        <li>
                                            <a href="{{route('videos.index')}}">Videos</a>
                                        </li>
                                        <li>
                                            <a href="{{route('aboutcounter.index')}}">Counter</a>
                                        </li>
                                        <li>
                                            <a href="{{route('aboutfaq.index')}}">Faq</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!-- nav items end -->

                            <!-- nav items end -->

                            <!-- nav items end -->
                            <li>
                                <a href="{{route('state.index')}}">
                                    <i data-feather="flag"></i>
                                    <span> State</span>
                                </a>
                            </li>
                            <!-- nav items end -->
                             <li>
                                <a href="{{route('blogs.comment')}}">
                                    <i data-feather="message-circle"></i>
                                    <span> Comment</span>
                                </a>
                            </li>
                            <!-- nav items end -->
                             <li>
                                <a href="{{route('review')}}">
                                    <i data-feather="message-circle"></i>
                                    <span> Review</span>
                                </a>
                            </li>
                            <!-- nav items end -->
                            <li>
                                <a href="#siebar-sitesetting" data-bs-toggle="collapse">
                                    <i data-feather="settings"></i>
                                    <span> Site Setting </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="siebar-sitesetting">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="{{route('couponcode.index')}}">Coupon Code</a>
                                        </li>
                                        <!--<li>-->
                                        <!--    <a href="{{route('settings.index')}}">General Setting</a>-->
                                        <!--</li>-->
                                        <li>
                                            <a href="{{route('socialmedias.index')}}">Social Media</a>
                                        </li>
                                        <li>
                                            <a href="{{route('contact.index')}}">Contact</a>
                                        </li>
                                        <li>
                                            <a href="{{route('createpage.index')}}">Createpage</a>
                                        </li>
                                        <li>
                                            <a href="{{route('pagetitle.index')}}">Page Title</a>
                                        </li>
                                        <li>
                                            <a href="{{route('sectiontitle.index')}}">Section Title</a>
                                        </li>
                                        <li>
                                            <a href="{{route('supportitem.index')}}">Support Item</a>
                                        </li>
                                        <li>
                                            <a href="{{route('transparent.index')}}">Transparent</a>
                                        </li>
                                        <li>
                                            <a href="{{route('needleitem.index')}}">Needleitem</a>
                                        </li>

                                    </ul>
                                </div>
                            </li>
                            <hr>
                             <li class="desk_hide">
                                   <a href="{{route('settings.index')}}">
                                    <i data-feather="dribbble"></i>
                                    <span> Setting </span>
                                </a>

                              </li>
                              <li class="desk_hide">
                                   <a href="{{route('support_list')}}">
                                     <i class="fe-send"></i>
                                    <span> Support Chat <span class="uread_support uread__count">{{$unreadsupport}}</span></span>
                                </a>

                              </li>

                             <li class="desk_hide">
                                 <a
                                    href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                                    class="dropdown-item notify-item"
                                >
                                    <i data-feather="unlock"></i>
                                    <span>Logout</span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>



                        </ul>


                    </div>
                    <!-- End Sidebar -->

                    <div class="clearfix"></div>
                </div>
                <!-- Sidebar -left -->
                <div class="sidebar_footer">
                            <!-- nav items end -->
                            <ul>
                              <li>
                                   <a href="{{route('settings.index')}}">
                                    <i data-feather="dribbble"></i>
                                    <span> Setting </span>
                                </a>

                              </li>

                              <li>
                                   <a href="{{route('support_list')}}">
                                     <i class="fe-send"></i>
                                    <span> Support Chat <span class="uread_support uread__count">{{$unreadsupport}}</span></span>
                                </a>

                              </li>

                             <li>
                                 <a
                                    href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                                    class="dropdown-item notify-item"
                                >
                                    <i data-feather="unlock"></i>
                                    <span>Logout</span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                            <!-- nav items end -->
                            </ul>

                        </div>
            </div>
            <!-- Left Sidebar End -->

            <div class="content-page col-md-8">
                <div class="content">
                    @yield('content')
                </div>
                <!-- content -->


            </div>
            <!-- Right Sidebar -->
        <div class="right-bar cust_right_bar col-md-2">
            <div data-simplebar class="h-100">
                <div class="noty_inner sidebar_message">
                    <div class="noty_item">
                      <h2>Notifications</h2>
                    </div>
                    @if(auth()->user()->hasRole('Superadmin'))
                    @foreach($allnotifications as $key=>$value)
                    <div class="noty_item @if($value->status == 'unread') unread @endif">
                      <a href="{{url($value->link)}}">
                       <p> {{$value->title}}
                        </p>
                      <span>{{$value->created_at->diffForHumans()}}</span>
                      </a>
                    </div>
                    @endforeach
                    @else
                    @foreach($asignallnotifications as $key=>$value)
                    <div class="noty_item @if($value->status == 'unread') unread @endif">
                      <a href="{{url($value->link)}}">
                       <p> {{$value->title}}
                        </p>
                      <span>{{$value->created_at->diffForHumans()}}</span>
                      </a>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
            <!-- end slimscroll-menu-->
        </div>
        <!-- /Right-bar -->

        </div>
        </div>
        <!-- END wrapper -->
        <!-- Footer Start -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="copyright_left">
                            <p>© {{date('Y')}} Rabbi IT Firm - All Right Reserved.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="copyright_right">
                            <div class="footer_menu">
                                <ul>
                                    @foreach($backpages as $key=>$value)
                                    <li><a href="{{'https://extremeranks.com/morepage/'.$value->slug}}" target="_blank">{{$value->pagename}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->



        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- Vendor js -->
        <!-- Vendor js -->
        <script src="{{asset('public/backend/')}}/assets/js/vendor.min.js"></script>
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <!-- App js -->
        <script src="{{asset('public/backend/')}}/assets/js/app.min.js"></script>
        <script src="{{asset('public/backend/')}}/assets/js/toastr.min.js"></script>
        <script src="{{asset('public/backend/')}}/assets/summernote-lite/summernote-lite.js"></script>
        {!! Toastr::message() !!}
        <script src="{{asset('public/backend/')}}/assets/js/sweetalert.min.js"></script>
        <script type="text/javascript">
            $(".delete-confirm").click(function (event) {
                var form = $(this).closest("form");
                event.preventDefault();
                swal({
                    title: `Are you sure you want to delete this record?`,
                    text: "If you delete this, it will be gone forever.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
            });
            $(".change-confirm").click(function (event) {
                var form = $(this).closest("form");
                event.preventDefault();
                swal({
                    title: `Are you sure you want to change this record?`,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
            });
        </script>

        <script>
          $('.summernote').summernote({
            height:250,
            callbacks: {
          // Clear all formatting of the pasted text
          onPaste: function (e) {
            var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
            e.preventDefault();
            setTimeout( function(){
              document.execCommand( 'insertText', false, bufferText );
            }, 300 );

          }
        }
          });
        </script>

        <script>
            $(".category").change(function () {
                var ajaxId = $(this).val();
                if (ajaxId) {
                  $.ajax({
                    type: "GET",
                    url: "{{url('ajax-package')}}?category_id=" + ajaxId,
                    success: function (res) {
                      if (res) {
                        $("#package_id").empty();
                        $("#package_id").append('<option value="0">Select..</option>');
                        $.each(res, function (key, value) {
                          $("#package_id").append('<option value="' + key + '">' + value + "</option>");
                        });
                      } else {
                        $("#package_id").empty();
                      }
                    },
                  });
                } else {
                  $("#package_id").empty();
                  $("#package_id").empty();
                }
          });

            $(".category").change(function () {
                var ajaxId = $(this).val();
                if (ajaxId) {
                  $.ajax({
                    type: "GET",
                    url: "{{url('ajax-attribute')}}?category_id=" + ajaxId,
                    success: function (res) {
                      if (res) {
                        $("#attribute_id").empty();
                        $("#attribute_id").append('<option value="0">Select..</option>');
                        $.each(res, function (key, value) {
                          $("#attribute_id").append('<option value="' + key + '">' + value + "</option>");
                        });
                      } else {
                        $("#attribute_id").empty();
                      }
                    },
                  });
                } else {
                  $("#attribute_id").empty();
                  $("#attribute_id").empty();
                }
          });

        </script>

        @yield('script')
        <script>
          $('.search_click').on('keyup change',function(){
              var keyword = $(this).val();
              $.ajax({
                 type:"GET",
                 data:{'keyword':keyword},
                 url:"{{route('admin.search')}}",
                 success:function(orders){
                  if(orders){
                      $(".search_result").html(orders);
                  }else{
                     $(".search_result").empty();
                  }
                 }
              });
         });
      </script>

      <script>
        $(document).ready(function() {
            $('.order_collapse').on('show.bs.collapse', function() {
                // Close any other open collapses
                $('.order_collapse').not(this).collapse('hide');
            });
        });
    </script>
   <script>
        function fetchSupport() {
            $.ajax({
                type: "GET",
                url: "{{ route('unread_support') }}",
                success: function (res) {
                    if (res) {
                        $(".uread_support").html(res.unreadsupport);
                    } else {

                    }
                },
            });
        }
        setInterval(fetchSupport, 2000);
    </script>

    <script>
        let refreshInterval;
        function startAutoRefresh() {
            refreshInterval = setInterval(fetchMessage, 2000);
        }
        function stopAutoRefresh() {
            clearInterval(refreshInterval);
        }
        function fetchMessage() {
            $.ajax({
                type: "GET",
                url: "{{ route('unread_message') }}",
                success: function (data) {
                    if (data) {
                        $(".unread_message").html(data);
                    } else {

                    }
                },
            });
        }
        startAutoRefresh();
        $(".unread_message").mouseenter(stopAutoRefresh);
        $(".unread_message").mouseleave(startAutoRefresh);
    </script>

    <script>
        let refreshInterval2;
        function startAutoRefresh2() {
            refreshInterval2 = setInterval(fetchSidebar, 2000);
        }
        function stopAutoRefresh2() {
            clearInterval(refreshInterval2);
        }
        function fetchSidebar() {
            $.ajax({
                type: "GET",
                url: "{{ route('sidebar_message') }}",
                success: function (data) {
                    if (data) {
                        $(".sidebar_message").html(data);
                    } else {

                    }
                },
            });
        }
        startAutoRefresh2();
        $(".sidebar_message").mouseenter(stopAutoRefresh2);
        $(".sidebar_message").mouseleave(startAutoRefresh2);
    </script>


    </body>
</html>
