<?php
	$query = mysqlQuery("SELECT * FROM users WHERE id=".$_SESSION['id']);
	$row = mysqli_fetch_assoc($query);
?>
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

				<!-- Media top -->
				<div class="media">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				  <div class="media-left media-middle">
				    <img src="http://192.168.1.89/_assets/images/me_icon.png" class="media-object img-circle" style="width:100px">
				  </div>
				  <div class="media-body media-middle bodytext" style="padding:15px 20px">
				    <span class="text-justify">Коллеги! Я планирую на время отладки работы сервиса ДОГОВОР использовать email-рассылки для оповещения обо всех обновлениях и изменениях в работе сервиса (другие что-то не приживаются), и не хочу напрягать рассылками на общий email сотрудников, которые данным сервисом не пользуются. Все просто, если вы хотите получать эти рассылки ответьте ДА, если не хотите - НЕТ, и это сообщение не будет появляться неделю. Вдруг передумаете :)</span>
				  </div>
				</div>
				<div class="bodytext" style="text-align:center">
					<span class="text-center text-uppercase" style="color:#000; font-size:1.2em">Ваш email в сервисе для рассылки</span><br>
					<span class="text-center"><span style="color:#31708f; font-size:1.2em; font-weight:700; letter-spacing:0.2em"><?php echo $row['email2']?></span></span>
				</div>


				<form id="formx" onsubmit="call()">
					<div class="btn-group" style="width:100%; margin-top:10px">
						<input class="btn btn-sm btn-default" style="width:50%" value="Да, хочу получать рассылку" type="submit">
						<input class="btn btn-sm btn-default" style="width:50%" value="Нет, закрыть окно" data-dismiss="modal" type="button">
					</div>
				</form>

				<center><span id="results"></span></center>

      </div>
    </div>
  </div>
</div>

<script>
	var tmp = "<?php echo $_SESSION ['login']; ?>";
	if (checkCookie(tmp) == 1) {
    $("#testModalBox").modal();
	}

	function call() {
	  var msg = $('#formx').serialize();
		$.ajax({
			type: 'POST',
			url: 'php/examples/simple/main/main/restr_5/formx.php', //обращаемся к обработчику
      data: msg,
			success: function(data) {
				$('#formx').remove();
				$('#results').html(data);
			},
			error:  function(xhr, str) {
				alert('Возникла ошибка: ' + xhr.responseCode);
			}
		});
   }
</script>
