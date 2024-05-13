<?php
date_default_timezone_set('Europe/Moscow');

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$__title = 'Договор';
$__subtitle = "Работа со счетом";
$__subsubtitle = "Карточка счета";

require($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/chetview/chetview-details/dognet-chetview-details-functions.inc.php");

if ( isset($_GET['uniqueID']) ) { $_SESSION['uniqueID'] = $_GET['uniqueID']; }
?>

<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/date-de.js"></script>
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/moment-with-locales.js"></script>
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/filterByText.js"></script>

<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/chetview/chetview-details/restr_5/tabs/css/chetview-details-common-tabs.css">

	<div class="container">
		<div class="row common-top-block">
			<?php include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/dognet-topblock.php")?>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">
				<?php include("dognet-chetview-details(restr_5)-main.php"); ?>
			</div>
			<div class="space20"></div>
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div id="main-tabs">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12">
							<ul id="main-tabs-menu" class="nav nav-tabs">
								<li class="active"><a data-toggle="tab" href="#tab-1" title="">Основные</a></li>
								<li><a data-toggle="tab" href="#tab-2" title="">Выполнение и оплата</a></li>
								<li><a data-toggle="tab" href="#tab-4" title="">Документы</a></li>
								<li><a data-toggle="tab" href="#tab-5" title="">Задолженность</a></li>
								<li><a data-toggle="tab" href="#tab-7" title="">Заявки</a></li>
								<li><a data-toggle="tab" href="#tab-8" title="">Отгрузка</a></li>
								<li><a data-toggle="tab" href="#tab-9" title="">Акты</a></li>
								<li style="float:right"><a href="dognet-chetview.php?chetview_type=edit&uniqueID=<?php echo $_GET['uniqueID']; ?>" title=""><span class="glyphicon glyphicon-pencil"></span></a></li>
							</ul>
							<div class="tab-content">
								<div id="tab-1" class="tab-pane fade in active">
									<?php include("tabs/dognet-chetview-details(restr_5)-tab1.php"); ?>
								</div>
								<div id="tab-2" class="tab-pane fade">
									<?php include("tabs/dognet-chetview-details(restr_5)-tab2.php"); ?>
								</div>
								<div id="tab-4" class="tab-pane fade">
									<?php include("tabs/dognet-chetview-details(restr_5)-tab4.php"); ?>
								</div>
								<div id="tab-5" class="tab-pane fade">
									<?php include("tabs/dognet-chetview-details(restr_5)-tab5_zadolg.php"); ?>
								</div>
								<div id="tab-7" class="tab-pane fade">
									<?php include("tabs/dognet-chetview-details(restr_5)-tab7.php"); ?>
								</div>
								<div id="tab-8" class="tab-pane fade">
									<?php include("tabs/dognet-chetview-details(restr_5)-tab8_paperotgr.php"); ?>
								</div>
								<div id="tab-9" class="tab-pane fade">
									<?php include("tabs/dognet-chetview-details(restr_5)-tab9_paperacts.php"); ?>
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
</script>
