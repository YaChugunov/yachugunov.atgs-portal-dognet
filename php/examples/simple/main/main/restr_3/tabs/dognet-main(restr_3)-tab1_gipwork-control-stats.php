<?php
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# Какой то блок...
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
?>
<?php
if (checkIsItGIP($_SESSION['id'])==1) {
?>
<script type="text/javascript" language="javascript" class="init">
var table_tab1_kalplans;
// ----- ----- -----
$(document).ready(function() {
	table_tab1_kalplans = $('#gipwork-control-stages_all').DataTable( {
		dom: "<'row'<'col-sm-5'><'col-sm-4'><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-2'f><'col-sm-4'i><'col-sm-6'p>>",
		language: {
			url: "russian.json"
		},
		ajax: {
			url: "php/examples/simple/main/main/restr_3/tabs/process/gipwork-control-stages_all-process.php",
			type: "POST"
		},
		serverSide: true,
		columns: [
            {
				class: "details-control",
				searchable: false,
				orderable: false,
				data: null,
				defaultContent: "<span class='glyphicon glyphicon-option-vertical'></span>"
            },
			{ data: "dognet_docbase.docnumber" },
			{ data: "dognet_dockalplan.numberstage" },
			{ data: "dognet_dockalplan.nameshotstage" },
			{ data: "dognet_dockalplan.srokstage_date" },
			{ data: "dognet_dockalplan.summastage" }
		],
		select: {
			style: 'os',
			selector: 'td:first-child'
		},
		columnDefs: [
			{ orderable: false, searchable: false, targets: 0 },
			{ orderable: false, searchable: true, targets: 1 },
			{ orderable: false, searchable: true, targets: 2 },
			{ orderable: false, searchable: false,
				render: function (  data, type, row, meta ) {
					return row.dognet_docbase.docnameshot+" / "+data;
				},
				targets: 3
			},
			{
				orderable: false,
				searchable: false,
				render: function (  data, type, row, meta ) {
					if (row.dognet_dockalplan.idsrokstage == 1) {
						// return moment(data, 'YYYY-MM-DD').format('DD.MM.YYYY');
						return row.dognet_dockalplan.srokstage_date;
					}
					else {
						return row.dognet_dockalplan.srokstage;
					}
				},
				targets: 4
			},
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
		paging: true,
		searching: true,
		lengthChange: false,
		order: [ [ 1, "asc" ] ],
		buttons: [
		],
		initComplete: function() {

		},
    drawCallback: function () {

    }
	} );
	// Array to track the ids of the details displayed rows
  var detailRows_stages_all = [];
  $('#gipwork-control-stages_all tbody').on( 'click', 'tr td.details-control', function () {
      var tr = $(this).closest('tr');
      var row = table_tab1_kalplans.row( tr );
      var idx = $.inArray( tr.attr('id'), detailRows_stages_all );
      if ( row.child.isShown() ) {
          tr.removeClass( 'details' );
          row.child.hide();
          // Remove from the 'open' array
          detailRows_stages_all.splice( idx, 1 );
      }
      else {
          tr.addClass( 'details' );
		rowData = table_tab1_kalplans.row( row );
		d = row.data();
		rowData.child( <?php include('templates/gipwork-control-stages_all.tpl'); ?> ).show();
	// Add to the 'open' array
      if ( idx === -1 ) {
          detailRows_stages_all.push( tr.attr('id') );
      }
    }
  } );
	// On each draw, loop over the `detailRows_stages_all` array and show any child rows
	table_tab1_kalplans.on( 'draw', function () {
		$.each( detailRows_stages_all, function ( i, id ) {
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
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/main/main/restr_3/tabs/css/gipwork-control-stages_all.css">
<section>
	<div id="tab1_kalplans" class="">
		<h3 class="docview-details-title2 space10">Все договора</h3>
		<div class="demo-html"></div>
		<table id="gipwork-control-stages_all" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th><span class='glyphicon glyphicon-option-vertical'></span></th>
					<th>Договор</th>
					<th>Этап</th>
					<th>Наименование</th>
					<th>Срок выполнения</th>
					<th>Сумма</th>
				</tr>
			</thead>
		</table>
	</div>
</section>
<?php
}
?>
