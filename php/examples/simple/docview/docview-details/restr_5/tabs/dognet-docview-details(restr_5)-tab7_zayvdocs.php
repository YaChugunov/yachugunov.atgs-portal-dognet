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

ОСНОВНАЯ ТАБЛИЦА

----- ----- ----- ----- ----- ----- ----- ----- ----- -----  
*/
/* 
/* Общее для таблицы */
#docview-details-tab7 {  }
#docview-details-tab7 .details-control:hover { cursor:hand }
.docview-details-tab7-title { color:#111; font-family:'Oswald', sans-serif; font-size:1.7em; font-weight:300; margin-bottom:20px; letter-spacing:0.3em }
/* 
/* 
/* Заголовок таблицы */
#docview-details-tab7 > thead { /* display:none */ }
#docview-details-tab7 > thead {	background-color:#f1f1f1;	color:#111; font-family:'Oswald', sans-serif; border-bottom:none;	border-top:none }
#docview-details-tab7 > thead > tr > th { color:#333; border-bottom:none; font-weight:500; font-size:1.3em; text-transform:uppercase }
#docview-details-tab7 > thead > tr > th:first-child { background-color:#f0f0f0; width:36px; text-align:center }
#docview-details-tab7 > thead > tr > th:nth-child(2) { background-color:#f0f0f0; border-left: 2px #fff solid; width:10%; text-align:left }
#docview-details-tab7 > thead > tr > th:nth-child(3) { background-color:#f0f0f0; border-left: 2px #fff solid; width:5%; text-align:center  }
#docview-details-tab7 > thead > tr > th:nth-child(4) { background-color:#f0f0f0; border-left: 2px #fff solid; text-align:left  }
#docview-details-tab7 > thead > tr > th:nth-child(5) { background-color:#f0f0f0; border-left: 2px #fff solid; width:15%; text-align:left  }
#docview-details-tab7 > thead > tr > th:nth-child(6) { background-color:#f0f0f0; border-left: 2px #fff solid; width:15%; text-align:left  }
#docview-details-tab7 > thead > tr > th:nth-child(7) { background-color:#f0f0f0; border-left: 2px #fff solid; width:15%; text-align:left  }
/* 
/* 
/* Тело таблицы */
#docview-details-tab7 > tbody {	font-family:courier,courier new,serif; color:#333; border-bottom:none;	border-top:none }
#docview-details-tab7 > tbody > tr > td { border-bottom:none; padding: 5px 8px; line-height: 1.42857143; vertical-align: middle }

#docview-details-tab7 > tbody > tr > td:first-child { width:36px; text-align:center }
#docview-details-tab7 > tbody > tr > td:nth-child(2) { width:10%; text-align:left }
#docview-details-tab7 > tbody > tr > td:nth-child(3) { width:5%; text-align:center }
#docview-details-tab7 > tbody > tr > td:nth-child(4) { text-align:left }
#docview-details-tab7 > tbody > tr > td:nth-child(5) { width:15%; text-align:left }
#docview-details-tab7 > tbody > tr > td:nth-child(6) { width:15%; text-align:left }
#docview-details-tab7 > tbody > tr > td:nth-child(7) { width:15%; text-align:left }

#docview-details-tab7 > tbody > tr > td.dataTables_empty { text-align:center; border-bottom:1px #951402 solid; border-top:1px #951402 solid; text-transform:uppercase; font-style:italic; color:#951402 }
#docview-details-tab7 > tbody > tr > td.docview-details-tab7-id { font-weight:300; font-size:1.3em; text-transform:uppercase; text-align:left; border-left: 5px #336a86 solid }
#docview-details-tab7 > tbody > tr > td.docview-details-tab7-zayvtel { font-weight:300; font-size:1.3em; text-transform:none }
#docview-details-tab7 > tbody > tr > td.docview-details-tab7-zayvnum { font-weight:300; font-size:1.3em; text-transform:none }
#docview-details-tab7 > tbody > tr > td.docview-details-tab7-zayvdesc { font-weight:300; font-size:1.3em; text-transform:none }
#docview-details-tab7 > tbody > tr > td { border-top:none }
#docview-details-tab7 > tbody > tr.shown > td { background-color:#336a86; color:#fff; font-weight:300 }
#docview-details-tab7 > tbody > tr > td a.zayv-link { text-decoration:underline; color:#336a86 }
#docview-details-tab7 > tbody > tr > td a.zayv-link:hover { text-decoration:none }

#docview-details-tab7 > tbody > tr > td.docview-details-tab7-zayvdocs-collapse { padding:0 }
/* 
/* 
/* Подвал таблицы */

/* 
/* 
----- ----- ----- ----- ----- ----- ----- ----- ----- -----  

ТАБЛИЦА "СЧЕТА COLLAPSE"

----- ----- ----- ----- ----- ----- ----- ----- ----- -----  
*/
#docview-details-tab7-zayvdocs-collapse-table { margin-bottom:0 }
#docview-details-tab7-zayvdocs-collapse-table > tbody > tr > td { font-family:courier,courier new,serif; border-bottom:none; border-top:none }

#docview-details-tab7-zayvdocs-collapse-table > thead > tr > th, 
#docview-details-tab7-zayvdocs-collapse-table > tbody > tr > td { font-family:courier,courier new,serif; border-bottom:none; border-top:none }
#docview-details-tab7-zayvdocs-collapse-table > thead { color:#666; font-family:'Oswald', sans-serif; border-bottom:none; border-top:none }
#docview-details-tab7-zayvdocs-collapse-table > thead > tr > th:first-child { width:20%; text-align:left }
#docview-details-tab7-zayvdocs-collapse-table > thead > tr > th:nth-child(2) { width:7%; text-align:left }
#docview-details-tab7-zayvdocs-collapse-table > thead > tr > th:nth-child(3) { width:10%; text-align:left }
#docview-details-tab7-zayvdocs-collapse-table > thead > tr > th:nth-child(4) { width:15%; text-align:right }
#docview-details-tab7-zayvdocs-collapse-table > thead > tr > th:nth-child(5) { width:20%; text-align:right }
#docview-details-tab7-zayvdocs-collapse-table > thead > tr > th:nth-child(6) { width:7%; text-align:left }

#docview-details-tab7-zayvdocs-collapse-table > tbody > tr > td:first-child { width:20%; text-align:left }
#docview-details-tab7-zayvdocs-collapse-table > tbody > tr > td:nth-child(2) { width:7%; text-align:left }
#docview-details-tab7-zayvdocs-collapse-table > tbody > tr > td:nth-child(3) { width:10%; text-align:left }
#docview-details-tab7-zayvdocs-collapse-table > tbody > tr > td:nth-child(4) { width:15%; text-align:right }
#docview-details-tab7-zayvdocs-collapse-table > tbody > tr > td:nth-child(5) { width:20%; text-align:right }
#docview-details-tab7-zayvdocs-collapse-table > tbody > tr > td:nth-child(6) { width:7%; text-align:left }

#docview-details-tab7-zayvdocs-collapse-table > tfoot > tr > th:nth-child(3) { text-align:right; font-weight:700 }
#docview-details-tab7-zayvdocs-collapse-table > tfoot > tr > th:nth-child(4) { text-align:right; font-weight:700 }

#docview-details-tab7-zayvdocs-collapse-table > tbody > tr > td a.chet-link { text-decoration:underline; color:#336a86 }
#docview-details-tab7-zayvdocs-collapse-table > tbody > tr > td a.chet-link:hover { text-decoration:none }

#docview-details-tab7-message-table > thead > tr > th, #docview-details-tab7-message-table > tbody > tr > td { border-bottom:none; border-top:none }
.docview-details-tab7-message { font-family:'Oswald', sans-serif; font-size:1.3em; letter-spacing:0.2em }
</style>

<section>
	
	<div class="" style="padding-left:5px; padding-right:5px">
		<div class="space50"></div>
<?php
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
// СЧЕТА-ФАКТУРЫ
// :::
	$query_getDoczayv = mysqlQuery( "
	SELECT dognet_doczayv.numberzayv as numberzayv, dognet_doczayv.kodzayv as kodzayv, dognet_doczayv.namerabfilespec as namerabfilespec, dognet_spzayvtel.namezayvtelshot as namezayvtelshot, dognet_sptipzayv.namezayvshot as namezayvshot, dognet_spispol.ispolnameshot as ispolnameshot, dognet_doczayv.datezayv as datezayv, dognet_sptipzayvall.nametipzayvshotall as nametipzayvshotall
	FROM dognet_doczayv 
	LEFT JOIN dognet_sptipzayv ON dognet_doczayv.kodtipzayv = dognet_sptipzayv.kodtipzayv 
	LEFT JOIN dognet_sptipzayvall ON dognet_doczayv.kodtipzayvall = dognet_sptipzayvall.kodtipzayvall 
	LEFT JOIN dognet_spzayvtel ON dognet_doczayv.kodzayvtel = dognet_spzayvtel.kodzayvtel 
	LEFT JOIN dognet_spispol ON dognet_doczayv.kodispol = dognet_spispol.kodispol 
	WHERE dognet_doczayv.koddoc = ".$varKoddoc." AND dognet_doczayv.koddel <> '99'" );
	if (mysqli_num_rows($query_getDoczayv) >= 1) { 
		$cntChetf = 0;
?>
		<h3 class="docview-details-tab7-title">Заявки по договору</h3>
		<table id="docview-details-tab7" class="table" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th><span class='glyphicon glyphicon-option-vertical'></span></th>
					<th>ГРУППА</th>
					<th>№</th>
					<th>Описание</th>
					<th>Заявитель</th>
					<th>Исполнитель</th>
					<th>Дата заявки</th>
				</tr>
			</thead>
			<tbody>
<?php
		while ($row_getDoczayv = mysqli_fetch_array($query_getDoczayv, MYSQLI_ASSOC)) { 
			$kodzayv = $row_getDoczayv['kodzayv'];
?>
				<tr style="background-color:#f7f7f7; color:#111">
					<td class="docview-details-tab7"><a href="#tab7-zayvdocs-row-<?php echo $row_getDoczayv['kodzayv']; ?>" data-toggle="collapse"><span class='glyphicon glyphicon-option-vertical'></span></a></td>
					<td class="docview-details-tab7"><?php echo $row_getDoczayv['nametipzayvshotall']; ?></td>
					<td class="docview-details-tab7"><?php echo $row_getDoczayv['numberzayv']; ?></td>
					<td class="docview-details-tab7"><?php echo $row_getDoczayv['namerabfilespec']; ?></td>
					<td class="docview-details-tab7"><?php echo $row_getDoczayv['namezayvtelshot']; ?></td>
					<td class="docview-details-tab7"><?php echo $row_getDoczayv['ispolnameshot']; ?></td>
					<td class="docview-details-tab7"><?php echo $row_getDoczayv['datezayv']; ?></td>
				</tr>
<?php
			$query_getDoczayvfiles = mysqlQuery( "
			SELECT 
			* 
			FROM dognet_doczayv_files 
			WHERE dognet_doczayv_files.kodzayv = ".$kodzayv );
			if (mysqli_num_rows($query_getDoczayvfiles) >= 1) { 
?>
				<tr id="tab7-zayvdocs-row-<?php echo $row_getDoczayv['kodzayv']; ?>" class="collapse in">
					<td class="docview-details-tab7"></td>
					<td colspan="6" class="docview-details-tab7-zayvdocs-collapse">
						<table id="docview-details-tab7-zayvdocs-collapse-table" class="table" cellspacing="0" width="100%">
							<tbody>
<?php
				while ($row_getDoczayvfiles = mysqli_fetch_array($query_getDoczayvfiles, MYSQLI_ASSOC)) { 
?>
								<tr>
									<td><?php echo "<a href='".$row_getDoczayvfiles['file_url']."' class='chet-link' target='_blank'>".$row_getDoczayvfiles['file_originalname']."</a>"; ?></td>
								</tr>
<?php
				}
?>
							</tbody>
						</table>
					</td>
				</tr>
<?php
			}
		}
?>
			</tbody>
		</table>
<?php
	}
	else {
?>
		<table id="docview-details-tab7-message-table" class="table table-condensed" cellspacing="0" width="100%">
			<tbody>
				<tr>
					<td class="docview-details-tab7-message text-center text-danger">Заявок на обеспечение договора не найдено</td>
				</tr>
			</tbody>
		</table>
<?php
	}
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
?>
	</div>

</section>
	
