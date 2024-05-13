'<div id="row-details-search">'+
	'<div class="row">'+
		'<div class="hidden-xs col-sm-12 col-md-12 col-lg-12">'+

			'<div class="space10"></div>'+
			'<table id="row-details-search-table" class="table table-condensed table-striped" >'+
				'<tbody>'+
					'<tr>'+
						'<td width="30%" class="title-column text-uppercase" style="border-top:none">Основание договора</td>'+
						'<td class="data-column" style="border-top:none"><span class="">'+osn+''+blank+'</span></td>'+
					'</tr>'+
					'<tr>'+
						'<td width="30%" class="title-column text-uppercase" style="border-top:none">Статус договора</td>'+
						'<td class="data-column" style="border-top:none"><span class="">'+d.dognet_spstatus.statusnamefull+'</span></td>'+
					'</tr>'+
					'<tr>'+
						'<td width="30%" class="title-column text-uppercase" style="border-top:none">Тип договора</td>'+
						'<td class="data-column" style="border-top:none"><span class="">'+d.dognet_sptipdog.nametip+'</span></td>'+
					'</tr>'+
					'<tr>'+
						'<td width="30%" class="title-column text-uppercase" style="border-top:none">Объект</td>'+
						'<td class="data-column" style="border-top:none"><span class="">'+d.sp_objects.nameobjectlong+'</span></td>'+
					'</tr>'+
					'<tr>'+
						'<td width="30%" class="title-column text-uppercase" style="border-top:none">Организация-плательщик</td>'+
						'<td class="data-column" style="border-top:none"><span class="">'+d.sp_contragents.namefull+'</span></td>'+
					'</tr>'+
					'<tr>'+
						'<td width="30%" class="title-column text-uppercase" style="border-top:none">Исполнитель</td>'+
						'<td class="data-column" style="border-top:none"><span class="">'+d.dognet_spispol.ispolnamefull+'</span></td>'+
					'</tr>'+
					'<tr>'+
						'<td width="30%" class="title-column text-uppercase" style="border-top:none">Исполнитель (руководство)</td>'+
						'<td class="data-column" style="border-top:none"><span class="">'+d.dognet_spispolruk.ispolrukname+'</span></td>'+
					'</tr>'+
					'<tr>'+
						'<td width="30%" class="title-column text-uppercase" style="border-top:none">Комментарии</td>'+
						'<td class="data-column" style="border-top:none"><span class="">'+d.dognet_docbase.comments+'</span></td>'+
					'</tr>'+
				'</tbody>'+
			'</table>'+

		'</div>'+
	'</div>'+
'</div>'
