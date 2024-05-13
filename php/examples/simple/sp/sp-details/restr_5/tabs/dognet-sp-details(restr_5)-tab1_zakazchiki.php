
<script type="text/javascript" language="javascript" class="init">
//
//
var table_tab1_zakazchiki;
var editor_tab1_zakazchiki;		// use a global for the submit and return data rendering in the examples
//
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
//
$(document).ready(function() {
//
	editor_tab1_zakazchiki = new $.fn.dataTable.Editor( {
		display: "bootstrap",
		ajax: "php/examples/php/sp/sp-details/dognet-sp-details-tab1_zakazchiki-process.php",
		table: "#sp-tab1_zakazchiki-table",
    i18n: {
        create: { title: "<h3>Добавить нового заказчика</h3>" },
        edit: { title: "<h3>Редактировать заказчика</h3>" },
        remove: {
	        title: "<h3>Удалить заказчика</h3>",
					confirm: {
            "_": "Вы уверены, что хотите удалить %d записи(ей)?",
            "1": "Вы уверены, что хотите удалить этого заказчика?"
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
		template: '#customForm-tab1_zakazchiki',
		fields: [
			{
				label: "Краткое название :",
				name: "namezakshot",
				type: "textarea",
				attr: { placeholder: 'Краткое название компании-заказчика' }
			}, {
				label: "Полное название :",
				name: "namezaklong",
				type: "textarea",
				attr: { placeholder: 'Полное название компании-заказчика' }
			}, {
				label: "Юридический адрес :",
				name: "zakuraddress",
				type: "textarea",
				attr: { placeholder: 'Юридический адрес' }
			}, {
				label: "Банковские реквизиты :",
				name: "zakbankch",
				type: "textarea",
				attr: { placeholder: 'Банковские реквизиты' }
			}, {
				label: "ИНН :",
				name: "zakinn",
				attr: { placeholder: 'ИНН' }
			}, {
				label: "КПП :",
				name: "zakkpp",
				attr: { placeholder: 'КПП' }
			}, {
				label: "Должность контакта :",
				name: "zakdolg",
				attr: { placeholder: 'Должность получателя документа' }
			}, {
				label: "Фамилия :",
				name: "zaklastname",
				attr: { placeholder: 'Фамилия получателя' }
			}, {
				label: "Имя :",
				name: "zakfistname",
				attr: { placeholder: 'Имя получателя' }
			}, {
				label: "Отчество :",
				name: "zakmidname",
				attr: { placeholder: 'Отчество получателя' }
			}, {
				label: "Телефон / Факс / Контакт :",
				name: "zaktelnumber",
				attr: { placeholder: 'Телефон / факс компании-заказчика' }
			}, {
				label: "Фактический адрес :",
				name: "zakaddressfact",
				type: "textarea",
				attr: { placeholder: 'Фактический адрес' }
			}
		]
	} );
//
// Изменяем размер диалогового окна редактирования договора субподряда
	editor_tab1_zakazchiki.on( 'open', function () { $(".modal-dialog").css({
		"width":"60%",
		"min-width":"640px",
		"max-width":"800px"
		});
	} );
	editor_tab1_zakazchiki.on( 'close', function () { $(".modal-dialog").css({
		"width":"80%",
		"min-width":"none",
		"max-width":"none"
		});
	} );
//
// ----- --- ----- --- -----
//
	table_tab1_zakazchiki = $('#sp-tab1_zakazchiki-table').DataTable( {
		dom: "<'row'<'col-sm-5'B><'col-sm-4'><'col-sm-3'l>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'p>>",
		language: {
			url: "php/examples/simple/sp/sp-details/dt_russian-sp-zakazchiki.json"
		},
		ajax: {
			url: "php/examples/php/sp/sp-details/dognet-sp-details-tab1_zakazchiki-process.php",
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
			{ data: "namezakshot" },
			{ data: "namezaklong" },
			{ data: "zakfio" },
			{ data: "zaktelnumber" },
			{ data: "zakuraddress" },
		],
		columnDefs: [
			{ orderable: false, searchable: false, targets: 0 },
			{ orderable: false, searchable: true, targets: 1 },
			{ orderable: false, searchable: true, targets: 2 },
			{ orderable: false, searchable: true,
				render: function( data, type, row, meta ) {
					last = (row.zaklastname!='') ? row.zaklastname : '';
					first = (row.zakfistname!='') ? row.zakfistname : '';
					mid = (row.zakmidname!='') ? row.zakmidname : '';
					return last+'&nbsp;'+first+'&nbsp;'+mid;
				},
				targets: 3
			},
			{ orderable: false, searchable: true, visible:false, targets: 4 },
			{ orderable: false, searchable: true, visible:false, targets: 5 }
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
					$('#tab1_zakNameSearch_text').val('');
					$('#tab1_zakRukSearch_text').val('');
					$('#tab1_zakAddrSearch_text').val('');
					$('#tab1_zakTelSearch_text').val('');
					table_tab1_zakazchiki.columns().search('');
					table_tab1_zakazchiki.order([1,"asc"]).draw();
				}
			},
			{ extend: "create", editor: editor_tab1_zakazchiki, text: "ДОБАВИТЬ ЗАКАЗЧИКА",
				formButtons:
					[ 'Добавить заказчика',
						{ text: 'Отмена', action: function () { this.close(); } }
					]
			},
			{ extend: "edit", editor: editor_tab1_zakazchiki, text: "РЕДАКТИРОВАТЬ",
				formButtons:
					[ 'Сохранить изменения',
						{ text: 'Отмена', action: function () { this.close(); } }
					]
			},
			{ extend: "remove", editor: editor_tab1_zakazchiki, text: "УДАЛИТЬ",
				formButtons:
					[ 'Удалить заказчика',
						{ text: 'Отмена', action: function () { this.close(); } }
					]
			}
		]
	} );
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    var detailRows_tab1_zakazchiki = [];
    $('#sp-tab1_zakazchiki-table tbody').on( 'click', 'tr td.details-control', function () {
      var tr = $(this).closest('tr');
      var row = table_tab1_zakazchiki.row( tr );
      var idx = $.inArray( tr.attr('id'), detailRows_tab1_zakazchiki );
      if ( row.child.isShown() ) {
	      tr.removeClass( 'details' );
	      row.child.hide();
	      detailRows_tab1_zakazchiki.splice( idx, 1 );
      }
      else {
        tr.addClass( 'details' );
				rowData = table_tab1_zakazchiki.row( row );
				d = row.data();
				rowData.child( <?php include('templates/sp-details_tab1_zakazchiki.tpl'); ?> ).show();
	      if ( idx === -1 ) {
					detailRows_tab1_zakazchiki.push( tr.attr('id') );
	      }
			}
    } );
//
		table_tab1_zakazchiki.on( 'draw', function () {
			$.each( detailRows_tab1_zakazchiki, function ( i, id ) {
			$('#'+id+' td.details-control').trigger( 'click' );
	  } );
	} );
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		$('#tab1_zakazchikiSearch_btnApply').click(function(e){
			table_tab1_zakazchiki
				.columns(1)
				.search($("#tab1_zakNameSearch_text").val())
				.draw();
//
			table_tab1_zakazchiki
				.columns(3)
				.search($("#tab1_zakRukSearch_text").val())
				.draw();
//
			table_tab1_zakazchiki
				.columns(5)
				.search($("#tab1_zakAddrSearch_text").val())
				.draw();
//
			table_tab1_zakazchiki
				.columns(4)
				.search($("#tab1_zakTelSearch_text").val())
				.draw();
		});
//
		$('#tab1_zakazchikiSearch_btnClear').click(function(e){
			$('#tab1_zakNameSearch_text').val('');
			$('#tab1_zakRukSearch_text').val('');
			$('#tab1_zakAddrSearch_text').val('');
			$('#tab1_zakTelSearch_text').val('');
			table_tab1_zakazchiki
				.columns()
				.search('')
				.draw();
		});
// ----- ----- ----- ----- -----
		$("#tab1_zakNameSearch_text").on("keyup", function(event) {
		  if (event.keyCode === 13) { event.preventDefault(); document.getElementById("tab1_zakazchikiSearch_btnApply").click(); }
		});
		$("#tab1_zakRukSearch_text").on("keyup", function(event) {
		  if (event.keyCode === 13) { event.preventDefault(); document.getElementById("tab1_zakazchikiSearch_btnApply").click(); }
		});
		$("#tab1_zakAddrSearch_text").on("keyup", function(event) {
		  if (event.keyCode === 13) { event.preventDefault(); document.getElementById("tab1_zakazchikiSearch_btnApply").click(); }
		});
		$("#tab1_zakTelSearch_text").on("keyup", function(event) {
		  if (event.keyCode === 13) { event.preventDefault(); document.getElementById("tab1_zakazchikiSearch_btnApply").click(); }
		});
} );
</script>
<?php
// ----- ----- ----- ----- -----
// Подключаем форму редактирования, форму поиска и выводим таблицу
// :::
include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/sp/sp-details/restr_5/tabs/forms/sp-details-tab1_zakazchiki-customForm.php");
include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/sp/sp-details/restr_5/tabs/forms/sp-details-tab1_zakazchiki-filters.php");
// ----- ----- ----- ----- -----
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/sp/sp-details/restr_5/tabs/css/sp-details-tab1_zakazchiki-main.css">
<section>
	<div id="sp-tab1_zakazchiki" class="">
		<div id="tab1_zakazchiki" class="">
			<div class="demo-html"></div>
			<table id="sp-tab1_zakazchiki-table" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th width="2%" class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
						<th>Краткое название</th>
						<th>Полное название</th>
						<th>Руководитель</th>
						<th>Телефон / факс</th>
						<th></th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</section>
