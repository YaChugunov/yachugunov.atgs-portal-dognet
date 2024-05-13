'<div id="template-details-doc-main">'+

	'<div id="row-details-docview-doc-main-tabs">'+
		'<div class="row">'+
			'<div class="col-xs-12 col-sm-12 col-md-12">'+
				'<ul id="row-details-docview-doc-main-tabs-menu" class="nav nav-tabs">'+
					'<li class="active"><a data-toggle="tab" href="#doc-main-'+row.id()+'-tab-1" title="">Информация</a></li>'+
				'</ul>'+
				'<div class="row-details-docview-doc-main-table-title_blank">'+
					'<span>Договор № 3/4-'+d.dognet_docbase.docnumber+'</span>'+
					'<span style="float:right; font-size:0.8em"><a href="dognet-docview.php?docview_type=current&export=yes&uniqueID1='+koddoc+'&zak='+kodzakaz+'"><span class="glyphicon glyphicon-print" style="padding-right:5px"></span>Сопроводительное письмо</a></span>'+
				'</div>'+
				'<div class="tab-content">'+
					'<div id="doc-main-'+row.id()+'-tab-1" class="tab-pane fade in active">'+
						'<div class="hidden-xs col-sm-12 col-md-12 col-lg-12">'+
							'<div class="space10"></div>'+
							'<div style="padding:10px">'+

								'<table id="row-details-docview-doc-main-table" class="table table-condensed table-striped" >'+
									'<tbody>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-docview-doc-main-table-title_topic">Основание договора</span></td>'+
											'<td width="70%"><span class="row-details-docview-doc-main-table-txt">'+osn+''+blank+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-docview-doc-main-table-title_topic">Статус договора</span></td>'+
											'<td width="70%"><span class="row-details-docview-doc-main-table-txt">'+d.dognet_spstatus.statusnamefull+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-docview-doc-main-table-title_topic">Тип договора</span></td>'+
											'<td width="70%"><span class="row-details-docview-doc-main-table-txt">'+d.dognet_sptipdog.nametip+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-docview-doc-main-table-title_topic">Объект</span></td>'+
											'<td width="70%"><span class="row-details-docview-doc-main-table-txt">'+d.sp_objects.nameobjectlong+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-docview-doc-main-table-title_topic">Организация-плательщик</span></td>'+
											'<td width="70%"><span class="row-details-docview-doc-main-table-txt">'+d.sp_contragents.namefull+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-docview-doc-main-table-title_topic">Исполнитель</span></td>'+
											'<td width="70%"><span class="row-details-docview-doc-main-table-txt">'+d.dognet_spispol.ispolnamefull+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-docview-doc-main-table-title_topic">Комментарии</span></td>'+
											'<td width="70%"><span class="row-details-docview-doc-main-table-txt">'+d.dognet_docbase.comments+'</span></td>'+
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