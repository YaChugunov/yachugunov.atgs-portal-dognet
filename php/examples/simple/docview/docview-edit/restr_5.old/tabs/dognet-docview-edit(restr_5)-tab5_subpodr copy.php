<script type="text/javascript" language="javascript" class="init">
  // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
  $(document).ready(function() {
    var editor_tab5_subpodr = new $.fn.dataTable.Editor({
      display: "bootstrap",
      ajax: "php/examples/simple/docview/docview-edit/restr_5/tabs/process/dognet-docview-edit(restr_5)-tab5_subpodr-process.php",
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
        "<'row'<'col-sm-6'><'col-sm-6'>>",
      /* 		dom: "<'row'<'col-md-8 col-sm-12'B><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'>>", */
      language: {
        url: "php/examples/simple/docview/docview-edit/dt_russian-tab5_subpodr.json"
      },
      ajax: {
        url: "php/examples/simple/docview/docview-edit/restr_5/tabs/process/dognet-docview-edit(restr_5)-tab5_subpodr-process.php",
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
          data: "dognet_dockalplan.numberstage",
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
          orderable: true,
          searchable: false,
          visible: false,
          targets: 1
        },
        {
          orderable: true,
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
        [4, 'desc']
      ],
      rowGroup: {
        dataSrc: function(row) {
          if (row.dognet_docbase.kodshab === "1" || row.dognet_docbase.kodshab === "3") {
            return "Этап " + row.dognet_dockalplan.numberstage;
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
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    var editor_tab5_chfsubpodr = new $.fn.dataTable.Editor({
      display: "bootstrap",
      ajax: {
        url: "php/examples/simple/docview/docview-edit/restr_5/tabs/process/dognet-docview-edit(restr_5)-tab5_subpodr_child_chetfact-process.php",
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
        url: "php/examples/simple/docview/docview-edit/restr_5/tabs/process/dognet-docview-edit(restr_5)-tab5_subpodr_child_chetfact-process.php",
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
          data: "dognet_docsubpodr.id"
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
          render: function(data) {
            return "...";
          },
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
              return $.fn.dataTable.render.number(' ', ',', 2, '').display(data) + row
                .dognet_spdened.short_code;
            } else {
              return "0.00" + row.dognet_spdened.short_code;
            }
          },
          targets: 6
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
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    var editor_tab5_oplchfsubpodr = new $.fn.dataTable.Editor({
      display: "bootstrap",
      ajax: {
        url: "php/examples/simple/docview/docview-edit/restr_5/tabs/process/dognet-docview-edit(restr_5)-tab5_subpodr_child_child_oplatachf-process.php",
        data: function(d) {
          var selected2 = table_tab5_subpodr.row({
            selected: true
          });
          if (selected2.any()) {
            d.koddocsubpodr2 = selected2.data().dognet_docsubpodr.koddocsubpodr;
          } else {
            d.koddocsubpodr2 = '';
          }
          var selected = table_tab5_chfsubpodr.row({
            selected: true
          });
          if (selected.any()) {
            d.kodchfsubpodr_oplchf = selected.data().dognet_docchfsubpodr.kodchfsubpodr;
          } else {
            d.kodchfsubpodr_oplchf = '';
          }
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
        url: "php/examples/simple/docview/docview-edit/restr_5/tabs/process/dognet-docview-edit(restr_5)-tab5_subpodr_child_child_oplatachf-process.php",
        type: 'post',
        data: function(d) {
          var selected2 = table_tab5_subpodr.row({
            selected: true
          });
          if (selected2.any()) {
            d.koddocsubpodr2 = selected2.data().dognet_docsubpodr.koddocsubpodr;
          } else {
            d.koddocsubpodr2 = '';
          }
          var selected = table_tab5_chfsubpodr.row({
            selected: true
          });
          if (selected.any()) {
            d.kodchfsubpodr_oplchf = selected.data().dognet_docchfsubpodr.kodchfsubpodr;
          } else {
            d.kodchfsubpodr_oplchf = '';
          }
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
          data: "dognet_docoplchfsubpodr.kodoplchfsubpodr",
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
          orderable: false,
          searchable: false,
          targets: 1
        },
        {
          orderable: true,
          searchable: false,
          type: "date",
          targets: 2
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
          targets: 3
        },
      ],
      order: [
        [2, "desc"]
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
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    var editor_tab5_avchfsubpodr = new $.fn.dataTable.Editor({
      display: "bootstrap",
      ajax: {
        url: "php/examples/simple/docview/docview-edit/restr_5/tabs/process/dognet-docview-edit(restr_5)-tab5_subpodr_child_child_avanschf-process.php",
        data: function(d) {
          var selected2 = table_tab5_subpodr.row({
            selected: true
          });
          if (selected2.any()) {
            d.koddocsubpodr2 = selected2.data().dognet_docsubpodr.koddocsubpodr;
          } else {
            d.koddocsubpodr2 = '';
          }
          var selected = table_tab5_chfsubpodr.row({
            selected: true
          });
          if (selected.any()) {
            d.kodchfsubpodr_avchf = selected.data().dognet_docchfsubpodr.kodchfsubpodr;
          } else {
            d.kodchfsubpodr_avchf = '';
          }
        },
        success: function(json) {
          editor_tab5_avchfsubpodr.field('cancelAvans').processing(false);
        }
      },
      table: "#docview-edit-tab5_avchfsubpodr",
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
      template: '#customForm_tab5_avchfsubpodr',
      fields: [{
        label: "Договор",
        type: "select",
        name: "dognet_docavsubpodr.koddocsubpodr",
        placeholder: "-- Выберите договор"
      }, {
        label: "Счет-фактура",
        type: "select",
        name: "dognet_docavsubpodr.kodchfsubpodr",
        placeholder: "-- Без зачета",
        options: [{
          label: "-- Без зачета",
          value: ""
        }]
      }, {
        label: "Дата аванса",
        name: "dognet_docavsubpodr.dateavsubpodr",
        type: "datetime",
        format: "DD.MM.YYYY"
      }, {
        label: "Сумма аванса",
        name: "dognet_docavsubpodr.sumavsubpodr"
      }, {
        label: "Отменить зачет аванса",
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
        url: "php/examples/simple/docview/docview-edit/restr_5/tabs/process/dognet-docview-edit(restr_5)-tab5_subpodr_child_child_avanschf-process.php",
        type: 'post',
        data: function(d) {
          var selected2 = table_tab5_subpodr.row({
            selected: true
          });
          if (selected2.any()) {
            d.koddocsubpodr2 = selected2.data().dognet_docsubpodr.koddocsubpodr;
          } else {
            d.koddocsubpodr2 = '';
          }

          var selected = table_tab5_chfsubpodr.row({
            selected: true
          });
          if (selected.any()) {
            d.kodchfsubpodr_avchf = selected.data().dognet_docchfsubpodr.kodchfsubpodr;
          } else {
            d.kodchfsubpodr_avchf = '';
          }
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

        if ((data.dognet_docavsubpodr.kodchfsubpodr === data.dognet_docchfsubpodr
            .kodchfsubpodr) &&
          (data.dognet_docavsubpodr.kodchfsubpodr === data.kodchfsubpodr)) {
          /* 								$(row).css({ 'color':'#FFF'	}); */
        }

        if (data.dognet_docavsubpodr.kodchfsubpodr === "") {
          $(row).css({
            'font-style': 'italic',
            'color': '#AAA'
          });
        }
      },
      columns: [{
          data: "dognet_docavsubpodr.kodchfsubpodr",
          className: ""
        },
        {
          data: "dognet_docavsubpodr.kodavsubpodr",
          className: ""
        },
        {
          data: "dognet_docavsubpodr.dateavsubpodr",
          className: ""
        },
        {
          data: "dognet_docavsubpodr.sumavsubpodr",
          className: ""
        }
      ],
      columnDefs: [{
          orderable: true,
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
      order: [
        [0, "asc"]
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
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    //
    //
    //
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
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
          mask: "3-6/9{1,4}"
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
      .on('open', function() {
        // Store the values of the fields on open
        openVals_tab5_oplchfsubpodr = JSON.stringify(editor_tab5_oplchfsubpodr.get());
        editor_tab5_oplchfsubpodr.on('preBlur', function(e) {
          // On close, check if the values have changed and ask for closing confirmation if they have
          if (openVals_tab5_oplchfsubpodr !== JSON.stringify(editor_tab5_oplchfsubpodr
              .get())) {
            return confirm('Вы не сохранили данные формы. Уверены, что хотите ее закрыть?');
          }
        })
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
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    //
    //
    //
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    editor_tab5_avchfsubpodr.dependent('cancelAvans', function(val) {
      if (val == 1) {
        editor_tab5_avchfsubpodr.field('cancelAvans').processing(false);
        editor_tab5_avchfsubpodr.field('dognet_docavsubpodr.kodchfsubpodr').disable();
        editor_tab5_avchfsubpodr.field('dognet_docavsubpodr.kodchfsubpodr').set("");
      } else {
        editor_tab5_avchfsubpodr.field('cancelAvans').processing(false);
        editor_tab5_avchfsubpodr.field('dognet_docavsubpodr.kodchfsubpodr').enable();
      }
    });
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    //
    //
    //
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    table_tab5_subpodr.on('init', function() {
      table_tab5_chfsubpodr.buttons().disable();
      table_tab5_oplchfsubpodr.buttons().disable();
      table_tab5_avchfsubpodr.buttons().disable();
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
    editor_tab5_chfsubpodr.on('initCreate initEdit', function() {
      editor_tab5_chfsubpodr.field('dognet_docchfsubpodr.sumzadolchfsubpodr').disable();
    });
    editor_tab5_oplchfsubpodr.on('submitSuccess', function() {
      table_tab5_chfsubpodr.ajax.reload();
      table_tab5_subpodr.ajax.reload();
    });
    editor_tab5_avchfsubpodr.on('submitSuccess', function() {
      table_tab5_chfsubpodr.ajax.url(
        "php/examples/simple/docview/docview-edit/restr_5/tabs/process/dognet-docview-edit(restr_5)-tab5_subpodr_child_chetfact-process.php"
      ).load();
      table_tab5_subpodr.ajax.url(
        "php/examples/simple/docview/docview-edit/restr_5/tabs/process/dognet-docview-edit(restr_5)-tab5_subpodr-process.php"
      ).load();
      table_tab5_subpodr.ajax.reload();
    });
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    //
    //
    //
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
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
      $(".modal-dialog").css("width", "80%");
    });
    editor_tab5_chfsubpodr.on('close', function() {
      $(".modal-dialog").css("width", "80%");
    });
    // Изменяем размер диалогового окна редактирования оплаты счета
    editor_tab5_oplchfsubpodr.on('open', function() {
      $(".modal-dialog").css("width", "50%");
    });
    editor_tab5_oplchfsubpodr.on('close', function() {
      $(".modal-dialog").css("width", "80%");
    });
    // Изменяем размер диалогового окна редактирования аванса
    editor_tab5_avchfsubpodr.on('open', function() {
      $(".modal-dialog").css("width", "80%");
    });
    editor_tab5_avchfsubpodr.on('close', function() {
      $(".modal-dialog").css("width", "80%");
    });
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----




    $('#docview-edit-tab5_chfsubpodr tbody').on('click', 'tr', function() {
      var rowData = table_tab5_chfsubpodr.row(this).data();
      /*   var rowData0 = table_tab5_chfsubpodr.row( this ).data(0); */
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
include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/docview/docview-edit/restr_5/tabs/forms/docview-edit_tab5_subpodr-customForm.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/docview/docview-edit/restr_5/tabs/forms/docview-edit_tab5_subpodr_chetfact-customForm.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/docview/docview-edit/restr_5/tabs/forms/docview-edit_tab5_subpodr_oplatachf-customForm.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/docview/docview-edit/restr_5/tabs/forms/docview-edit_tab5_subpodr_chfavans-customForm.php");
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-edit/restr_5/tabs/css/docview-edit-tab5_subpodr.css">
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
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-edit/restr_5/tabs/css/docview-edit-tab5_subpodr_chetfact.css">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="space30"></div>
      <h3 class="child-title space20">Счета-фактуры субподрядчика</h3>
      <div class="demo-html"></div>
      <table id="docview-edit-tab5_chfsubpodr" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th></th>
            <th>ID счета</th>
            <th>Дата</th>
            <th>№ счета-фактуры</th>
            <th>...</th>
            <th>Сумма</th>
            <th>Задолженность</th>
          </tr>
        </thead>
      </table>
    </div>
    <?php // ----- ----- ----- ----- ----- 
    ?>
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-edit/restr_5/tabs/css/docview-edit-tab5_subpodr_oplatachf.css">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
      <div class="space30"></div>
      <h3 class="child-title space20">Оплаты по счету-фактуре</h3>
      <div class="demo-html"></div>
      <table id="docview-edit-tab5_oplchfsubpodr" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th></th>
            <th>ID оплаты</th>
            <th>Дата</th>
            <th>Сумма</th>
          </tr>
        </thead>
      </table>
    </div>
    <?php // ----- ----- ----- ----- ----- 
    ?>
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-edit/restr_5/tabs/css/docview-edit-tab5_subpodr_chfavans.css">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
      <div class="space30"></div>
      <h3 class="child-title space20">Авансовые платежи по договору</h3>
      <!-- 			<h3 class="child-title space20"><span id="safasfaslaksjdlkasjd"></span></h3> -->
      <div class="demo-html"></div>
      <table id="docview-edit-tab5_avchfsubpodr" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th></th>
            <th>ID аванса</th>
            <th>Дата</th>
            <th>Сумма</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</section>