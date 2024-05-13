'<div id="row-details">'+
	'<div class="row">'+
		'<div class="hidden-xs col-sm-12 col-md-12 col-lg-12">'+

			'<div class="space10"></div>'+
			'<table id="row-details-chetview-details-table" class="table table-condensed table-striped" >'+
				'<tbody>'+
					'<tr>'+
						'<td width="30%"><span class="row-details-chetview-details-table-title_topic">Валюта</span></td>'+
						'<td width="70%"><span class="row-details-chetview-details-table-txt">'+d.dognet_spdened.namedenedshot+'</span></td>'+
					'</tr>'+
					'<tr>'+
						'<td width="30%"><span class="row-details-chetview-details-table-title_topic">Сумма договора</span></td>'+
						'<td width="70%"><span class="row-details-chetview-details-table-txt">'+$.fn.dataTable.render.number(' ', ',', 2, '').display( d.dognet_docbase.docsumma )+''+d.dognet_spdened.short_code+'</span></td>'+
					'</tr>'+
					'<tr>'+
						'<td width="30%"><span class="row-details-chetview-details-table-title_topic">Сумма выставленных счетов-фактур</span></td>'+
						'<td width="70%"><span class="row-details-chetview-details-table-txt">'+$.fn.dataTable.render.number(' ', ',', 2, '').display( d.dognet_docbase.summachf )+''+d.dognet_spdened.short_code+'</span></td>'+
					'</tr>'+
					'<tr>'+
						'<td width="30%"><span class="row-details-chetview-details-table-title_topic">Сумма оплат счетов-фактур</span></td>'+
						'<td width="70%"><span class="row-details-chetview-details-table-txt">'+$.fn.dataTable.render.number(' ', ',', 2, '').display( d.dognet_docbase.docoplata )+''+d.dognet_spdened.short_code+'</span></td>'+
					'</tr>'+
					'<tr>'+
						'<td width="30%"><span class="row-details-chetview-details-table-title_topic">Сумма полученных авансов</span></td>'+
						'<td width="70%"><span class="row-details-chetview-details-table-txt">'+$.fn.dataTable.render.number(' ', ',', 2, '').display( d.dognet_docbase.docavans )+''+d.dognet_spdened.short_code+'</span></td>'+
					'</tr>'+
					'<tr style="background-color:#fff">'+
						'<td colspan="2" style="border-top:none"></td>'+
					'</tr>'+
					'<tr style="background-color:#ccc">'+
						'<td width="30%"><span class="row-details-chetview-details-table-title_topic">Задолженность по выставленным счетам</span></td>'+
						'<td width="70%"><span class="row-details-chetview-details-table-txt">'+$.fn.dataTable.render.number(' ', ',', 2, '').display( d.dognet_docbase.doczadol )+''+d.dognet_spdened.short_code+'</span></td>'+
					'</tr>'+
					'<tr style="background-color:#ccc">'+
						'<td width="30%"><span class="row-details-chetview-details-table-title_topic">Незакрыто по полученным авансам</span></td>'+
						'<td width="70%"><span class="row-details-chetview-details-table-txt">'+$.fn.dataTable.render.number(' ', ',', 2, '').display( d.dognet_docbase.docnozak )+''+d.dognet_spdened.short_code+'</span></td>'+
					'</tr>'+
				'</tbody>'+
			'</table>'+

		'</div>'+
	'</div>'+
'</div>'
