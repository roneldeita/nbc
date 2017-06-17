<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta id="token" name="csrf-token" value="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{asset('public/images/fav.png')}}"/>

    <title>NoBorderClub</title>

    <!-- Styles -->
    <link href="{{asset('public/css/app.css') }}" rel="stylesheet">
    <link href="{{asset('public/css/pe-icon-7-stroke.css')}}" rel="stylesheet">
    <link href="{{asset('public/css/helper.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="{{asset('public/css/footable.core.css')}}" rel="stylesheet">
    <link href="{{asset('public/temp/toastr.css')}}" rel="stylesheet">
    @yield('styles')
    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
    <input type="hidden" id="aId" value="{{Auth::user()->id}}">
    <input type="hidden" id="mr" value="client">
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


    <script src="{{asset('public/temp/jquery-2.2.4.min.js')}}"></script>
    <script src="{{asset('public/temp/bootstrap.min.js')}}"></script>
    <script src="{{asset('public/js/footable.all.min.js')}}"></script>
    <script src="{{asset('public/temp/toastr.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js"></script>

    <script src="{{asset('public/temp/vue.js')}}"></script>
    <script src="{{asset('public/temp/vue-resource.min.js')}}"></script>
    <script type="text/javascript">
        Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');
    </script>

    <script src="{{asset('public/temp/socket.io.min.js')}}"></script>

    <script src="{{asset('public/js/core/general/helper.js')}}"></script>
    <script src="{{asset('public/js/core/general/cons.js')}}"></script>
    <script src="{{asset('public/js/core/general/setup.js')}}"></script>
    <script src="{{asset('public/js/core/general/namDOM.js')}}"></script>
    <script src="{{asset('public/js/core/general/checkUrl.js')}}"></script>

    <script src="{{asset('public/js/core/client/socket.js')}}"></script>

    <script src="{{asset('public/js/core/general/notification.js')}}"></script>
    @yield('scripts')
</body>
</html>
