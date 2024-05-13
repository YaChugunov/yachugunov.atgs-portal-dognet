
<script type="text/javascript" language="javascript" class="init">

var editor_tab1_kalplans;		// use a global for the submit and return data rendering in the examples
var table_tab1_kalplans;		// use a global for the submit and return data rendering in the examples

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

$(document).ready(function() {
	table_tab1_kalplans = $('#chetview-details-tab1_kalplans').DataTable( {
// 		dom: "<'row space20'<'col-md-8 col-sm-12'><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'ltip>>",
		dom: "t",
		language: {
			url: "russian.json"
		},
		ajax: {
			url: "php/examples/php/chetview/chetview-details/dognet-chetview-details-tab1_kalplans-process.php",
			type: "POST"
		},
		serverSide: true,
		columns: [
            {
				class: "details-control",
				searchable: false,
				orderable: false,
				data: null,
				defaultContent: "<span class='glyphicon glyphicon-option-vertical'></span>"
            },
			{ data: "dognet_dockalplan.numberstage", className: "text-center" },
			{ data: "dognet_dockalplan.nameshotstage" },
			{ data: "dognet_dockalplan.dateplan", className: "text-center" },
			{ data: "dognet_dockalplan.summastage" }
		],
		select: {
			style: 'os',
			selector: 'td:first-child'
		},
		columnDefs: [
			{ orderable: false, searchable: false, targets: 0 },
			{ orderable: false, searchable: false, targets: 1 },
			{ orderable: false, searchable: false, targets: 2 },
			{
				orderable: false,
				searchable: false,
				type: "de_date",
				render: function (  data, type, row, meta ) {
					if (data instanceof Date) {
						return moment(data, 'YYYY-MM-DD').format('DD.MM.YYYY');
					}
					else {
						return row.dognet_dockalplan.srokstage;
					}
				},
				targets: 3
			},
			{ orderable: false, searchable: false, render: function ( data, type, row, meta ) {
				if (data != null) {
					return $.fn.dataTable.render.number(' ', ',', 2, '').display( data )+row.dognet_spdened.short_code;
				}
				else {
					return "0.00"+row.dognet_spdened.short_code;
				}
				}, targets: 4
			}
		],
		order: [ [ 1, "asc" ] ],
		select: false,
		processing: false,
		paging: false,
		searching: false,
		lengthChange: false
	} );

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Array to track the ids of the details displayed rows
    var detailRows = [];

    $('#chetview-details-tab1_kalplans tbody').on( 'click', 'tr td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table_tab1_kalplans.row( tr );
        var idx = $.inArray( tr.attr('id'), detailRows );

        if ( row.child.isShown() ) {
            tr.removeClass( 'details' );
            row.child.hide();

            // Remove from the 'open' array
            detailRows.splice( idx, 1 );
        }
        else {
            tr.addClass( 'details' );
			rowData = table_tab1_kalplans.row( row );
			d = row.data();
			rowData.child( <?php include('templates/chetview-details_tab1_kalplans.tpl'); ?> ).show();

// Add to the 'open' array
            if ( idx === -1 ) {
                detailRows.push( tr.attr('id') );
            }
        }
    } );
// On each draw, loop over the `detailRows` array and show any child rows
	table_tab1_kalplans.on( 'draw', function () {
		$.each( detailRows, function ( i, id ) {
		$('#'+id+' td.details-control').trigger( 'click' );
	    } );
	} );

} );

</script>

<style>
/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
#chetview-details-tab1_kalplans {  }
#chetview-details-tab1_kalplans > thead, #chetview-details-tab1_kalplans > tbody {
	font-family: 'Ubuntu', sans-serif;
	font-size: 0.9em;
	color:#666;
	border-bottom:none;
	border-top:none;
}
#chetview-details-tab1_kalplans > thead {
	background-color:#f5f5f5;
	color:#333;
	font-weight: 300;
}
#chetview-details-tab1_kalplans > tbody > tr > td {
    padding: 5px 8px;
    line-height: 1.42857143;
    vertical-align: middle;
}
#chetview-details-tab1_kalplans > thead > tr > th { font-family:'Oswald', sans-serif; font-weight:500; border-bottom:none }
#chetview-details-tab1_kalplans > tbody > tr > td { border-top:none }
/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
#chetview-details-tab1_kalplans > thead > tr > th:first-child, #chetview-details-tab1_kalplans > tbody > tr > td:first-child { width:1%; text-align:center }
#chetview-details-tab1_kalplans > thead > tr > th:nth-child(2), #chetview-details-tab1_kalplans > tbody > tr > td:nth-child(2) { width:4%; text-align:center }
#chetview-details-tab1_kalplans > thead > tr > th:nth-child(2):hover { cursor:default }
#chetview-details-tab1_kalplans .details-control:hover { cursor:pointer }
#chetview-details-tab1_kalplans > thead > tr > th:nth-child(3), #chetview-details-tab1_kalplans > tbody > tr > td:nth-child(3) { width:55% }
#chetview-details-tab1_kalplans > thead > tr > th:nth-child(4), #chetview-details-tab1_kalplans > tbody > tr > td:nth-child(4) { width:15% }
#chetview-details-tab1_kalplans > thead > tr > th:nth-child(5), #chetview-details-tab1_kalplans > tbody > tr > td:nth-child(5) { width:20% }

#chetview-details-tab1_kalplans > tbody > tr > td:nth-child(2), #chetview-details-tab1_kalplans > tbody > tr > td:nth-child(3), #chetview-details-tab1_kalplans > tbody > tr > td:nth-child(4), #chetview-details-tab1_kalplans > tbody > tr > td:nth-child(5) { font-family: Courier, Courier new, Serif; font-weight:300 }
/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
/* 	#chetview-details-tab1_kalplans > thead { display:none } */
/* 	#chetview-details-tab1_kalplans > tbody > tr:first-child { display:none } */
#chetview-details-tab1_kalplans > tbody > tr:first-child  > td { border:none }
/* 	#chetview-details-tab1_kalplans > thead > tr:first-child  > td:first-child { width:2% } */
/* 	#chetview-details-tab1_kalplans > tbody > tr > td { border:none } */
#chetview-tab1_kalplans .panel-title {
	color:#333;
	font-family:'Oswald', sans-serif;
  font-weight:500;
  font-size:1.3em;
  text-transform:uppercase;
  letter-spacing:normal;
  padding:0;
}
#chetview-tab1_kalplans .panel {
    border:1px solid #f5f5f5;
}
#chetview-details-tab1_kalplans .sorting_asc:after { display:none }
#chetview-details-tab1_kalplans > thead > tr > th.sorting_asc { padding-right:8px }
/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
#row-details-tab1_kalplans { font-family:'Oswald', sans-serif; font-size:1.0em }
#row-details-tab1_kalplans > tbody >tr > td { text-align:left }

#chetview-tab1_kalplans .panel { border:1px solid #f5f5f5 }
#row-details-tab1_kalplans .title-column { font-family:'Oswald', sans-serif; font-weight:400 }
#row-details-tab1_kalplans .data-column { font-family: Courier, Courier new, Serif; font-weight:300 }

</style>

<section>

	<div id="chetview-tab1_kalplans" class="panel-group" style="padding:0 5px">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="media">
					<div class="media-left media-middle">
						<span class="" style="font-size:1.6em"><span class="glyphicon glyphicon-calendar"></span></span>
					</div>
					<div class="media-body media-middle">
						<h4 class="panel-title">
						<a data-toggle="collapse" href="#tab1_kalplans">Календарные планы</a>
						</h4>
					</div>
				</div>
			</div>
			<div id="tab1_kalplans" class="panel-collapse collapse">
				<div class="demo-html"></div>
				<table id="chetview-details-tab1_kalplans" class="table" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
							<th class="text-center text-uppercase">Этап</th>
							<th class="text-uppercase">Наименование</th>
							<th class="text-center text-uppercase">Окончание (план)</th>
							<th class="text-uppercase">Сумма</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>

</section>

