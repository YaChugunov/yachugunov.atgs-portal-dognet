<?php
date_default_timezone_set('Europe/Moscow');
# Подключаем конфигурационный файл
// require $_SERVER['DOCUMENT_ROOT'] . "/config.inc.php";
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// require_once $_SERVER['DOCUMENT_ROOT'] . "/dognet/config.dognet.inc.php";
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Подключаемся к базе
require_once $_SERVER['DOCUMENT_ROOT'] . "/_assets/drivers/db_connection.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/_assets/drivers/db_controller.php";
$db_handle = new DBController();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Подключаем общие функции безопасности
require $_SERVER['DOCUMENT_ROOT'] . "/_assets/functions/funcSecure.inc.php";
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Подключаем собственные функции сервиса Почта
require $_SERVER['DOCUMENT_ROOT'] . "/dognet/_assets/functions/funcDognet.inc.php";
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Включаем режим сессии
session_start();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
$kodzayv = isset($_POST['kodzayv']) ? $_POST['kodzayv'] : "";
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

function updateFields($db, $action, $id, $values, $row, $kodzayv)
{

    $_timestamp = date("Y-m-d H:i:s");
    $_action    = "COMMENT";
    $_commentID = $kodzayv . ".Z." . time();

    $_reqDB_Users = $db->sql("SELECT firstname, middlename, lastname FROM users WHERE id=" . $_SESSION['id'])->fetchAll();
    $_username    = $_reqDB_Users[0]['lastname'] . " " . $_reqDB_Users[0]['firstname'];

    $_reqDB_Zavtel = $db->sql("SELECT * FROM dognet_spzayvtel WHERE userid=" . $_SESSION['id'])->fetchAll();
    $_kodzayvtel   = $_reqDB_Zavtel[0]['kodzayvtel'];

    if ($action == "CRT") {
        $db->update('dognet_doczayv_logComments', [
            'koddel'     => null,
            'timestamp'  => $_timestamp,
            'action'     => $_action,
            'commentID'  => $_commentID,
            'kodzayvtel' => $_kodzayvtel,
            'userid'     => $_SESSION['id'],
            'username'   => $_username,
        ], [
            'id' => $id,
        ]);
    }
    if ($action == "PREUPD") {
        $_REQ = mysqlQuery("UPDATE dognet_doczayv_logComments SET prevcommentText = commentText WHERE id = {$id}");
    }
    #
    #
    if ($action == "UPD") {
        $_reqDB_3 = $db->sql("SELECT commentID FROM dognet_doczayv_logComments WHERE id=" . $id)->fetchAll();
        $db->update('dognet_doczayv_logComments', [
            'update_timestamp' => $_timestamp,
            'update_userid'    => $_SESSION['id'],
            'update_username'  => $_username,
        ], [
            'id' => $id,
        ]);
    }
    #
    #
    if ($action == "DEL") {
    }
    #
    #
}

/*
Example PHP implementation used for the index.html example
*/
// DataTables PHP library
require $_SERVER['DOCUMENT_ROOT'] . "/dognet/_assets/_datatables-php-api-editor/DataTables.php";

// Alias Editor classes so they are easy to use
use DataTables\Editor;
use DataTables\Editor\Field;
use DataTables\Editor\Format;

// Build our Editor instance and process the data coming from _POST
Editor::inst($db, 'dognet_doczayv_logComments')
    ->fields(
        Field::inst('dognet_doczayv_logComments.id'),
        Field::inst('dognet_doczayv_logComments.koddel'),
        Field::inst('dognet_doczayv_logComments.timestamp')
            ->getFormatter(Format::datetime(
                'Y-m-d H:i:s',
                'd.m.Y H:i:s'
            )),
        Field::inst('dognet_doczayv_logComments.action'),
        Field::inst('dognet_doczayv_logComments.kodzayv'),
        Field::inst('dognet_doczayv_logComments.userid'),
        Field::inst('dognet_doczayv_logComments.username'),
        Field::inst('dognet_doczayv_logComments.commentID'),
        Field::inst('dognet_doczayv_logComments.prevcommentText'),
        Field::inst('dognet_doczayv_logComments.commentText'),
        Field::inst('dognet_doczayv_logComments.commentAdd'),
        Field::inst('dognet_doczayv_logComments.update_timestamp')
            ->getFormatter(Format::datetime(
                'Y-m-d H:i:s',
                'd.m.Y H:i:s'
            )),
        Field::inst('dognet_doczayv_logComments.update_userid'),
        Field::inst('dognet_doczayv_logComments.update_username'),

        Field::inst('users.firstname'),
        Field::inst('users.middlename'),
        Field::inst('users.lastname')
    )

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

    ->on('preGet', function ($editor, $id) use ($kodzayv) {
        $editor->where(function ($q) use ($kodzayv) {
            $q->where('dognet_doczayv_logComments.kodzayv', $kodzayv);
        });
    })
    ->on('postCreate', function ($editor, $id, $values, $row) use ($kodzayv) {
        updateFields($editor->db(), 'CRT', $id, $values, $row, $kodzayv);
    })
    ->on('preEdit', function ($editor, $id, $values) use ($kodzayv) {
        updateFields($editor->db(), 'PREUPD', $id, $values, null, $kodzayv);
    })
    ->on('postEdit', function ($editor, $id, $values, $row) use ($kodzayv) {
        updateFields($editor->db(), 'UPD', $id, $values, $row, $kodzayv);
    })

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

    ->leftJoin('users', 'users.ID', '=', 'dognet_doczayv_logComments.userid')
    ->process($_POST)
    ->json();
