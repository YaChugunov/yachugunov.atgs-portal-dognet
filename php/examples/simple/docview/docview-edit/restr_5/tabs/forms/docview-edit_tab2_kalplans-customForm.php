<?php
// ----- ----- ----- ----- -----
// Форма редактирования этапа
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-edit/restr_5/tabs/css/docview-edit-tab2_kalplans-customForm.css">
<div id="customForm_tab2_kalplans">
	<div class="doc-editor-tabs" style="width:100%">
		<ul id="" class="nav nav-tabs doc-editor-tabs-menu">
			<li class="active"><a data-toggle="tab" href="#doc-editor-tab2-1" title=""><span id="doc-editor-menu-tab-1-errmsg"></span>Общая информация</a></li>
			<li><a data-toggle="tab" href="#doc-editor-tab2-2" title=""><span id="doc-editor-menu-tab-2-errmsg"></span>Сроки</a></li>
			<li><a data-toggle="tab" href="#doc-editor-tab2-3" title=""><span id="doc-editor-menu-tab-3-errmsg"></span>Распределение авансов</a></li>
			<li><a data-toggle="tab" href="#doc-editor-tab2-4" title=""><span id="doc-editor-menu-tab-4-errmsg"></span>Планирование</a></li>
		</ul>
		<div class="tab-content" style="padding:5px">
			<div id="doc-editor-tab2-1" class="tab-pane fade in active">
				<div class="Section">
					<div class="Block100">
						<legend>Общая информация <span id="sumctrl_msg" style="font-weight:300; font-size:0.8em; float:right; padding-right:10px; line-height:1.8em"></span>
						</legend>
						<div class="Block100">
							<fieldset class="field15">
								<editor-field name="dognet_dockalplan.numberstage"></editor-field>
							</fieldset>
							<fieldset class="field40">
								<editor-field name="dognet_dockalplan.summastage"></editor-field>
							</fieldset>
							<fieldset class="field45">
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
					<div class="Block50">
						<legend>Сроки выполнения</legend>
						<div class="Block100">
							<fieldset class="field50">
								<editor-field name="dognet_dockalplan.idsrokstage"></editor-field>
							</fieldset>
							<fieldset id="srokstage" class="field50">
								<editor-field name="dognet_dockalplan.srokstage"></editor-field>
							</fieldset>
							<fieldset id="srokstage_date" class="field50">
								<editor-field name="dognet_dockalplan.srokstage_date"></editor-field>
							</fieldset>
						</div>
						<div id="check-idobjectready" class="Block100" style="">
							<div class="fieldset-table-row" style="">
								<div class="fieldset-table-cell" style="padding-bottom:3px">
									<fieldset class="field100">
										<editor-field name="dognet_dockalplan.idobjectready"></editor-field>
									</fieldset>
								</div>
								<div class="fieldset-table-cell" style="width:100%">
									<div>
										<div class="chekbox-inline-text">При готовности объекта</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="Block50">
						<legend>Сроки оплаты</legend>
						<fieldset class="field50">
							<editor-field name="dognet_dockalplan.idsrokopl"></editor-field>
						</fieldset>
						<fieldset class="field50">
							<editor-field name="dognet_dockalplan.srokopl"></editor-field>
						</fieldset>
						<legend>Гарантийный срок</legend>
						<fieldset class="field75">
							<editor-field name="dognet_dockalplan.warranty_period"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
			<div id="doc-editor-tab2-3" class="tab-pane fade">
				<div class="Section">
					<div class="Block100">
						<legend>Распределение авансов (для планирования)</legend>
						<div style="display:block; width:100%; text-align:right"><span id="ajaxFirstAvansOut" class="text-danger"></span></div>
						<div class="Block50" style="margin-top:10px">
							<p class="" style="display:block; width:100%; margin-bottom:0; font-weight:700">1-ый аванс
								(планируемый, не реально полученный)</p>
							<div style="display:flex ">
								<fieldset class="useavplan">
									<editor-field name="dognet_dockalplan.useav1plan"></editor-field>
								</fieldset>
								<fieldset class="pravplanstage">
									<editor-field name="dognet_dockalplan.pravplan1stage"></editor-field>
								</fieldset>
								<fieldset class="dateplanavstage">
									<editor-field name="dognet_dockalplan.dateplanav1stage"></editor-field>
								</fieldset>
							</div>
							<p class="" style="display:block; width:100%; margin-bottom:0; font-weight:700">2-ой аванс
								(дата/дни после 1-го полученного аванса)</p>
							<div style="display:flex">
								<fieldset class="useavplan">
									<editor-field name="dognet_dockalplan.useav2plan"></editor-field>
								</fieldset>
								<fieldset class="pravplanstage">
									<editor-field name="dognet_dockalplan.pravplan2stage"></editor-field>
								</fieldset>
								<fieldset class="dateplanavstage">
									<editor-field name="dognet_dockalplan.dateplanav2stage"></editor-field>
								</fieldset>
								<fieldset class="daysplanavstage">
									<editor-field name="dognet_dockalplan.daysplanav2stage"></editor-field>
								</fieldset>
							</div>
						</div>
						<div class="Block50" style="margin-top:10px">
							<p class="" style="display:block; width:100%; margin-bottom:0; font-weight:700">3-ий аванс
								(дата/дни после 1-го полученного аванса)</p>
							<div style="display:flex">
								<fieldset class="useavplan">
									<editor-field name="dognet_dockalplan.useav3plan"></editor-field>
								</fieldset>
								<fieldset class="pravplanstage">
									<editor-field name="dognet_dockalplan.pravplan3stage"></editor-field>
								</fieldset>
								<fieldset class="dateplanavstage">
									<editor-field name="dognet_dockalplan.dateplanav3stage"></editor-field>
								</fieldset>
								<fieldset class="daysplanavstage">
									<editor-field name="dognet_dockalplan.daysplanav3stage"></editor-field>
								</fieldset>
							</div>
							<p class="" style="display:block; width:100%; margin-bottom:0; font-weight:700">4-ый аванс
								(дата/дни после 1-го полученного аванса)</p>
							<div style="display:flex">
								<fieldset class="useavplan">
									<editor-field name="dognet_dockalplan.useav4plan"></editor-field>
								</fieldset>
								<fieldset class="pravplanstage">
									<editor-field name="dognet_dockalplan.pravplan4stage"></editor-field>
								</fieldset>
								<fieldset class="dateplanavstage">
									<editor-field name="dognet_dockalplan.dateplanav4stage"></editor-field>
								</fieldset>
								<fieldset class="daysplanavstage">
									<editor-field name="dognet_dockalplan.daysplanav4stage"></editor-field>
								</fieldset>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="doc-editor-tab2-4" class="tab-pane fade">
				<div class="Section">
					<div class="Block100">
						<legend>Планирование</legend>
						<div class="Block100">
							<fieldset class="field25">
								<editor-field name="dognet_dockalplan.dateplanbegin"></editor-field>
							</fieldset>
							<fieldset class="field25">
								<editor-field name="dognet_dockalplan.dateplan"></editor-field>
							</fieldset>
							<fieldset class="field25">
								<editor-field name="dognet_dockalplan.numberdayoplstage"></editor-field>
							</fieldset>
							<fieldset class="field25">
								<editor-field name="dognet_dockalplan.dateoplall"></editor-field>
							</fieldset>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>