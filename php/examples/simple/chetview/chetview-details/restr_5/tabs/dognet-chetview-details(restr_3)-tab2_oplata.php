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
$__uniqueID = $_SESSION['uniqueID'];
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
// Вытаскиваем идентификатор календарного плана
	$query1 = mysqlQuery("SELECT koddened FROM dognet_docbase WHERE koddoc=".$__uniqueID);
	$row1 = mysqli_fetch_assoc($query1);
	$__koddened = $row1['koddened'];
	$query2 = mysqlQuery("SELECT short_code FROM dognet_spdened WHERE koddened=".$__koddened);
	$row2 = mysqli_fetch_assoc($query2);
	$__dened = $row2['short_code'];
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	$varKoddoc = $_GET['uniqueID'];
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
?>

<style>
/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----

ТАБЛИЦА "СВОДКА ПО ЭТАПАМ"

----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
/*
/* Общее для таблицы */
#chetview-details-tab2 {  }
#chetview-details-tab2 .details-control:hover { cursor:pointer }
#chetview-details-tab2 .font-courier { font-family:courier,courier new,serif }
/*
/*
/* Заголовок таблицы */
#chetview-details-tab2 > thead {	color:#111; font-family:'Oswald', sans-serif; border-bottom:none;	border-top:none }
#chetview-details-tab2 > thead > tr > th { color:#111; border-bottom:none; font-weight:500; font-size:1.3em; text-transform:uppercase }
#chetview-details-tab2 > thead > tr > th:first-child { background-color:#f0f0f0; width:5%; text-align:center }
#chetview-details-tab2 > thead > tr > th:nth-child(2) { background-color:#f0f0f0; border-left: 2px #fff solid; text-align:left }
#chetview-details-tab2 > thead > tr > th:nth-child(3) { background-color:#f0f0f0; border-left: 2px #fff solid; width:15%; text-align:left  }
#chetview-details-tab2 > thead > tr > th:nth-child(4) { background-color:#f0f0f0; border-left: 2px #fff solid; width:15%; text-align:right  }
#chetview-details-tab2 > thead > tr > th:nth-child(5) { background-color:#f0f0f0; border-left: 2px #fff solid; width:15%; text-align:right  }
#chetview-details-tab2 > thead > tr > th:nth-child(6) { background-color:#f0f0f0; border-left: 2px #fff solid; width:15%; text-align:right }
/*
/*
/* Тело таблицы */
#chetview-details-tab2 > tbody {	font-family:'Oswald', sans-serif; color:#666; border-bottom:none;	border-top:none }
#chetview-details-tab2 > tbody > tr > td { border-bottom:none; padding: 5px 8px; line-height: 1.42857143; vertical-align: middle }
#chetview-details-tab2 > tbody > tr > td:first-child { width:5%; font-family:courier,courier new,serif }
#chetview-details-tab2 > tbody > tr > td:nth-child(2) { font-family:courier,courier new,serif }
#chetview-details-tab2 > tbody > tr > td:nth-child(3) { width:15%; font-family:courier,courier new,serif }
#chetview-details-tab2 > tbody > tr > td:nth-child(4) { width:15%; font-family:courier,courier new,serif }
#chetview-details-tab2 > tbody > tr > td:nth-child(5) { width:15%; font-family:courier,courier new,serif }
#chetview-details-tab2 > tbody > tr > td:nth-child(6) { width:15%; font-family:courier,courier new,serif }
#chetview-details-tab2 > tbody > tr > td.dataTables_empty { text-align:center; border-bottom:1px #951402 solid; border-top:1px #951402 solid; text-transform:uppercase; font-style:italic; color:#951402 }
#chetview-details-tab2 > tbody > tr > td.chetview-details-tab2-numberstage { font-weight:300; font-size:1.0em; text-transform:none }
#chetview-details-tab2 > tbody > tr > td.chetview-details-tab2-dateplan { font-weight:300; font-size:1.0em; text-transform:none }
#chetview-details-tab2 > tbody > tr > td.chetview-details-tab2-namestage { font-weight:300; font-size:1.0em; text-transform:none }
#chetview-details-tab2 > tbody > tr > td.chetview-details-tab2-summastage { font-weight:300; font-size:1.0em; text-transform:none }
#chetview-details-tab2 > tbody > tr > td { border-top:none }
#chetview-details-tab2 > tbody > tr.shown > td { background-color:#336a86; color:#fff; font-weight:300 }
/*
/*
/* Подвал таблицы */
#chetview-details-tab2 > tfoot {	color:#111; font-family:courier,courier new,serif; border-bottom:none;	border-top:none }
#chetview-details-tab2 > tfoot > tr > th { border-bottom:none; font-weight:700; text-transform:uppercase }
#chetview-details-tab2 > tfoot > tr > th.chetview-details-tab2-summastage { text-align:right; text-transform:none }


/*
/*
/* Разное */
#chetview-tab2 .panel-title { font-size:1.3em; font-weight:600; text-transform:none;	padding:0 }
#chetview-tab2 .panel { border:1px solid #f5f5f5 }

#chetview-details-tab2 .sorting_asc:after { display:none }
#chetview-details-tab2 > thead > tr > th.sorting_asc { padding-right:8px }
#chetview-details-tab2 .sorting_desc:after { display:none }
#chetview-details-tab2 > thead > tr > th.sorting_desc { padding-right:8px }

#row-details-tab2 { font-family:'Oswald', sans-serif; font-size:1.0em }
#row-details-tab2 > tbody >tr > td { text-align:left }
#chetview-details-tab2 .details-body { border:3px #333 solid; border-radius:10px; border-collapse:collapse }
#end-of-child { border-bottom:3px #333 solid; border-left:3px #333 solid; border-right:3px #333 solid }
#chetview-details-tab2-chfact.table < div < td { border-left:3px #333 solid; border-right:3px #333 solid }

.chetview-details-tab2-title { color:#111; font-family:'Oswald', sans-serif; font-size:1.7em; font-weight:300; margin-bottom:20px; letter-spacing:0.3em }

/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----

ТАБЛИЦА "СВОДКА ПО АВАНСАМ"

----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
/*
/* Общее для таблицы */
#chetview-details-tab2-avans {  }
#chetview-details-tab2-avans .details-control:hover { cursor:pointer }
#chetview-details-tab2-avans .font-courier { font-family:courier,courier new,serif }
/*
/*
/* Заголовок таблицы */
#chetview-details-tab2-avans > thead {	color:#111; font-family:'Oswald', sans-serif; border-bottom:none;	border-top:none }
#chetview-details-tab2-avans > thead > tr > th { color:#111; border-bottom:none; font-weight:500; font-size:1.3em; text-transform:uppercase }
#chetview-details-tab2-avans > thead > tr > th:first-child { background-color:#f0f0f0; width:36px; text-align:center }
#chetview-details-tab2-avans > thead > tr > th:nth-child(2){ background-color:#f0f0f0; border-left: 2px #fff solid; width:5%; text-align:center }
#chetview-details-tab2-avans > thead > tr > th:nth-child(3) { background-color:#f0f0f0; border-left: 2px #fff solid; width:15%; text-align:left }
#chetview-details-tab2-avans > thead > tr > th:nth-child(4) { background-color:#f0f0f0; text-align:right }
#chetview-details-tab2-avans > thead > tr > th:nth-child(5) { background-color:#f0f0f0; width:15%; text-align:right  }
#chetview-details-tab2-avans > thead > tr > th:nth-child(6) { background-color:#f0f0f0; border-left: 2px #fff solid; width:15%; text-align:right  }
#chetview-details-tab2-avans > thead > tr > th:nth-child(7) { background-color:#f0f0f0; border-left: 2px #fff solid; width:15%; text-align:right  }
#chetview-details-tab2-avans > thead > tr > th:nth-child(8) { background-color:#f0f0f0; border-left: 2px #fff solid; width:15%; text-align:right }
/*
/*
/* Тело таблицы */
#chetview-details-tab2-avans > tbody {	font-family:'Oswald', sans-serif; color:#666; border-bottom:none;	border-top:none }
#chetview-details-tab2-avans > tbody > tr > td { border-bottom:none; padding: 5px 8px; line-height: 1.42857143; vertical-align: middle }
#chetview-details-tab2-avans > tbody > tr > td:first-child { width:36px }
#chetview-details-tab2-avans > tbody > tr > td:nth-child(2) { width:5%; font-family:courier,courier new,serif }
#chetview-details-tab2-avans > tbody > tr > td:nth-child(3) { width:15%; font-family:courier,courier new,serif }
#chetview-details-tab2-avans > tbody > tr > td:nth-child(4) { font-family:courier,courier new,serif }
#chetview-details-tab2-avans > tbody > tr > td:nth-child(5) { width:15%; font-family:courier,courier new,serif }
#chetview-details-tab2-avans > tbody > tr > td:nth-child(6) { width:15%; font-family:courier,courier new,serif }
#chetview-details-tab2-avans > tbody > tr > td:nth-child(7) { width:15%; font-family:courier,courier new,serif }
#chetview-details-tab2-avans > tbody > tr > td:nth-child(8) { width:15%; font-family:courier,courier new,serif }
#chetview-details-tab2-avans > tbody > tr > td.dataTables_empty { text-align:center; border-bottom:1px #951402 solid; border-top:1px #951402 solid; text-transform:uppercase; font-style:italic; color:#951402 }
#chetview-details-tab2-avans > tbody > tr > td.chetview-details-tab2-avans-numberstage { font-weight:300; font-size:1.0em; text-transform:none }
#chetview-details-tab2-avans > tbody > tr > td.chetview-details-tab2-avans-dateplan { font-weight:300; font-size:1.0em; text-transform:none }
#chetview-details-tab2-avans > tbody > tr > td.chetview-details-tab2-avans-namestage { font-family:'Oswald', sans-serif; font-weight:500; font-size:1.3em; text-transform:none }
#chetview-details-tab2-avans > tbody > tr > td.chetview-details-tab2-avans-summastage { font-weight:300; font-size:1.0em; text-transform:none }
#chetview-details-tab2-avans > tbody > tr > td { border-top:none }
#chetview-details-tab2-avans > tbody > tr.shown > td { background-color:#336a86; color:#fff; font-weight:300 }
#chetview-details-tab2-avans > tbody > tr > td.chetview-details-tab2-avans-collapse { padding:0 }
/*
/*
/* Подвал таблицы */
#chetview-details-tab2-avans > tfoot {	color:#111; font-family:'Oswald', sans-serif; border-bottom:none;	border-top:none }
#chetview-details-tab2-avans > tfoot > tr > th { border-bottom:none; font-weight:500; font-size:1.3em; text-transform:uppercase }
#chetview-details-tab2-avans > tfoot > tr > th.chetview-details-tab2-avans-summastage { text-align:right; text-transform:none }

#chetview-details-tab2-avans-collapse-table > thead > tr > th,
#chetview-details-tab2-avans-collapse-table > tbody > tr > td { font-family:courier,courier new,serif; border-bottom:none; border-top:none }
#chetview-details-tab2-avans-collapse-table > tbody > tr > td:first-child { width:52%; font-family:courier,courier new,serif; text-align:left }
#chetview-details-tab2-avans-collapse-table > tbody > tr > td:nth-child(2) { width:16%; font-family:courier,courier new,serif; text-align:right }
#chetview-details-tab2-avans-collapse-table > tbody > tr > td:nth-child(3) { width:16%; font-family:courier,courier new,serif; text-align:right }
#chetview-details-tab2-avans-collapse-table > tbody > tr > td:nth-child(4) { width:16%; font-family:courier,courier new,serif; text-align:right }
/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----

ТАБЛИЦА "СВОДКА ПО СЧЕТАМ-ФАКТУРАМ"

----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
/*
/* Общее для таблицы */
#chetview-details-tab2-chetfzadolg {  }
#chetview-details-tab2-chetfzadolg .details-control:hover { cursor:pointer }
#chetview-details-tab2-chetfzadolg .font-courier { font-family:courier,courier new,serif }
/*
/*
/* Заголовок таблицы */
#chetview-details-tab2-chetfzadolg > thead {	color:#111; font-family:'Oswald', sans-serif; border-bottom:none;	border-top:none }
#chetview-details-tab2-chetfzadolg > thead > tr > th { color:#111; border-bottom:none; font-weight:500; font-size:1.3em; text-transform:uppercase }

#chetview-details-tab2-chetfzadolg > thead > tr > th:first-child { background-color:#f0f0f0; width:36px; text-align:center }
#chetview-details-tab2-chetfzadolg > thead > tr > th:nth-child(2) { background-color:#f0f0f0; border-left: 2px #fff solid; width:5%; text-align:center }
#chetview-details-tab2-chetfzadolg > thead > tr > th:nth-child(3) { background-color:#f0f0f0; border-left: 2px #fff solid; width:5%; text-align:center }
#chetview-details-tab2-chetfzadolg > thead > tr > th:nth-child(4) { background-color:#f0f0f0; border-left: 2px #fff solid; width:28%; text-align:left  }
#chetview-details-tab2-chetfzadolg > thead > tr > th:nth-child(5) { background-color:#f0f0f0; border-left: 2px #fff solid; width:15%; text-align:right  }
#chetview-details-tab2-chetfzadolg > thead > tr > th:nth-child(6) { background-color:#f0f0f0; border-left: 2px #fff solid; width:15%; text-align:right  }
#chetview-details-tab2-chetfzadolg > thead > tr > th:nth-child(7) { background-color:#f0f0f0; border-left: 2px #fff solid; width:15%; text-align:right  }
#chetview-details-tab2-chetfzadolg > thead > tr > th:nth-child(8) { background-color:#f0f0f0; border-left: 2px #fff solid; width:15%; text-align:right }
/*
/*
/* Тело таблицы */
#chetview-details-tab2-chetfzadolg > tbody {	font-family:'Oswald', sans-serif; color:#666; border-bottom:none;	border-top:none }
#chetview-details-tab2-chetfzadolg > tbody > tr > td { border-bottom:none; padding: 5px 8px; line-height: 1.42857143; vertical-align: middle }

#chetview-details-tab2-chetfzadolg > tbody > tr > td:first-child { width:36px; font-family:courier,courier new,serif }
#chetview-details-tab2-chetfzadolg > tbody > tr > td:nth-child(2) { width:5%; font-family:courier,courier new,serif }
#chetview-details-tab2-chetfzadolg > tbody > tr > td:nth-child(3) { width:5%; font-family:courier,courier new,serif }
#chetview-details-tab2-chetfzadolg > tbody > tr > td:nth-child(4) { width:28%; font-family:courier,courier new,serif; text-align:left }
#chetview-details-tab2-chetfzadolg > tbody > tr > td:nth-child(5) { width:15%; font-family:courier,courier new,serif }
#chetview-details-tab2-chetfzadolg > tbody > tr > td:nth-child(6) { width:15%; font-family:courier,courier new,serif }
#chetview-details-tab2-chetfzadolg > tbody > tr > td:nth-child(7) { width:15%; font-family:courier,courier new,serif }
#chetview-details-tab2-chetfzadolg > tbody > tr > td:nth-child(8) { width:15%; font-family:courier,courier new,serif }
#chetview-details-tab2-chetfzadolg > tbody > tr > td.dataTables_empty { text-align:center; border-bottom:1px #951402 solid; border-top:1px #951402 solid; text-transform:uppercase; font-style:italic; color:#951402 }
#chetview-details-tab2-chetfzadolg > tbody > tr > td.chetview-details-tab2-chetfzadolg-numberstage { font-weight:300; font-size:1.0em; text-transform:none }
#chetview-details-tab2-chetfzadolg > tbody > tr > td.chetview-details-tab2-chetfzadolg-dateplan { font-weight:300; font-size:1.0em; text-transform:none }
#chetview-details-tab2-chetfzadolg > tbody > tr > td.chetview-details-tab2-chetfzadolg-namestage { font-weight:300; font-size:1.0em; text-transform:none }
#chetview-details-tab2-chetfzadolg > tbody > tr > td.chetview-details-tab2-chetfzadolg-summastage { font-weight:300; font-size:1.0em; text-transform:none }
#chetview-details-tab2-chetfzadolg > tbody > tr > td { border-top:none }
#chetview-details-tab2-chetfzadolg > tbody > tr.shown > td { background-color:#336a86; color:#fff; font-weight:300 }
/*
/*
/* Подвал таблицы */
#chetview-details-tab2-chetfzadolg > tfoot {	color:#111; font-family:'Oswald', sans-serif; border-bottom:none;	border-top:none }
#chetview-details-tab2-chetfzadolg > tfoot > tr > th { border-bottom:none; font-weight:500; font-size:1.3em; text-transform:uppercase }
#chetview-details-tab2-chetfzadolg > tfoot > tr > th.chetview-details-tab2-chetfzadolg-summastage { text-align:right; text-transform:none }

#chetview-details-tab2-chetfzadolg > tbody > tr > td.chetview-details-tab2-chetfzadolg-collapse { padding:0 }
/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----

ТАБЛИЦА "СЧЕТА-ФАКТУРЫ COLLAPSE"

----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
#chetview-details-tab2-chetfzadolg-collapse-table { margin-bottom:0 }
#chetview-details-tab2-chetfzadolg-collapse-table > tbody > tr > td { border-bottom:none; border-top:none }
#chetview-details-tab2-chetfzadolg-collapse-table > thead > tr > th:first-child { background-color:#f0f0f0; width:36px; text-align:center }
#chetview-details-tab2-chetfzadolg-collapse-table > thead > tr > th:nth-child(2) { background-color:#f0f0f0; border-left: 2px #fff solid; width:5%; text-align:center }
#chetview-details-tab2-chetfzadolg-collapse-table > thead > tr > th:nth-child(3) { background-color:#f0f0f0; border-left: 2px #fff solid; width:5%; text-align:center }
#chetview-details-tab2-chetfzadolg-collapse-table > thead > tr > th:nth-child(4) { background-color:#f0f0f0; border-left: 2px #fff solid; text-align:left }
#chetview-details-tab2-chetfzadolg-collapse-table > thead > tr > th:nth-child(5) { background-color:#f0f0f0; border-left: 2px #fff solid; width:15%; text-align:right }
#chetview-details-tab2-chetfzadolg-collapse-table > thead > tr > th:nth-child(6) { background-color:#f0f0f0; border-left: 2px #fff solid; width:15%; text-align:right }
#chetview-details-tab2-chetfzadolg-collapse-table > thead > tr > th:nth-child(7) { background-color:#f0f0f0; border-left: 2px #fff solid; width:15%; text-align:right }
#chetview-details-tab2-chetfzadolg-collapse-table > thead > tr > th:nth-child(8) { background-color:#f0f0f0; border-left: 2px #fff solid; width:15%; text-align:right }

#chetview-details-tab2-chetfzadolg-collapse-table > tbody > tr > td:first-child { width:36px; font-family:courier,courier new,serif }
#chetview-details-tab2-chetfzadolg-collapse-table > tbody > tr > td:nth-child(2) { width:5%; font-family:courier,courier new,serif }
#chetview-details-tab2-chetfzadolg-collapse-table > tbody > tr > td:nth-child(3) { width:5%; font-family:courier,courier new,serif }
#chetview-details-tab2-chetfzadolg-collapse-table > tbody > tr > td:nth-child(4) { font-family:courier,courier new,serif; text-align:left }
#chetview-details-tab2-chetfzadolg-collapse-table > tbody > tr > td:nth-child(5) { font-family:courier,courier new,serif }
#chetview-details-tab2-chetfzadolg-collapse-table > tbody > tr > td:nth-child(6) { width:15%; font-family:courier,courier new,serif }
#chetview-details-tab2-chetfzadolg-collapse-table > tbody > tr > td:nth-child(7) { width:15%; font-family:courier,courier new,serif }
#chetview-details-tab2-chetfzadolg-collapse-table > tbody > tr > td:nth-child(8) { width:15%; font-family:courier,courier new,serif }
/* ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- */
#chetview-details-tab2-avans .chetview-details-tab2-nokalplan,
#chetview-details-tab2-chetfzadolg .chetview-details-tab2-nokalplan { font-family:courier,courier new,serif; color:#111; font-weight:500; font-size:1.0em }

</style>

<section>

	<div class="" style="padding-left:5px; padding-right:5px">
		<div class="space50"></div>
		<h3 class="chetview-details-tab2-title">Выполнение по этапам</h3>
		<div class="demo-html"></div>
		<table id="chetview-details-tab2" class="table" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>Этап</th>
					<th>Краткое наименование этапа</th>
					<th>Срок</th>
					<th class="text-center">Сумма этапа</th>
					<th class="text-center">Закрыто</th>
					<th class="text-center">Не закрыто</th>
				</tr>
			</thead>
			<tbody>
<?php
	$query_getKalplan = mysqlQuery( "SELECT kodkalplan, numberstage, nameshotstage, dateplan, summastage FROM dognet_dockalplan WHERE koddoc = ".$varKoddoc." AND koddel <> '99'" );
	$totalStage = 0.00;
	$totalSumChf = 0.00;
	$totalZadolg = 0.00;
	if (mysqli_num_rows($query_getKalplan) >= 1) {
		while ($row_getKalplan = mysqli_fetch_array($query_getKalplan, MYSQLI_ASSOC)) {
			$kodkalplan = $row_getKalplan['kodkalplan'];
?>
				<tr>
					<td class="chetview-details-tab2-numberstage text-center"><?php echo $row_getKalplan['numberstage']; ?></td>
					<td class="chetview-details-tab2-namestage text-left"><?php echo $row_getKalplan['nameshotstage']; ?></td>
					<td class="chetview-details-tab2-dateplan text-left"><?php echo $row_getKalplan['dateplan']; ?></td>
					<td class="chetview-details-tab2-summastage text-right"><?php echo number_format((float)($row_getKalplan['summastage']), 2, '.', ' ').$__dened; ?></td>
					<td class="chetview-details-tab2-summastage text-right"><?php echo number_format((float)(StageSumChf($row_getKalplan['kodkalplan'])), 2, '.', ' ').$__dened; ?></td>
					<td class="chetview-details-tab2-summastage <?php echo (StageZadolg($row_getKalplan['kodkalplan']) <> 0 ? 'text-danger' : 'text-default'); ?> text-right"><?php echo number_format((float)(StageZadolg($row_getKalplan['kodkalplan'])), 2, '.', ' ').$__dened; ?></td>
				</tr>
<?php
		// ----- ----- -----
			$totalStage += $row_getKalplan['summastage'];
			$totalSumChf += StageSumChf($row_getKalplan['kodkalplan']);
			$totalZadolg += StageZadolg($row_getKalplan['kodkalplan']);
		}
?>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="3" class="text-right text-uppercase text-right">Итоги по договору :</th>
					<th class="chetview-details-tab2-summastage text-right"><?php echo number_format((float)($totalStage), 2, '.', ' ').$__dened; ?></th>
					<th class="chetview-details-tab2-summastage text-right"><?php echo number_format((float)($totalSumChf), 2, '.', ' ').$__dened; ?></th>
					<th class="chetview-details-tab2-summastage <?php echo ($totalZadolg <> 0 ? 'text-danger' : 'text-default'); ?> text-right"><?php echo number_format((float)($totalZadolg), 2, '.', ' ').$__dened; ?></th>
				</tr>
			</tfoot>
		</table>
<?php
	}
	else {
?>
				<tr>
					<td colspan="6" class="chetview-details-tab2-message text-left text-danger">По данному договору этапы не определены</td>
				</tr>
			</tbody>
		</table>
<?php
	}
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// АВАНСОВЫЕ ПЛАТЕЖИ
// :::
?>
		<div class="space50"></div>
		<h3 class="chetview-details-tab2-title">Авансовые платежи</h3>
		<table id="chetview-details-tab2-avans" class="table" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
					<th class="text-center">Этап</th>
					<th class="text-left">Дата аванса</th>
					<th class="text-center"></th>
					<th class="text-center">Сумма аванса</th>
					<th class="text-center">Зачтено</th>
					<th class="text-center">Остаток</th>
				</tr>
			</thead>
			<tbody>
<?php
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Выбираем календарные планы (этапы) по договору
	$query_getKalplan = mysqlQuery( "SELECT kodkalplan, numberstage, nameshotstage, dateplan, summastage FROM dognet_dockalplan WHERE koddoc = ".$varKoddoc." AND koddel <> '99'" );
	if (mysqli_num_rows($query_getKalplan) >= 1) {
//
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Блок вывода авансовых платежей для договоров с календарным планом (этапами)
// BEGIN ::: BLOCK AV_1
		$cntDocavans = 0;
		while ($row_getKalplan = mysqli_fetch_array($query_getKalplan, MYSQLI_ASSOC)) {
			$kodkalplan = $row_getKalplan['kodkalplan'];
?>
				<tr style="background-color:#f7f7f7; color:#111">
					<td class="chetview-details-tab2 text-center" style="font-size:1.0em; font-weight:700"><a href="#tab2-avans-row-<?php echo $row_getKalplan['kodkalplan']; ?>" data-toggle="collapse"><span class='glyphicon glyphicon-option-vertical'></span></a></td>
					<td class="chetview-details-tab2-avans-numberstage text-center" style="font-size:1.0em; font-weight:700"><?php echo $row_getKalplan['numberstage']; ?></td>
					<td colspan="5" class="chetview-details-tab2-namestage text-left" style="font-size:1.0em; font-weight:700"><?php echo $row_getKalplan['nameshotstage']; ?></td>
				</tr>
<?php
			// Выбираем полученные авансы по текущему календарному плану (этапу)
			$query_getDocavans = mysqlQuery( "SELECT kodavans, dateavans, nameavans, summaavans, comment FROM dognet_docavans WHERE koddoc = ".$kodkalplan." AND koddel <> '99'" );
			$cntDocavans += mysqli_num_rows($query_getDocavans);
			if (mysqli_num_rows($query_getDocavans) >= 1) {
?>
				<tr id="tab2-avans-row-<?php echo $row_getKalplan['kodkalplan']; ?>" class="collapse in">
					<td class="chetview-details-tab2"></td>
					<td class="chetview-details-tab2"></td>
					<td colspan="5" class="chetview-details-tab2-avans-collapse">
						<table id="chetview-details-tab2-avans-collapse-table" class="table" cellspacing="0" width="100%">
							<tbody>
<?php
				while ($row_getDocavans = mysqli_fetch_array($query_getDocavans, MYSQLI_ASSOC)) {
					$kodavans = $row_getDocavans['kodavans'];
					$query_getAvanschf = mysqlQuery( "SELECT SUM(summaoplav) as sum1 FROM dognet_chfavans WHERE kodavans =".$kodavans." AND koddel <> '99'" );
					$row_getAvanschf = mysqli_fetch_array($query_getAvanschf, MYSQLI_ASSOC);
?>
								<tr>
									<td class="chetview-details-tab2-avans-dateplan text-left"><?php echo $row_getDocavans['dateavans']; ?></td>
									<td class="chetview-details-tab2-avans-summastage text-right"><?php echo number_format((float)($row_getDocavans['summaavans']), 2, '.', ' ').$__dened; ?></td>
									<td class="chetview-details-tab2-avans-summastage text-right"><?php echo number_format((float)($row_getAvanschf['sum1']), 2, '.', ' ').$__dened; ?></td>
									<td class="chetview-details-tab2-avans-summastage <?php echo (($row_getDocavans['summaavans']-$row_getAvanschf['sum1']) <> 0 ? 'text-danger' : 'text-default'); ?> text-right"><?php echo number_format((float)($row_getDocavans['summaavans']-$row_getAvanschf['sum1']), 2, '.', ' ').$__dened; ?></td>
								</tr>
<?php
				} // while ($row_getDocavans)
?>
							</tbody>
						</table>
					</td>
				</tr>
<?php
			} // if ($query_getDocavans)
			else {
?>
				<tr id="tab2-avans-row-<?php echo $row_getKalplan['kodkalplan']; ?>" class="collapse in">
					<td class="text-center"></td>
					<td class="text-center"></td>
					<td colspan="5" class="chetview-details-tab2-message text-left text-danger">Авансовых платежей по данному этапу не поступало...</td>
				</tr>
<?php
			} // else if ($query_getDocavans)
		} // while ($row_getKalplan)
?>
			</tbody>
		</table>
<?php
// END ::: BLOCK AV_1
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
//
	} // if ($query_getKalplan)
	else {
//
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Блок вывода авансовых платежей для договоров без календарного плана (этапов)
// BEGIN ::: BLOCK AV_0
?>
				<tr style="background-color:#f7f7f7; color:#111">
					<td colspan="7" class="chetview-details-tab2-nokalplan text-left" style="font-size:1.0em; font-weight:700">Без этапа</td>
				</tr>
<?php
			// Выбираем полученные авансы по текущему календарному плану (этапу)
			$query_getDocavans = mysqlQuery( "SELECT kodavans, dateavans, nameavans, summaavans, comment FROM dognet_docavans WHERE koddoc = ".$varKoddoc." AND koddel <> '99'" );
			if (mysqli_num_rows($query_getDocavans) >= 1) {
?>
				<tr id="tab2-avans-row-<?php echo $varKoddoc; ?>" class="collapse in">
					<td class="chetview-details-tab2"></td>
					<td class="chetview-details-tab2"></td>
					<td colspan="5" class="chetview-details-tab2-avans-collapse">
						<table id="chetview-details-tab2-avans-collapse-table" class="table" cellspacing="0" width="100%">
							<tbody>
<?php
				while ($row_getDocavans = mysqli_fetch_array($query_getDocavans, MYSQLI_ASSOC)) {
					$kodavans = $row_getDocavans['kodavans'];
					$query_getAvanschf = mysqlQuery( "SELECT SUM(summaoplav) as sum1 FROM dognet_chfavans WHERE kodavans =".$kodavans." AND koddel <> '99'" );
					$row_getAvanschf = mysqli_fetch_array($query_getAvanschf, MYSQLI_ASSOC);
?>
								<tr>
									<td class="chetview-details-tab2-avans-dateplan text-left"><?php echo $row_getDocavans['dateavans']; ?></td>
									<td class="chetview-details-tab2-avans-summastage text-right"><?php echo number_format((float)($row_getDocavans['summaavans']), 2, '.', ' ').$__dened; ?></td>
									<td class="chetview-details-tab2-avans-summastage text-right"><?php echo number_format((float)($row_getAvanschf['sum1']), 2, '.', ' ').$__dened; ?></td>
									<td class="chetview-details-tab2-avans-summastage <?php echo (($row_getDocavans['summaavans']-$row_getAvanschf['sum1']) <> 0 ? 'text-danger' : 'text-default'); ?> text-right"><?php echo number_format((float)($row_getDocavans['summaavans']-$row_getAvanschf['sum1']), 2, '.', ' ').$__dened; ?></td>
								</tr>
<?php
				} // while ($row_getDocavans)
?>
							</tbody>
						</table>
					</td>
				</tr>
<?php
			} // if ($query_getDocavans)
			else {
?>
				<tr id="tab2-avans-row-<?php echo $row_getKalplan['kodkalplan']; ?>" class="collapse in">
					<td class="text-center"></td>
					<td class="text-center"></td>
					<td colspan="5" class="chetview-details-tab2-message text-left text-danger">Авансовых платежей по данному этапу не поступало...</td>
				</tr>
<?php
			} // else if ($query_getDocavans)
?>
			</tbody>
		</table>
<?php
// END ::: BLOCK AV_0
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
//
	}
//
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// СЧЕТА-ФАКТУРЫ
// :::
?>
		<div class="space50"></div>
		<h3 class="chetview-details-tab2-title">Выставленые счета-фактуры</h3>
		<table id="chetview-details-tab2-chetfzadolg" class="table" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
					<th class="text-center">Этап</th>
					<th class="text-center">№</th>
					<th class="text-center">Дата счета</th>
					<th class="text-center">Сумма счета</th>
					<th class="text-center">Оплачено</th>
					<th class="text-center">Зачтено</th>
					<th class="text-center">Задолженность</th>
				</tr>
			</thead>
			<tbody>
<?php
	$query_getKalplan = mysqlQuery( "SELECT kodkalplan, numberstage, nameshotstage, dateplan, summastage FROM dognet_dockalplan WHERE koddoc = ".$varKoddoc." AND koddel <> '99'" );
	if (mysqli_num_rows($query_getKalplan) >= 1) {
//
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Блок вывода счетов-фактур для договоров с календарным планом (этапами)
// BEGIN ::: BLOCK CHF_1
		$cntChetf = 0;
		while ($row_getKalplan = mysqli_fetch_array($query_getKalplan, MYSQLI_ASSOC)) {
			$kodkalplan = $row_getKalplan['kodkalplan'];
?>
				<tr style="background-color:#f7f7f7; color:#111">
					<td class="chetview-details-tab2-chetfzadolg text-center" style="font-size:1.0em; font-weight:700"><a href="#tab2-chetf-row-<?php echo $row_getKalplan['kodkalplan']; ?>" data-toggle="collapse"><span class='glyphicon glyphicon-option-vertical'></span></a></td>
					<td class="chetview-details-tab2-chetfzadolg-numberstage text-center" style="font-size:1.0em; font-weight:700"><?php echo $row_getKalplan['numberstage']; ?></td>
					<td colspan="6" class="chetview-details-tab2-chetfzadolg-namestage text-left" style="font-size:1.0em; font-weight:700"><?php echo $row_getKalplan['nameshotstage']; ?></td>
				</tr>
<?php
			// Выбираем выставленные счета-фактуры по текущему календарному плану (этапу)
			$query_getChetf = mysqlQuery( "SELECT kodchfact, chetfnumber, chetfdate, chetfsumma, comment FROM dognet_kalplanchf WHERE kodkalplan = ".$kodkalplan." AND koddel <> '99'" );
			if (mysqli_num_rows($query_getChetf) >= 1) {
?>
				<tr id="tab2-chetf-row-<?php echo $row_getKalplan['kodkalplan']; ?>" class="collapse in">
					<td colspan="8" class="chetview-details-tab2-chetfzadolg-collapse">
						<table id="chetview-details-tab2-chetfzadolg-collapse-table" class="table" cellspacing="0" width="100%">
							<tbody>
<?php
				while ($row_getChetf = mysqli_fetch_array($query_getChetf, MYSQLI_ASSOC)) {
					$kodchfact = $row_getChetf['kodchfact'];
?>
								<tr>
									<td class="chetview-details-tab2-chetfzadolg-numberstage text-center"></td>
									<td class="chetview-details-tab2-chetfzadolg-numberstage text-center">СФ</td>
									<td class="chetview-details-tab2-chetfzadolg-numberstage text-center"><?php echo $row_getChetf['chetfnumber']; ?></td>
									<td class="chetview-details-tab2-chetfzadolg-dateplan text-left"><?php echo $row_getChetf['chetfdate']; ?></td>
									<td class="chetview-details-tab2-chetfzadolg-summastage text-right"><?php echo number_format((float)($row_getChetf['chetfsumma']), 2, '.', ' ').$__dened; ?></td>
									<td class="chetview-details-tab2-chetfzadolg-summastage text-right"><?php echo number_format((float)(ChetfOplata($row_getChetf['kodchfact'])), 2, '.', ' ').$__dened; ?></td>
									<td class="chetview-details-tab2-chetfzadolg-summastage text-right"><?php echo number_format((float)(ChetfAvans($row_getChetf['kodchfact'])), 2, '.', ' ').$__dened; ?></td>
									<td class="chetview-details-tab2-chetfzadolg-summastage <?php echo (ChetfZadolg($row_getChetf['kodchfact']) <> 0 ? 'text-danger' : 'text-default'); ?> text-right"><?php echo number_format((float)(ChetfZadolg($row_getChetf['kodchfact'])), 2, '.', ' ').$__dened; ?></td>
								</tr>
<?php
				// В таблице dognet_oplatachf находим все оплаченные счета-фактуры с кодом kodchfact и суммируем
					$query_getOplatachf = mysqlQuery( "SELECT dateopl, summaopl, comment FROM dognet_oplatachf WHERE kodchfact =".$kodchfact." AND koddel <> '99'" );
					while ($row_getOplatachf = mysqli_fetch_array($query_getOplatachf, MYSQLI_ASSOC)) {
?>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td class="chetview-details-tab2-chetfzadolg-namestage text-right">Оплата от <?php echo $row_getOplatachf['dateopl']; ?></td>
									<td></td>
									<td class="chetview-details-tab2-chetfzadolg-summastage text-right"><?php echo number_format((float)($row_getOplatachf['summaopl']), 2, '.', ' ').$__dened; ?></td>
									<td colspan="2"></td>
								</tr>
<?php
					}
					// В таблице dognet_oplatachf находим все оплаченные счета-фактуры с кодом kodchfact и суммируем
					$query_getAvanschf = mysqlQuery( "SELECT summaoplav FROM dognet_chfavans WHERE kodchfact =".$kodchfact." AND koddel <> '99' AND summaoplav <> 0" );
					while ($row_getAvanschf = mysqli_fetch_array($query_getAvanschf, MYSQLI_ASSOC)) {
?>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td class="chetview-details-tab2-chetfzadolg-namestage text-right">Зачтено из аванса</td>
									<td></td>
									<td></td>
									<td class="chetview-details-tab2-chetfzadolg-summastage text-right"><?php echo number_format((float)($row_getAvanschf['summaoplav']), 2, '.', ' ').$__dened; ?></td>
									<td></td>
								</tr>
<?php
					}
				}
?>
							</tbody>
						</table>
					</td>
				</tr>
<?php
			}
			else {
?>
				<tr id="tab2-chetf-row-<?php echo $row_getKalplan['kodkalplan']; ?>" class="collapse in">
					<td class="chetview-details-tab2"></td>
					<td class="chetview-details-tab2"></td>
					<td colspan="6" class="chetview-details-tab2-chetfzadolg-collapse">
						<table id="chetview-details-tab2-chetfzadolg-collapse-table" class="table" cellspacing="0" width="100%">
							<tbody>
								<tr>
									<td class="chetview-details-tab2-message text-left text-danger">Счетов-фактур по данному этапу не выставлялось...</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
<?php
			}
		}
?>
					</td>
				</tr>
			</tbody>
		</table>
<?php
// END ::: BLOCK CHF_1
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
//
	}
	else {
//
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Блок вывода счетов-фактур для договоров без календарного плана (этапов)
// BEGIN ::: BLOCK CHF_0
?>
				<tr style="background-color:#f7f7f7; color:#111">
					<td colspan="8" class="chetview-details-tab2-nokalplan text-left" style="font-size:1.0em; font-weight:700">Без этапа</td>
				</tr>
<?php
			// Выбираем выставленные счета-фактуры по текущему календарному плану (этапу)
			$query_getChetf = mysqlQuery( "SELECT kodchfact, chetfnumber, chetfdate, chetfsumma, comment FROM dognet_kalplanchf WHERE kodkalplan = ".$varKoddoc." AND koddel <> '99'" );
			if (mysqli_num_rows($query_getChetf) >= 1) {
?>
				<tr id="tab2-chetf-row-<?php echo $varKoddoc; ?>" class="collapse in">
					<td colspan="8" class="chetview-details-tab2-chetfzadolg-collapse">
						<table id="chetview-details-tab2-chetfzadolg-collapse-table" class="table" cellspacing="0" width="100%">
							<tbody>
<?php
				while ($row_getChetf = mysqli_fetch_array($query_getChetf, MYSQLI_ASSOC)) {
					$kodchfact = $row_getChetf['kodchfact'];
?>
								<tr>
									<td class="chetview-details-tab2-chetfzadolg-numberstage text-center"></td>
									<td class="chetview-details-tab2-chetfzadolg-numberstage text-center">СФ</td>
									<td class="chetview-details-tab2-chetfzadolg-numberstage text-center"><?php echo $row_getChetf['chetfnumber']; ?></td>
									<td class="chetview-details-tab2-chetfzadolg-dateplan text-left"><?php echo $row_getChetf['chetfdate']; ?></td>
									<td class="chetview-details-tab2-chetfzadolg-summastage text-right"><?php echo number_format((float)($row_getChetf['chetfsumma']), 2, '.', ' ').$__dened; ?></td>
									<td class="chetview-details-tab2-chetfzadolg-summastage text-right"><?php echo number_format((float)(ChetfOplata($row_getChetf['kodchfact'])), 2, '.', ' ').$__dened; ?></td>
									<td class="chetview-details-tab2-chetfzadolg-summastage text-right"><?php echo number_format((float)(ChetfAvans($row_getChetf['kodchfact'])), 2, '.', ' ').$__dened; ?></td>
									<td class="chetview-details-tab2-chetfzadolg-summastage <?php echo (ChetfZadolg($row_getChetf['kodchfact']) <> 0 ? 'text-danger' : 'text-default'); ?> text-right"><?php echo number_format((float)(ChetfZadolg($row_getChetf['kodchfact'])), 2, '.', ' ').$__dened; ?></td>
								</tr>
<?php
				// В таблице dognet_oplatachf находим все оплаченные счета-фактуры с кодом kodchfact и суммируем
					$query_getOplatachf = mysqlQuery( "SELECT dateopl, summaopl, comment FROM dognet_oplatachf WHERE kodchfact =".$kodchfact." AND koddel <> '99'" );
					while ($row_getOplatachf = mysqli_fetch_array($query_getOplatachf, MYSQLI_ASSOC)) {
?>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td class="chetview-details-tab2-chetfzadolg-namestage text-right">Оплата от <?php echo $row_getOplatachf['dateopl']; ?></td>
									<td></td>
									<td class="chetview-details-tab2-chetfzadolg-summastage text-right"><?php echo number_format((float)($row_getOplatachf['summaopl']), 2, '.', ' ').$__dened; ?></td>
									<td colspan="2"></td>
								</tr>
<?php
					}
					// В таблице dognet_oplatachf находим все оплаченные счета-фактуры с кодом kodchfact и суммируем
					$query_getAvanschf = mysqlQuery( "SELECT summaoplav FROM dognet_chfavans WHERE kodchfact =".$kodchfact." AND koddel <> '99' AND summaoplav <> 0" );
					while ($row_getAvanschf = mysqli_fetch_array($query_getAvanschf, MYSQLI_ASSOC)) {
?>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td class="docview-details-tab2-chetfzadolg-namestage text-right">Зачтено из аванса</td>
									<td></td>
									<td></td>
									<td class="docview-details-tab2-chetfzadolg-summastage text-right"><?php echo number_format((float)($row_getAvanschf['summaoplav']), 2, '.', ' ').$__dened; ?></td>
									<td></td>
								</tr>
<?php
					}
				}
?>
							</tbody>
						</table>
					</td>
				</tr>
<?php
			}
			else {
?>
				<tr id="tab2-chetf-row-<?php echo $varKoddoc; ?>" class="collapse in">
					<td class="docview-details-tab2"></td>
					<td class="docview-details-tab2"></td>
					<td colspan="6" class="docview-details-tab2-chetfzadolg-collapse">
						<table id="docview-details-tab2-chetfzadolg-collapse-table" class="table" cellspacing="0" width="100%">
							<tbody>
								<tr>
									<td class="docview-details-tab2-message text-left text-danger">Счетов-фактур по данному этапу не выставлялось...</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
<?php
			}
?>
					</td>
				</tr>
			</tbody>
		</table>
<?php
// END ::: BLOCK CHF_0
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
//
	}
?>
	</div>

</section>
