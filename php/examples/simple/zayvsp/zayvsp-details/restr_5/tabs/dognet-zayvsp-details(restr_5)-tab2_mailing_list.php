
<script type="text/javascript" language="javascript" class="init">

var table_tab2_mailing_list;
var editor_tab2_mailing_list;		// use a global for the submit and return data rendering in the examples

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
//
$(document).ready(function() {



	editor_tab2_mailing_list = new $.fn.dataTable.Editor( {
		"display": "bootstrap",
		"ajax": "php/examples/php/zayvsp/zayvsp-details/dognet-zayvsp-details-tab2_mailing_list-process.php",
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

	table_tab2_mailing_list = $('#zayvsp-tab2_mailing_list-table').DataTable( {
		dom: "<'row'<'col-sm-5'B><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'l>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'p>>",
// 		dom: "<'space50'r>lftip",
		language: {
			url: "php/examples/simple/zayvsp/zayvsp-details/dt_russian-sp.json"
		},
		ajax: {
			url: "php/examples/php/zayvsp/zayvsp-details/dognet-zayvsp-details-tab2_mailing_list-process.php",
			type: "POST"
		},
		serverSide: true,
		columns: [
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
					table_tab2_mailing_list.columns().search('');
					table_tab2_mailing_list.order([1,"asc"]).draw();
				}
			},
			{ extend: "create", editor: editor_tab2_mailing_list, text: "НОВЫЙ" },
			{ extend: "edit",   editor: editor_tab2_mailing_list, text: "ИЗМЕНИТЬ" },
			{ extend: "remove", editor: editor_tab2_mailing_list, text: "УДАЛИТЬ" }
		]
	} );

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    var detailRows = [];
    $('#zayvsp-tab2_mailing_list-table tbody').on( 'click', 'tr td.details-control', function () {
      var tr = $(this).closest('tr');
      var row = table_tab2_mailing_list.row( tr );
      var idx = $.inArray( tr.attr('id'), detailRows );
      if ( row.child.isShown() ) {
	      tr.removeClass( 'details' );
	      row.child.hide();
	      detailRows.splice( idx, 1 );
      }
      else {
        tr.addClass( 'details' );
				rowData = table_tab2_mailing_list.row( row );
				d = row.data();
				rowData.child( <?php include('templates/zayvsp-details_tab2_mailing_list.tpl'); ?> ).show();
	      if ( idx === -1 ) {
					detailRows.push( tr.attr('id') );
	      }
			}
    } );

		table_tab2_mailing_list.on( 'draw', function () {
			$.each( detailRows, function ( i, id ) {
			$('#'+id+' td.details-control').trigger( 'click' );
	  } );
	} );

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	// #column1_search_tab1 is a <input type="text"> element
	$('#column1_search_tab1').on( 'keyup', function () {
	    table_tab2_mailing_list
	        .columns( 3 )
	        .search( this.value );
// 	        .draw();
	} );
	// #column2_search_tab1 is a <input type="text"> element
	$('#column2_search_tab1').on( 'keyup', function () {
	    table_tab2_mailing_list
	        .columns( 4 )
	        .search( this.value );
// 	        .draw();
	} );
	// #column3_search_tab1 is a <input type="text"> element
	$('#column3_search_tab1').on( 'keyup', function () {
	    table_tab2_mailing_list
	        .columns( 5 )
	        .search( this.value );
// 	        .draw();
	} );
	$('#filters_apply_tab1').on( 'click', function () {
	    table_tab2_mailing_list
			.draw();
	} );

	$('#filters_clear_tab1').on( 'click', function () {
		$('#column1_search_tab1').val('');
		$('#column2_search_tab1').val('');
		$('#column3_search_tab1').val('');
	    table_tab2_mailing_list
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
	#zayvsp-tab2_mailing_list {  }
/*
/*
/* Заголовок таблицы */
	#zayvsp-tab2_mailing_list-table > thead {	background-color:#f1f1f1;	color:#111; font-family:'Oswald', sans-serif; border-bottom:none; border-top:none }
	#zayvsp-tab2_mailing_list-table > thead > tr > th { color:#333; border-bottom:none; font-weight:500; font-size:1.2em; text-transform:uppercase }
	#zayvsp-tab2_mailing_list-table .sorting:after, #zayvsp-tab2_mailing_list-table .sorting_asc:after, #zayvsp-tab2_mailing_list-table .sorting_desc:after { display:none }
	#zayvsp-tab2_mailing_list-table > thead > tr > th.sorting_asc { padding-right:8px }
	#zayvsp-tab2_mailing_list-table > thead > tr > th.sorting_desc { padding-right:8px }
/*
/*
/* Тело таблицы */
	#zayvsp-tab2_mailing_list-table {  }
	#zayvsp-tab2_mailing_list-table > tbody { font-family:'Ubuntu', sans-serif; font-size: 0.9em; color:#666; border-bottom:none; border-top:none }
	#zayvsp-tab2_mailing_list-table > tbody > tr > td {  }
	#zayvsp-tab2_mailing_list-table > tbody > tr > td {
	    padding: 5px 8px;
	    line-height: 1.42857143;
	    vertical-align: middle;
	}
	#zayvsp-tab2_mailing_list-table > thead > tr > th { border-bottom:none }
	#zayvsp-tab2_mailing_list-table > tbody > tr > td {  }
	#zayvsp-tab2_mailing_list-table > tbody > tr > td:last-child { text-align:right }

	#zayvsp-tab2_mailing_list-table > tfoot > tr > td { padding:5px 4px }
	#zayvsp-tab2_mailing_list-table > tfoot {
		background-color:#999;
	}
/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
	#zayvsp-tab2_mailing_list-table > thead > tr > th:first-child, #zayvsp-tab2_mailing_list-table > tbody > tr > td:first-child { width:1%; text-align:center }
	#zayvsp-tab2_mailing_list-table > thead > tr > th:nth-child(2), #zayvsp-tab2_mailing_list-table > tbody > tr > td:nth-child(2) { width:34%; text-align:left }
	#zayvsp-tab2_mailing_list-table > thead > tr > th:nth-child(3), #zayvsp-tab2_mailing_list-table > tbody > tr > td:nth-child(3) { width:20%; text-align:left }
	#zayvsp-tab2_mailing_list-table > thead > tr > th:nth-child(4), #zayvsp-tab2_mailing_list-table > tbody > tr > td:nth-child(4) { width:25%; text-align:left }
	#zayvsp-tab2_mailing_list-table > thead > tr > th:nth-child(5), #zayvsp-tab2_mailing_list-table > tbody > tr > td:nth-child(5) { width:20%; text-align:left }

	#zayvsp-tab2_mailing_list-table .details-control:hover { cursor:pointer }

/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
	#zayvsp-tab2_mailing_list-table .sorting_asc:after { display:none }
	#zayvsp-tab2_mailing_list-table > thead > tr > th.sorting_asc { padding-right:8px }
/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
	#row-details { padding:0 35px }
	#row-details-zakazchik { font-family:'Oswald', sans-serif; font-size:1.0em; color:#333 }
	#row-details-zakazchik > tbody >tr > td { text-align:left }

	#row-details-zakazchik .title-column { font-family:'Oswald', sans-serif; font-weight:400 }
	#row-details-zakazchik .data-column { font-family: Courier, Courier new, Serif; font-weight:300 }

	#zayvsp-tab2_mailing_list-table > tfoot > tr > td { padding:5px 4px }
	#zayvsp-tab2_mailing_list-table > tfoot {
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

	<div id="zayvsp-tab2_mailing_list" class="">
		<div id="tab2_mailing_list" class="">
			<div class="demo-html"></div>
			<table id="zayvsp-tab2_mailing_list-table" class="table" cellspacing="0" width="100%">
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
