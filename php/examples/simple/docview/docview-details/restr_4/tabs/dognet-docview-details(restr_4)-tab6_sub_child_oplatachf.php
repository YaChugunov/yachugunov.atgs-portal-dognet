
<script type="text/javascript" language="javascript" class="init">

$(document).ready(function() {
//
//
//
// СЧЕТ
//
// ----- ----- -----
// Обработчик таблицы счетов
table_sub_child_oplatachf = $('#docview-sub-child-oplatachf').DataTable( {
		dom: "<'row'<'col-md-8 col-sm-12'><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'>>",
		language: {
			url: "php/examples/simple/docview/docview-details/dt_russian-tab6_sub_child_oplatachf.json"
		},
		ajax: {
			url: "php/examples/php/docview/docview-details/dognet-docview-details-tab6_sub_child_oplatachf-process.php",
			type: 'post',
      data: function ( d ) {
          var selected2 = table_sub_main.row( { selected: true } );
          if ( selected2.any() ) {
                d.koddocsubpodr2 = selected2.data().dognet_docsubpodr.koddocsubpodr;
          }
          else {
			          d.koddocsubpodr2 = '';
          }
          var selected = table_sub_child_chetf.row( { selected: true } );
          if ( selected.any() ) {
                d.kodchfsubpodr_oplchf = selected.data().dognet_docchfsubpodr.kodchfsubpodr;
          }
          else {
			          d.kodchfsubpodr_oplchf = '';
          }
      }
		},
		serverSide: true,
    select: {
        style: 'single'
    },
		createdRow: function ( row, data, index ) {
          var selectedChf = table_sub_child_chetf.row( { selected: true } );

          if ( selectedChf.any() ) { data.kodchfsubpodr = selectedChf.data().dognet_docchfsubpodr.kodchfsubpodr; }
          else { data.kodchfsubpodr = ''; }

					if ( (data.dognet_docoplchfsubpodr.kodchfsubpodr === data.dognet_docchfsubpodr.kodchfsubpodr) &&
					(data.dognet_docoplchfsubpodr.kodchfsubpodr === data.kodchfsubpodr) ) {
/* 								$(row).css({ 'color':'#FFF'	}); */
					}

					if ( data.dognet_docoplchfsubpodr.kodchfsubpodr === "" ) {
						$(row).css({ 'font-style':'italic', 'color':'#AAA'	});
					}
		},
		columns: [
			{ data: "dognet_docoplchfsubpodr.kodchfsubpodr", className: "" },
			{ data: "dognet_docoplchfsubpodr.kodoplchfsubpodr", className: "" },
			{ data: "dognet_docoplchfsubpodr.dateoplchfsubpodr", className: "" },
			{ data: null },
			{ data: "dognet_docoplchfsubpodr.sumoplchfsubpodr", className: "" }
		],
		columnDefs: [
			{ orderable: false, searchable: false,
				render: function ( data ) {
          var selectedChf = table_sub_child_chetf.row( { selected: true } );
          if ( selectedChf.any() ) { val1 = selectedChf.data().dognet_docchfsubpodr.kodchfsubpodr; }
          else { val1 = ''; }
					if ((data === val1) && val1 != "") { return '<span class="glyphicon glyphicon-link"></span>'; }
					else { return ''; }
				},
				targets: 0
			},
			{ orderable: false, searchable: false, targets: 1 },
			{
				orderable: true,
				searchable: false,
				type: "date",
				targets: 2
			},
			{ orderable: false, searchable: false, render: function () { return ''; }, targets: 3 },
			{ orderable: false, searchable: false, render: function ( data, type, row, meta ) {
				if (data != null) {
					if (row.dognet_spdened.short_code != null) {
						return $.fn.dataTable.render.number(' ', ',', 2, '').display( data )+row.dognet_spdened.short_code;
					}
					else {
						return $.fn.dataTable.render.number(' ', ',', 2, '').display( data )+" руб.";
					}
				}
				else {
					if (row.dognet_spdened.short_code != null) {
						return "0.00"+row.dognet_spdened.short_code;
					}
					else {
						return "0.00 руб.";
					}
				}
				},
				targets: 4
			},
		],
		order: [ [2, "desc"] ],
		buttons: [
		]
	} );
} );
</script>
<?php
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-details/restr_4/tabs/css/docview-details-common-tab6_sub_child_oplatachf.css">
<h3 class="docview-details-title2 text-right">Оплаты по выставленным счетам-фактурам</h3>
<div class="demo-html"></div>
<table id="docview-sub-child-oplatachf" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th></th>
			<th>ID оплаты</th>
			<th>Дата</th>
			<th></th>
			<th>Сумма</th>
		</tr>
	</thead>
</table>
