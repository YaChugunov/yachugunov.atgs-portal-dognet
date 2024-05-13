
<?php
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
?>

	<div id="doc-details-tabs" class="doc-details-tabs" style="width:100%">
		<ul id="doc-details-tabs-menu" class="nav nav-tabs doc-details-tabs-menu">
			<li class="active"><a data-toggle="tab" href="#doc-details-tab1-1" title="">Общая информация</a></li>
			<li><a data-toggle="tab" href="#doc-details-tab1-2" title="">Исполнители</a></li>
			<li><a data-toggle="tab" href="#doc-details-tab1-3" title="">Финансы</a></li>
			<li><a data-toggle="tab" href="#doc-details-tab1-4" title="">Заказчик</a></li>
			<li><a data-toggle="tab" href="#doc-details-tab1-5" title="">Этапы</a></li>
			<li><a data-toggle="tab" href="#doc-details-tab1-6" title="">Комментарии</a></li>
		</ul>
		<div class="tab-content" style="padding:5px; width:100%">
			<div id="doc-details-tab1-1" class="tab-pane fade in active">
				<?php	include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/docview/docview-details/restr_3/tabs/dognet-docview-details(restr_3)-tab1_common.php"); ?>
			</div>
			<div id="doc-details-tab1-2" class="tab-pane fade">
				<?php	include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/docview/docview-details/restr_3/tabs/dognet-docview-details(restr_3)-tab1_ispolniteli.php"); ?>
			</div>
			<div id="doc-details-tab1-3" class="tab-pane fade">
				<?php	include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/docview/docview-details/restr_3/tabs/dognet-docview-details(restr_3)-tab1_finances.php"); ?>
			</div>
			<div id="doc-details-tab1-4" class="tab-pane fade">
				<?php	include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/docview/docview-details/restr_3/tabs/dognet-docview-details(restr_3)-tab1_zakazchik.php"); ?>
			</div>
			<div id="doc-details-tab1-5" class="tab-pane fade">
				<?php	include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/docview/docview-details/restr_3/tabs/dognet-docview-details(restr_3)-tab1_kalplans.php"); ?>
			</div>
			<div id="doc-details-tab1-6" class="tab-pane fade">
				<?php	include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/docview/docview-details/restr_3/tabs/dognet-docview-details(restr_3)-tab1_comments.php"); ?>
			</div>
		</div>
	</div>
