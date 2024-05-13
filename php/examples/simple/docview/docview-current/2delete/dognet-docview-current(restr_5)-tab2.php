<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/date-de.js"></script>
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/moment-with-locales.js"></script>

<!-- Custom Table style -->
<link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/css/docview-table-current-tab2-custom.css">
<!-- Custom Form Editor style -->
<link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/css/docview-customForm-current-tab2-Editor.css">

<script type="text/javascript" language="javascript" class="init">
	var editor_tab2; // use a global for the submit and return data rendering in the examples
	var table_tab2; // use a global for the submit and return data rendering in the examples

	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	//
	//
	function format(d) {

		return '<div class="space20"></div>' +
			'<div id="row-details">' +
			'<div class="row space20">' +
			'<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">' +
			'<div id="row-details-docnamefull" class="media">' +
			'<div class="media-left media-middle text-nowrap">' +
			'</div>' +
			'<div class="media-body media-middle">' +
			'<h4 class="details-docnamefull">' + d.dognet_docbase.docnamefullm + '</h4>' +
			'</div>' +
			'</div>' +
			'</div>' +
			'</div>' +
			/*
				'<div class="row space20">'+
					'<div class="col-xs-12 col-sm-8 col-md-9 col-lg-9">'+
						'<div class="media">'+
							'<div class="media-left media-middle text-nowrap">'+
								'<span class="details-docID" style="font-size:3.0em">3-4/'+d.dognet_docbase.docnumber+'</span>'+
							'</div>'+
							'<div class="media-body media-middle">'+
								'<h3 class="details-docAbout">'+d.dognet_docbase.docnamefullm+'</h3>'+
							'</div>'+
						'</div>'+
					'</div>'+
					'<div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">'+
						
					'</div>'+
				'</div>'+
			*/
			'<div class="row space20">' +
			'<div class="hidden-xs col-sm-5 col-md-5 col-lg-5">' +
			'<div class="media">' +
			'<div class="media-left media-middle">' +
			'<span class="" style="font-size:2.5em"><span class="glyphicon glyphicon-list-alt"></span></span>' +
			'</div>' +
			'<div class="media-body media-middle">' +
			'<h4>Общая информация</h4>' +
			'</div>' +
			'</div>' +
			'<table id="row-details-table1" class="table table-condensed table-striped" >' +
			'<tbody>' +
			'<tr>' +
			'<td width="30%" class="text-uppercase" style="border-top:none; font-size:2.0em">№ :</td>' +
			'<td class="" style="border-top:none"><span class="" style="font-size:2.0em; font-weight:500">3-4/' + d.dognet_docbase.docnumber + '</span></td>' +
			'</tr>' +
			'<tr>' +
			'<td width="30%" class="text-uppercase" style="border-top:none">Название :</td>' +
			'<td class="" style="border-top:none"><span class="" style="font-weight:500">' + d.dognet_docbase.docnameshot + '</span></td>' +
			'</tr>' +
			'<tr>' +
			'<td width="30%" class="text-uppercase" style="border-top:none">Тип :</td>' +
			'<td class="" style="border-top:none"><span class="" style="font-weight:500">' + d.dognet_sptipdog.nametip + '</span></td>' +
			'</tr>' +
			'<tr>' +
			'<td width="30%" class="text-uppercase" style="border-top:none">Статус :</td>' +
			'<td class="" style="border-top:none"><span class="" style="font-weight:500">' + d.dognet_spstatus.statusnameshot + '</span></td>' +
			'</tr>' +
			'</tbody>' +
			'</table>' +
			'<div class="media">' +
			'<div class="media-left media-middle">' +
			'<span class="" style="font-size:2.5em"><span class="glyphicon glyphicon-home"></span></span>' +
			'</div>' +
			'<div class="media-body media-middle">' +
			'<h4>Объект и заказчик</h4>' +
			'</div>' +
			'</div>' +
			'<table id="row-details-table1" class="table table-condensed table-striped" >' +
			'<tbody>' +
			'<tr>' +
			'<td width="30%" class="text-uppercase" style="border-top:none">Объект :</td>' +
			'<td class="text-capitalize" style="border-top:none"><span class="" style="font-weight:500">' + d.sp_objects.nameobjectshot + '</span></td>' +
			'</tr>' +
			'<tr>' +
			'<td width="30%" class="text-uppercase" style="border-top:none">Заказчик :</td>' +
			'<td class="" style="border-top:none"><span class="" style="font-weight:500">' + d.sp_contragents.nameshort + '</span></td>' +
			'</tr>' +
			'</tbody>' +
			'</table>' +
			'<div class="media">' +
			'<div class="media-left media-middle">' +
			'<span class="" style="font-size:2.5em"><span class="glyphicon glyphicon-calendar"></span></span>' +
			'</div>' +
			'<div class="media-body media-middle">' +
			'<h4>Тайминг</h4>' +
			'</div>' +
			'</div>' +
			'<table id="row-details-table-dates" class="table table-condensed table-striped" >' +
			'<tbody>' +
			'<tr>' +
			'<td width="30%" class="text-uppercase" style="border-top:none">Дата начала :</td>' +
			'<td class="" style="border-top:none"><span class="">' + d.dognet_docbase.daynachdoc + '.' + d.dognet_docbase.monthnachdoc + '.' + d.dognet_docbase.yearnachdoc + '</span></td>' +
			'</tr>' +
			'<tr>' +
			'<td width="30%" class="text-uppercase" style="border-top:none">Дата окончания :</td>' +
			'<td class="" style="border-top:none"><span class="">' + d.dognet_docbase.dayenddoc + '.' + d.dognet_docbase.monthenddoc + '.' + d.dognet_docbase.yearenddoc + '</span></td>' +
			'</tr>' +
			'</tbody>' +
			'</table>' +
			'</div>' +
			'<div class="hidden-xs col-sm-7 col-md-7 col-lg-7">' +
			'<div class="media">' +
			'<div class="media-left media-middle">' +
			'<span class="" style="font-size:2.5em"><span class="glyphicon glyphicon-ruble"></span></span>' +
			'</div>' +
			'<div class="media-body media-middle">' +
			'<h4>Финансы</h4>' +
			'</div>' +
			'</div>' +
			'<div class="hidden-xs col-sm-6 col-md-6 col-lg-6" style="padding-left:0">' +
			'<table id="row-details-table-finance" class="table table-condensed table-striped" >' +
			'<tbody>' +
			'<tr>' +
			'<td width="55%" class="text-uppercase" style="border-top:none">Сумма :</td>' +
			'<td class="" style="border-top:none"><span class="">' + $.fn.dataTable.render.number(' ', ',', 2, '').display(d.dognet_docbase.docsumma) + '</span></td>' +
			'</tr>' +
			'<tr>' +
			'<td width="55%" class="text-uppercase" style="border-top:none">Сумма С/Ф :</td>' +
			'<td class="" style="border-top:none"><span class="">' + $.fn.dataTable.render.number(' ', ',', 2, '').display(d.dognet_docbase.summachf) + '</span></td>' +
			'</tr>' +
			'<tr>' +
			'<td width="55%" class="text-uppercase" style="border-top:none">Оплата :</td>' +
			'<td class="" style="border-top:none"><span class="">' + $.fn.dataTable.render.number(' ', ',', 2, '').display(d.dognet_docbase.docoplata) + '</span></td>' +
			'</tr>' +
			'<tr>' +
			'<td width="55%" class="text-uppercase" style="border-top:none">Аванс :</td>' +
			'<td class="" style="border-top:none"><span class="">' + $.fn.dataTable.render.number(' ', ',', 2, '').display(d.dognet_docbase.docavans) + '</span></td>' +
			'</tr>' +
			'<tr>' +
			'<td width="55%" class="text-uppercase" style="border-top:none">Задолженность :</td>' +
			'<td class="" style="border-top:none"><span class="">' + $.fn.dataTable.render.number(' ', ',', 2, '').display(d.dognet_docbase.doczadol) + '</span></td>' +
			'</tr>' +
			'<tr>' +
			'<td width="55%" class="text-uppercase" style="border-top:none">Незакрыто :</td>' +
			'<td class="" style="border-top:none"><span class="">' + $.fn.dataTable.render.number(' ', ',', 2, '').display(d.dognet_docbase.docnozak) + '</span></td>' +
			'</tr>' +
			'</tbody>' +
			'</table>' +
			'</div>' +
			'<div class="hidden-xs col-sm-6 col-md-6 col-lg-6" style="padding-right:0">' +
			'<table id="row-details-table-finance" class="table table-condensed table-striped" >' +
			'<tbody>' +
			'<tr>' +
			'<td width="55%" class="text-uppercase" style="border-top:none">Сумма :</td>' +
			'<td class="" style="border-top:none"><span class="">' + $.fn.dataTable.render.number(' ', ',', 2, '').display(d.dognet_docbase.docsumma) + '</span></td>' +
			'</tr>' +
			'<tr>' +
			'<td width="55%" class="text-uppercase" style="border-top:none">Сумма С/Ф :</td>' +
			'<td class="" style="border-top:none"><span class="">' + $.fn.dataTable.render.number(' ', ',', 2, '').display(d.dognet_docbase.summachf) + '</span></td>' +
			'</tr>' +
			'<tr>' +
			'<td width="55%" class="text-uppercase" style="border-top:none">Оплата :</td>' +
			'<td class="" style="border-top:none"><span class="">' + $.fn.dataTable.render.number(' ', ',', 2, '').display(d.dognet_docbase.docoplata) + '</span></td>' +
			'</tr>' +
			'<tr>' +
			'<td width="55%" class="text-uppercase" style="border-top:none">Аванс :</td>' +
			'<td class="" style="border-top:none"><span class="">' + $.fn.dataTable.render.number(' ', ',', 2, '').display(d.dognet_docbase.docavans) + '</span></td>' +
			'</tr>' +
			'<tr>' +
			'<td width="55%" class="text-uppercase" style="border-top:none">Задолженность :</td>' +
			'<td class="" style="border-top:none"><span class="">' + $.fn.dataTable.render.number(' ', ',', 2, '').display(d.dognet_docbase.doczadol) + '</span></td>' +
			'</tr>' +
			'<tr>' +
			'<td width="55%" class="text-uppercase" style="border-top:none">Незакрыто :</td>' +
			'<td class="" style="border-top:none"><span class="">' + $.fn.dataTable.render.number(' ', ',', 2, '').display(d.dognet_docbase.docnozak) + '</span></td>' +
			'</tr>' +
			'</tbody>' +
			'</table>' +
			'</div>' +
			'</div>' +
			'<div class="hidden-xs col-sm-12 col-md-7 col-lg-7">' +
			'<div class="media">' +
			'<div class="media-left media-middle">' +
			'<span class="" style="font-size:2.5em"><span class="glyphicon glyphicon-user"></span></span>' +
			'</div>' +
			'<div class="media-body media-middle">' +
			'<h4>Исполнители</h4>' +
			'</div>' +
			'</div>' +
			'<table id="row-details-table2" class="table table-condensed table-striped" >' +
			'<tbody>' +
			'<tr>' +
			'<td width="35%" class="text-uppercase" style="border-top:none">Исполнитель (руководство) :</td>' +
			'<td class="" style="border-top:none"><span class="">' + d.dognet_spispolruk.ispolruknamefull + '</span></td>' +
			'<td class="" style="border-top:none"><span class="">' + d.dognet_spispolruk.ispolrukemail + '</span></td>' +
			'</tr>' +
			'<tr>' +
			'<td width="35%" class="text-uppercase" style="border-top:none">Исполнитель :</td>' +
			'<td class="" style="border-top:none"><span class="">' + d.dognet_spispol.ispolnamefull + '</span></td>' +
			'<td class="" style="border-top:none"><span class="">' + d.dognet_spispol.ispolmail + '</span></td>' +
			'</tr>' +
			'</tbody>' +
			'</table>' +
			'</div>' +
			'<div class="hidden-xs col-sm-12 col-md-12 col-lg-12">' +
			'<div class="media">' +
			'<div class="media-left media-middle">' +
			'<span class="" style="font-size:2.5em"><span class="glyphicon glyphicon-comment"></span></span>' +
			'</div>' +
			'<div class="media-body media-middle">' +
			'<h4>Комментарии</h4>' +
			'</div>' +
			'</div>' +
			'<table id="row-details-table2" class="table table-condensed table-striped" >' +
			'<tbody>' +
			'<tr>' +
			'<td width="35%" class="text-uppercase" style="border-top:none">Последний комментарий :</td>' +
			'<td class="" style="border-top:none"><span class="">' + d.dognet_spispolruk.ispolruknamefull + '</span></td>' +
			'</tr>' +
			'</tbody>' +
			'</table>' +
			'</div>' +
			'</div>' +
			'</div>' +
			'<div class="space20"></div>';
	}

	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

	$(document).ready(function() {

		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		editor_tab2 = new $.fn.dataTable.Editor({
			"display": "bootstrap",
			"ajax": "php/examples/php/docview/docview-current/dognet-docview-current-tab2-process.php",
			"table": "#docview-current-tab2",
			"template": '#customForm_tab2',
			"fields": [{
				"label": "Исполнитель :",
				"name": "dognet_spispol.ispolnameshot"
			}, {
				"label": "№ :",
				"name": "dognet_docbase.docnumber"
			}, {
				"label": "Название (краткое) :",
				"name": "dognet_docbase.docnameshot"
			}, {
				"label": "Название (полное) :",
				"type": "textarea",
				"name": "dognet_docbase.docnamefullm"
			}, {
				"label": "Шаблон договора :",
				"type": "select",
				"name": "crt_shablon",
				"options": [{
						"label": "Договор с календарным планом",
						"value": "1"
					},
					{
						"label": "Договор без календарного плана",
						"value": "2"
					}
				],
				"placeholder": '---'
			}, {
				"label": "Основание :",
				"type": "select",
				"name": "crt_osnovanie",
				"options": [{
						"label": "Бланк требований (отс)",
						"value": "1"
					},
					{
						"label": "Бланк требований (нал)",
						"value": "2"
					},
					{
						"label": "Указание руководства",
						"value": "3"
					},
					{
						"label": "Импорт пл",
						"value": "4"
					}
				],
				"placeholder": '---'
			}, {
				"label": "Статус договора :",
				"name": "dognet_docbase.kodstatus",
				"type": "select",
				"placeholder": '---'
			}, {
				"label": "Объект договора :",
				"name": "dognet_docbase.kodobject",
				"type": "select",
				"placeholder": '---'
			}, {
				"label": "Заказчик по договору :",
				"name": "dognet_docbase.kodzakaz",
				"type": "select",
				"placeholder": '---'
			}, {
				"label": "Исполнитель (от руководства) :",
				"name": "dognet_docbase.kodispolruk",
				"type": "select",
				"placeholder": '---'
			}, {
				"label": "Исполнитель :",
				"name": "dognet_docbase.kodispol",
				"type": "select",
				"placeholder": '---'
			}, {
				"label": "Начало :",
				"name": "dognet_docbase.date_nach_tmp",
				"type": "datetime",
				"format": "DD.MM.YYYY",
				"opts": {
					"yearRange": 15
				}
			}, {
				"label": "День :",
				"name": "dognet_docbase.daynachdoc"
			}, {
				"label": "Месяц :",
				"name": "dognet_docbase.monthnachdoc"
			}, {
				"label": "Год :",
				"name": "dognet_docbase.yearnachdoc"
			}, {
				"label": "Окончание (план) :",
				"name": "dognet_docbase.date_end_tmp",
				"type": "datetime",
				"format": "DD.MM.YYYY",
				"opts": {
					"yearRange": 15
				}
			}, {
				"label": "День :",
				"name": "dognet_docbase.dayenddoc"
			}, {
				"label": "Месяц :",
				"name": "dognet_docbase.monthenddoc"
			}, {
				"label": "Год :",
				"name": "dognet_docbase.yearenddoc"
			}, {
				"label": "Тип договора :",
				"name": 'dognet_docbase.kodtip',
				"type": "select",
				"placeholder": 'Тип договора'
			}]
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

		editor_tab2.on('initEdit', function(e, node, data, items, type) {
			var dt1 = new Date();
			var nachDay = editor_tab2.field('dognet_docbase.daynachdoc').get();
			var nachMonth = editor_tab2.field('dognet_docbase.monthnachdoc').get();
			var nachYear = editor_tab2.field('dognet_docbase.yearnachdoc').get();
			dt1.setFullYear(nachYear, nachMonth - 1, nachDay);
			editor_tab2.field('dognet_docbase.date_nach_tmp').set(dt1);
			var dt2 = new Date();
			var nachDay = editor_tab2.field('dognet_docbase.dayenddoc').get();
			var nachMonth = editor_tab2.field('dognet_docbase.monthenddoc').get();
			var nachYear = editor_tab2.field('dognet_docbase.yearenddoc').get();
			dt2.setFullYear(nachYear, nachMonth - 1, nachDay);
			editor_tab2.field('dognet_docbase.date_end_tmp').set(dt2);
		});
		// ----- ----- ----- 
		editor_tab2.dependent('dognet_docbase.date_nach_tmp', function(val) {
			editor_tab2.field('dognet_docbase.daynachdoc').set(moment(val, 'DD.MM.YYYY').format('DD'));
			editor_tab2.field('dognet_docbase.monthnachdoc').set(moment(val, 'DD.MM.YYYY').format('MM'));
			editor_tab2.field('dognet_docbase.yearnachdoc').set(moment(val, 'DD.MM.YYYY').format('YYYY'));
		});
		editor_tab2.dependent('dognet_docbase.date_end_tmp', function(val) {
			editor_tab2.field('dognet_docbase.dayenddoc').set(moment(val, 'DD.MM.YYYY').format('DD'));
			editor_tab2.field('dognet_docbase.monthenddoc').set(moment(val, 'DD.MM.YYYY').format('MM'));
			editor_tab2.field('dognet_docbase.yearenddoc').set(moment(val, 'DD.MM.YYYY').format('YYYY'));
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		// Activate an inline edit on click of a table cell
		$('#docview-current-tab2').on('dblclick', 'tbody td:not(:first-child)', function(e) {

			var index = $(this).index();

			if (index === 1) {
				editor_tab2.bubble(this, ['dognet_docbase.docnameshot'], {
					submitOnBlur: false
				});
			} else if (index === 4) {
				editor_tab2.bubble(this, [
					'dognet_docbase.docnumber',
					'dognet_docbase.kodtip',
					'dognet_docbase.kodstatus'
				], {
					submitOnBlur: false,
					title: 'Общая информация о договоре',
					buttons: false
				});
			} else if (index === 5) {
				editor_tab2.bubble(this, [
					'dognet_docbase.kodobject',
					'dognet_docbase.kodzakaz'
				], {
					submitOnBlur: false,
					title: 'Объект и заказчик',
					buttons: false
				});
			} else if (index === 6) {
				editor_tab2.bubble(this, [
					'dognet_docbase.kodtip'
				], {
					submitOnBlur: false,
					title: 'Тайминг',
					buttons: false
				});
			}
		});

		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		editor_tab2.on('initCreate', function() {
			editor_tab2.dependent('crt_shablon', function(val) {
				if (val != 0) {
					editor_tab2.dependent('crt_osnovanie', function(val) {
						if (val != 0) {
							$("#mainsection").show();
						} else {
							$("#mainsection").hide();
						}
					});
				} else {
					$("#mainsection").hide();
				}
			});
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		editor_tab2.on('initEdit', function() {
			$("#presection").hide();
			$("#mainsection").show();
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

		// Activate an inline edit on click of a table cell
		/*
		    $('#row-details').on( 'click', 'tbody td:not(:first-child)', function (e) {
		        editor_tab2.inline( this );
		    } );
		*/

		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		table_tab2 = $('#docview-current-tab2').DataTable({
			// 		dom: "<'row'<'col-md-8 col-sm-12'><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'lftip>>",
			dom: "<'space50'Br>lftip",
			language: {
				url: "russian.json"
			},
			ajax: {
				url: "php/examples/php/docview/docview-current/dognet-docview-current-tab2-process.php",
				type: "POST"
			},
			serverSide: true,
			columns: [{
					class: "details-control",
					searchable: false,
					orderable: false,
					data: null,
					defaultContent: "<span class='glyphicon glyphicon-option-vertical'></span>",
					className: "center"
				},
				{
					data: "dognet_docbase.docnumber",
					className: "text-center"
				},
				{
					data: "dognet_docbase.docnameshot"
				},
				{
					data: null,
					defaultContent: '<a href="#" class="edit_listalt"><span class="glyphicon glyphicon-list-alt"></span></a>',
					orderable: false
				},
				{
					data: null,
					defaultContent: '<a href="#" class="edit_home"><span class="glyphicon glyphicon-home"></span></a>',
					orderable: false
				},
				{
					data: null,
					defaultContent: '<a href="#" class="edit_calendar"><span class="glyphicon glyphicon-calendar"></span></a>',
					orderable: false
				}
			],
			select: {
				style: 'os',
				selector: 'td:not(:last-child)' // no row selection on last column
			},
			columnDefs: [{
					orderable: false,
					targets: 0
				},
				{
					orderable: true,
					targets: 1
				},
				{
					orderable: false,
					targets: 2
				},
				{
					orderable: false,
					targets: 3
				},
				{
					orderable: false,
					targets: 4
				},
				{
					orderable: false,
					targets: 5
				}
			],
			order: [
				[1, "desc"]
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
					extend: "create",
					editor: editor_tab2,
					text: "НОВЫЙ"
				},
				{
					extend: "edit",
					editor: editor_tab2,
					text: "ИЗМЕНИТЬ"
				},
				{
					extend: "remove",
					editor: editor_tab2,
					text: "УДАЛИТЬ"
				}
			]
		});

		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
		// Array to track the ids of the details displayed rows
		var detailRows = [];

		$('#docview-current-tab2 tbody').on('click', 'tr td.details-control', function() {
			var tr = $(this).closest('tr');
			var row = table_tab2.row(tr);
			var idx = $.inArray(tr.attr('id'), detailRows);

			if (row.child.isShown()) {
				tr.removeClass('details');
				row.child.hide();

				// Remove from the 'open' array
				detailRows.splice(idx, 1);
			} else {
				tr.addClass('details');
				row.child(format(row.data())).show();

				// Add to the 'open' array
				if (idx === -1) {
					detailRows.push(tr.attr('id'));
				}
			}
		});
		// On each draw, loop over the `detailRows` array and show any child rows
		table_tab2.on('draw', function() {
			$.each(detailRows, function(i, id) {
				$('#' + id + ' td.details-control').trigger('click');
			});
		});
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 


		editor_tab2.on('open', function(e, mode, action) {
			$('div.DTE_Bubble').addClass('myBubble');
			$('div.DTE_Bubble_Triangle').addClass('myBubble_Triangle');
		});

	});
</script>

<style>
	.myBubble {
		/* 	position:relative; */
		z-index: 11;
		/* 	margin: 0 -45%; */
		opacity: 0;
		margin: 1.0em auto;
		float: none;
		width: 75%;
	}

	.myBubble_Triangle {
		display: none;
	}

	#customForm_tab2 div.DTE_Field label {
		display: block
	}

	/* FLEXBLOCK A */
	#flexblockA {
		display: flex;
		flex-flow: row wrap;
		flex-grow: 1;
		flex-shrink: 1;
		flex-basis: 100%;
		align-content: flex-start;
	}

	#flexblockA fieldset.labelA1 {
		flex-grow: 2;
		flex-shrink: 0;
		flex-basis: 15%;
	}

	#flexblockA fieldset.labelA2 {
		flex-grow: 1;
		flex-shrink: 2;
		flex-basis: 20%;
	}

	#flexblockA fieldset.labelA3 {
		flex-grow: 1;
		flex-shrink: 2;
		flex-basis: 20%;
	}

	#flexblockA fieldset.labelA4 {
		flex-grow: 1;
		flex-shrink: 2;
		flex-basis: 30%;
	}

	/* FLEXBLOCK B */
	#flexblockB {
		display: flex;
		flex-flow: row wrap;
		flex-grow: 1;
		flex-shrink: 1;
		flex-basis: 100%;
		align-content: flex-start;
	}

	#flexblockB fieldset.labelB1 {
		flex-grow: 0;
		flex-shrink: 0;
		flex-basis: 100%;
	}

	#flexblockB>fieldset.labelB1>div>div {
		width: 100%
	}

	#flexblockB fieldset.labelB2 {
		flex-grow: 0;
		flex-shrink: 0;
		flex-basis: 100%;
	}

	#flexblockB>fieldset.labelB2>div>div {
		width: 100%
	}

	/* FLEXBLOCK C */
	#flexblockC {
		display: flex;
		flex-flow: row wrap;
		flex-grow: 1;
		flex-shrink: 2;
		flex-basis: 100%;
		align-content: flex-start;
	}

	#flexblockC fieldset.labelC1 {
		flex-grow: 2;
		flex-shrink: 1;
		flex-basis: 50%;
	}

	#flexblockC fieldset.labelC2 {
		flex-grow: 2;
		flex-shrink: 1;
		flex-basis: 50%;
	}

	#DTE_Field_dognet_docbase-kodtip,
	#DTE_Field_dognet_docbase-kodstatus {
		min-width: 100%;
		max-width: 100%
	}

	/* FLEXBLOCK D */
	#flexblockD {
		display: flex;
		flex-flow: row wrap;
		flex-grow: 1;
		flex-shrink: 2;
		flex-basis: 100%;
		align-content: flex-start;
	}

	#flexblockD fieldset.labelD1 {
		flex-grow: 0;
		flex-shrink: 0;
		flex-basis: 100%;
	}

	#flexblockD fieldset.labelD2 {
		flex-grow: 0;
		flex-shrink: 0;
		flex-basis: 100%;
	}

	#flexblockD>fieldset.labelD1>div>div,
	#flexblockD>fieldset.labelD2>div>div {
		width: 100%
	}

	#DTE_Field_dognet_docbase-kodobject {
		min-width: 100%;
		max-width: 100%
	}

	/* FLEXBLOCK P */
	#flexblockP {
		display: flex;
		flex-flow: row wrap;
		flex-grow: 1;
		flex-shrink: 2;
		flex-basis: 100%;
		align-content: flex-start;
	}

	#flexblockP fieldset.labelP1 {
		flex-grow: 0;
		flex-shrink: 0;
		flex-basis: 50%;
	}

	#flexblockP fieldset.labelP2 {
		flex-grow: 0;
		flex-shrink: 0;
		flex-basis: 50%;
	}



	#customForm_tab2 .section h3 {
		font-family: 'HeliosCond', sans-serif;
		font-weight: normal;
		text-transform: uppercase
	}

	#customForm_tab2 label.control-label {
		width: 100%
	}

	/* #customForm_tab2 select { width: 100% } */
</style>


<div id="customForm_tab2">

	<div id="presection">
		<div class="hidden-xs col-sm-12 col-md-12 col-lg-12 space20">
			<div class="section">
				<div class="media">
					<div class="media-left media-middle">
						<span class="" style="font-size:2.5em"><span class="glyphicon glyphicon-filter"></span></span>
					</div>
					<div class="media-body media-middle">
						<h3>Условия для создания договора</h3>
					</div>
				</div>
				<div id="flexblockP">
					<fieldset class="labelP1">
						<editor-field name="crt_shablon"></editor-field>
					</fieldset>
					<fieldset class="labelP2">
						<editor-field name="crt_osnovanie"></editor-field>
					</fieldset>
				</div>
			</div>
		</div>
	</div>

	<div id="mainsection">
		<div class="hidden-xs col-sm-7 col-md-7 col-lg-7 space20">
			<div class="section">
				<div class="media">
					<div class="media-left media-middle">
						<span class="" style="font-size:2.5em"><span class="glyphicon glyphicon-list-alt"></span></span>
					</div>
					<div class="media-body media-middle">
						<h3>Общая информация</h3>
					</div>
				</div>
				<div id="flexblockA">
					<fieldset class="labelA1">
						<editor-field name="dognet_docbase.docnumber"></editor-field>
					</fieldset>
					<fieldset class="labelA2">
						<editor-field name="dognet_docbase.date_nach_tmp"></editor-field>
					</fieldset>
					<fieldset class="labelA3">
						<editor-field name="dognet_docbase.date_end_tmp"></editor-field>
					</fieldset>
				</div>
				<div id="flexblockB">
					<fieldset class="labelB1">
						<editor-field name="dognet_docbase.docnameshot"></editor-field>
					</fieldset>
					<fieldset class="labelB2">
						<editor-field name="dognet_docbase.docnamefullm"></editor-field>
					</fieldset>
				</div>
				<div id="flexblockC">
					<fieldset class="labelC1">
						<editor-field name="dognet_docbase.kodtip"></editor-field>
					</fieldset>
					<fieldset class="labelC1">
						<editor-field name="dognet_docbase.kodstatus"></editor-field>
					</fieldset>
				</div>
			</div>
		</div>
		<div class="hidden-xs col-sm-5 col-md-5 col-lg-5 space20">
			<div class="section space20">
				<div class="media">
					<div class="media-left media-middle">
						<span class="" style="font-size:2.5em"><span class="glyphicon glyphicon-home"></span></span>
					</div>
					<div class="media-body media-middle">
						<h3>Объект и заказчик</h3>
					</div>
				</div>
				<div id="flexblockD">
					<fieldset class="labelD1">
						<editor-field name="dognet_docbase.kodobject"></editor-field>
					</fieldset>
					<fieldset class="labelD2">
						<editor-field name="dognet_docbase.kodzakaz"></editor-field>
					</fieldset>
				</div>
			</div>
			<div class="section space20">
				<div class="media">
					<div class="media-left media-middle">
						<span class="" style="font-size:2.5em"><span class="glyphicon glyphicon-user"></span></span>
					</div>
					<div class="media-body media-middle">
						<h3>Исполнители</h3>
					</div>
				</div>
				<div id="flexblockE">
					<fieldset class="labelE1 text-nowrap">
						<editor-field name="dognet_docbase.kodispolruk"></editor-field>
					</fieldset>
					<fieldset class="labelE2">
						<editor-field name="dognet_docbase.kodispol"></editor-field>
					</fieldset>
				</div>
			</div>
		</div>
		<div class="hidden-xs col-sm-6 col-md-6 col-lg-6 space20">
			<div class="section">
				<div class="media">
					<div class="media-left media-middle">
						<span class="" style="font-size:2.5em"><span class="glyphicon glyphicon-calendar"></span></span>
					</div>
					<div class="media-body media-middle">
						<h3>Тайминг</h3>
					</div>
				</div>
				<div class="row">
					<div class="hidden-xs col-sm-6 col-md-6 col-lg-6">
						<div class="" style="border: 1px #333 solid; border-radius: 10px; padding: 10px;">
							<h4>Начало</h4>
							<fieldset class="">
								<editor-field name="dognet_docbase.daynachdoc"></editor-field>
							</fieldset>
							<fieldset class="">
								<editor-field name="dognet_docbase.monthnachdoc"></editor-field>
							</fieldset>
							<fieldset class="">
								<editor-field name="dognet_docbase.yearnachdoc"></editor-field>
							</fieldset>
						</div>
					</div>
					<div class="hidden-xs col-sm-6 col-md-6 col-lg-6">
						<div class="" style="border: 1px #333 solid; border-radius: 10px; padding: 10px;">
							<h4>Конец</h4>
							<fieldset class="">
								<editor-field name="dognet_docbase.dayenddoc"></editor-field>
							</fieldset>
							<fieldset class="">
								<editor-field name="dognet_docbase.monthenddoc"></editor-field>
							</fieldset>
							<fieldset class="">
								<editor-field name="dognet_docbase.yearenddoc"></editor-field>
							</fieldset>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="hidden-xs col-sm-6 col-md-6 col-lg-6 space20">

		</div>
	</div>
</div>


<div class="container">
	<section>
		<div class="demo-html"></div>
		<table id="docview-current-tab2" class="table table-condensed" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th width="2%" class="text-center"></th>
					<th width="5%" class="text-center">№</th>
					<th>Краткое название</th>
					<th width="2%" class="text-center"></th>
					<th width="2%" class="text-center"></th>
					<th width="2%" class="text-center"></th>
				</tr>
			</thead>
		</table>
	</section>
</div>