<?php

date_default_timezone_set('Europe/Moscow');

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$__title = 'Договор';
$__subtitle = "Экспорт отчетных данных";
$__subsubtitle = "Экспорт отчетных данных";

?>
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/moment-with-locales.js"></script>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/_bootstrap-css/bootstrap-datetimepicker.css" />
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/_bootstrap-js/bootstrap-datetimepicker.js">
</script>

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

  #report-settings div.input-group.ondate {
    width: 170px;
  }

  #report-settings div.input-group.ondate>input {
    font-family: 'Oswald', sans-serif;
    font-size: 1.5em;
    height: auto;
    color: #000000;
    letter-spacing: 1px;
    text-align: center;
  }

  #report-info {
    font-family: "Stolzl Book", Arial, Helvetica Neue, Helvetica, sans-serif;
    color: #111;
    text-align: left;
    font-size: 0.9em;
    padding: 15px;
    margin-top: 10px;
    margin-bottom: 20px;
    line-height: 1.3em;
    background-color: #fafafa;
  }

  #report-info ol li {
    padding-left: 10px;
    margin-bottom: 5px;
  }

  #report-settings h3 {
    color: #fff;
    font-family: 'Oswald', sans-serif;
    font-size: 1.7em;
    font-weight: 400;
    letter-spacing: 0.05em;
    text-transform: none;
    background-color: #337AB7;
    padding: 20px 10px;
  }

  #report-settings .form-control {
    border: none;
  }

  #report-settings .input-group.ondate {
    border: 2px solid #FF7707;
    border-radius: 6px;
  }


  #report-settings .input-group.ondate input.form-control {
    border-right: 2px solid #FF7707;
  }

  #report-settings .input-group.ondate span.input-group-addon {
    color: #fff;
    background-color: #FF7707;
    border: none;
  }

  #report-settings .btn {
    display: inline-block;
    padding: 6px 12px;
    margin-bottom: 0;
    font-size: 14px;
    background-image: none;
    border-radius: 4px;
  }

  #report-settings .btn-export {
    font-family: "Stolzl Book", Arial, Helvetica Neue, Helvetica, sans-serif;
    color: #FFFFFF;
    background-color: #FF7707;
    border: 1px solid #FF7707;
  }

  #report-settings .btn-export:hover {
    box-shadow: 0 0 0 2px #FF7707 inset, 0 0 0 4px white inset;
  }
</style>


<div class="container">
  <div class="space50"></div>
  <?php
  if (empty($_GET['done']) || !isset($_GET['done']) || $_GET['done'] != "ok") {
  ?>
    <div class="row space20">
      <div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 space20">
          <div id="report-settings" class="text-center">
            <h3 class="space10">Отчет о рисках по заявкам ГИПов на договора <br>за календарный год</h3>
            <div id="export-format-block" class="center-block" style="">
              <form class="form-inline" method="GET" action="/dognet/dognet-report.php">
                <input type="hidden" name="reportview" value="blankrisks">
                <input type="hidden" name="export" value="yes">
                <div class="form-group" style="text-align:center; margin-bottom:30px">
                  <div class='input-group ondate' id='ondate'>
                    <input type='text' name="ondate" id='inputOndate' class="form-control" />
                    <span class="input-group-addon">
                      <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                  </div>
                </div>

                <div id="report-info" class="">
                  <!-- <p>Особенности отчета:</p>
                  <ol>
                    <li>Учитываются только авансы с датой ранее или равной выбранной и имеющие
                      рассчитанный остаток
                      больше нулевого на дату ранее или равной выбранной.</li>
                  </ol> -->
                  <p class="text-danger"><b>По всем возникающим вопросам и найденным ошибкам в
                      отчете докладываем в
                      департамент разработки отчетов не откладывая! Чем дольше пауза, тем
                      сложнее поиск ошибки.</b></p>
                </div>


                <div class="col-xs-hidden col-sm-12 col-md-12 col-lg-12 space30">
                  <label id="select-format-xls" class="radio-inline">
                    <input type="radio" name="format" value="xls" checked>
                    <span class="media"></span>
                  </label>
                </div>
                <div>
                  <button class="btn btn-export" type="submit" name="done" value="ok">Эскпортировать</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php
  }
  ?>

  <script type="text/javascript">
    $(function() {
      $('#ondate').datetimepicker({
        locale: 'ru',
        defaultDate: moment(),
        format: 'YYYY'
      });
    });
  </script>

  <div class="row space50">
    <div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
      <div class="text-center">
        <?php
        if (isset($_GET['format'])) {
          switch ($_GET['format']) {
            case "xls":
              include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/other/blankrisks/export/_xlsx/export2xlsx.php");
              break;
            default:
              echo "<div class='format-not-selected'></div>";
          }
        } else {
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
                <span style="color:#111; margin:0 10px"><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/dognet-report.php">Отчеты</a></span>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>