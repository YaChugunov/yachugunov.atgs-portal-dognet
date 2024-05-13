<?php
date_default_timezone_set('Europe/Moscow');

	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);

	$__title = 'Договор';
	$__subtitle = "Отгрузка продукции";
	$__subsubtitle = "Список отгрузок";

// 		PORTAL_SYSLOG('99940000', '0000000', null, null, null, null);

?>
	<div class="container">
		<div class="row common-top-block">
			<?php include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/dognet-topblock.php")?>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">
			<?php include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/_fixes-updates/dognet_fixes-updates.php"); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">
				<?php include("dognet-otgrview-current(restr_4)-main.php"); ?>
			</div>
		</div>
		<div class="row space20">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<?php include($_SERVER['DOCUMENT_ROOT']."/dognet/_assets/includes/dognet_current-bottom-legend.php"); ?>
			</div>
		</div>

	</div>

	<div class="space100"></div>

<script type="text/javascript">
	subtitle = '<?php echo $__subtitle; ?>';
	subsubtitle = '<?php echo $__subsubtitle; ?>';
	document.getElementById("subtitle").innerHTML = subtitle;
// 	document.getElementById("subsubtitle").innerHTML = subsubtitle;
	document.getElementById("dognet-subsubtitle").innerHTML = subsubtitle;
</script>
