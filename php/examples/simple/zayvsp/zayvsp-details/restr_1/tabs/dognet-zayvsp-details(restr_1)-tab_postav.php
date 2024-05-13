<script type="text/javascript" language="javascript" class="init">
	var table_tab_postav;
	var editor_tab_postav; // use a global for the submit and return data rendering in the examples

	function isValidUrl(url) {
		var objRE = /(^https?:\/\/)?[a-z0-9~_\-\.]+\.[a-z]{2,9}(\/|:|\?[!-~]*)?$/i;
		return objRE.test(url);
	}

	//
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	//
	$(document).ready(function() {
		//
		editor_tab_postav = new $.fn.dataTable.Editor({
			display: "bootstrap",
			ajax: "php/examples/simple/zayvsp/zayvsp-details/restr_1/tabs/process/dognet-zayvsp-details-tab_postav-process.php",
			table: "#zayvsp-details-tab_postav-table",
			i18n: {
				create: {
					title: "<h3>Добавить нового поставщика</h3>"
				},
				edit: {
					title: "<h3>Изменить данные</h3>"
				},
				remove: {
					button: "Удалить",
					title: "<h3>Удалить поставщика</h3>",
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
			template: "#customForm-zayvsp-details-tab_postav",
			fields: [{
				label: "Краткое название",
				name: "sp_contragents.nameshort",
				attr: {
					placeholder: 'Краткое название поставщика'
				}
			}, {
				label: "Полное название",
				name: "sp_contragents.namefull",
				type: "textarea",
				attr: {
					placeholder: 'Полное название поставщика'
				}
			}, {
				label: "Адрес компании",
				name: "sp_contragents.address_postal",
				type: "textarea",
				attr: {
					placeholder: 'Адрес компании'
				}
			}, {
				label: "Сайт компании",
				name: "sp_contragents.web_official",
				attr: {
					placeholder: ''
				}
			}, {
				label: "Телефон / факс",
				name: "sp_contragents.postcontactfax",
				attr: {
					placeholder: 'Телефон / факс'
				}
			}, {
				label: "Дополнительная информация",
				name: "sp_contragents.postcontactmore",
				type: "textarea",
				attr: {
					placeholder: 'Дополнительная информация'
				}
			}, {
				label: "Контакт (DocNET)",
				name: "sp_contragents.postcontactone",
				attr: {
					placeholder: 'Контактное лицо'
				}
			}, {
				label: "Email (DocNET)",
				name: "sp_contragents.postcontactmail",
				attr: {
					placeholder: 'Email'
				}
			}, {
				label: "Телефон (DocNET)",
				name: "sp_contragents.postcontacttel",
				attr: {
					placeholder: 'Телефон'
				}
			}, {
				label: "ФИО контакта",
				name: "sp_contragents.cont1_name",
				attr: {
					placeholder: 'Контактное лицо'
				}
			}, {
				label: "Email",
				name: "sp_contragents.cont1_email",
				attr: {
					placeholder: 'Email'
				}
			}, {
				label: "Телефон (офис)",
				name: "sp_contragents.cont1_tels",
				attr: {
					placeholder: 'Телефон'
				}
			}, {
				label: "Телефон (мобильный)",
				name: "sp_contragents.cont1_telm",
				attr: {
					placeholder: 'Мобильный телефон'
				}
			}, {
				label: "ФИО контакта",
				name: "sp_contragents.cont2_name",
				attr: {
					placeholder: 'Контактное лицо'
				}
			}, {
				label: "Email",
				name: "sp_contragents.cont2_email",
				attr: {
					placeholder: 'Email'
				}
			}, {
				label: "Телефон (офис)",
				name: "sp_contragents.cont2_tels",
				attr: {
					placeholder: 'Телефон'
				}
			}, {
				label: "Телефон (мобильный)",
				name: "sp_contragents.cont2_telm",
				attr: {
					placeholder: 'Мобильный телефон'
				}
			}, {
				label: "ФИО контакта",
				name: "sp_contragents.cont3_name",
				attr: {
					placeholder: 'Контактное лицо'
				}
			}, {
				label: "Email",
				name: "sp_contragents.cont3_email",
				attr: {
					placeholder: 'Email'
				}
			}, {
				label: "Телефон (офис)",
				name: "sp_contragents.cont3_tels",
				attr: {
					placeholder: 'Телефон'
				}
			}, {
				label: "Телефон (мобильный)",
				name: "sp_contragents.cont3_telm",
				attr: {
					placeholder: 'Мобильный телефон'
				}
			}]
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		// Изменяем размер диалогового окна редактирования
		editor_tab_postav.on('open', function() {
			$(".modal-dialog").css({
				"width": "60%",
				"min-width": "640px",
				"max-width": "800px"
			});
		});
		editor_tab_postav.on('close', function() {
			$(".modal-dialog").css({
				"width": "60%",
				"min-width": "640px",
				"max-width": "480px"
			});
		});
		//
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		table_tab_postav = $('#zayvsp-details-tab_postav-table').DataTable({
			dom: "<'row'<'col-sm-5'B><'col-sm-2'><'col-sm-2'l><'col-sm-3'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'p>>",
			// 		dom: "<'space50'r>lftip",
			language: {
				url: "php/examples/simple/zayvsp/zayvsp-details/dt_russian-zayvsp_postav.json",
				lengthMenu: "Показать _MENU_"
			},
			ajax: {
				url: "php/examples/simple/zayvsp/zayvsp-details/restr_1/tabs/process/dognet-zayvsp-details-tab_postav-process.php",
				type: "POST"
			},
			serverSide: true,
			columns: [{
					class: "details-control",
					searchable: false,
					orderable: false,
					data: null,
					defaultContent: "<span class='glyphicon glyphicon-option-vertical'></span>",
					className: "text-center"
				},
				{
					data: "sp_contragents.nameshort",
					defaultContent: ""
				},
				{
					data: "sp_contragents.postcontactone"
				},
				{
					data: "sp_contragents.postcontactmail"
				},
				{
					data: "sp_contragents.postcontacttel"
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
					render: function(data, type, row) {
						urlpost = row.sp_contragents.web_official;
						if (isValidUrl(urlpost)) {
							return '<a href="' + urlpost + '" class="link-to-post" target="_blank" title="Перейти на сайт Поставщика">' + data + '</a>';
						} else {
							return data;
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
					searchable: false,
					targets: 3
				},
				{
					orderable: false,
					searchable: false,
					targets: 4
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
			lengthChange: true,
			lengthMenu: [
				[15, 30, 50, -1],
				[15, 30, 50, "Все"]
			],
			buttons: [{
				text: '<span class="glyphicon glyphicon-refresh"></span>',
				action: function(e, dt, node, config) {
					table_tab_postav.columns().search('');
					table_tab_postav.order([1, "asc"]).draw();
				}
			}],
			initComplete: function() {

			},
			drawCallback: function() {

			}
		});
		//
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		var detailRows_postav = [];
		$('#zayvsp-details-tab_postav-table tbody').on('click', 'tr td.details-control', function() {
			var tr = $(this).closest('tr');
			var row = table_tab_postav.row(tr);
			var idx = $.inArray(tr.attr('id'), detailRows_postav);
			if (row.child.isShown()) {
				tr.removeClass('details');
				row.child.hide();
				detailRows_postav.splice(idx, 1);
			} else {
				tr.addClass('details');
				rowData = table_tab_postav.row(row);
				d = row.data();

				urlpost = d.sp_contragents.web_official;
				if (isValidUrl(urlpost)) {
					d.url = '<a href="' + urlpost + '" class="link-to-post" target="_blank" title="Перейти на сайт Поставщика">' + urlpost + '</a>';
				} else {
					d.url = "---";
				}


				rowData.child(<?php include('templates/zayvsp-details_tab_postav.tpl'); ?>).show();
				if (idx === -1) {
					detailRows_postav.push(tr.attr('id'));
				}
			}
		});
		table_tab_postav.on('draw', function() {
			$.each(detailRows_postav, function(i, id) {
				$('#' + id + ' td.details-control').trigger('click');
			});
		});

		editor_tab_postav
			.on('open', function() {

				$('#DTE_Field_dognet_sppostav-postweb').inputmask({
					mask: "http://*{1,50}",
					greedy: false,
					onBeforeMask: function(pastedValue, opts) {
						pastedValue = pastedValue.toLowerCase();
						return pastedValue.replace("http://", "");
					},
					definitions: {
						'*': {
							validator: "[0-9A-Za-zА-Яа-я:.!#$%&'*+/=?^_`{|}~\-]",
							casing: "lower"
						}
					}
				});

				$('#DTE_Field_dognet_sppostav-contactemail1').inputmask({
					mask: "*{1,20}[.*{1,20}][.*{1,20}][.*{1,20}]@*{1,20}[.*{2,6}]",
					greedy: false,
					onBeforePaste: function(pastedValue, opts) {
						pastedValue = pastedValue.toLowerCase();
						return pastedValue.replace("mailto:", "");
					},
					definitions: {
						'*': {
							validator: "[0-9A-Za-z!#$%&'*+/=?^_`{|}~\-]",
							casing: "lower"
						}
					}
				});
				$('#DTE_Field_dognet_sppostav-contactemail2').inputmask({
					mask: "*{1,20}[.*{1,20}][.*{1,20}][.*{1,20}]@*{1,20}[.*{2,6}]",
					greedy: false,
					onBeforePaste: function(pastedValue, opts) {
						pastedValue = pastedValue.toLowerCase();
						return pastedValue.replace("mailto:", "");
					},
					definitions: {
						'*': {
							validator: "[0-9A-Za-z!#$%&'*+/=?^_`{|}~\-]",
							casing: "lower"
						}
					}
				});
				$('#DTE_Field_dognet_sppostav-contactemail3').inputmask({
					mask: "*{1,20}[.*{1,20}][.*{1,20}][.*{1,20}]@*{1,20}[.*{2,6}][.*{1,2}]",
					greedy: false,
					onBeforePaste: function(pastedValue, opts) {
						pastedValue = pastedValue.toLowerCase();
						return pastedValue.replace("mailto:", "");
					},
					definitions: {
						'*': {
							validator: "[0-9A-Za-z!#$%&'*+/=?^_`{|}~\-]",
							casing: "lower"
						}
					}
				});

				$('#DTE_Field_dognet_sppostav-contacttel1').inputmask("8 (999) 999-9999 доб. 999", {
					greedy: false
				});
				$('#DTE_Field_dognet_sppostav-contactmob1').inputmask("+9{1,2} (999) 999-9999", {
					greedy: false
				});

				$('#DTE_Field_dognet_sppostav-contacttel2').inputmask("8 (999) 999-9999 доб. 999", {
					greedy: false
				});
				$('#DTE_Field_dognet_sppostav-contactmob2').inputmask("+9{1,2} (999) 999-9999", {
					greedy: false
				});

				$('#DTE_Field_dognet_sppostav-contacttel3').inputmask("8 (999) 999-9999 доб. 999", {
					greedy: false
				});
				$('#DTE_Field_dognet_sppostav-contactmob3').inputmask("+9{1,2} (999) 999-9999", {
					greedy: false
				});
			});
	});
</script>
<?php
// ----- ----- ----- ----- -----
// Подключаем форму и выводим таблицу поставщиков
// :::
include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/zayvsp/zayvsp-details/restr_1/tabs/forms/zayvsp-details-tab_postav-customForm.php");
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/zayvsp/zayvsp-details/restr_1/tabs/css/zayvsp-details-tab_postav.css">
<section>
	<div id="zayvsp-details-tab_postav" class="">
		<div class="space20"></div>
		<div class="">
			<div class="demo-html"></div>
			<table id="zayvsp-details-tab_postav-table" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th><span class='glyphicon glyphicon-option-vertical'></span></th>
						<th>Название (краткое)</th>
						<th>Контакт (DocNET)</th>
						<th>Email (DocNET)</th>
						<th>Телефон (DocNET)</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</section>