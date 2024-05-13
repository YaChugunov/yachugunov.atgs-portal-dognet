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
						<h3 class="space20">Графики</h3>
						<blockquote class="">
							<p>Если будет четко поставленная задача и необходимость в графическом представлении финансновых или каких-либо других параметров (сальдо по договорам, объемы, оборот и так далее), то есть возможность это сделать. <mark>Если в этом действительно будет заинтересованность, то надо понимать, что это потребует оплаты лицензии на прикладной софт.</mark> А сделать - сделаю. Любой каприз, как говорится... :)</p>
							<p>Естественно, что графики могут быть как по финансовой, так и по производственной или любой другой части, по которой есть готовая статистика или есть желание ее начать собирать...</p>
							<p>Ниже примеры. В ассортименте более 30 типов графиков для отображения...</p>
							<footer>Ярослав Чугунов</footer>
						</blockquote>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 space50">
				<div id="chartContainer1" style="height: 300px; width: 100%;"></div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 space20">
				<div id="chartContainer2" style="height: 300px; width: 100%;"></div>
			</div>
		</div>
	</div>






