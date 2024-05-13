<?php
#
#
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### #####
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### #####
#
function CALC_AV_SUMOPLCHF($kodchfsubpodr) {
  $_QRY = mysqlQuery("SELECT SUM(sumoplchfsubpodr) as SummaOplatChf FROM dognet_docoplchfsubpodr WHERE kodchfsubpodr=" . $kodchfsubpodr);
  $_ROW = mysqli_fetch_assoc($_QRY);
  if ($_QRY) {
    $__SummaOplatChf = $_ROW['SummaOplatChf'];
  } else {
    $__SummaOplatChf = "";
  }
  return $__SummaOplatChf;
}
#
#
#
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### #####
# СУММА СПЛИТОВ ПО ВЫБРАННОМУ АВАНСУ ($kodavsubpodr)
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### #####
#
function CALC_AV_SUM_SPLIT($db, $action, $id, $kodavsubpodr) {
  $sumsplit = 0;
  if ($action != "DEL") {
    $_QRY_ID_SPLIT = $db->sql("SELECT sumavsplit FROM dognet_docavsplitsubpodr WHERE id='{$id}'")->fetchAll();
    $sumsplit = !empty($_QRY_ID_SPLIT[0]['sumavsplit']) ? $_QRY_ID_SPLIT[0]['sumavsplit'] : 0;
  }
  $_QRY = $db->sql("SELECT SUM(sumavsplit) as sum FROM dognet_docavsplitsubpodr WHERE kodavsubpodr='{$kodavsubpodr}'")->fetchAll();
  if ($action == "PREDEL") {
    $result = !empty($_QRY[0]['sum']) ? ($_QRY[0]['sum'] - $sumsplit) : 0;
  } else {
    $result = !empty($_QRY[0]['sum']) ? $_QRY[0]['sum'] : 0;
  }
  return $result;
}
#
#
#
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### #####
# СУММА СПЛИТОВ ПО ВЫБРАННОМУ АВАНСУ ($kodavsubpodr), ЗАЧТЕННЫХ ПО СЧЕТУ-ФАКТУРЕ ($kodchfsubpodr)
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### #####
#
function CALC_AV_SUMCHF_SPLIT($db, $action, $id, $kodavsubpodr, $kodchfsubpodr) {
  $_QRY = $db->sql("SELECT SUM(sumavsplit) as sum FROM dognet_docavsplitsubpodr WHERE kodavsubpodr='{$kodavsubpodr}' AND kodchfsubpodr='{$kodchfsubpodr}'")->fetchAll();
  $result = !empty($_QRY[0]['sum']) ? $_QRY[0]['sum'] : 0;
  return $result;
}
#
#
#
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### #####
#
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### #####
#
function CALC_AV_SUMOST($db, $action, $id, $useavans, $kodavsubpodr) {
  $result = 0;
  if (!empty($kodavsubpodr)) {
    if (empty($useavans)) {
      $_QRY_AV = $db->sql("SELECT SUM(sumavsubpodr) as sumAv FROM dognet_docavsubpodr WHERE kodavsubpodr='{$kodavsubpodr}'")->fetchAll();
      $_QRY_CHFAV = $db->sql("SELECT SUM(sumchfavsubpodr) as sumAvChf FROM dognet_docavsubpodr WHERE kodavsubpodr='{$kodavsubpodr}' AND kodchfsubpodr<>''")->fetchAll();
      $sumAv = !empty($_QRY_AV[0]['sumAv']) ? $_QRY_AV[0]['sumAv'] : 0;
      $sumChfAv = !empty($_QRY_CHFAV[0]['sumAvChf']) ? $_QRY_CHFAV[0]['sumAvChf'] : 0;
      $result = $sumAv - $sumChfAv;
    } elseif (!empty($useavans) && $useavans == '1') {
      $_QRY_AV = $db->sql("SELECT SUM(sumavsubpodr) as sumAv FROM dognet_docavsubpodr WHERE kodavsubpodr='{$kodavsubpodr}'")->fetchAll();
      $_QRY_AV_SPLIT = $db->sql("SELECT SUM(sumavsplit) as sumAvSplit FROM dognet_docavsplitsubpodr WHERE kodavsubpodr='{$kodavsubpodr}'")->fetchAll();
      $_QRY_CHFAV_SPLIT = $db->sql("SELECT SUM(sumavsplit) as sumAvChfSplit FROM dognet_docavsplitsubpodr WHERE kodavsubpodr='{$kodavsubpodr}' AND kodchfsubpodr<>''")->fetchAll();

      if ($action != "DEL") {
        $_QRY_ID_SPLIT = $db->sql("SELECT sumavsplit FROM dognet_docavsplitsubpodr WHERE id='{$id}'")->fetchAll();
        $sumsplit = !empty($_QRY_ID_SPLIT[0]['sumavsplit']) ? $_QRY_ID_SPLIT[0]['sumavsplit'] : 0;
      }

      $sumAv = !empty($_QRY_AV[0]['sumAv']) ? $_QRY_AV[0]['sumAv'] : 0;
      $sumAvSplit = !empty($_QRY_AV_SPLIT[0]['sumAvSplit']) ? $_QRY_AV_SPLIT[0]['sumAvSplit'] : 0;
      $sumChfAvSplit = !empty($_QRY_CHFAV_SPLIT[0]['sumAvChfSplit']) ? $_QRY_CHFAV_SPLIT[0]['sumAvChfSplit'] : 0;
      $diff1 = $sumAvSplit - $sumChfAvSplit; // не зачтено в сплите
      $diff2 = $sumAv - $sumAvSplit; // остаток аванса

      if ($action == "PREDEL") {
        $result = ($sumAv - $sumChfAvSplit) + $sumsplit;
      } else {
        $result = $sumAv - $sumChfAvSplit;
      }
    } elseif (!empty($useavans) && $useavans == '2') {
      $_QRY_AV = $db->sql("SELECT SUM(sumavsubpodr) as sumAv FROM dognet_docavsubpodr WHERE
    kodavsubpodr='{$kodavsubpodr}'")->fetchAll();
      $_QRY_CHFAV = $db->sql("SELECT SUM(sumchfavsubpodr) as sumAvChf FROM dognet_docavsubpodr WHERE
    kodavsubpodr='{$kodavsubpodr}' AND kodchfsubpodr<>''")->fetchAll();
      $sumAv = !empty($_QRY_AV[0]['sumAv']) ? $_QRY_AV[0]['sumAv'] : 0;
      $sumChfAv = !empty($_QRY_CHFAV[0]['sumAvChf']) ? $_QRY_CHFAV[0]['sumAvChf'] : 0;
      $result = $sumAv - $sumChfAv;
    }
  }
  return $result;
}
#
#
#
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### #####
#
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### #####
#
function CALC_AV_SUMCHF($db, $action, $id, $useavans, $kodavsubpodr) {
  $result = 0;
  if (!empty($kodavsubpodr)) {
    if (empty($useavans)) {
      $_QRY_CHFAV = $db->sql("SELECT SUM(sumchfavsubpodr) as sumAvChf FROM dognet_docavsubpodr WHERE
      kodavsubpodr='{$kodavsubpodr}' AND kodchfsubpodr<>''")->fetchAll();
      $sumChfAv = !empty($_QRY_CHFAV[0]['sumAvChf']) ? $_QRY_CHFAV[0]['sumAvChf'] : 0;
      $result = $sumChfAv;
    } elseif (!empty($useavans) && $useavans == '1') {
      $_QRY_AV = $db->sql("SELECT SUM(sumavsubpodr) as sumAv FROM dognet_docavsubpodr WHERE
        kodavsubpodr='{$kodavsubpodr}'")->fetchAll();
      $_QRY_AV_SPLIT = $db->sql("SELECT SUM(sumavsplit) as sumAvSplit FROM dognet_docavsplitsubpodr WHERE
        kodavsubpodr='{$kodavsubpodr}'")->fetchAll();
      $_QRY_CHFAV_SPLIT = $db->sql("SELECT SUM(sumavsplit) as sumAvChfSplit FROM dognet_docavsplitsubpodr WHERE
        kodavsubpodr='{$kodavsubpodr}' AND kodchfsubpodr<>''")->fetchAll();

      if ($action != "DEL") {
        $_QRY_ID_SPLIT = $db->sql("SELECT sumavsplit FROM dognet_docavsplitsubpodr WHERE id='{$id}'")->fetchAll();
        $sumsplit = !empty($_QRY_ID_SPLIT[0]['sumavsplit']) ? $_QRY_ID_SPLIT[0]['sumavsplit'] : 0;
      }

      $sumAv = !empty($_QRY_AV[0]['sumAv']) ? $_QRY_AV[0]['sumAv'] : 0;
      $sumAvSplit = !empty($_QRY_AV_SPLIT[0]['sumAvSplit']) ? $_QRY_AV_SPLIT[0]['sumAvSplit'] : 0;
      $sumChfAvSplit = !empty($_QRY_CHFAV_SPLIT[0]['sumAvChfSplit']) ? $_QRY_CHFAV_SPLIT[0]['sumAvChfSplit'] : 0;

      if ($action == "PREDEL") {
        $result = $sumChfAvSplit - $sumsplit;
      } else {
        $result = $sumChfAvSplit;
      }
    } elseif (!empty($useavans) && $useavans == '2') {
      $_QRY_CHFAV = $db->sql("SELECT SUM(sumchfavsubpodr) as sumAvChf FROM dognet_docavsubpodr WHERE
          kodavsubpodr='{$kodavsubpodr}' AND kodchfsubpodr<>''")->fetchAll();
      $sumChfAv = !empty($_QRY_CHFAV[0]['sumAvChf']) ? $_QRY_CHFAV[0]['sumAvChf'] : 0;
      $result = $sumChfAv;
    }
  }
  return $result;
}
#
#
#
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### #####
#
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### #####
#
function UPDATE_CHFZADOL($db, $action, $id, $kodCHF_selected, $kodCHF_field) {

  $_QRY_AV = $db->sql("SELECT sumavsubpodr, sumsplitsubpodr, sumchfavsubpodr, kodchfsubpodr FROM dognet_docavsubpodr WHERE id='{$id}'")->fetchAll();
  $kodchfsubpodrDB = !empty($_QRY_AV[0]['kodchfsubpodr']) ? $_QRY_AV[0]['kodchfsubpodr'] : "";
  $sumavsubpodrDB = !empty($_QRY_AV[0]['sumavsubpodr']) ? $_QRY_AV[0]['sumavsubpodr'] : 0;
  $sumsplitsubpodrDB = !empty($_QRY_AV[0]['sumsplitsubpodr']) ? $_QRY_AV[0]['sumsplitsubpodr'] : 0;
  $sumchfavsubpodrDB = !empty($_QRY_AV[0]['sumchfavsubpodr']) ? $_QRY_AV[0]['sumchfavsubpodr'] : 0;

  $__sumchfsubpodr = 0;
  $__sumavans = 0;
  $__sumavsplit = 0;

  $_var1 = '-';
  $_var2 = '-';
  # ----- ----- ----- ----- -----
  # СЧЕТ-ФАКТУРА УЖЕ ЗАДАН И В ФОРМЕ НЕ ПУСТОЙ
  # 1. $_POST['kodchfsubpodr_selected'] есть
  # 2. $_POST['kodchfsubpodr_selected'] == $_POST['kodchfsubpodr_field']
  #
  if (!empty($_POST['kodchfsubpodr_field']) && !empty($_POST['kodchfsubpodr_selected'])) {
    $_QRY_1 = $db->sql("SELECT sumchfsubpodr FROM dognet_docchfsubpodr WHERE kodchfsubpodr='{$kodCHF_field}'")->fetchAll();
    if ($_QRY_1) {
      $__sumchfsubpodr = $_QRY_1[0]['sumchfsubpodr'];
    }
    $_QRY_2 = $db->sql("SELECT SUM(sumchfavsubpodr) as sumavans FROM dognet_docavsubpodr WHERE kodchfsubpodr='{$kodCHF_field}'")->fetchAll();
    if ($_QRY_2) {
      $__sumavans = $_QRY_2[0]['sumavans'];
    }
    $_QRY_3 = $db->sql("SELECT SUM(sumavsplit) as sumavsplit FROM dognet_docavsplitsubpodr WHERE kodchfsubpodr='{$kodCHF_field}'")->fetchAll();
    if ($_QRY_3) {
      $__sumavsplit = $_QRY_3[0]['sumavsplit'];
    }
    // Пересчитываем сумму задолженности по счету-фактуре
    if ($action == 'UPD' or $action == 'CRT') {
      // $_NEW_sumzadolchfsubpodr = '-1';
      $_NEW_sumzadolchfsubpodr = $__sumchfsubpodr - (CALC_AV_SUMOPLCHF($kodCHF_field) + $__sumavans +
        $__sumavsplit);
      $_var1 = "-1";
    }
    if ($action == 'PREDEL') {
      // $_NEW_sumzadolchfsubpodr = '-10';
      $_NEW_sumzadolchfsubpodr = $__sumchfsubpodr - (CALC_AV_SUMOPLCHF($kodCHF_field) + $__sumavans +
        $__sumavsplit) + $sumchfavsubpodrDB;
      $_var2 = "-10";
    }
    // Пишем новую задолженность по СФ
    $db->update('dognet_docchfsubpodr', array(
      'sumzadolchfsubpodr'    => $_NEW_sumzadolchfsubpodr,
      'comment'               => 'AV ' . $_var1 . ' / ' . $_var2,
    ), array('kodchfsubpodr'  => $kodCHF_field));
  }
  # ----- ----- ----- ----- -----
  # СЧЕТ-ФАКТУРА УЖЕ ЗАДАН И В ФОРМЕ НЕ ПУСТОЙ
  # 1. $_POST['kodchfsubpodr_selected'] есть
  # 2. $_POST['kodchfsubpodr_selected'] == $_POST['kodchfsubpodr_field']
  #
  elseif (!empty($_POST['kodchfsubpodr_field']) && empty($_POST['kodchfsubpodr_selected'])) {
    $_QRY_1 = $db->sql("SELECT sumchfsubpodr FROM dognet_docchfsubpodr WHERE kodchfsubpodr='{$kodCHF_field}'")->fetchAll();
    if ($_QRY_1) {
      $__sumchfsubpodr = $_QRY_1[0]['sumchfsubpodr'];
    }
    $_QRY_2 = $db->sql("SELECT SUM(sumchfavsubpodr) as sumavans FROM dognet_docavsubpodr WHERE kodchfsubpodr='{$kodCHF_field}'")->fetchAll();
    if ($_QRY_2) {
      $__sumavans = $_QRY_2[0]['sumavans'];
    }
    $_QRY_3 = $db->sql("SELECT SUM(sumavsplit) as sumavsplit FROM dognet_docavsplitsubpodr WHERE kodchfsubpodr='{$kodCHF_field}'")->fetchAll();
    if ($_QRY_3) {
      $__sumavsplit = $_QRY_3[0]['sumavsplit'];
    }
    // Пересчитываем сумму задолженности по счету-фактуре
    if ($action == 'UPD' or $action == 'CRT') {
      // $_NEW_sumzadolchfsubpodr = '-2';
      $_NEW_sumzadolchfsubpodr = $__sumchfsubpodr - (CALC_AV_SUMOPLCHF($kodCHF_field) + $__sumavans +
        $__sumavsplit);
      $_var1 = "-2";
    }
    if ($action == 'PREDEL') {
      // $_NEW_sumzadolchfsubpodr = '-20';
      $_NEW_sumzadolchfsubpodr = $__sumchfsubpodr - (CALC_AV_SUMOPLCHF($kodCHF_field) + $__sumavans +
        $__sumavsplit);
      $_var2 = "-20";
    }
    // Пишем новую задолженность по СФ
    $db->update('dognet_docchfsubpodr', array(
      'sumzadolchfsubpodr'    => $_NEW_sumzadolchfsubpodr,
      'comment'               => 'AV ' . $_var1 . ' / ' . $_var2 . ' >>> ' . $__sumchfsubpodr . ' - ( ' . CALC_AV_SUMOPLCHF($kodCHF_field) . ' + ' . $__sumavans . ' + ' . $__sumavsplit . ' ) + ' . $sumchfavsubpodrDB,
    ), array('kodchfsubpodr'  => $kodCHF_field));
  }
  # ----- ----- ----- ----- -----
  # СЧЕТ-ФАКТУРА УЖЕ ЗАДАН И В ФОРМЕ НЕ ПУСТОЙ
  # 1. $_POST['kodchfsubpodr_selected'] есть
  # 2. $_POST['kodchfsubpodr_selected'] == $_POST['kodchfsubpodr_field']
  #
  elseif (empty($_POST['kodchfsubpodr_field']) && !empty($_POST['kodchfsubpodr_selected'])) {
    $_QRY_1 = $db->sql("SELECT sumchfsubpodr FROM dognet_docchfsubpodr WHERE kodchfsubpodr='{$kodCHF_selected}'")->fetchAll();
    if ($_QRY_1) {
      $__sumchfsubpodr = $_QRY_1[0]['sumchfsubpodr'];
    }
    $_QRY_2 = $db->sql("SELECT SUM(sumchfavsubpodr) as sumavans FROM dognet_docavsubpodr WHERE kodchfsubpodr='{$kodCHF_selected}'")->fetchAll();
    if ($_QRY_2) {
      $__sumavans = $_QRY_2[0]['sumavans'];
    }
    $_QRY_3 = $db->sql("SELECT SUM(sumavsplit) as sumavsplit FROM dognet_docavsplitsubpodr WHERE kodchfsubpodr='{$kodCHF_selected}'")->fetchAll();
    if ($_QRY_3) {
      $__sumavsplit = $_QRY_3[0]['sumavsplit'];
    }
    // Пересчитываем сумму задолженности по счету-фактуре
    if ($action == 'UPD' or $action == 'CRT') {
      // $_NEW_sumzadolchfsubpodr = '-3';
      $_NEW_sumzadolchfsubpodr = $__sumchfsubpodr - (CALC_AV_SUMOPLCHF($kodCHF_selected) + $__sumavans +
        $__sumavsplit);
      $_var1 = "-3";
    }
    if ($action == 'PREDEL') {
      // $_NEW_sumzadolchfsubpodr = '-30';
      $_NEW_sumzadolchfsubpodr = $__sumchfsubpodr - (CALC_AV_SUMOPLCHF($kodCHF_selected) + $__sumavans +
        $__sumavsplit);
      $_var2 = "-30";
    }
    // Пишем новую задолженность по СФ
    $db->update('dognet_docchfsubpodr', array(
      'sumzadolchfsubpodr'    => $_NEW_sumzadolchfsubpodr,
      'comment'               => 'AV ' . $_var1 . ' / ' . $_var2,
    ), array('kodchfsubpodr'  => $kodCHF_selected));
  }
  # ----- ----- ----- ----- -----
  # СЧЕТ-ФАКТУРА УЖЕ ЗАДАН И В ФОРМЕ НЕ ПУСТОЙ
  # 1. $_POST['kodchfsubpodr_selected'] есть
  # 2. $_POST['kodchfsubpodr_selected'] == $_POST['kodchfsubpodr_field']
  #
  // else {
  //   $_QRY_1 = $db->sql("SELECT sumchfsubpodr FROM dognet_docchfsubpodr WHERE kodchfsubpodr='{$kodchfsubpodrDB}'")->fetchAll();
  //   if ($_QRY_1) {
  //     $__sumchfsubpodr = $_QRY_1[0]['sumchfsubpodr'];
  //   }
  //   $_QRY_2 = $db->sql("SELECT SUM(sumchfavsubpodr) as sumavans FROM dognet_docavsubpodr WHERE kodchfsubpodr='{$kodchfsubpodrDB}'")->fetchAll();
  //   if ($_QRY_2) {
  //     $__sumavans = $_QRY_2[0]['sumavans'];
  //   }
  //   $_QRY_3 = $db->sql("SELECT SUM(sumavsplit) as sumavsplit FROM dognet_docavsplitsubpodr WHERE kodchfsubpodr='{$kodchfsubpodrDB}'")->fetchAll();
  //   if ($_QRY_3) {
  //     $__sumavsplit = $_QRY_3[0]['sumavsplit'];
  //   }
  //   // Пересчитываем сумму задолженности по счету-фактуре
  //   if ($action == 'UPD' or $action == 'CRT') {
  //     // $_NEW_sumzadolchfsubpodr = '-3';
  //     $_NEW_sumzadolchfsubpodr = $__sumchfsubpodr - (CALC_AV_SUMOPLCHF($kodchfsubpodrDB) + $__sumavans +
  //       $__sumavsplit);
  //     $_var1 = "-4";
  //   }
  //   if ($action == 'PREDEL') {
  //     // $_NEW_sumzadolchfsubpodr = '-30';
  //     $_NEW_sumzadolchfsubpodr = $__sumchfsubpodr - (CALC_AV_SUMOPLCHF($kodchfsubpodrDB) + $__sumavans +
  //       $__sumavsplit);
  //     $_var2 = "-40";
  //   }
  //   // Пишем новую задолженность по СФ
  //   $db->update('dognet_docchfsubpodr', array(
  //     'sumzadolchfsubpodr'    => $_NEW_sumzadolchfsubpodr,
  //     'comment'               => 'AV ' . $_var1 . ' / ' . $_var2,
  //   ), array('kodchfsubpodr'  => $kodchfsubpodrDB));
  // }
}
#
#
#
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### #####
#
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### #####
#
function UPDATE_CHFZADOL_OTH($db, $action, $id, $koddocsubpodr, $kodCHF_selected, $kodCHF_field) {

  $_QRY = mysqlQuery("SELECT kodchfsubpodr FROM dognet_docchfsubpodr WHERE koddocsubpodr=" . $koddocsubpodr);
  while ($_ROW = mysqli_fetch_assoc($_QRY)) {

    $kod = $_ROW['kodchfsubpodr'];
    // -----
    $_QRY_1 = $db->sql("SELECT sumchfsubpodr FROM dognet_docchfsubpodr WHERE kodchfsubpodr=" .
      $kod)->fetchAll();
    if ($_QRY_1) {
      $__sumchfsubpodr = $_QRY_1[0]['sumchfsubpodr'];
    }
    // -----
    $_QRY_2 = $db->sql("SELECT SUM(sumchfavsubpodr) as sumavans FROM dognet_docavsubpodr WHERE kodchfsubpodr=" .
      $kod)->fetchAll();
    if ($_QRY_2) {
      $__sumavans = $_QRY_2[0]['sumavans'];
    }
    // -----
    $_QRY_3 = $db->sql("SELECT SUM(sumavsplit) as sumavsplit FROM dognet_docavsplitsubpodr WHERE kodchfsubpodr="
      . $kod)->fetchAll();
    if ($_QRY_3) {
      $__sumavsplit = $_QRY_3[0]['sumavsplit'];
    }
    // -----
    $_NEW_sumzadolchfsubpodr = $__sumchfsubpodr - (CALC_AV_SUMOPLCHF($kod) + $__sumavans + $__sumavsplit);
    // -----
    if ($kod != $kodCHF_field) {
      $db->update('dognet_docchfsubpodr', array(
        'sumzadolchfsubpodr' => $_NEW_sumzadolchfsubpodr
      ), array('kodchfsubpodr' => $kod));
    }
  }
}