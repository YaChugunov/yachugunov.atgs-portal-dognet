
<script type="text/javascript" language="javascript" class="init">

var table_tab10_contblank;		// use a global for the submit and return data rendering in the examples

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

$(document).ready(function() {

	table_tab10_contblank = $('#docview-details-tab10_contblank').DataTable( {
// 		dom: "<'row space20'<'col-md-8 col-sm-12'><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'ltip>>",
		dom: "t",
		language: {
			url: "russian.json"
		},
		ajax: {
			url: "php/examples/simple/docview/docview-details/restr_3/tabs/process/dognet-docview-details-tab10_contblank-process.php",
			type: "POST"
		},
		serverSide: true,
		columns: [
			{ data: "dognet_docblankwork.numberdoccr", className: "text-center" }
		],
		select: false,
		processing: false,
		paging: false,
		searching: false,
		lengthChange: false,
		createdRow: function( row, d, dataIndex ) {

			rowData = table_tab10_contblank.row( row );

			if (d.dognet_docblankwork.kodtipblank == "POS") {
				d.lastname = d.dognet_blankdocpost.nameendcontact;
				d.firstname = d.dognet_blankdocpost.namefistcontact;
				d.midname = d.dognet_blankdocpost.namesecondcontact;
				d.telrab = d.dognet_blankdocpost.numbertelrab;
				d.telmob = d.dognet_blankdocpost.numbertelmob;
				d.telfax = d.dognet_blankdocpost.numbertelfax;
				d.email = d.dognet_blankdocpost.nameemail;
				d.dolj = d.dognet_blankdocpost.namedoljcontact;
				d.dop1 = "";
				d.dop2 = "";
			}
			if (d.dognet_docblankwork.kodtipblank == "PNR") {
				d.lastname = d.dognet_blankdocpnr.nameendcontact;
				d.firstname = d.dognet_blankdocpnr.namefistcontact;
				d.midname = d.dognet_blankdocpnr.namesecondcontact;
				d.telrab = d.dognet_blankdocpnr.numbertelrab;
				d.telmob = d.dognet_blankdocpnr.numbertelmob;
				d.telfax = d.dognet_blankdocpnr.numbertelfax;
				d.email = d.dognet_blankdocpnr.nameemail;
				d.dolj = d.dognet_blankdocpnr.namedoljcontact;
				d.dop1 = d.dognet_blankdocpnr.dopcontact1;
				d.dop2 = d.dognet_blankdocpnr.dopcontact2;
			}
			if (d.dognet_docblankwork.kodtipblank == "SUB") {
				d.lastname = d.dognet_blankdocsub.nameendcontact;
				d.firstname = d.dognet_blankdocsub.namefistcontact;
				d.midname = d.dognet_blankdocsub.namesecondcontact;
				d.telrab = d.dognet_blankdocsub.numbertelrab;
				d.telmob = d.dognet_blankdocsub.numbertelmob;
				d.telfax = d.dognet_blankdocsub.numbertelfax;
				d.email = d.dognet_blankdocsub.nameemail;
				d.dolj = d.dognet_blankdocsub.namedoljcontact;
				d.dop1 = "";
				d.dop2 = "";
			}

			rowData.child( <?php include('templates/docview-details_tab10_contblank.tpl'); ?> ).show();
		}
	} );
} );
</script>
<?php
// ----- ----- ----- ----- -----
// Подключаем стили для таблицы
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-details/restr_3/tabs/css/docview-details-common-tab10_contblank.css">
<section>
	<div id="docview-tab10_contblank">
		<h3 class="docview-details-title2">Контакты из заявки ГИПа</h3>
		<div class="demo-html"></div>
		<table id="docview-details-tab10_contblank" class="table" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th></th>
				</tr>
			</thead>
		</table>
	</div>
</section>