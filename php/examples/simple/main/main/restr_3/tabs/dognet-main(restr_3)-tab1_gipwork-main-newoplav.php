<?php
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# Какой то блок...
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
?>
<?php
if (checkDognetMainpageViewBlock(3, 'new_oplav')>0) {
?>
<script type="text/javascript" language="javascript" class="init">
var table_gipwork_newoplav;
// ----- ----- -----
$(document).ready(function() {
	table_gipwork_newoplav = $('#gipwork-main-newoplav-table').DataTable( {
// 		dom: "<'row space20'<'col-md-8 col-sm-12'><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'ltip>>",
		dom: "t",
		language: {
			url: "russian.json"
		},
		ajax: {
			url: "php/examples/simple/main/main/restr_3/tabs/process/gipwork-main-newoplav-process.php",
			type: "POST"
		},
		serverSide: true,
		columns: [
			{ data: "dognet_docbase.docnumber" },
			{ data: "dognet_dockalplan.numberstage" },
			{ data: "dognet_chfavans.dateoplav" },
			{ data: "dognet_docavans.dateavans" },
			{ data: "dognet_kalplanchf.chetfnumber" },
			{ data: "dognet_chfavans.summaoplav" }
		],
		select: {
			style: 'os',
			selector: 'td:first-child'
		},
		columnDefs: [
			{ orderable: false, searchable: false, render: function ( data, type, row, meta ) {
				return '<a href="/dognet/dognet-docview.php?docview_type=details&uniqueID='+row.dognet_dockalplan.koddoc+'" class="docview-details-link" title="Перейти к карточке договора">'+data+'</a>';
				},
				targets: 0
			},
			{ orderable: false, searchable: false, targets: 1 },
			{ orderable: false, searchable: false, targets: 2 },
			{ orderable: false, searchable: false, targets: 3 },
			{ orderable: false, searchable: false, targets: 4 },
			{ orderable: false, searchable: false, render: function ( data, type, row, meta ) {
				if (data != null) {
					return $.fn.dataTable.render.number(' ', ',', 2, '').display( data )+row.dognet_spdened.short_code;
				}
				else {
					return "0.00"+row.dognet_spdened.short_code;
				}
				}, targets: 5
			}
		],
		select: false,
		processing: true,
		paging: false,
		searching: false,
		lengthChange: false,
		order: [ [ 2, "desc" ] ],
		buttons: [
		],
		initComplete: function() {

		},
    drawCallback: function() {

    }
	} );
	// Array to track the ids of the details displayed rows
  var detailRows = [];
  $('#gipwork-main-newoplav-table tbody').on( 'click', 'tr td.details-control', function () {
      var tr = $(this).closest('tr');
      var row = table_gipwork_newoplav.row( tr );
      var idx = $.inArray( tr.attr('id'), detailRows );
      if ( row.child.isShown() ) {
          tr.removeClass( 'details' );
          row.child.hide();
          // Remove from the 'open' array
          detailRows.splice( idx, 1 );
      }
      else {
          tr.addClass( 'details' );
		rowData = table_gipwork_newoplav.row( row );
		d = row.data();
		rowData.child( <?php include('templates/dognet-main-gip-stage_srok_deadline.tpl'); ?> ).show();
	// Add to the 'open' array
      if ( idx === -1 ) {
          detailRows.push( tr.attr('id') );
      }
    }
  } );
	// On each draw, loop over the `detailRows` array and show any child rows
	table_gipwork_newoplav.on( 'draw', function () {
		$.each( detailRows, function ( i, id ) {
			$('#'+id+' td.details-control').trigger( 'click' );
    } );
	} );
// ----- ----- -----
} );
</script>
<?php
// ----- ----- ----- ----- -----
// Подключаем стили для таблицы
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/main/main/restr_3/tabs/css/gipwork-main-newoplav.css">
<section>
	<div id="gipwork-main-newoplav" class="">
		<div class="demo-html"></div>
		<table id="gipwork-main-newoplav-table" class="table table-bordered table-responsive display compact" cellspacing="0" width="100%">
			<thead style="">
				<tr>
					<th>Договор</th>
					<th>Этап</th>
					<th>Зачет от</th>
					<th>Аванс от</th>
					<th>Счет-фактура</th>
					<th>Сумма</th>
				</tr>
			</thead>
		</table>
	</div>
</section>
<?php
}
else {
?>
<section>
	<div id="gipwork-main-newoplav" class="">
		<span>Блок временно не выводится</span>
	</div>
</section>
<?php
}
?>