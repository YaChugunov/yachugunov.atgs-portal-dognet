'<div id="row-details">'+
	'<div class="row">'+
		'<div class="hidden-xs col-sm-12 col-md-12 col-lg-12">'+

			'<div class="space10"></div>'+
			'<table id="row-details-docview-details-table" class="table table-condensed table-striped" >'+
				'<tbody>'+
					'<tr>'+
						'<td width="30%"><span class="row-details-docview-details-table-title_topic">Номер договора</span></td>'+
						'<td width="70%"><span class="row-details-docview-details-table-txt">3-4/'+d.dognet_docbase.docnumber+'</span></td>'+
					'</tr>'+
					'<tr>'+
						'<td width="30%"><span class="row-details-docview-details-table-title_topic">Номер договора ( контрагент )</span></td>'+
						'<td width="70%"><span class="row-details-docview-details-table-txt">'+d.dognet_docbase.docpartnernumberSTR+'</span></td>'+
					'</tr>'+
					'<tr>'+
						'<td width="30%"><span class="row-details-docview-details-table-title_topic">Обоснование ввода</span></td>'+
						'<td width="70%"><span class="row-details-docview-details-table-txt">'+osn+''+blank+'</span></td>'+
					'</tr>'+
					'<tr>'+
						'<td width="30%"><span class="row-details-docview-details-table-title_topic">Сумма</span></td>'+
						'<td width="70%"><span class="row-details-docview-details-table-txt">'+$.fn.dataTable.render.number(' ', ',', 2, '').display( d.dognet_docbase.docsumma )+''+d.dognet_spdened.short_code+' ( '+d.dognet_docbase.usendssumma+' )</span></td>'+
					'</tr>'+
					'<tr>'+
						'<td width="30%"><span class="row-details-docview-details-table-title_topic">Дата начала договора</span></td>'+
						'<td width="70%"><span class="row-details-docview-details-table-txt">'+d.DN+'.'+d.MN+'.'+d.dognet_docbase.yearnachdoc+'</span></td>'+
					'</tr>'+
					'<tr>'+
						'<td width="30%"><span class="row-details-docview-details-table-title_topic">Дата окончания договора</span></td>'+
						'<td width="70%"><span class="row-details-docview-details-table-txt">'+d.DE+'.'+d.ME+'.'+d.dognet_docbase.yearenddoc+'</span></td>'+
					'</tr>'+
					'<tr>'+
						'<td width="30%"><span class="row-details-docview-details-table-title_topic">Нименование договора краткое</span></td>'+
						'<td width="70%"><span class="row-details-docview-details-table-txt">'+d.dognet_docbase.docnameshot+'</span></td>'+
					'</tr>'+
					'<tr>'+
						'<td width="30%"><span class="row-details-docview-details-table-title_topic">Наименование договора полное</span></td>'+
						'<td width="70%"><span class="row-details-docview-details-table-txt">'+d.dognet_docbase.docnamefullm+'</span></td>'+
					'</tr>'+
					'<tr>'+
						'<td width="30%"><span class="row-details-docview-details-table-title_topic">Тип</span></td>'+
						'<td width="70%"><span class="row-details-docview-details-table-txt">'+d.dognet_sptipdog.nametip+'</span></td>'+
					'</tr>'+
					'<tr>'+
						'<td width="30%"><span class="row-details-docview-details-table-title_topic">Заказчик ( агент )</span></td>'+
						'<td width="70%"><span class="row-details-docview-details-table-txt">'+d.sp_contragents.nameshort+' ( '+d.agent+' )</span></td>'+
					'</tr>'+
					'<tr>'+
						'<td width="30%"><span class="row-details-docview-details-table-title_topic">Объект</span></td>'+
						'<td width="70%"><span class="row-details-docview-details-table-txt">'+d.sp_objects.nameobjectshot+'</span></td>'+
					'</tr>'+
					'<tr>'+
						'<td width="30%"><span class="row-details-docview-details-table-title_topic">Статус</span></td>'+
						'<td width="70%"><span class="row-details-docview-details-table-txt">'+d.dognet_spstatus.statusnameshot+'</span></td>'+
					'</tr>'+
					'<tr>'+
						'<td width="30%"><span class="row-details-docview-details-table-title_topic">Специальные отметки</span></td>'+
						'<td width="70%"><span class="row-details-docview-details-table-txt">'+specialcomm+'</span></td>'+
					'</tr>'+
				'</tbody>'+
			'</table>'+

		'</div>'+
	'</div>'+
'</div>'
