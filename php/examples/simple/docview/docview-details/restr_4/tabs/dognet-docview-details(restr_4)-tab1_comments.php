
<script type="text/javascript" language="javascript" class="init">

var editor_tab1_comments;		// use a global for the submit and return data rendering in the examples
var table_tab1_comments;		// use a global for the submit and return data rendering in the examples

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

$(document).ready(function() {
	table_tab1_comments = $('#docview-details-tab1_comments').DataTable( {
// 		dom: "<'row space20'<'col-md-8 col-sm-12'><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'ltip>>",
		dom: "t",
		language: {
			url: "russian.json"
		},
		ajax: {
			url: "php/examples/php/docview/docview-details/dognet-docview-details-tab1_comments-process.php",
			type: "POST"
		},
		serverSide: true,
		columns: [
			{ data: "dognet_docbase.docnumber", className: "text-center" }
		],
		select: false,
		processing: false,
		paging: false,
		searching: false,
		lengthChange: false,
		createdRow: function( row, d, dataIndex ) {
			rowData = table_tab1_comments.row( row );
			rowData.child( <?php include('templates/docview-details_tab1_comments.tpl'); ?> ).show();
		}
	} );
} );
</script>
<?php
// ----- ----- ----- ----- -----
// Подключаем стили для таблицы
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-details/restr_4/tabs/css/docview-details-common-tab1_comments.css">
<section>
	<div id="tab1_comments">
		<h3 class="docview-details-title2">Комментарий к договору</h3>
		<div class="demo-html"></div>
		<table id="docview-details-tab1_comments" class="table" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th></th>
				</tr>
			</thead>
		</table>
	</div>
</section>
