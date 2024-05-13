'<div id="template-details-doc-main">'+

	'<div id="row-details-docview-doc-main-tabs">'+
		'<div class="row">'+
			'<div class="col-xs-12 col-sm-12 col-md-12">'+
				'<ul id="row-details-docview-doc-main-tabs-menu" class="nav nav-tabs">'+
					'<li class="active"><a data-toggle="tab" href="#doc-main-'+row.id()+'-tab-1" title="">Информация</a></li>'+
				'</ul>'+
				'<div class="row-details-docview-doc-main-table-title_blank">'+
				'<div class="detailsTitle">'+
					'<div class="" style="width:85%">'+
					'<div class="" style="font-size:2.0rem; text-transform:uppercase">Договор № 3/4-'+d.dognet_docbase.docnumber+'</div>'+
					'<div class="" style="font-size:1.65rem; font-weight:300; line-height:2.2rem; color:#666">'+d.dognet_docbase.docnameshot+'</div>'+
					'</div>'+
					'<div class="text-left" style="width:15%; line-height:2.5rem; border-left:1px #AAA solid; padding-left:1rem"><span style="float:left; font-size:0.8em; font-weight:300"><a href="dognet-docview.php?docview_type=current&export=yes&tip=letter_notify&uniqueID1='+koddoc+'&zak='+kodzakaz+'">Сопроводительное письмо</a></span>'+letterToChangeSrok+'</div>'+
				'</div>'+
				'</div>'+
				'<div class="tab-content">'+
					'<div id="doc-main-'+row.id()+'-tab-1" class="tab-pane fade in active">'+
						'<div class="hidden-xs col-sm-12 col-md-12 col-lg-12">'+
							'<div class="space10"></div>'+
							'<div style="padding:10px">'+

								'<table id="row-details-docview-doc-main-table" class="table table-condensed table-striped" >'+
									'<tbody>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-docview-doc-main-table-title_topic">Номер договора контрагента</span></td>'+
											'<td width="70%"><span class="row-details-docview-doc-main-table-txt">'+d.dognet_docbase.docpartnernumberSTR+'</span></td>'+
										'</tr>'+
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
											'<td width="30%"><span class="row-details-docview-doc-main-table-title_topic">Организация-плательщик (агент)</span></td>'+
											'<td width="70%"><span class="row-details-docview-doc-main-table-txt">'+d.sp_contragents.namefull+' ( '+d.agent+' )</span></td>'+
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