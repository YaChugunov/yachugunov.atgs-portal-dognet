<script type="text/javascript" language="javascript" class="init">
var table_reports_spravka_zadolchf_docs; // use a global for the submit and return data rendering in the examples

function checkVal(val) {
    if (typeof val !== "undefined" && val !== "" && val !== null) {
        return 1;
    } else {
        return 0;
    }
}

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

$(document).ready(function() {

    table_reports_spravka_zadolchf_docs = $('#reports-spravka-zadolchf-docs-table').DataTable({
        dom: "<'row'<'col-sm-5'><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-4'><'col-sm-8'>>",
        // 		dom: "<'space50'r>tip",
        language: {
            url: "russian.json"
        },
        ajax: {
            url: "php/examples/simple/report/report-details/restr_4/reports/spravka/zadolchf/process/dognet-report-reportview(restr_4)-spravka-zadolchf-docs-process.php",
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
                data: "dognet_reports_zadolchf.chetfnumber",
                className: "text-left"
            },
            {
                orderable: false,
                data: "dognet_reports_zadolchf.chetfdate",
                className: "text-left"
            },
            {
                orderable: false,
                data: "dognet_reports_zadolchf.chetfsumma",
                className: "text-left"
            },
            {
                orderable: false,
                data: "dognet_reports_zadolchf.summaoplav",
                className: "text-left"
            },
            {
                orderable: false,
                data: "dognet_reports_zadolchf.summaopl",
                className: "text-left"
            },
            {
                orderable: false,
                data: "dognet_reports_zadolchf.summazadol",
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
                data: "dognet_dockalplan.srokopl"
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
            /*
            			{ searchable: true, render: function ( data, type, row, meta ) {
            					if (data) {
            						var chfdate = moment(data.format('YYYY-MM-DD'));
            						var diff_days = row.dognet_dockalplan.srokopl;
            						var opldate = chfdate.add(diff_days, 'days').format('DD.MM.YYYY');
            						return data+"( "+opldate+" )";
            					}
            				},
            				targets: 5
            			},
            */
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
                visible: true,
                render: function(data, type, row, meta) {
                    if (!isNaN(data)) {
                        if (row.dognet_dockalplan.idsrokopl == 3) {
                            var par1 = row.dognet_dockalplan.idsrokopl;
                            var par2 = moment(row.dognet_reports_zadolchf.chetfdate,
                                'DD.MM.YYYY').format('YYYY-MM-DD');
                            var par3 = row.dognet_reports_zadolchf.kodchfact;
                            var par4 = data;
                            console.log("kodchfact: " + par3 + " / chetfdate: " + par2);
                            ajaxRequest_calcDateOpl(par1, par2, par3, par4, 'calcDateOpl');
                            return '<span id="' + par3 + '"></span> рд';
                        } else {
                            var chfdate = moment(row.dognet_reports_zadolchf.chetfdate,
                                'DD.MM.YYYY');
                            var diff_days = data;
                            var opldate = chfdate.add(diff_days, 'days').format('DD.MM.YYYY');
                            // console.log("idsrokopl: "+row.dognet_dockalplan.idsrokopl+" / diff_days: "+data+" / "+opldate);
                            return opldate + " кд";
                        }
                    } else {
                        // console.log("data: "+data);
                        return data;
                    }
                },
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
                    var kodzakaz = rows.data().pluck("dognet_docbase").pluck("kodzakaz")[0];
                    var koddoc = rows.data().pluck("dognet_docbase").pluck("koddoc")[0];
                    return '<span style="text-align:left; white-space:nowrap">' + group +
                        '</span><span class="export" style="float:right"><a href="dognet-report.php?reportview=zadolchf&export=yes&uniqueID1=' +
                        koddoc + '&zak=' + kodzakaz +
                        '"><span class="glyphicon glyphicon-print"></span></a></span>';
                }



                if (level == 1) {
                    var docnumber = rows.data().pluck("dognet_docbase").pluck("docnumber")[0];
                    var agent = rows.data().pluck("dognet_docbase").pluck("nameagentshort")[0];
                    agent = checkVal(agent) == 1 ? '&nbsp;(агент&nbsp;:&nbsp;' + agent + ')' : '';
                    return '<div style="text-align:left">Договор 3-4/' + docnumber +
                        '&nbsp;:&nbsp;' + group + agent + '</div>';
                }

                if (level == 2) {
                    var namestage = rows.data().pluck("dognet_dockalplan").pluck("nameshotstage")[
                        0];
                    if (group) {
                        return '<div style="text-align:left; margin-left:20px">Этап ' + group +
                            ' : ' + namestage + '</div>';
                    } else {
                        return '<div style="text-align:left; margin-left:20px">Этап не определен либо отсутствует</div>';
                    }
                }

            },
            endRender: function(rows, group, level) {

                var koddened = rows.data().pluck("dognet_spdened").pluck("short_code")[0];
                var docnumber = rows.data().pluck("dognet_docbase").pluck("docnumber")[0];
                var avg = rows
                    .data()
                    .pluck("dognet_reports_zadolchf")
                    .pluck("summazadol")
                    .reduce(function(a, b) {
                        return a + b * 1;
                    }, 0);
                var dataSrcArray = table_reports_spravka_zadolchf_docs.rowGroup().dataSrc();

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
            dataSrc: ["sp_contragents.nameshort", "dognet_docbase.docnameshot",
                "dognet_dockalplan.numberstage"
            ]
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
                table_reports_spravka_zadolchf_docs.columns().search('');
                table_reports_spravka_zadolchf_docs.order([3, "asc"], [4, "asc"], [6,
                    "asc"
                ]).draw();
            }
        }],

    });


    //
    //
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    //
    //

    $('#columnSearch_btnApply1').click(function(e) {

        table_reports_spravka_zadolchf_docs
            .columns(11)
            .search($("#reportZadolTypeSearch_text_1").val())
            .draw();

        table_reports_spravka_zadolchf_docs
            .columns(12)
            .search($("#reportDocNumberSearch_text").val())
            .draw();

        table_reports_spravka_zadolchf_docs
            .columns(4)
            .search($("#reportChfNumberSearch_text_1").val())
            .draw();

        table_reports_spravka_zadolchf_docs
            .columns(1)
            .search($("#reportObjectSearch_text_1").val())
            .draw();

        table_reports_spravka_zadolchf_docs
            .columns(2)
            .search($("#reportDocNameSearch_text_1").val())
            .draw();

    });
    $('#columnSearch_btnClear1').click(function(e) {
        $('#reportDocNumberSearch_text').val('');
        $('#reportChfNumberSearch_text_1').val('');
        $('#reportObjectSearch_text_1').val('');
        $('#reportDocNameSearch_text_1').val('');
        table_reports_spravka_zadolchf_docs
            .columns()
            .search('')
            .draw();
    });
    $('#columnSearch_btnRefresh1').click(function(e) {
        table_reports_spravka_zadolchf_docs
            .draw();
    });


    // On each draw, loop over the `detailRows` array and show any child rows
    table_reports_spravka_zadolchf_docs.on('draw', function() {



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
#reports-spravka-zadolchf-docs-table>thead {
    background-color: #111;
    font-family: 'Oswald', sans-serif;
    border-bottom: none;
    border-top: none
}

#reports-spravka-zadolchf-docs-table>thead>tr>th {
    color: white;
    border-bottom: none;
    font-weight: 400;
    font-size: 1.0em;
    padding: 5px
}

#reports-spravka-zadolchf-docs-table .sorting:after,
#reports-spravka-zadolchf-docs-table .sorting_asc:after,
#reports-spravka-zadolchf-docs-table .sorting_desc:after {
    display: none
}

#reports-spravka-zadolchf-docs-table>thead>tr>th.sorting_asc {
    padding-right: 8px
}

#reports-spravka-zadolchf-docs-table>thead>tr>th.sorting_desc {
    padding-right: 8px
}

/*
/*
/* Тело таблицы */
#reports-spravka-zadolchf-docs-table {}

#reports-spravka-zadolchf-docs-table>tbody {
    font-family: 'Ubuntu', sans-serif;
    font-size: 0.9em;
    color: #666;
    border-bottom: none;
    border-top: none
}

#reports-spravka-zadolchf-docs-table>tbody>tr>td {}

#reports-spravka-zadolchf-docs-table>tbody>tr>td {
    font-size: 0.9em;
    padding: 5px 8px;
    line-height: 1.42857143;
    vertical-align: middle;
}

#reports-spravka-zadolchf-docs-table>thead>tr>th {
    border-bottom: none
}

#reports-spravka-zadolchf-docs-table>tbody>tr>td {}

#reports-spravka-zadolchf-docs-table>tbody>tr>td:last-child {
    /* text-align:right */
}

#reports-spravka-zadolchf-docs-table>tfoot>tr>td {
    padding: 5px 4px
}

#reports-spravka-zadolchf-docs-table>tfoot {
    background-color: #999;
}

/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
#reports-spravka-zadolchf-docs-table>thead>tr>th:first-child,
#reports-spravka-zadolchf-docs-table>tbody>tr>td:first-child {
    width: 23%;
    text-align: left
}

#reports-spravka-zadolchf-docs-table>thead>tr>th:nth-child(2),
#reports-spravka-zadolchf-docs-table>tbody>tr>td:nth-child(2) {
    width: 5%;
    text-align: center;
    white-space: nowrap
}

#reports-spravka-zadolchf-docs-table>thead>tr>th:nth-child(3),
#reports-spravka-zadolchf-docs-table>tbody>tr>td:nth-child(3) {
    width: 10%;
    text-align: right;
    white-space: nowrap
}

#reports-spravka-zadolchf-docs-table>thead>tr>th:nth-child(4),
#reports-spravka-zadolchf-docs-table>tbody>tr>td:nth-child(4) {
    width: 13%;
    text-align: right;
    white-space: nowrap
}

#reports-spravka-zadolchf-docs-table>thead>tr>th:nth-child(5),
#reports-spravka-zadolchf-docs-table>tbody>tr>td:nth-child(5) {
    width: 13%;
    text-align: right;
    white-space: nowrap
}

#reports-spravka-zadolchf-docs-table>thead>tr>th:nth-child(6),
#reports-spravka-zadolchf-docs-table>tbody>tr>td:nth-child(6) {
    width: 13%;
    text-align: right;
    white-space: nowrap
}

#reports-spravka-zadolchf-docs-table>thead>tr>th:nth-child(7),
#reports-spravka-zadolchf-docs-table>tbody>tr>td:nth-child(7) {
    width: 13%;
    text-align: right;
    white-space: nowrap
}

#reports-spravka-zadolchf-docs-table>thead>tr>th:nth-child(8),
#reports-spravka-zadolchf-docs-table>tbody>tr>td:nth-child(8) {
    width: 10%;
    text-align: right;
    white-space: nowrap
}


#reports-spravka-zadolchf-docs-table>tbody>tr>td:nth-child(2),
#reports-spravka-zadolchf-docs-table>tbody>tr>td:nth-child(3),
#reports-spravka-zadolchf-docs-table>tbody>tr>td:nth-child(4),
#reports-spravka-zadolchf-docs-table>tbody>tr>td:nth-child(5),
#reports-spravka-zadolchf-docs-table>tbody>tr>td:nth-child(6),
#reports-spravka-zadolchf-docs-table>tbody>tr>td:nth-child(7),
#reports-spravka-zadolchf-docs-table>tbody>tr>td:nth-child(8) {
    font-family: 'Oswald', sans-serif;
    font-size: 1.15em;
    font-weight: 300;
    color: #111
}



#reports-spravka-zadolchf-docs-table .details-control:hover {
    cursor: pointer
}

/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
#reports-spravka-zadolchf-docs-table-row-details .sorting_asc:after {
    display: none
}

#reports-spravka-zadolchf-docs-table-row-details>thead>tr>th.sorting_asc {
    padding-right: 8px
}

#reports-spravka-zadolchf-docs-table .group {
    font-family: 'Oswald', sans-serif;
    font-size: 1.3em;
    font-weight: 400;
    color: #000
}

#reports-spravka-zadolchf-docs-table .group1 {
    font-family: 'Play', sans-serif;
    font-size: 1.15em;
    font-weight: 600;
    color: #000
}

#reports-spravka-zadolchf-docs-table .group2 {
    font-family: 'Play', sans-serif;
    font-size: 1.0em;
    font-weight: 600;
    color: #000
}

/* ----- */
#reports-spravka-zadolchf-docs-table>tbody>tr.dtrg-start.dtrg-level-0>th {
    font-family: 'Oswald', sans-serif;
    font-size: 1.1em;
    font-weight: 500;
    text-align: left;
    background-color: #666;
    color: white;
    padding: 5px
}

#reports-spravka-zadolchf-docs-table>tbody>tr.dtrg-start.dtrg-level-0>th>span>a {
    color: white
}

#reports-spravka-zadolchf-docs-table>tbody>tr.dtrg-start.dtrg-level-0>th>span>a:hover {
    color: #f10000
}

/* #reports-spravka-zadolchf-docs-table > tbody > tr.dtrg-end.dtrg-level-1 > th { font-family:'Play', sans-serif; font-size:1.1em; font-weight:300; color:#336a86; background-color:#fff } */
/* ----- */
#reports-spravka-zadolchf-docs-table>tbody>tr.dtrg-start.dtrg-level-1>th {
    padding: 5px;
    font-family: 'Oswald', sans-serif;
    font-size: 1.15em;
    font-weight: 500;
    color: #111;
    background-color: #dedede;
    text-align: left
}

#reports-spravka-zadolchf-docs-table>tbody>tr.dtrg-end.dtrg-level-1>th {
    font-family: 'Play', sans-serif;
    font-size: 1.1em;
    font-weight: 300;
    color: #336a86;
    background-color: #fff
}

/* ----- */

#reports-spravka-zadolchf-docs-table>tbody>tr.dtrg-start.dtrg-level-2>th>div {
    font-family: 'Oswald', sans-serif;
    font-size: 1.15em;
    font-weight: 400;
    color: #111;
    background-color: #fff
}

/* ----- */

#reports-spravka-zadolchf-docs-table>tbody>tr.dtrg-start.dtrg-level-3>td>table>tbody>tr>td {
    background-color: transparent
}

#reports-spravka-zadolchf-docs-table>tbody>tr.dtrg-start.dtrg-level-3>td>table>tbody>tr>td:first-child {
    text-align: left
}

#reports-spravka-zadolchf-docs-table>tbody>tr.dtrg-start.dtrg-level-3>td>table>tbody>tr>td:nth-child(2),
#reports-spravka-zadolchf-docs-table>tbody>tr.dtrg-start.dtrg-level-3>td>table>tbody>tr>td:nth-child(3),
#reports-spravka-zadolchf-docs-table>tbody>tr.dtrg-start.dtrg-level-3>td>table>tbody>tr>td:nth-child(4),
#reports-spravka-zadolchf-docs-table>tbody>tr.dtrg-start.dtrg-level-3>td>table>tbody>tr>td:nth-child(5) {
    text-align: right
}

#reports-spravka-zadolchf-docs-table>tbody>tr.dtrg-start.dtrg-level-3>td {
    padding-left: 45px
}

#reports-spravka-zadolchf-docs-table>tbody>tr.dtrg-start.dtrg-level-3>td {
    font-family: 'Oswald', sans-serif;
    font-size: 1.15em;
    font-weight: 400;
    color: #111;
    background-color: #fff
}


/* ----- */

#reports-spravka-zadolchf-docs-table>tbody>tr.dtrg-start.dtrg-level-4>td>table>tbody>tr>td {
    background-color: transparent
}

#reports-spravka-zadolchf-docs-table>tbody>tr.dtrg-start.dtrg-level-4>td>table>tbody>tr>td:first-child {
    text-align: left
}

#reports-spravka-zadolchf-docs-table>tbody>tr.dtrg-start.dtrg-level-4>td>table>tbody>tr>td:nth-child(2),
#reports-spravka-zadolchf-docs-table>tbody>tr.dtrg-start.dtrg-level-4>td>table>tbody>tr>td:nth-child(3),
#reports-spravka-zadolchf-docs-table>tbody>tr.dtrg-start.dtrg-level-4>td>table>tbody>tr>td:nth-child(4),
#reports-spravka-zadolchf-docs-table>tbody>tr.dtrg-start.dtrg-level-4>td>table>tbody>tr>td:nth-child(5) {
    text-align: right
}

#reports-spravka-zadolchf-docs-table>tbody>tr.dtrg-start.dtrg-level-4>td {
    padding-left: 45px
}

#reports-spravka-zadolchf-docs-table>tbody>tr.dtrg-start.dtrg-level-4>td {
    font-family: 'Oswald', sans-serif;
    font-size: 1.15em;
    font-weight: 300;
    color: #111;
    background-color: #fff
}


/* ----- */

#reports-spravka-zadolchf-docs-table>tbody>tr.dtrg-end.dtrg-level-5>td {
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
#reports-spravka-zadolchf-docs-filters-block .panel-title {
    font-family: 'HeliosCond', sans-serif;
    font-size: 1.5em;
    font-weight: 500;
    padding-top: 5px;
    text-transform: none;
}

#reports-spravka-zadolchf-docs-filters-block {
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
#reports-spravka-zadolchf-docs-filters-block .panel-title {
    font-family: 'HeliosCond', sans-serif;
    font-size: 1.5em;
    font-weight: 500;
    padding-top: 5px;
    text-transform: none;
}

#reports-spravka-zadolchf-docs-filters-block .panel {
    border: transparent
}

#docsearch-filters-docs {
    background-color: #f1f1f1
}


#reports-spravka-zadolchf-docs-table>tbody>tr.dtrg-end.dtrg-level-0>th>div {
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

#reports-spravka-zadolchf-docs-table>tbody>tr.dtrg-end.dtrg-level-1>th>div {
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

span.export-link {
    font-family: 'Play', sans-serif;
    font-size: 1.0em;
    font-weight: 300;
    padding: 0 15px;
}

span.export-link a {
    color: #337ab7;
    text-decoration: underline
}

span.export-link a:hover {
    color: #111111;
    text-decoration: none
}

span.noactive {
    color: #CCCCCC;
    text-decoration: underline
}

#reports-spravka-zadolchf-docs-table>tbody>tr>td>span.export>a {
    color: #fff
}
</style>

<section>

    <div class="space10"></div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div id="reports-spravka-zadolchf-docs-filters-block" class="panel-group">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" href="#docsearch-filters-docs">Фильтры для поиска</a>
                        </h4>
                    </div>
                    <div id="docsearch-filters-docs" class="panel-collapse collapse">

                        <div id="reports-spravka-zadolchf-docs-filters" class="panel-body space30">
                            <?php // ----- ----- ----- ----- ----- 
							?>
                            <div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
                                <div class="input-group space10" style="width:100%">
                                    <label for="reportZadolTypeSearch_text_1"><b>Задолженность :</b></label>
                                    <select name="reportZadolTypeSearch_text_1" id="reportZadolTypeSearch_text_1"
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
                                    <label for="reportDocNumberSearch_text"><b>Договор № :</b></label>
                                    <input type="text" id="reportDocNumberSearch_text" class="form-control"
                                           placeholder="####" name="reportDocNumberSearch_text">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                                <div class="form-group space10" style="width:100%">
                                    <label for="reportChfNumberSearch_text_1"><b>Счет-фактура № :</b></label>
                                    <input type="text" id="reportChfNumberSearch_text_1" class="form-control"
                                           placeholder="####" name="reportChfNumberSearch_text_1">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                                <div class="input-group space10" style="width:100%">
                                    <label for="reportObjectSearch_text_1"><b>Заказчик/объект :</b></label>
                                    <input type="text" id="reportObjectSearch_text_1" class="form-control"
                                           placeholder="Все объекты" name="reportObjectSearch_text_1">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                                <div class="input-group space10" style="width:100%">
                                    <label for="reportDocNameSearch_text_1"><b>Текст из названия договора :</b></label>
                                    <input type="text" id="reportDocNameSearch_text_1" class="form-control"
                                           placeholder="Введите текст" name="reportDocNameSearch_text_1">
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
                                    <button id="columnSearch_btnApply1" class="btn btn-default" type="button">Применить
                                        фильтры</button>
                                    <button id="columnSearch_btnClear1" class="btn btn-default" type="button"><i
                                           class="glyphicon glyphicon-remove"></i></button>
                                    <button id="columnSearch_btnRefresh1" class="btn btn-default" type="button"><i
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
    <table id="reports-spravka-zadolchf-docs-table" class="table table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th width="">Организация / Договор / Этап</th>
                <th width=""></th>
                <th width=""></th>
                <th width=""></th>
                <th width="">С/Ф #</th>
                <th width="">Дата С/Ф</th>
                <th width="">Сумма</th>
                <th width="">Зачтенные авансы</th>
                <th width="">Оплаты</th>
                <th width="">Задолженность</th>
                <th width=""></th>
                <th width=""></th>
                <th width=""></th>
                <th width=""></th>
                <th width="">Срок оплаты</th>
            </tr>
        </thead>
    </table>


</section>

<div class="space50"></div>