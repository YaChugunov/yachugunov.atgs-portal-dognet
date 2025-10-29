<?php
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Инициализация констант и функции определения дареса хоста
require_once ($_SERVER['DOCUMENT_ROOT']."/config.inc.php");
# Подключение библиотеки функций
require_once($_SERVER['DOCUMENT_ROOT']."/_assets/functions/funcSecure.inc.php");
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
?>
<?php
//
//
//
//
//
?>
<style>
	#navbarCollapse > div > ul:nth-child(1) > li.active.text-uppercase.text-left.logo-current-section > a { padding:5px 15px }
	.title-export { color:#999; font-family:"Oswald", sans-serif; font-weight:500; font-size:2em; margin:5px 0; text-transform:uppercase }
</style>

<nav class="navbar navbar-fixed-top" style="background-color:#f1f1f1; color:#fff; border-bottom:2px #fff solid">
	<div class="container-fluid">
		<div class="collapse navbar-collapse navbar-collapse-responsive" id="navbarCollapse">
		<?php
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		// Меню в разрешении экрана .xs
		//
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		?>
			<div class="hidden-sm hidden-md hidden-lg">
				<ul class="nav navbar-nav">
					<li class="text-right user-access-level">
						<span class="navbar-text">Модуль экспорта</span>
					</li>
				</ul>
			</div>
		<?php
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		// Меню в разрешении экрана .sm .md .lg
		//
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		?>
		<div class="hidden-xs">
			<ul class="nav navbar-nav">
				<li class="">
					<span class="navbar-text title-export">Модуль экспорта</span>
				</li>
			</ul>
		<?php
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		// СЕКЦИЯ 4 ::: ( правое меню )
		//
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		?>
			<ul class="nav navbar-nav navbar-right">
				<li class="text-right user-access-level">
					<span class="navbar-text">
						<span class="text-uppercase txt">
							<?php
								if (checkKoduseGIP($_SESSION['id']) == 1) {
									if (checkIsItGIP($_SESSION['id']) == 1) {
										echo '<span class="text-info">GIP</span>';
									}
									else {
										echo '<span class="text-danger">GIP</span>';
									}
								}
								else {
									echo '';
								}
							?>
						</span>
						<span class="lvl">&nbsp;</span>
						<span class="text-uppercase txt">lvl</span>
						<span class="lvl"><?php echo getUserRestrictions($_SESSION['id'], 'dognet'); ?></span>
					</span>
				</li>
			</ul>
		</div>
		<?php // ::: END ::: Меню в разрешении экрана .sm .md .lg ?>

		<?php
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		?>
			</div>
	</div>
<?php // ::: END ::: DIV class = "container-fluid" ?>
</nav>
<?php // ::: END ::: NAV class = "navbar navbar-fixed-top" ?>
