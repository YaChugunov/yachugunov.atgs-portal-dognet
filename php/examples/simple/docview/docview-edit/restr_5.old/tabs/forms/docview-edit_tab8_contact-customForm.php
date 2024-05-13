<?php
// ----- ----- ----- ----- -----
// Подключаем стили для формы
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-edit/restr_5/tabs/css/docview-edit-common-customForm.css">
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-edit/restr_5/tabs/css/docview-edit-tab8_contact-customform.css">
<style>
	span.select2.select2-container.select2-container--default.select2-container--focus { width:100% }
	span.select2-container > span > span.select2-selection { height:34px }
	#select2-DTE_Field_dognet_spcontact-kodzakaz-container { line-height:32px; text-align:left }
	#select2-DTE_Field_dognet_spcontact-koddoc-container { line-height:32px; text-align:left }
	span.select2-container > span.selection > span.select2-selection > span.select2-selection__arrow { height:32px }
</style>
<div id="customForm-tab8_contact">
	<div class="doc-editor-tabs" style="width:100%">
		<ul id="" class="nav nav-tabs doc-editor-tabs-menu">
			<li class="active"><a data-toggle="tab" href="#tab8_contact-tab-1" title="">Общее</a></li>
			<li><a data-toggle="tab" href="#tab8_contact-tab-2" title="">Привязка к заказчику</a></li>
			<li><a data-toggle="tab" href="#tab8_contact-tab-3" title="">Привязка к договору</a></li>
		</ul>
		<div class="tab-content" style="padding:5px">
			<div id="tab8_contact-tab-1" class="tab-pane fade in active">
				<div class="Section">
					<div class="Block60">
						<legend>ФИО</legend>
						<fieldset class="field50">
							<editor-field name="dognet_spcontact.namecontactend"></editor-field>
						</fieldset>
						<fieldset class="field50">
							<editor-field name="dognet_spcontact.namecontactfist"></editor-field>
						</fieldset>
						<fieldset class="field50">
							<editor-field name="dognet_spcontact.namecontactsecond"></editor-field>
						</fieldset>
						<fieldset class="field50">
							<editor-field name="dognet_spcontact.namecontactshot"></editor-field>
						</fieldset>
					</div>
					<div class="Block40">
						<legend>Должность</legend>
						<fieldset class="field100">
							<editor-field name="dognet_spcontact.doljcontact"></editor-field>
						</fieldset>
					</div>
					<div class="Block100">
						<legend>Контакты</legend>
						<fieldset class="field40">
							<editor-field name="dognet_spcontact.telcontact1"></editor-field>
						</fieldset>
						<fieldset class="field30">
							<editor-field name="dognet_spcontact.telcontact2"></editor-field>
						</fieldset>
						<fieldset class="field30">
							<editor-field name="dognet_spcontact.telcontact3"></editor-field>
						</fieldset>
						<fieldset class="field40">
							<editor-field name="dognet_spcontact.emailcontact"></editor-field>
						</fieldset>
						<fieldset class="field30">
							<editor-field name="dognet_spcontact.faxcontact"></editor-field>
						</fieldset>
						<fieldset class="field30">
							<editor-field name="dognet_spcontact.telcontactmobi"></editor-field>
						</fieldset>
					</div>
					<div class="Block100">
						<legend>Примечание</legend>
						<fieldset class="field100">
							<editor-field name="dognet_spcontact.contactprim"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
			<div id="tab8_contact-tab-2" class="tab-pane fade">
				<div class="Section">
					<div class="Block100">
						<legend>Привязка к заказчику</legend>
						<div class="Block100">
							<fieldset class="field100">
								<editor-field name="dognet_spcontact.kodzakaz"></editor-field>
							</fieldset>
						</div>
<!--
						<div class="Block100 fieldset-table-row" style="padding-top:25px">
							<div class="fieldset-table-cell" style="padding-bottom:3px">
								<fieldset>
									<editor-field name="zakunlink"></editor-field>
								</fieldset>
							</div>
							<div class="fieldset-table-cell" style="width:100%">
								<div><div class="chekbox-inline-text">Отменить привязку к заказчику</div></div>
							</div>
						</div>
-->
					</div>
				</div>
			</div>
			<div id="tab8_contact-tab-3" class="tab-pane fade">
				<div class="Section">
					<div class="Block100">
						<legend>Привязка к договору</legend>
						<div class="Block100">
							<fieldset class="field100">
								<editor-field name="dognet_spcontact.koddoc"></editor-field>
							</fieldset>
						</div>
<!--
						<div class="Block100 fieldset-table-row" style="padding-top:25px">
							<div class="fieldset-table-cell" style="padding-bottom:3px">
								<fieldset>
									<editor-field name="docunlink"></editor-field>
								</fieldset>
							</div>
							<div class="fieldset-table-cell" style="width:100%">
								<div><div class="chekbox-inline-text">Отменить привязку к договору</div></div>
							</div>
						</div>
-->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
