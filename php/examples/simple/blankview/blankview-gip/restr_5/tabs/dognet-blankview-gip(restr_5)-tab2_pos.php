<script type="text/javascript" language="javascript" class="init">
	//
	//
	var reqField_sendMailPOS = {
		sendMail: function(response) {}
	};

	function ajaxRequest_sendMailPOS(blanktip, blankname, ispolname, ispolrukname, objname, zakname, summablank, responseHandler) {
		var response = false;
		// Fire off the request to /form.php
		request = $.ajax({
			url: "php/examples/simple/blankview/blankview-gip/restr_5/tabs/php/sendMail_onSubmit-newBlankPOS.php",
			type: "post",
			cache: false,
			data: {
				blanktip: blanktip,
				blankname: blankname,
				ispolname: ispolname,
				ispolrukname: ispolrukname,
				objname: objname,
				zakname: zakname,
				summablank: summablank
			},
			success: reqField_sendMailPOS[responseHandler]
		});
		// Callback handler that will be called on success
		request.done(function(response, textStatus, jqXHR) {
			res1 = response.replace(new RegExp("\\r?\\n", "g"), "");
			if (res1 == '0') {
				console.log("Письмо отправлено");
				// $("#ajaxResponse_reqUnlockDoc_msg").html('Запрос в ОД отправлен');
			}
			if (res1 == '-1') {
				console.log("Лог файл недоступен для записи");
				// $("#ajaxResponse_reqUnlockDoc_msg").html('Что-то пошло не так...');
			}
			if (res1 == '-2') {
				console.log("Не возможно открыть лог файл");
				// $("#ajaxResponse_reqUnlockDoc_msg").html('Ошибка запроса');
			}
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
	//
	//

	$(document).ready(function() {
		//
		//
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		// API INSTANCE ФОРМЫ БЛАНКА ГИПА НА ПОСТАВКУ ::: Редактор
		var editor_blankview_edit_pos = new $.fn.dataTable.Editor({
			display: "bootstrap",
			ajax: "php/examples/php/blankview/blankview-gip/dognet-blankview-gip-pos-process.php",
			table: "#blankview-gip-pos-table",
			i18n: {
				create: {
					title: "<h3>Создать новую заявку на договор поставки</h3>"
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
			template: '#customForm_newblank_pos',
			fields: [{
				label: "Исполнитель (рук) :",
				name: "dognet_blankdocpost.kodispolruk",
				type: "select",
				def: "---",
				placeholder: "Выберите исполнителя"
			}, {
				label: "Исполнитель (ГИП) :",
				name: "dognet_blankdocpost.kodispol",
				type: "select",
				def: "---",
				placeholder: "Выберите ГИП"
			}, {
				label: "Организация (справочник) :",
				name: "dognet_blankdocpost.kodzakaz",
				type: "select",
				def: "---",
				placeholder: "Выберите заказчика"
			}, {
				label: "Название договора :",
				name: "dognet_blankdocpost.namedocblank"
			}, {
				label: "Как заказчик",
				type: "checkbox",
				name: "dognet_blankdocpost.kodorgzakaz",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "Как исполнитель",
				type: "checkbox",
				name: "dognet_blankdocpost.kodorgispol",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "Новая организация",
				type: "checkbox",
				name: "dognet_blankdocpost.koduseneworg",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "Справочник",
				type: "checkbox",
				name: "dognet_blankdocpost.kodusespzakaz",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "Название организации :",
				name: "dognet_blankdocpost.nameneworg",
				fieldInfo: ""
			}, {
				label: "Сумма договора :",
				name: "dognet_blankdocpost.csummadocopl"
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpost.kodusendsopl",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpost.kodusespechopl",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "Вариант 1",
				type: "checkbox",
				name: "dognet_blankdocpost.koduseopl1usl",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "Вариант 2",
				type: "checkbox",
				name: "dognet_blankdocpost.koduseopl2usl",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "Вариант 3",
				type: "checkbox",
				name: "dognet_blankdocpost.koduseopl3usl",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "Вариант 4",
				type: "checkbox",
				name: "dognet_blankdocpost.koduseopl4usl",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "Сумма аванса :",
				name: "dognet_blankdocpost.csummaopl1usl",
				fieldInfo: "( X процентов )"
			}, {
				label: "Сумма оплаты :",
				name: "dognet_blankdocpost.csummaopl2usl",
				fieldInfo: "( X процентов )"
			}, {
				label: "В течение :",
				name: "dognet_blankdocpost.cnumberoplday2usl",
				fieldInfo: "( N дней )"
			}, {
				label: "В течение :",
				name: "dognet_blankdocpost.cnumberoplday3usl",
				fieldInfo: "( N дней )"
			}, {
				label: "Иные условия :",
				name: "dognet_blankdocpost.ctextoplotherusl",
				type: "textarea"
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpost.kodusepril1",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpost.kodusepril2",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpost.kodusepril3",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpost.kodusepril4",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpost.kodusepril5",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "Особые условия договора :",
				name: "dognet_blankdocpost.defuslgiptext",
				type: "textarea",
				fieldInfo: ""
			}, {
				label: "По итогам выигранного тендера",
				type: "checkbox",
				name: "dognet_blankdocpost.kodusetender",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpost.koduseispoldoc1",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpost.koduseispoldoc2",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpost.koduseispoldoc3",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpost.koduseispoldoc4",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				name: "dognet_blankdocpost.cdateispoldoc1",
				attr: {
					placeholder: 'ДД/ММ/ГГГГ'
				},
				fieldInfo: ""
			}, {
				label: "",
				name: "dognet_blankdocpost.cdaysispoldoc2",
				attr: {
					placeholder: 'N дней'
				},
				fieldInfo: ""
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpost.kodusekomrasx1",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpost.kodusekomrasx2",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpost.kodusekomrasx3",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				name: "dognet_blankdocpost.komrasxprim",
				attr: {
					placeholder: ''
				},
				fieldInfo: ""
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpost.kodusetrans1",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpost.kodusetrans2",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpost.kodusetrans3",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				name: "dognet_blankdocpost.transprim",
				attr: {
					placeholder: ''
				},
				fieldInfo: ""
			}, {
				label: "Куда поставляется обрудование :",
				name: "dognet_blankdocpost.transplaceobor",
				type: "textarea",
				attr: {
					placeholder: ''
				},
				fieldInfo: ""
			}, {
				label: "",
				name: "dognet_blankdocpost.climitdays",
				attr: {
					placeholder: ''
				},
				fieldInfo: ""
			}, {
				label: "",
				name: "dognet_blankdocpost.numberdocmain",
				attr: {
					placeholder: ''
				},
				fieldInfo: ""
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpost.koduserisk1",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpost.koduserisk2",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpost.koduserisk3",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpost.koduserisk4",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				name: "dognet_blankdocpost.riskprim",
				attr: {
					placeholder: ''
				},
				fieldInfo: ""
			}, {
				label: "",
				name: "dognet_blankdocpost.nameendcontact",
				attr: {
					placeholder: ''
				},
				fieldInfo: ""
			}, {
				label: "",
				name: "dognet_blankdocpost.namefistcontact",
				attr: {
					placeholder: ''
				},
				fieldInfo: ""
			}, {
				label: "",
				name: "dognet_blankdocpost.namesecondcontact",
				attr: {
					placeholder: ''
				},
				fieldInfo: ""
			}, {
				label: "",
				name: "dognet_blankdocpost.namedoljcontact",
				attr: {
					placeholder: ''
				},
				fieldInfo: ""
			}, {
				label: "",
				name: "dognet_blankdocpost.nameemail",
				attr: {
					placeholder: ''
				},
				fieldInfo: ""
			}, {
				label: "",
				name: "dognet_blankdocpost.numbertelrab",
				attr: {
					placeholder: ''
				},
				fieldInfo: ""
			}, {
				label: "",
				name: "dognet_blankdocpost.numbertelmob",
				attr: {
					placeholder: ''
				},
				fieldInfo: ""
			}, {
				label: "",
				name: "dognet_blankdocpost.numbertelfax",
				attr: {
					placeholder: ''
				},
				fieldInfo: ""
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpost.kodblankcreate",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				type: "checkbox",
				name: "sendEmailPOS",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				def: "1",
				unselectedValue: 0
			}]
		});
		//
		// ----- ----- ----- ----- -----
		// Изменяем размер диалогового окна редактирования
		editor_blankview_edit_pos.on('open', function() {
			$(".modal-dialog").css({
				"width": "95%",
				"margin": "1.0em auto",
				"min-width": "800px",
				"max-width": "1170px"
			});
		});
		// ----- ----- ----- ----- -----
		var openVals1;
		editor_blankview_edit_pos.on('open', function() {
			$('#kodzakaz_filter_pos').val('');
			if (($('#DTE_Field_dognet_blankdocpost-kodzakaz').value) != editor_blankview_edit_pos.field('dognet_blankdocpost.kodzakaz').get()) {}
			// Поиск в ниспадающем списке по содержимому текстового поля для ответного документа
			$('#DTE_Field_dognet_blankdocpost-kodzakaz').filterByText(editor_blankview_edit_pos, $('#kodzakaz_filter_pos'), 'dognet_blankdocpost.kodzakaz', false);

			// Store the values of the fields on open
			openVals1 = JSON.stringify(editor_blankview_edit_pos.get());
			editor_blankview_edit_pos.on('preBlur', function(e) {
				// On close, check if the values have changed and ask for closing confirmation if they have
				if (openVals1 !== JSON.stringify(editor_blankview_edit_pos.get())) {
					return confirm('Вы не сохранили данные формы. Уверены, что хотите ее закрыть?');
				}
			})
		});
		editor_blankview_edit_pos.on("submit close", function() {
			editor_blankview_edit_pos.off("preBlur");
		});
		// ----- ----- ----- ----- -----
		editor_blankview_edit_pos.on('preSubmit', function(e) {
			var jsondata = JSON.stringify(editor_blankview_edit_pos.get());
			/* 		var jsondata = JSON.editor_blankview_edit_pos.get(); */
			var parsejson = JSON.parse(jsondata);
			if ((parsejson['dognet_blankdocpost.koduseopl1usl'] == 0) && (parsejson['dognet_blankdocpost.koduseopl2usl'] == 0) && (parsejson['dognet_blankdocpost.koduseopl3usl'] == 0) && (parsejson['dognet_blankdocpost.koduseopl4usl'] == 0)) {
				return confirm('Вы не определили порядок оплаты! Уверены, что хотите создать бланк?');
			}

		});
		// ----- ----- ----- ----- -----
		editor_blankview_edit_pos.on('postSubmit', function(e) {
			table_blankview_gip_pos.rows().deselect();
			table_blankview_gip_pos.ajax.reload();
		});
		// ----- ----- ----- ----- -----
		editor_blankview_edit_pos.on('initEdit', function(e) {
			editor_blankview_edit_pos.field('dognet_blankdocpost.nameneworg').set("");
			editor_blankview_edit_pos.field('dognet_blankdocpost.nameneworg').disable();
			editor_blankview_edit_pos.field('dognet_blankdocpost.koduseneworg').set(false);
			editor_blankview_edit_pos.field('dognet_blankdocpost.koduseneworg').disable();
			editor_blankview_edit_pos.field('dognet_blankdocpost.kodusespzakaz').set(true);
			editor_blankview_edit_pos.field('dognet_blankdocpost.kodusespzakaz').disable();
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		//
		//
		//
		//
		//
		//
		//
		//
		//
		//
		//
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		// API INSTANCE ЗАЯВКИ ГИПА НА ПОСТАВКУ ::: Редактор
		var editor_blankview_gip_pos = new $.fn.dataTable.Editor({
			display: "bootstrap",
			ajax: "php/examples/php/blankview/blankview-gip/dognet-blankview-gip-pos-process.php",
			table: "#blankview-gip-pos-table",
			i18n: {
				create: {
					title: "<h3>Создать новую заявку на договор поставки</h3>"
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
			/* 		template: '#customForm_docblank-table', */
			fields: [{
				label: "Номер договора :",
				name: "dognet_docblankwork.numberdoccr"
			}, {
				label: "Передан в работу :",
				name: "dognet_docblankwork.dateblankdoc",
				type: "datetime",
				format: "DD.MM.YYYY",
				def: function() {
					return new Date();
				},
				attr: {
					readonly: "readonly"
				}
			}, {
				label: "Заказчик :",
				name: "dognet_docblankwork.kodzakaz",
				type: "select",
				def: "---",
				placeholder: "Выберите заказчика"
			}]
		});
		// ----- ----- ----- ----- -----
		var openVals2;
		editor_blankview_gip_pos.on('preBlur', function(e) {
			// On close, check if the values have changed and ask for closing confirmation if they have
			if (openVals2 !== JSON.stringify(editor_blankview_gip_pos.get())) {
				return confirm('Вы изменили данные формы. Уверены, что хотите выйти из редактирования?');
			}
		})
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		//
		//
		//
		//
		//
		//
		//
		//
		//
		//
		//
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		// ::::: З А В И С И М О С Т И (dependences) : BEGIN
		//
		editor_blankview_edit_pos.dependent('dognet_blankdocpost.kodblankcreate', function(val) {
			if (val == 0) {
				$('#div-sendEmail-pos').css("display", "none");
				editor_blankview_edit_pos.field('sendEmailPOS').set(0);
				editor_blankview_edit_pos.field('sendEmailPOS').disable();
				editor_blankview_edit_pos.field('sendEmailPOS').hide(false);
			} else {
				$('#div-sendEmail-pos').css("display", "");
				editor_blankview_edit_pos.field('sendEmailPOS').set(1);
				editor_blankview_edit_pos.field('sendEmailPOS').show(false);
				editor_blankview_edit_pos.field('sendEmailPOS').enable();
			}
		});

		// TAB 1
		editor_blankview_edit_pos.dependent('dognet_blankdocpost.kodusespzakaz', function(val) {
			if (val == 0) {
				editor_blankview_edit_pos.field('dognet_blankdocpost.kodusespzakaz').disable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.kodzakaz').disable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.kodzakaz').set("");

				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseneworg').enable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseneworg').set(true);
				editor_blankview_edit_pos.field('dognet_blankdocpost.nameneworg').enable();
				$('#kodzakaz_filter_pos').prop('disabled', true);
			} else {}
		});
		editor_blankview_edit_pos.dependent('dognet_blankdocpost.koduseneworg', function(val) {
			if (val == 0) {
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseneworg').disable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.nameneworg').disable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.nameneworg').set("");

				editor_blankview_edit_pos.field('dognet_blankdocpost.kodusespzakaz').enable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.kodusespzakaz').set(true);
				editor_blankview_edit_pos.field('dognet_blankdocpost.kodzakaz').enable();
				$('#kodzakaz_filter_pos').prop('disabled', false);
			}
		});
		//
		//
		editor_blankview_edit_pos.dependent('dognet_blankdocpost.kodorgzakaz', function(val) {
			if (val == 1) {
				editor_blankview_edit_pos.field('dognet_blankdocpost.kodorgispol').disable();
			} else {
				editor_blankview_edit_pos.field('dognet_blankdocpost.kodorgispol').enable();
			}
		});
		editor_blankview_edit_pos.dependent('dognet_blankdocpost.kodorgispol', function(val) {
			if (val == 1) {
				editor_blankview_edit_pos.field('dognet_blankdocpost.kodorgzakaz').disable();
			} else {
				editor_blankview_edit_pos.field('dognet_blankdocpost.kodorgzakaz').enable();
			}
		});
		//
		//
		//
		// TAB 4
		editor_blankview_edit_pos.dependent('dognet_blankdocpost.koduseispoldoc1', function(val) {
			if (val == 1) {
				editor_blankview_edit_pos.field('dognet_blankdocpost.cdateispoldoc1').enable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseispoldoc2').disable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseispoldoc3').disable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseispoldoc4').disable();
				$("#useispoldoc1").css('outline-color', '#019401');
			} else {
				editor_blankview_edit_pos.field('dognet_blankdocpost.cdateispoldoc1').disable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseispoldoc2').enable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseispoldoc3').enable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseispoldoc4').enable();
				$("#useispoldoc1").css('outline-color', '#ccc');
			}
		});
		editor_blankview_edit_pos.dependent('dognet_blankdocpost.koduseispoldoc2', function(val) {
			if (val == 1) {
				editor_blankview_edit_pos.field('dognet_blankdocpost.cdaysispoldoc2').enable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseispoldoc1').disable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseispoldoc3').disable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseispoldoc4').disable();
				$("#useispoldoc2").css('outline-color', '#019401');
			} else {
				editor_blankview_edit_pos.field('dognet_blankdocpost.cdaysispoldoc2').disable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseispoldoc1').enable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseispoldoc3').enable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseispoldoc4').enable();
				$("#useispoldoc2").css('outline-color', '#ccc');
			}
			editor_blankview_edit_pos.dependent('dognet_blankdocpost.koduseispoldoc2', function(val) {
				if (val == 0) {
					editor_blankview_edit_pos.field('dognet_blankdocpost.cdaysispoldoc2').disable();
				} else {
					editor_blankview_edit_pos.field('dognet_blankdocpost.cdaysispoldoc2').enable();
				}
			});
		});
		editor_blankview_edit_pos.dependent('dognet_blankdocpost.koduseispoldoc3', function(val) {
			if (val == 1) {
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseispoldoc1').disable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseispoldoc2').disable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseispoldoc4').disable();
				$("#useispoldoc3").css('outline-color', '#019401');
			} else {
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseispoldoc1').enable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseispoldoc2').enable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseispoldoc4').enable();
				$("#useispoldoc3").css('outline-color', '#ccc');
			}
		});
		editor_blankview_edit_pos.dependent('dognet_blankdocpost.koduseispoldoc4', function(val) {
			if (val == 1) {
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseispoldoc1').disable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseispoldoc2').disable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseispoldoc3').disable();
				$("#useispoldoc4").css('outline-color', '#019401');
			} else {
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseispoldoc1').enable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseispoldoc2').enable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseispoldoc3').enable();
				$("#useispoldoc4").css('outline-color', '#ccc');
			}
		});
		//
		//
		//
		// TAB 6
		editor_blankview_edit_pos.dependent('dognet_blankdocpost.kodusetrans1', function(val) {
			if (val == 1) {
				editor_blankview_edit_pos.field('dognet_blankdocpost.kodusetrans2').disable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.kodusetrans3').disable();
			} else {
				editor_blankview_edit_pos.field('dognet_blankdocpost.kodusetrans2').enable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.kodusetrans3').enable();
			}
		});
		editor_blankview_edit_pos.dependent('dognet_blankdocpost.kodusetrans2', function(val) {
			if (val == 1) {
				editor_blankview_edit_pos.field('dognet_blankdocpost.kodusetrans1').disable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.kodusetrans3').disable();
			} else {
				editor_blankview_edit_pos.field('dognet_blankdocpost.kodusetrans1').enable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.kodusetrans3').enable();
			}
		});
		editor_blankview_edit_pos.dependent('dognet_blankdocpost.kodusetrans3', function(val) {
			if (val == 1) {
				editor_blankview_edit_pos.field('dognet_blankdocpost.kodusetrans1').disable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.kodusetrans2').disable();
			} else {
				editor_blankview_edit_pos.field('dognet_blankdocpost.kodusetrans1').enable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.kodusetrans2').enable();
			}
		});
		editor_blankview_edit_pos.dependent('dognet_blankdocpost.kodusetrans3', function(val) {
			if (val == 0) {
				editor_blankview_edit_pos.field('dognet_blankdocpost.transprim').disable();
			} else {
				editor_blankview_edit_pos.field('dognet_blankdocpost.transprim').enable();
			}
		});
		//
		//
		//
		// TAB 2
		editor_blankview_edit_pos.dependent('dognet_blankdocpost.koduseopl1usl', function(val) {
			if (val == 1) {
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseopl2usl').disable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseopl3usl').disable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseopl4usl').disable();
				$("#useopl1usl").css('outline-color', '#019401');
			} else {
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseopl2usl').enable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseopl3usl').enable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseopl4usl').enable();
				$("#useopl1usl").css('outline-color', '#ccc');
			}
		});
		editor_blankview_edit_pos.dependent('dognet_blankdocpost.koduseopl2usl', function(val) {
			if (val == 1) {
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseopl1usl').disable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseopl3usl').disable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseopl4usl').disable();
				$("#useopl2usl").css('outline-color', '#019401');
			} else {
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseopl1usl').enable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseopl3usl').enable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseopl4usl').enable();
				$("#useopl2usl").css('outline-color', '#ccc');
			}
		});
		editor_blankview_edit_pos.dependent('dognet_blankdocpost.koduseopl3usl', function(val) {
			if (val == 1) {
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseopl1usl').disable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseopl2usl').disable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseopl4usl').disable();
				$("#useopl3usl").css('outline-color', '#019401');
			} else {
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseopl1usl').enable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseopl2usl').enable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseopl4usl').enable();
				$("#useopl3usl").css('outline-color', '#ccc');
			}
		});
		editor_blankview_edit_pos.dependent('dognet_blankdocpost.koduseopl4usl', function(val) {
			if (val == 1) {
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseopl1usl').disable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseopl2usl').disable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseopl3usl').disable();
				$("#useopl4usl").css('outline-color', '#019401');
			} else {
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseopl1usl').enable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseopl2usl').enable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseopl3usl').enable();
				$("#useopl4usl").css('outline-color', '#ccc');
			}
		});
		//
		editor_blankview_edit_pos.dependent('dognet_blankdocpost.koduseopl1usl', function(val) {
			if (val == 0) {
				editor_blankview_edit_pos.field('dognet_blankdocpost.csummaopl1usl').disable();
			} else {
				editor_blankview_edit_pos.field('dognet_blankdocpost.csummaopl1usl').enable();
			}
		});
		editor_blankview_edit_pos.dependent('dognet_blankdocpost.koduseopl2usl', function(val) {
			if (val == 0) {
				editor_blankview_edit_pos.field('dognet_blankdocpost.csummaopl2usl').disable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.cnumberoplday2usl').disable();
			} else {
				editor_blankview_edit_pos.field('dognet_blankdocpost.csummaopl2usl').enable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.cnumberoplday2usl').enable();
			}
		});
		editor_blankview_edit_pos.dependent('dognet_blankdocpost.koduseopl3usl', function(val) {
			if (val == 0) {
				editor_blankview_edit_pos.field('dognet_blankdocpost.cnumberoplday3usl').disable();
			} else {
				editor_blankview_edit_pos.field('dognet_blankdocpost.cnumberoplday3usl').enable();
			}
		});
		editor_blankview_edit_pos.dependent('dognet_blankdocpost.koduseopl4usl', function(val) {
			if (val == 0) {
				editor_blankview_edit_pos.field('dognet_blankdocpost.ctextoplotherusl').disable();
			} else {
				editor_blankview_edit_pos.field('dognet_blankdocpost.ctextoplotherusl').enable();
			}
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		//
		//
		//
		//
		//
		//
		//
		//
		//
		//
		//
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		// БЛАНК ЗАЯВКИ ГИПА НА ПОСТАВКУ ::: Таблица данных
		var table_blankview_gip_pos = $('#blankview-gip-pos-table').DataTable({
			dom: "<'row'<'col-sm-9'B><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'p>>",
			// 		dom: "<'space50'r>tip",
			language: {
				url: "php/examples/simple/blankview/blankview-gip/dt_russian-tab2_pos.json"
			},
			ajax: {
				url: "php/examples/php/blankview/blankview-gip/dognet-blankview-gip-pos-process.php",
				type: "POST"
			},
			serverSide: true,
			columns: [{
					class: "details-control",
					searchable: false,
					orderable: false,
					data: null,
					defaultContent: "<span class='glyphicon glyphicon-list-alt'></span>"
				},
				{
					data: "dognet_blankdocpost.kodblankpost",
					className: ""
				},
				{
					data: "sp_contragents.nameshort",
					className: ""
				},
				{
					data: "dognet_blankdocpost.namedocblank",
					className: ""
				},
				{
					data: "dognet_spispolruk.ispolruknamefull",
					className: ""
				},
				{
					data: "dognet_blankdocpost.kodtipblank",
					className: ""
				}
			],
			select: {
				style: 'single',
				selector: 'td:not(:last-child)' // no row selection on last column
			},
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
					targets: 2,
					render: function(data, type, row, meta) {
						if (data != null) {
							fullstr = data;
							if (data.length > 60) {
								return data.substr(0, 60) + " ...";
							} else {
								return data;
							}
						} else {
							if (row.dognet_blankdocpost.koduseneworg == 1 && row.dognet_blankdocpost.nameneworg != "") {
								return row.dognet_blankdocpost.nameneworg;
							} else {
								return "---";
							}
						}
					}
				},
				{
					orderable: false,
					searchable: true,
					targets: 3,
					render: function(data, type, row, meta) {
						if (data != null) {
							fullstr = data;
							if (data.length > 60) {
								return data.substr(0, 60) + " ...";
							} else {
								return data;
							}
						} else {
							return "";
						}
					}
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
					targets: 5,
					render: function(data, type, row, meta) {
						return row.dognet_docblankwork.nametipblankwork;
					}
				}
			],
			order: [
				[1, "desc"],
				[5, "asc"]
			],
			select: true,
			processing: true,
			paging: true,
			searching: true,
			pageLength: 10,
			lengthChange: false,
			lengthMenu: [
				[15, 30, 50, -1],
				[15, 30, 50, "Все"]
			],
			buttons: [{
					text: '<span class="glyphicon glyphicon-refresh"></span>',
					className: 'tab2-refreshButton',
					action: function(e, dt, node, config) {
						table_blankview_gip_pos.columns().search('');
						table_blankview_gip_pos.draw();
						table_blankview_gip_pos_docfiles.draw();
						table_blankview_gip_pos_blankpril.draw();
					}
				},
				{
					extend: "create",
					editor: editor_blankview_edit_pos,
					text: "НОВАЯ ЗАЯВКА",
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
					text: "ИЗМЕНИТЬ / ОТПРАВИТЬ",
					action: function(e, dt, node, config) {
						editor_blankview_edit_pos
							.field('dognet_blankdocpost.kodblankcreate').set(0);
						editor_blankview_edit_pos
							.field('dognet_blankdocpost.kodblankcreate').enable();
						// Start in edit mode, and then change to create
						editor_blankview_edit_pos
							.edit(table_blankview_gip_pos.rows({
								selected: true
							}).indexes(), {
								title: '<h3>Изменить / Отправить заявку</h3>',
								buttons: 'Изменить / Отправить'
							})
							.mode('edit');
					},
					formButtons: ['Изменить / Отправить',
						{
							text: 'Отмена',
							action: function() {
								this.close();
							}
						}
					]
				},
				{
					extend: "selected",
					text: 'ДУБЛИРОВАТЬ',
					action: function(e, dt, node, config) {

						editor_blankview_edit_pos
							.field('dognet_blankdocpost.kodblankcreate').set(0);
						editor_blankview_edit_pos
							.field('dognet_blankdocpost.kodblankcreate').disable();
						// Start in edit mode, and then change to create
						editor_blankview_edit_pos
							.edit(table_blankview_gip_pos.rows({
								selected: true
							}).indexes(), {
								title: '<h3>Дублировать заявку на основе выбранной</h3>',
								buttons: 'Создать дубликат'
							})
							.mode('create');
					}
				},
				{
					extend: "remove",
					editor: editor_blankview_edit_pos,
					text: "УДАЛИТЬ"
				}
			],
			rowGroup: {
				startRender: function(rows, group, level) {

					if (level == 0) {
						if (group == "CR") {
							return '<span style="text-align:left; white-space:nowrap">Мои заявки (не отправленные в отдел договоров)</span>';
						} else if (group == "RD") {
							return '<span style="text-align:left; white-space:nowrap">Бланки в работе</span>';
						} else if (group == "DO") {
							return '<span style="text-align:left; white-space:nowrap">Бланки оформленные и переданные в отдел договоров</span>';
						} else {
							return '<span style="text-align:left; white-space:nowrap">Прочие бланки</span>';
						}
					}

				},
				endRender: function(rows, group, level) {},
				dataSrc: ["dognet_blankdocpost.kodtipblank"]
			},
			createdRow: function(row, data, index) {

			},
			initComplete: function() {

			},
			drawCallback: function() {

			}

		});
		//
		// ----- ----- ----- ----- -----
		// Array to track the ids of the edit displayed rows
		var detailRows_pos = [];

		$('#blankview-gip-pos-table tbody').on('click', 'tr td.details-control', function() {
			var tr = $(this).closest('tr');
			var row = table_blankview_gip_pos.row(tr);
			var idx = $.inArray(tr.attr('id'), detailRows_pos);

			if (row.child.isShown()) {
				tr.removeClass('edit');
				row.child.hide();

				// Remove from the 'open' array
				detailRows_pos.splice(idx, 1);
			} else {
				tr.addClass('edit');
				rowData = table_blankview_gip_pos.row(row);
				d = row.data();
				rowData.child(<?php include('templates/blankview-gip-pos-blanktemplate-table.tpl'); ?>).show();

				// Add to the 'open' array
				if (idx === -1) {
					detailRows_pos.push(tr.attr('id'));
				}
			}
		});
		// On each draw, loop over the `detailRows_pos` array and show any child rows
		table_blankview_gip_pos.on('draw', function() {
			$.each(detailRows_pos, function(i, id) {
				$('#' + id + ' td.details-control').trigger('click');
			});
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		//
		//
		//
		//
		//
		//
		//
		//
		//
		//
		//
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		// БЛАНКИ ДЛЯ ПЕЧАТИ ::: Редактор
		var editor_blankview_gip_pos_docfiles = new $.fn.dataTable.Editor({
			display: "bootstrap",
			ajax: "php/examples/php/blankview/blankview-gip/dognet-blankview-gip-pos-docfiles-process.php",
			table: "#blankview-gip-pos-docfiles-table",
			i18n: {
				create: {
					title: "<h3>Прикрепить документ</h3>",
					button: "Прикрепить файл",
					submit: "Прикрепить",
				},
				remove: {
					title: "<h3>Удалить документ</h3>",
					button: "Удалить файл",
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
			/* 		template: '#customForm_docblank-table', */
			fields: []
		});
		//
		// Изменяем размер диалогового окна редактирования
		editor_blankview_gip_pos_docfiles.on('open', function() {
			$(".modal-dialog").css({
				"width": "30%",
				"margin": "0em 70%",
				"min-width": "360px",
				"max-width": "480px"
			});
		});
		//
		// ----- ----- -----
		// БЛАНКИ ДЛЯ ПЕЧАТИ ::: Таблица данных
		var table_blankview_gip_pos_docfiles = $('#blankview-gip-pos-docfiles-table').DataTable({
			dom: "<'row'<'col-sm-5'B><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'><'col-sm-8'>>",
			// 		dom: "<'space50'r>tip",
			language: {
				url: "php/examples/simple/blankview/blankview-gip/dt_russian-tab2_pos-docfiles.json"
			},
			ajax: {
				url: "php/examples/php/blankview/blankview-gip/dognet-blankview-gip-pos-docfiles-process.php",
				type: 'post',
				data: function(d) {
					var selected = table_blankview_gip_pos.row({
						selected: true
					});
					if (selected.any()) {
						d.kodblankwork = selected.data().dognet_blankdocpost.kodblankwork;
						console.log("Kodblankwork (" + selected.id() + ") :: kodblankwork: " + d.kodblankwork);
					}
				}
			},
			serverSide: true,
			columns: [{
					data: "dognet_docblankwork_files.blank_status",
					className: "text-center"
				},
				{
					data: "dognet_docblankwork_files.file_name",
					className: "text-center"
				},
				{
					data: "dognet_docblankwork_files.file_extension",
					className: "text-center"
				}
			],
			select: {
				style: 'single',
				selector: 'td:not(:last-child)' // no row selection on last column
			},
			columnDefs: [{
					orderable: false,
					searchable: false,
					render: function(data) {
						if (data == 'CR' || data == 'GIP') {
							return '<span class="label label-default text-uppercase">ГИП</span>';
						}
						if (data == 'RD' || data == 'DO') {
							return '<span class="label label-danger text-uppercase">ДОГ</span>';
						} else {
							return '<span class="label label-default text-uppercase">---</span>';
						}
					},
					targets: 0
				},
				{
					orderable: false,
					searchable: true,
					render: function(data, type, row, meta) {
						return '<a class="blank_link" href="' + row.dognet_docblankwork_files.file_url + '" target="_blank">' + row.dognet_sysdefs_blankstatus.status_description + '</a>';
					},
					targets: 1
				},
				{
					orderable: false,
					searchable: true,
					render: function(data, type, row, meta) {
						return '<span class="label label-primary">' + data + '</span>';
					},
					targets: 2
				}
			],
			select: false,
			processing: false,
			paging: false,
			searching: false,
			buttons: [{
					extend: "create",
					editor: editor_blankview_gip_pos_docfiles,
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
					editor: editor_blankview_gip_pos_docfiles,
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
					editor: editor_blankview_gip_pos_docfiles,
					text: '<span class="glyphicon glyphicon-remove"></span>'
				}
			],
			initComplete: function() {

			},
			drawCallback: function(settings) {

			}
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		//
		//
		//
		//
		//
		//
		//
		//
		//
		//
		//
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		// ПРИКРЕПЛЯЕМЫЕ ФАЙЛЫ К БЛАНКУ ::: Редактор
		var editor_blankview_gip_pos_blankpril = new $.fn.dataTable.Editor({
			display: "bootstrap",
			ajax: {
				url: "php/examples/php/blankview/blankview-gip/dognet-blankview-gip-pos-blankpril-process.php",
				data: function(d) {
					var selected = table_blankview_gip_pos.row({
						selected: true
					});
					if (selected.any()) {
						d.kodblankwork = selected.data().dognet_blankdocpost.kodblankwork;
					}
				}
			},
			table: "#blankview-gip-pos-blankpril-table",
			i18n: {
				create: {
					title: "<h3>Прикрепить файл</h3>"
				},
				edit: {
					title: "<h3>Изменить запись о файле</h3>"
				},
				remove: {
					button: "Удалить",
					title: "<h3>Удалить файл</h3>",
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
			template: '#customForm_blankworkpril_pos',
			fields: [{
				name: "dognet_blankworkpril.docFileID",
				type: "upload",
				display: function(id) {
					return '<h4><a target="_blank" href="' + editor_blankview_gip_pos_blankpril.file('dognet_blankworkpril_files', id).file_webpath + '"><span class="glyphicon glyphicon-eye-open"></span></a></h4>';
				},
				dragDrop: false,
				clearText: "",
				noFileText: "Файл не выбран",
				uploadText: "Выберите файл"
			}, {
				type: "readonly",
				name: "dognet_blankworkpril.msgDocFileID"
			}, {
				label: "Бланк :",
				name: "dognet_blankworkpril.kodblankwork",
				type: "select",
				placeholder: "Выберите бланк"
			}, {
				label: "Описание документа :",
				name: "dognet_blankworkpril.namepril",
				type: "textarea"
			}]
		});
		//
		// Изменяем размер диалогового окна редактирования
		editor_blankview_gip_pos_blankpril.on('open', function() {
			$(".modal-dialog").css({
				"width": "30%",
				"margin": "0em 70%",
				"min-width": "360px",
				"max-width": "480px"
			});
		});
		//
		// Подготавливаем форму для работы
		editor_blankview_gip_pos_blankpril.on('initCreate', function(e) {
			editor_blankview_gip_pos_blankpril.field('dognet_blankworkpril.msgDocFileID').show();
			editor_blankview_gip_pos_blankpril.field('dognet_blankworkpril.msgDocFileID').val('Сначала создайте запись!');
			editor_blankview_gip_pos_blankpril.field('dognet_blankworkpril.docFileID').hide();
			editor_blankview_gip_pos_blankpril.field('dognet_blankworkpril.docFileID').disable();
		});
		editor_blankview_gip_pos_blankpril.on('initEdit', function(e, node, data, items, type) {
			editor_blankview_gip_pos_blankpril.field('dognet_blankworkpril.msgDocFileID').hide();
			editor_blankview_gip_pos_blankpril.field('dognet_blankworkpril.docFileID').show();
			editor_blankview_gip_pos_blankpril.field('dognet_blankworkpril.docFileID').enable();
		});
		// ----- ----- -----
		// ПРИКРЕПЛЯЕМЫЕ ФАЙЛЫ К БЛАНКУ ::: Таблица данных
		var table_blankview_gip_pos_blankpril = $('#blankview-gip-pos-blankpril-table').DataTable({
			dom: "<'row'<'col-sm-5'B><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'><'col-sm-8'>>",
			// 		dom: "<'space50'r>tip",
			language: {
				url: "php/examples/simple/blankview/blankview-gip/dt_russian-tab2_pos-prilfiles.json"
			},
			ajax: {
				url: "php/examples/php/blankview/blankview-gip/dognet-blankview-gip-pos-blankpril-process.php",
				type: 'post',
				data: function(d) {
					var selected = table_blankview_gip_pos.row({
						selected: true
					});
					if (selected.any()) {
						d.kodblankwork = selected.data().dognet_blankdocpost.kodblankwork;
						d.rowID = selected.id().substr(4);
						console.log("Kodblankwork (" + selected.id() + ") :: kodblankwork: " + d.kodblankwork);
						console.log("ID (" + selected.id() + ") :: row ID: " + d.rowID);
					}
				}
			},
			serverSide: true,
			columns: [{
					data: "dognet_blankworkpril.numberpril",
					className: "text-center"
				},
				{
					data: "dognet_blankworkpril.namepril",
					className: "text-center"
				},
				{
					data: "dognet_blankworkpril.extfile",
					className: "text-center"
				}
			],
			select: {
				style: 'single',
				selector: 'td:not(:last-child)' // no row selection on last column
			},
			columnDefs: [{
					orderable: false,
					searchable: true,
					targets: 0
				},
				{
					orderable: false,
					searchable: true,
					render: function(data, type, row, meta) {
						text_link = ((data !== "") ? data : "Файл без имени");
						if (row.dognet_blankworkpril_files.file_url == null) {
							return text_link;
						} else {
							return '<a class="blank_link" href="' + row.dognet_blankworkpril_files.file_url + '" target="_blank">' + text_link + '</a>';
						}
					},
					targets: 1
				},
				{
					orderable: false,
					searchable: true,
					render: function(data, type, row, meta) {
						return '<span class="label label-primary">' + data + '</span>';
					},
					targets: 2
				}
			],
			select: true,
			processing: false,
			paging: false,
			searching: false,
			buttons: [{
					extend: "create",
					editor: editor_blankview_gip_pos_blankpril,
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
					editor: editor_blankview_gip_pos_blankpril,
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
					editor: editor_blankview_gip_pos_blankpril,
					text: '<span class="glyphicon glyphicon-remove"></span>'
				}
			],
			initComplete: function() {

			},
			drawCallback: function() {

			}
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		//
		//
		//
		//
		//
		//
		//
		//
		//
		//
		//
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		// ДОПОЛНИТЕЛЬНЫЕ СУММЫ К БЛАНКУ ::: Редактор
		var editor_blankview_gip_pos_summadop = new $.fn.dataTable.Editor({
			display: "bootstrap",
			ajax: {
				url: "php/examples/php/blankview/blankview-gip/dognet-blankview-gip-pos-summadop-process.php",
				data: function(d) {
					var selected = table_blankview_gip_pos.row({
						selected: true
					});
					if (selected.any()) {
						d.kodblankwork = selected.data().dognet_blankdocpost.kodblankwork;
						d.kodtipblank = selected.data().dognet_blankdocpost.kodtipblank;
						d.rowID = selected.id().substr(4);
					}
				}
			},
			table: "#blankview-gip-pos-summadop-table",
			i18n: {
				create: {
					title: "<h3>Добавить новую сумму</h3>"
				},
				edit: {
					title: "<h3>Изменить сумму</h3>"
				},
				remove: {
					button: "Удалить",
					title: "<h3>Удалить сумму</h3>",
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
			template: '#customForm_blanksummadop_pos',
			fields: [{
				label: "Бланк :",
				name: "dognet_blanksummadop.kodblankwork",
				type: "select",
				placeholder: "Выберите бланк"
			}, {
				label: "Описание :",
				name: "dognet_blanksummadop.namesummadop"
			}, {
				label: "Сумма :",
				name: "dognet_blanksummadop.summadopblank"
			}]
		});
		//
		// Изменяем размер диалогового окна редактирования
		editor_blankview_gip_pos_summadop.on('open', function() {
			$(".modal-dialog").css({
				"width": "60%",
				"margin": "1.0em auto",
				"min-width": "640px",
				"max-width": "800px"
			});
		});
		// ----- ----- ----- ----- -----
		// ПРИКРЕПЛЯЕМЫЕ ФАЙЛЫ К БЛАНКУ ::: Таблица данных
		var table_blankview_gip_pos_summadop = $('#blankview-gip-pos-summadop-table').DataTable({
			dom: "<'row'<'col-sm-5'B><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'><'col-sm-8'>>",
			// 		dom: "<'space50'r>tip",
			language: {
				url: "php/examples/simple/blankview/blankview-gip/dt_russian-tab2_pos-summadop.json"
			},
			ajax: {
				url: "php/examples/php/blankview/blankview-gip/dognet-blankview-gip-pos-summadop-process.php",
				type: 'post',
				data: function(d) {
					var selected = table_blankview_gip_pos.row({
						selected: true
					});
					if (selected.any()) {
						d.kodblankwork = selected.data().dognet_blankdocpost.kodblankwork;
						d.kodtipblank = selected.data().dognet_blankdocpost.kodtipblank;
						d.rowID = selected.id().substr(4);
					}
				}
			},
			serverSide: true,
			columns: [{
					data: "dognet_blanksummadop.kodsummadop",
					className: "text-center"
				},
				{
					data: "dognet_blanksummadop.kodtipblank",
					className: "text-center"
				},
				{
					data: "dognet_blanksummadop.namesummadop",
					className: "text-center"
				},
				{
					data: "dognet_blanksummadop.summadopblank",
					className: "text-center"
				}
			],
			select: {
				style: 'single',
				selector: 'td:not(:last-child)' // no row selection on last column
			},
			columnDefs: [{
					orderable: false,
					searchable: false,
					targets: 0
				},
				{
					orderable: false,
					searchable: false,
					render: function(data) {
						if (data == 'CR' || data == 'GIP') {
							return '<span class="label label-default text-uppercase">ГИП</span>';
						}
						if (data == 'RD' || data == 'DO') {
							return '<span class="label label-danger text-uppercase">ДОГ</span>';
						} else {
							return '<span class="label label-default text-uppercase">---</span>';
						}
					},
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
					render: function(data, type, row, meta) {
						if (data != null) {
							return $.fn.dataTable.render.number(' ', ',', 2, '').display(data);
						} else {
							return "0.00";
						}
					},
					targets: 3
				}
			],
			select: true,
			processing: false,
			paging: false,
			searching: false,
			buttons: [{
					extend: "create",
					editor: editor_blankview_gip_pos_summadop,
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
					editor: editor_blankview_gip_pos_summadop,
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
					editor: editor_blankview_gip_pos_summadop,
					text: '<span class="glyphicon glyphicon-remove"></span>'
				}
			],
			initComplete: function() {

			},
			drawCallback: function() {

			}
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		//
		//
		//
		//
		//
		//
		//
		//
		//
		//
		//
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		table_blankview_gip_pos.on('select', function() {
			table_blankview_gip_pos.buttons().enable();
			table_blankview_gip_pos_summadop.buttons().enable();
			table_blankview_gip_pos_summadop.ajax.reload();
			table_blankview_gip_pos_docfiles.buttons().disable();
			table_blankview_gip_pos_docfiles.ajax.reload();
			table_blankview_gip_pos_blankpril.buttons().enable();
			table_blankview_gip_pos_blankpril.ajax.reload();
		});
		table_blankview_gip_pos.on('deselect', function() {
			table_blankview_gip_pos_summadop.buttons().disable();
			table_blankview_gip_pos_summadop.ajax.reload();
			table_blankview_gip_pos_docfiles.buttons().disable();
			table_blankview_gip_pos_docfiles.ajax.reload();
			table_blankview_gip_pos_blankpril.buttons().disable();
			table_blankview_gip_pos_blankpril.ajax.reload();
		});
		table_blankview_gip_pos.on('init', function() {
			table_blankview_gip_pos_summadop.buttons().disable();
			table_blankview_gip_pos_docfiles.buttons().disable();
			table_blankview_gip_pos_blankpril.buttons().disable();
		});

		editor_blankview_edit_pos.on('submitError', function() {
			if (editor_blankview_edit_pos.field('sendEmailPOS').val() == 1) {
				console.log('submitError OK / Form closed');
				// 			editor_blankview_edit_pos.close();
			} else {
				console.log('submitError OK');
			}
		});


		editor_blankview_edit_pos.on('preSubmit', function(e, data, action) {
			// let newObj = JSON.parse( data );
			let newObj1 = JSON.parse(JSON.stringify(data));
			let newObj2 = JSON.stringify(data);
			// console.log( "json: "+json.data[0].dognet_blankdocpost.namedocblank );
			// console.log( "newObj: "+newObj );
			// console.log( "newObj1: "+newObj1 );
			// console.log( "data: "+data );
			// console.log( "newObj2: "+newObj2 );

			var ids = (editor_blankview_edit_pos.ids(true) + '').substr(1);
			// console.log("ids: "+ids);
			var x = ids.split('_');
			// console.log("x: "+x[0]+"..."+x[1]);
			var rowid = parseInt(x[1], 10);
			// console.log("rowid: "+rowid);
			// console.log("data: "+data.data[ids].dognet_blankdocpost.namedocblank);


			// Осуществляем глубокое копирование объекта и инициализируем переменную
			if ((action === "create") && editor_blankview_edit_pos.field('dognet_blankdocpost.kodblankcreate').val() == 1 && editor_blankview_edit_pos.field('sendEmailPOS').val() == 1) {
				console.log("action1: " + action);
				/* 			console.log( "data: "+data.data[0].dognet_blankdocpost.namedocblank ); */
				// ТИП БЛАНКА
				_blanktip = "Поставка";
				// ОПИСАНИЕ БЛАНКА
				_blankname = data.data[0].dognet_blankdocpost.namedocblank;
				// ИМЯ ГИПа
				_ispolname = data.data[0].dognet_blankdocpost.kodispol;
				// ИМЯ РУКОВОДИТЕЛЯ
				_ispolrukname = data.data[0].dognet_blankdocpost.kodispolruk;
				// НАЗВАНИЕ ОБЪЕКТА
				_objname = "";
				// НАЗВАНИЕ ЗАКАЗЧИКА
				if (data.data[0].dognet_blankdocpost.kodusespzakaz == '1') {
					_zakname = data.data[0].dognet_blankdocpost.kodzakaz;
				} else if (data.data[0].dognet_blankdocpost.koduseneworg == '1') {
					_zakname = data.data[0].dognet_blankdocpost.nameneworg;
				} else {
					_zakname = "";
				}
				// СУММА БЛАНКА
				_summablank = data.data[0].dognet_blankdocpost.csummadocopl;
				_summablank = $.fn.dataTable.render.number(' ', ',', 2, '').display(_summablank);

				ajaxRequest_sendMailPOS(_blanktip, _blankname, _ispolname, _ispolrukname, _objname, _zakname, _summablank, 'sendMail');

			}
			// Осуществляем глубокое копирование объекта и инициализируем переменную
			else if ((action === "edit") && editor_blankview_edit_pos.field('dognet_blankdocpost.kodblankcreate').val() == 1 && editor_blankview_edit_pos.field('sendEmailPOS').val() == 1) {

				var ids = (editor_blankview_edit_pos.ids(true) + '').substr(1);
				// console.log("ids: "+ids);
				// console.log("action2: "+action);
				// ТИП БЛАНКА
				_blanktip = "Поставка";
				// ОПИСАНИЕ БЛАНКА
				_blankname = data.data[ids].dognet_blankdocpost.namedocblank;
				// console.log("_blankname: "+_blankname);

				// ИМЯ ГИПа
				_ispolname = data.data[ids].dognet_blankdocpost.kodispol;
				// console.log("_ispolname: "+_ispolname);

				// ИМЯ РУКОВОДИТЕЛЯ
				_ispolrukname = data.data[ids].dognet_blankdocpost.kodispolruk;
				// console.log("_ispolrukname: "+_ispolrukname);

				// НАЗВАНИЕ ОБЪЕКТА
				_objname = "";
				// console.log("_objname: "+_objname);

				// НАЗВАНИЕ ЗАКАЗЧИКА
				if (data.data[ids].dognet_blankdocpost.kodusespzakaz == '1') {
					_zakname = data.data[ids].dognet_blankdocpost.kodzakaz;
				} else if (data.data[ids].dognet_blankdocpost.koduseneworg == '1') {
					_zakname = data.data[ids].dognet_blankdocpost.nameneworg;
				} else {
					_zakname = "";
				}
				// console.log("kodusespzakaz: "+data.data[ids].dognet_blankdocpost.kodusespzakaz);
				// console.log("koduseneworg: "+data.data[ids].dognet_blankdocpost.koduseneworg);
				// console.log("_zakname: "+_zakname);

				// СУММА БЛАНКА
				_summablank = data.data[ids].dognet_blankdocpost.csummadocopl;
				_summablank = $.fn.dataTable.render.number(' ', ',', 2, '').display(_summablank);
				// console.log("_summablank: "+_summablank);

				ajaxRequest_sendMailPOS(_blanktip, _blankname, _ispolname, _ispolrukname, _objname, _zakname, _summablank, 'sendMail');

			}
		});


	});
</script>
<?php
// ----- ----- ----- ----- -----
// Подключаем стили для форм и таблиц
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/blankview/blankview-gip/restr_5/tabs/css/blankview-gip-tab2_pos.css">
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/blankview/blankview-gip/restr_5/tabs/css/blankview-gip-tab2_summadop.css">
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/blankview/blankview-gip/restr_5/tabs/css/blankview-gip-tab2_doc_files.css">
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/blankview/blankview-gip/restr_5/tabs/css/blankview-gip-tab2_pril_files.css">
<?php
// ----- ----- ----- ----- -----
// Форма редактирования заявки/бланка
// :::
?>
<div id="customForm_newblank_pos">
	<div id="newblank-pos-tabs" style="width:100%">
		<ul id="newblank-pos-tabs-menu" class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#pos-tab-1" title="">Основное</a></li>
			<li><a data-toggle="tab" href="#pos-tab-2" title="">Суммы</a></li>
			<li><a data-toggle="tab" href="#pos-tab-3" title="">Приложения</a></li>
			<li><a data-toggle="tab" href="#pos-tab-4" title="">Исполнение</a></li>
			<li><a data-toggle="tab" href="#pos-tab-10" title="">Условия</a></li>
			<li><a data-toggle="tab" href="#pos-tab-5" title="">Контакты</a></li>
			<li><a data-toggle="tab" href="#pos-tab-6" title="">Командировки</a></li>
			<li><a data-toggle="tab" href="#pos-tab-7" title="">Транспорт</a></li>
			<li><a data-toggle="tab" href="#pos-tab-8" title="">ДО</a></li>
			<li><a data-toggle="tab" href="#pos-tab-9" title="">Риски</a></li>
		</ul>
		<div class="tab-content" style="padding:5px">

			<div class="Section" style="background:#ddd; color:#000; margin-bottom:10px; border-bottom:2px #b95959 solid">
				<div class="Block80">
					<div class="Block100 fieldset-table-row">
						<div class="fieldset-table-cell" style="padding-bottom:3px">
							<fieldset>
								<editor-field name="dognet_blankdocpost.kodblankcreate"></editor-field>
							</fieldset>
						</div>
						<div class="fieldset-table-cell" style="width:100%">
							<div>
								<div class="chekbox-inline-text">Отправить заявку в Отдел договоров. После этого редатирование бланка будет уже невозможно!</div>
							</div>
						</div>
					</div>
				</div>
				<div id="div-sendEmail-pos" class="Block20" style="display:none">
					<div class="Block100 fieldset-table-row">
						<div class="fieldset-table-cell" style="padding-bottom:3px">
							<fieldset>
								<editor-field name="sendEmailPOS"></editor-field>
							</fieldset>
						</div>
						<div class="fieldset-table-cell" style="width:100%">
							<div>
								<div class="chekbox-inline-text">Уведомить ОД по email</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div id="pos-tab-1" class="tab-pane fade in active">

				<div class="Section">
					<div class="Block25">
						<legend>Исполнители</legend>
						<fieldset class="field100">
							<editor-field name="dognet_blankdocpost.kodispolruk"></editor-field>
						</fieldset>
						<fieldset class="field100">
							<editor-field name="dognet_blankdocpost.kodispol"></editor-field>
						</fieldset>
					</div>
					<div class="Block75">
						<legend>Организация</legend>
						<div class="Block40">
							<fieldset class="field50">
								<editor-field name="dognet_blankdocpost.kodorgzakaz"></editor-field>
							</fieldset>
							<fieldset class="field50">
								<editor-field name="dognet_blankdocpost.kodusespzakaz"></editor-field>
							</fieldset>
						</div>
						<div class="Block60">
							<fieldset class="field70">
								<editor-field name="dognet_blankdocpost.kodzakaz"></editor-field>
							</fieldset>
							<fieldset class="field30 kodzakazFilter" style="padding-top:30px; padding-right:15px">
								<input id="kodzakaz_filter_pos" type="text" placeholder="Поиск" />
							</fieldset>
						</div>
						<div class="Block100">
							<fieldset class="field20">
								<editor-field name="dognet_blankdocpost.kodorgispol"></editor-field>
							</fieldset>
							<fieldset class="field20">
								<editor-field name="dognet_blankdocpost.koduseneworg"></editor-field>
							</fieldset>
							<fieldset class="field60">
								<editor-field name="dognet_blankdocpost.nameneworg"></editor-field>
							</fieldset>
						</div>
					</div>
					<div class="Block100">
						<legend>Название договора</legend>
						<fieldset class="field100">
							<editor-field name="dognet_blankdocpost.namedocblank"></editor-field>
						</fieldset>
					</div>
				</div>

			</div>
			<div id="pos-tab-2" class="tab-pane fade">

				<div class="Section">
					<div class="Block20">
						<legend>Сумма договора</legend>
						<div class="Block100">
							<fieldset class="field100">
								<editor-field name="dognet_blankdocpost.csummadocopl"></editor-field>
							</fieldset>
						</div>
						<div class="Block100 fieldset-table-row">
							<div class="fieldset-table-cell" style="padding-bottom:3px">
								<fieldset>
									<editor-field name="dognet_blankdocpost.kodusendsopl"></editor-field>
								</fieldset>
							</div>
							<div class="fieldset-table-cell" style="width:100%">
								<div>
									<div class="chekbox-inline-text">Без НДС</div>
								</div>
							</div>
						</div>
						<div class="Block100 fieldset-table-row">
							<div class="fieldset-table-cell" style="padding-bottom:3px">
								<fieldset>
									<editor-field name="dognet_blankdocpost.kodusespechopl"></editor-field>
								</fieldset>
							</div>
							<div class="fieldset-table-cell" style="width:100%">
								<div>
									<div class="chekbox-inline-text">Со спецификацией</div>
								</div>
							</div>
						</div>
					</div>
					<div class="Block80">
						<legend>Порядок оплаты</legend>
						<div id="useopl1usl" class="Block40" style="outline:1px dashed #ccc; outline-offset:-4px; padding:4px 8px">
							<fieldset class="field100">
								<div class="fieldset-info">Оплата авансом в размере X процентов</div>
							</fieldset>
							<fieldset class="field40">
								<editor-field name="dognet_blankdocpost.koduseopl1usl"></editor-field>
							</fieldset>
							<fieldset class="field60">
								<editor-field name="dognet_blankdocpost.csummaopl1usl"></editor-field>
							</fieldset>
						</div>
						<div id="useopl2usl" class="Block60" style="outline:1px dashed #ccc; outline-offset:-4px; padding:4px 8px">
							<fieldset class="field100">
								<div class="fieldset-info">Окончательная оплата в размере X процентов в течение N дней после подписания акта</div>
							</fieldset>
							<fieldset class="field30">
								<editor-field name="dognet_blankdocpost.koduseopl2usl"></editor-field>
							</fieldset>
							<fieldset class="field40">
								<editor-field name="dognet_blankdocpost.csummaopl2usl"></editor-field>
							</fieldset>
							<fieldset class="field30">
								<editor-field name="dognet_blankdocpost.cnumberoplday2usl"></editor-field>
							</fieldset>
						</div>
						<div id="useopl3usl" class="Block40" style="outline:1px dashed #ccc; outline-offset:-4px; padding:4px 8px">
							<fieldset class="field100">
								<div class="fieldset-info">В течение N дней после получения финансирования от конечного Заказчика</div>
							</fieldset>
							<fieldset class="field40">
								<editor-field name="dognet_blankdocpost.koduseopl3usl"></editor-field>
							</fieldset>
							<fieldset class="field60">
								<editor-field name="dognet_blankdocpost.cnumberoplday3usl"></editor-field>
							</fieldset>
						</div>
						<div id="useopl4usl" class="Block60" style="outline:1px dashed #ccc; outline-offset:-4px; padding:4px 8px">
							<fieldset class="field30">
								<editor-field name="dognet_blankdocpost.koduseopl4usl"></editor-field>
							</fieldset>
							<fieldset class="field70">
								<editor-field name="dognet_blankdocpost.ctextoplotherusl"></editor-field>
							</fieldset>
						</div>
					</div>
				</div>

			</div>
			<div id="pos-tab-3" class="tab-pane fade">

				<div class="Section">
					<div class="Block100">
						<legend>Перечень приложений</legend>
						<div class="Block100 fieldset-table-row">
							<div class="fieldset-table-cell" style="padding-bottom:3px">
								<fieldset>
									<editor-field name="dognet_blankdocpost.kodusepril1"></editor-field>
								</fieldset>
							</div>
							<div class="fieldset-table-cell" style="width:100%">
								<div>
									<div class="chekbox-inline-text">Технические требования</div>
								</div>
							</div>
						</div>
						<div class="Block100 fieldset-table-row">
							<div class="fieldset-table-cell" style="padding-bottom:3px">
								<fieldset>
									<editor-field name="dognet_blankdocpost.kodusepril2"></editor-field>
								</fieldset>
							</div>
							<div class="fieldset-table-cell" style="width:100%">
								<div>
									<div class="chekbox-inline-text">Календарный план</div>
								</div>
							</div>
						</div>
						<div class="Block100 fieldset-table-row">
							<div class="fieldset-table-cell" style="padding-bottom:3px">
								<fieldset>
									<editor-field name="dognet_blankdocpost.kodusepril3"></editor-field>
								</fieldset>
							</div>
							<div class="fieldset-table-cell" style="width:100%">
								<div>
									<div class="chekbox-inline-text">Спецификация</div>
								</div>
							</div>
						</div>
						<div class="Block100 fieldset-table-row">
							<div class="fieldset-table-cell" style="padding-bottom:3px">
								<fieldset>
									<editor-field name="dognet_blankdocpost.kodusepril4"></editor-field>
								</fieldset>
							</div>
							<div class="fieldset-table-cell" style="width:100%">
								<div>
									<div class="chekbox-inline-text">Протокол соглашения о договорной цене</div>
								</div>
							</div>
						</div>
						<div class="Block100 fieldset-table-row">
							<div class="fieldset-table-cell" style="padding-bottom:3px">
								<fieldset>
									<editor-field name="dognet_blankdocpost.kodusepril5"></editor-field>
								</fieldset>
							</div>
							<div class="fieldset-table-cell" style="width:100%">
								<div>
									<div class="chekbox-inline-text">Сметный расчет</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
			<div id="pos-tab-4" class="tab-pane fade">

				<div class="Section">
					<div class="Block100">
						<legend>Исполнение</legend>
						<div class="Block100">
							<div class="fieldset-info">*Если точно не известен срок исполнения, выбирать "Конец года"</div>
						</div>
						<div id="useispoldoc1" class="Block50 fieldset-table-row" style="outline:1px dashed #ccc; outline-offset:-4px; padding:4px 8px">
							<div class="fieldset-table-cell" style="padding-bottom:3px">
								<fieldset>
									<editor-field name="dognet_blankdocpost.koduseispoldoc1"></editor-field>
								</fieldset>
							</div>
							<div class="fieldset-table-cell" style="width:70%">
								<div>
									<div class="chekbox-inline-text">Дата исполнения</div>
								</div>
							</div>
							<div class="fieldset-table-cell" style="padding-bottom:3px; width:30%">
								<fieldset>
									<editor-field name="dognet_blankdocpost.cdateispoldoc1"></editor-field>
								</fieldset>
							</div>
						</div>
						<div id="useispoldoc2" class="Block50 fieldset-table-row" style="outline:1px dashed #ccc; outline-offset:-4px; padding:4px 8px">
							<div class="fieldset-table-cell" style="padding-bottom:3px">
								<fieldset>
									<editor-field name="dognet_blankdocpost.koduseispoldoc2"></editor-field>
								</fieldset>
							</div>
							<div class="fieldset-table-cell" style="width:70%">
								<div>
									<div class="chekbox-inline-text">Дней от аванса</div>
								</div>
							</div>
							<div class="fieldset-table-cell" style="padding-bottom:3px; width:30%">
								<fieldset>
									<editor-field name="dognet_blankdocpost.cdaysispoldoc2"></editor-field>
								</fieldset>
							</div>
						</div>
						<div id="useispoldoc3" class="Block50 fieldset-table-row" style="outline:1px dashed #ccc; outline-offset:-4px; padding:4px 8px">
							<div class="fieldset-table-cell" style="padding-bottom:3px">
								<fieldset>
									<editor-field name="dognet_blankdocpost.koduseispoldoc3"></editor-field>
								</fieldset>
							</div>
							<div class="fieldset-table-cell" style="width:100%">
								<div>
									<div class="chekbox-inline-text">Автоматическая пролонгация</div>
								</div>
							</div>
						</div>
						<div id="useispoldoc4" class="Block50 fieldset-table-row" style="outline:1px dashed #ccc; outline-offset:-4px; padding:4px 8px">
							<div class="fieldset-table-cell" style="padding-bottom:3px">
								<fieldset>
									<editor-field name="dognet_blankdocpost.koduseispoldoc4"></editor-field>
								</fieldset>
							</div>
							<div class="fieldset-table-cell" style="width:100%">
								<div>
									<div class="chekbox-inline-text">Конец года</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
			<div id="pos-tab-10" class="tab-pane fade">

				<div class="Section">
					<div class="Block100">
						<legend>Особые условия (определяются ГИПом)</legend>
						<fieldset class="field80">
							<editor-field name="dognet_blankdocpost.defuslgiptext"></editor-field>
						</fieldset>
						<fieldset class="field20">
							<editor-field name="dognet_blankdocpost.kodusetender"></editor-field>
						</fieldset>
					</div>
				</div>

			</div>
			<div id="pos-tab-5" class="tab-pane fade">

				<div class="Section">
					<div class="Block100">
						<legend>Контакты</legend>
						<div class="Block50">
							<div class="Block100 fieldset-table-row">
								<div class="fieldset-table-cell" style="white-space:nowrap; width:50%">
									<div>
										<div class="chekbox-inline-text">Фамилия</div>
									</div>
								</div>
								<div class="fieldset-table-cell" style="padding-top:4px">
									<fieldset>
										<editor-field name="dognet_blankdocpost.nameendcontact"></editor-field>
									</fieldset>
								</div>
							</div>
							<div class="Block100 fieldset-table-row">
								<div class="fieldset-table-cell" style="white-space:nowrap; width:50%">
									<div>
										<div class="chekbox-inline-text">Имя</div>
									</div>
								</div>
								<div class="fieldset-table-cell" style="padding-top:4px">
									<fieldset>
										<editor-field name="dognet_blankdocpost.namefistcontact"></editor-field>
									</fieldset>
								</div>
							</div>
							<div class="Block100 fieldset-table-row">
								<div class="fieldset-table-cell" style="white-space:nowrap; width:50%">
									<div>
										<div class="chekbox-inline-text">Отчество</div>
									</div>
								</div>
								<div class="fieldset-table-cell" style="padding-top:4px">
									<fieldset>
										<editor-field name="dognet_blankdocpost.namesecondcontact"></editor-field>
									</fieldset>
								</div>
							</div>
							<div class="Block100 fieldset-table-row">
								<div class="fieldset-table-cell" style="white-space:nowrap; width:50%">
									<div>
										<div class="chekbox-inline-text">Должность</div>
									</div>
								</div>
								<div class="fieldset-table-cell" style="padding-top:4px">
									<fieldset>
										<editor-field name="dognet_blankdocpost.namedoljcontact"></editor-field>
									</fieldset>
								</div>
							</div>
						</div>
						<div class="Block50">
							<div class="Block100 fieldset-table-row">
								<div class="fieldset-table-cell" style="white-space:nowrap; width:50%">
									<div>
										<div class="chekbox-inline-text">Телефон (рабочий)</div>
									</div>
								</div>
								<div class="fieldset-table-cell" style="padding-top:4px">
									<fieldset>
										<editor-field name="dognet_blankdocpost.numbertelrab"></editor-field>
									</fieldset>
								</div>
							</div>
							<div class="Block100 fieldset-table-row">
								<div class="fieldset-table-cell" style="white-space:nowrap; width:50%">
									<div>
										<div class="chekbox-inline-text">Телефон (мобильный)</div>
									</div>
								</div>
								<div class="fieldset-table-cell" style="padding-top:4px">
									<fieldset>
										<editor-field name="dognet_blankdocpost.numbertelmob"></editor-field>
									</fieldset>
								</div>
							</div>
							<div class="Block100 fieldset-table-row">
								<div class="fieldset-table-cell" style="white-space:nowrap; width:50%">
									<div>
										<div class="chekbox-inline-text">Факс</div>
									</div>
								</div>
								<div class="fieldset-table-cell" style="padding-top:4px">
									<fieldset>
										<editor-field name="dognet_blankdocpost.numbertelfax"></editor-field>
									</fieldset>
								</div>
							</div>
							<div class="Block100 fieldset-table-row">
								<div class="fieldset-table-cell" style="white-space:nowrap; width:50%">
									<div>
										<div class="chekbox-inline-text">Email</div>
									</div>
								</div>
								<div class="fieldset-table-cell" style="padding-top:4px">
									<fieldset>
										<editor-field name="dognet_blankdocpost.nameemail"></editor-field>
									</fieldset>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
			<div id="pos-tab-6" class="tab-pane fade">

				<div class="Section">
					<div class="Block100">
						<legend>Командировочные расходы</legend>
						<div class="Block100 fieldset-table-row">
							<div class="fieldset-table-cell" style="padding-bottom:3px">
								<fieldset>
									<editor-field name="dognet_blankdocpost.kodusekomrasx1"></editor-field>
								</fieldset>
							</div>
							<div class="fieldset-table-cell" style="width:100%">
								<div>
									<div class="chekbox-inline-text">Наличие командировок</div>
								</div>
							</div>
						</div>
						<div class="Block100 fieldset-table-row">
							<div class="fieldset-table-cell" style="padding-bottom:3px">
								<fieldset>
									<editor-field name="dognet_blankdocpost.kodusekomrasx2"></editor-field>
								</fieldset>
							</div>
							<div class="fieldset-table-cell" style="width:100%">
								<div>
									<div class="chekbox-inline-text">Входят в стоимость договора</div>
								</div>
							</div>
						</div>
						<div class="Block100 fieldset-table-row">
							<div class="fieldset-table-cell" style="padding-bottom:3px">
								<fieldset>
									<editor-field name="dognet_blankdocpost.kodusekomrasx3"></editor-field>
								</fieldset>
							</div>
							<div class="fieldset-table-cell" style="width:100%">
								<div>
									<div class="chekbox-inline-text">Оплачиваются отдельно по фактическим затратам</div>
								</div>
							</div>
						</div>
						<div class="Block100 fieldset-table-row">
							<div class="fieldset-table-cell" style="padding-left:15px">
								<div>
									<div class="chekbox-inline-text">Примечание</div>
								</div>
							</div>
							<div class="fieldset-table-cell" style="padding-top:4px; width:100%">
								<fieldset>
									<editor-field name="dognet_blankdocpost.komrasxprim"></editor-field>
								</fieldset>
							</div>
						</div>
					</div>
				</div>

			</div>
			<div id="pos-tab-7" class="tab-pane fade">

				<div class="Section">
					<div class="Block60">
						<legend>Транспортные расходы</legend>
						<div class="Block100 fieldset-table-row">
							<div class="fieldset-table-cell" style="padding-bottom:3px">
								<fieldset>
									<editor-field name="dognet_blankdocpost.kodusetrans1"></editor-field>
								</fieldset>
							</div>
							<div class="fieldset-table-cell" style="width:100%">
								<div>
									<div class="chekbox-inline-text">Входят в стоимость договора</div>
								</div>
							</div>
						</div>
						<div class="Block100 fieldset-table-row">
							<div class="fieldset-table-cell" style="padding-bottom:3px">
								<fieldset>
									<editor-field name="dognet_blankdocpost.kodusetrans2"></editor-field>
								</fieldset>
							</div>
							<div class="fieldset-table-cell" style="width:100%">
								<div>
									<div class="chekbox-inline-text">Оплачиваются отдельно по фактическим затратам</div>
								</div>
							</div>
						</div>
						<div class="Block100 fieldset-table-row">
							<div class="fieldset-table-cell" style="padding-bottom:3px">
								<fieldset>
									<editor-field name="dognet_blankdocpost.kodusetrans3"></editor-field>
								</fieldset>
							</div>
							<div class="fieldset-table-cell">
								<div>
									<div class="chekbox-inline-text">Иное</div>
								</div>
							</div>
							<div class="fieldset-table-cell" style="padding-top:4px; width:100%">
								<fieldset>
									<editor-field name="dognet_blankdocpost.transprim"></editor-field>
								</fieldset>
							</div>
						</div>
					</div>
					<div class="Block40">
						<legend>Условия поставки</legend>
						<fieldset class="field100">
							<editor-field name="dognet_blankdocpost.transplaceobor"></editor-field>
						</fieldset>
					</div>
				</div>

			</div>
			<div id="pos-tab-8" class="tab-pane fade">

				<div class="Section">
					<div class="Block100">
						<legend>Дополнительные ограничения</legend>
						<div class="Block60">
							<div class="Block100 fieldset-table-row">
								<div class="fieldset-table-cell" style="white-space:nowrap; width:80%">
									<div>
										<div class="chekbox-inline-text">Номер основного договора, если АТГС Заказчик. Договор № 3-4/</div>
									</div>
								</div>
								<div class="fieldset-table-cell" style="padding-top:4px">
									<fieldset>
										<editor-field name="dognet_blankdocpost.numberdocmain"></editor-field>
									</fieldset>
								</div>
							</div>
						</div>
						<div class="Block60">
							<div class="Block100 fieldset-table-row">
								<div class="fieldset-table-cell" style="width:80%">
									<div>
										<div class="chekbox-inline-text">Ограничение по сроку оформление ( дней )</div>
									</div>
								</div>
								<div class="fieldset-table-cell" style="padding-top:4px">
									<fieldset>
										<editor-field name="dognet_blankdocpost.climitdays"></editor-field>
									</fieldset>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
			<div id="pos-tab-9" class="tab-pane fade">

				<div class="Section">
					<div class="Block100">
						<legend>Результаты оценки рисков/производственной осуществимости</legend>
						<div class="Block100 fieldset-table-row">
							<div class="fieldset-table-cell" style="padding-bottom:3px">
								<fieldset>
									<editor-field name="dognet_blankdocpost.koduserisk1"></editor-field>
								</fieldset>
							</div>
							<div class="fieldset-table-cell" style="width:100%">
								<div>
									<div class="chekbox-inline-text">Соблюдение сроков поставки</div>
								</div>
							</div>
						</div>
						<div class="Block100 fieldset-table-row">
							<div class="fieldset-table-cell" style="padding-bottom:3px">
								<fieldset>
									<editor-field name="dognet_blankdocpost.koduserisk2"></editor-field>
								</fieldset>
							</div>
							<div class="fieldset-table-cell" style="width:100%">
								<div>
									<div class="chekbox-inline-text">Соблюдение сроков оплаты</div>
								</div>
							</div>
						</div>
						<div class="Block100 fieldset-table-row">
							<div class="fieldset-table-cell" style="padding-bottom:3px">
								<fieldset>
									<editor-field name="dognet_blankdocpost.koduserisk3"></editor-field>
								</fieldset>
							</div>
							<div class="fieldset-table-cell" style="width:100%">
								<div>
									<div class="chekbox-inline-text">Обеспечение ресурсами</div>
								</div>
							</div>
						</div>
						<div class="Block100 fieldset-table-row">
							<div class="fieldset-table-cell" style="padding-bottom:3px">
								<fieldset>
									<editor-field name="dognet_blankdocpost.koduserisk4"></editor-field>
								</fieldset>
							</div>
							<div class="fieldset-table-cell">
								<div>
									<div class="chekbox-inline-text">Иное</div>
								</div>
							</div>
							<div class="fieldset-table-cell" style="padding-top:4px; width:100%">
								<fieldset>
									<editor-field name="dognet_blankdocpost.riskprim"></editor-field>
								</fieldset>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
<?php
// ----- ----- ----- ----- -----
// Форма разбиения сумм договора
// :::
?>
<div id="customForm_blanksummadop_pos">
	<div class="Section">
		<div class="Block100">
			<legend>Подсказки и помощь</legend>
		</div>
		<div class="Block100">
			<legend>Параметры документа</legend>
			<fieldset class="field25">
				<editor-field name="dognet_blanksummadop.kodblankwork"></editor-field>
			</fieldset>
			<fieldset class="field55">
				<editor-field name="dognet_blanksummadop.namesummadop"></editor-field>
			</fieldset>
			<fieldset class="field20">
				<editor-field name="dognet_blanksummadop.summadopblank"></editor-field>
			</fieldset>
		</div>
	</div>
</div>
<?php
// ----- ----- ----- ----- -----
// Форма добавления файла-вложения
// :::
?>
<div id="customForm_blankworkpril_pos">
	<div class="Section">
		<div class="Block100">
			<legend>Подсказки и помощь</legend>
		</div>
		<div class="Block100">
			<legend>Файл</legend>
			<fieldset class="field100">
				<editor-field name="dognet_blankworkpril.msgDocFileID"></editor-field>
			</fieldset>
			<fieldset class="field100">
				<editor-field name="dognet_blankworkpril.docFileID"></editor-field>
			</fieldset>
		</div>
		<div class="Block100">
			<legend>Параметры документа</legend>
			<fieldset class="field100">
				<editor-field name="dognet_blankworkpril.kodblankwork"></editor-field>
			</fieldset>
			<fieldset class="field100">
				<editor-field name="dognet_blankworkpril.namepril"></editor-field>
			</fieldset>
		</div>
	</div>
</div>
<?php
//
// ----- ----- -----
//
?>
<section>
	<div class="space30"></div>
	<div class="demo-html"></div>
	<table id="blankview-gip-pos-table" class="table table-bordered compact display" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th class="text-center"><span class='glyphicon glyphicon-list-alt'></span></th>
				<th width="" class="">ID заявки</th>
				<th width="" class="">Организация</th>
				<th width="" class="">Описание</th>
				<th width="" class="">Исполнитель ( рук )</th>
				<th width="" class=""></th>
			</tr>
		</thead>
	</table>
</section>
<div class="space30"></div>
<?php
//
// ----- ----- -----
//
?>
<section>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="space10"></div>
		<div id="blankview-gip-pos-summadop">
			<h3 class="space10">Разбиение суммы договора</h3>
			<div class="demo-html"></div>
			<table id="blankview-gip-pos-summadop-table" class="table table-striped" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th width="" class=""></th>
						<th width="" class=""></th>
						<th width="" class=""></th>
						<th width="" class=""></th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
	<?php // ----- ----- ----- 
	?>
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		<div class="space10"></div>
		<div id="blankview-gip-pos-docfiles">
			<h3 class="space10">Файлы бланков для печати</h3>
			<div class="demo-html"></div>
			<table id="blankview-gip-pos-docfiles-table" class="table table-striped" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th width="" class=""></th>
						<th width="" class=""></th>
						<th width="" class=""></th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
	<?php // ----- ----- ----- 
	?>
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		<div class="space10"></div>
		<div id="blankview-gip-pos-blankpril">
			<h3 class="space10">Прикрепленные к бланку файлы</h3>
			<div class="demo-html"></div>
			<table id="blankview-gip-pos-blankpril-table" class="table table-striped" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th width="" class=""></th>
						<th width="" class=""></th>
						<th width="" class=""></th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</section>