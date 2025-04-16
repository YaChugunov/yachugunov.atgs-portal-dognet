<?php
    date_default_timezone_set('Europe/Moscow');

    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    $__title       = 'Договор';
    $__subtitle    = "Заявки и счета";
    $__subsubtitle = "Работа с заявками";

    // 		PORTAL_SYSLOG('99940000', '0000000', null, null, null, null);

?>


<script type="text/javascript"
        src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/moment-with-locales.js"></script>
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/filterByText.js">
</script>

<script src="//yandex.st/jquery/cookie/1.0/jquery.cookie.min.js"></script>

<script type="text/javascript" language="javascript" class="init">
function addZero(digits_length, source) {
    var text = source + '';
    while (text.length < digits_length)
        text = '0' + text;
    return text;
}


// Добавляем метод fileExists к строковому типу
String.prototype.fileExists = function() {
    var filename = this.trim();

    // Выполняем AJAX-запрос HEAD-методом
    var response = jQuery.ajax({
        url: filename,
        type: 'HEAD',
        async: false
    }).status;

    // Проверяем статус ответа
    return (response !== "200") ? false : true;
}

function checkFileExists(filename, callback) {
    $.ajax({
        url: filename,
        type: 'HEAD',
        success: function() {
            callback(true);
        },
        error: function() {
            callback(false);
        }
    });
}
</script>

<style>
div.jumbotron {
    padding-left: 20px;
    padding-right: 20px;
}

div.jumbotron a.close {
    padding-left: 20px;
    padding-right: 20px;
}

.jumbotron h1,
.jumbotron p {
    font-family: 'Oswald', sans-serif;
}

.jumbotron h1 {
    font-size: 3.0em;
    font-weight: 400;
}

.jumbotron p {
    font-size: 1.3em;
    font-weight: 200;
    line-height: normal;
}

#main-tabs .nav>li>a {
    color: #111;
}

#main-tabs .nav>li>a:focus,
#main-tabs .nav>li>a:hover {
    background-color: transparent;
}

#main-tabs .nav-tabs>li.active>a,
#main-tabs .nav-tabs>li>a:hover {
    color: #fff !important;
}

#main-tabs>div.row>div>ul>li>a {
    font-family: 'Play', sans-serif
}

/* Изменено 20.06.2019 --- */
#main-tabs-menu {
    border-bottom: none;
}

#main-tabs-menu {
    padding: 10px;
    border: 2px #f0ad4e solid;
    border-radius: 10px;
}

#main-tabs-menu>li>a::after {
    content: "";
    background: #f0ad4e;
    height: 40px;
    z-index: -1;
    position: absolute;
    width: 100%;
    left: 0px;
    bottom: -1px;
    transition: all 250ms ease 0s;
    transform: scale(0);
}

#main-tabs-menu>li.active>a::after,
#main-tabs-menu>li:hover>a::after {
    transform: scale(1);
}

/* --- Изменено 20.06.2019 */

</style>





<?php
    $_QRY_MAILING_ENBL = mysqlQuery("SELECT dognet_mailing_enbl FROM users WHERE id=" . $_SESSION['id']);
    $_ROW_MAILING_ENBL = mysqli_fetch_assoc($_QRY_MAILING_ENBL);
    if ($_ROW_MAILING_ENBL['dognet_mailing_enbl'] == 0) {
        // include($_SERVER['DOCUMENT_ROOT']."/dognet/_assets/includes/subscribe_handler/dognetNewsletter-subscribe-popup-onload-window.php");
    }
?>







<div class="container">
    <div class="row common-top-block">
        <?php include $_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/dognet-topblock.php" ?>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <?php include $_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/_fixes-updates/dognet_fixes-updates.php"; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div id="main-tabs">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <ul id="main-tabs-menu" class="nav nav-tabs">
                            <li id="link-to-tab1" class="active"><a data-toggle="tab" href="#tab-1" title="">Заявка</a>
                            </li>
                            <li id="link-to-tab2"><a data-toggle="tab" href="#tab-2" title="">Спецификация (список)</a>
                            </li>
                            <li id="link-to-tab3"><a data-toggle="tab" href="#tab-3" title="">Спецификации и прочие
                                    файлы</a></li>
                            <li id="link-to-tab4"><a data-toggle="tab" href="#tab-4" title="">Счета и счета-фактуры</a>
                            </li>
                            <!-- 								<li id="link-to-tab5"><a data-toggle="tab" href="#tab-5" title="">Спецификации (договор)</a></li> -->
                        </ul>
                        <div class="tab-content">
                            <?php include $_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/zayvview/zayvview-current/restr_3/dognet-zayvview-current(restr_3)-main.php" ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row space20">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php // include($_SERVER['DOCUMENT_ROOT']."/dognet/_assets/includes/dognet_current-bottom-legend.php");
            ?>
        </div>
    </div>

</div>
<div class="space100"></div>
<div class="modal fade" data-backdrop="true" id="modal-dognetUpdates" tabindex="-1" role="dialog" aria-labelledby="modal-dognetUpdates-label">
    <div class="modal-dialog modal-lg" role="document" style="max-width:1170px">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title">Обновление в сервисе</h1>
            </div>
            <div class="modal-body">
                <div class="container dognetUpdates-content"></div>
            </div>
            <div class="modal-footer">
                <div class="checkbox">
                    <label><input type="checkbox" value="">Больше не показывать это окно</label>
                </div>
                <button type="button" class="btn btn-close" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>




<script type="text/javascript">
subtitle = '<?php echo $__subtitle; ?>';
subsubtitle = '<?php echo $__subsubtitle; ?>';
document.getElementById("subtitle").innerHTML = subtitle;
document.getElementById("dognet-subsubtitle").innerHTML = subsubtitle;

window.onload = function(){
    setTimeout(function(){
        // Пример проверки существования файла
        // var exists = "http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/updates.html/doczayv-updates.html".fileExists();


        // Использование асинхронной версии
        checkFileExists('http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/updates.html/doczayv-updates.html', function(exists) {
            if(exists) {
                console.log('Есть файл обновления');
                $('#modal-dognetUpdates .dognetUpdates-content').load('http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/updates.html/doczayv-updates.html', function() {
                    // Действия после успешной загрузки
                    console.log('Содержимое загружено');

                    $.ajax({
                        url: 'http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/updates.html/styles.css',
                        dataType: 'text',
                        success: function(data) {
                            var style = $('#modal-dognetUpdates .dognetUpdates-content style');
                            style.text(data);
                            // $('#modal-dognetUpdates .dognetUpdates-content').append(style);
                        }
                    });

                    jQuery(function () {
                        var modal = $('#modal-dognetUpdates');
                        var cookieLifetime = 12; // в часах
                        // Проверяем наличие cookie
                        if (!$.cookie('cookies_dognetZayvUpdatesShow')) {
                            modal.modal('show');
                        }

                        // Обработка нажатия кнопки "Да"
                        $('.btn-close').click(function () {
                            if($('#modal-dognetUpdates input[type="checkbox"]').is(':checked')) {
                                $.cookie('cookies_dognetZayvUpdatesShow', true, {
                                    expires: new Date(new Date().getTime() + cookieLifetime * 3600000), // срок хранения в днях
                                    path: '/'
                                });
                            } else {
                                $.removeCookie('cookies_dognetZayvUpdatesShow');
                            }
                        });
                    });
                });
            } else {
                console.log('Нет файла обновления');
            }
        });
    }, 500);
};

</script>