<?php
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# Какой то блок...
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
?>
<?php
if (checkDognetMainpageViewBlock(5, 'new_blanks')>0) {
?>
<script type="text/javascript" language="javascript" class="init">
//
	function print_checkBox(checkBox) {
		if (checkBox == 1) { return "<span class='glyphicon glyphicon-check'></span>"; }
		else { return "<span class='glyphicon glyphicon-unchecked'></span>"; }
	}
//
var table_gipwork_blankinprogress;
// ----- ----- -----
$(document).ready(function() {

	var table_gipwork_blankinprogress = $('#gipwork-main-blankinprogress-table').DataTable( {
		dom: "<'row'<'col-sm-2'B><'col-sm-9'<'#textttttttt'>><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'><'col-sm-8'>>",
// 		dom: "<'space50'r>tip",
		language: {
			url: "php/examples/simple/blankview/blankview-edit/dt_russian-tab1_blankwork.json"
		},
		ajax: {
			url: "php/examples/simple/main/main/restr_5/tabs/process/gipwork-main-blankinprogress-process.php",
			type: "POST"
		},
		serverSide: true,
		columns: [
			{
				class: "details-control-docblank",
				searchable: false,
				orderable: false,
				data: null,
				defaultContent: "<span class='glyphicon glyphicon-option-vertical'></span>"
			},
			{ data: "dognet_docblankwork.numberblankwork", className: "" },
			{ data: "dognet_docblankwork.kodstatusblank", className: "" },
			{ data: "dognet_docblankwork.nametipblankwork", className: "" },
			{ data: "dognet_spispol.ispolnameshot", className: "" },
			{ data: "dognet_docblankwork.nameblankwork", className: "" },
			{ data: "dognet_docblankwork.nameorgblankwork", className: "" },
			{ data: "dognet_docblankwork.dateblankorder", className: "" },
			{ data: "dognet_docblankwork.dateblankwork", className: "" },
			{
				class: "details-control-blankwork",
				searchable: false,
				orderable: false,
				data: null,
				defaultContent: '<span class="glyphicon glyphicon-list-alt"></span>',
				className: "text-right"
			}
		],
		columnDefs: [
			{ orderable: false, searchable: false, targets: 0 },
			{ orderable: false, searchable: true, targets: 1 },
			{ orderable: false, searchable: true, render: function ( data, type, row, meta ) {
					var tipdoc = row.dognet_docblankwork.kodstatusblank;
					var docdone = row.dognet_docblankwork.kodblankdone;
					if ( row.dognet_docblankwork.kodtipblank === "POS" ) {
						var tipblank = row.dognet_blankdocpost.kodtipblank;
						var inprocess = row.dognet_blankdocpost.kodblankinprocess;
						var blankdone = row.dognet_blankdocpost.kodblankdone;
					}
					if ( row.dognet_docblankwork.kodtipblank === "PNR" ) {
						var tipblank = row.dognet_blankdocpnr.kodtipblank;
						var inprocess = row.dognet_blankdocpnr.kodblankinprocess;
						var blankdone = row.dognet_blankdocpnr.kodblankdone;
					}
					if ( row.dognet_docblankwork.kodtipblank === "SUB" ) {
						var tipblank = row.dognet_blankdocsub.kodtipblank;
						var inprocess = row.dognet_blankdocsub.kodblankinprocess;
						var blankdone = row.dognet_blankdocsub.kodblankdone;
					}
					// Заявка создана.
					if ( tipdoc == "CR" && docdone == 0 && tipblank == "CR" && inprocess == 0 && blankdone == 0 ) {
							return "<span class='label label-default text-uppercase' style='color:#fafafa; background-color:#a94442; border:1px #fff solid'>Новый бланк</span>";
					}
					// Заявка создана. Отделом договоров получена.
					else if ( tipdoc == "CR" && docdone == 0 && tipblank == "CR" && inprocess == 1 && blankdone == 1 ) {
							return "<span class='label label-default text-uppercase' style='color:#fafafa; background-color:#ff7611; border:1px #fff solid'>Бланк в работе 1</span>";
					}
					// Заявка создана. Отделом договоров получена.
					else if ( tipdoc == "CR" && docdone == 0 && tipblank == "RD" && inprocess == 1 && blankdone == 0 ) {
							return "<span class='label label-default text-uppercase' style='color:#fafafa; background-color:#ff7611; border:1px #fff solid'>Бланк в работе 2</span>";
					}
					// Заявка в работе. ПЕРВАЯ версия бланка отдела договоров.
					else if ( tipdoc == "CR" && docdone == 0 && tipblank == "RD" && inprocess == 1 && blankdone == 1 ) {
							return "<span class='label label-default text-uppercase' style='color:#fafafa; background-color:#ff7611; border:1px #fff solid'>Бланк в работе 3</span>";
					}
					// Заявка в работе. ПЕРВАЯ версия бланка отдела договоров.
					else if ( tipdoc == "CR" && docdone == 1 && tipblank == "CR" && inprocess == 1 && blankdone == 1 ) {
							return "<span class='label label-default text-uppercase' style='color:#fafafa; background-color:#ff7611; border:1px #fff solid'>Бланк в работе 4</span>";
					}
					// Заявка в работе. Промежуточная версия бланка отдела договоров.
					else if ( tipdoc == "RD" && docdone == 1 && tipblank == "RD" && inprocess == 1 && blankdone == 1 ) {
							return "<span class='label label-default text-uppercase' style='color:#fafafa; background-color:#ff7611; border:1px #fff solid'>Бланк в работе 5</span>";
					}
					// Заявка обработана. Можно готовить договор.
					else if ( tipdoc == "RD" && docdone == 1 && tipblank == "DO" && inprocess == 1 && blankdone == 1 ) {
							return "<span class='label label-default text-uppercase' style='color:#fafafa; background-color:#31708f; border:1px #fff solid'>Ждет договора</span>";
					}
					// Заявка закрыта. Договор создан. Бланк привязан к договору.
					else if ( tipdoc == "DO" && docdone == 1 && tipblank == "DO" && inprocess == 1 && blankdone == 1 ) {
							return "<span class='label label-default text-uppercase' style='color:#999999; background-color:#ccc; border:1px #fff solid'>Договор готов</span>";
					}
					else {
							return "-";
					}
				},
				targets: 2
			},
			{
				orderable: false,
				searchable: true,
				targets: 3,
				render: function ( data, type, row, meta ) {
					fullstr = data;
					if (data.length > 3) { return data.substr(0,3); }
					else { return data;	}
				}
			},
			{ orderable: false, searchable: true, targets: 4 },
			{
				orderable: false,
				searchable: true,
				targets: 5,
				render: function ( data, type, row, meta ) {
					fullstr = data;
					if (data.length > 80) { return data.substr(0,80)+" ..."; }
					else { return data;	}
				}
			},
			{
				orderable: false,
				searchable: true,
				targets: 6,
				render: function ( data, type, row, meta ) {
					fullstr = data;
					if (data.length > 35) { return data.substr(0,35)+" ..."; }
					else { return data;	}
				}
			},
			{ orderable: false, searchable: false, targets: 7 },
			{ orderable: false, searchable: false, targets: 8 },
			{ orderable: false, searchable: false, targets: 9 }
		],
		order: [ [ 7, "desc" ], [ 1, "desc" ] ],
		processing: false,
		paging: false,
		searching: true,
		pageLength: 10,
		lengthChange: false,
		lengthMenu: [ [15, 30, 50, -1], [15, 30, 50, "Все"] ],
		buttons: [
		],
		createdRow: function ( row, data, index ) {
			if ( data.dognet_docblankwork.numberdoccr === "" ) {
					$(row).css({
/* 						"color": "rgba(149,20,2,1)" */
					});
			}
			if ( data.dognet_docblankwork.numberdoccr != "" ) {
					$(row).css({
/* 						"color": "rgba(135,145,150,1)" */
					});
			}
		},
		initComplete: function() {

		},
		drawCallback: function () {

		}

	} );
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Array to track the ids of the edit displayed rows
    var detailRows_docblank = [];
    $('#gipwork-main-blankinprogress-table tbody').on( 'click', 'tr td.details-control-docblank', function () {
        var tr = $(this).closest('tr');
        var row = table_gipwork_blankinprogress.row( tr );
        var idx = $.inArray( tr.attr('id'), detailRows_docblank );

        if ( row.child.isShown() ) {
            tr.removeClass( 'edit' );
            row.child.hide();

            // Remove from the 'open' array
            detailRows_docblank.splice( idx, 1 );
        }
        else {
            tr.addClass( 'edit' );
			rowData = table_gipwork_blankinprogress.row( row );
			d = row.data();
			rowData.child( <?php include('templates/gipwork-main-blankinprogress-doc-table.tpl'); ?> ).show();
// Add to the 'open' array
            if ( idx === -1 ) {
                detailRows_docblank.push( tr.attr('id') );
            }
        }
    } );
// On each draw, loop over the `detailRows` array and show any child rows
	table_gipwork_blankinprogress.on( 'draw', function () {
		$.each( detailRows_docblank, function ( i, id ) {
		$('#'+id+' td.details-control-docblank').trigger( 'click' );
	    } );
	} );
//
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Array to track the ids of the edit displayed rows
    var detailRows_blankwork = [];
    $('#gipwork-main-blankinprogress-table tbody').on( 'click', 'tr td.details-control-blankwork', function () {
        var tr = $(this).closest('tr');
        var row = table_gipwork_blankinprogress.row( tr );
        var idx = $.inArray( tr.attr('id'), detailRows_blankwork );

        if ( row.child.isShown() ) {
            tr.removeClass( 'edit' );
            row.child.hide();

            // Remove from the 'open' array
            detailRows_blankwork.splice( idx, 1 );
        }
        else {
            tr.addClass( 'edit' );
			rowData = table_gipwork_blankinprogress.row( row );
			d = row.data();
			if (d.dognet_docblankwork.kodtipblank == "POS") {
				rowData.child( <?php include('templates/gipwork-main-blankinprogress-pos-blank-table.tpl'); ?> ).show();
			}
			if (d.dognet_docblankwork.kodtipblank == "PNR") {
				rowData.child( <?php include('templates/gipwork-main-blankinprogress-pnr-blank-table.tpl'); ?> ).show();
			}
			if (d.dognet_docblankwork.kodtipblank == "SUB") {
				rowData.child( <?php include('templates/gipwork-main-blankinprogress-sub-blank-table.tpl'); ?> ).show();
			}
// Add to the 'open' array
            if ( idx === -1 ) {
                detailRows_blankwork.push( tr.attr('id') );
            }
        }
    } );
// On each draw, loop over the `detailRows` array and show any child rows
	table_gipwork_blankinprogress.on( 'draw', function () {
		$.each( detailRows_blankwork, function ( i, id ) {
		$('#'+id+' td.details-control-blankwork').trigger( 'click' );
	    } );
	} );
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
} );
</script>
<?php
// ----- ----- ----- ----- -----
// Подключаем стили для таблицы
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/main/main/restr_5/tabs/css/gipwork-main-blankinprogress.css">
<section>
	<div id="gipwork-main-blankinprogress" class="">
		<div class="demo-html"></div>
		<table id="gipwork-main-blankinprogress-table" class="table table-bordered table-responsive display compact" cellspacing="0" width="100%">
			<thead style="">
				<tr>
					<th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
					<th width="" class="">№</th>
					<th width="" class="">Статус</th>
					<th width="" class="">Тип</th>
					<th width="" class="">ГИП</th>
					<th width="" class="">Описание</th>
					<th width="" class="">Организация</th>
					<th width="" class="">Создан</th>
					<th width="" class="">Оформлен</th>
					<th width="" class=""><span class="glyphicon glyphicon-list-alt"></span></th>
				</tr>
			</thead>
		</table>
	</div>
</section>
<?php
}
else {
?>
<section>
	<div id="gipwork-main-blankinprogress" class="">
		<span>Блок временно не выводится</span>
	</div>
</section>
<?php
}
?>