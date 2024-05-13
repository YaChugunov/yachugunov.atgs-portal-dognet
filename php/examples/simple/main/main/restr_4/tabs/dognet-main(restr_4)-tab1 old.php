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
						<h3 class="space20">Журнал событий</h3>
						<blockquote class="">
							<p>Тут планируется сделать блок вывода последних действий пользователей сервиса, обновлений, изменений, сообщений от администратора Портала. Кто что где изменил, ввел, добавил и так далее. Все касающееся только сервиса Договор...</p>
							<footer>Ярослав Чугунов</footer>
						</blockquote>
					</div>
				</div>
			</div>
		</div>
	</div>



