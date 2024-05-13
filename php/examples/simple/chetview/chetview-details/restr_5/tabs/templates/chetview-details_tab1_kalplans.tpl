'<div id="row-details">'+
	'<div class="row">'+
		'<div class="hidden-xs col-sm-12 col-md-12 col-lg-12">'+

			'<div class="space10"></div>'+
			'<table id="row-details-tab1_kalplans" class="table table-condensed table-striped" >'+
				'<tbody>'+
					'<tr>'+
						'<td width="30%" class="title-column text-uppercase" style="border-top:none">Номер этапа :</td>'+
						'<td class="data-column" style="border-top:none"><span class="">'+d.dognet_dockalplan.numberstage+'</span></td>'+
					'</tr>'+
					'<tr>'+
						'<td width="30%" class="title-column text-uppercase" style="border-top:none">Описание этапа :</td>'+
						'<td class="data-column" style="border-top:none"><span class="">'+d.dognet_dockalplan.nameshotstage+'</span></td>'+
					'</tr>'+
					'<tr>'+
						'<td width="30%" class="title-column text-uppercase" style="border-top:none">Полное наименование этапа :</td>'+
						'<td class="data-column" style="border-top:none"><span class="">'+d.dognet_dockalplan.namefullstage+'</span></td>'+
					'</tr>'+
					'<tr>'+
						'<td width="30%" class="title-column text-uppercase" style="border-top:none">Объект по этапу :</td>'+
						'<td class="data-column" style="border-top:none"><span class="">'+d.sp_objects.nameobjectshot+'</span></td>'+
					'</tr>'+
					'<tr>'+
						'<td width="30%" class="title-column text-uppercase" style="border-top:none">Сумма этапа :</td>'+
						'<td class="data-column" style="border-top:none"><span class="">'+$.fn.dataTable.render.number(' ', ',', 2, '').display( d.dognet_dockalplan.summastage )+''+d.dognet_spdened.short_code+'</span></td>'+
					'</tr>'+
				'</tbody>'+
			'</table>'+

		'</div>'+
	'</div>'+
'</div>'
