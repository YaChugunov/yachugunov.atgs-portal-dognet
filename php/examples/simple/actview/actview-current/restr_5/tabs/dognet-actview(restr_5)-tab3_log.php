<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/moment-with-locales.js"></script>
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/filterByText.js"></script>


<script type="text/javascript" language="javascript" class="init">
	function addZero(digits_length, source) {
		var text = source + '';
		while (text.length < digits_length)
			text = '0' + text;
		return text;
	}

	var table_letter_log;

	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

	$(document).ready(function() {
		table_letter_log = $('#actview-letter-log').DataTable({
			dom: "<'row'<'col-sm-5'B><'col-sm-4'><'col-sm-3'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'p>>",
			// 		dom: "<'space50'r>tip",
			language: {
				url: "russian.json"
			},
			ajax: {
				url: "php/examples/simple/actview/actview-current/restr_5/process/dognet-actview-current-log_letter-process.php",
				type: "POST"
			},
			serverSide: true,
			columns: [{
					data: "dognet_docjurnallet.datecreateletter"
				},
				{
					data: "dognet_docjurnallet.numberdocletter"
				},
				{
					data: "sp_contragents.nameshort"
				},
				{
					data: "sp_contragents.director_fio"
				},
				{
					data: "dognet_docjurnallet.docactcreater"
				},
				{
					data: "dognet_docjurnallet.docFileID"
				}
			],
			select: 'single',
			columnDefs: [{
					orderable: false,
					searchable: true,
					targets: 0
				},
				{
					orderable: false,
					searchable: true,
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
					targets: 5,
					render: function(data, type, row, meta) {
						return data ? '<span style="padding:0 5px"><a href="' + row.dognet_docjurnallet_files.file_url + '" title="Скачать акт"><span class="glyphicon glyphicon-file"></span></a></span>' : '<span class="glyphicon glyphicon-option-horizontal"></span>';
					}
				}
			],
			order: [
				[0, "desc"]
			],
			processing: true,
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
					table_letter_log.columns().search('');
					table_letter_log.order([0, "desc"]).draw();
				}
			}],
			drawCallback: function() {

			}
		});
	});
</script>
<?php
// ----- ----- ----- ----- -----
// Выводим таблицу
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/actview/actview-current/restr_5/css/actview-current-log-letter.css">
<section>
	<div class="demo-html"></div>
	<table id="actview-letter-log" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>Дата</th>
				<th>Договор</th>
				<th>Организация</th>
				<th>Получатель</th>
				<th>Кто сформировал</th>
				<th><span class="glyphicon glyphicon-file"></span></th>
			</tr>
		</thead>
	</table>
</section>