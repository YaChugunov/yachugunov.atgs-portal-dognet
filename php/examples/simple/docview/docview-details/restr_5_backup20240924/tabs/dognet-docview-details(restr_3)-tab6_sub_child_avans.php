<script type="text/javascript" language="javascript" class="init">
$(document).ready(function() {
    //
    //
    //
    // АВАНС
    //
    // ----- ----- -----
    // Обработчик таблицы счетов
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
                        if (row.dognet_spdened.short_code != null) {
                            return $.fn.dataTable.render.number(' ', ',', 2, '').display(data) +
                                row.dognet_spdened.short_code;
                        } else {
                            return $.fn.dataTable.render.number(' ', ',', 2, '').display(data) +
                                " руб.";
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
            }
        ],
        order: [
            [0, "asc"]
        ],
        buttons: []
    });
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    //
    // Обработчики событий таблицы счетов
    table_sub_child_chetf.on('select', function() {
        table_sub_child_oplatachf.ajax.reload(null, false);
        table_sub_child_avans.ajax.reload(null, false);
    });
    table_sub_child_chetf.on('deselect', function() {
        table_sub_child_oplatachf.row({
            selected: true
        }).deselect();
        table_sub_child_oplatachf.ajax.reload(null, false);
        table_sub_child_avans.row({
            selected: true
        }).deselect();
        table_sub_child_avans.ajax.reload(null, false);
    });
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
});
</script>
<?php
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
?>
<link rel="stylesheet"
    href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-details/restr_3/tabs/css/docview-details-common-tab6_sub_child_avans.css">
<h3 class="docview-details-title2 text-right">Авансовые платежи</h3>
<div class="demo-html"></div>
<table id="docview-sub-child-avans" class="table table-responsive table-bordered display compact" cellspacing="0"
    width="100%">
    <thead>
        <tr>
            <th></th>
            <th>ID аванса</th>
            <th>Дата</th>
            <th>Сумма</th>
        </tr>
    </thead>
</table>