'<div id="template-details-report-view-main">'+

	'<div id="row-details-report-view-main-tabs">'+
		'<div class="row">'+
			'<div class="col-xs-12 col-sm-12 col-md-12">'+
				'<ul id="row-details-report-view-main-tabs-menu" class="nav nav-tabs">'+
					'<li class="active"><a data-toggle="tab" href="#report-view-main-'+row.id()+'-tab-1" title="">Информация о договоре</a></li>'+
					'<li><a data-toggle="tab" href="#report-view-main-'+row.id()+'-tab-2" title="">Информация об этапе</a></li>'+
					'<li><a data-toggle="tab" href="#report-view-main-'+row.id()+'-tab-3" title="">Сроки выполнения и оплаты</a></li>'+
					'<li><a data-toggle="tab" href="#report-view-main-'+row.id()+'-tab-4" title="">Суммы по счету-фактуре</a></li>'+
				'</ul>'+
				'<div class="tab-content">'+
					'<div id="report-view-main-'+row.id()+'-tab-1" class="tab-pane fade in active">'+
						'<div class="hidden-xs col-sm-12 col-md-12 col-lg-12">'+
							'<div class="space10"></div>'+
							'<div style="padding:10px">'+

								'<table id="row-details-report-view-main-table" class="table table-condensed table-striped" >'+
									'<tbody>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-report-view-main-table-title_topic">Внутренний ID договора</span></td>'+
											'<td width="70%"><span class="row-details-report-view-main-table-txt">'+d.dognet_docbase.koddoc+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-report-view-main-table-title_topic">Номер договора</span></td>'+
											'<td width="70%"><span class="row-details-report-view-main-table-txt">'+d.dognet_docbase.docnumber+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-report-view-main-table-title_topic">Описание договора</span></td>'+
											'<td width="70%"><span class="row-details-report-view-main-table-txt">'+d.dognet_docbase.docnameshot+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-report-view-main-table-title_topic">Полное наименование договора</span></td>'+
											'<td width="70%"><span class="row-details-report-view-main-table-txt">'+d.dognet_docbase.docnamefullm+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-report-view-main-table-title_topic">Заказчик</span></td>'+
											'<td width="70%"><span class="row-details-report-view-main-table-txt">'+d.sp_contragents.nameshort+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-report-view-main-table-title_topic">Исполнитель по договору (ГИП)</span></td>'+
											'<td width="70%"><span class="row-details-report-view-main-table-txt">'+d.dognet_spispol.ispolnameshot+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-report-view-main-table-title_topic">Тип договора</span></td>'+
											'<td width="70%"><span class="row-details-report-view-main-table-txt">'+d.dognet_sptipdog.nametip+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-report-view-main-table-title_topic">Статус договора</span></td>'+
											'<td width="70%"><span class="row-details-report-view-main-table-txt">'+d.dognet_spstatus.statusnameshot+'</span></td>'+
										'</tr>'+
									'</tbody>'+
								'</table>'+

							'</div>'+
						'</div>'+
					'</div>'+
					'<div id="report-view-main-'+row.id()+'-tab-2" class="tab-pane fade">'+
						'<div class="hidden-xs col-sm-12 col-md-12 col-lg-12">'+
							'<div class="space10"></div>'+
							'<div style="padding:10px">'+

								'<table id="row-details-report-view-main-table" class="table table-condensed table-striped" >'+
									'<tbody>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-report-view-main-table-title_topic">Номер этапа</span></td>'+
											'<td width="70%"><span class="row-details-report-view-main-table-txt">'+d.dognet_dockalplan.numberstage+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-report-view-main-table-title_topic">Описание этапа</span></td>'+
											'<td width="70%"><span class="row-details-report-view-main-table-txt">'+d.dognet_dockalplan.nameshotstage+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-report-view-main-table-title_topic">Полное наименование этапа</span></td>'+
											'<td width="70%"><span class="row-details-report-view-main-table-txt">'+d.dognet_dockalplan.namefullstage+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-report-view-main-table-title_topic">Объект по этапу</span></td>'+
											'<td width="70%"><span class="row-details-report-view-main-table-txt">'+d.sp_objects.nameobjectshot+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-report-view-main-table-title_topic">Сумма этапа</span></td>'+
											'<td width="70%"><span class="row-details-report-view-main-table-txt">'+$.fn.dataTable.render.number(' ', ',', 2, '').display( d.dognet_dockalplan.summastage )+''+d.dognet_spdened.short_code+'</span></td>'+
										'</tr>'+
									'</tbody>'+
								'</table>'+

							'</div>'+
						'</div>'+
					'</div>'+
					'<div id="report-view-main-'+row.id()+'-tab-3" class="tab-pane fade">'+
						'<div class="hidden-xs col-sm-12 col-md-12 col-lg-12">'+
							'<div class="space10"></div>'+
							'<div style="padding:10px">'+

								'<table id="row-details-report-view-main-table" class="table table-condensed table-striped" >'+
									'<tbody>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-report-view-main-table-title_topic">Срок выполнения</span></td>'+
											'<td width="70%"><span class="row-details-report-view-main-table-txt">'+d.dognet_dockalplan.srokstage+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-report-view-main-table-title_topic">Срок оплаты</span></td>'+
											'<td width="70%"><span class="row-details-report-view-main-table-txt">'+d.dognet_dockalplan.srokopl+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-report-view-main-table-title_topic">Срок выполнения (план)</span></td>'+
											'<td width="70%"><span class="row-details-report-view-main-table-txt">'+d.dognet_dockalplan.dateplan+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-report-view-main-table-title_topic">Дней до платежа (план)</span></td>'+
											'<td width="70%"><span class="row-details-report-view-main-table-txt">'+d.dognet_dockalplan.numberdayoplstage+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-report-view-main-table-title_topic">Дата окончательного платежа (план)</span></td>'+
											'<td width="70%"><span class="row-details-report-view-main-table-txt">'+d.dognet_dockalplan.dateoplall+'</span></td>'+
										'</tr>'+
									'</tbody>'+
								'</table>'+

							'</div>'+
						'</div>'+
					'</div>'+
					'<div id="report-view-main-'+row.id()+'-tab-4" class="tab-pane fade">'+
						'<div class="hidden-xs col-sm-12 col-md-12 col-lg-12">'+
							'<div class="space10"></div>'+
							'<div style="padding:10px">'+

								'<table id="row-details-report-view-main-table" class="table table-condensed table-striped" >'+
									'<tbody>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-report-view-main-table-title_topic">Сумма этапа</span></td>'+
											'<td width="70%"><span class="row-details-report-view-main-table-txt">'+$.fn.dataTable.render.number(' ', ',', 2, '').display( d.dognet_dockalplan.summastage )+''+d.dognet_spdened.short_code+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-report-view-main-table-title_topic">Сумма счета-фактуры</span></td>'+
											'<td width="70%"><span class="row-details-report-view-main-table-txt">'+$.fn.dataTable.render.number(' ', ',', 2, '').display( d.dognet_kalplanchf.chetfsumma )+''+d.dognet_spdened.short_code+'</span></td>'+
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

