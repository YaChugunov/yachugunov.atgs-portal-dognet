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
        <div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 space20">
                <div id="report-settings" class="text-center">
                    <h3 class="space10">Сопроводительное письмо Заказчику о направлении договора</h3>
                    <h4 class="space10">Подготовьте документ</h4>
                </div>
            </div>
            <div class="col-xs-hidden col-sm-12 col-md-12 col-lg-12">
                <div id="export-format-block" class="center-block" style="">
                    <form class="form-horizontal" method="GET" action="/dognet/dognet-docview.php">
                        <input type="hidden" name="docview_type" value="current">
                        <input type="hidden" name="export" value="yes">
                        <input type="hidden" name="tip" value="letter_notify">
                        <input type="hidden" name="uniqueID1"
                               value="<?php echo (isset($_GET['uniqueID1']) && !empty($_GET['uniqueID1'])) ? $_GET['uniqueID1'] : ""; ?>">
                        <input type="hidden" name="zak"
                               value="<?php echo (isset($_GET['zak']) && !empty($_GET['zak'])) ? $_GET['zak'] : ""; ?>">
                        <div class="col-xs-hidden col-sm-12 col-md-12 col-lg-12">
                            <!--
							<div class="form-group text-left">
							  <label for="sel1"><h4>Выберите этап договора</h4></label>
							  <select class="form-control" id="stage" name="uniqueID2">
								<?php
                                if (($_ROW['kodshab'] == 1) or ($_ROW['kodshab'] == 3)) {
                                    $_QRY0 = mysqlQuery("SELECT kodkalplan, numberstage, nameshotstage, summastage FROM dognet_dockalplan WHERE koddoc = '" . $_GET['uniqueID1'] . "'");
                                ?>
										<option value="">---</option>
										<?php
                                        while ($_ROW0 = mysqli_fetch_assoc($_QRY0)) {
                                        ?>
												<option value = '<?php echo $_ROW0["kodkalplan"]; ?>'><?php echo 'Этап ' . $_ROW0["numberstage"] . '. ' . $_ROW0["nameshotstage"]; ?></option>
									<?php
                                        }
                                    } else {
                                    ?>
										<option value="">Без этапа</option>
									<?php
                                    }
                                    ?>
							  </select>
							</div>
-->
                        </div>
                        <div class="col-xs-hidden col-sm-12 col-md-12 col-lg-12 space30">
                            <div class="text-left">
                                <div class="form-group">
                                    <?php
                                        $_QRY_A = mysqlQuery("SELECT docnumber, daynachdoc, monthnachdoc, yearnachdoc, kodzakaz FROM dognet_docbase WHERE koddoc = '" . $_GET['uniqueID1'] . "'");
                                        $_ROW_A = mysqli_fetch_assoc($_QRY_A);
                                        //
                                        $_QRY_B = mysqlQuery("SELECT * FROM sp_contragents WHERE kodcontragent = '" . $_GET['zak'] . "'");
                                        $_ROW_B = mysqli_fetch_assoc($_QRY_B);
                                        $docdate = numberFormat($_ROW_A['daynachdoc'], 2) . "." . numberFormat($_ROW_A['monthnachdoc'], 2) . numberFormat($_ROW_A['yearnachdoc'], 4);
                                        ?>
                                    <h4 class="space10">ФИО и должность получателя письма (из справочника)</h4>
                                    <p>
                                        <span><b>Фамилия Имя Отчество</b></span>
                                        <br>
                                        <span>
                                            <?php
                                                // echo $_ROW_B['director_firstname']." ".$_ROW_B['director_middlename']." ".$_ROW_B['director_lastname'];
                                                echo $_ROW_B['director_firstname'] . " " . $_ROW_B['director_middlename'] . " " . $_ROW_B['zakfio'];
                                                ?>
                                    </p>
                                    <p>
                                        <span><b>Должность</b></span>
                                        <br>
                                        <span>
                                            <?php
                                                echo $_ROW_B['director_post'];
                                                ?>
                                    </p>
                                    <div class="checkbox text-left">
                                        <label><input id="fio-manual" type="checkbox" name="fio_manual"
                                                   value="yes">Ввести данные Заказчика вручную</label>
                                    </div>
                                    <div id="div-fio-manual" style="display:none">
                                        <div class="radio" style="margin-bottom:20px">
                                            <label class="control-label col-sm-4" for="zak-hello"
                                                   style="text-align:left"><span>Обращение</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="zak-hello" name="zak_hello"
                                                       placeholder="Обращение" disabled>
                                            </div>
                                        </div>
                                        <div class="radio" style="margin-bottom:20px">
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="zak-lastname"
                                                       name="zak_lastname" placeholder="Фамилия" disabled>
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="zak-firstname"
                                                       name="zak_firstname" placeholder="Имя" disabled>
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="zak-midname"
                                                       name="zak_midname" placeholder="Отчество" disabled>
                                            </div>
                                        </div>
                                        <div class="radio" style="margin-bottom:20px">
                                            <label class="control-label col-sm-4" for="zak-org"
                                                   style="text-align:left"><span>Организация</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="zak-org" name="zak_org"
                                                       placeholder="Организация" disabled>
                                            </div>
                                        </div>
                                        <div class="radio" style="margin-bottom:20px">
                                            <label class="control-label col-sm-4" for="zak-dolg"
                                                   style="text-align:left"><span>Должность</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="zak-dolg" name="zak_dolg"
                                                       placeholder="Должность" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                                                <option value="isp6">Димитрова</option>
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
                                        <input type="text" class="form-control" id="isp-tel" type="tel" name="isp_tel"
                                               placeholder="Телефон">
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
                                <label><input type="checkbox" name="log" value="yes" checked="checked">Сделать запись в
                                    "Журнале писем"</label>
                            </div>
                            <div class="checkbox text-left">
                                <label><input type="checkbox" name="save" value="yes" checked="checked">Сохранить файл
                                    письма на сервере (будет доступен в "Журнале писем")</label>
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
                            <button id="exportBtn" class="btn btn-default" type="submit" name="done"
                                    value="ok">Эскпортировать</button>
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
                            include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/docview/docview-current/restr_4/letter/export/_docx/export2docx.php");
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
$('input[name="fio_manual"]').change(function() {
    if ($('input[name="fio_manual"]').prop("checked")) {
        $('#div-fio-manual').css("display", "");
        $('input[name="zak_hello"]').prop('disabled', false);
        $('input[name="zak_firstname"]').prop('disabled', false);
        $('input[name="zak_midname"]').prop('disabled', false);
        $('input[name="zak_lastname"]').prop('disabled', false);
        $('input[name="zak_org"]').prop('disabled', false);
        $('input[name="zak_dolg"]').prop('disabled', false);
    } else {
        $('#div-fio-manual').css("display", "none");
        $('input[name="zak_hello"]').prop('disabled', true);
        $('input[name="zak_firstname"]').prop('disabled', true);
        $('input[name="zak_midname"]').prop('disabled', true);
        $('input[name="zak_lastname"]').prop('disabled', true);
        $('input[name="zak_org"]').prop('disabled', true);
        $('input[name="zak_dolg"]').prop('disabled', true);
    }
});
$('#isp-selector').change(function() {
    console.log("isp_selector: " + $(this).val());
    if ($(this).val() == 'isp1') {
        $('input[name="isp_name"]').val('Желобова Ю. А.');
        $('input[name="isp_tel"]').val('8 (495) 660-0802 доб. 301');
        $('input[name="isp_email"]').val('zholobova@atgs.ru');
    } else {
        if ($(this).val() == 'isp2') {
            $('input[name="isp_name"]').val('Кочешков В. Е.');
            $('input[name="isp_tel"]').val('8 (495) 660-0802 доб. 302');
            $('input[name="isp_email"]').val('kve@atgs.ru');
        } else {
            if ($(this).val() == 'isp3') {
                $('input[name="isp_name"]').val('Шепотько Е. В.');
                $('input[name="isp_tel"]').val('8 (495) 660-0802 доб. 304');
                $('input[name="isp_email"]').val('sev@atgs.ru');
            } else {
                if ($(this).val() == 'isp4') {
                    $('input[name="isp_name"]').val('Царев В. А.');
                    $('input[name="isp_tel"]').val('8 (495) 660-0802 доб. 306');
                    $('input[name="isp_email"]').val('tsarev@atgs.ru');
                } else {
                    if ($(this).val() == 'isp5') {
                        $('input[name="isp_name"]').val('Широких С. В.');
                        $('input[name="isp_tel"]').val('8 (495) 660-0802 доб. 303');
                        $('input[name="isp_email"]').val('shirokih@atgs.ru');
                    } else {
                        if ($(this).val() == 'isp6') {
                            $('input[name="isp_name"]').val('Димитрова Е. А.');
                            $('input[name="isp_tel"]').val('8 (495) 660-0802 доб. 302');
                            $('input[name="isp_email"]').val('dimitrova@atgs.ru');
                        } else {
                            $('input[name="isp_name"]').val('');
                            $('input[name="isp_tel"]').val('');
                            $('input[name="isp_email"]').val('');
                        }
                    }
                }
            }
        }
    }

});
/*
	$( document ).ready(function() {
			size = $('#selectCHF option:selected').size();
			console.log("SIZE: "+size);
		  if (size < 1){
		    alert('Выберите хотя бы один счет-фактуру!');
		    $('#exportBtn').prop('disabled', true);
		  }
	});
*/

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
</script>