<?php ?>

<style>
	#toparea-hotlinks {
		font-family: 'Oswald', sans-serif
	}

	#toparea-hotlinks>div>div>div>a.btn,
	#toparea-hotlinks>div>div>div>div>button {
		font-size: 0.9em
	}

	#toparea-hotlinks .btn.btn-primary {
		background: #f1f1f1;
		border: 1px solid #fff;
		color: #111
	}

	#toparea-hotlinks .btn.btn-primary:hover {
		background: #111;
		border: 1px solid #111;
		color: #fff
	}

	#toparea-hotlinks>div>div>h3 {
		font-weight: 400
	}

	#toparea-hotlinks {
		font-family: 'Oswald', sans-serif
	}

	#toparea-hotlinks>div>div>div>div>button>span {
		text-transform: uppercase
	}

	#toparea-hotlinks .btn.btn-link:focus {
		outline: none
	}

	#toparea-hotlinks>div>div.modal-dialog {
		font-family: 'Oswald', sans-serif;
		margin: 1.0em auto;
		float: none;
		width: 75%
	}

	#toparea-hotlinks>div>div>div>div.modal-header>h4 {
		text-transform: uppercase;
		font-weight: 400;
		letter-spacing: normal
	}

	#toparea-hotlinks>div>div>div>div.modal-body>p {
		font-family: 'Oswald', sans-serif;
		font-weight: 300
	}

	#toparea-hotlinks>div>div>div>div.modal-body>img {
		margin: 20px 0
	}

	#toparea-hotlinks>div.panel {
		border-color: #ddd
	}

	#toparea-hotlinks>div.row>div>div>div>ul>li>a {
		color: #111;
		text-transform: uppercase
	}

	#toparea-hotlinks>div>div>div>div.modal-body>h2 {
		font-weight: 500
	}

	#toparea-hotlinks>div>div>div>div.modal-body>div>div.media-left>h3 {
		font-weight: 400;
		letter-spacing: normal
	}

	#toparea-hotlinks>div>div>div>div.modal-body>div>div.media-body>h4 {
		font-weight: 300;
		letter-spacing: normal
	}

	#toparea-hotlinks>div>div>div>div.btn-group.open>ul>li>a {
		font-size: 12px
	}

	#toparea-hotlinks>div>div>div.btn-group>a.btn.btn-warning,
	#toparea-hotlinks>div>div>div.btn-group>div.btn-group>button.btn.btn-warning {
		border: 1px #fff solid;
		color: #111;
		letter-spacing: 0.50em;
		font-family: 'Play', sans-serif;
		font-weight: 700
	}

	#toparea-hotlinks>div>div>div.btn-group>a.btn.btn-warning:hover,
	#toparea-hotlinks>div>div>div.btn-group>div.btn-group>button.btn.btn-warning:hover {
		color: #fff
	}

	#toparea-hotlinks>div>div>div.btn-group>a.btn.btn-info {
		border: 1px #fff solid;
		color: #111
	}

	#toparea-hotlinks>div>div>div.btn-group>a.btn.btn-info:hover {
		color: #fff
	}
</style>

<?php
// Верхний информационный блок
?>

<div id="toparea-hotlinks" class="">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12">
			<div class="btn-group btn-group-justified">
				<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/#" class="btn btn-primary text-uppercase">Договор / Главная</a>
				<div class="btn-group">
					<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><span class="">Договора / Соглашения <span class="caret"></span></span></button>
					<ul class="dropdown-menu" role="menu">
						<li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/dognet-docview.php?docview_type=current" class="">Текущие договора</a></li>
						<li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/dognet-chetview.php?chetview_type=current" class="">Текущие счета</a></li>
						<li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/dognet-docview.php?docview_type=search" class="">Расширенный поиск</a></li>
						<li class="divider"></li>
						<li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/dognet-agreeview.php?docview_type=current" class="">Соглашения о партнерстве</a></li>
					</ul>
				</div>
				<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/dognet-blankview.php?blankview_type=edit" class="btn btn-primary text-uppercase">Бланки</a>
				<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/dognet-otgrview.php?otgrview_type=current" class="btn btn-primary text-uppercase">Отгрузка</a>
			</div>
			<div class="btn-group btn-group-justified">
				<div class="btn-group">
					<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><span class="">Отчетные формы <span class="caret"></span></span></button>
					<ul class="dropdown-menu" role="menu">
						<li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/dognet-report.php">Отчеты</a></li>
						<li><a href="#">Корпоративная отчетность</a></li>
						<li><a href="#">Импорт отчетов и бланков</a></li>
					</ul>
				</div>
				<div class="btn-group">
					<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><span class="">Выходные документы <span class="caret"></span></span></button>
					<ul class="dropdown-menu" role="menu">
						<li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/dognet-actview.php?actview_type=list">Акты о выполненных работах</a></li>
						<li><a href="#">Акты сверки взаимозачетов</a></li>
						<li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/dognet-letterview.php?letterview_type=list">Письма должникам</a></li>
					</ul>
				</div>
				<!-- <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/dognet-sp.php?sp_type=common" class="btn btn-primary text-uppercase">Договор / Справочники</a> -->
			</div>
			<?php
			if (checkIsItZAYV($_SESSION['id']) == 1) {
			?>
				<div class="btn-group btn-group-justified">
					<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/dognet-zayvview.php?zayvview_type=current" class="btn btn-primary text-uppercase">Заявки</a>
					<div class="btn-group">
						<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><span class="">Счета заявок <span class="caret"></span></span></button>
						<ul class="dropdown-menu" role="menu">
							<li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/dognet-zayvview.php?zayvview_type=chet" class="">Работа со счетами заявок</a></li>
							<li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/dognet-zayvview.php?zayvview_type=chetf" class="">Работа со счетами-фактурами заявок</a></li>
						</ul>
					</div>
					<!-- <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/dognet-zayvsp.php?zayvsp_type=common" class="btn btn-primary text-uppercase">Заявки / Справочники</a> -->
				</div>
			<?php
			}
			?>
		</div>
	</div>
</div>