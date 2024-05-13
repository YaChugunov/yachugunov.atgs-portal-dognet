<?php ?>

<style>
div.panel-group > div {	border: 2px #a94442 solid }
div.panel-group > div > div.panel-heading > h3 { font-family: 'Oswald', sans-serif; text-transform:none; font-size:1.5em; font-weight:500; padding:0; letter-spacing:normal }
div.panel-group > div > div.panel-heading > h4 { font-family: 'Oswald', sans-serif; text-transform:none; font-size:1.25em; font-weight:400; padding:0; letter-spacing:normal }
div.panel-group > div > div.panel-heading { background-color:#a94442; color:#f0f0f0 }
div.panel-group > div > div.panel-heading > h4.panel-title > a:hover { color:#fafafa; text-decoration:underline }
</style>

<div class="panel-group">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">
				<span class="glyphicon glyphicon-question-sign" style="margin-right:10px"></span><a data-toggle="collapse" href="#collapse1">Что означают все эти кнопки и значки в таблице?</a>
			</h4>
		</div>
		<div id="collapse1" class="panel-collapse collapse">
			<div class="panel-body">
				<div id="legend">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
										<h4>Типы документов</h4>
										<p style="color:#666"><span class="glyphicon glyphicon-envelope" style="margin-right:10px"></span>Общий документ</p>
										<p style="color:#666"><span class="glyphicon glyphicon-info-sign" style="margin-right:10px"></span>Информационный документ</p>
										<p style="color:#666"><span class="glyphicon glyphicon-retweet" style="margin-right:10px"></span>Ответный документ на наш запрос</p>
										<p style="color:#666"><span class="glyphicon glyphicon-flash" style="margin-right:10px"></span>Запрос ответа от организации</p>
										<div class="space20"></div>
										<h4>Прочее</h4>
										<p style="color:#666"><span class="glyphicon glyphicon-option-vertical" style="margin-right:10px"></span>Подробная информация о документе</p>
										<p style="color:#666"><span class="glyphicon glyphicon-option-horizontal" style="margin-right:10px"></span>Скан документа не загружен</p>
										<div class="space20"></div>
										<h4>В столбце "Файл"</h4>
										<p style="color:#666"><span class="glyphicon glyphicon-file" style="margin-right:10px"></span>Скачать / посмотреть документ</p>
										<div class="space20"></div>
									</div>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
										<h4>В столбце "Связи"</h4>
										<p style="color:#666"><span class="glyphicon glyphicon-file" style="margin-right:10px"></span>Скачать / посмотреть (при наличии) скан нашего первичного документа в Исходящих / для типа<span class="glyphicon glyphicon-retweet" style="margin:0 10px"></span>Ответный (при наличии прикрепленной скан-копии документа)</span></p>
										<p style="color:#666"><span class="" style="margin-right:10px"><span class="" style="margin-right:10px; font-weight:300; text-decoration:underline">XXX</span>Ссылка на скан нашего первичного документа в Исходящих / для типа<span class="glyphicon glyphicon-retweet" style="margin:0 10px"></span>Ответный (при наличии связи между документами)</span></p>
										<p style="color:#666"><span class="glyphicon glyphicon-file" style="margin-right:10px"></span>Скачать / посмотреть (при наличии) скан нашего ответного документа в Исходящих / для типа<span class="glyphicon glyphicon-flash" style="margin:0 10px"></span>Запрос ответа (при наличии прикрепленной скан-копии документа)</span></p>
										<p style="color:#666"><span class="" style="margin-right:10px"><span class="" style="margin-right:10px; font-weight:300; text-decoration:underline">YYY</span>Ссылка на скан нашего ответного документа в Исходящих / для типа<span class="glyphicon glyphicon-flash" style="margin:0 10px"></span>Запрос ответа (при наличии связи между документами)</span></p>
										<div class="space20"></div>
										<h4>Для документов типа<span class="glyphicon glyphicon-flash" style="margin:0 10px"></span>"Запрос ответа"</h4>
										<p style="color:#666"><span style="padding:0 4px; background-color:rgb(226, 201, 201)">Ответ на официальный запрос не подготовлен</span><span style="margin:0 5px">|</span><span style="padding:0 4px; background-color:rgb(201, 226, 201)">Дан ответ на официальный запрос</span></p>
										<div class="space20"></div>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
										<h4>Кнопки управления</h4>
										<p style="color:#666"><span class="glyphicon glyphicon-refresh" style="padding:3px 8px; border:1px #666 solid; border-radius:4px; margin-right:10px"></span>Обновить и сбросить все ранее установленные фильтры</p>
										<p style="color:#666"><span class="glyphicon glyphicon-retweet" style="padding:3px 8px; border:1px #666 solid; border-radius:4px; margin-right:10px"></span>Фильтр "Только ответные документы"</p>
										<p style="color:#666"><span class="glyphicon glyphicon-flash" style="padding:3px 8px; border:1px #666 solid; border-radius:4px; margin-right:10px"></span>Фильтр "Только документы с запросом ответа"</p>
										<p style="color:#666"><span class="glyphicon glyphicon-arrow-left" style="padding:3px 8px; border:1px #666 solid; border-radius:4px; margin-right:10px"></span>Вернуться на предыдущую страницу (для связанных документов)</p>
										<div class="space20"></div>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
										<h4>Кнопки управления (уровень "Менеджер" и выше)</h4>
										<p style="color:#666"><span style="padding:0 8px; border:1px #666 solid; border-radius:4px; margin-right:10px">НОВЫЙ</span>Создать новую запись</p>
										<p style="color:#666"><span style="padding:0 8px; border:1px #666 solid; border-radius:4px; margin-right:10px">ИЗМЕНИТЬ</span>Изменить выбранную запись</p>
										<p style="color:#666"><span style="padding:0 8px; border:1px #666 solid; border-radius:4px; margin-right:10px">УДАЛИТЬ</span>Удалить выбранную запись</p>
										<div class="space20"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<?php ?>