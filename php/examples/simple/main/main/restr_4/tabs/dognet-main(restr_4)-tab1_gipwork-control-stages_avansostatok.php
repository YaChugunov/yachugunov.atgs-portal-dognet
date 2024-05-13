<?php
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# Какой то блок...
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
?>
<?php
if (checkDognetMainpageViewBlock(4, 'control_avans')>0) {
?>
<script type="text/javascript" language="javascript" class="init">
var table_gipwork_control_stages_avansostatok;
// ----- ----- -----
$(document).ready(function() {
		table_gipwork_control_stages_avansostatok = $('#gipwork-control-stages_avansostatok-table').DataTable( {
			dom: "<'row'<'col-sm-5'><'col-sm-4'><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'p>>",
			language: {
				url: "php/examples/simple/main/main/dt_russian-control-stages_avost.json"
			},
			ajax: {
				url: "php/examples/simple/main/main/restr_4/tabs/process/gipwork-control-stages_avansostatok-process.php",
				type: "POST"
			},
			serverSide: true,
			createdRow: function ( row, data, index ) {
				if (data.dognet_dockalplan.idobjectready==1) {
// 					$(row).css('background-color','rgb(255, 240, 240)');
					$('td', row).eq(4).addClass('highlight_warning');
				}
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
				{ data: "dognet_dockalplan.srokstage" },
				{ data: "dognet_dockalplan_progress.sumavstage" },
				{ data: "dognet_dockalplan_progress.sumoplavstage" },
				{ data: "dognet_dockalplan_progress.zadolsum_av" }
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
						return data;
					},
					targets: 3
				},
				{ orderable: false, searchable: false, render: function ( data, type, row, meta ) {
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
		var detailRows_stages_avansostatok = [];
		$('#gipwork-control-stages_avansostatok-table tbody').on( 'click', 'tr td.details-control', function () {
			var tr = $(this).closest('tr');
			var row = table_gipwork_control_stages_avansostatok.row( tr );
			var idx = $.inArray( tr.attr('id'), detailRows_stages_avansostatok );
			if ( row.child.isShown() ) {
				tr.removeClass( 'details' );
				row.child.hide();
				// Remove from the 'open' array
				detailRows_stages_avansostatok.splice( idx, 1 );
			}
			else {
				tr.addClass( 'details' );
				rowData = table_gipwork_control_stages_avansostatok.row( row );
				d = row.data();
				rowData.child( <?php include('templates/gipwork-control-stages_avansostatok.tpl'); ?> ).show();
				// Add to the 'open' array
				if ( idx === -1 ) {
				  detailRows_stages_avansostatok.push( tr.attr('id') );
				}
			}
		} );
		// On each draw, loop over the `detailRows_stages_avansostatok` array and show any child rows
		table_gipwork_control_stages_avansostatok.on( 'draw', function () {
			$.each( detailRows_stages_avansostatok, function ( i, id ) {
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
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/main/main/restr_4/tabs/css/gipwork-control-stages_avansostatok.css">
<section>
	<div id="gipwork-control-stages_avansostatok" class="">
		<h3 class="docview-details-title2 space10">Незакрытые авансы</h3>
		<div class="demo-html"></div>
		<table id="gipwork-control-stages_avansostatok-table" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
			<thead id="gipwork-control-stages_avansostatok-table-header">
				<tr>
					<th><span class='glyphicon glyphicon-option-vertical'></span></th>
					<th>Договор</th>
					<th>Этап</th>
					<th>Название договора/этапа</th>
					<th>Срок</th>
					<th>Сумма авансов</th>
					<th>Зачтено</th>
					<th>Остаток</th>
				</tr>
			</thead>
		</table>
		<table id="compact-legend-table" class="table table-responsive" cellspacing="0" width="100%">
			<tbody>
				<tr>
					<td width="8%" valign="middle"><span class="label label-default text-uppercase">Сумма авансов</span></td>
					<td width="2%"><span class=""></span></td>
					<td colspan="2">
						<span>Сумма полученных авансов по этапу.</span>
					</td>
				</tr>
				<tr>
					<td width="8%" valign="middle"><span class="label label-default text-uppercase">Остаток</span></td>
					<td width="2%"><span class=""></span></td>
					<td colspan="2">
						<span>Разница между всей суммой полученных авансов и зачтенной суммой по выставленным счетам-фактурам по этапу.</span>
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
				<tr>
					<td width="8%" valign="middle"><span class=""></span></td>
					<td width="2%"><span class=""></span></td>
					<td width="14%" style="background-color:#faeeaa; border-bottom:2px #fff solid; border-top:2px #fff solid"><span class=""><b>СРОК</b></span></td>
					<td><span class="">Срок учитывается при условии своевременной готовности объекта.</span></td>
				</tr>
			</tbody>
		</table>
	</div>
</section>
<?php
}
else {
?>
<section>
	<div id="gipwork-main-stages_avansostatok" class="">
		<span>Блок временно не выводится</span>
	</div>
</section>
<?php
}
?>
