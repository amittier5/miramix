<!doctype html>
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><html lang="en" class="no-js"> <![endif]-->
<html lang="en">

<head>

  <!-- Basic -->
  <title><?php echo (isset($title)?$title:'Miramix'); ?></title>

  <!-- Define Charset -->
  <meta charset="utf-8">

  <!-- Responsive Metatag -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <!-- Page Description and Author -->
  <meta name="description" content="MIRAMIX">
  	<!--theme font-->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,600,400italic,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
  <!-- Bootstrap CSS  -->
  <link rel="stylesheet" href="<?php echo url();?>/public/frontend/css/bootstrap.min.css" type="text/css" media="screen">
  <!-- Font Awesome CSS -->
  <link rel="stylesheet" href="<?php echo url();?>/public/frontend/css/font-awesome.min.css" type="text/css" media="screen">
  <!-- Slicknav -->
  <link rel="stylesheet" type="text/css" href="<?php echo url();?>/public/frontend/css/slicknav.css" media="screen">
  <!-- MIRAMIX CSS Styles  -->
  <link rel="stylesheet" type="text/css" href="<?php echo url();?>/public/frontend/css/style.css" media="screen">
  <!-- Responsive CSS Styles  -->
  <link rel="stylesheet" type="text/css" href="<?php echo url();?>/public/frontend/css/responsive.css" media="screen">
  <!-- Css3 Transitions Styles  -->
  <link rel="stylesheet" type="text/css" href="<?php echo url();?>/public/frontend/css/animate.css" media="screen">
   <!--theme css-->
    <link href="<?php echo url();?>/public/frontend/css/screen.css" rel="stylesheet">
  <!-- Color CSS Styles  -->
  <!-- MIRAMIX JS  -->
  <script type="text/javascript" src="<?php echo url();?>/public/frontend/js/jquery-2.1.4.min.js"></script>
  <script type="text/javascript" src="<?php echo url();?>/public/frontend/js/modernizrr.js"></script>
  <script type="text/javascript" src="<?php echo url();?>/public/frontend/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="<?php echo url();?>/public/frontend/js/jquery.slicknav.js"></script>

<script src="<?php echo url();?>/resources/assets/js/jquery.validate-1.9.1.min.js"></script>
  <script src="<?php echo url();?>/resources/assets/js/additional-methods-1.10.0.js"></script>
  

 
  
  <!--[if IE 8]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
  <!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>

<body class="<?php echo (isset($body_class)?$body_class:'');?>">

  <!-- Full Body Container -->
  <div id="container">


    <!-- Start Header Section -->
    <header class="clearfix">
      <div class="container">
      <!-- Start  Logo & Naviagtion  -->
      <div class="navbar navbar-default navbar-top">
          <div class="navbar-header">
            <!-- Stat Toggle Nav Link For Mobiles -->
            <button type="button" class="navbar-toggle nav-button" data-toggle="collapse" data-target=".navbar-collapse">
              <i class="fa fa-bars"></i>
            </button>
            <!-- End Toggle Nav Link For Mobiles -->
            <a class="navbar-brand" href="<?php echo url();?>">&nbsp;</a>
          </div>
          <div class="navbar-collapse collapse">
            <!-- Start Navigation List -->
            <ul class="nav navbar-nav navbar-right">
              <li><a href="#">Inventory</a></li>
              <li class="<?php echo (isset($brand_active)?$brand_active:'');?>"><a href="<?php echo url();?>/brand">Brands</a></li>
              <li><a href="#">FAQs</a></li>
              <li><a href="#">About Us</a></li>
              <li class="brand"><a href="<?php echo url();?>/brandLogin">Brand Login</a></li>
              <li class="sign"><a href="<?php echo url();?>/register">Sign Up</a></li>    
              <li class="login"><a href="<?php echo url();?>/memberLogin">Login</a></li>
              <li class="cart"><a href="#"><span>0</span></a></li>
            </ul>
            <!-- End Navigation List -->
          </div>


      </div>
      <!-- End Header Logo & Naviagtion -->
    </div>
    </header>
    <!-- End Header Section -->