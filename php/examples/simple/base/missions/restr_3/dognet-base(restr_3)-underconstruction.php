<?php
date_default_timezone_set('Europe/Moscow');

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$__title = 'Договор';
$__subtitle = "Раздел готовится";
$__subsubtitle = "";

?>

<style>
	div.jumbotron { padding-left:20px; padding-right:20px; }
	div.jumbotron a.close { padding-left:20px; padding-right:20px; }
	.jumbotron h1, .jumbotron p { font-family: 'Oswald', sans-serif; }
	.jumbotron h1 { font-size:3.0em; font-weight:400; }
	.jumbotron p { font-size:1.3em; font-weight:200; line-height:normal; }

	#main-tabs .nav > li > a { color:#666 }
	#main-tabs .nav > li > a:focus, #main-tabs .nav > li > a:hover { background-color:transparent; }
	#main-tabs .nav-tabs > li.active > a, #main-tabs .nav-tabs > li > a:hover { color: #336a86 !important; }
	#main-tabs .nav-tabs > li > a::after { background:#f1f1f1 }
	#main-tabs > div.row > div > ul > li > a { font-family: 'Play', sans-serif }

/* Изменено 20.06.2019 --- */
	#main-tabs-menu {
		border-bottom: none;
	}
	#main-tabs-menu {
		padding: 10px;
		border: 2px #336a86 solid;
		border-radius: 10px;
	}
	#main-tabs-menu > li > a::after {
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
			<div class="space20"></div>
			<div class="col-xs-12 col-sm-12 col-md-12">
				<?php include("message_section-underconstruction.php"); ?>
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
