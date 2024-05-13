<script type="text/javascript" language="javascript" class="init">
	//
	//
	var editor_tab4_avans; // use a global for the submit and return data rendering in the examples
	var table_tab4_avans; // use a global for the submit and return data rendering in the examples
	//
	//
	var reqField_sendMail = {
		sendMail: function(response) {}
	};

	function ajaxRequest_sendMail(docnumber, dateavans, summaavans, responseHandler) {
		var response = false;
		// Fire off the request to /form.php
		request = $.ajax({
			url: "php/examples/simple/chetview/chetview-edit/restr_5/tabs/php/sendMail_onSubmit-newAvans.php",
			type: "post",
			cache: false,
			data: {
				docnumber: docnumber,
				dateavans: dateavans,
				summaavans: summaavans
			},
			success: reqField_sendMail[responseHandler]
		});
		// Callback handler that will be called on success
		request.done(function(response, textStatus, jqXHR) {
			res1 = response.replace(new RegExp("\\r?\\n", "g"), "");
			console.log("response: " + response);
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

	$(document).ready(function() {

		// АВАНСЫ : форма редактирования
		editor_tab4_avans = new $.fn.dataTable.Editor({
			display: "bootstrap",
			ajax: "php/examples/simple/chetview/chetview-edit/restr_5/tabs/process/dognet-chetview-edit-tab4_avans-process.php",
			table: "#chetview-edit-tab4_avans",
			i18n: {
				create: {
					title: "<h3>Добавить новый аванс</h3>"
				},
				edit: {
					title: "<h3>Изменить аванс</h3>"
				},
				remove: {
					button: "Удалить",
					title: "<h3>Удалить аванс</h3>",
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
					months: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август',
						'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'
					],
					weekdays: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб']
				}
			},
			template: '#customForm_tab4_avans',
			fields: [{
				label: "Описание аванса :",
				name: "dognet_docavans.nameavans"
			}, {
				label: "Дата :",
				name: "dognet_docavans.dateavans",
				type: "datetime",
				format: "DD.MM.YYYY",
				def: function() {
					return new Date();
				},
				attr: {
					readonly: "readonly"
				}
			}, {
				label: "Этап:",
				name: "dognet_docavans.koddoc",
				type: "select",
				placeholder: "Выберите этап"
			}, {
				label: "Сумма :",
				name: "dognet_docavans.summaavans"
			}, {
				label: "Комментарий :",
				name: "dognet_docavans.comment"
			}]
		});
		//
		// Изменяем размер диалогового окна редактирования договора субподряда
		editor_tab4_avans.on('open', function() {
			$(".modal-dialog").css({
				"width": "60%",
				"min-width": "800px",
				"max-width": "1170px"
			});
		});
		editor_tab4_avans.on('close', function() {
			$(".modal-dialog").css({
				"width": "60%",
				"min-width": "none",
				"max-width": "none"
			});
		});
		//
		// АВАНСЫ : таблица
		table_tab4_avans = $('#chetview-edit-tab4_avans').DataTable({
			dom: "<'row'<'col-md-8 col-sm-12'B><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'>>",
			// 		dom: "t",
			language: {
				url: "php/examples/simple/chetview/chetview-edit/dt_russian-tab4_avans.json"
			},
			ajax: {
				url: "php/examples/simple/chetview/chetview-edit/restr_5/tabs/process/dognet-chetview-edit-tab4_avans-process.php",
				type: "POST"
			},
			serverSide: true,
			columns: [{
					data: null,
					class: "details-control",
					searchable: false,
					orderable: false,
					defaultContent: "<span class='glyphicon glyphicon-option-vertical'></span>"
				},
				{
					data: "dognet_docbase.kodshab",
					render: function(data, type, row) {
						if (data === "1") {
							if (type === 'display') {
								return '';
							}
							return row.dognet_dockalplan.numberstage;
						} else {
							if (type === 'display') {
								return '';
							}
							return row.dognet_docbase.docnumber;
						}
					}
				},
				{
					data: "dognet_docavans.dateavans"
				},
				{
					data: "dognet_docavans.kodavans"
				},
				{
					data: "dognet_docavans.summaavans"
				},
				{
					data: "dognet_docavans_ostatok.ostatokavans"
				}
			],
			select: {
				style: 'single',
				selector: 'td:first-child'
			},
			columnDefs: [{
					orderable: false,
					searchable: false,
					targets: 0
				},
				{
					orderable: true,
					visible: false,
					searchable: false,
					targets: 1
				},
				{
					orderable: false,
					searchable: false,
					type: "date",
					/*
									render: function ( data ) {
										if (data instanceof Date) { return moment(data, 'YYYY-MM-DD').format('DD.MM.YYYY');	}
										else { return "---"; }
									},
					*/
					render: function(data) {
						return data;
					},
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
							return $.fn.dataTable.render.number(' ', ',', 2, '').display(data) + row
								.dognet_spdened.short_code;
						} else {
							return "0.00" + row.dognet_spdened.short_code;
						}
					},
					targets: 4
				},
				{
					orderable: false,
					searchable: false,
					render: function(data, type, row, meta) {
						if (data != null) {
							return $.fn.dataTable.render.number(' ', ',', 2, '').display(data) + row
								.dognet_spdened.short_code;
						} else {
							return "0.00" + row.dognet_spdened.short_code;
						}
					},
					targets: 5
				}
			],
			order: [
				[2, "desc"]
			],
			select: true,
			processing: true,
			paging: false,
			searching: false,
			lengthChange: false,
			rowGroup: {
				dataSrc: function(row) {
					if (row.dognet_docbase.kodshab === "1") {
						return "Этап " + row.dognet_dockalplan.numberstage;
					} else {
						return "Счет # " + row.dognet_docbase.numberchet + " (без календарного плана)";
					}
				},
				startRender: function(rows, group) {
					return group;
				},
				endRender: null,
				emptyDataGroup: 'Нет категорий для группировки...'
			},
			buttons: [{
					text: '<span class="glyphicon glyphicon-refresh"></span>',
					action: function(e, dt, node, config) {
						table_tab4_avans.columns().search('').draw();
					}
				},
				{
					extend: "create",
					editor: editor_tab4_avans,
					text: "НОВЫЙ АВАНС",
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
					editor: editor_tab4_avans,
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
					editor: editor_tab4_avans,
					text: "УДАЛИТЬ",
					formButtons: ['Удалить',
						{
							text: 'Отмена',
							action: function() {
								this.close();
							}
						}
					]
				}
			],
			initComplete: function() {

			},
			drawCallback: function() {

			}
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		//
		//
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		editor_tab4_avans.on('submitSuccess', function(e, json, data, action) {
			if (action === "create") {
				// осуществляем глубокое копирование объекта и инициализируем переменную
				let newObj = JSON.parse(JSON.stringify(json));
				_docnumber = newObj.data[0].dognet_docbase.numberchet;

				_dateavans = newObj.data[0].dognet_docavans.dateavans;

				_summaavans = newObj.data[0].dognet_docavans.summaavans;
				_summaavans = $.fn.dataTable.render.number(' ', ',', 2, '').display(_summaavans) + newObj
					.data[0]
					.dognet_spdened.short_code

				ajaxRequest_sendMail(_docnumber, _dateavans, _summaavans, 'sendMail');

			}
		});
		//
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		// Array to track the ids of the edit displayed rows
		var detailRows = [];

		$('#chetview-edit-tab4_avans tbody').on('click', 'tr td.details-control', function() {
			var tr = $(this).closest('tr');
			var row = table_tab4_avans.row(tr);
			var idx = $.inArray(tr.attr('id'), detailRows);

			if (row.child.isShown()) {
				tr.removeClass('edit');
				row.child.hide();

				// Remove from the 'open' array
				detailRows.splice(idx, 1);
			} else {
				tr.addClass('edit');
				rowData = table_tab4_avans.row(row);
				d = row.data();
				rowData.child(<?php include('templates/chetview-edit_tab4_avans.tpl'); ?>).show();

				// Add to the 'open' array
				if (idx === -1) {
					detailRows.push(tr.attr('id'));
				}
			}
		});
		// On each draw, loop over the `detailRows` array and show any child rows
		table_tab4_avans.on('draw', function() {
			$.each(detailRows, function(i, id) {
				$('#' + id + ' td.details-control').trigger('click');
			});
		});

	});
</script>
<?php
// ----- ----- ----- ----- -----
// Форма редактирования этапа
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/chetview/chetview-edit/restr_5/tabs/css/chetview-edit-tab4_avans.css">
<div id="customForm_tab4_avans">
	<div class="Section">
		<div class="Block100">
			<legend>Подсказки и помощь</legend>
		</div>
		<div class="Block100">
			<legend>Авансовые платежи</legend>
			<fieldset class="field30">
				<editor-field name="dognet_docavans.koddoc"></editor-field>
			</fieldset>
			<fieldset class="field20">
				<editor-field name="dognet_docavans.dateavans"></editor-field>
			</fieldset>
			<fieldset class="field60">
				<editor-field name="dognet_docavans.nameavans"></editor-field>
			</fieldset>
			<fieldset class="field20">
				<editor-field name="dognet_docavans.summaavans"></editor-field>
			</fieldset>
		</div>
		<div class="Block100">
			<fieldset class="field100">
				<editor-field name="dognet_docavans.comment"></editor-field>
			</fieldset>
		</div>
	</div>
</div>
<?php
// ----- ----- ----- ----- -----
// Таблица этапов
// :::
?>
<section>
	<div id="chetview-tab4_avans" class="" style="padding:0 5px">
		<div class="space30"></div>
		<div class="demo-html"></div>
		<table id="chetview-edit-tab4_avans" class="table table-bordered table-striped" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
					<th></th>
					<th class="text-center text-uppercase">Дата</th>
					<th class="text-left text-uppercase">ID аванса</th>
					<th class="text-uppercase">Сумма</th>
					<th class="text-uppercase">Незачтенный остаток</th>
				</tr>
			</thead>
		</table>
	</div>
</section>