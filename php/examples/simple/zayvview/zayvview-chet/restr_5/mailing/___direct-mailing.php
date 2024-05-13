<?php

date_default_timezone_set('Europe/Moscow');

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$__title = 'Договор';
$__subtitle = "Экспорт отчетных данных";
$__subsubtitle = "Экспорт отчетных данных";

?>

<style>
	#report-settings {  }
	#report-settings h3 { color:#111; font-family:'Play', sans-serif; font-size:1.5em; font-weight:700; text-transform:uppercase }
	#report-settings h4 { color:#999; font-family:'Oswald', sans-serif; font-size:1.3em; font-weight:300; text-transform:uppercase }
	#export-format-block a > img { opacity:0.5; height:100px; width:100px; margin:0 2px }
	#export-format-block { text-align:center }
	#export-format-block a > img:hover { opacity:1.0; transition:0.5s	}
	#export-format-block a > img:not(hover) { opacity:0.5; transition:0.5s	}

	.format-not-selected { font-family:'Oswald', sans-serif; font-size:1.0em; font-weight:300; text-transform:uppercase }
	.format-not-selected { color:#999 }


label#select-format-doc, label#select-format-xls, label#select-format-pdf {
 width: 50px; /* Ширина рисунка */
 height: 50px; /* Высота рисунка */
 position: relative; /* Относительное позиционирование */
}
label#select-format-doc input[type="radio"], label#select-format-xls input[type="radio"], label#select-format-pdf input[type="radio"] { top:30px }
label#select-format-doc input[type="radio"] + span {
 position: absolute; /* Абсолютное позиционирование */
 left:0px;
 width: 100%; height: 100%;
 background: url(<?php $_SERVER['HTTP_HOST']; ?>/dognet/_assets/images/export-to-doc-inactive.png) no-repeat; /* Фоновый рисунок */
 cursor: pointer; /* Курсор в виде руки */
 background-position: center center;
 background-size: cover;
/*  border-radius:10px; */
}
label#select-format-doc input[type="radio"]:checked + span {
 position: absolute; /* Абсолютное позиционирование */
 left:0px;
 width: 100%; height: 100%;
 background: url(<?php $_SERVER['HTTP_HOST']; ?>/dognet/_assets/images/export-to-doc.png) no-repeat; /* Фоновый рисунок */
 cursor: pointer; /* Курсор в виде руки */
 background-position: center center;
 background-size: cover;
 border:5px #33333 solid;
/*  border-radius:10px; */
}


label#select-format-xls input[type="radio"] + span {
 position: absolute; /* Абсолютное позиционирование */
 width: 100%; height: 100%;
 left:0px;
 background: url(<?php $_SERVER['HTTP_HOST']; ?>/dognet/_assets/images/export-to-xls-inactive.png) no-repeat; /* Фоновый рисунок */
 cursor: pointer; /* Курсор в виде руки */
 background-position: center center;
 background-size: cover;
/*  border-radius:10px; */
}
label#select-format-xls input[type="radio"]:checked + span {
 position: absolute; /* Абсолютное позиционирование */
 left:0px;
 width: 100%; height: 100%;
 background: url(<?php $_SERVER['HTTP_HOST']; ?>/dognet/_assets/images/export-to-xls.png) no-repeat; /* Фоновый рисунок */
 cursor: pointer; /* Курсор в виде руки */
 background-position: center center;
 background-size: cover;
 border:5px #33333 solid;
/*  border-radius:10px; */
}

label#select-format-pdf input[type="radio"] + span {
 position: absolute; /* Абсолютное позиционирование */
 left:0px;
 width: 100%; height: 100%;
 background: url(<?php $_SERVER['HTTP_HOST']; ?>/dognet/_assets/images/export-to-pdf-inactive.png) no-repeat; /* Фоновый рисунок */
 cursor: pointer; /* Курсор в виде руки */
 background-position: center center;
 background-size: cover;
/*  border-radius:10px; */
}
label#select-format-pdf input[type="radio"]:checked + span {
 position: absolute; /* Абсолютное позиционирование */
 left:0px;
 width: 100%; height: 100%;
 background: url(<?php $_SERVER['HTTP_HOST']; ?>/dognet/_assets/images/export-to-pdf.png) no-repeat; /* Фоновый рисунок */
 cursor: pointer; /* Курсор в виде руки */
 background-position: center center;
 background-size: cover;
 border:5px #33333 solid;
/*  border-radius:10px; */
}
#section-quicklink > div.media > div.media-body > div > h3 {
	color:#666;
	line-height: 1.3em;
	font-family:'Oswald', sans-serif;
	margin-bottom: 0.5em;
	font-size: 1.2em;
	font-weight: 400;
	letter-spacing: -0.05em;
	text-transform:uppercase;
}
#section-quicklink > div.media > div.media-body > div > h4 {
	color:#666;
	line-height: 1.2em;
	font-family:'Oswald', sans-serif;
	margin-bottom: 0.5em;
	font-size: 1.0em;
	font-weight: 300;
	letter-spacing: -0.05em;
}
#section-quicklink > div.media > div.media-body > div > p {
	color:#111;
	font-family:'Oswald', sans-serif;
	font-weight: 500;
}
#section-quicklink > div.media > div.media-body > div > p > span > a {
	text-decoration:underline;
}
#section-quicklink > div.media > div.media-body > div > p > span > a:hover {
	text-decoration:none;
}


.block-text {
	display: none;
	padding: 15px;
	border: 1px solid #ec4848;
}

#mail-preview-info > tbody > tr > td { color:#111; font-size:0.9em; font-family:'Play', sans-serif; font-weight:400; border-top:none; border-bottom:none; padding:2px 5px }
#mail-preview-info { margin-bottom:0 }
#mail-preview-body { margin-bottom:0 }

.msg-h3 { font-family:'Helioscond', sans-serif; font-size:1.5em; font-weight:300; letter-spacing:0.05em }
.msg-h4 { font-family:'Helioscond', sans-serif; font-size:1.1em; font-weight:300; letter-spacing:0.05em }
.msg-h4 > span { padding-left:15px; padding-right:15px }
.msg-maintext { font-family:'Play', sans-serif }
.display-none { display:none }
.display-block { display:block }
</style>


<div class="container">
	<div class="space50"></div>
<?php
if (empty($_GET['done']) || !isset($_GET['done']) || $_GET['done']!="ok") {
?>
	<div class="row space20">
		<div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 space20">
				<div id="report-settings" class="text-center">
					<h3 class="space10">Рассылка email-уведомлений</h3>
					<h4 class="space10">Обновление информации по счету</h4>
				</div>
			</div>
			<div class="col-xs-hidden col-sm-12 col-md-12 col-lg-12">
				<div id="export-format-block" class="center-block" style="">
					<form class="form-horizontal" method="GET" action="/dognet/dognet-zayvview.php">
						<input type="hidden" name="zayvview_type" value="chet">
						<input type="hidden" name="uniqueID" value="<?php echo isset($_GET['uniqueID']) ? $_GET['uniqueID'] : ''; ?>">
						<input type="hidden" name="mailing" value="yes">
						<div class="col-xs-hidden col-sm-12 col-md-12 col-lg-12">
							<div class="form-group text-left">
								<label for="msgSubject"><b>Тип сообщения :</b></label>
							  <select class="form-control" id="msgSubject" name="msgSubject">
										<option value="">---</option>
										<option value="0">Тестовое сообщение</option>
										<option value="1">Новый счет (поставщик выставил счет)</option>
										<option value="2">Перенос счета на другую заявку</option>
										<option value="3">Изменение задолженности по счету</option>
										<option value="4">Прочие изменения данных по счету</option>
							  </select>
							</div>
							<div class="form-group text-left">
								<label for="msgTo"><b>Получатель сообщения :</b></label>
							  <select class="form-control" id="msgTo" name="msgTo">
										<option value="">---</option>
										<option value="0">Тест (chugunov@atgs.ru)</option>
										<option value="1">Только Заявитель</option>
										<option value="2">Весь список Заявителей</option>
										<option value="3">Выбрать получателя</option>
							  </select>
							</div>
							<div class="space10"></div>
							<div id="zayvtel-list" class="form-group text-left" style="width:100%; display:none; text-align:left">
								<label for="msgToZayvtel"><b>Получатель сообщения :</b></label>
								<select name="recipient" id="msgToZayvtel" class="form-control">
									<option value="">---</option>
									<?php
										$_QRY3 = mysqlQuery( " SELECT kodzayvtel, namezayvtel, namezayvtelshot FROM dognet_spzayvtel WHERE namezayvtelshot<>'' AND koddel<>'99' AND kodzayvtel<>'0000000000000000' ORDER BY namezayvtelshot ASC" );
										while($_ROW3 = mysqli_fetch_assoc($_QRY3)){
										?>
												<option value = '<?php echo $_ROW3["kodzayvtel"]; ?>'><?php echo $_ROW3["namezayvtelshot"]; ?></option>
									<?php
										}
										?>
								</select>
							</div>
							<div class="space10"></div>
							<div class="">
								<button id="btn_msgPreview" class="btn btn-default" type="submit" name="done" value="ok">Предварительный просмотр</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<?php
}
?>
	<div class="row space50">
		<div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
			<div class="text-center">
<?php
				if (isset($_GET['msgTo'])) {
					switch ($_GET['msgTo']) {
						case "0":
							include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/zayvview/zayvview-chet/restr_5/mailing/directMsg/mailing_directMsg-to-Chugunov.php");
							break;
						case "1":
							include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/zayvview/zayvview-chet/restr_5/mailing/directMsg/mailing_directMsg-to-ZayvTel.php");
							break;
						case "2":
							include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/zayvview/zayvview-chet/restr_5/mailing/directMsg/mailing_directMsg-to-groupZayvTel.php");
							break;
						case "3":
							include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/zayvview/zayvview-chet/restr_5/mailing/directMsg/mailing_directMsg-to-selectedZayvTel.php");
							break;
						default:
							echo "<div class='format-not-selected'></div>";
					}
				}
				else {
				 echo "<div class='format-not-selected'></div>";
				}
?>
			</div>
		</div>
	</div>


	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
			<div id="section-quicklink">
				<div class="media">
					<div class="media-body text-center">
						<div style="background-color:#fafafa; padding:10px">
							<h4 class="text-uppercase">Вы можете перейти в следующие разделы</h4>
							<p>
								<span style="color:#111; margin:0 10px"><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>">Портал</a></span>
								<span style="color:#111; margin:0 10px"><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/dognet-docview.php?docview_type=current">Договора</a></span>
								<span style="color:#111; margin:0 10px"><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/dognet-zayvview.php?zayvview_type=current">Заявки</a></span>
							</p>
						</div>
					</div>
				</div>
			</div>
			<div class="space50"></div>
		</div>
	</div>


</div>


<script type="text/javascript">

	$('input[name="sum_type"]').click(function(){
		if ($(this).val() == "1") {
			$('input[id="sum-user-value"]').prop('disabled', false);
		}
		else {
			$('input[id="sum-user-value"]').prop('disabled', true);
		}
	});

	$('#btn_msgPreview').prop('disabled', true);
	$('#msgTo').change(function(){
		if ($('#msgTo').val() == "") {
			$('#zayvtel-list').css({'display':'none'});
			$('#btn_msgPreview').prop('disabled', true);
		}
		else {
			if ($('#msgTo').val() == "3") {
				$('#zayvtel-list').css({'display':'block'});
				$('#btn_msgPreview').prop('disabled', true);
				$('#msgToZayvtel').change(function(){
					console.log('msgToZayvtel: '+$('#msgToZayvtel').val());
					if ($('#msgToZayvtel').val() == "") {
						$('#btn_msgPreview').prop('disabled', true);
					}
					else {
						$('#btn_msgPreview').prop('disabled', false);
					}
				});
			}
			else {
				$('#zayvtel-list').css({'display':'none'});
				$('#btn_msgPreview').prop('disabled', false);
			}
		}
	});

</script>
