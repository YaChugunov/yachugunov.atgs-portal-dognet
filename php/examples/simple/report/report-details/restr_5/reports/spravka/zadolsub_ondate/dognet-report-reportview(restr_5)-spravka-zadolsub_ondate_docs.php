<script type="text/javascript" language="javascript" class="init">
var table_reports_spravka_zadolsub_docs; // use a global for the submit and return data rendering in the examples

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

$(document).ready(function() {

    var tmp4;

    table_reports_spravka_zadolsub_docs = $('#reports-spravka-zadolsub-docs-table').DataTable({
        dom: "<'row'<'col-sm-5'><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-4'><'col-sm-8'>>",
        // 		dom: "<'space50'r>tip",
        language: {
            url: "russian.json"
        },
        ajax: {
            url: "php/examples/php/report/report-details/reports/dognet-report-reportview-spravka-zadolsub-docs-process.php",
            type: "POST"
        },
        serverSide: true,
        columns: [{
                searchable: false,
                orderable: false,
                data: null
            },
            {
                data: "dognet_spsubpodr.namesubpodrshot",
                className: "text-left"
            },
            {
                data: "dognet_docbase.docnameshot",
                className: "text-left"
            },
            {
                data: "dognet_docsubpodr.numberdocsubpodr",
                className: "text-left"
            },
            {
                data: "dognet_docchfsubpodr.kodchfsubpodr",
                className: "text-left"
            },
            {
                orderable: false,
                data: "dognet_reports_zadolsub_ondate_chfincoming.date_incoming",
                className: "text-left"
            },
            {
                data: "dognet_dockalplan.numberstage",
                className: "text-left"
            },
            {
                data: "dognet_reports_zadolsub_ondate_chfincoming.type_incoming",
                className: "text-left"
            },
            {
                orderable: false,
                data: "dognet_reports_zadolsub_ondate_chfincoming.sum_incoming",
                className: "text-left"
            },
            {
                data: "dognet_spdened.short_code"
            },
            {
                data: "dognet_docbase.docnumber"
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
                visible: false,
                targets: 4
            },
            {
                searchable: true,
                targets: 5
            },
            {
                searchable: true,
                visible: false,
                targets: 6
            },
            {
                searchable: true,
                targets: 7,
                render: function(data) {
                    if (data) {
                        if (data == -1) {
                            return '<span style="color:#999">Оплата</span>';
                        }
                        if (data == -2) {
                            return '<span style="color:#999">Аванс</span>';
                        }
                        if (data == 1) {
                            return 'Оплата';
                        }
                        if (data == 2) {
                            return 'Аванс';
                        }
                    } else {
                        return '';
                    }
                }
            },
            {
                searchable: false,
                render: function(data, type, row, meta) {
                    if (data != null && data != "0.00") {
                        return $.fn.dataTable.render.number(' ', ',', 2, '').display(data) + row
                            .dognet_spdened
                            .short_code;
                    } else {
                        return '<span style="color:#999">Платежей не проводилось<span>';
                    }
                },
                targets: 8
            },
            {
                visible: false,
                targets: 9
            },
            {
                visible: false,
                targets: 10
            },
            {
                searchable: true,
                visible: false,
                targets: 11
            }
        ],

        order: [
            [1, "asc"],
            [2, "asc"],
            [3, "asc"],
            [4, "asc"],
            [5, "asc"]
        ],
        rowGroup: {
            startRender: function(rows, group, level) {

                var koddened = rows.data().pluck("dognet_spdened").pluck("short_code")[0];
                if (koddened == null) {
                    var koddened = " р.";
                }

                if (level == 0) {
                    return '<span style="text-align:left">' + group + '</span>';
                }
                if (level == 1) {
                    var docnumber = rows.data().pluck("dognet_docbase").pluck("docnumber")[0];
                    return '<span style="text-align:left; margin-left:10px">Основной договор № 3-4/' +
                        docnumber +
                        '&nbsp;:&nbsp;' + group + '</span>';
                }
                if (level == 2) {
                    var namestage = rows.data().pluck("dognet_dockalplan").pluck("nameshotstage")[
                    0];
                    if (group) {
                        return '<span style="text-align:left">Этап ' + group + ' : ' + namestage +
                            '</span>';
                    } else {
                        return '<span style="text-align:left">Этап не определен либо отсутствует</span>';
                    }
                }
                if (level == 3) {

                    var datedocsubpodr = rows.data().pluck("dognet_docsubpodr").pluck(
                        "datedocsubpodr")[0];
                    var sumdocsubpodr = rows.data().pluck("dognet_docsubpodr").pluck(
                        "sumdocsubpodr")[0];
                    if (group) {
                        return '<table width="100%"><tbody><tr><td width="40%">Договор субподряда № ' +
                            group +
                            '</td><td width="20%">' + datedocsubpodr + '</td><td width="20%">' + $
                            .fn.dataTable.render
                            .number(' ', ',', 2, '').display(sumdocsubpodr) + '' + koddened +
                            '</td><td width="20%"></td></tr></tbody></table>';
                    } else {
                        return '<table width="100%"><tbody><tr><td colspan="4">Договор субподряда не определен либо отсутствует</td></tr></tbody></table>';
                    }
                }
                if (level == 4) {
                    var numberchfsubpodr = rows.data().pluck("dognet_docchfsubpodr").pluck(
                        "numberchfsubpodr")[0];
                    var datechfsubpodr = rows.data().pluck("dognet_docchfsubpodr").pluck(
                        "datechfsubpodr")[0];
                    var sumchfsubpodr = rows.data().pluck("dognet_docchfsubpodr").pluck(
                        "sumchfsubpodr")[0];
                    var sumzadolchfsubpodr = rows.data().pluck("dognet_docchfsubpodr").pluck(
                        "sumzadolchfsubpodr")[0];
                    if (group) {
                        return '<table width="100%"><tbody><tr><td width="40%">Счет-фактура # ' +
                            numberchfsubpodr +
                            '</td><td width="20%">' + datechfsubpodr +
                            '</td><td width="20%"><span id="chf-' + rows.data()
                            .pluck("dognet_docchfsubpodr").pluck("kodchfsubpodr")[0] + '">' + $.fn
                            .dataTable.render.number(
                                ' ', ',', 2, '').display(sumchfsubpodr) + '' + koddened +
                            '</span></td><td width="20%"></td></tr></tbody></table>';
                    } else {
                        return '<span style="text-align:left; margin-left:40px">Номер счета не указан</span>';
                    }
                }
            },
            endRender: function(rows, group, level) {



                var koddened = rows.data().pluck("dognet_spdened").pluck("short_code")[0];
                if (koddened == null) {
                    var koddened = " р.";
                }



                if (level == 0) {
                    var sm = 0.00;
                    for (let i = 0; i < rows.count(); i++) { // выведет 0, затем 1, затем 2
                        var flag_1 = rows.data().pluck("dognet_reports_zadolsub_ondate_chfincoming")
                            .pluck("flag_1")[i];
                        sm = Number(sm) + Number(flag_1) * Number(rows.data().pluck(
                            "dognet_docchfsubpodr").pluck(
                            "sumchfsubpodr")[i]);
                    }
                    var itogo0 = rows.data().pluck("dognet_reports_zadolsub_ondate_chfincoming")
                        .pluck("sum_incoming")
                        .reduce(function(a, b) {
                            return a + b * 1;
                        }, 0);
                    return '<span class="itogo-lvl0"><span class="itogo-lvl0-title">Итого по субподрядчику</span><span class="itogo-lvl0-text"><span class="itogo-lvl-lbltext1">' +
                        $.fn.dataTable.render.number(' ', ',', 2, '').display(sm) + '' + koddened +
                        '</span><span class="glyphicon glyphicon-option-vertical"></span><span class="itogo-lvl-lbltext2">' +
                        $.fn.dataTable.render.number(' ', ',', 2, '').display(itogo0) + '' +
                        koddened +
                        '</span><span class="glyphicon glyphicon-option-vertical"></span><span class="itogo-lvl-lbltext3">' +
                        $.fn.dataTable.render.number(' ', ',', 2, '').display(sm - itogo0) + '' +
                        koddened +
                        '</span></span></span>';

                    /* 							return '<span style=""><span style="text-transform:uppercase; text-align:left">Итого выплачено по субподрядчику <span style="color:#951402">( задолженность )</span>&nbsp;:</span><span style="float:right">'+$.fn.dataTable.render.number(' ', ',', 2, '').display( itogo0 )+''+koddened+'<span style="color:#951402">&nbsp;(&nbsp;'+$.fn.dataTable.render.number(' ', ',', 2, '').display( sm-itogo0 )+''+koddened+'&nbsp;)</span></span></span>'; */
                }
                if (level == 1) {
                    /* 						console.log('level1: '+rows.count()); */
                }
                if (level == 2) {
                    /* 						console.log('level2: '+rows.count()); */
                }
                if (level == 3) {

                    var sm = 0.00;
                    for (let i = 0; i < rows.count(); i++) { // выведет 0, затем 1, затем 2
                        var flag_1 = rows.data().pluck("dognet_reports_zadolsub_ondate_chfincoming")
                            .pluck("flag_1")[i];
                        sm = Number(sm) + Number(flag_1) * Number(rows.data().pluck(
                            "dognet_docchfsubpodr").pluck(
                            "sumchfsubpodr")[i]);
                    }

                    var itogo3 = rows.data().pluck("dognet_reports_zadolsub_ondate_chfincoming")
                        .pluck("sum_incoming")
                        .reduce(function(a, b) {
                            return a + b * 1;
                        }, 0);

                    console.log('flag_1: ' + flag_1);
                    return '<span class="itogo-lvl3"><span class="itogo-lvl3-title">Итого по договору субподряда</span><span class="itogo-lvl3-text"><span class="itogo-lvl-lbltext1">' +
                        $.fn.dataTable.render.number(' ', ',', 2, '').display(sm) + '' + koddened +
                        '</span><span class="glyphicon glyphicon-option-vertical"></span><span class="itogo-lvl-lbltext2">' +
                        $.fn.dataTable.render.number(' ', ',', 2, '').display(itogo3) + '' +
                        koddened +
                        '</span><span class="glyphicon glyphicon-option-vertical"></span><span class="itogo-lvl-lbltext3">' +
                        $.fn.dataTable.render.number(' ', ',', 2, '').display(sm - itogo3) + '' +
                        koddened +
                        '</span></span></span>';

                    /* 							return '<span style=""><span style="text-align:left">Итого выплачено по договору субподряда <span style="color:#951402">( задолженность по договору )</span>&nbsp;:</span><span style="float:right"><span class="label label-default">'+$.fn.dataTable.render.number(' ', ',', 2, '').display( itogo3 )+''+koddened+'</span><span class="label label-danger">'+$.fn.dataTable.render.number(' ', ',', 2, '').display( sm-itogo3 )+''+koddened+'&nbsp;)</span></span></span>';  */

                    /* 							return '<span style=""><span style="text-align:left">Итого выплачено по договору субподряда <span style="color:#951402">( задолженность по договору )</span>&nbsp;:</span><span style="float:right">'+$.fn.dataTable.render.number(' ', ',', 2, '').display( itogo3 )+''+koddened+'<span style="color:#951402">&nbsp;(&nbsp;'+$.fn.dataTable.render.number(' ', ',', 2, '').display( sm-itogo3 )+''+koddened+'&nbsp;)</span></span></span>'; */
                }
                if (level == 4) {

                    console.log('level4: ' + sm);
                    /* 						console.log('level4: '+rows.count()); */
                    var sumchfsubpodr0 = rows.data().pluck("dognet_docchfsubpodr").pluck(
                        "sumchfsubpodr")[0];
                    var type = rows.data().pluck("dognet_reports_zadolsub_ondate_chfincoming")
                        .pluck("type_incoming")[
                            0];
                    var itogo4 = rows.data().pluck("dognet_reports_zadolsub_ondate_chfincoming")
                        .pluck("sum_incoming")
                        .reduce(function(a, b) {
                            return a + b * 1;
                        }, 0);
                    return '<span class="itogo-lvl3"><span class="itogo-lvl3-title">Итого по счету</span><span class="itogo-lvl3-text"><span class="itogo-lvl-lbltext2">' +
                        $.fn.dataTable.render.number(' ', ',', 2, '').display(itogo4) + '' +
                        koddened +
                        '</span><span class="glyphicon glyphicon-option-vertical"></span><span class="itogo-lvl-lbltext3">' +
                        $.fn.dataTable.render.number(' ', ',', 2, '').display(sumchfsubpodr0 -
                            itogo4) + '' + koddened +
                        '</span></span></span>';

                    /* 							return '<span style=""><span style="text-align:left">Итого выплачено по счету <span style="color:#951402">( задолженность по счету )</span>&nbsp;:</span><span style="float:right">'+$.fn.dataTable.render.number(' ', ',', 2, '').display( itogo4 )+''+koddened+'<span style="color:#951402">&nbsp;(&nbsp;'+$.fn.dataTable.render.number(' ', ',', 2, '').display( sumchfsubpodr0-itogo4 )+''+koddened+'&nbsp;)</span></span></span>'; */
                }



            },
            dataSrc: ["dognet_spsubpodr.namesubpodrshot", "dognet_docbase.docnameshot",
                "dognet_dockalplan.numberstage", "dognet_docsubpodr.numberdocsubpodr",
                "dognet_docchfsubpodr.kodchfsubpodr",
                "dognet_reports_zadolsub_ondate_chfincoming.type_incoming"
            ],
            emptyDataGroup: 'Нет данных для группирования записей'
        },
        select: false,
        ordering: true,
        processing: true,
        paging: false,
        pageLength: 30,
        lengthChange: false,
        lengthMenu: [
            [15, 30, 50, -1],
            [15, 30, 50, "Все"]
        ],
        buttons: [{
            text: '<span class="glyphicon glyphicon-refresh"></span>',
            action: function(e, dt, node, config) {
                table_reports_spravka_zadolsub_docs.columns().search('');
                table_reports_spravka_zadolsub_docs.order([1, "asc"], [2, "asc"], [4,
                    "asc"]).draw();
            }
        }],

        createdRow: function(row, data, dataIndex, cells) {

        },
        drawCallback: function(settings) {

        }

    });
    //
    //
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    //
    //

    $('#columnSearch_btnApply1').click(function(e) {

        table_reports_spravka_zadolsub_docs
            .columns(10)
            .search($("#reportDocNumberSearch_text").val())
            .draw();

        table_reports_spravka_zadolsub_docs
            .columns(3)
            .search($("#reportSubdocNumberSearch_text").val())
            .draw();

        table_reports_spravka_zadolsub_docs
            .columns(1)
            .search($("#reportSubpodrSearch_text").val())
            .draw();

        /*
        			table_reports_spravka_zadolsub_docs
        				.columns(2)
        				.search($("#reportDocNameSearch_text").val())
        				.draw();
        */

    });
    $('#columnSearch_btnClear1').click(function(e) {
        $('#reportDocNumberSearch_text').val('');
        /* 			$('#reportDocNameSearch_text').val(''); */
        $('#reportSubdocNumberSearch_text').val('');
        $('#reportSubpodrSearch_text').val('');
        table_reports_spravka_zadolsub_docs
            .columns()
            .search('')
            .draw();
    });
    $('#columnSearch_btnRefresh1').click(function(e) {
        table_reports_spravka_zadolsub_docs
            .draw();
    });


    // On each draw, loop over the `detailRows` array and show any child rows
    table_reports_spravka_zadolsub_docs.on('draw', function() {



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
#reports-spravka-zadolsub-docs-table>thead {
    background-color: #111;
    font-family: 'Oswald', sans-serif;
    border-bottom: none;
    border-top: none
}

#reports-spravka-zadolsub-docs-table>thead>tr>th {
    color: white;
    border-bottom: none;
    font-weight: 400;
    font-size: 1.0em;
    padding: 5px
}

#reports-spravka-zadolsub-docs-table .sorting:after,
#reports-spravka-zadolsub-docs-table .sorting_asc:after,
#reports-spravka-zadolsub-docs-table .sorting_desc:after {
    display: none
}

#reports-spravka-zadolsub-docs-table>thead>tr>th.sorting_asc {
    padding-right: 8px
}

#reports-spravka-zadolsub-docs-table>thead>tr>th.sorting_desc {
    padding-right: 8px
}

/*
/*
/* Тело таблицы */
#reports-spravka-zadolsub-docs-table {}

#reports-spravka-zadolsub-docs-table>tbody {
    font-family: 'Ubuntu', sans-serif;
    font-size: 0.9em;
    color: #666;
    border-bottom: none;
    border-top: none
}

#reports-spravka-zadolsub-docs-table>tbody>tr>td {}

#reports-spravka-zadolsub-docs-table>tbody>tr>td {
    font-size: 0.9em;
    padding: 5px 8px;
    line-height: 1.42857143;
    vertical-align: middle;
}

#reports-spravka-zadolsub-docs-table>thead>tr>th {
    border-bottom: none
}

#reports-spravka-zadolsub-docs-table>tbody>tr>td {}

#reports-spravka-zadolsub-docs-table>tbody>tr>td:last-child {
    /* text-align:right */
}

#reports-spravka-zadolsub-docs-table>tfoot>tr>td {
    padding: 5px 4px
}

#reports-spravka-zadolsub-docs-table>tfoot {
    background-color: #999;
}

/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
#reports-spravka-zadolsub-docs-table>thead>tr>th:first-child,
#reports-spravka-zadolsub-docs-table>tbody>tr>td:first-child {
    width: 36%;
    text-align: left
}

#reports-spravka-zadolsub-docs-table>thead>tr>th:nth-child(2),
#reports-spravka-zadolsub-docs-table>tbody>tr>td:nth-child(2) {
    width: 16%;
    text-align: right;
    white-space: nowrap
}

#reports-spravka-zadolsub-docs-table>thead>tr>th:nth-child(3),
#reports-spravka-zadolsub-docs-table>tbody>tr>td:nth-child(3) {
    width: 16%;
    text-align: right;
    white-space: nowrap
}

#reports-spravka-zadolsub-docs-table>thead>tr>th:nth-child(4),
#reports-spravka-zadolsub-docs-table>tbody>tr>td:nth-child(4) {
    width: 16%;
    text-align: right;
    white-space: nowrap
}

#reports-spravka-zadolsub-docs-table>thead>tr>th:nth-child(5),
#reports-spravka-zadolsub-docs-table>tbody>tr>td:nth-child(5) {
    width: 16%;
    text-align: right;
    white-space: nowrap
}

#reports-spravka-zadolsub-docs-table>thead>tr>th:nth-child(6),
#reports-spravka-zadolsub-docs-table>tbody>tr>td:nth-child(6) {}

#reports-spravka-zadolsub-docs-table>thead>tr>th:nth-child(7),
#reports-spravka-zadolsub-docs-table>tbody>tr>td:nth-child(7) {}

#reports-spravka-zadolsub-docs-table>thead>tr>th:nth-child(8),
#reports-spravka-zadolsub-docs-table>tbody>tr>td:nth-child(8) {}


#reports-spravka-zadolsub-docs-table>tbody>tr>td:nth-child(2),
#reports-spravka-zadolsub-docs-table>tbody>tr>td:nth-child(3),
#reports-spravka-zadolsub-docs-table>tbody>tr>td:nth-child(4) {
    font-family: 'Oswald', sans-serif;
    font-size: 1.15em;
    font-weight: 300;
    color: #009a00
}



#reports-spravka-zadolsub-docs-table .details-control:hover {
    cursor: pointer
}

/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
#reports-spravka-zadolsub-docs-table-row-details .sorting_asc:after {
    display: none
}

#reports-spravka-zadolsub-docs-table-row-details>thead>tr>th.sorting_asc {
    padding-right: 8px
}

#reports-spravka-zadolsub-docs-table .group {
    font-family: 'Oswald', sans-serif;
    font-size: 1.3em;
    font-weight: 400;
    color: #000
}

#reports-spravka-zadolsub-docs-table .group1 {
    font-family: 'Play', sans-serif;
    font-size: 1.15em;
    font-weight: 600;
    color: #000
}

#reports-spravka-zadolsub-docs-table .group2 {
    font-family: 'Play', sans-serif;
    font-size: 1.0em;
    font-weight: 600;
    color: #000
}

/* ----- */
#reports-spravka-zadolsub-docs-table>tbody>tr.dtrg-start.dtrg-level-0>td {
    font-family: 'Oswald', sans-serif;
    font-size: 1.1em;
    font-weight: 500;
    text-align: left;
    background-color: #666;
    color: white;
    padding: 5px
}

/* ----- */
#reports-spravka-zadolsub-docs-table>tbody>tr.dtrg-start.dtrg-level-1>td {
    padding: 5px;
    font-family: 'Oswald', sans-serif;
    font-size: 1.15em;
    font-weight: 500;
    color: #111;
    background-color: #dedede;
    text-align: left
}

#reports-spravka-zadolsub-docs-table>tbody>tr.dtrg-end.dtrg-level-1>td {
    font-family: 'Play', sans-serif;
    font-size: 1.1em;
    font-weight: 300;
    color: #336a86;
    background-color: #fff
}

/* ----- */

#reports-spravka-zadolsub-docs-table>tbody>tr.dtrg-start.dtrg-level-2>td {
    font-family: 'Oswald', sans-serif;
    font-size: 1.15em;
    font-weight: 400;
    color: #111;
    background-color: #fff
}

/* ----- */

#reports-spravka-zadolsub-docs-table>tbody>tr.dtrg-start.dtrg-level-3>td>table>tbody>tr>td {
    background-color: transparent
}

#reports-spravka-zadolsub-docs-table>tbody>tr.dtrg-start.dtrg-level-3>td>table>tbody>tr>td:first-child {
    text-align: left
}

#reports-spravka-zadolsub-docs-table>tbody>tr.dtrg-start.dtrg-level-3>td>table>tbody>tr>td:nth-child(2),
#reports-spravka-zadolsub-docs-table>tbody>tr.dtrg-start.dtrg-level-3>td>table>tbody>tr>td:nth-child(3),
#reports-spravka-zadolsub-docs-table>tbody>tr.dtrg-start.dtrg-level-3>td>table>tbody>tr>td:nth-child(4),
#reports-spravka-zadolsub-docs-table>tbody>tr.dtrg-start.dtrg-level-3>td>table>tbody>tr>td:nth-child(5) {
    text-align: right
}

#reports-spravka-zadolsub-docs-table>tbody>tr.dtrg-start.dtrg-level-3>td {
    padding-left: 45px
}

#reports-spravka-zadolsub-docs-table>tbody>tr.dtrg-start.dtrg-level-3>td {
    font-family: 'Oswald', sans-serif;
    font-size: 1.15em;
    font-weight: 400;
    color: #111;
    background-color: #fff
}


/* ----- */

#reports-spravka-zadolsub-docs-table>tbody>tr.dtrg-start.dtrg-level-4>td>table>tbody>tr>td {
    background-color: transparent
}

#reports-spravka-zadolsub-docs-table>tbody>tr.dtrg-start.dtrg-level-4>td>table>tbody>tr>td:first-child {
    text-align: left
}

#reports-spravka-zadolsub-docs-table>tbody>tr.dtrg-start.dtrg-level-4>td>table>tbody>tr>td:nth-child(2),
#reports-spravka-zadolsub-docs-table>tbody>tr.dtrg-start.dtrg-level-4>td>table>tbody>tr>td:nth-child(3),
#reports-spravka-zadolsub-docs-table>tbody>tr.dtrg-start.dtrg-level-4>td>table>tbody>tr>td:nth-child(4),
#reports-spravka-zadolsub-docs-table>tbody>tr.dtrg-start.dtrg-level-4>td>table>tbody>tr>td:nth-child(5) {
    text-align: right
}

#reports-spravka-zadolsub-docs-table>tbody>tr.dtrg-start.dtrg-level-4>td {
    padding-left: 45px
}

#reports-spravka-zadolsub-docs-table>tbody>tr.dtrg-start.dtrg-level-4>td {
    font-family: 'Oswald', sans-serif;
    font-size: 1.15em;
    font-weight: 300;
    color: #111;
    background-color: #fff
}


/* ----- */

#reports-spravka-zadolsub-docs-table>tbody>tr.dtrg-end.dtrg-level-5>td {
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
#reports-spravka-zadolsub-docs-filters-block .panel-title {
    font-family: 'HeliosCond', sans-serif;
    font-size: 1.5em;
    font-weight: 500;
    padding-top: 5px;
    text-transform: none;
}

#reports-spravka-zadolsub-docs-filters-block {
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
#reports-spravka-zadolsub-docs-filters-block .panel-title {
    font-family: 'HeliosCond', sans-serif;
    font-size: 1.5em;
    font-weight: 500;
    padding-top: 5px;
    text-transform: none;
}

#reports-spravka-zadolsub-docs-filters-block .panel {
    border: transparent
}

#docsearch-filters-docs {
    background-color: #f1f1f1
}


#reports-spravka-zadolsub-docs-table>tbody>tr.dtrg-end.dtrg-level-0>td {
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

#reports-spravka-zadolsub-docs-table>tbody>tr.dtrg-end.dtrg-level-3>td {
    font-family: 'Oswald', sans-serif;
    font-size: 1.25em;
    font-weight: 400;
    color: #000;
    background-color: #f1f1f1
}

.itogo-lvl3 {}

.itogo-lvl3-title {
    text-align: left
}

.itogo-lvl3-text {
    float: right
}

#reports-spravka-zadolsub-docs-table>tbody>tr.dtrg-end.dtrg-level-4>td {
    font-family: 'Oswald', sans-serif;
    font-size: 1.15em;
    font-weight: 300;
    color: #000;
    background-color: #f1f1f1
}

.itogo-lvl4 {}

.itogo-lvl4-title {
    text-align: left
}

.itogo-lvl4-text {
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

    <div class="space30"></div>

    <div id="reports-spravka-zadolsub-docs-filters-block" class="panel-group">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" href="#docsearch-filters-docs">Фильтры для поиска</a>
                </h4>
            </div>
            <div id="docsearch-filters-docs" class="panel-collapse collapse">

                <div id="reports-spravka-zadolsub-docs-filters" class="panel-body space30">
                    <?php // ----- ----- ----- ----- ----- 
          ?>
                    <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                        <div class="form-group space10" style="width:100%">
                            <label for="reportDocNumberSearch_text"><b>Договор № :</b></label>
                            <input type="text" id="reportDocNumberSearch_text" class="form-control" placeholder="####"
                                   name="reportDocNumberSearch_text">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                        <div class="form-group space10" style="width:100%">
                            <label for="reportSubdocNumberSearch_text"><b>Субподряд № :</b></label>
                            <input type="text" id="reportSubdocNumberSearch_text" class="form-control"
                                   placeholder="####" name="reportSubdocNumberSearch_text">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="input-group space10" style="width:100%">
                            <label for="reportSubpodrSearch_text"><b>Субподрядчик :</b></label>
                            <input type="text" id="reportSubpodrSearch_text" class="form-control"
                                   placeholder="Все объекты" name="reportSubpodrSearch_text">
                        </div>
                    </div>
                    <!--
					<div class="col-xs-12 col-sm-6 col-md-5 col-lg-5">
						<div class="input-group space10" style="width:100%">
							<label for="reportDocNameSearch_text"><b>Текст из названия договора :</b></label>
							<input type="text" id="reportDocNameSearch_text" class="form-control" placeholder="Введите текст" name="reportDocNameSearch_text">
						</div>
					</div>
-->
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



    <div class="space30"></div>
    <div class="demo-html"></div>
    <table id="reports-spravka-zadolsub-docs-table" class="table table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th width="">Организация / Договор / Этап / Субподряд / Счет-фактура</th>
                <th width=""></th>
                <th width=""></th>
                <th width=""></th>
                <th width=""></th>
                <th width="">Дата</th>
                <th width=""></th>
                <th width="">Сумма договора / счета</th>
                <th width="">Сумма аванса / оплаты</th>
                <th width=""></th>
                <th width=""></th>
                <th width=""></th>
            </tr>
        </thead>
    </table>


</section>

<div class="space50"></div>