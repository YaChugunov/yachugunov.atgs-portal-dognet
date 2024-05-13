<?php
// ----- ----- ----- ----- -----
// Подключаем форму поиска
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/letterview/letterview-current/restr_5/css/letterview-current-docs-filters.css">
  <div id="docsearch-filters-block" class="panel-group">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" href="#docsearch-filters">Фильтры для поиска договора</a>
        </h4>
      </div>
      <div id="docsearch-filters" class="panel-collapse collapse">

				<div id="docview-current-filters" class="panel-body space30">
					<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
						<div class="form-group space10" style="width:100%">
							<label for="docNumberSearch_text_tab1"><b>Номер договора :</b></label>
							<input type="text" id="docNumberSearch_text_tab1" class="form-control" placeholder="Все номера" name="docNumberSearch_text_tab1">
						</div>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
						<div class="form-group space10" style="width:100%">
							<label for="docYearSearch_text_tab1"><b>Год начала действия :</b></label>
							<input type="text" id="docYearSearch_text_tab1" class="form-control" placeholder="Все года" name="docYearSearch_text_tab1">
						</div>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
						<div class="form-group space10" style="width:100%">
							<label for="docStatusSearch_text_tab1"><b>Статус договора :</b></label>
							<select name="docStatusSearch_text_tab1" id="docStatusSearch_text_tab1" class="form-control">
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
					<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
						<div class="form-group space10" style="width:100%">
							<label for="docTypeSearch_text_tab1"><b>Тип договора :</b></label>
							<select name="docTypeSearch_text_tab1" id="docTypeSearch_text_tab1" class="form-control">
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
<?php // ----- ----- ----- ----- ----- ?>
					<div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
						<div class="input-group space10" style="width:100%">
							<label for="docObjectSearch_text_tab1"><b>Заказчик/объект :</b></label>
							<input type="text" id="docObjectSearch_text_tab1" class="form-control" placeholder="Все объекты" name="docObjectSearch_text_tab1">
						</div>
					</div>
					<div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
						<div class="input-group space10" style="width:100%">
							<label for="docZakazSearch_text_tab1"><b>Заказчик/плательщик :</b></label>
							<input type="text" id="docZakazSearch_text_tab1" class="form-control" placeholder="Все плательщики" name="docZakazSearch_text_tab1">
						</div>
					</div>
					<div class="col-xs-12 col-sm-4 col-md-6 col-lg-6">
						<div class="input-group space10" style="width:100%">
							<label for="docNameSearch_text_tab1"><b>Текст из названия договора :</b></label>
							<input type="text" id="docNameSearch_text_tab1" class="form-control" placeholder="Введите текст для поиска в названии" name="docNameSearch_text_tab1">
						</div>
					</div>
<?php // ----- ----- ----- ----- ----- ?>
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
						<div class="input-group space10" style="width:100%">
							<label for="docIspolSearch_text_tab1"><b>Исполнитель :</b></label>
							<select name="docIspolSearch_text_tab1" id="docIspolSearch_text_tab1" class="form-control">
								<option value="">Все исполнители</option>
								<?php
									$_QRY3 = mysqlQuery( " SELECT ispolnamefull FROM dognet_spispol WHERE ispolnamefull<>'' AND koddel<>99 " );
									while($_ROW3 = mysqli_fetch_assoc($_QRY3)){
									?>
											<option value = '<?php echo $_ROW3["ispolnamefull"]; ?>'><?php echo $_ROW3["ispolnamefull"]; ?></option>
								<?php
									}
									?>
							</select>
						</div>
					</div>
<?php // ----- ----- ----- ----- ----- ?>
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
						<div class="input-group space10" style="width:100%">
							<label for="docShablonSearch_text_tab1"><b>Календарный план :</b></label>
							<select name="docShablonSearch_text_tab1" id="docShablonSearch_text_tab1" class="form-control">
								<option value="">Все</option>
								<option value="1">Только с календарным планом</option>
								<option value="2">Только без календарного плана</option>
							</select>
						</div>
					</div>
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-6">

					</div>
<?php // ----- ----- ----- ----- ----- ?>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
						<div class="input-group-btn">
							<button id="columnSearch_btnApply_tab1" class="btn btn-default" type="button">Применить фильтры</button>
							<button id="columnSearch_btnClear_tab1" class="btn btn-default" type="button"><i class="glyphicon glyphicon-remove"></i></button>
						</div>
					</div>
<?php // ----- ----- ----- ----- ----- ?>
				</div>

      </div>
    </div>
  </div>
