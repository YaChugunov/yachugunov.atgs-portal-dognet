<?php
// ----- ----- ----- ----- -----
// Подключаем стили для формы
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/otgrview/otgrview-current/restr_4/css/otgrview-current-customform.css">
<div id="customForm-otgrpaper-main">
	<div class="doc-current-tabs" style="width:100%">
		<ul id="" class="nav nav-tabs doc-current-tabs-menu">
			<li class="active"><a data-toggle="tab" href="#doc-editor-tab-1" title="">Параметры записи</a></li>
			<li><a data-toggle="tab" href="#doc-editor-tab-2" title="">Параметры отгрузки</a></li>
			<li><a data-toggle="tab" href="#doc-editor-tab-3" title="">Описание</a></li>
			<li><a data-toggle="tab" href="#doc-editor-tab-4" title="">Файл</a></li>
		</ul>
		<div class="tab-content" style="padding:5px">
			<div id="doc-editor-tab-1" class="tab-pane fade in active">
				<div class="Section">
					<div class="Block100">
						<legend>Параметры записи</legend>
						<fieldset class="field25">
							<editor-field name="dognet_docpaperotgr.dateloader"></editor-field>
						</fieldset>
						<fieldset class="field20">
							<editor-field name="dognet_docpaperotgr.papermemo"></editor-field>
						</fieldset>
						<fieldset class="field55">
							<editor-field name="dognet_docpaperotgr.kodpaper"></editor-field>
						</fieldset>
						<fieldset class="field100">
							<editor-field name="dognet_docpaperotgr.commentloader"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
			<div id="doc-editor-tab-2" class="tab-pane fade">
				<div class="Section">
					<div class="Block100">
						<legend>Отгрузка</legend>
						<fieldset class="field25">
							<editor-field name="dognet_docpaperotgr.dateotgr"></editor-field>
						</fieldset>
						<fieldset class="field35">
							<editor-field name="dognet_docpaperotgr.nameotgr"></editor-field>
						</fieldset>
						<fieldset class="field40">
							<editor-field name="dognet_docpaperotgr.nameorgotgr"></editor-field>
						</fieldset>
						<fieldset class="field100">
							<editor-field name="dognet_docpaperotgr.commentotgr"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
			<div id="doc-editor-tab-3" class="tab-pane fade">
				<div class="Section">
					<div class="Block100">
						<legend>Описание документа</legend>
						<fieldset class="field100">
							<editor-field name="dognet_docpaperotgr.namedocotgr"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
			<div id="doc-editor-tab-4" class="tab-pane fade">
				<div class="Section">
					<div class="Block100">
						<legend>Файл</legend>
						<fieldset class="field100">
							<editor-field name="dognet_docpaperotgr.msgDocFileID"></editor-field>
						</fieldset>
						<fieldset class="field100">
							<editor-field name="dognet_docpaperotgr.docFileID"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
