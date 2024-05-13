
<script type="text/javascript" language="javascript" class="init">

var table_zayv_child_dop;

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

$(document).ready(function() {
//
//
// TAB #2 :::
// СПЕЦИФИКАЦИЯ (список)
//
// ----- ----- -----
// Обработчик таблицы счетов
	table_zayv_child_dop = $('#docview-zayv-child-dop').DataTable( {
		dom: "<'row'<'col-sm-5'><'col-sm-4'><'col-sm-3'<'test_msg'>>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-1'B><'col-sm-5'i><'col-sm-6'p>>",
		language: {
			url: "php/examples/simple/docview/docview-details/dt_russian-tab7_zayv_child_dop.json"
		},
		ajax: {
			url: "php/examples/php/docview/docview-details/dognet-docview-details-tab7_zayv_child_dop-process.php",
			type: "POST",
      data: function ( d ) {
          var selected = table_zayv_main.row( { selected: true } );
          if ( selected.any() ) {
                d.kodzayv = selected.data().dognet_doczayv.kodzayv;
          }
      }
		},
		serverSide: true,
		createdRow: function ( row, data, index ) {

		},
		columns: [
      {
				class: "details-control",
				searchable: false,
				orderable: false,
				data: null,
				defaultContent: "<span class='glyphicon glyphicon-option-vertical'></span>"
			},
			{ data: "dognet_doczayvdop.numberdop" },
			{ data: "dognet_doczayvdop.namedop" },
			{ data: "dognet_doczayvdop.modeldop" },
			{ data: "dognet_doczayvdop.koldop" }
		],
		select: 'single',
		columnDefs: [
			{ orderable: false, searchable: false, targets: 0 },
			{ orderable: true, searchable: false, targets: 1 },
			{ orderable: false, searchable: true, targets: 2 },
			{ orderable: false, searchable: true, targets: 3 },
			{ orderable: false, searchable: true, targets: 4 }
		],
		order: [ [ 1, "asc" ] ],
		ordering: true,
		paging: true,
		searching: true,
		select: false,
		pageLength: 15,
		lengthChange: false,
		lengthMenu: [ [15, 30, 50, -1], [15, 30, 50, "Все"] ],
		buttons: [
	    { text:	'<span class="glyphicon glyphicon-refresh"></span>', action:
	      function ( e, dt, node, config ) {
			    table_zayv_child_dop.ajax.reload();
					table_zayv_child_dop.columns().search('').draw();
				}
			}
		],
		drawCallback: function () {

		}
	} );
// ----- ----- -----
// Обработчик child-таблицы выбранного счета
// Array to track the ids of the details displayed rows
  var detailRows_zayv_child_dop = [];
  $('#docview-zayv-child-dop tbody').on( 'click', 'tr td.details-control', function () {
      var tr = $(this).closest('tr');
      var row = table_zayv_child_dop.row( tr );
      var idx = $.inArray( tr.attr('id'), detailRows_zayv_child_dop );

      if ( row.child.isShown() ) {
          tr.removeClass( 'details' );
          row.child.hide();

          // Remove from the 'open' array
          detailRows_zayv_child_dop.splice( idx, 1 );
      }
      else {
          tr.addClass( 'details' );
		rowData = table_zayv_child_dop.row( row );
		d = row.data();
		rowData.child( <?php include('templates/docview-details_tab7_zayv_child_dop.tpl'); ?> ).show();

// Add to the 'open' array
          if ( idx === -1 ) {
              detailRows_zayv_child_dop.push( tr.attr('id') );
          }
      }
  } );
// On each draw, loop over the `detailRows` array and show any child rows
	table_zayv_child_dop.on( 'draw', function () {
		$.each( detailRows_zayv_child_dop, function ( i, id ) {
		$('#'+id+' td.details-control').trigger( 'click' );
	    } );
	} );
} );
</script>
<?php
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-details/restr_5/tabs/css/docview-details-common-tab7_zayv_child_dop.css">
<h3 class="docview-details-title2 text-right">Спецификация к заявке (список, создаваемый вручную)</h3>
<div class="demo-html"></div>
<table id="docview-zayv-child-dop" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
			<th>#</th>
			<th>Название</th>
			<th>Модель</th>
			<th>Кол</th>
		</tr>
	</thead>
</table>
