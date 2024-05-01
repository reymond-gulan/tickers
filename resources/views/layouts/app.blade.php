<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        var _token = $('meta[name=csrf-token').attr('content');

        $.ajaxSetup({
            headers : {
                'X-CSRF-Token' : _token
            }
        });

        function TableComparer(index) {
            return function(a, b) {
                var val_a = TableCellValue(a, index);
                var val_b = TableCellValue(b, index);
                var result = ($.isNumeric(val_a) && $.isNumeric(val_b)) ? val_a - val_b : val_a.toString().localeCompare(val_b);

                return result;
            }
        }

        function TableCellValue(row, index) {
            return $(row).children("td").eq(index).text();
        }

        $(function(){
            $(document).on("click", "table thead tr th:not(.no-sort)", function() {
                var table = $(this).parents("table");
                var rows = $(this).parents("table").find("tbody tr").toArray().sort(TableComparer($(this).index()));
                
                if ($(this).hasClass('sort')) {
                    var dir = $('.sort').data('sort');
                } else {
                    var dir = ($(this).hasClass("sort-asc")) ? "desc" : "asc";
                }


                if (dir == "desc") {
                    rows = rows.reverse();
                }

                for (var i = 0; i < rows.length; i++) {
                    table.append(rows[i]);
                }

                table.find("thead tr th").removeClass("sort-asc").removeClass("sort-desc");
                $(this).removeClass("sort-asc").removeClass("sort-desc") .addClass("sort-" + dir);
            });
        });
    </script>
</head>
<style>
    th:hover{
        background:transparent;
    }
    th{
        text-align:center;
        font-size:10px;
    }
    .text-right{
        text-align:right !important;
    }
    .text-sm{
        font-size:10px;
    }
    .text-xs{
        font-size:8px;
    }
    .form{
        width:100%;
        border:1px solid #eee;
        border-radius:5px;
        padding:2px 5px;
    }
    table{
        background:#FFF !important;
        font-size:15px;
    }
    #table .form{
        border:1px solid #000;
        border-radius:0;
    }
    .h-25{
        height:25px !important;
    }
    .toggle-settings{
        position:fixed;
        right:0;
        top:0;
        z-index:1000 !important;
        padding:0;
    }
    .bg-danger{
        display:none !important;
    }

    .symbols-body tr td{
        font-size:10px !important;
    }
</style>
<body>
<button type="button" class="btn btn-secondary toggle-settings px-3" id="toggle-settings">
    ...
</button>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm text-sm p-0 d-none">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{-- config('app.name', 'Laravel') --}}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item d-none">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item d-none">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link" target="_blank" href="/collect">Collect&nbsp;Data</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" target="_blank" href="/batch">Batch</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>
