<?php
// ----- ----- ----- ----- -----
// Подключаем стили для формы
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/sp/sp-details/restr_5/tabs/css/sp-details-tab5_ispolniteliruk-customform.css">
<div id="customForm-tab5_ispolniteliruk">
	<div class="sp-details-tabs" style="width:100%">
		<ul id="" class="nav nav-tabs sp-details-tabs-menu">
			<li class="active"><a data-toggle="tab" href="#tab5_ispolniteliruk-tab-1" title="">Название и адрес</a></li>
			<li><a data-toggle="tab" href="#tab5_ispolniteliruk-tab-2" title="">Руководитель</a></li>
		</ul>
		<div class="tab-content" style="padding:5px">
			<div id="tab5_ispolniteliruk-tab-1" class="tab-pane fade in active">
				<div class="Section">
					<div class="Block40">
						<legend>Имя</legend>
						<fieldset class="field100">
							<editor-field name="ispolrukname"></editor-field>
						</fieldset>
						<fieldset class="field100">
							<editor-field name="ispolruknamefull"></editor-field>
						</fieldset>
					</div>
					<div class="Block60">
						<legend>Должность и контакты</legend>
						<fieldset class="field100">
							<editor-field name="ispolrukjob"></editor-field>
						</fieldset>
						<fieldset class="field50">
							<editor-field name="ispolrukemail"></editor-field>
						</fieldset>
						<fieldset class="field50">
							<editor-field name="ispolruktel"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
			<div id="tab5_ispolniteliruk-tab-2" class="tab-pane fade">
				<div class="Section">
					<div class="Block100">
						<legend>Использование разделов</legend>
						<fieldset class="field100">
							<editor-field name="kodrukgip"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
