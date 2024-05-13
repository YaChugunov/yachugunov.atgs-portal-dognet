<?php
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
#
#	Сумма всех счетов-фактур по договору субподряда на дату/без даты
# >>> $koddocsub		- Идентификатор договора субподряда
# >>> $ondate				- Дата отсечки сплитов по дате (для справки о задолженности на дату). Если дата отсутствует (null), то суммируются ВСЕ сплиты
#
function F_SUM_SUBDOC_CHF($koddocsub, $ondate) {
  $result = "";
  //
  // Считаем сумму сплитов по авансу без учета даты ( $ondate = NULL )
  if (!empty($koddocsub) && empty($ondate)) {
    $_QRY = mysqli_fetch_assoc(mysqlQuery("SELECT SUM(sumchfsubpodr) as sum FROM dognet_docchfsubpodr WHERE koddocsubpodr='{$koddocsub}' AND koddel<>'99'"));
    $result = $_QRY['sum'];
  }
  // Считаем сумму сплитов по авансу с учетом даты ( $ondate )
  elseif (!empty($koddocsub) && !empty($ondate) && ((DateTime::createFromFormat('Y-m-d', $ondate) !== false))) {
    $_QRY = mysqli_fetch_assoc(mysqlQuery("SELECT SUM(sumchfsubpodr) as sum FROM dognet_docchfsubpodr WHERE koddocsubpodr='{$koddocsub}' AND koddel<>'99' AND datechfsubpodr<='{$ondate}'"));
    $result = $_QRY['sum'];
  } else {
    $result = 0;
  }
  return $result;
}
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
#
#	Сумма всех авансов по договору субподряда на дату/без даты
# >>> $koddocsub		- Идентификатор договора субподряда
# >>> $ondate				- Дата отсечки сплитов по дате (для справки о задолженности на дату). Если дата отсутствует (null), то суммируются ВСЕ сплиты
#
function F_SUM_SUBDOC_AV($koddocsub, $ondate) {
  $result = "";
  //
  // Считаем сумму сплитов по авансу без учета даты ( $ondate = NULL )
  if (!empty($koddocsub) && empty($ondate)) {
    $_QRY = mysqli_fetch_assoc(mysqlQuery("SELECT SUM(sumavsubpodr) as sum FROM dognet_docavsubpodr WHERE koddocsubpodr='{$koddocsub}' AND koddel<>'99'"));
    $result = $_QRY['sum'];
  }
  // Считаем сумму сплитов по авансу с учетом даты ( $ondate )
  elseif (!empty($koddocsub) && !empty($ondate) && ((DateTime::createFromFormat('Y-m-d', $ondate) !== false))) {
    $_QRY = mysqli_fetch_assoc(mysqlQuery("SELECT SUM(sumavsubpodr) as sum FROM dognet_docavsubpodr WHERE koddocsubpodr='{$koddocsub}' AND koddel<>'99' AND dateavsubpodr<='{$ondate}'"));
    $result = $_QRY['sum'];
  } else {
    $result = 0;
  }
  return $result;
}
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
#
#	Сумма всех зачтенных авансов по счету-фактуре субподрядчика через сплит (разбитие, то есть частями)
# >>> $koddocsub		- Идентификатор договора субподряда
# >>> $kodchf				- Идентификатор счета-фактуры
# >>> $ondate	- Дата отсечки сплитов по дате (для справки о задолженности на дату). Если дата отсутствует (null), то суммируются ВСЕ сплиты
#
function F_SUM_SUBDOC_AVCHF($koddocsub, $kodchf, $ondate) {
  $result = "";
  //
  // ЕСЛИ В ЗАПРОСЕ ЕСТЬ КОНКРЕТНЫЙ ДОГОВОР И СЧЕТ-ФАКТУРА
  if (!empty($koddocsub) && !empty($kodchf)) {
    // Считаем сумму сплитов по авансу без учета даты ( $ondate = NULL )
    if (empty($ondate)) {
      $_QRY = mysqli_fetch_assoc(mysqlQuery("SELECT SUM(sumavsubpodr) as sum FROM dognet_docavsubpodr WHERE koddocsubpodr='{$koddocsub}' AND useavans='2' AND kodchfsubpodr='{$kodchf}' AND koddel<>'99'"));
      $result = $_QRY['sum'];
    }
    // Считаем сумму сплитов по авансу с учетом даты ( $ondate )
    elseif (!empty($ondate) && ((DateTime::createFromFormat('Y-m-d', $ondate) !== false))) {
      $_QRY = mysqli_fetch_assoc(mysqlQuery("SELECT SUM(sumavsubpodr) as sum FROM dognet_docavsubpodr WHERE koddocsubpodr='{$koddocsub}' AND useavans='2' AND kodchfsubpodr='{$kodchf}' AND koddel<>'99' AND dateavsubpodr<='{$ondate}'"));
      $result = $_QRY['sum'];
    } else {
      $result = 0;
    }
    // ЕСЛИ В ЗАПРОСЕ ЕСТЬ КОНКРЕТНЫЙ ДОГОВОР И НЕТ СЧЕТ-ФАКТУРЫ
  } elseif (!empty($koddocsub) && empty($kodchf)) {
    // Считаем сумму сплитов по авансу без учета даты ( $ondate = NULL )
    if (empty($ondate)) {
      $_QRY = mysqli_fetch_assoc(mysqlQuery("SELECT SUM(sumavsubpodr) as sum FROM dognet_docavsubpodr WHERE koddocsubpodr='{$koddocsub}' AND useavans='0' AND koddel<>'99'"));
      $result = $_QRY['sum'];
    }
    // Считаем сумму сплитов по авансу с учетом даты ( $ondate )
    elseif (!empty($ondate) && ((DateTime::createFromFormat('Y-m-d', $ondate) !== false))) {
      $_QRY = mysqli_fetch_assoc(mysqlQuery("SELECT SUM(sumavsubpodr) as sum FROM dognet_docavsubpodr WHERE koddocsubpodr='{$koddocsub}' AND useavans='0' AND koddel<>'99' AND dateavsubpodr<='{$ondate}'"));
      $result = $_QRY['sum'];
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
#	Сумма всех зачтенных авансов по счету-фактуре субподрядчика через сплит (разбитие, то есть частями)
# >>> $koddocsub		- Идентификатор договора субподряда
# >>> $kodchf				- Идентификатор счета-фактуры
# >>> $ondate				- Дата отсечки сплитов по дате (для справки о задолженности на дату). Если дата отсутствует (null), то суммируются ВСЕ сплиты
#
function F_SUM_SUBDOC_AVSPLITCHF($koddocsub, $kodchf, $ondate) {
  $result = "";
  //
  // [A:0] ЕСЛИ В ЗАПРОСЕ ЕСТЬ КОНКРЕТНЫЙ ДОГОВОР И СЧЕТ-ФАКТУРА
  if (!empty($koddocsub) && !empty($kodchf)) {
    // [B:0] Считаем сумму сплитов по авансу без учета даты ( $ondate = NULL )
    if (empty($ondate)) {
      $_QRY = mysqli_fetch_assoc(mysqlQuery("SELECT SUM(sumavsplit) as sum FROM dognet_docavsplitsubpodr WHERE koddocsubpodr='{$koddocsub}' AND kodchfsubpodr='{$kodchf}' AND koddel<>'99'"));
      $result = $_QRY['sum'];
    }
    // [B:1] Считаем сумму сплитов по авансу с учетом даты ( $ondate )
    elseif (!empty($ondate) && ((DateTime::createFromFormat('Y-m-d', $ondate) !== false))) {
      $_QRY = mysqli_fetch_assoc(mysqlQuery("SELECT SUM(sumavsplit) as sum FROM dognet_docavsplitsubpodr WHERE koddocsubpodr='{$koddocsub}' AND kodchfsubpodr='{$kodchf}' AND koddel<>'99' AND dateavsplit<='{$ondate}'"));
      $result = $_QRY['sum'];
    }
    // [B:2]
    else {
      $result = 0;
    }
  }
  // [A:1] ЕСЛИ В ЗАПРОСЕ ЕСТЬ КОНКРЕТНЫЙ ДОГОВОР И НЕТ СЧЕТ-ФАКТУРЫ
  elseif (!empty($koddocsub) && empty($kodchf)) {
    // [C:0] Считаем сумму сплитов по авансу без учета даты ( $ondate = NULL )
    if (empty($ondate)) {
      $_QRY = mysqli_fetch_assoc(mysqlQuery("SELECT SUM(sumavsplit) as sum FROM dognet_docavsplitsubpodr WHERE koddocsubpodr='{$koddocsub}' AND koddel<>'99'"));
      $result = $_QRY['sum'];
    }
    // [C:1] Считаем сумму сплитов по авансу с учетом даты ( $ondate )
    elseif (!empty($ondate) && ((DateTime::createFromFormat('Y-m-d', $ondate) !== false))) {
      $_QRY = mysqli_fetch_assoc(mysqlQuery("SELECT SUM(sumavsplit) as sum FROM dognet_docavsplitsubpodr WHERE koddocsubpodr='{$koddocsub}' AND koddel<>'99' AND dateavsplit<='{$ondate}'"));
      $result = $_QRY['sum'];
    }
    // [C:2] 
    else {
      $result = 0;
    }
  }
  // [A:2]
  else {
    $result = 0;
  }
  return $result;
}
#
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
#
#	Сумма всех оплат по счету-фактуре субподрядчика
# >>> $koddocsub		- Идентификатор договора субподряда
# >>> $kodchf				- Идентификатор счета-фактуры
# >>> $ondate	- Дата отсечки сплитов по дате (для справки о задолженности на дату). Если дата отсутствует (null), то суммируются ВСЕ сплиты
#
function F_SUM_SUBDOC_OPLCHF($koddocsub, $kodchf, $ondate) {
  $result = "";
  //
  // [A:0] ЕСЛИ В ЗАПРОСЕ ЕСТЬ КОНКРЕТНЫЙ ДОГОВОР И СЧЕТ-ФАКТУРА
  if (!empty($koddocsub) && !empty($kodchf)) {
    // Считаем сумму оплат без учета даты ( $ondate = NULL )
    if (empty($ondate)) {
      $_QRY = mysqli_fetch_assoc(mysqlQuery("SELECT SUM(sumoplchfsubpodr) as sum FROM dognet_docoplchfsubpodr WHERE koddocsubpodr='{$koddocsub}' AND kodchfsubpodr='{$kodchf}' AND koddel<>'99'"));
      $result = $_QRY['sum'];
    }
    // Считаем сумму сплитов по авансу с учетом даты ( $ondate )
    elseif (!empty($ondate) && ((DateTime::createFromFormat('Y-m-d', $ondate) !== false))) {
      $_QRY = mysqli_fetch_assoc(mysqlQuery("SELECT SUM(sumoplchfsubpodr) as sum FROM dognet_docoplchfsubpodr WHERE koddocsubpodr='{$koddocsub}' AND kodchfsubpodr='{$kodchf}' AND koddel<>'99' AND dateoplchfsubpodr<='{$ondate}'"));
      $result = $_QRY['sum'];
    } else {
      $result = 0;
    }
  }
  // [A:1] ЕСЛИ В ЗАПРОСЕ ЕСТЬ КОНКРЕТНЫЙ ДОГОВОР И НЕТ СЧЕТ-ФАКТУРЫ
  elseif (!empty($koddocsub) && empty($kodchf)) {
    // Считаем сумму оплат без учета даты ( $ondate = NULL )
    if (empty($ondate)) {
      $_QRY = mysqli_fetch_assoc(mysqlQuery("SELECT SUM(sumoplchfsubpodr) as sum FROM dognet_docoplchfsubpodr WHERE koddocsubpodr='{$koddocsub}'"));
      $result = $_QRY['sum'];
    }
    // Считаем сумму сплитов по авансу с учетом даты ( $ondate )
    elseif (!empty($ondate) && ((DateTime::createFromFormat('Y-m-d', $ondate) !== false))) {
      $_QRY = mysqli_fetch_assoc(mysqlQuery("SELECT SUM(sumoplchfsubpodr) as sum FROM dognet_docoplchfsubpodr WHERE koddocsubpodr='{$koddocsub}' AND dateoplchfsubpodr<='{$ondate}'"));
      $result = $_QRY['sum'];
    } else {
      $result = 0;
    }
  }
  // [A:2]
  else {
    $result = 0;
  }
  return $result;
}
#
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
#
#	Сумма всех оплат по счету-фактуре субподрядчика
# >>> $kodsub		- Идентификатор счета-фактуры
# >>> $kod		- Идентификатор счета-фактуры
# >>> $ondate	- Дата отсечки сплитов по дате (для справки о задолженности на дату). Если дата отсутствует (null), то суммируются ВСЕ сплиты
#
function F_CALC_SUBDOC_INCOM($koddocsub, $ondate) {
  $result = "";

  $_QRY = mysqli_fetch_assoc(mysqlQuery("SELECT sumdocsubpodr FROM dognet_docsubpodr WHERE koddocsubpodr='{$koddocsub}' AND koddel<>'99'"));
  $_SUMDOC = !empty($_QRY) ? $_QRY['sumdocsubpodr'] : null;

  $_TOTCHF_F = F_SUM_SUBDOC_CHF($koddocsub, $ondate);
  $_TOTCHF = !empty($_TOTCHF_F) ? $_TOTCHF_F : 0;
  $_TOTAV = F_SUM_SUBDOC_AV($koddocsub, $ondate);

  $_SUMOPLCHF = 0;
  if (empty($ondate)) {
    $_QRY_DOCCHF = mysqlQuery("SELECT * FROM dognet_docchfsubpodr WHERE koddocsubpodr='{$koddocsub}' AND koddel<>'99'");
  } elseif (!empty($ondate) && ((DateTime::createFromFormat('Y-m-d', $ondate) !== false))) {
    $_QRY_DOCCHF = mysqlQuery("SELECT * FROM dognet_docchfsubpodr WHERE koddocsubpodr='{$koddocsub}' AND koddel<>'99' AND datechfsubpodr<='{$ondate}'");
  }
  while ($_ROW_DOCCHF = mysqli_fetch_assoc($_QRY_DOCCHF)) {
    $kodchf = $_ROW_DOCCHF['kodchfsubpodr'];
    $_TOTAVCHF_F = F_SUM_SUBDOC_AVCHF($koddocsub, $kodchf, $ondate);
    $_TOTAVCHF = !empty($_TOTAVCHF_F) ? $_TOTAVCHF_F : 0;
    $_TOTAVSPLITCHF_F = F_SUM_SUBDOC_AVSPLITCHF($koddocsub, $kodchf, $ondate);
    $_TOTAVSPLITCHF = !empty($_TOTAVSPLITCHF_F) ? $_TOTAVSPLITCHF_F : 0;
    $_TOTOPLCHF_F = F_SUM_SUBDOC_OPLCHF($koddocsub, $kodchf, $ondate);
    $_TOTOPLCHF = !empty($_TOTOPLCHF_F) ? $_TOTOPLCHF_F : 0;
    $_SUMOPLCHF += $_TOTAVCHF + $_TOTAVSPLITCHF + $_TOTOPLCHF;
  }
  $_SUMINCOM = $_SUMOPLCHF;
  $result = $_SUMINCOM;
  return $result;
}
#
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
#
#	Сумма всех оплат по счету-фактуре субподрядчика
# >>> $kodsub		- Идентификатор счета-фактуры
# >>> $kod		- Идентификатор счета-фактуры
# >>> $ondate	- Дата отсечки сплитов по дате (для справки о задолженности на дату). Если дата отсутствует (null), то суммируются ВСЕ сплиты
#
function F_CALC_SUBDOC_ZADOL($koddocsub, $ondate) {
  $result = "";

  $_QRY = mysqli_fetch_assoc(mysqlQuery("SELECT sumdocsubpodr FROM dognet_docsubpodr WHERE koddocsubpodr='{$koddocsub}' AND koddel<>'99'"));
  $_SUMDOC = !empty($_QRY) ? $_QRY['sumdocsubpodr'] : null;

  $_TOTCHF_F = F_SUM_SUBDOC_CHF($koddocsub, $ondate);
  $_TOTCHF = !empty($_TOTCHF_F) ? $_TOTCHF_F : 0;
  $_TOTAV = F_SUM_SUBDOC_AV($koddocsub, $ondate);

  $_SUMOPLCHF = 0;
  if (empty($ondate)) {
    $_QRY_DOCCHF = mysqlQuery("SELECT * FROM dognet_docchfsubpodr WHERE koddocsubpodr='{$koddocsub}' AND koddel<>'99'");
  } elseif (!empty($ondate) && ((DateTime::createFromFormat('Y-m-d', $ondate) !== false))) {
    $_QRY_DOCCHF = mysqlQuery("SELECT * FROM dognet_docchfsubpodr WHERE koddocsubpodr='{$koddocsub}' AND koddel<>'99' AND datechfsubpodr<='{$ondate}'");
  }
  while ($_ROW_DOCCHF = mysqli_fetch_assoc($_QRY_DOCCHF)) {
    $kodchf = $_ROW_DOCCHF['kodchfsubpodr'];
    $_TOTAVCHF_F = F_SUM_SUBDOC_AVCHF($koddocsub, $kodchf, $ondate);
    $_TOTAVCHF = !empty($_TOTAVCHF_F) ? $_TOTAVCHF_F : 0;
    $_TOTAVSPLITCHF_F = F_SUM_SUBDOC_AVSPLITCHF($koddocsub, $kodchf, $ondate);
    $_TOTAVSPLITCHF = !empty($_TOTAVSPLITCHF_F) ? $_TOTAVSPLITCHF_F : 0;
    $_TOTOPLCHF_F = F_SUM_SUBDOC_OPLCHF($koddocsub, $kodchf, $ondate);
    $_TOTOPLCHF = !empty($_TOTOPLCHF_F) ? $_TOTOPLCHF_F : 0;
    $_SUMOPLCHF += $_TOTAVCHF + $_TOTAVSPLITCHF + $_TOTOPLCHF;
  }
  $_SUMZADOLZH = $_TOTCHF - $_SUMOPLCHF;
  $result = $_SUMZADOLZH;
  return $result;
}
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
#
#	Сумма всех счетов-фактур по договору субподряда на дату/без даты
# >>> $koddocsub		- Идентификатор договора субподряда
# >>> $ondate				- Дата отсечки сплитов по дате (для справки о задолженности на дату). Если дата отсутствует (null), то суммируются ВСЕ сплиты
#
function F_CALC_CHF_ZADOL($kodchf, $ondate) {
  $result = "";

  // --- --- --- --- --- --- --- --- --- ---

  $_AVCHF = 0;
  // ЕСЛИ В ЗАПРОСЕ ЕСТЬ КОНКРЕТНЫЙ ДОГОВОР И СЧЕТ-ФАКТУРА
  if (!empty($kodchf)) {
    // Считаем сумму сплитов по авансу без учета даты ( $ondate = NULL )
    if (empty($ondate)) {
      $_QRY = mysqli_fetch_assoc(mysqlQuery("SELECT SUM(sumavsubpodr) as sum FROM dognet_docavsubpodr WHERE useavans='2' AND kodchfsubpodr='{$kodchf}' AND koddel<>'99'"));
      $_AVCHF = $_QRY['sum'];
    }
    // Считаем сумму сплитов по авансу с учетом даты ( $ondate )
    elseif (!empty($ondate) && ((DateTime::createFromFormat('Y-m-d', $ondate) !== false))) {
      $_QRY_CHF = mysqlQuery("SELECT * FROM dognet_docchfsubpodr WHERE kodchfsubpodr='{$kodchf}' AND koddel<>'99' AND datechfsubpodr<='{$ondate}'");
      if (!empty($_QRY_CHF)) {
        $_QRY = mysqli_fetch_assoc(mysqlQuery("SELECT SUM(sumavsubpodr) as sum FROM dognet_docavsubpodr WHERE useavans='2' AND kodchfsubpodr='{$kodchf}' AND koddel<>'99' AND dateavsubpodr<='{$ondate}'"));
        $_AVCHF = $_QRY['sum'];
      } else {
        $_AVCHF = 0;
      }
    } else {
      $_AVCHF = 0;
    }
  } else {
    $_AVCHF = 0;
  }

  // --- --- --- --- --- --- --- --- --- ---

  $_AVSPLITCHF = 0;
  // [A:0] ЕСЛИ В ЗАПРОСЕ ЕСТЬ КОНКРЕТНЫЙ ДОГОВОР И СЧЕТ-ФАКТУРА
  if (!empty($kodchf)) {
    // [B:0] Считаем сумму сплитов по авансу без учета даты ( $ondate = NULL )
    if (empty($ondate)) {
      $_QRY = mysqli_fetch_assoc(mysqlQuery("SELECT SUM(sumavsplit) as sum FROM dognet_docavsplitsubpodr WHERE kodchfsubpodr='{$kodchf}' AND koddel<>'99'"));
      $_AVSPLITCHF = $_QRY['sum'];
    }
    // [B:1] Считаем сумму сплитов по авансу с учетом даты ( $ondate )
    elseif (!empty($ondate) && ((DateTime::createFromFormat('Y-m-d', $ondate) !== false))) {
      $_QRY_CHF = mysqlQuery("SELECT * FROM dognet_docchfsubpodr WHERE kodchfsubpodr='{$kodchf}' AND koddel<>'99' AND datechfsubpodr<='{$ondate}'");
      if (!empty($_QRY_CHF)) {
        $_QRY = mysqli_fetch_assoc(mysqlQuery("SELECT SUM(sumavsplit) as sum FROM dognet_docavsplitsubpodr WHERE kodchfsubpodr='{$kodchf}' AND koddel<>'99' AND dateavsplit<='{$ondate}'"));
        $_AVSPLITCHF = $_QRY['sum'];
      } else {
        $_AVSPLITCHF = 0;
      }
    }
    // [B:2]
    else {
      $_AVSPLITCHF = 0;
    }
  } else {
    $_AVSPLITCHF = 0;
  }

  // --- --- --- --- --- --- --- --- --- ---

  $_OPL = 0;
  // [A:0] ЕСЛИ В ЗАПРОСЕ ЕСТЬ КОНКРЕТНЫЙ ДОГОВОР И СЧЕТ-ФАКТУРА
  if (!empty($kodchf)) {
    // Считаем сумму оплат без учета даты ( $ondate = NULL )
    if (empty($ondate)) {
      $_QRY = mysqli_fetch_assoc(mysqlQuery("SELECT SUM(sumoplchfsubpodr) as sum FROM dognet_docoplchfsubpodr WHERE kodchfsubpodr='{$kodchf}' AND koddel<>'99'"));
      $_OPL = $_QRY['sum'];
    }
    // Считаем сумму сплитов по авансу с учетом даты ( $ondate )
    elseif (!empty($ondate) && ((DateTime::createFromFormat('Y-m-d', $ondate) !== false))) {
      $_QRY_CHF = mysqlQuery("SELECT * FROM dognet_docchfsubpodr WHERE kodchfsubpodr='{$kodchf}' AND koddel<>'99' AND datechfsubpodr<='{$ondate}'");
      if (!empty($_QRY_CHF)) {
        $_QRY = mysqli_fetch_assoc(mysqlQuery("SELECT SUM(sumoplchfsubpodr) as sum FROM dognet_docoplchfsubpodr WHERE kodchfsubpodr='{$kodchf}' AND dateoplchfsubpodr<='{$ondate}' AND koddel<>'99'"));
        $_OPL = $_QRY['sum'];
      } else {
        $_OPL = 0;
      }
    } else {
      $_OPL = 0;
    }
  } else {
    $_OPL = 0;
  }

  // --- --- --- --- --- --- --- --- --- ---

  if (!empty($kodchf)) {
    if (empty($ondate)) {
      $_QRY_CHF = mysqli_fetch_assoc(mysqlQuery("SELECT * FROM dognet_docchfsubpodr WHERE kodchfsubpodr='{$kodchf}' AND koddel<>'99'"));
      $_CHF = $_QRY_CHF['sumchfsubpodr'];
    } elseif (!empty($ondate) && ((DateTime::createFromFormat('Y-m-d', $ondate) !== false))) {
      $_QRY_CHF = mysqlQuery("SELECT * FROM dognet_docchfsubpodr WHERE kodchfsubpodr='{$kodchf}' AND koddel<>'99' AND datechfsubpodr<='{$ondate}'");
      if (!empty($_QRY_CHF)) {
        $_ROW_CHF = mysqli_fetch_assoc($_QRY_CHF);
        $_CHF = $_ROW_CHF['sumchfsubpodr'];
      } else {
        $_CHF = 0;
      }
    } else {
      $_CHF = 0;
    }
  } else {
    $_CHF = 0;
  }

  // --- --- --- --- --- --- --- --- --- ---

  $result = round($_CHF, 2, PHP_ROUND_HALF_UP) - (round($_AVCHF, 2, PHP_ROUND_HALF_UP) + round($_AVSPLITCHF, 2, PHP_ROUND_HALF_UP) + round($_OPL, 2, PHP_ROUND_HALF_UP));
  return $result;
}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
#
#	Сумма всех счетов-фактур по договору субподряда на дату/без даты
# >>> $koddocsub		- Идентификатор договора субподряда
# >>> $ondate				- Дата отсечки сплитов по дате (для справки о задолженности на дату). Если дата отсутствует (null), то суммируются ВСЕ сплиты
#
function F_SUM_SUBDOC_CHF_WITHZADOL($koddocsub, $ondate) {
  $result = "";
  $SumChfWithZadol = 0;
  //
  // Считаем сумму сплитов по авансу без учета даты ( $ondate = NULL )
  if (!empty($koddocsub)) {
    $_QRY = mysqlQuery("SELECT * FROM dognet_docchfsubpodr WHERE koddocsubpodr='{$koddocsub}' AND koddel<>'99'");
    while ($_ROW = mysqli_fetch_assoc($_QRY)) {
      if (F_CALC_CHF_ZADOL($_ROW['kodchfsubpodr'], $ondate) <> 0) {
        $SumChfWithZadol += $_ROW['sumchfsubpodr'];
      } else {
        $SumChfWithZadol += 0;
      }
    }
  } else {
    $result = 0;
  }
  $result = $SumChfWithZadol;
  return $result;
}
#
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
#
#	Сумма всех оплат по счету-фактуре субподрядчика
# >>> $kodsub		- Идентификатор счета-фактуры
# >>> $kod		- Идентификатор счета-фактуры
# >>> $ondate	- Дата отсечки сплитов по дате (для справки о задолженности на дату). Если дата отсутствует (null), то суммируются ВСЕ сплиты
#
function F_CALC_SUBDOC_INCOM_WITHZADOL($koddocsub, $ondate) {
  $result = "";

  $_QRY = mysqli_fetch_assoc(mysqlQuery("SELECT sumdocsubpodr FROM dognet_docsubpodr WHERE koddocsubpodr='{$koddocsub}' AND koddel<>'99'"));
  $_SUMDOC = !empty($_QRY) ? $_QRY['sumdocsubpodr'] : null;

  $_TOTCHF_F = F_SUM_SUBDOC_CHF($koddocsub, $ondate);
  $_TOTCHF = !empty($_TOTCHF_F) ? $_TOTCHF_F : 0;
  $_TOTAV = F_SUM_SUBDOC_AV($koddocsub, $ondate);

  $_SUMOPLCHF = 0;
  if (empty($ondate)) {
    $_QRY_DOCCHF = mysqlQuery("SELECT * FROM dognet_docchfsubpodr WHERE koddocsubpodr='{$koddocsub}' AND koddel<>'99'");
  } elseif (!empty($ondate) && ((DateTime::createFromFormat('Y-m-d', $ondate) !== false))) {
    $_QRY_DOCCHF = mysqlQuery("SELECT * FROM dognet_docchfsubpodr WHERE koddocsubpodr='{$koddocsub}' AND koddel<>'99' AND datechfsubpodr<='{$ondate}'");
  }
  while ($_ROW_DOCCHF = mysqli_fetch_assoc($_QRY_DOCCHF)) {
    $kodchf = $_ROW_DOCCHF['kodchfsubpodr'];
    if (F_CALC_CHF_ZADOL($_ROW_DOCCHF['kodchfsubpodr'], $ondate) <> 0) {
      $_TOTAVCHF_F = F_SUM_SUBDOC_AVCHF($koddocsub, $kodchf, $ondate);
      $_TOTAVCHF = !empty($_TOTAVCHF_F) ? $_TOTAVCHF_F : 0;
      $_TOTAVSPLITCHF_F = F_SUM_SUBDOC_AVSPLITCHF($koddocsub, $kodchf, $ondate);
      $_TOTAVSPLITCHF = !empty($_TOTAVSPLITCHF_F) ? $_TOTAVSPLITCHF_F : 0;
      $_TOTOPLCHF_F = F_SUM_SUBDOC_OPLCHF($koddocsub, $kodchf, $ondate);
      $_TOTOPLCHF = !empty($_TOTOPLCHF_F) ? $_TOTOPLCHF_F : 0;
      $_SUMOPLCHF += $_TOTAVCHF + $_TOTAVSPLITCHF + $_TOTOPLCHF;
    }
  }
  $_SUMINCOM = $_SUMOPLCHF;
  $result = $_SUMINCOM;
  return $result;
}
#
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
#
#	Проверка договора субподряда на наличие задолженности
# IN  >>> $kodsub		- Идентификатор счета-фактуры
# IN  >>> $ondate	- Дата отсечки сплитов по дате (для справки о задолженности на дату). Если дата отсутствует (null), то суммируются ВСЕ сплиты
# OUT <<< 1 (есть задолженность) или 0
#
function F_CHECK_CHF_ZADOL($kodchf, $ondate) {
  $result = "";

  $_SUMOPLCHF = 0;
  if (!empty($kodchf) && empty($ondate)) {
    $_QRY_CHF = mysqlQuery("SELECT * FROM dognet_docchfsubpodr WHERE kodchfsubpodr='{$kodchf}' AND koddel<>'99'");
    $_ROW_CHF = mysqli_fetch_assoc($_QRY_CHF);
  } elseif (!empty($kodchf) && !empty($ondate) && ((DateTime::createFromFormat('Y-m-d', $ondate) !== false))) {
    $_QRY_CHF = mysqlQuery("SELECT * FROM dognet_docchfsubpodr WHERE kodchfsubpodr='{$kodchf}' AND koddel<>'99' AND datechfsubpodr<='{$ondate}'");
    $_ROW_CHF = mysqli_fetch_assoc($_QRY_CHF);
  } else {
    $result = 0;
  }

  if (!empty($kodchf) && !empty($_QRY_CHF)) {
    $koddocsub = $_ROW_CHF['koddocsubpodr'];
    $kodchf = $_ROW_CHF['kodchfsubpodr'];
    $_CHF = $_ROW_CHF['sumchfsubpodr'];
    $_TOTAVCHF_F = F_SUM_SUBDOC_AVCHF($koddocsub, $kodchf, $ondate);
    $_TOTAVCHF = !empty($_TOTAVCHF_F) ? $_TOTAVCHF_F : 0;
    $_TOTAVSPLITCHF_F = F_SUM_SUBDOC_AVSPLITCHF($koddocsub, $kodchf, $ondate);
    $_TOTAVSPLITCHF = !empty($_TOTAVSPLITCHF_F) ? $_TOTAVSPLITCHF_F : 0;
    $_TOTOPLCHF_F = F_SUM_SUBDOC_OPLCHF($koddocsub, $kodchf, $ondate);
    $_TOTOPLCHF = !empty($_TOTOPLCHF_F) ? $_TOTOPLCHF_F : 0;
    $_SUMOPLCHF = $_TOTAVCHF + $_TOTAVSPLITCHF + $_TOTOPLCHF;
    $result = round((round($_CHF, 2, PHP_ROUND_HALF_UP) - round($_SUMOPLCHF, 2, PHP_ROUND_HALF_UP)), 2, PHP_ROUND_HALF_UP) <> 0 ? 1 : 0;
  } else {
    $result = 0;
  }
  return $result;
}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# ТЕСТ ТЕСТ ТЕСТ ТЕСТ ТЕСТ ТЕСТ ТЕСТ ТЕСТ ТЕСТ ТЕСТ 
# >>>> >>>> >>>> >>>> >>>> >>>> >>>> >>>> >>>> >>>> 
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
function F_CHECK_CHF_ZADOL_TEST($kodchf, $ondate) {
  $result = "";

  $_SUMOPLCHF = 0;
  if (!empty($kodchf) && empty($ondate)) {
    $_QRY_CHF = mysqlQuery("SELECT * FROM dognet_docchfsubpodr WHERE kodchfsubpodr='{$kodchf}' AND koddel<>'99'");
    $_ROW_CHF = mysqli_fetch_assoc($_QRY_CHF);
  } elseif (!empty($kodchf) && !empty($ondate) && ((DateTime::createFromFormat('Y-m-d', $ondate) !== false))) {
    $_QRY_CHF = mysqlQuery("SELECT * FROM dognet_docchfsubpodr WHERE kodchfsubpodr='{$kodchf}' AND koddel<>'99' AND datechfsubpodr<='{$ondate}'");
    $_ROW_CHF = mysqli_fetch_assoc($_QRY_CHF);
  } else {
    $result = 0;
  }

  if (!empty($kodchf) && !empty($_QRY_CHF)) {
    $koddocsub = $_ROW_CHF['koddocsubpodr'];
    $kodchf = $_ROW_CHF['kodchfsubpodr'];
    $_CHF = $_ROW_CHF['sumchfsubpodr'];
    $_TOTAVCHF_F = F_SUM_SUBDOC_AVCHF($koddocsub, $kodchf, $ondate);
    $_TOTAVCHF = !empty($_TOTAVCHF_F) ? $_TOTAVCHF_F : 0;
    $_TOTAVSPLITCHF_F = F_SUM_SUBDOC_AVSPLITCHF($koddocsub, $kodchf, $ondate);
    $_TOTAVSPLITCHF = !empty($_TOTAVSPLITCHF_F) ? $_TOTAVSPLITCHF_F : 0;
    $_TOTOPLCHF_F = F_SUM_SUBDOC_OPLCHF($koddocsub, $kodchf, $ondate);
    $_TOTOPLCHF = !empty($_TOTOPLCHF_F) ? $_TOTOPLCHF_F : 0;
    $_SUMOPLCHF = $_TOTAVCHF + $_TOTAVSPLITCHF + $_TOTOPLCHF;
    // $result = round((round($_CHF, 2, PHP_ROUND_HALF_UP) - round($_SUMOPLCHF, 2, PHP_ROUND_HALF_UP)), 2, PHP_ROUND_HALF_UP) <> 0 ? 1 : 0;
    $result = $_CHF . " / " . $_TOTAVCHF . " / " . $_TOTAVSPLITCHF . " / " . $_TOTOPLCHF;
  } else {
    $result = 0;
  }
  return $result;
}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# <<<< <<<< <<<< <<<< <<<< <<<< <<<< <<<< <<<< <<<< 
# ТЕСТ ТЕСТ ТЕСТ ТЕСТ ТЕСТ ТЕСТ ТЕСТ ТЕСТ ТЕСТ ТЕСТ 
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
#
#	Проверка договора субподряда на наличие задолженности
# IN  >>> $kodsub		- Идентификатор счета-фактуры
# IN  >>> $ondate	- Дата отсечки сплитов по дате (для справки о задолженности на дату). Если дата отсутствует (null), то суммируются ВСЕ сплиты
# OUT <<< 1 (есть задолженность) или 0
#
function F_CHECK_SUBDOC_ZADOL($koddocsub, $ondate) {
  $result = "";

  $_SUMOPLCHF = 0;
  if (!empty($koddocsub) && empty($ondate)) {
    $_TOTCHF_F = F_SUM_SUBDOC_CHF($koddocsub, $ondate);
    $_TOTCHF = !empty($_TOTCHF_F) ? $_TOTCHF_F : 0;
    $_QRY_DOCCHF = mysqlQuery("SELECT * FROM dognet_docchfsubpodr WHERE koddocsubpodr='{$koddocsub}' AND koddel<>'99'");
  } elseif (!empty($koddocsub) && !empty($ondate) && ((DateTime::createFromFormat('Y-m-d', $ondate) !== false))) {
    $_TOTCHF_F = F_SUM_SUBDOC_CHF($koddocsub, $ondate);
    $_TOTCHF = !empty($_TOTCHF_F) ? $_TOTCHF_F : 0;
    $_QRY_DOCCHF = mysqlQuery("SELECT * FROM dognet_docchfsubpodr WHERE koddocsubpodr='{$koddocsub}' AND koddel<>'99' AND datechfsubpodr<='{$ondate}'");
  }
  if (!empty($koddocsub)) {
    while ($_ROW_DOCCHF = mysqli_fetch_assoc($_QRY_DOCCHF)) {
      $kodchf = $_ROW_DOCCHF['kodchfsubpodr'];
      $_TOTAVCHF_F = F_SUM_SUBDOC_AVCHF($koddocsub, $kodchf, $ondate);
      $_TOTAVCHF = !empty($_TOTAVCHF_F) ? $_TOTAVCHF_F : 0;
      $_TOTAVSPLITCHF_F = F_SUM_SUBDOC_AVSPLITCHF($koddocsub, $kodchf, $ondate);
      $_TOTAVSPLITCHF = !empty($_TOTAVSPLITCHF_F) ? $_TOTAVSPLITCHF_F : 0;
      $_TOTOPLCHF_F = F_SUM_SUBDOC_OPLCHF($koddocsub, $kodchf, $ondate);
      $_TOTOPLCHF = !empty($_TOTOPLCHF_F) ? $_TOTOPLCHF_F : 0;
      $_SUMOPLCHF += $_TOTAVCHF + $_TOTAVSPLITCHF + $_TOTOPLCHF;
    }
    $_SUMZADOLZH = round($_TOTCHF, 2, PHP_ROUND_HALF_UP) - round($_SUMOPLCHF, 2, PHP_ROUND_HALF_UP);
    $result = $_SUMZADOLZH <> 0.00 ? 1 : 0;
  } else {
    $result = 0;
  }
  return $result;
}
#
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
#
#	Проверка договора субподряда на наличие задолженности
# IN  >>> $kodsub		- Идентификатор счета-фактуры
# IN  >>> $ondate	- Дата отсечки сплитов по дате (для справки о задолженности на дату). Если дата отсутствует (null), то суммируются ВСЕ сплиты
# OUT <<< 1 (есть задолженность) или 0
#
function F_CHECK_STAGE_ZADOL($kodkalplan, $ondate) {
  $result = "";
  $count = 0;
  if (!empty($kodkalplan)) {
    $_QRY_DOCSTAGE = mysqlQuery("SELECT * FROM dognet_docsubpodr WHERE koddoc='{$kodkalplan}' AND koddel<>'99'");
    while ($_ROW_DOCSTAGE = mysqli_fetch_assoc($_QRY_DOCSTAGE)) {
      $count += F_CHECK_SUBDOC_ZADOL($_ROW_DOCSTAGE['koddocsubpodr'], $ondate);
    }
    $result = $count > 0 ? 1 : 0;
  } else {
    $result = 0;
  }
  return $result;
}
#
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
#
#	Проверка договора субподряда на наличие задолженности
# IN  >>> $kodsub		- Идентификатор счета-фактуры
# IN  >>> $ondate	- Дата отсечки сплитов по дате (для справки о задолженности на дату). Если дата отсутствует (null), то суммируются ВСЕ сплиты
# OUT <<< 1 (есть задолженность) или 0
#
function F_CHECK_DOC_ZADOL($koddoc, $kodshab, $ondate) {
  $result = "";
  $count = 0;
  if (!empty($koddoc) && ($kodshab == '1' || $kodshab == '3')) {
    $_QRY_DOC = mysqlQuery("SELECT * FROM dognet_dockalplan WHERE koddoc='{$koddoc}' AND koddel<>'99'");
    while ($_ROW_DOC = mysqli_fetch_assoc($_QRY_DOC)) {
      $count += F_CHECK_STAGE_ZADOL($_ROW_DOC['kodkalplan'], $ondate);
    }
    $result = $count > 0 ? 1 : 0;
  } elseif (!empty($koddoc) && ($kodshab == '0' || $kodshab == '2' || $kodshab == '4')) {
    $_QRY_DOC = mysqlQuery("SELECT * FROM dognet_docsubpodr WHERE koddoc='{$koddoc}' AND koddel<>'99'");
    while ($_ROW_DOC = mysqli_fetch_assoc($_QRY_DOC)) {
      $count += F_CHECK_SUBDOC_ZADOL($_ROW_DOC['koddocsubpodr'], $ondate);
    }
    $result = $count > 0 ? 1 : 0;
  } else {
    $result = 0;
  }
  return $result;
}
#
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
#
#	Проверка договора субподряда на наличие задолженности
# IN  >>> $kodsub		- Идентификатор счета-фактуры
# IN  >>> $ondate	- Дата отсечки сплитов по дате (для справки о задолженности на дату). Если дата отсутствует (null), то суммируются ВСЕ сплиты
# OUT <<< 1 (есть задолженность) или 0
#
function F_CHECK_SUB_ZADOL($kodsub, $ondate) {
  $result = "";
  $count = 0;
  if (!empty($kodsub)) {
    $_QRY_DOCSUB = mysqlQuery("SELECT * FROM dognet_docsubpodr WHERE kodsubpodr='{$kodsub}' AND koddel<>'99'");
    while ($_ROW_DOCSUB = mysqli_fetch_assoc($_QRY_DOCSUB)) {
      $count += F_CHECK_SUBDOC_ZADOL($_ROW_DOCSUB['koddocsubpodr'], $ondate);
    }
    $result = $count > 0 ? 1 : 0;
  } else {
    $result = 0;
  }
  return $result;
}
#
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
#
#	Проверка договора субподряда на наличие задолженности
# IN  >>> $kodsub		- Идентификатор счета-фактуры
# IN  >>> $ondate	- Дата отсечки сплитов по дате (для справки о задолженности на дату). Если дата отсутствует (null), то суммируются ВСЕ сплиты
# OUT <<< 1 (есть задолженность) или 0
#
function F_SUM_DOCSSUB_CHF($kodsub, $koddoc, $ondate) {
  $result = "";
  $sum = 0;
  if (!empty($kodsub) && !empty($koddoc)) {
    $_QRY_DOCS = mysqlQuery("SELECT * FROM dognet_docsubpodr WHERE kodsubpodr='{$kodsub}' AND koddoc='{$koddoc}' AND koddel<>'99'");
    while ($_ROW_DOCS = mysqli_fetch_assoc($_QRY_DOCS)) {
      $sum += F_SUM_SUBDOC_CHF($_ROW_DOCS['koddocsubpodr'], $ondate);
    }
    $result = $sum;
  } else {
    $result = 0;
  }
  return $result;
}


function F_SUM_DOCSSUB_INCOM($kodsub, $koddoc, $ondate) {
  $result = "";


  return $result;
}
