<?php
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
# Функция суммирования счетов-фактур по ётапу
# 
function StageSumChf($varKodkalplan) { 
// Из таблицы dognet_kalplanchf определяем код(ы) счета(ов)-фактур - kodchfact относящихся к соответствующему этапу (календарному плану)
	$query_getKodchfact = mysqlQuery( "SELECT SUM(chetfsumma) as SummaChf FROM dognet_kalplanchf WHERE kodkalplan =".$varKodkalplan." AND koddel <> '99'" );
	$row_getKodchfact = mysqli_fetch_array($query_getKodchfact, MYSQLI_ASSOC);
	$varSummaChf = $row_getKodchfact['SummaChf'];
	return $varSummaChf;
}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
# Функция расчета суммарных платежей по этапу (оплата + аванс) с кодом kodkalplan
# 
function StageOplata($varKodkalplan) { 
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
function StageZadolg($varKodkalplan) { 
// Из таблицы dognet_dockalplan определяем код(ы) этапа(ов) - kodkalplan
	$query_getSummastage = mysqlQuery( "SELECT summastage FROM dognet_dockalplan WHERE kodkalplan = ".$varKodkalplan." AND koddel <> '99'" );
	$row_getSummastage = mysqli_fetch_array($query_getSummastage, MYSQLI_ASSOC);
	$varSummastage = $row_getSummastage['summastage'];
	$varStageSumChf = StageSumChf($varKodkalplan);
	$StateZadolg = $varSummastage-$varStageSumChf;
	return $StateZadolg;
}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
# Функция расчета суммарных платежей по счету-фактуре с кодом kodchfact
# 
function ChetfOplata($varKodchfact) { 
// В таблице dognet_oplatachf находим все оплаченные счета-фактуры с кодом kodchfact и суммируем
	$query_getSummaopl = mysqlQuery( "SELECT SUM(summaopl) as SummaOplatChf FROM dognet_oplatachf WHERE kodchfact =".$varKodchfact." AND koddel <> '99'" );
	$row_getSummaopl = mysqli_fetch_array($query_getSummaopl, MYSQLI_ASSOC);
	$varSummaOplatChf = $row_getSummaopl['SummaOplatChf'];
	return $varSummaOplatChf;
}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
# Функция расчета суммы авансов по счету-фактуре с кодом kodchfact
# 
function ChetfAvans($varKodchfact) { 
// В таблице dognet_chfavans находим все авансы по счетам-фактурам с кодом kodchfact и суммируем
	$query_getSummaoplav = mysqlQuery( "SELECT SUM(summaoplav) as SummaAvansChf FROM dognet_chfavans WHERE kodchfact =".$varKodchfact." AND koddel <> '99'" );
	$row_getSummaoplav = mysqli_fetch_array($query_getSummaoplav, MYSQLI_ASSOC);
	$varSummaAvansChf = $row_getSummaoplav['SummaAvansChf'];
	return $varSummaAvansChf;
}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
# Функция расчета суммы авансов по счету-фактуре с кодом kodchfact
# 
function ChetfZadolg($varKodchfact) { 
// Из таблицы dognet_kalplanchf определяем код(ы) счета(ов)-фактур - kodchfact относящихся к соответствующему этапу (календарному плану)
	$query_getChetfsumma = mysqlQuery( "SELECT chetfsumma FROM dognet_kalplanchf WHERE kodchfact =".$varKodchfact." AND koddel <> '99'" );
	while($row_getChetfsumma = mysqli_fetch_array($query_getChetfsumma, MYSQLI_ASSOC)) { 
		$varChetfZadolg = $row_getChetfsumma['chetfsumma'] - (ChetfOplata($varKodchfact) + ChetfAvans($varKodchfact));
	}
	return $varChetfZadolg;
}
?>