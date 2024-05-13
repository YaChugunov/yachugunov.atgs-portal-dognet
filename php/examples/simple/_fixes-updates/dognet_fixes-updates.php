<?php

?>
<link rel="stylesheet" href="<?php echo __ROOT; ?>/_assets/js/vendors/slick/slick.css">
<link rel="stylesheet" href="<?php echo __ROOT; ?>/_assets/js/vendors/slick/slick-theme.css">
<script type="text/javascript" language="javascript" src="<?php echo __ROOT; ?>/_assets/js/vendors/slick/slick.min.js"></script>
<style>
.slick-slider { min-width:0; margin-bottom:10px }
.slick-track { display:flex; align-items:flex-start }
.slick-list { overflow:hidden }
.slider-news { position:relative; padding-right:35px; background-color: #fafafa; z-index:1 }
.slider-news .slick-arrow{ position:absolute; top:10px; z-index:2 }
.slider-news-item { height:18px; padding-left:2px; color:#000; font-size:12px }

.slick-prev { left:inherit; right:15px }
.slick-next { left:inherit; right:0 }
.slick-prev, .slick-next {
    font-size: 0;
    line-height: 0;
    position: absolute;
    top: 50%;
    display: block;
    width: 20px;
    height: 20px;
    margin-top: -10px;
    padding: 0;
    cursor: pointer;
    color:#111;
    border: none;
    outline: none;
    background: transparent;
}
.slick-prev:before, .slick-next:before {
    font-family: 'slick';
    font-size: 12px;
    line-height: 1;
    opacity: .75;
    color: #111;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}
.slick-prev:hover, .slick-prev:focus, .slick-next:hover, .slick-next:focus {
    color: #111;
    outline: none;
    background: transparent;
}
.slider-news-title, .slider-news-title a { position:relative; height:18px; float:left; padding-left:2px; padding-right:2px; background:#a94442; color:#fff; font-size:12px; font-weight:500; letter-spacing:0.1em; z-index:2 }
.slider-news-section { float:left; height:18px; padding:0 2px; color:#fff; background:#111; font-weight:500 }
.slider-news-msgdate {  }
.slider-news-msgtext {  }

</style>

<?php
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
	$_restr1 = 0;
	$_restr2 = 0;
	$_restr1 = getUserRestrictions($_SESSION['id'], 'mail');
	$_restr2 = getUserRestrictions($_SESSION['id'], 'dognet');
	$_QRY = mysqlQuery( "SELECT * FROM dognet_updates_log WHERE msg_date>=DATE_ADD(NOW(), INTERVAL -7 DAY) AND status='1' AND restr<='".min($_restr1, $_restr2)."' ORDER BY msg_date DESC LIMIT 10" );
	if (mysqli_num_rows($_QRY)>0) {
?>
<div class="slider-news-title"><a href="<?php $_SERVER['HTTP_HOST']; ?>/news/news-view.php?news_type=current" title="Новости и обновления">Новости и обновления</a></div>
<div class="slider-news">
<?php
		while ($_ROW = mysqli_fetch_array($_QRY)) {
?>
	<div class="slider-news-item">
		<div class="slider-news-section">
		<?php echo $_ROW['section']; ?>
		</div>
		<span style="margin:0 5px; font-size:9px; color:#000"><span class="glyphicon glyphicon-menu-right"></span></span>
		<span class="slider-news-msgdate"><?php echo date("d.m.Y H:i", strtotime($_ROW['msg_date'])); ?></span>
		<span style="margin:0 5px; font-size:9px"><span class="glyphicon glyphicon-menu-right"></span></span>
		<span class="slider-news-msgtext"><?php echo $_ROW['msg_short']; ?></span>
	</div>
<?php
		}
?>
</div>
<?php
	}
?>


<script type="text/javascript" language="javascript" class="init">

	$(document).ready(function(){
		$('.slider-news').slick({
			dots: false,
			infinite: true,
			slidesToShow: 1,
			slidesToScroll: 1,
			autoplay: true,
			autoplaySpeed: 5000,
			pauseOnHover: true,
			fade: true,
			cssEase: 'ease-in',
			arrows: true,
			prevArrow: '<button type="button" class="slick-prev"><span class="glyphicon glyphicon-arrow-left"></span></button>',
			nextArrow: '<button type="button" class="slick-next"><span class="glyphicon glyphicon-arrow-right"></span></button>'
		});
	});

</script>

<?php

?>