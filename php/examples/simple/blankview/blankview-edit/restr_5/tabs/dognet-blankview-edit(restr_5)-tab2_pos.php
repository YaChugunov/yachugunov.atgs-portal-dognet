<script type="text/javascript" language="javascript" class="init">
	function print_checkBox(checkBox) {
		if (checkBox == 1) {
			return "<span class='glyphicon glyphicon-check'></span>";
		} else {
			return "<span class='glyphicon glyphicon-unchecked'></span>";
		}
	}
	$(document).ready(function() {
		//
		//
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		// API INSTANCE ФОРМЫ БЛАНКА НА ПОСТАВКУ ::: Редактор
		var editor_blankview_edit_pos = new $.fn.dataTable.Editor({
			display: "bootstrap",
			ajax: {
				url: "php/examples/simple/blankview/blankview-edit/restr_5/tabs/process/dognet-blankview-edit-pos-process.php",
				data: function(d) {
					var selected = table_blankview_edit_pos.row({
						selected: true
					});
					if (selected.any()) {
						d.kodblankwork_tab2 = selected.data().dognet_blankdocpost.kodblankwork;
						d.kodblankpost_tab2 = selected.data().dognet_blankdocpost.kodblankpost;
						d.kodstatusblank_tab2 = selected.data().dognet_blankdocpost.kodtipblank;
						d.parentid_tab2 = selected.id().substr(4);
					}
				}
			},
			table: "#blankview-edit-pos-table",
			i18n: {
				create: {
					title: "<h3>Создать новую заявку/бланк на договор поставки</h3>"
				},
				edit: {
					title: "<h3>Изменить бланк</h3>"
				},
				remove: {
					button: "Удалить",
					title: "<h3>Удалить бланк</h3>",
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
				label: "Особые условия договора :",
				name: "dognet_blankdocpost.defuslgiptext",
				type: "textarea",
				fieldInfo: ""
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
				name: "dognet_blankdocpost.kodblankinprocess",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpost.kodblankdone",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				name: "dognet_blankdocpost.kodtipblank"
			}, {
				label: "",
				name: "dognet_blankdocpost.kodblankwork"
			}, {
				label: "",
				name: "dognet_blankdocpost.kodblankpost"
			}]
		});
		//
		//
		// Изменяем размер диалогового окна редактирования договора субподряда
		editor_blankview_edit_pos.on('open', function() {
			$(".modal-dialog").css({
				"width": "95%",
				"margin": "1.0em auto",
				"min-width": "800px",
				"max-width": "1170px"
			});
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		var openVals_pos;
		editor_blankview_edit_pos.on('open', function() {
			$('#kodzakaz_filter_pos').val('');
			if (($('#DTE_Field_dognet_blankdocpost-kodzakaz').value) != editor_blankview_edit_pos.field('dognet_blankdocpost.kodzakaz').get()) {}
			// Поиск в ниспадающем списке по содержимому текстового поля для ответного документа
			$('#DTE_Field_dognet_blankdocpost-kodzakaz').filterByText(editor_blankview_edit_pos, $('#kodzakaz_filter_pos'), 'dognet_blankdocpost.kodzakaz', false);
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
			table_blankview_edit_pos.rows().deselect();
			table_blankview_edit_pos.ajax.reload();
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
		//
		// ::::: З А В И С И М О С Т И (dependences) : BEGIN
		//
		// TAB 1
		editor_blankview_edit_pos.dependent('dognet_blankdocpost.kodusespzakaz', function(val) {
			if (val == 0) {
				editor_blankview_edit_pos.field('dognet_blankdocpost.kodzakaz').disable();
				$('#kodzakaz_filter_pos').prop('disabled', true);
			} else {
				editor_blankview_edit_pos.field('dognet_blankdocpost.kodzakaz').enable();
				$('#kodzakaz_filter_pos').prop('disabled', false);
			}
		});
		editor_blankview_edit_pos.dependent('dognet_blankdocpost.koduseneworg', function(val) {
			if (val == 0) {
				editor_blankview_edit_pos.field('dognet_blankdocpost.nameneworg').disable();
			} else {
				editor_blankview_edit_pos.field('dognet_blankdocpost.nameneworg').enable();
			}
		});

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
				$("#tab2_useispoldoc1").css('outline-color', '#019401');
			} else {
				editor_blankview_edit_pos.field('dognet_blankdocpost.cdateispoldoc1').disable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseispoldoc2').enable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseispoldoc3').enable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseispoldoc4').enable();
				$("#tab2_useispoldoc1").css('outline-color', '#ccc');
			}
		});
		editor_blankview_edit_pos.dependent('dognet_blankdocpost.koduseispoldoc2', function(val) {
			if (val == 1) {
				editor_blankview_edit_pos.field('dognet_blankdocpost.cdaysispoldoc2').enable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseispoldoc1').disable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseispoldoc3').disable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseispoldoc4').disable();
				$("#tab2_useispoldoc2").css('outline-color', '#019401');
			} else {
				editor_blankview_edit_pos.field('dognet_blankdocpost.cdaysispoldoc2').disable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseispoldoc1').enable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseispoldoc3').enable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseispoldoc4').enable();
				$("#tab2_useispoldoc2").css('outline-color', '#ccc');
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
				$("#tab2_useispoldoc3").css('outline-color', '#019401');
			} else {
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseispoldoc1').enable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseispoldoc2').enable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseispoldoc4').enable();
				$("#tab2_useispoldoc3").css('outline-color', '#ccc');
			}
		});
		editor_blankview_edit_pos.dependent('dognet_blankdocpost.koduseispoldoc4', function(val) {
			if (val == 1) {
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseispoldoc1').disable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseispoldoc2').disable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseispoldoc3').disable();
				$("#tab2_useispoldoc4").css('outline-color', '#019401');
			} else {
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseispoldoc1').enable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseispoldoc2').enable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseispoldoc3').enable();
				$("#tab2_useispoldoc4").css('outline-color', '#ccc');
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
				$("#tab2_useopl1usl").css('outline-color', '#019401');
			} else {
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseopl2usl').enable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseopl3usl').enable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseopl4usl').enable();
				$("#tab2_useopl1usl").css('outline-color', '#ccc');
			}
		});
		editor_blankview_edit_pos.dependent('dognet_blankdocpost.koduseopl2usl', function(val) {
			if (val == 1) {
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseopl1usl').disable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseopl3usl').disable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseopl4usl').disable();
				$("#tab2_useopl2usl").css('outline-color', '#019401');
			} else {
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseopl1usl').enable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseopl3usl').enable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseopl4usl').enable();
				$("#tab2_useopl2usl").css('outline-color', '#ccc');
			}
		});
		editor_blankview_edit_pos.dependent('dognet_blankdocpost.koduseopl3usl', function(val) {
			if (val == 1) {
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseopl1usl').disable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseopl2usl').disable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseopl4usl').disable();
				$("#tab2_useopl3usl").css('outline-color', '#019401');
			} else {
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseopl1usl').enable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseopl2usl').enable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseopl4usl').enable();
				$("#tab2_useopl3usl").css('outline-color', '#ccc');
			}
		});
		editor_blankview_edit_pos.dependent('dognet_blankdocpost.koduseopl4usl', function(val) {
			if (val == 1) {
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseopl1usl').disable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseopl2usl').disable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseopl3usl').disable();
				$("#tab2_useopl4usl").css('outline-color', '#019401');
			} else {
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseopl1usl').enable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseopl2usl').enable();
				editor_blankview_edit_pos.field('dognet_blankdocpost.koduseopl3usl').enable();
				$("#tab2_useopl4usl").css('outline-color', '#ccc');
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
		var table_blankview_edit_pos = $('#blankview-edit-pos-table').DataTable({
			dom: "<'row'<'col-sm-9'B><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'p>>",
			// 		dom: "<'space50'r>tip",
			language: {
				url: "php/examples/simple/blankview/blankview-edit/dt_russian-tab2_pos.json"
			},
			ajax: {
				url: "php/examples/simple/blankview/blankview-edit/restr_5/tabs/process/dognet-blankview-edit-pos-process.php",
				type: "POST"
			},
			serverSide: true,
			columns: [{
					class: "details-control-docblank-pos",
					searchable: false,
					orderable: false,
					data: null,
					defaultContent: "<span class='glyphicon glyphicon-option-vertical'></span>"
				},
				{
					data: "dognet_blankdocpost.kodpaperstr",
					className: ""
				},
				{
					data: "dognet_blankdocpost.kodblankpost",
					className: ""
				},
				{
					data: "dognet_spispol.ispolnamefull",
					className: ""
				},
				{
					data: "dognet_spispolruk.ispolruknamefull",
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
					data: "dognet_blankdocpost.kodtipblank",
					className: ""
				},
				{
					class: "details-control-blankwork-pos",
					searchable: false,
					orderable: false,
					data: null,
					defaultContent: '<span class="glyphicon glyphicon-list-alt"></span>',
					className: "text-right"
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
					render: function(data, type, row, meta) {
						var tipdoc = row.dognet_docblankwork.kodstatusblank;
						var docdone = row.dognet_docblankwork.kodblankdone;
						if (row.dognet_docblankwork.kodtipblank === "POS") {
							var tipblank = row.dognet_blankdocpost.kodtipblank;
							var inprocess = row.dognet_blankdocpost.kodblankinprocess;
							var blankdone = row.dognet_blankdocpost.kodblankdone;
						}
						// Заявка создана.
						if (tipdoc == "CR" && docdone == 0 && tipblank == "CR" && inprocess == 0 && blankdone == 0) {
							return "<span class='label label-default text-uppercase' style='color:#fafafa; background-color:#a94442; border:1px #fff solid'>Новый бланк</span>";
						}
						// Заявка создана. Отделом договоров получена.
						else if (tipdoc == "CR" && docdone == 0 && tipblank == "CR" && inprocess == 1 && blankdone == 1) {
							return "<span class='label label-default text-uppercase' style='color:#fafafa; background-color:#ff7611; border:1px #fff solid'>Бланк в работе 1</span>";
						}
						// Заявка создана. Отделом договоров получена.
						else if (tipdoc == "CR" && docdone == 0 && tipblank == "RD" && inprocess == 1 && blankdone == 0) {
							return "<span class='label label-default text-uppercase' style='color:#fafafa; background-color:#ff7611; border:1px #fff solid'>Бланк в работе 2</span>";
						}
						// Заявка в работе. ПЕРВАЯ версия бланка отдела договоров.
						else if (tipdoc == "CR" && docdone == 0 && tipblank == "RD" && inprocess == 1 && blankdone == 1) {
							return "<span class='label label-default text-uppercase' style='color:#fafafa; background-color:#ff7611; border:1px #fff solid'>Бланк в работе 3</span>";
						}
						// Заявка в работе. ПЕРВАЯ версия бланка отдела договоров.
						else if (tipdoc == "CR" && docdone == 1 && tipblank == "CR" && inprocess == 1 && blankdone == 1) {
							return "<span class='label label-default text-uppercase' style='color:#fafafa; background-color:#ff7611; border:1px #fff solid'>Бланк в работе 4</span>";
						}
						// Заявка в работе. Промежуточная версия бланка отдела договоров.
						else if (tipdoc == "RD" && docdone == 1 && tipblank == "RD" && inprocess == 1 && blankdone == 1) {
							return "<span class='label label-default text-uppercase' style='color:#fafafa; background-color:#ff7611; border:1px #fff solid'>Бланк в работе 5</span>";
						}
						// Заявка обработана. Можно готовить договор.
						else if (tipdoc == "RD" && docdone == 1 && tipblank == "DO" && inprocess == 1 && blankdone == 1) {
							return "<span class='label label-default text-uppercase' style='color:#fafafa; background-color:#31708f; border:1px #fff solid'>Ждет договора</span>";
						}
						// Заявка закрыта. Договор создан. Бланк привязан к договору.
						else if (tipdoc == "DO" && docdone == 1 && tipblank == "DO" && inprocess == 1 && blankdone == 1) {
							return "<span class='label label-default text-uppercase' style='color:#999999; background-color:#ccc; border:1px #fff solid'>Договор готов</span>";
						} else {
							return "-";
						}
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
					targets: 5,
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
					visible: false,
					searchable: true,
					targets: 6
				},
				{
					orderable: false,
					visible: false,
					searchable: true,
					targets: 7,
					render: function(data, type, row, meta) {
						return data;
					}
				},
				{
					orderable: false,
					searchable: false,
					targets: 8
				}
			],
			order: [
				[7, "asc"],
				[2, "desc"]
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
						table_blankview_edit_pos.columns().search('');
						table_blankview_edit_pos.draw();
						table_blankview_edit_pos_summadop.ajax.reload();
						table_blankview_edit_pos_docfiles.ajax.reload();
						table_blankview_edit_pos_blankpril.ajax.reload();
					}
				},
				{
					extend: "selected",
					text: 'РАБОТАТЬ С БЛАНКОМ',
					action: function(e, dt, node, config) {

						// Get currently selected row ids
						var parentid = dt.row({
							selected: true
						}).id();

						editor_blankview_edit_pos.on('preOpen', function(e) {
							editor_blankview_edit_pos.field('dognet_blankdocpost.kodblankcreate').disable();
							editor_blankview_edit_pos.field('dognet_blankdocpost.kodblankinprocess').set(1);
							editor_blankview_edit_pos.field('dognet_blankdocpost.kodblankinprocess').disable();
							editor_blankview_edit_pos.field('dognet_blankdocpost.kodblankdone').set(0);
						});

						// Start in edit mode, and then change to create
						editor_blankview_edit_pos
							.edit(table_blankview_edit_pos.rows({
								selected: true
							}).indexes(), {
								title: '<h3>Работать с бланком на поставку</h3>',
								buttons: 'Применить изменения'
							})
							.mode('create');
					}
				}
			],
			rowGroup: {
				startRender: function(rows, group, level) {

					if (level == 0) {
						if (group == "CR") {
							return '<span style="text-align:left; white-space:nowrap">Новые бланки. Версия ГИП.</span>';
						} else if (group == "RD") {
							return '<span style="text-align:left; white-space:nowrap">Бланк в работе.</span>';
						} else if (group == "DO") {
							return '<span style="text-align:left; white-space:nowrap">Работа с бланком завершена. Договор готов.</span>';
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
						"font-style": "italic"
					});
				} else {
					$(row).css({
						"font-style": "none"
					});
				}
			},
			initComplete: function() {

			},
			drawCallback: function(settings) {

			}
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		// Array to track the ids of the edit displayed rows
		var detailRows_docblank_pos = [];
		$('#blankview-edit-pos-table tbody').on('click', 'tr td.details-control-docblank-pos', function() {
			var tr = $(this).closest('tr');
			var row = table_blankview_edit_pos.row(tr);
			var idx = $.inArray(tr.attr('id'), detailRows_docblank_pos);

			if (row.child.isShown()) {
				tr.removeClass('edit');
				row.child.hide();

				// Remove from the 'open' array
				detailRows_docblank_pos.splice(idx, 1);
			} else {
				tr.addClass('edit');
				rowData = table_blankview_edit_pos.row(row);
				d = row.data();
				rowData.child(<?php include('templates/blankview-edit-tab2-blankwork-doc-table.tpl'); ?>).show();

				// Add to the 'open' array
				if (idx === -1) {
					detailRows_docblank_pos.push(tr.attr('id'));
				}
			}
		});
		// ----- ----- ----- ----- -----
		// On each draw, loop over the `detailRows_docblank_pos` array and show any child rows
		table_blankview_edit_pos.on('draw', function() {
			$.each(detailRows_docblank_pos, function(i, id) {
				$('#' + id + ' td.details-control-docblank-pos').trigger('click');
			});
		});
		// ----- ----- ----- ----- -----
		// Array to track the ids of the edit displayed rows
		var detailRows_blankwork_pos = [];
		$('#blankview-edit-pos-table tbody').on('click', 'tr td.details-control-blankwork-pos', function() {
			var tr = $(this).closest('tr');
			var row = table_blankview_edit_pos.row(tr);
			var idx = $.inArray(tr.attr('id'), detailRows_blankwork_pos);

			if (row.child.isShown()) {
				tr.removeClass('edit');
				row.child.hide();

				// Remove from the 'open' array
				detailRows_blankwork_pos.splice(idx, 1);
			} else {
				tr.addClass('edit');
				rowData = table_blankview_edit_pos.row(row);
				d = row.data();
				rowData.child(<?php include('templates/blankview-edit-tab2-blankwork-pos-table.tpl'); ?>).show();

				// Add to the 'open' array
				if (idx === -1) {
					detailRows_blankwork_pos.push(tr.attr('id'));
				}
			}
		});
		// ----- ----- ----- ----- -----
		// On each draw, loop over the `detailRows_docblank_pos` array and show any child rows
		table_blankview_edit_pos.on('draw', function() {
			$.each(detailRows_blankwork_pos, function(i, id) {
				$('#' + id + ' td.details-control-blankwork-pos').trigger('click');
			});

			// Выводим уведомление (цифру) о новых заявках на договор
			cnt_pos = table_blankview_edit_pos.data().count();
			console.log("table_blankview_edit_pos.count() : " + cnt_pos);
			if (cnt_pos > 0) {
				document.getElementById("pos_newitems_cnt").innerHTML = cnt_pos;
			}
			//

		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		//
		// Не позволяем выделять бланки в стадии оформления
		table_blankview_edit_pos.on('user-select', function(e, dt, type, cell, originalEvent) {
			var row = dt.row(cell.index().row);
			if (((row.data().dognet_blankdocpost.kodtipblank == "CR") && (row.data().dognet_blankdocpost.kodblankinprocess == 1))) {
				e.preventDefault();
			}
			if (((row.data().dognet_blankdocpost.kodtipblank == "RD") && (row.data().dognet_blankdocpost.kodblankdone == 1))) {
				e.preventDefault();
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
		// БЛАНКИ ДЛЯ ПЕЧАТИ ::: Редактор
		var editor_blankview_edit_pos_docfiles = new $.fn.dataTable.Editor({
			display: "bootstrap",
			ajax: "php/examples/simple/blankview/blankview-edit/restr_5/tabs/process/dognet-blankview-edit-pos-docfiles-process.php",
			table: "#blankview-edit-pos-docfiles-table",
			i18n: {
				create: {
					title: "<h3>Прикрепить файл</h3>"
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
			template: '#customForm_docblankfiles_pos',
			fields: []
		});
		//
		//
		// Изменяем размер диалогового окна редактирования договора субподряда
		editor_blankview_edit_pos_docfiles.on('open', function() {
			$(".modal-dialog").css({
				"width": "30%",
				"margin": "0em 70%",
				"min-width": "360px",
				"max-width": "480px"
			});
		});
		// ----- ----- -----
		// БЛАНКИ ДЛЯ ПЕЧАТИ ::: Таблица данных
		var table_blankview_edit_pos_docfiles = $('#blankview-edit-pos-docfiles-table').DataTable({
			dom: "<'row'<'col-sm-5'B><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'><'col-sm-8'>>",
			// 		dom: "<'space50'r>tip",
			language: {
				url: "php/examples/simple/blankview/blankview-edit/dt_russian-tab2_pos-docfiles.json"
			},
			ajax: {
				url: "php/examples/simple/blankview/blankview-edit/restr_5/tabs/process/dognet-blankview-edit-pos-docfiles-process.php",
				type: 'post',
				data: function(d) {
					var selected = table_blankview_edit_pos.row({
						selected: true
					});
					if (selected.any()) {
						d.kodblankwork_tab2_docfiles = selected.data().dognet_blankdocpost.kodblankwork;
						console.log("Kodblankwork (" + selected.id() + ") :: kodblankwork: " + d.kodblankwork_tab2_docfiles);
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
					editor: editor_blankview_edit_pos_docfiles,
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
					extend: "remove",
					editor: editor_blankview_edit_pos_docfiles,
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
		var editor_blankview_edit_pos_blankpril = new $.fn.dataTable.Editor({
			display: "bootstrap",
			ajax: {
				url: "php/examples/simple/blankview/blankview-edit/restr_5/tabs/process/dognet-blankview-edit-pos-blankpril-process.php",
				data: function(d) {
					var selected = table_blankview_edit_pos.row({
						selected: true
					});
					if (selected.any()) {
						d.kodblankwork_tab2_blankpril = selected.data().dognet_blankdocpost.kodblankwork;
					}
				}
			},
			table: "#blankview-edit-pos-blankpril-table",
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
					return '<h4><a target="_blank" href="' + editor_blankview_edit_pos_blankpril.file('dognet_blankworkpril_files', id).file_webpath + '"><span class="glyphicon glyphicon-eye-open"></span></a></h4>';
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
		// Изменяем размер диалогового окна редактирования договора субподряда
		editor_blankview_edit_pos_blankpril.on('open', function() {
			$(".modal-dialog").css({
				"width": "30%",
				"margin": "0em 70%",
				"min-width": "360px",
				"max-width": "480px"
			});
		});
		// ----- ----- -----
		editor_blankview_edit_pos_blankpril.on('initCreate', function(e) {
			editor_blankview_edit_pos_blankpril.field('dognet_blankworkpril.msgDocFileID').show();
			editor_blankview_edit_pos_blankpril.field('dognet_blankworkpril.msgDocFileID').val('Сначала создайте запись!');
			editor_blankview_edit_pos_blankpril.field('dognet_blankworkpril.docFileID').hide();
			editor_blankview_edit_pos_blankpril.field('dognet_blankworkpril.docFileID').disable();
		});
		//
		editor_blankview_edit_pos_blankpril.on('initEdit', function(e, node, data, items, type) {
			editor_blankview_edit_pos_blankpril.field('dognet_blankworkpril.msgDocFileID').hide();
			editor_blankview_edit_pos_blankpril.field('dognet_blankworkpril.docFileID').show();
			editor_blankview_edit_pos_blankpril.field('dognet_blankworkpril.docFileID').enable();
		});
		//
		// ----- ----- -----
		// ПРИКРЕПЛЯЕМЫЕ ФАЙЛЫ К БЛАНКУ ::: Таблица данных
		var table_blankview_edit_pos_blankpril = $('#blankview-edit-pos-blankpril-table').DataTable({
			dom: "<'row'<'col-sm-5'B><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'><'col-sm-8'>>",
			// 		dom: "<'space50'r>tip",
			language: {
				url: "php/examples/simple/blankview/blankview-edit/dt_russian-tab2_pos-prilfiles.json"
			},
			ajax: {
				url: "php/examples/simple/blankview/blankview-edit/restr_5/tabs/process/dognet-blankview-edit-pos-blankpril-process.php",
				type: 'post',
				data: function(d) {
					var selected = table_blankview_edit_pos.row({
						selected: true
					});
					if (selected.any()) {
						d.kodblankwork_tab2_blankpril = selected.data().dognet_blankdocpost.kodblankwork;
						console.log("Kodblankwork (" + selected.id() + ") :: kodblankwork: " + d.kodblankwork_tab2_blankpril);
					}
				}
			},
			serverSide: true,
			columns: [{
					data: "dognet_blankworkpril.numberpril",
					className: "text-center"
				},
				{
					data: "dognet_blankworkpril.kodtipblank",
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
					searchable: true,
					render: function(data, type, row, meta) {
						if (row.dognet_blankworkpril_files.file_url == null) {
							return data;
						} else {
							return '<a class="blank_link" href="' + row.dognet_blankworkpril_files.file_url + '" target="_blank">' + data + '</a>';
						}
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
			select: true,
			processing: false,
			paging: false,
			searching: false,
			buttons: [{
					extend: "create",
					editor: editor_blankview_edit_pos_blankpril,
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
					editor: editor_blankview_edit_pos_blankpril,
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
					editor: editor_blankview_edit_pos_blankpril,
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
		var editor_blankview_edit_pos_summadop = new $.fn.dataTable.Editor({
			display: "bootstrap",
			ajax: {
				url: "php/examples/simple/blankview/blankview-edit/restr_5/tabs/process/dognet-blankview-edit-pos-summadop-process.php",
				data: function(d) {
					var selected = table_blankview_edit_pos.row({
						selected: true
					});
					if (selected.any()) {
						d.kodblankwork_tab2_summadop = selected.data().dognet_blankdocpost.kodblankwork;
						d.kodtipblank_tab2_summadop = selected.data().dognet_blankdocpost.kodtipblank;
						d.rowID_tab2_summadop = selected.id().substr(4);
					}
				}
			},
			table: "#blankview-edit-pos-summadop-table",
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
		editor_blankview_edit_pos_summadop.on('open', function() {
			$(".modal-dialog").css({
				"width": "60%",
				"margin": "1.0em auto",
				"min-width": "640px",
				"max-width": "800px"
			});
		});
		// ----- ----- ----- ----- -----
		// ПРИКРЕПЛЯЕМЫЕ ФАЙЛЫ К БЛАНКУ ::: Таблица данных
		var table_blankview_edit_pos_summadop = $('#blankview-edit-pos-summadop-table').DataTable({
			dom: "<'row'<'col-sm-5'B><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'><'col-sm-8'>>",
			// 		dom: "<'space50'r>tip",
			language: {
				url: "php/examples/simple/blankview/blankview-edit/dt_russian-tab2_pos-summadop.json"
			},
			ajax: {
				url: "php/examples/simple/blankview/blankview-edit/restr_5/tabs/process/dognet-blankview-edit-pos-summadop-process.php",
				type: 'post',
				data: function(d) {
					var selected = table_blankview_edit_pos.row({
						selected: true
					});
					if (selected.any()) {
						d.kodblankwork_tab2_summadop = selected.data().dognet_blankdocpost.kodblankwork;
						d.kodtipblank_tab2_summadop = selected.data().dognet_blankdocpost.kodtipblank;
						d.rowID_tab2_summadop = selected.id().substr(4);
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
					searchable: true,
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
					searchable: true,
					targets: 2
				},
				{
					orderable: false,
					searchable: true,
					targets: 3
				}
			],
			select: true,
			processing: false,
			paging: false,
			searching: false,
			buttons: [{
					extend: "create",
					editor: editor_blankview_edit_pos_summadop,
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
					editor: editor_blankview_edit_pos_summadop,
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
					editor: editor_blankview_edit_pos_summadop,
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
		table_blankview_edit_pos.on('select', function() {
			table_blankview_edit_pos_summadop.buttons().enable();
			table_blankview_edit_pos_summadop.ajax.reload();
			table_blankview_edit_pos_docfiles.buttons().disable();
			table_blankview_edit_pos_docfiles.ajax.reload();
			table_blankview_edit_pos_blankpril.buttons().enable();
			table_blankview_edit_pos_blankpril.ajax.reload();
		});
		table_blankview_edit_pos.on('deselect', function() {
			table_blankview_edit_pos_summadop.buttons().disable();
			table_blankview_edit_pos_summadop.ajax.reload();
			table_blankview_edit_pos_docfiles.buttons().disable();
			table_blankview_edit_pos_docfiles.ajax.reload();
			table_blankview_edit_pos_blankpril.buttons().disable();
			table_blankview_edit_pos_blankpril.ajax.reload();
		});
		table_blankview_edit_pos.on('init', function() {
			table_blankview_edit_pos_summadop.buttons().disable();
			table_blankview_edit_pos_docfiles.buttons().disable();
			table_blankview_edit_pos_blankpril.buttons().disable();
		});

	});
</script>
<?php
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
// Подключаем стили для форм и таблиц
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/blankview/blankview-edit/restr_5/tabs/css/blankview-edit-tab2_pos.css">
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/blankview/blankview-edit/restr_5/tabs/css/blankview-edit-tab2_summadop.css">
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/blankview/blankview-edit/restr_5/tabs/css/blankview-edit-tab2_doc_files.css">
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/blankview/blankview-edit/restr_5/tabs/css/blankview-edit-tab2_pril_files.css">
<?php
// ----- ----- ----- ----- -----
// Форма редактирования заявки/бланка
// :::
?>
<div id="customForm_newblank_pos">
	<div id="newblank-pos-tabs" style="width:100%">
		<ul id="newblank-pos-tabs-menu" class="nav nav-tabs space10">
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
				<div class="Block100">
					<div class="Block30 fieldset-table-row">
						<div class="fieldset-table-cell" style="padding-bottom:3px">
							<fieldset>
								<editor-field name="dognet_blankdocpost.kodblankcreate"></editor-field>
							</fieldset>
						</div>
						<div class="fieldset-table-cell" style="width:100%">
							<div>
								<div class="chekbox-inline-text">Этап 1. Новый бланк (версия ГИПа).</div>
							</div>
						</div>
					</div>
					<div class="Block35 fieldset-table-row">
						<div class="fieldset-table-cell" style="padding-bottom:3px">
							<fieldset>
								<editor-field name="dognet_blankdocpost.kodblankinprocess"></editor-field>
							</fieldset>
						</div>
						<div class="fieldset-table-cell" style="width:100%">
							<div>
								<div class="chekbox-inline-text">Этап 2. Рабочая копия (корректировка ДО).</div>
							</div>
						</div>
					</div>
					<div class="Block35 fieldset-table-row">
						<div class="fieldset-table-cell" style="padding-bottom:3px">
							<fieldset>
								<editor-field name="dognet_blankdocpost.kodblankdone"></editor-field>
							</fieldset>
						</div>
						<div class="fieldset-table-cell" style="width:100%">
							<div>
								<div class="chekbox-inline-text">Этап 3. Бланк оформлен, готовится договор.</div>
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
						<div id="tab2_useopl1usl" class="Block40" style="outline:1px dashed #ccc; outline-offset:-4px; padding:4px 8px">
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
						<div id="tab2_useopl2usl" class="Block60" style="outline:1px dashed #ccc; outline-offset:-4px; padding:4px 8px">
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
						<div id="tab2_useopl3usl" class="Block40" style="outline:1px dashed #ccc; outline-offset:-4px; padding:4px 8px">
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
						<div id="tab2_useopl4usl" class="Block60" style="outline:1px dashed #ccc; outline-offset:-4px; padding:4px 8px">
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
						<div id="tab2_useispoldoc1" class="Block50 fieldset-table-row" style="outline:1px dashed #ccc; outline-offset:-4px; padding:4px 8px">
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
						<div id="tab2_useispoldoc2" class="Block50 fieldset-table-row" style="outline:1px dashed #ccc; outline-offset:-4px; padding:4px 8px">
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
						<div id="tab2_useispoldoc3" class="Block50 fieldset-table-row" style="outline:1px dashed #ccc; outline-offset:-4px; padding:4px 8px">
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
						<div id="tab2_useispoldoc4" class="Block50 fieldset-table-row" style="outline:1px dashed #ccc; outline-offset:-4px; padding:4px 8px">
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
						<fieldset class="field100">
							<editor-field name="dognet_blankdocpost.defuslgiptext"></editor-field>
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
// Форма добавления файла
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
// ----- ----- ----- ----- -----
// Форма добавления файла для печати
// :::
?>
<div id="customForm_docblankfiles_pos">
	<div class="Section">
		<div class="Block100">
			<legend>Подсказки и помощь</legend>
		</div>
		<div class="Block100">
			<legend>Файл</legend>
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
	<table id="blankview-edit-pos-table" class="table table-bordered table-condensed display compact" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
				<th width="" class="">Статус</th>
				<th width="" class="">ID бланка</th>
				<th width="" class="">ГИП</th>
				<th width="" class="">Исполнитель ( рук )</th>
				<th width="" class="">Организация</th>
				<th width="" class="">Описание</th>
				<th width="" class=""></th>
				<th width="" class=""><span class="glyphicon glyphicon-list-alt"></span></th>
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
		<div id="blankview-edit-pos-summadop">
			<h3 class="space10">Разбиение суммы договора</h3>
			<div class="demo-html"></div>
			<table id="blankview-edit-pos-summadop-table" class="table table-striped" cellspacing="0" width="100%">
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
		<div id="blankview-edit-pos-docfiles">
			<h3 class="space10">Файлы бланков для печати</h3>
			<div class="demo-html"></div>
			<table id="blankview-edit-pos-docfiles-table" class="table table-striped" cellspacing="0" width="100%">
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
		<div id="blankview-edit-pos-blankpril">
			<h3 class="space10">Прикрепленные к бланку файлы</h3>
			<div class="demo-html"></div>
			<table id="blankview-edit-pos-blankpril-table" class="table table-striped" cellspacing="0" width="100%">
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
</section>