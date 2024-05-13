<?php
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# Какой то блок...
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
?>
<?php
if (checkDognetMainpageViewBlock(4, 'new_stages') > 0) {
?>
	<script type="text/javascript" language="javascript" class="init">
		var table_gipwork_newdocs;
		// ----- ----- -----
		$(document).ready(function() {
			table_gipwork_newdocs = $('#gipwork-main-newdocs-table').DataTable({
				dom: "tr",
				language: {
					loadingRecords: '&nbsp;',
					processing: '<div class="spinner"></div>'
				},
				ajax: {
					url: "php/examples/simple/main/main/restr_4/tabs/process/gipwork-main-newdocs-process.php",
					type: "POST"
				},
				serverSide: true,
				createdRow: function(row, data, index) {
					if (data.dognet_dockalplan.idobjectready == 1) {
						// 					$(row).css('background-color','rgb(255, 240, 240)');
						$('td', row).eq(8).addClass('highlight_warning');
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
						data: "dognet_docbase.docnumber"
					},
					{
						data: "dognet_dockalplan.numberstage"
					},
					{
						data: "sp_objects.nameobjectshot"
					},
					{
						data: "dognet_docbase.docnameshot"
					},
					{
						data: "dognet_spispol.ispolnameshot"
					},
					{
						data: "dognet_docblankwork.numberblankwork"
					},
					{
						data: "dognet_dockalplan_progress.stagecreated"
					},
					{
						data: "dognet_dockalplan.srokstage_date"
					},
					{
						data: "dognet_dockalplan.summastage"
					},
					{
						data: "dognet_docblankwork.dateblankdoc"
					}
				],
				select: {
					style: 'os',
					selector: 'td:first-child'
				},
				columnDefs: [{
						orderable: false,
						searchable: false,
						targets: 0
					},
					{
						orderable: false,
						searchable: false,
						render: function(data, type, row, meta) {
							return '<a href="/dognet/dognet-docview.php?docview_type=details&uniqueID=' + row.dognet_dockalplan.koddoc + '" class="docview-details-link" title="Перейти к карточке договора">' + data + '</a>';
						},
						targets: 1
					},
					{
						orderable: false,
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
						render: function(data, type, row, meta) {
							str = data;
							if (str.length > 55) {
								return str.substr(0, 55) + " ...";
							} else {
								return str;
							}
						},
						targets: 4
					},
					{
						orderable: false,
						searchable: false,
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
					},
					{
						orderable: false,
						searchable: false,
						render: function(data, type, row, meta) {
							if (row.dognet_dockalplan.idsrokstage == 1) {
								// return moment(data, 'YYYY-MM-DD').format('DD.MM.YYYY');
								return row.dognet_dockalplan.srokstage_date;
							} else {
								return row.dognet_dockalplan.srokstage;
							}
						},
						targets: 8
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
						targets: 9
					},
					{
						orderable: false,
						searchable: false,
						visible: false,
						targets: 10
					}
				],
				orderClasses: false,
				select: false,
				processing: true,
				paging: true,
				pageLength: 10,
				searching: false,
				lengthChange: false,
				order: [
					[7, "desc"],
					[10, "desc"]
				],
				buttons: [],
				initComplete: function() {

				},
				drawCallback: function() {

				}
			});
			// Array to track the ids of the details displayed rows
			var detailRows = [];
			$('#gipwork-main-newdocs-table tbody').on('click', 'tr td.details-control', function() {
				var tr = $(this).closest('tr');
				var row = table_gipwork_newdocs.row(tr);
				var idx = $.inArray(tr.attr('id'), detailRows);
				if (row.child.isShown()) {
					tr.removeClass('details');
					row.child.hide();
					// Remove from the 'open' array
					detailRows.splice(idx, 1);
				} else {
					tr.addClass('details');
					rowData = table_gipwork_newdocs.row(row);
					d = row.data();
					rowData.child(<?php include('templates/gipwork-main-newdocs.tpl'); ?>).show();
					// Add to the 'open' array
					if (idx === -1) {
						detailRows.push(tr.attr('id'));
					}
				}
			});
			// On each draw, loop over the `detailRows` array and show any child rows
			table_gipwork_newdocs.on('draw', function() {
				$.each(detailRows, function(i, id) {
					$('#' + id + ' td.details-control').trigger('click');
				});
			});

		});
	</script>
	<?php
	// ----- ----- ----- ----- -----
	// Подключаем стили для таблицы
	// :::
	?>
	<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/main/main/restr_4/tabs/css/gipwork-main-newdocs.css">
	<section>
		<div id="gipwork-main-newdocs" class="" style="">
			<div class="demo-html"></div>
			<table id="gipwork-main-newdocs-table" class="table table-bordered table-responsive display compact" cellspacing="0" width="100%">
				<thead id="gipwork-main-newdocs-table-header" style="">
					<tr>
						<th><span class='glyphicon glyphicon-option-vertical'></span></th>
						<th>Договор</th>
						<th>Этап</th>
						<th>Объект</th>
						<th>Название договора</th>
						<th>ГИП</th>
						<th>Бланк</th>
						<th>Создан</th>
						<th>Срок</th>
						<th>Сумма</th>
					</tr>
				</thead>
			</table>
		</div>
	</section>
<?php
} else {
?>
	<section>
		<div id="gipwork-main-newdocs" class="">
			<span>Блок временно не выводится</span>
		</div>
	</section>
<?php
}
?>