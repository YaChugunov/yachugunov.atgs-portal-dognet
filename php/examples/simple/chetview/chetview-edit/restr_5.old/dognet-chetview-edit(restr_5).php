<?php
date_default_timezone_set('Europe/Moscow');

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$__title = 'Договор';
$__subtitle = "Работа со счетом";
$__subsubtitle = "Редактирование";

require($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/chetview/chetview-edit/dognet-chetview-edit-functions.inc.php");

if ( isset($_GET['uniqueID']) ) { $_SESSION['uniqueID'] = $_GET['uniqueID']; }
?>

<style>
	div.jumbotron { padding-left:20px; padding-right:20px; }
	div.jumbotron a.close { padding-left:20px; padding-right:20px; }
	.jumbotron h1, .jumbotron p { font-family: 'Oswald', sans-serif; }
	.jumbotron h1 { font-size:3.0em; font-weight:400; }
	.jumbotron p { font-size:1.3em; font-weight:200; line-height:normal; }

	#main-tabs .nav > li > a { color:#666 }
	#main-tabs .nav > li > a:focus, #main-tabs .nav > li > a:hover { background-color:transparent; }
	#main-tabs .nav-tabs > li.active > a, #main-tabs .nav-tabs > li > a:hover { color: #fff !important; }
	#main-tabs .nav-tabs > li > a::after { background:#951402 }
	#main-tabs > div.row > div > ul > li > a { font-family: 'Play', sans-serif }

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
	#main-tabs-menu > li > a::after {
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
	#main-tabs-menu > li.active > a::after, #main-tabs-menu > li:hover > a::after {
		transform: scale(1);
	}
/* --- Изменено 20.06.2019 */


</style>


	<div class="container">
		<div class="row" style="margin-top:20px">
			<?php include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/dognet-topblock.php")?>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">
				<?php include("dognet-chetview-edit(restr_5)-main.php"); ?>
			</div>
			<div class="space20"></div>
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div id="main-tabs">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12">
							<ul id="main-tabs-menu" class="nav nav-tabs">
								<li class="active"><a data-toggle="tab" href="#tab-1" title="">счет</a></li>
<!-- 								<li><a data-toggle="tab" href="#tab-2" title="">Календарный план</a></li> -->
								<li><a data-toggle="tab" href="#tab-3" title="">Счета-фактуры</a></li>
								<li><a data-toggle="tab" href="#tab-4" title="">Авансы</a></li>
<!-- 								<li><a data-toggle="tab" href="#tab-5" title="">Субподряд</a></li> -->
								<li><a data-toggle="tab" href="#tab-6" title="">Документы по счету</a></li>
								<li><a data-toggle="tab" href="#tab-7" title="">Контакты</a></li>
								<li style="float:right"><a href="dognet-chetview.php?chetview_type=details&uniqueID=<?php echo $_GET['uniqueID']; ?>" title=""><span class="glyphicon glyphicon-list-alt"></span></a></li>
								<li style="float:right"><a href="dognet-chetview.php?chetview_type=details&uniqueID=<?php echo $_GET['uniqueID']; ?>&action=unlock" title=""><span class="glyphicon glyphicon-lock"></span></a></li>
							</ul>
							<div class="tab-content">
								<div id="tab-1" class="tab-pane fade in active">
									<?php include("tabs/dognet-chetview-edit(restr_5)-tab1_chet.php"); ?>
								</div>
								<div id="tab-2" class="tab-pane fade">
									<?php // include("tabs/dognet-chetview-edit(restr_5)-tab2_kalplans.php"); ?>
									<div class="space10"></div>
								</div>
								<div id="tab-3" class="tab-pane fade">
									<?php include("tabs/dognet-chetview-edit(restr_5)-tab3_kalplanchf.php"); ?>
									<div class="space10"></div>
								</div>
								<div id="tab-4" class="tab-pane fade">
									<?php include("tabs/dognet-chetview-edit(restr_5)-tab4_avans.php"); ?>
									<div class="space10"></div>
								</div>
								<div id="tab-5" class="tab-pane fade">
									<?php include("tabs/dognet-chetview-edit(restr_5)-tab5_subpodr.php"); ?>
									<div class="space10"></div>
								</div>
								<div id="tab-6" class="tab-pane fade">
									<?php include("tabs/dognet-chetview-edit(restr_5)-tab6_files.php"); ?>
									<div class="space10"></div>
								</div>
								<div id="tab-7" class="tab-pane fade">
									<?php include("tabs/message_section-underconstruction.php"); ?>
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
