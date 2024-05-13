<?php
date_default_timezone_set('Europe/Moscow');

	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);

	$__title = 'Договор';
	$__subtitle = "Текущие документы";
	$__subsubtitle = "Карточка договора";

if ( isset($_GET['uniqueID']) ) { $_SESSION['uniqueID'] = $_GET['uniqueID']; }
?>

<style>
	div.jumbotron { padding-left:20px; padding-right:20px; }
	div.jumbotron a.close { padding-left:20px; padding-right:20px; }
	.jumbotron h1, .jumbotron p { font-family: 'Oswald', sans-serif; }
	.jumbotron h1 { font-size:3.0em; font-weight:400; }
	.jumbotron p { font-size:1.3em; font-weight:200; line-height:normal; }
	#main-tabs .nav > li > a { color:#ccc; }
	#main-tabs .nav > li > a:focus, #main-tabs .nav > li > a:hover { background-color:transparent; }
	#main-tabs .nav-tabs > li.active > a, #main-tabs .nav-tabs > li > a:hover { color: #336a86 !important; }

	#main-tabs > div.row > div > ul > li > a { font-family: 'Play', sans-serif }
</style>


	<div class="container">
		<div class="row" style="margin-top:20px">
			<?php include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/dognet-topblock.php")?>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">
			<?php include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/_fixes-updates/dognet_fixes-updates.php"); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">
				<?php include("dognet-docview-details(restr_2)-main.php"); ?>
			</div>
			<div class="space20"></div>
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div id="main-tabs">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12">
							<ul class="nav nav-tabs">
								<li class="active"><a data-toggle="tab" href="#tab-1" title="">Основные</a></li>
								<li><a data-toggle="tab" href="#tab-2" title="">Выполнение и оплата</a></li>
								<li><a data-toggle="tab" href="#tab-3" title="">Затраты</a></li>
								<li><a data-toggle="tab" href="#tab-4" title="">Документы</a></li>
								<li><a data-toggle="tab" href="#tab-5" title="">Отгрузка</a></li>
								<li><a data-toggle="tab" href="#tab-6" title="">Субподрядчики</a></li>
								<li><a data-toggle="tab" href="#tab-7" title="">Заявки</a></li>
								<li><a data-toggle="tab" href="#tab-8" title="">Задолженность</a></li>
								<li><a data-toggle="tab" href="#tab-9" title="">Акты</a></li>
							</ul>
							<div class="tab-content">
								<div id="tab-1" class="tab-pane fade in active">
									<?php
										include("tabs/dognet-docview-details(restr_2)-tab1_common.php");
										include("tabs/dognet-docview-details(restr_2)-tab1_ispolniteli.php");
										include("tabs/dognet-docview-details(restr_2)-tab1_finances.php");
										include("tabs/dognet-docview-details(restr_2)-tab1_zakazchik.php");
										include("tabs/dognet-docview-details(restr_2)-tab1_kalplans.php");
										include("tabs/dognet-docview-details(restr_2)-tab1_comments.php");
									?>

									<div class="space10"></div>
									<div class="row">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<?php // include('atgs-portal_main_bottom-area.php'); ?>
											<?php include($_SERVER['DOCUMENT_ROOT']."/dognet/_assets/includes/dognet_current-bottom-legend.php"); ?>
										</div>
									</div>

								</div>
								<div id="tab-2" class="tab-pane fade">
									<?php include("tabs/dognet-docview-details(restr_2)-tab2_oplata.php"); ?>

									<div class="space10"></div>
									<div class="row">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<?php // include('atgs-portal_main_bottom-area.php'); ?>
											<?php include($_SERVER['DOCUMENT_ROOT']."/dognet/_assets/includes/dognet_current-bottom-legend.php"); ?>
										</div>
									</div>

								</div>
								<div id="tab-3" class="tab-pane fade">
									<?php include("tabs/dognet-docview-details(restr_2)-tab3_zatraty.php"); ?>

									<div class="space10"></div>
									<div class="row">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<?php // include('atgs-portal_main_bottom-area.php'); ?>
											<?php include($_SERVER['DOCUMENT_ROOT']."/dognet/_assets/includes/dognet_current-bottom-legend.php"); ?>
										</div>
									</div>

								</div>
								<div id="tab-4" class="tab-pane fade">
									<?php include("tabs/dognet-docview-details(restr_2)-tab4.php"); ?>

									<div class="space10"></div>
									<div class="row">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<?php // include('atgs-portal_main_bottom-area.php'); ?>
											<?php include($_SERVER['DOCUMENT_ROOT']."/dognet/_assets/includes/dognet_current-bottom-legend.php"); ?>
										</div>
									</div>

								</div>
								<div id="tab-5" class="tab-pane fade">
									<?php include("tabs/message_section-underconstruction.php"); ?>
								</div>
								<div id="tab-6" class="tab-pane fade">
									<?php include("tabs/message_section-underconstruction.php"); ?>
								</div>
								<div id="tab-7" class="tab-pane fade">
									<?php include("tabs/message_section-underconstruction.php"); ?>
								</div>
								<div id="tab-8" class="tab-pane fade">
									<?php include("tabs/message_section-underconstruction.php"); ?>
								</div>
								<div id="tab-9" class="tab-pane fade">
									<?php include("tabs/message_section-underconstruction.php"); ?>
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
	document.getElementById("subsubtitle").innerHTML = subsubtitle;
</script>
