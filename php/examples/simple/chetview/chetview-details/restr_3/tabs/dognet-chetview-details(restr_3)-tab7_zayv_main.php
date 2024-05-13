
<script type="text/javascript" language="javascript" class="init">

var table_zayv_main;

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

$(document).ready(function() {
//
// ЗАЯВКА
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Обработчик таблицы заявок
//
	table_zayv_main = $('#chetview-zayv-main').DataTable( {
		dom: "<'row'<'col-sm-5'><'col-sm-4'><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-1'B><'col-sm-5'i><'col-sm-6'p>>",
		language: {
			url: "php/examples/simple/chetview/chetview-details/dt_russian-tab7_zayv_main.json"
		},
		ajax: {
			url: "php/examples/php/chetview/chetview-details/dognet-chetview-details-tab7_zayv_main-process.php",
			type: "POST"
		},
		serverSide: true,
		createdRow: function ( row, data, index ) {
      if (data.dognet_doczayv.koddoc == "000000000000000") {
          $('td', row).eq(6).addClass('highlight_0');
      }
      else if (data.dognet_doczayv.koddoc == "245375260650765") {
          $('td', row).eq(6).addClass('highlight_1');
      }
      else if (data.dognet_doczayv.koddoc == "245375544141726") {
          $('td', row).eq(6).addClass('highlight_2');
      }
      else {
          $('td', row).eq(6).addClass('highlight_td');
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
			{ data: "dognet_doczayv.tipusezayv" },
			{ data: "dognet_doczayv.datezayv" },
			{ data: "dognet_sptipzayvall.nametipzayvshotall" },
			{ data: "dognet_doczayv.numberzayv" },
			{ data: "dognet_doczayv.namerabfilespec" },
			{ data: "dognet_doczayv.koddoc" }
		],
		select: 'single',
    select: {
        toggleable: true
    },
		columnDefs: [
			{ orderable: false, searchable: false, targets: 0 },
			{ orderable: false, searchable: true,
				render: function ( data, type, row, meta ) {
					if (data == '0') {
						return '<span class="glyphicon glyphicon-play-circle" title="Заявка сформирована"></span>';
					}
					else if (data == '1') {
						return '<span class="text-warning glyphicon glyphicon-credit-card" title="Есть выставленные счета"></span>';
					}
					else if (data == '2') {
						return '<span class="text-success glyphicon glyphicon-ok-circle" title="Заявка закрыта"></span>';
					}
					else if (data == '3') {
						return '<span class="text-danger glyphicon glyphicon-ban-circle" title="Заявка аннулирована"></span>';
					}
					else if (data == '4') {
						return '<span class="text-info glyphicon glyphicon-credit-card" title="Все счета выставлены"></span>';
					}
					else {
						return "";
					}
				},
				targets: 1
			},
			{ orderable: true, searchable: true, targets: 2 },
			{ orderable: false, searchable: true, targets: 3 },
			{ orderable: false, searchable: true, targets: 4 },
			{ orderable: false, searchable: true, targets: 5 },
			{ orderable: false, searchable: true,
				render: function ( data, type, row, meta ) {
					if (data == '245375260650765') {
						return "На нужды АТГС";
					}
					else if (data == '245375544141726') {
						return "На склад";
					}
					else if (data == '000000000000000') {
						return "---";
					}
					else {
						return "Дог. 3-4/"+row.dognet_docbase.docnumber;
					}
				},
				targets: 6
			}
		],
		order: [ [ 2, "desc" ] ],
		ordering: true,
		processing: true,
		paging: true,
		searching: false,
		pageLength: 15,
		lengthChange: false,
		lengthMenu: [ [15, 30, 50, -1], [15, 30, 50, "Все"] ],
		buttons: [
			{ text:	'<span class="glyphicon glyphicon-refresh"></span>', action:
				function ( e, dt, node, config ) {
					table_zayv_main.ajax.reload(null, false);
				}
			}
		],
		drawCallback: function () {

		}
	} );
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Обработчик child-таблицы для выбранной заявки
// Array to track the ids of the details displayed rows
  var detailRows_zayv_main = [];
  $('#chetview-zayv-main tbody').on( 'click', 'tr td.details-control', function () {
      var tr = $(this).closest('tr');
      var row = table_zayv_main.row( tr );
      var idx = $.inArray( tr.attr('id'), detailRows_zayv_main );

      if ( row.child.isShown() ) {
          tr.removeClass( 'details' );
          row.child.hide();

          // Remove from the 'open' array
          detailRows_zayv_main.splice( idx, 1 );
      }
      else {
          tr.addClass( 'details' );
		rowData = table_zayv_main.row( row );
		d = row.data();
		if (d.dognet_doczayv.koddoc == '245375260650765') {
			d.doczayv_obosn = "На нужды АТГС";
		}
		else if (d.dognet_doczayv.koddoc == '245375544141726') {
			d.doczayv_obosn = "На склад";
		}
		else if (d.dognet_doczayv.koddoc == '000000000000000') {
			d.doczayv_obosn = "Без договора";
		}
		else {
			d.doczayv_obosn = "Дог. 3-4/"+d.dognet_docbase.docnumber;
		}
		//
		if (d.dognet_doczayv.tipusezayv == '0') {
			d.doczayv_tipuse = "Заявка сформирована";
		}
		else if (d.dognet_doczayv.tipusezayv == '1') {
			d.doczayv_tipuse = "Выставлены все счета";
		}
		else if (d.dognet_doczayv.tipusezayv == '2') {
			d.doczayv_tipuse = "Заявка закрыта";
		}
		else if (d.dognet_doczayv.tipusezayv == '3') {
			d.doczayv_tipuse = "Заявка аннулирована";
		}
		else if (d.dognet_doczayv.tipusezayv == '4') {
			d.doczayv_tipuse = "Выставлены счета";
		}
		else {
			d.doczayv_tipuse = "";
		}
		rowData.child( <?php include('templates/chetview-details_tab7_zayv_main.tpl'); ?> ).show();

// Add to the 'open' array
        if ( idx === -1 ) {
            detailRows_zayv_main.push( tr.attr('id') );
        }
      }
  } );
// On each draw, loop over the `detailRows` array and show any child rows
	table_zayv_main.on( 'draw', function () {
		sessionID = "<?php echo $_SESSION['uniqueID']; ?>";
		getID = "<?php echo $_GET['uniqueID']; ?>";
		console.log("$_SESSION: "+sessionID);
		console.log("$_GET: "+getID);
		$.each( detailRows_zayv_main, function ( i, id ) {
		$('#'+id+' td.details-control').trigger( 'click' );
	    } );
	} );
// ----- ----- -----
	table_zayv_main.button( 0 ).action( function( e, dt, button, config ) {
	    console.log( 'Button '+this.text()+' activated' );
	    this.disable();
	} );
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Обработчики событий таблицы заявок
	table_zayv_main.on( 'select', function () {
		table_zayv_files.buttons().enable();
    table_zayv_files.ajax.reload(null, true);
		table_zayv_child_chet.buttons().enable();
    table_zayv_child_chet.ajax.reload(null, true);
		table_zayv_child_dop.buttons().enable();
    table_zayv_child_dop.ajax.reload(null, true);
// 		table_zayv_child_dopspec.buttons().enable();
//     table_zayv_child_dopspec.ajax.reload(null, true);
		table_zayv_child_dop_docspec.buttons().enable();
    table_zayv_child_dop_docspec.ajax.reload(null, true);
	} );
	table_zayv_main.on( 'deselect', function () {
		table_zayv_files.rows().deselect();
    table_zayv_files.ajax.reload(null, true);
		table_zayv_child_dop.rows().deselect();
    table_zayv_child_dop.ajax.reload(null, true);
// 		table_zayv_child_dopspec.rows().deselect();
//     table_zayv_child_dopspec.ajax.reload(null, true);
		table_zayv_child_chet.rows().deselect();
    table_zayv_child_chet.ajax.reload(null, true);
		table_chet_child_chetf.rows().deselect();
    table_chet_child_chetf.ajax.reload(null, true);
		table_zayv_child_dop_docspec.rows().deselect();
    table_zayv_child_dop_docspec.ajax.reload(null, true);
	} );
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
} );
</script>
<?php
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/chetview/chetview-details/restr_3/tabs/css/chetview-details-common-tab7_zayv_main.css">
<h3 class="chetview-details-title2 text-right">Заявки к договору</h3>
<div class="demo-html"></div>
<table id="chetview-zayv-main" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
			<th></th>
			<th>Дата</th>
			<th>Тип</th>
			<th>№</th>
			<th>Описание заявки</th>
			<th>Обоснование</th>
		</tr>
	</thead>
</table>
