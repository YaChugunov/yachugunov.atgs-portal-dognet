<?php
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Форма редактирования договора субподряда
// :::
?>
<link rel="stylesheet"
  href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-edit/restr_5/tabs/css/docview-edit-tab5_subpodr-customForm.css">
<div id="customForm_tab5_subpodr">
  <div class="doc-editor-tabs" style="width:100%">
    <ul id="" class="nav nav-tabs doc-editor-tabs-menu">
      <li class="active"><a data-toggle="tab" href="#doc-editor-tab5-subpodr-3" title="">Параметры</a></li>
      <!-- <li class="active"><a data-toggle="tab" href="#doc-editor-tab5-subpodr-1" title="">Информация</a></li> -->
      <li><a data-toggle="tab" href="#doc-editor-tab5-subpodr-2" title="">Организация субподрядчик</a></li>
    </ul>
    <div class="tab-content" style="padding:5px">
      <!-- <div id="doc-editor-tab5-subpodr-1" class="tab-pane fade in active">
				<div class="Section">
					<div class="Block100">
						<legend>Информация</legend>
					</div>
				</div>
			</div> -->
      <div id="doc-editor-tab5-subpodr-3" class="tab-pane fade in active">
        <div class="Section">
          <div class="Block100">
            <legend>Параметры субподряда</legend>
            <fieldset class="field40">
              <editor-field name="dognet_docsubpodr.numberdocsubpodr"></editor-field>
            </fieldset>
            <fieldset class="field30">
              <editor-field name="dognet_docsubpodr.datedocsubpodr"></editor-field>
            </fieldset>
            <fieldset class="field30">
              <editor-field name="dognet_docsubpodr.sumdocsubpodr"></editor-field>
            </fieldset>
            <fieldset class="field100">
              <editor-field name="dognet_docsubpodr.namedocsubpodr"></editor-field>
            </fieldset>
          </div>
        </div>
      </div>
      <div id="doc-editor-tab5-subpodr-2" class="tab-pane fade">
        <div class="Section">
          <div class="Block100">
            <legend>Этап / Организация</legend>
            <fieldset class="field40">
              <editor-field name="dognet_docsubpodr.koddoc"></editor-field>
            </fieldset>
            <fieldset class="field60">
              <editor-field name="dognet_docsubpodr.kodsubpodr"></editor-field>
            </fieldset>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>