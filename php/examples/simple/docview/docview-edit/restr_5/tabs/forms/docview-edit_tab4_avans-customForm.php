<?php
// ----- ----- ----- ----- -----
// Форма редактирования аванса
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-edit/restr_5/tabs/css/docview-edit-tab4_avans-customForm.css">
<div id="customForm_tab4_avans">
	<div class="doc-editor-tabs" style="width:100%">
		<ul id="" class="nav nav-tabs doc-editor-tabs-menu">
			<li class="active"><a data-toggle="tab" href="#doc-editor-tab4-1" title="">Параметры</a></li>
			<li><a data-toggle="tab" href="#doc-editor-tab4-2" title="">Комментарий</a></li>
			<li><a data-toggle="tab" href="#doc-editor-tab4-3" title="">Информация</a></li>
		</ul>
		<div class="tab-content" style="padding:5px">
			<div id="doc-editor-tab4-1" class="tab-pane fade in active">
				<div class="Section">
					<div class="Block100">
						<legend>Параметры аванса</legend>
						<fieldset class="field40">
							<editor-field name="dognet_docavans.koddoc"></editor-field>
						</fieldset>
						<fieldset class="field30">
							<editor-field name="dognet_docavans.dateavans"></editor-field>
						</fieldset>
						<fieldset class="field30">
							<editor-field name="dognet_docavans.summaavans"></editor-field>
						</fieldset>
						<fieldset class="field100">
							<editor-field name="dognet_docavans.nameavans"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
			<div id="doc-editor-tab4-2" class="tab-pane fade">
				<div class="Section">
					<div class="Block100">
						<legend>Комментарий</legend>
						<fieldset class="field100">
							<editor-field name="dognet_docavans.comment"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
			<div id="doc-editor-tab4-3" class="tab-pane fade">
				<div class="Section">
					<div class="Block100">
						<legend>Информация</legend>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>