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

<div id="doc-details-tabs" class="doc-details-tabs" style="width:100%">
	<ul id="doc-details-tabs-menu" class="nav nav-tabs doc-details-tabs-menu">
		<li class="active"><a data-toggle="tab" href="#doc-details-tab2-1" title="">Выполнение</a></li>
		<li><a data-toggle="tab" href="#doc-details-tab2-2" title="">Авансы</a></li>
		<li><a data-toggle="tab" href="#doc-details-tab2-3" title="">Счета-фактуры</a></li>
	</ul>
	<div class="tab-content" style="padding:5px; width:100%">
		<div id="doc-details-tab2-1" class="tab-pane fade in active">
			<?php	include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/chetview/chetview-details/restr_3/tabs/dognet-chetview-details(restr_3)-tab2_progress.php"); ?>
		</div>
		<div id="doc-details-tab2-2" class="tab-pane fade">
			<?php	include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/chetview/chetview-details/restr_3/tabs/dognet-chetview-details(restr_3)-tab2_avans.php"); ?>
		</div>
		<div id="doc-details-tab2-3" class="tab-pane fade">
			<?php	include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/chetview/chetview-details/restr_3/tabs/dognet-chetview-details(restr_3)-tab2_chetf.php"); ?>
		</div>
	</div>
</div>
