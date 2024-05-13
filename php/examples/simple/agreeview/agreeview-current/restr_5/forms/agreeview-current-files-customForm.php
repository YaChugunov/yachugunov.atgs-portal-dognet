<?php
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Форма редактирования договора субподряда
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/agreeview/agreeview-current/restr_5/css/agreeview-current-files-customForm.css">
<div id="customForm-doc-files">
	<div class="doc-editor-tabs" style="width:100%">
		<ul id="" class="nav nav-tabs doc-editor-tabs-menu">
			<li class="active"><a data-toggle="tab" href="#doc-files-tab-1" title="">Параметры</a></li>
			<li><a data-toggle="tab" href="#doc-files-tab-2" title="">Файл</a></li>
			<li><a data-toggle="tab" href="#doc-files-tab-3" title="">Информация</a></li>
		</ul>
		<div class="tab-content" style="padding:5px">
			<div id="doc-files-tab-1" class="tab-pane fade in active">
				<div class="Section">
					<div class="Block100">
						<legend>Параметры документа</legend>
						<fieldset class="field30">
							<editor-field name="dognet_agreepaper.dateloader"></editor-field>
						</fieldset>
						<fieldset class="field70">
							<editor-field name="dognet_agreepaper.kodpaper"></editor-field>
						</fieldset>
						<fieldset class="field70">
							<editor-field name="dognet_agreepaper.paperfull"></editor-field>
						</fieldset>
						<fieldset class="field30">
							<editor-field name="dognet_agreepaper.kodmainpaper"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
			<div id="doc-files-tab-2" class="tab-pane fade">
				<div class="Section">
					<div class="Block100">
						<legend>Файл</legend>
						<div style="width:100%; text-align:center">
							<fieldset class="field100">
								<editor-field name="dognet_agreepaper.msgDocFileID"></editor-field>
							</fieldset>
							<fieldset class="field100">
								<editor-field name="dognet_agreepaper.lnkDocFileID"></editor-field>
							</fieldset>
						</div>
						<div class="Block25"></div>
						<div class="Block50">
							<fieldset class="field100">
								<editor-field name="dognet_agreepaper.docFileID"></editor-field>
							</fieldset>
							<div id="lnkDocFileID"></div>
						</div>
						<div class="Block25"></div>
					</div>
				</div>
			</div>
			<div id="doc-files-tab-3" class="tab-pane fade">
				<div class="Section">
					<div class="Block100">
						<legend>Подсказки и помощь</legend>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
