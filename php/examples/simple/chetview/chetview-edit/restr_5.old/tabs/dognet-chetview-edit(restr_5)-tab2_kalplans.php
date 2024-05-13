
<script type="text/javascript" language="javascript" class="init">

var editor_tab2_kalplans;		// use a global for the submit and return data rendering in the examples
var table_tab2_kalplans;		// use a global for the submit and return data rendering in the examples

function converttime(onetime, day, month, year) {
	var D = new Date(onetime);
	D.setDate(D.getDate()+day);
	D.setMonth(D.getMonth()+month);
	D.setFullYear(D.getFullYear()+year);
	if(D.getDate() < 10) var curr_date = "0" + D.getDate(); else var curr_date = D.getDate();
	if(D.getMonth() < 10) { var curr_month = D.getMonth()+1; curr_month = "0" + curr_month;} else var curr_month = D.getMonth()+1; //Всегда +1 для месяца - т.к. счет с о по 11
	var curr_year = D.getFullYear();
	var newData = curr_year + "-" + curr_month + "-" + curr_date; //формат даты на выходе (можно менять как угодно)
	return newData;
}

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

$(document).ready(function() {
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	editor_tab2_kalplans = new $.fn.dataTable.Editor( {
		display: "bootstrap",
		ajax: "php/examples/php/chetview/chetview-edit/dognet-chetview-edit-tab2_kalplans-process.php",
		table: "#chetview-edit-tab2_kalplans",
    i18n: {
        edit: { title: "<h3>Редактирование этапа</h3>" },
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
		template: '#customForm_tab2_kalplans',
		fields: [
			{
				label: "Этап :",
				name: "dognet_dockalplan.numberstage"
			}, {
				label: "Краткое наименование :",
				name: "dognet_dockalplan.nameshotstage"
			}, {
				label: "Полное наименование :",
				name: "dognet_dockalplan.namefullstage",
				type: "textarea"
			}, {
				label: "Объект :",
				name: "dognet_dockalplan.kodobject",
				type: "select",
				def: "---",
				placeholder: "Выберите объект"
			}, {
				label: "Сумма :",
				name: "dognet_dockalplan.summastage"
			}, {
				label: "Текущий срок :",
				name: "dognet_dockalplan.srokstage",
				placeholder: "Дата или дни"
			}, {
		    label: "Контроль выполнения",
		    type:  "radio",
		    name:  "dognet_dockalplan.idsrokstage",
		    options: [
		        { label: "По сроку (в днях)", value: 0 },
		        { label: "По дате", value: 1 }
		    ]
			}, {
				type: "hidden",
				name: "dognet_dockalplan.srokstage_tmp"
			}, {
				label: "Текущий срок :",
				name: "dognet_dockalplan.srokopl",
				placeholder: "ПКЗ или дни"
			}, {
		    label: "Контроль оплаты",
		    type:  "radio",
		    name:  "dognet_dockalplan.idsrokopl",
		    options: [
		        { label: "ПКЗ", value: 0 },
		        { label: "По сроку", value: 1 }
		    ]
			}, {
		    label: "Новый срок :",
				name: "dognet_dockalplan.srokopl_tmp"
			}, {
// ----- ----- ----- ----- -----
				label: "&nbsp;",
		    type:  "checkbox",
		    name:  "dognet_dockalplan.useav1plan",
				options: [ { label: "", value: 1 } ],
				separator: "",
				unselectedValue: 0
			}, {
				label: "%",
				name: "dognet_dockalplan.pravplan1stage"
			}, {
				label: "Дата",
				name: "dognet_dockalplan.dateplanav1stage",
				type: "datetime",
				format: "DD.MM.YYYY"
// 				attr: { readonly: "readonly"}
			}, {
// ----- -----
		    type:  "checkbox",
		    name:  "dognet_dockalplan.useav2plan",
				options: [ { label: "", value: 1 } ],
				separator: "",
				unselectedValue: 0
			}, {
				name: "dognet_dockalplan.pravplan2stage"
			}, {
				name: "dognet_dockalplan.dateplanav2stage",
				type: "datetime",
				format: "DD.MM.YYYY"
// 				attr: { readonly: "readonly"}
			}, {
// ----- -----
				label: "&nbsp;",
		    type:  "checkbox",
		    name:  "dognet_dockalplan.useav3plan",
				options: [ { label: "", value: 1 } ],
				separator: "",
				unselectedValue: 0
			}, {
				label: "%",
				name: "dognet_dockalplan.pravplan3stage"
			}, {
				label: "Дата",
				name: "dognet_dockalplan.dateplanav3stage",
				type: "datetime",
				format: "DD.MM.YYYY"
// 				attr: { readonly: "readonly"}
			}, {
// ----- -----
		    type:  "checkbox",
		    name:  "dognet_dockalplan.useav4plan",
				options: [ { label: "", value: 1 } ],
				separator: "",
				unselectedValue: 0
			}, {
				name: "dognet_dockalplan.pravplan4stage"
			}, {
				name: "dognet_dockalplan.dateplanav4stage",
				type: "datetime",
				format: "DD.MM.YYYY"
// 				attr: { readonly: "readonly"}
// ----- ----- ----- ----- -----
			}, {
				label: "Субподряд :",
		    type:  "checkbox",
		    name:  "dognet_dockalplan.usedocsubpodr",
				options: [ { label: "", value: 1 } ],
				separator: "",
				unselectedValue: 0
			}, {
				label: "Дней до платежа :",
		    name:  "dognet_dockalplan.numberdayoplstage"
			}, {
				label: "Дата окончания :",
				name: "dognet_dockalplan.dateplan",
				type: "datetime",
				format: "DD.MM.YYYY",
				attr: { readonly: "readonly"}
			}, {
				label: "Дата окон. платежа :",
				name: "dognet_dockalplan.dateoplall",
				type: "datetime",
				format: "DD.MM.YYYY",
				attr: { readonly: "readonly"}
			}
		]
	} );
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Изменяем размер диалогового окна редактирования договора субподряда
	editor_tab2_kalplans.on( 'open', function () { $(".modal-dialog").css({
		"width":"80%",
		"min-width":"800px",
		"max-width":"1170px"
		});
	} );
	editor_tab2_kalplans.on( 'close', function () { $(".modal-dialog").css({
		"width":"60%",
		"min-width":"none",
		"max-width":"none"
		});
	} );
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
  editor_tab2_kalplans
      .on( 'open', function () {
				editor_tab2_kalplans.field('dognet_dockalplan.srokstage_tmp').set(editor_tab2_kalplans.field('dognet_dockalplan.srokstage').get());
				editor_tab2_kalplans.field('dognet_dockalplan.srokopl_tmp').set(editor_tab2_kalplans.field('dognet_dockalplan.srokopl').get());
			})

// ----- -- ----- -- -----
    editor_tab2_kalplans.dependent( 'dognet_dockalplan.idsrokstage', function ( val ) {
			if ( val == 1 ) {
				editor_tab2_kalplans.field('dognet_dockalplan.idsrokstage').processing(false);
			editor_tab2_kalplans.field('dognet_dockalplan.srokstage').set(editor_tab2_kalplans.field('dognet_dockalplan.srokstage_tmp').get());
					editor_tab2_kalplans.field('dognet_dockalplan.srokstage').fieldInfo("Дата в формате ДД/ММ/ГГГГ");
			}
			else {
				editor_tab2_kalplans.field('dognet_dockalplan.idsrokstage').processing(false);
			editor_tab2_kalplans.field('dognet_dockalplan.srokstage').set(editor_tab2_kalplans.field('dognet_dockalplan.srokstage_tmp').get());
					editor_tab2_kalplans.field('dognet_dockalplan.srokstage').fieldInfo("Просто количество дней");
			}
    } );
// ----- -- ----- -- -----
    editor_tab2_kalplans.dependent( 'dognet_dockalplan.idsrokopl', function ( val ) {
			if ( val == 0 ) {
				editor_tab2_kalplans.field('dognet_dockalplan.idsrokopl').processing(false);
				editor_tab2_kalplans.field('dognet_dockalplan.srokopl').set('ПКЗ');
			}
			else {
				editor_tab2_kalplans.field('dognet_dockalplan.idsrokopl').processing(false);
				editor_tab2_kalplans.field('dognet_dockalplan.srokopl').set(editor_tab2_kalplans.field('dognet_dockalplan.srokopl_tmp').get());
			}
    } );
// ----- -- ----- -- -----
    editor_tab2_kalplans.dependent( 'dognet_dockalplan.numberdayoplstage', function ( val ) {
			editor_tab2_kalplans.field('dognet_dockalplan.numberdayoplstage').processing(false);

			if ( val !== '' ) {
				var dateplan = editor_tab2_kalplans.field('dognet_dockalplan.dateplan').val();
				var date = moment(dateplan, 'DD.MM.YYYY');
				var newdate = moment(date.format('YYYY-MM-DD'));

				var diff_days = editor_tab2_kalplans.field('dognet_dockalplan.numberdayoplstage').val();
				var out = newdate.add(diff_days, 'days').format('DD.MM.YYYY');

				editor_tab2_kalplans.field('dognet_dockalplan.dateoplall').set(out);

			// Получаем текущую дату
				console.log( date+" : "+diff_days+" : "+out );
			}

    }, { event: 'keyup' } );
// ----- -- ----- -- -----
    editor_tab2_kalplans.dependent( 'dognet_dockalplan.dateoplall', function ( val ) {
			editor_tab2_kalplans.field('dognet_dockalplan.dateoplall').processing(false);

			if ( val !== '' ) {
				var dateplan = editor_tab2_kalplans.field('dognet_dockalplan.dateplan').val();
				var date1 = moment(dateplan, 'DD.MM.YYYY');
				var newdate1 = moment(date1.format('YYYY-MM-DD'));

				var date2 = moment(val, 'DD.MM.YYYY');
				var newdate2 = moment(date2.format('YYYY-MM-DD'));

				var out = newdate2.diff(newdate1, 'days');

				editor_tab2_kalplans.field('dognet_dockalplan.numberdayoplstage').set(out);

			// Получаем текущую дату
				console.log( newdate1+" : "+newdate2+" : "+out );
			}

    }, { event: 'change' } );
// ----- -- ----- -- -----
//
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	table_tab2_kalplans = $('#chetview-edit-tab2_kalplans').DataTable( {
		dom: "<'row space20'<'col-md-8 col-sm-12'B><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'>>",
// 		dom: "t",
			language: {
				url: "php/examples/simple/chetview/chetview-edit/dt_russian-tab2_kalplan.json"
			},
		ajax: {
			url: "php/examples/php/chetview/chetview-edit/dognet-chetview-edit-tab2_kalplans-process.php",
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
			{ data: "dognet_dockalplan.numberstage", className: "text-center" },
			{ data: "dognet_dockalplan.nameshotstage" },
			{ data: "dognet_dockalplan.srokstage", className: "text-center" },
			{ data: "dognet_dockalplan.srokopl", className: "text-center" },
			{ data: "dognet_dockalplan.summastage" }
		],
		select: {
			style: 'os',
			selector: 'td:first-child'
		},
		columnDefs: [
			{ orderable: false, searchable: false, targets: 0 },
			{ orderable: false, searchable: false, targets: 1 },
			{ orderable: false, searchable: false, targets: 2 },
			{ orderable: false, searchable: false, targets: 3 },
			{ orderable: false, searchable: false, targets: 4 },
			{ orderable: false, searchable: false, render: function ( data, type, row, meta ) {
				if (data != null) {
					return $.fn.dataTable.render.number(' ', ',', 2, '').display( data )+row.dognet_spdened.short_code;
				}
				else {
					return "0.00"+row.dognet_spdened.short_code;
				}
				}, targets: 5
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
//				$('#column3_search').val('');
//				$('#column4_search').val('');
//				$('#column5_search').val('');
//				$('#column6_search').val('');
//				$('#column7_search').val('');
//				$('#column8_search').val('');
//				$('#column9_search').val('');
					table_tab2_kalplans.columns().search('').draw();
				}
			},
			{ extend: "create", editor: editor_tab2_kalplans, text: "НОВЫЙ ЭТАП",
				formButtons:
					[ 'Создать',
						{ text: 'Отмена', action: function () { this.close(); } }
					]
			},
			{ extend: "edit", editor: editor_tab2_kalplans, text: "ИЗМЕНИТЬ",
				formButtons:
					[ 'Изменить',
						{ text: 'Отмена', action: function () { this.close(); } }
					]
			},
			{ extend: "remove", editor: editor_tab2_kalplans, text: "УДАЛИТЬ" }
		],
		initComplete: function() {

		},
    drawCallback: function () {

    }
	} );
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
//
// ----- -- ----- -- -----
// Array to track the ids of the edit displayed rows
    var detailRows = [];

    $('#chetview-edit-tab2_kalplans tbody').on( 'click', 'tr td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table_tab2_kalplans.row( tr );
        var idx = $.inArray( tr.attr('id'), detailRows );

        if ( row.child.isShown() ) {
            tr.removeClass( 'edit' );
            row.child.hide();

            // Remove from the 'open' array
            detailRows.splice( idx, 1 );
        }
        else {
            tr.addClass( 'edit' );
			rowData = table_tab2_kalplans.row( row );
			d = row.data();
			rowData.child( <?php include('templates/chetview-edit_tab2_kalplans.tpl'); ?> ).show();

// Add to the 'open' array
            if ( idx === -1 ) {
                detailRows.push( tr.attr('id') );
            }
        }
    } );
// On each draw, loop over the `detailRows` array and show any child rows
	table_tab2_kalplans.on( 'draw', function () {
		$.each( detailRows, function ( i, id ) {
		$('#'+id+' td.details-control').trigger( 'click' );
	    } );
	} );

} );

</script>
<?php
// ----- ----- ----- ----- -----
// Форма редактирования этапа
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/chetview/chetview-edit/restr_5/tabs/css/chetview-edit-tab2_kalplans.css">
<div id="customForm_tab2_kalplans">
			<div class="Section">
					<div class="Block100">
						<legend>Общая информация</legend>
						<fieldset class="field10">
							<editor-field name="dognet_dockalplan.numberstage"></editor-field>
						</fieldset>
						<fieldset class="field40">
							<editor-field name="dognet_dockalplan.nameshotstage"></editor-field>
						</fieldset>
						<fieldset class="field15">
							<editor-field name="dognet_dockalplan.summastage"></editor-field>
						</fieldset>
						<fieldset class="field35">
							<editor-field name="dognet_dockalplan.kodobject"></editor-field>
						</fieldset>
					</div>
					<div class="Block100">
						<fieldset class="field100">
							<editor-field name="dognet_dockalplan.namefullstage"></editor-field>
						</fieldset>
					</div>
					<div class="Block50">
						<legend>Сроки выполнения</legend>
						<fieldset class="field50">
							<editor-field name="dognet_dockalplan.idsrokstage"></editor-field>
						</fieldset>
						<fieldset class="field50">
							<editor-field name="dognet_dockalplan.srokstage"></editor-field>
						</fieldset>
					</div>
					<div class="Block50">
						<legend>Сроки оплаты</legend>
						<fieldset class="field50">
							<editor-field name="dognet_dockalplan.idsrokopl"></editor-field>
						</fieldset>
						<fieldset class="field50">
							<editor-field name="dognet_dockalplan.srokopl"></editor-field>
						</fieldset>
					</div>
					<div class="Block100">
						<div class="Block60">
							<legend>Распределение авансов (только для информации)</legend>
							<div class="Block50">
								<fieldset class="useavplan">
									<editor-field name="dognet_dockalplan.useav1plan"></editor-field>
								</fieldset>
								<fieldset class="pravplanstage">
									<editor-field name="dognet_dockalplan.pravplan1stage"></editor-field>
								</fieldset>
								<fieldset class="dateplanavstage">
									<editor-field name="dognet_dockalplan.dateplanav1stage"></editor-field>
								</fieldset>
								<fieldset class="useavplan">
									<editor-field name="dognet_dockalplan.useav2plan"></editor-field>
								</fieldset>
								<fieldset class="pravplanstage">
									<editor-field name="dognet_dockalplan.pravplan2stage"></editor-field>
								</fieldset>
								<fieldset class="dateplanavstage">
									<editor-field name="dognet_dockalplan.dateplanav2stage"></editor-field>
								</fieldset>
							</div>
							<div class="Block50">
								<fieldset class="useavplan">
									<editor-field name="dognet_dockalplan.useav3plan"></editor-field>
								</fieldset>
								<fieldset class="pravplanstage">
									<editor-field name="dognet_dockalplan.pravplan3stage"></editor-field>
								</fieldset>
								<fieldset class="dateplanavstage">
									<editor-field name="dognet_dockalplan.dateplanav3stage"></editor-field>
								</fieldset>
								<fieldset class="useavplan">
									<editor-field name="dognet_dockalplan.useav4plan"></editor-field>
								</fieldset>
								<fieldset class="pravplanstage">
									<editor-field name="dognet_dockalplan.pravplan4stage"></editor-field>
								</fieldset>
								<fieldset class="dateplanavstage">
									<editor-field name="dognet_dockalplan.dateplanav4stage"></editor-field>
								</fieldset>
							</div>
						</div>
						<div class="Block40">
							<legend>Планирование</legend>
							<div class="Block50">
								<fieldset class="field100">
									<editor-field name="dognet_dockalplan.dateplan"></editor-field>
								</fieldset>
								<fieldset class="field100">
									<editor-field name="dognet_dockalplan.numberdayoplstage"></editor-field>
								</fieldset>
							</div>
							<div class="Block50">
								<fieldset class="field100">
									<editor-field name="dognet_dockalplan.dateoplall"></editor-field>
								</fieldset>
							</div>
						</div>
					</div>
			</div>
</div>




<?php
// ----- ----- ----- ----- -----
// Таблица этапов
// :::
?>
<section>
	<div id="chetview-tab2_kalplans" class="" style="padding:0 5px">
		<div class="space30"></div>
		<div class="demo-html"></div>
		<table id="chetview-edit-tab2_kalplans" class="table table-bordered" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
					<th class="text-center text-uppercase">Этап</th>
					<th class="text-uppercase">Наименование</th>
					<th class="text-center text-uppercase">Срок (дата/дни)</th>
					<th class="text-center text-uppercase">Срок оплаты</th>
					<th class="text-uppercase">Сумма</th>
				</tr>
			</thead>
		</table>
	</div>
</section>

