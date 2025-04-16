<?php

date_default_timezone_set('Europe/Moscow');

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$__title = 'Договор';
$__subtitle = "Экспорт отчетных данных";
$__subsubtitle = "Экспорт отчетных данных";

?>

<style>
	#report-settings {  }
	#report-settings h3 { color:#111; font-family:'Play', sans-serif; font-size:1.5em; font-weight:700; text-transform:uppercase }
	#report-settings h4 { color:#999; font-family:'Oswald', sans-serif; font-size:1.3em; font-weight:300; text-transform:uppercase }
	#export-format-block a > img { opacity:0.5; height:100px; width:100px; margin:0 2px }
	#export-format-block { text-align:center }
	#export-format-block a > img:hover { opacity:1.0; transition:0.5s	}
	#export-format-block a > img:not(hover) { opacity:0.5; transition:0.5s	}

	.format-not-selected { font-family:'Oswald', sans-serif; font-size:1.0em; font-weight:300; text-transform:uppercase }
	.format-not-selected { color:#999 }


label#select-format-doc, label#select-format-xls, label#select-format-pdf {
 width: 50px; /* Ширина рисунка */
 height: 50px; /* Высота рисунка */
 position: relative; /* Относительное позиционирование */
}
label#select-format-doc input[type="radio"], label#select-format-xls input[type="radio"], label#select-format-pdf input[type="radio"] { top:30px }
label#select-format-doc input[type="radio"] + span {
 position: absolute; /* Абсолютное позиционирование */
 left:0px;
 width: 100%; height: 100%;
 background: url(<?php $_SERVER['HTTP_HOST']; ?>/dognet/_assets/images/export-to-doc-inactive.png) no-repeat; /* Фоновый рисунок */
 cursor: pointer; /* Курсор в виде руки */
 background-position: center center;
 background-size: cover;
/*  border-radius:10px; */
}
label#select-format-doc input[type="radio"]:checked + span {
 position: absolute; /* Абсолютное позиционирование */
 left:0px;
 width: 100%; height: 100%;
 background: url(<?php $_SERVER['HTTP_HOST']; ?>/dognet/_assets/images/export-to-doc.png) no-repeat; /* Фоновый рисунок */
 cursor: pointer; /* Курсор в виде руки */
 background-position: center center;
 background-size: cover;
 border:5px #33333 solid;
/*  border-radius:10px; */
}


label#select-format-xls input[type="radio"] + span {
 position: absolute; /* Абсолютное позиционирование */
 width: 100%; height: 100%;
 left:0px;
 background: url(<?php $_SERVER['HTTP_HOST']; ?>/dognet/_assets/images/export-to-xls-inactive.png) no-repeat; /* Фоновый рисунок */
 cursor: pointer; /* Курсор в виде руки */
 background-position: center center;
 background-size: cover;
/*  border-radius:10px; */
}
label#select-format-xls input[type="radio"]:checked + span {
 position: absolute; /* Абсолютное позиционирование */
 left:0px;
 width: 100%; height: 100%;
 background: url(<?php $_SERVER['HTTP_HOST']; ?>/dognet/_assets/images/export-to-xls.png) no-repeat; /* Фоновый рисунок */
 cursor: pointer; /* Курсор в виде руки */
 background-position: center center;
 background-size: cover;
 border:5px #33333 solid;
/*  border-radius:10px; */
}

label#select-format-pdf input[type="radio"] + span {
 position: absolute; /* Абсолютное позиционирование */
 left:0px;
 width: 100%; height: 100%;
 background: url(<?php $_SERVER['HTTP_HOST']; ?>/dognet/_assets/images/export-to-pdf-inactive.png) no-repeat; /* Фоновый рисунок */
 cursor: pointer; /* Курсор в виде руки */
 background-position: center center;
 background-size: cover;
/*  border-radius:10px; */
}
label#select-format-pdf input[type="radio"]:checked + span {
 position: absolute; /* Абсолютное позиционирование */
 left:0px;
 width: 100%; height: 100%;
 background: url(<?php $_SERVER['HTTP_HOST']; ?>/dognet/_assets/images/export-to-pdf.png) no-repeat; /* Фоновый рисунок */
 cursor: pointer; /* Курсор в виде руки */
 background-position: center center;
 background-size: cover;
 border:5px #33333 solid;
/*  border-radius:10px; */
}
#section-quicklink > div.media > div.media-body > div > h3 {
	color:#666;
	line-height: 1.3em;
	font-family:'Oswald', sans-serif;
	margin-bottom: 0.5em;
	font-size: 1.2em;
	font-weight: 400;
	letter-spacing: -0.05em;
	text-transform:uppercase;
}
#section-quicklink > div.media > div.media-body > div > h4 {
	color:#666;
	line-height: 1.2em;
	font-family:'Oswald', sans-serif;
	margin-bottom: 0.5em;
	font-size: 1.0em;
	font-weight: 300;
	letter-spacing: -0.05em;
}
#section-quicklink > div.media > div.media-body > div > p {
	color:#111;
	font-family:'Oswald', sans-serif;
	font-weight: 500;
}
#section-quicklink > div.media > div.media-body > div > p > span > a {
	text-decoration:underline;
}
#section-quicklink > div.media > div.media-body > div > p > span > a:hover {
	text-decoration:none;
}


.block-text {
	display: none;
	padding: 15px;
	border: 1px solid #ec4848;
}

</style>


<div class="container">
	<div class="space50"></div>
	<div class="row space20">
		<div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
			<div class="col-xs-hidden col-sm-12 col-md-12 col-lg-12">
<?php
				include($_SERVER['DOCUMENT_ROOT'].'/_assets/includes/msg.inc/message_section-underconstruction.php');
?>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
			<div id="section-quicklink">
				<div class="media">
					<div class="media-body text-center">
						<div style="background-color:#fafafa; padding:10px">
							<h4 class="text-uppercase">Вы можете перейти в следующие разделы</h4>
							<p>
								<span style="color:#111; margin:0 10px"><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet">Договор / Главная</a></span>
								<span style="color:#111; margin:0 10px"><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/dognet-docview.php?docview_type=current">Договора</a></span>
								<span style="color:#111; margin:0 10px"><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/dognet-zayvview.php?zayvview_type=current">Заявки</a></span>
							</p>
						</div>
					</div>
				</div>
			</div>
			<div class="space50"></div>
		</div>
	</div>


</div>

<script type="text/javascript">

	$('input[name="sum_type"]').click(function(){
		if ($(this).val() == "1") {
			$('input[id="sum-user-value"]').prop('disabled', false);
		}
		else {
			$('input[id="sum-user-value"]').prop('disabled', true);
		}
	});

</script>