'<div id="template-details">'+

	'<div id="blankview-details-blank-tabs">'+
	'<div class="row">'+
		'<div class="col-xs-12 col-sm-12 col-md-12">'+
			'<ul id="blankview-details-blank-tabs-menu" class="nav nav-tabs">'+
				'<li class="active"><a data-toggle="tab" href="#blankarchive-main-sub-'+row.id()+'-tab-1" title="">Основное</a></li>'+
				'<li><a data-toggle="tab" href="#blankarchive-main-sub-'+row.id()+'-tab-2" title="">Суммы</a></li>'+
				'<li><a data-toggle="tab" href="#blankarchive-main-sub-'+row.id()+'-tab-3" title="">Приложения</a></li>'+
				'<li><a data-toggle="tab" href="#blankarchive-main-sub-'+row.id()+'-tab-10" title="">Условия</a></li>'+
				'<li><a data-toggle="tab" href="#blankarchive-main-sub-'+row.id()+'-tab-4" title="">Исполнение</a></li>'+
				'<li><a data-toggle="tab" href="#blankarchive-main-sub-'+row.id()+'-tab-5" title="">Контакт</a></li>'+
				'<li><a data-toggle="tab" href="#blankarchive-main-sub-'+row.id()+'-tab-6" title="">Командировки</a></li>'+
				'<li><a data-toggle="tab" href="#blankarchive-main-sub-'+row.id()+'-tab-7" title="">Транспорт</a></li>'+
				'<li><a data-toggle="tab" href="#blankarchive-main-sub-'+row.id()+'-tab-8" title="">ДО</a></li>'+
				'<li><a data-toggle="tab" href="#blankarchive-main-sub-'+row.id()+'-tab-9" title="">Риски</a></li>'+
			'</ul>'+
			'<div class="template-details-tab1-table-title_blank"><span>Заявка к бланку требований № '+d.dognet_docblankwork.yearblankwork+'-'+d.dognet_docblankwork.numberblankwork+'</span></div>'+
			'<div class="template-details-tab1-table-blankstatus"><span class="label label-default" style="margin-right:5px">'+d.dognet_docblankwork.statusblankwork+'</span><span class="label label-default" style="margin-left:5px">'+d.dognet_docblankwork.nametipblankwork+'</span><span style="float:right"><a href="dognet-blankview.php?blankview_type=edit&export=yes&blankID='+d.dognet_docblankwork.kodblankwork+'&blankType='+d.dognet_docblankwork.kodtipblank+'"><span class="glyphicon glyphicon-print"></span></a></span></div>'+
			'<div class="tab-content">'+
				'<div id="blankarchive-main-sub-'+row.id()+'-tab-1" class="tab-pane fade in active">'+
					'<div class="hidden-xs col-sm-12 col-md-12 col-lg-12">'+
						'<div class="space10"></div>'+
						'<div style="padding:10px">'+
							'<table id="template-details-tab1-table" class="table" >'+
								'<tbody>'+
									'<tr>'+
										'<td width="5%" class="td-title"><span class="template-details-tab1-table-title_topic">I</span></td>'+
										'<td width="35%" class="td-title" colspan="2"><span class="template-details-tab1-table-title_topic">Ответственный руководитель</span></td>'+
										'<td width="60%"><span class="template-details-tab1-table-txt"><span class="txt-parameter">'+d.dognet_spispolruk.ispolruknamefull+'</span></span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="5%" class="td-title"><span class="template-details-tab1-table-title_topic">II</span></td>'+
										'<td width="35%" class="td-title" colspan="2"><span class="template-details-tab1-table-title_topic">ГИП по договору</span></td>'+
										'<td width="60%"><span class="template-details-tab1-table-txt"><span class="txt-parameter">'+d.dognet_spispol.ispolnamefull+'</span></span></td>'+
									'</tr>'+
									'<tr><td colspan="4"></td></tr>'+
									'<tr class="tr-title">'+
										'<td width="5%"><span class="template-details-tab1-table-title_topic">III</span></td>'+
										'<td width="95%" colspan="3"><span class="template-details-tab1-table-title_topic">Наименование организации</span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="5%"><span class="template-details-tab1-table-title"></span></td>'+
										'<td width="5%"><span class="template-details-tab1-table-title">1)</span></td>'+
										'<td width="30%"><span class="template-details-tab1-table-title">Заказчик (Покупатель)</span></td>'+
										'<td width="60%"><span class="template-details-tab1-table-txt"><span class="txt-parameter">'+d.sp_contragents.nameshort+'</span></span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="5%"><span class="template-details-tab1-table-title"></span></td>'+
										'<td width="5%"><span class="template-details-tab1-table-title">2)</span></td>'+
										'<td width="30%"><span class="template-details-tab1-table-title">Исполнитель (Поставщик)</span></td>'+
										'<td width="60%"><span class="template-details-tab1-table-txt"><span class="txt-parameter">'+d.sp_contragents_subpodr.nameshort+'</span></span></td>'+
									'</tr>'+
									'<tr><td colspan="4"></td></tr>'+
									'<tr>'+
										'<td width="5%" class="td-title"><span class="template-details-tab1-table-title_topic">IV</span></td>'+
										'<td width="35%" class="td-title" colspan="2"><span class="template-details-tab1-table-title_topic">Предмет договора</span></td>'+
										'<td width="60%"><span class="template-details-tab1-table-txt"><span class="txt-parameter">'+d.dognet_blankdocsub.namedocblank+'</span></span></td>'+
									'</tr>'+
								'</tbody>'+
							'</table>'+
						'</div>'+

					'</div>'+
				'</div>'+
				'<div id="blankarchive-main-sub-'+row.id()+'-tab-2" class="tab-pane fade">'+
					'<div class="hidden-xs col-sm-12 col-md-12 col-lg-12">'+
						'<div class="space10"></div>'+
						'<div style="padding:10px">'+
							'<table id="template-details-tab1-table" class="table">'+
								'<tbody>'+
									'<tr>'+
										'<td width="5%" class="td-title"><span class="template-details-tab1-table-title_topic">V</span></td>'+
										'<td width="35%" class="td-title" colspan="2"><span class="template-details-tab1-table-title_topic">Сумма договора</span></td>'+
										'<td width="60%"><span class="template-details-tab1-table-txt"><span class="txt-parameter">'+d.dognet_blankdocsub.csummadocopl+'</span>рублей</span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="5%"><span class="template-details-tab1-table-title"></span></td>'+
										'<td width="35%" colspan="2"><span class="template-details-tab1-table-txt">Без учета НДС</span></td>'+
										'<td width="60%"><span class="template-details-tab1-table-txt">'+print_checkBox(d.dognet_blankdocsub.kodusendsopl)+'</span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="5%"><span class="template-details-tab1-table-title"></span></td>'+
										'<td width="35%" colspan="2"><span class="template-details-tab1-table-txt">По спецификации</span></td>'+
										'<td width="60%"><span class="template-details-tab1-table-txt">'+print_checkBox(d.dognet_blankdocsub.kodusespechopl)+'</span></td>'+
									'</tr>'+
									'<tr><td colspan="4"><a class="template-details-tab1-table-link" href="#blankview-gip-blankwork-summadop">Разбиение суммы договора</a></td></tr>'+
									'<tr><td colspan="4"></td></tr>'+
									'<tr class="tr-title">'+
										'<td width="5%"><span class="template-details-tab1-table-title_topic">VI</span></td>'+
										'<td width="95%" colspan="3"><span class="template-details-tab1-table-title_topic">Порядок оплаты</span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="5%"><span class="template-details-tab1-table-title"></span></td>'+
										'<td width="5%"><span class="template-details-tab1-table-title">1)</span></td>'+
										'<td width="90%" colspan="2"><span class="template-details-tab1-table-txt">Аванс<span class="txt-parameter">'+d.dognet_blankdocsub.csummaopl1usl+'</span>%</span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="5%"><span class="template-details-tab1-table-title"></span></td>'+
										'<td width="5%"><span class="template-details-tab1-table-title">2)</span></td>'+
										'<td width="90%" colspan="2"><span class="template-details-tab1-table-txt">Окончательная оплата в размере<span class="txt-parameter">'+d.dognet_blankdocsub.csummaopl2usl+'</span>% в течение<span class="txt-parameter">'+d.dognet_blankdocsub.cnumberoplday2usl+'</span>дней после подписания акта</span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="5%"><span class="template-details-tab1-table-title"></span></td>'+
										'<td width="5%"><span class="template-details-tab1-table-title">3)</span></td>'+
										'<td width="90%" colspan="2"><span class="template-details-tab1-table-txt">В течение<span class="txt-parameter">'+d.dognet_blankdocsub.cnumberoplday3usl+'</span>дней после получения соответствующего финансирования от конечного Заказчика</span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="5%"><span class="template-details-tab1-table-title"></span></td>'+
										'<td width="5%"><span class="template-details-tab1-table-title">4)</span></td>'+
										'<td width="90%" colspan="2"><span class="template-details-tab1-table-txt">Иная<span class="txt-parameter">'+d.dognet_blankdocsub.ctextoplotherusl+'</span></span></td>'+
									'</tr>'+
								'</tbody>'+
							'</table>'+
						'</div>'+
					'</div>'+
				'</div>'+
				'<div id="blankarchive-main-sub-'+row.id()+'-tab-3" class="tab-pane fade">'+

					'<div class="hidden-xs col-sm-12 col-md-12 col-lg-12">'+
						'<div class="space10"></div>'+
						'<div style="padding:10px">'+
							'<table id="template-details-tab1-table" class="table">'+
								'<tbody>'+
									'<tr class="tr-title">'+
										'<td width="5%"><span class="template-details-tab1-table-title_topic">VII</span></td>'+
										'<td width="95%" colspan="3"><span class="template-details-tab1-table-title_topic">Перечень приложений к договору</span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="5%"><span class="template-details-tab1-table-title"></span></td>'+
										'<td width="5%"><span class="template-details-tab1-table-title">1)</span></td>'+
										'<td width="65%"><span class="template-details-tab1-table-title">Технические требования</span></td>'+
										'<td width="25%"><span class="template-details-tab1-table-txt">'+print_checkBox(d.dognet_blankdocsub.kodusepril1)+'</span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="5%"><span class="template-details-tab1-table-title"></span></td>'+
										'<td width="5%"><span class="template-details-tab1-table-title">2)</span></td>'+
										'<td width="65%"><span class="template-details-tab1-table-title">Календарный план</span></td>'+
										'<td width="25%"><span class="template-details-tab1-table-txt">'+print_checkBox(d.dognet_blankdocsub.kodusepril2)+'</span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="5%"><span class="template-details-tab1-table-title"></span></td>'+
										'<td width="5%"><span class="template-details-tab1-table-title">3)</span></td>'+
										'<td width="65%"><span class="template-details-tab1-table-title">Спецификация</span></td>'+
										'<td width="25%"><span class="template-details-tab1-table-txt">'+print_checkBox(d.dognet_blankdocsub.kodusepril3)+'</span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="5%"><span class="template-details-tab1-table-title"></span></td>'+
										'<td width="5%"><span class="template-details-tab1-table-title">4)</span></td>'+
										'<td width="65%"><span class="template-details-tab1-table-title">Протокол соглашения о договорной цене</span></td>'+
										'<td width="25%"><span class="template-details-tab1-table-txt">'+print_checkBox(d.dognet_blankdocsub.kodusepril4)+'</span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="5%"><span class="template-details-tab1-table-title"></span></td>'+
										'<td width="5%"><span class="template-details-tab1-table-title">5)</span></td>'+
										'<td width="65%"><span class="template-details-tab1-table-title">Сметный расчет</span></td>'+
										'<td width="25%"><span class="template-details-tab1-table-txt">'+print_checkBox(d.dognet_blankdocsub.kodusepril5)+'</span></td>'+
									'</tr>'+
								'</tbody>'+
							'</table>'+
						'</div>'+
					'</div>'+

				'</div>'+
				'<div id="blankarchive-main-sub-'+row.id()+'-tab-10" class="tab-pane fade">'+

					'<div class="hidden-xs col-sm-12 col-md-12 col-lg-12">'+
						'<div class="space10"></div>'+
						'<div style="padding:10px">'+
							'<table id="template-details-tab1-table" class="table">'+
								'<tbody>'+
									'<tr class="tr-title">'+
										'<td width="5%"><span class="template-details-tab1-table-title_topic">VIII</span></td>'+
										'<td width="95%" colspan="3"><span class="template-details-tab1-table-title_topic">Особые условия (определяются ГИПом)</span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="5%"><span class="template-details-tab1-table-title"></span></td>'+
										'<td width="95%" colspan="2"><span class="template-details-tab1-table-txt">Особые условия договора<span class="txt-parameter">'+d.dognet_blankdocsub.defuslgiptext+'</span></span></td>'+
									'</tr>'+
								'</tbody>'+
							'</table>'+
						'</div>'+
					'</div>'+

				'</div>'+
				'<div id="blankarchive-main-sub-'+row.id()+'-tab-4" class="tab-pane fade">'+

					'<div class="space10"></div>'+
					'<div class="hidden-xs col-sm-12 col-md-12 col-lg-12">'+
						'<div style="padding:10px">'+
							'<table id="template-details-tab1-table" class="table">'+
								'<tbody>'+
									'<tr class="tr-title">'+
										'<td width="5%"><span class="template-details-tab1-table-title_topic">IX</span></td>'+
										'<td width="95%" colspan="3"><span class="template-details-tab1-table-title_topic">Срок исполнения договорных обязательств</span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="5%"><span class="template-details-tab1-table-title"></span></td>'+
										'<td width="5%"><span class="template-details-tab1-table-title">1)</span></td>'+
										'<td width="1%"><span class="template-details-tab1-table-txt">'+print_checkBox(d.dognet_blankdocsub.koduseispoldoc1)+'</span></td>'+
										'<td width="89%"><span class="template-details-tab1-table-txt">Дата<span class="txt-parameter">'+d.dognet_blankdocsub.cdateispoldoc1+'</span></span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="5%"><span class="template-details-tab1-table-title"></span></td>'+
										'<td width="5%"><span class="template-details-tab1-table-title">2)</span></td>'+
										'<td width="1%"><span class="template-details-tab1-table-txt">'+print_checkBox(d.dognet_blankdocsub.koduseispoldoc2)+'</span></td>'+
										'<td width="89%"><span class="template-details-tab1-table-txt"><span class="txt-parameter">'+d.dognet_blankdocsub.cdateispoldoc1+'</span>дней от аванса</span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="5%"><span class="template-details-tab1-table-title"></span></td>'+
										'<td width="5%"><span class="template-details-tab1-table-title">3)</span></td>'+
										'<td width="1%"><span class="template-details-tab1-table-txt">'+print_checkBox(d.dognet_blankdocsub.koduseispoldoc3)+'</span></td>'+
										'<td width="89%"><span class="template-details-tab1-table-txt">Автоматическая пролонгация</span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="5%"><span class="template-details-tab1-table-title"></span></td>'+
										'<td width="5%"><span class="template-details-tab1-table-title">4)</span></td>'+
										'<td width="1%"><span class="template-details-tab1-table-txt">'+print_checkBox(d.dognet_blankdocsub.koduseispoldoc4)+'</span></td>'+
										'<td width="89%"><span class="template-details-tab1-table-txt">*Конец года</span></td>'+
									'</tr>'+
								'</tbody>'+
							'</table>'+
						'</div>'+
					'</div>'+

				'</div>'+
				'<div id="blankarchive-main-sub-'+row.id()+'-tab-5" class="tab-pane fade">'+

					'<div class="space10"></div>'+
					'<div class="hidden-xs col-sm-12 col-md-12 col-lg-12">'+
						'<div style="padding:10px">'+
							'<table id="template-details-tab1-table" class="table">'+
								'<tbody>'+
									'<tr class="tr-title">'+
										'<td width="5%"><span class="template-details-tab1-table-title_topic">X</span></td>'+
										'<td width="95%" colspan="3"><span class="template-details-tab1-table-title_topic">Контактное лицо партнера</span></td>'+
									'</tr>'+
								'</tbody>'+
							'</table>'+
						'</div>'+
					'</div>'+
					'<div class="hidden-xs col-sm-12 col-md-6 col-lg-6">'+
						'<div style="padding:10px">'+
							'<table id="template-details-tab1-table" class="table">'+
								'<tbody>'+
									'<tr>'+
										'<td width="30%"><span class="template-details-tab1-table-title">Фамилия</span></td>'+
										'<td width="70%" colspan="3"><span class="template-details-tab1-table-txt"><span class="txt-parameter">'+d.dognet_blankdocsub.nameendcontact+'</span></span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="30%"><span class="template-details-tab1-table-title">Имя</span></td>'+
										'<td width="70%" colspan="3"><span class="template-details-tab1-table-txt"><span class="txt-parameter">'+d.dognet_blankdocsub.namefistcontact+'</span></span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="30%"><span class="template-details-tab1-table-title">Отчество</span></td>'+
										'<td width="70%" colspan="3"><span class="template-details-tab1-table-txt"><span class="txt-parameter">'+d.dognet_blankdocsub.namesecondcontact+'</span></span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="30%"><span class="template-details-tab1-table-title">Должность</span></td>'+
										'<td width="70%" colspan="3"><span class="template-details-tab1-table-txt"><span class="txt-parameter">'+d.dognet_blankdocsub.namedoljcontact+'</span></span></td>'+
									'</tr>'+
								'</tbody>'+
							'</table>'+
						'</div>'+
					'</div>'+
					'<div class="hidden-xs col-sm-12 col-md-6 col-lg-6">'+
						'<div style="padding:10px">'+
							'<table id="template-details-tab1-table" class="table">'+
								'<tbody>'+
									'<tr>'+
										'<td width="30%"><span class="template-details-tab1-table-title">Телефон (раб)</span></td>'+
										'<td width="70%" colspan="3"><span class="template-details-tab1-table-txt"><span class="txt-parameter">'+d.dognet_blankdocsub.numbertelrab+'</span></span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="30%"><span class="template-details-tab1-table-title">Телефон (моб)</span></td>'+
										'<td width="70%" colspan="3"><span class="template-details-tab1-table-txt"><span class="txt-parameter">'+d.dognet_blankdocsub.numbertelmob+'</span></span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="30%"><span class="template-details-tab1-table-title">Факс</span></td>'+
										'<td width="70%" colspan="3"><span class="template-details-tab1-table-txt"><span class="txt-parameter">'+d.dognet_blankdocsub.numbertelfax+'</span></span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="30%"><span class="template-details-tab1-table-title">Email</span></td>'+
										'<td width="70%" colspan="3"><span class="template-details-tab1-table-txt"><span class="txt-parameter">'+d.dognet_blankdocsub.nameemail+'</span></span></td>'+
									'</tr>'+
								'</tbody>'+
							'</table>'+
						'</div>'+
					'</div>'+

				'</div>'+
				'<div id="blankarchive-main-sub-'+row.id()+'-tab-6" class="tab-pane fade">'+

					'<div class="hidden-xs col-sm-12 col-md-12 col-lg-12">'+
						'<div class="space10"></div>'+
						'<div style="padding:10px">'+
							'<table id="template-details-tab1-table" class="table">'+
								'<tbody>'+
									'<tr class="tr-title">'+
										'<td width="5%"><span class="template-details-tab1-table-title_topic">XI</span></td>'+
										'<td width="95%" colspan="3"><span class="template-details-tab1-table-title_topic">Командировочные расходы</span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="5%"><span class="template-details-tab1-table-title"></span></td>'+
										'<td width="5%"><span class="template-details-tab1-table-title">1)</span></td>'+
										'<td width="60%"><span class="template-details-tab1-table-title">Входят в стоимость договора</span></td>'+
										'<td width="30%"><span class="template-details-tab1-table-txt">'+print_checkBox(d.dognet_blankdocsub.kodusekomrasx1)+'</span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="5%"><span class="template-details-tab1-table-title"></span></td>'+
										'<td width="5%"><span class="template-details-tab1-table-title">2)</span></td>'+
										'<td width="60%"><span class="template-details-tab1-table-title">Оплачиваются отдельно по фактическим затратам</span></td>'+
										'<td width="30%"><span class="template-details-tab1-table-txt">'+print_checkBox(d.dognet_blankdocsub.kodusekomrasx2)+'</span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="5%"><span class="template-details-tab1-table-title"></span></td>'+
										'<td width="5%"><span class="template-details-tab1-table-title">3)</span></td>'+
										'<td width="60%"><span class="template-details-tab1-table-title">Входят в стоимость с установленным лимитом</span><span class="template-details-tab1-table-txt"><span class="txt-parameter">'+d.dognet_blankdocsub.summalimitmis+'</span></span></td>'+
										'<td width="30%"><span class="template-details-tab1-table-txt">'+print_checkBox(d.dognet_blankdocsub.kodusekomrasx3)+'</span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="5%"><span class="template-details-tab1-table-title"></span></td>'+
										'<td width="5%"><span class="template-details-tab1-table-title">4)</span></td>'+
										'<td width="60%"><span class="template-details-tab1-table-title">Примечание</span><span class="template-details-tab1-table-txt"><span class="txt-parameter">'+d.dognet_blankdocsub.komrasxprim+'</span></span></td>'+
										'<td width="30%"><span class="template-details-tab1-table-txt">'+print_checkBox(d.dognet_blankdocsub.kodusekomrasx4)+'</span></td>'+
									'</tr>'+
								'</tbody>'+
							'</table>'+
						'</div>'+
					'</div>'+

				'</div>'+
				'<div id="blankarchive-main-sub-'+row.id()+'-tab-7" class="tab-pane fade">'+

					'<div class="hidden-xs col-sm-12 col-md-6 col-lg-6">'+
						'<div class="space10"></div>'+
						'<div style="padding:10px">'+
							'<table id="template-details-tab1-table" class="table">'+
								'<tbody>'+
									'<tr class="tr-title">'+
										'<td width="10%"><span class="template-details-tab1-table-title_topic">XII</span></td>'+
										'<td width="90%" colspan="3"><span class="template-details-tab1-table-title_topic">Транспортные расходы</span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="5%"><span class="template-details-tab1-table-title"></span></td>'+
										'<td width="5%"><span class="template-details-tab1-table-title">1)</span></td>'+
										'<td width="1%"><span class="template-details-tab1-table-txt">'+print_checkBox(d.dognet_blankdocsub.kodusetrans1)+'</span></td>'+
										'<td width="89%"><span class="template-details-tab1-table-txt">Входят в стоимость</span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="5%"><span class="template-details-tab1-table-title"></span></td>'+
										'<td width="5%"><span class="template-details-tab1-table-title">2)</span></td>'+
										'<td width="1%"><span class="template-details-tab1-table-txt">'+print_checkBox(d.dognet_blankdocsub.kodusetrans2)+'</span></td>'+
										'<td width="89%"><span class="template-details-tab1-table-txt">Оплачиваются отдельно по фактическим затратам</span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="5%"><span class="template-details-tab1-table-title"></span></td>'+
										'<td width="5%"><span class="template-details-tab1-table-title">3)</span></td>'+
										'<td width="1%"><span class="template-details-tab1-table-txt">'+print_checkBox(d.dognet_blankdocsub.kodusetrans3)+'</span></td>'+
										'<td width="89%"><span class="template-details-tab1-table-txt">Иное<span class="txt-parameter">'+d.dognet_blankdocsub.transprim+'</span></span></td>'+
									'</tr>'+
								'</tbody>'+
							'</table>'+
						'</div>'+
					'</div>'+
					'<div class="hidden-xs col-sm-12 col-md-6 col-lg-6">'+
						'<div class="space10"></div>'+
						'<div style="padding:10px">'+
							'<table id="template-details-tab1-table" class="table">'+
								'<tbody>'+
									'<tr class="tr-title">'+
										'<td width="10%"><span class="template-details-tab1-table-title_topic">XIII</span></td>'+
										'<td width="90%" colspan="3"><span class="template-details-tab1-table-title_topic">Условия поставки</span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="5%"><span class="template-details-tab1-table-title"></span></td>'+
										'<td width="95%" colspan="2"><span class="template-details-tab1-table-txt">Куда поставляется оборудование<span class="txt-parameter">'+d.dognet_blankdocsub.transplaceobor+'</span></span></td>'+
									'</tr>'+
								'</tbody>'+
							'</table>'+
						'</div>'+
					'</div>'+

				'</div>'+
				'<div id="blankarchive-main-sub-'+row.id()+'-tab-8" class="tab-pane fade">'+

					'<div class="hidden-xs col-sm-12 col-md-12 col-lg-12">'+
						'<div class="space10"></div>'+
						'<div style="padding:10px">'+
							'<table id="template-details-tab1-table" class="table" >'+
								'<tbody>'+
									'<tr>'+
										'<td width="5%" class="td-title"><span class="template-details-tab1-table-title_topic">XIV</span></td>'+
										'<td width="75%" class="td-title" colspan="2"><span class="template-details-tab1-table-title_topic">Если АТГС является Заказчиком - указать, к какому номеру основного договора/этапа относится данный договор</span></td>'+
										'<td width="20%"><span class="template-details-tab1-table-txt"><span class="txt-parameter">'+d.dognet_blankdocsub.numberdocmain+'</span></span></td>'+
									'</tr>'+
								'</tbody>'+
							'</table>'+
						'</div>'+
						'<div class="space10"></div>'+
						'<div style="padding:10px">'+
							'<table id="template-details-tab1-table" class="table" >'+
								'<tbody>'+
									'<tr>'+
										'<td width="5%" class="td-title"><span class="template-details-tab1-table-title_topic">XV</span></td>'+
										'<td width="75%" class="td-title" colspan="2"><span class="template-details-tab1-table-title_topic">Ограничение по сроку оформления</span></td>'+
										'<td width="20%"><span class="template-details-tab1-table-txt"><span class="txt-parameter">'+d.dognet_blankdocsub.climitdays+'</span>дней</span></td>'+
									'</tr>'+
								'</tbody>'+
							'</table>'+
						'</div>'+
					'</div>'+

				'</div>'+
				'<div id="blankarchive-main-sub-'+row.id()+'-tab-9" class="tab-pane fade">'+

					'<div class="hidden-xs col-sm-12 col-md-12 col-lg-12">'+
						'<div class="space10"></div>'+
						'<div style="padding:10px">'+
							'<table id="template-details-tab1-table" class="table">'+
								'<tbody>'+
									'<tr class="tr-title">'+
										'<td width="5%"><span class="template-details-tab1-table-title_topic">XVI</span></td>'+
										'<td width="95%" colspan="3"><span class="template-details-tab1-table-title_topic">Результаты оценки рисков/производственной осуществимости</span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="5%"><span class="template-details-tab1-table-title"></span></td>'+
										'<td width="5%"><span class="template-details-tab1-table-title">1)</span></td>'+
										'<td width="1%"><span class="template-details-tab1-table-txt">'+print_checkBox(d.dognet_blankdocsub.koduserisk1)+'</span></td>'+
										'<td width="89%"><span class="template-details-tab1-table-txt">Соблюдение сроков выполнения монтажных работ</span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="5%"><span class="template-details-tab1-table-title"></span></td>'+
										'<td width="5%"><span class="template-details-tab1-table-title">2)</span></td>'+
										'<td width="1%"><span class="template-details-tab1-table-txt">'+print_checkBox(d.dognet_blankdocsub.koduserisk2)+'</span></td>'+
										'<td width="89%"><span class="template-details-tab1-table-txt">Соблюдение сроков выполнения пуско-наладочных работ</span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="5%"><span class="template-details-tab1-table-title"></span></td>'+
										'<td width="5%"><span class="template-details-tab1-table-title">3)</span></td>'+
										'<td width="1%"><span class="template-details-tab1-table-txt">'+print_checkBox(d.dognet_blankdocsub.koduserisk3)+'</span></td>'+
										'<td width="89%"><span class="template-details-tab1-table-txt">Соблюдение сроков оплаты</span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="5%"><span class="template-details-tab1-table-title"></span></td>'+
										'<td width="5%"><span class="template-details-tab1-table-title">4)</span></td>'+
										'<td width="1%"><span class="template-details-tab1-table-txt">'+print_checkBox(d.dognet_blankdocsub.koduserisk4)+'</span></td>'+
										'<td width="89%"><span class="template-details-tab1-table-txt">Обеспечение ресурсами</span></td>'+
									'</tr>'+
									'<tr>'+
										'<td width="5%"><span class="template-details-tab1-table-title"></span></td>'+
										'<td width="5%"><span class="template-details-tab1-table-title">5)</span></td>'+
										'<td width="1%"><span class="template-details-tab1-table-txt">'+print_checkBox(d.dognet_blankdocsub.koduserisk5)+'</span></td>'+
										'<td width="89%"><span class="template-details-tab1-table-txt">Иное<span class="txt-parameter">'+d.dognet_blankdocsub.riskprim+'</span></span></td>'+
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
