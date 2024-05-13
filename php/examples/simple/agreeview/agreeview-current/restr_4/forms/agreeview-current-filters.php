<?php
// ----- ----- ----- ----- -----
// Подключаем форму поиска
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/agreeview/agreeview-current/restr_4/css/agreeview-current-filters.css">
<div id="docsearch-filters-block" class="panel-group">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" href="#docsearch-filters">Фильтры для поиска соглашения</a>
      </h4>
    </div>
    <div id="docsearch-filters" class="panel-collapse collapse">

			<div id="agreeview-current-filters" class="panel-body space30">
				<div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
					<div class="form-group space10" style="width:100%">
						<label for="docNumberSearch_text"><b>Номер соглашения :</b></label>
						<input type="text" id="docNumberSearch_text" class="form-control" placeholder="Все номера" name="docNumberSearch_text">
					</div>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
					<div class="form-group space10" style="width:100%">
						<label for="docNachYearSearch_text"><b>Год начала :</b></label>
						<input type="text" id="docNachYearSearch_text" class="form-control" placeholder="Все года" name="docNachYearSearch_text">
					</div>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
					<div class="form-group space10" style="width:100%">
						<label for="docEndYearSearch_text"><b>Год окончания :</b></label>
						<input type="text" id="docEndYearSearch_text" class="form-control" placeholder="Все года" name="docEndYearSearch_text">
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
					<div class="input-group space10" style="width:100%">
						<label for="docZakazSearch_text"><b>Компания-партнер :</b></label>
						<input type="text" id="docZakazSearch_text" class="form-control" placeholder="Все плательщики" name="docZakazSearch_text">
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
					<div class="input-group space10" style="width:100%">
						<label for="docIspolSearch_text"><b>ГИП :</b></label>
						<select name="docIspolSearch_text" id="docIspolSearch_text" class="form-control">
							<option value="">Все</option>
							<?php
								$_QRY3 = mysqlQuery( " SELECT ispolnameshot FROM dognet_spispol WHERE ispolnameshot<>'' AND koddel<>99 " );
								while($_ROW3 = mysqli_fetch_assoc($_QRY3)){
								?>
										<option value = '<?php echo $_ROW3["ispolnameshot"]; ?>'><?php echo $_ROW3["ispolnameshot"]; ?></option>
							<?php
								}
								?>
						</select>
					</div>
				</div>
<?php // ----- ----- ----- ----- ----- ?>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<div class="input-group space10" style="width:100%">
						<label for="docNameSearch_text"><b>Текст из названия соглашения :</b></label>
						<input type="text" id="docNameSearch_text" class="form-control" placeholder="Введите текст для поиска в названии" name="docNameSearch_text">
					</div>
				</div>
<?php // ----- ----- ----- ----- ----- ?>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
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
