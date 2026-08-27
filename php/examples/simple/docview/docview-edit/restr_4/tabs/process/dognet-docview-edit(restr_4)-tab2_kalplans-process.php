<?php
date_default_timezone_set('Europe/Moscow');
// Подключаем конфигурационный файл
// require($_SERVER['DOCUMENT_ROOT']."/config.inc.php");
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Подключаемся к базе
require_once $_SERVER['DOCUMENT_ROOT'].'/_assets/drivers/db_connection.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_assets/drivers/db_controller.php';
$db_handle = new DBController();
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Подключаем общие функции безопасности
// require(dirname(__FILE__) . '/_assets/functions/funcSecure.inc.php');
require $_SERVER['DOCUMENT_ROOT'].'/_assets/functions/funcSecure.inc.php';
// Подключаем собственные функции сервиса Почта
require $_SERVER['DOCUMENT_ROOT'].'/dognet/_assets/functions/funcDognet.inc.php';
// Включаем режим сессии
session_start();

//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Функция определения нового номера этапа (numberstage)
// для таблицы этапов 'dognet_dockalplan'
// ----- ----- -----
function updateFields($db, $action, $id, $values)
{
    $__koddoc = $_SESSION['uniqueID'];
    // $srokstage = date('Y-m-d');
    $srokstage = '';
    if ($action == 'CRT') {
        $__nextKodkalplan = nextKodkalplan();
        $_QRY = $db->sql('SELECT * FROM dognet_dockalplan WHERE id='.$id)->fetchAll();
        $koddoc = ! empty($_QRY[0]['koddoc']) ? $_QRY[0]['koddoc'] : '';
        $kodkalplan = ! empty($_QRY[0]['kodkalplan']) ? $_QRY[0]['kodkalplan'] : '';
        $idsrokstage = ! empty($_QRY[0]['idsrokstage']) ? $_QRY[0]['idsrokstage'] : '';

        // >>>>> CorrectionID#20230520-01
        // Правка от 20.05.2023
        // Добавляем сохранение названий объектов (nameobjectshot, nameobjectlong) для реализации полнотекстового поиска
        $_QRY_SPOBJ = $db->sql('SELECT nameobjectshot, nameobjectlong FROM sp_objects WHERE kodobject='.$_QRY[0]['kodobject'])->fetchAll();

        // <<<<< CorrectionID#20230520-01

        // Добавляем этап в таблицу прогресса
        // -----
        $expiry_date = NULL;
        if ($idsrokstage == 1) {
            $srokstage = $_QRY[0]['srokstage_date'];
            $expiry_date = $_QRY[0]['srokstage_date'];
        } elseif ($idsrokstage == 0 && $_QRY[0]['srokstage'] != '') {
            $srokstage = $_QRY[0]['srokstage'];
            $_QRY_AV = $db->sql("SELECT MIN(dateavans) as firstavans FROM dognet_docavans WHERE koddoc='{$kodkalplan}'")->fetchAll();
            if ($_QRY_AV[0]['firstavans'] != '') {
                $dateavans = new DateTime($_QRY_AV[0]['firstavans']);
                $firstavans = $dateavans->format('Y-m-d');
                if (is_string($srokstage)) {
                    $srokdays = (int) $srokstage;
                }
                $expiry_date = $dateavans->add(new DateInterval('P'.$srokdays.'D'))->format('Y-m-d');
            } else {
                $expiry_date = NULL;
            }
        }

        $db->update('dognet_dockalplan', array(
            'kodkalplan' => $__nextKodkalplan,
            'koddoc' => $__koddoc,
            'nameobjectshort' => $_QRY_SPOBJ[0]['nameobjectshot'],
            'nameobjectfull' => $_QRY_SPOBJ[0]['nameobjectlong'],
            'srokstage_date' => $expiry_date,
        ), array('id' => $id));

        // -----
        $db->insert('dognet_dockalplan_progress', array(
            'koddoc' => $__koddoc,
            'kodkalplan' => $__nextKodkalplan,
            'stagecreated' => date('Y-m-d'),
            'idsrokstage' => $idsrokstage,
            'srokstage' => $srokstage,
            'srokstage_date' => $expiry_date,
            'idsrokopl' => $_QRY[0]['idsrokopl'],
            'srokopl' => $_QRY[0]['srokopl'],
            'dateplan' => $_QRY[0]['dateplan'],
            'numberdayoplstage' => $_QRY[0]['numberdayoplstage'],
            'dateoplall' => $_QRY[0]['dateoplall'],
            'summastage' => $_QRY[0]['summastage'],
            'sumchfstage' => '',
            'sumavstage' => '',
            'sumoplchfstage' => '',
            'sumoplavstage' => '',
            'zadolsum_stage' => $_QRY[0]['summastage'],
            'zadolsum_chf' => '',
            'zadolsum_av' => '',
        ));

        // Делаем запись в системный лог
        // Все параметры в таблице portal_log_messages
        PORTAL_SYSLOG('99940200', '0000001', $id, $__nextKodkalplan, $_QRY[0]['numberstage'], $_QRY[0]['koddoc']);
    }
    //
    //
    if ($action == 'UPD') {
        $_QRY = $db->sql('SELECT * FROM dognet_dockalplan WHERE id='.$id)->fetchAll();
        if ($_QRY[0]['idsrokstage'] != 1) {
            $db->update('dognet_dockalplan', array(
                'srokstage_date' => null,
            ), array('id' => $id));
        }
        $kodkalplan = ! empty($_QRY[0]['kodkalplan']) ? $_QRY[0]['kodkalplan'] : '';
        // >>>>> CorrectionID#20230520-01
        // Правка от 20.05.2023
        // Добавляем сохранение названий объектов (nameobjectshot, nameobjectlong) для реализации полнотекстового поиска
        $_QRY_SPOBJ = $db->sql('SELECT nameobjectshot, nameobjectlong FROM sp_objects WHERE kodobject='.$_QRY[0]['kodobject'])->fetchAll();
        // <<<<< CorrectionID#20230520-01

        // -----
        // Суммируем все счета-фактуры по этапу ($_QRY2[0]['koddoc'])
        $_QRY_SUMCHF = $db->sql("SELECT SUM(chetfsumma) as sum1 FROM dognet_kalplanchf WHERE kodkalplan='{$kodkalplan}' AND koddel<>'99'")->fetchAll();
        // -----
        $expiry_date = NULL;
        if ($_QRY[0]['idsrokstage'] == 1) {
            $srokstage = $_QRY[0]['srokstage_date'];
            $expiry_date = $_QRY[0]['srokstage_date'];
        } elseif ($_QRY[0]['idsrokstage'] == 0 && $_QRY[0]['srokstage'] != '') {
            $srokstage = $_QRY[0]['srokstage'];
            $_QRY_AV = $db->sql("SELECT MIN(dateavans) as firstavans FROM dognet_docavans WHERE koddoc='{$kodkalplan}'")->fetchAll();
            if ($_QRY_AV[0]['firstavans'] != '') {
                $dateavans = new DateTime($_QRY_AV[0]['firstavans']);
                $firstavans = $dateavans->format('Y-m-d');
                if (is_string($srokstage)) {
                    $srokdays = (int) $srokstage;
                }
                $expiry_date = $dateavans->add(new DateInterval('P'.$srokdays.'D'))->format('Y-m-d');
            } else {
                $expiry_date = NULL;
            }
        }

        $db->update('dognet_dockalplan', array(
            'nameobjectshort' => $_QRY_SPOBJ[0]['nameobjectshot'],
            'nameobjectfull' => $_QRY_SPOBJ[0]['nameobjectlong'],
            'srokstage_date' => $expiry_date,
        ), array('id' => $id));

        // * - - - - - - - - - -
        // * UPD 07.10.24
        // * Делаем проверку на случай если этап не добавился в таблицу dognet_dockalplan_progress
        // *
        $_kkp = ! empty($_QRY[0]['kodkalplan']) ? $_QRY[0]['kodkalplan'] : '';
        $_reqCheck = mysqlQuery("SELECT * FROM dognet_dockalplan_progress WHERE kodkalplan='{$_kkp}'");
        if (mysqli_num_rows($_reqCheck) > 0) {
            // Обновляем этап в таблице прогресса
            $db->update('dognet_dockalplan_progress', array(
                'idsrokstage' => $_QRY[0]['idsrokstage'],
                'srokstage' => $srokstage,
                'srokstage_date' => $expiry_date,
                'idsrokopl' => $_QRY[0]['idsrokopl'],
                'srokopl' => $_QRY[0]['srokopl'],
                'dateplan' => $_QRY[0]['dateplan'],
                'numberdayoplstage' => $_QRY[0]['numberdayoplstage'],
                'dateoplall' => $_QRY[0]['dateoplall'],
                'summastage' => $_QRY[0]['summastage'],
                'zadolsum_stage' => $_QRY[0]['summastage'] - $_QRY_SUMCHF[0]['sum1'],
            ), array(
                'kodkalplan' => $_kkp,
            ));
            // Делаем запись в системный лог
            // Все параметры в таблице portal_log_messages
            PORTAL_SYSLOG('99940200', '0000002', $id, null, null, null);
        } else {
            $sumchstage = DOCBASE_FN_SUM_CHF_STAGE($kodkalplan);
            $sumavstage = DOCBASE_FN_SUM_AVANS_STAGE($kodkalplan);
            $sumoplchfstage = DOCBASE_FN_SUM_OPLATCHF_STAGE($kodkalplan);
            $sumoplavstage = DOCBASE_FN_SUM_AVANSCHF_STAGE($kodkalplan);
            //
            $zadolchfstage = $sumchstage - ($sumoplchfstage + $sumoplavstage);
            $zadolavstage = $sumavstage - $sumoplavstage;
            //
            $db->insert('dognet_dockalplan_progress', array(
                'koddoc' => $_QRY[0]['koddoc'],
                'kodkalplan' => $_QRY[0]['kodkalplan'],
                'stagecreated' => date('Y-m-d'),
                'idsrokstage' => $_QRY[0]['idsrokstage'],
                'srokstage' => $srokstage,
                'srokstage_date' => $expiry_date,
                'idsrokopl' => $_QRY[0]['idsrokopl'],
                'srokopl' => $_QRY[0]['srokopl'],
                'dateplan' => $_QRY[0]['dateplan'],
                'numberdayoplstage' => $_QRY[0]['numberdayoplstage'],
                'dateoplall' => $_QRY[0]['dateoplall'],
                'summastage' => $_QRY[0]['summastage'],
                'sumchfstage' => $sumchstage,
                'sumavstage' => $sumavstage,
                'sumoplchfstage' => $sumoplchfstage,
                'sumoplavstage' => $sumoplavstage,
                'zadolsum_stage' => $_QRY[0]['summastage'] - $_QRY_SUMCHF[0]['sum1'],
                'zadolsum_chf' => $zadolchfstage,
                'zadolsum_av' => $zadolavstage,
            ));
            // Делаем запись в системный лог
            // Все параметры в таблице portal_log_messages
            PORTAL_SYSLOG('99940200', '0000001', $id, $_kkp, $_QRY[0]['numberstage'], $_QRY[0]['koddoc']);
        }
        // *
        // * - - - - - - - - - -
    }
    //
    //
    if ($action == 'DEL') {
        // Делаем запись в системный лог
        // Все параметры в таблице portal_log_messages
        PORTAL_SYSLOG('99940200', '0000003', $id, null, null, null);
    }
    //
    //
}

//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Функция определения нового номера этапа (numberstage)
// для таблицы этапов 'dognet_dockalplan'
// ----- ----- -----
function removeProgress($db, $id, $values)
{
    $_QRY1 = $db->sql('SELECT kodkalplan FROM dognet_dockalplan WHERE id='.$id)->fetchAll();
    $_QRY2 = $db->sql('DELETE FROM dognet_dockalplan_progress WHERE kodkalplan='.$_QRY1[0]['kodkalplan']);
}

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
$__uniqueID = $_SESSION['uniqueID'];
// $__uniqueID = "245847329098834";
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
//
//
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//

/*
 * Example PHP implementation used for the index.html example
 */
// DataTables PHP library
require $_SERVER['DOCUMENT_ROOT'].'/dognet/_assets/_datatables-php-api-editor/DataTables.php';

// Alias Editor classes so they are easy to use
use DataTables\Editor\Field;
use DataTables\Editor\Format;
use DataTables\Editor\Options;
use DataTables\Editor\Validate;
use DataTables\Editor\ValidateOptions;
use DataTables\Editor;

// Build our Editor instance and process the data coming from _POST
Editor::inst($db, 'dognet_dockalplan')
    ->fields(
        Field::inst('dognet_docbase.koddel'),
        Field::inst('dognet_docbase.kodtip'),
        Field::inst('dognet_dockalplan.kodkalplan'),
        Field::inst('dognet_dockalplan.numberstage')
            ->validator(Validate::notEmpty(
                ValidateOptions::inst()
                    ->message('Номер этапа')
            )),
        Field::inst('dognet_dockalplan.nameshotstage')
            ->validator(Validate::notEmpty(
                ValidateOptions::inst()
                    ->message('Хотя бы краткое описание')
            )),
        Field::inst('dognet_dockalplan.namefullstage'),
        Field::inst('dognet_dockalplan.summastage'),
        // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
        Field::inst('dognet_dockalplan.srokstage'),
        Field::inst('dognet_dockalplan.srokstage_date')
            ->validator(Validate::dateFormat(
                'd/m/Y',
                ValidateOptions::inst()
                    ->allowEmpty(true)
            ))
            ->getFormatter(Format::datetime(
                'Y-m-d',
                'd/m/Y'
            ))
            ->setFormatter(Format::datetime(
                'd/m/Y',
                'Y-m-d'
            )),
        Field::inst('dognet_dockalplan.idsrokstage'),
        Field::inst('dognet_dockalplan.idobjectready'),
        Field::inst('dognet_dockalplan.srokopl'),
        Field::inst('dognet_dockalplan.idsrokopl'),
        // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
        Field::inst('dognet_dockalplan.useav1plan'),
        Field::inst('dognet_dockalplan.pravplan1stage'),
        Field::inst('dognet_dockalplan.dateplanav1stage')
            ->validator(Validate::dateFormat(
                'd.m.Y',
                ValidateOptions::inst()
                    ->allowEmpty(true)
            ))
            ->getFormatter(Format::datetime(
                'Y-m-d',
                'd.m.Y'
            ))
            ->setFormatter(Format::datetime(
                'd.m.Y',
                'Y-m-d'
            )),
        Field::inst('dognet_dockalplan.daysplanav1stage'),
        Field::inst('dognet_dockalplan.useav2plan'),
        Field::inst('dognet_dockalplan.pravplan2stage'),
        Field::inst('dognet_dockalplan.dateplanav2stage')
            ->validator(Validate::dateFormat(
                'd.m.Y',
                ValidateOptions::inst()
                    ->allowEmpty(true)
            ))
            ->getFormatter(Format::datetime(
                'Y-m-d',
                'd.m.Y'
            ))
            ->setFormatter(Format::datetime(
                'd.m.Y',
                'Y-m-d'
            )),
        Field::inst('dognet_dockalplan.daysplanav2stage'),
        Field::inst('dognet_dockalplan.useav3plan'),
        Field::inst('dognet_dockalplan.pravplan3stage'),
        Field::inst('dognet_dockalplan.dateplanav3stage')
            ->validator(Validate::dateFormat(
                'd.m.Y',
                ValidateOptions::inst()
                    ->allowEmpty(true)
            ))
            ->getFormatter(Format::datetime(
                'Y-m-d',
                'd.m.Y'
            ))
            ->setFormatter(Format::datetime(
                'd.m.Y',
                'Y-m-d'
            )),
        Field::inst('dognet_dockalplan.daysplanav3stage'),
        Field::inst('dognet_dockalplan.useav4plan'),
        Field::inst('dognet_dockalplan.pravplan4stage'),
        Field::inst('dognet_dockalplan.dateplanav4stage')
            ->validator(Validate::dateFormat(
                'd.m.Y',
                ValidateOptions::inst()
                    ->allowEmpty(true)
            ))
            ->getFormatter(Format::datetime(
                'Y-m-d',
                'd.m.Y'
            ))
            ->setFormatter(Format::datetime(
                'd.m.Y',
                'Y-m-d'
            )),
        Field::inst('dognet_dockalplan.daysplanav4stage'),
        // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
        Field::inst('dognet_dockalplan.numberdayoplstage'),
        Field::inst('dognet_dockalplan.dateplan')
            ->validator(Validate::dateFormat(
                'd.m.Y',
                ValidateOptions::inst()
                    ->allowEmpty(true)
            ))
            ->getFormatter(Format::datetime(
                'Y-m-d',
                'd.m.Y'
            ))
            ->setFormatter(Format::datetime(
                'd.m.Y',
                'Y-m-d'
            ))
            ->validator(Validate::notEmpty(
                ValidateOptions::inst()
                    ->message('Дата окончания этапа')
            )),
        Field::inst('dognet_dockalplan.dateplanbegin')
            ->validator(Validate::dateFormat(
                'd.m.Y',
                ValidateOptions::inst()
                    ->allowEmpty(true)
            ))
            ->getFormatter(Format::datetime(
                'Y-m-d',
                'd.m.Y'
            ))
            ->setFormatter(Format::datetime(
                'd.m.Y',
                'Y-m-d'
            )),
        Field::inst('dognet_dockalplan.dateoplall')
            ->validator(Validate::dateFormat(
                'd.m.Y',
                ValidateOptions::inst()
                    ->allowEmpty(true)
            ))
            ->getFormatter(Format::datetime(
                'Y-m-d',
                'd.m.Y'
            ))
            ->setFormatter(Format::datetime(
                'd.m.Y',
                'Y-m-d'
            ))
            ->validator(Validate::notEmpty(
                ValidateOptions::inst()
                    ->message('Дата полной оплаты')
            )),
        Field::inst('dognet_dockalplan.usedocsubpodr'),
        // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
        Field::inst('sp_objects.nameobjectshot'),
        Field::inst('dognet_dockalplan.kodobject')
            ->options(
                Options::inst()
                    ->table('sp_objects')
                    ->value('kodobject')
                    ->label(array('kodobject', 'nameobjectshot'))
                    ->render(function ($row) {
                        return $row['nameobjectshot'];
                    })
            )
            ->validator(Validate::notEmpty(
                ValidateOptions::inst()
                    ->message('Объект обязателен')
            )),
        // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
        Field::inst('dognet_dockalplan.warranty_period'),  // Добавлено 2023-08-28
        Field::inst('dognet_docbase.koddened'),
        Field::inst('dognet_docbase.docnumber'),
        Field::inst('dognet_docbase.kodobject'),
        Field::inst('dognet_spdened.koddened'),
        Field::inst('dognet_spdened.html_code'),
        Field::inst('dognet_spdened.short_code')
        // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    )
    //
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    //
    ->on('preGet', function ($editor, $id) use ($__uniqueID) {
        $editor->where(function ($q) use ($__uniqueID) {
            $q->where('dognet_dockalplan.koddoc', $__uniqueID);
            $q->and_where('dognet_dockalplan.koddel', '99', '!=');
        });
    })
    //
    ->on('postCreate', function ($editor, $id, $values, $row) {
        updateFields($editor->db(), 'CRT', $id, $values);
    })
    ->on('postEdit', function ($editor, $id, $values, $row) {
        updateFields($editor->db(), 'UPD', $id, $values);
    })
    ->on('preRemove', function ($editor, $id, $values) {
        removeProgress($editor->db(), $id, $values);
        updateFields($editor->db(), 'DEL', $id, $values);
    })
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    //
    ->leftJoin('dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_dockalplan.koddoc')
    ->leftJoin('dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened')
    ->leftJoin('sp_objects', 'sp_objects.kodobject', '=', 'dognet_dockalplan.kodobject')
    ->process($_POST)
    ->json();
