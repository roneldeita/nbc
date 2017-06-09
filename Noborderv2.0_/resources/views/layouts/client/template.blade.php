<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta id="token" name="csrf-token" value="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{asset('images/fav.png')}}"/>

    <title>NoBorderClub</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{asset('css/pe-icon-7-stroke.css')}}" rel="stylesheet">
    <link href="{{asset('css/helper.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="{{asset('css/footable.core.css')}}" rel="stylesheet">
    <link href="{{asset('temp/toastr.css')}}" rel="stylesheet">
    @yield('styles')
    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
    <div id="app">
        <nav class="navbar background-secondary-nbc">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a  href="{{ url('/client') }}">
                        <img src="{{asset('images/logo_.svg')}}" height="48" width="48" >
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    @if (Auth::user()->verification != null && Auth::user()->verified == 1)
                        @include('layouts/client/include/navigation')
                    @elseif (Auth::user()->password == null && count(Auth::user()->socialAcc->id))
                        @include('layouts/client/include/navigation')
                    @else
                    @endif

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right text-white">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <!-- <li>
                                        <a href="{{ url('/client/profile') }}">
                                            Profile
                                        </a>
                                    </li> -->
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
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- <script src="https://code.jquery.com/jquery-2.2.4.min.js""></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
    <script type="text/javascript" src="{{asset('js/cons.js')}}"></script>
    <script src="{{asset('temp/jquery-2.2.4.min.js')}}"></script>
    <script src="{{asset('temp/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/footable.all.min.js')}}"></script>
    <script src="{{asset('temp/toastr.min.js')}}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js"></script>
    <script src="{{asset('temp/socket.io.min.js')}}"></script>
    <script type="text/javascript">
        toastr.options = {
            "timeOut": "5000",
            "positionClass" : "toast-top-right",
            "progressBar": true,
        };

        var socket = io.connect(LOCALPORT);

        socket.on('new contract', function (details) {
            if (details.clientId == "{{Auth::user()->id}}") {
                toastr.info('You have new contract signing!', ''+details.projectName);
                addNotification('<li><a href=""><strong>New Contract </strong>: '+ details.projectName +'</a></li>');
            }
        });

        socket.on('contract approve', function (details) {
            if (details.receiver == "{{Auth::user()->id}}") {
                toastr.info('Worker approved to contract!', ''+details.projectName +'');
                addNotification('<li><a href=""><strong>Contract Approval </strong>: '+ details.projectName +'</a></li>');
            }
        });

        if (!urlForProjects() || urlForContract()) {
            socket.on('new message', function (details) {
                if (details.receiver == "{{Auth::user()->id}}") {
                    toastr.info('You have new message!', ''+details.projectName);
                    addMessage('<li><a href=""> '+ details.projectName +'</a></li>');

                }
            });
            socket.on('project update', function (details) {
                if (details.clientId == "{{Auth::user()->id}}") {
                    toastr.success('Your project updated to '+ details.status +'!', ''+details.projectName);
                    addNotification('<li><a href=""><strong>Project Status Updated </strong>: '+ details.projectName +'</a></li>');
                }
            });
        }

        if (urlForProjects() && urlForDraft() ) {
            socket.on('new message', function (details) {
                if (details.receiver == "{{Auth::user()->id}}") {
                    toastr.info('You have new message!', ''+details.projectName);
                    addMessage('<li><a href=""> '+ details.projectName +'</a></li>');

                }
            });
            socket.on('project update', function (details) {
                if (details.clientId == "{{Auth::user()->id}}") {
                    toastr.success('Your project updated to '+ details.status +'!', ''+details.projectName);
                    addNotification('<li><a href=""><strong>Project Status Updated </strong>: '+ details.projectName +'</a></li>');
                }
            });

        }

        if (!urlForContract()) {
            socket.on('project development', function (details) {
                if (details.clientId == "{{Auth::user()->id}}") {
                    toastr.success('Your project is now on development!', ''+details.projectName);
                    addNotification('<li><a href=""><strong>Project Status Updated </strong>: '+ details.projectName +'</a></li>');
                }
            });
        }

        if (!urlForPublished()) {
            socket.on('new applicant', function (details) {
                if (details.clientId == "{{Auth::user()->id}}") {
                    toastr.success('You have new Applicant!', ''+details.projectName);
                    addNotification('<li><a href=""><strong>New Applicant </strong>: '+ details.projectName +'</a></li>');
                }
            });
        }

        function urlForPublished () {
            var pathArray = window.location.pathname.split("/");
            if (pathArray[2] == "projects" && pathArray[3] == "published" ) {
                return true;
            }
        }

        function urlForDraft () {
            var pathArray = window.location.pathname.split("/");
            if (pathArray[2] == "projects" && pathArray[3] == "draft" ) {
                return true;
            }
        }

        function urlForContract () {
            var pathArray = window.location.pathname.split("/");
            if (pathArray[2] == "projects" && pathArray[3] == "contract_signing" ) {
                return true;
            }
        }

        function urlForProjects () {
            var pathArray = window.location.pathname.split("/");
            if (pathArray[2] == "projects" && typeof pathArray[3] != "undefined" ) {
                return true;
            }
        }

        function addNotification (data) {
            var badge = parseInt($('#notificationsBadge').text());
            if (isNaN(badge)) {
                badge = 0;
            }
            var final = badge + 1;
            $('#notificationsBadge').text(""+final);
            //$('#notificationsMenu').prepend(data);
        }

        function addMessage (data) {
            var badge = parseInt($('#messagesBadge').text());
            if (isNaN(badge)) {
                badge = 0;
            }
            var final = badge + 1;
            $('#messagesBadge').text(""+final);
            //$('#messagesMenu').prepend(data);
        }

    </script>
    @yield('scripts')
</body>
</html>
