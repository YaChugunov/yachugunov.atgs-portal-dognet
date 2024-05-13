<?php
// ----- ----- ----- ----- -----
// Подключаем стили для формы
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/agreeview/agreeview-current/restr_4/css/agreeview-current-customform.css">
<div id="customForm-doc-main">
	<div class="doc-editor-tabs" style="width:100%">
				<ul id="" class="nav nav-tabs doc-editor-tabs-menu">
					<li class="active"><a data-toggle="tab" href="#doc-editor-tab-1" title=""><span id="doc-editor-menu-tab-1-errmsg"></span>Параметры</a></li>
					<li><a data-toggle="tab" href="#doc-editor-tab-2" title=""><span id="doc-editor-menu-tab-2-errmsg"></span>Название и сроки</a></li>
					<li><a data-toggle="tab" href="#doc-editor-tab-3" title=""><span id="doc-editor-menu-tab-3-errmsg"></span>Финансовая часть</a></li>
					<li><a data-toggle="tab" href="#doc-editor-tab-4" title=""><span id="doc-editor-menu-tab-4-errmsg"></span>Комментарии</a></li>
				</ul>
				<div class="tab-content" style="padding:5px">
					<div id="doc-editor-tab-1" class="tab-pane fade in active">
						<div class="Section">
								<div class="Block30">
									<legend>Обоснование соглашения</legend>
									<div class="Block100">
										<div class="Block100 fieldset-table-row">
											<div class="fieldset-table-cell" style="padding-bottom:3px">
												<fieldset>
													<editor-field name="dognet_agreebase.usedocruk"></editor-field>
												</fieldset>
											</div>
											<div class="fieldset-table-cell" style="width:100%">
												<div><div class="chekbox-inline-text">По указанию руководства</div></div>
											</div>
										</div>
									</div>
								</div>
								<div class="Block70">
									<legend>Свойства соглашения</legend>
									<fieldset class="field70">
										<editor-field name="dognet_agreebase.kodzakaz"></editor-field>
									</fieldset>
									<fieldset class="field30 kodzakazFilter" style="padding-top:30px; padding-right:15px">
										<input id="kodzakaz_filter" type="text" placeholder="Поиск в Заказчиках"/>
									</fieldset>
								</div>
								<div class="Block100">
									<legend>Исполнители</legend>
									<fieldset class="field50">
										<editor-field name="dognet_agreebase.kodispol"></editor-field>
									</fieldset>
									<fieldset class="field50">
										<editor-field name="dognet_agreebase.kodispolruk"></editor-field>
									</fieldset>
								</div>
						</div>
					</div>
					<div id="doc-editor-tab-2" class="tab-pane fade">
						<div class="Section">
							<div class="Block100">
								<legend>Наименование и сроки</legend>
								<div class="Block20">
									<fieldset class="field100">
										<editor-field name="dognet_agreebase.docnumber"></editor-field>
									</fieldset>
									<fieldset class="field100">
										<editor-field name="docDateBegin"></editor-field>
									</fieldset>
									<fieldset class="field100">
										<editor-field name="docDateEnd"></editor-field>
									</fieldset>
								</div>
								<div class="Block80">
									<fieldset class="field100">
										<editor-field name="dognet_agreebase.docnameshot"></editor-field>
									</fieldset>
									<fieldset class="field100">
										<editor-field name="dognet_agreebase.docnamefullm"></editor-field>
									</fieldset>
								</div>
							</div>
						</div>
					</div>
					<div id="doc-editor-tab-3" class="tab-pane fade">
						<div class="Section">
								<div class="Block100">
									<legend>Финансы</legend>
									<fieldset class="field30">
										<editor-field name="dognet_agreebase.koddened"></editor-field>
									</fieldset>
									<fieldset class="field20">
										<editor-field name="dognet_agreebase.docsumma"></editor-field>
									</fieldset>
									<fieldset class="field10">
										<editor-field name="dognet_agreebase.usendssumma"></editor-field>
									</fieldset>
								</div>
						</div>
					</div>
					<div id="doc-editor-tab-4" class="tab-pane fade">
						<div class="Section">
								<div class="Block100">
									<legend>Комментарии</legend>
									<fieldset class="field100">
										<editor-field name="dognet_agreebase.comments"></editor-field>
									</fieldset>
								</div>
						</div>
					</div>
				</div>
	</div>
</div>
