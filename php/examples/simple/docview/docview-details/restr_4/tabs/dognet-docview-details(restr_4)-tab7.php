<?php
$_QRY_ZAYV = mysqlQuery( "SELECT * FROM dognet_doczayv WHERE koddoc = ".$__uniqueID." AND koddel <> '99'" );
if (mysqli_num_rows($_QRY_ZAYV)>0) {
	include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/docview/docview-details/restr_4/tabs/dognet-docview-details(restr_4)-tab7_zayv_main.php");
?>
<div id="doc-details-tabs" class="doc-details-tabs" style="width:100%">
	<ul id="doc-details-tabs-menu" class="nav nav-tabs doc-details-tabs-menu">
		<li class="active"><a data-toggle="tab" href="#doc-details-tab7-2" title="">Список</a></li>
		<li><a data-toggle="tab" href="#doc-details-tab7-3" title="">Файлы</a></li>
		<li><a data-toggle="tab" href="#doc-details-tab7-5" title="">Счета и счета-фактуры</a></li>
		<li><a data-toggle="tab" href="#doc-details-tab7-6" title="">Файлы из договора</a></li>
	</ul>
	<div class="tab-content" style="padding:5px; width:100%">
		<div id="doc-details-tab7-2" class="tab-pane fade in active">
			<?php include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/docview/docview-details/restr_4/tabs/dognet-docview-details(restr_4)-tab7_zayv_child_dop.php"); ?>
		</div>
		<div id="doc-details-tab7-3" class="tab-pane fade">
			<?php include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/docview/docview-details/restr_4/tabs/dognet-docview-details(restr_4)-tab7_zayv_files.php"); ?>
		</div>
		<div id="doc-details-tab7-4" class="tab-pane fade">
			<?php // include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/docview/docview-details/restr_4/tabs/dognet-docview-details(restr_4)-tab7_zayv_child_dopspec.php"); ?>
		</div>
		<div id="doc-details-tab7-5" class="tab-pane fade">
			<?php include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/docview/docview-details/restr_4/tabs/dognet-docview-details(restr_4)-tab7_zayv_child_chets.php"); ?>
		</div>
		<div id="doc-details-tab7-6" class="tab-pane fade">
			<?php include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/docview/docview-details/restr_4/tabs/dognet-docview-details(restr_4)-tab7_zayv_child_dop-docspec.php"); ?>
		</div>
	</div>
</div>
<?php
}
else {
?>
<section>
	<div class="" style="padding-left:5px; padding-right:5px">
		<table id="docview-details-tab7-zayv-message-table" class="table table-condensed" cellspacing="0" width="100%">
			<tbody>
				<tr>
					<td class="docview-details-td-message text-center text-danger" style="border-top:none">Заявок на заказ оборудования по договору не формировалось</td>
				</tr>
			</tbody>
		</table>
	</div>
</section>
<?php
}
?>
