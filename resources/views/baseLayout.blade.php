<!DOCTYPE html>
<!--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.0
Version: 1.5.3
Author: KeenThemes
Website: http://www.keenthemes.com/
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
-->
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8"/>
    <title>CEMCO ERP</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <meta name="MobileOptimized" content="320">
    <!-- BEGIN GLOBAL MANDATORY STYLES -->

    <link href="{{URL::asset('assets/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ URL::asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/plugins/uniform/css/uniform.default.css') }}" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
    <link rel="stylesheet" type="text/css"
          href="{{ URL::asset('assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css') }}"/>

    <link href="{{ URL::asset('assets/plugins/bootstrap-modal/css/bootstrap-modal.css') }}" rel="stylesheet"
          type="text/css"/>

    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/data-tables/DT_bootstrap.css') }}"/>
    <!-- END PAGE LEVEL PLUGIN STYLES -->
    <!-- BEGIN THEME STYLES -->
    <link href="{{ URL::asset('assets/css/style-metronic.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/css/style.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/css/style-responsive.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/css/plugins.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/css/pages/tasks.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/css/themes/default.css') }}" rel="stylesheet" type="text/css" id="style_color"/>
    <link href="{{ URL::asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css"/>
    <!-- END THEME STYLES -->
    <link rel="shortcut icon" href="favicon.ico"/>
    @yield('styles')
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="page-header-fixed">

<!-- BEGIN HEADER -->
<div class="header navbar navbar-inverse navbar-fixed-top">
    <!-- BEGIN TOP NAVIGATION BAR -->
    <div class="header-inner">
        <!-- BEGIN LOGO -->
        <a class="navbar-brand" href="{{ URL::to('dashboard/') }}">
            <img src="{{ URL::asset('assets/img/logo.png') }}" alt="CEMCO" class="img-responsive"/>
        </a>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <img src="{{ URL::asset('assets/img/menu-toggler.png') }}" alt=""/>
        </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN TOP NAVIGATION MENU -->
        <ul class="nav navbar-nav pull-right">
            <!-- BEGIN USER LOGIN DROPDOWN -->
            <li class="dropdown user">
                <a href="index.html#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                   data-close-others="true">
                    <img alt="" src="{{URL::asset('assets/img/user.png')}}"/>
                    <span class="username">{{Session::get('user_name')}}</span>
                    <i class="fa fa-angle-down"></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="{{ URL::to('profile') }}"><i class="fa fa-user"></i>Profile</a>
                    <li><a href="{{ URL::to('users/change-password') }}"><i class="fa fa-unlock-o"></i>Change Password</a>
                    <li><a href="{{ URL::to('logout') }}"><i class="fa fa-key"></i> Log Out</a>
                    </li>
                </ul>
            </li>
            <!-- END USER LOGIN DROPDOWN -->
        </ul>
        <!-- END TOP NAVIGATION MENU -->
    </div>

</div>
<!-- END HEADER -->
<div class="clearfix"></div>
<!-- BEGIN CONTAINER -->
<div class="page-container">

    <div id="ajax" class="modal fade" tabindex="-1" > </div>
    <div id="ajax2" class="modal fade" tabindex="-1" > </div>
    <div id="purchaseInvoice" class="modal fade" tabindex="-1" > </div>
    <div id="purchasePayment" class="modal fade" tabindex="-1" > </div>
    <div id="expensePayment" class="modal fade" tabindex="-1" > </div>
    <div id="Expense" class="modal fade" tabindex="-1" > </div>
    <div id="salePayment" class="modal fade" tabindex="-1" > </div>
    <div id="salePayment2" class="modal fade" tabindex="-1" > </div>
    <div id="sale" class="modal fade" tabindex="-1" > </div>
    <div id="stockReport" class="modal fade" tabindex="-1" > </div>
</div>
    <!-- BEGIN SIDEBAR -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <ul class="page-sidebar-menu">
            <li>
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                <div class="sidebar-toggler hidden-phone"></div>
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            </li>
            <li>
                {{--<!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->--}}
            {{--    <form class="sidebar-search" action="extra_search.html" method="POST">--}}
                    {{--<div class="form-container">--}}
                        {{--<div class="input-box">--}}
                            {{--<a href="javascript:;" class="remove"></a>--}}
                            {{--<input type="text" placeholder="Search..."/>--}}
                            {{--<input type="button" class="submit" value=" "/>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</form>--}}
                {{--<!-- END RESPONSIVE QUICK SEARCH FORM -->--}}
            </li>
            <li class="start @if (Request::is('dashboard/'))active @endif">
                <a href="{{ URL::to('dashboard/') }}">
                    <i class="fa fa-home"></i>
                    <span class="title">Dashboard</span>
                    @if (Request::is('dashboard/'))<span class="selected"></span>@endif
                </a>
            </li>
            @if(Session::get('user_role') == 'admin')
            <li class=" @if (Request::is('add')||Request::is('list')) active @endif">
                <a href="javascript:;">
                    <i class="fa fa-group"></i>
                    <span class="title">Users</span>
                    @if (Request::is('users/'))<span class="selected"></span>@endif
                    <span class="arrow @if (Request::is('users/'))open @endif"></span>
                </a>

                <ul class="sub-menu">
                    <li
                    @if (Request::is('add/')) class="active" @endif>
                    <a href="{{ URL::to('add/') }}">Add User </a>
            </li>
            <li
            @if (Request::is('list/')) class="active" @endif>
            <a href="{{ URL::to('list/') }}">User List </a>
            </li>
        </ul>
        </li>


        <li class="@if (Request::is('branchAdd')||Request::is('branchList'))active @endif">
            <a href="javascript:;">
                <i class="fa fa-puzzle-piece"></i>
                <span class="title">Branch</span>
                @if (Request::is('branches/*'))<span class="selected"></span>@endif
                <span class="arrow @if (Request::is('branches/*'))open @endif"></span>
            </a>

                <ul class="sub-menu">
                    <li
                    @if (Request::is('branchAdd/'))class="active"@endif>
                    <a href="{{ URL::to('branchAdd') }}">Add Branch </a>
            </li>
            <li
            @if (Request::is('branchList/'))class="active"@endif>
            <a href="{{ URL::to('branchList') }}">Branch List </a>
            </li>
            </ul>
        </li>
            @endif

        <li class="@if (Request::is('productCategories/*')||Request::is('productsubcategories/*')||Request::is('products/*'))active @endif">
            <a href="javascript:;">
                <i class="fa fa-barcode"></i>
                <span class="title">Products</span>
                @if (Request::is('productCategories/'))<span class="selected"></span>@endif
                <span class="arrow @if (Request::is('productCategories/'))open @endif"></span>
            </a>

            <ul class="sub-menu">
                <li
                @if (Request::is('productCategories/index/'))class="active"@endif>
                <a href="{{ URL::to('productCategories/index/') }}"><i class=""></i>Product Category</a>
        </li>

        <li
        @if (Request::is('productsubcategories/index/'))class="active"@endif>
        <a href="{{ URL::to('productsubcategories/index/') }}"><i class=""></i>Product Sub Category
        </a>
        </li>

        <li
        @if (Request::is('products/index/'))class="active"@endif>
        <a href="{{ URL::to('products/index/') }}">Product List</a>
        </li>

        </ul>
        </li>
            @if(Session::get('user_role') == 'admin')

                <li class="@if (Request::is('imports/*'))active @endif">
            <a href="javascript:;">
                <i class="fa fa-plane"></i>
                <span class="title">Import</span>
                @if (Request::is('imports/'))<span class="selected"></span>@endif
                <span class="arrow @if (Request::is('imports/'))open @endif"></span>
            </a>

            <ul class="sub-menu">
                <li
                @if (Request::is('imports/create'))class="active"@endif>
                <a href="{{ URL::to('imports/create') }}">Create New Import</a>
        </li>
        <li
        @if (Request::is('imports/index'))class="active"@endif>
        <a href="{{ URL::to('imports/index') }}">Import List </a>
        </li>
        </ul>
        </li>
        @endif
        <li class="@if (Request::is('stocks/*'))active @endif">
            <a href="javascript:;">
                <i class="fa fa-archive"></i>
                <span class="title">Stock</span>
                @if (Request::is('stocks/*'))<span class="selected"></span>@endif
                <span class="arrow @if (Request::is('stocks/*'))open @endif"></span>
            </a>

            <ul class="sub-menu">
                <li
                @if (Request::is('stocks/create2'))class="active"@endif>
                <a href="{{ URL::to('stocks/create2') }}">Stock Entry</a>
                 </li>
                <li
                @if (Request::is('stocks/index'))class="active"@endif>
                <a href="{{ URL::to('stocks/index') }}">Stock Entry List </a>
                </li>

        </ul>
        </li>
            @if(Session::get('user_role') == 'admin')
            <li class="@if (Request::is('balancetransfers/*'))active @endif">
                <a href="javascript:;">
                    <i class="fa fa-random"></i>
                    <span class="title">Balance Transfer</span>
                    @if (Request::is('balancetransfers/*'))<span class="selected"></span>@endif
                    <span class="arrow @if (Request::is('balancetransfers/*'))open @endif"></span>
                </a>

                <ul class="sub-menu">
                    <li
                            @if (Request::is('balancetransfers/create'))class="active"@endif>
                        <a href="{{ URL::to('balancetransfers/create') }}">Balance Transfer Entry</a>
                    </li>
                    <li
                            @if (Request::is('balancetransfers/index'))class="active"@endif>
                        <a href="{{ URL::to('balancetransfers/index') }}">Balance Transfer List </a>
                    </li>

                </ul>
            </li>
            @endif
        <li class="@if (Request::is('requisitions/*'))active @endif">
            <a href="javascript:;">
                <i class="fa fa-pencil-square-o"></i>
                <span class="title">Order Requisition</span>
                @if (Request::is('requisitions/*'))<span class="selected"></span>@endif
                <span class="arrow @if (Request::is('requisitions/*'))open @endif"></span>
            </a>

            <ul class="sub-menu">
                @if(Session::get('user_role') != 'manager')
                <li
                @if (Request::is('requisitions/create'))class="active"@endif>
                <a href="{{ URL::to('requisitions/create') }}">Create Order Requisition </a>
        </li>
                @endif
        <li
        @if (Request::is('requisitions/index'))class="active"@endif>
        <a href="{{ URL::to('requisitions/index') }}">Order Requisition List </a>
        </li>

        </ul>
        </li>
            @if(Session::get('user_role') != 'manager')
            <li class="@if (Request::is('accountcategory/*')||Request::is('accountnames/*')||Request::is('sales/*')||Request::is('salesreturn/*')||Request::is('purchases/*')||Request::is('expenses/*'))active @endif">
                <a href="javascript:;">
                    <i class="fa fa-bar-chart-o"></i>
                    <span class="title">Accounts Section</span>
                    @if (Request::is('partilizers/*'))<span class="selected"></span>@endif
                    <span class="arrow @if (Request::is('partilizers/*'))open @endif"></span>
                </a>

                <ul class="sub-menu">
                    <li
                            @if (Request::is('accountcategory/index'))class="active"@endif>
                        <a href="{{ URL::to('accountcategory/index') }}"> Create Account Category </a>
                    </li>
                    <li
                            @if (Request::is('accountnames/index'))class="active"@endif>
                        <a href="{{ URL::to('accountnames/index') }}"> Create New Account </a>
                    </li>
                    <li
                            @if (Request::is('sales/index'))class="active"@endif>
                        <a href="{{ URL::to('sales/index') }}"> Sales </a>
                    </li>
                    <li
                            @if (Request::is('salesreturn/index'))class="active"@endif>
                        <a href="{{ URL::to('salesreturn/index') }}"> Sales Return</a>
                    </li>
                    <li
                            @if (Request::is('purchases/index'))class="active"@endif>
                        <a href="{{ URL::to('purchases/index') }}"> Purchase </a>
                    </li>
                    <li
                            @if (Request::is('expenses/index'))class="active"@endif>
                        <a href="{{ URL::to('expenses/index') }}"> Expense </a>
                    </li>
                    <li
                            @if (Request::is('chequeregister/index'))class="active"@endif>
                        <a href="{{ URL::to('chequeregister/index') }}">Payee Cheque Register </a>
                    </li>

                    <li
                            @if (Request::is('chequeregister/purchase'))class="active"@endif>
                        <a href="{{ URL::to('chequeregister/purchase') }}">Payer Cheque Register </a>
                    </li>
                </ul>
            </li>
            @endif
            @if(Session::get('user_role') == 'admin')
        <li class="@if (Request::is('parties/*')||Request::is('stockInfos/*'))active @endif">
            <a href="javascript:;">
                <i class="fa fa-gears"></i>
                <span class="title">Settings</span>
                @if (Request::is('parties/'))<span class="selected"></span>@endif
                <span class="arrow @if (Request::is('parties/'))open @endif"></span>
            </a>

            <ul class="sub-menu">
                <li
                    @if (Request::is('parties/index/'))class="active"@endif>
                    <a href="{{ URL::to('parties/index/') }}"><i class=""></i> Create Party </a>
                 </li>

                <li
                        @if (Request::is('stockInfos/index/'))class="active"@endif>
                    <a href="{{ URL::to('stockInfos/index/') }}"><i class=""></i> Create Stock </a>
                </li>
        </ul>
        </li>
            @endif
          {{--  <li class="@if (Request::is('searches/*'))active @endif">--}}
                {{--<a href="javascript:;">--}}
                    {{--<i class="fa fa-search"></i>--}}
                    {{--<span class="title">Search</span>--}}
                    {{--@if (Request::is('searches/*'))<span class="selected"></span>@endif--}}
                    {{--<span class="arrow @if (Request::is('searches/*'))open @endif"></span>--}}
                {{--</a>--}}

                {{--<ul class="sub-menu">--}}
                    {{--<li--}}
                            {{--@if (Request::is('searches/entry'))class="active"@endif>--}}
                        {{--<a href="{{ URL::to('searches/entry') }}">Stock Entry </a>--}}
                    {{--</li>--}}
                    {{--<li--}}
                            {{--@if (Request::is('searches/requisition/'))class="active"@endif>--}}
                        {{--<a href="{{ URL::to('searches/requisition') }}">Order Requisition </a>--}}
                    {{--</li>--}}
                    {{--<li--}}
                            {{--@if (Request::is('searches/stock-products'))class="active"@endif>--}}
                        {{--<a href="{{ URL::to('searches/stock-products') }}">Stock Entry By Product </a>--}}
                    {{--</li>--}}

                 {{--</ul>--}}
                {{--</li>--}}
            <li class="@if (Request::is('reports/*'))active @endif">
                <a href="javascript:;">
                    <i class="fa fa-puzzle-piece"></i>
                    <span class="title">Report</span>
                    @if (Request::is('reports/*'))<span class="selected"></span>@endif
                    <span class="arrow @if (Request::is('reports/*'))open @endif"></span>
                </a>

                <ul class="sub-menu">
                    <li style="background-color: #665062"
                            @if (Request::is('reports/stocks'))class="active"@endif>
                        <a href="{{ URL::to('reports/stocks') }}">Stocks </a>
                    </li>
                    <li style="background-color: #665062"
                            @if (Request::is('reports/stocksproducts'))class="active"@endif>
                        <a href="{{ URL::to('reports/stocksproducts') }}">Stock In Hand </a>
                    </li>
                    <li style="background-color: #665062"
                            @if (Request::is('searches/entry'))class="active"@endif>
                        <a href="{{ URL::to('searches/entry') }}">Stock Entry </a>
                    </li>
                    <li style="background-color: #665062"
                            @if (Request::is('searches/stock-products'))class="active"@endif>
                        <a href="{{ URL::to('searches/stock-products') }}">Stock Entry By Product </a>
                    </li>
                    <li style="background-color: #ad71cc"
                            @if (Request::is('searches/requisition/'))class="active"@endif>
                        <a href="{{ URL::to('searches/requisition') }}">Order Requisition </a>
                    </li>
                    @if(Session::get('user_role') != 'manager')
                    <li style="background-color: #006666"
                            @if (Request::is('reports/salesreport'))class="active"@endif>
                        <a href="{{ URL::to('reports/salesreport') }}">Periodic Sales Report</a>
                    </li>
                    <li style="background-color: #006666"
                            @if (Request::is('reports/salesdetails'))class="active"@endif>
                        <a href="{{ URL::to('reports/salesdetails') }}">Sales Details Report</a>
                    </li>
                    <li style="background-color: #006666"
                            @if (Request::is('reports/salesdue'))class="active"@endif>
                        <a href="{{ URL::to('reports/salesdue') }}">Sales Due Report</a>
                    </li>
                    <li style="background-color: #006666"
                            @if (Request::is('reports/salescollection'))class="active"@endif>
                        <a href="{{ URL::to('reports/salescollection') }}">Sales Collection Report</a>
                    </li>
                    <li style="background-color: #134266"
                            @if (Request::is('reports/salesreturn'))class="active"@endif>
                        <a href="{{ URL::to('reports/salesreturn') }}">Sales Return Report</a>
                    </li>
                        <li style="background-color: #134266"
                            @if (Request::is('reports/salesreturndetails'))class="active"@endif>
                            <a href="{{ URL::to('reports/salesreturndetails') }}">Sales Return Details Report</a>
                        </li>
                        <li style="background-color: #134266"
                            @if (Request::is('reports/salespartyledger'))class="active"@endif>
                            <a href="{{ URL::to('reports/salespartyledger') }}">Sales Party-Ledger Report</a>
                        </li>
                    <li style="background-color: #cc5d5e"
                            @if (Request::is('reports/purchasereport'))class="active"@endif>
                        <a href="{{ URL::to('reports/purchasereport') }}">Periodic Purchase Report</a>
                    </li>
                    <li style="background-color: #cc5d5e"
                            @if (Request::is('reports/purchasedetails'))class="active"@endif>
                        <a href="{{ URL::to('reports/purchasedetails') }}">Purchase Details Report</a>
                    </li>
                    <li style="background-color: #cc5d5e"
                            @if (Request::is('reports/purchasedue'))class="active"@endif>
                        <a href="{{ URL::to('reports/purchasedue') }}">Purchase Due Report</a>
                    </li>
                    <li style="background-color: #cc5d5e"
                            @if (Request::is('reports/purchasecollection'))class="active"@endif>
                        <a href="{{ URL::to('reports/purchasecollection') }}">Purchase Payment Report</a>
                    </li>
                        <li style="background-color: #134266"
                            @if (Request::is('reports/purchasepartyledger'))class="active"@endif>
                            <a href="{{ URL::to('reports/purchasepartyledger') }}">Purchase Party-Ledger Report</a>
                        </li>
                    <li style="background-color: #2c91cc"
                            @if (Request::is('reports/expensereport'))class="active"@endif>
                        <a href="{{ URL::to('reports/expensereport') }}">Expense Report</a>
                    </li>
                    <li style="background-color: #2c91cc"
                            @if (Request::is('reports/expensepayment'))class="active"@endif>
                        <a href="{{ URL::to('reports/expensepayment') }}">Expense Payment Report</a>
                    </li>
                    @endif
                    @if(Session::get('user_role') == 'admin')
                    <li style="background-color: #aa6b10"
                            @if (Request::is('reports/balancetransfer'))class="active"@endif>
                        <a href="{{ URL::to('reports/balancetransfer') }}">Account Balance Transfer </a>
                    </li>
                    <li style="background-color: #aa6b10"
                            @if (Request::is('reports/balancetransferreport'))class="active"@endif>
                        <a href="{{ URL::to('reports/balancetransferreport') }}"> Creditor Debtor Report</a>
                    </li>
                    <li style="background-color: #7a5f50"
                            @if (Request::is('reports/accountsreport'))class="active"@endif>
                        <a href="{{ URL::to('reports/accountsreport') }}">Accounts Report</a>
                    </li>
                        @endif

                </ul>
            </li>
            </ul>
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
    <!-- BEGIN PAGE -->
    <!-- BEGIN PAGE -->
    <div class="page-content">

        @yield('content')
    </div>
    <!-- END PAGE -->

<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="footer">
    {{--<div class="footer-inner">--}}
         {{--&copy; CEMCO--}}
    {{--</div>--}}
    {{--<div class="footer-tools">--}}
			{{--<span class="go-top">--}}
			{{--<i class="fa fa-angle-up"></i>--}}
			{{--</span>--}}
    {{--</div>--}}
</div>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="{{ URL::asset('assets/plugins/respond.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/excanvas.min.js') }}"></script>
<![endif]-->
<script src="{{ URL::asset('assets/plugins/jquery-1.10.2.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/jquery-migrate-1.2.1.min.js') }}" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="{{ URL::asset('assets/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js') }}"
        type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js') }}"
        type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}"
        type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/jquery.cookie.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/uniform/jquery.uniform.min.js') }}" type="text/javascript"></script>
<script type="text/javascript"
        src="{{ URL::asset('assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js') }}"></script>

<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript"
        src="{{ URL::asset('assets/plugins/jquery-validation/dist/jquery.validate.min.js') }}"></script>

<script type="text/javascript"
        src="{{ URL::asset('assets/plugins/jquery-validation/dist/additional-methods.min.js') }}"></script>

<script src="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/moment.min.js') }}"
        type="text/javascript"></script>

<script src="{{ URL::asset('assets/scripts/ui-modals.js') }}"
        type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/jquery.sparkline.min.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ URL::asset('assets/plugins/select2/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/plugins/data-tables/jquery.dataTables.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/plugins/data-tables/DT_bootstrap.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-touchspin/bootstrap.touchspin.js') }}"
        type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-modal/js/bootstrap-modal.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-modal/js/bootstrap-modalmanager.js') }}"
        type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ URL::asset('assets/scripts/app.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/scripts/index.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/scripts/tasks.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/scripts/form-validation.js') }}" type="text/javascript"></script>
<!--<script src="{{ URL::asset('assets/scripts/table-managed.js') }}"></script>-->
<script src="{{ URL::asset('assets/scripts/form-components.js') }}"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script type="text/javascript">

    jQuery(document).ready(function () {
        App.init();

        $('#sub_category_table').DataTable({
            "bPaginate": false
        });


        $('#party_table').DataTable({
            "bPaginate": false
        });

       // $('#Expensetable').DataTable();
        $('#imports_table').DataTable({
            "bPaginate": false
        });
        Tasks.initDashboardWidget();


    });

</script>
<!-- END JAVASCRIPTS -->
<script type="text/javascript">  var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-37564768-1']);
    _gaq.push(['_setDomainName', 'keenthemes.com']);
    _gaq.push(['_setAllowLinker', true]);
    _gaq.push(['_trackPageview']);
    (function () {
        var ga = document.createElement('script');
        ga.type = 'text/javascript';
        ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(ga, s);
    })();</script>
@yield('javascript')
</body>
<!-- END BODY -->
</html>