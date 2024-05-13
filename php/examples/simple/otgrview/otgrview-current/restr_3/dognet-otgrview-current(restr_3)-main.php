
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/moment-with-locales.js"></script>
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/filterByText.js"></script>

<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/otgrview/otgrview-current/restr_3/css/otgrview-current-common-tables.css">
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/otgrview/otgrview-current/restr_3/css/otgrview-current-common-customForm.css">

<script type="text/javascript" language="javascript" class="init">

function addZero(digits_length, source){
    var text = source + '';
    while(text.length < digits_length)
        text = '0' + text;
    return text;
}

var table_docotgr_main;
var editor_docotgr_main;

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

$(document).ready(function() {

	editor_docotgr_main = new $.fn.dataTable.Editor( {
		display: "bootstrap",
		ajax: "php/examples/php/otgrview/otgrview-current/dognet-otgrview-doc-main-process.php",
		table: "#otgrview-doc-main",
    i18n: {
        create: { title: "<h3>Создать новый договора</h3>" },
        edit: { title: "<h3>Редактировать договор</h3>" },
        remove: {
	        title: "<h3>Удалить договор</h3>",
					confirm: {
            "_": "Вы уверены, что хотите удалить %d записи(ей)?",
            "1": "Вы уверены, что хотите удалить этот договор?"
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
		template: '#customForm-otgrpaper-main',
		fields: [
			{
				label: "Тип документа :",
				name: "dognet_docpaperotgr.kodpaper",
				type: "select",
				def: "---",
				placeholder: "Выберите тип документа"
			}, {
				label: "Договор № :",
				name: "dognet_docpaperotgr.papermemo"
			}, {
				label: "Дата записи :",
				name: "dognet_docpaperotgr.dateloader",
				type: "datetime",
				def:    function () { return new Date(); },
				format: "DD.MM.YYYY",
				attr: { readonly: "readonly" }
			}, {
				label: "Дата отгрузки :",
				name: "dognet_docpaperotgr.dateotgr",
				type: "datetime",
				def:    function () { return new Date(); },
				format: "DD.MM.YYYY",
				attr: { readonly: "readonly" }
			}, {
				label: "Доверенное лицо :",
				name: "dognet_docpaperotgr.nameotgr"
			}, {
				label: "Организация :",
				name: "dognet_docpaperotgr.nameorgotgr"
			}, {
				label: "Описание документа :",
				name: "dognet_docpaperotgr.namedocotgr",
				type: "textarea"
			}, {
				label: "Примечание к записи :",
				name: "dognet_docpaperotgr.commentloader",
				type: "textarea"
			}, {
				label: "Примечание к отгрузке :",
				name: "dognet_docpaperotgr.commentotgr",
				type: "textarea"
// ----- ----- ----- ----- -----
			}, {
				name: "dognet_docpaperotgr.docFileID",
				type: "upload",
				display: function ( id ) { return '<a target="_blank" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet'+editor_docotgr_main.file( 'dognet_docpaperotgr_files', id ).file_webpath+'"><h4>СКАЧАТЬ ФАЙЛ</h4></a>'; }
			}, {
				type: "readonly",
				name: "dognet_docpaperotgr.msgDocFileID"
// ----- ----- ----- ----- -----
			}
		]
	} );
//
// Изменяем размер диалогового окна редактирования договора субподряда
	editor_docotgr_main.on( 'open', function () { $(".modal-dialog").css({
		"width":"60%",
		"min-width":"640px",
		"max-width":"800px"
		});
	} );
	editor_docotgr_main.on( 'close', function () { $(".modal-dialog").css({
		"width":"80%",
		"min-width":"none",
		"max-width":"none"
		});
	} );
//
// ----- --- ----- --- -----
//
	editor_docotgr_main.on('initCreate', function ( e ) {
		editor_docotgr_main.field('dognet_docpaperotgr.msgDocFileID').show();
		editor_docotgr_main.field('dognet_docpaperotgr.msgDocFileID').val('Сначала создайте запись!');
		editor_docotgr_main.field('dognet_docpaperotgr.docFileID').hide();
		editor_docotgr_main.field('dognet_docpaperotgr.docFileID').disable();
	});
// ----- --- ----- --- -----
	editor_docotgr_main.on('initEdit', function ( e, node, data, items, type ) {
		editor_docotgr_main.field('dognet_docpaperotgr.msgDocFileID').hide();
		editor_docotgr_main.field('dognet_docpaperotgr.docFileID').show();
		editor_docotgr_main.field('dognet_docpaperotgr.docFileID').enable();
	});
//
// ----- --- ----- --- -----
//
    editor_docotgr_main
        .on( 'open', function () {



        } )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

	table_docotgr_main = $('#otgrview-doc-main').DataTable( {
		dom: "<'row'<'col-sm-5'B><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'l>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'p>>",
// 		dom: "<'space50'r>tip",
		language: {	url: "russian.json" },
		ajax: {
			url: "php/examples/php/otgrview/otgrview-current/dognet-otgrview-doc-main-process.php",
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
			{ data: "dognet_docpaperotgr.koddocpaper", className: "text-center" },
			{ data: "dognet_docpaperotgr.dateloader", className: "text-center" },
			{ data: "dognet_docpaperotgr.dateotgr", className: "text-left" },
			{ data: "dognet_sptippaper.namepaper", className: "text-left" },
			{ data: "dognet_docpaperotgr.namedocotgr" },
      {
          data: "dognet_docpaperotgr.docFileID",
          render: function ( id ) {
              return id ?
                  '<a class="" target="_blank" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet'+editor_docotgr_main.file( 'dognet_docpaperotgr_files', id ).file_webpath+'"><span class="glyphicon glyphicon-file"></span></a>' :
                  '<span class="glyphicon glyphicon-option-horizontal"></span>';
          },
          defaultContent: "",
	className: "text-center"
      },
			{ data: "dognet_docbase.docnumber" },
			{ data: "dognet_docpaperotgr.nameotgr" },
			{ data: "dognet_docpaperotgr.nameorgotgr" }
		],
		select: 'single',
		columnDefs: [
			{ orderable: false, searchable: false, targets: 0 },
			{ orderable: true, searchable: false, targets: 1 },
			{ orderable: true, searchable: false, targets: 2 },
			{ orderable: false, searchable: true, targets: 3 },
			{ orderable: false, searchable: true, targets: 4 },
			{ orderable: false, searchable: true, targets: 5 },
			{ orderable: false, searchable: false, targets: 6 },
			{ orderable: false, visible: false, searchable: true, targets: 7 },
			{ orderable: false, visible: false, searchable: true, targets: 8 },
			{ orderable: false, visible: false, searchable: true, targets: 9 }
		],
		order: [ [ 2, "desc" ], [ 1, "desc" ] ],
		processing: true,
		paging: true,
		searching: true,
		pageLength: 15,
		lengthChange: false,
		lengthMenu: [ [15, 30, 50, -1], [15, 30, 50, "Все"] ],
		buttons: [
			{ text:	'<span class="glyphicon glyphicon-refresh"></span>', action:
				function ( e, dt, node, config ) {
					$('#docNumberSearch_text').val('');
					$('#otgrYearSearch_text').val('');
					$('#tipPaperSearch_text').val('');
					$('#docNameSearch_text').val('');
					$('#nameorgotgrSearch_text').val('');
					$('#nameotgrSearch_text').val('');
					table_docotgr_main.columns().search('');
					table_docotgr_main.order([2,"desc"], [1,"desc"]).draw();
				}
			},
			{ extend: "create", editor: editor_docotgr_main, text: "НОВАЯ ОТГРУЗКА",
				formButtons:
					[ 'Новая отгрузка',
						{ text: 'Отмена', action: function () { this.close(); } }
					]
			},
			{ extend: "edit", editor: editor_docotgr_main, text: "ИЗМЕНИТЬ",
				formButtons:
					[ 'Сохранить изменения',
						{ text: 'Отмена', action: function () { this.close(); } }
					]
			},
			{ extend: "remove", editor: editor_docotgr_main, text: "УДАЛИТЬ",
				formButtons:
					[ 'Удалить запись',
						{ text: 'Отмена', action: function () { this.close(); } }
					]
			}
		],
		drawCallback: function () {

		}
	} );

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Array to track the ids of the details displayed rows
    var detailRows = [];

    $('#otgrview-doc-main tbody').on( 'click', 'tr td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table_docotgr_main.row( tr );
        var idx = $.inArray( tr.attr('id'), detailRows );

        if ( row.child.isShown() ) {
            tr.removeClass( 'details' );
            row.child.hide();

            // Remove from the 'open' array
            detailRows.splice( idx, 1 );
        }
        else {
            tr.addClass( 'details' );
			rowData = table_docotgr_main.row( row );
			d = row.data();
			rowData.child( <?php include('templates/otgrview-current-details.tpl'); ?> ).show();

// Add to the 'open' array
            if ( idx === -1 ) {
                detailRows.push( tr.attr('id') );
            }
        }
    } );
// On each draw, loop over the `detailRows` array and show any child rows
	table_docotgr_main.on( 'draw', function () {
		$.each( detailRows, function ( i, id ) {
		$('#'+id+' td.details-control').trigger( 'click' );
	    } );
	} );
//
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
//
	editor_docotgr_main.on( 'preOpen', function () {


	} );
	editor_docotgr_main.on( 'initSubmit', function () {


	} );
	editor_docotgr_main.on( 'initEdit', function () {

	} );
	editor_docotgr_main.on( 'initCreate', function () {

	} );
	editor_docotgr_main.on( 'preOpen', function () {

	} );
//
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
//
		$('#globalSearch_button').click(function(e){
			table_docotgr_main.search($("#globalSearch_text").val()).draw();
		});
		$('#clearSearch_button').click(function(e){
			table_docotgr_main.search('').draw();
			$('#globalSearch_text').val('');
		});

		$('#columnSearch_btnApply').click(function(e){
			table_docotgr_main
				.columns(7)
				.search($("#docNumberSearch_text").val())
				.draw();

			table_docotgr_main
				.columns(3)
				.search($("#otgrYearSearch_text").val())
				.draw();

			table_docotgr_main
				.columns(5)
				.search($("#docNameSearch_text").val())
				.draw();

			table_docotgr_main
				.columns(4)
				.search($("#tipPaperSearch_text").val())
				.draw();

			table_docotgr_main
				.columns(9)
				.search($("#nameorgotgrSearch_text").val())
				.draw();

			table_docotgr_main
				.columns(8)
				.search($("#nameotgrSearch_text").val())
				.draw();

		});

		$('#columnSearch_btnClear').click(function(e){
			$('#docNumberSearch_text').val('');
			$('#otgrYearSearch_text').val('');
			$('#tipPaperSearch_text').val('');
			$('#docNameSearch_text').val('');
			$('#nameorgotgrSearch_text').val('');
			$('#nameotgrSearch_text').val('');
			$('#docTypeSearch_text').val('');
			$('#docIspolSearch_text').val('');
			$('#docShablonSearch_text').val('');
			table_docotgr_main
				.columns()
				.search('')
				.draw();
		});

// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

		$("#docNumberSearch_text").on("keyup", function(event) {
		  if (event.keyCode === 13) { event.preventDefault(); document.getElementById("columnSearch_btnApply").click(); }
		});
		$("#otgrYearSearch_text").on("keyup", function(event) {
		  if (event.keyCode === 13) { event.preventDefault(); document.getElementById("columnSearch_btnApply").click(); }
		});
		$("#docNameSearch_text").on("keyup", function(event) {
		  if (event.keyCode === 13) { event.preventDefault(); document.getElementById("columnSearch_btnApply").click(); }
		});
		$("#nameorgotgrSearch_text").on("keyup", function(event) {
		  if (event.keyCode === 13) { event.preventDefault(); document.getElementById("columnSearch_btnApply").click(); }
		});
		$("#nameotgrSearch_text").on("keyup", function(event) {
		  if (event.keyCode === 13) { event.preventDefault(); document.getElementById("columnSearch_btnApply").click(); }
		});
} );
</script>
<?php
// ----- ----- ----- ----- -----
// Подключаем форму редактирования, форму поиска и выводим таблицу договора
// :::
include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/otgrview/otgrview-current/restr_3/forms/otgrview-current-customForm.php");
include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/otgrview/otgrview-current/restr_3/forms/otgrview-current-filters.php");
// ----- ----- ----- ----- -----
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/otgrview/otgrview-current/restr_3/css/otgrview-current-main.css">
<section>
	<div class="demo-html"></div>
	<table id="otgrview-doc-main" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th><span class='glyphicon glyphicon-option-vertical'></span></th>
				<th>ID отгрузки</th>
				<th>Ввод</th>
				<th>Отгрузка</th>
				<th>Тип документа</th>
				<th>Описание</th>
				<th>Скан</th>
			</tr>
		</thead>
	</table>
</section>

