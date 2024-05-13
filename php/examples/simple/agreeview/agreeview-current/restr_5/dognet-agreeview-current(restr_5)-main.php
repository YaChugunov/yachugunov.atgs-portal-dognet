<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/moment-with-locales.js"></script>
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/filterByText.js"></script>

<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/agreeview/agreeview-current/restr_5/css/agreeview-current-common-tables.css">
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/agreeview/agreeview-current/restr_5/css/agreeview-current-common-customForm.css">

<script type="text/javascript" language="javascript">
	function addZero(digits_length, source) {
		var text = source + '';
		while (text.length < digits_length)
			text = '0' + text;
		return text;
	}
</script>


<script type="text/javascript" language="javascript" class="">
	var table_doc_main;
	var editor_doc_main;

	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

	$(document).ready(function() {
		//
		editor_doc_main = new $.fn.dataTable.Editor({
			display: "bootstrap",
			ajax: "php/examples/simple/agreeview/agreeview-current/restr_5/process/dognet-agreeview-current(restr_5)-main-process.php",
			table: "#agreeview-doc-main",
			i18n: {
				create: {
					title: "<h3>Создать новое соглашение</h3>"
				},
				edit: {
					title: "<h3>Редактировать соглашение</h3>"
				},
				remove: {
					title: "<h3>Удалить соглашение</h3>",
					confirm: {
						"_": "Вы уверены, что хотите удалить %d записи(ей)?",
						"1": "Вы уверены, что хотите удалить это соглашение?"
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
			template: '#customForm-doc-main',
			fields: [{
				label: "Номер",
				name: "dognet_agreebase.docnumber"
			}, {
				label: "Шаблон :",
				name: "dognet_agreebase.kodshab",
				type: "select",
				options: [{
						label: "С календарным планом (по умолч.)",
						value: "1"
					},
					{
						label: "Без календарного плана",
						value: "2"
					}
				],
				placeholder: "Выберите шаблон"
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_agreebase.usedoczayv",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_agreebase.usedocruk",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "Краткое наименование",
				name: "dognet_agreebase.docnameshot",
				type: "textarea"
			}, {
				label: "Полное наименование",
				name: "dognet_agreebase.docnamefullm",
				type: "textarea"
			}, {
				label: "Бланк (год / номер / организация) :",
				name: "dognet_agreebase.kodblankwork",
				type: "select",
				placeholder: "Выберите бланк (из посл. 20-ти)"
			}, {
				// ----- -----
				label: "Начало соглашения (число)",
				name: "dognet_agreebase.daynachdoc",
				type: "hidden"
			}, {
				label: "Начало соглашения (месяц)",
				name: "dognet_agreebase.monthnachdoc",
				type: "hidden"
			}, {
				label: "Начало соглашения (год)",
				name: "dognet_agreebase.yearnachdoc",
				type: "hidden"
			}, {
				label: "Окончание соглашения (число)",
				name: "dognet_agreebase.dayenddoc",
				type: "hidden"
			}, {
				label: "Окончание соглашения (месяц)",
				name: "dognet_agreebase.monthenddoc",
				type: "hidden"
			}, {
				label: "Окончание соглашения (год)",
				name: "dognet_agreebase.yearenddoc",
				type: "hidden"
			}, {
				label: "Начало",
				name: "docDateBegin",
				type: "datetime",
				def: function() {
					return new Date();
				},
				format: "DD.MM.YYYY",
				opts: {
					yearRange: 20
				},
				attr: {
					readonly: "readonly"
				}
			}, {
				label: "Окончание",
				name: "docDateEnd",
				type: "datetime",
				def: function() {
					return new Date();
				},
				format: "DD.MM.YYYY",
				opts: {
					yearRange: 20
				},
				attr: {
					readonly: "readonly"
				}
			}, {
				// ----- -----
				label: "Тип :",
				name: "dognet_agreebase.kodtip",
				type: "select",
				def: "---",
				placeholder: "Выберите тип"
			}, {
				label: "Объект :",
				name: "dognet_agreebase.kodobject",
				type: "select",
				def: "---",
				placeholder: "Выберите объект"
			}, {
				label: "Заказчик",
				name: "dognet_agreebase.kodzakaz",
				type: "select",
				def: "---",
				placeholder: "Выберите заказчика"
			}, {
				label: "Статус :",
				name: "dognet_agreebase.kodstatus",
				type: "select",
				def: "---",
				placeholder: "Выберите статус"
			}, {
				label: "Исполнтель",
				name: "dognet_agreebase.kodispol",
				type: "select",
				def: "---",
				placeholder: "Выберите исполнителя"
			}, {
				label: "Руководитель",
				name: "dognet_agreebase.kodispolruk",
				type: "select",
				def: "---",
				placeholder: "Выберите руководителя"
			}, {
				label: "Сумма",
				name: "dognet_agreebase.docsumma",
				def: "0.00"
			}, {
				// ----- -----
				label: "Ден. единица",
				name: "dognet_agreebase.koddened",
				type: "select",
				def: "245296558950375",
				placeholder: "Выберите валюту"
			}, {
				label: "НДС",
				type: "checkbox",
				name: "dognet_agreebase.usendssumma",
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
				name: "dognet_agreebase.usemisopl",
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
				name: "dognet_agreebase.docsummamis",
				def: "0.00"
				// ----- -----
			}, {
				label: "Статус задолженности :",
				name: "dognet_agreebase.kodstatuszdl",
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
			}, {
				label: "Комментарии к соглашению",
				name: "dognet_agreebase.comments",
				type: "textarea"
			}]
		});
		//
		// ----- ----- ----- ----- -----
		// Изменяем размер диалогового окна редактирования
		editor_doc_main.on('open', function() {
			$(".modal-dialog").css({
				"width": "80%",
				"margin": "1.0em auto",
				"min-width": "640px",
				"max-width": "800px"
			});
		});
		//
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		//
		editor_doc_main
			.on('open', function() {
				$('#kodzakaz_filter').val('');
				if (($('#DTE_Field_dognet_docbase-kodzakaz').value) != editor_doc_main.field('dognet_agreebase.kodzakaz').get()) {}
				// Поиск в ниспадающем списке по содержимому текстового поля для ответного документа
				$('#DTE_Field_dognet_docbase-kodzakaz').filterByText(editor_doc_main, $('#kodzakaz_filter'), 'dognet_agreebase.kodzakaz', false);

				$('#kodobject_filter').val('');
				if (($('#DTE_Field_dognet_docbase-kodobject').value) != editor_doc_main.field('dognet_agreebase.kodobject').get()) {}
				// Поиск в ниспадающем списке по содержимому текстового поля для ответного документа
				$('#DTE_Field_dognet_docbase-kodobject').filterByText(editor_doc_main, $('#kodobject_filter'), 'dognet_agreebase.kodobject', false);

				$('#kodblankwork_filter').val('');
				if (($('#DTE_Field_dognet_docbase-kodblankwork').value) != editor_doc_main.field('dognet_agreebase.kodblankwork').get()) {}
				// Поиск в ниспадающем списке по содержимому текстового поля для ответного документа
				$('#DTE_Field_dognet_docbase-kodblankwork').filterByText(editor_doc_main, $('#kodblankwork_filter'), 'dognet_agreebase.kodblankwork', false);

				// Store the values of the fields on open
				openVals = JSON.stringify(editor_doc_main.get());

				editor_doc_main.on('preClose', function(e) {
					// On close, check if the values have changed and ask for closing confirmation if they have
					if (openVals !== JSON.stringify(editor_doc_main.get())) {
						return confirm('Вы не сохранили данные формы. Уверены, что хотите ее закрыть?');
					}
				})
				// ----- ----- ----- ----- -----
				editor_doc_main.on('preSubmit', function(e) {
					if (editor_doc_main.field('dognet_agreebase.kodtip').val() == '' || editor_doc_main.field('dognet_agreebase.kodstatus').val() == '') {
						document.getElementById("doc-editor-menu-tab-1-errmsg").innerHTML = '<span class="glyphicon glyphicon-exclamation-sign"></span>';
						$("#doc-editor-menu-tab-1-errmsg").attr("class", "text-danger errmsg");
					}
					if (editor_doc_main.field('dognet_agreebase.docnumber').val() == '' || editor_doc_main.field('dognet_agreebase.docnameshot').val() == '') {
						document.getElementById("doc-editor-menu-tab-2-errmsg").innerHTML = '<span class="glyphicon glyphicon-exclamation-sign"></span>';
						$("#doc-editor-menu-tab-2-errmsg").attr("class", "text-danger errmsg");
					}
					// return false; // prevent the submission
				})
			})
			.on('postCreate postEdit close', function() {
				editor_doc_main.off('preClose');
				document.getElementById("doc-editor-menu-tab-1-errmsg").innerHTML = '';
				document.getElementById("doc-editor-menu-tab-2-errmsg").innerHTML = '';
				document.getElementById("doc-editor-menu-tab-3-errmsg").innerHTML = '';
				document.getElementById("doc-editor-menu-tab-4-errmsg").innerHTML = '';
			});
		//
		//
		editor_doc_main.on('preOpen', function() {
			var daynachdoc = addZero(2, editor_doc_main.field('dognet_agreebase.daynachdoc').val());
			var monthnachdoc = addZero(2, editor_doc_main.field('dognet_agreebase.monthnachdoc').val());
			var yearnachdoc = addZero(4, editor_doc_main.field('dognet_agreebase.yearnachdoc').val());
			editor_doc_main.field('docDateBegin').set(daynachdoc + "." + monthnachdoc + "." + yearnachdoc);

			var dayenddoc = addZero(2, editor_doc_main.field('dognet_agreebase.dayenddoc').val());
			var monthenddoc = addZero(2, editor_doc_main.field('dognet_agreebase.monthenddoc').val());
			var yearenddoc = addZero(4, editor_doc_main.field('dognet_agreebase.yearenddoc').val());
			editor_doc_main.field('docDateEnd').set(dayenddoc + "." + monthenddoc + "." + yearenddoc);
		});
		//
		//
		editor_doc_main.on('initSubmit', function() {
			var a = editor_doc_main.field('docDateBegin').val().split('.');
			editor_doc_main.field('dognet_agreebase.daynachdoc').set(a[0]);
			editor_doc_main.field('dognet_agreebase.monthnachdoc').set(a[1]);
			editor_doc_main.field('dognet_agreebase.yearnachdoc').set(a[2]);
			var b = editor_doc_main.field('docDateEnd').val().split('.');
			editor_doc_main.field('dognet_agreebase.dayenddoc').set(b[0]);
			editor_doc_main.field('dognet_agreebase.monthenddoc').set(b[1]);
			editor_doc_main.field('dognet_agreebase.yearenddoc').set(b[2]);
		});
		//
		//
		//
		//
		//
		var request2;
		editor_doc_main.on('open', function(e, mode, action) {
			if (action == 'create') {
				console.log("create : kodblankwork=" + editor_doc_main.field('dognet_agreebase.kodblankwork').val());
				editor_doc_main.val('dognet_agreebase.kodblankwork', null);
				editor_doc_main.field('dognet_agreebase.kodshab').enable();
				editor_doc_main.field('dognet_agreebase.usedocruk').enable();
				editor_doc_main.field('dognet_agreebase.usedoczayv').enable();
				editor_doc_main.dependent('dognet_agreebase.usedoczayv', function(val) {
					if (val == 1) {
						console.log("create : usedoczayv=" + editor_doc_main.field('dognet_agreebase.usedoczayv').val());
						editor_doc_main.field('dognet_agreebase.kodblankwork').enable();
						editor_doc_main.field('dognet_agreebase.kodblankwork').show(false);
						editor_doc_main.field('dognet_agreebase.kodblankwork').focus();
						editor_doc_main.field('dognet_agreebase.usedocruk').disable();
						$('#kodblankwork_filter').prop("disabled", false);
						$('#kodblankwork_filter').prop("placeholder", "Поиск в Бланках");
						$('#kodblankwork_filter').css("display", "block");


						// Обрабатываем возможность "Зачесть аванс" прямо в форме создания СФ
						editor_doc_main.dependent('dognet_agreebase.kodblankwork', function(val, data, callback) {
							if ($("#DTE_Field_dognet_docbase-kodblankwork option:selected").val() != "") {

								// Serialize the data in the form
								// var serializedData = $form.serialize();
								var kodblankwork = $("#DTE_Field_dognet_docbase-kodblankwork").val();
								// Fire off the request to /form.php
								request2 = $.ajax({
									url: "php/examples/simple/agreeview/agreeview-current/restr_5/process/dognet-docview-doc(restr_5)-main_fetch-process.php",
									type: "post",
									cache: false,
									data: {
										"kodblankwork": kodblankwork
									}
								});
								// Callback handler that will be called on success
								request2.done(function(response, textStatus, jqXHR) {
									// Log a message to the console
									console.log("Request 2 status : " + textStatus);
									console.log("Request 2 response : " + response.replace(/\r?\n/g, ""));

									var resp = response.replace(/\r?\n/g, "");
									if (resp != '') {
										var x = resp.split(':');
										var zak = (x[0] != '') ? x[0].replace(/\ /g, '') : "";
										var isp = (x[1] != '') ? x[1].replace(/\ /g, '') : "";
										var ruk = (x[2] != '') ? x[2].replace(/\ /g, '') : "";
										var doc = x[3];
										console.log("RES " + resp);
										console.log("ZAK " + zak + " / ISP " + isp + " / RUK " + ruk);
										editor_doc_main.field('dognet_agreebase.kodzakaz').set(zak);
										editor_doc_main.field('dognet_agreebase.kodispol').set(isp);
										editor_doc_main.field('dognet_agreebase.kodispolruk').set(ruk);
										editor_doc_main.field('dognet_agreebase.docnamefullm').set(doc);
									}

								});
							} else {

							}
						}, {
							event: 'change'
						});


					} else {
						console.log("create : usedoczayv=" + editor_doc_main.field('dognet_agreebase.usedoczayv').val());
						editor_doc_main.field('dognet_agreebase.kodblankwork').hide(false);
						editor_doc_main.val('dognet_agreebase.kodblankwork', null);
						editor_doc_main.field('dognet_agreebase.usedocruk').enable();
						$('#kodblankwork_filter').css("display", "none");
					}
				});
				editor_doc_main.dependent('dognet_agreebase.usedocruk', function(val) {
					if (val == 1) {
						console.log("create : usedocruk=" + editor_doc_main.field('dognet_agreebase.usedocruk').val());
						editor_doc_main.field('dognet_agreebase.usedoczayv').disable();
					} else {
						console.log("create : usedocruk=" + editor_doc_main.field('dognet_agreebase.usedocruk').val());
						editor_doc_main.field('dognet_agreebase.usedoczayv').enable();
					}
				});

				editor_doc_main.val('dognet_agreebase.kodshab', 1);

			}
			if (action == 'edit') {
				console.log("edit : kodblankwork=" + editor_doc_main.field('dognet_agreebase.kodblankwork').val());
				$('#kodblankwork_filter').css("display", "none");
				editor_doc_main.field('dognet_agreebase.kodshab').disable();
				editor_doc_main.field('dognet_agreebase.usedocruk').disable();
				editor_doc_main.field('dognet_agreebase.usedoczayv').disable();
				editor_doc_main.dependent('dognet_agreebase.usedoczayv', function(val) {
					if (val == 1) {
						editor_doc_main.field('dognet_agreebase.kodblankwork').show(false);
						editor_doc_main.field('dognet_agreebase.kodblankwork').disable();
						editor_doc_main.field('dognet_agreebase.usedocruk').disable();
						editor_doc_main.field('dognet_agreebase.usedoczayv').disable();
					} else {
						editor_doc_main.field('dognet_agreebase.kodblankwork').hide(false);
					}
				});

			}

			$('#DTE_Field_docDateBegin').inputmask({
				mask: "99.99.9999"
			});
			$('#DTE_Field_docDateEnd').inputmask({
				mask: "99.99.9999"
			});
			$('#DTE_Field_dognet_docbase-docsummamis').inputmask({
				alias: "currency",
				rightAlign: false,
				greedy: false,
				tabThrough: true,
				enforceDigitsOnBlur: false,
				radixPoint: ".",
				positionCaretOnClick: "radixFocus",
				groupSeparator: " ",
				allowMinus: "true",
				inputType: "number",
				unmaskAsNumber: false,
				suffix: " р",
				removeMaskOnSubmit: true,
				autoUnmask: true,
				onUnMask: function(maskedValue, unmaskedValue) {
					var x = unmaskedValue.split('.');
					return x[0].replace(/\ /g, '') + '.' + x[1];
				}
			});
			$('#DTE_Field_dognet_docbase-docsumma').inputmask({
				alias: "currency",
				rightAlign: false,
				greedy: false,
				tabThrough: true,
				enforceDigitsOnBlur: false,
				radixPoint: ".",
				positionCaretOnClick: "radixFocus",
				groupSeparator: " ",
				allowMinus: "true",
				inputType: "number",
				unmaskAsNumber: false,
				suffix: " р",
				removeMaskOnSubmit: true,
				autoUnmask: true,
				onUnMask: function(maskedValue, unmaskedValue) {
					var x = unmaskedValue.split('.');
					return x[0].replace(/\ /g, '') + '.' + x[1];
				}
			});

		});
		editor_doc_main.on('close', function(e, mode, action) {
			console.log("close");
			editor_doc_main.undependent('dognet_agreebase.usedoczayv');
			editor_doc_main.undependent('dognet_agreebase.usedocruk');
			editor_doc_main.undependent('dognet_agreebase.kodblankwork');
			table_doc_main.ajax.reload();
		});
		//
		//
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		//
		table_doc_main = $('#agreeview-doc-main').DataTable({
			dom: "<'row'<'col-sm-5'B><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'l>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'p>>",
			// 		dom: "<'space50'r>tip",
			language: {
				url: "php/examples/simple/agreeview/agreeview-current/dt_russian-agreeview-current.json"
			},
			ajax: {
				url: "php/examples/simple/agreeview/agreeview-current/restr_5/process/dognet-agreeview-current(restr_5)-main-process.php",
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
					data: "dognet_agreebase.docnumber"
				},
				{
					data: "dognet_agreebase.yearnachdoc"
				},
				{
					data: "dognet_agreebase.yearenddoc"
				},
				{
					data: "sp_contragents.nameshort"
				},
				{
					data: "dognet_agreebase.docnameshot"
				},
				{
					data: "dognet_spispol.ispolnameshot"
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
					orderable: false,
					searchable: true,
					render: function(data, type, row, meta) {
						if (data != 0) {
							return addZero(2, row.dognet_agreebase.daynachdoc) + "." + addZero(2, row.dognet_agreebase.monthnachdoc) + "." + addZero(4, row.dognet_agreebase.yearnachdoc);
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
						if (data != 0) {
							return addZero(2, row.dognet_agreebase.dayenddoc) + "." + addZero(2, row.dognet_agreebase.monthenddoc) + "." + addZero(4, row.dognet_agreebase.yearenddoc);
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
							if (str.length > 25) {
								return str.substr(0, 25) + " ...";
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
							if (str.length > 70) {
								return str.substr(0, 70) + " ...";
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
					visible: true,
					targets: 6
				},
				{
					orderable: false,
					searchable: false,
					targets: 7,
					render: function(data, type, row, meta) {
						return '<span style="padding:0 5px"><a data-toggle="modal" href="#onFuture-modalBox"><span class="glyphicon glyphicon-list-alt"></span></a></span>' +
							'<span style="padding:0 5px"><a data-toggle="modal" href="#onFuture-modalBox"><span class="glyphicon glyphicon-pencil"></span></a></span>';
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
						$('#docNachYearSearch_text').val('');
						$('#docEndYearSearch_text').val('');
						$('#docNameSearch_text').val('');
						$('#docZakazSearch_text').val('');
						$('#docIspolSearch_text').val('');
						table_doc_main.columns().search('');
						table_doc_main.order([2, "desc"], [1, "desc"]).draw();
					}
				},
				{
					extend: "create",
					editor: editor_doc_main,
					text: "НОВОЕ СОГЛАШЕНИЕ",
					formButtons: ['Новое соглашение',
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
					editor: editor_doc_main,
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
					editor: editor_doc_main,
					text: "УДАЛИТЬ",
					formButtons: ['Удалить соглашение',
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
		//
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		// Array to track the ids of the details displayed rows
		//
		var detailRows = [];
		$('#agreeview-doc-main tbody').on('click', 'tr td.details-control', function() {
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
				if (row.data().dognet_agreebase.usedocruk == '1') {
					var osn = "По указанию руководства";
					var blank = '';
				} else if (row.data().dognet_agreebase.usedoczayv == '1') {
					var osn = 'Заявка ГИПа';
					if (row.data().dognet_agreebase.kodblankwork !== null) {
						/* 					var blank = ' / Бланк № '+row.data().dognet_docblankwork.numberblankwork+' / '+row.data().dognet_docblankwork.nameblankwork; */
						var blank = ' / (!) Номер бланка пока не выводится';
					} else {
						var blank = ' / Бланк не привязан';
					}
				} else {
					var osn = "Не определено";
					var blank = '';
				}
				d = row.data();
				rowData.child(<?php include('templates/agreeview-current-details.tpl'); ?>).show();

				// Add to the 'open' array
				if (idx === -1) {
					detailRows.push(tr.attr('id'));
				}
			}
		});
		//
		// On each draw, loop over the `detailRows` array and show any child rows
		table_doc_main.on('draw', function() {
			$.each(detailRows, function(i, id) {
				$('#' + id + ' td.details-control').trigger('click');
			});
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		$('#globalSearch_button').click(function(e) {
			table_doc_main.search($("#globalSearch_text").val()).draw();
		});
		$('#clearSearch_button').click(function(e) {
			table_doc_main.search('').draw();
			$('#globalSearch_text').val('');
		});
		$('#columnSearch_btnApply').click(function(e) {
			table_doc_main
				.columns(1)
				.search($("#docNumberSearch_text").val())
				.draw();

			table_doc_main
				.columns(2)
				.search($("#docNachYearSearch_text").val())
				.draw();

			table_doc_main
				.columns(3)
				.search($("#docEndYearSearch_text").val())
				.draw();

			table_doc_main
				.columns(4)
				.search($("#docZakazSearch_text").val())
				.draw();

			table_doc_main
				.columns(5)
				.search($("#docNameSearch_text").val())
				.draw();

			table_doc_main
				.columns(6)
				.search($("#docIspolSearch_text").val())
				.draw();
		});
		$('#columnSearch_btnClear').click(function(e) {
			$('#docNumberSearch_text').val('');
			$('#docNachYearSearch_text').val('');
			$('#docEndYearSearch_text').val('');
			$('#docNameSearch_text').val('');
			$('#docZakazSearch_text').val('');
			$('#docIspolSearch_text').val('');
			table_doc_main
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
		$("#docNachYearSearch_text").on("keyup", function(event) {
			if (event.keyCode === 13) {
				event.preventDefault();
				document.getElementById("columnSearch_btnApply").click();
			}
		});
		$("#docEndYearSearch_text").on("keyup", function(event) {
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
		$("#docZakazSearch_text").on("keyup", function(event) {
			if (event.keyCode === 13) {
				event.preventDefault();
				document.getElementById("columnSearch_btnApply").click();
			}
		});
		//
		//
		//
		//
		//
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		//
		//
		//
		//
		var editor_doc_files = new $.fn.dataTable.Editor({
			display: "bootstrap",
			ajax: {
				url: "php/examples/simple/agreeview/agreeview-current/restr_5/process/dognet-agreeview-current(restr_5)-files-process.php",
				data: function(d) {
					var selected = table_doc_main.row({
						selected: true
					});
					if (selected.any()) {
						d.koddoc = selected.data().dognet_agreebase.koddoc;
					}
				}
			},
			table: "#agreeview-doc-files",
			i18n: {
				create: {
					title: "<h3>Новый договор субподряда</h3>"
				},
				edit: {
					title: "<h3>Изменить параметры договора</h3>"
				},
				remove: {
					button: "Удалить",
					title: "<h3>Удалить договор субподряда</h3>",
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
			template: '#customForm-doc-files',
			fields: [{
				label: "Основной документ",
				type: "checkbox",
				name: "dognet_agreepaper.kodmainpaper",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
				// ----- ----- ----- ----- -----
			}, {
				label: "Тип документа :",
				name: "dognet_agreepaper.kodpaper",
				type: "select",
				def: "---",
				placeholder: "Выберите тип документа"
				// ----- ----- ----- ----- -----
			}, {
				label: "Дата загрузки",
				name: "dognet_agreepaper.dateloader",
				type: "datetime",
				format: "DD.MM.YYYY",
				def: function() {
					return new Date();
				},
				attr: {
					readonly: "readonly"
				}
				// ----- ----- ----- ----- -----
			}, {
				label: "XXX",
				name: "dognet_agreepaper.koddocpaper"
				// ----- ----- ----- ----- -----
			}, {
				name: "dognet_agreepaper.docFileID",
				type: "upload",
				display: function(id) {
					return '<div class="lnkDocFileID"><a target="_blank" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet' + editor_doc_files.file('dognet_agreepaper_files', id).file_webpath + '">Текущий прикрепленный файл</a></div>';
				},
				dragDrop: false,
				fileReadText: 'Загрузка файла',
				processingText: 'Обработка файла',
				uploadText: 'Прикрепить файл',
				clearText: 'Удалить файл',
				noFileText: 'Нет файла'
			}, {
				type: "readonly",
				name: "dognet_agreepaper.msgDocFileID"
			}, {
				type: "readonly",
				name: "dognet_agreepaper.lnkDocFileID"
				// ----- ----- ----- ----- -----
			}, {
				label: "Описание документа",
				name: "dognet_agreepaper.paperfull"
			}]
		});
		//
		// Изменяем размер диалогового окна редактирования договора субподряда
		editor_doc_files.on('open', function() {
			$(".modal-dialog").css({
				"width": "50%",
				"min-width": "800px",
				"max-width": "1170px"
			});
		});
		editor_doc_files.on('close', function() {
			$(".modal-dialog").css({
				"width": "80%",
				"min-width": "none",
				"max-width": "none"
			});
		});
		//
		// ----- --- ----- --- -----
		var txtlink;
		var initCreate;
		editor_doc_files.on('initCreate', function(e) {
			table_doc_files.rows().deselect();
			editor_doc_files.field('dognet_agreepaper.msgDocFileID').show(false);
			editor_doc_files.field('dognet_agreepaper.lnkDocFileID').hide(false);
			editor_doc_files.field('dognet_agreepaper.msgDocFileID').val('Сначала создайте запись!');
			editor_doc_files.field('dognet_agreepaper.docFileID').hide();
			editor_doc_files.field('dognet_agreepaper.docFileID').disable();
			window.txtlink = '';
			window.initCreate = 1;
			console.log('initCreate ' + window.initCreate);
		});
		//
		// ----- --- ----- --- -----
		editor_doc_files.on('initEdit', function(e, node, data, items, type) {
			window.initCreate = 0;
			if (data.dognet_agreepaper.docFileID == '') {
				editor_doc_files.field('dognet_agreepaper.msgDocFileID').hide(false);
				editor_doc_files.field('dognet_agreepaper.lnkDocFileID').hide(false);
				editor_doc_files.field('dognet_agreepaper.docFileID').show(false);
				editor_doc_files.field('dognet_agreepaper.docFileID').enable();
				window.txtlink = '';
				console.log('initEdit (docFileID empty) ' + window.initCreate);
			} else {
				editor_doc_files.field('dognet_agreepaper.msgDocFileID').hide(false);
				editor_doc_files.field('dognet_agreepaper.lnkDocFileID').show(false);
				editor_doc_files.field('dognet_agreepaper.lnkDocFileID').val('Если вы хотите обновить прикрепленный файл, создайте новую запись и удалите старую!');
				editor_doc_files.field('dognet_agreepaper.docFileID').hide(false);
				editor_doc_files.field('dognet_agreepaper.docFileID').disable();
				console.log('initEdit (docFileID NOT empty) ' + window.initCreate);
				if (window.initCreate != 1) {
					filelink = "http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet" + data.dognet_agreepaper_files.file_webpath + "";
					window.txtlink = '<a target="_blank" href="' + filelink + '">Текущий прикрепленный файл</a>';
					console.log('initEdit (docFileID txtlink) ' + window.initCreate);
					console.log('initEdit (docFileID NOT empty txtLink) ' + window.initCreate);
				}
			}
		});
		//
		// ----- --- ----- --- -----
		editor_doc_files.on('open', function(e) {
			// selected = table_doc_files.row( { selected: true } );
			// filewebpath = selected.data().dognet_agreepaper_files.file_webpath
			// filelink = "http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet"+filewebpath+"";
			// var txtlink = '<a target="_blank" href="'+filelink+'">Прикрепленный документ</a>';
			// console.log(filelink);
			$('#lnkDocFileID').html(window.txtlink);
		});
		editor_doc_files.on('close', function(e) {
			table_doc_files.ajax.reload();
		});
		//
		//
		// ----- --- ----- --- -----
		var table_doc_files = $('#agreeview-doc-files').DataTable({
			dom: "<'row'<'col-md-8 col-sm-12'B><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'>>",
			language: {
				url: "php/examples/simple/agreeview/agreeview-current/dt_russian-agreeview-current-files.json"
			},
			ajax: {
				url: "php/examples/simple/agreeview/agreeview-current/restr_5/process/dognet-agreeview-current(restr_5)-files-process.php",
				type: "POST",
				data: function(d) {
					var selected = table_doc_main.row({
						selected: true
					});
					if (selected.any()) {
						d.koddoc = selected.data().dognet_agreebase.koddoc;
					}
				}
			},
			serverSide: true,
			processing: true,
			select: {
				style: 'single'
			},
			columns: [{
					data: null,
					class: "details-control",
					searchable: false,
					orderable: false,
					defaultContent: "<span class='glyphicon glyphicon-option-vertical'></span>"
				},
				{
					data: "dognet_agreepaper.koddocpaper",
					className: "text-left"
				},
				{
					data: "dognet_agreepaper.dateloader",
					className: "text-left"
				},
				{
					data: "dognet_agreepaper.kodpaper",
					className: "text-left"
				},
				{
					data: "dognet_agreepaper.paperfull",
					className: "text-left"
				},
				{
					data: "dognet_agreepaper.docFileID",
					render: function(id) {
						return id ?
							'<a class="" target="_blank" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet' + editor_doc_files.file('dognet_agreepaper_files', id).file_webpath + '"><span class="glyphicon glyphicon-file"></span></a>' :
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
					orderable: false,
					searchable: false,
					targets: 1
				},
				{
					orderable: true,
					searchable: false,
					targets: 2
				},
				{
					orderable: true,
					visible: false,
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
					targets: 5
				}
			],
			order: [
				[2, "desc"],
				[3, "asc"]
			],
			rowGroup: {
				dataSrc: function(row) {
					return row.dognet_sptippaper.namepaper;
				},
				startRender: function(rows, group) {
					return group;
				},
				endRender: null,
				emptyDataGroup: 'No categories assigned yet'
			},
			buttons: [{
					text: '<span class="glyphicon glyphicon-refresh"></span>',
					action: function(e, dt, node, config) {
						table_doc_files.ajax.reload();
						table_doc_files.columns().search('').draw();
					}
				},
				{
					extend: "create",
					editor: editor_doc_files,
					text: "НОВЫЙ ДОКУМЕНТ",
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
					editor: editor_doc_files,
					text: "ИЗМЕНИТЬ",
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
					editor: editor_doc_files,
					text: "УДАЛИТЬ"
				}
			]
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		//
		// ----- -- ----- -- -----
		// Array to track the ids of the edit displayed rows
		var detailRows_doc_files = [];
		$('#agreeview-doc-files tbody').on('click', 'tr td.details-control', function() {
			var tr = $(this).closest('tr');
			var row = table_doc_files.row(tr);
			var idx = $.inArray(tr.attr('id'), detailRows_doc_files);

			if (row.child.isShown()) {
				tr.removeClass('edit');
				row.child.hide();

				// Remove from the 'open' array
				detailRows_doc_files.splice(idx, 1);
			} else {
				tr.addClass('edit');
				rowData = table_doc_files.row(row);
				d = row.data();
				rowData.child(<?php include('templates/agreeview-current-files-details.tpl'); ?>).show();

				// Add to the 'open' array
				if (idx === -1) {
					detailRows_doc_files.push(tr.attr('id'));
				}
			}
		});
		// On each draw, loop over the `detailRows_doc_files` array and show any child rows
		table_doc_files.on('draw', function() {
			$.each(detailRows_doc_files, function(i, id) {
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
		// Обработчики событий таблицы заявок
		table_doc_main.on('select', function() {
			table_doc_files.buttons().enable();
			table_doc_files.ajax.reload(null, true);
		});
		table_doc_main.on('deselect', function() {
			table_doc_files.buttons().disable();
			table_doc_files.rows().deselect();
			table_doc_files.ajax.reload(null, true);
		});
	});
</script>
<?php
// ----- ----- ----- ----- -----
// Подключаем форму редактирования, форму поиска и выводим таблицу соглашения
// :::
include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/agreeview/agreeview-current/restr_5/forms/agreeview-current-customForm.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/agreeview/agreeview-current/restr_5/forms/agreeview-current-filters.php");
// ----- ----- ----- ----- -----
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/agreeview/agreeview-current/restr_5/css/agreeview-current-main.css">
<section>
	<div class="demo-html"></div>
	<table id="agreeview-doc-main" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th><span class='glyphicon glyphicon-option-vertical'></span></th>
				<th>№</th>
				<th>Нач</th>
				<th>Кон</th>
				<th>Партнер</th>
				<th>Предмет соглашения</th>
				<th>ГИП</th>
				<th><span class="glyphicon glyphicon-edit"></span></th>
			</tr>
		</thead>
	</table>
</section>

<?php
// ----- ----- ----- ----- -----
// Подключаем форму и выводим таблицу документов
// :::
include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/agreeview/agreeview-current/restr_5/forms/agreeview-current-files-customForm.php");
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/agreeview/agreeview-current/restr_5/css/agreeview-current-files.css">
<section>
	<div class="" style="padding-left:5px; padding-right:5px">
		<div class="space30"></div>
		<h3 class="parent-title space20">Документы к соглашению</h3>
		<div class="demo-html"></div>
		<table id="agreeview-doc-files" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
					<th class="text-uppercase">ID документа</th>
					<th class="text-uppercase">Дата загрузки</th>
					<th class="text-uppercase">Тип документа</th>
					<th class="text-uppercase">Описание</th>
					<th><span class="glyphicon glyphicon-file"></span></th>
				</tr>
			</thead>
		</table>
	</div>
</section>

<?php
// ----- ----- ----- ----- -----
// Подключаем модальное окно
// :::
include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/agreeview/agreeview-current/restr_5/forms/agreeview-current-modals.php");
?>