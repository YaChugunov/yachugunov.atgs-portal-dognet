<script type="text/javascript" language="javascript" class="init">
$(document).ready(function() {
  // ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
  // ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
  //
  //
  // СЧЕТ-ФАКТУРА
  //
  //
  // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
  // Обработчик таблицы счетов-фактур
  // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
  table_sub_child_chetf = $('#docview-sub-child-chetf').DataTable({
    dom: "<'row'<'col-sm-5'><'col-sm-4'><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-1'B><'col-sm-5'i><'col-sm-6'p>>",
    language: {
      url: "php/examples/simple/docview/docview-details/dt_russian-tab6_sub_child_chetf.json"
    },
    ajax: {
      url: "php/examples/php/docview/docview-details/dognet-docview-details-tab6_sub_child_chetf-process.php",
      type: 'post',
      data: function(d) {
        var selected = table_sub_main.row({
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
    select: true,
    pagingType: 'full',
    createdRow: function(row, data, index) {

    },
    rowCallback: function(row, data) {

    },
    columns: [{
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
        targets: 0
      },
      {
        orderable: true,
        searchable: false,
        type: "date",
        targets: 1
      },
      {
        orderable: true,
        searchable: false,
        targets: 2
      },
      {
        orderable: false,
        searchable: false,
        render: function(data, type, row, meta) {
          if (data != null) {
            if (row.dognet_spdened.short_code != null) {
              return $.fn.dataTable.render.number(' ', ',', 2, '').display(data) + row.dognet_spdened
                .short_code;
            } else {
              return $.fn.dataTable.render.number(' ', ',', 2, '').display(data) + " руб.";
            }
          } else {
            if (row.dognet_spdened.short_code != null) {
              return "0.00" + row.dognet_spdened.short_code;
            } else {
              return "0.00 руб.";
            }
          }
        },
        targets: 3
      },
      {
        orderable: false,
        searchable: false,
        render: function(data, type, row, meta) {
          if (data != null) {
            if (row.dognet_spdened.short_code != null) {
              return $.fn.dataTable.render.number(' ', ',', 2, '').display(data) + row.dognet_spdened
                .short_code;
            } else {
              return $.fn.dataTable.render.number(' ', ',', 2, '').display(data) + " руб.";
            }
          } else {
            if (row.dognet_spdened.short_code != null) {
              return "0.00" + row.dognet_spdened.short_code;
            } else {
              return "0.00 руб.";
            }
          }
        },
        targets: 4
      }
    ],
    order: [
      [1, "desc"],
      [2, "asc"]
    ],
    buttons: [{
      text: '<span class="glyphicon glyphicon-refresh"></span>',
      action: function(e, dt, node, config) {
        table_sub_child_chetf.ajax.reload();
        table_sub_child_chetf.columns().search('').draw();
      }
    }]
  });
  //
  //
  table_sub_child_chetf.on('select', function() {
    table_sub_child_oplatachf.ajax.reload(null, false);
    // table_sub_child_avans.ajax.reload(null, false);
    table_sub_child_avanssplit.ajax.reload(null, false);
  });
  //
  table_sub_child_chetf.on('deselect', function() {
    table_sub_child_oplatachf.row({
      selected: true
    }).deselect();
    table_sub_child_oplatachf.ajax.reload(null, false);
    // table_sub_child_avans.row({
    //   selected: true
    // }).deselect();
    // table_sub_child_avans.ajax.reload(null, false);
    table_sub_child_avanssplit.ajax.reload(null, false);
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
  // ОПЛАТА СЧЕТА-ФАКТУРЫ
  //
  //
  // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
  // Обработчик таблицы оплат счетов-фактур
  // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
  table_sub_child_oplatachf = $('#docview-sub-child-oplatachf').DataTable({
    dom: "<'row'<'col-md-8 col-sm-12'><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'>>",
    language: {
      url: "php/examples/simple/docview/docview-details/dt_russian-tab6_sub_child_oplatachf.json"
    },
    ajax: {
      url: "php/examples/php/docview/docview-details/dognet-docview-details-tab6_sub_child_oplatachf-process.php",
      type: 'post',
      data: function(d) {
        var selected2 = table_sub_main.row({
          selected: true
        });
        if (selected2.any()) {
          d.koddocsubpodr2 = selected2.data().dognet_docsubpodr.koddocsubpodr;
        } else {
          d.koddocsubpodr2 = '';
        }
        var selected = table_sub_child_chetf.row({
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
      var selectedChf = table_sub_child_chetf.row({
        selected: true
      });

      if (selectedChf.any()) {
        data.kodchfsubpodr = selectedChf.data().dognet_docchfsubpodr.kodchfsubpodr;
      } else {
        data.kodchfsubpodr = '';
      }

      if ((data.dognet_docoplchfsubpodr.kodchfsubpodr === data.dognet_docchfsubpodr.kodchfsubpodr) &&
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
          var selectedChf = table_sub_child_chetf.row({
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
              return $.fn.dataTable.render.number(' ', ',', 2, '').display(data) + row.dognet_spdened
                .short_code;
            } else {
              return $.fn.dataTable.render.number(' ', ',', 2, '').display(data) + " руб.";
            }
          } else {
            if (row.dognet_spdened.short_code != null) {
              return "0.00" + row.dognet_spdened.short_code;
            } else {
              return "0.00 руб.";
            }
          }
        },
        targets: 2
      },
    ],
    order: [
      [1, "desc"]
    ],
    buttons: []
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
  // АВАНС / ЗАЧЕТ АВАНСА
  //
  //
  // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
  // Обработчик таблицы авансов
  // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
  table_sub_child_avans = $('#docview-sub-child-avans').DataTable({
    dom: "<'row'<'col-sm-5'><'col-sm-4'><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-1'><'col-sm-5'><'col-sm-6'>>",
    language: {
      url: "php/examples/simple/docview/docview-details/dt_russian-tab6_sub_child_avans.json"
    },
    ajax: {
      url: "php/examples/php/docview/docview-details/dognet-docview-details-tab6_sub_child_avans-process.php",
      type: 'post',
      data: function(d) {
        selected_mainsub = table_sub_main.row({
          selected: true
        });
        if (selected_mainsub.any()) {
          d.koddocsubpodr2 = selected_mainsub.data().dognet_docsubpodr.koddocsubpodr;
          console.log('Sub is selected, d.kodchfsubpodr_avchf is empty, sub is', d
            .koddocsubpodr2);

        } else {
          d.koddocsubpodr2 = '';
          d.kodchfsubpodr_avchf = '';
          console.log('d.kodchfsubpodr_avchf, no sub selected', d.kodchfsubpodr_avchf);
        }

        selected = table_sub_child_chetf.row({
          selected: true
        });
        if (selected.any()) {
          d.kodchfsubpodr_avchf = selected.data().dognet_docchfsubpodr.kodchfsubpodr;
          console.log('Sub is selected, d.kodchfsubpodr_avchf is', d
            .kodchfsubpodr_avchf);
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
      var selectedChf = table_sub_child_chetf.row({
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

      // if (data.dognet_docavsubpodr.kodchfsubpodr === "") {
      //   $(row).css({
      //     'font-style': 'italic',
      //     'color': '#AAA'
      //   });
      // }
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
          var selectedChf = table_sub_child_chetf.row({
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
            dataOutput = "<span style='margin-right:6px'>" + $.fn.dataTable.render.number(' ', ',', 2, '')
              .display(data) + "</span>";
            diff = parseFloat(row.dognet_docavsubpodr.sumavsubpodr) - parseFloat(data);
            color = (diff > 0) ? 'green' : 'inherit';
            diffOutput = (useavans == '1') ? "<span style=''>(&nbsp;" + $.fn.dataTable.render.number(' ',
                ',', 2, '').display(parseFloat(row.dognet_docavsubpodr.sumavsubpodr) - parseFloat(data)) +
              "&nbsp;)</span>" : "( аванс не в сплите )";
            return ((useavans == '1') ? dataOutput : "") + diffOutput + ((useavans != '1') ? "" : row
              .dognet_spdened.short_code);
          } else {
            return "-";
          }
        },
        targets: 6
      }
    ],
    order: [
      [0, "asc"]
    ],
    buttons: []
  });
  //
  //
  table_sub_child_avans.on('select', function() {
    table_sub_child_avanssplit.ajax.reload(null, false);
  });
  //
  table_sub_child_avans.on('deselect', function() {
    table_sub_child_avanssplit.row({
      selected: true
    }).deselect();
    table_sub_child_avanssplit.ajax.reload(null, false);
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
  // СПЛИТ (ЧАСТЬ) АВАНСА / ЗАЧЕТ ЧАСТИ АВАНСА
  //
  //
  // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
  // Обработчик таблицы сплитов аванса
  // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
  table_sub_child_avanssplit = $('#docview-sub-child-avanssplit').DataTable({
    dom: "<'row'<'col-md-8 col-sm-12'><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'>>",
    language: {
      url: "php/examples/simple/docview/docview-details/dt_russian-tab6_sub_child_avanssplit.json"
    },
    ajax: {
      url: "php/examples/php/docview/docview-details/dognet-docview-details-tab6_sub_child_avanssplit-process.php",
      type: 'post',
      data: function(d) {
        var selected_sub = table_sub_main.row({
          selected: true
        });
        if (selected_sub.any()) {
          d.koddocsubpodr = selected_sub.data().dognet_docsubpodr.koddocsubpodr;
        } else {
          d.koddocsubpodr = '';
        }
        //
        //
        var selected_av = table_sub_child_avans.row({
          selected: true
        });
        if (selected_av.any()) {
          d.kodavsubpodr = selected_av.data().dognet_docavsubpodr.kodavsubpodr;
        } else {
          d.kodavsubpodr = '';
        }
        //
        //
        var selected_chf = table_sub_child_avanssplit.row({
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
      var selectedChf = table_sub_child_chetf.row({
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
          var selectedChf = table_sub_child_chetf.row({
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
    buttons: []
  });
  //
  //
  //
});
</script>
<?php
// ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
// ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
?>
<link rel="stylesheet"
  href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-details/restr_4/tabs/css/docview-details-common-tab6_sub_child_chetf.css">
<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
  <div class="space30"></div>
  <h3 class="docview-details-title2 text-right">Выставленные счета-фактуры</h3>
  <div class="demo-html"></div>
  <table id="docview-sub-child-chetf" class="table table-responsive table-bordered display compact" cellspacing="0"
    width="100%">
    <thead>
      <tr>
        <th>ID счета</th>
        <th>Дата</th>
        <th>Счет-фактура</th>
        <th>Сумма</th>
        <th>Задолженность</th>
      </tr>
    </thead>
  </table>
</div>
<?php
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
?>
<link rel="stylesheet"
  href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-details/restr_4/tabs/css/docview-details-common-tab6_sub_child_oplatachf.css">
<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
  <div class="space30"></div>
  <h3 class="docview-details-title2 text-right">Оплаты счетов</h3>
  <div class="demo-html"></div>
  <table id="docview-sub-child-oplatachf" class="table table-responsive table-bordered display compact" cellspacing="0"
    width="100%">
    <thead>
      <tr>
        <th>С-ф</th>
        <th>Дата</th>
        <th>Сумма</th>
      </tr>
    </thead>
  </table>
</div>
<?php
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
?>
<link rel="stylesheet"
  href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-details/restr_4/tabs/css/docview-details-common-tab6_sub_child_avans.css">
<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
  <div class="space30"></div>
  <h3 class="docview-details-title2 text-right">Авансовые платежи</h3>
  <div class="demo-html"></div>
  <table id="docview-sub-child-avans" class="table table-responsive table-bordered display compact" cellspacing="0"
    width="100%">
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
<?php
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
?>
<link rel="stylesheet"
  href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-details/restr_4/tabs/css/docview-details-common-tab6_sub_child_avanssplit.css">
<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
  <div class="space30"></div>
  <h3 class="docview-details-title2 text-right">Сплит аванса</h3>
  <div class="demo-html"></div>
  <table id="docview-sub-child-avanssplit" class="table table-responsive table-bordered display compact" cellspacing="0"
    width="100%">
    <thead>
      <tr>
        <th>С-ф</th>
        <th>Дата</th>
        <th>Сумма</th>
      </tr>
    </thead>
  </table>
</div>