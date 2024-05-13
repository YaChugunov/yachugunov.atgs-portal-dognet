<script type="text/javascript" language="javascript" class="init">
  function addZero(digits_length, source) {
    var text = source + '';
    while (text.length < digits_length)
      text = '0' + text;
    return text;
  }

  var editor_tab1_dogovor; // use a global for the submit and return data rendering in the examples
  var table_tab1_dogovor; // use a global for the submit and return data rendering in the examples
  //
  //
  var reqField_sendMail_docStatus = {
    sendMail: function(response) {}
  };

  function ajaxRequest_sendMail_docStatus(docnumber, namedoc, ispolname, docstatus, summadoc, koddoc, kodstatus, kodispol,
    responseHandler) {
    var response = false;
    // Fire off the request to /form.php
    request = $.ajax({
      url: "php/examples/simple/docview/docview-edit/restr_5/tabs/php/sendMail_onSubmit-changeDocstatus.php",
      type: "post",
      cache: false,
      data: {
        docnumber: docnumber,
        namedoc: namedoc,
        ispolname: ispolname,
        docstatus: docstatus,
        summadoc: summadoc,
        koddoc: koddoc,
        kodstatus: kodstatus,
        kodispol: kodispol
      },
      success: reqField_sendMail_docStatus[responseHandler]
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
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    editor_tab1_dogovor = new $.fn.dataTable.Editor({
      display: "bootstrap",
      ajax: "php/examples/php/docview/docview-edit/dognet-docview-edit-tab1_dogovor-process.php",
      table: "#docview-edit-tab1_dogovor",
      i18n: {
        create: {
          title: "<h3>Создать новый договора</h3>"
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
      template: '#customForm_tab1_dogovor',
      fields: [{
        label: "Номер :",
        name: "dognet_docbase.docnumber"
      }, {
        label: "Номер контрагента :",
        name: "dognet_docbase.docpartnernumberSTR"
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
        format: "DD.MM.YYYY"
        // 				attr: { readonly: "readonly" }
      }, {
        label: "Окончание :",
        name: "docDateEnd",
        type: "datetime",
        format: "DD.MM.YYYY"
        // 				attr: { readonly: "readonly" }
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
            value: "3"
          }
        ],
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
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    editor_tab1_dogovor
      .on('open', function() {

        $('#kodzakaz_filter').val('');
        if (($('#DTE_Field_dognet_docbase-kodzakaz').value) != editor_tab1_dogovor.field(
            'dognet_docbase.kodzakaz').get()) {}
        // Поиск в ниспадающем списке по содержимому текстового поля для ответного документа
        $('#DTE_Field_dognet_docbase-kodzakaz').filterByText(editor_tab1_dogovor, $('#kodzakaz_filter'),
          'dognet_docbase.kodzakaz', false);

        $('#kodobject_filter').val('');
        if (($('#DTE_Field_dognet_docbase-kodobject').value) != editor_tab1_dogovor.field(
            'dognet_docbase.kodobject').get()) {}
        // Поиск в ниспадающем списке по содержимому текстового поля для ответного документа
        $('#DTE_Field_dognet_docbase-kodobject').filterByText(editor_tab1_dogovor, $(
          '#kodobject_filter'), 'dognet_docbase.kodobject', false);

        $(".modal-dialog").css({
          "width": "80%",
          "min-width": "800px",
          "max-width": "1170px"
        });
        // Store the values of the fields on open
        openVals_tab1_dogovor = JSON.stringify(editor_tab1_dogovor.get());

        editor_tab1_dogovor.on('preBlur', function(e) {
          // On close, check if the values have changed and ask for closing confirmation if they have
          if (openVals_tab1_dogovor !== JSON.stringify(editor_tab1_dogovor.get())) {
            return confirm('Вы не сохранили данные формы. Уверены, что хотите ее закрыть?');
          }
        })

        $('#DTE_Field_dognet_docbase-docsumma').inputmask({
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
        $('#DTE_Field_dognet_docbase-docsummamis').inputmask({
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
        $('#DTE_Field_docDateBegin').inputmask({
          mask: "99.99.9999"
        });
        $('#DTE_Field_docDateEnd').inputmask({
          mask: "99.99.9999"
        });

      })
      .on("submit close", function() {
        editor_tab1_dogovor.off("preBlur");
      });
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    // Изменяем размер диалогового окна редактирования договора субподряда
    editor_tab1_dogovor.on('close', function() {
      $(".modal-dialog").css({
        "width": "60%",
        "min-width": "none",
        "max-width": "none"
      });
    });
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    table_tab1_dogovor = $('#docview-edit-tab1_dogovor').DataTable({
      dom: "<'row'<'col-md-8 col-sm-12'B><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'>>",
      // 		dom: "t",
      language: {
        url: "russian.json"
      },
      ajax: {
        url: "php/examples/php/docview/docview-edit/dognet-docview-edit-tab1_dogovor-process.php",
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
          className: 'tab1-refreshButton',
          action: function(e, dt, node, config) {
            table_tab1_dogovor.columns().search('').draw();
          }
        },
        {
          extend: "edit",
          editor: editor_tab1_dogovor,
          text: "РЕДАКТИРОВАТЬ",
          formButtons: ['Сохранить изменения',
            {
              text: 'Отмена',
              action: function() {
                this.close();
              }
            }
          ],
          className: 'tab1-editButton'
        }
      ],
      initComplete: function() {

      },
      drawCallback: function() {

      }
    });
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    editor_tab1_dogovor.on('preOpen', function() {

      var daynachdoc = addZero(2, editor_tab1_dogovor.field('dognet_docbase.daynachdoc').val());
      var monthnachdoc = addZero(2, editor_tab1_dogovor.field('dognet_docbase.monthnachdoc').val());
      var yearnachdoc = addZero(2, editor_tab1_dogovor.field('dognet_docbase.yearnachdoc').val());
      editor_tab1_dogovor.field('docDateBegin').set(daynachdoc + "." + monthnachdoc + "." +
        yearnachdoc);

      var dayenddoc = addZero(2, editor_tab1_dogovor.field('dognet_docbase.dayenddoc').val());
      var monthenddoc = addZero(2, editor_tab1_dogovor.field('dognet_docbase.monthenddoc').val());
      var yearenddoc = addZero(2, editor_tab1_dogovor.field('dognet_docbase.yearenddoc').val());
      editor_tab1_dogovor.field('docDateEnd').set(dayenddoc + "." + monthenddoc + "." + yearenddoc);

    });
    //
    //
    editor_tab1_dogovor.on('initSubmit', function() {

      var a = editor_tab1_dogovor.field('docDateBegin').val().split('.');
      editor_tab1_dogovor.field('dognet_docbase.daynachdoc').set(a[0]);
      editor_tab1_dogovor.field('dognet_docbase.monthnachdoc').set(a[1]);
      editor_tab1_dogovor.field('dognet_docbase.yearnachdoc').set(a[2]);

      var b = editor_tab1_dogovor.field('docDateEnd').val().split('.');
      editor_tab1_dogovor.field('dognet_docbase.dayenddoc').set(b[0]);
      editor_tab1_dogovor.field('dognet_docbase.monthenddoc').set(b[1]);
      editor_tab1_dogovor.field('dognet_docbase.yearenddoc').set(b[2]);

    });
    //
    //
    editor_tab1_dogovor.on('open', function(e, mode, action) {
      // Изменяем размер диалогового окна редактирования договора субподряда
      $(".modal-dialog").css("width", "80%");
      if (action == 'edit') {
        $('#kodblankwork_filter').css("display", "none");
        editor_tab1_dogovor.field('dognet_docbase.kodshab').disable();
        editor_tab1_dogovor.field('dognet_docbase.usedocruk').disable();
        editor_tab1_dogovor.field('dognet_docbase.usedoczayv').disable();
        editor_tab1_dogovor.dependent('dognet_docbase.usedoczayv', function(val) {
          if (val == 1) {
            editor_tab1_dogovor.field('dognet_docbase.kodblankwork').show(false);
            editor_tab1_dogovor.field('dognet_docbase.kodblankwork').disable();
            editor_tab1_dogovor.field('dognet_docbase.usedocruk').disable();
            editor_tab1_dogovor.field('dognet_docbase.usedoczayv').disable();
          } else {
            editor_tab1_dogovor.field('dognet_docbase.kodblankwork').hide(false);
          }
        });

      }
    });
    editor_tab1_dogovor.on('close', function(e, mode, action) {
      // Изменяем размер диалогового окна редактирования договора субподряда
      $(".modal-dialog").css("width", "80%");
      editor_tab1_dogovor.undependent('dognet_docbase.usedoczayv');
      editor_tab1_dogovor.undependent('dognet_docbase.usedocruk');
      editor_tab1_dogovor.undependent('dognet_docbase.kodblankwork');
    });
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    //
    //
    //
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    editor_tab1_dogovor.on('initEdit', function(e, node, data, items, type) {
      window._kodstatusbefore = data.dognet_docbase.kodstatus;
    });
    editor_tab1_dogovor.on('submitSuccess', function(e, json, data, action) {
      if (action === "create") {
        // осуществляем глубокое копирование объекта и инициализируем переменную
        let newObj = JSON.parse(JSON.stringify(json));
        // console.log( newObj.data[0] );
        _docnumber = newObj.data[0].dognet_docbase.docnumber;
        _namedoc = newObj.data[0].dognet_docbase.docnameshot;
        _ispolname = newObj.data[0].dognet_spispol.ispolnamefull;
        _docstatus = newObj.data[0].dognet_spstatus.statusnameshot;
        _koddoc = newObj.data[0].dognet_docbase.koddoc;
        _kodstatus = newObj.data[0].dognet_docbase.kodstatus;
        _kodispol = newObj.data[0].dognet_docbase.kodispol;

        _summadoc = newObj.data[0].dognet_docbase.docsumma;
        _summadoc = $.fn.dataTable.render.number(' ', ',', 2, '').display(_summadoc) + newObj.data[
          0].dognet_spdened.short_code

        ajaxRequest_sendMail_docStatus(_docnumber, _namedoc, _ispolname, _docstatus, _summadoc,
          _koddoc, _kodstatus, _kodispol, 'sendMail');
      } else if (action === "edit") {
        // осуществляем глубокое копирование объекта и инициализируем переменную
        let newObj = JSON.parse(JSON.stringify(json));
        // console.log( newObj.data[0] );
        _docnumber = newObj.data[0].dognet_docbase.docnumber;
        _namedoc = newObj.data[0].dognet_docbase.docnameshot;
        _ispolname = newObj.data[0].dognet_spispol.ispolnamefull;
        _docstatus = newObj.data[0].dognet_spstatus.statusnameshot;
        _koddoc = newObj.data[0].dognet_docbase.koddoc;
        _kodstatus = newObj.data[0].dognet_docbase.kodstatus;
        _kodispol = newObj.data[0].dognet_docbase.kodispol;

        _summadoc = newObj.data[0].dognet_docbase.docsumma;
        _summadoc = $.fn.dataTable.render.number(' ', ',', 2, '').display(_summadoc) + newObj.data[
          0].dognet_spdened.short_code;
        // Отправляем уведомление на email только если статус договора меняется на "ЕСТЬ СКАН" или "ТЕКУЩИЙ" с отличного (window._kodstatusbefore)
        if ((_kodstatus == "245597345680479" || _kodstatus == "245381842747296") && _kodstatus !=
          window._kodstatusbefore) {
          ajaxRequest_sendMail_docStatus(_docnumber, _namedoc, _ispolname, _docstatus, _summadoc,
            _koddoc, _kodstatus, _kodispol, 'sendMail');
        }

      }
    });
    //
    //
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    //
    //
    // Array to track the ids of the edit displayed rows
    var detailRows = [];

    $('#docview-edit-tab1_dogovor tbody').on('click', 'tr td.details-control', function() {
      var tr = $(this).closest('tr');
      var row = table_tab1_dogovor.row(tr);
      var idx = $.inArray(tr.attr('id'), detailRows);

      if (row.child.isShown()) {
        tr.removeClass('edit');
        row.child.hide();

        // Remove from the 'open' array
        detailRows.splice(idx, 1);
      } else {
        tr.addClass('edit');
        rowData = table_tab1_dogovor.row(row);
        d = row.data();
        rowData.child(<?php include('templates/docview-edit_tab1_dogovor.tpl'); ?>).show();
        // Add to the 'open' array
        if (idx === -1) {
          detailRows.push(tr.attr('id'));
        }
      }
    });
    // On each draw, loop over the `detailRows` array and show any child rows
    table_tab1_dogovor.on('draw', function() {
      $.each(detailRows, function(i, id) {
        $('#' + id + ' td.details-control').trigger('click');
      });
    });

  });
</script>
<?php
// ----- ----- ----- ----- -----
// Подключаем форму и выводим таблицу договора
// :::
include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/docview/docview-edit/restr_5/tabs/forms/docview-edit_tab1_dogovor-customForm.php");
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-edit/restr_5/tabs/css/docview-edit-tab1_dogovor.css">
<section>
  <div id="docview-tab1_dogovor" class="" style="padding:0 5px">
    <div class="space30"></div>
    <h3 class="parent-title space20">Основной договор</h3>
    <div class="demo-html"></div>
    <table id="docview-edit-tab1_dogovor" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
      <thead>
        <tr>
          <th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
          <th class="text-center text-uppercase">Название договора</th>
          <th class="text-uppercase">Сумма</th>
        </tr>
      </thead>
    </table>
  </div>
</section>