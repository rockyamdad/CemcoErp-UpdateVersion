<!DOCTYPE html>

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
    <link href="{{URL::asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{URL::asset('assets/plugins/uniform/css/uniform.default.css')}}" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css" href="{{URL::asset('assets/plugins/select2/select2_metro.css')}}"/>
    <!-- END PAGE LEVEL SCRIPTS -->
    <!-- BEGIN THEME STYLES -->
    <link href="{{URL::asset('assets/css/style-metronic.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{URL::asset('assets/css/style.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{URL::asset('assets/css/style-responsive.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{URL::asset('assets/css/plugins.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{URL::asset('assets/css/themes/default.css')}}" rel="stylesheet" type="text/css" id="style_color"/>
    <link href="{{URL::asset('assets/css/pages/login.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{URL::asset('assets/css/custom.css')}}" rel="stylesheet" type="text/css"/>
    <!-- END THEME STYLES -->
    <link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- BEGIN BODY -->
<body class="login">
<!-- BEGIN LOGO -->
<div class="logo">
    <img src="{{URL::asset('assets/img/logo.png')}}" alt=""/>
</div>

<div class="content">
    @yield('content')
</div>

<div class="copyright">
    2013 &copy; Cemco Dashboard Template.
</div>
<!-- END COPYRIGHT -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="{{ URL::asset('assets/plugins/respond.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/excanvas.min.js') }}"></script>
<![endif]-->
<script src="{{URL::asset('assets/plugins/jquery-1.10.2.min.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('assets/plugins/jquery-migrate-1.2.1.min.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('assets/plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js')}}"
        type="text/javascript"></script>
<script src="{{URL::asset('assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}"
        type="text/javascript"></script>
<script src="{{URL::asset('assets/plugins/jquery.blockui.min.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('assets/plugins/jquery.cookie.min.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('assets/plugins/uniform/jquery.uniform.min.js')}}" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{URL::asset('assets/plugins/jquery-validation/dist/jquery.validate.min.js')}}"
        type="text/javascript"></script>
<script type="text/javascript"
        src="{{ URL::asset('assets/plugins/jquery-validation/dist/additional-methods.min.js') }}"></script>

<script type="text/javascript" src="{{URL::asset('assets/plugins/select2/select2.min.js')}}"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{URL::asset('assets/scripts/app.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('assets/scripts/login.js')}}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
    @
    yield('javascript');
    jQuery(document).ready(function () {
        App.init();

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
</body>
<!-- END BODY -->
</html>