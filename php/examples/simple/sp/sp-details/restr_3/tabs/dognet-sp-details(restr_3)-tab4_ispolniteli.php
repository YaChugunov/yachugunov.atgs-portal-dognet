
<script type="text/javascript" language="javascript" class="init">

var table_tab4_ispolniteli;
var editor_tab4_ispolniteli;

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
//
$(document).ready(function() {
//
	table_tab4_ispolniteli = $('#sp-tab4_ispolniteli-table').DataTable( {
		dom: "<'row'<'col-sm-6'B><'col-sm-3'><'col-sm-3'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'p>>",
		language: {
			url: "php/examples/simple/sp/sp-details/dt_russian-sp-ispolniteli.json"
		},
		ajax: {
			url: "php/examples/php/sp/sp-details/dognet-sp-details-tab4_ispolniteli-process.php",
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
			{ data: "ispolnameshot", defaultContent: "" },
			{ data: "ispolnamefull", defaultContent: "" },
			{ data: "ispolmanager" },
			{ data: "ispolmail" },
			{ data: "kodusedoc" },
			{ data: "kodusezayv" },
			{ data: "kodusegip" },
			{ data: "kodusegipfar" }
		],
		columnDefs: [
			{ orderable: false, searchable: false, targets: 0 },
			{ orderable: false, searchable: true, targets: 1 },
			{ orderable: false, searchable: true, targets: 2 },
			{ orderable: false, targets: 3 },
			{ orderable: false, targets: 4 },
			{ orderable: false,
				render: function( data, type, row, meta ) {
					return (data == 1) ? "X" : "";
				},
				targets: 5
			},
			{ orderable: false,
				render: function( data, type, row, meta ) {
					return (data == 1) ? "X" : "";
				},
				targets: 6
			},
			{ orderable: false,
				render: function( data, type, row, meta ) {
					return (data == 1) ? "X" : "";
				},
				targets: 7
			},
			{ orderable: false,
				render: function( data, type, row, meta ) {
					return (data == 1) ? "X" : "";
				},
				targets: 8
			}
		],
		order: [ [ 1, "asc" ] ],
		select: false,
		processing: true,
		paging: true,
		searching: true,
		pageLength: 15,
		lengthChange: false,
		lengthMenu: [ [15, 30, 50, -1], [15, 30, 50, "Все"] ],
		buttons: [
			{ text:	'<span class="glyphicon glyphicon-refresh"></span>', action:
				function ( e, dt, node, config ) {
					table_tab4_ispolniteli.columns().search('');
					table_tab4_ispolniteli.order([1,"asc"]).draw();
				}
			}
		]
	} );
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    var detailRows_tab4_ispolniteli = [];
    $('#sp-tab4_ispolniteli-table tbody').on( 'click', 'tr td.details-control', function () {
      var tr = $(this).closest('tr');
      var row = table_tab4_ispolniteli.row( tr );
      var idx = $.inArray( tr.attr('id'), detailRows_tab4_ispolniteli );
      if ( row.child.isShown() ) {
	      tr.removeClass( 'details' );
	      row.child.hide();
	      detailRows_tab4_ispolniteli.splice( idx, 1 );
      }
      else {
        tr.addClass( 'details' );
				rowData = table_tab4_ispolniteli.row( row );
				d = row.data();
				rowData.child( <?php include('templates/sp-details_tab4_ispolniteli.tpl'); ?> ).show();
	      if ( idx === -1 ) {
					detailRows_tab4_ispolniteli.push( tr.attr('id') );
	      }
			}
    } );
//
		table_tab4_ispolniteli.on( 'draw', function () {
			$.each( detailRows_tab4_ispolniteli, function ( i, id ) {
				$('#'+id+' td.details-control').trigger( 'click' );
		  } );
		} );
} );
</script>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/sp/sp-details/restr_3/tabs/css/sp-details-tab4_ispolniteli-main.css">
<section>
	<div id="sp-tab4_ispolniteli" class="">
		<div id="tab4_ispolniteli" class="">
			<div class="demo-html"></div>
			<table id="sp-tab4_ispolniteli-table" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th><span class='glyphicon glyphicon-option-vertical'></span></th>
						<th>Краткое имя</th>
						<th>Полное имя</th>
						<th>Исполнитель</th>
						<th>Email</th>
						<th>ДОГ</th>
						<th>ЗВК</th>
						<th>ГИП1</th>
						<th>ГИП2</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</section>
