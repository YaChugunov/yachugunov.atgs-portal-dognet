<?php

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
	default: "---";
}


# Import PHPMailer classes into the global namespace
# These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
#
# Подключаем библиотеки
require $_SERVER['DOCUMENT_ROOT']."/dognet/_assets/_PHPMailer/src/Exception.php";
require $_SERVER['DOCUMENT_ROOT']."/dognet/_assets/_PHPMailer/src/PHPMailer.php";
require $_SERVER['DOCUMENT_ROOT']."/dognet/_assets/_PHPMailer/src/SMTP.php";

#
# Instantiation and passing `true` enables exceptions
$mail3 = new PHPMailer;
$message3 = "";
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
	$subjectTxt = "Договор [Заявки] : обновление по заявке № ".$_ROW_TIPZAYV['nametipzayvshotall']."-".$_ROW_ZAYV['numberzayv']." от ".date('d.m.Y', strtotime($_ROW_ZAYV['datezayv']));
	$subject = "=?utf-8?B?".base64_encode($subjectTxt)."?=";
#
# Текст сообщения (верхняя часть)
	$message3 = "<html>";
	$message3 .= "<head></head>";
	$message3 .= "<body>";
	$message3 .= "<div style=\"text-align:left\" >";

	$message3 .= "
		<h3 class='msg-h3'>Обновление по заявке № ".$_ROW_TIPZAYV['nametipzayvshotall']."-".$_ROW_ZAYV['numberzayv']." от ".date('d.m.Y', strtotime($_ROW_ZAYV['datezayv']))."</h3>
		<h4 class='msg-h4'>Заявитель: <span>".$_ROW_ZAYVTEL['namezayvtelshot']."</span></h4>
		<div class='msg-maintext' style=\"margin-top: 10px;\">
		<span>-----</span><br>";
#
#
if (isset($_GET['msgSubject'])) {
	switch ($_GET['msgSubject']) {
		case 0:
			$message3 .= "
				<span style='color:red'><b>Тестовое сообщение. Идет проверка работы сервиса. Не обращайте внимание на это сообщение.</b></span><br>";
		break;
		case 1:
			$message3 .= "
				<span><b>Создана новая заявка № ".$_ROW_TIPZAYV['nametipzayvshotall']."-".$_ROW_ZAYV['numberzayv']." от ".date('d.m.Y', strtotime($_ROW_ZAYV['datezayv']))."</b></span><br>";
		break;
		case 2:
			$message3 .= "
				<span><b>Был изменен статус заявки № ".$_ROW_TIPZAYV['nametipzayvshotall']."-".$_ROW_ZAYV['numberzayv']." от ".date('d.m.Y', strtotime($_ROW_ZAYV['datezayv']))."</b></span><br>
				<span>Текущий статус - <b>".$_ZAYV_STATUS."</b></span><br>";
		break;
		case 3:
			$message3 .= "
				<span><b>Произошли изменения в регистрационных данных выбранной заявки</b></span><br>
				<span>Дата создания заявки - ".date('d.m.Y', strtotime($_ROW_ZAYV['datezayv']))."</span><br>
				<span>№ заявки : ".$_ROW_TIPZAYV['nametipzayvshotall']."-".$_ROW_ZAYV['numberzayv']."</span><br>
				<span>Статус заявки : <b>".$_ZAYV_STATUS."</b></span><br>
				<span>Примечание : ".((!empty($_ROW_ZAYV['namerabfilespec'])) ? $_ROW_ZAYV['namerabfilespec'] : '---')."</span><br>";
		break;
		default:
			$message3 .= "";
	}
}
#
#
	$message3 .= "
		<br>
		</div>
		";
#
#
# Текст сообщения (нижняя часть)
	$message3 .= "<div style=\"margin-top: 10px; display: block; text-align: left; padding: 15px 0; border-top: 1px #ccc solid;\">";
	$message3 .= "<span style=\"display: block\"><img src=\"http://atgs.ru/ext/img/dognet-logo-2-32x32.png\" height=\"32px\" /></span><br>";
	$message3 .= "<span><b>Корпоративный сервис АТГС.Договор</b></span><br>";
	$message3 .= "<span style=\"\"><i>-----</i></span><br>";
	$message3 .= "<span style=\"\"><i>* Это сообщение отправлено роботом. Не используйте адрес отправителя этого письма для обратной связи.</i></span>";
	$message3 .= "</div>";
	$message3 .= "</div>";
	$message3 .= "</body>";
	$message3 .= "</html>";

?>
	<div class="space10" style="padding:30px; background-color:#f1f1f1">
		<table id="mail-preview-info" class="table table-responsive">
			<tbody>
				<tr style="">
					<td width="30%" class="text-left"><span><b>Тип сообщения :</b></span></td>
					<td width="70%" class="text-left"><span><?php echo "Сообщение Заявителю"; ?></span></td>
				</tr>
				<tr style="">
					<td width="30%" class="text-left"><span><b>Тема сообщения :</b></span></td>
					<td width="70%" class="text-left"><span><?php echo $subjectTxt; ?></span></td>
				</tr>
				<tr style="">
					<td width="30%" class="text-left"><span><b>Получатель сообщения :</b></span></td>
					<td width="70%" class="text-left"><span><?php echo $_ROW_RECIPIENT['lastname']." ".mb_substr($_ROW_RECIPIENT['firstname'],0,1,'utf-8').". ".mb_substr($_ROW_RECIPIENT['middlename'],0,1,'utf-8').". / ".$_ROW_RECIPIENT['email2']; ?></span></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="space10" style="color: #111; background-color:#fff; font-size: 1.0em; border: 1px #f1f1f1 solid; padding: 20px">
		<table id="mail-preview-body" class="table table-responsive">
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
// SMTP password
  $mail3->Password = 'iu3Li,quohch';
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
	$from_name = "АТГС.Портал (сервис корпоративной документации)";
	$from_email = "portal@atgs.ru";
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
/*
 	$mail3->addAddress('chugunov@atgs.ru');
	$email_to = 'chugunov@atgs.ru';
*/
# ----- ----- ----- ----- -----
	$email_to = $_ROW_RECIPIENT['email2'];
 	$mail3->addAddress($email_to);
# ----- ----- ----- ----- -----
	$mail3->addReplyTo('notreply@atgs.ru', 'Do not reply');
# ----- ----- ----- ----- -----
#
// Content
  $mail3->isHTML(true);                                  // Set email format to HTML
  $mail3->Subject = $subject;
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
	        $text = date('Y-m-d h:i:s')." : ошибка рассылки на ( $email_to ) : ".$err;
	      // Записываем $somecontent в наш открытый файл.
	        if (fwrite($handle, $text) === FALSE) {
          echo "<span style='color:red; text-align:center'><i>Не могу произвести запись в лог файл.</i></span>";
	          exit;
	        }
	        echo "<span style='color:red; text-align:center'><i>Ошибка при отправке сообщения : $err.</i></span>";
	        fclose($handle);
	      }
	      else {
	        $text = date('Y-m-d h:i:s')." : сообщение на ( $email_to ) успешно отправлено".PHP_EOL;
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
#
	unset($_POST['sendMsg']);
#
#
}
?>

