
<script type="text/javascript" language="javascript" class="init">

var table_tab_zayvtel;
var editor_tab_zayvtel;		// use a global for the submit and return data rendering in the examples

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
//
$(document).ready(function() {



	editor_tab_zayvtel = new $.fn.dataTable.Editor( {
		"display": "bootstrap",
		"ajax": "php/examples/php/zayvsp/zayvsp-details/dognet-zayvsp-details-tab_zayvtel-process.php",
		"table": "#sp-zayvtel",
		"fields": [
			{
				"label": "Краткое название",
				"name": "namezakshot",
				"attr": { "placeholder": 'Краткое название компании-заказчика' }
			}, {
				"label": "Полное название",
				"name": "namezaklong",
				"attr": { "placeholder": 'Полное название компании-заказчика' }
			}, {
				"label": "Юридический адрес",
				"name": "zakuraddress",
				"type": "textarea",
				"attr": { "placeholder": 'Юридический адрес' }
			}, {
				"label": "Банковские реквизиты",
				"name": "zakbankch",
				"type": "textarea",
				"attr": { "placeholder": 'Банковские реквизиты' }
			}, {
				"label": "ИНН",
				"name": "zakinn",
				"attr": { "placeholder": 'ИНН' }
			}, {
				"label": "КПП",
				"name": "zakkpp",
				"attr": { "placeholder": 'КПП' }
			}, {
				"label": "Должность контакта",
				"name": "zakdolg",
				"attr": { "placeholder": 'Должность получателя документа' }
			}, {
				"label": "Фамилия",
				"name": "zaklastname",
				"attr": { "placeholder": 'Фамилия получателя' }
			}, {
				"label": "Имя",
				"name": "zakfistname",
				"attr": { "placeholder": 'Имя получателя' }
			}, {
				"label": "Телефон / факс",
				"name": "zaktelnumber",
				"attr": { "placeholder": 'Телефон / факс компании-заказчика' }
			}
		]
	} );

	table_tab_zayvtel = $('#zayvsp-tab_zayvtel-table').DataTable( {
		dom: "<'row'<'col-sm-5'B><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'l>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'p>>",
// 		dom: "<'space50'r>lftip",
		language: {
			url: "php/examples/simple/zayvsp/zayvsp-details/dt_russian-sp.json"
		},
		ajax: {
			url: "php/examples/simple/zayvsp/zayvsp-details/restr_3/tabs/process/dognet-zayvsp-details-tab_zayvtel-process.php",
			type: "POST"
		},
		serverSide: true,
		columns: [
			{
				class: "details-control",
				searchable: false,
				orderable: false,
				data: null,
				defaultContent: "<span class='glyphicon glyphicon-option-vertical'></span>",
				className: "text-center"
			},
			{ data: "dognet_spzayvtel.namezayvtel", defaultContent: "" },
			{ data: "dognet_spzayvtel.doljzayvtel" },
			{ data: "dognet_spispol.ispolnameshot" },
			{ data: null, defaultContent: "" }
		],
		columnDefs: [
			{ orderable: false, targets: 0 },
			{ orderable: false, targets: 1 },
			{ orderable: false, targets: 2 },
			{ orderable: false, targets: 3 },
			{ orderable: false, targets: 4 }
		],
		order: [ [ 1, "asc" ] ],
		select: true,
		processing: false,
		paging: true,
		searching: true,
		pageLength: 15,
		lengthChange: false,
		lengthMenu: [ [15, 30, 50, -1], [15, 30, 50, "Все"] ],
		buttons: [
			{ text:	'<span class="glyphicon glyphicon-refresh"></span>', action:
				function ( e, dt, node, config ) {
					$('#column1_search_tab1').val('');
					$('#column2_search_tab1').val('');
					$('#column3_search_tab1').val('');
					table_tab_zayvtel.columns().search('');
					table_tab_zayvtel.order([1,"asc"]).draw();
				}
			},
			{ extend: "create", editor: editor_tab_zayvtel, text: "НОВЫЙ" },
			{ extend: "edit",   editor: editor_tab_zayvtel, text: "ИЗМЕНИТЬ" },
			{ extend: "remove", editor: editor_tab_zayvtel, text: "УДАЛИТЬ" }
		]
	} );

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    var detailRows = [];
    $('#zayvsp-tab_zayvtel-table tbody').on( 'click', 'tr td.details-control', function () {
      var tr = $(this).closest('tr');
      var row = table_tab_zayvtel.row( tr );
      var idx = $.inArray( tr.attr('id'), detailRows );
      if ( row.child.isShown() ) {
	      tr.removeClass( 'details' );
	      row.child.hide();
	      detailRows.splice( idx, 1 );
      }
      else {
        tr.addClass( 'details' );
				rowData = table_tab_zayvtel.row( row );
				d = row.data();
				rowData.child( <?php include('templates/zayvsp-details_tab_zayvtel.tpl'); ?> ).show();
	      if ( idx === -1 ) {
					detailRows.push( tr.attr('id') );
	      }
			}
    } );

		table_tab_zayvtel.on( 'draw', function () {
			$.each( detailRows, function ( i, id ) {
			$('#'+id+' td.details-control').trigger( 'click' );
	  } );
	} );

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	// #column1_search_tab1 is a <input type="text"> element
	$('#column1_search_tab1').on( 'keyup', function () {
	    table_tab_zayvtel
	        .columns( 3 )
	        .search( this.value );
// 	        .draw();
	} );
	// #column2_search_tab1 is a <input type="text"> element
	$('#column2_search_tab1').on( 'keyup', function () {
	    table_tab_zayvtel
	        .columns( 4 )
	        .search( this.value );
// 	        .draw();
	} );
	// #column3_search_tab1 is a <input type="text"> element
	$('#column3_search_tab1').on( 'keyup', function () {
	    table_tab_zayvtel
	        .columns( 5 )
	        .search( this.value );
// 	        .draw();
	} );
	$('#filters_apply_tab1').on( 'click', function () {
	    table_tab_zayvtel
			.draw();
	} );

	$('#filters_clear_tab1').on( 'click', function () {
		$('#column1_search_tab1').val('');
		$('#column2_search_tab1').val('');
		$('#column3_search_tab1').val('');
	    table_tab_zayvtel
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
*/

/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----

ОСНОВНАЯ ТАБЛИЦА

----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
/*
/* Общее для таблицы */
	#zayvsp-tab_zayvtel {  }
/*
/*
/* Заголовок таблицы */
	#zayvsp-tab_zayvtel-table > thead {	background-color:#f1f1f1;	color:#111; font-family:'Oswald', sans-serif; border-bottom:none; border-top:none }
	#zayvsp-tab_zayvtel-table > thead > tr > th { color:#333; border-bottom:none; font-weight:500; font-size:1.2em; text-transform:uppercase }
	#zayvsp-tab_zayvtel-table .sorting:after, #zayvsp-tab_zayvtel-table .sorting_asc:after, #zayvsp-tab_zayvtel-table .sorting_desc:after { display:none }
	#zayvsp-tab_zayvtel-table > thead > tr > th.sorting_asc { padding-right:8px }
	#zayvsp-tab_zayvtel-table > thead > tr > th.sorting_desc { padding-right:8px }
/*
/*
/* Тело таблицы */
	#zayvsp-tab_zayvtel-table {  }
	#zayvsp-tab_zayvtel-table > tbody { font-family:'Ubuntu', sans-serif; font-size: 0.9em; color:#666; border-bottom:none; border-top:none }
	#zayvsp-tab_zayvtel-table > tbody > tr > td {  }
	#zayvsp-tab_zayvtel-table > tbody > tr > td {
	    padding: 5px 8px;
	    line-height: 1.42857143;
	    vertical-align: middle;
	}
	#zayvsp-tab_zayvtel-table > thead > tr > th { border-bottom:none }
	#zayvsp-tab_zayvtel-table > tbody > tr > td {  }
	#zayvsp-tab_zayvtel-table > tbody > tr > td:last-child { text-align:right }

	#zayvsp-tab_zayvtel-table > tfoot > tr > td { padding:5px 4px }
	#zayvsp-tab_zayvtel-table > tfoot {
		background-color:#999;
	}
/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
	#zayvsp-tab_zayvtel-table > thead > tr > th:first-child, #zayvsp-tab_zayvtel-table > tbody > tr > td:first-child { width:1%; text-align:center }
	#zayvsp-tab_zayvtel-table > thead > tr > th:nth-child(2), #zayvsp-tab_zayvtel-table > tbody > tr > td:nth-child(2) { width:34%; text-align:left }
	#zayvsp-tab_zayvtel-table > thead > tr > th:nth-child(3), #zayvsp-tab_zayvtel-table > tbody > tr > td:nth-child(3) { width:20%; text-align:left }
	#zayvsp-tab_zayvtel-table > thead > tr > th:nth-child(4), #zayvsp-tab_zayvtel-table > tbody > tr > td:nth-child(4) { width:25%; text-align:left }
	#zayvsp-tab_zayvtel-table > thead > tr > th:nth-child(5), #zayvsp-tab_zayvtel-table > tbody > tr > td:nth-child(5) { width:20%; text-align:left }

	#zayvsp-tab_zayvtel-table .details-control:hover { cursor:pointer }

/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
	#zayvsp-tab_zayvtel-table .sorting_asc:after { display:none }
	#zayvsp-tab_zayvtel-table > thead > tr > th.sorting_asc { padding-right:8px }
/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
	#row-details { padding:0 35px }
	#row-details-zakazchik { font-family:'Oswald', sans-serif; font-size:1.0em; color:#333 }
	#row-details-zakazchik > tbody >tr > td { text-align:left }

	#row-details-zakazchik .title-column { font-family:'Oswald', sans-serif; font-weight:400 }
	#row-details-zakazchik .data-column { font-family: Courier, Courier new, Serif; font-weight:300 }

	#zayvsp-tab_zayvtel-table > tfoot > tr > td { padding:5px 4px }
	#zayvsp-tab_zayvtel-table > tfoot {
		background-color:#999;
	}
	#column1_search_tab1, #column2_search_tab1, #column3_search_tab1, #column4_search_tab1 {
		width: 100%;
		padding: 5px 5px;
		font-weight: 400;
		font-size: 0.9em;
		color: #333;
		max-height:31px;
	}
	#column1_search_tab1 { text-align:left }
	#column2_search_tab1 { text-align:left }
	#column3_search_tab1 { text-align:left }
	#column4_search_tab1 { text-align:left }

	#filters_clear_tab1, #filters_apply_tab1 { padding:6px; font-weight:400; font-size:0.9em }
</style>

<div class="space20"></div>
<section>

	<div id="zayvsp-tab_zayvtel" class="">
		<div id="tab_zayvtel" class="">
			<div class="demo-html"></div>
			<table id="zayvsp-tab_zayvtel-table" class="table" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th><span class='glyphicon glyphicon-option-vertical'></span></th>
						<th>Заявитель</th>
						<th>Должность</th>
						<th>Отдел</th>
						<th></th>
					</tr>
				</thead>
			</table>
		</div>
	</div>

</section>
