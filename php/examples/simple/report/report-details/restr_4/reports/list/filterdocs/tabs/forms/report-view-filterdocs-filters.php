<?php
// ----- ----- ----- ----- -----
// Подключаем форму поиска
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/report/report-details/restr_4/reports/list/filterdocs/tabs/css/report-view-filterdocs-filters.css">
<div class="space20"></div>
<div id="docsearch-filters-block" class="panel-group" style="margin-bottom:10px">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" href="#docsearch-filters">Фильтры для поиска договора</a>
      </h4>
    </div>
    <div id="docsearch-filters" class="panel-collapse collapse">

			<div id="docview-current-filters" class="panel-body">
				<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
					<div class="form-group space10" style="width:100%">
						<label for="docNumberSearch_text"><b>Номер :</b></label>
						<input type="text" id="docNumberSearch_text" class="form-control" placeholder="Все номера" name="docNumberSearch_text">
					</div>
				</div>
				<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
					<div class="form-group space10" style="width:100%">
						<label for="docYearNachSearch_text"><b>Начало :</b></label>
						<input type="text" id="docYearNachSearch_text" class="form-control" placeholder="Все года" name="docYearNachSearch_text">
					</div>
				</div>
				<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
					<div class="form-group space10" style="width:100%">
						<label for="docYearEndSearch_text"><b>Конец :</b></label>
						<input type="text" id="docYearEndSearch_text" class="form-control" placeholder="Все года" name="docYearEndSearch_text">
					</div>
				</div>
				<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
					<div class="input-group space10" style="width:100%">
						<label for="docObjectSearch_text"><b>Заказчик/объект :</b></label>
						<input type="text" id="docObjectSearch_text" class="form-control" placeholder="Все объекты" name="docObjectSearch_text">
					</div>
				</div>
				<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
					<div class="input-group space10" style="width:100%">
						<label for="docZakazSearch_text"><b>Заказчик/плательщик :</b></label>
						<input type="text" id="docZakazSearch_text" class="form-control" placeholder="Все плательщики" name="docZakazSearch_text">
					</div>
				</div>
<?php // ----- ----- ----- ----- ----- ?>
				<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
					<div class="input-group space10" style="width:100%">
						<label for="docShablonSearch_text"><b>Шаблон :</b></label>
						<select name="docShablonSearch_text" id="docShablonSearch_text" class="form-control">
							<option value="">Все</option>
							<option value="0">Договора-счета</option>
							<option value="1">Договора с календарным планом</option>
							<option value="2">Договора без календарного плана</option>
						</select>
					</div>
				</div>
				<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
					<div class="form-group space10" style="width:100%">
						<label for="docTypeSearch_text"><b>Тип договора :</b></label>
						<select name="docTypeSearch_text" id="docTypeSearch_text" class="form-control">
							<option value="">Все типы договоров</option>
							<?php
								$_QRY2 = mysqlQuery( " SELECT nametip FROM dognet_sptipdog WHERE nametip<>'' AND koddel<>99 " );
								while($_ROW2 = mysqli_fetch_assoc($_QRY2)){
								?>
										<option value = '<?php echo $_ROW2["nametip"]; ?>'><?php echo $_ROW2["nametip"]; ?></option>
							<?php
								}
								?>
						</select>
					</div>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					<div class="input-group space10" style="width:100%">
						<label for="docNameSearch_text"><b>Текст из названия договора :</b></label>
						<input type="text" id="docNameSearch_text" class="form-control" placeholder="Текст для поиска" name="docNameSearch_text">
					</div>
				</div>
<?php // ----- ----- ----- ----- ----- ?>
				<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
					<div class="input-group space10" style="width:100%">
						<label for="docIspolSearch_text"><b>Исполнитель :</b></label>
						<select name="docIspolSearch_text" id="docIspolSearch_text" class="form-control">
							<option value="">Все исполнители</option>
							<?php
								$_QRY3 = mysqlQuery( " SELECT kodispol, ispolnamefull FROM dognet_spispol WHERE ispolnamefull<>'' AND koddel<>99 ORDER BY ispolnamefull ASC " );
								while($_ROW3 = mysqli_fetch_assoc($_QRY3)){
								?>
										<option value = '<?php echo $_ROW3["kodispol"]; ?>'><?php echo $_ROW3["ispolnamefull"]; ?></option>
							<?php
								}
								?>
						</select>
					</div>
				</div>
				<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
					<div class="form-group space10" style="width:100%">
						<label for="docStatusSearch_text"><b>Статус договора :</b></label>
						<select name="docStatusSearch_text" id="docStatusSearch_text" class="form-control">
							<option value="">Все статусы договоров</option>
							<?php
								$_QRY1 = mysqlQuery( " SELECT statusnameshot FROM dognet_spstatus WHERE statusnameshot<>'' " );
								while($_ROW1 = mysqli_fetch_assoc($_QRY1)){
								?>
										<option value = '<?php echo $_ROW1["statusnameshot"]; ?>'><?php echo $_ROW1["statusnameshot"]; ?></option>
							<?php
								}
								?>
						</select>
					</div>
				</div>
				<div class="col-xs-12 col-sm-3 col-md-2 col-lg-2">
					<div class="form-group space10" style="width:100%">
						<label for="docYearZakrSearch_text"><b>Закрытие :</b></label>
						<input type="text" id="docYearZakrSearch_text" class="form-control" placeholder="Все года" name="docYearZakrSearch_text">
					</div>
				</div>
<?php // ----- ----- ----- ----- ----- ?>
				<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 text-right">
					<div class="input-group-btn" style="padding-top:25px">
						<button id="columnSearch_btnApply" class="btn btn-default" type="button">Применить фильтры</button>
						<button id="columnSearch_btnClear" class="btn btn-default" type="button"><i class="glyphicon glyphicon-remove"></i></button>
					</div>
				</div>
<?php // ----- ----- ----- ----- ----- ?>
			</div>

    </div>
  </div>
</div>
