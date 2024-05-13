<?php
// ----- ----- ----- ----- -----
// Подключаем стили для таблиц
// :::
?>
<link rel="stylesheet"
      href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-details/restr_3/tabs/css/docview-details-common-tab2_progress.css">

<section>
    <div class="" style="padding-left:5px; padding-right:5px">
        <h3 class="docview-details-title2">Выполнение по этапам</h3>
        <div class="demo-html"></div>
        <table id="docview-details-tab2" class="table table-responsive table-bordered display compact" cellspacing="0"
               width="100%">
            <thead>
                <tr>
                    <th>Этап</th>
                    <th>Краткое наименование этапа</th>
                    <th>1й аванс</th>
                    <th>Срок</th>
                    <th class="text-center">Сумма этапа</th>
                    <th class="text-center">Закрыто</th>
                    <th class="text-center">Не закрыто</th>
                    <th class="text-center">Гарантия до</th>
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
					$firstavans = $dateavans->format('d.m.Y');
					if (is_string($srokstage)) { $srokdays = (int)$srokstage; }
					$expiry_date = $dateavans->add(new DateInterval('P'.$srokdays.'D'))->format('d.m.Y');
				}
				elseif ($row_getKalplan['idsrokstage']==1) {
					$firstavans = $dateavans->format('d.m.Y');
					$expiry_date = $srokstage;
				}
			}
			else {
				if ($srokstage!=NULL&&$srokstage!="") {
					$expiry_date = $srokstage;
				}
				else {
					if ($row_getKalplan['dateplan']!=NULL&&$row_getKalplan['dateplan']!="") {
						$expiry_date = date("d/m/Y", $row_getKalplan['dateplan']);
					}
					else {
						$expiry_date = "---";
					}
				}
				$firstavans = "---";
			}
						# ----- ----- ----- ----- -----
						#	Вычисляем дату окончания гарантии по его сроку в месяцах
						# ----- ----- ----- ----- -----
						$query_checkChf = mysqlQuery("SELECT MIN(chetfdate) as stageEndWork FROM dognet_kalplanchf WHERE kodkalplan = " . $kodkalplan . " AND koddel <> '99'");
						$row_checkChf = mysqli_fetch_assoc($query_checkChf);
						if ($row_checkChf['stageEndWork'] != NULL) {
							$date1chf = new DateTime($row_checkChf['stageEndWork']);
							// Нужно теперь определить срок выполнения этапа (если он был задан в днях)
							if ($row_getKalplan['warranty_period'] != 0) {
								$firstchf = $date1chf->format('d.m.Y');
								$srokdays = (int)0;
								if (is_string($row_getKalplan['warranty_period'])) {
									$srokdays = (int)$row_getKalplan['warranty_period'];
								}
								$expiry_warranty = $date1chf->add(new DateInterval('P' . $srokdays . 'M'))->format('d.m.Y');
							} else {
								$expiry_warranty = "---";
							}
						} else {
							$expiry_warranty = "Нет СФ";
						}

# ----- ----- ----- ----- -----
?>
                <tr>
                    <td class="docview-details-tab2-numberstage text-center">
                        <?php echo $row_getKalplan['numberstage']; ?></td>
                    <td class="docview-details-tab2-namestage text-left"><?php echo $row_getKalplan['nameshotstage']; ?>
                    </td>
                    <td class="docview-details-tab2-dateplan text-left"><?php echo $firstavans; ?></td>
                    <td class="docview-details-tab2-dateplan text-left"><?php echo $expiry_date; ?></td>
                    <td class="docview-details-tab2-summastage text-right">
                        <?php echo number_format((float)($row_getKalplan['summastage']), 2, '.', ' ').$__dened; ?></td>
                    <td class="docview-details-tab2-summastage text-right">
                        <?php echo number_format((float)(StageSumChf($row_getKalplan['kodkalplan'])), 2, '.', ' ').$__dened; ?>
                    </td>
                    <td
                        class="docview-details-tab2-summastage <?php echo (StageZadolg($row_getKalplan['kodkalplan']) <> 0 ? 'text-danger' : 'text-default'); ?> text-right">
                        <?php echo number_format((float)(StageZadolg($row_getKalplan['kodkalplan'])), 2, '.', ' ').$__dened; ?>
                    </td>
                    <td class="docview-details-tab2-dateplan text-center"><?php echo $expiry_warranty; ?></td>
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
                    <th colspan="4" class="text-right text-uppercase text-right">Итоги по договору :</th>
                    <th class="docview-details-tab2-summastage text-right">
                        <?php echo number_format((float)($totalStage), 2, '.', ' ').$__dened; ?></th>
                    <th class="docview-details-tab2-summastage text-right">
                        <?php echo number_format((float)($totalSumChf), 2, '.', ' ').$__dened; ?></th>
                    <th
                        class="docview-details-tab2-summastage <?php echo ($totalZadolg <> 0 ? 'text-danger' : 'text-default'); ?> text-right">
                        <?php echo number_format((float)($totalZadolg), 2, '.', ' ').$__dened; ?></th>
                </tr>
            </tfoot>
        </table>
        <table id="compact-legend-table" class="table table-responsive" cellspacing="0" width="100%">
            <tbody>
                <tr>
                    <td width="8%" valign="middle"><span class="label label-default text-uppercase">Закрыто</span></td>
                    <td width="2%"><span class=""></span></td>
                    <td><span>Сумма выставленных счетов-фактур по этапу.</span></td>
                </tr>
                <tr>
                    <td width="8%" valign="middle"><span class="label label-default text-uppercase">Не закрыто</span>
                    </td>
                    <td width="2%"><span class=""></span></td>
                    <td><span>Разница между суммой этапа и суммой выставленных счетов-фактур по этапу.</span></td>
                </tr>
                <tr>
                    <td width="8%" valign="middle"><span class="label label-default text-uppercase">Срок</span></td>
                    <td width="2%"><span class=""></span></td>
                    <td>
                        <span>1. Если срок выполнения этапа указан в виде даты (ДД/ММ/ГГГГ), то этот срок равен этой
                            дате.</span><br>
                        <span>2. Если срок выполнения этапа указан в днях, то этот срок равен дате 1-го аванса +
                            количество дней.</span><br>
                        <span>3. Если срок выполнения этапа не указан, то этот срок равен планируемой дате либо дате
                            конца года (31/12/ГГГГ).</span>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php
	}
	else {
?>
        <tr>
            <td colspan="6" class="docview-details-tab2-txt text-left text-danger" style="text-align:left">По данному
                договору этапы не определены</td>
        </tr>
        </tbody>
        </table>
        <?php
	}
?>
    </div>
</section>