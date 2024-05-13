<?php

// Общее количество субподрядных организаций
$_QRY_SUBDOC_A = mysqlQuery("SELECT DISTINCT kodsubpodr FROM dognet_docsubpodr WHERE koddel <> '99'");
$_ROW_SUBDOC_A = mysqli_fetch_assoc($_QRY_SUBDOC_A);
$_qty_subdocA = mysqli_num_rows($_QRY_SUBDOC_A);

// Общее количество субподрядных организаций, перед которыми есть задолженность
$_QRY_SUBDOC_B = mysqlQuery("SELECT DISTINCT kodsubpodr FROM dognet_docsubpodr WHERE koddel <> '99' AND sumzadolsubpodr > 0.00");
$_ROW_SUBDOC_B = mysqli_fetch_assoc($_QRY_SUBDOC_B);
$_qty_subdocB = mysqli_num_rows($_QRY_SUBDOC_B);

// Общее количество договоров
$_QRY_SUBDOC1 = mysqlQuery("SELECT * FROM dognet_docsubpodr WHERE koddel <> '99'");
$_ROW_SUBDOC1 = mysqli_fetch_assoc($_QRY_SUBDOC1);
$_qty_subdoc1 = mysqli_num_rows($_QRY_SUBDOC1);

// Из них с задолженностью
$_QRY_SUBDOC2 = mysqlQuery("SELECT * FROM dognet_docsubpodr WHERE koddel <> '99' AND sumzadolsubpodr > 0.00");
$_ROW_SUBDOC2 = mysqli_fetch_assoc($_QRY_SUBDOC2);
$_qty_subdoc2 = mysqli_num_rows($_QRY_SUBDOC2);

// Из них не закрытых
$_QRY_SUBDOC3 = mysqlQuery("SELECT koddocsubpodr, sumdocsubpodr FROM dognet_docsubpodr WHERE koddel <> '99'");
$_qty_subdoc3 = mysqli_num_rows($_QRY_SUBDOC3);
$_cnt = 0;
while ($_ROW_SUBDOC3 = mysqli_fetch_assoc($_QRY_SUBDOC3)) {
	$_koddocsubpodr = $_ROW_SUBDOC3['koddocsubpodr'];
	$_sumdocsubpodr = $_ROW_SUBDOC3['sumdocsubpodr'];
	$_QRY_SUBDOC3_1 = mysqlQuery("SELECT SUM(sumchfsubpodr) as SUM_CHF FROM dognet_docchfsubpodr WHERE koddocsubpodr = " . $_koddocsubpodr . " AND koddel <> '99'");
	$_ROW_SUBDOC3_1 = mysqli_fetch_assoc($_QRY_SUBDOC3_1);
	$_sumchf = $_ROW_SUBDOC3_1['SUM_CHF'];
	if (($_sumdocsubpodr != '') && ($_sumdocsubpodr != 0.00) && $_sumdocsubpodr > $_sumchf) {
		$_cnt++;
	}
}
$_qty_nezakr = $_cnt;

// Сумма выставленных счетов по всем договорам
$_QRY_SUBDOC4 = mysqlQuery("SELECT SUM(sumchfsubpodr) as TOTAL_CHF FROM dognet_docchfsubpodr WHERE koddel <> '99'");
$_ROW_SUBDOC4 = mysqli_fetch_assoc($_QRY_SUBDOC4);
$_total_sumchf = $_ROW_SUBDOC4['TOTAL_CHF'];

// Сумма оплаченных счетов по всем договорам
$_QRY_SUBDOC5 = mysqlQuery("SELECT SUM(sumoplchfsubpodr) as TOTAL_OPLCHF FROM dognet_docoplchfsubpodr WHERE koddel <> '99'");
$_ROW_SUBDOC5 = mysqli_fetch_assoc($_QRY_SUBDOC5);
$_total_sumoplchf = $_ROW_SUBDOC5['TOTAL_OPLCHF'];
// Сумма всех авансов по всем договорам
$_QRY_SUBDOC6_1 = mysqlQuery("SELECT SUM(sumavsubpodr) as TOTAL_AV FROM dognet_docavsubpodr WHERE koddel<>'99'");
$_ROW_SUBDOC6_1 = mysqli_fetch_assoc($_QRY_SUBDOC6_1);
$_total_sumav = $_ROW_SUBDOC6_1['TOTAL_AV'];
// Сумма всех полностью зачтенных авансов по всем договорам
$_QRY_SUBDOC6_2 = mysqlQuery("SELECT SUM(sumavsubpodr) as TOTAL_AVCHF FROM dognet_docavsubpodr WHERE koddel <> '99' AND useavans='2' AND kodchfsubpodr <> ''");
$_ROW_SUBDOC6_2 = mysqli_fetch_assoc($_QRY_SUBDOC6_2);
$_total_sumavchf = $_ROW_SUBDOC6_2['TOTAL_AVCHF'];
// Сумма всех частично зачтенных авансов по всем договорам
$_QRY_SUBDOC6_3 = mysqlQuery("SELECT SUM(sumavsplit) as TOTAL_AVSPLITCHF FROM dognet_docavsplitsubpodr WHERE koddel <> '99' AND kodchfsubpodr <> '' AND kodavsubpodr IN (SELECT kodavsubpodr FROM dognet_docavsubpodr WHERE koddel<>'99' AND useavans='1' AND kodchfsubpodr='')");
$_ROW_SUBDOC6_3 = mysqli_fetch_assoc($_QRY_SUBDOC6_3);
$_total_sumavsplitchf = $_ROW_SUBDOC6_3['TOTAL_AVSPLITCHF'];

// Сумма задолженностей по договорам субподряда по столбцу sumzadolsubpodr
$_QRY_SUBDOC7 = mysqlQuery("SELECT SUM(sumzadolsubpodr) as TOTAL_ZADOL FROM dognet_docsubpodr WHERE koddel <> '99'");
$_ROW_SUBDOC7 = mysqli_fetch_assoc($_QRY_SUBDOC7);
$_total_zadol_table = $_ROW_SUBDOC7['TOTAL_ZADOL'];

// Сумма выплаченных авансов и совершенных оплат
$_total_oplav = $_total_sumoplchf + $_total_sumav;
// Сумма зачтенных авансов и совершенных оплат
$_total_oplavchf = $_total_sumoplchf + $_total_sumavchf + $_total_sumavsplitchf;

// Расчетная общая задолженность по счетам
$_total_zadol_calc = $_total_sumchf - $_total_oplavchf;
$_itogo_calc = $_total_zadol_calc;

// Табличная общая задолженность по счетам
$_itogo_table = $_total_zadol_table;

?>



<div class="space20"></div>
<div class="row">
	<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">

		<div id="summa-zadolzh" class="">
			<div class="panel-body">
				<h3 class="space30">Договора</h3>
				<ul class="list-group">
					<li class="list-group-item">Общее количество субподрядных организаций :<span style="float:right"><?php echo $_qty_subdocA; ?></span></li>
					<li class="list-group-item"><span style="margin-left:20px">Из них с задолженностью :</span><span style="float:right"><?php echo $_qty_subdocB; ?></span></li>
					<li class="list-group-item">Общее количество договоров :<span style="float:right"><?php echo $_qty_subdoc1; ?></span></li>
					<li class="list-group-item"><span style="margin-left:20px">Из них с задолженностью :</span><span style="float:right"><?php echo $_qty_subdoc2; ?></span></li>
					<li class="list-group-item"><span style="margin-left:20px">Из них не закрытых :</span><span style="float:right"><?php echo $_qty_nezakr; ?></span></li>
				</ul>

			</div>
		</div>

	</div>
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">

		<div id="summa-zadolzh" class="">
			<div class="panel-body">
				<h3 class="space30">Счета и оплата</h3>
				<ul class="list-group">
					<li class="list-group-item"><span style="float:right; margin-left:20px"><kbd>A</kbd></span>Всего выставлено
						счетов на сумму :<span style="float:right"><?php echo ($_total_sumchf ? number_format((float)($_total_sumchf), 2, '.', ' ') : "---"); ?></span>
					</li>
					<li class="list-group-item"><span style="float:right; margin-left:20px"><kbd>B</kbd></span>Всего оплачено
						счетов на сумму :<span style="float:right"><?php echo ($_total_sumoplchf ? number_format((float)($_total_sumoplchf), 2, '.', ' ') : "---"); ?></span>
					</li>
					<li class="list-group-item"><span style="float:right; margin-left:20px"><kbd>C</kbd></span>Всего выплачено
						авансов на сумму :<span style="float:right"><?php echo ($_total_sumav ? number_format((float)($_total_sumav), 2, '.', ' ') : "---"); ?></span>
					</li>
					<li class="list-group-item"><span style="float:right; margin-left:20px"><kbd>D</kbd></span><span style="margin-left:20px">Из нее зачтено :<span style="float:right"><?php echo ($_total_sumavchf ? number_format((float)($_total_sumavchf), 2, '.', ' ') : "---"); ?></span></span>
					</li>
					<li class="list-group-item"><span style="float:right; margin-left:20px"><kbd>E</kbd></span>Итого закрыто по
						счетам :<span style="float:right"><?php echo ($_total_oplavchf ? number_format((float)($_total_oplavchf), 2, '.', ' ') : "---"); ?></span>
					</li>
				</ul>

			</div>
			<div class="panel-footer">
				<span class="title">Итоговая задолженность (расчетная) :<span style="float:right"><?php echo number_format((float)($_itogo_calc), 2, '.', ' '); ?></span></span>
				<br>
				<kbd>= A - ( B + D )</kbd>
			</div>
			<div class="panel-footer">
				<span class="title">Итоговая задолженность (табличная) :<span style="float:right"><?php echo number_format((float)($_itogo_table), 2, '.', ' '); ?></span></span>
			</div>
		</div>

	</div>
</div>

<div class="space50"></div>

<?php

//

?>