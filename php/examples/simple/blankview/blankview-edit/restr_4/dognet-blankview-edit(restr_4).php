<?php
date_default_timezone_set('Europe/Moscow');

	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);

	$__title = 'Договор';
	$__subtitle = "Бланки требований";
	$__subsubtitle = "Работа отдела договоров";
?>

<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/filterByText.js"></script>
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/date-de.js"></script>
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/moment-with-locales.js"></script>

<style>
	#blankview-tabs .nav > li > a { color:#666 }
	#blankview-tabs .nav > li > a:focus, #blankview-tabs .nav > li > a:hover { background-color:transparent; }
	#blankview-tabs .nav-tabs > li.active > a, #blankview-tabs .nav-tabs > li > a:hover { color: #333333 !important; }
	#blankview-tabs .nav-tabs > li > a::after { background:#f1f1f1 }
	#blankview-tabs > ul > li > a { font-family: 'Play', sans-serif }

/* Изменено 20.06.2019 --- */
	#blankview-tabs-menu {
		border-bottom: none;
	}
	#blankview-tabs-menu {
		padding: 10px;
		border: 2px #333333 solid;
		border-radius: 5px;
	}
	#blankview-tabs-menu > li > a::after {
		content: "";
		background: #f1f1f1;
		height: 40px;
		z-index: -1;
		position: absolute;
		width: 100%;
		left: 0px;
		bottom: -1px;
		transition: all 250ms ease 0s;
		transform: scale(0);
	}
	#blankview-tabs-menu > li.active > a::after, #blankview-tabs-menu > li:hover > a::after {
		transform: scale(1);
	}
	#pos_newitems_cnt { position:absolute; right:5px; top:-3px; font-weight:700; color:#951402 }
	#pnr_newitems_cnt { position:absolute; right:5px; top:-3px; font-weight:700; color:#951402 }
	#sub_newitems_cnt { position:absolute; right:5px; top:-3px; font-weight:700; color:#951402 }
	#pir_newitems_cnt { position:absolute; right:5px; top:-3px; font-weight:700; color:#951402 }
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
				<?php // include("dognet-blankview-edit(restr_4)-main.php"); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div id="blankview-tabs">
					<ul id="blankview-tabs-menu" class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#blankview-edit-tab-1" title="">Бланки <span class="glyphicon glyphicon-option-vertical"></span> <?php echo date('Y'); ?></a></li>
						<li><span id="pos_newitems_cnt"></span><a data-toggle="tab" href="#blankview-edit-tab-2" title="">Поставка</a></li>
						<li><span id="pnr_newitems_cnt"></span><a data-toggle="tab" href="#blankview-edit-tab-3" title="">ПНР</a></li>
						<li><span id="sub_newitems_cnt"></span><a data-toggle="tab" href="#blankview-edit-tab-4" title="">Субподряд</a></li>
						<li><span id="pir_newitems_cnt"></span><a data-toggle="tab" href="#blankview-edit-tab-5" title="">ПИР</a></li>
						<li style="float:right"><a data-toggle="tab" href="#blankview-edit-tab-7" title=""><span class="glyphicon glyphicon-flash text-danger" style="margin-right:5px"></span><span class="">Как это работает?</span></a></li>
						<li style="float:right"><a data-toggle="tab" href="#blankview-edit-tab-6" title="">Архив</a></li>
					</ul>
					<div class="tab-content">
						<div id="blankview-edit-tab-1" class="tab-pane fade in active">
								<?php include("tabs/dognet-blankview-edit(restr_4)-tab1_blankwork.php"); ?>
						</div>
						<div id="blankview-edit-tab-2" class="tab-pane fade">
								<?php include("tabs/dognet-blankview-edit(restr_4)-tab2_pos.php"); ?>
						</div>
						<div id="blankview-edit-tab-3" class="tab-pane fade">
								<?php include("tabs/dognet-blankview-edit(restr_4)-tab3_pnr.php"); ?>
						</div>
						<div id="blankview-edit-tab-4" class="tab-pane fade">
								<?php // include("tabs/message_section-underconstruction.php"); ?>
								<?php include("tabs/dognet-blankview-edit(restr_4)-tab4_sub.php"); ?>
						</div>
						<div id="blankview-edit-tab-5" class="tab-pane fade in">
								<?php 
									// include("tabs/message_section-thinkaboutit.php"); 
									include("tabs/dognet-blankview-edit(restr_4)-tab5_pir.php");
								?>
						</div>
						<div id="blankview-edit-tab-6" class="tab-pane fade in">
								<?php include("tabs/dognet-blankview-edit(restr_4)-tab6_blankarchive.php"); ?>
						</div>
						<div id="blankview-edit-tab-7" class="tab-pane fade in">
								<?php include("dognet-blankview-edit(restr_4)-help.php"); ?>
								<?php // include("tabs/message_section-howtodo.php"); ?>
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
</script>
