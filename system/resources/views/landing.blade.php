<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="Let your online audience know about your upcoming project launch whether it's an event, a new website, product or service.">
    <meta name="author" content="Inovatik">
        <!-- OG Meta Tags to improve the way the post looks when you share the page on LinkedIn, Facebook, Google+ -->
	<meta property="og:site_name" content="" /> <!-- website name -->
	<meta property="og:site" content="" /> <!-- website link -->
	<meta property="og:title" content=""/> <!-- title shown in the actual shared post -->
	<meta property="og:description" content="" /> <!-- description shown in the actual shared post -->
	<meta property="og:image" content="" /> <!-- image link, make sure it's jpg -->
	<meta property="og:url" content="" /> <!-- where do you want your post to link to -->
	<meta property="og:type" content="article" />

    <!-- Website Title -->
    <title>Rusunawa - Coming Soon</title>
    
    <!-- Styles -->
	<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,600,700,700i" rel="stylesheet">
    <link href="{{ asset('assets/landing/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/landing/css/fontawesome-all.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/landing/css/magnific-popup.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/landing/css/styles.css') }}" rel="stylesheet">
	
	<!-- Favicon  -->
    <link rel="icon" href="images/favicon.png">
</head>
<body data-spy="scroll" data-target=".fixed-top">

    <!-- Preloader -->
	<div class="spinner-wrapper">
        <div class="spinner">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>
    <!-- end of preloader -->  

    
    <!-- Header -->
	<header id="header">
        
        <!-- Logo And Details -->
        <div class="logo-and-details-wrapper">
            
            <!-- Logo Image -->
            
            <!-- Logo Text -->
            <!-- <a class="logo-txt" href="index.html">Bono</a> -->

            <div class="contact-details">
                <ul class="list-unstyled">
                    <li class="list-inline-item "><a class="button-solid" href="{{url('login')}}">Login</a></li>
                </ul>
            </div> 
        </div> <!-- end of logo-and-details-wrapper -->
        <!-- end of logo and details -->

        <div class="clearfix"></div>
        
        <!-- Header Content -->
        <div class="header-content">
            <div class="container">
                
                <h1>Sistem Informasi Rusunawa <span id="js-rotating">Kota, Magelang</span></h1>
            </div> <!-- end of container -->
        </div> <!-- end of header-content -->
        <!-- end of header content -->

        <!-- Social Links -->
        <div class="social-links-container">
            <span class="fa-stack fa-lg">
                <a href="#your-link">
                    <i class="fas fa-circle fa-stack-2x facebook"></i>
                    <i class="fab fa-facebook-f fa-stack-1x"></i>
                </a>
            </span>
            <span class="fa-stack fa-lg">
                <a href="#your-link">
                    <i class="fas fa-circle fa-stack-2x twitter"></i>
                    <i class="fab fa-twitter fa-stack-1x"></i>
                </a>
            </span>
            <span class="fa-stack fa-lg">
                <a href="#your-link">
                    <i class="fas fa-circle fa-stack-2x instagram"></i>
                    <i class="fab fa-instagram fa-stack-1x"></i>
                </a>
            </span>
            <span class="fa-stack fa-lg">
                <a href="#your-link">
                    <i class="fas fa-circle fa-stack-2x linkedin"></i>
                    <i class="fab fa-linkedin-in fa-stack-1x"></i>
                </a>
            </span>
            <span class="fa-stack fa-lg">
                <a href="#your-link">
                    <i class="fas fa-circle fa-stack-2x dribbble"></i>
                    <i class="fab fa-dribbble fa-stack-1x"></i>
                </a>
            </span>
        </div> <!-- end of social-links-container -->
        <!-- end of social links -->

    </header> 
    <!-- end of header -->


    <!-- Form Lightbox -->
	<div id="lightbox-form" class="lightbox-form zoom-anim-dialog mfp-hide">
        <div class="row">
            <button title="Close (Esc)" type="button" class="mfp-close x-button">×</button>
            <div class="col-lg-12">
                <p>Use the form below to get in touch with us or send an email using <a href="mailto:contact@bono.com">contact@bono.com</a></p>
                
                <!-- Contact Form -->
                <form id="ContactForm" data-toggle="validator" data-focus="false">
                    <div class="form-group">
                        <input type="text" class="form-control-input" id="firstname" required>
                        <label class="label-control" for="firstname">First name</label>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control-input" id="lastname" required>
                        <label class="label-control" for="lastname">Last name</label>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control-input" id="email" required>
                        <label class="label-control" for="email">Email address</label>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control-textarea" id="message" required></textarea>
                        <label class="label-control" for="message">Your message</label>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group checkbox">
                        <input type="checkbox" id="terms" value="Agreed-to-Terms" required>I allow Bono to use my data for the event registration</a> 
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="form-control-submit-button">Submit</button>
                    </div>
                    <div class="form-message">
                        <div id="msgSubmit" class="h3 text-center hidden"></div>
                    </div>
                </form>
                <!-- end of contact form -->

            </div> <!-- end of col -->
        </div> <!-- end of row -->
    </div> <!-- end of lightbox-form -->
    <!-- end of form lightbox -->


    <!-- Scripts -->
    <script src="{{ asset('assets/landing/js/jquery.min.js') }}"></script> <!-- jQuery - required by Bootstrap -->
    <script src="{{ asset('assets/landing/js/popper.min.js') }}"></script> <!-- Popper tooltip library - required by Bootstrap -->
    <script src="{{ asset('assets/landing/js/bootstrap.min.js') }}"></script> <!-- Bootstrap - front-end web framework -->
    <script src="{{ asset('assets/landing/js/jquery.easing.min.js') }}"></script> <!-- jQuery Easing for smooth scrolling between anchors -->
    <script src="{{ asset('assets/landing/js/jquery.countdown.min.js') }}"></script> <!-- The Final Countdown plugin for jQuery -->
    <script src="{{ asset('assets/landing/js/morphext.min.js') }}"></script> <!-- Morphtext for rotating text in the header -->
    <script src="{{ asset('assets/landing/js/jquery.magnific-popup.js') }}"></script> <!-- Magnific Popup for lightboxes -->
    <script src="{{ asset('assets/landing/js/validator.min.js') }}"></script> <!--  Validator.js Bootstrap plugin that validates the registration form -->
    <script src="{{ asset('assets/landing/js/scripts.js') }}"></script> <!-- Bono custom scripts -->
    
</body>
</html>