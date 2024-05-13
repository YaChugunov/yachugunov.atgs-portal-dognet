'<div id="template-details-common-kalplans">'+

	'<div id="row-details-docview-common-kalplans-tabs">'+
		'<div class="row">'+
			'<div class="col-xs-12 col-sm-12 col-md-12">'+
				'<ul id="row-details-docview-common-kalplans-tabs-menu" class="nav nav-tabs">'+
					'<li class="active"><a data-toggle="tab" href="#common-kalplans-'+row.id()+'-tab-1" title="">Информация</a></li>'+
					'<li><a data-toggle="tab" href="#common-kalplans-'+row.id()+'-tab-2" title="">Сроки выполнения и оплаты</a></li>'+
				'</ul>'+
				'<div class="tab-content">'+
					'<div id="common-kalplans-'+row.id()+'-tab-1" class="tab-pane fade in active">'+
						'<div class="hidden-xs col-sm-12 col-md-12 col-lg-12">'+
							'<div class="space10"></div>'+
							'<div style="padding:10px">'+

								'<table id="row-details-docview-common-kalplans-table" class="table table-condensed table-striped" >'+
									'<tbody>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-docview-details-table-title_topic">Номер этапа</span></td>'+
											'<td width="70%"><span class="row-details-docview-details-table-txt">'+d.dognet_dockalplan.numberstage+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-docview-details-table-title_topic">Описание этапа</span></td>'+
											'<td width="70%"><span class="row-details-docview-details-table-txt">'+d.dognet_dockalplan.nameshotstage+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-docview-details-table-title_topic">Полное наименование этапа</span></td>'+
											'<td width="70%"><span class="row-details-docview-details-table-txt">'+d.dognet_dockalplan.namefullstage+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-docview-details-table-title_topic">Объект по этапу</span></td>'+
											'<td width="70%"><span class="row-details-docview-details-table-txt">'+d.sp_objects.nameobjectshot+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-docview-details-table-title_topic">Сумма этапа</span></td>'+
											'<td width="70%"><span class="row-details-docview-details-table-txt">'+$.fn.dataTable.render.number(' ', ',', 2, '').display( d.dognet_dockalplan.summastage )+''+d.dognet_spdened.short_code+'</span></td>'+
										'</tr>'+
									'</tbody>'+
								'</table>'+

							'</div>'+
						'</div>'+
					'</div>'+
					'<div id="common-kalplans-'+row.id()+'-tab-2" class="tab-pane fade">'+
						'<div class="hidden-xs col-sm-12 col-md-6 col-lg-6">'+
							'<div class="space10"></div>'+
							'<div style="padding:10px">'+

								'<table id="row-details-docview-common-kalplans-table" class="table table-condensed table-striped" >'+
									'<tbody>'+
										'<tr>'+
											'<td width="70%"><span class="row-details-docview-details-table-title_topic">Срок выполнения</span></td>'+
											'<td width="30%"><span class="row-details-docview-details-table-txt">'+d.dognet_dockalplan.srokstage+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="70%"><span class="row-details-docview-details-table-title_topic">Срок оплаты</span></td>'+
											'<td width="30%"><span class="row-details-docview-details-table-txt">'+d.dognet_dockalplan.srokopl+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="70%"><span class="row-details-docview-details-table-title_topic">Срок выполнения (план)</span></td>'+
											'<td width="30%"><span class="row-details-docview-details-table-txt">'+d.dognet_dockalplan.dateplan+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="70%"><span class="row-details-docview-details-table-title_topic">Дней до платежа (план)</span></td>'+
											'<td width="30%"><span class="row-details-docview-details-table-txt">'+d.dognet_dockalplan.numberdayoplstage+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="70%"><span class="row-details-docview-details-table-title_topic">Дата окончательного платежа (план)</span></td>'+
											'<td width="30%"><span class="row-details-docview-details-table-txt">'+d.dognet_dockalplan.dateoplall+'</span></td>'+
										'</tr>'+
									'</tbody>'+
								'</table>'+

							'</div>'+
						'</div>'+
						'<div class="hidden-xs col-sm-12 col-md-6 col-lg-6">'+
							'<div class="space10"></div>'+
							'<div style="padding:10px">'+

								'<table id="row-details-docview-common-kalplans-table" class="table table-condensed table-striped" >'+
									'<tbody>'+
										'<tr>'+
											'<td width="25%" style="text-align:center"><span class="row-details-docview-details-table-title_topic">Аванс 1<br>(план)</span></td>'+
											'<td width="25%" style="text-align:center"><span class="row-details-docview-details-table-title_topic">Аванс 2<br>(план)</span></td>'+
											'<td width="25%" style="text-align:center"><span class="row-details-docview-details-table-title_topic">Аванс 3<br>(план)</span></td>'+
											'<td width="25%" style="text-align:center"><span class="row-details-docview-details-table-title_topic">Аванс 4<br>(план)</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="25%" style="text-align:center"><span class="row-details-docview-details-table-txt">'+d.chkplanav1+'</span></td>'+
											'<td width="25%" style="text-align:center"><span class="row-details-docview-details-table-txt">'+d.chkplanav2+'</span></td>'+
											'<td width="25%" style="text-align:center"><span class="row-details-docview-details-table-txt">'+d.chkplanav3+'</span></td>'+
											'<td width="25%" style="text-align:center"><span class="row-details-docview-details-table-txt">'+d.chkplanav4+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="25%" style="text-align:center"><span class="row-details-docview-details-table-txt">'+d.prplanav1+'</span></td>'+
											'<td width="25%" style="text-align:center"><span class="row-details-docview-details-table-txt">'+d.prplanav2+'</span></td>'+
											'<td width="25%" style="text-align:center"><span class="row-details-docview-details-table-txt">'+d.prplanav3+'</span></td>'+
											'<td width="25%" style="text-align:center"><span class="row-details-docview-details-table-txt">'+d.prplanav4+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="25%" style="text-align:center"><span class="row-details-docview-details-table-txt">'+d.dateplanav1+'</span></td>'+
											'<td width="25%" style="text-align:center"><span class="row-details-docview-details-table-txt">'+d.dateplanav2+'</span></td>'+
											'<td width="25%" style="text-align:center"><span class="row-details-docview-details-table-txt">'+d.dateplanav3+'</span></td>'+
											'<td width="25%" style="text-align:center"><span class="row-details-docview-details-table-txt">'+d.dateplanav4+'</span></td>'+
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

