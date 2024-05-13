<?php
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# Какой то блок...
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
?>
<?php
if (checkDognetMainpageViewBlock(4, 'control_chf')>0) {
?>
<script type="text/javascript" language="javascript" class="init">
var table_gipwork_control_stages_oplataexpired;
// ----- ----- -----
$(document).ready(function() {
	$("#control-stages_oplataexpired-table-btnshow").click(function(){
		$("#control-stages_oplataexpired-table-btnshow").remove();
		$("#gipwork-control-stages_oplataexpired").css({"display":""});
		table_gipwork_control_stages_oplataexpired = $('#gipwork-control-stages_oplataexpired-table').DataTable( {
			dom: "<'row'<'col-sm-5'><'col-sm-4'><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'p>>",
			language: {
				url: "php/examples/simple/main/main/dt_russian-chf.json",
	            loadingRecords: '&nbsp;',
				processing: '<div class="spinner"></div>'
			},
			ajax: {
				url: "php/examples/simple/main/main/restr_5/tabs/process/gipwork-control-stages_oplataexpired-process.php",
				type: "POST"
			},
			serverSide: true,
			createdRow: function ( row, data, index ) {
				datenow = moment();
				numberdayoplstage = data.dognet_dockalplan.numberdayoplstage;
				dateplan = data.dognet_dockalplan.dateplan;
				dateoplall = data.dognet_dockalplan.dateoplall;
				chetfdate = data.dognet_kalplanchf.chetfdate;
				srokopl = data.dognet_dockalplan.srokopl;
				idsrokopl = data.dognet_dockalplan.idsrokopl;
				if (srokopl!=""&&srokopl!=null) {
					if (idsrokopl!==0&&idsrokopl!==2) {
						if (chetfdate!=""&&chetfdate!=null) {
							date1 = moment(chetfdate, 'YYYY-MM-DD');
							dateoplata = date1.add(srokopl, 'days').format('YYYY-MM-DD');
						}
						else {
							date2 = moment(dateplan, 'YYYY-MM-DD');
							dateoplata = date2.add(numberdayoplstage, 'days').format('YYYY-MM-DD');
						}
					}
					else {
						dateoplata = datenow;
					}
				}
				else {
					date2 = moment(dateplan, 'YYYY-MM-DD');
					dateoplata = date2.add(numberdayoplstage, 'days').format('YYYY-MM-DD');
				}
				console.log(data.dognet_docbase.docnumber+" : "+moment(dateoplata).format('YYYY-MM-DD')+" : "+moment(dateoplata).diff(datenow, 'days'));
				if (moment(dateoplata).diff(datenow, 'days')<0) { $(row).css('background-color','rgb(255, 240, 240)'); }
			},
			columns: [
	            {
					class: "details-control",
					searchable: false,
					orderable: false,
					data: null,
					defaultContent: "<span class='glyphicon glyphicon-option-vertical'></span>"
	            },
				{ data: "dognet_docbase.docnumber" },
				{ data: "dognet_dockalplan.numberstage" },
				{ data: "dognet_dockalplan.nameshotstage" },
				{ data: "dognet_kalplanchf.chetfdate" },
				{ data: "dognet_kalplanchf.chetfnumber" },
				{ data: "dognet_kalplanchf.chetfsumma" },
				{ data: "dognet_kalplanchf_zadol.chetfsumzadol" },
				{ data: "dognet_dockalplan.srokopl" }
			],
			select: {
				style: 'os',
				selector: 'td:first-child'
			},
			columnDefs: [
				{ orderable: false, searchable: false, targets: 0 },
				{ orderable: true, searchable: false, render: function ( data, type, row, meta ) {
					return '<a href="/dognet/dognet-docview.php?docview_type=details&uniqueID='+row.dognet_dockalplan.koddoc+'" class="docview-details-link" title="Перейти к карточке договора">'+data+'</a>';
					},
					targets: 1
				},
				{ orderable: false, searchable: false, targets: 2 },
				{ orderable: false, searchable: false,
					render: function (  data, type, row, meta ) {
						if (data!="") {
							if (row.dognet_docbase.docnameshot!="") {
								str = row.dognet_docbase.docnameshot+" / "+data;
							}
							else {
								str = data;
							}
							if (str.length > 77) { return str.substr(0,77)+" ..."; }
							else { return str;	}
						}
						else {
							return "";
						}
					},
					targets: 3
				},
				{ orderable: false, searchable: false, render: function ( data, type, row, meta ) {
					if (data) {
						return moment(data, 'YYYY-MM-DD').format('DD.MM.YYYY');
					}
					else {
						return "!?";
					}
					},
					targets: 4
				},
				{ orderable: false, searchable: false, targets: 5 },
				{ orderable: false, searchable: false, render: function ( data, type, row, meta ) {
					if (data != null) {
						return $.fn.dataTable.render.number(' ', ',', 2, '').display( data )+row.dognet_spdened.short_code;
					}
					else {
						return "0.00"+row.dognet_spdened.short_code;
					}
					}, targets: 6
				},
				{ orderable: false, searchable: false, render: function ( data, type, row, meta ) {
					if (data != null) {
						return $.fn.dataTable.render.number(' ', ',', 2, '').display( data )+row.dognet_spdened.short_code;
					}
					else {
						return "0.00"+row.dognet_spdened.short_code;
					}
					}, targets: 7
				},
				{ orderable: false, searchable: false, targets: 8 }
			],
			orderClasses: false,
			select: false,
			processing: true,
			paging: true,
			pageLength: 10,
			searching: false,
			lengthChange: false,
			order: [ [ 1, "desc" ] ],
			buttons: [
			],
			initComplete: function() {

			},
		    drawCallback: function () {

		    }
		} );
		// Array to track the ids of the details displayed rows
		var detailRows_stages_oplataexpired = [];
		$('#gipwork-control-stages_oplataexpired-table tbody').on( 'click', 'tr td.details-control', function () {
		  var tr = $(this).closest('tr');
		  var row = table_gipwork_control_stages_oplataexpired.row( tr );
		  var idx = $.inArray( tr.attr('id'), detailRows_stages_oplataexpired );
		  if ( row.child.isShown() ) {
		      tr.removeClass( 'details' );
		      row.child.hide();
		      // Remove from the 'open' array
		      detailRows_stages_oplataexpired.splice( idx, 1 );
		  }
		  else {
		      tr.addClass( 'details' );
			rowData = table_gipwork_control_stages_oplataexpired.row( row );
			d = row.data();
			rowData.child( <?php include('templates/gipwork-control-stages_oplataexpired.tpl'); ?> ).show();
		// Add to the 'open' array
		  if ( idx === -1 ) {
		      detailRows_stages_oplataexpired.push( tr.attr('id') );
		  }
		}
		} );
		// On each draw, loop over the `detailRows_stages_oplataexpired` array and show any child rows
		table_gipwork_control_stages_oplataexpired.on( 'draw', function () {
			$.each( detailRows_stages_oplataexpired, function ( i, id ) {
				$('#'+id+' td.details-control').trigger( 'click' );
		    } );
		} );
	} );
} );
</script>
<?php
// ----- ----- ----- ----- -----
// Подключаем стили для таблицы
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/main/main/restr_5/tabs/css/gipwork-control-stages_oplataexpired.css">
<div id="gipwork-control-stages_oplataexpired-border" style="padding:4px 10px; border:2px #336a86 solid; border-radius:10px">
<center><button id="control-stages_oplataexpired-table-btnshow" type="button" class="" style="margin:10px">Показать данные</button></center>
<section>
	<div id="gipwork-control-stages_oplataexpired" class="" style="display:none">
		<div class="demo-html"></div>
		<table id="gipwork-control-stages_oplataexpired-table" class="table table-bordered table-responsive display compact" cellspacing="0" width="100%">
			<thead id="gipwork-control-stages_oplataexpired-table-header">
				<tr>
					<th><span class='glyphicon glyphicon-option-vertical'></span></th>
					<th>Договор</th>
					<th>Этап</th>
					<th>Название договора/этапа</th>
					<th>Дата</th>
					<th>№ СФ</th>
					<th>Сумма</th>
					<th>Задолженность</th>
					<th>Срок</th>
				</tr>
			</thead>
		</table>
	</div>
</section>
</div>
<?php
}
else {
?>
<section>
	<div id="gipwork-main-stages_oplataexpired" class="">
		<span>Блок временно не выводится</span>
	</div>
</section>
<?php
}
?>