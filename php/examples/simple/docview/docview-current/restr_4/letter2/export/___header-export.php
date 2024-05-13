<?php
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Подключаемся к базе
// require_once('../_assets/drivers/dbcontroller.php');
// $db_handle = new DBController();
// require_once('../_assets/drivers/bd_remote.php');
# Инициализация констант и функции определения адреса хоста
require_once ($_SERVER['DOCUMENT_ROOT']."/config.inc.php");
# Подключение библиотеки функций
require_once($_SERVER['DOCUMENT_ROOT']."/dognet/_assets/functions/funcDognet.inc.php");
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
?>
<!DOCTYPE html>
<html lang="ru">

<head>

    <meta http-equiv="content-type" content="text/html; charset=UTF8">

    <title>АТГС.Договор</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">

    <!-- FAVICON -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo __ROOT; ?>/_assets/images/apple-touch-icon.png">
    <!-- 	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo __ROOT; ?>/_assets/images/favicon-32x32.png"> -->
    <!-- 	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo __ROOT; ?>/_assets/images/favicon-16x16.png"> -->
    <link rel="icon" type="image/png" sizes="16x16" href="https://fontalpina.com/images/cat-clipart-face-6.png">
    <!-- 	<link rel="manifest" href="<?php echo __ROOT; ?>/_assets/images/manifest.json"> -->
    <link rel="mask-icon" href="<?php echo __ROOT; ?>/_assets/images/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="theme-color" content="#cccccc">


    <?php
	# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
	# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
	?>
    <!-- JQUERY -->
    <script type="text/javascript" language="javascript" src="<?php echo __ROOT; ?>/_assets/js/jquery-1_12_4.js">
    </script>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?php echo __ROOT; ?>/_assets/css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo __ROOT; ?>/_assets/css/bootstrap/bootstrap-select.min.css">
    <script type="text/javascript" language="javascript"
            src="<?php echo __ROOT; ?>/_assets/js/bootstrap/bootstrap.min.js"></script>
    <!-- Datatables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap.min.css">
    <script type="text/javascript" language="javascript"
            src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript"
            src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap.min.js"></script>
    <!-- Moment (date & time lib) -->
    <script type="text/javascript"
            src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/moment-with-locales.js"></script>
    <!-- ICONS -->
    <link rel="stylesheet" href="<?php echo __ROOT; ?>/_assets/css/icons/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo __ROOT; ?>/_assets/css/icons/fontawesome/css/style.css">
    <link rel="stylesheet" href="<?php echo __ROOT; ?>/_assets/css/icons/style.css">
    <link rel="stylesheet" href="<?php echo __ROOT; ?>/_assets/css/icons/icon2/style.css">
    <link rel="stylesheet" href="<?php echo __ROOT; ?>/_assets/js/vendors/swipebox/css/swipebox.min.css">
    <!-- My CSS -->
    <link rel="stylesheet" href="<?php echo __ROOT; ?>/dognet/_assets/css/dognet_style.css">
    <!-- SKIN -->
    <link rel="stylesheet" href="<?php echo __ROOT; ?>/_assets/css/skin/stone.css">
    <!-- Include Fonts -->
    <link rel="stylesheet" href="<?php echo __ROOT; ?>/dognet/_assets/css/dognet_font-face.css">
    <!-- My CSS -->
    <link rel="stylesheet" href="<?php echo __ROOT; ?>/dognet/_assets/css/dognet_additional.css">
    <!-- ADDITIONAL -->
    <link rel="stylesheet" href="<?php echo __ROOT; ?>/_assets/js/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <!-- Datetime Picker -->
    <link rel="stylesheet"
          href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/_bootstrap-css/bootstrap-datetimepicker.css" />
    <script type="text/javascript"
            src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/_bootstrap-js/bootstrap-datetimepicker.js">
    </script>
    <?php
	# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
	# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
	?>


    <!-- Datatables : end -->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->

</head>

<body>

    <!-- Блок, который будет отображаться над страницей -->
    <div id="before-load">
        <!-- Иконка Font Awesome -->
        <!-- 	<i class="fa fa-spinner fa-spin"></i> -->
        <i></i>
    </div>

    <?php include("___navbartop-export.php"); ?>

    <div class="body" style="padding-top: 50px;">
        <div class="vh-content">