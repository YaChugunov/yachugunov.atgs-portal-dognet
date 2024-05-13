<?php
date_default_timezone_set('Europe/Moscow');

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$__title = 'Договор';
$__subtitle = "Реестр договоров";
$__subsubtitle = "Для служебных заданий";

?>

<div class="container">
	<div class="row base-top-block space20">
		<?php include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/dognet-topblock.php")?>
	</div>
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12">
			<?php include("includes/dognet-base-missions(restr_1)-view.php"); ?>
		</div>
	</div>
</div>

<div class="space100"></div>

<script type="text/javascript">
	subtitle = '<?php echo $__subtitle; ?>';
	subsubtitle = '<?php echo $__subsubtitle; ?>';
	document.getElementById("subtitle").innerHTML = subtitle;
	document.getElementById("dognet-subsubtitle").innerHTML = subsubtitle;
	$("#dognet-subsubtitle").attr("class", "text-default");
</script>
