
<script type="text/javascript" language="javascript" class="init">

var table_tab2_subpodr;
var editor_tab2_subpodr;		// use a global for the submit and return data rendering in the examples

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
//
$(document).ready(function() {
//
	editor_tab2_subpodr = new $.fn.dataTable.Editor( {
		display: "bootstrap",
		ajax: "php/examples/php/sp/sp-details/dognet-sp-details-tab2_subpodr-process.php",
		table: "#sp-tab2_subpodr-table",
    i18n: {
        create: { title: "<h3>Добавить нового субподрядчика</h3>" },
        edit: { title: "<h3>Редактировать субподрядчика</h3>" },
        remove: {
	        title: "<h3>Удалить субподрядчика</h3>",
					confirm: {
            "_": "Вы уверены, что хотите удалить %d записи(ей)?",
            "1": "Вы уверены, что хотите удалить этого подрядчика?"
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
		template: '#customForm-tab2_subpodr',
		fields: [
			{
				label: "Краткое название :",
				name: "namesubpodrshot",
				type: "textarea",
				attr: { placeholder: 'Краткое название компании-подрядчика' }
			}, {
				label: "Полное название :",
				name: "namesubpodrlong",
				type: "textarea",
				attr: { placeholder: 'Полное название компании-подрядчика' }
			}
		]
	} );
//
// Изменяем размер диалогового окна редактирования договора субподряда
	editor_tab2_subpodr.on( 'open', function () { $(".modal-dialog").css({
		"width":"60%",
		"min-width":"640px",
		"max-width":"800px"
		});
	} );
	editor_tab2_subpodr.on( 'close', function () { $(".modal-dialog").css({
		"width":"80%",
		"min-width":"none",
		"max-width":"none"
		});
	} );
//
// ----- --- ----- --- -----
//
	table_tab2_subpodr = $('#sp-tab2_subpodr-table').DataTable( {
		dom: "<'row'<'col-sm-6'B><'col-sm-3'><'col-sm-3'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'p>>",
		language: {
			url: "php/examples/simple/sp/sp-details/dt_russian-sp-subpodr.json"
		},
		ajax: {
			url: "php/examples/php/sp/sp-details/dognet-sp-details-tab2_subpodr-process.php",
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
			{ data: "namesubpodrshot" },
			{ data: "namesubpodrlong" }
		],
		columnDefs: [
			{ orderable: false, targets: 0 },
			{ orderable: false, searchable: true, targets: 1 },
			{ orderable: false, searchable: true, targets: 2 }
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
					table_tab2_subpodr.columns().search('');
					table_tab2_subpodr.order([1,"asc"]).draw();
				}
			},
			{ extend: "create", editor: editor_tab2_subpodr, text: "ДОБАВИТЬ ПОДРЯДЧИКА",
				formButtons:
					[ 'Добавить подрядчика',
						{ text: 'Отмена', action: function () { this.close(); } }
					]
			},
			{ extend: "edit", editor: editor_tab2_subpodr, text: "РЕДАКТИРОВАТЬ",
				formButtons:
					[ 'Сохранить изменения',
						{ text: 'Отмена', action: function () { this.close(); } }
					]
			},
			{ extend: "remove", editor: editor_tab2_subpodr, text: "УДАЛИТЬ",
				formButtons:
					[ 'Удалить подрядчика',
						{ text: 'Отмена', action: function () { this.close(); } }
					]
			}
		]
	} );
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    var detailRows_tab2_subpodr = [];
    $('#sp-tab2_subpodr-table tbody').on( 'click', 'tr td.details-control', function () {
      var tr = $(this).closest('tr');
      var row = table_tab2_subpodr.row( tr );
      var idx = $.inArray( tr.attr('id'), detailRows_tab2_subpodr );
      if ( row.child.isShown() ) {
	      tr.removeClass( 'details' );
	      row.child.hide();
	      detailRows_tab2_subpodr.splice( idx, 1 );
      }
      else {
        tr.addClass( 'details' );
				rowData = table_tab2_subpodr.row( row );
				d = row.data();
				rowData.child( <?php include('templates/sp-details_tab2_subpodr.tpl'); ?> ).show();
	      if ( idx === -1 ) {
					detailRows_tab2_subpodr.push( tr.attr('id') );
	      }
			}
    } );
//
		table_tab2_subpodr.on( 'draw', function () {
			$.each( detailRows_tab2_subpodr, function ( i, id ) {
			$('#'+id+' td.details-control').trigger( 'click' );
	  } );
	} );
} );
</script>
<?php
// ----- ----- ----- ----- -----
// Подключаем форму редактирования и выводим таблицу
// :::
include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/sp/sp-details/restr_5/tabs/forms/sp-details-tab2_subpodr-customForm.php");
// ----- ----- ----- ----- -----
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/sp/sp-details/restr_5/tabs/css/sp-details-tab2_subpodr-main.css">
<section>
	<div id="sp-tab2_subpodr" class="">
		<div id="tab2_subpodr" class="">
			<div class="demo-html"></div>
			<table id="sp-tab2_subpodr-table" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th><span class='glyphicon glyphicon-option-vertical'></span></th>
						<th>Краткое название</th>
						<th>Полное название</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</section>
