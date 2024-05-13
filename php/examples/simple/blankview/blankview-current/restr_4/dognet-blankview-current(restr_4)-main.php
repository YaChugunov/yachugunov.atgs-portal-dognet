
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/date-de.js"></script>
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/moment-with-locales.js"></script>

<script type="text/javascript" language="javascript" class="init">

var table_blankview_docwork;		// use a global for the submit and return data rendering in the examples

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

$(document).ready(function() {

	table_blankview_docwork = $('#blankview-docwork-table').DataTable( {
		dom: "<'row'<'col-sm-5'B><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'p>>",
// 		dom: "<'space50'r>tip",
		language: {	url: "russian.json" },
		ajax: {
			url: "php/examples/php/blankview/blankview-docwork/dognet-blankview-docwork-process.php",
			type: "POST"
		},
		serverSide: true,
		columns: [
			{ data: "dognet_docblankwork.numberblankwork", className: "text-center" },
			{ data: "dognet_docblankwork.yearblankwork", className: "text-center" }, 
			{ data: "dognet_docblankwork.nameblankwork", className: "text-left" }, 
			{ data: "dognet_docblankwork.nameorgblankwork", className: "text-left" }, 
			{
				data: null,
				defaultContent: '<a href="" class="edit_listalt"><span class="glyphicon glyphicon-list-alt"></span></a>', 
				className: "text-right" 
			} 
		],
		select: {
			style: 'os',
			selector: 'td:not(:last-child)' // no row selection on last column
		},
		columnDefs: [
			{ orderable: true, searchable: true, targets: 0 },
			{ orderable: true, searchable: true, targets: 1 }, 
			{ 
				orderable: false, 
				searchable: true, 
				targets: 2, 
				render: function ( data, type, row, meta ) { 
					fullstr = data;
					if (data.length > 80) { return data.substr(0,80)+' <a class="test" href="#" data-toggle="tooltip" data-placement="top" title="'+fullstr+'">[ ... ]</a>'; }
					else { return data;	}
				}
			}, 
			{ 
				orderable: false, 
				searchable: true, 
				targets: 3, 
				render: function ( data, type, row, meta ) { 
					fullstr = data;
					if (data.length > 40) { return data.substr(0,40)+' <a class="test" href="#" data-toggle="tooltip" data-placement="top" title="'+fullstr+'">[ ... ]</a>'; }
					else { return data;	}
				}
			}, 
			{ 
				orderable: false, 
				searchable: false, 
				targets: 4, 
				render: function ( data, type, row, meta ) {
					return '<a href="dognet-blankview.php?blankview_type=details&uniqueID='+row.dognet_docblankwork.kodblankwork+'"><span class="glyphicon glyphicon-list-alt"></span></a>';
				} 
			} 
		], 
		order: [ [ 1, "desc" ], [ 0, "desc" ] ],
		select: false,
		processing: true,
		paging: true,
		searching: true,
		pageLength: 15, 
		lengthChange: true,
		lengthMenu: [ [15, 30, 50, -1], [15, 30, 50, "Все"] ], 
		buttons: [
			{ text:	'<span class="glyphicon glyphicon-refresh"></span>', action:	
				function ( e, dt, node, config ) { 
					$('#column1_search_docwork').val('');
					$('#column2_search_docwork').val('');
					$('#column3_search_docwork').val('');
					$('#column4_search_docwork').val('');
					table_blankview_docwork.columns().search('');
					table_blankview_docwork.order( [ 1, "desc" ], [ 0, "desc" ] ).draw(); 
				} 
			} 
		], 
		initComplete: function() {
/*
      this.api().columns(3).every( function () {
          var column = this;
          var select = $('<select id="tmp1_search"><option value="">Все года</option></select>')
              .appendTo( $(column.footer()).empty() )
              .on( 'change', function () {
								var val = $(this).val();
									column
										.search( val ? val : '', true, false )
										.draw();
							} );
          column.data().unique().sort().each( function ( d, j ) {
              select.append( '<option value="'+d+'">'+d+'</option>' )
          } );
      } );
      this.api().columns(4).every( function () {
          var column = this;
          var select = $('<select id="tmp2_search"><option value="">Все типы</option></select>')
              .appendTo( $(column.footer()).empty() )
              .on( 'change', function () {
								var val = $(this).val();
									column
										.search( val ? val : '', true, false )
										.draw();
							} );
          column.data().unique().sort().each( function ( d, j ) {
              select.append( '<option value="'+d+'">'+d+'</option>' )
          } );
      } );
*/
		}, 

		drawCallback: function () {

		}

	} );


// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
	// #column1_search_docwork is a <input type="text"> element
	$('#column1_search_docwork').on( 'keyup', function () {
	    table_blankview_docwork
	        .columns( 0 )
	        .search( this.value );
// 	        .draw();
	} );
	// #column2_search_docwork is a <input type="text"> element
	$('#column2_search_docwork').on( 'keyup', function () {
	    table_blankview_docwork
	        .columns( 1 )
	        .search( this.value );
// 	        .draw();
	} );
	// #column3_search_docwork is a <input type="text"> element
	$('#column3_search_docwork').on( 'keyup', function () {
	    table_blankview_docwork
	        .columns( 2 )
	        .search( this.value );
// 	        .draw();
	} );
	// #column4_search_docwork is a <input type="text"> element
	$('#column4_search_docwork').on( 'keyup', function () {
	    table_blankview_docwork
	        .columns( 3 )
	        .search( this.value );
// 	        .draw();
	} );
	$('#filters_apply_docwork').on( 'click', function () {
	    table_blankview_docwork
			.draw();
	} );

	$('#filters_clear_docwork').on( 'click', function () {
		$('#column1_search_docwork').val('');
		$('#column2_search_docwork').val('');
		$('#column3_search_docwork').val('');
		$('#column4_search_docwork').val('');
	    table_blankview_docwork
	    	.columns()
	    	.search('')
	    	.draw();
	} );
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 

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
#blankview-docwork-table > thead {	background-color:#f1f1f1;	color:#111; font-family:'Oswald', sans-serif; border-bottom:none;	border-top:none }
#blankview-docwork-table > thead > tr > th { color:#333; border-bottom:none; font-weight:500; font-size:1.2em; text-transform:uppercase }
#blankview-docwork-table .sorting:after, #blankview-docwork-table .sorting_asc:after, #blankview-docwork-table .sorting_desc:after { display:none }
#blankview-docwork-table > thead > tr > th.sorting_asc { padding-right:8px }
#blankview-docwork-table > thead > tr > th.sorting_desc { padding-right:8px }
/* 
/* 
/* Тело таблицы */
#blankview-docwork-table {  }
#blankview-docwork-table > tbody { font-family:'Ubuntu', sans-serif; font-size: 0.9em; color:#666; border-bottom:none; border-top:none }
#blankview-docwork-table > tbody > tr > td {  }
#blankview-docwork-table > tbody > tr > td {
    padding: 5px 8px;
    line-height: 1.42857143;
    vertical-align: middle;
}
#blankview-docwork-table > thead > tr > th { border-bottom:none }
#blankview-docwork-table > tbody > tr > td {  }
#blankview-docwork-table > tbody > tr > td:last-child { text-align:right }

#blankview-docwork-table > tfoot > tr > td { padding:5px 4px }
#blankview-docwork-table > tfoot > tr > td:last-child { text-align:right }
#blankview-docwork-table > tfoot {
	background-color:#999;
}

/* 
----- ----- ----- ----- ----- ----- ----- ----- ----- -----  
*/
	#blankview-docwork-table > thead > tr > th:first-child, #blankview-docwork-table > tbody > tr > td:first-child { width:7%; text-align:center }
	#blankview-docwork-table > thead > tr > th:nth-child(2), #blankview-docwork-table > tbody > tr > td:nth-child(2) { width:7%; text-align:center }
	#blankview-docwork-table > thead > tr > th:nth-child(3), #blankview-docwork-table > tbody > tr > td:nth-child(3) { width:54%; text-align:left }
	#blankview-docwork-table > thead > tr > th:nth-child(4), #blankview-docwork-table > tbody > tr > td:nth-child(4) { width:22%; text-align:left }
	#blankview-docwork-table > thead > tr > th:nth-child(5), #blankview-docwork-table > tbody > tr > td:nth-child(5) { width:10%; text-align:center }
	#blankview-docwork-table .details-control:hover { cursor:pointer }
	
/* 
----- ----- ----- ----- ----- ----- ----- ----- ----- -----  
*/
	#blankview-docwork-table .sorting_asc:after { display:none }
	#blankview-docwork-table > thead > tr > th.sorting_asc { padding-right:8px }
/* 
----- ----- ----- ----- ----- ----- ----- ----- ----- -----  
*/
	#row-details { padding:0 35px }
	#row-details-subpodr { font-family:'Oswald', sans-serif; font-size:1.0em; color:#333 }
	#row-details-subpodr > tbody >tr > td { text-align:left }
	
	#row-details-subpodr .title-column { font-family:'Oswald', sans-serif; font-weight:400 }
	#row-details-subpodr .data-column { font-family: Courier, Courier new, Serif; font-weight:300 }

	#blankview-docwork-table > tfoot > tr > td { padding:5px 4px }
	#blankview-docwork-table > tfoot {
		background-color:#999;
	}
	#column1_search_docwork, #column2_search_docwork, #column3_search_docwork, #column4_search_docwork {
		width: 100%;
		padding: 5px 5px;
		font-weight: 400;
		font-size: 0.9em;
		color: #333;
		max-height:31px;
	}
	#column1_search_docwork { text-align:center }
	#column2_search_docwork { text-align:center }
	#column3_search_docwork { text-align:left }
	#column4_search_docwork { text-align:left }
	
	#filters_clear_docwork, #filters_apply_docwork { min-width:50px; max-width:50px; padding:6px; font-weight:400; font-size:0.9em } 
</style>


		<section>
			<div class="space30"></div>
			<div class="demo-html"></div>
			<table id="blankview-docwork-table" class="table" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th width="7%" class="text-center">№</th>
						<th width="7%" class="text-center">Год</th>
						<th width="54%" class="text-left">Описание</th>
						<th width="22%" class="text-left">Организация</th>
						<th width="10%"></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th width="7%" class="text-center"><input id="column1_search_docwork" placeholder="###" type="text"></input></th>
						<th width="7%" class="text-center"><input id="column2_search_docwork" placeholder="ГГГГ" type="text"></input></th>
						<th width="54%" class="text-center"><input id="column3_search_docwork" placeholder="Описание" type="text"></input></th>
						<th width="22%" class="text-center"><input id="column4_search_docwork" placeholder="Организация" type="text"></input></th>
						<th width="10%">
							<div class="btn-group btn-group-justified">
								<div class="btn-group">
									<button id="filters_apply_docwork" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
								</div>
								<div class="btn-group">
									<button id="filters_clear_docwork" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span></button>
								</div>
							</div>
						</th>
					</tr>
				</tfoot>
			</table>
		</section>
