<?php
// ----- ----- ----- ----- -----
// Подключаем форму поиска
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/chetview/chetview-current/restr_4/css/chetview-current-filters.css">
<div id="docsearch-filters-block" class="panel-group">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" href="#docsearch-filters">Фильтры для поиска счета</a>
      </h4>
    </div>
    <div id="docsearch-filters" class="panel-collapse collapse">

			<div id="chetview-current-filters" class="panel-body space30">
				<div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
					<div class="form-group space10" style="width:100%">
						<label for="docNumberSearch_text"><b>Номер счета :</b></label>
						<input type="text" id="docNumberSearch_text" class="form-control" placeholder="Все номера" name="docNumberSearch_text">
					</div>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
					<div class="form-group space10" style="width:100%">
						<label for="docYearSearch_text"><b>Год :</b></label>
						<input type="text" id="docYearSearch_text" class="form-control" placeholder="Все года" name="docYearSearch_text">
					</div>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
					<div class="input-group space10" style="width:100%">
						<label for="docObjectSearch_text"><b>Объект :</b></label>
						<input type="text" id="docObjectSearch_text" class="form-control" placeholder="Все объекты" name="docObjectSearch_text">
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
					<div class="input-group space10" style="width:100%">
						<label for="docZakazSearch_text"><b>Плательщик :</b></label>
						<input type="text" id="docZakazSearch_text" class="form-control" placeholder="Все плательщики" name="docZakazSearch_text">
					</div>
				</div>

				<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
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
<?php // ----- ----- ----- ----- ----- ?>
				<div class="col-xs-12 col-sm-4 col-md-6 col-lg-6">
					<div class="input-group space10" style="width:100%">
						<label for="docNameSearch_text"><b>Текст из названия договора :</b></label>
						<input type="text" id="docNameSearch_text" class="form-control" placeholder="Введите текст для поиска в названии" name="docNameSearch_text">
					</div>
				</div>
<?php // ----- ----- ----- ----- ----- ?>
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">

				</div>
<?php // ----- ----- ----- ----- ----- ?>
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
					<div class="input-group-btn text-right" style="padding-top:25px">
						<button id="columnSearch_btnApply" class="btn btn-default" type="button">Применить фильтры</button>
						<button id="columnSearch_btnClear" class="btn btn-default" type="button"><i class="glyphicon glyphicon-remove"></i></button>
					</div>
				</div>
<?php // ----- ----- ----- ----- ----- ?>
			</div>

    </div>
  </div>
</div>
