<script type="text/javascript" language="javascript" class="init">
var editor_tab1_common; // use a global for the submit and return data rendering in the examples
var table_tab1_common; // use a global for the submit and return data rendering in the examples

function checkVal(val) {
    if (typeof val !== "undefined" && val !== "" && val !== null) {
        return 1;
    } else {
        return 0;
    }
}

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

$(document).ready(function() {

    table_tab1_common = $('#docview-details-tab1_common').DataTable({
        // 		dom: "<'row space20'<'col-md-8 col-sm-12'><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'ltip>>",
        dom: "t",
        language: {
            url: "russian.json"
        },
        ajax: {
            url: "php/examples/php/docview/docview-details/dognet-docview-details-tab1_common-process.php",
            type: "POST"
        },
        serverSide: true,
        columns: [{
            data: "dognet_docbase.docnumber",
            className: "text-center"
        }],
        select: false,
        processing: false,
        paging: false,
        searching: false,
        lengthChange: false,
        createdRow: function(row, d, dataIndex) {
            if (d.dognet_docbase.usedocruk == '1') {
                var osn = "По указанию руководства";
                var blank = '';
            } else if (d.dognet_docbase.usedoczayv == '1') {
                var osn = 'Заявка ГИПа';
                if (d.dognet_docbase.kodblankwork !== null) {
                    /* 					var blank = ' / Бланк № '+row.data().dognet_docblankwork.numberblankwork+' / '+row.data().dognet_docblankwork.nameblankwork; */
                    var blank = ' / (!) Номер бланка пока не выводится';
                } else {
                    var blank = ' / Бланк не привязан';
                }
            } else {
                var osn = "Не определено";
                var blank = '';
            }
            var specialcomm = "---";
            if (d.dognet_docbase.usecreatekcp === '1') {
                var specialcomm =
                    "<span style='background-color: rgb(255, 242, 204)'>Договор подписан на электронной площадке</span>";
            }
            rowData = table_tab1_common.row(row);
            d.agent = checkVal(d.sp_contragents_agent.nameshort) == 1 ? d.sp_contragents_agent
                .nameshort : "---";
            d.DN = (d.dognet_docbase.daynachdoc < 10) ? d.dognet_docbase.daynachdoc.padStart(2,
                '0') : d.dognet_docbase.daynachdoc;
            d.MN = (d.dognet_docbase.monthnachdoc < 10) ? d.dognet_docbase.monthnachdoc.padStart(2,
                '0') : d.dognet_docbase.monthnachdoc;
            d.DE = (d.dognet_docbase.dayenddoc < 10) ? d.dognet_docbase.dayenddoc.padStart(2, '0') :
                d.dognet_docbase.dayenddoc;
            d.ME = (d.dognet_docbase.monthenddoc < 10) ? d.dognet_docbase.monthenddoc.padStart(2,
                '0') : d.dognet_docbase.monthenddoc;
            rowData.child(<?php include('templates/docview-details_tab1_common.tpl'); ?>).show();
        }
    });
});
</script>
<?php
// ----- ----- ----- ----- -----
// Подключаем стили для таблицы
// :::
?>
<link rel="stylesheet"
      href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-details/restr_3/tabs/css/docview-details-common-tab1_common.css">
<section>
    <div id="docview-tab1_common">
        <h3 class="docview-details-title2">Общая информация</h3>
        <div class="demo-html"></div>
        <table id="docview-details-tab1_common" class="table" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th></th>
                </tr>
            </thead>
        </table>
    </div>
</section>