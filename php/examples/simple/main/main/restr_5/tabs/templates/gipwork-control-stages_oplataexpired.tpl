'<div id="template-details-gipwork-control">'+

	'<div id="row-details-gipwork-control-stages_oplataexpired-tabs">'+
		'<div class="row">'+
			'<div class="col-xs-12 col-sm-12 col-md-12">'+
				'<ul id="row-details-gipwork-control-stages_oplataexpired-tabs-menu" class="nav nav-tabs">'+
					'<li class="active"><a data-toggle="tab" href="#control-stages_oplataexpired-'+row.id()+'-tab-1" title="">Информация по этапу</a></li>'+
					'<li><a data-toggle="tab" href="#control-stages_oplataexpired-'+row.id()+'-tab-2" title="">Информация по этапу</a></li>'+
					'<li><a data-toggle="tab" href="#control-stages_oplataexpired-'+row.id()+'-tab-3" title="">Сроки выполнения и оплаты</a></li>'+
				'</ul>'+
				'<div class="tab-content">'+
					'<div id="control-stages_oplataexpired-'+row.id()+'-tab-1" class="tab-pane fade in active">'+
						'<div class="hidden-xs col-sm-12 col-md-12 col-lg-12">'+
							'<div class="space10"></div>'+
							'<div style="padding:10px">'+

								'<table id="row-details-gipwork-control-stages_oplataexpired-table" class="table table-condensed table-striped" >'+
									'<tbody>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-gipwork-control-table-title_topic">Внутренний ID договора</span></td>'+
											'<td width="70%"><span class="row-details-gipwork-control-table-txt">'+d.dognet_docbase.koddoc+'</span></td>'+
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
											'<td width="30%"><span class="row-details-gipwork-control-table-title_topic">Исполнитель по договору (ГИП)</span></td>'+
											'<td width="70%"><span class="row-details-gipwork-control-table-txt">'+d.dognet_spispol.ispolnameshot+'</span></td>'+
										'</tr>'+
									'</tbody>'+
								'</table>'+

							'</div>'+
						'</div>'+
					'</div>'+
					'<div id="control-stages_oplataexpired-'+row.id()+'-tab-2" class="tab-pane fade">'+
						'<div class="hidden-xs col-sm-12 col-md-12 col-lg-12">'+
							'<div class="space10"></div>'+
							'<div style="padding:10px">'+

								'<table id="row-details-gipwork-control-stages_oplataexpired-table" class="table table-condensed table-striped" >'+
									'<tbody>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-gipwork-control-table-title_topic">Внутренний ID этапа</span></td>'+
											'<td width="70%"><span class="row-details-gipwork-control-table-txt">'+d.dognet_dockalplan.kodkalplan+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-gipwork-control-table-title_topic">Номер этапа</span></td>'+
											'<td width="70%"><span class="row-details-gipwork-control-table-txt">'+d.dognet_dockalplan.numberstage+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-gipwork-control-table-title_topic">Описание этапа</span></td>'+
											'<td width="70%"><span class="row-details-gipwork-control-table-txt">'+d.dognet_dockalplan.nameshotstage+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-gipwork-control-table-title_topic">Полное наименование этапа</span></td>'+
											'<td width="70%"><span class="row-details-gipwork-control-table-txt">'+d.dognet_dockalplan.namefullstage+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-gipwork-control-table-title_topic">Объект по этапу</span></td>'+
											'<td width="70%"><span class="row-details-gipwork-control-table-txt">'+d.sp_objects.nameobjectshot+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-gipwork-control-table-title_topic">Сумма этапа</span></td>'+
											'<td width="70%"><span class="row-details-gipwork-control-table-txt">'+$.fn.dataTable.render.number(' ', ',', 2, '').display( d.dognet_dockalplan.summastage )+''+d.dognet_spdened.short_code+'</span></td>'+
										'</tr>'+
									'</tbody>'+
								'</table>'+

							'</div>'+
						'</div>'+
					'</div>'+
					'<div id="control-stages_oplataexpired-'+row.id()+'-tab-3" class="tab-pane fade">'+
						'<div class="hidden-xs col-sm-12 col-md-12 col-lg-12">'+
							'<div class="space10"></div>'+
							'<div style="padding:10px">'+

								'<table id="row-details-gipwork-control-stages_oplataexpired-table" class="table table-condensed table-striped" >'+
									'<tbody>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-gipwork-control-table-title_topic">Срок выполнения</span></td>'+
											'<td width="70%"><span class="row-details-gipwork-control-table-txt">'+d.dognet_dockalplan.srokstage+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-gipwork-control-table-title_topic">Срок оплаты</span></td>'+
											'<td width="70%"><span class="row-details-gipwork-control-table-txt">'+d.dognet_dockalplan.srokopl+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-gipwork-control-table-title_topic">Срок выполнения (план)</span></td>'+
											'<td width="70%"><span class="row-details-gipwork-control-table-txt">'+d.dognet_dockalplan.dateplan+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-gipwork-control-table-title_topic">Дней до платежа (план)</span></td>'+
											'<td width="70%"><span class="row-details-gipwork-control-table-txt">'+d.dognet_dockalplan.numberdayoplstage+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-gipwork-control-table-title_topic">Дата окончательного платежа (план)</span></td>'+
											'<td width="70%"><span class="row-details-gipwork-control-table-txt">'+d.dognet_dockalplan.dateoplall+'</span></td>'+
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

