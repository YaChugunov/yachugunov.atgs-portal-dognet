<?php
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Форма редактирования договора субподряда
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/chetview/chetview-edit/restr_5/tabs/css/chetview-edit-tab6_files-customForm.css">
<div id="customForm_tab6_files">
	<div class="doc-editor-tabs" style="width:100%">
		<ul id="" class="nav nav-tabs doc-editor-tabs-menu">
			<li class="active"><a data-toggle="tab" href="#doc-editor-tab6-1" title="">Информация</a></li>
			<li><a data-toggle="tab" href="#doc-editor-tab6-2" title="">Параметры</a></li>
			<li><a data-toggle="tab" href="#doc-editor-tab6-3" title="">Файл</a></li>
		</ul>
		<div class="tab-content" style="padding:5px">
			<div id="doc-editor-tab6-1" class="tab-pane fade in active">
				<div class="Section">
					<div class="Block100">
						<legend>Подсказки и помощь</legend>
					</div>
				</div>
			</div>
			<div id="doc-editor-tab6-2" class="tab-pane fade">
				<div class="Section">
					<div class="Block100">
						<legend>Параметры документа</legend>
						<fieldset class="field30">
							<editor-field name="dognet_docpaper.dateloader"></editor-field>
						</fieldset>
						<fieldset class="field70">
							<editor-field name="dognet_docpaper.kodpaper"></editor-field>
						</fieldset>
						<fieldset class="field70">
							<editor-field name="dognet_docpaper.paperfull"></editor-field>
						</fieldset>
						<fieldset class="field30">
							<editor-field name="dognet_docpaper.kodmainpaper"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
			<div id="doc-editor-tab6-3" class="tab-pane fade">
				<div class="Section">
					<div class="Block100">
						<legend>Файл</legend>
					<fieldset class="field100">
						<editor-field name="dognet_docpaper.msgDocFileID"></editor-field>
					</fieldset>
						<fieldset class="field100">
							<editor-field name="dognet_docpaper.docFileID"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
