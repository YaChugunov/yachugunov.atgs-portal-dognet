<?php
# ----- ----- ----- ----- ----- 
#	ОПИСАНИЕ : Сумма всех авансов зачтенных в счет-фактуру $kodchfsubpodr 
#	
#
function DOCBASE_FN_SUM_CHF($koddoc) { 
	$_QRY = mysqlQuery( "SELECT SUM(summaoplav) as SummaAvansChf FROM dognet_chfavans WHERE kodchfact=".$kodchfact );
	$_ROW = mysqli_fetch_assoc($_QRY);
	if ( $_QRY ) { 
		$__SummaAvansChf = $_ROW['SummaAvansChf']; 
	}
	else {
		$__SummaAvansChf = "";
	}
	return $__SummaAvansChf;
}
#
# ----- ----- ----- ----- ----- 
#	ОПИСАНИЕ : Сумма всех авансов зачтенных в счет-фактуру $kodchfsubpodr 
#	
#
function DOCBASE_FN_SUM_AVANS($koddoc) { 
	$_QRY = mysqlQuery( "SELECT SUM(summaoplav) as SummaAvansChf FROM dognet_chfavans WHERE kodchfact=".$kodchfact );
	$_ROW = mysqli_fetch_assoc($_QRY);
	if ( $_QRY ) { 
		$__SummaAvansChf = $_ROW['SummaAvansChf']; 
	}
	else {
		$__SummaAvansChf = "";
	}
	return $__SummaAvansChf;
}
#
# ----- ----- ----- ----- ----- 
# ОПИСАНИЕ : Сумма всех оплат счета-фактуры $kodchfsubpodr 
#	
#
function DOCBASE_FN_SUM_OPLATA($koddoc) { 
	$_QRY = mysqlQuery( "SELECT SUM(summaopl) as SummaOplatChf FROM dognet_oplatachf WHERE kodchfact=".$kodchfact );
	$_ROW = mysqli_fetch_assoc($_QRY);
	if ( $_QRY ) { 
		$__SummaOplatChf = $_ROW['SummaOplatChf']; 
	}
	else {
		$__SummaOplatChf = "";
	}
	return $__SummaOplatChf;
}

?>