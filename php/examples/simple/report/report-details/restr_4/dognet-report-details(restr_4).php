<?php
date_default_timezone_set('Europe/Moscow');

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$__title = 'Договор';
$__subtitle = "Отчетные формы";
$__subsubtitle = "";

// Делаем запись в системный лог
// Все параметры в таблице portal_log_messages
PORTAL_SYSLOG('99942000', '0000000', null, null, null, null);

?>

<style>
h4.reports-list {
    color: #333;
    padding: 2px 4px;
    font-family: 'Oswald', sans-serif;
    font-weight: 200;
    font-size: 1.5em;
    text-transform: uppercase;
    letter-spacing: 0.35em
}

div.list-group>li>h4 {
    color: #111;
    font-family: 'Oswald', sans-serif;
    font-weight: 400;
    font-size: 1.2em;
    text-transform: none;
    letter-spacing: 0em;
    margin-bottom: 6px;
}

div.list-group>li>h4>span {
    font-size: 10px;
    font-family: 'Play', sans-serif;
}

div.list-group>li.disabled>h4 {
    color: #999
}

div.list-group>li>p {
    color: #a94442;
    font-family: 'Play', sans-serif;
    font-weight: 600;
    font-size: 0.9em;
    text-transform: none;
    letter-spacing: 0.02em;
}

.report-container-block {
    padding: 10px;
    margin-top: 30px
}

.report-container-block li.list-group-item {
    background-color: #fafafa;
    border: 1px solid #f1f1f1;
    border-radius: 8px;
    min-height: 80px;
    margin-bottom: 10px;
    display: flex;
    flex-direction: column;
    transition: .2s linear;
}

.report-container-block li.list-group-item:hover {
    box-shadow: 0 0 0 2px #337AB7 inset, 0 0 0 4px white inset;
}

.report-container-block li.list-group-item.disabled:hover {
    box-shadow: 0 0 0 2px #DDDDDD inset, 0 0 0 4px white inset;
}

.report-container-block li.list-group-item.updated {
    background-color: #FFEBEB;
}

.report-container-block li.list-group-item.updated:hover {
    box-shadow: 0 0 0 2px #D9534F inset, 0 0 0 4px white inset;
}

.report-container-block li.list-group-item .labels {
    display: flex;
    flex-direction: row;
}

.report-container-block li.list-group-item .labels a span {
    margin-right: 10px;
}
</style>


<div class="container">
    <div class="row common-top-block">
        <?php include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/dognet-topblock.php") ?>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <?php include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/_fixes-updates/dognet_fixes-updates.php"); ?>
        </div>
    </div>
    <div class="row report-container-block">
        <div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h4 class="reports-list space20">Перечни</h4>
                <div class="list-group">
                    <li class="list-group-item">
                        <h4>Перечень договоров с набором фильтров</h4>
                        <div class="labels">
                            <a href="dognet-report.php?reportview=filterdocs" class=""><span
                                      class="label label-default">Онлайн</span></a>
                            <a href="dognet-report.php?reportview=filterdocs&export=yes&format=" class=""><span
                                      class="label label-primary">Экспорт</span></a>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <h4>Перечень незакрытых этапов</h4>
                        <div class="labels">
                            <a href="dognet-report.php?reportview=uncomplstages" class=""><span
                                      class="label label-default">Онлайн</span></a>
                            <a href="dognet-report.php?reportview=uncomplstages&export=yes&format=" class=""><span
                                      class="label label-primary">Экспорт</span></a>
                        </div>
                    </li>
                    <li class="list-group-item disabled">
                        <h4>Перечень не подписанных договоров</h4>
                    </li>
                </div>
                <h4 class="reports-list space20">Справки</h4>
                <div class="list-group">
                    <li class="list-group-item">
                        <h4>Справка о задолженности по счетам-фактурам</h4>
                        <div class="labels">
                            <a href="dognet-report.php?reportview=zadolchf" class=""><span
                                      class="label label-default">Онлайн</span></a>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <h4>Справка о задолженности по счетам-фактурам (на любую дату)</h4>
                        <div class="labels">
                            <a href="dognet-report.php?reportview=zadolchf_ondate" class=""><span
                                      class="label label-default">Онлайн</span></a>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <h4>Справка о задолженности по субподрядчикам (на любую дату)</h4>
                        <div class="labels">
                            <?php if ($_SESSION['id'] === "000") { ?>
                            <p class="text-danger">Идет работа над отчетом...</p>
                            <?php } else { ?>
                            <a href="dognet-report.php?reportview=zadolsub_ondate&export=yes&format=" class=""><span
                                      class="label label-primary">Экспорт</span></a>
                            <?php } ?>
                        </div>
                    </li>
                    <!-- <li class="list-group-item">
            <h4>Справка об авансах, не закрытых счетами-фактурами (на текущую дату)</h4>
            <div class="labels">
              <a href="dognet-report.php?reportview=unoplav&export=yes&format=" class=""><span
                  class="label label-primary">Экспорт</span></a>
            </div>
          </li> -->
                    <li class="list-group-item">
                        <h4>Справка об авансах, не закрытых счетами-фактурами (на любую дату)</h4>
                        <!-- <p class="text-danger">Идет работа над отчетом...</p> -->
                        <div class="labels">
                            <a href="dognet-report.php?reportview=unoplav_ondate&export=yes&format=" class=""><span
                                      class="label label-primary">Экспорт</span></a>
                        </div>
                    </li>
                    <li class="list-group-item updated">
                        <h4>Справка об авансах, не закрытых счетами-фактурами по договорам субподряда (на любую дату)
                        </h4>
                        <!-- <p class="text-danger">Идет работа над отчетом...</p> -->
                        <div class="labels">
                            <?php if (checkIsItSuperadmin($_SESSION['id']) == '1') { ?>
                            <a href="dognet-report.php?reportview=unoplavsub_ondate&export=yes&format=" class=""><span
                                      class="label label-primary">Экспорт</span></a>
                            <?php } else { ?>
                            <p class="text-danger">Идет работа над отчетом...</p>
                            <?php } ?>
                        </div>
                    </li>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h4 class="reports-list space20">Выполнение и поступление средств</h4>
                <div class="list-group">
                    <li class="list-group-item">
                        <h4>Выполнение работ по всем договорам за период</h4>
                        <div class="labels">
                            <a href="dognet-report.php?reportview=docprogress" class=""><span
                                      class="label label-default">Онлайн</span></a>
                            <a href="dognet-report.php?reportview=docprogress&export=yes" class=""><span
                                      class="label label-primary">Экспорт</span></a>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <h4>Договора (все) с истёкшими сроками выполнения</h4>
                        <div class="labels">

                            <a href="dognet-report.php?reportview=alldocsexp" class=""><span
                                      class="label label-default">Онлайн</span></a>
                            <a href="dognet-report.php?reportview=alldocsexp&export=yes" class=""><span
                                      class="label label-primary">Экспорт</span></a>
                        </div>
                    </li>
                    <li class="list-group-item updated">
                        <h4>Договора (поставки) с истёкшими сроками выполнения и расчетом штрафа <span
                                  class="label label-danger" style="float:right">Обновлен 29.11.2023</span></h4>
                        <div class="labels">
                            <a href="dognet-report.php?reportview=postexp" class=""><span
                                      class="label label-default">Онлайн</span></a>
                            <a href="dognet-report.php?reportview=postexp&export=yes" class=""><span
                                      class="label label-primary">Экспорт</span></a>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <h4>Оплата выполненных работ по всем договорам за период</h4>
                        <div class="labels">
                            <a href="dognet-report.php?reportview=opl" class=""><span
                                      class="label label-default">Онлайн</span></a>
                            <a href="dognet-report.php?reportview=opl&export=yes" class=""><span
                                      class="label label-primary">Экспорт</span></a>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <h4>Авансы, поступившие по всем договорам за период</h4>
                        <div class="labels">
                            <a href="dognet-report.php?reportview=av" class=""><span
                                      class="label label-default">Онлайн</span></a>
                            <a href="dognet-report.php?reportview=av&export=yes" class=""><span
                                      class="label label-primary">Экспорт</span></a>
                        </div>
                    </li>
                </div>
                <h4 class="reports-list space20">Прочие отчеты</h4>
                <div class="list-group">
                    <li class="list-group-item disabled">
                        <h4>Задолженности по всем договорам субподряда</h4>
                    </li>
                    <li class="list-group-item">
                        <h4>Реестр договоров для формирования служебных заданий</h4>
                        <div class="labels">
                            <a href="dognet-report.php?reportview=missions" class=""><span
                                      class="label label-default">Онлайн</span></a>
                        </div>
                    </li>
                    <li class="list-group-item disabled">
                        <h4>Соблюдение сроков поставки за год</h4>
                    </li>
                    <li class="list-group-item updated">
                        <h4>Сводный отчет о рисках по заявкам ГИПов на договора за календарный год <span
                                  class="label label-danger" style="float:right">Обновлен 13.02.2024</span></h4>
                        <div class="labels">
                            <a href="dognet-report.php?reportview=blankrisks&export=yes" class=""><span
                                      class="label label-primary">Экспорт</span></a>
                        </div>
                    </li>
                </div>
                <h4 class="reports-list space20">Банковские формы</h4>
                <div class="list-group">
                    <li class="list-group-item">
                        <h4>Реестр контрактов (форма 1)</h4>
                        <div class="labels">
                            <a href="dognet-report.php?reportview=bankform1&export=yes" class=""><span
                                      class="label label-primary">Экспорт</span></a>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <h4>Контрактная база за период</h4>
                        <div class="labels">
                            <a href="dognet-report.php?reportview=bankform2&export=yes" class=""><span
                                      class="label label-primary">Экспорт</span></a>
                        </div>
                    </li>
                </div>
                <h4 class="reports-list space20">Формы Газпрома</h4>
                <div class="list-group">
                    <li class="list-group-item">
                        <h4>Газпром мониторинг</h4>
                        <div class="labels">
                            <a href="dognet-report.php?reportview=gazpromform1&export=yes" class=""><span
                                      class="label label-primary">Экспорт</span></a>
                        </div>
                    </li>
                </div>
                <h4 class="reports-list space20">Для тендеров (Мохнаткин ONLY)</h4>
                <div class="list-group">
                    <li class="list-group-item">
                        <h4>Сведения об опыте выполнения работ по предмету ПКО за последние три года</h4>
                        <div class="labels">
                            <a href="dognet-report.php?reportview=pko&export=yes&format=" class=""><span
                                      class="label label-primary">Экспорт</span></a>
                        </div>
                    </li>
                    <?php
                    if (checkIsItSuperadmin($_SESSION['id']) == 1 || $_SESSION['id'] == '1073' || $_SESSION['id'] == '1011') {
                        echo '<li class="list-group-item">';
                        echo '<h4>Сведения об опыте выполнения работ по предмету ПКО за последние три года (версия 2)</h4>';
                        echo '<p>*Окончание договора фиксируется по дате последнего счета-фактуры</p>';
                        echo '<div class="labels">';
                        echo '<a href="dognet-report.php?reportview=pko_v2&export=yes&format=" class=""><span class="label label-primary">Экспорт</span></a>';
                        echo '</div>';
                        echo '</li>';
                    }
                    ?>
                    <li class="list-group-item">
                        <h4 style="">Сведения об опыте выполнения работ по предмету ПКО за последние три года (разбивка
                            по спецификациям)</h4>
                        <div class="labels">
                            <a href="dognet-report.php?reportview=pko_stages&export=yes&format=" class=""><span
                                      class="label label-primary">Экспорт</span></a>
                        </div>
                    </li>
                    <?php
                    if (checkIsItSuperadmin($_SESSION['id']) == 1 || $_SESSION['id'] == '1073' || $_SESSION['id'] == '1011') {
                        echo '<li class="list-group-item">';
                        echo '<h4>Сведения об опыте выполнения работ по предмету ПКО за последние три года (разбивка по спецификациям, версия 2)</h4>';
                        echo '<p>*Окончание договора фиксируется по дате последнего счета-фактуры</p>';
                        echo '<div class="labels">';
                        echo '<a href="dognet-report.php?reportview=pko_stages_v2&export=yes&format=" class=""><span class="label label-primary">Экспорт</span></a>';
                        echo '</div>';
                        echo '</li>';
                    }
                    if (checkIsItSuperadmin($_SESSION['id']) == 1 || $_SESSION['id'] == '1073' || $_SESSION['id'] == '1011') {
                        echo '<li class="list-group-item">';
                        echo '<h4>Справка об опыте выполнения поставок товара, подобного предмету закупки за последние три года (разбивка по спецификациям)</h4>';
                        echo '<p>*Только для договоров поставки</p>';
                        echo '<div class="labels">';
                        echo '<a href="dognet-report.php?reportview=tend_exp&export=yes&format=" class=""><span class="label label-primary">Экспорт</span></a>';
                        echo '</div>';
                        echo '</li>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="space100"></div>

<script type="text/javascript">
subtitle = '<?php echo $__subtitle; ?>';
subsubtitle = '<?php echo $__subsubtitle; ?>';
document.getElementById("subtitle").innerHTML = subtitle;
document.getElementById("dognet-subsubtitle").innerHTML = subsubtitle;
$("#dognet-subsubtitle").attr("class", "text-default");
</script>