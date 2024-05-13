
<script type="text/javascript" language="javascript" class="init">

var table_tab5_ispolniteliruk;

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
//
$(document).ready(function() {
//
	editor_tab5_ispolniteliruk = new $.fn.dataTable.Editor( {
		display: "bootstrap",
		ajax: "php/examples/php/sp/sp-details/dognet-sp-details-tab5_ispolniteliruk-process.php",
		table: "#sp-tab5_ispolniteliruk-table",
    i18n: {
        create: { title: "<h3>Добавить нового руководителя</h3>" },
        edit: { title: "<h3>Редактировать руководителя</h3>" },
        remove: {
	        title: "<h3>Удалить руководителя</h3>",
					confirm: {
            "_": "Вы уверены, что хотите удалить %d записи(ей)?",
            "1": "Вы уверены, что хотите удалить этого руководителя?"
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
		template: '#customForm-tab5_ispolniteliruk',
		fields: [
			{
				label: "",
				name: "kodispolruk"
			}, {
				label: "Краткое имя :",
				name: "ispolrukname",
				attr: { placeholder: 'Краткое имя исполнителя' }
			}, {
				label: "Полное имя :",
				name: "ispolruknamefull",
				attr: { placeholder: 'Полное имя исполнителя' }
			}, {
				label: "Должность :",
				name: "ispolrukjob",
				attr: { placeholder: 'Должность' }
			}, {
				label: "Рабочий email :",
				name: "ispolrukemail",
				attr: { placeholder: 'Email' }
			}, {
				label: "Рабочий телефон :",
				name: "ispolruktel",
				attr: { placeholder: 'Телефон' }
			}, {
				label: "Руководитель ГИП :",
		    type:  "checkbox",
				name: "kodrukgip",
				options: [ { label: "", value: 1 } ],
				separator: "",
				unselectedValue: 0
			}
		]
	} );
//
// Изменяем размер диалогового окна редактирования договора субподряда
	editor_tab5_ispolniteliruk.on( 'open', function () { $(".modal-dialog").css({
		"width":"60%",
		"min-width":"640px",
		"max-width":"800px"
		});
	} );
	editor_tab5_ispolniteliruk.on( 'close', function () { $(".modal-dialog").css({
		"width":"80%",
		"min-width":"none",
		"max-width":"none"
		});
	} );
//
// ----- --- ----- --- -----
//
	table_tab5_ispolniteliruk = $('#sp-tab5_ispolniteliruk-table').DataTable( {
		dom: "<'row'<'col-sm-6'B><'col-sm-3'><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'>>",
// 		dom: "<'space50'r>lftip",
		language: {
			url: "php/examples/simple/sp/sp-details/dt_russian-sp-ispolniteliruk.json"
		},
		ajax: {
			url: "php/examples/php/sp/sp-details/dognet-sp-details-tab5_ispolniteliruk-process.php",
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
			{ data: "ispolrukname", defaultContent: "" },
			{ data: "ispolruknamefull", defaultContent: "" },
			{ data: "ispolrukjob" },
			{ data: "ispolrukemail" },
			{ data: "ispolruktel" },
			{ data: "kodrukgip" }
		],
		columnDefs: [
			{ orderable: false, targets: 0 },
			{ orderable: false, searchable: true, targets: 1 },
			{ orderable: false, searchable: true, targets: 2 },
			{ orderable: false, searchable: true, targets: 3 },
			{ orderable: false, searchable: false, targets: 4 },
			{ orderable: false, searchable: false, targets: 5 },
			{ orderable: false,
				render: function( data, type, row, meta ) {
					return (data == 1) ? "X" : "";
				},
				targets: 6
			}
		],
		order: [ [ 1, "asc" ] ],
		select: true,
		processing: true,
		paging: true,
		searching: true,
		pageLength: 15,
		lengthChange: false,
		lengthMenu: [ [15, 30, 50, -1], [15, 30, 50, "Все"] ],
		buttons: [
			{ text:	'<span class="glyphicon glyphicon-refresh"></span>', action:
				function ( e, dt, node, config ) {
					table_tab5_ispolniteliruk.columns().search('');
					table_tab5_ispolniteliruk.order([1,"asc"]).draw();
				}
			},
			{ extend: "create", editor: editor_tab5_ispolniteliruk, text: "ДОБАВИТЬ РУКОВОДИТЕЛЯ",
				formButtons:
					[ 'Добавить руководителя',
						{ text: 'Отмена', action: function () { this.close(); } }
					]
			},
			{ extend: "edit", editor: editor_tab5_ispolniteliruk, text: "РЕДАКТИРОВАТЬ",
				formButtons:
					[ 'Сохранить изменения',
						{ text: 'Отмена', action: function () { this.close(); } }
					]
			},
			{ extend: "remove", editor: editor_tab5_ispolniteliruk, text: "УДАЛИТЬ",
				formButtons:
					[ 'Удалить руководителя',
						{ text: 'Отмена', action: function () { this.close(); } }
					]
			}
		]
	} );
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    var detailRows_tab5_ispolniteliruk = [];
    $('#sp-tab5_ispolniteliruk-table tbody').on( 'click', 'tr td.details-control', function () {
      var tr = $(this).closest('tr');
      var row = table_tab5_ispolniteliruk.row( tr );
      var idx = $.inArray( tr.attr('id'), detailRows_tab5_ispolniteliruk );
      if ( row.child.isShown() ) {
	      tr.removeClass( 'details' );
	      row.child.hide();
	      detailRows_tab5_ispolniteliruk.splice( idx, 1 );
      }
      else {
        tr.addClass( 'details' );
				rowData = table_tab5_ispolniteliruk.row( row );
				d = row.data();
				rowData.child( <?php include('templates/sp-details_tab5_ispolniteliruk.tpl'); ?> ).show();
	      if ( idx === -1 ) {
					detailRows_tab5_ispolniteliruk.push( tr.attr('id') );
	      }
			}
    } );
//
		table_tab5_ispolniteliruk.on( 'draw', function () {
			$.each( detailRows_tab5_ispolniteliruk, function ( i, id ) {
			$('#'+id+' td.details-control').trigger( 'click' );
	  } );
	} );
} );
</script>
<?php
// ----- ----- ----- ----- -----
// Подключаем форму редактирования и выводим таблицу
// :::
include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/sp/sp-details/restr_5/tabs/forms/sp-details-tab5_ispolniteliruk-customForm.php");
// ----- ----- ----- ----- -----
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/sp/sp-details/restr_5/tabs/css/sp-details-tab5_ispolniteliruk-main.css">
<section>
	<div id="sp-tab5_ispolniteliruk" class="">
		<div id="tab5_ispolniteliruk" class="">
			<div class="demo-html"></div>
			<table id="sp-tab5_ispolniteliruk-table" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th><span class='glyphicon glyphicon-option-vertical'></span></th>
						<th>Краткое имя</th>
						<th>Полное имя</th>
						<th>Исполнитель</th>
						<th>Email</th>
						<th>Телефон</th>
						<th>ГИП</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</section>
