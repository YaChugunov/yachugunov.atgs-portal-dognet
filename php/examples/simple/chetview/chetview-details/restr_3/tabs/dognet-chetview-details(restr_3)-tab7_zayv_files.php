
<script type="text/javascript" language="javascript" class="init">

var table_zayv_files;

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

$(document).ready(function() {
//
//
// TAB #3 :::
// СПЕЦИФИКАЦИЯ (файл)
//
// ----- ----- -----
// Обработчик таблицы счетов
	table_zayv_files = $('#chetview-zayv-files').DataTable( {
		dom: "<'row'<'col-sm-5'><'col-sm-4'><'col-sm-3'<'test_msg'>>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-1'B><'col-sm-5'i><'col-sm-6'p>>",
		language: {
			url: "php/examples/simple/chetview/chetview-details/dt_russian-tab7_zayv_files.json"
		},
		ajax: {
			url: "php/examples/php/chetview/chetview-details/dognet-chetview-details-tab7_zayv_files-process.php",
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
      {
        data: "dognet_doczayv_files.zayv_type",
        render: function ( data, type, row, meta ) {
	        if (data == "C" || data == "S") {
            return row.dognet_doczayv_files.file_webpath ? '<a class="" target="_blank" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet'+row.dognet_doczayv_files.file_webpath+'">'+row.dognet_doczayv_files.file_originalname+' (бланк заявки)</a>' : '<span class="glyphicon glyphicon-option-horizontal"></span>';
	        }
	        if (data == "D") {
            return row.dognet_doczayv_files.file_webpath ? '<a class="" target="_blank" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet'+row.dognet_doczayv_files.file_webpath+'">'+row.dognet_doczayv.namerabfilespec+'</a>' : '<span class="glyphicon glyphicon-option-horizontal"></span>';
	        }
	        else {
            return row.dognet_doczayv.file_webpath ? '<a class="" target="_blank" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet'+row.dognet_doczayv_files.file_webpath+'">'+row.dognet_doczayv_files.file_originalname+'</a>' : '<span class="glyphicon glyphicon-option-horizontal"></span>';
	        }
        },
        defaultContent: "",
				className: "text-center"
      },
			{ data: "dognet_doczayv_files.file_extension" },
		],
		select: {
			style: 'single',
			selector: 'tr:not(.no-select)'
		},
		columnDefs: [
			{ orderable: false, searchable: false, targets: 0 },
			{ orderable: true, searchable: false, targets: 1 },
			{ orderable: true, searchable: false, targets: 2 }
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
			    table_zayv_files.ajax.reload();
					table_zayv_files.columns().search('').draw();
				}
			}
		],
		drawCallback: function () {

		}
	} );
// ----- ----- -----
// Обработчик child-таблицы выбранного счета
// Array to track the ids of the details displayed rows
  var detailRows_zayv_files = [];
  $('#chetview-zayv-files tbody').on( 'click', 'tr td.details-control', function () {
      var tr = $(this).closest('tr');
      var row = table_zayv_files.row( tr );
      var idx = $.inArray( tr.attr('id'), detailRows_zayv_files );

      if ( row.child.isShown() ) {
          tr.removeClass( 'details' );
          row.child.hide();

          // Remove from the 'open' array
          detailRows_zayv_files.splice( idx, 1 );
      }
      else {
          tr.addClass( 'details' );
		rowData = table_zayv_files.row( row );
		d = row.data();
		rowData.child( <?php include('templates/chetview-details_tab7_zayv_files.tpl'); ?> ).show();

// Add to the 'open' array
          if ( idx === -1 ) {
              detailRows_zayv_files.push( tr.attr('id') );
          }
      }
  } );
// On each draw, loop over the `detailRows` array and show any child rows
	table_zayv_files.on( 'draw', function () {
		$.each( detailRows_zayv_files, function ( i, id ) {
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
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/chetview/chetview-details/restr_3/tabs/css/chetview-details-common-tab7_zayv_files.css">
<h3 class="chetview-details-title2 text-right">Спецификации к заявке (в виде прикреплённых файлов)</h3>
<div class="demo-html"></div>
<table id="chetview-zayv-files" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
			<th>Имя файла</th>
			<th>Тип</th>
		</tr>
	</thead>
</table>

