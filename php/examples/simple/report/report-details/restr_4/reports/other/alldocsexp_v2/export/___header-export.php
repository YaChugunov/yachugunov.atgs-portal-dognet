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
// 	include($_SERVER['DOCUMENT_ROOT']."/_assets/main_link-css-includes.header");
	include($_SERVER['DOCUMENT_ROOT']."/dognet/_assets/dognet_style-css-includes.header");
	include($_SERVER['DOCUMENT_ROOT']."/dognet/_assets/dognet_script-js-includes.header");
	include($_SERVER['DOCUMENT_ROOT']."/dognet/_assets/dognet_datatables-includes.header");
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
