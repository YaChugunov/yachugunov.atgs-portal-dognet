<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/filterByText.js"></script>
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/date-de.js"></script>
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/moment-with-locales.js"></script>

<script type="text/javascript" language="javascript" class="init">
	$(document).ready(function() {
		//
		//
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		// ПОЛНОЕ РЕДАКТИРОВАНИЕ БЛАНКА ::: Редактор
		var editor_blankview_edit_pos = new $.fn.dataTable.Editor({
			display: "bootstrap",
			ajax: "php/examples/php/blankview/blankview-edit/dognet-blankview-edit-pos-process.php",
			table: "#blankview-edit-pos-table",
			i18n: {
				create: {
					title: "<h3>Добавить новый счет-фактуру</h3>"
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
				name: "dognet_blankdocpost.nameneworg"
			}, {
				label: "Сумма договора :",
				name: "dognet_blankdocpost.csummadocopl"
			}, {
				label: "Без НДС",
				type: "checkbox",
				name: "dognet_blankdocpost.kodusendsopl",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "Со спецификацией",
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
			}]
		});
		//
		//
		// Изменяем размер диалогового окна редактирования договора субподряда
		editor_blankview_edit_pos.on('open', function() {
			$(".modal-dialog").css({
				"width": "80%",
				"min-width": "800px",
				"max-width": "1170px"
			});
		});
		editor_blankview_edit_pos.on('close', function() {
			$(".modal-dialog").css({
				"width": "60%",
				"min-width": "none",
				"max-width": "none"
			});
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		editor_blankview_edit_pos
			.on('open', function() {
				$('#kodzakaz_filter').val('');
				if (($('#DTE_Field_dognet_blankdocpost-kodzakaz').value) != editor_blankview_edit_pos.field('dognet_blankdocpost.kodzakaz').get()) {}
				// Поиск в ниспадающем списке по содержимому текстового поля для ответного документа
				$('#DTE_Field_dognet_blankdocpost-kodzakaz').filterByText(editor_blankview_edit_pos, $('#kodzakaz_filter'), 'dognet_blankdocpost.kodzakaz', false);
			});
		//
		editor_blankview_edit_pos.on('preSubmit', function(e) {
			var jsondata = JSON.stringify(editor_blankview_edit_pos.get());
			/* 		var jsondata = JSON.editor_blankview_edit_pos.get(); */
			var parsejson = JSON.parse(jsondata);
			if ((parsejson['dognet_blankdocpost.koduseopl1usl'] == 0) && (parsejson['dognet_blankdocpost.koduseopl2usl'] == 0) && (parsejson['dognet_blankdocpost.koduseopl3usl'] == 0) && (parsejson['dognet_blankdocpost.koduseopl4usl'] == 0)) {
				return confirm('Вы не опреледили порядок оплаты! Уверены, что хотите создать бланк?');
			}

		});

		//
		//
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		// РЕДАКТИРОВАНИЕ ГОТОВОГО БЛАНКА ::: Редактор
		var editor_blankview_gip_pos = new $.fn.dataTable.Editor({
			display: "bootstrap",
			ajax: "php/examples/php/blankview/blankview-edit/dognet-blankview-edit-pos-process.php",
			table: "#blankview-edit-pos-table",
			i18n: {
				create: {
					title: "<h3>Добавить новый счет-фактуру</h3>"
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
		var openVals;
		editor_blankview_gip_pos.on('preClose', function(e) {
			// On close, check if the values have changed and ask for closing confirmation if they have
			if (openVals !== JSON.stringify(editor_blankview_gip_pos.get())) {
				return confirm('Вы изменили данные формы. Уверены, что хотите выйти из редактирования?');
			}
		})
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		// ::::: З А В И С И М О С Т И (dependences) : BEGIN
		//
		// TAB 1
		editor_blankview_edit_pos.dependent('dognet_blankdocpost.kodusespzakaz', function(val) {
			if (val == 0) {
				editor_blankview_edit_pos.field('dognet_blankdocpost.kodzakaz').disable();
				$('#kodzakaz_filter').prop('disabled', true);
			} else {
				editor_blankview_edit_pos.field('dognet_blankdocpost.kodzakaz').enable();
				$('#kodzakaz_filter').prop('disabled', false);
			}
		});
		//
		editor_blankview_edit_pos.dependent('dognet_blankdocpost.koduseneworg', function(val) {
			if (val == 0) {
				editor_blankview_edit_pos.field('dognet_blankdocpost.nameneworg').disable();
			} else {
				editor_blankview_edit_pos.field('dognet_blankdocpost.nameneworg').enable();
			}
		});
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
		//
		editor_blankview_edit_pos.dependent('dognet_blankdocpost.kodusetrans3', function(val) {
			if (val == 0) {
				editor_blankview_edit_pos.field('dognet_blankdocpost.transprim').disable();
			} else {
				editor_blankview_edit_pos.field('dognet_blankdocpost.transprim').enable();
			}
		});
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
		//
		//
		// ::::: З А В И С И М О С Т И (dependences) : END
		//
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		// БЛАНК ГОТОВЫЙ ::: Таблица данных
		var table_blankview_gip_pos = $('#blankview-edit-pos-table').DataTable({
			dom: "<'row'<'col-sm-9'B><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'p>>",
			// 		dom: "<'space50'r>tip",
			language: {
				url: "russian.json"
			},
			ajax: {
				url: "php/examples/php/blankview/blankview-edit/dognet-blankview-edit-pos-process.php",
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
					data: "dognet_blankdocpost.kodblankpost",
					className: ""
				},
				{
					data: "sp_contragents.namefull",
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
				},
				{
					data: null,
					defaultContent: '<a href="" class="edit_listalt"><span class="glyphicon glyphicon-list-alt"></span></a>',
					className: "text-right"
				}
			],
			select: {
				style: 'os',
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
					targets: 2
				},
				{
					orderable: false,
					searchable: true,
					targets: 3,
					render: function(data, type, row, meta) {
						fullstr = data;
						if (data.length > 75) {
							return data.substr(0, 75) + " ...";
						} else {
							return data;
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
				},
				{
					orderable: false,
					searchable: false,
					targets: 6,
					render: function(data, type, row, meta) {
						var blanktype = row.dognet_docblankwork.kodstatusblank;
						if (row.dognet_docblankwork.kodstatusblank == "DO") {
							return '<span style="padding:0 5px"><a href="dognet-blankview.php?blankview_type=details&uniqueID=' + row.dognet_docblankwork.kodblankwork + '"><span class="glyphicon glyphicon-list-alt"></span></a></span>' + '<span style="padding:0 5px"><a href=""><span class="glyphicon glyphicon-comment"></span></a></span>';
						} else {
							return '<span style="padding:0 5px"><a href="dognet-blankview.php?blankview_type=details&uniqueID=' + row.dognet_docblankwork.kodblankwork + '"><span class="glyphicon glyphicon-list-alt"></span></a></span>' + '<span style="padding:0 5px"><a href="dognet-blankview.php?blankview_type=edit&uniqueID=' + row.dognet_docblankwork.kodblankwork + '"><span class="glyphicon glyphicon-pencil"></span></a></span>' + '<span style="padding:0 5px"><a href=""><span class="glyphicon glyphicon-comment"></span></a></span>';
						}
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
					action: function(e, dt, node, config) {
						$('#blankNumberSearch_text_pos').val('');
						$('#docNumberSearch_text_pos').val('');
						$('#blankYearSearch_text_pos').val('');
						$('#blankStatusSearch_text_pos').val('');
						$('#blankNameSearch_text_pos').val('');
						$('#blankObjectSearch_text_pos').val('');
						$('#blankTypeSearch_text_pos').val('');
						$('#blankIspolSearch_text_pos').val('');
						table_blankview_gip_pos.columns().search('');
						table_blankview_gip_pos.draw();
					}
				},
				{
					extend: "create",
					editor: editor_blankview_edit_pos,
					text: "НОВЫЙ БЛАНК",
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
					editor: editor_blankview_edit_pos,
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
					extend: "selected",
					text: 'ДУБЛИРОВАТЬ',
					action: function(e, dt, node, config) {

						editor_blankview_edit_pos
							.field('dognet_blankdocpost.kodblankcreate').set(0);
						// Start in edit mode, and then change to create
						editor_blankview_edit_pos
							.edit(table_blankview_gip_pos.rows({
								selected: true
							}).indexes(), {
								title: 'Дублировать бланк',
								buttons: 'Создать на основе выбранного'
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
							return '<span style="text-align:left; white-space:nowrap">Мои бланки (не отправленные в отдел договоров)</span>';
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
				if (data.dognet_blankdocpost.kodtipblank === "CR") {
					$(row).css({
						"color": "rgba(149,20,2,1)"
					});
				} else {
					$(row).css({
						"color": "rgba(102,102,102,1)"
					});
				}
			},
			initComplete: function() {

			},
			drawCallback: function() {

			}

		});
		// ----- ----- ----- ----- -----
		$('#globalSearch_pos_button').click(function(e) {
			table_blankview_gip_pos.search($("#globalSearch_pos_text_pos").val()).draw();
		});
		$('#clearSearch_pos_button').click(function(e) {
			table_blankview_gip_pos.search('').draw();
			$('#globalSearch_pos_text_pos').val('');
		});
		$('#columnSearch_pos_btnApply').click(function(e) {
			table_blankview_gip_pos
				.columns(1)
				.search($("#blankNumberSearch_text_pos").val())
				.draw();

			table_blankview_gip_pos
				.columns(6)
				.search($("#docNumberSearch_text_pos").val())
				.draw();

			table_blankview_gip_pos
				.columns(2)
				.search($("#blankYearSearch_text_pos").val())
				.draw();

			table_blankview_gip_pos
				.columns(5)
				.search($("#blankStatusSearch_text_pos").val())
				.draw();

			table_blankview_gip_pos
				.columns(13)
				.search($("#blankTypeSearch_text_pos").val())
				.draw();

			table_blankview_gip_pos
				.columns(4)
				.search($("#blankObjectSearch_text_pos").val())
				.draw();

			table_blankview_gip_pos
				.columns(3)
				.search($("#blankNameSearch_text_pos").val())
				.draw();

			table_blankview_gip_pos
				.columns(12)
				.search($("#blankIspolSearch_text_pos").val())
				.draw();

		});
		$('#columnSearch_pos_btnClear').click(function(e) {
			$('#blankNumberSearch_text_pos').val('');
			$('#docNumberSearch_text_pos').val('');
			$('#blankYearSearch_text_pos').val('');
			$('#blankStatusSearch_text_pos').val('');
			$('#blankNameSearch_text_pos').val('');
			$('#blankObjectSearch_text_pos').val('');
			$('#blankTypeSearch_text_pos').val('');
			$('#blankIspolSearch_text_pos').val('');
			table_blankview_gip_pos
				.columns()
				.search('')
				.draw();
		});
		// ----- ----- ----- ----- -----
		$("#blankNumberSearch_text_pos").on("keyup", function(event) {
			if (event.keyCode === 13) {
				event.preventDefault();
				document.getElementById("columnSearch_pos_btnApply").click();
			}
		});
		$("#docNumberSearch_text_pos").on("keyup", function(event) {
			if (event.keyCode === 13) {
				event.preventDefault();
				document.getElementById("columnSearch_pos_btnApply").click();
			}
		});
		$("#blankYearSearch_text_pos").on("keyup", function(event) {
			if (event.keyCode === 13) {
				event.preventDefault();
				document.getElementById("columnSearch_pos_btnApply").click();
			}
		});
		$("#blankNameSearch_text_pos").on("keyup", function(event) {
			if (event.keyCode === 13) {
				event.preventDefault();
				document.getElementById("columnSearch_pos_btnApply").click();
			}
		});
		$("#blankObjectSearch_text_pos").on("keyup", function(event) {
			if (event.keyCode === 13) {
				event.preventDefault();
				document.getElementById("columnSearch_pos_btnApply").click();
			}
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		//
		//
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		// Array to track the ids of the edit displayed rows
		var detailRows = [];

		$('#blankview-edit-pos-table tbody').on('click', 'tr td.details-control', function() {
			var tr = $(this).closest('tr');
			var row = table_blankview_gip_pos.row(tr);
			var idx = $.inArray(tr.attr('id'), detailRows);

			if (row.child.isShown()) {
				tr.removeClass('edit');
				row.child.hide();

				// Remove from the 'open' array
				detailRows.splice(idx, 1);
			} else {
				tr.addClass('edit');
				rowData = table_blankview_gip_pos.row(row);
				d = row.data();
				rowData.child(<?php include('templates/blankview-edit-pos-table.tpl'); ?>).show();

				// Add to the 'open' array
				if (idx === -1) {
					detailRows.push(tr.attr('id'));
				}
			}
		});
		// On each draw, loop over the `detailRows` array and show any child rows
		table_blankview_gip_pos.on('draw', function() {
			$.each(detailRows, function(i, id) {
				$('#' + id + ' td.details-control').trigger('click');
			});
		});





		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		//
		//
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		// БЛАНК РАБОЧИЙ ::: Редактор
		var editor_blankview_gip_pos_docfiles = new $.fn.dataTable.Editor({
			display: "bootstrap",
			ajax: "php/examples/php/blankview/blankview-edit/dognet-blankview-edit-pos-docfiles-process.php",
			table: "#blankview-edit-pos-docfiles-table",
			i18n: {
				create: {
					title: "<h3>Добавить новый счет-фактуру</h3>"
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
			/* 		template: '#customForm_docblank-table', */
			fields: []
		});
		// ----- ----- ----- ----- -----
		// БЛАНК РАБОЧИЙ ::: Таблица данных
		var table_blankview_gip_pos_docfiles = $('#blankview-edit-pos-docfiles-table').DataTable({
			dom: "<'row'<'col-sm-5'B><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'><'col-sm-8'>>",
			// 		dom: "<'space50'r>tip",
			language: {
				url: "russian.json"
			},
			ajax: {
				url: "php/examples/php/blankview/blankview-edit/dognet-blankview-edit-pos-docfiles-process.php",
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
					data: "dognet_docblankwork_files.blank_type",
					className: "text-center"
				},
				{
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
				style: 'os',
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
					targets: 1
				},
				{
					orderable: false,
					searchable: true,
					render: function(data, type, row, meta) {
						return '<a class="blank_link" href="' + row.dognet_docblankwork_files.file_url + '" target="_blank">' + row.dognet_sysdefs_blankstatus.status_description + '</a>';
					},
					targets: 2
				},
				{
					orderable: false,
					searchable: true,
					render: function(data, type, row, meta) {
						return '<span class="label label-primary">' + data + '</span>';
					},
					targets: 3
				}
			],
			select: false,
			processing: true,
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
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		// ПРИЛОЖЕНИЯ БЛАНКА ::: Редактор
		var editor_blankview_gip_pos_blankpril = new $.fn.dataTable.Editor({
			display: "bootstrap",
			ajax: {
				url: "php/examples/php/blankview/blankview-edit/dognet-blankview-edit-pos-blankpril-process.php",
				data: function(d) {
					var selected = table_blankview_gip_pos.row({
						selected: true
					});
					if (selected.any()) {
						d.kodblankwork = selected.data().dognet_blankdocpost.kodblankwork;
					}
				}
			},
			table: "#blankview-edit-pos-blankpril-table",
			i18n: {
				create: {
					title: "<h3>Добавить новый счет-фактуру</h3>"
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
			template: '#customForm_blankworkpril',
			fields: [{
				name: "dognet_blankworkpril.docFileID",
				type: "upload",
				display: function(id) {
					return '<a target="_blank" href="' + editor_blankview_gip_pos_blankpril.file('dognet_blankworkpril_files', id).file_webpath + '"><h4>СКАЧАТЬ ФАЙЛ</h4></a>';
				}
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
				name: "dognet_blankworkpril.namepril"
			}]
		});
		// ----- --- ----- --- -----
		editor_blankview_gip_pos_blankpril.on('initCreate', function(e) {
			editor_blankview_gip_pos_blankpril.field('dognet_blankworkpril.msgDocFileID').show();
			editor_blankview_gip_pos_blankpril.field('dognet_blankworkpril.msgDocFileID').val('Сначала создайте запись!');
			editor_blankview_gip_pos_blankpril.field('dognet_blankworkpril.docFileID').hide();
			editor_blankview_gip_pos_blankpril.field('dognet_blankworkpril.docFileID').disable();
		});
		//
		editor_blankview_gip_pos_blankpril.on('initEdit', function(e, node, data, items, type) {
			editor_blankview_gip_pos_blankpril.field('dognet_blankworkpril.msgDocFileID').hide();
			editor_blankview_gip_pos_blankpril.field('dognet_blankworkpril.docFileID').show();
			editor_blankview_gip_pos_blankpril.field('dognet_blankworkpril.docFileID').enable();
		});
		// ----- ----- ----- ----- -----
		// ПРИЛОЖЕНИЯ БЛАНКА ::: Таблица данных
		var table_blankview_gip_pos_blankpril = $('#blankview-edit-pos-blankpril-table').DataTable({
			dom: "<'row'<'col-sm-5'B><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'><'col-sm-8'>>",
			// 		dom: "<'space50'r>tip",
			language: {
				url: "russian.json"
			},
			ajax: {
				url: "php/examples/php/blankview/blankview-edit/dognet-blankview-edit-pos-blankpril-process.php",
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
				style: 'os',
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
						if (row.dognet_blankworkpril_files.file_url == null) {
							return data;
						} else {
							return '<a class="blank_link" href="' + row.dognet_blankworkpril_files.file_url + '" target="_blank">' + data + '</a>';
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
			processing: true,
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
		//
		//
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		table_blankview_gip_pos.on('select', function() {
			table_blankview_gip_pos.buttons().enable();
			table_blankview_gip_pos_docfiles.buttons().enable();
			table_blankview_gip_pos_docfiles.ajax.reload();
			table_blankview_gip_pos_blankpril.buttons().enable();
			table_blankview_gip_pos_blankpril.ajax.reload();
		});
		table_blankview_gip_pos.on('deselect', function() {
			table_blankview_gip_pos_docfiles.buttons().disable();
			table_blankview_gip_pos_docfiles.ajax.reload();
			table_blankview_gip_pos_blankpril.buttons().disable();
			table_blankview_gip_pos_blankpril.ajax.reload();
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

	});
</script>

<style>
	/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----

ТАБЛИЦА ФАЙЛОВ БЛАНКОВ : blankview-edit-pos-docfiles-table

----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
	#blankview-edit-pos-docfiles {
		padding: 10px 15px;
		border: 1px #e9e9e9 solid;
		border-radius: 5px
	}

	#blankview-edit-pos-docfiles>h3 {
		color: #111;
		font-family: 'Oswald', sans-serif;
		font-weight: 400;
		font-size: 1.7em;
		letter-spacing: 0.05em
	}

	/* Общее для таблицы */
	#blankview-edit-pos-docfiles-table {}

	#blankview-edit-pos-docfiles-table .details-control:hover {
		cursor: hand
	}

	/* Заголовок таблицы */
	#blankview-edit-pos-docfiles-table>thead {
		display: none
	}

	#blankview-edit-pos-docfiles-table>thead>tr>th {
		color: #333;
		border-bottom: none;
		font-weight: 500;
		font-size: 1.2em;
		text-transform: uppercase
	}

	#blankview-edit-pos-docfiles-table .sorting:after,
	#blankview-edit-pos-table .sorting_asc:after,
	#blankview-edit-pos-table .sorting_desc:after {
		display: none
	}

	#blankview-edit-pos-docfiles-table>thead>tr>th.sorting_asc {
		padding-right: 8px
	}

	#blankview-edit-pos-docfiles-table>thead>tr>th.sorting_desc {
		padding-right: 8px
	}

	#blankview-edit-pos-docfiles-table .sorting_asc:after {
		display: none
	}

	#blankview-edit-pos-docfiles-table>thead>tr>th.sorting_asc {
		padding-right: 8px
	}

	/* Тело таблицы */
	#blankview-edit-pos-docfiles-table>tbody>tr>td {
		padding: 5px;
		border: none
	}

	#blankview-edit-pos-docfiles-table>tbody>tr>td:first-child {
		width: 5%;
		text-align: left
	}

	#blankview-edit-pos-docfiles-table>tbody>tr>td:nth-child(2) {
		width: 5%;
		text-align: left
	}

	#blankview-edit-pos-docfiles-table>tbody>tr>td:nth-child(3) {
		width: 85%;
		text-align: left
	}

	#blankview-edit-pos-docfiles-table>tbody>tr>td:nth-child(4) {
		width: 5%;
		text-align: right;
		text-transform: uppercase
	}

	/* Разное */
	#blankview-edit-pos-docfiles-table a.blank_link {
		color: #08C;
		text-decoration: underline
	}

	#blankview-edit-pos-docfiles-table a.blank_link:hover {
		text-decoration: none
	}
</style>
<?php
// ----- ----- ----- ----- -----
// Форма редактирования этапа
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/blankview/blankview-edit/restr_3/tabs/css/blankview-edit-tab2_pos.css">
<div id="customForm_newblank_pos">
	<div id="newblank-pos-tabs" style="width:100%">
		<ul id="newblank-pos-tabs-menu" class="nav nav-tabs space10">
			<li class="active"><a data-toggle="tab" href="#pos-tab-1" title="">Основное</a></li>
			<li><a data-toggle="tab" href="#pos-tab-2" title="">Суммы</a></li>
			<li><a data-toggle="tab" href="#pos-tab-3" title="">Приложения</a></li>
			<li><a data-toggle="tab" href="#pos-tab-4" title="">Исполнение</a></li>
			<li><a data-toggle="tab" href="#pos-tab-5" title="">Контакты</a></li>
			<li><a data-toggle="tab" href="#pos-tab-6" title="">Транспорт</a></li>
			<li><a data-toggle="tab" href="#pos-tab-7" title="">ДО</a></li>
			<li><a data-toggle="tab" href="#pos-tab-8" title="">Риски</a></li>
			<li><a data-toggle="tab" href="#pos-tab-0" title="" class="text-danger">Сформировать бланк</a></li>
		</ul>
		<div class="tab-content">
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
								<input id="kodzakaz_filter" type="text" placeholder="Поиск" />
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
					<div class="Block30">
						<legend>Сумма договора</legend>
						<fieldset class="field60">
							<editor-field name="dognet_blankdocpost.csummadocopl"></editor-field>
						</fieldset>
						<fieldset class="field40">
							<editor-field name="dognet_blankdocpost.kodusendsopl"></editor-field>
						</fieldset>
						<fieldset class="field60">
							<editor-field name="dognet_blankdocpost.kodusespechopl"></editor-field>
						</fieldset>
					</div>
					<div class="Block70">
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
			<div id="pos-tab-7" class="tab-pane fade">

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
			<div id="pos-tab-8" class="tab-pane fade">

				<div class="Section">
					<div class="Block100">
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
			<div id="pos-tab-0" class="tab-pane fade">

				<div class="Section">
					<div class="Block100">
						<div class="Block100 fieldset-table-row">
							<div class="fieldset-table-cell" style="padding-bottom:3px">
								<fieldset>
									<editor-field name="dognet_blankdocpost.kodblankcreate"></editor-field>
								</fieldset>
							</div>
							<div class="fieldset-table-cell" style="width:100%">
								<div>
									<div class="chekbox-inline-text">Отправить бланк в Отдел договоров. После этого редатирование бланка будет уже невозможно!</div>
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
// ----- ----- ----- ----- -----
// Форма добавления файла
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/blankview/blankview-edit/restr_3/tabs/css/blankview-edit-tab2_pril_files.css">
<div id="customForm_blankworkpril">
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
			<fieldset class="field20">
				<editor-field name="dognet_blankworkpril.kodblankwork"></editor-field>
			</fieldset>
			<fieldset class="field60">
				<editor-field name="dognet_blankworkpril.namepril"></editor-field>
			</fieldset>
		</div>
	</div>
</div>
<?php
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
?>
<div id="blanksearch-filters-pos-block" class="panel-group">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a data-toggle="collapse" href="#blanksearch-filters-pos">Фильтры для поиска бланка</a>
			</h4>
		</div>
		<div id="blanksearch-filters-pos" class="panel-collapse collapse">

			<div id="blankview-edit-filters" class="panel-body space30">
				<div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
					<div class="form-group space10" style="width:100%">
						<label for="blankNumberSearch_text_pos"><b>Номер бланка :</b></label>
						<input type="text" id="blankNumberSearch_text_pos" class="form-control" placeholder="Все номера" name="blankNumberSearch_text_pos">
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
					<div class="form-group space10" style="width:100%">
						<label for="docNumberSearch_text_pos"><b>Номер договора :</b></label>
						<input type="text" id="docNumberSearch_text_pos" class="form-control" placeholder="Все номера" name="docNumberSearch_text_pos">
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
					<div class="form-group space10" style="width:100%">
						<label for="blankYearSearch_text_pos"><b>Год :</b></label>
						<input type="text" id="blankYearSearch_text_pos" class="form-control" placeholder="XXXX" name="blankYearSearch_text_pos">
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
					<div class="form-group space10" style="width:100%">
						<label for="blankStatusSearch_text_pos"><b>Статус бланка :</b></label>
						<select name="blankStatusSearch_text_pos" id="blankStatusSearch_text_pos" class="form-control">
							<option value="">Все статусы бланков</option>
							<?php
							$_QRY1 = mysqlQuery("SELECT status_kod, status_description FROM dognet_sysdefs_blankstatus WHERE status = 1");
							while ($_ROW1 = mysqli_fetch_assoc($_QRY1)) {
							?>
								<option value='<?php echo $_ROW1["status_kod"]; ?>'><?php echo $_ROW1["status_description"]; ?></option>
							<?php
							}
							?>
						</select>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
					<div class="form-group space10" style="width:100%">
						<label for="blankTypeSearch_text_pos"><b>Тип бланка :</b></label>
						<select name="blankTypeSearch_text_pos" id="blankTypeSearch_text_pos" class="form-control">
							<option value="">Все типы бланков</option>
							<?php
							$_QRY2 = mysqlQuery(" SELECT type_kod, type_description FROM dognet_sysdefs_blanktype WHERE status = 1");
							while ($_ROW2 = mysqli_fetch_assoc($_QRY2)) {
							?>
								<option value='<?php echo $_ROW2["type_kod"]; ?>'><?php echo $_ROW2["type_description"]; ?></option>
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
						<label for="blankObjectSearch_text_pos"><b>Заказчик/объект :</b></label>
						<input type="text" id="blankObjectSearch_text_pos" class="form-control" placeholder="Все объекты" name="blankObjectSearch_text_pos">
					</div>
				</div>
				<?php // ----- ----- ----- ----- ----- 
				?>
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
					<div class="input-group space10" style="width:100%">
						<label for="blankIspolSearch_text_pos"><b>ГИП (исполнитель) :</b></label>
						<select name="blankIspolSearch_text_pos" id="blankIspolSearch_text_pos" class="form-control">
							<option value="">Все исполнители</option>
							<?php
							$_QRY3 = mysqlQuery("SELECT ispolnamefull, ispolnameshot FROM dognet_spispol WHERE ispolnamefull<>'' AND koddel<>99 AND kodusegip = 1 ORDER BY ispolnameshot ASC");
							while ($_ROW3 = mysqli_fetch_assoc($_QRY3)) {
							?>
								<option value='<?php echo $_ROW3["ispolnameshot"]; ?>'><?php echo $_ROW3["ispolnameshot"]; ?></option>
							<?php
							}
							?>
						</select>
					</div>
				</div>
				<?php // ----- ----- ----- ----- ----- 
				?>
				<div class="col-xs-12 col-sm-4 col-md-6 col-lg-6">
					<div class="input-group space10" style="width:100%">
						<label for="blankNameSearch_text_pos"><b>Текст из названия договора :</b></label>
						<input type="text" id="blankNameSearch_text_pos" class="form-control" placeholder="Введите текст для поиска в названии" name="blankNameSearch_text_pos">
					</div>
				</div>
				<?php // ----- ----- ----- ----- ----- 
				?>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
					<div class="input-group-btn">
						<button id="columnSearch_pos_btnApply" class="btn btn-default" type="button">Применить фильтры</button>
						<button id="columnSearch_pos_btnClear" class="btn btn-default" type="button"><i class="glyphicon glyphicon-remove"></i></button>
					</div>
				</div>
				<?php // ----- ----- ----- ----- ----- 
				?>
			</div>

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
	<table id="blankview-edit-pos-table" class="table table-striped" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
				<th width="" class="">ID бланка</th>
				<th width="" class="">Организация</th>
				<th width="" class="">Описание</th>
				<th width="" class="">Исполнитель ( рук )</th>
				<th width="" class=""></th>
				<th width="" class=""></th>
			</tr>
		</thead>
	</table>
</section>
<?php
//
// ----- ----- -----
//
?>
<section>
	<div class="space10"></div>
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		<div id="blankview-edit-pos-docfiles">
			<h3 class="space10">Бланки требований</h3>
			<div class="demo-html"></div>
			<table id="blankview-edit-pos-docfiles-table" class="table table-striped" cellspacing="0" width="100%">
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
		<div id="blankview-edit-pos-blankpril">
			<h3 class="space10">Вложения</h3>
			<div class="demo-html"></div>
			<table id="blankview-edit-pos-blankpril-table" class="table table-striped" cellspacing="0" width="100%">
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