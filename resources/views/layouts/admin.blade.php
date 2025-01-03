<!DOCTYPE html>
<html lang="en">
@include('dashboard.partials.head')
@stack('styles')
<body>

<div id="app">
    @include('dashboard.partials.sidebar')
    <div class="content-wrapper">
        <nav class="top-toolbar navbar navbar-mobile navbar-tablet">
            <ul class="navbar-nav nav-left">
                <li class="nav-item">
                    <a href="javascript:void(0)" data-toggle-state="aside-left-open">
                        <i class="icon dripicons-align-left"></i>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav nav-center site-logo">
                <li>
                    <a href="index.html">
                        <div class="logo_mobile">
                            <svg id="logo_mobile" width="27" height="27" viewBox="0 0 54.03 56.55">
                                <defs>
                                    <linearGradient id="logo_background_mobile_color">
                                        <stop class="stop1" offset="0%"/>
                                        <stop class="stop2" offset="50%"/>
                                        <stop class="stop3" offset="100%"/>
                                    </linearGradient>
                                </defs>
                                <path id="logo_path_mobile" class="cls-2" d="M90.32,0c14.2-.28,22.78,7.91,26.56,18.24a39.17,39.17,0,0,1,1,4.17l.13,1.5A15.25,15.25,0,0,1,118.1,29v.72l-.51,3.13a30.47,30.47,0,0,1-3.33,8,15.29,15.29,0,0,1-2.5,3.52l.06.07c.57.88,1.43,1.58,2,2.41,1.1,1.49,2.36,2.81,3.46,4.3.41.55,1,1,1.41,1.56.68.92,1.16,1.89.32,3.06-.08.12-.08.24-.19.33a2.39,2.39,0,0,1-2.62.07,4.09,4.09,0,0,1-.7-.91c-.63-.85-1.41-1.61-2-2.48-1-1.42-2.33-2.67-3.39-4.1a16.77,16.77,0,0,1-1.15-1.37c-.11,0-.06,0-.13.07-.41.14-.65.55-1,.78-.72.54-1.49,1.08-2.24,1.56A29.5,29.5,0,0,1,97.81,53c-.83.24-1.6.18-2.5.39a16.68,16.68,0,0,1-3.65.26H90.58L88,53.36A36.87,36.87,0,0,1,82.71,52a27.15,27.15,0,0,1-15.1-14.66c-.47-1.1-.7-2.17-1.09-3.39-1-3-1.45-8.86-.51-12.38a29,29,0,0,1,2.56-7.36c3.56-6,7.41-9.77,14.08-12.57a34.92,34.92,0,0,1,4.8-1.3Zm.13,4.1c-.45.27-1.66.11-2.24.26a32.65,32.65,0,0,0-4.74,1.37A23,23,0,0,0,71,18.7,24,24,0,0,0,71.13,35c2.78,6.66,7.2,11.06,14.21,13.42,1.16.39,2.52.59,3.84.91l1.47.07a7.08,7.08,0,0,0,2.43,0H94c.89-.21,1.9-.28,2.75-.46V48.8A7.6,7.6,0,0,1,95.19,47c-.78-1-1.83-1.92-2.62-3s-1.86-1.84-2.62-2.87c-2-2.7-4.45-5.1-6.66-7.62-.57-.66-1.14-1.32-1.66-2-.22-.29-.59-.51-.77-.85a2.26,2.26,0,0,1,.58-2.61,2.39,2.39,0,0,1,2.24-.2,4.7,4.7,0,0,1,1.22,1.3l.51.46c.5.68,1,1.32,1.6,2,2.07,2.37,4.38,4.62,6.27,7.17.94,1.26,2.19,2.3,3.14,3.58l1,1c.82,1.1,1.8,2,2.62,3.13.26.35.65.6.9,1A23.06,23.06,0,0,0,105,45c.37-.27,1-.51,1.15-1h-.06c-.18-.51-.73-.83-1-1.24-.74-1-1.64-1.88-2.37-2.87-1.8-2.44-3.89-4.6-5.7-7-.61-.82-1.44-1.52-2-2.34-.85-1.16-3.82-3.73-1.54-5.41a2.27,2.27,0,0,1,1.86-.26c.9.37,2.33,2.43,2.94,3.26s1.27,1.31,1.79,2c1.44,1.95,3.11,3.66,4.54,5.6.41.55,1,1,1.41,1.56.66.89,1.46,1.66,2.11,2.54.29.39.61,1.06,1.09,1.24.54-1,1.34-1.84,1.92-2.8a25.69,25.69,0,0,0,2.5-6.32c1.27-4.51.32-10.37-1.15-13.81A22.48,22.48,0,0,0,100.75,5.94a35.12,35.12,0,0,0-6.08-1.69A20.59,20.59,0,0,0,90.45,4.11Z" transform="translate(-65.5)" fill="url(#logo_background_mobile_color)"/>
                            </svg>
                        </div>
                        <span class="brand-text">QuantumPro</span>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav nav-right">
                <li class="nav-item">
                    <a href="javascript:void(0)" data-toggle-state="mobile-topbar-toggle">
                        <i class="icon dripicons-dots-3 rotate-90"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <nav class="top-toolbar navbar navbar-desktop flex-nowrap">
            <ul class="navbar-nav nav-right">
{{--                <li class="nav-item">--}}
{{--                    <a href="javascript:void(0)" class="open-search-button" data-q-action="open-site-search">--}}
{{--                        <i class="icon dripicons-search"></i>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li class="nav-item dropdown dropdown-menu-lg">--}}
{{--                    <a href="javascript:void(0)" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">--}}
{{--                        <i class="icon dripicons-view-apps"></i>--}}
{{--                    </a>--}}
{{--                    <div class="dropdown-menu dropdown-menu-right p-0">--}}
{{--                        <div class="dropdown-menu-grid">--}}
{{--                            <div class="menu-grid-row">--}}
{{--                                <div><a class="dropdown-item  border-bottom border-right" href="apps.mail.html"><i class="icon dripicons-mail"></i><span>Mail</span></a></div>--}}
{{--                                <div><a class="dropdown-item  border-bottom" href="apps.messages.html"><i class="icon dripicons-message"></i><span>Messages</span></a></div>--}}
{{--                            </div>--}}
{{--                            <div class="menu-grid-row">--}}
{{--                                <div><a class="dropdown-item  border-right" href="apps.contacts.html"><i class="icon dripicons-archive"></i><span>Contacts</span></a></div>--}}
{{--                                <div> <a class="dropdown-item" href="apps.calendar.html"><i class="icon dripicons-calendar"></i><span>Calendar</span></a></div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </li>--}}
{{--                <li class="nav-item dropdown dropdown-notifications dropdown-menu-lg">--}}
{{--                    <a href="javascript:void(0)" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">--}}
{{--                        <i class="icon dripicons-bell"></i>--}}
{{--                    </a>--}}
{{--                    <div class="dropdown-menu dropdown-menu-right">--}}
{{--                        <div class="card card-notification">--}}
{{--                            <div class="card-header">--}}
{{--                                <h5 class="card-title">Notifications</h5>--}}
{{--                                <ul class="actions top-right">--}}
{{--                                    <li>--}}
{{--                                        <a href="javascript:void(0);" data-q-action="open-notifi-config">--}}
{{--                                            <i class="icon dripicons-gear"></i>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                            <div class="card-body">--}}
{{--                                <div class="card-container-wrapper">--}}
{{--                                    <div class="card-container">--}}
{{--                                        <div class="timeline timeline-border">--}}
{{--                                            <div class="timeline-list">--}}
{{--                                                <div class="timeline-info">--}}
{{--                                                    <div>Prep for bi-weekly meeting with <a href="javascript:void(0)"><strong>Steven Weinberg</strong></a> </div>--}}
{{--                                                    <small class="text-muted">07/05/18, 2:00 PM</small>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="timeline-list timeline-border timeline-primary">--}}
{{--                                                <div class="timeline-info">--}}
{{--                                                    <div>Skype call with development team</div>--}}
{{--                                                    <small class="text-muted">07/07/18, 1:00 PM</small>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="timeline-list  timeline-border timeline-accent">--}}
{{--                                                <div class="timeline-info">--}}
{{--                                                    <div>Programming control system</div>--}}
{{--                                                    <small class="text-muted">07/09/18, 10:00 AM - 6:00 PM</small>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="timeline-list  timeline-border timeline-success">--}}
{{--                                                <div class="timeline-info">--}}
{{--                                                    <div>Lunch with Peter Higgs</div>--}}
{{--                                                    <small class="text-muted">07/10/18, 12:00 PM</small>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="timeline-list  timeline-border timeline-warning">--}}
{{--                                                <div class="timeline-info">--}}
{{--                                                    <div><a href="#"><strong>Approve Request</strong></a> for new training material by</div>--}}
{{--                                                    <small class="text-muted">07/11/18, 9:00 AM</small>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="timeline-list  timeline-border timeline-info">--}}
{{--                                                <div class="timeline-info">--}}
{{--                                                    <div><a href="#"><strong>RSVP</strong></a> for this year's hackathon.</div>--}}
{{--                                                    <small class="text-muted">07/11/18, 1:30 PM</small>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="card-container">--}}
{{--                                        <h6 class="p-0 m-0">--}}
{{--                                            Show notifications from:--}}
{{--                                        </h6>--}}
{{--                                        <div class="row m-b-20 m-t-30">--}}
{{--                                            <div class="col-10"><span class="title"><i class="icon dripicons-calendar"></i>Calendar</span></div>--}}
{{--                                            <div class="col-2"><input type="checkbox" class="js-switch" checked /></div>--}}
{{--                                        </div>--}}
{{--                                        <div class="row m-b-20">--}}
{{--                                            <div class="col-10"><span class="title"><i class="icon dripicons-mail"></i>Email</span></div>--}}
{{--                                            <div class="col-2"><input type="checkbox" class="js-switch" checked/></div>--}}
{{--                                        </div>--}}
{{--                                        <div class="row m-b-20">--}}
{{--                                            <div class="col-10"><span class="title"><i class="icon dripicons-message"></i>Messages</span></div>--}}
{{--                                            <div class="col-2"><input type="checkbox" class="js-switch" /></div>--}}
{{--                                        </div>--}}
{{--                                        <div class="row m-b-20">--}}
{{--                                            <div class="col-10"><span class="title"><i class="icon dripicons-stack"></i>Projects</span></div>--}}
{{--                                            <div class="col-2"><input type="checkbox" class="js-switch" checked/></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </li>--}}
                <li class="nav-item dropdown">
                    <a class="nav-link nav-pill user-avatar" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <img src="{{ asset('admin/assets/img/avatars/logo_sign.png') }}" class="w-35 rounded-circle" alt="Albert Einstein">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-accout">
                        <div class="dropdown-header pb-3">
                            <div class="media d-user">
                                <img class="align-self-center mr-3 w-40 rounded-circle" src="{{ asset('admin/assets/img/avatars/logo_sign.png') }}" alt="Albert Einstein">
                                <div class="media-body">
                                    <h5 class="mt-0 mb-0">{{ auth()->user()->name }}</h5>
                                    <span>{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
{{--                        <a class="dropdown-item" href="apps.messages.html"><i class="icon dripicons-mail"></i> Message <span class="badge badge-accent rounded-circle w-15 h-15 p-0 font-size-10">4</span></a>--}}
{{--                        <a class="dropdown-item" href="pages.profile.html"><i class="icon dripicons-user"></i> Profile</a>--}}
{{--                        <a class="dropdown-item" href="pages.my-account.html"><i class="icon dripicons-gear"></i> Account Settings </a>--}}
{{--                        <div class="dropdown-divider"></div>--}}
{{--                        <a class="dropdown-item" href="#"><i class="icon dripicons-lock"></i> Lock Account</a>--}}
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();"><i class="icon dripicons-lock-open"></i> Sign Out</a>
                        <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </li>
            </ul>
            <form role="search" action="pages.search.html" class="navbar-form">
                <div class="form-group">
                    <input type="text" placeholder="Search and press enter..." class="form-control navbar-search" autocomplete="off">
                    <i data-q-action="close-site-search" class="icon dripicons-cross close-search"></i>
                </div>
                <button type="submit" class="d-none">Submit</button>
            </form>
        </nav>
        <div class="content">
{{--            @include('dashboard.partials.header')--}}

            @yield('content')
        </div>
    </div>
</div>

@include('dashboard.partials.foot')
@stack('scripts')
</body>
</html>
