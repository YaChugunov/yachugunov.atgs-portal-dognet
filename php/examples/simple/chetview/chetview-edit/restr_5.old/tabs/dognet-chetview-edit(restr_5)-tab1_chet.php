
<script type="text/javascript" language="javascript" class="init">

function addZero(digits_length, source){
    var text = source + '';
    while(text.length < digits_length)
        text = '0' + text;
    return text;
}

var editor_tab1_chet;		// use a global for the submit and return data rendering in the examples
var table_tab1_chet;		// use a global for the submit and return data rendering in the examples

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

$(document).ready(function() {
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	editor_tab1_chet = new $.fn.dataTable.Editor( {
		display: "bootstrap",
		ajax: "php/examples/php/chetview/chetview-edit/dognet-chetview-edit-tab1_chet-process.php",
		table: "#chetview-edit-tab1_chet",
    i18n: {
        create: { title: "<h3>Создать новый счет</h3>" },
        edit: { title: "<h3>Редактировать счет</h3>" },
        remove: {
	        title: "<h3>Удалить счет</h3>",
					confirm: {
            "_": "Вы уверены, что хотите удалить %d записи(ей)?",
            "1": "Вы уверены, что хотите удалить этот счет?"
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
            next:     'След',
            months:   [ 'Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь' ],
            weekdays: [ 'Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб' ]
        }
    },
		template: '#customForm_tab1_chet',
		fields: [
			{
				label: "Номер :",
				name: "dognet_docbase.docnumber"
			}, {
				label: "Шаблон :",
				name: "dognet_docbase.kodshab",
				type: "select",
        options: [
            { label: "С календарным планом", value: "1" },
            { label: "Без календарного плана", value: "2" }
				],
				def: "---",
				placeholder: "Выберите шаблон"
			}, {
				label: "Бланк требования",
		    type:  "checkbox",
		    name:  "dognet_docbase.usedoczayv",
				options: [ { label: "", value: 1 } ],
				separator: "",
				unselectedValue: 0
			}, {
				label: "Указание руководства",
		    type:  "checkbox",
		    name:  "dognet_docbase.usedocruk",
				options: [ { label: "", value: 1 } ],
				separator: "",
				unselectedValue: 0
			}, {
				label: "Краткое наименование :",
				name: "dognet_docbase.docnameshot",
				type: "textarea"
			}, {
				label: "Полное наименование :",
				name: "dognet_docbase.docnamefullm",
				type: "textarea"
			}, {
// ----- -----
				label: "Начало счета (число) :",
				name: "dognet_docbase.daynachdoc",
				type: "hidden"
			}, {
				label: "Начало счета (месяц) :",
				name: "dognet_docbase.monthnachdoc",
				type: "hidden"
			}, {
				label: "Начало счета (год) :",
				name: "dognet_docbase.yearnachdoc",
				type: "hidden"
			}, {
				label: "Окончание счета (число) :",
				name: "dognet_docbase.dayenddoc",
				type: "hidden"
			}, {
				label: "Окончание счета (месяц) :",
				name: "dognet_docbase.monthenddoc",
				type: "hidden"
			}, {
				label: "Окончание счета (год) :",
				name: "dognet_docbase.yearenddoc",
				type: "hidden"
			}, {
				label: "Начало :",
				name: "docDateBegin",
				type: "datetime",
				format: "DD.MM.YYYY",
				attr: { readonly: "readonly" }
			}, {
				label: "Окончание :",
				name: "docDateEnd",
				type: "datetime",
				format: "DD.MM.YYYY",
				attr: { readonly: "readonly" }
			}, {
// ----- -----
				label: "Тип :",
				name: "dognet_docbase.kodtip",
				type: "select",
				def: "---",
				placeholder: "Выберите тип"
			}, {
				label: "Объект :",
				name: "dognet_docbase.kodobject",
				type: "select",
				def: "---",
				placeholder: "Выберите объект"
			}, {
				label: "Заказчик :",
				name: "dognet_docbase.kodzakaz",
				type: "select",
				def: "---",
				placeholder: "Выберите заказчика"
			}, {
				label: "Статус :",
				name: "dognet_docbase.kodstatus",
				type: "select",
				def: "---",
				placeholder: "Выберите статус"
			}, {
				label: "Исполнтель :",
				name: "dognet_docbase.kodispol",
				type: "select",
				def: "---",
				placeholder: "Выберите исполнителя"
			}, {
				label: "Руководитель :",
				name: "dognet_docbase.kodispolruk",
				type: "select",
				def: "---",
				placeholder: "Выберите руководителя"
			}, {
				label: "Сумма :",
				name: "dognet_docbase.docsumma"
			}, {
// ----- -----
				label: "Ден. единица :",
				name: "dognet_docbase.koddened",
				type: "select",
				def: "---",
				placeholder: "Выберите валюту"
			}, {
				label: "НДС",
		    type:  "checkbox",
		    name:  "dognet_docbase.usendssumma",
				options: [ { label: "", value: 1 } ],
				separator: "",
				unselectedValue: 0
// ----- -----
			}, {
				label: "Расчет командировок :",
				name: "dognet_docbase.usemisopl",
				type: "select",
        options: [
            { label: "Не определено", value: "0" },
            { label: "С оплатой по лимиту", value: "1" },
            { label: "Сверх стоимости", value: "2" }
				],
				placeholder: "Выберите вариант"
			}, {
				label: "Лимит :",
				name: "dognet_docbase.docsummamis"
// ----- -----
			}, {
				label: "Статус задолженности :",
				name: "dognet_docbase.kodstatuszdl",
				type: "select",
        options: [
            { label: "Не определено", value: "0" },
            { label: "Текущая", value: "1" },
            { label: "Судебная", value: "2" },
            { label: "Невозвратная", value: "2" }
				],
				placeholder: "Выберите вариант"
			}
		]
	} );
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
  editor_tab1_chet
      .on( 'open', function () {

					$('#kodzakaz_filter').val('');
					if (($('#DTE_Field_dognet_docbase-kodzakaz').value) != editor_tab1_chet.field('dognet_docbase.kodzakaz').get()) {
					}
			// Поиск в ниспадающем списке по содержимому текстового поля для ответного документа
          $('#DTE_Field_dognet_docbase-kodzakaz').filterByText(editor_tab1_chet, $('#kodzakaz_filter'), 'dognet_docbase.kodzakaz', false);

					$('#kodobject_filter').val('');
					if (($('#DTE_Field_dognet_docbase-kodobject').value) != editor_tab1_chet.field('dognet_docbase.kodobject').get()) {
					}
			// Поиск в ниспадающем списке по содержимому текстового поля для ответного документа
          $('#DTE_Field_dognet_docbase-kodobject').filterByText(editor_tab1_chet, $('#kodobject_filter'), 'dognet_docbase.kodobject', false);

					$(".modal-dialog").css({
						"width":"80%",
						"min-width":"800px",
						"max-width":"1170px"
					});

      } );
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Изменяем размер диалогового окна редактирования счета субподряда
	editor_tab1_chet.on( 'close', function () { $(".modal-dialog").css({
		"width":"60%",
		"min-width":"none",
		"max-width":"none"
		});
	} );
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	table_tab1_chet = $('#chetview-edit-tab1_chet').DataTable( {
		dom: "<'row'<'col-md-8 col-sm-12'B><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'>>",
// 		dom: "t",
		language: {
				url: "php/examples/simple/chetview/chetview-edit/dt_russian-tab1_chet.json"
		},
		ajax: {
			url: "php/examples/php/chetview/chetview-edit/dognet-chetview-edit-tab1_chet-process.php",
			type: "POST"
		},
		serverSide: true,
		columns: [
			{
				class: "details-control",
				searchable: false,
				orderable: false,
				data: null,
				defaultContent: "<span class='glyphicon glyphicon-option-vertical'></span>"
			},
			{ data: "dognet_docbase.docnamefullm" },
			{ data: "dognet_docbase.docsumma" }
		],
		select: {
			style: 'single',
			selector: 'td:first-child'
		},
		columnDefs: [
			{ orderable: false, searchable: false, targets: 0 },
			{ orderable: false, searchable: false, render: function ( data, type, row, meta ) {
				if (data == "") {
					return row.dognet_docbase.docnameshot;
				}
				else {
					return row.dognet_docbase.docnamefullm;
				}
				}, targets: 1
			},
			{ orderable: false, searchable: false, render: function ( data, type, row, meta ) {
				if (data != null) {
					return $.fn.dataTable.render.number(' ', ',', 2, '').display( data )+row.dognet_spdened.short_code;
				}
				else {
					return "0.00"+row.dognet_spdened.short_code;
				}
				}, targets: 2
			}
		],
		order: [ [ 1, "asc" ] ],
		select: true,
		processing: false,
		paging: false,
		searching: false,
		lengthChange: false,
		buttons: [
	    { text:	'<span class="glyphicon glyphicon-refresh"></span>', action:
	      function ( e, dt, node, config ) {
					table_tab1_chet.columns().search('').draw();
				}
			},
			{ extend: "edit", editor: editor_tab1_chet, text: "РЕДАКТИРОВАТЬ",
				formButtons:
					[ 'Сохранить изменения',
						{ text: 'Отмена', action: function () { this.close(); } }
					]
			}
		],
		initComplete: function() {

		},
    drawCallback: function () {

    }
	} );
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	editor_tab1_chet.on( 'preOpen', function () {

		var daynachdoc = addZero(2, editor_tab1_chet.field('dognet_docbase.daynachdoc').val());
		var monthnachdoc = addZero(2, editor_tab1_chet.field('dognet_docbase.monthnachdoc').val());
		var yearnachdoc = addZero(2, editor_tab1_chet.field('dognet_docbase.yearnachdoc').val());
			editor_tab1_chet.field( 'docDateBegin' ).set(daynachdoc+"."+monthnachdoc+"."+yearnachdoc);

		var dayenddoc = addZero(2, editor_tab1_chet.field('dognet_docbase.dayenddoc').val());
		var monthenddoc = addZero(2, editor_tab1_chet.field('dognet_docbase.monthenddoc').val());
		var yearenddoc = addZero(2, editor_tab1_chet.field('dognet_docbase.yearenddoc').val());
			editor_tab1_chet.field( 'docDateEnd' ).set(dayenddoc+"."+monthenddoc+"."+yearenddoc);

	} );
//
//
	editor_tab1_chet.on( 'initSubmit', function () {

		var a = editor_tab1_chet.field( 'docDateBegin' ).val().split('.');
		editor_tab1_chet.field('dognet_docbase.daynachdoc').set(a[0]);
		editor_tab1_chet.field('dognet_docbase.monthnachdoc').set(a[1]);
		editor_tab1_chet.field('dognet_docbase.yearnachdoc').set(a[2]);

		var b = editor_tab1_chet.field( 'docDateEnd' ).val().split('.');
		editor_tab1_chet.field('dognet_docbase.dayenddoc').set(b[0]);
		editor_tab1_chet.field('dognet_docbase.monthenddoc').set(b[1]);
		editor_tab1_chet.field('dognet_docbase.yearenddoc').set(b[2]);

	} );
	editor_tab1_chet.on( 'initEdit', function () {
		editor_tab1_chet.field('dognet_docbase.kodshab').disable();
	} );
	editor_tab1_chet.on( 'preOpen', function () {
		editor_tab1_chet.field('dognet_docbase.usedoczayv').disable();
	} );
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Изменяем размер диалогового окна редактирования счета субподряда
	editor_tab1_chet.on( 'open', function () { $(".modal-dialog").css("width", "80%");	} );
	editor_tab1_chet.on( 'close', function () { $(".modal-dialog").css("width", "80%"); } );
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Array to track the ids of the edit displayed rows
    var detailRows = [];

    $('#chetview-edit-tab1_chet tbody').on( 'click', 'tr td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table_tab1_chet.row( tr );
        var idx = $.inArray( tr.attr('id'), detailRows );

        if ( row.child.isShown() ) {
            tr.removeClass( 'edit' );
            row.child.hide();

// Remove from the 'open' array
            detailRows.splice( idx, 1 );
        }
        else {
            tr.addClass( 'edit' );
			rowData = table_tab1_chet.row( row );
			d = row.data();
			rowData.child( <?php include('templates/chetview-edit_tab1_chet.tpl'); ?> ).show();
// Add to the 'open' array
            if ( idx === -1 ) {
                detailRows.push( tr.attr('id') );
            }
        }
    } );
// On each draw, loop over the `detailRows` array and show any child rows
	table_tab1_chet.on( 'draw', function () {
		$.each( detailRows, function ( i, id ) {
		$('#'+id+' td.details-control').trigger( 'click' );
	    } );
	} );
} );
</script>
<?php
// ----- ----- ----- ----- -----
// Подключаем форму и выводим таблицу договора
// :::
include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/chetview/chetview-edit/restr_5/tabs/forms/chetview-edit_tab1_chet-customForm.php");
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/chetview/chetview-edit/restr_5/tabs/css/chetview-edit-tab1_chet.css">
<section>
	<div id="chetview-tab1_chet" class="" style="padding:0 5px">
		<div class="space30"></div>
		<div class="demo-html"></div>
		<table id="chetview-edit-tab1_chet" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
					<th class="text-center text-uppercase">Название счета</th>
					<th class="text-uppercase">Сумма</th>
				</tr>
			</thead>
		</table>
	</div>
</section>

