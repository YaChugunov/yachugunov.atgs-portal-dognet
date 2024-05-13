<?php
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Форма редактирования аванса
// :::
?>
<link rel="stylesheet"
  href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-edit/restr_5/tabs/css/docview-edit-tab5_subpodr_chfavans-customForm.css">
<div id="customForm_tab5_avchfsubpodr">
  <div class="doc-editor-tabs" style="width:100%">
    <ul id="doc-editor-tabs-menu" class="nav nav-tabs doc-editor-tabs-menu">
      <!-- <li><a data-toggle="tab" href="#doc-editor-tab5-chfavans-2" title="">Договор и счет-фактура</a></li> -->
      <li class="active"><a data-toggle="tab" href="#doc-editor-tab5-chfavans-3" title="">Параметры</a></li>
      <!-- <li class="active"><a data-toggle="tab" href="#doc-editor-tab5-chfavans-1" title="">Информация</a></li> -->
    </ul>
    <div class="tab-content" style="padding:5px">
      <!-- <div id="doc-editor-tab5-chfavans-1" class="tab-pane fade in active">
				<div class="Section">
					<div class="Block100">
						<legend>Подсказки и помощь</legend>
					</div>
				</div>
			</div> -->
      <!-- <div id="doc-editor-tab5-chfavans-2" class="tab-pane fade">
				<div class="Section">
				</div>
			</div> -->
      <div id="doc-editor-tab5-chfavans-3" class="tab-pane fade in active">
        <div class="Section">
          <div class="Block100">
            <legend>Договор и счет-фактура</legend>
            <fieldset class="field60">
              <editor-field name="dognet_docavsubpodr.koddocsubpodr"></editor-field>
            </fieldset>
            <fieldset class="field40">
              <editor-field name="dognet_docavsubpodr.kodchfsubpodr"></editor-field>
            </fieldset>
          </div>
          <div class="Block100">
            <legend>Дата и сумма аванса</legend>
            <fieldset class="field30">
              <editor-field name="dognet_docavsubpodr.dateavsubpodr"></editor-field>
            </fieldset>
            <fieldset class="field30">
              <editor-field name="dognet_docavsubpodr.sumavsubpodr"></editor-field>
            </fieldset>
            <fieldset class="field40">
              <editor-field name="cancelAvans"></editor-field>
            </fieldset>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>