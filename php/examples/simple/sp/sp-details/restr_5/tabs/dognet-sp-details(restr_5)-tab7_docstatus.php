
<script type="text/javascript" language="javascript" class="init">
//
//
var editor_tab7_docstatus;		// use a global for the submit and return data rendering in the examples
var table_tab7_docstatus;		// use a global for the submit and return data rendering in the examples
//
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
//
$(document).ready(function() {
//
	editor_tab7_docstatus = new $.fn.dataTable.Editor( {
		display: "bootstrap",
		ajax: "php/examples/php/sp/sp-details/dognet-sp-details-tab7_docstatus-process.php",
		table: "#sp-tab7_docstatus-table",
    i18n: {
        create: { title: "<h3>Добавить нового заказчика</h3>" },
        edit: { title: "<h3>Редактировать заказчика</h3>" },
        remove: {
	        title: "<h3>Удалить заказчика</h3>",
					confirm: {
            "_": "Вы уверены, что хотите удалить %d записи(ей)?",
            "1": "Вы уверены, что хотите удалить этот статус?"
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
		template: '#customForm-tab7_docstatus',
		fields: [
			{
				label: "Краткое название :",
				name: "statusnameshot",
				attr: { placeholder: 'Краткое название' }
			}, {
				label: "Полное название :",
				name: "statusnamefull",
				type: "textarea",
				attr: { placeholder: 'Полное название' }
			}, {
				label: "",
		    type:  "checkbox",
				name: "usedate",
				options: [ { label: "", value: 1 } ],
				separator: "",
				unselectedValue: 0
			}, {
				label: "NUMORD :",
				name: "numberorder"
			}, {
				label: "USLREP :",
				name: "uslreport"
			}, {
				label: "",
		    type:  "checkbox",
		    name:  "useplandate",
				options: [ { label: "", value: 1 } ],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
		    type:  "checkbox",
				name: "enbl_report_missions",
				options: [ { label: "", value: 1 } ],
				separator: "",
				unselectedValue: 0
			}
		]
	} );
//
// Изменяем размер диалогового окна редактирования договора субподряда
	editor_tab7_docstatus.on( 'open', function () { $(".modal-dialog").css({
		"width":"60%",
		"min-width":"640px",
		"max-width":"800px"
		});
	} );
	editor_tab7_docstatus.on( 'close', function () { $(".modal-dialog").css({
		"width":"80%",
		"min-width":"none",
		"max-width":"none"
		});
	} );
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Activate an inline edit on click of a table cell
    $('#sp-tab7_docstatus-table').on( 'dblclick', 'tbody td:not(:first-child)', function (e) {
        editor_tab7_docstatus.inline( this );
    } );
//
// ----- --- ----- --- -----
//
	table_tab7_docstatus = $('#sp-tab7_docstatus-table').DataTable( {
		dom: "<'row'<'col-sm-6'B><'col-sm-3'><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'>>",
		language: {
			url: "php/examples/simple/sp/sp-details/dt_russian-sp-docstatus.json"
		},
		ajax: {
			url: "php/examples/php/sp/sp-details/dognet-sp-details-tab7_docstatus-process.php",
			type: "POST"
		},
		serverSide: true,
		columns: [
			{
				class: "details-control",
				searchable: false,
				orderable: false,
				data: null,
				defaultContent: "<span class='glyphicon glyphicon-option-vertical'></span>",
				className: "text-center"
			},
			{ data: "statusnameshot" },
			{ data: "numberorder" },
			{ data: "uslreport" },
			{ data: "usedate" },
			{ data: "useplandate" },
			{ data: "enbl_report_missions" }
		],
		select: {
			style: 'os',
			selector: 'td:not(:last-child)' // no row selection on last column
		},
		columnDefs: [
			{ orderable: true, targets: 0 },
			{ orderable: false, targets: 1 },
			{ orderable: false, targets: 2 },
			{ orderable: false, targets: 3 },
			{ orderable: false, targets: 4 },
			{ orderable: false, targets: 5 },
			{ orderable: false, targets: 6 }
		],
		order: [ [ 1, "asc" ] ],
		select: true,
		processing: true,
		paging: false,
		searching: false,
		pageLength: 15,
		lengthChange: false,
		lengthMenu: [ [15, 30, 50, -1], [15, 30, 50, "Все"] ],
		buttons: [
			{ text:	'<span class="glyphicon glyphicon-refresh"></span>', action:
				function ( e, dt, node, config ) {
					table_tab7_docstatus.columns().search('');
					table_tab7_docstatus.order([1,"asc"]).draw();
				}
			},
			{ extend: "create", editor: editor_tab7_docstatus, text: "ДОБАВИТЬ СТАТУС",
				formButtons:
					[ 'Добавить статус',
						{ text: 'Отмена', action: function () { this.close(); } }
					]
			},
			{ extend: "edit", editor: editor_tab7_docstatus, text: "РЕДАКТИРОВАТЬ",
				formButtons:
					[ 'Сохранить изменения',
						{ text: 'Отмена', action: function () { this.close(); } }
					]
			},
			{ extend: "remove", editor: editor_tab7_docstatus, text: "УДАЛИТЬ",
				formButtons:
					[ 'Удалить статус',
						{ text: 'Отмена', action: function () { this.close(); } }
					]
			}
		]
	} );
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    var detailRows_tab7_docstatus = [];
    $('#sp-tab7_docstatus-table tbody').on( 'click', 'tr td.details-control', function () {
      var tr = $(this).closest('tr');
      var row = table_tab7_docstatus.row( tr );
      var idx = $.inArray( tr.attr('id'), detailRows_tab7_docstatus );
      if ( row.child.isShown() ) {
	      tr.removeClass( 'details' );
	      row.child.hide();
	      detailRows_tab7_docstatus.splice( idx, 1 );
      }
      else {
        tr.addClass( 'details' );
				rowData = table_tab7_docstatus.row( row );
				d = row.data();
				rowData.child( <?php include('templates/sp-details_tab7_docstatus.tpl'); ?> ).show();
	      if ( idx === -1 ) {
					detailRows_tab7_docstatus.push( tr.attr('id') );
	      }
			}
    } );
//
		table_tab7_docstatus.on( 'draw', function () {
			$.each( detailRows_tab7_docstatus, function ( i, id ) {
				$('#'+id+' td.details-control').trigger( 'click' );
		  } );
		} );
} );
</script>
<?php
// ----- ----- ----- ----- -----
// Подключаем форму редактирования и выводим таблицу
// :::
include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/sp/sp-details/restr_5/tabs/forms/sp-details-tab7_docstatus-customForm.php");
// ----- ----- ----- ----- -----
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/sp/sp-details/restr_5/tabs/css/sp-details-tab7_docstatus-main.css">
<section>
	<div id="sp-tab7_docstatus" class="">
		<div id="tab7_docstatus" class="">
			<div class="demo-html"></div>
			<table id="sp-tab7_docstatus-table" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th><span class='glyphicon glyphicon-option-vertical'></span></th>
						<th>Статус договора</th>
						<th>USEDATE</th>
						<th>NUMORD</th>
						<th>USLREP</th>
						<th>USEPLDATE</th>
						<th>ENBLMIS</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</section>
