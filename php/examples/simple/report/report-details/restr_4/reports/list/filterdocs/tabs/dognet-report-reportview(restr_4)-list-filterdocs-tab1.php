<?php
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# Какой то блок...
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
?>
<script type="text/javascript" language="javascript" class="init">
	function addZero(digits_length, source) {
		var text = source + '';
		while (text.length < digits_length)
			text = '0' + text;
		return text;
	}


	var table_reports_filterdocs;
	// ----- ----- -----
	$(document).ready(function() {
		table_reports_filterdocs = $('#report-view-filterdocs-table').DataTable({
			dom: "<'row'<'col-sm-5'B><'col-sm-4'><'col-sm-3 text-right'l>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'p>>",
			language: {
				url: "php/examples/simple/report/report-details/restr_4/reports/list/filterdocs/dt_russian-report-view-filterdocs.json"
			},
			ajax: {
				url: "php/examples/simple/report/report-details/restr_4/reports/list/filterdocs/process/dognet-report-reportview(restr_4)-list-filterdocs-process.php",
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
					data: "dognet_docbase.yearnachdoc"
				},
				{
					data: "dognet_docbase.docnameshot"
				},
				{
					data: "sp_contragents.nameshort"
				},
				{
					data: "sp_objects.nameobjectshot"
				},
				{
					data: "dognet_docbase.docsumma"
				},
				{
					data: "dognet_sptipdog.nametip"
				},
				{
					data: "dognet_docbase.yearenddoc"
				},
				{
					data: "dognet_docbase.datezakr"
				},
				{
					data: "dognet_spstatus.statusnameshot"
				},
				{
					data: "dognet_spispol.kodispol"
				},
				{
					data: "dognet_docbase.kodshab"
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
					orderable: true,
					searchable: true,
					render: function(data, type, row, meta) {
						return '<a href="/dognet/dognet-docview.php?docview_type=details&uniqueID=' + row.dognet_docbase.koddoc + '" class="docview-details-link" title="Перейти к карточке договора">' + data + '</a>';
					},
					targets: 1
				},
				{
					orderable: false,
					searchable: true,
					render: function(data, type, row, meta) {
						if (data != 0) {
							return addZero(2, row.dognet_docbase.daynachdoc) + "." + addZero(2, row.dognet_docbase.monthnachdoc) + "." + addZero(4, row.dognet_docbase.yearnachdoc);
						} else {
							return "---";
						}
					},
					targets: 2
				},
				{
					orderable: false,
					searchable: true,
					render: function(data, type, row, meta) {
						str = data;
						if (str != null) {
							if (str.length > 21) {
								return str.substr(0, 21) + " ...";
							} else {
								return str;
							}
						} else {
							return "---";
						}
					},
					targets: 3
				},
				{
					orderable: false,
					searchable: true,
					render: function(data, type, row, meta) {
						str = data;
						if (str != null) {
							if (str.length > 13) {
								return str.substr(0, 13) + " ...";
							} else {
								return str;
							}
						} else {
							return "---";
						}
					},
					targets: 4
				},
				{
					orderable: false,
					searchable: true,
					render: function(data, type, row, meta) {
						str = data;
						if (str != null) {
							if (str.length > 15) {
								return str.substr(0, 15) + " ...";
							} else {
								return str;
							}
						} else {
							return "---";
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
					searchable: true,
					render: function(data, type, row, meta) {
						str = data;
						if (str != null) {
							if (str.length > 12) {
								return str.substr(0, 12) + " ...";
							} else {
								return str;
							}
						} else {
							return "---";
						}
					},
					targets: 7
				},
				{
					orderable: false,
					searchable: true,
					render: function(data, type, row, meta) {
						if (data != 0) {
							return addZero(2, row.dognet_docbase.dayenddoc) + "." + addZero(2, row.dognet_docbase.monthenddoc) + "." + addZero(4, row.dognet_docbase.yearenddoc);
						} else {
							return "---";
						}
					},
					targets: 8
				},
				{
					orderable: false,
					searchable: true,
					render: function(data, type, row, meta) {
						if (data !== null) {
							return data;
						} else {
							return "---";
						}
					},
					targets: 9
				},
				{
					orderable: false,
					searchable: true,
					render: function(data, type, row, meta) {
						str = data;
						if (str != null && str != '') {
							if (str.length > 10) {
								return str.substr(0, 10) + " ...";
							} else {
								return str;
							}
						} else {
							return "---";
						}
					},
					targets: 10
				},
				{
					orderable: false,
					searchable: true,
					render: function(data, type, row, meta) {
						str = row.dognet_spispol.ispolnameshot;
						if (str != null && str != '') {
							if (str.length > 10) {
								return str.substr(0, 10) + " ...";
							} else {
								return str;
							}
						} else {
							return "---";
						}
					},
					targets: 11
				},
				{
					orderable: false,
					visible: false,
					searchable: true,
					targets: 12
				},
			],
			orderClasses: false,
			select: false,
			processing: true,
			paging: true,
			pageLength: 15,
			searching: true,
			lengthChange: true,
			lengthMenu: [
				[15, 30, 50, -1],
				[15, 30, 50, "Все"]
			],
			order: [
				[1, "desc"]
			],
			buttons: [{
				text: '<span class="glyphicon glyphicon-refresh"></span>',
				action: function(e, dt, node, config) {
					table_reports_filterdocs.columns().search('');
					table_reports_filterdocs.order([1, "desc"]).draw();
				}
			}],
			initComplete: function() {

			},
			drawCallback: function() {

			}
		});
		// Array to track the ids of the details displayed rows
		var detailRows_reports_filterdocs = [];
		$('#report-view-filterdocs-table tbody').on('click', 'tr td.details-control', function() {

			var tr = $(this).closest('tr');
			var row = table_reports_filterdocs.row(tr);
			var idx = $.inArray(tr.attr('id'), detailRows_reports_filterdocs);

			if (row.child.isShown()) {
				tr.removeClass('details');
				row.child.hide();
				// Remove from the 'open' array
				detailRows_reports_filterdocs.splice(idx, 1);
			} else {
				tr.addClass('details');
				rowData = table_reports_filterdocs.row(row);
				d = row.data();

				if (d.dognet_docbase.datezakr !== null) {
					d.datezakr = d.dognet_docbase.datezakr;
				} else {
					d.datezakr = "---";
				}

				/*
									var firstdateavans = d.dognet_dockalplan_progress.firstdateavans;
									var srokstage = d.dognet_dockalplan_progress.srokstage;
									var idsrokstage = d.dognet_dockalplan_progress.idsrokstage;

									var date1;
									var newdate1;
									var out;

									if (idsrokstage == 0) {
										date1 = moment(firstdateavans, 'YYYY-MM-DD');
										newdate1 = moment(date1.format('YYYY-MM-DD'));
										out = date1.add(d.dognet_dockalplan_progress.srokstage, 'days').format('YYYY-MM-DD');
									} else {
										out = moment(srokstage, 'YYYY-MM-DD').format('YYYY-MM-DD');
									}
									console.log("ids="+idsrokstage+" / "+out);
				*/


				rowData.child(<?php include('templates/report-view-filterdocs.tpl'); ?>).show();
				// Add to the 'open' array
				if (idx === -1) {
					detailRows_reports_filterdocs.push(tr.attr('id'));
				}
			}
		});
		// On each draw, loop over the `detailRows_reports_filterdocs` array and show any child rows
		table_reports_filterdocs.on('draw', function() {
			$.each(detailRows_reports_filterdocs, function(i, id) {
				$('#' + id + ' td.details-control').trigger('click');
			});
		});

		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

		$('#globalSearch_button').click(function(e) {
			table_reports_filterdocs.search($("#globalSearch_text").val()).draw();
		});
		$('#clearSearch_button').click(function(e) {
			table_reports_filterdocs.search('').draw();
			$('#globalSearch_text').val('');
		});

		$('#columnSearch_btnApply').click(function(e) {
			table_reports_filterdocs
				.columns(1)
				.search($("#docNumberSearch_text").val())
				.draw();

			table_reports_filterdocs
				.columns(2)
				.search($("#docYearNachSearch_text").val())
				.draw();

			table_reports_filterdocs
				.columns(8)
				.search($("#docYearEndSearch_text").val())
				.draw();

			table_reports_filterdocs
				.columns(3)
				.search($("#docNameSearch_text").val())
				.draw();

			table_reports_filterdocs
				.columns(4)
				.search($("#docZakazSearch_text").val())
				.draw();

			table_reports_filterdocs
				.columns(5)
				.search($("#docObjectSearch_text").val())
				.draw();

			table_reports_filterdocs
				.columns(10)
				.search($("#docStatusSearch_text").val())
				.draw();

			table_reports_filterdocs
				.columns(7)
				.search($("#docTypeSearch_text").val())
				.draw();

			table_reports_filterdocs
				.columns(11)
				.search($("#docIspolSearch_text").val())
				.draw();

			table_reports_filterdocs
				.columns(9)
				.search($("#docYearZakrSearch_text").val())
				.draw();

			table_reports_filterdocs
				.columns(12)
				.search($("#docShablonSearch_text").val())
				.draw();
		});

		$('#columnSearch_btnClear').click(function(e) {
			$('#docNumberSearch_text').val('');
			$('#docYearNachSearch_text').val('');
			$('#docYearEndSearch_text').val('');
			$('#docYearZakrSearch_text').val('');
			$('#docStatusSearch_text').val('');
			$('#docNameSearch_text').val('');
			$('#docObjectSearch_text').val('');
			$('#docZakazSearch_text').val('');
			$('#docTypeSearch_text').val('');
			$('#docIspolSearch_text').val('');
			$('#docShablonSearch_text').val('');
			table_reports_filterdocs
				.columns()
				.search('')
				.draw();
		});

		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

		$("#docNumberSearch_text").on("keyup", function(event) {
			if (event.keyCode === 13) {
				event.preventDefault();
				document.getElementById("columnSearch_btnApply").click();
			}
		});
		$("#docYearNachSearch_text").on("keyup", function(event) {
			if (event.keyCode === 13) {
				event.preventDefault();
				document.getElementById("columnSearch_btnApply").click();
			}
		});
		$("#docYearEndSearch_text").on("keyup", function(event) {
			if (event.keyCode === 13) {
				event.preventDefault();
				document.getElementById("columnSearch_btnApply").click();
			}
		});
		$("#docYearZakrSearch_text").on("keyup", function(event) {
			if (event.keyCode === 13) {
				event.preventDefault();
				document.getElementById("columnSearch_btnApply").click();
			}
		});
		$("#docNameSearch_text").on("keyup", function(event) {
			if (event.keyCode === 13) {
				event.preventDefault();
				document.getElementById("columnSearch_btnApply").click();
			}
		});
		$("#docObjectSearch_text").on("keyup", function(event) {
			if (event.keyCode === 13) {
				event.preventDefault();
				document.getElementById("columnSearch_btnApply").click();
			}
		});
		$("#docZakazSearch_text").on("keyup", function(event) {
			if (event.keyCode === 13) {
				event.preventDefault();
				document.getElementById("columnSearch_btnApply").click();
			}
		});

	});
</script>
<?php
// ----- ----- ----- ----- -----
// Подключаем стили для таблицы
// :::
include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/list/filterdocs/tabs/forms/report-view-filterdocs-filters.php");
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/report/report-details/restr_4/reports/list/filterdocs/tabs/css/report-view-filterdocs.css">
<section>
	<div id="report-view-filterdocs" class="" style="">
		<div class="demo-html"></div>
		<table id="report-view-filterdocs-table" class="table table-bordered table-responsive display compact" cellspacing="0" width="100%">
			<thead id="report-view-filterdocs-table-header">
				<tr>
					<th><span class='glyphicon glyphicon-option-vertical'></span></th>
					<th>№</th>
					<th>Начало</th>
					<th>Предмет договора</th>
					<th>Заказчик</th>
					<th>Объект</th>
					<th>Сумма</th>
					<th>Тип</th>
					<th>Конец</th>
					<th>Закрыт</th>
					<th>Статус</th>
					<th>Исполнитель</th>
				</tr>
			</thead>
		</table>
	</div>
</section>