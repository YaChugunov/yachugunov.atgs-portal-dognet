<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/moment-with-locales.js"></script>
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/filterByText.js"></script>


<script type="text/javascript" language="javascript" class="init">
	function addZero(digits_length, source) {
		var text = source + '';
		while (text.length < digits_length)
			text = '0' + text;
		return text;
	}

	var table_chetf_main;
	var table_chetf_transfer_chetfrom;
	var table_chetf_transfer_chetto;
	var table_chetf_archive;
	var editor_chetf_main;
	var editor_chetf_transfer_chetto;

	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

	$(document).ready(function() {
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		//
		// TAB #1 :::
		// СЧЕТ-ФАКТУРА
		//
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		// СЧЕТ-ФАКТУРА
		//
		editor_chetf_main = new $.fn.dataTable.Editor({
			display: "bootstrap",
			ajax: {
				url: "php/examples/php/zayvview/zayvview-chetf/dognet-zayvview-chetf-main-process.php"
			},
			table: "#zayvview-chetf-main",
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
			template: '#customForm-chetf-main',
			fields: [{
				label: "",
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
			}, {
				label: "Статус :",
				type: "select",
				name: "dognet_doczayvchetf.kodusevalid",
				options: [{
						label: "Не определено",
						value: 0
					},
					{
						label: "Проверено",
						value: 1
					},
					{
						label: "Не проверено",
						value: 2
					}
				],
				def: "---",
				placeholder: "Определите статус"
				// ----- ----- -----
			}, {
				name: "dognet_doczayvchetf.docFileID",
				type: "upload",
				display: function(id) {
					return '<a target="_blank" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet' + editor_chetf_main.file('dognet_doczayvchetf_files', id).file_webpath + '"><h4>СКАЧАТЬ ФАЙЛ</h4></a>';
				},
				dragDrop: false,
				dragDropText: "",
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
		// Изменяем размер диалогового окна редактирования договора субподряда
		editor_chetf_main.on('open', function() {
			$(".modal-dialog").css({
				"width": "50%",
				"min-width": "640px",
				"max-width": "800px"
			});
		});
		editor_chetf_main.off('close', function() {
			$(".modal-dialog").css({
				"width": "80%",
				"min-width": "none",
				"max-width": "none"
			});
		});
		editor_chetf_main.on('initCreate', function(e) {
			editor_chetf_main.field('dognet_doczayvchetf.msgDocFileID').show();
			editor_chetf_main.field('dognet_doczayvchetf.msgDocFileID').val('Сначала создайте запись!');
			editor_chetf_main.field('dognet_doczayvchetf.docFileID').hide();
			editor_chetf_main.field('dognet_doczayvchetf.docFileID').disable();
		});
		editor_chetf_main.on('initEdit', function(e, node, data, items, type) {
			editor_chetf_main.field('dognet_doczayvchetf.msgDocFileID').hide();
			editor_chetf_main.field('dognet_doczayvchetf.docFileID').show();
			editor_chetf_main.field('dognet_doczayvchetf.docFileID').enable();
		});
		// ----- ----- -----
		table_chetf_main = $('#zayvview-chetf-main').DataTable({
			dom: "<'row'<'col-sm-6'B><'col-sm-4'<'#toolbar_msg'>><'col-sm-2'l>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'p>>",
			// 		dom: "<'space50'r>tip",
			language: {
				url: "php/examples/simple/zayvview/zayvview-chetf/dt_russian-chetf-main.json"
			},
			ajax: {
				url: "php/examples/php/zayvview/zayvview-chetf/dognet-zayvview-chetf-main-process.php",
				type: "POST"
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
					data: "dognet_doczayv.numberzayv",
					className: ""
				},
				{
					data: "dognet_doczayvchet.zayvchetcomment",
					className: ""
				},
				{
					data: "sp_contragents.nameshort",
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
					render: function(id) {
						return id ?
							'<a class="" target="_blank" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet' + editor_chetf_main.file('dognet_doczayvchetf_files', id).file_webpath + '"><span class="glyphicon glyphicon-file"></span></a>' :
							'<span class="glyphicon glyphicon-option-horizontal"></span>';
					},
					defaultContent: "",
					className: "text-center"
				},
				{
					data: "dognet_sptipzayvall.kodtipzayvall"
				},
				{
					data: "dognet_doczayv.numberzayv"
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
					searchable: true,
					type: "date",
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
					searchable: false,
					render: function(data, type, row, meta) {
						return row.dognet_sptipzayvall.nametipzayvshotall + "-" + data;
					},
					targets: 4
				},
				{
					orderable: false,
					searchable: true,
					render: function(data, type, row, meta) {
						str = data;
						if (str !== null) {
							if (str.length > 30) {
								return str.substr(0, 30) + " ...";
							} else {
								return str;
							}
						} else {
							return "";
						}
					},
					targets: 5
				},
				{
					orderable: false,
					searchable: true,
					render: function(data, type, row, meta) {
						str = data;
						if (str !== null) {
							if (str.length > 30) {
								return str.substr(0, 30) + " ...";
							} else {
								return str;
							}
						} else {
							return "";
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
					targets: 8
				},
				{
					orderable: false,
					searchable: false,
					targets: 9
				},
				{
					orderable: false,
					visible: false,
					searchable: true,
					targets: 10
				},
				{
					orderable: false,
					visible: false,
					searchable: true,
					targets: 11
				},
				{
					orderable: false,
					searchable: false,
					targets: 12,
					render: function(data, type, row, meta) {
						return '' + '<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/dognet-zayvview.php?zayvview_type=chetf&uniqueID=' + row.dognet_doczayvchetf.kodzayvchetf + '&mailing=yes&msgType="><span class="glyphicon glyphicon-send"></span></a>';
					}
				}
			],
			order: [
				[1, "desc"]
			],
			ordering: true,
			paging: true,
			searching: true,
			searchCols: [null, {
				search: moment().format("YYYY")
			}, null, null, null, null, null, null, null, null],
			pageLength: 15,
			lengthChange: false,
			lengthMenu: [
				[15, 30, 50, -1],
				[15, 30, 50, "Все"]
			],
			processing: true,
			buttons: [{
					text: '<span class="glyphicon glyphicon-refresh"></span>',
					action: function(e, dt, node, config) {
						// 					table_chetf_main.columns(1).search(moment().format("YYYY"));
						table_chetf_main.columns(1).search('');
						table_chetf_main.order([1, "desc"]).draw();
					}
				},
				{
					extend: "create",
					editor: editor_chetf_main,
					text: "ДОБАВИТЬ СЧЕТ-ФАКТУРУ",
					formButtons: ['Создать счет-фактуру',
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
					editor: editor_chetf_main,
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
					editor: editor_chetf_main,
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
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		// Array to track the ids of the details displayed rows
		var detailRows = [];
		$('#zayvview-chetf-main tbody').on('click', 'tr td.details-control', function() {
			var tr = $(this).closest('tr');
			var row = table_chetf_main.row(tr);
			var idx = $.inArray(tr.attr('id'), detailRows);

			if (row.child.isShown()) {
				tr.removeClass('details');
				row.child.hide();

				// Remove from the 'open' array
				detailRows.splice(idx, 1);
			} else {
				tr.addClass('details');
				rowData = table_chetf_main.row(row);
				d = row.data();
				rowData.child(<?php include('templates/zayvview-chetf-details.tpl'); ?>).show();

				// Add to the 'open' array
				if (idx === -1) {
					detailRows.push(tr.attr('id'));
				}
			}
		});
		//
		// On each draw, loop over the `detailRows` array and show any child rows
		table_chetf_main.on('draw', function() {
			$.each(detailRows, function(i, id) {
				$('#' + id + ' td.details-control').trigger('click');
			});
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		// Обработчик формы редактора заявок
		editor_chetf_main.on('open', function(e) {
			$('#zayvview-chetf-main-kodzayvchet_filter').val('');
			// Поиск в ниспадающем списке по содержимому текстового поля для ответного документа
			$('#DTE_Field_dognet_doczayvchetf-kodzayvchet').filterByText(editor_chetf_main, $('#zayvview-chetf-main-kodzayvchet_filter'), 'dognet_doczayvchetf.kodzayvchet', false);
		});
		editor_chetf_main.on('close', function(e) {
			table_chetf_main.ajax.reload(null, false);
		});





		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		// СВЯЗАННЫЙ СЧЕТ
		//
		// ----- ----- -----
		// Обработчик формы редактирование связанного счета
		editor_chet_linked = new $.fn.dataTable.Editor({
			display: "bootstrap",
			ajax: {
				url: "php/examples/php/zayvview/zayvview-chetf/dognet-zayvview-chetf_child_chet-process.php",
				data: function(d) {
					var selected = table_chetf_main.row({
						selected: true
					});
					if (selected.any()) {
						d.kodzayvchet = selected.data().dognet_doczayvchetf.kodzayvchet;
					}
				}
			},
			table: "#zayvview-chet-linked",
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
			template: '#customForm-chet-linked',
			fields: [{
				label: "",
				type: "select",
				name: "dognet_doczayvchet.kodzayv",
				def: "---",
				placeholder: "Выберите заявку"
			}, {
				label: "",
				type: "checkbox",
				name: "kodzayv_transfer_enbl",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				type: "select",
				name: "dognet_doczayvchet.kodpost",
				def: "---",
				placeholder: "Выберите поставщика"
			}, {
				label: "",
				type: "select",
				name: "dognet_doczayvchet.kodpokup",
				def: "---",
				placeholder: "Выберите покупателя"
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
			}, {
				label: "",
				name: "year_zayv_transfer",
				type: "hidden"
				// ----- ----- -----
			}, {
				name: "dognet_doczayvchet.docFileID",
				type: "upload",
				display: function(id) {
					return '<a target="_blank" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet' + editor_chet_linked.file('dognet_doczayvchet_files', id).file_webpath + '"><h4>СКАЧАТЬ ФАЙЛ</h4></a>';
				},
				dragDrop: false,
				dragDropText: "",
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
		// Изменяем размер диалогового окна редактирования договора субподряда
		editor_chet_linked.on('open', function() {
			$(".modal-dialog").css({
				"width": "50%",
				"min-width": "640px",
				"max-width": "800px"
			});
		});
		editor_chet_linked.off('close', function() {
			$(".modal-dialog").css({
				"width": "80%",
				"min-width": "none",
				"max-width": "none"
			});
		});
		editor_chet_linked.on('initCreate', function(e) {
			editor_chet_linked.field('dognet_doczayvchet.msgDocFileID').show();
			editor_chet_linked.field('dognet_doczayvchet.msgDocFileID').val('Сначала создайте запись!');
			editor_chet_linked.field('dognet_doczayvchet.docFileID').hide();
			editor_chet_linked.field('dognet_doczayvchet.docFileID').disable();
		});
		editor_chet_linked.on('initEdit', function(e, node, data, items, type) {
			editor_chet_linked.field('dognet_doczayvchet.msgDocFileID').hide();
			editor_chet_linked.field('dognet_doczayvchet.docFileID').show();
			editor_chet_linked.field('dognet_doczayvchet.docFileID').enable();
		});
		// ----- ----- -----
		table_chet_linked = $('#zayvview-chet-linked').DataTable({
			dom: "<'row'<'col-sm-5'B><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'l>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'><'col-sm-8'>>",
			// 		dom: "<'space50'r>tip",
			language: {
				url: "php/examples/simple/zayvview/zayvview-chetf/dt_russian-chet-linked.json"
			},
			ajax: {
				url: "php/examples/php/zayvview/zayvview-chetf/dognet-zayvview-chetf_child_chet-process.php",
				type: "POST",
				data: function(d) {
					var selected = table_chetf_main.row({
						selected: true
					});
					if (selected.any()) {
						d.kodzayvchet = selected.data().dognet_doczayvchetf.kodzayvchet;
					}
				}
			},
			serverSide: true,
			/*
					createdRow: function ( row, data, index ) {
						if (data.dognet_doczayvchet.zayvchetpr < 50) {
							$(row).css('background-color','rgb(255, 235, 235)');
						}
						else if (data.dognet_doczayvchet.zayvchetpr >= 50 && data.dognet_doczayvchet.zayvchetpr < 100) {
							$(row).css('background-color','rgb(235, 255, 230)');
						}
						else { $(row).css('background-color','rgb(255, 255, 255)'); }
					},
			*/
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
					data: "dognet_doczayvchet.zayvchetcomment"
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
						return id ? '<a class="" target="_blank" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet' + editor_chet_linked.file('dognet_doczayvchet_files', id).file_webpath + '"><span class="glyphicon glyphicon-file"></span></a>' : '<span class="glyphicon glyphicon-option-horizontal"></span>';
					},
					defaultContent: "",
					className: "text-center"
				},
				{
					data: "dognet_doczayv.kodtipzayvall"
				},
				{
					data: "dognet_doczayvchet.controlzadol"
				},
				{
					data: null,
					defaultContent: ''
				}
			],
			select: 'single',
			createdRow: function(row, data, index) {
				if (data.dognet_doczayvchet.zayvchetpr < 100.00 || data.dognet_doczayvchet.zayvchetzadol > 0.00) {
					$('td', row).eq(7).addClass('highlight_warning');
					$('td', row).eq(8).addClass('highlight_warning');
				}
				if (data.dognet_doczayvchet.zayvchetpr > 100.00 || data.dognet_doczayvchet.zayvchetzadol < 0.00) {
					$('td', row).eq(7).addClass('highlight_alarm');
					$('td', row).eq(8).addClass('highlight_alarm');
				}
			},
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
					searchable: true,
					targets: 5
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
					targets: 6
				},
				{
					orderable: false,
					searchable: true,
					render: function(data, type, row, meta) {
						return Math.round(data);
					},
					targets: 7
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
					targets: 8
				},
				{
					orderable: false,
					searchable: false,
					targets: 9
				},
				{
					orderable: false,
					searchable: true,
					visible: false,
					targets: 10
				},
				{
					orderable: false,
					searchable: true,
					visible: false,
					targets: 11
				},
				{
					orderable: false,
					searchable: true,
					visible: false,
					targets: 12
				}
			],
			order: [
				[1, "desc"]
			],
			ordering: true,
			paging: false,
			searching: true,
			searchCols: [null, null, null, null, null, null, null, null, null, null],
			pageLength: 15,
			lengthChange: false,
			lengthMenu: [
				[15, 30, 50, -1],
				[15, 30, 50, "Все"]
			],
			processing: true,
			buttons: [{
				text: '<span class="glyphicon glyphicon-refresh"></span>',
				action: function(e, dt, node, config) {
					table_chet_linked.ajax.reload(null, false);
				}
			}],
			drawCallback: function() {

			}
		});
		// ----- ----- -----
		// Array to track the ids of the details displayed rows
		//
		var detailRows_chet_linked = [];
		$('#zayvview-chet-linked tbody').on('click', 'tr td.details-control', function() {
			var tr = $(this).closest('tr');
			var row = table_chet_linked.row(tr);
			var idx = $.inArray(tr.attr('id'), detailRows_chet_linked);

			if (row.child.isShown()) {
				tr.removeClass('details');
				row.child.hide();

				// Remove from the 'open' array
				detailRows_chet_linked.splice(idx, 1);
			} else {
				tr.addClass('details');
				rowData = table_chet_linked.row(row);
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
				rowData.child(<?php include('templates/zayvview-chet-linked-details.tpl'); ?>).show();

				// Add to the 'open' array
				if (idx === -1) {
					detailRows_chet_linked.push(tr.attr('id'));
				}
			}
		});
		//
		// On each draw, loop over the `detailRows` array and show any child rows
		table_chet_linked.on('draw', function() {
			$.each(detailRows_chet_linked, function(i, id) {
				$('#' + id + ' td.details-control').trigger('click');
			});
		});
		// ----- ----- -----
		// Обработчик формы редактора счетов
		editor_chet_linked.on('open', function(e) {
			$('#zayvview-chet-linked-kodzayv_filter').val('');
			// Поиск в ниспадающем списке по содержимому текстового поля для названия заявки
			$('#DTE_Field_dognet_doczayvchet-kodzayv').filterByText(editor_chet_linked, $('#zayvview-chet-linked-kodzayv_filter'), 'dognet_doczayvchet.kodzayv', false);
			//
			$('#zayvview-chet-linked-kodpost_filter').val('');
			// Поиск в ниспадающем списке по содержимому текстового поля для названия заявки
			$('#DTE_Field_dognet_doczayvchet-kodpost').filterByText(editor_chet_linked, $('#zayvview-chet-linked-kodpost_filter'), 'dognet_doczayvchet.kodpost', false);
			//
			$('#zayvview-chet-linked-kodpokup_filter').val('');
			// Поиск в ниспадающем списке по содержимому текстового поля для названия заявки
			$('#DTE_Field_dognet_doczayvchet-kodpokup').filterByText(editor_chet_linked, $('#zayvview-chet-linked-kodpokup_filter'), 'dognet_doczayvchet.kodpokup', false);

			editor_chet_linked.dependent('kodzayv_transfer_enbl', function(val) {
				if (val == 0) {
					editor_chet_linked.field('dognet_doczayvchet.kodzayv').disable();
					$('#zayvview-chet-linked-kodzayv_filter').prop('disabled', true);
				}
				if (val == 1) {
					editor_chet_linked.field('dognet_doczayvchet.kodzayv').enable();
					$('#zayvview-chet-linked-kodzayv_filter').prop('disabled', false);
				}
			});

		});
		editor_chet_linked.on('close', function(e) {
			table_chet_linked.ajax.reload(null, true);
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		// СВЯЗАННАЯ ЗАЯВКА
		//
		// ----- ----- -----
		// Обработчик формы редактирование заявки
		editor_zayv_linked = new $.fn.dataTable.Editor({
			display: "bootstrap",
			ajax: {
				url: "php/examples/php/zayvview/zayvview-chetf/dognet-zayvview-chetf_child_chet_child_zayv-process.php",
				data: function(d) {
					var selected = table_chet_linked.row({
						selected: true
					});
					if (selected.any()) {
						d.kodzayv = selected.data().dognet_doczayvchet.kodzayv;
					}
				}
			},
			table: "#zayvview-zayv-linked",
			i18n: {
				create: {
					title: "<h3>Новая заявка</h3>"
				},
				edit: {
					title: "<h3>Изменить заявку</h3>"
				},
				remove: {
					button: "Удалить",
					title: "<h3>Удалить заявку</h3>",
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
			template: '#customForm-zayv-linked',
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
				placeholder: "Тип заявки"
			}, {
				label: "Статус :",
				type: "select",
				name: "dognet_doczayv.tipusezayv",
				options: [{
						label: "Заявка сформирована",
						value: 0
					},
					{
						label: "Выставлена часть счетов",
						value: 1
					},
					{
						label: "Выставлены все счета",
						value: 4
					},
					{
						label: "Заявка закрыта",
						value: 2
					},
					{
						label: "Заявка аннулирована",
						value: 3
					}
				],
				def: "0",
				placeholder: "Статус заявки"
			}, {
				label: "Дата :",
				name: "dognet_doczayv.datezayv",
				type: "datetime",
				format: "DD.MM.YYYY",
				def: function() {
					return new Date();
				}
			}, {
				label: "Номер :",
				name: "dognet_doczayv.numberzayv"
			}, {
				label: "Описание заявки :",
				name: "dognet_doczayv.namerabfilespec",
				def: "Заявка"
				// ----- ----- -----
			}, {
				name: "dognet_doczayv.docFileID",
				type: "upload",
				display: function(id) {
					return '<a target="_blank" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet' + editor_zayv_linked.file('dognet_doczayv_files', id).file_webpath + '"><h4>СКАЧАТЬ ФАЙЛ</h4></a>';
				},
				dragDrop: false,
				dragDropText: "",
				fileReadText: "Файл загружается",
				noFileText: "Файл не прикреплен",
				processingText: "Файл загружен",
				uploadText: "Выберите файл"
			}, {
				type: "readonly",
				name: "dognet_doczayv.msgDocFileID"
				// ----- ----- -----
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_doczayv.kodusepoligon",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_doczayv.koduseobjwork",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				type: "hidden",
				name: "koddoc_tmp"
			}, {
				label: "",
				type: "checkbox",
				name: "kodusezayv_0",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				type: "checkbox",
				name: "kodusezayv_1",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				type: "checkbox",
				name: "kodusezayv_2",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_doczayv.kodrabzayv",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_doczayv.kodrabfile",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				type: "checkbox",
				name: "sendMessage",
				unselectedValue: 0,
				options: {
					"": 1
				}
			}]
		});
		// ----- ----- -----
		// Управление размером диалогового окна редактирования заявки
		editor_zayv_linked.on('open', function() {
			$(".modal-dialog").css({
				"width": "60%",
				"min-width": "800px",
				"max-width": "1024px"
			});
		});
		editor_zayv_linked.off('close', function() {
			$(".modal-dialog").css({
				"width": "80%",
				"min-width": "none",
				"max-width": "none"
			});
		});
		// ----- ----- -----
		// Обработчик формы редактора заявок
		editor_zayv_linked.on('preOpen', function() {
			editor_zayv_linked.field('koddoc_tmp').set(editor_zayv_linked.field('dognet_doczayv.koddoc').get());
			if (editor_zayv_linked.field('dognet_doczayv.koddoc').get() == "245375260650765") {
				editor_zayv_linked.field('kodusezayv_1').set(1);
			}
			if (editor_zayv_linked.field('dognet_doczayv.koddoc').get() == "245375544141726") {
				editor_zayv_linked.field('kodusezayv_2').set(1);
			}
		});
		editor_zayv_linked.on('open', function() {

			editor_zayv_linked.on('edit', function(e, json, data) {
				/*     alert( 'New server IP is: '+ data['sendMessage'] ); */
				return false;
			});

			$('#zayvview-zayv-linked-koddoc_filter').val('');
			if (($('#DTE_Field_dognet_doczayv-koddoc').value) != editor_zayv_linked.field('dognet_doczayv.koddoc').get()) {}
			// Поиск в ниспадающем списке по содержимому текстового поля для ответного документа
			$('#DTE_Field_dognet_doczayv-koddoc').filterByText(editor_zayv_linked, $('#zayvview-zayv-linked-koddoc_filter'), 'dognet_doczayv.koddoc', false);
			//
			editor_zayv_linked.dependent('kodusezayv_0', function(val) {
				if (val == 1) {
					editor_zayv_linked.field('dognet_doczayv.koddoc').set("000000000000000");
					editor_zayv_linked.field('dognet_doczayv.koddoc').disable();
					$('#zayvview-zayv-linked-koddoc_filter').prop('disabled', true);
					editor_zayv_linked.field('kodusezayv_1').disable();
					editor_zayv_linked.field('kodusezayv_2').disable();
				}
				if (val == 0) {
					editor_zayv_linked.field('dognet_doczayv.koddoc').set(editor_zayv_linked.field('koddoc_tmp').get());
					editor_zayv_linked.field('dognet_doczayv.koddoc').enable();
					$('#zayvview-zayv-linked-koddoc_filter').prop('disabled', false);
					editor_zayv_linked.field('kodusezayv_1').enable();
					editor_zayv_linked.field('kodusezayv_2').enable();
				}
			});
			//
			editor_zayv_linked.dependent('kodusezayv_1', function(val) {
				if (val == 1) {
					editor_zayv_linked.field('dognet_doczayv.koddoc').set("245375260650765");
					editor_zayv_linked.field('dognet_doczayv.koddoc').disable();
					$('#zayvview-zayv-linked-koddoc_filter').prop('disabled', true);
					editor_zayv_linked.field('kodusezayv_0').disable();
					editor_zayv_linked.field('kodusezayv_2').disable();
				}
				if (val == 0) {
					editor_zayv_linked.field('dognet_doczayv.koddoc').set(editor_zayv_linked.field('koddoc_tmp').get());
					editor_zayv_linked.field('dognet_doczayv.koddoc').enable();
					$('#zayvview-zayv-linked-koddoc_filter').prop('disabled', false);
					editor_zayv_linked.field('kodusezayv_0').enable();
					editor_zayv_linked.field('kodusezayv_2').enable();
				}
			});
			//
			editor_zayv_linked.dependent('kodusezayv_2', function(val) {
				if (val == 1) {
					editor_zayv_linked.field('dognet_doczayv.koddoc').set("245375544141726");
					editor_zayv_linked.field('dognet_doczayv.koddoc').disable();
					$('#zayvview-zayv-linked-koddoc_filter').prop('disabled', true);
					editor_zayv_linked.field('kodusezayv_0').disable();
					editor_zayv_linked.field('kodusezayv_1').disable();
				}
				if (val == 0) {
					editor_zayv_linked.field('dognet_doczayv.koddoc').set(editor_zayv_linked.field('koddoc_tmp').get());
					editor_zayv_linked.field('dognet_doczayv.koddoc').enable();
					$('#zayvview-zayv-linked-koddoc_filter').prop('disabled', false);
					editor_zayv_linked.field('kodusezayv_0').enable();
					editor_zayv_linked.field('kodusezayv_1').enable();
				}
			});
			//
			editor_zayv_linked.dependent('dognet_doczayv.kodrabfile', function(val) {
				if (val == 1) {
					editor_zayv_linked.field('dognet_doczayv.docFileID').enable();
					editor_zayv_linked.field('dognet_doczayv.docFileID').show();
				}
				if (val == 0) {
					editor_zayv_linked.field('dognet_doczayv.docFileID').disable();
					editor_zayv_linked.field('dognet_doczayv.docFileID').hide();
				}
			});
		});
		editor_zayv_linked.on('close', function() {
			table_zayv_linked.ajax.reload(null, false);
		});
		//
		editor_zayv_linked.on('initCreate', function(e) {
			editor_zayv_linked.field('dognet_doczayv.msgDocFileID').show();
			editor_zayv_linked.field('dognet_doczayv.msgDocFileID').val('Сначала создайте запись!');
			editor_zayv_linked.field('dognet_doczayv.docFileID').hide();
			editor_zayv_linked.field('dognet_doczayv.docFileID').disable();
		});
		editor_zayv_linked.on('initEdit', function(e, node, data, items, type) {
			editor_zayv_linked.field('dognet_doczayv.msgDocFileID').hide();
			editor_zayv_linked.field('dognet_doczayv.docFileID').show();
			editor_zayv_linked.field('dognet_doczayv.docFileID').enable();
		});
		editor_zayv_linked.on('postEdit', function(e, json, data, id) {
			return false;
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		// Обработчик таблицы заявок
		//
		table_zayv_linked = $('#zayvview-zayv-linked').DataTable({
			dom: "<'row'<'col-sm-5'B><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'l>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'><'col-sm-8'>>",
			// 		dom: "<'space50'r>tip",
			language: {
				url: "php/examples/simple/zayvview/zayvview-chetf/dt_russian-zayv-linked.json"
			},
			ajax: {
				url: "php/examples/php/zayvview/zayvview-chetf/dognet-zayvview-chetf_child_chet_child_zayv-process.php",
				type: "POST",
				data: function(d) {
					var selected = table_chet_linked.row({
						selected: true
					});
					if (selected.any()) {
						d.kodzayv = selected.data().dognet_doczayvchet.kodzayv;
						console.log("kodzayv linked :" + d.kodzayv);
					}
				}
			},
			serverSide: true,
			createdRow: function(row, data, index) {
				if (data.dognet_doczayv.koddoc == "000000000000000") {
					$('td', row).eq(6).addClass('highlight_0');
				} else if (data.dognet_doczayv.koddoc == "245375260650765") {
					$('td', row).eq(6).addClass('highlight_1');
				} else if (data.dognet_doczayv.koddoc == "245375544141726") {
					$('td', row).eq(6).addClass('highlight_2');
				} else {
					$('td', row).eq(6).addClass('highlight_td');
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
					data: "dognet_doczayv.tipusezayv"
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
						var txt1 = '';
						var txt2 = '';
						if (row.dognet_doczayv.kodrabfile == 1) {
							if (id) {
								txt1 = '<span style="padding:0 5px"><a class="" target="_blank" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet' + editor_zayv_linked.file('dognet_doczayv_files', id).file_webpath + '"><span class="glyphicon glyphicon-file"></span></a></span>';
							} else {
								txt1 = '';
							}
						}
						if (row.dognet_doczayv.kodrabzayv == 1) {
							txt2 = '<span style="padding:0 5px"><a href="#"><span class="glyphicon glyphicon-list-alt"></span></a></span>';
						} else {
							txt2 = '';
						}
						return txt1 + txt2;
					},
					defaultContent: "",
					className: "text-center"
				},
				{
					data: "dognet_doczayv.kodzayvtel"
				},
				{
					data: "dognet_docbase.docnumber"
				},
				{
					data: "dognet_doczayv.kodrabzayv"
				},
				{
					data: "dognet_docbase.koddoc"
				}
			],
			select: 'single',
			select: {
				toggleable: true
			},
			columnDefs: [{
					orderable: false,
					searchable: false,
					targets: 0
				},
				{
					orderable: false,
					searchable: true,
					render: function(data, type, row, meta) {
						if (data == '0') {
							return '<span class="glyphicon glyphicon-play-circle" title="Заявка сформирована"></span>';
						} else if (data == '1') {
							return '<span class="text-warning glyphicon glyphicon-credit-card" title="Есть выставленные счета"></span>';
						} else if (data == '2') {
							return '<span class="text-success glyphicon glyphicon-ok-circle" title="Заявка закрыта"></span>';
						} else if (data == '3') {
							return '<span class="text-danger glyphicon glyphicon-ban-circle" title="Заявка аннулирована"></span>';
						} else if (data == '4') {
							return '<span class="text-info glyphicon glyphicon-credit-card" title="Все счета выставлены"></span>';
						} else {
							return "";
						}
					},
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
					searchable: true,
					targets: 5
				},
				{
					orderable: false,
					searchable: true,
					render: function(data, type, row, meta) {
						if (data == '245375260650765') {
							return "На нужды АТГС";
						} else if (data == '245375544141726') {
							return "На склад";
						} else if (data == '000000000000000') {
							return "---";
						} else {
							return "Дог. 3-4/" + row.dognet_docbase.docnumber;
						}
					},
					targets: 6
				},
				{
					orderable: false,
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
					visible: false,
					searchable: true,
					targets: 10
				},
				{
					orderable: false,
					visible: false,
					searchable: true,
					targets: 11
				}
			],
			order: [
				[2, "desc"]
			],
			ordering: true,
			processing: true,
			paging: false,
			searching: true,
			searchCols: [null, null, null, null, null, null, null, null, null, null, null, null, null],
			pageLength: 15,
			lengthChange: false,
			lengthMenu: [
				[15, 30, 50, -1],
				[15, 30, 50, "Все"]
			],
			buttons: [{
				text: '<span class="glyphicon glyphicon-refresh"></span>',
				action: function(e, dt, node, config) {
					table_zayv_linked.ajax.reload(null, false);
				}
			}],
			drawCallback: function() {

			}
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		// Обработчик child-таблицы для выбранной заявки
		// Array to track the ids of the details displayed rows
		var detailRows_zayv_linked = [];
		$('#zayvview-zayv-linked tbody').on('click', 'tr td.details-control', function() {
			var tr = $(this).closest('tr');
			var row = table_zayv_linked.row(tr);
			var idx = $.inArray(tr.attr('id'), detailRows_zayv_linked);

			if (row.child.isShown()) {
				tr.removeClass('details');
				row.child.hide();

				// Remove from the 'open' array
				detailRows_zayv_linked.splice(idx, 1);
			} else {
				tr.addClass('details');
				rowData = table_zayv_linked.row(row);
				d = row.data();
				if (d.dognet_doczayv.koddoc == '245375260650765') {
					d.doczayv_obosn = "На нужды АТГС";
				} else if (d.dognet_doczayv.koddoc == '245375544141726') {
					d.doczayv_obosn = "На склад";
				} else if (d.dognet_doczayv.koddoc == '000000000000000') {
					d.doczayv_obosn = "Без договора";
				} else {
					d.doczayv_obosn = "Дог. 3-4/" + d.dognet_docbase.docnumber;
				}
				//
				if (d.dognet_doczayv.tipusezayv == '0') {
					d.doczayv_tipuse = "Заявка сформирована";
				} else if (d.dognet_doczayv.tipusezayv == '1') {
					d.doczayv_tipuse = "Выставлены все счета";
				} else if (d.dognet_doczayv.tipusezayv == '2') {
					d.doczayv_tipuse = "Заявка закрыта";
				} else if (d.dognet_doczayv.tipusezayv == '3') {
					d.doczayv_tipuse = "Заявка аннулирована";
				} else if (d.dognet_doczayv.tipusezayv == '4') {
					d.doczayv_tipuse = "Выставлены счета";
				} else {
					d.doczayv_tipuse = "";
				}
				rowData.child(<?php include('templates/zayvview-zayv-linked-details.tpl'); ?>).show();

				// Add to the 'open' array
				if (idx === -1) {
					detailRows_zayv_linked.push(tr.attr('id'));
				}
			}
		});
		// On each draw, loop over the `detailRows` array and show any child rows
		table_zayv_linked.on('draw', function() {
			$.each(detailRows_zayv_linked, function(i, id) {
				$('#' + id + ' td.details-control').trigger('click');
			});
		});
		// ----- ----- -----
		table_zayv_linked.button(0).action(function(e, dt, button, config) {
			console.log('Button ' + this.text() + ' activated');
			this.disable();
		});







		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		//
		// TAB #2 :::
		// ПЕРЕНОС СЧЕТОВ-ФАКТУР
		//
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		// СЧЕТ ТЕКУЩИЙ
		//
		// ----- ----- -----
		// Обработчик таблицы текущего счета
		table_chetf_transfer_chetfrom = $('#zayvview-chetf-transfer-chetfrom').DataTable({
			dom: "<'row'<'col-sm-5'><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'l>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'><'col-sm-8'>>",
			// 		dom: "<'space50'r>tip",
			language: {
				url: "php/examples/simple/zayvview/zayvview-chetf/dt_russian-chet-from.json"
			},
			ajax: {
				url: "php/examples/php/zayvview/zayvview-chetf/dognet-zayvview-chetf-transfer-chetfrom-process.php",
				type: "POST",
				data: function(d) {
					var selected = table_chetf_main.row({
						selected: true
					});
					if (selected.any()) {
						console.log(selected.data().dognet_doczayvchet.kodzayvchet);
						d.kodzayvchet_from = selected.data().dognet_doczayvchet.kodzayvchet;
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
					data: "dognet_doczayvchet.zayvchetcomment"
				},
				{
					data: "dognet_doczayvchet.zayvchetsumma"
				},
				{
					data: "dognet_doczayvchet.zayvchetpr"
				},
				{
					data: "dognet_doczayvchet.zayvchetzadol"
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
					render: function(data, type, row, meta) {
						return moment(data).format("DD.MM.YYYY");
					},
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
					searchable: true,
					targets: 5
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
					targets: 6
				},
				{
					orderable: false,
					searchable: true,
					render: function(data, type, row, meta) {
						return Math.round(data);
					},
					targets: 7
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
					targets: 8
				}
			],
			order: [
				[1, "desc"]
			],
			ordering: false,
			processing: false,
			paging: false,
			searching: true,
			pageLength: 15,
			lengthChange: false,
			lengthMenu: [
				[15, 30, 50, -1],
				[15, 30, 50, "Все"]
			],
			buttons: [],
			drawCallback: function() {

			}
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		// Array to track the ids of the details displayed rows
		var detailRows_chfFrom = [];
		$('#zayvview-chetf-transfer-chetfrom tbody').on('click', 'tr td.details-control', function() {
			var tr = $(this).closest('tr');
			var row = table_chetf_transfer_chetfrom.row(tr);
			var idx = $.inArray(tr.attr('id'), detailRows_chfFrom);

			if (row.child.isShown()) {
				tr.removeClass('details');
				row.child.hide();

				// Remove from the 'open' array
				detailRows_chfFrom.splice(idx, 1);
			} else {
				tr.addClass('details');
				rowData = table_chetf_transfer_chetfrom.row(row);
				d = row.data();
				rowData.child(<?php include('templates/zayvview-chetf-transfer-chetfrom-details.tpl'); ?>).show();

				// Add to the 'open' array
				if (idx === -1) {
					detailRows_chfFrom.push(tr.attr('id'));
				}
			}
		});
		//
		// On each draw, loop over the `detailRows_chfFrom` array and show any child rows
		table_chetf_transfer_chetfrom.on('draw', function() {
			$.each(detailRows_chfFrom, function(i, id) {
				$('#' + id + ' td.details-control').trigger('click');
			});
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		// СЧЕТ, НА КОТОРЫЙ ПРОИСХОДИТ ПЕРЕНОС
		//
		// ----- ----- -----
		// Обработчик формы редактирование счета-фактуры
		editor_chetf_transfer_chetto = new $.fn.dataTable.Editor({
			display: "bootstrap",
			ajax: {
				url: "php/examples/php/zayvview/zayvview-chetf/dognet-zayvview-chetf-transfer-process.php",
				data: function(d) {
					var selected_chf = table_chetf_main.row({
						selected: true
					});
					var selected_chFrom = table_chetf_transfer_chetfrom.row({
						selected: true
					});
					if (selected_chf.any()) {
						console.log("ID [chf] : " + selected_chf.data().dognet_doczayvchetf.ID);
						d.chf_ID = selected_chf.data().dognet_doczayvchetf.ID;
					}
					if (selected_chFrom.any()) {
						console.log("ID [ch_from] : " + selected_chFrom.data().dognet_doczayvchet.ID);
						d.chFrom_ID = selected_chFrom.data().dognet_doczayvchet.ID;
						d.chFrom_kodzayvchet = selected_chFrom.data().dognet_doczayvchet.kodzayvchet;
						date_chet = selected_chFrom.data().dognet_doczayvchet.zayvchetdate;
						console.log("Date [ch_from] : " + selected_chFrom.data().dognet_doczayvchet.zayvchetdate);
						d.chFrom_year = moment(date_chet).format("YYYY");
					}
				}
			},
			table: "#zayvview-chetf-transfer-chetto",
			i18n: {
				edit: {
					title: "<h3>Перенести счет-фактуру на другой счет</h3>"
				}
			},
			/* 			template: '#customForm-chet-transfer-chetto', */
			fields: [{
				label: "Новый счет :",
				name: "dognet_doczayvchetf.kodzayvchet",
				type: "hidden"
			}]
		});
		// ----- ----- -----
		// Управление размером диалогового окна редактирования заявки
		editor_chetf_transfer_chetto.on('open', function() {
			$(".modal-dialog").css({
				"width": "40%",
				"min-width": "640px",
				"max-width": "800px"
			});
		});
		editor_chetf_transfer_chetto.off('close', function() {
			$(".modal-dialog").css({
				"width": "80%",
				"min-width": "none",
				"max-width": "none"
			});
		});
		// ----- ----- -----
		// Обработчик формы редактора заявок
		editor_chetf_transfer_chetto.on('postSubmit', function() {
			table_chetf_main.ajax.reload(null, true);
			table_chetf_main.on('draw', function() {
				table_chetf_transfer_chetfrom.ajax.reload(null, false);
				table_chetf_transfer_chetfrom.on('draw', function() {
					table_chetf_transfer_chetto.ajax.reload(null, false);
				});
			});
		});
		// ----- ----- -----
		// Обработчик таблицы текущей заявки
		table_chetf_transfer_chetto = $('#zayvview-chetf-transfer-chetto').DataTable({
			dom: "<'row'<'col-sm-5'><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'l>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'B><'col-sm-8'p>>",
			// 		dom: "<'space50'r>tip",
			language: {
				url: "php/examples/simple/zayvview/zayvview-chetf/dt_russian-chet-to.json"
			},
			ajax: {
				url: "php/examples/php/zayvview/zayvview-chetf/dognet-zayvview-chetf-transfer-chetto-process.php",
				type: "POST",
				data: function(d) {
					var selected_chf = table_chetf_main.row({
						selected: true
					});
					var selected_chFrom = table_chetf_transfer_chetfrom.row({
						selected: true
					});
					if (selected_chf.any()) {
						console.log("ID [chf] : " + selected_chf.data().dognet_doczayvchetf.ID);
						d.chf_ID = selected_chf.data().dognet_doczayvchetf.ID;
					}
					if (selected_chFrom.any()) {
						console.log("ID [ch_from] : " + selected_chFrom.data().dognet_doczayvchet.ID);
						d.chFrom_ID = selected_chFrom.data().dognet_doczayvchet.ID;
						d.chFrom_kodzayvchet = selected_chFrom.data().dognet_doczayvchet.kodzayvchet;
						date_chet = selected_chFrom.data().dognet_doczayvchet.zayvchetdate;
						console.log("Date [ch_from] : " + selected_chFrom.data().dognet_doczayvchet.zayvchetdate);
						d.chFrom_year = moment(date_chet).format("YYYY");
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
					data: "dognet_doczayvchet.zayvchetcomment"
				},
				{
					data: "dognet_doczayvchet.zayvchetsumma"
				},
				{
					data: "dognet_doczayvchet.zayvchetpr"
				},
				{
					data: "dognet_doczayvchet.zayvchetzadol"
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
					render: function(data, type, row, meta) {
						return moment(data).format("DD.MM.YYYY");
					},
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
					searchable: true,
					targets: 5
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
					targets: 6
				},
				{
					orderable: false,
					searchable: true,
					render: function(data, type, row, meta) {
						return Math.round(data);
					},
					targets: 7
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
					targets: 8
				}
			],
			order: [
				[1, "desc"]
			],
			ordering: true,
			processing: true,
			paging: true,
			searching: false,
			pageLength: 10,
			lengthChange: false,
			lengthMenu: [
				[15, 30, 50, -1],
				[15, 30, 50, "Все"]
			],
			buttons: [{
					text: '<span class="glyphicon glyphicon-refresh"></span>',
					action: function(e, dt, node, config) {
						table_chetf_transfer_chetfrom.columns().search('');
						table_chetf_transfer_chetfrom.order([1, "desc"]).draw();
						table_chetf_transfer_chetto.columns().search('');
						table_chetf_transfer_chetto.order([1, "desc"]).draw();
					}
				},
				{
					extend: "edit",
					editor: editor_chetf_transfer_chetto,
					text: 'Перенести счет-фактуру',
					formButtons: ['Перенести',
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
		var detailRows_chfTo = [];
		$('#zayvview-chetf-transfer-chetto tbody').on('click', 'tr td.details-control', function() {
			var tr = $(this).closest('tr');
			var row = table_chetf_transfer_chetto.row(tr);
			var idx = $.inArray(tr.attr('id'), detailRows_chfTo);

			if (row.child.isShown()) {
				tr.removeClass('details');
				row.child.hide();

				// Remove from the 'open' array
				detailRows_chfTo.splice(idx, 1);
			} else {
				tr.addClass('details');
				rowData = table_chetf_transfer_chetto.row(row);
				d = row.data();
				rowData.child(<?php include('templates/zayvview-chetf-transfer-chetto-details.tpl'); ?>).show();

				// Add to the 'open' array
				if (idx === -1) {
					detailRows_chfTo.push(tr.attr('id'));
				}
			}
		});
		//
		// On each draw, loop over the `detailRows_chfTo` array and show any child rows
		table_chetf_transfer_chetto.on('draw', function() {
			$.each(detailRows_chfTo, function(i, id) {
				$('#' + id + ' td.details-control').trigger('click');
			});
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		//
		// TAB #3 :::
		// СЧЕТ-ФАКТУРА (АРХИВ)
		//
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		// СЧЕТ-ФАКТУРА (АРХИВ)
		//
		editor_chetf_archive = new $.fn.dataTable.Editor({
			display: "bootstrap",
			ajax: {
				url: "php/examples/php/zayvview/zayvview-chetf/dognet-zayvview-chetf-main-process.php"
			},
			table: "#zayvview-chetf-archive",
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
			fields: []
		});
		// ----- ----- -----
		table_chetf_archive = $('#zayvview-chetf-archive').DataTable({
			dom: "<'row'<'col-sm-6'B><'col-sm-4'<'#toolbar_msg'>><'col-sm-2'l>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'p>>",
			// 		dom: "<'space50'r>tip",
			language: {
				url: "php/examples/simple/zayvview/zayvview-chetf/dt_russian-chetf-main.json"
			},
			ajax: {
				url: "php/examples/php/zayvview/zayvview-chetf/dognet-zayvview-chetf-archive-process.php",
				type: "POST"
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
					data: "dognet_doczayv.numberzayv",
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
					render: function(id) {
						return id ?
							'<a class="" target="_blank" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet' + editor_chetf_archive.file('dognet_doczayvchetf_files', id).file_webpath + '"><span class="glyphicon glyphicon-file"></span></a>' :
							'<span class="glyphicon glyphicon-option-horizontal"></span>';
					},
					defaultContent: "",
					className: "text-center"
				},
				{
					data: "dognet_sptipzayvall.kodtipzayvall"
				},
				{
					data: "dognet_doczayv.numberzayv"
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
					type: "date",
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
					searchable: false,
					render: function(data, type, row, meta) {
						return row.dognet_sptipzayvall.nametipzayvshotall + "-" + data;
					},
					targets: 4
				},
				{
					orderable: false,
					searchable: true,
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
					targets: 7
				},
				{
					orderable: false,
					searchable: false,
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
					visible: false,
					searchable: true,
					targets: 10
				}
			],
			order: [
				[1, "desc"]
			],
			ordering: true,
			paging: true,
			searching: true,
			searchCols: [null, {
				search: "XXXX"
			}, null, null, null, null, null, null, null, null],
			pageLength: 15,
			lengthChange: false,
			lengthMenu: [
				[15, 30, 50, -1],
				[15, 30, 50, "Все"]
			],
			processing: true,
			buttons: [{
				text: '<span class="glyphicon glyphicon-refresh"></span>',
				action: function(e, dt, node, config) {
					// 					table_chetf_archive.columns(1).search(moment().format("YYYY"));
					table_chetf_archive.columns(1).search('');
					table_chetf_archive.order([1, "desc"]).draw();
				}
			}],
			drawCallback: function() {

			}
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		// Array to track the ids of the details displayed rows
		//
		var detailRows_archive = [];
		$('#zayvview-chetf-archive tbody').on('click', 'tr td.details-control', function() {
			var tr = $(this).closest('tr');
			var row = table_chetf_archive.row(tr);
			var idx = $.inArray(tr.attr('id'), detailRows_archive);

			if (row.child.isShown()) {
				tr.removeClass('details');
				row.child.hide();

				// Remove from the 'open' array
				detailRows_archive.splice(idx, 1);
			} else {
				tr.addClass('details');
				rowData = table_chetf_archive.row(row);
				d = row.data();
				rowData.child(<?php include('templates/zayvview-chetf-details.tpl'); ?>).show();

				// Add to the 'open' array
				if (idx === -1) {
					detailRows_archive.push(tr.attr('id'));
				}
			}
		});
		//
		// On each draw, loop over the `detailRows_archive` array and show any child rows
		table_chetf_archive.on('draw', function() {
			$.each(detailRows_archive, function(i, id) {
				$('#' + id + ' td.details-control').trigger('click');
			});
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		//
		//
		//
		//
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		// Обработчики событий таблицы счетов-фактур
		table_chetf_main.on('select', function() {
			table_chet_linked.ajax.reload(null, false);
			table_chet_linked.on('draw', function() {
				table_zayv_linked.buttons().enable();
				table_zayv_linked.ajax.reload(null, false);
			});
			//
			table_chetf_transfer_chetfrom.ajax.reload(null, false);
			table_chetf_transfer_chetfrom.on('draw', function() {
				table_chetf_transfer_chetto.buttons().enable();
				table_chetf_transfer_chetto.ajax.reload(null, false);
			});
		});
		table_chetf_main.on('deselect', function() {
			table_chet_linked.ajax.reload(null, false);
			table_chet_linked.on('draw', function() {
				table_zayv_linked.buttons().disable();
				table_zayv_linked.ajax.reload(null, false);
			});
			//
			table_chetf_transfer_chetfrom.ajax.reload(null, false);
			table_chetf_transfer_chetfrom.on('draw', function() {
				table_chetf_transfer_chetto.buttons().disable();
				table_chetf_transfer_chetto.ajax.reload(null, false);
			});
		});
		table_chet_linked.on('select', function() {
			table_zayv_linked.ajax.reload(null, false);
		});
		table_chet_linked.on('deselect', function() {
			table_zayv_linked.ajax.reload(null, false);
		});
		table_chetf_transfer_chetfrom.on('select', function() {
			table_chetf_transfer_chetto.buttons().enable();
			table_chetf_transfer_chetto.ajax.reload(null, false);
		});
		table_chetf_transfer_chetfrom.on('deselect', function() {
			table_chetf_transfer_chetto.buttons().disable();
			table_chetf_transfer_chetto.ajax.reload(null, false);
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		//
		$('#zayvview-chetf-search_btnApply').click(function(e) {
			table_chetf_main
				.columns(1)
				.search($("#chfYearSearch_text").val())
				.draw();

			table_chetf_main
				.columns(2)
				.search($("#chfNumberSearch_text").val())
				.draw();

			table_chetf_main
				.columns(3)
				.search($("#chNumberSearch_text").val())
				.draw();

			table_chetf_main
				.columns(5)
				.search($("#chCommentSearch_text").val())
				.draw();

			table_chetf_main
				.columns(6)
				.search($("#chPostavSearch_text").val())
				.draw();
		});
		$('#zayvview-chetf-search_btnClear').click(function(e) {
			$('#chfYearSearch_text').val('<?php echo date("Y"); ?>');
			$('#chfNumberSearch_text').val('');
			$('#chNumberSearch_text').val('');
			$('#chCommentSearch_text').val('');
			$('#chPostavSearch_text').val('');
			table_chetf_main
				.columns()
				.search('')
				.draw();
		});
		// ----- ----- -----
		$("#chfNumberSearch_text").on("keyup", function(event) {
			if (event.keyCode === 13) {
				event.preventDefault();
				document.getElementById("zayvview-chetf-search_btnApply").click();
			}
		});
		$("#chNumberSearch_text").on("keyup", function(event) {
			if (event.keyCode === 13) {
				event.preventDefault();
				document.getElementById("zayvview-chetf-search_btnApply").click();
			}
		});
		$("#chCommentSearch_text").on("keyup", function(event) {
			if (event.keyCode === 13) {
				event.preventDefault();
				document.getElementById("zayvview-chetf-search_btnApply").click();
			}
		});
		$("#chPostavSearch_text").on("keyup", function(event) {
			if (event.keyCode === 13) {
				event.preventDefault();
				document.getElementById("zayvview-chetf-search_btnApply").click();
			}
		});
		//
		//
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		//
		$('#zayvview-chetf-archive-search_btnApply').click(function(e) {
			table_chetf_archive
				.columns(1)
				.search($("#chfYearSearchInArchive_text").val())
				.draw();

			table_chetf_archive
				.columns(2)
				.search($("#chfNumberSearchInArchive_text").val())
				.draw();

			table_chetf_archive
				.columns(3)
				.search($("#chNumberSearchInArchive_text").val())
				.draw();

			table_chetf_archive
				.columns(5)
				.search($("#chfCommentSearchInArchive_text").val())
				.draw();
		});
		$('#zayvview-chetf-archive-search_btnClear').click(function(e) {
			$('#chfYearSearchInArchive_text').val('');
			$('#chfNumberSearchInArchive_text').val('');
			$('#chNumberSearchInArchive_text').val('');
			$('#chfCommentSearchInArchive_text').val('');
			table_chetf_archive
				.columns()
				.search('')
				.draw();
		});
		// ----- ----- -----
		$("#chfNumberSearchInArchive_text").on("keyup", function(event) {
			if (event.keyCode === 13) {
				event.preventDefault();
				document.getElementById("zayvview-chetf-archive-search_btnApply").click();
			}
		});
		$("#chNumberSearchInArchive_text").on("keyup", function(event) {
			if (event.keyCode === 13) {
				event.preventDefault();
				document.getElementById("zayvview-chetf-archive-search_btnApply").click();
			}
		});
		$("#chfCommentSearchInArchive_text").on("keyup", function(event) {
			if (event.keyCode === 13) {
				event.preventDefault();
				document.getElementById("zayvview-chetf-archive-search_btnApply").click();
			}
		});
		//
		//
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		//
	});
</script>
<?php
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Форма редактирования счета-фактуры
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/zayvview/zayvview-chetf/restr_5/css/zayvview-chetf-main-customform.css">
<div id="customForm-chetf-main">
	<div id="customForm-chetf-main-editor-tabs" style="width:100%">
		<ul id="customForm-chetf-main-editor-tabs-menu" class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#customForm-chetf-main-editor-tab-1" title="">Параметры</a></li>
			<li><a data-toggle="tab" href="#customForm-chetf-main-editor-tab-2" title="">Примечание</a></li>
			<li><a data-toggle="tab" href="#customForm-chetf-main-editor-tab-3" title="">Файл</a></li>
		</ul>
		<div class="tab-content" style="padding:5px">
			<div id="customForm-chetf-main-editor-tab-1" class="tab-pane fade in active">
				<div class="Section">
					<div class="Block100">
						<legend>Счет</legend>
						<fieldset class="field60">
							<editor-field name="dognet_doczayvchetf.kodzayvchet"></editor-field>
						</fieldset>
						<fieldset class="field40 kodzayvchetFilter" style="padding:7px 15px 0;">
							<input id="zayvview-chetf-main-kodzayvchet_filter" type="text" placeholder="Поиск счета" />
						</fieldset>
					</div>
					<div class="Block50">
						<legend>Статус и номер</legend>
						<fieldset class="field100">
							<editor-field name="dognet_doczayvchetf.zayvchetfnumber"></editor-field>
						</fieldset>
						<fieldset class="field100">
							<editor-field name="dognet_doczayvchetf.kodusevalid"></editor-field>
						</fieldset>
					</div>
					<div class="Block50">
						<legend>Дата и сумма</legend>
						<fieldset class="field100">
							<editor-field name="dognet_doczayvchetf.zayvchetfdate"></editor-field>
						</fieldset>
						<fieldset class="field100">
							<editor-field name="dognet_doczayvchetf.zayvchetfsumma"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
			<div id="customForm-chetf-main-editor-tab-2" class="tab-pane fade">
				<div class="Section">
					<div class="Block100">
						<legend>Примечание к счету-фактуре</legend>
						<fieldset class="field100">
							<editor-field name="dognet_doczayvchetf.zayvchetfcomment"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
			<div id="customForm-chetf-main-editor-tab-3" class="tab-pane fade">
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
// ----- ----- ----- ----- -----
// Подключаем стили для таблицы счетов
// :::
?>
<div id="tab-1" class="tab-pane fade in active">

	<div class="space30"></div>
	<div class="col-xs-12 space30" style="padding:10px; background-color:#fafafa">
		<h4 class="space20 text-uppercase" style="color:#31708f; font-family:'Oswald', sans-serif; font-weight:400; letter-spacing:0.4em; padding-bottom:5px; border-bottom:4px #fff solid">Фильтры для поиска счета-фактуры</h4>
		<div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
			<div class="form-group space10" style="width:100%">
				<label for="chfYearSearch_text"><b>Год :</b></label>
				<select name="chfYearSearch_text" id="chfYearSearch_text" class="form-control">
					<option value="<?php echo date("Y"); ?>"><?php echo date("Y"); ?></option>
					<option value="<?php echo (date("Y") - 1); ?>"><?php echo (date("Y") - 1); ?></option>
				</select>
			</div>
		</div>
		<div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
			<div class="form-group space10" style="width:100%">
				<label for="chfNumberSearch_text"><b>Номер СФ :</b></label>
				<input type="text" id="chfNumberSearch_text" class="form-control" placeholder="Все номера" name="chfNumberSearch_text">
			</div>
		</div>
		<div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
			<div class="form-group space10" style="width:100%">
				<label for="chNumberSearch_text"><b>Номер счета :</b></label>
				<input type="text" id="chNumberSearch_text" class="form-control" placeholder="Все номера" name="chNumberSearch_text">
			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
			<div class="input-group space10" style="width:100%">
				<label for="chCommentSearch_text"><b>Примечание к счету :</b></label>
				<input type="text" id="chCommentSearch_text" class="form-control" placeholder="Текст для поиска" name="chCommentSearch_text">
			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
			<div class="input-group space10" style="width:100%">
				<label for="chPostavSearch_text"><b>Поставщик :</b></label>
				<input type="text" id="chPostavSearch_text" class="form-control" placeholder="Текст для поиска" name="chPostavSearch_text">
			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 text-right">
			<div class="input-group-btn" style="padding-top:25px">
				<button id="zayvview-chetf-search_btnApply" class="btn btn-default" type="button">Применить</button>
				<button id="zayvview-chetf-search_btnClear" class="btn btn-default" type="button"><i class="glyphicon glyphicon-remove"></i></button>
			</div>
		</div>
	</div>

	<?php // ----- ----- ----- ----- ----- 
	?>

	<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/zayvview/zayvview-chetf/restr_5/css/zayvview-chetf-main.css">
	<div class="demo-html"></div>
	<table id="zayvview-chetf-main" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
				<th>Дата</th>
				<th>Счет-фактура</th>
				<th>Счет</th>
				<th>Заявка</th>
				<th>Прим. к счету</th>
				<th>Поставщик</th>
				<th>Сумма</th>
				<th>Статус</th>
				<th><span class="glyphicon glyphicon-file"></span></th>
				<th></th>
				<th></th>
				<th><span class="glyphicon glyphicon-send"></span></th>
			</tr>
		</thead>
	</table>

	<?php // ----- ----- ----- ----- ----- 
	?>

	<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/zayvview/zayvview-chetf/restr_5/css/zayvview-chet-linked.css">
	<div class="space30"></div>
	<div class="col-xs-12 space30" style="padding:10px; background-color:#fafafa">
		<h4 class="text-uppercase" style="color:#31708f; font-family:'Oswald', sans-serif; font-weight:400; letter-spacing:0.4em">Связанный счет</h4>
	</div>
	<div class="demo-html"></div>
	<table id="zayvview-chet-linked" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
				<th>Дата</th>
				<th>Счет №</th>
				<th>Заявка</th>
				<th>Поставщик</th>
				<th>Примечание</th>
				<th>Сумма</th>
				<th>%</th>
				<th>Задолж</th>
				<th><span class="glyphicon glyphicon-file"></span></th>
				<th></th>
				<th></th>
				<th></th>
			</tr>
		</thead>
	</table>

	<?php // ----- ----- ----- ----- ----- 
	?>

	<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/zayvview/zayvview-chetf/restr_5/css/zayvview-zayv-linked.css">
	<div class="space30"></div>
	<div class="col-xs-12 space30" style="padding:10px; background-color:#fafafa">
		<h4 class="text-uppercase" style="color:#31708f; font-family:'Oswald', sans-serif; font-weight:400; letter-spacing:0.4em">Связанная заявка</h4>
	</div>
	<div class="demo-html"></div>
	<table id="zayvview-zayv-linked" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
				<th></th>
				<th>Дата</th>
				<th>Тип</th>
				<th>№</th>
				<th>Описание заявки</th>
				<th>Обоснование</th>
				<th>Спец</th>
				<th></th>
				<th></th>
				<th></th>
			</tr>
		</thead>
	</table>

</div>

<?php // ----- ----- ----- ----- ----- 
?>

<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/zayvview/zayvview-chetf/restr_5/css/zayvview-chetf-transfer-chetfrom.css">
<div id="tab-2" class="tab-pane fade">
	<div class="space30"></div>
	<div class="col-xs-12 space30" style="padding:10px; background-color:#fafafa">
		<h4 class="text-uppercase" style="color:#31708f; font-family:'Oswald', sans-serif; font-weight:400; letter-spacing:0.4em">Перенос счета-фактуры со счета на счет</h4>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 space10">
		<div id="chetf-transfer-from">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<h4 class="transfer-title-from"><span>Откуда</span></h4>
					<div class="demo-html"></div>
					<table id="zayvview-chetf-transfer-chetfrom" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
								<th>Дата</th>
								<th>Счет №</th>
								<th>Заявка</th>
								<th>Поставщик</th>
								<th>Примечание</th>
								<th>Сумма</th>
								<th>%</th>
								<th>Остаток</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
	<?php // ----- ----- ----- ----- ----- 
	?>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div id="chetf-transfer-to">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<h4 class="transfer-title-to"><span>Куда</span></h4>
					<div class="demo-html"></div>
					<table id="zayvview-chetf-transfer-chetto" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
								<th>Дата</th>
								<th>Счет №</th>
								<th>Заявка</th>
								<th>Поставщик</th>
								<th>Примечание</th>
								<th>Сумма</th>
								<th>%</th>
								<th>Остаток</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<?php // ----- ----- ----- ----- ----- 
?>

<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/zayvview/zayvview-chetf/restr_5/css/zayvview-chetf-transfer-chetto.css">
<div id="tab-3" class="tab-pane fade">
	<div class="space30"></div>
	<div class="col-xs-12 space30" style="padding:10px; background-color:#fafafa">
		<h4 class="space20 text-uppercase" style="color:#31708f; font-family:'Oswald', sans-serif; font-weight:400; letter-spacing:0.4em; padding-bottom:5px; border-bottom:4px #fff solid">Фильтры для поиска счета-фактуры</h4>
		<div class="col-xs-12 col-sm-4 col-md-1 col-lg-1">
			<div class="form-group space10" style="width:100%">
				<label for="chfYearSearchInArchive_text"><b>Год :</b></label>
				<select name="chfYearSearchInArchive_text" id="chfYearSearchInArchive_text" class="form-control">
					<option value='---'>---</option>
					<?php
					$_QRY = mysqlQuery("SELECT MIN(zayvchetdate) as minchetdate, MAX(zayvchetdate) as maxchetdate FROM dognet_doczayvchet WHERE koddel<>'99'");
					$_ROW = mysqli_fetch_assoc($_QRY);
					for ($y = 2005; $y < date("Y"); $y++) {
					?>
						<option value='<?php echo $y; ?>'><?php echo $y; ?></option>
					<?php
					}
					?>
				</select>
			</div>
		</div>
		<div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
			<div class="form-group space10" style="width:100%">
				<label for="chfNumberSearchInArchive_text"><b>Номер счета-фактуры :</b></label>
				<input type="text" id="chfNumberSearchInArchive_text" class="form-control" placeholder="Все номера" name="chfNumberSearchInArchive_text">
			</div>
		</div>
		<div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
			<div class="form-group space10" style="width:100%">
				<label for="chNumberSearchInArchive_text"><b>Номер счета :</b></label>
				<input type="text" id="chNumberSearchInArchive_text" class="form-control" placeholder="Все номера" name="chNumberSearchInArchive_text">
			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
			<div class="input-group space10" style="width:100%">
				<label for="chfCommentSearchInArchive_text"><b>Примечание к счету-фактуре :</b></label>
				<input type="text" id="chfCommentSearchInArchive_text" class="form-control" placeholder="Текст для поиска" name="chfCommentSearchInArchive_text">
			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 text-right">
			<div class="input-group-btn" style="padding-top:25px">
				<button id="zayvview-chetf-archive-search_btnApply" class="btn btn-default" type="button">Применить</button>
				<button id="zayvview-chetf-archive-search_btnClear" class="btn btn-default" type="button"><i class="glyphicon glyphicon-remove"></i></button>
			</div>
		</div>
	</div>

	<?php // ----- ----- ----- ----- ----- 
	?>

	<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/zayvview/zayvview-chetf/restr_5/css/zayvview-chetf-archive.css">
	<div class="demo-html"></div>
	<table id="zayvview-chetf-archive" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
				<th>Дата</th>
				<th>Счет-фактура</th>
				<th>Счет</th>
				<th>Заявка</th>
				<th>Примечание</th>
				<th>Сумма</th>
				<th>Статус</th>
				<th><span class="glyphicon glyphicon-file"></span></th>
			</tr>
		</thead>
	</table>
</div>