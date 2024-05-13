<?php
// ----- ----- ----- ----- -----
// Подключаем стили для формы
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/sp/sp-details/restr_5/tabs/css/sp-details-tab3_object-customform.css">
<div id="customForm-tab3_object">
	<div class="sp-details-tabs" style="width:100%">
		<ul id="" class="nav nav-tabs sp-details-tabs-menu">
			<li class="active"><a data-toggle="tab" href="#tab3_object-tab-1" title="">Название объекта</a></li>
			<li><a data-toggle="tab" href="#tab3_object-tab-2" title="">Видимость для ГИПа</a></li>
		</ul>
		<div class="tab-content" style="padding:5px">
			<div id="tab3_object-tab-1" class="tab-pane fade in active">
				<div class="Section">
					<div class="Block100">
						<legend>Название</legend>
						<fieldset class="field100">
							<editor-field name="nameobjectshot"></editor-field>
						</fieldset>
						<fieldset class="field100">
							<editor-field name="nameobjectlong"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
			<div id="tab3_object-tab-2" class="tab-pane fade">
				<div class="Section">
					<div class="Block100">
						<legend>Видимость для ГИПа</legend>
						<fieldset class="field100">
							<editor-field name="kodusegip"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
