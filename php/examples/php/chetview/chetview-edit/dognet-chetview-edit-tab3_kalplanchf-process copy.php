<?php
date_default_timezone_set('Europe/Moscow');

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

# Подключаем конфигурационный файл
// require($_SERVER['DOCUMENT_ROOT']."/config.inc.php");
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
# Подключаемся к базе
require_once($_SERVER['DOCUMENT_ROOT']."/_assets/drivers/db_connection.php");
require_once($_SERVER['DOCUMENT_ROOT']."/_assets/drivers/db_controller.php");
$db_handle = new DBController();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
# Подключаем общие функции безопасности
// require(dirname(__FILE__) . '/_assets/functions/funcSecure.inc.php');
require($_SERVER['DOCUMENT_ROOT']."/_assets/functions/funcSecure.inc.php");
# Подключаем собственные функции сервиса Почта
require($_SERVER['DOCUMENT_ROOT']."/dognet/_assets/functions/funcDognet.inc.php");
# Включаем режим сессии
session_start();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
$_UNIQUEID = $_SESSION['uniqueID'];
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
// 
// ВАЖНО!!!
// Определяем создан ли договор по шаблону с календарным планом (kodshab=1)
// или без плана (kodshab=2)
// Это определяет будет ли идти привязка в таблицах счетов, оплат и авансов привязка по
// коду этапа (kodkalplan) или по коду договора (koddoc) соответственно
// 
	$_QRY_KODSHAB = mysqlQuery("SELECT kodshab FROM dognet_docbase WHERE koddoc=".$_UNIQUEID);
	$_ROW_KODSHAB = mysqli_fetch_assoc($_QRY_KODSHAB);
	$_KODSHAB = $_ROW_KODSHAB['kodshab'];
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
# Функция формирования нового ID счета-фактуры (kodchfact) 
# для таблицы этапов 'dognet_kalplanchf'
# ----- ----- ----- 
function nextKodchfact() {
	$query = mysqlQuery("SELECT MAX(kodchfact) as lastKod FROM dognet_kalplanchf ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastKod = $row['lastKod'];
	$nextKod = $lastKod + rand(3, 33);
	return $nextKod;
}
#	ОПИСАНИЕ : Сумма всех авансов зачтенных в счет-фактуру $kodchfsubpodr 
#	
#
function SUMMA_AVANSCHF($kodchfact) { 
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
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
# ОПИСАНИЕ : Сумма всех оплат счета-фактуры $kodchfsubpodr 
#	
#
function SUMMA_OPLATCHF($kodchfact) { 
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
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
# Функция обновления полей основной таблицы (dognet_kalplanchf) 
# ----- ----- ----- 
function updateFields_kalplanchf( $db, $action, $id, $values, $__kodshab, $__uniqueID ) { 
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
# 
# ::: 
# ::: Если была нажата кнопка "НОВЫЙ СЧЕТ"
# ::: 
# 
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
	if ( $action == 'CRT' ) { 
#
#
	// Формируем новый идентификатор счета-фактуры (kodchfact) 
		$__nextKodchfact = nextKodchfact();
		$db->update( 'dognet_kalplanchf', array(
			'kodchfact'			=>	$__nextKodchfact 
		), array( 'id' => $id ));
#
#
	// Выбираем код редактируемого счета-фактуры (kodchfact) 
	// из таблицы счетов dognet_kalplanchf
		$_CHF_OPL_0 = 0;
		$_CHF_OPL_AVS_0 = 0;
		$_QRY_1 = $db->sql( "SELECT * FROM dognet_kalplanchf WHERE id=".$id )->fetchAll();
		if ( $_QRY_1 ) { 
			$__kodchfact = $_QRY_1[0]['kodchfact']; 
		// Запоминаем сумму счета для текущей записи
			$_CHF_0 = $_QRY_1[0]['chetfsumma']; 
		// Запоминаем сумму оплаты для текущего счета ($__kodchfact)
			$_QRY_CHF_OPL_0 = mysqlQuery( "SELECT SUM(summaopl) as sum1 FROM dognet_oplatachf WHERE kodchfact=".$__kodchfact );
			$_ROW_CHF_OPL_0 = mysqli_fetch_assoc($_QRY_CHF_OPL_0);
			$_CHF_OPL_0 = $_ROW_CHF_OPL_0['sum1']; 
		// Запоминаем сумму зачтенного аванса для текущего счета ($__kodchfact)
			$_QRY_CHF_OPL_AVS_0 = mysqlQuery( "SELECT SUM(summaoplav) as sum2 FROM dognet_chfavans WHERE kodchfact=".$__kodchfact );
			$_ROW_CHF_OPL_AVS_0 = mysqli_fetch_assoc($_QRY_CHF_OPL_AVS_0);
			$_CHF_OPL_AVS_0 = $_ROW_CHF_OPL_AVS_0['sum2']; 
		}
#
#
	// Выбираем сумму счета-фактуры
		$_QRY_2 = $db->sql( "SELECT chetfsumma FROM dognet_kalplanchf WHERE id=".$id )->fetchAll();
		if ( $_QRY_2 ) { $__summachfact = $_QRY_2[0]['chetfsumma']; }
#
#
	// Считаем задолженность по счету 
	// SUMMA_OPLATCHF - функция : сумма оплат по счету-фактуре
	// SUMMA_AVANSCHF - функция : сумма зачтенных авансов по счету-фактуре
		$_NEW_sumzadolchfact = $__summachfact - (SUMMA_OPLATCHF($__kodchfact) + SUMMA_AVANSCHF($__kodchfact));
#
#
	$db->insert( 'dognet_kalplanchf_zadol', array(
		'kodchfact' =>	$__nextKodchfact, 
		'kodkalplan' =>	$_QRY_1[0]['kodkalplan'], 
		'chetfsumma' =>	$_QRY_1[0]['chetfsumma'], 
		'chetfsumzadol' =>	$_NEW_sumzadolchfact 
	));
#
#
	// Выбираем код календарного плана (этапа) редактируемого счета-фактуры
		$query1 = mysqlQuery("SELECT kodkalplan FROM dognet_kalplanchf WHERE id=".$id);
		$row1 = mysqli_fetch_assoc($query1);
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
#
		// Если договор создан с календарным планом (kodshab=1)
		if ($__kodshab == 1) { 
		// Выбираем код этапа (kodkalplan) из таблицы календарных планов (этапов)
		// для выбранного выше договора ($_koddoc)
			$_QRY1 = mysqlQuery( "SELECT kodkalplan FROM dognet_dockalplan WHERE koddoc=".$__uniqueID );
			if ( $_QRY1 ) { 
			// Обнуляем счетчики
				$_CHF_SUM = 0;
				$_CHF_OPL_SUM = 0;
				$_CHF_AVS_SUM = 0;
				$_CHF_OPL_AVS_SUM = 0;
			// Запускаем цикл по всем кодам этапов
				while ($_ROW1 = mysqli_fetch_assoc($_QRY1)) {
				// Выбираем код счета-фактуры
					$_QRY = mysqlQuery( "SELECT kodchfact FROM dognet_kalplanchf WHERE kodkalplan=".$_ROW1['kodkalplan'] );
				// Обнуляем счетчики
					$__summachfact = 0;
					$__summaopl = 0;
					$__sumavans = 0;
					$__sumoplavans = 0;
				// Запускаем цикл по всем счетам-фактурам
					while( $_ROW = mysqli_fetch_assoc($_QRY) ) {
						$kod = $_ROW['kodchfact'];
					// Выбираем сумму счета-фактуры ($kod)
						$_QRY_1 = $db->sql( "SELECT SUM(chetfsumma) as chfsum FROM dognet_kalplanchf WHERE kodchfact=".$kod )->fetchAll();
						if ( $_QRY_1 ) { 
							$__summachfact = $_QRY_1[0]['chfsum']; 
						}
					// Сууммируем все оплаты по счету-фактуре ($kod)
						$_QRY_2 = $db->sql( "SELECT SUM(summaopl) as sumoplata FROM dognet_oplatachf WHERE kodchfact=".$kod )->fetchAll();
						if ( $_QRY_2 ) { 
							$__summaopl = $_QRY_2[0]['sumoplata']; 
						}
					// Суммируем все зачтенные авансы по счету-фактуре ($kod)
						$_QRY_3 = $db->sql( "SELECT SUM(summaoplav) as sumoplavans FROM dognet_chfavans WHERE kodchfact=".$kod )->fetchAll();
						if ( $_QRY_3 ) { 
							$__sumoplavans = $_QRY_3[0]['sumoplavans']; 
						}
					// Считаем текущую задолженность по счету-фактуре ($kod)
						$_NEW_sumzadolchfact = $__summachfact - ($__summaopl + $__sumoplavans);
					// Пишем в таблицу задолженностей счетов-фактур 
						$db->update( 'dognet_kalplanchf_zadol', array(
							'chetfsumzadol'		=>	$_NEW_sumzadolchfact 
						), array( 'kodchfact' => $kod ));
					// Суммируем общую задолженность по договору
						$_CHF_SUM += $__summachfact;
						$_CHF_OPL_SUM += $__summaopl;
						$_CHF_OPL_AVS_SUM += $__sumoplavans;
					}
				}
			// Суммируем все авансы по договору ($_koddoc)
				$_QRY_4 = $db->sql( "SELECT SUM(summaavans) as sumavans FROM dognet_docavans WHERE koddoc=".$__uniqueID )->fetchAll();
				if ( $_QRY_4 ) { 
					$__sumavans = $_QRY_4[0]['sumavans']; 
				}
				$_CHF_AVS_SUM = $__sumavans;
			// Пишем в основную таблицу договоров общую задолженность по счетам, оплатам и авансам
			// по договору ($_koddoc)
				$db->update( 'dognet_docbase', array(
				'summachf' => $_CHF_SUM+$_CHF_0,  
				'docoplata' => $_CHF_OPL_SUM+$_CHF_OPL_0,   
				'doczadol' =>	($_CHF_SUM+$_CHF_0) - ($_CHF_OPL_SUM+$_CHF_OPL_0),
				'docavans' => $_CHF_AVS_SUM, 
				'docnozak' => $_CHF_AVS_SUM-($_CHF_OPL_AVS_SUM+$_CHF_OPL_AVS_0) 
				), array( 'koddoc' => $__uniqueID ));
			}
		}
#
#
		// Если договор создан без календарного плана (kodshab=2)
		if ($__kodshab == 2) {
		// ВАЖНО!!
		// В случае договора без календарного плана в таблице этапов 
		// под кодом этапа (kodkalplan) хранится код самого договора (koddoc)
		// 
		// Выбираем код счета-фактуры
			$_QRY = mysqlQuery( "SELECT kodchfact FROM dognet_kalplanchf WHERE kodkalplan=".$__uniqueID );
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
			while( $_ROW = mysqli_fetch_assoc($_QRY) ) {
				$kod = $_ROW['kodchfact'];
		// Выбираем сумму счета-фактуры ($kod)
				$_QRY_1 = $db->sql( "SELECT chetfsumma FROM dognet_kalplanchf WHERE kodchfact=".$kod )->fetchAll();
				if ( $_QRY_1 ) { 
					$__summachfact = $_QRY_1[0]['chetfsumma']; 
				}
			// Сууммируем все оплаты по счету-фактуре ($kod)
				$_QRY_2 = $db->sql( "SELECT SUM(summaopl) as sumoplata FROM dognet_oplatachf WHERE kodchfact=".$kod )->fetchAll();
				if ( $_QRY_2 ) { 
					$__summaopl = $_QRY_2[0]['sumoplata']; 
				}
			// Суммируем все зачтенные авансы по счету-фактуре ($kod)
				$_QRY_3 = $db->sql( "SELECT SUM(summaoplav) as sumoplavans FROM dognet_chfavans WHERE kodchfact=".$kod )->fetchAll();
				if ( $_QRY_3 ) { 
					$__sumoplavans = $_QRY_3[0]['sumoplavans']; 
				}
			// Считаем текущую задолженность по счету-фактуре ($kod)
				$_NEW_sumzadolchfact = $__summachfact - ($__summaopl + $__sumoplavans);
			// Пишем в таблицу задолженностей счетов-фактур 
				$db->update( 'dognet_kalplanchf_zadol', array(
					'chetfsumzadol'		=>	$_NEW_sumzadolchfact 
				), array( 'kodchfact' => $kod ));
			// Суммируем общую задолженность по договору
				$_CHF_SUM += $__summachfact;
				$_CHF_OPL_SUM += $__summaopl;
				$_CHF_OPL_AVS_SUM += $__sumoplavans;
			}
		// Суммируем все авансы по договору ($_koddoc)
			$_QRY_4 = $db->sql( "SELECT SUM(summaavans) as sumavans FROM dognet_docavans WHERE koddoc=".$__uniqueID )->fetchAll();
			if ( $_QRY_4 ) { 
				$__sumavans = $_QRY_4[0]['sumavans']; 
			}
			$_CHF_AVS_SUM = $__sumavans;
		// Пишем в основную таблицу договоров общую задолженность по счетам, оплатам и авансам 
		// по договору ($_koddoc)
			$db->update( 'dognet_docbase', array(
				'summachf' => $_CHF_SUM+$_CHF_0,  
				'docoplata' => $_CHF_OPL_SUM+$_CHF_OPL_0,   
				'doczadol' =>	($_CHF_SUM+$_CHF_0) - ($_CHF_OPL_SUM+$_CHF_OPL_0),
				'docavans' => $_CHF_AVS_SUM, 
				'docnozak' => $_CHF_AVS_SUM-($_CHF_OPL_AVS_SUM+$_CHF_OPL_AVS_0) 
			), array( 'koddoc' => $__uniqueID ));
		}
	}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
# 
# ::: 
# ::: Если была нажата кнопка "ИЗМЕНИТЬ"
# ::: 
# 
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
	if ( $action == 'UPD' ) { 
#
#
		// Выбираем код редактируемого счета-фактуры (kodchfact) 
		// из таблицы счетов dognet_kalplanchf
			$_QRY_1 = $db->sql( "SELECT kodchfact FROM dognet_kalplanchf WHERE id=".$id )->fetchAll();
			if ( $_QRY_1 ) { $__kodchfact = $_QRY_1[0]['kodchfact']; }
#
#
		// Выбираем сумму счета-фактуры
			$_QRY_2 = $db->sql( "SELECT chetfsumma FROM dognet_kalplanchf WHERE id=".$id )->fetchAll();
			if ( $_QRY_2 ) { $__summachfact = $_QRY_2[0]['chetfsumma']; }
#
#
		// Считаем задолженность по счету 
		// SUMMA_OPLATCHF - функция : сумма оплат по счету-фактуре
		// SUMMA_AVANSCHF - функция : сумма зачтенных авансов по счету-фактуре
			$_NEW_sumzadolchfact = $__summachfact - (SUMMA_OPLATCHF($__kodchfact) + SUMMA_AVANSCHF($__kodchfact));
#
#
		// Пишем в таблицу dognet_kalplanchf_zadol задолженность по счету-фактуре
		$db->update( 'dognet_kalplanchf_zadol', array(
			'chetfsumma'		=>	$__summachfact, 
			'chetfsumzadol'		=>	$_NEW_sumzadolchfact 
		), array( 'kodchfact' => $__kodchfact ));
#
#
		// Выбираем код календарного плана (этапа) редактируемого счета-фактуры
		$query1 = mysqlQuery("SELECT kodkalplan FROM dognet_kalplanchf WHERE id=".$id);
		$row1 = mysqli_fetch_assoc($query1);
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
#
		// Если договор создан с календарным планом (kodshab=1)
		if ($__kodshab == 1) { 
		// Выбираем код договора из таблицы календарных планов (этапов)
			$query2 = mysqlQuery("SELECT koddoc FROM dognet_dockalplan WHERE kodkalplan=".$row1['kodkalplan']." ORDER BY kodkalplan LIMIT 1");
			$row2 = mysqli_fetch_assoc($query2);
		// Код договора
			$_koddoc = $row2['koddoc'];
		// Выбираем код этапа (kodkalplan) из таблицы календарных планов (этапов)
		// для выбранного выше договора ($_koddoc)
			$_QRY1 = mysqlQuery( "SELECT kodkalplan FROM dognet_dockalplan WHERE koddoc=".$_koddoc );
			if ( $_QRY1 ) { 
			// Обнуляем счетчики
				$_CHF_SUM = 0;
				$_CHF_OPL_SUM = 0;
				$_CHF_AVS_SUM = 0;
				$_CHF_OPL_AVS_SUM = 0;
			// Запускаем цикл по всем кодам этапов
				while ($_ROW1 = mysqli_fetch_assoc($_QRY1)) {
				// Выбираем код счета-фактуры
					$_QRY = mysqlQuery( "SELECT kodchfact FROM dognet_kalplanchf WHERE kodkalplan=".$_ROW1['kodkalplan'] );
				// Обнуляем счетчики
					$__summachfact = 0;
					$__summaopl = 0;
					$__sumavans = 0;
					$__sumoplavans = 0;
				// Запускаем цикл по всем счетам-фактурам
					while( $_ROW = mysqli_fetch_assoc($_QRY) ) {
						$kod = $_ROW['kodchfact'];
					// Выбираем сумму счета-фактуры ($kod)
						$_QRY_1 = $db->sql( "SELECT chetfsumma FROM dognet_kalplanchf WHERE kodchfact=".$kod )->fetchAll();
						if ( $_QRY_1 ) { 
							$__summachfact = $_QRY_1[0]['chetfsumma']; 
						}
					// Сууммируем все оплаты по счету-фактуре ($kod)
						$_QRY_2 = $db->sql( "SELECT SUM(summaopl) as sumoplata FROM dognet_oplatachf WHERE kodchfact=".$kod )->fetchAll();
						if ( $_QRY_2 ) { 
							$__summaopl = $_QRY_2[0]['sumoplata']; 
						}
					// Суммируем все зачтенные авансы по счету-фактуре ($kod)
						$_QRY_3 = $db->sql( "SELECT SUM(summaoplav) as sumoplavans FROM dognet_chfavans WHERE kodchfact=".$kod )->fetchAll();
						if ( $_QRY_3 ) { 
							$__sumoplavans = $_QRY_3[0]['sumoplavans']; 
						}
					// Суммируем все авансы по договору ($_koddoc)
						$_QRY_4 = $db->sql( "SELECT SUM(summaavans) as sumavans FROM dognet_docavans WHERE koddoc=".$_koddoc )->fetchAll();
						if ( $_QRY_4 ) { 
							$__sumavans = $_QRY_4[0]['sumavans']; 
						}
					// Считаем текущую задолженность по счету-фактуре ($kod)
						$_NEW_sumzadolchfact = $__summachfact - ($__summaopl + $__sumoplavans);
					// Пишем в таблицу задолженностей счетов-фактур 
						$db->update( 'dognet_kalplanchf_zadol', array(
							'chetfsumzadol'		=>	$_NEW_sumzadolchfact 
						), array( 'kodchfact' => $kod ));
					// Суммируем общую задолженность по договору
						$_CHF_SUM += $__summachfact;
						$_CHF_OPL_SUM += $__summaopl;
						$_CHF_AVS_SUM += $__sumavans;
						$_CHF_OPL_AVS_SUM += $__sumoplavans;
					}
				}
				// Пишем в основную таблицу договоров общую задолженность по счетам, оплатам и авансам
				// по договору ($_koddoc)
				$db->update( 'dognet_docbase', array(
					'summachf' => $_CHF_SUM,  
					'docoplata' => $_CHF_OPL_SUM,   
					'doczadol' =>	$_CHF_SUM -  $_CHF_OPL_SUM,
					'docavans' => $_CHF_AVS_SUM, 
					'docnozak' => $_CHF_AVS_SUM-$_CHF_OPL_AVS_SUM 
				), array( 'koddoc' => $_koddoc ));
			}
		}
#
#
		// Если договор создан без календарного плана (kodshab=2)
		if ($__kodshab == 2) {
		// ВАЖНО!!
		// В случае договора без календарного плана в таблице этапов 
		// под кодом этапа (kodkalplan) хранится код самого договора (koddoc)
		// 
		// Выбираем код договора (kodkalplan) из таблицы календарных планов (этапов)
		// для текущего договора ($__uniqueID) 
			$query2 = mysqlQuery("SELECT kodkalplan FROM dognet_kalplanchf WHERE kodkalplan=".$__uniqueID." ORDER BY kodkalplan LIMIT 1");
			$row2 = mysqli_fetch_assoc($query2);
		// Код договора
			$_koddoc = $row2['kodkalplan'];
		// Выбираем код счета-фактуры
			$_QRY = mysqlQuery( "SELECT kodchfact FROM dognet_kalplanchf WHERE kodkalplan=".$_koddoc );
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
			while( $_ROW = mysqli_fetch_assoc($_QRY) ) {
				$kod = $_ROW['kodchfact'];
		// Выбираем сумму счета-фактуры ($kod)
				$_QRY_1 = $db->sql( "SELECT chetfsumma FROM dognet_kalplanchf WHERE kodchfact=".$kod )->fetchAll();
				if ( $_QRY_1 ) { 
					$__summachfact = $_QRY_1[0]['chetfsumma']; 
				}
			// Сууммируем все оплаты по счету-фактуре ($kod)
				$_QRY_2 = $db->sql( "SELECT SUM(summaopl) as sumoplata FROM dognet_oplatachf WHERE kodchfact=".$kod )->fetchAll();
				if ( $_QRY_2 ) { 
					$__summaopl = $_QRY_2[0]['sumoplata']; 
				}
			// Суммируем все зачтенные авансы по счету-фактуре ($kod)
				$_QRY_3 = $db->sql( "SELECT SUM(summaoplav) as sumoplavans FROM dognet_chfavans WHERE kodchfact=".$kod )->fetchAll();
				if ( $_QRY_3 ) { 
					$__sumoplavans = $_QRY_3[0]['sumoplavans']; 
				}
			// Суммируем все авансы по договору ($_koddoc)
				$_QRY_4 = $db->sql( "SELECT SUM(summaavans) as sumavans FROM dognet_docavans WHERE koddoc=".$_koddoc )->fetchAll();
				if ( $_QRY_4 ) { 
					$__sumavans = $_QRY_4[0]['sumavans']; 
				}
			// Считаем текущую задолженность по счету-фактуре ($kod)
				$_NEW_sumzadolchfact = $__summachfact - ($__summaopl + $__sumoplavans);
			// Пишем в таблицу задолженностей счетов-фактур 
				$db->update( 'dognet_kalplanchf_zadol', array(
					'chetfsumzadol'		=>	$_NEW_sumzadolchfact 
				), array( 'kodchfact' => $kod ));
			// Суммируем общую задолженность по договору
				$_CHF_SUM += $__summachfact;
				$_CHF_OPL_SUM += $__summaopl;
				$_CHF_AVS_SUM += $__sumavans;
				$_CHF_OPL_AVS_SUM += $__sumoplavans;
			}
		// Пишем в основную таблицу договоров общую задолженность по счетам, оплатам и авансам 
		// по договору ($_koddoc)
			$db->update( 'dognet_docbase', array(
				'summachf' => $_CHF_SUM,  
				'docoplata' => $_CHF_OPL_SUM,   
				'doczadol' =>	$_CHF_SUM -  $_CHF_OPL_SUM,
				'docavans' => $_CHF_AVS_SUM, 
				'docnozak' => $_CHF_AVS_SUM-$_CHF_OPL_AVS_SUM 
			), array( 'koddoc' => $_koddoc ));
		}
	}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
# 
# ::: 
# ::: Если была нажата кнопка "УДАЛИТЬ"
# ::: 
# 
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
	if ( $action == 'DEL' ) { 
#
#
		// Выбираем код редактируемого счета-фактуры (kodchfact) 
		// из таблицы счетов dognet_kalplanchf
			$_QRY_1 = $db->sql( "SELECT kodchfact FROM dognet_kalplanchf WHERE id=".$id )->fetchAll();
			if ( $_QRY_1 ) { 
				$__kodchfact = $_QRY_1[0]['kodchfact']; 
				$_QRY_DEL1 = $db->sql( "DELETE FROM dognet_kalplanchf_zadol WHERE kodchfact=".$__kodchfact );
				$_QRY_DEL2 = $db->sql( "DELETE FROM dognet_oplatachf WHERE kodchfact=".$__kodchfact );
				$_QRY_DEL3 = $db->sql( "DELETE FROM dognet_chfavans WHERE kodchfact=".$__kodchfact );
			}
#
#
		// Выбираем код календарного плана (этапа) редактируемого счета-фактуры
		$query1 = mysqlQuery("SELECT kodkalplan FROM dognet_kalplanchf WHERE id=".$id);
		$row1 = mysqli_fetch_assoc($query1);
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
#
		// Если договор создан с календарным планом (kodshab=1)
		if ($__kodshab == 1) { 
		// Выбираем код договора из таблицы календарных планов (этапов)
			$query2 = mysqlQuery("SELECT koddoc FROM dognet_dockalplan WHERE kodkalplan=".$row1['kodkalplan']." ORDER BY kodkalplan LIMIT 1");
			$row2 = mysqli_fetch_assoc($query2);
		// Код договора
			$_koddoc = $row2['koddoc'];
		// Выбираем код этапа (kodkalplan) из таблицы календарных планов (этапов)
		// для выбранного выше договора ($_koddoc)
			$_QRY1 = mysqlQuery( "SELECT kodkalplan FROM dognet_dockalplan WHERE koddoc=".$_koddoc );
			if ( $_QRY1 ) { 
			// Обнуляем счетчики
				$_CHF_SUM = 0;
				$_CHF_OPL_SUM = 0;
				$_CHF_AVS_SUM = 0;
				$_CHF_OPL_AVS_SUM = 0;
			// Запускаем цикл по всем кодам этапов
				while ($_ROW1 = mysqli_fetch_assoc($_QRY1)) {
				// Выбираем код счета-фактуры
					$_QRY = mysqlQuery( "SELECT kodchfact FROM dognet_kalplanchf WHERE kodkalplan=".$_ROW1['kodkalplan']." AND kodchfact<>".$__kodchfact );
				// Обнуляем счетчики
					$__summachfact = 0;
					$__summaopl = 0;
					$__sumavans = 0;
					$__sumoplavans = 0;
				// Запускаем цикл по всем счетам-фактурам
					while( $_ROW = mysqli_fetch_assoc($_QRY) ) {
						$kod = $_ROW['kodchfact'];
					// Выбираем сумму счета-фактуры ($kod)
						$_QRY_1 = $db->sql( "SELECT chetfsumma FROM dognet_kalplanchf WHERE kodchfact=".$kod." AND kodchfact<>".$__kodchfact )->fetchAll();
						if ( $_QRY_1 ) { 
							$__summachfact = $_QRY_1[0]['chetfsumma']; 
						}
					// Сууммируем все оплаты по счету-фактуре ($kod)
						$_QRY_2 = $db->sql( "SELECT SUM(summaopl) as sumoplata FROM dognet_oplatachf WHERE kodchfact=".$kod." AND kodchfact<>".$__kodchfact )->fetchAll();
						if ( $_QRY_2 ) { 
							$__summaopl = $_QRY_2[0]['sumoplata']; 
						}
					// Суммируем все зачтенные авансы по счету-фактуре ($kod)
						$_QRY_3 = $db->sql( "SELECT SUM(summaoplav) as sumoplavans FROM dognet_chfavans WHERE kodchfact=".$kod." AND kodchfact<>".$__kodchfact )->fetchAll();
						if ( $_QRY_3 ) { 
							$__sumoplavans = $_QRY_3[0]['sumoplavans']; 
						}
					// Суммируем все авансы по договору ($_koddoc)
						$_QRY_4 = $db->sql( "SELECT SUM(summaavans) as sumavans FROM dognet_docavans WHERE koddoc=".$_koddoc )->fetchAll();
						if ( $_QRY_4 ) { 
							$__sumavans = $_QRY_4[0]['sumavans']; 
						}
					// Считаем текущую задолженность по счету-фактуре ($kod)
						$_NEW_sumzadolchfact = $__summachfact - ($__summaopl + $__sumoplavans);
					// Пишем в таблицу задолженностей счетов-фактур 
						$db->update( 'dognet_kalplanchf_zadol', array(
							'chetfsumzadol'		=>	$_NEW_sumzadolchfact 
						), array( 'kodchfact' => $kod ));
					// Суммируем общую задолженность по договору
						$_CHF_SUM += $__summachfact;
						$_CHF_OPL_SUM += $__summaopl;
						$_CHF_AVS_SUM += $__sumavans;
						$_CHF_OPL_AVS_SUM += $__sumoplavans;
					}
				}
				// Пишем в основную таблицу договоров общую задолженность по счетам, оплатам и авансам
				// по договору ($_koddoc)
				$db->update( 'dognet_docbase', array(
					'summachf' => $_CHF_SUM,  
					'docoplata' => $_CHF_OPL_SUM,   
					'doczadol' =>	$_CHF_SUM -  $_CHF_OPL_SUM,
					'docavans' => $_CHF_AVS_SUM, 
					'docnozak' => $_CHF_AVS_SUM-$_CHF_OPL_AVS_SUM 
				), array( 'koddoc' => $_koddoc ));
			}
		}
#
#
		// Если договор создан без календарного плана (kodshab=2)
		if ($__kodshab == 2) {
		// ВАЖНО!!
		// В случае договора без календарного плана в таблице этапов 
		// под кодом этапа (kodkalplan) хранится код самого договора (koddoc)
		// 
		// Выбираем код договора (kodkalplan) из таблицы календарных планов (этапов)
		// для текущего договора ($__uniqueID) 
			$query2 = mysqlQuery("SELECT kodkalplan FROM dognet_kalplanchf WHERE kodkalplan=".$__uniqueID." ORDER BY kodkalplan LIMIT 1");
			$row2 = mysqli_fetch_assoc($query2);
		// Код договора
			$_koddoc = $row2['kodkalplan'];
		// Выбираем код счета-фактуры
			$_QRY = mysqlQuery( "SELECT kodchfact FROM dognet_kalplanchf WHERE kodkalplan=".$_koddoc." AND kodchfact<>".$__kodchfact );
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
			while( $_ROW = mysqli_fetch_assoc($_QRY) ) {
				$kod = $_ROW['kodchfact'];
		// Выбираем сумму счета-фактуры ($kod)
				$_QRY_1 = $db->sql( "SELECT chetfsumma FROM dognet_kalplanchf WHERE kodchfact=".$kod." AND kodchfact<>".$__kodchfact )->fetchAll();
				if ( $_QRY_1 ) { 
					$__summachfact = $_QRY_1[0]['chetfsumma']; 
				}
			// Сууммируем все оплаты по счету-фактуре ($kod)
				$_QRY_2 = $db->sql( "SELECT SUM(summaopl) as sumoplata FROM dognet_oplatachf WHERE kodchfact=".$kod." AND kodchfact<>".$__kodchfact )->fetchAll();
				if ( $_QRY_2 ) { 
					$__summaopl = $_QRY_2[0]['sumoplata']; 
				}
			// Суммируем все зачтенные авансы по счету-фактуре ($kod)
				$_QRY_3 = $db->sql( "SELECT SUM(summaoplav) as sumoplavans FROM dognet_chfavans WHERE kodchfact=".$kod." AND kodchfact<>".$__kodchfact )->fetchAll();
				if ( $_QRY_3 ) { 
					$__sumoplavans = $_QRY_3[0]['sumoplavans']; 
				}
			// Суммируем все авансы по договору ($_koddoc)
				$_QRY_4 = $db->sql( "SELECT SUM(summaavans) as sumavans FROM dognet_docavans WHERE koddoc=".$_koddoc )->fetchAll();
				if ( $_QRY_4 ) { 
					$__sumavans = $_QRY_4[0]['sumavans']; 
				}
			// Считаем текущую задолженность по счету-фактуре ($kod)
				$_NEW_sumzadolchfact = $__summachfact - ($__summaopl + $__sumoplavans);
			// Пишем в таблицу задолженностей счетов-фактур 
				$db->update( 'dognet_kalplanchf_zadol', array(
					'chetfsumzadol'		=>	$_NEW_sumzadolchfact 
				), array( 'kodchfact' => $kod ));
			// Суммируем общую задолженность по договору
				$_CHF_SUM += $__summachfact;
				$_CHF_OPL_SUM += $__summaopl;
				$_CHF_AVS_SUM += $__sumavans;
				$_CHF_OPL_AVS_SUM += $__sumoplavans;
			}
		// Пишем в основную таблицу договоров общую задолженность по счетам, оплатам и авансам 
		// по договору ($_koddoc)
			$db->update( 'dognet_docbase', array(
				'summachf' => $_CHF_SUM,  
				'docoplata' => $_CHF_OPL_SUM,   
				'doczadol' =>	$_CHF_SUM -  $_CHF_OPL_SUM,
				'docavans' => $_CHF_AVS_SUM, 
				'docnozak' => $_CHF_AVS_SUM-$_CHF_OPL_AVS_SUM 
			), array( 'koddoc' => $_koddoc ));
		}
	}
}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
# 
// Вытаскиваем идентификатор календарного плана 
	$query1 = mysqlQuery("SELECT koddened FROM dognet_docbase WHERE koddoc=".$_UNIQUEID);
	$row1 = mysqli_fetch_assoc($query1);
	$__koddened = $row1['koddened'];
	$query2 = mysqlQuery("SELECT html_code FROM dognet_spdened WHERE koddened=".$__koddened);
	$row2 = mysqli_fetch_assoc($query2);
	$__dened = $row2['html_code'];
#
# Example PHP implementation used for the index.html example
#
// DataTables PHP library
require( $_SERVER['DOCUMENT_ROOT']."/dognet/_assets/_datatables-php-api-editor/DataTables.php" );
// Alias Editor classes so they are easy to use
use
	DataTables\Editor,
	DataTables\Editor\Field,
	DataTables\Editor\Format,
	DataTables\Editor\Mjoin,
	DataTables\Editor\Options,
	DataTables\Editor\Upload,
	DataTables\Editor\Validate,
	DataTables\Editor\ValidateOptions;
// 	
// 	
	if ($_KODSHAB == 1) {
// 	
// 	
// Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'dognet_kalplanchf' )
  ->fields(
      Field::inst( 'dognet_kalplanchf.kodchfact' ), 
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
      Field::inst( 'dognet_kalplanchf.kodkalplan' ) 
				->options( Options::inst()
					->table( 'dognet_dockalplan' )
					->value( 'kodkalplan' )
					->label( array('kodkalplan', 'numberstage') )
					->render( function ( $row ) {
						return "Этап ".$row['numberstage'];
						})
					->where(function ($q) use ($_UNIQUEID)  { 
						$q->where('koddoc', $_UNIQUEID, '=');
						})
				) 
				->validator( Validate::notEmpty( ValidateOptions::inst()
					->message( 'Объект обязателен' )	
			) ),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
      Field::inst( 'dognet_kalplanchf.chetfnumber' ), 
      Field::inst( 'dognet_kalplanchf.chetfdate' ) 
      	->set( Field::SET_EDIT )
          ->validator( Validate::dateFormat(
              'd.m.Y',
              ValidateOptions::inst()
                  ->allowEmpty( false ) ) )
          ->getFormatter( Format::datetime(
              'Y-m-d',
              'd.m.Y'
          ) )
          ->setFormatter( Format::datetime(
              'd.m.Y',
              'Y-m-d'
			) ),
      Field::inst( 'dognet_kalplanchf.chetfsumma' ), 
      Field::inst( 'dognet_kalplanchf.comment' ), 
      Field::inst( 'dognet_kalplanchf_zadol.chetfsumzadol' ), 
      Field::inst( 'dognet_dockalplan.koddoc' ), 
      Field::inst( 'dognet_dockalplan.kodkalplan' ), 
      Field::inst( 'dognet_dockalplan.nameshotstage' ), 
      Field::inst( 'dognet_dockalplan.numberstage' ), 
      Field::inst( 'dognet_dockalplan.summastage' ), 
      Field::inst( 'dognet_dockalplan.srokstage' ), 
      Field::inst( 'dognet_dockalplan.dateplan' ),  
      Field::inst( 'dognet_docbase.koddened' ), 
      Field::inst( 'dognet_docbase.kodshab' ), 
      Field::inst( 'dognet_docbase.docnumber' ), 
      Field::inst( 'dognet_spdened.koddened' ), 
      Field::inst( 'dognet_spdened.html_code' ), 
      Field::inst( 'dognet_spdened.short_code' ) 
  )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
	->on( 'preGet', function ( $editor, $id ) use ($_UNIQUEID) {
		$editor->where( function ( $q ) use ($_UNIQUEID) {
			$q->where( 'dognet_kalplanchf.koddel', '99', '!=');
		} );
	} )
//
	->on( 'postCreate', function ( $editor, $id, $values, $row ) use ($_KODSHAB, $_UNIQUEID) {
		updateFields_kalplanchf( $editor->db(), 'CRT', $id, $values, $_KODSHAB, $_UNIQUEID );
	} )
	->on( 'postEdit', function ( $editor, $id, $values, $row ) use ($_KODSHAB, $_UNIQUEID) {
		updateFields_kalplanchf( $editor->db(), 'UPD', $id, $values, $_KODSHAB, $_UNIQUEID );
	} )
	->on( 'preRemove', function ( $editor, $id, $values ) use ($_KODSHAB, $_UNIQUEID) {
		updateFields_kalplanchf( $editor->db(), 'DEL', $id, $values, $_KODSHAB, $_UNIQUEID );
	} )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
	->leftJoin( 'dognet_kalplanchf_zadol', 'dognet_kalplanchf_zadol.kodchfact', '=', 'dognet_kalplanchf.kodchfact' )
	->leftJoin( 'dognet_dockalplan', 'dognet_dockalplan.kodkalplan', '=', 'dognet_kalplanchf.kodkalplan' )
	->leftJoin( 'dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_dockalplan.koddoc' )
	->leftJoin( 'dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened' )
	->join(
    Mjoin::inst( 'dognet_oplatachf' )
      ->link( 'dognet_oplatachf.kodchfact', 'dognet_kalplanchf.kodchfact' )
      ->field(
        Field::inst( 'kodchfact' )
    )
  )
  ->where( 'dognet_dockalplan.koddoc', $_UNIQUEID)
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
  ->process( $_POST )
  ->json();
// 	
// 	
}
// 	
// 	
	elseif ($_KODSHAB == "2") {
// 	
// 	
// Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'dognet_kalplanchf' )
  ->fields(
      Field::inst( 'dognet_kalplanchf.kodchfact' ), 
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
      Field::inst( 'dognet_kalplanchf.kodkalplan' ) 
				->options( Options::inst()
					->table( 'dognet_docbase' )
					->value( 'koddoc' )
					->label( array('koddoc') )
					->render( function ( $row ) {
						return "Без календарного плана";
						})
					->where(function ($q) use ($_UNIQUEID)  { 
						$q->where('koddoc', $_UNIQUEID, '=');
						})
				) 
				->validator( Validate::notEmpty( ValidateOptions::inst()
					->message( 'Объект обязателен' )	
			) ),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
      Field::inst( 'dognet_kalplanchf.chetfnumber' ), 
      Field::inst( 'dognet_kalplanchf.chetfdate' ) 
      	->set( Field::SET_EDIT )
          ->validator( Validate::dateFormat(
              'd.m.Y',
              ValidateOptions::inst()
                  ->allowEmpty( false ) ) )
          ->getFormatter( Format::datetime(
              'Y-m-d',
              'd.m.Y'
          ) )
          ->setFormatter( Format::datetime(
              'd.m.Y',
              'Y-m-d'
			) ),
      Field::inst( 'dognet_kalplanchf.chetfsumma' ), 
      Field::inst( 'dognet_kalplanchf.comment' ), 
      Field::inst( 'dognet_kalplanchf_zadol.chetfsumzadol' ), 
      Field::inst( 'dognet_docbase.koddened' ), 
      Field::inst( 'dognet_docbase.kodshab' ), 
      Field::inst( 'dognet_docbase.docnumber' ), 
      Field::inst( 'dognet_spdened.koddened' ), 
      Field::inst( 'dognet_spdened.html_code' ), 
      Field::inst( 'dognet_spdened.short_code' ) 
  )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
	->on( 'preGet', function ( $editor, $id ) use ($_UNIQUEID) {
		$editor->where( function ( $q ) use ($_UNIQUEID) {
			$q->where( 'dognet_kalplanchf.koddel', '99', '!=');
		} );
	} )
//
	->on( 'postCreate', function ( $editor, $id, $values, $row ) use ($_KODSHAB, $_UNIQUEID) {
		updateFields_kalplanchf( $editor->db(), 'CRT', $id, $values, $_KODSHAB, $_UNIQUEID );
	} )
	->on( 'postEdit', function ( $editor, $id, $values, $row ) use ($_KODSHAB, $_UNIQUEID) {
		updateFields_kalplanchf( $editor->db(), 'UPD', $id, $values, $_KODSHAB, $_UNIQUEID );
	} )
	->on( 'preRemove', function ( $editor, $id, $values ) use ($_KODSHAB, $_UNIQUEID) {
		updateFields_kalplanchf( $editor->db(), 'DEL', $id, $values, $_KODSHAB, $_UNIQUEID );
	} )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
	->leftJoin( 'dognet_kalplanchf_zadol', 'dognet_kalplanchf_zadol.kodchfact', '=', 'dognet_kalplanchf.kodchfact' )
	->leftJoin( 'dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_kalplanchf.kodkalplan' )
	->leftJoin( 'dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened' )
	->join(
    Mjoin::inst( 'dognet_oplatachf' )
      ->link( 'dognet_oplatachf.kodchfact', 'dognet_kalplanchf.kodchfact' )
      ->field(
        Field::inst( 'kodchfact' )
    )
  )
  ->where( 'dognet_kalplanchf.kodkalplan', $_UNIQUEID)
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
  ->process( $_POST )
  ->json();
// 	
// 	
}
// 	
// 	

?>