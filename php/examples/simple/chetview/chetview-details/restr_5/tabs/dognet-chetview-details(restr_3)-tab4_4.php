
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/date-de.js"></script>
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/moment-with-locales.js"></script>

<style>
	#docview-details-tab4_4 > thead { display:none }
	#docview-details-tab4_4 > tbody > tr > td:first-child { width:20px }
	#docview-details-tab4_4 > tbody > tr > td, 
	#docview-details-tab4_4 > tbody > tr > th, 
	#docview-details-tab4_4 > tfoot > tr > td, 
	#docview-details-tab4_4 > tfoot > tr > th, 
	#docview-details-tab4_4 > thead > tr > td, 
	#docview-details-tab4_4 > thead > tr > th { border:none }
	#docview-details-tab4_4 > tbody > tr > td > a { color:#3B7087; text-decoration:underline }
	#docview-details-tab4_4 > tbody > tr > td > a:hover { color:#333; text-decoration:none }
</style>

<script type="text/javascript" language="javascript" class="init">

var editor_tab4_4;		// use a global for the submit and return data rendering in the examples
var table_tab4_4;		// use a global for the submit and return data rendering in the examples

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

$(document).ready(function() {

	table_tab4_4 = $('#docview-details-tab4_4').DataTable( {
// 		dom: "<'row'<'col-md-8 col-sm-12'><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'lftip>>",
		dom: "t",
		language: {
			url: "russian.json"
		},
		ajax: {
			url: "php/examples/php/docview/docview-details/dognet-docview-details-tab4_4-process.php",
			type: "POST"
		},
		serverSide: true,
		columns: [
			{ data: "dognet_docblankwork_files.file_name" }
		],
		select: {
			style: 'os',
			selector: 'td:not(:last-child)' // no row selection on last column
		},
		columnDefs: [
/*
			{ 
				searchable: false, 
				orderable: false, 
				targets: 0 
			}, 
*/
			{ 
				orderable: false, 
				targets: 0, 
				render: 
					function ( data, type, row, meta ) { 
						if (row.dognet_docblankwork_files.blank_status === "CR") {
							return '<a href="'+row.dognet_docblankwork_files.file_url+'" target="_blank">Первоначальная версия бланка.<span style="text-transform:lowercase">'+row.dognet_docblankwork_files.file_extension+'</span></a>';
						}
						else if (row.dognet_docblankwork_files.blank_status === "RD") { 
							return '<a href="'+row.dognet_docblankwork_files.file_url+'" target="_blank">Версия бланка с корректировками отдела договоров.<span style="text-transform:lowercase">'+row.dognet_docblankwork_files.file_extension+'</span></a>';
						} 
						else if (row.dognet_docblankwork_files.blank_status === "DO") { 
							return '<a href="'+row.dognet_docblankwork_files.file_url+'" target="_blank">Окончательная версия бланка.<span style="text-transform:lowercase">'+row.dognet_docblankwork_files.file_extension+'</span></a>';
						} 
						else if (row.dognet_docblankwork_files.blank_status === "GIP") { 
							return '<a href="'+row.dognet_docblankwork_files.file_url+'" target="_blank">Версия бланка ГИП.<span style="text-transform:lowercase">'+row.dognet_docblankwork_files.file_extension+'</span></a>';
						} 
					}
			}
		], 
		select: false,
		processing: false,
		paging: false,
		searching: false,
		lengthChange: false 
/*
		createdRow: function( row, d, i ) {
			rowData = table_tab4_3.row( row );
			if ( d.dognet_blankdocpnr.kodtipblank != d.dognet_docblankwork_files.blank_status ) {
				table_tab4_3.row(i)
					.nodes()
					.to$()
					.hide();
			}
			
			rowData.child( <?php include('templates/docview-details_tab4_3.tpl'); ?> ).show();
		
		}
*/
	} );
/*
	table_tab4_3.on( 'order.dt search.dt', function () {
		table_tab4_3.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
			cell.innerHTML = i+1;
		} );
	} ).draw();
*/
} );


</script>

<section>
	<div class="demo-html"></div>
	<table id="docview-details-tab4_4" class="table table-condensed" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th width="100%"></th>
			</tr>
		</thead>
	</table>
</section>
