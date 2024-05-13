<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/moment-with-locales.js"></script>
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/filterByText.js"></script>


<script type="text/javascript" language="javascript" class="init">
	function addZero(digits_length, source) {
		var text = source + '';
		while (text.length < digits_length)
			text = '0' + text;
		return text;
	}

	var table_letter_log_main;

	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

	$(document).ready(function() {
		table_letter_log_main = $('#letterview-act-log').DataTable({
			dom: "<'row'<'col-sm-5'B><'col-sm-4'><'col-sm-3'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'p>>",
			// 		dom: "<'space50'r>tip",
			language: {
				url: "russian.json"
			},
			ajax: {
				url: "php/examples/php/letterview/letterview-current/dognet-letterview-current-log-process.php",
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
					data: "dognet_docjurnallet.sum_field1"
				},
				{
					data: "dognet_docjurnallet.docactcreater"
				},
				{
					data: "dognet_docjurnallet.docFileID",
					defaultContent: '<a href="#" class="edit_listalt"><span class="glyphicon glyphicon-export"></span></a>'
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
					searchable: false,
					render: function(data, type, row, meta) {
						if (data != null) {
							return $.fn.dataTable.render.number(' ', ',', 2, '').display(data) + " руб.";
						} else {
							return "0.00 руб.";
						}
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
					targets: 5,
					render: function(data, type, row, meta) {
						return data ? '<span style="padding:0 5px"><a href="' + row.dognet_docjurnallet_files.file_url + '" title="Скачать письмо"><span class="glyphicon glyphicon-file"></span></a></span>' : '<span class="glyphicon glyphicon-file"></span>';
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
					table_letter_log_main.columns().search('');
					table_letter_log_main.order([0, "desc"]).draw();
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
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/letterview/letterview-current/restr_4/css/letterview-current-log-main.css">
<section>
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 сol-lg-12">
			<h3 class="log-message-info text-center text-danger space10">Здесь только журнал созданных писем. Само письмо можно сформировать в отчете<br><a href="/dognet/dognet-report.php?reportview=zadolchf">"Задолженность по счетам-фактурам"</a></h3>
		</div>
	</div>
	<div class="demo-html"></div>
	<table id="letterview-act-log" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>Дата</th>
				<th>Письмо</th>
				<th>Организация-должник</th>
				<th>Сумма письма</th>
				<th>Кто сформировал</th>
				<th><span class="glyphicon glyphicon-file"></span></th>
			</tr>
		</thead>
	</table>
</section>