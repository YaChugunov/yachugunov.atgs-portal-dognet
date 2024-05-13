<?php
date_default_timezone_set('Europe/Moscow');
# Подключаем конфигурационный файл
// require($_SERVER['DOCUMENT_ROOT']."/config.inc.php");
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Подключаемся к базе
require_once($_SERVER['DOCUMENT_ROOT'] . "/_assets/drivers/db_connection.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/_assets/drivers/db_controller.php");
$db_handle = new DBController();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
$__uniqueID = $_SESSION['uniqueID'];
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
// Вытаскиваем идентификатор календарного плана
$query1 = mysqlQuery("SELECT koddened FROM dognet_docbase WHERE koddoc=" . $__uniqueID);
$row1 = mysqli_fetch_assoc($query1);
$__koddened = $row1['koddened'];
$query2 = mysqlQuery("SELECT short_code FROM dognet_spdened WHERE koddened=" . $__koddened);
$row2 = mysqli_fetch_assoc($query2);
$__dened = $row2['short_code'];
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
$varKoddoc = $_GET['uniqueID'];
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
?>

<style>
	/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----

ОСНОВНАЯ ТАБЛИЦА

----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
	/*
/* Общее для таблицы */
	#chetview-details-tab3 {}

	#chetview-details-tab3 .details-control:hover {
		cursor: hand
	}

	.chetview-details-tab3-title {
		color: #111;
		font-family: 'Oswald', sans-serif;
		font-size: 1.7em;
		font-weight: 300;
		margin-bottom: 20px;
		letter-spacing: 0.3em
	}

	/*
/*
/* Заголовок таблицы */
	#chetview-details-tab3>thead {
		/* display:none */
	}

	#chetview-details-tab3>thead {
		background-color: #f1f1f1;
		color: #111;
		font-family: 'Oswald', sans-serif;
		border-bottom: none;
		border-top: none
	}

	#chetview-details-tab3>thead>tr>th {
		color: #333;
		border-bottom: none;
		font-weight: 500;
		font-size: 1.3em;
		text-transform: uppercase
	}

	#chetview-details-tab3>thead>tr>th:first-child {
		background-color: #f0f0f0;
		width: 36px;
		text-align: center
	}

	#chetview-details-tab3>thead>tr>th:nth-child(2) {
		background-color: #f0f0f0;
		border-left: 2px #fff solid;
		width: 10%;
		text-align: left
	}

	#chetview-details-tab3>thead>tr>th:nth-child(3) {
		background-color: #f0f0f0;
		border-left: 2px #fff solid;
		width: 5%;
		text-align: center
	}

	#chetview-details-tab3>thead>tr>th:nth-child(4) {
		background-color: #f0f0f0;
		border-left: 2px #fff solid;
		text-align: left
	}

	#chetview-details-tab3>thead>tr>th:nth-child(5) {
		background-color: #f0f0f0;
		border-left: 2px #fff solid;
		width: 15%;
		text-align: left
	}

	#chetview-details-tab3>thead>tr>th:nth-child(6) {
		background-color: #f0f0f0;
		border-left: 2px #fff solid;
		width: 15%;
		text-align: left
	}

	#chetview-details-tab3>thead>tr>th:nth-child(7) {
		background-color: #f0f0f0;
		border-left: 2px #fff solid;
		width: 15%;
		text-align: left
	}

	/*
/*
/* Тело таблицы */
	#chetview-details-tab3>tbody {
		font-family: courier, courier new, serif;
		color: #333;
		border-bottom: none;
		border-top: none
	}

	#chetview-details-tab3>tbody>tr>td {
		border-bottom: none;
		padding: 5px 8px;
		line-height: 1.42857143;
		vertical-align: middle
	}

	#chetview-details-tab3>tbody>tr>td:first-child {
		width: 36px;
		text-align: center
	}

	#chetview-details-tab3>tbody>tr>td:nth-child(2) {
		width: 10%;
		text-align: left
	}

	#chetview-details-tab3>tbody>tr>td:nth-child(3) {
		width: 5%;
		text-align: center
	}

	#chetview-details-tab3>tbody>tr>td:nth-child(4) {
		text-align: left
	}

	#chetview-details-tab3>tbody>tr>td:nth-child(5) {
		width: 15%;
		text-align: left
	}

	#chetview-details-tab3>tbody>tr>td:nth-child(6) {
		width: 15%;
		text-align: left
	}

	#chetview-details-tab3>tbody>tr>td:nth-child(7) {
		width: 15%;
		text-align: left
	}

	#chetview-details-tab3>tbody>tr>td.dataTables_empty {
		text-align: center;
		border-bottom: 1px #951402 solid;
		border-top: 1px #951402 solid;
		text-transform: uppercase;
		font-style: italic;
		color: #951402
	}

	#chetview-details-tab3>tbody>tr>td.chetview-details-tab3-id {
		font-weight: 300;
		font-size: 1.3em;
		text-transform: uppercase;
		text-align: left;
		border-left: 5px #336a86 solid
	}

	#chetview-details-tab3>tbody>tr>td.chetview-details-tab3-zayvtel {
		font-weight: 300;
		font-size: 1.3em;
		text-transform: none
	}

	#chetview-details-tab3>tbody>tr>td.chetview-details-tab3-zayvnum {
		font-weight: 300;
		font-size: 1.3em;
		text-transform: none
	}

	#chetview-details-tab3>tbody>tr>td.chetview-details-tab3-zayvdesc {
		font-weight: 300;
		font-size: 1.3em;
		text-transform: none
	}

	#chetview-details-tab3>tbody>tr>td {
		border-top: none
	}

	#chetview-details-tab3>tbody>tr.shown>td {
		background-color: #336a86;
		color: #fff;
		font-weight: 300
	}

	#chetview-details-tab3>tbody>tr>td a.zayv-link {
		text-decoration: underline;
		color: #336a86
	}

	#chetview-details-tab3>tbody>tr>td a.zayv-link:hover {
		text-decoration: none
	}

	#chetview-details-tab3>tbody>tr>td.chetview-details-tab3-doczayvchet-collapse {
		padding: 0
	}

	/*
/*
/* Подвал таблицы */

	/*
/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----

ТАБЛИЦА "СЧЕТА COLLAPSE"

----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
	/*
/*
/* Общее для таблицы */
	#chetview-details-tab3-doczayvchet-collapse-table {
		margin-bottom: 0
	}

	/*
/*
/* Заголовок таблицы */
	#chetview-details-tab3-message-table>thead>tr>th {
		border-bottom: none;
		border-top: none
	}

	#chetview-details-tab3-doczayvchet-collapse-table>thead {
		background-color: #f7f7f7;
		color: #111
	}

	#chetview-details-tab3-doczayvchet-collapse-table>thead>tr>th {
		font-weight: 700;
		border-bottom: none;
		border-top: 2px #fff solid
	}

	#chetview-details-tab3-doczayvchet-collapse-table>thead>tr>th:first-child {
		width: 5%;
		text-align: center
	}

	#chetview-details-tab3-doczayvchet-collapse-table>thead>tr>th:nth-child(2) {
		width: 10%;
		text-align: left
	}

	#chetview-details-tab3-doczayvchet-collapse-table>thead>tr>th:nth-child(3) {
		width: 15%;
		text-align: left
	}

	#chetview-details-tab3-doczayvchet-collapse-table>thead>tr>th:nth-child(4) {
		width: 20%;
		text-align: left
	}

	#chetview-details-tab3-doczayvchet-collapse-table>thead>tr>th:nth-child(5) {
		width: 15%;
		text-align: right
	}

	#chetview-details-tab3-doczayvchet-collapse-table>thead>tr>th:nth-child(6) {
		width: 10%;
		text-align: center
	}

	#chetview-details-tab3-doczayvchet-collapse-table>thead>tr>th:nth-child(7) {
		width: 25%;
		text-align: left
	}

	/*
/*
/* Тело таблицы */
	#chetview-details-tab3-message-table>tbody>tr>td {
		border-bottom: none;
		border-top: none
	}

	#chetview-details-tab3-doczayvchet-collapse-table>tbody>tr>td {
		font-family: courier, courier new, serif;
		border-bottom: none;
		border-top: none
	}

	#chetview-details-tab3-doczayvchet-collapse-table>tbody>tr>td {
		font-family: courier, courier new, serif;
		border-bottom: none;
		border-top: none
	}

	#chetview-details-tab3-doczayvchet-collapse-table>tbody>tr>td:first-child {
		width: 5%;
		text-align: center
	}

	#chetview-details-tab3-doczayvchet-collapse-table>tbody>tr>td:nth-child(2) {
		width: 10%;
		text-align: left
	}

	#chetview-details-tab3-doczayvchet-collapse-table>tbody>tr>td:nth-child(3) {
		width: 15%;
		text-align: left
	}

	#chetview-details-tab3-doczayvchet-collapse-table>tbody>tr>td:nth-child(4) {
		width: 20%;
		text-align: left
	}

	#chetview-details-tab3-doczayvchet-collapse-table>tbody>tr>td:nth-child(5) {
		width: 15%;
		text-align: right
	}

	#chetview-details-tab3-doczayvchet-collapse-table>tbody>tr>td:nth-child(6) {
		width: 10%;
		text-align: center
	}

	#chetview-details-tab3-doczayvchet-collapse-table>tbody>tr>td:nth-child(7) {
		width: 25%;
		text-align: left
	}

	#chetview-details-tab3-doczayvchet-collapse-table>tbody>tr>td a.chet-link {
		text-decoration: underline;
		color: #336a86
	}

	#chetview-details-tab3-doczayvchet-collapse-table>tbody>tr>td a.chet-link:hover {
		text-decoration: none
	}

	.chetview-details-tab3-message {
		font-family: 'Oswald', sans-serif;
		font-size: 1.3em;
		letter-spacing: 0.2em
	}

	/*
/*
/* Подвал таблицы */

	/*
/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----

ТАБЛИЦА "СЧЕТА-ФАКТУРЫ COLLAPSE"

----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
	#chetview-details-tab3-doczayvchet-collapse-table>tbody>tr>td.chetview-details-tab3-doczayvchetf-collapse-td {
		padding-left: 0;
		padding-right: 0
	}

	/*
/*
/* Общее для таблицы */
	#chetview-details-tab3-doczayvchetf-collapse-table {
		margin-bottom: 0;
		border: 2px #f1f1f1 solid;
		background-color: #fafafa;
	}

	/*
/*
/* Заголовок таблицы */

	/*
/*
/* Тело таблицы */
	#chetview-details-tab3-doczayvchetf-collapse-table>tbody>tr>td {
		font-family: courier, courier new, serif;
		border-bottom: none;
		border-top: none
	}

	#chetview-details-tab3-doczayvchetf-collapse-table>tbody>tr>td:first-child {
		width: 5%;
		text-align: center;
		background-color: #f1f1f1;
		color: #000
	}

	#chetview-details-tab3-doczayvchetf-collapse-table>tbody>tr>td:nth-child(2) {
		width: 10%;
		text-align: left
	}

	#chetview-details-tab3-doczayvchetf-collapse-table>tbody>tr>td:nth-child(3) {
		width: 15%;
		text-align: left
	}

	#chetview-details-tab3-doczayvchetf-collapse-table>tbody>tr>td:nth-child(4) {
		width: 20%;
		text-align: left
	}

	#chetview-details-tab3-doczayvchetf-collapse-table>tbody>tr>td:nth-child(5) {
		width: 15%;
		text-align: right
	}

	#chetview-details-tab3-doczayvchetf-collapse-table>tbody>tr>td:nth-child(6) {
		width: 10%;
		text-align: center
	}

	#chetview-details-tab3-doczayvchetf-collapse-table>tbody>tr>td:nth-child(7) {
		text-align: left
	}

	#chetview-details-tab3-doczayvchetf-collapse-table>tbody>tr>td a.chet-link {
		text-decoration: underline;
		color: #336a86
	}

	#chetview-details-tab3-doczayvchetf-collapse-table>tbody>tr>td a.chet-link:hover {
		text-decoration: none
	}

	#chetview-details-tab3-message-table>thead>tr>th,
	#chetview-details-tab3-message-table>tbody>tr>td {
		border-bottom: none;
		border-top: none
	}

	.chetview-details-tab3-message {
		font-family: 'Oswald', sans-serif;
		font-size: 1.3em;
		letter-spacing: 0.2em
	}

	/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----

ТАБЛИЦА "NO-СООБЩЕНИЕ COLLAPSE"

----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
	/*
/*
/* Общее для таблицы */
	#chetview-details-tab3-doczayvchet-msg-collapse-table {
		margin-bottom: 0
	}

	/*
/*
/* Заголовок таблицы */

	/*
/*
/* Тело таблицы */
	#chetview-details-tab3-doczayvchet-msg-collapse-table>tbody>tr>td {
		font-family: courier, courier new, serif;
		border-bottom: none;
		border-top: none
	}

	#chetview-details-tab3-doczayvchet-msg-collapse-table>tbody>tr>td:first-child {
		text-align: left
	}

	#chetview-details-tab3-doczayvchet-msg-collapse-table>tbody>tr>td:nth-child(2) {}
</style>

<section>

	<div class="" style="padding-left:5px; padding-right:5px">
		<div class="space50"></div>

		<?php
		//
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		// СЧЕТА-ФАКТУРЫ
		// :::
		$query_getDoczayv = mysqlQuery("
	SELECT dognet_doczayv.numberzayv as numberzayv, dognet_doczayv.kodzayv as kodzayv, dognet_doczayv.namerabfilespec as namerabfilespec, dognet_spzayvtel.namezayvtelshot as namezayvtelshot, dognet_sptipzayv.namezayvshot as namezayvshot, dognet_spispol.ispolnameshot as ispolnameshot, dognet_doczayv.datezayv as datezayv, dognet_sptipzayvall.nametipzayvshotall as nametipzayvshotall
	FROM dognet_doczayv
	LEFT JOIN dognet_sptipzayv ON dognet_doczayv.kodtipzayv = dognet_sptipzayv.kodtipzayv
	LEFT JOIN dognet_sptipzayvall ON dognet_doczayv.kodtipzayvall = dognet_sptipzayvall.kodtipzayvall
	LEFT JOIN dognet_spzayvtel ON dognet_doczayv.kodzayvtel = dognet_spzayvtel.kodzayvtel
	LEFT JOIN dognet_spispol ON dognet_doczayv.kodispol = dognet_spispol.kodispol
	WHERE dognet_doczayv.koddoc = " . $varKoddoc . " AND dognet_doczayv.koddel <> '99'");
		if (mysqli_num_rows($query_getDoczayv) >= 1) {
			$cntDoczayv = 0;
		?>
			<h3 class="chetview-details-tab3-title">Затраты по договору</h3>
			<table id="chetview-details-tab3" class="table" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th><span class='glyphicon glyphicon-option-vertical'></span></th>
						<th>ГРУППА</th>
						<th>№</th>
						<th>Описание</th>
						<th>Заявитель</th>
						<th>Исполнитель</th>
						<th>Дата заявки</th>
					</tr>
				</thead>
				<tbody>
					<?php
					while ($row_getDoczayv = mysqli_fetch_array($query_getDoczayv, MYSQLI_ASSOC)) {
						$kodzayv = $row_getDoczayv['kodzayv'];
					?>
						<tr style="background-color:#f7f7f7; color:#111">
							<td class="chetview-details-tab3"><a href="#tab3-zayvchet-row-<?php echo $row_getDoczayv['kodzayv']; ?>" data-toggle="collapse"><span class='glyphicon glyphicon-option-vertical'></span></a></td>
							<td class="chetview-details-tab3"><?php echo $row_getDoczayv['nametipzayvshotall']; ?></td>
							<td class="chetview-details-tab3"><?php echo $row_getDoczayv['numberzayv']; ?></td>
							<td class="chetview-details-tab3"><?php echo $row_getDoczayv['namerabfilespec']; ?></td>
							<td class="chetview-details-tab3"><?php echo $row_getDoczayv['namezayvtelshot']; ?></td>
							<td class="chetview-details-tab3"><?php echo $row_getDoczayv['ispolnameshot']; ?></td>
							<td class="chetview-details-tab3"><?php echo $row_getDoczayv['datezayv']; ?></td>
						</tr>
						<?php
						$cntDoczayv++;
						$query_getDoczayvchet = mysqlQuery("
			SELECT
			dognet_doczayvchet.kodzayvchet as kodzayvchet, dognet_doczayvchet.zayvchetdate as zayvchetdate, dognet_doczayvchet.zayvchetsumma as zayvchetsumma, dognet_doczayvchet.zayvchetnumber as zayvchetnumber, dognet_doczayvchet.zayvchetpr as zayvchetpr, dognet_doczayvchet.zayvchetcomment as zayvchetcomment, dognet_doczayvchet_files.file_url as doczayvchet_fileurl, sp_contragents.nameshort as nameshotpost
			FROM dognet_doczayvchet
			LEFT JOIN dognet_doczayvchet_files ON dognet_doczayvchet.kodzayvchet = dognet_doczayvchet_files.kodzayvchet
			LEFT JOIN sp_contragents ON dognet_doczayvchet.kodpost = sp_contragents.kodcontragent
			WHERE dognet_doczayvchet.kodzayv = " . $kodzayv . " AND dognet_doczayvchet.koddel <> '99'");
						if (mysqli_num_rows($query_getDoczayvchet) >= 1) {
						?>
							<tr id="tab3-zayvchet-row-<?php echo $row_getDoczayv['kodzayv']; ?>" class="collapse in">
								<td class="chetview-details-tab3"></td>
								<td colspan="6" class="chetview-details-tab3-doczayvchet-collapse">
									<table id="chetview-details-tab3-doczayvchet-collapse-table" class="table table-condensed" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th></th>
												<th>Дата</th>
												<th>Счет №</th>
												<th>Поставщик</th>
												<th>Сумма</th>
												<th>%</th>
												<th>Комментарий</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$sumChetsumma = 0;
											while ($row_getDoczayvchet = mysqli_fetch_array($query_getDoczayvchet, MYSQLI_ASSOC)) {
												$kodzayvchet = $row_getDoczayvchet['kodzayvchet'];
											?>
												<tr>
													<td><a href="#tab3-zayvchet-row-<?php echo $kodzayvchet; ?>" data-toggle="collapse"><span class='glyphicon glyphicon-option-vertical'></span></a></td>
													<td><?php echo $row_getDoczayvchet['zayvchetdate']; ?></td>
													<td><?php echo "<a href='" . $row_getDoczayvchet['doczayvchet_fileurl'] . "' class='chet-link' target='_blank'>" . $row_getDoczayvchet['zayvchetnumber'] . "</a>"; ?></td>
													<td><?php echo $row_getDoczayvchet['nameshotpost']; ?></td>
													<td><?php echo number_format((float)($row_getDoczayvchet['zayvchetsumma']), 2, '.', ' ') . $__dened; ?></td>
													<td><?php echo $row_getDoczayvchet['zayvchetpr'] . "%"; ?></td>
													<td><?php echo $row_getDoczayvchet['zayvchetcomment']; ?></td>
												</tr>
												<?php
												$query_getDoczayvchetf = mysqlQuery("
					SELECT
					dognet_doczayvchetf.zayvchetfnumber as zayvchetfnumber, dognet_doczayvchetf.zayvchetfdate as zayvchetfdate, dognet_doczayvchetf.zayvchetfsumma as zayvchetfsumma, dognet_doczayvchetf.zayvchetfcomment as zayvchetfcomment, dognet_doczayvchetf.namevaliduse as namevaliduse, dognet_doczayvchetf_files.file_url as doczayvchetf_fileurl
					FROM dognet_doczayvchetf
					LEFT JOIN dognet_doczayvchetf_files ON dognet_doczayvchetf.kodzayvchetf = dognet_doczayvchetf_files.kodzayvchetf
					WHERE dognet_doczayvchetf.kodzayvchet = " . $kodzayvchet . " AND dognet_doczayvchetf.koddel <> '99'");
												if (mysqli_num_rows($query_getDoczayvchetf) >= 1) {
												?>
													<tr id="tab3-zayvchet-row-<?php echo $kodzayvchet; ?>" class="collapse">
														<td colspan="7" class="chetview-details-tab3-doczayvchetf-collapse-td">
															<table id="chetview-details-tab3-doczayvchetf-collapse-table" class="table table-condensed" cellspacing="0" width="100%">
																<tbody>
																	<?php
																	while ($row_getDoczayvchetf = mysqli_fetch_array($query_getDoczayvchetf, MYSQLI_ASSOC)) {
																	?>
																		<tr>
																			<td>СФ</td>
																			<td><?php echo $row_getDoczayvchetf['zayvchetfdate']; ?></td>
																			<td><?php echo "<a href='" . $row_getDoczayvchetf['doczayvchetf_fileurl'] . "' class='chet-link' target='_blank'>" . $row_getDoczayvchetf['zayvchetfnumber'] . "</a>"; ?></td>
																			<td></td>
																			<td><?php echo number_format((float)($row_getDoczayvchetf['zayvchetfsumma']), 2, '.', ' ') . $__dened; ?></td>
																			<td></td>
																			<td><?php echo $row_getDoczayvchetf['namevaliduse']; ?></td>
																		</tr>
																	<?php
																	}
																	?>
																</tbody>
															</table>
														</td>
													</tr>
											<?php
												}
												$sumChetsumma += $row_getDoczayvchet['zayvchetsumma'];
											}
											?>
										</tbody>
									</table>
								</td>
							</tr>
						<?php
						} else {
						?>
							<tr id="tab3-zayvchet-row-<?php echo $row_getDoczayv['kodzayv']; ?>" class="collapse in">
								<td class="chetview-details-tab3"></td>
								<td colspan="6" class="chetview-details-tab3-doczayvchet-msg-collapse">
									<table id="chetview-details-tab3-doczayvchet-msg-collapse-table" class="table table-condensed" cellspacing="0" width="100%">
										<tr>
											<td class="chetview-details-tab3 text-left text-danger">Счетов по заявке не найдено</td>
										</tr>
				</tbody>
			</table>
			</td>
			</tr>
	<?php
						}
					}
	?>
	</tbody>
	</table>
<?php
		} else {
?>
	<table id="chetview-details-tab3-message-table" class="table table-condensed" cellspacing="0" width="100%">
		<tbody>
			<tr>
				<td class="chetview-details-tab3-message text-center text-danger">Расходов по обеспечению договора нет</td>
			</tr>
		</tbody>
	</table>
<?php
		}
?>

	</div>

</section>