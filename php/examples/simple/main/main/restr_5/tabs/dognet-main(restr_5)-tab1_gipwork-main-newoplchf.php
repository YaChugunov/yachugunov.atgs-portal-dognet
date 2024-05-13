<?php
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# Какой то блок...
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
?>
<?php
if (checkDognetMainpageViewBlock(5, 'new_oplchf')>0) {
?>
<script type="text/javascript" language="javascript" class="init">
var table_gipwork_newoplchf;
// ----- ----- -----
$(document).ready(function() {
// 	$("#main-newoplchf-table-btnshow").click(function(){
		$("#gipwork-main-newoplchf").css({"display":""});
		table_gipwork_newoplchf = $('#gipwork-main-newoplchf-table').DataTable( {
			dom: "tr",
			language: {
	            loadingRecords: '&nbsp;',
				processing: '<div class="spinner"></div>'
			},
			ajax: {
				url: "php/examples/simple/main/main/restr_5/tabs/process/gipwork-main-newoplchf-process.php",
				type: "POST"
			},
			serverSide: true,
			columns: [
				{ data: "dognet_docbase.docnumber" },
				{ data: "dognet_dockalplan.numberstage" },
				{ data: "dognet_oplatachf.dateopl" },
				{ data: "dognet_kalplanchf.chetfnumber" },
				{ data: "dognet_oplatachf.summaopl" }
			],
			select: {
				style: 'os',
				selector: 'td:first-child'
			},
			columnDefs: [
				{ orderable: false, searchable: false, render: function ( data, type, row, meta ) {
						if (row.dognet_docbase.kodshab==0) {
							return '<a href="/dognet/dognet-chetview.php?chetview_type=details&uniqueID='+row.dognet_docbase.koddoc+'" class="docview-details-link" title="Перейти к карточке счета">'+data+'</a>';
						}
						if (row.tmp1.kodshab==1 || row.tmp1.kodshab==3) {
							return '<a href="/dognet/dognet-docview.php?docview_type=details&uniqueID='+row.tmp1.koddoc+'" class="docview-details-link" title="Перейти к карточке договора">'+row.tmp1.docnumber+'</a>';
						}
						if (row.tmp2.kodshab==2 || row.tmp2.kodshab==4) {
							return '<a href="/dognet/dognet-docview.php?docview_type=details&uniqueID='+row.tmp2.koddoc+'" class="docview-details-link" title="Перейти к карточке договора">'+row.tmp2.docnumber+'</a>';
						}
					},
					targets: 0
				},
				{ orderable: false, searchable: false, render: function ( data, type, row, meta ) {
						if (row.dognet_docbase.kodshab==0) {
							return 'СЧЁТ';
						}
						if (row.tmp1.kodshab==1 || row.tmp1.kodshab==3) {
							return data;
						}
						if (row.tmp2.kodshab==2 || row.tmp2.kodshab==4) {
							return '---';
						}
					},
					targets: 1
				},
				{ orderable: false, searchable: false, targets: 2 },
				{ orderable: false, searchable: false, targets: 3 },
				{ orderable: false, searchable: false, render: function ( data, type, row, meta ) {
					if (data != null) {
						if (row.dognet_docbase.kodshab==0) {
							return $.fn.dataTable.render.number(' ', ',', 2, '').display( data )+row.dognet_spdened.short_code;
						}
						if (row.tmp1.kodshab==1 || row.tmp1.kodshab==3) {
							return $.fn.dataTable.render.number(' ', ',', 2, '').display( data )+row.tmp3.short_code;
						}
						if (row.tmp2.kodshab==2 || row.tmp2.kodshab==4) {
							return $.fn.dataTable.render.number(' ', ',', 2, '').display( data )+row.tmp2.short_code;
						}
					}
					else {
						return "0.00"+row.dognet_spdened.short_code;
					}
					}, targets: 4
				}
			],
			orderClasses: false,
			select: false,
			processing: true,
			paging: true,
			pageLength: 5,
			searching: false,
			lengthChange: false,
			order: [ [ 2, "desc" ] ],
			buttons: [
			],
			initComplete: function() {

			},
	    drawCallback: function() {

	    }
		} );

		table_gipwork_newoplchf.on( 'processing', function( e, settings, processing ) {
			if(!processing) {
// 				$("#main-newoplchf-table-btnshow").remove();
				$("#gipwork-main-newoplchf-table").addClass("table-bordered");
				$(table_gipwork_newoplchf.table().header()).css('display','');
			}
			else {
// 				$("#main-newoplchf-table-btnshow").prop('disabled', true);
				$(table_gipwork_newoplchf.table().header()).css('display','none');
			}
		} )
// 	} )
} );
</script>
<?php
// ----- ----- ----- ----- -----
// Подключаем стили для таблицы
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/main/main/restr_5/tabs/css/gipwork-main-newoplchf.css">
<!-- <button id="main-newoplchf-table-btnshow" type="button" class="" style="margin-top:10px">Показать данные</button> -->
<section>
	<div id="gipwork-main-newoplchf" class="" style="display:none">
		<div class="demo-html"></div>
		<table id="gipwork-main-newoplchf-table" class="table table-responsive display compact" cellspacing="0" width="100%">
			<thead id="gipwork-main-newoplchf-table-header" style="display:none">
				<tr>
					<th>Дог/Сч</th>
					<th>Этап</th>
					<th>Оплата от</th>
					<th>Счет-фактура</th>
					<th>Сумма</th>
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
	<div id="gipwork-main-newoplchf" class="">
		<span>Блок временно не выводится</span>
	</div>
</section>
<?php
}
?>