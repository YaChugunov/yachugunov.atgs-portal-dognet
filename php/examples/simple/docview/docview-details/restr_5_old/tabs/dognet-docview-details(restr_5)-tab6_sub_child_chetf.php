<script type="text/javascript" language="javascript" class="init">
$(document).ready(function() {
  //
  //
  //
  // СЧЕТ-ФАКТУРА
  //
  // ----- ----- -----
  // Обработчик таблицы счетов-фактур
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
    createdRow: function(row, data, index) {

    },
    rowCallback: function(row, data) {

    },
    columns: [{
        class: "details-control",
        searchable: false,
        orderable: false,
        data: null,
        defaultContent: "<span class='glyphicon glyphicon-option-vertical'></span>"
      },
      {
        data: "dognet_docchfsubpodr.datechfsubpodr"
      },
      {
        data: "dognet_docchfsubpodr.numberchfsubpodr"
      },
      {
        data: null
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
        render: function() {
          return '';
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
        targets: 5
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
  // ----- ----- -----
  // Обработчик child-таблицы выбранного счета
  // Array to track the ids of the details displayed rows
  var detailRows_sub_child_chetf = [];
  $('#docview-sub-child-chetf tbody').on('click', 'tr td.details-control', function() {
    var tr = $(this).closest('tr');
    var row = table_sub_child_chetf.row(tr);
    var idx = $.inArray(tr.attr('id'), detailRows_sub_child_chetf);

    if (row.child.isShown()) {
      tr.removeClass('details');
      row.child.hide();

      // Remove from the 'open' array
      detailRows_sub_child_chetf.splice(idx, 1);
    } else {
      tr.addClass('details');
      rowData = table_sub_child_chetf.row(row);
      d = row.data();
      rowData.child(<?php include('templates/docview-details_tab6_sub_child_chetf.tpl'); ?>).show();

      // Add to the 'open' array
      if (idx === -1) {
        detailRows_sub_child_chetf.push(tr.attr('id'));
      }
    }
  });
  // On each draw, loop over the `detailRows` array and show any child rows
  table_sub_child_chetf.on('draw', function() {
    $.each(detailRows_sub_child_chetf, function(i, id) {
      $('#' + id + ' td.details-control').trigger('click');
    });
  });
});
</script>
<?php
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
?>
<link rel="stylesheet"
  href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-details/restr_5/tabs/css/docview-details-common-tab6_sub_child_chetf.css">
<h3 class="docview-details-title2 text-right">Выставленные счета-фактуры</h3>
<div class="demo-html"></div>
<table id="docview-sub-child-chetf" class="table table-responsive table-bordered display compact" cellspacing="0"
  width="100%">
  <thead>
    <tr>
      <th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
      <th>Дата</th>
      <th>Счет-фактура</th>
      <th></th>
      <th>Сумма</th>
      <th>Задолженность</th>
    </tr>
  </thead>
</table>