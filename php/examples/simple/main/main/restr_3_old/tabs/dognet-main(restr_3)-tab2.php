<?php
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
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
// Какой то блок...
#
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
?>

	<div class="space30"></div>
	<div id="admin-anounce" class="">
		<div class="row admin-anounce-block">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 space20">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="block">
						<h3 class="space20">Флажки по финансам</h3>
						<blockquote class="">
							<p>Как вариант, например можно вывести финансовую сводку по договорам и счетам (общие суммы, задолженности, незакрытие и так далее).</p>
								<p class="text-warning">Любые пожелания от начальников отделов, ГИПов и руководства, чтобы они хотели видеть на стартовых страницах сервиса приветствуются.</p>
							<footer>Ярослав Чугунов</footer>
						</blockquote>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 space20">
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<div class="block">
						<h3 class="space20">Флажки по срокам 1</h3>
						<blockquote class="">
							<p>Можно вывести списки договоров, по которым горят или просрочены сроки оплаты.</p>
							<footer>Ярослав Чугунов</footer>
						</blockquote>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<div class="block">
						<h3 class="space20">Флажки по срокам 2</h3>
						<blockquote class="">
							<p>Можно вывести списки договоров субподряда, по которым горят или просрочены сроки оплаты.</p>
							<footer>Ярослав Чугунов</footer>
						</blockquote>
					</div>
				</div>
			</div>
		</div>
	</div>
