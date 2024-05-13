<?php
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Форма редактирования счета-фактуры
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-edit/restr_5/tabs/css/docview-edit-tab5_subpodr_chetfact-customForm.css">
<div id="customForm_tab5_chfsubpodr">
	<div class="doc-editor-tabs" style="width:100%">
		<ul id="" class="nav nav-tabs doc-editor-tabs-menu">
			<li class="active"><a data-toggle="tab" href="#doc-editor-tab5-chetfact-1" title="">Информация</a></li>
			<li><a data-toggle="tab" href="#doc-editor-tab5-chetfact-2" title="">Договор</a></li>
			<li><a data-toggle="tab" href="#doc-editor-tab5-chetfact-3" title="">Параметры</a></li>
		</ul>
		<div class="tab-content" style="padding:5px">
			<div id="doc-editor-tab5-chetfact-1" class="tab-pane fade in active">
				<div class="Section">
					<div class="Block100">
						<legend>Информация</legend>
					</div>
				</div>
			</div>
			<div id="doc-editor-tab5-chetfact-2" class="tab-pane fade">
				<div class="Section">
					<div class="Block100">
						<legend>Договор</legend>
						<fieldset class="field100">
							<editor-field name="dognet_docchfsubpodr.koddocsubpodr"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
			<div id="doc-editor-tab5-chetfact-3" class="tab-pane fade">
				<div class="Section">
						<div class="Block100">
							<legend>Параметры счета-фактуры</legend>
							<fieldset class="field20">
								<editor-field name="dognet_docchfsubpodr.numberchfsubpodr"></editor-field>
							</fieldset>
							<fieldset class="field20">
								<editor-field name="dognet_docchfsubpodr.datechfsubpodr"></editor-field>
							</fieldset>
							<fieldset class="field30">
								<editor-field name="dognet_docchfsubpodr.sumchfsubpodr"></editor-field>
							</fieldset>
							<fieldset class="field30">
								<editor-field name="dognet_docchfsubpodr.sumzadolchfsubpodr"></editor-field>
							</fieldset>
						</div>
				</div>
			</div>
		</div>
	</div>
</div>
