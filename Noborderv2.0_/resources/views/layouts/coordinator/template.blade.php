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
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
    <link href="{{asset('css/pe-icon-7-stroke.css')}}" rel="stylesheet">
    <link href="{{asset('css/helper.css')}}" rel="stylesheet">

    <link href="{{asset('css/footable.core.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet"> -->
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
        <nav class="navbar background-secondary-nbc ">
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
                    <a  href="{{ url('/coordinator') }}">
                        <img src="{{asset('images/logo_.svg')}}" height="48" width="48" >
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    @include('layouts/coordinator/include/navigation')


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
                                        <a href="{{ url('/coordinator/profile') }}">
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
    <script type="text/javascript" src="{{asset('js/cons.js')}}"></script>
    <script src="{{asset('temp/jquery-2.2.4.min.js')}}"></script>
    <script src="{{asset('temp/bootstrap.min.js')}}"></script>
    <script src="{{asset('temp/toastr.min.js')}}"></script>
    <script src="{{asset('temp/socket.io.min.js')}}"></script>

    <script src="{{asset('js/footable.all.min.js')}}"></script>

    <script type="text/javascript">
    var socket = io.connect(LOCALPORT);
    toastr.options = {
        "timeOut": "5000",
        "positionClass" : "toast-top-right",
        "progressBar": true,
    };
    socket.on('new project published', function (data) {
        var details = data.details;
        if (details.coordinator_id == "{{Auth::user()->id}}") {

            // toastr.options = {
            //     "timeOut": "5000",
            //     "positionClass" : "toast-bottom-left"
            // };

            addNotification('<li><a href=""><strong>New Project </strong>: '+ details.name +'</a></li>');
            toastr.info(''+details.name ,'New Project Created');
        }
    });



    if (!urlForProjects()) {
        socket.on('new message', function (details) {
            if (details.receiver == "{{Auth::user()->id}}") {
                toastr.info('You have new message!', ''+details.projectName);
                addMessage('<li><a href="">'+ details.projectName +'</a></li>');
                console.log(details);
            }
        });
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
