
<script type="text/javascript" language="javascript" class="init">

var table_tab8_contact;
var editor_tab8_contact;

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
//
$(document).ready(function() {
//
	editor_tab8_contact = new $.fn.dataTable.Editor( {
		display: "bootstrap",
		ajax: "php/examples/php/sp/sp-details/dognet-sp-details-tab8_contact-process.php",
		table: "#sp-tab8_contact-table",
    i18n: {
        create: { title: "<h3>Добавить нового исполнителя</h3>" },
        edit: { title: "<h3>Редактировать исполнителя</h3>" },
        remove: {
	        title: "<h3>Удалить исполнителя</h3>",
					confirm: {
            "_": "Вы уверены, что хотите удалить %d записи(ей)?",
            "1": "Вы уверены, что хотите удалить этого исполнителя?"
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
		template: '#customForm-tab8_contact',
		fields: [
			{
				label: "Фамилия :",
				name: "dognet_spcontact.namecontactend",
				attr: { placeholder: 'Фамилия' }
			}, {
				label: "Имя :",
				name: "dognet_spcontact.namecontactfist",
				attr: { placeholder: 'Имя' }
			}, {
				label: "Отчество :",
				name: "dognet_spcontact.namecontactsecond",
				attr: { placeholder: 'Отчество' }
			}, {
				label: "Краткое имя :",
				name: "dognet_spcontact.namecontactshot",
				attr: { placeholder: 'Фамилия И.О.' }
			}, {
				label: "Телефон 1 :",
				name: "dognet_spcontact.telcontact1",
				attr: { placeholder: 'Телефон' }
			}, {
				label: "Телефон 2 :",
				name: "dognet_spcontact.telcontact2",
				attr: { placeholder: 'Телефон' }
			}, {
				label: "Телефон 3 :",
				name: "dognet_spcontact.telcontact3",
				attr: { placeholder: 'Телефон' }
			}, {
				label: "Сотовый :",
				name: "dognet_spcontact.telcontactmobi",
				attr: { placeholder: 'Сотовый телефон' }
			}, {
				label: "Email :",
				name: "dognet_spcontact.emailcontact",
				attr: { placeholder: 'Email' }
			}, {
				label: "Факс :",
				name: "dognet_spcontact.faxcontact",
				attr: { placeholder: 'Факс' }
			}, {
				label: "Должность :",
				name: "dognet_spcontact.doljcontact",
				attr: { placeholder: 'Должность' }
			}, {
				label: "Комментарий :",
				name: "dognet_spcontact.contactprim",
				attr: { placeholder: 'Комментарий' }
			}
		]
	} );
//
// Изменяем размер диалогового окна редактирования договора субподряда
	editor_tab8_contact.on( 'open', function () { $(".modal-dialog").css({
		"width":"60%",
		"min-width":"640px",
		"max-width":"800px"
		});
	} );
	editor_tab8_contact.on( 'close', function () { $(".modal-dialog").css({
		"width":"80%",
		"min-width":"none",
		"max-width":"none"
		});
	} );
//
// ----- --- ----- --- -----
//
	table_tab8_contact = $('#sp-tab8_contact-table').DataTable( {
		dom: "<'row'<'col-sm-5'><'col-sm-4'><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'><'col-sm-8'>>",
		language: {
			url: "php/examples/simple/sp/sp-details/dt_russian-sp-contact.json"
		},
		ajax: {
			url: "php/examples/php/sp/sp-details/dognet-sp-details-tab8_contact-process.php",
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
			{ data: "dognet_spcontact.namecontactshot" },
			{ data: "dognet_spcontact.doljcontact" },
			{ data: "dognet_spcontact.emailcontact" },
			{ data: "dognet_spcontact.telcontact1" },
			{ data: "dognet_spcontact.telcontactmobi" }
		],
		columnDefs: [
			{ orderable: false, searchable: false, targets: 0 },
			{ orderable: false, searchable: true,
				render: function( data, type, row, meta ) {
					last = (row.dognet_spcontact.namecontactend!='') ? row.dognet_spcontact.namecontactend : '';
					first = (row.dognet_spcontact.namecontactfist!='') ? row.dognet_spcontact.namecontactfist : '';
					mid = (row.dognet_spcontact.namecontactsecond!='') ? row.dognet_spcontact.namecontactsecond : '';
					return last+'&nbsp;'+first+'&nbsp;'+mid;
				},
				targets: 1
			},
			{ orderable: false, searchable: true, targets: 2 },
			{ orderable: false, searchable: true, targets: 3 },
			{ orderable: false, searchable: true, targets: 4 },
			{ orderable: false, searchable: true, targets: 5 }
		],
		order: [ [ 1, "asc" ] ],
		select: true,
		processing: true,
		paging: true,
		searching: true,
		pageLength: 15,
		lengthChange: false,
		lengthMenu: [ [15, 30, 50, -1], [15, 30, 50, "Все"] ],
		buttons: [ ]
	} );
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    var detailRows_tab8_contact = [];
    $('#sp-tab8_contact-table tbody').on( 'click', 'tr td.details-control', function () {
      var tr = $(this).closest('tr');
      var row = table_tab8_contact.row( tr );
      var idx = $.inArray( tr.attr('id'), detailRows_tab8_contact );
      if ( row.child.isShown() ) {
	      tr.removeClass( 'details' );
	      row.child.hide();
	      detailRows_tab8_contact.splice( idx, 1 );
      }
      else {
        tr.addClass( 'details' );
				rowData = table_tab8_contact.row( row );
				d = row.data();
				rowData.child( <?php include('templates/sp-details_tab8_contact.tpl'); ?> ).show();
	      if ( idx === -1 ) {
					detailRows_tab8_contact.push( tr.attr('id') );
	      }
			}
    } );
//
		table_tab8_contact.on( 'draw', function () {
			$.each( detailRows_tab8_contact, function ( i, id ) {
				$('#'+id+' td.details-control').trigger( 'click' );
		  } );
		} );
} );
</script>
<?php
// ----- ----- ----- ----- -----
// Подключаем форму редактирования и выводим таблицу
// :::
// include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/sp/sp-details/restr_5/tabs/forms/sp-details-tab8_contact-customForm.php");
// ----- ----- ----- ----- -----
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/sp/sp-details/restr_5/tabs/css/sp-details-tab8_contact-main.css">
<section>
	<div id="sp-tab8_contact" class="">
		<div id="tab8_contact" class="">
			<div class="demo-html"></div>
			<table id="sp-tab8_contact-table" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th><span class='glyphicon glyphicon-option-vertical'></span></th>
						<th>Краткое имя</th>
						<th>Полное имя</th>
						<th>Исполнитель</th>
						<th>Email</th>
						<th>ДОГ</th>
						<th>ЗВК</th>
						<th>ГИП1</th>
						<th>ГИП2</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</section>
