<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <meta name="token" content="{{csrf_token()}}"/>
    <!--[if IE]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <![endif]-->
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
    <!-- HTML5 Shiv and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
        h3#tagline {
            line-height: 90px;
        }

        h3#tagline span.also {
            position: relative;
            top: -51px;
            margin-left: -15px;
            margin-right: -15px;
        }

        h3#tagline span.also:after {
            content: "";
            display: inline-block;
            position: absolute;
            background-image: url("{{asset('assets/img/check.png')}}");
            background-size: cover;
            width: 50px;
            height: 50px;
            color: white;
            left: -2px;
            top: 40px;
            -ms-transform: rotate(20deg); /* IE 9 */
            -webkit-transform: rotate(20deg); /* Safari */
            transform: rotate(20deg);
        }

        #carousel-slider {
            padding: 0 20px 5px 20px;
        }

        #home {
            text-align: center;
            padding-top: 30px;
            padding-bottom: 30px;
        }

        h3#tagline span.also{
            display: inline-block;
            -ms-transform: rotate(-20deg); /* IE 9 */
            -webkit-transform: rotate(-20deg); /* Safari */
            transform: rotate(-20deg);
        }
        .row div.first-container{
            margin-top: 100px;
            margin-bottom: 200px;
        }
        .button-custom.btn-custom-two.btn-sm{
            margin-top: 10px;
        }

    </style>


</head>
<body data-spy="scroll" data-target="#menu-section" id='body'>
<!--MENU SECTION START-->
<div class="navbar navbar-inverse navbar-fixed-top scroll-me" id="menu-section">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">
                {{Cache::get('settings')->first()->value}}
            </a>
           </div>

    </div>
</div>
<!--MENU SECTION END-->
<!--HOME SECTION START-->
<div id="home">
    <br>
    <br>
    <div class="container">
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
            {!! csrf_field() !!}

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label class="col-md-4 control-label">E-Mail Address</label>

                <div class="col-md-6">
                    <input type="email" class="form-control" name="email" value="{{ $email or old('email') }}">

                    @if ($errors->has('email'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label class="col-md-4 control-label">Password</label>

                <div class="col-md-6">
                    <input type="password" class="form-control" name="password">

                    @if ($errors->has('password'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <label class="col-md-4 control-label">Confirm Password</label>
                <div class="col-md-6">
                    <input type="password" class="form-control" name="password_confirmation">

                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-btn fa-refresh"></i> Reset your password
                    </button>
                </div>
            </div>
        </form>
    </div>

</div>


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
<script src="/assets/js/custom.js"></script>


</body>

</html>
