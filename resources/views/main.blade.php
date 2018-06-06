<!doctype html>
<html lang="en">


<!-- Mirrored from demos.creative-tim.com/material-dashboard-pro/examples/dashboard.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 20 Mar 2017 21:29:18 GMT -->
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('sacco/img/apple-icon.png')}}" />
    <link rel="icon" type="image/png" href="{{asset('sacco/img/favicon.png')}}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>The Sacco</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <!-- Bootstrap core CSS     -->
    <link href="{{asset('sacco/css/bootstrap.min.css')}}" rel="stylesheet" />
    <!--  Material Dashboard CSS    -->
    <link href="{{asset('sacco/css/material-dashboard.css')}}" rel="stylesheet" />
    <link href="{{asset('sacco/css/demo.css')}}" rel="stylesheet" />
    <!--     Fonts and icons     -->
    <link href="{{asset('sacco/css/fontawesome-all.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('/sacco/css/material-icons.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/sacco/css/roboto.css?family=Roboto:300,400,500,700|Material+Icons')}}" />
    <!--link rel="stylesheet" type="text/css" href="{{asset('/sacco/js/bootstrap-select.min.css')}}"-->
    <script type="text/javascript">
        var settings_json = @php echo json_encode($settings) @endphp
    </script>
</head>

<body id="thebody">
    <style>
        .modal-full{
            width:96%;
            height:auto;
            margin:0;
            padding-left:4%;
        }
        .modal-content{
            height:auto;
            min-height:100%;
            border-radius:0;
        }
    </style>
                        <style>
                        .ajax-loader {
                            visibility: hidden;
                            background-color: rgba(0,0,0,0.7);
                            position: absolute;
                            z-index: 4000 !important;
                            width: 100%;
                            height: 100%;
                        }
                        .ajax-loader img{
                            position: relative;
                            top: 50%;
                            left:50%;
                        }
                    </style>
                    <div class="ajax-loader">
                        <img src="{{ asset('images/ajax-loader.gif')}}" class="img-responsive" />
                    </div>


    <div class="wrapper">
        <div class="sidebar" data-active-color="blue" data-background-color="black">
            <!--
        Tip 1: You can change the color of active element of the sidebar using: data-active-color="purple | blue | green | orange | red | rose"
        Tip 2: you can also add an image using data-image tag
        Tip 3: you can change the color of the sidebar with data-background-color="white | black"
    -->
            <div class="logo">
                <a href="#" id="organization_name" class="simple-text">
                    @php echo isset($settings['name']) ? $settings['name'] : "The Sacco"; @endphp
                </a>
            </div>
            <div class="logo logo-mini">
                <a href="#" class="simple-text">
                    S
                </a>
            </div>
            <div class="sidebar-wrapper">
                <ul class="nav">
                    <li class="{{Active::check('dashboard')}}">
                        <a href="/dashboard">
                            <i class="material-icons">dashboard</i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="{{Active::check('dashboard/users')}}">
                        <a href="/dashboard/users">
                            <i class="material-icons">people</i>
                            <p>Members</p>
                        </a>
                    </li>
                    <li class="{{Active::check('dashboard/loans')}}">
                        <a href="/dashboard/loans">
                            <i class="material-icons">attach_money</i>
                            <p>Loans</p>
                        </a>
                    </li>
                    <li class="{{Active::check('dashboard/shares')}}">
                        <a href="/dashboard/shares">
                            <i class="material-icons">account_balance</i>
                            <p>Shares</p>
                        </a>
                    </li>
                    <li class="{{Active::check('dashboard/settings')}}">
                        <a href="/dashboard/settings">
                            <i class="material-icons">settings</i>
                            <p>Settings</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-panel">
            <nav class="navbar navbar-transparent navbar-absolute">
                <div class="container-fluid">
                    <div class="navbar-minimize">
                        <button id="minimizeSidebar" class="btn btn-round btn-white btn-fill btn-just-icon">
                            <i class="material-icons visible-on-sidebar-regular">more_vert</i>
                            <i class="material-icons visible-on-sidebar-mini">view_list</i>
                        </button>
                    </div>
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#"> Dashboard </a>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <!--li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="material-icons">notifications</i>
                                    <span class="notification">5</span>
                                    <p class="hidden-lg hidden-md">
                                        Notifications
                                        <b class="caret"></b>
                                    </p>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="#">Notification 1</a>
                                    </li>
                                    <li>
                                        <a href="#">Notification 2</a>
                                    </li>
                                    <li>
                                        <a href="#">Notification 3</a>
                                    </li>
                                    <li>
                                        <a href="#">Notification 4</a>
                                    </li>
                                    <li>
                                        <a href="#">Notification 5</a>
                                    </li>
                                </ul>
                            </li-->
                            @if(Auth::check())
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    <i class="material-icons">person</i> <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>{{ Auth::user()->name }}</li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                            @endif
                            <li class="separator hidden-lg hidden-md"></li>
                        </ul>
                        <form class="navbar-form navbar-right typeahead" id="search-form" role="search">
                            <div class="form-group form-search is-empty">
                                <input type="text" class="form-control the-search" autocomplete="off" placeholder="Search">
                                <span class="material-input"></span>
                            </div>
                        </form>
                    </div>
                </div>
            </nav>
            <div class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>

            </div>
            <footer class="footer">
                <div class="container-fluid">
                    <nav class="pull-left">
                        <ul>
                        </ul>
                    </nav>
                    <p class="copyright pull-right">
                        &copy;
                        <script>
                            document.write(new Date().getFullYear())
                        </script>
                        Developed by <a href="#" id="developer">Collins Kasyoki</a>
                    </p>
                </div>
            </footer>
        </div>
    </div>
    <!--div class="fixed-plugin">
        <div class="dropdown show-dropdown">
            <a href="#" data-toggle="dropdown">
                <i class="fa fa-cog fa-2x"> </i>
            </a>
            <form id="quick-settings-form" name="quick-settings-form">
            <div class="dropdown-menu">
                <div class="col-xs-12">
                    <h4>Quick Settings</h4>
                </div>
                <div class="col-xs-12">
                    <div class="form-group label-floating form-inline">
                        <label class="control-label">Loan Duration (mths)</label>
                        <input class="form-control" name="loan-duration" id="loan-duration" type="text" number="true"/>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="form-group label-floating form-inline">
                        <label class="control-label">Loan Interest (%)</label>
                        <input class="form-control" name="loan-interest" id="loan-interest" type="text" number="true"/>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="form-group label-floating form-inline">
                        <label class="control-label">Loan Borrowable(x times shares)</label>
                        <input class="form-control" name="loan-borrowable" id="loan-borrowable" type="text" number="true"/>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="form-group label-floating form-inline">
                        <label class="control-label">Minimum Guarantors</label>
                        <input class="form-control" name="min-guarantors" id="min-guarantors" type="text" number="true"/>
                    </div>
                </div>
                <div class="col-xs-12">
                    <input type="submit" value="Save" class="btn btn-primary btn-sm btn-block">
                    <a href="/dashboard/settings" class="btn btn-info btn-sm btn-block">Settings</a>
                </div>
            </div>          
            </form>
        </div>
    </div-->
    <meta name="_token" content={!! csrf_token() !!} />
</body>
<!--   Core JS Files   -->
<script src="{{asset('sacco/js/jquery-3.1.1.min.js')}}" type="text/javascript"></script>
<!--script src="{{asset('sacco/js/jquery-ui.min.js')}}" type="text/javascript"></script-->
<script src="{{asset('sacco/js/bootstrap.min.js')}}" type="text/javascript"></script>
<!--script src="{{asset('/sacco/js/bootstrap-select.min.js')}}" type="text/javascript"></script-->
<script src="{{asset('sacco/js/typeahead.bundle.min.js')}}" type="text/javascript"></script>
<script src="{{asset('sacco/js/material.min.js')}}" type="text/javascript"></script>
<script src="{{asset('sacco/js/perfect-scrollbar.jquery.min.js')}}" type="text/javascript"></script>
<!-- Forms Validations Plugin -->
<script src="{{asset('sacco/js/jquery.validate.min.js')}}"></script>
<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
<script src="{{asset('sacco/js/moment.min.js')}}"></script>
<!--  Charts Plugin -->
<!--script src="{{asset('sacco/js/chartist.min.js')}}"></script-->
<!--  Plugin for the Wizard -->
<script src="{{asset('sacco/js/jquery.bootstrap-wizard.js')}}"></script>
<!--  Notifications Plugin    -->
<script src="{{asset('sacco/js/bootstrap-notify.js')}}"></script>
<!--   Sharrre Library    -->
<!--script src="{{asset('sacco/js/jquery.sharrre.js')}}"></script-->
<!-- DateTimePicker Plugin -->
<script src="{{asset('sacco/js/bootstrap-datetimepicker.js')}}"></script>
<!-- Vector Map plugin -->
<!--script src="{{asset('sacco/js/jquery-jvectormap.js')}}"></script-->
<!-- Sliders Plugin -->
<!--script src="{{asset('sacco/js/nouislider.min.js')}}"></script-->
<!-- Select Plugin -->
<script src="{{asset('sacco/js/jquery.select-bootstrap.js')}}"></script>
<!--  DataTables.net Plugin    -->
<script src="{{asset('sacco/js/jquery.datatables.js')}}"></script>
<!-- Sweet Alert 2 plugin -->
<script src="{{asset('sacco/js/sweetalert2.js')}}"></script>
<!--    Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<!--script src="{{asset('sacco/js/jasny-bootstrap.min.js')}}"></script-->
<!--  Full Calendar Plugin    -->
<!--script src="{{asset('sacco/js/fullcalendar.min.js')}}"></script-->
<!-- TagsInput Plugin -->
<script src="{{asset('sacco/js/jquery.tagsinput.js')}}"></script>
<!-- Material Dashboard javascript methods -->
<script src="{{asset('sacco/js/material-dashboard.js')}}"></script>
<!--Common js file-->
<script type="text/javascript" src="{{asset('sacco/js/my.js')}}"></script>
<!--Custom per page js files-->
@yield('js')

</html>
