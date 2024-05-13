
<style>
	@import url('https://fonts.googleapis.com/css?family=Neucha&display=swap');
	#dognet-base-main { font-family:'Oswald', sans-serif }
	#dognet-base-main-block1 {
		border:2px #fff solid;
		border-radius:25px;
		padding:8px;
		background-image: url("../_assets/images/banner_bg_abstract_009.jpg");
		background-position: center center;
		background-size: cover;
		opacity: 1.0;
	}
	#dognet-base-main-block1:hover, #dognet-base-main-block2:hover, #dognet-base-main-block3:hover {
		opacity: 0.6;
		transition: 1s;
 	}
	#dognet-base-main-block1:not(hover), #dognet-base-main-block2:not(hover), #dognet-base-main-block3:not(hover) {
		opacity: 1.0;
		transition: 1s;
 	}
	#dognet-base-main-block2 {
		border:2px transparent solid;
		border-radius:25px;
		padding:8px;
		background-image: url("../_assets/images/banner_bg_abstract_008.jpg");
		background-position: center center; background-size: cover;
		opacity: 1.0;
	}
	#dognet-base-main-block3 {
		border:2px #fff solid;
		border-radius:25px;
		padding:8px;
		background-image: url("../_assets/images/banner_bg_abstract_006.jpg");
		background-position: center center; background-size: cover;
		opacity: 1.0;
	}
	#dognet-base-main .media-body {  }
	#dognet-base-main .media-heading { padding:4px; min-height:100px }
	#dognet-base-main .top-block-text h3, #dognet-base-main .bottom-block-text h3, #dognet-base-main .media h3 { margin-top:25%; margin-bottom:25%; color:#111; font-size:1.8em; font-weight:400; font-family: 'Oswald',sans-serif; letter-spacing:0.05em; background-color:#fff; padding:5px 4px }
	#dognet-base-main .top-block-text h4, #dognet-base-main .bottom-block-text h4, #dognet-base-main .media h4 { color:#111; font-size:1.5em; font-family: 'Neucha', cursive; letter-spacing:normal }
	#dognet-base-main .media p { color:#999; font-family: 'Open Sans Condensed', sans-serif; font-size:1.2em; font-weight:200; letter-spacing:normal }
	#dognet-base-main .top-block-text p { text-align:center; color:#111; font-family: 'Open Sans Condensed', sans-serif; font-size:1.5em; font-weight:300; letter-spacing:normal; line-height:1.0em }
	#dognet-base-main .bottom-block-text p { text-align:center; color:#999; font-family: 'Open Sans Condensed', sans-serif; font-size:1.5em; font-weight:300; letter-spacing:normal; line-height:1.0em }
</style>

<div id="dognet-base-main">

<div class="row">
	<div class="col-xs-hidden col-sm-12 col-md-4 col-lg-4">
		<a class="" href="<?php $_SERVER['HTTP_HOST']; ?>/dognet/dognet-base.php?section=missions">
			<div id="dognet-base-main-block1" class="media" style="padding:20px">
			  <div class="media-body">
			    <h3 class="text-uppercase text-center">Реестр договоров</h3>
			  </div>
			</div>
		</a>
	</div>
	<div class="col-xs-hidden col-sm-12 col-md-4 col-lg-4">
		<a class="" href="<?php $_SERVER['HTTP_HOST']; ?>/dognet/dognet-base.php?section=contacts">
			<div id="dognet-base-main-block2" class="media" style="padding:20px">
			  <div class="media-body">
			    <h3 class="text-uppercase text-center">Адреса, пароли, явки</h3>
			  </div>
			</div>
		</a>
	</div>
	<div class="col-xs-hidden col-sm-12 col-md-4 col-lg-4">
		<a class="" href="<?php $_SERVER['HTTP_HOST']; ?>/dognet/dognet-base.php?section=otherinfo">
			<div id="dognet-base-main-block3" class="media" style="padding:20px">
			  <div class="media-body">
			    <h3 class="text-uppercase text-center">Прочая информация</h3>
			  </div>
			</div>
		</a>
	</div>
</div>

</div>