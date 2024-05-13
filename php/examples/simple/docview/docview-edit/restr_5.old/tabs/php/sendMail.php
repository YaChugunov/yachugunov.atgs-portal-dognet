<?php

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

# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# УВЕДОМЛЕНИЕ ПО EMAIL О ПОЯВЛЕНИИ НОВОГО АВАНСА


		//
		// Instantiation and passing `true` enables exceptions
		$mail3 = new PHPMailer(true);
		$message3 = "";
		//
		//
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		//
			$subjectTxt = "Договор [Авансы] : Получен новый аванс";
			$subject = "=?utf-8?B?".base64_encode($subjectTxt)."?=";
		//
		// Текст сообщения (верхняя часть)
			$message3 = "<html>";
			$message3 .= "<head></head>";
			$message3 .= "<body>";
			$message3 .= "<div style=\"text-align:left\" >";

			$message3 .= "
				<h3>Получен новый аванс</h3>
				<div style=\"margin-top: 10px;\">
				<span>-----</span><br>";

			$message3 .= "
				<span>Дата аванса : ".NULL."</span><br>
				<span>Договор № : ".NULL."</span><br>
				<span>Этап № : ".NULL."</span><br>
				<span>Сумма : ".NULL."</span><br>";

			$message3 .= "
				<br>
				</div>
				";

			$message3 .= "<div style=\"margin-top: 10px; display: block; text-align: left; padding: 15px 0; border-top: 1px #ccc solid;\">";
			$message3 .= "<span style=\"display: block\"><img src=\"http://atgs.ru/ext/img/dognet-logo-2-32x32.png\" height=\"32px\" /></span><br>";
			$message3 .= "<span><b>Корпоративный сервис АТГС.Договор</b></span><br>";
			$message3 .= "<span style=\"\"><i>-----</i></span><br>";
			$message3 .= "<span style=\"\"><i>* Это сообщение отправлено роботом. Не используйте адрес отправителя этого письма для обратной связи.</i></span>";
			$message3 .= "</div>";
			$message3 .= "</div>";
			$message3 .= "</body>";
			$message3 .= "</html>";
		//
		//
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
# ПОЛУЧАТЕЛИ
# $mail3->addReplyTo('email', 'name')
# Email is an recipient address, Name is optional
#
// 	$email_to = 'office-all@atgs.ru';
//   $mail3->addAddress($email_to, 'ATGS Office');

 	$mail3->addAddress("chugunov@atgs.ru", "Y. Chugunov");
/*  	$mail3->addAddress("informed.looser@gmail.com", "Y. Chugunov"); */
	$mail3->addReplyTo('notreply@atgs.ru', 'Do not reply');
#
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
 	        // echo "<span style='color:red; text-align:center'><i>Не могу открыть лог-файл для записи отчета об отправке.</i></span>";
	        echo "-2";
	        exit;
	      }

	      if (!$mail3->send()) {
		    $err = $mail3->ErrorInfo.PHP_EOL;
	        $text = date('Y-m-d h:i:s')." : ошибка рассылки : ".$err;
	      // Записываем $somecontent в наш открытый файл.
	        if (fwrite($handle, $text) === FALSE) {
	          // echo "<span style='color:red; text-align:center'><i>Не могу произвести запись в лог файл.</i></span>";
	          echo "-1";
	          exit;
	        }
	        // echo "<span style='color:red; text-align:center'><i>Ошибка при отправке сообщения : $err.</i></span>";
	        echo "2";
	        fclose($handle);
	      }
	      else {
	        $text = date('Y-m-d h:i:s')." : сообщение успешно отправлено".PHP_EOL;
	      // Записываем $somecontent в наш открытый файл.
	        if (fwrite($handle, $text) === FALSE) {
	          // echo "<span style='color:red; text-align:center'><i>Не могу произвести запись в лог-файл.</i></span>";
	          echo "-1";
	          exit;
	        }
	          // echo "<span style='color:green; text-align:center'><i>Сообщение успешно отправлено. Запись в лог-файл произведена.</i></span>";
	          echo "0";
	          fclose($handle);
	      }
	    }
	    else {
	      // echo "<span style='color:red; text-align:center'><i>Лог-файл недоступен для записи.</i></span>";
	      echo "-1";
	    }


?>