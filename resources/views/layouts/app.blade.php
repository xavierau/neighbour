<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>LocalHood Admin</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet'
          type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="{{asset("css/bootstrap/bootstrap.min.css")}}" rel="stylesheet">
    <link href="/css/app.css" rel="stylesheet">
    {{--<link href="{{ elixir('css/app.css') }}" rel="stylesheet">--}}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/3.0.1/sweetalert2.min.css">
    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>

    @yield('style')
</head>
<body id="app-layout">
<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                {{getSettingsFromCache()->first()->value}}
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                <li><a href="{{ url('/app') }}">App</a></li>
                <li><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
                <li><a href="{{ url('/admin/categories') }}">Categories</a></li>
                <li><a href="{{ url('/admin/roles') }}">Roles</a></li>
                <li><a href="{{ url('/admin/permissions') }}">Permissions</a></li>
                <li><a href="{{ url('/admin/clans') }}">Buildings</a></li>
                <li><a href="{{ url('/admin/users') }}">Users</a></li>
                <li><a href="{{ url('/admin/feeds') }}">Feeds</a></li>
                <li><a href="{{ url('/admin/media') }}">Media</a></li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ url('/login') }}">Login</a></li>
                    <li><a href="{{ url('/facebook/register') }}">Facebook Sing Up</a></li>
                    <li><a href="{{ url('/register') }}">Register</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
@include('partials.messageAlert')
@yield('content')

        <!-- JavaScripts -->
<script src="{{asset("js/jquery/jquery.min.js")}}"></script>
<script src="{{asset("js/bootstrap/bootstrap.min.js")}}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/3.0.1/sweetalert2.min.js"></script>

@yield('script')
{{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>
</html>
