<?php
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# Какой то блок...
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
?>
<?php
if (checkIsItGIP($_SESSION['id']) == 1) {
	if (checkDognetMainpageViewBlock(3, 'control_debtors') > 0) {
?>
		<script type="text/javascript" language="javascript" class="init">
			var table_gipwork_control_stages_debtors;
			// ----- ----- -----
			$(document).ready(function() {
				table_gipwork_control_stages_debtors = $('#gipwork-control-stages_debtors').DataTable({
					dom: "<'row'<'col-sm-5'><'col-sm-4'><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'p>>",
					language: {
						url: "russian.json"
					},
					ajax: {
						url: "php/examples/simple/main/main/restr_3/tabs/process/gipwork-control-stages_debtors-process.php",
						type: "POST"
					},
					serverSide: true,
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
							data: "sp_contragents.nameshort"
						},
						{
							data: "sp_objects.nameobjectshot"
						},
						{
							data: "dognet_dockalplan_progress.sumchfstage"
						},
						{
							data: "dognet_dockalplan_progress.sumoplchfstage"
						},
						{
							data: "dognet_dockalplan_progress.sumoplavstage"
						},
						{
							data: "dognet_dockalplan_progress.zadolsum_chf"
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
							render: function(data, type, row, meta) {
								if (data != null) {
									return $.fn.dataTable.render.number(' ', ',', 2, '').display(data) + row.dognet_spdened.short_code;
								} else {
									return "0.00" + row.dognet_spdened.short_code;
								}
							},
							targets: 6
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
							targets: 7
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
							targets: 8
						}
					],
					select: false,
					processing: true,
					paging: true,
					searching: false,
					lengthChange: false,
					order: [
						[1, "desc"]
					],
					buttons: [],
					initComplete: function() {

					},
					drawCallback: function() {

					}
				});
				// Array to track the ids of the details displayed rows
				var detailRows_stages_debtors = [];
				$('#gipwork-control-stages_debtors tbody').on('click', 'tr td.details-control', function() {
					var tr = $(this).closest('tr');
					var row = table_gipwork_control_stages_debtors.row(tr);
					var idx = $.inArray(tr.attr('id'), detailRows_stages_debtors);
					if (row.child.isShown()) {
						tr.removeClass('details');
						row.child.hide();
						// Remove from the 'open' array
						detailRows_stages_debtors.splice(idx, 1);
					} else {
						tr.addClass('details');
						rowData = table_gipwork_control_stages_debtors.row(row);
						d = row.data();
						rowData.child(<?php include('templates/gipwork-control-stages_debtors.tpl'); ?>).show();
						// Add to the 'open' array
						if (idx === -1) {
							detailRows_stages_debtors.push(tr.attr('id'));
						}
					}
				});
				// On each draw, loop over the `detailRows_stages_debtors` array and show any child rows
				table_gipwork_control_stages_debtors.on('draw', function() {
					$.each(detailRows_stages_debtors, function(i, id) {
						$('#' + id + ' td.details-control').trigger('click');
					});
				});
				// ----- ----- -----
			});
		</script>
		<?php
		// ----- ----- ----- ----- -----
		// Подключаем стили для таблицы
		// :::
		?>
		<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/main/main/restr_3/tabs/css/gipwork-control-stages_debtors.css">
		<section>
			<div id="tab1_kalplans" class="">
				<h3 class="docview-details-title2 space10">Должники по этапам</h3>
				<div class="demo-html"></div>
				<table id="gipwork-control-stages_debtors" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th><span class='glyphicon glyphicon-option-vertical'></span></th>
							<th>Договор</th>
							<th>Этап</th>
							<th>Заказчик</th>
							<th>Объект</th>
							<th>Сумма СФ</th>
							<th>Сумма оплат</th>
							<th>Зачет авансов</th>
							<th>Задолженность</th>
						</tr>
					</thead>
				</table>
			</div>
		</section>
	<?php
	} else {
	?>
		<section>
			<div id="gipwork-main-stages_debtors" class="">
				<span>Блок временно не выводится</span>
			</div>
		</section>
<?php
	}
}
?>