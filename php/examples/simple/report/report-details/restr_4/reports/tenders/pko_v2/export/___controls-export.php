<?php

date_default_timezone_set('Europe/Moscow');

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$__title = 'Договор';
$__subtitle = "Экспорт отчетных данных";
$__subsubtitle = "Экспорт отчетных данных";

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
	if (empty($_GET['done']) || !isset($_GET['done']) || $_GET['done'] != "ok") {
	?>
    <div class="row space20">
        <div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 space20">
                <div id="report-settings" class="text-center">
                    <h3 class="space10">Сведения об опыте выполнения работ по предмету ПКО<br><span
                            style="text-decoration:underline">за последние три года</span></h4>
                        <h4 class="space10">Выберите параметры для отчета</h4>
                </div>
            </div>
            <div class="col-xs-hidden col-sm-12 col-md-12 col-lg-12">
                <div id="export-format-block" class="center-block" style="">
                    <form class="form-horizontal" method="GET" action="/dognet/dognet-report.php">
                        <div id="docsearch-filters-block" class="">
                            <div id="docsearch-filters" class="">
                                <div id="docview-search-filters" class="row">
                                    <div
                                        class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2 space30">
                                        <div class="checkbox text-left">
                                            <label><input id="chk_allDocs" type="checkbox" name="chk_allDocs"
                                                    value="yes"><b>Все</b> / Все договора</label>
                                        </div>
                                        <div class="checkbox text-left">
                                            <label><input id="chk_currentDocs" type="checkbox" name="chk_currentDocs"
                                                    value="yes"><b>Текущие</b> / Все текущие договора с любыми
                                                статусами, <u>кроме</u> "закрыт", "закрыт оригинала нет", "не
                                                использовать", "не состоялся", "для заказов"</label>
                                        </div>
                                        <div class="checkbox text-left">
                                            <label><input id="chk_closedDocs" type="checkbox" name="chk_closedDocs"
                                                    value="yes"><b>Закрытые</b> / Договора со статусами "закрыт" и
                                                "закрыт, оригинала нет", все или с выбранными годами закрытия</label>
                                        </div>
                                    </div>
                                    <div id="divYearSelector"
                                        class="col-xs-12 col-sm-12 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4"
                                        style="display:none">
                                        <div class="form-group space10" style="width:100%">
                                            <label for="YearSelector1" class="text-uppercase"><b>Год закрытия
                                                    договора</b></label>
                                            <select id="YearSelector1" class="form-control">
                                                <?php
													// Выборка за 3 года
													$year0 = date("Y") - 3;
													echo $year0;
													$_QRY_YMAX = mysqlQuery("SELECT MAX(yearenddoc) as yearmax FROM dognet_docbase WHERE koddel<>'99'");
													$_ROW_YMAX = mysqli_fetch_assoc($_QRY_YMAX);
													// $_yearmax = $_ROW_YMAX['yearmax'];
													$_yearmax = date("Y");
													for ($i = 0; $i <= ($_yearmax - $year0); $i++) {
														$year = $year0 + $i;
														$_arrYear1[$i] = $year;
														echo "<option value='{$year}'>{$year}</option>"
													?>

                                                <?php
													}
													?>
                                            </select>
                                        </div>
                                        <div class="form-group space10" style="width:100%">
                                            <select name="YearSelector[]" multiple="multiple" id="YearSelector"
                                                class="form-control space10">
                                                <?php
													// Сохраняем выбранные элементы и помещаем их в список
													if (isset($_POST['YearSelector']) && !empty($_POST['YearSelector'])) {
														for ($i = 0; $i < count($_arrYear1); $i++) {
															$selected = (in_array($_arrYear1[$i], $_POST['YearSelector']) ? 'selected="selected"' : '');
															if ($selected != "") {
																echo "<option value='$_arrYear1[$i]' $selected>$_arrYear1[$i]</option>";
															}
														}
													}
													?>
                                            </select>
                                            <div class="btn-group">
                                                <button class="btn btn-default" type="button"
                                                    id="btn_addToList_YearSelector"><span
                                                        class='glyphicon glyphicon-plus'></span></button>
                                                <button class="btn btn-default" type="button"
                                                    id="btn_removeFromList_YearSelector"><span
                                                        class='glyphicon glyphicon-minus'></span></button>
                                                <button class="btn btn-default" type="button"
                                                    id="btn_clearList_YearSelector"><span
                                                        class='glyphicon glyphicon-ban-circle'></span></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="divStatusSelector"
                                        class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3"
                                        style="display:none">
                                        <div class="form-group space10" style="width:100%">
                                            <select name="StatusSelector[]" multiple="multiple" id="StatusSelector"
                                                class="form-control space10">
                                                <?php
													// Сохраняем выбранные элементы и помещаем их в список
													if (isset($_POST['StatusSelector']) && !empty($_POST['StatusSelector'])) {
														for ($i = 0; $i < count($_arrStatus1); $i++) {
															$selected = (in_array($_arrStatus1[$i], $_POST['StatusSelector']) ? 'selected="selected"' : '');
															if ($selected != "") {
																echo "<option value='$_arrStatus1[$i]' $selected>$_arrStatus2[$i]</option>";
															}
														}
													}
													?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="reportview" value="pko_v2">
                        <input type="hidden" name="export" value="yes">
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
        $('#start_date').datetimepicker({
            locale: 'ru',
            format: 'DD.MM.YYYY'
        });
        $('#end_date').datetimepicker({
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
							include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/tenders/pko_v2/export/_xlsx/export2xlsx.php");
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
subtitle = '<?php echo $__subtitle; ?>';
subsubtitle = '<?php echo $__subsubtitle; ?>';
// document.getElementById("subtitle").innerHTML = subtitle;
// document.getElementById("dognet-subsubtitle").innerHTML = subsubtitle;
$("#dognet-subsubtitle").attr("class", "text-default");
$('#divStatusSelector').css("display", "none");

// ----- ----- ----- ----- -----
// YEAR SELECTOR
// Добавить в выбранное
$('#btn_addToList_YearSelector').click(function() {
    $('#YearSelector1 option:selected').each(function() {
        $("<option selected/>").
        val($(this).val()).
        text($(this).text()).
        appendTo("#YearSelector");
    });
});
// Удалить из выбранного
$('#btn_removeFromList_YearSelector').click(function() {
    $("#YearSelector option:selected").remove();
});
// Очистить список
$('#btn_clearList_YearSelector').click(function() {
    $('#YearSelector').find('option').remove();
});
// ----- ----- ----- ----- -----

$('#chk_currentDocs').click(function() {
    if ($(this).is(':checked')) {
        $('#divYearSelector').css("display", "none");
        $('#chk_allDocs').prop('checked', false);
        $('#chk_closedDocs').prop('checked', false);
        var list = [{
                'enbl': '1',
                'kodstatus': '245267756667430',
                'statusnameshot': 'ПОДПИСАНИЕ'
            },
            {
                'enbl': '1',
                'kodstatus': '245287841353107',
                'statusnameshot': 'ЗАВИС'
            },
            {
                'enbl': '0',
                'kodstatus': '245287853877236',
                'statusnameshot': 'ЗАКРЫТ'
            },
            {
                'enbl': '1',
                'kodstatus': '245381842747296',
                'statusnameshot': 'ТЕКУЩИЙ'
            },
            {
                'enbl': '1',
                'kodstatus': '245381842145343',
                'statusnameshot': 'ПРОЕКТ'
            },
            {
                'enbl': '0',
                'kodstatus': '245316049282906',
                'statusnameshot': 'НЕ ИСПОЛЬЗОВАТЬ'
            },
            {
                'enbl': '0',
                'kodstatus': '245330847566343',
                'statusnameshot': 'НЕ СОСТОЯЛСЯ'
            },
            {
                'enbl': '0',
                'kodstatus': '245379861643048',
                'statusnameshot': 'ДЛЯ ЗАКАЗОВ'
            },
            {
                'enbl': '1',
                'kodstatus': '245494561881685',
                'statusnameshot': 'ПРЕД-ПРОЕКТ'
            },
            {
                'enbl': '1',
                'kodstatus': '245597345680479',
                'statusnameshot': 'ЕСТЬ СКАН'
            },
            {
                'enbl': '0',
                'kodstatus': '245600252070703',
                'statusnameshot': 'ЗАКРЫТ, ОРИГИН. НЕТ'
            }
        ];
        $('#StatusSelector option').remove();
        $('#YearSelector option').remove();
        for (i in list) {
            if (list[i].enbl == '1') {
                jQuery('#StatusSelector').append('<option value="' + list[i].kodstatus + '" selected>' + list[i]
                    .statusnameshot + '</option>');
            }
        }
    } else {
        $('#YearSelector option').remove();
        $('#StatusSelector option').remove();
    }
});
$('#chk_allDocs').click(function() {
    if ($(this).is(':checked')) {
        $('#divYearSelector').css("display", "none");
        $('#chk_currentDocs').prop('checked', false);
        $('#chk_closedDocs').prop('checked', false);
        var list = [{
                'enbl': '1',
                'kodstatus': '245267756667430',
                'statusnameshot': 'ПОДПИСАНИЕ'
            },
            {
                'enbl': '1',
                'kodstatus': '245287841353107',
                'statusnameshot': 'ЗАВИС'
            },
            {
                'enbl': '1',
                'kodstatus': '245287853877236',
                'statusnameshot': 'ЗАКРЫТ'
            },
            {
                'enbl': '1',
                'kodstatus': '245381842747296',
                'statusnameshot': 'ТЕКУЩИЙ'
            },
            {
                'enbl': '1',
                'kodstatus': '245381842145343',
                'statusnameshot': 'ПРОЕКТ'
            },
            {
                'enbl': '1',
                'kodstatus': '245316049282906',
                'statusnameshot': 'НЕ ИСПОЛЬЗОВАТЬ'
            },
            {
                'enbl': '1',
                'kodstatus': '245330847566343',
                'statusnameshot': 'НЕ СОСТОЯЛСЯ'
            },
            {
                'enbl': '1',
                'kodstatus': '245379861643048',
                'statusnameshot': 'ДЛЯ ЗАКАЗОВ'
            },
            {
                'enbl': '1',
                'kodstatus': '245494561881685',
                'statusnameshot': 'ПРЕД-ПРОЕКТ'
            },
            {
                'enbl': '1',
                'kodstatus': '245597345680479',
                'statusnameshot': 'ЕСТЬ СКАН'
            },
            {
                'enbl': '1',
                'kodstatus': '245600252070703',
                'statusnameshot': 'ЗАКРЫТ, ОРИГИН. НЕТ'
            }
        ];
        $('#StatusSelector option').remove();
        $('#YearSelector option').remove();
        for (i in list) {
            if (list[i].enbl == '1') {
                jQuery('#StatusSelector').append('<option value="' + list[i].kodstatus + '" selected>' + list[i]
                    .statusnameshot + '</option>');
            }
        }
    } else {
        $('#YearSelector option').remove();
        $('#StatusSelector option').remove();
    }
});
$('#chk_closedDocs').click(function() {
    if ($(this).is(':checked')) {
        $('#divYearSelector').css("display", "");
        $('#chk_currentDocs').prop('checked', false);
        $('#chk_allDocs').prop('checked', false);
        var list = [{
                'enbl': '0',
                'kodstatus': '245267756667430',
                'statusnameshot': 'ПОДПИСАНИЕ'
            },
            {
                'enbl': '0',
                'kodstatus': '245287841353107',
                'statusnameshot': 'ЗАВИС'
            },
            {
                'enbl': '1',
                'kodstatus': '245287853877236',
                'statusnameshot': 'ЗАКРЫТ'
            },
            {
                'enbl': '0',
                'kodstatus': '245381842747296',
                'statusnameshot': 'ТЕКУЩИЙ'
            },
            {
                'enbl': '0',
                'kodstatus': '245381842145343',
                'statusnameshot': 'ПРОЕКТ'
            },
            {
                'enbl': '0',
                'kodstatus': '245316049282906',
                'statusnameshot': 'НЕ ИСПОЛЬЗОВАТЬ'
            },
            {
                'enbl': '0',
                'kodstatus': '245330847566343',
                'statusnameshot': 'НЕ СОСТОЯЛСЯ'
            },
            {
                'enbl': '0',
                'kodstatus': '245379861643048',
                'statusnameshot': 'ДЛЯ ЗАКАЗОВ'
            },
            {
                'enbl': '0',
                'kodstatus': '245494561881685',
                'statusnameshot': 'ПРЕД-ПРОЕКТ'
            },
            {
                'enbl': '0',
                'kodstatus': '245597345680479',
                'statusnameshot': 'ЕСТЬ СКАН'
            },
            {
                'enbl': '1',
                'kodstatus': '245600252070703',
                'statusnameshot': 'ЗАКРЫТ, ОРИГИН. НЕТ'
            }
        ];
        $('#StatusSelector option').remove();
        $('#YearSelector option').remove();
        for (i in list) {
            if (list[i].enbl == '1') {
                jQuery('#StatusSelector').append('<option value="' + list[i].kodstatus + '" selected>' + list[i]
                    .statusnameshot + '</option>');
            }
        }
    } else {
        $('#divYearSelector').css("display", "none");
        $('#YearSelector option').remove();
        $('#StatusSelector option').remove();
    }
});
</script>