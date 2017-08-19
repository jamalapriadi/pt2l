<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>PL2T ADMINISTRATOR</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- import CSS -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    {{Html::style('limitless/assets/css/icons/icomoon/styles.css')}}
    {{Html::style('limitless/assets/css/bootstrap.css')}}
    {{Html::style('limitless/assets/css/core.css')}}
    {{Html::style('limitless/assets/css/components.css')}}
    {{Html::style('limitless/assets/css/colors.css')}}
    <!--
    <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-default/index.css">
    -->

    <!-- Core JS files -->
    {{Html::script('limitless/assets/js/plugins/loaders/pace.min.js')}}
    {{Html::script('limitless/assets/js/core/libraries/jquery.min.js')}}
    {{Html::script('limitless/assets/js/core/libraries/bootstrap.min.js')}}
    {{Html::script('limitless/assets/js/plugins/loaders/blockui.min.js')}}
    <!-- /core JS files -->

    <!--DATATABLE AND CKEDITOR -->
    {{Html::script('limitless/ckeditor/ckeditor.js')}}

    <!-- Theme JS files -->
    {{Html::script('limitless/assets/js/plugins/tables/datatables/datatables.min.js')}}
    {{Html::script('limitless/assets/js/plugins/tables/datatables/extensions/col_vis.min.js')}}
    {{Html::script('limitless/assets/js/core/libraries/jquery_ui/interactions.min.js')}}
    {{Html::script('limitless/assets/js/plugins/forms/selects/select2.min.js')}}
    {{Html::script('limitless/assets/js/plugins/notifications/pnotify.min.js')}}

    <!-- SWEET ALERT -->
    {{Html::style('plugins/sweetalert/dist/sweetalert.css')}}
    {{Html::script('plugins/sweetalert/dist/sweetalert.min.js')}}
    <!-- SWEET ALERT -->


    {{Html::script('limitless/assets/js/core/app.js')}}
    {{Html::script('limitless/assets/js/pages/form_select2.js')}}
    <!-- /theme JS files -->

    @yield('css')
</head>
<body>
    <div id="app">
        <!-- Main navbar -->
        <div class="navbar navbar-inverse">
            <div class="container">
                <div class="navbar-header">
                    
                </div>

                <div class="navbar-collapse collapse" id="navbar-mobile">
                    

                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown dropdown-user">
                            <a class="dropdown-toggle" data-toggle="dropdown">
                                {{Html::image('limitless/assets/images/placeholder.jpg')}}
                                <span>{{Auth::user()->name}}</span>
                                <i class="caret"></i>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-right">
                                <!--
                                <li><a href="{{URL::to('home/profile')}}"><i class="icon-user-plus"></i> My profile</a></li>
                                <li class="divider"></li>
                                <li><a href="#"><i class="icon-cog5"></i> Account settings</a></li>
                                -->
                                <li>
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                        <i class="icon-switch2"></i> 
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /main navbar -->

        <!-- Second navbar -->
        <div class="navbar navbar-default" id="navbar-second">
            <div class="container">
                <ul class="nav navbar-nav no-border visible-xs-block">
                    <li><a class="text-center collapsed" data-toggle="collapse" data-target="#navbar-second-toggle"><i class="icon-menu7"></i></a></li>
                </ul>

                <div class="navbar-collapse collapse" id="navbar-second-toggle">
                    <ul class="nav navbar-nav">
                        <li><a href="{{URL::to('home')}}"><i class="icon-display4 position-left"></i> Dashboard</a></li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="icon-ticket position-left"></i> Master Data <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu width-200">
                                <li><a href="{{URL::to('pelanggan')}}">Pelanggan</a></li>
                                <li><a href="{{URL::to('daya')}}">Daya</a></li>
                                <li><a href="{{URL::to('tarif')}}">Tarif</a></li>
                                <li><a href="{{URL::to('pelanggaran')}}">Jenis Pelanggaran</a></li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="icon-tv"></i> Transaksi <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu width-200">
                                <li><a href="{{URL::to('pemeriksaan')}}"><i class="icon-basket"></i> Pemeriksaan</a></li>
                                <li><a href="{{URL::to('pembayaran')}}"><i class="icon-angle"></i> Pembayaran</a></li>
                                <li><a href="{{URL::to('tindakan')}}"><i class="icon-users2"></i> Tindak Lanjut</a></li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="icon-stats-growth"></i> Reports <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu width-200">
                                <li><a href="{{URL::to('report/hasil-pemeriksaan')}}"><i class="icon-align-center-horizontal"></i> Hasil Pemeriksaan</a></li>
                                <li><a href="{{URL::to('report/pembayaran')}}"><i class="icon-align-center-horizontal"></i> Pembayaran</a></li>
                                <li><a href="{{URL::to('report/belum-terbayar')}}"><i class="icon-align-center-horizontal"></i> Belum Terbayar</a></li>
                                <li><a href="{{URL::to('report/penyambungan-kembali')}}"><i class="icon-align-center-horizontal"></i> Penyambungan Kembali</a></li>
                            </ul>
                        </li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="icon-user-tie position-left"></i> Users <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu width-200">
                                <li><a href="{{URL::to('user')}}"><i class="icon-users4"></i> User</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /second navbar -->



        <br>
        <div class="container">
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->

    @yield('js')
</body>
</html>
