
<script type="text/javascript" language="javascript" class="init">

var editor_tab5; 
var table_tab5; 
var table_tab5_chfact; 
var table_tab5_avans; 

total_oplata = 0;
total_avans = 0;

var summaOplataChf;

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	var table_zadolg = $('<table id="docview-details-tab5-zadolg" class="table" cellspacing="0" width="100%"><thead><tr><th></th></tr></thead></table>');
	var totalOplataChf = table_zadolg.DataTable( {
    dom: '',
		language: {
			url: "php/examples/simple/docview/docview-details/dt_russian-tab2-oplata.json"
		},
    ajax: {
			url: "php/examples/php/docview/docview-details/dognet-docview-details-tab2_oplata_chfact_sumopl-process.php",
			type: 'post',
			data: function ( d ) {
        d.kodchfact = row().data().dognet_kalplanchf.kodchfact;
        console.log("kodchfact: "+d.kodchfact);
				}
    },
    columns: [
			{ data: "dognet_oplatachf.summaopl", className: "font-courier text-right" } 
    ],
		columnDefs: [
			{ orderable: false, searchable: false, targets: 0 } 
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
      summaOplataChf = api.column( 0 ).data().reduce( function (a, b) { return intVal(a) + intVal(b); }, 0 );
      console.log("summaOplataChf: "+summaOplataChf);
    }
	} );

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

	table_tab5 = $('#docview-details-tab5').DataTable( {
// 		dom: "<'row space20'<'col-md-8 col-sm-12'><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'ltip>>",
		dom: "t",
		language: {
			url: "php/examples/simple/docview/docview-details/dt_russian-tab5.json"
		},
		ajax: {
			url: "php/examples/php/docview/docview-details/dognet-docview-details-tab5_zadolg-process.php",
			type: "POST"
		},
		serverSide: true,
		columns: [
			{ data: "dognet_dockalplan.numberstage", className: "text-left" },
			{ data: "dognet_dockalplan.nameshotstage", className: "text-right text-uppercase" }, 
			{ data: "dognet_dockalplan.dateplan", className: "text-left" },
			{ data: "dognet_dockalplan.summastage", className: "text-right" }, 
			{ data: null, className: "stage_oplata" }, 
			{ data: null, className: "stage_zadolg" } 
		],
		columnDefs: [
			{ orderable: true, searchable: false, render: function ( data ) { return data; }, targets: 0 }, 
			{ orderable: false, searchable: false, render: function ( data ) { return data; }, targets: 1 }, 
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
				targets: 2 
			},
			{ orderable: false, searchable: false, render: function ( data, type, row, meta ) { 
					if (data != null) {
						return $.fn.dataTable.render.number(' ', ',', 2, '').display( data )+row.dognet_spdened.short_code; 
					}
					else {
						return "0.00"+row.dognet_spdened.short_code;
					}
				}, targets: 3 
			}, 
			{ orderable: false, searchable: false, render: function ( data ) { return ""; }, targets: 4 }, 
			{ orderable: false, searchable: false, render: function ( data ) { return ""; }, targets: 5 }
		], 
// 		order: [ [ 1, "asc" ] ],
		processing: false,
		paging: false,
		select: false,
		searching: false,
		lengthChange: false, 
		order: [ [0, 'asc'] ], 
    initComplete: function ( data, type, row, meta ) {
			var api = this.api(), data; 
      // Remove the formatting to get integer data for summation
      var intVal = function ( i ) {
          return typeof i === 'string' ?
              i.replace(/[\$,]/g, '')*1 :
              typeof i === 'number' ?
                  i : 0;
      };
//       $( api.column( 4 ) ).html( row.dognet_dockalplan.summastage );
//       $( '.stage_oplata' ).html(row.data().dognet_dockalplan.summastage);
    }
	} );	
// ----- ----- ----- ----- ----- 
	table_tab5
		.on( 'select', function () {

		} )
		.on( 'deselect', function () {

		} );
// ----- ----- ----- ----- ----- 
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
#docview-details-tab5 {  }
#docview-details-tab5 .details-control:hover { cursor:pointer }
#docview-details-tab5 .font-courier { font-family:courier,courier new,serif }
/* 
/* 
/* Заголовок таблицы */
#docview-details-tab5 > thead {	color:#111; font-family:'Oswald', sans-serif; border-bottom:none;	border-top:none }
#docview-details-tab5 > thead > tr > th { color:#333; border-bottom:none; font-weight:500; font-size:1.3em; text-transform:uppercase }
#docview-details-tab5 > thead > tr > th:first-child { background-color:#f7f7f7; width:5%; text-align:center }
#docview-details-tab5 > thead > tr > th:nth-child(2) { background-color:#f7f7f7; width:35%; text-align:left }
#docview-details-tab5 > thead > tr > th:nth-child(3) { background-color:#f7f7f7; width:10%; text-align:left  }
#docview-details-tab5 > thead > tr > th:nth-child(4) { background-color:#f7f7f7; width:15%; text-align:center  }
#docview-details-tab5 > thead > tr > th:nth-child(5) { background-color:#f0f0f0; width:15%; text-align:center  }
#docview-details-tab5 > thead > tr > th:nth-child(6) { background-color:#f0f0f0; width:15%; text-align:center }
/* 
/* 
/* Тело таблицы */
#docview-details-tab5 > tbody {	font-family:'Oswald', sans-serif; color:#333; border-bottom:none;	border-top:none }
#docview-details-tab5 > tbody > tr > td { border-bottom:none; padding: 5px 8px; line-height: 1.42857143; vertical-align: middle }
#docview-details-tab5 > tbody > tr > td:first-child { width:5%; text-align:center }
#docview-details-tab5 > tbody > tr > td:nth-child(2) { width:35%; text-align:left }
#docview-details-tab5 > tbody > tr > td:nth-child(3) { width:10%; text-align:left }
#docview-details-tab5 > tbody > tr > td:nth-child(4) { width:15%; font-family:courier,courier new,serif; text-align:center; color:#111 }
#docview-details-tab5 > tbody > tr > td:nth-child(5) { width:15%; font-family:courier,courier new,serif; text-align:center; background-color:#f1f1f1; color:#111 }
#docview-details-tab5 > tbody > tr > td:nth-child(6) { width:15%; font-family:courier,courier new,serif; text-align:center; background-color:#f1f1f1; color:#111 }
#docview-details-tab5 > tbody > tr > td.dataTables_empty { text-align:center; border-bottom:1px #951402 solid; border-top:1px #951402 solid; text-transform:uppercase; font-style:italic; color:#951402 }
#docview-details-tab5 > tbody > tr > td.docview-details-tab5-numberstage { font-weight:300; font-size:1.3em; text-transform:uppercase; text-align:left; border-left: 5px #336a86 solid }
#docview-details-tab5 > tbody > tr > td.docview-details-tab5-dateplan { font-weight:300; font-size:1.3em; text-transform:uppercase }
#docview-details-tab5 > tbody > tr > td.docview-details-tab5-namestage { font-weight:300; font-size:1.3em; text-transform:none }
#docview-details-tab5 > tbody > tr > td.docview-details-tab5-summastage { font-weight:300; font-size:1.0em; text-align:right; text-transform:none }
#docview-details-tab5 > tbody > tr > td { border-top:none }
#docview-details-tab5 > tbody > tr.shown > td { background-color:#336a86; color:#fff; font-weight:300 }
/* 
/* 
/* Подвал таблицы */



/* 
/* 
/* Разное */
#docview-tab5 .panel-title { font-size:1.3em; font-weight:600; text-transform:none;	padding:0 }
#docview-tab5 .panel { border:1px solid #f5f5f5 }

#docview-details-tab5 .sorting_asc:after { display:none }
#docview-details-tab5 > thead > tr > th.sorting_asc { padding-right:8px }
#docview-details-tab5 .sorting_desc:after { display:none }
#docview-details-tab5 > thead > tr > th.sorting_desc { padding-right:8px }

#row-details-tab5 { font-family:'Oswald', sans-serif; font-size:1.0em }
#row-details-tab5 > tbody >tr > td { text-align:left }
#docview-details-tab5 .details-body { border:3px #333 solid; border-radius:10px; border-collapse:collapse }
#end-of-child { border-bottom:3px #333 solid; border-left:3px #333 solid; border-right:3px #333 solid } 
#docview-details-tab5-chfact.table < div < td { border-left:3px #333 solid; border-right:3px #333 solid }

</style>

<section>
	
	<div class="" style="padding-left:5px; padding-right:5px">
		<div class="space30"></div>
		<div class="demo-html"></div>
		<table id="docview-details-tab5" class="table" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>Этап</th>
					<th>Краткое наименование этапа</th>
					<th>Срок</th>
					<th class="text-center">Сумма этапа</th>
					<th class="text-center">Оплачено</th>
					<th class="text-center">Задолженность</th>
				</tr>
			</thead>
		</table>
	</div>

</section>
	
