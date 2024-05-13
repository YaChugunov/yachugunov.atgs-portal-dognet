<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/date-de.js"></script>
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/moment-with-locales.js"></script>

<!-- Custom Table style -->
<link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/css/docview-table-current-tab1-custom.css">
<!-- Custom Form Editor style -->
<link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/css/docview-customForm-current-tab1-Editor.css">


<style>
	.panel-title {
		/* font-family: 'BebasNeueRegular', sans-serif; */
		padding-top: 5px;
		text-transform: none;
		margin-top: 0;
		margin-bottom: 0;
		font-size: 1.5em;
		color: inherit;
		font-weight: 400;
	}
</style>


<script type="text/javascript" language="javascript" class="init">
	var editor_tab1; // use a global for the submit and return data rendering in the examples
	var table_tab1; // use a global for the submit and return data rendering in the examples

	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	//
	//
	function format(d) {

		return '<div class="space20"></div>' +
			'<div id="row-details">' +
			'<div class="panel-group">' +
			'<div class="panel panel-default">' +
			'<div class="panel-heading">' +
			'<h4 class="panel-title">' +
			'<a data-toggle="collapse" href="#collapse1">Основные показатели</a>' +
			'</h4>' +
			'</div>' +
			'<div id="collapse1" class="panel-collapse collapse">' +
			'<ul class="list-group">' +

			'<li class="list-group-item">' +
			'<h5 class=space20>Общая информация</h5>' +
			'<table id="row-details-table1" class="table table-condensed table-striped" >' +
			'<tbody>' +
			'<tr>' +
			'<td width="30%" class="text-uppercase" style="border-top:none; font-size:2.0em">№ :</td>' +
			'<td class="" style="border-top:none"><span class="" style="font-size:2.0em; font-weight:500">3-4/' + d.dognet_docbase.docnumber + '</span></td>' +
			'</tr>' +
			'<tr>' +
			'<td width="30%" class="text-uppercase" style="border-top:none">Обоснование ввода :</td>' +
			'<td class="" style="border-top:none"><span class="" style="font-weight:500">{ --- ??? --- }</span></td>' +
			'</tr>' +
			'<tr>' +
			'<td width="30%" class="text-uppercase" style="border-top:none">Дата начала :</td>' +
			'<td class="" style="border-top:none"><span class="">' + d.dognet_docbase.daynachdoc + '.' + d.dognet_docbase.monthnachdoc + '.' + d.dognet_docbase.yearnachdoc + '</span></td>' +
			'</tr>' +
			'<tr>' +
			'<td width="30%" class="text-uppercase" style="border-top:none">Дата окончания (план) :</td>' +
			'<td class="" style="border-top:none"><span class="">' + d.dognet_docbase.dayenddoc + '.' + d.dognet_docbase.monthenddoc + '.' + d.dognet_docbase.yearenddoc + '</span></td>' +
			'</tr>' +
			'<tr>' +
			'<td width="30%" class="text-uppercase" style="border-top:none">Наименование краткое :</td>' +
			'<td class="" style="border-top:none"><span class="" style="font-weight:500">' + d.dognet_docbase.docnameshot + '</span></td>' +
			'</tr>' +
			'<tr>' +
			'<td width="30%" class="text-uppercase" style="border-top:none">Наименование полное :</td>' +
			'<td class="" style="border-top:none"><span class="" style="font-weight:500">' + d.dognet_docbase.docnamefulm + '</span></td>' +
			'</tr>' +
			'<tr>' +
			'<td width="30%" class="text-uppercase" style="border-top:none">Тип :</td>' +
			'<td class="" style="border-top:none"><span class="" style="font-weight:500">' + d.dognet_sptipdog.nametip + '</span></td>' +
			'</tr>' +
			'<tr>' +
			'<td width="30%" class="text-uppercase" style="border-top:none">Статус :</td>' +
			'<td class="" style="border-top:none"><span class="" style="font-weight:500">' + d.dognet_spstatus.statusnameshot + '</span></td>' +
			'</tr>' +
			'</tbody>' +
			'</table>' +
			'</li>' +

			'<li class="list-group-item">Заказчик</li>' +
			'<li class="list-group-item">Контакты</li>' +
			'<li class="list-group-item">Исполнители</li>' +
			'<li class="list-group-item">Финансы</li>' +
			'</ul>' +
			'<div class="panel-footer">Основные показатели</div>' +
			'</div>' +
			'</div>' +
			'<div class="panel panel-default">' +
			'<div class="panel-heading">' +
			'<h4 class="panel-title">' +
			'<a data-toggle="collapse" href="#collapse2">Выполнение и оплата</a>' +
			'</h4>' +
			'</div>' +
			'<div id="collapse2" class="panel-collapse collapse">' +
			'<ul class="list-group">' +
			'<li class="list-group-item">One</li>' +
			'<li class="list-group-item">Two</li>' +
			'<li class="list-group-item">Three</li>' +
			'</ul>' +
			'<div class="panel-footer">Выполнение и оплата</div>' +
			'</div>' +
			'</div>' +
			'<div class="panel panel-default">' +
			'<div class="panel-heading">' +
			'<h4 class="panel-title">' +
			'<a data-toggle="collapse" href="#collapse2">Затраты по договору</a>' +
			'</h4>' +
			'</div>' +
			'<div id="collapse2" class="panel-collapse collapse">' +
			'<ul class="list-group">' +
			'<li class="list-group-item">One</li>' +
			'<li class="list-group-item">Two</li>' +
			'<li class="list-group-item">Three</li>' +
			'</ul>' +
			'<div class="panel-footer">Затраты по договору</div>' +
			'</div>' +
			'</div>' +
			'<div class="panel panel-default">' +
			'<div class="panel-heading">' +
			'<h4 class="panel-title">' +
			'<a data-toggle="collapse" href="#collapse2">Первичные документы</a>' +
			'</h4>' +
			'</div>' +
			'<div id="collapse2" class="panel-collapse collapse">' +
			'<ul class="list-group">' +
			'<li class="list-group-item">One</li>' +
			'<li class="list-group-item">Two</li>' +
			'<li class="list-group-item">Three</li>' +
			'</ul>' +
			'<div class="panel-footer">Первичные документы</div>' +
			'</div>' +
			'</div>' +
			'</div>' +


			'<div class="row space20">' +
			'<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">' +
			'<div id="row-details-docnamefull" class="media">' +
			'<div class="media-left media-middle text-nowrap">' +
			'</div>' +
			'<div class="media-body media-middle">' +
			'<h4 class="details-docnamefull">' + d.dognet_docbase.docnamefullm + '</h4>' +
			'</div>' +
			'</div>' +
			'</div>' +
			'</div>' +
			/*
				'<div class="row space20">'+
					'<div class="col-xs-12 col-sm-8 col-md-9 col-lg-9">'+
						'<div class="media">'+
							'<div class="media-left media-middle text-nowrap">'+
								'<span class="details-docID" style="font-size:3.0em">3-4/'+d.dognet_docbase.docnumber+'</span>'+
							'</div>'+
							'<div class="media-body media-middle">'+
								'<h3 class="details-docAbout">'+d.dognet_docbase.docnamefullm+'</h3>'+
							'</div>'+
						'</div>'+
					'</div>'+
					'<div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">'+
						
					'</div>'+
				'</div>'+
			*/
			'<div class="row space20">' +
			'<div class="hidden-xs col-sm-5 col-md-5 col-lg-5">' +
			'<div class="media">' +
			'<div class="media-left media-middle">' +
			'<span class="" style="font-size:2.5em"><span class="glyphicon glyphicon-list-alt"></span></span>' +
			'</div>' +
			'<div class="media-body media-middle">' +
			'<h4>Общая информация</h4>' +
			'</div>' +
			'</div>' +
			'<table id="row-details-table1" class="table table-condensed table-striped" >' +
			'<tbody>' +
			'<tr>' +
			'<td width="30%" class="text-uppercase" style="border-top:none; font-size:2.0em">№ :</td>' +
			'<td class="" style="border-top:none"><span class="" style="font-size:2.0em; font-weight:500">3-4/' + d.dognet_docbase.docnumber + '</span></td>' +
			'</tr>' +
			'<tr>' +
			'<td width="30%" class="text-uppercase" style="border-top:none">Название :</td>' +
			'<td class="" style="border-top:none"><span class="" style="font-weight:500">' + d.dognet_docbase.docnameshot + '</span></td>' +
			'</tr>' +
			'<tr>' +
			'<td width="30%" class="text-uppercase" style="border-top:none">Тип :</td>' +
			'<td class="" style="border-top:none"><span class="" style="font-weight:500">' + d.dognet_sptipdog.nametip + '</span></td>' +
			'</tr>' +
			'<tr>' +
			'<td width="30%" class="text-uppercase" style="border-top:none">Статус :</td>' +
			'<td class="" style="border-top:none"><span class="" style="font-weight:500">' + d.dognet_spstatus.statusnameshot + '</span></td>' +
			'</tr>' +
			'</tbody>' +
			'</table>' +
			'<div class="media">' +
			'<div class="media-left media-middle">' +
			'<span class="" style="font-size:2.5em"><span class="glyphicon glyphicon-home"></span></span>' +
			'</div>' +
			'<div class="media-body media-middle">' +
			'<h4>Объект и заказчик</h4>' +
			'</div>' +
			'</div>' +
			'<table id="row-details-table1" class="table table-condensed table-striped" >' +
			'<tbody>' +
			'<tr>' +
			'<td width="30%" class="text-uppercase" style="border-top:none">Объект :</td>' +
			'<td class="text-capitalize" style="border-top:none"><span class="" style="font-weight:500">' + d.sp_objects.nameobjectshot + '</span></td>' +
			'</tr>' +
			'<tr>' +
			'<td width="30%" class="text-uppercase" style="border-top:none">Заказчик :</td>' +
			'<td class="" style="border-top:none"><span class="" style="font-weight:500">' + d.sp_contragents.nameshort + '</span></td>' +
			'</tr>' +
			'</tbody>' +
			'</table>' +
			'<div class="media">' +
			'<div class="media-left media-middle">' +
			'<span class="" style="font-size:2.5em"><span class="glyphicon glyphicon-calendar"></span></span>' +
			'</div>' +
			'<div class="media-body media-middle">' +
			'<h4>Тайминг</h4>' +
			'</div>' +
			'</div>' +
			'<table id="row-details-table-dates" class="table table-condensed table-striped" >' +
			'<tbody>' +
			'<tr>' +
			'<td width="30%" class="text-uppercase" style="border-top:none">Дата начала :</td>' +
			'<td class="" style="border-top:none"><span class="">' + d.dognet_docbase.daynachdoc + '.' + d.dognet_docbase.monthnachdoc + '.' + d.dognet_docbase.yearnachdoc + '</span></td>' +
			'</tr>' +
			'<tr>' +
			'<td width="30%" class="text-uppercase" style="border-top:none">Дата окончания :</td>' +
			'<td class="" style="border-top:none"><span class="">' + d.dognet_docbase.dayenddoc + '.' + d.dognet_docbase.monthenddoc + '.' + d.dognet_docbase.yearenddoc + '</span></td>' +
			'</tr>' +
			'</tbody>' +
			'</table>' +
			'</div>' +
			'<div class="hidden-xs col-sm-7 col-md-7 col-lg-7">' +
			'<div class="media">' +
			'<div class="media-left media-middle">' +
			'<span class="" style="font-size:2.5em"><span class="glyphicon glyphicon-ruble"></span></span>' +
			'</div>' +
			'<div class="media-body media-middle">' +
			'<h4>Финансы</h4>' +
			'</div>' +
			'</div>' +
			'<div class="hidden-xs col-sm-6 col-md-6 col-lg-6" style="padding-left:0">' +
			'<table id="row-details-table-finance" class="table table-condensed table-striped" >' +
			'<tbody>' +
			'<tr>' +
			'<td width="55%" class="text-uppercase" style="border-top:none">Сумма :</td>' +
			'<td class="" style="border-top:none"><span class="">' + $.fn.dataTable.render.number(' ', ',', 2, '').display(d.dognet_docbase.docsumma) + '</span></td>' +
			'</tr>' +
			'<tr>' +
			'<td width="55%" class="text-uppercase" style="border-top:none">Сумма С/Ф :</td>' +
			'<td class="" style="border-top:none"><span class="">' + $.fn.dataTable.render.number(' ', ',', 2, '').display(d.dognet_docbase.summachf) + '</span></td>' +
			'</tr>' +
			'<tr>' +
			'<td width="55%" class="text-uppercase" style="border-top:none">Оплата :</td>' +
			'<td class="" style="border-top:none"><span class="">' + $.fn.dataTable.render.number(' ', ',', 2, '').display(d.dognet_docbase.docoplata) + '</span></td>' +
			'</tr>' +
			'<tr>' +
			'<td width="55%" class="text-uppercase" style="border-top:none">Аванс :</td>' +
			'<td class="" style="border-top:none"><span class="">' + $.fn.dataTable.render.number(' ', ',', 2, '').display(d.dognet_docbase.docavans) + '</span></td>' +
			'</tr>' +
			'<tr>' +
			'<td width="55%" class="text-uppercase" style="border-top:none">Задолженность :</td>' +
			'<td class="" style="border-top:none"><span class="">' + $.fn.dataTable.render.number(' ', ',', 2, '').display(d.dognet_docbase.doczadol) + '</span></td>' +
			'</tr>' +
			'<tr>' +
			'<td width="55%" class="text-uppercase" style="border-top:none">Незакрыто :</td>' +
			'<td class="" style="border-top:none"><span class="">' + $.fn.dataTable.render.number(' ', ',', 2, '').display(d.dognet_docbase.docnozak) + '</span></td>' +
			'</tr>' +
			'</tbody>' +
			'</table>' +
			'</div>' +
			'<div class="hidden-xs col-sm-6 col-md-6 col-lg-6" style="padding-right:0">' +
			'<table id="row-details-table-finance" class="table table-condensed table-striped" >' +
			'<tbody>' +
			'<tr>' +
			'<td width="55%" class="text-uppercase" style="border-top:none">Сумма :</td>' +
			'<td class="" style="border-top:none"><span class="">' + $.fn.dataTable.render.number(' ', ',', 2, '').display(d.dognet_docbase.docsumma) + '</span></td>' +
			'</tr>' +
			'<tr>' +
			'<td width="55%" class="text-uppercase" style="border-top:none">Сумма С/Ф :</td>' +
			'<td class="" style="border-top:none"><span class="">' + $.fn.dataTable.render.number(' ', ',', 2, '').display(d.dognet_docbase.summachf) + '</span></td>' +
			'</tr>' +
			'<tr>' +
			'<td width="55%" class="text-uppercase" style="border-top:none">Оплата :</td>' +
			'<td class="" style="border-top:none"><span class="">' + $.fn.dataTable.render.number(' ', ',', 2, '').display(d.dognet_docbase.docoplata) + '</span></td>' +
			'</tr>' +
			'<tr>' +
			'<td width="55%" class="text-uppercase" style="border-top:none">Аванс :</td>' +
			'<td class="" style="border-top:none"><span class="">' + $.fn.dataTable.render.number(' ', ',', 2, '').display(d.dognet_docbase.docavans) + '</span></td>' +
			'</tr>' +
			'<tr>' +
			'<td width="55%" class="text-uppercase" style="border-top:none">Задолженность :</td>' +
			'<td class="" style="border-top:none"><span class="">' + $.fn.dataTable.render.number(' ', ',', 2, '').display(d.dognet_docbase.doczadol) + '</span></td>' +
			'</tr>' +
			'<tr>' +
			'<td width="55%" class="text-uppercase" style="border-top:none">Незакрыто :</td>' +
			'<td class="" style="border-top:none"><span class="">' + $.fn.dataTable.render.number(' ', ',', 2, '').display(d.dognet_docbase.docnozak) + '</span></td>' +
			'</tr>' +
			'</tbody>' +
			'</table>' +
			'</div>' +
			'</div>' +
			'<div class="hidden-xs col-sm-12 col-md-7 col-lg-7">' +
			'<div class="media">' +
			'<div class="media-left media-middle">' +
			'<span class="" style="font-size:2.5em"><span class="glyphicon glyphicon-user"></span></span>' +
			'</div>' +
			'<div class="media-body media-middle">' +
			'<h4>Исполнители</h4>' +
			'</div>' +
			'</div>' +
			'<table id="row-details-table2" class="table table-condensed table-striped" >' +
			'<tbody>' +
			'<tr>' +
			'<td width="35%" class="text-uppercase" style="border-top:none">Исполнитель (руководство) :</td>' +
			'<td class="" style="border-top:none"><span class="">' + d.dognet_spispolruk.ispolruknamefull + '</span></td>' +
			'<td class="" style="border-top:none"><span class="">' + d.dognet_spispolruk.ispolrukemail + '</span></td>' +
			'</tr>' +
			'<tr>' +
			'<td width="35%" class="text-uppercase" style="border-top:none">Исполнитель :</td>' +
			'<td class="" style="border-top:none"><span class="">' + d.dognet_spispol.ispolnamefull + '</span></td>' +
			'<td class="" style="border-top:none"><span class="">' + d.dognet_spispol.ispolmail + '</span></td>' +
			'</tr>' +
			'</tbody>' +
			'</table>' +
			'</div>' +
			'<div class="hidden-xs col-sm-12 col-md-12 col-lg-12">' +
			'<div class="media">' +
			'<div class="media-left media-middle">' +
			'<span class="" style="font-size:2.5em"><span class="glyphicon glyphicon-comment"></span></span>' +
			'</div>' +
			'<div class="media-body media-middle">' +
			'<h4>Комментарии</h4>' +
			'</div>' +
			'</div>' +
			'<table id="row-details-table2" class="table table-condensed table-striped" >' +
			'<tbody>' +
			'<tr>' +
			'<td width="35%" class="text-uppercase" style="border-top:none">Последний комментарий :</td>' +
			'<td class="" style="border-top:none"><span class="">' + d.dognet_spispolruk.ispolruknamefull + '</span></td>' +
			'</tr>' +
			'</tbody>' +
			'</table>' +
			'</div>' +
			'</div>' +
			'</div>' +
			'<div class="space20"></div>';
	}

	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

	$(document).ready(function() {
		table_tab1 = $('#docview-current-tab1').DataTable({
			dom: "<'row space20'<'col-md-8 col-sm-12'><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'ltip>>",
			// 		dom: "<'space50'r>lftip",
			language: {
				url: "russian.json"
			},
			ajax: {
				url: "php/examples/php/docview/docview-current/dognet-docview-current-tab1-process.php",
				type: "POST"
			},
			serverSide: true,
			columns: [{
					class: "details-control",
					data: null,
					defaultContent: "<span class='glyphicon glyphicon-option-vertical'></span>",
					className: "center"
				},
				{
					data: "dognet_docbase.yearnachdoc",
					className: "text-center"
				},
				{
					data: "dognet_docbase.docnumber",
					className: "text-center"
				},
				{
					data: "dognet_docbase.docnameshot"
				},
				{
					data: "sp_objects.nameobjectshot"
				}
			],
			select: {
				style: 'os',
				selector: 'td:not(:last-child)' // no row selection on last column
			},
			columnDefs: [{
					orderable: false,
					searchable: false,
					targets: 0
				},
				{
					orderable: false,
					searchable: true,
					targets: 1
				},
				{
					orderable: false,
					searchable: true,
					targets: 2
				},
				{
					orderable: false,
					searchable: true,
					targets: 3
				},
				{
					orderable: false,
					searchable: true,
					targets: 4
				}
			],

			order: [
				[1, "desc"],
				[2, "desc"]
			],
			select: false,
			processing: true,
			paging: true,
			searching: true,
			pageLength: 15,
			lengthChange: false,
			lengthMenu: [
				[15, 30, 50, -1],
				[15, 30, 50, "Все"]
			]

		});

		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
		// Array to track the ids of the details displayed rows
		var detailRows = [];

		$('#docview-current-tab1 tbody').on('click', 'tr td.details-control', function() {
			var tr = $(this).closest('tr');
			var row = table_tab1.row(tr);
			var idx = $.inArray(tr.attr('id'), detailRows);

			if (row.child.isShown()) {
				tr.removeClass('details');
				row.child.hide();

				// Remove from the 'open' array
				detailRows.splice(idx, 1);
			} else {
				tr.addClass('details');
				row.child(format(row.data())).show();

				// Add to the 'open' array
				if (idx === -1) {
					detailRows.push(tr.attr('id'));
				}
			}
		});
		// On each draw, loop over the `detailRows` array and show any child rows
		table_tab1.on('draw', function() {
			$.each(detailRows, function(i, id) {
				$('#' + id + ' td.details-control').trigger('click');
			});
		});

	});
</script>

<div class="container">
	<section>
		<div class="demo-html"></div>
		<table id="docview-current-tab1" class="table table-bordered table-condensed" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th width="2%" class="text-center"></th>
					<th width="7%" class="text-center">Год</th>
					<th width="7%" class="text-center">№</th>
					<th>Краткое название</th>
					<th>Объект</th>
				</tr>
			</thead>
		</table>
	</section>
</div>