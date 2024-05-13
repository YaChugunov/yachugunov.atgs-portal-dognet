
<script type="text/javascript" language="javascript" class="init">

var table_zayv_child_dop_docspec;

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

$(document).ready(function() {
//
//
// TAB #5 :::
// СПЕЦИФИКАЦИИ (договор)
//
// ----- ----- -----
// Обработчик таблицы спецификаций из договора
	table_zayv_child_dop_docspec = $('#chetview-zayv-child-dop-docspec').DataTable( {
		dom: "<'row'<'col-sm-5'><'col-sm-4'><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-1'B><'col-sm-5'i><'col-sm-6'p>>",
		language: {
			url: "php/examples/simple/chetview/chetview-details/dt_russian-tab7_zayv_child_dop-docspec.json"
		},
		ajax: {
			url: "php/examples/php/chetview/chetview-details/dognet-chetview-details-tab7_zayv_child_dop-docspec-process.php",
			type: "POST",
      data: function ( d ) {
          var selected = table_zayv_main.row( { selected: true } );
          if ( selected.any() ) {
                d.koddoc = selected.data().dognet_doczayv.koddoc;
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
      {
        data: "dognet_docpaper.kodpaper",
        render: function ( data, type, row, meta ) {
          return data ? '<a class="" target="_blank" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet'+row.dognet_docpaper_files.file_webpath+'">'+row.dognet_docpaper.paperfull+'</a>' : '<span class="glyphicon glyphicon-option-horizontal"></span>';
        },
        defaultContent: "",
				className: "text-center"
      },
			{ data: "dognet_docpaper_files.file_extension" },
		],
		select: 'single',
		columnDefs: [
			{ orderable: false, searchable: false, targets: 0 },
			{ orderable: true, searchable: false, targets: 1 },
			{ orderable: false, searchable: false, targets: 2 }
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
			    table_zayv_child_dop_docspec.ajax.reload();
					table_zayv_child_dop_docspec.columns().search('').draw();
				}
			}
		],
		drawCallback: function () {

		}
	} );
// ----- ----- -----
// Обработчик child-таблицы выбранного счета
// Array to track the ids of the details displayed rows
  var detailRows_zayv_child_dop_docspec = [];
  $('#chetview-zayv-child-dop-docspec tbody').on( 'click', 'tr td.details-control', function () {
      var tr = $(this).closest('tr');
      var row = table_zayv_child_dop_docspec.row( tr );
      var idx = $.inArray( tr.attr('id'), detailRows_zayv_child_dop_docspec );

      if ( row.child.isShown() ) {
          tr.removeClass( 'details' );
          row.child.hide();

          // Remove from the 'open' array
          detailRows_zayv_child_dop_docspec.splice( idx, 1 );
      }
      else {
          tr.addClass( 'details' );
		rowData = table_zayv_child_dop_docspec.row( row );
		d = row.data();
		rowData.child( <?php include('templates/chetview-details_tab7_zayv_child_dop-docspec.tpl'); ?> ).show();

// Add to the 'open' array
          if ( idx === -1 ) {
              detailRows_zayv_child_dop_docspec.push( tr.attr('id') );
          }
      }
  } );
// On each draw, loop over the `detailRows` array and show any child rows
	table_zayv_child_dop_docspec.on( 'draw', function () {
		$.each( detailRows_zayv_child_dop_docspec, function ( i, id ) {
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
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/chetview/chetview-details/restr_5/tabs/css/chetview-details-common-tab7_zayv_child_dop-docspec.css">
<h3 class="chetview-details-title2 text-right">Спецификации из договора</h3>
<div class="demo-html"></div>
<table id="chetview-zayv-child-dop-docspec" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
			<th>Имя файла</th>
			<th>Тип</th>
		</tr>
	</thead>
</table>
