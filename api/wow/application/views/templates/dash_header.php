<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><?= $title;?></title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- Favicons -->
  <!-- <link href="img/favicon.png" rel="icon">
  <link href="img/apple-touch-icon.png" rel="apple-touch-icon"> -->


  <link href="https://fonts.googleapis.com/css?family=Nunito+Sans" rel="stylesheet">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Poppins:300,400,500,700" rel="stylesheet">

  <!-- Bootstrap CSS File -->
  <!-- Bootstrap and Font Awesome css -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

<!-- Css animations  -->
    <link href="<?php echo base_url(); ?>assets/css/animate.css" rel="stylesheet">

    <!-- Theme stylesheet, if possible do not edit this stylesheet -->
    <!-- <link href="<?php //echo base_url(); ?>assets/css/slider.css" rel="stylesheet" id="theme-stylesheet"> -->
    <link href="<?php echo base_url(); ?>assets/css/style.default.css" rel="stylesheet" id="theme-stylesheet"><!-- 
    <link href="css/style.local.css" rel="stylesheet" id="theme-stylesheet"> -->

    <!-- Custom stylesheet - for your changes -->
    <!-- <link href="<?php //echo base_url(); ?>assets/css/custom.css" rel="stylesheet"> -->

    <!-- Favicon and apple touch icons-->
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/lagacy.png" type="image/x-icon" />
    <link rel="apple-touch-icon" href="img/lagacy.png" />
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo base_url(); ?>assets/img/lagacy.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url(); ?>assets/img/lagacy.png" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url(); ?>assets/img/lagacy.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url(); ?>assets/img/lagacy.png" />
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo base_url(); ?>assets/img/lagacy.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo base_url(); ?>assets/img/lagacy.png" />
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url(); ?>assets/img/lagacy.png" />
    <!-- owl carousel css -->

    <link href="<?php echo base_url(); ?>assets/css/owl.carousel.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/owl.theme.css" rel="stylesheet">

</head>

<body>

    <div id="all">
        <header>
             <nav class=" navbar-fixed-top navbar navbar-default">
                  <div class="container">
                    <div class="navbar-header">
                       <!-- <a href="#"><img src="<?php echo base_url(); ?>assets/img/lagacy.png" alt="Lagacy logo"     width= "166px" ></a> -->
                    </div>
                    <!-- <ul class="nav navbar-nav pull-right">
                      <li class="active"><a href="#">Home</a></li>
                      <li><a href="#">Page 1</a></li>
                      <li><a href="#">Page 2</a></li>
                      <li><a href="#">Page 3</a></li>
                    </ul> -->
                  </div>
                </nav>

        </header>
        <section class="banner-bg" style="background-image:linear-gradient(#2dc997e0, #ffffffe3),url(<?php echo base_url(); ?>assets/img/house.jpg);background-size:cover;">

        </section>
        <section class="container">
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-md-3 white bd-right position-fixed">
                        <div class="profile-header">
                            <div class="image-holder">
                                <img src="<?php echo base_url(); ?>assets/img/profile.jpg"  class="img-responsive">
                            </div>
                            <div class="content-holder">
                                <span>Howdy!</span>
                                <h3>Promise Orung</h3>
                            </div>
                        </div>
                        <div class="list-content">
                            <ul>
                                <li><a class="dash-golden dashlink-active" href="<?php echo base_url(); ?>">Dashboard </a></li>
                                <li><a class="dash-golden" href="<?php echo base_url(); ?>create_event">Create Events </a></li>
                                <li><a href="created-event.html" class=" dash-golden">Created Events</a></li>
                                <li><a class="dash-golden" href="vendors.html">Vendors Contacted</a></li>
                                <li><a class="dash-golden" href="post-request.html">Post Requst</a></li>
                                <li><a href="dashboard-profile.html" class="dash-golden">Profile</a></li>
                                <li><a href="notification.html" class="dash-golden">Notification</a></li>
                                <li><a href="favourite.html" class="dash-golden">Favourite</a></li>
                                <li><a class="dash-golden" href="report-abuse.html">Report a User</a></li>
                                <li><a class="dash-golden" href="settings.html">Settings</a></li>
                            </ul>
                        </div>
                    </div>