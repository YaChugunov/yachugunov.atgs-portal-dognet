<?php
// ----- ----- ----- ----- -----
// Подключаем форму поиска
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/actview/actview-current/restr_5/css/actview-current-log-filters.css">
<div id="logsearch-filters-block" class="panel-group">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" href="#logsearch-filters">Фильтры для поиска в журнале актов</a>
      </h4>
    </div>
    <div id="logsearch-filters" class="panel-collapse collapse">

			<div id="actview-current-filters" class="panel-body space30">
				<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
					<div class="form-group space10" style="width:100%">
						<label for="docNumberSearch_text_tab2"><b>Номер договора :</b></label>
						<input type="text" id="docNumberSearch_text_tab2" class="form-control" placeholder="Все номера" name="docNumberSearch_text_tab2">
					</div>
				</div>
<?php // ----- ----- ----- ----- ----- ?>
				<div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
					<div class="input-group space10" style="width:100%">
						<label for="docAuthorSearch_text_tab2"><b>Кто сформировал акт :</b></label>
						<input type="text" id="docAuthorSearch_text_tab2" class="form-control" placeholder="Кто сформировал акт" name="docAuthorSearch_text_tab2">
					</div>
				</div>
				<div class="col-xs-12 col-sm-5 col-md-6 col-lg-6">
					<div class="input-group space10" style="width:100%">
						<label for="docNameSearch_text_tab2"><b>Текст из названия договора :</b></label>
						<input type="text" id="docNameSearch_text_tab2" class="form-control" placeholder="Введите текст для поиска в названии" name="docNameSearch_text_tab2">
					</div>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-6">

				</div>
<?php // ----- ----- ----- ----- ----- ?>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
					<div class="input-group-btn">
						<button id="columnSearch_btnApply_tab2" class="btn btn-default" type="button">Применить фильтры</button>
						<button id="columnSearch_btnClear_tab2" class="btn btn-default" type="button"><i class="glyphicon glyphicon-remove"></i></button>
					</div>
				</div>
<?php // ----- ----- ----- ----- ----- ?>
			</div>

    </div>
  </div>
</div>
