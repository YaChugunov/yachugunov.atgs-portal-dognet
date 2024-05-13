<?php
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# Какой то блок...
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
?>
<?php
if (checkDognetMainpageViewBlock(4, 'new_chf')>0) {
?>
<script type="text/javascript" language="javascript" class="init">
var table_gipwork_newchf;
// ----- ----- -----
$(document).ready(function() {
// 	$("#main-newchf-table-btnshow").click(function(){
		$("#gipwork-main-newchf").css({"display":""});
		table_gipwork_newchf = $('#gipwork-main-newchf-table').DataTable( {
			dom: "tr",
			language: {
	            loadingRecords: '&nbsp;',
				processing: '<div class="spinner"></div>'
			},
			ajax: {
				url: "php/examples/simple/main/main/restr_5/tabs/process/gipwork-main-newchf-process.php",
				type: "POST"
			},
			serverSide: true,
			columns: [
				{ data: "dognet_docbase.docnumber" },
				{ data: "dognet_dockalplan.numberstage" },
				{ data: "dognet_kalplanchf.chetfdate" },
				{ data: "dognet_kalplanchf.chetfnumber" },
				{ data: "dognet_kalplanchf.chetfsumma" }
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
		// Array to track the ids of the details displayed rows
		var detailRows = [];
		$('#gipwork-main-newchf-table tbody').on( 'click', 'tr td.details-control', function () {
		  var tr = $(this).closest('tr');
		  var row = table_gipwork_newchf.row( tr );
		  var idx = $.inArray( tr.attr('id'), detailRows );
		  if ( row.child.isShown() ) {
		      tr.removeClass( 'details' );
		      row.child.hide();
		      // Remove from the 'open' array
		      detailRows.splice( idx, 1 );
		  }
		  else {
		      tr.addClass( 'details' );
			rowData = table_gipwork_newchf.row( row );
			d = row.data();
			rowData.child( <?php include('templates/dognet-main-gip-stage_srok_deadline.tpl'); ?> ).show();
		// Add to the 'open' array
		  if ( idx === -1 ) {
		      detailRows.push( tr.attr('id') );
		  }
		}
		} );
		// On each draw, loop over the `detailRows` array and show any child rows
		table_gipwork_newchf.on( 'draw', function () {
			$.each( detailRows, function ( i, id ) {
				$('#'+id+' td.details-control').trigger( 'click' );
			} );
		} );

		table_gipwork_newchf.on( 'processing', function( e, settings, processing ) {
			if(!processing) {
/* 				$("#main-newchf-table-btnshow").remove(); */
				$("#gipwork-main-newchf-table").addClass("table-bordered");
				$(table_gipwork_newchf.table().header()).css('display','');
			}
			else {
/* 				$("#main-newchf-table-btnshow").prop('disabled', true); */
				$(table_gipwork_newchf.table().header()).css('display','none');
			}
		} )
/* 	} ); */
} );
</script>
<?php
// ----- ----- ----- ----- -----
// Подключаем стили для таблицы
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/main/main/restr_5/tabs/css/gipwork-main-newchf.css">
<!-- <button id="main-newchf-table-btnshow" type="button" class="" style="margin-top:10px">Показать данные</button> -->
<section>
	<div id="gipwork-main-newchf" class="" style="display:none">
		<div class="demo-html"></div>
		<table id="gipwork-main-newchf-table" class="table table-responsive display compact" cellspacing="0" width="100%">
			<thead id="gipwork-main-newchf-table-header" style="display:none">
				<tr>
					<th>Дог/Сч</th>
					<th>Этап</th>
					<th>Счет от</th>
					<th>Номер</th>
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
	<div id="gipwork-main-newchf" class="">
		<span>Блок временно не выводится</span>
	</div>
</section>
<?php
}
?>