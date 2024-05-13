<?php
// ----- ----- ----- ----- -----
// Форма редактирования поставщика
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/zayvsp/zayvsp-details/restr_5/tabs/css/zayvsp-details-tab_postav-customForm.css">
<div id="customForm-zayvsp-details-tab_postav">
	<div class="doc-editor-tabs" style="width:100%">
		<ul id="" class="nav nav-tabs doc-editor-tabs-menu">
			<li class="active"><a data-toggle="tab" href="#zayvsp-editor-tab-1" title="">Общая</a></li>
			<li><a data-toggle="tab" href="#zayvsp-editor-tab-2" title="">Контакт (DocNET)</a></li>
			<li><a data-toggle="tab" href="#zayvsp-editor-tab-3" title="">Контакт (новый формат)</a></li>
			<li><a data-toggle="tab" href="#zayvsp-editor-tab-4" title="">Доп. информация</a></li>
		</ul>
		<div class="tab-content" style="padding:5px">
			<div id="zayvsp-editor-tab-1" class="tab-pane fade in active">
				<div class="Section">
					<div class="Block100">
						<legend>Общая</legend>
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
						<legend>Контакты (DocNET)</legend>
						<div class="Block50">
							<fieldset class="field100">
								<editor-field name="sp_contragents.postcontactone"></editor-field>
							</fieldset>
						</div>
						<div class="Block50">
							<fieldset class="field100">
								<editor-field name="sp_contragents.postcontactmail"></editor-field>
							</fieldset>
							<fieldset class="field100">
								<editor-field name="sp_contragents.postcontacttel"></editor-field>
							</fieldset>
						</div>
					</div>
				</div>
			</div>
			<div id="zayvsp-editor-tab-3" class="tab-pane fade">
				<div class="Section">
					<div class="Block100">
						<legend>Контакт 1</legend>
						<div class="Block50">
							<fieldset class="field100">
								<editor-field name="sp_contragents.cont1_name"></editor-field>
							</fieldset>
							<fieldset class="field100">
								<editor-field name="sp_contragents.cont1_tels"></editor-field>
							</fieldset>
						</div>
						<div class="Block50">
							<fieldset class="field100">
								<editor-field name="sp_contragents.cont1_email"></editor-field>
							</fieldset>
							<fieldset class="field100">
								<editor-field name="sp_contragents.cont1_telm"></editor-field>
							</fieldset>
						</div>
						<?php // ----- ----- ----- ----- ----- 
						?>
						<legend>Контакт 2</legend>
						<div class="Block50">
							<fieldset class="field100">
								<editor-field name="sp_contragents.cont2_name"></editor-field>
							</fieldset>
							<fieldset class="field100">
								<editor-field name="sp_contragents.cont2_tels"></editor-field>
							</fieldset>
						</div>
						<div class="Block50">
							<fieldset class="field100">
								<editor-field name="sp_contragents.cont2_email"></editor-field>
							</fieldset>
							<fieldset class="field100">
								<editor-field name="sp_contragents.cont2_telm"></editor-field>
							</fieldset>
						</div>
						<?php // ----- ----- ----- ----- ----- 
						?>
						<legend>Контакт 3</legend>
						<div class="Block50">
							<fieldset class="field100">
								<editor-field name="sp_contragents.cont3_name"></editor-field>
							</fieldset>
							<fieldset class="field100">
								<editor-field name="sp_contragents.cont3_tels"></editor-field>
							</fieldset>
						</div>
						<div class="Block50">
							<fieldset class="field100">
								<editor-field name="sp_contragents.cont3_email"></editor-field>
							</fieldset>
							<fieldset class="field100">
								<editor-field name="sp_contragents.cont3_telm"></editor-field>
							</fieldset>
						</div>
					</div>
				</div>
			</div>
			<div id="zayvsp-editor-tab-4" class="tab-pane fade">
				<div class="Section">
					<div class="Block100">
						<legend>Дополнительная информация</legend>
						<fieldset class="field100">
							<editor-field name="sp_contragents.postcontactmore"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>