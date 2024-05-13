
<style>
	#docview-details-tab4_7 > thead { display:none }
	#docview-details-tab4_7 > tbody > tr > td:first-child { width:20px }
	#docview-details-tab4_7 > tbody > tr > td,
	#docview-details-tab4_7 > tbody > tr > th,
	#docview-details-tab4_7 > tfoot > tr > td,
	#docview-details-tab4_7 > tfoot > tr > th,
	#docview-details-tab4_7 > thead > tr > td,
	#docview-details-tab4_7 > thead > tr > th { border:none }
	#docview-details-tab4_7 > tbody > tr > td > a { color:#3B7087; text-decoration:underline }
	#docview-details-tab4_7 > tbody > tr > td > a:hover { color:#333; text-decoration:none }
</style>

<script type="text/javascript" language="javascript" class="init">

var editor_tab4_7;		// use a global for the submit and return data rendering in the examples
var table_tab4_7;		// use a global for the submit and return data rendering in the examples

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

$(document).ready(function() {

	table_tab4_7 = $('#docview-details-tab4_7').DataTable( {
// 		dom: "<'row'<'col-md-8 col-sm-12'><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'lftip>>",
		dom: "t",
		language: {
			url: "php/examples/simple/docview/docview-details/dt_russian-tab4.json"
		},
		ajax: {
			url: "php/examples/php/docview/docview-details/dognet-docview-details-tab4_7-process.php",
			type: "POST"
		},
		serverSide: true,
		columns: [
			{ data: "dognet_docpaper_files.file_name" }
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
						if (data) {
							if (row.dognet_docpaper.paperfull != "") {
								return '<a href="'+row.dognet_docpaper_files.file_url+'" target="_blank">'+row.dognet_docpaper.paperfull+'.<span style="text-transform:lowercase">'+row.dognet_docpaper_files.file_extension+'</span></a>';
								}
							else {
								return '<a href="'+row.dognet_docpaper_files.file_url+'" target="_blank">'+data+'.<span style="text-transform:lowercase">'+row.dognet_docpaper_files.file_extension+'</span></a> (описания файла не найдено, использовано системное имя файла)';
							}
						}
						else { return ""; }
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
	<table id="docview-details-tab4_7" class="table table-striped table-condensed compact display" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th width="100%"></th>
			</tr>
		</thead>
	</table>
</section>
