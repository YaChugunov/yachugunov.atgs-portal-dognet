
<script type="text/javascript" language="javascript" class="init">

var table_tab5_ispolniteliruk;

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
//
$(document).ready(function() {
//
	table_tab5_ispolniteliruk = $('#sp-tab5_ispolniteliruk-table').DataTable( {
		dom: "<'row'<'col-sm-6'B><'col-sm-3'><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'>>",
// 		dom: "<'space50'r>lftip",
		language: {
			url: "php/examples/simple/sp/sp-details/dt_russian-sp-ispolniteliruk.json"
		},
		ajax: {
			url: "php/examples/php/sp/sp-details/dognet-sp-details-tab5_ispolniteliruk-process.php",
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
			{ data: "ispolrukname", defaultContent: "" },
			{ data: "ispolruknamefull", defaultContent: "" },
			{ data: "ispolrukjob" },
			{ data: "ispolrukemail" },
			{ data: "ispolruktel" },
			{ data: "kodrukgip" }
		],
		columnDefs: [
			{ orderable: false, targets: 0 },
			{ orderable: false, searchable: true, targets: 1 },
			{ orderable: false, searchable: true, targets: 2 },
			{ orderable: false, searchable: true, targets: 3 },
			{ orderable: false, searchable: false, targets: 4 },
			{ orderable: false, searchable: false, targets: 5 },
			{ orderable: false,
				render: function( data, type, row, meta ) {
					return (data == 1) ? "X" : "";
				},
				targets: 6
			}
		],
		order: [ [ 1, "asc" ] ],
		select: true,
		processing: true,
		paging: true,
		searching: true,
		pageLength: 15,
		lengthChange: false,
		lengthMenu: [ [15, 30, 50, -1], [15, 30, 50, "Все"] ],
		buttons: [
			{ text:	'<span class="glyphicon glyphicon-refresh"></span>', action:
				function ( e, dt, node, config ) {
					table_tab5_ispolniteliruk.columns().search('');
					table_tab5_ispolniteliruk.order([1,"asc"]).draw();
				}
			}
		]
	} );
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    var detailRows_tab5_ispolniteliruk = [];
    $('#sp-tab5_ispolniteliruk-table tbody').on( 'click', 'tr td.details-control', function () {
      var tr = $(this).closest('tr');
      var row = table_tab5_ispolniteliruk.row( tr );
      var idx = $.inArray( tr.attr('id'), detailRows_tab5_ispolniteliruk );
      if ( row.child.isShown() ) {
	      tr.removeClass( 'details' );
	      row.child.hide();
	      detailRows_tab5_ispolniteliruk.splice( idx, 1 );
      }
      else {
        tr.addClass( 'details' );
				rowData = table_tab5_ispolniteliruk.row( row );
				d = row.data();
				rowData.child( <?php include('templates/sp-details_tab5_ispolniteliruk.tpl'); ?> ).show();
	      if ( idx === -1 ) {
					detailRows_tab5_ispolniteliruk.push( tr.attr('id') );
	      }
			}
    } );
//
		table_tab5_ispolniteliruk.on( 'draw', function () {
			$.each( detailRows_tab5_ispolniteliruk, function ( i, id ) {
			$('#'+id+' td.details-control').trigger( 'click' );
	  } );
	} );
} );
</script>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/sp/sp-details/restr_3/tabs/css/sp-details-tab5_ispolniteliruk-main.css">
<section>
	<div id="sp-tab5_ispolniteliruk" class="">
		<div id="tab5_ispolniteliruk" class="">
			<div class="demo-html"></div>
			<table id="sp-tab5_ispolniteliruk-table" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th><span class='glyphicon glyphicon-option-vertical'></span></th>
						<th>Краткое имя</th>
						<th>Полное имя</th>
						<th>Исполнитель</th>
						<th>Email</th>
						<th>Телефон</th>
						<th>ГИП</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</section>
