<?php
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Форма редактирования оплаты
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-edit/restr_5/tabs/css/docview-edit-tab5_subpodr_oplatachf-customForm.css">
<div id="customForm_tab5_oplchfsubpodr">
  <div class="doc-editor-tabs" style="width:100%">
    <ul id="doc-editor-tabs-menu" class="nav nav-tabs doc-editor-tabs-menu">
      <!-- <li class="active"><a data-toggle="tab" href="#doc-editor-tab5-oplatachf-1" title="">Информация</a></li> -->
      <li class="active"><a data-toggle="tab" href="#doc-editor-tab5-oplatachf-2" title="">Параметры</a></li>
    </ul>
    <div class="tab-content" style="padding:5px">
      <!-- <div id="doc-editor-tab5-oplatachf-1" class="tab-pane fade in active">
				<div class="Section">
					<div class="Block100">
						<legend>Информация</legend>
					</div>
				</div>
			</div> -->
      <div id="doc-editor-tab5-oplatachf-2" class="tab-pane fade in active">
        <div class="Section">
          <div class="Block60">
            <legend>Cчет-фактура</legend>
            <fieldset class="field100">
              <editor-field name="dognet_docoplchfsubpodr.kodchfsubpodr"></editor-field>
            </fieldset>
            <fieldset class="field100">
              <editor-field name="dognet_docoplchfsubpodr.koddocsubpodr"></editor-field>
            </fieldset>
          </div>
          <div class="Block40">
            <legend>Дата и сумма оплаты</legend>
            <fieldset class="field100">
              <editor-field name="dognet_docoplchfsubpodr.dateoplchfsubpodr"></editor-field>
            </fieldset>
            <fieldset class="field100">
              <editor-field name="dognet_docoplchfsubpodr.sumoplchfsubpodr"></editor-field>
            </fieldset>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>