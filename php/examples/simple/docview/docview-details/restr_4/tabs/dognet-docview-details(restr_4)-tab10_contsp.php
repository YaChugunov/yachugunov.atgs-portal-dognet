
<script type="text/javascript" language="javascript" class="init">

var table_tab10_contsp;

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

$(document).ready(function() {

	table_tab10_contsp = $('#docview-details-tab10_contsp').DataTable( {
		dom: "<'row'<'col-sm-5'><'col-sm-4'><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'><'col-sm-8'>>",
		language: {
			url: "php/examples/simple/docview/docview-details/dt_russian-tab10_contacts.json"
		},
		ajax: {
			url: "php/examples/simple/docview/docview-details/restr_4/tabs/process/dognet-docview-details-tab10_contsp-process.php",
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
			{ data: "dognet_spcontact.namecontactshot" },
			{ data: "dognet_spcontact.doljcontact" },
			{ data: "dognet_spcontact.emailcontact" },
			{ data: "dognet_spcontact.telcontact1" },
			{ data: "dognet_spcontact.telcontactmobi" }
		],
		columnDefs: [
			{ orderable: false, searchable: false, targets: 0 },
			{ orderable: false, searchable: true,
				render: function( data, type, row, meta ) {
					last = (row.dognet_spcontact.namecontactend!='') ? row.dognet_spcontact.namecontactend : '';
					first = (row.dognet_spcontact.namecontactfist!='') ? row.dognet_spcontact.namecontactfist : '';
					mid = (row.dognet_spcontact.namecontactsecond!='') ? row.dognet_spcontact.namecontactsecond : '';
					return last+'&nbsp;'+first+'&nbsp;'+mid;
				},
				targets: 1
			},
			{ orderable: false, searchable: true, targets: 2 },
			{ orderable: false, searchable: true, targets: 3 },
			{ orderable: false, searchable: true, targets: 4 },
			{ orderable: false, searchable: true, targets: 5 }
		],
		order: [ [ 1, "asc" ] ],
		select: true,
		processing: true,
		paging: true,
		searching: true,
		pageLength: 15,
		lengthChange: false,
		lengthMenu: [ [15, 30, 50, -1], [15, 30, 50, "Все"] ],
		buttons: [ ]
	} );
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    var detailRows_tab10_contsp = [];
    $('#docview-details-tab10_contsp tbody').on( 'click', 'tr td.details-control', function () {
      var tr = $(this).closest('tr');
      var row = table_tab10_contsp.row( tr );
      var idx = $.inArray( tr.attr('id'), detailRows_tab10_contsp );
      if ( row.child.isShown() ) {
	      tr.removeClass( 'details' );
	      row.child.hide();
	      detailRows_tab10_contsp.splice( idx, 1 );
      }
      else {
        tr.addClass( 'details' );
				rowData = table_tab10_contsp.row( row );
				d = row.data();
				rowData.child( <?php include('templates/docview-details_tab10_contsp.tpl'); ?> ).show();
	      if ( idx === -1 ) {
					detailRows_tab10_contsp.push( tr.attr('id') );
	      }
			}
    } );
//
		table_tab10_contsp.on( 'draw', function () {
			$.each( detailRows_tab10_contsp, function ( i, id ) {
			$('#'+id+' td.details-control').trigger( 'click' );
	  } );
	} );
} );
</script>
<?php
// ----- ----- ----- ----- -----
// Подключаем стили для таблицы
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-details/restr_4/tabs/css/docview-details-common-tab10_contsp.css">
<section>
	<div id="docview-tab10_contsp">
		<h3 class="docview-details-title2">Контакты из справочника Контактов</h3>
		<div class="demo-html"></div>
		<table id="docview-details-tab10_contsp" class="table table-bordered display compact" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th><span class='glyphicon glyphicon-option-vertical'></span></th>
					<th>ФИО</th>
					<th>Должность</th>
					<th>Email</th>
					<th>Телефон 1</th>
					<th>Мобильный</th>
				</tr>
			</thead>
		</table>
	</div>
</section>

