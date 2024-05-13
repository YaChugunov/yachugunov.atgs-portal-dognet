<?php
// ----- ----- ----- ----- -----
// Форма редактирования аванса по счету-фактуре
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/chetview/chetview-edit/restr_5/tabs/css/chetview-edit-tab3_kalplanchf_avans-customForm.css">
<div id="customForm_tab3_avans">

	<div class="doc-editor-tabs" style="width:100%">
		<ul id="" class="nav nav-tabs doc-editor-tabs-menu">
			<li class="active"><a data-toggle="tab" href="#doc-editor-tab3-kalplanchf_avans-1" title="">Информация</a></li>
			<li><a data-toggle="tab" href="#doc-editor-tab3-kalplanchf_avans-2" title="">Параметры</a></li>
			<li><a data-toggle="tab" href="#doc-editor-tab3-kalplanchf_avans-3" title="">Комментарий</a></li>
		</ul>
		<div class="tab-content" style="padding:5px">
			<div id="doc-editor-tab3-kalplanchf_avans-1" class="tab-pane fade in active">
				<div class="Section">
					<div class="Block100">
						<legend>Информация</legend>
					</div>
				</div>
			</div>
			<div id="doc-editor-tab3-kalplanchf_avans-2" class="tab-pane fade">
				<div class="Section">
					<div class="Block30">
						<legend>Счет-фактура</legend>
						<fieldset class="field100">
							<editor-field name="dognet_chfavans.kodchfact"></editor-field>
						</fieldset>
					</div>
					<div class="Block70">
						<legend>Зачет части аванса</legend>
						<fieldset class="field70">
							<editor-field name="dognet_chfavans.kodavans"></editor-field>
						</fieldset>
						<fieldset class="field30">
							<editor-field name="dognet_chfavans.summaoplav"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
			<div id="doc-editor-tab3-kalplanchf_avans-3" class="tab-pane fade">
				<div class="Section">
					<div class="Block100">
						<legend>Комментарий к авансу</legend>
						<fieldset class="field100">
							<editor-field name="dognet_chfavans.comment"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
