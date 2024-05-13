<script type="text/javascript"
        src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/moment-with-locales.js"></script>
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/filterByText.js">
</script>

<link rel="stylesheet"
      href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/chetview/chetview-current/restr_4/css/chetview-current-common-tables.css">
<link rel="stylesheet"
      href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/chetview/chetview-current/restr_4/css/chetview-current-common-customForm.css">

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
        url: "php/examples/simple/chetview/chetview-current/restr_4/process/ajaxrequests/dognet-reqAjax-getFromDBAsync-firstavans.php",
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
        url: "php/examples/simple/chetview/chetview-current/restr_4/process/ajaxrequests/dognet-reqAjax-getFromDB-firstavans.php",
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

        if (response != '0' && response != '-1' && response != '-2' && response != 'error -3') {

            var x = res.split('/');
            var av1date = x[0];
            var av1summa = x[1];
            if (av1date != "" && av1summa != "") {
                $('#ajaxFirstAvansOut').html("1-ый аванс по счёту поступил " + moment(av1date, 'YYYY-MM-DD')
                    .format(
                        'DD.MM.YYYY') + " на сумму " + av1summa + " р.");
                firstavans_date += moment(av1date, 'YYYY-MM-DD').format('DD.MM.YYYY');
            } else {
                $('#ajaxFirstAvansOut').html("Авансов по счёту пока не поступало");
                firstavans_date = "";
            }
            $('div.firstAvans').css({
                "display": "block"
            });
        } else {
            $('#ajaxFirstAvansOut').html("Авансов по счёту пока не поступало");
            firstavans_date = "";
        }
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
var table_chet_main;
var editor_chet_main;
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
$(document).ready(function() {

    editor_chet_main = new $.fn.dataTable.Editor({
        display: "bootstrap",
        ajax: "php/examples/simple/chetview/chetview-current/restr_4/process/dognet-chetview-chet-main-process.php",
        table: "#chetview-chet-main",
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
        template: '#customForm-chet-main',
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
            def: "0",
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
            label: "Комментарий :",
            name: "dognet_docbase.comments",
            type: "textarea"
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
        }]
    });
    //
    // ----- ----- ----- ----- -----
    // Изменяем размер диалогового окна редактирования
    editor_chet_main.on('open', function() {
        $(".modal-dialog").css({
            "width": "60%",
            "min-width": "640px",
            "max-width": "800px"
        });
    });
    editor_chet_main.on('close', function() {
        $(".modal-dialog").css({
            "width": "80%",
        });
    });
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    editor_chet_main
        .on('open', function(e, mode, action) {
            firstavans_dateAsync = "";
            koddoc = "";
            //
            //
            if (action === "create") {
                ajaxRequest_firstavans(koddoc, 'firstavans');
                firstavans_dateAsync = ajaxRequest_firstavansAsync(koddoc);
                if (firstavans_dateAsync !== "") {
                    editor_chet_main.field('docDateEnd').enable();
                } else {
                    editor_chet_main.field('docDateEnd').disable();
                }
            }
            //
            if (action === "edit") {
                selected = table_chet_main.row({
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
                    editor_chet_main.field('docDateEnd').enable();
                } else {
                    editor_chet_main.field('docDateEnd').disable();
                    $("fieldset.docDateEndInDays").css({
                        "display": "block"
                    });
                    $("fieldset.docDateEnd").css({
                        "display": "none"
                    });
                }
            }
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
            $('#kodzakaz_filter').val('');
            if (($('#DTE_Field_dognet_docbase-kodzakaz').value) != editor_chet_main.field(
                    'dognet_docbase.kodzakaz').get()) {}
            // Поиск в ниспадающем списке по содержимому текстового поля для ответного документа
            $('#DTE_Field_dognet_docbase-kodzakaz').filterByText(editor_chet_main, $('#kodzakaz_filter'),
                'dognet_docbase.kodzakaz', false);
            $('#kodobject_filter').val('');
            if (($('#DTE_Field_dognet_docbase-kodobject').value) != editor_chet_main.field(
                    'dognet_docbase.kodobject').get()) {}
            // Поиск в ниспадающем списке по содержимому текстового поля для ответного документа
            $('#DTE_Field_dognet_docbase-kodobject').filterByText(editor_chet_main, $('#kodobject_filter'),
                'dognet_docbase.kodobject', false);
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
                if ($(this).is(':checked')) {
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
            $('#DTE_Field_docDateEndInDays').on("keyup", function() {
                if (firstavans_dateAsync !== "") {
                    editor_chet_main.field('docDateEnd').enable();
                    dateAvans = moment(firstavans_dateAsync, 'YYYY-MM-DD');
                    dateEnd = dateAvans.add($(this).val(), 'days').format('DD.MM.YYYY');
                    console.log('dateEnd in DATE', dateEnd);
                    editor_chet_main.field('docDateEnd').val(dateEnd);
                } else {
                    editor_chet_main.field('docDateEnd').disable();
                    editor_chet_main.field('docDateEnd').val('');
                    editor_chet_main.field('dognet_docbase.dayenddoc').set(0);
                    editor_chet_main.field('dognet_docbase.monthenddoc').set(0);
                    editor_chet_main.field('dognet_docbase.yearenddoc').set(0);
                }
                editor_chet_main.field('dognet_docbase.srokindays').set($(this).val());
            });
            $('#DTE_Field_docDateEnd').on("change", function() {
                if (firstavans_dateAsync !== "" && !isNaN($(this).val())) {
                    dateAvans = moment(firstavans_dateAsync, 'YYYY-MM-DD');
                    dateEnd = moment($(this).val(), 'DD.MM.YYYY');
                    if (dateAvans.isValid() && dateEnd.isValid()) {
                        dateEndInDays = dateEnd.diff(dateAvans, 'days');
                        console.log('dateEnd in DATE', dateEnd, 'dateEnd in DAYS', dateEndInDays);
                        editor_chet_main.field('docDateEndInDays').val(
                            dateEndInDays);
                        editor_chet_main.field('dognet_docbase.srokindays').val(
                            dateEndInDays);
                    }
                } else {
                    editor_chet_main.field('docDateEndInDays').set(
                        editor_chet_main.field('dognet_docbase.srokindays').val());
                }
            });
        })
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

    table_chet_main = $('#chetview-chet-main').DataTable({
        dom: "<'row'<'col-sm-5'B><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'l>>" +
            "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'p>>",
        // 		dom: "<'space50'r>tip",
        language: {
            url: "russian.json"
        },
        ajax: {
            url: "php/examples/simple/chetview/chetview-current/restr_4/process/dognet-chetview-chet-main-process.php",
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
                data: "dognet_docbase.docnumber",
                className: "text-center"
            },
            {
                data: "dognet_docbase.numberchet",
                className: "text-left"
            },
            {
                data: "dognet_docbase.yearnachdoc",
                className: "text-center"
            },
            {
                data: "dognet_docbase.docnameshot",
                className: "text-left"
            },
            {
                data: "sp_objects.nameobjectshot"
            },
            {
                data: "sp_contragents.nameshort"
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
                data: null,
                defaultContent: '<a href="#" class="edit_listalt"><span class="glyphicon glyphicon-list-alt"></span></a>'
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
                orderable: true,
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
                visible: false,
                searchable: true,
                targets: 5
            },
            {
                orderable: false,
                visible: false,
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
                searchable: false,
                targets: 10,
                render: function(data, type, row, meta) {
                    return '<span style="padding:0 5px"><a href="dognet-chetview.php?chetview_type=details&uniqueID=' +
                        row.dognet_docbase.koddoc +
                        '"><span class="glyphicon glyphicon-list-alt"></span></a></span>' +
                        '<span style="padding:0 5px"><a href="dognet-chetview.php?chetview_type=edit&uniqueID=' +
                        row.dognet_docbase.koddoc +
                        '"><span class="glyphicon glyphicon-pencil"></span></a></span>';
                }
            }
        ],
        order: [
            [2, "desc"],
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
                    $('#docObjectSearch_text').val('');
                    $('#docZakazSearch_text').val('');
                    $('#docTypeSearch_text').val('');
                    $('#docIspolSearch_text').val('');
                    $('#docShablonSearch_text').val('');
                    table_chet_main.columns().search('');
                    table_chet_main.order([2, "desc"], [1, "desc"]).draw();
                }
            },
            {
                extend: "create",
                editor: editor_chet_main,
                text: "СОЗДАТЬ СЧЕТ",
                formButtons: ['Создать счет',
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
                editor: editor_chet_main,
                text: "РЕДАКТИРОВАТЬ",
                formButtons: ['Сохранить изменения',
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
                editor: editor_chet_main,
                text: "УДАЛИТЬ",
                formButtons: ['Удалить счет',
                    {
                        text: 'Отмена',
                        action: function() {
                            this.close();
                        }
                    }
                ]
            }
        ],
        drawCallback: function() {

        }
    });

    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    // Array to track the ids of the details displayed rows
    var detailRows = [];

    $('#chetview-chet-main tbody').on('click', 'tr td.details-control', function() {
        var tr = $(this).closest('tr');
        var row = table_chet_main.row(tr);
        var idx = $.inArray(tr.attr('id'), detailRows);

        if (row.child.isShown()) {
            tr.removeClass('details');
            row.child.hide();

            // Remove from the 'open' array
            detailRows.splice(idx, 1);
        } else {
            tr.addClass('details');
            rowData = table_chet_main.row(row);
            d = row.data();
            rowData.child(<?php include('templates/chetview-current-details.tpl'); ?>).show();

            // Add to the 'open' array
            if (idx === -1) {
                detailRows.push(tr.attr('id'));
            }
        }
    });
    // On each draw, loop over the `detailRows` array and show any child rows
    table_chet_main.on('draw', function() {
        $.each(detailRows, function(i, id) {
            $('#' + id + ' td.details-control').trigger('click');
        });
    });
    //
    //
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    //
    //
    editor_chet_main.on('preOpen', function(e, node, action) {
        if (action === "create") {
            editor_chet_main.field('docDateBegin').val('');
            editor_chet_main.field('docDateEnd').val('');
            editor_chet_main.field('docDateEndInDays').val('');

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
            if (editor_chet_main.field('dognet_docbase.daynachdoc').val() == '0' || editor_chet_main
                .field('dognet_docbase.monthnachdoc').val() == '0' || editor_chet_main.field(
                    'dognet_docbase.yearnachdoc').val() == '0') {
                editor_chet_main.field('docDateBegin').val('');
            } else {
                var daynachdoc = addZero(2, editor_chet_main.field('dognet_docbase.daynachdoc')
                    .val());
                var monthnachdoc = addZero(2, editor_chet_main.field('dognet_docbase.monthnachdoc')
                    .val());
                var yearnachdoc = addZero(2, editor_chet_main.field('dognet_docbase.yearnachdoc')
                    .val());
                editor_chet_main.field('docDateBegin').set(daynachdoc + "." + monthnachdoc + "." +
                    yearnachdoc);
            }
            //
            //
            if (editor_chet_main.field('dognet_docbase.dayenddoc').val() == '0' || editor_chet_main
                .field('dognet_docbase.monthenddoc').val() == '0' || editor_chet_main.field(
                    'dognet_docbase.yearenddoc').val() == '0') {
                editor_chet_main.field('docDateEnd').val('');
            } else {
                var dayenddoc = addZero(2, editor_chet_main.field('dognet_docbase.dayenddoc')
                    .val());
                var monthenddoc = addZero(2, editor_chet_main.field('dognet_docbase.monthenddoc')
                    .val());
                var yearenddoc = addZero(2, editor_chet_main.field('dognet_docbase.yearenddoc')
                    .val());
                editor_chet_main.field('docDateEnd').set(dayenddoc + "." + monthenddoc + "." +
                    yearenddoc);
            }
            //
            //
            if (editor_chet_main.field('dognet_docbase.srokindays').val() != null) {
                console.log('>>>>>', 'editor_chet_main.field(dognet_docbase.srokindays)',
                    editor_chet_main.field(
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
    editor_chet_main.on('initSubmit', function() {

        var a = editor_chet_main.field('docDateBegin').val().split('.');
        editor_chet_main.field('dognet_docbase.daynachdoc').set(a[0]);
        editor_chet_main.field('dognet_docbase.monthnachdoc').set(a[1]);
        editor_chet_main.field('dognet_docbase.yearnachdoc').set(a[2]);

        var b = editor_chet_main.field('docDateEnd').val().split('.');
        editor_chet_main.field('dognet_docbase.dayenddoc').set(b[0]);
        editor_chet_main.field('dognet_docbase.monthenddoc').set(b[1]);
        editor_chet_main.field('dognet_docbase.yearenddoc').set(b[2]);

    });
    editor_chet_main.on('initEdit', function() {
        editor_chet_main.field('dognet_docbase.kodshab').disable();
    });
    editor_chet_main.on('initCreate', function() {
        editor_chet_main.field('dognet_docbase.kodshab').enable();
    });
    editor_chet_main.on('preOpen', function() {
        editor_chet_main.field('dognet_docbase.usedoczayv').disable();
    });
    editor_chet_main.on('preSubmit', function(e, data, action) {
        if (action !== "remove") {
            returnFalse = 0;
            tabError_1 = 0;
            tabError_2 = 0;
            tabError_3 = 0;
            tabError_4 = 0;
            let docDateBegin = editor_chet_main.field('docDateBegin').val();
            let docDateEnd = editor_chet_main.field('docDateEnd').val();
            let kodtip = editor_chet_main.field('dognet_docbase.kodtip').val();
            let docnumber = editor_chet_main.field('dognet_docbase.docnumber').val();
            let docnameshot = editor_chet_main.field('dognet_docbase.docnameshot').val();
            let kodobject = editor_chet_main.field('dognet_docbase.kodobject').val();
            let kodzakaz = editor_chet_main.field('dognet_docbase.kodzakaz').val();
            //
            var b = editor_chet_main.field('docDateBegin').val().split('.');
            var e = editor_chet_main.field('docDateEnd').val().split('.');
            //
            if (!moment(docDateBegin, "DD.MM.YYYY", true).isValid()) {
                editor_chet_main.field('docDateBegin').error('<center>Обязательно</center>');
                $('input[id="DTE_Field_docDateBegin"]').closest('fieldset.docDateBegin').css({
                    'background-color': '#FFD5D4',
                    'border-radius': '1rem',
                    'margin-bottom': '0.5rem'
                });
                editor_chet_main.field('dognet_docbase.daynachdoc').set(0);
                editor_chet_main.field('dognet_docbase.monthnachdoc').set(0);
                editor_chet_main.field('dognet_docbase.yearnachdoc').set(0);
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
            if (editor_chet_main.field('docDateEndInDays').val() === "") {
                editor_chet_main.field('dognet_docbase.srokindays').set(null);
            }
            //
            //
            if (['245287841599652', '245287841608965'].includes(kodtip) && !moment(docDateEnd,
                    "DD.MM.YYYY", true).isValid() && firstavans_date !== "") {
                editor_chet_main.field('docDateEnd').error('<center>Срок поставки</center>');
                $('input[id="DTE_Field_docDateEnd"]').closest('fieldset.docDateEnd').css({
                    'background-color': '#FFD5D4',
                    'border-radius': '1rem',
                    'margin-bottom': '0.5rem'
                });
                editor_chet_main.field('dognet_docbase.dayenddoc').set(0);
                editor_chet_main.field('dognet_docbase.monthenddoc').set(0);
                editor_chet_main.field('dognet_docbase.yearenddoc').set(0);
                tabError_1 = 1;
                returnFalse = 1;
            } else {
                $('input[id="DTE_Field_docDateEnd"]').closest('fieldset.docDateEnd').css({
                    'background-color': 'inherit',
                    'border-radius': 'none',
                    'margin-bottom': 'none'
                });
            }
            // 
            if (docnumber === "") {
                editor_chet_main.field('dognet_docbase.docnumber').error(
                    '<center>Обязательно</center>');
                $('input[id="DTE_Field_dognet_docbase-docnumber"]').closest('fieldset.docnumber')
                    .css({
                        'background-color': '#FFD5D4',
                        'border-radius': '1rem',
                        'margin-bottom': '0.5rem'
                    });
                tabError_1 = 1;
                returnFalse = 1;
            } else {
                $('input[id="DTE_Field_dognet_docbase-docnumber"]').closest('fieldset.docnumber')
                    .css({
                        'background-color': 'inherit',
                        'border-radius': 'none',
                        'margin-bottom': 'none'
                    });
            }
            // 
            if (docnameshot === "") {
                editor_chet_main.field('dognet_docbase.docnameshot').error(
                    '<center>Обязательно</center>');
                $('textarea[id="DTE_Field_dognet_docbase-docnameshot"]').closest(
                        'fieldset.docnameshot')
                    .css({
                        'background-color': '#FFD5D4',
                        'border-radius': '1rem',
                        'margin-bottom': '0.5rem'
                    });
                tabError_1 = 1;
                returnFalse = 1;
            } else {
                $('textarea[id="DTE_Field_dognet_docbase-docnameshot"]').closest(
                        'fieldset.docnameshot')
                    .css({
                        'background-color': 'inherit',
                        'border-radius': 'none',
                        'margin-bottom': 'none'
                    });
            }
            //
            if (kodobject === "" || kodobject === null) {
                editor_chet_main.field('dognet_docbase.kodobject').error(
                    '<center>Обязательно</center>');
                $('select[id="DTE_Field_dognet_docbase-kodobject"]').closest('fieldset.kodobject')
                    .css({
                        'background-color': '#FFD5D4',
                        'border-radius': '1rem',
                        'margin-bottom': '0.5rem'
                    });
                tabError_2 = 1;
                returnFalse = 1;
            } else {
                $('select[id="DTE_Field_dognet_docbase-kodobject"]').closest('fieldset.kodobject')
                    .css({
                        'background-color': 'inherit',
                        'border-radius': 'none',
                        'margin-bottom': 'none'
                    });
            }
            //
            if (kodzakaz === "" || kodzakaz === null) {
                editor_chet_main.field('dognet_docbase.kodzakaz').error(
                    '<center>Обязательно</center>');
                $('select[id="DTE_Field_dognet_docbase-kodzakaz"]').closest('fieldset.kodzakaz')
                    .css({
                        'background-color': '#FFD5D4',
                        'border-radius': '1rem',
                        'margin-bottom': '0.5rem'
                    });
                tabError_2 = 1;
                returnFalse = 1;
            } else {
                $('select[id="DTE_Field_dognet_docbase-kodzakaz"]').closest('fieldset.kodzakaz')
                    .css({
                        'background-color': 'inherit',
                        'border-radius': 'none',
                        'margin-bottom': 'none'
                    });
            }
            //
            //
            if (tabError_1 === 1) {
                $('a[href="#doc-editor-tab-1"]').addClass('error');
            } else {
                $('a[href="#doc-editor-tab-1"]').removeClass('error');
            }
            if (tabError_2 === 1) {
                $('a[href="#doc-editor-tab-2"]').addClass('error');
            } else {
                $('a[href="#doc-editor-tab-2"]').removeClass('error');
            }
            // 
            if (returnFalse === 1) {
                return false;
            }
        }
    });
    editor_chet_main.on('preClose', function(e) {
        $('a[href="#doc-editor-tab-1"]').removeClass('error');
        $('a[href="#doc-editor-tab-2"]').removeClass('error');
        //
        $('input[id="DTE_Field_docDateBegin"]').closest('fieldset.docDateBegin').css({
            'background-color': 'inherit',
            'border-radius': 'none',
            'margin-bottom': 'none'
        });
        $('input[id="DTE_Field_docDateEnd"]').closest('fieldset.docDateEnd').css({
            'background-color': 'inherit',
            'border-radius': 'none',
            'margin-bottom': 'none'
        });
        $('input[id="DTE_Field_dognet_docbase-docnumber"]').closest('fieldset.docnumber').css({
            'background-color': 'inherit',
            'border-radius': 'none',
            'margin-bottom': 'none'
        });
        $('textarea[id="DTE_Field_dognet_docbase-docnameshot"]').closest('fieldset.docnameshot')
            .css({
                'background-color': 'inherit',
                'border-radius': 'none',
                'margin-bottom': 'none'
            });
        $('select[id="DTE_Field_dognet_docbase-kodobject"]').closest('fieldset.kodobject').css({
            'background-color': 'inherit',
            'border-radius': 'none',
            'margin-bottom': 'none'
        });
        $('select[id="DTE_Field_dognet_docbase-kodzakaz"]').closest('fieldset.kodzakaz').css({
            'background-color': 'inherit',
            'border-radius': 'none',
            'margin-bottom': 'none'
        });
        $('div.firstAvans').css({
            "display": "none"
        });

    });
    //
    //
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    //
    //
    $('#globalSearch_button').click(function(e) {
        table_chet_main.search($("#globalSearch_text").val()).draw();
    });
    $('#clearSearch_button').click(function(e) {
        table_chet_main.search('').draw();
        $('#globalSearch_text').val('');
    });

    $('#columnSearch_btnApply').click(function(e) {
        table_chet_main
            .columns(2)
            .search($("#docNumberSearch_text").val())
            .draw();

        table_chet_main
            .columns(3)
            .search($("#docYearSearch_text").val())
            .draw();

        table_chet_main
            .columns(4)
            .search($("#docNameSearch_text").val())
            .draw();

        table_chet_main
            .columns(5)
            .search($("#docObjectSearch_text").val())
            .draw();

        table_chet_main
            .columns(6)
            .search($("#docZakazSearch_text").val())
            .draw();

        table_chet_main
            .columns(7)
            .search($("#docTypeSearch_text").val())
            .draw();

        table_chet_main
            .columns(8)
            .search($("#docIspolSearch_text").val())
            .draw();

    });

    $('#columnSearch_btnClear').click(function(e) {
        $('#docNumberSearch_text').val('');
        $('#docYearSearch_text').val('');
        $('#docNameSearch_text').val('');
        $('#docObjectSearch_text').val('');
        $('#docZakazSearch_text').val('');
        $('#docTypeSearch_text').val('');
        $('#docIspolSearch_text').val('');
        table_chet_main
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
include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/chetview/chetview-current/restr_4/forms/chetview-current-customForm.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/chetview/chetview-current/restr_4/forms/chetview-current-filters.php");
// ----- ----- ----- ----- -----
?>
<link rel="stylesheet"
      href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/chetview/chetview-current/restr_4/css/chetview-current-main.css">
<section>
    <div class="demo-html"></div>
    <table id="chetview-chet-main" class="table table-responsive table-bordered display compact" cellspacing="0"
           width="100%">
        <thead>
            <tr>
                <th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
                <th class="text-center">№</th>
                <th class="text-center">Счет №</th>
                <th class="text-center">Год</th>
                <th class="text-left">Краткое название</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </thead>
    </table>
</section>