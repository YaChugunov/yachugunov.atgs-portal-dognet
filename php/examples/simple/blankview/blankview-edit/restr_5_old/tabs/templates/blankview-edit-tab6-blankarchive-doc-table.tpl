'<div id="template-details">'+

	'<div id="blankview-details-doc-tabs">'+
	'<div class="row">'+
		'<div class="col-xs-12 col-sm-12 col-md-12">'+
			'<ul id="blankview-details-doc-tabs-menu" class="nav nav-tabs">'+
				'<li class="active"><a data-toggle="tab" href="#doc-main-archive-'+row.id()+'-tab-1" title="">Бланк</a></li>'+
				'<li><a data-toggle="tab" href="#doc-main-archive-'+row.id()+'-tab-2" title="">Договор</a></li>'+
			'</ul>'+
			'<div class="template-details-tab1-table-title_blank"><span>Бланк требований № '+d.dognet_docblankwork.yearblankwork+'-'+d.dognet_docblankwork.numberblankwork+'</span></div>'+
			'<div class="template-details-tab1-table-blankstatus"><span class="label label-default" style="margin-right:5px">'+d.dognet_docblankwork.statusblankwork+'</span><span class="label label-default" style="margin-left:5px">'+d.dognet_docblankwork.nametipblankwork+'</span></div>'+
			'<div class="tab-content">'+
				'<div id="doc-main-archive-'+row.id()+'-tab-1" class="tab-pane fade in active">'+
					'<div class="hidden-xs col-sm-12 col-md-12 col-lg-12">'+

						'<div class="space10"></div>'+
						'<div style="padding:10px">'+
							'<table id="template-details-table" class="table table-striped" >'+
								'<tbody>'+
									'<tr>'+
										'<td width="30%"><span class="template-details-tab1-table-title_topic">Номер бланка</span></td>'+
										'<td width="70%"><span class="template-details-table-txt">'+d.dognet_docblankwork.numberblankwork+'</span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="30%"><span class="template-details-tab1-table-title_topic">ID бланка</span></td>'+
										'<td width="70%"><span class="template-details-table-txt">'+d.dognet_docblankwork.kodblankwork+'</span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="30%"><span class="template-details-tab1-table-title_topic">Статус бланка</span></td>'+
										'<td width="70%"><span class="template-details-table-txt">'+d.dognet_docblankwork.statusblankwork+'</span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="30%"><span class="template-details-table-title">Дата создания</span></td>'+
										'<td width="70%"><span class="template-details-table-txt">'+d.dognet_docblankwork.dateblankorder+'</span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="30%"><span class="template-details-table-title">Дата оформления</span></td>'+
										'<td width="70%"><span class="template-details-table-txt">'+d.dognet_docblankwork.dateblankwork+'</span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="30%"><span class="template-details-table-title">Дата договора</span></td>'+
										'<td width="70%"><span class="template-details-table-txt">'+d.dognet_docblankwork.dateblankdoc+'</span></td>'+
									'</tr>'+
								'</tbody>'+
							'</table>'+
						'</div>'+

					'</div>'+
				'</div>'+
				'<div id="doc-main-archive-'+row.id()+'-tab-2" class="tab-pane fade">'+
					'<div class="hidden-xs col-sm-12 col-md-12 col-lg-12">'+

						'<div class="space10"></div>'+
						'<div style="padding:10px">'+
							'<table id="template-details-table" class="table table-striped">'+
								'<tbody>'+
									'<tr>'+
										'<td width="30%"><span class="template-details-tab1-table-title_topic">Номер договора</span></td>'+
										'<td width="70%"><span class="template-details-table-txt">'+d.dognet_docblankwork.numberdoccr+'</span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="30%"><span class="template-details-tab1-table-title_topic">Тип договора</span></td>'+
										'<td width="70%"><span class="template-details-table-txt">'+d.dognet_docblankwork.nametipblankwork+'</span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="30%"><span class="template-details-tab1-table-title_topic">Название договора</span></td>'+
										'<td width="70%"><span class="template-details-table-txt">'+d.dognet_docblankwork.nameblankwork+'</span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="30%"><span class="template-details-tab1-table-title_topic">Название организации</span></td>'+
										'<td width="70%"><span class="template-details-table-txt">'+d.dognet_docblankwork.nameorgblankwork+'</span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="30%"><span class="template-details-table-title">Исполнитель от руководства</span></td>'+
										'<td width="70%"><span class="template-details-table-txt">'+d.dognet_spispolruk.ispolruknamefull+'</span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="30%"><span class="template-details-table-title">Исполнитель</span></td>'+
										'<td width="70%"><span class="template-details-table-txt">'+d.dognet_spispol.ispolnamefull+'</span></td>'+
									'</tr>'+
								'</tbody>'+
							'</table>'+
						'</div>'+

					'</div>'+
				'</div>'+

			'</div>'+
		'</div>'+
	'</div>'+

'</div>'
