<script type="text/javascript" language="javascript" class="init">
	var table_zayv_main;
	var editor_zayv_main;
	var table_zayv_child_dop;
	var editor_zayv_child_dop;
	var table_zayv_child_chet;
	var editor_zayv_child_chet;
	var table_chet_child_chetf;
	var editor_chet_child_chetf;

	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

	$(document).ready(function() {
		//
		// ЗАЯВКА
		//
		// ----- ----- -----
		// Обработчик формы редактирование заявки
		editor_zayv_main = new $.fn.dataTable.Editor({
			display: "bootstrap",
			ajax: {
				url: "php/examples/php/zayvview/zayvview-current/dognet-zayvview-zayv-main-process.php",
				data: function(d) {
					var selected = table_zayv_child_chet.row({
						selected: true
					});
					if (selected.any()) {
						d.kodzayvchet = selected.data().dognet_doczayvchet.kodzayvchet;
						d.kodtipzayvall = selected.data().dognet_doczayv.kodtipzayvall;
						console.log("kodtipzayvall: " + d.kodtipzayvall)
					}
				}
			},
			table: "#zayvview-zayv-main",
			i18n: {
				create: {
					title: "<h3>Новый счет</h3>"
				},
				edit: {
					title: "<h3>Изменить счет</h3>"
				},
				remove: {
					button: "Удалить",
					title: "<h3>Удалить счет</h3>",
					submit: "Удалить",
					confirm: {
						_: "Вы действительно хотите удалить %d записей?",
						1: "Вы действительно хотите удалить эту запись?"
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
			template: '#customForm-zayv-main',
			fields: [{
				label: "Договор :",
				type: "select",
				name: "dognet_doczayv.koddoc",
				def: "---",
				placeholder: "Выберите договор"
			}, {
				label: "Заявитель :",
				type: "select",
				name: "dognet_doczayv.kodzayvtel",
				def: "---",
				placeholder: "Выберите заявителя"
			}, {
				label: "Тип :",
				type: "select",
				name: "dognet_doczayv.kodtipzayvall",
				def: "---",
				placeholder: "Выберите тип заявки"
			}, {
				label: "Дата :",
				name: "dognet_doczayv.datezayv",
				type: "datetime",
				format: "DD.MM.YYYY"
			}, {
				label: "Номер :",
				name: "dognet_doczayv.numberzayv"
			}, {
				label: "Название спецификации :",
				name: "dognet_doczayv.namerabfilespec"
				// ----- ----- -----
			}, {
				name: "dognet_doczayv.docFileID",
				type: "upload",
				display: function(id) {
					return '<a target="_blank" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet' + editor_zayv_main.file('dognet_doczayv_files', id).file_webpath + '"><h4>СКАЧАТЬ ФАЙЛ</h4></a>';
				},
				dragDrop: false,
				dragDropText: "",
				clearText: "",
				fileReadText: "Файл загружается",
				noFileText: "Файл не прикреплен",
				processingText: "Файл загружен",
				uploadText: "Выберите файл"
			}, {
				type: "readonly",
				name: "dognet_doczayv.msgDocFileID"
				// ----- ----- -----
			}]
		});
		// ----- ----- -----
		// Управление размером диалогового окна редактирования заявки
		editor_zayv_main.on('open', function() {
			$(".modal-dialog").css({
				"width": "50%",
				"min-width": "640px",
				"max-width": "800px"
			});
		});
		editor_zayv_main.off('close', function() {
			$(".modal-dialog").css({
				"width": "80%",
				"min-width": "none",
				"max-width": "none"
			});
		});
		// ----- ----- -----
		// Обработчик таблицы заявок
		table_zayv_main = $('#zayvview-zayv-main').DataTable({
			dom: "<'row'<'col-sm-5'B><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'l>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'p>>",
			// 		dom: "<'space50'r>tip",
			language: {
				url: "russian.json"
			},
			ajax: {
				url: "php/examples/php/zayvview/zayvview-current/dognet-zayvview-zayv-main-process.php",
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
					data: "dognet_doczayv.datezayv"
				},
				{
					data: "dognet_sptipzayvall.nametipzayvshotall"
				},
				{
					data: "dognet_doczayv.numberzayv"
				},
				{
					data: "dognet_doczayv.namerabfilespec"
				},
				{
					data: "dognet_doczayv.koddoc"
				},
				{
					data: "dognet_doczayv.docFileID",
					render: function(id, type, row) {
						if (row.dognet_doczayv.kodrabzayv == 0) {
							return id ?
								'<a class="" target="_blank" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet' + editor_zayv_main.file('dognet_doczayv_files', id).file_webpath + '"><span class="glyphicon glyphicon-file"></span></a>' :
								'<span class="glyphicon glyphicon-option-horizontal"></span>';
						} else {
							return '';
						}
					},
					defaultContent: "",
					className: "text-center"
				},
				{
					data: null,
					defaultContent: ''
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
					orderable: true,
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
					searchable: true,
					render: function(data, type, row, meta) {
						if (data == '245375260650765') {
							return "АТГС";
						} else if (data == '245375544141726') {
							return "Склад";
						} else {
							return row.dognet_docbase.docnumber;
						}
					},
					targets: 5
				},
				{
					orderable: false,
					searchable: true,
					targets: 6
				},
				{
					orderable: false,
					searchable: false,
					targets: 7,
					render: function(data, type, row, meta) {
						return '' +
							'<span style="padding:0 5px"><a href="#"><span class="glyphicon glyphicon-print"></span></a></span>' +
							'<span style="padding:0 5px"><a href="#"><span class="glyphicon glyphicon-send"></span></a></span>';
					}
				}
			],
			order: [
				[1, "desc"],
				[3, "desc"]
			],
			ordering: true,
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
						table_zayv_main.columns().search('');
						table_zayv_main.order([2, "desc"], [1, "desc"]).draw();
					}
				},
				{
					extend: "create",
					editor: editor_zayv_main,
					text: "СОЗДАТЬ ЗАЯВКУ",
					formButtons: ['Создать заявку',
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
					editor: editor_zayv_main,
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
					editor: editor_zayv_main,
					text: "УДАЛИТЬ",
					formButtons: ['Удалить договор',
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
		// ----- ----- -----
		// Обработчик child-таблицы для выбранной заявки
		// Array to track the ids of the details displayed rows
		var detailRows = [];
		$('#zayvview-zayv-main tbody').on('click', 'tr td.details-control', function() {
			var tr = $(this).closest('tr');
			var row = table_zayv_main.row(tr);
			var idx = $.inArray(tr.attr('id'), detailRows);

			if (row.child.isShown()) {
				tr.removeClass('details');
				row.child.hide();

				// Remove from the 'open' array
				detailRows.splice(idx, 1);
			} else {
				tr.addClass('details');
				rowData = table_zayv_main.row(row);
				if (row.data().dognet_docbase.usedocruk == '1') {
					var osn = "По указанию руководства";
					var blank = '';
				} else if (row.data().dognet_docbase.usedoczayv == '1') {
					var osn = 'Заявка ГИПа';
					if (row.data().dognet_docbase.kodblankwork !== null) {
						var blank = ' / Бланк № ' + row.data().dognet_docblankwork.numberblankwork + ' / ' + row.data().dognet_docblankwork.nameblankwork;
					} else {
						var blank = ' / Бланк не привязан';
					}
				} else {
					var osn = "Не определено";
					var blank = '';
				}
				d = row.data();
				rowData.child(<?php include('templates/zayvview-zayv-details.tpl'); ?>).show();

				// Add to the 'open' array
				if (idx === -1) {
					detailRows.push(tr.attr('id'));
				}
			}
		});
		// On each draw, loop over the `detailRows` array and show any child rows
		table_zayv_main.on('draw', function() {
			$.each(detailRows, function(i, id) {
				$('#' + id + ' td.details-control').trigger('click');
			});
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		//
		//
		// СПЕЦИФИКАЦИЯ
		//
		// ----- ----- -----
		// Обработчик формы редактирование счета
		editor_zayv_child_dop = new $.fn.dataTable.Editor({
			display: "bootstrap",
			ajax: {
				url: "php/examples/php/zayvview/zayvview-current/dognet-zayvview-zayv-child-dop-process.php",
				data: function(d) {
					var selected = table_zayv_main.row({
						selected: true
					});
					if (selected.any()) {
						d.kodzayv = selected.data().dognet_doczayv.kodzayv;
					}
				}
			},
			table: "#zayvview-zayv-child-dop",
			i18n: {
				create: {
					title: "<h3>Новая позиция спецификации</h3>"
				},
				edit: {
					title: "<h3>Изменить позицию спецификации</h3>"
				},
				remove: {
					button: "Удалить",
					title: "<h3>Удалить позицию</h3>",
					submit: "Удалить",
					confirm: {
						_: "Вы действительно хотите удалить %d записей?",
						1: "Вы действительно хотите удалить эту запись?"
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
			template: '#customForm-zayv-child-dop',
			fields: [{
				label: "Наименование позиции :",
				name: "dognet_doczayvdop.namedop"
			}, {
				label: "Модель :",
				name: "dognet_doczayvdop.modeldop"
			}, {
				label: "Кол :",
				name: "dognet_doczayvdop.koldop"
			}, {
				label: "Примечание :",
				name: "dognet_doczayvdop.commentdop",
				type: "textarea"
			}]
		});
		// ----- ----- -----
		// Управление размером диалогового окна редактирования счета
		editor_zayv_child_dop.on('open', function() {
			$(".modal-dialog").css({
				"width": "50%",
				"min-width": "640px",
				"max-width": "800px"
			});
		});
		editor_zayv_child_dop.off('close', function() {
			$(".modal-dialog").css({
				"width": "80%",
				"min-width": "none",
				"max-width": "none"
			});
		});
		// ----- ----- -----
		// Обработчики событий редактора счета
		editor_zayv_child_dop.on('submitSuccess', function() {
			table_zayv_main.ajax.reload(null, false);
		});
		// ----- ----- -----
		// Обработчик таблицы счетов
		table_zayv_child_dop = $('#zayvview-zayv-child-dop').DataTable({
			dom: "<'row'<'col-sm-5'B><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'l>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'p>>",
			// 		dom: "<'space50'r>tip",
			language: {
				url: "php/examples/simple/zayvview/zayvview-current/dt_russian-zayv-child-dop.json"
			},
			ajax: {
				url: "php/examples/php/zayvview/zayvview-current/dognet-zayvview-zayv-child-dop-process.php",
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

			},
			columns: [{
					class: "details-control",
					searchable: false,
					orderable: false,
					data: null,
					defaultContent: "<span class='glyphicon glyphicon-option-vertical'></span>"
				},
				{
					data: "dognet_doczayvdop.numberdop"
				},
				{
					data: "dognet_doczayvdop.namedop"
				},
				{
					data: "dognet_doczayvdop.modeldop"
				},
				{
					data: "dognet_doczayvdop.koldop"
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
					targets: 3
				},
				{
					orderable: false,
					searchable: true,
					targets: 4
				}
			],
			order: [
				[1, "asc"]
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
						table_zayv_child_dop.ajax.reload();
						table_zayv_child_dop.columns().search('').draw();
					}
				},
				{
					extend: "create",
					editor: editor_zayv_child_dop,
					text: '<span class="glyphicon glyphicon-plus"></span>',
					formButtons: ['Создать',
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
					editor: editor_zayv_child_dop,
					text: '<span class="glyphicon glyphicon-pencil"></span>',
					formButtons: ['Изменить',
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
					editor: editor_zayv_child_dop,
					text: '<span class="glyphicon glyphicon-remove"></span>'
				}
			],
			drawCallback: function() {

			}
		});
		// ----- ----- -----
		// Обработчик child-таблицы выбранного счета
		// Array to track the ids of the details displayed rows
		var detailRows = [];
		$('#zayvview-zayv-child-dop tbody').on('click', 'tr td.details-control', function() {
			var tr = $(this).closest('tr');
			var row = table_zayv_child_dop.row(tr);
			var idx = $.inArray(tr.attr('id'), detailRows);

			if (row.child.isShown()) {
				tr.removeClass('details');
				row.child.hide();

				// Remove from the 'open' array
				detailRows.splice(idx, 1);
			} else {
				tr.addClass('details');
				rowData = table_zayv_child_dop.row(row);
				d = row.data();
				rowData.child(<?php include('templates/zayvview-dop-details.tpl'); ?>).show();

				// Add to the 'open' array
				if (idx === -1) {
					detailRows.push(tr.attr('id'));
				}
			}
		});
		// On each draw, loop over the `detailRows` array and show any child rows
		table_zayv_child_dop.on('draw', function() {
			$.each(detailRows, function(i, id) {
				$('#' + id + ' td.details-control').trigger('click');
			});
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		//
		//
		// СЧЕТ
		//
		// ----- ----- -----
		// Обработчик формы редактирование счета
		editor_zayv_child_chet = new $.fn.dataTable.Editor({
			display: "bootstrap",
			ajax: {
				url: "php/examples/php/zayvview/zayvview-current/dognet-zayvview-zayv-child-chet-process.php",
				data: function(d) {
					var selected = table_zayv_main.row({
						selected: true
					});
					if (selected.any()) {
						d.kodzayv = selected.data().dognet_doczayv.kodzayv;
					}
				}
			},
			table: "#zayvview-zayv-child-chet",
			i18n: {
				create: {
					title: "<h3>Новый счет</h3>"
				},
				edit: {
					title: "<h3>Изменить счет</h3>"
				},
				remove: {
					button: "Удалить",
					title: "<h3>Удалить счет</h3>",
					submit: "Удалить",
					confirm: {
						_: "Вы действительно хотите удалить %d записей?",
						1: "Вы действительно хотите удалить эту запись?"
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
			template: '#customForm-zayv-child-chet',
			fields: [{
				label: "Заявка :",
				type: "select",
				name: "dognet_doczayvchet.kodzayv",
				def: "---",
				placeholder: "Выберите заявку"
			}, {
				label: "Дата счета :",
				name: "dognet_doczayvchet.zayvchetdate",
				type: "datetime",
				format: "DD.MM.YYYY"
			}, {
				label: "№ счета :",
				name: "dognet_doczayvchet.zayvchetnumber"
			}, {
				label: "Сумма счета :",
				name: "dognet_doczayvchet.zayvchetsumma"
			}, {
				label: "Примечание к счету :",
				name: "dognet_doczayvchet.zayvchetcomment",
				type: "textarea"
				// ----- ----- -----
			}, {
				name: "dognet_doczayvchet.docFileID",
				type: "upload",
				display: function(id) {
					return '<a target="_blank" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet' + editor_zayv_child_chet.file('dognet_doczayvchet_files', id).file_webpath + '"><h4>СКАЧАТЬ ФАЙЛ</h4></a>';
				},
				dragDrop: false,
				dragDropText: "",
				clearText: "",
				fileReadText: "Файл загружается",
				noFileText: "Файл не прикреплен",
				processingText: "Файл загружен",
				uploadText: "Выберите файл"
			}, {
				type: "readonly",
				name: "dognet_doczayvchet.msgDocFileID"
				// ----- ----- -----
			}]
		});
		// ----- ----- -----
		// Управление размером диалогового окна редактирования счета
		editor_zayv_child_chet.on('open', function() {
			$(".modal-dialog").css({
				"width": "50%",
				"min-width": "640px",
				"max-width": "800px"
			});
		});
		editor_zayv_child_chet.off('close', function() {
			$(".modal-dialog").css({
				"width": "80%",
				"min-width": "none",
				"max-width": "none"
			});
		});
		// ----- ----- -----
		// Обработчики событий редактора счета
		editor_zayv_child_chet.on('initCreate', function(e) {
			editor_zayv_child_chet.field('dognet_doczayvchet.msgDocFileID').show();
			editor_zayv_child_chet.field('dognet_doczayvchet.msgDocFileID').val('Сначала создайте запись!');
			editor_zayv_child_chet.field('dognet_doczayvchet.docFileID').hide();
			editor_zayv_child_chet.field('dognet_doczayvchet.docFileID').disable();
		});
		editor_zayv_child_chet.on('initEdit', function(e, node, data, items, type) {
			editor_zayv_child_chet.field('dognet_doczayvchet.msgDocFileID').hide();
			editor_zayv_child_chet.field('dognet_doczayvchet.docFileID').show();
			editor_zayv_child_chet.field('dognet_doczayvchet.docFileID').enable();
			editor_zayv_child_chet.field('dognet_doczayvchet.kodzayv').disable();
		});
		editor_zayv_child_chet.on('submitSuccess', function() {
			table_zayv_main.ajax.reload(null, false);
		});
		// ----- ----- -----
		// Обработчик таблицы счетов
		table_zayv_child_chet = $('#zayvview-zayv-child-chet').DataTable({
			dom: "<'row'<'col-sm-5'B><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'l>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'p>>",
			// 		dom: "<'space50'r>tip",
			language: {
				url: "php/examples/simple/zayvview/zayvview-current/dt_russian-zayv-child-chet.json"
			},
			ajax: {
				url: "php/examples/php/zayvview/zayvview-current/dognet-zayvview-zayv-child-chet-process.php",
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
				console.log(data.dognet_doczayvchet.zayvchetpr);
				if (data.dognet_doczayvchet.zayvchetpr < 100.00 || data.dognet_doczayvchet.zayvchetzadol < 0.00) {
					$('td', row).eq(6).addClass('highlight');
					$('td', row).eq(7).addClass('highlight');
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
					render: function(id) {
						return id ?
							'<a class="" target="_blank" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet' + editor_zayv_child_chet.file('dognet_doczayvchet_files', id).file_webpath + '"><span class="glyphicon glyphicon-file"></span></a>' :
							'<span class="glyphicon glyphicon-option-horizontal"></span>';
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
				},
				{
					extend: "create",
					editor: editor_zayv_child_chet,
					text: '<span class="glyphicon glyphicon-plus"></span>',
					formButtons: ['Создать',
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
					editor: editor_zayv_child_chet,
					text: '<span class="glyphicon glyphicon-pencil"></span>',
					formButtons: ['Изменить',
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
					editor: editor_zayv_child_chet,
					text: '<span class="glyphicon glyphicon-remove"></span>'
				}
			],
			drawCallback: function() {

			}
		});
		// ----- ----- -----
		// Обработчик child-таблицы выбранного счета
		// Array to track the ids of the details displayed rows
		var detailRows = [];
		$('#zayvview-zayv-child-chet tbody').on('click', 'tr td.details-control', function() {
			var tr = $(this).closest('tr');
			var row = table_zayv_child_chet.row(tr);
			var idx = $.inArray(tr.attr('id'), detailRows);

			if (row.child.isShown()) {
				tr.removeClass('details');
				row.child.hide();

				// Remove from the 'open' array
				detailRows.splice(idx, 1);
			} else {
				tr.addClass('details');
				rowData = table_zayv_child_chet.row(row);
				d = row.data();
				rowData.child(<?php include('templates/zayvview-chet-details.tpl'); ?>).show();

				// Add to the 'open' array
				if (idx === -1) {
					detailRows.push(tr.attr('id'));
				}
			}
		});
		// On each draw, loop over the `detailRows` array and show any child rows
		table_zayv_child_chet.on('draw', function() {
			$.each(detailRows, function(i, id) {
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
		// Обработчик формы редактирование счета-фактуры
		editor_chet_child_chetf = new $.fn.dataTable.Editor({
			display: "bootstrap",
			ajax: {
				url: "php/examples/php/zayvview/zayvview-current/dognet-zayvview-chet-child-chetf-process.php",
				data: function(d) {
					var selected = table_zayv_child_chet.row({
						selected: true
					});
					if (selected.any()) {
						d.kodzayvchet = selected.data().dognet_doczayvchet.kodzayvchet;
					}
				}
			},
			table: "#zayvview-chet-child-chetf",
			i18n: {
				create: {
					title: "<h3>Новый счет-фактура</h3>"
				},
				edit: {
					title: "<h3>Изменить счет-фактуру</h3>"
				},
				remove: {
					button: "Удалить",
					title: "<h3>Удалить счет-фактуру</h3>",
					submit: "Удалить",
					confirm: {
						_: "Вы действительно хотите удалить %d записей?",
						1: "Вы действительно хотите удалить эту запись?"
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
			template: '#customForm-chet-child-chetf',
			fields: [{
				label: "Счет :",
				type: "select",
				name: "dognet_doczayvchetf.kodzayvchet",
				def: "---",
				placeholder: "Выберите счет"
			}, {
				label: "Дата С/Ф :",
				name: "dognet_doczayvchetf.zayvchetfdate",
				type: "datetime",
				format: "DD.MM.YYYY"
			}, {
				label: "№ С/Ф :",
				name: "dognet_doczayvchetf.zayvchetfnumber"
			}, {
				label: "Сумма С/Ф :",
				name: "dognet_doczayvchetf.zayvchetfsumma"
			}, {
				label: "Примечание к С/Ф :",
				name: "dognet_doczayvchetf.zayvchetfcomment",
				type: "textarea"
				// ----- ----- -----
			}, {
				name: "dognet_doczayvchetf.docFileID",
				type: "upload",
				display: function(id) {
					return '<a target="_blank" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet' + editor_chet_child_chetf.file('dognet_doczayvchetf_files', id).file_webpath + '"><h4>СКАЧАТЬ ФАЙЛ</h4></a>';
				},
				dragDrop: false,
				dragDropText: "",
				clearText: "",
				fileReadText: "Файл загружается",
				noFileText: "Файл не прикреплен",
				processingText: "Файл загружен",
				uploadText: "Выберите файл"
			}, {
				type: "readonly",
				name: "dognet_doczayvchetf.msgDocFileID"
				// ----- ----- -----
			}]
		});
		// ----- ----- -----
		// Управление размером диалогового окна редактирования счета-фактуры
		editor_chet_child_chetf.on('open', function() {
			$(".modal-dialog").css({
				"width": "50%",
				"min-width": "640px",
				"max-width": "800px"
			});
		});
		editor_chet_child_chetf.off('close', function() {
			$(".modal-dialog").css({
				"width": "80%",
				"min-width": "none",
				"max-width": "none"
			});
		});
		// ----- ----- -----
		// Обработчики событий редактора счета-фактуры
		editor_chet_child_chetf.on('initCreate', function(e) {
			editor_chet_child_chetf.field('dognet_doczayvchetf.msgDocFileID').show();
			editor_chet_child_chetf.field('dognet_doczayvchetf.msgDocFileID').val('Сначала создайте запись!');
			editor_chet_child_chetf.field('dognet_doczayvchetf.docFileID').hide();
			editor_chet_child_chetf.field('dognet_doczayvchetf.docFileID').disable();
		});
		editor_chet_child_chetf.on('initEdit', function(e, node, data, items, type) {
			editor_chet_child_chetf.field('dognet_doczayvchetf.msgDocFileID').hide();
			editor_chet_child_chetf.field('dognet_doczayvchetf.docFileID').show();
			editor_chet_child_chetf.field('dognet_doczayvchetf.docFileID').enable();
			editor_chet_child_chetf.field('dognet_doczayvchetf.kodzayvchet').disable();
		});
		// ----- ----- -----
		// Обработчик таблицы счетов-фактур
		table_chet_child_chetf = $('#zayvview-chet-child-chetf').DataTable({
			dom: "<'row'<'col-md-8 col-sm-12'B><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'>>",
			language: {
				url: "php/examples/simple/zayvview/zayvview-current/dt_russian-chet-child-chetf.json"
			},
			ajax: {
				url: "php/examples/php/zayvview/zayvview-current/dognet-zayvview-chet-child-chetf-process.php",
				type: 'post',
				data: function(d) {
					var selected = table_zayv_child_chet.row({
						selected: true
					});
					if (selected.any()) {
						d.kodzayvchet = selected.data().dognet_doczayvchet.kodzayvchet;
					}
				}
			},
			serverSide: true,
			select: {
				style: 'single'
			},
			createdRow: function(row, data, index) {

			},
			rowCallback: function(row, data) {
				// console.log(row);
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
					data: "dognet_doczayvchetf.zayvchetfcomment",
					className: ""
				},
				{
					data: "dognet_doczayvchetf.zayvchetfsumma",
					className: ""
				},
				{
					data: "dognet_doczayvchetf.docFileID",
					render: function(id) {
						return id ?
							'<a class="" target="_blank" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet' + editor_chet_child_chetf.file('dognet_doczayvchetf_files', id).file_webpath + '"><span class="glyphicon glyphicon-file"></span></a>' :
							'<span class="glyphicon glyphicon-option-horizontal"></span>';
					},
					defaultContent: "",
					className: "text-center"
				},
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
					render: function(data, type, row, meta) {
						if (data != null) {
							return $.fn.dataTable.render.number(' ', ',', 2, '').display(data) + row.dognet_spdened.short_code;
						} else {
							return "0.00" + row.dognet_spdened.short_code;
						}
					},
					targets: 4
				},
				{
					orderable: false,
					searchable: false,
					targets: 5
				}
			],
			order: [
				[2, "desc"],
				[3, "asc"]
			],
			buttons: [{
					text: '<span class="glyphicon glyphicon-refresh"></span>',
					action: function(e, dt, node, config) {
						table_chet_child_chetf.ajax.reload();
						table_chet_child_chetf.columns().search('').draw();
					}
				},
				{
					extend: "create",
					editor: editor_chet_child_chetf,
					text: '<span class="glyphicon glyphicon-plus"></span>',
					formButtons: ['Создать',
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
					editor: editor_chet_child_chetf,
					text: '<span class="glyphicon glyphicon-pencil"></span>',
					formButtons: ['Изменить',
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
					editor: editor_chet_child_chetf,
					text: '<span class="glyphicon glyphicon-remove"></span>'
				}
			]
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		//
		//
		//
		//
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		// Обработчики событий таблицы заявок
		table_zayv_main.on('select', function() {
			table_zayv_child_chet.buttons().enable();
			table_zayv_child_chet.ajax.reload(null, true);

			var selected = table_zayv_main.row({
				selected: true
			});
			var kod = selected.data().dognet_doczayv.kodrabzayv;
			if (kod == 1) {
				$("#zayvview-zayv-child-dop-spec").css('display', 'block');
			} else {
				$("#zayvview-zayv-child-dop-spec").css('display', 'none');
			}
			table_zayv_child_dop.buttons().enable();
			table_zayv_child_dop.ajax.reload(null, true);
		});
		table_zayv_main.on('deselect', function() {
			table_zayv_child_chet.buttons().disable();
			table_zayv_child_chet.row({
				selected: true
			}).deselect();
			table_zayv_child_chet.ajax.reload(null, false);
			table_zayv_child_dop.buttons().disable();
			table_zayv_child_dop.row({
				selected: true
			}).deselect();
			table_zayv_child_dop.ajax.reload(null, false);
		});
		// ----- ----- -----
		// Обработчики событий редактора счета
		editor_zayv_child_chet.on('submitSuccess', function() {
			table_zayv_main.ajax.reload(null, false);
		});
		// ----- ----- -----
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
		// ----- ----- -----
		// Обработчики событий редактора счета-фактуры
		editor_chet_child_chetf.on('submitSuccess', function() {
			table_zayv_child_chet.ajax.reload(null, false);
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		//
		//
		//
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		$('#globalSearch_button').click(function(e) {
			table_zayv_main.search($("#globalSearch_text").val()).draw();
		});
		$('#clearSearch_button').click(function(e) {
			table_zayv_main.search('').draw();
			$('#globalSearch_text').val('');
		});
		$('#columnSearch_btnApply').click(function(e) {
			table_zayv_main
				.columns(1)
				.search($("#docNumberSearch_text").val())
				.draw();

			table_zayv_main
				.columns(2)
				.search($("#docYearSearch_text").val())
				.draw();

			table_zayv_main
				.columns(3)
				.search($("#docNameSearch_text").val())
				.draw();

			table_zayv_main
				.columns(4)
				.search($("#docStatusSearch_text").val())
				.draw();

			table_zayv_main
				.columns(5)
				.search($("#docObjectSearch_text").val())
				.draw();

			table_zayv_main
				.columns(6)
				.search($("#docZakazSearch_text").val())
				.draw();

			table_zayv_main
				.columns(7)
				.search($("#docTypeSearch_text").val())
				.draw();

			table_zayv_main
				.columns(8)
				.search($("#docIspolSearch_text").val())
				.draw();

			table_zayv_main
				.columns(9)
				.search($("#docShablonSearch_text").val())
				.draw();
		});
		$('#columnSearch_btnClear').click(function(e) {
			$('#docNumberSearch_text').val('');
			$('#docYearSearch_text').val('');
			$('#docStatusSearch_text').val('');
			$('#docNameSearch_text').val('');
			$('#docObjectSearch_text').val('');
			$('#docZakazSearch_text').val('');
			$('#docTypeSearch_text').val('');
			$('#docIspolSearch_text').val('');
			$('#docShablonSearch_text').val('');
			table_zayv_main
				.columns()
				.search('')
				.draw();
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

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
// Форма редактирования заявки
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/zayvview/zayvview-current/restr_5/css/zayvview-zayv-main-customform.css">
<div id="customForm-zayv-main">
	<div id="customForm-zayv-main-editor-tabs" style="width:100%">
		<ul id="customForm-zayv-main-editor-tabs-menu" class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#customForm-zayv-main-editor-tab-1" title="">Договор</a></li>
			<li><a data-toggle="tab" href="#customForm-zayv-main-editor-tab-2" title="">Параметры</a></li>
			<li><a data-toggle="tab" href="#customForm-zayv-main-editor-tab-3" title="">Файл</a></li>
		</ul>
		<div class="tab-content" style="padding:5px">
			<div id="customForm-zayv-main-editor-tab-1" class="tab-pane fade in active">
				<div class="Section">
					<div class="Block100">
						<legend>Договор</legend>
						<fieldset class="field100">
							<editor-field name="dognet_doczayv.koddoc"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
			<div id="customForm-zayv-main-editor-tab-2" class="tab-pane fade">
				<div class="Section">
					<div class="Block60">
						<legend>Заявитель и тип заявки</legend>
						<fieldset class="field60">
							<editor-field name="dognet_doczayv.kodzayvtel"></editor-field>
						</fieldset>
						<fieldset class="field40">
							<editor-field name="dognet_doczayv.kodtipzayvall"></editor-field>
						</fieldset>
					</div>
					<div class="Block40">
						<legend>Номер и дата заявки</legend>
						<fieldset class="field50">
							<editor-field name="dognet_doczayv.numberzayv"></editor-field>
						</fieldset>
						<fieldset class="field50">
							<editor-field name="dognet_doczayv.datezayv"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
			<div id="customForm-zayv-main-editor-tab-3" class="tab-pane fade">
				<div class="Section">
					<div class="Block100">
						<legend>Файл</legend>
						<fieldset class="field100">
							<editor-field name="dognet_doczayvchet.msgDocFileID"></editor-field>
						</fieldset>
						<fieldset class="field100">
							<editor-field name="dognet_doczayvchet.docFileID"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Форма редактирования позиций спецификации
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/zayvview/zayvview-current/restr_5/css/zayvview-zayv-child-dop-customform.css">
<div id="customForm-zayv-child-dop">
	<div id="customForm-zayv-child-dop-editor-tabs" style="width:100%">
		<ul id="customForm-zayv-child-dop-editor-tabs-menu" class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#customForm-zayv-child-dop-editor-tab-1" title="">Параметры</a></li>
			<li><a data-toggle="tab" href="#customForm-zayv-child-dop-editor-tab-2" title="">Примечание</a></li>
		</ul>
		<div class="tab-content" style="padding:5px">
			<div id="customForm-zayv-child-dop-editor-tab-1" class="tab-pane fade in active">
				<div class="Section">
					<div class="Block100">
						<legend>Позиция спецификации</legend>
						<fieldset class="field100">
							<editor-field name="dognet_doczayvdop.namedop"></editor-field>
						</fieldset>
						<fieldset class="field85">
							<editor-field name="dognet_doczayvdop.modeldop"></editor-field>
						</fieldset>
						<fieldset class="field15">
							<editor-field name="dognet_doczayvdop.koldop"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
			<div id="customForm-zayv-child-dop-editor-tab-2" class="tab-pane fade">
				<div class="Section">
					<div class="Block100">
						<legend>Примечание к позиции</legend>
						<fieldset class="field100">
							<editor-field name="dognet_doczayvdop.commentdop"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Форма редактирования счета
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/zayvview/zayvview-current/restr_5/css/zayvview-zayv-child-chet-customform.css">
<div id="customForm-zayv-child-chet">
	<div id="customForm-zayv-child-chet-editor-tabs" style="width:100%">
		<ul id="customForm-zayv-child-chet-editor-tabs-menu" class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#customForm-zayv-child-chet-editor-tab-1" title="">Параметры</a></li>
			<li><a data-toggle="tab" href="#customForm-zayv-child-chet-editor-tab-2" title="">Примечание</a></li>
			<li><a data-toggle="tab" href="#customForm-zayv-child-chet-editor-tab-3" title="">Файл</a></li>
		</ul>
		<div class="tab-content" style="padding:5px">
			<div id="customForm-zayv-child-chet-editor-tab-1" class="tab-pane fade in active">
				<div class="Section">
					<div class="Block100">
						<legend>Заявка и параметры счета</legend>
						<fieldset class="field30">
							<editor-field name="dognet_doczayvchet.kodzayv"></editor-field>
						</fieldset>
						<fieldset class="field30">
							<editor-field name="dognet_doczayvchet.zayvchetnumber"></editor-field>
						</fieldset>
						<fieldset class="field20">
							<editor-field name="dognet_doczayvchet.zayvchetdate"></editor-field>
						</fieldset>
						<fieldset class="field20">
							<editor-field name="dognet_doczayvchet.zayvchetsumma"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
			<div id="customForm-zayv-child-chet-editor-tab-2" class="tab-pane fade">
				<div class="Section">
					<div class="Block100">
						<legend>Примечание к счету</legend>
						<fieldset class="field100">
							<editor-field name="dognet_doczayvchet.zayvchetcomment"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
			<div id="customForm-zayv-child-chet-editor-tab-3" class="tab-pane fade">
				<div class="Section">
					<div class="Block100">
						<legend>Файл</legend>
						<fieldset class="field100">
							<editor-field name="dognet_doczayvchet.msgDocFileID"></editor-field>
						</fieldset>
						<fieldset class="field100">
							<editor-field name="dognet_doczayvchet.docFileID"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Форма редактирования счета-фактуры
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/zayvview/zayvview-current/restr_5/css/zayvview-chet-child-chetf-customform.css">
<div id="customForm-chet-child-chetf">

	<div id="customForm-chet-child-chetf-editor-tabs" style="width:100%">
		<ul id="customForm-chet-child-chetf-editor-tabs-menu" class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#customForm-chet-child-chetf-editor-tab-1" title="">Параметры</a></li>
			<li><a data-toggle="tab" href="#customForm-chet-child-chetf-editor-tab-2" title="">Примечание</a></li>
			<li><a data-toggle="tab" href="#customForm-chet-child-chetf-editor-tab-3" title="">Файл</a></li>
		</ul>
		<div class="tab-content" style="padding:5px">
			<div id="customForm-chet-child-chetf-editor-tab-1" class="tab-pane fade in active">
				<div class="Section">
					<div class="Block100">
						<legend>Счет и счет-фактура</legend>
						<fieldset class="field30">
							<editor-field name="dognet_doczayvchetf.kodzayvchet"></editor-field>
						</fieldset>
						<fieldset class="field30">
							<editor-field name="dognet_doczayvchetf.zayvchetfnumber"></editor-field>
						</fieldset>
						<fieldset class="field20">
							<editor-field name="dognet_doczayvchetf.zayvchetfdate"></editor-field>
						</fieldset>
						<fieldset class="field20">
							<editor-field name="dognet_doczayvchetf.zayvchetfsumma"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
			<div id="customForm-chet-child-chetf-editor-tab-2" class="tab-pane fade">
				<div class="Section">
					<div class="Block100">
						<legend>Примечание к счету-фактуре</legend>
						<fieldset class="field100">
							<editor-field name="dognet_doczayvchetf.zayvchetfcomment"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
			<div id="customForm-chet-child-chetf-editor-tab-3" class="tab-pane fade">
				<div class="Section">
					<div class="Block100">
						<legend>Файл</legend>
						<fieldset class="field100">
							<editor-field name="dognet_doczayvchetf.msgDocFileID"></editor-field>
						</fieldset>
						<fieldset class="field100">
							<editor-field name="dognet_doczayvchetf.docFileID"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
<?php
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
?>

<section>

	<div class="space30"></div>
	<div id="docsearch-filters-block" class="panel-group">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
					<a data-toggle="collapse" href="#docsearch-filters">Фильтры для поиска договора</a>
				</h4>
			</div>
			<div id="docsearch-filters" class="panel-collapse collapse">

				<div id="zayvview-current-filters" class="panel-body space30">
					<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
						<div class="form-group space10" style="width:100%">
							<label for="docNumberSearch_text"><b>Номер договора :</b></label>
							<input type="text" id="docNumberSearch_text" class="form-control" placeholder="Все номера" name="docNumberSearch_text">
						</div>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
						<div class="form-group space10" style="width:100%">
							<label for="docYearSearch_text"><b>Год начала действия :</b></label>
							<input type="text" id="docYearSearch_text" class="form-control" placeholder="Все года" name="docYearSearch_text">
						</div>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
						<div class="form-group space10" style="width:100%">
							<label for="docStatusSearch_text"><b>Статус договора :</b></label>
							<select name="docStatusSearch_text" id="docStatusSearch_text" class="form-control">
								<option value="">Все статусы договоров</option>
								<?php
								$_QRY1 = mysqlQuery(" SELECT statusnameshot FROM dognet_spstatus WHERE statusnameshot<>'' ");
								while ($_ROW1 = mysqli_fetch_assoc($_QRY1)) {
								?>
									<option value='<?php echo $_ROW1["statusnameshot"]; ?>'><?php echo $_ROW1["statusnameshot"]; ?></option>
								<?php
								}
								?>
							</select>
						</div>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
						<div class="form-group space10" style="width:100%">
							<label for="docTypeSearch_text"><b>Тип договора :</b></label>
							<select name="docTypeSearch_text" id="docTypeSearch_text" class="form-control">
								<option value="">Все типы договоров</option>
								<?php
								$_QRY2 = mysqlQuery(" SELECT nametip FROM dognet_sptipdog WHERE nametip<>'' AND koddel<>99 ");
								while ($_ROW2 = mysqli_fetch_assoc($_QRY2)) {
								?>
									<option value='<?php echo $_ROW2["nametip"]; ?>'><?php echo $_ROW2["nametip"]; ?></option>
								<?php
								}
								?>
							</select>
						</div>
					</div>
					<?php // ----- ----- ----- ----- ----- 
					?>
					<div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
						<div class="input-group space10" style="width:100%">
							<label for="docObjectSearch_text"><b>Заказчик/объект :</b></label>
							<input type="text" id="docObjectSearch_text" class="form-control" placeholder="Все объекты" name="docObjectSearch_text">
						</div>
					</div>
					<div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
						<div class="input-group space10" style="width:100%">
							<label for="docZakazSearch_text"><b>Заказчик/плательщик :</b></label>
							<input type="text" id="docZakazSearch_text" class="form-control" placeholder="Все плательщики" name="docZakazSearch_text">
						</div>
					</div>
					<div class="col-xs-12 col-sm-4 col-md-6 col-lg-6">
						<div class="input-group space10" style="width:100%">
							<label for="docNameSearch_text"><b>Текст из названия договора :</b></label>
							<input type="text" id="docNameSearch_text" class="form-control" placeholder="Введите текст для поиска в названии" name="docNameSearch_text">
						</div>
					</div>
					<?php // ----- ----- ----- ----- ----- 
					?>
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
						<div class="input-group space10" style="width:100%">
							<label for="docIspolSearch_text"><b>Исполнитель :</b></label>
							<select name="docIspolSearch_text" id="docIspolSearch_text" class="form-control">
								<option value="">Все исполнители</option>
								<?php
								$_QRY3 = mysqlQuery(" SELECT ispolnamefull FROM dognet_spispol WHERE ispolnamefull<>'' AND koddel<>99 ");
								while ($_ROW3 = mysqli_fetch_assoc($_QRY3)) {
								?>
									<option value='<?php echo $_ROW3["ispolnamefull"]; ?>'><?php echo $_ROW3["ispolnamefull"]; ?></option>
								<?php
								}
								?>
							</select>
						</div>
					</div>
					<?php // ----- ----- ----- ----- ----- 
					?>
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
						<div class="input-group space10" style="width:100%">
							<label for="docShablonSearch_text"><b>Календарный план :</b></label>
							<select name="docShablonSearch_text" id="docShablonSearch_text" class="form-control">
								<option value="">Все</option>
								<option value="1">Только с календарным планом</option>
								<option value="2">Только без календарного плана</option>
							</select>
						</div>
					</div>
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-6">

					</div>
					<?php // ----- ----- ----- ----- ----- 
					?>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
						<div class="input-group-btn">
							<button id="columnSearch_btnApply" class="btn btn-default" type="button">Применить фильтры</button>
							<button id="columnSearch_btnClear" class="btn btn-default" type="button"><i class="glyphicon glyphicon-remove"></i></button>
						</div>
					</div>
					<?php // ----- ----- ----- ----- ----- 
					?>
				</div>

			</div>
		</div>
	</div>

	<?php // ----- ----- ----- ----- ----- 
	?>
	<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/zayvview/zayvview-current/restr_5/css/zayvview-zayv-main.css">

	<div class="demo-html"></div>
	<table id="zayvview-zayv-main" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
				<th>Дата</th>
				<th>Тип</th>
				<th>№</th>
				<th>Описание заявки</th>
				<th>Договор</th>
				<th>Спец</th>
				<th></th>
			</tr>
		</thead>
	</table>

	<?php // ----- ----- ----- ----- ----- 
	?>

	<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/zayvview/zayvview-current/restr_5/css/zayvview-zayv-child-dop.css">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="space30"></div>
		<div id="zayvview-zayv-child-dop-spec" style="display:none">
			<h3 class="child-title space20">Спецификация</h3>
			<div class="demo-html"></div>
			<table id="zayvview-zayv-child-dop" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
						<th>#</th>
						<th>Название</th>
						<th>Модель</th>
						<th>Кол</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>

	<?php // ----- ----- ----- ----- ----- 
	?>

	<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/zayvview/zayvview-current/restr_5/css/zayvview-zayv-child-chet.css">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="space30"></div>
		<h3 class="child-title space20">Счета</h3>
		<div class="demo-html"></div>
		<table id="zayvview-zayv-child-chet" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
					<th>Дата</th>
					<th>Счет №</th>
					<th>Заявка</th>
					<th>Поставщик</th>
					<th>Сумма</th>
					<th>%</th>
					<th>Остаток</th>
					<th><span class="glyphicon glyphicon-file"></span></th>
				</tr>
			</thead>
		</table>
	</div>

	<?php // ----- ----- ----- ----- ----- 
	?>

	<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/zayvview/zayvview-current/restr_5/css/zayvview-chet-child-chetf.css">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="space30"></div>
		<h3 class="child-title space20">Счета-фактуры</h3>
		<div class="demo-html"></div>
		<table id="zayvview-chet-child-chetf" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
					<th>Дата</th>
					<th>№</th>
					<th>Примечание</th>
					<th>Сумма</th>
					<th><span class="glyphicon glyphicon-file"></span></th>
				</tr>
			</thead>
		</table>
	</div>



</section>