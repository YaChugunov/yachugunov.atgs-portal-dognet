<?php
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Форма редактирования аванса
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-edit/restr_5/tabs/css/docview-edit-tab5_subpodr_chfavanssplit-customForm.css">
<div id="customForm_tab5_avsplitsubpodr">
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
            <legend>
              Счет-фактура и сплит
            </legend>
            <div class="Block100" style="justify-content:end">
              <div class="" style="float:right; font-family:'Play', sans-serif; font-size:1.0em; font-weight:500; color:#999; padding: 0 15px">
                Аванс&nbsp;<span id="calcAvans-valuesDB-sumav" class="small" style="font-weight:700; color:#111"></span>&nbsp;&middot;&nbsp;В
                сплите&nbsp;<span id="calcAvans-valuesDB-sumavsplit" class="small" style="font-weight:700; color:#111"></span>&nbsp;&middot;&nbsp;Зачтено&nbsp;<span id="calcAvans-valuesDB-sumavchfsplit" class="small" style="font-weight:700; color:#111"></span>&nbsp;&middot;&nbsp;Незачтенный
                остаток&nbsp;<span id="calcAvans-valuesDB-sumavost" class="small" style="font-weight:700; color:#111"></span>
              </div>
            </div>
            <fieldset class="field40">
              <editor-field name="dognet_docavsplitsubpodr.kodchfsubpodr"></editor-field>
            </fieldset>
            <fieldset class="field15">
              <editor-field name="cancelChf"></editor-field>
            </fieldset>
            <fieldset class="field20">
              <editor-field name="dognet_docavsplitsubpodr.dateavsplit"></editor-field>
            </fieldset>
            <fieldset class="field25">
              <editor-field name="dognet_docavsplitsubpodr.sumavsplit"></editor-field>
            </fieldset>
            <fieldset class="field25">
              <editor-field name="dognet_docavsplitsubpodr.kodavsubpodr"></editor-field>
            </fieldset>
            <fieldset class="field25">
              <editor-field name="dognet_docavsplitsubpodr.koddocsubpodr"></editor-field>
            </fieldset>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>