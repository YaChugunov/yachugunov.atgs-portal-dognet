
<script type="text/javascript" language="javascript" class="init">

var editor_tab3;
var table_tab3;
var table_tab3_chet;
var table_tab3_chetf;
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
function format_chetf ( d ) {
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

	table_tab3 = $('#docview-details-tab3').DataTable( {
// 		dom: "<'row space20'<'col-md-8 col-sm-12'><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'ltip>>",
		dom: "t",
		language: {
			url: "php/examples/simple/docview/docview-details/dt_russian-tab3.json"
		},
		ajax: {
			url: "php/examples/php/docview/docview-details/dognet-docview-details-tab3_zatraty-process.php",
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
			{ data: "dognet_doczayv.kodzayv", className: "text-left" },
			{ data: "dognet_sptipzayvall.nametipzayvshotall", className: "text-center" },
			{ data: "dognet_doczayv.numberzayv", className: "text-center" },
			{ data: "dognet_sptipzayv.namezayvshot", className: "text-left" },
			{ data: "dognet_spzayvtel.namezayvtelshot", className: "text-uppercase text-center" },
			{ data: "dognet_spispol.ispolnameshot", className: "text-uppercase text-center" }, 
			{ data: "dognet_doczayv.datezayv", className: "text-center" }
		],
		select: {
			style: 'os',
			selector: 'td:not(:first-child)'
		},
		columnDefs: [
			{ orderable: false, searchable: false, targets: 0 }, 
			{ orderable: true, searchable: false, render: function ( data ) { return ""; }, targets: 1 }, 
			{ orderable: false, searchable: false, render: function ( data ) { return ""; }, targets: 2 }, 
			{ orderable: false, searchable: false, render: function ( data ) { return ""; }, targets: 3 }, 
			{ orderable: true, searchable: false, render: function ( data ) { return ""; }, targets: 4 }, 
			{ orderable: false, searchable: false, render: function ( data ) { return data; }, targets: 5 }, 
			{ orderable: false, searchable: false, render: function ( data ) { return data; }, targets: 6 }, 
			{ 
				orderable: false, 
				searchable: false, 
				type: "de_date", 
				render: function ( data ) {	return moment(data, 'YYYY-MM-DD').format('DD.MM.YYYY');	}, 
				targets: 7 
			}
		], 
		order: [ [ 3, "asc" ], [ 1, "asc" ] ],
		processing: false,
		paging: false,
		searching: false,
		lengthChange: false, 

		drawCallback: function ( settings ) {
			var api = this.api(), data;
			var rows = api.rows().nodes();
			var last1 = null;
			api.column(1).data().each( function ( tmp1, i ) { 
				if ( last1 !== tmp1 ) { 
// 					datestage = api.row(0).data().dognet_dockalplan.dateplan;
// 					console.log( api.row(0).data().dognet_dockalplan.dateplan );
					$(rows).eq( i ).before( 
							'<tr><td colspan="2" class="docview-details-tab3-id">ID:&nbsp;'+tmp1+'</td><td class="docview-details-tab3-zayvtel">'+api.row(i).data().dognet_sptipzayvall.nametipzayvshotall+'</td><td class="docview-details-tab3-zayvnum">'+api.row(i).data().dognet_doczayv.numberzayv+'</td><td colspan="4" class="docview-details-tab3-zayvdesc">'+api.row(i).data().dognet_doczayv.namerabfilespec+'</td></tr>'
					);
					last1 = tmp1;
				}
			} );
		}

	} );	
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

	function createChild_lvl1( row ) {
		// This is the table we'll convert into a DataTable
		var table_chet = $('<table id="docview-details-tab3-chet" class="table" cellspacing="0" width="100%"><thead><tr><th class="text-uppercase">Счета и счета-фактуры</th><th></th><th></th><th></th><th></th><th></th><th></th></tr></thead><tfoot><tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tr></tfoot></table>');
		var table_chetf = $('<table id="docview-details-tab3-chetf" class="table" cellspacing="0" width="100%"><thead><tr><th>Счета-фактуры</th><th></th><th></th><th></th></tr></thead><tfoot><tr><th></th><th></th><th></th><th></th></tr></tfoot></table>');
		// ----- ----- ----- 
		// Display it the child row
		row.child( [ table_chet ] ).show();
		// ----- ----- ----- 
		// Initialise as a DataTable
		var table_tab3_chet = table_chet.DataTable( {
		// ...
	    dom: 't',
			language: {
				url: "php/examples/simple/docview/docview-details/dt_russian-tab3-chet.json"
			},
	    ajax: {
				url: "php/examples/php/docview/docview-details/dognet-docview-details-tab3_zatraty_chet-process.php",
				type: 'post',
				data: function ( d ) { 
					d.kodzayv = row.data().dognet_doczayv.kodzayv; 
				}
	    },
	    columns: [
				{ data: "dognet_doczayvchet.zayvchetdate", className: "text-left" },
				{ data: null, defaultContent: "Счет № :", className: "font-courier text-right text-uppercase" },
				{ data: "dognet_doczayvchet.zayvchetnumber", className: "font-courier text-left" }, 
				{ data: "dognet_doczayvchet.zayvchetsumma", className: "font-courier text-right" }, 
				{ data: null, defaultContent: "", className: "font-courier text-right text-uppercase" },
				{ data: "dognet_doczayvchetf.zayvchetfnumber", defaultContent: "---", className: "font-courier text-left" }, 
				{ data: "dognet_doczayvchetf.zayvchetfdate", defaultContent: "---", className: "font-courier text-left" } 
	    ],
			columnDefs: [
				{ 
					orderable: false, 
					searchable: false, 
					select: false, 
					type: "de_date", 
					render: function ( data ) {
						return moment(data, 'YYYY-MM-DD').format('DD.MM.YYYY');
					}, 
					targets: 0 
				},
				{ orderable: false, searchable: false, targets: 1 }, 
				{ orderable: false, searchable: false, 
					render: function ( data, type, row, meta ) { 
						if (data && row.dognet_doczayvchet_files.file_url) {
							return "<a class='chet-link' href='"+row.dognet_doczayvchet_files.file_url+"' target='_blank'>"+data+"</a>";
						}
						else if (data) {
							return data;
						}
						else {
							return "---";
						}
					}, targets: 2
				}, 
				{ orderable: false, searchable: false, render: function ( data, type, row, meta ) { return $.fn.dataTable.render.number(' ', ',', 2, '').display( data )+row.dognet_spdened.short_code; }, targets: 3 }, 
				{ orderable: false, searchable: false, 
					render: function ( row ) { 
						if (row.dognet_doczayvchetf.zayvchetfnumber != null ) {
							return "Счет-фактура № :";
						}
						else {
							return "<span class='text-danger'>Счета-фактуры нет</span>";
						} 
					}, 
					targets: 4 
				},  
				{ orderable: false, searchable: false, 
					render: function ( data, type, row, meta ) { 
						if (data && row.dognet_doczayvchetf_files.file_url) {
							return "<a class='chet-link' href='"+row.dognet_doczayvchetf_files.file_url+"' target='_blank'>"+data+"</a>";
						}
						else if (data) {
							return data;
						}
						else {
							return "";
						}
					}, targets: 5
				}, 
				{ orderable: false, searchable: false, 
					type: "de_date", 
					render: function ( data ) { 
						if (data) {
							return moment(data, 'YYYY-MM-DD').format('DD.MM.YYYY');
						}
						else {
							return "";
						}
					}, targets: 6
				}  
			], 
			order: [ [ 0, "desc" ] ],
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
				total = api.column( 3 ).data().reduce( function (a, b) { return intVal(a) + intVal(b); }, 0 );
        dened = "";
        if (api.row().data() != null) {
					dened = api.row().data().dognet_spdened.short_code;
        }
        else {
	        dened = " -.";
        }

				// Update footer
        $( api.column( 2 ).footer() ).html('ИТОГО : ');
				$( api.column( 3 ).footer() ).html($.fn.dataTable.render.number(' ', ',', 2, '').display( total )+dened);
      }
		} );
		// ----- ----- ----- 
		// Initialise as a DataTable
		var table_tab3_chetf = table_chetf.DataTable( {
		// ...
	    dom: 't', 
			language: {
				url: "php/examples/simple/docview/docview-details/dt_russian-tab3-chetf.json"
			},
	    ajax: {
				url: "php/examples/php/docview/docview-details/dognet-docview-details-tab3_zatraty_chfact-process.php", 
				type: 'post', 
				data: function ( d ) { 
					d.kodzayvchet = row.data().dognet_doczayvchet.kodzayvchet; 
				}
	    },
	    columns: [

				{ data: "dognet_doczayvchetf.zayvchetfdate", className: "text-left" },
				{ data: null, defaultContent: "Счет-фактура № :", className: "text-right text-uppercase" },
				{ data: "dognet_doczayvchetf.zayvchetfnumber", className: "text-left" }, 
				{ data: "dognet_doczayvchetf.zayvchetfsumma", className: "text-right" }

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
				{ orderable: false, searchable: false, targets: 1 },  
				{ orderable: false, searchable: false, render: function ( data ) { return data; }, targets: 2 },  
				{ orderable: false, searchable: false, render: function ( data, type, row, meta ) { return $.fn.dataTable.render.number(' ', ',', 2, '').display( data )+row.dognet_spdened.short_code; }, targets: 3 } 
			], 
			order: [ [ 0, "desc" ] ],
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
				total = api.column( 3 ).data().reduce( function (a, b) { return intVal(a) + intVal(b); }, 0 );
        dened = "";
        if (api.row().data() != null) {
					dened = api.row().data().dognet_spdened.short_code;
        }

				// Update footer
        $( api.column( 2 ).footer() ).html('ИТОГО : ');
				$( api.column( 3 ).footer() ).html(total.toFixed(2)+dened);
      }
		} );
	}
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
	function destroyChild( id, row ) {
		var table = $(id, row.child());
		table.detach();
		table.DataTable().destroy();
		// And then hide the row
		row.child.hide();
	}
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
//
	table_tab3
		.on( 'select', function () {
// 			table_tab3_chetf.ajax.reload();
// 			table_tab3_chet.ajax.reload();
		} )
		.on( 'deselect', function () {
// 			table_tab3_chetf.ajax.reload();
// 			table_tab3_chet.ajax.reload();
		} );
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
	$('#docview-details-tab3 tbody').on('click', 'td.details-control', function () {
// 		console.log("Click on details-control lvl1 !");
		var tr = $(this).closest('tr');
		var row = table_tab3.row( tr );
		
		if ( row.child.isShown() ) {
			// This row is already open - close it
			destroyChild('#docview-details-tab3', row);
			tr.removeClass('shown');
		}
		else {
			// Open this row
			createChild_lvl1(row); // class is for background colour
			tr.addClass('shown');
		}
	} );
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
//

    table_tab3
    .on( 'init', function () {
//       console.log( 'Table table_tab3 initialisation complete: '+new Date().getTime() );
// 			console.log("Table table_tab3 recordsTotal: "+table_tab3.page.info().recordsTotal);
			if (table_tab3.page.info().recordsTotal === 0) {
				table_tab3.tables().header().to$().addClass('hide_element');
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
#docview-details-tab3 {  }
#docview-details-tab3 .details-control:hover { cursor:hand }
/* 
/* 
/* Заголовок таблицы */
#docview-details-tab3 > thead { /* display:none */ }
#docview-details-tab3 > thead {	background-color:#f1f1f1;	color:#111; font-family:'Oswald', sans-serif; border-bottom:none;	border-top:none }
#docview-details-tab3 > thead > tr > th { color:#333; border-bottom:none; font-weight:500; font-size:1.3em; text-transform:uppercase }
#docview-details-tab3 > thead > tr > th:first-child { background-color:#f7f7f7; width:1%; text-align:center }
#docview-details-tab3 > thead > tr > th:nth-child(2) { background-color:#f7f7f7; width:5%; text-align:left }
#docview-details-tab3 > thead > tr > th:nth-child(3) { background-color:#f7f7f7; width:3%; text-align:center  }
#docview-details-tab3 > thead > tr > th:nth-child(4) { background-color:#f7f7f7; width:3%; text-align:center  }
#docview-details-tab3 > thead > tr > th:nth-child(5) { background-color:#f7f7f7; width:35%; text-align:left  }
#docview-details-tab3 > thead > tr > th:nth-child(6) { background-color:#f0f0f0; text-align:center  }
#docview-details-tab3 > thead > tr > th:nth-child(7) { background-color:#f0f0f0; text-align:center  }
#docview-details-tab3 > thead > tr > th:nth-child(8) { background-color:#f0f0f0; text-align:center  }
/* 
/* 
/* Тело таблицы */
#docview-details-tab3 > tbody {	font-family:'Oswald', sans-serif; color:#333; border-bottom:none;	border-top:none }
#docview-details-tab3 > tbody > tr > td { border-bottom:none; padding: 5px 8px; line-height: 1.42857143; vertical-align: middle }
#docview-details-tab3 > tbody > tr > td:first-child { width:1%; text-align:center }
#docview-details-tab3 > tbody > tr > td:nth-child(2) { width:5%; text-align:center }
#docview-details-tab3 > tbody > tr > td:nth-child(3) { width:3%; text-align:center }
#docview-details-tab3 > tbody > tr > td:nth-child(4) { width:3%; text-align:left }
#docview-details-tab3 > tbody > tr > td:nth-child(5) { width:35%; text-align:left }

#docview-details-tab3 > tbody > tr > td:nth-child(6) { font-family:courier,courier new,serif; text-align:center; background-color:#f1f1f1; color:#111 }
#docview-details-tab3 > tbody > tr > td:nth-child(7) { font-family:courier,courier new,serif; text-align:center; background-color:#f1f1f1; color:#111 }
#docview-details-tab3 > tbody > tr > td:nth-child(8) { font-family:courier,courier new,serif; text-align:center; background-color:#f1f1f1; color:#111 }
#docview-details-tab3 > tbody > tr > td.dataTables_empty { text-align:center; border-bottom:1px #951402 solid; border-top:1px #951402 solid; text-transform:uppercase; font-style:italic; color:#951402 }
#docview-details-tab3 > tbody > tr > td.docview-details-tab3-id { font-weight:300; font-size:1.3em; text-transform:uppercase; text-align:left; border-left: 5px #336a86 solid }
#docview-details-tab3 > tbody > tr > td.docview-details-tab3-zayvtel { font-weight:300; font-size:1.3em; text-transform:none }
#docview-details-tab3 > tbody > tr > td.docview-details-tab3-zayvnum { font-weight:300; font-size:1.3em; text-transform:none }
#docview-details-tab3 > tbody > tr > td.docview-details-tab3-zayvdesc { font-weight:300; font-size:1.3em; text-transform:none }
#docview-details-tab3 > tbody > tr > td { border-top:none }
#docview-details-tab3 > tbody > tr.shown > td { background-color:#336a86; color:#fff; font-weight:300 }
#docview-details-tab3 > tbody > tr > td a.zayv-link { text-decoration:underline; color:#336a86 }
#docview-details-tab3 > tbody > tr > td a.zayv-link:hover { text-decoration:none }
/* 
/* 
/* Подвал таблицы */

/* 
/* 
/* Разное */
#docview-tab2 .panel-title { font-size:1.3em; font-weight:600; text-transform:none;	padding:0 }
#docview-tab2 .panel { border:1px solid #f5f5f5 }

#docview-details-tab3 .sorting:after, #docview-details-tab3 .sorting_asc:after, #docview-details-tab3 .sorting_desc:after { display:none }
#docview-details-tab3 > thead > tr > th.sorting_asc { padding-right:8px }
#docview-details-tab3 > thead > tr > th.sorting_desc { padding-right:8px }

#row-details-tab3 { font-family:'Oswald', sans-serif; font-size:1.0em }
#row-details-tab3 > tbody > tr > td { text-align:left }
#docview-details-tab3 .details-body { border:3px #333 solid; border-radius:10px; border-collapse:collapse }
#end-of-child { border-bottom:3px #333 solid; border-left:3px #333 solid; border-right:3px #333 solid } 
#docview-details-tab3-chfact.table < div < td { border-left:3px #333 solid; border-right:3px #333 solid }
/* 
----- ----- ----- ----- ----- ----- ----- ----- ----- -----  
TABLE_CHET
----- ----- ----- ----- ----- ----- ----- ----- ----- -----  
*/
/* 
/* Общее для таблицы */
#docview-details-tab3-chet { border: 2px #336a86 solid; border-radius:5px }
#docview-details-tab3-chet > thead { background-color:#f1f1f1; color:#111 }
#docview-details-tab3-chet .font-courier { font-family:courier,courier new,serif }

#docview-details-tab3-chet > thead { border-bottom:none;	border-top:none }
#docview-details-tab3-chet > tbody { font-family: 'Ubuntu', sans-serif;	font-size:0.9em;	color:#666; border-bottom:none;	border-top:none }
#docview-details-tab3-chet > thead { /*display:none*/ /*background-color:#f5f5f5*/ color:#333; font-weight: 300 }
#docview-details-tab3-chet > tbody > tr > td { padding:5px 8px; line-height: 1.42857143; vertical-align: middle }
#docview-details-tab3-chet .sorting_asc:after { display:none }
/* 
/* 
/* Заголовок таблицы */
#docview-details-tab3-chet > thead > tr > th { border-bottom:none }
#docview-details-tab3-chet > thead > tr > th:first-child { width:18%; color:#336a86; font-size:1.1em; font-weight:500; text-align:left }
#docview-details-tab3-chet > thead > tr > th:nth-child(2) { width:10%; text-align:left }
#docview-details-tab3-chet > thead > tr > th:nth-child(3) { width:15%; text-align:left } 
#docview-details-tab3-chet > thead > tr > th:nth-child(4) { width:12%; text-align:left }
#docview-details-tab3-chet > thead > tr > th:nth-child(5) { width:20%; text-align:left }
#docview-details-tab3-chet > thead > tr > th:nth-child(6) { width:15%; text-align:left } 
#docview-details-tab3-chet > thead > tr > th:nth-child(7) { width:10%; text-align:left } 
#docview-details-tab3-chet > thead > tr > th.sorting_asc { padding-right:8px }
/* 
/* 
/* Тело таблицы */
#docview-details-tab3-chet > tbody > tr > td { color:#111; border-top:none; font-size:1.1em }
#docview-details-tab3-chet > tbody > tr > td:first-child { font-family:courier,courier new,serif; width:18%; text-align:right }
#docview-details-tab3-chet > tbody > tr > td:nth-child(2) { width:10% }
#docview-details-tab3-chet > tbody > tr > td:nth-child(3) { width:15% } 
#docview-details-tab3-chet > tbody > tr > td:nth-child(4) { width:12% }
#docview-details-tab3-chet > tbody > tr > td:nth-child(5) { width:20% }
#docview-details-tab3-chet > tbody > tr > td:nth-child(6) { width:15% } 
#docview-details-tab3-chet > tbody > tr > td:nth-child(7) { width:10% } 
#docview-details-tab3-chet > tbody > tr > td a.chet-link { text-decoration:underline; color:#336a86 }
#docview-details-tab3-chet > tbody > tr > td a.chet-link:hover { text-decoration:none }
/* 
/* 
/* Подвал таблицы */
#docview-details-tab3-chet > tfoot > tr > th:first-child { width:18% }
#docview-details-tab3-chet > tfoot > tr > th:nth-child(2) { width:10% }
#docview-details-tab3-chet > tfoot > tr > th:nth-child(3) { width:15%; text-align:right }
#docview-details-tab3-chet > tfoot > tr > th:nth-child(4) { width:12%; text-align:right }
#docview-details-tab3-chet > tfoot > tr > th:nth-child(5) { width:20%; text-align:right }
#docview-details-tab3-chet > tfoot > tr > th:nth-child(6) { width:15%; text-align:right }
#docview-details-tab3-chet > tfoot > tr > th:nth-child(7) { width:10% }
/* 
/* 
/* Разное */
#docview-details-tab3-chet > tbody > tr > td.dataTables_empty { text-align:left; text-transform:none; color:#999 }

/* 
----- ----- ----- ----- ----- ----- ----- ----- ----- -----  
TABLE_CHETF
----- ----- ----- ----- ----- ----- ----- ----- ----- -----  
*/
/* 
/* Общее для таблицы */
#docview-details-tab3-chetf {  }
#docview-details-tab3-chetf .font-courier { font-family:courier,courier new,serif }

#docview-details-tab3-chetf > thead { border-bottom:none;	border-top:none }
#docview-details-tab3-chetf > tbody { font-family: 'Ubuntu', sans-serif;	font-size:0.9em;	color:#666; border-bottom:none;	border-top:none }
#docview-details-tab3-chetf > thead { /*display:none*/ /*background-color:#f5f5f5*/ color:#333; font-weight: 300 }
#docview-details-tab3-chetf > tbody > tr > td { padding:5px 8px; line-height: 1.42857143; vertical-align: middle }
#docview-details-tab3-chetf .sorting_asc:after { display:none }
/* 
/* 
/* Заголовок таблицы */
#docview-details-tab3-chetf > thead > tr > th { border-bottom:none }
#docview-details-tab3-chetf > thead > tr > th:first-child { width:18%; text-align:left }
#docview-details-tab3-chetf > thead > tr > th:nth-child(2) { width:20%; text-align:left }
#docview-details-tab3-chetf > thead > tr > th:nth-child(3) { width:15%; text-align:left } 
#docview-details-tab3-chetf > thead > tr > th:nth-child(4) { width:47%; text-align:left }
#docview-details-tab3-chetf > thead > tr > th.sorting_asc { padding-right:8px }
/* 
/* 
/* Тело таблицы */
#docview-details-tab3-chetf > tbody > tr > td { border-top:none }
#docview-details-tab3-chetf > tbody > tr > td:first-child { width:18%; text-align:right }
#docview-details-tab3-chetf > tbody > tr > td:nth-child(2) { width:20% }
#docview-details-tab3-chetf > tbody > tr > td:nth-child(3) { width:15%; text-align:left } 
#docview-details-tab3-chetf > tbody > tr > td:nth-child(4) { width:47%; text-align:left }
/* 
/* 
/* Подвал таблицы */
#docview-details-tab3-chetf > tfoot > tr > th:first-child 
#docview-details-tab3-chetf > tfoot > tr > th:nth-child(2) { text-align:right }
#docview-details-tab3-chetf > tfoot > tr > th:nth-child(3) { text-align:right }
#docview-details-tab3-chetf > tfoot > tr > th:nth-child(4) { text-align:left }
/* 
----- ----- ----- ----- ----- ----- ----- ----- ----- -----  
*/
</style>

<section>
	
	<div class="" style="padding-left:5px; padding-right:5px">
		<div class="space30"></div>
		<div class="demo-html"></div>
		<table id="docview-details-tab3" class="table" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
					<th class="text-left"></th>
					<th class="text-left">ГРУППА</th>
					<th class="text-center">№</th>
					<th class="text-left">Описание</th>
					<th class="text-left">Заявитель</th>
					<th class="text-left">Исполнитель</th>
					<th class="text-center">Дата заявки</th>
				</tr>
			</thead>
		</table>
	</div>

</section>
	
