<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/libs/select2/select2.min.css" crossorigin="anonymous" />
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/libs/select2/select2.full.min.js"></script>
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/libs/select2/ru.min.js"></script>

<script type="text/javascript" language="javascript" class="init">
	(function(factory) {
		if (typeof define === 'function' && define.amd) {
			// AMD
			define(['jquery', 'datatables.net', 'datatables.net-editor'], factory);
		} else if (typeof exports === 'object') {
			// Node / CommonJS
			module.exports = function($, dt) {
				if (!$) {
					$ = require('jquery');
				}
				factory($, dt || $.fn.dataTable || require('datatables'));
			};
		} else if (jQuery) {
			// Browser standard
			factory(jQuery, jQuery.fn.dataTable);
		}
	}(function($, DataTable) {
		'use strict';


		if (!DataTable.ext.editorFields) {
			DataTable.ext.editorFields = {};
		}

		var _fieldTypes = DataTable.Editor ?
			DataTable.Editor.fieldTypes :
			DataTable.ext.editorFields;

		_fieldTypes.select2 = {
			_addOptions: function(conf, opts) {
				var elOpts = conf._input[0].options;

				elOpts.length = 0;

				if (opts) {
					DataTable.Editor.pairs(opts, conf.optionsPair, function(val, label, i) {
						elOpts[i] = new Option(label, val);
					});
				}
			},

			create: function(conf) {
				conf._input = $('<select/>')
					.attr($.extend({
						id: DataTable.Editor.safeId(conf.id)
					}, conf.attr || {}));

				var options = $.extend({
					width: '100%'
				}, conf.opts);

				_fieldTypes.select2._addOptions(conf, conf.options || conf.ipOpts);
				conf._input.select2(options);

				var open;
				conf._input
					.on('select2:open', function() {
						open = true;
					})
					.on('select2:close', function() {
						open = false;
					});

				// On open, need to have the instance update now that it is in the DOM
				this.one('open.select2-' + DataTable.Editor.safeId(conf.id), function() {
					conf._input.select2(options);

					if (open) {
						conf._input.select2('open');
					}
				});

				return conf._input[0];
			},

			get: function(conf) {
				var val = conf._input.val();
				val = conf._input.prop('multiple') && val === null ? [] :
					val;

				return conf.separator ?
					val.join(conf.separator) :
					val;
			},

			set: function(conf, val) {
				if (conf.separator && !Array.isArray(val)) {
					val = val.split(conf.separator);
				}

				// Clear out any existing tags
				if (conf.opts && conf.opts.tags) {
					conf._input.val([]);
				}

				// The value isn't present in the current options list, so we need to add it
				// in order to be able to select it. Note that this makes the set action async!
				// It doesn't appear to be possible to add an option to select2, then change
				// its label and update the display
				var needAjax = false;

				if (conf.opts && conf.opts.ajax) {
					if (Array.isArray(val)) {
						for (var i = 0, ien = val.length; i < ien; i++) {
							if (conf._input.find('option[value="' + val[i] + '"]').length === 0) {
								needAjax = true;
								break;
							}
						}
					} else {
						if (conf._input.find('option[value="' + val + '"]').length === 0) {
							needAjax = true;
						}
					}
				}

				if (needAjax && val) {
					$.ajax($.extend({
						beforeSend: function(jqXhr, settings) {
							// Add an initial data request to the server, but don't
							// override `data` since the dev might be using that
							var initData = conf.urlDataType === undefined || conf.urlDataType === 'json' ?
								'initialValue=true&value=' + JSON.stringify(val) :
								$.param({
									initialValue: true,
									value: val
								});

							if (typeof conf.opts.ajax.url === 'function') {
								settings.url = conf.opts.ajax.url();
							}

							if (settings.type === 'GET') {
								settings.url += settings.url.indexOf('?') === -1 ?
									'?' + initData :
									'&' + initData;
							} else {
								settings.data = settings.data ?
									settings.data + '&' + initData :
									initData;
							}
						},
						success: function(json) {
							var addOption = function(option) {
								if (conf._input.find('option[value="' + option.id + '"]').length === 0) {
									$('<option/>')
										.attr('value', option.id)
										.text(option.text)
										.appendTo(conf._input);
								}
							}

							if (Array.isArray(json)) {
								for (var i = 0, ien = json.length; i < ien; i++) {
									addOption(json[i]);
								}
							} else if (json.results && Array.isArray(json.results)) {
								for (var i = 0, ien = json.results.length; i < ien; i++) {
									addOption(json.results[i]);
								}
							} else {
								addOption(json);
							}

							conf._input
								.val(val)
								.trigger('change', {
									editor: true
								});
						}
					}, conf.opts.ajax));
				} else {
					conf._input
						.val(val)
						.trigger('change', {
							editor: true
						});
				}
			},

			enable: function(conf) {
				$(conf._input).removeAttr('disabled');
			},

			disable: function(conf) {
				$(conf._input).attr('disabled', 'disabled');
			},

			// Non-standard Editor methods - custom to this plug-in
			inst: function(conf) {
				var args = Array.prototype.slice.call(arguments);
				args.shift();

				return conf._input.select2.apply(conf._input, args);
			},

			update: function(conf, data) {
				var val = _fieldTypes.select2.get(conf);

				_fieldTypes.select2._addOptions(conf, data);

				// Restore null value if it was, to let the placeholder show
				if (val === null) {
					_fieldTypes.select2.set(conf, null);
				}

				$(conf._input).trigger('change', {
					editor: true
				});
			},

			focus: function(conf) {
				if (conf._input.is(':visible') && conf.onFocus === 'focus') {
					conf._input.select2('open');
				}
			},

			owns: function(conf, node) {
				if ($(node).closest('.select2-container').length || $(node).closest('.select2').length || $(node).hasClass('select2-selection__choice__remove')) {
					return true;
				}
				return false;
			},

			canReturnSubmit: function() {
				return false;
			}
		};


	}));

	var table_tab8_contact;
	var editor_tab8_contact;

	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	//
	//
	$(document).ready(function() {
		//
		editor_tab8_contact = new $.fn.dataTable.Editor({
			display: "bootstrap",
			ajax: "php/examples/simple/docview/docview-edit/restr_4/tabs/process/dognet-docview-edit(restr_4)-tab8_contact-process.php",
			table: "#sp-tab8_contact-table",
			i18n: {
				create: {
					title: "<h3>Добавить новый контакт</h3>"
				},
				edit: {
					title: "<h3>Редактировать контакт</h3>"
				},
				remove: {
					title: "<h3>Удалить контакт</h3>",
					confirm: {
						"_": "Вы уверены, что хотите удалить %d записи(ей)?",
						"1": "Вы уверены, что хотите удалить этого исполнителя?"
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
			template: '#customForm-tab8_contact',
			fields: [{
				label: "Фамилия :",
				name: "dognet_spcontact.namecontactend",
				attr: {
					placeholder: 'Фамилия'
				}
			}, {
				label: "Имя :",
				name: "dognet_spcontact.namecontactfist",
				attr: {
					placeholder: 'Имя'
				}
			}, {
				label: "Отчество :",
				name: "dognet_spcontact.namecontactsecond",
				attr: {
					placeholder: 'Отчество'
				}
			}, {
				label: "Краткое имя :",
				name: "dognet_spcontact.namecontactshot",
				attr: {
					placeholder: 'Фамилия И.О.'
				}
			}, {
				label: "Телефон 1 :",
				name: "dognet_spcontact.telcontact1",
				attr: {
					placeholder: 'Телефон'
				}
			}, {
				label: "Телефон 2 :",
				name: "dognet_spcontact.telcontact2",
				attr: {
					placeholder: 'Телефон'
				}
			}, {
				label: "Телефон 3 :",
				name: "dognet_spcontact.telcontact3",
				attr: {
					placeholder: 'Телефон'
				}
			}, {
				label: "Сотовый :",
				name: "dognet_spcontact.telcontactmobi",
				attr: {
					placeholder: 'Сотовый телефон'
				}
			}, {
				label: "Email :",
				name: "dognet_spcontact.emailcontact",
				attr: {
					placeholder: 'Email'
				}
			}, {
				label: "Факс :",
				name: "dognet_spcontact.faxcontact",
				attr: {
					placeholder: 'Факс'
				}
			}, {
				label: "Должность :",
				name: "dognet_spcontact.doljcontact",
				attr: {
					placeholder: 'Должность'
				}
			}, {
				label: "Организация :",
				name: "dognet_spcontact.kodzakaz",
				type: "select2",
				placeholder: "Выберите организацию"
			}, {
				label: "Договор :",
				name: "dognet_spcontact.koddoc",
				type: "select2",
				placeholder: "Выберите договор"
			}, {
				label: "Примечание :",
				name: "dognet_spcontact.contactprim",
				type: "textarea",
				attr: {
					placeholder: 'Комментарий к контакту'
				}
			}, {
				label: "",
				type: "checkbox",
				name: "zakunlink",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				def: "0",
				unselectedValue: 0
			}, {
				label: "",
				type: "checkbox",
				name: "docunlink",
				options: [{
					label: "",
					value: 1
				}],
				separator: "",
				def: "0",
				unselectedValue: 0
			}]
		});
		//
		// Изменяем размер диалогового окна редактирования договора субподряда
		editor_tab8_contact.on('open', function() {
			doctmp = editor_tab8_contact.field('dognet_spcontact.koddoc').val();
			zaktmp = editor_tab8_contact.field('dognet_spcontact.kodzakaz').val();
			$(".modal-dialog").css({
				"width": "65%",
				"min-width": "680px",
				"max-width": "800px"
			});
			// $("#DTE_Field_dognet_spcontact-telcontact1").inputmask("8(999)999-9999");
			$("#DTE_Field_dognet_spcontact-telcontactmobi").inputmask("+7(999)999-9999");

			$('#DTE_Field_dognet_spcontact-kodzakaz').select2({
				placeholder: 'Вводите название организации используя поиск (внутри списка)',
				allowClear: 'true',
				minimumInputLength: 3, // only start searching when the user has input 3 or more characters
				width: '100%'
			});
			$('#DTE_Field_dognet_spcontact-koddoc').select2({
				placeholder: 'Вводите номер или название договора используя поиск (внутри списка)',
				allowClear: 'true',
				minimumInputLength: 3, // only start searching when the user has input 3 or more characters
				width: '100%'
			});

			editor_tab8_contact.disable(['dognet_spcontact.namecontactshot']);

			editor_tab8_contact.dependent('docunlink', function(val) {
				if (val == 1) {
					console.log("Docunlink!");
					editor_tab8_contact.field('dognet_spcontact.koddoc').set('');
				} else {
					editor_tab8_contact.field('dognet_spcontact.koddoc').set(doctmp);
				}
			})
			editor_tab8_contact.dependent('zakunlink', function(val) {
				if (val == 1) {
					console.log("Zakunlink!");
					editor_tab8_contact.field('dognet_spcontact.kodzakaz').set('');
				} else {
					editor_tab8_contact.field('dognet_spcontact.kodzakaz').set(zaktmp);
				}
			})
		});
		//
		editor_tab8_contact.on('close', function() {
			$(".modal-dialog").css({
				"width": "80%",
				"min-width": "none",
				"max-width": "none"
			});
			table_tab8_contact.ajax.reload(null, false);
		});
		//
		// ----- --- ----- --- -----
		//
		table_tab8_contact = $('#sp-tab8_contact-table').DataTable({
			dom: "<'row'<'col-sm-5'B><'col-sm-4'><'col-sm-3'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'p>>",
			language: {
				url: "php/examples/simple/docview/docview-edit/dt_russian-tab8_contact.json"
			},
			ajax: {
				url: "php/examples/simple/docview/docview-edit/restr_4/tabs/process/dognet-docview-edit(restr_4)-tab8_contact-process.php",
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
					data: "dognet_spcontact.namecontactend"
				},
				{
					data: "sp_contragents.nameshort"
				},
				{
					data: "dognet_spcontact.doljcontact"
				},
				{
					data: "dognet_spcontact.emailcontact"
				},
				{
					data: "dognet_spcontact.telcontactmobi"
				}
			],
			columnDefs: [{
					orderable: false,
					searchable: false,
					targets: 0
				},
				{
					orderable: false,
					searchable: true,
					render: function(data, type, row, meta) {
						last = (row.dognet_spcontact.namecontactend != '') ? row.dognet_spcontact.namecontactend : '';
						first = (row.dognet_spcontact.namecontactfist != '') ? row.dognet_spcontact.namecontactfist : '';
						mid = (row.dognet_spcontact.namecontactsecond != '') ? row.dognet_spcontact.namecontactsecond : '';
						return last + '&nbsp;' + first + '&nbsp;' + mid;
					},
					targets: 1
				},
				{
					orderable: false,
					searchable: true,
					render: function(data, type, row, meta) {
						str = data;
						if (str !== null) {
							if (str.length > 27) {
								return str.substr(0, 27) + " ...";
							} else {
								return str;
							}
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
						str = data;
						if (str.length > 37) {
							return str.substr(0, 37) + " ...";
						} else {
							return str;
						}
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
				}
			],
			order: [
				[1, "asc"]
			],
			select: true,
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
						table_tab8_contact.columns().search('');
						table_tab8_contact.order([1, "asc"]).draw();
					}
				},
				{
					extend: "create",
					editor: editor_tab8_contact,
					text: "ДОБАВИТЬ КОНТАКТ",
					formButtons: ['Добавить контакт',
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
					editor: editor_tab8_contact,
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
					editor: editor_tab8_contact,
					text: "УДАЛИТЬ",
					formButtons: ['Удалить контакт',
						{
							text: 'Отмена',
							action: function() {
								this.close();
							}
						}
					]
				}
			]
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		var detailRows_tab8_contact = [];
		$('#sp-tab8_contact-table tbody').on('click', 'tr td.details-control', function() {
			var tr = $(this).closest('tr');
			var row = table_tab8_contact.row(tr);
			var idx = $.inArray(tr.attr('id'), detailRows_tab8_contact);
			if (row.child.isShown()) {
				tr.removeClass('details');
				row.child.hide();
				detailRows_tab8_contact.splice(idx, 1);
			} else {
				tr.addClass('details');
				rowData = table_tab8_contact.row(row);
				d = row.data();
				rowData.child(<?php include('templates/docview-edit_tab8_contact.tpl'); ?>).show();
				if (idx === -1) {
					detailRows_tab8_contact.push(tr.attr('id'));
				}
			}
		});
		//
		table_tab8_contact.on('draw', function() {
			$.each(detailRows_tab8_contact, function(i, id) {
				$('#' + id + ' td.details-control').trigger('click');
			});
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		//
		//
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		// Выводим уведомление (цифру) о количестве документов по договору
		table_tab8_contact.on('draw', function() {
			items = table_tab8_contact.data().count();
			if (items > 0) {
				document.getElementById("con_newitems_cnt").innerHTML = items;
			} else {
				document.getElementById("con_newitems_cnt").innerHTML = "";
			}
		});
	});
</script>
<?php
// ----- ----- ----- ----- -----
// Подключаем форму редактирования и выводим таблицу
// :::
include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/docview/docview-edit/restr_4/tabs/forms/docview-edit_tab8_contact-customForm.php");
// ----- ----- ----- ----- -----
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-edit/restr_4/tabs/css/docview-edit-tab8_contact-main.css">
<section>
	<div id="sp-tab8_contact" class="">
		<div id="tab8_contact" class="">
			<div class="space30"></div>
			<h3 class="parent-title space20">Контакты по договору (из справочника контактов)</h3>
			<div class="demo-html"></div>
			<table id="sp-tab8_contact-table" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th><span class='glyphicon glyphicon-option-vertical'></span></th>
						<th>ФИО</th>
						<th>Организация</th>
						<th>Должность</th>
						<th>Email</th>
						<th>Мобильный</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</section>