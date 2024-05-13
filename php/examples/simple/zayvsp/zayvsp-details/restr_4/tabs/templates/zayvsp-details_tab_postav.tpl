'<div id="template-details-zayvsp-tab_postav">'+

	'<div id="row-details-zayvsp-tab_postav-tabs">'+
		'<div class="row">'+
			'<div class="col-xs-12 col-sm-12 col-md-12">'+
				'<ul id="row-details-zayvsp-tab_postav-tabs-menu" class="nav nav-tabs">'+
					'<li class="active"><a data-toggle="tab" href="#zayvsp-postav-'+row.id()+'-tab-1" title="">Общая информация</a></li>'+
					'<li><a data-toggle="tab" href="#zayvsp-postav-'+row.id()+'-tab-2" title="">Контакты (DocNET)</a></li>'+
					'<li><a data-toggle="tab" href="#zayvsp-postav-'+row.id()+'-tab-3" title="">Контакты (новые)</a></li>'+
				'</ul>'+
				'<div class="row-details-zayvsp-tab_postav-table-title_blank"><span>'+d.sp_contragents.namefull+'</span></div>'+
				'<div class="tab-content">'+
					'<div id="zayvsp-postav-'+row.id()+'-tab-1" class="tab-pane fade in active">'+
						'<div class="hidden-xs col-sm-12 col-md-12 col-lg-12">'+
							'<div class="space10"></div>'+
							'<div style="padding:10px">'+
								'<table id="row-details-zayvsp-tab_postav-table" class="table table-condensed table-striped" >'+
									'<tbody>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-zayvsp-tab_postav-table-title_topic">Внутренний ID поставщика</span></td>'+
											'<td width="70%"><span class="row-details-zayvsp-tab_postav-table-txt">'+d.sp_contragents.kodcontragent+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-zayvsp-tab_postav-table-title_topic">Краткое название</span></td>'+
											'<td width="70%"><span class="row-details-zayvsp-tab_postav-table-txt">'+d.sp_contragents.nameshort+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-zayvsp-tab_postav-table-title_topic">Полное название</span></td>'+
											'<td width="70%"><span class="row-details-zayvsp-tab_postav-table-txt">'+d.sp_contragents.namefull+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-zayvsp-tab_postav-table-title_topic">Адрес компании</span></td>'+
											'<td width="70%"><span class="row-details-zayvsp-tab_postav-table-txt">'+d.sp_contragents.address_postal+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-zayvsp-tab_postav-table-title_topic">Сайт компании</span></td>'+
											'<td width="70%"><span class="row-details-zayvsp-tab_postav-table-txt">'+d.url+'</span></td>'+
										'</tr>'+
									'</tbody>'+
								'</table>'+

							'</div>'+
						'</div>'+
					'</div>'+
					'<div id="zayvsp-postav-'+row.id()+'-tab-2" class="tab-pane fade">'+
						'<div class="hidden-xs col-sm-12 col-md-12 col-lg-12">'+
							'<div class="space10"></div>'+
							'<div style="padding:10px">'+
								'<table id="row-details-zayvsp-tab_postav-table" class="table table-condensed table-striped" >'+
									'<tbody>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-zayvsp-tab_postav-table-title_topic">Имя контакта</span></td>'+
											'<td width="70%"><span class="row-details-zayvsp-tab_postav-table-txt">'+d.sp_contragents.postcontactone+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-zayvsp-tab_postav-table-title_topic">Email</span></td>'+
											'<td width="70%"><span class="row-details-zayvsp-tab_postav-table-txt">'+d.sp_contragents.postcontactmail+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-zayvsp-tab_postav-table-title_topic">Телефон</span></td>'+
											'<td width="70%"><span class="row-details-zayvsp-tab_postav-table-txt">'+d.sp_contragents.postcontacttel+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-zayvsp-tab_postav-table-title_topic">Факс</span></td>'+
											'<td width="70%"><span class="row-details-zayvsp-tab_postav-table-txt">'+d.sp_contragents.postcontactfax+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td width="30%"><span class="row-details-zayvsp-tab_postav-table-title_topic">ICQ</span></td>'+
											'<td width="70%"><span class="row-details-zayvsp-tab_postav-table-txt">'+d.sp_contragents.postcontacticq+'</span></td>'+
										'</tr>'+
									'</tbody>'+
								'</table>'+

							'</div>'+
						'</div>'+
					'</div>'+
					'<div id="zayvsp-postav-'+row.id()+'-tab-3" class="tab-pane fade">'+
						'<div class="hidden-xs col-sm-12 col-md-4 col-lg-4">'+
							'<div class="space10"></div>'+
							'<div style="padding:10px">'+
								'<table id="row-details-zayvsp-tab_postav-table" cellspacing="2" class="table table-condensed" style="margin-bottom:20px">'+
									'<thead>'+
										'<tr>'+
											'<th width="" colspan="2" style="text-align:center; background-color:#fafafa"><span class="row-details-zayvsp-tab_postav-table-title_topic2">Контакт 1</span></th>'+
										'</tr>'+
									'</thead>'+
									'<tbody>'+
										'<tr style="border-bottom:1px #f1f1f1 solid">'+
											'<td><span class="row-details-zayvsp-tab_postav-table-title_topic"><span class="glyphicon glyphicon-user"></span></span></td>'+
											'<td style="text-align:left"><span class="row-details-zayvsp-tab_postav-table-txt"><b>'+d.sp_contragents.cont1_name+'</b></span></td>'+
										'</tr>'+
										'<tr style="border-bottom:1px #f1f1f1 solid">'+
											'<td><span class="row-details-zayvsp-tab_postav-table-title_topic"><span class="glyphicon glyphicon-envelope"></span></span></td>'+
											'<td style="text-align:left"><span class="row-details-zayvsp-tab_postav-table-txt">'+d.sp_contragents.cont1_email+'</span></td>'+
										'</tr>'+
										'<tr style="border-bottom:1px #f1f1f1 solid">'+
											'<td><span class="row-details-zayvsp-tab_postav-table-title_topic"><span class="glyphicon glyphicon-earphone"></span></span></td>'+
											'<td style="text-align:left"><span class="row-details-zayvsp-tab_postav-table-txt">'+d.sp_contragents.cont1_tels+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td><span class="row-details-zayvsp-tab_postav-table-title_topic"><span class="glyphicon glyphicon-phone"></span></span></td>'+
											'<td style="text-align:left"><span class="row-details-zayvsp-tab_postav-table-txt">'+d.sp_contragents.cont1_telm+'</span></td>'+
										'</tr>'+
									'</tbody>'+
								'</table>'+
							'</div>'+
						'</div>'+
						'<div class="hidden-xs col-sm-12 col-md-4 col-lg-4">'+
							'<div class="space10"></div>'+
							'<div style="padding:10px">'+
								'<table id="row-details-zayvsp-tab_postav-table" cellspacing="2" class="table table-condensed" style="margin-bottom:20px">'+
									'<thead>'+
										'<tr>'+
											'<th width="" colspan="2" style="text-align:center; background-color:#fafafa"><span class="row-details-zayvsp-tab_postav-table-title_topic2">Контакт 2</span></th>'+
										'</tr>'+
									'</thead>'+
									'<tbody>'+
										'<tr style="border-bottom:1px #f1f1f1 solid">'+
											'<td><span class="row-details-zayvsp-tab_postav-table-title_topic"><span class="glyphicon glyphicon-user"></span></span></td>'+
											'<td style="text-align:left"><span class="row-details-zayvsp-tab_postav-table-txt"><b>'+d.sp_contragents.cont2_name+'</b></span></td>'+
										'</tr>'+
										'<tr style="border-bottom:1px #f1f1f1 solid">'+
											'<td><span class="row-details-zayvsp-tab_postav-table-title_topic"><span class="glyphicon glyphicon-envelope"></span></span></td>'+
											'<td style="text-align:left"><span class="row-details-zayvsp-tab_postav-table-txt">'+d.sp_contragents.cont2_email+'</span></td>'+
										'</tr>'+
										'<tr style="border-bottom:1px #f1f1f1 solid">'+
											'<td><span class="row-details-zayvsp-tab_postav-table-title_topic"><span class="glyphicon glyphicon-earphone"></span></span></td>'+
											'<td style="text-align:left"><span class="row-details-zayvsp-tab_postav-table-txt">'+d.sp_contragents.cont2_tels+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td><span class="row-details-zayvsp-tab_postav-table-title_topic"><span class="glyphicon glyphicon-phone"></span></span></td>'+
											'<td style="text-align:left"><span class="row-details-zayvsp-tab_postav-table-txt">'+d.sp_contragents.cont2_telm+'</span></td>'+
										'</tr>'+
									'</tbody>'+
								'</table>'+
							'</div>'+
						'</div>'+
						'<div class="hidden-xs col-sm-12 col-md-4 col-lg-4">'+
							'<div class="space10"></div>'+
							'<div style="padding:10px">'+
								'<table id="row-details-zayvsp-tab_postav-table" cellspacing="2" class="table table-condensed" style="margin-bottom:20px">'+
									'<thead>'+
										'<tr>'+
											'<th width="" colspan="2" style="text-align:center; background-color:#fafafa"><span class="row-details-zayvsp-tab_postav-table-title_topic2">Контакт 3</span></th>'+
										'</tr>'+
									'</thead>'+
									'<tbody>'+
										'<tr style="border-bottom:1px #f1f1f1 solid">'+
											'<td><span class="row-details-zayvsp-tab_postav-table-title_topic"><span class="glyphicon glyphicon-user"></span></span></td>'+
											'<td style="text-align:left"><span class="row-details-zayvsp-tab_postav-table-txt"><b>'+d.sp_contragents.cont3_name+'</b></span></td>'+
										'</tr>'+
										'<tr style="border-bottom:1px #f1f1f1 solid">'+
											'<td><span class="row-details-zayvsp-tab_postav-table-title_topic"><span class="glyphicon glyphicon-envelope"></span></span></td>'+
											'<td style="text-align:left"><span class="row-details-zayvsp-tab_postav-table-txt">'+d.sp_contragents.cont3_email+'</span></td>'+
										'</tr>'+
										'<tr style="border-bottom:1px #f1f1f1 solid">'+
											'<td><span class="row-details-zayvsp-tab_postav-table-title_topic"><span class="glyphicon glyphicon-earphone"></span></span></td>'+
											'<td style="text-align:left"><span class="row-details-zayvsp-tab_postav-table-txt">'+d.sp_contragents.cont3_tels+'</span></td>'+
										'</tr>'+
										'<tr>'+
											'<td><span class="row-details-zayvsp-tab_postav-table-title_topic"><span class="glyphicon glyphicon-phone"></span></span></td>'+
											'<td style="text-align:left"><span class="row-details-zayvsp-tab_postav-table-txt">'+d.sp_contragents.cont3_telm+'</span></td>'+
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