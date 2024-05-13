<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/filterByText.js">
</script>

<script type="text/javascript" language="javascript" class="init">
let firstavans_date = "";

function addZero(digits_length, source) {
    var text = source + '';
    while (text.length < digits_length)
        text = '0' + text;
    return text;
}
//
// ###### ## ##### ## ###### ## ##### ## ###### ## ##### ## ###### ## #####
// ###### ## ##### ## ###### ## ##### ## ###### ## ##### ## ###### ## #####
// ###### ## ##### ## ###### ## ##### ## ###### ## ##### ## ###### ## #####
//
function ajaxRequest_firstavansAsync(koddoc) {
    var result = false;
    $.ajax({
        async: false,
        cache: false,
        type: "post",
        url: "php/examples/simple/chetview/chetview-edit/restr_4/tabs/process/ajaxrequests/dognet-reqAjax-getFromDBAsync-firstavans.php",
        data: {
            koddoc: koddoc
        },
        success: function(response) {
            res = response.replace(new RegExp("\\r?\\n", "g"), "");
            if (response != '0' && response != '-1' && response != '-2' && response != 'error -3') {
                result = res;
            } else {
                result = '';
            }
            console.log('ajaxRequest_firstavansAsync', result);
        }
    });
    return result;
}
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
var reqField3 = {
    firstavans: function(response) {}
};

function ajaxRequest_firstavans(data, responseHandler) {
    var response = false;

    // Fire off the request to /form.php
    request = $.ajax({
        url: "php/examples/simple/chetview/chetview-edit/restr_4/tabs/process/ajaxrequests/dognet-reqAjax-getFromDB-firstavans.php",
        type: "post",
        cache: false,
        data: {
            koddoc: data
        },
        success: reqField3[responseHandler]
    });
    // Callback handler that will be called on success
    request.done(function(response, textStatus, jqXHR) {
        res = response.replace(new RegExp("\\r?\\n", "g"), "");
        console.log("Первый аванс : " + res);

        var x = res.split('/');
        var av1date = x[0];
        var av1summa = x[1];
        if (av1date != "" && av1summa != "") {
            $('#ajaxFirstAvansOut').html("1-ый аванс по счёту поступил " + moment(av1date, 'YYYY-MM-DD').format(
                'DD.MM.YYYY') + " на сумму " + av1summa + " р.");
            firstavans_date += moment(av1date, 'YYYY-MM-DD').format('DD.MM.YYYY');
        } else {
            $('#ajaxFirstAvansOut').html("Авансов по счёту пока не поступало");
            firstavans_date = "";
        }
        $('div.firstAvans').css({
            "display": "block"
        });
    });
    // Callback handler that will be called on failure
    request.fail(function(jqXHR, textStatus, errorThrown) {
        console.error(
            "The following error occurred: " +
            textStatus, errorThrown
        );
    });
    // Callback handler that will be called regardless
    // if the request failed or succeeded
    request.always(function() {

    });
}
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
var editor_tab1_chet; // use a global for the submit and return data rendering in the examples
var table_tab1_chet; // use a global for the submit and return data rendering in the examples

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

$(document).ready(function() {
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    editor_tab1_chet = new $.fn.dataTable.Editor({
        display: "bootstrap",
        ajax: "php/examples/php/chetview/chetview-edit/dognet-chetview-edit-tab1_chet-process.php",
        table: "#chetview-edit-tab1_chet",
        i18n: {
            create: {
                title: "<h3>Создать новый счет</h3>"
            },
            edit: {
                title: "<h3>Редактировать счет</h3>"
            },
            remove: {
                title: "<h3>Удалить счет</h3>",
                confirm: {
                    "_": "Вы уверены, что хотите удалить %d записи(ей)?",
                    "1": "Вы уверены, что хотите удалить этот счет?"
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
        template: '#customForm_tab1_chet',
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
            label: "Бланк требования",
            type: "checkbox",
            name: "dognet_docbase.usedoczayv",
            options: [{
                label: "",
                value: 1
            }],
            separator: "",
            unselectedValue: 0
        }, {
            label: "Указание руководства",
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
            // ----- -----
            label: "Начало счета (число) :",
            name: "dognet_docbase.daynachdoc",
            type: "hidden"
        }, {
            label: "Начало счета (месяц) :",
            name: "dognet_docbase.monthnachdoc",
            type: "hidden"
        }, {
            label: "Начало счета (год) :",
            name: "dognet_docbase.yearnachdoc",
            type: "hidden"
        }, {
            label: "Окончание счета (число) :",
            name: "dognet_docbase.dayenddoc",
            type: "hidden"
        }, {
            label: "Окончание счета (месяц) :",
            name: "dognet_docbase.monthenddoc",
            type: "hidden"
        }, {
            label: "Окончание счета (год) :",
            name: "dognet_docbase.yearenddoc",
            type: "hidden"
        }, {
            label: "Окончание договора (в днях) :",
            name: "dognet_docbase.srokindays",
            type: "hidden"
        }, {
            label: "Начало :",
            name: "docDateBegin",
            type: "datetime",
            def: function() {
                return new Date();
            },
            format: "DD.MM.YYYY"
        }, {
            label: "Окончание :",
            name: "docDateEnd",
            type: "datetime",
            def: function() {
                return new Date();
            },
            format: "DD.MM.YYYY"
        }, {
            label: "Окончание :",
            name: "docDateEndInDays"
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
            type: "hidden",
            def: "---",
            placeholder: "Выберите объект"
        }, {
            label: "Заказчик :",
            name: "dognet_docbase.kodzakaz",
            type: "hidden",
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
            name: "dognet_docbase.docsumma"
        }, {
            // ----- -----
            label: "Ден. единица :",
            name: "dognet_docbase.koddened",
            type: "select",
            def: "---",
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
            name: "dognet_docbase.docsummamis"
            // ----- -----
        }, {
            label: "Статус задолженности :",
            name: "dognet_docbase.kodstatuszdl",
            type: "select",
            options: [{
                    label: "Не определено",
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
            placeholder: "Выберите вариант"
        }]
    });
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    editor_tab1_chet
        .on('open', function(e, mode, action) {
            firstavans_dateAsync = "";
            koddoc = "";
            //
            if (action === "create") {
                ajaxRequest_firstavans(koddoc, 'firstavans');
                firstavans_dateAsync = ajaxRequest_firstavansAsync(koddoc);
                if (firstavans_dateAsync !== "") {
                    editor_tab1_chet.field('docDateEnd').enable();
                } else {
                    editor_tab1_chet.field('docDateEnd').disable();
                }
            }
            //
            if (action === "edit") {
                selected = table_tab1_chet.row({
                    selected: true
                });
                if (selected.any()) {
                    koddoc = selected.data().dognet_docbase.koddoc;
                    ajaxRequest_firstavans(koddoc, 'firstavans');
                    firstavans_dateAsync = ajaxRequest_firstavansAsync(koddoc);
                    console.log('firstavans_date', firstavans_date);
                } else {
                    koddoc = "";
                }
                if (firstavans_dateAsync !== "") {
                    editor_tab1_chet.field('docDateEnd').enable();
                } else {
                    editor_tab1_chet.field('docDateEnd').disable();
                    $("fieldset.docDateEndInDays").css({
                        "display": "block"
                    });
                    $("fieldset.docDateEnd").css({
                        "display": "none"
                    });
                }
            }
            //
            $('#chkDocDateEndInDays').prop('checked', true);
            $('#chkDocDateEndInDays').attr('checked', true);
            $('#DTE_Field_docDateEndInDays').attr("placeholder", "Кол. дней");
            $("fieldset.docDateEndInDays").css({
                "display": "block"
            });
            $("fieldset.docDateEnd").css({
                "display": "none"
            });
            //
            //
            //
            //
            // $('#kodzakaz_filter').val('');
            // if (($('#DTE_Field_dognet_docbase-kodzakaz').value) != editor_tab1_chet.field(
            //         'dognet_docbase.kodzakaz').get()) {}
            // Поиск в ниспадающем списке по содержимому текстового поля для ответного документа
            // $('#DTE_Field_dognet_docbase-kodzakaz').filterByText(editor_tab1_chet, $('#kodzakaz_filter'),
            //     'dognet_docbase.kodzakaz', false);

            // $('#kodobject_filter').val('');
            // if (($('#DTE_Field_dognet_docbase-kodobject').value) != editor_tab1_chet.field(
            //         'dognet_docbase.kodobject').get()) {}
            // Поиск в ниспадающем списке по содержимому текстового поля для ответного документа
            // $('#DTE_Field_dognet_docbase-kodobject').filterByText(editor_tab1_chet, $('#kodobject_filter'),
            //     'dognet_docbase.kodobject', false);

            $(".modal-dialog").css({
                "width": "60%",
                "min-width": "640px",
                "max-width": "800px"
            });
            //
            //
            $('#DTE_Field_docDateBegin').inputmask({
                mask: "99.99.9999"
            });
            $('#DTE_Field_docDateEnd').inputmask({
                mask: "99.99.9999"
            });
            //
            $('#chkDocDateEndInDays').on("click", function() {
                console.log("chkDocDateEndInDays clicked", $(this).prop("checked"));
                if ($(this).prop("checked")) {
                    $('#DTE_Field_docDateEndInDays').attr("placeholder", "Кол. дней");
                    $("fieldset.docDateEndInDays").css({
                        "display": "block"
                    });
                    $("fieldset.docDateEnd").css({
                        "display": "none"
                    });
                } else {
                    $('#DTE_Field_docDateEnd').attr("placeholder", "Дата");
                    $("fieldset.docDateEndInDays").css({
                        "display": "none"
                    });
                    $("fieldset.docDateEnd").css({
                        "display": "block"
                    });
                }
            });
            //
            //
            $('#DTE_Field_docDateEndInDays').on("keyup", function() {
                if (firstavans_dateAsync !== "") {
                    editor_tab1_chet.field('docDateEnd').enable();
                    dateAvans = moment(firstavans_dateAsync, 'YYYY-MM-DD');
                    dateEnd = dateAvans.add($(this).val(), 'days').format('DD.MM.YYYY');
                    console.log('dateEnd in DATE', dateEnd);
                    editor_tab1_chet.field('docDateEnd').val(dateEnd);
                } else {
                    editor_tab1_chet.field('docDateEnd').disable();
                    editor_tab1_chet.field('docDateEnd').val('');
                    editor_tab1_chet.field('dognet_docbase.dayenddoc').set(0);
                    editor_tab1_chet.field('dognet_docbase.monthenddoc').set(0);
                    editor_tab1_chet.field('dognet_docbase.yearenddoc').set(0);
                }
                editor_tab1_chet.field('dognet_docbase.srokindays').set($(this).val());
            });
            //
            //
            $('#DTE_Field_docDateEnd').on("change", function() {
                if (firstavans_dateAsync !== "" && !isNaN($(this).val())) {
                    dateAvans = moment(firstavans_dateAsync, 'YYYY-MM-DD');
                    dateEnd = moment($(this).val(), 'DD.MM.YYYY');
                    if (dateAvans.isValid() && dateEnd.isValid()) {
                        dateEndInDays = dateEnd.diff(dateAvans, 'days');
                        console.log('dateEnd in DATE', dateEnd, 'dateEnd in DAYS', dateEndInDays);
                        editor_tab1_chet.field('docDateEndInDays').val(
                            dateEndInDays);
                        editor_tab1_chet.field('dognet_docbase.srokindays').val(
                            dateEndInDays);
                    }
                } else {
                    editor_tab1_chet.field('docDateEndInDays').set(
                        editor_tab1_chet.field('dognet_docbase.srokindays').val());
                }
            });
        });
    editor_tab1_chet.on('preSubmit', function(e, data, action) {
        if (action !== "remove") {
            let docDateBegin = editor_tab1_chet.field('docDateBegin').val();
            let docDateEnd = editor_tab1_chet.field('docDateEnd').val();
            let kodtip = editor_tab1_chet.field('dognet_docbase.kodtip').val();
            //
            var b = editor_tab1_chet.field('docDateBegin').val().split('.');
            var e = editor_tab1_chet.field('docDateEnd').val().split('.');
            //
            if (!moment(docDateBegin, "DD.MM.YYYY", true).isValid()) {
                editor_tab1_chet.field('docDateBegin').error('<center>Обязательно</center>');
                $('input[id="DTE_Field_docDateBegin"]').closest('fieldset.docDateBegin').css({
                    'background-color': '#FFD5D4',
                    'border-radius': '1rem',
                    'margin-bottom': '0.5rem'
                });
                editor_tab1_chet.field('dognet_docbase.daynachdoc').set(0);
                editor_tab1_chet.field('dognet_docbase.monthnachdoc').set(0);
                editor_tab1_chet.field('dognet_docbase.yearnachdoc').set(0);
                tabError_1 = 1;
                returnFalse = 1;
            } else {
                $('input[id="DTE_Field_docDateBegin"]').closest('fieldset.docDateBegin').css({
                    'background-color': 'inherit',
                    'border-radius': 'none',
                    'margin-bottom': 'none'
                });
            }
            //
            //
            if (editor_tab1_chet.field('docDateEndInDays').val() === "") {
                editor_tab1_chet.field('dognet_docbase.srokindays').set(null);
            }
            //
            //
            if (['245287841599652', '245287841608965'].includes(kodtip) && !moment(docDateEnd,
                    "DD.MM.YYYY", true).isValid() && firstavans_date !== "") {
                editor_tab1_chet.field('docDateEnd').error('<center>Срок поставки</center>');
                $('input[id="DTE_Field_docDateEnd"]').closest('fieldset.docDateEnd').css({
                    'background-color': '#FFD5D4',
                    'border-radius': '1rem',
                    'margin-bottom': '0.5rem'
                });
                editor_tab1_chet.field('dognet_docbase.dayenddoc').set(0);
                editor_tab1_chet.field('dognet_docbase.monthenddoc').set(0);
                editor_tab1_chet.field('dognet_docbase.yearenddoc').set(0);
                tabError_1 = 1;
                returnFalse = 1;
            } else {
                $('input[id="DTE_Field_docDateEnd"]').closest('fieldset.docDateEnd').css({
                    'background-color': 'inherit',
                    'border-radius': 'none',
                    'margin-bottom': 'none'
                });
            }
        }
    });

    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    // Изменяем размер диалогового окна редактирования счета субподряда
    editor_tab1_chet.on('close', function() {
        $(".modal-dialog").css({
            "width": "80%",
        });
        table_tab1_chet.ajax.reload(null, false);
    });
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    table_tab1_chet = $('#chetview-edit-tab1_chet').DataTable({
        dom: "<'row'<'col-md-8 col-sm-12'B><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'>>",
        // 		dom: "t",
        language: {
            url: "php/examples/simple/chetview/chetview-edit/dt_russian-tab1_chet.json"
        },
        ajax: {
            url: "php/examples/php/chetview/chetview-edit/dognet-chetview-edit-tab1_chet-process.php",
            type: "POST"
        },
        serverSide: true,
        columns: [{
                class: "details-control",
                searchable: false,
                orderable: false,
                data: null,
                defaultContent: "<span class='glyphicon glyphicon-option-vertical'></span>"
            },
            {
                data: "dognet_docbase.docnamefullm"
            },
            {
                data: "dognet_docbase.docsumma"
            }
        ],
        select: {
            style: 'single',
            selector: 'td:first-child'
        },
        columnDefs: [{
                orderable: false,
                searchable: false,
                targets: 0
            },
            {
                orderable: false,
                searchable: false,
                render: function(data, type, row, meta) {
                    if (data == "") {
                        return row.dognet_docbase.docnameshot;
                    } else {
                        return row.dognet_docbase.docnamefullm;
                    }
                },
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
            [1, "asc"]
        ],
        select: true,
        processing: false,
        paging: false,
        searching: false,
        lengthChange: false,
        buttons: [{
                text: '<span class="glyphicon glyphicon-refresh"></span>',
                action: function(e, dt, node, config) {
                    table_tab1_chet.columns().search('').draw();
                }
            },
            {
                extend: "edit",
                editor: editor_tab1_chet,
                text: "РЕДАКТИРОВАТЬ",
                formButtons: ['Сохранить изменения',
                    {
                        text: 'Отмена',
                        action: function() {
                            this.close();
                        }
                    }
                ]
            }
        ],
        initComplete: function() {

        },
        drawCallback: function() {

        }
    });
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    editor_tab1_chet.on('preOpen', function(e, node, action) {
        if (action === "create") {
            editor_tab1_chet.field('docDateBegin').val('');
            editor_tab1_chet.field('docDateEnd').val('');
            editor_tab1_chet.field('docDateEndInDays').val('');

            $('#DTE_Field_docDateEndInDays').attr("placeholder", "Кол. дней");
            $("fieldset.docDateEndInDays").css({
                "display": "block"
            });
            $("fieldset.docDateEnd").css({
                "display": "none"
            });
        }
        //
        if (action === "edit") {
            if (editor_tab1_chet.field('dognet_docbase.daynachdoc').val() == '0' || editor_tab1_chet
                .field('dognet_docbase.monthnachdoc').val() == '0' || editor_tab1_chet.field(
                    'dognet_docbase.yearnachdoc').val() == '0') {
                editor_tab1_chet.field('docDateBegin').val('');
            } else {
                var daynachdoc = addZero(2, editor_tab1_chet.field('dognet_docbase.daynachdoc')
                    .val());
                var monthnachdoc = addZero(2, editor_tab1_chet.field('dognet_docbase.monthnachdoc')
                    .val());
                var yearnachdoc = addZero(2, editor_tab1_chet.field('dognet_docbase.yearnachdoc')
                    .val());
                editor_tab1_chet.field('docDateBegin').set(daynachdoc + "." + monthnachdoc + "." +
                    yearnachdoc);
            }
            //
            //
            if (editor_tab1_chet.field('dognet_docbase.dayenddoc').val() == '0' || editor_tab1_chet
                .field('dognet_docbase.monthenddoc').val() == '0' || editor_tab1_chet.field(
                    'dognet_docbase.yearenddoc').val() == '0') {
                editor_tab1_chet.field('docDateEnd').val('');
            } else {
                var dayenddoc = addZero(2, editor_tab1_chet.field('dognet_docbase.dayenddoc')
                    .val());
                var monthenddoc = addZero(2, editor_tab1_chet.field('dognet_docbase.monthenddoc')
                    .val());
                var yearenddoc = addZero(2, editor_tab1_chet.field('dognet_docbase.yearenddoc')
                    .val());
                editor_tab1_chet.field('docDateEnd').set(dayenddoc + "." + monthenddoc + "." +
                    yearenddoc);
            }
            //
            //
            if (editor_tab1_chet.field('dognet_docbase.srokindays').val() != null) {
                console.log('>>>>>', 'editor_tab1_chet.field(dognet_docbase.srokindays)',
                    editor_tab1_chet.field(
                        'dognet_docbase.srokindays').val());
                $('#DTE_Field_docDateEndInDays').attr("placeholder", "Кол. дней");
                $("fieldset.docDateEndInDays").css({
                    "display": "block"
                });
                $("fieldset.docDateEnd").css({
                    "display": "none"
                });

            }
        }
    });
    //
    //
    editor_tab1_chet.on('preClose', function(e) {
        $('div.firstAvans').css({
            "display": "none"
        });
    });
    //
    //
    editor_tab1_chet.on('initSubmit', function() {

        var a = editor_tab1_chet.field('docDateBegin').val().split('.');
        editor_tab1_chet.field('dognet_docbase.daynachdoc').set(a[0]);
        editor_tab1_chet.field('dognet_docbase.monthnachdoc').set(a[1]);
        editor_tab1_chet.field('dognet_docbase.yearnachdoc').set(a[2]);

        var b = editor_tab1_chet.field('docDateEnd').val().split('.');
        editor_tab1_chet.field('dognet_docbase.dayenddoc').set(b[0]);
        editor_tab1_chet.field('dognet_docbase.monthenddoc').set(b[1]);
        editor_tab1_chet.field('dognet_docbase.yearenddoc').set(b[2]);

    });
    editor_tab1_chet.on('initEdit', function() {
        editor_tab1_chet.field('dognet_docbase.kodshab').disable();
    });
    editor_tab1_chet.on('preOpen', function() {
        editor_tab1_chet.field('dognet_docbase.usedoczayv').disable();
    });
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    // Изменяем размер диалогового окна редактирования счета субподряда
    editor_tab1_chet.on('open', function() {
        $(".modal-dialog").css("width", "80%");
    });
    editor_tab1_chet.on('close', function() {
        $(".modal-dialog").css("width", "80%");
    });
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    // Array to track the ids of the edit displayed rows
    var detailRows = [];

    $('#chetview-edit-tab1_chet tbody').on('click', 'tr td.details-control', function() {
        var tr = $(this).closest('tr');
        var row = table_tab1_chet.row(tr);
        var idx = $.inArray(tr.attr('id'), detailRows);

        if (row.child.isShown()) {
            tr.removeClass('edit');
            row.child.hide();

            // Remove from the 'open' array
            detailRows.splice(idx, 1);
        } else {
            tr.addClass('edit');
            rowData = table_tab1_chet.row(row);
            d = row.data();
            rowData.child(<?php include('templates/chetview-edit_tab1_chet.tpl'); ?>).show();
            // Add to the 'open' array
            if (idx === -1) {
                detailRows.push(tr.attr('id'));
            }
        }
    });
    // On each draw, loop over the `detailRows` array and show any child rows
    table_tab1_chet.on('draw', function() {
        $.each(detailRows, function(i, id) {
            $('#' + id + ' td.details-control').trigger('click');
        });
    });

});
</script>

<style>
/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
#chetview-edit-tab1_chet {}

/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
#chetview-edit-tab1_chet>thead {}

#chetview-edit-tab1_chet {
    border: 2px #951402 solid
}

#chetview-edit-tab1_chet>thead {
    background-color: #951402;
    color: #fff;
    font-weight: 300
}

#chetview-edit-tab1_chet>thead>tr>th {
    font-family: 'Oswald', sans-serif;
    font-weight: 500;
    border-bottom: none
}

#chetview-edit-tab1_chet>thead>tr>th:first-child {
    width: 2%;
    text-align: center
}

#chetview-edit-tab1_chet>thead>tr>th:nth-child(2) {
    width: 83%;
    text-align: left;
    border-left: 1px #f7f7f7 solid
}

#chetview-edit-tab1_chet>thead>tr>th:nth-child(3) {
    width: 15%;
    border-left: 1px #f7f7f7 solid;
    text-align: left
}

/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
#chetview-edit-tab1_chet>tbody>tr>td {
    border-top: none
}

#chetview-edit-tab1_chet>tbody {
    font-family: Courier, Courier new, Serif;
    color: #666;
    border-bottom: none;
    border-top: none
}

#chetview-edit-tab1_chet>tbody>tr>td {
    padding: 5px 8px;
    line-height: 1.42857143;
    vertical-align: middle
}

#chetview-edit-tab1_chet>tbody>tr>td:first-child {
    width: 2%;
    text-align: center
}

#chetview-edit-tab1_chet>tbody>tr>td:nth-child(2) {
    width: 83%;
    text-align: left
}

#chetview-edit-tab1_chet>tbody>tr>td:nth-child(3) {
    width: 15%;
    text-align: left
}

/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
#chetview-edit-tab1_chet>thead>tr>th:nth-child(2):hover {
    cursor: default
}

#chetview-edit-tab1_chet .details-control:hover {
    cursor: pointer
}

#chetview-edit-tab1_chet>tbody>tr>td:nth-child(2),
#chetview-edit-tab1_chet>tbody>tr>td:nth-child(3),
#chetview-edit-tab1_chet>tbody>tr>td:nth-child(4),
#chetview-edit-tab1_chet>tbody>tr>td:nth-child(5) {
    font-family: Courier, Courier new, Serif;
    font-weight: 300
}

/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
#chetview-edit-tab1_chet .sorting_asc:after {
    display: none
}

#chetview-edit-tab1_chet>thead>tr>th.sorting_asc {
    padding-right: 8px
}

/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
#row-edit-tab1_chet {
    font-family: 'Oswald', sans-serif;
    font-size: 1.0em
}

#row-edit-tab1_chet>tbody>tr>td {
    text-align: left
}

#chetview-tab1_chet .panel {
    border: 1px solid #f5f5f5
}

#row-edit-tab1_chet .title-column {
    font-family: 'Oswald', sans-serif;
    font-weight: 400
}

#row-edit-tab1_chet .data-column {
    font-family: Courier, Courier new, Serif;
    font-weight: 300
}

/* ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- */






div.DTE div.DTE_Processing_Indicator {
    top: 15px;
    right: 32px
}

/* ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- */
#customForm_tab1_chet {
    display: flex;
    flex-flow: row wrap;
}

#customForm_tab1_chet fieldset legend {
    padding: 5px 20px;
    font-weight: bold;
}

#customForm_tab1_chet fieldset.name {
    flex: 1 50%;
}

#customForm_tab1_chet fieldset.name legend {}

#customForm_tab1_chet fieldset.office legend {}

#customForm_tab1_chet fieldset.hr legend {
    background: #ffbfbf;
}

#customForm_tab1_chet div.DTE_Field {
    padding: 0;
    text-align: left;
}

#customForm_tab1_chet div.DTE_Field>label.control-label {
    text-align: left;
    font-family: 'HeliosCond', sans-serif;
    text-transform: none;
    font-style: normal;
    font-weight: bold;
    font-size: 1.3em;
    color: #000;
}

/* ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- */
div.modal-dialog {
    margin: 1.0em auto;
    width: 80%
}

/* ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- */
#customForm_tab1_chet {
    font-family: 'Play', sans-serif;
    font-style: normal;
    font-weight: normal;
    font-size: 0.9em;
    display: flex;
    flex-flow: row wrap;
    justify-content: flex-start;
}

/* ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- */
#customForm_tab1_chet div.Section {
    justify-content: flex-start;
    padding: 0;
    background-color: #fafafa;
    display: flex;
    flex-flow: row wrap;
    flex-grow: 1;
    flex-shrink: 2;
    flex-basis: 70%;
    align-content: flex-start;
}

/* ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- */
#customForm_tab1_chet div.Block100 {
    display: flex;
    flex-flow: row wrap;
    flex-grow: 0;
    flex-shrink: 0;
    flex-basis: 100%;
    justify-content: flex-start;
    align-content: flex-start
}

#customForm_tab1_chet div.Block80 {
    display: flex;
    flex-flow: row wrap;
    flex-grow: 0;
    flex-shrink: 0;
    flex-basis: 80%;
    justify-content: flex-start;
    align-content: flex-start;
    padding: 0 2px
}

#customForm_tab1_chet div.Block75 {
    display: flex;
    flex-flow: row wrap;
    flex-grow: 0;
    flex-shrink: 0;
    flex-basis: 75%;
    justify-content: flex-start;
    align-content: flex-start;
    padding: 0 2px
}

#customForm_tab1_chet div.Block70 {
    display: flex;
    flex-flow: row wrap;
    flex-grow: 0;
    flex-shrink: 0;
    flex-basis: 70%;
    justify-content: flex-start;
    align-content: flex-start;
    padding: 0 2px
}

#customForm_tab1_chet div.Block60 {
    display: flex;
    flex-flow: row wrap;
    flex-grow: 0;
    flex-shrink: 0;
    flex-basis: 60%;
    justify-content: flex-start;
    align-content: flex-start;
    padding: 0 2px
}

#customForm_tab1_chet div.Block50 {
    display: flex;
    flex-flow: row wrap;
    flex-grow: 0;
    flex-shrink: 0;
    flex-basis: 50%;
    justify-content: flex-start;
    align-content: flex-start;
    padding: 0 2px
}

#customForm_tab1_chet div.Block40 {
    display: flex;
    flex-flow: row wrap;
    flex-grow: 0;
    flex-shrink: 0;
    flex-basis: 40%;
    justify-content: flex-start;
    align-content: flex-start;
    padding: 0 2px
}

#customForm_tab1_chet div.Block30 {
    display: flex;
    flex-flow: row wrap;
    flex-grow: 0;
    flex-shrink: 0;
    flex-basis: 30%;
    justify-content: flex-start;
    align-content: flex-start;
    padding: 0 2px
}

#customForm_tab1_chet div.Block25 {
    display: flex;
    flex-flow: row wrap;
    flex-grow: 0;
    flex-shrink: 0;
    flex-basis: 25%;
    justify-content: flex-start;
    align-content: flex-start;
    padding: 0 2px
}

#customForm_tab1_chet div.Block20 {
    display: flex;
    flex-flow: row wrap;
    flex-grow: 0;
    flex-shrink: 0;
    flex-basis: 20%;
    justify-content: flex-start;
    align-content: flex-start;
    padding: 0 2px
}

/* ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- */
#customForm_tab1_chet>div.Section>div>fieldset>div>label.control-label {
    width: 100%
}

#customForm_tab1_chet>div.Section>div.Block100>fieldset.dateplan>div>div {
    width: 100%
}

/* ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- */
#customForm_tab1_chet fieldset.field10 {
    flex-grow: 0;
    flex-shrink: 0;
    flex-basis: 10%
}

#customForm_tab1_chet fieldset.field10>div>div {
    width: 100%
}

#customForm_tab1_chet fieldset.field15 {
    flex-grow: 0;
    flex-shrink: 0;
    flex-basis: 15%
}

#customForm_tab1_chet fieldset.field15>div>div {
    width: 100%
}

#customForm_tab1_chet fieldset.field20 {
    flex-grow: 0;
    flex-shrink: 0;
    flex-basis: 20%
}

#customForm_tab1_chet fieldset.field20>div>div {
    width: 100%
}

#customForm_tab1_chet fieldset.field25 {
    flex-grow: 0;
    flex-shrink: 0;
    flex-basis: 25%
}

#customForm_tab1_chet fieldset.field25>div>div {
    width: 100%
}

#customForm_tab1_chet fieldset.field30 {
    flex-grow: 0;
    flex-shrink: 0;
    flex-basis: 30%
}

#customForm_tab1_chet fieldset.field30>div>div {
    width: 100%
}

#customForm_tab1_chet fieldset.field40 {
    flex-grow: 0;
    flex-shrink: 0;
    flex-basis: 40%
}

#customForm_tab1_chet fieldset.field40>div>div {
    width: 100%
}

#customForm_tab1_chet fieldset.field50 {
    flex-grow: 0;
    flex-shrink: 0;
    flex-basis: 50%
}

#customForm_tab1_chet fieldset.field50>div>div {
    width: 100%
}

#customForm_tab1_chet fieldset.field60 {
    flex-grow: 0;
    flex-shrink: 0;
    flex-basis: 60%
}

#customForm_tab1_chet fieldset.field60>div>div {
    width: 100%
}

#customForm_tab1_chet fieldset.field70 {
    flex-grow: 0;
    flex-shrink: 0;
    flex-basis: 70%
}

#customForm_tab1_chet fieldset.field70>div>div {
    width: 100%
}

#customForm_tab1_chet fieldset.field80 {
    flex-grow: 0;
    flex-shrink: 0;
    flex-basis: 80%
}

#customForm_tab1_chet fieldset.field80>div>div {
    width: 100%
}

#customForm_tab1_chet fieldset.field90 {
    flex-grow: 0;
    flex-shrink: 0;
    flex-basis: 90%
}

#customForm_tab1_chet fieldset.field90>div>div {
    width: 100%
}

#customForm_tab1_chet fieldset.field100 {
    flex-grow: 0;
    flex-shrink: 0;
    flex-basis: 100%
}

#customForm_tab1_chet fieldset.field100>div>div {
    width: 100%
}

/* ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- */
#customForm_tab1_chet div.DTE_Field_InputControl {
    text-align: center
}

#customForm_tab1_chet>div.Section>div>fieldset>div.DTE_Field_Type_checkbox>label.control-label {
    text-align: center
}

#customForm_tab1_chet div.DTE_Field_InputControl>div>div>label {
    display: none
}

#customForm_tab1_chet fieldset>div>label.control-label {
    width: 100%
}

/* ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- */
#customForm_tab1_chet div.rDS2 {
    display: flex;
    flex-flow: row wrap;
    flex-grow: 1;
    flex-shrink: 1;
    flex-basis: 100%;
    justify-content: flex-end;
    align-content: flex-start;
}

#customForm_tab1_chet>div.Section>div.rDS2>fieldset.docnamefullm>div>div {
    width: 100%
}

#customForm_tab1_chet>div.Section>div.rDS2>fieldset>div>label.control-label {
    width: 100%
}

#customForm_tab1_chet>div.Section>div.rDS3>fieldset>div>label.control-label {
    width: 100%
}

#customForm_tab1_chet div.rDS3 {
    display: flex;
    flex-flow: row wrap;
    flex-grow: 1;
    flex-shrink: 1;
    flex-basis: 100%;
    justify-content: flex-end;
    align-content: flex-start;
}

#customForm_tab1_chet>div.Section>div.rDS3>fieldset>div>div {
    width: 100%
}

#customForm_tab1_chet fieldset.docnumberRel {
    flex-grow: 1;
    flex-shrink: 3;
    flex-basis: 100%;
}

#DTE_Field_mailbox_incoming-outbox_docnumber_rel {
    width: 99.99%;
}

#DTE_Field_inbox_docnumber_rel {
    width: 100%;
}

#customForm_tab1_chet>div.Section>div>legend,
#customForm_tab1_chet>div.Section>div>div>legend {
    padding: 5px 0 5px 15px;
    font-family: 'HeliosCond', sans-serif;
    font-size: 1.3em;
    font-weight: normal;
    border: none;
    border-left: 10px #b95959 solid;
    text-transform: none;
    color: #111;
    background-color: #ddd;
    margin-bottom: 5px;
}

#customForm_tab1_chet>div.Section>div>fieldset.kodobjectFilter>input,
#customForm_tab1_chet>div.Section>div>fieldset.kodzakazFilter>input {
    height: 34px;
    padding: 6px 12px;
    width: 100%;
    border: 1px solid #ccc;
    border-radius: 4px
}

/**/
textarea[id=DTE_Field_dognet_docbase-docnameshot],
textarea[id=DTE_Field_dognet_docbase-docnamefullm],
textarea[id=DTE_Field_dognet_docbase-comments] {
    resize: none
}

textarea[id=DTE_Field_dognet_docbase-docnameshot] {
    height: 4em;
}

#customForm_tab1_chet div.firstAvans {
    background-color: #B95959;
    color: #FFF !important;
    width: 100%;
    text-align: center;
    padding: 0.25rem 1rem;
    border: 2px #fff solid;
    border-top: none;
}

label[for="DTE_Field_dognet_docbase-usendssumma"] {
    text-align: center;
}

#block-chkDocDateEndInDays {
    margin-left: 15px;
    padding-top: 0;
}
</style>
<?php
// ----- ----- ----- ----- -----
// Форма редактирования этапа
// :::
?>
<div id="customForm_tab1_chet">
    <div class="Section">
        <div class="firstAvans" style="display:none">
            <span id="ajaxFirstAvansOut" class=""></span>
        </div>
        <div class="Block60">
            <legend>Наименование и сроки</legend>
            <fieldset class="field40 docnumber">
                <editor-field name="dognet_docbase.docnumber"></editor-field>
            </fieldset>
            <fieldset class="field30 docDateBegin">
                <editor-field name="docDateBegin"></editor-field>
            </fieldset>
            <fieldset class="field30 docDateEnd" style="display:block">
                <editor-field name="docDateEnd"></editor-field>
            </fieldset>
            <fieldset class="field30 docDateEndInDays" style="display:none">
                <editor-field name="docDateEndInDays"></editor-field>
            </fieldset>
            <fieldset class="field30 srokindays" style="display:none">
                <editor-field name="dognet_docbase.srokindays"></editor-field>
            </fieldset>
            <fieldset class="field30 kodzakaz" style="display:none">
                <editor-field name="dognet_docbase.kodzakaz"></editor-field>
            </fieldset>
            <div id="block-chkDocDateEndInDays" class="checkbox" style="">
                <label style="font-size:1.0rem"><input id="chkDocDateEndInDays" type="checkbox" checked="true"
                           value=""><b>Срок
                        окончания в днях (от 1-го аванса)</b></label>
            </div>
        </div>
        <div class="Block40">
            <legend>Тип счета</legend>
            <fieldset class="field100">
                <editor-field name="dognet_docbase.kodtip"></editor-field>
            </fieldset>
        </div>
        <div class="Block50">
            <legend>Название счета</legend>
            <fieldset class="field100 docnameshot">
                <editor-field name="dognet_docbase.docnameshot"></editor-field>
            </fieldset>
        </div>
        <div class="Block50">
            <div class="Block100">
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
        </div>
    </div>
</div>




<?php
// ----- ----- ----- ----- -----
// Таблица этапов
// :::
?>
<section>
    <div id="chetview-tab1_chet" class="" style="padding:0 5px">
        <div class="space30"></div>
        <div class="demo-html"></div>
        <table id="chetview-edit-tab1_chet" class="table" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
                    <th class="text-center text-uppercase">Название счета</th>
                    <th class="text-uppercase">Сумма</th>
                </tr>
            </thead>
        </table>
    </div>
</section>