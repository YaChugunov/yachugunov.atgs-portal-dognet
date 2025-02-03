<?php
date_default_timezone_set('Europe/Moscow');

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$__title = 'Договор';
$__subtitle = "Работа со счетом";
$__subsubtitle = "Карточка счета";

require $_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/chetview/chetview-details/dognet-chetview-details-functions.inc.php";

if (isset($_GET['uniqueID'])) {$_SESSION['uniqueID'] = $_GET['uniqueID'];}
?>

<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/date-de.js">
</script>
<script type="text/javascript"
        src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/moment-with-locales.js"></script>
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/filterByText.js">
</script>

<link rel="stylesheet"
      href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/chetview/chetview-details/restr_3/tabs/css/chetview-details-common-tabs.css">

<script type="text/javascript" language="javascript" class="init">
function checkVal(val) {
    if (typeof val !== "undefined" && val !== "" && val !== null) {
        return 1;
    } else {
        return 0;
    }
}

var urlAjax_tab_countRecords =
    "<?php echo __ROOT; ?>/dognet/php/examples/simple/chetview/chetview-details/php/ajaxrequests/ajaxReq-tab-countRecords.php";
// ** ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- **
// ** Функция загрузки js-кода из файла
// **
// **

var reqField_tab_countRecords = {
    tab_countRecords: function(response) {},
};

function ajaxReq_tab_countRecords(uid, ajaxurl, responseHandler) {
    request = $.ajax({
        url: ajaxurl,
        type: "post",
        cache: false,
        data: {
            uid: uid,
        },
        success: reqField_tab_countRecords[responseHandler],
    });
    // Callback handler that will be called on success
    request.done(function(response, textStatus, jqXHR) {
        console.log("ajaxReq_tab_countRecords", response);
        setTimeout(function() {
            if (!(response < 0)) {
                result = JSON.parse(response);
                console.log("ajaxReq_tab_countRecords > JSON.parse(response)", result);
                cntStages = checkVal(result['counts'][0].cntStages) ?
                    '<span class="badge badge-count" data-toggle="tooltip" title="Количество этапов в договоре">' +
                    result['counts'][0].cntStages + "</span>" :
                    "";
                cntSubs = checkVal(result['counts'][0].cntSubs) ?
                    '<span class="badge badge-count" data-toggle="tooltip" title="Количество субподрядных договоров в основном договоре (учитываются все этапы)">' +
                    result['counts'][0].cntSubs + "</span>" :
                    "";
                cntChf = checkVal(result['counts'][0].cntChf) ?
                    '<span class="badge badge-count" data-toggle="tooltip" title="Общее количество счетов-фактур по всем этапам договора">' +
                    result['counts'][0].cntChf + "</span>" :
                    "";
                cntAv = checkVal(result['counts'][0].cntAv) ?
                    '<span class="badge badge-count" data-toggle="tooltip" title="Общее количество авансов по всем этапам договора">' +
                    result['counts'][0].cntAv + "</span>" :
                    "";
                cntZayv = checkVal(result['counts'][0].cntZayv) ?
                    '<span class="badge badge-count" data-toggle="tooltip" title="Все заявки на оборудование по договору">' +
                    result['counts'][0].cntZayv + "</span>" :
                    "";
                cntFiles = checkVal(result['counts'][0].cntFiles) ?
                    '<span class="badge badge-count" data-toggle="tooltip" title="Все прикрепленные файлы к договору">' +
                    result['counts'][0].cntFiles + "</span>" :
                    "";
                $("span.main-tab2.itemCnt").html(cntStages);
                $("span.main-tab4.itemCnt").html(cntFiles);
                $("span.main-tab5.itemCnt").html(cntChf);
                $("span.main-tab2-1.itemCnt").html(cntStages);
                $("span.main-tab2-2.itemCnt").html(cntAv);
                $("span.main-tab2-3.itemCnt").html(cntChf);
                $("span.main-tab6.itemCnt").html(cntSubs);
                $("span.main-tab7.itemCnt").html(cntZayv);
            }
        }, 100);
        setTimeout(function() {
            $(function() {
                $('#main-tabs-menu *[data-toggle="tooltip"]').tooltip({
                    html: true,
                    trigger: 'hover',
                    placement: 'top',
                });
            })
        }, 200);
    });
    // Callback handler that will be called on failure
    request.fail(function(jqXHR, textStatus, errorThrown) {
        console.error("The following error occurred: " + textStatus, errorThrown);
    });
    // Callback handler that will be called regardless
    // if the request_addItem failed or succeeded
    request.always(function() {});
}


// **
// **
// **
// **
// ** ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- **
</script>

<style>
#doc-details-tabs-menu li span.itemCnt,
#main-tabs-menu li span.itemCnt {
    position: absolute;
    margin-left: 4px;
    top: -4px;
    right: 3px;
    float: right;
}

#doc-details-tabs-menu li a,
#main-tabs-menu li a {
    float: left;
}

#main-tabs-menu li span.badge.badge-count {
    background-color: transparent;
    color: #F00000;
    font-size: 0.9rem;
    font-weight: 200;
    padding: 3px 2px;
}

#doc-details-tabs-menu li span.badge.badge-count,
#doc-details-tabs-menu li.active span.badge.badge-count {
    background-color: transparent;
    color: #111111;
    font-size: 0.9rem;
    font-weight: 200;
    padding: 3px 2px;
}

#doc-details-tabs-menu li span.badge.badge-count {
    color: #FFFFFF;
}

#doc-details-tabs-menu li a:hover+span>span.badge.badge-count,
#doc-details-tabs-menu li a:hover~span>span.badge.badge-count {
    color: #111111;
}

#main-tabs-menu .tooltip-inner {
    min-width: 300px;
    max-width: 300px;
    padding: 3px 8px;
    color: #fff;
    text-align: center;
    background-color: #000;
    border-radius: .25rem;
}

*[data-toggle='tooltip']:hover {
    cursor: help;
}
</style>

<div class="container">
    <div class="row common-top-block">
        <?php include $_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/dognet-topblock.php"; ?>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <?php include "dognet-chetview-details(restr_3)-main.php"; ?>
        </div>
        <div class="space20"></div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div id="main-tabs">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <ul id="main-tabs-menu" class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-1" title="">Основные</a></li>
                            <li><a data-toggle="tab" href="#tab-2" title="">Выполнение и оплата</a><span
                                      class="main-tab2 itemCnt"></span></li>
                            <li><a data-toggle="tab" href="#tab-4" title="">Документы</a><span
                                      class="main-tab4 itemCnt"></span></li>
                            <li><a data-toggle="tab" href="#tab-5" title="">Задолженность</a><span
                                      class="main-tab5 itemCnt"></span></li>
                            <li><a data-toggle="tab" href="#tab-7" title="">Заявки</a><span
                                      class="main-tab7 itemCnt"></span></li>
                            <li><a data-toggle="tab" href="#tab-8" title="">Отгрузка</a></li>
                            <li><a data-toggle="tab" href="#tab-9" title="">Акты</a></li>
                            <li style="float:right"><a href="dognet-chetview.php?chetview_type=current"
                                   title="В список текущих договоров"><span
                                          class="glyphicon glyphicon-th-list"></span></a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane fade in active">
                                <?php include "tabs/dognet-chetview-details(restr_3)-tab1.php"; ?>
                            </div>
                            <div id="tab-2" class="tab-pane fade">
                                <?php include "tabs/dognet-chetview-details(restr_3)-tab2.php"; ?>
                            </div>
                            <div id="tab-4" class="tab-pane fade">
                                <?php include "tabs/dognet-chetview-details(restr_3)-tab4.php"; ?>
                            </div>
                            <div id="tab-5" class="tab-pane fade">
                                <?php include "tabs/dognet-chetview-details(restr_3)-tab5_zadolg.php"; ?>
                            </div>
                            <div id="tab-7" class="tab-pane fade">
                                <?php include "tabs/dognet-chetview-details(restr_3)-tab7.php"; ?>
                            </div>
                            <div id="tab-8" class="tab-pane fade">
                                <?php include "tabs/dognet-chetview-details(restr_3)-tab8_paperotgr.php"; ?>
                            </div>
                            <div id="tab-9" class="tab-pane fade">
                                <?php include "tabs/dognet-chetview-details(restr_3)-tab9_paperacts.php"; ?>
                            </div>
                        </div>
                    </div>
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
ajaxReq_tab_countRecords("<?php echo $_GET['uniqueID']; ?>", urlAjax_tab_countRecords,
    "tab_countRecords");
</script>