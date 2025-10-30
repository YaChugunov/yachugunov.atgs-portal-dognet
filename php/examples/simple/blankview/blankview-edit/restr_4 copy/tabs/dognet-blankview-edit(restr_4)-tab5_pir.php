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
		var editor_blankview_edit_pir = new $.fn.dataTable.Editor({
			display: "bootstrap",
			ajax: {
				url: "php/examples/php/blankview/blankview-edit/dognet-blankview-edit-pir-process.php",
				data: function(d) {
					var selected = table_blankview_edit_pir.row({
						selected: true
					});
					if (selected.any()) {
						d.kodblankwork_tab5 = selected.data().dognet_blankdocpir.kodblankwork;
						d.kodblankpir_tab5 = selected.data().dognet_blankdocpir.kodblankpir;
						d.kodstatusblank_tab5 = selected.data().dognet_blankdocpir.kodtipblank;
						d.parentid_tab5 = selected.id().substr(4);
					}
				}
			},
			table: "#blankview-edit-pir-table",
			i18n: {
				create: {
					title: "<h3>Создать новую заявку/бланк на договор ПИР</h3>"
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
			template: '#customForm_newblank_pir',
			fields: [{
				label: "Исполнитель (рук) :",
				name: "dognet_blankdocpir.kodispolruk",
				type: "select",
				def: "---",
				placeholder: "Выберите исполнителя"
			}, {
				label: "Исполнитель (ГИП) :",
				name: "dognet_blankdocpir.kodispol",
				type: "select",
				def: "---",
				placeholder: "Выберите ГИП"
			}, {
				label: "Организация (справочник) :",
				name: "dognet_blankdocpir.kodzakaz",
				type: "select",
				def: "---",
				placeholder: "Выберите заказчика"
			}, {
				label: "Название договора :",
				name: "dognet_blankdocpir.namedocblank"
			}, {
				label: "Как заказчик",
				type: "checkbox",
				name: "dognet_blankdocpir.kodorgzakaz",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "Как исполнитель",
				type: "checkbox",
				name: "dognet_blankdocpir.kodorgispol",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "Новая организация",
				type: "checkbox",
				name: "dognet_blankdocpir.koduseneworg",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "Справочник",
				type: "checkbox",
				name: "dognet_blankdocpir.kodusespzakaz",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "Название организации :",
				name: "dognet_blankdocpir.nameneworg",
				fieldInfo: ""
			}, {
				label: "Сумма договора :",
				name: "dognet_blankdocpir.csummadocopl"
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpir.kodusendsopl",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpir.kodusespechopl",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "Вариант 1",
				type: "checkbox",
				name: "dognet_blankdocpir.koduseopl1usl",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "Вариант 2",
				type: "checkbox",
				name: "dognet_blankdocpir.koduseopl2usl",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "Вариант 3",
				type: "checkbox",
				name: "dognet_blankdocpir.koduseopl3usl",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "Вариант 4",
				type: "checkbox",
				name: "dognet_blankdocpir.koduseopl4usl",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "Сумма аванса :",
				name: "dognet_blankdocpir.csummaopl1usl",
				fieldInfo: "( X процентов )"
			}, {
				label: "Сумма оплаты :",
				name: "dognet_blankdocpir.csummaopl2usl",
				fieldInfo: "( X процентов )"
			}, {
				label: "В течение :",
				name: "dognet_blankdocpir.cnumberoplday2usl",
				fieldInfo: "( N дней )"
			}, {
				label: "В течение :",
				name: "dognet_blankdocpir.cnumberoplday3usl",
				fieldInfo: "( N дней )"
			}, {
				label: "Иные условия :",
				name: "dognet_blankdocpir.ctextoplotherusl",
				type: "textarea"
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpir.kodusepril1",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpir.kodusepril2",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpir.kodusepril3",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpir.kodusepril4",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpir.kodusepril5",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "Особые условия договора :",
				name: "dognet_blankdocpir.defuslgiptext",
				type: "textarea",
				fieldInfo: ""
			}, {
				label: "По итогам выигранного тендера",
				type: "checkbox",
				name: "dognet_blankdocpir.kodusetender",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpir.koduseispoldoc1",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpir.koduseispoldoc3",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				name: "dognet_blankdocpir.cdateispoldoc1",
				attr: {
					placeholder: 'ДД/ММ/ГГГГ'
				},
				fieldInfo: ""
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpir.kodusekomrasx1",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpir.kodusekomrasx2",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpir.kodusekomrasx3",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpir.kodusekomrasx4",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				name: "dognet_blankdocpir.summalimitmis",
				fieldInfo: ""
			}, {
				label: "",
				name: "dognet_blankdocpir.komrasxprim",
				attr: {
					placeholder: ''
				},
				fieldInfo: ""
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpir.kodusetrans1",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpir.kodusetrans2",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpir.kodusetrans3",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				name: "dognet_blankdocpir.transprim",
				attr: {
					placeholder: ''
				},
				fieldInfo: ""
			}, {
				label: "Куда поставляется обрудование :",
				name: "dognet_blankdocpir.transplaceobor",
				type: "textarea",
				attr: {
					placeholder: ''
				},
				fieldInfo: ""
			}, {
				label: "",
				name: "dognet_blankdocpir.climitdays",
				attr: {
					placeholder: ''
				},
				fieldInfo: ""
			}, {
				label: "",
				name: "dognet_blankdocpir.numberdocmain",
				attr: {
					placeholder: ''
				},
				fieldInfo: ""
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpir.koduserisk1",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpir.koduserisk2",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpir.koduserisk3",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpir.koduserisk4",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpir.koduserisk5",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpir.koduserisk6",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				name: "dognet_blankdocpir.riskprim",
				attr: {
					placeholder: ''
				},
				fieldInfo: ""
			}, {
				label: "",
				name: "dognet_blankdocpir.nameendcontact",
				attr: {
					placeholder: ''
				},
				fieldInfo: ""
			}, {
				label: "",
				name: "dognet_blankdocpir.namefistcontact",
				attr: {
					placeholder: ''
				},
				fieldInfo: ""
			}, {
				label: "",
				name: "dognet_blankdocpir.namesecondcontact",
				attr: {
					placeholder: ''
				},
				fieldInfo: ""
			}, {
				label: "",
				name: "dognet_blankdocpir.namedoljcontact",
				attr: {
					placeholder: ''
				},
				fieldInfo: ""
			}, {
				label: "",
				name: "dognet_blankdocpir.nameemail",
				attr: {
					placeholder: ''
				},
				fieldInfo: ""
			}, {
				label: "",
				name: "dognet_blankdocpir.numbertelrab",
				attr: {
					placeholder: ''
				},
				fieldInfo: ""
			}, {
				label: "",
				name: "dognet_blankdocpir.numbertelmob",
				attr: {
					placeholder: ''
				},
				fieldInfo: ""
			}, {
				label: "",
				name: "dognet_blankdocpir.numbertelfax",
				attr: {
					placeholder: ''
				},
				fieldInfo: ""
			}, {
				label: "",
				name: "dognet_blankdocpir.dopcontact1",
				attr: {
					placeholder: ''
				},
				fieldInfo: ""
			}, {
				label: "",
				name: "dognet_blankdocpir.dopcontact2",
				attr: {
					placeholder: ''
				},
				fieldInfo: ""
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpir.kodblankcreate",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpir.kodblankinprocess",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				type: "checkbox",
				name: "dognet_blankdocpir.kodblankdone",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
				name: "dognet_blankdocpir.kodtipblank"
			}, {
				label: "",
				name: "dognet_blankdocpir.kodblankwork"
			}, {
				label: "",
				name: "dognet_blankdocpir.kodblankpir"
			}]
		});
		//
		//
		// Изменяем размер диалогового окна редактирования договора субподряда
		editor_blankview_edit_pir.on('open', function() {
			$(".modal-dialog").css({
				"width": "95%",
				"margin": "1.0em auto",
				"min-width": "800px",
				"max-width": "1170px"
			});
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		var openVals_pir;
		editor_blankview_edit_pir.on('open', function() {
			$('#kodzakaz_filter_pir').val('');
			if (($('#DTE_Field_dognet_blankdocpir-kodzakaz').value) != editor_blankview_edit_pir.field('dognet_blankdocpir.kodzakaz').get()) {}
			// Поиск в ниспадающем списке по содержимому текстового поля для ответного документа
			$('#DTE_Field_dognet_blankdocpir-kodzakaz').filterByText(editor_blankview_edit_pir, $('#kodzakaz_filter_pir'), 'dognet_blankdocpir.kodzakaz', false);
		});
		// ----- ----- ----- ----- -----
		editor_blankview_edit_pir.on('preSubmit', function(e) {
			var jsondata = JSON.stringify(editor_blankview_edit_pir.get());
			/* 		var jsondata = JSON.editor_blankview_edit_pir.get(); */
			var parsejson = JSON.parse(jsondata);
			if ((parsejson['dognet_blankdocpir.koduseopl1usl'] == 0) && (parsejson['dognet_blankdocpir.koduseopl2usl'] == 0) && (parsejson['dognet_blankdocpir.koduseopl3usl'] == 0) && (parsejson['dognet_blankdocpir.koduseopl4usl'] == 0)) {
				return confirm('Вы не определили порядок оплаты! Уверены, что хотите создать бланк?');
			}

		});
		// ----- ----- ----- ----- -----
		editor_blankview_edit_pir.on('postSubmit', function(e) {
			table_blankview_edit_pir.rows().deselect();
			table_blankview_edit_pir.ajax.reload();
		});
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
		editor_blankview_edit_pir.dependent('dognet_blankdocpir.kodusespzakaz', function(val) {
			if (val == 0) {
				editor_blankview_edit_pir.field('dognet_blankdocpir.koduseneworg').enable();
				editor_blankview_edit_pir.field('dognet_blankdocpir.kodzakaz').disable();
				$('#kodzakaz_filter_pir').prop('disabled', true);
			} else {
				editor_blankview_edit_pir.field('dognet_blankdocpir.kodzakaz').enable();
				editor_blankview_edit_pir.field('dognet_blankdocpir.koduseneworg').disable();
				$('#kodzakaz_filter_pir').prop('disabled', false);
			}
		});
		editor_blankview_edit_pir.dependent('dognet_blankdocpir.koduseneworg', function(val) {
			if (val == 0) {
				editor_blankview_edit_pir.field('dognet_blankdocpir.nameneworg').disable();
				editor_blankview_edit_pir.field('dognet_blankdocpir.kodusespzakaz').enable();
			} else {
				editor_blankview_edit_pir.field('dognet_blankdocpir.nameneworg').enable();
				editor_blankview_edit_pir.field('dognet_blankdocpir.kodusespzakaz').disable();
			}
		});
		//
		//
		//
		// TAB 4
		editor_blankview_edit_pir.dependent('dognet_blankdocpir.koduseispoldoc1', function(val) {
			if (val == 1) {
				editor_blankview_edit_pir.field('dognet_blankdocpir.cdateispoldoc1').enable();
				editor_blankview_edit_pir.field('dognet_blankdocpir.koduseispoldoc3').disable();
				$("#tab5_useispoldoc1").css('outline-color', '#019401');
			} else {
				editor_blankview_edit_pir.field('dognet_blankdocpir.cdateispoldoc1').disable();
				editor_blankview_edit_pir.field('dognet_blankdocpir.koduseispoldoc3').enable();
				$("#tab5_useispoldoc1").css('outline-color', '#ccc');
			}
		});
		editor_blankview_edit_pir.dependent('dognet_blankdocpir.koduseispoldoc3', function(val) {
			if (val == 1) {
				editor_blankview_edit_pir.field('dognet_blankdocpir.koduseispoldoc1').disable();
				$("#tab5_useispoldoc3").css('outline-color', '#019401');
			} else {
				editor_blankview_edit_pir.field('dognet_blankdocpir.koduseispoldoc1').enable();
				$("#tab5_useispoldoc3").css('outline-color', '#ccc');
			}
		});
		//
		//
		//
		// TAB 5
		editor_blankview_edit_pir.dependent('dognet_blankdocpir.kodusekomrasx1', function(val) {
			if (val == 1) {
				editor_blankview_edit_pir.field('dognet_blankdocpir.kodusekomrasx2').disable();
				editor_blankview_edit_pir.field('dognet_blankdocpir.kodusekomrasx3').disable();
				editor_blankview_edit_pir.field('dognet_blankdocpir.kodusekomrasx4').disable();
			} else {
				editor_blankview_edit_pir.field('dognet_blankdocpir.kodusekomrasx2').enable();
				editor_blankview_edit_pir.field('dognet_blankdocpir.kodusekomrasx3').enable();
				editor_blankview_edit_pir.field('dognet_blankdocpir.kodusekomrasx4').enable();
			}
		});
		editor_blankview_edit_pir.dependent('dognet_blankdocpir.kodusekomrasx2', function(val) {
			if (val == 1) {
				editor_blankview_edit_pir.field('dognet_blankdocpir.kodusekomrasx1').disable();
				editor_blankview_edit_pir.field('dognet_blankdocpir.kodusekomrasx3').disable();
				editor_blankview_edit_pir.field('dognet_blankdocpir.kodusekomrasx4').disable();
			} else {
				editor_blankview_edit_pir.field('dognet_blankdocpir.kodusekomrasx1').enable();
				editor_blankview_edit_pir.field('dognet_blankdocpir.kodusekomrasx3').enable();
				editor_blankview_edit_pir.field('dognet_blankdocpir.kodusekomrasx4').enable();
			}
		});
		editor_blankview_edit_pir.dependent('dognet_blankdocpir.kodusekomrasx3', function(val) {
			if (val == 1) {
				editor_blankview_edit_pir.field('dognet_blankdocpir.kodusekomrasx1').disable();
				editor_blankview_edit_pir.field('dognet_blankdocpir.kodusekomrasx2').disable();
				editor_blankview_edit_pir.field('dognet_blankdocpir.kodusekomrasx4').disable();
			} else {
				editor_blankview_edit_pir.field('dognet_blankdocpir.kodusekomrasx1').enable();
				editor_blankview_edit_pir.field('dognet_blankdocpir.kodusekomrasx2').enable();
				editor_blankview_edit_pir.field('dognet_blankdocpir.kodusekomrasx4').enable();
			}
		});
		editor_blankview_edit_pir.dependent('dognet_blankdocpir.kodusekomrasx4', function(val) {
			if (val == 1) {
				editor_blankview_edit_pir.field('dognet_blankdocpir.kodusekomrasx1').disable();
				editor_blankview_edit_pir.field('dognet_blankdocpir.kodusekomrasx3').disable();
				editor_blankview_edit_pir.field('dognet_blankdocpir.kodusekomrasx2').disable();
			} else {
				editor_blankview_edit_pir.field('dognet_blankdocpir.kodusekomrasx1').enable();
				editor_blankview_edit_pir.field('dognet_blankdocpir.kodusekomrasx3').enable();
				editor_blankview_edit_pir.field('dognet_blankdocpir.kodusekomrasx2').enable();
			}
		});
		//
		editor_blankview_edit_pir.dependent('dognet_blankdocpir.kodusekomrasx3', function(val) {
			if (val == 0) {
				editor_blankview_edit_pir.field('dognet_blankdocpir.summalimitmis').disable();
			} else {
				editor_blankview_edit_pir.field('dognet_blankdocpir.summalimitmis').enable();
			}
		});
		editor_blankview_edit_pir.dependent('dognet_blankdocpir.kodusekomrasx4', function(val) {
			if (val == 0) {
				editor_blankview_edit_pir.field('dognet_blankdocpir.komrasxprim').disable();
			} else {
				editor_blankview_edit_pir.field('dognet_blankdocpir.komrasxprim').enable();
			}
		});
		//
		//
		//
		// TAB 6
		editor_blankview_edit_pir.dependent('dognet_blankdocpir.kodusetrans1', function(val) {
			if (val == 1) {
				editor_blankview_edit_pir.field('dognet_blankdocpir.kodusetrans2').disable();
				editor_blankview_edit_pir.field('dognet_blankdocpir.kodusetrans3').disable();
			} else {
				editor_blankview_edit_pir.field('dognet_blankdocpir.kodusetrans2').enable();
				editor_blankview_edit_pir.field('dognet_blankdocpir.kodusetrans3').enable();
			}
		});
		editor_blankview_edit_pir.dependent('dognet_blankdocpir.kodusetrans2', function(val) {
			if (val == 1) {
				editor_blankview_edit_pir.field('dognet_blankdocpir.kodusetrans1').disable();
				editor_blankview_edit_pir.field('dognet_blankdocpir.kodusetrans3').disable();
			} else {
				editor_blankview_edit_pir.field('dognet_blankdocpir.kodusetrans1').enable();
				editor_blankview_edit_pir.field('dognet_blankdocpir.kodusetrans3').enable();
			}
		});
		editor_blankview_edit_pir.dependent('dognet_blankdocpir.kodusetrans3', function(val) {
			if (val == 1) {
				editor_blankview_edit_pir.field('dognet_blankdocpir.kodusetrans1').disable();
				editor_blankview_edit_pir.field('dognet_blankdocpir.kodusetrans2').disable();
			} else {
				editor_blankview_edit_pir.field('dognet_blankdocpir.kodusetrans1').enable();
				editor_blankview_edit_pir.field('dognet_blankdocpir.kodusetrans2').enable();
			}
		});
		//
		editor_blankview_edit_pir.dependent('dognet_blankdocpir.kodusetrans3', function(val) {
			if (val == 0) {
				editor_blankview_edit_pir.field('dognet_blankdocpir.transprim').disable();
			} else {
				editor_blankview_edit_pir.field('dognet_blankdocpir.transprim').enable();
			}
		});
		//
		//
		// TAB 2
		editor_blankview_edit_pir.dependent('dognet_blankdocpir.koduseopl1usl', function(val) {
			if (val == 1) {
				editor_blankview_edit_pir.field('dognet_blankdocpir.koduseopl2usl').disable();
				editor_blankview_edit_pir.field('dognet_blankdocpir.koduseopl3usl').disable();
				editor_blankview_edit_pir.field('dognet_blankdocpir.koduseopl4usl').disable();
				$("#tab5_useopl1usl").css('outline-color', '#019401');
			} else {
				editor_blankview_edit_pir.field('dognet_blankdocpir.koduseopl2usl').enable();
				editor_blankview_edit_pir.field('dognet_blankdocpir.koduseopl3usl').enable();
				editor_blankview_edit_pir.field('dognet_blankdocpir.koduseopl4usl').enable();
				$("#tab5_useopl1usl").css('outline-color', '#ccc');
			}
		});
		editor_blankview_edit_pir.dependent('dognet_blankdocpir.koduseopl2usl', function(val) {
			if (val == 1) {
				editor_blankview_edit_pir.field('dognet_blankdocpir.koduseopl1usl').disable();
				editor_blankview_edit_pir.field('dognet_blankdocpir.koduseopl3usl').disable();
				editor_blankview_edit_pir.field('dognet_blankdocpir.koduseopl4usl').disable();
				$("#tab5_useopl2usl").css('outline-color', '#019401');
			} else {
				editor_blankview_edit_pir.field('dognet_blankdocpir.koduseopl1usl').enable();
				editor_blankview_edit_pir.field('dognet_blankdocpir.koduseopl3usl').enable();
				editor_blankview_edit_pir.field('dognet_blankdocpir.koduseopl4usl').enable();
				$("#tab5_useopl2usl").css('outline-color', '#ccc');
			}
		});
		editor_blankview_edit_pir.dependent('dognet_blankdocpir.koduseopl3usl', function(val) {
			if (val == 1) {
				editor_blankview_edit_pir.field('dognet_blankdocpir.koduseopl1usl').disable();
				editor_blankview_edit_pir.field('dognet_blankdocpir.koduseopl2usl').disable();
				editor_blankview_edit_pir.field('dognet_blankdocpir.koduseopl4usl').disable();
				$("#tab5_useopl3usl").css('outline-color', '#019401');
			} else {
				editor_blankview_edit_pir.field('dognet_blankdocpir.koduseopl1usl').enable();
				editor_blankview_edit_pir.field('dognet_blankdocpir.koduseopl2usl').enable();
				editor_blankview_edit_pir.field('dognet_blankdocpir.koduseopl4usl').enable();
				$("#tab5_useopl3usl").css('outline-color', '#ccc');
			}
		});
		editor_blankview_edit_pir.dependent('dognet_blankdocpir.koduseopl4usl', function(val) {
			if (val == 1) {
				editor_blankview_edit_pir.field('dognet_blankdocpir.koduseopl1usl').disable();
				editor_blankview_edit_pir.field('dognet_blankdocpir.koduseopl2usl').disable();
				editor_blankview_edit_pir.field('dognet_blankdocpir.koduseopl3usl').disable();
				$("#tab5_useopl4usl").css('outline-color', '#019401');
			} else {
				editor_blankview_edit_pir.field('dognet_blankdocpir.koduseopl1usl').enable();
				editor_blankview_edit_pir.field('dognet_blankdocpir.koduseopl2usl').enable();
				editor_blankview_edit_pir.field('dognet_blankdocpir.koduseopl3usl').enable();
				$("#tab5_useopl4usl").css('outline-color', '#ccc');
			}
		});
		//
		editor_blankview_edit_pir.dependent('dognet_blankdocpir.koduseopl1usl', function(val) {
			if (val == 0) {
				editor_blankview_edit_pir.field('dognet_blankdocpir.csummaopl1usl').disable();
			} else {
				editor_blankview_edit_pir.field('dognet_blankdocpir.csummaopl1usl').enable();
			}
		});
		editor_blankview_edit_pir.dependent('dognet_blankdocpir.koduseopl2usl', function(val) {
			if (val == 0) {
				editor_blankview_edit_pir.field('dognet_blankdocpir.csummaopl2usl').disable();
				editor_blankview_edit_pir.field('dognet_blankdocpir.cnumberoplday2usl').disable();
			} else {
				editor_blankview_edit_pir.field('dognet_blankdocpir.csummaopl2usl').enable();
				editor_blankview_edit_pir.field('dognet_blankdocpir.cnumberoplday2usl').enable();
			}
		});
		editor_blankview_edit_pir.dependent('dognet_blankdocpir.koduseopl3usl', function(val) {
			if (val == 0) {
				editor_blankview_edit_pir.field('dognet_blankdocpir.cnumberoplday3usl').disable();
			} else {
				editor_blankview_edit_pir.field('dognet_blankdocpir.cnumberoplday3usl').enable();
			}
		});
		editor_blankview_edit_pir.dependent('dognet_blankdocpir.koduseopl4usl', function(val) {
			if (val == 0) {
				editor_blankview_edit_pir.field('dognet_blankdocpir.ctextoplotherusl').disable();
			} else {
				editor_blankview_edit_pir.field('dognet_blankdocpir.ctextoplotherusl').enable();
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
		// БЛАНК ЗАЯВКИ ГИПА НА ПИР ::: Таблица данных
		var table_blankview_edit_pir = $('#blankview-edit-pir-table').DataTable({
			dom: "<'row'<'col-sm-5'B><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'p>>",
			// 		dom: "<'space50'r>tip",
			language: {
				url: "php/examples/simple/blankview/blankview-edit/dt_russian-tab5_pir.json"
			},
			ajax: {
				url: "php/examples/php/blankview/blankview-edit/dognet-blankview-edit-pir-process.php",
				type: "POST"
			},
			serverSide: true,
			columns: [{
					class: "details-control-docblank-pir",
					searchable: false,
					orderable: false,
					data: null,
					defaultContent: "<span class='glyphicon glyphicon-option-vertical'></span>"
				},
				{
					data: "dognet_blankdocpir.kodpaperstr",
					className: ""
				},
				{
					data: "dognet_blankdocpir.kodblankpir",
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
					data: "dognet_blankdocpir.namedocblank",
					className: ""
				},
				{
					data: "dognet_blankdocpir.kodtipblank",
					className: ""
				},
				{
					class: "details-control-blankwork-pir",
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
						if (row.dognet_docblankwork.kodtipblank === "PIR") {
							var tipblank = row.dognet_blankdocpir.kodtipblank;
							var inprocess = row.dognet_blankdocpir.kodblankinprocess;
							var blankdone = row.dognet_blankdocpir.kodblankdone;
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
							if (row.dognet_blankdocpir.koduseneworg == 1 && row.dognet_blankdocpir.nameneworg != "") {
								return row.dognet_blankdocpir.nameneworg;
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
						table_blankview_edit_pir.columns().search('');
						table_blankview_edit_pir.draw();
						table_blankview_edit_pir_summadop.ajax.reload();
						table_blankview_edit_pir_docfiles.ajax.reload();
						table_blankview_edit_pir_blankpril.ajax.reload();
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

						editor_blankview_edit_pir.on('preOpen', function(e) {
							editor_blankview_edit_pir.field('dognet_blankdocpir.kodblankcreate').disable();
							editor_blankview_edit_pir.field('dognet_blankdocpir.kodblankinprocess').set(1);
							editor_blankview_edit_pir.field('dognet_blankdocpir.kodblankinprocess').disable();
							editor_blankview_edit_pir.field('dognet_blankdocpir.kodblankdone').set(0);
						});

						// Start in edit mode, and then change to create
						editor_blankview_edit_pir
							.edit(table_blankview_edit_pir.rows({
								selected: true
							}).indexes(), {
								title: '<h3>Работать с бланком на ПИР</h3>',
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
				dataSrc: ["dognet_blankdocpir.kodtipblank"]
			},
			createdRow: function(row, data, index) {
				if (data.dognet_blankdocpir.kodtipblank === "CR") {
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
		var detailRows_docblank_pir = [];
		$('#blankview-edit-pir-table tbody').on('click', 'tr td.details-control-docblank-pir', function() {
			var tr = $(this).closest('tr');
			var row = table_blankview_edit_pir.row(tr);
			var idx = $.inArray(tr.attr('id'), detailRows_docblank_pir);

			if (row.child.isShown()) {
				tr.removeClass('edit');
				row.child.hide();

				// Remove from the 'open' array
				detailRows_docblank_pir.splice(idx, 1);
			} else {
				tr.addClass('edit');
				rowData = table_blankview_edit_pir.row(row);
				d = row.data();
				rowData.child(<?php include('templates/blankview-edit-tab5-blankwork-doc-table.tpl'); ?>).show();

				// Add to the 'open' array
				if (idx === -1) {
					detailRows_docblank_pir.push(tr.attr('id'));
				}
			}
		});
		// ----- ----- ----- ----- -----
		// On each draw, loop over the `detailRows_docblank_pir` array and show any child rows
		table_blankview_edit_pir.on('draw', function() {
			$.each(detailRows_docblank_pir, function(i, id) {
				$('#' + id + ' td.details-control-docblank-pir').trigger('click');
			});
		});
		// ----- ----- ----- ----- -----
		// Array to track the ids of the edit displayed rows
		var detailRows_blankwork_pir = [];
		$('#blankview-edit-pir-table tbody').on('click', 'tr td.details-control-blankwork-pir', function() {
			var tr = $(this).closest('tr');
			var row = table_blankview_edit_pir.row(tr);
			var idx = $.inArray(tr.attr('id'), detailRows_blankwork_pir);

			if (row.child.isShown()) {
				tr.removeClass('edit');
				row.child.hide();

				// Remove from the 'open' array
				detailRows_blankwork_pir.splice(idx, 1);
			} else {
				tr.addClass('edit');
				rowData = table_blankview_edit_pir.row(row);
				d = row.data();
				rowData.child(<?php include('templates/blankview-edit-tab5-blankwork-pir-table.tpl'); ?>).show();

				// Add to the 'open' array
				if (idx === -1) {
					detailRows_blankwork_pir.push(tr.attr('id'));
				}
			}
		});
		// ----- ----- ----- ----- -----
		// On each draw, loop over the `detailRows_docblank_pir` array and show any child rows
		table_blankview_edit_pir.on('draw', function() {
			$.each(detailRows_blankwork_pir, function(i, id) {
				$('#' + id + ' td.details-control-blankwork-pir').trigger('click');
			});

			// Выводим уведомление (цифру) о новых заявках на договор
			cnt_pir = table_blankview_edit_pir.data().count();
			console.log("table_blankview_edit_pir.count() : " + cnt_pir);
			if (cnt_pir > 0) {
				document.getElementById("pir_newitems_cnt").innerHTML = cnt_pir;
			}
			//

		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		//
		// Не позволяем выделять бланки в стадии оформления
		table_blankview_edit_pir.on('user-select', function(e, dt, type, cell, originalEvent) {
			var row = dt.row(cell.index().row);
			if (((row.data().dognet_blankdocpir.kodtipblank == "CR") && (row.data().dognet_blankdocpir.kodblankinprocess == 1))) {
				e.preventDefault();
			}
			if (((row.data().dognet_blankdocpir.kodtipblank == "RD") && (row.data().dognet_blankdocpir.kodblankdone == 1))) {
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
		var editor_blankview_edit_pir_docfiles = new $.fn.dataTable.Editor({
			display: "bootstrap",
			ajax: "php/examples/php/blankview/blankview-edit/dognet-blankview-edit-pir-docfiles-process.php",
			table: "#blankview-edit-pir-docfiles-table",
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
			template: '#customForm_docblankfiles_pir',
			fields: []
		});
		//
		//
		// Изменяем размер диалогового окна редактирования договора субподряда
		editor_blankview_edit_pir_docfiles.on('open', function() {
			$(".modal-dialog").css({
				"width": "30%",
				"margin": "0em 70%",
				"min-width": "360px",
				"max-width": "480px"
			});
		});
		// ----- ----- -----
		// БЛАНКИ ДЛЯ ПЕЧАТИ ::: Таблица данных
		var table_blankview_edit_pir_docfiles = $('#blankview-edit-pir-docfiles-table').DataTable({
			dom: "<'row'<'col-sm-5'B><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'><'col-sm-8'>>",
			// 		dom: "<'space50'r>tip",
			language: {
				url: "php/examples/simple/blankview/blankview-edit/dt_russian-tab5_pir-docfiles.json"
			},
			ajax: {
				url: "php/examples/php/blankview/blankview-edit/dognet-blankview-edit-pir-docfiles-process.php",
				type: 'post',
				data: function(d) {
					var selected = table_blankview_edit_pir.row({
						selected: true
					});
					if (selected.any()) {
						d.kodblankwork_tab5_docfiles = selected.data().dognet_blankdocpir.kodblankwork;
						console.log("Kodblankwork (" + selected.id() + ") :: kodblankwork: " + d.kodblankwork_tab5_docfiles);
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
					editor: editor_blankview_edit_pir_docfiles,
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
					editor: editor_blankview_edit_pir_docfiles,
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
		var editor_blankview_edit_pir_blankpril = new $.fn.dataTable.Editor({
			display: "bootstrap",
			ajax: {
				url: "php/examples/php/blankview/blankview-edit/dognet-blankview-edit-pir-blankpril-process.php",
				data: function(d) {
					var selected = table_blankview_edit_pir.row({
						selected: true
					});
					if (selected.any()) {
						d.kodblankwork_tab5_blankpril = selected.data().dognet_blankdocpir.kodblankwork;
					}
				}
			},
			table: "#blankview-edit-pir-blankpril-table",
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
			template: '#customForm_blankworkpril_pir',
			fields: [{
				name: "dognet_blankworkpril.docFileID",
				type: "upload",
				display: function(id) {
					return '<h4><a target="_blank" href="' + editor_blankview_edit_pir_blankpril.file('dognet_blankworkpril_files', id).file_webpath + '"><span class="glyphicon glyphicon-eye-open"></span></a></h4>';
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
		editor_blankview_edit_pir_blankpril.on('open', function() {
			$(".modal-dialog").css({
				"width": "30%",
				"margin": "0em 70%",
				"min-width": "360px",
				"max-width": "480px"
			});
		});
		// ----- ----- -----
		editor_blankview_edit_pir_blankpril.on('initCreate', function(e) {
			editor_blankview_edit_pir_blankpril.field('dognet_blankworkpril.msgDocFileID').show();
			editor_blankview_edit_pir_blankpril.field('dognet_blankworkpril.msgDocFileID').val('Сначала создайте запись!');
			editor_blankview_edit_pir_blankpril.field('dognet_blankworkpril.docFileID').hide();
			editor_blankview_edit_pir_blankpril.field('dognet_blankworkpril.docFileID').disable();
		});
		//
		editor_blankview_edit_pir_blankpril.on('initEdit', function(e, node, data, items, type) {
			editor_blankview_edit_pir_blankpril.field('dognet_blankworkpril.msgDocFileID').hide();
			editor_blankview_edit_pir_blankpril.field('dognet_blankworkpril.docFileID').show();
			editor_blankview_edit_pir_blankpril.field('dognet_blankworkpril.docFileID').enable();
		});
		//
		// ----- ----- -----
		// ПРИКРЕПЛЯЕМЫЕ ФАЙЛЫ К БЛАНКУ ::: Таблица данных
		var table_blankview_edit_pir_blankpril = $('#blankview-edit-pir-blankpril-table').DataTable({
			dom: "<'row'<'col-sm-5'B><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'><'col-sm-8'>>",
			// 		dom: "<'space50'r>tip",
			language: {
				url: "php/examples/simple/blankview/blankview-edit/dt_russian-tab5_pir-prilfiles.json"
			},
			ajax: {
				url: "php/examples/php/blankview/blankview-edit/dognet-blankview-edit-pir-blankpril-process.php",
				type: 'post',
				data: function(d) {
					var selected = table_blankview_edit_pir.row({
						selected: true
					});
					if (selected.any()) {
						d.kodblankwork_tab5_blankpril = selected.data().dognet_blankdocpir.kodblankwork;
						console.log("Kodblankwork (" + selected.id() + ") :: kodblankwork: " + d.kodblankwork_tab5_blankpril);
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
					editor: editor_blankview_edit_pir_blankpril,
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
					editor: editor_blankview_edit_pir_blankpril,
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
					editor: editor_blankview_edit_pir_blankpril,
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
		var editor_blankview_edit_pir_summadop = new $.fn.dataTable.Editor({
			display: "bootstrap",
			ajax: {
				url: "php/examples/php/blankview/blankview-edit/dognet-blankview-edit-pir-summadop-process.php",
				data: function(d) {
					var selected = table_blankview_edit_pir.row({
						selected: true
					});
					if (selected.any()) {
						d.kodblankwork_tab5_summadop = selected.data().dognet_blankdocpir.kodblankwork;
						d.kodtipblank_tab5_summadop = selected.data().dognet_blankdocpir.kodtipblank;
						d.rowID_tab5_summadop = selected.id().substr(4);
					}
				}
			},
			table: "#blankview-edit-pir-summadop-table",
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
			template: '#customForm_blanksummadop_pir',
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
		editor_blankview_edit_pir_summadop.on('open', function() {
			$(".modal-dialog").css({
				"width": "60%",
				"margin": "1.0em auto",
				"min-width": "640px",
				"max-width": "800px"
			});
		});
		// ----- ----- ----- ----- -----
		// ПРИКРЕПЛЯЕМЫЕ ФАЙЛЫ К БЛАНКУ ::: Таблица данных
		var table_blankview_edit_pir_summadop = $('#blankview-edit-pir-summadop-table').DataTable({
			dom: "<'row'<'col-sm-5'B><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'><'col-sm-8'>>",
			// 		dom: "<'space50'r>tip",
			language: {
				url: "php/examples/simple/blankview/blankview-edit/dt_russian-tab5_pir-summadop.json"
			},
			ajax: {
				url: "php/examples/php/blankview/blankview-edit/dognet-blankview-edit-pir-summadop-process.php",
				type: 'post',
				data: function(d) {
					var selected = table_blankview_edit_pir.row({
						selected: true
					});
					if (selected.any()) {
						d.kodblankwork_tab5_summadop = selected.data().dognet_blankdocpir.kodblankwork;
						d.kodtipblank_tab5_summadop = selected.data().dognet_blankdocpir.kodtipblank;
						d.rowID_tab5_summadop = selected.id().substr(4);
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
					editor: editor_blankview_edit_pir_summadop,
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
					editor: editor_blankview_edit_pir_summadop,
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
					editor: editor_blankview_edit_pir_summadop,
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
		table_blankview_edit_pir.on('select', function() {
			table_blankview_edit_pir_summadop.buttons().enable();
			table_blankview_edit_pir_summadop.ajax.reload();
			table_blankview_edit_pir_docfiles.buttons().disable();
			table_blankview_edit_pir_docfiles.ajax.reload();
			table_blankview_edit_pir_blankpril.buttons().enable();
			table_blankview_edit_pir_blankpril.ajax.reload();
		});
		table_blankview_edit_pir.on('deselect', function() {
			table_blankview_edit_pir_summadop.buttons().disable();
			table_blankview_edit_pir_summadop.ajax.reload();
			table_blankview_edit_pir_docfiles.buttons().disable();
			table_blankview_edit_pir_docfiles.ajax.reload();
			table_blankview_edit_pir_blankpril.buttons().disable();
			table_blankview_edit_pir_blankpril.ajax.reload();
		});
		table_blankview_edit_pir.on('init', function() {
			table_blankview_edit_pir_summadop.buttons().disable();
			table_blankview_edit_pir_docfiles.buttons().disable();
			table_blankview_edit_pir_blankpril.buttons().disable();
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
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/blankview/blankview-edit/restr_4/tabs/css/blankview-edit-tab5_pir.css">
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/blankview/blankview-edit/restr_4/tabs/css/blankview-edit-tab5_summadop.css">
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/blankview/blankview-edit/restr_4/tabs/css/blankview-edit-tab5_doc_files.css">
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/blankview/blankview-edit/restr_4/tabs/css/blankview-edit-tab5_pril_files.css">
<?php
// ----- ----- ----- ----- -----
// Форма редактирования заявки/бланка
// :::
?>
<div id="customForm_newblank_pir">
	<div id="newblank-pir-tabs" style="width:100%">
		<ul id="newblank-pir-tabs-menu" class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#pir-tab-1" title="">Основное</a></li>
			<li><a data-toggle="tab" href="#pir-tab-2" title="">Суммы</a></li>
			<li><a data-toggle="tab" href="#pir-tab-3" title="">Приложения</a></li>
			<li><a data-toggle="tab" href="#pir-tab-4" title="">Исполнение</a></li>
			<li><a data-toggle="tab" href="#pir-tab-10" title="">Условия</a></li>
			<li><a data-toggle="tab" href="#pir-tab-5" title="">Контакты</a></li>
			<li><a data-toggle="tab" href="#pir-tab-6" title="">Командировки</a></li>
			<li><a data-toggle="tab" href="#pir-tab-7" title="">Транспорт</a></li>
			<li><a data-toggle="tab" href="#pir-tab-8" title="">ДО</a></li>
			<li><a data-toggle="tab" href="#pir-tab-9" title="">Риски</a></li>
		</ul>
		<div class="tab-content" style="padding:5px">

			<div class="Section" style="background:#ddd; color:#000; margin-bottom:10px; border-bottom:2px #b95959 solid">
				<div class="Block100">
					<div class="Block30 fieldset-table-row">
						<div class="fieldset-table-cell" style="padding-bottom:3px">
							<fieldset>
								<editor-field name="dognet_blankdocpir.kodblankcreate"></editor-field>
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
								<editor-field name="dognet_blankdocpir.kodblankinprocess"></editor-field>
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
								<editor-field name="dognet_blankdocpir.kodblankdone"></editor-field>
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

			<div id="pir-tab-1" class="tab-pane fade in active">

				<div class="Section">
					<div class="Block20">
						<legend>Исполнители</legend>
						<fieldset class="field100">
							<editor-field name="dognet_blankdocpir.kodispolruk"></editor-field>
						</fieldset>
						<fieldset class="field100">
							<editor-field name="dognet_blankdocpir.kodispol"></editor-field>
						</fieldset>
					</div>
					<div class="Block60">
						<legend>Организация</legend>
						<div class="Block100">
							<fieldset class="field30">
								<editor-field name="dognet_blankdocpir.kodusespzakaz"></editor-field>
							</fieldset>
							<fieldset class="field40">
								<editor-field name="dognet_blankdocpir.kodzakaz"></editor-field>
							</fieldset>
							<fieldset class="field30 kodzakazFilter" style="padding-top:30px; padding-right:15px">
								<input id="kodzakaz_filter_pir" type="text" placeholder="Поиск" />
							</fieldset>
						</div>
						<div class="Block100">
							<fieldset class="field30">
								<editor-field name="dognet_blankdocpir.koduseneworg"></editor-field>
							</fieldset>
							<fieldset class="field70">
								<editor-field name="dognet_blankdocpir.nameneworg"></editor-field>
							</fieldset>
						</div>
					</div>
					<div class="Block100">
						<legend>Название договора</legend>
						<fieldset class="field100">
							<editor-field name="dognet_blankdocpir.namedocblank"></editor-field>
						</fieldset>
					</div>
				</div>

			</div>
			<div id="pir-tab-2" class="tab-pane fade">

				<div class="Section">
					<div class="Block20">
						<legend>Сумма договора</legend>
						<div class="Block100">
							<fieldset class="field100">
								<editor-field name="dognet_blankdocpir.csummadocopl"></editor-field>
							</fieldset>
						</div>
						<div class="Block100 fieldset-table-row">
							<div class="fieldset-table-cell" style="padding-bottom:3px">
								<fieldset>
									<editor-field name="dognet_blankdocpir.kodusendsopl"></editor-field>
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
									<editor-field name="dognet_blankdocpir.kodusespechopl"></editor-field>
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
								<editor-field name="dognet_blankdocpir.koduseopl1usl"></editor-field>
							</fieldset>
							<fieldset class="field60">
								<editor-field name="dognet_blankdocpir.csummaopl1usl"></editor-field>
							</fieldset>
						</div>
						<div id="useopl2usl" class="Block60" style="outline:1px dashed #ccc; outline-offset:-4px; padding:4px 8px">
							<fieldset class="field100">
								<div class="fieldset-info">Окончательная оплата в размере X процентов в течение N дней после подписания акта</div>
							</fieldset>
							<fieldset class="field30">
								<editor-field name="dognet_blankdocpir.koduseopl2usl"></editor-field>
							</fieldset>
							<fieldset class="field40">
								<editor-field name="dognet_blankdocpir.csummaopl2usl"></editor-field>
							</fieldset>
							<fieldset class="field30">
								<editor-field name="dognet_blankdocpir.cnumberoplday2usl"></editor-field>
							</fieldset>
						</div>
						<div id="useopl3usl" class="Block40" style="outline:1px dashed #ccc; outline-offset:-4px; padding:4px 8px">
							<fieldset class="field100">
								<div class="fieldset-info">В течение N дней после получения финансирования от конечного Заказчика</div>
							</fieldset>
							<fieldset class="field40">
								<editor-field name="dognet_blankdocpir.koduseopl3usl"></editor-field>
							</fieldset>
							<fieldset class="field60">
								<editor-field name="dognet_blankdocpir.cnumberoplday3usl"></editor-field>
							</fieldset>
						</div>
						<div id="useopl4usl" class="Block60" style="outline:1px dashed #ccc; outline-offset:-4px; padding:4px 8px">
							<fieldset class="field30">
								<editor-field name="dognet_blankdocpir.koduseopl4usl"></editor-field>
							</fieldset>
							<fieldset class="field70">
								<editor-field name="dognet_blankdocpir.ctextoplotherusl"></editor-field>
							</fieldset>
						</div>
					</div>
				</div>

			</div>
			<div id="pir-tab-3" class="tab-pane fade">

				<div class="Section">
					<div class="Block100">
						<legend>Перечень приложений</legend>
						<div class="Block100 fieldset-table-row">
							<div class="fieldset-table-cell" style="padding-bottom:3px">
								<fieldset>
									<editor-field name="dognet_blankdocpir.kodusepril1"></editor-field>
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
									<editor-field name="dognet_blankdocpir.kodusepril2"></editor-field>
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
									<editor-field name="dognet_blankdocpir.kodusepril3"></editor-field>
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
									<editor-field name="dognet_blankdocpir.kodusepril4"></editor-field>
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
									<editor-field name="dognet_blankdocpir.kodusepril5"></editor-field>
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
			<div id="pir-tab-4" class="tab-pane fade">

				<div class="Section">
					<div class="Block100">
						<legend>Исполнение</legend>
						<div id="useispoldoc1" class="Block50 fieldset-table-row" style="outline:1px dashed #ccc; outline-offset:-4px; padding:4px 8px">
							<div class="fieldset-table-cell" style="padding-bottom:3px">
								<fieldset>
									<editor-field name="dognet_blankdocpir.koduseispoldoc1"></editor-field>
								</fieldset>
							</div>
							<div class="fieldset-table-cell" style="width:70%">
								<div>
									<div class="chekbox-inline-text">Дата исполнения</div>
								</div>
							</div>
							<div class="fieldset-table-cell" style="padding-bottom:3px; width:30%">
								<fieldset>
									<editor-field name="dognet_blankdocpir.cdateispoldoc1"></editor-field>
								</fieldset>
							</div>
						</div>
						<div id="useispoldoc3" class="Block50 fieldset-table-row" style="outline:1px dashed #ccc; outline-offset:-4px; padding:4px 8px">
							<div class="fieldset-table-cell" style="padding-bottom:3px">
								<fieldset>
									<editor-field name="dognet_blankdocpir.koduseispoldoc3"></editor-field>
								</fieldset>
							</div>
							<div class="fieldset-table-cell" style="width:100%">
								<div>
									<div class="chekbox-inline-text">Автоматическая пролонгация</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
			<div id="pir-tab-10" class="tab-pane fade">

				<div class="Section">
					<div class="Block100">
						<legend>Особые условия (определяются ГИПом)</legend>
						<fieldset class="field80">
							<editor-field name="dognet_blankdocpir.defuslgiptext"></editor-field>
						</fieldset>
						<fieldset class="field20">
							<editor-field name="dognet_blankdocpir.kodusetender"></editor-field>
						</fieldset>
					</div>
				</div>

			</div>
			<div id="pir-tab-5" class="tab-pane fade">

				<div class="Section">
					<div class="Block100">
						<legend>Контакты</legend>
						<div class="Block50" style="padding:0 15px">
							<div class="Block100 fieldset-table-row">
								<div class="fieldset-table-cell" style="white-space:nowrap; width:50%">
									<div>
										<div class="chekbox-inline-text">Фамилия</div>
									</div>
								</div>
								<div class="fieldset-table-cell" style="padding-top:4px">
									<fieldset>
										<editor-field name="dognet_blankdocpir.nameendcontact"></editor-field>
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
										<editor-field name="dognet_blankdocpir.namefistcontact"></editor-field>
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
										<editor-field name="dognet_blankdocpir.namesecondcontact"></editor-field>
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
										<editor-field name="dognet_blankdocpir.namedoljcontact"></editor-field>
									</fieldset>
								</div>
							</div>
						</div>
						<div class="Block50" style="padding:0 15px">
							<div class="Block100 fieldset-table-row">
								<div class="fieldset-table-cell" style="white-space:nowrap; width:50%">
									<div>
										<div class="chekbox-inline-text">Телефон (рабочий)</div>
									</div>
								</div>
								<div class="fieldset-table-cell" style="padding-top:4px">
									<fieldset>
										<editor-field name="dognet_blankdocpir.numbertelrab"></editor-field>
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
										<editor-field name="dognet_blankdocpir.numbertelmob"></editor-field>
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
										<editor-field name="dognet_blankdocpir.numbertelfax"></editor-field>
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
										<editor-field name="dognet_blankdocpir.nameemail"></editor-field>
									</fieldset>
								</div>
							</div>
						</div>
					</div>
					<div class="Block100">
						<legend>Дополнительные контакты (одной строкой)</legend>
						<div class="Block100" style="padding:0 15px">
							<div class="Block100 fieldset-table-row">
								<div class="fieldset-table-cell" style="white-space:nowrap">
									<div>
										<div class="chekbox-inline-text">Доп контакты 1</div>
									</div>
								</div>
								<div class="fieldset-table-cell" style="padding-top:4px; width:100%">
									<fieldset>
										<editor-field name="dognet_blankdocpir.dopcontact1"></editor-field>
									</fieldset>
								</div>
							</div>
						</div>
						<div class="Block100" style="padding:0 15px">
							<div class="Block100 fieldset-table-row">
								<div class="fieldset-table-cell" style="white-space:nowrap">
									<div>
										<div class="chekbox-inline-text">Доп контакты 2</div>
									</div>
								</div>
								<div class="fieldset-table-cell" style="padding-top:4px; width:100%">
									<fieldset>
										<editor-field name="dognet_blankdocpir.dopcontact2"></editor-field>
									</fieldset>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
			<div id="pir-tab-6" class="tab-pane fade">

				<div class="Section">
					<div class="Block100">
						<legend>Командировочные расходы</legend>
						<div class="Block100 fieldset-table-row">
							<div class="fieldset-table-cell" style="padding-bottom:3px">
								<fieldset>
									<editor-field name="dognet_blankdocpir.kodusekomrasx1"></editor-field>
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
									<editor-field name="dognet_blankdocpir.kodusekomrasx2"></editor-field>
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
									<editor-field name="dognet_blankdocpir.kodusekomrasx3"></editor-field>
								</fieldset>
							</div>
							<div class="fieldset-table-cell" style="width:80%">
								<div>
									<div class="chekbox-inline-text">Входят в стоимость договора с установленным лимитом</div>
								</div>
							</div>
							<div class="fieldset-table-cell" style="padding-top:4px; width:20%">
								<fieldset>
									<editor-field name="dognet_blankdocpir.summalimitmis"></editor-field>
								</fieldset>
							</div>
						</div>
						<div class="Block100 fieldset-table-row">
							<div class="fieldset-table-cell" style="padding-bottom:3px">
								<fieldset>
									<editor-field name="dognet_blankdocpir.kodusekomrasx4"></editor-field>
								</fieldset>
							</div>
							<div class="fieldset-table-cell">
								<div>
									<div class="chekbox-inline-text">Примечание</div>
								</div>
							</div>
							<div class="fieldset-table-cell" style="padding-top:4px; width:100%">
								<fieldset>
									<editor-field name="dognet_blankdocpir.komrasxprim"></editor-field>
								</fieldset>
							</div>
						</div>
					</div>
				</div>

			</div>
			<div id="pir-tab-7" class="tab-pane fade">

				<div class="Section">
					<div class="Block60">
						<legend>Транспортные расходы</legend>
						<div class="Block100 fieldset-table-row">
							<div class="fieldset-table-cell" style="padding-bottom:3px">
								<fieldset>
									<editor-field name="dognet_blankdocpir.kodusetrans1"></editor-field>
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
									<editor-field name="dognet_blankdocpir.kodusetrans2"></editor-field>
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
									<editor-field name="dognet_blankdocpir.kodusetrans3"></editor-field>
								</fieldset>
							</div>
							<div class="fieldset-table-cell">
								<div>
									<div class="chekbox-inline-text">Иное</div>
								</div>
							</div>
							<div class="fieldset-table-cell" style="padding-top:4px; width:100%">
								<fieldset>
									<editor-field name="dognet_blankdocpir.transprim"></editor-field>
								</fieldset>
							</div>
						</div>
					</div>
					<div class="Block40">
						<legend>Условия поставки</legend>
						<fieldset class="field100">
							<editor-field name="dognet_blankdocpir.transplaceobor"></editor-field>
						</fieldset>
					</div>
				</div>

			</div>
			<div id="pir-tab-8" class="tab-pane fade">

				<div class="Section">
					<div class="Block100">
						<legend>Дополнительные ограничения</legend>
						<div class="Block60" style="padding:0 15px">
							<div class="Block100 fieldset-table-row">
								<div class="fieldset-table-cell" style="white-space:nowrap; width:80%">
									<div>
										<div class="chekbox-inline-text">Номер основного договора, если АТГС Заказчик. Договор № 3-4/</div>
									</div>
								</div>
								<div class="fieldset-table-cell" style="padding-top:4px">
									<fieldset>
										<editor-field name="dognet_blankdocpir.numberdocmain"></editor-field>
									</fieldset>
								</div>
							</div>
						</div>
						<div class="Block60" style="padding:0 15px">
							<div class="Block100 fieldset-table-row">
								<div class="fieldset-table-cell" style="white-space:nowrap; width:80%">
									<div>
										<div class="chekbox-inline-text">Ограничение по сроку оформление ( дней )</div>
									</div>
								</div>
								<div class="fieldset-table-cell" style="padding-top:4px">
									<fieldset>
										<editor-field name="dognet_blankdocpir.climitdays"></editor-field>
									</fieldset>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
			<div id="pir-tab-9" class="tab-pane fade">

				<div class="Section">
					<div class="Block100">
						<div class="Block100 fieldset-table-row">
							<div class="fieldset-table-cell" style="padding-bottom:3px">
								<fieldset>
									<editor-field name="dognet_blankdocpir.koduserisk1"></editor-field>
								</fieldset>
							</div>
							<div class="fieldset-table-cell" style="width:100%">
								<div>
									<div class="chekbox-inline-text">Осуществимость выполнения работ по срокам</div>
								</div>
							</div>
						</div>
						<div class="Block100 fieldset-table-row">
							<div class="fieldset-table-cell" style="padding-bottom:3px">
								<fieldset>
									<editor-field name="dognet_blankdocpir.koduserisk2"></editor-field>
								</fieldset>
							</div>
							<div class="fieldset-table-cell" style="width:100%">
								<div>
									<div class="chekbox-inline-text">Полнота исходных данных</div>
								</div>
							</div>
						</div>
						<div class="Block100 fieldset-table-row">
							<div class="fieldset-table-cell" style="padding-bottom:3px">
								<fieldset>
									<editor-field name="dognet_blankdocpir.koduserisk3"></editor-field>
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
									<editor-field name="dognet_blankdocpir.koduserisk4"></editor-field>
								</fieldset>
							</div>
							<div class="fieldset-table-cell" style="width:100%">
								<div>
									<div class="chekbox-inline-text">Сезон технического обслуживания объекта</div>
								</div>
							</div>
						</div>
						<div class="Block100 fieldset-table-row">
							<div class="fieldset-table-cell" style="padding-bottom:3px">
								<fieldset>
									<editor-field name="dognet_blankdocpir.koduserisk5"></editor-field>
								</fieldset>
							</div>
							<div class="fieldset-table-cell" style="width:100%">
								<div>
									<div class="chekbox-inline-text">Соблюдение срока оплаты по договору</div>
								</div>
							</div>
						</div>
						<div class="Block100 fieldset-table-row">
							<div class="fieldset-table-cell" style="padding-bottom:3px">
								<fieldset>
									<editor-field name="dognet_blankdocpir.koduserisk6"></editor-field>
								</fieldset>
							</div>
							<div class="fieldset-table-cell">
								<div>
									<div class="chekbox-inline-text">Иное</div>
								</div>
							</div>
							<div class="fieldset-table-cell" style="padding-top:4px; width:100%">
								<fieldset>
									<editor-field name="dognet_blankdocpir.riskprim"></editor-field>
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
<div id="customForm_blanksummadop_pir">
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
<div id="customForm_blankworkpril_pir">
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
<div id="customForm_docblankfiles_pir">
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
	<table id="blankview-edit-pir-table" class="table table-bordered table-condensed display compact" cellspacing="0" width="100%">
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
		<div id="blankview-edit-pir-summadop">
			<h3 class="space10">Разбиение суммы договора</h3>
			<div class="demo-html"></div>
			<table id="blankview-edit-pir-summadop-table" class="table table-striped" cellspacing="0" width="100%">
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
		<div id="blankview-edit-pir-docfiles">
			<h3 class="space10">Файлы бланков для печати</h3>
			<div class="demo-html"></div>
			<table id="blankview-edit-pir-docfiles-table" class="table table-striped" cellspacing="0" width="100%">
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
		<div id="blankview-edit-pir-blankpril">
			<h3 class="space10">Прикрепленные к бланку файлы</h3>
			<div class="demo-html"></div>
			<table id="blankview-edit-pir-blankpril-table" class="table table-striped" cellspacing="0" width="100%">
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