
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/date-de.js"></script>
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/moment-with-locales.js"></script>

<style>
	#docview-details-tab4_1 > thead { display:none }
	#docview-details-tab4_1 > tbody > tr > td:first-child { width:20px }
	#docview-details-tab4_1 > tbody > tr > td, 
	#docview-details-tab4_1 > tbody > tr > th, 
	#docview-details-tab4_1 > tfoot > tr > td, 
	#docview-details-tab4_1 > tfoot > tr > th, 
	#docview-details-tab4_1 > thead > tr > td, 
	#docview-details-tab4_1 > thead > tr > th { border:none }
	#docview-details-tab4_1 > tbody > tr > td > a { color:#3B7087; text-decoration:underline }
	#docview-details-tab4_1 > tbody > tr > td > a:hover { color:#333; text-decoration:none }
</style>

<script type="text/javascript" language="javascript" class="init">

var editor_tab4_1;		// use a global for the submit and return data rendering in the examples
var table_tab4_1;		// use a global for the submit and return data rendering in the examples

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

$(document).ready(function() {

	table_tab4_1 = $('#docview-details-tab4_1').DataTable( {
// 		dom: "<'row'<'col-md-8 col-sm-12'><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'lftip>>",
		dom: "t",
		language: {
			url: "russian.json"
		},
		ajax: {
			url: "php/examples/php/docview/docview-details/dognet-docview-details-tab4_1-process.php",
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
			{ 
				orderable: false, 
				targets: 0, 
				render: 
					function ( data, type, row, meta ) { 
						return '<a href="'+row.dognet_docblankwork_files.file_url+'" target="_blank">Итоговый бланк заявки на договор.<span style="text-transform:lowercase">'+row.dognet_docblankwork_files.file_extension+'</span></a>';
					}
			}
		], 
		select: false,
		processing: false,
		paging: false,
		searching: false,
		lengthChange: false
	} );
} );


</script>

<section>
	<div class="demo-html"></div>
	<table id="docview-details-tab4_1" class="table table-condensed" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th width="100%"></th>
			</tr>
		</thead>
	</table>
</section>
