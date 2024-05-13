<?php
// ----- ----- ----- ----- -----
// Подключаем стили для формы
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/sp/sp-details/restr_3/tabs/css/sp-details-tab2_subpodr-customform.css">
<div id="customForm-tab2_subpodr">
	<div class="sp-details-tabs" style="width:100%">
		<ul id="" class="nav nav-tabs sp-details-tabs-menu">
			<li class="active"><a data-toggle="tab" href="#tab2_subpodr-tab-1" title="">Название организации</a></li>
		</ul>
		<div class="tab-content" style="padding:5px">
			<div id="tab2_subpodr-tab-1" class="tab-pane fade in active">
				<div class="Section">
					<div class="Block100">
						<legend>Название</legend>
						<fieldset class="field100">
							<editor-field name="namesubpodrshot"></editor-field>
						</fieldset>
						<fieldset class="field100">
							<editor-field name="namesubpodrlong"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
