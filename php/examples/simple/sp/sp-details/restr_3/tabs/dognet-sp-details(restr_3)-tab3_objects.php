
<script type="text/javascript" language="javascript" class="init">

var table_tab3_object;

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
//
$(document).ready(function() {
//
	table_tab3_object = $('#sp-tab3_object-table').DataTable( {
		dom: "<'row'<'col-sm-6'B><'col-sm-3'><'col-sm-3'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'p>>",
		language: {
			url: "php/examples/simple/sp/sp-details/dt_russian-sp-object.json"
		},
		ajax: {
			url: "php/examples/php/sp/sp-details/dognet-sp-details-tab3_object-process.php",
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
			{ data: "nameobjectshot" },
			{ data: "nameobjectlong" },
			{ data: "kodusegip" }
		],
		columnDefs: [
			{ orderable: false, targets: 0 },
			{ orderable: false, searchable: true, targets: 1 },
			{ orderable: false, searchable: true, targets: 2 },
			{ orderable: false,
				render: function( data, type, row, meta ) {
					return (data == 1) ? "X" : "";
				},
				targets: 3
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
					table_tab3_object.columns().search('');
					table_tab3_object.order([1,"asc"]).draw();
				}
			}
		]
	} );
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    var detailRows_tab3_object = [];
    $('#sp-tab3_object-table tbody').on( 'click', 'tr td.details-control', function () {
      var tr = $(this).closest('tr');
      var row = table_tab3_object.row( tr );
      var idx = $.inArray( tr.attr('id'), detailRows_tab3_object );
      if ( row.child.isShown() ) {
	      tr.removeClass( 'details' );
	      row.child.hide();
	      detailRows_tab3_object.splice( idx, 1 );
      }
      else {
        tr.addClass( 'details' );
				rowData = table_tab3_object.row( row );
				d = row.data();
				rowData.child( <?php include('templates/sp-details_tab3_object.tpl'); ?> ).show();
	      if ( idx === -1 ) {
					detailRows_tab3_object.push( tr.attr('id') );
	      }
			}
    } );
//
		table_tab3_object.on( 'draw', function () {
			$.each( detailRows_tab3_object, function ( i, id ) {
			$('#'+id+' td.details-control').trigger( 'click' );
	  } );
	} );
} );
</script>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/sp/sp-details/restr_3/tabs/css/sp-details-tab3_object-main.css">
<section>
	<div id="sp-tab3_object" class="">
		<div id="tab3_object" class="">
			<div class="demo-html"></div>
			<table id="sp-tab3_object-table" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th><span class='glyphicon glyphicon-option-vertical'></span></th>
						<th>Краткое название</th>
						<th>Полное название</th>
						<th>ГИП</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</section>
