<!doctype html>
<html lang="en">


<!-- Mirrored from demos.creative-tim.com/material-dashboard-pro/examples/pages/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 20 Mar 2017 21:32:19 GMT -->
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Login/Register</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <!-- Bootstrap core CSS     -->
    <link href="{{asset('sacco/css/bootstrap.min.css')}}" rel="stylesheet" />
    <!--  Material Dashboard CSS    -->
    <link href="{{asset('sacco/css/material-dashboard.css')}}" rel="stylesheet" />
    <link href="{{asset('sacco/css/demo.css')}}" rel="stylesheet" />
    <!--     Fonts and icons     -->
    <link href="{{asset('sacco/css/fontawesome-all.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('/sacco/css/material-icons.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/sacco/css/roboto.css?family=Roboto:300,400,500,700|Material+Icons')}}" />
</head>

<body>
      <nav class="navbar navbar-primary navbar-transparent navbar-absolute">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="{{Active::check('register')}}">
                        <a href="/register">
                            <i class="material-icons">person_add</i> Register
                        </a>
                    </li>
                    <li class="{{Active::check('login')}}">
                        <a href="/login">
                            <i class="material-icons">fingerprint</i> Login
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="wrapper wrapper-full-page">
        <div class="full-page login-page" filter-color="black">
            <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
            <div class="content">
                <div class="container">
                @yield('content')
                </div>
            </div>
            <footer class="footer">
                <div class="container">
                    <p class="copyright pull-right">
                        &copy;
                        <script>
                            document.write(new Date().getFullYear())
                        </script>
                    </p>
                </div>
            </footer>
        </div>
    </div>
        <meta name="_token" content={!! csrf_token() !!} />
</body>
<!--   Core JS Files   -->
<script src="{{asset('sacco/js/jquery-3.1.1.min.js')}}" type="text/javascript"></script>
<!--script src="{{asset('sacco/js/jquery-ui.min.js')}}" type="text/javascript"></script-->
<script src="{{asset('sacco/js/bootstrap.min.js')}}" type="text/javascript"></script>
<!--script src="{{asset('/sacco/js/bootstrap-select.min.js')}}" type="text/javascript"></script-->
<script src="{{asset('sacco/js/typeahead.bundle.min.js')}}" type="text/javascript"></script>
<script src="{{asset('sacco/js/material.min.js')}}" type="text/javascript"></script>
<!--script src="{{asset('sacco/js/perfect-scrollbar.jquery.min.js')}}" type="text/javascript"></script-->
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
<scripts src="{{asset('js/app.js')}}"></script>
</html>