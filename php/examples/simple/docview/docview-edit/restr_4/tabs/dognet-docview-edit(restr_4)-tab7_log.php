
<script type="text/javascript" language="javascript" class="init">

var tableSysLog;
$(document).ready(function() {

tableSysLog = $('#docview-edit-syslog').DataTable( {
		dom: "<'row'<'col-sm-5'B><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'><'col-sm-8'p>>",
// 		dom: "Brlftip",
		language: { url: "php/examples/simple/docview/docview-edit/dt_russian-tab7_log.json" },
		ajax: {
			url: "php/examples/simple/docview/docview-edit/restr_4/tabs/process/dognet-docview-edit(restr_4)-tab7_log-process.php",
			type: "POST"
		},
		serverSide: true,
		columns: [
			{ data: "id" },
			{ data: "timestamp" },
			{ data: "user_lastname" },
			{ data: "subgroup" },
			{ data: "field_info1" }
		],
		columnDefs: [
			{ visible: true, searchable: false, orderable: false, targets: 0 },
			{ visible: true, searchable: true, orderable: false, targets: 1 },
			{ visible: true, searchable: true, orderable: false, targets: 2 },
			{ visible: true, searchable: true, orderable: false, targets: 3 },
			{ visible: true, searchable: true, orderable: false,
				render: function ( data, type, row, meta ) { return data; },
				targets: 4
			}
		],
		select: true,
		processing: false,
// 	    scrollY: 575,
		paging: true,
		searching: true,
		pageLength: 15,
		lengthChange: false,
		lengthMenu: [ [10, 50, 100, -1], [10, 50, 100, "Все"] ],
		buttons: [
			{ text:	'<span class="glyphicon glyphicon-refresh"></span>', action:
				function ( e, dt, node, config ) {
          tableSysLog.columns().search('');
          tableSysLog.draw();
				}
			}
		],
		createdRow: function ( row, data, index ) {

		}
	} );

} );


</script>


<!-- Custom form Editor -->
<!-- <link rel="stylesheet" type="text/css" href="./_css/table_docview-edit-syslog.css"> -->

<style>
	#docview-edit-syslog { margin-top:10% }
	#docview-edit-syslog > thead { font-size:0.85em; font-family:'Play', sans-serif; background-color:#f1f1f1; color:#111; text-transform:none }
	#docview-edit-syslog > tbody { font-size:0.85em; font-family:'Play', sans-serif }
	#docview-edit-syslog > thead > tr > th { padding:10px 6px; border-bottom:none }
	#docview-edit-syslog > tbody > tr > td { padding:4px 6px; border-top:none; border-bottom:none }

/* ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- */
	.dataTables_length { float: left; text-align: left; }
	.dataTables_filter { float: right; text-align: right; }
	.dataTables_info { float: left; text-align: left; }
	.dataTables_paginate { float: right; text-align: right; }
	td.details-control { cursor: pointer }
	tr.details td.details-control {  }

	#docview-edit-syslog > tbody > tr:first-child > td { border-top:none }
	#docview-edit-syslog > thead > tr > th:first-child, #docview-edit-syslog > tbody > tr > td:first-child { width:2%; text-align:center; white-space:nowrap }
	#docview-edit-syslog > thead > tr > th:nth-child(2), #docview-edit-syslog > tbody > tr > td:nth-child(2) { width:10%; text-align:left; white-space:nowrap }
	#docview-edit-syslog > thead > tr > th:nth-child(3), #docview-edit-syslog > tbody > tr > td:nth-child(3) { width:8%; text-align:left; white-space:nowrap }
	#docview-edit-syslog > thead > tr > th:nth-child(4), #docview-edit-syslog > tbody > tr > td:nth-child(4) { width:10%; text-align:left; white-space:nowrap }
	#docview-edit-syslog > thead > tr > th:nth-child(5), #docview-edit-syslog > tbody > tr > td:nth-child(5) { text-align:left }

	#profile-table > tbody > tr > td { font-size: 1.0em; text-align:left }
	#docview-edit-syslog .hr-small { margin-top:10px; margin-bottom:10px }

	#docview-edit-syslog > thead > tr > th.sorting_asc::after, #docview-edit-syslog > thead > tr > th.sorting_desc::after { display:none }

</style>

<div class="space30"></div>
<section id="docview-edit-syslog-table" style="">
	<table id="docview-edit-syslog" style="" class="table table-condensed table-bordered table-striped display compact" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>ID</th>
				<th>Временная метка</th>
				<th>Пользователь</th>
				<th>Раздел</th>
				<th>Подробно</th>
			</tr>
		</thead>
	</table>
</section>

<div class="space100"></div>

