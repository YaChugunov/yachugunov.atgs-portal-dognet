<?php
// ----- ----- ----- ----- -----
// Подключаем стили для формы
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/sp/sp-details/restr_4/tabs/css/sp-details-tab1_zakazchiki-customform.css">
<div id="customForm-tab1_zakazchiki">
	<div class="sp-details-tabs" style="width:100%">
		<ul id="" class="nav nav-tabs sp-details-tabs-menu">
			<li class="active"><a data-toggle="tab" href="#tab1_zakazchiki-tab-1" title="">Название и адрес</a></li>
			<li><a data-toggle="tab" href="#tab1_zakazchiki-tab-2" title="">Руководитель</a></li>
			<li><a data-toggle="tab" href="#tab1_zakazchiki-tab-3" title="">Банковские реквизиты</a></li>
			<li><a data-toggle="tab" href="#tab1_zakazchiki-tab-4" title="">Комментарии</a></li>
		</ul>
		<div class="tab-content" style="padding:5px">
			<div id="tab1_zakazchiki-tab-1" class="tab-pane fade in active">
				<div class="Section">
					<div class="Block50">
						<legend>Название</legend>
						<fieldset class="field100">
							<editor-field name="namezakshot"></editor-field>
						</fieldset>
						<fieldset class="field100">
							<editor-field name="namezaklong"></editor-field>
						</fieldset>
					</div>
					<div class="Block50">
						<legend>Адреса</legend>
						<fieldset class="field100">
							<editor-field name="zakuraddress"></editor-field>
						</fieldset>
						<fieldset class="field100">
							<editor-field name="zakaddressfact"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
			<div id="tab1_zakazchiki-tab-2" class="tab-pane fade">
				<div class="Section">
					<div class="Block100">
						<legend>ФИО</legend>
						<fieldset class="field40">
							<editor-field name="zaklastname"></editor-field>
						</fieldset>
						<fieldset class="field30">
							<editor-field name="zakfistname"></editor-field>
						</fieldset>
						<fieldset class="field30">
							<editor-field name="zakmidname"></editor-field>
						</fieldset>
					</div>
					<div class="Block100">
						<legend>Должность и телефон</legend>
						<fieldset class="field100">
							<editor-field name="zakdolg"></editor-field>
						</fieldset>
						<fieldset class="field100">
							<editor-field name="zaktelnumber"></editor-field>
						</fieldset>
						<fieldset class="field100">
							<editor-field name="zakfio"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
			<div id="tab1_zakazchiki-tab-3" class="tab-pane fade">
				<div class="Section">
					<div class="Block100">
						<legend>Банковские реквизиты</legend>
						<fieldset class="field100">
							<editor-field name="zakbankch"></editor-field>
						</fieldset>
						<fieldset class="field50">
							<editor-field name="zakinn"></editor-field>
						</fieldset>
						<fieldset class="field50">
							<editor-field name="zakkpp"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
			<div id="tab1_zakazchiki-tab-4" class="tab-pane fade">
				<div class="Section">
				</div>
			</div>
		</div>
	</div>
</div>
