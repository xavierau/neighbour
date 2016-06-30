<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <meta name="csrf_token" content="{{csrf_token()}}"/>
    <meta name="appName" content="{{getSettingValue($settings, 'appName')}}"/>
    <!--[if IE]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <![endif]-->
    <title>{{getSettingValue($settings, 'appName')}}</title>
    <!-- BOOTSTRAP CORE CSS -->
    <link href="/assets/css/bootstrap.css" rel="stylesheet"/>
    <!-- ION ICONS STYLES -->
    <link href="/assets/css/ionicons.css" rel="stylesheet"/>
    <!-- FONT AWESOME ICONS STYLES -->
    <link href="/assets/css/font-awesome.css" rel="stylesheet"/>
    <!-- FANCYBOX POPUP STYLES -->
    <link href="/assets/js/source/jquery.fancybox.css" rel="stylesheet"/>
    <!-- STYLES FOR VIEWPORT ANIMATION -->
    <link href="/assets/css/animations.min.css" rel="stylesheet"/>
    <!-- CUSTOM CSS -->
    <link href="/assets/css/style-blue.css" rel="stylesheet"/>

    <link href="/css/app.css" rel="stylesheet">


    <!-- HTML5 Shiv and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        body {
            position:relative
        }
        .navbar-inverse .navbar-nav > .open > a,
        .navbar-inverse .navbar-nav > .open > a:hover,
        .navbar-inverse .navbar-nav > .open > a:focus {
            color: #fff;
            background-color: transparent;
        }
        .modal{
            -webkit-overflow-scrolling: auto
        }
    </style>

    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-79828628-1', 'auto');
        ga('send', 'pageview');

    </script>

</head>
<body data-target="#menu-section" id="app">

<router-view></router-view>

<!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME -->
<!-- CORE JQUERY -->
<script src="/assets/js/jquery-1.11.1.js"></script>
<!-- BOOTSTRAP SCRIPTS -->
<script src="/assets/js/bootstrap.js"></script>
<!-- EASING SCROLL SCRIPTS PLUGIN -->
<script src="/assets/js/vegas/jquery.vegas.min.js"></script>
<!-- VEGAS SLIDESHOW SCRIPTS -->
<script src="/assets/js/jquery.easing.min.js"></script>
<!-- FANCYBOX PLUGIN -->
<script src="/assets/js/source/jquery.fancybox.js"></script>
<!-- ISOTOPE SCRIPTS -->
<script src="/assets/js/jquery.isotope.js"></script>
<!-- VIEWPORT ANIMATION SCRIPTS   -->
<script src="/assets/js/appear.min.js"></script>
<script src="/assets/js/animations.min.js"></script>
<!-- CUSTOM SCRIPTS -->
<script src="/assets/js/customApp.js"></script>

<script>
    var user ={!! Auth::user() !!};
</script>
<script src="/js/app.js"></script>
</body>

</html>
