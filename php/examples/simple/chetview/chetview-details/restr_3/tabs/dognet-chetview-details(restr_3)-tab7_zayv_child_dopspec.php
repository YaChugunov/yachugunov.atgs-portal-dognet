
<script type="text/javascript" language="javascript" class="init">

var table_zayv_child_dopspec;

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

$(document).ready(function() {
//
//
// TAB #3 :::
// СПЕЦИФИКАЦИЯ (файл)
//
// ----- ----- -----
// Обработчик таблицы счетов
	table_zayv_child_dopspec = $('#chetview-zayv-child-dopspec').DataTable( {
		dom: "<'row'<'col-sm-5'><'col-sm-4'><'col-sm-3'<'test_msg'>>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-1'B><'col-sm-5'i><'col-sm-6'p>>",
		language: {
			url: "php/examples/simple/chetview/chetview-details/dt_russian-tab7_zayv_child_dopspec.json"
		},
		ajax: {
			url: "php/examples/php/chetview/chetview-details/dognet-chetview-details-tab7_zayv_child_dopspec-process.php",
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
          console.log ("kodmainspec : "+data.dognet_doczayvdopspec.kodmainspec);
      if ( data.dognet_doczayvdopspec.kodmainspec == 1 ) {
          $(row).addClass('no-select');
          $('td', row).eq(1).css({'font-weight':'700','color':'#000'});
          $('td', row).eq(2).css({'font-weight':'700','color':'#000'});
      }
		},
		columns: [
      {
				class: "details-control",
				searchable: false,
				orderable: false,
				data: null,
				defaultContent: "<span class='glyphicon glyphicon-option-vertical'></span>"
			},
			{ data: "dognet_doczayvdopspec.numberdopspec" },
			{ data: "dognet_doczayvdopspec.namedopspec" },
      {
        data: "dognet_doczayvdopspec.dopFileID",
        render: function ( id ) {
            return id ?
                /* '<a class="" target="_blank" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet'+editor_zayv_child_dopspec.file( 'dognet_doczayvdopspec_files', id ).file_webpath+'"><span class="glyphicon glyphicon-file"></span></a>' */ '' :
                '<span class="glyphicon glyphicon-option-horizontal"></span>';
        },
        defaultContent: "",
				className: "text-center"
      }
		],
		select: {
			style: 'single',
			selector: 'tr:not(.no-select)'
		},
		columnDefs: [
			{ orderable: false, searchable: false, targets: 0 },
			{ orderable: true, searchable: false, targets: 1 },
			{ orderable: false, searchable: false, targets: 2 },
			{ orderable: false, searchable: true, targets: 3 }
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
			    table_zayv_child_dopspec.ajax.reload();
					table_zayv_child_dopspec.columns().search('').draw();
				}
			}
		],
		drawCallback: function () {

		}
	} );
// ----- ----- -----
// Обработчик child-таблицы выбранного счета
// Array to track the ids of the details displayed rows
  var detailRows_zayv_child_dopspec = [];
  $('#chetview-zayv-child-dopspec tbody').on( 'click', 'tr td.details-control', function () {
      var tr = $(this).closest('tr');
      var row = table_zayv_child_dopspec.row( tr );
      var idx = $.inArray( tr.attr('id'), detailRows_zayv_child_dopspec );

      if ( row.child.isShown() ) {
          tr.removeClass( 'details' );
          row.child.hide();

          // Remove from the 'open' array
          detailRows_zayv_child_dopspec.splice( idx, 1 );
      }
      else {
          tr.addClass( 'details' );
		rowData = table_zayv_child_dopspec.row( row );
		d = row.data();
		rowData.child( <?php include('templates/chetview-details_tab7_zayv_child_dopspec.tpl'); ?> ).show();

// Add to the 'open' array
          if ( idx === -1 ) {
              detailRows_zayv_child_dopspec.push( tr.attr('id') );
          }
      }
  } );
// On each draw, loop over the `detailRows` array and show any child rows
	table_zayv_child_dopspec.on( 'draw', function () {
		$.each( detailRows_zayv_child_dopspec, function ( i, id ) {
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
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/chetview/chetview-details/restr_3/tabs/css/chetview-details-common-tab7_zayv_child_dopspec.css">
<h3 class="chetview-details-title2 text-right">Спецификации к заявке (в виде прикреплённых файлов)</h3>
<div class="demo-html"></div>
<table id="chetview-zayv-child-dopspec" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
			<th>#</th>
			<th>Название</th>
			<th></th>
		</tr>
	</thead>
</table>

