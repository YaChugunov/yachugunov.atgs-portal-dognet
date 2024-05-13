<?php
// ----- ----- ----- ----- -----
// Форма редактирования этапа
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-edit/restr_5/tabs/css/docview-edit-tab2_kalplans-customForm.css">
<div id="customForm_tab2_kalplans">
	<div class="doc-editor-tabs" style="width:100%">
		<ul id="" class="nav nav-tabs doc-editor-tabs-menu">
			<li class="active"><a data-toggle="tab" href="#doc-editor-tab2-1" title="">Общая информация</a></li>
			<li><a data-toggle="tab" href="#doc-editor-tab2-2" title="">Сроки выполнения и оплаты</a></li>
			<li><a data-toggle="tab" href="#doc-editor-tab2-3" title="">Распределение авансов</a></li>
			<li><a data-toggle="tab" href="#doc-editor-tab2-4" title="">Планирование</a></li>
		</ul>
		<div class="tab-content" style="padding:5px">
			<div id="doc-editor-tab2-1" class="tab-pane fade in active">
				<div class="Section">
					<div class="Block100">
						<legend>Общая информация</legend>
						<div class="Block100">
							<fieldset class="field20">
								<editor-field name="dognet_dockalplan.numberstage"></editor-field>
							</fieldset>
							<fieldset class="field20">
								<editor-field name="dognet_dockalplan.summastage"></editor-field>
							</fieldset>
							<fieldset class="field60">
								<editor-field name="dognet_dockalplan.kodobject"></editor-field>
							</fieldset>
						</div>
						<div class="Block100">
							<fieldset class="field100">
								<editor-field name="dognet_dockalplan.nameshotstage"></editor-field>
							</fieldset>
						</div>
						<div class="Block100">
							<fieldset class="field100">
								<editor-field name="dognet_dockalplan.namefullstage"></editor-field>
							</fieldset>
						</div>
					</div>
				</div>
			</div>
			<div id="doc-editor-tab2-2" class="tab-pane fade">
				<div class="Section">
					<div class="Block100">
						<div class="Block50">
							<legend>Сроки выполнения</legend>
							<fieldset class="field50">
								<editor-field name="dognet_dockalplan.idsrokstage"></editor-field>
							</fieldset>
							<fieldset class="field50">
								<editor-field name="dognet_dockalplan.srokstage"></editor-field>
							</fieldset>
						</div>
						<div class="Block50">
							<legend>Сроки оплаты</legend>
							<fieldset class="field50">
								<editor-field name="dognet_dockalplan.idsrokopl"></editor-field>
							</fieldset>
							<fieldset class="field50">
								<editor-field name="dognet_dockalplan.srokopl"></editor-field>
							</fieldset>
						</div>
					</div>
				</div>
			</div>
			<div id="doc-editor-tab2-3" class="tab-pane fade">
				<div class="Section">
					<div class="Block100">
						<legend>Распределение авансов (только для информации)</legend>
						<div class="Block50">
							<fieldset class="useavplan">
								<editor-field name="dognet_dockalplan.useav1plan"></editor-field>
							</fieldset>
							<fieldset class="pravplanstage">
								<editor-field name="dognet_dockalplan.pravplan1stage"></editor-field>
							</fieldset>
							<fieldset class="dateplanavstage">
								<editor-field name="dognet_dockalplan.dateplanav1stage"></editor-field>
							</fieldset>
							<fieldset class="useavplan">
								<editor-field name="dognet_dockalplan.useav2plan"></editor-field>
							</fieldset>
							<fieldset class="pravplanstage">
								<editor-field name="dognet_dockalplan.pravplan2stage"></editor-field>
							</fieldset>
							<fieldset class="dateplanavstage">
								<editor-field name="dognet_dockalplan.dateplanav2stage"></editor-field>
							</fieldset>
						</div>
						<div class="Block50">
							<fieldset class="useavplan">
								<editor-field name="dognet_dockalplan.useav3plan"></editor-field>
							</fieldset>
							<fieldset class="pravplanstage">
								<editor-field name="dognet_dockalplan.pravplan3stage"></editor-field>
							</fieldset>
							<fieldset class="dateplanavstage">
								<editor-field name="dognet_dockalplan.dateplanav3stage"></editor-field>
							</fieldset>
							<fieldset class="useavplan">
								<editor-field name="dognet_dockalplan.useav4plan"></editor-field>
							</fieldset>
							<fieldset class="pravplanstage">
								<editor-field name="dognet_dockalplan.pravplan4stage"></editor-field>
							</fieldset>
							<fieldset class="dateplanavstage">
								<editor-field name="dognet_dockalplan.dateplanav4stage"></editor-field>
							</fieldset>
						</div>
					</div>
				</div>
			</div>
			<div id="doc-editor-tab2-4" class="tab-pane fade">
				<div class="Section">
					<div class="Block100">
						<legend>Планирование</legend>
						<div class="Block100">
							<fieldset class="field35">
								<editor-field name="dognet_dockalplan.dateplan"></editor-field>
							</fieldset>
							<fieldset class="field35">
								<editor-field name="dognet_dockalplan.numberdayoplstage"></editor-field>
							</fieldset>
							<fieldset class="field30">
								<editor-field name="dognet_dockalplan.dateoplall"></editor-field>
							</fieldset>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
