<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="shortcut icon" href="/storage/Images/solar.ico" />

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

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
                    {{-- {{ config('app.name', 'Laravel') }} --}}
                    <img height="35px" src="/storage/Images/solar-logo.png">
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
                            
                            @if(Auth::user()->osi_access == 1 || Auth::user()->sysadmin == 1)
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-pencil-ruler"></i> <small><strong>Office Supplies</strong></small>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                @if(Auth::user()->osi_role == "CUST" || Auth::user()->sysadmin == 1)
                                <h6 class="dropdown-header">Setup</h6>
                                <a class="dropdown-item" href="{{route('list_categories')}}">&nbsp;&nbsp;&nbsp;&nbsp;Category Master</a>
                                <a class="dropdown-item" href="{{route('list_uofm')}}">&nbsp;&nbsp;&nbsp;&nbsp;U of M Master</a>
                                <a class="dropdown-item" href="{{route('list_items')}}">&nbsp;&nbsp;&nbsp;&nbsp;Item Master</a>
                                @endif
                                <h6 class="dropdown-header">Transactions</h6>
                                <a class="dropdown-item" href="{{route('list_trx')}}">&nbsp;&nbsp;&nbsp;&nbsp;Requisition and Inventory</a>
                                </div>
                            </li>
                            @endif

                            @if(Auth::user()->yield_access == 1 || Auth::user()->sysadmin == 1)
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-tachometer-alt"></i> <small><strong>Yield Dashboard</strong></small>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                @if(Auth::user()->yield_role == "ADMIN" || Auth::user()->sysadmin == 1)
                                <h6 class="dropdown-header">Setup</h6>
                                <a class="dropdown-item" href="/yield/setup/product_types">&nbsp;&nbsp;&nbsp;&nbsp;Product Types</a>
                                <a class="dropdown-item" href="{{route('list_email_yield')}}">&nbsp;&nbsp;&nbsp;&nbsp;Email Distribution</a>
                                @endif
                                <h6 class="dropdown-header">Transactions</h6>
                                <a class="dropdown-item" href="{{route('list_yield')}}">&nbsp;&nbsp;&nbsp;&nbsp;Data Entry</a>
                                </div>
                            </li>
                            @endif

                            @if(Auth::user()->mes_access == 1 || Auth::user()->sysadmin == 1)
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-solar-panel"></i> <small><strong>MFG Transactions</strong></small>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                @if(Auth::user()->mes_role == 'ADMIN' || Auth::user()->sysadmin == 1)
                                <h6 class="dropdown-header">Setup</h6>
                                {{-- <a class="dropdown-item" href="#">Global Parameters</a> --}}
                                <a class="dropdown-item" href="/mes/setup/custom">&nbsp;&nbsp;&nbsp;&nbsp;Customized Fields</a>
                                <a class="dropdown-item" href="#">&nbsp;&nbsp;&nbsp;&nbsp;Station Assignment</a>
                                <a class="dropdown-item" href="#">&nbsp;&nbsp;&nbsp;&nbsp;Location and Routing</a>
                                <a class="dropdown-item" href="#">&nbsp;&nbsp;&nbsp;&nbsp;Module Class</a>
                                <a class="dropdown-item" href="/planning/setup/shift">&nbsp;&nbsp;&nbsp;&nbsp;Shift</a>
                                @endif
                                <h6 class="dropdown-header">Reports</h6>
                                {{-- <a class="dropdown-item" href="#">&nbsp;&nbsp;&nbsp;&nbsp;Dashboard</a> --}}
                                <a class="dropdown-item" href="/modules">&nbsp;&nbsp;&nbsp;&nbsp;Module Inquiry</a>
                                <a class="dropdown-item" href="/mes">&nbsp;&nbsp;&nbsp;&nbsp;Daily Transactions</a>
                                <a class="dropdown-item" href="/mes/output">&nbsp;&nbsp;&nbsp;&nbsp;Daily Output</a>
                                <a class="dropdown-item" href="/mes/ftd">&nbsp;&nbsp;&nbsp;&nbsp;FTD Report</a>
                                <a class="dropdown-item" href="/report/test">&nbsp;&nbsp;&nbsp;&nbsp;Pack Outs for Backflush</a>
                                @if(Auth::user()->mes_role != 'OPRT')
                                    <a class="dropdown-item" href="/mes/stringer">&nbsp;&nbsp;&nbsp;&nbsp;Stringer Lot Transactions</a>
                                @endif
                                
                                <h6 class="dropdown-header">Planning</h6>
                                @if(Auth::user()->mes_role == 'PLAN' || Auth::user()->sysadmin == 1)
                                <a class="dropdown-item" href="/planning/item">&nbsp;&nbsp;&nbsp;&nbsp;Item Maintenance</a>
                                @endif
                                <a class="dropdown-item" href="/planning/bom">&nbsp;&nbsp;&nbsp;&nbsp;BOM Maintenance</a>
                                @if(Auth::user()->mes_role == 'PLAN' || Auth::user()->sysadmin == 1)
                                <a class="dropdown-item" href="/planning/wo">&nbsp;&nbsp;&nbsp;&nbsp;Work Order Information</a>
                                @endif
                                <a class="dropdown-item" href="/planning/schedule">&nbsp;&nbsp;&nbsp;&nbsp;Production Schedule</a>
                                
                                @if(Auth::user()->mes_role == 'WHSE' || Auth::user()->mes_role == 'MH' || Auth::user()->sysadmin == 1)
                                    <h6 class="dropdown-header">Warehouse</h6>
                                    @if(Auth::user()->mes_role == 'WHSE' || Auth::user()->sysadmin == 1)
                                    <a class="dropdown-item" href="/mes/materials">&nbsp;&nbsp;&nbsp;&nbsp;Materials Received</a>
                                    @endif
                                    @if(Auth::user()->mes_role == 'WHSE' || Auth::user()->mes_role == 'MH' || Auth::user()->sysadmin == 1)
                                    <a class="dropdown-item" href="/mes/issuance">&nbsp;&nbsp;&nbsp;&nbsp;Material Issuance</a>
                                    @endif
                                    @if(Auth::user()->mes_role == 'MH' || Auth::user()->sysadmin == 1)
                                    <a class="dropdown-item" href="/mes/assign/lot">&nbsp;&nbsp;&nbsp;&nbsp;Lot ID Assignment</a>
                                    @endif
                                @endif

                                @if(Auth::user()->mes_role == 'SHIP' || Auth::user()->sysadmin == 1)
                                <h6 class="dropdown-header">Shipping</h6>
                                <a class="dropdown-item" href="/mes/cabinet">&nbsp;&nbsp;&nbsp;&nbsp;Cabinet Information</a>
                                @endif

                                @if(Auth::user()->mes_role == 'OPRT' || Auth::user()->sysadmin == 1)
                                <h6 class="dropdown-header">Line Transactions</h6>
                                @foreach(Auth::user()->portalUser->mesUser->assignment as $assign)
                                    @if(App\Models\WebPortal\IPAssign::where("IPADDRESS",Request::ip())->count() == 0)
                                        @if($assign->stationInfo->NEWPORTAL == 1)
                                            {{-- @if($assign->STNCODE == 'STRINGER') --}}
                                                {{-- <a class="dropdown-item" href="/mes/stringer">&nbsp;&nbsp;&nbsp;&nbsp;<small>{{$assign->stationInfo->STNDESC}}</small></a> --}}
                                            {{-- @else --}}
                                                <a class="dropdown-item" href="/mescreate/{{$assign->stationInfo->STNID}}">&nbsp;&nbsp;&nbsp;&nbsp;<small>{{$assign->stationInfo->STNDESC}}</small></a>
                                                @if($assign->STNCODE == 'FG-PROD')
                                                <a class="dropdown-item" href="/mes/packaging">&nbsp;&nbsp;&nbsp;&nbsp;<small>Packaging</small></a>
                                                @endif
                                            {{-- @endif --}}
                                        @endif
                                    @else
                                        @php
                                            $ip_assign = App\Models\WebPortal\IPAssign::where([["IPADDRESS",Request::ip()],["STATION",$assign->stationInfo->STNCODE],]);
                                        @endphp
                                        @if($assign->stationInfo->NEWPORTAL == 1 && $ip_assign->count() != 0)
                                            {{-- @if($assign->STNCODE == 'STRINGER') --}}
                                                {{-- <a class="dropdown-item" href="/mes/stringer">&nbsp;&nbsp;&nbsp;&nbsp;<small>{{$assign->stationInfo->STNDESC}}</small></a> --}}
                                            {{-- @else --}}
                                                <a class="dropdown-item" href="/mescreate/{{$assign->stationInfo->STNID}}/{{$ip_assign->first()->PRODLINE}}">&nbsp;&nbsp;&nbsp;&nbsp;<small>{{$assign->stationInfo->STNDESC}}</small></a>
                                                @if($assign->STNCODE == 'FG-PROD')
                                                <a class="dropdown-item" href="/mes/packaging">&nbsp;&nbsp;&nbsp;&nbsp;<small>Packaging</small></a>
                                                @endif
                                            {{-- @endif --}}
                                        @endif
                                    @endif
                                @endforeach
                                @endif

                                @if(Auth::user()->mes_role == 'QUAL')
                                <h6 class="dropdown-header">QA Transactions</h6>
                                <a class="dropdown-item" href="/mes/packaging">&nbsp;&nbsp;&nbsp;&nbsp;<small>MRB Packaging</small></a>
                                @endif
                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img height="25px" src="/storage/Images/Trina-Solar.png">
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                @if(Auth::user()->sysadmin == 1)
                                <h6 class="dropdown-header">Admin Functions</h6>
                                <a class="dropdown-item" href="/trina/moduleupdate">&nbsp;&nbsp;&nbsp;&nbsp;Module Update</a>
                                <a class="dropdown-item" href="/trina/module/sync">&nbsp;&nbsp;&nbsp;&nbsp;Module ID Sync</a>
                                <a class="dropdown-item" href="/trina/module/missing">&nbsp;&nbsp;&nbsp;&nbsp;Missing Module IDs</a>
                                <a class="dropdown-item" href="/trina/jbox/register">&nbsp;&nbsp;&nbsp;&nbsp;JBOX Registration</a>
                                <a class="dropdown-item" href="/trina/module/color">&nbsp;&nbsp;&nbsp;&nbsp;Module Color</a>
                                <a class="dropdown-item" href="/trina/module/power">&nbsp;&nbsp;&nbsp;&nbsp;Module Power</a>
                                <a class="dropdown-item" href="/trina/po">&nbsp;&nbsp;&nbsp;&nbsp;Cell PO Information</a>
                                @endif
                                <h6 class="dropdown-header">Reports</h6>
                                <a class="dropdown-item" href="/trina/inquiry">&nbsp;&nbsp;&nbsp;&nbsp;Module Inquiry</a>
                                <a class="dropdown-item" href="/trina/flashtest">&nbsp;&nbsp;&nbsp;&nbsp;Flash Test Inquiry</a>
                                <a class="dropdown-item" href="/trina/workorder">&nbsp;&nbsp;&nbsp;&nbsp;Work Order Info</a>
                                <a class="dropdown-item" href="/trina/lotreport">&nbsp;&nbsp;&nbsp;&nbsp;Lot Number Monitoring</a>
                                <a class="dropdown-item" href="/trina/moduleinfo">&nbsp;&nbsp;&nbsp;&nbsp;Module Information</a>
                                <a class="dropdown-item" href="/trina/ftdreport">&nbsp;&nbsp;&nbsp;&nbsp;FTD Report</a>
                                <a class="dropdown-item" href="/trina/containerinfo">&nbsp;&nbsp;&nbsp;&nbsp;Container Information</a>
                                
                                @if(Auth::user()->mes_role == 'SHIP' || Auth::user()->sysadmin == 1)
                                <h6 class="dropdown-header">Transactions</h6>
                                <a class="dropdown-item" href="/trina/shipment">&nbsp;&nbsp;&nbsp;&nbsp;Shipment Details</a>
                                @endif
                                </div>
                            </li>
                            @endif

                            @if(Auth::user()->proddt_access == 1 || Auth::user()->sysadmin == 1)
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ban"></i> <small><strong>Downtime Monitoring</strong></small>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                @if(Auth::user()->proddt_role == "SUPV" || Auth::user()->proddt_role == "ADMIN" || Auth::user()->sysadmin == 1)
                                <h6 class="dropdown-header">Setup</h6>
                                {{-- <a class="dropdown-item" href="#">Global Parameters</a> --}}
                                <a class="dropdown-item" href="/proddt/setup/category">&nbsp;&nbsp;&nbsp;&nbsp;Downtime Categories</a>
                                <a class="dropdown-item" href="/proddt/setup/machine">&nbsp;&nbsp;&nbsp;&nbsp;Machine</a>
                                <a class="dropdown-item" href="/proddt/setup/station">&nbsp;&nbsp;&nbsp;&nbsp;Stations</a>
                                @endif
                                <h6 class="dropdown-header">Transactions</h6>
                                <a class="dropdown-item" href="/proddt/dashboard">&nbsp;&nbsp;&nbsp;&nbsp;Dashboard</a>
                                @if(Auth::user()->proddt_role != "VIEW" || Auth::user()->sysadmin == 1)
                                <a class="dropdown-item" href="/proddt/logsheet">&nbsp;&nbsp;&nbsp;&nbsp;Log Sheet</a>
                                @endif
                                </div>
                            </li>
                            @endif

                            @if(Auth::user()->assets_access == 1 || Auth::user()->sysadmin == 1)
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-laptop"></i> <small><strong>IT Management</strong></small>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <h6 class="dropdown-header">Assets</h6>
                                <h6 class="dropdown-header">&nbsp;&nbsp;&nbsp;&nbsp;Computing Devices</h6>
                                <a class="dropdown-item" href="/assets/general">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Masterlist</a>
                                <a class="dropdown-item" href="/assets/dashboard/general">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dashboard</a>
                                {{-- <h6 class="dropdown-header">&nbsp;&nbsp;&nbsp;&nbsp;Software</h6> --}}
                                {{-- <a class="dropdown-item" href="#">Departments</a> --}}
                                </div>
                            </li>
                            @endif

                            @if(Auth::user()->sysadmin == 1)
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-user-cog"></i> <small><strong>System Setup</strong></small>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <h6 class="dropdown-header">General Setup</h6>
                                <a class="dropdown-item" href="{{route('list_users')}}">&nbsp;&nbsp;&nbsp;&nbsp;Users</a>
                                <a class="dropdown-item" href="{{route('list_cost_centers')}}">&nbsp;&nbsp;&nbsp;&nbsp;Cost Centers</a>
                                <a class="dropdown-item" href="{{route('list_depts')}}">&nbsp;&nbsp;&nbsp;&nbsp;Departments</a>
                                </div>
                            </li>
                            @endif
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
                                    <small>{{ Auth::user()->name }}</small> <span class="caret"></span>
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
            <div class="text-center">
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
