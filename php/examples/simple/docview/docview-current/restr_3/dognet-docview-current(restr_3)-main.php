<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/moment-with-locales.js"></script>
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/filterByText.js">
</script>

<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-current/restr_3/css/docview-current-common-tables.css">
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-current/restr_3/css/docview-current-common-customForm.css">

<script type="text/javascript" language="javascript" class="init">
    function addZero(digits_length, source) {
        var text = source + '';
        while (text.length < digits_length)
            text = '0' + text;
        return text;
    }

    var table_doc_main;
    var editor_doc_main;

    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

    $(document).ready(function() {
        //
        editor_doc_main = new $.fn.dataTable.Editor({
            display: "bootstrap",
            ajax: "php/examples/php/docview/docview-current/dognet-docview-doc-main-process.php",
            table: "#docview-doc-main",
            i18n: {
                create: {
                    title: "<h3>Создать новый договор</h3>"
                },
                edit: {
                    title: "<h3>Редактировать договор</h3>"
                },
                remove: {
                    title: "<h3>Удалить договор</h3>",
                    confirm: {
                        "_": "Вы уверены, что хотите удалить %d записи(ей)?",
                        "1": "Вы уверены, что хотите удалить этот договор?"
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
            template: '#customForm-doc-main',
            fields: [{
                label: "Номер :",
                name: "dognet_docbase.docnumber"
            }, {
                label: "Шаблон :",
                name: "dognet_docbase.kodshab",
                type: "select",
                options: [{
                        label: "С календарным планом",
                        value: "1"
                    },
                    {
                        label: "Без календарного плана",
                        value: "2"
                    }
                ],
                def: "---",
                placeholder: "Выберите шаблон"
            }, {
                label: "",
                type: "checkbox",
                name: "dognet_docbase.usedoczayv",
                options: [{
                    label: "",
                    value: 1
                }],
                separator: "",
                unselectedValue: 0
            }, {
                label: "",
                type: "checkbox",
                name: "dognet_docbase.usedocruk",
                options: [{
                    label: "",
                    value: 1
                }],
                separator: "",
                unselectedValue: 0
            }, {
                label: "Краткое наименование :",
                name: "dognet_docbase.docnameshot",
                type: "textarea"
            }, {
                label: "Полное наименование :",
                name: "dognet_docbase.docnamefullm",
                type: "textarea"
            }, {
                label: "Бланк :",
                name: "dognet_docbase.kodblankwork",
                type: "select",
                placeholder: "Выберите бланк"
            }, {
                // ----- -----
                label: "Начало договора (число) :",
                name: "dognet_docbase.daynachdoc",
                type: "hidden"
            }, {
                label: "Начало договора (месяц) :",
                name: "dognet_docbase.monthnachdoc",
                type: "hidden"
            }, {
                label: "Начало договора (год) :",
                name: "dognet_docbase.yearnachdoc",
                type: "hidden"
            }, {
                label: "Окончание договора (число) :",
                name: "dognet_docbase.dayenddoc",
                type: "hidden"
            }, {
                label: "Окончание договора (месяц) :",
                name: "dognet_docbase.monthenddoc",
                type: "hidden"
            }, {
                label: "Окончание договора (год) :",
                name: "dognet_docbase.yearenddoc",
                type: "hidden"
            }, {
                label: "Начало :",
                name: "docDateBegin",
                type: "datetime",
                def: function() {
                    return new Date();
                },
                format: "DD.MM.YYYY",
                attr: {
                    readonly: "readonly"
                }
            }, {
                label: "Окончание :",
                name: "docDateEnd",
                type: "datetime",
                def: function() {
                    return new Date();
                },
                format: "DD.MM.YYYY",
                attr: {
                    readonly: "readonly"
                }
            }, {
                // ----- -----
                label: "Тип :",
                name: "dognet_docbase.kodtip",
                type: "select",
                def: "---",
                placeholder: "Выберите тип"
            }, {
                label: "Объект :",
                name: "dognet_docbase.kodobject",
                type: "select",
                def: "---",
                placeholder: "Выберите объект"
            }, {
                label: "Заказчик :",
                name: "dognet_docbase.kodzakaz",
                type: "select",
                def: "---",
                placeholder: "Выберите заказчика"
            }, {
                label: "Статус :",
                name: "dognet_docbase.kodstatus",
                type: "select",
                def: "---",
                placeholder: "Выберите статус"
            }, {
                label: "Исполнтель :",
                name: "dognet_docbase.kodispol",
                type: "select",
                def: "---",
                placeholder: "Выберите исполнителя"
            }, {
                label: "Руководитель :",
                name: "dognet_docbase.kodispolruk",
                type: "select",
                def: "---",
                placeholder: "Выберите руководителя"
            }, {
                label: "Сумма :",
                name: "dognet_docbase.docsumma",
                def: "0.00"
            }, {
                // ----- -----
                label: "Ден. единица :",
                name: "dognet_docbase.koddened",
                type: "select",
                def: "245296558950375",
                placeholder: "Выберите валюту"
            }, {
                label: "НДС",
                type: "checkbox",
                name: "dognet_docbase.usendssumma",
                options: [{
                    label: "",
                    value: 1
                }],
                separator: "",
                def: 1,
                unselectedValue: 0
                // ----- -----
            }, {
                label: "Расчет командировок :",
                name: "dognet_docbase.usemisopl",
                type: "select",
                options: [{
                        label: "Не определено",
                        value: "0"
                    },
                    {
                        label: "С оплатой по лимиту",
                        value: "1"
                    },
                    {
                        label: "Сверх стоимости",
                        value: "2"
                    }
                ],
                placeholder: "Выберите вариант"
            }, {
                label: "Лимит :",
                name: "dognet_docbase.docsummamis",
                def: "0.00"
                // ----- -----
            }, {
                label: "Статус задолженности :",
                name: "dognet_docbase.kodstatuszdl",
                type: "select",
                options: [{
                        label: "Без задолженности",
                        value: "0"
                    },
                    {
                        label: "Текущая",
                        value: "1"
                    },
                    {
                        label: "Судебная",
                        value: "2"
                    },
                    {
                        label: "Невозвратная",
                        value: "2"
                    }
                ],
                def: 0,
                placeholder: "Выберите вариант"
            }, {
                label: "Комментарии к договору :",
                name: "dognet_docbase.comments",
                type: "textarea"
            }, {
                label: "",
                type: "checkbox",
                name: "dognet_docbase.usecreatekcp",
                options: [{
                    label: "",
                    value: 1
                }],
                separator: "",
                unselectedValue: 0
            }]
        });
        //
        // ----- ----- ----- ----- -----
        // Изменяем размер диалогового окна редактирования
        editor_doc_main.on('open', function() {
            $(".modal-dialog").css({
                "width": "95%",
                "margin": "1.0em auto",
                "min-width": "800px",
                "max-width": "1170px"
            });
        });
        //
        // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
        //
        //
        editor_doc_main
            .on('open', function() {
                $('#kodzakaz_filter').val('');
                if (($('#DTE_Field_dognet_docbase-kodzakaz').value) != editor_doc_main.field(
                        'dognet_docbase.kodzakaz').get()) {}
                // Поиск в ниспадающем списке по содержимому текстового поля для ответного документа
                $('#DTE_Field_dognet_docbase-kodzakaz').filterByText(editor_doc_main, $('#kodzakaz_filter'),
                    'dognet_docbase.kodzakaz', false);

                $('#kodobject_filter').val('');
                if (($('#DTE_Field_dognet_docbase-kodobject').value) != editor_doc_main.field(
                        'dognet_docbase.kodobject').get()) {}
                // Поиск в ниспадающем списке по содержимому текстового поля для ответного документа
                $('#DTE_Field_dognet_docbase-kodobject').filterByText(editor_doc_main, $('#kodobject_filter'),
                    'dognet_docbase.kodobject', false);

                $('#kodblankwork_filter').val('');
                if (($('#DTE_Field_dognet_docbase-kodblankwork').value) != editor_doc_main.field(
                        'dognet_docbase.kodblankwork').get()) {}
                // Поиск в ниспадающем списке по содержимому текстового поля для ответного документа
                $('#DTE_Field_dognet_docbase-kodblankwork').filterByText(editor_doc_main, $(
                    '#kodblankwork_filter'), 'dognet_docbase.kodblankwork', false);

                // Store the values of the fields on open
                openVals = JSON.stringify(editor_doc_main.get());

                editor_doc_main.on('preClose', function(e) {
                    // On close, check if the values have changed and ask for closing confirmation if they have
                    if (openVals !== JSON.stringify(editor_doc_main.get())) {
                        return confirm('Вы не сохранили данные формы. Уверены, что хотите ее закрыть?');
                    }
                })
                // ----- ----- ----- ----- -----
                editor_doc_main.on('preSubmit', function(e) {
                    if (editor_doc_main.field('dognet_docbase.kodtip').val() == '' || editor_doc_main
                        .field('dognet_docbase.kodstatus').val() == '') {
                        document.getElementById("doc-editor-menu-tab-1-errmsg").innerHTML =
                            '<span class="glyphicon glyphicon-exclamation-sign"></span>';
                        $("#doc-editor-menu-tab-1-errmsg").attr("class", "text-danger errmsg");
                    }
                    if (editor_doc_main.field('dognet_docbase.docnumber').val() == '' || editor_doc_main
                        .field('dognet_docbase.docnameshot').val() == '') {
                        document.getElementById("doc-editor-menu-tab-2-errmsg").innerHTML =
                            '<span class="glyphicon glyphicon-exclamation-sign"></span>';
                        $("#doc-editor-menu-tab-2-errmsg").attr("class", "text-danger errmsg");
                    }
                    // return false; // prevent the submission
                })
            })
            .on('postCreate postEdit close', function() {
                editor_doc_main.off('preClose');
                document.getElementById("doc-editor-menu-tab-1-errmsg").innerHTML = '';
                document.getElementById("doc-editor-menu-tab-2-errmsg").innerHTML = '';
                document.getElementById("doc-editor-menu-tab-3-errmsg").innerHTML = '';
                document.getElementById("doc-editor-menu-tab-4-errmsg").innerHTML = '';
            });
        //
        //
        editor_doc_main.on('preOpen', function() {
            var daynachdoc = addZero(2, editor_doc_main.field('dognet_docbase.daynachdoc').val());
            var monthnachdoc = addZero(2, editor_doc_main.field('dognet_docbase.monthnachdoc').val());
            var yearnachdoc = addZero(2, editor_doc_main.field('dognet_docbase.yearnachdoc').val());
            editor_doc_main.field('docDateBegin').set(daynachdoc + "." + monthnachdoc + "." + yearnachdoc);

            var dayenddoc = addZero(2, editor_doc_main.field('dognet_docbase.dayenddoc').val());
            var monthenddoc = addZero(2, editor_doc_main.field('dognet_docbase.monthenddoc').val());
            var yearenddoc = addZero(2, editor_doc_main.field('dognet_docbase.yearenddoc').val());
            editor_doc_main.field('docDateEnd').set(dayenddoc + "." + monthenddoc + "." + yearenddoc);

        });
        //
        //
        editor_doc_main.on('initSubmit', function() {
            var a = editor_doc_main.field('docDateBegin').val().split('.');
            editor_doc_main.field('dognet_docbase.daynachdoc').set(a[0]);
            editor_doc_main.field('dognet_docbase.monthnachdoc').set(a[1]);
            editor_doc_main.field('dognet_docbase.yearnachdoc').set(a[2]);
            var b = editor_doc_main.field('docDateEnd').val().split('.');
            editor_doc_main.field('dognet_docbase.dayenddoc').set(b[0]);
            editor_doc_main.field('dognet_docbase.monthenddoc').set(b[1]);
            editor_doc_main.field('dognet_docbase.yearenddoc').set(b[2]);
        });
        //
        //
        //
        //
        //
        editor_doc_main.on('open', function(e, mode, action) {
            if (action == 'create') {
                console.log("create : kodblankwork=" + editor_doc_main.field('dognet_docbase.kodblankwork')
                    .val());
                editor_doc_main.val('dognet_docbase.kodblankwork', null);
                editor_doc_main.field('dognet_docbase.kodshab').enable();
                editor_doc_main.field('dognet_docbase.usedocruk').enable();
                editor_doc_main.field('dognet_docbase.usedoczayv').enable();
                editor_doc_main.dependent('dognet_docbase.usedoczayv', function(val) {
                    if (val == 1) {
                        console.log("create : usedoczayv=" + editor_doc_main.field(
                            'dognet_docbase.usedoczayv').val());
                        editor_doc_main.field('dognet_docbase.kodblankwork').enable();
                        editor_doc_main.field('dognet_docbase.kodblankwork').show(false);
                        editor_doc_main.field('dognet_docbase.kodblankwork').focus();
                        editor_doc_main.field('dognet_docbase.usedocruk').disable();
                        $('#kodblankwork_filter').prop("disabled", false);
                        $('#kodblankwork_filter').prop("placeholder", "Поиск в Бланках");
                        $('#kodblankwork_filter').css("display", "block");
                    } else {
                        console.log("create : usedoczayv=" + editor_doc_main.field(
                            'dognet_docbase.usedoczayv').val());
                        editor_doc_main.field('dognet_docbase.kodblankwork').hide(false);
                        editor_doc_main.val('dognet_docbase.kodblankwork', null);
                        editor_doc_main.field('dognet_docbase.usedocruk').enable();
                        $('#kodblankwork_filter').css("display", "none");
                    }
                });
                editor_doc_main.dependent('dognet_docbase.usedocruk', function(val) {
                    if (val == 1) {
                        console.log("create : usedocruk=" + editor_doc_main.field(
                            'dognet_docbase.usedocruk').val());
                        editor_doc_main.field('dognet_docbase.usedoczayv').disable();
                    } else {
                        console.log("create : usedocruk=" + editor_doc_main.field(
                            'dognet_docbase.usedocruk').val());
                        editor_doc_main.field('dognet_docbase.usedoczayv').enable();
                    }
                });
            }
            if (action == 'edit') {
                console.log("edit : kodblankwork=" + editor_doc_main.field('dognet_docbase.kodblankwork')
                    .val());
                $('#kodblankwork_filter').css("display", "none");
                editor_doc_main.field('dognet_docbase.kodshab').disable();
                editor_doc_main.field('dognet_docbase.usedocruk').disable();
                editor_doc_main.field('dognet_docbase.usedoczayv').disable();
                editor_doc_main.dependent('dognet_docbase.usedoczayv', function(val) {
                    if (val == 1) {
                        editor_doc_main.field('dognet_docbase.kodblankwork').show(false);
                        editor_doc_main.field('dognet_docbase.kodblankwork').disable();
                        editor_doc_main.field('dognet_docbase.usedocruk').disable();
                        editor_doc_main.field('dognet_docbase.usedoczayv').disable();
                    } else {
                        editor_doc_main.field('dognet_docbase.kodblankwork').hide(false);
                    }
                });

            }
        });
        editor_doc_main.on('close', function(e, mode, action) {
            console.log("close");
            editor_doc_main.undependent('dognet_docbase.usedoczayv');
            editor_doc_main.undependent('dognet_docbase.usedocruk');
            editor_doc_main.undependent('dognet_docbase.kodblankwork');
        });
        //
        //
        //
        //
        //
        //
        // ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
        //
        //
        table_doc_main = $('#docview-doc-main').DataTable({
            dom: "<'row'<'col-sm-5'B><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'l>>" +
                "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'p>>",
            // 		dom: "<'space50'r>tip",
            language: {
                url: "russian.json"
            },
            ajax: {
                url: "php/examples/php/docview/docview-current/dognet-docview-doc-main-process.php",
                type: "POST"
            },
            serverSide: true,
            createdRow: function(row, data, index) {
                // if ( data.dognet_docbase.usecreatekcp != 0 ) { $(row).css('background-color','rgb(255 242 204)'); }
                if (data.dognet_docbase.usecreatekcp != 0) {
                    $(row).addClass('highlight-usecreatekcp');
                }
            },
            columns: [{
                    class: "details-control",
                    searchable: false,
                    orderable: false,
                    data: null,
                    defaultContent: "<span class='glyphicon glyphicon-option-vertical'></span>"
                },
                {
                    data: "dognet_docbase.docnumber",
                    className: "text-center"
                },
                {
                    data: "dognet_docbase.docpartnernumberSTR",
                    className: "text-center"
                },
                {
                    data: "dognet_docbase.yearnachdoc",
                    className: "text-center"
                },
                {
                    data: "sp_contragents.nameshort"
                },
                {
                    data: "dognet_docbase.docnameshot",
                    className: "text-left"
                },
                {
                    data: "dognet_spstatus.statusnameshot",
                    className: "text-left"
                },
                {
                    data: "sp_objects.nameobjectshot"
                },
                {
                    data: "dognet_sptipdog.nametip"
                },
                {
                    data: "dognet_spispol.ispolnamefull"
                },
                {
                    data: "dognet_docbase.kodshab"
                },
                {
                    data: "dognet_docbase.docsumma"
                },
                {
                    data: null,
                    defaultContent: '<a href="#" class="edit_listalt"><span class="glyphicon glyphicon-list-alt"></span></a>'
                },
                {
                    data: "dognet_docbase.usecreatekcp"
                }
            ],
            select: 'single',
            columnDefs: [{
                    orderable: false,
                    searchable: false,
                    targets: 0
                },
                {
                    orderable: true,
                    searchable: true,
                    targets: 1
                },
                {
                    orderable: false,
                    searchable: true,
                    targets: 2
                },
                {
                    orderable: false,
                    searchable: true,
                    targets: 3
                },
                {
                    orderable: false,
                    searchable: true,
                    targets: 4
                },
                {
                    orderable: false,
                    searchable: true,
                    targets: 5
                },
                {
                    orderable: false,
                    searchable: true,
                    targets: 6
                },
                {
                    orderable: false,
                    visible: false,
                    searchable: true,
                    targets: 7
                },
                {
                    orderable: false,
                    visible: false,
                    searchable: true,
                    targets: 8
                },
                {
                    orderable: false,
                    visible: false,
                    searchable: true,
                    targets: 9
                },
                {
                    orderable: false,
                    visible: false,
                    searchable: true,
                    targets: 10
                },
                {
                    orderable: true,
                    searchable: false,
                    render: function(data, type, row, meta) {
                        if (data != null) {
                            return $.fn.dataTable.render.number(' ', ',', 2, '').display(data) + row
                                .dognet_spdened.short_code;
                        } else {
                            return "0.00" + row.dognet_spdened.short_code;
                        }
                    },
                    targets: 11
                },
                {
                    orderable: false,
                    searchable: false,
                    targets: 12,
                    render: function(data, type, row, meta) {
                        return '<span style="padding:0 5px"><a href="dognet-docview.php?docview_type=details&uniqueID=' +
                            row.dognet_docbase.koddoc +
                            '"><span class="glyphicon glyphicon-list-alt"></span></a></span>';
                    }
                },
                {
                    orderable: false,
                    visible: false,
                    searchable: true,
                    targets: 13
                },
            ],
            order: [
                [1, "desc"]
            ],
            processing: true,
            paging: true,
            searching: true,
            pageLength: 15,
            lengthChange: false,
            lengthMenu: [
                [15, 30, 50, -1],
                [15, 30, 50, "Все"]
            ],
            buttons: [{
                text: '<span class="glyphicon glyphicon-refresh"></span>',
                action: function(e, dt, node, config) {
                    $('#docNumberSearch_text').val('');
                    $('#docYearSearch_text').val('');
                    $('#docStatusSearch_text').val('');
                    $('#docNameSearch_text').val('');
                    $('#docPartnerNumberSearch_text').val('');
                    $('#docObjectSearch_text').val('');
                    $('#docZakazSearch_text').val('');
                    $('#docTypeSearch_text').val('');
                    $('#docIspolSearch_text').val('');
                    $('#docShablonSearch_text').val('');
                    $('#docCreateKcpSearch_text').val('');
                    table_doc_main.columns().search('');
                    table_doc_main.order([1, "desc"]).draw();
                }
            }],
            drawCallback: function() {

            }
        });
        //
        // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
        // Array to track the ids of the details displayed rows
        //
        var detailRows = [];
        $('#docview-doc-main tbody').on('click', 'tr td.details-control', function() {
            var tr = $(this).closest('tr');
            var row = table_doc_main.row(tr);
            var idx = $.inArray(tr.attr('id'), detailRows);

            if (row.child.isShown()) {
                tr.removeClass('details');
                row.child.hide();

                // Remove from the 'open' array
                detailRows.splice(idx, 1);
            } else {
                tr.addClass('details');
                rowData = table_doc_main.row(row);
                if (row.data().dognet_docbase.usedocruk == '1') {
                    var osn = "По указанию руководства";
                    var blank = '';
                } else if (row.data().dognet_docbase.usedoczayv == '1') {
                    var osn = 'Заявка ГИПа';
                    if (row.data().dognet_docbase.kodblankwork !== null) {
                        /* 					var blank = ' / Бланк № '+row.data().dognet_docblankwork.numberblankwork+' / '+row.data().dognet_docblankwork.nameblankwork; */
                        var blank = ' / (!) Номер бланка пока не выводится';
                    } else {
                        var blank = ' / Бланк не привязан';
                    }
                } else {
                    var osn = "Не определено";
                    var blank = '';
                }
                d = row.data();
                rowData.child(<?php include('templates/docview-current-details.tpl'); ?>).show();

                // Add to the 'open' array
                if (idx === -1) {
                    detailRows.push(tr.attr('id'));
                }
            }
        });
        //
        // On each draw, loop over the `detailRows` array and show any child rows
        table_doc_main.on('draw', function() {
            $.each(detailRows, function(i, id) {
                $('#' + id + ' td.details-control').trigger('click');
            });
        });
        //
        //
        // ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
        //
        //
        $('#globalSearch_button').click(function(e) {
            table_doc_main.search($("#globalSearch_text").val()).draw();
        });
        $('#clearSearch_button').click(function(e) {
            table_doc_main.search('').draw();
            $('#globalSearch_text').val('');
        });

        $('#columnSearch_btnApply').click(function(e) {
            table_doc_main
                .columns(1)
                .search($("#docNumberSearch_text").val())
                .draw();

            table_doc_main
                .columns(2)
                .search($("#docPartnerNumberSearch_text").val())
                .draw();

            table_doc_main
                .columns(3)
                .search($("#docYearSearch_text").val())
                .draw();

            table_doc_main
                .columns(5)
                .search($("#docNameSearch_text").val())
                .draw();

            table_doc_main
                .columns(6)
                .search($("#docStatusSearch_text").val())
                .draw();

            table_doc_main
                .columns(7)
                .search($("#docObjectSearch_text").val())
                .draw();

            table_doc_main
                .columns(4)
                .search($("#docZakazSearch_text").val())
                .draw();

            table_doc_main
                .columns(8)
                .search($("#docTypeSearch_text").val())
                .draw();

            table_doc_main
                .columns(9)
                .search($("#docIspolSearch_text").val())
                .draw();

            table_doc_main
                .columns(10)
                .search($("#docShablonSearch_text").val())
                .draw();

            table_doc_main
                .columns(13)
                .search($("#docCreateKcpSearch_text").val())
                .draw();
        });

        $('#columnSearch_btnClear').click(function(e) {
            $('#docNumberSearch_text').val('');
            $('#docYearSearch_text').val('');
            $('#docStatusSearch_text').val('');
            $('#docNameSearch_text').val('');
            $('#docPartnerNumberSearch_text').val('');
            $('#docObjectSearch_text').val('');
            $('#docZakazSearch_text').val('');
            $('#docTypeSearch_text').val('');
            $('#docIspolSearch_text').val('');
            $('#docShablonSearch_text').val('');
            $('#docCreateKcpSearch_text').val('');
            table_doc_main
                .columns()
                .search('')
                .draw();
        });

        // ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

        $("#docNumberSearch_text").on("keyup", function(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                document.getElementById("columnSearch_btnApply").click();
            }
        });
        $("#docPartnerNumberSearch_text").on("keyup", function(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                document.getElementById("columnSearch_btnApply").click();
            }
        });
        $("#docYearSearch_text").on("keyup", function(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                document.getElementById("columnSearch_btnApply").click();
            }
        });
        $("#docNameSearch_text").on("keyup", function(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                document.getElementById("columnSearch_btnApply").click();
            }
        });
        $("#docObjectSearch_text").on("keyup", function(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                document.getElementById("columnSearch_btnApply").click();
            }
        });
        $("#docZakazSearch_text").on("keyup", function(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                document.getElementById("columnSearch_btnApply").click();
            }
        });


    });
</script>
<?php
// ----- ----- ----- ----- -----
// Подключаем форму редактирования, форму поиска и выводим таблицу договора
// :::
include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/docview/docview-current/restr_3/forms/docview-current-customForm.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/docview/docview-current/restr_3/forms/docview-current-filters.php");
// ----- ----- ----- ----- -----
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-current/restr_3/css/docview-current-main.css">
<style>
    table#docview-doc-main>tbody>tr.highlight-usecreatekcp {
        background-color: rgb(255 242 204)
    }

    table#docview-doc-main>tbody>tr.even.selected td,
    table#docview-doc-main>tbody>tr.odd.selected td,
    table#docview-doc-main>tbody>tr.even.selected td a,
    table#docview-doc-main>tbody>tr.odd.selected td a {
        color: #FFFFFF;
        background-color: #0085c8;
    }

    table#docview-doc-main>tbody>tr.highlight-usecreatekcp.even.selected td,
    table#docview-doc-main>tbody>tr.highlight-usecreatekcp.odd.selected td,
    table#docview-doc-main>tbody>tr.highlight-usecreatekcp.even.selected td a,
    table#docview-doc-main>tbody>tr.highlight-usecreatekcp.odd.selected td a {
        color: #FFF2CC;
        background-color: #0085c8;
    }
</style>
<section>
    <div class="demo-html"></div>
    <table id="docview-doc-main" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
                <th width="6%" class="text-center">N<sub>атгс</sub></th>
                <th width="8%" class="text-center">N<sub>контр</sub></th>
                <th width="7%" class="text-center">Год</th>
                <th width="14%" class="text-left">Заказчик</th>
                <th class="text-left">Краткое название</th>
                <th width="9%" class="text-left">Статус</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th width="12%">Сумма</th>
                <th width="1%"></th>
                <th></th>
            </tr>
        </thead>
    </table>

</section>