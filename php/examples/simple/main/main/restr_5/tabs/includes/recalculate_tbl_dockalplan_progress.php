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
# Подключаем общие функции безопасности
// require(dirname(__FILE__) . '/_assets/functions/funcSecure.inc.php');
require($_SERVER['DOCUMENT_ROOT']."/_assets/functions/funcSecure.inc.php");
# Подключаем собственные функции сервиса
require($_SERVER['DOCUMENT_ROOT']."/dognet/_assets/functions/funcDognet.inc.php");
# Включаем режим сессии

/*
				$_QRY1 = mysqlQuery( "SELECT kodkalplan FROM dognet_kalplanchf" );
				while ($_ROW1 = mysqli_fetch_assoc($_QRY1)) {
					$_QRY = mysqlQuery( "SELECT SUM(chetfsumma) as sum1 FROM dognet_kalplanchf WHERE kodkalplan = ".$_ROW1['kodkalplan'] );
					$_ROW = mysqli_fetch_assoc($_QRY);
					$_QRY_UPD = mysqlQuery( "UPDATE dognet_dockalplan_progress SET sumchfstage = ".$_ROW['sum1']." WHERE kodkalplan = ".$_ROW1['kodkalplan'] );
				}

				$_QRY2 = mysqlQuery( "SELECT koddoc FROM dognet_docavans" );
				while ($_ROW2 = mysqli_fetch_assoc($_QRY2)) {
					$_QRY = mysqlQuery( "SELECT SUM(summaavans) as sum1 FROM dognet_docavans WHERE koddoc = ".$_ROW2['koddoc'] );
					$_ROW = mysqli_fetch_assoc($_QRY);
					$_QRY_UPD = mysqlQuery( "UPDATE dognet_dockalplan_progress SET sumavstage = ".$_ROW['sum1']." WHERE kodkalplan = ".$_ROW2['koddoc'] );
				}
*/

/*
				$_QRY3 = mysqlQuery( "SELECT kodkalplan FROM dognet_dockalplan WHERE koddel<>'99'" );
				while ($_ROW3 = mysqli_fetch_assoc($_QRY3)) {
					$_QRY_CHF = mysqlQuery( "SELECT kodchfact FROM dognet_kalplanchf WHERE kodkalplan = ".$_ROW3['kodkalplan'] );
					$_SUMOPLCHF = 0.0;
					while ($_ROW_CHF = mysqli_fetch_assoc($_QRY_CHF)) {
						$_QRY = mysqlQuery( "SELECT SUM(summaopl) as sum1 FROM dognet_oplatachf WHERE kodchfact = ".$_ROW_CHF['kodchfact'] );
						$_ROW = mysqli_fetch_assoc($_QRY);
						$_SUMOPLCHF += $_ROW['sum1'];
					}
					$_QRY_UPD = mysqlQuery( "UPDATE dognet_dockalplan_progress SET sumoplchfstage = ".$_SUMOPLCHF." WHERE kodkalplan = ".$_ROW3['kodkalplan'] );
				}
*/

/*
				$_QRY4 = mysqlQuery( "SELECT kodkalplan FROM dognet_dockalplan WHERE koddel<>'99'" );
				while ($_ROW4 = mysqli_fetch_assoc($_QRY4)) {
					$_QRY_CHF = mysqlQuery( "SELECT kodchfact FROM dognet_kalplanchf WHERE kodkalplan = ".$_ROW4['kodkalplan'] );
					$_SUMOPLAVCHF = 0.0;
					while ($_ROW_CHF = mysqli_fetch_assoc($_QRY_CHF)) {
						$_QRY = mysqlQuery( "SELECT SUM(summaoplav) as sum1 FROM dognet_chfavans WHERE kodchfact = ".$_ROW_CHF['kodchfact'] );
						$_ROW = mysqli_fetch_assoc($_QRY);
						$_SUMOPLAVCHF += $_ROW['sum1'];
					}
					$_QRY_UPD = mysqlQuery( "UPDATE dognet_dockalplan_progress SET sumoplavstage = ".$_SUMOPLAVCHF." WHERE kodkalplan = ".$_ROW4['kodkalplan'] );
				}
*/

/*
				$_QRY4 = mysqlQuery( "SELECT summastage, kodkalplan FROM dognet_dockalplan WHERE koddel<>'99'" );
				while ($_ROW4 = mysqli_fetch_assoc($_QRY4)) {
					$_QRY_SUMS = mysqlQuery( "SELECT sumchfstage, sumavstage, sumoplchfstage, sumoplavstage FROM dognet_dockalplan_progress WHERE kodkalplan = ".$_ROW4['kodkalplan'] );
					$_ZADOLSUM_STAGE = $_QRY4[0]['summastage']-$_QRY_SUMS[0]['sumchfstage'];
					$_ZADOLSUM_CHF = $_QRY_SUMS[0]['sumchfstage']-($_QRY_SUMS[0]['sumoplchfstage']+$_QRY_SUMS[0]['sumoplavstage']);
					$_ZADOLSUM_AV = $_QRY_SUMS[0]['sumavstage']-$_QRY_SUMS[0]['sumoplavstage'];

					$_QRY_UPD = mysqlQuery( "UPDATE dognet_dockalplan_progress SET zadolsum_stage = ".$_ZADOLSUM_STAGE.", zadolsum_chf = ".$_ZADOLSUM_CHF.", zadolsum_av = ".$_ZADOLSUM_AV." WHERE kodkalplan = ".$_ROW4['kodkalplan'] );
				}
*/

?>