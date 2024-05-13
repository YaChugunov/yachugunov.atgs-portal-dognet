<?php
date_default_timezone_set('Europe/Moscow');

# Import PHPMailer classes into the global namespace
# These must be at the top of your script, not inside a function
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;
# Подключаем библиотеки
// require $_SERVER['DOCUMENT_ROOT']."/dognet/_assets/_PHPMailer/src/Exception.php";
// require $_SERVER['DOCUMENT_ROOT']."/dognet/_assets/_PHPMailer/src/PHPMailer.php";
// require $_SERVER['DOCUMENT_ROOT']."/dognet/_assets/_PHPMailer/src/SMTP.php";

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
#
# Включаем режим сессии
session_start();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
/*
function my_mail_function($db){


#
# Instantiation and passing `true` enables exceptions
$mail3 = new PHPMailer;
#
$message3 = "";
#
	$subjectTxt = "АТГС.Договор / Заявки";
	$subject = "=?utf-8?B?".base64_encode($subjectTxt)."?=";
#
# Текст сообщения (верхняя часть)
	$message3 = "<html>";
	$message3 .= "<head></head>";
	$message3 .= "<body>";
	$message3 .= "<div style=\"\" >";
#
	$message3 .= "
		<h3>И снова здравствуйте!</h3>
		<div style=\"margin-top: 10px;\">
		<span>Если вы видите это сообщение значит тестирование email-уведомлений сервиса ДОГОВОР проходит успешно.</span><br><br>
		<span>-----</span><br>
		<span><b>Верим в лучшее. Лето близко. :)</b></span><br><br>
		</div>
		";
#
# Текст сообщения (нижняя часть)
	$message3 .= "<div style=\"margin-top: 10px; display: block; text-align: left; padding: 15px 0; border-top: 1px #ccc solid;\">";
	$message3 .= "<span style=\"display: block\"><img src=\"http://192.168.1.89/dognet/_assets/images/dognet-logo-2-32x32.png\" height=\"32px\" /></span><br>";
	$message3 .= "<span><b>Корпоративный сервис АТГС.Договор</b></span><br>";
	$message3 .= "<span style=\"\"><i>-----</i></span><br>";
	$message3 .= "<span style=\"\"><i>* Это сообщение отправлено роботом. Не используйте адрес отправителя этого письма для обратной связи.</i></span>";
	$message3 .= "</div>";
	$message3 .= "</div>";
	$message3 .= "</body>";
	$message3 .= "</html>";
# ----- ----- ----- ----- -----
# SERVER SETTINGS
#
// Enable verbose debug output
  $mail3->SMTPDebug = SMTP::DEBUG_SERVER;
// Disable verbose debug output
  $mail3->SMTPDebug = 2;
// Send using SMTP
	$mail3->isSmtp();
// Set the SMTP server to send through
  $mail3->Host = 'mail.atgs.ru';
// Enable SMTP authentication
  $mail3->SMTPAuth = true;
// SMTP connection will not close after each email sent, reduces SMTP overhead
  $mail3->SMTPKeepAlive = false;
// SMTP username
  $mail3->Username = 'portal@atgs.ru';
// SMTP password
  $mail3->Password = 'iu3Li,quohch';
// Enable TLS encryption, `PHPMailer::ENCRYPTION_SMTPS` also accepted
  $mail3->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
// TCP port
  $mail3->Port = 587;
# ----- ----- ----- ----- -----
  $mail3->setLanguage('ru', $_SERVER['DOCUMENT_ROOT']."/dognet/_assets/_PHPMailer/language/");
  $mail3->CharSet = "utf-8";
#
# From
	$from_name = "АТГС.Договор (сервис контроля и управления договорными отношениями)";
	$from_email = "portal@atgs.ru";
	$from_name = "=?utf-8?B?".base64_encode($from_name)."?=";
	$mail3->setFrom($from_email, $from_name);
# ----- ----- ----- ----- -----
 	$mail3->addAddress('chugunov@atgs.ru');
 	$email_to = 'chugunov@atgs.ru';
# ----- ----- ----- ----- -----
	$mail3->addReplyTo('notreply@atgs.ru', 'Do not reply');
  $mail3->isHTML(true);                                  // Set email format to HTML
  $mail3->Subject = $subject;
  $mail3->Body    = $message3;
  $mail3->AltBody = 'Ваш почтовый клиент не принимает сообщений в формате HTML. Вариант рассылки в формате PLAIN TEXT будет реализован позже.';
# ----- ----- ----- ----- -----
#
# ::: Send the message, check for errors
#
# ----- ----- ----- ----- -----
# Открыли файл для записи данных в конец файла
  $filename = $_SERVER['DOCUMENT_ROOT']."/dognet/PHPMailer_errors.log";
  if (is_writable($filename)) {
    if (!$handle = fopen($filename, 'a')) {
      echo "Не могу открыть файл ($filename)";
      exit;
    }
    if (!$mail3->send()) {
      $text = date('Y-m-d h:i:s')." : ошибка рассылки на ( $email_to ) : ".$mail3->ErrorInfo.PHP_EOL;
    // Записываем $somecontent в наш открытый файл.
      if (fwrite($handle, $text) === FALSE) {
        echo "Не могу произвести запись в файл ($filename)";
        exit;
      }
      echo "Ура! Записали ($text) в файл ($filename)";
      fclose($handle);
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
    }
  }
  else {
    echo "Файл $filename недоступен для записи";
  }
// 	$mail3->getSMTPInstance()->reset();
// 	$mail3->clearAddresses();
// 	$mail3->clearAttachments();
# ----- ----- ----- ----- -----
	$mail3->smtpClose();

return false;

}
*/
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция определения нового ID заявки ( kodzayv)
# для таблицы заявок 'dognet_doczayv'
# ----- ----- -----
function nextKodzayv() {
	$query = mysqlQuery("SELECT MAX(kodzayv) as lastKod FROM dognet_doczayv ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastKod = $row['lastKod'];
	$nextKod = $lastKod + rand(3, 13);
	return $nextKod;
}
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция определения нового номера заявки (numberzayv)
# для таблицы этапов 'dognet_docbase'
# ----- ----- -----
function nextNumberzayv($tip, $year) {
	$query = mysqlQuery("SELECT MAX(numberzayv) as lastNumber FROM dognet_doczayv WHERE kodtipzayvall=".$tip." AND YEAR(datezayv)=".$year." ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastNumber = $row['lastNumber'];
	$nextNumber = $lastNumber + 1;
	return $nextNumber;
}
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция определения нового ID договора ( koddoc)
# для таблицы этапов 'dognet_docbase'
# ----- ----- -----
function nextKodzayvdopspec() {
	$query = mysqlQuery("SELECT MAX(kodzayvdopspec) as lastKod FROM dognet_doczayvdopspec ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastKod = $row['lastKod'];
	$nextKod = $lastKod + rand(3, 13);
	return $nextKod;
}
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция определения нового ID договора ( koddoc)
# для таблицы этапов 'dognet_docbase'
# ----- ----- -----
function nextNumberdopspec($kodzayv) {
	$query = mysqlQuery("SELECT MAX(numberdopspec) as lastNumber FROM dognet_doczayvdopspec WHERE kodzayv=".$kodzayv." ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastNumber = $row['lastNumber'];
	$nextNumber = $lastNumber + 1;
	return $nextNumber;
}
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# :::
# ::: О Б Р А Б О Т Ч И К   З А Г Р У З К И   Ф А Й Л А
# :::
#
if ( $_SERVER["REQUEST_METHOD"] == "POST" ) {
#
	$__CURRENT_YEAR = date('Y');
	$tmpfolder = $__CURRENT_YEAR;
#
# ----- --- ----- --- ----- ---
# !!! ОЧЕНЬ ВАЖНЫЕ СТРОКИ !!!
# ----- --- ----- --- ----- ---
#
# Постоянная часть пути
// 	$Const_Part_Of_PATH = "/STORAGEDOC/ZAYVCTZ/CTZ".$__CURRENT_YEAR."/";
	$Const_Part_Of_PATH = "/STORAGEDOC/DOCZAYV/DOCZAYV".$__CURRENT_YEAR."/";
#
#
# Имя столбца в таблице файлов: file_truelocation
# Путь, где распологается оригинальный файл
	$_QRY_GetStorageFolder = mysqlQuery("SELECT storagefolder_name FROM dognet_settings_storagefolders WHERE storagefolder_use = '1'");

	$_ROW_GetStorageFolder = mysqli_fetch_assoc($_QRY_GetStorageFolder);
	if ($_QRY_GetStorageFolder) { $StorageName = $_ROW_GetStorageFolder['storagefolder_name']; }

	$d = dir($StorageName.$Const_Part_Of_PATH);
	$__DOCPATH = $d->path;
#
#
# Имя столбца в таблице файлов: file_webpath
# Формируем часть URL (без http://, имени хоста и сервиса) симлинка на оригинальный файл
// 	$__WEBPATH = "/dognet".$Const_Part_Of_PATH;
	$__WEBPATH = "".$Const_Part_Of_PATH;
#
#
# Имя столбца в таблице файлов: file_syspath
# Серверный путь (PATH) к симлинку на оригинальный файл
	$__SYSPATH = $_SERVER['DOCUMENT_ROOT']."/dognet".$Const_Part_Of_PATH;
#
# ----- --- ----- --- ----- ---
#
	$varFileArray = [
		'year' => $__CURRENT_YEAR,
		'docpath' => $__DOCPATH,
		'webpath' => $__WEBPATH,
		'syspath' => $__SYSPATH
	];
#
}
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция обновления полей основной таблицы (dognet_doczayv)
#
function updateFields_doczayv ( $db, $action_doczayv, $id, $values, $varFileArray ) {
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# :::
# ::: Если была нажата кнопка "НОВАЯ ЗАЯВКА"
# :::
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	if ( $action_doczayv == 'CRT' ) {
#
#
		$_QRY = $db->sql( "SELECT * FROM dognet_doczayv WHERE id=".$id )->fetchAll();
		$__tip = $_QRY[0]['kodtipzayvall'];
		$__name = $_QRY[0]['namerabfilespec'];

	// Формируем новый идентификатор завки (kodzayv)
		$__nextKodzayv = nextKodzayv();
		$__nextNumberzayv = nextNumberzayv($__tip, date('Y'));

		$db->update( 'dognet_doczayv', array(
			'kodzayv'			=>	$__nextKodzayv,
			'numberzayv'		=>	$__nextNumberzayv,
			'docFileID' => ""
		), array( 'id' => $id ));

		if (empty($__name)) {
			$db->update( 'dognet_doczayv', array(
				'namerabfilespec'		=>	"Заявка"
			), array( 'id' => $id ));
		}

		if ($_QRY[0]['kodrabfile']==1) {
			$__nextKodzayvdopspec = nextKodzayvdopspec();
			$__date = date("Y-m-d");
			$_QRY_1 = $db->sql( "INSERT INTO dognet_doczayvdopspec (koddel, kodzayv, kodzayvdopspec, kodmainspec, datedopspec, numberdopspec, namedopspec, docFileID, dopFileID) VALUES ('', {$__nextKodzayv}, {$__nextKodzayvdopspec}, '1', {$__date}, '1', 'Основной файл, прикрепленный к заявке', '', '')");
		}


#
#
	}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# :::
# ::: Если была нажата кнопка "ИЗМЕНИТЬ"
# :::
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	if ( $action_doczayv == 'UPD' ) {
#
#
	// В papermemo храним номер договора, чтобы не создавать новое специальное поле
		$_QRY_1 = $db->sql( "SELECT namerabfilespec, koddoc, kodzayv, docFileID FROM dognet_doczayv WHERE id=".$id )->fetchAll();
	//
		if ($_QRY_1) {
			$_kodzayv = $_QRY_1[0]['kodzayv'];
			$_namerabfilespec = $_QRY_1[0]['namerabfilespec'];
			$_koddoc = $_QRY_1[0]['koddoc'];
			$_docFileID = $_QRY_1[0]['docFileID'];
			//
			$_QRY_docRowID = $db->sql( "SELECT id FROM dognet_docbase WHERE koddoc=".$_koddoc )->fetchAll();
			$__docRowID = $_QRY_docRowID[0]['id'];
			//
			$db->update( 'dognet_doczayv_files', array(
				'kodzayv' => $_kodzayv,
				'koddoc' => $_koddoc,
				'doc_rowid' => $__docRowID,
				'zayv_rowid' => $id,
			), array(
				'id' => $_docFileID
			));
			//
			$_QRY_specRowID = $db->sql( "SELECT id FROM dognet_doczayvdopspec WHERE kodzayv=".$_kodzayv." AND kodmainspec='1'" )->fetchAll();
			if ($_QRY_specRowID) {
				//
				$db->update( 'dognet_doczayvdopspec', array(
					'docFileID' => ""

// При 'docFileID' => $_docFileID вставляется пустое значение вместо $_docFileID
// Временное решение. Думаю пока...

				), array(
					'kodzayv' => $_kodzayv, 'kodmainspec' => 1
				));
				$_dopSpecID = $_QRY_specRowID[0]['id'];
				$db->update( 'dognet_doczayv', array(
					'dopSpecID' => $_dopSpecID
				), array(
					'id' => $id
				));
			}
			else {
				$_QRY = $db->sql( "SELECT * FROM dognet_doczayv WHERE id=".$id )->fetchAll();
				if ($_QRY[0]['kodrabfile']==1) {
					$__nextKodzayvdopspec = nextKodzayvdopspec();
					$__date = date("Y-m-d");
					$__docFileID = $_docFileID ? $_docFileID : "";

					$_QRY_1 = $db->sql( "INSERT INTO dognet_doczayvdopspec (koddel, kodzayv, kodzayvdopspec, kodmainspec, datedopspec, numberdopspec, namedopspec, docFileID, dopFileID) VALUES ('', '{$_kodzayv}', '{$__nextKodzayvdopspec}', '1', '{$__date}', '1', 'Основной файл, прикрепленный к заявке', '', '')" );

// При INSERT в поле docFileID вставляется пустое значение вместо $_docFileID
// Временное решение. Думаю пока...

					$_QRY_2 = $db->sql( "SELECT id FROM dognet_doczayvdopspec WHERE kodzayv=".$_kodzayv." AND kodmainspec='1'" )->fetchAll();
					$_dopSpecID = $_QRY_2[0]['id'];

					$db->update( 'dognet_doczayv', array(
						'dopSpecID' => $_dopSpecID
					), array(
						'id' => $id
					));
				}
			}
#
#
			if ($_docFileID != "") {

			// Переименовываем файл
				$_QRY_paperfiles = $db->sql( "SELECT flag, file_truelocation, file_syspath, zayv_filetype, file_extension FROM dognet_doczayv_files WHERE id=".$_docFileID )->fetchAll();
				if ($_QRY_paperfiles[0]['flag'] == "0") {
					$__ext = $_QRY_paperfiles[0]['file_extension'];
					$__newFileName = "NEW-DOCZAYV{$_kodzayv}";
				// Формируем новый симлинк
					$md5 = md5(uniqid());
					$__newFileSymName = "{$md5}.{$__ext}";
				// Переименовываем реальный файл
					rename($_QRY_paperfiles[0]['file_truelocation'], $varFileArray['docpath']."{$__newFileName}.{$__ext}");
				// Удаляем старый симлинк
					unlink($_QRY_paperfiles[0]['file_syspath']);
				// Формируем новый симлинк
					symlink( $varFileArray['docpath']."{$__newFileName}.{$__ext}", $varFileArray['syspath']."{$__newFileSymName}.{$__ext}" );
				// Формируем новый URL
					$__NewURL = str_replace($_SERVER['DOCUMENT_ROOT'], 'http://'.$_SERVER['HTTP_HOST'], $varFileArray['syspath']."{$__newFileName}.{$__ext}");
				// Обновляем запись в таблице файлов
					$db->update( 'dognet_doczayv_files', array(
						"file_name" => $__newFileName,
						"file_symname" => $__newFileName,
						"file_truelocation" => $varFileArray['docpath']."{$__newFileName}.{$__ext}",
						"file_syspath" => $varFileArray['syspath']."{$__newFileSymName}.{$__ext}", // Симлинк пока не используем!
						"file_webpath" => $varFileArray['webpath']."{$__newFileSymName}.{$__ext}", // Симлинк пока не используем!
						"file_url" => $__NewURL,
						"flag" => "1"
					), array(
						"id" => $_docFileID
					));
				}
			}
		}
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
/*
		if ( json_encode($values['sendMessage'], JSON_NUMERIC_CHECK) == '[1]' ) {
			my_mail_function();
		}
*/
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
	}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# :::
# ::: Если была нажата кнопка "УДАЛИТЬ"
# :::
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	if ( $action_doczayv == 'DEL' ) {
#
#
#
#
	}
#
#
}
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция удаления файлов и записи в таблице файлов счетов-фактур (dognet_doczayvchetf)
#
function delAttachment ( $db, $id ) {
#
#
	$__rowFileID = $db->sql( "SELECT docFileID FROM dognet_doczayv WHERE id=".$id )->fetchAll();
	$row2delete = $__rowFileID[0]['docFileID'];
	if ($row2delete!="") {
	// Удаление оригинального файла ($__tmp2) и сим-ссылки ($__tmp1) с диска
		$__file = $db->sql( "SELECT file_truelocation, file_syspath FROM dognet_doczayv_files WHERE id=".$row2delete )->fetchAll();
		$__tmp1 = unlink($__file[0]['file_syspath']);
		$__tmp2 = unlink($__file[0]['file_truelocation']);
		// Удаление записи в таблице файлов
		if ( $__tmp1 && $__tmp2 ) {
			$query = $db->sql( "DELETE FROM dognet_doczayv_files WHERE id=".$row2delete );
		}
	}
#
#
}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
#
#
/*
 * Example PHP implementation used for the index.html example
*/
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


// Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'dognet_doczayv' )
	->fields(
		Field::inst( 'dognet_docbase.koddel' ),
		Field::inst( 'dognet_doczayv.kodzayv' ),
// ----- ----- -----
		Field::inst( 'dognet_doczayv.koddoc' )
			->options( Options::inst()
				->table( 'dognet_docbase' )
				->value( 'koddoc' )
				->label( array('koddoc', 'yearnachdoc', 'docnumber', 'docnameshot') )
				->render( function ( $row ) {
					return ($row['yearnachdoc']." : "."3-4/".$row['docnumber']." : ".$row['docnameshot']);
					})
				->where(function ($q) {
					$q->where('koddel', '99', '!=');
					})
			),
		Field::inst( 'dognet_doczayv.kodispol' ),
// ----- ----- -----
		Field::inst( 'dognet_doczayv.kodzayvtel' )
			->options( Options::inst()
				->table( 'dognet_spzayvtel' )
				->value( 'kodzayvtel' )
				->label( array('kodzayvtel', 'namezayvtelshot') )
				->render( function ( $row ) {
					return ($row['namezayvtelshot']);
					})
				->where(function ($q) {
					$q->where('koddel', '99', '!=');
					$q->where('kodzayvtel', '0000000000000000', '!=');
					})
			)
			->validator( Validate::notEmpty( ValidateOptions::inst()
				->message( 'Заявитель обязателен' )
			) ),
// ----- ----- -----
		Field::inst( 'dognet_doczayv.kodrabzayv' ),
		Field::inst( 'dognet_doczayv.numberzayv' ),
// ----- ----- -----
		Field::inst( 'dognet_doczayv.datezayv' )
		        ->validator( Validate::dateFormat(
		            'd.m.Y',
		            ValidateOptions::inst()
		                ->allowEmpty( true ) ) )
		        ->getFormatter( Format::datetime(
		            'Y-m-d',
		            'd.m.Y'
		        ) )
		        ->setFormatter( Format::datetime(
		            'd.m.Y',
		            'Y-m-d'
				) ),
		Field::inst( 'dognet_doczayv.namedoc' ),
		Field::inst( 'dognet_doczayv.kodrabfile' ),
		Field::inst( 'dognet_doczayv.namerabfilespec' ),
		Field::inst( 'dognet_doczayv.rabfileexp' ),
		Field::inst( 'dognet_doczayv.tipusezayv' ),
// ----- ----- -----
		Field::inst( 'dognet_doczayv.kodtipzayv' ),
// ----- ----- -----
		Field::inst( 'dognet_doczayv.kodusecht' ),
		Field::inst( 'dognet_doczayv.rabzayvdoc' ),
		Field::inst( 'dognet_doczayv.zayvchetcom' ),
// ----- ----- -----
		Field::inst( 'dognet_doczayv.kodtipzayvall' )
			->options( Options::inst()
				->table( 'dognet_sptipzayvall' )
				->value( 'kodtipzayvall' )
				->label( array('kodtipzayvall', 'nametipzayvshotall') )
				->render( function ( $row ) {
					return ($row['nametipzayvshotall']);
					})
				->where(function ($q) {
					$q->where('koddel', '99', '!=');
					})
			)
			->validator( Validate::notEmpty( ValidateOptions::inst()
				->message( 'Тип обязателен' )
			) ),
// ----- ----- -----
		Field::inst( 'dognet_doczayv.koduseobjwork' ),
		Field::inst( 'dognet_doczayv.kodusepoligon' ),
		Field::inst( 'dognet_doczayv.zayvchetcomall' ),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst( 'dognet_doczayv.docFileID' )
        ->setFormatter( Format::ifEmpty( null ) )
        ->upload(
        	Upload::inst( function ( $file, $id ) use ( $varFileArray, $db ) {
						$__pref = date('Y').$_SESSION['id'].date('mdHis');
// 					$__name = $__pref."-".$file['name'];
						$__name = $file['name'];
						$__nameTmp = $file['tmp_name'];
						$__ext = explode('.', $__name);
						$__ext = strtolower(end($__ext));
						$md5 = md5(uniqid());
						$__nameMD5 = "{$md5}.{$__ext}";
						$__name2save = "TMPNAME.{$__pref}";

//
						$__url = str_replace($_SERVER['DOCUMENT_ROOT'], 'http://'.$_SERVER['HTTP_HOST'], $varFileArray['syspath'].$__nameMD5);
//
						move_uploaded_file($__nameTmp, $varFileArray['docpath']."{$__name2save}");
						symlink( $varFileArray['docpath']."{$__name2save}", $varFileArray['syspath'].$__nameMD5 );

//
// Database table to update
            $db->update( 'dognet_doczayv_files', [
							'flag' => '0',
// ---
							'file_year' => $varFileArray['year'],
							'file_id' => $id,
							'file_name' => $__name2save,
							'file_originalname' => $__name,
							'file_symname' => $__nameMD5,
							'file_truelocation' => $varFileArray['docpath']."{$__name2save}",
// ---
							'file_syspath' => $varFileArray['syspath'].$__nameMD5,
							'file_webpath' => $varFileArray['webpath'].$__nameMD5,
							'file_url' => $__url
							], [ 'id' => $id ]
	          );
            return $id;
        	})
        ->db( 'dognet_doczayv_files', 'id', array(
					'zayv_filetype' => Upload::DB_EXTN,
					'file_extension' => Upload::DB_EXTN,
					'file_size' => Upload::DB_FILE_SIZE,
					'file_webpath' => '',
					'file_truelocation' => ''
					)
				)
        ->validator( Validate::fileSize( 50000000, 'Размер документа не должен превышать 50МБ' ) )
        ->validator( Validate::fileExtensions( array( 'png', 'jpg', 'pdf', 'doc', 'docx', 'xls', 'xlsx' ), "Загрузите документ" ) )
		),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst( 'dognet_docbase.koddoc' ),
		Field::inst( 'dognet_docbase.docnumber' ),
		Field::inst( 'dognet_docbase.docnameshot' ),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    Field::inst( 'dognet_spzayvtel.kodzayvtel' ),
    Field::inst( 'dognet_spzayvtel.namezayvtel' ),
    Field::inst( 'dognet_spzayvtel.namezayvtelshot' ),
    Field::inst( 'dognet_spzayvtel.doljzayvtel' ),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    Field::inst( 'dognet_sptipzayv.kodtipzayv' ),
    Field::inst( 'dognet_sptipzayv.namezayvshot' ),
    Field::inst( 'dognet_sptipzayv.namezayvfull' ),
    Field::inst( 'dognet_sptipzayv.shifrzayv' ),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    Field::inst( 'dognet_sptipzayvall.kodtipzayvall' ),
    Field::inst( 'dognet_sptipzayvall.nametipzayvshotall' ),
    Field::inst( 'dognet_sptipzayvall.nametipzayvfullall' ),
    Field::inst( 'dognet_sptipzayvall.usesimple' ),
    Field::inst( 'dognet_sptipzayvall.usespec' ),
    Field::inst( 'dognet_sptipzayvall.koddoclim' ),
    Field::inst( 'dognet_sptipzayvall.kodshab' )
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
	)
#
#
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->on( 'preGet', function ( $editor_doczayv, $id ) use ($varFileArray) {
		$editor_doczayv->where( function ( $q ) {
		    $q->where( 'dognet_doczayv.koddel', '99', '!=' );
		} );
	} )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->on( 'postCreate', function ( $editor_doczayv, $id, $values, $row ) use ($varFileArray) {
		updateFields_doczayv( $editor_doczayv->db(), 'CRT', $id, $values, $varFileArray );
	} )
	->on( 'preEdit', function ( $editor_doczayv, $id, $values ) {

	} )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->on( 'postEdit', function ( $editor_doczayv, $id, $values, $row ) use ($varFileArray) {
		updateFields_doczayv( $editor_doczayv->db(), 'UPD', $id, $values, $varFileArray );
/*
		if ( json_encode($values['sendMessage'], JSON_NUMERIC_CHECK) == '[1]' ) {
			my_mail_function();
		}
*/
	} )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->on( 'preRemove', function ( $editor_doczayv, $id, $values ) use ($varFileArray) {
		delAttachment( $editor_doczayv->db(), $id );
		updateFields_doczayv( $editor_doczayv->db(), 'DEL', $id, $values, $varFileArray );
	} )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->on( 'postUpload', function ( $editor_doczayv, $id, $files, $data ) use ($varFileArray) {

	} )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->leftJoin( 'dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_doczayv.koddoc' )
	->leftJoin( 'dognet_spzayvtel', 'dognet_spzayvtel.kodzayvtel', '=', 'dognet_doczayv.kodzayvtel' )
	->leftJoin( 'dognet_spispol', 'dognet_spispol.kodispol', '=', 'dognet_doczayv.kodispol' )
	->leftJoin( 'dognet_sptipzayv', 'dognet_sptipzayv.kodtipzayv', '=', 'dognet_doczayv.kodtipzayv' )
	->leftJoin( 'dognet_sptipzayvall', 'dognet_sptipzayvall.kodtipzayvall', '=', 'dognet_doczayv.kodtipzayvall' )
	->process( $_POST )
	->json();

