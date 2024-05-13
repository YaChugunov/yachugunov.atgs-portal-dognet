
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/date-de.js"></script>
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/moment-with-locales.js"></script>
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/filterByText.js"></script>

<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/zayvsp/zayvsp-details/restr_4/tabs/css/zayvsp-details-common-tables.css">
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/zayvsp/zayvsp-details/restr_4/tabs/css/zayvsp-details-common-customForm.css">

<?php
date_default_timezone_set('Europe/Moscow');

	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);

	$__title = 'Договор';
	$__subtitle = "Справочники";
	$__subsubtitle = "";

if ( isset($_GET['uniqueID']) ) { $_SESSION['uniqueID'] = $_GET['uniqueID']; }
?>

<style>
	#main-tabs .nav > li > a { color:#111; }
	#main-tabs .nav > li > a:focus, #main-tabs .nav > li > a:hover { background-color:transparent; }
	#main-tabs .nav-tabs > li.active > a, #main-tabs .nav-tabs > li > a:hover { color: #fff !important; }
	#main-tabs > div.row > div > ul > li > a { font-family: 'Play', sans-serif }
/* Изменено 20.06.2019 --- */
	#main-tabs-menu {
		border-bottom: none;
	}
	#main-tabs-menu {
		padding: 10px;
		border: 2px #f0ad4e solid;
		border-radius: 10px;
	}
	#main-tabs-menu > li > a::after {
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
	#main-tabs-menu > li.active > a::after, #main-tabs-menu > li:hover > a::after {
		transform: scale(1);
	}
/* --- Изменено 20.06.2019 */
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
								<li id="tab-1-link" class="active"><a data-toggle="tab" href="#tab-1" title="">Поставщики</a></li>
							</ul>
							<div class="tab-content">
								<div id="tab-1" class="tab-pane fade in active">
									<?php include("tabs/dognet-zayvsp-details(restr_4)-tab_postav.php"); ?>
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
	document.getElementById("dognet-subsubtitle").innerHTML = "Поставщики";
	$('#tab-1-link').on( 'click', function () {
		document.getElementById("dognet-subsubtitle").innerHTML = "Поставщики";
	} );
	$('#tab-2-link').on( 'click', function () {
		document.getElementById("dognet-subsubtitle").innerHTML = "";
	} );
	$('#tab-3-link').on( 'click', function () {
		document.getElementById("dognet-subsubtitle").innerHTML = "";
	} );
	$('#tab-4-link').on( 'click', function () {
		document.getElementById("dognet-subsubtitle").innerHTML = "";
	} );
	$('#tab-5-link').on( 'click', function () {
		document.getElementById("dognet-subsubtitle").innerHTML = "";
	} );
</script>
