
<script type="text/javascript" language="javascript" class="init">

var editor_tab1_ispolniteli;		// use a global for the submit and return data rendering in the examples
var table_tab1_ispolniteli;		// use a global for the submit and return data rendering in the examples

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

$(document).ready(function() {
	table_tab1_ispolniteli = $('#docview-details-tab1_ispolniteli').DataTable( {
// 		dom: "<'row space20'<'col-md-8 col-sm-12'><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'ltip>>",
		dom: "t",
		language: {
			url: "russian.json"
		},
		ajax: {
			url: "php/examples/php/docview/docview-details/dognet-docview-details-tab1_ispolniteli-process.php",
			type: "POST"
		},
		serverSide: true,
		columns: [
			{ data: "dognet_docbase.koddoc", visible: false, className: "text-center" }
		],
		select: false,
		processing: false,
		paging: false,
		searching: false,
		lengthChange: false,
		createdRow: function( row, d ) {
			rowData = table_tab1_ispolniteli.row( row );
			rowData.child( <?php include('templates/docview-details_tab1_ispolniteli.tpl'); ?> ).show();
		}
	} );
} );

</script>
<?php
// ----- ----- ----- ----- -----
// Подключаем стили для таблицы
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-details/restr_3/tabs/css/docview-details-common-tab1_ispolniteli.css">
<section>
	<div id="docview-tab1_ispolniteli">
		<h3 class="docview-details-title2">Исполнители</h3>
		<div class="demo-html"></div>
		<table id="docview-details-tab1_ispolniteli" class="table" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th></th>
				</tr>
			</thead>
		</table>
	</div>
</section>
