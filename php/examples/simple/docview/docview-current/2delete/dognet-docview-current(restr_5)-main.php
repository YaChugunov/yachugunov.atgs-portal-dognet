
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/date-de.js"></script>
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/moment-with-locales.js"></script>

<!-- Custom Table style -->
	<link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/css/docview-table-current-tab2-custom.css">
<!-- Custom Form Editor style -->
	<link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/css/docview-customForm-current-tab2-Editor.css">

<script type="text/javascript" language="javascript" class="init">

var table_tab2;		// use a global for the submit and return data rendering in the examples

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

$(document).ready(function() {

	table_tab2 = $('#docview-current-tab2').DataTable( {
// 		dom: "<'row'<'col-md-8 col-sm-12'><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'lftip>>",
		dom: "<'space50'r>ftip",
		language: {	url: "russian.json" },
		ajax: {
			url: "php/examples/php/docview/docview-current/dognet-docview-current-main-process.php",
			type: "POST"
		},
		serverSide: true,
		columns: [
			{ data: "docnumber", className: "text-center" },
			{ data: "docnameshot" }, 
			{
				data: null,
				defaultContent: '<a href="#" class="edit_listalt"><span class="glyphicon glyphicon-list-alt"></span></a>' 
			}
		],
		select: {
			style: 'os',
			selector: 'td:not(:last-child)' // no row selection on last column
		},
		columnDefs: [
			{ orderable: true, searchable: true, targets: 0 },
			{ orderable: false, searchable: false, targets: 1 }, 
			{ 
				orderable: false, 
				searchable: false, 
				targets: 2, 
				render: function ( data, type, row, meta ) {
					return '<a href="dognet-docview.php?docview_type=details&uniqueID='+row.koddoc+'"><span class="glyphicon glyphicon-list-alt"></span></a>';
				} 
			} 
		], 
		order: [ [ 0, "desc" ] ],
		select: false,
		processing: true,
		paging: true,
		searching: true,
		pageLength: 15, 
		lengthChange: false,
		lengthMenu: [ [15, 30, 50, -1], [15, 30, 50, "Все"] ]
	} );

} );
</script>

		<section>
			<div class="demo-html"></div>
			<table id="docview-current-tab2" class="table table-condensed" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th width="5%" class="text-center">№</th>
						<th>Краткое название</th>
						<th width="2%" class="text-center"></th>
					</tr>
				</thead>
			</table>
		</section>
