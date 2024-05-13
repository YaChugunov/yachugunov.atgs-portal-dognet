<script type="text/javascript" language="javascript" class="init">
var reqField1 = {
    calcDateOpl: function(response1) {
        $('#ajaxResponseOut1').html(response1);
    }
};

//
function ajaxRequest_calcDateOpl(idsrokopl, chetfdate, kodchfact, srokopl, responseHandler) {
    var response1 = false;

    // Fire off the request to /form.php
    request1 = $.ajax({
        url: "php/examples/simple/report/report-details/restr_4/reports/spravka/zadolchf/php/ajaxRequest-report-details(restr_4)-isdaysoff_calc_opldate-fetch.php",
        type: "post",
        cache: false,
        data: {
            idsrokopl: idsrokopl,
            chetfdate: chetfdate,
            kodchfact: kodchfact,
            srokopl: srokopl
        },
        success: reqField1[responseHandler]
    });
    // Callback handler that will be called on success
    request1.done(function(response1, textStatus, jqXHR) {
        console.log("Ого! Работает! : " + response1);
        $('#' + kodchfact).html(response1);
    });
    // Callback handler that will be called on failure
    request1.fail(function(jqXHR, textStatus, errorThrown) {
        console.error(
            "The following error occurred: " +
            textStatus, errorThrown
        );
    });
    // Callback handler that will be called regardless
    // if the request failed or succeeded
    request1.always(function() {

    });

}
</script>

<?php
date_default_timezone_set('Europe/Moscow');

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$__title = 'Договор';
$__subtitle = "Отчетные формы";
$__subsubtitle = "Задолженность по счетам-фактурам / на дату";
$ondate = "";

if (isset($_POST['update_data']) && isset($_POST['ondate']) && !empty($_POST['ondate'])) {
	$ondate = date('Y-m-d', strtotime($_POST['ondate']));

	// Делаем запись в системный лог
	// Все параметры в таблице portal_log_messages
	PORTAL_SYSLOG('99942100', '0000000', null, $_GET['reportview'], $__subsubtitle, null);

	#
	#
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	# Функция формирования таблицы данных для справки о задолженности по счетам-фактурам (dognet_reports_zadolchf_ondate)
	#
	#
	$_QRY0 = mysqlQuery("TRUNCATE TABLE dognet_reports_zadolchf_ondate");
	$_QRY = mysqlQuery("SELECT * FROM dognet_kalplanchf WHERE koddel <> '99' AND chetfdate <= '" . $ondate . "'");
	$chf_koddoc = '';
	$chf_kodstatuszdl = '';
	$_ENBL = FALSE;
	while ($_ROW = mysqli_fetch_assoc($_QRY)) {

		$chf_sumAvChf = SUMMA_AVANSCHF_ONDATE($_ROW['kodchfact'], $ondate);
		$chf_sumOpChf = SUMMA_OPLATCHF_ONDATE($_ROW['kodchfact'], $ondate);
		$chf_summazadol = $_ROW['chetfsumma'] - ($chf_sumOpChf + $chf_sumAvChf);
		if (round($chf_summazadol, 2) > 0 or round($chf_summazadol, 2) < 0) {

			// Определяем ID договора (koddoc) для договора с календарным планом
			$_QRY_koddoc1 = mysqlQuery("SELECT koddoc, srokopl FROM dognet_dockalplan WHERE kodkalplan=" . $_ROW['kodkalplan'] . " AND koddel <> '99'");
			$_NUM1 = mysqli_num_rows($_QRY_koddoc1);
			$_ROW_koddoc1 = mysqli_fetch_assoc($_QRY_koddoc1);
			if ($_NUM1 > 0) {
				$chf_koddoc = $_ROW_koddoc1['koddoc'];
				if ($_ROW_koddoc1['srokopl'] == "ПКЗ") {
					$chf_chetfdateopl = "ПКЗ";
				} else {
					$chf_chetfdateopl = $_ROW['chetfdate'];
				}
				// Определяем статус задолженности по ID договора (koddoc)
				$_QRY_kodstatuszdl = mysqlQuery("SELECT kodstatuszdl FROM dognet_docbase WHERE koddoc=" . $chf_koddoc);
				$_ROW_kodstatuszdl = mysqli_fetch_assoc($_QRY_kodstatuszdl);
				if ($_ROW_kodstatuszdl['kodstatuszdl'] == '2' || $_ROW_kodstatuszdl['kodstatuszdl'] == '3') {
					$chf_kodstatuszdl = $_ROW_kodstatuszdl['kodstatuszdl'];
				} else {
					$chf_kodstatuszdl = '1';
				}
			}
			// Определяем ID договора (koddoc) для договора без календарного плана
			else {
				$_QRY_koddoc2 = mysqlQuery("SELECT koddoc, kodstatuszdl FROM dognet_docbase WHERE koddoc=" . $_ROW['kodkalplan']);
				$_ROW_koddoc2 = mysqli_fetch_assoc($_QRY_koddoc2);
				$chf_koddoc = $_ROW_koddoc2['koddoc'];
				if ($_ROW_koddoc2['kodstatuszdl'] == '2' || $_ROW_koddoc2['kodstatuszdl'] == '3') {
					$chf_kodstatuszdl = $_ROW_koddoc2['kodstatuszdl'];
				} else {
					$chf_kodstatuszdl = '1';
				}
				$chf_chetfdateopl = "";
			}
			// ----- ----- ----- ----- -----
			$chf_kodkalplan = $_ROW['kodkalplan'];
			$chf_kodchfact = $_ROW['kodchfact'];
			$chf_kodusechf = $_ROW['kodusechf'];
			$chf_koddel = $_ROW['koddel'];
			$chf_chetfnumber = $_ROW['chetfnumber'];
			$chf_chetfdate = $_ROW['chetfdate'];
			$chf_chetfsumma = $_ROW['chetfsumma'];
			$chf_summazadol = $chf_chetfsumma - ($chf_sumAvChf + $chf_sumOpChf);
			$chf_comment = "";
			// ----- ----- ----- ----- -----
			if ($chf_koddoc != "" && $chf_kodkalplan != "" && $chf_kodchfact != "") {
				$_QRY_INSERT = mysqlQuery(" INSERT INTO dognet_reports_zadolchf_ondate (koddoc, kodkalplan, kodchfact, kodusechf, koddel, chetfnumber, chetfdate, chetfdateopl, chetfsumma, summaoplav, summaopl, summazadol, comment, kodstatuszdl) VALUES ('$chf_koddoc', '$chf_kodkalplan', '$chf_kodchfact', '$chf_kodusechf', '$chf_koddel', '$chf_chetfnumber', '$chf_chetfdate', '', '$chf_chetfsumma', '$chf_sumAvChf', '$chf_sumOpChf', '$chf_summazadol', '$chf_comment', '$chf_kodstatuszdl') ");
			}
		}
	}
	$_LOG_UPDATE = mysqlQuery("UPDATE dognet_log_updates_table SET table_update='" . $ondate . "' WHERE table_name='dognet_reports_zadolchf_ondate'");
	#
	#
}
?>

<script type="text/javascript"
        src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/moment-with-locales.js"></script>
<link rel="stylesheet"
      href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/_bootstrap-css/bootstrap-datetimepicker.css" />
<script type="text/javascript"
        src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/_bootstrap-js/bootstrap-datetimepicker.js">
</script>

<link rel="stylesheet"
      href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/report/report-details/css/reports-spravka-zadolchf.css">

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
						$_QRY = mysqlQuery("SELECT table_update FROM dognet_log_updates_table WHERE table_name='dognet_reports_zadolchf_ondate'");
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
                            <li><a data-toggle="tab" href="#tab-2" title="">Договора</a></li>
                            <li><a data-toggle="tab" href="#tab-3" title="">Счета</a></li>
                            <li style="float:right"><a
                                   href="?reportview=zadolchf_ondate&export=yes&doc=&cht=&format=&ondate=<?php echo $_ZDL_ONDATE; ?>"
                                   title="">Экспорт</a></li>
                        </ul>

                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane fade in active">
                                <?php include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/spravka/zadolchf_ondate/dognet-report-reportview(restr_4)-spravka-zadolchf_ondate_common.php"); ?>
                            </div>
                            <div id="tab-2" class="tab-pane fade">
                                <?php include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/spravka/zadolchf_ondate/dognet-report-reportview(restr_4)-spravka-zadolchf_ondate_docs.php"); ?>
                            </div>
                            <div id="tab-3" class="tab-pane fade">
                                <?php include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/spravka/zadolchf_ondate/dognet-report-reportview(restr_4)-spravka-zadolchf_ondate_chets.php"); ?>
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