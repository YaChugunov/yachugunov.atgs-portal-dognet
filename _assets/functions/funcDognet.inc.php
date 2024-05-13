<?php
# Import PHPMailer classes into the global namespace
# These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
#
# Подключаем библиотеки
require $_SERVER['DOCUMENT_ROOT'] . "/dognet/_assets/_PHPMailer/src/Exception.php";
require $_SERVER['DOCUMENT_ROOT'] . "/dognet/_assets/_PHPMailer/src/PHPMailer.php";
require $_SERVER['DOCUMENT_ROOT'] . "/dognet/_assets/_PHPMailer/src/SMTP.php";
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# ::: ФУНКЦИИ
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция добавления новой организации из формы редактора
# ----- ----- -----
function createNewZakaz($neworgname, $msg) {
	$query = mysqlQuery("SELECT MAX(kodzakaz) as lastKod FROM dognet_spzakaz ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastKod = $row['lastKod'];
	$nextKod = $lastKod + rand(3, 33);
	$query1 = mysqlQuery("INSERT INTO dognet_spzakaz (kodzakaz, koddel, namezakshot, namezaklong, zakuraddress, zakbankch, zakdolg, zakfio, zakfistname, zaklastname, zaktelnumber, zakinn, zakkpp, zakaddressfact) VALUES ('$nextKod', '', '$neworgname', '$neworgname', '$msg', '', '', '', '', '', '', '', '', '')");
	return $nextKod;
}
#
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция добавления нового субподрядчика из формы редактора
# ----- ----- -----
function createNewSubpodr($neworgname, $msg) {
	$query = mysqlQuery("SELECT MAX(kodsubpodr) as lastKod FROM dognet_spsubpodr ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastKod = $row['lastKod'];
	$nextKod = $lastKod + rand(3, 33);
	$query1 = mysqlQuery("INSERT INTO dognet_spsubpodr (koddel, kodsubpodr, namesubpodrshot, namesubpodrlong) VALUES ('', '$nextKod', '$neworgname', '$msg')");
	return $nextKod;
}
#
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция определения нового номера этапа (numberstage)
# для таблицы этапов 'dognet_dockalplan'
# ----- ----- -----
function nextKoddocjurnal() {
	$query = mysqlQuery("SELECT MAX(koddocjurnal) as lastKod FROM dognet_docjurnalact ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastKod = $row['lastKod'];
	$nextKod = $lastKod + rand(3, 13);
	return $nextKod;
}
#
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция определения нового номера этапа (numberstage)
# для таблицы этапов 'dognet_dockalplan'
# ----- ----- -----
function nextKoddocjurnal_letter() {
	$query = mysqlQuery("SELECT MAX(koddocjurnal) as lastKod FROM dognet_docjurnallet ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastKod = $row['lastKod'];
	$nextKod = $lastKod + rand(3, 13);
	return $nextKod;
}
#
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция определения нового номера этапа (numberstage)
# для таблицы этапов 'dognet_dockalplan'
# ----- ----- -----
function nextKodkalplan() {
	$query = mysqlQuery("SELECT MAX(kodkalplan) as lastKod FROM dognet_dockalplan ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastKod = $row['lastKod'];
	$nextKod = $lastKod + rand(3, 33);
	return $nextKod;
}
#
#
#
# ----- ----- ----- ----- -----
# ОПИСАНИЕ : Сумма всех оплат счета-фактуры $kodchfsubpodr
function SUMMA_OPLATCHF($kodchfact) {
	$_QRY = mysqlQuery("SELECT SUM(summaopl) as SummaOplatChf FROM dognet_oplatachf WHERE kodchfact='" . $kodchfact . "' AND koddel<>'99'");
	$_ROW = mysqli_fetch_assoc($_QRY);
	if ($_QRY && (mysqli_num_rows($_QRY) > 0)) {
		$__SummaOplatChf = $_ROW['SummaOplatChf'];
	} else {
		$__SummaOplatChf = 0.0;
	}
	return $__SummaOplatChf;
}
#
#
#
# ----- ----- ----- ----- -----
# ОПИСАНИЕ : Сумма всех оплат счета-фактуры $kodchfsubpodr
function SUMMA_OPLATCHF_ONDATE($kodchfact, $ondate) {
	if ($ondate != "" and $ondate != null) {
		$_QRY = mysqlQuery("SELECT SUM(summaopl) as SummaOplatChf FROM dognet_oplatachf WHERE kodchfact='" . $kodchfact . "' AND koddel<>'99' AND dateopl<='" . $ondate . "'");
	} else {
		$_QRY = mysqlQuery("SELECT SUM(summaopl) as SummaOplatChf FROM dognet_oplatachf WHERE kodchfact='" . $kodchfact . "' AND koddel<>'99'");
	}
	$_ROW = mysqli_fetch_assoc($_QRY);
	if ($_QRY && (mysqli_num_rows($_QRY) > 0)) {
		$__SummaOplatChf = $_ROW['SummaOplatChf'];
	} else {
		$__SummaOplatChf = 0.0;
	}
	return $__SummaOplatChf;
}
#
#
# ----- ----- ----- ----- -----
#	ОПИСАНИЕ : Сумма всех авансов зачтенных в счет-фактуру $kodchfact
#
#
function SUMMA_AVANSCHF($kodchfact) {
	$_QRY = mysqlQuery("SELECT SUM(summaoplav) as SummaAvansChf FROM dognet_chfavans WHERE kodchfact='" . $kodchfact . "' AND koddel<>'99'");
	$_ROW = mysqli_fetch_assoc($_QRY);
	if ($_QRY && (mysqli_num_rows($_QRY) > 0)) {
		$__SummaAvansChf = $_ROW['SummaAvansChf'];
	} else {
		$__SummaAvansChf = 0.0;
	}
	return $__SummaAvansChf;
}
#
#
# ----- ----- ----- ----- -----
#	ОПИСАНИЕ : Сумма всех авансов зачтенных в счет-фактуру $kodchfact (НА ДАТУ)
#
#
function SUMMA_AVANSCHF_ONDATE($kodchfact, $ondate) {
	if ($ondate != "" and $ondate != null) {
		$_QRY = mysqlQuery("SELECT SUM(summaoplav) as SummaAvansChf FROM dognet_chfavans WHERE kodchfact='" . $kodchfact . "' AND koddel<>'99' AND dateoplav<='" . $ondate . "'");
	} else {
		$_QRY = mysqlQuery("SELECT SUM(summaoplav) as SummaAvansChf FROM dognet_chfavans WHERE kodchfact='" . $kodchfact . "' AND koddel<>'99'");
	}
	$_ROW = mysqli_fetch_assoc($_QRY);
	if ($_QRY && (mysqli_num_rows($_QRY) > 0)) {
		$__SummaAvansChf = $_ROW['SummaAvansChf'];
	} else {
		$__SummaAvansChf = 0.0;
	}
	return $__SummaAvansChf;
}
#
#
# ----- ----- ----- ----- -----
#	ОПИСАНИЕ : Сумма всех авансов зачтенных в счет-фактуру $kodchfact
#
#
function DOCBASE_FN_SUM_AVANSCHF_CHETF($kodchfact) {
	$_QRY = mysqlQuery("SELECT SUM(summaoplav) as SummaAvansChf FROM dognet_chfavans WHERE kodchfact=" . $kodchfact);
	$_ROW = mysqli_fetch_assoc($_QRY);
	if ($_QRY) {
		$__SummaAvansChf = $_ROW['SummaAvansChf'];
	} else {
		$__SummaAvansChf = "";
	}
	return $__SummaAvansChf;
}
#
#
# ----- ----- ----- ----- -----
#	ОПИСАНИЕ : Сумма всех оплат счета-фактуры $kodchfact
#
#
function DOCBASE_FN_SUM_OPLATCHF_CHETF($kodchfact) {
	$_QRY = mysqlQuery("SELECT SUM(summaopl) as SummaOplatChf FROM dognet_oplatachf WHERE kodchfact=" . $kodchfact);
	$_ROW = mysqli_fetch_assoc($_QRY);
	if ($_QRY) {
		$__SummaOplatChf = $_ROW['SummaOplatChf'];
	} else {
		$__SummaOplatChf = 0.0;
	}
	return $__SummaOplatChf;
}
#
#
# ----- ----- ----- ----- -----
#	ОПИСАНИЕ : Сумма всех этапов по договору $koddoc
#
#
function DOCBASE_FN_SUM_STAGES_DOC($koddoc) {
	$_QRY = mysqlQuery("SELECT SUM(summastage) as SumAllStages FROM dognet_dockalplan WHERE koddoc=" . $koddoc);
	$_ROW = mysqli_fetch_assoc($_QRY);
	if ($_QRY) {
		$__SumAllStages = $_ROW['SumAllStages'];
	} else {
		$__SumAllStages = 0.0;
	}
	return $__SumAllStages;
}
#
#
# ----- ----- ----- ----- -----
#	ОПИСАНИЕ : Сумма всех авансов по этапу $kodkalplan
#
#
function DOCBASE_FN_SUM_AVANS_STAGE($kodkalplan) {
	$_QRY = mysqlQuery("SELECT SUM(summaavans) as SumAllAvans FROM dognet_docavans WHERE koddoc=" . $kodkalplan);
	$_ROW = mysqli_fetch_assoc($_QRY);
	if ($_QRY) {
		$__SumAllAvans = $_ROW['SumAllAvans'];
	} else {
		$__SumAllAvans = "";
	}
	return $__SumAllAvans;
}
#
#
# ----- ----- ----- ----- -----
# ОПИСАНИЕ : Сумма всех выставленных счетов-фактур по этапу $kodkalplan
#
#
function DOCBASE_FN_SUM_CHF_STAGE($kodkalplan) {
	$_QRY = mysqlQuery("SELECT SUM(chetfsumma) as SumChf FROM dognet_kalplanchf WHERE kodkalplan=" . $kodkalplan);
	$_ROW = mysqli_fetch_assoc($_QRY);
	if ($_QRY) {
		$__SummaChf = $_ROW['SumChf'];
	} else {
		$__SummaChf = "";
	}
	return $__SummaChf;
}
#
#
# ----- ----- ----- ----- -----
#	ОПИСАНИЕ : Сумма всех оплат по этапу $kodkalplan
#
#
function DOCBASE_FN_SUM_OPLATCHF_STAGE($kodkalplan) {
	$_QRY = mysqlQuery("SELECT kodchfact FROM dognet_kalplanchf WHERE kodkalplan=" . $kodkalplan);
	if ($_QRY) {
		$_sumOplata = 0;
		while ($_ROW = mysqli_fetch_assoc($_QRY)) {
			$_kodchfact = $_ROW['kodchfact'];
			$_SUBQRY1 = mysqlQuery("SELECT SUM(summaopl) as sumoplchf FROM dognet_oplatachf WHERE kodchfact=" . $_kodchfact);
			$_SUBROW1 = mysqli_fetch_assoc($_SUBQRY1);
			$_sumOplata += $_SUBROW1['sumoplchf'];
		}
	} else {
		$_sumOplata = "";
	}
	return $_sumOplata;
}
#
#
# ----- ----- ----- ----- -----
#	ОПИСАНИЕ : Сумма всех зачтенных авансов по этапу $kodkalplan
#
#
function DOCBASE_FN_SUM_AVANSCHF_STAGE($kodkalplan) {
	$_QRY = mysqlQuery("SELECT kodchfact FROM dognet_kalplanchf WHERE kodkalplan=" . $kodkalplan);
	if ($_QRY) {
		$_sumAvansChf = 0;
		while ($_ROW = mysqli_fetch_assoc($_QRY)) {
			$_kodchfact = $_ROW['kodchfact'];
			$_SUBQRY1 = mysqlQuery("SELECT SUM(summaoplav) as sumoplav FROM dognet_chfavans WHERE kodchfact=" . $_kodchfact);
			$_SUBROW1 = mysqli_fetch_assoc($_SUBQRY1);
			$_sumAvansChf += $_SUBROW1['sumoplav'];
		}
	} else {
		$_sumAvansChf = "";
	}
	return $_sumAvansChf;
}
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# ::: ПРОЦЕДУРЫ
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# ОПРЕДЕЛЕНИЕ ОБЩЕЙ ЗАДОЛЖЕННОСТИ ПО ВСЕМ СЧЕТАМ-ФАКТУРАМ И СУММА НЕЗАКРЫТИЯ ПО АВАНСАМ ДОГОВОРА
# + $koddoc - ID договора
# + $action - кнопка вызова процедуры (New, Edit, Delete)
# + $kodshab - шаблон договора, с календарным планом (1) или без (2)
# + $source_rowID - ID строки исходных данных источника
# + $source_tableName - имя таблицы-источника
# + $db - драйвер БД
#
function DOCBASE_PR_ZADOLG_DOC($db, $source_tableName, $source_rowID, $action, $koddoc, $kodshab) {
	#
	#
	if ($source_tableName == "kalplanchf") {
		// Выбираем код редактируемого счета-фактуры (kodchfact)
		// из таблицы счетов dognet_kalplanchf
		$_CHF_OPL_0 = 0;
		$_CHF_OPL_AVS_0 = 0;
		$_QRY = $db->sql("SELECT * FROM dognet_kalplanchf WHERE id=" . $source_rowID)->fetchAll();
		if ($_QRY) {
			$__kodchfact = $_QRY[0]['kodchfact'];
			$__numchfact = $_QRY[0]['chetfnumber'];
			// Запоминаем сумму счета для текущей записи
			$_CHF_0 = $_QRY[0]['chetfsumma'];
			// Запоминаем сумму оплаты для текущего счета
			$_QRY_CHF_OPL_0 = mysqlQuery("SELECT SUM(summaopl) as sum1 FROM dognet_oplatachf WHERE kodchfact=" . $__kodchfact);
			$_ROW_CHF_OPL_0 = mysqli_fetch_assoc($_QRY_CHF_OPL_0);
			// $_CHF_OPL_SUM = $_ROW_CHF_OPL_0['sum1'];
			// >>>
			// Редакция от 12.01.2024
			$_CHF_OPL_0 = $_ROW_CHF_OPL_0['sum1'];
			// <<<
			// Запоминаем сумму зачтенного аванса для текущего счета
			$_QRY_CHF_OPL_AVS_0 = mysqlQuery("SELECT SUM(summaoplav) as sum2 FROM dognet_chfavans WHERE kodchfact=" . $__kodchfact);
			$_ROW_CHF_OPL_AVS_0 = mysqli_fetch_assoc($_QRY_CHF_OPL_AVS_0);
			$_CHF_OPL_AVS_0 = $_ROW_CHF_OPL_AVS_0['sum2'];
		}
		#
		# ----- ----- ----- ----- -----
		#
		// Если договор создан с календарным планом (kodshab=1)
		if ($kodshab == 1 || $kodshab == 3) {
			// Выбираем код этапа (kodkalplan) из таблицы календарных планов (этапов)
			// для выбранного выше договора ($_koddoc)
			$_QRY1 = mysqlQuery("SELECT kodkalplan FROM dognet_dockalplan WHERE koddoc=" . $koddoc);
			if ($_QRY1) {
				// Обнуляем счетчики
				$_CHF_SUM = 0;
				$_CHF_OPL_SUM = 0;
				$_CHF_AVS_SUM = 0;
				$_CHF_OPL_AVS_SUM = 0;
				// Запускаем цикл по всем кодам этапов
				while ($_ROW1 = mysqli_fetch_assoc($_QRY1)) {
					// Выбираем код счета-фактуры
					$_QRY2 = mysqlQuery("SELECT kodchfact, chetfnumber FROM dognet_kalplanchf WHERE kodkalplan=" . $_ROW1['kodkalplan']);
					// Обнуляем счетчики
					$__summachfact = 0;
					$__summaopl = 0;
					$__sumavans = 0;
					$__sumoplavans = 0;
					// Запускаем цикл по всем счетам-фактурам
					while ($_ROW2 = mysqli_fetch_assoc($_QRY2)) {
						$kod = $_ROW2['kodchfact'];
						// Выбираем сумму счета-фактуры ($kod)
						$_QRY3 = $db->sql("SELECT SUM(chetfsumma) as chfsum FROM dognet_kalplanchf WHERE kodchfact=" . $kod)->fetchAll();
						if ($_QRY3) {
							$__summachfact = $_QRY3[0]['chfsum'];
						}
						// Сууммируем все оплаты по счету-фактуре ($kod)
						$_QRY4 = $db->sql("SELECT SUM(summaopl) as sumoplata FROM dognet_oplatachf WHERE kodchfact=" . $kod)->fetchAll();
						if ($_QRY4) {
							$__summaopl = $_QRY4[0]['sumoplata'];
						}
						// Суммируем все зачтенные авансы по счету-фактуре ($kod)
						$_QRY5 = $db->sql("SELECT SUM(summaoplav) as sumoplavans FROM dognet_chfavans WHERE kodchfact=" . $kod)->fetchAll();
						if ($_QRY5) {
							$__sumoplavans = $_QRY5[0]['sumoplavans'];
						}
						// Считаем текущую задолженность по счету-фактуре ($kod)
						if (($kod === $__kodchfact) and $action == "DEL") {
							$_NEW_sumzadolchfact = ($__summachfact - $_CHF_0) - ($__summaopl + $__sumoplavans);
						} else {
							$_NEW_sumzadolchfact = $__summachfact - ($__summaopl + $__sumoplavans);
						}
						// Пишем в таблицу задолженностей счетов-фактур
						$db->update('dognet_kalplanchf_zadol', array(
							'chetfsumzadol'		=>	$_NEW_sumzadolchfact
						), array('kodchfact' => $kod));
						// Суммируем общую задолженность по договору
						$_CHF_SUM += $__summachfact;
						$_CHF_OPL_SUM += $__summaopl;
						$_CHF_OPL_AVS_SUM += $__sumoplavans;
					}
					// Суммируем все авансы по договору ($_koddoc)
					$_QRY6 = $db->sql("SELECT SUM(summaavans) as sumavans FROM dognet_docavans WHERE koddoc=" . $_ROW1['kodkalplan'])->fetchAll();
					if ($_QRY6) {
						$__sumavans = $_QRY6[0]['sumavans'];
					}
					$_CHF_AVS_SUM += $__sumavans;
				}

				// Формируем "текущий" статус задолженности, если таковая имеется
				$_QRY_KZ = $db->sql("SELECT kodstatuszdl FROM dognet_docbase WHERE koddoc=" . $koddoc)->fetchAll();
				$_KODSTATUSZDL = $_QRY_KZ[0]['kodstatuszdl'];
				$_KODSTATUSZDL_0 = $_QRY_KZ[0]['kodstatuszdl'];
				// -----

				// Пишем в основную таблицу договоров общую задолженность по счетам, оплатам и авансам
				// по договору ($_koddoc)
				if ($action == "CRT") {
					if ($_KODSTATUSZDL <= 1) {
						$_KODSTATUSZDL = ((($_CHF_SUM + $_CHF_0) - ($_CHF_OPL_SUM + $_CHF_OPL_0) - ($_CHF_OPL_AVS_SUM + $_CHF_OPL_AVS_0)) != 0) ? 1 : 0;
					}
					$db->update('dognet_docbase', array(
						'summachf' => $_CHF_SUM + $_CHF_0,
						'docoplata' => $_CHF_OPL_SUM + $_CHF_OPL_0,
						'doczadol' => ($_CHF_SUM + $_CHF_0) - ($_CHF_OPL_SUM + $_CHF_OPL_0) - ($_CHF_OPL_AVS_SUM + $_CHF_OPL_AVS_0),
						'docavans' => $_CHF_AVS_SUM,
						'docnozak' => $_CHF_AVS_SUM - ($_CHF_OPL_AVS_SUM + $_CHF_OPL_AVS_0),
						'kodstatuszdl' => $_KODSTATUSZDL
					), array('koddoc' => $koddoc));
					//
					//
					$db->insert('dognet_testingDocStatusZadol', array(
						'koddoc'		=> $koddoc,
						'timestamp'		=> date('Y-m-d H:i:s'),
						'userID'		=> $_SESSION['id'],
						'userName'		=> $_SESSION['lastname'],
						'action'		=> 'CRT',
						'actionTable'	=> $source_tableName,
						'actionDesc'	=> 'Добавлен новый СФ ( ' . $__numchfact . ' ) в договор с этапами (kodshab = 1,3)',
						'kodchfact'		=> $__kodchfact,
						'numchfact'		=> $__numchfact,
						'kodoplata'		=> 'Нет',
						'kodchfavans'	=> 'Нет',
						'sumChf_1'		=> $_CHF_SUM + $_CHF_0,
						'sumOplChf_1'	=> $_CHF_OPL_SUM + $_CHF_OPL_0,
						'sumOplAvChf_1'	=> $_CHF_OPL_AVS_SUM + $_CHF_OPL_AVS_0,
						'docZadol_1'	=> ($_CHF_SUM + $_CHF_0) - ($_CHF_OPL_SUM + $_CHF_OPL_0) - ($_CHF_OPL_AVS_SUM + $_CHF_OPL_AVS_0),
						'statusZadol_1'	=> $_KODSTATUSZDL
					));
					//
					//
				}
				if ($action == "UPD") {
					if ($_KODSTATUSZDL <= 1) {
						$_KODSTATUSZDL = (($_CHF_SUM - ($_CHF_OPL_SUM + $_CHF_OPL_AVS_SUM)) != 0) ? 1 : 0;
					}
					$db->update('dognet_docbase', array(
						'summachf' => $_CHF_SUM,
						'docoplata' => $_CHF_OPL_SUM,
						'doczadol' =>	$_CHF_SUM - ($_CHF_OPL_SUM + $_CHF_OPL_AVS_SUM),
						'docavans' => $_CHF_AVS_SUM,
						'docnozak' => $_CHF_AVS_SUM - $_CHF_OPL_AVS_SUM,
						'kodstatuszdl' => $_KODSTATUSZDL
					), array('koddoc' => $koddoc));
					//
					//
					$db->insert('dognet_testingDocStatusZadol', array(
						'koddoc'		=> $koddoc,
						'timestamp'		=> date('Y-m-d H:i:s'),
						'userID'		=> $_SESSION['id'],
						'userName'		=> $_SESSION['lastname'],
						'action'		=> 'UPD',
						'actionTable'	=> $source_tableName,
						'actionDesc'	=> 'Изменен СФ ( ' . $__numchfact . ' ) в договоре с этапами (kodshab = 1,3)',
						'kodchfact'		=> $__kodchfact,
						'numchfact'		=> $__numchfact,
						'kodoplata'		=> 'Нет',
						'kodchfavans'	=> 'Нет',
						'sumChf_1'		=> $_CHF_SUM,
						'sumOplChf_1'	=> $_CHF_OPL_SUM,
						'sumOplAvChf_1'	=> $_CHF_OPL_AVS_SUM,
						'docZadol_1'	=> $_CHF_SUM - ($_CHF_OPL_SUM + $_CHF_OPL_AVS_SUM),
						'statusZadol_1'	=> $_KODSTATUSZDL
					));
					//
					//
				}
				if ($action == "DEL") {
					if ($_KODSTATUSZDL <= 1) {
						$_KODSTATUSZDL = ((($_CHF_SUM - $_CHF_0) - ($_CHF_OPL_SUM + $_CHF_OPL_AVS_SUM)) != 0) ? 1 : 0;
					}
					$db->update('dognet_docbase', array(
						'summachf' => $_CHF_SUM - $_CHF_0,
						'docoplata' => $_CHF_OPL_SUM,
						'doczadol' => ($_CHF_SUM - $_CHF_0) - ($_CHF_OPL_SUM + $_CHF_OPL_AVS_SUM),
						'docavans' => $_CHF_AVS_SUM,
						'docnozak' => $_CHF_AVS_SUM - $_CHF_OPL_AVS_SUM,
						'kodstatuszdl' => $_KODSTATUSZDL
					), array('koddoc' => $koddoc));
					//
					//
					$db->insert('dognet_testingDocStatusZadol', array(
						'koddoc'		=> $koddoc,
						'timestamp'		=> date('Y-m-d H:i:s'),
						'userID'		=> $_SESSION['id'],
						'userName'		=> $_SESSION['lastname'],
						'action'		=> 'DEL',
						'actionTable'	=> $source_tableName,
						'actionDesc'	=> 'Удален СФ ( ' . $__numchfact . ' ) в договоре с этапами (kodshab = 1,3)',
						'kodchfact'		=> $__kodchfact,
						'numchfact'		=> $__numchfact,
						'kodoplata'		=> 'Нет',
						'kodchfavans'	=> 'Нет',
						'sumChf_1'		=> $_CHF_SUM - $_CHF_0,
						'sumOplChf_1'	=> $_CHF_OPL_SUM,
						'sumOplAvChf_1'	=> $_CHF_OPL_AVS_SUM,
						'docZadol_1'	=> ($_CHF_SUM - $_CHF_0) - ($_CHF_OPL_SUM + $_CHF_OPL_AVS_SUM),
						'statusZadol_1'	=> $_KODSTATUSZDL
					));
					//
					//
				}
			}
		}
		#
		# ----- ----- ----- ----- -----
		#
		// Если договор создан без календарного плана (kodshab=2)
		if ($kodshab != 1 && $kodshab != 3) {
			// ВАЖНО!!
			// В случае договора без календарного плана в таблице этапов
			// под кодом этапа (kodkalplan) хранится код самого договора (koddoc)
			//
			// Выбираем код счета-фактуры
			$_QRY1 = mysqlQuery("SELECT kodchfact FROM dognet_kalplanchf WHERE kodkalplan=" . $koddoc);
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
				$kod = $_ROW1['kodchfact'];
				// Выбираем сумму счета-фактуры ($kod)
				$_QRY2 = $db->sql("SELECT chetfsumma FROM dognet_kalplanchf WHERE kodchfact=" . $kod)->fetchAll();
				if ($_QRY2) {
					$__summachfact = $_QRY2[0]['chetfsumma'];
				}
				// Сууммируем все оплаты по счету-фактуре ($kod)
				$_QRY3 = $db->sql("SELECT SUM(summaopl) as sumoplata FROM dognet_oplatachf WHERE kodchfact=" . $kod)->fetchAll();
				if ($_QRY3) {
					$__summaopl = $_QRY3[0]['sumoplata'];
				}
				// Суммируем все зачтенные авансы по счету-фактуре ($kod)
				$_QRY4 = $db->sql("SELECT SUM(summaoplav) as sumoplavans FROM dognet_chfavans WHERE kodchfact=" . $kod)->fetchAll();
				if ($_QRY4) {
					$__sumoplavans = $_QRY4[0]['sumoplavans'];
				}
				// Считаем текущую задолженность по счету-фактуре ($kod)
				$_NEW_sumzadolchfact = $__summachfact - ($__summaopl + $__sumoplavans);
				// Пишем в таблицу задолженностей счетов-фактур
				$db->update('dognet_kalplanchf_zadol', array(
					'chetfsumzadol'		=>	$_NEW_sumzadolchfact
				), array('kodchfact' => $kod));
				// Суммируем общую задолженность по договору
				$_CHF_SUM += $__summachfact;
				$_CHF_OPL_SUM += $__summaopl;
				$_CHF_OPL_AVS_SUM += $__sumoplavans;
			}
			// Суммируем все авансы по договору ($_koddoc)
			$_QRY5 = $db->sql("SELECT SUM(summaavans) as sumavans FROM dognet_docavans WHERE koddoc=" . $koddoc)->fetchAll();
			if ($_QRY5) {
				$__sumavans = $_QRY5[0]['sumavans'];
			}
			$_CHF_AVS_SUM = $__sumavans;

			// Формируем "текущий" статус задолженности, если таковая имеется
			$_QRY_KZ = $db->sql("SELECT kodstatuszdl FROM dognet_docbase WHERE koddoc=" . $koddoc)->fetchAll();
			$_KODSTATUSZDL = $_QRY_KZ[0]['kodstatuszdl'];
			// -----

			// Пишем в основную таблицу договоров общую задолженность по счетам, оплатам и авансам
			// по договору ($_koddoc)
			if ($action == "CRT") {
				if ($_KODSTATUSZDL <= 1) {
					$_KODSTATUSZDL = ((($_CHF_SUM + $_CHF_0) - ($_CHF_OPL_SUM + $_CHF_OPL_0) - ($_CHF_OPL_AVS_SUM + $_CHF_OPL_AVS_0)) != 0) ? 1 : 0;
				}
				$db->update('dognet_docbase', array(
					'summachf' => $_CHF_SUM + $_CHF_0,
					'docoplata' => $_CHF_OPL_SUM + $_CHF_OPL_0,
					'doczadol' => ($_CHF_SUM + $_CHF_0) - ($_CHF_OPL_SUM + $_CHF_OPL_0) - ($_CHF_OPL_AVS_SUM + $_CHF_OPL_AVS_0),
					'docavans' => $_CHF_AVS_SUM,
					'docnozak' => $_CHF_AVS_SUM - ($_CHF_OPL_AVS_SUM + $_CHF_OPL_AVS_0),
					'kodstatuszdl' => $_KODSTATUSZDL
				), array('koddoc' => $koddoc));
				//
				//
				$db->insert('dognet_testingDocStatusZadol', array(
					'koddoc'		=> $koddoc,
					'timestamp'		=> date('Y-m-d H:i:s'),
					'userID'		=> $_SESSION['id'],
					'userName'		=> $_SESSION['lastname'],
					'action'		=> 'CRT',
					'actionTable'	=> $source_tableName,
					'actionDesc'	=> 'Добавлен СФ ( ' . $__numchfact . ' ) в договор без этапов (kodshab = 2,4)',
					'kodchfact'		=> $__kodchfact,
					'numchfact'		=> $__numchfact,
					'kodoplata'		=> 'Нет',
					'kodchfavans'	=> 'Нет',
					'sumChf_1'		=> $_CHF_SUM + $_CHF_0,
					'sumOplChf_1'	=> $_CHF_OPL_SUM + $_CHF_OPL_0,
					'sumOplAvChf_1'	=> $_CHF_OPL_AVS_SUM + $_CHF_OPL_AVS_0,
					'docZadol_1'	=> ($_CHF_SUM + $_CHF_0) - ($_CHF_OPL_SUM + $_CHF_OPL_0) - ($_CHF_OPL_AVS_SUM + $_CHF_OPL_AVS_0),
					'statusZadol_1'	=> $_KODSTATUSZDL
				));
				//
				//
			}
			if ($action == "UPD") {
				if ($_KODSTATUSZDL <= 1) {
					$_KODSTATUSZDL = (($_CHF_SUM - ($_CHF_OPL_SUM + $_CHF_OPL_AVS_SUM)) != 0) ? 1 : 0;
				}
				$db->update('dognet_docbase', array(
					'summachf' => $_CHF_SUM,
					'docoplata' => $_CHF_OPL_SUM,
					'doczadol' =>	$_CHF_SUM - ($_CHF_OPL_SUM + $_CHF_OPL_AVS_SUM),
					'docavans' => $_CHF_AVS_SUM,
					'docnozak' => $_CHF_AVS_SUM - $_CHF_OPL_AVS_SUM,
					'kodstatuszdl' => $_KODSTATUSZDL
				), array('koddoc' => $koddoc));
				//
				//
				$db->insert('dognet_testingDocStatusZadol', array(
					'koddoc'		=> $koddoc,
					'timestamp'		=> date('Y-m-d H:i:s'),
					'userID'		=> $_SESSION['id'],
					'userName'		=> $_SESSION['lastname'],
					'action'		=> 'UPD',
					'actionTable'	=> $source_tableName,
					'actionDesc'	=> 'Изменен СФ ( ' . $__numchfact . ' ) в договоре без этапов (kodshab = 2,4)',
					'kodchfact'		=> $__kodchfact,
					'numchfact'		=> $__numchfact,
					'kodoplata'		=> 'Нет',
					'kodchfavans'	=> 'Нет',
					'sumChf_1'		=> $_CHF_SUM,
					'sumOplChf_1'	=> $_CHF_OPL_SUM,
					'sumOplAvChf_1'	=> $_CHF_OPL_AVS_SUM,
					'docZadol_1'	=> $_CHF_SUM - ($_CHF_OPL_SUM + $_CHF_OPL_AVS_SUM),
					'statusZadol_1'	=> $_KODSTATUSZDL
				));
				//
				//
			}
			if ($action == "DEL") {
				if ($_KODSTATUSZDL <= 1) {
					$_KODSTATUSZDL = ((($_CHF_SUM - $_CHF_0) - ($_CHF_OPL_SUM + $_CHF_OPL_AVS_SUM)) != 0) ? 1 : 0;
				}
				$db->update('dognet_docbase', array(
					'summachf' => $_CHF_SUM - $_CHF_0,
					'docoplata' => $_CHF_OPL_SUM,
					'doczadol' => ($_CHF_SUM - $_CHF_0) - ($_CHF_OPL_SUM + $_CHF_OPL_AVS_SUM),
					'docavans' => $_CHF_AVS_SUM,
					'docnozak' => $_CHF_AVS_SUM - $_CHF_OPL_AVS_SUM,
					'kodstatuszdl' => $_KODSTATUSZDL
				), array('koddoc' => $koddoc));
				//
				//
				$db->insert('dognet_testingDocStatusZadol', array(
					'koddoc'		=> $koddoc,
					'timestamp'		=> date('Y-m-d H:i:s'),
					'userID'		=> $_SESSION['id'],
					'userName'		=> $_SESSION['lastname'],
					'action'		=> 'DEL',
					'actionTable'	=> $source_tableName,
					'actionDesc'	=> 'Удален СФ ( ' . $__numchfact . ' ) в договоре без этапов (kodshab = 2,4)',
					'kodchfact'		=> $__kodchfact,
					'numchfact'		=> $__numchfact,
					'kodoplata'		=> 'Нет',
					'kodchfavans'	=> 'Нет',
					'sumChf_1'		=> $_CHF_SUM - $_CHF_0,
					'sumOplChf_1'	=> $_CHF_OPL_SUM,
					'sumOplAvChf_1'	=> $_CHF_OPL_AVS_SUM,
					'docZadol_1'	=> ($_CHF_SUM - $_CHF_0) - ($_CHF_OPL_SUM + $_CHF_OPL_AVS_SUM),
					'statusZadol_1'	=> $_KODSTATUSZDL
				));
				//
				//
			}
		}
		#
		#
	}
	#
	#
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	#
	#
	if ($source_tableName == "oplatachf") {
		// Выбираем код редактируемого счета-фактуры (kodchfact)
		// из таблицы счетов dognet_kalplanchf
		$_CHF_OPL_0 = 0;
		$_CHF_OPL_AVS_0 = 0;
		$__kodchfact = "";
		$__kodoplata = "";
		$__numchfact = "";
		$_QRY = $db->sql("SELECT * FROM dognet_oplatachf WHERE id=" . $source_rowID)->fetchAll();
		if ($_QRY) {
			$__kodchfact = $_QRY[0]['kodchfact'];
			$__kodoplata = $_QRY[0]['kodoplata'];
			// Запоминаем сумму оплаты для текущего счета
			$_CHF_OPL_0 = $_QRY[0]['summaopl'];
			$_QRY1 = $db->sql("SELECT chetfnumber FROM dognet_kalplanchf WHERE kodchfact=" . $__kodchfact)->fetchAll();
			if ($_QRY1) {
				$__numchfact = $_QRY1[0]['chetfnumber'];
			}
		}
		#
		# ----- ----- ----- ----- -----
		#
		// Если договор создан с календарным планом (kodshab=1)
		if ($kodshab == 1 || $kodshab == 3) {
			// Выбираем код этапа (kodkalplan) из таблицы календарных планов (этапов)
			// для выбранного выше договора ($_koddoc)
			$_QRY1 = mysqlQuery("SELECT kodkalplan FROM dognet_dockalplan WHERE koddoc=" . $koddoc);
			if ($_QRY1) {
				// Обнуляем счетчики
				$_CHF_SUM = 0;
				$_CHF_OPL_SUM = 0;
				$_CHF_AVS_SUM = 0;
				$_CHF_OPL_AVS_SUM = 0;
				// Запускаем цикл по всем кодам этапов
				while ($_ROW1 = mysqli_fetch_assoc($_QRY1)) {
					// Выбираем код счета-фактуры
					$_QRY2 = mysqlQuery("SELECT kodchfact FROM dognet_kalplanchf WHERE kodkalplan=" . $_ROW1['kodkalplan']);
					// Обнуляем счетчики
					$__summachfact = 0;
					$__summaopl = 0;
					$__sumavans = 0;
					$__sumoplavans = 0;
					// Запускаем цикл по всем счетам-фактурам
					while ($_ROW2 = mysqli_fetch_assoc($_QRY2)) {
						$kod = $_ROW2['kodchfact'];
						// Выбираем сумму счета-фактуры ($kod)
						$_QRY3 = $db->sql("SELECT SUM(chetfsumma) as chfsum FROM dognet_kalplanchf WHERE kodchfact=" . $kod)->fetchAll();
						if ($_QRY3) {
							$__summachfact = $_QRY3[0]['chfsum'];
						}
						// Сууммируем все оплаты по счету-фактуре ($kod)
						$_QRY4 = $db->sql("SELECT SUM(summaopl) as sumoplata FROM dognet_oplatachf WHERE kodchfact=" . $kod)->fetchAll();
						if ($_QRY4) {
							$__summaopl = $_QRY4[0]['sumoplata'];
						}
						// Суммируем все зачтенные авансы по счету-фактуре ($kod)
						$_QRY5 = $db->sql("SELECT SUM(summaoplav) as sumoplavans FROM dognet_chfavans WHERE kodchfact=" . $kod)->fetchAll();
						if ($_QRY5) {
							$__sumoplavans = $_QRY5[0]['sumoplavans'];
						}
						// Считаем текущую задолженность по счету-фактуре ($kod)
						if (($kod === $__kodchfact) and $action == "DEL") {
							$_NEW_sumzadolchfact = $__summachfact - (($__summaopl - $_CHF_OPL_0) + $__sumoplavans);
						} else {
							$_NEW_sumzadolchfact = $__summachfact - ($__summaopl + $__sumoplavans);
						}
						// Пишем в таблицу задолженностей счетов-фактур
						$db->update('dognet_kalplanchf_zadol', array(
							'chetfsumzadol'		=>	$_NEW_sumzadolchfact
						), array('kodchfact' => $kod));
						// Суммируем общую задолженность по договору
						$_CHF_SUM += $__summachfact;
						$_CHF_OPL_SUM += $__summaopl;
						$_CHF_OPL_AVS_SUM += $__sumoplavans;
					}
					// Суммируем все авансы по договору ($_koddoc)
					$_QRY6 = $db->sql("SELECT SUM(summaavans) as sumavans FROM dognet_docavans WHERE koddoc=" . $_ROW1['kodkalplan'])->fetchAll();
					if ($_QRY6) {
						$__sumavans = $_QRY6[0]['sumavans'];
					}
					$_CHF_AVS_SUM += $__sumavans;
				}

				// Формируем "текущий" статус задолженности, если таковая имеется
				$_QRY_KZ = $db->sql("SELECT kodstatuszdl FROM dognet_docbase WHERE koddoc=" . $koddoc)->fetchAll();
				$_KODSTATUSZDL = $_QRY_KZ[0]['kodstatuszdl'];
				// -----

				// Пишем в основную таблицу договоров общую задолженность по счетам, оплатам и авансам
				// по договору ($_koddoc)
				if ($action == "CRT" or $action == "UPD") {
					if ($_KODSTATUSZDL <= 1) {
						$_KODSTATUSZDL = (($_CHF_SUM - ($_CHF_OPL_SUM + $_CHF_OPL_AVS_SUM)) != 0) ? 1 : 0;
					}
					$db->update('dognet_docbase', array(
						'summachf' => $_CHF_SUM,
						'docoplata' => $_CHF_OPL_SUM,
						'doczadol' =>	$_CHF_SUM - ($_CHF_OPL_SUM + $_CHF_OPL_AVS_SUM),
						'docavans' => $_CHF_AVS_SUM,
						'docnozak' => $_CHF_AVS_SUM - $_CHF_OPL_AVS_SUM,
						'kodstatuszdl' => $_KODSTATUSZDL
					), array('koddoc' => $koddoc));
					//
					//
					$actionDesc1 = $action == "CRT" ? "Добавлена" : "Изменена";
					$actionDesc2 = $action == "CRT" ? "в договор" : "в договоре";
					$db->insert('dognet_testingDocStatusZadol', array(
						'koddoc'		=> $koddoc,
						'timestamp'		=> date('Y-m-d H:i:s'),
						'userID'		=> $_SESSION['id'],
						'userName'		=> $_SESSION['lastname'],
						'action'		=> $action,
						'actionTable'	=> $source_tableName,
						'actionDesc'	=> $actionDesc1 . ' оплата СФ ( ' . $__numchfact . ' ) ' . $actionDesc2 . ' с этапами (kodshab = 1,3)',
						'kodchfact'		=> $__kodchfact,
						'numchfact'		=> $__numchfact,
						'kodoplata'		=> $__kodoplata,
						'kodchfavans'	=> 'Нет',
						'sumChf_1'		=> $_CHF_SUM,
						'sumOplChf_1'	=> $_CHF_OPL_SUM,
						'sumOplAvChf_1'	=> $_CHF_OPL_AVS_SUM,
						'docZadol_1'	=> $_CHF_SUM - ($_CHF_OPL_SUM + $_CHF_OPL_AVS_SUM),
						'statusZadol_1'	=> $_KODSTATUSZDL
					));
					//
					//
				}
				if ($action == "DEL") {
					$db->update('dognet_docbase', array(
						'summachf' => $_CHF_SUM,
						'docoplata' => $_CHF_OPL_SUM - $_CHF_OPL_0,
						'doczadol' =>	$_CHF_SUM - (($_CHF_OPL_SUM - $_CHF_OPL_0) + $_CHF_OPL_AVS_SUM),
						'docavans' => $_CHF_AVS_SUM,
						'docnozak' => $_CHF_AVS_SUM - $_CHF_OPL_AVS_SUM,
						'kodstatuszdl' => $_KODSTATUSZDL
					), array('koddoc' => $koddoc));
					//
					//
					$db->insert('dognet_testingDocStatusZadol', array(
						'koddoc'		=> $koddoc,
						'timestamp'		=> date('Y-m-d H:i:s'),
						'userID'		=> $_SESSION['id'],
						'userName'		=> $_SESSION['lastname'],
						'action'		=> $action,
						'actionTable'	=> $source_tableName,
						'actionDesc'	=> 'Удалена оплата СФ ( ' . $__numchfact . ' ) в договоре с этапами (kodshab = 1,3)',
						'kodchfact'		=> $__kodchfact,
						'numchfact'		=> $__numchfact,
						'kodoplata'		=> $__kodoplata,
						'kodchfavans'	=> 'Нет',
						'sumChf_1'		=> $_CHF_SUM,
						'sumOplChf_1'	=> $_CHF_OPL_SUM - $_CHF_OPL_0,
						'sumOplAvChf_1'	=> $_CHF_OPL_AVS_SUM,
						'docZadol_1'	=> $_CHF_SUM - (($_CHF_OPL_SUM - $_CHF_OPL_0) + $_CHF_OPL_AVS_SUM),
						'statusZadol_1'	=> $_KODSTATUSZDL
					));
					//
					//
				}
			}
		}
		#
		# ----- ----- ----- ----- -----
		#
		// Если договор создан без календарного плана (kodshab=2)
		if ($kodshab != 1 && $kodshab != 3) {
			// ВАЖНО!!
			// В случае договора без календарного плана в таблице этапов
			// под кодом этапа (kodkalplan) хранится код самого договора (koddoc)
			//
			// Выбираем код счета-фактуры
			$_QRY1 = mysqlQuery("SELECT kodchfact FROM dognet_kalplanchf WHERE kodkalplan=" . $koddoc);
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
				$kod = $_ROW1['kodchfact'];
				// Выбираем сумму счета-фактуры ($kod)
				$_QRY2 = $db->sql("SELECT chetfsumma FROM dognet_kalplanchf WHERE kodchfact=" . $kod)->fetchAll();
				if ($_QRY2) {
					$__summachfact = $_QRY2[0]['chetfsumma'];
				}
				// Сууммируем все оплаты по счету-фактуре ($kod)
				$_QRY3 = $db->sql("SELECT SUM(summaopl) as sumoplata FROM dognet_oplatachf WHERE kodchfact=" . $kod)->fetchAll();
				if ($_QRY3) {
					$__summaopl = $_QRY3[0]['sumoplata'];
				}
				// Суммируем все зачтенные авансы по счету-фактуре ($kod)
				$_QRY4 = $db->sql("SELECT SUM(summaoplav) as sumoplavans FROM dognet_chfavans WHERE kodchfact=" . $kod)->fetchAll();
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
				$db->update('dognet_kalplanchf_zadol', array(
					'chetfsumzadol'		=>	$_NEW_sumzadolchfact
				), array('kodchfact' => $kod));
				// Суммируем общую задолженность по договору
				$_CHF_SUM += $__summachfact;
				$_CHF_OPL_SUM += $__summaopl;
				$_CHF_OPL_AVS_SUM += $__sumoplavans;
			}
			// Суммируем все авансы по договору ($_koddoc)
			$_QRY5 = $db->sql("SELECT SUM(summaavans) as sumavans FROM dognet_docavans WHERE koddoc=" . $koddoc)->fetchAll();
			if ($_QRY5) {
				$__sumavans = $_QRY5[0]['sumavans'];
			}
			$_CHF_AVS_SUM = $__sumavans;

			// Формируем "текущий" статус задолженности, если таковая имеется
			$_QRY_KZ = $db->sql("SELECT kodstatuszdl FROM dognet_docbase WHERE koddoc=" . $koddoc)->fetchAll();
			$_KODSTATUSZDL = $_QRY_KZ[0]['kodstatuszdl'];
			// -----

			// Пишем в основную таблицу договоров общую задолженность по счетам, оплатам и авансам
			// по договору ($_koddoc)
			if ($action == "CRT" or $action == "UPD") {
				if ($_KODSTATUSZDL <= 1) {
					$_KODSTATUSZDL = (($_CHF_SUM - ($_CHF_OPL_SUM + $_CHF_OPL_AVS_SUM)) != 0) ? 1 : 0;
				}
				$db->update('dognet_docbase', array(
					'summachf' => $_CHF_SUM,
					'docoplata' => $_CHF_OPL_SUM,
					'doczadol' =>	$_CHF_SUM - ($_CHF_OPL_SUM + $_CHF_OPL_AVS_SUM),
					'docavans' => $_CHF_AVS_SUM,
					'docnozak' => $_CHF_AVS_SUM - $_CHF_OPL_AVS_SUM,
					'kodstatuszdl' => $_KODSTATUSZDL
				), array('koddoc' => $koddoc));
				//
				//
				$actionDesc1 = $action == "CRT" ? "Добавлена" : "Изменена";
				$actionDesc2 = $action == "CRT" ? "в договор" : "в договоре";
				$db->insert('dognet_testingDocStatusZadol', array(
					'koddoc'		=> $koddoc,
					'timestamp'		=> date('Y-m-d H:i:s'),
					'userID'		=> $_SESSION['id'],
					'userName'		=> $_SESSION['lastname'],
					'action'		=> $action,
					'actionTable'	=> $source_tableName,
					'actionDesc'	=> $actionDesc1 . ' оплата СФ ( ' . $__numchfact . ' ) ' . $actionDesc2 . ' без этапов (kodshab = 2,4)',
					'kodchfact'		=> $__kodchfact,
					'numchfact'		=> $__numchfact,
					'kodoplata'		=> $__kodoplata,
					'kodchfavans'	=> 'Нет',
					'sumChf_1'		=> $_CHF_SUM,
					'sumOplChf_1'	=> $_CHF_OPL_SUM,
					'sumOplAvChf_1'	=> $_CHF_OPL_AVS_SUM,
					'docZadol_1'	=> $_CHF_SUM - ($_CHF_OPL_SUM + $_CHF_OPL_AVS_SUM),
					'statusZadol_1'	=> $_KODSTATUSZDL
				));
				//
				//
			}
			if ($action == "DEL") {
				if ($_KODSTATUSZDL <= 1) {
					$_KODSTATUSZDL = (($_CHF_SUM - (($_CHF_OPL_SUM - $_CHF_OPL_0) + $_CHF_OPL_AVS_SUM)) != 0) ? 1 : 0;
				}
				$db->update('dognet_docbase', array(
					'summachf' => $_CHF_SUM,
					'docoplata' => $_CHF_OPL_SUM - $_CHF_OPL_0,
					'doczadol' =>	$_CHF_SUM - (($_CHF_OPL_SUM - $_CHF_OPL_0) + $_CHF_OPL_AVS_SUM),
					'docavans' => $_CHF_AVS_SUM,
					'docnozak' => $_CHF_AVS_SUM - $_CHF_OPL_AVS_SUM,
					'kodstatuszdl' => $_KODSTATUSZDL
				), array('koddoc' => $koddoc));
				//
				//
				$db->insert('dognet_testingDocStatusZadol', array(
					'koddoc'		=> $koddoc,
					'timestamp'		=> date('Y-m-d H:i:s'),
					'userID'		=> $_SESSION['id'],
					'userName'		=> $_SESSION['lastname'],
					'action'		=> $action,
					'actionTable'	=> $source_tableName,
					'actionDesc'	=> 'Удалена оплата СФ ( ' . $__numchfact . ' ) в договоре без этапов (kodshab = 2,4)',
					'kodchfact'		=> $__kodchfact,
					'numchfact'		=> $__numchfact,
					'kodoplata'		=> $__kodoplata,
					'kodchfavans'	=> 'Нет',
					'sumChf_1'		=> $_CHF_SUM,
					'sumOplChf_1'	=> $_CHF_OPL_SUM - $_CHF_OPL_0,
					'sumOplAvChf_1'	=> $_CHF_OPL_AVS_SUM,
					'docZadol_1'	=> $_CHF_SUM - (($_CHF_OPL_SUM - $_CHF_OPL_0) + $_CHF_OPL_AVS_SUM),
					'statusZadol_1'	=> $_KODSTATUSZDL
				));
				//
				//
			}
		}
		#
		#
	}
	#
	#
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	#
	#
	if ($source_tableName == "chfavans") {
		// Выбираем код редактируемого счета-фактуры (kodchfact)
		// из таблицы счетов dognet_kalplanchf
		$_CHF_OPL_0 = 0;
		$_CHF_OPL_AVS_0 = 0;
		$__kodchfact = "";
		$__kodchfavans = "";
		$__numchfact = "";
		$_QRY = $db->sql("SELECT * FROM dognet_chfavans WHERE id=" . $source_rowID)->fetchAll();
		if ($_QRY) {
			$__kodchfact = $_QRY[0]['kodchfact'];
			$__kodchfavans = $_QRY[0]['kodchfavans'];
			// Запоминаем сумму оплаты для текущего счета
			$_CHF_OPL_AVS_0 = $_QRY[0]['summaoplav'];
			$_QRY1 = $db->sql("SELECT chetfnumber FROM dognet_kalplanchf WHERE kodchfact=" . $__kodchfact)->fetchAll();
			if ($_QRY1) {
				$__numchfact = $_QRY1[0]['chetfnumber'];
			}
		}
		#
		# ----- ----- ----- ----- -----
		#
		// Если договор создан с календарным планом (kodshab=1)
		if ($kodshab == 1 || $kodshab == 3) {
			// Выбираем код этапа (kodkalplan) из таблицы календарных планов (этапов)
			// для выбранного выше договора ($_koddoc)
			$_QRY1 = mysqlQuery("SELECT kodkalplan FROM dognet_dockalplan WHERE koddoc=" . $koddoc);
			if ($_QRY1) {
				// Обнуляем счетчики
				$_CHF_SUM = 0;
				$_CHF_OPL_SUM = 0;
				$_CHF_AVS_SUM = 0;
				$_CHF_OPL_AVS_SUM = 0;
				// Запускаем цикл по всем кодам этапов
				while ($_ROW1 = mysqli_fetch_assoc($_QRY1)) {
					// Выбираем код счета-фактуры
					$_QRY2 = mysqlQuery("SELECT kodchfact FROM dognet_kalplanchf WHERE kodkalplan=" . $_ROW1['kodkalplan']);
					// Обнуляем счетчики
					$__summachfact = 0;
					$__summaopl = 0;
					$__sumavans = 0;
					$__sumoplavans = 0;
					// Запускаем цикл по всем счетам-фактурам
					while ($_ROW2 = mysqli_fetch_assoc($_QRY2)) {
						$kod = $_ROW2['kodchfact'];
						// Выбираем сумму счета-фактуры ($kod)
						$_QRY3 = $db->sql("SELECT SUM(chetfsumma) as chfsum FROM dognet_kalplanchf WHERE kodchfact=" . $kod)->fetchAll();
						if ($_QRY3) {
							$__summachfact = $_QRY3[0]['chfsum'];
						}
						// Сууммируем все оплаты по счету-фактуре ($kod)
						$_QRY4 = $db->sql("SELECT SUM(summaopl) as sumoplata FROM dognet_oplatachf WHERE kodchfact=" . $kod)->fetchAll();
						if ($_QRY4) {
							$__summaopl = $_QRY4[0]['sumoplata'];
						}
						// Суммируем все зачтенные авансы по счету-фактуре ($kod)
						$_QRY5 = $db->sql("SELECT SUM(summaoplav) as sumoplavans FROM dognet_chfavans WHERE kodchfact=" . $kod)->fetchAll();
						if ($_QRY5) {
							$__sumoplavans = $_QRY5[0]['sumoplavans'];
						}
						// Считаем текущую задолженность по счету-фактуре ($kod)
						if (($kod === $__kodchfact) and $action == "DEL") {
							$_NEW_sumzadolchfact = $__summachfact - ($__summaopl + ($__sumoplavans - $_CHF_OPL_AVS_0));
						} else {
							$_NEW_sumzadolchfact = $__summachfact - ($__summaopl + $__sumoplavans);
						}
						// Пишем в таблицу задолженностей счетов-фактур
						$db->update('dognet_kalplanchf_zadol', array(
							'chetfsumzadol'		=>	$_NEW_sumzadolchfact
						), array('kodchfact' => $kod));
						// Суммируем общую задолженность по договору
						$_CHF_SUM += $__summachfact;
						$_CHF_OPL_SUM += $__summaopl;
						$_CHF_OPL_AVS_SUM += $__sumoplavans;
					}
					// Суммируем все авансы по договору ($_koddoc)
					$_QRY6 = $db->sql("SELECT SUM(summaavans) as sumavans FROM dognet_docavans WHERE koddoc=" . $_ROW1['kodkalplan'])->fetchAll();
					if ($_QRY6) {
						$__sumavans = $_QRY6[0]['sumavans'];
					}
					$_CHF_AVS_SUM += $__sumavans;
				}

				// Формируем "текущий" статус задолженности, если таковая имеется
				$_QRY_KZ = $db->sql("SELECT kodstatuszdl FROM dognet_docbase WHERE koddoc=" . $koddoc)->fetchAll();
				$_KODSTATUSZDL = $_QRY_KZ[0]['kodstatuszdl'];
				// -----

				// Пишем в основную таблицу договоров общую задолженность по счетам, оплатам и авансам
				// по договору ($_koddoc)
				if ($action == "CRT" or $action == "UPD") {
					if ($_KODSTATUSZDL <= 1) {
						$_KODSTATUSZDL = (($_CHF_SUM - ($_CHF_OPL_SUM + $_CHF_OPL_AVS_SUM)) != 0) ? 1 : 0;
					}
					$db->update('dognet_docbase', array(
						'summachf' => $_CHF_SUM,
						'docoplata' => $_CHF_OPL_SUM,
						'doczadol' =>	$_CHF_SUM - ($_CHF_OPL_SUM + $_CHF_OPL_AVS_SUM),
						'docavans' => $_CHF_AVS_SUM,
						'docnozak' => $_CHF_AVS_SUM - $_CHF_OPL_AVS_SUM,
						'kodstatuszdl' => $_KODSTATUSZDL
					), array('koddoc' => $koddoc));
					//
					//
					$actionDesc1 = $action == "CRT" ? "Добавлен" : "Изменен";
					$actionDesc2 = $action == "CRT" ? "в договор" : "в договоре";
					$db->insert('dognet_testingDocStatusZadol', array(
						'koddoc'		=> $koddoc,
						'timestamp'		=> date('Y-m-d H:i:s'),
						'userID'		=> $_SESSION['id'],
						'userName'		=> $_SESSION['lastname'],
						'action'		=> $action,
						'actionDesc'	=> $actionDesc1 . ' зачет аванса по СФ ( ' . $__numchfact . ' ) ' . $actionDesc2 . ' с этапами (kodshab = 1,3)',
						'kodchfact'		=> $__kodchfact,
						'numchfact'		=> $__numchfact,
						'kodoplata'		=> 'Нет',
						'kodchfavans'	=> $__kodchfavans,
						'sumChf_1'		=> $_CHF_SUM,
						'sumOplChf_1'	=> $_CHF_OPL_SUM,
						'sumOplAvChf_1'	=> $_CHF_OPL_AVS_SUM,
						'docZadol_1'	=> $_CHF_SUM - ($_CHF_OPL_SUM + $_CHF_OPL_AVS_SUM),
						'statusZadol_1'	=> $_KODSTATUSZDL
					));
					//
					//
				}
				if ($action == "DEL") {
					if ($_KODSTATUSZDL <= 1) {
						$_KODSTATUSZDL = (($_CHF_SUM - ($_CHF_OPL_SUM + ($_CHF_OPL_AVS_SUM - $_CHF_OPL_AVS_0))) != 0) ? 1 : 0;
					}
					$db->update('dognet_docbase', array(
						'summachf' => $_CHF_SUM,
						'docoplata' => $_CHF_OPL_SUM,
						'doczadol' =>	$_CHF_SUM - ($_CHF_OPL_SUM + ($_CHF_OPL_AVS_SUM - $_CHF_OPL_AVS_0)),
						'docavans' => $_CHF_AVS_SUM,
						'docnozak' => $_CHF_AVS_SUM - ($_CHF_OPL_AVS_SUM - $_CHF_OPL_AVS_0),
						'kodstatuszdl' => $_KODSTATUSZDL
					), array('koddoc' => $koddoc));
					//
					//
					$db->insert('dognet_testingDocStatusZadol', array(
						'koddoc'		=> $koddoc,
						'timestamp'		=> date('Y-m-d H:i:s'),
						'userID'		=> $_SESSION['id'],
						'userName'		=> $_SESSION['lastname'],
						'action'		=> $action,
						'actionDesc'	=> 'Удален зачет аванса по СФ ( ' . $__numchfact . ' ) в договоре с этапами (kodshab = 1,3)',
						'kodchfact'		=> $__kodchfact,
						'numchfact'		=> $__numchfact,
						'kodoplata'		=> 'Нет',
						'kodchfavans'	=> $__kodchfavans,
						'sumChf_1'		=> $_CHF_SUM,
						'sumOplChf_1'	=> $_CHF_OPL_SUM,
						'sumOplAvChf_1'	=> $_CHF_OPL_AVS_SUM - $_CHF_OPL_AVS_0,
						'docZadol_1'	=> $_CHF_SUM - ($_CHF_OPL_SUM + ($_CHF_OPL_AVS_SUM - $_CHF_OPL_AVS_0)),
						'statusZadol_1'	=> $_KODSTATUSZDL
					));
					//
					//
				}
			}
		}
		#
		# ----- ----- ----- ----- -----
		#
		// Если договор создан без календарного плана (kodshab=2)
		if ($kodshab != 1 && $kodshab != 3) {
			// ВАЖНО!!
			// В случае договора без календарного плана в таблице этапов
			// под кодом этапа (kodkalplan) хранится код самого договора (koddoc)
			//
			// Выбираем код счета-фактуры
			$_QRY1 = mysqlQuery("SELECT kodchfact FROM dognet_kalplanchf WHERE kodkalplan=" . $koddoc);
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
				$kod = $_ROW1['kodchfact'];
				// Выбираем сумму счета-фактуры ($kod)
				$_QRY2 = $db->sql("SELECT chetfsumma FROM dognet_kalplanchf WHERE kodchfact=" . $kod)->fetchAll();
				if ($_QRY2) {
					$__summachfact = $_QRY2[0]['chetfsumma'];
				}
				// Сууммируем все оплаты по счету-фактуре ($kod)
				$_QRY3 = $db->sql("SELECT SUM(summaopl) as sumoplata FROM dognet_oplatachf WHERE kodchfact=" . $kod)->fetchAll();
				if ($_QRY3) {
					$__summaopl = $_QRY3[0]['sumoplata'];
				}
				// Суммируем все зачтенные авансы по счету-фактуре ($kod)
				$_QRY4 = $db->sql("SELECT SUM(summaoplav) as sumoplavans FROM dognet_chfavans WHERE kodchfact=" . $kod)->fetchAll();
				if ($_QRY4) {
					$__sumoplavans = $_QRY4[0]['sumoplavans'];
				}
				// Считаем текущую задолженность по счету-фактуре ($kod)
				if (($kod === $__kodchfact) and $action == "DEL") {
					$_NEW_sumzadolchfact = $__summachfact - ($__summaopl + ($__sumoplavans - $_CHF_OPL_AVS_0));
				} else {
					$_NEW_sumzadolchfact = $__summachfact - ($__summaopl + $__sumoplavans);
				}
				// Пишем в таблицу задолженностей счетов-фактур
				$db->update('dognet_kalplanchf_zadol', array(
					'chetfsumzadol'		=>	$_NEW_sumzadolchfact
				), array('kodchfact' => $kod));
				// Суммируем общую задолженность по договору
				$_CHF_SUM += $__summachfact;
				$_CHF_OPL_SUM += $__summaopl;
				$_CHF_OPL_AVS_SUM += $__sumoplavans;
			}
			// Суммируем все авансы по договору ($_koddoc)
			$_QRY5 = $db->sql("SELECT SUM(summaavans) as sumavans FROM dognet_docavans WHERE koddoc=" . $koddoc)->fetchAll();
			if ($_QRY5) {
				$__sumavans = $_QRY5[0]['sumavans'];
			}
			$_CHF_AVS_SUM = $__sumavans;

			// Формируем "текущий" статус задолженности, если таковая имеется
			$_QRY_KZ = $db->sql("SELECT kodstatuszdl FROM dognet_docbase WHERE koddoc=" . $koddoc)->fetchAll();
			$_KODSTATUSZDL = $_QRY_KZ[0]['kodstatuszdl'];
			// -----

			// Пишем в основную таблицу договоров общую задолженность по счетам, оплатам и авансам
			// по договору ($_koddoc)
			if ($action == "CRT" or $action == "UPD") {
				if ($_KODSTATUSZDL <= 1) {
					$_KODSTATUSZDL = (($_CHF_SUM - ($_CHF_OPL_SUM + $_CHF_OPL_AVS_SUM)) != 0) ? 1 : 0;
				}
				$db->update('dognet_docbase', array(
					'summachf' => $_CHF_SUM,
					'docoplata' => $_CHF_OPL_SUM,
					'doczadol' =>	$_CHF_SUM - ($_CHF_OPL_SUM + $_CHF_OPL_AVS_SUM),
					'docavans' => $_CHF_AVS_SUM,
					'docnozak' => $_CHF_AVS_SUM - $_CHF_OPL_AVS_SUM,
					'kodstatuszdl' => $_KODSTATUSZDL
				), array('koddoc' => $koddoc));
				//
				//
				$actionDesc1 = $action == "CRT" ? "Добавлен" : "Изменен";
				$actionDesc2 = $action == "CRT" ? "в договор" : "в договоре";
				$db->insert('dognet_testingDocStatusZadol', array(
					'koddoc'		=> $koddoc,
					'timestamp'		=> date('Y-m-d H:i:s'),
					'userID'		=> $_SESSION['id'],
					'userName'		=> $_SESSION['lastname'],
					'action'		=> $action,
					'actionDesc'	=> $actionDesc1 . ' зачет аванса по СФ ( ' . $__numchfact . ' ) ' . $actionDesc2 . ' без этапов (kodshab = 2,4)',
					'kodchfact'		=> $__kodchfact,
					'numchfact'		=> $__numchfact,
					'kodoplata'		=> 'Нет',
					'kodchfavans'	=> $__kodchfavans,
					'sumChf_1'		=> $_CHF_SUM,
					'sumOplChf_1'	=> $_CHF_OPL_SUM,
					'sumOplAvChf_1'	=> $_CHF_OPL_AVS_SUM,
					'docZadol_1'	=> $_CHF_SUM - ($_CHF_OPL_SUM + $_CHF_OPL_AVS_SUM),
					'statusZadol_1'	=> $_KODSTATUSZDL
				));
				//
				//
			}
			if ($action == "DEL") {
				if ($_KODSTATUSZDL <= 1) {
					$_KODSTATUSZDL = (($_CHF_SUM - ($_CHF_OPL_SUM + ($_CHF_OPL_AVS_SUM - $_CHF_OPL_AVS_0))) != 0) ? 1 : 0;
				}
				$db->update('dognet_docbase', array(
					'summachf' => $_CHF_SUM,
					'docoplata' => $_CHF_OPL_SUM,
					'doczadol' =>	$_CHF_SUM - ($_CHF_OPL_SUM + ($_CHF_OPL_AVS_SUM - $_CHF_OPL_AVS_0)),
					'docavans' => $_CHF_AVS_SUM,
					'docnozak' => $_CHF_AVS_SUM - ($_CHF_OPL_AVS_SUM - $_CHF_OPL_AVS_0),
					'kodstatuszdl' => $_KODSTATUSZDL
				), array('koddoc' => $koddoc));
				//
				//
				$db->insert('dognet_testingDocStatusZadol', array(
					'koddoc'		=> $koddoc,
					'timestamp'		=> date('Y-m-d H:i:s'),
					'userID'		=> $_SESSION['id'],
					'userName'		=> $_SESSION['lastname'],
					'action'		=> $action,
					'actionDesc'	=> 'Удален зачет аванса по СФ ( ' . $__numchfact . ' ) в договоре без этапов (kodshab = 2,4)',
					'kodchfact'		=> $__kodchfact,
					'numchfact'		=> $__numchfact,
					'kodoplata'		=> 'Нет',
					'kodchfavans'	=> $__kodchfavans,
					'sumChf_1'		=> $_CHF_SUM,
					'sumOplChf_1'	=> $_CHF_OPL_SUM,
					'sumOplAvChf_1'	=> $_CHF_OPL_AVS_SUM - $_CHF_OPL_AVS_0,
					'docZadol_1'	=> $_CHF_SUM - ($_CHF_OPL_SUM + ($_CHF_OPL_AVS_SUM - $_CHF_OPL_AVS_0)),
					'statusZadol_1'	=> $_KODSTATUSZDL
				));
				//
				//
			}
		}
		#
		#
	}
	#
	#
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	#
	#
	if ($source_tableName == "docavans") {
		// Выбираем код редактируемого счета-фактуры (kodchfact)
		// из таблицы счетов dognet_kalplanchf
		$_CHF_AVS_0 = 0;
		$_QRY = $db->sql("SELECT * FROM dognet_docavans WHERE id=" . $source_rowID)->fetchAll();
		if ($_QRY) {
			$__kodavans = $_QRY[0]['kodavans'];
			// Запоминаем сумму оплаты для текущего счета
			$_CHF_AVS_0 = $_QRY[0]['summaavans'];
		}
		#
		# ----- ----- ----- ----- -----
		#
		// Если договор создан с календарным планом (kodshab=1)
		if ($kodshab == 1 || $kodshab == 3) {
			// Выбираем код этапа (kodkalplan) из таблицы календарных планов (этапов)
			// для выбранного выше договора ($_koddoc)
			$_QRY1 = mysqlQuery("SELECT kodkalplan FROM dognet_dockalplan WHERE koddoc=" . $koddoc);
			if ($_QRY1) {
				// Обнуляем счетчики
				$_CHF_SUM = 0;
				$_CHF_OPL_SUM = 0;
				$_CHF_AVS_SUM = 0;
				$_CHF_OPL_AVS_SUM = 0;
				// Запускаем цикл по всем кодам этапов
				while ($_ROW1 = mysqli_fetch_assoc($_QRY1)) {
					// Выбираем код счета-фактуры
					$_QRY2 = mysqlQuery("SELECT kodchfact FROM dognet_kalplanchf WHERE kodkalplan=" . $_ROW1['kodkalplan']);
					// Обнуляем счетчики
					$__summachfact = 0;
					$__summaopl = 0;
					$__sumavans = 0;
					$__sumoplavans = 0;
					// Запускаем цикл по всем счетам-фактурам
					while ($_ROW2 = mysqli_fetch_assoc($_QRY2)) {
						$kod = $_ROW2['kodchfact'];
						// Выбираем сумму счета-фактуры ($kod)
						$_QRY3 = $db->sql("SELECT SUM(chetfsumma) as chfsum FROM dognet_kalplanchf WHERE kodchfact=" . $kod)->fetchAll();
						if ($_QRY3) {
							$__summachfact = $_QRY3[0]['chfsum'];
						}
						// Сууммируем все оплаты по счету-фактуре ($kod)
						$_QRY4 = $db->sql("SELECT SUM(summaopl) as sumoplata FROM dognet_oplatachf WHERE kodchfact=" . $kod)->fetchAll();
						if ($_QRY4) {
							$__summaopl = $_QRY4[0]['sumoplata'];
						}
						// Суммируем все зачтенные авансы по счету-фактуре ($kod)
						$_QRY5 = $db->sql("SELECT SUM(summaoplav) as sumoplavans FROM dognet_chfavans WHERE kodchfact=" . $kod)->fetchAll();
						if ($_QRY5) {
							$__sumoplavans = $_QRY5[0]['sumoplavans'];
						}
						$_NEW_sumzadolchfact = $__summachfact - ($__summaopl + $__sumoplavans);
						// Пишем в таблицу задолженностей счетов-фактур
						$db->update('dognet_kalplanchf_zadol', array(
							'chetfsumzadol'		=>	$_NEW_sumzadolchfact
						), array('kodchfact' => $kod));
						// Суммируем общую задолженность по договору
						$_CHF_SUM += $__summachfact;
						$_CHF_OPL_SUM += $__summaopl;
						$_CHF_OPL_AVS_SUM += $__sumoplavans;
					}
					// Суммируем все авансы по договору ($_koddoc)
					$_QRY6 = $db->sql("SELECT SUM(summaavans) as sumavans FROM dognet_docavans WHERE koddoc=" . $_ROW1['kodkalplan'])->fetchAll();
					$__sumavans = $_QRY6[0]['sumavans'];
					$_CHF_AVS_SUM += $__sumavans;
				}

				// Формируем "текущий" статус задолженности, если таковая имеется
				$_QRY_KZ = $db->sql("SELECT kodstatuszdl FROM dognet_docbase WHERE koddoc=" . $koddoc)->fetchAll();
				$_KODSTATUSZDL = $_QRY_KZ[0]['kodstatuszdl'];
				// -----

				// Пишем в основную таблицу договоров общую задолженность по счетам, оплатам и авансам
				// по договору ($_koddoc)
				if ($action == "CRT" or $action == "UPD") {
					if ($_KODSTATUSZDL <= 1) {
						$_KODSTATUSZDL = (($_CHF_SUM - ($_CHF_OPL_SUM + $_CHF_OPL_AVS_SUM)) != 0) ? 1 : 0;
					}
					$db->update('dognet_docbase', array(
						'summachf' => $_CHF_SUM,
						'docoplata' => $_CHF_OPL_SUM,
						'doczadol' =>	$_CHF_SUM - ($_CHF_OPL_SUM + $_CHF_OPL_AVS_SUM),
						'docavans' => $_CHF_AVS_SUM,
						'docnozak' => $_CHF_AVS_SUM - $_CHF_OPL_AVS_SUM,
						'kodstatuszdl' => $_KODSTATUSZDL
					), array('koddoc' => $koddoc));
				}
				if ($action == "DEL") {
					if ($_KODSTATUSZDL <= 1) {
						$_KODSTATUSZDL = (($_CHF_SUM - ($_CHF_OPL_SUM + $_CHF_OPL_AVS_SUM)) != 0) ? 1 : 0;
					}
					$db->update('dognet_docbase', array(
						'summachf' => $_CHF_SUM,
						'docoplata' => $_CHF_OPL_SUM,
						'doczadol' =>	$_CHF_SUM - ($_CHF_OPL_SUM + $_CHF_OPL_AVS_SUM),
						'docavans' => $_CHF_AVS_SUM - $_CHF_AVS_0,
						'docnozak' => ($_CHF_AVS_SUM - $_CHF_AVS_0) - $_CHF_OPL_AVS_SUM,
						'kodstatuszdl' => $_KODSTATUSZDL
					), array('koddoc' => $koddoc));
				}
			}
		}
		#
		# ----- ----- ----- ----- -----
		#
		// Если договор создан без календарного плана (kodshab=2)
		if ($kodshab != 1 && $kodshab != 3) {
			// ВАЖНО!!
			// В случае договора без календарного плана в таблице этапов
			// под кодом этапа (kodkalplan) хранится код самого договора (koddoc)
			//
			// Выбираем код счета-фактуры
			$_QRY1 = mysqlQuery("SELECT kodchfact FROM dognet_kalplanchf WHERE kodkalplan=" . $koddoc);
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
				$kod = $_ROW1['kodchfact'];
				// Выбираем сумму счета-фактуры ($kod)
				$_QRY2 = $db->sql("SELECT chetfsumma FROM dognet_kalplanchf WHERE kodchfact=" . $kod)->fetchAll();
				if ($_QRY2) {
					$__summachfact = $_QRY2[0]['chetfsumma'];
				}
				// Сууммируем все оплаты по счету-фактуре ($kod)
				$_QRY3 = $db->sql("SELECT SUM(summaopl) as sumoplata FROM dognet_oplatachf WHERE kodchfact=" . $kod)->fetchAll();
				if ($_QRY3) {
					$__summaopl = $_QRY3[0]['sumoplata'];
				}
				// Суммируем все зачтенные авансы по счету-фактуре ($kod)
				$_QRY4 = $db->sql("SELECT SUM(summaoplav) as sumoplavans FROM dognet_chfavans WHERE kodchfact=" . $kod)->fetchAll();
				if ($_QRY4) {
					$__sumoplavans = $_QRY4[0]['sumoplavans'];
				}
				// Считаем текущую задолженность по счету-фактуре ($kod)
				$_NEW_sumzadolchfact = $__summachfact - ($__summaopl + $__sumoplavans);
				// Пишем в таблицу задолженностей счетов-фактур
				$db->update('dognet_kalplanchf_zadol', array(
					'chetfsumzadol'		=>	$_NEW_sumzadolchfact
				), array('kodchfact' => $kod));
				// Суммируем общую задолженность по договору
				$_CHF_SUM += $__summachfact;
				$_CHF_OPL_SUM += $__summaopl;
				$_CHF_OPL_AVS_SUM += $__sumoplavans;
			}
			// Суммируем все авансы по договору ($_koddoc)
			$_QRY5 = $db->sql("SELECT SUM(summaavans) as sumavans FROM dognet_docavans WHERE koddoc=" . $koddoc)->fetchAll();
			if ($_QRY5) {
				$__sumavans = $_QRY5[0]['sumavans'];
			}
			$_CHF_AVS_SUM = $__sumavans;

			// Формируем "текущий" статус задолженности, если таковая имеется
			$_QRY_KZ = $db->sql("SELECT kodstatuszdl FROM dognet_docbase WHERE koddoc=" . $koddoc)->fetchAll();
			$_KODSTATUSZDL = $_QRY_KZ[0]['kodstatuszdl'];
			// -----

			// Пишем в основную таблицу договоров общую задолженность по счетам, оплатам и авансам
			// по договору ($_koddoc)
			if ($action == "CRT" or $action == "UPD") {
				if ($_KODSTATUSZDL <= 1) {
					$_KODSTATUSZDL = (($_CHF_SUM - ($_CHF_OPL_SUM + $_CHF_OPL_AVS_SUM)) != 0) ? 1 : 0;
				}
				$db->update('dognet_docbase', array(
					'summachf' => $_CHF_SUM,
					'docoplata' => $_CHF_OPL_SUM,
					'doczadol' =>	$_CHF_SUM - ($_CHF_OPL_SUM + $_CHF_OPL_AVS_SUM),
					'docavans' => $_CHF_AVS_SUM,
					'docnozak' => $_CHF_AVS_SUM - $_CHF_OPL_AVS_SUM,
					'kodstatuszdl' => $_KODSTATUSZDL
				), array('koddoc' => $koddoc));
			}
			if ($action == "DEL") {
				if ($_KODSTATUSZDL <= 1) {
					$_KODSTATUSZDL = (($_CHF_SUM - ($_CHF_OPL_SUM + $_CHF_OPL_AVS_SUM)) != 0) ? 1 : 0;
				}
				$db->update('dognet_docbase', array(
					'summachf' => $_CHF_SUM,
					'docoplata' => $_CHF_OPL_SUM,
					'doczadol' =>	$_CHF_SUM - ($_CHF_OPL_SUM + $_CHF_OPL_AVS_SUM),
					'docavans' => $_CHF_AVS_SUM - $_CHF_AVS_0,
					'docnozak' => ($_CHF_AVS_SUM - $_CHF_AVS_0) - $_CHF_OPL_AVS_SUM,
					'kodstatuszdl' => $_KODSTATUSZDL
				), array('koddoc' => $koddoc));
			}
		}
		#
		#
	}
	#
	#
}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
# ОПРЕДЕЛЕНИЕ ЗАДОЛЖЕННОСТИ ПО СЧЕТУ-ФАКТУРЕ
# + $kodchfact - ID счета-фактуры
# + $action - кнопка вызова процедуры (New, Edit, Delete)
# + $source_rowID - ID строки исходных данных источника
# + $source_tableName - имя таблицы-источника
# + $db - драйвер БД
#
function KALPLANCHF_PR_ZADOLG_CHF($db, $source_tableName, $source_rowID, $action, $kodchfact) {
	#
	#
	if ($source_tableName == "kalplanchf") {
		// Выбираем данные счета-фактуры по ID записи (id) из таблицы счетов dognet_kalplanchf
		$_QRY_1 = $db->sql("SELECT * FROM dognet_kalplanchf WHERE id=" . $source_rowID)->fetchAll();
		if ($_QRY_1) {
			$__kodchfact = $_QRY_1[0]['kodchfact'];
			$__summachfact = $_QRY_1[0]['chetfsumma'];
		}
		#
		#
		// Считаем и пишем задолженность по счету
		// SUMMA_OPLATCHF - функция : сумма оплат по счету-фактуре
		// SUMMA_AVANSCHF - функция : сумма зачтенных авансов по счету-фактуре
		if ($action == "CRT") {
			$db->insert('dognet_kalplanchf_zadol', array(
				'kodchfact' =>	$__kodchfact,
				'kodkalplan' =>	$_QRY_1[0]['kodkalplan'],
				'chetfsumma' =>	$_QRY_1[0]['chetfsumma'],
				'chetfsumzadol' =>	$__summachfact - (SUMMA_OPLATCHF($__kodchfact) + SUMMA_AVANSCHF($__kodchfact))
			));
		}
		if ($action == "UPD") {
			$db->update('dognet_kalplanchf_zadol', array(
				'chetfsumma'		=>	$__summachfact,
				'chetfsumzadol' =>	$__summachfact - (SUMMA_OPLATCHF($__kodchfact) + SUMMA_AVANSCHF($__kodchfact))
			), array('kodchfact' => $__kodchfact));
		}
	}
	#
	#
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	#
	#
	if ($source_tableName == "oplatachf") {
		$_QRY = $db->sql("SELECT * FROM dognet_oplatachf WHERE id=" . $source_rowID)->fetchAll();
		if ($_QRY) {
			$__kodchfact = $_QRY[0]['kodchfact'];
		}

		// Выбираем данные счета-фактуры по ID записи (id) из таблицы счетов dognet_kalplanchf
		$_QRY_1 = $db->sql("SELECT * FROM dognet_kalplanchf WHERE kodchfact=" . $__kodchfact)->fetchAll();
		if ($_QRY_1) {
			$__summachfact = $_QRY_1[0]['chetfsumma'];
		}
		#
		#
		// Считаем и пишем задолженность по счету
		// SUMMA_OPLATCHF - функция : сумма оплат по счету-фактуре
		// SUMMA_AVANSCHF - функция : сумма зачтенных авансов по счету-фактуре
		if ($action == "UPD" or $action == "DEL") {
			$db->update('dognet_kalplanchf_zadol', array(
				'chetfsumma'		=>	$__summachfact,
				'chetfsumzadol' =>	$__summachfact - (SUMMA_OPLATCHF($__kodchfact) + SUMMA_AVANSCHF($__kodchfact))
			), array('kodchfact' => $__kodchfact));
		}
	}
	#
	#
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	#
	#
	if ($source_tableName == "chfavans") {
		$_QRY = $db->sql("SELECT * FROM dognet_chfavans WHERE id=" . $source_rowID)->fetchAll();
		if ($_QRY) {
			$__kodchfact = $_QRY[0]['kodchfact'];
		}

		// Выбираем данные счета-фактуры по ID записи (id) из таблицы счетов dognet_kalplanchf
		$_QRY_1 = $db->sql("SELECT * FROM dognet_kalplanchf WHERE kodchfact=" . $__kodchfact)->fetchAll();
		if ($_QRY_1) {
			$__summachfact = $_QRY_1[0]['chetfsumma'];
		}
		#
		#
		// Считаем и пишем задолженность по счету
		// SUMMA_OPLATCHF - функция : сумма оплат по счету-фактуре
		// SUMMA_AVANSCHF - функция : сумма зачтенных авансов по счету-фактуре
		if ($action == "UPD" or $action == "DEL") {
			$db->update('dognet_kalplanchf_zadol', array(
				'chetfsumma'		=>	$__summachfact,
				'chetfsumzadol' =>	$__summachfact - (SUMMA_OPLATCHF($__kodchfact) + SUMMA_AVANSCHF($__kodchfact))
			), array('kodchfact' => $__kodchfact));
		}
	}
	#
	#
}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
# ОПРЕДЕЛЕНИЕ ОСТАТКА ПО АВАНСУ
# + $kodchfact - ID счета-фактуры
# + $action - кнопка вызова процедуры (New, Edit, Delete)
# + $source_rowID - ID строки исходных данных источника
# + $source_tableName - имя таблицы-источника
# + $db - драйвер БД
#
function DOCAVANS_PR_OSTATOK_DOC($db, $source_tableName, $source_rowID, $action) {
	#
	#
	if ($source_tableName == "docavans") {
		// Считаем и пишем остаток по авансам
		// SUMMA_OPLATCHF - функция : сумма оплат по счету-фактуре
		// SUMMA_AVANSCHF - функция : сумма зачтенных авансов по счету-фактуре
		if ($action == "CRT") {
			// Выбираем данные счета-фактуры по ID записи (id) из таблицы счетов dognet_kalplanchf
			$_QRY = $db->sql("SELECT * FROM dognet_docavans WHERE id=" . $source_rowID)->fetchAll();
			if ($_QRY) {
				$__kodavans = $_QRY[0]['kodavans'];
				$__koddoc = $_QRY[0]['koddoc'];
				$__summaavans = $_QRY[0]['summaavans'];
			}
			$db->insert('dognet_docavans_ostatok', array(
				'kodavans' =>	$__kodavans,
				'koddoc' =>	$__koddoc,
				'summaavans' =>	$__summaavans,
				'ostatokavans' =>	$__summaavans
			));
			// Пишем остаток аванса
			$db->update(
				'dognet_docavans',
				array(
					'ostatokavans' => $__summaavans
				),
				array('kodavans' => $__kodavans)
			);
		}
		#
		#
		if ($action == "UPD") {


			// 16.04.2020
			// - Убрал обновление незачтенной суммы аванса для всех авансов по этапу
			// + Сделал обновление только для выбранного аванса
			// ... Убрал повторный sql-запрос к этой же строке и цикл while по id аванса (kodavans)
			$_QRY = $db->sql("SELECT koddoc, kodavans, summaavans FROM dognet_docavans WHERE id=" . $source_rowID)->fetchAll();
			$_QRY2 = $db->sql("SELECT SUM(summaoplav) as sum1 FROM dognet_chfavans WHERE kodavans=" . $_QRY[0]['kodavans'])->fetchAll();
			// Пишем в таблицу задолженностей счетов-фактур
			$db->update(
				'dognet_docavans_ostatok',
				array(
					'summaavans' =>	$_QRY[0]['summaavans'],
					'ostatokavans' => ($_QRY[0]['summaavans'] - $_QRY2[0]['sum1'])
				),
				array('kodavans' => $_QRY[0]['kodavans'])
			);
			// Пишем остаток аванса
			$db->update(
				'dognet_docavans',
				array(
					'ostatokavans' => ($_QRY[0]['summaavans'] - $_QRY2[0]['sum1'])
				),
				array('kodavans' => $_QRY[0]['kodavans'])
			);
			/*
				$_QRY = $db->sql( "SELECT koddoc, kodavans FROM dognet_docavans WHERE id=".$source_rowID )->fetchAll();
				$_QRY1 = mysqlQuery( "SELECT * FROM dognet_docavans WHERE koddoc=".$_QRY[0]['koddoc'] );
				while( $_ROW1 = mysqli_fetch_assoc($_QRY1) ) {
					$_QRY2 = $db->sql( "SELECT SUM(summaoplav) as sum1 FROM dognet_chfavans WHERE kodavans=".$_ROW1['kodavans'] )->fetchAll();
				// Пишем в таблицу задолженностей счетов-фактур
					$db->update( 'dognet_docavans_ostatok', array(
						'summaavans' =>	$_ROW1['summaavans'],
						'ostatokavans' => ($_ROW1['summaavans'] - $_QRY2[0]['sum1'])
						), array( 'kodavans' => $_ROW1['kodavans'] )
					);
				// Пишем остаток аванса
					$db->update( 'dognet_docavans', array(
						'ostatokavans' => ($_ROW1['summaavans'] - $_QRY2[0]['sum1'])
						), array( 'kodavans' => $_ROW1['kodavans'] )
					);
				}
*/
		}
	}
	#
	#
	#
	# ----- ----- ----- ----- -----
	#
	#
	#
	if ($source_tableName == "kalplanchf") {

		if ($action == "DEL") {
			// Выбираем данные счета-фактуры по ID записи (id) из таблицы счетов dognet_kalplanchf
			$_QRY_CHF = $db->sql("SELECT kodchfact FROM dognet_kalplanchf WHERE id=" . $source_rowID)->fetchAll();
			if ($_QRY_CHF) {

				$_QRY = $db->sql("SELECT * FROM dognet_chfavans WHERE kodchfact=" . $_QRY_CHF[0]['kodchfact'])->fetchAll();
				if ($_QRY) {
					$__kodavans = $_QRY[0]['kodavans'];
					$__summaoplav = $_QRY[0]['summaoplav'];
					$_QRY0 = $db->sql("SELECT koddoc FROM dognet_docavans WHERE kodavans=" . $__kodavans)->fetchAll();
					if ($_QRY0) {
						$_QRY1 = mysqlQuery("SELECT * FROM dognet_docavans WHERE koddoc=" . $_QRY0[0]['koddoc']);
						while ($_ROW1 = mysqli_fetch_assoc($_QRY1)) {
							$_QRY2 = $db->sql("SELECT SUM(summaoplav) as sum1 FROM dognet_chfavans WHERE kodavans=" . $_ROW1['kodavans'])->fetchAll();
							if ($_QRY[0]['kodavans'] == $_ROW1['kodavans']) {
								// Пишем в таблицу задолженностей счетов-фактур
								$db->update(
									'dognet_docavans_ostatok',
									array(
										'summaavans' => $_ROW1['summaavans'],
										'ostatokavans' => ($_ROW1['summaavans'] - ($_QRY2[0]['sum1']) + $__summaoplav)
									),
									array('kodavans' => $_ROW1['kodavans'])
								);
								// Пишем остаток аванса
								$db->update(
									'dognet_docavans',
									array(
										'ostatokavans' => ($_ROW1['summaavans'] - ($_QRY2[0]['sum1']) + $__summaoplav)
									),
									array('kodavans' => $_ROW1['kodavans'])
								);
							} else {
								// Пишем в таблицу задолженностей счетов-фактур
								$db->update(
									'dognet_docavans_ostatok',
									array(
										'summaavans' => $_ROW1['summaavans'],
										'ostatokavans' => ($_ROW1['summaavans'] - $_QRY2[0]['sum1'])
									),
									array('kodavans' => $_ROW1['kodavans'])
								);
								// Пишем остаток аванса
								$db->update(
									'dognet_docavans',
									array(
										'ostatokavans' => ($_ROW1['summaavans'] - $_QRY2[0]['sum1'])
									),
									array('kodavans' => $_ROW1['kodavans'])
								);
							}
						}
					}
				}
			}
		}
		#
		#
	}
	if ($source_tableName == "kalplanchf_test") {

		if ($action == "DEL") {
			// Выбираем данные счета-фактуры по ID записи (id) из таблицы счетов dognet_kalplanchf
			$_QRY_CHF = $db->sql("SELECT kodchfact FROM dognet_kalplanchf WHERE id=" . $source_rowID)->fetchAll();
			$__kodchfact = $_QRY_CHF[0]['kodchfact'];
			if ($_QRY_CHF) {

				$_QRY = mysqlQuery("SELECT * FROM dognet_chfavans WHERE kodchfact='" . $__kodchfact . "'");
				while ($_ROW = mysqli_fetch_assoc($_QRY)) {
					$_kodavans = $_ROW['kodavans'];
					$_summaoplav = $_ROW['summaoplav'];
					$_QRY_DOCAV = $db->sql("SELECT koddoc FROM dognet_docavans WHERE kodavans=" . $_kodavans)->fetchAll();
					if ($_QRY_DOCAV) {
						$_koddoc = $_QRY_DOCAV[0]['koddoc'];
						$_QRY_DOCAVANS = mysqlQuery("SELECT * FROM dognet_docavans WHERE koddoc='" . $_koddoc . "' AND kodavans='" . $_kodavans . "'");
						while ($_ROW_DOCAVANS = mysqli_fetch_assoc($_QRY_DOCAVANS)) {
							$__kodavans = $_ROW_DOCAVANS['kodavans'];
							$_QRY_SUMOPLAV = $db->sql("SELECT SUM(summaoplav) as sum1 FROM dognet_chfavans WHERE kodavans='" . $__kodavans . "'")->fetchAll();
							$__summaavans = $_ROW_DOCAVANS['summaavans'];
							$__summaoplav = $_QRY_SUMOPLAV[0]['sum1'];
							if ($_kodavans == $__kodavans) {
								// Пишем в таблицу задолженностей счетов-фактур
								$db->update(
									'dognet_docavans_ostatok',
									array(
										'summaavans' => $__summaavans,
										'ostatokavans' => ($__summaavans - $__summaoplav) + $_summaoplav
									),
									array('kodavans' => $__kodavans)
								);
								// Пишем остаток аванса
								$db->update(
									'dognet_docavans',
									array(
										'ostatokavans' => ($__summaavans - $__summaoplav) + $_summaoplav
									),
									array('kodavans' => $__kodavans)
								);
							} else {
								// Пишем в таблицу задолженностей счетов-фактур
								$db->update(
									'dognet_docavans_ostatok',
									array(
										'summaavans' => $__summaavans,
										'ostatokavans' => ($__summaavans - $__summaoplav)
									),
									array('kodavans' => $__kodavans)
								);
								// Пишем остаток аванса
								$db->update(
									'dognet_docavans',
									array(
										'ostatokavans' => ($__summaavans - $__summaoplav)
									),
									array('kodavans' => $__kodavans)
								);
							}
						}
					}
				}
			}
		}
		#
		#
	}
	#
	#
	#
	# ----- ----- ----- ----- -----
	#
	#
	#
	if ($source_tableName == "chfavans") {

		if ($action == "CRT") {
			// Выбираем данные счета-фактуры по ID записи (id) из таблицы счетов dognet_kalplanchf
			$_QRY = $db->sql("SELECT * FROM dognet_chfavans WHERE id=" . $source_rowID)->fetchAll();
			if ($_QRY) {
				$__kodavans = $_QRY[0]['kodavans'];
				$__summaoplav = $_QRY[0]['summaoplav'];
			}
			$_QRY0 = $db->sql("SELECT koddoc FROM dognet_docavans WHERE kodavans=" . $__kodavans)->fetchAll();
			if ($_QRY0) {
				$_QRY1 = mysqlQuery("SELECT * FROM dognet_docavans WHERE koddoc=" . $_QRY0[0]['koddoc']);
				while ($_ROW1 = mysqli_fetch_assoc($_QRY1)) {
					$_QRY2 = $db->sql("SELECT SUM(summaoplav) as sum1 FROM dognet_chfavans WHERE kodavans=" . $_ROW1['kodavans'])->fetchAll();
					// Пишем в таблицу задолженностей счетов-фактур
					$db->update(
						'dognet_docavans_ostatok',
						array(
							'summaavans' => $_ROW1['summaavans'],
							'ostatokavans' => ($_ROW1['summaavans'] - $_QRY2[0]['sum1'])
						),
						array('kodavans' => $_ROW1['kodavans'])
					);
					// Пишем остаток аванса
					$db->update(
						'dognet_docavans',
						array(
							'ostatokavans' => ($_ROW1['summaavans'] - $_QRY2[0]['sum1'])
						),
						array('kodavans' => $_ROW1['kodavans'])
					);
				}
			}
		}
		#
		#
		if ($action == "UPD") {
			// Выбираем данные счета-фактуры по ID записи (id) из таблицы счетов dognet_kalplanchf
			$_QRY = $db->sql("SELECT * FROM dognet_chfavans WHERE id=" . $source_rowID)->fetchAll();
			if ($_QRY) {
				$__kodavans = $_QRY[0]['kodavans'];
				$__summaoplav = $_QRY[0]['summaoplav'];
			}
			$_QRY0 = $db->sql("SELECT koddoc FROM dognet_docavans WHERE kodavans=" . $__kodavans)->fetchAll();
			if ($_QRY0) {
				$_QRY1 = mysqlQuery("SELECT * FROM dognet_docavans WHERE koddoc=" . $_QRY0[0]['koddoc']);
				while ($_ROW1 = mysqli_fetch_assoc($_QRY1)) {
					$_QRY2 = $db->sql("SELECT SUM(summaoplav) as sum1 FROM dognet_chfavans WHERE kodavans=" . $_ROW1['kodavans'])->fetchAll();
					// Пишем в таблицу задолженностей счетов-фактур
					$db->update(
						'dognet_docavans_ostatok',
						array(
							'summaavans' => $_ROW1['summaavans'],
							'ostatokavans' => ($_ROW1['summaavans'] - $_QRY2[0]['sum1'])
						),
						array('kodavans' => $_ROW1['kodavans'])
					);
					// Пишем остаток аванса
					$db->update(
						'dognet_docavans',
						array(
							'ostatokavans' => ($_ROW1['summaavans'] - $_QRY2[0]['sum1'])
						),
						array('kodavans' => $_ROW1['kodavans'])
					);
				}
			}
		}
		#
		#
		if ($action == "DEL") {
			// Выбираем данные счета-фактуры по ID записи (id) из таблицы счетов dognet_kalplanchf
			$_QRY = $db->sql("SELECT * FROM dognet_chfavans WHERE id=" . $source_rowID)->fetchAll();
			if ($_QRY) {
				$__kodavans = $_QRY[0]['kodavans'];
				$__summaoplav = $_QRY[0]['summaoplav'];
			}
			$_QRY0 = $db->sql("SELECT koddoc FROM dognet_docavans WHERE kodavans=" . $__kodavans)->fetchAll();
			if ($_QRY0) {
				$_QRY1 = mysqlQuery("SELECT * FROM dognet_docavans WHERE koddoc=" . $_QRY0[0]['koddoc']);
				while ($_ROW1 = mysqli_fetch_assoc($_QRY1)) {
					$_QRY2 = $db->sql("SELECT SUM(summaoplav) as sum1 FROM dognet_chfavans WHERE kodavans=" . $_ROW1['kodavans'])->fetchAll();
					if ($_QRY[0]['kodavans'] == $_ROW1['kodavans']) {
						// Пишем в таблицу задолженностей счетов-фактур
						$db->update(
							'dognet_docavans_ostatok',
							array(
								'summaavans' => $_ROW1['summaavans'],
								'ostatokavans' => ($_ROW1['summaavans'] - ($_QRY2[0]['sum1']) + $__summaoplav)
							),
							array('kodavans' => $_ROW1['kodavans'])
						);
						// Пишем остаток аванса
						$db->update(
							'dognet_docavans',
							array(
								'ostatokavans' => ($_ROW1['summaavans'] - ($_QRY2[0]['sum1']) + $__summaoplav)
							),
							array('kodavans' => $_ROW1['kodavans'])
						);
					} else {
						// Пишем в таблицу задолженностей счетов-фактур
						$db->update(
							'dognet_docavans_ostatok',
							array(
								'summaavans' => $_ROW1['summaavans'],
								'ostatokavans' => ($_ROW1['summaavans'] - $_QRY2[0]['sum1'])
							),
							array('kodavans' => $_ROW1['kodavans'])
						);
						// Пишем остаток аванса
						$db->update(
							'dognet_docavans',
							array(
								'ostatokavans' => ($_ROW1['summaavans'] - $_QRY2[0]['sum1'])
							),
							array('kodavans' => $_ROW1['kodavans'])
						);
					}
				}
			}
		}
	}
	#
	#
	#
	# ----- ----- ----- ----- -----
	#
	#
	#
}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
# ОПРЕДЕЛЕНИЕ ПРОГРЕССА ПО ЭТАПУ
# + $kodkalplan - ID этапа
# + $action - кнопка вызова процедуры (New, Edit, Delete)
# + $source_rowID - ID строки исходных данных источника
# + $source_tableName - имя таблицы-источника
# + $db - драйвер БД
#
function DOCSTAGE_PR_PROGRESS($db, $source_tableName, $source_rowID, $action) {
	#
	#
	if ($source_tableName == "docavans") {
		if ($action == "CRT" || $action == "UPD") {
			// Выбираем данные счета-фактуры по ID записи (id) из таблицы счетов dognet_kalplanchf
			$_QRY = $db->sql("SELECT * FROM dognet_docavans WHERE id=" . $source_rowID)->fetchAll();
			$_QRY_S = mysqlQuery("SELECT SUM(summaavans) as SumAllAvans FROM dognet_docavans WHERE koddoc=" . $_QRY[0]['koddoc']);
			$_ROW_S = mysqli_fetch_assoc($_QRY_S);
			$db->update('dognet_dockalplan_progress', array(
				'sumavstage'	=>	$_ROW_S['SumAllAvans']
			), array('kodkalplan' => $_QRY[0]['koddoc']));
		}
		if ($action == "DEL") {
			$_QRY = $db->sql("SELECT * FROM dognet_docavans WHERE id=" . $source_rowID)->fetchAll();
			$_QRY_S = mysqlQuery("SELECT SUM(summaavans) as SumAllAvans FROM dognet_docavans WHERE koddoc=" . $_QRY[0]['koddoc']);
			$_ROW_S = mysqli_fetch_assoc($_QRY_S);
			$db->update('dognet_dockalplan_progress', array(
				'sumavstage'	=>	$_ROW_S['SumAllAvans'] - $_QRY[0]['summaavans']
			), array('kodkalplan' => $_QRY[0]['koddoc']));
		}
	}
	#
	#
	if ($source_tableName == "kalplanchf") {
		if ($action == "CRT") {
			// Выбираем данные счета-фактуры по ID записи (id) из таблицы счетов dognet_kalplanchf
			$_QRY = $db->sql("SELECT * FROM dognet_kalplanchf WHERE id=" . $source_rowID)->fetchAll();
			$db->update('dognet_dockalplan_progress', array(
				'sumchfstage'	=>	DOCBASE_FN_SUM_CHF_STAGE($_QRY[0]['kodkalplan'])
			), array('kodkalplan' => $_QRY[0]['kodkalplan']));
		}
		if ($action == "UPD") {
			// Выбираем данные счета-фактуры по ID записи (id) из таблицы счетов dognet_kalplanchf
			$_QRY = $db->sql("SELECT * FROM dognet_kalplanchf WHERE id=" . $source_rowID)->fetchAll();
			$db->update('dognet_dockalplan_progress', array(
				'sumchfstage'	=>	DOCBASE_FN_SUM_CHF_STAGE($_QRY[0]['kodkalplan'])
			), array('kodkalplan' => $_QRY[0]['kodkalplan']));
		}
		if ($action == "DEL") {
			$_QRY = $db->sql("SELECT * FROM dognet_kalplanchf WHERE id=" . $source_rowID)->fetchAll();
			$db->update('dognet_dockalplan_progress', array(
				'sumchfstage'	=>	DOCBASE_FN_SUM_CHF_STAGE($_QRY[0]['kodkalplan']) - $_QRY[0]['chetfsumma']
			), array('kodkalplan' => $_QRY[0]['kodkalplan']));
		}
	}
	#
	#
	if ($source_tableName == "chfavans") {
		// ----- ----- -----
		$_QRY1 = $db->sql("SELECT kodavans, summaoplav FROM dognet_chfavans WHERE id=" . $source_rowID)->fetchAll();
		// ----- ----- -----
		$_QRY2 = $db->sql("SELECT koddoc FROM dognet_docavans WHERE kodavans=" . $_QRY1[0]['kodavans'])->fetchAll();
		$_QRY = mysqlQuery("SELECT kodchfact FROM dognet_kalplanchf WHERE kodkalplan=" . $_QRY2[0]['koddoc']);
		$_sumAvansChf = 0;
		if ($_QRY) {
			while ($_ROW = mysqli_fetch_assoc($_QRY)) {
				$_kodchfact = $_ROW['kodchfact'];
				$_SUBQRY1 = mysqlQuery("SELECT SUM(summaoplav) as sumoplav FROM dognet_chfavans WHERE kodchfact=" . $_kodchfact);
				$_SUBROW1 = mysqli_fetch_assoc($_SUBQRY1);
				$_sumAvansChf += $_SUBROW1['sumoplav'];
			}
		}
		if ($action == "CRT") {
			$db->update('dognet_dockalplan_progress', array(
				'sumoplavstage'	=>	$_sumAvansChf + $_QRY1[0]['summaoplav']
			), array('kodkalplan' => $_QRY2[0]['koddoc']));
		}
		#
		if ($action == "UPD") {
			$db->update('dognet_dockalplan_progress', array(
				'sumoplavstage'	=>	$_sumAvansChf
			), array('kodkalplan' => $_QRY2[0]['koddoc']));
		}
		#
		if ($action == "DEL") {
			$db->update('dognet_dockalplan_progress', array(
				'sumoplavstage'	=>	$_sumAvansChf - $_QRY1[0]['summaoplav']
			), array('kodkalplan' => $_QRY2[0]['koddoc']));
		}
	}
	#
	#
	if ($source_tableName == "oplatachf") {
		if ($action == "CRT") {
			// Выбираем данные счета-фактуры по ID записи (id) из таблицы счетов dognet_kalplanchf
			$_QRY1 = $db->sql("SELECT kodchfact FROM dognet_oplatachf WHERE id=" . $source_rowID)->fetchAll();
			// Выбираем данные счета-фактуры по ID записи (id) из таблицы счетов dognet_kalplanchf
			$_QRY2 = $db->sql("SELECT kodkalplan FROM dognet_kalplanchf WHERE kodchfact=" . $_QRY1[0]['kodchfact'])->fetchAll();
			$db->update('dognet_dockalplan_progress', array(
				'sumoplchfstage'	=>	DOCBASE_FN_SUM_OPLATCHF_STAGE($_QRY2[0]['kodkalplan'])
			), array('kodkalplan' => $_QRY2[0]['kodkalplan']));
		}
		if ($action == "UPD") {
			// Выбираем данные счета-фактуры по ID записи (id) из таблицы счетов dognet_kalplanchf
			$_QRY1 = $db->sql("SELECT kodchfact FROM dognet_oplatachf WHERE id=" . $source_rowID)->fetchAll();
			// Выбираем данные счета-фактуры по ID записи (id) из таблицы счетов dognet_kalplanchf
			$_QRY2 = $db->sql("SELECT kodkalplan FROM dognet_kalplanchf WHERE kodchfact=" . $_QRY1[0]['kodchfact'])->fetchAll();
			$db->update('dognet_dockalplan_progress', array(
				'sumoplchfstage'	=>	DOCBASE_FN_SUM_OPLATCHF_STAGE($_QRY2[0]['kodkalplan'])
			), array('kodkalplan' => $_QRY2[0]['kodkalplan']));
		}
		if ($action == "DEL") {
			// Выбираем данные счета-фактуры по ID записи (id) из таблицы счетов dognet_kalplanchf
			$_QRY1 = $db->sql("SELECT kodchfact, summaopl FROM dognet_oplatachf WHERE id=" . $source_rowID)->fetchAll();
			// Выбираем данные счета-фактуры по ID записи (id) из таблицы счетов dognet_kalplanchf
			$_QRY2 = $db->sql("SELECT kodkalplan FROM dognet_kalplanchf WHERE kodchfact=" . $_QRY1[0]['kodchfact'])->fetchAll();
			$db->update('dognet_dockalplan_progress', array(
				'sumoplchfstage'	=>	DOCBASE_FN_SUM_OPLATCHF_STAGE($_QRY2[0]['kodkalplan']) - $_QRY1[0]['summaopl']
			), array('kodkalplan' => $_QRY2[0]['kodkalplan']));
		}
	}
	#
	#
}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
# АВТОМАТИЧЕСКОЕ ФОРМИРОВАНИЕ БАЗОВОГО КАЛЕНДАРНОГО ПЛАНА
# ПРИ СОЗДАНИИ НОВОГО ДОГОВОРА
# + $action - кнопка вызова процедуры (New, Edit, Delete)
# + $source_rowID - ID строки исходных данных источника
# + $source_tableName - имя таблицы-источника
# + $db - драйвер БД
#
function DOCKALPLAN_PR_CREATE_DEFPLAN($db, $source_tableName, $source_rowID, $action) {
	#
	#
	if ($source_tableName == "docbase") {
		#
		#
		if ($action == "CRT") {
			// Выбираем данные вновь созданного договора по ID записи (id) из таблицы договоров dognet_docbase
			$_QRY = $db->sql("SELECT * FROM dognet_docbase WHERE id=" . $source_rowID)->fetchAll();
			if ($_QRY && $_QRY[0]['kodshab'] == 1 || $_QRY[0]['kodshab'] == 3) {
				$nextkodkalplan = nextKodkalplan();
				$db->insert('dognet_dockalplan', array(
					'koddoc' =>	$_QRY[0]['koddoc'],
					'kodkalplan' =>	$nextkodkalplan,
					'kodobject' =>	$_QRY[0]['kodobject'],
					'numberstage' => '1',
					'nameshotstage' => $_QRY[0]['docnameshot'],
					'namefullstage' => $_QRY[0]['docnamefullm'],
					'kodobject' =>	$_QRY[0]['kodobject'],
					'summastage' =>	$_QRY[0]['docsumma']
				));

				$db->insert('dognet_dockalplan_progress', array(
					'koddoc' =>	$_QRY[0]['koddoc'],
					'kodkalplan' =>	$nextkodkalplan,
					'stagecreated' => date("Y-m-d"),
					'summastage' =>	$_QRY[0]['docsumma']
				));
			}
		}
		#
		#
	}
	#
	#
}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
# ПОЛНОЕ УДАЛЕНИЕ ДОГОВОРА И ВСЕ СВЯЗАННЫХ С НИМ ЭТАПОВ, СЧЕТОВ, ОПЛАТ, АВАНСОВ И ДОГОВОРОВ СУБПОДРЯДА
# + $koddoc - ID договора
# + $action - кнопка вызова процедуры (New, Edit, Delete)
# + $kodshab - шаблон договора, с календарным планом (1) или без (2)
# + $source_rowID - ID строки исходных данных источника
# + $source_tableName - имя таблицы-источника
# + $db - драйвер БД
#
function DOCBASE_PR_FULLREMOVE_DOC($db, $source_rowID) {

	// Определяем ID и шаблон текущего договора (kodshab) по ID записи (id) из таблицы договоров dognet_docbase
	$_QRY = $db->sql("SELECT koddoc, kodshab FROM dognet_docbase WHERE id=" . $source_rowID)->fetchAll();
	#
	# ----- ----- ----- ----- -----
	#
	// Если договор создан с календарным планом (kodshab=1)
	if ($_QRY[0]['kodshab'] == 1 || $_QRY[0]['kodshab'] == 3) {
		if ($_QRY) {
			$__koddoc = $_QRY[0]['koddoc'];
			// Выбираем все календарные планы по договору (kodkalplan)
			$_QRY1 = mysqlQuery("SELECT kodkalplan FROM dognet_dockalplan WHERE koddoc=" . $_QRY[0]['koddoc']);
			while ($_ROW1 = mysqli_fetch_assoc($_QRY1)) {
				// Выбираем все счета-фактуры (kodchfact) по календарному плану выбранному в цикле выше
				$_SUBQRY1 = mysqlQuery("SELECT kodchfact FROM dognet_kalplanchf WHERE kodkalplan=" . $_ROW1['kodkalplan']);
				while ($_SUBROW1 = mysqli_fetch_assoc($_SUBQRY1)) {
					// Удаляем все оплаты по счету-фактуре (kodchfact)
					$_SUBSUBQRY_DEL1 = $db->sql("DELETE FROM dognet_oplatachf WHERE kodchfact=" . $_SUBROW1['kodchfact']);
					// Удаляем все авансы по счету-фактуре (kodchfact)
					$_SUBSUBQRY_DEL2 = $db->sql("DELETE FROM dognet_chfavans WHERE kodchfact=" . $_SUBROW1['kodchfact']);
				}
				// Удаляем сами счета-фактуры по заданному в цикле этапу
				$_SUBQRY_DEL1 = $db->sql("DELETE FROM dognet_kalplanchf WHERE kodkalplan=" . $_ROW1['kodkalplan']);
				// Удаляем таблицу задолженностей по счету-фактуре по заданному в цикле этапу
				$_SUBQRY_DEL1 = $db->sql("DELETE FROM dognet_kalplanchf_zadol WHERE kodkalplan=" . $_ROW1['kodkalplan']);
				// Удаляем сами счета-фактуры по заданному в цикле этапу
				$_SUBQRY_DEL2 = $db->sql("DELETE FROM dognet_docavans WHERE koddoc=" . $_ROW1['kodkalplan']);
			}
			// Удаляем сами этапы по выбранному договору
			$_QRY_DEL1 = $db->sql("DELETE FROM dognet_dockalplan WHERE koddoc=" . $_QRY[0]['koddoc']);
			$_QRY_DEL2 = $db->sql("DELETE FROM dognet_dockalplan_progress WHERE koddoc=" . $_QRY[0]['koddoc']);
		}
	}
	# ----- ----- ----- ----- -----
	#
	// Если договор создан без календарного плана (kodshab=2)
	if ($_QRY[0]['kodshab'] != 1 || $_QRY[0]['kodshab'] != 3) {
		if ($_QRY) {
			$__koddoc = $_QRY[0]['koddoc'];
			// Выбираем все счета-фактуры (kodchfact) по календарному плану выбранному в цикле выше
			$_SUBQRY1 = mysqlQuery("SELECT kodchfact FROM dognet_kalplanchf WHERE kodkalplan=" . $__koddoc);
			while ($_SUBROW1 = mysqli_fetch_assoc($_SUBQRY1)) {
				// Удаляем все оплаты по счету-фактуре (kodchfact)
				$_SUBSUBQRY_DEL1 = $db->sql("DELETE FROM dognet_oplatachf WHERE kodchfact=" . $_SUBROW1['kodchfact']);
				// Удаляем все авансы по счету-фактуре (kodchfact)
				$_SUBSUBQRY_DEL2 = $db->sql("DELETE FROM dognet_chfavans WHERE kodchfact=" . $_SUBROW1['kodchfact']);
			}
			// Удаляем сами счета-фактуры по заданному в цикле этапу
			$_SUBQRY_DEL1 = $db->sql("DELETE FROM dognet_kalplanchf WHERE kodkalplan=" . $__koddoc);
			// Удаляем таблицу задолженностей по счету-фактуре по заданному в цикле этапу
			$_SUBQRY_DEL1 = $db->sql("DELETE FROM dognet_kalplanchf_zadol WHERE kodkalplan=" . $__koddoc);
			// Удаляем сами счета-фактуры по заданному в цикле этапу
			$_SUBQRY_DEL2 = $db->sql("DELETE FROM dognet_docavans WHERE koddoc=" . $__koddoc);
		}
	}
	#
	#
}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
# ФИКСАЦИЯ МОМЕНТА ПЕРЕХОДА ДОГОВОРА В РЕЖИМ РЕДАКТИРОВАНИЯ
function DOCBASE_PR_DOC_LOCK_FOR_EDIT($koddoc) {
	#
	#
	// Проверяем был ли договор заблокирован для редактирования ранее
	$_QRY_0 = mysqlQuery("SELECT * FROM dognet_doc_locked WHERE koddoc=" . $koddoc);
	$_ROW_0 = mysqli_fetch_assoc($_QRY_0);

	if (mysqli_num_rows($_QRY_0) > 0) {
		// Закрываем договор для редактирования для других пользователей
		$_QRY = mysqlQuery("UPDATE dognet_doc_locked SET last_edit_timestamp = NOW() WHERE koddoc=" . $koddoc);
	} else {
		// Выбираем ID редактируемого договора по ID записи (id) из таблицы договоров dognet_docbase
		$_QRY = mysqlQuery("SELECT id FROM dognet_docbase WHERE koddoc=" . $koddoc);
		$_ROW = mysqli_fetch_assoc($_QRY);
		$_koddoc = $koddoc;
		//
		$_docRowID = $_ROW['id'];
		$_userID = $_SESSION['id'];
		$_userLogin = $_SESSION['login'];
		$_userLastname = $_SESSION['lastname'];
		$_userSESSID = session_id();
		$_userAgent = $_SERVER['HTTP_USER_AGENT'];
		$_userIP = $_SERVER['REMOTE_ADDR'];
		// Закрываем договор для редактирования для других пользователей
		$_QRY_BLOCK = mysqlQuery("INSERT INTO dognet_doc_locked (koddoc, doc_rowid, user_id, ip, SESSID, user_login, user_lastname, user_agent, start_edit_timestamp, last_edit_timestamp, status, comment) VALUES ('$_koddoc', '$_docRowID', '$_userID', '$_userIP', '$_userSESSID', '$_userLogin', '$_userLastname', '$_userAgent', NOW(), NOW(), '-1', '')");
	}
	#
	#
}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
# ПРОВЕРЯЕМ ДОГОВОР НА ВОЗМОЖНОСТЬ РЕДАКТИРОВАНИЯ
function DOCBASE_FN_DOC_CHECK_FOR_EDIT($koddoc) {
	#
	#
	// Выбираем ID редактируемого договора по ID записи (id) из таблицы договоров dognet_docbase
	$_QRY = mysqlQuery("SELECT * FROM dognet_doc_locked WHERE koddoc=" . $koddoc);
	$_ROW = mysqli_fetch_assoc($_QRY);
	$_koddoc = $koddoc;
	//
	$_userID = $_SESSION['id'];
	$_userLogin = $_SESSION['login'];
	$_userLastname = $_SESSION['lastname'];
	$_userSESSID = session_id();
	$_userAgent = $_SERVER['HTTP_USER_AGENT'];
	$_userIP = $_SERVER['REMOTE_ADDR'];
	//
	if (((!empty($_ROW['user_id']) ? $_ROW['user_id'] : "") == $_userID) or (mysqli_num_rows($_QRY) == 0)) {
		return 1;
	} else {
		return 0;
	}
	#
	#
}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
# СНИМАЕМ БЛОКИРОВКУ РЕДАКТИРОВАНИЯ С ДОГОВОРА
function DOCBASE_FN_DOC_UNLOCK_FOR_EDIT($koddoc) {
	#
	#
	// Выбираем ID редактируемого договора по ID записи (id) из таблицы договоров dognet_docbase
	$_QRY = mysqlQuery("SELECT * FROM dognet_doc_locked WHERE koddoc=" . $koddoc);
	$_ROW = mysqli_fetch_assoc($_QRY);
	$_ROWSNUM = mysqli_num_rows($_QRY);
	//
	$_userID = $_ROW['user_id'];
	// Удаляем запись
	if ($_QRY) {
		if ($_ROWSNUM > 0) {
			$_QRY_DELETE = mysqlQuery("DELETE FROM dognet_doc_locked WHERE koddoc=" . $koddoc . " AND user_id = " . $_userID);
			if ($_QRY_DELETE) {
				return 1;
			} else {
				return 0;
			}
		} else {
			return 1;
		}
	} else {
		return 1;
		mysqli_free_result($_QRY);
	}
	#
	#
}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
# ОПРЕДЕЛЯЕМ ПОЛЬЗОВАТЕЛЯ, РЕДАКТИРУЮЩЕГО ДОГОВОР
function DOCBASE_FN_USERNAME_LOCK_FOR_EDIT($koddoc) {
	#
	#
	// Выбираем ID редактируемого договора по ID записи (id) из таблицы договоров dognet_docbase
	$_QRY_0 = mysqlQuery("SELECT * FROM dognet_doc_locked WHERE koddoc=" . $koddoc);
	$_ROW_0 = mysqli_fetch_assoc($_QRY_0);
	//
	$_userID = $_ROW_0['user_id'];
	// Удаляем запись
	$_QRY = mysqlQuery("SELECT lastname, firstname FROM users WHERE id=" . $_userID);
	$_ROW = mysqli_fetch_assoc($_QRY);
	//
	if ($_QRY) {
		return $_ROW['lastname'] . " " . $_ROW['firstname'];
	} else {
		return "Пользователь не установлен";
	}
	#
	#
}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
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
			// $_CHF_OPL_AVS_0 = $_QRY[0]['sumavsubpodr'];
			$_CHF_OPL_AVS_0 = $_QRY[0]['sumchfavsubpodr'];
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
			if (($kod === $__kodchfact) and $action == "PREDEL") {
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
		if ($action == "PREDEL") {
			$db->update('dognet_docsubpodr', array(
				'sumzadolsubpodr' =>	$_CHF_SUM - ($_CHF_OPL_SUM + $_CHF_OPL_AVS_SUM + $_CHF_OPL_AVSPLIT_SUM)
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
			if (($kod === $__kodchfact) and $action == "PREDEL") {
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
		if ($action == "PREDEL") {
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
			if (($kod === $__kodchfact) and $action == "PREDEL") {
				$_NEW_sumzadolchfact = $__summachfact - (($__summaopl - $_CHF_OPL_0) + $__sumoplavans + $__sumsplit);
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
		// по договору ($__koddocsubpodr)
		if ($action == "CRT" or $action == "UPD") {
			$db->update('dognet_docsubpodr', array(
				'sumzadolsubpodr' =>	$_CHF_SUM - ($_CHF_OPL_SUM + $_CHF_OPL_AVS_SUM + $_CHF_OPL_AVSPLIT_SUM)
			), array('koddocsubpodr' => $__koddocsubpodr));
		}
		if ($action == "PREDEL") {
			$db->update('dognet_docsubpodr', array(
				'sumzadolsubpodr' =>	$_CHF_SUM - (($_CHF_OPL_SUM - $_CHF_OPL_0) + $_CHF_OPL_AVS_SUM + $_CHF_OPL_AVSPLIT_SUM)
			), array('koddocsubpodr' => $__koddocsubpodr));
		}
	}
	#
	#
}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#

/**
 * Возвращает сумму прописью
 * @author runcore
 * @uses morph(...)
 */
function num2str($num) {
	$nul = 'ноль';
	$ten = array(
		array('', 'один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'),
		array('', 'одна', 'две', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять')
	);
	$a20 = array('десять', 'одиннадцать', 'двенадцать', 'тринадцать', 'четырнадцать', 'пятнадцать', 'шестнадцать', 'семнадцать', 'восемнадцать', 'девятнадцать');
	$tens = array(2 => 'двадцать', 'тридцать', 'сорок', 'пятьдесят', 'шестьдесят', 'семьдесят', 'восемьдесят', 'девяносто');
	$hundred = array('', 'сто', 'двести', 'триста', 'четыреста', 'пятьсот', 'шестьсот', 'семьсот', 'восемьсот', 'девятьсот');
	$unit = array(
		array('копейка', 'копейки',   'копеек',     1),
		array('рубль',    'рубля',     'рублей',     0),
		array('тысяча',   'тысячи',    'тысяч',      1),
		array('миллион',  'миллиона',  'миллионов',  0),
		array('миллиард', 'миллиарда', 'миллиардов', 0),
	);

	list($rub, $kop) = explode('.', sprintf("%015.2f", floatval($num)));
	$out = array();
	if (intval($rub) > 0) {
		foreach (str_split($rub, 3) as $uk => $v) {
			if (!intval($v)) continue;
			$uk = sizeof($unit) - $uk - 1;
			$gender = $unit[$uk][3];
			list($i1, $i2, $i3) = array_map('intval', str_split($v, 1));
			// mega-logic
			$out[] = $hundred[$i1]; // 1xx-9xx
			if ($i2 > 1) $out[] = $tens[$i2] . ' ' . $ten[$gender][$i3]; // 20-99
			else $out[] = $i2 > 0 ? $a20[$i3] : $ten[$gender][$i3]; // 10-19 | 1-9
			// units without rub & kop
			if ($uk > 1) $out[] = morph($v, $unit[$uk][0], $unit[$uk][1], $unit[$uk][2]);
		}
	} else {
		$out[] = $nul;
	}
	$out[] = morph(intval($rub), $unit[1][0], $unit[1][1], $unit[1][2]); // rub
	$out[] = $kop . ' ' . morph($kop, $unit[0][0], $unit[0][1], $unit[0][2]); // kop
	return trim(preg_replace('/ {2,}/', ' ', join(' ', $out)));
}

/**
 * Склоняем словоформу
 * @author runcore
 */
function morph($n, $f1, $f2, $f5) {
	$n = abs(intval($n)) % 100;
	if ($n > 10 && $n < 20) return $f5;
	$n = $n % 10;
	if ($n > 1 && $n < 5) return $f2;
	if ($n == 1) return $f1;
	return $f5;
}
/**
 * проверяем, что функция mb_ucfirst не объявлена
 * и включено расширение mbstring (Multibyte String Functions)
 */
if (!function_exists('mb_ucfirst') && extension_loaded('mbstring')) {
	/**
	 * mb_ucfirst - преобразует первый символ в верхний регистр
	 * @param string $str - строка
	 * @param string $encoding - кодировка, по-умолчанию UTF-8
	 * @return string
	 */
	function mb_ucfirst($str, $encoding = 'UTF-8') {
		$str = mb_ereg_replace('^[\ ]+', '', $str);
		$str = mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding) .
			mb_substr($str, 1, mb_strlen($str), $encoding);
		return $str;
	}
}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
# Рассылка сообщений
#
function SendMessage_NewBlankCreate($tableName, $rowID, $numberblankwork, $emailTo) {
	#
	#
	$_QRY_BLANK = mysqlQuery("SELECT * FROM " . $tableName . " WHERE id=" . $rowID);
	$_ROW_BLANK = mysqli_fetch_assoc($_QRY_BLANK);

	$_QRY_ISPOL = mysqlQuery("SELECT ispolnameshot FROM dognet_spispol WHERE kodispol=" . $_ROW_BLANK['kodispol']);
	$_ROW_ISPOL = mysqli_fetch_assoc($_QRY_ISPOL);
	$_QRY_ISPOLRUK = mysqlQuery("SELECT ispolrukname FROM dognet_spispolruk WHERE kodispolruk=" . $_ROW_BLANK['kodispolruk']);
	$_ROW_ISPOLRUK = mysqli_fetch_assoc($_QRY_ISPOLRUK);

	switch ($tableName) {
		case "dognet_blankdocsub":
			$_TIP = "СУБ";
			break;
		case "dognet_blankdocpnr":
			$_TIP = "ПНР";
			break;
		case "dognet_blankdocpost":
			$_TIP = "ПОС";
			break;
		default:
			$_TIP = "---";
	}

	if ($tableName == "dognet_blankdocsub") {
		$_QRY_ZAKAZ = mysqlQuery("SELECT namesubpodrshot FROM dognet_spsubpodr WHERE kodsubpodr=" . $_ROW_BLANK['kodzakaz']);
		$_ROW_ZAKAZ = mysqli_fetch_assoc($_QRY_ZAKAZ);
		$_ZAK = $_ROW_ZAKAZ['namesubpodrshot'];
	} else {
		$_QRY_ZAKAZ = mysqlQuery("SELECT nameshort FROM sp_contragents WHERE kodcontragent=" . $_ROW_BLANK['kodzakaz']);
		$_ROW_ZAKAZ = mysqli_fetch_assoc($_QRY_ZAKAZ);
		$_ZAK = $_ROW_ZAKAZ['namezakshot'];
	}
	if ($tableName == "dognet_blankdocpnr") {
		$_QRY_OBJ = mysqlQuery("SELECT nameobjectshot FROM sp_objects WHERE kodobject=" . $_ROW_BLANK['kodobject']);
		$_ROW_OBJ = mysqli_fetch_assoc($_QRY_OBJ);
		$_OBJ = $_ROW_OBJ['nameobjectshot'];
	} else {
		$_OBJ = "---";
	}
	#
	# Instantiation and passing `true` enables exceptions
	$mail3 = new PHPMailer;
	$message = "";
	#
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	#
	$subjectTxt = "АТГС.Договор [Бланки] : новая заявка на договор";
	$subject = "=?utf-8?B?" . base64_encode($subjectTxt) . "?=";
	#


	// Подключаем стили
	$message_style = "<style>";
	$message_style .= "";
	$message_style .= "</style>";
	// ----- ----- -----
	// Header письма
	$message_header = "";
	// 	$message_header = "\r\n\r\n--".$boundary."\r\n";
	// 	$message_header .= "Content-type: text/html; charset=utf-8\r\n\r\n";
	// ----- ----- -----
	// Тело письма (top)
	$message_body = "
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"> <html style=\"width:100%;font-family:arial, 'helvetica neue', helvetica, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0;\"> <head> <meta charset=\"UTF-8\"> <meta content=\"width=device-width, initial-scale=1\" name=\"viewport\"> <meta name=\"x-apple-disable-message-reformatting\"> <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\"> <meta content=\"telephone=no\" name=\"format-detection\"> <title>Новый шаблон 2</title> <!--[if (mso 16)]><style type=\"text/css\">     a {text-decoration: none;}     </style><![endif]--> <!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]--> <style type=\"text/css\">
 @media only screen and (max-width:600px) {p, ul li, ol li, a { font-size:16px!important; line-height:150%!important } h1 { font-size:30px!important; text-align:center; line-height:120%!important } h2 { font-size:26px!important; text-align:center; line-height:120%!important } h3 { font-size:20px!important; text-align:center; line-height:120%!important } h1 a { font-size:30px!important } h2 a { font-size:26px!important } h3 a { font-size:20px!important } .es-menu td a { font-size:13px!important } .es-header-body p, .es-header-body ul li, .es-header-body ol li, .es-header-body a { font-size:16px!important } .es-footer-body p, .es-footer-body ul li, .es-footer-body ol li, .es-footer-body a { font-size:16px!important } .es-infoblock p, .es-infoblock ul li, .es-infoblock ol li, .es-infoblock a { font-size:12px!important } *[class=\"gmail-fix\"] { display:none!important } .es-m-txt-c, .es-m-txt-c h1, .es-m-txt-c h2, .es-m-txt-c h3 {
text-align:center!important } .es-m-txt-r, .es-m-txt-r h1, .es-m-txt-r h2, .es-m-txt-r h3 { text-align:right!important } .es-m-txt-l, .es-m-txt-l h1, .es-m-txt-l h2, .es-m-txt-l h3 { text-align:left!important } .es-m-txt-r img, .es-m-txt-c img, .es-m-txt-l img { display:inline!important } .es-button-border { display:block!important } a.es-button { font-size:16px!important; display:block!important; border-left-width:0px!important; border-right-width:0px!important } .es-btn-fw { border-width:10px 0px!important; text-align:center!important } .es-adaptive table, .es-btn-fw, .es-btn-fw-brdr, .es-left, .es-right { width:100%!important } .es-content table, .es-header table, .es-footer table, .es-content, .es-footer, .es-header { width:100%!important; max-width:600px!important } .es-adapt-td { display:block!important; width:100%!important } .adapt-img { width:100%!important; height:auto!important } .es-m-p0 { padding:0px!important } .es-m-p0r
{ padding-right:0px!important } .es-m-p0l { padding-left:0px!important } .es-m-p0t { padding-top:0px!important } .es-m-p0b { padding-bottom:0!important } .es-m-p20b { padding-bottom:20px!important } .es-mobile-hidden, .es-hidden { display:none!important } .es-desk-hidden { display:table-row!important; width:auto!important; overflow:visible!important; float:none!important; max-height:inherit!important; line-height:inherit!important } .es-desk-menu-hidden { display:table-cell!important } table.es-table-not-adapt, .esd-block-html table { width:auto!important } table.es-social { display:inline-block!important } table.es-social td { display:inline-block!important } } #outlook a { 	padding:0; } .ExternalClass { 	width:100%; } .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div { 	line-height:100%; } .es-button { 	mso-style-priority:100!important; 	text-decoration:none!important;
} a[x-apple-data-detectors] { 	color:inherit!important; 	text-decoration:none!important; 	font-size:inherit!important; 	font-family:inherit!important; 	font-weight:inherit!important; 	line-height:inherit!important; } .es-desk-hidden { 	display:none; 	float:left; 	overflow:hidden; 	width:0; 	max-height:0; 	line-height:0; 	mso-hide:all; } </style> </head> <body style=\"width:100%;font-family:arial, 'helvetica neue', helvetica, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0;\"> <div class=\"es-wrapper-color\" style=\"background-color:transparent;\"> <!--[if gte mso 9]><v:background xmlns:v=\"urn:schemas-microsoft-com:vml\" fill=\"t\"> <v:fill type=\"tile\" color=\"transparent\"></v:fill> </v:background><![endif]-->
 <table class=\"es-wrapper\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top;\"> <tr style=\"border-collapse:collapse;\"> <td valign=\"top\" style=\"padding:0;Margin:0;\"> <table cellpadding=\"0\" cellspacing=\"0\" class=\"es-content\" align=\"center\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;\"> <tr style=\"border-collapse:collapse;\"> <td align=\"center\" style=\"padding:0;Margin:0;\"> <table bgcolor=\"#ffffff\" class=\"es-content-body\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" width=\"580\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;\"> <tr style=\"border-collapse:collapse;\">
 <td align=\"left\" style=\"padding:0;Margin:0;\"> <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;\"> <tr style=\"border-collapse:collapse;\"> <td width=\"580\" align=\"center\" valign=\"top\" style=\"padding:0;Margin:0;\"> <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" role=\"presentation\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;\"> <tr style=\"border-collapse:collapse;\"> <td align=\"center\" style=\"padding:0;Margin:0;font-size:0px;\"><img class=\"adapt-img\" src=\"http://atgs.ru/ext/img/new-logo-dognet-2-w580px.jpg\" alt style=\"display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;\" width=\"580\" height=\"94\"></td> </tr> </table></td> </tr> </table></td> </tr> <tr style=\"border-collapse:collapse;\">
 <td align=\"left\" style=\"padding:0;Margin:0;padding-top:10px;padding-bottom:10px;\"> <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;\"> <tr style=\"border-collapse:collapse;\"> <td width=\"580\" align=\"left\" style=\"padding:0;Margin:0;\"> <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" role=\"presentation\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;\"> <tr style=\"border-collapse:collapse;\"> <td class=\"es-m-txt-c\" align=\"center\" style=\"Margin:0;padding-top:5px;padding-bottom:5px;padding-left:10px;padding-right:10px;\"><h1 style=\"Margin:0;line-height:36px;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:30px;font-style:normal;font-weight:normal;color:#A94442;\"><strong>НОВЫЙ БЛАНК</strong></h1></td> </tr> </table></td> </tr> </table></td> </tr>
 </table></td> </tr> </table> <table class=\"es-content\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;\"> <tr style=\"border-collapse:collapse;\"> <td align=\"center\" style=\"padding:0;Margin:0;\"> <table class=\"es-content-body\" width=\"580\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;border-left:2px solid transparent;border-right:2px solid transparent;border-top:2px solid transparent;border-bottom:2px solid transparent;\" bgcolor=\"#ffffff\"> <tr class=\"es-mobile-hidden\" style=\"border-collapse:collapse;\"> <td align=\"left\" bgcolor=\"#fafafa\" style=\"Margin:0;padding-top:20px;padding-bottom:20px;padding-left:20px;padding-right:20px;background-color:#FAFAFA;\">
 <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;\"> <tr style=\"border-collapse:collapse;\"> <td width=\"536\" valign=\"top\" align=\"center\" style=\"padding:0;Margin:0;\"> <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" role=\"presentation\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;\"> <tr style=\"border-collapse:collapse;\"> <td style=\"padding:0;Margin:0;\"> <table style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:100%;\" cellpadding=\"2\" cellspacing=\"1\" role=\"presentation\"> <tr style=\"border-collapse:collapse;line-height:20px;\"> <td width=\"35%\" style=\"padding:5px;Margin:0;\"><b>Номер бланка</b></td> <td style=\"padding:5px;Margin:0;border-bottom:1px #CCCCCC solid;\">" . $numberblankwork . "</td> </tr>  <tr style=\"border-collapse:collapse;line-height:20px;\"> <td width=\"35%\" style=\"padding:5px;Margin:0;\"><b>Тип бланка</b></td> <td style=\"padding:5px;Margin:0;border-bottom:1px #CCCCCC solid;\">" . $_TIP . "</td> </tr> <tr style=\"border-collapse:collapse;line-height:20px;\">
 <td width=\"35%\" style=\"padding:5px;Margin:0;\"><b>Описание</b></td> <td style=\"padding:5px;Margin:0;border-bottom:1px #CCCCCC solid;\">" . $_ROW_BLANK['namedocblank'] . "</td> </tr> <tr style=\"border-collapse:collapse;line-height:20px;\"> <td width=\"35%\" style=\"padding:5px;Margin:0;\"><b>ГИП</b></td> <td style=\"padding:5px;Margin:0;border-bottom:1px #CCCCCC solid;\">" . $_ROW_ISPOL['ispolnameshot'] . "</td> </tr> <tr style=\"border-collapse:collapse;line-height:20px;\"> <td width=\"35%\" style=\"padding:5px;Margin:0;\"><b>Руководитель</b></td> <td style=\"padding:5px;Margin:0;border-bottom:1px #CCCCCC solid;\">" . $_ROW_ISPOLRUK['ispolrukname'] . "</td> </tr> <tr style=\"border-collapse:collapse;line-height:20px;\"> <td width=\"35%\" style=\"padding:5px;Margin:0;\"><b>Заказчик / Подрядчик</b></td> <td style=\"padding:5px;Margin:0;border-bottom:1px #CCCCCC solid;\">" . $_ZAK . "</td> </tr> <tr style=\"border-collapse:collapse;line-height:20px;\"> <td width=\"35%\" style=\"padding:5px;Margin:0;\"><b>Объект</b></td>
 <td style=\"padding:5px;Margin:0;border-bottom:1px #CCCCCC solid;\">" . $_OBJ . "</td> </tr> <tr style=\"border-collapse:collapse;line-height:20px;\"> <td width=\"35%\" style=\"padding:5px;Margin:0;\"><b>Сумма</b></td> <td style=\"padding:5px;Margin:0;border-bottom:1px #CCCCCC solid;\">" . number_format((float)($_ROW_BLANK['csummadocopl']), 2, '.', ' ') . "</td> </tr> </table></td> </tr> </table></td> </tr> </table></td> </tr> </table></td> </tr> </table> <table cellpadding=\"0\" cellspacing=\"0\" class=\"es-content\" align=\"center\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;\"> <tr style=\"border-collapse:collapse;\"> <td align=\"center\" style=\"padding:0;Margin:0;\"> <table class=\"es-content-body\" width=\"580\" cellspacing=\"0\" cellpadding=\"0\" bgcolor=\"#ffffff\" align=\"center\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;\"> <tr style=\"border-collapse:collapse;\">
 <td align=\"left\" style=\"Margin:0;padding-top:15px;padding-bottom:20px;padding-left:20px;padding-right:20px;\"> <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;\"> <tr style=\"border-collapse:collapse;\"> <td width=\"540\" valign=\"top\" align=\"center\" style=\"padding:0;Margin:0;\"> <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" role=\"presentation\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;\"> <tr style=\"border-collapse:collapse;\"> <td class=\"es-infoblock\" align=\"center\" style=\"padding:0;Margin:0;line-height:14px;font-size:12px;color:#CCCCCC;\"><p style=\"Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:12px;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:14px;color:#CCCCCC;\">
<a target=\"_blank\" href=\"http://192.168.1.89/dognet/dognet-blankview.php?blankview_type=edit\" style=\"-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:12px;text-decoration:underline;color:#666666;\">Перейти в раздел БЛАНКИ</a></p></td> </tr> </table></td> </tr> </table></td> </tr> </table></td> </tr> </table> <table cellpadding=\"0\" cellspacing=\"0\" class=\"es-footer\" align=\"center\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top;\"> <tr style=\"border-collapse:collapse;\"> <td align=\"center\" style=\"padding:0;Margin:0;\">
 <table class=\"es-footer-body\" width=\"580\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#333333;\" bgcolor=\"#333333\"> <tr style=\"border-collapse:collapse;\"> <td align=\"left\" style=\"padding:0;Margin:0;padding-top:20px;padding-left:20px;padding-right:20px;\"> <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;\"> <tr style=\"border-collapse:collapse;\"> <td width=\"540\" valign=\"top\" align=\"center\" style=\"padding:0;Margin:0;\"> <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" role=\"presentation\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;\"> <tr style=\"border-collapse:collapse;\"> <td style=\"padding:0;Margin:0;\">
 <table class=\"es-menu\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" role=\"presentation\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;\"> <tr class=\"links\" style=\"border-collapse:collapse;\"> <td style=\"Margin:0;padding-left:5px;padding-right:5px;padding-top:0px;padding-bottom:0px;border:0;\" id=\"esd-menu-id-0\" width=\"25.00%\" bgcolor=\"transparent\" align=\"center\"><a target=\"_blank\" style=\"-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:14px;text-decoration:none;display:block;color:#FFFFFF;\" href=\"http://portal.atgs.ru\">Портал</a></td> <td style=\"Margin:0;padding-left:5px;padding-right:5px;padding-top:0px;padding-bottom:0px;border:0;border-left:1px solid #FFFFFF;\" id=\"esd-menu-id-1\" esdev-border-color=\"#ffffff\" width=\"25.00%\" bgcolor=\"transparent\" align=\"center\">
<a target=\"_blank\" style=\"-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:14px;text-decoration:none;display:block;color:#FFFFFF;\" href=\"http://portal.atgs.ru/mail/\">Почта</a></td> <td style=\"Margin:0;padding-left:5px;padding-right:5px;padding-top:0px;padding-bottom:0px;border:0;border-left:1px solid #FFFFFF;\" id=\"esd-menu-id-2\" esdev-border-color=\"#ffffff\" width=\"25.00%\" bgcolor=\"transparent\" align=\"center\"><a target=\"_blank\" style=\"-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:14px;text-decoration:none;display:block;color:#FFFFFF;\" href=\"http://portal.atgs.ru/dognet/\">Договор</a></td>
 <td style=\"Margin:0;padding-left:5px;padding-right:5px;padding-top:0px;padding-bottom:0px;border:0;border-left:1px solid #FFFFFF;\" id=\"esd-menu-id-3\" esdev-border-color=\"#ffffff\" width=\"25.00%\" bgcolor=\"transparent\" align=\"center\"><a target=\"_blank\" style=\"-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:14px;text-decoration:none;display:block;color:#FFFFFF;\" href=\"http://atgs-dinner.ru\">Еда</a></td> </tr> </table></td> </tr> </table></td> </tr> </table></td> </tr> <tr style=\"border-collapse:collapse;\"> <td align=\"left\" style=\"Margin:0;padding-bottom:15px;padding-top:20px;padding-left:20px;padding-right:20px;\"> <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;\"> <tr style=\"border-collapse:collapse;\">
 <td width=\"540\" valign=\"top\" align=\"center\" style=\"padding:0;Margin:0;\"> <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" role=\"presentation\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;\"> <tr style=\"border-collapse:collapse;\"> <td align=\"center\" style=\"padding:0;Margin:0;\"><p style=\"Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:11px;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:17px;color:#A9A9A9;\">Не используйте адрес отправителя этого письма для обратной связи.<br>Это письмо отправлено роботом.</p></td> </tr> <tr style=\"border-collapse:collapse;\"> <td align=\"center\" style=\"padding:0;Margin:0;padding-top:15px;\">
<p style=\"Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:11px;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:17px;color:#A9A9A9;\">2017 - 2020&nbsp;© Чугунов Ярослав</p></td> </tr> </table></td> </tr> </table></td> </tr> </table></td> </tr> </table></td> </tr> </table> </div> </body>
</html>
";
	// ----- ----- -----
	//
	//
	$message_body_bottom = "";
	# ----- ----- ----- ----- -----

	$FULL_MESSAGE = $message_header;
	$FULL_MESSAGE .= $message_body;
	$FULL_MESSAGE .= $message_body_bottom;

	# ----- ----- ----- ----- -----
	#
	# SERVER SETTINGS
	#
	#
	// Enable verbose debug output
	$mail3->SMTPDebug = SMTP::DEBUG_SERVER;
	// Disable verbose debug output
	$mail3->SMTPDebug = 0;
	// Send using SMTP
	$mail3->isSMTP();
	// Set the SMTP server to send through
	$mail3->Host = 'mail.atgs.ru';
	// Enable SMTP authentication
	$mail3->SMTPAuth = true;
	// SMTP connection will not close after each email sent, reduces SMTP overhead
	$mail3->SMTPKeepAlive = true;
	// SMTP username
	$mail3->Username = 'portal@atgs.ru';
	//   $mail3->Username = 'dinner@atgs.ru';
	// SMTP password
	$mail3->Password = 'iu3Li,quohch'; // portal@atgs.ru
	//   $mail3->Password = 'gai3ir+o4Ui4'; //dinner@atgs.ru
	// Enable TLS encryption, `PHPMailer::ENCRYPTION_SMTPS` also accepted
	$mail3->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
	// TCP port
	$mail3->Port = 587;
	#
	#
	# ----- ----- ----- ----- -----
	#
	#
	$mail3->setLanguage('ru', $_SERVER['DOCUMENT_ROOT'] . "/dognet/_assets/_PHPMailer/language/");
	$mail3->CharSet = "utf-8";
	#
	# From
	$from_name = "АТГС.Договор / Управление договорами";
	$from_email = "portal@atgs.ru";
	// 	$from_email = "dinner@atgs.ru";
	$from_name = "=?utf-8?B?" . base64_encode($from_name) . "?=";
	$mail3->setFrom($from_email, $from_name);
	# ----- ----- ----- ----- -----
	#
	# ПОЛУЧАТЕЛИ
	# $mail3->addReplyTo('email', 'name')
	# Email is an recipient address, Name is optional
	#
	# ----- ----- ----- ----- -----
	$email_to = $emailTo;
	# ----- ----- ----- ----- -----
	$mail3->addAddress($email_to);
	$mail3->addAddress('chugunov@atgs.ru');
	$mail3->addReplyTo('notreply@atgs.ru', 'Do not reply');
	# ----- ----- ----- ----- -----
	#
	// Content
	$mail3->isHTML(true);                                  // Set email format to HTML
	$mail3->Subject = $subject . " / " . $email_to;
	$mail3->Body    = $FULL_MESSAGE;
	$mail3->AltBody = 'Ваш почтовый клиент не принимает сообщений в формате HTML. Вариант рассылки в формате PLAIN TEXT будет реализован позже.';
	#
	# ::: Send the message, check for errors
	#
	# Открыли файл для записи данных в конец файла
	$filename = $_SERVER['DOCUMENT_ROOT'] . "/dognet/PHPMailer_errors.log";
	if (is_writable($filename)) {

		if (!$handle = fopen($filename, 'a')) {
			echo "<span style='color:red; text-align:center'><i>Не могу открыть лог-файл для записи отчета об отправке.</i></span>";
			exit;
		}

		if (!$mail3->send()) {
			$err = $mail3->ErrorInfo . PHP_EOL;
			$text = date('Y-m-d h:i:s') . " : ошибка рассылки на ( $email_to ) : " . $err;
			// Записываем $somecontent в наш открытый файл.
			if (fwrite($handle, $text) === FALSE) {
				echo "<span style='color:red; text-align:center'><i>Не могу произвести запись в лог файл.</i></span>";
				exit;
			}
			echo "<span style='color:red; text-align:center'><i>Ошибка при отправке сообщения : $err.</i></span>";
			fclose($handle);
		} else {
			$text = date('Y-m-d h:i:s') . " : сообщение на ( $email_to ) успешно отправлено" . PHP_EOL;
			// Записываем $somecontent в наш открытый файл.
			if (fwrite($handle, $text) === FALSE) {
				echo "<span style='color:red; text-align:center'><i>Не могу произвести запись в лог-файл.</i></span>";
				exit;
			}
			echo "<span style='color:green; text-align:center'><i>Сообщение успешно отправлено. Запись в лог-файл произведена.</i></span>";
			fclose($handle);
		}
	} else {
		echo "<span style='color:red; text-align:center'><i>Лог-файл недоступен для записи.</i></span>";
	}
	#
	# :::
	// Clear all addresses and attachments for next loop
	$mail3->ClearAddresses();
}
#
# :::
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
# Рассылка сообщений
#
function sendMessage_NewAvans() {
}
