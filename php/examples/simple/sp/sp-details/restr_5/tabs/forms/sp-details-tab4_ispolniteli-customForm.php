<?php
// ----- ----- ----- ----- -----
// Подключаем стили для формы
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/sp/sp-details/restr_5/tabs/css/sp-details-tab4_ispolniteli-customform.css">
<div id="customForm-tab4_ispolniteli">
	<div class="sp-details-tabs" style="width:100%">
		<ul id="" class="nav nav-tabs sp-details-tabs-menu">
			<li class="active"><a data-toggle="tab" href="#tab4_ispolniteli-tab-1" title="">Группа и контакт</a></li>
			<li><a data-toggle="tab" href="#tab4_ispolniteli-tab-2" title="">Доступ к разделам</a></li>
		</ul>
		<div class="tab-content" style="padding:5px">
			<div id="tab4_ispolniteli-tab-1" class="tab-pane fade in active">
				<div class="Section">
					<div class="Block50">
						<legend>Описание исполнителя</legend>
						<fieldset class="field100">
							<editor-field name="ispolnameshot"></editor-field>
						</fieldset>
						<fieldset class="field100">
							<editor-field name="ispolnamefull"></editor-field>
						</fieldset>
					</div>
					<div class="Block50">
						<legend>Имя и email</legend>
						<fieldset class="field100">
							<editor-field name="ispolmanager"></editor-field>
						</fieldset>
						<fieldset class="field100">
							<editor-field name="ispolmail"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
			<div id="tab4_ispolniteli-tab-2" class="tab-pane fade">
				<div class="Section">
					<div class="Block100">
						<legend>Доступ к разделам</legend>
						<fieldset class="field25">
							<editor-field name="kodusedoc"></editor-field>
						</fieldset>
						<fieldset class="field25">
							<editor-field name="kodusezayv"></editor-field>
						</fieldset>
						<fieldset class="field25">
							<editor-field name="kodusegip"></editor-field>
						</fieldset>
						<fieldset class="field25">
							<editor-field name="kodusegipfar"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
