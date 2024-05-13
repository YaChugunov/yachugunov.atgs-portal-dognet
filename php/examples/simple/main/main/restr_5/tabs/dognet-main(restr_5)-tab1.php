<?php
#
date_default_timezone_set('Europe/Moscow');
# Подключаем конфигурационный файл
// require($_SERVER['DOCUMENT_ROOT']."/config.inc.php");
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Подключаемся к базе
require_once($_SERVER['DOCUMENT_ROOT']."/_assets/drivers/db_connection.php");
require_once($_SERVER['DOCUMENT_ROOT']."/_assets/drivers/db_controller.php");
$db_handle = new DBController();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# ID ПОЛЬЗОВАТЕЛЯ
	$__USERID = $_SESSION['id'];

#	$__USERID = '1052'; // Щукин
#	$__USERID = '1105'; // Лавров
#	$__USERID = '1043'; // Тимофеев
#	$__USERID = '1037'; // Зельдин

# ИНТЕРВАЛ ДЕДЛАЙНА
	$__DATEDIFF = 180;

# ТЕКУЩАЯ ДАТА
	$__DATENOW = date("Y-m-d H:i:s");

// ОПРЕДЕЛЯЕМ KODISPOL ГИПА ПО ЕГО ID
	$_QRY_KODISPOL = mysqlQuery("SELECT * FROM dognet_users_kods WHERE id='".$__USERID."'");
	$_ROW_KODISPOL = mysqli_fetch_assoc($_QRY_KODISPOL);
	$__KODISPOL = $_ROW_KODISPOL['kodispol'];
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
?>
<style>
#gip-greeting { background:#f1f1f1; padding:10px 30px; border:2px #f1f1f1 solid; border-radius:10px }
h3.gipwork-main-section-title {
	color: #111;
	font-family: 'Oswald',sans-serif;
	font-weight: 400;
	font-size: 1.5em;
	text-transform: uppercase;
}
/*
h3.gipwork-main-section-title > span {
	display:block;
	color: #111;
	font-family: 'Oswald', sans-serif;
	font-weight: 200;
	font-size: 0.5em;
	letter-spacing: 0em;
	text-transform: uppercase;
}
*/
div.gip-greeting-block { text-align:center }
div.gip-message-block { text-align:center }
div.gip-message-admin-block {  }
h3.gip-greeting-title {
    color: #31708f;
    font-family: 'Oswald', sans-serif;
    font-weight: 400;
    font-size: 2.0em;
    text-transform: uppercase;
}
div.gip-greeting-message > span {
    color: #333;
    font-family: 'Oswald', sans-serif;
    font-weight: 300;
    font-size: 1.3em;
    text-transform: uppercase;
}
div.gip-message-text > span {
    font-family: 'HeliosCond', sans-serif;
    font-weight: 300;
    font-size: 1.2em;
    text-transform: uppercase;
}
div.gip-message-admin-text > span {
		color: #999;
    font-family: 'HeliosCond', sans-serif;
    font-weight: 300;
    font-size: 1.0em;
    font-style: italic;
}
#admin-anounce .block-anounce h3.section-title { color:#999; font-family:'Oswald', sans-serif; font-size:2.0em; font-weight:400; text-transform:uppercase; letter-spacing:0.0em }

.block {
/*
	border: 2px #336a86 solid;
	padding: 10px;
	border-radius: 10px;
*/
}
</style>

	<div class="space30"></div>
	<div id="gip-greeting" class="">
		<div class="row gip-greeting-block">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<h3 class="gip-greeting-title space10 text-success">Приветствую, <?php echo $_SESSION['firstname']; ?>!</h3>
<?php
if (checkIsItGIP($_SESSION['id'])==1) {
?>
				<div class="gip-greeting-message">
					<span><b>Вы - ГИП.</b> Ниже вы найдете информацию, которая касается всех тех договоров и этапов, в которых вы являетесь Исполнителем.<br>Возможно представленная информация будет для вас полезной.</span>
				</div>
<?php
}
?>
			</div>
		</div>
	</div>
	<div class="space20"></div>
	<div id="admin-anounce" class="">
		<div class="row admin-anounce-block">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="block-anounce">
						<h3 class="space20">График выполнения (АТГС в целом)</h3>
						<blockquote class="">
							<p>На графике представлены данные за последние 24 месяца (сумма за каждый месяц), а именно - общая сумма выставленных АТГС счетов-фактур за этот период ("Счета-фактуры"), а также сумма выплаченных авансов ("Авансы") в адрес АТГС и оплат счетов-фактур ("Оплаты") со стороны Заказчиков. Для отображения/скрытия того или иного графика надо кликнуть на его названии в легенде.</p>
							<p class="text-warning"><b>Данные на графике соответствуют реальным показателям АТГС, это не демонстрация.</b></p>
							<footer>Ярослав Чугунов</footer>
						</blockquote>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="admin-anounce" class="">
		<div class="row admin-anounce-block">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<?php include("dognet-main(restr_5)-tab1_gipwork-main-chart_stageprogress.php"); ?>
			</div>
		</div>
	</div>
	<div class="space50"></div>
	<div id="admin-anounce" class="">
		<div class="row admin-anounce-block">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="block-anounce">
						<h3 class="space20">Новые бланки</h3>
						<blockquote class="">
							<p>В этом разделе выводятся недавно созданные заявки на договор, как вновь созданные так и оформленные, ожидающие привязки к договору.</p>
							<footer>Ярослав Чугунов</footer>
						</blockquote>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="" class="" style="padding:10px; border:2px #336a86 solid; border-radius:10px">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="block">
						<div style="">
							<h3 class="gipwork-main-section-title">Незавершенные заявки на договор</h3>
						</div>
						<?php include("dognet-main(restr_5)-tab1_gipwork-main-blankinprogress.php"); ?>
					</div>
			</div>
		</div>
	</div>
	<div class="space50"></div>
	<div id="admin-anounce" class="">
		<div class="row admin-anounce-block">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="block-anounce">
						<h3 class="space20">Новое</h3>
						<blockquote class="">
							<p>В этом разделе выводятся недавно созданные договора/этапы (за последние 30 дней) и выставленные счета-фактуры (за последние 20 дней). Кроме этого выводятся авансовые платежи, оплаты по счетам-фактурам и зачтенные авансы (также за последние 20 дней).</p>
							<p class="text-warning"><b>Дата зачета суммы из авансового платежа фиксируется только для операций после 22.04.2020.</b></p>
							<p>По ссылке номера договора вы всегда можете попасть в карточку договора, к которому относится данная запись.</p>
							<footer>Ярослав Чугунов</footer>
						</blockquote>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="" class="" style="padding:10px; border:2px #336a86 solid; border-radius:10px">
		<div class="row space20">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="block">
						<div style="">
							<h3 class="gipwork-main-section-title">Новые договора и этапы<span class="text-uppercase text-danger"> / за последние 30 дней</span> / ТОП 10</h3>
						</div>
						<?php include("dognet-main(restr_5)-tab1_gipwork-main-newdocs.php"); ?>
					</div>
			</div>
		</div>
		<div class="row space20">
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					<div class="block">
						<div style="">
							<h3 class="gipwork-main-section-title">Новые авансы<span class="text-uppercase text-danger"> / за последние 20 дней</span> / ТОП 5</h3>
						</div>
						<?php include("dognet-main(restr_5)-tab1_gipwork-main-newavans.php"); ?>
					</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					<div class="block">
						<div style="">
							<h3 class="gipwork-main-section-title">Новые счета-фактуры<span class="text-uppercase text-danger"> / за последние 20 дней</span> / ТОП 5</h3>
						</div>
						<?php include("dognet-main(restr_5)-tab1_gipwork-main-newchf.php"); ?>
					</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					<div class="block">
						<div style="">
							<h3 class="gipwork-main-section-title">Новые оплаты<span class="text-uppercase text-danger"> / за последние 20 дней</span> / ТОП 5</h3>
						</div>
						<?php include("dognet-main(restr_5)-tab1_gipwork-main-newoplchf.php"); ?>
					</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					<div class="block">
						<div style="">
							<h3 class="gipwork-main-section-title">Новые зачеты авансов<span class="text-uppercase text-danger"> / за последние 20 дней</span> / ТОП 5</h3>
						</div>
						<?php include("dognet-main(restr_5)-tab1_gipwork-main-newoplav.php"); ?>
					</div>
			</div>
		</div>
	</div>
	<div class="space50"></div>
	<div id="admin-anounce" class="">
		<div class="row admin-anounce-block">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="block-anounce">
						<h3 class="space20">Контроль счетов-фактур</h3>
						<blockquote class="">
							<p>В разделе контроля счетов-фактур приведены те счета, по которым есть текущая задолженность, а также просрочен срок оплаты. Такие счета выделены <span style="color:#111; background:#fdf0f0; padding:0 5px">нежно-розовым цветом</span>. Так получилось :)</p>
							<p class=""><b>UPD 12/05/20</b><br>
							<span class=""><s>Контроль счетов-фактур осуществляется только для договоров в статусе - "Текущий", "Проект" и "Подписание".</s></span>
							<br>
							<span class="text-danger"><b>Рассматриваются ВСЕ договора, имеющие задолженность в статусе "Текущая".</b></span>
							</p>
							<p>По ссылке номера договора вы всегда можете попасть в карточку договора, к которому относится данная запись.</p>
							<footer>Ярослав Чугунов</footer>
						</blockquote>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="" class="">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="block">
						<div style="">
							<h3 class="gipwork-main-section-title space10">Контроль счетов-фактур
								<span class="text-uppercase text-danger"> / Счета-фактуры, по которым есть задолженность / просрочен срок оплаты</span>
							</h3>
						</div>
						<?php include("dognet-main(restr_5)-tab1_gipwork-control-stages_oplataexpired.php"); ?>
					</div>
			</div>
		</div>
	</div>
	<div class="space50"></div>
	<div id="admin-anounce" class="">
		<div class="row admin-anounce-block">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="block-anounce">
						<h3 class="space20">Контроль этапов</h3>
						<blockquote class="">
							<p>В разделе контроля этапов выводятся те этапы договоров, по которым есть незакрытая сумма (сумма этапа превышает сумму выставленных счетов-фактур по нему) или есть незакрытые авансы (сумма аванса не зачтена полностью). Кроме этого, выведены отдельным списком компании-должники, за которыми числятся непогашенные счета-фактуры по этапам.</p>
							<p>Что означают суммы и даты в колонках таблиц, вы можете прочитать в легенде к этим таблицам.</p>
							<p class="text-warning"><b>Контроль этапов осуществляется только для договоров в статусе - "Текущий", "Проект" и "Подписание".</b></p>
							<footer>Ярослав Чугунов</footer>
						</blockquote>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
?>
	<div class="block space10">
		<h3 class="gipwork-main-section-title">Контроль этапов
			<span class="text-uppercase text-danger"> / Незакрытые этапы / незакрытые авансы / должники по этапам</span>
		</h3>
	</div>
	<div id="doc-details-tabs" class="doc-details-tabs" style="width:100%">
		<ul id="doc-details-tabs-menu" class="nav nav-tabs doc-details-tabs-menu">
			<li class="active"><a data-toggle="tab" href="#doc-details-tab1-2" title="">Незакрытые этапы</a></li>
			<li><a data-toggle="tab" href="#doc-details-tab1-3" title="">Незакрытые авансы</a></li>
			<li><a data-toggle="tab" href="#doc-details-tab1-4" title="">Должники по договорам</a></li>
			<li><a data-toggle="tab" href="#doc-details-tab1-5" title="">Просроченные этапы</a></li>
		</ul>
		<div class="tab-content" style="padding:5px; width:100%">
			<div id="doc-details-tab1-2" class="tab-pane fade in active">
					<?php include("dognet-main(restr_5)-tab1_gipwork-control-stages_uncompleted.php"); ?>
			</div>
			<div id="doc-details-tab1-3" class="tab-pane fade">
					<?php include("dognet-main(restr_5)-tab1_gipwork-control-stages_avansostatok.php"); ?>
			</div>
			<div id="doc-details-tab1-4" class="tab-pane fade">
					<?php include("dognet-main(restr_5)-tab1_gipwork-control-stages_debtors.php"); ?>
			</div>
			<div id="doc-details-tab1-5" class="tab-pane fade">
					<?php include("dognet-main(restr_5)-tab1_gipwork-control-stages_expired.php"); ?>
			</div>
		</div>
	</div>
