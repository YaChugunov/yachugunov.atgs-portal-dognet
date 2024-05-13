<?php
date_default_timezone_set('Europe/Moscow');

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$__title = 'Договор';
$__subtitle = "Отчетные формы";
$__subsubtitle = "Задолженность по субподрядчикам / на дату";
$ondate = "";

if (isset($_POST['update_data']) && isset($_POST['ondate']) && !empty($_POST['ondate'])) {
	$ondate = date('Y-m-d', strtotime($_POST['ondate']));

	// Делаем запись в системный лог
	// Все параметры в таблице portal_log_messages
	PORTAL_SYSLOG('99942100', '0000000', null, $_GET['reportview'], $__subsubtitle, null);

	#
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	# Функция формирования вспомогательной таблицы данных
	# для справки о задолженности по субподрядчикам (dognet_docchfsubpodr_zadol)
	#
	# В таблице содержатся все авансовые платежи и оплаты по каждому счету-фактуре
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	#
	$_QRY0 = mysqlQuery("TRUNCATE TABLE dognet_reports_zadolsub_ondate_chfincoming");
	$_QRY = mysqlQuery("SELECT * FROM dognet_docchfsubpodr WHERE koddel <> '99' AND datechfsubpodr <= '" . $ondate . "'");
	$chf_koddocsubpodr = '';
	$_ENBL = FALSE;
	while ($_ROW = mysqli_fetch_assoc($_QRY)) {

		// Находим все оплаты по счету-фактуре (kodchfsubpodr)
		$_QRY_1 = mysqlQuery("SELECT * FROM dognet_docoplchfsubpodr WHERE kodchfsubpodr=" . $_ROW['kodchfsubpodr'] . " AND koddel <> '99'");
		// Сохраняем код счета-фактуры
		$subchf_kod = $_ROW['kodchfsubpodr'];
		// Пробегаемся по всем оплатам
		$flag1 = 1;
		if (mysqli_num_rows($_QRY_1) > 0) {
			while ($_ROW_1 = mysqli_fetch_assoc($_QRY_1)) {
				// Сохраняем код оплаты
				$subchf_kodopl = $_ROW_1['kodoplchfsubpodr'];
				// Сохраняем дату оплаты
				$subchf_dateopl = $_ROW_1['dateoplchfsubpodr'];
				// Сохраняем сумму оплаты
				$subchf_sumopl = $_ROW_1['sumoplchfsubpodr'];
				// Формируем и сохраняем строку с выбранными данными
				// Тип операции 1 (для оплаты) и 2 (для аванса)
				$subchf_type = "1";

				$_QRY_INSERT = mysqlQuery(" INSERT INTO dognet_reports_zadolsub_ondate_chfincoming (kodchfsubpodr, type_incoming, kod_incoming, date_incoming, sum_incoming, flag_1) VALUES ('$subchf_kod', '$subchf_type', '$subchf_kodopl', '$subchf_dateopl', '$subchf_sumopl', '$flag1') ");
				$flag1 = 0;
			}
		} else {
			// Сохраняем код оплаты
			$subchf_kodopl = "";
			// Сохраняем дату оплаты
			$subchf_dateopl = "";
			// Сохраняем сумму оплаты
			$subchf_sumopl = "0.00";
			// Формируем и сохраняем строку с выбранными данными
			// Тип операции 1 (для оплаты) и 2 (для аванса)
			$subchf_type = "-1";

			$_QRY_INSERT = mysqlQuery(" INSERT INTO dognet_reports_zadolsub_ondate_chfincoming (kodchfsubpodr, type_incoming, kod_incoming, date_incoming, sum_incoming, flag_1) VALUES ('$subchf_kod', '$subchf_type', '$subchf_kodopl', NULL, '$subchf_sumopl', '$flag1') ");
			$flag1 = 0;
		}


		// Находим все зачтенные авансовые платежи по счету-фактуре (kodchfsubpodr)
		$_QRY_2 = mysqlQuery("SELECT * FROM dognet_docavsubpodr WHERE kodchfsubpodr=" . $_ROW['kodchfsubpodr'] . " AND koddel <> '99'");


		if (mysqli_num_rows($_QRY_2) > 0) {
			// Пробегаемся по всем авансам
			while ($_ROW_2 = mysqli_fetch_assoc($_QRY_2)) {
				// Сохраняем код аванса
				$subchf_kodav = $_ROW_2['kodavsubpodr'];
				// Сохраняем дату аванса
				$subchf_dateav = $_ROW_2['dateavsubpodr'];
				// Сохраняем сумму аванса
				$subchf_sumav = $_ROW_2['sumavsubpodr'];
				// Формируем и сохраняем строку с выбранными данными
				// Тип операции 1 (для оплаты) и 2 (для аванса)
				$subchf_type = "2";

				$_QRY_INSERT = mysqlQuery(" INSERT INTO dognet_reports_zadolsub_ondate_chfincoming (kodchfsubpodr, type_incoming, kod_incoming, date_incoming, sum_incoming, flag_1) VALUES ('$subchf_kod', '$subchf_type', '$subchf_kodav', '$subchf_dateav', '$subchf_sumav', '$flag1') ");
				$flag1 = 0;
			}
		} else {
			// Сохраняем код аванса
			$subchf_kodav = "";
			// Сохраняем дату аванса
			$subchf_dateav = "";
			// Сохраняем сумму аванса
			$subchf_sumav = "0.00";
			// Формируем и сохраняем строку с выбранными данными
			// Тип операции 1 (для оплаты) и 2 (для аванса)
			$subchf_type = "-2";

			$_QRY_INSERT = mysqlQuery(" INSERT INTO dognet_reports_zadolsub_ondate_chfincoming (kodchfsubpodr, type_incoming, kod_incoming, date_incoming, sum_incoming, flag_1) VALUES ('$subchf_kod', '$subchf_type', '$subchf_kodav', NULL, '$subchf_sumav', '$flag1') ");
			$flag1 = 0;
		}
	}
	$_LOG_UPDATE = mysqlQuery("UPDATE dognet_log_updates_table SET table_update='" . $ondate . "' WHERE table_name='dognet_reports_zadolsub_ondate'");
	#
	#
}
?>

<script type="text/javascript"
  src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/moment-with-locales.js"></script>
<link rel="stylesheet"
  href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/_bootstrap-css/bootstrap-datetimepicker.css" />
<script type="text/javascript"
  src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/_bootstrap-js/bootstrap-datetimepicker.js"></script>

<link rel="stylesheet"
  href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/report/report-details/css/reports-spravka-zadolsub.css">

<div class="container">
  <div class="row common-top-block">
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/dognet-topblock.php") ?>
  </div>
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
      <div class="" style="margin-bottom:5px">
        <form class="form-inline" method="POST" action="">
          <div class="form-group">
            <?php
						$_QRY = mysqlQuery("SELECT table_update FROM dognet_log_updates_table WHERE table_name='dognet_reports_zadolsub_ondate'");
						$_ROW = mysqli_fetch_assoc($_QRY);
						$_ZDL_ONDATE = date('d.m.Y', strtotime($_ROW['table_update']));
						echo "<span class='update-timestamp-label' style='padding:10px 5px 9px'>" . $_ZDL_ONDATE . "</span>";
						?>
          </div>
          <div class="form-group">
            <span><button class="text-uppercase" style="font-size:0.9em; height:34px" type="submit"
                name="update_data">Обновить данные</button></span>
          </div>
          <div class="form-group" style="float:right">
            <div class='input-group date' id='ondate'>
              <input type='text' name="ondate" id='ondate' class="form-control" />
              <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
              </span>
            </div>
          </div>
        </form>
      </div>
      <div id="main-tabs">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12">
            <ul id="main-tabs-menu" class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#tab-1" title="">Общая сводка</a></li>
              <li><a data-toggle="tab" href="#tab-2" title="">Субподрядчики</a></li>
              <li style="float:right"><a
                  href="?reportview=zadolsub_ondate&export=yes&format=&ondate=<?php echo $_ZDL_ONDATE; ?>"
                  title="">Экспорт</a></li>
            </ul>
            <div class="tab-content">
              <div id="tab-1" class="tab-pane fade in active">
                <?php include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_5/reports/spravka/zadolsub_ondate/dognet-report-reportview(restr_5)-spravka-zadolsub_ondate_common.php"); ?>
              </div>
              <div id="tab-2" class="tab-pane fade">
                <p>Онлайн-отчет отключен. Пользуйтесь функцией экспорта.</p>
                <?php // include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_5/reports/spravka/zadolsub_ondate/dognet-report-reportview(restr_5)-spravka-zadolsub_ondate_docs.php"); 
								?>
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
ondate = '<?php echo $_ZDL_ONDATE; ?>';
document.getElementById("subtitle").innerHTML = subtitle;
document.getElementById("dognet-subsubtitle").innerHTML = subsubtitle;
$("#dognet-subsubtitle").attr("class", "text-default");

$(function() {
  $('#ondate').datetimepicker({
    locale: 'ru',
    format: 'DD.MM.YYYY',
    defaultDate: moment(ondate, 'DD.MM.YYYY')
  });

});
</script>