<?php
date_default_timezone_set('Europe/Moscow');

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once($_SERVER['DOCUMENT_ROOT'] . "/dognet/_assets/_NCL/NCLNameCaseRu.php");

require_once($_SERVER['DOCUMENT_ROOT'] . "/dognet/_assets/_Morpher/morpher-ws3-php-client-1.0.0/vendor/autoload.php");

use Morpher\Ws3Client\WebClient;
use Morpher\Ws3Client\Morpher;
use Morpher\Ws3Client\Russian\Flags;
use Morpher\Ws3Client\Russian\DeclensionResult;

$__title = 'Договор';
$__subtitle = "Экспорт отчетных данных";
$__subsubtitle = "Экспорт отчетных данных";

# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 

$_docSrok = "";
$_koddoc = "";
if (isset($_GET['uniqueID1']) && !empty($_GET['uniqueID1'])) {
    $_koddoc = $_GET['uniqueID1'];
    $_QRY_DOC = mysqli_fetch_assoc(mysqlQuery("SELECT * FROM dognet_docbase WHERE koddoc='{$_koddoc}'"));
    $_docSrok = $_QRY_DOC['dayenddoc'] . "." . $_QRY_DOC['monthenddoc'] . "." . $_QRY_DOC['yearenddoc'];
}
if (isset($_GET['zak']) && !empty($_GET['zak'])) {
    $_kodzakaz = $_GET['zak'];
    $_QRY_SP = mysqli_fetch_assoc(mysqlQuery("SELECT * FROM sp_contragents WHERE kodcontragent='{$_kodzakaz}'"));
    $_docZak = $_QRY_SP['namefull'];
    $_kodformlegal = $_QRY_SP['kodformlegal'];
    $_QRY_OPF = mysqli_fetch_assoc(mysqlQuery("SELECT * FROM sp_contragents_opf WHERE kodformlegal='{$_kodformlegal}'"));
    $_docZakOpf = $_QRY_OPF['abbr'];
    $_zakOrg = $_docZakOpf . " " . "\"" . $_docZak . "\"";
}
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
?>

<style>
#report-settings {}

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
    font-size: 1.2em;
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
    width: 260px;
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

#report-settings h3.page-header {
    color: #fff;
    font-family: 'Oswald', sans-serif;
    font-size: 1.7em;
    font-weight: 400;
    letter-spacing: 0.05em;
    text-transform: none;
    background-color: #337AB7;
    padding: 20px 10px;
}

#report-settings h4.section-title {
    color: #111111;
    font-family: "Stolzl", Arial, Helvetica Neue, Helvetica, sans-serif;
    font-size: 1.15em;
    font-weight: 400;
    text-transform: none;
    text-align: left;
}

#report-settings .form-control.ispol-input {}

#report-settings .input-group.ondate {
    border: 2px solid #FF7707;
    border-radius: 6px;
}



#report-settings .input-group.ondate span.input-group-addon {
    color: #fff;
    background-color: #FF7707;
    border: none;
}

button#clearSrok.btn {
    display: inline-block;
    padding: 4px 12px;
    margin-bottom: 0;
    font-size: 12px;
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

#report-settings .btn-link {
    font-family: "Stolzl Book", Arial, Helvetica Neue, Helvetica, sans-serif;
    font-size: 1.5rem;
    color: #111111;
}

#report-settings .btn-link:focus {
    border: none;
}

.block-text {
    display: none;
    padding: 15px;
    border: 1px solid #ec4848;
}

#report-settings .docHeader-preview {
    font-family: 'Play', sans-serif;
    border: 1px solid #CCC;
    border-radius: 1rem;
    padding: 1rem;
}

#report-settings .block-comment p {
    font-family: "Stolzl Book", Arial, Helvetica Neue, Helvetica, sans-serif;
    text-align: left;
    font-size: 0.9em;
    line-height: 1.3em;
}

#report-settings .docHeader-preview h4 {}

#report-settings .form-control {
    font-family: "Stolzl Book", Arial, Helvetica Neue, Helvetica, sans-serif;
    color: rgb(153 153 153) !important;
    box-shadow: none;
    border-color: rgb(119, 119, 119, .2) !important;
}

#report-settings .form-control:focus {
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, .045), 0 0 4px rgb(255 119 7);
    border-color: rgb(255 119 7) !important;
    color: rgb(0, 0, 0, .9) !important;
}

#report-settings .input-group.ondate input.form-control,
#report-settings .input-group.ondate input.form-control:focus {
    border-color: transparent;
    color: rgb(0, 0, 0, .9) !important;
    box-shadow: none;
}

button#clearSrok.btn.active.focus,
button#clearSrok.btn.active:focus,
button#clearSrok.btn.focus,
button#clearSrok.btn:active.focus,
button#clearSrok.btn:active:focus,
button#clearSrok.btn:focus {
    outline: none;
    outline-offset: 0;
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
    if (empty($_GET['done']) || !isset($_GET['done']) || $_GET['done'] != "ok") {

        $_QRY = mysqlQuery("SELECT * FROM dognet_docbase WHERE koddoc = '" . $_GET['uniqueID1'] . "'");
        $_ROW = mysqli_fetch_assoc($_QRY);

        function numberFormat($digit, $width) {
            while (strlen($digit) < $width)
                $digit = '0' . $digit;
            return $digit;
        }


        /*
$_QRY = mysqlQuery( "SELECT * FROM sp_contragents" );
while ($_ROW = mysqli_fetch_assoc($_QRY)) {
	$pos_space = mb_strpos($_ROW['zakfio'], " ", 0, 'utf-8');
	$subname = mb_substr($_ROW['zakfio'], 0, ($pos_space+1), 'utf-8');
	echo $subname." | ";
// 	$_QRY_A = mysqlQuery( "UPDATE sp_contragents SET director_lastname='".$subname."'" );
}
*/




    ?>
    <div class="row space20">
        <div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 space20">
                <div id="report-settings" class="text-center">
                    <h3 class="page-header space10">Письмо заказчику о задолженности по договору/этапу договора</h3>
                    <div id="export-format-block" class="center-block" style="">
                        <form class="form-horizontal" method="GET" action="/dognet/dognet-report.php">
                            <input type="hidden" name="reportview" value="zadolchf">
                            <input type="hidden" name="export" value="yes">
                            <input type="hidden" name="uniqueID1"
                                   value="<?php echo (isset($_GET['uniqueID1']) && !empty($_GET['uniqueID1'])) ? $_GET['uniqueID1'] : ""; ?>">
                            <input type="hidden" name="zak"
                                   value="<?php echo (isset($_GET['zak']) && !empty($_GET['zak'])) ? $_GET['zak'] : ""; ?>">
                            <div class="col-xs-hidden col-sm-12 col-md-12 col-lg-12 space20">
                                <div class="form-group text-left">
                                    <h4 class="section-title space10">Выберите счета-фактуры для письма</h4>
                                    <select id="selectCHF" class='form-control' name='chfID[]' multiple size='10'
                                            style="font-size:0.9em; min-height:205px">
                                        <?php
                                            $_QRY_A = mysqlQuery("SELECT koddoc, docnumber, daynachdoc, monthnachdoc, yearnachdoc, kodzakaz FROM dognet_docbase WHERE kodzakaz = '" . $_GET['zak'] . "'");
                                            $_QRY_B = mysqlQuery("SELECT * FROM sp_contragents WHERE kodcontragent = '" . $_GET['zak'] . "'");
                                            $_ROW_B = mysqli_fetch_assoc($_QRY_B);
                                            while ($_ROW_A = mysqli_fetch_assoc($_QRY_A)) {
                                                $docdate = numberFormat($_ROW_A['daynachdoc'], 2) . "." . numberFormat($_ROW_A['monthnachdoc'], 2) . numberFormat($_ROW_A['yearnachdoc'], 4);
                                                $_QRY = mysqlQuery("SELECT * FROM dognet_reports_zadolchf WHERE koddoc = '" . $_ROW_A['koddoc'] . "'");
                                                while ($_ROW = mysqli_fetch_assoc($_QRY)) {
                                            ?>
                                        <option value='<?php echo $_ROW["kodchfact"]; ?>' selected="selected">
                                            <?php echo 'С/Ф №' . $_ROW["chetfnumber"] . ' от ' . date("d.m.Y", strtotime($_ROW["chetfdate"])) . ' / Договор №3-4/' . $_ROW_A["docnumber"] . ' от ' . $docdate . ' / ' . number_format($_ROW["summazadol"], 2, '.', ' ');; ?>
                                        </option>
                                        <?php
                                                }
                                            }
                                            ?>
                                    </select>
                                </div>
                                <?php

                                    $_zakLastName_D = "";
                                    $_zakFirstName_D = "";
                                    $_zakMidName_D = "";
                                    $_zakDolj_D = "";

                                    $_QRY_A = mysqlQuery("SELECT docnumber, daynachdoc, monthnachdoc, yearnachdoc, kodzakaz FROM dognet_docbase WHERE koddoc = '" . $_GET['uniqueID1'] . "'");
                                    $_ROW_A = mysqli_fetch_assoc($_QRY_A);
                                    //
                                    $_QRY_B = mysqlQuery("SELECT * FROM sp_contragents WHERE kodcontragent = '" . $_GET['zak'] . "'");
                                    $_ROW_B = mysqli_fetch_assoc($_QRY_B);
                                    $docdate = numberFormat($_ROW_A['daynachdoc'], 2) . "." . numberFormat($_ROW_A['monthnachdoc'], 2) . numberFormat($_ROW_A['yearnachdoc'], 4);
                                    $_zakFirstName = !empty($_ROW_B['director_firstname']) ? $_ROW_B['director_firstname'] : "";
                                    $_zakMidName = !empty($_ROW_B['director_middlename']) ? $_ROW_B['director_middlename'] : "";
                                    $_zakLastName = !empty($_ROW_B['director_lastname']) ? $_ROW_B['director_lastname'] : "";
                                    $_zakDolj = !empty($_ROW_B['director_post']) ? $_ROW_B['director_post'] : "";
                                    /**
                                     * 
                                     * Формируем дательный падеж для ИО руководителя компании-заказчика
                                     * На основе класса https://github.com/petrovich/petrovich-php
                                     *  
                                     */
                                    if (!empty($_zakLastName) && !empty($_zakFirstName)) {
                                        mb_internal_encoding('UTF-8');
                                        $nc = new NCLNameCaseRu();
                                        $_zakLastName_D = $nc->qFullName($_zakLastName, $_zakFirstName, $_zakMidName, null, NCL::$DATELN, "S");
                                        $_zakFirstName_D = $nc->qFullName($_zakLastName, $_zakFirstName, $_zakMidName, null, NCL::$DATELN, "N");
                                        $_zakMidName_D = $nc->qFullName($_zakLastName, $_zakFirstName, $_zakMidName, null, NCL::$DATELN, "F");
                                        // $_zakDolj_D = $_zakDolj;

                                        $base_url = 'https://ws3.morpher.ru';
                                        $token = "";
                                        $morpher = new Morpher($base_url, $token);
                                        $_zakDolj_D = $morpher->russian->Parse($_zakDolj)->Dative;
                                    }
                                    ?>

                                <h4 class="section-title space10">Информация о контрагенте (из справочника)</h4>
                                <div class="col-sm-12 text-left space10">
                                    <span><b>Фамилия Имя Отчество адресата</b></span><br>
                                    <span>
                                        <?php
                                            echo $_zakFirstName . " " . $_zakMidName . " " . $_zakLastName;
                                            ?>
                                    </span>
                                </div>
                                <div class="col-sm-12 text-left space10">
                                    <span><b>Должность адресата</b></span><br>
                                    <span>
                                        <?php
                                            echo $_zakDolj;
                                            ?>
                                    </span>
                                </div>
                                <div class="col-sm-12 text-left space10">
                                    <span><b>Организация-адресат</b></span><br>
                                    <span>
                                        <?php
                                            echo $_zakOrg;
                                            ?>
                                    </span>
                                </div>
                            </div>


                            <div class="col-xs-hidden col-sm-12 col-md-12 col-lg-12 space20">
                                <div id="report-info" class="">
                                    <p>Особенности формирования документа:</p>
                                    <ol>
                                        <li>ФИО (выше, из справочника) должны быть полностью, иначе в обращении
                                            будут
                                            некорректные Имя Отчество. В противном случае стоит использовать
                                            ручной ввод
                                            данных Заказчика.</li>
                                        <li>Данные исполнителя используются в нижнем колонтитуле документа.</li>
                                        <li>После формирования документа его можно открыть и скорректировать при
                                            необходимости, либо отправить ссылку на формирование этого документа
                                            по
                                            email.</li>
                                        <li>Для склонения в дательный падеж в качестве эксперимента используются
                                            следующие PHP-библиотеки и модули:<br>
                                            - NameCaseLib для склонения ФИО
                                            (https://github.com/seagullua/NameCaseLib/tree/v0.4.1)<br>
                                            - Web-клиент Morpher для склонения должности
                                            (https://morpher.ru/php/extension)<br><span
                                                  class="text-info">[&nbsp;Используется
                                                бесплатная версия клиента, у
                                                которой количество обращений к сервису в сутки ограничено. Так что,
                                                если при формировании отчета возникает сбой, то возможно причина в
                                                этом, в таком случае - срочно пишите админу&nbsp;]</span>
                                        </li>
                                    </ol>
                                    <p class="text-danger"><b>По всем возникающим вопросам и найденным ошибкам в
                                            формируемом документе докладываем в
                                            отдел разработки отчетов департамента корпоративных сервисов не
                                            откладывая!
                                            Чем дольше пауза, тем сложнее
                                            поиск ошибки.</b></p>
                                </div>
                            </div>



                            <div class="col-xs-hidden col-sm-12 col-md-12 col-lg-12 space20">
                                <h4 class="section-title space10">Как будет выглядеть адресат в шапке письма
                                    (в
                                    дательном падеже)
                                </h4>
                                <div class="col-sm-12 space10">
                                    <input type="text" class="form-control" id="zak-dolj" name="zak_dolj"
                                           placeholder="Должность">
                                </div>
                                <div class="col-sm-12 space10">
                                    <input type="text" class="form-control" id="zak-org" name="zak_org"
                                           placeholder="Организация">
                                </div>
                                <div class="col-sm-4 space30">
                                    <input type="text" class="form-control" id="zak-lastname" name="zak_lastname"
                                           placeholder="Фамилия">
                                </div>
                                <div class="col-sm-4 space30">
                                    <input type="text" class="form-control" id="zak-firstname" name="zak_firstname"
                                           placeholder="Имя">
                                </div>
                                <div class="col-sm-4 space30">
                                    <input type="text" class="form-control" id="zak-midname" name="zak_midname"
                                           placeholder="Отчество">
                                </div>
                                <h4 class="section-title space10">Как будет выглядеть приветственное
                                    обращение</h4>
                                <div class="col-sm-12 space10">
                                    <input type="text" class="form-control" id="zak-hello" name="zak_hello"
                                           placeholder='Обращение (по умолчанию - "Уважаемый")'>
                                </div>
                                <div class="col-sm-4 space10">
                                    <input type="text" class="form-control" id="zak-hello-firstname"
                                           name="zak_hello_firstname" placeholder="Имя">
                                </div>
                                <div class="col-sm-4 space10">
                                    <input type="text" class="form-control" id="zak-hello-midname"
                                           name="zak_hello_midname" placeholder="Отчество">
                                </div>
                            </div>

                            <div class="col-xs-hidden col-sm-12 col-md-12 col-lg-12 space30">
                                <div class="text-left">
                                    <div class="form-group">
                                        <h4 class="space10">Исполнитель документа</h4>
                                        <div class="col-sm-4">
                                            <div class="radio" style="margin-bottom:20px">
                                                <select class="form-control" id="isp-selector" name="isp_selector">
                                                    <option value="">---</option>
                                                    <option value="isp1">Желобова</option>
                                                    <option value="isp2">Кочешков</option>
                                                    <option value="isp3">Шепотько</option>
                                                    <option value="isp4">Царев</option>
                                                    <option value="isp5">Широких</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="radio" style="margin-bottom:20px">
                                                <input type="text" class="form-control" id="isp-name" name="isp_name"
                                                       placeholder="ФИО Исполнителя">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="isp-tel" type="tel"
                                                   name="isp_tel" placeholder="Телефон">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="isp-email" type="email"
                                                   name="isp_email" placeholder="Email">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-hidden col-sm-12 col-md-12 col-lg-12 space30">
                                <div class="checkbox text-left">
                                    <label><input type="checkbox" name="log" value="yes" checked="checked">Сделать
                                        запись в
                                        "Журнале писем"</label>
                                </div>
                                <div class="checkbox text-left">
                                    <label><input type="checkbox" name="save" value="yes" checked="checked">Сохранить
                                        файл
                                        письма на сервере (будет доступен в "Журнале писем")</label>
                                </div>
                            </div>
                            <div class="col-xs-hidden col-sm-12 col-md-12 col-lg-12 space30">
                                <label id="select-format-doc" class="radio-inline">
                                    <input type="radio" name="format" value="doc" checked>
                                    <span class="media"></span>
                                </label>
                            </div>
                            <div class="space10">
                                <button id="exportBtn" class="btn btn-export" type="submit" name="done"
                                        value="ok">Сформировать документ</button>
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
    <div class="row space50">
        <div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
            <div class="text-center">
                <?php
                if (isset($_GET['format'])) {
                    switch ($_GET['format']) {
                        case "doc":
                            include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/letter/zakzadolchf/export/_docx/export2docx.php");
                            break;
                        case "xls":
                            include('');
                            break;
                        case "pdf":
                            include('');
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
$('#isp-selector').change(function() {
    console.log("isp_selector: " + $(this).val());
    if ($(this).val() == 'isp1') {
        $('input[name="isp_name"]').val('Желобова Ю. А.');
        $('input[name="isp_tel"]').val('8 (495) 660-0802 доб. 301');
        $('input[name="isp_email"]').val('zholobova@atgs.ru');
    } else if ($(this).val() == 'isp2') {
        $('input[name="isp_name"]').val('Кочешков В. Е.');
        $('input[name="isp_tel"]').val('8 (495) 660-0802 доб. 302');
        $('input[name="isp_email"]').val('kve@atgs.ru');
    } else if ($(this).val() == 'isp3') {
        $('input[name="isp_name"]').val('Иванова В. О.');
        $('input[name="isp_tel"]').val('8 (495) 660-0802 доб. 304');
        $('input[name="isp_email"]').val('нет email');
    } else if ($(this).val() == 'isp4') {
        $('input[name="isp_name"]').val('Царев В. А.');
        $('input[name="isp_tel"]').val('8 (495) 660-0802 доб. 306');
        $('input[name="isp_email"]').val('tsarev@atgs.ru');
    } else if ($(this).val() == 'isp5') {
        $('input[name="isp_name"]').val('Широких С. В.');
        $('input[name="isp_tel"]').val('8 (495) 660-0802 доб. 303');
        $('input[name="isp_email"]').val('shirokih@atgs.ru');
    } else {
        $('input[name="isp_name"]').val('');
        $('input[name="isp_tel"]').val('');
        $('input[name="isp_email"]').val('');
    }
});

$('input[name="log"]').change(function() {
    if ($('input[name="log"]').prop("checked")) {
        $('#filesave-enbl').css("display", "");
    } else {
        $('#filesave-enbl').css("display", "none");
    }
});

$('#selectCHF').change(function() {
    size = $('#selectCHF option:selected').size();
    console.log("SIZE: " + size);
    if (size < 1) {
        alert('Выберите хотя бы один счет-фактуру!');
        $('#exportBtn').prop('disabled', true);
    } else {
        $('#exportBtn').prop('disabled', false);
    }
});

$('input[name="zak_firstname"]').val('<?php echo $_zakFirstName_D; ?>');
$('input[name="zak_midname"]').val('<?php echo $_zakMidName_D; ?>');
$('input[name="zak_lastname"]').val('<?php echo $_zakLastName_D; ?>');
$('input[name="zak_org"]').val('<?php echo $_zakOrg; ?>');
$('input[name="zak_dolj"]').val('<?php echo $_zakDolj_D; ?>');
$('input[name="zak_hello_firstname"]').val('<?php echo $_zakFirstName; ?>');
$('input[name="zak_hello_midname"]').val('<?php echo $_zakMidName; ?>');
$('#isp-selector option[value=isp1]').prop('selected', true);
$('input[name="isp_name"]').val('Желобова Ю. А.');
$('input[name="isp_tel"]').val('8 (495) 660-0802 доб. 301');
$('input[name="isp_email"]').val('zholobova@atgs.ru');
</script>