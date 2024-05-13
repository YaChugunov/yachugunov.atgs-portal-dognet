<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/moment-with-locales.js"></script>
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/filterByText.js"></script>


<script type="text/javascript" language="javascript" class="init">
	function addZero(digits_length, source) {
		var text = source + '';
		while (text.length < digits_length)
			text = '0' + text;
		return text;
	}

	var table_chet_main;
	var table_chet_chetf;
	var table_chet_archive;
	var editor_chet_main;
	var editor_chet_chetf;

	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

	$(document).ready(function() {
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		//
		// TAB #1 :::
		// СЧЕТ И СЧЕТ-ФАКТУРА
		//
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		// СЧЕТ
		//
		editor_chet_main = new $.fn.dataTable.Editor({
			display: "bootstrap",
			ajax: {
				url: "php/examples/php/zayvview/zayvview-chet/dognet-zayvview-chet-main-process.php",
				data: function(d) {
					var selected = table_chet_main.row({
						selected: true
					});
					if (selected.any()) {
						d.zayvchetdate = selected.data().dognet_doczayvchet.zayvchetdate;
						console.log("zayvchetdate: " + d.zayvchetdate)
					}
				}
			},
			table: "#zayvview-chet-main",
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
			template: '#customForm-chet-main',
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
					return '<a target="_blank" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet' + editor_chet_main.file('dognet_doczayvchet_files', id).file_webpath + '"><h4>СКАЧАТЬ ФАЙЛ</h4></a>';
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
		editor_chet_main.on('open', function() {
			$(".modal-dialog").css({
				"width": "50%",
				"min-width": "640px",
				"max-width": "800px"
			});
		});
		editor_chet_main.off('close', function() {
			$(".modal-dialog").css({
				"width": "80%",
				"min-width": "none",
				"max-width": "none"
			});
		});
		editor_chet_main.on('initCreate', function(e) {
			editor_chet_main.field('dognet_doczayvchet.msgDocFileID').show();
			editor_chet_main.field('dognet_doczayvchet.msgDocFileID').val('Сначала создайте запись!');
			editor_chet_main.field('dognet_doczayvchet.docFileID').hide();
			editor_chet_main.field('dognet_doczayvchet.docFileID').disable();
		});
		editor_chet_main.on('initEdit', function(e, node, data, items, type) {
			editor_chet_main.field('dognet_doczayvchet.msgDocFileID').hide();
			editor_chet_main.field('dognet_doczayvchet.docFileID').show();
			editor_chet_main.field('dognet_doczayvchet.docFileID').enable();
		});
		// ----- ----- -----
		table_chet_main = $('#zayvview-chet-main').DataTable({
			dom: "<'row'<'col-sm-5'B><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'l>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'p>>",
			// 		dom: "<'space50'r>tip",
			language: {
				url: "php/examples/simple/zayvview/zayvview-chet/dt_russian-chet-main.json"
			},
			ajax: {
				url: "php/examples/php/zayvview/zayvview-chet/dognet-zayvview-chet-main-process.php",
				type: "POST",
				data: function(d) {
					var selected = table_chet_main.row({
						selected: true
					});
					if (selected.any()) {
						d.zayvchetdate = selected.data().dognet_doczayvchet.zayvchetdate;
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
						return id ? '<a class="" target="_blank" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet' + editor_chet_main.file('dognet_doczayvchet_files', id).file_webpath + '"><span class="glyphicon glyphicon-file"></span></a>' : '<span class="glyphicon glyphicon-option-horizontal"></span>';
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
			select: {
				style: 'single',
				selector: 'td:not(:nth-child(10))'
			},
			createdRow: function(row, data, index) {
				if (data.dognet_doczayvchet.zayvchetpr < 100.00 || data.dognet_doczayvchet.zayvchetzadol > 0.00) {
					$('td', row).eq(7).addClass('highlight_warning');
					$('td', row).eq(8).addClass('highlight_warning');
				}
				if (data.dognet_doczayvchet.zayvchetpr > 100.00 || data.dognet_doczayvchet.zayvchetzadol < 0.00) {
					$('td', row).eq(7).addClass('highlight_alarm');
					$('td', row).eq(8).addClass('highlight_alarm');
				}
				$('[data-toggle="tooltip"]', row).tooltip();
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
						comment = (row.dognet_doczayv.zayvchetcom != "") ? "<span style='float:right'><a href='#' data-toggle='tooltip' data-placement='top' title='" + row.dognet_doczayv.zayvchetcom + "' style='color:#999'><span class='glyphicon glyphicon-comment'></span></a></span>" : "";
						return "<abbr title=''><a href='#' data-toggle='tooltip' data-placement='top' title='" + row.dognet_doczayv.namerabfilespec + "'>" + row.dognet_sptipzayvall.nametipzayvshotall + "-" + data + "</a></abbr>" + comment;
					},
					targets: 3
				},
				{
					orderable: false,
					searchable: true,
					render: function(data, type, row, meta) {
						fullstr = data;
						if (fullstr != null) {
							if (data.length > 25) {
								return data.substr(0, 25) + " ...";
							} else {
								return data;
							}
						} else {
							return "";
						}
					},
					targets: 4
				},
				{
					orderable: false,
					searchable: true,
					render: function(data, type, row, meta) {
						fullstr = data;
						if (fullstr != null) {
							if (data.length > 35) {
								return data.substr(0, 35) + " ...";
							} else {
								return data;
							}
						} else {
							return "";
						}
					},
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
					/* 				render: function ( data, type, row, meta ) { return Math.round(data); }, */
					render: function(data, type, row, meta) {
						return parseFloat(data).toFixed(2);
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
					searchable: false,
					targets: 12,
					render: function(data, type, row, meta) {
						/* 					return ''+'<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/dognet-zayvview.php?zayvview_type=chet&uniqueID='+row.dognet_doczayvchet.kodzayvchet+'&mailing=yes&msgType="><span class="glyphicon glyphicon-send"></span></a>'; */
						return '';
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
						$('#chNumberSearch_text').val('');
						$('#chYearSearch_text').val('');
						$('#chCommentSearch_text').val('');
						$('#zayvTipSearch_text').val('');
						$('#zayvNumberSearch_text').val('');
						$('#chZadolSearch_text').val('');
						table_chet_main.columns().search('');
						table_chet_main.order([1, "desc"]).draw();
					}
				},
				{
					extend: "create",
					editor: editor_chet_main,
					text: "ДОБАВИТЬ СЧЕТ",
					formButtons: ['Добавить счет',
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
		//
		var detailRows = [];
		$('#zayvview-chet-main tbody').on('click', 'tr td.details-control', function() {
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
				rowData.child(<?php include('templates/zayvview-chet-details.tpl'); ?>).show();

				// Add to the 'open' array
				if (idx === -1) {
					detailRows.push(tr.attr('id'));
				}
			}
		});
		//
		// On each draw, loop over the `detailRows` array and show any child rows
		table_chet_main.on('draw', function() {
			$.each(detailRows, function(i, id) {
				$('#' + id + ' td.details-control').trigger('click');
			});
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		// Обработчик формы редактора счетов
		editor_chet_main.on('open', function(e) {
			$('#zayvview-chet-main-kodzayv_filter').val('');
			// Поиск в ниспадающем списке по содержимому текстового поля для названия заявки
			$('#DTE_Field_dognet_doczayvchet-kodzayv').filterByText(editor_chet_main, $('#zayvview-chet-main-kodzayv_filter'), 'dognet_doczayvchet.kodzayv', false);
			//
			$('#zayvview-chet-main-kodpost_filter').val('');
			// Поиск в ниспадающем списке по содержимому текстового поля для названия заявки
			$('#DTE_Field_dognet_doczayvchet-kodpost').filterByText(editor_chet_main, $('#zayvview-chet-main-kodpost_filter'), 'dognet_doczayvchet.kodpost', false);
			//
			$('#zayvview-chet-main-kodpokup_filter').val('');
			// Поиск в ниспадающем списке по содержимому текстового поля для названия заявки
			$('#DTE_Field_dognet_doczayvchet-kodpokup').filterByText(editor_chet_main, $('#zayvview-chet-main-kodpokup_filter'), 'dognet_doczayvchet.kodpokup', false);

			editor_chet_main.dependent('kodzayv_transfer_enbl', function(val) {
				if (val == 0) {
					editor_chet_main.field('dognet_doczayvchet.kodzayv').disable();
					$('#zayvview-chet-main-kodzayv_filter').prop('disabled', true);
				}
				if (val == 1) {
					editor_chet_main.field('dognet_doczayvchet.kodzayv').enable();
					$('#zayvview-chet-main-kodzayv_filter').prop('disabled', false);
				}
			});

		});
		editor_chet_main.on('close', function(e) {
			table_chet_main.ajax.reload(null, true);
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		// СЧЕТ-ФАКТУРА
		//
		// ----- ----- -----
		// Обработчик формы редактирование счета-фактуры
		editor_chet_chetf = new $.fn.dataTable.Editor({
			display: "bootstrap",
			ajax: {
				url: "php/examples/php/zayvview/zayvview-chet/dognet-zayvview-chet_child_chetfact-process.php",
				data: function(d) {
					var selected = table_chet_main.row({
						selected: true
					});
					if (selected.any()) {
						d.kodzayvchet = selected.data().dognet_doczayvchet.kodzayvchet;
					}
				}
			},
			table: "#zayvview-chet-chetf",
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
			template: '#customForm-chet-chetf',
			fields: [{
				label: "№ С/Ф :",
				name: "dognet_doczayvchetf.zayvchetfnumber"
			}, {
				label: "Дата С/Ф :",
				name: "dognet_doczayvchetf.zayvchetfdate",
				type: "datetime",
				format: "DD.MM.YYYY"
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
					return '<a target="_blank" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet' + editor_chet_chetf.file('dognet_doczayvchetf_files', id).file_webpath + '"><h4>СКАЧАТЬ ФАЙЛ</h4></a>';
				}
			}, {
				type: "readonly",
				name: "dognet_doczayvchetf.msgDocFileID"
				// ----- ----- -----
			}]
		});
		// ----- ----- -----
		// Управление размером диалогового окна редактирования счета-фактуры
		editor_chet_chetf.on('open', function() {
			$(".modal-dialog").css({
				"width": "50%",
				"min-width": "640px",
				"max-width": "800px"
			});
		});
		editor_chet_chetf.off('close', function() {
			$(".modal-dialog").css({
				"width": "80%",
				"min-width": "none",
				"max-width": "none"
			});
		});
		// ----- ----- -----
		// Обработчики событий редактора счета-фактуры
		editor_chet_chetf.on('initCreate', function(e) {
			editor_chet_chetf.field('dognet_doczayvchetf.msgDocFileID').show();
			editor_chet_chetf.field('dognet_doczayvchetf.msgDocFileID').val('Сначала создайте запись!');
			editor_chet_chetf.field('dognet_doczayvchetf.docFileID').hide();
			editor_chet_chetf.field('dognet_doczayvchetf.docFileID').disable();
		});
		editor_chet_chetf.on('initEdit', function(e, node, data, items, type) {
			editor_chet_chetf.field('dognet_doczayvchetf.msgDocFileID').hide();
			editor_chet_chetf.field('dognet_doczayvchetf.docFileID').show();
			editor_chet_chetf.field('dognet_doczayvchetf.docFileID').enable();
		});
		editor_chet_chetf.on('submitSuccess', function() {
			table_chet_main.ajax.reload(null, false);
		});
		// ----- ----- -----
		// Обработчик таблицы счетов-фактур
		table_chet_chetf = $('#zayvview-chet-chetf').DataTable({
			dom: "<'row'<'col-md-8 col-sm-12'B><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'>>",
			language: {
				url: "php/examples/simple/zayvview/zayvview-chet/dt_russian-chet-child-chetf.json"
			},
			ajax: {
				url: "php/examples/php/zayvview/zayvview-chet/dognet-zayvview-chet_child_chetfact-process.php",
				type: 'post',
				data: function(d) {
					var selected = table_chet_main.row({
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
					data: "dognet_doczayvchet.zayvchetnumber",
					className: ""
				},
				{
					data: "dognet_doczayvchetf.zayvchetfsumma",
					className: ""
				},
				{
					data: "dognet_doczayvchetf.zayvchetfcomment",
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
							'<a class="" target="_blank" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet' + editor_chet_chetf.file('dognet_doczayvchetf_files', id).file_webpath + '"><span class="glyphicon glyphicon-file"></span></a>' :
							'<span class="glyphicon glyphicon-option-horizontal"></span>';
					},
					defaultContent: "",
					className: "text-center"
				},
				{
					data: null,
					className: ""
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
					targets: 8,
					render: function(data, type, row, meta) {
						return '' + '<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/dognet-zayvview.php?zayvview_type=chetf&uniqueID=' + row.dognet_doczayvchetf.kodzayvchetf + '&mailing=yes&msgType="><span class="glyphicon glyphicon-send"></span></a>';
					}
				}
			],
			order: [
				[1, "desc"]
			],
			buttons: [{
					text: '<span class="glyphicon glyphicon-refresh"></span>',
					action: function(e, dt, node, config) {
						table_chet_chetf.ajax.reload();
						table_chet_chetf.columns().search('').draw();
						table_chet_chetf.order([1, "desc"]).draw();
					}
				},
				{
					extend: "create",
					editor: editor_chet_chetf,
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
					editor: editor_chet_chetf,
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
					editor: editor_chet_chetf,
					text: '<span class="glyphicon glyphicon-remove"></span>'
				}
			]
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		// Array to track the ids of the details displayed rows
		var detailRows_chet_chetf = [];
		$('#zayvview-chet-chetf tbody').on('click', 'tr td.details-control', function() {
			var tr = $(this).closest('tr');
			var row = table_chet_chetf.row(tr);
			var idx = $.inArray(tr.attr('id'), detailRows_chet_chetf);

			if (row.child.isShown()) {
				tr.removeClass('details');
				row.child.hide();

				// Remove from the 'open' array
				detailRows_chet_chetf.splice(idx, 1);
			} else {
				tr.addClass('details');
				rowData = table_chet_chetf.row(row);
				d = row.data();
				rowData.child(<?php include('templates/zayvview-chet-chetf-details.tpl'); ?>).show();

				// Add to the 'open' array
				if (idx === -1) {
					detailRows_chet_chetf.push(tr.attr('id'));
				}
			}
		});
		//
		// On each draw, loop over the `detailRows_chet_chetf` array and show any child rows
		table_chet_chetf.on('draw', function() {
			$.each(detailRows_chet_chetf, function(i, id) {
				$('#' + id + ' td.details-control').trigger('click');
			});
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		//
		// TAB #2 :::
		// ПЕРЕНОС СЧЕТОВ
		//
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		// ЗАЯВКА ТЕКУЩАЯ
		//
		// ----- ----- -----
		// Обработчик таблицы текущей заявки
		table_chet_transfer_zayvfrom = $('#zayvview-chet-transfer-zayvfrom').DataTable({
			dom: "<'row'<'col-sm-5'><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'l>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'><'col-sm-8'>>",
			// 		dom: "<'space50'r>tip",
			language: {
				url: "php/examples/simple/zayvview/zayvview-chet/dt_russian-zayv-from.json"
			},
			ajax: {
				url: "php/examples/php/zayvview/zayvview-chet/dognet-zayvview-chet-transfer-zayvfrom-process.php",
				type: "POST",
				data: function(d) {
					var selected = table_chet_main.row({
						selected: true
					});
					if (selected.any()) {
						d.kodzayv_from = selected.data().dognet_doczayv.kodzayv;
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
					data: "dognet_spzayvtel.namezayvtelshot"
				},
				{
					data: "dognet_doczayv.namerabfilespec"
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
					render: function(data, type, row, meta) {
						if (data == '0') {
							return '<span class="glyphicon glyphicon-play-circle"></span>';
						} else if (data == '1') {
							return '<span class="text-warning glyphicon glyphicon-credit-card"></span>';
						} else if (data == '2') {
							return '<span class="text-success glyphicon glyphicon-ok-circle"></span>';
						} else if (data == '3') {
							return '<span class="glyphicon glyphicon-ban-circle"></span>';
						} else if (data == '4') {
							return '<span class="text-danger glyphicon glyphicon-credit-card"></span>';
						} else {
							return "";
						}
					},
					targets: 1
				},
				{
					orderable: true,
					searchable: true,
					render: function(data, type, row, meta) {
						return moment(data).format("DD.MM.YYYY");
					},
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
					targets: 6
				}
			],
			order: [
				[2, "desc"]
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
			buttons: [{
				text: '<span class="glyphicon glyphicon-refresh"></span>',
				action: function(e, dt, node, config) {
					table_chet_transfer_zayvfrom.columns().search('');
					table_chet_transfer_zayvfrom.order([2, "desc"]).draw();
				}
			}],
			drawCallback: function() {

			}
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		// Array to track the ids of the details displayed rows
		var detailRows_zayvFrom = [];
		$('#zayvview-chet-transfer-zayvfrom tbody').on('click', 'tr td.details-control', function() {
			var tr = $(this).closest('tr');
			var row = table_chet_transfer_zayvfrom.row(tr);
			var idx = $.inArray(tr.attr('id'), detailRows_zayvFrom);

			if (row.child.isShown()) {
				tr.removeClass('details');
				row.child.hide();

				// Remove from the 'open' array
				detailRows_zayvFrom.splice(idx, 1);
			} else {
				tr.addClass('details');
				rowData = table_chet_transfer_zayvfrom.row(row);
				d = row.data();
				rowData.child(<?php include('templates/zayvview-chet-transfer-zayvfrom-details.tpl'); ?>).show();

				// Add to the 'open' array
				if (idx === -1) {
					detailRows_zayvFrom.push(tr.attr('id'));
				}
			}
		});
		//
		// On each draw, loop over the `detailRows_zayvFrom` array and show any child rows
		table_chet_transfer_zayvfrom.on('draw', function() {
			$.each(detailRows_zayvFrom, function(i, id) {
				$('#' + id + ' td.details-control').trigger('click');
			});
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		// ЗАЯВКА, НА КОТОРУЮ ПРОИСХОДИТ ПЕРЕНОС
		//
		// ----- ----- -----
		// Обработчик формы редактирование счета
		editor_chet_transfer_zayvto = new $.fn.dataTable.Editor({
			display: "bootstrap",
			ajax: {
				url: "php/examples/php/zayvview/zayvview-chet/dognet-zayvview-chet-transfer-process.php",
				data: function(d) {
					var selected = table_chet_main.row({
						selected: true
					});
					if (selected.any()) {
						console.log(selected.data().dognet_doczayvchet.ID);
						d.chRowID = selected.data().dognet_doczayvchet.ID;
					}
				}
			},
			table: "#zayvview-chet-transfer-zayvto",
			i18n: {
				edit: {
					title: "<h3>Перенести счет на другую заявку</h3>"
				}
			},
			/* 			template: '#customForm-chet-transfer-zayvto', */
			fields: [{
				label: "Новая заявка :",
				name: "dognet_doczayvchet.kodzayv",
				type: "hidden"
			}]
		});
		// ----- ----- -----
		// Управление размером диалогового окна редактирования заявки
		editor_chet_transfer_zayvto.on('open', function() {
			$(".modal-dialog").css({
				"width": "40%",
				"min-width": "640px",
				"max-width": "800px"
			});
		});
		editor_chet_transfer_zayvto.off('close', function() {
			$(".modal-dialog").css({
				"width": "80%",
				"min-width": "none",
				"max-width": "none"
			});
		});
		// ----- ----- -----
		// Обработчик формы редактора заявок
		editor_chet_transfer_zayvto.on('postSubmit', function() {
			table_chet_main.ajax.reload(null, true);
			table_chet_main.on('draw', function() {
				table_chet_transfer_zayvfrom.ajax.reload(null, false);
				table_chet_transfer_zayvfrom.on('draw', function() {
					table_chet_transfer_zayvto.ajax.reload(null, false);
				});
			});
		});
		// ----- ----- -----
		// Обработчик таблицы текущей заявки
		table_chet_transfer_zayvto = $('#zayvview-chet-transfer-zayvto').DataTable({
			dom: "<'row'<'col-sm-5'><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'l>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'B><'col-sm-8'p>>",
			// 		dom: "<'space50'r>tip",
			language: {
				url: "php/examples/simple/zayvview/zayvview-chet/dt_russian-zayv-to.json"
			},
			ajax: {
				url: "php/examples/php/zayvview/zayvview-chet/dognet-zayvview-chet-transfer-zayvto-process.php",
				type: "POST",
				data: function(d) {
					var selected = table_chet_transfer_zayvfrom.row({
						selected: true
					});
					if (selected.any()) {
						date_zayv = selected.data().dognet_doczayv.datezayv;
						d.zayvfrom_year = moment(date_zayv).format("YYYY");
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
					data: "dognet_spzayvtel.namezayvtelshot"
				},
				{
					data: "dognet_doczayv.namerabfilespec"
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
					render: function(data, type, row, meta) {
						if (data == '0') {
							return '<span class="glyphicon glyphicon-play-circle"></span>';
						} else if (data == '1') {
							return '<span class="text-warning glyphicon glyphicon-credit-card"></span>';
						} else if (data == '2') {
							return '<span class="text-success glyphicon glyphicon-ok-circle"></span>';
						} else if (data == '3') {
							return '<span class="glyphicon glyphicon-ban-circle"></span>';
						} else if (data == '4') {
							return '<span class="text-danger glyphicon glyphicon-credit-card"></span>';
						} else {
							return "";
						}
					},
					targets: 1
				},
				{
					orderable: true,
					searchable: true,
					render: function(data, type, row, meta) {
						return moment(data).format("DD.MM.YYYY");
					},
					targets: 2
				},
				{
					orderable: true,
					searchable: true,
					targets: 3
				},
				{
					orderable: true,
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
					targets: 6
				}
			],
			order: [
				[3, "asc"],
				[4, "asc"]
			],
			ordering: true,
			processing: false,
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
						table_chet_transfer_zayvto.columns().search('');
						table_chet_transfer_zayvto.order([2, "desc"]).draw();
					}
				},
				{
					extend: "edit",
					editor: editor_chet_transfer_zayvto,
					text: 'Перенести счет',
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
		var detailRows_zayvTo = [];
		$('#zayvview-chet-transfer-zayvto tbody').on('click', 'tr td.details-control', function() {
			var tr = $(this).closest('tr');
			var row = table_chet_transfer_zayvto.row(tr);
			var idx = $.inArray(tr.attr('id'), detailRows_zayvTo);

			if (row.child.isShown()) {
				tr.removeClass('details');
				row.child.hide();

				// Remove from the 'open' array
				detailRows_zayvTo.splice(idx, 1);
			} else {
				tr.addClass('details');
				rowData = table_chet_transfer_zayvto.row(row);
				d = row.data();
				rowData.child(<?php include('templates/zayvview-chet-transfer-zayvto-details.tpl'); ?>).show();

				// Add to the 'open' array
				if (idx === -1) {
					detailRows_zayvTo.push(tr.attr('id'));
				}
			}
		});
		//
		// On each draw, loop over the `detailRows_zayvTo` array and show any child rows
		table_chet_transfer_zayvto.on('draw', function() {
			$.each(detailRows_zayvTo, function(i, id) {
				$('#' + id + ' td.details-control').trigger('click');
			});
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		//
		// TAB #3 :::
		// СЧЕТ И СЧЕТ-ФАКТУРА (АРХИВ)
		//
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		// СЧЕТ (АРХИВ)
		//
		editor_chet_archive = new $.fn.dataTable.Editor({
			display: "bootstrap",
			ajax: {
				url: "php/examples/php/zayvview/zayvview-chet/dognet-zayvview-chet-archive-process.php",
				data: function(d) {
					var selected = table_chet_archive.row({
						selected: true
					});
					if (selected.any()) {
						d.zayvchetdate = selected.data().dognet_doczayvchet.zayvchetdate;
						console.log("zayvchetdate: " + d.zayvchetdate)
					}
				}
			},
			table: "#zayvview-chet-archive",
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
			fields: [{
				name: "dognet_doczayvchet.docFileID",
				type: "upload",
				display: function(id) {
					return '<a target="_blank" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet' + editor_chet_main.file('dognet_doczayvchet_files', id).file_webpath + '"><h4>СКАЧАТЬ ФАЙЛ</h4></a>';
				},
				dragDrop: false,
				dragDropText: "",
				fileReadText: "Файл загружается",
				noFileText: "Файл не прикреплен",
				processingText: "Файл загружен",
				uploadText: "Выберите файл"
			}]
		});
		// ----- ----- -----
		table_chet_archive = $('#zayvview-chet-archive').DataTable({
			dom: "<'row'<'col-sm-5'B><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'l>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'p>>",
			// 		dom: "<'space50'r>tip",
			language: {
				url: "php/examples/simple/zayvview/zayvview-chet/dt_russian-chet-main.json"
			},
			ajax: {
				url: "php/examples/php/zayvview/zayvview-chet/dognet-zayvview-chet-archive-process.php",
				type: "POST",
				data: function(d) {
					var selected = table_chet_archive.row({
						selected: true
					});
					if (selected.any()) {
						d.zayvchetdate = selected.data().dognet_doczayvchet.zayvchetdate;
					}
				}
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
						return id ? '<a class="" target="_blank" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet' + editor_chet_archive.file('dognet_doczayvchet_files', id).file_webpath + '"><span class="glyphicon glyphicon-file"></span></a>' : '<span class="glyphicon glyphicon-option-horizontal"></span>';
					},
					defaultContent: "",
					className: "text-center"
				},
				{
					data: "dognet_doczayv.kodtipzayvall"
				},
				{
					data: "dognet_doczayvchet.controlzadol"
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
					$('#chNumberSearch_text').val('');
					$('#chYearSearch_text').val('');
					$('#chCommentSearch_text').val('');
					$('#zayvTipSearch_text').val('');
					$('#zayvNumberSearch_text').val('');
					table_chet_archive.columns().search('');
					table_chet_archive.order([1, "desc"]).draw();
				}
			}],
			drawCallback: function() {

			}
		});
		// ----- ----- -----
		// Array to track the ids of the details displayed rows
		var detailRows_archive = [];
		$('#zayvview-chet-archive tbody').on('click', 'tr td.details-control', function() {
			var tr = $(this).closest('tr');
			var row = table_chet_archive.row(tr);
			var idx = $.inArray(tr.attr('id'), detailRows_archive);

			if (row.child.isShown()) {
				tr.removeClass('details');
				row.child.hide();

				// Remove from the 'open' array
				detailRows_archive.splice(idx, 1);
			} else {
				tr.addClass('details');
				rowData = table_chet_archive.row(row);
				d = row.data();
				rowData.child(<?php include('templates/zayvview-chet-archive-details.tpl'); ?>).show();

				// Add to the 'open' array
				if (idx === -1) {
					detailRows_archive.push(tr.attr('id'));
				}
			}
		});
		//
		// On each draw, loop over the `detailRows_archive` array and show any child rows
		table_chet_archive.on('draw', function() {
			$.each(detailRows_archive, function(i, id) {
				$('#' + id + ' td.details-control').trigger('click');
			});
		});
		// ----- ----- -----
		//
		// СЧЕТ-ФАКТУРА (АРХИВ)
		//
		// ----- ----- -----
		editor_chet_archive_chetf = new $.fn.dataTable.Editor({
			display: "bootstrap",
			ajax: {
				url: "php/examples/php/zayvview/zayvview-chet/dognet-zayvview-chet_archive_child_chetfact-process.php",
				data: function(d) {
					var selected = table_chet_archive.row({
						selected: true
					});
					if (selected.any()) {
						d.kodzayvchet = selected.data().dognet_doczayvchet.kodzayvchet;
					}
				}
			},
			table: "#zayvview-chet-archive-chetf",
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
		// Обработчик таблицы счетов-фактур для архивных счетов
		table_chet_archive_chetf = $('#zayvview-chet-archive-chetf').DataTable({
			dom: "<'row'<'col-md-8 col-sm-12'B><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'>>",
			language: {
				url: "php/examples/simple/zayvview/zayvview-chet/dt_russian-chet-child-chetf.json"
			},
			ajax: {
				url: "php/examples/php/zayvview/zayvview-chet/dognet-zayvview-chet_archive_child_chetfact-process.php",
				type: 'post',
				data: function(d) {
					var selected_archive = table_chet_archive.row({
						selected: true
					});
					if (selected_archive.any()) {
						d.kodzayvchet_archive = selected_archive.data().dognet_doczayvchet.kodzayvchet;
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
					data: "dognet_doczayvchet.zayvchetnumber",
					className: ""
				},
				{
					data: "dognet_doczayvchetf.zayvchetfsumma",
					className: ""
				},
				{
					data: "dognet_doczayvchetf.zayvchetfcomment",
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
							'<a class="" target="_blank" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet' + editor_chet_archive_chetf.file('dognet_doczayvchetf_files', id).file_webpath + '"><span class="glyphicon glyphicon-file"></span></a>' :
							'<span class="glyphicon glyphicon-option-horizontal"></span>';
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
				[1, "desc"]
			],
			buttons: [{
				text: '<span class="glyphicon glyphicon-refresh"></span>',
				action: function(e, dt, node, config) {
					table_chet_archive_chetf.ajax.reload();
					table_chet_archive_chetf.columns().search('').draw();
					table_chet_archive_chetf.order([1, "desc"]).draw();
				}
			}]
		});
		// ----- ----- -----
		// Array to track the ids of the details displayed rows
		var detailRows_chet_archive_chetf = [];
		$('#zayvview-chet-archive-chetf tbody').on('click', 'tr td.details-control', function() {
			var tr = $(this).closest('tr');
			var row = table_chet_archive_chetf.row(tr);
			var idx = $.inArray(tr.attr('id'), detailRows_chet_archive_chetf);

			if (row.child.isShown()) {
				tr.removeClass('details');
				row.child.hide();

				// Remove from the 'open' array
				detailRows_chet_archive_chetf.splice(idx, 1);
			} else {
				tr.addClass('details');
				rowData = table_chet_archive_chetf.row(row);
				d = row.data();
				rowData.child(<?php include('templates/zayvview-chet-chetf-details.tpl'); ?>).show();

				// Add to the 'open' array
				if (idx === -1) {
					detailRows_chet_archive_chetf.push(tr.attr('id'));
				}
			}
		});
		//
		// On each draw, loop over the `detailRows_chet_archive_chetf` array and show any child rows
		table_chet_archive_chetf.on('draw', function() {
			$.each(detailRows_chet_archive_chetf, function(i, id) {
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
		// Обработчики событий основной таблицы счетов
		table_chet_main.on('select', function() {
			table_chet_chetf.buttons().enable();
			table_chet_chetf.ajax.reload(null, false);
			table_chet_transfer_zayvfrom.ajax.reload(null, false);
			table_chet_transfer_zayvfrom.on('draw', function() {
				table_chet_transfer_zayvto.buttons().enable();
				table_chet_transfer_zayvto.ajax.reload(null, false);
			});
			var selected_chet = table_chet_main.row({
				selected: true
			});
			var ch_number = selected_chet.data().dognet_doczayvchet.zayvchetnumber;
			var ch_date = selected_chet.data().dognet_doczayvchet.zayvchetdate;
			$("#chet-to-move").html("<span style='background-color:#31708f; color:#fff; letter-spacing:normal'>№ " + ch_number + " <span style='text-transform:lowercase'>от</span> " + ch_date + "</span>");
		});
		table_chet_main.on('deselect', function() {
			// Обрабатываем форму счетов-фактур (chfsubpodr)
			table_chet_chetf.buttons().disable();
			table_chet_chetf.row({
				selected: true
			}).deselect();
			table_chet_chetf.ajax.reload(null, false);
			table_chet_transfer_zayvfrom.ajax.reload(null, false);
			table_chet_transfer_zayvfrom.on('draw', function() {
				table_chet_transfer_zayvto.buttons().disable();
				table_chet_transfer_zayvto.ajax.reload(null, false);
			});
			$("#chet-to-move").html("");
		});
		table_chet_transfer_zayvfrom.on('select', function() {
			table_chet_transfer_zayvto.buttons().enable();
			table_chet_transfer_zayvto.ajax.reload(null, false);
		});
		table_chet_transfer_zayvfrom.on('deselect', function() {
			table_chet_transfer_zayvto.buttons().disable();
			table_chet_transfer_zayvto.ajax.reload(null, false);
		});

		// Обработчики событий архивной таблицы счетов
		table_chet_archive.on('select', function() {
			table_chet_archive_chetf.buttons().enable();
			table_chet_archive_chetf.ajax.reload(null, false);
		});
		table_chet_archive.on('deselect', function() {
			// Обрабатываем форму счетов-фактур (chfsubpodr)
			table_chet_archive_chetf.buttons().disable();
			table_chet_archive_chetf.row({
				selected: true
			}).deselect();
			table_chet_archive_chetf.ajax.reload(null, false);
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		//
		$('#zayvview-chet-search_btnApply').click(function(e) {
			table_chet_main
				.columns(2)
				.search($("#chNumberSearch_text").val())
				.draw();

			table_chet_main
				.columns(1)
				.search($("#chYearSearch_text").val())
				.draw();

			table_chet_main
				.columns(5)
				.search($("#chCommentSearch_text").val())
				.draw();

			table_chet_main
				.columns(10)
				.search($("#zayvTipSearch_text").val())
				.draw();

			table_chet_main
				.columns(3)
				.search($("#zayvNumberSearch_text").val())
				.draw();

			table_chet_main
				.columns(11)
				.search($("#chZadolSearch_text").val())
				.draw();

			table_chet_main
				.columns(4)
				.search($("#chPostavSearch_text").val())
				.draw();
		});

		$('#zayvview-chet-search_btnClear').click(function(e) {
			$('#chNumberSearch_text').val('');
			$('#chYearSearch_text').val('');
			$('#chCommentSearch_text').val('');
			$('#zayvTipSearch_text').val('');
			$('#zayvNumberSearch_text').val('');
			$('#chZadolSearch_text').val('');
			$('#chPostavSearch_text').val('');
			table_chet_main
				.columns()
				.search("")
				.draw();
		});
		// ----- ----- -----
		$("#chNumberSearch_text").on("keyup", function(event) {
			if (event.keyCode === 13) {
				event.preventDefault();
				document.getElementById("zayvview-chet-search_btnApply").click();
			}
		});
		$("#chCommentSearch_text").on("keyup", function(event) {
			if (event.keyCode === 13) {
				event.preventDefault();
				document.getElementById("zayvview-chet-search_btnApply").click();
			}
		});
		$("#zayvNumberSearch_text").on("keyup", function(event) {
			if (event.keyCode === 13) {
				event.preventDefault();
				document.getElementById("zayvview-chet-search_btnApply").click();
			}
		});
		$("#chPostavSearch_text").on("keyup", function(event) {
			if (event.keyCode === 13) {
				event.preventDefault();
				document.getElementById("zayvview-chet-search_btnApply").click();
			}
		});
		//
		//
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		//
		$('#zayvview-chet-archive-search_btnApply').click(function(e) {
			table_chet_archive
				.columns(2)
				.search($("#chNumberSearchInArchive_text").val())
				.draw();

			table_chet_archive
				.columns(1)
				.search($("#chYearSearchInArchive_text").val())
				.draw();

			table_chet_archive
				.columns(6)
				.search($("#chCommentSearchInArchive_text").val())
				.draw();

			table_chet_archive
				.columns(10)
				.search($("#zayvTipSearchInArchive_text").val())
				.draw();

			table_chet_archive
				.columns(3)
				.search($("#zayvNumberSearchInArchive_text").val())
				.draw();

			table_chet_archive
				.columns(4)
				.search($("#chPostavSearchInArchive_text").val())
				.draw();
		});
		$('#zayvview-chet-archive-search_btnClear').click(function(e) {
			$('#chNumberSearchInArchive_text').val('');
			$('#chYearSearchInArchive_text').val('');
			$('#chCommentSearchInArchive_text').val('');
			$('#zayvTipSearchInArchive_text').val('');
			$('#zayvNumberSearchInArchive_text').val('');
			table_chet_archive
				.columns()
				.search('')
				.draw();
		});
		// ----- ----- -----
		$("#chNumberSearchInArchive_text").on("keyup", function(event) {
			if (event.keyCode === 13) {
				event.preventDefault();
				document.getElementById("zayvview-chet-archive-search_btnApply").click();
			}
		});
		$("#chCommentSearchInArchive_text").on("keyup", function(event) {
			if (event.keyCode === 13) {
				event.preventDefault();
				document.getElementById("zayvview-chet-archive-search_btnApply").click();
			}
		});
		$("#zayvNumberSearchInArchive_text").on("keyup", function(event) {
			if (event.keyCode === 13) {
				event.preventDefault();
				document.getElementById("zayvview-chet-archive-search_btnApply").click();
			}
		});
		$("#chPostavSearchInArchive_text").on("keyup", function(event) {
			if (event.keyCode === 13) {
				event.preventDefault();
				document.getElementById("zayvview-chet-archive-search_btnApply").click();
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
// Форма редактирования счета
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/zayvview/zayvview-chet/restr_4/css/zayvview-chet-main-customform.css">
<div id="customForm-chet-main">
	<div id="customForm-chet-main-editor-tabs" style="width:100%">
		<ul id="customForm-chet-main-editor-tabs-menu" class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#customForm-chet-main-editor-tab-1" title="">Параметры</a></li>
			<li><a data-toggle="tab" href="#customForm-chet-main-editor-tab-2" title="">Поставщик</a></li>
			<li><a data-toggle="tab" href="#customForm-chet-main-editor-tab-3" title="">Примечание</a></li>
			<li><a data-toggle="tab" href="#customForm-chet-main-editor-tab-4" title="">Файл</a></li>
		</ul>
		<div class="tab-content" style="padding:5px">
			<div id="customForm-chet-main-editor-tab-1" class="tab-pane fade in active">
				<div class="Section">
					<div class="Block100">
						<legend>Заявка</legend>
						<div class="Block100 fieldset-table-row">
							<div class="fieldset-table-cell" style="padding-bottom:3px">
								<fieldset>
									<editor-field name="kodzayv_transfer_enbl"></editor-field>
								</fieldset>
							</div>
							<div class="fieldset-table-cell" style="width:100%">
								<div>
									<div class="chekbox-inline-text">Перенести счет на другую заявку (в пределах прошлого/текущего годов)</div>
								</div>
							</div>
						</div>
						<fieldset class="field60">
							<editor-field name="dognet_doczayvchet.kodzayv"></editor-field>
						</fieldset>
						<fieldset class="field40 kodzayvFilter" style="padding:7px 15px 0;">
							<input id="zayvview-chet-main-kodzayv_filter" type="text" placeholder="Поиск заявки" />
						</fieldset>
					</div>
					<div class="Block100">
						<legend>Параметры счета</legend>
						<fieldset class="field40">
							<editor-field name="dognet_doczayvchet.zayvchetnumber"></editor-field>
						</fieldset>
						<fieldset class="field30">
							<editor-field name="dognet_doczayvchet.zayvchetdate"></editor-field>
						</fieldset>
						<fieldset class="field30">
							<editor-field name="dognet_doczayvchet.zayvchetsumma"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
			<div id="customForm-chet-main-editor-tab-2" class="tab-pane fade">
				<div class="Section">
					<div class="Block100">
						<legend>Поставщик</legend>
						<fieldset class="field60">
							<editor-field name="dognet_doczayvchet.kodpost"></editor-field>
						</fieldset>
						<fieldset class="field40 kodpostFilter" style="padding:7px 15px 0;">
							<input id="zayvview-chet-main-kodpost_filter" type="text" placeholder="Поиск поставщика" />
						</fieldset>
					</div>
					<div class="Block100">
						<legend>Покупатель</legend>
						<fieldset class="field60">
							<editor-field name="dognet_doczayvchet.kodpokup"></editor-field>
						</fieldset>
						<fieldset class="field40 kodpokupFilter" style="padding:7px 15px 0;">
							<input id="zayvview-chet-main-kodpokup_filter" type="text" placeholder="Поиск покупателя" />
						</fieldset>
					</div>
				</div>
			</div>
			<div id="customForm-chet-main-editor-tab-3" class="tab-pane fade">
				<div class="Section">
					<div class="Block100">
						<legend>Примечание к счету</legend>
						<fieldset class="field100">
							<editor-field name="dognet_doczayvchet.zayvchetcomment"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
			<div id="customForm-chet-main-editor-tab-4" class="tab-pane fade">
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
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/zayvview/zayvview-chet/restr_4/css/zayvview-chet-chetf-customform.css">
<div id="customForm-chet-chetf">
	<div id="customForm-chet-chetf-editor-tabs" style="width:100%">
		<ul id="customForm-chet-chetf-editor-tabs-menu" class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#customForm-chet-chetf-editor-tab-1" title="">Параметры</a></li>
			<li><a data-toggle="tab" href="#customForm-chet-chetf-editor-tab-2" title="">Примечание</a></li>
			<li><a data-toggle="tab" href="#customForm-chet-chetf-editor-tab-3" title="">Файл</a></li>
		</ul>
		<div class="tab-content" style="padding:5px">
			<div id="customForm-chet-chetf-editor-tab-1" class="tab-pane fade in active">
				<div class="Section">
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
			<div id="customForm-chet-chetf-editor-tab-2" class="tab-pane fade">
				<div class="Section">
					<div class="Block100">
						<legend>Примечание к счету-фактуре</legend>
						<fieldset class="field100">
							<editor-field name="dognet_doczayvchetf.zayvchetfcomment"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
			<div id="customForm-chet-chetf-editor-tab-3" class="tab-pane fade">
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
		<h4 class="space20 text-uppercase" style="color:#31708f; font-family:'Oswald', sans-serif; font-weight:400; letter-spacing:0.4em; padding-bottom:5px; border-bottom:4px #fff solid">Фильтры для поиска счета</h4>
		<div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
			<div class="form-group space10" style="width:100%">
				<label for="chYearSearch_text"><b>Год :</b></label>
				<select name="chYearSearch_text" id="chYearSearch_text" class="form-control">
					<option value="<?php echo date("Y"); ?>"><?php echo date("Y"); ?></option>
					<option value="<?php echo (date("Y") - 1); ?>"><?php echo (date("Y") - 1); ?></option>
					<option value="<?php echo (date("Y") - 2); ?>"><?php echo (date("Y") - 2); ?></option>
				</select>
			</div>
		</div>
		<div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
			<div class="form-group space10" style="width:100%">
				<label for="chNumberSearch_text"><b>Номер счета :</b></label>
				<input type="text" id="chNumberSearch_text" class="form-control" placeholder="Все номера" name="chNumberSearch_text">
			</div>
		</div>
		<div class="col-xs-6 col-sm-3 col-md-1 col-lg-1">
			<div class="input-group space10" style="width:100%">
				<label for="zayvTipSearch_text"><b>Тип :</b></label>
				<select name="zayvTipSearch_text" id="zayvTipSearch_text" class="form-control">
					<option value="">Все</option>
					<?php
					$_QRY3 = mysqlQuery("SELECT kodtipzayvall, nametipzayvshotall FROM dognet_sptipzayvall WHERE nametipzayvshotall<>'' AND koddel<>'99'");
					while ($_ROW3 = mysqli_fetch_assoc($_QRY3)) {
					?>
						<option value='<?php echo $_ROW3["kodtipzayvall"]; ?>'><?php echo $_ROW3["nametipzayvshotall"]; ?></option>
					<?php
					}
					?>
				</select>
			</div>
		</div>
		<div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
			<div class="form-group space10" style="width:100%">
				<label for="zayvNumberSearch_text"><b>№ заявки :</b></label>
				<input type="text" id="zayvNumberSearch_text" class="form-control" placeholder="Все номера" name="zayvNumberSearch_text">
			</div>
		</div>
		<div class="col-xs-6 col-sm-12 col-md-3 col-lg-3">
			<div class="input-group space10" style="width:100%">
				<label for="chCommentSearch_text"><b>Примечание к счету :</b></label>
				<input type="text" id="chCommentSearch_text" class="form-control" placeholder="Текст для поиска" name="chCommentSearch_text">
			</div>
		</div>
		<div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
			<div class="form-group space10" style="width:100%">
				<label for="chZadolSearch_text"><b>Задол :</b></label>
				<select name="chZadolSearch_text" id="chZadolSearch_text" class="form-control">
					<option value="">Все</option>
					<option value="0">Без задолж</option>
					<option value="1">С задолж</option>
				</select>
			</div>
		</div>
		<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
			<div class="input-group space10" style="width:100%">
				<label for="chPostavSearch_text"><b>Поставщик :</b></label>
				<input type="text" id="chPostavSearch_text" class="form-control" placeholder="Поставщик оборудования" name="chPostavSearch_text">
			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 text-right">
			<div class="input-group-btn" style="padding-top:25px">
				<button id="zayvview-chet-search_btnApply" class="btn btn-default" type="button">Применить</button>
				<button id="zayvview-chet-search_btnClear" class="btn btn-default" type="button"><i class="glyphicon glyphicon-remove"></i></button>
			</div>
		</div>
	</div>
	<?php // ----- ----- ----- ----- ----- 
	?>

	<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/zayvview/zayvview-chet/restr_4/css/zayvview-chet-main.css">
	<?php // ----- ----- ----- ----- ----- 
	?>
	<div class="demo-html"></div>
	<table id="zayvview-chet-main" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
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
				<th><span class="glyphicon glyphicon-send"></span></th>
			</tr>
		</thead>
	</table>
	<?php // ----- ----- ----- ----- ----- 
	?>
	<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/zayvview/zayvview-chet/restr_4/css/zayvview-chet-chetf.css">
	<div class="space30"></div>
	<div class="col-xs-12 space30" style="padding:10px; background-color:#fafafa">
		<h4 class="text-uppercase" style="color:#31708f; font-family:'Oswald', sans-serif; font-weight:400; letter-spacing:0.4em">Счета-фактуры к выбранному счету</h4>
	</div>
	<div class="demo-html"></div>
	<table id="zayvview-chet-chetf" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
				<th>Дата</th>
				<th>Счет-фактура</th>
				<th>Счет</th>
				<th>Сумма</th>
				<th>Примечание</th>
				<th>Статус</th>
				<th><span class="glyphicon glyphicon-file"></span></th>
				<th><span class="glyphicon glyphicon-send"></span></th>
			</tr>
		</thead>
	</table>
</div>

<?php // ----- ----- ----- ----- ----- 
?>

<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/zayvview/zayvview-chet/restr_4/css/zayvview-chet-transfer-zayvfrom.css">
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/zayvview/zayvview-chet/restr_4/css/zayvview-chet-transfer-zayvto.css">
<div id="tab-2" class="tab-pane fade">
	<div class="space30"></div>
	<div class="col-xs-12 space30" style="padding-left:0; padding-right:0">
		<div class="space10" style="padding:10px; background-color:#fafafa">
			<h4 class="text-uppercase" style="color:#31708f; font-family:'Oswald', sans-serif; font-weight:400; letter-spacing:0.4em">Перенос счета <span id="chet-to-move"></span> с заявки на заявку</h4>
		</div>
		<p class="bg-danger" style="padding:2px 10px">Перенос возможен на заявку того же года или более поздних годов</p>
	</div>
	<div id="chet-transfer-from">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 space10">
				<h4 class="transfer-title-from"><span>Откуда</span></h4>
				<div class="demo-html"></div>
				<table id="zayvview-chet-transfer-zayvfrom" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
							<th>С</th>
							<th>Дата</th>
							<th>Тип</th>
							<th>Номер</th>
							<th>Заявитель</th>
							<th>Примечание</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
	<?php // ----- ----- ----- ----- ----- 
	?>
	<div id="chet-transfer-to">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<h4 class="transfer-title-to"><span>Куда</span></h4>
				<div class="demo-html"></div>
				<table id="zayvview-chet-transfer-zayvto" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
							<th>С</th>
							<th>Дата</th>
							<th>Тип</th>
							<th>Номер</th>
							<th>Заявитель</th>
							<th>Примечание</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>

<?php // ----- ----- ----- ----- ----- 
?>

<div id="tab-3" class="tab-pane fade">
	<div class="space30"></div>
	<div class="col-xs-12 space30" style="padding:10px; background-color:#fafafa">
		<h4 class="space20 text-uppercase" style="color:#31708f; font-family:'Oswald', sans-serif; font-weight:400; letter-spacing:0.4em; padding-bottom:5px; border-bottom:4px #fff solid">Фильтры для поиска счета</h4>
		<div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
			<div class="form-group space10" style="width:100%">
				<label for="chYearSearchInArchive_text"><b>Год :</b></label>
				<select name="chYearSearchInArchive_text" id="chYearSearchInArchive_text" class="form-control">
					<option value=""><?php echo "2005-" . (date("Y") - 1); ?></option>
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
		<div class="col-xs-5 col-sm-3 col-md-2 col-lg-2">
			<div class="form-group space10" style="width:100%">
				<label for="chNumberSearchInArchive_text"><b>Номер счета :</b></label>
				<input type="text" id="chNumberSearchInArchive_text" class="form-control" placeholder="Все номера" name="chNumberSearchInArchive_text">
			</div>
		</div>
		<div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
			<div class="input-group space10" style="width:100%">
				<label for="zayvTipSearchInArchive_text"><b>Тип :</b></label>
				<select name="zayvTipSearchInArchive_text" id="zayvTipSearchInArchive_text" class="form-control">
					<option value="">Все типы</option>
					<?php
					$_QRY3 = mysqlQuery("SELECT kodtipzayvall, nametipzayvshotall FROM dognet_sptipzayvall WHERE nametipzayvshotall<>'' AND koddel<>'99'");
					while ($_ROW3 = mysqli_fetch_assoc($_QRY3)) {
					?>
						<option value='<?php echo $_ROW3["kodtipzayvall"]; ?>'><?php echo $_ROW3["nametipzayvshotall"]; ?></option>
					<?php
					}
					?>
				</select>
			</div>
		</div>
		<div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
			<div class="form-group space10" style="width:100%">
				<label for="zayvNumberSearchInArchive_text"><b>№ заявки :</b></label>
				<input type="text" id="zayvNumberSearchInArchive_text" class="form-control" placeholder="Все номера" name="zayvNumberSearchInArchive_text">
			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
			<div class="input-group space10" style="width:100%">
				<label for="chCommentSearchInArchive_text"><b>Примечание к счету :</b></label>
				<input type="text" id="chCommentSearchInArchive_text" class="form-control" placeholder="Текст для поиска" name="chCommentSearchInArchive_text">
			</div>
		</div>
		<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
			<div class="input-group space10" style="width:100%">
				<label for="chPostavSearchInArchive_text"><b>Поставщик :</b></label>
				<input type="text" id="chPostavSearchInArchive_text" class="form-control" placeholder="Поставщик оборудования" name="chPostavSearchInArchive_text">
			</div>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-8 col-lg-8 text-right">
			<div class="input-group-btn" style="padding-top:25px">
				<button id="zayvview-chet-archive-search_btnApply" class="btn btn-default" type="button">Применить</button>
				<button id="zayvview-chet-archive-search_btnClear" class="btn btn-default" type="button"><i class="glyphicon glyphicon-remove"></i></button>
			</div>
		</div>
	</div>
	<?php // ----- ----- ----- ----- ----- 
	?>

	<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/zayvview/zayvview-chet/restr_4/css/zayvview-chet-archive.css">
	<?php // ----- ----- ----- ----- ----- 
	?>
	<div class="demo-html"></div>
	<table id="zayvview-chet-archive" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
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
			</tr>
		</thead>
	</table>
	<?php // ----- ----- ----- ----- ----- 
	?>
	<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/zayvview/zayvview-chet/restr_4/css/zayvview-chet-archive-chetf.css">
	<div class="space30"></div>
	<div class="col-xs-12 space30" style="padding:10px; background-color:#fafafa">
		<h4 class="text-uppercase" style="color:#31708f; font-family:'Oswald', sans-serif; font-weight:400; letter-spacing:0.4em">Счета-фактуры к выбранному счету</h4>
	</div>
	<div class="demo-html"></div>
	<table id="zayvview-chet-archive-chetf" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
				<th>Дата</th>
				<th>Счет-фактура</th>
				<th>Счет</th>
				<th>Сумма</th>
				<th>Примечание</th>
				<th>Статус</th>
				<th><span class="glyphicon glyphicon-file"></span></th>
			</tr>
		</thead>
	</table>
</div>