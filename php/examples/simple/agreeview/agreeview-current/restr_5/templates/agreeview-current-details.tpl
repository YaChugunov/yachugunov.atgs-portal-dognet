'<div id="template-details-doc-main">'+

	'<div id="row-details-agreeview-doc-main-tabs">'+
		'<div class="row">'+
			'<div class="col-xs-12 col-sm-12 col-md-12">'+
				'<ul id="row-details-agreeview-doc-main-tabs-menu" class="nav nav-tabs">'+
					'<li class="active"><a data-toggle="tab" href="#doc-main-'+row.id()+'-tab-1" title="">Информация</a></li>'+
				'</ul>'+
				'<div class="row-details-agreeview-doc-main-table-title_blank"><span>Соглашение № А/Б-'+d.dognet_agreebase.docnumber+'</span></div>'+
				'<div class="tab-content">'+
					'<div id="doc-main-'+row.id()+'-tab-1" class="tab-pane fade in active">'+
						'<div class="hidden-xs col-sm-12 col-md-12 col-lg-12">'+
							'<div class="space10"></div>'+
							'<div style="padding:10px">'+

								'<table id="row-details-agreeview-doc-main-table" class="table table-condensed table-striped" >'+
									'<tbody>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-agreeview-doc-main-table-title_topic">Основание договора</span></td>'+
											'<td width="70%"><span class="row-details-agreeview-doc-main-table-txt">'+osn+''+blank+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-agreeview-doc-main-table-title_topic">Краткое описание</span></td>'+
											'<td width="70%"><span class="row-details-agreeview-doc-main-table-txt">'+d.dognet_agreebase.docnameshot+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-agreeview-doc-main-table-title_topic">Полное описание</span></td>'+
											'<td width="70%"><span class="row-details-agreeview-doc-main-table-txt">'+d.dognet_agreebase.docnamefullm+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-agreeview-doc-main-table-title_topic">Компания-партнер</span></td>'+
											'<td width="70%"><span class="row-details-agreeview-doc-main-table-txt">'+d.sp_contragents.namefull+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-agreeview-doc-main-table-title_topic">Исполнитель</span></td>'+
											'<td width="70%"><span class="row-details-agreeview-doc-main-table-txt">'+d.dognet_spispol.ispolnamefull+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-agreeview-doc-main-table-title_topic">Комментарии</span></td>'+
											'<td width="70%"><span class="row-details-agreeview-doc-main-table-txt">'+d.dognet_agreebase.comments+'</span></td>'+
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