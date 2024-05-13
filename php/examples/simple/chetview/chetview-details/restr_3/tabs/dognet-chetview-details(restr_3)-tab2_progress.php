<?php
// ----- ----- ----- ----- -----
// Подключаем стили для таблиц
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/chetview/chetview-details/restr_3/tabs/css/chetview-details-common-tab2_progress.css">

<section>
	<div class="" style="padding-left:5px; padding-right:5px">
		<h3 class="chetview-details-title2">Выполнение по этапам</h3>
		<div class="demo-html"></div>
		<table id="chetview-details-tab2" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>Этап</th>
					<th>Краткое наименование этапа</th>
					<th>Срок</th>
					<th class="text-center">Сумма этапа</th>
					<th class="text-center">Закрыто</th>
					<th class="text-center">Не закрыто</th>
				</tr>
			</thead>
			<tbody>
<?php
	$query_getKalplan = mysqlQuery( "SELECT * FROM dognet_dockalplan WHERE koddoc = ".$varKoddoc." AND koddel <> '99'" );
	$totalStage = 0.00;
	$totalSumChf = 0.00;
	$totalZadolg = 0.00;
	if (mysqli_num_rows($query_getKalplan) >= 1) {
		while ($row_getKalplan = mysqli_fetch_array($query_getKalplan, MYSQLI_ASSOC)) {
			$kodkalplan = $row_getKalplan['kodkalplan'];
			$srokstage = $row_getKalplan['srokstage'];
# ----- ----- ----- ----- -----
#	Проверяем наличие авансов по данному этапу и выбираем аванс поступивший ранее других
# ----- ----- ----- ----- -----
			$query_checkAvans = mysqlQuery( "SELECT MIN(dateavans) as stageStartWork FROM dognet_docavans WHERE koddoc = ".$kodkalplan." AND koddel <> '99'" );
			$row_checkAvans = mysqli_fetch_assoc($query_checkAvans);
			if($row_checkAvans['stageStartWork']!=NULL) {
				$dateavans = new DateTime($row_checkAvans['stageStartWork']);
			// Нужно теперь определить срок выполнения этапа (если он был задан в днях)
				if ($row_getKalplan['idsrokstage']==0) {
					$dateavans->add(new DateInterval('P'.$srokstage.'D'));
					$expiry_date = $dateavans->format('d.m.Y');
				}
				elseif ($row_getKalplan['idsrokstage']==1) {
					$expiry_date = $srokstage;
				}
			}
			else {
				$expiry_date = "---";
			}
# ----- ----- ----- ----- -----
?>
				<tr>
					<td class="chetview-details-tab2-numberstage text-center"><?php echo $row_getKalplan['numberstage']; ?></td>
					<td class="chetview-details-tab2-namestage text-left"><?php echo $row_getKalplan['nameshotstage']; ?></td>
					<td class="chetview-details-tab2-dateplan text-left"><?php echo $expiry_date; ?></td>
					<td class="chetview-details-tab2-summastage text-right"><?php echo number_format((float)($row_getKalplan['summastage']), 2, '.', ' ').$__dened; ?></td>
					<td class="chetview-details-tab2-summastage text-right"><?php echo number_format((float)(StageSumChf($row_getKalplan['kodkalplan'])), 2, '.', ' ').$__dened; ?></td>
					<td class="chetview-details-tab2-summastage <?php echo (StageZadolg($row_getKalplan['kodkalplan']) <> 0 ? 'text-danger' : 'text-default'); ?> text-right"><?php echo number_format((float)(StageZadolg($row_getKalplan['kodkalplan'])), 2, '.', ' ').$__dened; ?></td>
				</tr>
<?php
		// ----- ----- -----
			$totalStage += $row_getKalplan['summastage'];
			$totalSumChf += StageSumChf($row_getKalplan['kodkalplan']);
			$totalZadolg += StageZadolg($row_getKalplan['kodkalplan']);
		}
?>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="3" class="text-right text-uppercase text-right">Итоги по договору :</th>
					<th class="chetview-details-tab2-summastage text-right"><?php echo number_format((float)($totalStage), 2, '.', ' ').$__dened; ?></th>
					<th class="chetview-details-tab2-summastage text-right"><?php echo number_format((float)($totalSumChf), 2, '.', ' ').$__dened; ?></th>
					<th class="chetview-details-tab2-summastage <?php echo ($totalZadolg <> 0 ? 'text-danger' : 'text-default'); ?> text-right"><?php echo number_format((float)($totalZadolg), 2, '.', ' ').$__dened; ?></th>
				</tr>
			</tfoot>
		</table>
<?php
	}
	else {
?>
				<tr>
					<td colspan="6" class="chetview-details-tab2-message text-left text-danger" style="text-align:left">По данному договору этапы не определены</td>
				</tr>
			</tbody>
		</table>
<?php
	}
?>
	</div>
</section>
