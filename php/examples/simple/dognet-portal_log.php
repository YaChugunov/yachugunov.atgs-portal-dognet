
<script type="text/javascript" src="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/'; ?>_assets/js/my/date-de.js"></script>
<script type="text/javascript" src="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/'; ?>_assets/js/my/moment-with-locales.js"></script>

<?php date_default_timezone_set('Europe/Moscow'); ?>

<script type="text/javascript" language="javascript" class="init">

var service_log_table;		// use a global for the submit and return data rendering in the examples

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

$(document).ready(function() {

	service_log_table = $('#dognet-service-devs-log').DataTable( {
// 		dom: "<'row'<'col-md-8 col-sm-12'><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'lftip>>",
		dom: "<'space10'>t",
		language: {
			url: "php/examples/simple/dt_russian-portal_log.json"
		},
		ajax: {
			url: "<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/'; ?>dognet/php/examples/php/dognet-portal_log-process.php",
			type: "POST"
		},
		serverSide: true,
		columns: [
			{ data: "msg_date" },
			{ data: "msg_short" }
		],
		columnDefs: [
			{ 
				orderable: false, 
				searchable: false, 
				render: function (  data, type, row, meta ) {
					if (data) { return moment(data, 'YYYY-MM-DD H:m:s').format('DD.MM.YYYY<br>H:m'); }
					else { return ""; } 
				},
				targets: 0 
			}, 
			{ orderable: false, targets: 1 }
		], 
		order: [ [ 0, "desc" ] ],
		select: false,
		processing: true,
		paging: false,
		searching: false,
		buttons: [  ]
	} );

// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 

} );

</script>

<style>
	#service-log { font-family:'Oswald', sans-serif }
	#service-log h3 { font-size:2.0em; font-weight:300; letter-spacing:0.1em }
	
	#dognet-service-devs-log { font-size:1.2em }
	#dognet-service-devs-log > thead { display:none }
	#dognet-service-devs-log > tbody > tr > td { border-top:none }
	#dognet-service-devs-log > tbody > tr > td:nth-child(1) { width:20%; color:#666; font-weight:200 }
	#dognet-service-devs-log > tbody > tr > td:nth-child(2) { width:80%; color:#111; font-weight:300 }
</style>

<section>
	<div id="service-log">
		<h3 class="space10">Новости сервиса</h3>
		<div class="demo-html"></div>
		<table id="dognet-service-devs-log" class="table table-condensed" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th width="20%">Дата/время</th>
					<th>Комментарий</th>
				</tr>
			</thead>
		</table>
	</div>
</section>
