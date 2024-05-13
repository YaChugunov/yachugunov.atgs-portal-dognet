'<div id="row-details-report-missions">'+

	'<div id="row-details-report-missions-tabs">'+
		'<div class="row">'+
			'<div class="col-xs-12 col-sm-12 col-md-12">'+
				'<ul id="row-details-report-missions-tabs-menu" class="nav nav-tabs">'+
					'<li class="active"><a data-toggle="tab" href="#report-missions-'+row.id()+'-tab-1" title="">Информация</a></li>'+
				'</ul>'+

				'<div class="row-details-report-missions-table-title_blank"><span>Общая информация о договоре № 3-4/'+d.dognet_docbase.docnumber+'</span></div>'+
				'<div class="tab-content">'+
					'<div id="report-missions-'+row.id()+'-tab-1" class="tab-pane fade in active">'+
						'<div class="hidden-xs col-sm-12 col-md-12 col-lg-12">'+
							'<div class="space10"></div>'+
							'<div style="padding:10px">'+

								'<table id="row-details-report-missions-table" class="table table-condensed table-striped" >'+
									'<tbody>'+
										'<tr>'+
											'<td width="30%" style=""><span class="row-details-report-missions-table-title_topic">Статус договора</span></td>'+
											'<td style=""><span class="row-details-report-missions-table-txt" >'+d.dognet_spstatus.statusnameshot+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%" style=""><span class="row-details-report-missions-table-title_topic">Тип договора</span></td>'+
											'<td style=""><span class="row-details-report-missions-table-txt"><span class="">'+d.dognet_sptipdog.nametip+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%" style=""><span class="row-details-report-missions-table-title_topic">Объект</span></td>'+
											'<td style=""><span class="row-details-report-missions-table-txt"><span class="">'+d.sp_objects.nameobjectlong+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%" style=""><span class="row-details-report-missions-table-title_topic">Организация-плательщик</span></td>'+
											'<td style=""><span class="row-details-report-missions-table-txt"><span class="">'+d.sp_contragents.namefull+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%" style=""><span class="row-details-report-missions-table-title_topic">Исполнитель</span></td>'+
											'<td style=""><span class="row-details-report-missions-table-txt"><span class="">'+d.dognet_spispol.ispolnamefull+'</span></td>'+
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
