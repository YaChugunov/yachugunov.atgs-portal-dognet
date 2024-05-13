'<div id="row-details">'+
	'<div class="row">'+
		'<div class="hidden-xs col-sm-12 col-md-12 col-lg-12">'+

			'<div class="space10"></div>'+
			'<table id="row-details-chetview-details-table" class="table table-condensed table-striped" >'+
				'<tbody>'+
					'<tr>'+
						'<td width="30%"><span class="row-details-chetview-details-table-title_topic">Номер счета</span></td>'+
						'<td width="70%"><span class="row-details-chetview-details-table-txt">'+d.dognet_docbase.docnumber+'</span></td>'+
					'</tr>'+
					'<tr>'+
						'<td width="30%"><span class="row-details-chetview-details-table-title_topic">Сумма</span></td>'+
						'<td width="70%"><span class="row-details-chetview-details-table-txt">'+$.fn.dataTable.render.number(' ', ',', 2, '').display( d.dognet_docbase.docsumma )+''+d.dognet_spdened.short_code+' ( '+d.dognet_docbase.usendssumma+' )</span></td>'+
					'</tr>'+
					'<tr>'+
						'<td width="30%"><span class="row-details-chetview-details-table-title_topic">Дата формирования счета</span></td>'+
						'<td width="70%"><span class="row-details-chetview-details-table-txt">'+d.dognet_docbase.daynachdoc+'.'+d.dognet_docbase.monthnachdoc+'.'+d.dognet_docbase.yearnachdoc+'</span></td>'+
					'</tr>'+
					'<tr>'+
						'<td width="30%"><span class="row-details-chetview-details-table-title_topic">Нименование счета краткое</span></td>'+
						'<td width="70%"><span class="row-details-chetview-details-table-txt">'+d.dognet_docbase.docnameshot+'</span></td>'+
					'</tr>'+
					'<tr>'+
						'<td width="30%"><span class="row-details-chetview-details-table-title_topic">Тип</span></td>'+
						'<td width="70%"><span class="row-details-chetview-details-table-txt">'+d.dognet_sptipdog.nametip+'</span></td>'+
					'</tr>'+
					'<tr>'+
						'<td width="30%"><span class="row-details-chetview-details-table-title_topic">Заказчик ( подробно раздел ниже )</span></td>'+
						'<td width="70%"><span class="row-details-chetview-details-table-txt">'+d.sp_contragents.nameshort+'</span></td>'+
					'</tr>'+
					'<tr>'+
						'<td width="30%"><span class="row-details-chetview-details-table-title_topic">Объект</span></td>'+
						'<td class="data-column" style="border-top:none"><span class="" >'+d.sp_objects.nameobjectshot+'</span></td>'+
					'</tr>'+
				'</tbody>'+
			'</table>'+

		'</div>'+
	'</div>'+
'</div>'
