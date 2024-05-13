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
# Функция расчета суммарных платежей по этапу (оплата + аванс) с кодом kodkalplan
# 
function DocSubpodrOplata($varKodkalplan) { 
// Из таблицы dognet_kalplanchf определяем код(ы) счета(ов)-фактур - kodchfact относящихся к соответствующему этапу (календарному плану)
	$query_getKodchfact = mysqlQuery( "SELECT kodchfact FROM dognet_kalplanchf WHERE kodkalplan =".$varKodkalplan." AND koddel <> '99'" );
	$varSummaOplatChf = 0.0;
	$varSummaAvansChf = 0.0;
	while($row_getKodchfact = mysqli_fetch_array($query_getKodchfact, MYSQLI_ASSOC)) { 
		$varKodchfact = $row_getKodchfact['kodchfact'];
	// В таблице dognet_oplatachf находим все оплаченные счета-фактуры с кодом kodchfact и суммируем
		$query_getSummaopl = mysqlQuery( "SELECT SUM(summaopl) as SummaOplatChf FROM dognet_oplatachf WHERE kodchfact =".$varKodchfact." AND koddel <> '99'" );
		$row_getSummaopl = mysqli_fetch_array($query_getSummaopl, MYSQLI_ASSOC);
		$varSummaOplatChf += $row_getSummaopl['SummaOplatChf'];
	// В таблице dognet_chfavans находим все авансы по счетам-фактурам с кодом kodchfact и суммируем
		$query_getSummaoplav = mysqlQuery( "SELECT SUM(summaoplav) as SummaAvansChf FROM dognet_chfavans WHERE kodchfact =".$varKodchfact." AND koddel <> '99'" );
		$row_getSummaoplav = mysqli_fetch_array($query_getSummaoplav, MYSQLI_ASSOC);
		$varSummaAvansChf += $row_getSummaoplav['SummaAvansChf'];
	}
	return $varSummaOplatChf+$varSummaAvansChf;
}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
# Функция расчета итоговой задолженности по этапу с кодом kodkalplan
# 
function StageSubpodr($varKodkalplan) { 
// Из таблицы dognet_dockalplan определяем код(ы) этапа(ов) - kodkalplan
	$query_getSummastage = mysqlQuery( "SELECT summastage FROM dognet_dockalplan WHERE kodkalplan = ".$varKodkalplan." AND koddel <> '99'" );
	$row_getSummastage = mysqli_fetch_array($query_getSummastage, MYSQLI_ASSOC);
	$varSummastage = $row_getSummastage['summastage'];
	return $varSummastage - DocSubpodrOplata($varKodkalplan);
}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
# Функция расчета суммарных платежей по счету-фактуре с кодом kodchfact
# 
function SubpodrChetfOplata($varKodchfact) { 
// В таблице dognet_oplatachf находим все оплаченные счета-фактуры с кодом kodchfact и суммируем
	$query_getSummaopl = mysqlQuery( "SELECT SUM(summaopl) as SummaOplatChf FROM dognet_oplatachf WHERE kodchfact =".$varKodchfact." AND koddel <> '99'" );
	$row_getSummaopl = mysqli_fetch_array($query_getSummaopl, MYSQLI_ASSOC);
	$varSummaOplatChf = $row_getSummaopl['SummaOplatChf'];
	return $varSummaOplatChf;
}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
# Функция расчета суммы авансов по счету-фактуре с кодом kodchfact
# 
function SubpodrChetfAvans($varKodchfact) { 
// В таблице dognet_chfavans находим все авансы по счетам-фактурам с кодом kodchfact и суммируем
	$query_getSummaoplav = mysqlQuery( "SELECT SUM(summaoplav) as SummaAvansChf FROM dognet_chfavans WHERE kodchfact =".$varKodchfact." AND koddel <> '99'" );
	$row_getSummaoplav = mysqli_fetch_array($query_getSummaoplav, MYSQLI_ASSOC);
	$varSummaAvansChf = $row_getSummaoplav['SummaAvansChf'];
	return $varSummaAvansChf;
}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
# Функция расчета суммы авансов по счету-фактуре с кодом kodchfact
# 
function ChetfSubpodr($varKodchfact) { 
// Из таблицы dognet_kalplanchf определяем код(ы) счета(ов)-фактур - kodchfact относящихся к соответствующему этапу (календарному плану)
	$query_getChetfsumma = mysqlQuery( "SELECT chetfsumma FROM dognet_kalplanchf WHERE kodchfact =".$varKodchfact." AND koddel <> '99'" );
	while($row_getChetfsumma = mysqli_fetch_array($query_getChetfsumma, MYSQLI_ASSOC)) { 
		$varChetfSubpodr = $row_getChetfsumma['chetfsumma'] - (SubpodrChetfOplata($varKodchfact) + SubpodrChetfAvans($varKodchfact));
	}
	return $varChetfSubpodr;
}
?>

<style>
/* 
----- ----- ----- ----- ----- ----- ----- ----- ----- -----  

ТАБЛИЦА "СВОДКА ПО ЭТАПАМ"

----- ----- ----- ----- ----- ----- ----- ----- ----- -----  
*/
/* 
/* Общее для таблицы */
#docview-details-tab6 {  }
#docview-details-tab6 .details-control:hover { cursor:pointer }
#docview-details-tab6 .font-courier { font-family:courier,courier new,serif }
/* 
/* 
/* Заголовок таблицы */
#docview-details-tab6 > thead {	color:#111; font-family:'Oswald', sans-serif; border-bottom:none;	border-top:none }
#docview-details-tab6 > thead > tr > th { color:#111; border-bottom:none; font-weight:500; font-size:1.3em; text-transform:uppercase }
#docview-details-tab6 > thead > tr > th:first-child { background-color:#f0f0f0; width:5%; text-align:center }
#docview-details-tab6 > thead > tr > th:nth-child(2) { background-color:#f0f0f0; width:25%; border-left: 2px #fff solid; text-align:left }
#docview-details-tab6 > thead > tr > th:nth-child(3) { background-color:#f0f0f0; border-left: 2px #fff solid; width:15%; text-align:left  }
#docview-details-tab6 > thead > tr > th:nth-child(4) { background-color:#f0f0f0; border-left: 2px #fff solid; text-align:left  }
#docview-details-tab6 > thead > tr > th:nth-child(5) { background-color:#f0f0f0; border-left: 2px #fff solid; width:15%; text-align:right  }
#docview-details-tab6 > thead > tr > th:nth-child(6) { background-color:#f0f0f0; border-left: 2px #fff solid; text-align:right }
/* 
/* 
/* Тело таблицы */
#docview-details-tab6 > tbody {	font-family:'Oswald', sans-serif; color:#666; border-bottom:none;	border-top:none }
#docview-details-tab6 > tbody > tr > td { border-bottom:none; padding: 5px 8px; line-height: 1.42857143; vertical-align: middle }
#docview-details-tab6 > tbody > tr > td:first-child { width:5%; font-family:courier,courier new,serif }
#docview-details-tab6 > tbody > tr > td:nth-child(2) { width:25%; font-family:courier,courier new,serif }
#docview-details-tab6 > tbody > tr > td:nth-child(3) { width:15%; font-family:courier,courier new,serif }
#docview-details-tab6 > tbody > tr > td:nth-child(4) { font-family:courier,courier new,serif }
#docview-details-tab6 > tbody > tr > td:nth-child(5) { width:15%; font-family:courier,courier new,serif }
#docview-details-tab6 > tbody > tr > td:nth-child(6) { font-family:courier,courier new,serif }
#docview-details-tab6 > tbody > tr > td.dataTables_empty { text-align:center; border-bottom:1px #951402 solid; border-top:1px #951402 solid; text-transform:uppercase; font-style:italic; color:#951402 }
#docview-details-tab6 > tbody > tr > td.docview-details-tab6-numberstage { font-weight:300; font-size:1.0em; text-transform:none }
#docview-details-tab6 > tbody > tr > td.docview-details-tab6-dateplan { font-weight:300; font-size:1.0em; text-transform:none }
#docview-details-tab6 > tbody > tr > td.docview-details-tab6-namestage { font-weight:300; font-size:1.0em; text-transform:none }
#docview-details-tab6 > tbody > tr > td.docview-details-tab6-summastage { font-weight:300; font-size:1.0em; text-transform:none }
#docview-details-tab6 > tbody > tr > td { border-top:none }
#docview-details-tab6 > tbody > tr.shown > td { background-color:#336a86; color:#fff; font-weight:300 }
/* 
/* 
/* Подвал таблицы */
#docview-details-tab6 > tfoot {	color:#111; font-family:'Oswald', sans-serif; border-bottom:none;	border-top:none }
#docview-details-tab6 > tfoot > tr > th { border-bottom:none; font-weight:500; font-size:1.3em; text-transform:uppercase }
#docview-details-tab6 > tfoot > tr > th.docview-details-tab6-summastage { text-align:right; text-transform:none }


/* 
/* 
/* Разное */
#docview-tab6 .panel-title { font-size:1.3em; font-weight:600; text-transform:none;	padding:0 }
#docview-tab6 .panel { border:1px solid #f5f5f5 }

#docview-details-tab6 .sorting_asc:after { display:none }
#docview-details-tab6 > thead > tr > th.sorting_asc { padding-right:8px }
#docview-details-tab6 .sorting_desc:after { display:none }
#docview-details-tab6 > thead > tr > th.sorting_desc { padding-right:8px }

#row-details-tab6 { font-family:'Oswald', sans-serif; font-size:1.0em }
#row-details-tab6 > tbody >tr > td { text-align:left }
#docview-details-tab6 .details-body { border:3px #333 solid; border-radius:10px; border-collapse:collapse }
#end-of-child { border-bottom:3px #333 solid; border-left:3px #333 solid; border-right:3px #333 solid } 
#docview-details-tab6-chfact.table < div < td { border-left:3px #333 solid; border-right:3px #333 solid }

.docview-details-tab6-title { color:#111; font-family:'Oswald', sans-serif; font-size:1.7em; font-weight:300; margin-bottom:20px; letter-spacing:0.3em }

/* 
----- ----- ----- ----- ----- ----- ----- ----- ----- -----  

ТАБЛИЦА "СВОДКА ПО АВАНСАМ"

----- ----- ----- ----- ----- ----- ----- ----- ----- -----  
*/
/* 
/* Общее для таблицы */
#docview-details-tab6-avans {  }
#docview-details-tab6-avans .details-control:hover { cursor:pointer }
#docview-details-tab6-avans .font-courier { font-family:courier,courier new,serif }
/* 
/* 
/* Заголовок таблицы */
#docview-details-tab6-avans > thead {	color:#111; font-family:'Oswald', sans-serif; border-bottom:none;	border-top:none }
#docview-details-tab6-avans > thead > tr > th { color:#111; border-bottom:none; font-weight:500; font-size:1.3em; text-transform:uppercase }
#docview-details-tab6-avans > thead > tr > th:first-child { background-color:#f0f0f0; width:5%; text-align:center }
#docview-details-tab6-avans > thead > tr > th:nth-child(2) { background-color:#f0f0f0; width:5%; text-align:center }
#docview-details-tab6-avans > thead > tr > th:nth-child(3) { background-color:#f0f0f0; border-left: 2px #fff solid; text-align:left  }
#docview-details-tab6-avans > thead > tr > th:nth-child(4) { background-color:#f0f0f0; width:15%; text-align:right  }
#docview-details-tab6-avans > thead > tr > th:nth-child(5) { background-color:#f0f0f0; border-left: 2px #fff solid; width:15%; text-align:right  }
#docview-details-tab6-avans > thead > tr > th:nth-child(6) { background-color:#f0f0f0; border-left: 2px #fff solid; width:15%; text-align:right  }
#docview-details-tab6-avans > thead > tr > th:nth-child(7) { background-color:#f0f0f0; border-left: 2px #fff solid; width:15%; text-align:right }
/* 
/* 
/* Тело таблицы */
#docview-details-tab6-avans > tbody {	font-family:'Oswald', sans-serif; color:#666; border-bottom:none;	border-top:none }
#docview-details-tab6-avans > tbody > tr > td { border-bottom:none; padding: 5px 8px; line-height: 1.42857143; vertical-align: middle }
#docview-details-tab6-avans > tbody > tr > td:first-child { width:5%; font-family:courier,courier new,serif }
#docview-details-tab6-avans > tbody > tr > td:nth-child(2) { width:5%; font-family:courier,courier new,serif }
#docview-details-tab6-avans > tbody > tr > td:nth-child(3) { font-family:courier,courier new,serif }
#docview-details-tab6-avans > tbody > tr > td:nth-child(4) { width:15%; font-family:courier,courier new,serif }
#docview-details-tab6-avans > tbody > tr > td:nth-child(5) { width:15%; font-family:courier,courier new,serif }
#docview-details-tab6-avans > tbody > tr > td:nth-child(6) { width:15%; font-family:courier,courier new,serif }
#docview-details-tab6-avans > tbody > tr > td:nth-child(7) { width:15%; font-family:courier,courier new,serif }
#docview-details-tab6-avans > tbody > tr > td.dataTables_empty { text-align:center; border-bottom:1px #951402 solid; border-top:1px #951402 solid; text-transform:uppercase; font-style:italic; color:#951402 }
#docview-details-tab6-avans > tbody > tr > td.docview-details-tab6-avans-numberstage { font-weight:300; font-size:1.0em; text-transform:none }
#docview-details-tab6-avans > tbody > tr > td.docview-details-tab6-avans-dateplan { font-weight:300; font-size:1.0em; text-transform:none }
#docview-details-tab6-avans > tbody > tr > td.docview-details-tab6-avans-namestage { font-family:'Oswald', sans-serif; font-weight:500; font-size:1.3em; text-transform:none; text-align:left }
#docview-details-tab6-avans > tbody > tr > td.docview-details-tab6-avans-summastage { font-weight:300; font-size:1.0em; text-transform:none }
#docview-details-tab6-avans > tbody > tr > td { border-top:none }
#docview-details-tab6-avans > tbody > tr.shown > td { background-color:#336a86; color:#fff; font-weight:300 }
/* 
/* 
/* Подвал таблицы */
#docview-details-tab6-avans > tfoot {	color:#111; font-family:'Oswald', sans-serif; border-bottom:none;	border-top:none }
#docview-details-tab6-avans > tfoot > tr > th { border-bottom:none; font-weight:500; font-size:1.3em; text-transform:uppercase }
#docview-details-tab6-avans > tfoot > tr > th.docview-details-tab6-avans-summastage { text-align:right; text-transform:none }

/* 
----- ----- ----- ----- ----- ----- ----- ----- ----- -----  

ТАБЛИЦА "СВОДКА ПО СЧЕТАМ-ФАКТУРАМ"

----- ----- ----- ----- ----- ----- ----- ----- ----- -----  
*/
/* 
/* Общее для таблицы */
#docview-details-tab6-ChetfSubpodr {  }
#docview-details-tab6-ChetfSubpodr .details-control:hover { cursor:pointer }
#docview-details-tab6-ChetfSubpodr .font-courier { font-family:courier,courier new,serif }
/* 
/* 
/* Заголовок таблицы */
#docview-details-tab6-ChetfSubpodr > thead {	color:#111; font-family:'Oswald', sans-serif; border-bottom:none;	border-top:none }
#docview-details-tab6-ChetfSubpodr > thead > tr > th { color:#111; border-bottom:none; font-weight:500; font-size:1.3em; text-transform:uppercase }
#docview-details-tab6-ChetfSubpodr > thead > tr > th:first-child { background-color:#f0f0f0; width:5%; text-align:center }
#docview-details-tab6-ChetfSubpodr > thead > tr > th:nth-child(2) { background-color:#f0f0f0; border-left: 2px #fff solid; width:5%; text-align:center }
#docview-details-tab6-ChetfSubpodr > thead > tr > th:nth-child(3) { background-color:#f0f0f0; border-left: 2px #fff solid; text-align:left  }
#docview-details-tab6-ChetfSubpodr > thead > tr > th:nth-child(4) { background-color:#f0f0f0; border-left: 2px #fff solid; width:15%; text-align:right  }
#docview-details-tab6-ChetfSubpodr > thead > tr > th:nth-child(5) { background-color:#f0f0f0; border-left: 2px #fff solid; width:15%; text-align:right  }
#docview-details-tab6-ChetfSubpodr > thead > tr > th:nth-child(6) { background-color:#f0f0f0; border-left: 2px #fff solid; width:15%; text-align:right  }
#docview-details-tab6-ChetfSubpodr > thead > tr > th:nth-child(7) { background-color:#f0f0f0; border-left: 2px #fff solid; width:15%; text-align:right }
/* 
/* 
/* Тело таблицы */
#docview-details-tab6-ChetfSubpodr > tbody {	font-family:'Oswald', sans-serif; color:#666; border-bottom:none;	border-top:none }
#docview-details-tab6-ChetfSubpodr > tbody > tr > td { border-bottom:none; padding: 5px 8px; line-height: 1.42857143; vertical-align: middle }
#docview-details-tab6-ChetfSubpodr > tbody > tr > td:first-child { width:5%; font-family:courier,courier new,serif }
#docview-details-tab6-ChetfSubpodr > tbody > tr > td:nth-child(2) { width:5%; font-family:courier,courier new,serif }
#docview-details-tab6-ChetfSubpodr > tbody > tr > td:nth-child(3) { font-family:courier,courier new,serif }
#docview-details-tab6-ChetfSubpodr > tbody > tr > td:nth-child(4) { width:15%; font-family:courier,courier new,serif }
#docview-details-tab6-ChetfSubpodr > tbody > tr > td:nth-child(5) { width:15%; font-family:courier,courier new,serif }
#docview-details-tab6-ChetfSubpodr > tbody > tr > td:nth-child(6) { width:15%; font-family:courier,courier new,serif }
#docview-details-tab6-ChetfSubpodr > tbody > tr > td:nth-child(7) { width:15%; font-family:courier,courier new,serif }
#docview-details-tab6-ChetfSubpodr > tbody > tr > td.dataTables_empty { text-align:center; border-bottom:1px #951402 solid; border-top:1px #951402 solid; text-transform:uppercase; font-style:italic; color:#951402 }
#docview-details-tab6-ChetfSubpodr > tbody > tr > td.docview-details-tab6-ChetfSubpodr-numberstage { font-weight:300; font-size:1.0em; text-transform:none }
#docview-details-tab6-ChetfSubpodr > tbody > tr > td.docview-details-tab6-ChetfSubpodr-dateplan { font-weight:300; font-size:1.0em; text-transform:none }
#docview-details-tab6-ChetfSubpodr > tbody > tr > td.docview-details-tab6-ChetfSubpodr-namestage { font-family:'Oswald', sans-serif; font-weight:500; font-size:1.3em; text-transform:none; text-align:left }
#docview-details-tab6-ChetfSubpodr > tbody > tr > td.docview-details-tab6-ChetfSubpodr-summastage { font-weight:300; font-size:1.0em; text-transform:none }
#docview-details-tab6-ChetfSubpodr > tbody > tr > td { border-top:none }
#docview-details-tab6-ChetfSubpodr > tbody > tr.shown > td { background-color:#336a86; color:#fff; font-weight:300 }
/* 
/* 
/* Подвал таблицы */
#docview-details-tab6-ChetfSubpodr > tfoot {	color:#111; font-family:'Oswald', sans-serif; border-bottom:none;	border-top:none }
#docview-details-tab6-ChetfSubpodr > tfoot > tr > th { border-bottom:none; font-weight:500; font-size:1.3em; text-transform:uppercase }
#docview-details-tab6-ChetfSubpodr > tfoot > tr > th.docview-details-tab6-ChetfSubpodr-summastage { text-align:right; text-transform:none }
/* 
----- ----- ----- ----- ----- ----- ----- ----- ----- -----  

ОБЩЕЕ

----- ----- ----- ----- ----- ----- ----- ----- ----- -----  
*/
#docview-details-tab6 > tbody > tr > td.table-message {  }
#docview-details-tab6 > tbody > tr > td.docview-details-tab6-message, 
#docview-details-tab6-avans > tbody > tr > td.docview-details-tab6-message {  }
#docview-details-tab6-message-table > thead > tr > th, #docview-details-tab6-message-table > tbody > tr > td { border-bottom:none; border-top:none }
.docview-details-tab6-message { font-family:'Oswald', sans-serif; font-size:1.3em; letter-spacing:0.2em }
</style>

<section>
	
	<div class="" style="padding-left:5px; padding-right:5px">
		<div class="space50"></div>
<?php
$query_getKalplan = mysqlQuery( "SELECT kodkalplan, numberstage, nameshotstage, dateplan, summastage FROM dognet_dockalplan WHERE koddoc = ".$varKoddoc." AND koddel <> '99'" );
$cntDocsubpodr = 0;
if (mysqli_num_rows($query_getKalplan) >= 1) { 
	while ($row_getKalplan = mysqli_fetch_array($query_getKalplan, MYSQLI_ASSOC)) { 
		$kodkalplan = $row_getKalplan['kodkalplan'];
		// Получаем информацию о договоре субподряда
		$query_getDocsubpodr = mysqlQuery( "SELECT * FROM dognet_docsubpodr WHERE koddoc = ".$kodkalplan );
		$cntDocsubpodr += mysqli_num_rows($query_getDocsubpodr);
	}
}
if (!isset($cntDocsubpodr) || $cntDocsubpodr == 0) { 
?>
		<table id="docview-details-tab6-message-table" class="table table-condensed" cellspacing="0" width="100%">
			<tbody>
				<tr>
					<td class="docview-details-tab6-message text-center text-danger">Договоров субподряда не заключалось</td>
				</tr>
			</tbody>
		</table>
<?php
}
else {
?>
		<h3 class="docview-details-tab6-title">Догвора субподряда по этапам</h3>
		<div class="demo-html"></div>
		<table id="docview-details-tab6" class="table" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>Этап</th>
					<th>Субподрядчик</th>
					<th>Номер договора</th>
					<th>Описание договора</th>
					<th>Сумма договора</th>
				</tr>
			</thead>
			<tbody>
<?php
	$query_getKalplan = mysqlQuery( "SELECT kodkalplan, numberstage, nameshotstage, dateplan, summastage FROM dognet_dockalplan WHERE koddoc = ".$varKoddoc." AND koddel <> '99'" );
	if (mysqli_num_rows($query_getKalplan) >= 1) { 
		$cntDocsubpodr = 0;
		while ($row_getKalplan = mysqli_fetch_array($query_getKalplan, MYSQLI_ASSOC)) { 
			$kodkalplan = $row_getKalplan['kodkalplan'];
			// Получаем информацию о договоре субподряда
			$query_getDocsubpodr = mysqlQuery( "SELECT * FROM dognet_docsubpodr WHERE koddoc = ".$kodkalplan );
			$cntDocsubpodr += mysqli_num_rows($query_getDocsubpodr);
			if (mysqli_num_rows($query_getDocsubpodr) >= 1) { 
?>
				<tr style="background-color:#f7f7f7; color:#111">
					<td class="docview-details-tab5-avans-numberstage text-center" style="font-size:1.0em; font-weight:700"><?php echo $row_getKalplan['numberstage']; ?></td>
					<td colspan="4" class="docview-details-tab5-namestage text-left" style="font-size:1.0em; font-weight:700"><?php echo $row_getKalplan['nameshotstage']; ?></td>
				</tr>
<?php
				while ($row_getDocsubpodr = mysqli_fetch_array($query_getDocsubpodr, MYSQLI_ASSOC)) { 
					$kodsubpodr = $row_getDocsubpodr['kodsubpodr'];
					// Получаем информацию об организации субподрядчике
					$query_getSubpodr = mysqlQuery( "SELECT * FROM dognet_spsubpodr WHERE kodsubpodr = ".$kodsubpodr );
					if (mysqli_num_rows($query_getSubpodr) >= 1) { 
						while ($row_getSubpodr = mysqli_fetch_array($query_getSubpodr, MYSQLI_ASSOC)) { 
?>
				<tr>
					<td class="docview-details-tab6-numberstage text-center"></td>
					<td class="docview-details-tab6-dateplan text-left"><?php echo $row_getSubpodr['namesubpodrshot']; ?></td>
					<td class="docview-details-tab6-namestage text-left"><?php echo ($row_getDocsubpodr['numberdocsubpodr'])<>"" ? $row_getDocsubpodr['numberdocsubpodr'] : "Не указано"; ?></td>
					<td class="docview-details-tab6-namestage text-left"><?php echo ($row_getDocsubpodr['namedocsubpodr'])<>"" ? $row_getDocsubpodr['namedocsubpodr'] : "Не указано"; ?></td>
					<td class="docview-details-tab6-summastage text-right"><?php echo number_format((float)($row_getDocsubpodr['sumdocsubpodr']), 2, '.', ' ').$__dened; ?></td>
				</tr>
<?php
								}
							}
					}
				}
		}
		if ($cntDocsubpodr == 0) {
?>
				<tr>
					<td colspan="5" class="docview-details-tab6-message text-center">Договоров субподряда не заключалось...</td>
				</tr>
<?php
		}
	}
	else {
?>		
				<tr>
					<td colspan="5" class="docview-details-tab6-message text-center">У договора нет этапов</td>
				</tr>
<?php
	}
?>			
			</tbody>
		</table>

<?php // ----- ----- ----- ----- ----- ?>

		<div class="space50"></div>
		<h3 class="docview-details-tab6-title">Авансовые платежи субподрядчикам</h3>
		<table id="docview-details-tab6-avans" class="table" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th class="text-center">Этап</th>
					<th class="text-center"></th>
					<th class="text-center">Дата аванса</th>
					<th class="text-center"></th>
					<th class="text-center">Сумма аванса</th>
					<th class="text-center">Зачтено</th>
					<th class="text-center">Остаток</th>
				</tr>
			</thead>
			<tbody>
<?php
	$query_getKalplan = mysqlQuery( "SELECT kodkalplan, numberstage, nameshotstage, dateplan, summastage FROM dognet_dockalplan WHERE koddoc = ".$varKoddoc." AND koddel <> '99'" );
	if (mysqli_num_rows($query_getKalplan) >= 1) { 
		$cntDocsubpodr = 0;
		while ($row_getKalplan = mysqli_fetch_array($query_getKalplan, MYSQLI_ASSOC)) { 
			$kodkalplan = $row_getKalplan['kodkalplan'];
			// Получаем информацию о договоре субподряда
			$query_getDocSubpodr = mysqlQuery( "SELECT * FROM dognet_docsubpodr WHERE koddoc = ".$kodkalplan." AND koddel <> '99'" );
			if (mysqli_num_rows($query_getDocsubpodr) >= 1) { 
?>
				<tr style="background-color:#f7f7f7; color:#111">
					<td class="docview-details-tab5-avans-numberstage text-center" style="font-size:1.0em; font-weight:700"><?php echo $row_getKalplan['numberstage']; ?></td>
					<td colspan="6" class="docview-details-tab5-namestage text-left" style="font-size:1.0em; font-weight:700"><?php echo $row_getKalplan['nameshotstage']; ?></td>
				</tr>
<?php
				while ($row_getDocSubpodr = mysqli_fetch_array($query_getDocSubpodr, MYSQLI_ASSOC)) { 
					$koddocsubpodr = $row_getDocSubpodr['koddocsubpodr'];
					$cntDocsubpodr++;
?>
				<tr>
					<td class="docview-details-tab6-ChetfSubpodr-numberstage text-center"></td>
					<td colspan="2" class="docview-details-tab5-avans-namestage text-left">Договор субподряда №<?php echo $row_getDocSubpodr['numberdocsubpodr']; ?></td>
					<td colspan="3" class="docview-details-tab5-namestage text-left"></td>
				</tr>
<?php
					$query_getDocAvSubpodr = mysqlQuery( "SELECT * FROM dognet_docavsubpodr WHERE koddocsubpodr = ".$koddocsubpodr." AND koddel <> '99'" );
					if (mysqli_num_rows($query_getDocAvSubpodr) >= 1) { 
						while ($row_getDocAvSubpodr = mysqli_fetch_array($query_getDocAvSubpodr, MYSQLI_ASSOC)) { 
							$kodavsubpodr = $row_getDocAvSubpodr['kodavsubpodr'];
?>
				<tr>
					<td class="docview-details-tab6-avans-numberstage text-center"></td>
					<td class="docview-details-tab6-avans-numberstage text-center"></td>
					<td class="docview-details-tab6-avans-dateplan text-left"><?php echo $row_getDocAvSubpodr['dateavsubpodr']; ?></td>
					<td class="docview-details-tab6-avans-summastage text-right"></td>
					<td class="docview-details-tab6-avans-summastage text-right"><?php echo number_format((float)($row_getDocAvSubpodr['summaavsubpodr']), 2, '.', ' ').$__dened; ?></td>
					<td class="docview-details-tab6-avans-summastage text-right"></td>
					<td class="docview-details-tab6-avans-summastage text-right"></td>
				</tr>
<?php
						}
					}
					else { 
?>
				<tr>
					<td class="text-center"></td>
					<td class="text-center"></td>
					<td colspan="5" class="docview-details-tab6 text-left text-danger">Авансовых платежей по договору не проводилось...</td>
				</tr> 
<?php
					}
				}
			}
		}
		if ($cntDocsubpodr == 0) { 
?>
				<tr>
					<td colspan="7" class="docview-details-tab6-message text-center">Договоров субподряда не заключалось...</td>
				</tr>
<?php
		}
	}
	else {
?>		
				<tr>
					<td colspan="7" class="docview-details-tab6-message text-center">У договора нет этапов</td>
				</tr>
<?php
	}
?>			
			</tbody>
		</table>

<?php // ----- ----- ----- ----- ----- ?>

<?php
	$query_getKalplan = mysqlQuery( "SELECT kodkalplan, numberstage, nameshotstage, dateplan, summastage FROM dognet_dockalplan WHERE koddoc = ".$varKoddoc." AND koddel <> '99'" );
	if ($query_getKalplan) { 
?>
		<div class="space50"></div>
		<h3 class="docview-details-tab6-title">Cчета-фактуры субподрядчиков</h3>
		<table id="docview-details-tab6-ChetfSubpodr" class="table" cellspacing="0" width="100%">
			<thead>
				<tr>
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
		while ($row_getKalplan = mysqli_fetch_array($query_getKalplan, MYSQLI_ASSOC)) { 
			$kodkalplan = $row_getKalplan['kodkalplan'];
?>
				<tr style="background-color:#f7f7f7; color:#111">
					<td class="docview-details-tab5-avans-numberstage text-center" style="font-size:1.0em; font-weight:700"><?php echo $row_getKalplan['numberstage']; ?></td>
					<td colspan="6" class="docview-details-tab5-namestage text-left" style="font-size:1.0em; font-weight:700"><?php echo $row_getKalplan['nameshotstage']; ?></td>
				</tr>
<?php
			$query_getDocSubpodr = mysqlQuery( "SELECT * FROM dognet_docsubpodr WHERE koddoc = ".$kodkalplan." AND koddel <> '99'" );
			if ($query_getDocSubpodr) { 
				while ($row_getDocSubpodr = mysqli_fetch_array($query_getDocSubpodr, MYSQLI_ASSOC)) { 
					$koddocsubpodr = $row_getDocSubpodr['koddocsubpodr'];
?>
				<tr>
					<td class="docview-details-tab6-ChetfSubpodr-numberstage text-center"></td>
					<td colspan="2" class="docview-details-tab5-avans-namestage text-left">Договор субподряда №<?php echo $row_getDocSubpodr['numberdocsubpodr']; ?></td>
					<td colspan="3" class="docview-details-tab5-namestage text-left"></td>
				</tr>
<?php
					$query_getChetf = mysqlQuery( "SELECT * FROM dognet_docchfsubpodr WHERE koddocsubpodr = ".$koddocsubpodr." AND koddel <> '99'" );
					if ($query_getChetf) { 
						while ($row_getChetf = mysqli_fetch_array($query_getChetf, MYSQLI_ASSOC)) { 
							$kodchfact = $row_getChetf['kodchfsubpodr'];
?>
				<tr>
					<td class="docview-details-tab6-ChetfSubpodr-numberstage text-center">СФ</td>
					<td class="docview-details-tab6-ChetfSubpodr-numberstage text-center"><?php echo $row_getChetf['numberchfsubpodr']; ?></td>
					<td class="docview-details-tab6-ChetfSubpodr-dateplan text-left"><?php echo $row_getChetf['datechfsubpodr']; ?></td>
					<td class="docview-details-tab6-ChetfSubpodr-summastage text-right"><?php echo number_format((float)($row_getChetf['sumchfsubpodr']), 2, '.', ' ').$__dened; ?></td>
					<td class="docview-details-tab6-ChetfSubpodr-summastage text-right"></td>
					<td class="docview-details-tab6-ChetfSubpodr-summastage text-right"></td>
					<td class="docview-details-tab6-ChetfSubpodr-summastage text-right"></td>
				</tr>
<?php
// В таблице dognet_oplatachf находим все оплаченные счета-фактуры с кодом kodchfact и суммируем
							$query_getOplatachf = mysqlQuery( "SELECT * FROM dognet_docoplchfsubpodr WHERE kodchfsubpodr =".$kodchfact." AND koddel <> '99'" );
							while ($row_getOplatachf = mysqli_fetch_array($query_getOplatachf, MYSQLI_ASSOC)) { 
?>
				<tr>
					<td></td>
					<td></td>
					<td class="docview-details-tab6-namestage text-left">Оплата от <?php echo $row_getOplatachf['dateoplchfsubpodr']; ?></td>
					<td></td>
					<td class="docview-details-tab6-ChetfSubpodr-summastage text-right"><?php echo number_format((float)($row_getOplatachf['sumoplchfsubpodr']), 2, '.', ' ').$__dened; ?></td>
					<td colspan="2"></td>
				</tr>
<?php
							} // while ($row_getOplatachf)
						} // while ($row_getChetf)
					} // if ($query_getChetf)
				} // while ($row_getDocSubpodr)
			} // if ($query_getDocSubpodr)
		} // if ($row_getKalplan)
?>
			</tbody>
		</table>
<?php
	} // if ($query_getKalplan)
}
?>
	</div>

</section>
