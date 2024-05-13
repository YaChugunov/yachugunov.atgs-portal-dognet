<?php
// ----- ----- ----- ----- -----
// Форма редактирования счета-фактуры
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/chetview/chetview-edit/restr_5/tabs/css/chetview-edit-tab3_kalplanchf-customForm.css">
<div id="customForm_tab3_kalplanchf">

	<div class="doc-editor-tabs" style="width:100%">
		<ul id="" class="nav nav-tabs doc-editor-tabs-menu">
			<li class="active"><a data-toggle="tab" href="#doc-editor-tab3-kalplanchf-1" title="">Информация</a></li>
			<li><a data-toggle="tab" href="#doc-editor-tab3-kalplanchf-2" title="">Параметры</a></li>
		</ul>
		<div class="tab-content" style="padding:5px">
			<div id="doc-editor-tab3-kalplanchf-1" class="tab-pane fade in active">
				<div class="Section">
					<div class="Block100">
						<legend>Информация</legend>
					</div>
				</div>
			</div>
			<div id="doc-editor-tab3-kalplanchf-2" class="tab-pane fade">
				<div class="Section">
					<div class="Block100">
						<legend>Счет-фактура</legend>
						<fieldset class="field45">
							<editor-field name="dognet_kalplanchf.kodkalplan"></editor-field>
						</fieldset>
						<fieldset class="field15">
							<editor-field name="dognet_kalplanchf.chetfnumber"></editor-field>
						</fieldset>
						<fieldset class="field20">
							<editor-field name="dognet_kalplanchf.chetfdate"></editor-field>
						</fieldset>
						<fieldset class="field20">
							<editor-field name="dognet_kalplanchf.chetfsumma"></editor-field>
						</fieldset>
					</div>
					<div class="Block100">
						<fieldset class="field100">
							<editor-field name="dognet_kalplanchf.comment"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
