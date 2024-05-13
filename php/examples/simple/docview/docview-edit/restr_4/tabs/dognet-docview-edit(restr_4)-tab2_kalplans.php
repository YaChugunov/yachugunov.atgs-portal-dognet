<script type="text/javascript" language="javascript" class="init">
    var editor_tab2_kalplans; // use a global for the submit and return data rendering in the examples
    var table_tab2_kalplans; // use a global for the submit and return data rendering in the examples
    var uniqueID = <?php echo $_SESSION['uniqueID']; ?>;
    //
    var reqField1 = {
        kodtip: function(response1) {
            $('#ajaxResponseOut1').html(response1.replace(new RegExp("\\r?\\n", "g"), ""));
        }
    };
    var reqField2 = {
        sumdiff: function(response2) {
            $('#ajaxResponseOut2').html(response2.replace(new RegExp("\\r?\\n", "g"), ""));
        }
    };
    var reqField3 = {
        firstavans: function(response) {}
    };
    //
    function ajaxRequest_kodtip(data, responseHandler) {
        var response1 = false;

        // Fire off the request to /form.php
        request1 = $.ajax({
            url: "php/examples/simple/docview/docview-edit/restr_4/tabs/process/dognet-docview-edit(restr_4)-tab2_kalplans_fetch-process.php",
            type: "post",
            cache: false,
            data: {
                koddoc: data
            },
            success: reqField1[responseHandler]
        });
        // Callback handler that will be called on success
        request1.done(function(response1, textStatus, jqXHR) {
            console.log("Ого! Работает! : " + textStatus);
        });
        // Callback handler that will be called on failure
        request1.fail(function(jqXHR, textStatus, errorThrown) {
            console.error(
                "The following error occurred: " +
                textStatus, errorThrown
            );
        });
        // Callback handler that will be called regardless
        // if the request failed or succeeded
        request1.always(function() {

        });

    }

    function ajaxRequest_sumdiff(data1, data2, data3, data4, responseHandler) {
        var response2 = false;

        // Fire off the request to /form.php
        request2 = $.ajax({
            url: "php/examples/simple/docview/docview-edit/restr_4/tabs/process/dognet-docview-edit(restr_4)-tab2_kalplans_fetch2-process.php",
            type: "post",
            cache: false,
            data: {
                action: data1,
                koddoc: data2,
                kodkalplan: data3,
                sum: data4
            },
            success: reqField2[responseHandler]
        });
        // Callback handler that will be called on success
        request2.done(function(response2, textStatus, jqXHR) {
            console.log("Ого! Работает! : " + textStatus);
            res = response2.replace(new RegExp("\\r?\\n", "g"), "");
            console.log("Response2 : " + data1 + " / " + data2 + " / " + data3 + " >>> " + res);

            var x = res.split(' / ');
            var doc_summa = x[0];
            var stage_summa = x[1];
            var diff_summa = x[2];
            var diff = (parseFloat(diff_summa) < 0) ?
                '<span class="" style="color:#fff; padding:2px 5px; background-color:#951302">' + diff_summa +
                '</span>' : '<span class="" style="color:#fff; padding:2px 5px; background-color:#46a512">' +
                diff_summa + '</span>';

            // editor_tab2_kalplans.field('dognet_dockalplan.summastage').message(res);
            $('#sumctrl_msg').html(doc_summa + " / " + stage_summa + " / " + diff);

        });
        // Callback handler that will be called on failure
        request2.fail(function(jqXHR, textStatus, errorThrown) {
            console.error(
                "The following error occurred: " +
                textStatus, errorThrown
            );
        });
        // Callback handler that will be called regardless
        // if the request failed or succeeded
        request2.always(function() {

        });

    }

    function ajaxRequest_sumstages(data1, data2, data3, data4, responseHandler) {
        var response2 = false;

        // Fire off the request to /form.php
        request2 = $.ajax({
            url: "php/examples/simple/docview/docview-edit/restr_4/tabs/process/dognet-docview-edit(restr_4)-tab2_kalplans_fetch2-process.php",
            type: "post",
            cache: false,
            data: {
                action: data1,
                koddoc: data2,
                kodkalplan: data3,
                sum: data4
            },
            success: reqField2[responseHandler]
        });
        // Callback handler that will be called on success
        request2.done(function(response2, textStatus, jqXHR) {
            console.log("Ого! Работает! : " + textStatus);
            res = response2.replace(new RegExp("\\r?\\n", "g"), "");
            console.log("Response2 : " + data1 + " / " + data2 + " / " + data3 + " >>> " + res);

            var x = res.split(' / ');
            var doc_summa = x[0];
            var stage_summa = x[1];
            var diff_summa = x[2];
            var diff = (parseFloat(diff_summa) != 0) ?
                '<span title="Контрольная разница между суммой договора и суммой всех этапов по договору" class="" style="color:#fff; padding:2px 5px; background-color:#951302">' +
                diff_summa +
                '</span>' :
                '<span title="Контрольная разница между суммой договора и суммой всех этапов по договору" class="" style="color:#fff; padding:2px 5px; background-color:#46a512">' +
                diff_summa + '</span>';

            // editor_tab2_kalplans.field('dognet_dockalplan.summastage').message(res);
            $('#sumctrl_title').html(doc_summa + " / " + stage_summa + " / " + diff);

        });
        // Callback handler that will be called on failure
        request2.fail(function(jqXHR, textStatus, errorThrown) {
            console.error(
                "The following error occurred: " +
                textStatus, errorThrown
            );
        });
        // Callback handler that will be called regardless
        // if the request failed or succeeded
        request2.always(function() {

        });

    }

    function ajaxRequest_firstavans(data, responseHandler) {
        var response = false;

        // Fire off the request to /form.php
        request = $.ajax({
            url: "php/examples/simple/docview/docview-edit/restr_4/tabs/php/dognet-reqAjax-getFromDB-firstavans.php",
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
                $('#ajaxFirstAvansOut').html("1-ый аванс поступил " + moment(av1date, 'YYYY-MM-DD').format(
                    'DD.MM.YYYY') + " на сумму " + av1summa);
                window.firstavans_date = moment(av1date, 'YYYY-MM-DD');
            } else {
                $('#ajaxFirstAvansOut').html("Авансов пока не поступало");
                window.firstavans_date = "";
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
    function converttime(onetime, day, month, year) {
        var D = new Date(onetime);
        D.setDate(D.getDate() + day);
        D.setMonth(D.getMonth() + month);
        D.setFullYear(D.getFullYear() + year);
        if (D.getDate() < 10) var curr_date = "0" + D.getDate();
        else var curr_date = D.getDate();
        if (D.getMonth() < 10) {
            var curr_month = D.getMonth() + 1;
            curr_month = "0" + curr_month;
        } else var curr_month = D.getMonth() + 1; //Всегда +1 для месяца - т.к. счет с о по 11
        var curr_year = D.getFullYear();
        var newData = curr_year + "-" + curr_month + "-" + curr_date; //формат даты на выходе (можно менять как угодно)
        return newData;
    }
    //
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    //
    $(document).ready(function() {
        // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
        editor_tab2_kalplans = new $.fn.dataTable.Editor({
            display: "bootstrap",
            formOptions: {
                main: {
                    onEsc: 'close'
                }
            },
            ajax: "php/examples/simple/docview/docview-edit/restr_4/tabs/process/dognet-docview-edit(restr_4)-tab2_kalplans-process.php",
            table: "#docview-edit-tab2_kalplans",
            i18n: {
                create: {
                    title: "<h3>Создать новый этап</h3>"
                },
                edit: {
                    title: "<h3>Редактировать этап</h3>"
                },
                remove: {
                    title: "<h3>Удалить этап</h3>",
                    confirm: {
                        "_": "Вы уверены, что хотите удалить %d записи(ей)?",
                        "1": "Вы уверены, что хотите удалить этот этап?"
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
            template: '#customForm_tab2_kalplans',
            fields: [{
                label: "Этап",
                name: "dognet_dockalplan.numberstage"
            }, {
                label: "Краткое наименование",
                name: "dognet_dockalplan.nameshotstage"
            }, {
                label: "Полное наименование",
                name: "dognet_dockalplan.namefullstage",
                type: "textarea"
            }, {
                label: "Объект",
                name: "dognet_dockalplan.kodobject",
                type: "select",
                def: "---",
                placeholder: "Выберите объект"
            }, {
                label: "Сумма",
                name: "dognet_dockalplan.summastage"
            }, {
                label: "Текущий срок",
                name: "dognet_dockalplan.srokstage",
                placeholder: "Дата или дни"
            }, {
                label: "Текущий срок",
                name: "dognet_dockalplan.srokstage_date",
                type: "datetime",
                format: "DD/MM/YYYY"
                // 				attr: { readonly: "readonly"}
            }, {
                label: "Контроль выполнения",
                type: "radio",
                name: "dognet_dockalplan.idsrokstage",
                options: [{
                        label: "По сроку (в днях)",
                        value: 0
                    },
                    {
                        label: "По дате",
                        value: 1
                    }
                ]
            }, {
                type: "hidden",
                name: "dognet_dockalplan.srokstage_tmp"
            }, {
                type: "hidden",
                name: "dognet_dockalplan.srokstage_date_tmp"
            }, {
                label: "&nbsp;",
                type: "checkbox",
                name: "dognet_dockalplan.idobjectready",
                options: [{
                    label: "",
                    value: 1
                }],
                separator: "",
                unselectedValue: 0
                // ----- ----- ----- ----- -----
            }, {
                label: "Текущий срок",
                name: "dognet_dockalplan.srokopl",
                placeholder: "ПКЗ или дни"
            }, {
                label: "Контроль оплаты",
                type: "radio",
                name: "dognet_dockalplan.idsrokopl",
                options: [{
                        label: "ПКЗ",
                        value: 0
                    },
                    {
                        label: "По сроку (в кал. днях)",
                        value: 1
                    },
                    {
                        label: "По дате",
                        value: 2
                    },
                    {
                        label: "По сроку (в раб. днях)",
                        value: 3
                    }
                ]
            }, {
                label: "Новый срок",
                name: "dognet_dockalplan.srokopl_tmp"
            }, {
                label: "",
                name: "dognet_docbase.kodtip"
            }, {
                // ----- ----- ----- ----- -----
                label: "",
                type: "checkbox",
                name: "dognet_dockalplan.useav1plan",
                options: [{
                    label: "",
                    value: 1
                }],
                separator: "",
                unselectedValue: 0
            }, {
                label: "",
                name: "dognet_dockalplan.pravplan1stage",
                attr: {
                    placeholder: "%"
                }
            }, {
                label: "",
                name: "dognet_dockalplan.dateplanav1stage",
                type: "datetime",
                format: "DD.MM.YYYY",
                attr: {
                    placeholder: "Дата"
                }
            }, {
                label: "",
                name: "dognet_dockalplan.daysplanav1stage",
                attr: {
                    placeholder: "Дни"
                }
            }, {
                // ----- -----
                label: "",
                type: "checkbox",
                name: "dognet_dockalplan.useav2plan",
                options: [{
                    label: "",
                    value: 1
                }],
                separator: "",
                unselectedValue: 0
            }, {
                label: "",
                name: "dognet_dockalplan.pravplan2stage",
                attr: {
                    placeholder: "%"
                }
            }, {
                label: "",
                name: "dognet_dockalplan.dateplanav2stage",
                type: "datetime",
                format: "DD.MM.YYYY",
                attr: {
                    placeholder: "Дата"
                }
            }, {
                label: "",
                name: "dognet_dockalplan.daysplanav2stage",
                attr: {
                    placeholder: "Дни"
                }
            }, {
                // ----- -----
                label: "",
                type: "checkbox",
                name: "dognet_dockalplan.useav3plan",
                options: [{
                    label: "",
                    value: 1
                }],
                separator: "",
                unselectedValue: 0
            }, {
                label: "",
                name: "dognet_dockalplan.pravplan3stage",
                attr: {
                    placeholder: "%"
                }
            }, {
                label: "",
                name: "dognet_dockalplan.dateplanav3stage",
                type: "datetime",
                format: "DD.MM.YYYY",
                attr: {
                    placeholder: "Дата"
                }
            }, {
                label: "",
                name: "dognet_dockalplan.daysplanav3stage",
                attr: {
                    placeholder: "Дни"
                }
            }, {
                // ----- -----
                label: "",
                type: "checkbox",
                name: "dognet_dockalplan.useav4plan",
                options: [{
                    label: "",
                    value: 1
                }],
                separator: "",
                unselectedValue: 0
            }, {
                label: "",
                name: "dognet_dockalplan.pravplan4stage",
                attr: {
                    placeholder: "%"
                }
            }, {
                label: "",
                name: "dognet_dockalplan.dateplanav4stage",
                type: "datetime",
                format: "DD.MM.YYYY",
                attr: {
                    placeholder: "Дата"
                }
            }, {
                label: "",
                name: "dognet_dockalplan.daysplanav4stage",
                attr: {
                    placeholder: "Дни"
                }
                // ----- ----- ----- ----- -----
            }, {
                label: "Субподряд",
                type: "checkbox",
                name: "dognet_dockalplan.usedocsubpodr",
                options: [{
                    label: "",
                    value: 1
                }],
                separator: "",
                unselectedValue: 0
            }, {
                label: "Дней до платежа",
                name: "dognet_dockalplan.numberdayoplstage",
                def: 30
            }, {
                label: "Дата окончания",
                name: "dognet_dockalplan.dateplan",
                type: "datetime",
                format: "DD.MM.YYYY",
                // 				attr: { readonly: "readonly"},
                def: function() {
                    return new Date();
                }
            }, {
                label: "Дата начала",
                message: "Для рамочных договоров",
                name: "dognet_dockalplan.dateplanbegin",
                type: "datetime",
                format: "DD.MM.YYYY",
                // 				attr: { readonly: "readonly"},
                def: function() {
                    return new Date();
                }
            }, {
                label: "Дата окон. платежа",
                name: "dognet_dockalplan.dateoplall",
                type: "datetime",
                format: "DD.MM.YYYY",
                // 				attr: { readonly: "readonly"},
                def: function() {
                    return new Date();
                }
            }, {
                label: "",
                name: "dognet_docbase.kodobject"
            }, {
                // Добавлено 2023-08-28
                label: "Гарантийный срок (в месяцах)",
                name: "dognet_dockalplan.warranty_period",
                def: "0"
            }]
        });
        // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
        // Изменяем размер диалогового окна редактирования договора субподряда
        editor_tab2_kalplans.on('open', function() {
            $(".modal-dialog").css({
                "width": "60%",
                "min-width": "640px",
                "max-width": "800px"
            });
        });
        editor_tab2_kalplans.on('close', function() {
            $(".modal-dialog").css({
                "width": "60%",
                "min-width": "640px",
                "max-width": "480px"
            });
        });
        // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
        //

        var request_kodtip;

        editor_tab2_kalplans
            .on('open', function() {
                editor_tab2_kalplans.field('dognet_dockalplan.srokstage_tmp').set(editor_tab2_kalplans.field(
                    'dognet_dockalplan.srokstage').get());
                editor_tab2_kalplans.field('dognet_dockalplan.srokopl_tmp').set(editor_tab2_kalplans.field(
                    'dognet_dockalplan.srokopl').get());
                // Store the values of the fields on open
                openVals_tab2_kalplans = JSON.stringify(editor_tab2_kalplans.get());
                editor_tab2_kalplans.on('preBlur', function(e) {
                    // On close, check if the values have changed and ask for closing confirmation if they have
                    if (openVals_tab2_kalplans !== JSON.stringify(editor_tab2_kalplans.get())) {
                        return confirm('Вы не сохранили данные формы. Уверены, что хотите ее закрыть?');
                    }
                })

                $('#DTE_Field_dognet_dockalplan-summastage').inputmask({
                    alias: "currency",
                    rightAlign: false,
                    greedy: false,
                    tabThrough: false,

                    placeholder: "0",
                    enforceDigitsOnBlur: false,
                    radixPoint: ".",
                    digits: 2,
                    digitsOptional: false,
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
                        if (typeof x[1] == 'undefined') {
                            return x[0].replace(/\ /g, '') + '.00';
                        } else {
                            return x[0].replace(/\ /g, '') + '.' + x[1];
                        }
                    }
                });
                $('#DTE_Field_dognet_dockalplan-srokstage_date').inputmask({
                    mask: "99/99/9999",
                    showMaskOnHover: false
                });
                $('#DTE_Field_dognet_dockalplan-dateplanav1stage').inputmask({
                    mask: "99.99.9999"
                });
                $('#DTE_Field_dognet_dockalplan-dateplanav2stage').inputmask({
                    mask: "99.99.9999"
                });
                $('#DTE_Field_dognet_dockalplan-dateplanav3stage').inputmask({
                    mask: "99.99.9999"
                });
                $('#DTE_Field_dognet_dockalplan-dateplanav4stage').inputmask({
                    mask: "99.99.9999"
                });
                $('#DTE_Field_dognet_dockalplan-dateplan').inputmask({
                    mask: "99.99.9999"
                });
                $('#DTE_Field_dognet_dockalplan-dateoplall').inputmask({
                    mask: "99.99.9999"
                });

                /**
                 * Корректировка от 20.04.2022
                 * Добавлено поле dognet_dockalplan.dateplanbegin - дата начала этапа для рамочных договоров (объект рамочный, 245530345307999)
                 */
                var docbaseKodobject = editor_tab2_kalplans.field('dognet_docbase.kodobject').val();
                if (docbaseKodobject == "245530345307999") {
                    editor_tab2_kalplans.field('dognet_dockalplan.dateplanbegin').enable();
                    editor_tab2_kalplans.field('dognet_dockalplan.dateplanbegin').message(
                        'Для рамочных договоров желательно');
                } else {
                    editor_tab2_kalplans.field('dognet_dockalplan.dateplanbegin').disable();
                    editor_tab2_kalplans.field('dognet_dockalplan.dateplanbegin').message(
                        'Для этого типа договора не обязательно');
                }

            })
        // ----- -- ----- -- -----
        editor_tab2_kalplans
            .on('open', function() {
                var tipdoc = $('#ajaxResponseOut1').text().replace(new RegExp("\\r?\\n", "g"), "");
                console.log("ajaxRequest1: " + tipdoc);
                //
                // Массив с типами договора, для которых нужен котроль готовности объекта
                // ПНР+ШМР, ШМР, ПНР, Поставка+Работы, Техобслуживание
                // UPD20240202 >> Добавлен тип договора "Разработка и корректировка ПО" (245538555152781)
                const tips = ['245773055697212', '245773052282168', '245287843809309', '245287841599652',
                    '245267756588371', '245538555152781, 245461560078473', '245538555152781'
                ];
                if (tips.includes(tipdoc)) {
                    editor_tab2_kalplans.field('dognet_dockalplan.idobjectready').show(false);
                    $('#check-idobjectready').css("display", "");
                } else {
                    editor_tab2_kalplans.field('dognet_dockalplan.idobjectready').hide(false);
                    $('#check-idobjectready').css("display", "none");
                }
                //
                editor_tab2_kalplans.on('preSubmit', function(e) {
                    if (editor_tab2_kalplans.field('dognet_dockalplan.numberstage').val() == '' ||
                        editor_tab2_kalplans.field('dognet_dockalplan.kodobject').val() == '' ||
                        editor_tab2_kalplans.field('dognet_dockalplan.nameshotstage').val() == '') {
                        document.getElementById("doc-editor-menu-tab-1-errmsg").innerHTML =
                            '<span class="glyphicon glyphicon-exclamation-sign"></span>';
                        $("#doc-editor-menu-tab-1-errmsg").attr("class", "text-danger errmsg");
                    } else {
                        document.getElementById("doc-editor-menu-tab-1-errmsg").innerHTML = '';
                    }
                    if ((editor_tab2_kalplans.field('dognet_dockalplan.srokstage').val() == '' &&
                            editor_tab2_kalplans.field('dognet_dockalplan.srokstage_date').val() == ''
                        ) || editor_tab2_kalplans.field('dognet_dockalplan.srokopl').val() == '') {
                        document.getElementById("doc-editor-menu-tab-2-errmsg").innerHTML =
                            '<span class="glyphicon glyphicon-exclamation-sign"></span>';
                        $("#doc-editor-menu-tab-2-errmsg").attr("class", "text-danger errmsg");
                    } else {
                        document.getElementById("doc-editor-menu-tab-2-errmsg").innerHTML = '';
                    }
                    if (editor_tab2_kalplans.field('dognet_dockalplan.dateplan').val() == '' ||
                        editor_tab2_kalplans.field('dognet_dockalplan.dateoplall').val() == '') {
                        document.getElementById("doc-editor-menu-tab-4-errmsg").innerHTML =
                            '<span class="glyphicon glyphicon-exclamation-sign"></span>';
                        $("#doc-editor-menu-tab-4-errmsg").attr("class", "text-danger errmsg");
                    } else {
                        document.getElementById("doc-editor-menu-tab-4-errmsg").innerHTML = '';
                    }
                })
            })
        // ----- -- ----- -- -----
        editor_tab2_kalplans.dependent('dognet_dockalplan.idsrokstage', function(val) {
            if (val == 1) {
                editor_tab2_kalplans.field('dognet_dockalplan.idsrokstage').processing(false);
                $('#srokstage').css("display", "none");
                editor_tab2_kalplans.field('dognet_dockalplan.srokstage').hide(false);
                $('#srokstage_date').css("display", "");
                editor_tab2_kalplans.field('dognet_dockalplan.srokstage_date').show(false);
                editor_tab2_kalplans.field('dognet_dockalplan.srokstage').fieldInfo("В формате ДД/ММ/ГГГГ");
            } else {
                editor_tab2_kalplans.field('dognet_dockalplan.idsrokstage').processing(false);
                editor_tab2_kalplans.field('dognet_dockalplan.srokstage').show(false);
                $('#srokstage').css("display", "");
                editor_tab2_kalplans.field('dognet_dockalplan.srokstage_date').hide(false);
                $('#srokstage_date').css("display", "none");
                editor_tab2_kalplans.field('dognet_dockalplan.srokstage').set(editor_tab2_kalplans.field(
                    'dognet_dockalplan.srokstage_tmp').get());
                editor_tab2_kalplans.field('dognet_dockalplan.srokstage').fieldInfo(
                    "Просто количество дней");
            }
        });
        // ----- -- ----- -- -----
        editor_tab2_kalplans.dependent('dognet_dockalplan.idsrokopl', function(val) {
            if (val == 0) {
                editor_tab2_kalplans.field('dognet_dockalplan.idsrokopl').processing(false);
                editor_tab2_kalplans.field('dognet_dockalplan.srokopl').set('ПКЗ');
                $('#DTE_Field_dognet_dockalplan-srokopl').unmask();
            }
            if (val == 2) {
                editor_tab2_kalplans.field('dognet_dockalplan.idsrokopl').processing(false);
                $('#DTE_Field_dognet_dockalplan-srokopl').mask("99/99/9999");
                editor_tab2_kalplans.field('dognet_dockalplan.srokopl').fieldInfo("В формате ДД/ММ/ГГГГ");

                $('#DTE_Field_dognet_dockalplan-srokopl').change(function() {
                    if ($(this).val().substring(0, 2) > 31 || $(this).val().substring(0, 2) ==
                        "00") {
                        alert("Неправильное значение дня");
                        return false;
                    }
                    if ($(this).val().substring(3, 2) > 12 || $(this).val().substring(3, 2) ==
                        "00") {
                        alert("Неправильное значение месяца");
                        return false;
                    }
                });
            }
            if (val == 1) {
                editor_tab2_kalplans.field('dognet_dockalplan.idsrokopl').processing(false);
                $('#DTE_Field_dognet_dockalplan-srokopl').unmask();
                editor_tab2_kalplans.field('dognet_dockalplan.srokopl').set(editor_tab2_kalplans.field(
                    'dognet_dockalplan.srokopl_tmp').get());
            }

            /*
            				$('#DTE_Field_dognet_dockalplan-srokopl').change(function() {
            					if ( editor_tab2_kalplans.field('dognet_dockalplan.idsrokopl').val() == 2 ) {
            						if ($(this).val().substring(0, 2) > 12 || $(this).val().substring(0, 2) == "00") {
            							alert("Неправильное значение месяца");
            							return false;
            						}
            						if ($(this).val().substring(3, 5) > 31 || $(this).val().substring(0, 2) == "00") {
            							alert("Неправильное значение даты");
            							return false;
            						}
            					}
            				});
            */



        }, {
            event: 'change'
        });
        // ----- -- ----- -- -----
        editor_tab2_kalplans.dependent('dognet_dockalplan.numberdayoplstage', function(val) {
            editor_tab2_kalplans.field('dognet_dockalplan.numberdayoplstage').processing(false);

            if (val !== '') {
                var dateplan = editor_tab2_kalplans.field('dognet_dockalplan.dateplan').val();
                var date = moment(dateplan, 'DD.MM.YYYY');
                var newdate = moment(date.format('YYYY-MM-DD'));

                var diff_days = editor_tab2_kalplans.field('dognet_dockalplan.numberdayoplstage').val();
                var out = newdate.add(diff_days, 'days').format('DD.MM.YYYY');

                editor_tab2_kalplans.field('dognet_dockalplan.dateoplall').set(out);

            }

        }, {
            event: 'keyup'
        });
        // ----- -- ----- -- -----
        editor_tab2_kalplans.dependent('dognet_dockalplan.srokstage_date', function(val) {
            editor_tab2_kalplans
                .field('dognet_dockalplan.srokstage')
                .set(editor_tab2_kalplans
                    .field('dognet_dockalplan.srokstage_date')
                    .get());

        }, {
            event: 'change'
        });
        // ----- -- ----- -- -----
        editor_tab2_kalplans.dependent('dognet_dockalplan.dateoplall', function(val) {
            editor_tab2_kalplans.field('dognet_dockalplan.dateoplall').processing(false);

            if (val !== '') {
                var dateplan = editor_tab2_kalplans.field('dognet_dockalplan.dateplan').val();
                var date1 = moment(dateplan, 'DD.MM.YYYY');
                var newdate1 = moment(date1.format('YYYY-MM-DD'));

                var date2 = moment(val, 'DD.MM.YYYY');
                var newdate2 = moment(date2.format('YYYY-MM-DD'));

                var out = newdate2.diff(newdate1, 'days');

                editor_tab2_kalplans.field('dognet_dockalplan.numberdayoplstage').set(out);

            }

        }, {
            event: 'change'
        });
        // ----- -- ----- -- -----
        // Если вводим дату планируемого аванса - пересчитываем дни от первого аванса, и наоборот - если вводим дни - персчитываем дату
        // 
        // ДЛЯ АВАНСА 2
        editor_tab2_kalplans.dependent('dognet_dockalplan.dateplanav2stage', function(val) {
            editor_tab2_kalplans.field('dognet_dockalplan.dateplanav2stage').processing(false);

            if (window.firstavans_date != "") {
                editor_tab2_kalplans.field('dognet_dockalplan.dateplanav2stage').enable();
                if (val !== '') {
                    // var dateav1 = editor_tab2_kalplans.field('dognet_dockalplan.dateplanav1stage').val();
                    var dateav1 = window.firstavans_date;
                    var date1 = moment(dateav1);
                    var newdate1 = moment(date1.format('YYYY-MM-DD'));
                    var date2 = moment(val, 'DD.MM.YYYY');
                    var newdate2 = moment(date2.format('YYYY-MM-DD'));
                    var out = newdate2.diff(newdate1, 'days');
                    editor_tab2_kalplans.field('dognet_dockalplan.daysplanav2stage').set(out);
                } else {
                    editor_tab2_kalplans.field('dognet_dockalplan.daysplanav2stage').set("");
                }
            } else {
                editor_tab2_kalplans.field('dognet_dockalplan.dateplanav2stage').set("");
                editor_tab2_kalplans.field('dognet_dockalplan.dateplanav2stage').disable();
            }

        }, {
            event: 'change'
        });
        //
        // ДЛЯ АВАНСА 3
        editor_tab2_kalplans.dependent('dognet_dockalplan.dateplanav3stage', function(val) {
            editor_tab2_kalplans.field('dognet_dockalplan.dateplanav3stage').processing(false);

            if (window.firstavans_date != "") {
                editor_tab2_kalplans.field('dognet_dockalplan.dateplanav3stage').enable();
                if (val !== '') {
                    // var dateav1 = editor_tab2_kalplans.field('dognet_dockalplan.dateplanav1stage').val();
                    var dateav1 = window.firstavans_date;
                    var date1 = moment(dateav1);
                    var newdate1 = moment(date1.format('YYYY-MM-DD'));
                    var date2 = moment(val, 'DD.MM.YYYY');
                    var newdate2 = moment(date2.format('YYYY-MM-DD'));
                    var out = newdate2.diff(newdate1, 'days');
                    editor_tab2_kalplans.field('dognet_dockalplan.daysplanav3stage').set(out);
                } else {
                    editor_tab2_kalplans.field('dognet_dockalplan.daysplanav3stage').set("");
                }
            } else {
                editor_tab2_kalplans.field('dognet_dockalplan.dateplanav3stage').set("");
                editor_tab2_kalplans.field('dognet_dockalplan.dateplanav3stage').disable();
            }

        }, {
            event: 'change'
        });
        //
        // ДЛЯ АВАНСА 4
        editor_tab2_kalplans.dependent('dognet_dockalplan.dateplanav4stage', function(val) {
            editor_tab2_kalplans.field('dognet_dockalplan.dateplanav4stage').processing(false);

            if (window.firstavans_date != "") {
                editor_tab2_kalplans.field('dognet_dockalplan.dateplanav4stage').enable();
                if (val !== '') {
                    // var dateav1 = editor_tab2_kalplans.field('dognet_dockalplan.dateplanav1stage').val();
                    var dateav1 = window.firstavans_date;
                    var date1 = moment(dateav1);
                    var newdate1 = moment(date1.format('YYYY-MM-DD'));
                    var date2 = moment(val, 'DD.MM.YYYY');
                    var newdate2 = moment(date2.format('YYYY-MM-DD'));
                    var out = newdate2.diff(newdate1, 'days');
                    editor_tab2_kalplans.field('dognet_dockalplan.daysplanav4stage').set(out);
                } else {
                    editor_tab2_kalplans.field('dognet_dockalplan.daysplanav4stage').set("");
                }
            } else {
                editor_tab2_kalplans.field('dognet_dockalplan.dateplanav4stage').set("");
                editor_tab2_kalplans.field('dognet_dockalplan.dateplanav4stage').disable();
            }

        }, {
            event: 'change'
        });
        //
        //
        /*
            editor_tab2_kalplans.dependent( 'dognet_dockalplan.useav1plan', function ( val ) { 
        	    if ( val == 0 ) {
        			editor_tab2_kalplans.field('dognet_dockalplan.pravplan1stage').disable();
        			editor_tab2_kalplans.field('dognet_dockalplan.dateplanav1stage').disable();
        			editor_tab2_kalplans.field('dognet_dockalplan.daysplanav1stage').disable();
        	    }
        	    else {
        			editor_tab2_kalplans.field('dognet_dockalplan.pravplan1stage').enable();
        			editor_tab2_kalplans.field('dognet_dockalplan.dateplanav1stage').enable();
        			editor_tab2_kalplans.field('dognet_dockalplan.daysplanav1stage').enable();
        	    }
            }, { event: 'change' } );
            editor_tab2_kalplans.dependent( 'dognet_dockalplan.useav2plan', function ( val ) { 
        	    if ( val == 0 ) {
        			editor_tab2_kalplans.field('dognet_dockalplan.pravplan2stage').disable();
        			editor_tab2_kalplans.field('dognet_dockalplan.dateplanav2stage').disable();
        			editor_tab2_kalplans.field('dognet_dockalplan.daysplanav2stage').disable();
        	    }
        	    else {
        			editor_tab2_kalplans.field('dognet_dockalplan.pravplan2stage').enable();
        			editor_tab2_kalplans.field('dognet_dockalplan.dateplanav2stage').enable();
        			editor_tab2_kalplans.field('dognet_dockalplan.daysplanav2stage').enable();
        	    }
            }, { event: 'change' } );
            editor_tab2_kalplans.dependent( 'dognet_dockalplan.useav3plan', function ( val ) { 
        	    if ( val == 0 ) {
        			editor_tab2_kalplans.field('dognet_dockalplan.pravplan3stage').disable();
        			editor_tab2_kalplans.field('dognet_dockalplan.dateplanav3stage').disable();
        			editor_tab2_kalplans.field('dognet_dockalplan.daysplanav3stage').disable();
        	    }
        	    else {
        			editor_tab2_kalplans.field('dognet_dockalplan.pravplan3stage').enable();
        			editor_tab2_kalplans.field('dognet_dockalplan.dateplanav3stage').enable();
        			editor_tab2_kalplans.field('dognet_dockalplan.daysplanav3stage').enable();
        	    }
            }, { event: 'change' } );
            editor_tab2_kalplans.dependent( 'dognet_dockalplan.useav4plan', function ( val ) { 
        	    if ( val == 0 ) {
        			editor_tab2_kalplans.field('dognet_dockalplan.pravplan4stage').disable();
        			editor_tab2_kalplans.field('dognet_dockalplan.dateplanav4stage').disable();
        			editor_tab2_kalplans.field('dognet_dockalplan.daysplanav4stage').disable();
        	    }
        	    else {
        			editor_tab2_kalplans.field('dognet_dockalplan.pravplan4stage').enable();
        			editor_tab2_kalplans.field('dognet_dockalplan.dateplanav4stage').enable();
        			editor_tab2_kalplans.field('dognet_dockalplan.daysplanav4stage').enable();
        	    }
            }, { event: 'change' } );
        */



        // ----- -- ----- -- -----
        //
        //
        // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
        table_tab2_kalplans = $('#docview-edit-tab2_kalplans').DataTable({
            dom: "<'row'<'col-sm-5'B><'col-sm-4'><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-6'i><'col-sm-6'p>>",
            /* 		dom: "<'row'<'col-md-8 col-sm-12'B><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'>>", */
            // 		dom: "t",
            language: {
                url: "php/examples/simple/docview/docview-edit/dt_russian-tab2_kalplan.json"
            },
            ajax: {
                url: "php/examples/simple/docview/docview-edit/restr_4/tabs/process/dognet-docview-edit(restr_4)-tab2_kalplans-process.php",
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
                    data: "dognet_dockalplan.numberstage",
                    className: "text-center"
                },
                {
                    data: "dognet_dockalplan.nameshotstage"
                },
                {
                    data: "dognet_dockalplan.srokstage",
                    className: "text-center"
                },
                {
                    data: "dognet_dockalplan.srokopl",
                    className: "text-center"
                },
                {
                    data: "dognet_dockalplan.summastage"
                }
            ],
            select: {
                style: 'os',
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
                                .dognet_spdened.short_code;
                        } else {
                            return "0.00" + row.dognet_spdened.short_code;
                        }
                    },
                    targets: 5
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
                {
                    extend: "create",
                    editor: editor_tab2_kalplans,
                    text: "НОВЫЙ ЭТАП",
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
                    editor: editor_tab2_kalplans,
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
                    editor: editor_tab2_kalplans,
                    text: "УДАЛИТЬ"
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
        // ----- -- ----- -- -----
        // Array to track the ids of the edit displayed rows
        var detailRows_tab2_kalplans = [];
        $('#docview-edit-tab2_kalplans tbody').on('click', 'tr td.details-control', function() {
            var tr = $(this).closest('tr');
            var row = table_tab2_kalplans.row(tr);
            var idx = $.inArray(tr.attr('id'), detailRows_tab2_kalplans);

            if (row.child.isShown()) {
                tr.removeClass('edit');
                row.child.hide();

                // Remove from the 'open' array
                detailRows_tab2_kalplans.splice(idx, 1);
            } else {
                tr.addClass('edit');
                rowData = table_tab2_kalplans.row(row);
                d = row.data();
                rowData.child(<?php include('templates/docview-edit_tab2_kalplans.tpl'); ?>).show();

                // Add to the 'open' array
                if (idx === -1) {
                    detailRows_tab2_kalplans.push(tr.attr('id'));
                }
            }
        });
        // On each draw, loop over the `detailRows_tab2_kalplans` array and show any child rows
        table_tab2_kalplans.on('draw', function() {
            $.each(detailRows_tab2_kalplans, function(i, id) {
                $('#' + id + ' td.details-control').trigger('click');
            });
        });
        // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
        //
        //
        //
        // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
        // Выводим уведомление (цифру) о количестве этапов
        table_tab2_kalplans.on('draw', function() {
            cnt_stg = table_tab2_kalplans.data().count();
            if (cnt_stg > 0) {
                document.getElementById("stg_newitems_cnt").innerHTML = cnt_stg;
            } else {
                document.getElementById("stg_newitems_cnt").innerHTML = "";
            }

            console.log("UNIQUE ID: " + uniqueID);
            ajaxRequest_kodtip(uniqueID, 'kodtip');


            selected = table_tab2_kalplans.row({
                selected: true
            });
            console.log('selected: ' + selected);
            if (selected.any()) {
                kodkalplan = selected.data().dognet_dockalplan.kodkalplan;
            } else {
                kodkalplan = null;
            }
            console.log('kodkalplan: ' + kodkalplan);
            ajaxRequest_sumstages(null, uniqueID, kodkalplan, null, 'sumdiff');

        });
        // ----- -- ----- -- -----
        editor_tab2_kalplans.on('open', function(e, mode, action) {
            console.log('action : ' + action);
            // editor_tab2_kalplans.field('dognet_dockalplan.summastage').fieldInfo('Контроль сумм');
            editor_tab2_kalplans.dependent('dognet_dockalplan.summastage', function(val) {
                selected = table_tab2_kalplans.row({
                    selected: true
                });
                console.log('selected: ' + selected);
                if (selected.any()) {
                    kodkalplan = selected.data().dognet_dockalplan.kodkalplan;
                } else {
                    kodkalplan = null;
                }
                console.log('kodkalplan: ' + kodkalplan);
                unmaskedValue = val;
                x = unmaskedValue.split('.');
                sum_selectedstage = x[0].replace(/\ /g, '') + '.' + x[1];
                console.log('sum_selectedstage: ' + sum_selectedstage);
                ajaxRequest_sumdiff(action, uniqueID, kodkalplan, sum_selectedstage, 'sumdiff');
            }, {
                event: 'keyup'
            });
            console.log("Event on(open): " + action);
            $('#sumctrl_msg').empty();

            // ----- -- ----- -- -----
            //
            //
            // ----- -- ----- -- -----

            selected = table_tab2_kalplans.row({
                selected: true
            });
            if (selected.any()) {
                kodkalplan = selected.data().dognet_dockalplan.kodkalplan;
            } else {
                kodkalplan = null;
            }
            ajaxRequest_firstavans(kodkalplan, 'firstavans');


            $('#DTE_Field_dognet_dockalplan-daysplanav2stage').on("input", function() {
                val = $(this).val();
                if (val !== '') {
                    if (window.firstavans_date != "") {
                        // var dateav1 = editor_tab2_kalplans.field('dognet_dockalplan.dateplanav1stage').val();
                        var dateav1 = window.firstavans_date;
                        var date1 = moment(dateav1);
                        var newdate1 = moment(date1.format('YYYY-MM-DD'));
                        var date2 = newdate1.add(val, 'days').format('DD.MM.YYYY');
                        var newdate2 = moment(date2, 'DD.MM.YYYY').format('YYYY-MM-DD');
                        editor_tab2_kalplans.field('dognet_dockalplan.dateplanav2stage').set(date2);
                    } else {
                        editor_tab2_kalplans.field('dognet_dockalplan.dateplanav2stage').set("");
                    }
                } else {
                    editor_tab2_kalplans.field('dognet_dockalplan.dateplanav2stage').set("");
                }
            });
            $('#DTE_Field_dognet_dockalplan-daysplanav3stage').on("input", function() {
                val = $(this).val();
                if (val !== '') {
                    if (window.firstavans_date != "") {
                        // var dateav1 = editor_tab2_kalplans.field('dognet_dockalplan.dateplanav1stage').val();
                        var dateav1 = window.firstavans_date;
                        var date1 = moment(dateav1);
                        var newdate1 = moment(date1.format('YYYY-MM-DD'));
                        var date2 = newdate1.add(val, 'days').format('DD.MM.YYYY');
                        var newdate2 = moment(date2, 'DD.MM.YYYY').format('YYYY-MM-DD');
                        editor_tab2_kalplans.field('dognet_dockalplan.dateplanav3stage').set(date2);
                    } else {
                        editor_tab2_kalplans.field('dognet_dockalplan.dateplanav3stage').set("");
                    }
                } else {
                    editor_tab2_kalplans.field('dognet_dockalplan.dateplanav3stage').set("");
                }
            });
            $('#DTE_Field_dognet_dockalplan-daysplanav4stage').on("input", function() {
                val = $(this).val();
                if (val !== '') {
                    if (window.firstavans_date != "") {
                        // var dateav1 = editor_tab2_kalplans.field('dognet_dockalplan.dateplanav1stage').val();
                        var dateav1 = window.firstavans_date;
                        var date1 = moment(dateav1);
                        var newdate1 = moment(date1.format('YYYY-MM-DD'));
                        var date2 = newdate1.add(val, 'days').format('DD.MM.YYYY');
                        var newdate2 = moment(date2, 'DD.MM.YYYY').format('YYYY-MM-DD');
                        editor_tab2_kalplans.field('dognet_dockalplan.dateplanav4stage').set(date2);
                    } else {
                        editor_tab2_kalplans.field('dognet_dockalplan.dateplanav4stage').set("");
                    }
                } else {
                    editor_tab2_kalplans.field('dognet_dockalplan.dateplanav4stage').set("");
                }
            });



        });
    });
</script>
<?php
// ----- ----- ----- ----- -----
// Подключаем форму и выводим таблицу этапов
// :::
include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/docview/docview-edit/restr_4/tabs/forms/docview-edit_tab2_kalplans-customForm.php");
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-edit/restr_4/tabs/css/docview-edit-tab2_kalplans.css">
<section>
    <div id="docview-tab2_kalplans" class="" style="padding:0 5px">
        <div class="space30"></div>
        <h3 class="parent-title space20">Этапы основного договора <span id="sumctrl_title" style="font-weight:300; font-size:0.9em; float:right; padding-right:10px"></span></h3>
        <div class="demo-html"></div>
        <table id="docview-edit-tab2_kalplans" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
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
    <span id="ajaxResponseOut1" style="display:none"></span>
    <span id="ajaxResponseOut2" style="display:none"></span>
</section>


<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-danger">Сумма всех этапов превышает сумму договора!</h4>
            </div>
            <div class="modal-body">
                <p>Сумма договора: <b><span id="out_docsum"></span></b></p>
                <p>Сумма всех этапов: <b><span id="out_stagesum"></span></b></p>
                <p>Рекомендуемая сумма создаваемого/редактируемого этапа: <b><span id="out_recsum"></span></b></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>

    </div>
</div>