<?php
// ----- ----- ----- ----- -----
// Форма редактирования оплаты счета-фактуры
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-edit/restr_4/tabs/css/docview-edit-tab3_kalplanchf_oplata-customForm.css">
<div id="customForm_tab3_oplata">

	<div class="doc-editor-tabs" style="width:100%">
		<ul id="" class="nav nav-tabs doc-editor-tabs-menu">
			<li class="active"><a data-toggle="tab" href="#doc-editor-tab3-kalplanchf_oplata-1" title="">Параметры</a></li>
			<li><a data-toggle="tab" href="#doc-editor-tab3-kalplanchf_oplata-2" title="">Комментарий</a></li>
			<li><a data-toggle="tab" href="#doc-editor-tab3-kalplanchf_oplata-3" title="">Информация</a></li>
		</ul>
		<div class="tab-content" style="padding:5px">
			<div id="doc-editor-tab3-kalplanchf_oplata-1" class="tab-pane fade in active">
				<div class="Section">
					<div class="Block100">
						<legend>Параметры оплаты</legend>
						<fieldset class="field40">
							<editor-field name="dognet_oplatachf.kodchfact"></editor-field>
						</fieldset>
						<fieldset class="field30">
							<editor-field name="dognet_oplatachf.dateopl"></editor-field>
						</fieldset>
						<fieldset class="field30">
							<editor-field name="dognet_oplatachf.summaopl"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
			<div id="doc-editor-tab3-kalplanchf_oplata-2" class="tab-pane fade">
				<div class="Section">
					<div class="Block100">
						<legend>Комментарий</legend>
						<fieldset class="field100">
							<editor-field name="dognet_oplatachf.comment"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
			<div id="doc-editor-tab3-kalplanchf_oplata-3" class="tab-pane fade">
				<div class="Section">
					<div class="Block100">
						<legend>Информация</legend>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
