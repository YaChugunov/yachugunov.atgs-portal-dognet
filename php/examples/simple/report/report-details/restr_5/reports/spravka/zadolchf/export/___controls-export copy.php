<?php

date_default_timezone_set('Europe/Moscow');

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$__title = 'Договор';
$__subtitle = "Экспорт отчетных данных";
$__subsubtitle = "Экспорт отчетных данных";

?>

<style>
	#report-settings {  }
	#report-settings h4 { font-family:'Oswald', sans-serif; font-size:2.0em; font-weight:300 }
	#export-format-block a > img { opacity:0.5; height:100px; width:100px; margin:0 2px }
	#export-format-block { text-align:center }
	#export-format-block a > img:hover { opacity:1.0; transition:0.5s	}
	#export-format-block a > img:not(hover) { opacity:0.5; transition:0.5s	}

	.format-not-selected { font-family:'Oswald', sans-serif; font-size:1.0em; font-weight:300; text-transform:uppercase }
	.format-not-selected { color:#999 }
</style>


<div class="container">
	<div class="space50"></div>
	<div class="row space20">
		<div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 space20">
				<div id="report-settings" class="text-center">
					<h4 class="space10">Выберите тип задолженности для экспорта</h4>

<label class="checkbox-inline"><input type="checkbox" value="">Все</label>
<label class="checkbox-inline"><input type="checkbox" value="">Текущая</label>
<label class="checkbox-inline"><input type="checkbox" value="">Судебная</label>
<label class="checkbox-inline"><input type="checkbox" value="">Невозвратная</label>
<?php
	// Тут будут настройки отчета
?>
				</div>
			</div>
			<div class="col-xs-hidden col-sm-12 col-md-12 col-lg-12">
				<div id="export-format-block" class="center-block" style="">
					<a href="<?php $_SERVER['HTTP_HOST']; ?>/dognet/dognet-report.php?reportview=zadolchf&export=yes&format=doc" class="">
							<img src="<?php $_SERVER['HTTP_HOST']; ?>/dognet/_assets/images/export-to-doc.png" class="media">
					</a>
					<a href="<?php $_SERVER['HTTP_HOST']; ?>/dognet/dognet-report.php?reportview=zadolchf&export=yes&format=xls" class="">
							<img src="<?php $_SERVER['HTTP_HOST']; ?>/dognet/_assets/images/export-to-xls.png" class="media">
					</a>
					<a href="<?php $_SERVER['HTTP_HOST']; ?>/dognet/dognet-report.php?reportview=zadolchf&export=yes&format=pdf" class="">
							<img src="<?php $_SERVER['HTTP_HOST']; ?>/dognet/_assets/images/export-to-pdf.png" class="media">
					</a>
				</div>
			</div>
		</div>
	</div>
	<div class="row space50">
		<div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
			<div class="text-center">
<?php
				if (isset($_GET['format'])) {
					switch ($_GET['format']) {
						case "doc":
							include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/report/report-details/restr_5/reports/spravka/zadolchf/export/_docx/export2docx.php");
							break;
						case "xls":
							include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/report/report-details/restr_5/reports/spravka/zadolchf/export/_xlsx/export2xlsx.php");
							break;
						case "pdf":
							echo "<div class='format-not-selected'>Coming soon...</div>";
							break;
						default:
							echo "<div class='format-not-selected'>Выберите формат для экспорта</div>";
					}
				}
				else {
				 echo "<div class='format-not-selected'>Выберите формат для экспорта</div>";
				}
?>
			</div>
		</div>
	</div>

</div>



<script type="text/javascript">
	subtitle = '<?php echo $__subtitle; ?>';
	subsubtitle = '<?php echo $__subsubtitle; ?>';
	document.getElementById("subtitle").innerHTML = subtitle;
	document.getElementById("dognet-subsubtitle").innerHTML = subsubtitle;
	$("#dognet-subsubtitle").attr("class", "text-default");
</script>
