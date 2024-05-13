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
# Подключаем общие функции безопасности
// require(dirname(__FILE__) . '/_assets/functions/funcSecure.inc.php');
require($_SERVER['DOCUMENT_ROOT'] . "/_assets/functions/funcSecure.inc.php");
# Подключаем собственные функции сервиса Почта
require($_SERVER['DOCUMENT_ROOT'] . "/dognet/_assets/functions/funcDognet.inc.php");
# Включаем режим сессии
session_start();
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция определения нового ID договора ( koddoc)
# для таблицы этапов 'dognet_docbase'
# ----- ----- -----
function nextKodzayvchet() {
	$query = mysqlQuery("SELECT MAX(kodzayvchet) as lastKod FROM dognet_doczayvchet ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastKod = $row['lastKod'];
	$nextKod = $lastKod + rand(3, 33);
	return $nextKod;
}
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция обновления полей основной таблицы (dognet_kalplanchf)
#
function updateFields_doczayvchet($db, $action_doczayvchet, $id, $values) {
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	#
	# :::
	# ::: Если была нажата кнопка "НОВЫЙ ДОГОВОР"
	# :::
	#
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	if ($action_doczayvchet == 'CRT') {
		#
		#
		// Формируем новый идентификатор договора (koddoc)
		$__nextKodzayvchet = nextKodzayvchet();

		$db->update('dognet_docbase', array(
			'kodzayvchet'			=>	$__nextKodzayvchet
		), array('id' => $id));
		#
		#


		#
		#
	}
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	#
	# :::
	# ::: Если была нажата кнопка "ИЗМЕНИТЬ"
	# :::
	#
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	if ($action_doczayvchet == 'UPD') {
		#
		#


		#
		#
	}
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	#
	# :::
	# ::: Если была нажата кнопка "УДАЛИТЬ"
	# :::
	#
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	if ($action_doczayvchet == 'DEL') {
		#
		#


		#
		#
	}
	#
	#
}
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция обновления полей основной таблицы (dognet_kalplanchf)
#
function doc_block_for_edit($db, $action_doczayvchet, $id, $values) {
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	#
	# :::
	# ::: Если была нажата кнопка "ИЗМЕНИТЬ"
	# :::
	#
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	if ($action_doczayvchet == 'UPD') {
		#
		#


		#
		#
	}
}
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
#
#
/*
 * Example PHP implementation used for the index.html example
*/
// DataTables PHP library
require($_SERVER['DOCUMENT_ROOT'] . "/dognet/_assets/_datatables-php-api-editor/DataTables.php");
// Alias Editor classes so they are easy to use
use
	DataTables\Editor,
	DataTables\Editor\Field,
	DataTables\Editor\Format,
	DataTables\Editor\Mjoin,
	DataTables\Editor\Options,
	DataTables\Editor\Upload,
	DataTables\Editor\Validate,
	DataTables\Editor\ValidateOptions;

if (!isset($_POST['chetfrom_year']) || !is_numeric($_POST['chetfrom_year'])) {
	echo json_encode(["data" => []]);
} else {
	$__chetfrom_year = $_POST['chetfrom_year'];

	// Build our Editor instance and process the data coming from _POST
	Editor::inst($db, 'dognet_doczayvchet')
		->fields(
			Field::inst('dognet_doczayvchet.ID'),
			Field::inst('dognet_doczayvchet.koddel'),
			Field::inst('dognet_doczayvchet.kodcontragent'),
			Field::inst('dognet_doczayvchet.kodzayv')
				->options(
					Options::inst()
						->table('dognet_doczayv')
						->value('dognet_doczayv.kodzayv')
						->label(array('dognet_doczayv.kodzayv', 'dognet_doczayv.numberzayv', 'dognet_doczayv.datezayv'))
						->render(function ($row) {
							return ($row['dognet_doczayv.datezayv'] . " : заявка № " . $row['dognet_doczayv.numberzayv']);
						})
						->where(function ($q) {
							$q->where('dognet_doczayv.koddel', '99', '!=');
						})
				)
				->validator(Validate::notEmpty(
					ValidateOptions::inst()
						->message('Заявка обязательна')
				)),
			Field::inst('dognet_doczayvchet.kodzayvchet'),
			Field::inst('dognet_doczayvchet.zayvchetnumber'),
			Field::inst('dognet_doczayvchet.zayvchetdate'),
			Field::inst('dognet_doczayvchet.zayvchetsumma'),
			Field::inst('dognet_doczayvchet.zayvchetpr'),
			Field::inst('dognet_doczayvchet.zayvchetzadol'),
			Field::inst('dognet_doczayvchet.zayvchetcomment'),
			Field::inst('dognet_doczayvchet.controlrab'),
			Field::inst('dognet_doczayvchet.zayvchetchetfcom'),
			Field::inst('dognet_doczayvchet.kodpokup'),
			Field::inst('dognet_doczayvchet.controlrab1'),
			// ----- ----- -----
			Field::inst('dognet_doczayv.kodzayv'),
			Field::inst('dognet_doczayv.koddoc'),
			Field::inst('dognet_doczayv.kodispol'),
			Field::inst('dognet_doczayv.kodzayvtel'),
			Field::inst('dognet_doczayv.kodrabzayv'),
			Field::inst('dognet_doczayv.datezayv'),
			Field::inst('dognet_doczayv.numberzayv'),
			Field::inst('dognet_doczayv.namedoc'),
			Field::inst('dognet_doczayv.kodrabfile'),
			Field::inst('dognet_doczayv.namerabfilespec'),
			Field::inst('dognet_doczayv.rabfileexp'),
			Field::inst('dognet_doczayv.tipusezayv'),
			Field::inst('dognet_doczayv.kodtipzayv'),
			Field::inst('dognet_doczayv.kodusecht'),
			Field::inst('dognet_doczayv.rabzayvdoc'),
			Field::inst('dognet_doczayv.zayvchetcom'),
			Field::inst('dognet_doczayv.kodtipzayvall'),
			Field::inst('dognet_doczayv.koduseobjwork'),
			Field::inst('dognet_doczayv.kodusepoligon'),
			Field::inst('dognet_doczayv.zayvchetcomall'),
			// ----- ----- -----
			Field::inst('dognet_spzayvtel.kodzayvtel'),
			Field::inst('dognet_spzayvtel.namezayvtel'),
			Field::inst('dognet_spzayvtel.namezayvtelshot'),
			// ----- ----- -----
			Field::inst('dognet_sptipzayvall.kodtipzayvall'),
			Field::inst('dognet_sptipzayvall.nametipzayvshotall'),
			Field::inst('dognet_sptipzayvall.nametipzayvfullall'),
			// ----- ----- -----
			Field::inst('dognet_docbase.koddoc'),
			Field::inst('dognet_docbase.docnumber'),
			Field::inst('dognet_docbase.docnameshot'),
			// ----- ----- -----
			Field::inst('sp_contragents.kodcontragent'),
			Field::inst('sp_contragents.nameshort'),
			Field::inst('sp_contragents.namefull'),
			// ----- ----- -----
			Field::inst('dognet_sppokup.kodpokup'),
			Field::inst('dognet_sppokup.namepokupshot'),
			Field::inst('dognet_sppokup.namepokupfull'),
			// ----- ----- -----
			Field::inst('dognet_spdened.koddened'),
			Field::inst('dognet_spdened.html_code'),
			Field::inst('dognet_spdened.short_code')
			# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			#
			#
		)
		#
		#
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		->leftJoin('dognet_doczayv', 'dognet_doczayv.kodzayv', '=', 'dognet_doczayvchet.kodzayv')
		->leftJoin('dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_doczayv.koddoc')
		->leftJoin('dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened')
		->leftJoin('sp_contragents', 'sp_contragents.kodcontragent', '=', 'dognet_doczayvchet.kodpost')
		->leftJoin('dognet_sppokup', 'dognet_sppokup.kodpokup', '=', 'dognet_doczayvchet.kodpokup')
		->leftJoin('dognet_spzayvtel', 'dognet_spzayvtel.kodzayvtel', '=', 'dognet_doczayv.kodzayvtel')
		->leftJoin('dognet_sptipzayv', 'dognet_sptipzayv.kodtipzayv', '=', 'dognet_doczayv.kodtipzayv')
		->leftJoin('dognet_sptipzayvall', 'dognet_sptipzayvall.kodtipzayvall', '=', 'dognet_doczayv.kodtipzayvall')
		->where('YEAR(dognet_doczayvchet.zayvchetdate)', $__chetfrom_year)
		->process($_POST)
		->json();
}
