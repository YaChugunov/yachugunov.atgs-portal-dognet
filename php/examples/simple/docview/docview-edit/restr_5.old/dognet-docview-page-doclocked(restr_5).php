<?php
	$__title = 'Договор';
	$__msg = "Редактирование невозможно";
?>
<style>
#section-doclocked > div.row { font-family:'Oswald', sans-serif }
#section-doclocked > div > div > div.media > div.media-body > h1 {
	color:#950100;
	font-size: 2.2em;
}
#section-doclocked > div > div > div.media > div.media-body > h3 {
/* 	font-family: 'Jura', sans-serif; */
/* 	font-size: 1.0em; */
/* 	font-weight: 200; */
	color:#666;
	line-height: 1.2em;
	font-family:'Oswald', sans-serif;
	margin-bottom: 0.5em;
	font-size: 1.5em;
  font-weight: 200;
  letter-spacing: 0.05em;
}
#section-doclocked > div > div > div.media > div.media-body > h3 > span.username { color:#000; font-weight:500; padding:0 5pxж letter-spacing: 0 }
#section-doclocked > div > div > div.media > div.media-body > div > h4 {
	color:#666;
    font-weight: 300;
	margin-bottom: 0.75em;
}
#section-doclocked > div > div > div.media > div.media-body > div > p {
	color:#111;
	font-family:'Oswald', sans-serif;
    font-weight: 500;
}
#section-doclocked > div > div > div.media > div.media-body > div > p > span > a {
	text-decoration:underline;
}
#section-doclocked > div > div > div.media > div.media-body > div > p > span > a:hover {
	text-decoration:none;
}
#section-doclocked > div.media > div.media-body > ul {
	font-family: 'Oswald', sans-serif;
    font-size: 1.2em;
    font-weight: 300;
    letter-spacing: normal;
	margin-top: 5px;
	margin-left: 10px;
}
.vh-content {
    min-height: calc(100vh - 185px);
}
</style>

<?php
$query1 = mysqlQuery( "SELECT COUNT(id) as cnt FROM service_access WHERE service_name!='allservices'" );
$query2 = mysqlQuery( "SELECT service_name, service_title, access, service_path FROM service_access" );
$row1 = mysqli_fetch_array($query1, MYSQLI_ASSOC);
$_cnt = $row1['cnt'];
?>

<div id="section-doclocked" class="container">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
			<div class="space50"></div>
			<div class="media">
				<div class="media-body text-center">
					<h1 class="text-uppercase space10">Внесение изменений в договор заблокировано</h1>
					<h3 class="">В данный момент пользователь <span class="username"><?php echo DOCBASE_FN_USERNAME_LOCK_FOR_EDIT( $_GET['uniqueID'] ); ?></span> вносит изменения в данный договор</h3>

					<div style="background-color:#fafafa; padding:10px">
						<h4 class="text-uppercase">Вам доступны</h4>
						<p>
							<span style='color:#111; margin:0 10px'><a href="dognet-docview.php?docview_type=details&uniqueID=<?php echo $_GET['uniqueID']; ?>">Карточка договора</a></span>
							<span style='color:#111; margin:0 10px'><a data-toggle="modal" href="#testModalBox">Попросить разблокировать!</a></span>
						</p>
					</div>

				</div>
			</div>
			<div class="space50"></div>
		</div>
	</div>
</div>



<style>

#testModalBox div.bodytext {	color:#666; font-family:'Helioscond', sans-serif; font-size:1.0em; line-height:1.2em }
#testModalBox input.btn { font-weight:400; text-transform:uppercase; letter-spacing:0.1em }
</style>

<!-- HTML-код модального окна -->
<div id="testModalBox" class="modal fade">
	<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <!-- Основное содержимое модального окна -->
      <div class="modal-body">

<!-- 				<form id="formx" onsubmit="call()" metod=""> -->
				<form id="formx">
					<div class="btn-group" style="width:100%; margin-top:10px">
						<input class="btn btn-sm btn-default" style="width:50%" value="Отправить запрос" type="submit">
						<input class="btn btn-sm btn-default" style="width:50%" value="Нет, закрыть окно" data-dismiss="modal" type="button">
					</div>
				</form>

				<center><span id="results"></span></center>

      </div>
    </div>
  </div>
</div>



<script type="text/javascript">


$('#formx').submit(function(){
    $.post(
        'dognet/php/example/simple/docview/docview-edit/restr_5/includes/request_docunlock_handler/dognet-request-docunlock-handler.php', // адрес обработчика
         $("#formx").serialize(), // отправляемые данные

        function(msg) { // получен ответ сервера
            $('#formx').hide('slow');
            $('#results').html(msg);
        }
    );
    return false;
});



	title = '<?php echo $__title; ?>';
	msg = '<?php echo $__msg; ?>';
	document.getElementById("title").innerHTML = title;
	document.getElementById("subtitle").innerHTML = msg;
</script>
