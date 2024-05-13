<?php
date_default_timezone_set('Europe/Moscow');

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$__title = 'Договор';
$__subtitle = "Отчетные формы";
$__subsubtitle = "Поставки с истекшими сроками на сегодня";

// Делаем запись в системный лог
// Все параметры в таблице portal_log_messages
	PORTAL_SYSLOG('99942100', '0000000', null, $_GET['reportview'], $__subsubtitle, null);

?>
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/moment-with-locales.js"></script>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/_bootstrap-css/bootstrap-datetimepicker.css" />
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/_bootstrap-js/bootstrap-datetimepicker.js"></script>

<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/report/report-details/css/reports-main-tabs.css">

	<div class="container">
		<div class="row common-top-block">
			<?php include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/dognet-topblock.php")?>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div id="main-tabs">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12">
							<ul id="main-tabs-menu" class="nav nav-tabs">
								<li class="active"><a data-toggle="tab" href="#tab-1" title="">Сорванные поставки</a></li>
								<li><a data-toggle="tab" href="#tab-2" title="">Расширенный поиск</a></li>
								<li style="float:right"><a href="?reportview=postexp&export=yes&format=" title="">Экспорт</a></li>
							</ul>

							<div class="tab-content">
								<div id="tab-1" class="tab-pane fade in active">
									<?php include("tabs/dognet-report-reportview(restr_4)-other-postexp-tab1.php"); ?>
								</div>
								<div id="tab-2" class="tab-pane fade">
									<?php include($_SERVER['DOCUMENT_ROOT']."/_assets/includes/msg.inc/message_section-thinkaboutit.php"); ?>
								</div>
							</div>
						</div>
					</div>
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
