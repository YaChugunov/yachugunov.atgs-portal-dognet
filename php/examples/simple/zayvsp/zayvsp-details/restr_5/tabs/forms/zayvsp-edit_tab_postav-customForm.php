<?php
// ----- ----- ----- ----- -----
// Форма редактирования поставщика
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/zayvsp/zayvsp-details/restr_5/tabs/css/zayvsp-details-tab_postav-customForm.css">
<div id="customForm_zayvsp_tab_postav">
	<div class="zayvsp-editor-tabs" style="width:100%">
		<ul id="" class="nav nav-tabs doc-zayvsp-tabs-menu">
			<li class="active"><a data-toggle="tab" href="#zayvsp-editor-tab-1" title="">Параметры</a></li>
			<li><a data-toggle="tab" href="#zayvsp-editor-tab-3" title="">Комментарий</a></li>
			<li><a data-toggle="tab" href="#zayvsp-editor-tab-2" title="">Информация</a></li>
		</ul>
		<div class="tab-content" style="padding:5px">
			<div id="zayvsp-editor-tab-1" class="tab-pane fade in active">
				<div class="Section">
					<div class="Block100">
						<legend>Общая информация</legend>
						<fieldset class="field100">
							<editor-field name="sp_contragents.nameshort"></editor-field>
						</fieldset>
						<fieldset class="field100">
							<editor-field name="sp_contragents.namefull"></editor-field>
						</fieldset>
						<fieldset class="field100">
							<editor-field name="sp_contragents.address_postal"></editor-field>
						</fieldset>
						<fieldset class="field100">
							<editor-field name="sp_contragents.web_official"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
			<div id="zayvsp-editor-tab-2" class="tab-pane fade">
				<div class="Section">
					<div class="Block100">
						<legend>Контакты</legend>
						<fieldset class="field100">
							<editor-field name="dognet_docavans.comment"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
			<div id="zayvsp-editor-tab-3" class="tab-pane fade">
				<div class="Section">
					<div class="Block100">
						<legend>Дополнительная информация</legend>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>