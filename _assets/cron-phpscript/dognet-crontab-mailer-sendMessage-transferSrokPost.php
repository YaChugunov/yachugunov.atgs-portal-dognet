<?php
#
$_IS_CRONTAB		= TRUE;
$_IS_MAILING_ENBL	= TRUE;
#
$path_parts = pathinfo($_SERVER['SCRIPT_FILENAME']); // определяем директорию скрипта
chdir($path_parts['dirname']); // задаем директорию выполнение скрипта
#
date_default_timezone_set('Europe/Moscow');
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Подключаем конфигурационный файл
require_once("/var/www/html/atgs-portal.local/www/config.inc.php");
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
require_once("/var/www/html/atgs-portal.local/www/dognet/config.dognet.inc.php");
#
# Подключаемся к базе
require_once("/var/www/html/atgs-portal.local/www/dognet/_assets/dbconn/db_connection.php");
require_once("/var/www/html/atgs-portal.local/www/dognet/_assets/dbconn/db_controller.php");
$db_handle = new DBController();
#
# Подключаем общие функции безопасности
require("/var/www/html/atgs-portal.local/www/dognet/_assets/functions/func.secure.inc.php");
# Подключаем собственные функции сервиса Почта
require("/var/www/html/atgs-portal.local/www/dognet/_assets/functions/func.dognet.inc.php");
# Подключаем библиотеки для формирования обращения к контрагенту в дательном падеже
require("/var/www/html/atgs-portal.local/www/dognet/_assets/cron-phpscript/addons/_NCL/NCLNameCaseRu.php");
require("/var/www/html/atgs-portal.local/www/dognet/_assets/cron-phpscript/addons/_Morpher/morpher-ws3-php-client-1.0.0/vendor/autoload.php");
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
/** 
 * !!! Отправка письма о переносе срока по договору поставки
 * 
 * ? > Рассылка тестового сообщения на email разработчика
 * ? > Last edition 21.11.2023
 */
#
# Import PHPMailer classes into the global namespace
# These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use Morpher\Ws3Client\Morpher;
use Morpher\Ws3Client\Russian\Flags;
use Morpher\Ws3Client\Russian\DeclensionResult;
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
$datetimenow = date("Y-m-d H:i:s");
$datenow = date("Y-m-d");
$datetime1 = date("Y-m-d H:i:s", strtotime('-6 month', strtotime($datetimenow)));
$datetime0 = date("Y-m-d H:i:s", strtotime(strtotime($datetimenow)));
$datetimeDL2 = date("Y-m-d 00:00:00", strtotime('+7 day', strtotime($datetimenow)));
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# Instantiation and passing `true` enables exceptions
$mailer = new PHPMailer;
$message_header = "";
$message_addresser = "";
$message_body = "";
$message_footer = "";
/**
 * Рассматриваем договора только следующих типов: 
 * !- поставка (245287841608965)
 * !- поставка+работа (245287841599652)
 * и в статусе:
 * !- текущий (245381842747296)
 */

$_SQLReq_Docs = "
SELECT 
koddoc as koddoc, 
kodkalplan as kodkalplan, 
summastage as summastage, 
srokstage_date as srokstage_date, 
'1' as kodshab, 
NULL as docnumber, 
NULL as koddened, 
NULL as kodzakaz, 
NULL as docnamefullm 
FROM dognet_dockalplan_progress WHERE srokstage_date != '0000-00-00' AND srokstage_date != 'NULL' AND srokstage_date != '' AND zadolsum_stage > 0 AND koddoc IN (SELECT koddoc FROM dognet_docbase WHERE (kodstatus='245381842747296' OR kodstatus='245597345680479' OR kodstatus='245267756667430' OR kodstatus='245381842145343') AND (kodtip='245287841608965' OR kodtip='245287841599652') AND koddel<>'99') 

UNION 
SELECT 
koddoc as koddoc, 
koddoc as kodkalplan, 
docsumma as summastage, 
STR_TO_DATE(CONCAT(yearenddoc,'-',monthenddoc,'-',dayenddoc), '%Y-%m-%d') as srokstage_date, 
kodshab as kodshab, 
numberchet as docnumber, 
koddened as koddened, 
kodzakaz as kodzakaz, 
docnamefullm as docnamefullm 
FROM dognet_docbase WHERE kodstatus='' AND (yearenddoc<>'0' AND monthenddoc<>'0' AND dayenddoc<>'0') AND (kodtip='245287841608965' OR kodtip='245287841599652') AND numberchet<>'' AND kodshab='0' AND koddel<>'99' 

ORDER BY koddoc DESC";

$_SQLReq_Docs_Clr = str_replace(array('\'', '"'), '`', $_SQLReq_Docs);
echo '<br>' . $_SQLReq_Docs_Clr;
$_SQLReq_Insert1 = "";
$messageContent_docInfo = "";
$_QRY_Docs = mysqlQuery($_SQLReq_Docs);


if (isset($_QRY_Docs)) {
	while ($_ROW_Docs = mysqli_fetch_assoc($_QRY_Docs)) {

		$_koddoc = $_ROW_Docs['koddoc'];
		$_kodshab = $_ROW_Docs['kodshab'];
		$_kodkalplan = $_ROW_Docs['kodkalplan'];
		// $strEndDocY = $_ROW_Docs['yearenddoc'];
		// $strEndDocM = $_ROW_Docs['monthenddoc'];
		// $strEndDocD = $_ROW_Docs['dayenddoc'];
		// $strEndDoc = strtotime($strEndDocY . "-" . $strEndDocM . "-" . $strEndDocD);
		$strEndDoc = strtotime($_ROW_Docs['srokstage_date']);
		$strNow = strtotime("now");
		$diff = round(($strEndDoc - $strNow) / 60 / 60 / 24);
		#
		#
		# Данные по договору
		$_messageTitle = "Срок поставки";
		$_docSrok = "";
		$_docName = "";
		$_docStageName = "";
		$_docStageNum = "";
		$_docNumber = "";
		$_docNumberURL = "";
		$_docZak = "";
		$_zakHello = "Уважаемый";
		$_zakFirstName = "";
		$_zakMidName = "";
		$_zakLastName = "";
		$_zakDolj = "";
		$_docSum = "";
		$_fileURL = 'http://192.168.1.89/dognet/dognet-docview.php?docview_type=details&uniqueID=' . $_koddoc;
		$_messageText = "";
		# Для автоматической рассылки исполнителем письма по умолчанию делаем Тимофеева
		$_ispName = "Тимофеев Р.Ю.";
		$_ispTel = "8 (495) 660-0802 доб. 404";
		$_ispEmail = "tim@atgs.ru";
		#
		$_docSrok = $_ROW_Docs['srokstage_date'];
		$_docSrok = date("d.m.Y", strtotime($_docSrok));
		$_docSum = number_format($_ROW_Docs['summastage'], 2, '.', '');

		if (isset($_koddoc) && !empty($_koddoc) && $_kodshab !== '0') {
			$_QRY_DOC = mysqli_fetch_assoc(mysqlQuery("SELECT * FROM dognet_docbase WHERE koddoc='{$_koddoc}'"));
			$_docName = $_QRY_DOC['docnamefullm'];
			$_docNumber = "3-4/" . $_QRY_DOC['docnumber'];
			$_koddened = $_QRY_DOC['koddened'];
			$_kodzakaz = $_QRY_DOC['kodzakaz'];

			$_QRY_STG = mysqli_fetch_assoc(mysqlQuery("SELECT * FROM dognet_dockalplan WHERE kodkalplan='{$_kodkalplan}' ORDER BY kodkalplan DESC LIMIT 1"));
			$_docStageName = ", " . $_QRY_STG['nameshotstage'];
			$_docStageNum = ", спец. " . $_QRY_STG['numberstage'];
		} else {
			$_docName = $_ROW_Docs['docnamefullm'];
			$_docNumber = "счёт " . $_ROW_Docs['docnumber'];
			$_koddened = $_ROW_Docs['koddened'];
			$_kodzakaz = $_ROW_Docs['kodzakaz'];
		}

		if (isset($_koddened) && !empty($_koddened)) {
			$_QRY_DEN = mysqli_fetch_assoc(mysqlQuery("SELECT * FROM dognet_spdened WHERE koddened='{$_koddened}'"));
			$_docDened = $_QRY_DEN['short_code'];
			$_docSum = number_format($_docSum, 2, '.', '') . " " . $_docDened;
		}
		if (isset($_kodzakaz) && !empty($_kodzakaz)) {
			$_QRY_SP = mysqli_fetch_assoc(mysqlQuery("SELECT * FROM sp_contragents WHERE kodcontragent='{$_kodzakaz}'"));
			$_docZak = $_QRY_SP['namefull'];
			$_zakFirstName = $_QRY_SP['director_firstname'];
			$_zakMidName = $_QRY_SP['director_middlename'];
			$_zakLastName = $_QRY_SP['director_lastname'];
			$_zakDolj = $_QRY_SP['director_post'];
			//
			$_kodformlegal = $_QRY_SP['kodformlegal'];
			$_QRY_OPF = mysqli_fetch_assoc(mysqlQuery("SELECT * FROM sp_contragents_opf WHERE kodformlegal='{$_kodformlegal}'"));
			$_docZakOpf = $_QRY_OPF['abbr'];
			$_zakOrg = $_docZakOpf . " " . "\"" . $_docZak . "\"";
		}
		#
		# 
		if ($diff > 0) {
			echo '<br>($strEndDoc - $strNow): >>> ' . $_docNumber . ': ' . $_ROW_Docs['srokstage_date'] . ' :  ' . $strEndDoc . " - " . $strNow . " = " . $diff;
		}
		#
		#
		if ($diff <= 7 && $diff >= 6) {
			$_docNumberURL = '<a href="' . $_fileURL . '" title="" style="text-decoration:none !important">' . $_docNumber . '</a>';
			$_messageText = "Добрый день!<br><br>Во вложении проект письма о переносе срока поставки по договору. Если письмо необходимо написать, просьба скорректировать дату планируемой поставки и направить письмо Ю.Желобовой и В.Цареву.<br>Спасибо.<br><br>";
			$_messageText .= "Это письмо сгенерировано автоматически, поэтому в проекте письма указан текущий срок поставки, а исполнителем по умолчанию определен Тимофеев Р.Ю.<br><br>";
			$_messageText .= "Ниже информация о договоре.";
			// $_messageText .= "<br>";
			// $_messageText .= $strEndDoc . " / " . $strNow . " / " . $diff;
			#
			#
			# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			#
			/** 
			 * !!! Формирование документа для отправки в качестве вложения 
			 * !!! в письме о переносе срока по договору поставки
			 * 
			 * ? > Рассылка тестового сообщения на email разработчика
			 * ? > Last edition 21.11.2023
			 */
			#
			/**
			 * 
			 * Формируем дательный падеж для ИО руководителя компании-заказчика
			 * На основе класса https://github.com/petrovich/petrovich-php
			 *  
			 */
			mb_internal_encoding('UTF-8');
			$nc = new NCLNameCaseRu();
			$_zakLastName_D = $nc->qFullName($_zakLastName, $_zakFirstName, $_zakMidName, null, NCL::$DATELN, "S");
			$_zakFirstName_D = $nc->qFullName($_zakLastName, $_zakFirstName, $_zakMidName, null, NCL::$DATELN, "N");
			$_zakMidName_D = $nc->qFullName($_zakLastName, $_zakFirstName, $_zakMidName, null, NCL::$DATELN, "F");

			$base_url = 'https://ws3.morpher.ru';
			$token = "";
			$morpher = new Morpher($base_url, $token);
			$_zakDolj_D = !empty($_zakDolj) ? $morpher->russian->Parse($_zakDolj)->Dative : $_zakDolj;

			include("/var/www/html/atgs-portal.local/www/dognet/_assets/cron-phpscript/addons/exportDoc-phpword-transferSrokPost.php");
			#
			# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			#
			#
			$subjectTxt = "Договор [Поставка] : Письмо о переносе сроков поставки";
			$subject = "=?utf-8?B?" . base64_encode($subjectTxt) . "?=";
			#
			# Текст сообщения (верхняя часть)
			$message_header = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
<!--[if gte mso 9]><xml><o:OfficeDocumentSettings><o:AllowPNG/><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml><![endif]-->
<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
<meta content="width=device-width" name="viewport"/>
<!--[if !mso]><!-->
<meta content="IE=edge" http-equiv="X-UA-Compatible"/>
<!--<![endif]-->
<title></title>
<!--[if !mso]><!-->
<!--<![endif]-->
<style type="text/css">
		body {
			margin: 0;
			padding: 0;
		}

		table,
		td,
		tr {
			vertical-align: top;
			border-collapse: collapse;
		}

		* {
			line-height: inherit;
		}

		a[x-apple-data-detectors=true] {
			color: inherit !important;
			text-decoration: none !important;
		}
	</style>
<style id="media-query" type="text/css">
		@media (max-width: 620px) {

			.block-grid,
			.col {
				min-width: 320px !important;
				max-width: 100% !important;
				display: block !important;
			}

			.block-grid {
				width: 100% !important;
			}

			.col {
				width: 100% !important;
			}

			.col_cont {
				margin: 0 auto;
			}

			img.fullwidth,
			img.fullwidthOnMobile {
				max-width: 100% !important;
			}

			.no-stack .col {
				min-width: 0 !important;
				display: table-cell !important;
			}

			.no-stack.two-up .col {
				width: 50% !important;
			}

			.no-stack .col.num2 {
				width: 16.6% !important;
			}

			.no-stack .col.num3 {
				width: 25% !important;
			}

			.no-stack .col.num4 {
				width: 33% !important;
			}

			.no-stack .col.num5 {
				width: 41.6% !important;
			}

			.no-stack .col.num6 {
				width: 50% !important;
			}

			.no-stack .col.num7 {
				width: 58.3% !important;
			}

			.no-stack .col.num8 {
				width: 66.6% !important;
			}

			.no-stack .col.num9 {
				width: 75% !important;
			}

			.no-stack .col.num10 {
				width: 83.3% !important;
			}

			.video-block {
				max-width: none !important;
			}

			.mobile_hide {
				min-height: 0px;
				max-height: 0px;
				max-width: 0px;
				display: none;
				overflow: hidden;
				font-size: 0px;
			}

			.desktop_hide {
				display: block !important;
				max-height: none !important;
			}
		}
	</style>
</head>
<body class="clean-body" style="margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: #fff;">
<!--[if IE]><div class="ie-browser"><![endif]-->
<table bgcolor="#fff" cellpadding="0" cellspacing="0" class="nl-container" role="presentation" style="table-layout: fixed; vertical-align: top; min-width: 320px; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #fff; width: 100%;" valign="top" width="100%">
<tbody>
<tr style="vertical-align: top;" valign="top">
<td style="word-break: break-word; vertical-align: top;" valign="top">
<!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td align="center" style="background-color:#fff"><![endif]-->
<div style="background-color:transparent;">
<div class="block-grid mixed-two-up" style="min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;">
<div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
<!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:600px"><tr class="layout-full-width" style="background-color:transparent"><![endif]-->
<!--[if (mso)|(IE)]><td align="center" width="150" style="background-color:transparent;width:150px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
<div class="col num3" style="display: table-cell; vertical-align: top; max-width: 320px; min-width: 150px; width: 150px;">
<div class="col_cont" style="width:100% !important;">
<!--[if (!mso)&(!IE)]><!-->
<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
<!--<![endif]-->
<div class="mobile_hide">
<div align="left" class="img-container left fixedwidth fullwidthOnMobile" style="padding-right: 0px;padding-left: 0px;">
<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px"><td style="padding-right: 0px;padding-left: 0px;" align="left"><![endif]--><img alt="Alternate text" border="0" class="left fixedwidth fullwidthOnMobile" src="http://atgs.ru/ext/img/54a786fe-e089-481b-9f16-931582b7541e.png" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; width: 100%; max-width: 112px; display: block;" title="Alternate text" width="112"/>
<!--[if mso]></td></tr></table><![endif]-->
</div>
</div>
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td><td align="center" width="450" style="background-color:transparent;width:450px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
<div class="col num9" style="display: table-cell; vertical-align: top; min-width: 320px; max-width: 450px; width: 450px;">
<div class="col_cont" style="width:100% !important;">
<!--[if (!mso)&(!IE)]><!-->
<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
<!--<![endif]-->
<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 30px; padding-bottom: 15px; font-family: Arial, sans-serif"><![endif]-->
<div style="color:#555555;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:30px;padding-right:10px;padding-bottom:15px;padding-left:10px;">
<div style="line-height: 1.2; font-size: 12px; color: #555555; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;">
<p style="font-size: 24px; line-height: 1.2; word-break: break-word; text-align: left; mso-line-height-alt: 29px; margin: 0;"><span style="color: #ffb400; font-size: 24px;"><span style=""><strong><span style="font-size: 28px; text-transform: uppercase;">' . $_messageTitle . '</span><br/></strong></span></span></p>
<p style="font-size: 20px; line-height: 1.2; word-break: break-word; text-align: left; mso-line-height-alt: 24px; margin: 0;"><span style="color: #ffffff; font-size: 20px;"><span style=""><strong><span style="color: #000000;"><span style="background-color: #000000; color: #ffffff;">' . $_docSrok . '</span>&nbsp;/&nbsp;</span><span style="background-color: #000000; color: #ffffff;">Договор №' . $_docNumber . $_docStageNum . '</span></strong></span></span></p>
</div>
</div>
<!--[if mso]></td></tr></table><![endif]-->
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
';
			#
			#
			$message_body = '
<div style="background-color:transparent;">
<div class="block-grid" style="min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;">
<div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
<!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:600px"><tr class="layout-full-width" style="background-color:transparent"><![endif]-->
<!--[if (mso)|(IE)]><td align="center" width="600" style="background-color:transparent;width:600px; border-top: 1px solid transparent; border-left: 1px solid transparent; border-bottom: 1px solid transparent; border-right: 1px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:15px;"><![endif]-->
<div class="col num12" style="min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 598px;">
<div class="col_cont" style="width:100% !important;">
<!--[if (!mso)&(!IE)]><!-->
<div style="border-top:1px solid transparent; border-left:1px solid transparent; border-bottom:1px solid transparent; border-right:1px solid transparent; padding-top:5px; padding-bottom:15px; padding-right: 0px; padding-left: 0px;">
<!--<![endif]-->
<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 5px; padding-bottom: 5px; font-family: Arial, sans-serif"><![endif]-->
<div style="color:#555555;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:5px;padding-right:10px;padding-bottom:5px;padding-left:10px;">
<div style="line-height: 1.2; font-size: 12px; color: #555555; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;">
<p style="font-size: 14px; line-height: 1.2; word-break: break-word; mso-line-height-alt: 17px; margin: 0;"><strong><span style="color: #a94442; font-size: 18px;"><span style="">' . $_messageText . '</span></span></strong></p>
</div>
</div>
<!--[if mso]></td></tr></table><![endif]-->
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style="background-color:transparent;">
<div class="block-grid" style="min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;">
<div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
<!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:600px"><tr class="layout-full-width" style="background-color:transparent"><![endif]-->
<!--[if (mso)|(IE)]><td align="center" width="600" style="background-color:transparent;width:600px; border-top: 1px solid transparent; border-left: 1px solid transparent; border-bottom: 1px solid transparent; border-right: 1px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:15px;"><![endif]-->
<div class="col num12" style="min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 598px;">
<div class="col_cont" style="width:100% !important;">
<!--[if (!mso)&(!IE)]><!-->
<div style="border-top:1px solid transparent; border-left:1px solid transparent; border-bottom:1px solid transparent; border-right:1px solid transparent; padding-top:5px; padding-bottom:15px; padding-right: 0px; padding-left: 0px;">
<!--<![endif]-->
<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 5px; padding-bottom: 5px; font-family: Arial, sans-serif"><![endif]-->
<div style="color:#555555;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:5px;padding-right:10px;padding-bottom:5px;padding-left:10px;">
<div style="line-height: 1.2; font-size: 12px; color: #555555; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;">
<p style="font-size: 14px; line-height: 1.2; word-break: break-word; mso-line-height-alt: 17px; margin: 0;"><strong><span style="color: #000000; font-size: 14px;"><span style="">' . $_docName . '</span></span></strong></p>
</div>
</div>
<!--[if mso]></td></tr></table><![endif]-->
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style="background-color:transparent;">
<div class="block-grid mixed-two-up" style="min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;">
<div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
<!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:600px"><tr class="layout-full-width" style="background-color:transparent"><![endif]-->
<!--[if (mso)|(IE)]><td align="center" width="200" style="background-color:transparent;width:200px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:0px; padding-bottom:0px;"><![endif]-->
<div class="col num4" style="display: table-cell; vertical-align: top; max-width: 320px; min-width: 200px; width: 200px;">
<div class="col_cont" style="width:100% !important;">
<!--[if (!mso)&(!IE)]><!-->
<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:0px; padding-bottom:0px; padding-right: 0px; padding-left: 0px;">
<!--<![endif]-->
<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 5px; padding-bottom: 5px; font-family: Arial, sans-serif"><![endif]-->
<div style="color:#555555;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:5px;padding-right:10px;padding-bottom:5px;padding-left:10px;">
<div style="line-height: 1.2; font-size: 12px; color: #555555; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;">
<p style="font-size: 12px; line-height: 1.2; word-break: break-word; mso-line-height-alt: 14px; margin: 0;"><span style="font-size: 12px; color: #333333;">ССЫЛКА НА ДОГОВОР</span></p>
</div>
</div>
<!--[if mso]></td></tr></table><![endif]-->
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td><td align="center" width="400" style="background-color:transparent;width:400px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:0px; padding-bottom:0px;"><![endif]-->
<div class="col num8" style="display: table-cell; vertical-align: top; min-width: 320px; max-width: 400px; width: 400px;">
<div class="col_cont" style="width:100% !important;">
<!--[if (!mso)&(!IE)]><!-->
<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:0px; padding-bottom:0px; padding-right: 0px; padding-left: 0px;">
<!--<![endif]-->
<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 5px; padding-bottom: 5px; font-family: Arial, sans-serif"><![endif]-->
<div style="color:#555555;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:5px;padding-right:10px;padding-bottom:5px;padding-left:10px;">
<div style="line-height: 1.2; font-size: 12px; color: #555555; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;">
<p style="font-size: 14px; line-height: 1.2; word-break: break-word; mso-line-height-alt: 14px; margin: 0;"><span style="color: #000000;"><strong><span style="font-size: 12px;">' . $_docNumberURL . '</span></strong></span></p>
</div>
</div>
<!--[if mso]></td></tr></table><![endif]-->
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style="background-color:transparent;">
<div class="block-grid mixed-two-up" style="min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;">
<div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
<!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:600px"><tr class="layout-full-width" style="background-color:transparent"><![endif]-->
<!--[if (mso)|(IE)]><td align="center" width="200" style="background-color:transparent;width:200px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:0px; padding-bottom:0px;"><![endif]-->
<div class="col num4" style="display: table-cell; vertical-align: top; max-width: 320px; min-width: 200px; width: 200px;">
<div class="col_cont" style="width:100% !important;">
<!--[if (!mso)&(!IE)]><!-->
<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:0px; padding-bottom:0px; padding-right: 0px; padding-left: 0px;">
<!--<![endif]-->
<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 5px; padding-bottom: 5px; font-family: Arial, sans-serif"><![endif]-->
<div style="color:#555555;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2; padding-top:5px;padding-right:10px;padding-bottom:5px;padding-left:10px;">
<div style="line-height: 1.2; font-size: 12px; color: #555555; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;">
<p style="font-size: 12px; line-height: 1.2; word-break: break-word; mso-line-height-alt: 14px; margin: 0;"><span style="font-size: 12px; color: #333333;">ЗАКАЗЧИК</span></p>
</div>
</div>
<!--[if mso]></td></tr></table><![endif]-->
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td><td align="center" width="400" style="background-color:transparent;width:400px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:0px; padding-bottom:0px;"><![endif]-->
<div class="col num8" style="display: table-cell; vertical-align: top; min-width: 320px; max-width: 400px; width: 400px;">
<div class="col_cont" style="width:100% !important;">
<!--[if (!mso)&(!IE)]><!-->
<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:0px; padding-bottom:0px; padding-right: 0px; padding-left: 0px;">
<!--<![endif]-->
<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 5px; padding-bottom: 5px; font-family: Arial, sans-serif"><![endif]-->
<div style="color:#555555;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:5px;padding-right:10px;padding-bottom:5px;padding-left:10px;">
<div style="line-height: 1.2; font-size: 12px; color: #555555; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;">
<p style="line-height: 1.2; word-break: break-word; mso-line-height-alt: 14px; margin: 0;"><span style="color: #000000;"><strong>' . $_zakOrg . '</strong></span></p>
</div>
</div>
<!--[if mso]></td></tr></table><![endif]-->
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style="background-color:transparent;">
<div class="block-grid mixed-two-up" style="min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;">
<div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
<!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:600px"><tr class="layout-full-width" style="background-color:transparent"><![endif]-->
<!--[if (mso)|(IE)]><td align="center" width="200" style="background-color:transparent;width:200px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:0px; padding-bottom:0px;"><![endif]-->
<div class="col num4" style="display: table-cell; vertical-align: top; max-width: 320px; min-width: 200px; width: 200px;">
<div class="col_cont" style="width:100% !important;">
<!--[if (!mso)&(!IE)]><!-->
<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:0px; padding-bottom:0px; padding-right: 0px; padding-left: 0px;">
<!--<![endif]-->
<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 5px; padding-bottom: 5px; font-family: Arial, sans-serif"><![endif]-->
<div style="color:#555555;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:5px;padding-right:10px;padding-bottom:5px;padding-left:10px;">
<div style="line-height: 1.2; font-size: 12px; color: #555555; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;">
<p style="font-size: 12px; line-height: 1.2; word-break: break-word; mso-line-height-alt: 14px; margin: 0;"><span style="font-size: 12px; color: #333333;">СУММА ДОГОВОРА</span></p>
</div>
</div>
<!--[if mso]></td></tr></table><![endif]-->
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td><td align="center" width="400" style="background-color:transparent;width:400px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:0px; padding-bottom:0px;"><![endif]-->
<div class="col num8" style="display: table-cell; vertical-align: top; min-width: 320px; max-width: 400px; width: 400px;">
<div class="col_cont" style="width:100% !important;">
<!--[if (!mso)&(!IE)]><!-->
<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:0px; padding-bottom:0px; padding-right: 0px; padding-left: 0px;">
<!--<![endif]-->
<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 5px; padding-bottom: 5px; font-family: Arial, sans-serif"><![endif]-->
<div style="color:#555555;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:5px;padding-right:10px;padding-bottom:5px;padding-left:10px;">
<div style="line-height: 1.2; font-size: 12px; color: #555555; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;">
<p style="font-size: 14px; line-height: 1.2; word-break: break-word; mso-line-height-alt: 14px; margin: 0;"><span style="color: #000000;"><strong><span style="font-size: 12px;">' . $_docSum . '</span></strong></span></p>
</div>
</div>
<!--[if mso]></td></tr></table><![endif]-->
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style="background-color:transparent;">
<div class="block-grid" style="min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;">
<div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
<!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:600px"><tr class="layout-full-width" style="background-color:transparent"><![endif]-->
<!--[if (mso)|(IE)]><td align="center" width="600" style="background-color:transparent;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
<div class="col num12" style="min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;">
<div class="col_cont" style="width:100% !important;">
<!--[if (!mso)&(!IE)]><!-->
<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
<!--<![endif]-->
<table border="0" cellpadding="0" cellspacing="0" class="divider" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;" valign="top" width="100%">
<tbody>
<tr style="vertical-align: top;" valign="top">
<td class="divider_inner" style="word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 15px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px;" valign="top">
<table align="center" border="0" cellpadding="0" cellspacing="0" class="divider_content" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-top: 1px solid #BBBBBB; width: 100%;" valign="top" width="100%">
<tbody>
<tr style="vertical-align: top;" valign="top">
<td style="word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;" valign="top"><span></span></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
';
			#
			#
			$message_footer = '
<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 0px; padding-bottom: 0px; font-family: Arial, sans-serif"><![endif]-->
<div style="color:#555555;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:0px;padding-right:10px;padding-bottom:0px;padding-left:10px;">
<div style="line-height: 1.2; font-size: 12px; color: #555555; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;">
<p style="font-size: 9px; line-height: 1.2; word-break: break-word; text-align: left; mso-line-height-alt: 11px; margin: 0;"><span style="font-size: 9px; color: #999999;"><em><span style="">Служба уведомлений <span style="color: #333333;">АТГС.Портал</span><br/></span></em></span></p>
<p style="font-size: 9px; line-height: 1.2; word-break: break-word; text-align: left; mso-line-height-alt: 11px; margin: 0;"><span style="font-size: 9px; color: #999999;"><em><span style="">Данное сообщение отправлено роботом. Не используйте адрес его отправителя для обратной связи.</span></em></span></p>
</div>
</div>
<!--[if mso]></td></tr></table><![endif]-->
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
</td>
</tr>
</tbody>
</table>
<!--[if (IE)]></div><![endif]-->
</body>
</html>
';
			#
			#
			# ----- ----- ----- ----- -----
			#
			# SERVER SETTINGS
			#
			#
			// Enable verbose debug output
			$mailer->SMTPDebug = SMTP::DEBUG_SERVER;
			// Disable verbose debug output
			$mailer->SMTPDebug = 0;
			// Send using SMTP
			$mailer->isSMTP();
			// Set the SMTP server to send through
			$mailer->Host = 'mail.atgs.ru';
			// Enable SMTP authentication
			$mailer->SMTPAuth = true;
			// SMTP connection will not close after each email sent, reduces SMTP overhead
			$mailer->SMTPKeepAlive = true;
			// SMTP username
			$mailer->Username = 'portal@atgs.ru';
			// SMTP password
			$mailer->Password = 'iu3Li,quohch';
			// Enable TLS encryption, `PHPMailer::ENCRYPTION_SMTPS` also accepted
			$mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
			// TCP port
			$mailer->Port = 587;
			#
			#
			# ----- ----- ----- ----- -----
			#
			#
			$mailer->setLanguage('ru', "/var/www/html/atgs-portal.local/www/dognet/_assets/_PHPMailer/language/");
			$mailer->CharSet = "utf-8";
			#
			# From
			$from_name = "АТГС.Портал / Корпоративные сервисы";
			$from_email = "portal@atgs.ru";
			$from_name = "=?utf-8?B?" . base64_encode($from_name) . "?=";
			$mailer->setFrom($from_email, $from_name);
			#
			# ПОЛУЧАТЕЛИ
			# $mailer->addReplyTo('email', 'name')
			# Email is an recipient address, Name is optional
			#
			# Тестовый набор адресатов
			$email_to = "zholobova@atgs.ru";
			// $email_opt = "Y. Chugunov";
			// $mailer->addAddress($email_to, $email_opt);
			// $mailer->addAddress("chugunov@atgs.ru", "Y. Chugunov");

			# Рабочий набор адресатов
			$mailer->addAddress("zholobova@atgs.ru", "J. Zholobova");
			$mailer->addAddress("tim@atgs.ru", "R. Timofeev");
			$mailer->addCC("chugunov@atgs.ru", "Y. Chugunov");

			// $mailer->addAddress('office-all@atgs.ru', 'ATGS Office');
			$mailer->addReplyTo('noreply@atgs.ru', 'Do not reply');

			# ----- ----- ----- ----- -----
			#
			$checkedFilepath = (isset($filepath) && $filepath != "") ? $filepath : "";
			$checkedFilename = (isset($filename) && $filename != "") ? $filename : "";
			$_attachment = $checkedFilepath . $checkedFilename;
			$mailer->addAttachment($_attachment);
			#
			# ----- ----- ----- ----- -----
			#
			#
			// Content
			$mailer->isHTML(true);                                  // Set email format to HTML
			$mailer->Subject = $subject;
			$mailer->Body    = $message_header . $message_addresser . $message_body . $message_footer;
			$mailer->AltBody = 'Ваш почтовый клиент не принимает сообщений в формате HTML.';
			#
			# ::: Send the message, check for errors
			#
			# Открыли файл для записи данных в конец файла
			$filename = "/var/www/html/atgs-portal.local/www/dognet/PHPMailer_errors.log";
			// echo '<br>' . $message_body;
			if ($_IS_MAILING_ENBL) {
				if (is_writable($filename)) {

					if (!$handle = fopen($filename, 'a')) {
						exit;
					}

					if (!$mailer->send()) {
						$text = date('Y-m-d H:i:s') . " : ошибка рассылки на ( $email_to ) : " . $mailer->ErrorInfo . PHP_EOL;
						// Записываем в наш открытый файл.
						if (fwrite($handle, $text) === FALSE) {
							exit;
						}
						fclose($handle);
						$sending_status = "err";
					} else {
						$text = date('Y-m-d H:i:s') . " : сообщение на ( $email_to ) успешно отправлено" . PHP_EOL;
						$sending_status = "ok";
						// Записываем в наш открытый файл.
						if (fwrite($handle, $text) === FALSE) {
							exit;
						}
						fclose($handle);
					}
				} else {
					$text = "Файл $filename недоступен для записи";
					if (fwrite($handle, $text) === FALSE) {
						exit;
					}
					fclose($handle);
				}
			}
			#
			# :::
			// Clear all addresses and attachments for next loop
			$mailer->ClearAllRecipients();
			$mailer->ClearAddresses();
		}
	}
}
unset($_IS_CRONTAB);
