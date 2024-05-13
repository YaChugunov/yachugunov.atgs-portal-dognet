
<script type="text/javascript" language="javascript" class="init">

var editor_tab1_ispolniteli;		// use a global for the submit and return data rendering in the examples
var table_tab1_ispolniteli;		// use a global for the submit and return data rendering in the examples

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

$(document).ready(function() {
	table_tab1_ispolniteli = $('#chetview-details-tab1_ispolniteli').DataTable( {
// 		dom: "<'row space20'<'col-md-8 col-sm-12'><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'ltip>>",
		dom: "t",
		language: {
			url: "russian.json"
		},
		ajax: {
			url: "php/examples/php/chetview/chetview-details/dognet-chetview-details-tab1_ispolniteli-process.php",
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
			rowData.child( <?php include('templates/chetview-details_tab1_ispolniteli.tpl'); ?> ).show();
		}
	} );
} );

</script>

<style>
	#chetview-details-tab1_ispolniteli > thead { display:none }
	#chetview-details-tab1_ispolniteli > tbody > tr:first-child { display:none }
	#chetview-details-tab1_ispolniteli > tbody > tr > td { border:none }
	#chetview-tab1_ispolniteli .panel-title {
		color:#333;
		font-family:'Oswald', sans-serif;
    font-weight:500;
    font-size:1.3em;
    text-transform:uppercase;
    letter-spacing:normal;
    padding:0;
	}
	#chetview-tab1_ispolniteli .panel { border:1px solid #f5f5f5 }
	#row-details-common .title-column, #row-details-ispol .title-column, #row-details-finances .title-column { font-family:'Oswald', sans-serif; font-weight:400 }
	#row-details-common .data-column, #row-details-ispol .data-column, #row-details-finances .data-column { font-family: Courier, Courier new, Serif; font-weight:300 }
/* 	#row-details-tab1_ispolniteli { font-family:'Oswald', sans-serif; font-size:1.0em } */
</style>

<section>

	<div id="chetview-tab1_ispolniteli" class="panel-group" style="padding:0 5px">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="media">
					<div class="media-left media-middle">
						<span class="" style="font-size:1.6em"><span class="glyphicon glyphicon-user"></span></span>
					</div>
					<div class="media-body media-middle">
						<h4 class="panel-title">
						<a data-toggle="collapse" href="#tab1_ispolniteli">Исполнители</a>
						</h4>
					</div>
				</div>
			</div>
			<div id="tab1_ispolniteli" class="panel-collapse collapse">
				<div class="demo-html"></div>
				<table id="chetview-details-tab1_ispolniteli" class="table table-condensed" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th></th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>

</section>
