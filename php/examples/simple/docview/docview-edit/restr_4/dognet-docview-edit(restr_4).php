<?php
date_default_timezone_set('Europe/Moscow');

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$__title = 'Договор';
$__subtitle = "Работа с договором";
$__subsubtitle = "Редактирование";

require($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/docview/docview-edit/dognet-docview-edit-functions.inc.php");

if (isset($_GET['uniqueID'])) {
	$_SESSION['uniqueID'] = $_GET['uniqueID'];
}
?>

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
    color: #666
}

#main-tabs .nav>li>span {
    color: #951402
}

#main-tabs .nav>li>a:focus,
#main-tabs .nav>li>a:hover {
    background-color: transparent;
}

#main-tabs .nav-tabs>li.active>a,
#main-tabs .nav-tabs>li>a:hover,
#main-tabs .nav-tabs>li.active>span,
#main-tabs .nav-tabs>li:hover>span {
    color: #fff !important;
}

#main-tabs .nav-tabs>li>a::after {
    background: #951402
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
    /* 		border: 2px #336a86 solid; */
    border: 2px #951402 solid;
    border-radius: 6px;
}

#main-tabs-menu>li>a::after {
    content: "";
    background: #951402;
    height: 40px;
    z-index: -1;
    position: absolute;
    width: 100%;
    left: 0px;
    bottom: -1px;
    transition: all 250ms ease 0s;
    transform: scale(0);
}

#main-tabs-menu>li>span::after {
    content: "";
    background: #951402;
    z-index: -1;
    position: absolute;
    width: 100%;
    left: 0px;
    bottom: -1px;
    transition: all 250ms ease 0s;
    transform: scale(0);
}

#main-tabs-menu>li.active>a::after,
#main-tabs-menu>li:hover>a::after,
#main-tabs-menu>li.active>span::after {
    transform: scale(1);
}

/* --- Изменено 20.06.2019 */

#stg_newitems_cnt {
    position: absolute;
    right: 5px;
    top: -3px;
    font-weight: 500
}

#chf_newitems_cnt {
    position: absolute;
    right: 5px;
    top: -3px;
    font-weight: 500
}

#avn_newitems_cnt {
    position: absolute;
    right: 5px;
    top: -3px;
    font-weight: 500
}

#sub_newitems_cnt {
    position: absolute;
    right: 5px;
    top: -3px;
    font-weight: 500
}

#doc_newitems_cnt {
    position: absolute;
    right: 5px;
    top: -3px;
    font-weight: 500
}

#con_newitems_cnt {
    position: absolute;
    right: 5px;
    top: -3px;
    font-weight: 500
}
</style>


<div class="container">
    <div class="row common-top-block">
        <?php include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/dognet-topblock.php") ?>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <?php
			if ($_SESSION['id'] != '999' && $_SESSION['login'] != 'yachugunov') {
				include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/updates/dognet-updates.php");
			} else {
				include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/updates/dognet-updates-test.php");
			}
			?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <?php include("dognet-docview-edit(restr_4)-main.php"); ?>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div id="main-tabs">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <ul id="main-tabs-menu" class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-1" title="">Договор</a></li>
                            <li><span id="stg_newitems_cnt"></span><a data-toggle="tab" href="#tab-2"
                                   title="">Календарный план</a></li>
                            <li><span id="chf_newitems_cnt"></span><a data-toggle="tab" href="#tab-3"
                                   title="">Счета-фактуры</a></li>
                            <li><span id="avn_newitems_cnt"></span><a data-toggle="tab" href="#tab-4"
                                   title="">Авансы</a></li>
                            <li><span id="sub_newitems_cnt"></span><a data-toggle="tab" href="#tab-5"
                                   title="">Субподряд</a></li>
                            <li><span id="doc_newitems_cnt"></span><a data-toggle="tab" href="#tab-6" title="">Документы
                                    по договору</a></li>
                            <li><span id="con_newitems_cnt"></span><a data-toggle="tab" href="#tab-8"
                                   title="">Контакты</a></li>
                            <li style="float:right"><a
                                   href="dognet-docview.php?docview_type=details&uniqueID=<?php echo $_GET['uniqueID']; ?>"
                                   title=""><span class="glyphicon glyphicon-list-alt"></span></a></li>
                            <li style="float:right"><a
                                   href="dognet-docview.php?docview_type=details&uniqueID=<?php echo $_GET['uniqueID']; ?>&action=unlock"
                                   title=""><span class="glyphicon glyphicon-lock"></span></a></li>
                            <li style="float:right"><a data-toggle="tab" href="#tab-7" title=""><span
                                          class="glyphicon glyphicon-menu-hamburger"></span></a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane fade in active">
                                <?php include("tabs/dognet-docview-edit(restr_4)-tab1_dogovor.php"); ?>
                            </div>
                            <div id="tab-2" class="tab-pane fade">
                                <?php include("tabs/dognet-docview-edit(restr_4)-tab2_kalplans.php"); ?>
                                <div class="space10"></div>
                            </div>
                            <div id="tab-3" class="tab-pane fade">
                                <?php include("tabs/dognet-docview-edit(restr_4)-tab3_kalplanchf.php"); ?>
                                <div class="space10"></div>
                            </div>
                            <div id="tab-4" class="tab-pane fade">
                                <?php include("tabs/dognet-docview-edit(restr_4)-tab4_avans.php"); ?>
                                <div class="space10"></div>
                            </div>
                            <div id="tab-5" class="tab-pane fade">
                                <?php include("tabs/dognet-docview-edit(restr_4)-tab5_subpodr.php"); ?>
                                <div class="space10"></div>
                            </div>
                            <div id="tab-6" class="tab-pane fade">
                                <?php include("tabs/dognet-docview-edit(restr_4)-tab6_files.php"); ?>
                                <div class="space10"></div>
                            </div>
                            <div id="tab-7" class="tab-pane fade">
                                <?php include("tabs/dognet-docview-edit(restr_4)-tab7_log.php"); ?>
                                <div class="space10"></div>
                            </div>
                            <div id="tab-8" class="tab-pane fade">
                                <?php
								// include("tabs/message_section-underconstruction.php"); 
								include("tabs/dognet-docview-edit(restr_4)-tab8_contact.php");
								?>
                                <div class="space10"></div>
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
$("#dognet-subsubtitle").attr("class", "text-danger");
</script>