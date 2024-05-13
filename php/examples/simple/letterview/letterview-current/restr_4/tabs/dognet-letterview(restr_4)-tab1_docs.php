<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/moment-with-locales.js"></script>
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/filterByText.js"></script>


<script type="text/javascript" language="javascript" class="init">
	function addZero(digits_length, source) {
		var text = source + '';
		while (text.length < digits_length)
			text = '0' + text;
		return text;
	}

	var table_doc_main;
	var editor_doc_main;

	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

	$(document).ready(function() {


		table_doc_main = $('#letterview-doc-list').DataTable({
			dom: "<'row'<'col-sm-5'B><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'l>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'p>>",
			// 		dom: "<'space50'r>tip",
			language: {
				url: "russian.json"
			},
			ajax: {
				url: "php/examples/php/letterview/letterview-current/dognet-letterview-current-docs-process.php",
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
					data: "dognet_docbase.docnumber",
					className: ""
				},
				{
					data: "dognet_docbase.yearnachdoc",
					className: ""
				},
				{
					data: "dognet_docbase.docnamefullm",
					className: ""
				},
				{
					data: "dognet_spstatus.statusnameshot",
					className: ""
				},
				{
					data: "sp_objects.nameobjectshot"
				},
				{
					data: "sp_contragents.nameshort"
				},
				{
					data: "dognet_sptipdog.nametip"
				},
				{
					data: "dognet_spispol.ispolnamefull"
				},
				{
					data: "dognet_docbase.kodshab"
				},
				{
					data: null,
					defaultContent: '<a href="#" class="edit_listalt"><span class="glyphicon glyphicon-list-alt"></span></a>'
				}
			],
			select: 'single',
			columnDefs: [{
					orderable: false,
					searchable: false,
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
					targets: 3,
					render: function(data, type, row, meta) {
						fullstr = data;
						if (data.length > 130) {
							return data.substr(0, 130) + " ...";
						} else {
							return data;
						}
					}
				},
				{
					orderable: false,
					visible: false,
					searchable: true,
					targets: 4
				},
				{
					orderable: false,
					visible: false,
					searchable: true,
					targets: 5
				},
				{
					orderable: false,
					visible: false,
					searchable: true,
					targets: 6
				},
				{
					orderable: false,
					visible: false,
					searchable: true,
					targets: 7
				},
				{
					orderable: false,
					visible: false,
					searchable: true,
					targets: 8
				},
				{
					orderable: false,
					visible: false,
					searchable: true,
					targets: 9
				},
				{
					orderable: false,
					searchable: false,
					targets: 10,
					render: function(data, type, row, meta) {
						return '<span style="padding:0 5px"><a href="dognet-letterview.php?letterview_type=list&uniqueID1=' + row.dognet_docbase.koddoc + '&export=yes&format=" title="Сформировать документ"><span class="glyphicon glyphicon-export"></span></a></span>';
					}
				}
			],
			order: [
				[2, "desc"],
				[1, "desc"]
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
					$('#docNumberSearch_text_tab1').val('');
					$('#docYearSearch_text_tab1').val('');
					$('#docStatusSearch_text_tab1').val('');
					$('#docNameSearch_text_tab1').val('');
					$('#docObjectSearch_text_tab1').val('');
					$('#docZakazSearch_text_tab1').val('');
					$('#docTypeSearch_text_tab1').val('');
					$('#docIspolSearch_text_tab1').val('');
					$('#docShablonSearch_text_tab1').val('');
					table_doc_main.columns().search('');
					table_doc_main.order([2, "desc"], [1, "desc"]).draw();
				}
			}],
			drawCallback: function() {

			}
		});

		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		// Array to track the ids of the details displayed rows
		var detailRows = [];

		$('#letterview-doc-list tbody').on('click', 'tr td.details-control', function() {
			var tr = $(this).closest('tr');
			var row = table_doc_main.row(tr);
			var idx = $.inArray(tr.attr('id'), detailRows);

			if (row.child.isShown()) {
				tr.removeClass('details');
				row.child.hide();

				// Remove from the 'open' array
				detailRows.splice(idx, 1);
			} else {
				tr.addClass('details');
				rowData = table_doc_main.row(row);
				d = row.data();
				rowData.child(<?php include('templates/docview-current-details.tpl'); ?>).show();

				// Add to the 'open' array
				if (idx === -1) {
					detailRows.push(tr.attr('id'));
				}
			}
		});
		// On each draw, loop over the `detailRows` array and show any child rows
		table_doc_main.on('draw', function() {
			$.each(detailRows, function(i, id) {
				$('#' + id + ' td.details-control').trigger('click');
			});
		});
		//
		//
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		//
		$('#globalSearch_button').click(function(e) {
			table_doc_main.search($("#globalSearch_text_tab1").val()).draw();
		});
		$('#clearSearch_button').click(function(e) {
			table_doc_main.search('').draw();
			$('#globalSearch_text_tab1').val('');
		});

		$('#columnSearch_btnApply_tab1').click(function(e) {
			table_doc_main
				.columns(1)
				.search($("#docNumberSearch_text_tab1").val())
				.draw();

			table_doc_main
				.columns(2)
				.search($("#docYearSearch_text_tab1").val())
				.draw();

			table_doc_main
				.columns(3)
				.search($("#docNameSearch_text_tab1").val())
				.draw();

			table_doc_main
				.columns(4)
				.search($("#docStatusSearch_text_tab1").val())
				.draw();

			table_doc_main
				.columns(5)
				.search($("#docObjectSearch_text_tab1").val())
				.draw();

			table_doc_main
				.columns(6)
				.search($("#docZakazSearch_text_tab1").val())
				.draw();

			table_doc_main
				.columns(7)
				.search($("#docTypeSearch_text_tab1").val())
				.draw();

			table_doc_main
				.columns(8)
				.search($("#docIspolSearch_text_tab1").val())
				.draw();

			table_doc_main
				.columns(9)
				.search($("#docShablonSearch_text_tab1").val())
				.draw();
		});

		$('#columnSearch_btnClear_tab1').click(function(e) {
			$('#docNumberSearch_text_tab1').val('');
			$('#docYearSearch_text_tab1').val('');
			$('#docStatusSearch_text_tab1').val('');
			$('#docNameSearch_text_tab1').val('');
			$('#docObjectSearch_text_tab1').val('');
			$('#docZakazSearch_text_tab1').val('');
			$('#docTypeSearch_text_tab1').val('');
			$('#docIspolSearch_text_tab1').val('');
			$('#docShablonSearch_text_tab1').val('');
			table_doc_main
				.columns()
				.search('')
				.draw();
		});

		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

		$("#docNumberSearch_text_tab1").on("keyup", function(event) {
			if (event.keyCode === 13) {
				event.preventDefault();
				document.getElementById("columnSearch_btnApply_tab1").click();
			}
		});
		$("#docYearSearch_text_tab1").on("keyup", function(event) {
			if (event.keyCode === 13) {
				event.preventDefault();
				document.getElementById("columnSearch_btnApply_tab1").click();
			}
		});
		$("#docNameSearch_text_tab1").on("keyup", function(event) {
			if (event.keyCode === 13) {
				event.preventDefault();
				document.getElementById("columnSearch_btnApply_tab1").click();
			}
		});
		$("#docObjectSearch_text_tab1").on("keyup", function(event) {
			if (event.keyCode === 13) {
				event.preventDefault();
				document.getElementById("columnSearch_btnApply_tab1").click();
			}
		});
		$("#docZakazSearch_text_tab1").on("keyup", function(event) {
			if (event.keyCode === 13) {
				event.preventDefault();
				document.getElementById("columnSearch_btnApply_tab1").click();
			}
		});
	});
</script>
<?php
// ----- ----- ----- ----- -----
// Подключаем форму поиска и выводим таблицу
// :::
include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/letterview/letterview-current/restr_4/forms/letterview-current-docs-filters.php");
// ----- ----- ----- ----- -----
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/letterview/letterview-current/restr_4/css/letterview-current-docs-main.css">
<section>
	<div class="demo-html"></div>
	<table id="letterview-doc-list" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th class=""><span class='glyphicon glyphicon-option-vertical'></span></th>
				<th class="">№</th>
				<th class="">Год</th>
				<th class="">Краткое название</th>
				<th class="">Статус</th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
			</tr>
		</thead>
	</table>
</section>