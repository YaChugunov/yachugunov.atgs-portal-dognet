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
# ID ПОЛЬЗОВАТЕЛЯ
	$__USERID = $_SESSION['id'];

#	$__USERID = '1052'; // Щукин
#	$__USERID = '1105'; // Лавров
#	$__USERID = '1043'; // Тимофеев
#	$__USERID = '1037'; // Зельдин
#
# ИНТЕРВАЛ ДЕДЛАЙНА
	$__DATEDIFF = 180;
# ----- ----- ----- ----- -----

$__DATENOW = date("Y-m-d H:i:s");

// ОПРЕДЕЛЯЕМ KODISPOL ГИПА ПО ЕГО ID


$_QRY_KODISPOL = mysqlQuery("SELECT * FROM dognet_users_kods WHERE id='".$__USERID."'");
// 	$_QRY_KODISPOL = mysqlQuery("SELECT * FROM dognet_users_kods WHERE id='1052'"); // Щукин
// 	$_QRY_KODISPOL = mysqlQuery("SELECT * FROM dognet_users_kods WHERE id='1105'"); // Лавров
// 	$_QRY_KODISPOL = mysqlQuery("SELECT * FROM dognet_users_kods WHERE id='1043'"); // Тимофеев
// 	$_QRY_KODISPOL = mysqlQuery("SELECT * FROM dognet_users_kods WHERE id='1037'"); // Зельдин
	$_ROW_KODISPOL = mysqli_fetch_assoc($_QRY_KODISPOL);
	$__KODISPOL = $_ROW_KODISPOL['kodispol'];
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
?>
<style>
div.gip-greeting-block { text-align:center }
div.gip-message-block { text-align:center }
div.gip-message-admin-block {  }
h3.gip-greeting-title {
    color: #31708f;
    font-family: 'Oswald', sans-serif;
    font-weight: 400;
    font-size: 2.0em;
    text-transform: uppercase;
}
div.gip-greeting-message > span {
    color: #333;
    font-family: 'Oswald', sans-serif;
    font-weight: 300;
    font-size: 1.3em;
    text-transform: uppercase;
}
div.gip-message-text > span {
    font-family: 'HeliosCond', sans-serif;
    font-weight: 300;
    font-size: 1.2em;
    text-transform: uppercase;
}
div.gip-message-admin-text > span {
		color: #999;
    font-family: 'HeliosCond', sans-serif;
    font-weight: 300;
    font-size: 1.0em;
    font-style: italic;
}
#admin-anounce .block h3.section-title { color:#999; font-family:'Oswald', sans-serif; font-size:2.0em; font-weight:400; text-transform:uppercase; letter-spacing:0.0em }
/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----

ТАБЛИЦА "СВОДКА ПО СЧЕТАМ-ФАКТУРАМ"

----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
/*
/* Общее для таблицы */
#gip-doc-deadlines {  }
#gip-doc-deadlines .details-control:hover { cursor:pointer }
#gip-doc-deadlines .font-courier { font-family:courier,courier new,serif }
/*
/*
/* Заголовок таблицы */
#gip-doc-deadlines > thead {	color:#111; font-family:'Oswald', sans-serif; border-bottom:none;	border-top:none }
#gip-doc-deadlines > thead > tr > th { background-color:#f0f0f0; color:#111; border-bottom:none; font-weight:500; text-transform:uppercase }
/*
/*
/* Тело таблицы */
#gip-doc-deadlines > tbody > tr > td {
	font-family:'Play', sans-serif;
	font-size:0.9em;
	padding: 2px 5px;
	line-height: 1.42857143;
	vertical-align: middle
}
#gip-doc-deadlines > thead > tr > th:first-child, #gip-doc-deadlines > tbody > tr > td:first-child { width:36px; text-align:center }
#gip-doc-deadlines > thead > tr > th:nth-child(2), #gip-doc-deadlines > tbody > tr > td:nth-child(2) { width:5%; text-align:center }
#gip-doc-deadlines > thead > tr > th:nth-child(3), #gip-doc-deadlines > tbody > tr > td:nth-child(3) { width:5%; text-align:center }
#gip-doc-deadlines > thead > tr > th:nth-child(4) { text-align:left }
#gip-doc-deadlines > tbody > tr > td:nth-child(4) { text-align:left }
#gip-doc-deadlines > thead > tr > th:nth-child(5), #gip-doc-deadlines > tbody > tr > td:nth-child(5) { width:15%; text-align:center }
#gip-doc-deadlines > thead > tr > th:nth-child(6), #gip-doc-deadlines > tbody > tr > td:nth-child(6) { width:15%; text-align:center }
#gip-doc-deadlines > thead > tr > th:nth-child(7), #gip-doc-deadlines > tbody > tr > td:nth-child(7) { width:15%; text-align:center }
#gip-doc-deadlines > thead > tr > th:nth-child(8), #gip-doc-deadlines > tbody > tr > td:nth-child(8) { width:15%; text-align:center }
#gip-doc-deadlines > tbody > tr > td.dataTables_empty { text-align:center; border-bottom:1px #951402 solid; border-top:1px #951402 solid; text-transform:uppercase; font-style:italic; color:#951402 }
#gip-doc-deadlines > tbody > tr.shown > td { background-color:#336a86; color:#fff; font-weight:300 }
#gip-doc-deadlines-avans > tbody > tr > td.gip-doc-deadlines-avans-collapse { padding:0 }
/*
/*
/* Подвал таблицы */
#gip-doc-deadlines > tfoot {	color:#111; font-family:'Oswald', sans-serif; border-bottom:none;	border-top:none }
#gip-doc-deadlines > tfoot > tr > th { border-bottom:none; font-weight:500; font-size:1.3em; text-transform:uppercase }
#gip-doc-deadlines > tfoot > tr > th.gip-doc-deadlines-summastage { text-align:right; text-transform:none }

#gip-doc-deadlines > tbody > tr > td.gip-doc-deadlines-collapse { padding:0 }


</style>


	<div class="space30"></div>
	<div id="gip-greeting" class="">
		<div class="row gip-greeting-block">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 space30">
				<h3 class="gip-greeting-title space10 text-success">Приветствую, <?php echo $_SESSION['firstname']; ?>!</h3>
<?php
if (checkIsItGIP($_SESSION['id'])==1) {
?>
				<div class="gip-greeting-message">
					<span>Вы - ГИП. Ниже вы найдете информацию, которая может быть для вас полезной</span>
				</div>
<?php
}
?>
			</div>
		</div>
	</div>
<?php
if (checkIsItGIP($_SESSION['id'])==1) {
if ($__KODISPOL != "") {
?>
<?php
	$_QRY_GIP_DOCS = mysqlQuery("
		SELECT koddoc, docnumber, kodshab FROM dognet_docbase
		WHERE koddel<>'99'
		AND kodstatus='245381842747296'
		AND docnozak > '0.00'
		AND kodispol=".$__KODISPOL);
?>
	<div id="admin-anounce" class="">
		<div class="row admin-anounce-block">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 space20">
				<div class="block text-center">
					<h3 class="section-title space20">Ваши договора/этапы, по которым не закрыто выполнение</h3>
<?php
if (mysqli_num_rows($_QRY_GIP_DOCS)>0) {
?>
		<table id="gip-doc-deadlines" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
					<th class="text-center">Договор</th>
					<th class="text-center">Этап</th>
					<th class="text-center">Название этапа</th>
					<th class="text-center">Срок выполнения</th>
					<th class="text-center">Осталось/Просрочено</th>
					<th class="text-center">Сумма незакрытия</th>
				</tr>
			</thead>
			<tbody>
<?php
	while($_ROW_GIP_DOCS = mysqli_fetch_assoc($_QRY_GIP_DOCS)) {
		$_QRY_GIP_STAGES = mysqlQuery("
			SELECT * FROM dognet_dockalplan
			WHERE koddel<>'99'
			AND koddoc=".$_ROW_GIP_DOCS['koddoc']);
		while($_ROW_GIP_STAGES = mysqli_fetch_assoc($_QRY_GIP_STAGES)) {
			if ($_ROW_GIP_STAGES['idsrokstage']==1) {
				if (!empty($_ROW_GIP_STAGES['srokstage_date'])) {
					$__DATESROK = $_ROW_GIP_STAGES['srokstage_date'];
				}
				elseif (!empty($_ROW_GIP_STAGES['dateplan'])) {
					$__DATESROK = $_ROW_GIP_STAGES['dateplan'];
				}
			}
			elseif ($_ROW_GIP_STAGES['idsrokstage']!=1) {
				if ($_ROW_GIP_DOCS['kodshab']==1 || $_ROW_GIP_DOCS['kodshab']==3) {
					$_QRY_GIP_AVANS = mysqlQuery("SELECT MIN(dateavans) as mindateavans FROM dognet_docavans WHERE koddel<>'99' AND koddoc=".$_ROW_GIP_STAGES['kodkalplan']);
					$_ROW_GIP_AVANS = mysqli_fetch_assoc($_QRY_GIP_AVANS);
					if ($_QRY_GIP_AVANS!=NULL) {
						$dateavans = new DateTime($_ROW_GIP_AVANS['mindateavans']);
					// Нужно теперь определить срок выполнения этапа (если он был задан в днях)
						$srokstage = $_ROW_GIP_STAGES['srokstage'];
						$dateavans->add(new DateInterval('P'.$srokstage.'D'));
						$__DATESROK = $dateavans->format('Y-m-d');
					}
					else {
						$__DATESROK = $dateavans->format('2100-12-31');
					}
				}
				else {
					$_QRY_GIP_AVANS = mysqlQuery("SELECT MIN(dateavans) as mindateavans FROM dognet_docavans WHERE koddel<>'99' AND koddoc=".$_ROW_GIP_DOCS['koddoc']);
					$_ROW_GIP_AVANS = mysqli_fetch_assoc($_QRY_GIP_AVANS);
					if ($_QRY_GIP_AVANS!=NULL) {
						$dateavans = new DateTime($_ROW_GIP_AVANS['mindateavans']);
					// Нужно теперь определить срок выполнения этапа (если он был задан в днях)
						$srokstage = $_ROW_GIP_STAGES['srokstage'];
						$dateavans->add(new DateInterval('P'.$srokstage.'D'));
						$__DATESROK = $dateavans->format('Y-m-d');
					}
					else {
						$__DATESROK = $dateavans->format('2100-12-31');
					}
				}
			}
			$datetime1 = new DateTime(date("Y-m-d"));
			$datetime2 = new DateTime($__DATESROK);
			$int1 = strtotime($__DATESROK) - strtotime(date("Y-m-d"));
			$int1 = round($int1 / 3600 / 24);
			$int2 = $datetime1->diff($datetime2);
			$int2->format("%d");
			$diff = $int2->format('%R%a дней');
			if ($int1 < $__DATEDIFF && StageZadolg($_ROW_GIP_STAGES['kodkalplan']) > 0.00) {
?>
				<tr>
					<td class=""></td>
					<td class=""><?php echo $_ROW_GIP_DOCS['docnumber']; ?></td>
					<td class=""><?php echo $_ROW_GIP_STAGES['numberstage']; ?></td>
					<td class=""><?php echo $_ROW_GIP_STAGES['nameshotstage']; ?></td>
					<td class=""><?php echo date("d.m.Y", strtotime($__DATESROK)); ?></td>
					<td class=""><?php echo $diff; ?></td>
					<td class=""><?php echo number_format((float)(StageZadolg($_ROW_GIP_STAGES['kodkalplan'])), 2, '.', ' ')." руб."; ?></td>
				</tr>
<?php
			}
		}
	}
?>
			</tbody>
		</table>
<?php
}
else {
?>
				</div>
			</div>
		</div>
	</div>
	<div id="gip-message" class="">
		<div class="row gip-message-block">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 space30">
				<div class="gip-message-text text-danger">
					<span>Похоже с выполнением у вас все хорошо</span>
				</div>
			</div>
		</div>
		<div class="row gip-message-admin-block text-left">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 space30">
				<div class="gip-message-admin-text">
					<span>* Раздел в стадии отладки. Работает в тестовом режиме.</span>
				</div>
			</div>
		</div>
	</div>
<?php
}
}
}
?>
