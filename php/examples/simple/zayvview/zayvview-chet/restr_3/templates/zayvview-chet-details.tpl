'<div id="template-details-chet-main">'+

	'<div id="row-details-zayvview-chet-main-tabs">'+
		'<div class="row">'+
			'<div class="col-xs-12 col-sm-12 col-md-12">'+
				'<ul id="row-details-zayvview-chet-main-tabs-menu" class="nav nav-tabs">'+
					'<li class="active"><a data-toggle="tab" href="#chet-main-'+row.id()+'-tab-1" title="">Информация</a></li>'+
				'</ul>'+
				'<div class="row-details-zayvview-chet-main-table-title_blank"><span>Счет № '+d.dognet_doczayvchet.zayvchetnumber+' к заявке № '+d.dognet_sptipzayvall.nametipzayvshotall+'-'+d.dognet_doczayv.numberzayv+'</span></div>'+
				'<div class="tab-content">'+
					'<div id="chet-main-'+row.id()+'-tab-1" class="tab-pane fade in active">'+
						'<div class="hidden-xs col-sm-12 col-md-12 col-lg-12">'+
							'<div class="space10"></div>'+
							'<div style="padding:10px">'+
								'<table id="row-details-zayvview-chet-main-table" class="table table-condensed table-striped" >'+
									'<tbody>'+
										'<tr>'+
											'<td width="40%"><span class="row-details-zayvview-chet-main-table-title_topic">Внутренний ID счета</span></td>'+
											'<td width="60%"><span class="row-details-zayvview-chet-main-table-txt">'+d.dognet_doczayvchet.kodzayvchet+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="40%"><span class="row-details-zayvview-chet-main-table-title_topic">Дата счета</span></td>'+
											'<td width="60%"><span class="row-details-zayvview-chet-main-table-txt">'+d.dognet_doczayvchet.zayvchetdate+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="40%"><span class="row-details-zayvview-chet-main-table-title_topic">Срок поставки</span></td>'+
											'<td width="60%"><span class="row-details-zayvview-chet-main-table-txt">'+d.srokpostavki+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="40%"><span class="row-details-zayvview-chet-main-table-title_topic">Расчетный дедлайн ( дата счета + срок поставки )</span></td>'+
											'<td width="60%"><span class="row-details-zayvview-chet-main-table-txt">'+d.deadline+'</span></td>'+
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