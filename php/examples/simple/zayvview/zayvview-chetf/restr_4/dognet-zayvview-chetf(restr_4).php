<?php
date_default_timezone_set('Europe/Moscow');

	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);

	$__title = 'Договор';
	$__subtitle = "Заявки и счета";
	$__subsubtitle = "Работа со счетами-фактурами";

// 		PORTAL_SYSLOG('99940000', '0000000', null, null, null, null);

?>

<style>
	div.jumbotron { padding-left:20px; padding-right:20px; }
	div.jumbotron a.close { padding-left:20px; padding-right:20px; }
	.jumbotron h1, .jumbotron p { font-family: 'Oswald', sans-serif; }
	.jumbotron h1 { font-size:3.0em; font-weight:400; }
	.jumbotron p { font-size:1.3em; font-weight:200; line-height:normal; }
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
								<li id="link-to-tab1" class="active"><a data-toggle="tab" href="#tab-1" title="">Счета-фактуры <?php echo (date("Y")-1)."-".date("Y"); ?></a></li>
								<li id="link-to-tab2"><a data-toggle="tab" href="#tab-2" title="">Перенос счета-фактуры</a></li>
								<li id="link-to-tab3" style="float:right"><a data-toggle="tab" href="#tab-3" title="">Архив счетов-фактур</a></li>
							</ul>
							<div class="tab-content">
<?php include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/zayvview/zayvview-chetf/restr_4/dognet-zayvview-chetf(restr_4)-main.php")?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<?php // include($_SERVER['DOCUMENT_ROOT']."/dognet/_assets/includes/dognet_chet-bottom-legend.php"); ?>
			</div>
		</div>

	</div>

	<div class="space100"></div>

<script type="text/javascript">
	subtitle = '<?php echo $__subtitle; ?>';
	subsubtitle = '<?php echo $__subsubtitle; ?>';
	document.getElementById("subtitle").innerHTML = subtitle;
	document.getElementById("dognet-subsubtitle").innerHTML = subsubtitle;
</script>
