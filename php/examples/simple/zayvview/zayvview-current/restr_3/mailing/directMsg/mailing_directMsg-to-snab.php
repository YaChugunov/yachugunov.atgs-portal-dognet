<?php
# ----- ----- -----
if (isset($_GET['uniqueID'])) {
	$_QRY_ZAYV = mysqlQuery("SELECT * FROM dognet_doczayv WHERE kodzayv = ".$_GET['uniqueID']);
	$_ROW_ZAYV = mysqli_fetch_assoc($_QRY_ZAYV);

	$_QRY_TIPZAYV = mysqlQuery("SELECT * FROM dognet_sptipzayvall WHERE kodtipzayvall = ".$_ROW_ZAYV['kodtipzayvall']);
	$_ROW_TIPZAYV = mysqli_fetch_assoc($_QRY_TIPZAYV);
}
# ----- ----- -----
// Определяем код Заявителя по справочнику Заявителей
	if (isset($_ROW_ZAYV['kodzayvtel'])&&!empty($_ROW_ZAYV['kodzayvtel'])) {
		$_QRY_ZAYVTEL = mysqlQuery("SELECT * FROM dognet_spzayvtel WHERE kodzayvtel = ".$_ROW_ZAYV['kodzayvtel']);
		$_ROW_ZAYVTEL = mysqli_fetch_assoc($_QRY_ZAYVTEL);
	}
// Определяем email Заявителя по таблице пользователей Портала
	if (isset($_ROW_ZAYVTEL['kodzayvtel'])&&!empty($_ROW_ZAYVTEL['kodzayvtel'])) {
		$_QRY_ZAYVTEL_EMAIL = mysqlQuery("SELECT * FROM users WHERE kodzayvtel = ".$_ROW_ZAYVTEL['kodzayvtel']);
		$_ROW_ZAYVTEL_EMAIL = mysqli_fetch_assoc($_QRY_ZAYVTEL_EMAIL);
	}
# ----- ----- -----

switch ($_ROW_ZAYV["tipusezayv"]) {
	case 0:
		$_ZAYV_STATUS = "Заявка сформирована";
	break;
	case 1:
		$_ZAYV_STATUS = "Выставлены все счета";
	break;
	case 2:
		$_ZAYV_STATUS = "Заявка закрыта";
	break;
	case 3:
		$_ZAYV_STATUS = "Заявка аннулирована";
	break;
	case 4:
		$_ZAYV_STATUS = "Выставлена часть счетов";
	break;
	default:
		$_ZAYV_STATUS = "---";
}


# Import PHPMailer classes into the global namespace
# These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
#
# Подключаем библиотеки
// require $_SERVER['DOCUMENT_ROOT']."/dognet/_assets/_PHPMailer/src/Exception.php";
// require $_SERVER['DOCUMENT_ROOT']."/dognet/_assets/_PHPMailer/src/PHPMailer.php";
// require $_SERVER['DOCUMENT_ROOT']."/dognet/_assets/_PHPMailer/src/SMTP.php";

#
# Instantiation and passing `true` enables exceptions
$mail3 = new PHPMailer;
$message3 = "";
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#

// Номер заявки
$_zayvnum = $_ROW_TIPZAYV['nametipzayvshotall']."-".$_ROW_ZAYV['numberzayv'];
// Дата заявки
$_zayvdate = date('d.m.Y', strtotime($_ROW_ZAYV['datezayv']));
// Имя файла
$_zayvdesc = $_ROW_ZAYV['namerabfilespec'];
// Имя заявителя
$_zayvuser = $_ROW_ZAYVTEL['namezayvtelshot'];
// Статус заявки
$_zayvstatus = $_ZAYV_STATUS;

#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
#
$subjectTxt = "Договор [Заявки] : Заявка № ".$_ROW_TIPZAYV['nametipzayvshotall']."-".$_ROW_ZAYV['numberzayv']." от ".date('d.m.Y', strtotime($_ROW_ZAYV['datezayv']));
$subject = "=?utf-8?B?".base64_encode($subjectTxt)."?=";
//
if (isset($_GET['msgSubject'])) {
	switch ($_GET['msgSubject']) {
		case 0:
			$_zayvtitle = "Заявка";
			$_zayvmsg = "Тестовое сообщение. Идет проверка работы алгоритма.";
		break;
		case 1:
			$_zayvtitle = "Новая заявка";
			$_zayvmsg = "Новая заявка";
			$subjectTxt = "Договор [Заявки] : Новая заявка № ".$_ROW_TIPZAYV['nametipzayvshotall']."-".$_ROW_ZAYV['numberzayv']." от ".date('d.m.Y', strtotime($_ROW_ZAYV['datezayv']));
			$subject = "=?utf-8?B?".base64_encode($subjectTxt)."?=";
		break;
		case 2:
			$_zayvtitle = "Заявка";
			$_zayvmsg = "Изменен статус заявки";
			$subjectTxt = "Договор [Заявки] : Изменен статус заявки № ".$_ROW_TIPZAYV['nametipzayvshotall']."-".$_ROW_ZAYV['numberzayv']." от ".date('d.m.Y', strtotime($_ROW_ZAYV['datezayv']));
			$subject = "=?utf-8?B?".base64_encode($subjectTxt)."?=";
		break;
		case 3:
			$_zayvtitle = "Заявка";
			$_zayvmsg = "Изменены параметры заявки";
			$subjectTxt = "Договор [Заявки] : Изменены параметры заявки № ".$_ROW_TIPZAYV['nametipzayvshotall']."-".$_ROW_ZAYV['numberzayv']." от ".date('d.m.Y', strtotime($_ROW_ZAYV['datezayv']));
			$subject = "=?utf-8?B?".base64_encode($subjectTxt)."?=";
		break;
		default:
			$_zayvtitle = "Заявка";
			$_zayvmsg = "О заявке";
			$subjectTxt = "Договор [Заявки] : Заявка № ".$_ROW_TIPZAYV['nametipzayvshotall']."-".$_ROW_ZAYV['numberzayv']." от ".date('d.m.Y', strtotime($_ROW_ZAYV['datezayv']));
			$subject = "=?utf-8?B?".base64_encode($subjectTxt)."?=";
	}
}
#
# Текст сообщения
	$message3 = '
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
<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px"><td style="padding-right: 0px;padding-left: 0px;" align="left"><![endif]--><img alt="Alternate text" border="0" class="left fixedwidth fullwidthOnMobile" src="http://atgs.ru/ext/img/54a786fe-a017-591a-3d16-131539b7541e.png" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; width: 100%; max-width: 112px; display: block;" title="Alternate text" width="112"/>
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
<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 25px; padding-bottom: 15px; font-family: Arial, sans-serif"><![endif]-->
<div style="color:#555555;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:25px;padding-right:10px;padding-bottom:15px;padding-left:10px;">
<div style="line-height: 1.2; font-size: 12px; color: #555555; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;">
<p style="font-size: 28px; line-height: 1.2; word-break: break-word; text-align: left; mso-line-height-alt: 34px; margin: 0;"><span style="color: #ffb400; font-size: 28px; text-transform: uppercase"><span style=""><strong>'.$_zayvtitle.'</strong></span></span></p>
<p style="font-size: 20px; line-height: 1.2; word-break: break-word; text-align: left; mso-line-height-alt: 24px; margin: 0;"><span style="color: #ffffff; font-size: 20px; background-color: #000000;"><span style=""><strong>'.$_zayvuser.'</strong></span></span><span style="color: #000000; font-size: 20px;"><span style=""><strong> / </strong></span></span><span style="color: #ffffff; font-size: 20px; background-color: #000000;"><span style=""><strong>'.$_zayvnum.'</strong></span></span></p>
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
<p style="font-size: 14px; line-height: 1.2; word-break: break-word; mso-line-height-alt: 17px; margin: 0;"><strong><span style="color: #000000; font-size: 18px;"><span style="">'.$_zayvmsg.'</span></span></strong></p>
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
<p style="font-size: 12px; line-height: 1.2; word-break: break-word; mso-line-height-alt: 14px; margin: 0;"><span style="font-size: 12px; color: #333333;">ДАТА ЗАЯВКИ</span></p>
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
<p style="font-size: 14px; line-height: 1.2; word-break: break-word; mso-line-height-alt: 17px; margin: 0;"><span style="color: #000000;"><strong><span style="font-size: 12px;">'.$_zayvdate.'</span></strong></span></p>
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
<p style="font-size: 12px; line-height: 1.2; word-break: break-word; mso-line-height-alt: 14px; margin: 0;"><span style="font-size: 12px; color: #333333;">НОМЕР ЗАЯВКИ</span></p>
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
<p style="font-size: 14px; line-height: 1.2; word-break: break-word; mso-line-height-alt: 17px; margin: 0;"><span style="color: #000000;"><strong><span style="font-size: 12px;">'.$_zayvnum.'</span></strong></span></p>
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
<p style="font-size: 12px; line-height: 1.2; word-break: break-word; mso-line-height-alt: 14px; margin: 0;"><span style="font-size: 12px; color: #333333;">ЗАЯВИТЕЛЬ</span></p>
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
<p style="font-size: 14px; line-height: 1.2; word-break: break-word; mso-line-height-alt: 17px; margin: 0;"><span style="color: #000000;"><strong><span style="font-size: 12px;">'.$_zayvuser.'</span></strong></span></p>
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
<p style="font-size: 12px; line-height: 1.2; word-break: break-word; mso-line-height-alt: 14px; margin: 0;"><span style="font-size: 12px; color: #333333;">ОПИСАНИЕ</span></p>
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
<p style="font-size: 14px; line-height: 1.2; word-break: break-word; text-align: left; mso-line-height-alt: 17px; margin: 0;"><strong><span style="color: #000000; font-size: 12px;">'.$_zayvdesc.'</span></strong></p>
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
<p style="font-size: 12px; line-height: 1.2; word-break: break-word; mso-line-height-alt: 14px; margin: 0;"><span style="font-size: 12px; color: #333333;">СТАТУС</span></p>
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
<p style="font-size: 12px; line-height: 1.2; word-break: break-word; text-align: left; mso-line-height-alt: 14px; margin: 0;"><span style="font-size: 12px; background-color: #ffb400;"><strong><span style="color: #000000;">'.$_zayvstatus.'</span></strong></span></p>
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
<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 0px; padding-bottom: 0px; font-family: Arial, sans-serif"><![endif]-->
<div style="color:#555555;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:0px;padding-right:10px;padding-bottom:0px;padding-left:10px;">
<div style="line-height: 1.2; font-size: 12px; color: #555555; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;">
<p style="font-size: 9px; line-height: 1.2; word-break: break-word; text-align: left; mso-line-height-alt: 11px; margin: 0;"><span style="font-size: 9px; color: #999999;"><em><span style="">Служба уведомлений <span style="color: #333333;">АТГС.Портал</span></span></em></span></p>
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
?>
	<div class="space10" style="padding:30px; background-color:#f1f1f1">
		<table id="mail-preview-info" class="table table-responsive">
			<tbody>
				<tr style="">
					<td width="30%" class="text-left"><span><b>Тип рассылки :</b></span></td>
					<td width="70%" class="text-left"><span><?php echo "Сообщение на snab@atgs.ru"; ?></span></td>
				</tr>
				<tr style="">
					<td width="30%" class="text-left"><span><b>Тема сообщения :</b></span></td>
					<td width="70%" class="text-left"><span><?php echo $subjectTxt; ?></span></td>
				</tr>
				<tr style="">
					<td width="30%" class="text-left"><span><b>Получатель сообщения :</b></span></td>
					<td width="70%" class="text-left"><span><?php echo "snab@atgs.ru"; ?></span></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="space10" style="color: #111; background-color:#fff; font-size: 1.0em; border: 1px #f1f1f1 solid; padding: 20px">
		<table id="mail-preview-body" class="table table-responsive text-left">
			<tbody>
				<tr style="">
					<td style="border-top:none">
							<?php echo $message3; ?>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<form action="" class="form-inline" method="POST" enctype="multipart/form-data">
		<div class="form-group">
	    	<button type="submit" name="sendMsg" class="btn btn-lg btn-info">Отправить</button>
		</div>
	</form>
<?php
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
  $mail3->setLanguage('ru', $_SERVER['DOCUMENT_ROOT']."/dognet/_assets/_PHPMailer/language/");
  $mail3->CharSet = "utf-8";
#
# From
	$from_name = "АТГС.Портал / Корпоративные сервисы";
	$from_email = "portal@atgs.ru";
// 	$from_email = "dinner@atgs.ru";
	$from_name = "=?utf-8?B?".base64_encode($from_name)."?=";
	$mail3->setFrom($from_email, $from_name);
# ----- ----- ----- ----- -----
#
#
if ( isset($_POST['sendMsg']) ) {
#
#
#
# ПОЛУЧАТЕЛИ
# $mail3->addReplyTo('email', 'name')
# Email is an recipient address, Name is optional
#
# ----- ----- ----- ----- -----
		$email_0 = "snab@atgs.ru";
		//
		$email_8 = "chugunov@atgs.ru";
# ----- ----- ----- ----- -----
	 	$mail3->addAddress($email_0);
	 	$mail3->addCC($email_8);
		$mail3->addReplyTo('notreply@atgs.ru', 'Do not reply');
# ----- ----- ----- ----- -----
#
// Content
	  $mail3->isHTML(true); // Set email format to HTML
	  $mail3->Subject = $subject." / Message on snab@atgs.ru";
	  $mail3->Body    = $message3;
	  $mail3->AltBody = 'Ваш почтовый клиент не принимает сообщений в формате HTML. Вариант рассылки в формате PLAIN TEXT будет реализован позже.';
#
# ::: Send the message, check for errors
#
# Открыли файл для записи данных в конец файла
	    $filename = $_SERVER['DOCUMENT_ROOT']."/dognet/PHPMailer_errors.log";
	    if (is_writable($filename)) {

	      if (!$handle = fopen($filename, 'a')) {
	        echo "<span style='color:red; text-align:center'><i>Не могу открыть лог-файл для записи отчета об отправке.</i></span>";
	        exit;
	      }

	      if (!$mail3->send()) {
		      $err = $mail3->ErrorInfo.PHP_EOL;
	        $text = date('Y-m-d h:i:s')." : ошибка рассылки на ( Список Скубаева 1 ) : ".$err;
	      // Записываем $somecontent в наш открытый файл.
	        if (fwrite($handle, $text) === FALSE) {
          echo "<span style='color:red; text-align:center'><i>Не могу произвести запись в лог файл.</i></span>";
	          exit;
	        }
	        echo "<span style='color:red; text-align:center'><i>Ошибка при отправке сообщения : $err.</i></span>";
	        fclose($handle);
	      }
	      else {
	        $text = date('Y-m-d h:i:s')." : сообщение на ( Список Скубаева 1 ) успешно отправлено".PHP_EOL;
	      // Записываем $somecontent в наш открытый файл.
	        if (fwrite($handle, $text) === FALSE) {
	        echo "<span style='color:red; text-align:center'><i>Не могу произвести запись в лог-файл.</i></span>";
	          exit;
	        }
        echo "<span style='color:green; text-align:center'><i>Сообщение успешно отправлено. Запись в лог-файл произведена.</i></span>";
	        fclose($handle);
	      }
	    }
	    else {
      echo "<span style='color:red; text-align:center'><i>Лог-файл недоступен для записи.</i></span>";
	    }
#
# :::
// Clear all addresses and attachments for next loop
  $mail3->ClearAddresses();
	unset($_POST['sendMsg']);
#
#
}
?>

