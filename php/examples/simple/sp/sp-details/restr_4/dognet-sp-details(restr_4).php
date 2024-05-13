
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/date-de.js"></script>
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/moment-with-locales.js"></script>

<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/sp/sp-details/restr_4/tabs/css/sp-details-common-tables.css">
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/sp/sp-details/restr_4/tabs/css/sp-details-common-customForm.css">

<?php
date_default_timezone_set('Europe/Moscow');

	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);

	$__title = 'Договор';
	$__subtitle = "Справочная информация";
	$__subsubtitle = "";

if ( isset($_GET['uniqueID']) ) { $_SESSION['uniqueID'] = $_GET['uniqueID']; }
?>

<style>
	#main-tabs .nav > li > a { color:#666 }
	#main-tabs .nav > li > a:focus, #main-tabs .nav > li > a:hover { background-color:transparent; }
	#main-tabs .nav-tabs > li.active > a, #main-tabs .nav-tabs > li > a:hover { color: #336a86 !important; }
	#main-tabs .nav-tabs > li > a::after { background:#f1f1f1 }
	#main-tabs > div.row > div > ul > li > a { font-family: 'Play', sans-serif }
/* Изменено 20.06.2019 --- */
	#main-tabs-menu { border-bottom:none; padding:10px; border:2px #336a86 solid; border-radius:10px; margin-bottom:20px }
	#main-tabs-menu > li > a::after { content:""; background:#f1f1f1; height:40px; z-index:-1; position:absolute; width:100%; left:0px; bottom:-1px; transition:all 250ms ease 0s; transform:scale(0) }
	#main-tabs-menu > li.active > a::after, #main-tabs-menu > li:hover > a::after { transform:scale(1) }
</style>


	<div class="container">
		<div class="row common-top-block">
			<?php include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/dognet-topblock.php")?>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">
			<?php include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/_fixes-updates/dognet_fixes-updates.php"); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div id="main-tabs">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12">
							<ul id="main-tabs-menu" class="nav nav-tabs">
								<li id="tab-1-link"class="active"><a data-toggle="tab" href="#tab-1" title="">Заказчики</a></li>
								<li id="tab-8-link"><a data-toggle="tab" href="#tab-8" title="">Контакты</a></li>
								<li id="tab-2-link"><a data-toggle="tab" href="#tab-2" title="">Cубподрядчики</a></li>
								<li id="tab-3-link"><a data-toggle="tab" href="#tab-3" title="">Объекты</a></li>
								<li id="tab-4-link"><a data-toggle="tab" href="#tab-4" title="">Исполнители</a></li>
								<li id="tab-5-link"><a data-toggle="tab" href="#tab-5" title="">Руководство</a></li>
							</ul>
							<div class="tab-content">
								<div id="tab-1" class="tab-pane fade in active">
									<?php include("tabs/dognet-sp-details(restr_4)-tab1_zakazchiki.php"); ?>
								</div>
								<div id="tab-8" class="tab-pane fade">
									<?php include("tabs/dognet-sp-details(restr_4)-tab8_contact.php"); ?>
								</div>
								<div id="tab-2" class="tab-pane fade">
									<?php include("tabs/dognet-sp-details(restr_4)-tab2_subpodr.php"); ?>
								</div>
								<div id="tab-3" class="tab-pane fade">
									<?php include("tabs/dognet-sp-details(restr_4)-tab3_objects.php"); ?>
								</div>
								<div id="tab-4" class="tab-pane fade">
									<?php include("tabs/dognet-sp-details(restr_4)-tab4_ispolniteli.php"); ?>
								</div>
								<div id="tab-5" class="tab-pane fade">
									<?php include("tabs/dognet-sp-details(restr_4)-tab5_ispolniteliruk.php"); ?>
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
	document.getElementById("subtitle").innerHTML = subtitle;
	document.getElementById("dognet-subsubtitle").innerHTML = "Заказчики";
	$('#tab-1-link').on( 'click', function () {
		document.getElementById("dognet-subsubtitle").innerHTML = "Заказчики";
	} );
	$('#tab-2-link').on( 'click', function () {
		document.getElementById("dognet-subsubtitle").innerHTML = "Субподрядчики";
	} );
	$('#tab-3-link').on( 'click', function () {
		document.getElementById("dognet-subsubtitle").innerHTML = "Объекты";
	} );
	$('#tab-4-link').on( 'click', function () {
		document.getElementById("dognet-subsubtitle").innerHTML = "Исполнители";
	} );
	$('#tab-5-link').on( 'click', function () {
		document.getElementById("dognet-subsubtitle").innerHTML = "Руководство";
	} );
	$('#tab-8-link').on( 'click', function () {
		document.getElementById("dognet-subsubtitle").innerHTML = "Контакты";
	} );
</script>
