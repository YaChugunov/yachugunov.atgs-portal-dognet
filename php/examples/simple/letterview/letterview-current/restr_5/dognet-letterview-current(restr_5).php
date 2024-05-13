<?php
date_default_timezone_set('Europe/Moscow');

	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);

	$__title = 'Договор';
	$__subtitle = "Выходные документы";
	$__subsubtitle = "Письма должникам";

// Делаем запись в системный лог
// Все параметры в таблице portal_log_messages
	PORTAL_SYSLOG('99944000', '0000000', null, $_GET['letterview_type'], $__subsubtitle, null);

?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/letterview/letterview-current/restr_5/css/letterview-current-common-tables.css">
<style>
	#letterview-tabs .nav > li > a { color:#666 }
	#letterview-tabs .nav > li > a:focus, #letterview-tabs .nav > li > a:hover { background-color:transparent; }
	#letterview-tabs .nav-tabs > li.active > a, #letterview-tabs .nav-tabs > li > a:hover { color: #336a86 !important; }
	#letterview-tabs .nav-tabs > li > a::after { background:#f1f1f1 }
	#letterview-tabs > ul > li > a { font-family: 'Play', sans-serif }

/* Изменено 20.06.2019 --- */
	#letterview-tabs-menu {
		margin-bottom:10px;
		border-bottom: none;
		padding: 10px;
		border: 2px #336a86 solid;
		border-radius: 10px;
	}
	#letterview-tabs-menu > li > a::after {
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
	#letterview-tabs-menu > li.active > a::after, #letterview-tabs-menu > li:hover > a::after {
		transform: scale(1);
	}
</style>


	<div class="container">
		<div class="row common-top-block">
			<?php include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/dognet-topblock.php")?>
		</div>
		<div class="row common-content-block">
			<div class="col-xs-12 col-sm-12 col-md-12 сol-lg-12">
				<div id="letterview-tabs">
					<ul id="letterview-tabs-menu" class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#letterview-tab-2" title="">Журнал писем</a></li>
					</ul>
					<div class="tab-content">
						<div id="letterview-tab-2" class="tab-pane fade in active">
							<div class="col-xs-12 col-sm-12 col-md-12 сol-lg-12">
								<?php include("tabs/dognet-letterview(restr_5)-tab2_log.php"); ?>
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
