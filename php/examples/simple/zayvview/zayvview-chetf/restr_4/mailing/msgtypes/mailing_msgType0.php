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
#
# Instantiation and passing `true` enables exceptions
$mail3 = new PHPMailer;
$message3 = "";
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
	$subjectTxt = "АТГС.Договор / Заявки";
	$subject = "=?utf-8?B?".base64_encode($subjectTxt)."?=";
#
# Текст сообщения (верхняя часть)
	$message3 = "<html>";
	$message3 .= "<head></head>";
	$message3 .= "<body>";
	$message3 .= "<div style=\"\" >";

	$message3 .= "
		<h3>Тестовое сообщение</h3>
		<div style=\"margin-top: 10px;\">
		<span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. \"<b>Nunc a nulla et diam</b>\" aliquam dictum. Donec eleifend diam at quam sollicitudin, ac maximus tellus maximus. Sed vestibulum, risus imperdiet tempor suscipit, arcu libero porta diam, vel vestibulum leo eros ut ante. Etiam ut malesuada lectus. Fusce tempus augue vel ex hendrerit, nec facilisis leo molestie.</span><br><br>
		<span>-----</span><br>
		<span><b>Тип сообщения ".$_GET['msgType']."</b></span><br>
		<span>-----</span><br>
		<span>Phasellus ultrices mi ac vestibulum sollicitudin. Donec eu luctus ligula. Morbi sagittis lacus vel nibh dictum ultricies id vitae diam. Fusce cursus, nisi a congue egestas, purus sem faucibus arcu, non tincidunt felis arcu in arcu. </span><br>
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
	<div class="space10">
		<table id="item-list-table" class="table table-responsive">
			<tbody>
				<tr style="background-color: #f1f1f1">
					<td class="text-left"><h4><b>Тип сообщения :</b></h4></td>
					<td class="text-right"><h4><?php echo $_GET['msgType']; ?></h4></td>
				</tr>
				<tr style="background-color: #f1f1f1">
					<td class="text-left"><h4><b>Получатель сообщения :</b></h4></td>
					<td class="text-right"><h4><?php echo $_GET['msgRecipient']; ?></h4></td>
				</tr>
				<tr>
					<td colspan="2">
						<div style="color: #000; background-color: #fafafa; font-size: 1.0em; border: 2px #111 solid; margin: 20px 0 5px; padding: 30px">
							<?php echo $message3; ?>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<form action="" class="form-inline" method="POST" enctype="multipart/form-data">
		<div class="form-group">
	    	<button type="submit" name="sendMsgType0" class="btn btn-lg btn-info">Отправить</button>
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
#  $mail3->SMTPDebug = 0;
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
if ( isset($_POST['sendMsgType0']) ) {
#
#
#
# ПОЛУЧАТЕЛИ
# $mail3->addReplyTo('email', 'name')
# Email is an recipient address, Name is optional
#
// 	$email_to = 'office-all@atgs.ru';
//   $mail3->addAddress($email_to, 'ATGS Office');

// 	$email_to = 'chugunov@atgs.ru';
	$email_to = '';
 	$mail3->addAddress('chugunov@atgs.ru');
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
        echo "Не могу открыть файл ($filename)";
        exit;
				return -1;
      }

      if (!$mail3->send()) {
        $text = date('Y-m-d h:i:s')." : ошибка рассылки на ( $email_to ) : ".$mail1->ErrorInfo.PHP_EOL;
      // Записываем $somecontent в наш открытый файл.
        if (fwrite($handle, $text) === FALSE) {
          echo "Не могу произвести запись в файл ($filename)";
          exit;
        }
        echo "Ура! Записали ($text) в файл ($filename)";
        fclose($handle);
				return 1;
      }
      else {
        $text = date('Y-m-d h:i:s')." : сообщение на ( $email_to ) успешно отправлено".PHP_EOL;
      // Записываем $somecontent в наш открытый файл.
        if (fwrite($handle, $text) === FALSE) {
          echo "Не могу произвести запись в файл ($filename)";
          exit;
        }
        echo "Ура! Записали ($text) в файл ($filename)";
        fclose($handle);
				return 0;
      }
    }
    else {
      echo "Файл $filename недоступен для записи";
			return -2;
    }
#
#
	unset($_POST['mailing']);
#
#
}
?>

