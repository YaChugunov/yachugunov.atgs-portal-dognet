
<?php
// ----- ----- ----- ----- -----
// Подключаем стили для таблиц
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-details/restr_4/tabs/css/docview-details-common-tab8_paperotgr.css">

<section>
	<div class="" style="padding-left:5px; padding-right:5px">
<?php
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// ОТГРУЗКА
// :::
	$query_getDocotgr = mysqlQuery( "
	SELECT dognet_docpaperotgr.koddocpaper as koddocpaper, dognet_docpaperotgr.kodpaper as kodpaper, dognet_docpaperotgr.dateloader as dateloader, dognet_docpaperotgr.dateotgr as dateotgr, dognet_docpaperotgr.nameotgr as nameotgr, dognet_docpaperotgr.nameorgotgr as nameorgotgr, dognet_docpaperotgr.namedocotgr as namedocotgr, dognet_docpaperotgr.commentloader as commentloader, dognet_docpaperotgr.commentotgr as commentotgr, dognet_docpaperotgr.docFileID as docfileid, dognet_docpaperotgr_files.file_url as fileurl
	FROM dognet_docpaperotgr
	LEFT JOIN dognet_sptippaper ON dognet_docpaperotgr.kodpaper = dognet_sptippaper.kodpaper
	LEFT JOIN dognet_docbase ON dognet_docpaperotgr.koddoc = dognet_docbase.koddoc
	LEFT JOIN dognet_docpaperotgr_files ON dognet_docpaperotgr_files.id = dognet_docpaperotgr.docFileID
	WHERE dognet_docpaperotgr.koddoc = ".$varKoddoc." AND dognet_docpaperotgr.koddel <> '99'" );
	if (mysqli_num_rows($query_getDocotgr) >= 1) {
		$cntChetf = 0;
?>
		<h3 class="docview-details-title1">Отгрузка продукции по договору</h3>
		<table id="docview-details-tab8-paperotgr" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th><span class='glyphicon glyphicon-option-vertical'></span></th>
					<th>Ввод</th>
					<th>Отгрузка</th>
					<th>Тип документа</th>
					<th>Описание</th>
					<th>Скан</th>
				</tr>
			</thead>
			<tbody>
<?php
		while ($row_getDocotgr = mysqli_fetch_array($query_getDocotgr, MYSQLI_ASSOC)) {
			$koddocpaper = $row_getDocotgr['koddocpaper'];
?>
				<tr style="">
					<td class="docview-details-tab8-paperotgr"><a href="#tab8-otgrdocs-row-<?php echo $row_getDocotgr['koddocpaper']; ?>" data-toggle="collapse"><span class='glyphicon glyphicon-option-vertical'></span></a></td>
					<td class="docview-details-tab8-paperotgr"><?php echo date("d.m.Y", strtotime($row_getDocotgr['dateloader'])); ?></td>
					<td class="docview-details-tab8-paperotgr"><?php echo date("d.m.Y", strtotime($row_getDocotgr['dateotgr'])); ?></td>
					<td class="docview-details-tab8-paperotgr">
						<?php
							$query_getTippaper = mysqlQuery( "
							SELECT
							*
							FROM dognet_sptippaper
							WHERE dognet_sptippaper.kodpaper = ".$row_getDocotgr['kodpaper'] );
							$row_getTippaper = mysqli_fetch_array($query_getTippaper, MYSQLI_ASSOC);
							if ($query_getTippaper) {
								echo $row_getTippaper['namepaper'];
							}
							else {
								echo "---";
							}
						?>
					</td>
					<td class="docview-details-tab8-paperotgr"><?php echo $row_getDocotgr['namedocotgr']; ?></td>
					<?php
						if ($row_getDocotgr['fileurl']!="") {
					?>
							<td class="docview-details-tab8-paperotgr"><a href="<?php echo $row_getDocotgr['fileurl']; ?>" target="_blank"><span class="glyphicon glyphicon-file"></span></a></td>
					<?php
						}
						else {
					?>
							<td class="docview-details-tab8-paperotgr"><span class="glyphicon glyphicon-option-horizontal"></span></td>
					<?php
						}
					?>
				</tr>

				<tr id="tab8-otgrdocs-row-<?php echo $row_getDocotgr['koddocpaper']; ?>" class="collapse">
					<td colspan="6" class="docview-details-tab8-paperotgr-collapse">

<div id="template-details-paperotgr">

	<div id="row-details-docview-paperotgr-tabs">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">
				<ul id="row-details-docview-paperotgr-tabs-menu" class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" href="#paperotgr-row.id()-tab-1" title="">Информация</a></li>
				</ul>
				<div class="tab-content">
					<div id="paperotgr-row.id()-tab-1" class="tab-pane fade in active">
						<div class="hidden-xs col-sm-12 col-md-12 col-lg-12">
							<div class="space10"></div>
							<div style="padding:10px">

								<table id="row-details-docview-paperotgr-table" class="table table-condensed table-striped" >
									<tbody>
										<tr>
											<td width="30%"><span class="row-details-docview-paperotgr-table-title_topic">Компания-перевозчик</span></td>
											<td width="70%"><span class="row-details-docview-paperotgr-table-txt"><?php echo $row_getDocotgr['nameorgotgr']; ?></span></td>
										</tr>
										<tr>
											<td width="30%"><span class="row-details-docview-paperotgr-table-title_topic">Получатель груза</span></td>
											<td width="70%"><span class="row-details-docview-paperotgr-table-txt"><?php echo $row_getDocotgr['nameotgr']; ?></span></td>
										</tr>
										<tr>
											<td width="30%"><span class="row-details-docview-paperotgr-table-title_topic">Комментарий перевозчика</span></td>
											<td width="70%"><span class="row-details-docview-paperotgr-table-txt"><?php echo $row_getDocotgr['commentotgr']; ?></span></td>
										</tr>
										<tr>
											<td width="30%"><span class="row-details-docview-paperotgr-table-title_topic">Комментарий АТГС</span></td>
											<td width="70%"><span class="row-details-docview-paperotgr-table-txt"><?php echo $row_getDocotgr['commentloader']; ?></span></td>
										</tr>
									</tbody>
								</table>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>

<?php
		}
?>
			</tbody>
		</table>
<?php
	}
	else {
?>
		<table id="docview-details-tab8-paperotgr-message-table" class="table table-condensed" cellspacing="0" width="100%">
			<tbody>
				<tr>
					<td class="docview-details-td-message text-center text-danger">Отгрузки оборудования по договору не проводилось</td>
				</tr>
			</tbody>
		</table>
<?php
	}
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
?>
	</div>

</section>

