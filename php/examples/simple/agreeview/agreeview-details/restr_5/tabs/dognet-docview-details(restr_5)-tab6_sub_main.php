
<script type="text/javascript" language="javascript" class="init">

var table_sub_main;
var table_sub_child_chetf;
var table_sub_child_oplatachf;
var table_sub_child_avans;

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

$(document).ready(function() {
//
//
//
// СУБПОДРЯД
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Обработчик таблицы заявок
//
	table_sub_main = $('#docview-sub-main').DataTable( {
		dom: "<'row'<'col-sm-5'><'col-sm-4'><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-1'B><'col-sm-5'i><'col-sm-6'p>>",
/* 		dom: "<'row'<'col-md-8 col-sm-12'B><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'>>", */
		language: {
				url: "php/examples/simple/docview/docview-details/dt_russian-tab6_sub_main.json"
		},
		ajax: {
			url: "php/examples/php/docview/docview-details/dognet-docview-details-tab6_sub_main-process.php",
			type: "POST",
	    data: function ( d ) {
		     }
		},
		serverSide: true,
	  select: {
	      style: 'single'
	  },
		columns: [
			{
				data: null,
				class: "details-control",
				searchable: false,
				orderable: false,
				defaultContent: "<span class='glyphicon glyphicon-option-vertical'></span>"
			},
	    { data: "dognet_dockalplan.numberstage",
	      render: function ( data, type, row ) {
	          if (type === 'display') {
	            return '';
	          }
	          return row.dognet_dockalplan.numberstage;
	      }
	    },
			{ data: "dognet_docsubpodr.numberdocsubpodr", className: "" },
			{ data: "dognet_docsubpodr.datedocsubpodr", className: "" },
			{ data: "dognet_spsubpodr.namesubpodrshot", className: "" },
			{ data: "dognet_docsubpodr.sumdocsubpodr", className: "" },
			{ data: "dognet_docsubpodr.sumzadolsubpodr", className: "" },
		],
		columnDefs: [
			{ orderable: false, searchable: false, targets: 0 },
			{ orderable: true, searchable: false, visible: false, targets: 1 },
			{ orderable: false, searchable: false, render: function ( data ) { return data; }, targets: 2 },
			{
				orderable: false,
				searchable: false,
				type: "date",
				targets: 3
			},
			{ orderable: false, searchable: false, render: function ( data ) { return data; }, targets: 4 },
			{ orderable: false, searchable: false, render: function ( data, type, row, meta ) {
				if (data != null) {
					return $.fn.dataTable.render.number(' ', ',', 2, '').display( data )+row.dognet_spdened.short_code;
				}
				else {
					return "0.00"+row.dognet_spdened.short_code;
				}
				}, targets: 5
			},
			{ orderable: false, searchable: false, render: function ( data, type, row, meta ) {
				if (data != null) {
					return $.fn.dataTable.render.number(' ', ',', 2, '').display( data )+row.dognet_spdened.short_code;
				}
				else {
					return "0.00"+row.dognet_spdened.short_code;
				}
				}, targets: 6
			}
		],
	  order: [[3, 'desc']],
	  rowGroup: {
				dataSrc: function(row) {
					if (row.dognet_docbase.kodshab === "1" || row.dognet_docbase.kodshab === "3") {
						return "Этап "+row.dognet_dockalplan.numberstage;
					}
					else if (row.dognet_docbase.kodshab === "2" || row.dognet_docbase.kodshab === "4") {
						return "Договор 3-4/"+row.dognet_docbase.docnumber+" (без календарного плана)";
					}
				},
	      startRender: function ( rows, group ) {
		      return group;
				},
	      endRender: null,
				emptyDataGroup: 'No categories assigned yet'
	  },
		select: true,
		processing: true,
		paging: true,
		searching: false,
		lengthChange: false,
		buttons: [
	    { text:	'<span class="glyphicon glyphicon-refresh"></span>', action:
	      function ( e, dt, node, config ) {
			    table_sub_main.ajax.reload();
					table_sub_main.columns().search('').draw();
				}
			}
		]
	} );
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Обработчик child-таблицы для выбранной заявки
// Array to track the ids of the details displayed rows
  var detailRows_sub_main = [];
  $('#docview-sub-main tbody').on( 'click', 'tr td.details-control', function () {
      var tr = $(this).closest('tr');
      var row = table_sub_main.row( tr );
      var idx = $.inArray( tr.attr('id'), detailRows_sub_main );

      if ( row.child.isShown() ) {
          tr.removeClass( 'details' );
          row.child.hide();

          // Remove from the 'open' array
          detailRows_sub_main.splice( idx, 1 );
      }
      else {
          tr.addClass( 'details' );
					rowData = table_sub_main.row( row );
					d = row.data();
					rowData.child( <?php include('templates/docview-details_tab6_sub_main.tpl'); ?> ).show();
// Add to the 'open' array
		      if ( idx === -1 ) {
		          detailRows_sub_main.push( tr.attr('id') );
		      }
      }
  } );
// On each draw, loop over the `detailRows` array and show any child rows
	table_sub_main.on( 'draw', function () {
		$.each( detailRows_sub_main, function ( i, id ) {
		$('#'+id+' td.details-control').trigger( 'click' );
	    } );
	} );
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Обработчики событий таблицы заявок
	table_sub_main.on( 'select', function () {
		table_sub_child_chetf.buttons().enable();
    table_sub_child_chetf.ajax.reload(null, true);
	} );
	table_sub_main.on( 'deselect', function () {
		table_sub_child_chetf.rows().deselect();
    table_sub_child_chetf.ajax.reload(null, true);
		table_sub_child_oplatachf.rows().deselect();
    table_sub_child_oplatachf.ajax.reload(null, true);
		table_sub_child_avans.rows().deselect();
    table_sub_child_avans.ajax.reload(null, true);
	} );
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
} );
</script>
<?php
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-details/restr_5/tabs/css/docview-details-common-tab6_sub_main.css">
<h3 class="docview-details-title2 text-right">Договора субподряда</h3>
<div class="demo-html"></div>
<table id="docview-sub-main" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th><span class='glyphicon glyphicon-option-vertical'></span></th>
			<th></th>
			<th>Договор</th>
			<th>Дата</th>
			<th>Организация</th>
			<th>Сумма</th>
			<th>Задолженность</th>
		</tr>
	</thead>
</table>
