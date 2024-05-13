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

</style>


<div class="container">
	<div class="space50"></div>
<?php
if (empty($_GET['done']) || !isset($_GET['done']) || $_GET['done']!="ok") {

$_QRY = mysqlQuery( "SELECT * FROM dognet_docbase WHERE koddoc = '".$_GET['uniqueID1']."'" );
$_ROW = mysqli_fetch_assoc($_QRY);

?>
	<div class="row space20">
		<div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 space20">
				<div id="report-settings" class="text-center">
					<h3 class="space10">Закрывающий акт по договору/этапу договора</h3>
					<h4 class="space10">Сконфигурируйте документ</h4>
				</div>
			</div>
			<div class="col-xs-hidden col-sm-12 col-md-12 col-lg-12">
				<div id="export-format-block" class="center-block" style="">
					<form class="form-horizontal" method="GET" action="/dognet/dognet-actview.php">
						<input type="hidden" name="actview_type" value="list">
						<input type="hidden" name="export" value="yes">
						<input type="hidden" name="uniqueID1" value="<?php echo (isset($_GET['uniqueID1'])&&!empty($_GET['uniqueID1'])) ? $_GET['uniqueID1'] : ""; ?>">
						<div class="col-xs-hidden col-sm-12 col-md-12 col-lg-12">
							<div class="form-group text-left">
							  <label for="sel1"><h4>Выберите этап договора</h4></label>
							  <select class="form-control" id="stage" name="uniqueID2">
								<?php
									if (($_ROW['kodshab']==1)OR($_ROW['kodshab']==3)) {
										$_QRY0 = mysqlQuery( "SELECT kodkalplan, numberstage, nameshotstage, summastage FROM dognet_dockalplan WHERE koddoc = '".$_GET['uniqueID1']."'" );
								?>
										<option value="">---</option>
										<?php
										while($_ROW0 = mysqli_fetch_assoc($_QRY0)){
										?>
												<option value = '<?php echo $_ROW0["kodkalplan"]; ?>'><?php echo 'Этап '.$_ROW0["numberstage"].'. '.$_ROW0["nameshotstage"]; ?></option>
									<?php
										}
									}
									else {
									?>
										<option value="">Без этапа</option>
									<?php
									}
									?>
							  </select>
							</div>
						</div>
						<div class="col-xs-hidden col-sm-12 col-md-12 col-lg-12 space30">
							<div class="text-left">
								<div class="form-group">
									<h4>Определите сумму акта</h4>
									<div class="radio" style="margin-bottom:20px">
										<label class="control-label col-sm-8" for="email" style="text-align:left"><input type="radio" name="sum_type" value="1">Сумма введенная пользователем</label>
								    <div class="col-sm-4">
								      <input type="text" class="form-control" id="sum-user-value" name="sum_val" placeholder="Сумма акта" disabled="true">
								    </div>
									</div>
									<div class="radio" style="margin-bottom:13px">
										<label><input type="radio" name="sum_type" value="2" checked>Сумма этапа календарного плана (по договору)</label>
									</div>
									<div class="radio">
										<label><input type="radio" name="sum_type" value="3">Сумма незакрытия этапа (сумма этапа минус сумма счетов-фактур)</label>
									</div>

								</div>
							</div>
						</div>
						<div class="col-xs-hidden col-sm-6 col-md-6 col-lg-6">
							<div class="form-group text-left">
							  <label for="sel1">В шапке акта слева (АТГС):</label>
							  <select class="form-control" id="sel1" name="org1">
								<option value="">---</option>
								<?php
									$_QRY1 = mysqlQuery( "SELECT kodshabact, nameshabact_i FROM dognet_shablactdoc WHERE koduseact = '1'" );
									while($_ROW1 = mysqli_fetch_assoc($_QRY1)){
									?>
											<option value = '<?php echo $_ROW1["kodshabact"]; ?>'><?php echo $_ROW1["nameshabact_i"]; ?></option>
								<?php
									}
									?>
							  </select>
							</div>
						</div>
						<div class="col-xs-hidden col-sm-6 col-md-6 col-lg-6">
							<div class="form-group text-left">
							  <label for="sel2">В шапке акта справа (контрагент):</label>
							  <select class="form-control" id="sel2" name="org2">
								<option value="">---</option>
								<?php
									$_QRY2 = mysqlQuery( "SELECT kodshabact, nameshabact_i FROM dognet_shablactdoc WHERE koduseact = '2'" );
									while($_ROW2 = mysqli_fetch_assoc($_QRY2)){
									?>
											<option value = '<?php echo $_ROW2["kodshabact"]; ?>'><?php echo $_ROW2["nameshabact_i"]; ?></option>
								<?php
									}
									?>
							  </select>
							</div>
						</div>
						<div class="col-xs-hidden col-sm-12 col-md-12 col-lg-12 space30">
							<div class="checkbox text-left">
								<label><input type="checkbox" name="log" value="yes">Сделать запись в "Журнале актов"</label>
							</div>
						</div>
						<div class="col-xs-hidden col-sm-12 col-md-12 col-lg-12 space30">
							<label id="select-format-doc" class="radio-inline">
								<input type="radio" name="format" value="doc" checked>
									<span class="media"></span>
							</label>
<!--
							<label id="select-format-xls" class="radio-inline">
								<input type="radio" name="format" value="xls">
									<span class="media"></span>
							</label>
-->
<!--
							<label id="select-format-pdf" class="radio-inline">
								<input type="radio" name="format" value="pdf">
									<span class="media"></span>
							</label>
-->
						</div>
						<div>
							<button class="btn btn-default" type="submit" name="done" value="ok">Эскпортировать</button>
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
				if (isset($_GET['format'])) {
					switch ($_GET['format']) {
						case "doc":
							include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/actview/actview-current/restr_4/export/_docx/export2docx.php");
							break;
						case "xls":
							include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/actview/actview-current/restr_4/export/_xlsx/export2xlsx.php");
							break;
						case "pdf":
							include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/actview/actview-details/restr_4/export/_pdf/export2pdf.php");
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
								<span style="color:#111; margin:0 10px"><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/dognet-actview.php?actview_type=list">Акты</a></span>
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

</script>