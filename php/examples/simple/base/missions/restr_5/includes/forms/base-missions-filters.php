<?php
// ----- ----- ----- ----- -----
// Подключаем форму поиска
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/base/missions/restr_5/includes/css/base-missions-filters.css">
<div id="docsearch-filters-block" class="panel-group">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" href="#docsearch-filters">Фильтры для поиска договора</a>
      </h4>
    </div>
    <div id="docsearch-filters" class="panel-collapse collapse">

			<div id="dognet-missions-filters" class="panel-body space30">
				<div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
					<div class="form-group space10" style="width:100%">
						<label for="docNumberSearch_text"><b>Номер договора:</b></label>
						<input type="text" id="docNumberSearch_text" class="form-control" placeholder="По номеру" name="docNumberSearch_text">
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
					<div class="form-group space10" style="width:100%">
						<label for="docObjectSearch_text"><b>Объект/заказчик:</b></label>
						<input type="text" id="docObjectSearch_text" class="form-control" placeholder="По объекту или заказчику" name="docObjectSearch_text">
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
					<div class="form-group space10" style="width:100%">
						<label for="docZakazSearch_text"><b>Плательщик:</b></label>
						<input type="text" id="docZakazSearch_text" class="form-control" placeholder="По плательщику" name="docZakazSearch_text">
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
					<div class="form-group space10" style="width:100%">
						<label for="docGipSearch_text"><b>ГИП:</b></label>
						<input type="text" id="docGipSearch_text" class="form-control" placeholder="По исполнителю" name="docGipSearch_text">
					</div>
				</div>
<?php // ----- ----- ----- ----- ----- ?>
				<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
					<div class="form-group space10" style="width:100%">
						<label for="docNameSearch_text"><b>Название договора:</b></label>
						<input type="text" id="docNameSearch_text" class="form-control" placeholder="По названию договора" name="docNameSearch_text">
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
					<div class="form-group space10" style="width:100%">
						<label for="docStageSearch_text"><b>Название этапа:</b></label>
						<input type="text" id="docStageSearch_text" class="form-control" placeholder="По названию этапа" name="docStageSearch_text">
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-right">
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
