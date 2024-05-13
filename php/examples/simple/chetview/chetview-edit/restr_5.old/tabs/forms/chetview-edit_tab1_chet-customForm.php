<?php
// ----- ----- ----- ----- -----
// Форма редактирования договора
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/chetview/chetview-edit/restr_5/tabs/css/chetview-edit-tab1_chet-customForm.css">
<div id="customForm_tab1_chet">
	<div class="doc-editor-tabs" style="width:100%">
		<ul id="" class="nav nav-tabs doc-editor-tabs-menu">
			<li class="active"><a data-toggle="tab" href="#doc-editor-tab1-1" title="">Параметры</a></li>
			<li><a data-toggle="tab" href="#doc-editor-tab1-2" title="">Название и сроки</a></li>
			<li><a data-toggle="tab" href="#doc-editor-tab1-3" title="">Комментарии</a></li>
		</ul>
		<div class="tab-content" style="padding:5px">
			<div id="doc-editor-tab1-1" class="tab-pane fade in active">
				<div class="Section">
					<div class="Block60">
						<legend>Параметры и финансы</legend>
						<fieldset class="field60">
							<editor-field name="dognet_docbase.kodobject"></editor-field>
						</fieldset>
						<fieldset class="field40 kodobjectFilter" style="padding-top:30px; padding-right:15px">
							<input id="kodobject_filter" type="text" placeholder="Поиск в Объектах"/>
						</fieldset>
						<fieldset class="field60">
							<editor-field name="dognet_docbase.kodzakaz"></editor-field>
						</fieldset>
						<fieldset class="field40 kodzakazFilter" style="padding-top:30px; padding-right:15px">
							<input id="kodzakaz_filter" type="text" placeholder="Поиск в Заказчиках"/>
						</fieldset>
					</div>
					<div class="Block40">
						<legend>Финансы</legend>
						<fieldset class="field50">
							<editor-field name="dognet_docbase.koddened"></editor-field>
						</fieldset>
						<fieldset class="field50">
							<editor-field name="dognet_docbase.docsumma"></editor-field>
						</fieldset>
						<fieldset class="field100">
							<editor-field name="dognet_docbase.usendssumma"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
			<div id="doc-editor-tab1-2" class="tab-pane fade">
				<div class="Section">
					<div class="Block70">
						<legend>Наименование и сроки</legend>
						<fieldset class="field15">
							<editor-field name="dognet_docbase.docnumber"></editor-field>
						</fieldset>
						<fieldset class="field25">
							<editor-field name="docDateBegin"></editor-field>
						</fieldset>
						<fieldset class="field60">
							<editor-field name="dognet_docbase.docnameshot"></editor-field>
						</fieldset>
					</div>
					<div class="Block30">
						<legend>Тип счета</legend>
						<fieldset class="field100">
							<editor-field name="dognet_docbase.kodtip"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
			<div id="doc-editor-tab1-3" class="tab-pane fade">
				<div class="Section">
					<div class="Block100">
						<legend>Комментарии</legend>
						<fieldset class="field100">
							<editor-field name="dognet_docbase.comments"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
