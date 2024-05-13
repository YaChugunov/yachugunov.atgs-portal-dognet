<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/moment-with-locales.js"></script>
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/filterByText.js"></script>

<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/chetview/chetview-current/restr_5/css/chetview-current-common-tables.css">
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/chetview/chetview-current/restr_5/css/chetview-current-common-customForm.css">

<script type="text/javascript" language="javascript" class="init">
	function addZero(digits_length, source) {
		var text = source + '';
		while (text.length < digits_length)
			text = '0' + text;
		return text;
	}

	var table_chet_main;
	var editor_chet_main;

	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

	$(document).ready(function() {

		editor_chet_main = new $.fn.dataTable.Editor({
			display: "bootstrap",
			ajax: "php/examples/php/chetview/chetview-current/dognet-chetview-chet-main-process.php",
			table: "#chetview-chet-main",
			i18n: {
				create: {
					title: "<h3>Создать новый счет</h3>"
				},
				edit: {
					title: "<h3>Редактировать счет</h3>"
				},
				remove: {
					title: "<h3>Удалить счет</h3>",
					confirm: {
						"_": "Вы уверены, что хотите удалить %d записи(ей)?",
						"1": "Вы уверены, что хотите удалить этот счет?"
					}
				},
				error: {
					system: "Ошибка в работе сервиса! Свяжитесь с администратором."
				},
				multi: {
					title: "Несколько значений",
					info: "",
					restore: "Отменить изменения"
				},
				datetime: {
					previous: 'Пред',
					next: 'След',
					months: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
					weekdays: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб']
				}
			},
			template: '#customForm-chet-main',
			fields: [{
				label: "Номер :",
				name: "dognet_docbase.docnumber"
			}, {
				label: "Шаблон :",
				name: "dognet_docbase.kodshab",
				type: "select",
				options: [{
						label: "С календарным планом",
						value: "1"
					},
					{
						label: "Без календарного плана",
						value: "2"
					}
				],
				def: "---",
				placeholder: "Выберите шаблон"
			}, {
				label: "Бланк требования",
				type: "checkbox",
				name: "dognet_docbase.usedoczayv",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "Указание руководства",
				type: "checkbox",
				name: "dognet_docbase.usedocruk",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "Краткое наименование :",
				name: "dognet_docbase.docnameshot",
				type: "textarea"
			}, {
				label: "Полное наименование :",
				name: "dognet_docbase.docnamefullm",
				type: "textarea"
			}, {
				label: "Комментарий :",
				name: "dognet_docbase.comments",
				type: "textarea"
			}, {
				// ----- -----
				label: "Начало договора (число) :",
				name: "dognet_docbase.daynachdoc",
				type: "hidden"
			}, {
				label: "Начало договора (месяц) :",
				name: "dognet_docbase.monthnachdoc",
				type: "hidden"
			}, {
				label: "Начало договора (год) :",
				name: "dognet_docbase.yearnachdoc",
				type: "hidden"
			}, {
				label: "Окончание договора (число) :",
				name: "dognet_docbase.dayenddoc",
				type: "hidden"
			}, {
				label: "Окончание договора (месяц) :",
				name: "dognet_docbase.monthenddoc",
				type: "hidden"
			}, {
				label: "Окончание договора (год) :",
				name: "dognet_docbase.yearenddoc",
				type: "hidden"
			}, {
				label: "Начало :",
				name: "docDateBegin",
				type: "datetime",
				def: function() {
					return new Date();
				},
				format: "DD.MM.YYYY",
				attr: {
					readonly: "readonly"
				}
			}, {
				label: "Окончание :",
				name: "docDateEnd",
				type: "datetime",
				def: function() {
					return new Date();
				},
				format: "DD.MM.YYYY",
				attr: {
					readonly: "readonly"
				}
			}, {
				// ----- -----
				label: "Тип :",
				name: "dognet_docbase.kodtip",
				type: "select",
				def: "---",
				placeholder: "Выберите тип"
			}, {
				label: "Объект :",
				name: "dognet_docbase.kodobject",
				type: "select",
				def: "---",
				placeholder: "Выберите объект"
			}, {
				label: "Заказчик :",
				name: "dognet_docbase.kodzakaz",
				type: "select",
				def: "---",
				placeholder: "Выберите заказчика"
			}, {
				label: "Статус :",
				name: "dognet_docbase.kodstatus",
				type: "select",
				def: "---",
				placeholder: "Выберите статус"
			}, {
				label: "Исполнтель :",
				name: "dognet_docbase.kodispol",
				type: "select",
				def: "---",
				placeholder: "Выберите исполнителя"
			}, {
				label: "Руководитель :",
				name: "dognet_docbase.kodispolruk",
				type: "select",
				def: "---",
				placeholder: "Выберите руководителя"
			}, {
				label: "Сумма :",
				name: "dognet_docbase.docsumma",
				def: "0.00"
			}, {
				// ----- -----
				label: "Ден. единица :",
				name: "dognet_docbase.koddened",
				type: "select",
				def: "245296558950375",
				placeholder: "Выберите валюту"
			}, {
				label: "НДС",
				type: "checkbox",
				name: "dognet_docbase.usendssumma",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				def: 1,
				unselectedValue: 0
				// ----- -----
			}, {
				label: "Расчет командировок :",
				name: "dognet_docbase.usemisopl",
				type: "select",
				options: [{
						label: "Не определено",
						value: "0"
					},
					{
						label: "С оплатой по лимиту",
						value: "1"
					},
					{
						label: "Сверх стоимости",
						value: "2"
					}
				],
				placeholder: "Выберите вариант"
			}, {
				label: "Лимит :",
				name: "dognet_docbase.docsummamis",
				def: "0.00"
				// ----- -----
			}, {
				label: "Статус задолженности :",
				name: "dognet_docbase.kodstatuszdl",
				type: "select",
				options: [{
						label: "Без задолженности",
						value: "0"
					},
					{
						label: "Текущая",
						value: "1"
					},
					{
						label: "Судебная",
						value: "2"
					},
					{
						label: "Невозвратная",
						value: "2"
					}
				],
				def: 0,
				placeholder: "Выберите вариант"
			}]
		});
		//
		// ----- ----- ----- ----- -----
		// Изменяем размер диалогового окна редактирования
		editor_chet_main.on('open', function() {
			$(".modal-dialog").css({
				"width": "60%",
				"min-width": "640px",
				"max-width": "800px"
			});
		});
		editor_chet_main.on('close', function() {
			$(".modal-dialog").css({
				"width": "80%",
			});
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		editor_chet_main
			.on('open', function() {
				$('#kodzakaz_filter').val('');
				if (($('#DTE_Field_dognet_docbase-kodzakaz').value) != editor_chet_main.field('dognet_docbase.kodzakaz').get()) {}
				// Поиск в ниспадающем списке по содержимому текстового поля для ответного документа
				$('#DTE_Field_dognet_docbase-kodzakaz').filterByText(editor_chet_main, $('#kodzakaz_filter'), 'dognet_docbase.kodzakaz', false);
				$('#kodobject_filter').val('');
				if (($('#DTE_Field_dognet_docbase-kodobject').value) != editor_chet_main.field('dognet_docbase.kodobject').get()) {}
				// Поиск в ниспадающем списке по содержимому текстового поля для ответного документа
				$('#DTE_Field_dognet_docbase-kodobject').filterByText(editor_chet_main, $('#kodobject_filter'), 'dognet_docbase.kodobject', false);
			})
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

		table_chet_main = $('#chetview-chet-main').DataTable({
			dom: "<'row'<'col-sm-5'B><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'l>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'p>>",
			// 		dom: "<'space50'r>tip",
			language: {
				url: "russian.json"
			},
			ajax: {
				url: "php/examples/php/chetview/chetview-current/dognet-chetview-chet-main-process.php",
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
					className: "text-center"
				},
				{
					data: "dognet_docbase.numberchet",
					className: "text-left"
				},
				{
					data: "dognet_docbase.yearnachdoc",
					className: "text-center"
				},
				{
					data: "dognet_docbase.docnameshot",
					className: "text-left"
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
					orderable: true,
					searchable: true,
					targets: 1
				},
				{
					orderable: true,
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
						return '<span style="padding:0 5px"><a href="dognet-chetview.php?chetview_type=details&uniqueID=' + row.dognet_docbase.koddoc + '"><span class="glyphicon glyphicon-list-alt"></span></a></span>' +
							'<span style="padding:0 5px"><a href="dognet-chetview.php?chetview_type=edit&uniqueID=' + row.dognet_docbase.koddoc + '"><span class="glyphicon glyphicon-pencil"></span></a></span>';
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
						$('#docNumberSearch_text').val('');
						$('#docYearSearch_text').val('');
						$('#docStatusSearch_text').val('');
						$('#docNameSearch_text').val('');
						$('#docObjectSearch_text').val('');
						$('#docZakazSearch_text').val('');
						$('#docTypeSearch_text').val('');
						$('#docIspolSearch_text').val('');
						$('#docShablonSearch_text').val('');
						table_chet_main.columns().search('');
						table_chet_main.order([2, "desc"], [1, "desc"]).draw();
					}
				},
				{
					extend: "create",
					editor: editor_chet_main,
					text: "СОЗДАТЬ СЧЕТ",
					formButtons: ['Создать счет',
						{
							text: 'Отмена',
							action: function() {
								this.close();
							}
						}
					]
				},
				{
					extend: "edit",
					editor: editor_chet_main,
					text: "РЕДАКТИРОВАТЬ",
					formButtons: ['Сохранить изменения',
						{
							text: 'Отмена',
							action: function() {
								this.close();
							}
						}
					]
				},
				{
					extend: "remove",
					editor: editor_chet_main,
					text: "УДАЛИТЬ",
					formButtons: ['Удалить счет',
						{
							text: 'Отмена',
							action: function() {
								this.close();
							}
						}
					]
				}
			],
			drawCallback: function() {

			}
		});

		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		// Array to track the ids of the details displayed rows
		var detailRows = [];

		$('#chetview-chet-main tbody').on('click', 'tr td.details-control', function() {
			var tr = $(this).closest('tr');
			var row = table_chet_main.row(tr);
			var idx = $.inArray(tr.attr('id'), detailRows);

			if (row.child.isShown()) {
				tr.removeClass('details');
				row.child.hide();

				// Remove from the 'open' array
				detailRows.splice(idx, 1);
			} else {
				tr.addClass('details');
				rowData = table_chet_main.row(row);
				d = row.data();
				rowData.child(<?php include('templates/chetview-current-details.tpl'); ?>).show();

				// Add to the 'open' array
				if (idx === -1) {
					detailRows.push(tr.attr('id'));
				}
			}
		});
		// On each draw, loop over the `detailRows` array and show any child rows
		table_chet_main.on('draw', function() {
			$.each(detailRows, function(i, id) {
				$('#' + id + ' td.details-control').trigger('click');
			});
		});
		//
		//
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		//
		editor_chet_main.on('preOpen', function() {

			var daynachdoc = addZero(2, editor_chet_main.field('dognet_docbase.daynachdoc').val());
			var monthnachdoc = addZero(2, editor_chet_main.field('dognet_docbase.monthnachdoc').val());
			var yearnachdoc = addZero(2, editor_chet_main.field('dognet_docbase.yearnachdoc').val());
			editor_chet_main.field('docDateBegin').set(daynachdoc + "." + monthnachdoc + "." + yearnachdoc);

			var dayenddoc = addZero(2, editor_chet_main.field('dognet_docbase.dayenddoc').val());
			var monthenddoc = addZero(2, editor_chet_main.field('dognet_docbase.monthenddoc').val());
			var yearenddoc = addZero(2, editor_chet_main.field('dognet_docbase.yearenddoc').val());
			editor_chet_main.field('docDateEnd').set(dayenddoc + "." + monthenddoc + "." + yearenddoc);

		});
		editor_chet_main.on('initSubmit', function() {

			var a = editor_chet_main.field('docDateBegin').val().split('.');
			editor_chet_main.field('dognet_docbase.daynachdoc').set(a[0]);
			editor_chet_main.field('dognet_docbase.monthnachdoc').set(a[1]);
			editor_chet_main.field('dognet_docbase.yearnachdoc').set(a[2]);

			var b = editor_chet_main.field('docDateEnd').val().split('.');
			editor_chet_main.field('dognet_docbase.dayenddoc').set(b[0]);
			editor_chet_main.field('dognet_docbase.monthenddoc').set(b[1]);
			editor_chet_main.field('dognet_docbase.yearenddoc').set(b[2]);

		});
		editor_chet_main.on('initEdit', function() {
			editor_chet_main.field('dognet_docbase.kodshab').disable();
		});
		editor_chet_main.on('initCreate', function() {
			editor_chet_main.field('dognet_docbase.kodshab').enable();
		});
		editor_chet_main.on('preOpen', function() {
			editor_chet_main.field('dognet_docbase.usedoczayv').disable();
		});
		//
		//
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		//
		$('#globalSearch_button').click(function(e) {
			table_chet_main.search($("#globalSearch_text").val()).draw();
		});
		$('#clearSearch_button').click(function(e) {
			table_chet_main.search('').draw();
			$('#globalSearch_text').val('');
		});

		$('#columnSearch_btnApply').click(function(e) {
			table_chet_main
				.columns(2)
				.search($("#docNumberSearch_text").val())
				.draw();

			table_chet_main
				.columns(3)
				.search($("#docYearSearch_text").val())
				.draw();

			table_chet_main
				.columns(4)
				.search($("#docNameSearch_text").val())
				.draw();

			table_chet_main
				.columns(5)
				.search($("#docObjectSearch_text").val())
				.draw();

			table_chet_main
				.columns(6)
				.search($("#docZakazSearch_text").val())
				.draw();

			table_chet_main
				.columns(7)
				.search($("#docTypeSearch_text").val())
				.draw();

			table_chet_main
				.columns(8)
				.search($("#docIspolSearch_text").val())
				.draw();

		});

		$('#columnSearch_btnClear').click(function(e) {
			$('#docNumberSearch_text').val('');
			$('#docYearSearch_text').val('');
			$('#docNameSearch_text').val('');
			$('#docObjectSearch_text').val('');
			$('#docZakazSearch_text').val('');
			$('#docTypeSearch_text').val('');
			$('#docIspolSearch_text').val('');
			table_chet_main
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
		$("#docYearSearch_text").on("keyup", function(event) {
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
// Подключаем форму редактирования, форму поиска и выводим таблицу договора
// :::
include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/chetview/chetview-current/restr_5/forms/chetview-current-customForm.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/chetview/chetview-current/restr_5/forms/chetview-current-filters.php");
// ----- ----- ----- ----- -----
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/chetview/chetview-current/restr_5/css/chetview-current-main.css">
<section>
	<div class="demo-html"></div>
	<table id="chetview-chet-main" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
				<th class="text-center">№</th>
				<th class="text-center">Счет №</th>
				<th class="text-center">Год</th>
				<th class="text-left">Краткое название</th>
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