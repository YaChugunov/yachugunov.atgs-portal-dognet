<?php
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# Какой то блок...
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
?>
<script type="text/javascript" language="javascript" class="init">
var table_gipwork_control_stages_uncompleted;
// ----- ----- -----
$(document).ready(function() {
		table_gipwork_control_stages_uncompleted = $('#report-view-uncomplstages-table').DataTable( {
			dom: "<'row'<'col-sm-5'B><'col-sm-4'><'col-sm-3'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'p>>",
			language: {
				url: "php/examples/simple/report/report-details/restr_5/reports/list/uncomplstages/dt_russian-reports-view-uncomplstages.json"
			},
			ajax: {
				url: "php/examples/simple/report/report-details/restr_5/reports/list/uncomplstages/process/dognet-report-reportview(restr_5)-list-uncomplstages-process.php",
				type: "POST"
			},
			serverSide: true,
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
				{ data: "dognet_dockalplan.srokstage" },
				{ data: "dognet_dockalplan_progress.summastage" },
				{ data: "dognet_dockalplan_progress.sumchfstage" },
				{ data: "dognet_dockalplan_progress.zadolsum_stage" }
			],
			select: {
				style: 'os',
				selector: 'td:first-child'
			},
			columnDefs: [
				{ orderable: false, searchable: false, targets: 0 },
				{ orderable: true, searchable: true, render: function ( data, type, row, meta ) {
					return '<a href="/dognet/dognet-docview.php?docview_type=details&uniqueID='+row.dognet_dockalplan.koddoc+'" class="docview-details-link" title="Перейти к карточке договора">'+data+'</a>';
					},
					targets: 1
				},
				{ orderable: false, searchable: false, targets: 2 },
				{ orderable: false, searchable: true,
					render: function (  data, type, row, meta ) {
						return data;
					},
					targets: 3
				},
				{ orderable: false, searchable: true, render: function ( data, type, row, meta ) {
					firstdateavans = row.dognet_dockalplan_progress.firstdateavans;
					srokstage = row.dognet_dockalplan_progress.srokstage;
					dateplan = row.dognet_dockalplan_progress.dateplan;
					idsrokstage = row.dognet_dockalplan_progress.idsrokstage;
					if (srokstage!=""&&srokstage!=null) {
						if (idsrokstage == 0) {
							if (firstdateavans!=""&&firstdateavans!=null) {
								date1 = moment(firstdateavans, 'YYYY-MM-DD');
								out = date1.add(srokstage, 'days').format('DD.MM.YYYY');
							}
							else {
								out = "--- ("+srokstage+")";
							}
						} else {
							out = moment(srokstage, 'YYYY-MM-DD').format('DD/MM/YYYY');
						}
					}
					else {
						out = "!? ("+moment(dateplan, 'YYYY-MM-DD').format('DD.MM.YYYY')+")";
					}
					return out;
					}, targets: 4
				},
				{ orderable: false, searchable: false, render: function ( data, type, row, meta ) {
					if (data != null) {
						return $.fn.dataTable.render.number(' ', ',', 2, '').display( data )+row.dognet_spdened.short_code;
					}
					else {
						return "0.00"+row.dognet_spdened.short_code;
					}
					}, targets: 5
				},
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
				}
			],
			orderClasses: false,
			select: false,
			processing: true,
			paging: true,
			pageLength: 10,
			searching: true,
			lengthChange: false,
			order: [ [ 1, "desc" ] ],
			buttons: [
				{ text:	'<span class="glyphicon glyphicon-refresh"></span>', action:
					function ( e, dt, node, config ) {
						table_gipwork_control_stages_uncompleted.columns().search('');
						table_gipwork_control_stages_uncompleted.order([1, "desc"]).draw();
					}
				}
			],
			initComplete: function() {

			},
		    drawCallback: function () {

		    }
		} );
		// Array to track the ids of the details displayed rows
		var detailRows_stages_uncompleted = [];
		$('#report-view-uncomplstages-table tbody').on( 'click', 'tr td.details-control', function () {

		var tr = $(this).closest('tr');
		var row = table_gipwork_control_stages_uncompleted.row( tr );
		var idx = $.inArray( tr.attr('id'), detailRows_stages_uncompleted );

		if ( row.child.isShown() ) {
			tr.removeClass( 'details' );
			row.child.hide();
			// Remove from the 'open' array
			detailRows_stages_uncompleted.splice( idx, 1 );
		}
		else {
			tr.addClass( 'details' );
			rowData = table_gipwork_control_stages_uncompleted.row( row );
			d = row.data();


					var firstdateavans = d.dognet_dockalplan_progress.firstdateavans;
					var srokstage = d.dognet_dockalplan_progress.srokstage;
					var idsrokstage = d.dognet_dockalplan_progress.idsrokstage;

					var date1;
					var newdate1;
					var out;

					if (idsrokstage == 0) {
						date1 = moment(firstdateavans, 'YYYY-MM-DD');
						newdate1 = moment(date1.format('YYYY-MM-DD'));
						out = date1.add(d.dognet_dockalplan_progress.srokstage, 'days').format('YYYY-MM-DD');
					} else {
						out = moment(srokstage, 'YYYY-MM-DD').format('YYYY-MM-DD');
					}
					console.log("ids="+idsrokstage+" / "+out);


			rowData.child( <?php include('templates/report-view-uncomplstages.tpl'); ?> ).show();
		// Add to the 'open' array
		  if ( idx === -1 ) {
		      detailRows_stages_uncompleted.push( tr.attr('id') );
		  }
		}
		} );
		// On each draw, loop over the `detailRows_stages_uncompleted` array and show any child rows
		table_gipwork_control_stages_uncompleted.on( 'draw', function () {
			$.each( detailRows_stages_uncompleted, function ( i, id ) {
				$('#'+id+' td.details-control').trigger( 'click' );
		    } );
		} );
} );
</script>
<?php
// ----- ----- ----- ----- -----
// Подключаем стили для таблицы
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/report/report-details/restr_5/reports/list/uncomplstages/tabs/css/report-view-uncomplstages.css">
<section>
	<div class="space20"></div>
	<div id="report-view-uncomplstages" class="" style="">
		<div class="demo-html"></div>
		<table id="report-view-uncomplstages-table" class="table table-bordered table-responsive display compact" cellspacing="0" width="100%">
			<thead id="report-view-uncomplstages-table-header">
				<tr>
					<th><span class='glyphicon glyphicon-option-vertical'></span></th>
					<th>Договор</th>
					<th>Этап</th>
					<th>Название договора/этапа</th>
					<th>Срок</th>
					<th>Сумма этапа</th>
					<th>Сумма СФ</th>
					<th>Не закрыто</th>
				</tr>
			</thead>
		</table>
		<table id="compact-legend-table" class="table table-responsive" cellspacing="0" width="100%">
			<tbody>
				<tr>
					<td width="8%" valign="middle"><span class="label label-default text-uppercase">Поиск</span></td>
					<td width="2%"><span class=""></span></td>
					<td colspan="2">
						<span>Поиск осуществляется сразу при вводе по столбцам: ДОГОВОР, НАЗВАНИЕ ДОГОВОРА/ЭТАПА и СРОК</span>
					</td>
				</tr>
				<tr>
					<td width="8%" valign="middle"><span class="label label-default text-uppercase">Сумма СФ</span></td>
					<td width="2%"><span class=""></span></td>
					<td colspan="2">
						<span>Сумма выставленных счетов-фактур по этапу.</span>
					</td>
				</tr>
				<tr>
					<td width="8%" valign="middle"><span class="label label-default text-uppercase">Не закрыто</span></td>
					<td width="2%"><span class=""></span></td>
					<td colspan="2">
						<span>Разница между суммой этапа и суммой выставленных счетов-фактур по этапу.</span>
					</td>
				</tr>
				<tr>
					<td width="8%" valign="middle"><span class="label label-default text-uppercase">Срок</span></td>
					<td width="2%"><span class=""></span></td>
					<td colspan="2"><span class="">Варианты отображения сроков выполнения этапа</span></td>
				</tr>
				<tr>
					<td width="8%" valign="middle"><span class=""></span></td>
					<td width="2%"><span class=""></span></td>
					<td width="14%" style="background:#fafafa; border-bottom:2px #fff solid; border-top:2px #fff solid"><span class=""><b>ДД/ММ/ГГГГ</b></span></td>
					<td><span class="">Срок равен этой дате и был задан в этапе напрямую.</span></td>
				</tr>
				<tr>
					<td width="8%" valign="middle"><span class=""></span></td>
					<td width="2%"><span class=""></span></td>
					<td width="14%" style="background:#fafafa; border-bottom:2px #fff solid; border-top:2px #fff solid"><span class=""><b>ДД.ММ.ГГГГ</b></span></td>
					<td><span class="">Срок равен дате 1-го аванса + количество дней, указанное в сроке выполнения этапа.</span></td>
				</tr>
				<tr>
					<td width="8%" valign="middle"><span class=""></span></td>
					<td width="2%"><span class=""></span></td>
					<td width="14%" style="background:#fafafa; border-bottom:2px #fff solid; border-top:2px #fff solid"><span class=""><b>--- (ДД)</b></span></td>
					<td><span class="">Срок выполнения этапа указан в днях (ДД), но авансовых платежей пока не поступало.</span></td>
				</tr>
				<tr>
					<td width="8%" valign="middle"><span class=""></span></td>
					<td width="2%"><span class=""></span></td>
					<td width="14%" style="background:#fafafa; border-bottom:2px #fff solid; border-top:2px #fff solid"><span class=""><b>!? (ДД.ММ.ГГГГ)</b></span></td>
					<td><span class="">Срок выполнения в этапе указан не был и в качестве срока используется планируемая дата (ДД.ММ.ГГГГ).</span></td>
				</tr>
			</tbody>
		</table>
	</div>
</section>
