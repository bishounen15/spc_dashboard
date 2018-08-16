<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/Datatables-1.10.16/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/buttons.dataTables.min.css') }}" rel="stylesheet">
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    {{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> --}}
  

   {{-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"> --}}
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
  
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
  
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>  

    <style>
        div.dt-buttons {
            float: right;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            {{-- <div class="container"> --}}
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
    
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @guest
                        @else
                            {{-- <li><a class="nav-link" href="{{ route('apps') }}">{{ __('My Apps') }}</a></li> --}}
                            
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Office Supplies
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <h6 class="dropdown-header">Setup</h6>
                                <a class="dropdown-item" href="{{route('list_categories')}}">Category Master</a>
                                <a class="dropdown-item" href="{{route('list_uofm')}}">U of M Master</a>
                                <a class="dropdown-item" href="{{route('list_items')}}">Item Master</a>
                                <h6 class="dropdown-header">Transactions</h6>
                                <a class="dropdown-item" href="{{route('list_trx')}}">Requisition and Inventory</a>
                                </div>
                            </li>

                            <li><a class="nav-link" href="{{route('list_yield')}}">{{ __('Yield Dashboard') }}</a></li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                System Setup
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                {{-- <h6 class="dropdown-header">Setup</h6> --}}
                                <a class="dropdown-item" href="{{route('list_users')}}">Users</a>
                                <a class="dropdown-item" href="{{route('list_cost_centers')}}">Cost Centers</a>
                                <a class="dropdown-item" href="{{route('list_depts')}}">Departments</a>
                                </div>
                            </li>
                        @endguest
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                            {{-- <li><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li> --}}
                            <li><a class="nav-link" href="{{ route('portal_link') }}">{{ __('Link Portal Account') }}</a></li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            {{-- </div> --}}
        </nav>

        <main class="py-4">
            <div align= "center">
            @include('inc.messages')
            </div>
            @yield('content')
        </main>
    </div>

    <script src="{{ asset('js/jquery.dataTables.min.js') }}" defer></script>
    <script src="{{ asset('js/dataTables.buttons.min.js') }}" defer></script>
    <script src="{{ asset('js/buttons.html5.min.js') }}" defer></script>
    <script src="{{ asset('js/buttons.print.min.js') }}" defer></script>
    <script src="{{ asset('js/pdfmake.min.js') }}" defer></script>
    <script src="{{ asset('js/jszip.min.js') }}" defer></script>
    <script src="{{ asset('js/buttons.flash.min.js') }}" defer></script>

    @stack('jscript')
</body>
</html>
