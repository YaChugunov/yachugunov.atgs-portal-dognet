<?php
// ----- ----- ----- ----- -----
// Подключаем форму поиска
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/report/report-details/restr_5/reports/oplav/opl/tabs/css/report-view-main-filters.css">
<div id="docsearch-filters-block" class="panel-group">
  <div class="panel panel-default">
    <div id="docsearch-filters" class="panel-collapse collapse in">

			<div id="docview-current-filters" class="panel-body space30">
				<div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
					<div class="form-group space10" style="width:100%">
						<label for="docNumberSearch_text"><b>Номер договора :</b></label>
						<input type="text" id="docNumberSearch_text" class="form-control" placeholder="Все номера" name="docNumberSearch_text">
					</div>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
					<div class="input-group space10" style="width:100%">
						<label for="docChfSearch_text"><b>Счет-фактура :</b></label>
						<input type="text" id="docChfSearch_text" class="form-control" placeholder="Все объекты" name="docChfSearch_text">
					</div>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
					<div class="input-group space10" style="width:100%">
						<label for="docZakazSearch_text"><b>Заказчик :</b></label>
						<input type="text" id="docZakazSearch_text" class="form-control" placeholder="Все плательщики" name="docZakazSearch_text">
					</div>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
					<div class="input-group space10" style="width:100%">
						<label for="docNameSearch_text"><b>Текст из названия :</b></label>
						<input type="text" id="docNameSearch_text" class="form-control" placeholder="Текст для поиска в названии" name="docNameSearch_text">
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
