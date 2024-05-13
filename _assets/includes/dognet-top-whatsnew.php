<?php ?>

<style>
	#whatsnew { font-family:'Oswald', sans-serif }
	#whatsnew > div > div > div > a.btn { font-size:0.9em }
	#whatsnew .btn.btn-link:focus { outline:none }
	#whatsnew > div > div > h3 { color:red; font-weight:400 }

	#whatsnew > div > div.modal-dialog { font-family:'Oswald', sans-serif; margin:1.0em auto; float:none; width:75% }
	#whatsnew > div > div > div > div.modal-header > h4 { text-transform:uppercase; font-weight:400; letter-spacing:normal }
	#whatsnew > div > div > div > div.modal-body > p { font-family:'Oswald', sans-serif; font-weight:300 }
	#whatsnew > div > div > div > div.modal-body > img { margin:20px 0 }
	#whatsnew > div.panel { border-color:#ddd }
</style>

<div id="whatsnew">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			
			<div class="btn-group">
				<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
				Что нового? <span class="caret"></span></button>
				<ul class="dropdown-menu" role="menu">
					<li><a data-toggle="modal" href="#WhatsNew_1">Новый тип записи "Запрос ответа" для Входящих</a></li>
					<li><a data-toggle="modal" href="#WhatsNew_2">Новые кнопки - "Обновить таблицу" и фильтры для типов записей</a></li>
				</ul>
			</div>

		</div>
	</div>

<?php ?>
	
<!-- Modal -->
	<div id="WhatsNew_1" class="modal fade" role="dialog">
		<div class="modal-dialog">
<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Новый тип записи "Запрос ответа"</h4>
				</div>
				<div class="modal-body">
					<p>С 5 декабря добавлен тип записи "Запрос ответа" для входящих документов, в которых Отправитель официально запрашивает ответ. Введение данного типа записи обусловлено необходимостью контроля за подобного рода входящими документами.</p>
					<p>Иконка для записей типа "Запрос ответа" - <span class="glyphicon glyphicon-flash"></span>.</p>
					<p>Строка записи типа "Запрос ответа", на которую пока не отправлен ответный документ, будет подсвечиваться таким образом:</p>
					<img class="img-responsive" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/_assets/images/whatsnew/mail/whatsnew-mail-002.jpg" class="img-rounded" alt="">
					<p>После того как в Исходящих записях появится документ типа "Ответный" и в качестве входящего документа будет выбран соответствующий документ типа "Запрос ответа", то строка записи станет выглядеть следующим образом:</p>
					<img class="img-responsive" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/_assets/images/whatsnew/mail/whatsnew-mail-001.jpg" class="img-rounded" alt="">
					<p>Кроме того, в колонке "Исх №" появится номер-ссылка на исходящий документ, который является ответом на данный.</p>
					<p>В случае изменения типа записи входящего документа привязка к ответному документу в Исходящих записях пропадет. Ее можно будет восстановить обновив соответствующую запись в Исходящих.</p>
					<button type="button" class="btn btn-link" data-toggle="modal" data-target="#WhatsNew_2">Новые кнопки - "Обновить таблицу" и фильтры для типов записей</button>

				</div>
			</div>
		</div>
	</div>

<!-- Modal -->
	<div id="WhatsNew_2" class="modal fade" role="dialog">
		<div class="modal-dialog">
<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Новый тип записи "Запрос ответа"</h4>
				</div>
				<div class="modal-body">
					<p>С 5 декабря добавлен тип записи "Запрос ответа" для входящих документов, в которых Отправитель официально запрашивает ответ. Введение данного типа записи обусловлено необходимостью контроля за подобного рода входящими документами.</p>
					<p>Иконка для записей типа "Запрос ответа" - <span class="glyphicon glyphicon-flash"></span>.</p>
					<p>Строка записи типа "Запрос ответа", на которую пока не отправлен ответный документ, будет подсвечиваться таким образом:</p>
					<img class="img-responsive" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/_assets/images/whatsnew/mail/whatsnew-mail-002.jpg" class="img-rounded" alt="">
					<p>После того как в Исходящих записях появится документ типа "Ответный" и в качестве входящего документа будет выбран соответствующий документ типа "Запрос ответа", то строка записи станет выглядеть следующим образом:</p>
					<img class="img-responsive" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/_assets/images/whatsnew/mail/whatsnew-mail-001.jpg" class="img-rounded" alt="">
					<p>Кроме того, в колонке "Исх №" появится номер-ссылка на исходящий документ, который является ответом на данный.</p>
					<p>В случае изменения типа записи входящего документа привязка к ответному документу в Исходящих записях пропадет. Ее можно будет восстановить обновив соответствующую запись в Исходящих.</p>
				</div>
			</div>
		</div>
	</div>

</div>
