
<?php
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
?>

	<div id="doc-details-tabs" class="doc-details-tabs" style="width:100%">
		<ul id="doc-details-tabs-menu" class="nav nav-tabs doc-details-tabs-menu">
			<li class="active"><a data-toggle="tab" href="#doc-details-tab10-1" title="">Из заявки ГИПа</a></li>
			<li><a data-toggle="tab" href="#doc-details-tab10-2" title="">Из справочника Контактов</a></li>
			<li><a data-toggle="tab" href="#doc-details-tab10-3" title="">Из справочника Заказчиков</a></li>
		</ul>
		<div class="tab-content" style="padding:5px; width:100%">
			<div id="doc-details-tab10-1" class="tab-pane fade in active">
				<?php	include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/docview/docview-details/restr_4/tabs/dognet-docview-details(restr_4)-tab10_contblank.php"); ?>
			</div>
			<div id="doc-details-tab10-2" class="tab-pane fade">
				<?php	include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/docview/docview-details/restr_4/tabs/dognet-docview-details(restr_4)-tab10_contsp.php"); ?>
			</div>
			<div id="doc-details-tab10-3" class="tab-pane fade">
				<?php	include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/docview/docview-details/restr_4/tabs/dognet-docview-details(restr_4)-tab10_contzakaz.php"); ?>
			</div>
		</div>
	</div>
