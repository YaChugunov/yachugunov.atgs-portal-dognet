
<script type="text/javascript" src="_assets/js/my/date-de.js"></script>
<script type="text/javascript" src="_assets/js/my/moment-with-locales.js"></script>

<script type="text/javascript" language="javascript" class="init">

var editor;		// use a global for the submit and return data rendering in the examples
var table;		// use a global for the submit and return data rendering in the examples

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
//
function format ( d ) {

	return '<table id="objects-details-tab1" class="tableDetails" width="100%" border="0" style="margin:10px 0">'+
		'<tr>'+
			'<td colspan="3"><h4>'+d.namezaklong+'</h4></td>'+
		'</tr>'+
		'<tr>'+
			'<td colspan="3"><hr class="hr-small"></td>'+
		'</tr>'+
		'<tr>'+
			'<td width="49%">Подробное описание документа :</td>'+
			'<td width="1%"></td>'+
			'<td>'+d.zakuraddress+'</td>'+
		'</tr>'+
		'<tr>'+
			'<td colspan="3"><hr class="hr-small"></td>'+
		'</tr>'+
		'<tr>'+
			'<td width="49%">Входящий номер документа:</td>'+
			'<td width="1%"></td>'+
			'<td><b>'+d.zakbankch+'</b></td>'+
		'</tr>'+
		'<tr>'+
			'<td width="49%">Кому адресован документ:</td>'+
			'<td width="1%"></td>'+
			'<td><b>'+d.zakdolg+'</b></td>'+
		'</tr>'+
		'<tr>'+
			'<td width="49%">Кому адресован документ:</td>'+
			'<td width="1%"></td>'+
			'<td><b>'+d.zakfio+'</b></td>'+
		'</tr>'+
	'</table>';
}

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

$(document).ready(function() {

	editor = new $.fn.dataTable.Editor( {
		"display": "bootstrap", 
		"ajax": "php/examples/php/dognet-service-sp-objects-tab1-process.php",
		"table": "#sp-objects-tab1", 
		"fields": [ 
			{
				"label": "Код",
				"name": "kodobject", 
				"placeholder": 'Код'
			}, {
				"label": "Название",
				"name": "nameobjectshot", 
				"placeholder": 'Название'
			}, {
				"label": "Описание",
				"name": "nameobjectlong", 
				"placeholder": 'Описание'
			}, {
				"label": "ХХХ",
				"name": "kodusegip" 
			}
		]
	} );


// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

// Activate an inline edit on click of a table cell
    $('#sp-objects-tab1').on( 'dblclick', 'tbody td:not(:first-child)', function (e) {
        editor.inline( this );
    } );

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

	table = $('#sp-objects-tab1').DataTable( {
// 		dom: "<'row'<'col-md-8 col-sm-12'><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'lftip>>",
		dom: "<'space50'Br>lftip",
		language: {
			url: "russian.json"
		},
		ajax: {
			url: "php/examples/php/dognet-service-sp-objects-tab1-process.php",
			type: "POST"
		},
		serverSide: true,
		columns: [
			{ data: "ID", className: "text-center" },
			{ data: "kodobject" },
			{ data: "nameobjectshot" },
			{ data: "nameobjectlong" }, 
			{ data: "kodusegip", className: "text-center" } 
		],
		select: {
			style: 'os',
			selector: 'td:not(:last-child)' // no row selection on last column
		},
		columnDefs: [
			{ orderable: true, targets: 0 },
			{ orderable: false, targets: 1 },
			{ orderable: false, targets: 2 },
			{ orderable: false, targets: 3 }, 
			{ orderable: false, targets: 4 } 
		], 
		order: [ [ 1, "asc" ] ],
		select: true,
		processing: true,
		paging: true,
		searching: true,
		pageLength: 15, 
		lengthChange: false,
		lengthMenu: [ [15, 30, 50, -1], [15, 30, 50, "Все"] ],
		buttons: [
			{ extend: "create", editor: editor, text: "НОВЫЙ" },
			{ extend: "edit",   editor: editor, text: "ИЗМЕНИТЬ" },
			{ extend: "remove", editor: editor, text: "УДАЛИТЬ" } 
		]
	} );

// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 

} );


</script>

	<div class="container">
		<section>
			<div class="demo-html"></div>
			<table id="sp-objects-tab1" class="table table-striped table-bordered" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th width="5%">#</th>
						<th width="15%">Код</th>
						<th width="25%">Название</th>
						<th>Описание</th>
						<th width="5%" class="text-center">xxx</th>
					</tr>
				</thead>
			</table>
		</section>
	</div>
