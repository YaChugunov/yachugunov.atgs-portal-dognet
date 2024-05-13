<script type="text/javascript" language="javascript" class="init">
    $(document).ready(function() {
        //
        // ##### ##### ##### ##### ##### ##### ##### ##### ##### #####  
        // ##### ##### ##### ##### ##### ##### ##### ##### ##### #####  
        // ##### ##### ##### ##### ##### ##### ##### ##### ##### #####  
        // 
        // ##### ##### ##### ##### ##### ##### ##### ##### ##### #####  
        // 
        var reqField_calcChfAvOstatok = {
            calcChfAvOstatok: function(response) {}
        };

        function ajaxRequest_calcChfAvOstatok(kodavsubpodr, kodchfsubpodr, inputvalue, responseHandler) {
            // Fire off the request_addItem to /form.php
            request_calcChfAvOstatok = $.ajax({
                type: "post",
                url: '<?php echo __ROOT; ?>/dognet/php/examples/simple/docview/docview-edit/restr_4/tabs/process/ajaxrequests/ajaxReq-docveiwedit-subpodr-avans-calcOstatok.php',
                cache: false,
                data: {
                    kodavsubpodr: kodavsubpodr,
                    kodchfsubpodr: kodchfsubpodr,
                    inputvalue: inputvalue
                },
                success: reqField_calcChfAvOstatok[responseHandler]
            });
            // Callback handler that will be called on success
            request_calcChfAvOstatok.done(function(response, textStatus, jqXHR) {
                if (response != "-1") {
                    res = response.replace(new RegExp("\\r?\\n", "g"), "");
                    x = res.split('///');

                    window.res_sumav = x[0];
                    window.res_sumavsplit = x[1];
                    res_sumavchfsplit = x[2];
                    res_sumavsplit2 = x[3];
                    res_sumavchfsplit2 = x[4];
                    window.res_sumavost = x[0] - x[2];
                    res_sumavost2 = x[0] - x[4];

                    $('#calcAvans-valuesDB-sumav').html($.fn.dataTable.render.number(' ', ',', 2, '')
                        .display(x[0]));
                    $('#calcAvans-valuesDB-sumavsplit').html($.fn.dataTable.render.number(' ', ',', 2, '')
                        .display(x[1]));
                    $('#calcAvans-valuesDB-sumavchfsplit').html($.fn.dataTable.render.number(' ', ',', 2,
                        '').display(x[
                        2]));
                    $('#calcAvans-valuesDB-sumavost').html($.fn.dataTable.render.number(' ', ',', 2, '')
                        .display(x[0] - x[
                            2]));

                    // $('#calcAvans-valuesForm-sumavsplit').html($.fn.dataTable.render.number(' ', ',', 2, '').display(x[3]));
                    // $('#calcAvans-valuesForm-sumavchfsplit').html($.fn.dataTable.render.number(' ', ',', 2, '').display(x[
                    //   4]));
                    // $('#calcAvans-valuesForm-sumavost').html($.fn.dataTable.render.number(' ', ',', 2, '').display(x[0] - x[
                    //   4]));

                }
                console.log('request_calcChfAvOstatok', response)
            });
            // Callback handler that will be called on failure
            request_calcChfAvOstatok.fail(function(jqXHR, textStatus, errorThrown) {
                console.error(
                    "The following error occurred: " +
                    textStatus, errorThrown
                );
            });
            // Callback handler that will be called regardless
            // if the request_addItem failed or succeeded
            request_calcChfAvOstatok.always(function() {

            });
        }
        //
        // ##### ##### ##### ##### ##### ##### ##### ##### ##### #####  
        // ##### ##### ##### ##### ##### ##### ##### ##### ##### #####  
        // ##### ##### ##### ##### ##### ##### ##### ##### ##### #####  
        // 
        // ##### ##### ##### ##### ##### ##### ##### ##### ##### #####  
        // 
        var editor_tab5_subpodr = new $.fn.dataTable.Editor({
            display: "bootstrap",
            ajax: "php/examples/simple/docview/docview-edit/restr_4/tabs/process/dognet-docview-edit(restr_4)-tab5_subpodr-process.php",
            table: "#docview-edit-tab5_subpodr",
            i18n: {
                create: {
                    title: "<h3>Новый договор субподряда</h3>"
                },
                edit: {
                    title: "<h3>Изменить параметры договора</h3>"
                },
                remove: {
                    button: "Удалить",
                    title: "<h3>Удалить договор субподряда</h3>",
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
            template: '#customForm_tab5_subpodr',
            fields: [{
                label: "Этап",
                type: "select",
                name: "dognet_docsubpodr.koddoc",
                def: "---",
                placeholder: "Выберите этап"
            }, {
                label: "Дата",
                name: "dognet_docsubpodr.datedocsubpodr",
                type: "datetime",
                format: "DD.MM.YYYY"
            }, {
                label: "Организация субподрядчик",
                name: "dognet_docsubpodr.kodsubpodr",
                type: "select",
                def: "---",
                placeholder: "Выберите организацию"
            }, {
                label: "Название договора",
                type: "textarea",
                name: "dognet_docsubpodr.namedocsubpodr"
            }, {
                label: "Сумма договора",
                name: "dognet_docsubpodr.sumdocsubpodr"
            }, {
                label: "Номер договора",
                name: "dognet_docsubpodr.numberdocsubpodr"
            }]
        });
        var table_tab5_subpodr = $('#docview-edit-tab5_subpodr').DataTable({
            dom: "<'row'<'col-sm-5'B><'col-sm-4'><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-6'><'col-sm-6'p>>",
            /* 		dom: "<'row'<'col-md-8 col-sm-12'B><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'>>", */
            language: {
                url: "php/examples/simple/docview/docview-edit/dt_russian-tab5_subpodr.json"
            },
            ajax: {
                url: "php/examples/simple/docview/docview-edit/restr_4/tabs/process/dognet-docview-edit(restr_4)-tab5_subpodr-process.php",
                type: "POST",
                data: function(d) {}
            },
            serverSide: true,
            select: {
                style: 'single'
            },
            columns: [{
                    data: null,
                    class: "details-control",
                    searchable: false,
                    orderable: false,
                    defaultContent: "<span class='glyphicon glyphicon-option-vertical'></span>"
                },
                {
                    data: "dognet_docsubpodr.koddocsubpodr",
                    render: function(data, type, row) {
                        if (row.dognet_docbase.kodshab === "1" || row.dognet_docbase.kodshab ===
                            "3") {
                            return row.dognet_dockalplan.numberstage;
                        } else if (row.dognet_docbase.kodshab === "2" || row.dognet_docbase
                            .kodshab === "4") {
                            return row.dognet_docbase.docnumber;
                        }
                    }
                },
                {
                    data: "dognet_docsubpodr.koddocsubpodr",
                    className: ""
                },
                {
                    data: "dognet_docsubpodr.numberdocsubpodr",
                    className: ""
                },
                {
                    data: "dognet_docsubpodr.datedocsubpodr",
                    className: ""
                },
                {
                    data: "sp_contragents.nameshort",
                    className: ""
                },
                {
                    data: "dognet_docsubpodr.sumdocsubpodr",
                    className: ""
                },
                {
                    data: "dognet_docsubpodr.sumzadolsubpodr",
                    className: ""
                },
            ],
            columnDefs: [{
                    orderable: false,
                    searchable: false,
                    targets: 0
                },
                {
                    orderable: false,
                    searchable: false,
                    visible: false,
                    targets: 1
                },
                {
                    orderable: false,
                    searchable: false,
                    visible: true,
                    targets: 2
                },
                {
                    orderable: false,
                    searchable: false,
                    render: function(data) {
                        return data;
                    },
                    targets: 3
                },
                {
                    orderable: false,
                    searchable: false,
                    type: "date",
                    targets: 4
                },
                {
                    orderable: false,
                    searchable: false,
                    render: function(data) {
                        return data;
                    },
                    targets: 5
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
                    targets: 6
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
                    targets: 7
                }
            ],
            order: [
                [4, 'desc'],
                [1, 'desc']
            ],
            rowGroup: {
                dataSrc: function(row) {
                    if (row.dognet_docbase.kodshab === "1" || row.dognet_docbase.kodshab === "3") {
                        return "Этап " + row.dognet_dockalplan.numberstage + ' / ' + row.dognet_dockalplan.nameshotstage;
                    } else if (row.dognet_docbase.kodshab === "2" || row.dognet_docbase.kodshab ===
                        "4") {
                        return "Договор 3-4/" + row.dognet_docbase.docnumber +
                            " (без календарного плана)";
                    }
                },
                startRender: function(rows, group) {
                    return group;
                },
                endRender: null,
                emptyDataGroup: 'No categories assigned yet'
            },
            select: true,
            processing: true,
            paging: true,
            pagingType: "simple",
            pageLength: 10,
            searching: false,
            lengthChange: false,
            buttons: [{
                    text: '<span class="glyphicon glyphicon-refresh"></span>',
                    action: function(e, dt, node, config) {
                        table_tab5_subpodr.ajax.reload();
                        table_tab5_subpodr.columns().search('').draw();
                    }
                },
                {
                    extend: "create",
                    editor: editor_tab5_subpodr,
                    text: "НОВЫЙ ДОГОВОР",
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
                    editor: editor_tab5_subpodr,
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
                    editor: editor_tab5_subpodr,
                    text: "УДАЛИТЬ"
                }
            ],
        });
        //
        // ##### ##### ##### ##### ##### ##### ##### ##### ##### #####  
        // ##### ##### ##### ##### ##### ##### ##### ##### ##### #####  
        // ##### ##### ##### ##### ##### ##### ##### ##### ##### #####  
        // 
        // ##### ##### ##### ##### ##### ##### ##### ##### ##### #####  
        // 
        var editor_tab5_chfsubpodr = new $.fn.dataTable.Editor({
            display: "bootstrap",
            ajax: {
                url: "php/examples/simple/docview/docview-edit/restr_4/tabs/process/dognet-docview-edit(restr_4)-tab5_subpodr_child_chetfact-process.php",
                data: function(d) {
                    var selected = table_tab5_subpodr.row({
                        selected: true
                    });
                    if (selected.any()) {
                        d.koddocsubpodr = selected.data().dognet_docsubpodr.koddocsubpodr;
                    }
                }
            },
            table: "#docview-edit-tab5_chfsubpodr",
            i18n: {
                create: {
                    title: "<h3>Новый счет-фактура</h3>"
                },
                edit: {
                    title: "<h3>Изменить параметры счета-фактуры</h3>"
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
            template: '#customForm_tab5_chfsubpodr',
            fields: [{
                label: "Договор",
                type: "select",
                name: "dognet_docchfsubpodr.koddocsubpodr",
                de: "---",
                placeholder: "Выберите договор"
            }, {
                label: "Дата",
                name: "dognet_docchfsubpodr.datechfsubpodr",
                type: "datetime",
                format: "DD.MM.YYYY"

            }, {
                label: "Номер счета",
                name: "dognet_docchfsubpodr.numberchfsubpodr"
            }, {
                label: "Сумма счета",
                name: "dognet_docchfsubpodr.sumchfsubpodr"
            }, {
                label: "Задолженность",
                name: "dognet_docchfsubpodr.sumzadolchfsubpodr"
            }]
        });
        var table_tab5_chfsubpodr = $('#docview-edit-tab5_chfsubpodr').DataTable({
            dom: "<'row'<'col-md-8 col-sm-12'B><'col-md-4 col-sm-12'>r>t<'row'<'col-md-4 col-sm-12 footer'><'col-md-8 col-sm-12'p>>",
            language: {
                url: "php/examples/simple/docview/docview-edit/dt_russian-tab5_subpodr_chetfact.json"
            },
            ajax: {
                url: "php/examples/simple/docview/docview-edit/restr_4/tabs/process/dognet-docview-edit(restr_4)-tab5_subpodr_child_chetfact-process.php",
                type: 'post',
                data: function(d) {
                    var selected = table_tab5_subpodr.row({
                        selected: true
                    });
                    if (selected.any()) {
                        d.koddocsubpodr = selected.data().dognet_docsubpodr.koddocsubpodr;
                    }
                }
            },
            serverSide: true,
            select: {
                style: 'single'
            },
            createdRow: function(row, data, index) {

            },
            rowCallback: function(row, data) {

            },
            columns: [{
                    data: "dognet_docsubpodr.koddocsubpodr"
                },
                {
                    data: "dognet_docchfsubpodr.kodchfsubpodr"
                },
                {
                    data: "dognet_docchfsubpodr.datechfsubpodr"
                },
                {
                    data: "dognet_docchfsubpodr.numberchfsubpodr"
                },
                {
                    data: "dognet_docchfsubpodr.sumchfsubpodr"
                },
                {
                    data: "dognet_docchfsubpodr.sumzadolchfsubpodr"
                }
            ],
            columnDefs: [{
                    orderable: false,
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
                    type: "date",
                    targets: 2
                },
                {
                    orderable: false,
                    searchable: false,
                    targets: 3
                },
                {
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row, meta) {
                        if (data != null) {
                            if (row.dognet_spdened.short_code != null) {
                                return $.fn.dataTable.render.number(' ', ',', 2, '').display(data) +
                                    row.dognet_spdened.short_code;
                            } else {
                                return $.fn.dataTable.render.number(' ', ',', 2, '').display(data) +
                                    " р.";
                            }
                        } else {
                            if (row.dognet_spdened.short_code != null) {
                                return "0.00" + row.dognet_spdened.short_code;
                            } else {
                                return "0.00 р.";
                            }
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
            paging: true,
            pagingType: "simple",
            pageLength: 10,
            order: [
                [2, "desc"]
            ],
            buttons: [{
                    text: '<span class="glyphicon glyphicon-refresh"></span>',
                    action: function(e, dt, node, config) {
                        table_tab5_chfsubpodr.ajax.reload();
                        table_tab5_chfsubpodr.columns().search('').draw();
                    }
                },
                {
                    extend: "create",
                    editor: editor_tab5_chfsubpodr,
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
                    editor: editor_tab5_chfsubpodr,
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
                    editor: editor_tab5_chfsubpodr,
                    text: '<span class="glyphicon glyphicon-remove"></span>'
                }
            ]
        });
        //
        // ##### ##### ##### ##### ##### ##### ##### ##### ##### #####  
        // ##### ##### ##### ##### ##### ##### ##### ##### ##### #####  
        // ##### ##### ##### ##### ##### ##### ##### ##### ##### #####  
        // 
        // ##### ##### ##### ##### ##### ##### ##### ##### ##### #####  
        // 
        var editor_tab5_oplchfsubpodr = new $.fn.dataTable.Editor({
            display: "bootstrap",
            ajax: {
                url: "php/examples/simple/docview/docview-edit/restr_4/tabs/process/dognet-docview-edit(restr_4)-tab5_subpodr_child_child_oplatachf-process.php",
                data: function(d) {
                    var selected_doc = table_tab5_subpodr.row({
                        selected: true
                    });
                    if (selected_doc.any()) {
                        d.koddocsubpodr = selected_doc.data().dognet_docsubpodr.koddocsubpodr;
                    } else {
                        d.koddocsubpodr = '';
                    }
                    // ----- ----- ----- ----- ----- 
                    var selected_opl = table_tab5_oplchfsubpodr.row({
                        selected: true
                    });
                    if (selected_opl.any()) {
                        d.kodoplchfsubpodr = selected_opl.data().dognet_docoplchfsubpodr
                            .kodoplchfsubpodr;
                    } else {
                        d.kodoplchfsubpodr = '';
                    }
                    // ----- ----- ----- ----- ----- 
                    var selected_chf = table_tab5_chfsubpodr.row({
                        selected: true
                    });
                    if (selected_chf.any()) {
                        d.kodchfsubpodr = selected_chf.data().dognet_docchfsubpodr.kodchfsubpodr;
                    } else {
                        d.kodchfsubpodr = '';
                    }
                    // ----- ----- ----- ----- ----- 
                    var selected_oplchf = table_tab5_oplchfsubpodr.row({
                        selected: true
                    });
                    if (selected_oplchf.any()) {
                        d.kodchfsubpodr_selected = selected_oplchf.data().dognet_docoplchfsubpodr
                            .kodchfsubpodr;
                    } else {
                        d.kodchfsubpodr_selected = '';
                    }
                    d.kodchfsubpodr_field = editor_tab5_oplchfsubpodr.field(
                            'dognet_docoplchfsubpodr.kodchfsubpodr')
                        .val();

                    console.log('TABLE oplchfsubpodr processing >>>>>', 'koddocsubpodr:', d
                        .koddocsubpodr,
                        'kodavsubpodr:',
                        d.kodavsubpodr, 'kodchfsubpodr_selected:', d.kodchfsubpodr_selected,
                        'kodchfsubpodr_field:', d
                        .kodchfsubpodr_field, '<<<<< TABLE oplchfsubpodr processing');
                }
            },
            table: "#docview-edit-tab5_oplchfsubpodr",
            i18n: {
                create: {
                    title: "<h3>Зачесть сумму из аванса</h3>"
                },
                edit: {
                    title: "<h3>Изменить зачтенную ранее сумму</h3>"
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
            template: '#customForm_tab5_oplchfsubpodr',
            fields: [{
                label: "Счет-фактура :",
                type: "select",
                name: "dognet_docoplchfsubpodr.kodchfsubpodr",
                placeholder: "-- Выберите счет",
                options: [{
                    label: "-- Выберите счет",
                    value: ""
                }]
            }, {
                label: "",
                // type: "hidden",
                name: "dognet_docoplchfsubpodr.koddocsubpodr"
            }, {
                label: "Дата оплаты :",
                name: "dognet_docoplchfsubpodr.dateoplchfsubpodr",
                type: "datetime",
                format: "DD.MM.YYYY"
            }, {
                label: "Сумма оплаты :",
                name: "dognet_docoplchfsubpodr.sumoplchfsubpodr"
            }]
        });
        var table_tab5_oplchfsubpodr = $('#docview-edit-tab5_oplchfsubpodr').DataTable({
            dom: "<'row'<'col-md-8 col-sm-12'B><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'>>",
            language: {
                url: "php/examples/simple/docview/docview-edit/dt_russian-tab5_subpodr_oplatachf.json"
            },
            ajax: {
                url: "php/examples/simple/docview/docview-edit/restr_4/tabs/process/dognet-docview-edit(restr_4)-tab5_subpodr_child_child_oplatachf-process.php",
                type: 'post',
                data: function(d) {
                    var selected_doc = table_tab5_subpodr.row({
                        selected: true
                    });
                    if (selected_doc.any()) {
                        d.koddocsubpodr = selected_doc.data().dognet_docsubpodr.koddocsubpodr;
                    } else {
                        d.koddocsubpodr = '';
                    }
                    // ----- ----- ----- ----- ----- 
                    var selected_opl = table_tab5_oplchfsubpodr.row({
                        selected: true
                    });
                    if (selected_opl.any()) {
                        d.kodoplchfsubpodr = selected_opl.data().dognet_docoplchfsubpodr
                            .kodoplchfsubpodr;
                    } else {
                        d.kodoplchfsubpodr = '';
                    }
                    // ----- ----- ----- ----- ----- 
                    var selected_chf = table_tab5_chfsubpodr.row({
                        selected: true
                    });
                    if (selected_chf.any()) {
                        d.kodchfsubpodr = selected_chf.data().dognet_docchfsubpodr.kodchfsubpodr;
                    } else {
                        d.kodchfsubpodr = '';
                    }
                    // ----- ----- ----- ----- ----- 
                    var selected_oplchf = table_tab5_oplchfsubpodr.row({
                        selected: true
                    });
                    if (selected_oplchf.any()) {
                        d.kodchfsubpodr_selected = selected_oplchf.data().dognet_docoplchfsubpodr
                            .kodchfsubpodr;
                    } else {
                        d.kodchfsubpodr_selected = '';
                    }
                    d.kodchfsubpodr_field = editor_tab5_oplchfsubpodr.field(
                            'dognet_docoplchfsubpodr.kodchfsubpodr')
                        .val();

                    console.log('EDITOR oplchfsubpodr processing >>>>>', 'koddocsubpodr:', d
                        .koddocsubpodr,
                        'kodavsubpodr:',
                        d.kodavsubpodr, 'kodchfsubpodr_selected:', d.kodchfsubpodr_selected,
                        'kodchfsubpodr_field:', d
                        .kodchfsubpodr_field, '<<<<< EDITOR oplchfsubpodr processing');
                }
            },
            serverSide: true,
            select: {
                style: 'single'
            },
            createdRow: function(row, data, index) {
                var selectedChf = table_tab5_chfsubpodr.row({
                    selected: true
                });

                if (selectedChf.any()) {
                    data.kodchfsubpodr = selectedChf.data().dognet_docchfsubpodr.kodchfsubpodr;
                } else {
                    data.kodchfsubpodr = '';
                }

                if ((data.dognet_docoplchfsubpodr.kodchfsubpodr === data.dognet_docchfsubpodr
                        .kodchfsubpodr) &&
                    (data.dognet_docoplchfsubpodr.kodchfsubpodr === data.kodchfsubpodr)) {
                    /* 								$(row).css({ 'color':'#FFF'	}); */
                }

                if (data.dognet_docoplchfsubpodr.kodchfsubpodr === "") {
                    $(row).css({
                        'font-style': 'italic',
                        'color': '#AAA'
                    });
                }
            },
            columns: [{
                    data: "dognet_docoplchfsubpodr.kodchfsubpodr",
                    className: ""
                },
                {
                    data: "dognet_docoplchfsubpodr.dateoplchfsubpodr",
                    className: ""
                },
                {
                    data: "dognet_docoplchfsubpodr.sumoplchfsubpodr",
                    className: ""
                }
            ],
            columnDefs: [{
                    orderable: false,
                    searchable: false,
                    render: function(data) {
                        var selectedChf = table_tab5_chfsubpodr.row({
                            selected: true
                        });
                        if (selectedChf.any()) {
                            val1 = selectedChf.data().dognet_docchfsubpodr.kodchfsubpodr;
                        } else {
                            val1 = '';
                        }
                        if ((data === val1) && val1 != "") {
                            return '<span class="glyphicon glyphicon-link"></span>';
                        } else {
                            return '';
                        }
                    },
                    targets: 0
                },
                {
                    orderable: true,
                    searchable: false,
                    type: "date",
                    targets: 1
                },
                {
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row, meta) {
                        if (data != null) {
                            if (row.dognet_spdened.short_code != null) {
                                return $.fn.dataTable.render.number(' ', ',', 2, '').display(data) +
                                    row.dognet_spdened.short_code;
                            } else {
                                return $.fn.dataTable.render.number(' ', ',', 2, '').display(data) +
                                    " р.";
                            }
                        } else {
                            if (row.dognet_spdened.short_code != null) {
                                return "0.00" + row.dognet_spdened.short_code;
                            } else {
                                return "0.00 р.";
                            }
                        }
                    },
                    targets: 2
                },
            ],
            order: [
                [1, "desc"]
            ],
            buttons: [{
                    extend: "create",
                    editor: editor_tab5_oplchfsubpodr,
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
                    editor: editor_tab5_oplchfsubpodr,
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
                    editor: editor_tab5_oplchfsubpodr,
                    text: '<span class="glyphicon glyphicon-remove"></span>'
                }
            ]
        });
        //
        // ##### ##### ##### ##### ##### ##### ##### ##### ##### #####  
        // ##### ##### ##### ##### ##### ##### ##### ##### ##### #####  
        // ##### ##### ##### ##### ##### ##### ##### ##### ##### #####  
        // 
        // ##### ##### ##### ##### ##### ##### ##### ##### ##### #####  
        // 
        var editor_tab5_avchfsubpodr = new $.fn.dataTable.Editor({
            display: "bootstrap",
            ajax: {
                url: "php/examples/simple/docview/docview-edit/restr_4/tabs/process/dognet-docview-edit(restr_4)-tab5_subpodr_child_child_avanschf-process.php",
                data: function(d) {
                    var selected_doc = table_tab5_subpodr.row({
                        selected: true
                    });
                    if (selected_doc.any()) {
                        d.koddocsubpodr = selected_doc.data().dognet_docsubpodr.koddocsubpodr;
                    } else {
                        d.koddocsubpodr = '';
                    }
                    // ----- ----- ----- ----- ----- 
                    var selected_av = table_tab5_avchfsubpodr.row({
                        selected: true
                    });
                    if (selected_av.any()) {
                        d.kodavsubpodr = selected_av.data().dognet_docavsubpodr.kodavsubpodr;
                    } else {
                        d.kodavsubpodr = '';
                    }
                    // ----- ----- ----- ----- ----- 
                    var selected_chf = table_tab5_avchfsubpodr.row({
                        selected: true
                    });
                    if (selected_chf.any()) {
                        d.kodchfsubpodr_selected = selected_chf.data().dognet_docavsubpodr
                            .kodchfsubpodr;
                    } else {
                        d.kodchfsubpodr_selected = '';
                    }
                    d.kodchfsubpodr_field = editor_tab5_avchfsubpodr.field(
                            'dognet_docavsubpodr.kodchfsubpodr')
                        .val();

                    console.log('EDIT avchfsubpodr processing >>>>>', 'koddocsubpodr:', d.koddocsubpodr,
                        'kodavsubpodr:',
                        d.kodavsubpodr, 'kodchfsubpodr_selected:', d.kodchfsubpodr_selected,
                        'kodchfsubpodr_field:', d
                        .kodchfsubpodr_field, '<<<<< EDIT avchfsubpodr processing');
                },
                success: function(json) {}
            },
            table: "#docview-edit-tab5_avchfsubpodr",
            i18n: {
                create: {
                    title: "<h3>Добавить аванс</h3>"
                },
                edit: {
                    title: "<h3>Изменить параметры аванса</h3>"
                },
                remove: {
                    button: "Удалить",
                    title: "<h3>Удалить аванс</h3>",
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
            template: '#customForm_tab5_avchfsubpodr',
            fields: [{
                label: "Договор",
                type: "select",
                name: "dognet_docavsubpodr.koddocsubpodr",
                placeholder: "-- Выберите договор"
            }, {
                label: "Счет-фактура (для зачета аванса)",
                type: "select",
                name: "dognet_docavsubpodr.kodchfsubpodr",
                placeholder: "-- Без привязки к счету",
                placeholderValue: "",
                options: [{
                    label: "-- Без привязки к счету",
                    value: ""
                }]
            }, {
                label: "Дата аванса",
                name: "dognet_docavsubpodr.dateavsubpodr",
                type: "datetime",
                format: "DD.MM.YYYY"
            }, {
                label: "Сумма аванса",
                name: "dognet_docavsubpodr.sumavsubpodr",
            }, {
                label: "Остаток",
                name: "dognet_docavsubpodr.sumostsubpodr",
                type: "readonly"
            }, {
                label: "Вариант зачета аванса",
                type: "select",
                name: "dognet_docavsubpodr.useavans",
                options: [{
                        label: "Без зачета аванса",
                        value: "0"
                    },
                    {
                        label: "Разбить аванс на части",
                        value: "1"
                    },
                    {
                        label: "Зачесть аванс полностью",
                        value: "2"
                    },
                ],
                placeholder: "Выберите вариант"
            }, {
                label: "Очистить",
                type: "checkbox",
                name: "cancelAvans",
                unselectedValue: 0,
                options: {
                    "": 1
                }
            }]
        });
        var table_tab5_avchfsubpodr = $('#docview-edit-tab5_avchfsubpodr').DataTable({
            dom: "<'row'<'col-md-8 col-sm-12'B><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'>>",
            language: {
                url: "php/examples/simple/docview/docview-edit/dt_russian-tab5_subpodr_chfavans.json"
            },
            ajax: {
                url: "php/examples/simple/docview/docview-edit/restr_4/tabs/process/dognet-docview-edit(restr_4)-tab5_subpodr_child_child_avanschf-process.php",
                type: 'post',
                data: function(d) {
                    var selected_doc = table_tab5_subpodr.row({
                        selected: true
                    });
                    if (selected_doc.any()) {
                        d.koddocsubpodr = selected_doc.data().dognet_docsubpodr.koddocsubpodr;
                    } else {
                        d.koddocsubpodr = '';
                    }
                    // ----- ----- ----- ----- ----- 
                    var selected_av = table_tab5_avchfsubpodr.row({
                        selected: true
                    });
                    if (selected_av.any()) {
                        d.kodavsubpodr = selected_av.data().dognet_docavsubpodr.kodavsubpodr;
                    } else {
                        d.kodavsubpodr = '';
                    }
                    // ----- ----- ----- ----- ----- 
                    var selected_chf = table_tab5_avchfsubpodr.row({
                        selected: true
                    });
                    if (selected_chf.any()) {
                        d.kodchfsubpodr_selected = selected_chf.data().dognet_docavsubpodr
                            .kodchfsubpodr;
                    } else {
                        d.kodchfsubpodr_selected = '';
                    }
                    d.kodchfsubpodr_field = editor_tab5_avchfsubpodr.field(
                            'dognet_docavsubpodr.kodchfsubpodr')
                        .val();

                    console.log('TABLE avchfsubpodr processing >>>>>', 'koddocsubpodr:', d
                        .koddocsubpodr, 'kodavsubpodr:',
                        d.kodavsubpodr, 'kodchfsubpodr_selected:', d.kodchfsubpodr_selected,
                        'kodchfsubpodr_field:', d
                        .kodchfsubpodr_field, '<<<<< TABLE kodchfsubpodr processing');
                }
            },
            serverSide: true,
            select: {
                style: 'single'
            },
            createdRow: function(row, data, index) {
                var selectedChf = table_tab5_chfsubpodr.row({
                    selected: true
                });

                if (selectedChf.any()) {
                    data.kodchfsubpodr = selectedChf.data().dognet_docchfsubpodr.kodchfsubpodr;
                } else {
                    data.kodchfsubpodr = '';
                }
            },
            columns: [{
                    data: "dognet_docavsubpodr.kodchfsubpodr",
                    className: ""
                },
                {
                    data: "dognet_docavsubpodr.useavans",
                    className: ""
                },
                {
                    data: "dognet_docavsubpodr.dateavsubpodr",
                    className: ""
                },
                {
                    data: "dognet_docavsubpodr.sumavsubpodr",
                    className: ""
                },
                {
                    data: "dognet_docavsubpodr.sumchfavsubpodr",
                    className: ""
                },
                {
                    data: "dognet_docavsubpodr.sumostsubpodr",
                    className: ""
                },
                {
                    data: "dognet_docavsubpodr.sumsplitsubpodr",
                    className: ""
                }
            ],
            columnDefs: [{
                    orderable: false,
                    searchable: false,
                    render: function(data) {
                        var selectedChf = table_tab5_chfsubpodr.row({
                            selected: true
                        });
                        if (selectedChf.any()) {
                            val1 = selectedChf.data().dognet_docchfsubpodr.kodchfsubpodr;
                        } else {
                            val1 = '';
                        }
                        if ((data === val1) && val1 != "") {
                            return '<span class="glyphicon glyphicon-link"></span>';
                        } else {
                            return '';
                        }
                    },
                    targets: 0
                },
                {
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row, meta) {
                        res = '';
                        if (data === "0") {
                            res = '<div class="lbl lbl-light">Без зачета</div>';
                        } else if (data === "1") {
                            if (row.dognet_docavsubpodr.sumsplitsubpodr > 0) {
                                res = '<div class="lbl lbl-red">Сплит</div>';
                            } else {
                                res = '<div class="lbl lbl-red-o">Сплит</div>';
                            }
                        } else if (data === "2") {
                            res = '<div class="lbl lbl-green">Зачет</div>';
                        }
                        return res;
                    },
                    targets: 1
                },
                {
                    orderable: false,
                    searchable: false,
                    type: "date",
                    targets: 2
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
                },
                {
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row, meta) {
                        if (data != null) {
                            useavans = row.dognet_docavsubpodr.useavans;
                            dataOutput = "<span style='margin-right:6px'>" + $.fn.dataTable.render
                                .number(' ', ',', 2, '')
                                .display(data) + "</span>";
                            diff = parseFloat(row.dognet_docavsubpodr.sumavsubpodr) - parseFloat(
                                data);
                            color = (diff > 0) ? 'green' : 'inherit';
                            diffOutput = (useavans == '1') ? "<span style=''>(&nbsp;" + $.fn
                                .dataTable.render.number(' ',
                                    ',', 2, '').display(parseFloat(row.dognet_docavsubpodr
                                    .sumavsubpodr) - parseFloat(data)) +
                                "&nbsp;)</span>" : "( аванс не в сплите )";
                            return ((useavans == '1') ? dataOutput : "") + diffOutput + ((
                                    useavans != '1') ? "" : row
                                .dognet_spdened.short_code);
                        } else {
                            return "-";
                        }
                    },
                    targets: 6
                }
            ],
            order: [
                [2, "desc"]
            ],
            buttons: [{
                    extend: "create",
                    editor: editor_tab5_avchfsubpodr,
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
                    editor: editor_tab5_avchfsubpodr,
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
                    editor: editor_tab5_avchfsubpodr,
                    text: '<span class="glyphicon glyphicon-remove"></span>'
                }
            ]
        });
        //
        // ##### ##### ##### ##### ##### ##### ##### ##### ##### #####  
        // ##### ##### ##### ##### ##### ##### ##### ##### ##### #####  
        // ##### ##### ##### ##### ##### ##### ##### ##### ##### #####  
        // 
        // ##### ##### ##### ##### ##### ##### ##### ##### ##### #####  
        // 
        var editor_tab5_avsplitsubpodr = new $.fn.dataTable.Editor({
            display: "bootstrap",
            ajax: {
                url: "php/examples/simple/docview/docview-edit/restr_4/tabs/process/dognet-docview-edit(restr_4)-tab5_subpodr_child_child_avanschfsplit-process.php",
                data: function(d) {
                    var selected_sub = table_tab5_subpodr.row({
                        selected: true
                    });
                    if (selected_sub.any()) {
                        d.koddocsubpodr = selected_sub.data().dognet_docsubpodr.koddocsubpodr;
                    } else {
                        d.koddocsubpodr = '';
                    }
                    //
                    //
                    var selected_av = table_tab5_avchfsubpodr.row({
                        selected: true
                    });
                    if (selected_av.any()) {
                        d.kodavsubpodr = selected_av.data().dognet_docavsubpodr.kodavsubpodr;
                    } else {
                        d.kodavsubpodr = '';
                    }
                    //
                    //
                    var selected_chf = table_tab5_avsplitsubpodr.row({
                        selected: true
                    });
                    if (selected_chf.any()) {
                        d.kodchfsubpodr_selected = selected_chf.data().dognet_docavsplitsubpodr
                            .kodchfsubpodr;
                        d.sumavsplit_selected = selected_chf.data().dognet_docavsplitsubpodr.sumavsplit;
                    } else {
                        d.kodchfsubpodr_selected = '';
                        d.sumavsplit_selected = '';
                    }
                    d.kodchfsubpodr_field = editor_tab5_avsplitsubpodr.field(
                            'dognet_docavsplitsubpodr.kodchfsubpodr')
                        .val();
                    d.sumavsplit_field = editor_tab5_avsplitsubpodr.field(
                        'dognet_docavsplitsubpodr.sumavsplit').val();
                    console.log(d.koddocsubpodr, d.kodavsubpodr);
                    console.log('kodchfsubpodr processing >>>>>', 'kodchfsubpodr_selected:', d
                        .kodchfsubpodr_selected,
                        'kodchfsubpodr_field:', d
                        .kodchfsubpodr_field, 'sumavsplit_selected:', d.sumavsplit_selected,
                        'sumavsplit_field:', d
                        .sumavsplit_field, '<<<<< kodchfsubpodr processing');
                },
                success: function(json) {}
            },
            table: "#docview-edit-tab5_avsplitsubpodr",
            i18n: {
                create: {
                    title: "<h3>Добавить сплит суммы аванса</h3>"
                },
                edit: {
                    title: "<h3>Изменить параметры сплита</h3>"
                },
                remove: {
                    button: "Удалить",
                    title: "<h3>Удалить сплит</h3>",
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
            template: '#customForm_tab5_avsplitsubpodr',
            fields: [{
                label: "Счет-фактура",
                type: "select",
                name: "dognet_docavsplitsubpodr.kodchfsubpodr",
                placeholder: "-- Без привязки к счету",
                placeholderValue: "",
                options: [{
                    label: "-- Без привязки к счету",
                    value: ""
                }]
            }, {
                label: "Дата",
                name: "dognet_docavsplitsubpodr.dateavsplit",
                type: "datetime",
                format: "DD.MM.YYYY"
            }, {
                label: "Сумма сплита",
                name: "dognet_docavsplitsubpodr.sumavsplit"
            }, {
                label: "Очистить",
                type: "checkbox",
                name: "cancelChf",
                unselectedValue: 0,
                options: {
                    "": 1
                }
            }, {
                label: "",
                name: "dognet_docavsplitsubpodr.koddocsubpodr",
                type: "hidden"
            }, {
                label: "",
                name: "dognet_docavsplitsubpodr.kodavsubpodr",
                type: "hidden"
            }]
        });
        var table_tab5_avsplitsubpodr = $('#docview-edit-tab5_avsplitsubpodr').DataTable({
            dom: "<'row'<'col-md-8 col-sm-12'B><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'>>",
            language: {
                url: "php/examples/simple/docview/docview-edit/dt_russian-tab5_subpodr_chfavanssplit.json"
            },
            ajax: {
                url: "php/examples/simple/docview/docview-edit/restr_4/tabs/process/dognet-docview-edit(restr_4)-tab5_subpodr_child_child_avanschfsplit-process.php",
                type: 'post',
                data: function(d) {
                    var selected_sub = table_tab5_subpodr.row({
                        selected: true
                    });
                    if (selected_sub.any()) {
                        d.koddocsubpodr = selected_sub.data().dognet_docsubpodr.koddocsubpodr;
                    } else {
                        d.koddocsubpodr = '';
                    }
                    //
                    //
                    var selected_av = table_tab5_avchfsubpodr.row({
                        selected: true
                    });
                    if (selected_av.any()) {
                        d.kodavsubpodr = selected_av.data().dognet_docavsubpodr.kodavsubpodr;
                    } else {
                        d.kodavsubpodr = '';
                    }
                    //
                    //
                    var selected_chf = table_tab5_avsplitsubpodr.row({
                        selected: true
                    });
                    if (selected_chf.any()) {
                        d.kodchfsubpodr = selected_chf.data().dognet_docavsplitsubpodr.kodchfsubpodr;
                    } else {
                        d.kodchfsubpodr = '';
                    }
                    console.log(d.koddocsubpodr, d.kodavsubpodr, d.kodchfsubpodr);
                }
            },
            serverSide: true,
            select: {
                style: 'single'
            },
            createdRow: function(row, data, index) {
                var selectedChf = table_tab5_chfsubpodr.row({
                    selected: true
                });

                if (selectedChf.any()) {
                    data.kodchfsubpodr = selectedChf.data().dognet_docchfsubpodr.kodchfsubpodr;
                } else {
                    data.kodchfsubpodr = '';
                }
            },
            columns: [{
                    data: "dognet_docavsplitsubpodr.kodchfsubpodr",
                    className: ""
                },
                {
                    data: "dognet_docavsplitsubpodr.dateavsplit",
                    className: ""
                },
                {
                    data: "dognet_docavsplitsubpodr.sumavsplit",
                    className: ""
                }
            ],
            columnDefs: [{
                    orderable: false,
                    searchable: false,
                    render: function(data) {
                        var selectedChf = table_tab5_chfsubpodr.row({
                            selected: true
                        });
                        if (selectedChf.any()) {
                            val1 = selectedChf.data().dognet_docchfsubpodr.kodchfsubpodr;
                        } else {
                            val1 = '';
                        }
                        if ((data === val1) && val1 != "") {
                            return '<span class="glyphicon glyphicon-link"></span>';
                        } else {
                            return '';
                        }
                    },
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
            order: [
                [1, "desc"]
            ],
            buttons: [{
                    extend: "create",
                    editor: editor_tab5_avsplitsubpodr,
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
                    editor: editor_tab5_avsplitsubpodr,
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
                    editor: editor_tab5_avsplitsubpodr,
                    text: '<span class="glyphicon glyphicon-remove"></span>'
                }
            ]
        });
        //
        //
        //
        // ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
        // ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
        // ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
        // ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
        // ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
        // ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
        //
        //
        //
        editor_tab5_subpodr
            .on('open', function() {
                // Store the values of the fields on open
                openVals_tab5_subpodr = JSON.stringify(editor_tab5_subpodr.get());
                editor_tab5_subpodr.on('preBlur', function(e) {
                    // On close, check if the values have changed and ask for closing confirmation if they have
                    if (openVals_tab5_subpodr !== JSON.stringify(editor_tab5_subpodr.get())) {
                        return confirm('Вы не сохранили данные формы. Уверены, что хотите ее закрыть?');
                    }
                })
                $('#DTE_Field_dognet_docsubpodr-sumdocsubpodr').inputmask({
                    alias: "currency",
                    rightAlign: false,
                    greedy: false,
                    tabThrough: true,

                    enforceDigitsOnBlur: false,
                    radixPoint: ".",
                    positionCaretOnClick: "radixFocus",
                    groupSeparator: " ",
                    allowMinus: "true",
                    // 		        min: undefined,
                    // 		        max: undefined,
                    // 		        step: 1,
                    inputType: "number",
                    unmaskAsNumber: false,
                    // 		        roundingFN: Math.round,
                    // 		        shortcuts: {k: "000", m: "000000"},
                    suffix: " р",
                    removeMaskOnSubmit: true,
                    autoUnmask: true,
                    onUnMask: function(maskedValue, unmaskedValue) {
                        var x = unmaskedValue.split('.');
                        return x[0].replace(/\ /g, '') + '.' + x[1];
                    }
                });
                $('#DTE_Field_dognet_docsubpodr-datedocsubpodr').inputmask({
                    mask: "99.99.9999"
                });
                $('#DTE_Field_dognet_docsubpodr-numberdocsubpodr').inputmask({
                    // mask: "3-6/9{1,4}"
                });
            });
        //
        editor_tab5_chfsubpodr
            .on('open', function() {
                // Store the values of the fields on open
                openVals_tab5_chfsubpodr = JSON.stringify(editor_tab5_chfsubpodr.get());
                editor_tab5_chfsubpodr.on('preBlur', function(e) {
                    // On close, check if the values have changed and ask for closing confirmation if they have
                    if (openVals_tab5_chfsubpodr !== JSON.stringify(editor_tab5_chfsubpodr.get())) {
                        return confirm('Вы не сохранили данные формы. Уверены, что хотите ее закрыть?');
                    }
                })
                $('#DTE_Field_dognet_docchfsubpodr-sumchfsubpodr').inputmask({
                    alias: "currency",
                    rightAlign: false,
                    greedy: false,
                    tabThrough: true,

                    enforceDigitsOnBlur: false,
                    radixPoint: ".",
                    positionCaretOnClick: "radixFocus",
                    groupSeparator: " ",
                    allowMinus: "true",
                    // 		        min: undefined,
                    // 		        max: undefined,
                    // 		        step: 1,
                    inputType: "number",
                    unmaskAsNumber: false,
                    // 		        roundingFN: Math.round,
                    // 		        shortcuts: {k: "000", m: "000000"},
                    suffix: " р",
                    removeMaskOnSubmit: true,
                    autoUnmask: true,
                    onUnMask: function(maskedValue, unmaskedValue) {
                        var x = unmaskedValue.split('.');
                        return x[0].replace(/\ /g, '') + '.' + x[1];
                    }
                });
                $('#DTE_Field_dognet_docchfsubpodr-datechfsubpodr').inputmask({
                    mask: "99.99.9999"
                });
            });
        //
        editor_tab5_avchfsubpodr
            .on('open', function() {
                // Store the values of the fields on open
                openVals_tab5_avchfsubpodr = JSON.stringify(editor_tab5_avchfsubpodr.get());
                editor_tab5_avchfsubpodr.on('preBlur', function(e) {
                    // On close, check if the values have changed and ask for closing confirmation if they have
                    if (openVals_tab5_avchfsubpodr !== JSON.stringify(editor_tab5_avchfsubpodr.get())) {
                        return confirm('Вы не сохранили данные формы. Уверены, что хотите ее закрыть?');
                    }
                })
                $('#DTE_Field_dognet_docavsubpodr-sumavsubpodr').inputmask({
                    alias: "currency",
                    rightAlign: false,
                    greedy: false,
                    tabThrough: true,

                    enforceDigitsOnBlur: false,
                    radixPoint: ".",
                    positionCaretOnClick: "radixFocus",
                    groupSeparator: " ",
                    allowMinus: "true",
                    // 		        min: undefined,
                    // 		        max: undefined,
                    // 		        step: 1,
                    inputType: "number",
                    unmaskAsNumber: false,
                    // 		        roundingFN: Math.round,
                    // 		        shortcuts: {k: "000", m: "000000"},
                    suffix: " р",
                    removeMaskOnSubmit: true,
                    autoUnmask: true,
                    onUnMask: function(maskedValue, unmaskedValue) {
                        var x = unmaskedValue.split('.');
                        return x[0].replace(/\ /g, '') + '.' + x[1];
                    }
                });
                $('#DTE_Field_dognet_docavsubpodr-dateavsubpodr').inputmask({
                    mask: "99.99.9999"
                });
            });
        //
        editor_tab5_oplchfsubpodr
            .on('open', function(e, mode, action) {
                // Store the values of the fields on open
                openVals_tab5_oplchfsubpodr = JSON.stringify(editor_tab5_oplchfsubpodr.get());
                editor_tab5_oplchfsubpodr.on('preBlur', function(e) {
                    // On close, check if the values have changed and ask for closing confirmation if they have
                    if (openVals_tab5_oplchfsubpodr !== JSON.stringify(editor_tab5_oplchfsubpodr
                            .get())) {
                        return confirm('Вы не сохранили данные формы. Уверены, что хотите ее закрыть?');
                    }
                })
                if (action === 'create' || action === 'edit') {
                    editor_tab5_oplchfsubpodr
                        .field('dognet_docoplchfsubpodr.koddocsubpodr')
                        .set(table_tab5_subpodr.row({
                            selected: true
                        }).data().dognet_docsubpodr.koddocsubpodr);
                }
                $('#DTE_Field_dognet_docoplchfsubpodr-sumoplchfsubpodr').inputmask({
                    alias: "currency",
                    rightAlign: false,
                    greedy: false,
                    tabThrough: true,

                    enforceDigitsOnBlur: false,
                    radixPoint: ".",
                    positionCaretOnClick: "radixFocus",
                    groupSeparator: " ",
                    allowMinus: "true",
                    // 		        min: undefined,
                    // 		        max: undefined,
                    // 		        step: 1,
                    inputType: "number",
                    unmaskAsNumber: false,
                    // 		        roundingFN: Math.round,
                    // 		        shortcuts: {k: "000", m: "000000"},
                    suffix: " р",
                    removeMaskOnSubmit: true,
                    autoUnmask: true,
                    onUnMask: function(maskedValue, unmaskedValue) {
                        var x = unmaskedValue.split('.');
                        return x[0].replace(/\ /g, '') + '.' + x[1];
                    }
                });
                $('#DTE_Field_dognet_docoplchfsubpodr-dateoplchfsubpodr').inputmask({
                    mask: "99.99.9999"
                });
            });
        // ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
        // ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
        //
        // ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
        // ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 

        editor_tab5_avchfsubpodr
            .on('open', function() {
                var useavans = editor_tab5_avchfsubpodr.field('dognet_docavsubpodr.useavans').val();
                var kodchf = editor_tab5_avchfsubpodr.field('dognet_docavsubpodr.kodchfsubpodr').val();
                //
                editor_tab5_avchfsubpodr.dependent('cancelAvans', function(val) {
                    if (val == 1) {
                        editor_tab5_avchfsubpodr.field('cancelAvans').processing(false);
                        editor_tab5_avchfsubpodr.field('dognet_docavsubpodr.kodchfsubpodr').set("");
                        editor_tab5_avchfsubpodr.field('cancelAvans').val(0);
                    }
                });
                //
                editor_tab5_avchfsubpodr.dependent('dognet_docavsubpodr.useavans', function(val) {
                    var kodchf = editor_tab5_avchfsubpodr.field('dognet_docavsubpodr.kodchfsubpodr')
                        .val();
                    if (val == 0) {
                        editor_tab5_avchfsubpodr.field('dognet_docavsubpodr.kodchfsubpodr').hide(false);
                        editor_tab5_avchfsubpodr.field('cancelAvans').hide(false);
                        editor_tab5_avchfsubpodr.field('dognet_docavsubpodr.kodchfsubpodr').disable();
                        editor_tab5_avchfsubpodr.field('dognet_docavsubpodr.kodchfsubpodr').set("");
                        editor_tab5_avchfsubpodr.field('dognet_docavsubpodr.kodchfsubpodr').error('');
                    } else if (val == 1) {
                        editor_tab5_avchfsubpodr.field('dognet_docavsubpodr.kodchfsubpodr').hide(false);
                        editor_tab5_avchfsubpodr.field('cancelAvans').hide(false);
                        editor_tab5_avchfsubpodr.field('dognet_docavsubpodr.kodchfsubpodr').disable();
                        editor_tab5_avchfsubpodr.field('dognet_docavsubpodr.kodchfsubpodr').set("");
                        editor_tab5_avchfsubpodr.field('dognet_docavsubpodr.kodchfsubpodr').error('');
                    } else if (val == 2) {
                        editor_tab5_avchfsubpodr.field('dognet_docavsubpodr.kodchfsubpodr').enable();
                        editor_tab5_avchfsubpodr.field('dognet_docavsubpodr.kodchfsubpodr').show(false);
                        editor_tab5_avchfsubpodr.field('cancelAvans').show(false);
                        editor_tab5_avchfsubpodr.field('dognet_docavsubpodr.kodchfsubpodr').focus();
                        if (kodchf == "") {
                            editor_tab5_avchfsubpodr.field('dognet_docavsubpodr.kodchfsubpodr').error(
                                'Для полного зачета выбрать счет надо обязательно');
                        } else {
                            editor_tab5_avchfsubpodr.field('dognet_docavsubpodr.kodchfsubpodr').error(
                                '');
                        }
                    }
                });
                //
                editor_tab5_avchfsubpodr.dependent('dognet_docavsubpodr.kodchfsubpodr', function(val) {
                    if (val == "" && editor_tab5_avchfsubpodr.field('dognet_docavsubpodr.useavans')
                        .val() == "2") {
                        editor_tab5_avchfsubpodr.field('dognet_docavsubpodr.kodchfsubpodr').error(
                            'Для полного зачета выбрать счет надо обязательно');
                    } else {
                        editor_tab5_avchfsubpodr.field('dognet_docavsubpodr.kodchfsubpodr').error('');
                    }
                });
            });

        // ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
        // ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 

        editor_tab5_avsplitsubpodr
            .on('open', function(e, mode, action) {
                editor_tab5_avsplitsubpodr.dependent('cancelChf', function(val) {
                    if (val == 1) {
                        editor_tab5_avsplitsubpodr.field('cancelChf').processing(false);
                        editor_tab5_avsplitsubpodr.field('dognet_docavsplitsubpodr.kodchfsubpodr').set(
                            "");
                        editor_tab5_avsplitsubpodr.field('cancelChf').val(0);
                    }
                });
                if (action === 'create') {
                    editor_tab5_avsplitsubpodr
                        .field('dognet_docavsplitsubpodr.kodavsubpodr')
                        .set(table_tab5_avchfsubpodr.row({
                            selected: true
                        }).data().dognet_docavsubpodr.kodavsubpodr);
                    editor_tab5_avsplitsubpodr
                        .field('dognet_docavsplitsubpodr.koddocsubpodr')
                        .set(table_tab5_avchfsubpodr.row({
                            selected: true
                        }).data().dognet_docavsubpodr.koddocsubpodr);
                }
                $(document).on("change", "select#DTE_Field_dognet_docavsplitsubpodr-kodchfsubpodr", function() {
                    ajaxRequest_calcChfAvOstatok(editor_tab5_avsplitsubpodr.field(
                            'dognet_docavsplitsubpodr.kodavsubpodr')
                        .val(), editor_tab5_avsplitsubpodr.field(
                            'dognet_docavsplitsubpodr.kodchfsubpodr').val(),
                        editor_tab5_avsplitsubpodr.field('dognet_docavsplitsubpodr.sumavsplit')
                        .val(), 'calcChfAvOstatok');
                });
                $(document).on("keyup", "input#DTE_Field_dognet_docavsplitsubpodr-sumavsplit", function() {
                    ajaxRequest_calcChfAvOstatok(editor_tab5_avsplitsubpodr.field(
                            'dognet_docavsplitsubpodr.kodavsubpodr')
                        .val(), editor_tab5_avsplitsubpodr.field(
                            'dognet_docavsplitsubpodr.kodchfsubpodr').val(),
                        editor_tab5_avsplitsubpodr.field('dognet_docavsplitsubpodr.sumavsplit')
                        .val(), 'calcChfAvOstatok');

                });
            });

        editor_tab5_avsplitsubpodr
            .on('preSubmit', function(e, data, action) {

                var selected_split = table_tab5_avsplitsubpodr.row({
                    selected: true
                });
                if (selected_split.any()) {
                    var selectedSplit = selected_split.data().dognet_docavsplitsubpodr.sumavsplit;
                } else {
                    var selectedSplit = 0.0;
                }

                if (action === "create") {
                    var Input_SumSplit = parseFloat(editor_tab5_avsplitsubpodr.field(
                            'dognet_docavsplitsubpodr.sumavsplit')
                        .val()) + parseFloat(window.res_sumavsplit);
                    var limit = parseFloat(window.res_sumav) - parseFloat(window.res_sumavsplit);
                    var errMessage = (limit > 0) ? ('Не более ' + $.fn.dataTable.render.number(' ', ',', 2, '')
                        .display(
                            limit)) : 'Аванс исчерпан';
                    if (Input_SumSplit > parseFloat(window.res_sumav)) {
                        editor_tab5_avsplitsubpodr.field('dognet_docavsplitsubpodr.sumavsplit').error(
                            errMessage);
                        editor_tab5_avsplitsubpodr.field('dognet_docavsplitsubpodr.sumavsplit').val(limit);
                        return (false);
                    } else {
                        editor_tab5_avsplitsubpodr.field('dognet_docavsplitsubpodr.sumavsplit').error('');
                    }
                }
                if (action === "edit") {
                    var Input_SumSplit = parseFloat(editor_tab5_avsplitsubpodr.field(
                            'dognet_docavsplitsubpodr.sumavsplit')
                        .val()) + parseFloat(window.res_sumavsplit) - parseFloat(selectedSplit);
                    var limit = parseFloat(window.res_sumav) - parseFloat(window.res_sumavsplit);
                    var errMessage = (limit > 0) ? ('Не более ' + $.fn.dataTable.render.number(' ', ',', 2, '')
                        .display(
                            limit)) : 'Аванс исчерпан';
                    if (Input_SumSplit > parseFloat(window.res_sumav)) {
                        editor_tab5_avsplitsubpodr.field('dognet_docavsplitsubpodr.sumavsplit').error(
                            errMessage);
                        editor_tab5_avsplitsubpodr.field('dognet_docavsplitsubpodr.sumavsplit').val(limit);
                        return (false);
                    } else {
                        editor_tab5_avsplitsubpodr.field('dognet_docavsplitsubpodr.sumavsplit').error('');
                    }
                }
            });

        // ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
        // ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
        //
        // ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
        // ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
        table_tab5_subpodr.on('init', function() {
            table_tab5_chfsubpodr.buttons().disable();
            table_tab5_oplchfsubpodr.buttons().disable();
            table_tab5_avchfsubpodr.buttons().disable();
            table_tab5_avsplitsubpodr.buttons().disable();
        });
        // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
        //
        //
        //
        // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
        table_tab5_subpodr.on('select', function() {
            // Обрабатываем форму оплат счетов (oplchfsubpodr)
            table_tab5_chfsubpodr.buttons().enable();
            table_tab5_chfsubpodr.ajax.reload();
            editor_tab5_chfsubpodr
                .field('dognet_docchfsubpodr.koddocsubpodr')
                .set(table_tab5_subpodr.row({
                    selected: true
                }).data().dognet_docsubpodr.koddocsubpodr);
            // Обрабатываем форму авансов (avchfsubpodr)
            table_tab5_avchfsubpodr.buttons().enable();
            table_tab5_avchfsubpodr.ajax.reload();
            editor_tab5_avchfsubpodr
                .field('dognet_docavsubpodr.koddocsubpodr')
                .set(table_tab5_subpodr.row({
                    selected: true
                }).data().dognet_docsubpodr.koddocsubpodr);
            table_tab5_avsplitsubpodr.ajax.reload();
        });
        //
        table_tab5_subpodr.on('deselect', function() {
            // Обрабатываем форму счетов-фактур (chfsubpodr)
            table_tab5_chfsubpodr.buttons().disable();
            table_tab5_chfsubpodr.row({
                selected: true
            }).deselect();
            table_tab5_chfsubpodr.ajax.reload();
            // Обрабатываем форму оплат счетов (oplchfsubpodr)
            table_tab5_oplchfsubpodr.buttons().disable();
            table_tab5_oplchfsubpodr.ajax.reload();
            // Обрабатываем форму авансов (avchfsubpodr)
            table_tab5_avchfsubpodr.buttons().disable();
            table_tab5_avchfsubpodr.ajax.reload();
            //
            table_tab5_avsplitsubpodr.buttons().disable();
        });
        //
        editor_tab5_subpodr.on('submitSuccess', function() {
            table_tab5_chfsubpodr.ajax.reload();
        });
        //
        editor_tab5_chfsubpodr.on('submitSuccess', function() {
            table_tab5_subpodr.ajax.reload();
        });
        // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
        //
        //
        //
        // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
        table_tab5_chfsubpodr.on('select', function() {
            table_tab5_oplchfsubpodr.buttons().enable();
            table_tab5_oplchfsubpodr.ajax.reload();
            editor_tab5_oplchfsubpodr
                .field('dognet_docoplchfsubpodr.kodchfsubpodr')
                .set(table_tab5_chfsubpodr.row({
                    selected: true
                }).data().dognet_docchfsubpodr.kodchfsubpodr);
            table_tab5_avchfsubpodr.buttons().enable();
            table_tab5_avchfsubpodr.ajax.reload();
            editor_tab5_avchfsubpodr
                .field('dognet_docavsubpodr.kodchfsubpodr')
                .set(table_tab5_chfsubpodr.row({
                    selected: true
                }).data().dognet_docchfsubpodr.kodchfsubpodr);
        });
        //
        table_tab5_chfsubpodr.on('deselect', function() {
            table_tab5_oplchfsubpodr.buttons().disable();
            table_tab5_oplchfsubpodr.ajax.reload();
            /* 			table_tab5_avchfsubpodr.buttons().disable(); */
            table_tab5_avchfsubpodr.ajax.reload();
        });
        editor_tab5_chfsubpodr.on('submitSuccess', function() {
            table_tab5_oplchfsubpodr.ajax.reload();
            table_tab5_avchfsubpodr.ajax.reload();
        });
        //
        editor_tab5_chfsubpodr.on('initEdit', function() {
            editor_tab5_chfsubpodr.field('dognet_docchfsubpodr.koddocsubpodr').disable();
        });
        editor_tab5_chfsubpodr.on('initCreate', function() {
            editor_tab5_chfsubpodr.field('dognet_docchfsubpodr.koddocsubpodr').enable();
        });
        editor_tab5_chfsubpodr.on('initCreate initEdit', function() {
            editor_tab5_chfsubpodr.field('dognet_docchfsubpodr.sumzadolchfsubpodr').disable();
        });
        editor_tab5_oplchfsubpodr.on('submitSuccess', function() {
            table_tab5_chfsubpodr.ajax.reload();
            table_tab5_subpodr.ajax.reload();
        });
        editor_tab5_avchfsubpodr.on('submitSuccess', function() {
            table_tab5_chfsubpodr.ajax.url(
                "php/examples/simple/docview/docview-edit/restr_4/tabs/process/dognet-docview-edit(restr_4)-tab5_subpodr_child_chetfact-process.php"
            ).load();
            table_tab5_subpodr.ajax.url(
                "php/examples/simple/docview/docview-edit/restr_4/tabs/process/dognet-docview-edit(restr_4)-tab5_subpodr-process.php"
            ).load();
            table_tab5_subpodr.ajax.reload();
        });
        // 
        // ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
        // ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
        // ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
        // 
        table_tab5_avchfsubpodr.on('select', function(e, data, type, index) {
            var selected = table_tab5_avchfsubpodr.row({
                selected: true
            });
            var useavans = selected.data().dognet_docavsubpodr.useavans;
            if (useavans == "1") {
                table_tab5_avsplitsubpodr.buttons().enable();
            } else {
                table_tab5_avsplitsubpodr.buttons().disable();
            }
            table_tab5_avsplitsubpodr.ajax.reload();
        });
        // ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
        table_tab5_avchfsubpodr.on('deselect', function() {
            table_tab5_avsplitsubpodr.buttons().disable();
            table_tab5_avsplitsubpodr.ajax.reload();
        });
        // ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
        editor_tab5_avchfsubpodr.on('preSubmit', function(e, data, action) {
            var useavans = editor_tab5_avchfsubpodr.field('dognet_docavsubpodr.useavans').val();
            var kodchf = editor_tab5_avchfsubpodr.field('dognet_docavsubpodr.kodchfsubpodr').val();
            if (useavans == "2" && kodchf == "") {
                console.log('useavans', useavans, 'kodchf', kodchf);
                e.preventDefault();
                editor_tab5_avchfsubpodr.field('dognet_docavsubpodr.kodchfsubpodr').error(
                    'Для полного зачета выбрать счет надо обязательно');
                return false;
            };
        })
        // ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
        editor_tab5_avchfsubpodr.on('submitSuccess', function() {
            table_tab5_subpodr.ajax.reload();
            table_tab5_chfsubpodr.ajax.reload();
            table_tab5_avchfsubpodr.ajax.reload();
            table_tab5_avsplitsubpodr.ajax.reload();
        });
        // 
        // ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
        // ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
        // ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
        // 
        // ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
        editor_tab5_avsplitsubpodr.on('submitSuccess', function() {
            table_tab5_subpodr.ajax.reload();
            table_tab5_chfsubpodr.ajax.reload();
            table_tab5_avchfsubpodr.ajax.reload();
        });
        // 
        // ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
        // ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
        // ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
        // 
        table_tab5_avchfsubpodr.on('select', function(row) {
            $(row).css({
                'color': '#FFF'
            });
        });
        // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
        // Изменяем размер диалогового окна редактирования договора субподряда
        editor_tab5_subpodr.on('open', function() {
            $(".modal-dialog").css({
                "width": "60%",
                "min-width": "640px",
                "max-width": "800px"
            });
        });
        editor_tab5_subpodr.on('close', function() {
            $(".modal-dialog").css("width", "80%");
        });
        // Изменяем размер диалогового окна редактирования счета-фактуры
        editor_tab5_chfsubpodr.on('open', function() {
            $(".modal-dialog").css({
                "width": "60%",
                "min-width": "640px",
                "max-width": "800px"
            });
        });
        editor_tab5_chfsubpodr.on('close', function() {
            $(".modal-dialog").css("width", "80%");
        });
        // Изменяем размер диалогового окна редактирования оплаты счета
        editor_tab5_oplchfsubpodr.on('open', function() {
            $(".modal-dialog").css({
                "width": "60%",
                "min-width": "640px",
                "max-width": "800px"
            });
        });
        editor_tab5_oplchfsubpodr.on('close', function() {
            $(".modal-dialog").css("width", "80%");
        });
        // Изменяем размер диалогового окна редактирования аванса
        editor_tab5_avchfsubpodr.on('open', function() {
            $(".modal-dialog").css({
                "width": "60%",
                "min-width": "640px",
                "max-width": "800px"
            });
        });
        editor_tab5_avchfsubpodr.on('close', function() {
            $(".modal-dialog").css("width", "80%");
        });
        // Изменяем размер диалогового окна редактирования аванса
        editor_tab5_avsplitsubpodr.on('open', function() {
            $(".modal-dialog").css({
                "width": "60%",
                "min-width": "640px",
                "max-width": "800px"
            });
        });
        editor_tab5_avsplitsubpodr.on('close', function() {
            $(".modal-dialog").css("width", "80%");
        });
        // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----




        $('#docview-edit-tab5_avchfsubpodr tbody').on('click', 'tr', function() {
            var rowData = table_tab5_chfsubpodr.row(this).data();
            console.log('tbody click count()', table_tab5_avsplitsubpodr.rows().count());
            // ... do something with `rowData`

        });




        // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
        //
        //
        //
        // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
        // Array to track the ids of the edit displayed rows
        var detailRows_tab5_subpodr = [];

        $('#docview-edit-tab5_subpodr tbody').on('click', 'tr td.details-control', function() {
            var tr = $(this).closest('tr');
            var row = table_tab5_subpodr.row(tr);
            var idx = $.inArray(tr.attr('id'), detailRows_tab5_subpodr);

            if (row.child.isShown()) {
                tr.removeClass('edit');
                row.child.hide();

                // Remove from the 'open' array
                detailRows_tab5_subpodr.splice(idx, 1);
            } else {
                tr.addClass('edit');
                rowData = table_tab5_subpodr.row(row);
                d = row.data();
                rowData.child(<?php include('templates/docview-edit_tab5_subpodr.tpl'); ?>).show();

                // Add to the 'open' array
                if (idx === -1) {
                    detailRows_tab5_subpodr.push(tr.attr('id'));
                }
            }
        });
        // On each draw, loop over the `detailRows_tab5_subpodr` array and show any child rows
        table_tab5_subpodr.on('draw', function() {
            $.each(detailRows_tab5_subpodr, function(i, id) {
                $('#' + id + ' td.details-control').trigger('click');
            });
        });
        // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
        //
        //
        //
        // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
        // Выводим уведомление (цифру) о количестве договоров субподряда
        table_tab5_subpodr.on('draw', function() {
            sub_stg = table_tab5_subpodr.data().count();
            if (sub_stg > 0) {
                document.getElementById("sub_newitems_cnt").innerHTML = sub_stg;
            }
        });
    });
</script>
<?php
// ----- ----- ----- ----- -----
// Подключаем формы и выводим таблицы
// :::
include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/docview/docview-edit/restr_4/tabs/forms/docview-edit_tab5_subpodr-customForm.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/docview/docview-edit/restr_4/tabs/forms/docview-edit_tab5_subpodr_chetfact-customForm.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/docview/docview-edit/restr_4/tabs/forms/docview-edit_tab5_subpodr_oplatachf-customForm.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/docview/docview-edit/restr_4/tabs/forms/docview-edit_tab5_subpodr_chfavans-customForm.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/docview/docview-edit/restr_4/tabs/forms/docview-edit_tab5_subpodr_chfavanssplit-customForm.php");
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-edit/restr_4/tabs/css/docview-edit-tab5_subpodr.css">
<section>
    <div class="" style="padding-left:5px; padding-right:5px">
        <div class="space30"></div>
        <h3 class="parent-title space20">Договора субподряда</h3>
        <div class="demo-html"></div>
        <table id="docview-edit-tab5_subpodr" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th><span class='glyphicon glyphicon-option-vertical'></span></th>
                    <th></th>
                    <th>ID договора</th>
                    <th>№ договора</th>
                    <th>Дата</th>
                    <th>Организация</th>
                    <th>Сумма</th>
                    <th>Задолженность</th>
                </tr>
            </thead>
        </table>
        <?php // ----- ----- ----- ----- ----- 
        ?>
        <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-edit/restr_4/tabs/css/docview-edit-tab5_subpodr_chetfact.css">
        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
            <div class="space30"></div>
            <h3 class="child-title space20">Счета-фактуры субподрядчика</h3>
            <div class="demo-html"></div>
            <table id="docview-edit-tab5_chfsubpodr" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th></th>
                        <th>ID счета</th>
                        <th>Дата</th>
                        <th>№ СФ</th>
                        <th>Сумма</th>
                        <th>Задолж</th>
                    </tr>
                </thead>
            </table>
        </div>
        <?php // ----- ----- ----- ----- ----- 
        ?>
        <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-edit/restr_4/tabs/css/docview-edit-tab5_subpodr_oplatachf.css">
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
            <div class="space30"></div>
            <h3 class="child-title space20">Оплаты по счету-фактуре</h3>
            <div class="demo-html"></div>
            <table id="docview-edit-tab5_oplchfsubpodr" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>С-ф</th>
                        <th>Дата</th>
                        <th>Сумма</th>
                    </tr>
                </thead>
            </table>
        </div>
        <?php // ----- ----- ----- ----- ----- 
        ?>
        <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-edit/restr_4/tabs/css/docview-edit-tab5_subpodr_chfavans.css">
        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
            <div class="space30"></div>
            <h3 class="child-title space20">Авансовые платежи по договору</h3>
            <!-- 			<h3 class="child-title space20"><span id="safasfaslaksjdlkasjd"></span></h3> -->
            <div class="demo-html"></div>
            <table id="docview-edit-tab5_avchfsubpodr" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>С-ф</th>
                        <th>Тип</th>
                        <th>Дата</th>
                        <th>Аванс</th>
                        <th>Зачтено</th>
                        <th>Не зачтено</th>
                        <th>В сплите (доступно для сплита)</th>
                    </tr>
                </thead>
            </table>
        </div>
        <?php // ----- ----- ----- ----- ----- 
        ?>
        <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-edit/restr_4/tabs/css/docview-edit-tab5_subpodr_chfavanssplit.css">
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
            <div class="space30"></div>
            <h3 class="child-title space20">Сплит аванса</h3>
            <!-- 			<h3 class="child-title space20"><span id="safasfaslaksjdlkasjd"></span></h3> -->
            <div class="demo-html"></div>
            <table id="docview-edit-tab5_avsplitsubpodr" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>С-ф</th>
                        <th>Дата</th>
                        <th>Сумма</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</section>
<div id="subpodr-block-legend" class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:25px; border-top:1px solid #00a6dc; padding:20px">

    <div style="float: left">
        <p><span class="label label-icon"><span class="lbl lbl-light">Без зачета</span></span><span style="font-size:0.8em; font-family: 'HelliosCond', sans-serif; font-weight: 400; color:#8d8d8d">Аванс
                создан,
                но не определена форма его зачета</span></p>
    </div>
    <div style="float: left">
        <p><span class="label label-icon"><span class="lbl lbl-red-o">Сплит</span></span><span style="font-size:0.8em; font-family: 'HelliosCond', sans-serif; font-weight: 400; color:#8d8d8d">Тип
                аванса подразумевает разбитие (сплиты), но они пока не создавались</span></p>
    </div>
    <div style="float: left">
        <p><span class="label label-icon"><span class="lbl lbl-red">Сплит</span></span><span style="font-size:0.8em; font-family: 'HelliosCond', sans-serif; font-weight: 400; color:#8d8d8d">Из
                аванса
                выделены части (сплиты)</span></p>
    </div>
    <div style="float: left">
        <p><span class="label label-icon"><span class="lbl lbl-green">Зачет</span></span><span style="font-size:0.8em; font-family: 'HelliosCond', sans-serif; font-weight: 400; color:#8d8d8d">Аванс
                зачтен
                полностью</span></p>
    </div>
    <div style="float: left">
        <p><span class="label label-icon"><span style="color:#0085c7" class="glyphicon glyphicon-link"></span></span><span style="font-size:0.8em; font-family: 'HelliosCond', sans-serif; font-weight: 400; color:#8d8d8d">Оплата,
                аванс
                целиком
                или часть аванаса (сплит) зачтены в счет-фактуру, который выбран в соответствующей таблице</span></p>
    </div>

</div>