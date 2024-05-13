<?php 
date_default_timezone_set('Europe/Moscow');

	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);

	$__title = 'Договор';
	$__subtitle = "Текущие";
	$__subsubtitle = "Договоры";
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
				<?php include("dognet-docview-current(restr_5)-main.php"); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">
				<?php // include('atgs-portal_main_bottom-area.php'); ?>
			</div>
		</div>

	</div>

	<div class="space100"></div>

<script type="text/javascript">
	title = '<?php echo $__title; ?>';
	subtitle = '<?php echo $__subtitle; ?>';
	document.getElementById("title").innerHTML = title;
	document.getElementById("subtitle").innerHTML = subtitle;
</script>
