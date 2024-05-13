<script type="text/javascript" language="javascript" class="init">
var table_reports_spravka_zadolchf_chets; // use a global for the submit and return data rendering in the examples

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

$(document).ready(function() {

    table_reports_spravka_zadolchf_chets = $('#reports-spravka-zadolchf-chets-table').DataTable({
        dom: "<'row'<'col-sm-5'><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-4'><'col-sm-8'>>",
        // 		dom: "<'space50'r>tip",
        language: {
            url: "russian.json"
        },
        ajax: {
            url: "php/examples/simple/report/report-details/restr_5/reports/spravka/zadolchf_ondate/process/dognet-report-reportview(restr_5)-spravka-zadolchf_ondate-chets-process.php",
            type: "POST"
        },
        serverSide: true,
        columns: [{
                searchable: false,
                orderable: false,
                data: null
            },
            {
                data: "sp_contragents.nameshort",
                className: "text-left"
            },
            {
                data: "dognet_docbase.docnameshot",
                className: "text-left"
            },
            {
                data: "dognet_dockalplan.numberstage",
                className: "text-left"
            },
            {
                orderable: false,
                data: "dognet_reports_zadolchf_ondate.chetfnumber",
                className: "text-left"
            },
            {
                orderable: false,
                data: "dognet_reports_zadolchf_ondate.chetfdate",
                className: "text-left"
            },
            {
                orderable: false,
                data: "dognet_reports_zadolchf_ondate.chetfsumma",
                className: "text-left"
            },
            {
                orderable: false,
                data: "dognet_reports_zadolchf_ondate.summaoplav",
                className: "text-left"
            },
            {
                orderable: false,
                data: "dognet_reports_zadolchf_ondate.summaopl",
                className: "text-left"
            },
            {
                orderable: false,
                data: "dognet_reports_zadolchf_ondate.summazadol",
                className: "text-left"
            },
            {
                data: "dognet_spdened.short_code"
            },
            {
                data: "dognet_docbase.kodstatuszdl"
            },
            {
                data: "dognet_docbase.docnumber"
            },
            {
                data: "dognet_docbase.numberchet"
            },
            {
                data: "sp_objects.nameobjectshot"
            }
        ],
        select: {
            style: 'os',
            selector: 'td:not(:last-child)' // no row selection on last column
        },
        columnDefs: [{
                searchable: false,
                targets: 0,
                render: function(data) {
                    return '';
                }
            },
            {
                searchable: true,
                visible: false,
                targets: 1
            },
            {
                searchable: true,
                visible: false,
                targets: 2
            },
            {
                searchable: true,
                visible: false,
                targets: 3
            },
            {
                searchable: true,
                targets: 4
            },
            {
                searchable: true,
                targets: 5
            },
            {
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
            },
            {
                searchable: false,
                render: function(data, type, row, meta) {
                    if (data != null) {
                        return $.fn.dataTable.render.number(' ', ',', 2, '').display(data) + row
                            .dognet_spdened.short_code;
                    } else {
                        return "0.00" + row.dognet_spdened.short_code;
                    }
                },
                targets: 8
            },
            {
                searchable: false,
                render: function(data, type, row, meta) {
                    if (data != null) {
                        return $.fn.dataTable.render.number(' ', ',', 2, '').display(data) + row
                            .dognet_spdened.short_code;
                    } else {
                        return "0.00" + row.dognet_spdened.short_code;
                    }
                },
                targets: 9
            },
            {
                visible: false,
                targets: 10
            },
            {
                visible: false,
                targets: 11
            },
            {
                searchable: true,
                visible: false,
                targets: 12
            },
            {
                searchable: true,
                visible: false,
                targets: 13
            },
            {
                searchable: true,
                visible: false,
                targets: 14
            }
        ],

        order: [
            [1, "asc"],
            [2, "asc"],
            [3, "asc"],
            [4, "asc"]
        ],
        rowGroup: {
            startRender: function(rows, group, level) {

                if (level == 0) {
                    return '<span style="text-align:left; white-space:nowrap">' + group + '</span>';
                }

                if (level == 1) {
                    var docnumber = rows.data().pluck("dognet_docbase").pluck("docnumber")[0];
                    return '<span style="text-align:left; white-space:nowrap; margin-left:10px">Счет&nbsp;' +
                        docnumber + '&nbsp;:&nbsp;' + group + '</span>';
                }

            },
            endRender: function(rows, group, level) {

                var koddened = rows.data().pluck("dognet_spdened").pluck("short_code")[0];
                var docnumber = rows.data().pluck("dognet_docbase").pluck("docnumber")[0];
                var avg = rows
                    .data()
                    .pluck("dognet_reports_zadolchf_ondate")
                    .pluck("summazadol")
                    .reduce(function(a, b) {
                        return a + b * 1;
                    }, 0);
                var dataSrcArray = table_reports_spravka_zadolchf_chets.rowGroup().dataSrc();

                if (level == 0) {
                    return '<span class="itogo-lvl0"><span class="itogo-lvl0-title">Итого по заказчику</span><span class="itogo-lvl0-text"><span class="itogo-lvl-lbltext3">' +
                        $.fn.dataTable.render.number(' ', ',', 2, '').display(avg) + '' + koddened +
                        '</span></span></span>';
                }
                if (level == 1) {
                    return '<span class="itogo-lvl1"><span class="itogo-lvl1-title">Итого по договору</span><span class="itogo-lvl1-text"><span class="itogo-lvl-lbltext3">' +
                        $.fn.dataTable.render.number(' ', ',', 2, '').display(avg) + '' + koddened +
                        '</span></span></span>';
                }
            },
            dataSrc: ["sp_contragents.nameshort", "dognet_docbase.docnameshot"]
        },

        select: false,
        ordering: true,
        processing: true,
        paging: false,
        pageLength: 15,
        lengthChange: false,
        lengthMenu: [
            [15, 30, 50, -1],
            [15, 30, 50, "Все"]
        ],
        buttons: [{
            text: '<span class="glyphicon glyphicon-refresh"></span>',
            action: function(e, dt, node, config) {
                table_reports_spravka_zadolchf_chets.columns().search('');
                table_reports_spravka_zadolchf_chets.order([3, "asc"], [4, "asc"], [6,
                    "asc"]).draw();
            }
        }],

    });


    //
    //
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    //
    //


    $('#columnSearch_btnApply2').click(function(e) {

        table_reports_spravka_zadolchf_chets
            .columns(11)
            .search($("#reportZadolTypeSearch_text_2").val())
            .draw();

        table_reports_spravka_zadolchf_chets
            .columns(13)
            .search($("#reportChetNumberSearch_text").val())
            .draw();

        table_reports_spravka_zadolchf_chets
            .columns(4)
            .search($("#reportChfNumberSearch_text_2").val())
            .draw();

        table_reports_spravka_zadolchf_chets
            .columns(1)
            .search($("#reportObjectSearch_text_2").val())
            .draw();

        table_reports_spravka_zadolchf_chets
            .columns(2)
            .search($("#reportDocNameSearch_text_2").val())
            .draw();

    });
    $('#columnSearch_btnClear2').click(function(e) {
        $('#reportChetNumberSearch_text').val('');
        $('#reportChfNumberSearch_text_2').val('');
        $('#reportObjectSearch_text_2').val('');
        $('#reportDocNameSearch_text_2').val('');
        table_reports_spravka_zadolchf_chets
            .columns()
            .search('')
            .draw();
    });
    $('#columnSearch_btnRefresh2').click(function(e) {
        table_reports_spravka_zadolchf_chets
            .draw();
    });


    // On each draw, loop over the `detailRows` array and show any child rows
    table_reports_spravka_zadolchf_chets.on('draw', function() {



    });


});
</script>

<style>
/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----

ОСНОВНАЯ ТАБЛИЦА

----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
/*
/* Общее для таблицы */
#docview-details-tab3 {}

#docview-details-tab3 .details-control:hover {
    cursor: hand
}

/*
/*
/* Заголовок таблицы */
#reports-spravka-zadolchf-chets-table>thead {
    background-color: #111;
    font-family: 'Oswald', sans-serif;
    border-bottom: none;
    border-top: none
}

#reports-spravka-zadolchf-chets-table>thead>tr>th {
    color: white;
    border-bottom: none;
    font-weight: 400;
    font-size: 1.0em;
    padding: 5px
}

#reports-spravka-zadolchf-chets-table .sorting:after,
#reports-spravka-zadolchf-chets-table .sorting_asc:after,
#reports-spravka-zadolchf-chets-table .sorting_desc:after {
    display: none
}

#reports-spravka-zadolchf-chets-table>thead>tr>th.sorting_asc {
    padding-right: 8px
}

#reports-spravka-zadolchf-chets-table>thead>tr>th.sorting_desc {
    padding-right: 8px
}

/*
/*
/* Тело таблицы */
#reports-spravka-zadolchf-chets-table {}

#reports-spravka-zadolchf-chets-table>tbody {
    font-family: 'Ubuntu', sans-serif;
    font-size: 0.9em;
    color: #666;
    border-bottom: none;
    border-top: none
}

#reports-spravka-zadolchf-chets-table>tbody>tr>td {}

#reports-spravka-zadolchf-chets-table>tbody>tr>td {
    font-size: 0.9em;
    padding: 5px 8px;
    line-height: 1.42857143;
    vertical-align: middle;
}

#reports-spravka-zadolchf-chets-table>thead>tr>th {
    border-bottom: none
}

#reports-spravka-zadolchf-chets-table>tbody>tr>td {}

#reports-spravka-zadolchf-chets-table>tbody>tr>td:last-child {
    /* text-align:right */
}

#reports-spravka-zadolchf-chets-table>tfoot>tr>td {
    padding: 5px 4px
}

#reports-spravka-zadolchf-chets-table>tfoot {
    background-color: #999;
}

/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
#reports-spravka-zadolchf-chets-table>thead>tr>th:first-child,
#reports-spravka-zadolchf-chets-table>tbody>tr>td:first-child {
    width: 25%;
    text-align: left
}

#reports-spravka-zadolchf-chets-table>thead>tr>th:nth-child(2),
#reports-spravka-zadolchf-chets-table>tbody>tr>td:nth-child(2) {
    width: 5%;
    text-align: center;
    white-space: nowrap
}

#reports-spravka-zadolchf-chets-table>thead>tr>th:nth-child(3),
#reports-spravka-zadolchf-chets-table>tbody>tr>td:nth-child(3) {
    width: 14%;
    text-align: right;
    white-space: nowrap
}

#reports-spravka-zadolchf-chets-table>thead>tr>th:nth-child(4),
#reports-spravka-zadolchf-chets-table>tbody>tr>td:nth-child(4) {
    width: 14%;
    text-align: right;
    white-space: nowrap
}

#reports-spravka-zadolchf-chets-table>thead>tr>th:nth-child(5),
#reports-spravka-zadolchf-chets-table>tbody>tr>td:nth-child(5) {
    width: 14%;
    text-align: right;
    white-space: nowrap
}

#reports-spravka-zadolchf-chets-table>thead>tr>th:nth-child(6),
#reports-spravka-zadolchf-chets-table>tbody>tr>td:nth-child(6) {
    width: 14%;
    text-align: right;
    white-space: nowrap
}

#reports-spravka-zadolchf-chets-table>thead>tr>th:nth-child(7),
#reports-spravka-zadolchf-chets-table>tbody>tr>td:nth-child(7) {
    width: 14%;
    text-align: right;
    white-space: nowrap
}

#reports-spravka-zadolchf-chets-table>thead>tr>th:nth-child(8),
#reports-spravka-zadolchf-chets-table>tbody>tr>td:nth-child(8) {}


#reports-spravka-zadolchf-chets-table>tbody>tr>td:nth-child(2),
#reports-spravka-zadolchf-chets-table>tbody>tr>td:nth-child(3),
#reports-spravka-zadolchf-chets-table>tbody>tr>td:nth-child(4),
#reports-spravka-zadolchf-chets-table>tbody>tr>td:nth-child(5),
#reports-spravka-zadolchf-chets-table>tbody>tr>td:nth-child(6),
#reports-spravka-zadolchf-chets-table>tbody>tr>td:nth-child(7),
#reports-spravka-zadolchf-chets-table>tbody>tr>td:nth-child(8) {
    font-family: 'Oswald', sans-serif;
    font-size: 1.15em;
    font-weight: 300;
    color: #111
}



#reports-spravka-zadolchf-chets-table .details-control:hover {
    cursor: pointer
}

/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
#reports-spravka-zadolchf-chets-table-row-details .sorting_asc:after {
    display: none
}

#reports-spravka-zadolchf-chets-table-row-details>thead>tr>th.sorting_asc {
    padding-right: 8px
}

#reports-spravka-zadolchf-chets-table .group {
    font-family: 'Oswald', sans-serif;
    font-size: 1.3em;
    font-weight: 400;
    color: #000
}

#reports-spravka-zadolchf-chets-table .group1 {
    font-family: 'Play', sans-serif;
    font-size: 1.15em;
    font-weight: 600;
    color: #000
}

#reports-spravka-zadolchf-chets-table .group2 {
    font-family: 'Play', sans-serif;
    font-size: 1.0em;
    font-weight: 600;
    color: #000
}

/* ----- */
#reports-spravka-zadolchf-chets-table>tbody>tr.dtrg-start.dtrg-level-0>td {
    font-family: 'Oswald', sans-serif;
    font-size: 1.1em;
    font-weight: 500;
    text-align: left;
    background-color: #666;
    color: white;
    padding: 5px
}

#reports-spravka-zadolchf-chets-table>tbody>tr.dtrg-end.dtrg-level-1>td {
    font-family: 'Play', sans-serif;
    font-size: 1.1em;
    font-weight: 300;
    color: #336a86;
    background-color: #fff
}

/* ----- */
#reports-spravka-zadolchf-chets-table>tbody>tr.dtrg-start.dtrg-level-1>td {
    padding: 5px;
    font-family: 'Oswald', sans-serif;
    font-size: 1.15em;
    font-weight: 500;
    color: #111;
    background-color: #dedede;
    text-align: left
}

#reports-spravka-zadolchf-chets-table>tbody>tr.dtrg-end.dtrg-level-1>td {
    font-family: 'Play', sans-serif;
    font-size: 1.1em;
    font-weight: 300;
    color: #336a86;
    background-color: #fff
}

/* ----- */

#reports-spravka-zadolchf-chets-table>tbody>tr.dtrg-start.dtrg-level-2>td {
    font-family: 'Oswald', sans-serif;
    font-size: 1.15em;
    font-weight: 400;
    color: #111;
    background-color: #fff
}

/* ----- */

#reports-spravka-zadolchf-chets-table>tbody>tr.dtrg-start.dtrg-level-3>td>table>tbody>tr>td {
    background-color: transparent
}

#reports-spravka-zadolchf-chets-table>tbody>tr.dtrg-start.dtrg-level-3>td>table>tbody>tr>td:first-child {
    text-align: left
}

#reports-spravka-zadolchf-chets-table>tbody>tr.dtrg-start.dtrg-level-3>td>table>tbody>tr>td:nth-child(2),
#reports-spravka-zadolchf-chets-table>tbody>tr.dtrg-start.dtrg-level-3>td>table>tbody>tr>td:nth-child(3),
#reports-spravka-zadolchf-chets-table>tbody>tr.dtrg-start.dtrg-level-3>td>table>tbody>tr>td:nth-child(4),
#reports-spravka-zadolchf-chets-table>tbody>tr.dtrg-start.dtrg-level-3>td>table>tbody>tr>td:nth-child(5) {
    text-align: right
}

#reports-spravka-zadolchf-chets-table>tbody>tr.dtrg-start.dtrg-level-3>td {
    padding-left: 45px
}

#reports-spravka-zadolchf-chets-table>tbody>tr.dtrg-start.dtrg-level-3>td {
    font-family: 'Oswald', sans-serif;
    font-size: 1.15em;
    font-weight: 400;
    color: #111;
    background-color: #fff
}


/* ----- */

#reports-spravka-zadolchf-chets-table>tbody>tr.dtrg-start.dtrg-level-4>td>table>tbody>tr>td {
    background-color: transparent
}

#reports-spravka-zadolchf-chets-table>tbody>tr.dtrg-start.dtrg-level-4>td>table>tbody>tr>td:first-child {
    text-align: left
}

#reports-spravka-zadolchf-chets-table>tbody>tr.dtrg-start.dtrg-level-4>td>table>tbody>tr>td:nth-child(2),
#reports-spravka-zadolchf-chets-table>tbody>tr.dtrg-start.dtrg-level-4>td>table>tbody>tr>td:nth-child(3),
#reports-spravka-zadolchf-chets-table>tbody>tr.dtrg-start.dtrg-level-4>td>table>tbody>tr>td:nth-child(4),
#reports-spravka-zadolchf-chets-table>tbody>tr.dtrg-start.dtrg-level-4>td>table>tbody>tr>td:nth-child(5) {
    text-align: right
}

#reports-spravka-zadolchf-chets-table>tbody>tr.dtrg-start.dtrg-level-4>td {
    padding-left: 45px
}

#reports-spravka-zadolchf-chets-table>tbody>tr.dtrg-start.dtrg-level-4>td {
    font-family: 'Oswald', sans-serif;
    font-size: 1.15em;
    font-weight: 300;
    color: #111;
    background-color: #fff
}


/* ----- */

#reports-spravka-zadolchf-chets-table>tbody>tr.dtrg-end.dtrg-level-5>td {
    font-family: 'Oswald', sans-serif;
    font-size: 1.2em;
    font-weight: 300;
    color: #336a86;
    background-color: #f1f1f1
}


/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/

#column1_search_current,
#column2_search_current,
#column3_search_current,
#column4_search_current {
    width: 100%;
    padding: 5px 5px;
    font-weight: 400;
    font-size: 0.9em;
    color: #333;
    max-height: 31px;
}

#column1_search_current {
    text-align: center
}

#column2_search_current {
    text-align: center
}

#column3_search_current {
    text-align: left
}

#column4_search_current {
    text-align: left
}

#filters_clear_current,
#filters_apply_current {
    padding: 6px;
    font-weight: 400;
    font-size: 0.9em
}

/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
#reports-spravka-zadolchf-chets-filters-block .panel-title {
    font-family: 'HeliosCond', sans-serif;
    font-size: 1.5em;
    font-weight: 500;
    padding-top: 5px;
    text-transform: none;
}

#reports-spravka-zadolchf-chets-filters-block {
    border: transparent
}

#dognet-missions-filters {
    padding: 15px 0;
    background-color: #f1f1f1
}

#columnSearch_btnApply1 .focus,
#columnSearch_btnApply1 .active:focus,
#columnSearch_btnApply1:active.focus,
#columnSearch_btnApply1:active:focus,
#columnSearch_btnApply1:focus {
    outline: none;
    border-color: #ccc
}

#columnSearch_btnClear1 .focus,
#columnSearch_btnClear1 .active:focus,
#columnSearch_btnClear1:active.focus,
#columnSearch_btnClear1:active:focus,
#columnSearch_btnClear1:focus {
    outline: none;
    border-color: #ccc
}

#columnSearch_btnRefresh1 .focus,
#columnSearch_btnRefresh1 .active:focus,
#columnSearch_btnRefresh1:active.focus,
#columnSearch_btnRefresh1:active:focus,
#columnSearch_btnRefresh1:focus {
    outline: none;
    border-color: #ccc
}
}

/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
#reports-spravka-zadolchf-chets-filters-block .panel-title {
    font-family: 'HeliosCond', sans-serif;
    font-size: 1.5em;
    font-weight: 500;
    padding-top: 5px;
    text-transform: none;
}

#reports-spravka-zadolchf-chets-filters-block .panel {
    border: transparent
}

#docsearch-filters-chets {
    background-color: #f1f1f1
}


#reports-spravka-zadolchf-chets-table>tbody>tr.dtrg-end.dtrg-level-0>td {
    font-family: 'Oswald', sans-serif;
    font-size: 1.4em;
    font-weight: 500;
    color: #000;
    background-color: #f1f1f1
}

.itogo-lvl0 {}

.itogo-lvl0-title {
    text-transform: uppercase;
    text-align: left
}

.itogo-lvl0-text {
    float: right
}

#reports-spravka-zadolchf-chets-table>tbody>tr.dtrg-end.dtrg-level-1>td {
    font-family: 'Oswald', sans-serif;
    font-size: 1.25em;
    font-weight: 400;
    color: #000;
    background-color: #f1f1f1
}

.itogo-lvl1 {}

.itogo-lvl1-title {
    text-align: left
}

.itogo-lvl1-text {
    float: right
}

.itogo-lvl-lbltitle1 {
    margin: 0 2px;
    padding: 0 4px 0 4px;
    background-color: transparent;
    color: #777
}

.itogo-lvl-lbltext1 {
    margin: 0 2px;
    padding: 0 4px 0 4px;
    background-color: transparent;
    color: #777
}

.itogo-lvl-lbltitle2 {
    margin: 0 2px;
    padding: 0 4px 0 4px;
    background-color: transparent;
    color: #5cb85c
}

.itogo-lvl-lbltext2 {
    margin: 0 2px;
    padding: 0 4px 0 4px;
    background-color: transparent;
    color: #5cb85c
}

.itogo-lvl-lbltitle3 {
    margin: 0 2px;
    padding: 0 4px 0 4px;
    background-color: transparent;
    color: #d9534f
}

.itogo-lvl-lbltext3 {
    margin: 0 2px;
    padding: 0 4px 0 4px;
    background-color: transparent;
    color: #d9534f
}
</style>

<section>

    <div class="space10"></div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div id="reports-spravka-zadolchf-chets-filters-block" class="panel-group">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" href="#docsearch-filters-chets">Фильтры для поиска</a>
                        </h4>
                    </div>
                    <div id="docsearch-filters-chets" class="panel-collapse collapse">

                        <div id="reports-spravka-zadolchf-chets-filters" class="panel-body space30">
                            <?php // ----- ----- ----- ----- ----- 
							?>
                            <div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
                                <div class="input-group space10" style="width:100%">
                                    <label for="reportZadolTypeSearch_text_2"><b>Задолженность :</b></label>
                                    <select name="reportZadolTypeSearch_text_2" id="reportZadolTypeSearch_text_2"
                                            class="form-control">
                                        <option value="">Все</option>
                                        <option value="1">Текущая</option>
                                        <option value="2">Судебная</option>
                                        <option value="3">Невозвратная</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                                <div class="form-group space10" style="width:100%">
                                    <label for="reportChetNumberSearch_text"><b>Счет № :</b></label>
                                    <input type="text" id="reportChetNumberSearch_text" class="form-control"
                                           placeholder="####" name="reportChetNumberSearch_text">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                                <div class="form-group space10" style="width:100%">
                                    <label for="reportChfNumberSearch_text_2"><b>Счет-фактура № :</b></label>
                                    <input type="text" id="reportChfNumberSearch_text_2" class="form-control"
                                           placeholder="####" name="reportChfNumberSearch_text_2">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                                <div class="input-group space10" style="width:100%">
                                    <label for="reportObjectSearch_text_2"><b>Заказчик/объект :</b></label>
                                    <input type="text" id="reportObjectSearch_text_2" class="form-control"
                                           placeholder="Все объекты" name="reportObjectSearch_text_2">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                                <div class="input-group space10" style="width:100%">
                                    <label for="reportDocNameSearch_text_2"><b>Текст из названия счета :</b></label>
                                    <input type="text" id="reportDocNameSearch_text_2" class="form-control"
                                           placeholder="Введите текст" name="reportDocNameSearch_text_2">
                                </div>
                            </div>
                            <?php // ----- ----- ----- ----- ----- 
							?>
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-6">

                            </div>
                            <?php // ----- ----- ----- ----- ----- 
							?>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                                <div class="input-group-btn">
                                    <button id="columnSearch_btnApply2" class="btn btn-default" type="button">Применить
                                        фильтры</button>
                                    <button id="columnSearch_btnClear2" class="btn btn-default" type="button"><i
                                           class="glyphicon glyphicon-remove"></i></button>
                                    <button id="columnSearch_btnRefresh2" class="btn btn-default" type="button"><i
                                           class="glyphicon glyphicon-refresh"></i></button>
                                </div>
                            </div>
                            <?php // ----- ----- ----- ----- ----- 
							?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="demo-html"></div>
    <table id="reports-spravka-zadolchf-chets-table" class="table table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th width="">Организация / Счет / Этап</th>
                <th width=""></th>
                <th width=""></th>
                <th width="">Этап</th>
                <th width="">Счет</th>
                <th width="">Дата</th>
                <th width="">Сумма счета</th>
                <th width="">Зачтенные авансы</th>
                <th width="">Оплаты счета</th>
                <th width="">Задолженность</th>
                <th width=""></th>
                <th width=""></th>
                <th width=""></th>
                <th width=""></th>
            </tr>
        </thead>
    </table>

</section>

<div class="space50"></div>