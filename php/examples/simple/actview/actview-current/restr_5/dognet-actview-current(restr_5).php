<?php
date_default_timezone_set('Europe/Moscow');

	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);

	$__title = 'Договор';
	$__subtitle = "Выходные документы";
	$__subsubtitle = "Акты выполненных работ";

// Делаем запись в системный лог
// Все параметры в таблице portal_log_messages
	PORTAL_SYSLOG('99943000', '0000000', null, $_GET['actview_type'], $__subsubtitle, null);

?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/actview/actview-current/restr_5/css/actview-current-common-tables.css">

<style>
	#actview-tabs .nav > li > a { color:#666 }
	#actview-tabs .nav > li > a:focus, #actview-tabs .nav > li > a:hover { background-color:transparent; }
	#actview-tabs .nav-tabs > li.active > a, #actview-tabs .nav-tabs > li > a:hover { color: #336a86 !important; }
	#actview-tabs .nav-tabs > li > a::after { background:#f1f1f1 }
	#actview-tabs > ul > li > a { font-family: 'Play', sans-serif }

/* Изменено 20.06.2019 --- */
	#actview-tabs-menu {
		margin-bottom:10px;
		padding: 10px;
		border: 2px #336a86 solid;
		border-radius: 10px;
	}
	#actview-tabs-menu > li > a::after {
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
	#actview-tabs-menu > li.active > a::after, #actview-tabs-menu > li:hover > a::after {
		transform: scale(1);
	}
</style>


	<div class="container">
		<div class="row common-top-block">
			<?php include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/dognet-topblock.php")?>
		</div>
		<div class="row common-content-block">
			<div class="col-xs-12 col-sm-12 col-md-12 сol-lg-12">
				<div id="actview-tabs">
					<ul id="actview-tabs-menu" class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#actview-tab-1" title="">Договора</a></li>
						<li><a data-toggle="tab" href="#actview-tab-2" title="">Журнал актов</a></li>
						<li><a data-toggle="tab" href="#actview-tab-3" title="">Журнал писем</a></li>
					</ul>
					<div class="tab-content">
						<div id="actview-tab-1" class="tab-pane fade in active">
							<div class="col-xs-12 col-sm-12 col-md-12 сol-lg-12">
								<?php include("tabs/dognet-actview(restr_5)-tab1_docs.php"); ?>
							</div>
						</div>
						<div id="actview-tab-2" class="tab-pane fade">
							<div class="col-xs-12 col-sm-12 col-md-12 сol-lg-12">
								<?php include("tabs/dognet-actview(restr_5)-tab2_log.php"); ?>
							</div>
						</div>
						<div id="actview-tab-3" class="tab-pane fade">
							<div class="col-xs-12 col-sm-12 col-md-12 сol-lg-12">
								<?php include("tabs/dognet-actview(restr_5)-tab3_log.php"); ?>
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
// 	document.getElementById("subsubtitle").innerHTML = subsubtitle;
	document.getElementById("dognet-subsubtitle").innerHTML = subsubtitle;
</script>
