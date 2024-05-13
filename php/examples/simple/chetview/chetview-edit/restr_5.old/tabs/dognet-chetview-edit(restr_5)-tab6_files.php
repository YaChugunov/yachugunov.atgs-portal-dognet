
<script type="text/javascript" language="javascript" class="init">

$(document).ready(function() {

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

	var	editor_tab6_files = new $.fn.dataTable.Editor( {
		display: "bootstrap",
		ajax: "php/examples/php/chetview/chetview-edit/dognet-chetview-edit-tab6_files-process.php",
		table: "#chetview-edit-tab6_files",
    i18n: {
        create: { title: "<h3>Новый договор субподряда</h3>" },
        edit: { title: "<h3>Изменить параметры договора</h3>" },
        remove: {
            button: "Удалить",
            title:  "<h3>Удалить договор субподряда</h3>",
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
            next:     'След',
            months:   [ 'Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь' ],
            weekdays: [ 'Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб' ]
        }
    },
		template: '#customForm_tab6_files',
		fields: [
			{
				label: "Основной документ",
		    type:  "checkbox",
		    name:  "dognet_docpaper.kodmainpaper",
				options: [ { label: "", value: 1 } ],
				separator: "",
				unselectedValue: 0
// ----- ----- ----- ----- -----
			}, {
				label: "Тип документа :",
				name: "dognet_docpaper.kodpaper",
				type: "select",
				def: "---",
				placeholder: "Выберите тип документа"
// ----- ----- ----- ----- -----
			}, {
				label: "Дата загрузки",
				name: "dognet_docpaper.dateloader",
				type: "datetime",
				format: "DD.MM.YYYY",
				def: function () { return new Date(); },
				attr: { readonly: "readonly" }
// ----- ----- ----- ----- -----
			}, {
				label: "XXX",
				name: "dognet_docpaper.koddocpaper"
// ----- ----- ----- ----- -----
			}, {
				name: "dognet_docpaper.docFileID",
				type: "upload",
				display: function ( id ) { return '<a target="_blank" href="'+editor_tab6_files.file( 'dognet_docpaper_files', id ).file_webpath+'"><h4>СКАЧАТЬ ФАЙЛ</h4></a>'; }
			}, {
				type: "readonly",
				name: "dognet_docpaper.msgDocFileID"
// ----- ----- ----- ----- -----
			}, {
				label: "Описание документа",
				name: "dognet_docpaper.paperfull"
			}
		]
	} );
//
// Изменяем размер диалогового окна редактирования договора субподряда
	editor_tab6_files.on( 'open', function () { $(".modal-dialog").css({
		"width":"50%",
		"min-width":"800px",
		"max-width":"1170px"
		});
	} );
	editor_tab6_files.on( 'close', function () { $(".modal-dialog").css({
		"width":"80%",
		"min-width":"none",
		"max-width":"none"
		});
	} );
//
// ----- --- ----- --- -----
//
	editor_tab6_files.on('initCreate', function ( e ) {
		editor_tab6_files.field('dognet_docpaper.msgDocFileID').show();
		editor_tab6_files.field('dognet_docpaper.msgDocFileID').val('Сначала создайте запись!');
		editor_tab6_files.field('dognet_docpaper.docFileID').hide();
		editor_tab6_files.field('dognet_docpaper.docFileID').disable();
	});
// ----- --- ----- --- -----
	editor_tab6_files.on('initEdit', function ( e, node, data, items, type ) {
		editor_tab6_files.field('dognet_docpaper.msgDocFileID').hide();
		editor_tab6_files.field('dognet_docpaper.docFileID').show();
		editor_tab6_files.field('dognet_docpaper.docFileID').enable();
	});
//
//
// ----- --- ----- --- -----
	var table_tab6_files = $('#chetview-edit-tab6_files').DataTable( {
		dom: "<'row'<'col-md-8 col-sm-12'B><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'>>",
		language: {
				url: "php/examples/simple/chetview/chetview-edit/dt_russian-tab6_files.json"
		},
		ajax: {
			url: "php/examples/php/chetview/chetview-edit/dognet-chetview-edit-tab6_files-process.php",
			type: "POST",
	    data: function ( d ) {  }
		},
		serverSide: true,
	  select: {
	      style: 'single'
	  },
		columns: [
			{
				data: null,
				class: "details-control",
				searchable: false,
				orderable: false,
				defaultContent: "<span class='glyphicon glyphicon-option-vertical'></span>"
			},
			{ data: "dognet_docpaper.koddocpaper", className: "text-left" },
			{ data: "dognet_docpaper.dateloader", className: "text-left" },
			{ data: "dognet_docpaper.kodpaper", className: "text-left" },
			{ data: "dognet_docpaper.paperfull", className: "text-left" },
            {
                data: "dognet_docpaper.docFileID",
                render: function ( id ) {
                    return id ?
                        '<a class="" target="_blank" href="'+editor_tab6_files.file( 'dognet_docpaper_files', id ).file_webpath+'"><span class="glyphicon glyphicon-file"></span></a>' :
                        '<span class="glyphicon glyphicon-option-horizontal"></span>';
                },
                defaultContent: "",
				className: "text-center"
            }
		],
		columnDefs: [
			{ orderable: false, searchable: false, targets: 0 },
			{ orderable: false, searchable: false, targets: 1 },
			{ orderable: true, searchable: false, targets: 2 },
			{ orderable: true, visible: false, searchable: false, targets: 3 },
			{ orderable: false, searchable: false, targets: 4 },
			{ orderable: false, searchable: false, targets: 5 }
		],
		order: [ [ 2, "desc" ], [ 3, "asc" ] ],
    rowGroup: {
			dataSrc: function(row) {
				return row.dognet_sptippaper.namepaper;
			},
      startRender: function ( rows, group ) {
	      return group;
			},
      endRender: null,
			emptyDataGroup: 'No categories assigned yet'
		},
		buttons: [
	    { text:	'<span class="glyphicon glyphicon-refresh"></span>', action:
	      function ( e, dt, node, config ) {
			    table_tab6_files.ajax.reload();
					table_tab6_files.columns().search('').draw();
				}
			},
			{ extend: "create", editor: editor_tab6_files, text: "НОВЫЙ ДОКУМЕНТ",
				formButtons:
					[ 'Создать',
						{ text: 'Отмена', action: function () { this.close(); } }
					]
			},
			{ extend: "edit", editor: editor_tab6_files, text: "ИЗМЕНИТЬ",
				formButtons:
					[ 'Изменить',
						{ text: 'Отмена', action: function () { this.close(); } }
					]
			},
			{ extend: "remove", editor: editor_tab6_files, text: "УДАЛИТЬ" }
		]
	} );
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Array to track the ids of the edit displayed rows
  var detailRows_tab6_files = [];
  $('#chetview-edit-tab6_files tbody').on( 'click', 'tr td.details-control', function () {
      var tr = $(this).closest('tr');
      var row = table_tab6_files.row( tr );
      var idx = $.inArray( tr.attr('id'), detailRows_tab6_files );

      if ( row.child.isShown() ) {
          tr.removeClass( 'edit' );
          row.child.hide();

          // Remove from the 'open' array
          detailRows_tab6_files.splice( idx, 1 );
      }
      else {
          tr.addClass( 'edit' );
		rowData = table_tab6_files.row( row );
		d = row.data();
		rowData.child( <?php include('templates/chetview-edit_tab6_files.tpl'); ?> ).show();

// Add to the 'open' array
          if ( idx === -1 ) {
              detailRows_tab6_files.push( tr.attr('id') );
          }
      }
  } );
// On each draw, loop over the `detailRows_tab6_files` array and show any child rows
	table_tab6_files.on( 'draw', function () {
		$.each( detailRows_tab6_files, function ( i, id ) {
		$('#'+id+' td.details-control').trigger( 'click' );
	    } );
	} );
} );
</script>
<?php
// ----- ----- ----- ----- -----
// Подключаем форму и выводим таблицу документов
// :::
include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/chetview/chetview-edit/restr_5/tabs/forms/chetview-edit_tab6_files-customForm.php");
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/chetview/chetview-edit/restr_5/tabs/css/chetview-edit-tab6_files.css">
<section>
	<div class="" style="padding-left:5px; padding-right:5px">
		<div class="space30"></div>
		<div class="demo-html"></div>
		<table id="chetview-edit-tab6_files" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
					<th class="text-uppercase">ID</th>
					<th class="text-uppercase">Дата загрузки</th>
					<th class="text-uppercase">Тип документа</th>
					<th class="text-uppercase">Описание</th>
					<th><span class="glyphicon glyphicon-file"></span></th>
				</tr>
			</thead>
		</table>
	</div>
</section>


