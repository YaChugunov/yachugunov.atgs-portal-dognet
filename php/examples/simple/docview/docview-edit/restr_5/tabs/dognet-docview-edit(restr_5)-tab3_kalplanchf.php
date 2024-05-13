<script type="text/javascript" language="javascript" class="init">
  var editor_tab3_kalplanchf;
  var table_tab3_kalplanchf;
  var editor_tab3_oplatachf;
  var table_tab3_oplatachf;
  var editor_tab3_chfavans;
  var table_tab3_chfavans;

  //
  //
  var reqField_sumallchf = {
    sumallchf: function(response) {}
  };

  function ajaxRequest_sumallchf(data1, data2, data3, data4, responseHandler) {
    var response = false;

    // Fire off the request to /form.php
    request = $.ajax({
      url: "php/examples/simple/docview/docview-edit/restr_5/tabs/process/ajaxrequests/ajaxReq-docviewedit-tab3_kalplanchf-sumallchf.php",
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
      var sumchf = x[2];
      var sumzadol = x[3];
      var sumoplchf = x[4];
      var sumoplavchf = x[5];
      var sumchf_html = (parseFloat(sumchf) != 0) ? '<span title="Сумма всех счетов-фактур по договору" class="">' +
        sumchf +
        '</span>' : '<span title="Сумма всех счетов-фактур по договору" class="">' + sumchf + '</span>';
      var sumzadol_html = (parseFloat(sumzadol) != 0) ?
        '<span title="Суммарная задолженность по всем счетам-фактурам" class="" style="color:#fff; padding:2px 5px; background-color:#951302">' +
        sumzadol +
        '</span>' :
        '<span title="Суммарная задолженность по всем счетам-фактурам" class="" style="color:#fff; padding:2px 5px; background-color:#46a512">' +
        sumzadol + '</span>';
      var sumoplchf_html = (parseFloat(sumoplchf) != 0) ?
        '<span title="Сумма всех оплат по всем счетам-фактурам по договору" class="">' +
        sumoplchf +
        '</span>' : '<span title="Сумма всех оплат по всем счетам-фактурам по договору" class="">' + sumoplchf +
        '</span>';
      var sumoplavchf_html = (parseFloat(sumoplavchf) != 0) ?
        '<span title="Сумма всех зачетов авансов по всем счетам-фактурам по договору" class="">' +
        sumoplavchf +
        '</span>' : '<span title="Сумма всех зачетов авансов по всем счетам-фактурам по договору" class="">' +
        sumoplavchf + '</span>';
      // editor_tab2_kalplans.field('dognet_dockalplan.summastage').message(res);
      $('#sumctrl_chf_title').html(sumchf_html + " / " + sumoplchf_html + " / " + sumoplavchf_html + " / " +
        sumzadol_html);
      console.log("ajaxRequest_sumallchf : " + doc_summa + " / " + stage_summa + " / " + sumchf + " / " + sumzadol +
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

    // СЧЕТА-ФАКТУРЫ : форма редактирования
    editor_tab3_kalplanchf = new $.fn.dataTable.Editor({
      display: "bootstrap",
      ajax: {
        url: "php/examples/simple/docview/docview-edit/restr_5/tabs/process/dognet-docview-edit(restr_5)-tab3_kalplanchf-process.php",
        data: function(d) {
          d.usekodavans = $("#DTE_Field_usekodavans option:selected").val();
          if ($("#DTE_Field_useavans_0").is(':checked')) {
            d.useavans = 1;
          } else {
            d.useavans = 0;
          }
          console.log("d.useavans : " + d.useavans);
        }
      },
      table: "#docview-edit-tab3_kalplanchf",
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
        label: "Этап",
        type: "select",
        name: "dognet_kalplanchf.kodkalplan",
        def: "---",
        placeholder: "Выберите этап"
      }, {
        label: "Дата",
        name: "dognet_kalplanchf.chetfdate",
        type: "datetime",
        format: "DD.MM.YYYY",
        def: function() {
          return new Date();
        }
        // 				attr: { readonly: "readonly" }
        // ----- ----- ----- ----- -----
      }, {
        label: "Сумма СФ",
        name: "dognet_kalplanchf.chetfsumma"
      }, {
        label: "Комментарий",
        name: "dognet_kalplanchf.comment"
      }, {
        label: "№ счета",
        name: "dognet_kalplanchf.chetfnumber"
        // ----- ----- ----- ----- -----
      }, {
        label: "",
        name: "useavans",
        type: "checkbox",
        unselectedValue: 0,
        options: {
          "": 1
        }
      }, {
        label: "Дата аванса : сумма / остаток",
        type: "select",
        name: "usekodavans"
      }, {
        label: "Сумма к зачету",
        name: "usesumzachet",
        def: 0.0
      }, {
        label: "",
        name: "useallostatok",
        type: "checkbox",
        unselectedValue: 0,
        options: {
          "": 1
        }
      }, {
        type: "hidden",
        name: "usesumzachet_tmp"
      }]
    });
    //
    // Изменяем размер диалогового окна редактирования договора субподряда
    editor_tab3_kalplanchf.on('open', function() {
      $(".modal-dialog").css({
        "width": "60%",
        "min-width": "640px",
        "max-width": "800px"
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
    table_tab3_kalplanchf = $('#docview-edit-tab3_kalplanchf').DataTable({

      dom: "<'row'<'col-sm-5'B><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-4'i><'col-sm-8'p>>",
      language: {
        url: "php/examples/simple/docview/docview-edit/dt_russian-tab3_kalplanchf.json"
      },
      ajax: {
        url: "php/examples/simple/docview/docview-edit/restr_5/tabs/process/dognet-docview-edit(restr_5)-tab3_kalplanchf-process.php",
        type: "POST"
      },
      stateSave: false,
      serverSide: true,
      processing: true,
      select: {
        style: 'single'
      },
      paging: true,
      pageLength: 5,
      lengthChange: false,
      columns: [{
          data: "dognet_kalplanchf.kodkalplan",
          render: function(data, type, row) {
            if (row.dognet_docbase.kodshab === "1" || row.dognet_docbase.kodshab ===
              "3") {
              return row.dognet_dockalplan.numberstage;
            }
            if (row.dognet_docbase.kodshab === "2" || row.dognet_docbase.kodshab ===
              "4") {
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
          data: "dognet_kalplanchf.comment",
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
          orderable: true,
          searchable: false,
          type: "date",
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
          targets: 5
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
          targets: 6
        }
      ],
      order: [
        [3, 'desc'],
        [2, 'desc'],
        [0, 'asc']
      ],
      buttons: [{
          text: '<span class="glyphicon glyphicon-refresh"></span>',
          action: function(e, dt, node, config) {
            table_tab3_kalplanchf.columns().search('').draw();
          }
        },
        {
          extend: "create",
          editor: editor_tab3_kalplanchf,
          text: "НОВЫЙ СЧЕТ-ФАКТУРА",
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
    editor_tab3_oplatachf = new $.fn.dataTable.Editor({
      display: "bootstrap",
      ajax: {
        url: 'php/examples/simple/docview/docview-edit/restr_5/tabs/process/dognet-docview-edit(restr_5)-tab3_oplatachf_child-process.php',
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
      table: '#docview-edit-tab3_oplata',
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
        label: "Сумма платежа :",
        name: "dognet_oplatachf.summaopl"
      }, {
        label: "Дата платежа :",
        name: "dognet_oplatachf.dateopl",
        type: "datetime",
        format: "DD.MM.YYYY",
        def: function() {
          return new Date();
        }
        /* 				attr: { readonly: "readonly" } */
      }, {
        label: "Счет-фактура :",
        name: "dognet_oplatachf.kodchfact",
        type: "select",
        placeholder: "Выберите счет-фактуру"
      }, {
        label: "Комментарий :",
        name: "dognet_oplatachf.comment"
      }]
    });
    //
    // Изменяем размер диалогового окна редактирования договора субподряда
    editor_tab3_oplatachf.on('open', function() {
      $(".modal-dialog").css({
        "width": "60%",
        "min-width": "640px",
        "max-width": "800px"
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
    table_tab3_oplatachf = $('#docview-edit-tab3_oplata').DataTable({
      dom: "<'row'<'col-md-8 col-sm-12'B><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'>>",
      // 		dom: "Bfrtip",
      language: {
        url: "php/examples/simple/docview/docview-edit/dt_russian-tab3_oplatachf.json"
      },
      ajax: {
        url: "php/examples/simple/docview/docview-edit/restr_5/tabs/process/dognet-docview-edit(restr_5)-tab3_oplatachf_child-process.php",
        type: 'post',
        data: function(d) {
          var selected = table_tab3_kalplanchf.row({
            selected: true
          });
          if (selected.any()) {
            d.kodchfact = selected.data().dognet_kalplanchf.kodchfact;
            d.kodkalplan = selected.data().dognet_kalplanchf.kodkalplan;
          }
          var selected2 = table_tab3_oplatachf.row({
            selected: true
          });
          if (selected2.any()) {}
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
    editor_tab3_chfavans = new $.fn.dataTable.Editor({
      display: "bootstrap",
      ajax: {
        url: 'php/examples/simple/docview/docview-edit/restr_5/tabs/process/dognet-docview-edit(restr_5)-tab3_chfavans_child-process.php',
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
      table: '#docview-edit-tab3_avans',
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
        label: "Сумма :",
        name: "dognet_chfavans.summaoplav"
      }, {
        label: "Счет-фактура :",
        name: "dognet_chfavans.kodchfact",
        type: "select"
      }, {
        label: "Аванс :",
        name: "dognet_chfavans.kodavans",
        type: "select",
        placeholder: "Выберите аванс"
      }, {
        label: "Комментарий :",
        name: "dognet_chfavans.comment"
      }, {
        label: "",
        name: "useostatok",
        type: "checkbox",
        unselectedValue: 0,
        options: {
          "": 1
        }
      }, {
        type: "hidden",
        name: "dognet_chfavans.tmp"
      }]
    });
    //
    // Изменяем размер диалогового окна редактирования договора субподряда
    editor_tab3_chfavans.on('open', function() {
      $(".modal-dialog").css({
        "width": "60%",
        "min-width": "640px",
        "max-width": "800px"
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
    table_tab3_chfavans = $('#docview-edit-tab3_avans').DataTable({
      dom: "<'row'<'col-md-8 col-sm-12'B><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'>>",
      language: {
        url: "php/examples/simple/docview/docview-edit/dt_russian-tab3_chfavans.json"
      },
      ajax: {
        url: "php/examples/simple/docview/docview-edit/restr_5/tabs/process/dognet-docview-edit(restr_5)-tab3_chfavans_child-process.php",
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
          data: "dognet_chfavans.dateoplav",
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
    editor_tab3_kalplanchf
      .on('open', function() {
        // Store the values of the fields on open
        openVals_tab3_kalplanchf = JSON.stringify(editor_tab3_kalplanchf.get());
        editor_tab3_kalplanchf.on('preBlur', function(e) {
          // On close, check if the values have changed and ask for closing confirmation if they have
          if (openVals_tab3_kalplanchf !== JSON.stringify(editor_tab3_kalplanchf.get())) {
            return confirm('Вы не сохранили данные формы. Уверены, что хотите ее закрыть?');
          }
        })
        $('#DTE_Field_dognet_kalplanchf-chetfsumma').inputmask({
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
        $('#DTE_Field_dognet_kalplanchf-chetfdate').inputmask({
          mask: "99.99.9999"
        });
        $('#DTE_Field_usesumzachet').inputmask({
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
            var x1 = unmaskedValue.split('.');
            return x1[0].replace(/\ /g, '') + '.' + x1[1];
          }
        });
      });
    editor_tab3_oplatachf
      .on('open', function() {
        $('#DTE_Field_dognet_oplatachf-summaopl').inputmask({
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
        $('#DTE_Field_dognet_oplatachf-dateopl').inputmask({
          mask: "99.99.9999"
        });
      });
    editor_tab3_chfavans
      .on('open', function() {
        $('#DTE_Field_dognet_chfavans-summaoplav').inputmask({
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
      table_tab4_avans.ajax.reload();
      $('button.tab1-refreshButton').click();
    });
    //
    editor_tab3_oplatachf.on('submitSuccess', function() {
      table_tab3_kalplanchf.ajax.reload(null, false);
      $('button.tab1-refreshButton').click();
    });
    editor_tab3_oplatachf.on('initEdit initCreate', function() {
      editor_tab3_oplatachf.disable(['dognet_oplatachf.kodchfact']);
    });
    //
    editor_tab3_chfavans.on('submitSuccess', function() {
      table_tab3_kalplanchf.ajax.reload(null, false);
      table_tab4_avans.ajax.reload();
      $('button.tab1-refreshButton').click();
    });
    editor_tab3_chfavans.on('initEdit initCreate', function() {
      editor_tab3_chfavans.disable(['dognet_chfavans.kodchfact']);
    });

    // Обрабатываем checkbox "Зачесть остаток аванса"
    editor_tab3_chfavans.on('open', function() {
      editor_tab3_chfavans.field('dognet_chfavans.tmp').set(editor_tab3_chfavans.field(
        'dognet_chfavans.summaoplav').get());

      editor_tab3_chfavans.dependent('dognet_chfavans.kodavans', function(val, data, callback) {
        editor_tab3_chfavans.field('useostatok').set(0);
        if (val != '') {
          var val_selected = $('#DTE_Field_dognet_chfavans-kodavans option:selected')
            .val();
          var txt_selected = $('#DTE_Field_dognet_chfavans-kodavans option:selected')
            .text();
          if (txt_selected != '') {
            var x = txt_selected.split('/');
            var sum = (x[1] != '') ? x[1].replace(/\ /g, '') : "";
            var ost = (x[2] != '') ? x[2].replace(/\ /g, '') : "";
            console.log("TXT " + txt_selected);
            console.log("SUM " + sum + " / OST " + ost);
          }
          if (ost > 0.0) {
            $('#fieldset-table-row_useostatok').css({
              "display": ""
            });
            editor_tab3_chfavans.field('useostatok').enable();
            editor_tab3_chfavans.field('useostatok').show(false);
            editor_tab3_chfavans.dependent('useostatok', function(val, data, callback) {
              if (val == 1) {
                editor_tab3_chfavans.field('dognet_chfavans.summaoplav')
                  .disable();
                editor_tab3_chfavans.field('dognet_chfavans.summaoplav')
                  .set(ost);
              } else {
                editor_tab3_chfavans.field('dognet_chfavans.summaoplav')
                  .enable();
                editor_tab3_chfavans.field('dognet_chfavans.summaoplav')
                  .set(editor_tab3_chfavans.field('dognet_chfavans.tmp')
                    .get());
              }
            });
          } else {
            $('#fieldset-table-row_useostatok').css({
              "display": "none"
            });
            editor_tab3_chfavans.field('useostatok').disable();
            editor_tab3_chfavans.field('useostatok').hide(false);
          }
        } else {
          $('#fieldset-table-row_useostatok').css({
            "display": "none"
          });
          editor_tab3_chfavans.field('useostatok').disable();
          editor_tab3_chfavans.field('useostatok').hide(false);
        }
      }, {
        event: 'change'
      });
    });
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    //
    //
    //
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    // Выводим уведомление (цифру) о количестве счетов-фактур
    table_tab3_kalplanchf.on('draw', function() {
      cnt_chf = table_tab3_kalplanchf.page.info().recordsTotal;
      if (cnt_chf > 0) {
        document.getElementById("chf_newitems_cnt").innerHTML = cnt_chf;
      } else {
        document.getElementById("chf_newitems_cnt").innerHTML = "";
      }

      selected = table_tab3_kalplanchf.row({
        selected: true
      });
      console.log('ajaxRequest_sumallchf (selected): ' + selected);
      if (selected.any()) {
        kodkalplan = selected.data().dognet_kalplanchf.kodkalplan;
      } else {
        kodkalplan = null;
      }
      console.log('ajaxRequest_sumallchf (kodkalplan): ' + kodkalplan);

      ajaxRequest_sumallchf(null, uniqueID, kodkalplan, null, 'sumallchf');


    });
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
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    // Variable to hold request
    var request;
    var request2;

    editor_tab3_kalplanchf.on('open', function(e, mode, action) {
      console.log("action : " + action);
      e.preventDefault();
      if (action == "create") {
        editor_tab3_kalplanchf.field('useavans').enable();
        //
        $("#DTE_Field_dognet_kalplanchf-kodkalplan").on("change", function(val) {

          // Serialize the data in the form
          // var serializedData = $form.serialize();
          var kodkalplan = $("#DTE_Field_dognet_kalplanchf-kodkalplan").val();

          if ($("#DTE_Field_dognet_kalplanchf-kodkalplan option:selected").val() != "") {

            // Fire off the request to /form.php
            request2 = $.ajax({
              url: "php/examples/simple/docview/docview-edit/restr_5/tabs/process/dognet-docview-edit(restr_5)-tab3_kalplanchf_fetch2-process.php",
              type: "post",
              cache: false,
              data: {
                "kodkalplan": kodkalplan
              }
            });
            // Callback handler that will be called on success
            request2.done(function(response, textStatus, jqXHR) {
              // Log a message to the console
              console.log("Request 2 status : " + textStatus);
              console.log("Request 2 response : " + response.replace(/\r?\n/g,
                ""));
              if (response.replace(/\r?\n/g, "") == "avans 0") {
                $("#check-useavans").css("display", "none");
                editor_tab3_kalplanchf.field('useavans').hide(false);
              }
              if (response.replace(/\r?\n/g, "") == "avans 1") {
                $("#check-useavans").css("display", "");
                editor_tab3_kalplanchf.field('useavans').show(false);
              }
            });
          } else {
            $("#check-useavans").css("display", "none");
            editor_tab3_kalplanchf.field('useavans').hide(false);
          }

          // setup some local variables
          var $form = $('.DTE_Action_Create');

          // Let's select and cache all the fields
          var $inputs = $form.find("select");

          // Let's disable the inputs for the duration of the Ajax request.
          // Note: we disable elements AFTER the form data has been serialized.
          // Disabled form elements will not be serialized.
          $inputs.prop("disabled", true);

          // Fire off the request to /form.php
          request = $.ajax({
            url: "php/examples/simple/docview/docview-edit/restr_5/tabs/process/dognet-docview-edit(restr_5)-tab3_kalplanchf_fetch-process.php",
            type: "post",
            cache: false,
            data: {
              "kodkalplan": kodkalplan
            }
          });

          // Callback handler that will be called on success
          request.done(function(response, textStatus, jqXHR) {
            // Log a message to the console
            console.log("Hooray, it worked : " + textStatus);
            console.log(kodkalplan);
            /*         $("#OutputResult").html(response); */
            $("#DTE_Field_usekodavans").html(response);
          });

          // Callback handler that will be called on failure
          request.fail(function(jqXHR, textStatus, errorThrown) {
            // Log the error to the console
            console.error(
              "The following error occurred: " +
              textStatus, errorThrown
            );
          });

          // Callback handler that will be called regardless
          // if the request failed or succeeded
          request.always(function() {
            // Reenable the inputs
            $inputs.prop("disabled", false);
          });


        });
        //

        editor_tab3_kalplanchf.dependent('dognet_kalplanchf.kodkalplan', function(val, data,
          callback) {
          editor_tab3_kalplanchf.field('useavans').set(0);
        }, {
          event: 'change'
        });
        //
        editor_tab3_kalplanchf.dependent('useavans', function(val, data, callback) {
          if (val == 1) {
            $("#div-useavans").css("display", "");

            // Обрабатываем возможность "Зачесть аванс" прямо в форме создания СФ
            editor_tab3_kalplanchf.dependent('usekodavans', function(val, data,
              callback) {
              editor_tab3_kalplanchf.field('usesumzachet_tmp').set(
                editor_tab3_kalplanchf.field('usesumzachet').get());
              editor_tab3_kalplanchf.field('useallostatok').set(0);
              var val_selected = $('#DTE_Field_usekodavans option:selected')
                .val();
              if (val_selected != 'nozachet' && val_selected != 'zachetall' &&
                val_selected != '') {
                $('#div-usesumzachet').css({
                  "display": ""
                });
                var txt_selected = $(
                  '#DTE_Field_usekodavans option:selected').text();
                if (txt_selected != '') {
                  var x = txt_selected.split('/');
                  var y = x[0].split(':');
                  var sum = (y[1] != '') ? y[1].replace(/\ /g, '') : "";
                  var ost = (x[1] != '') ? x[1].replace(/\ /g, '') : "";
                  console.log("TXT " + txt_selected);
                  console.log("SUM " + sum + " / OST " + ost);
                }
                if (ost > 0.0) {
                  $('#fieldset-table-row_useallostatok').css({
                    "display": ""
                  });
                  editor_tab3_kalplanchf.field('useallostatok').enable();
                  editor_tab3_kalplanchf.field('useallostatok').show(
                    false);
                  editor_tab3_kalplanchf.dependent('useallostatok',
                    function(val, data, callback) {
                      if (val == 1) {
                        editor_tab3_kalplanchf.field(
                          'usesumzachet').disable();
                        editor_tab3_kalplanchf.field(
                          'usesumzachet').set(ost);
                      } else {
                        editor_tab3_kalplanchf.field(
                          'usesumzachet').enable();
                        editor_tab3_kalplanchf.field(
                          'usesumzachet').set(
                          editor_tab3_kalplanchf.field(
                            'usesumzachet_tmp').get());
                      }
                    });
                } else {
                  $('#fieldset-table-row_useallostatok').css({
                    "display": "none"
                  });
                  editor_tab3_kalplanchf.field('useallostatok').disable();
                  editor_tab3_kalplanchf.field('useallostatok').hide(
                    false);
                }
              } else if (val_selected == 'zachetall') {
                $('#div-usesumzachet').css({
                  "display": ""
                });
                var txt_selected = $(
                  '#DTE_Field_usekodavans option:selected').text();
                if (txt_selected != '') {
                  var x = txt_selected.split('/');
                  var y = x[0].split(':');
                  var sum = (y[1] != '') ? y[1].replace(/\ /g, '') : "";
                  var ostAll = (x[1] != '') ? x[1].replace(/\ /g, '') :
                    "";
                  console.log("TXT " + txt_selected);
                  console.log("SUM " + sum + " / OST ALL " + ostAll);
                }
                if (ostAll > 0.0) {
                  $('#fieldset-table-row_useallostatok').css({
                    "display": ""
                  });
                  editor_tab3_kalplanchf.field('useallostatok').set(1);
                  editor_tab3_kalplanchf.field('useallostatok').show(
                    false);
                  editor_tab3_kalplanchf.dependent('useallostatok',
                    function(val, data, callback) {
                      if (val == 1) {
                        editor_tab3_kalplanchf.field(
                          'usesumzachet').disable();
                        editor_tab3_kalplanchf.field(
                          'usesumzachet').set(ostAll);
                      } else {
                        editor_tab3_kalplanchf.field(
                          'usesumzachet').enable();
                        editor_tab3_kalplanchf.field(
                          'usesumzachet').set(
                          editor_tab3_kalplanchf.field(
                            'usesumzachet_tmp').get());
                      }
                    });
                } else {
                  $('#fieldset-table-row_useallostatok').css({
                    "display": "none"
                  });
                  editor_tab3_kalplanchf.field('useallostatok').disable();
                  editor_tab3_kalplanchf.field('useallostatok').hide(
                    false);
                }
              } else {
                $('#div-usesumzachet').css({
                  "display": "none"
                });
                $('#fieldset-table-row_useallostatok').css({
                  "display": "none"
                });
                editor_tab3_kalplanchf.field('useallostatok').disable();
                editor_tab3_kalplanchf.field('useallostatok').hide(false);
              }
            }, {
              event: 'change'
            });

            $("#DTE_Field_usekodavans").on("change", function() {
              console.log("usekodavans (text): " + $(
                "#DTE_Field_usekodavans option:selected").text());
              console.log("usekodavans (val): " + $(
                "#DTE_Field_usekodavans option:selected").val());
              if ($("#DTE_Field_usekodavans option:selected").val() == "" ||
                $("#DTE_Field_usekodavans").val() == null || $(
                  "#DTE_Field_usekodavans").val() == undefined) {
                editor_tab3_kalplanchf.field('useallostatok').disable();
                $("#fieldset-table-row_useallostatok").css("display",
                  "none");
                $("#div-usesumzachet").css("display", "none");
              } else {
                editor_tab3_kalplanchf.field('useallostatok').enable();
                $("#fieldset-table-row_useallostatok").css("display", "");
                $("#div-usesumzachet").css("display", "");
              }
            });
          } else {
            $("#div-useavans").css("display", "none");
          }
        });
      }
      if (action != "create") {
        editor_tab3_kalplanchf.field('useavans').disable();
      }
    });

  });
</script>
<?php
// ----- ----- ----- ----- -----
// Подключаем формы и выводим таблицы
// :::
include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/docview/docview-edit/restr_5/tabs/forms/docview-edit_tab3_kalplanchf-customForm.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/docview/docview-edit/restr_5/tabs/forms/docview-edit_tab3_kalplanchf_oplata-customForm.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/docview/docview-edit/restr_5/tabs/forms/docview-edit_tab3_kalplanchf_avans-customForm.php");
?>
<section>
  <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-edit/restr_5/tabs/css/docview-edit-tab3_kalplanchf.css">
  <div class="" style="padding-left:5px; padding-right:5px">
    <div class="space30"></div>
    <h3 class="parent-title space20">Счета-фактуры <span id="sumctrl_chf_title" style="font-weight:300; font-size:0.9em; float:right; padding-right:10px"></span></h3>
    <div class="demo-html"></div>
    <table id="docview-edit-tab3_kalplanchf" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
      <thead>
        <tr>
          <th>Этап</th>
          <th>ID счета-фактуры</th>
          <th>№</th>
          <th>Дата</th>
          <th>Комментарий</th>
          <th>Сумма</th>
          <th>Задолженность</th>
        </tr>
      </thead>
    </table>
    <?php
    // ----- ----- ----- ----- -----
    // Таблицы оплат и авансов
    // :::
    ?>
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-edit/restr_5/tabs/css/docview-edit-tab3_kalplanchf_oplata.css">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
      <div class="space30"></div>
      <h3 class="child-title space20">Оплаты по счету-фактуре</h3>
      <div class="demo-html"></div>
      <table id="docview-edit-tab3_oplata" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>ID оплаты</th>
            <th>Дата</th>
            <th>Сумма</th>
          </tr>
        </thead>
      </table>
    </div>
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-edit/restr_5/tabs/css/docview-edit-tab3_kalplanchf_avans.css">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
      <div class="space30"></div>
      <h3 class="child-title space20">Зачтенные авансы / части авансов</h3>
      <div class="demo-html"></div>
      <table id="docview-edit-tab3_avans" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>ID аванса</th>
            <th>Дата аванса</th>
            <th>Дата зачета</th>
            <th>Зачтено</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</section>