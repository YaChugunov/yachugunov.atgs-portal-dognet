<?php
date_default_timezone_set('Europe/Moscow');
# Подключаем конфигурационный файл
// require($_SERVER['DOCUMENT_ROOT']."/config.inc.php");
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Подключаемся к базе
require_once($_SERVER['DOCUMENT_ROOT']."/_assets/drivers/db_connection.php");
require_once($_SERVER['DOCUMENT_ROOT']."/_assets/drivers/db_controller.php");
$db_handle = new DBController();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
// Какой то блок...
#
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
?>
<script>
window.onload = function () {

var options = {
	animationEnabled: true,
	title:{
		text: "Поступившие оплаты и авансы по выставленным счетам-фактурам"
	},
	axisX:{
		valueFormatString: "DD.MM.YY",
		crosshair: {
			enabled: true,
			snapToDataPoint: true
		}
	},
	axisY: {
		title: "Поступившие средства (в руб.)",
		includeZero: false,
		valueFormatString: "##0.00 р.",
		crosshair: {
			enabled: true,
			snapToDataPoint: true,
			labelFormatter: function(e) {
				return CanvasJS.formatNumber(e.value, "##0.00")+" р.";
			}
		}
	},
	data: [{
		type: "area",
		xValueFormatString: "DD.MM.YY",
		yValueFormatString: "##0.00 р.",
		dataPoints: [
			{ x: new Date(2017, 08, 01), y: 85.83 },

			{ x: new Date(2017, 08, 04), y: 84.42 },
			{ x: new Date(2017, 08, 05), y: 84.97 },
			{ x: new Date(2017, 08, 06), y: 84.89 },
			{ x: new Date(2017, 08, 07), y: 84.78 },
			{ x: new Date(2017, 08, 08), y: 85.09 },
			{ x: new Date(2017, 08, 09), y: 85.14 },

			{ x: new Date(2017, 08, 11), y: 84.46 },
			{ x: new Date(2017, 08, 12), y: 84.71 },
			{ x: new Date(2017, 08, 13), y: 84.62 },
			{ x: new Date(2017, 08, 14), y: 84.83 },
			{ x: new Date(2017, 08, 15), y: 84.37 },

			{ x: new Date(2017, 08, 18), y: 84.07 },
			{ x: new Date(2017, 08, 19), y: 83.60 },
			{ x: new Date(2017, 08, 20), y: 82.85 },
			{ x: new Date(2017, 08, 21), y: 82.52 },

			{ x: new Date(2017, 08, 25), y: 82.65 },
			{ x: new Date(2017, 08, 26), y: 81.76 },
			{ x: new Date(2017, 08, 27), y: 80.50 },
			{ x: new Date(2017, 08, 28), y: 79.13 },
			{ x: new Date(2017, 08, 29), y: 79.00 }
		]
	}]
};
$("#chartContainer1").CanvasJSChart(options);


var chart = new CanvasJS.Chart("chartContainer2", {
	exportEnabled: true,
	animationEnabled: true,
	title:{
		text: "Доля Заказчиков в обороте"
	},
	legend:{
		cursor: "pointer",
		itemclick: explodePie
	},
	data: [{
		type: "pie",
		showInLegend: true,
		toolTipContent: "{name}: <strong>{y}%</strong>",
		indexLabel: "{name} - {y}%",
		dataPoints: [
			{ y: 26, name: "Заказчик 1", exploded: true },
			{ y: 20, name: "Заказчик 2" },
			{ y: 5, name: "Заказчик 3" },
			{ y: 3, name: "Заказчик 4" },
			{ y: 7, name: "Заказчик 5" },
			{ y: 17, name: "Заказчик 6" },
			{ y: 22, name: "Прочие заказчики"}
		]
	}]
});
chart.render();
}

function explodePie (e) {
	if(typeof (e.dataSeries.dataPoints[e.dataPointIndex].exploded) === "undefined" || !e.dataSeries.dataPoints[e.dataPointIndex].exploded) {
		e.dataSeries.dataPoints[e.dataPointIndex].exploded = true;
	} else {
		e.dataSeries.dataPoints[e.dataPointIndex].exploded = false;
	}
	e.chart.render();


}

</script>


	<div class="space30"></div>
	<div id="admin-anounce" class="">
		<div class="row admin-anounce-block">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 space20">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="block">
						<h3 class="space20">Графики</h3>
						<blockquote class="">
							<p>Если будет четко поставленная задача и необходимость в графическом представлении финансновых или каких-либо других параметров (сальдо по договорам, объемы, оборот и так далее), то есть возможность это сделать. <mark>Если в этом действительно будет заинтересованность, то надо понимать, что это потребует оплаты лицензии на прикладной софт.</mark> А сделать - сделаю. Любой каприз, как говорится... :)</p>
							<p>Естественно, что графики могут быть как по финансовой, так и по производственной или любой другой части, по которой есть готовая статистика или есть желание ее начать собирать...</p>
							<p>Ниже примеры. В ассортименте более 30 типов графиков для отображения...</p>
							<p class="text-warning">Любые пожелания от начальников отделов, ГИПов и руководства, чтобы они хотели видеть на стартовых страницах сервиса приветствуются.</p>
							<footer>Ярослав Чугунов</footer>
						</blockquote>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 space50">
				<div id="chartContainer1" style="height: 300px; width: 100%;"></div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 space20">
				<div id="chartContainer2" style="height: 300px; width: 100%;"></div>
			</div>
		</div>
	</div>


<script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
<script src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>




