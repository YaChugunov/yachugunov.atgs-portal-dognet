<?php
// ----- ----- ----- ----- -----
// Подключаем форму поиска
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/otgrview/otgrview-current/restr_5/css/otgrview-current-filters.css">
<div id="docsearch-filters-block" class="panel-group">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" href="#docsearch-filters">Фильтры для поиска отгрузки</a>
      </h4>
    </div>
    <div id="docsearch-filters" class="panel-collapse collapse">

			<div id="otgrview-current-filters" class="panel-body space30">
				<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
					<div class="form-group space10" style="width:100%">
						<label for="docNumberSearch_text"><b>Номер договора :</b></label>
						<input type="text" id="docNumberSearch_text" class="form-control" placeholder="Все номера" name="docNumberSearch_text">
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
					<div class="form-group space10" style="width:100%">
						<label for="otgrYearSearch_text"><b>Год отгрузки :</b></label>
						<input type="text" id="otgrYearSearch_text" class="form-control" placeholder="Все года" name="otgrYearSearch_text">
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-3 col-lg-6">
					<div class="form-group space10" style="width:100%">
						<label for="tipPaperSearch_text"><b>Тип документа :</b></label>
						<select name="tipPaperSearch_text" id="tipPaperSearch_text" class="form-control">
							<option value="">Все типы</option>
							<?php
								$_QRY1 = mysqlQuery( " SELECT namepaper FROM dognet_sptippaper WHERE namepaper<>'' AND kodusepril='2' " );
								while($_ROW1 = mysqli_fetch_assoc($_QRY1)){
								?>
										<option value = '<?php echo $_ROW1["namepaper"]; ?>'><?php echo $_ROW1["namepaper"]; ?></option>
							<?php
								}
								?>
						</select>
					</div>
				</div>
<?php // ----- ----- ----- ----- ----- ?>
				<div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
					<div class="input-group space10" style="width:100%">
						<label for="nameorgotgrSearch_text"><b>Получатель :</b></label>
						<input type="text" id="nameorgotgrSearch_text" class="form-control" placeholder="Все получатели" name="nameorgotgrSearch_text">
					</div>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
					<div class="input-group space10" style="width:100%">
						<label for="nameotgrSearch_text"><b>Ответственный :</b></label>
						<input type="text" id="nameotgrSearch_text" class="form-control" placeholder="Все ответственные" name="nameotgrSearch_text">
					</div>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-6 col-lg-6">
					<div class="input-group space10" style="width:100%">
						<label for="docNameSearch_text"><b>Текст из описания :</b></label>
						<input type="text" id="docNameSearch_text" class="form-control" placeholder="Введите текст для поиска в названии" name="docNameSearch_text">
					</div>
				</div>
<?php // ----- ----- ----- ----- ----- ?>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
					<div class="input-group-btn">
						<button id="columnSearch_btnApply" class="btn btn-default" type="button">Применить фильтры</button>
						<button id="columnSearch_btnClear" class="btn btn-default" type="button"><i class="glyphicon glyphicon-remove"></i></button>
					</div>
				</div>
<?php // ----- ----- ----- ----- ----- ?>
			</div>

    </div>
  </div>
</div>
