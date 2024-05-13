
<script type="text/javascript" language="javascript" class="init">

var table_tab1_common;		// use a global for the submit and return data rendering in the examples

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

$(document).ready(function() {

	table_tab1_common = $('#docview-details-tab1_common').DataTable( {
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
		columns: [
			{ data: "dognet_docbase.docnumber", className: "text-center" }
		],
		select: false,
		processing: false,
		paging: false,
		searching: false,
		lengthChange: false,
		createdRow: function( row, d, dataIndex ) {
			if (d.dognet_docbase.usedocruk == '1') {
				var osn = "По указанию руководства";
				var blank = '';
			}
			else if (d.dognet_docbase.usedoczayv == '1') {
				var osn = 'Заявка ГИПа';
				if (d.dognet_docbase.kodblankwork !== null) {
/* 					var blank = ' / Бланк № '+row.data().dognet_docblankwork.numberblankwork+' / '+row.data().dognet_docblankwork.nameblankwork; */
					var blank = ' / (!) Номер бланка пока не выводится';
				}
				else {
					var blank = ' / Бланк не привязан';
				}
			}
			else {
				var osn = "Не определено";
				var blank = '';
			}
			rowData = table_tab1_common.row( row );
			rowData.child( <?php include('templates/docview-details_tab1_common.tpl'); ?> ).show();
		}
	} );
} );
</script>
<?php
// ----- ----- ----- ----- -----
// Подключаем стили для таблицы
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-details/restr_5/tabs/css/docview-details-common-tab1_common.css">
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