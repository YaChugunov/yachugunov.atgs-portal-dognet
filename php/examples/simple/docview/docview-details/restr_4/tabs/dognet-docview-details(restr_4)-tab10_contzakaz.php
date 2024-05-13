<script type="text/javascript" language="javascript" class="init">
	var table_tab10_contzakaz;

	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

	$(document).ready(function() {
		table_tab10_contzakaz = $('#docview-details-tab10_contzakaz').DataTable({
			// 		dom: "<'row space20'<'col-md-8 col-sm-12'><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'ltip>>",
			dom: "t",
			language: {
				url: "russian.json"
			},
			ajax: {
				url: "php/examples/simple/docview/docview-details/restr_4/tabs/process/dognet-docview-details-tab10_contzakaz-process.php",
				type: "POST"
			},
			serverSide: true,
			columns: [{
				data: "sp_contragents.nameshort",
				className: "text-center"
			}],
			select: false,
			processing: false,
			paging: false,
			searching: false,
			lengthChange: false,
			createdRow: function(row, d, dataIndex) {
				rowData = table_tab10_contzakaz.row(row);
				rowData.child(<?php include('templates/docview-details_tab10_contzakaz.tpl'); ?>).show();
			}
		});
	});
</script>
<?php
// ----- ----- ----- ----- -----
// Подключаем стили для таблицы
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-details/restr_4/tabs/css/docview-details-common-tab10_contzakaz.css">
<section>
	<div id="docview-tab10_contzakaz">
		<h3 class="docview-details-title2">Контакты из справочника Заказчиков</h3>
		<div class="demo-html"></div>
		<table id="docview-details-tab10_contzakaz" class="table" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th></th>
				</tr>
			</thead>
		</table>
	</div>
</section>