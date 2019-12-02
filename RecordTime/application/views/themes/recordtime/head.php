<!DOCTYPE html>
<html lang="en">
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php if (isset($title)){ echo $title; } ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<?php if(get_option('favicon') != ''){ ?>
	<link href="<?php echo base_url('uploads/company/'.get_option('favicon')); ?>?asd=sadadasdasd" rel="shortcut icon">
	<?php } ?>
	<?php if(!isset($exclude_reset_css)){ ?>
	<?php //echo app_stylesheet('assets/css','reset.css'); ?>
	<?php } ?>

	<?php echo app_stylesheet(template_assets_path().'/css','style.css'); ?>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<?php if(is_rtl(true)){ ?>
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/bootstrap-arabic/css/bootstrap-arabic.min.css'); ?>">
	<?php } ?>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.1.2/handlebars.min.js" integrity="sha256-ngJY93C4H39YbmrWhnLzSyiepRuQDVKDNCWO2iyMzFw=" crossorigin="anonymous"></script>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js" integrity="sha384-kW+oWsYx3YpxvjtZjFXqazFpA7UP/MbiY4jvs+RWZo2+N94PFZ36T6TFkc9O3qoB" crossorigin="anonymous"></script>
	<?php echo app_stylesheet(template_assets_path().'/css','slick.css'); ?>
	<?php echo app_stylesheet(template_assets_path().'/css','slick-theme.css'); ?>
	<?php echo app_script(template_assets_path().'/js','slick.min.js'); ?>
	<?php echo app_script(template_assets_path().'/js','recordTime-script.js'); ?>

	<?php /*if(is_client_logged_in()){ ?>
	<?php }*/ ?>

	<?php if(file_exists(FCPATH.'assets/css/custom.css')){ ?>
	<link href="<?php echo base_url('assets/css/custom.css'); ?>" rel="stylesheet" type='text/css'>
	<?php } ?>

	<?php if(file_exists(FCPATH.'assets/css/dev.css')){ ?>
	<link href="<?php echo base_url('assets/css/dev.css'); ?>" rel="stylesheet" type='text/css'>
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,700,900&display=swap" rel="stylesheet">
	<?php } ?>

	<?php //render_custom_styles(array('general','tabs','buttons','customers','modals')); ?>
	<?php $isRTL = (is_rtl(true) ? 'true' : 'false'); ?>
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
      <!-- DO NOT REMOVE -->
    <?php //do_action('app_customers_head',array('language'=>$language)); ?>


    </head>
<?php /*?>    <body class="customers <?php if(isset($bodyclass)){echo $bodyclass; } ?>" <?php if(is_rtl(true)){ echo 'dir="rtl"';} ?>>
<?php */?>
	<body class="<?= (!empty($class) ? $class : '');?>">
