<script type="text/javascript" language="javascript" class="init">
//
//
var editor_tab4_avans; // use a global for the submit and return data rendering in the examples
var table_tab4_avans; // use a global for the submit and return data rendering in the examples
//
//
var reqField_sendMail = {
    sendMail: function(response) {}
};

function ajaxRequest_sendMail(koddoc, docnumber, namedoc, numberstage, namestage, dateavans, summaavans,
    responseHandler) {
    var response = false;
    // Fire off the request to /form.php
    request = $.ajax({
        url: "php/examples/simple/docview/docview-edit/restr_4/tabs/php/sendMail_onSubmit-newAvans.php",
        type: "post",
        cache: false,
        data: {
            koddoc: koddoc,
            docnumber: docnumber,
            namedoc: namedoc,
            numberstage: numberstage,
            namestage: namestage,
            dateavans: dateavans,
            summaavans: summaavans
        },
        success: reqField_sendMail[responseHandler]
    });
    // Callback handler that will be called on success
    request.done(function(response, textStatus, jqXHR) {
        res1 = response.replace(new RegExp("\\r?\\n", "g"), "");
        console.log("response: " + response);
        if (res1 == '0') {
            console.log("Письмо отправлено");
            // $("#ajaxResponse_reqUnlockDoc_msg").html('Запрос в ОД отправлен');
        }
        if (res1 == '-1') {
            console.log("Лог файл недоступен для записи");
            // $("#ajaxResponse_reqUnlockDoc_msg").html('Что-то пошло не так...');
        }
        if (res1 == '-2') {
            console.log("Не возможно открыть лог файл");
            // $("#ajaxResponse_reqUnlockDoc_msg").html('Ошибка запроса');
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
//
var reqField_sumallavans = {
    sumallavans: function(response) {}
};

function ajaxRequest_sumallavans(data1, data2, data3, data4, responseHandler) {
    var response = false;

    // Fire off the request to /form.php
    request = $.ajax({
        url: "php/examples/simple/docview/docview-edit/restr_4/tabs/process/ajaxrequests/ajaxReq-docviewedit-tab4_avans-sumallavans.php",
        type: "post",
        cache: false,
        data: {
            action: data1,
            koddoc: data2,
            kodkalplan: data3,
            sum: data4
        },
        success: reqField_sumallavans[responseHandler]
    });
    // Callback handler that will be called on success
    request.done(function(response, textStatus, jqXHR) {
        console.log("Ого! Работает! : " + textStatus);
        res = response.replace(new RegExp("\\r?\\n", "g"), "");
        // console.log("Response2 : " + data1 + " / " + data2 + " / " + data3 + " >>> " + res);

        var x = res.split(' / ');
        var doc_summa = x[0];
        var stage_summa = x[1];
        var sumav = x[2];
        var sumost = x[3];
        var sumoplavchf = x[4];
        var sumav_html = (parseFloat(sumav) != 0) ? '<span title="Сумма всех авансов по договору" class="">' +
            sumav +
            '</span>' : '<span title="Сумма всех авансов по договору" class="">' + sumav + '</span>'
        var sumost_html = (parseFloat(sumost) != 0) ?
            '<span title="Сумма всех незачтенных остатков" class="" style="color:#fff; padding:2px 5px; background-color:#951302">' +
            sumost +
            '</span>' :
            '<span title="Сумма всех незачтенных остатков" class="" style="color:#fff; padding:2px 5px; background-color:#46a512">' +
            sumost + '</span>';
        var sumoplavchf_html = (parseFloat(sumoplavchf) != 0) ?
            '<span title="Сумма всех зачетов авансов по всем счетам-фактурам по договору" class="">' +
            sumoplavchf +
            '</span>' :
            '<span title="Сумма всех зачетов авансов по всем счетам-фактурам по договору" class="">' +
            sumoplavchf + '</span>';
        // editor_tab2_kalplans.field('dognet_dockalplan.summastage').message(res);
        $('#sumctrl_av_title').html(sumav_html + " / " + sumoplavchf_html + " / " + sumost_html);
        console.log("ajaxRequest_sumallavans : " + doc_summa + " / " + stage_summa + " / " + sumav + " / " +
            sumost +
            " >>> " + res);

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
$(document).ready(function() {

    // АВАНСЫ : форма редактирования
    editor_tab4_avans = new $.fn.dataTable.Editor({
        display: "bootstrap",
        ajax: "php/examples/simple/docview/docview-edit/restr_4/tabs/process/dognet-docview-edit(restr_4)-tab4_avans-process.php",
        table: "#docview-edit-tab4_avans",
        i18n: {
            create: {
                title: "<h3>Добавить новый аванс</h3>"
            },
            edit: {
                title: "<h3>Изменить аванс</h3>"
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
                    'Сентябрь', 'Октябрь',
                    'Ноябрь', 'Декабрь'
                ],
                weekdays: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб']
            }
        },
        template: '#customForm_tab4_avans',
        fields: [{
            label: "Описание аванса :",
            name: "dognet_docavans.nameavans"
        }, {
            label: "Дата :",
            name: "dognet_docavans.dateavans",
            type: "datetime",
            format: "DD.MM.YYYY",
            def: function() {
                return new Date();
            }
            // 				attr: { readonly: "readonly" }
        }, {
            label: "Этап:",
            name: "dognet_docavans.koddoc",
            type: "select",
            placeholder: "Выберите этап"
        }, {
            label: "Сумма :",
            name: "dognet_docavans.summaavans"
        }, {
            label: "Комментарий :",
            name: "dognet_docavans.comment"
        }]
    });
    //
    // Изменяем размер диалогового окна редактирования договора субподряда
    editor_tab4_avans.on('open', function() {
        $(".modal-dialog").css({
            "width": "60%",
            "min-width": "800px",
            "max-width": "1170px"
        });
    });
    editor_tab4_avans.on('close', function() {
        $(".modal-dialog").css({
            "width": "60%",
            "min-width": "none",
            "max-width": "none"
        });
    });
    //
    //
    editor_tab4_avans.on('open', function(e, mode, action) {});
    //
    //
    // АВАНСЫ : таблица
    table_tab4_avans = $('#docview-edit-tab4_avans').DataTable({
        dom: "<'row'<'col-md-8 col-sm-12'B><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'>>",
        // 		dom: "t",
        language: {
            url: "php/examples/simple/docview/docview-edit/dt_russian-tab4_avans.json"
        },
        ajax: {
            url: "php/examples/simple/docview/docview-edit/restr_4/tabs/process/dognet-docview-edit(restr_4)-tab4_avans-process.php",
            type: "POST"
        },
        serverSide: true,
        columns: [{
                data: null,
                class: "details-control",
                searchable: false,
                orderable: false,
                defaultContent: "<span class='glyphicon glyphicon-option-vertical'></span>"
            },
            {
                data: null,
                render: function(data, type, row) {
                    if (row.dognet_docbase.kodshab === "1" || row.dognet_docbase.kodshab ===
                        "3") {
                        if (type === 'display') {
                            return '';
                        }
                        return row.dognet_dockalplan.numberstage;
                    } else if (row.dognet_docbase.kodshab === "2" || row.dognet_docbase
                        .kodshab === "4") {
                        if (type === 'display') {
                            return '';
                        }
                        return row.dognet_docbase.docnumber;
                    }
                }
            },
            {
                data: "dognet_docavans.kodavans"
            },
            {
                data: "dognet_docavans.dateavans"
            },
            {
                data: "dognet_docavans.nameavans"
            },
            {
                data: "dognet_docavans.summaavans"
            },
            {
                data: "dognet_docavans.ostatokavans"
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
                orderable: true,
                visible: false,
                searchable: false,
                targets: 1
            },
            {
                orderable: false,
                searchable: false,
                targets: 2
            },
            {
                orderable: true,
                searchable: false,
                type: "date",
                render: function(data) {
                    return data;
                },
                targets: 3
            },
            {
                orderable: false,
                searchable: false,
                targets: 4
            },
            {
                orderable: false,
                searchable: false,
                render: function(data, type, row, meta) {
                    if (data != null) {
                        return $.fn.dataTable.render.number(' ', ',', 2, '').display(data) + row
                            .dognet_spdened
                            .short_code;
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
                        return $.fn.dataTable.render.number(' ', ',', 2, '').display(data) + row
                            .dognet_spdened
                            .short_code;
                    } else {
                        return "0.00" + row.dognet_spdened.short_code;
                    }
                },
                targets: 6
            }
        ],
        order: [
            [3, "desc"]
        ],
        select: true,
        processing: true,
        paging: false,
        searching: false,
        lengthChange: false,
        rowGroup: {
            dataSrc: function(row) {
                if (row.dognet_docbase.kodshab === "1" || row.dognet_docbase.kodshab === "3") {
                    return "Этап " + row.dognet_dockalplan.numberstage + " (" + row
                        .dognet_dockalplan.nameshotstage +
                        ")";
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
            emptyDataGroup: 'Нет категорий для группировки...'
        },
        buttons: [{
                text: '<span class="glyphicon glyphicon-refresh"></span>',
                action: function(e, dt, node, config) {
                    table_tab4_avans.columns().search('');
                    table_tab4_avans.order([3, "desc"]).draw();
                }
            },
            {
                extend: "create",
                editor: editor_tab4_avans,
                text: "НОВЫЙ АВАНС",
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
                editor: editor_tab4_avans,
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
                editor: editor_tab4_avans,
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
        ],
        initComplete: function() {

        },
        drawCallback: function() {

        }
    });
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    //
    //
    //
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    // Выводим уведомление (цифру) о количестве авансов
    table_tab4_avans.on('draw', function() {
        cnt_avn = table_tab4_avans.data().count();
        if (cnt_avn > 0) {
            document.getElementById("avn_newitems_cnt").innerHTML = cnt_avn;
        } else {
            document.getElementById("avn_newitems_cnt").innerHTML = "";
        }

        selected = table_tab4_avans.row({
            selected: true
        });
        console.log('ajaxRequest_sumallavans (selected): ' + selected);
        if (selected.any()) {
            kodkalplan = selected.data().dognet_docavans.koddoc;
        } else {
            kodkalplan = null;
        }
        console.log('ajaxRequest_sumallavans (kodkalplan): ' + kodkalplan);

        ajaxRequest_sumallavans(null, uniqueID, kodkalplan, null, 'sumallavans');

    });
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    //
    //
    //
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    editor_tab4_avans.on('submitSuccess', function(e, json, data, action) {
        if (action === "create") {
            // осуществляем глубокое копирование объекта и инициализируем переменную
            let newObj = JSON.parse(JSON.stringify(json));
            console.log("submitSuccess newObj.data > " + newObj.data[0]);
            _koddoc = newObj.data[0].dognet_dockalplan.kodkalplan;
            console.log("_koddoc > " + _koddoc);
            _docnumber = newObj.data[0].dognet_docbase.docnumber;

            _namedoc = newObj.data[0].dognet_docbase.docnameshot;

            _numberstage = newObj.data[0].dognet_dockalplan.numberstage;

            _namestage = newObj.data[0].dognet_dockalplan.nameshotstage;

            _dateavans = newObj.data[0].dognet_docavans.dateavans;

            _summaavans = newObj.data[0].dognet_docavans.summaavans;
            _summaavans = $.fn.dataTable.render.number(' ', ',', 2, '').display(_summaavans) + newObj
                .data[0]
                .dognet_spdened.short_code

            ajaxRequest_sendMail(_koddoc, _docnumber, _namedoc, _numberstage, _namestage, _dateavans,
                _summaavans,
                'sendMail');

        }
        table_tab3_kalplanchf.row({
            selected: true
        }).deselect();
    });
    //
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    //
    // Array to track the ids of the edit displayed rows
    var detailRows_tab4_avans = [];

    $('#docview-edit-tab4_avans tbody').on('click', 'tr td.details-control', function() {
        var tr = $(this).closest('tr');
        var row = table_tab4_avans.row(tr);
        var idx = $.inArray(tr.attr('id'), detailRows_tab4_avans);

        if (row.child.isShown()) {
            tr.removeClass('edit');
            row.child.hide();

            // Remove from the 'open' array
            detailRows_tab4_avans.splice(idx, 1);
        } else {
            tr.addClass('edit');
            rowData = table_tab4_avans.row(row);
            d = row.data();
            rowData.child(<?php include('templates/docview-edit_tab4_avans.tpl'); ?>).show();

            // Add to the 'open' array
            if (idx === -1) {
                detailRows_tab4_avans.push(tr.attr('id'));
            }
        }
    });
    // On each draw, loop over the `detailRows_tab4_avans` array and show any child rows
    table_tab4_avans.on('draw', function() {
        $.each(detailRows_tab4_avans, function(i, id) {
            $('#' + id + ' td.details-control').trigger('click');
        });
    });

    editor_tab4_avans
        .on('open', function() {
            // Store the values of the fields on open
            openVals_tab4_avans = JSON.stringify(editor_tab4_avans.get());
            editor_tab4_avans.on('preBlur', function(e) {
                // On close, check if the values have changed and ask for closing confirmation if they have
                if (openVals_tab4_avans !== JSON.stringify(editor_tab4_avans.get())) {
                    return confirm('Вы не сохранили данные формы. Уверены, что хотите ее закрыть?');
                }
            })
            $('#DTE_Field_dognet_docavans-summaavans').inputmask({
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
            $('#DTE_Field_dognet_docavans-dateavans').inputmask({
                mask: "99.99.9999"
            });
        });

});
</script>
<?php
// ----- ----- ----- ----- -----
// Подключаем форму и выводим таблицу авансов
// :::
include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/docview/docview-edit/restr_4/tabs/forms/docview-edit_tab4_avans-customForm.php");
?>
<link rel="stylesheet"
      href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-edit/restr_4/tabs/css/docview-edit-tab4_avans.css">
<section>
    <div id="docview-tab4_avans" class="" style="padding:0 5px">
        <div class="space30"></div>
        <h3 class="parent-title space20">Авансы по основному договору <span id="sumctrl_av_title"
                  style="font-weight:300; font-size:0.9em; float:right; padding-right:10px"></span></h3>
        <div class="demo-html"></div>
        <table id="docview-edit-tab4_avans" class="table table-responsive table-bordered display compact"
               cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
                    <th></th>
                    <th>ID аванса</th>
                    <th>Дата</th>
                    <th>Описание аванса</th>
                    <th>Сумма</th>
                    <th>Незачтенный остаток</th>
                </tr>
            </thead>
        </table>
    </div>
</section>