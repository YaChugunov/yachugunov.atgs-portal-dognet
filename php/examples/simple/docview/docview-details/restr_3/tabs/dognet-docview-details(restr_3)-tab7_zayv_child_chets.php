<script type="text/javascript" language="javascript" class="init">
	var table_zayv_child_chet;
	var table_chet_child_chetf;

	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

	$(document).ready(function() {
		//
		//
		//
		// СЧЕТ
		//
		// ----- ----- -----
		// Обработчик таблицы счетов
		table_zayv_child_chet = $('#docview-zayv-child-chet').DataTable({
			dom: "<'row'<'col-sm-5'><'col-sm-4'><'col-sm-3'<'test_msg'>>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-1'B><'col-sm-5'i><'col-sm-6'p>>",
			language: {
				url: "php/examples/simple/docview/docview-details/dt_russian-tab7_zayv_child_chet.json"
			},
			ajax: {
				url: "php/examples/php/docview/docview-details/dognet-docview-details-tab7_zayv_child_chet-process.php",
				type: "POST",
				data: function(d) {
					var selected = table_zayv_main.row({
						selected: true
					});
					if (selected.any()) {
						d.kodzayv = selected.data().dognet_doczayv.kodzayv;
					}
				}
			},
			serverSide: true,
			createdRow: function(row, data, index) {
				if (data.dognet_doczayvchet.zayvchetpr < 100.00 || data.dognet_doczayvchet.zayvchetzadol > 0.00) {
					$('td', row).eq(6).addClass('highlight_warning');
					$('td', row).eq(7).addClass('highlight_warning');
				}
				if (data.dognet_doczayvchet.zayvchetpr > 100.00 || data.dognet_doczayvchet.zayvchetzadol < 0.00) {
					$('td', row).eq(6).addClass('highlight_alarm');
					$('td', row).eq(7).addClass('highlight_alarm');
				}
			},
			columns: [{
					class: "details-control",
					searchable: false,
					orderable: false,
					data: null,
					defaultContent: "<span class='glyphicon glyphicon-option-vertical'></span>"
				},
				{
					data: "dognet_doczayvchet.zayvchetdate"
				},
				{
					data: "dognet_doczayvchet.zayvchetnumber"
				},
				{
					data: "dognet_doczayv.numberzayv"
				},
				{
					data: "sp_contragents.nameshort"
				},
				{
					data: "dognet_doczayvchet.zayvchetsumma"
				},
				{
					data: "dognet_doczayvchet.zayvchetpr"
				},
				{
					data: "dognet_doczayvchet.zayvchetzadol"
				},
				{
					data: "dognet_doczayvchet.docFileID",
					render: function(data, type, row, meta) {
						return data ? '<a class="" target="_blank" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet' + row.dognet_doczayvchet_files.file_webpath + '"><span class="glyphicon glyphicon-file"></span></a>' : '<span class="glyphicon glyphicon-option-horizontal"></span>';
					},
					defaultContent: "",
					className: "text-center"
				}
			],
			select: 'single',
			columnDefs: [{
					orderable: false,
					searchable: false,
					targets: 0
				},
				{
					orderable: true,
					searchable: false,
					targets: 1
				},
				{
					orderable: false,
					searchable: true,
					targets: 2
				},
				{
					orderable: false,
					searchable: true,
					render: function(data, type, row, meta) {
						return row.dognet_sptipzayvall.nametipzayvshotall + "-" + data;
					},
					targets: 3
				},
				{
					orderable: false,
					searchable: true,
					targets: 4
				},
				{
					orderable: false,
					searchable: false,
					render: function(data, type, row, meta) {
						if (data != null) {
							if (row.dognet_spdened.short_code != null) {
								return $.fn.dataTable.render.number(' ', ',', 2, '').display(data) + row.dognet_spdened.short_code;
							} else {
								return $.fn.dataTable.render.number(' ', ',', 2, '').display(data) + " р.";
							}
						} else {
							if (row.dognet_spdened.short_code != null) {
								return "0.00" + row.dognet_spdened.short_code;
							} else {
								return "0.00 р.";
							}
						}
					},
					targets: 5
				},
				{
					orderable: false,
					searchable: true,
					render: function(data, type, row, meta) {
						return Math.round(data);
					},
					targets: 6
				},
				{
					orderable: false,
					searchable: false,
					render: function(data, type, row, meta) {
						if (data != null) {
							if (row.dognet_spdened.short_code != null) {
								return $.fn.dataTable.render.number(' ', ',', 2, '').display(data) + row.dognet_spdened.short_code;
							} else {
								return $.fn.dataTable.render.number(' ', ',', 2, '').display(data) + " р.";
							}
						} else {
							if (row.dognet_spdened.short_code != null) {
								return "0.00" + row.dognet_spdened.short_code;
							} else {
								return "0.00 р.";
							}
						}
					},
					targets: 7
				},
				{
					orderable: false,
					searchable: false,
					targets: 8
				}
			],
			order: [
				[1, "desc"]
			],
			ordering: true,
			paging: true,
			searching: true,
			pageLength: 15,
			lengthChange: false,
			lengthMenu: [
				[15, 30, 50, -1],
				[15, 30, 50, "Все"]
			],
			buttons: [{
				text: '<span class="glyphicon glyphicon-refresh"></span>',
				action: function(e, dt, node, config) {
					table_zayv_child_chet.ajax.reload();
					table_zayv_child_chet.columns().search('').draw();
				}
			}],
			drawCallback: function() {

			}
		});
		// ----- ----- -----
		// Обработчик child-таблицы выбранного счета
		// Array to track the ids of the details displayed rows
		var detailRows_zayv_child_chet = [];
		$('#docview-zayv-child-chet tbody').on('click', 'tr td.details-control', function() {
			var tr = $(this).closest('tr');
			var row = table_zayv_child_chet.row(tr);
			var idx = $.inArray(tr.attr('id'), detailRows_zayv_child_chet);

			if (row.child.isShown()) {
				tr.removeClass('details');
				row.child.hide();

				// Remove from the 'open' array
				detailRows_zayv_child_chet.splice(idx, 1);
			} else {
				tr.addClass('details');
				rowData = table_zayv_child_chet.row(row);
				d = row.data();
				rowData.child(<?php include('templates/docview-details_tab7_zayv_child_chet.tpl'); ?>).show();

				// Add to the 'open' array
				if (idx === -1) {
					detailRows_zayv_child_chet.push(tr.attr('id'));
				}
			}
		});
		// On each draw, loop over the `detailRows` array and show any child rows
		table_zayv_child_chet.on('draw', function() {
			$.each(detailRows_zayv_child_chet, function(i, id) {
				$('#' + id + ' td.details-control').trigger('click');
			});
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		//
		//
		// СЧЕТ-ФАКТУРА
		//
		// ----- ----- -----
		// Обработчик таблицы счетов-фактур
		table_chet_child_chetf = $('#docview-chet-child-chetf').DataTable({
			dom: "<'row'<'col-sm-5'><'col-sm-4'><'col-sm-3'<'test_msg'>>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-1'B><'col-sm-5'i><'col-sm-6'p>>",
			language: {
				url: "php/examples/simple/docview/docview-details/dt_russian-tab7_zayv_child_chetf.json"
			},
			ajax: {
				url: "php/examples/php/docview/docview-details/dognet-docview-details-tab7_zayv_child_chetf-process.php",
				type: 'post',
				data: function(d) {
					var selected = table_zayv_child_chet.row({
						selected: true
					});
					if (selected.any()) {
						d.kodzayvchet = selected.data().dognet_doczayvchet.kodzayvchet;
						d.kodzayv = selected.data().dognet_doczayvchet.kodzayv;
					}
				}
			},
			serverSide: true,
			select: {
				style: 'single'
			},
			select: false,
			createdRow: function(row, data, index) {

			},
			rowCallback: function(row, data) {

			},
			columns: [{
					class: "details-control",
					searchable: false,
					orderable: false,
					data: null,
					defaultContent: "<span class='glyphicon glyphicon-option-vertical'></span>"
				},
				{
					data: "dognet_doczayvchetf.zayvchetfdate",
					className: ""
				},
				{
					data: "dognet_doczayvchetf.zayvchetfnumber",
					className: ""
				},
				{
					data: "dognet_doczayvchet.zayvchetnumber",
					className: ""
				},
				{
					data: "dognet_doczayvchetf.zayvchetfcomment",
					className: ""
				},
				{
					data: "dognet_doczayvchetf.zayvchetfsumma",
					className: ""
				},
				{
					data: "dognet_doczayvchetf.namevaliduse",
					className: ""
				},
				{
					data: "dognet_doczayvchetf.docFileID",
					render: function(data, type, row, meta) {
						return data ? '<a class="" target="_blank" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet' + row.dognet_doczayvchetf_files.file_webpath + '"><span class="glyphicon glyphicon-file"></span></a>' : '<span class="glyphicon glyphicon-option-horizontal"></span>';
					},
					defaultContent: "",
					className: "text-center"
				}
			],
			columnDefs: [{
					orderable: false,
					searchable: false,
					targets: 0
				},
				{
					orderable: true,
					searchable: false,
					type: "date",
					targets: 1
				},
				{
					orderable: true,
					searchable: false,
					targets: 2
				},
				{
					orderable: false,
					searchable: false,
					targets: 3
				},
				{
					orderable: false,
					searchable: false,
					targets: 4
				},
				{
					orderable: false,
					searchable: false,
					render: function(data, type, row, meta) {
						if (data != null) {
							return $.fn.dataTable.render.number(' ', ',', 2, '').display(data) + row.dognet_spdened.short_code;
						} else {
							return "0.00" + row.dognet_spdened.short_code;
						}
					},
					targets: 5
				},
				{
					orderable: false,
					searchable: false,
					targets: 6
				},
				{
					orderable: false,
					searchable: false,
					targets: 7
				}
			],
			order: [
				[1, "desc"],
				[2, "asc"]
			],
			buttons: [{
				text: '<span class="glyphicon glyphicon-refresh"></span>',
				action: function(e, dt, node, config) {
					table_chet_child_chetf.ajax.reload();
					table_chet_child_chetf.columns().search('').draw();
				}
			}]
		});
		// ----- ----- -----
		// Обработчик child-таблицы выбранного счета
		// Array to track the ids of the details displayed rows
		var detailRows_chet_child_chetf = [];
		$('#docview-chet-child-chetf tbody').on('click', 'tr td.details-control', function() {
			var tr = $(this).closest('tr');
			var row = table_chet_child_chetf.row(tr);
			var idx = $.inArray(tr.attr('id'), detailRows_chet_child_chetf);

			if (row.child.isShown()) {
				tr.removeClass('details');
				row.child.hide();

				// Remove from the 'open' array
				detailRows_chet_child_chetf.splice(idx, 1);
			} else {
				tr.addClass('details');
				rowData = table_chet_child_chetf.row(row);
				d = row.data();
				rowData.child(<?php include('templates/docview-details_tab7_zayv_child_chetf.tpl'); ?>).show();

				// Add to the 'open' array
				if (idx === -1) {
					detailRows_chet_child_chetf.push(tr.attr('id'));
				}
			}
		});
		// On each draw, loop over the `detailRows` array and show any child rows
		table_chet_child_chetf.on('draw', function() {
			$.each(detailRows_chet_child_chetf, function(i, id) {
				$('#' + id + ' td.details-control').trigger('click');
			});
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		// Обработчики событий таблицы счетов
		table_zayv_child_chet.on('select', function() {
			table_chet_child_chetf.buttons().enable();
			table_chet_child_chetf.ajax.reload(null, false);
		});
		table_zayv_child_chet.on('deselect', function() {
			table_chet_child_chetf.buttons().disable();
			table_chet_child_chetf.row({
				selected: true
			}).deselect();
			table_chet_child_chetf.ajax.reload(null, false);
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	});
</script>
<?php
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-details/restr_3/tabs/css/docview-details-common-tab7_zayv_child_chet.css">
<h3 class="docview-details-title2 text-right">Счета</h3>
<div class="demo-html"></div>
<table id="docview-zayv-child-chet" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
			<th>Дата</th>
			<th>Счет №</th>
			<th>Заявка</th>
			<th>Поставщик</th>
			<th>Сумма</th>
			<th>%</th>
			<th>Задолж</th>
			<th><span class="glyphicon glyphicon-file"></span></th>
		</tr>
	</thead>
</table>
<?php // ----- ----- ----- ----- ----- 
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-details/restr_3/tabs/css/docview-details-common-tab7_zayv_child_chetf.css">
<div class="space30"></div>
<h3 class="docview-details-title2 text-right">Счета-фактуры</h3>
<div class="demo-html"></div>
<table id="docview-chet-child-chetf" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
			<th>Дата</th>
			<th>Счет-фактура</th>
			<th>Счет</th>
			<th>Примечание</th>
			<th>Сумма</th>
			<th>Статус</th>
			<th><span class="glyphicon glyphicon-file"></span></th>
		</tr>
	</thead>
</table>