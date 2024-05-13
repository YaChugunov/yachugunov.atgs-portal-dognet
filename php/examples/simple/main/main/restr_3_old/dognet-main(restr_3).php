<?php
date_default_timezone_set('Europe/Moscow');

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$__title = 'Договор';
$__subtitle = "Главная страница";
$__subsubtitle = "";

if (isset($_GET['uniqueID'])) {
	$_SESSION['uniqueID'] = $_GET['uniqueID'];
}

require($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/main/main/dognet-main-functions.inc.php");

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

	#main-tabs .nav>li>a:focus,
	#main-tabs .nav>li>a:hover {
		background-color: transparent;
	}

	#main-tabs .nav-tabs>li.active>a,
	#main-tabs .nav-tabs>li>a:hover {
		color: #336a86 !important;
	}

	#main-tabs .nav-tabs>li>a::after {
		background: #f1f1f1
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
		border: 2px #336a86 solid;
		border-radius: 10px;
	}

	#main-tabs-menu>li>a::after {
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

	#main-tabs-menu>li.active>a::after,
	#main-tabs-menu>li:hover>a::after {
		transform: scale(1);
	}

	/* --- Изменено 20.06.2019 */

	#admin-anounce {
		padding: 10px 30px
	}

	.admin-anounce-block {
		/*
		padding:10px;
		border:2px solid #f0ad4e;
		border-radius:5px;
	*/
	}

	.admin-anounce-block p {
		color: #333;
		font-family: 'HeliosCond', sans-serif;
		font-size: 1.2em;
		font-weight: 200;
		line-height: 1.5em;
	}

	.admin-anounce-block p.text-warning {
		color: #f0ad4e;
	}

	#admin-anounce .block h3 {
		font-family: 'Oswald', sans-serif;
		font-size: 2.0em;
		font-weight: 500;
		text-transform: uppercase;
		letter-spacing: 0.1em
	}

	#admin-anounce blockquote {
		border: none;
		font-style: italic;
		text-align: justify
	}
</style>





<?php
$_QRY_MAILING_ENBL = mysqlQuery("SELECT dognet_mailing_enbl FROM users WHERE id=" . $_SESSION['id']);
$_ROW_MAILING_ENBL = mysqli_fetch_assoc($_QRY_MAILING_ENBL);
if ($_ROW_MAILING_ENBL['dognet_mailing_enbl'] == 0) {
	// include($_SERVER['DOCUMENT_ROOT']."/dognet/_assets/includes/subscribe_handler/dognetNewsletter-subscribe-popup-onload-window.php");
}
?>







<div class="container">
	<div class="row common-top-block">
		<?php include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/dognet-topblock.php") ?>
	</div>
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div id="main-tabs">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12">
						<ul id="main-tabs-menu" class="nav nav-tabs">
							<li id="tab-1-link" class="active"><a data-toggle="tab" href="#tab-1" title="">Работа ГИПа</a></li>
							<li id="tab-2-link"><a data-toggle="tab" href="#tab-2" title="">Флажки</a></li>
							<li id="tab-5-link"><a data-toggle="tab" href="#tab-5" title="">Графики</a></li>
						</ul>
						<div class="tab-content">
							<div id="tab-1" class="tab-pane fade in active">
								<?php include("tabs/dognet-main(restr_3)-tab1.php"); ?>
							</div>
							<div id="tab-2" class="tab-pane fade">
								<?php include("tabs/dognet-main(restr_3)-tab2.php"); ?>
							</div>
							<div id="tab-5" class="tab-pane fade">
								<?php include("tabs/dognet-main(restr_3)-tab5.php"); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--
			<div class="col-xs-hidden col-sm-hidden col-md-4 col-lg-3">
				<?php // include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/dognet-portal_log.php")
				?>
			</div>
-->
	</div>

</div>

<div class="space100"></div>

<script type="text/javascript">
	subtitle = '<?php echo $__subtitle; ?>';
	document.getElementById("subtitle").innerHTML = subtitle;
	document.getElementById("dognet-subsubtitle").innerHTML = "Работа ГИПа";
	$('#tab-1-link').on('click', function() {
		document.getElementById("dognet-subsubtitle").innerHTML = "События";
	});
	$('#tab-2-link').on('click', function() {
		document.getElementById("dognet-subsubtitle").innerHTML = "Флажки";
	});
	$('#tab-3-link').on('click', function() {
		document.getElementById("dognet-subsubtitle").innerHTML = "Заявки";
	});
	$('#tab-4-link').on('click', function() {
		document.getElementById("dognet-subsubtitle").innerHTML = "Отгрузки";
	});
	$('#tab-5-link').on('click', function() {
		document.getElementById("dognet-subsubtitle").innerHTML = "Графики";
	});
</script>