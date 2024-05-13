
<?php
// ----- ----- ----- ----- -----
// Подключаем стили для таблиц
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/chetview/chetview-details/restr_4/tabs/css/chetview-details-common-tab9_paperacts.css">

<section>
	<div class="" style="padding-left:5px; padding-right:5px">
<?php
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// АКТЫ ВЫПОЛНЕННЫХ РАБОТ
// :::
	$query_getDocjurnal = mysqlQuery( "
	SELECT dognet_docjurnalact.koddocjurnal as koddocjurnal, dognet_docjurnalact.koddoc as koddoc, dognet_docjurnalact.koddockalplan as koddockalplan, dognet_docjurnalact.datecreateact as datecreateact, dognet_docjurnalact.numberdocact as numberdocact, dognet_docjurnalact.summadocact as summadocact, dognet_docjurnalact.nameactcreate as nameactcreate, dognet_docjurnalact.docactcreater as docactcreater, dognet_docjurnalact.docFileID as docfileid, dognet_docjurnalact_files.file_url as fileurl, dognet_spdened.short_code as shortcode
	FROM dognet_docjurnalact
	LEFT JOIN dognet_docbase ON dognet_docjurnalact.koddoc = dognet_docbase.koddoc
	LEFT JOIN dognet_spdened ON dognet_docbase.koddened = dognet_spdened.koddened
	LEFT JOIN dognet_docjurnalact_files ON dognet_docjurnalact_files.id = dognet_docjurnalact.docFileID
	WHERE dognet_docjurnalact.koddoc = ".$varKoddoc." AND dognet_docjurnalact.koddel <> '99'" );
	if (mysqli_num_rows($query_getDocjurnal) >= 1) {
		$cntChetf = 0;
?>
		<h3 class="chetview-details-title1">Акты выполненных работ по договору</h3>
		<table id="chetview-details-tab9-paperacts" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th><span class='glyphicon glyphicon-option-vertical'></span></th>
					<th>Создан</th>
					<th>Номер акта</th>
					<th>Кем сформирован</th>
					<th>Сумма</th>
					<th>Скан</th>
				</tr>
			</thead>
			<tbody>
<?php
		while ($row_getDocjurnal = mysqli_fetch_array($query_getDocjurnal, MYSQLI_ASSOC)) {
			$koddocjurnal = $row_getDocjurnal['koddocjurnal'];
?>
				<tr style="">
					<td class="chetview-details-tab9-paperacts"><a href="#tab9-acts-row-<?php echo $row_getDocjurnal['koddocjurnal']; ?>" data-toggle="collapse"><span class='glyphicon glyphicon-option-vertical'></span></a></td>
					<td class="chetview-details-tab9-paperacts"><?php echo date("d.m.Y", strtotime($row_getDocjurnal['datecreateact'])); ?></td>
					<td class="chetview-details-tab9-paperacts"><?php echo $row_getDocjurnal['numberdocact']; ?></td>
					<td class="chetview-details-tab9-paperacts"><?php echo $row_getDocjurnal['docactcreater']; ?></td>
					<td class="chetview-details-tab9-paperacts"><?php echo $row_getDocjurnal['summadocact'].$row_getDocjurnal['shortcode']; ?></td>
					<td class="chetview-details-tab9-paperacts"><a href="#">PDF</a></td>
				</tr>

				<tr id="tab9-acts-row-<?php echo $row_getDocjurnal['koddocjurnal']; ?>" class="collapse">
					<td colspan="6" class="chetview-details-tab9-paperacts-acts-collapse">

						<div id="template-details-paperacts">

							<div id="row-details-chetview-paperacts-tabs">
								<div class="row">
									<div class="col-xs-12 col-sm-12 col-md-12">
										<ul id="row-details-chetview-paperacts-tabs-menu" class="nav nav-tabs">
											<li class="active"><a data-toggle="tab" href="#paperacts-row.id()-tab-1" title="">Информация</a></li>
										</ul>
										<div class="tab-content">
											<div id="paperacts-row.id()-tab-1" class="tab-pane fade in active">
												<div class="hidden-xs col-sm-12 col-md-12 col-lg-12">
													<div class="space10"></div>
													<div style="padding:10px">

														<table id="row-details-chetview-paperacts-table" class="table table-condensed table-striped" >
															<tbody>
																<tr>
																	<td width="30%"><span class="row-details-chetview-paperacts-table-title_topic">ID акта</span></td>
																	<td width="70%"><span class="row-details-chetview-paperacts-table-txt"><?php echo $row_getDocjurnal['koddocjurnal']; ?></span></td>
																</tr>
																<tr>
																	<td width="30%"><span class="row-details-chetview-paperacts-table-title_topic">Получатель груза</span></td>
																	<td width="70%"><span class="row-details-chetview-paperacts-table-txt"><?php echo $row_getDocjurnal['koddoc']; ?></span></td>
																</tr>
																<tr>
																	<td width="30%"><span class="row-details-chetview-paperacts-table-title_topic">Комментарий перевозчика</span></td>
																	<td width="70%"><span class="row-details-chetview-paperacts-table-txt"><?php echo $row_getDocjurnal['koddockalplan']; ?></span></td>
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

					</td>
				</tr>
<?php
		}
?>
			</tbody>
		</table>
<?php
	}
	else {
?>
		<table id="chetview-details-tab9-paperacts-message-table" class="table table-condensed" cellspacing="0" width="100%">
			<tbody>
				<tr>
					<td class="chetview-details-td-message text-center text-danger">Акты выполненных работ по договору не формировались</td>
				</tr>
			</tbody>
		</table>
<?php
	}
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
?>
	</div>
</section>

