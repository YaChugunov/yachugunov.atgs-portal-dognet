<?php
date_default_timezone_set('Europe/Moscow');

	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);

	$__title = 'Договор';
	$__subtitle = "Общий раздел";
?>


	<div class="container">
		<div class="row" style="margin-top:20px">
			<?php include("dognet-topblock.php")?>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">
			<?php include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/_fixes-updates/dognet_fixes-updates.php"); ?>
			</div>
		</div>
		<div class="row">
			<div class="space20"></div>
			<div class="col-xs-hidden col-sm-12 col-md-12 col-lg-12">
				<?php include("dognet-base-startpage.php")?>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-hidden col-sm-12 col-md-12 col-lg-12">
				<?php // include('atgs-portal_main_bottom-area.php'); ?>
			</div>
		</div>

	</div>

	<div class="space100"></div>

<script type="text/javascript">
	title = '<?php echo $__title; ?>';
	subtitle = '<?php echo $__subtitle; ?>';
	document.getElementById("title").innerHTML = title;
	document.getElementById("subtitle").innerHTML = subtitle;
</script>
