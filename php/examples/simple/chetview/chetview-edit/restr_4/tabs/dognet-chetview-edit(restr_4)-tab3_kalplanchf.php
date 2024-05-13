<script type="text/javascript" language="javascript" class="init">
$(document).ready(function() {

    // СЧЕТА-ФАКТУРЫ : форма редактирования
    var editor_tab3_kalplanchf = new $.fn.dataTable.Editor({
        display: "bootstrap",
        ajax: "php/examples/php/chetview/chetview-edit/dognet-chetview-edit-tab3_kalplanchf-process.php",
        table: "#chetview-edit-tab3_kalplanchf",
        i18n: {
            create: {
                title: "<h3>Добавить новый счет-фактуру</h3>"
            },
            edit: {
                title: "<h3>Изменить счет-фактуру</h3>"
            },
            remove: {
                button: "Удалить",
                title: "<h3>Удалить счет-фактуру</h3>",
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
                next: 'След',
                months: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август',
                    'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'
                ],
                weekdays: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб']
            }
        },
        template: '#customForm_tab3_kalplanchf',
        fields: [{
            label: "Этап :",
            type: "select",
            name: "dognet_kalplanchf.kodkalplan",
            def: "---",
            placeholder: "Выберите этап"
        }, {
            label: "Дата :",
            name: "dognet_kalplanchf.chetfdate",
            type: "datetime",
            format: "DD.MM.YYYY",
            def: function() {
                return new Date();
            }
            // ----- ----- ----- ----- -----
        }, {
            label: "Сумма :",
            name: "dognet_kalplanchf.chetfsumma"
        }, {
            label: "Комментарий :",
            name: "dognet_kalplanchf.comment"
        }, {
            label: "№ счета :",
            name: "dognet_kalplanchf.chetfnumber"
        }]
    });
    //
    // Изменяем размер диалогового окна редактирования договора субподряда
    editor_tab3_kalplanchf.on('open', function() {
        $(".modal-dialog").css({
            "width": "60%",
            "min-width": "800px",
            "max-width": "1170px"
        });
    });
    editor_tab3_kalplanchf.on('close', function() {
        $(".modal-dialog").css({
            "width": "60%",
            "min-width": "none",
            "max-width": "none"
        });
    });
    //
    // СЧЕТА-ФАКТУРЫ : таблица
    var table_tab3_kalplanchf = $('#chetview-edit-tab3_kalplanchf').DataTable({

        dom: "<'row'<'col-sm-5'B><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-4'i><'col-sm-8'p>>",
        language: {
            url: "php/examples/simple/chetview/chetview-edit/dt_russian-tab3_kalplanchf.json"
        },
        ajax: {
            url: "php/examples/php/chetview/chetview-edit/dognet-chetview-edit-tab3_kalplanchf-process.php",
            type: "POST"
        },
        stateSave: true,
        serverSide: true,
        processing: true,
        select: {
            style: 'single'
        },
        paging: true,
        pageLength: 5,
        lengthChange: false,
        columns: [{
                data: "dognet_docbase.kodshab",
                render: function(data, type, row) {
                    if (data === "1") {
                        if (type === 'display') {
                            return '';
                        }
                        return row.dognet_dockalplan.numberstage;
                    } else {
                        if (type === 'display') {
                            return '';
                        }
                        return row.dognet_docbase.docnumber;
                    }
                }
            },
            {
                data: "dognet_kalplanchf.kodchfact",
                className: ""
            },
            {
                data: "dognet_kalplanchf.chetfnumber",
                className: ""
            },
            {
                data: "dognet_kalplanchf.chetfdate",
                className: ""
            },
            {
                data: "dognet_kalplanchf.chetfsumma",
                className: ""
            },
            {
                data: "dognet_kalplanchf_zadol.chetfsumzadol",
                className: ""
            }
        ],
        columnDefs: [{
                orderable: true,
                searchable: false,
                visible: false,
                targets: 0
            },
            {
                orderable: false,
                searchable: false,
                targets: 1
            },
            {
                orderable: false,
                searchable: false,
                render: function(data) {
                    return data;
                },
                targets: 2
            },
            {
                orderable: false,
                searchable: false,
                type: "date",
                targets: 3
            },
            {
                orderable: false,
                searchable: false,
                render: function(data, type, row, meta) {
                    if (data != null) {
                        return $.fn.dataTable.render.number(' ', ',', 2, '').display(data) + row
                            .dognet_spdened.short_code;
                    } else {
                        return "0.00" + row.dognet_spdened.short_code;
                    }
                },
                targets: 4
            },
            {
                orderable: false,
                searchable: false,
                render: function(data, type, row, meta) {
                    if (data != null) {
                        return $.fn.dataTable.render.number(' ', ',', 2, '').display(data) + row
                            .dognet_spdened.short_code;
                    } else {
                        return "0.00" + row.dognet_spdened.short_code;
                    }
                },
                targets: 5
            }
        ],
        order: [
            [0, 'asc']
        ],
        rowGroup: {
            dataSrc: function(row) {
                if (row.dognet_docbase.kodshab === "1") {
                    return "Этап " + row.dognet_dockalplan.numberstage;
                } else {
                    return "Счет # " + row.dognet_docbase.numberchet + " (без календарного плана)";
                }
            },
            startRender: function(rows, group) {
                return group;
            },
            endRender: null,
            emptyDataGroup: 'No categories assigned yet'
        },
        buttons: [{
                text: '<span class="glyphicon glyphicon-refresh"></span>',
                action: function(e, dt, node, config) {
                    table_tab3_kalplanchf.columns().search('').draw();
                }
            },
            {
                extend: "create",
                editor: editor_tab3_kalplanchf,
                text: "НОВЫЙ СЧЕТ",
                formButtons: ['Создать',
                    {
                        text: 'Отмена',
                        action: function() {
                            this.close();
                        }
                    }
                ]
            },
            {
                extend: "edit",
                editor: editor_tab3_kalplanchf,
                text: "ИЗМЕНИТЬ",
                formButtons: ['Изменить',
                    {
                        text: 'Отмена',
                        action: function() {
                            this.close();
                        }
                    }
                ]
            },
            {
                extend: "remove",
                editor: editor_tab3_kalplanchf,
                text: "УДАЛИТЬ",
                formButtons: ['Удалить',
                    {
                        text: 'Отмена',
                        action: function() {
                            this.close();
                        }
                    }
                ]
            }
        ]
    });
    //
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    //
    // ОПЛАТА СЧЕТОВ-ФАКТУР : форма редактирования
    var editor_tab3_oplatachf = new $.fn.dataTable.Editor({
        display: "bootstrap",
        ajax: {
            url: 'php/examples/php/chetview/chetview-edit/dognet-chetview-edit-tab3_oplatachf_child-process.php',
            data: function(d) {
                var selected = table_tab3_kalplanchf.row({
                    selected: true
                });
                if (selected.any()) {
                    d.kodchfact = selected.data().dognet_kalplanchf.kodchfact;
                    d.kodkalplan = selected.data().dognet_kalplanchf.kodkalplan;
                }
            }
        },
        table: '#chetview-edit-tab3_oplata',
        i18n: {
            create: {
                title: "<h3>Добавить новую оплату по счету-фактуре</h3>"
            },
            edit: {
                title: "<h3>Изменить оплату</h3>"
            },
            remove: {
                button: "Удалить",
                title: "<h3>Удалить оплату</h3>",
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
                next: 'След',
                months: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август',
                    'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'
                ],
                weekdays: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб']
            }
        },
        template: '#customForm_tab3_oplata',
        fields: [{
            label: "Сумма платежа:",
            name: "dognet_oplatachf.summaopl"
        }, {
            label: "Дата платежа:",
            name: "dognet_oplatachf.dateopl",
            type: "datetime",
            format: "DD.MM.YYYY",
            def: function() {
                return new Date();
            },
            attr: {
                readonly: "readonly"
            }
        }, {
            label: "Счет-фактура:",
            name: "dognet_oplatachf.kodchfact",
            type: "select",
            placeholder: "Выберите счет-фактуру"
        }, {
            label: "Комментарий:",
            name: "dognet_oplatachf.comment"
        }]
    });
    //
    // Изменяем размер диалогового окна редактирования договора субподряда
    editor_tab3_oplatachf.on('open', function() {
        $(".modal-dialog").css({
            "width": "65%",
            "min-width": "800px",
            "max-width": "1170px"
        });
    });
    editor_tab3_oplatachf.on('close', function() {
        $(".modal-dialog").css({
            "width": "60%",
            "min-width": "none",
            "max-width": "none"
        });
    });
    //
    // ОПЛАТА СЧЕТОВ-ФАКТУР : таблица
    var table_tab3_oplatachf = $('#chetview-edit-tab3_oplata').DataTable({
        dom: "<'row'<'col-md-8 col-sm-12'B><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'>>",
        // 		dom: "Bfrtip",
        language: {
            url: "php/examples/simple/chetview/chetview-edit/dt_russian-tab3_oplatachf.json"
        },
        ajax: {
            url: "php/examples/php/chetview/chetview-edit/dognet-chetview-edit-tab3_oplatachf_child-process.php",
            type: 'post',
            data: function(d) {
                var selected = table_tab3_kalplanchf.row({
                    selected: true
                });
                if (selected.any()) {
                    d.kodchfact = selected.data().dognet_kalplanchf.kodchfact;
                    d.kodkalplan = selected.data().dognet_kalplanchf.kodkalplan;
                    console.log("KalplanChf (" + selected.id() + ") :: kodchfact: " + d.kodchfact +
                        ", kodkalplan: " + d.kodkalplan);
                }
                var selected2 = table_tab3_oplatachf.row({
                    selected: true
                });
                if (selected2.any()) {
                    console.log("OplataChf (" + selected2.id() + ")");
                }
            }
        },
        serverSide: true,
        select: {
            style: 'single'
        },
        columns: [{
                data: "dognet_oplatachf.kodoplata",
                className: ""
            },
            {
                data: "dognet_oplatachf.dateopl",
                className: ""
            },
            {
                data: "dognet_oplatachf.summaopl",
                className: ""
            }
        ],
        columnDefs: [{
                orderable: false,
                searchable: false,
                targets: 0
            },
            {
                orderable: false,
                searchable: false,
                type: "date",
                targets: 1
            },
            {
                orderable: false,
                searchable: false,
                render: function(data, type, row, meta) {
                    if (data != null) {
                        return $.fn.dataTable.render.number(' ', ',', 2, '').display(data) + row
                            .dognet_spdened.short_code;
                    } else {
                        return "0.00" + row.dognet_spdened.short_code;
                    }
                },
                targets: 2
            }
        ],
        buttons: [{
                extend: "create",
                editor: editor_tab3_oplatachf,
                text: '<span class="glyphicon glyphicon-plus"></span>',
                formButtons: ['Создать',
                    {
                        text: 'Отмена',
                        action: function() {
                            this.close();
                        }
                    }
                ]
            },
            {
                extend: "edit",
                editor: editor_tab3_oplatachf,
                text: '<span class="glyphicon glyphicon-pencil"></span>',
                formButtons: ['Изменить',
                    {
                        text: 'Отмена',
                        action: function() {
                            this.close();
                        }
                    }
                ]
            },
            {
                extend: "remove",
                editor: editor_tab3_oplatachf,
                text: '<span class="glyphicon glyphicon-remove"></span>'
            }
        ]
    });
    //
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    //
    // АВАНСЫ ЗАЧТЕННЫЕ ПО СЧЕТАМ-ФАКТУРАМ : форма редактирования
    var editor_tab3_chfavans = new $.fn.dataTable.Editor({
        display: "bootstrap",
        ajax: {
            url: 'php/examples/php/chetview/chetview-edit/dognet-chetview-edit-tab3_chfavans_child-process.php',
            data: function(d) {
                var selected_chfavans = table_tab3_kalplanchf.row({
                    selected: true
                });
                if (selected_chfavans.any()) {
                    d.kodchfact_chfavans = selected_chfavans.data().dognet_kalplanchf.kodchfact;
                    d.kodkalplan_chfavans = selected_chfavans.data().dognet_kalplanchf.kodkalplan;
                }
            }
        },
        table: '#chetview-edit-tab3_avans',
        i18n: {
            create: {
                title: "<h3>Зачесть сумму из аванса</h3>"
            },
            edit: {
                title: "<h3>Изменить зачтенную сумму</h3>"
            },
            remove: {
                button: "Удалить",
                title: "<h3>Удалить зачтенную сумму</h3>",
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
                next: 'След',
                months: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август',
                    'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'
                ],
                weekdays: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб']
            }
        },
        template: '#customForm_tab3_avans',
        fields: [{
            label: "Зачесть из аванса:",
            name: "dognet_chfavans.summaoplav"
        }, {
            label: "Счет-фактура:",
            name: "dognet_chfavans.kodchfact",
            type: "select"
        }, {
            label: "Аванс:",
            name: "dognet_chfavans.kodavans",
            type: "select",
            placeholder: "Выберите аванс"
        }, {
            label: "Комментарий:",
            name: "dognet_chfavans.comment"
        }]
    });
    //
    // Изменяем размер диалогового окна редактирования договора субподряда
    editor_tab3_chfavans.on('open', function() {
        $(".modal-dialog").css({
            "width": "70%",
            "min-width": "800px",
            "max-width": "1170px"
        });
    });
    editor_tab3_chfavans.on('close', function() {
        $(".modal-dialog").css({
            "width": "60%",
            "min-width": "none",
            "max-width": "none"
        });
    });
    //
    // АВАНСЫ ЗАЧТЕННЫЕ ПО СЧЕТАМ-ФАКТУРАМ : таблица
    var table_tab3_chfavans = $('#chetview-edit-tab3_avans').DataTable({
        dom: "<'row'<'col-md-8 col-sm-12'B><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'>>",
        language: {
            url: "php/examples/simple/chetview/chetview-edit/dt_russian-tab3_chfavans.json"
        },
        ajax: {
            url: "php/examples/php/chetview/chetview-edit/dognet-chetview-edit-tab3_chfavans_child-process.php",
            type: 'post',
            data: function(d) {
                var selected_chfavans = table_tab3_kalplanchf.row({
                    selected: true
                });
                if (selected_chfavans.any()) {
                    d.kodchfact_chfavans = selected_chfavans.data().dognet_kalplanchf.kodchfact;
                    d.kodkalplan_chfavans = selected_chfavans.data().dognet_kalplanchf.kodkalplan;
                }
            }
        },
        serverSide: true,
        select: {
            style: 'single'
        },
        columns: [{
                data: "dognet_chfavans.kodavans",
                className: ""
            },
            {
                data: "dognet_docavans.dateavans",
                className: ""
            },
            {
                data: "dognet_chfavans.summaoplav",
                className: ""
            }
        ],
        columnDefs: [{
                orderable: false,
                searchable: false,
                targets: 0
            },
            {
                orderable: false,
                searchable: false,
                type: "date",
                targets: 1
            },
            {
                orderable: false,
                searchable: false,
                render: function(data, type, row, meta) {
                    if (data != null) {
                        return $.fn.dataTable.render.number(' ', ',', 2, '').display(data) + row
                            .dognet_spdened.short_code;
                    } else {
                        return "0.00" + row.dognet_spdened.short_code;
                    }
                },
                targets: 2
            }
        ],
        buttons: [{
                extend: "create",
                editor: editor_tab3_chfavans,
                text: '<span class="glyphicon glyphicon-plus"></span>',
                formButtons: ['Создать',
                    {
                        text: 'Отмена',
                        action: function() {
                            this.close();
                        }
                    }
                ]
            },
            {
                extend: "edit",
                editor: editor_tab3_chfavans,
                text: '<span class="glyphicon glyphicon-pencil"></span>',
                formButtons: ['Изменить',
                    {
                        text: 'Отмена',
                        action: function() {
                            this.close();
                        }
                    }
                ]
            },
            {
                extend: "remove",
                editor: editor_tab3_chfavans,
                text: '<span class="glyphicon glyphicon-remove"></span>'
            }
        ]
    });
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    //
    //
    //
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    table_tab3_kalplanchf.on('select', function() {
        table_tab3_kalplanchf.buttons().enable();
        table_tab3_oplatachf.buttons().enable();
        table_tab3_oplatachf.ajax.reload();
        table_tab3_chfavans.buttons().enable();
        table_tab3_chfavans.ajax.reload();

        editor_tab3_oplatachf
            .field('dognet_oplatachf.kodchfact')
            .def(table_tab3_kalplanchf.row({
                selected: true
            }).data().dognet_kalplanchf.kodchfact);
        editor_tab3_chfavans
            .field('dognet_chfavans.kodchfact')
            .def(table_tab3_kalplanchf.row({
                selected: true
            }).data().dognet_kalplanchf.kodchfact);

    });
    table_tab3_kalplanchf.on('deselect', function() {
        table_tab3_oplatachf.buttons().disable();
        table_tab3_oplatachf.ajax.reload();
        table_tab3_chfavans.buttons().disable();
        table_tab3_chfavans.ajax.reload();
    });
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    editor_tab3_kalplanchf.on('submitSuccess', function() {
        table_tab3_oplatachf.ajax.reload();
        table_tab3_chfavans.ajax.reload();
    });
    //
    editor_tab3_oplatachf.on('submitSuccess', function() {
        table_tab3_kalplanchf.ajax.reload(null, false);
    });
    editor_tab3_oplatachf.on('initEdit initCreate', function() {
        editor_tab3_oplatachf.disable(['dognet_oplatachf.kodchfact']);
    });
    //
    editor_tab3_chfavans.on('submitSuccess', function() {
        table_tab3_kalplanchf.ajax.reload(null, false);
        table_tab4_avans.ajax.reload();
    });
    editor_tab3_chfavans.on('initEdit initCreate', function() {
        editor_tab3_chfavans.disable(['dognet_chfavans.kodchfact']);
    });
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    //
    //
    //
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    /*
        editor_tab3_chfavans.dependent( 'dognet_chfavans.kodavans', function ( val, data, callback ) {

        } );
    */
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    //
    //
    //
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    table_tab3_kalplanchf.on('init', function() {
        table_tab3_oplatachf.buttons().disable();
        table_tab3_chfavans.buttons().disable();
    });
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
});
</script>
<?php
// ----- ----- ----- ----- -----
// Форма редактирования этапа
// :::
?>
<link rel="stylesheet"
      href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/chetview/chetview-edit/restr_4/tabs/css/chetview-edit-tab3_kalplanchf.css">
<div id="customForm_tab3_kalplanchf">
    <div class="Section">
        <div class="Block100">
            <legend>Информация</legend>
        </div>
        <div class="Block100">
            <legend>Счет-фактура</legend>
            <fieldset class="field45">
                <editor-field name="dognet_kalplanchf.kodkalplan"></editor-field>
            </fieldset>
            <fieldset class="field15">
                <editor-field name="dognet_kalplanchf.chetfnumber"></editor-field>
            </fieldset>
            <fieldset class="field20">
                <editor-field name="dognet_kalplanchf.chetfdate"></editor-field>
            </fieldset>
            <fieldset class="field20">
                <editor-field name="dognet_kalplanchf.chetfsumma"></editor-field>
            </fieldset>
        </div>
        <div class="Block100">
            <fieldset class="field100">
                <editor-field name="dognet_kalplanchf.comment"></editor-field>
            </fieldset>
        </div>
    </div>
</div>
<?php
// ----- ----- ----- ----- -----
// Форма редактирования оплаты счета-фактуры
// :::
?>
<link rel="stylesheet"
      href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/chetview/chetview-edit/restr_4/tabs/css/chetview-edit-tab3_kalplanchf_oplata.css">
<div id="customForm_tab3_oplata">
    <div class="Section">
        <div class="Block100">
            <legend>Подсказки и помощь</legend>
        </div>
        <div class="Block100">
            <legend>Оплата счета</legend>
            <fieldset class="field40">
                <editor-field name="dognet_oplatachf.kodchfact"></editor-field>
            </fieldset>
            <fieldset class="field30">
                <editor-field name="dognet_oplatachf.dateopl"></editor-field>
            </fieldset>
            <fieldset class="field30">
                <editor-field name="dognet_oplatachf.summaopl"></editor-field>
            </fieldset>
        </div>
        <div class="Block100">
            <fieldset class="field100">
                <editor-field name="dognet_oplatachf.comment"></editor-field>
            </fieldset>
        </div>
    </div>
</div>
<?php
// ----- ----- ----- ----- -----
// Форма редактирования оплаты счета-фактуры
// :::
?>
<link rel="stylesheet"
      href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/chetview/chetview-edit/restr_4/tabs/css/chetview-edit-tab3_kalplanchf_avans.css">
<div id="customForm_tab3_avans">
    <div class="Section">
        <div class="Block100">
            <legend>Информация</legend>
        </div>
        <div class="Block30">
            <legend>Счет-фактура</legend>
            <fieldset class="field100">
                <editor-field name="dognet_chfavans.kodchfact"></editor-field>
            </fieldset>
        </div>
        <div class="Block70">
            <legend>Зачет части аванса</legend>
            <fieldset class="field70">
                <editor-field name="dognet_chfavans.kodavans"></editor-field>
            </fieldset>
            <fieldset class="field30">
                <editor-field name="dognet_chfavans.summaoplav"></editor-field>
            </fieldset>
        </div>
        <div class="Block100">
            <fieldset class="field100">
                <editor-field name="dognet_chfavans.comment"></editor-field>
            </fieldset>
        </div>
    </div>
</div>
<?php
// ----- ----- ----- ----- -----
// Таблица этапов
// :::
?>
<section>

    <div class="" style="padding-left:5px; padding-right:5px">
        <div class="space30"></div>
        <div class="demo-html"></div>
        <table id="chetview-edit-tab3_kalplanchf" class="table table-bordered table-striped" cellspacing="0"
               width="100%">
            <thead>
                <tr>
                    <th></th>
                    <th>ID счета</th>
                    <th>№</th>
                    <th>Дата</th>
                    <th>Сумма</th>
                    <th>Задолженность</th>
                </tr>
            </thead>
        </table>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="space30"></div>
            <h3 class="child-title space20">Оплаты по счету</h3>
            <div class="demo-html"></div>
            <table id="chetview-edit-tab3_oplata" class="table table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>ID оплаты</th>
                        <th>Дата</th>
                        <th>Сумма</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="space30"></div>
            <h3 class="child-title space20">Зачтенные авансы / части авансов</h3>
            <div class="demo-html"></div>
            <table id="chetview-edit-tab3_avans" class="display table table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>ID аванса</th>
                        <th>Дата</th>
                        <th>Зачтено</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

</section>