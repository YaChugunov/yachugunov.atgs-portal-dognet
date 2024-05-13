<script type="text/javascript" language="javascript" class="init">
//
//
var reqField_sendMailSUB = {
    sendMail: function(response) {}
};

function ajaxRequest_sendMailSUB(blanktip, blankname, ispolname, ispolrukname, objname, zakname, summablank,
    responseHandler) {
    var response = false;
    // Fire off the request to /form.php
    request = $.ajax({
        url: "php/examples/simple/blankview/blankview-gip/restr_3/tabs/php/sendMail_onSubmit-newBlankSUB.php",
        type: "post",
        cache: false,
        data: {
            blanktip: blanktip,
            blankname: blankname,
            ispolname: ispolname,
            ispolrukname: ispolrukname,
            objname: objname,
            zakname: zakname,
            summablank: summablank
        },
        success: reqField_sendMailSUB[responseHandler]
    });
    // Callback handler that will be called on success
    request.done(function(response, textStatus, jqXHR) {
        res1 = response.replace(new RegExp("\\r?\\n", "g"), "");
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

$(document).ready(function() {
    //
    //
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    // API INSTANCE ФОРМЫ БЛАНКА ГИПА НА субподряд ::: Редактор
    var editor_blankview_edit_sub = new $.fn.dataTable.Editor({
        display: "bootstrap",
        ajax: {
            url: "php/examples/php/blankview/blankview-gip/dognet-blankview-gip-sub-process.php"
        },
        table: "#blankview-gip-sub-table",
        i18n: {
            create: {
                title: "<h3>Создать новую заявку на субподряд</h3>"
            },
            edit: {
                title: "<h3>Изменить заявку</h3>"
            },
            remove: {
                button: "Удалить",
                title: "<h3>Удалить заявку</h3>",
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
        template: '#customForm_newblank_sub',
        fields: [{
            label: "Исполнитель (рук) :",
            name: "dognet_blankdocsub.kodispolruk",
            type: "select",
            def: "---",
            placeholder: "Выберите исполнителя"
        }, {
            label: "Исполнитель (ГИП) :",
            name: "dognet_blankdocsub.kodispol",
            type: "select",
            def: "---",
            placeholder: "Выберите ГИП"
        }, {
            label: "Организация (справочник) :",
            name: "dognet_blankdocsub.kodzakaz",
            type: "select",
            def: "---",
            placeholder: "Выберите подрядчика"
        }, {
            label: "Название договора :",
            name: "dognet_blankdocsub.namedocblank"
        }, {
            label: "Как заказчик",
            type: "checkbox",
            name: "dognet_blankdocsub.kodorgzakaz",
            options: [{
                label: "",
                value: 1
            }],
            separator: "",
            unselectedValue: 0
        }, {
            label: "Как исполнитель",
            type: "checkbox",
            name: "dognet_blankdocsub.kodorgispol",
            options: [{
                label: "",
                value: 1
            }],
            separator: "",
            unselectedValue: 0
        }, {
            label: "Новая организация",
            type: "checkbox",
            name: "dognet_blankdocsub.koduseneworg",
            options: [{
                label: "",
                value: 1
            }],
            separator: "",
            unselectedValue: 0
        }, {
            label: "Справочник",
            type: "checkbox",
            name: "dognet_blankdocsub.kodusespzakaz",
            options: [{
                label: "",
                value: 1
            }],
            separator: "",
            unselectedValue: 0
        }, {
            label: "Название организации :",
            name: "dognet_blankdocsub.nameneworg",
            fieldInfo: ""
        }, {
            label: "Сумма договора :",
            name: "dognet_blankdocsub.csummadocopl"
        }, {
            label: "",
            type: "checkbox",
            name: "dognet_blankdocsub.kodusendsopl",
            options: [{
                label: "",
                value: 1
            }],
            separator: "",
            unselectedValue: 0
        }, {
            label: "",
            type: "checkbox",
            name: "dognet_blankdocsub.kodusespechopl",
            options: [{
                label: "",
                value: 1
            }],
            separator: "",
            unselectedValue: 0
        }, {
            label: "Вариант 1",
            type: "checkbox",
            name: "dognet_blankdocsub.koduseopl1usl",
            options: [{
                label: "",
                value: 1
            }],
            separator: "",
            unselectedValue: 0
        }, {
            label: "Вариант 2",
            type: "checkbox",
            name: "dognet_blankdocsub.koduseopl2usl",
            options: [{
                label: "",
                value: 1
            }],
            separator: "",
            unselectedValue: 0
        }, {
            label: "Вариант 3",
            type: "checkbox",
            name: "dognet_blankdocsub.koduseopl3usl",
            options: [{
                label: "",
                value: 1
            }],
            separator: "",
            unselectedValue: 0
        }, {
            label: "Вариант 4",
            type: "checkbox",
            name: "dognet_blankdocsub.koduseopl4usl",
            options: [{
                label: "",
                value: 1
            }],
            separator: "",
            unselectedValue: 0
        }, {
            label: "Сумма аванса :",
            name: "dognet_blankdocsub.csummaopl1usl",
            fieldInfo: "( X процентов )"
        }, {
            label: "Сумма оплаты :",
            name: "dognet_blankdocsub.csummaopl2usl",
            fieldInfo: "( X процентов )"
        }, {
            label: "В течение :",
            name: "dognet_blankdocsub.cnumberoplday2usl",
            fieldInfo: "( N дней )"
        }, {
            label: "В течение :",
            name: "dognet_blankdocsub.cnumberoplday3usl",
            fieldInfo: "( N дней )"
        }, {
            label: "Иные условия :",
            name: "dognet_blankdocsub.ctextoplotherusl",
            type: "textarea"
        }, {
            label: "",
            type: "checkbox",
            name: "dognet_blankdocsub.kodusepril1",
            options: [{
                label: "",
                value: 1
            }],
            separator: "",
            unselectedValue: 0
        }, {
            label: "",
            type: "checkbox",
            name: "dognet_blankdocsub.kodusepril2",
            options: [{
                label: "",
                value: 1
            }],
            separator: "",
            unselectedValue: 0
        }, {
            label: "",
            type: "checkbox",
            name: "dognet_blankdocsub.kodusepril3",
            options: [{
                label: "",
                value: 1
            }],
            separator: "",
            unselectedValue: 0
        }, {
            label: "",
            type: "checkbox",
            name: "dognet_blankdocsub.kodusepril4",
            options: [{
                label: "",
                value: 1
            }],
            separator: "",
            unselectedValue: 0
        }, {
            label: "",
            type: "checkbox",
            name: "dognet_blankdocsub.kodusepril5",
            options: [{
                label: "",
                value: 1
            }],
            separator: "",
            unselectedValue: 0
        }, {
            label: "Особые условия договора :",
            name: "dognet_blankdocsub.defuslgiptext",
            type: "textarea",
            fieldInfo: ""
        }, {
            label: "По итогам выигранного тендера",
            type: "checkbox",
            name: "dognet_blankdocsub.kodusetender",
            options: [{
                label: "",
                value: 1
            }],
            separator: "",
            unselectedValue: 0
        }, {
            label: "",
            type: "checkbox",
            name: "dognet_blankdocsub.koduseispoldoc1",
            options: [{
                label: "",
                value: 1
            }],
            separator: "",
            unselectedValue: 0
        }, {
            label: "",
            type: "checkbox",
            name: "dognet_blankdocsub.koduseispoldoc2",
            options: [{
                label: "",
                value: 1
            }],
            separator: "",
            unselectedValue: 0
        }, {
            label: "",
            type: "checkbox",
            name: "dognet_blankdocsub.koduseispoldoc3",
            options: [{
                label: "",
                value: 1
            }],
            separator: "",
            unselectedValue: 0
        }, {
            label: "",
            type: "checkbox",
            name: "dognet_blankdocsub.koduseispoldoc4",
            options: [{
                label: "",
                value: 1
            }],
            separator: "",
            unselectedValue: 0
        }, {
            label: "",
            name: "dognet_blankdocsub.cdateispoldoc1",
            attr: {
                placeholder: 'ДД/ММ/ГГГГ'
            },
            fieldInfo: ""
        }, {
            label: "",
            name: "dognet_blankdocsub.cdaysispoldoc2",
            attr: {
                placeholder: 'N дней'
            },
            fieldInfo: ""
        }, {
            label: "",
            type: "checkbox",
            name: "dognet_blankdocsub.kodusekomrasx1",
            options: [{
                label: "",
                value: 1
            }],
            separator: "",
            unselectedValue: 0
        }, {
            label: "",
            type: "checkbox",
            name: "dognet_blankdocsub.kodusekomrasx2",
            options: [{
                label: "",
                value: 1
            }],
            separator: "",
            unselectedValue: 0
        }, {
            label: "",
            type: "checkbox",
            name: "dognet_blankdocsub.kodusekomrasx3",
            options: [{
                label: "",
                value: 1
            }],
            separator: "",
            unselectedValue: 0
        }, {
            label: "",
            type: "checkbox",
            name: "dognet_blankdocsub.kodusekomrasx4",
            options: [{
                label: "",
                value: 1
            }],
            separator: "",
            unselectedValue: 0
        }, {
            label: "",
            name: "dognet_blankdocsub.summalimitmis",
            fieldInfo: ""
        }, {
            label: "",
            name: "dognet_blankdocsub.komrasxprim",
            attr: {
                placeholder: ''
            },
            fieldInfo: ""
        }, {
            label: "",
            type: "checkbox",
            name: "dognet_blankdocsub.kodusetrans1",
            options: [{
                label: "",
                value: 1
            }],
            separator: "",
            unselectedValue: 0
        }, {
            label: "",
            type: "checkbox",
            name: "dognet_blankdocsub.kodusetrans2",
            options: [{
                label: "",
                value: 1
            }],
            separator: "",
            unselectedValue: 0
        }, {
            label: "",
            type: "checkbox",
            name: "dognet_blankdocsub.kodusetrans3",
            options: [{
                label: "",
                value: 1
            }],
            separator: "",
            unselectedValue: 0
        }, {
            label: "",
            name: "dognet_blankdocsub.transprim",
            attr: {
                placeholder: ''
            },
            fieldInfo: ""
        }, {
            label: "Куда поставляется обрудование :",
            name: "dognet_blankdocsub.transplaceobor",
            type: "textarea",
            attr: {
                placeholder: ''
            },
            fieldInfo: ""
        }, {
            label: "",
            name: "dognet_blankdocsub.climitdays",
            attr: {
                placeholder: ''
            },
            fieldInfo: ""
        }, {
            label: "",
            name: "dognet_blankdocsub.numberdocmain",
            attr: {
                placeholder: ''
            },
            fieldInfo: ""
        }, {
            label: "",
            type: "checkbox",
            name: "dognet_blankdocsub.koduserisk1",
            options: [{
                label: "",
                value: 1
            }],
            separator: "",
            unselectedValue: 0
        }, {
            label: "",
            type: "checkbox",
            name: "dognet_blankdocsub.koduserisk2",
            options: [{
                label: "",
                value: 1
            }],
            separator: "",
            unselectedValue: 0
        }, {
            label: "",
            type: "checkbox",
            name: "dognet_blankdocsub.koduserisk3",
            options: [{
                label: "",
                value: 1
            }],
            separator: "",
            unselectedValue: 0
        }, {
            label: "",
            type: "checkbox",
            name: "dognet_blankdocsub.koduserisk4",
            options: [{
                label: "",
                value: 1
            }],
            separator: "",
            unselectedValue: 0
        }, {
            label: "",
            type: "checkbox",
            name: "dognet_blankdocsub.koduserisk5",
            options: [{
                label: "",
                value: 1
            }],
            separator: "",
            unselectedValue: 0
        }, {
            label: "",
            name: "dognet_blankdocsub.riskprim",
            attr: {
                placeholder: ''
            },
            fieldInfo: ""
        }, {
            label: "",
            name: "dognet_blankdocsub.nameendcontact",
            attr: {
                placeholder: ''
            },
            fieldInfo: ""
        }, {
            label: "",
            name: "dognet_blankdocsub.namefistcontact",
            attr: {
                placeholder: ''
            },
            fieldInfo: ""
        }, {
            label: "",
            name: "dognet_blankdocsub.namesecondcontact",
            attr: {
                placeholder: ''
            },
            fieldInfo: ""
        }, {
            label: "",
            name: "dognet_blankdocsub.namedoljcontact",
            attr: {
                placeholder: ''
            },
            fieldInfo: ""
        }, {
            label: "",
            name: "dognet_blankdocsub.nameemail",
            attr: {
                placeholder: ''
            },
            fieldInfo: ""
        }, {
            label: "",
            name: "dognet_blankdocsub.numbertelrab",
            attr: {
                placeholder: ''
            },
            fieldInfo: ""
        }, {
            label: "",
            name: "dognet_blankdocsub.numbertelmob",
            attr: {
                placeholder: ''
            },
            fieldInfo: ""
        }, {
            label: "",
            name: "dognet_blankdocsub.numbertelfax",
            attr: {
                placeholder: ''
            },
            fieldInfo: ""
        }, {
            label: "",
            type: "checkbox",
            name: "dognet_blankdocsub.kodblankcreate",
            options: [{
                label: "",
                value: 1
            }],
            separator: "",
            unselectedValue: 0
        }, {
            label: "",
            type: "checkbox",
            name: "sendEmailSUB",
            options: [{
                label: "",
                value: 1
            }],
            separator: "",
            def: "1",
            unselectedValue: 0
        }]
    });
    //
    // ----- ----- ----- ----- -----
    // Изменяем размер диалогового окна редактирования
    editor_blankview_edit_sub.on('open', function() {
        $(".modal-dialog").css({
            "width": "95%",
            "margin": "1.0em auto",
            "min-width": "800px",
            "max-width": "1170px"
        });
    });
    // ----- ----- ----- ----- -----
    var openVals1;
    editor_blankview_edit_sub.on('open', function() {
        $('#kodzakaz_filter_sub').val('');
        if (($('#DTE_Field_dognet_blankdocsub-kodzakaz').value) != editor_blankview_edit_sub.field(
                'dognet_blankdocsub.kodzakaz').get()) {}
        // Поиск в ниспадающем списке по содержимому текстового поля для ответного документа
        $('#DTE_Field_dognet_blankdocsub-kodzakaz').filterByText(editor_blankview_edit_sub, $(
            '#kodzakaz_filter_sub'), 'dognet_blankdocsub.kodzakaz', false);

        // Store the values of the fields on open
        openVals1 = JSON.stringify(editor_blankview_edit_sub.get());
        editor_blankview_edit_sub.on('preBlur', function(e) {
            // On close, check if the values have changed and ask for closing confirmation if they have
            if (openVals1 !== JSON.stringify(editor_blankview_edit_sub.get())) {
                return confirm('Вы не сохранили данные формы. Уверены, что хотите ее закрыть?');
            }
        })

        $('#DTE_Field_dognet_blankdocsub-csummadocopl').inputmask({
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

    });
    editor_blankview_edit_sub.on("submit close", function() {
        editor_blankview_edit_sub.off("preBlur");
    });
    // ----- ----- ----- ----- -----
    editor_blankview_edit_sub.on('preSubmit', function(e, data, action) {
        var jsondata = JSON.stringify(editor_blankview_edit_sub.get());
        /* 		var jsondata = JSON.editor_blankview_edit_sub.get(); */
        var parsejson = JSON.parse(jsondata);
        if (action !== 'remove') {
            if ((parsejson['dognet_blankdocsub.koduseopl1usl'] == 0) && (parsejson[
                    'dognet_blankdocsub.koduseopl2usl'] == 0) && (parsejson[
                    'dognet_blankdocsub.koduseopl3usl'] == 0) && (parsejson[
                    'dognet_blankdocsub.koduseopl4usl'] == 0)) {
                return confirm('Вы не определили порядок оплаты! Уверены, что хотите сохранить бланк?');
            }
        } else {
            return confirm('Вы уверены, что хотите удалить бланк?');
        }

    });
    // ----- ----- ----- ----- -----
    editor_blankview_edit_sub.on('postSubmit', function(e) {
        table_blankview_gip_sub.rows().deselect();
        table_blankview_gip_sub.ajax.reload();
    });
    // ----- ----- ----- ----- -----
    editor_blankview_edit_sub.on('initEdit', function(e) {
        editor_blankview_edit_sub.field('dognet_blankdocsub.nameneworg').set("");
        editor_blankview_edit_sub.field('dognet_blankdocsub.nameneworg').disable();
        editor_blankview_edit_sub.field('dognet_blankdocsub.koduseneworg').set(false);
        editor_blankview_edit_sub.field('dognet_blankdocsub.koduseneworg').disable();
        editor_blankview_edit_sub.field('dognet_blankdocsub.kodusespzakaz').set(true);
        editor_blankview_edit_sub.field('dognet_blankdocsub.kodusespzakaz').disable();
    });
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    //
    //
    //
    //
    //
    //
    //
    //
    //
    //
    //
    //
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    // API INSTANCE ЗАЯВКИ ГИПА НА субподряд ::: Редактор
    var editor_blankview_gip_sub = new $.fn.dataTable.Editor({
        display: "bootstrap",
        ajax: "php/examples/php/blankview/blankview-gip/dognet-blankview-gip-sub-process.php",
        table: "#blankview-gip-sub-table",
        i18n: {
            create: {
                title: "<h3>Создать новую заявку на договор субподряд</h3>"
            },
            edit: {
                title: "<h3>Изменить заявку</h3>"
            },
            remove: {
                button: "Удалить",
                title: "<h3>Удалить заявку</h3>",
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
        /* 		template: '#customForm_docblank-table', */
        fields: [{
            label: "Номер договора :",
            name: "dognet_docblankwork.numberdoccr"
        }, {
            label: "Передан в работу :",
            name: "dognet_docblankwork.dateblankdoc",
            type: "datetime",
            format: "DD.MM.YYYY",
            def: function() {
                return new Date();
            },
            attr: {
                readonly: "readonly"
            }
        }, {
            label: "Подрядчик :",
            name: "dognet_docblankwork.kodzakaz",
            type: "select",
            def: "---",
            placeholder: "Выберите подрядчика"
        }]
    });
    // ----- ----- ----- ----- -----
    var openVals2;
    editor_blankview_gip_sub.on('preBlur', function(e) {
        // On close, check if the values have changed and ask for closing confirmation if they have
        if (openVals2 !== JSON.stringify(editor_blankview_gip_sub.get())) {
            return confirm('Вы изменили данные формы. Уверены, что хотите выйти из редактирования?');
        }
    })
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    //
    // ::::: З А В И С И М О С Т И (dependences) : BEGIN
    //
    editor_blankview_edit_sub.dependent('dognet_blankdocsub.kodblankcreate', function(val) {
        if (val == 0) {
            $('#div-sendEmail-sub').css("display", "none");
            editor_blankview_edit_sub.field('sendEmailSUB').set(0);
            editor_blankview_edit_sub.field('sendEmailSUB').disable();
            editor_blankview_edit_sub.field('sendEmailSUB').hide(false);
        } else {
            $('#div-sendEmail-sub').css("display", "");
            editor_blankview_edit_sub.field('sendEmailSUB').set(1);
            editor_blankview_edit_sub.field('sendEmailSUB').show(false);
            editor_blankview_edit_sub.field('sendEmailSUB').enable();
        }
    });

    // TAB 1
    editor_blankview_edit_sub.dependent('dognet_blankdocsub.kodusespzakaz', function(val) {
        if (val == 0) {
            editor_blankview_edit_sub.field('dognet_blankdocsub.kodusespzakaz').disable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.kodzakaz').disable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.kodzakaz').set("");

            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseneworg').enable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseneworg').set(true);
            editor_blankview_edit_sub.field('dognet_blankdocsub.nameneworg').enable();
            $('#kodzakaz_filter_sub').prop('disabled', true);
        } else {}
    });
    editor_blankview_edit_sub.dependent('dognet_blankdocsub.koduseneworg', function(val) {
        if (val == 0) {
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseneworg').disable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.nameneworg').disable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.nameneworg').set("");

            editor_blankview_edit_sub.field('dognet_blankdocsub.kodusespzakaz').enable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.kodusespzakaz').set(true);
            editor_blankview_edit_sub.field('dognet_blankdocsub.kodzakaz').enable();
            $('#kodzakaz_filter_sub').prop('disabled', false);
        }
    });
    //
    //
    //
    // TAB 4
    editor_blankview_edit_sub.dependent('dognet_blankdocsub.koduseispoldoc1', function(val) {
        if (val == 1) {
            editor_blankview_edit_sub.field('dognet_blankdocsub.cdateispoldoc1').enable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseispoldoc2').disable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseispoldoc3').disable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseispoldoc4').disable();
            $("#useispoldoc1").css('outline-color', '#019401');
        } else {
            editor_blankview_edit_sub.field('dognet_blankdocsub.cdateispoldoc1').disable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseispoldoc2').enable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseispoldoc3').enable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseispoldoc4').enable();
            $("#useispoldoc1").css('outline-color', '#ccc');
        }
    });
    editor_blankview_edit_sub.dependent('dognet_blankdocsub.koduseispoldoc2', function(val) {
        if (val == 1) {
            editor_blankview_edit_sub.field('dognet_blankdocsub.cdaysispoldoc2').enable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseispoldoc1').disable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseispoldoc3').disable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseispoldoc4').disable();
            $("#useispoldoc2").css('outline-color', '#019401');
        } else {
            editor_blankview_edit_sub.field('dognet_blankdocsub.cdaysispoldoc2').disable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseispoldoc1').enable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseispoldoc3').enable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseispoldoc4').enable();
            $("#useispoldoc2").css('outline-color', '#ccc');
        }
        editor_blankview_edit_sub.dependent('dognet_blankdocsub.koduseispoldoc2', function(val) {
            if (val == 0) {
                editor_blankview_edit_sub.field('dognet_blankdocsub.cdaysispoldoc2').disable();
            } else {
                editor_blankview_edit_sub.field('dognet_blankdocsub.cdaysispoldoc2').enable();
            }
        });
    });
    editor_blankview_edit_sub.dependent('dognet_blankdocsub.koduseispoldoc3', function(val) {
        if (val == 1) {
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseispoldoc1').disable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseispoldoc2').disable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseispoldoc4').disable();
            $("#useispoldoc3").css('outline-color', '#019401');
        } else {
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseispoldoc1').enable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseispoldoc2').enable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseispoldoc4').enable();
            $("#useispoldoc3").css('outline-color', '#ccc');
        }
    });
    editor_blankview_edit_sub.dependent('dognet_blankdocsub.koduseispoldoc4', function(val) {
        if (val == 1) {
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseispoldoc1').disable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseispoldoc2').disable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseispoldoc3').disable();
            $("#useispoldoc4").css('outline-color', '#019401');
        } else {
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseispoldoc1').enable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseispoldoc2').enable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseispoldoc3').enable();
            $("#useispoldoc4").css('outline-color', '#ccc');
        }
    });
    //
    //
    //
    // TAB 5
    editor_blankview_edit_sub.dependent('dognet_blankdocsub.kodusekomrasx1', function(val) {
        if (val == 1) {
            editor_blankview_edit_sub.field('dognet_blankdocsub.kodusekomrasx2').disable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.kodusekomrasx3').disable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.kodusekomrasx4').disable();
        } else {
            editor_blankview_edit_sub.field('dognet_blankdocsub.kodusekomrasx2').enable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.kodusekomrasx3').enable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.kodusekomrasx4').enable();
        }
    });
    editor_blankview_edit_sub.dependent('dognet_blankdocsub.kodusekomrasx2', function(val) {
        if (val == 1) {
            editor_blankview_edit_sub.field('dognet_blankdocsub.kodusekomrasx1').disable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.kodusekomrasx3').disable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.kodusekomrasx4').disable();
        } else {
            editor_blankview_edit_sub.field('dognet_blankdocsub.kodusekomrasx1').enable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.kodusekomrasx3').enable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.kodusekomrasx4').enable();
        }
    });
    editor_blankview_edit_sub.dependent('dognet_blankdocsub.kodusekomrasx3', function(val) {
        if (val == 1) {
            editor_blankview_edit_sub.field('dognet_blankdocsub.kodusekomrasx1').disable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.kodusekomrasx2').disable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.kodusekomrasx4').disable();
        } else {
            editor_blankview_edit_sub.field('dognet_blankdocsub.kodusekomrasx1').enable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.kodusekomrasx2').enable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.kodusekomrasx4').enable();
        }
    });
    editor_blankview_edit_sub.dependent('dognet_blankdocsub.kodusekomrasx4', function(val) {
        if (val == 1) {
            editor_blankview_edit_sub.field('dognet_blankdocsub.kodusekomrasx1').disable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.kodusekomrasx3').disable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.kodusekomrasx2').disable();
        } else {
            editor_blankview_edit_sub.field('dognet_blankdocsub.kodusekomrasx1').enable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.kodusekomrasx3').enable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.kodusekomrasx2').enable();
        }
    });
    //
    editor_blankview_edit_sub.dependent('dognet_blankdocsub.kodusekomrasx3', function(val) {
        if (val == 0) {
            editor_blankview_edit_sub.field('dognet_blankdocsub.summalimitmis').disable();
        } else {
            editor_blankview_edit_sub.field('dognet_blankdocsub.summalimitmis').enable();
        }
    });
    editor_blankview_edit_sub.dependent('dognet_blankdocsub.kodusekomrasx4', function(val) {
        if (val == 0) {
            editor_blankview_edit_sub.field('dognet_blankdocsub.komrasxprim').disable();
        } else {
            editor_blankview_edit_sub.field('dognet_blankdocsub.komrasxprim').enable();
        }
    });
    //
    //
    //
    // TAB 6
    editor_blankview_edit_sub.dependent('dognet_blankdocsub.kodusetrans1', function(val) {
        if (val == 1) {
            editor_blankview_edit_sub.field('dognet_blankdocsub.kodusetrans2').disable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.kodusetrans3').disable();
        } else {
            editor_blankview_edit_sub.field('dognet_blankdocsub.kodusetrans2').enable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.kodusetrans3').enable();
        }
    });
    editor_blankview_edit_sub.dependent('dognet_blankdocsub.kodusetrans2', function(val) {
        if (val == 1) {
            editor_blankview_edit_sub.field('dognet_blankdocsub.kodusetrans1').disable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.kodusetrans3').disable();
        } else {
            editor_blankview_edit_sub.field('dognet_blankdocsub.kodusetrans1').enable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.kodusetrans3').enable();
        }
    });
    editor_blankview_edit_sub.dependent('dognet_blankdocsub.kodusetrans3', function(val) {
        if (val == 1) {
            editor_blankview_edit_sub.field('dognet_blankdocsub.kodusetrans1').disable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.kodusetrans2').disable();
        } else {
            editor_blankview_edit_sub.field('dognet_blankdocsub.kodusetrans1').enable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.kodusetrans2').enable();
        }
    });
    //
    editor_blankview_edit_sub.dependent('dognet_blankdocsub.kodusetrans3', function(val) {
        if (val == 0) {
            editor_blankview_edit_sub.field('dognet_blankdocsub.transprim').disable();
        } else {
            editor_blankview_edit_sub.field('dognet_blankdocsub.transprim').enable();
        }
    });
    //
    //
    // TAB 2
    editor_blankview_edit_sub.dependent('dognet_blankdocsub.koduseopl1usl', function(val) {
        if (val == 1) {
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseopl2usl').disable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseopl3usl').disable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseopl4usl').disable();
            $("#useopl1usl").css('outline-color', '#019401');
        } else {
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseopl2usl').enable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseopl3usl').enable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseopl4usl').enable();
            $("#useopl1usl").css('outline-color', '#ccc');
        }
    });
    editor_blankview_edit_sub.dependent('dognet_blankdocsub.koduseopl2usl', function(val) {
        if (val == 1) {
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseopl1usl').disable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseopl3usl').disable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseopl4usl').disable();
            $("#useopl2usl").css('outline-color', '#019401');
        } else {
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseopl1usl').enable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseopl3usl').enable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseopl4usl').enable();
            $("#useopl2usl").css('outline-color', '#ccc');
        }
    });
    editor_blankview_edit_sub.dependent('dognet_blankdocsub.koduseopl3usl', function(val) {
        if (val == 1) {
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseopl1usl').disable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseopl2usl').disable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseopl4usl').disable();
            $("#useopl3usl").css('outline-color', '#019401');
        } else {
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseopl1usl').enable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseopl2usl').enable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseopl4usl').enable();
            $("#useopl3usl").css('outline-color', '#ccc');
        }
    });
    editor_blankview_edit_sub.dependent('dognet_blankdocsub.koduseopl4usl', function(val) {
        if (val == 1) {
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseopl1usl').disable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseopl2usl').disable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseopl3usl').disable();
            $("#useopl4usl").css('outline-color', '#019401');
        } else {
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseopl1usl').enable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseopl2usl').enable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.koduseopl3usl').enable();
            $("#useopl4usl").css('outline-color', '#ccc');
        }
    });
    //
    editor_blankview_edit_sub.dependent('dognet_blankdocsub.koduseopl1usl', function(val) {
        if (val == 0) {
            editor_blankview_edit_sub.field('dognet_blankdocsub.csummaopl1usl').disable();
        } else {
            editor_blankview_edit_sub.field('dognet_blankdocsub.csummaopl1usl').enable();
        }
    });
    editor_blankview_edit_sub.dependent('dognet_blankdocsub.koduseopl2usl', function(val) {
        if (val == 0) {
            editor_blankview_edit_sub.field('dognet_blankdocsub.csummaopl2usl').disable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.cnumberoplday2usl').disable();
        } else {
            editor_blankview_edit_sub.field('dognet_blankdocsub.csummaopl2usl').enable();
            editor_blankview_edit_sub.field('dognet_blankdocsub.cnumberoplday2usl').enable();
        }
    });
    editor_blankview_edit_sub.dependent('dognet_blankdocsub.koduseopl3usl', function(val) {
        if (val == 0) {
            editor_blankview_edit_sub.field('dognet_blankdocsub.cnumberoplday3usl').disable();
        } else {
            editor_blankview_edit_sub.field('dognet_blankdocsub.cnumberoplday3usl').enable();
        }
    });
    editor_blankview_edit_sub.dependent('dognet_blankdocsub.koduseopl4usl', function(val) {
        if (val == 0) {
            editor_blankview_edit_sub.field('dognet_blankdocsub.ctextoplotherusl').disable();
        } else {
            editor_blankview_edit_sub.field('dognet_blankdocsub.ctextoplotherusl').enable();
        }
    });
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    //
    //
    //
    //
    //
    //
    //
    //
    //
    //
    //
    //
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    // БЛАНК ЗАЯВКИ ГИПА НА субподряд ::: Таблица данных
    var table_blankview_gip_sub = $('#blankview-gip-sub-table').DataTable({
        dom: "<'row'<'col-sm-9'B><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-4'i><'col-sm-8'p>>",
        // 		dom: "<'space50'r>tip",
        language: {
            url: "php/examples/simple/blankview/blankview-gip/dt_russian-tab4_sub.json"
        },
        ajax: {
            url: "php/examples/php/blankview/blankview-gip/dognet-blankview-gip-sub-process.php",
            type: "POST"
        },
        serverSide: true,
        columns: [{
                class: "details-control",
                searchable: false,
                orderable: false,
                data: null,
                defaultContent: "<span class='glyphicon glyphicon-list-alt'></span>"
            },
            {
                data: "dognet_docblankwork.dateblankwork",
                className: ""
            },
            {
                data: "dognet_docblankwork.numberblankwork",
                className: ""
            },
            {
                data: "dognet_docblankwork.statusblankwork",
                className: ""
            },
            {
                data: "sp_contragents.nameshort",
                className: ""
            },
            {
                data: "dognet_blankdocsub.namedocblank",
                className: ""
            },
            {
                data: "dognet_spispolruk.ispolruknamefull",
                className: ""
            },
            {
                data: "dognet_blankdocsub.kodtipblank",
                className: ""
            }
        ],
        select: {
            style: 'single',
            selector: 'td:not(:last-child)' // no row selection on last column
        },
        columnDefs: [{
                orderable: false,
                searchable: false,
                targets: 0
            },
            {
                orderable: true,
                searchable: true,
                targets: 1,
                render: function(data, type, row, meta) {
                    if (row.dognet_docblankwork.kodstatusblank === "CR") {
                        return row.dognet_docblankwork.dateblankorder;
                    } else if (row.dognet_docblankwork.kodstatusblank === "DO") {
                        return row.dognet_docblankwork.dateblankwork;
                    } else {
                        return '---';
                    }
                }
            },
            {
                orderable: true,
                visible: false,
                searchable: true,
                targets: 2
            },
            {
                orderable: true,
                searchable: true,
                targets: 3,
                render: function(data, type, row, meta) {
                    if (row.dognet_docblankwork.kodstatusblank === "CR") {
                        return '<span class="label label-danger text-uppercase">Версия ГИП</span>';
                    } else if (row.dognet_docblankwork.kodstatusblank === "DO") {
                        return '<span class="label label-info text-uppercase">Финальная</span>';
                    } else {
                        return '---';
                    }
                }

            },
            {
                orderable: false,
                searchable: true,
                targets: 4
            },
            {
                orderable: false,
                searchable: true,
                targets: 5,
                render: function(data, type, row, meta) {
                    fullstr = data;
                    if (data.length > 63) {
                        return data.substr(0, 63) + " ...";
                    } else {
                        return data;
                    }
                }
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
                targets: 7,
                render: function(data, type, row, meta) {
                    return row.dognet_docblankwork.nametipblankwork;
                }
            }
        ],
        order: [
            [2, "asc"],
            [1, "desc"]
        ],
        select: true,
        processing: true,
        paging: true,
        searching: true,
        pageLength: 30,
        lengthChange: false,
        lengthMenu: [
            [15, 30, 50, -1],
            [15, 30, 50, "Все"]
        ],
        buttons: [{
                text: '<span class="glyphicon glyphicon-refresh"></span>',
                tabIndex: "0",
                className: 'tab4-refreshButton',
                action: function(e, dt, node, config) {
                    table_blankview_gip_sub.columns().search('');
                    table_blankview_gip_sub.draw();
                    table_blankview_gip_sub_docfiles.draw();
                    table_blankview_gip_sub_blankpril.draw();
                }
            },
            {
                extend: "create",
                editor: editor_blankview_edit_sub,
                text: "НОВАЯ ЗАЯВКА",
                tabIndex: "1",
                className: 'tab4-createButton',
                formButtons: ['Создать',
                    {
                        text: 'Отмена',
                        action: function() {
                            this.close();
                            return false;
                        }
                    }
                ]
            },
            {
                extend: "edit",
                text: "ИЗМЕНИТЬ И ОТПРАВИТЬ",
                tabIndex: "2",
                className: 'tab4-editButton',
                action: function(e, dt, node, config) {
                    editor_blankview_edit_sub
                        .field('dognet_blankdocsub.kodblankcreate').set(0);
                    editor_blankview_edit_sub
                        .field('dognet_blankdocsub.kodblankcreate').enable();
                    // Start in edit mode, and then change to create
                    editor_blankview_edit_sub
                        .edit(table_blankview_gip_sub.rows({
                            selected: true
                        }).indexes(), {
                            title: '<h3>Изменить и отправить заявку</h3>',
                            buttons: 'Изменить и отправить'
                        })
                        .mode('edit');
                    return false;
                },
                formButtons: ['Изменить и отправить',
                    {
                        text: 'Отмена',
                        action: function() {
                            this.close();
                        }
                    }
                ]
            },
            {
                extend: "selected",
                text: 'ДУБЛИРОВАТЬ',
                tabIndex: "3",
                className: 'tab4-duplicateButton',
                action: function(e, dt, node, config) {

                    editor_blankview_edit_sub
                        .field('dognet_blankdocsub.kodblankcreate').set(0);
                    editor_blankview_edit_sub
                        .field('dognet_blankdocsub.kodblankcreate').disable();
                    // Start in edit mode, and then change to create
                    editor_blankview_edit_sub
                        .edit(table_blankview_gip_sub.rows({
                            selected: true
                        }).indexes(), {
                            title: '<h3>Дублировать заявку на основе выбранной</h3>',
                            buttons: 'Создать дубликат'
                        })
                        .mode('create');
                }
            },
            {
                extend: "remove",
                name: "tab4-removeButton",
                editor: editor_blankview_edit_sub,
                text: "УДАЛИТЬ",
                tabIndex: "4",
                className: 'tab4-removeButton'
            }
        ],
        rowGroup: {
            startRender: function(rows, group, level) {

                if (level == 0) {
                    if (group !== "No group") {
                        return '<span style="text-align:left; white-space:nowrap">Бланк № _ ' +
                            group +
                            '</span>';
                    } else {
                        return '<span class="text-danger" style="text-align:left; white-space:nowrap">Заявки, не отправленные в ОД</span>';

                    }
                }

            },
            endRender: function(rows, group, level) {},
            dataSrc: ["dognet_docblankwork.numberblankwork"]
        },
        createdRow: function(row, data, index) {

        },
        initComplete: function() {

        },
        drawCallback: function() {

        }

    });
    //
    // ----- ----- ----- ----- -----
    // Array to track the ids of the edit displayed rows
    var detailRows_sub = [];
    $('#blankview-gip-sub-table tbody').on('click', 'tr td.details-control',
        function() {
            var tr = $(this).closest('tr');
            var row = table_blankview_gip_sub.row(tr);
            var idx = $.inArray(tr.attr('id'), detailRows_sub);

            if (row.child.isShown()) {
                tr.removeClass('edit');
                row.child.hide();

                // Remove from the 'open' array
                detailRows_sub.splice(idx, 1);
            } else {
                tr.addClass('edit');
                rowData = table_blankview_gip_sub.row(row);
                d = row.data();
                rowData.child(<?php include('templates/blankview-gip-sub-blanktemplate-table.tpl'); ?>)
                    .show();
                // Add to the 'open' array
                if (idx === -1) {
                    detailRows_sub.push(tr.attr('id'));
                }
            }
        });
    //
    // ----- ----- ----- ----- -----
    // On each draw, loop over the `detailRows_sub` array and show any child rows
    table_blankview_gip_sub.on('draw', function() {
        $.each(detailRows_sub, function(i, id) {
            $('#' + id + ' td.details-control').trigger('click');
        });
    });
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    //
    //
    //
    //
    //
    //
    //
    //
    //
    //
    //
    //
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    // БЛАНКИ ДЛЯ ПЕЧАТИ ::: Редактор
    var editor_blankview_gip_sub_docfiles = new $.fn.dataTable.Editor({
        display: "bootstrap",
        ajax: "php/examples/php/blankview/blankview-gip/dognet-blankview-gip-sub-docfiles-process.php",
        table: "#blankview-gip-sub-docfiles-table",
        i18n: {
            create: {
                title: "<h3>Прикрепить документ</h3>",
                button: "Прикрепить файл",
                submit: "Прикрепить",
            },
            remove: {
                title: "<h3>Удалить документ</h3>",
                button: "Удалить файл",
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
        template: '#customForm_docfiles_sub',
        fields: []
    });
    //
    // Изменяем размер диалогового окна редактирования
    editor_blankview_gip_sub_docfiles.on('open', function() {
        $(".modal-dialog").css({
            "width": "30%",
            "margin": "0em 70%",
            "min-width": "360px",
            "max-width": "480px"
        });
    });
    //
    // ----- ----- -----
    // БЛАНКИ ДЛЯ ПЕЧАТИ ::: Таблица данных
    var table_blankview_gip_sub_docfiles = $('#blankview-gip-sub-docfiles-table').DataTable({
        dom: "<'row'<'col-sm-5'B><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-4'><'col-sm-8'>>",
        // 		dom: "<'space50'r>tip",
        language: {
            url: "php/examples/simple/blankview/blankview-gip/dt_russian-tab4_sub-docfiles.json"
        },
        ajax: {
            url: "php/examples/php/blankview/blankview-gip/dognet-blankview-gip-sub-docfiles-process.php",
            type: 'post',
            data: function(d) {
                var selected = table_blankview_gip_sub.row({
                    selected: true
                });
                if (selected.any()) {
                    d.kodblankwork = selected.data().dognet_blankdocsub.kodblankwork;
                    console.log("Kodblankwork (" + selected.id() + ") :: kodblankwork: " + d
                        .kodblankwork);
                }
            }
        },
        serverSide: true,
        columns: [{
                data: "dognet_docblankwork_files.blank_status",
                className: "text-center"
            },
            {
                data: "dognet_docblankwork_files.file_name",
                className: "text-center"
            },
            {
                data: "dognet_docblankwork_files.file_extension",
                className: "text-center"
            }
        ],
        select: {
            style: 'os',
            selector: 'td:not(:last-child)' // no row selection on last column
        },
        columnDefs: [{
                orderable: false,
                searchable: false,
                render: function(data) {
                    if (data == 'CR' || data == 'GIP') {
                        return '<span class="label label-default text-uppercase">ГИП</span>';
                    }
                    if (data == 'RD' || data == 'DO') {
                        return '<span class="label label-danger text-uppercase">ДОГ</span>';
                    } else {
                        return '<span class="label label-default text-uppercase">???</span>';
                    }
                },
                targets: 0
            },
            {
                orderable: false,
                searchable: false,
                render: function(data, type, row, meta) {
                    return '<a class="blank_link" href="' + row
                        .dognet_docblankwork_files
                        .file_url + '" target="_blank">' + row
                        .dognet_sysdefs_blankstatus
                        .status_description + '</a>';
                },
                targets: 1
            },
            {
                orderable: false,
                searchable: false,
                render: function(data, type, row, meta) {
                    return '<span class="label label-primary">' + data + '</span>';
                },
                targets: 2
            }
        ],
        select: false,
        processing: false,
        paging: false,
        searching: false,
        buttons: [{
                extend: "create",
                editor: editor_blankview_gip_sub_docfiles,
                text: '<span class="glyphicon glyphicon-plus"></span>',
                formButtons: ['Прикрепить файл',
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
                editor: editor_blankview_gip_sub_docfiles,
                text: '<span class="glyphicon glyphicon-remove"></span>',
                formButtons: ['Удалить файл',
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
        drawCallback: function(settings) {

        }
    });
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    //
    //
    //
    //
    //
    //
    //
    //
    //
    //
    //
    //
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    // ПРИКРЕПЛЯЕМЫЕ ФАЙЛЫ К БЛАНКУ ::: Редактор
    var editor_blankview_gip_sub_blankpril = new $.fn.dataTable.Editor({
        display: "bootstrap",
        ajax: {
            url: "php/examples/php/blankview/blankview-gip/dognet-blankview-gip-sub-blankpril-process.php",
            data: function(d) {
                var selected = table_blankview_gip_sub.row({
                    selected: true
                });
                if (selected.any()) {
                    d.kodblankwork = selected.data().dognet_blankdocsub.kodblankwork;
                }
            }
        },
        table: "#blankview-gip-sub-blankpril-table",
        i18n: {
            create: {
                title: "<h3>Прикрепить файл</h3>"
            },
            edit: {
                title: "<h3>Изменить запись о файле</h3>"
            },
            remove: {
                button: "Удалить",
                title: "<h3>Удалить файл</h3>",
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
        template: '#customForm_blankworkpril_sub',
        fields: [{
            name: "dognet_blankworkpril.docFileID",
            type: "upload",
            display: function(id) {
                return '<div class="lnkDocFileID"><a target="_blank" href="' +
                    editor_blankview_gip_sub_blankpril.file(
                        'dognet_blankworkpril_files',
                        id).file_webpath + '">Прикрепленный файл</a></div>';
            },
            dragDrop: false,
            fileReadText: 'Загрузка файла',
            processingText: 'Обработка файла',
            uploadText: 'Прикрепить новый файл',
            clearText: 'Удалить файл',
            noFileText: 'Нет файла'
        }, {
            type: "readonly",
            name: "dognet_blankworkpril.msgDocFileID"
        }, {
            label: "Бланк :",
            name: "dognet_blankworkpril.kodblankwork",
            type: "hidden",
            placeholder: "Выберите бланк"
        }, {
            label: "Описание документа",
            name: "dognet_blankworkpril.namepril",
            type: "textarea"
        }]
    });
    //
    // Изменяем размер диалогового окна редактирования
    editor_blankview_gip_sub_blankpril.on('open', function() {
        $(".modal-dialog").css({
            "width": "30%",
            "margin": "1.3em 70%",
            "min-width": "360px",
            "max-width": "480px"
        });
    });
    //
    // Подготавливаем форму для работы
    editor_blankview_gip_sub_blankpril.on('initCreate', function(e) {
        editor_blankview_gip_sub_blankpril.field('dognet_blankworkpril.msgDocFileID').show();
        editor_blankview_gip_sub_blankpril.field('dognet_blankworkpril.msgDocFileID').val(
            'Сначала создайте запись!');
        editor_blankview_gip_sub_blankpril.field('dognet_blankworkpril.docFileID').hide();
        editor_blankview_gip_sub_blankpril.field('dognet_blankworkpril.docFileID').disable();

        selected_sub = table_blankview_gip_sub.row({
            selected: true
        });
        if (selected_sub.any()) {
            kodblankwork_sub = selected_sub.data().dognet_blankdocsub.kodblankwork;
        }
        editor_blankview_gip_sub_blankpril.field('dognet_blankworkpril.kodblankwork').val(
            kodblankwork_sub);
    });
    editor_blankview_gip_sub_blankpril.on('initEdit', function(e, node, data, items, type) {
        editor_blankview_gip_sub_blankpril.field('dognet_blankworkpril.msgDocFileID').hide();
        editor_blankview_gip_sub_blankpril.field('dognet_blankworkpril.docFileID').show();
        editor_blankview_gip_sub_blankpril.field('dognet_blankworkpril.docFileID').enable();

        selected_sub = table_blankview_gip_sub.row({
            selected: true
        });
        if (selected_sub.any()) {
            kodblankwork_sub = selected_sub.data().dognet_blankdocsub.kodblankwork;
        }
        editor_blankview_gip_sub_blankpril.field('dognet_blankworkpril.kodblankwork').val(
            kodblankwork_sub);
    });
    // ----- ----- -----
    // ПРИКРЕПЛЯЕМЫЕ ФАЙЛЫ К БЛАНКУ ::: Таблица данных
    var table_blankview_gip_sub_blankpril = $('#blankview-gip-sub-blankpril-table').DataTable({
        dom: "<'row'<'col-sm-5'B><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-4'><'col-sm-8'>>",
        // 		dom: "<'space50'r>tip",
        language: {
            url: "php/examples/simple/blankview/blankview-gip/dt_russian-tab4_sub-prilfiles.json"
        },
        ajax: {
            url: "php/examples/php/blankview/blankview-gip/dognet-blankview-gip-sub-blankpril-process.php",
            type: 'post',
            data: function(d) {
                var selected = table_blankview_gip_sub.row({
                    selected: true
                });
                if (selected.any()) {
                    d.kodblankwork = selected.data().dognet_blankdocsub.kodblankwork;
                    d.rowID = selected.id().substr(4);
                    console.log("Kodblankwork (" + selected.id() + ") :: kodblankwork: " + d
                        .kodblankwork);
                    console.log("ID (" + selected.id() + ") :: row ID: " + d.rowID);
                }
            }
        },
        serverSide: true,
        columns: [{
                data: "dognet_blankworkpril.numberpril",
                className: "text-center"
            },
            {
                data: "dognet_blankworkpril.kodtipblank",
                className: "text-center"
            },
            {
                data: "dognet_blankworkpril.namepril",
                className: "text-center"
            },
            {
                data: "dognet_blankworkpril.extfile",
                className: "text-center"
            }
        ],
        select: {
            style: 'os',
            selector: 'td:not(:last-child)' // no row selection on last column
        },
        columnDefs: [{
                orderable: false,
                searchable: false,
                targets: 0
            },
            {
                orderable: false,
                searchable: false,
                render: function(data) {
                    if (data == 'CR' || data == 'GIP') {
                        return '<span class="label label-default text-uppercase">ГИП</span>';
                    }
                    if (data == 'RD' || data == 'DO') {
                        return '<span class="label label-danger text-uppercase">ДОГ</span>';
                    } else {
                        return '<span class="label label-default text-uppercase">---</span>';
                    }
                },
                targets: 1
            },
            {
                orderable: false,
                searchable: false,
                render: function(data, type, row, meta) {
                    text_link = ((data !== "") ? data : "Файл без имени");
                    if (row.dognet_blankworkpril_files.file_url == null) {
                        return text_link;
                    } else {
                        return '<a class="blank_link" href="' + row
                            .dognet_blankworkpril_files
                            .file_url + '" target="_blank">' + text_link + '</a>';
                    }
                },
                targets: 1
            },
            {
                orderable: false,
                searchable: false,
                render: function(data, type, row, meta) {
                    return '<span class="label label-primary">' + data + '</span>';
                },
                targets: 2
            }
        ],
        select: true,
        processing: false,
        paging: false,
        searching: false,
        buttons: [{
                extend: "create",
                editor: editor_blankview_gip_sub_blankpril,
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
                editor: editor_blankview_gip_sub_blankpril,
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
                editor: editor_blankview_gip_sub_blankpril,
                text: '<span class="glyphicon glyphicon-remove"></span>'
            }
        ],
        initComplete: function() {

        },
        drawCallback: function() {

        }
    });
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    //
    //
    //
    //
    //
    //
    //
    //
    //
    //
    //
    //
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    // ДОПОЛНИТЕЛЬНЫЕ СУММЫ К БЛАНКУ ::: Редактор
    var editor_blankview_gip_sub_summadop = new $.fn.dataTable.Editor({
        display: "bootstrap",
        ajax: {
            url: "php/examples/php/blankview/blankview-gip/dognet-blankview-gip-sub-summadop-process.php",
            data: function(d) {
                var selected = table_blankview_gip_sub.row({
                    selected: true
                });
                if (selected.any()) {
                    d.kodblankwork = selected.data().dognet_blankdocsub.kodblankwork;
                    d.kodtipblank = selected.data().dognet_blankdocsub.kodtipblank;
                    d.rowID = selected.id().substr(4);
                }
            }
        },
        table: "#blankview-gip-sub-summadop-table",
        i18n: {
            create: {
                title: "<h3>Добавить новую сумму</h3>"
            },
            edit: {
                title: "<h3>Изменить сумму</h3>"
            },
            remove: {
                button: "Удалить",
                title: "<h3>Удалить сумму</h3>",
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
        template: '#customForm_blanksummadop_sub',
        fields: [{
            label: "Бланк :",
            name: "dognet_blanksummadop.kodblankwork",
            type: "select",
            placeholder: "Выберите бланк"
        }, {
            label: "Описание :",
            name: "dognet_blanksummadop.namesummadop"
        }, {
            label: "Сумма :",
            name: "dognet_blanksummadop.summadopblank"
        }]
    });
    //
    // Изменяем размер диалогового окна редактирования
    editor_blankview_gip_sub_summadop.on('open', function() {
        $(".modal-dialog").css({
            "width": "60%",
            "margin": "1.0em auto",
            "min-width": "640px",
            "max-width": "800px"
        });
    });
    // ----- ----- -----
    // ДОПОЛНИТЕЛЬНЫЕ СУММЫ К БЛАНКУ ::: Таблица данных
    var table_blankview_gip_sub_summadop = $('#blankview-gip-sub-summadop-table').DataTable({
        dom: "<'row'<'col-sm-5'B><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-4'><'col-sm-8'>>",
        // 		dom: "<'space50'r>tip",
        language: {
            url: "php/examples/simple/blankview/blankview-gip/dt_russian-tab4_sub-summadop.json"
        },
        ajax: {
            url: "php/examples/php/blankview/blankview-gip/dognet-blankview-gip-sub-summadop-process.php",
            type: 'post',
            data: function(d) {
                var selected = table_blankview_gip_sub.row({
                    selected: true
                });
                if (selected.any()) {
                    d.kodblankwork = selected.data().dognet_blankdocsub.kodblankwork;
                    d.kodtipblank = selected.data().dognet_blankdocsub.kodtipblank;
                    d.rowID = selected.id().substr(4);
                }
            }
        },
        serverSide: true,
        columns: [{
                data: "dognet_blanksummadop.kodsummadop",
                className: "text-center"
            },
            {
                data: "dognet_blanksummadop.kodtipblank",
                className: "text-center"
            },
            {
                data: "dognet_blanksummadop.namesummadop",
                className: "text-center"
            },
            {
                data: "dognet_blanksummadop.summadopblank",
                className: "text-center"
            }
        ],
        select: {
            style: 'single',
            selector: 'td:not(:last-child)' // no row selection on last column
        },
        columnDefs: [{
                orderable: false,
                searchable: false,
                targets: 0
            },
            {
                orderable: false,
                searchable: false,
                render: function(data) {
                    if (data == 'CR' || data == 'GIP') {
                        return '<span class="label label-default text-uppercase">ГИП</span>';
                    }
                    if (data == 'RD' || data == 'DO') {
                        return '<span class="label label-danger text-uppercase">ДОГ</span>';
                    } else {
                        return '<span class="label label-default text-uppercase">---</span>';
                    }
                },
                targets: 1
            },
            {
                orderable: false,
                searchable: false,
                targets: 2
            },
            {
                orderable: false,
                searchable: false,
                targets: 3
            }
        ],
        select: true,
        processing: false,
        paging: false,
        searching: false,
        buttons: [{
                extend: "create",
                editor: editor_blankview_gip_sub_summadop,
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
                editor: editor_blankview_gip_sub_summadop,
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
                editor: editor_blankview_gip_sub_summadop,
                text: '<span class="glyphicon glyphicon-remove"></span>'
            }
        ],
        initComplete: function() {

        },
        drawCallback: function() {

        }
    });
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    //
    //
    //
    //
    //
    //
    //
    //
    //
    //
    //
    //
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    table_blankview_gip_sub.on('select', function(e, dt, type, indexes) {

        if (type === 'row') {
            var rows = table_blankview_gip_sub.rows(indexes).nodes().to$();
            $.each(rows, function() {
                if (table_blankview_gip_sub.row($(this)).data().dognet_blankdocsub
                    .kodblankcreate === "1") {
                    table_blankview_gip_sub.row($(this)).deselect();
                }
            })
        }



        table_blankview_gip_sub.buttons().enable();
        table_blankview_gip_sub_summadop.buttons().enable();
        table_blankview_gip_sub_summadop.ajax.reload();
        table_blankview_gip_sub_docfiles.buttons().disable();
        table_blankview_gip_sub_docfiles.ajax.reload();
        table_blankview_gip_sub_blankpril.buttons().enable();
        table_blankview_gip_sub_blankpril.ajax.reload();
    });
    table_blankview_gip_sub.on('deselect', function() {
        table_blankview_gip_sub_summadop.buttons().disable();
        table_blankview_gip_sub_summadop.ajax.reload();
        table_blankview_gip_sub_docfiles.buttons().disable();
        table_blankview_gip_sub_docfiles.ajax.reload();
        table_blankview_gip_sub_blankpril.buttons().disable();
        table_blankview_gip_sub_blankpril.ajax.reload();
    });
    table_blankview_gip_sub.on('init', function() {
        table_blankview_gip_sub_summadop.buttons().disable();
        table_blankview_gip_sub_docfiles.buttons().disable();
        table_blankview_gip_sub_blankpril.buttons().disable();
    });
    //
    editor_blankview_edit_sub.on('initEdit', function() {
        console.log('initEdit OK');
    });
    editor_blankview_edit_sub.on('postEdit', function() {
        console.log('postEdit OK');
    });
    editor_blankview_edit_sub.on('submitSuccess', function() {
        console.log('submitSuccess OK');
    });
    editor_blankview_edit_sub.on('submitError', function() {
        if (editor_blankview_edit_sub.field('sendEmailSUB').val() == 1) {
            console.log('submitError OK / Form closed');
            /* 			editor_blankview_edit_sub.close(); */
        } else {
            console.log('submitError OK');
        }
    });


    editor_blankview_edit_sub.on('preSubmit', function(e, data, action) {
        // let newObj = JSON.parse( data );
        let newObj1 = JSON.parse(JSON.stringify(data));
        let newObj2 = JSON.stringify(data);
        // console.log( "json: "+json.data[0].dognet_blankdocsub.namedocblank );
        // console.log( "newObj: "+newObj );
        // console.log( "newObj1: "+newObj1 );
        // console.log( "data: "+data );
        // console.log( "newObj2: "+newObj2 );

        var ids = (editor_blankview_edit_sub.ids(true) + '').substr(1);
        // console.log("ids: "+ids);
        var x = ids.split('_');
        // console.log("x: "+x[0]+"..."+x[1]);
        var rowid = parseInt(x[1], 10);
        // console.log("rowid: "+rowid);
        // console.log("data: "+data.data[ids].dognet_blankdocsub.namedocblank);


        // Осуществляем глубокое копирование объекта и инициализируем переменную
        if ((action === "create") && editor_blankview_edit_sub.field(
                'dognet_blankdocsub.kodblankcreate').val() == 1 && editor_blankview_edit_sub.field(
                'sendEmailSUB').val() == 1) {
            console.log("action1: " + action);
            /* 			console.log( "data: "+data.data[0].dognet_blankdocsub.namedocblank ); */
            // ТИП БЛАНКА
            _blanktip = "Субподряд";
            // ОПИСАНИЕ БЛАНКА
            _blankname = data.data[0].dognet_blankdocsub.namedocblank;
            // ИМЯ ГИПа
            _ispolname = data.data[0].dognet_blankdocsub.kodispol;
            // ИМЯ РУКОВОДИТЕЛЯ
            _ispolrukname = data.data[0].dognet_blankdocsub.kodispolruk;
            // НАЗВАНИЕ ОБЪЕКТА
            _objname = "";
            // НАЗВАНИЕ ЗАКАЗЧИКА
            if (data.data[0].dognet_blankdocsub.kodusespzakaz == '1') {
                _zakname = data.data[0].dognet_blankdocsub.kodzakaz;
            } else if (data.data[0].dognet_blankdocsub.koduseneworg == '1') {
                _zakname = data.data[0].dognet_blankdocsub.nameneworg;
            } else {
                _zakname = "";
            }
            // СУММА БЛАНКА
            _summablank = data.data[0].dognet_blankdocsub.csummadocopl;
            _summablank = $.fn.dataTable.render.number(' ', ',', 2, '').display(_summablank);

            ajaxRequest_sendMailSUB(_blanktip, _blankname, _ispolname, _ispolrukname, _objname,
                _zakname, _summablank, 'sendMail');

        }
        // Осуществляем глубокое копирование объекта и инициализируем переменную
        else if ((action === "edit") && editor_blankview_edit_sub.field(
                'dognet_blankdocsub.kodblankcreate').val() == 1 && editor_blankview_edit_sub.field(
                'sendEmailSUB').val() == 1) {

            var ids = (editor_blankview_edit_sub.ids(true) + '').substr(1);
            // console.log("ids: "+ids);
            // console.log("action2: "+action);
            // ТИП БЛАНКА
            _blanktip = "Субподряд";
            // ОПИСАНИЕ БЛАНКА
            _blankname = data.data[ids].dognet_blankdocsub.namedocblank;
            // console.log("_blankname: "+_blankname);

            // ИМЯ ГИПа
            _ispolname = data.data[ids].dognet_blankdocsub.kodispol;
            // console.log("_ispolname: "+_ispolname);

            // ИМЯ РУКОВОДИТЕЛЯ
            _ispolrukname = data.data[ids].dognet_blankdocsub.kodispolruk;
            // console.log("_ispolrukname: "+_ispolrukname);

            // НАЗВАНИЕ ОБЪЕКТА
            _objname = "";
            // console.log("_objname: "+_objname);

            // НАЗВАНИЕ ЗАКАЗЧИКА
            if (data.data[ids].dognet_blankdocsub.kodusespzakaz == '1') {
                _zakname = data.data[ids].dognet_blankdocsub.kodzakaz;
            } else if (data.data[ids].dognet_blankdocsub.koduseneworg == '1') {
                _zakname = data.data[ids].dognet_blankdocsub.nameneworg;
            } else {
                _zakname = "";
            }
            // console.log("kodusespzakaz: "+data.data[ids].dognet_blankdocsub.kodusespzakaz);
            // console.log("koduseneworg: "+data.data[ids].dognet_blankdocsub.koduseneworg);
            // console.log("_zakname: "+_zakname);

            // СУММА БЛАНКА
            _summablank = data.data[ids].dognet_blankdocsub.csummadocopl;
            _summablank = $.fn.dataTable.render.number(' ', ',', 2, '').display(_summablank);
            // console.log("_summablank: "+_summablank);

            ajaxRequest_sendMailSUB(_blanktip, _blankname, _ispolname, _ispolrukname, _objname,
                _zakname, _summablank, 'sendMail');

        }
    });


});
</script>
<?php
// ----- ----- ----- ----- -----
// Подключаем стили для форм и таблиц
// :::
?>
<link rel="stylesheet"
      href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/blankview/blankview-gip/restr_3/tabs/css/blankview-gip-tab4_sub.css">
<link rel="stylesheet"
      href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/blankview/blankview-gip/restr_3/tabs/css/blankview-gip-tab4_summadop.css">
<link rel="stylesheet"
      href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/blankview/blankview-gip/restr_3/tabs/css/blankview-gip-tab4_doc_files.css">
<link rel="stylesheet"
      href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/blankview/blankview-gip/restr_3/tabs/css/blankview-gip-tab4_pril_files.css">
<?php
// ----- ----- ----- ----- -----
// Форма редактирования заявки/бланка
// :::
?>
<div id="customForm_newblank_sub">
    <div id="newblank-sub-tabs" style="width:100%">
        <ul id="newblank-sub-tabs-menu" class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#sub-tab-1" title="">Основное</a></li>
            <li><a data-toggle="tab" href="#sub-tab-2" title="">Суммы</a></li>
            <li><a data-toggle="tab" href="#sub-tab-3" title="">Приложения</a></li>
            <li><a data-toggle="tab" href="#sub-tab-4" title="">Исполнение</a></li>
            <li><a data-toggle="tab" href="#sub-tab-10" title="">Условия</a></li>
            <li><a data-toggle="tab" href="#sub-tab-5" title="">Контакты</a></li>
            <li><a data-toggle="tab" href="#sub-tab-6" title="">Командировки</a></li>
            <li><a data-toggle="tab" href="#sub-tab-7" title="">Транспорт</a></li>
            <li><a data-toggle="tab" href="#sub-tab-8" title="">ДО</a></li>
            <li><a data-toggle="tab" href="#sub-tab-9" title="">Риски</a></li>
        </ul>
        <div class="tab-content" style="padding:5px">

            <div class="Section"
                 style="background:#ddd; color:#000; margin-bottom:10px; border-bottom:2px #b95959 solid">
                <div class="Block80">
                    <div class="Block100 fieldset-table-row">
                        <div class="fieldset-table-cell" style="padding-bottom:3px">
                            <fieldset>
                                <editor-field name="dognet_blankdocsub.kodblankcreate"></editor-field>
                            </fieldset>
                        </div>
                        <div class="fieldset-table-cell" style="width:100%">
                            <div>
                                <div class="chekbox-inline-text">Отправить заявку в Отдел договоров. После этого
                                    редактирование бланка будет уже невозможно!</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="div-sendEmail-sub" class="Block20" style="display:none">
                    <div class="Block100 fieldset-table-row">
                        <div class="fieldset-table-cell" style="padding-bottom:3px">
                            <fieldset>
                                <editor-field name="sendEmailSUB"></editor-field>
                            </fieldset>
                        </div>
                        <div class="fieldset-table-cell" style="width:100%">
                            <div>
                                <div class="chekbox-inline-text">Уведомить ОД по email</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="sub-tab-1" class="tab-pane fade in active">

                <div class="Section">
                    <div class="Block30">
                        <legend>Исполнители</legend>
                        <fieldset class="field100">
                            <editor-field name="dognet_blankdocsub.kodispolruk"></editor-field>
                        </fieldset>
                        <fieldset class="field100">
                            <editor-field name="dognet_blankdocsub.kodispol"></editor-field>
                        </fieldset>
                    </div>
                    <div class="Block70">
                        <legend>Организация</legend>
                        <div class="Block100">
                            <fieldset class="field30">
                                <editor-field name="dognet_blankdocsub.kodusespzakaz"></editor-field>
                            </fieldset>
                            <fieldset class="field40">
                                <editor-field name="dognet_blankdocsub.kodzakaz"></editor-field>
                            </fieldset>
                            <fieldset class="field30 kodzakazFilter" style="padding-top:30px; padding-right:15px">
                                <input id="kodzakaz_filter_sub" type="text" placeholder="Поиск" />
                            </fieldset>
                        </div>
                        <div class="Block100">
                            <fieldset class="field30">
                                <editor-field name="dognet_blankdocsub.koduseneworg"></editor-field>
                            </fieldset>
                            <fieldset class="field70">
                                <editor-field name="dognet_blankdocsub.nameneworg"></editor-field>
                            </fieldset>
                        </div>
                    </div>
                    <div class="Block100">
                        <legend>Название договора</legend>
                        <fieldset class="field100">
                            <editor-field name="dognet_blankdocsub.namedocblank"></editor-field>
                        </fieldset>
                    </div>
                </div>

            </div>
            <div id="sub-tab-2" class="tab-pane fade">

                <div class="Section">
                    <div class="Block20">
                        <legend>Сумма договора</legend>
                        <div class="Block100">
                            <fieldset class="field100">
                                <editor-field name="dognet_blankdocsub.csummadocopl"></editor-field>
                            </fieldset>
                        </div>
                        <div class="Block100 fieldset-table-row">
                            <div class="fieldset-table-cell" style="padding-bottom:3px">
                                <fieldset>
                                    <editor-field name="dognet_blankdocsub.kodusendsopl"></editor-field>
                                </fieldset>
                            </div>
                            <div class="fieldset-table-cell" style="width:100%">
                                <div>
                                    <div class="chekbox-inline-text">Без НДС</div>
                                </div>
                            </div>
                        </div>
                        <div class="Block100 fieldset-table-row">
                            <div class="fieldset-table-cell" style="padding-bottom:3px">
                                <fieldset>
                                    <editor-field name="dognet_blankdocsub.kodusespechopl"></editor-field>
                                </fieldset>
                            </div>
                            <div class="fieldset-table-cell" style="width:100%">
                                <div>
                                    <div class="chekbox-inline-text">Со спецификацией</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="Block80">
                        <legend>Порядок оплаты</legend>
                        <div id="useopl1usl" class="Block40"
                             style="outline:1px dashed #ccc; outline-offset:-4px; padding:4px 8px">
                            <fieldset class="field100">
                                <div class="fieldset-info">Оплата авансом в размере X процентов</div>
                            </fieldset>
                            <fieldset class="field40">
                                <editor-field name="dognet_blankdocsub.koduseopl1usl"></editor-field>
                            </fieldset>
                            <fieldset class="field60">
                                <editor-field name="dognet_blankdocsub.csummaopl1usl"></editor-field>
                            </fieldset>
                        </div>
                        <div id="useopl2usl" class="Block60"
                             style="outline:1px dashed #ccc; outline-offset:-4px; padding:4px 8px">
                            <fieldset class="field100">
                                <div class="fieldset-info">Окончательная оплата в размере X процентов в течение N дней
                                    после подписания акта</div>
                            </fieldset>
                            <fieldset class="field30">
                                <editor-field name="dognet_blankdocsub.koduseopl2usl"></editor-field>
                            </fieldset>
                            <fieldset class="field40">
                                <editor-field name="dognet_blankdocsub.csummaopl2usl"></editor-field>
                            </fieldset>
                            <fieldset class="field30">
                                <editor-field name="dognet_blankdocsub.cnumberoplday2usl"></editor-field>
                            </fieldset>
                        </div>
                        <div id="useopl3usl" class="Block40"
                             style="outline:1px dashed #ccc; outline-offset:-4px; padding:4px 8px">
                            <fieldset class="field100">
                                <div class="fieldset-info">В течение N дней после получения финансирования от конечного
                                    Заказчика</div>
                            </fieldset>
                            <fieldset class="field40">
                                <editor-field name="dognet_blankdocsub.koduseopl3usl"></editor-field>
                            </fieldset>
                            <fieldset class="field60">
                                <editor-field name="dognet_blankdocsub.cnumberoplday3usl"></editor-field>
                            </fieldset>
                        </div>
                        <div id="useopl4usl" class="Block60"
                             style="outline:1px dashed #ccc; outline-offset:-4px; padding:4px 8px">
                            <fieldset class="field30">
                                <editor-field name="dognet_blankdocsub.koduseopl4usl"></editor-field>
                            </fieldset>
                            <fieldset class="field70">
                                <editor-field name="dognet_blankdocsub.ctextoplotherusl"></editor-field>
                            </fieldset>
                        </div>
                    </div>
                </div>

            </div>
            <div id="sub-tab-3" class="tab-pane fade">

                <div class="Section">
                    <div class="Block100">
                        <legend>Перечень приложений</legend>
                        <div class="Block100 fieldset-table-row">
                            <div class="fieldset-table-cell" style="padding-bottom:3px">
                                <fieldset>
                                    <editor-field name="dognet_blankdocsub.kodusepril1"></editor-field>
                                </fieldset>
                            </div>
                            <div class="fieldset-table-cell" style="width:100%">
                                <div>
                                    <div class="chekbox-inline-text">Технические требования</div>
                                </div>
                            </div>
                        </div>
                        <div class="Block100 fieldset-table-row">
                            <div class="fieldset-table-cell" style="padding-bottom:3px">
                                <fieldset>
                                    <editor-field name="dognet_blankdocsub.kodusepril2"></editor-field>
                                </fieldset>
                            </div>
                            <div class="fieldset-table-cell" style="width:100%">
                                <div>
                                    <div class="chekbox-inline-text">Календарный план</div>
                                </div>
                            </div>
                        </div>
                        <div class="Block100 fieldset-table-row">
                            <div class="fieldset-table-cell" style="padding-bottom:3px">
                                <fieldset>
                                    <editor-field name="dognet_blankdocsub.kodusepril3"></editor-field>
                                </fieldset>
                            </div>
                            <div class="fieldset-table-cell" style="width:100%">
                                <div>
                                    <div class="chekbox-inline-text">Спецификация</div>
                                </div>
                            </div>
                        </div>
                        <div class="Block100 fieldset-table-row">
                            <div class="fieldset-table-cell" style="padding-bottom:3px">
                                <fieldset>
                                    <editor-field name="dognet_blankdocsub.kodusepril4"></editor-field>
                                </fieldset>
                            </div>
                            <div class="fieldset-table-cell" style="width:100%">
                                <div>
                                    <div class="chekbox-inline-text">Протокол соглашения о договорной цене</div>
                                </div>
                            </div>
                        </div>
                        <div class="Block100 fieldset-table-row">
                            <div class="fieldset-table-cell" style="padding-bottom:3px">
                                <fieldset>
                                    <editor-field name="dognet_blankdocsub.kodusepril5"></editor-field>
                                </fieldset>
                            </div>
                            <div class="fieldset-table-cell" style="width:100%">
                                <div>
                                    <div class="chekbox-inline-text">Сметный расчет</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div id="sub-tab-4" class="tab-pane fade">

                <div class="Section">
                    <div class="Block100">
                        <legend>Исполнение</legend>
                        <div class="Block100">
                            <div class="fieldset-info">*Если точно не известен срок исполнения, выбирать "Конец года"
                            </div>
                        </div>
                        <div id="useispoldoc1" class="Block50 fieldset-table-row"
                             style="outline:1px dashed #ccc; outline-offset:-4px; padding:4px 8px">
                            <div class="fieldset-table-cell" style="padding-bottom:3px">
                                <fieldset>
                                    <editor-field name="dognet_blankdocsub.koduseispoldoc1"></editor-field>
                                </fieldset>
                            </div>
                            <div class="fieldset-table-cell" style="width:70%">
                                <div>
                                    <div class="chekbox-inline-text">Дата исполнения</div>
                                </div>
                            </div>
                            <div class="fieldset-table-cell" style="padding-bottom:3px; width:30%">
                                <fieldset>
                                    <editor-field name="dognet_blankdocsub.cdateispoldoc1"></editor-field>
                                </fieldset>
                            </div>
                        </div>
                        <div id="useispoldoc2" class="Block50 fieldset-table-row"
                             style="outline:1px dashed #ccc; outline-offset:-4px; padding:4px 8px">
                            <div class="fieldset-table-cell" style="padding-bottom:3px">
                                <fieldset>
                                    <editor-field name="dognet_blankdocsub.koduseispoldoc2"></editor-field>
                                </fieldset>
                            </div>
                            <div class="fieldset-table-cell" style="width:70%">
                                <div>
                                    <div class="chekbox-inline-text">Дней от аванса</div>
                                </div>
                            </div>
                            <div class="fieldset-table-cell" style="padding-bottom:3px; width:30%">
                                <fieldset>
                                    <editor-field name="dognet_blankdocsub.cdaysispoldoc2"></editor-field>
                                </fieldset>
                            </div>
                        </div>
                        <div id="useispoldoc3" class="Block50 fieldset-table-row"
                             style="outline:1px dashed #ccc; outline-offset:-4px; padding:4px 8px">
                            <div class="fieldset-table-cell" style="padding-bottom:3px">
                                <fieldset>
                                    <editor-field name="dognet_blankdocsub.koduseispoldoc3"></editor-field>
                                </fieldset>
                            </div>
                            <div class="fieldset-table-cell" style="width:100%">
                                <div>
                                    <div class="chekbox-inline-text">Автоматическая пролонгация</div>
                                </div>
                            </div>
                        </div>
                        <div id="useispoldoc4" class="Block50 fieldset-table-row"
                             style="outline:1px dashed #ccc; outline-offset:-4px; padding:4px 8px">
                            <div class="fieldset-table-cell" style="padding-bottom:3px">
                                <fieldset>
                                    <editor-field name="dognet_blankdocsub.koduseispoldoc4"></editor-field>
                                </fieldset>
                            </div>
                            <div class="fieldset-table-cell" style="width:100%">
                                <div>
                                    <div class="chekbox-inline-text">Конец года</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div id="sub-tab-10" class="tab-pane fade">

                <div class="Section">
                    <div class="Block100">
                        <legend>Особые условия (определяются ГИПом)</legend>
                        <fieldset class="field80">
                            <editor-field name="dognet_blankdocsub.defuslgiptext"></editor-field>
                        </fieldset>
                        <fieldset class="field20">
                            <editor-field name="dognet_blankdocsub.kodusetender"></editor-field>
                        </fieldset>
                    </div>
                </div>

            </div>
            <div id="sub-tab-5" class="tab-pane fade">

                <div class="Section">
                    <div class="Block100">
                        <legend>Контакты</legend>
                        <div class="Block50" style="padding:0 15px">
                            <div class="Block100 fieldset-table-row">
                                <div class="fieldset-table-cell" style="white-space:nowrap; width:50%">
                                    <div>
                                        <div class="chekbox-inline-text">Фамилия</div>
                                    </div>
                                </div>
                                <div class="fieldset-table-cell" style="padding-top:4px">
                                    <fieldset>
                                        <editor-field name="dognet_blankdocsub.nameendcontact"></editor-field>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="Block100 fieldset-table-row">
                                <div class="fieldset-table-cell" style="white-space:nowrap; width:50%">
                                    <div>
                                        <div class="chekbox-inline-text">Имя</div>
                                    </div>
                                </div>
                                <div class="fieldset-table-cell" style="padding-top:4px">
                                    <fieldset>
                                        <editor-field name="dognet_blankdocsub.namefistcontact"></editor-field>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="Block100 fieldset-table-row">
                                <div class="fieldset-table-cell" style="white-space:nowrap; width:50%">
                                    <div>
                                        <div class="chekbox-inline-text">Отчество</div>
                                    </div>
                                </div>
                                <div class="fieldset-table-cell" style="padding-top:4px">
                                    <fieldset>
                                        <editor-field name="dognet_blankdocsub.namesecondcontact"></editor-field>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="Block100 fieldset-table-row">
                                <div class="fieldset-table-cell" style="white-space:nowrap; width:50%">
                                    <div>
                                        <div class="chekbox-inline-text">Должность</div>
                                    </div>
                                </div>
                                <div class="fieldset-table-cell" style="padding-top:4px">
                                    <fieldset>
                                        <editor-field name="dognet_blankdocsub.namedoljcontact"></editor-field>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                        <div class="Block50" style="padding:0 15px">
                            <div class="Block100 fieldset-table-row">
                                <div class="fieldset-table-cell" style="white-space:nowrap; width:50%">
                                    <div>
                                        <div class="chekbox-inline-text">Телефон (рабочий)</div>
                                    </div>
                                </div>
                                <div class="fieldset-table-cell" style="padding-top:4px">
                                    <fieldset>
                                        <editor-field name="dognet_blankdocsub.numbertelrab"></editor-field>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="Block100 fieldset-table-row">
                                <div class="fieldset-table-cell" style="white-space:nowrap; width:50%">
                                    <div>
                                        <div class="chekbox-inline-text">Телефон (мобильный)</div>
                                    </div>
                                </div>
                                <div class="fieldset-table-cell" style="padding-top:4px">
                                    <fieldset>
                                        <editor-field name="dognet_blankdocsub.numbertelmob"></editor-field>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="Block100 fieldset-table-row">
                                <div class="fieldset-table-cell" style="white-space:nowrap; width:50%">
                                    <div>
                                        <div class="chekbox-inline-text">Факс</div>
                                    </div>
                                </div>
                                <div class="fieldset-table-cell" style="padding-top:4px">
                                    <fieldset>
                                        <editor-field name="dognet_blankdocsub.numbertelfax"></editor-field>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="Block100 fieldset-table-row">
                                <div class="fieldset-table-cell" style="white-space:nowrap; width:50%">
                                    <div>
                                        <div class="chekbox-inline-text">Email</div>
                                    </div>
                                </div>
                                <div class="fieldset-table-cell" style="padding-top:4px">
                                    <fieldset>
                                        <editor-field name="dognet_blankdocsub.nameemail"></editor-field>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div id="sub-tab-6" class="tab-pane fade">

                <div class="Section">
                    <div class="Block100">
                        <legend>Командировочные расходы</legend>
                        <div class="Block100 fieldset-table-row">
                            <div class="fieldset-table-cell" style="padding-bottom:3px">
                                <fieldset>
                                    <editor-field name="dognet_blankdocsub.kodusekomrasx1"></editor-field>
                                </fieldset>
                            </div>
                            <div class="fieldset-table-cell" style="width:100%">
                                <div>
                                    <div class="chekbox-inline-text">Входят в стоимость договора</div>
                                </div>
                            </div>
                        </div>
                        <div class="Block100 fieldset-table-row">
                            <div class="fieldset-table-cell" style="padding-bottom:3px">
                                <fieldset>
                                    <editor-field name="dognet_blankdocsub.kodusekomrasx2"></editor-field>
                                </fieldset>
                            </div>
                            <div class="fieldset-table-cell" style="width:100%">
                                <div>
                                    <div class="chekbox-inline-text">Оплачиваются отдельно по фактическим затратам</div>
                                </div>
                            </div>
                        </div>
                        <div class="Block100 fieldset-table-row">
                            <div class="fieldset-table-cell" style="padding-bottom:3px">
                                <fieldset>
                                    <editor-field name="dognet_blankdocsub.kodusekomrasx3"></editor-field>
                                </fieldset>
                            </div>
                            <div class="fieldset-table-cell" style="width:80%">
                                <div>
                                    <div class="chekbox-inline-text">Входят в стоимость с установленным лимитом</div>
                                </div>
                            </div>
                            <div class="fieldset-table-cell" style="padding-top:4px; width:20%">
                                <fieldset>
                                    <editor-field name="dognet_blankdocsub.summalimitmis"></editor-field>
                                </fieldset>
                            </div>
                        </div>
                        <div class="Block100 fieldset-table-row">
                            <div class="fieldset-table-cell" style="padding-bottom:3px">
                                <fieldset>
                                    <editor-field name="dognet_blankdocsub.kodusekomrasx4"></editor-field>
                                </fieldset>
                            </div>
                            <div class="fieldset-table-cell">
                                <div>
                                    <div class="chekbox-inline-text">Примечание</div>
                                </div>
                            </div>
                            <div class="fieldset-table-cell" style="padding-top:4px; width:100%">
                                <fieldset>
                                    <editor-field name="dognet_blankdocsub.komrasxprim"></editor-field>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div id="sub-tab-7" class="tab-pane fade">

                <div class="Section">
                    <div class="Block60">
                        <legend>Транспортные расходы</legend>
                        <div class="Block100 fieldset-table-row">
                            <div class="fieldset-table-cell" style="padding-bottom:3px">
                                <fieldset>
                                    <editor-field name="dognet_blankdocsub.kodusetrans1"></editor-field>
                                </fieldset>
                            </div>
                            <div class="fieldset-table-cell" style="width:100%">
                                <div>
                                    <div class="chekbox-inline-text">Входят в стоимость договора</div>
                                </div>
                            </div>
                        </div>
                        <div class="Block100 fieldset-table-row">
                            <div class="fieldset-table-cell" style="padding-bottom:3px">
                                <fieldset>
                                    <editor-field name="dognet_blankdocsub.kodusetrans2"></editor-field>
                                </fieldset>
                            </div>
                            <div class="fieldset-table-cell" style="width:100%">
                                <div>
                                    <div class="chekbox-inline-text">Оплачиваются отдельно по фактическим затратам</div>
                                </div>
                            </div>
                        </div>
                        <div class="Block100 fieldset-table-row">
                            <div class="fieldset-table-cell" style="padding-bottom:3px">
                                <fieldset>
                                    <editor-field name="dognet_blankdocsub.kodusetrans3"></editor-field>
                                </fieldset>
                            </div>
                            <div class="fieldset-table-cell">
                                <div>
                                    <div class="chekbox-inline-text">Иное</div>
                                </div>
                            </div>
                            <div class="fieldset-table-cell" style="padding-top:4px; width:100%">
                                <fieldset>
                                    <editor-field name="dognet_blankdocsub.transprim"></editor-field>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <div class="Block40">
                        <legend>Условия поставки</legend>
                        <fieldset class="field100">
                            <editor-field name="dognet_blankdocsub.transplaceobor"></editor-field>
                        </fieldset>
                    </div>
                </div>

            </div>
            <div id="sub-tab-8" class="tab-pane fade">

                <div class="Section">
                    <div class="Block100">
                        <legend>Дополнительные ограничения</legend>
                        <div class="Block60" style="padding:0 15px">
                            <div class="Block100 fieldset-table-row">
                                <div class="fieldset-table-cell" style="white-space:nowrap; width:80%">
                                    <div>
                                        <div class="chekbox-inline-text">Номер основного договора, если АТГС Заказчик.
                                            Договор № 3-4/</div>
                                    </div>
                                </div>
                                <div class="fieldset-table-cell" style="padding-top:4px">
                                    <fieldset>
                                        <editor-field name="dognet_blankdocsub.numberdocmain"></editor-field>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                        <div class="Block60" style="padding:0 15px">
                            <div class="Block100 fieldset-table-row">
                                <div class="fieldset-table-cell" style="white-space:nowrap; width:80%">
                                    <div>
                                        <div class="chekbox-inline-text">Ограничение по сроку оформление ( дней )</div>
                                    </div>
                                </div>
                                <div class="fieldset-table-cell" style="padding-top:4px">
                                    <fieldset>
                                        <editor-field name="dognet_blankdocsub.climitdays"></editor-field>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div id="sub-tab-9" class="tab-pane fade">

                <div class="Section">
                    <div class="Block100">
                        <legend>Результаты оценки рисков/производственной осуществимости</legend>
                        <div class="Block100 fieldset-table-row">
                            <div class="fieldset-table-cell" style="padding-bottom:3px">
                                <fieldset>
                                    <editor-field name="dognet_blankdocsub.koduserisk1"></editor-field>
                                </fieldset>
                            </div>
                            <div class="fieldset-table-cell" style="width:100%">
                                <div>
                                    <div class="chekbox-inline-text">Соблюдение сроков выполнения монтажных работ</div>
                                </div>
                            </div>
                        </div>
                        <div class="Block100 fieldset-table-row">
                            <div class="fieldset-table-cell" style="padding-bottom:3px">
                                <fieldset>
                                    <editor-field name="dognet_blankdocsub.koduserisk2"></editor-field>
                                </fieldset>
                            </div>
                            <div class="fieldset-table-cell" style="width:100%">
                                <div>
                                    <div class="chekbox-inline-text">Соблюдение сроков выполнения пуско-наладочных работ
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="Block100 fieldset-table-row">
                            <div class="fieldset-table-cell" style="padding-bottom:3px">
                                <fieldset>
                                    <editor-field name="dognet_blankdocsub.koduserisk3"></editor-field>
                                </fieldset>
                            </div>
                            <div class="fieldset-table-cell" style="width:100%">
                                <div>
                                    <div class="chekbox-inline-text">Соблюдение сроков оплаты</div>
                                </div>
                            </div>
                        </div>
                        <div class="Block100 fieldset-table-row">
                            <div class="fieldset-table-cell" style="padding-bottom:3px">
                                <fieldset>
                                    <editor-field name="dognet_blankdocsub.koduserisk4"></editor-field>
                                </fieldset>
                            </div>
                            <div class="fieldset-table-cell" style="width:100%">
                                <div>
                                    <div class="chekbox-inline-text">Обеспечение ресурсами</div>
                                </div>
                            </div>
                        </div>
                        <div class="Block100 fieldset-table-row">
                            <div class="fieldset-table-cell" style="padding-bottom:3px">
                                <fieldset>
                                    <editor-field name="dognet_blankdocsub.koduserisk5"></editor-field>
                                </fieldset>
                            </div>
                            <div class="fieldset-table-cell">
                                <div>
                                    <div class="chekbox-inline-text">Иное</div>
                                </div>
                            </div>
                            <div class="fieldset-table-cell" style="padding-top:4px; width:100%">
                                <fieldset>
                                    <editor-field name="dognet_blankdocsub.riskprim"></editor-field>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
<?php
// ----- ----- ----- ----- -----
// Форма разбиения сумм договора
// :::
?>
<div id="customForm_blanksummadop_sub">
    <div class="Section">
        <div class="Block100">
            <legend>Подсказки и помощь</legend>
        </div>
        <div class="Block100">
            <legend>Параметры документа</legend>
            <fieldset class="field25">
                <editor-field name="dognet_blanksummadop.kodblankwork"></editor-field>
            </fieldset>
            <fieldset class="field55">
                <editor-field name="dognet_blanksummadop.namesummadop"></editor-field>
            </fieldset>
            <fieldset class="field20">
                <editor-field name="dognet_blanksummadop.summadopblank"></editor-field>
            </fieldset>
        </div>
    </div>
</div>
<?php
// ----- ----- ----- ----- -----
// Форма добавления файла-вложения
// :::
?>
<div id="customForm_docfiles_sub">
    <div class="Section">
        <div class="Block100">
            <legend>Подсказки и помощь</legend>
        </div>
        <div class="Block100">
            <legend>Файл</legend>
            <fieldset class="field100">
                <editor-field name="dognet_blankworkpril.msgDocFileID"></editor-field>
            </fieldset>
            <fieldset class="field100">
                <editor-field name="dognet_blankworkpril.docFileID"></editor-field>
            </fieldset>
        </div>
        <div class="Block100">
            <legend>Параметры документа</legend>
            <fieldset class="field100">
                <editor-field name="dognet_blankworkpril.kodblankwork"></editor-field>
            </fieldset>
            <fieldset class="field100">
                <editor-field name="dognet_blankworkpril.namepril"></editor-field>
            </fieldset>
        </div>
    </div>
</div>
<?php
// ----- ----- ----- ----- -----
// Форма добавления файла-вложения
// :::
?>
<div id="customForm_blankworkpril_sub">
    <div class="Section">
        <div class="Block100">
            <fieldset class="field100">
                <editor-field name="dognet_blankworkpril.msgDocFileID"></editor-field>
            </fieldset>
            <fieldset class="field100">
                <editor-field name="dognet_blankworkpril.docFileID"></editor-field>
            </fieldset>
        </div>
        <div class="Block100">
            <fieldset class="field100">
                <editor-field name="dognet_blankworkpril.kodblankwork"></editor-field>
            </fieldset>
            <fieldset class="field100">
                <editor-field name="dognet_blankworkpril.namepril"></editor-field>
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
    <div class="space30"></div>
    <div class="demo-html"></div>
    <table id="blankview-gip-sub-table" class="table table-bordered compact display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th class="text-center"><span class='glyphicon glyphicon-list-alt'></span></th>
                <th width="" class="">Дата бланка</th>
                <th width="" class="">Бланк</th>
                <th width="" class="">Версия</th>
                <th width="" class="">Организация</th>
                <th width="" class="">Описание</th>
                <th width="" class="">Исполнитель ( рук )</th>
                <th width="" class=""></th>
            </tr>
        </thead>
    </table>
</section>
<div class="space30"></div>
<p>
    <span class="text-info space20"><b>*Теперь в этой вкладке вы также видите все свои ранее созданные бланки <u>за
                текущий год</u>, которые были вами отправлены в ОД и им обработаны. Эти бланки представлены только в
            режиме "просмотра", без возможности каких-либо действий с ними.</b></span><br>
    <span class="text-danger space20"><b>**Изменять, дублировать и удалять в этой вкладке можно только бланки, которые
            вы еще не отправили в ОД.</b></span><br>
    <span class="text-danger space20"><b>***Так как выбор уже готовых (отправленных и обработанных) бланков
            заблокирован, то посмотреть в областях ниже прикрепленные файлы, разбиение сумм и бланки для печати пока
            невозможно. Но это временно.</b></span>
</p>
<?php
//
// ----- ----- -----
//
?>
<section>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="space10"></div>
        <div id="blankview-gip-sub-summadop">
            <h3 class="space10">Разбиение суммы договора</h3>
            <div class="demo-html"></div>
            <table id="blankview-gip-sub-summadop-table" class="table table-striped" cellspacing="0" width="100%">
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
    <?php // ----- ----- ----- 
    ?>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="space10"></div>
        <div id="blankview-gip-sub-docfiles">
            <h3 class="space10">Файлы бланков для печати</h3>
            <div class="demo-html"></div>
            <table id="blankview-gip-sub-docfiles-table" class="table table-striped" cellspacing="0" width="100%">
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
    <?php // ----- ----- ----- 
    ?>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="space10"></div>
        <div id="blankview-gip-sub-blankpril">
            <h3 class="space10">Прикрепленные к бланку файлы</h3>
            <div class="demo-html"></div>
            <table id="blankview-gip-sub-blankpril-table" class="table table-striped" cellspacing="0" width="100%">
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
</section>