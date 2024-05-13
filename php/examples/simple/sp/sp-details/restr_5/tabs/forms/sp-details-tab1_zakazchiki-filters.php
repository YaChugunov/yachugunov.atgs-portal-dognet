<?php
// ----- ----- ----- ----- -----
// Подключаем форму поиска
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/sp/sp-details/restr_5/tabs/css/sp-details-tab1_zakazchiki-filters.css">
<div id="filters-tab1_zakazchiki-block" class="panel-group">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" href="#filters-tab1_zakazchiki-panel">Фильтры для поиска договора</a>
      </h4>
    </div>
    <div id="filters-tab1_zakazchiki-panel" class="panel-collapse collapse">
			<div id="filters-tab1_zakazchiki" class="panel-body space30">
				<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
					<div class="form-group space10" style="width:100%">
						<label for="tab1_zakNameSearch_text"><b>Краткое название :</b></label>
						<input type="text" id="tab1_zakNameSearch_text" class="form-control" placeholder="Все" name="tab1_zakNameSearch_text">
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
					<div class="form-group space10" style="width:100%">
						<label for="tab1_zakRukSearch_text"><b>Руководитель :</b></label>
						<input type="text" id="tab1_zakRukSearch_text" class="form-control" placeholder="Все" name="tab1_zakRukSearch_text">
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
					<div class="form-group space10" style="width:100%">
						<label for="tab1_zakAddrSearch_text"><b>Юридический адрес :</b></label>
						<input type="text" id="tab1_zakAddrSearch_text" class="form-control" placeholder="Все" name="tab1_zakAddrSearch_text">
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
					<div class="form-group space10" style="width:100%">
						<label for="tab1_zakTelSearch_text"><b>Телефон :</b></label>
						<input type="text" id="tab1_zakTelSearch_text" class="form-control" placeholder="Все" name="tab1_zakTelSearch_text">
					</div>
				</div>
<?php // ----- ----- ----- ----- ----- ?>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
					<div class="input-group-btn">
						<button id="tab1_zakazchikiSearch_btnApply" class="btn btn-default" type="button">Применить фильтры</button>
						<button id="tab1_zakazchikiSearch_btnClear" class="btn btn-default" type="button"><i class="glyphicon glyphicon-remove"></i></button>
					</div>
				</div>
<?php // ----- ----- ----- ----- ----- ?>
			</div>
    </div>
  </div>
</div>
