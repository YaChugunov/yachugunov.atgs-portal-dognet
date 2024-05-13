<?php

date_default_timezone_set('Europe/Moscow');

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$__title = 'Договор';
$__subtitle = "Экспорт отчетных данных";
$__subsubtitle = "Экспорт отчетных данных";

# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# КОД ДЛЯ ПЕРЕСЧЕТА ТЕКУЩЕГО ОСТАТКА ПО КАЖДОМУ АВАНСУ
#
/*
$_QRY_docavans = mysqlQuery( "SELECT * FROM dognet_docavans WHERE koddel<>'99'");
while ($_ROW_docavans = mysqli_fetch_assoc($_QRY_docavans)) {

	$_QRY_SUM_GET = mysqlQuery( "SELECT SUM(summaoplav) as sum FROM dognet_chfavans WHERE koddel<>'99' AND kodavans = '".$_ROW_docavans['kodavans']."'");
	$_ROW_SUM_GET = mysqli_fetch_assoc($_QRY_SUM_GET);
	$_OSTATOK = $_ROW_docavans['summaavans']-$_ROW_SUM_GET['sum'];

	$_QRY_SUM_SET = mysqlQuery( "UPDATE dognet_docavans SET ostatokavans = ".$_OSTATOK." WHERE kodavans = '".$_ROW_docavans['kodavans']."'");

}
*/
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
?>
<script type="text/javascript"
  src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/moment-with-locales.js"></script>
<link rel="stylesheet"
  href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/_bootstrap-css/bootstrap-datetimepicker.css" />
<script type="text/javascript"
  src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/_bootstrap-js/bootstrap-datetimepicker.js"></script>

<style>
#report-settings {}

#report-settings h3 {
  color: #111;
  font-family: 'Play', sans-serif;
  font-size: 1.5em;
  font-weight: 700;
  text-transform: uppercase
}

#report-settings h4 {
  color: #999;
  font-family: 'Oswald', sans-serif;
  font-size: 1.3em;
  font-weight: 300;
  text-transform: uppercase
}

#export-format-block a>img {
  opacity: 0.5;
  height: 100px;
  width: 100px;
  margin: 0 2px
}

#export-format-block {
  text-align: center
}

#export-format-block a>img:hover {
  opacity: 1.0;
  transition: 0.5s
}

#export-format-block a>img:not(hover) {
  opacity: 0.5;
  transition: 0.5s
}

.format-not-selected {
  font-family: 'Oswald', sans-serif;
  font-size: 1.0em;
  font-weight: 300;
  text-transform: uppercase
}

.format-not-selected {
  color: #999
}


label#select-format-doc,
label#select-format-xls,
label#select-format-pdf {
  width: 50px;
  /* Ширина рисунка */
  height: 50px;
  /* Высота рисунка */
  position: relative;
  /* Относительное позиционирование */
}

label#select-format-doc input[type="radio"],
label#select-format-xls input[type="radio"],
label#select-format-pdf input[type="radio"] {
  top: 30px
}

label#select-format-doc input[type="radio"]+span {
  position: absolute;
  /* Абсолютное позиционирование */
  left: 0px;
  width: 100%;
  height: 100%;
  background: url(<?php $_SERVER['HTTP_HOST']; ?>/dognet/_assets/images/export-to-doc-inactive.png) no-repeat;
  /* Фоновый рисунок */
  cursor: pointer;
  /* Курсор в виде руки */
  background-position: center center;
  background-size: cover;
  /*  border-radius:10px; */
}

label#select-format-doc input[type="radio"]:checked+span {
  position: absolute;
  /* Абсолютное позиционирование */
  left: 0px;
  width: 100%;
  height: 100%;
  background: url(<?php $_SERVER['HTTP_HOST']; ?>/dognet/_assets/images/export-to-doc.png) no-repeat;
  /* Фоновый рисунок */
  cursor: pointer;
  /* Курсор в виде руки */
  background-position: center center;
  background-size: cover;
  border: 5px #33333 solid;
  /*  border-radius:10px; */
}


label#select-format-xls input[type="radio"]+span {
  position: absolute;
  /* Абсолютное позиционирование */
  width: 100%;
  height: 100%;
  left: 0px;
  background: url(<?php $_SERVER['HTTP_HOST']; ?>/dognet/_assets/images/export-to-xls-inactive.png) no-repeat;
  /* Фоновый рисунок */
  cursor: pointer;
  /* Курсор в виде руки */
  background-position: center center;
  background-size: cover;
  /*  border-radius:10px; */
}

label#select-format-xls input[type="radio"]:checked+span {
  position: absolute;
  /* Абсолютное позиционирование */
  left: 0px;
  width: 100%;
  height: 100%;
  background: url(<?php $_SERVER['HTTP_HOST']; ?>/dognet/_assets/images/export-to-xls.png) no-repeat;
  /* Фоновый рисунок */
  cursor: pointer;
  /* Курсор в виде руки */
  background-position: center center;
  background-size: cover;
  border: 5px #33333 solid;
  /*  border-radius:10px; */
}

label#select-format-pdf input[type="radio"]+span {
  position: absolute;
  /* Абсолютное позиционирование */
  left: 0px;
  width: 100%;
  height: 100%;
  background: url(<?php $_SERVER['HTTP_HOST']; ?>/dognet/_assets/images/export-to-pdf-inactive.png) no-repeat;
  /* Фоновый рисунок */
  cursor: pointer;
  /* Курсор в виде руки */
  background-position: center center;
  background-size: cover;
  /*  border-radius:10px; */
}

label#select-format-pdf input[type="radio"]:checked+span {
  position: absolute;
  /* Абсолютное позиционирование */
  left: 0px;
  width: 100%;
  height: 100%;
  background: url(<?php $_SERVER['HTTP_HOST']; ?>/dognet/_assets/images/export-to-pdf.png) no-repeat;
  /* Фоновый рисунок */
  cursor: pointer;
  /* Курсор в виде руки */
  background-position: center center;
  background-size: cover;
  border: 5px #33333 solid;
  /*  border-radius:10px; */
}

#section-quicklink>div.media>div.media-body>div>h3 {
  color: #666;
  line-height: 1.3em;
  font-family: 'Oswald', sans-serif;
  margin-bottom: 0.5em;
  font-size: 1.3em;
  font-weight: 400;
  letter-spacing: -0.05em;
  text-transform: uppercase;
}

#section-quicklink>div.media>div.media-body>div>h4 {
  color: #666;
  line-height: 1.2em;
  font-family: 'Oswald', sans-serif;
  margin-bottom: 0.5em;
  font-size: 1.0em;
  font-weight: 300;
  letter-spacing: -0.05em;
}

#section-quicklink>div.media>div.media-body>div>p {
  color: #111;
  font-family: 'Oswald', sans-serif;
  font-weight: 500;
}

#section-quicklink>div.media>div.media-body>div>p>span>a {
  text-decoration: underline;
}

#section-quicklink>div.media>div.media-body>div>p>span>a:hover {
  text-decoration: none;
}
</style>


<div class="container">
  <div class="space50"></div>
  <?php
if (empty($_GET['done']) || !isset($_GET['done']) || $_GET['done']!="ok") {
?>
  <div class="row space20">
    <div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 space20">
        <div id="report-settings" class="text-center">
          <h3 class="space10">Справка о незакрытых авансах по всем договорам на текущую дату</h4>
        </div>
      </div>
      <div class="col-xs-hidden col-sm-12 col-md-12 col-lg-12">
        <div id="export-format-block" class="center-block" style="">
          <form class="form-inline" method="GET" action="/dognet/dognet-report.php">
            <input type="hidden" name="reportview" value="unoplav">
            <input type="hidden" name="export" value="yes">
            <div class="col-xs-hidden col-sm-12 col-md-12 col-lg-12">
              <div class="form-group">
                <div class='input-group date' id='on_date'>
                  <input type='text' name="on_date" id='input_on_date' class="form-control" disabled />
                  <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-xs-hidden col-sm-12 col-md-12 col-lg-12 space30">
              <label id="select-format-xls" class="radio-inline">
                <input type="radio" name="format" value="xls" checked>
                <span class="media"></span>
              </label>
            </div>
            <div>
              <button class="btn btn-default" type="submit" name="done" value="ok">Эскпортировать</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
  $(function() {
    $('#on_date').datetimepicker({
      locale: 'ru',
      format: 'DD.MM.YYYY'
    });
  });
  </script>
  <?php
}
?>
  <div class="row space50">
    <div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
      <div class="text-center">
        <?php
				if (isset($_GET['format'])) {
					switch ($_GET['format']) {
						case "xls":
							include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/report/report-details/restr_4/reports/spravka/unoplav/export/_xlsx/export2xlsx.php");
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
                <span style="color:#111; margin:0 10px"><a
                    href="http://<?php echo $_SERVER['HTTP_HOST']; ?>">Портал</a></span>
                <span style="color:#111; margin:0 10px"><a
                    href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/dognet-docview.php?docview_type=current">Договора</a></span>
                <span style="color:#111; margin:0 10px"><a
                    href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/dognet-report.php">Отчеты</a></span>
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
subtitle = '<?php echo $__subtitle; ?>';
subsubtitle = '<?php echo $__subsubtitle; ?>';
document.getElementById("subtitle").innerHTML = subtitle;
document.getElementById("dognet-subsubtitle").innerHTML = subsubtitle;
$("#dognet-subsubtitle").attr("class", "text-default");
</script>