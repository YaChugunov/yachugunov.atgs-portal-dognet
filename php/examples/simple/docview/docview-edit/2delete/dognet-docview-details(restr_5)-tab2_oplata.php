
<script type="text/javascript" language="javascript" class="init">

var editor_tab2;		// use a global for the submit and return data rendering in the examples
var table_tab2;		// use a global for the submit and return data rendering in the examples
var table_tab2_chfact;		// use a global for the submit and return data rendering in the examples
var table_tab2_avans;		// use a global for the submit and return data rendering in the examples

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----


function format_chfact ( d ) {
    // `d` is the original data object for the row
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td>'+d.dognet_kalplanchf.chetfdate+' / '+d.chetfnumber+' / '+d.chetfsumma+'</td>'+
        '</tr>'+
    '</table>';
}
function format_oplata ( d ) {
    // `d` is the original data object for the row
    return '<div clas="test">'+d.data()+'</div>';
}

jQuery.fn.dataTable.Api.register( 'sum()', function ( ) {
    return this.flatten().reduce( function ( a, b ) {
        if ( typeof a === 'string' ) {
            a = a.replace(/[^\d.-]/g, '') * 1;
        }
        if ( typeof b === 'string' ) {
            b = b.replace(/[^\d.-]/g, '') * 1;
        }
 
        return a + b;
    }, 0 );
} );


$(document).ready(function() {

	table_tab2 = $('#docview-details-tab2').DataTable( {
// 		dom: "<'row space20'<'col-md-8 col-sm-12'><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'ltip>>",
		dom: "t",
		language: {
			url: "russian.json"
		},
		ajax: {
			url: "php/examples/php/docview/docview-details/dognet-docview-details-tab2_oplata-process.php",
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
			selector: 'td:not(:first-child)'
		},
		columnDefs: [
			{ orderable: false, searchable: false, targets: 0 }, 
			{ orderable: false, searchable: false, targets: 1 }, 
			{ orderable: false, searchable: false, targets: 2 }, 
			{ 
				orderable: false, 
				searchable: false, 
				type: "de_date", 
				render: function ( data ) {
					return moment(data, 'YYYY-MM-DD').format('DD.MM.YYYY');
				}, 
				targets: 3 
			},
			{ orderable: false, searchable: false, targets: 4 } 
		], 
		order: [ [ 1, "asc" ] ],
		processing: false,
		paging: false,
		searching: false,
		lengthChange: false
	} );	



	function createChild( row ) {
		// This is the table we'll convert into a DataTable
		var table_chfact = $('<table id="docview-details-tab2-chfact" class="table" cellspacing="0" width="100%"><thead><tr><th colspan"4">Сумма счетов-фактур</th><th></th><th></th><th></th></tr></thead></table>');

		var table_avans = $('<table id="docview-details-tab2-avans" class="table" cellspacing="0" width="100%"><thead><tr><th>Сумма авансов</th><th></th></tr></thead><tfoot><tr><th></th><th></th></tr></tfoot></table>');
		var table_oplata = $('<table id="docview-details-tab2-oplata" class="table" cellspacing="0" width="100%"><thead><tr><th colspan"3">Сумма оплат</th><th></th><th></th></tr></thead></table>');
		var table_zadolg = $('<table id="docview-details-tab2-zadolg" class="table" cellspacing="0" width="100%"><thead><tr><th colspan"3">Сумма задолженностей</th><th></th><th></th></tr></thead></table>');
		
		// Display it the child row
// 		row.child(table_chfact).show();
// 		row.child(table_avans).show();

		row.child( [ table_chfact, table_avans, table_oplata, table_zadolg ] ).show();
		
		// Initialise as a DataTable
		var table_tab2_chfact = table_chfact.DataTable( {
		// ...

    dom: 't',
    ajax: {
			url: "php/examples/php/docview/docview-details/dognet-docview-details-tab2_oplata_chfact-process.php",
        type: 'post',
        data: function ( d ) {
                d.kodkalplan = row.data().dognet_dockalplan.kodkalplan;
        }
    },
    columns: [
			{ data: "dognet_kalplanchf.kodchfact", className: "text-left" }, 
			{ data: "dognet_kalplanchf.chetfnumber", className: "text-left" }, 
			{ data: "dognet_kalplanchf.chetfdate", className: "text-left" },
			{ data: "dognet_kalplanchf.chetfsumma", className: "text-left" } 
    ],
		columnDefs: [
			{ orderable: false, searchable: false, targets: 0 },  
			{ orderable: false, searchable: false, targets: 1 },  
			{ 
				orderable: false, 
				searchable: false, 
				type: "de_date", 
				render: function ( data ) {
					return moment(data, 'YYYY-MM-DD').format('DD.MM.YYYY');
				}, 
				targets: 2 
			},
			{ orderable: false, searchable: false, targets: 3 } 
		], 
		
      initComplete: function ( row, data ) {
				var api = this.api(), data; 
        // Remove the formatting to get integer data for summation
        var intVal = function ( i ) {
            return typeof i === 'string' ?
                i.replace(/[\$,]/g, '')*1 :
                typeof i === 'number' ?
                    i : 0;
        };

				var column = api.column( 0 );
        // Total over all pages
        total = api.column( 1 ).data().reduce( function (a, b) { return intVal(a) + intVal(b); }, 0 );

        // Update footer
        $( api.column( 0 ).footer() ).html('Всего: ');
        $( api.column( 1 ).footer() ).html(total.toFixed(2));
      }
		 
		} );
// --- --- --- --- ---		
		var table_tab2_avans = table_avans.DataTable( {
		// ...

	    dom: 't',
	    ajax: {
				url: "php/examples/php/docview/docview-details/dognet-docview-details-tab2_oplata_avans-process.php",
					type: 'post',
					data: function ( d ) {
	                d.kodkalplan = row.data().dognet_dockalplan.kodkalplan;
					}
	    },
	    columns: [
				{ data: "dognet_docavans.dateavans", className: "text-left" },
				{ data: "dognet_docavans.summaavans", className: "text-left" }
	    ],
			columnDefs: [
				{ 
					orderable: false, 
					searchable: false, 
					type: "de_date", 
					render: function ( data ) {
						return moment(data, 'YYYY-MM-DD').format('DD.MM.YYYY');
					}, 
					targets: 0 
				},
				{ orderable: false, searchable: false, targets: 1 } 
			], 

      initComplete: function ( row, data ) {
				var api = this.api(), data; 
        // Remove the formatting to get integer data for summation
        var intVal = function ( i ) {
            return typeof i === 'string' ?
                i.replace(/[\$,]/g, '')*1 :
                typeof i === 'number' ?
                    i : 0;
        };

				var column = api.column( 0 );
        // Total over all pages
        total = api.column( 1 ).data().reduce( function (a, b) { return intVal(a) + intVal(b); }, 0 );

        // Update footer
        $( api.column( 0 ).footer() ).html('Всего: ');
        $( api.column( 1 ).footer() ).html(total.toFixed(2));
      }
									
		} );

	}

// ----- ----- ----- ----- ----- 
	function destroyChild(row) {
		var table_chfact = $("#table_chfact", row.child());
		var table_avans = $("#table_avans", row.child());
		table_chfact.detach();
		table_avans.detach();
		table_chfact.DataTable().destroy();
		table_avans.DataTable().destroy();
		// And then hide the row
		row.child.hide();
	}
// ----- ----- ----- ----- ----- 

	table_tab2
		.on( 'select', function () {
// 			table_tab2_chfact.ajax.reload();
// 			table_tab2_avans.ajax.reload();
		} )

		.on( 'deselect', function () {
// 			table_tab2_chfact.ajax.reload();
// 			table_tab2_avans.ajax.reload();
		} );


	$('#docview-details-tab2 tbody').on('click', 'td.details-control', function () {
		var tr = $(this).parents('tr');
		var row = table_tab2.row( tr );
		
		if ( row.child.isShown() ) {
			// This row is already open - close it
			destroyChild(row);
			tr.removeClass('shown');
		}
		else {
			// Open this row
			createChild(row, 'details-body'); // class is for background colour
			tr.addClass('shown');
		}
	} );

} );


</script>

<style>
/* 
----- ----- ----- ----- ----- ----- ----- ----- ----- -----  
*/
#docview-details-tab2 {  }
#docview-details-tab2 > thead, #docview-details-tab2 > tbody {
	font-family: 'Ubuntu', sans-serif;
	font-size: 0.9em;
	color:#666;
	border-bottom:none;
	border-top:none;
}
#docview-details-tab2 > thead { 
	background-color:#666666;
	color:#ffffff;
	font-weight: 200;
}
#docview-details-tab2 > tbody > tr > td {
    padding: 5px 8px;
    line-height: 1.42857143;
    vertical-align: middle;
}
#docview-details-tab2 > thead > tr > th { border-bottom:none }
#docview-details-tab2 > thead > tr > th { border-bottom:none }

#docview-details-tab2 > thead > tr > th:first-child, #docview-details-tab2 > tbody > tr > td:first-child { width:1%; text-align:center }
#docview-details-tab2 > thead > tr > th:nth-child(2), #docview-details-tab2 > tbody > tr > td:nth-child(2) { width:4%; text-align:center }
#docview-details-tab2 > thead > tr > th:nth-child(2):hover { cursor:default }
#docview-details-tab2 .details-control:hover { cursor:hand }
#docview-details-tab2 > thead > tr > th:nth-child(3), #docview-details-tab2 > tbody > tr > td:nth-child(3) { width:55% }
#docview-details-tab2 > thead > tr > th:nth-child(4), #docview-details-tab2 > tbody > tr > td:nth-child(4) { width:15% }
#docview-details-tab2 > thead > tr > th:nth-child(5), #docview-details-tab2 > tbody > tr > td:nth-child(5) { width:20% }

#docview-details-tab2 > tbody > tr > td { border-top:none }
#docview-details-tab2 > tbody > tr.shown { border-radius:10px }
#docview-details-tab2 > tbody > tr.shown > td { border-top:3px #336a86 solid }
#docview-details-tab2 > tbody > tr.shown > td:first-child { border-left:3px #336a86 solid }
#docview-details-tab2 > tbody > tr.shown > td:last-child { border-right:3px #336a86 solid }


#docview-tab2 .panel-title {
	font-size:1.3em;
	font-weight:600;
	text-transform:none;
	padding:0;
}
#docview-tab2 .panel {
    border:1px solid #f5f5f5;
}
#docview-details-tab2 .sorting_asc:after { display:none }
#docview-details-tab2 > thead > tr > th.sorting_asc { padding-right:8px }
#row-details-tab2 { font-family:'Oswald', sans-serif; font-size:1.0em }
#row-details-tab2 > tbody >tr > td { text-align:left }


#docview-details-tab2 > thead { display:none }
/* #docview-details-tab2_wrapper .shown { border:3px #333 solid; border-radius:10px } */
/* #docview-details-tab2 .shown { border:3px #333 solid; border-radius:10px; border-collapse:separate } */
/* #docview-details-tab2_wrapper > table > tbody > tr.shown { border:3px #333 solid; border-radius:10px; border-collapse:collapse } */


#docview-details-tab2 .details-body { border:3px #333 solid; border-radius:10px; border-collapse:collapse }
#end-of-child { border-bottom:3px #333 solid; border-left:3px #333 solid; border-right:3px #333 solid } 
#docview-details-tab2-chfact.table < div < td { border-left:3px #333 solid; border-right:3px #333 solid }
/* 
----- ----- ----- ----- ----- ----- ----- ----- ----- -----  
*/
#docview-details-tab2-chfact {  }
#docview-details-tab2-chfact > thead, #docview-details-tab2-chfact > tbody {
	font-family: 'Ubuntu', sans-serif;
	font-size: 0.9em;
	color:#666;
	border-bottom:none;
	border-top:none;
}
#docview-details-tab2-chfact > thead { 
	background-color:#f5f5f5;
	color:#333;
	font-weight: 300;
}
#docview-details-tab2-chfact > tbody > tr > td {
    padding: 5px 8px;
    line-height: 1.42857143;
    vertical-align: middle;
}
#docview-details-tab2-chfact > thead > tr > th { border-bottom:none }
#docview-details-tab2-chfact > tbody > tr > td { border-top:none }
#docview-details-tab2-chfact > thead > tr > th:first-child, #docview-details-tab2-chfact > tbody > tr > td:first-child { width:15%; text-align:left }
#docview-details-tab2-chfact > thead > tr > th:nth-child(2), #docview-details-tab2-chfact > tbody > tr > td:nth-child(2) { width:15%; text-align:left }
#docview-details-tab2-chfact > thead > tr > th:nth-child(3), #docview-details-tab2-chfact > tbody > tr > td:nth-child(3) { width:70%; text-align:left }
#docview-details-tab2-chfact .sorting_asc:after { display:none }
#docview-details-tab2-chfact > thead > tr > th.sorting_asc { padding-right:8px }

#docview-details-tab2-chfact-sumopl {  }
#docview-details-tab2-chfact-sumopl > thead > tr > th { border-bottom:none }

/* 
----- ----- ----- ----- ----- ----- ----- ----- ----- -----  
*/
#docview-details-tab2-avans {  }
#docview-details-tab2-avans > thead, #docview-details-tab2-avans > tbody {
	font-family: 'Ubuntu', sans-serif;
	font-size: 0.9em;
	color:#666;
	border-bottom:none;
	border-top:none;
}
#docview-details-tab2-avans > thead { 
	background-color:#f5f5f5;
	color:#333;
	font-weight: 300;
}
#docview-details-tab2-avans > tbody > tr > td {
    padding: 5px 8px;
    line-height: 1.42857143;
    vertical-align: middle;
}
#docview-details-tab2-avans > thead > tr > th { border-bottom:none }
#docview-details-tab2-avans > tbody > tr > td { border-top:none }
#docview-details-tab2-avans > thead > tr > th:first-child, #docview-details-tab2-avans > tbody > tr > td:first-child { width:15%; text-align:left }
#docview-details-tab2-avans > thead > tr > th:nth-child(2), #docview-details-tab2-avans > tbody > tr > td:nth-child(2) { width:85%; text-align:left }
#docview-details-tab2-avans .sorting_asc:after { display:none }
#docview-details-tab2-avans > thead > tr > th.sorting_asc { padding-right:8px }
/* 
----- ----- ----- ----- ----- ----- ----- ----- ----- -----  
*/
#docview-details-tab2-oplata {  }
#docview-details-tab2-oplata > thead, #docview-details-tab2-oplata > tbody {
	font-family: 'Ubuntu', sans-serif;
	font-size: 0.9em;
	color:#666;
	border-bottom:none;
	border-top:none;
}
#docview-details-tab2-oplata > thead { 
	background-color:#f5f5f5;
	color:#333;
	font-weight: 300;
}
#docview-details-tab2-oplata > tbody > tr > td {
    padding: 5px 8px;
    line-height: 1.42857143;
    vertical-align: middle;
}
#docview-details-tab2-oplata > thead > tr > th { border-bottom:none }
#docview-details-tab2-oplata > tbody > tr > td { border-top:none }
#docview-details-tab2-oplata > thead > tr > th:first-child, #docview-details-tab2-oplata > tbody > tr > td:first-child { width:15%; text-align:left }
#docview-details-tab2-oplata > thead > tr > th:nth-child(2), #docview-details-tab2-oplata > tbody > tr > td:nth-child(2) { width:85%; text-align:left }
#docview-details-tab2-oplata .sorting_asc:after { display:none }
#docview-details-tab2-oplata > thead > tr > th.sorting_asc { padding-right:8px }
/* 
----- ----- ----- ----- ----- ----- ----- ----- ----- -----  
*/
#docview-details-tab2-zadolg {  }
#docview-details-tab2-zadolg > thead, #docview-details-tab2-zadolg > tbody {
	font-family: 'Ubuntu', sans-serif;
	font-size: 0.9em;
	color:#666;
	border-bottom:none;
	border-top:none;
}
#docview-details-tab2-zadolg > thead { 
	background-color:#f5f5f5;
	color:#333;
	font-weight: 300;
}
#docview-details-tab2-zadolg > tbody > tr > td {
    padding: 5px 8px;
    line-height: 1.42857143;
    vertical-align: middle;
}
#docview-details-tab2-zadolg > thead > tr > th { border-bottom:none }
#docview-details-tab2-zadolg > tbody > tr > td { border-top:none }
#docview-details-tab2-zadolg > thead > tr > th:first-child, #docview-details-tab2-zadolg > tbody > tr > td:first-child { width:15%; text-align:left }
#docview-details-tab2-zadolg > thead > tr > th:nth-child(2), #docview-details-tab2-zadolg > tbody > tr > td:nth-child(2) { width:85%; text-align:left }
#docview-details-tab2-zadolg .sorting_asc:after { display:none }
#docview-details-tab2-zadolg > thead > tr > th.sorting_asc { padding-right:8px }

</style>

<section>
	
	<div class="" style="padding-left:5px; padding-right:5px">
		<div class="space30"></div>
		<div class="demo-html"></div>
		<table id="docview-details-tab2" class="table" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
					<th class="text-center">Этап</th>
					<th>Наименование</th>
					<th>Окончание (план)</th>
					<th>Сумма</th>
				</tr>
			</thead>
		</table>
	</div>

</section>
	
