
<?php
// ----- ----- ----- ----- -----
// Подключаем стили для таблиц
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-details/restr_5/tabs/css/docview-details-common-tab2_chetf.css">

<section>
	<div class="" style="padding-left:5px; padding-right:5px">
<?php
//
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// СЧЕТА-ФАКТУРЫ
// :::
?>
		<h3 class="docview-details-title2">Выставленые счета-фактуры</h3>
		<table id="docview-details-tab2-chetfzadolg" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
					<th class="text-center">Этап</th>
					<th class="text-center">№</th>
					<th class="text-center">Дата счета</th>
					<th class="text-center">Сумма счета</th>
					<th class="text-center">Оплачено</th>
					<th class="text-center">Зачтено</th>
					<th class="text-center">Задолженность</th>
				</tr>
			</thead>
			<tbody>
<?php
	$query_getKalplan = mysqlQuery( "SELECT kodkalplan, numberstage, nameshotstage, namefullstage, dateplan, summastage FROM dognet_dockalplan WHERE koddoc = ".$varKoddoc." AND koddel <> '99'" );
	if (mysqli_num_rows($query_getKalplan) >= 1) {
//
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Блок вывода счетов-фактур для договоров с календарным планом (этапами)
// BEGIN ::: BLOCK CHF_1
		$cntChetf = 0;
		while ($row_getKalplan = mysqli_fetch_array($query_getKalplan, MYSQLI_ASSOC)) {
			$kodkalplan = $row_getKalplan['kodkalplan'];
?>
				<tr style="background-color:#f7f7f7; color:#111">
					<td class="docview-details-tab2-chetfzadolg text-center" style="font-size:1.0em; font-weight:700; border-bottom:none"><a href="#tab2-chetf-row-<?php echo $row_getKalplan['kodkalplan']; ?>" data-toggle="collapse"><span class='glyphicon glyphicon-option-vertical'></span></a></td>
					<td class="docview-details-tab2-chetfzadolg-numberstage text-center" style="font-size:1.0em; font-weight:700; border-bottom:none"><?php echo $row_getKalplan['numberstage']; ?></td>
					<td colspan="6" class="docview-details-tab2-chetfzadolg-namestage text-left" style="font-size:1.0em; font-weight:700; border-bottom:none"><?php echo ($row_getKalplan['namefullstage']!="") ? $row_getKalplan['namefullstage'] : $row_getKalplan['nameshotstage']; ?></td>
				</tr>
<?php
			// Выбираем выставленные счета-фактуры по текущему календарному плану (этапу)
			$query_getChetf = mysqlQuery( "SELECT kodchfact, chetfnumber, chetfdate, chetfsumma, comment FROM dognet_kalplanchf WHERE kodkalplan = ".$kodkalplan." AND koddel <> '99'" );
			if (mysqli_num_rows($query_getChetf) >= 1) {
?>
				<tr id="tab2-chetf-row-<?php echo $row_getKalplan['kodkalplan']; ?>" class="collapse in">
					<td colspan="8" class="docview-details-tab2-chetfzadolg-collapse">
						<table id="docview-details-tab2-chetfzadolg-collapse-table" class="table table-responsive display compact" cellspacing="0" width="100%">
							<tbody>
<?php
				while ($row_getChetf = mysqli_fetch_array($query_getChetf, MYSQLI_ASSOC)) {
					$kodchfact = $row_getChetf['kodchfact'];
?>
								<tr>
									<td class="docview-details-tab2-chetfzadolg-numberstage text-center"></td>
									<td class="docview-details-tab2-chetfzadolg-numberstage text-center">СФ</td>
									<td class="docview-details-tab2-chetfzadolg-numberstage text-center"><?php echo $row_getChetf['chetfnumber']; ?></td>
									<td class="docview-details-tab2-chetfzadolg-dateplan text-left"><?php echo date("d.m.Y", strtotime($row_getChetf['chetfdate'])); ?></td>
									<td class="docview-details-tab2-chetfzadolg-summastage text-right"><?php echo number_format((float)($row_getChetf['chetfsumma']), 2, '.', ' ').$__dened; ?></td>
									<td class="docview-details-tab2-chetfzadolg-summastage text-right"><?php echo number_format((float)(ChetfOplata($row_getChetf['kodchfact'])), 2, '.', ' ').$__dened; ?></td>
									<td class="docview-details-tab2-chetfzadolg-summastage text-right"><?php echo number_format((float)(ChetfAvans($row_getChetf['kodchfact'])), 2, '.', ' ').$__dened; ?></td>
									<td class="docview-details-tab2-chetfzadolg-summastage <?php echo (ChetfZadolg($row_getChetf['kodchfact']) <> 0 ? 'text-danger' : 'text-default'); ?> text-right"><?php echo number_format((float)(ChetfZadolg($row_getChetf['kodchfact'])), 2, '.', ' ').$__dened; ?></td>
								</tr>
<?php
				// В таблице dognet_oplatachf находим все оплаченные счета-фактуры с кодом kodchfact и суммируем
					$query_getOplatachf = mysqlQuery( "SELECT dateopl, summaopl, comment FROM dognet_oplatachf WHERE kodchfact =".$kodchfact." AND koddel <> '99'" );
					while ($row_getOplatachf = mysqli_fetch_array($query_getOplatachf, MYSQLI_ASSOC)) {
?>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td class="docview-details-tab2-chetfzadolg-namestage text-right">Оплата от <?php echo date("d.m.Y", strtotime($row_getOplatachf['dateopl'])); ?></td>
									<td></td>
									<td class="docview-details-tab2-chetfzadolg-summastage text-right"><?php echo number_format((float)($row_getOplatachf['summaopl']), 2, '.', ' ').$__dened; ?></td>
									<td colspan="2"></td>
								</tr>
<?php
					}
					// В таблице dognet_oplatachf находим все оплаченные счета-фактуры с кодом kodchfact и суммируем
					$query_getAvanschf = mysqlQuery( "SELECT summaoplav FROM dognet_chfavans WHERE kodchfact =".$kodchfact." AND koddel <> '99' AND summaoplav <> 0" );
					while ($row_getAvanschf = mysqli_fetch_array($query_getAvanschf, MYSQLI_ASSOC)) {
?>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td class="docview-details-tab2-chetfzadolg-namestage text-right">Зачтено из аванса</td>
									<td></td>
									<td></td>
									<td class="docview-details-tab2-chetfzadolg-summastage text-right"><?php echo number_format((float)($row_getAvanschf['summaoplav']), 2, '.', ' ').$__dened; ?></td>
									<td></td>
								</tr>
<?php
					}
				}
?>
							</tbody>
						</table>
					</td>
				</tr>
<?php
			}
			else {
?>
				<tr id="tab2-chetf-row-<?php echo $row_getKalplan['kodkalplan']; ?>" class="collapse in">
					<td class="docview-details-tab2"></td>
					<td class="docview-details-tab2"></td>
					<td colspan="6" class="docview-details-tab2-chetfzadolg-collapse">
						<table id="docview-details-tab2-chetfzadolg-collapse-table" class="table table-responsive display compact" cellspacing="0" width="100%">
							<tbody>
								<tr>
									<td class="docview-details-tab2-message text-left text-danger" style="text-align:left">Счетов-фактур по данному этапу не выставлялось...</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
<?php
			}
		}
?>
					</td>
				</tr>
			</tbody>
		</table>
<?php
// END ::: BLOCK CHF_1
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
//
	}
	else {
//
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Блок вывода счетов-фактур для договоров без календарного плана (этапов)
// BEGIN ::: BLOCK CHF_0
?>
				<tr style="background-color:#f7f7f7; color:#111">
					<td colspan="8" class="docview-details-tab2-nokalplan text-left" style="font-size:1.0em; font-weight:700; text-align:left">Без этапа</td>
				</tr>
<?php
			// Выбираем выставленные счета-фактуры по текущему календарному плану (этапу)
			$query_getChetf = mysqlQuery( "SELECT kodchfact, chetfnumber, chetfdate, chetfsumma, comment FROM dognet_kalplanchf WHERE kodkalplan = ".$varKoddoc." AND koddel <> '99'" );
			if (mysqli_num_rows($query_getChetf) >= 1) {
?>
				<tr id="tab2-chetf-row-<?php echo $varKoddoc; ?>" class="collapse in">
					<td colspan="8" class="docview-details-tab2-chetfzadolg-collapse">
						<table id="docview-details-tab2-chetfzadolg-collapse-table" class="table table-responsive display compact" cellspacing="0" width="100%">
							<tbody>
<?php
				while ($row_getChetf = mysqli_fetch_array($query_getChetf, MYSQLI_ASSOC)) {
					$kodchfact = $row_getChetf['kodchfact'];
?>
								<tr>
									<td class="docview-details-tab2-chetfzadolg-numberstage text-center"></td>
									<td class="docview-details-tab2-chetfzadolg-numberstage text-center">СФ</td>
									<td class="docview-details-tab2-chetfzadolg-numberstage text-center"><?php echo $row_getChetf['chetfnumber']; ?></td>
									<td class="docview-details-tab2-chetfzadolg-dateplan text-left"><?php echo date("d.m.Y", strtotime($row_getChetf['chetfdate'])); ?></td>
									<td class="docview-details-tab2-chetfzadolg-summastage text-right"><?php echo number_format((float)($row_getChetf['chetfsumma']), 2, '.', ' ').$__dened; ?></td>
									<td class="docview-details-tab2-chetfzadolg-summastage text-right"><?php echo number_format((float)(ChetfOplata($row_getChetf['kodchfact'])), 2, '.', ' ').$__dened; ?></td>
									<td class="docview-details-tab2-chetfzadolg-summastage text-right"><?php echo number_format((float)(ChetfAvans($row_getChetf['kodchfact'])), 2, '.', ' ').$__dened; ?></td>
									<td class="docview-details-tab2-chetfzadolg-summastage <?php echo (ChetfZadolg($row_getChetf['kodchfact']) <> 0 ? 'text-danger' : 'text-default'); ?> text-right"><?php echo number_format((float)(ChetfZadolg($row_getChetf['kodchfact'])), 2, '.', ' ').$__dened; ?></td>
								</tr>
<?php
				// В таблице dognet_oplatachf находим все оплаченные счета-фактуры с кодом kodchfact и суммируем
					$query_getOplatachf = mysqlQuery( "SELECT dateopl, summaopl, comment FROM dognet_oplatachf WHERE kodchfact =".$kodchfact." AND koddel <> '99'" );
					while ($row_getOplatachf = mysqli_fetch_array($query_getOplatachf, MYSQLI_ASSOC)) {
?>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td class="docview-details-tab2-chetfzadolg-namestage text-right">Оплата от <?php echo date("d.m.Y", strtotime($row_getOplatachf['dateopl'])); ?></td>
									<td></td>
									<td class="docview-details-tab2-chetfzadolg-summastage text-right"><?php echo number_format((float)($row_getOplatachf['summaopl']), 2, '.', ' ').$__dened; ?></td>
									<td colspan="2"></td>
								</tr>
<?php
					}
					// В таблице dognet_oplatachf находим все оплаченные счета-фактуры с кодом kodchfact и суммируем
					$query_getAvanschf = mysqlQuery( "SELECT summaoplav FROM dognet_chfavans WHERE kodchfact =".$kodchfact." AND koddel <> '99' AND summaoplav <> 0" );
					while ($row_getAvanschf = mysqli_fetch_array($query_getAvanschf, MYSQLI_ASSOC)) {
?>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td class="docview-details-tab2-chetfzadolg-namestage text-right">Зачтено из аванса</td>
									<td></td>
									<td></td>
									<td class="docview-details-tab2-chetfzadolg-summastage text-right"><?php echo number_format((float)($row_getAvanschf['summaoplav']), 2, '.', ' ').$__dened; ?></td>
									<td></td>
								</tr>
<?php
					}
				}
?>
							</tbody>
						</table>
					</td>
				</tr>
<?php
			}
			else {
?>
				<tr id="tab2-chetf-row-<?php echo $varKoddoc; ?>" class="collapse in">
					<td class="docview-details-tab2"></td>
					<td class="docview-details-tab2"></td>
					<td colspan="6" class="docview-details-tab2-chetfzadolg-collapse">
						<table id="docview-details-tab2-chetfzadolg-collapse-table" class="table table-responsive display compact" cellspacing="0" width="100%">
							<tbody>
								<tr>
									<td class="docview-details-tab2-message text-left text-danger" style="text-align:left">Счетов-фактур по данному этапу не выставлялось...</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
<?php
			}
?>
					</td>
				</tr>
			</tbody>
		</table>
<?php
// END ::: BLOCK CHF_0
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
//
	}
?>
	</div>
</section>
