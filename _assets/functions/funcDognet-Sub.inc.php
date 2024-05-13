<?php

# ::: ФУНКЦИИ
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# ОПРЕДЕЛЕНИЕ ОБЩЕЙ ЗАДОЛЖЕННОСТИ ПО ДОГОВОРУ СУБПОДРЯДА
# + $koddoc - ID договора
# + $action - кнопка вызова процедуры (New, Edit, Delete)
# + $kodshab - шаблон договора, с календарным планом (1) или без (2)
# + $source_rowID - ID строки исходных данных источника
# + $source_tableName - имя таблицы-источника
# + $db - драйвер БД
#
function DOCSUB_PR_ZADOLG_AVANS($db, $source_tableName, $source_rowID, $action) {
}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# ОПРЕДЕЛЕНИЕ ОБЩЕЙ ЗАДОЛЖЕННОСТИ ПО ДОГОВОРУ СУБПОДРЯДА
# + $koddoc - ID договора
# + $action - кнопка вызова процедуры (New, Edit, Delete)
# + $kodshab - шаблон договора, с календарным планом (1) или без (2)
# + $source_rowID - ID строки исходных данных источника
# + $source_tableName - имя таблицы-источника
# + $db - драйвер БД
#
function DOCSUB_PR_ZADOLG_DOC($db, $source_tableName, $source_rowID, $action) {
	#
	#
	if ($source_tableName == "docsubpodr") {
	}
	#
	#
	if ($source_tableName == "docchfsubpodr") {
		// Выбираем код редактируемого счета-фактуры (kodchfact)
		// из таблицы счетов dognet_kalplanchf
		$_CHF_OPL_0 = 0;
		$_CHF_OPL_AVS_0 = 0;
		$_CHF_OPL_AVSPLIT_0 = 0;
		$_QRY = $db->sql("SELECT * FROM dognet_docchfsubpodr WHERE id=" . $source_rowID)->fetchAll();
		if ($_QRY) {
			$__kodchfact = $_QRY[0]['kodchfsubpodr'];
			$__koddocsubpodr = $_QRY[0]['koddocsubpodr'];
			// Запоминаем сумму счета для текущей записи
			$_CHF_0 = $_QRY[0]['sumchfsubpodr'];
			// Запоминаем сумму оплаты для текущего счета
			$_QRY_CHF_OPL_0 = mysqlQuery("SELECT SUM(sumoplchfsubpodr) as sum1 FROM dognet_docoplchfsubpodr WHERE kodchfsubpodr=" . $__kodchfact);
			$_ROW_CHF_OPL_0 = mysqli_fetch_assoc($_QRY_CHF_OPL_0);
			$_CHF_OPL_0 = $_ROW_CHF_OPL_0['sum1'];
			// Запоминаем сумму зачтенного аванса для текущего счета
			$_QRY_CHF_OPL_AVS_0 = mysqlQuery("SELECT SUM(sumavsubpodr) as sum2 FROM dognet_docavsubpodr WHERE kodchfsubpodr=" . $__kodchfact);
			$_ROW_CHF_OPL_AVS_0 = mysqli_fetch_assoc($_QRY_CHF_OPL_AVS_0);
			$_CHF_OPL_AVS_0 = $_ROW_CHF_OPL_AVS_0['sum2'];
			// Запоминаем сумму зачтенного аванса через сплит
			$_QRY_CHF_OPL_AVSPLIT_0 = mysqlQuery("SELECT SUM(sumavsplit) as sumsplit FROM dognet_docavsplitsubpodr WHERE kodchfsubpodr=" . $__kodchfact);
			$_ROW_CHF_OPL_AVSPLIT_0 = mysqli_fetch_assoc($_QRY_CHF_OPL_AVSPLIT_0);
			$_CHF_OPL_AVSPLIT_0 = $_ROW_CHF_OPL_AVSPLIT_0['sumsplit'];
		}
		#
		// Выбираем код счета-фактуры
		$_QRY1 = mysqlQuery("SELECT kodchfsubpodr FROM dognet_docchfsubpodr WHERE koddocsubpodr=" . $__koddocsubpodr);
		// Обнуляем счетчики
		$_CHF_SUM = 0;
		$_CHF_OPL_SUM = 0;
		$_CHF_AVS_SUM = 0;
		$_CHF_OPL_AVS_SUM = 0;
		$_CHF_OPL_AVSPLIT_SUM = 0;
		$__summachfact = 0;
		$__summaopl = 0;
		$__sumavans = 0;
		$__sumoplavans = 0;
		$__sumsplit = 0;
		// Запускаем цикл по всем счетам-фактурам
		while ($_ROW1 = mysqli_fetch_assoc($_QRY1)) {
			$kod = $_ROW1['kodchfsubpodr'];
			// Выбираем сумму счета-фактуры ($kod)
			$_QRY2 = $db->sql("SELECT sumchfsubpodr FROM dognet_docchfsubpodr WHERE kodchfsubpodr=" . $kod)->fetchAll();
			if ($_QRY2) {
				$__summachfact = $_QRY2[0]['sumchfsubpodr'];
			}
			// Сууммируем все оплаты по счету-фактуре ($kod)
			$_QRY3 = $db->sql("SELECT SUM(sumoplchfsubpodr) as sumoplata FROM dognet_docoplchfsubpodr WHERE kodchfsubpodr=" . $kod)->fetchAll();
			if ($_QRY3) {
				$__summaopl = $_QRY3[0]['sumoplata'];
			}
			// Суммируем все зачтенные авансы по счету-фактуре ($kod)
			$_QRY4 = $db->sql("SELECT SUM(sumavsubpodr) as sumoplavans FROM dognet_docavsubpodr WHERE kodchfsubpodr=" . $kod)->fetchAll();
			if ($_QRY4) {
				$__sumoplavans = $_QRY4[0]['sumoplavans'];
			}
			// Суммируем все зачтенные авансы через сплит
			$_QRY5 = $db->sql("SELECT SUM(sumavsplit) as sumsplit FROM dognet_docavsplitsubpodr WHERE kodchfsubpodr=" . $kod)->fetchAll();
			if ($_QRY5) {
				$__sumsplit = $_QRY5[0]['sumsplit'];
			}
			// Считаем текущую задолженность по счету-фактуре ($kod)
			if (($kod === $__kodchfact) and $action == "DEL") {
				$_NEW_sumzadolchfact = $__summachfact - (($__summaopl - $_CHF_OPL_0) + $__sumoplavans);
			} else {
				$_NEW_sumzadolchfact = $__summachfact - ($__summaopl + $__sumoplavans + $__sumsplit);
			}
			// Пишем в таблицу задолженностей счетов-фактур
			// $db->update( 'dognet_kalplanchf_zadol', array(
			// 	'chetfsumzadol'		=>	$_NEW_sumzadolchfact
			// ), array( 'kodchfact' => $kod ));
			// Суммируем общую задолженность по договору
			$_CHF_SUM += $__summachfact;
			$_CHF_OPL_SUM += $__summaopl;
			$_CHF_OPL_AVS_SUM += $__sumoplavans;
			$_CHF_OPL_AVSPLIT_SUM += $__sumsplit;
		}
		// Суммируем все авансы по договору ($_koddoc)
		$_QRY5 = $db->sql("SELECT SUM(sumavsubpodr) as sumavans FROM dognet_docavsubpodr WHERE koddocsubpodr=" . $__koddocsubpodr)->fetchAll();
		if ($_QRY5) {
			$__sumavans = $_QRY5[0]['sumavans'];
		}
		$_CHF_AVS_SUM = $__sumavans;
		// Пишем в основную таблицу договоров общую задолженность по счетам, оплатам и авансам
		// по договору ($_koddoc)
		if ($action == "CRT") {
			$db->update('dognet_docsubpodr', array(
				'sumzadolsubpodr' => ($_CHF_SUM + $_CHF_0) - ($_CHF_OPL_SUM + $_CHF_OPL_0) - ($_CHF_OPL_AVS_SUM + $_CHF_OPL_AVS_0) - ($_CHF_OPL_AVSPLIT_SUM + $_CHF_OPL_AVSPLIT_0),
			), array('koddocsubpodr' => $__koddocsubpodr));
		}
		if ($action == "UPD") {
			$db->update('dognet_docsubpodr', array(
				'sumzadolsubpodr' =>	$_CHF_SUM - ($_CHF_OPL_SUM + $_CHF_OPL_AVS_SUM + $_CHF_OPL_AVSPLIT_SUM),
			), array('koddocsubpodr' => $__koddocsubpodr));
		}
		if ($action == "DEL") {
			$db->update('dognet_docsubpodr', array(
				'sumzadolsubpodr' => ($_CHF_SUM - $_CHF_0) - ($_CHF_OPL_SUM + $_CHF_OPL_AVS_SUM + $_CHF_OPL_AVSPLIT_SUM),
			), array('koddocsubpodr' => $__koddocsubpodr));
		}
	}
	#
	#
	if ($source_tableName == "docavsubpodr") {
		// Выбираем зачтенный аванс (kodchfsubpodr не пустой)
		// из таблицы авансов субподряда dognet_docavsubpodr по id редактируемой строки ($source_rowID)
		$_CHF_OPL_0 = 0;
		$_CHF_OPL_AVS_0 = 0;
		$_CHF_OPL_AVSPLIT_0 = 0;
		$_QRY = $db->sql("SELECT * FROM dognet_docavsubpodr WHERE id=" . $source_rowID)->fetchAll();
		/* 		if ( $_QRY && $_QRY[0]['kodchfsubpodr'] != "" ) {  */
		if ($_QRY) {
			$__kodchfact = $_QRY[0]['kodchfsubpodr'];
			$__koddocsubpodr = $_QRY[0]['koddocsubpodr'];
			$__kodavsubpodr = $_QRY[0]['kodavsubpodr'];
			// Запоминаем сумму зачтенного аванса
			$_CHF_OPL_AVS_0 = $_QRY[0]['sumavsubpodr'];
			$_QRY_SPLIT = $db->sql("SELECT SUM(sumavsplit) as sumsplit FROM dognet_docavsplitsubpodr WHERE kodavsubpodr='{$__kodavsubpodr}' AND kodchfsubpodr='{$__kodchfact}'")->fetchAll();
			$_CHF_OPL_AVSPLIT_0 = $_QRY_SPLIT[0]['sumsplit'];
		}
		#
		// Выбираем код счета-фактуры
		$_QRY1 = mysqlQuery("SELECT kodchfsubpodr FROM dognet_docchfsubpodr WHERE koddocsubpodr=" . $__koddocsubpodr);
		// Обнуляем счетчики
		$_CHF_SUM = 0;
		$_CHF_OPL_SUM = 0;
		$_CHF_AVS_SUM = 0;
		$_CHF_OPL_AVS_SUM = 0;
		$_CHF_OPL_AVSPLIT_SUM = 0;
		$__summachfact = 0;
		$__summaopl = 0;
		$__sumavans = 0;
		$__sumoplavans = 0;
		$__sumsplit = 0;
		// Запускаем цикл по всем счетам-фактурам
		while ($_ROW1 = mysqli_fetch_assoc($_QRY1)) {
			$kod = $_ROW1['kodchfsubpodr'];
			// Выбираем сумму счета-фактуры ($kod)
			$_QRY2 = $db->sql("SELECT sumchfsubpodr FROM dognet_docchfsubpodr WHERE kodchfsubpodr=" . $kod)->fetchAll();
			if ($_QRY2) {
				$__summachfact = $_QRY2[0]['sumchfsubpodr'];
			}
			// Сууммируем все оплаты по счету-фактуре ($kod)
			$_QRY3 = $db->sql("SELECT SUM(sumoplchfsubpodr) as sumoplata FROM dognet_docoplchfsubpodr WHERE kodchfsubpodr=" . $kod)->fetchAll();
			if ($_QRY3) {
				$__summaopl = $_QRY3[0]['sumoplata'];
			}
			// Суммируем все зачтенные авансы по счету-фактуре ($kod)
			$_QRY4 = $db->sql("SELECT SUM(sumavsubpodr) as sumoplavans FROM dognet_docavsubpodr WHERE kodchfsubpodr=" . $kod)->fetchAll();
			if ($_QRY4) {
				$__sumoplavans = $_QRY4[0]['sumoplavans'];
			}
			// Суммируем все зачтенные авансы по сплиту
			$_QRY41 = $db->sql("SELECT SUM(sumavsplit) as sumsplit FROM dognet_docavsplitsubpodr WHERE kodchfsubpodr=" . $kod)->fetchAll();
			if ($_QRY41) {
				$__sumsplit = $_QRY41[0]['sumsplit'];
			}
			// Считаем текущую задолженность по счету-фактуре ($kod)
			if (($kod === $__kodchfact) and $action == "DEL") {
				$_NEW_sumzadolchfact = $__summachfact - ($__summaopl + ($__sumoplavans - $_CHF_OPL_AVS_0));
			} else {
				$_NEW_sumzadolchfact = $__summachfact - ($__summaopl + $__sumoplavans + $__sumsplit);
			}
			// Пишем в таблицу задолженностей счетов-фактур
			// $db->update( 'dognet_kalplanchf_zadol', array(
			// 	'chetfsumzadol'		=>	$_NEW_sumzadolchfact
			// ), array( 'kodchfact' => $kod ));
			// Суммируем общую задолженность по договору
			$_CHF_SUM += $__summachfact;
			$_CHF_OPL_SUM += $__summaopl;
			$_CHF_OPL_AVS_SUM += $__sumoplavans;
			$_CHF_OPL_AVSPLIT_SUM += $__sumsplit;
		}
		// Суммируем все авансы по договору ($_koddoc)
		$_QRY5 = $db->sql("SELECT SUM(sumavsubpodr) as sumavans FROM dognet_docavsubpodr WHERE koddocsubpodr=" . $__koddocsubpodr)->fetchAll();
		if ($_QRY5) {
			$__sumavans = $_QRY5[0]['sumavans'];
		}
		$_CHF_AVS_SUM = $__sumavans;
		// Пишем в основную таблицу договоров общую задолженность по счетам, оплатам и авансам
		// по договору ($_koddoc)
		if ($action == "CRT" or $action == "UPD") {
			$db->update('dognet_docsubpodr', array(
				'sumzadolsubpodr' =>	$_CHF_SUM - ($_CHF_OPL_SUM + $_CHF_OPL_AVS_SUM + $_CHF_OPL_AVSPLIT_SUM)
			), array('koddocsubpodr' => $__koddocsubpodr));
		}
		if ($action == "DEL") {
			$db->update('dognet_docsubpodr', array(
				'sumzadolsubpodr' =>	$_CHF_SUM - ($_CHF_OPL_SUM + ($_CHF_OPL_AVS_SUM - $_CHF_OPL_AVS_0) + $_CHF_OPL_AVSPLIT_SUM)
			), array('koddocsubpodr' => $__koddocsubpodr));
		}
	}
	#
	#
	if ($source_tableName == "docavsplitsubpodr") {
		// Выбираем зачтенный аванс (kodchfsubpodr не пустой)
		// из таблицы авансов субподряда dognet_docavsubpodr по id редактируемой строки ($source_rowID)
		$_CHF_OPL_0 = 0;
		$_CHF_OPL_AVS_0 = 0;
		$_QRY = $db->sql("SELECT * FROM dognet_docavsplitsubpodr WHERE id=" . $source_rowID)->fetchAll();
		/* 		if ( $_QRY && $_QRY[0]['kodchfsubpodr'] != "" ) {  */
		if ($_QRY) {
			$__kodchfact = $_QRY[0]['kodchfsubpodr'];
			$__koddocsubpodr = $_QRY[0]['koddocsubpodr'];
			// Запоминаем сумму зачтенного аванса
			$_CHF_OPL_AVS_0 = !empty($__kodchfact) ? $_QRY[0]['sumavsplit'] : 0;
		}
		#
		// Выбираем код счета-фактуры
		$_QRY1 = mysqlQuery("SELECT kodchfsubpodr FROM dognet_docchfsubpodr WHERE koddocsubpodr=" . $__koddocsubpodr);
		// Обнуляем счетчики
		$_CHF_SUM = 0;
		$_CHF_OPL_SUM = 0;
		$_CHF_AVS_SUM = 0;
		$_CHF_OPL_AVS_SUM = 0;
		$_CHF_OPL_AVSPLIT_SUM = 0;
		$__summachfact = 0;
		$__summaopl = 0;
		$__sumavans = 0;
		$__sumoplavans = 0;
		$__sumsplit = 0;
		// Запускаем цикл по всем счетам-фактурам
		while ($_ROW1 = mysqli_fetch_assoc($_QRY1)) {
			$kod = $_ROW1['kodchfsubpodr'];
			// Выбираем сумму счета-фактуры ($kod)
			$_QRY2 = $db->sql("SELECT sumchfsubpodr FROM dognet_docchfsubpodr WHERE kodchfsubpodr=" . $kod)->fetchAll();
			if ($_QRY2) {
				$__summachfact = $_QRY2[0]['sumchfsubpodr'];
			}
			// Сууммируем все оплаты по счету-фактуре ($kod)
			$_QRY3 = $db->sql("SELECT SUM(sumoplchfsubpodr) as sumoplata FROM dognet_docoplchfsubpodr WHERE kodchfsubpodr=" . $kod)->fetchAll();
			if ($_QRY3) {
				$__summaopl = $_QRY3[0]['sumoplata'];
			}
			// Суммируем все зачтенные авансы по счету-фактуре ($kod)
			$_QRY4 = $db->sql("SELECT SUM(sumavsubpodr) as sumoplavans FROM dognet_docavsubpodr WHERE kodchfsubpodr=" . $kod)->fetchAll();
			if ($_QRY4) {
				$__sumoplavans = $_QRY4[0]['sumoplavans'];
			}
			// Суммируем все зачтенные авансы по сплиту
			$_QRY41 = $db->sql("SELECT SUM(sumavsplit) as sumsplit FROM dognet_docavsplitsubpodr WHERE kodchfsubpodr=" . $kod)->fetchAll();
			if ($_QRY41) {
				$__sumsplit = $_QRY41[0]['sumsplit'];
			}
			// Считаем текущую задолженность по счету-фактуре ($kod)
			if (($kod === $__kodchfact) and $action == "DEL") {
				$_NEW_sumzadolchfact = $__summachfact - ($__summaopl + $__sumoplavans + ($__sumsplit - $_CHF_OPL_AVS_0));
			} else {
				$_NEW_sumzadolchfact = $__summachfact - ($__summaopl + $__sumoplavans + $__sumsplit);
			}
			// Пишем в таблицу задолженностей счетов-фактур
			// $db->update( 'dognet_kalplanchf_zadol', array(
			// 	'chetfsumzadol'		=>	$_NEW_sumzadolchfact
			// ), array( 'kodchfact' => $kod ));
			// Суммируем общую задолженность по договору
			$_CHF_SUM += $__summachfact;
			$_CHF_OPL_SUM += $__summaopl;
			$_CHF_OPL_AVS_SUM += $__sumoplavans;
			$_CHF_OPL_AVSPLIT_SUM += $__sumsplit;
		}
		// Суммируем все авансы по договору ($_koddoc)
		$_QRY5 = $db->sql("SELECT SUM(sumavsubpodr) as sumavans FROM dognet_docavsubpodr WHERE koddocsubpodr=" . $__koddocsubpodr)->fetchAll();
		if ($_QRY5) {
			$__sumavans = $_QRY5[0]['sumavans'];
		}
		$_CHF_AVS_SUM = $__sumavans;
		// Пишем в основную таблицу договоров общую задолженность по счетам, оплатам и авансам
		// по договору ($_koddoc)
		if ($action == "CRT" or $action == "UPD") {
			$db->update('dognet_docsubpodr', array(
				'sumzadolsubpodr' =>	$_CHF_SUM - ($_CHF_OPL_SUM + $_CHF_OPL_AVS_SUM + $_CHF_OPL_AVSPLIT_SUM)
			), array('koddocsubpodr' => $__koddocsubpodr));
		}
		if ($action == "DEL") {
			$db->update('dognet_docsubpodr', array(
				'sumzadolsubpodr' =>	$_CHF_SUM - ($_CHF_OPL_SUM + $_CHF_OPL_AVS_SUM + ($_CHF_OPL_AVSPLIT_SUM - $_CHF_OPL_AVS_0))
			), array('koddocsubpodr' => $__koddocsubpodr));
		}
	}
	#
	#
	if ($source_tableName == "docoplchfsubpodr") {
		// Выбираем код редактируемого счета-фактуры (kodchfact)
		// из таблицы счетов dognet_kalplanchf
		$_CHF_OPL_0 = 0;
		$_CHF_OPL_AVS_0 = 0;
		$_QRY = $db->sql("SELECT * FROM dognet_docoplchfsubpodr WHERE id=" . $source_rowID)->fetchAll();
		if ($_QRY) {
			$__kodchfact = $_QRY[0]['kodchfsubpodr'];
			$_QRY99 = $db->sql("SELECT koddocsubpodr FROM dognet_docchfsubpodr WHERE kodchfsubpodr=" . $__kodchfact)->fetchAll();
			$__koddocsubpodr = $_QRY99[0]['koddocsubpodr'];
			// Запоминаем сумму оплаты для текущего счета
			$_CHF_OPL_0 = $_QRY[0]['sumoplchfsubpodr'];
		}

		// Выбираем код счета-фактуры
		$_QRY1 = mysqlQuery("SELECT kodchfsubpodr FROM dognet_docchfsubpodr WHERE koddocsubpodr=" . $__koddocsubpodr);
		// Обнуляем счетчики
		$_CHF_SUM = 0;
		$_CHF_OPL_SUM = 0;
		$_CHF_AVS_SUM = 0;
		$_CHF_OPL_AVS_SUM = 0;
		$__summachfact = 0;
		$__summaopl = 0;
		$__sumavans = 0;
		$__sumoplavans = 0;
		// Запускаем цикл по всем счетам-фактурам
		while ($_ROW1 = mysqli_fetch_assoc($_QRY1)) {
			$kod = $_ROW1['kodchfsubpodr'];
			// Выбираем сумму счета-фактуры ($kod)
			$_QRY2 = $db->sql("SELECT sumchfsubpodr FROM dognet_docchfsubpodr WHERE kodchfsubpodr=" . $kod)->fetchAll();
			if ($_QRY2) {
				$__summachfact = $_QRY2[0]['sumchfsubpodr'];
			}
			// Сууммируем все оплаты по счету-фактуре ($kod)
			$_QRY3 = $db->sql("SELECT SUM(sumoplchfsubpodr) as sumoplata FROM dognet_docoplchfsubpodr WHERE kodchfsubpodr=" . $kod)->fetchAll();
			if ($_QRY3) {
				$__summaopl = $_QRY3[0]['sumoplata'];
			}
			// Суммируем все зачтенные авансы по счету-фактуре ($kod)
			$_QRY4 = $db->sql("SELECT SUM(sumavsubpodr) as sumoplavans FROM dognet_docavsubpodr WHERE kodchfsubpodr=" . $kod)->fetchAll();
			if ($_QRY4) {
				$__sumoplavans = $_QRY4[0]['sumoplavans'];
			}
			// Считаем текущую задолженность по счету-фактуре ($kod)
			if (($kod === $__kodchfact) and $action == "DEL") {
				$_NEW_sumzadolchfact = $__summachfact - (($__summaopl - $_CHF_OPL_0) + $__sumoplavans);
			} else {
				$_NEW_sumzadolchfact = $__summachfact - ($__summaopl + $__sumoplavans);
			}
			// Пишем в таблицу задолженностей счетов-фактур
			// $db->update( 'dognet_kalplanchf_zadol', array(
			// 	'chetfsumzadol'		=>	$_NEW_sumzadolchfact
			// ), array( 'kodchfact' => $kod ));
			// Суммируем общую задолженность по договору
			$_CHF_SUM += $__summachfact;
			$_CHF_OPL_SUM += $__summaopl;
			$_CHF_OPL_AVS_SUM += $__sumoplavans;
		}
		// Суммируем все авансы по договору ($_koddoc)
		$_QRY5 = $db->sql("SELECT SUM(sumavsubpodr) as sumavans FROM dognet_docavsubpodr WHERE koddocsubpodr=" . $__koddocsubpodr)->fetchAll();
		if ($_QRY5) {
			$__sumavans = $_QRY5[0]['sumavans'];
		}
		$_CHF_AVS_SUM = $__sumavans;
		// Пишем в основную таблицу договоров общую задолженность по счетам, оплатам и авансам
		// по договору ($__koddocsubpodr)
		if ($action == "CRT" or $action == "UPD") {
			$db->update('dognet_docsubpodr', array(
				'sumzadolsubpodr' =>	$_CHF_SUM - ($_CHF_OPL_SUM + $_CHF_OPL_AVS_SUM)
			), array('koddocsubpodr' => $__koddocsubpodr));
		}
		if ($action == "DEL") {
			$db->update('dognet_docsubpodr', array(
				'sumzadolsubpodr' =>	$_CHF_SUM - (($_CHF_OPL_SUM - $_CHF_OPL_0) + $_CHF_OPL_AVS_SUM)
			), array('koddocsubpodr' => $__koddocsubpodr));
		}
	}
	#
	#
}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#