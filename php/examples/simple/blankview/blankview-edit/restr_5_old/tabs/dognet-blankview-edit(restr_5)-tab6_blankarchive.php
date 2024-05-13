<script type="text/javascript" language="javascript" class="init">
	function print_checkBox(checkBox) {
		if (checkBox == 1) { return "<span class='glyphicon glyphicon-check'></span>"; }
		else { return "<span class='glyphicon glyphicon-unchecked'></span>"; }
	}
$(document).ready(function() {
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
//
//
//
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// ТАБЛИЦА ДАННЫХ ::: Скрипт Table
	var table_blankview_edit_blankarchive = $('#blankview-edit-blankarchive-table').DataTable( {
		dom: "<'row'<'col-sm-2'B><'col-sm-9'<'#textttttttt'>><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'p>>",
// 		dom: "<'space50'r>tip",
		language: {
			url: "php/examples/simple/blankview/blankview-edit/dt_russian-tab1_blankwork.json"
		},
		ajax: {
			url: "php/examples/php/blankview/blankview-edit/dognet-blankview-edit-blankarchive-process.php",
			type: "POST"
		},
		serverSide: true,
		columns: [
      {
				class: "details-control-docblank",
				searchable: false,
				orderable: false,
				data: null,
				defaultContent: "<span class='glyphicon glyphicon-option-vertical'></span>"
      },
			{ data: "dognet_docblankwork.numberblankwork", className: "" },
			{ data: "dognet_docblankwork.yearblankwork", className: "" },
			{ data: "dognet_docblankwork.nametipblankwork", className: "" },
			{ data: "dognet_docblankwork.nameblankwork", className: "" },
			{ data: "dognet_docblankwork.nameorgblankwork", className: "" },
			{ data: "dognet_docblankwork.kodstatusblank", className: "" },
			{ data: "dognet_docblankwork.numberdoccr", className: "" },
			{ data: "dognet_docblankwork.dateblankorder", className: "" },
			{ data: "dognet_docblankwork.dateblankwork", className: "" },
			{ data: "dognet_docblankwork.dateblankdoc", className: "" },
			{
				class: "details-control-blankarchive",
				searchable: false,
				orderable: false,
				data: null,
				defaultContent: '<span class="glyphicon glyphicon-list-alt"></span>',
				className: "text-right"
			},
			{ data: "dognet_sysdefs_blankstatus.id" },
			{ data: "dognet_spispol.ispolnameshot" },
			{ data: "dognet_docblankwork.kodtipblank" },
			{ data: "dognet_spispolruk.ispolrukname" }
		],
		select: {
			style: 'single',
			selector: 'td:not(:last-child)' // no row selection on last column
		},
		columnDefs: [
			{ orderable: false, searchable: false, targets: 0 },
			{ orderable: false, searchable: true, targets: 1 },
			{ orderable: false, searchable: true, targets: 2 },
			{
				orderable: false,
				searchable: true,
				targets: 3,
				render: function ( data, type, row, meta ) {
					fullstr = data;
					if (data.length > 3) { return data.substr(0,3); }
					else { return data;	}
				}
			},
			{
				orderable: false,
				searchable: true,
				targets: 4,
				render: function ( data, type, row, meta ) {
					fullstr = data;
					if (data.length > 65) { return data.substr(0,65)+" ..."; }
					else { return data;	}
				}
			},
			{ orderable: false, searchable: true, targets: 5 },
			{
				orderable: false,
				visible: false,
				searchable: true,
				targets: 6,
				render: function ( data, type, row, meta ) {
					return row.dognet_docblankwork.nametipblankwork;
				}
			},
			{ orderable: false, searchable: true, targets: 7 },
			{ orderable: false, searchable: false, targets: 8 },
			{ orderable: false, searchable: false, targets: 9 },
			{ orderable: false, searchable: false, targets: 10 },
			{ orderable: false, searchable: false, targets: 11 },
			{ orderable: false, searchable: false, visible: false, targets: 12 },
			{ orderable: false, searchable: true, visible: false, targets: 13 },
			{ orderable: false, searchable: true, visible: false, targets: 14 },
			{ orderable: false, searchable: true, visible: false, targets: 15 }
		],
		order: [ [ 12, "asc" ], [ 2, "desc" ], [ 1, "desc" ], [ 6, "asc" ] ],
		select: true,
		processing: true,
		paging: true,
		searching: true,
		pageLength: 10,
		lengthChange: false,
		lengthMenu: [ [15, 30, 50, -1], [15, 30, 50, "Все"] ],
		buttons: [
			{ text:	'<span class="glyphicon glyphicon-refresh"></span>', action:
				function ( e, dt, node, config ) {
					$('#blankNumberSearchArchive_text').val('');
					$('#docNumberSearchArchive_text').val('');
					$('#blankYearSearchArchive_text').val('');
					$('#blankStatusSearchArchive_text').val('');
					$('#blankNameSearchArchive_text').val('');
					$('#blankObjectSearchArchive_text').val('');
					$('#blankTypeSearchArchive_text').val('');
					$('#blankIspolSearchArchive_text').val('');
					$('#blankIspolRukSearchArchive_text').val('');
					table_blankview_edit_blankarchive.columns().search('');
					table_blankview_edit_blankarchive.draw();
			    table_blankview_edit_blankarchive_summadop.ajax.reload();
			    table_blankview_edit_blankarchive_docfiles.ajax.reload();
			    table_blankview_edit_blankarchive_blankpril.ajax.reload();
				}
			}
		],
		initComplete: function() {

		},
		drawCallback: function () {

		}

	} );
// ----- ----- -----
// ТАБЛИЦА ДАННЫХ ::: Поиск
		$('#globalSearchArchive_button').click(function(e){
			table_blankview_edit_blankarchive.search($("#globalSearchArchive_text").val()).draw();
		});
		$('#clearSearch_button').click(function(e){
			table_blankview_edit_blankarchive.search('').draw();
			$('#globalSearchArchive_text').val('');
		});
		$('#columnSearchArchive_btnApply').click(function(e){
			table_blankview_edit_blankarchive
				.columns(1)
				.search($("#blankNumberSearchArchive_text").val())
				.draw();

			table_blankview_edit_blankarchive
				.columns(7)
				.search($("#docNumberSearchArchive_text").val())
				.draw();

			table_blankview_edit_blankarchive
				.columns(2)
				.search($("#blankYearSearchArchive_text").val())
				.draw();

			table_blankview_edit_blankarchive
				.columns(6)
				.search($("#blankStatusSearchArchive_text").val())
				.draw();

			table_blankview_edit_blankarchive
				.columns(14)
				.search($("#blankTypeSearchArchive_text").val())
				.draw();

			table_blankview_edit_blankarchive
				.columns(5)
				.search($("#blankObjectSearchArchive_text").val())
				.draw();

			table_blankview_edit_blankarchive
				.columns(4)
				.search($("#blankNameSearchArchive_text").val())
				.draw();

			table_blankview_edit_blankarchive
				.columns(13)
				.search($("#blankIspolSearchArchive_text").val())
				.draw();

			table_blankview_edit_blankarchive
				.columns(15)
				.search($("#blankIspolRukSearchArchive_text").val())
				.draw();

		});
		$('#columnSearchArchive_btnClear').click(function(e){
			$('#blankNumberSearchArchive_text').val('');
			$('#docNumberSearchArchive_text').val('');
			$('#blankYearSearchArchive_text').val('');
			$('#blankStatusSearchArchive_text').val('');
			$('#blankNameSearchArchive_text').val('');
			$('#blankObjectSearchArchive_text').val('');
			$('#blankTypeSearchArchive_text').val('');
			$('#blankIspolSearchArchive_text').val('');
			$('#blankIspolRukSearchArchive_text').val('');
			table_blankview_edit_blankarchive
				.columns()
				.search('')
				.draw();
		});
// ----- ----- -----
		$("#blankNumberSearchArchive_text").on("keyup", function(event) {
		  if (event.keyCode === 13) { event.preventDefault(); document.getElementById("columnSearchArchive_btnApply").click(); }
		});
		$("#docNumberSearchArchive_text").on("keyup", function(event) {
		  if (event.keyCode === 13) { event.preventDefault(); document.getElementById("columnSearchArchive_btnApply").click(); }
		});
		$("#blankYearSearchArchive_text").on("keyup", function(event) {
		  if (event.keyCode === 13) { event.preventDefault(); document.getElementById("columnSearchArchive_btnApply").click(); }
		});
		$("#blankNameSearchArchive_text").on("keyup", function(event) {
		  if (event.keyCode === 13) { event.preventDefault(); document.getElementById("columnSearchArchive_btnApply").click(); }
		});
		$("#blankObjectSearchArchive_text").on("keyup", function(event) {
		  if (event.keyCode === 13) { event.preventDefault(); document.getElementById("columnSearchArchive_btnApply").click(); }
		});
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Array to track the ids of the edit displayed rows
    var detailRows_docblank = [];
    $('#blankview-edit-blankarchive-table tbody').on( 'click', 'tr td.details-control-docblank', function () {
        var tr = $(this).closest('tr');
        var row = table_blankview_edit_blankarchive.row( tr );
        var idx = $.inArray( tr.attr('id'), detailRows_docblank );

        if ( row.child.isShown() ) {
            tr.removeClass( 'edit' );
            row.child.hide();

            // Remove from the 'open' array
            detailRows_docblank.splice( idx, 1 );
        }
        else {
            tr.addClass( 'edit' );
			rowData = table_blankview_edit_blankarchive.row( row );
			d = row.data();
			rowData.child( <?php include('templates/blankview-edit-tab6-blankarchive-doc-table.tpl'); ?> ).show();
// Add to the 'open' array
            if ( idx === -1 ) {
                detailRows_docblank.push( tr.attr('id') );
            }
        }
    } );
// On each draw, loop over the `detailRows` array and show any child rows
	table_blankview_edit_blankarchive.on( 'draw', function () {
		$.each( detailRows_docblank, function ( i, id ) {
		$('#'+id+' td.details-control-docblank').trigger( 'click' );
	    } );
	} );
//
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Array to track the ids of the edit displayed rows
    var detailRows_blankarchive = [];
    $('#blankview-edit-blankarchive-table tbody').on( 'click', 'tr td.details-control-blankarchive', function () {
        var tr = $(this).closest('tr');
        var row = table_blankview_edit_blankarchive.row( tr );
        var idx = $.inArray( tr.attr('id'), detailRows_blankarchive );

        if ( row.child.isShown() ) {
            tr.removeClass( 'edit' );
            row.child.hide();

            // Remove from the 'open' array
            detailRows_blankarchive.splice( idx, 1 );
        }
        else {
            tr.addClass( 'edit' );
			rowData = table_blankview_edit_blankarchive.row( row );
			d = row.data();
			if (d.dognet_docblankwork.kodtipblank == "POS") {
				rowData.child( <?php include('templates/blankview-edit-tab6-blankarchive-pos-blank-table.tpl'); ?> ).show();
			}
			if (d.dognet_docblankwork.kodtipblank == "PNR") {
				rowData.child( <?php include('templates/blankview-edit-tab6-blankarchive-pnr-blank-table.tpl'); ?> ).show();
			}
			if (d.dognet_docblankwork.kodtipblank == "SUB") {
				rowData.child( <?php include('templates/blankview-edit-tab6-blankarchive-sub-blank-table.tpl'); ?> ).show();
			}
// Add to the 'open' array
            if ( idx === -1 ) {
                detailRows_blankarchive.push( tr.attr('id') );
            }
        }
    } );
// On each draw, loop over the `detailRows` array and show any child rows
	table_blankview_edit_blankarchive.on( 'draw', function () {
		$.each( detailRows_blankarchive, function ( i, id ) {
		$('#'+id+' td.details-control-blankarchive').trigger( 'click' );
	    } );
	} );
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
//
//
//
//
//
//
//
//
//
//
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// БЛАНКИ ДЛЯ ПЕЧАТИ ::: Таблица данных
	var table_blankview_edit_blankarchive_docfiles = $('#blankview-edit-blankarchive-docfiles-table').DataTable( {
		dom: "<'row'<'col-sm-5'><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'><'col-sm-8'>>",
// 		dom: "<'space50'r>tip",
		language: {
			url: "php/examples/simple/blankview/blankview-edit/dt_russian-tab1_blankwork-docfiles.json"
		},
		ajax: {
			url: "php/examples/php/blankview/blankview-edit/dognet-blankview-edit-blankarchive-docfiles-process.php",
			type: 'post',
      data: function ( d ) {
          var selected = table_blankview_edit_blankarchive.row( { selected: true } );
          if ( selected.any() ) {
					    d.kodblankwork_archive = selected.data().dognet_docblankwork.kodblankwork;
					    d.kodtipblank_archive = selected.data().dognet_docblankwork.kodstatusblank;
          }
			}
		},
		serverSide: true,
		columns: [
			{ data: "dognet_docblankwork_files.blank_status", className: "text-center" },
			{ data: "dognet_docblankwork_files.file_name", className: "text-center" },
			{ data: "dognet_docblankwork_files.file_extension", className: "text-center" }
		],
		select: {
			style: 'single',
			selector: 'td:not(:last-child)' // no row selection on last column
		},
		select: false,
		columnDefs: [
			{ orderable: false, searchable: true,
				render: function(data) {
					if (data == 'CR' || data == 'GIP') { return '<span class="label label-default text-uppercase">ГИП</span>'; }
					if (data == 'RD' || data == 'DO') { return '<span class="label label-danger text-uppercase">ДОГ</span>'; }
					else { return '<span class="label label-default text-uppercase">???</span>'; }
				},
				targets: 0
			},
			{ orderable: false, searchable: true,
				render: function ( data, type, row, meta ) {
					return '<a class="blank_link" href="'+row.dognet_docblankwork_files.file_url+'" target="_blank">'+row.dognet_sysdefs_blankstatus.status_description+'</a>';
					},
				targets: 1
			},
			{ orderable: false, searchable: true,
				render: function ( data, type, row, meta ) {
					return '<span class="label label-primary">'+data+'</span>';
					},
				targets: 2
			}
		],
		processing: false,
		paging: false,
		searching: false,
		initComplete: function() {

		},
		drawCallback: function (settings) {

		}
	} );
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
//
//
//
//
//
//
//
//
//
//
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// ПРИКРЕПЛЯЕМЫЕ ФАЙЛЫ К БЛАНКУ ::: Таблица данных
	var table_blankview_edit_blankarchive_blankpril = $('#blankview-edit-blankarchive-blankpril-table').DataTable( {
		dom: "<'row'<'col-sm-5'><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'><'col-sm-8'>>",
// 		dom: "<'space50'r>tip",
		language: {
			url: "php/examples/simple/blankview/blankview-edit/dt_russian-tab1_blankwork-prilfiles.json"
		},
		ajax: {
			url: "php/examples/php/blankview/blankview-edit/dognet-blankview-edit-blankarchive-blankpril-process.php",
			type: 'post',
      data: function ( d ) {
          var selected = table_blankview_edit_blankarchive.row( { selected: true } );
          if ( selected.any() ) {
					    d.kodblankwork_archive = selected.data().dognet_docblankwork.kodblankwork;
		          console.log("Kodblankwork ("+selected.id()+") :: kodblankwork: "+d.kodblankwork_archive);
          }
			}
		},
		serverSide: true,
		columns: [
			{ data: "dognet_blankworkpril.numberpril", className: "text-center" },
			{ data: "dognet_blankworkpril.kodtipblank", className: "text-center" },
			{ data: "dognet_blankworkpril.namepril", className: "text-center" },
			{ data: "dognet_blankworkpril.extfile", className: "text-center" }
		],
		select: {
			style: 'single'
		},
		columnDefs: [
			{ orderable: false, searchable: true, targets: 0 },
			{ orderable: false, searchable: true,
				render: function(data) {
					if (data == 'CR') { return '<span class="label label-default text-uppercase">ГИП</span>'; }
					if (data == 'RD' || data == 'DO') { return '<span class="label label-danger text-uppercase">ДОГ</span>'; }
					else { return '<span class="label label-default text-uppercase">???</span>'; }
				},
				targets: 1
			},
			{ orderable: false, searchable: true,
				render: function ( data, type, row, meta ) {
					if (row.dognet_blankworkpril_files.file_url == null) {
						return data;
					}
					else {
						return '<a class="blank_link" href="'+row.dognet_blankworkpril_files.file_url+'" target="_blank">'+data+'</a>';
					}
				},
				targets: 2
			},
			{ orderable: false, searchable: true,
				render: function ( data, type, row, meta ) {
					return '<span class="label label-primary">'+data+'</span>';
					},
				targets: 3
			}
		],
		processing: false,
		paging: false,
		searching: false,
		initComplete: function() {

		},
		drawCallback: function () {

		}
		} );
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
//
//
//
//
//
//
//
//
//
//
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// ДОПОЛНИТЕЛЬНЫЕ СУММЫ К БЛАНКУ ::: Таблица данных
	var table_blankview_edit_blankarchive_summadop = $('#blankview-edit-blankarchive-summadop-table').DataTable( {
		dom: "<'row'<'col-sm-5'><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'><'col-sm-8'>>",
// 		dom: "<'space50'r>tip",
		language: {
			url: "php/examples/simple/blankview/blankview-edit/dt_russian-tab1_blankwork-summadop.json"
		},
		ajax: {
			url: "php/examples/php/blankview/blankview-edit/dognet-blankview-edit-blankarchive-summadop-process.php",
			type: 'post',
      data: function ( d ) {
          var selected = table_blankview_edit_blankarchive.row( { selected: true } );
          if ( selected.any() ) {
					    d.kodblankwork_archive = selected.data().dognet_docblankwork.kodblankwork;
					    d.kodtipblank_archive = selected.data().dognet_docblankwork.kodtipblank;
					    d.rowID_archive = selected.id().substr(4);
          }
			}
		},
		serverSide: true,
		columns: [
			{ data: "dognet_blanksummadop.kodsummadop", className: "text-center" },
			{ data: "dognet_blanksummadop.kodtipblank", className: "text-center" },
			{ data: "dognet_blanksummadop.namesummadop", className: "text-center" },
			{ data: "dognet_blanksummadop.summadopblank", className: "text-center" }
		],
		select: {
			style: 'single',
			selector: 'td:not(:last-child)' // no row selection on last column
		},
		columnDefs: [
			{ orderable: false, searchable: true, targets: 0 },
			{ orderable: false, searchable: true,
				render: function(data) {
					if (data == 'CR') { return '<span class="label label-default text-uppercase">ГИП</span>'; }
					if (data == 'RD' || data == 'DO') { return '<span class="label label-danger text-uppercase">ДОГ</span>'; }
					else { return '<span class="label label-default text-uppercase">???</span>'; }
				},
				targets: 1
			},
			{ orderable: false, searchable: true, targets: 2 },
			{ orderable: false, searchable: false, render: function ( data, type, row, meta ) {
				if (data != null) {
					return $.fn.dataTable.render.number(' ', ',', 2, '').display( data );
				}
				else {
					return "0.00";
				}
				}, targets: 3
			}
		],
		select: false,
		processing: false,
		paging: false,
		searching: false,
		initComplete: function() {

		},
		drawCallback: function () {

		}
		} );
//
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	table_blankview_edit_blankarchive.on( 'select', function () {
			table_blankview_edit_blankarchive.buttons().enable();
	    table_blankview_edit_blankarchive_summadop.ajax.reload();
	    table_blankview_edit_blankarchive_docfiles.ajax.reload();
	    table_blankview_edit_blankarchive_blankpril.ajax.reload();
	} );
	table_blankview_edit_blankarchive.on( 'deselect', function () {
	    table_blankview_edit_blankarchive_summadop.ajax.reload();
	    table_blankview_edit_blankarchive_docfiles.ajax.reload();
	    table_blankview_edit_blankarchive_blankpril.ajax.reload();
	} );
	table_blankview_edit_blankarchive.on( 'init', function () {
			table_blankview_edit_blankarchive_summadop.buttons().disable();
			table_blankview_edit_blankarchive_docfiles.buttons().disable();
			table_blankview_edit_blankarchive_blankpril.buttons().disable();
	} );
} );
</script>
<?php
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
//
//
//
//
//
//
//
//
//
//
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Подключаем стили для форм и таблиц
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/blankview/blankview-edit/restr_5/tabs/css/blankview-edit-tab6_blankarchive.css">
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/blankview/blankview-edit/restr_5/tabs/css/blankview-edit-tab6_summadop.css">
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/blankview/blankview-edit/restr_5/tabs/css/blankview-edit-tab6_doc_files.css">
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/blankview/blankview-edit/restr_5/tabs/css/blankview-edit-tab6_pril_files.css">
<?php
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
?>
  <div class="space10"></div>
  <div id="blankarchive-edit-search-filters-block" class="panel-group">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" href="#blankarchive-edit-search-filters">Фильтры для поиска бланка</a>
        </h4>
      </div>
      <div id="blankarchive-edit-search-filters" class="panel-collapse collapse">

				<div id="blankarchive-edit-filters" class="panel-body space30">
					<div class="col-xs-12 col-sm-3 col-md-1 col-lg-1">
						<div class="form-group space10" style="width:100%">
							<label for="blankNumberSearchArchive_text"><b># бл :</b></label>
							<input type="text" id="blankNumberSearchArchive_text" class="form-control" placeholder="###" name="blankNumberSearchArchive_text">
						</div>
					</div>
					<div class="col-xs-12 col-sm-3 col-md-1 col-lg-1">
						<div class="form-group space10" style="width:100%">
							<label for="docNumberSearchArchive_text"><b># дог :</b></label>
							<input type="text" id="docNumberSearchArchive_text" class="form-control" placeholder="####" name="docNumberSearchArchive_text">
						</div>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
						<div class="form-group space10" style="width:100%">
							<label for="blankStatusSearchArchive_text"><b>Статус :</b></label>
							<select name="blankStatusSearchArchive_text" id="blankStatusSearchArchive_text" class="form-control">
								<option value="">Все статусы</option>
								<?php
									$_QRY1 = mysqlQuery( "SELECT status_kod, status_description, status_name FROM dognet_sysdefs_blankstatus WHERE status = 1" );
									while($_ROW1 = mysqli_fetch_assoc($_QRY1)){
									?>
											<option value = '<?php echo $_ROW1["status_kod"]; ?>'><?php echo $_ROW1["status_name"]; ?></option>
								<?php
									}
									?>
							</select>
						</div>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
						<div class="form-group space10" style="width:100%">
							<label for="blankTypeSearchArchive_text"><b>Тип :</b></label>
							<select name="blankTypeSearchArchive_text" id="blankTypeSearchArchive_text" class="form-control">
								<option value="">Все типы</option>
								<?php
									$_QRY2 = mysqlQuery( " SELECT type_kod, type_description, type_name FROM dognet_sysdefs_blanktype WHERE status = 1" );
									while($_ROW2 = mysqli_fetch_assoc($_QRY2)){
									?>
											<option value = '<?php echo $_ROW2["type_kod"]; ?>'><?php echo $_ROW2["type_name"]; ?></option>
								<?php
									}
									?>
							</select>
						</div>
					</div>
<?php // ----- ----- ----- ----- ----- ?>
					<div class="col-xs-12 col-sm-3 col-md-4 col-lg-4">
						<div class="input-group space10" style="width:100%">
							<label for="blankObjectSearchArchive_text"><b>Заказчик/объект :</b></label>
							<input type="text" id="blankObjectSearchArchive_text" class="form-control" placeholder="Все объекты" name="blankObjectSearchArchive_text">
						</div>
					</div>
<?php // ----- ----- ----- ----- ----- ?>
					<div class="col-xs-12 col-sm-12 col-md-1 col-lg-1">
						<div class="form-group space10" style="width:100%">
							<label for="blankYearSearchArchive_text"><b>Год :</b></label>
							<input type="text" id="blankYearSearchArchive_text" class="form-control" placeholder="ГГГГ" name="blankYearSearchArchive_text">
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
						<div class="form-group space10" style="width:100%">
							<label for="blankIspolSearchArchive_text"><b>Исполнитель (ГИП) :</b></label>
							<select name="blankIspolSearchArchive_text" id="blankIspolSearchArchive_text" class="form-control">
								<option value="">Все</option>
								<?php
									$_QRY3 = mysqlQuery( "SELECT * FROM dognet_spispol WHERE kodusegip != '0'" );
									while($_ROW3 = mysqli_fetch_assoc($_QRY3)){
									?>
											<option value = '<?php echo $_ROW3["ispolnameshot"]; ?>'><?php echo $_ROW3["ispolnameshot"]; ?></option>
								<?php
									}
									?>
							</select>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
						<div class="form-group space10" style="width:100%">
							<label for="blankIspolRukSearchArchive_text"><b>Исполнитель (рук) :</b></label>
							<select name="blankIspolRukSearchArchive_text" id="blankIspolRukSearchArchive_text" class="form-control">
								<option value="">Все</option>
								<?php
									$_QRY4 = mysqlQuery( "SELECT * FROM dognet_spispolruk WHERE koddel != '99' AND kodrukgip = '1'" );
									while($_ROW4 = mysqli_fetch_assoc($_QRY4)){
									?>
											<option value = '<?php echo $_ROW4["ispolrukname"]; ?>'><?php echo $_ROW4["ispolrukname"]; ?></option>
								<?php
									}
									?>
							</select>
						</div>
					</div>
<?php // ----- ----- ----- ----- ----- ?>
					<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
						<div class="input-group space10" style="width:100%">
							<label for="blankNameSearchArchive_text"><b>Текст из названия :</b></label>
							<input type="text" id="blankNameSearchArchive_text" class="form-control" placeholder="Введите текст для поиска" name="blankNameSearchArchive_text">
						</div>
					</div>
<?php // ----- ----- ----- ----- ----- ?>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
						<div class="input-group-btn">
							<button id="columnSearchArchive_btnApply" class="btn btn-default" type="button">Применить фильтры</button>
							<button id="columnSearchArchive_btnClear" class="btn btn-default" type="button"><i class="glyphicon glyphicon-remove"></i></button>
						</div>
					</div>
<?php // ----- ----- ----- ----- ----- ?>
				</div>

      </div>
    </div>
  </div>
<?php
//
// ----- ----- -----
//
?>
<section>
	<div class="space30"></div>
	<div class="demo-html"></div>
	<table id="blankview-edit-blankarchive-table" class="table table-striped" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
					<th width="" class="">№</th>
					<th width="" class="">Год</th>
					<th width="" class="">Тип</th>
					<th width="" class="">Описание</th>
					<th width="" class="">Организация</th>
					<th width="" class="">Тип</th>
					<th width="" class="">Договор</th>
					<th width="" class="">Создан</th>
					<th width="" class="">Оформлен</th>
					<th width="" class="">Готов</th>
					<th width="" class=""><span class="glyphicon glyphicon-list-alt"></span></th>
					<th width="" class=""></th>
				</tr>
			</thead>
	</table>
</section>
<div class="space30"></div>
<?php
//
// ----- ----- -----
//
?>
<section>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="space10"></div>
		<div id="blankview-edit-blankarchive-summadop">
			<h3 class="space10">Разбиение суммы договора</h3>
			<div class="demo-html"></div>
			<table id="blankview-edit-blankarchive-summadop-table" class="table table-striped" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th width="" class=""></th>
						<th width="" class=""></th>
						<th width="" class=""></th>
						<th width="" class=""></th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
<?php // ----- ----- ----- ?>
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		<div class="space10"></div>
		<div id="blankview-edit-blankarchive-docfiles">
			<h3 class="space10">Файлы бланков для печати</h3>
			<div class="demo-html"></div>
			<table id="blankview-edit-blankarchive-docfiles-table" class="table table-striped" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th width="" class=""></th>
						<th width="" class=""></th>
						<th width="" class=""></th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
<?php // ----- ----- ----- ?>
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		<div class="space10"></div>
		<div id="blankview-edit-blankarchive-blankpril">
			<h3 class="space10">Прикрепленные к бланку файлы</h3>
			<div class="demo-html"></div>
			<table id="blankview-edit-blankarchive-blankpril-table" class="table table-striped" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th width="" class=""></th>
						<th width="" class=""></th>
						<th width="" class=""></th>
						<th width="" class=""></th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</section>
