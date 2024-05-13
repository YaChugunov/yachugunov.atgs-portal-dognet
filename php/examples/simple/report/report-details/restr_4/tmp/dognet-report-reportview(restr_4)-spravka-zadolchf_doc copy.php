<?php
date_default_timezone_set('Europe/Moscow');

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$__title = 'Договор';
$__subtitle = "Отчетные формы";
$__subsubtitle = "Задолженность по счетам-фактурам";


#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
# Функция обновления полей основной таблицы (dognet_kalplanchf) 
# 
#
$_QRY0 = mysqlQuery("TRUNCATE TABLE dognet_reports_zadolchf");
$_QRY = mysqlQuery("SELECT * FROM dognet_kalplanchf WHERE koddel <> '99'");
$chf_koddoc = '';
$_ENBL = FALSE;
while ($_ROW = mysqli_fetch_assoc($_QRY)) {

	$chf_sumAvChf = SUMMA_AVANSCHF($_ROW['kodchfact']);
	$chf_sumOpChf = SUMMA_OPLATCHF($_ROW['kodchfact']);
	$chf_summazadol = $_ROW['chetfsumma'] - ($chf_sumOpChf + $chf_sumAvChf);
	if (round($chf_summazadol) > 0 or round($chf_summazadol) < 0) {

		// Определяем ID договора (koddoc) для договора с календарным планом
		$_QRY_koddoc1 = mysqlQuery("SELECT koddoc FROM dognet_dockalplan WHERE kodkalplan=" . $_ROW['kodkalplan'] . " AND koddel <> '99'");
		$_NUM1 = mysqli_num_rows($_QRY_koddoc1);
		$_ROW_koddoc1 = mysqli_fetch_assoc($_QRY_koddoc1);
		if ($_NUM1 > 0) {
			$chf_koddoc = $_ROW_koddoc1['koddoc'];
		}
		// Определяем ID договора (koddoc) для договора без календарного плана
		else {
			$_QRY_koddoc2 = mysqlQuery("SELECT koddoc FROM dognet_docbase WHERE koddoc=" . $_ROW['kodkalplan']);
			$_ROW_koddoc2 = mysqli_fetch_assoc($_QRY_koddoc2);
			$chf_koddoc = $_ROW_koddoc2['koddoc'];
		}
		// ----- ----- ----- ----- ----- 
		$chf_kodkalplan = $_ROW['kodkalplan'];
		$chf_kodchfact = $_ROW['kodchfact'];
		$chf_kodusechf = $_ROW['kodusechf'];
		$chf_koddel = $_ROW['koddel'];
		$chf_chetfnumber = $_ROW['chetfnumber'];
		$chf_chetfdate = $_ROW['chetfdate'];
		$chf_chetfsumma = $_ROW['chetfsumma'];
		$chf_summazadol = $chf_chetfsumma - ($chf_sumAvChf + $chf_sumOpChf);
		$chf_comment = "";
		// ----- ----- ----- ----- ----- 
		// 			$_QRY_INSERT = mysqlQuery( " INSERT INTO dognet_reports_zadolchf (koddoc, kodkalplan, kodchfact, chetfnumber, chetfdate, chetfsumma, summaoplav, summaopl, summazadol, comment) VALUES ($chf_koddoc, $chf_kodkalplan, $chf_kodchfact, $chf_chetfnumber, $chf_chetfdate, $chf_chetfsumma, $chf_sumAvChf, $chf_sumOpChf, $chf_summazadol, $chf_comment) " );
		$_QRY_INSERT = mysqlQuery(" INSERT INTO dognet_reports_zadolchf (koddoc, kodkalplan, kodchfact, kodusechf, koddel, chetfnumber, chetfdate, chetfsumma, summaoplav, summaopl, summazadol, comment) VALUES ('$chf_koddoc', '$chf_kodkalplan', '$chf_kodchfact', '$chf_kodusechf', '$chf_koddel', '$chf_chetfnumber', '$chf_chetfdate', '$chf_chetfsumma', '$chf_sumAvChf', '$chf_sumOpChf', '$chf_summazadol', '$chf_comment') ");
	}
}


?>

<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/moment-with-locales.js"></script>

<div class="container">
	<div class="row" style="margin-top:20px">
		<?php include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/dognet-topblock.php") ?>
	</div>


	<script type="text/javascript" language="javascript" class="init">
		var table_reportview_filterdocs; // use a global for the submit and return data rendering in the examples

		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

		$(document).ready(function() {

			table_reportview_filterdocs = $('#reportview-filterdocs').DataTable({
				dom: "<'row'<'col-sm-5'B><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'p>>",
				// 		dom: "<'space50'r>tip",
				language: {
					url: "russian.json"
				},
				ajax: {
					url: "php/examples/php/report/report-details/reports/dognet-report-reportview(restr_4)-spravka-zadolchf-process.php",
					type: "POST"
				},
				serverSide: true,
				columns: [{
						searchable: false,
						orderable: false,
						data: null
					},
					{
						searchable: false,
						orderable: false,
						data: null
					},
					{
						searchable: false,
						orderable: false,
						data: null
					},
					{
						data: "sp_contragents.nameshort",
						className: "text-left"
					},
					{
						data: "dognet_docbase.docnameshot",
						className: "text-left"
					},
					{
						data: "dognet_dockalplan.numberstage",
						className: "text-left"
					},
					{
						orderable: false,
						data: "dognet_reports_zadolchf.chetfnumber",
						className: "text-left"
					},
					{
						orderable: false,
						data: "dognet_reports_zadolchf.chetfdate",
						className: "text-left"
					},
					{
						orderable: false,
						data: "dognet_reports_zadolchf.chetfsumma",
						className: "text-left"
					},
					{
						orderable: false,
						data: "dognet_reports_zadolchf.summaoplav",
						className: "text-left"
					},
					{
						orderable: false,
						data: "dognet_reports_zadolchf.summaopl",
						className: "text-left"
					},
					{
						orderable: false,
						data: "dognet_reports_zadolchf.summazadol",
						className: "text-left"
					},
					{
						data: "dognet_spdened.short_code"
					}
				],
				select: {
					style: 'os',
					selector: 'td:not(:last-child)' // no row selection on last column
				},
				columnDefs: [{
						searchable: false,
						targets: 0,
						render: function(data) {
							return '';
						}
					},
					{
						searchable: false,
						targets: 1,
						render: function(data) {
							return '';
						}
					},
					{
						searchable: false,
						targets: 2,
						render: function(data) {
							return '';
						}
					},
					{
						visible: false,
						targets: 3
					},
					{
						visible: false,
						targets: 4
					},
					{
						render: function(data) {
							if (data) {
								return 'Этап ' + data;
							} else {
								return 'Без этапа';
							}
						},
						targets: 5
					},
					{
						searchable: true,
						targets: 6
					},
					{
						searchable: true,
						targets: 7
					},
					{
						searchable: false,
						render: function(data, type, row, meta) {
							if (data != null) {
								return $.fn.dataTable.render.number(' ', ',', 2, '').display(data) + row.dognet_spdened.short_code;
							} else {
								return "0.00" + row.dognet_spdened.short_code;
							}
						},
						targets: 8
					},
					{
						searchable: false,
						render: function(data, type, row, meta) {
							if (data != null) {
								return $.fn.dataTable.render.number(' ', ',', 2, '').display(data) + row.dognet_spdened.short_code;
							} else {
								return "0.00" + row.dognet_spdened.short_code;
							}
						},
						targets: 9
					},
					{
						searchable: false,
						render: function(data, type, row, meta) {
							if (data != null) {
								return $.fn.dataTable.render.number(' ', ',', 2, '').display(data) + row.dognet_spdened.short_code;
							} else {
								return "0.00" + row.dognet_spdened.short_code;
							}
						},
						targets: 10
					},
					{
						searchable: false,
						render: function(data, type, row, meta) {
							if (data != null) {
								return $.fn.dataTable.render.number(' ', ',', 2, '').display(data) + row.dognet_spdened.short_code;
							} else {
								return "0.00" + row.dognet_spdened.short_code;
							}
						},
						targets: 11
					},
					{
						visible: false,
						targets: 12
					},
				],

				order: [
					[3, "asc"],
					[4, "asc"],
					[5, "asc"],
					[6, "asc"]
				],
				rowGroup: {
					startRender: function(rows, group, level) {

						if (level == 0) {
							return '<span style="text-align:left; white-space:nowrap; padding-right:20px">' + group + '</span><span style="float:right"></span>';
						}
						var docnumber = rows.data().pluck("dognet_docbase").pluck("docnumber")[0];
						if (level == 1) {
							return '<span style="text-align:left; white-space:nowrap; padding-right:20px">Договор 3-4/' + docnumber + '&nbsp;-&nbsp;' + group + '</span><span style="float:right"></span>';
						}

					},
					endRender: function(rows, group, level) {

						var kodened = rows.data().pluck("dognet_spdened").pluck("short_code")[0];
						var docnumber = rows.data().pluck("dognet_docbase").pluck("docnumber")[0];
						var avg = rows
							.data()
							.pluck("dognet_reports_zadolchf")
							.pluck("summazadol")
							.reduce(function(a, b) {
								return a + b * 1;
							}, 0);
						var dataSrcArray = table_reportview_filterdocs.rowGroup().dataSrc();

						if (level == 0) {
							return '<span style="float:right"><span style="text-align:left; padding-right:20px">Итого по заказчику&nbsp;:</span><span style="">' + $.fn.dataTable.render.number(' ', ',', 2, '').display(avg) + '' + kodened + '</span></span>';
						}
						if (level == 1) {
							return '<span style="float:right"><span style="text-align:left; padding-right:20px">Итого по договору&nbsp;:</span><span style="">' + $.fn.dataTable.render.number(' ', ',', 2, '').display(avg) + '' + kodened + '</span></span>';
						}
					},
					dataSrc: ["sp_contragents.nameshort", "dognet_docbase.docnameshot"]
				},

				select: false,
				ordering: true,
				processing: true,
				paging: true,
				searching: true,
				pageLength: 15,
				lengthChange: false,
				lengthMenu: [
					[15, 30, 50, -1],
					[15, 30, 50, "Все"]
				],
				buttons: [{
					text: '<span class="glyphicon glyphicon-refresh"></span>',
					action: function(e, dt, node, config) {
						table_reportview_filterdocs.columns().search('');
						table_reportview_filterdocs.order([3, "asc"], [4, "asc"], [6, "asc"]).draw();
					}
				}],

				/*
						drawCallback: 
							function ( settings ) {
								var api = this.api(), data;

								var rows = api.rows( {page:'current'} ).nodes();
								var last = null;
								api.column(3, {page:'current'} ).data().each( function ( group, i ) {
									if ( last !== group ) { 
										$(rows).eq( i ).before(
											'<tr class="group"><td colspan="12" style="text-align:left; white-space:nowrap">'+api.row(i).data().sp_contragents.nameshort+'</td></tr>'
										);
										last = group;
									}
								} );

								var rows1 = api.rows( {page:'current'} ).nodes();
								var last1 = null;
								api.column(4, {page:'current'} ).data().each( function ( group1, i ) { 
									if ( last1 !== group1 ) { 
										$(rows1).eq( i ).before(
											'<tr class="group1"><td></td><td colspan="12" style="text-align:left; white-space:nowrap">Договор №3-4/'+api.row(i).data().dognet_docbase.docnumber+'&nbsp;-&nbsp;'+api.row(i).data().dognet_docbase.docnameshot+'</td></tr>'
										);
										last1 = group1;
									}
								} );

								var rows2 = api.rows( {page:'current'} ).nodes();
								var last2 = null;
								api.column(5, {page:'current'} ).data().each( function ( group2, i ) { 
									if ( last2 !== group2 ) { 
										var numstage = api.row(i).data().dognet_dockalplan.numberstage;
										var namestage = api.row(i).data().dognet_dockalplan.nameshotstage;
										if (numstage !== null) {
											$(rows2).eq( i ).before(
												'<tr class="group2"><td></td><td></td><td colspan="11" style="text-align:left">Этап&nbsp;'+numstage+'&nbsp;-&nbsp;'+namestage+'</td></tr>'
											);
										}
										else {
											$(rows).eq( i ).before(
												'<tr class="group2"><td></td><td></td><td colspan="11" style="text-align:left">Без этапа</td></tr>'
											);
										}
										last2 = group2;
									}
								} );

							}
				*/



				/*
				        drawCallback: function ( settings ) {
				            var api = this.api();
				            var rows = api.rows( {page:'current'} ).nodes();
				            var last = null;
				            var subTotal = new Array();
				            var groupID = -1;
				            var aData = new Array();
				            var index = 0;
				            
				            api.column(3, {page:'current'} ).data().each( function ( group, i ) {
				//               console.log(group+">>>"+i);
				              var vals = api.row(api.row($(rows).eq(i)).index()).data();
				              var salary = vals[12] ? parseFloat(vals[12]) : 0;
				              if (typeof aData[group] == 'undefined') {
				                 aData[group] = new Array();
				                 aData[group].rows = [];
				                 aData[group].salary = [];
				              }
				           		aData[group].rows.push(i); 
				        			aData[group].salary.push(salary); 
				            } );
				// ----- --- ----- --- ----- 
				            var idx= 0;
				          	for(var office in aData){
													idx =  Math.max.apply(Math,aData[office].rows);
				                  var sum = 0; 
				                  $.each(aData[office].salary,function(k,v){
				                        sum = sum + v;
				                  });
				  									console.log(aData[office].salary);
				                  $(rows).eq( idx ).before(
				                        '<tr class="group">'+
				                        '<td colspan="12" style="text-align:left; white-space:nowrap">'+api.row(idx).data().sp_contragents.nameshort+'</td>'+
				                        '</tr>'
				                    );
				                  $(rows).eq( idx ).after(
				                        '<tr class="group">'+
				                        '<td colspan="4" style="text-align:left; white-space:nowrap">ИТОГО: </td>'+
				                        '<td>'+sum+'</td>'+
				                        '</tr>'
				                  );
				            };
				// ----- --- ----- --- ----- 
				        }
				*/






			});

		});
	</script>

	<style>
		/* 
----- ----- ----- ----- ----- ----- ----- ----- ----- -----  

ОСНОВНАЯ ТАБЛИЦА

----- ----- ----- ----- ----- ----- ----- ----- ----- -----  
*/
		/* 
/* Общее для таблицы */
		#docview-details-tab3 {}

		#docview-details-tab3 .details-control:hover {
			cursor: hand
		}

		/* 
/* 
/* Заголовок таблицы */
		#reportview-filterdocs>thead {
			background-color: #326a86;
			font-family: 'Oswald', sans-serif;
			border-bottom: none;
			border-top: none
		}

		#reportview-filterdocs>thead>tr>th {
			color: #fff;
			border-bottom: none;
			font-weight: 500;
			font-size: 1.2em;
			text-transform: uppercase
		}

		#reportview-filterdocs .sorting:after,
		#reportview-filterdocs .sorting_asc:after,
		#reportview-filterdocs .sorting_desc:after {
			display: none
		}

		#reportview-filterdocs>thead>tr>th.sorting_asc {
			padding-right: 8px
		}

		#reportview-filterdocs>thead>tr>th.sorting_desc {
			padding-right: 8px
		}

		/* 
/* 
/* Тело таблицы */
		#reportview-filterdocs {}

		#reportview-filterdocs>tbody {
			font-family: 'Ubuntu', sans-serif;
			font-size: 0.9em;
			color: #666;
			border-bottom: none;
			border-top: none
		}

		#reportview-filterdocs>tbody>tr>td {}

		#reportview-filterdocs>tbody>tr>td {
			padding: 5px 8px;
			line-height: 1.42857143;
			vertical-align: middle;
		}

		#reportview-filterdocs>thead>tr>th {
			border-bottom: none
		}

		#reportview-filterdocs>tbody>tr>td {}

		#reportview-filterdocs>tbody>tr>td:last-child {
			text-align: right
		}

		#reportview-filterdocs>tfoot>tr>td {
			padding: 5px 4px
		}

		#reportview-filterdocs>tfoot {
			background-color: #999;
		}

		/* 
----- ----- ----- ----- ----- ----- ----- ----- ----- -----  
*/
		#reportview-filterdocs>thead>tr>th:first-child,
		#reportview-filterdocs>tbody>tr>td:first-child {
			width: 1%
		}

		#reportview-filterdocs>thead>tr>th:nth-child(2),
		#reportview-filterdocs>tbody>tr>td:nth-child(2) {
			width: 1%
		}

		#reportview-filterdocs>thead>tr>th:nth-child(2),
		#reportview-filterdocs>tbody>tr>td:nth-child(3) {
			width: 1%
		}

		#reportview-filterdocs>thead>tr>th:nth-child(4),
		#reportview-filterdocs>tbody>tr>td:nth-child(4) {
			width: 7%;
			text-align: left
		}

		#reportview-filterdocs>thead>tr>th:nth-child(5),
		#reportview-filterdocs>tbody>tr>td:nth-child(5) {
			width: 15%;
			text-align: left
		}

		#reportview-filterdocs>thead>tr>th:nth-child(6),
		#reportview-filterdocs>tbody>tr>td:nth-child(6) {
			width: 15%;
			text-align: right;
			white-space: nowrap
		}

		#reportview-filterdocs>thead>tr>th:nth-child(7),
		#reportview-filterdocs>tbody>tr>td:nth-child(7) {
			width: 15%;
			text-align: right;
			white-space: nowrap
		}

		#reportview-filterdocs>thead>tr>th:nth-child(8),
		#reportview-filterdocs>tbody>tr>td:nth-child(8) {
			width: 15%;
			text-align: right;
			white-space: nowrap
		}

		#reportview-filterdocs>thead>tr>th:nth-child(9),
		#reportview-filterdocs>tbody>tr>td:nth-child(9) {
			width: 15%;
			text-align: right;
			white-space: nowrap
		}


		#reportview-filterdocs .details-control:hover {
			cursor: pointer
		}

		/* 
----- ----- ----- ----- ----- ----- ----- ----- ----- -----  
*/
		#reportview-filterdocs-row-details .sorting_asc:after {
			display: none
		}

		#reportview-filterdocs-row-details>thead>tr>th.sorting_asc {
			padding-right: 8px
		}

		#reportview-filterdocs .group {
			font-family: 'Oswald', sans-serif;
			font-size: 1.3em;
			font-weight: 400;
			color: #000
		}

		#reportview-filterdocs .group1 {
			font-family: 'Play', sans-serif;
			font-size: 1.15em;
			font-weight: 600;
			color: #000
		}

		#reportview-filterdocs .group2 {
			font-family: 'Play', sans-serif;
			font-size: 1.0em;
			font-weight: 600;
			color: #000
		}


		#reportview-filterdocs>tbody>tr.dtrg-start.dtrg-level-0>td {
			font-family: 'Oswald', sans-serif;
			font-size: 1.35em;
			font-weight: 500;
			color: #000;
			text-align: left
		}

		#reportview-filterdocs>tbody>tr.dtrg-start.dtrg-level-1>td {
			font-family: 'Play', sans-serif;
			font-size: 1.15em;
			font-weight: 500;
			color: #000;
			text-align: left
		}

		#reportview-filterdocs>tbody>tr.dtrg-end.dtrg-level-1>td {
			font-family: 'Play', sans-serif;
			font-size: 1.0em;
			font-weight: 500;
			color: #000;
			background-color: #fff
		}

		#reportview-filterdocs>tbody>tr.dtrg-end.dtrg-level-0>td {
			font-family: 'Play', sans-serif;
			font-size: 1.15em;
			font-weight: 700;
			color: #000;
			background-color: #fff
		}



		/* 
----- ----- ----- ----- ----- ----- ----- ----- ----- -----  
*/

		#column1_search_current,
		#column2_search_current,
		#column3_search_current,
		#column4_search_current {
			width: 100%;
			padding: 5px 5px;
			font-weight: 400;
			font-size: 0.9em;
			color: #333;
			max-height: 31px;
		}

		#column1_search_current {
			text-align: center
		}

		#column2_search_current {
			text-align: center
		}

		#column3_search_current {
			text-align: left
		}

		#column4_search_current {
			text-align: left
		}

		#filters_clear_current,
		#filters_apply_current {
			padding: 6px;
			font-weight: 400;
			font-size: 0.9em
		}

		/* 
----- ----- ----- ----- ----- ----- ----- ----- ----- -----  
*/
		#docsearch-filters-block .panel-title {
			font-family: 'HeliosCond', sans-serif;
			font-size: 1.5em;
			font-weight: 500;
			padding-top: 5px;
			text-transform: none;
		}

		#docsearch-filters-block .panel {
			border: transparent
		}

		#dognet-missions-filters {
			padding: 15px 0;
			background-color: #f1f1f1
		}

		#columnSearch_btnApply .focus,
		#columnSearch_btnApply .active:focus,
		#columnSearch_btnApply:active.focus,
		#columnSearch_btnApply:active:focus,
		#columnSearch_btnApply:focus {
			outline: none;
			border-color: #ccc
		}

		#columnSearch_btnClear .focus,
		#columnSearch_btnClear .active:focus,
		#columnSearch_btnClear:active.focus,
		#columnSearch_btnClear:active:focus,
		#columnSearch_btnClear:focus {
			outline: none;
			border-color: #ccc
		}
		}
	</style>


	<section>

		<div class="space30"></div>
		<div class="demo-html"></div>
		<table id="reportview-filterdocs" class="table table-responsive display compact" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th width=""></th>
					<th width=""></th>
					<th width=""></th>
					<th width=""></th>
					<th width=""></th>
					<th width=""></th>
					<th width="">Счет</th>
					<th width="">Дата</th>
					<th width="">Сумма</th>
					<th width="">Авансы</th>
					<th width="">Оплаты</th>
					<th width="">Задолженность</th>
					<th width=""></th>
				</tr>
			</thead>
		</table>

	</section>


	<script type="text/javascript">
		subtitle = '<?php echo $__subtitle; ?>';
		subsubtitle = '<?php echo $__subsubtitle; ?>';
		document.getElementById("subtitle").innerHTML = subtitle;
		document.getElementById("dognet-subsubtitle").innerHTML = subsubtitle;
		$("#dognet-subsubtitle").attr("class", "text-default");
	</script>