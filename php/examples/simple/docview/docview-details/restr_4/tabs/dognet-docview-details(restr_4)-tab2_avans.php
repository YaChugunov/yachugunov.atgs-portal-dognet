<?php
// ----- ----- ----- ----- -----
// Подключаем стили для таблиц
// :::
?>
<link rel="stylesheet"
  href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-details/restr_4/tabs/css/docview-details-common-tab2_avans.css">

<section>
  <div class="" style="padding-left:5px; padding-right:5px">
    <?php
		//
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		// АВАНСОВЫЕ ПЛАТЕЖИ
		// :::
		?>
    <h3 class="docview-details-title2">Авансовые платежи</h3>
    <table id="docview-details-tab2-avans" class="table table-responsive table-bordered display compact" cellspacing="0"
      width="100%">
      <thead>
        <tr>
          <th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
          <th class="text-center">Этап</th>
          <th class="text-left">Дата аванса</th>
          <th class="text-center"></th>
          <th class="text-center">Сумма аванса</th>
          <th class="text-center">Зачтено</th>
          <th class="text-center">Остаток</th>
        </tr>
      </thead>
      <tbody>
        <?php
				// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
				// Выбираем календарные планы (этапы) по договору
				$query_getKalplan = mysqlQuery("SELECT kodkalplan, numberstage, nameshotstage, namefullstage, dateplan, summastage FROM dognet_dockalplan WHERE koddoc = " . $varKoddoc . " AND koddel <> '99'");
				if (mysqli_num_rows($query_getKalplan) >= 1) {
					//
					//
					// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
					// Блок вывода авансовых платежей для договоров с календарным планом (этапами)
					// BEGIN ::: BLOCK AV_1
					$cntDocavans = 0;
					$_SUMAV_ALL = 0;
					$_SUMAVCHF_ALL = 0;
					$_SUMOST_ALL = 0;
					while ($row_getKalplan = mysqli_fetch_array($query_getKalplan, MYSQLI_ASSOC)) {
						$kodkalplan = $row_getKalplan['kodkalplan'];
				?>
        <tr style="background-color:#f7f7f7; color:#111">
          <td class="docview-details-tab2 text-center" style="font-size:1.0em; font-weight:700"><a
              href="#tab2-avans-row-<?php echo $row_getKalplan['kodkalplan']; ?>" data-toggle="collapse"><span
                class='glyphicon glyphicon-option-vertical'></span></a></td>
          <td class="docview-details-tab2-avans-numberstage" style="font-size:1.0em; font-weight:700">
            <?php echo $row_getKalplan['numberstage']; ?></td>
          <td colspan="5" class="docview-details-tab2-namestage"
            style="font-size:1.0em; font-weight:700; text-align:left">
            <?php echo ($row_getKalplan['namefullstage'] != "") ? $row_getKalplan['namefullstage'] : $row_getKalplan['nameshotstage']; ?>
          </td>
        </tr>
        <?php
						// Выбираем полученные авансы по текущему календарному плану (этапу)
						$query_getDocavans = mysqlQuery("SELECT kodavans, dateavans, nameavans, summaavans, comment FROM dognet_docavans WHERE koddoc = " . $kodkalplan . " AND koddel <> '99'");
						$cntDocavans += mysqli_num_rows($query_getDocavans);
						$_SUMAV_STAGE = 0;
						$_SUMAVCHF_STAGE = 0;
						$_SUMOST_STAGE = 0;
						if (mysqli_num_rows($query_getDocavans) >= 1) {
						?>
        <tr id="tab2-avans-row-<?php echo $row_getKalplan['kodkalplan']; ?>" class="collapse in">
          <td class="docview-details-tab2"></td>
          <td class="docview-details-tab2"></td>
          <td colspan="5" class="docview-details-tab2-avans-collapse">
            <table id="docview-details-tab2-avans-collapse-table" class="table table-responsive display compact"
              cellspacing="0" width="100%">
              <tbody>
                <?php
											while ($row_getDocavans = mysqli_fetch_array($query_getDocavans, MYSQLI_ASSOC)) {
												$kodavans = $row_getDocavans['kodavans'];
												$query_getAvanschf = mysqlQuery("SELECT SUM(summaoplav) as sum1 FROM dognet_chfavans WHERE kodavans =" . $kodavans . " AND koddel <> '99'");
												$row_getAvanschf = mysqli_fetch_array($query_getAvanschf, MYSQLI_ASSOC);
											?>
                <tr>
                  <td class="docview-details-tab2-avans-dateplan">
                    <?php echo date("d.m.Y", strtotime($row_getDocavans['dateavans'])); ?></td>
                  <td class=""><?php echo $row_getDocavans['nameavans']; ?></td>
                  <td class="docview-details-tab2-avans-summastage">
                    <?php echo number_format((float)($row_getDocavans['summaavans']), 2, '.', ' ') . $__dened; ?></td>
                  <td class="docview-details-tab2-avans-summastage">
                    <?php echo number_format((float)($row_getAvanschf['sum1']), 2, '.', ' ') . $__dened; ?></td>
                  <td
                    class="docview-details-tab2-avans-summastage <?php echo (($row_getDocavans['summaavans'] - $row_getAvanschf['sum1']) <> 0 ? 'text-danger' : 'text-default'); ?> text-right">
                    <?php echo number_format((float)($row_getDocavans['summaavans'] - $row_getAvanschf['sum1']), 2, '.', ' ') . $__dened; ?>
                  </td>
                </tr>
                <?php
												$_SUMAV_STAGE +=  $row_getDocavans['summaavans'];
												$_SUMAVCHF_STAGE +=  $row_getAvanschf['sum1'];
											} // while ($row_getDocavans)
											$_SUMOST_STAGE = $_SUMAV_STAGE - $_SUMAVCHF_STAGE;
											?>
              </tbody>
            </table>
          </td>
        </tr>
        <?php
						} // if ($query_getDocavans)
						else {
						?>
        <tr id="tab2-avans-row-<?php echo $row_getKalplan['kodkalplan']; ?>" class="collapse in">
          <td class="text-center"></td>
          <td class="text-center"></td>
          <td colspan="5" class="docview-details-tab2-message text-danger" style="text-align:left">Авансовых платежей по
            данному этапу не поступало...</td>
        </tr>
        <?php
						} // else if ($query_getDocavans)
						$_SUMAV_ALL += $_SUMAV_STAGE;
						$_SUMAVCHF_ALL += $_SUMAVCHF_STAGE;
					} // while ($row_getKalplan)
					$_SUMOST_ALL = $_SUMAV_ALL - $_SUMAVCHF_ALL;
					if (checkIsItSuperadmin($_SESSION['id']) != 99) {
						?>

        <tr id="tab2-avans-row-sumallavans" class="">
          <td class="text-center"></td>
          <td class="text-center"></td>
          <td colspan="2" class="docview-details-tab2-message text-info lead" style="text-align:right">
            <span class=""><b>ИТОГО:</b></span>
          </td>
          <td class="text-center text-info">
            <b><?php echo number_format((float)($_SUMAV_ALL), 2, '.', ' ') . $__dened; ?></b>
          </td>
          <td class="text-center text-info">
            <b><?php echo number_format((float)($_SUMAVCHF_ALL), 2, '.', ' ') . $__dened; ?></b>
          </td>
          <td class="text-center text-info">
            <b><?php echo number_format((float)($_SUMOST_ALL), 2, '.', ' ') . $__dened; ?></b>
          </td>
        </tr>

        <?php
					}
					?>
      </tbody>
    </table>
    <?php
					// END ::: BLOCK AV_1
					// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
					//
					//
				} // if ($query_getKalplan)
				else {
					//
					//
					// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
					// Блок вывода авансовых платежей для договоров без календарного плана (этапов)
					// BEGIN ::: BLOCK AV_0
	?>
    <tr style="background-color:#f7f7f7; color:#111">
      <td colspan="7" class="docview-details-tab2-nokalplan text-left"
        style="font-size:1.0em; font-weight:700; text-align:left">Без этапа</td>
    </tr>
    <?php
					// Выбираем полученные авансы по текущему календарному плану (этапу)
					$query_getDocavans = mysqlQuery("SELECT kodavans, dateavans, nameavans, summaavans, comment FROM dognet_docavans WHERE koddoc = " . $varKoddoc . " AND koddel <> '99'");
					$_SUMAV_ALL = 0;
					$_SUMAVCHF_ALL = 0;
					$_SUMOST_ALL = 0;
					if (mysqli_num_rows($query_getDocavans) >= 1) {
		?>
    <tr id="tab2-avans-row-<?php echo $varKoddoc; ?>" class="collapse in">
      <td class="docview-details-tab2"></td>
      <td class="docview-details-tab2"></td>
      <td colspan="5" class="docview-details-tab2-avans-collapse">
        <table id="docview-details-tab2-avans-collapse-table" class="table" cellspacing="0" width="100%">
          <tbody>
            <?php
							while ($row_getDocavans = mysqli_fetch_array($query_getDocavans, MYSQLI_ASSOC)) {
								$kodavans = $row_getDocavans['kodavans'];
								$query_getAvanschf = mysqlQuery("SELECT SUM(summaoplav) as sum1 FROM dognet_chfavans WHERE kodavans =" . $kodavans . " AND koddel <> '99'");
								$row_getAvanschf = mysqli_fetch_array($query_getAvanschf, MYSQLI_ASSOC);
							?>
            <tr>
              <td class="docview-details-tab2-avans-dateplan">
                <?php echo date("d.m.Y", strtotime($row_getDocavans['dateavans'])); ?></td>
              <td class=""><?php echo $row_getDocavans['nameavans']; ?></td>
              <td class="docview-details-tab2-avans-summastage">
                <?php echo number_format((float)($row_getDocavans['summaavans']), 2, '.', ' ') . $__dened; ?></td>
              <td class="docview-details-tab2-avans-summastage">
                <?php echo number_format((float)($row_getAvanschf['sum1']), 2, '.', ' ') . $__dened; ?></td>
              <td
                class="docview-details-tab2-avans-summastage <?php echo (($row_getDocavans['summaavans'] - $row_getAvanschf['sum1']) <> 0 ? 'text-danger' : 'text-default'); ?> text-right">
                <?php echo number_format((float)($row_getDocavans['summaavans'] - $row_getAvanschf['sum1']), 2, '.', ' ') . $__dened; ?>
              </td>
            </tr>
            <?php
								$_SUMAV_ALL += $row_getDocavans['summaavans'];
								$_SUMAVCHF_ALL += $row_getAvanschf['sum1'];
								$_SUMOST_ALL += $_SUMAV_ALL - $_SUMAVCHF_ALL;
							} // while ($row_getDocavans)
							?>
          </tbody>
        </table>
      </td>
    </tr>
    <?php
					} // if ($query_getDocavans)
					else {
		?>
    <tr id="tab2-avans-row-<?php echo $row_getKalplan['kodkalplan']; ?>" class="collapse in">
      <td class="text-center"></td>
      <td class="text-center"></td>
      <td colspan="5" class="docview-details-tab2-message text-danger" style="text-align:left">Авансовых платежей по
        данному этапу не поступало...</td>
    </tr>
    <?php
					} // else if ($query_getDocavans)
					if (checkIsItSuperadmin($_SESSION['id']) == 1) {
		?>

    <tr id="tab2-avans-row-sumallavans" class="">
      <td class="text-center"></td>
      <td class="text-center"></td>
      <td colspan="2" class="docview-details-tab2-message text-info lead" style="text-align:right">
        <span class=""><b>ИТОГО:</b></span>
      </td>
      <td class="text-center text-info">
        <b><?php echo number_format((float)($_SUMAV_ALL), 2, '.', ' ') . $__dened; ?></b>
      </td>
      <td class="text-center text-info">
        <b><?php echo number_format((float)($_SUMAVCHF_ALL), 2, '.', ' ') . $__dened; ?></b>
      </td>
      <td class="text-center text-info">
        <b><?php echo number_format((float)($_SUMOST_ALL), 2, '.', ' ') . $__dened; ?></b>
      </td>
    </tr>

    <?php
					}
		?>
    </tbody>
    </table>
    <?php
					// END ::: BLOCK AV_0
					// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
					//
					//
				}
	?>
  </div>
</section>