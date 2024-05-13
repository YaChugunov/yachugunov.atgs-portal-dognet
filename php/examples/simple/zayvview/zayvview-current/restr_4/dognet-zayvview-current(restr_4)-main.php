<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/moment-with-locales.js"></script>
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/filterByText.js"></script>


<script type="text/javascript" language="javascript" class="init">
	function addZero(digits_length, source) {
		var text = source + '';
		while (text.length < digits_length)
			text = '0' + text;
		return text;
	}

	function switchtotab2() {
		$('li#link-to-tab2 a').trigger('click');
	}

	var reqField_getLastZayvNumber = {
		lastZayvNumber: function(response) {}
	};

	function ajaxRequest_getLastZayvNumber(data, responseHandler) {
		var response = false;
		// Fire off the request to /form.php
		request = $.ajax({
			url: "php/examples/simple/zayvview/zayvview-current/restr_4/php/req_getLastZayvNumber.php",
			type: "post",
			cache: false,
			data: {
				tipZayv: data
			},
			success: reqField_getLastZayvNumber[responseHandler]
		});
		// Callback handler that will be called on success
		request.done(function(response, textStatus, jqXHR) {
			res = response.replace(new RegExp("\\r?\\n", "g"), "");
			if (res == '-3' || res == '-2' || res == '-1' || res == '0') {
				$('#DTE_Field_dognet_doczayv-numberzayv').val("");
			} else {
				$('#DTE_Field_dognet_doczayv-numberzayv').val(res);
			}
			console.log('res (response) lastZayvNumber: ' + res);
		});
		// Callback handler that will be called on failure
		request.fail(function(jqXHR, textStatus, errorThrown) {
			console.error(
				"The following error occurred: " +
				textStatus, errorThrown
			);
		});
		// Callback handler that will be called regardless
		// if the request failed or succeeded
		request.always(function() {

		});
	}

	// --- - --- - --- - --- - --- - --- - --- - --- - --- - ---
	var reqField_getFullMsg = {
		getFullMsg: function(response) {}
	};

	function ajaxRequest_getFullMsg(zayvKOD, responseHandler) {
		var response = false;

		// Fire off the request to /form.php
		request = $.ajax({
			url: "php/examples/simple/zayvview/zayvview-current/restr_4/php/req_getComments(zayvview).php",
			type: "post",
			cache: false,
			data: {
				kodzayv: zayvKOD
			},
			success: reqField_getFullMsg[responseHandler]
		});
		// Callback handler that will be called on success
		request.done(function(response, textStatus, jqXHR) {
			res = response.replace(new RegExp("\\r?\\n", "g"), "");
			console.log("zayvKOD: " + zayvKOD);
			$("#zayvComments-text").html(response);
			$("#zayvComments-modal").modal("show");
		});
		// Callback handler that will be called on failure
		request.fail(function(jqXHR, textStatus, errorThrown) {
			console.error(
				"The following error occurred: " +
				textStatus, errorThrown
			);
		});
		// Callback handler that will be called regardless
		// if the request failed or succeeded
		request.always(function() {

		});
	}
	// --- - --- - --- - --- - --- - --- - --- - --- - --- - ---
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
					}
				}
			},
			table: "#zayvview-zayv-main",
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
					return '<a target="_blank" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet' + editor_zayv_main.file('dognet_doczayv_files', id).file_webpath + '"><h4>СКАЧАТЬ ФАЙЛ</h4></a>';
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
			}, {
				label: "Дата / Имя / Ваш комментарий :",
				name: "dognet_doczayv.zayvchetcom",
				type: "textarea"
			}]
		});
		// ----- ----- -----
		// Управление размером диалогового окна редактирования заявки
		editor_zayv_main.on('open', function() {
			$(".modal-dialog").css({
				"width": "60%",
				"min-width": "800px",
				"max-width": "1024px"
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
		// Обработчик формы редактора заявок
		editor_zayv_main.on('preOpen', function() {
			editor_zayv_main.field('koddoc_tmp').set(editor_zayv_main.field('dognet_doczayv.koddoc').get());
			if (editor_zayv_main.field('dognet_doczayv.koddoc').get() == "000000000000000") {
				editor_zayv_main.field('kodusezayv_0').set(1);
			}
			if (editor_zayv_main.field('dognet_doczayv.koddoc').get() == "245375260650765") {
				editor_zayv_main.field('kodusezayv_1').set(1);
			}
			if (editor_zayv_main.field('dognet_doczayv.koddoc').get() == "245375544141726") {
				editor_zayv_main.field('kodusezayv_2').set(1);
			}
		});
		//
		//
		editor_zayv_main.on('open', function(e, mode, action) {


			console.log('Событие open произошло!' + '(' + form_in_create_mode + ', ' + form_in_edit_mode + ')');

			$('#DTE_Field_dognet_doczayv-kodtipzayvall').on('change', function(e) {
				console.log('Селектор типа заявки изменен' + '(' + form_in_create_mode + ', ' + form_in_edit_mode + ')');
				if (form_in_create_mode == 1) {
					ajaxRequest_getLastZayvNumber($('#DTE_Field_dognet_doczayv-kodtipzayvall option:selected').val(), 'lastZayvNumber');
				}
			});


			editor_zayv_main.field('sendMessage').disable();
			editor_zayv_main.on('edit', function(e, json, data) {
				/*     alert( 'New server IP is: '+ data['sendMessage'] ); */
				return false;
			});

			$('#zayvview-zayv-main-koddoc_filter').val('');
			if (($('#DTE_Field_dognet_doczayv-koddoc').value) != editor_zayv_main.field('dognet_doczayv.koddoc').get()) {}
			// Поиск в ниспадающем списке по содержимому текстового поля для ответного документа
			$('#DTE_Field_dognet_doczayv-koddoc').filterByText(editor_zayv_main, $('#zayvview-zayv-main-koddoc_filter'), 'dognet_doczayv.koddoc', false);
			//
			editor_zayv_main.dependent('kodusezayv_0', function(val) {
				if (val == 1) {
					editor_zayv_main.field('dognet_doczayv.koddoc').set("000000000000000");
					editor_zayv_main.field('dognet_doczayv.koddoc').disable();
					$('#zayvview-zayv-main-koddoc_filter').prop('disabled', true);
					editor_zayv_main.field('kodusezayv_1').disable();
					editor_zayv_main.field('kodusezayv_2').disable();
				}
				if (val == 0) {
					editor_zayv_main.field('dognet_doczayv.koddoc').set(editor_zayv_main.field('koddoc_tmp').get());
					editor_zayv_main.field('dognet_doczayv.koddoc').enable();
					$('#zayvview-zayv-main-koddoc_filter').prop('disabled', false);
					editor_zayv_main.field('kodusezayv_1').enable();
					editor_zayv_main.field('kodusezayv_2').enable();
				}
			});
			//
			editor_zayv_main.dependent('kodusezayv_1', function(val) {
				if (val == 1) {
					editor_zayv_main.field('dognet_doczayv.koddoc').set("245375260650765");
					editor_zayv_main.field('dognet_doczayv.koddoc').disable();
					$('#zayvview-zayv-main-koddoc_filter').prop('disabled', true);
					editor_zayv_main.field('kodusezayv_0').disable();
					editor_zayv_main.field('kodusezayv_2').disable();
				}
				if (val == 0) {
					editor_zayv_main.field('dognet_doczayv.koddoc').set(editor_zayv_main.field('koddoc_tmp').get());
					editor_zayv_main.field('dognet_doczayv.koddoc').enable();
					$('#zayvview-zayv-main-koddoc_filter').prop('disabled', false);
					editor_zayv_main.field('kodusezayv_0').enable();
					editor_zayv_main.field('kodusezayv_2').enable();
				}
			});
			//
			editor_zayv_main.dependent('kodusezayv_2', function(val) {
				if (val == 1) {
					editor_zayv_main.field('dognet_doczayv.koddoc').set("245375544141726");
					editor_zayv_main.field('dognet_doczayv.koddoc').disable();
					$('#zayvview-zayv-main-koddoc_filter').prop('disabled', true);
					editor_zayv_main.field('kodusezayv_0').disable();
					editor_zayv_main.field('kodusezayv_1').disable();
				}
				if (val == 0) {
					editor_zayv_main.field('dognet_doczayv.koddoc').set(editor_zayv_main.field('koddoc_tmp').get());
					editor_zayv_main.field('dognet_doczayv.koddoc').enable();
					$('#zayvview-zayv-main-koddoc_filter').prop('disabled', false);
					editor_zayv_main.field('kodusezayv_0').enable();
					editor_zayv_main.field('kodusezayv_1').enable();
				}
			});
			//
			editor_zayv_main.dependent('dognet_doczayv.kodrabfile', function(val) {
				if (val == 1) {
					editor_zayv_main.field('dognet_doczayv.docFileID').enable();
					editor_zayv_main.field('dognet_doczayv.docFileID').show();
				}
				if (val == 0) {
					editor_zayv_main.field('dognet_doczayv.docFileID').disable();
					editor_zayv_main.field('dognet_doczayv.docFileID').hide();
				}
			});
		});
		//
		editor_zayv_main.on('close', function() {
			table_zayv_main.ajax.reload(null, false);
			editor_zayv_main.field('sendMessage').disable();
			window.form_in_create_mode = 0;
			window.form_in_edit_mode = 0;

			console.log('Событие close произошло!' + '(' + form_in_create_mode + ', ' + form_in_edit_mode + ')');
		});
		//
		editor_zayv_main.on('initCreate', function(e) {
			window.form_in_create_mode = 1;
			window.form_in_edit_mode = 0;

			console.log('Событие InitCreate произошло!' + '(' + form_in_create_mode + ', ' + form_in_edit_mode + ')');

			editor_zayv_main.field('dognet_doczayv.msgDocFileID').show();
			editor_zayv_main.field('dognet_doczayv.msgDocFileID').val('Сначала создайте запись!');
			editor_zayv_main.field('dognet_doczayv.docFileID').hide();
			editor_zayv_main.field('dognet_doczayv.docFileID').disable();
		});
		editor_zayv_main.on('initEdit', function(e, node, data, items, type) {
			window.form_in_create_mode = 0;
			window.form_in_edit_mode = 1;

			console.log('Событие InitEdit произошло!' + '(' + form_in_create_mode + ', ' + form_in_edit_mode + ')');

			editor_zayv_main.field('dognet_doczayv.msgDocFileID').hide();
			editor_zayv_main.field('dognet_doczayv.docFileID').show();
			editor_zayv_main.field('dognet_doczayv.docFileID').enable();
		});
		editor_zayv_main.on('postEdit', function(e, json, data, id) {

		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		// Обработчик таблицы заявок
		//
		table_zayv_main = $('#zayvview-zayv-main').DataTable({
			dom: "<'row'<'col-sm-5'B><'col-sm-4'<'#toolbar_msg'>><'col-sm-3 text-right'l>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'p>>",
			// 		dom: "<'space50'r>tip",
			language: {
				url: "php/examples/simple/zayvview/zayvview-current/dt_russian-zayv-main.json"
			},
			ajax: {
				url: "php/examples/php/zayvview/zayvview-current/dognet-zayvview-zayv-main-process.php",
				type: "POST"
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
				// 
				if (data.dognet_doczayv.tipusezayv == "2") {
					$('td', row).eq(1).addClass('zayvtip_2');
				} else {
					$('td', row).eq(1).removeClass('zayvtip_2');
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
								txt1 = '<span style="padding:0 5px"><a class="" target="_blank" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet' + editor_zayv_main.file('dognet_doczayv_files', id).file_webpath + '"><span class="glyphicon glyphicon-file"></span></a></span>';
							} else {
								txt1 = '';
							}
						}
						if (row.dognet_doczayv.kodrabzayv == 1) {
							txt2 = '<span style="padding:0 5px"><span id="click-to-tab2"><a data-toggle="tab" href="#tab-2" onclick="switchtotab2()"><span class="glyphicon glyphicon-list-alt"></span></a></span></span>';
						} else {
							txt2 = '';
						}
						return txt1 + txt2;
					},
					defaultContent: "",
					className: "text-center"
				},
				{
					data: null,
					defaultContent: ''
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
							return '<span class="glyphicon glyphicon-pushpin" title="Заявка сформирована"></span>';
						} else if (data == '1') {
							return '<span class="text-warning glyphicon glyphicon-credit-card" title="Есть выставленные счета"></span>';
						} else if (data == '2') {
							return '<span class="text-default glyphicon glyphicon-ok-circle" title="Заявка закрыта"></span>';
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
					render: function(data, type, row, meta) {
						if (row.dognet_doczayv.zayvchetcom != "") {
							return data + '<a class="comments-click" href="#" title="Комментарии к заявке"><span class="glyphicon glyphicon-comment" style="float:right"></span></a>';
						} else {
							return data;
						}
					},
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
					searchable: false,
					targets: 8,
					render: function(data, type, row, meta) {
						return '' + '<span style="padding:0 5px"><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/dognet-zayvview.php?zayvview_type=current&uniqueID=' + row.dognet_doczayv.kodzayv + '&export=yes&format="><span class="glyphicon glyphicon-print"></span></a></span>' + '<span style="padding:0 5px"><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/dognet-zayvview.php?zayvview_type=current&uniqueID=' + row.dognet_doczayv.kodzayv + '&mailing=yes&msgtype="><span class="glyphicon glyphicon-send"></span></a></span>';
					}
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
				},
				{
					orderable: false,
					visible: false,
					searchable: true,
					targets: 12
				}
			],
			order: [
				[2, "desc"],
				[3, "asc"],
				[4, "asc"]
			],
			ordering: true,
			processing: true,
			paging: true,
			searching: true,
			/* 		searchCols: [ null, null, { search: moment().format("YYYY") }, null, null, null, null, null, null, null, null, null, null ], */
			searchCols: [null, null, null, null, null, null, null, null, null, null, null, null, null],
			pageLength: 15,
			lengthChange: true,
			lengthMenu: [
				[15, 30, 50, -1],
				[15, 30, 50, "Все"]
			],
			buttons: [{
					text: '<span class="glyphicon glyphicon-refresh"></span>',
					action: function(e, dt, node, config) {
						table_zayv_main.ajax.reload(null, false);
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
					formButtons: ['Удалить заявку',
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
		// Обработчик child-таблицы для выбранной заявки
		// Array to track the ids of the details displayed rows
		var detailRows_zayv_main = [];
		$('#zayvview-zayv-main tbody').on('click', 'tr td.details-control', function() {
			var tr = $(this).closest('tr');
			var row = table_zayv_main.row(tr);
			var idx = $.inArray(tr.attr('id'), detailRows_zayv_main);

			if (row.child.isShown()) {
				tr.removeClass('details');
				row.child.hide();

				// Remove from the 'open' array
				detailRows_zayv_main.splice(idx, 1);
			} else {
				tr.addClass('details');
				rowData = table_zayv_main.row(row);
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
				rowData.child(<?php include('templates/zayvview-zayv-details.tpl'); ?>).show();

				// Add to the 'open' array
				if (idx === -1) {
					detailRows_zayv_main.push(tr.attr('id'));
				}
			}
		});
		// On each draw, loop over the `detailRows` array and show any child rows
		table_zayv_main.on('draw', function() {
			$.each(detailRows_zayv_main, function(i, id) {
				$('#' + id + ' td.details-control').trigger('click');
			});
		});
		// ----- ----- -----
		table_zayv_main.button(0).action(function(e, dt, button, config) {
			console.log('Button ' + this.text() + ' activated');
			this.disable();
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		//
		// TAB #2 :::
		// СПЕЦИФИКАЦИЯ (список)
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
				"width": "60%",
				"min-width": "800px",
				"max-width": "1024px"
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
			/* 	    table_zayv_main.ajax.reload(null, false); */
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
		var detailRows_zayv_child_dop = [];
		$('#zayvview-zayv-child-dop tbody').on('click', 'tr td.details-control', function() {
			var tr = $(this).closest('tr');
			var row = table_zayv_child_dop.row(tr);
			var idx = $.inArray(tr.attr('id'), detailRows_zayv_child_dop);

			if (row.child.isShown()) {
				tr.removeClass('details');
				row.child.hide();

				// Remove from the 'open' array
				detailRows_zayv_child_dop.splice(idx, 1);
			} else {
				tr.addClass('details');
				rowData = table_zayv_child_dop.row(row);
				d = row.data();
				rowData.child(<?php include('templates/zayvview-dop-details.tpl'); ?>).show();

				// Add to the 'open' array
				if (idx === -1) {
					detailRows_zayv_child_dop.push(tr.attr('id'));
				}
			}
		});
		// On each draw, loop over the `detailRows` array and show any child rows
		table_zayv_child_dop.on('draw', function() {
			$.each(detailRows_zayv_child_dop, function(i, id) {
				$('#' + id + ' td.details-control').trigger('click');
			});
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		//
		// TAB #3 :::
		// СПЕЦИФИКАЦИЯ (файл)
		//
		// ----- ----- -----
		// Обработчик формы редактирование счета
		editor_zayv_child_files = new $.fn.dataTable.Editor({
			display: "bootstrap",
			ajax: {
				url: "php/examples/php/zayvview/zayvview-current/dognet-zayvview-zayv-child-files-process.php",
				data: function(d) {
					var selected = table_zayv_main.row({
						selected: true
					});
					if (selected.any()) {
						d.kodzayv = selected.data().dognet_doczayv.kodzayv;
					}
				}
			},
			table: "#zayvview-zayv-child-files",
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
			template: '#customForm-zayv-child-files',
			fields: [{
				label: "Наименование спецификации :",
				name: "dognet_doczayvdopspec.namedopspec"
				// ----- ----- -----
			}, {
				name: "dognet_doczayvdopspec.dopFileID",
				type: "upload",
				display: function(id) {
					return '<a target="_blank" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet' + editor_zayv_child_files.file('dognet_doczayvdopspec_files', id).file_webpath + '"><h4>СКАЧАТЬ ФАЙЛ</h4></a>';
				},
				dragDrop: false,
				dragDropText: "",
				clearText: "Удалить файл",
				fileReadText: "Файл загружается",
				noFileText: "Файл не прикреплен",
				processingText: "Файл загружен",
				uploadText: "Выберите файл"
			}, {
				type: "readonly",
				name: "dognet_doczayvdopspec.msgDocFileID"
				// ----- ----- -----
			}]
		});
		// ----- ----- -----
		// Управление размером диалогового окна редактирования доп спецификаций
		editor_zayv_child_files.on('open', function() {
			$(".modal-dialog").css({
				"width": "60%",
				"min-width": "800px",
				"max-width": "1024px"
			});
		});
		editor_zayv_child_files.off('close', function() {
			$(".modal-dialog").css({
				"width": "80%",
				"min-width": "none",
				"max-width": "none"
			});
		});
		// ----- ----- -----
		// Обработчики событий редактора доп спецификаций
		editor_zayv_child_files.on('initCreate', function(e) {
			editor_zayv_child_files.field('dognet_doczayvdopspec.msgDocFileID').show();
			editor_zayv_child_files.field('dognet_doczayvdopspec.msgDocFileID').val('Сначала создайте запись!');
			editor_zayv_child_files.field('dognet_doczayvdopspec.dopFileID').hide();
			editor_zayv_child_files.field('dognet_doczayvdopspec.dopFileID').disable();
		});
		editor_zayv_child_files.on('initEdit', function(e, node, data, items, type) {
			editor_zayv_child_files.field('dognet_doczayvdopspec.msgDocFileID').hide();
			editor_zayv_child_files.field('dognet_doczayvdopspec.dopFileID').show();
			editor_zayv_child_files.field('dognet_doczayvdopspec.dopFileID').enable();
		});
		editor_zayv_child_files.on('submitSuccess', function() {
			// 	    table_zayv_main.ajax.reload(null, false);
		});
		// ----- ----- -----
		// Обработчик таблицы счетов
		table_zayv_child_files = $('#zayvview-zayv-child-files').DataTable({
			dom: "<'row'<'col-sm-5'B><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'l>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'p>>",
			// 		dom: "<'space50'r>tip",
			language: {
				url: "php/examples/simple/zayvview/zayvview-current/dt_russian-zayv-child-files.json"
			},
			ajax: {
				url: "php/examples/php/zayvview/zayvview-current/dognet-zayvview-zayv-child-files-process.php",
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
				console.log("kodmainspec : " + data.dognet_doczayvdopspec.kodmainspec);
				if (data.dognet_doczayvdopspec.kodmainspec == 1) {
					$(row).addClass('no-select');
					$('td', row).eq(1).css({
						'font-weight': '700',
						'color': '#000'
					});
					$('td', row).eq(2).css({
						'font-weight': '700',
						'color': '#000'
					});
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
					data: "dognet_doczayvdopspec.numberdopspec"
				},
				{
					data: "dognet_doczayvdopspec.namedopspec"
				},
				{
					data: "dognet_doczayvdopspec.dopFileID",
					render: function(id) {
						return id ?
							'<a class="" target="_blank" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet' + editor_zayv_child_files.file('dognet_doczayvdopspec_files', id).file_webpath + '"><span class="glyphicon glyphicon-file"></span></a>' :
							'<span class="glyphicon glyphicon-option-horizontal"></span>';
					},
					defaultContent: "",
					className: "text-center"
				}
			],
			select: {
				style: 'single',
				selector: 'tr:not(.no-select)'
			},
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
					searchable: false,
					targets: 2
				},
				{
					orderable: false,
					searchable: true,
					targets: 3
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
						table_zayv_child_files.ajax.reload();
						table_zayv_child_files.columns().search('').draw();
					}
				},
				{
					extend: "create",
					editor: editor_zayv_child_files,
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
					editor: editor_zayv_child_files,
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
					editor: editor_zayv_child_files,
					text: '<span class="glyphicon glyphicon-remove"></span>'
				}
			],
			drawCallback: function() {

			}
		});
		// ----- ----- -----
		// Обработчик child-таблицы выбранного счета
		// Array to track the ids of the details displayed rows
		var detailRows_zayv_child_files = [];
		$('#zayvview-zayv-child-files tbody').on('click', 'tr td.details-control', function() {
			var tr = $(this).closest('tr');
			var row = table_zayv_child_files.row(tr);
			var idx = $.inArray(tr.attr('id'), detailRows_zayv_child_files);

			if (row.child.isShown()) {
				tr.removeClass('details');
				row.child.hide();

				// Remove from the 'open' array
				detailRows_zayv_child_files.splice(idx, 1);
			} else {
				tr.addClass('details');
				rowData = table_zayv_child_files.row(row);
				d = row.data();
				rowData.child(<?php include('templates/zayvview-dopspec-details.tpl'); ?>).show();

				// Add to the 'open' array
				if (idx === -1) {
					detailRows_zayv_child_files.push(tr.attr('id'));
				}
			}
		});
		// On each draw, loop over the `detailRows` array and show any child rows
		table_zayv_child_files.on('draw', function() {
			$.each(detailRows_zayv_child_files, function(i, id) {
				$('#' + id + ' td.details-control').trigger('click');
			});
		});
		// ----- ----- -----
		/*
		  table_zayv_child_files.on( 'draw', function () {
		    table_zayv_child_files.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
		        cell.innerHTML = i+1;
		    } );
		  } ).draw();
		*/
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		//
		// TAB #5 :::
		// СПЕЦИФИКАЦИИ (договор)
		//
		// ----- ----- -----
		// Обработчик таблицы спецификаций из договора
		table_zayv_child_dop_docspec = $('#zayvview-zayv-child-dop-docspec').DataTable({
			dom: "<'row'<'col-sm-5'B><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'l>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'p>>",
			// 		dom: "<'space50'r>tip",
			language: {
				url: "php/examples/simple/zayvview/zayvview-current/dt_russian-zayv-child-dop-docspec.json"
			},
			ajax: {
				url: "php/examples/php/zayvview/zayvview-current/dognet-zayvview-zayv-child-dop-docspec-process.php",
				type: "POST",
				data: function(d) {
					var selected = table_zayv_main.row({
						selected: true
					});
					if (selected.any()) {
						d.koddoc = selected.data().dognet_doczayv.koddoc;
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
					data: "dognet_docpaper.koddocpaper"
				},
				{
					data: "dognet_docpaper.paperfull"
				},
				{
					data: "dognet_docpaper.docFileID",
					render: function(id) {
						/*
						            return id ?
						                '<a class="" target="_blank" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet'+editor_zayv_child_files.file( 'dognet_docpaper_files', id ).file_webpath+'"><span class="glyphicon glyphicon-file"></span></a>' :
						                '<span class="glyphicon glyphicon-option-horizontal"></span>';
						*/
						return id ?
							'' : '';
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
					orderable: true,
					searchable: false,
					targets: 2
				},
				{
					orderable: true,
					searchable: false,
					targets: 3
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
					table_zayv_child_dop_docspec.ajax.reload();
					table_zayv_child_dop_docspec.columns().search('').draw();
				}
			}],
			drawCallback: function() {

			}
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
				label: "Поставщик :",
				type: "select",
				name: "dognet_doczayvchet.kodpost",
				def: "---",
				placeholder: "Выберите поставщика"
			}, {
				label: "Покуптель :",
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
			/* 	    table_zayv_main.ajax.reload(null, false); */
		});
		editor_zayv_child_chet.on('open', function(e) {
			$('#zayvview-zayv-child-chet-kodzayv_filter').val('');
			// Поиск в ниспадающем списке по содержимому текстового поля для названия заявки
			$('#DTE_Field_dognet_doczayvchet-kodzayv').filterByText(editor_zayv_child_chet, $('#zayvview-zayv-child-chet-kodzayv_filter'), 'dognet_doczayvchet.kodzayv', false);
			//
			$('#zayvview-zayv-child-chet-kodpost_filter').val('');
			// Поиск в ниспадающем списке по содержимому текстового поля для названия заявки
			$('#DTE_Field_dognet_doczayvchet-kodpost').filterByText(editor_zayv_child_chet, $('#zayvview-zayv-child-chet-kodpost_filter'), 'dognet_doczayvchet.kodpost', false);
			//
			$('#zayvview-zayv-child-chet-kodpokup_filter').val('');
			// Поиск в ниспадающем списке по содержимому текстового поля для названия заявки
			$('#DTE_Field_dognet_doczayvchet-kodpokup').filterByText(editor_zayv_child_chet, $('#zayvview-zayv-child-chet-kodpokup_filter'), 'dognet_doczayvchet.kodpokup', false);
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
				if (data.dognet_doczayvchet.zayvchetpr < 100.00 || data.dognet_doczayvchet.zayvchetzadol > 0.00) {
					$('td', row).eq(6).addClass('highlight_warning');
					$('td', row).eq(7).addClass('highlight_warning');
				}
				if (data.dognet_doczayvchet.zayvchetpr > 100.00 || data.dognet_doczayvchet.zayvchetzadol < 0.00) {
					$('td', row).eq(6).addClass('highlight_alarm');
					$('td', row).eq(7).addClass('highlight_alarm');
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
				}
			],
			order: [
				[1, "desc"]
			],
			ordering: true,
			paging: true,
			searching: true,
			pageLength: 15,
			lengthChange: true,
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
		var detailRows_zayv_child_chet = [];
		$('#zayvview-zayv-child-chet tbody').on('click', 'tr td.details-control', function() {
			var tr = $(this).closest('tr');
			var row = table_zayv_child_chet.row(tr);
			var idx = $.inArray(tr.attr('id'), detailRows_zayv_child_chet);

			if (row.child.isShown()) {
				tr.removeClass('details');
				row.child.hide();

				// Remove from the 'open' array
				detailRows_zayv_child_chet.splice(idx, 1);
			} else {
				tr.addClass('details');
				rowData = table_zayv_child_chet.row(row);
				d = row.data();
				rowData.child(<?php include('templates/zayvview-chet-details.tpl'); ?>).show();

				// Add to the 'open' array
				if (idx === -1) {
					detailRows_zayv_child_chet.push(tr.attr('id'));
				}
			}
		});
		// On each draw, loop over the `detailRows` array and show any child rows
		table_zayv_child_chet.on('draw', function() {
			$.each(detailRows_zayv_child_chet, function(i, id) {
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
						d.kodzayv = selected.data().dognet_doczayvchet.kodzayv;
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
				label: "",
				type: "select",
				name: "dognet_doczayvchetf.kodzayvchet",
				def: "---",
				placeholder: "Выберите счет"
			}, {
				label: "",
				type: "checkbox",
				name: "kodzayvchet_transfer_enbl",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
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
			//
			selected = table_zayv_child_chet.row({
				selected: true
			});
			var kodzayvchet = "";
			if (selected.any()) {
				kodzayvchet = selected.data().dognet_doczayvchet.kodzayvchet;
			}
			editor_chet_child_chetf.field('dognet_doczayvchetf.kodzayvchet').val(kodzayvchet);
		});
		editor_chet_child_chetf.on('initEdit', function(e, node, data, items, type) {
			editor_chet_child_chetf.field('dognet_doczayvchetf.msgDocFileID').hide();
			editor_chet_child_chetf.field('dognet_doczayvchetf.docFileID').show();
			editor_chet_child_chetf.field('dognet_doczayvchetf.docFileID').enable();
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
						d.kodzayv = selected.data().dognet_doczayvchet.kodzayv;
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
					targets: 6
				},
				{
					orderable: false,
					searchable: false,
					targets: 7
				}
			],
			order: [
				[1, "desc"],
				[2, "asc"]
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
		// ----- ----- -----
		// Обработчик child-таблицы выбранного счета
		// Array to track the ids of the details displayed rows
		var detailRows_chet_child_chetf = [];
		$('#zayvview-chet-child-chetf tbody').on('click', 'tr td.details-control', function() {
			var tr = $(this).closest('tr');
			var row = table_chet_child_chetf.row(tr);
			var idx = $.inArray(tr.attr('id'), detailRows_chet_child_chetf);

			if (row.child.isShown()) {
				tr.removeClass('details');
				row.child.hide();

				// Remove from the 'open' array
				detailRows_chet_child_chetf.splice(idx, 1);
			} else {
				tr.addClass('details');
				rowData = table_chet_child_chetf.row(row);
				d = row.data();
				rowData.child(<?php include('templates/zayvview-chetf-details.tpl'); ?>).show();

				// Add to the 'open' array
				if (idx === -1) {
					detailRows_chet_child_chetf.push(tr.attr('id'));
				}
			}
		});
		// On each draw, loop over the `detailRows` array and show any child rows
		table_chet_child_chetf.on('draw', function() {
			$.each(detailRows_chet_child_chetf, function(i, id) {
				$('#' + id + ' td.details-control').trigger('click');
			});
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		// Обработчик формы редактора заявок
		editor_chet_child_chetf.on('open', function(e) {
			$('#zayvview-chet-child-chetf-kodzayvchet_filter').val('');
			// Поиск в ниспадающем списке по содержимому текстового поля для ответного документа
			$('#DTE_Field_dognet_doczayvchetf-kodzayvchet').filterByText(editor_chet_child_chetf, $('#zayvview-chet-child-chetf-kodzayvchet_filter'), 'dognet_doczayvchetf.kodzayvchet', false);

			editor_chet_child_chetf.dependent('kodzayvchet_transfer_enbl', function(val) {
				if (val == 0) {
					editor_chet_child_chetf.field('dognet_doczayvchetf.kodzayvchet').disable();
					$('#zayvview-chet-child-chetf-kodzayv_filter').prop('disabled', true);
				}
				if (val == 1) {
					editor_chet_child_chetf.field('dognet_doczayvchetf.kodzayvchet').enable();
					$('#zayvview-chet-child-chetf-kodzayvchet_filter').prop('disabled', false);
				}
			});

		});
		editor_chet_child_chetf.on('close', function(e) {
			table_chet_child_chetf.ajax.reload(null, false);
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
			//
			var rowData = table_zayv_main.row({
				selected: true
			}).data();
			if (rowData.dognet_doczayv.kodrabzayv == 1) {
				table_zayv_child_dop.buttons().enable();
			} else {
				table_zayv_child_dop.buttons().disable();
			}
			//
			if (rowData.dognet_doczayv.kodrabfile == 1) {
				table_zayv_child_files.buttons().enable();
			} else {
				table_zayv_child_files.buttons().disable();
			}
			//
			table_zayv_child_dop.ajax.reload(null, true);
			/* 		table_zayv_child_files.buttons().enable(); */
			table_zayv_child_files.ajax.reload(null, true);
			table_zayv_child_dop_docspec.buttons().enable();
			table_zayv_child_dop_docspec.ajax.reload(null, true);
		});
		table_zayv_main.on('deselect', function() {
			table_zayv_child_dop.buttons().disable();
			table_zayv_child_dop.rows().deselect();
			table_zayv_child_dop.ajax.reload(null, true);
			table_zayv_child_files.buttons().disable();
			table_zayv_child_files.rows().deselect();
			table_zayv_child_files.ajax.reload(null, true);
			table_zayv_child_chet.rows().deselect();
			table_zayv_child_chet.buttons().disable();
			table_zayv_child_chet.ajax.reload(null, true);
			table_chet_child_chetf.buttons().disable();
			table_chet_child_chetf.rows().deselect();
			table_chet_child_chetf.ajax.reload(null, true);
			table_zayv_child_dop_docspec.buttons().disable();
			table_zayv_child_dop_docspec.rows().deselect();
			table_zayv_child_dop_docspec.ajax.reload(null, true);
		});
		// ----- ----- -----
		// Обработчики событий редактора счета
		editor_zayv_child_chet.on('submitSuccess', function() {
			/* 	    table_zayv_main.ajax.reload(null, false); */
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
				.columns(4)
				.search($("#zayvNumberSearch_text").val())
				.draw();

			table_zayv_main
				.columns(10)
				.search($("#docNumberSearch_text").val())
				.draw();

			table_zayv_main
				.columns(9)
				.search($("#zayvTelSearch_text").val())
				.draw();

			table_zayv_main
				.columns(2)
				.search($("#zayvYearSearch_text").val())
				.draw();

			table_zayv_main
				.columns(3)
				.search($("#zayvTipSearch_text").val())
				.draw();

			table_zayv_main
				.columns(11)
				.search($("#zayvTipSpecSearch_text").val())
				.draw();

			table_zayv_main
				.columns(5)
				.search($("#zayvNameSearch_text").val())
				.draw();

			table_zayv_main
				.columns(12)
				.search($("#zayvTypeSearch_text").val())
				.draw();

			table_zayv_main
				.columns(1)
				.search($("#zayvStatusSearch_text").val())
				.draw();
		});
		$('#columnSearch_btnClear').click(function(e) {
			$('#docNumberSearch_text').val('');
			$('#zayvYearSearch_text').val('');
			$('#zayvNameSearch_text').val('');
			$('#zayvNumberSearch_text').val('');
			$('#zayvTelSearch_text').val('');
			$('#zayvTipSearch_text').val('');
			$('#zayvTipSpecSearch_text').val('');
			$('#zayvTypeSearch_text').val('');
			$('#zayvStatusSearch_text').val('');
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
		$("#zayvNumberSearch_text").on("keyup", function(event) {
			if (event.keyCode === 13) {
				event.preventDefault();
				document.getElementById("columnSearch_btnApply").click();
			}
		});
		$("#zayvYearSearch_text").on("keyup", function(event) {
			if (event.keyCode === 13) {
				event.preventDefault();
				document.getElementById("columnSearch_btnApply").click();
			}
		});
		$("#zayvNameSearch_text").on("keyup", function(event) {
			if (event.keyCode === 13) {
				event.preventDefault();
				document.getElementById("columnSearch_btnApply").click();
			}
		});

		$('#zayvview-zayv-main tbody').on('click', 'a.comments-click', function() {
			var tr = $(this).closest('tr');
			var data = table_zayv_main.row(tr).data();
			zayv_kod = data.dognet_doczayv.kodzayv;
			ajaxRequest_getFullMsg(zayv_kod, 'getFullMsg');
		});
	});
</script>

<?php
// ----- ----- ----- ----- -----
// Форма редактирования заявки
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/zayvview/zayvview-current/restr_4/css/zayvview-zayv-main-customform.css">
<div id="customForm-zayv-main">
	<div id="customForm-zayv-main-editor-tabs" style="width:100%">
		<ul id="customForm-zayv-main-editor-tabs-menu" class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#customForm-zayv-main-editor-tab-1" title="">Основание заявки</a></li>
			<li><a data-toggle="tab" href="#customForm-zayv-main-editor-tab-2" title="">Параметры</a></li>
			<li><a data-toggle="tab" href="#customForm-zayv-main-editor-tab-3" title="">Спецификация</a></li>
			<li><a data-toggle="tab" href="#customForm-zayv-main-editor-tab-4" title="">Отправка уведомлений</a></li>
		</ul>
		<div class="tab-content" style="padding:5px">
			<div id="customForm-zayv-main-editor-tab-1" class="tab-pane fade in active">
				<div class="Section">
					<div class="Block30">
						<legend>Без / условный договор</legend>
						<div class="Block100 fieldset-table-row">
							<div class="fieldset-table-cell" style="padding-bottom:3px">
								<fieldset>
									<editor-field name="kodusezayv_0"></editor-field>
								</fieldset>
							</div>
							<div class="fieldset-table-cell" style="width:100%">
								<div>
									<div class="chekbox-inline-text">Без договора</div>
								</div>
							</div>
						</div>
						<div class="Block100 fieldset-table-row">
							<div class="fieldset-table-cell" style="padding-bottom:3px">
								<fieldset>
									<editor-field name="kodusezayv_1"></editor-field>
								</fieldset>
							</div>
							<div class="fieldset-table-cell" style="width:100%">
								<div>
									<div class="chekbox-inline-text">Для нужд АТГС</div>
								</div>
							</div>
						</div>
						<div class="Block100 fieldset-table-row">
							<div class="fieldset-table-cell" style="padding-bottom:3px">
								<fieldset>
									<editor-field name="kodusezayv_2"></editor-field>
								</fieldset>
							</div>
							<div class="fieldset-table-cell" style="width:100%">
								<div>
									<div class="chekbox-inline-text">На склад</div>
								</div>
							</div>
						</div>
					</div>
					<div class="Block70">
						<legend>На основании официального договора</legend>
						<fieldset class="field100 koddocFilter" style="padding-left:15px; padding-right:15px">
							<input id="zayvview-zayv-main-koddoc_filter" type="text" placeholder="Вводите либо год, либо номер, либо текст из названия договора" />
						</fieldset>
						<fieldset class="field100">
							<editor-field name="dognet_doczayv.koddoc"></editor-field>
						</fieldset>
					</div>
					<div class="Block100">
						<legend>Комментарии к заявке</legend>
						<fieldset class="field100">
							<editor-field name="dognet_doczayv.zayvchetcom"></editor-field>
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
					<div class="Block60">
						<legend>Описание заявки (спецификации)</legend>
						<fieldset class="field100">
							<editor-field name="dognet_doczayv.namerabfilespec"></editor-field>
						</fieldset>
					</div>
					<div class="Block40">
						<legend>Статус заявки</legend>
						<fieldset class="field100">
							<editor-field name="dognet_doczayv.tipusezayv"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
			<div id="customForm-zayv-main-editor-tab-3" class="tab-pane fade">
				<div class="Section">
					<div class="Block50">
						<legend>Вид спецификации</legend>
						<div class="Block100 fieldset-table-row">
							<div class="fieldset-table-cell" style="padding-bottom:3px">
								<fieldset>
									<editor-field name="dognet_doczayv.kodrabzayv"></editor-field>
								</fieldset>
							</div>
							<div class="fieldset-table-cell" style="width:100%">
								<div>
									<div class="chekbox-inline-text">Спецификация в виде списка</div>
								</div>
							</div>
						</div>
						<div class="Block100 fieldset-table-row">
							<div class="fieldset-table-cell" style="padding-bottom:3px">
								<fieldset>
									<editor-field name="dognet_doczayv.kodrabfile"></editor-field>
								</fieldset>
							</div>
							<div class="fieldset-table-cell" style="width:100%">
								<div>
									<div class="chekbox-inline-text">Спецификации в виде файлов</div>
								</div>
							</div>
						</div>
					</div>
					<div class="Block50">
						<legend>Файл</legend>
						<fieldset class="field100">
							<editor-field name="dognet_doczayv.msgDocFileID"></editor-field>
						</fieldset>
						<fieldset class="field100">
							<editor-field name="dognet_doczayv.docFileID"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
			<div id="customForm-zayv-main-editor-tab-4" class="tab-pane fade">
				<div class="Section">
					<div class="Block100">
						<legend>Отправить сообщение</legend>
						<div class="Block100 fieldset-table-row">
							<div class="fieldset-table-cell" style="padding-bottom:3px">
								<fieldset>
									<editor-field name="sendMessage"></editor-field>
								</fieldset>
							</div>
							<div class="fieldset-table-cell" style="width:100%">
								<div>
									<div class="chekbox-inline-text">Уведомить по email группу "Заявки" (функция временно отключена, используйте ручную рассылку)</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Форма редактирования позиций спецификации (список)
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/zayvview/zayvview-current/restr_4/css/zayvview-zayv-child-dop-customform.css">
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
// Форма редактирования позиций спецификации (файл)
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/zayvview/zayvview-current/restr_4/css/zayvview-zayv-child-files-customform.css">
<div id="customForm-zayv-child-files">
	<div id="customForm-zayv-child-files-editor-tabs" style="width:100%">
		<ul id="customForm-zayv-child-files-editor-tabs-menu" class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#customForm-zayv-child-files-editor-tab-1" title="">Параметры</a></li>
		</ul>
		<div class="tab-content" style="padding:5px">
			<div id="customForm-zayv-child-files-editor-tab-1" class="tab-pane fade in active">
				<div class="Section">
					<div class="Block100">
						<legend>Позиция спецификации</legend>
						<fieldset class="field100">
							<editor-field name="dognet_doczayvdopspec.namedopspec"></editor-field>
						</fieldset>
						<fieldset class="field100">
							<editor-field name="dognet_doczayvdopspec.msgDocFileID"></editor-field>
						</fieldset>
						<fieldset class="field100">
							<editor-field name="dognet_doczayvdopspec.dopFileID"></editor-field>
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
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/zayvview/zayvview-current/restr_4/css/zayvview-zayv-child-chet-customform.css">
<div id="customForm-zayv-child-chet">
	<div id="customForm-zayv-child-chet-editor-tabs" style="width:100%">
		<ul id="customForm-zayv-child-chet-editor-tabs-menu" class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#customForm-zayv-child-chet-editor-tab-1" title="">Параметры</a></li>
			<li><a data-toggle="tab" href="#customForm-zayv-child-chet-editor-tab-2" title="">Поставщик</a></li>
			<li><a data-toggle="tab" href="#customForm-zayv-child-chet-editor-tab-3" title="">Примечание</a></li>
			<li><a data-toggle="tab" href="#customForm-zayv-child-chet-editor-tab-4" title="">Файл</a></li>
		</ul>
		<div class="tab-content" style="padding:5px">
			<div id="customForm-zayv-child-chet-editor-tab-1" class="tab-pane fade in active">
				<div class="Section">
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
			<div id="customForm-zayv-child-chet-editor-tab-2" class="tab-pane fade">
				<div class="Section">
					<div class="Block100">
						<legend>Поставщик</legend>
						<fieldset class="field60">
							<editor-field name="dognet_doczayvchet.kodpost"></editor-field>
						</fieldset>
						<fieldset class="field40 kodpostFilter" style="padding:30px 15px 0;">
							<input id="zayvview-zayv-child-chet-kodpost_filter" type="text" placeholder="Поиск поставщика" />
						</fieldset>
					</div>
					<div class="Block100">
						<legend>Покупатель</legend>
						<fieldset class="field60">
							<editor-field name="dognet_doczayvchet.kodpokup"></editor-field>
						</fieldset>
						<fieldset class="field40 kodpokupFilter" style="padding:30px 15px 0;">
							<input id="zayvview-zayv-child-chet-kodpokup_filter" type="text" placeholder="Поиск покупателя" />
						</fieldset>
					</div>
				</div>
			</div>
			<div id="customForm-zayv-child-chet-editor-tab-3" class="tab-pane fade">
				<div class="Section">
					<div class="Block100">
						<legend>Примечание к счету</legend>
						<fieldset class="field100">
							<editor-field name="dognet_doczayvchet.zayvchetcomment"></editor-field>
						</fieldset>
					</div>
				</div>
			</div>
			<div id="customForm-zayv-child-chet-editor-tab-4" class="tab-pane fade">
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
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/zayvview/zayvview-current/restr_4/css/zayvview-chet-child-chetf-customform.css">
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
						<legend>Счет</legend>
						<div class="Block100 fieldset-table-row">
							<div class="fieldset-table-cell" style="padding-bottom:3px">
								<fieldset>
									<editor-field name="kodzayvchet_transfer_enbl"></editor-field>
								</fieldset>
							</div>
							<div class="fieldset-table-cell" style="width:100%">
								<div>
									<div class="chekbox-inline-text">Создать/перенести счет-фактуру на другой счет (в пределах заявки)</div>
								</div>
							</div>
						</div>
						<fieldset class="field60">
							<editor-field name="dognet_doczayvchetf.kodzayvchet"></editor-field>
						</fieldset>
						<fieldset class="field40 kodzayvchetFilter" style="padding:7px 15px 0;">
							<input id="zayvview-chet-child-chetf-kodzayvchet_filter" type="text" placeholder="Поиск счета" />
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
<div id="tab-1" class="tab-pane fade in active">
	<div class="space30"></div>
	<div id="zayvsearch-filters-block" class="panel-group">
		<div class="panel panel-default">
			<div class="panel-heading" style="padding:10px; background-color:#fafafa">
				<h4 class="space20 text-uppercase" style="color:#31708f; font-family:'Oswald', sans-serif; font-weight:400; letter-spacing:0.4em; padding-bottom:5px; border-bottom:4px #fff solid">
					<a data-toggle="collapse" href="#zayvsearch-filters">Фильтры для поиска заявки</a>
				</h4>
			</div>
			<div id="zayvsearch-filters" class="panel-collapse collapse in">

				<div id="zayvview-current-filters" class="panel-body space30" style="background-color:#fafafa">
					<div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
						<div class="form-group space10" style="width:100%">
							<label for="zayvYearSearch_text"><b>Год :</b></label>
							<select name="zayvYearSearch_text" id="zayvYearSearch_text" class="form-control">
								<option value="">Все года</option>
								<?php
								$_QRY = mysqlQuery("SELECT MIN(datezayv) as minzayvdate, MAX(datezayv) as maxzayvdate FROM dognet_doczayv WHERE koddel<>'99'");
								$_ROW = mysqli_fetch_assoc($_QRY);
								for ($y = date("Y"); $y >= 2005; $y--) {
								?>
									<option value='<?php echo $y; ?>'><?php echo $y; ?></option>
								<?php
								}
								?>
							</select>
						</div>
					</div>
					<div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
						<div class="form-group space10" style="width:100%">
							<label for="docNumberSearch_text"><b>№ договора :</b></label>
							<input type="text" id="docNumberSearch_text" class="form-control" placeholder="Все" name="docNumberSearch_text">
						</div>
					</div>
					<div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
						<div class="input-group space10" style="width:100%">
							<label for="zayvTipSearch_text"><b>Тип заявки :</b></label>
							<select name="zayvTipSearch_text" id="zayvTipSearch_text" class="form-control">
								<option value="">Все типы</option>
								<?php
								$_QRY3 = mysqlQuery("SELECT kodtipzayvall, nametipzayvshotall FROM dognet_sptipzayvall WHERE nametipzayvshotall<>'' AND koddel<>'99'");
								while ($_ROW3 = mysqli_fetch_assoc($_QRY3)) {
								?>
									<option value='<?php echo $_ROW3["nametipzayvshotall"]; ?>'><?php echo $_ROW3["nametipzayvshotall"]; ?></option>
								<?php
								}
								?>
							</select>
						</div>
					</div>
					<div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
						<div class="form-group space10" style="width:100%">
							<label for="zayvNumberSearch_text"><b>№ заявки :</b></label>
							<input type="text" id="zayvNumberSearch_text" class="form-control" placeholder="Все номера" name="zayvNumberSearch_text">
						</div>
					</div>
					<div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
						<div class="input-group space10" style="width:100%">
							<label for="zayvTelSearch_text"><b>Заявитель :</b></label>
							<select name="zayvTelSearch_text" id="zayvTelSearch_text" class="form-control">
								<option value="">Все заявители</option>
								<?php
								$_QRY3 = mysqlQuery(" SELECT kodzayvtel, namezayvtel, namezayvtelshot FROM dognet_spzayvtel WHERE namezayvtelshot<>'' AND koddel<>'99' AND kodzayvtel<>'0000000000000000'");
								while ($_ROW3 = mysqli_fetch_assoc($_QRY3)) {
								?>
									<option value='<?php echo $_ROW3["kodzayvtel"]; ?>'><?php echo $_ROW3["namezayvtelshot"]; ?></option>
								<?php
								}
								?>
							</select>
						</div>
					</div>
					<div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
						<div class="input-group space10" style="width:100%">
							<label for="zayvTipSpecSearch_text"><b>Список позиций:</b></label>
							<select name="zayvTipSpecSearch_text" id="zayvTipSpecSearch_text" class="form-control">
								<option value="">Все</option>
								<option value="0">Прикрепленный файл</option>
								<option value="1">Список внутри заявки</option>
							</select>
						</div>
					</div>
					<?php // ----- ----- ----- ----- ----- 
					?>
					<div class="col-xs-12 col-sm-3 col-md-6 col-lg-4">
						<div class="input-group space10" style="width:100%">
							<label for="zayvNameSearch_text"><b>Текст из описания заявки :</b></label>
							<input type="text" id="zayvNameSearch_text" class="form-control" placeholder="Введите текст для поиска в описании" name="zayvNameSearch_text">
						</div>
					</div>
					<div class="col-xs-12 col-sm-3 col-md-2 col-lg-2">
						<div class="input-group space10" style="width:100%">
							<label for="zayvTypeSearch_text"><b>Обоснование заявки:</b></label>
							<select name="zayvTypeSearch_text" id="zayvTypeSearch_text" class="form-control">
								<option value="">---</option>
								<option value="000000000000000">Без договора</option>
								<option value="245375260650765">Для нужд АТГС</option>
								<option value="245375544141726">На склад</option>
							</select>
						</div>
					</div>
					<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
						<div class="input-group space10" style="width:100%">
							<label for="zayvStatusSearch_text"><b>Статус заявки:</b></label>
							<select name="zayvStatusSearch_text" id="zayvStatusSearch_text" class="form-control">
								<option value="">---</option>
								<option value="0">Заявка сформирована</option>
								<option value="1">Выставлена часть счетов</option>
								<option value="4">Выставлены все счета</option>
								<option value="2">Заявка закрыта</option>
								<option value="3">Заявка аннулирована</option>
							</select>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 text-right">
						<div class="input-group-btn" style="padding-top:25px">
							<button id="columnSearch_btnApply" class="btn btn-default" type="button">Применить</button>
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
	<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/zayvview/zayvview-current/restr_4/css/zayvview-zayv-main.css">
	<div class="demo-html"></div>
	<table id="zayvview-zayv-main" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
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
				<th></th>
			</tr>
		</thead>
	</table>

	<style>
		.label-icon {
			color: #111;
			background-color: transparent;
			border: 1px #f1f1f1 solid;
			padding: 0.5em;
			margin-left: 15px;
			margin-right: 15px;
		}

		.label-icon-zayv2 {
			color: #fff;
			background-color: #009b00;
		}
	</style>

	<div class="" style="margin-top:15px">

		<div style="float: left">
			<p><span class="label label-icon"><span class="glyphicon glyphicon-pushpin" title="Заявка сформирована"></span></span><span style="font-size:0.9em; font-family: 'HelliosCond', sans-serif; font-weight: 400; color:#8d8d8d">Заявка сформирована</span></p>
		</div>
		<div style="float: left">
			<p><span class="label label-icon"><span class="text-warning glyphicon glyphicon-credit-card" title="Есть выставленные счета"></span></span><span style="font-size:0.9em; font-family: 'HelliosCond', sans-serif; font-weight: 400; color:#8d8d8d">Есть выставленные счета</span></p>
		</div>
		<div style="float: left">
			<p><span class="label label-icon"><span class="text-info glyphicon glyphicon-credit-card" title="Все счета выставлены"></span></span><span style="font-size:0.9em; font-family: 'HelliosCond', sans-serif; font-weight: 400; color:#8d8d8d">Все счета выставлены</span></p>
		</div>
		<div style="float: left">
			<p><span class="label label-icon label-icon-zayv2"><span class="glyphicon glyphicon-ok-circle" title="Заявка закрыта"></span></span><span style="font-size:0.9em; font-family: 'HelliosCond', sans-serif; font-weight: 400; color:#8d8d8d">Заявка закрыта</span></p>
		</div>
		<div style="float: left">
			<p><span class="label label-icon"><span class="text-danger glyphicon glyphicon-ban-circle" title="Заявка аннулирована"></span></span><span style="font-size:0.9em; font-family: 'HelliosCond', sans-serif; font-weight: 400; color:#8d8d8d">Заявка аннулирована</span></p>
		</div>
		<div style="float: left">
			<p><span class="label label-icon"><span class="glyphicon glyphicon-comment" title="Есть комментарий к заявке"></span></span><span style="font-size:0.9em; font-family: 'HelliosCond', sans-serif; font-weight: 400; color:#8d8d8d">Есть комментарий к заявке</span></p>
		</div>
		<div style="float: left">
			<p><span class="label label-icon"><span class="glyphicon glyphicon-file" title="Спецификация в виде файла"></span></span><span style="font-size:0.9em; font-family: 'HelliosCond', sans-serif; font-weight: 400; color:#8d8d8d">Спецификация в виде файла</span></p>
		</div>
		<div style="float: left">
			<p><span class="label label-icon"><span class="glyphicon glyphicon-list-alt" title="Спецификация в виде списка"></span></span><span style="font-size:0.9em; font-family: 'HelliosCond', sans-serif; font-weight: 400; color:#8d8d8d">Спецификация в виде списка</span></p>
		</div>
		<div style="float: left">
			<p><span class="label label-icon"><span class="glyphicon glyphicon-print" title="Распечатать заявку (в разработке)"></span></span><span style="font-size:0.9em; font-family: 'HelliosCond', sans-serif; font-weight: 400; color:#8d8d8d">Распечатать заявку (в разработке)</span></p>
		</div>
		<div style="float: left">
			<p><span class="label label-icon"><span class="glyphicon glyphicon-send" title="Разослать уведомления на email"></span></span><span style="font-size:0.9em; font-family: 'HelliosCond', sans-serif; font-weight: 400; color:#8d8d8d">Разослать уведомления на email</span></p>
		</div>

	</div>

</div>

<?php // ----- ----- ----- ----- ----- 
?>

<div id="tab-2" class="tab-pane fade">
	<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/zayvview/zayvview-current/restr_4/css/zayvview-zayv-child-dop.css">
	<div class="space30"></div>
	<div id="zayvview-zayv-child-dop-spec" style="">
		<div class="col-xs-12 space30" style="padding:10px; background-color:#fafafa">
			<h4 class="text-uppercase" style="color:#31708f; font-family:'Oswald', sans-serif; font-weight:400; letter-spacing:0.4em">Спецификация к заявке (список, создаваемый вручную)</h4>
		</div>
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
	<div class="space10"></div>
	<div class="text-danger" style="font-size:0.85em"><span class="glyphicon glyphicon-exclamation-sign" style="margin-right:10px"></span>Чтобы иметь возможность добавлять позиции в этот список, необходимо в параметрах заявки выбрать "Спецификация в виде списка".</div>
</div>

<?php // ----- ----- ----- ----- ----- 
?>

<div id="tab-3" class="tab-pane fade">
	<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/zayvview/zayvview-current/restr_4/css/zayvview-zayv-child-files.css">
	<div class="space30"></div>
	<div id="zayvview-zayv-child-files-spec" style="">
		<div class="col-xs-12 space30" style="padding:10px; background-color:#fafafa">
			<h4 class="text-uppercase" style="color:#31708f; font-family:'Oswald', sans-serif; font-weight:400; letter-spacing:0.4em">Спецификации к заявке (в виде прикреплённых файлов)</h4>
		</div>
		<div class="demo-html"></div>
		<table id="zayvview-zayv-child-files" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
					<th>#</th>
					<th>Название</th>
					<th></th>
				</tr>
			</thead>
		</table>
	</div>
	<div class="space10"></div>
	<div class="text-danger" style="font-size:0.85em"><span class="glyphicon glyphicon-exclamation-sign" style="margin-right:10px"></span>Чтобы иметь возможность добавлять позиции в этот список, необходимо в параметрах заявки выбрать "Спецификация в виде файла".</div>
</div>

<?php // ----- ----- ----- ----- ----- 
?>

<div id="tab-4" class="tab-pane fade">
	<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/zayvview/zayvview-current/restr_4/css/zayvview-zayv-child-chet.css">
	<div class="space30"></div>
	<div class="col-xs-12 space30" style="padding:10px; background-color:#fafafa">
		<h4 class="text-uppercase" style="color:#31708f; font-family:'Oswald', sans-serif; font-weight:400; letter-spacing:0.4em">Счета</h4>
	</div>
	<div class="demo-html"></div>
	<table id="zayvview-zayv-child-chet" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
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
			</tr>
		</thead>
	</table>
	<?php // ----- ----- ----- ----- ----- 
	?>
	<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/zayvview/zayvview-current/restr_4/css/zayvview-chet-child-chetf.css">
	<div class="space30"></div>
	<div class="col-xs-12 space30" style="padding:10px; background-color:#fafafa">
		<h4 class="text-uppercase" style="color:#31708f; font-family:'Oswald', sans-serif; font-weight:400; letter-spacing:0.4em">Счета-фактуры</h4>
	</div>
	<div class="demo-html"></div>
	<table id="zayvview-chet-child-chetf" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
				<th>Дата</th>
				<th>Счет-фактура</th>
				<th>Счет</th>
				<th>Примечание</th>
				<th>Сумма</th>
				<th>Статус</th>
				<th><span class="glyphicon glyphicon-file"></span></th>
			</tr>
		</thead>
	</table>
</div>

<?php // ----- ----- ----- ----- ----- 
?>

<div id="tab-5" class="tab-pane fade">
	<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/zayvview/zayvview-current/restr_4/css/zayvview-zayv-child-dop-docspec.css">
	<div class="space30"></div>
	<div class="col-xs-12 space30" style="padding:10px; background-color:#fafafa">
		<h4 class="text-uppercase" style="color:#31708f; font-family:'Oswald', sans-serif; font-weight:400; letter-spacing:0.4em">Спецификации из договора</h4>
	</div>
	<div class="demo-html"></div>
	<table id="zayvview-zayv-child-dop-docspec" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
				<th>ID</th>
				<th>Описание</th>
				<th></th>
			</tr>
		</thead>
	</table>
</div>

<!-- Modal -->
<div id="zayvComments-modal" class="modal fade" role="dialog">
	<div class="modal-dialog" style="width:60%; min-width:640px; max-width:800px">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header" style="padding:5px 15px; border-bottom:none">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 id="" class="modal-title">Комментарии к заявке</h4>
			</div>
			<div class="modal-body">
				<div id="zayvComments-text"></div>
			</div>
		</div>

	</div>
</div>