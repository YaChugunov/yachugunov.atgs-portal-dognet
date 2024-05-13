
<script type="text/javascript" language="javascript" class="init">

var editor_tab6_doctypes;		// use a global for the submit and return data rendering in the examples
var table_tab6_doctypes;		// use a global for the submit and return data rendering in the examples
//
//
$(document).ready(function() {
//
	editor_tab6_doctypes = new $.fn.dataTable.Editor( {
		display: "bootstrap",
		ajax: "php/examples/php/sp/sp-details/dognet-sp-details-tab6_doctypes-process.php",
		table: "#sp-tab6_doctypes-table",
    i18n: {
        create: { title: "<h3>Добавить нового тип</h3>" },
        edit: { title: "<h3>Редактировать тип</h3>" },
        remove: {
	        title: "<h3>Удалить тип</h3>",
					confirm: {
            "_": "Вы уверены, что хотите удалить %d записи(ей)?",
            "1": "Вы уверены, что хотите удалить этот тип?"
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
		template: '#customForm-tab6_doctypes',
		fields: [
			{
				label: "Название типа договора :",
				name: "nametip",
				attr: { placeholder: 'Название типа договора' }
			}, {
				label: "Описание типа договора :",
				name: "commenttip",
				type: "textarea",
				attr: { placeholder: 'Описание типа договора' }
			}, {
				label: "",
		    type:  "checkbox",
				name: "usedate",
				options: [ { label: "", value: 1 } ],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
		    type:  "checkbox",
		    name:  "kodrepanl",
				options: [ { label: "", value: 1 } ],
				separator: "",
				unselectedValue: 0
			}, {
				label: "",
		    type:  "checkbox",
		    name:  "usedatepl",
				options: [ { label: "", value: 1 } ],
				separator: "",
				unselectedValue: 0
			}, {
				label: "Дней до оплаты (план) :",
				name: "numberdayoplplan",
				attr: { placeholder: 'Дней до оплаты (план)' }
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
	editor_tab6_doctypes.on( 'open', function () { $(".modal-dialog").css({
		"width":"60%",
		"min-width":"640px",
		"max-width":"800px"
		});
	} );
	editor_tab6_doctypes.on( 'close', function () { $(".modal-dialog").css({
		"width":"80%",
		"min-width":"none",
		"max-width":"none"
		});
	} );
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Activate an inline edit on click of a table cell
    $('#sp-tab6_doctypes-table').on( 'dblclick', 'tbody td:not(:first-child)', function (e) {
        editor_tab6_doctypes.inline( this );
    } );
//
// ----- --- ----- --- -----
//
	table_tab6_doctypes = $('#sp-tab6_doctypes-table').DataTable( {
		dom: "<'row'<'col-sm-6'B><'col-sm-3'><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'>>",
		language: {
			url: "php/examples/simple/sp/sp-details/dt_russian-sp-doctypes.json"
		},
		ajax: {
			url: "php/examples/php/sp/sp-details/dognet-sp-details-tab6_doctypes-process.php",
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
			{ data: "nametip" },
			{ data: "numberdayoplplan" },
			{ data: "usedate" },
			{ data: "kodrepanl" },
			{ data: "usedatepl" },
			{ data: "enbl_report_missions" }
		],
		select: {
			style: 'os',
			selector: 'td:not(:last-child)' // no row selection on last column
		},
		columnDefs: [
			{ orderable: false, targets: 0 },
			{ orderable: true, targets: 1 },
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
					table_tab6_doctypes.columns().search('');
					table_tab6_doctypes.order([1,"asc"]).draw();
				}
			},
			{ extend: "create", editor: editor_tab6_doctypes, text: "ДОБАВИТЬ ТИП",
				formButtons:
					[ 'Добавить тип',
						{ text: 'Отмена', action: function () { this.close(); } }
					]
			},
			{ extend: "edit", editor: editor_tab6_doctypes, text: "РЕДАКТИРОВАТЬ",
				formButtons:
					[ 'Сохранить изменения',
						{ text: 'Отмена', action: function () { this.close(); } }
					]
			},
			{ extend: "remove", editor: editor_tab6_doctypes, text: "УДАЛИТЬ",
				formButtons:
					[ 'Удалить тип',
						{ text: 'Отмена', action: function () { this.close(); } }
					]
			}
		]
	} );
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    var detailRows_tab6_doctypes = [];
    $('#sp-tab6_doctypes-table tbody').on( 'click', 'tr td.details-control', function () {
      var tr = $(this).closest('tr');
      var row = table_tab6_doctypes.row( tr );
      var idx = $.inArray( tr.attr('id'), detailRows_tab6_doctypes );
      if ( row.child.isShown() ) {
	      tr.removeClass( 'details' );
	      row.child.hide();
	      detailRows_tab6_doctypes.splice( idx, 1 );
      }
      else {
        tr.addClass( 'details' );
				rowData = table_tab6_doctypes.row( row );
				d = row.data();
				rowData.child( <?php include('templates/sp-details_tab6_doctypes.tpl'); ?> ).show();
	      if ( idx === -1 ) {
					detailRows_tab6_doctypes.push( tr.attr('id') );
	      }
			}
    } );
//
		table_tab6_doctypes.on( 'draw', function () {
			$.each( detailRows_tab6_doctypes, function ( i, id ) {
				$('#'+id+' td.details-control').trigger( 'click' );
		  } );
		} );
} );
</script>
<?php
// ----- ----- ----- ----- -----
// Подключаем форму редактирования и выводим таблицу
// :::
include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/sp/sp-details/restr_5/tabs/forms/sp-details-tab6_doctypes-customForm.php");
// ----- ----- ----- ----- -----
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/sp/sp-details/restr_5/tabs/css/sp-details-tab6_doctypes-main.css">
<section>
	<div id="sp-tab6_doctypes" class="">
		<div id="tab6_doctypes" class="">
			<div class="demo-html"></div>
			<table id="sp-tab6_doctypes-table" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th><span class='glyphicon glyphicon-option-vertical'></span></th>
						<th>Тип договора</th>
						<th>DOPL</th>
						<th>USEDATE</th>
						<th>REPANL</th>
						<th>USEDOPL</th>
						<th>ENBLMIS</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</section>
