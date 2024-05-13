<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
date_default_timezone_set('Europe/Moscow');
setlocale(LC_ALL, 'rus');
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Включаем режим сессии
// session_start();
# Подключаем конфигурационный файл
// require($_SERVER['DOCUMENT_ROOT']."/config.inc.php");
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Подключаемся к базе
require_once($_SERVER['DOCUMENT_ROOT']."/_assets/drivers/db_connection.php");
require_once($_SERVER['DOCUMENT_ROOT']."/_assets/drivers/db_controller.php");
$db_handle = new DBController();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Подключаем общие функции безопасности
// require(dirname(__FILE__) . '/_assets/functions/funcSecure.inc.php');
// require($_SERVER['DOCUMENT_ROOT']."/_assets/functions/funcSecure.inc.php");
# Подключаем собственные функции сервиса Почта
// require($_SERVER['DOCUMENT_ROOT']."/dognet/_assets/functions/funcDognet.inc.php");
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
?>















<style>
.circles {
  display: flex;
  justify-content: center;
  align-items: center;
  font-family: sans-serif;
  color: #111;
}

.circle {
  background: #FAFAFA;
  padding: 15px;
  margin: 5px;
  display: flex;
  justify-content: center;
  align-items: center;
  border: 2px #111 solid;
  border-radius: 50%;
  width: 10px;
  height: 10px;
  max-width: 10px;
  max-height: 10px;
}

.circle_number {
  font-size: 2rem;
}
.return-link, .format-selected { font-family:'Oswald', sans-serif; font-size:1.0em; font-weight:300; text-transform:uppercase }
.return-link { color:#999 }
a.return-link, a.format-selected { text-decoration:underline }
a.return-link:hover, a.format-selected:hover { text-decoration:none }
</style>

<div id="link">
	<div class="">
		<span class="format-selected">Экспорт в данный формат скоро будет реализован</span>
	</div>
	<div class="circles">
		<div class="circle">
			<div class="circle_number"><span id="time"></span></div>
		</div>
	</div>
</div>

<script type="text/javascript">
var timer;
function countDown(){
	//время в сек.
		i = 5;
		document.getElementById("time").innerHTML = i;
		timer = setInterval(function(){
			document.getElementById("time").innerHTML = i--;

			host = '<?php echo $_SERVER["HTTP_HOST"]; ?>';
			url1 = 'http://'+host+'/dognet/dognet-report.php';
			url2 = 'http://'+host+'/dognet/dognet-report.php?reportview=zadolchf_ondate&export=yes&ondate=<?php echo $_GET['ondate']; ?>';
			if (i < 0) {
				clearInterval(timer);
				document.getElementById("link").innerHTML = "<div class='space20'><span style='padding:0 15px'><a class='return-link' href="+url1+">Вернуться в Отчеты</a></span></div><div class='space20'><span style='padding:0 15px'><a class='return-link' href="+url2+">Новый экспорт</a></span></div>";
			}
		}, 1000);
}
countDown();

</script>
