<?php
// ----- ----- ----- ----- -----
// Подключаем стили для формы
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/sp/sp-details/restr_5/tabs/css/sp-details-tab7_docstatus-customform.css">
<div id="customForm-tab7_docstatus">
	<div class="sp-details-tabs" style="width:100%">
		<ul id="" class="nav nav-tabs sp-details-tabs-menu">
			<li class="active"><a data-toggle="tab" href="#tab7_docstatus-tab-1" title="">Название и описание</a></li>
			<li><a data-toggle="tab" href="#tab7_docstatus-tab-2" title="">Параметры</a></li>
		</ul>
		<div class="tab-content" style="padding:5px">
			<div id="tab7_docstatus-tab-1" class="tab-pane fade in active">
				<div class="Section">
					<div class="Block50">
						<legend>Название и описание статуса</legend>
						<fieldset class="field100">
							<editor-field name="statusnameshot"></editor-field>
						</fieldset>
					</div>
					<div class="Block50">
						<legend>Параметры</legend>
						<fieldset class="field50">
							<editor-field name="numberorder"></editor-field>
						</fieldset>
						<fieldset class="field50">
							<editor-field name="uslreport"></editor-field>
						</fieldset>
					</div>
					<div class="Block100">
						<fieldset class="field100">
							<editor-field name="statusnamefull"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
			<div id="tab7_docstatus-tab-2" class="tab-pane fade">
				<div class="Section">
					<div class="Block100">
						<legend>Использование разделов</legend>
						<div class="Block40 fieldset-table-row">
							<div class="fieldset-table-cell" style="padding-bottom:3px">
								<fieldset>
									<editor-field name="useplandate"></editor-field>
								</fieldset>
							</div>
							<div class="fieldset-table-cell" style="width:100%">
								<div><div class="chekbox-inline-text">USEPLDATE</div></div>
							</div>
						</div>
						<div class="Block30 fieldset-table-row">
							<div class="fieldset-table-cell" style="padding-bottom:3px">
								<fieldset>
									<editor-field name="usedate"></editor-field>
								</fieldset>
							</div>
							<div class="fieldset-table-cell" style="width:100%">
								<div><div class="chekbox-inline-text">USEDATE</div></div>
							</div>
						</div>
						<div class="Block30 fieldset-table-row">
							<div class="fieldset-table-cell" style="padding-bottom:3px">
								<fieldset>
									<editor-field name="enbl_report_missions"></editor-field>
								</fieldset>
							</div>
							<div class="fieldset-table-cell" style="width:100%">
								<div><div class="chekbox-inline-text">ENBLMIS</div></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
