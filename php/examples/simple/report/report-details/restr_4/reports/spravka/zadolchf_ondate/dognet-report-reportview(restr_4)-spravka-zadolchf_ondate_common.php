<?php

// Текущая задолженность
	$_QRY_DOC1 = mysqlQuery( "SELECT SUM(summazadol) as SUM_1 FROM dognet_reports_zadolchf_ondate WHERE kodstatuszdl = '1' AND koddel <> '99' AND koddoc IN (SELECT koddoc FROM dognet_docbase WHERE numberchet = '')" );
	$_ROW_DOC1 = mysqli_fetch_assoc($_QRY_DOC1);
	$_sumzadol_doc1 = $_ROW_DOC1['SUM_1'];
	$_QRY_CHT1 = mysqlQuery( "SELECT SUM(summazadol) as SUM_1 FROM dognet_reports_zadolchf_ondate WHERE kodstatuszdl = '1' AND koddel <> '99' AND koddoc IN (SELECT koddoc FROM dognet_docbase WHERE numberchet <> '')" );
	$_ROW_CHT1 = mysqli_fetch_assoc($_QRY_CHT1);
	$_sumzadol_cht1 = $_ROW_CHT1['SUM_1'];

// Судебная задолженность
	$_QRY_DOC2 = mysqlQuery( "SELECT SUM(summazadol) as SUM_2 FROM dognet_reports_zadolchf_ondate WHERE kodstatuszdl = '2' AND koddel <> '99' AND koddoc IN (SELECT koddoc FROM dognet_docbase WHERE numberchet = '')" );
	$_ROW_DOC2 = mysqli_fetch_assoc($_QRY_DOC2);
	$_sumzadol_doc2 = $_ROW_DOC2['SUM_2'];
	$_QRY_CHT2 = mysqlQuery( "SELECT SUM(summazadol) as SUM_2 FROM dognet_reports_zadolchf_ondate WHERE kodstatuszdl = '2' AND koddel <> '99' AND koddoc IN (SELECT koddoc FROM dognet_docbase WHERE numberchet <> '')" );
	$_ROW_CHT2 = mysqli_fetch_assoc($_QRY_CHT2);
	$_sumzadol_cht2 = $_ROW_CHT2['SUM_2'];

// Невозвратная задолженность
	$_QRY_DOC3 = mysqlQuery( "SELECT SUM(summazadol) as SUM_3 FROM dognet_reports_zadolchf_ondate WHERE kodstatuszdl = '3' AND koddel <> '99' AND koddoc IN (SELECT koddoc FROM dognet_docbase WHERE numberchet = '')" );
	$_ROW_DOC3 = mysqli_fetch_assoc($_QRY_DOC3);
	$_sumzadol_doc3 = $_ROW_DOC3['SUM_3'];
	$_QRY_CHT3 = mysqlQuery( "SELECT SUM(summazadol) as SUM_3 FROM dognet_reports_zadolchf_ondate WHERE kodstatuszdl = '3' AND koddel <> '99' AND koddoc IN (SELECT koddoc FROM dognet_docbase WHERE numberchet <> '')" );
	$_ROW_CHT3 = mysqli_fetch_assoc($_QRY_CHT3);
	$_sumzadol_cht3 = $_ROW_CHT3['SUM_3'];

?>



	<div class="space20"></div>
	<div class="col-xs-12 col-sm-6 col-md-6 col-md-6">

		<div id="summa-zadolzh" class="panel panel-default">
		  <div class="panel-body">
				<h3 class="space30">Договора</h3>
				<ul class="list-group">
				  <li class="list-group-item">Текущая задолженность :<span style="float:right"><?php echo number_format((float)($_sumzadol_doc1), 2, '.', ' '); ?></span></li>
				  <li class="list-group-item">Судебная задолженность :<span style="float:right"><?php echo number_format((float)($_sumzadol_doc2), 2, '.', ' '); ?></span></li>
				  <li class="list-group-item">Невозвратная задолженность :<span style="float:right"><?php echo number_format((float)($_sumzadol_doc3), 2, '.', ' '); ?></span></li>
				</ul>

		  </div>
		  <div class="panel-footer">ИТОГО :<span style="float:right"><?php echo number_format((float)($_sumzadol_doc1 + $_sumzadol_doc2 + $_sumzadol_doc3), 2, '.', ' '); ?></span></div>
		</div>

	</div>
	<div class="col-xs-12 col-sm-6 col-md-6 col-md-6">

		<div id="summa-zadolzh" class="panel panel-default">
		  <div class="panel-body">
				<h3 class="space30">Счета</h3>
				<ul class="list-group">
				  <li class="list-group-item">Текущая задолженность :<span style="float:right"><?php echo ( $_sumzadol_cht1 ? number_format((float)($_sumzadol_cht1), 2, '.', ' ') : "---" ); ?></span></li>
				  <li class="list-group-item">Судебная задолженность :<span style="float:right"><?php echo ( $_sumzadol_cht1 ? number_format((float)($_sumzadol_cht2), 2, '.', ' ') : "---" ); ?></span></li>
				  <li class="list-group-item">Невозвратная задолженность :<span style="float:right"><?php echo ( $_sumzadol_cht1 ? number_format((float)($_sumzadol_cht3), 2, '.', ' ') : "---" ); ?></span></li>
				</ul>

		  </div>
		  <div class="panel-footer">ИТОГО :<span style="float:right"><?php echo number_format((float)($_sumzadol_cht1 + $_sumzadol_cht2 + $_sumzadol_cht3), 2, '.', ' '); ?></span></div>
		</div>

	</div>


<?php

	//

?>
