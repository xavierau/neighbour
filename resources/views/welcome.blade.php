<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <!--[if IE]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <![endif]-->
    <title>Localhood</title>
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



</head>
<body data-spy="scroll" data-target="#menu-section">
<!--MENU SECTION START-->
<div class="navbar navbar-inverse navbar-fixed-top scroll-me" id="menu-section">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">

                Localhood

            </a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#home">Home</a></li>
                <li><a href="#services">SERVICES</a></li>
                <li><a href="#contact">CONTACT</a></li>
                @if(Auth::guest())
                    <li><a href="" data-toggle="modal" data-target="#signinModal">SIGN IN</a></li>
                @endif
            </ul>
        </div>

    </div>
</div>
<!--MENU SECTION END-->
<!--HOME SECTION START-->
<div id="home">

    <div class="container">
        <div id="status">
        </div>
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2 ">
                <div id="carousel-slider" data-ride="carousel" class="carousel slide  animate-in"
                     data-anim-type="fade-in-up">

                    <div class="carousel-inner">
                        <div class="item active">
                            <h3>
                                This is the main landing page.
                            </h3>
                            <p>
                                You have to put something here for your potential customer.
                                Lorem ipsumdolor sitamet, consect adipiscing elit
                                Lorem ipsumdolor sitamet, consect adipiscing elit.
                                Lorem ipsumdolor sitamet, consect adipiscing elit
                                Lorem ipsumdolor sitamet, consect adipiscing elit.
                            </p>
                        </div>
                        <div class="item">
                            <h3>
                                Lorem ipsumdolor sitamet, consect adipiscing elit
                            </h3>
                            <p>
                                Lorem ipsumdolor sitamet, consect adipiscing elit
                                Lorem ipsumdolor sitamet, consect adipiscing elit.
                                Lorem ipsumdolor sitamet, consect adipiscing elit
                                Lorem ipsumdolor sitamet, consect adipiscing elit.
                            </p>
                        </div>

                    </div>


                </div>


            </div>
        </div>
        <div class="row animate-in" data-anim-type="fade-in-up">
            <div class="col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3 col-lg-8 col-lg-offset-2 scroll-me">

                <button class="btn-success btn-lg" data-toggle="modal" data-target="#signupModal">Join Now</button>
                {{--<form action="" class="form">--}}
                {{--<div class="form-group">--}}
                {{--<input type="text" class="form-control">--}}
                {{--</div>--}}
                {{--<button class="btn btn-success">Join Now</button>--}}
                {{--</form>--}}


                {{--<h2 >--}}
                {{--This line is fixed so you can write anything--}}

                {{--Join Now--}}

                {{--</h2>--}}
                <div class="social">
                    <a href="#" class="btn button-custom btn-custom-one"><i class="fa fa-facebook "></i></a>
                    <a href="#" class="btn button-custom btn-custom-one"><i class="fa fa-twitter"></i></a>
                    {{--<a href="#" class="btn button-custom btn-custom-one" ><i class="fa fa-google-plus "></i></a>--}}
                    {{--<a href="#" class="btn button-custom btn-custom-one" ><i class="fa fa-linkedin "></i></a>--}}
                    {{--<a href="#" class="btn button-custom btn-custom-one" ><i class="fa fa-pinterest "></i></a>--}}
                    {{--<a href="#" class="btn button-custom btn-custom-one" ><i class="fa fa-github "></i></a>--}}
                </div>
                {{--<a href="#services" class=" btn button-custom btn-custom-two">See Service List </a>--}}
            </div>
        </div>
    </div>

</div>
<!--HOME SECTION END-->
<!--SERVICE SECTION START-->
<section id="services">
    <div class="container">
        <div class="row text-center header">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 animate-in" data-anim-type="fade-in-up">
                <h3>Our Services</h3>
                <hr/>
            </div>
        </div>
        <div class="row animate-in" data-anim-type="fade-in-up">
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <div class="services-wrapper">
                    <i class="ion-document"></i>
                    <h3>Consectetur tellus nec</h3>
                    Morbi mollis lectus et ipsum sollicitudin varius.
                    Aliquam tempus ante placerat, consectetur tellus nec, porttitor nulla.
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <div class="services-wrapper">
                    <i class="ion-scissors"></i>
                    <h3>Consectetur tellus nec</h3>
                    Morbi mollis lectus et ipsum sollicitudin varius.
                    Aliquam tempus ante placerat, consectetur tellus nec, porttitor nulla.
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <div class="services-wrapper">
                    <i class="ion-clipboard"></i>
                    <h3>Consectetur tellus nec</h3>
                    Morbi mollis lectus et ipsum sollicitudin varius.
                    Aliquam tempus ante placerat, consectetur tellus nec, porttitor nulla.
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <div class="services-wrapper">
                    <i class="ion-calendar"></i>
                    <h3>Consectetur tellus nec</h3>
                    Morbi mollis lectus et ipsum sollicitudin varius.
                    Aliquam tempus ante placerat, consectetur tellus nec, porttitor nulla.
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <div class="services-wrapper">
                    <i class="ion-erlenmeyer-flask"></i>
                    <h3>Consectetur tellus nec</h3>
                    Morbi mollis lectus et ipsum sollicitudin varius.
                    Aliquam tempus ante placerat, consectetur tellus nec, porttitor nulla.
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <div class="services-wrapper">
                    <i class="ion-monitor"></i>
                    <h3>Consectetur tellus nec</h3>
                    Morbi mollis lectus et ipsum sollicitudin varius.
                    Aliquam tempus ante placerat, consectetur tellus nec, porttitor nulla.
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <div class="services-wrapper">
                    <i class="ion-pinpoint"></i>
                    <h3>Consectetur tellus nec</h3>
                    Morbi mollis lectus et ipsum sollicitudin varius.
                    Aliquam tempus ante placerat, consectetur tellus nec, porttitor nulla.
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <div class="services-wrapper">
                    <i class="ion-tshirt-outline"></i>
                    <h3>Consectetur tellus nec</h3>
                    Morbi mollis lectus et ipsum sollicitudin varius.
                    Aliquam tempus ante placerat, consectetur tellus nec, porttitor nulla.
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <div class="services-wrapper">
                    <i class="ion-speedometer"></i>
                    <h3>Consectetur tellus nec</h3>
                    Morbi mollis lectus et ipsum sollicitudin varius.
                    Aliquam tempus ante placerat, consectetur tellus nec, porttitor nulla.
                </div>
            </div>
        </div>
    </div>
</section>
<!--SERVICE SECTION END-->
<!--CONTACT SECTION START-->
<section id="contact">
    <div class="container">
        <div class="row text-center header animate-in" data-anim-type="fade-in-up">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                <h3>Contact Details </h3>
                <hr/>

            </div>
        </div>

        <div class="row animate-in" data-anim-type="fade-in-up">

            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <div class="contact-wrapper">
                    <h3>We Are Social</h3>
                    <p>
                        Aliquam tempus ante placerat,
                        consectetur tellus nec, porttitor nulla.
                    </p>
                    <div class="social-below">
                        <a href="#" class="btn button-custom btn-custom-two"> Facebook</a>
                        <a href="#" class="btn button-custom btn-custom-two"> Twitter</a>
                        <a href="#" class="btn button-custom btn-custom-two"> Google +</a>
                    </div>
                </div>

            </div>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <div class="contact-wrapper">
                    <h3>Quick Contact</h3>
                    <h4><strong>Email : </strong> info@yuordomain.com </h4>
                    <h4><strong>Call : </strong> +09-88-99-77-55 </h4>
                    <h4><strong>Skype : </strong> Yujhaeu78 </h4>
                </div>

            </div>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <div class="contact-wrapper">
                    <h3>Address : </h3>
                    <h4>230/45 , New way Lane , </h4>
                    <h4>United States</h4>
                    <div class="footer-div">
                        &copy; 2015 YourDomain | <a href="http://www.designbootstrap.com/" target="_blank">by
                            DesignBootstrp</a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>
<!--CONTACT SECTION END-->

<!--SIGNUP MODAL -->
<div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel" style="color:black">Sign Up Form</h4>
            </div>
            <form action="register" method="POST">
                <div class="modal-body">
                    {{csrf_field()}}
                    <input type="email" name="email" class="form-control" placeholder="Your Email" required>
                    @if ($errors->has('email'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                    @endif
                    <input type="text" name="name" class="form-control" placeholder="User Name" required>
                    @if ($errors->has('name'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                    @endif
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                    @if ($errors->has('password'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                    @endif
                    <input type="password" name="password_confirmation" class="form-control"
                           placeholder="Confirm your password" required>
                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                    @endif

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Sign Up"/>
                </div>
            </form>
        </div>
    </div>
</div>
<!--SIGNUP MODAL END-->


<!--SIGNIN MODAL -->
<div class="modal fade" id="signinModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel" style="color:black">Sign In Form</h4>
            </div>
            <form action="login" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <a href="/facebook/register" class="btn btn btn-primary">Login With Facebook</a>
                    </div>
                    {{csrf_field()}}
                    <input type="email" name="email" class="form-control" placeholder="Your Email" required>
                    @if ($errors->has('email'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                    @endif

                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                    @if ($errors->has('password'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                    @endif


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Login"/>
                </div>
            </form>
        </div>
    </div>
</div>
<!--SIGNIN MODAL END-->


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
