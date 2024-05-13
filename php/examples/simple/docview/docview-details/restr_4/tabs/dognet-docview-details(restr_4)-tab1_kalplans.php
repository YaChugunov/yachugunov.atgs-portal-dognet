<script type="text/javascript" language="javascript" class="init">
var editor_tab1_kalplans; // use a global for the submit and return data rendering in the examples
var table_tab1_kalplans; // use a global for the submit and return data rendering in the examples

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

$(document).ready(function() {
    table_tab1_kalplans = $('#docview-details-tab1_kalplans').DataTable({
        // 		dom: "<'row space20'<'col-md-8 col-sm-12'><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'ltip>>",
        dom: "t",
        language: {
            url: "russian.json"
        },
        ajax: {
            url: "php/examples/php/docview/docview-details/dognet-docview-details-tab1_kalplans-process.php",
            type: "POST"
        },
        serverSide: true,
        createdRow: function(row, data, index) {
            if (data.dognet_dockalplan.idobjectready == 1) {
                // 					$(row).css('background-color','rgb(255, 240, 240)');
                $('td', row).eq(3).addClass('highlight_warning');
            }
        },
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
                data: "dognet_dockalplan.dateplan",
                className: "text-center"
            },
            {
                data: "dognet_dockalplan.summastage"
            },
            {
                data: "dognet_dockalplan.warranty_period",
                className: "text-center"
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
                type: "de_date",
                render: function(data, type, row, meta) {
                    if (data instanceof Date) {
                        return moment(data, 'YYYY-MM-DD').format('DD.MM.YYYY');
                    } else {
                        return row.dognet_dockalplan.srokstage;
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
                    if (data !== 0) {
                        return data;
                    } else {
                        return '---';
                    }
                },
                targets: 5
            },
        ],
        order: [
            [1, "asc"]
        ],
        select: false,
        processing: false,
        paging: false,
        searching: false,
        lengthChange: false
    });

    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    // Array to track the ids of the details displayed rows
    var detailRows = [];

    $('#docview-details-tab1_kalplans tbody').on('click', 'tr td.details-control', function() {
        var tr = $(this).closest('tr');
        var row = table_tab1_kalplans.row(tr);
        var idx = $.inArray(tr.attr('id'), detailRows);

        if (row.child.isShown()) {
            tr.removeClass('details');
            row.child.hide();

            // Remove from the 'open' array
            detailRows.splice(idx, 1);
        } else {
            tr.addClass('details');
            rowData = table_tab1_kalplans.row(row);
            d = row.data();
            d.chkplanav1 = (d.dognet_dockalplan.useav1plan == 1) ?
                "<span class='glyphicon glyphicon-check'></span>" : "-";
            d.chkplanav2 = (d.dognet_dockalplan.useav2plan == 1) ?
                "<span class='glyphicon glyphicon-check'></span>" : "-";
            d.chkplanav3 = (d.dognet_dockalplan.useav3plan == 1) ?
                "<span class='glyphicon glyphicon-check'></span>" : "-";
            d.chkplanav4 = (d.dognet_dockalplan.useav4plan == 1) ?
                "<span class='glyphicon glyphicon-check'></span>" : "-";

            d.dateplanav1 = (d.dognet_dockalplan.dateplanav1stage == null || d.dognet_dockalplan
                .dateplanav1stage == "") ? "-" : d.dognet_dockalplan.dateplanav1stage;
            d.dateplanav2 = (d.dognet_dockalplan.dateplanav2stage == null || d.dognet_dockalplan
                .dateplanav2stage == "") ? "-" : d.dognet_dockalplan.dateplanav2stage;
            d.dateplanav3 = (d.dognet_dockalplan.dateplanav3stage == null || d.dognet_dockalplan
                .dateplanav3stage == "") ? "-" : d.dognet_dockalplan.dateplanav3stage;
            d.dateplanav4 = (d.dognet_dockalplan.dateplanav4stage == null || d.dognet_dockalplan
                .dateplanav4stage == "") ? "-" : d.dognet_dockalplan.dateplanav4stage;

            d.prplanav1 = (d.dognet_dockalplan.pravplan1stage == null || d.dognet_dockalplan
                .pravplan1stage == 0) ? "-" : d.dognet_dockalplan.pravplan1stage + "%";
            d.prplanav2 = (d.dognet_dockalplan.pravplan2stage == null || d.dognet_dockalplan
                .pravplan2stage == 0) ? "-" : d.dognet_dockalplan.pravplan2stage + "%";
            d.prplanav3 = (d.dognet_dockalplan.pravplan3stage == null || d.dognet_dockalplan
                .pravplan3stage == 0) ? "-" : d.dognet_dockalplan.pravplan3stage + "%";
            d.prplanav4 = (d.dognet_dockalplan.pravplan4stage == null || d.dognet_dockalplan
                .pravplan4stage == 0) ? "-" : d.dognet_dockalplan.pravplan4stage + "%";
            rowData.child(<?php include('templates/docview-details_tab1_kalplans.tpl'); ?>).show();

            // Add to the 'open' array
            if (idx === -1) {
                detailRows.push(tr.attr('id'));
            }
        }
    });
    // On each draw, loop over the `detailRows` array and show any child rows
    table_tab1_kalplans.on('draw', function() {
        $.each(detailRows, function(i, id) {
            $('#' + id + ' td.details-control').trigger('click');
        });
    });

});
</script>
<?php
// ----- ----- ----- ----- -----
// Подключаем стили для таблицы
// :::
?>
<link rel="stylesheet"
      href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-details/restr_4/tabs/css/docview-details-common-tab1_kalplans.css">
<section>
    <div id="tab1_kalplans" class="">
        <h3 class="docview-details-title2 space10">Календарный план</h3>
        <div class="demo-html"></div>
        <table id="docview-details-tab1_kalplans" class="table table-responsive table-bordered display compact"
               cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
                    <th class="text-center text-uppercase">Этап</th>
                    <th class="text-uppercase">Наименование</th>
                    <th class="text-center text-uppercase">Срок выполнения</th>
                    <th class="text-uppercase">Сумма</th>
                    <th class="text-uppercase">Гарантийный срок ( мес )</th>
                </tr>
            </thead>
        </table>
    </div>
</section>