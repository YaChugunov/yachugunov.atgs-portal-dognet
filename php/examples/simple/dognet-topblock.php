<style>
/* ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- */
	.title-main { font-family:'BebasNeueRegular',sans-serif; font-weight:200; font-size:3.6em; line-height: 1.1em; margin-bottom: -0.15em }
	h3.subtitle-main { min-height:34px; padding-top:4px }
	h3.subtitle-main > span { background-color:transparent; color:#111; font-family:'Poiret One', cursive; font-weight:400; font-size:1.3em; text-transform:uppercase; letter-spacing:0.2em; margin-left:0 }
	.title-small { color:red; font-family:'BebasNeueRegular',sans-serif; font-weight:200; font-size:4.0em; line-height:0.75em }
	h3.subsubtitle-main > span { color:#333; padding:2px 4px; font-family: 'Oswald', sans-serif; font-weight:200; font-size:0.8em; text-transform:uppercase; letter-spacing:0.1em }
/* ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- */
	#topblock-menu {
	    background-color:#fff;
	    min-height:140px;
/*
	    border:2px #333 solid;
	    border-radius:5px;
*/
	}
	#topblock-menu .nav > li { margin-bottom:-2px }
	#topblock-menu .nav > li > a { color:#ccc }
	#topblock-menu .nav > li > a:focus, #topblock-menu .nav > li > a:hover { background-color:transparent }

	#topblock-menu .nav-tabs > li { border:none; margin-top:10px; margin-left:0; margin-right:20px; margin-bottom:10px }
	#topblock-menu .nav-tabs > li > a { border:none; padding:0 }
	#topblock-menu .nav-tabs > li.active > a { color: #111 !important; background-color:#fff; border-bottom:transparent }
	#topblock-menu .nav-tabs > li > a:hover { color: #111 !important; background-color:#fff; border-bottom:transparent }
	#topblock-menu .nav-tabs > li > a::after { background:#fff }
	#topblock-menu > ul > li > a { font-family: 'Arial', sans-serif; font-size:0.8em; font-weight:500 }
/* Изменено 20.06.2019 --- */
	#topblock-menu-tabs {
/* 	    background: #333; */
		padding:0;
		border-bottom: none;
		text-transform:uppercase;
	}
	#topblock-menu-tabs > li > a:hover {
		background-color:#fff
	}

	#topblock-menu .nav-tabs > li.active > a, #topblock-menu .nav-tabs > li.active > a:focus, #topblock-menu .nav-tabs > li.active > a:hover { border:transparent }
	#topblock-menu-tabs > li > a::after {
		content: "";
		background: #fff;
		height: 40px;
		z-index: -1;
		position: absolute;
		width: 100%;
		left: 0px;
		transition: all 250ms ease 0s;
		transform: scale(0);
	}
	#topblock-menu-tabs > li.active > a::after, #topblock-menu-tabs > li:hover > a::after {
		transform: scale(0);
	}
</style>
<link href="https://fonts.googleapis.com/css?family=Poiret+One&display=swap&subset=cyrillic" rel="stylesheet">

	<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
		<div style="">
			<div class="media" style="height:42px">
			  <div class="media-left media-middle" style="padding-right:0">
			    <img src="<?php $_SERVER['HTTP_HOST']; ?>/dognet/_assets/images/service-workmode-live-1.gif" class="media-object" style="width:48px">
			  </div>
			  <div class="media-body media-middle">
					<h3 class="subtitle-main" style="display:none"><span id="companyName"></span></h3>
			    <h3 class="subtitle-main media-heading"><span id="serviceName"></span></h3>
			  </div>
			</div>
			<h1 class="title-main text-uppercase text-left"><span id="dognet-subtitle"><?php echo $__subtitle; ?></span></h1>
			<h3 class="subsubtitle-main"><span id="dognet-subsubtitle"></span></h3>
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
		<div id="topblock-menu" style="width:100%">
			<ul id="topblock-menu-tabs" class="nav nav-tabs">
			<?php
				if (checkUserRestrictions($_SESSION['id'],'mail',2,0)==1) {
					echo '<li><a data-toggle="tab" href="#topblock-menu-tab-1" title="">Почта АТГС</a></li>';
				}
				if (checkUserRestrictions($_SESSION['id'],'mailATC',2,0)==1) {
					echo '<li><a data-toggle="tab" href="#topblock-menu-tab-2" title="">Почта АТ Система</a></li>';
				}
			?>
				<li class="active"><a data-toggle="tab" href="#topblock-menu-tab-3" title="">Договор</a></li>
				<li class=""><a data-toggle="tab" href="#topblock-menu-tab-4" title="">Командировка</a></li>
				<li class=""><a data-toggle="tab" href="#topblock-menu-tab-5" title="">ИСМ / СМК</a></li>
				<li class=""><a data-toggle="tab" href="#topblock-menu-tab-6" title="">Кадры</a></li>
			</ul>
			<div class="tab-content" style="padding:5px 0">
			<?php
				if (checkUserRestrictions($_SESSION['id'],'mail',2,0)==1) {
			?>
				<div id="topblock-menu-tab-1" class="tab-pane fade in">
					<?php
						if (checkUserRestrictions($_SESSION['id'],'mail',5,1)==1) {
							include($_SERVER['DOCUMENT_ROOT'].'/mail/php/examples/simple/mailbox-hotlinks(restr_5).php');
						}
						elseif (checkUserRestrictions($_SESSION ['id'],'mail',4,1) == 1) {
							include($_SERVER['DOCUMENT_ROOT'].'/mail/php/examples/simple/mailbox-hotlinks(restr_4).php');
						}
						elseif (checkUserRestrictions($_SESSION ['id'],'mail',3,1) == 1) {
							include($_SERVER['DOCUMENT_ROOT'].'/mail/php/examples/simple/mailbox-hotlinks(restr_3).php');
						}
						elseif (checkUserRestrictions($_SESSION ['id'],'mail',2,1) == 1) {
							include($_SERVER['DOCUMENT_ROOT'].'/mail/php/examples/simple/mailbox-hotlinks(restr_2).php');
						}
						else { include($_SERVER['DOCUMENT_ROOT'].'/_assets/includes/msg.inc/message_service-nopermission185.php'); }
					?>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="space10"></div>
					</div>
				</div>
			<?php
				}
				if (checkUserRestrictions($_SESSION['id'],'mailATC',2,0)==1) {
			?>
				<div id="topblock-menu-tab-2" class="tab-pane fade in">
					<?php
						if (checkUserRestrictions($_SESSION['id'],'mailATC',5,1)==1) {
							include($_SERVER['DOCUMENT_ROOT'].'/mailATC/php/examples/simple/mailbox-hotlinks(restr_5).php');
						}
						elseif (checkUserRestrictions($_SESSION ['id'],'mailATC',4,1) == 1) {
							include($_SERVER['DOCUMENT_ROOT'].'/mailATC/php/examples/simple/mailbox-hotlinks(restr_4).php');
						}
						elseif (checkUserRestrictions($_SESSION ['id'],'mailATC',3,1) == 1) {
							include($_SERVER['DOCUMENT_ROOT'].'/mailATC/php/examples/simple/mailbox-hotlinks(restr_3).php');
						}
						elseif (checkUserRestrictions($_SESSION ['id'],'mailATC',2,1) == 1) {
							include($_SERVER['DOCUMENT_ROOT'].'/mailATC/php/examples/simple/mailbox-hotlinks(restr_2).php');
						}
						else { include($_SERVER['DOCUMENT_ROOT'].'/_assets/includes/msg.inc/message_service-nopermission-topblock-menu.php'); }
					?>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="space10"></div>
					</div>
				</div>
			<?php
				}
			?>
				<div id="topblock-menu-tab-3" class="tab-pane fade in active">
					<?php
						if (checkUserRestrictions($_SESSION['id'],'dognet',5,1)==1) {
							include($_SERVER['DOCUMENT_ROOT'].'/dognet/php/examples/simple/dognet-hotlinks(restr_5).php');
						}
						elseif (checkUserRestrictions($_SESSION ['id'],'dognet',4,1) == 1) {
							include($_SERVER['DOCUMENT_ROOT'].'/dognet/php/examples/simple/dognet-hotlinks(restr_4).php');
						}
						elseif (checkUserRestrictions($_SESSION ['id'],'dognet',3,1) == 1) {
							include($_SERVER['DOCUMENT_ROOT'].'/dognet/php/examples/simple/dognet-hotlinks(restr_3).php');
						}
						elseif (checkUserRestrictions($_SESSION ['id'],'dognet',2,1) == 1) {
							include($_SERVER['DOCUMENT_ROOT'].'/dognet/php/examples/simple/dognet-hotlinks(restr_2).php');
						}
						elseif (checkUserRestrictions($_SESSION ['id'],'dognet',1,1) == 1) {
							include($_SERVER['DOCUMENT_ROOT'].'/dognet/php/examples/simple/dognet-hotlinks(restr_1).php');
						}
						else { include($_SERVER['DOCUMENT_ROOT'].'/dognet/php/examples/simple/dognet-hotlinks(restr_1).php'); }
					?>
				</div>
				<div id="topblock-menu-tab-4" class="tab-pane fade in">
					<?php
						if (checkUserRestrictions($_SESSION['id'],'dognet',5,1)==1) {
							include($_SERVER['DOCUMENT_ROOT'].'/btrips/php/examples/simple/btrips-hotlinks(restr_5).php');
						}
						elseif (checkUserRestrictions($_SESSION ['id'],'dognet',4,1) == 1) {
							include($_SERVER['DOCUMENT_ROOT'].'/btrips/php/examples/simple/btrips-hotlinks(restr_4).php');
						}
						elseif (checkUserRestrictions($_SESSION ['id'],'dognet',3,1) == 1) {
							include($_SERVER['DOCUMENT_ROOT'].'/btrips/php/examples/simple/btrips-hotlinks(restr_3).php');
						}
						elseif (checkUserRestrictions($_SESSION ['id'],'dognet',2,1) == 1) {
							include($_SERVER['DOCUMENT_ROOT'].'/btrips/php/examples/simple/btrips-hotlinks(restr_2).php');
						}
						elseif (checkUserRestrictions($_SESSION ['id'],'dognet',1,1) == 1) {
							include($_SERVER['DOCUMENT_ROOT'].'/btrips/php/examples/simple/btrips-hotlinks(restr_1).php');
						}
						else { include($_SERVER['DOCUMENT_ROOT'].'/btrips/php/examples/simple/btrips-hotlinks(restr_1).php'); }
					?>
				</div>
				<div id="topblock-menu-tab-5" class="tab-pane fade in">
					<?php
						if (checkUserRestrictions($_SESSION['id'],'ism',5,1)==1) {
							include($_SERVER['DOCUMENT_ROOT'].'/ism/php/examples/simple/ism-hotlinks(restr_5).php');
						}
						elseif (checkUserRestrictions($_SESSION ['id'],'ism',4,1) == 1) {
							include($_SERVER['DOCUMENT_ROOT'].'/ism/php/examples/simple/ism-hotlinks(restr_4).php');
						}
						elseif (checkUserRestrictions($_SESSION ['id'],'ism',3,1) == 1) {
							include($_SERVER['DOCUMENT_ROOT'].'/ism/php/examples/simple/ism-hotlinks(restr_3).php');
						}
						elseif (checkUserRestrictions($_SESSION ['id'],'ism',2,1) == 1) {
							include($_SERVER['DOCUMENT_ROOT'].'/ism/php/examples/simple/ism-hotlinks(restr_2).php');
						}
						elseif (checkUserRestrictions($_SESSION ['id'],'ism',1,1) == 1) {
							include($_SERVER['DOCUMENT_ROOT'].'/ism/php/examples/simple/ism-hotlinks(restr_1).php');
						}
						else { include($_SERVER['DOCUMENT_ROOT'].'/ism/php/examples/simple/ism-hotlinks(restr_1).php'); }
					?>
				</div>
				<div id="topblock-menu-tab-6" class="tab-pane fade in">
					<?php
						if (checkUserRestrictions($_SESSION['id'],'hr',5,1)==1) {
							include($_SERVER['DOCUMENT_ROOT'].'/hr/php/examples/simple/hr-hotlinks(restr_5).php');
						}
						elseif (checkUserRestrictions($_SESSION ['id'],'hr',4,1) == 1) {
							include($_SERVER['DOCUMENT_ROOT'].'/hr/php/examples/simple/hr-hotlinks(restr_4).php');
						}
						elseif (checkUserRestrictions($_SESSION ['id'],'hr',3,1) == 1) {
							include($_SERVER['DOCUMENT_ROOT'].'/hr/php/examples/simple/hr-hotlinks(restr_3).php');
						}
						elseif (checkUserRestrictions($_SESSION ['id'],'hr',2,1) == 1) {
							include($_SERVER['DOCUMENT_ROOT'].'/hr/php/examples/simple/hr-hotlinks(restr_2).php');
						}
						elseif (checkUserRestrictions($_SESSION ['id'],'hr',1,1) == 1) {
							include($_SERVER['DOCUMENT_ROOT'].'/hr/php/examples/simple/hr-hotlinks(restr_1).php');
						}
						else { include($_SERVER['DOCUMENT_ROOT'].'/hr/php/examples/simple/hr-hotlinks(restr_1).php'); }
					?>
				</div>
			</div>
		</div>
	</div>
