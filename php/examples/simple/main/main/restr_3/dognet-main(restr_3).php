<?php
date_default_timezone_set('Europe/Moscow');
# Подключаем конфигурационный файл
// require($_SERVER['DOCUMENT_ROOT']."/config.inc.php");
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Подключаемся к базе
require_once($_SERVER['DOCUMENT_ROOT'] . "/_assets/drivers/db_connection.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/_assets/drivers/db_controller.php");
$db_handle = new DBController();

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$__title = 'Договор';
$__subtitle = "Главная страница";
$__subsubtitle = "";

if (isset($_GET['uniqueID'])) {
	$_SESSION['uniqueID'] = $_GET['uniqueID'];
}

require($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/main/main/dognet-main-functions.inc.php");
?>

<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/date-de.js"></script>
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/moment-with-locales.js"></script>

<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/main/main/restr_3/tabs/css/main-common-tabs.css">

<?php
$_QRY_MAILING_ENBL = mysqlQuery("SELECT dognet_mailing_enbl FROM users WHERE id=" . $_SESSION['id']);
$_ROW_MAILING_ENBL = mysqli_fetch_assoc($_QRY_MAILING_ENBL);
if ($_ROW_MAILING_ENBL['dognet_mailing_enbl'] == 0) {
	// include($_SERVER['DOCUMENT_ROOT']."/dognet/_assets/includes/subscribe_handler/dognetNewsletter-subscribe-popup-onload-window.php");
}
?>
<div class="container">
	<div class="row common-top-block">
		<?php include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/dognet-topblock.php"); ?>
	</div>
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12">
			<?php include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/_fixes-updates/dognet_fixes-updates.php"); ?>
		</div>
	</div>
	<?php
	if (checkIsItGIP($_SESSION['id']) == 1) {
	?>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div id="main-tabs">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12">
							<ul id="main-tabs-menu" class="nav nav-tabs">
								<li id="tab-1-link" class="active"><a data-toggle="tab" href="#tab-1" title="">Работа ГИПа</a></li>
								<li id="tab-3-link"><a data-toggle="tab" href="#tab-3" title="">Заявки</a></li>
								<li id="tab-4-link"><a data-toggle="tab" href="#tab-4" title="">Отгрузки</a></li>
							</ul>
							<div class="tab-content">
								<div id="tab-1" class="tab-pane fade in active">
									<?php include("tabs/dognet-main(restr_3)-tab1.php"); ?>
								</div>
								<div id="tab-2" class="tab-pane fade">
									<?php // include("tabs/dognet-main(restr_3)-tab2.php"); 
									?>
								</div>
								<div id="tab-3" class="tab-pane fade">
									<?php include("tabs/dognet-main(restr_3)-tab3.php"); ?>
								</div>
								<div id="tab-4" class="tab-pane fade">
									<?php include("tabs/dognet-main(restr_3)-tab4.php"); ?>
								</div>
								<div id="tab-5" class="tab-pane fade">
									<?php // include("tabs/dognet-main(restr_3)-tab5.php"); 
									?>
								</div>
								<div id="tab-6" class="tab-pane fade">
									<?php // include("tabs/dognet-main(restr_3)-tab6.php"); 
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php
	} else {
	?>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<?php include("tabs/dognet-main(restr_3)-tab1.php"); ?>
			</div>
		</div>
	<?php
	}
	?>
</div>

<div class="space100"></div>

<script type="text/javascript">
	subtitle = '<?php echo $__subtitle; ?>';
	document.getElementById("subtitle").innerHTML = subtitle;
	document.getElementById("dognet-subsubtitle").innerHTML = "Работа ГИПа";
	$('#tab-1-link').on('click', function() {
		document.getElementById("dognet-subsubtitle").innerHTML = "Работа ГИПа";
	});
	$('#tab-2-link').on('click', function() {
		document.getElementById("dognet-subsubtitle").innerHTML = "Флажки";
	});
	$('#tab-3-link').on('click', function() {
		document.getElementById("dognet-subsubtitle").innerHTML = "Заявки";
	});
	$('#tab-4-link').on('click', function() {
		document.getElementById("dognet-subsubtitle").innerHTML = "Отгрузки";
	});
	$('#tab-5-link').on('click', function() {
		document.getElementById("dognet-subsubtitle").innerHTML = "Графики";
	});
	$('#tab-6-link').on('click', function() {
		document.getElementById("dognet-subsubtitle").innerHTML = "Документы";
	});
	// ----- ----- ----- ----- ----- ----- -----
	// Отрабатываем решение по циклическому запуску скрипта
	// :::
	//
	url = "php/examples/simple/ajaxload.php";

	function GenerateData() {
		return 1;
	}
	//
	var fn = function() {
		$('#ajaxtest').load(url, function() {
			GenerateData();
		});
		setTimeout(arguments.callee, 60000);
	}
	setTimeout(fn, 1000);
	//
	param = "";
	$.ajax({
		type: "POST",
		url: url,
		data: param,
		contentType: "application/json; charset=utf-8",
		success: function(result) {
			console.log(result);
		},
		error: function(unused1, unused2, error) {
			alert(error);
		}
	});
	// :::
	// ----- ----- ----- ----- ----- ----- -----
</script>

<script src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/CanvasJS/canvasjs.min.js"></script>
<script>
	window.onload = function() {
		var chart = new CanvasJS.Chart("chartContainer", {
			theme: "light1",
			animationEnabled: true,
			title: {
				text: "Выполнение АТГС по всем договорам за последние 24 месяца"
			},
			subtitles: [{
				text: "Сумма счетов-фактур / Сумма оплат / Сумма авансов"
			}],
			axisX: {
				valueFormatString: "MM/YYYY",
			},
			axisY: [{
				includeZero: false,
				lineColor: "#369EAD",
				tickColor: "#369EAD",
				title: "Авансы, в руб.",
				valueFormatString: "### ### ###",
				suffix: "р.",
				prefix: ""
			}, {
				includeZero: false,
				lineColor: "#C24642",
				tickColor: "#C24642",
				title: "Оплаты, в руб.",
				valueFormatString: "### ### ###",
				suffix: "р.",
				prefix: ""
			}],
			axisY2: {
				includeZero: false,
				lineColor: "#83A7D0",
				tickColor: "#83A7D0",
				title: "Выполнение в руб.",
				valueFormatString: "### ### ###",
				suffix: "р.",
				prefix: ""
			},
			legend: {
				cursor: "pointer",
				itemclick: toggleDataSeries
			},
			toolTip: {
				shared: true
			},
			data: [{
					type: "stackedArea",
					color: "#83A7D0",
					axisYType: "secondary",
					name: "Счета-фактуры",
					markerSize: 5,
					showInLegend: true,
					visible: true,
					xValueFormatString: "MM/YYYY",
					yValueFormatString: "### ### ###.## р.",
					xValueType: "dateTime",
					dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
				},
				{
					type: "stackedArea",
					color: "#C24642",
					axisYIndex: 1,
					name: "Оплаты",
					markerSize: 5,
					showInLegend: true,
					visible: true,
					xValueFormatString: "MM/YYYY",
					yValueFormatString: "### ### ###.## р.",
					xValueType: "dateTime",
					dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
				},
				{
					type: "stackedArea",
					color: "#369EAD",
					axisYIndex: 0,
					name: "Авансы",
					markerSize: 5,
					showInLegend: true,
					visible: true,
					xValueFormatString: "MM/YYYY",
					yValueFormatString: "### ### ###.## р.",
					xValueType: "dateTime",
					dataPoints: <?php echo json_encode($dataPoints3, JSON_NUMERIC_CHECK); ?>
				}
			]
		});
		chart.render();

		function toggleDataSeries(e) {
			if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
				e.dataSeries.visible = false;
			} else {
				e.dataSeries.visible = true;
			}
			chart.render();
		}
		// ----- ----- ----- ----- -----
	}
</script>