<?php ?>

<style>
	#toparea-hotlinks { font-family:'Oswald', sans-serif }
	#toparea-hotlinks > div > div > div > a.btn, #toparea-hotlinks > div > div > div > div > button  { font-size:0.9em }
	#toparea-hotlinks .btn.btn-primary { background:#f1f1f1; border:1px solid #fff; color:#111 }
	#toparea-hotlinks .btn.btn-primary:hover { background:#111; border:1px solid #111; color:#fff }
	#toparea-hotlinks > div > div > h3 { font-weight:400 }

	#toparea-hotlinks { font-family:'Oswald', sans-serif }
	#toparea-hotlinks > div > div > div > div > button > span { text-transform:uppercase }
	#toparea-hotlinks .btn.btn-link:focus { outline:none }

	#toparea-hotlinks > div > div.modal-dialog { font-family:'Oswald', sans-serif; margin:1.0em auto; float:none; width:75% }
	#toparea-hotlinks > div > div > div > div.modal-header > h4 { text-transform:uppercase; font-weight:400; letter-spacing:normal }
	#toparea-hotlinks > div > div > div > div.modal-body > p { font-family:'Oswald', sans-serif; font-weight:300 }
	#toparea-hotlinks > div > div > div > div.modal-body > img { margin:20px 0 }
	#toparea-hotlinks > div.panel { border-color:#ddd }
	#toparea-hotlinks > div.row > div > div > div > ul > li > a { color:#111; text-transform:uppercase }
	#toparea-hotlinks > div > div > div > div.modal-body > h2 { font-weight:500 }
	#toparea-hotlinks > div > div > div > div.modal-body > div > div.media-left > h3 { font-weight:400; letter-spacing:normal }
	#toparea-hotlinks > div > div > div > div.modal-body > div > div.media-body > h4 { font-weight:300; letter-spacing:normal }
	#toparea-hotlinks > div > div > div > div.btn-group.open > ul > li > a { font-size:12px }
</style>

<?php
// Верхний информационный блок
?>

<div id="toparea-hotlinks" class="">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12">
			<div class="btn-group btn-group-justified">
				<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/#" class="btn btn-primary text-uppercase">Договор / Главная</a>
			</div>
		</div>
<?php
if (checkIsItZAYV($_SESSION['id']) == 1) {
?>
		<div class="col-xs-12 col-sm-12 col-md-12">
			<div class="btn-group btn-group-justified">
				<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/dognet-zayvview.php?zayvview_type=current" class="btn btn-primary text-uppercase">Заявки</a>
				<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/dognet-zayvsp.php?zayvsp_type=common" class="btn btn-primary text-uppercase">Заявки / Справочники</a>
			</div>
		</div>
<?php
}
?>
	</div>
</div>

