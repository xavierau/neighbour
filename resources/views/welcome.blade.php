<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="token" content="{{csrf_token()}}" />
	<!--[if IE]>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<![endif]-->
	<!-- BOOTSTRAP CORE CSS -->
    <link href="/assets/css/bootstrap.css" rel="stylesheet" />
	<!-- ION ICONS STYLES -->
    <link href="/assets/css/ionicons.css" rel="stylesheet" />
	<!-- FONT AWESOME ICONS STYLES -->
    <link href="/assets/css/font-awesome.css" rel="stylesheet" />
	<!-- FANCYBOX POPUP STYLES -->
    <link href="/assets/js/source/jquery.fancybox.css" rel="stylesheet" />
	<!-- STYLES FOR VIEWPORT ANIMATION -->
    <link href="/assets/css/animations.min.css" rel="stylesheet" />
	<!-- CUSTOM CSS -->
    <link href="/assets/css/style-blue.css" rel="stylesheet" />
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

        h3#tagline span.also {
	        display: inline-block;
	        -ms-transform: rotate(-20deg); /* IE 9 */
	        -webkit-transform: rotate(-20deg); /* Safari */
	        transform: rotate(-20deg);
        }

        .row div.first-container {
	        margin-top: 100px;
	        margin-bottom: 200px;
        }

        .button-custom.btn-custom-two.btn-sm {
	        margin-top: 10px;
        }

    </style>


</head>
<body data-spy="scroll" data-target="#menu-section" id='body'>
<!--MENU SECTION START-->
<div class="navbar navbar-inverse navbar-fixed-top scroll-me" id="menu-section">
    <div class="container">
        <div class="navbar-header">
            {{--<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">--}}
	        {{--<span class="icon-bar"></span>--}}
	        {{--<span class="icon-bar"></span>--}}
	        {{--<span class="icon-bar"></span>--}}
	        {{--</button>--}}
	        <a class="navbar-brand" href="#">
                {{App\Setting::appName()}}
            </a>
            <a href="#" class="btn button-custom btn-custom-two btn-sm pull-right" data-toggle="modal"
               data-target="#signinModal"> Log In</a>
            <a href="#" class="btn button-custom btn-custom-two btn-sm pull-right" data-toggle="modal"
               data-target="#signupModal"> Join Now</a>
        </div>
	    {{--<div class="navbar-collapse collapse">--}}
	    {{--<ul class="nav navbar-nav navbar-right">--}}
	    {{--<li><a href="#home">Home</a></li>--}}
	    {{--<li><a href="#services">SERVICES</a></li>--}}
	    {{--<li><a href="#contact">CONTACT</a></li>--}}
	    {{--@if(Auth::guest())--}}
	    {{--<li><a href="" data-toggle="modal" data-target="#signinModal">SIGN IN</a></li>--}}
	    {{--@endif--}}
	    {{--</ul>--}}
	    {{--</div>--}}

    </div>
</div>
<!--MENU SECTION END-->
<!--HOME SECTION START-->
<div id="home">

    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2 first-container">
                <div id="carousel-slider" data-ride="carousel" class="carousel slide  animate-in"
                     data-anim-type="fade-in-up">

                    <div class="carousel-inner">
                        <div class="item active">
                            <h3 id="tagline">
                                LocalHood, because Neighbors
                                <br><span class="also">also</span> care
                            </h3>
                            <br>
	                        {{--<div class="row animate-in" data-anim-type="fade-in-up">--}}
	                        {{--<div class="social-below">--}}
	                        {{--<a href="#" class="btn button-custom btn-custom-two " data-toggle="modal" data-target="#signupModal"> Join Now</a>--}}
	                        {{--<a href="#" class="btn button-custom btn-custom-two" data-toggle="modal" data-target="#signinModal"> Log In</a>--}}
	                        {{--</div>--}}
	                        {{--</div>--}}
	                        {{--<p>--}}
	                        {{--Localhood has been built to foster communication and interaction, both virtually and--}}
	                        {{--in-person, within your neighborhood.--}}
	                        {{--By being friendly neighbors and making neighbors friends. Let's make our neighborhood an--}}
	                        {{--even more fun place to live.--}}
	                        {{--</p>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row animate-in" data-anim-type="fade-in-up">

            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="margin-bottom: 30px">
                <div class="contact-wrapper">
                    <h3>We Are Social</h3>
                    <p class="text-justify" style="line-height: 25px">
                        Localhood has been built to foster communication and interaction, both virtually and
                        in-person, within your neighborhood.
                        By being friendly neighbors and making neighbors friends. Let's make our neighborhood an
                        even more fun place to live.
                    </p>
                    <div class="social-below">
                        <a href="#" class="btn button-custom btn-custom-two"> Facebook</a>
                        <a href="#" class="btn button-custom btn-custom-two"> Twitter</a>
                        <a href="#" class="btn button-custom btn-custom-two"> Google +</a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="margin-bottom: 30px">
                <div class="contact-wrapper">
                    <h3>Contact Details.</h3>
                    <h4><strong>Email : </strong> Info@iccommunity.net </h4>
                    <h4><strong>Wazzap : </strong> 61098138 </h4>
                </div>

            </div>
	        {{--<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">--}}
	        {{--<div class="contact-wrapper">--}}
	        {{--<h3>Address : </h3>--}}
	        {{--<h4>230/45 , New way Lane , </h4>--}}
	        {{--<h4>United States</h4>--}}
	        {{--<div class="footer-div">--}}
	        {{--&copy; 2015 YourDomain | <a href="http://www.designbootstrap.com/" target="_blank">by--}}
	        {{--DesignBootstrp</a>--}}
	        {{--</div>--}}
	        {{--</div>--}}
	
	        {{--</div>--}}

        </div>
    </div>

</div>
<!--HOME SECTION END-->
{{--<section id="contact">--}}
{{--<div class="container">--}}
{{--<div class="row text-center header animate-in" data-anim-type="fade-in-up">--}}
{{--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">--}}
{{--<h3>Contact Details </h3>--}}
{{--<hr/>--}}
{{--</div>--}}
{{--</div>--}}

{{--<div class="row animate-in" data-anim-type="fade-in-up">--}}

{{--<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">--}}
{{--<div class="contact-wrapper">--}}
{{--<h3>We Are Social</h3>--}}
{{--<p>--}}
{{--Aliquam tempus ante placerat,--}}
{{--consectetur tellus nec, porttitor nulla.--}}
{{--</p>--}}
{{--<div class="social-below">--}}
{{--<a href="#" class="btn button-custom btn-custom-two"> Facebook</a>--}}
{{--<a href="#" class="btn button-custom btn-custom-two"> Twitter</a>--}}
{{--<a href="#" class="btn button-custom btn-custom-two"> Google +</a>--}}
{{--</div>--}}
{{--</div>--}}

{{--</div>--}}
{{--<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">--}}
{{--<div class="contact-wrapper">--}}
{{--<h3>Contact Details.</h3>--}}
{{--<h4><strong>Email : </strong> Info@iccommunity.net </h4>--}}
{{--<h4><strong>Wazzap : </strong> 61098138 </h4>--}}
{{--</div>--}}

{{--</div>--}}
{{--<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">--}}
{{--<div class="contact-wrapper">--}}
{{--<h3>Address : </h3>--}}
{{--<h4>230/45 , New way Lane , </h4>--}}
{{--<h4>United States</h4>--}}
{{--<div class="footer-div">--}}
{{--&copy; 2015 YourDomain | <a href="http://www.designbootstrap.com/" target="_blank">by--}}
{{--DesignBootstrp</a>--}}
{{--</div>--}}
{{--</div>--}}

{{--</div>--}}

{{--</div>--}}
{{--</div>--}}
{{--</section>--}}
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
	                <input type="text" name="first_name" class="form-control" placeholder="First Name" required>
	                @if ($errors->has('first_name'))
		                <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
	                @endif
	                <input type="text" name="last_name" class="form-control" placeholder="Last Name" required>
	                @if ($errors->has('last_name'))
		                <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
	                @endif
	                <select class="form-control" name="city_id">
                        @foreach($cities as $city)
			                <option value="{{$city->id}}">{{$city->label}}</option>
		                @endforeach
                    </select>
	                @if ($errors->has('city_id'))
		                <span class="help-block">
                                        <strong>{{ $errors->first('city_id') }}</strong>
                                    </span>
	                @endif
	
	                <select name="clan_id" class="form-control" required>
                        @foreach($buildings as $index=>$building)
			                <option value="{{$building->id}}"
			                        @if($index == 0) selected @endif>{{$building->label}}</option>
		                @endforeach
                    </select>
	                @if ($errors->has('clanId'))
		                <span class="help-block">
                                        <strong>{{ $errors->first('clanId') }}</strong>
                                    </span>
	                @endif
	
	                <input type="email" name="email" class="form-control" placeholder="Email" required>
	                @if ($errors->has('email'))
		                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
	                @endif
	
	
	                <div class="" style="position: relative">
                        <input type="password" name="password" id="signupPassword" class="form-control"
                               placeholder="Password" required>
                        <span style="position: absolute; color: black; top: 7px; right: 10px;"
                              data-toggle="tooltip"
                              data-placement="left"
                              title="You password should contain at least 1 letter and 1 number and has at least 5 characters."
                        ><i class="fa fa-info-circle" aria-hidden="true"></i></span>
                        <span style="position: absolute; color: black; top: 7px; right: 30px;"
                              onclick="showPassword(this)"><i class="fa fa-eye" aria-hidden="true"></i></span>
		                @if ($errors->has('password'))
			                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
		                @endif
                    </div>
                    <div style="position: relative">
                         <input type="password" name="password_confirmation" class="form-control"
                                placeholder="Confirm your password"
                                required />
                        <span
		                        style="position: absolute; color: black; top: 7px; right: 10px;"
		                        onclick="showPassword(this)"><i class="fa fa-eye" aria-hidden="true"></i></span>
	
	                    @if ($errors->has('password_confirmation'))
		                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
	                    @endif
                    </div>
	
	                {{----}}
	                {{--<input type="hidden" name="clan_id" class="form-control" required value="{{App\Clan::first()->id}}">--}}
	                {{--@if ($errors->has('password_confirmation'))--}}
	                {{--<span class="help-block">--}}
	                {{--<strong>{{ $errors->first('clan_id') }}</strong>--}}
	                {{--</span>--}}
	                {{--@endif--}}

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Sign Up" />
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
                <h4 class="modal-title" id="myModalLabel" style="color:black">Log In Form</h4>
            </div>
            <form action="login" method="POST">
                <div class="modal-body clearfix" style="color:black">
                    <label> Log In With </label>
                    <div class="form-group">
                        <a href="/facebook/register" class="btn btn btn-primary btn-block">Facebook</a>
                    </div>

                    <div class="form-group">
                        <a href="#" class="btn btn btn-primary btn-block">Twitter</a>
                    </div>
                    <div class="form-group">
                        <a href="#" class="btn btn btn-primary btn-block">LinkedIn</a>
                    </div>
	                {{csrf_field()}}
	                <p class="text-center"> or </p>
                    <input type="email" name="email" class="form-control" placeholder="Your Email" required>
	                @if ($errors->has('email'))
		                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
	                @endif
	                <div style="position: relative">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                        <span
		                        style="position: absolute; color: black; top: 7px; right: 10px;"
		                        onclick="showPassword(this)"><i class="fa fa-eye" aria-hidden="true"></i></span>
		                @if ($errors->has('password'))
			                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
		                @endif
                    </div>
	                
	                <div class="clearfix">
                        <div class="checkbox" style="display: inline-block">
                            <label style="color: black">
                                <input type="checkbox" name="remember"> Remember me
                            </label>
                        </div>
                        <div class="pull-right" style="margin-top: 10px; margin-bottom: 10px;">
                            <a style="color:Grey" onclick="showResetModal(event)">Forget Password</a>
                        </div>
                    </div>





                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Log In" />
                </div>
            </form>
        </div>
    </div>
</div>
<!--SIGNIN MODAL END-->

<!--RESETPASSWORD MODAL -->
<div class="modal fade" id="resetPasswordModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
			                aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel" style="color:black">Reset your Password</h4>
            </div>
            <form onsubmit="resetPassword(event)">
                <div class="modal-body" style="color:black">
                    <p>In order to reset your password, please insert your Email address below</p>
	                {{csrf_field()}}
	                <input type="email" name="resetEmail" id="resetEmail" class="form-control" placeholder="Your Email"
	                       required autofocus>
	                @if ($errors->has('email'))
		                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
	                @endif
	                <p>An email will be sent to your Email address in order to reset password</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Send" />
                </div>
            </form>
        </div>
    </div>
</div>
<!--RESETPASSWORD MODAL END-->


@if(session()->has('registration'))
	<!--REGISTRATION SUCCESS MODAL -->
	<div class="modal fade" id="registrationSuccess" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
			                aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel" style="color:black">Registration Success</h4>
            </div>
                <div class="modal-body" style="color:black">
                    <p>Congratulations on joining the LocalHood Network of {{session()->get('registration')}}!
                        A confirmation email will be sent to your email address within 48 hours.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
        </div>
    </div>
</div>
<!--REGISTRATION SUCCESS MODAL END-->
@endif


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

<script>
    $(function () {
	    $('[data-toggle="tooltip"]').tooltip();
    });

    @if(session()->has('from'))
        @if(session("from") == "register")
            $("#signupModal").modal("show")
    @endif

	@if(session("from") == "login")
		$("#signinModal").modal("show")
    @endif
@endif


@if(session()->has("registration"))
	$("#registrationSuccess").modal("show")
    @endif


    function showResetModal(e) {
	    e.preventDefault();
	    $("#signinModal").modal("hide");
	    $("#resetPasswordModal").modal("show");
    }

    function showPassword(eye) {
	    var el = $(eye).siblings('input')
	    el.attr('type', "text")
	
	    setTimeout(function () {
		    el.attr('type', "password")
	    }, 3000)
    }
    function resetPassword(e) {
	    e.preventDefault();
	    console.log(e.target.resetEmail.value);
	    console.log(window.location);
	
	
	    var data = {
		    email   : e.target.resetEmail.value,
		    "_token": $("meta[name='token']").attr("content")
	    };
	
	    console.log(data);
	
	    var url = window.location.origin + "/password/email";
	
	    $.post(url, data)
	     .done(function (response) {
		     if (response.hasOwnProperty("fail")) {
			     alert("Your Email is not recogenised by our database. Kindly re-enter a valid E-mail address.");
		     } else {
			     e.target.resetEmail.value = "";
			     $("#resetPasswordModal").modal("hide");
			     alert("Reset Password Email will send to you soon!");
		     }
	     })
	     .fail(function (response) {
		     alert("request fail due to system error. Try again later.");
		     console.log(response);
	     });
	    return false;
    }
</script>

</body>

</html>
