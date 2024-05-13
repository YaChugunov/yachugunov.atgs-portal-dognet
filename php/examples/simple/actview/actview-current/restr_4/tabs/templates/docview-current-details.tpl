'<div id="template-details-docs-main">'+

	'<div id="row-details-actview-docs-main-tabs">'+
		'<div class="row">'+
			'<div class="col-xs-12 col-sm-12 col-md-12">'+
				'<ul id="row-details-actview-docs-main-tabs-menu" class="nav nav-tabs">'+
					'<li class="active"><a data-toggle="tab" href="#doc-main-'+row.id()+'-tab-1" title="">Информация</a></li>'+
				'</ul>'+
				'<div class="row-details-actview-docs-main-table-title_blank"><span>Договор № 3/4-'+d.dognet_docbase.docnumber+'</span></div>'+
				'<div class="tab-content">'+
					'<div id="doc-main-'+row.id()+'-tab-1" class="tab-pane fade in active">'+
						'<div class="hidden-xs col-sm-12 col-md-12 col-lg-12">'+
							'<div class="space10"></div>'+
							'<div style="padding:10px">'+

								'<table id="row-details-actview-docs-main-table" class="table table-condensed table-striped" >'+
									'<tbody>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-actview-docs-main-table-title_topic">Краткое название</span></td>'+
											'<td width="70%"><span class="row-details-actview-docs-main-table-txt">'+d.dognet_docbase.docnameshot+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-actview-docs-main-table-title_topic">Полное название</span></td>'+
											'<td width="70%"><span class="row-details-actview-docs-main-table-txt">'+d.dognet_docbase.docnamefullm+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-actview-docs-main-table-title_topic">Статус договора</span></td>'+
											'<td width="70%"><span class="row-details-actview-docs-main-table-txt">'+d.dognet_spstatus.statusnamefull+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-actview-docs-main-table-title_topic">Тип договора</span></td>'+
											'<td width="70%"><span class="row-details-actview-docs-main-table-txt">'+d.dognet_sptipdog.nametip+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-actview-docs-main-table-title_topic">Объект</span></td>'+
											'<td width="70%"><span class="row-details-actview-docs-main-table-txt">'+d.sp_objects.nameobjectlong+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-actview-docs-main-table-title_topic">Организация-плательщик</span></td>'+
											'<td width="70%"><span class="row-details-actview-docs-main-table-txt">'+d.sp_contragents.namefull+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-actview-docs-main-table-title_topic">Исполнитель</span></td>'+
											'<td width="70%"><span class="row-details-actview-docs-main-table-txt">'+d.dognet_spispol.ispolnamefull+'</span></td>'+
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
