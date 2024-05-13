<?php
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
#
#	Сумма всех счетов-фактур по договору субподряда на дату/без даты
# >>> $koddocsub		- Идентификатор договора субподряда
# >>> $ondate				- Дата отсечки сплитов по дате (для справки о задолженности на дату). Если дата отсутствует (null), то суммируются ВСЕ сплиты
#
function F_REP_MAIN_SUM_STAGE_CHF($kodstage, $ondate) {
  $result = "";
  if (!empty($kodstage) && empty($ondate)) {
    // Считаем сумму счетов-фактур без учета даты ( $ondate = NULL )
    $_QRY = mysqli_fetch_assoc(mysqlQuery("SELECT SUM(chetfsumma) as sum FROM dognet_kalplanchf WHERE koddel<>'99' AND kodkalplan='{$kodstage}'"));
    $result = $_QRY['sum'];
  } elseif (!empty($koddocsub) && !empty($ondate) && ((DateTime::createFromFormat('Y-m-d', $ondate) !== false))) {
    // Считаем сумму сплитов по авансу с учетом даты ( $ondate )
    $_QRY = mysqli_fetch_assoc(mysqlQuery("SELECT SUM(chetfsumma) as sum FROM dognet_kalplanchf WHERE koddel<>'99' AND kodkalplan='{$kodstage}' AND chetfdate<='{$ondate}'"));
    $result = $_QRY['sum'];
  } else {
    $result = 0;
  }
  return $result;
}
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
#
#	Сумма всех счетов-фактур по договору субподряда на дату/без даты
# >>> $koddoc		- Идентификатор договора субподряда
# >>> $ondate				- Дата отсечки сплитов по дате (для справки о задолженности на дату). Если дата отсутствует (null), то суммируются ВСЕ сплиты
#
function F_REP_MAIN_CALC_AV_AVOST($kodavans, $ondate) {
  $result = "";
  $sumav = 0;
  $sumoplav = 0;
  $diff = 0;

  if (!empty($kodavans)) {
    if (empty($ondate)) {
      // Считаем сумму сплитов по авансу без учета даты ( $ondate = NULL )
      $_QRY_SUMAV = mysqli_fetch_assoc(mysqlQuery("SELECT SUM(summaavans) as sum FROM dognet_docavans WHERE kodavans='{$kodavans}' AND koddel<>'99'"));
      $sumav = $_QRY_SUMAV['sum'];
      $_QRY_SUMOPLAV = mysqli_fetch_assoc(mysqlQuery("SELECT SUM(summaoplav) as sum FROM dognet_chfavans WHERE kodavans='{$kodavans}' AND koddel<>'99'"));
      $sumoplav = $_QRY_SUMOPLAV['sum'];
      $diff = round($sumav, 2, PHP_ROUND_HALF_UP) - round($sumoplav, 2, PHP_ROUND_HALF_UP);
      $result = $diff;
    } elseif (DateTime::createFromFormat('Y-m-d', $ondate) !== false) {
      // Считаем сумму сплитов по авансу с учетом даты ( $ondate <> NULL )
      $_QRY_SUMAV = mysqli_fetch_assoc(mysqlQuery("SELECT SUM(summaavans) as sum FROM dognet_docavans WHERE kodavans='{$kodavans}' AND koddel<>'99' AND dateavans<='{$ondate}'"));
      $sumav = $_QRY_SUMAV['sum'];
      $_QRY_SUMOPLAV = mysqli_fetch_assoc(mysqlQuery("SELECT SUM(summaoplav) as sum FROM dognet_chfavans WHERE kodavans='{$kodavans}' AND koddel<>'99' AND kodchfact<>'' AND dateoplav<='{$ondate}'"));
      $sumoplav = $_QRY_SUMOPLAV['sum'];
      $diff = round($sumav, 2, PHP_ROUND_HALF_UP) - round($sumoplav, 2, PHP_ROUND_HALF_UP);
      $result = $diff;
    } else {
      $result = 0;
    }
  } else {
    $result = 0;
  }
  return $result;
}
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
#
#	Сумма всех счетов-фактур по договору субподряда на дату/без даты
# >>> $koddoc		- Идентификатор договора субподряда
# >>> $ondate				- Дата отсечки сплитов по дате (для справки о задолженности на дату). Если дата отсутствует (null), то суммируются ВСЕ сплиты
#
function F_REP_MAIN_SUM_AV_OPLAV($kodavans, $ondate) {
  $result = "";
  $sumoplav = 0;

  if (!empty($kodavans)) {
    if (empty($ondate)) {
      // Считаем сумму сплитов по авансу без учета даты ( $ondate = NULL )
      $_QRY_SUMOPLAV = mysqli_fetch_assoc(mysqlQuery("SELECT SUM(summaoplav) as sum FROM dognet_chfavans WHERE kodavans='{$kodavans}' AND koddel<>'99'"));
      $sumoplav = $_QRY_SUMOPLAV['sum'];
      $result = $sumoplav;
    } elseif (DateTime::createFromFormat('Y-m-d', $ondate) !== false) {
      // Считаем сумму сплитов по авансу с учетом даты ( $ondate <> NULL )
      $_QRY_SUMOPLAV = mysqli_fetch_assoc(mysqlQuery("SELECT SUM(summaoplav) as sum FROM dognet_chfavans WHERE kodavans='{$kodavans}' AND koddel<>'99' AND kodchfact<>'' AND dateoplav<='{$ondate}'"));
      $sumoplav = $_QRY_SUMOPLAV['sum'];
      $result = $sumoplav;
    } else {
      $result = 0;
    }
  } else {
    $result = 0;
  }
  return $result;
}
