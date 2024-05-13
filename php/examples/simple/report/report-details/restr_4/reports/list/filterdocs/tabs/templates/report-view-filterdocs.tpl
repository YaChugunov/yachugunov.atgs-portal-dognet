'<div id="template-details-gipwork-control">'+

	'<div id="row-details-report-view-filterdocs-tabs">'+
		'<div class="row">'+
			'<div class="col-xs-12 col-sm-12 col-md-12">'+
				'<ul id="row-details-report-view-filterdocs-tabs-menu" class="nav nav-tabs">'+
					'<li class="active"><a data-toggle="tab" href="#report-view-filterdocs-'+row.id()+'-tab-1" title="">Информация по договору</a></li>'+
				'</ul>'+
				'<div class="tab-content">'+
					'<div id="report-view-filterdocs-'+row.id()+'-tab-1" class="tab-pane fade in active">'+
						'<div class="hidden-xs col-sm-12 col-md-12 col-lg-12">'+
							'<div class="space10"></div>'+
							'<div style="padding:10px">'+

								'<table id="row-details-report-view-filterdocs-table" class="table table-condensed table-striped" >'+
									'<tbody>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-gipwork-control-table-title_topic">Внутренний ID договора</span></td>'+
											'<td width="70%"><span class="row-details-gipwork-control-table-txt">'+d.dognet_docbase.koddoc+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-gipwork-control-table-title_topic">Номер договора</span></td>'+
											'<td width="70%"><span class="row-details-gipwork-control-table-txt">'+d.dognet_docbase.docnumber+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-gipwork-control-table-title_topic">Начало договора</span></td>'+
											'<td width="70%"><span class="row-details-gipwork-control-table-txt">'+d.dognet_docbase.yearnachdoc+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-gipwork-control-table-title_topic">Конец договора</span></td>'+
											'<td width="70%"><span class="row-details-gipwork-control-table-txt">'+d.dognet_docbase.yearenddoc+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-gipwork-control-table-title_topic">Краткое наименование договора</span></td>'+
											'<td width="70%"><span class="row-details-gipwork-control-table-txt">'+d.dognet_docbase.docnameshot+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-gipwork-control-table-title_topic">Полное наименование договора</span></td>'+
											'<td width="70%"><span class="row-details-gipwork-control-table-txt">'+d.dognet_docbase.docnamefullm+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-gipwork-control-table-title_topic">Заказчик</span></td>'+
											'<td width="70%"><span class="row-details-gipwork-control-table-txt">'+d.sp_contragents.namefull+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-gipwork-control-table-title_topic">Объект</span></td>'+
											'<td width="70%"><span class="row-details-gipwork-control-table-txt">'+d.sp_objects.nameobjectlong+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-gipwork-control-table-title_topic">Сумма договора</span></td>'+
											'<td width="70%"><span class="row-details-gipwork-control-table-txt">'+$.fn.dataTable.render.number(' ', ',', 2, '').display( d.dognet_docbase.docsumma )+d.dognet_spdened.short_code+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-gipwork-control-table-title_topic">Тип</span></td>'+
											'<td width="70%"><span class="row-details-gipwork-control-table-txt">'+d.dognet_sptipdog.nametip+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-gipwork-control-table-title_topic">Статус</span></td>'+
											'<td width="70%"><span class="row-details-gipwork-control-table-txt">'+d.dognet_spstatus.statusnameshot+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-gipwork-control-table-title_topic">Закрытие договора</span></td>'+
											'<td width="70%"><span class="row-details-gipwork-control-table-txt">'+d.datezakr+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-gipwork-control-table-title_topic">Исполнитель по договору (ГИП)</span></td>'+
											'<td width="70%"><span class="row-details-gipwork-control-table-txt">'+d.dognet_spispol.ispolnameshot+'</span></td>'+
										'</tr>'+
									'</tbody>'+
								'</table>'+

							'</div>'+
						'</div>'+
					'</div>'+
				'</div>'+
			'</div>'+
		'</div>'+
	'</div>'+

'</div>'

