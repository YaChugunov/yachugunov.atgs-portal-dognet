
<script type="text/javascript" language="javascript" class="init">

var editor_tab2; 
var table_tab2; 
var table_tab2_chfact; 
var table_tab2_avans; 

total_oplata = 0;
total_avans = 0;

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
function format_chfact ( d ) {
    // `d` is the original data object for the row
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td>'+d.dognet_kalplanchf.chetfdate+' / '+d.chetfnumber+' / '+d.chetfsumma+'</td>'+
        '</tr>'+
    '</table>';
}
// ----- ----- ----- 
function format_oplata ( d ) {
    // `d` is the original data object for the row
    return '<div clas="test">'+d.data()+'</div>';
}
// ----- ----- ----- 
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
// ----- ----- ----- 

$(document).ready(function() {

	table_tab2 = $('#docview-details-tab2').DataTable( {
// 		dom: "<'row space20'<'col-md-8 col-sm-12'><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'ltip>>",
		dom: "t",
		language: {
			url: "php/examples/simple/docview/docview-details/dt_russian-tab2.json"
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
			{ data: "dognet_dockalplan.numberstage", className: "text-left" },
			{ data: "dognet_dockalplan.dateplan", className: "text-left" },
			{ data: "dognet_dockalplan.nameshotstage", className: "text-right text-uppercase" }, 
			{ data: "dognet_kalplanchf.chetfnumber", className: "text-left" },
			{ data: "dognet_kalplanchf.chetfdate", className: "text-center" },
			{ data: "dognet_kalplanchf.chetfsumma" }, 
			{ data: "dognet_dockalplan.summastage", className: "text-right" } 
		],
		columnDefs: [
			{ orderable: false, searchable: false, targets: 0 }, 
			{ orderable: true, searchable: false, render: function ( data ) { return ""; }, targets: 1 }, 
			{ 
				orderable: false, 
				searchable: false, 
				type: "de_date", 
// 				render: function ( data ) { return ""; }, 
				render: function ( data ) {	return "";	}, 
				targets: 2 
			},
			{ orderable: false, searchable: false, render: function ( data ) { return "Счет-фактура № "; }, targets: 3 }, 
			{ orderable: false, searchable: false, render: function ( data ) {	return data;	}, targets: 4 }, 
			{ 
				orderable: false, 
				searchable: false, 
				type: "de_date", 
				render: function ( data ) {	
					if (data instanceof Date) {
						return moment(data, 'YYYY-MM-DD').format('DD.MM.YYYY');	
					}
					else {
						return "---";
					}
				}, 
				targets: 5 
			},
			{ orderable: false, searchable: false, render: function ( data, type, row, meta ) { 
				if (data != null) {
					return $.fn.dataTable.render.number(' ', ',', 2, '').display( data )+row.dognet_spdened.short_code; 
				}
				else {
					return "0.00"+row.dognet_spdened.short_code;
				}
				}, targets: 6 
			}, 
			{ orderable: false, searchable: false, render: function ( data ) { return ""; }, targets: 7 }
		], 
// 		order: [ [ 1, "asc" ] ],
		processing: false,
		paging: false,
		select: false,
		searching: false,
		lengthChange: false, 
		order: [[1, 'asc'], [2, 'asc'], [5, 'desc']],

/*
    rowGroup: {
			enable: true,
      startRender: null,
      endRender: function ( rows, group ) {
				
				var sum = 0;
              			
				rows.every(function(idx) {
                  var cell = rows.cell(idx, 1);
                  var data = parseInt(cell.data());
                  var attr = $(cell.node()).data('typecell');
                  if (attr === 'sum') {
                    sum += data;
                  }
                  else {
                    sum -= data;
                  }                    
                })            

                return $('<tr/>')
                    .append( '<td>Totals '+group+'</td>' )
                    .append( '<td>'+sum.toFixed(2)+'</td>' );
					
					
            },
            dataSrc: 1
        }
*/
/*
		rowGroup: {
			dataSrc: [ 1, 2 ]
		},
*/

		drawCallback: function ( settings ) {
			var api = this.api(), data;
			var rows = api.rows().nodes();
			var last1 = null;
			dened = "";
			api.column(1).data().each( function ( tmp1, i ) { 
				if ( last1 !== tmp1 ) { 
			dened = api.row().data().dognet_spdened.short_code;
// 					datestage = api.row(0).data().dognet_dockalplan.dateplan;
					if (api.row(i).data().dognet_dockalplan.dateplan instanceof Date) { 
						dateplan = moment(api.row(i).data().dognet_dockalplan.dateplan, 'YYYY-MM-DD').format('DD.MM.YYYY');
					} 
					else {
						dateplan = api.row(i).data().dognet_dockalplan.srokstage;
					}
					$(rows).eq( i ).before( 
							'<tr><td colspan="2" class="docview-details-tab2-numberstage">Этап '+tmp1+'</td><td class="docview-details-tab2-dateplan">'+dateplan+'</td><td colspan="4" class="docview-details-tab2-namestage">'+api.row(i).data().dognet_dockalplan.nameshotstage+'</td><td class="docview-details-tab2-summastage">'+$.fn.dataTable.render.number(' ', ',', 2, '').display( api.row(i).data().dognet_dockalplan.summastage )+''+dened+'</td></tr>'
					);
					last1 = tmp1;
				}
			} );
		}
		
	} );	


	function createChild( row ) {
		// This is the table we'll convert into a DataTable
		var table_chfact = $('<table id="docview-details-tab2-chfact" class="table" cellspacing="0" width="100%"><thead><tr><th class="text-uppercase">Счет-фактура</th><th></th><th></th><th></th></tr></thead></table>');

		var table_oplata = $('<table id="docview-details-tab2-oplata" class="table" cellspacing="0" width="100%"><thead><tr><th class="text-uppercase">Данные об оплате</th><th></th><th></th><th></th><th></th></tr></thead><tfoot><tr><th></th><th></th><th></th><th></th><th></th></tr></tfoot></table>');
		var table_avans = $('<table id="docview-details-tab2-avans" class="table" cellspacing="0" width="100%"><thead><tr><th class="text-uppercase">Данные об авансах</th><th></th><th></th><th></th><th></th></tr></thead><tfoot><tr><th></th><th></th><th></th><th></th><th></th></tr></tfoot></table>');
		var table_zadolg = $('<table id="docview-details-tab2-zadolg" class="table" cellspacing="0" width="100%"><thead><tr><th class="text-uppercase">Данные о задолженности</th><th></th><th></th><th></th><th></th></tr></thead><tfoot><tr><th></th><th></th><th></th><th></th><th></th></tr></tfoot></table>');
		
		// Display it the child row
// 		row.child(table_chfact).show();
// 		row.child(table_avans).show();

// 		row.child( [ table_chfact, table_oplata, table_avans, table_zadolg ] ).show();
		row.child( [ table_oplata, table_avans ] ).show();
		
		// Initialise as a DataTable
		var table_tab2_chfact = table_chfact.DataTable( {
		// ...

    dom: 't',
		language: {
			url: "php/examples/simple/docview/docview-details/dt_russian-tab2-chfact.json"
		},
    ajax: {
			url: "php/examples/php/docview/docview-details/dognet-docview-details-tab2_oplata_chfact-process.php",
        type: 'post',
        data: function ( d ) {
                d.kodkalplan = row.data().dognet_kalplanchf.kodchfact;
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
		] 

		} );
// --- --- --- --- ---		
		var table_tab2_oplata = table_oplata.DataTable( {
		// ...

	    dom: 't',
			language: {
				url: "php/examples/simple/docview/docview-details/dt_russian-tab2-oplata.json"
			},
	    ajax: {
				url: "php/examples/php/docview/docview-details/dognet-docview-details-tab2_oplata_chfact_sumopl-process.php",
				type: 'post',
				data: function ( d ) {
	        d.kodchfact = row.data().dognet_kalplanchf.kodchfact;
// 	        console.log("kodchfact: "+d.kodchfact);
					}
	    },
	    columns: [
				{ data: null, defaultContent: "" },
				{ data: null, defaultContent: "Оплачено :", className: "font-courier text-right text-uppercase" },
				{ data: "dognet_oplatachf.dateopl", className: "font-courier text-center" },
				{ data: "dognet_oplatachf.summaopl", className: "font-courier text-right" }, 
				{ data: null, defaultContent: "" }
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
				{ orderable: false, searchable: false, render: function ( data, type, row, meta ) { return $.fn.dataTable.render.number(' ', ',', 2, '').display( data )+row.dognet_spdened.short_code; }, targets: 3 }, 
				{ orderable: false, searchable: false, targets: 4 }
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
        total_oplata = api.column( 3 ).data().reduce( function (a, b) { return intVal(a) + intVal(b); }, 0 );
        dened = "";
        if (api.row().data() != null) {
					dened = api.row().data().dognet_spdened.short_code;
        }
        else {
	        dened = " -.";
        }

        // Update footer
        $( table_tab2_oplata.column( 1 ).footer() ).html('ИТОГО : ');
        $( table_tab2_oplata.column( 3 ).footer() ).html($.fn.dataTable.render.number(' ', ',', 2, '').display( total_oplata )+dened); 
      }
									
		} );
// --- --- --- --- ---		
		var table_tab2_avans = table_avans.DataTable( {
		// ...

	    dom: 't',
			language: {
				url: "php/examples/simple/docview/docview-details/dt_russian-tab2-avans.json"
			},
	    ajax: {
				url: "php/examples/php/docview/docview-details/dognet-docview-details-tab2_oplata_chfact_sumavans-process.php",
				type: 'post',
				data: function ( d ) {
	        d.kodchfact = row.data().dognet_kalplanchf.kodchfact;
// 	        console.log("kodchfact: "+d.kodchfact);
					}
	    },
	    columns: [
				{ data: null, defaultContent: "" },
				{ data: null, defaultContent: "Зачтено :", className: "font-courier text-right text-uppercase" },
				{ data: "dognet_docavans.dateavans", className: "font-courier text-left" },
				{ data: "dognet_docavans.summaavans", className: "font-courier text-right" }, 
				{ data: null, defaultContent: "" }
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
				{ orderable: false, searchable: false, render: function ( data, type, row, meta ) { return $.fn.dataTable.render.number(' ', ',', 2, '').display( data )+row.dognet_spdened.short_code; }, targets: 3 },  
				{ orderable: false, searchable: false, targets: 4 }
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
        total_avans = api.column( 3 ).data().reduce( function (a, b) { return intVal(a) + intVal(b); }, 0 );
        dened = "";
        if (api.row().data() != null) {
					dened = api.row().data().dognet_spdened.short_code;
        }
        else {
	        dened = " -.";
        }

        // Update footer
        $( table_tab2_avans.column( 1 ).footer() ).html('ИТОГО : ');
        $( table_tab2_avans.column( 3 ).footer() ).html($.fn.dataTable.render.number(' ', ',', 2, '').display( total_avans )+dened); 
      }
									
		} );
// --- --- --- --- ---		
		var table_tab2_zadolg = table_zadolg.DataTable( {
		// ...

	    dom: 't',
			language: {
				url: "php/examples/simple/docview/docview-details/dt_russian-tab2-zadolg.json"
			},
	    ajax: {
				url: "php/examples/php/docview/docview-details/dognet-docview-details-tab2_oplata_chfact_sumzadolg-process.php",
				type: 'post',
				data: function ( d ) {
                d.kodkalplan = row.data().dognet_kalplanchf.kodchfact;
// 	        console.log("kodchfact (zadolg): "+d.kodchfact);
					}
	    },
    columns: [
			{ data: null, className: "text-left" }, 
			{ data: null, className: "text-left" }, 
			{ data: null, className: "text-left" },
			{ data: "dognet_kalplanchf.chetfsumma", className: "text-left" },  
			{ data: null, defaultContent: "" }
    ],
		columnDefs: [
			{ orderable: false, searchable: false, render: function ( data ) { return ""; }, targets: 0 },  
			{ orderable: false, searchable: false, render: function ( data ) { return ""; }, targets: 1 },  
			{ orderable: false, searchable: false, render: function ( data ) { return ""; }, targets: 2 },  
			{ orderable: false, searchable: false, render: function ( data, type, row, meta ) { return $.fn.dataTable.render.number(' ', ',', 2, '').display( data - (total_oplata + total_avans) )+row.dognet_spdened.short_code; }, targets: 3 }, 
			{ orderable: false, searchable: false, render: function ( data ) { return ""; }, targets: 4 } 
		]									
		} );

	}

// ----- ----- ----- ----- ----- 
	function destroyChild(row) {
		var table_oplata = $("#docview-details-tab2-oplata", row.child());
		var table_avans = $("#docview-details-tab2-avans", row.child());
		var table_zadolg = $("#docview-details-tab2-zadolg", row.child());
		table_oplata.detach();
		table_avans.detach();
		table_zadolg.detach();
		table_oplata.DataTable().destroy();
		table_avans.DataTable().destroy();
		table_zadolg.DataTable().destroy();
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

    table_tab2
    .on( 'init', function () {
//       console.log( 'Table table_tab2 initialisation complete: '+new Date().getTime() );
// 			console.log("Table table_tab2 recordsTotal: "+table_tab2.page.info().recordsTotal);
			var tr = $('#docview-details-tab2 tbody').parents('tr');
			var row = table_tab2.row( tr );
			createChild(row, 'details-body'); // class is for background colour
			if (table_tab2.page.info().recordsTotal === 0) {
				table_tab2.tables().header().to$().addClass('hide_element');
			}
    } )


} );


</script>

<style>
/* 
----- ----- ----- ----- ----- ----- ----- ----- ----- -----  

ОСНОВНАЯ ТАБЛИЦА

----- ----- ----- ----- ----- ----- ----- ----- ----- -----  
*/
/* 
/* Общее для таблицы */
#docview-details-tab2 {  }
#docview-details-tab2 .details-control:hover { cursor:pointer }
#docview-details-tab2 .font-courier { font-family:courier,courier new,serif }
/* 
/* 
/* Заголовок таблицы */
#docview-details-tab2 > thead {	color:#111; font-family:'Oswald', sans-serif; border-bottom:none;	border-top:none }
#docview-details-tab2 > thead > tr > th { color:#333; border-bottom:none; font-weight:500; font-size:1.3em; text-transform:uppercase }
#docview-details-tab2 > thead > tr > th:first-child { background-color:#f7f7f7; width:1%; text-align:center }
#docview-details-tab2 > thead > tr > th:nth-child(2) { background-color:#f7f7f7; width:4%; text-align:left }
#docview-details-tab2 > thead > tr > th:nth-child(3) { background-color:#f7f7f7; width:4%; text-align:left  }
#docview-details-tab2 > thead > tr > th:nth-child(4) { background-color:#f7f7f7; width:48%; text-align:left  }
#docview-details-tab2 > thead > tr > th:nth-child(5) { background-color:#f0f0f0; width:5%; text-align:center  }
#docview-details-tab2 > thead > tr > th:nth-child(6) { background-color:#f0f0f0; width:10%; text-align:center }
#docview-details-tab2 > thead > tr > th:nth-child(7) { background-color:#f0f0f0; width:14%; text-align:center }
#docview-details-tab2 > thead > tr > th:nth-child(8) { background-color:#f7f7f7; width:13%; text-align:center }
/* 
/* 
/* Тело таблицы */
#docview-details-tab2 > tbody {	font-family:'Oswald', sans-serif; color:#333; border-bottom:none;	border-top:none }
#docview-details-tab2 > tbody > tr > td { border-bottom:none; padding: 5px 8px; line-height: 1.42857143; vertical-align: middle }
#docview-details-tab2 > tbody > tr > td:first-child { width:1%; text-align:center }
#docview-details-tab2 > tbody > tr > td:nth-child(2) { width:4%; text-align:left }
#docview-details-tab2 > tbody > tr > td:nth-child(3) { width:4%; text-align:left }
#docview-details-tab2 > tbody > tr > td:nth-child(4) { width:48%; font-family:courier,courier new,serif; font-size:1.1em; color:#111 }
#docview-details-tab2 > tbody > tr > td:nth-child(5) { width:5%; font-family:courier,courier new,serif; width:5%; text-align:center; background-color:#f1f1f1; color:#111 }
#docview-details-tab2 > tbody > tr > td:nth-child(6) { width:10%; font-family:courier,courier new,serif; text-align:center; background-color:#f1f1f1; color:#111 }
#docview-details-tab2 > tbody > tr > td:nth-child(7) { width:14%; font-family:courier,courier new,serif; text-align:right; background-color:#f1f1f1; color:#111 }
#docview-details-tab2 > tbody > tr > td:nth-child(8) { width:13%; font-size:1.3em; text-align:right }
#docview-details-tab2 > tbody > tr > td.dataTables_empty { text-align:center; border-bottom:1px #951402 solid; border-top:1px #951402 solid; text-transform:uppercase; font-style:italic; color:#951402 }
#docview-details-tab2 > tbody > tr > td.docview-details-tab2-numberstage { font-weight:300; font-size:1.3em; text-transform:uppercase; text-align:left; border-left: 5px #336a86 solid }
#docview-details-tab2 > tbody > tr > td.docview-details-tab2-dateplan { font-weight:300; font-size:1.3em; text-transform:uppercase }
#docview-details-tab2 > tbody > tr > td.docview-details-tab2-namestage { font-weight:300; font-size:1.3em; text-transform:none }
#docview-details-tab2 > tbody > tr > td.docview-details-tab2-summastage { font-weight:300; font-size:1.0em; text-align:right; text-transform:none }
#docview-details-tab2 > tbody > tr > td { border-top:none }
#docview-details-tab2 > tbody > tr.shown > td { background-color:#336a86; color:#fff; font-weight:300 }
/* 
/* 
/* Подвал таблицы */



/* 
/* 
/* Разное */
#docview-tab2 .panel-title { font-size:1.3em; font-weight:600; text-transform:none;	padding:0 }
#docview-tab2 .panel { border:1px solid #f5f5f5 }

#docview-details-tab2 .sorting_asc:after { display:none }
#docview-details-tab2 > thead > tr > th.sorting_asc { padding-right:8px }
#docview-details-tab2 .sorting_desc:after { display:none }
#docview-details-tab2 > thead > tr > th.sorting_desc { padding-right:8px }

#row-details-tab2 { font-family:'Oswald', sans-serif; font-size:1.0em }
#row-details-tab2 > tbody >tr > td { text-align:left }
#docview-details-tab2 .details-body { border:3px #333 solid; border-radius:10px; border-collapse:collapse }
#end-of-child { border-bottom:3px #333 solid; border-left:3px #333 solid; border-right:3px #333 solid } 
#docview-details-tab2-chfact.table < div < td { border-left:3px #333 solid; border-right:3px #333 solid }
/* 
----- ----- ----- ----- ----- ----- ----- ----- ----- -----  
TABLE_CHFACT
----- ----- ----- ----- ----- ----- ----- ----- ----- -----  
*/
#docview-details-tab2-chfact {  }
#docview-details-tab2-chfact > thead, #docview-details-tab2-chfact > tbody { font-family: 'Ubuntu', sans-serif;	font-size:0.9em; color:#666; border-bottom:none; border-top:none }
#docview-details-tab2-chfact > thead { background-color:#f5f5f5; color:#333; font-weight:300 }
#docview-details-tab2-chfact > tbody > tr > td { padding: 5px 8px; line-height: 1.42857143; vertical-align: middle }
#docview-details-tab2-chfact > thead > tr > th { border-bottom:none }
#docview-details-tab2-chfact > tbody > tr > td { border-top:none }

#docview-details-tab2-chfact .sorting_asc:after { display:none }
#docview-details-tab2-chfact > thead > tr > th.sorting_asc { padding-right:8px }

#docview-details-tab2-chfact-sumopl {  }
#docview-details-tab2-chfact-sumopl > thead > tr > th { border-bottom:none }

#docview-details-tab2-chfact > thead > tr > th:first-child, 
#docview-details-tab2-chfact > tbody > tr > td:first-child { width:17%; text-align:left }

#docview-details-tab2-chfact > thead > tr > th:nth-child(2), 
#docview-details-tab2-chfact > tbody > tr > td:nth-child(2) { width:13%; text-align:right }

#docview-details-tab2-chfact > thead > tr > th:nth-child(3), 
#docview-details-tab2-chfact > tbody > tr > td:nth-child(3) { width:15%; text-align:left } 

#docview-details-tab2-chfact > thead > tr > th:nth-child(4), 
#docview-details-tab2-chfact > tbody > tr > td:nth-child(4) { width:55%; text-align:left }
/* 
----- ----- ----- ----- ----- ----- ----- ----- ----- -----  
TABLE_OPLATA
----- ----- ----- ----- ----- ----- ----- ----- ----- -----  
*/
#docview-details-tab2-oplata { border: 2px #336a86 solid; border-radius:5px }
#docview-details-tab2-oplata > thead { background-color:#f1f1f1; color:#111 }
#docview-details-tab2-oplata .font-courier { font-family:courier,courier new,serif }

#docview-details-tab2 > table {  }

#docview-details-tab2-oplata > tbody { font-family: 'Ubuntu', sans-serif;	color:#666; border-bottom:none;	border-top:none }
#docview-details-tab2-oplata > thead { /*display:none*/ /*background-color:#f5f5f5*/ color:#333; font-weight: 300 }
#docview-details-tab2-oplata > tbody > tr > td { padding:5px 8px; line-height: 1.42857143; vertical-align: middle }
#docview-details-tab2-oplata > thead > tr > th { border-bottom:none }
#docview-details-tab2-oplata > tbody > tr > td { border-top:none }
#docview-details-tab2-oplata > tbody > tr > td.dataTables_empty { text-align:left; text-transform:none; color:#999 }


#docview-details-tab2-oplata > thead > tr > th:first-child { width:50%; color:#336a86; font-size:1.1em; font-weight:500; } 
#docview-details-tab2-oplata > tbody > tr > td:first-child, 
#docview-details-tab2-oplata > tfoot > tr > th:first-child { width:50%; text-align:left }
#docview-details-tab2-oplata > tbody > tr > td:first-child { font-family:courier, courier new, serif } 

#docview-details-tab2-oplata > thead > tr > th:nth-child(2), 
#docview-details-tab2-oplata > tbody > tr > td:nth-child(2), 
#docview-details-tab2-oplata > tfoot > tr > th:nth-child(2) { width:13%; font-size:1.1em; text-align:right }

#docview-details-tab2-oplata > thead > tr > th:nth-child(3), 
#docview-details-tab2-oplata > tbody > tr > td:nth-child(3) { width:10%; font-size:1.1em } 
#docview-details-tab2-oplata > tfoot > tr > th:nth-child(3) { width:10%; font-size:1.1em }

#docview-details-tab2-oplata > thead > tr > th:nth-child(4), 
#docview-details-tab2-oplata > tbody > tr > td:nth-child(4), 
#docview-details-tab2-oplata > tfoot > tr > th:nth-child(4) { width:14% }

#docview-details-tab2-oplata > thead > tr > th:nth-child(5), 
#docview-details-tab2-oplata > tbody > tr > td:nth-child(5), 
#docview-details-tab2-oplata > tfoot > tr > th:nth-child(5) {  }

#docview-details-tab2-oplata .sorting_asc:after { display:none }
#docview-details-tab2-oplata > thead > tr > th.sorting_asc { padding-right:8px }
/* 
----- ----- ----- ----- ----- ----- ----- ----- ----- -----  
TABLE_AVANS
----- ----- ----- ----- ----- ----- ----- ----- ----- -----  
*/
#docview-details-tab2-avans { border: 2px #336a86 solid; border-radius:5px }
#docview-details-tab2-avans > thead { background-color:#f1f1f1; color:#111 }
#docview-details-tab2-avans .font-courier { font-family:courier,courier new,serif }

#docview-details-tab2-avans > tbody { font-family: 'Ubuntu', sans-serif; color:#666; border-bottom:none;	border-top:none }
#docview-details-tab2-avans > thead { /*display:none*/ /*background-color:#f5f5f5*/ color:#333; font-weight: 300 }
#docview-details-tab2-avans > tbody > tr > td { padding:5px 8px; line-height: 1.42857143; vertical-align: middle }
#docview-details-tab2-avans > tbody > tr > td.dataTables_empty { text-align:left; text-transform:none; color:#999 }

#docview-details-tab2-avans > thead > tr > th { border-bottom:none }
#docview-details-tab2-avans > tbody > tr > td { border-top:none }

#docview-details-tab2-avans > thead > tr > th:first-child { width:50%; color:#336a86; font-size:1.1em; font-weight:500; } 
#docview-details-tab2-avans > tbody > tr > td:first-child, 
#docview-details-tab2-avans > tfoot > tr > th:first-child { width:50%; text-align:left }
#docview-details-tab2-avans > tbody > tr > td:first-child { font-family:courier, courier new, serif } 

#docview-details-tab2-avans > thead > tr > th:nth-child(2), 
#docview-details-tab2-avans > tbody > tr > td:nth-child(2), 
#docview-details-tab2-avans > tfoot > tr > th:nth-child(2) { width:13%; font-size:1.1em; text-align:right }

#docview-details-tab2-avans > thead > tr > th:nth-child(3), 
#docview-details-tab2-avans > tbody > tr > td:nth-child(3) { width:10%; font-size:1.1em } 
#docview-details-tab2-avans > tfoot > tr > th:nth-child(3) { width:10%; font-size:1.1em }

#docview-details-tab2-avans > thead > tr > th:nth-child(4), 
#docview-details-tab2-avans > tbody > tr > td:nth-child(4), 
#docview-details-tab2-avans > tfoot > tr > th:nth-child(4) { width:14% }

#docview-details-tab2-avans > thead > tr > th:nth-child(5), 
#docview-details-tab2-avans > tbody > tr > td:nth-child(5), 
#docview-details-tab2-avans > tfoot > tr > th:nth-child(5) {  }

#docview-details-tab2-avans .sorting_asc:after { display:none }
#docview-details-tab2-avans > thead > tr > th.sorting_asc { padding-right:8px }
/* 
----- ----- ----- ----- ----- ----- ----- ----- ----- -----  
TABLE_ZADOLG
----- ----- ----- ----- ----- ----- ----- ----- ----- -----  
*/
#docview-details-tab2-zadolg { border: 2px #336a86 solid; border-radius:5px }
#docview-details-tab2-zadolg > thead { background-color:#f1f1f1; color:#111 }
#docview-details-tab2-zadolg .font-courier { font-family:courier, courier new, serif }

#docview-details-tab2-zadolg > tbody { font-family: 'Ubuntu', sans-serif;	color:#666; border-bottom:none;	border-top:none }
#docview-details-tab2-zadolg > thead { /*display:none*/ /*background-color:#f5f5f5*/ color:#333; font-weight: 300 }
#docview-details-tab2-zadolg > tbody > tr > td { padding:5px 8px; line-height: 1.42857143; vertical-align: middle }
#docview-details-tab2-zadolg > tbody > tr > td.dataTables_empty { text-align:left; text-transform:none; color:#999 }

#docview-details-tab2-zadolg > thead > tr > th { border-bottom:none }
#docview-details-tab2-zadolg > tbody > tr > td { border-top:none }

#docview-details-tab2-zadolg > thead > tr > th:first-child { width:50%; color:#336a86; font-size:1.1em; font-weight:500; } 
#docview-details-tab2-zadolg > tbody > tr > td:first-child, 
#docview-details-tab2-zadolg > tfoot > tr > th:first-child { width:50%; text-align:left }
#docview-details-tab2-zadolg > tbody > tr > td:first-child { font-family:courier, courier new, serif  } 

#docview-details-tab2-zadolg > thead > tr > th:nth-child(2), 
#docview-details-tab2-zadolg > tbody > tr > td:nth-child(2), 
#docview-details-tab2-zadolg > tfoot > tr > th:nth-child(2) { width:13%; font-size:1.1em; text-align:right }

#docview-details-tab2-zadolg > thead > tr > th:nth-child(3), 
#docview-details-tab2-zadolg > tbody > tr > td:nth-child(3) { width:10%; font-size:1.1em } 
#docview-details-tab2-zadolg > tfoot > tr > th:nth-child(3) { width:10%; font-size:1.1em }

#docview-details-tab2-zadolg > thead > tr > th:nth-child(4), 
#docview-details-tab2-zadolg > tbody > tr > td:nth-child(4), 
#docview-details-tab2-zadolg > tfoot > tr > th:nth-child(4) { width:14% }

#docview-details-tab2-zadolg > thead > tr > th:nth-child(5), 
#docview-details-tab2-zadolg > tbody > tr > td:nth-child(5), 
#docview-details-tab2-zadolg > tfoot > tr > th:nth-child(5) {  }

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
					<th><span class='glyphicon glyphicon-option-vertical'></span></th>
					<th></th>
					<th>Срок</th>
					<th>Наименование этапа</th>
					<th>№</th>
					<th class="text-center">Дата</th>
					<th class="text-center">Сумма</th>
					<th class="text-center">Сумма этапа</th>
				</tr>
			</thead>
		</table>
	</div>

</section>
	
