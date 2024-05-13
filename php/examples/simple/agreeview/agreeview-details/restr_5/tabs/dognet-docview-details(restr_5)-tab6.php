<?php
$_QRY_DOC = mysqlQuery( "SELECT * FROM dognet_docsubpodr WHERE koddel <> '99' AND koddoc IN (SELECT koddoc FROM dognet_docbase WHERE koddoc = ".$__uniqueID." AND koddel<>'99')" );
$_QRY_KAL = mysqlQuery( "SELECT * FROM dognet_docsubpodr WHERE koddel <> '99' AND koddoc IN (SELECT kodkalplan FROM dognet_dockalplan WHERE koddoc = ".$__uniqueID." AND koddel<>'99')" );
if (mysqli_num_rows($_QRY_DOC)>0 OR mysqli_num_rows($_QRY_KAL)>0) {
	include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/docview/docview-details/restr_5/tabs/dognet-docview-details(restr_5)-tab6_sub_main.php");
?>
<div id="doc-details-tabs" class="doc-details-tabs" style="width:100%">
	<ul id="doc-details-tabs-menu" class="nav nav-tabs doc-details-tabs-menu">
		<li class="active"><a data-toggle="tab" href="#doc-details-tab6-1" title="">Счета-фактуры</a></li>
		<li><a data-toggle="tab" href="#doc-details-tab6-2" title="">Оплаты счетов-фактур</a></li>
		<li><a data-toggle="tab" href="#doc-details-tab6-3" title="">Авансовые платежи</a></li>
	</ul>
	<div class="tab-content" style="padding:5px; width:100%">
		<div id="doc-details-tab6-1" class="tab-pane fade in active">
			<?php include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/docview/docview-details/restr_5/tabs/dognet-docview-details(restr_5)-tab6_sub_child_chetf.php"); ?>
		</div>
		<div id="doc-details-tab6-2" class="tab-pane fade">
			<?php include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/docview/docview-details/restr_5/tabs/dognet-docview-details(restr_5)-tab6_sub_child_oplatachf.php"); ?>
		</div>
		<div id="doc-details-tab6-3" class="tab-pane fade">
			<?php include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/docview/docview-details/restr_5/tabs/dognet-docview-details(restr_5)-tab6_sub_child_avans.php"); ?>
		</div>
	</div>
</div>
<?php
}
else {
?>
<section>
	<div class="" style="padding-left:5px; padding-right:5px">
		<table id="docview-details-tab6-sub-message-table" class="table table-condensed" cellspacing="0" width="100%">
			<tbody>
				<tr>
					<td class="docview-details-td-message text-center text-danger" style="border-top:none">Договоров субподряда не заключалось</td>
				</tr>
			</tbody>
		</table>
	</div>
</section>
<?php
}
?>
