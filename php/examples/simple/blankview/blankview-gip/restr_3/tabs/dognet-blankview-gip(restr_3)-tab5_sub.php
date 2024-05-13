<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/date-de.js"></script>
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/moment-with-locales.js"></script>

<script type="text/javascript" language="javascript" class="init">

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

$(document).ready(function() {
//
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// ПОЛНОЕ РЕДАКТИРОВАНИЕ БЛАНКА ::: Редактор
	var editor_blankview_edit_pos = new $.fn.dataTable.Editor( {
		display: "bootstrap",
		ajax: "php/examples/php/blankview/blankview-gip/dognet-blankview-gip-pos-process.php",
		table: "#blankview-gip-pos-table",
    i18n: {
        create: { title: "<h3>Добавить новый счет-фактуру</h3>" },
        edit: { title: "<h3>Изменить счет-фактуру</h3>" },
        remove: {
            button: "Удалить",
            title:  "<h3>Удалить счет-фактуру</h3>",
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
		template: '#customForm_newblank_pos',
		fields: [
			{
				label: "Номер договора :",
				name: "dognet_docblankwork.numberdoccr"
/*
			}, {
				label: "Передан в работу :",
				name: "dognet_docblankwork.dateblankdoc",
				type: "datetime",
				format: "DD.MM.YYYY",
				def: function () { return new Date(); },
				attr: { readonly: "readonly" }
*/
			}, {
				label: "Заказчик :",
				name: "dognet_docblankwork.kodzakaz",
				type: "select",
				def: "---",
				placeholder: "Выберите заказчика"
			}
		]
	} );
// ----- ----- ----- ----- -----
/*
	$('#blankview-gip-pos-table').on( 'dblclick', 'tbody tr', function () {
	    editor_blankview_edit_pos.edit( this, {
	        focus: 0
	    } );
	} );
*/
//
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// РЕДАКТИРОВАНИЕ ГОТОВОГО БЛАНКА ::: Редактор
	var editor_blankview_gip_pos = new $.fn.dataTable.Editor( {
		display: "bootstrap",
		ajax: "php/examples/php/blankview/blankview-gip/dognet-blankview-gip-pos-process.php",
		table: "#blankview-gip-pos-table",
    i18n: {
        create: { title: "<h3>Добавить новый счет-фактуру</h3>" },
        edit: { title: "<h3>Изменить счет-фактуру</h3>" },
        remove: {
            button: "Удалить",
            title:  "<h3>Удалить счет-фактуру</h3>",
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
/* 		template: '#customForm_docblank-table', */
		fields: [
			{
				label: "Номер договора :",
				name: "dognet_docblankwork.numberdoccr"
			}, {
				label: "Передан в работу :",
				name: "dognet_docblankwork.dateblankdoc",
				type: "datetime",
				format: "DD.MM.YYYY",
				def: function () { return new Date(); },
				attr: { readonly: "readonly" }
			}, {
				label: "Заказчик :",
				name: "dognet_docblankwork.kodzakaz",
				type: "select",
				def: "---",
				placeholder: "Выберите заказчика"
			}
		]
	} );
// ----- ----- ----- ----- -----
	var openVals;
  editor_blankview_gip_pos.on( 'preClose', function ( e ) {
      // On close, check if the values have changed and ask for closing confirmation if they have
      if ( openVals !== JSON.stringify( editor_blankview_gip_pos.get() ) ) {
          return confirm( 'Вы изменили данные формы. Уверены, что хотите выйти из редактирования?' );
      }
  } )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// БЛАНК ГОТОВЫЙ ::: Таблица данных
	var table_blankview_gip_pos = $('#blankview-gip-pos-table').DataTable( {
		dom: "<'row'<'col-sm-5'B><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'p>>",
// 		dom: "<'space50'r>tip",
		language: {	url: "russian.json" },
		ajax: {
			url: "php/examples/php/blankview/blankview-gip/dognet-blankview-gip-pos-process.php",
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
			{ data: "dognet_docblankwork.numberblankwork", className: "" },
			{ data: "dognet_docblankwork.yearblankwork", className: "" },
			{ data: "dognet_docblankwork.nameblankwork", className: "" },
			{ data: "dognet_docblankwork.nameorgblankwork", className: "" },
			{ data: "dognet_docblankwork.kodstatusblank", className: "" },
			{ data: "dognet_docblankwork.numberdoccr", className: "" },
			{ data: "dognet_docblankwork.dateblankorder", className: "" },
			{ data: "dognet_docblankwork.dateblankwork", className: "" },
			{ data: "dognet_docblankwork.dateblankdoc", className: "" },
			{
				data: null,
				defaultContent: '<a href="" class="edit_listalt"><span class="glyphicon glyphicon-list-alt"></span></a>',
				className: "text-right"
			},
			{ data: "dognet_sysdefs_blankstatus.id" },
			{ data: "dognet_spispol.ispolnameshot" },
			{ data: "dognet_docblankwork.kodtipblank" }
		],
		select: {
			style: 'os',
			selector: 'td:not(:last-child)' // no row selection on last column
		},
		columnDefs: [
			{ orderable: false, searchable: false, targets: 0 },
			{ orderable: false, searchable: true, targets: 1 },
			{ orderable: false, searchable: true, targets: 2 },
			{
				orderable: false,
				searchable: true,
				targets: 3,
				render: function ( data, type, row, meta ) {
					fullstr = data;
					if (data.length > 75) { return data.substr(0,75)+" ..."; }
					else { return data;	}
				}
			},
			{ orderable: false, searchable: true, targets: 4 },
			{
				orderable: false,
				visible: false,
				searchable: true,
				targets: 5,
				render: function ( data, type, row, meta ) {
					return row.dognet_docblankwork.nametipblankwork;
				}
			},
			{ orderable: false, searchable: true, targets: 6 },
			{ orderable: false, searchable: false, targets: 7 },
			{ orderable: false, searchable: false, visible: false, targets: 8 },
			{ orderable: false, searchable: false, targets: 9 },
			{
				orderable: false,
				searchable: false,
				targets: 10,
				render: function ( data, type, row, meta ) {
					var blanktype = row.dognet_docblankwork.kodstatusblank;
					if (row.dognet_docblankwork.kodstatusblank == "DO") {
						return '<span style="padding:0 5px"><a href="dognet-blankview.php?blankview_type=details&uniqueID='+row.dognet_docblankwork.kodblankwork+'"><span class="glyphicon glyphicon-list-alt"></span></a></span>'+'<span style="padding:0 5px"><a href=""><span class="glyphicon glyphicon-comment"></span></a></span>';
					}
					else {
					return '<span style="padding:0 5px"><a href="dognet-blankview.php?blankview_type=details&uniqueID='+row.dognet_docblankwork.kodblankwork+'"><span class="glyphicon glyphicon-list-alt"></span></a></span>'+'<span style="padding:0 5px"><a href="dognet-blankview.php?blankview_type=edit&uniqueID='+row.dognet_docblankwork.kodblankwork+'"><span class="glyphicon glyphicon-pencil"></span></a></span>'+'<span style="padding:0 5px"><a href=""><span class="glyphicon glyphicon-comment"></span></a></span>';
					}
				}
			},
			{ orderable: false, searchable: false, visible: false, targets: 11 },
			{ orderable: false, searchable: true, visible: false, targets: 12 },
			{ orderable: false, searchable: true, visible: false, targets: 13 }
		],
		order: [ [ 11, "asc" ], [ 2, "desc" ], [ 5, "asc" ] ],
		select: true,
		processing: true,
		paging: true,
		searching: true,
		pageLength: 10,
		lengthChange: false,
		lengthMenu: [ [15, 30, 50, -1], [15, 30, 50, "Все"] ],
		buttons: [
			{ text:	'<span class="glyphicon glyphicon-refresh"></span>', action:
				function ( e, dt, node, config ) {
					$('#blankNumberSearch_text').val('');
					$('#docNumberSearch_text').val('');
					$('#blankYearSearch_text').val('');
					$('#blankStatusSearch_text').val('');
					$('#blankNameSearch_text').val('');
					$('#blankObjectSearch_text').val('');
					$('#blankTypeSearch_text').val('');
					$('#blankIspolSearch_text').val('');
					table_blankview_gip_pos.columns().search('');
					table_blankview_gip_pos.draw();
				}
			},
			{ extend: "create", editor: editor_blankview_edit_pos, text: "НОВЫЙ БЛАНК",
				formButtons:
					[ 'Создать',
						{ text: 'Отмена', action: function () { this.close(); } }
					]
			},
			{ extend: "edit", editor: editor_blankview_gip_pos, text: "ИЗМЕНИТЬ",
				formButtons:
					[ 'Изменить',
						{ text: 'Отмена', action: function () { this.close(); } }
					]
			},
			{ extend: "remove", editor: editor_blankview_gip_pos, text: "УДАЛИТЬ" }
		],
    rowGroup: {
		    startRender: function ( rows, group, level ) {

					if (level==0) {
						if (group == "CR") {
							return '<span style="text-align:left; white-space:nowrap">Новые бланки требований</span>';
						}
						else if (group == "RD") {
							return '<span style="text-align:left; white-space:nowrap">Бланки в работе</span>';
						}
						else if (group == "DO") {
							return '<span style="text-align:left; white-space:nowrap">Бланки оформленные и переданные в отдел договоров</span>';
						}
						else {
							return '<span style="text-align:left; white-space:nowrap">Прочие бланки</span>';
						}
					}

		    },
        endRender: function ( rows, group, level ) {
        },
        dataSrc: [ "dognet_docblankwork.kodstatusblank" ]
    },
		createdRow: function ( row, data, index ) {
			if ( data.dognet_docblankwork.kodstatusblank === "CR" ) {
					$(row).css({
						"color": "rgba(149,20,2,1)"
					});
			}
			if ( data.dognet_docblankwork.kodstatusblank === "RD" ) {
					$(row).css({
						"color": "rgba(0,154,0,1)"
					});
			}
		},
		initComplete: function() {

		},
		drawCallback: function () {

		}

	} );
// ----- ----- ----- ----- -----
		$('#globalSearch_button').click(function(e){
			table_blankview_gip_pos.search($("#globalSearch_text").val()).draw();
		});
		$('#clearSearch_button').click(function(e){
			table_blankview_gip_pos.search('').draw();
			$('#globalSearch_text').val('');
		});
		$('#columnSearch_btnApply').click(function(e){
			table_blankview_gip_pos
				.columns(1)
				.search($("#blankNumberSearch_text").val())
				.draw();

			table_blankview_gip_pos
				.columns(6)
				.search($("#docNumberSearch_text").val())
				.draw();

			table_blankview_gip_pos
				.columns(2)
				.search($("#blankYearSearch_text").val())
				.draw();

			table_blankview_gip_pos
				.columns(5)
				.search($("#blankStatusSearch_text").val())
				.draw();

			table_blankview_gip_pos
				.columns(13)
				.search($("#blankTypeSearch_text").val())
				.draw();

			table_blankview_gip_pos
				.columns(4)
				.search($("#blankObjectSearch_text").val())
				.draw();

			table_blankview_gip_pos
				.columns(3)
				.search($("#blankNameSearch_text").val())
				.draw();

			table_blankview_gip_pos
				.columns(12)
				.search($("#blankIspolSearch_text").val())
				.draw();

		});
		$('#columnSearch_btnClear').click(function(e){
			$('#blankNumberSearch_text').val('');
			$('#docNumberSearch_text').val('');
			$('#blankYearSearch_text').val('');
			$('#blankStatusSearch_text').val('');
			$('#blankNameSearch_text').val('');
			$('#blankObjectSearch_text').val('');
			$('#blankTypeSearch_text').val('');
			$('#blankIspolSearch_text').val('');
			table_blankview_gip_pos
				.columns()
				.search('')
				.draw();
		});
// ----- ----- ----- ----- -----
		$("#blankNumberSearch_text").on("keyup", function(event) {
		  if (event.keyCode === 13) { event.preventDefault(); document.getElementById("columnSearch_btnApply").click(); }
		});
		$("#docNumberSearch_text").on("keyup", function(event) {
		  if (event.keyCode === 13) { event.preventDefault(); document.getElementById("columnSearch_btnApply").click(); }
		});
		$("#blankYearSearch_text").on("keyup", function(event) {
		  if (event.keyCode === 13) { event.preventDefault(); document.getElementById("columnSearch_btnApply").click(); }
		});
		$("#blankNameSearch_text").on("keyup", function(event) {
		  if (event.keyCode === 13) { event.preventDefault(); document.getElementById("columnSearch_btnApply").click(); }
		});
		$("#blankObjectSearch_text").on("keyup", function(event) {
		  if (event.keyCode === 13) { event.preventDefault(); document.getElementById("columnSearch_btnApply").click(); }
		});
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
//
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Array to track the ids of the edit displayed rows
    var detailRows = [];

    $('#blankview-gip-pos-table tbody').on( 'click', 'tr td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table_blankview_gip_pos.row( tr );
        var idx = $.inArray( tr.attr('id'), detailRows );

        if ( row.child.isShown() ) {
            tr.removeClass( 'edit' );
            row.child.hide();

            // Remove from the 'open' array
            detailRows.splice( idx, 1 );
        }
        else {
            tr.addClass( 'edit' );
			rowData = table_blankview_gip_pos.row( row );
			d = row.data();
			rowData.child( <?php include('templates/blankview-gip-pos-table.tpl'); ?> ).show();

// Add to the 'open' array
            if ( idx === -1 ) {
                detailRows.push( tr.attr('id') );
            }
        }
    } );
// On each draw, loop over the `detailRows` array and show any child rows
	table_blankview_gip_pos.on( 'draw', function () {
		$.each( detailRows, function ( i, id ) {
		$('#'+id+' td.details-control').trigger( 'click' );
	    } );
	} );
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
//
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// БЛАНК РАБОЧИЙ ::: Редактор
	var editor_blankview_docfiles = new $.fn.dataTable.Editor( {
		display: "bootstrap",
		ajax: "php/examples/php/blankview/blankview-gip/dognet-blankview-docfiles-process.php",
		table: "#blankview-docfiles-table",
    i18n: {
        create: { title: "<h3>Добавить новый счет-фактуру</h3>" },
        edit: { title: "<h3>Изменить счет-фактуру</h3>" },
        remove: {
            button: "Удалить",
            title:  "<h3>Удалить счет-фактуру</h3>",
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
/* 		template: '#customForm_docblank-table', */
		fields: [
		]
	} );
// ----- ----- ----- ----- -----
// БЛАНК РАБОЧИЙ ::: Таблица данных
	var table_blankview_docfiles = $('#blankview-docfiles-table').DataTable( {
		dom: "<'row'<'col-sm-5'><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'><'col-sm-8'>>",
// 		dom: "<'space50'r>tip",
		language: {	url: "russian.json" },
		ajax: {
			url: "php/examples/php/blankview/blankview-gip/dognet-blankview-docfiles-process.php",
			type: 'post',
      data: function ( d ) {
          var selected = table_blankview_gip_pos.row( { selected: true } );
          if ( selected.any() ) {
					    d.kodblankwork = selected.data().dognet_docblankwork.kodblankwork;
		          console.log("Kodblankwork ("+selected.id()+") :: kodblankwork: "+d.kodblankwork);
          }
			}
		},
		serverSide: true,
		columns: [
			{ data: "dognet_docblankwork_files.blank_type", className: "text-center" },
			{ data: "dognet_docblankwork_files.blank_status", className: "text-center" },
			{ data: "dognet_docblankwork_files.file_name", className: "text-center" },
			{ data: "dognet_docblankwork_files.file_extension", className: "text-center" }
		],
		select: {
			style: 'os',
			selector: 'td:not(:last-child)' // no row selection on last column
		},
		columnDefs: [
			{ orderable: false, searchable: true, targets: 0 },
			{ orderable: false, searchable: true, targets: 1 },
			{ orderable: false, searchable: true,
				render: function ( data, type, row, meta ) {
					return '<a class="blank_link" href="'+row.dognet_docblankwork_files.file_url+'" target="_blank">'+row.dognet_sysdefs_blankstatus.status_description+'</a>';
					},
				targets: 2
			},
			{ orderable: false, searchable: true,
				render: function ( data, type, row, meta ) {
					return '<span class="label label-primary">'+data+'</span>';
					},
				targets: 3
			}
		],
		select: false,
		processing: true,
		paging: false,
		searching: false,
		initComplete: function() {

		},
		drawCallback: function (settings) {

		}
	} );
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
//
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// ПРИЛОЖЕНИЯ БЛАНКА ::: Редактор
	var editor_blankview_blankpril = new $.fn.dataTable.Editor( {
		display: "bootstrap",
		ajax: "php/examples/php/blankview/blankview-gip/dognet-blankview-blankpril-process.php",
		table: "#blankview-blankpril-table",
    i18n: {
        create: { title: "<h3>Добавить новый счет-фактуру</h3>" },
        edit: { title: "<h3>Изменить счет-фактуру</h3>" },
        remove: {
            button: "Удалить",
            title:  "<h3>Удалить счет-фактуру</h3>",
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
/* 		template: '#customForm_docblank-table', */
		fields: [
		]
	} );
// ----- ----- ----- ----- -----
// ПРИЛОЖЕНИЯ БЛАНКА ::: Таблица данных
	var table_blankview_blankpril = $('#blankview-blankpril-table').DataTable( {
		dom: "<'row'<'col-sm-5'><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'><'col-sm-8'>>",
// 		dom: "<'space50'r>tip",
		language: {	url: "russian.json" },
		ajax: {
			url: "php/examples/php/blankview/blankview-gip/dognet-blankview-blankpril-process.php",
			type: 'post',
      data: function ( d ) {
          var selected = table_blankview_gip_pos.row( { selected: true } );
          if ( selected.any() ) {
					    d.kodblankwork = selected.data().dognet_docblankwork.kodblankwork;
		          console.log("Kodblankwork ("+selected.id()+") :: kodblankwork: "+d.kodblankwork);
          }
			}
		},
		serverSide: true,
		columns: [
			{ data: "dognet_blankworkpril.numberpril", className: "text-center" },
			{ data: "dognet_blankworkpril.namepril", className: "text-center" },
			{ data: "dognet_blankworkpril.extfile", className: "text-center" }
		],
		select: {
			style: 'os',
			selector: 'td:not(:last-child)' // no row selection on last column
		},
		columnDefs: [
			{ orderable: false, searchable: true, targets: 0 },
			{ orderable: false, searchable: true,
				render: function ( data, type, row, meta ) {
					return '<a class="blank_link" href="'+row.dognet_blankworkpril_files.file_url+'" target="_blank">'+data+'</a>';
					},
				targets: 1
			},
			{ orderable: false, searchable: true,
				render: function ( data, type, row, meta ) {
					return '<span class="label label-primary">'+data+'</span>';
					},
				targets: 2
			}
		],
		select: false,
		processing: true,
		paging: false,
		searching: false,
		initComplete: function() {

		},
		drawCallback: function () {

		}
		} );
//
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	table_blankview_gip_pos.on( 'select', function () {
			table_blankview_gip_pos.buttons().enable();
			table_blankview_docfiles.buttons().enable();
	    table_blankview_docfiles.ajax.reload();
			table_blankview_blankpril.buttons().enable();
	    table_blankview_blankpril.ajax.reload();
	} );
	table_blankview_gip_pos.on( 'deselect', function () {
			table_blankview_docfiles.buttons().disable();
	    table_blankview_docfiles.ajax.reload();
			table_blankview_blankpril.buttons().disable();
	    table_blankview_blankpril.ajax.reload();
	} );
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

} );
</script>

<style>
/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----

ОСНОВНАЯ ТАБЛИЦА

----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
/*
/* Общее для таблицы */
#blankview-gip-pos-table {  }
#blankview-gip-pos-table .details-control:hover { cursor:hand }
#blankview-gip-pos-table > tbody > tr.selected, #docview-details-tab3 > tbody > tr > .selected { color:#000;	background-color:#e9e9e9 }
/*
/*
/* Заголовок таблицы */
#blankview-gip-pos-table > thead {	background-color:#111;	color:#fff; font-family:'Oswald', sans-serif; border-bottom:none;	border-top:none }
#blankview-gip-pos-table > thead > tr > th { border-bottom:none; font-weight:400; font-size:1.0em; text-transform:uppercase }
#blankview-gip-pos-table .sorting:after, #blankview-gip-pos-table .sorting_asc:after, #blankview-gip-pos-table .sorting_desc:after { display:none }
#blankview-gip-pos-table > thead > tr > th.sorting_asc { padding-right:5px }
#blankview-gip-pos-table > thead > tr > th.sorting_desc { padding-right:5px }
/*
/*
/* Тело таблицы */
#blankview-gip-pos-table {  }
#blankview-gip-pos-table > tbody { font-family:'Helioscond', sans-serif; font-size:1.0em; font-weight:300; color:#666; border-bottom:none; border-top:none }
#blankview-gip-pos-table > tbody > tr > td { padding:5px; line-height:1.42857143; vertical-align:middle; border-top:none }
#blankview-gip-pos-table > thead > tr > th { padding:8px 5px; border-bottom:none }
#blankview-gip-pos-table > tbody > tr > td {  }
#blankview-gip-pos-table > tbody > tr > td:last-child { text-align:right }

#blankview-gip-pos-table > tfoot > tr > td { padding:5px 4px }
#blankview-gip-pos-table > tfoot > tr > td:last-child { text-align:right }
#blankview-gip-pos-table > tfoot {
	background-color:#999;
}

/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
	#blankview-gip-pos-table > thead > tr > th:first-child, #blankview-gip-pos-table > tbody > tr > td:first-child { width:1%; text-align:center }
	#blankview-gip-pos-table > thead > tr > th:nth-child(2), #blankview-gip-pos-table > tbody > tr > td:nth-child(2) { width:3%; text-align:center; border-left:1px #fff solid }
	#blankview-gip-pos-table > thead > tr > th:nth-child(3), #blankview-gip-pos-table > tbody > tr > td:nth-child(3) { width:4%; text-align:center; border-left:1px #fff solid }
	#blankview-gip-pos-table > thead > tr > th:nth-child(4), #blankview-gip-pos-table > tbody > tr > td:nth-child(4) { width:45%; text-align:left; border-left:1px #fff solid }
	#blankview-gip-pos-table > thead > tr > th:nth-child(5), #blankview-gip-pos-table > tbody > tr > td:nth-child(5) { width:19%; text-align:left; border-left:1px #fff solid }
	#blankview-gip-pos-table > thead > tr > th:nth-child(6), #blankview-gip-pos-table > tbody > tr > td:nth-child(6) { width:5%; text-align:center; border-left:1px #fff solid }
	#blankview-gip-pos-table > thead > tr > th:nth-child(7), #blankview-gip-pos-table > tbody > tr > td:nth-child(7) { width:4%; text-align:center; border-left:1px #fff solid }
	#blankview-gip-pos-table > thead > tr > th:nth-child(8), #blankview-gip-pos-table > tbody > tr > td:nth-child(8) { width:7%; text-align:center; border-left:1px #fff solid }
	#blankview-gip-pos-table > thead > tr > th:nth-child(9), #blankview-gip-pos-table > tbody > tr > td:nth-child(9) { width:8%; text-align:center; border-left:1px #fff solid }
	#blankview-gip-pos-table > thead > tr > th:nth-child(10), #blankview-gip-pos-table > tbody > tr > td:nth-child(10) { width:7%; text-align:center; border-left:1px #fff solid }
	#blankview-gip-pos-table > thead > tr > th:nth-child(11), #blankview-gip-pos-table > tbody > tr > td:nth-child(11) { width:5%; text-align:center; border-left:1px #fff solid }
	#blankview-gip-pos-table .details-control:hover { cursor:pointer }

/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
	#blankview-gip-pos-table .sorting_asc:after { display:none }
	#blankview-gip-pos-table > thead > tr > th.sorting_asc { padding-right:8px }
/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
	#row-details { padding:0 35px }
	#row-details-subpodr { font-family:'Oswald', sans-serif; font-size:1.0em; color:#333 }
	#row-details-subpodr > tbody >tr > td { text-align:left }

	#row-details-subpodr .title-column { font-family:'Oswald', sans-serif; font-weight:400 }
	#row-details-subpodr .data-column { font-family: Courier, Courier new, Serif; font-weight:300 }

	#blankview-gip-pos-table > tfoot > tr > td { padding:5px 4px }
	#blankview-gip-pos-table > tfoot {
		background-color:#999;
	}

	#blankview-gip-filters { padding:15px 0; background-color:#f1f1f1 }
	#columnSearch_btnApply .focus, #columnSearch_btnApply .active:focus, #columnSearch_btnApply:active.focus, #columnSearch_btnApply:active:focus, #columnSearch_btnApply:focus { outline:none; border-color:#ccc }
	#columnSearch_btnClear .focus, #columnSearch_btnClear .active:focus, #columnSearch_btnClear:active.focus, #columnSearch_btnClear:active:focus, #columnSearch_btnClear:focus { outline:none; border-color:#ccc }

	#column1_search_docwork, #column2_search_docwork, #column3_search_docwork, #column4_search_docwork {
		width: 100%;
		padding: 5px 5px;
		font-weight: 400;
		font-size: 0.9em;
		color: #333;
		max-height:31px;
	}
	#column1_search_docwork { text-align:center }
	#column2_search_docwork { text-align:center }
	#column3_search_docwork { text-align:left }
	#column4_search_docwork { text-align:left }

	#filters_clear_docwork, #filters_apply_docwork { min-width:50px; max-width:50px; padding:6px; font-weight:400; font-size:0.9em }

#blanksearch-filters-block .panel-title { font-family: 'HeliosCond', sans-serif; font-size: 1.5em; font-weight: 500; padding-top: 5px; text-transform:none }
#blanksearch-filters-block .panel { border:transparent }
/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----

ТАБЛИЦА ФАЙЛОВ БЛАНКОВ : blankview-docfiles-table

----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
#blankview-docfiles { padding:10px 15px; border:1px #e9e9e9 solid; border-radius:5px }
#blankview-docfiles > h3 { color:#111; font-family:'Oswald', sans-serif; font-weight:400; font-size:1.7em; letter-spacing:0.05em }
/* Общее для таблицы */
#blankview-docfiles-table {  }
#blankview-docfiles-table .details-control:hover { cursor:hand }
/* Заголовок таблицы */
#blankview-docfiles-table > thead {	display:none }
#blankview-docfiles-table > thead > tr > th { color:#333; border-bottom:none; font-weight:500; font-size:1.2em; text-transform:uppercase }
#blankview-docfiles-table .sorting:after, #blankview-gip-pos-table .sorting_asc:after, #blankview-gip-pos-table .sorting_desc:after { display:none }
#blankview-docfiles-table > thead > tr > th.sorting_asc { padding-right:8px }
#blankview-docfiles-table > thead > tr > th.sorting_desc { padding-right:8px }
#blankview-docfiles-table .sorting_asc:after { display:none }
#blankview-docfiles-table > thead > tr > th.sorting_asc { padding-right:8px }
/* Тело таблицы */
#blankview-docfiles-table > tbody > tr > td { padding:5px; border:none }
#blankview-docfiles-table > tbody > tr > td:first-child { width:5%; text-align:left }
#blankview-docfiles-table > tbody > tr > td:nth-child(2) { width:5%; text-align:left }
#blankview-docfiles-table > tbody > tr > td:nth-child(3) { width:85%; text-align:left }
#blankview-docfiles-table > tbody > tr > td:nth-child(4) { width:5%; text-align:right; text-transform:uppercase }
/* Разное */
#blankview-docfiles-table a.blank_link { color:#08C; text-decoration:underline }
#blankview-docfiles-table a.blank_link:hover { text-decoration:none }
/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----

ТАБЛИЦА ФАЙЛОВ ПРИЛОЖЕНИЙ : blankview-blankpril-table

----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
#blankview-blankpril { padding:10px 15px; border:2px #e9e9e9 solid; border-radius:5px }
#blankview-blankpril > h3 { color:#111; font-family:'Oswald', sans-serif; font-weight:400; font-size:1.7em; letter-spacing:0.05em }
/* Общее для таблицы */
#blankview-blankpril-table {  }
#blankview-blankpril-table .details-control:hover { cursor:hand }
/* Заголовок таблицы */
#blankview-blankpril-table > thead {	display:none }
#blankview-blankpril-table > thead > tr > th { color:#333; border-bottom:none; font-weight:500; font-size:1.2em; text-transform:uppercase }
#blankview-blankpril-table .sorting:after, #blankview-gip-pos-table .sorting_asc:after, #blankview-gip-pos-table .sorting_desc:after { display:none }
#blankview-blankpril-table > thead > tr > th.sorting_asc { padding-right:8px }
#blankview-blankpril-table > thead > tr > th.sorting_desc { padding-right:8px }
#blankview-blankpril-table .sorting_asc:after { display:none }
#blankview-blankpril-table > thead > tr > th.sorting_asc { padding-right:8px }
/* Тело таблицы */
#blankview-blankpril-table > tbody > tr > td { padding:5px; border:none }
#blankview-blankpril-table > tbody > tr > td:first-child { width:5%; text-align:left }
#blankview-blankpril-table > tbody > tr > td:nth-child(2) { width:90%; text-align:left }
#blankview-blankpril-table > tbody > tr > td:nth-child(3) { width:5%; text-align:right; text-transform:uppercase }
/* Разное */
#blankview-blankpril-table a.blank_link { color:#08C; text-decoration:underline }
#blankview-blankpril-table a.blank_link:hover { text-decoration:none }
/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----

ШАБЛОН CHILD-ТАБЛИЦЫ : template-details-table

----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
#template-details { border:2px #666 solid; border-radius:5px; background-color:#fff }
#template-details-table { margin-bottom:0; background-color:transparent }
#template-details-table > tbody { color:#333; font-family:'Play', sans-serif; font-weight:300; font-size:1.0em }
#template-details-table > tbody > tr > td { border-top:none; padding:3px 5px; }
#template-details-table > tbody > tr > td:first-child { text-align:left }
#template-details-table > tbody > tr > td:nth-child(2) { text-align:left }
.template-details-table-title { text-transform:uppercase; font-weight:700 }
.template-details-table-txt { font-weight:300 }

#blankview-gip-pos-table .group { font-family:'Oswald', sans-serif; font-size:1.3em; font-weight:400; color:#000 }
#blankview-gip-pos-table > tbody > tr.dtrg-start.dtrg-level-0 > td { font-family:'Oswald', sans-serif; font-size:1.3em; font-weight:400; text-align:left; background-color:#d9d9d9; color:#111; padding:5px }
#blankview-gip-pos-table > tbody > tr.dtrg-end.dtrg-level-0 > td { font-family:'Oswald', sans-serif; font-size:1.4em; font-weight:500; color:#000; background-color:#f1f1f1 }
#blankview-gip-pos-table > tbody > tr.dtrg-end.dtrg-level-0 > td { font-family:'Oswald', sans-serif; font-size:1.4em; font-weight:500; color:#000; background-color:#f1f1f1 }
.itogo-lvl0 {  }
.itogo-lvl0-title { text-transform:uppercase; text-align:left }
.itogo-lvl0-text { float:right }

</style>
<?php
// ----- ----- ----- ----- -----
// Форма редактирования этапа
// :::
?>
<div id="customForm_newblank_pos">

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div id="main-tabs">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12">
							<ul id="main-tabs-menu" class="nav nav-tabs">
								<li class="active"><a data-toggle="tab" href="#tab-1" title="">Договор</a></li>
								<li><a data-toggle="tab" href="#tab-2" title="">Календарный план</a></li>
							</ul>
							<div class="tab-content">
								<div id="tab-1" class="tab-pane fade in active">
									<?php echo ("TAB 1"); ?>
								</div>
								<div id="tab-2" class="tab-pane fade">
									<?php echo ("TAB 2"); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="Section">
					<div class="Block20">
						<legend>Обоснование и план</legend>
						<fieldset class="field100">
							<editor-field name="dognet_docbase.kodshab"></editor-field>
						</fieldset>
						<fieldset class="field100">
							<editor-field name="dognet_docbase.usedoczayv"></editor-field>
						</fieldset>
						<fieldset class="field100">
							<editor-field name="dognet_docbase.usedocruk"></editor-field>
						</fieldset>
					</div>
					<div class="Block80">
						<legend>Наименование и сроки</legend>
						<fieldset class="field10">
							<editor-field name="dognet_docbase.docnumber"></editor-field>
						</fieldset>
						<fieldset class="field15">
							<editor-field name="docDateBegin"></editor-field>
						</fieldset>
						<fieldset class="field15">
							<editor-field name="docDateEnd"></editor-field>
						</fieldset>
						<fieldset class="field60">
							<editor-field name="dognet_docbase.docnameshot"></editor-field>
						</fieldset>
						<fieldset class="field100">
							<editor-field name="dognet_docbase.docnamefullm"></editor-field>
						</fieldset>
					</div>
					<div class="Block70">
						<legend>Свойства договора</legend>

						<fieldset class="field40">
							<editor-field name="dognet_docbase.kodobject"></editor-field>
						</fieldset>
						<fieldset class="field30 kodobjectFilter" style="padding-top:30px; padding-right:15px">
							<input id="kodobject_filter" type="text" placeholder="Поиск в Объектах"/>
						</fieldset>
						<fieldset class="field30">
							<editor-field name="dognet_docbase.kodtip"></editor-field>
						</fieldset>

						<fieldset class="field40">
							<editor-field name="dognet_docbase.kodzakaz"></editor-field>
						</fieldset>
						<fieldset class="field30 kodzakazFilter" style="padding-top:30px; padding-right:15px">
							<input id="kodzakaz_filter" type="text" placeholder="Поиск в Заказчиках"/>
						</fieldset>
						<fieldset class="field30">
							<editor-field name="dognet_docbase.kodstatus"></editor-field>
						</fieldset>
					</div>
					<div class="Block30">
						<legend>Исполнители</legend>
						<fieldset class="field100">
							<editor-field name="dognet_docbase.kodispol"></editor-field>
						</fieldset>
						<fieldset class="field100">
							<editor-field name="dognet_docbase.kodispolruk"></editor-field>
						</fieldset>
					</div>
					<div class="Block40">
						<legend>Командировки</legend>
						<fieldset class="field60">
							<editor-field name="dognet_docbase.usemisopl"></editor-field>
						</fieldset>
						<fieldset class="field40">
							<editor-field name="dognet_docbase.docsummamis"></editor-field>
						</fieldset>
					</div>
					<div class="Block40">
						<legend>Финансы</legend>
						<fieldset class="field40">
							<editor-field name="dognet_docbase.koddened"></editor-field>
						</fieldset>
						<fieldset class="field40">
							<editor-field name="dognet_docbase.docsumma"></editor-field>
						</fieldset>
						<fieldset class="field20">
							<editor-field name="dognet_docbase.usendssumma"></editor-field>
						</fieldset>
					</div>
					<div class="Block20">
						<legend>Задолженность</legend>
						<fieldset class="field100">
							<editor-field name="dognet_docbase.kodstatuszdl"></editor-field>
						</fieldset>
					</div>
			</div>

</div>
<?php
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
?>
<section>
  <div id="blanksearch-filters-block" class="panel-group">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" href="#blanksearch-filters">Фильтры для поиска бланка</a>
        </h4>
      </div>
      <div id="blanksearch-filters" class="panel-collapse collapse">

				<div id="blankview-gip-filters" class="panel-body space30">
					<div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
						<div class="form-group space10" style="width:100%">
							<label for="blankNumberSearch_text"><b>Номер бланка :</b></label>
							<input type="text" id="blankNumberSearch_text" class="form-control" placeholder="Все номера" name="blankNumberSearch_text">
						</div>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
						<div class="form-group space10" style="width:100%">
							<label for="docNumberSearch_text"><b>Номер договора :</b></label>
							<input type="text" id="docNumberSearch_text" class="form-control" placeholder="Все номера" name="docNumberSearch_text">
						</div>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
						<div class="form-group space10" style="width:100%">
							<label for="blankYearSearch_text"><b>Год :</b></label>
							<input type="text" id="blankYearSearch_text" class="form-control" placeholder="XXXX" name="blankYearSearch_text">
						</div>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
						<div class="form-group space10" style="width:100%">
							<label for="blankStatusSearch_text"><b>Статус бланка :</b></label>
							<select name="blankStatusSearch_text" id="blankStatusSearch_text" class="form-control">
								<option value="">Все статусы бланков</option>
								<?php
									$_QRY1 = mysqlQuery( "SELECT status_kod, status_description FROM dognet_sysdefs_blankstatus WHERE status = 1" );
									while($_ROW1 = mysqli_fetch_assoc($_QRY1)){
									?>
											<option value = '<?php echo $_ROW1["status_kod"]; ?>'><?php echo $_ROW1["status_description"]; ?></option>
								<?php
									}
									?>
							</select>
						</div>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
						<div class="form-group space10" style="width:100%">
							<label for="blankTypeSearch_text"><b>Тип бланка :</b></label>
							<select name="blankTypeSearch_text" id="blankTypeSearch_text" class="form-control">
								<option value="">Все типы бланков</option>
								<?php
									$_QRY2 = mysqlQuery( " SELECT type_kod, type_description FROM dognet_sysdefs_blanktype WHERE status = 1" );
									while($_ROW2 = mysqli_fetch_assoc($_QRY2)){
									?>
											<option value = '<?php echo $_ROW2["type_kod"]; ?>'><?php echo $_ROW2["type_description"]; ?></option>
								<?php
									}
									?>
							</select>
						</div>
					</div>
<?php // ----- ----- ----- ----- ----- ?>
					<div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
						<div class="input-group space10" style="width:100%">
							<label for="blankObjectSearch_text"><b>Заказчик/объект :</b></label>
							<input type="text" id="blankObjectSearch_text" class="form-control" placeholder="Все объекты" name="blankObjectSearch_text">
						</div>
					</div>
<?php // ----- ----- ----- ----- ----- ?>
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
						<div class="input-group space10" style="width:100%">
							<label for="blankIspolSearch_text"><b>ГИП (исполнитель) :</b></label>
							<select name="blankIspolSearch_text" id="blankIspolSearch_text" class="form-control">
								<option value="">Все исполнители</option>
								<?php
									$_QRY3 = mysqlQuery( "SELECT ispolnamefull, ispolnameshot FROM dognet_spispol WHERE ispolnamefull<>'' AND koddel<>99 AND kodusegip = 1 ORDER BY ispolnameshot ASC" );
									while($_ROW3 = mysqli_fetch_assoc($_QRY3)){
									?>
											<option value = '<?php echo $_ROW3["ispolnameshot"]; ?>'><?php echo $_ROW3["ispolnameshot"]; ?></option>
								<?php
									}
									?>
							</select>
						</div>
					</div>
<?php // ----- ----- ----- ----- ----- ?>
					<div class="col-xs-12 col-sm-4 col-md-6 col-lg-6">
						<div class="input-group space10" style="width:100%">
							<label for="blankNameSearch_text"><b>Текст из названия договора :</b></label>
							<input type="text" id="blankNameSearch_text" class="form-control" placeholder="Введите текст для поиска в названии" name="blankNameSearch_text">
						</div>
					</div>
<?php // ----- ----- ----- ----- ----- ?>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
						<div class="input-group-btn">
							<button id="columnSearch_btnApply" class="btn btn-default" type="button">Применить фильтры</button>
							<button id="columnSearch_btnClear" class="btn btn-default" type="button"><i class="glyphicon glyphicon-remove"></i></button>
						</div>
					</div>
<?php // ----- ----- ----- ----- ----- ?>
				</div>

      </div>
    </div>
  </div>
<?php
//
// ----- ----- -----
//
?>
	<div class="space30"></div>
	<div class="demo-html"></div>
	<table id="blankview-gip-pos-table" class="table table-striped" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
					<th width="" class="">№</th>
					<th width="" class="">Год</th>
					<th width="" class="">Описание</th>
					<th width="" class="">Организация</th>
					<th width="" class="">Тип</th>
					<th width="" class="">Договор</th>
					<th width="" class="">Создан</th>
					<th width="" class=""></th>
					<th width="" class="">Передан</th>
					<th width="" class="">Действие</th>
					<th width="" class=""></th>
				</tr>
			</thead>
		</table>
<?php
//
// ----- ----- -----
//
?>
	<div class="space10"></div>
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		<div id="blankview-docfiles">
			<h3 class="space10">Бланки требований</h3>
			<div class="demo-html"></div>
			<table id="blankview-docfiles-table" class="table table-striped" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th width="" class=""></th>
						<th width="" class=""></th>
						<th width="" class=""></th>
						<th width="" class=""></th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
<?php // ----- ----- ----- ?>
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		<div id="blankview-blankpril">
			<h3 class="space10">Вложения</h3>
			<div class="demo-html"></div>
			<table id="blankview-blankpril-table" class="table table-striped" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th width="" class=""></th>
						<th width="" class=""></th>
						<th width="" class=""></th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</section>
