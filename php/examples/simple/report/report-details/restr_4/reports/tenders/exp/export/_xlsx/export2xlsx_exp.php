<?php
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
# Создаем страницу
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Создаем новый лист
$objPHPExcel->createSheet();
// Устанавливаем индекс активного листа
$cntsheets = $objPHPExcel->getSheetCount();
$objPHPExcel->setActiveSheetIndex($cntsheets - 1);
// Получаем активный лист
$activeSheet = $objPHPExcel->getActiveSheet();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
# Подготавляваем страницу
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
// Вставляем лого в колонтитул
$objDrawing = new PHPExcel_Worksheet_HeaderFooterDrawing();
$objDrawing->setName('АТГС.Договор');
// $objDrawing->setPath('logo_dognet.png');
// $objDrawing->setHeight(36);
// $objPHPExcel->getActiveSheet()->getHeaderFooter()->addImage($objDrawing, PHPExcel_Worksheet_HeaderFooter::IMAGE_HEADER_LEFT);
#
// Ориентация страницы и  размер листа
$activeSheet->getPageSetup()
	->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$activeSheet->getPageSetup()
	->SetPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
#
// $activeSheet->getSheetView()->setView(PHPExcel_Worksheet_SheetView::SHEETVIEW_PAGE_LAYOUT);
// Задаем повторяющиеся строки листа
$activeSheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 3);
#
// Задаем область печати
$activeSheet->getPageSetup()->setFitToWidth(1);
$activeSheet->getPageSetup()->setFitToHeight(0);
// $activeSheet->getPageSetup()->setPrintArea('A1:E100');
#
// Поля документа
$activeSheet->getPageMargins()->setTop(1);
$activeSheet->getPageMargins()->setRight(0.75);
$activeSheet->getPageMargins()->setLeft(0.75);
$activeSheet->getPageMargins()->setBottom(1);
#
// Название листа
$activeSheet->setTitle('Перечень договоров');
#
// Колонтитулы
$activeSheet->getHeaderFooter()->setOddHeader('&L&G&B&12СПРАВКА ОБ ОПЫТЕ ВЫПОЛНЕНИЯ ПОСТАВОК ТОВАРА, ПОДОБНОГО ПРЕДМЕТУ ЗАКУПКИ ЗА ПОСЛЕДНИЕ ТРИ ГОДА + ТЕКУЩИЙ&R&G&B&12');
$activeSheet->getHeaderFooter()->setOddFooter('&11&L&B' . $_SESSION["current_user_firstname"] . ' ' . $_SESSION["current_user_lastname"] . ' / ' . date('d.m.Y H:i:s') . '&R&11Страница &P из &N');
#
// Настройки шрифта
$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');
$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
// Задаем свой формат
define("PRICE_FORMAT_1", PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1 . "[\$ р.-419]");
// Предопределим массивы оформления границы ячеек
$_BORDER_RIGHT = array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))));
$_BORDER_RIGHT_NONE = array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_NONE)));
$_BORDER_LEFT = array('borders' => array('left' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))));
$_BORDER_LEFT_NONE = array('borders' => array('left' => array('style' => PHPExcel_Style_Border::BORDER_NONE)));
// Внешняя рамка, тонкая
$_BORDER_OUTSIDE_THIN = array('borders' => array('outline' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))));
// Внешняя рамка, толстая
$_BORDER_OUTSIDE_THICK = array('borders' => array('outline' => array('style' => PHPExcel_Style_Border::BORDER_THICK, 'color' => array('rgb' => '000000'))));
// Внутренние разделители
$_BORDER_INSIDE = array('borders' => array('inside' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))));
$_BORDER_INSIDE_NONE = array('borders' => array('inside' => array('style' => PHPExcel_Style_Border::BORDER_NONE)));
$_BORDER_TOP = array('borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))));
$_BORDER_BOTTOM_THIN = array('borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))));
$_BORDER_BOTTOM_THICK = array('borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_THICK, 'color' => array('rgb' => '000000'))));
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
// $start_date = date("Y-m-d", strtotime($_GET['start_date']));
// $end_date = date("Y-m-d", strtotime($_GET['end_date']));
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# ФОРМАТИРУЕМ ВЫХОДНУЮ ТАБЛИЦУ EXCEL
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
// Задаем ширины столбцов
$activeSheet->getColumnDimension('A')->setWidth(10); // Номер
$activeSheet->getColumnDimension('B')->setWidth(55); // Предмет договора
$activeSheet->getColumnDimension('C')->setWidth(25); // Наименование товара
$activeSheet->getColumnDimension('D')->setWidth(20); // Коды ОКПД товара, подобного предмету закупки
$activeSheet->getColumnDimension('E')->setWidth(25); // Федеральный округ
$activeSheet->getColumnDimension('F')->setWidth(45); // Заказчик
$activeSheet->getColumnDimension('G')->setWidth(20); // ИНН заказчика
$activeSheet->getColumnDimension('H')->setWidth(20); // Сумма всего договора
$activeSheet->getColumnDimension('I')->setWidth(15); // Дата заключения договора (дата начала этапа/спецификаии)
$activeSheet->getColumnDimension('J')->setWidth(15); // Дата завершения договора (дата последнего СФ при закрытии)
$activeSheet->getColumnDimension('K')->setWidth(25); // Договор, этап
$activeSheet->getColumnDimension('L')->setWidth(25); // Отзыв (опционально)
$activeSheet->getColumnDimension('M')->setWidth(55); // Статус договора (опционально)
#
// Для удобства заводим переменную $line, в ней будем считать номер строки
$line = 1;
#
# ----- ----- ----- ----- -----
# СТРОКА 1
# ----- ----- ----- ----- -----
// Выводим название отчета
$activeSheet->setCellValue("A{$line}", 'СПРАВКА ОБ ОПЫТЕ ВЫПОЛНЕНИЯ ПОСТАВОК ТОВАРА, ПОДОБНОГО ПРЕДМЕТУ ЗАКУПКИ ЗА ПОСЛЕДНИЕ ТРИ ГОДА + ТЕКУЩИЙ');
// Задаем высоту строки
$activeSheet->getRowDimension($line)->setRowHeight(24);
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:M{$line}");
// Делаем выравнивание по центру вертикали и горизонтали
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("A{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Делаем текст жирным и увеличиваем шрифт.
$activeSheet->getStyle("A{$line}")->getFont()->setBold(true);
$activeSheet->getStyle("A{$line}")->getFont()->setSize(15);
#
# ----- ----- ----- ----- -----
# СТРОКА 2
# ----- ----- ----- ----- -----
$line++;
// Выводим название отчета
$activeSheet->setCellValue("A{$line}", 'Дата отчета: ' . date("d.m.Y H:i:s"));
// Задаем высоту строки
$activeSheet->getRowDimension($line)->setRowHeight(20);
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:M{$line}");
// Делаем выравнивание по центру вертикали и горизонтали
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("A{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Делаем текст жирным и увеличиваем шрифт.
$activeSheet->getStyle("A{$line}")->getFont()->setBold(true);
$activeSheet->getStyle("A{$line}")->getFont()->setSize(13);
#
# ----- ----- ----- ----- -----
# СТРОКА 3
# ----- ----- ----- ----- -----
$line++;
// Выводим название отчета
$activeSheet->setCellValue("A{$line}", "Отчет составлен: " . $_SESSION['lastname'] . " " . $_SESSION['firstname'] . " " . $_SESSION['middlename']);
// Задаем высоту строки
$activeSheet->getRowDimension($line)->setRowHeight(20);
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:M{$line}");
// Делаем выравнивание по центру вертикали и горизонтали
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("A{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Делаем текст жирным и увеличиваем шрифт.
$activeSheet->getStyle("A{$line}")->getFont()->setBold(true);
$activeSheet->getStyle("A{$line}")->getFont()->setSize(13);
#
# ----- ----- ----- ----- -----
# СТРОКА 4-5
# ----- ----- ----- ----- -----
$line++;
#
$_cntYearSelector = "";
if (!empty($_GET['YearSelector']) && isset($_GET['YearSelector'])) {
	$_arrYearSelector = $_GET['YearSelector'];
	$_cntYearSelector = count($_arrYearSelector);
}
$_cntStatusSelector = "";
if (!empty($_GET['StatusSelector']) && isset($_GET['StatusSelector'])) {
	$_arrStatusSelector = $_GET['StatusSelector'];
	$_cntStatusSelector = count($_arrStatusSelector);
}
#
// Выводим название отчета
$_yearTitleStr = "";
if ($_cntYearSelector == 0) {
	$_yearTitleStr .= "---";
} else {
	for ($i = 0; $i < $_cntYearSelector; $i++) {
		if ($i < ($_cntYearSelector - 1)) {
			$_yearTitleStr .= $_arrYearSelector[$i] . ", ";
		}
		if ($i == ($_cntYearSelector - 1)) {
			$_yearTitleStr .= $_arrYearSelector[$i];
		}
	}
}
$_yearTitleStr .= "";
//
$_statusTitleStr = "";
if ($_cntStatusSelector == 0) {
	$_statusTitleStr .= "---";
} else {
	for ($i = 0; $i < $_cntStatusSelector; $i++) {
		$_QRY_STS = mysqlQuery(" SELECT statusnameshot FROM dognet_spstatus WHERE kodstatus='" . $_arrStatusSelector[$i] . "'");
		$_ROW_STS = mysqli_fetch_assoc($_QRY_STS);

		if ($i < ($_cntStatusSelector - 1)) {
			$_statusTitleStr .= $_ROW_STS['statusnameshot'] . ", ";
		}
		if ($i == ($_cntStatusSelector - 1)) {
			$_statusTitleStr .= $_ROW_STS['statusnameshot'];
		}
	}
}
$_statusTitleStr .= "";
#
$activeSheet->setCellValue("A{$line}", "Фильтр экспорта по году закрытия:");
$activeSheet->setCellValue("C{$line}", $_yearTitleStr);
// Задаем высоту строки
$activeSheet->getRowDimension($line)->setRowHeight(20);
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:B{$line}");
$activeSheet->mergeCells("C{$line}:M{$line}");
// Делаем выравнивание по центру вертикали и горизонтали
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("C{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("A{$line}:M{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Делаем текст жирным и увеличиваем шрифт.
$activeSheet->getStyle("A{$line}")->getFont()->setBold(false);
$activeSheet->getStyle("C{$line}")->getFont()->setBold(true);
$activeSheet->getStyle("A{$line}:M{$line}")->getFont()->setSize(12);
#
#
$line++;
$activeSheet->setCellValue("A{$line}", "Фильтр экспорта по статусу договора:");
$activeSheet->setCellValue("C{$line}", $_statusTitleStr);
// Задаем высоту строки
$activeSheet->getRowDimension($line)->setRowHeight(20);
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:B{$line}");
$activeSheet->mergeCells("C{$line}:M{$line}");
// Делаем выравнивание по центру вертикали и горизонтали
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("C{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("A{$line}:M{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Делаем текст жирным и увеличиваем шрифт.
$activeSheet->getStyle("A{$line}")->getFont()->setBold(false);
$activeSheet->getStyle("C{$line}")->getFont()->setBold(true);
$activeSheet->getStyle("A{$line}:M{$line}")->getFont()->setSize(12);
#
#
$line++;
$activeSheet->setCellValue("A{$line}", "Дополнительные обозначения в столбцах (9) и (10):");
$activeSheet->setCellValue("C{$line}", "(ПЛ) - планируемая дата начала этапа (если этой даты нет - выводится дата начала договора), (СФ) - дата последнего счета-фактуры по этапу, (ДГ) - дата закрытия договора, выделенная цветом строка - рамочный договор");
// Задаем высоту строки
$activeSheet->getRowDimension($line)->setRowHeight(20);
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:B{$line}");
$activeSheet->mergeCells("C{$line}:M{$line}");
// Делаем выравнивание по центру вертикали и горизонтали
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("C{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("A{$line}:M{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Делаем текст жирным и увеличиваем шрифт.
$activeSheet->getStyle("A{$line}")->getFont()->setBold(false);
$activeSheet->getStyle("C{$line}")->getFont()->setBold(false);
$activeSheet->getStyle("A{$line}:M{$line}")->getFont()->setSize(12);
#
# ----- ----- ----- ----- -----
# СТРОКА ШАПКИ ТАБЛИЦЫ (строка 2)
# ----- ----- ----- ----- -----
$line++;
// Шапка таблицы
$activeSheet->setCellValue("A{$line}", '№' . "\n" . 'п/п');
$activeSheet->setCellValue("B{$line}", 'ПРЕДМЕТ ДОГОВОРА ПОСТАВКИ');
$activeSheet->setCellValue("C{$line}", 'НАИМЕНОВАНИЕ ТОВАРА' . "\n" . 'В СОСТАВЕ ДОГОВОРА ПОСТАВКИ' . "\n" . 'ПОДОНОГО ПРЕДМЕТУ ЗАКУПКИ');
$activeSheet->setCellValue("D{$line}", 'КОД(Ы) ОКПД2 ТОВАРА' . "\n" . 'ПОДОБНОГО ПРЕДМЕТУ ЗАКУПКИ');
$activeSheet->setCellValue("E{$line}", 'ФЕДЕРАЛЬНЫЙ ОКРУГ ПОСТАВКИ');
$activeSheet->setCellValue("F{$line}", 'НАИМЕНОВАНИЕ ЗАКАЗЧИКА');
$activeSheet->setCellValue("G{$line}", 'ИНН ЗАКАЗЧИКА');
$activeSheet->setCellValue("H{$line}", 'СУММА ВСЕГО ДОГОВОРА ПОСТАВКИ / ' . "\n" . 'СУММА ДОГОВОРА ПОСТАВКИ ТОВАРА' . "\n" . 'ПОДОБНОГО ПРЕДМЕТУ ЗАКУПКИ' . "\n" . 'В РУБЛЯХ С НДС');
$activeSheet->setCellValue("I{$line}", 'ДАТА ЗАКЛЮЧЕНИЯ' . "\n" . 'ДОГОВОРА');
$activeSheet->setCellValue("J{$line}", 'ДАТА ЗАВЕРШЕНИЯ' . "\n" . 'ДОГОВОРА');
$activeSheet->setCellValue("K{$line}", 'ДОГОВОР,' . "\n" . '(ЭТАП / СПЕЦИФИКАЦИЯ)');
$activeSheet->setCellValue("L{$line}", 'ОТЗЫВ');
$activeSheet->setCellValue("M{$line}", 'СТАТУС ДОГОВОРА');
// Стили для текста в шапки таблицы.
$activeSheet->getRowDimension($line)->setRowHeight(128); // высота строки
$activeSheet->getStyle("A{$line}:M{$line}")->getFont()->setSize(10); // размер шрифта
$activeSheet->getStyle("A{$line}:M{$line}")->getFont()->setBold(true); // делаем шрифт жирным
$activeSheet->getStyle("A{$line}:M{$line}")->getAlignment()->setWrapText(true); // разрешаем перенос строк в ячейке

// Выравнивание по вертикали - середина
$activeSheet->getStyle("A{$line}:M{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Выравнивание по горизонтали
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$activeSheet->getStyle("B{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("C{$line}:E{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$activeSheet->getStyle("F{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("G{$line}:J{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$activeSheet->getStyle("K{$line}:M{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
// Делаем заливку области ячеек
$activeSheet->getStyle("A{$line}:M{$line}")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$activeSheet->getStyle("A{$line}:M{$line}")->getFill()->getStartColor()->setRGB("31708F");
// Задаем цвет текста строки
$activeSheet->getStyle("A{$line}:M{$line}")->getFont()->getColor()->setRGB('FFFFFF');
// Оформляем границы
$activeSheet->getStyle("A{$line}:M{$line}")->applyFromArray($_BORDER_INSIDE);
$activeSheet->getStyle("A{$line}:M{$line}")->applyFromArray($_BORDER_OUTSIDE_THIN);
#
#
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
$line++;
$start_table = $line;
// Шапка таблицы
$activeSheet->setCellValue("A{$line}", '1');
$activeSheet->setCellValue("B{$line}", '2');
$activeSheet->setCellValue("C{$line}", '3');
$activeSheet->setCellValue("D{$line}", '4');
$activeSheet->setCellValue("E{$line}", '5');
$activeSheet->setCellValue("F{$line}", '6');
$activeSheet->setCellValue("G{$line}", '7');
$activeSheet->setCellValue("H{$line}", '8');
$activeSheet->setCellValue("I{$line}", '9');
$activeSheet->setCellValue("J{$line}", '10');
$activeSheet->setCellValue("K{$line}", '11');
$activeSheet->setCellValue("L{$line}", '12');
$activeSheet->setCellValue("M{$line}", '13');
// Стили для текста в шапки таблицы.
$activeSheet->getRowDimension($line)->setRowHeight(18); // высота строки
$activeSheet->getStyle("A{$line}:M{$line}")->getFont()->setSize(9); // размер шрифта
$activeSheet->getStyle("A{$line}:M{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); // вырванивание по вертикали - середина
// Выравнивание по горизонтали - центр
$activeSheet->getStyle("A{$line}:M{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// Делаем заливку области ячеек
$activeSheet->getStyle("A{$line}:M{$line}")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$activeSheet->getStyle("A{$line}:M{$line}")->getFill()->getStartColor()->setRGB("F1F1F1");
// Задаем цвет текста строки
$activeSheet->getStyle("A{$line}:M{$line}")->getFont()->getColor()->setRGB('999999');
// Оформляем границы
$activeSheet->getStyle("A{$line}:M{$line}")->applyFromArray($_BORDER_INSIDE);
$activeSheet->getStyle("A{$line}:M{$line}")->applyFromArray($_BORDER_OUTSIDE_THIN);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
$qryPart = "SELECT koddoc, kodshab, koddened, docnumber, docnameshot, docnamefull, docnamefullm, docsumma, yearnachdoc, monthnachdoc, daynachdoc, yearenddoc, monthenddoc, dayenddoc, docnamefullm, kodzakaz, kodobject, kodispol, kodtip, kodstatus, datezakr FROM dognet_docbase WHERE kodtip IN ('245287841608965') AND yearnachdoc >= YEAR( NOW() )-3 AND ";

$_yearQueryStr = "";
for ($i = 0; $i < $_cntYearSelector; $i++) {
	if ($i == 0) {
		$_yearQueryStr .= "(";
	}
	$_yearQueryStr .= "YEAR(datezakr) = '";
	if ($i < ($_cntYearSelector - 1)) {
		$_yearQueryStr .= $_arrYearSelector[$i] . "' OR ";
	}
	if ($i == ($_cntYearSelector - 1)) {
		$_yearQueryStr .= $_arrYearSelector[$i] . "')";
	}
}
$qryPart .= $_yearQueryStr;
#
$_kodstatusQueryStr = "";
for ($i = 0; $i < $_cntStatusSelector; $i++) {
	if ($i == 0) {
		$_kodstatusQueryStr .= "(";
	}
	$_kodstatusQueryStr .= "kodstatus = '";
	if ($i < ($_cntStatusSelector - 1)) {
		$_kodstatusQueryStr .= $_arrStatusSelector[$i] . "' OR ";
	}
	if ($i == ($_cntStatusSelector - 1)) {
		$_kodstatusQueryStr .= $_arrStatusSelector[$i] . "')";
	}
}
$qryPart .= (($_yearQueryStr != "") && ($_kodstatusQueryStr != "")) ? " AND " . $_kodstatusQueryStr : $_kodstatusQueryStr;
#
$qryPart .= (($_yearQueryStr == "") && ($_kodstatusQueryStr == "")) ? " koddel<>'99' " : " AND koddel<>'99' ";
$qryPart .= "ORDER BY yearnachdoc ASC, monthnachdoc ASC, daynachdoc ASC, docnumber ASC";

// echo $qryPart;
// echo "<br>";

// Делаем выборку этапов по идентификатору этапа (kodkalplan)
$_QRY = mysqlQuery($qryPart);
//
// Номер строки
$num = 1;
while ($_ROW = mysqli_fetch_assoc($_QRY)) {
	$DOCTIP = $db_handle->runQuery("SELECT nametip FROM dognet_sptipdog WHERE kodtip='" . $_ROW['kodtip'] . "'");
	$DOCSTATUS = $db_handle->runQuery("SELECT statusnameshot, statusnamefull FROM dognet_spstatus WHERE kodstatus='" . $_ROW['kodstatus'] . "'");
	$DOCOBJ = $db_handle->runQuery("SELECT nameobjectshot, nameobjectlong FROM sp_objects WHERE kodobject='" . $_ROW['kodobject'] . "'");
	$DOCZAK = $db_handle->runQuery("SELECT * FROM sp_contragents WHERE kodcontragent='" . $_ROW['kodzakaz'] . "'");
	$DOCISP = $db_handle->runQuery("SELECT ispolnameshot FROM dognet_spispol WHERE kodispol='" . $_ROW['kodispol'] . "'");
	//
	$_DOCNUM = $_ROW['docnumber'];
	//
	switch ($_ROW['kodshab']) {
		case 0:
			$_DOCSHAB = "ДСЧ";
			break;

		case 1:
			$_DOCSHAB = "СКП";
			break;

		case 2:
			$_DOCSHAB = "БКП";
			break;

		default:
			$_DOCSHAB = "---";
	}
	$_DOCNAMEFULL = ($_ROW['docnamefull'] != "") ? $_ROW['docnamefull'] : (($_ROW['docnamefullm'] != "") ? $_ROW['docnamefullm'] : "");
	$_DOCNAME = ($_DOCNAMEFULL != "") ? $_DOCNAMEFULL : $_ROW['docnameshot'];
	//
	$_DOCDATE_NACH_DAY = ($_ROW['daynachdoc'] != "" && $_ROW['daynachdoc'] != 0) ? str_pad($_ROW['daynachdoc'], 2, '0', STR_PAD_LEFT) : "--";
	$_DOCDATE_NACH_MON = ($_ROW['monthnachdoc'] != "" && $_ROW['monthnachdoc'] != 0) ? str_pad($_ROW['monthnachdoc'], 2, '0', STR_PAD_LEFT) : "--";
	$_DOCDATE_NACH_YER = ($_ROW['yearnachdoc'] != "" && $_ROW['yearnachdoc'] != 0) ? $_ROW['yearnachdoc'] : "----";
	$_DOCDATE_NACH = $_DOCDATE_NACH_DAY . "." . $_DOCDATE_NACH_MON . "." . $_DOCDATE_NACH_YER;
	$_DOCDATE_NACH2 = $_DOCDATE_NACH_MON . "." . $_DOCDATE_NACH_YER;
	//
	$_DOCDATE_END_DAY = ($_ROW['dayenddoc'] != "" && $_ROW['dayenddoc'] != 0) ? str_pad($_ROW['dayenddoc'], 2, '0', STR_PAD_LEFT) : "--";
	$_DOCDATE_END_MON = ($_ROW['monthenddoc'] != "" && $_ROW['monthenddoc'] != 0) ? str_pad($_ROW['monthenddoc'], 2, '0', STR_PAD_LEFT) : "--";
	$_DOCDATE_END_YER = ($_ROW['yearenddoc'] != "" && $_ROW['yearenddoc'] != 0) ? $_ROW['yearenddoc'] : "----";
	$_DOCDATE_END = $_DOCDATE_END_DAY . "." . $_DOCDATE_END_MON . "." . $_DOCDATE_END_YER;
	$_DOCDATE_END2 = $_DOCDATE_END_MON . "." . $_DOCDATE_END_YER;
	//
	$_DOCTIP = $DOCTIP[0]['nametip'];
	$_DOCSTATUS = $DOCSTATUS[0]['statusnamefull'];
	$_DOCOBJ = ($DOCOBJ[0]['nameobjectlong'] != "") ? $DOCOBJ[0]['nameobjectlong'] : $DOCOBJ[0]['nameobjectshot'];

	$_DOCZAK = $DOCZAK[0]['nameshort'];
	$_DOCZAKFULL = ($DOCZAK[0]['namefull'] != "") ? $DOCZAK[0]['namefull'] : $DOCZAK[0]['nameshort'];
	$_DOCZAKADDR = ($DOCZAK[0]['address_legal'] != "") ? "\n" . $DOCZAK[0]['address_legal'] : "";
	$_DOCZAKINN = ($DOCZAK[0]['inn'] != "") ? "\nИНН " . $DOCZAK[0]['inn'] : "";
	$_DOCZAKKPP = ($DOCZAK[0]['kpp'] != "") ? "\nКПП " . $DOCZAK[0]['kpp'] : "";
	$_DOCZAKRUK = ($DOCZAK[0]['director_lastname'] != "") ? "\n" . $DOCZAK[0]['director_lastname'] . " " . $DOCZAK[0]['director_firstname'] . " " . $DOCZAK[0]['director_middlename'] : "\n" . $DOCZAK[0]['zakfio'];
	$_DOCZAKDOLJ = ($DOCZAK[0]['director_post'] != "") ? "\n" . $DOCZAK[0]['director_post'] : "";
	$_DOCZAKTEL = ($DOCZAK[0]['tel_official'] != "") ? "\n" . $DOCZAK[0]['tel_official'] : "";

	// Ed 2022-08-30
	// Определяем дату окончания договора (столбец 8) по дате последнего СФ независимо от статуса договора
	$_TMMQRY = mysqli_fetch_assoc(mysqlQuery("SELECT MAX(chetfdate) as lastchetfdate FROM dognet_kalplanchf WHERE kodkalplan IN ( SELECT MAX(kodkalplan) FROM dognet_dockalplan WHERE koddoc = '" . $_ROW['koddoc'] . "' )"));
	//
	if (!empty($_ROW['datezakr'])) {
		if ($_ROW['datezakr'] < $_TMMQRY['lastchetfdate']) {
			$_DOCDATE_ZAK = date("d.m.Y", strtotime($_TMMQRY['lastchetfdate'])) . "*";
			$_DOCDATE_ZAK1 = date("m.Y", strtotime($_TMMQRY['lastchetfdate'])) . "*";
			$_DOCYEAR_ZAK = date("Y", strtotime($_TMMQRY['lastchetfdate'])) . "*";
		} else {
			$_DOCDATE_ZAK = date("d.m.Y", strtotime($_ROW['datezakr']));
			$_DOCDATE_ZAK1 = date("m.Y", strtotime($_ROW['datezakr']));
			$_DOCYEAR_ZAK = date("Y", strtotime($_ROW['datezakr']));
		}
	} else {
		if (!empty($_TMMQRY['lastchetfdate'])) {
			$_DOCDATE_ZAK = date("d.m.Y", strtotime($_TMMQRY['lastchetfdate'])) . "*";
			$_DOCDATE_ZAK1 = date("m.Y", strtotime($_TMMQRY['lastchetfdate'])) . "*";
			$_DOCYEAR_ZAK = date("Y", strtotime($_TMMQRY['lastchetfdate'])) . "*";
		} else {
			$_DOCDATE_ZAK = "---";
			$_DOCDATE_ZAK1 = "---";
			$_DOCYEAR_ZAK = "---";
		}
	}

	// $_DOCDATE_ZAK = (!empty($_ROW['datezakr'])) ? date("d.m.Y", strtotime($_ROW['datezakr'])) : "---";
	// $_DOCYEAR_ZAK = (!empty($_ROW['datezakr'])) ? date("Y", strtotime($_ROW['datezakr'])) : "---";
	// $_DOCDATE_ZAK = "";
	$_DOCSUM = $_ROW['docsumma'];
	$_DOCISP = $DOCISP[0]['ispolnameshot'];

	// Считаем сумму всех субподрядных договоров по основному договору
	$DOCSUB_QRY = mysqlQuery("SELECT kodkalplan FROM dognet_dockalplan WHERE koddoc = '" . $_ROW['koddoc'] . "'");
	$DOCSUB_SUM = 0.0;
	if ($DOCSUB_QRY) {
		while ($DOCSUB_ROW = mysqli_fetch_assoc($DOCSUB_QRY)) {
			$DOCSUB = $db_handle->runQuery("SELECT SUM(sumdocsubpodr) as tmp_sum1 FROM dognet_docsubpodr WHERE koddoc = '" . $DOCSUB_ROW['kodkalplan'] . "'");
			$DOCSUB_SUM += $DOCSUB[0]['tmp_sum1'];
		}
	}
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	//
	// ЕСЛИ ДОГОВОР "РАМОЧНЫЙ"
	// Тип объекта "Рамочный" ( kodobject = 245530345307999 )
	//
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

	if ($_ROW['kodobject'] == "245530345307999") {

		$DOCSTAGES_QRY1 = mysqlQuery("SELECT kodkalplan, numberstage, summastage, dateplanbegin FROM dognet_dockalplan WHERE koddoc = '" . $_ROW['koddoc'] . "'");
		while ($DOCSTAGES_ROW = mysqli_fetch_assoc($DOCSTAGES_QRY1)) {
			$_NUMBERSTAGE = $DOCSTAGES_ROW['numberstage'];
			$_SUMMASTAGE = $DOCSTAGES_ROW['summastage'];
			$STAGESUB = $db_handle->runQuery("SELECT SUM(sumdocsubpodr) as tmp_sum1 FROM dognet_docsubpodr WHERE koddoc = '" . $DOCSTAGES_ROW['kodkalplan'] . "'");
			$STAGESUB_SUM = $STAGESUB[0]['tmp_sum1'];


			// Ed 2022-08-30
			// Определяем дату окончания договора (столбец 8) по дате последнего СФ независимо от статуса договора
			$_TMMQRY1 = mysqli_fetch_assoc(mysqlQuery("SELECT MAX(chetfdate) as lastchetfdate FROM dognet_kalplanchf WHERE kodkalplan = '" . $DOCSTAGES_ROW['kodkalplan'] . "'"));
			//
			if ($_TMMQRY1) {
				if (!empty($_TMMQRY1['lastchetfdate'])) {
					$_DOCDATE_ZAK = "* " . date("d.m.Y", strtotime($_TMMQRY1['lastchetfdate'])) . " (СФ)";
					$_DOCDATE_ZAK2 = "* " . date("m.Y", strtotime($_TMMQRY1['lastchetfdate'])) . " (СФ)";
					$_DOCYEAR_ZAK = "* " . date("Y", strtotime($_TMMQRY1['lastchetfdate'])) . " (СФ)";
				} else {
					$_DOCDATE_ZAK = "---";
					$_DOCDATE_ZAK2 = "---";
					$_DOCYEAR_ZAK = "---";
				}
			} else {
				$_DOCDATE_ZAK = "---";
				$_DOCDATE_ZAK2 = "---";
				$_DOCYEAR_ZAK = "---";
			}

			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			// Задаем высоту строки и шрифт
			$activeSheet->getRowDimension($line)->setRowHeight(-1);
			$activeSheet->getStyle("A{$line}:M{$line}")->getFont()->setSize(10);
			$activeSheet->getStyle("A{$line}:M{$line}")->getFont()->setBold(false);
			$activeSheet->getStyle("A{$line}:M{$line}")->getAlignment()->setWrapText(true); // разрешаем перенос строк в ячейке
			// Задаем цвет текста строки
			$activeSheet->getStyle("A{$line}:M{$line}")->getFont()->getColor()->setRGB('111111');
			// Выравнивание по вертикали - середина
			$activeSheet->getStyle("A{$line}:M{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			// Выравнивание по горизонтали
			$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$activeSheet->getStyle("B{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$activeSheet->getStyle("C{$line}:E{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$activeSheet->getStyle("F{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$activeSheet->getStyle("G{$line}:J{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$activeSheet->getStyle("K{$line}:M{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			// Делаем заливку области ячеек
			$activeSheet->getStyle("A{$line}:M{$line}")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
			$activeSheet->getStyle("A{$line}:M{$line}")->getFill()->getStartColor()->setRGB("E0F2F7");
			//
			// (A) ПОРЯДКОВЫЙ НОМЕР
			$activeSheet->setCellValue("A{$line}", $num);
			//
			// (B) ПРЕДМЕТ ДОГОВОРА ПОСТАВКИ
			$activeSheet->setCellValue("B{$line}", $_DOCNAME);
			//
			// (C) НАИМЕНОВАНИЕ ТОВАРА
			$activeSheet->setCellValue("C{$line}", "---");
			//
			// (D) КОД ОКПД2 ТОВАРА
			$activeSheet->setCellValue("D{$line}", "---");
			//
			// (E) ФЕДЕРАЛЬНЫЙ ОКРУГ ПОСТАВКИ
			$activeSheet->setCellValue("E{$line}", "---");
			//
			// (F) КОД ОКПД2 ТОВАРА
			$activeSheet->setCellValue("F{$line}", $_DOCZAKFULL);
			//
			// (G) ИНН ЗАКАЗЧИКА
			$activeSheet->setCellValue("G{$line}", $_DOCZAKINN);
			//
			// (H) СУММА ЭТАПА
			$activeSheet->setCellValue("H{$line}", $_SUMMASTAGE);
			$activeSheet->getStyle("H{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
			// 
			// (I) : ДАТА НАЧАЛА ЭТАПА(СПЕЦИФИКАЦИИ) / ДОГОВОРА
			mb_internal_encoding("UTF-8");
			$_tmpStageDateNach = $DOCSTAGES_ROW['dateplanbegin'] != "" ?  mb_substr(date("d.m.Y", strtotime($DOCSTAGES_ROW['dateplanbegin'])), "3") . " (ПЛ)" : mb_substr($_DOCDATE_NACH, "3");
			$activeSheet->setCellValue("I{$line}", "* " . $_tmpStageDateNach);
			// 
			// (J) : ДАТА ЗАВЕРШЕНИЯ ЭТАПА(СПЕЦИФИКАЦИИ) / ДОГОВОРА
			$activeSheet->setCellValue("J{$line}", $_DOCDATE_ZAK2);
			// 
			// (K) : НОМЕР ДОГОВОРА / СПЕЦИФИКАЦИЯ
			$activeSheet->setCellValue("K{$line}", "3-4/" . $_DOCNUM . ", спец. № " . $_NUMBERSTAGE);
			// 
			// (L) : ОТЗЫВ
			$activeSheet->setCellValue("L{$line}", "---");
			// 
			// (M) : СТАТУС
			$activeSheet->setCellValue("M{$line}", ucfirst(strtolower($_DOCSTATUS)));
			// 
			// Оформляем границы
			$activeSheet->getStyle("A{$line}:M{$line}")->applyFromArray($_BORDER_INSIDE);
			$activeSheet->getStyle("A{$line}:M{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			// Следующая строка
			$line++;

			$num++;
		}
	} else {

		$DOCSTAGES_QRY2 = mysqlQuery("SELECT kodkalplan, numberstage, summastage, dateplanbegin FROM dognet_dockalplan WHERE koddoc = '" . $_ROW['koddoc'] . "'");
		while ($DOCSTAGES_ROW = mysqli_fetch_assoc($DOCSTAGES_QRY2)) {
			$_NUMBERSTAGE = $DOCSTAGES_ROW['numberstage'];
			$_SUMMASTAGE = $DOCSTAGES_ROW['summastage'];
			$STAGESUB = $db_handle->runQuery("SELECT SUM(sumdocsubpodr) as tmp_sum1 FROM dognet_docsubpodr WHERE koddoc = '" . $DOCSTAGES_ROW['kodkalplan'] . "'");
			$STAGESUB_SUM = $STAGESUB[0]['tmp_sum1'];


			// Ed 2022-08-30
			// Определяем дату окончания договора (столбец 8) по дате последнего СФ независимо от статуса договора
			$_TMMQRY2 = mysqli_fetch_assoc(mysqlQuery("SELECT MAX(chetfdate) as lastchetfdate FROM dognet_kalplanchf WHERE kodkalplan = '" . $DOCSTAGES_ROW['kodkalplan'] . "'"));
			//
			if (!empty($_ROW['datezakr'])) {
				if ($_ROW['datezakr'] < $_TMMQRY2['lastchetfdate']) {
					$_DOCDATE_ZAK = "* " . date("d.m.Y", strtotime($_TMMQRY2['lastchetfdate'])) . " (СФ)";
					$_DOCDATE_ZAK1 = "* " . date("m.Y", strtotime($_TMMQRY2['lastchetfdate'])) . " (СФ)";
					$_DOCYEAR_ZAK = "* " . date("Y", strtotime($_TMMQRY2['lastchetfdate'])) . " (СФ)";
				} else {
					$_DOCDATE_ZAK = "* " . date("d.m.Y", strtotime($_ROW['datezakr'])) . " (ДГ)";
					$_DOCDATE_ZAK1 = "* " . date("m.Y", strtotime($_ROW['datezakr'])) . " (ДГ)";
					$_DOCYEAR_ZAK = "* " . date("Y", strtotime($_ROW['datezakr'])) . " (ДГ)";
				}
			} else {
				if (!empty($_TMMQRY2['lastchetfdate'])) {
					$_DOCDATE_ZAK = "* " . date("d.m.Y", strtotime($_TMMQRY2['lastchetfdate'])) . " (СФ)";
					$_DOCDATE_ZAK1 = "* " . date("m.Y", strtotime($_TMMQRY2['lastchetfdate'])) . " (СФ)";
					$_DOCYEAR_ZAK = "* " . date("Y", strtotime($_TMMQRY2['lastchetfdate'])) . " (СФ)";
				} else {
					$_DOCDATE_ZAK = "---";
					$_DOCDATE_ZAK1 = "---";
					$_DOCYEAR_ZAK = "---";
				}
			}

			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			// Задаем высоту строки и шрифт
			$activeSheet->getRowDimension($line)->setRowHeight(-1);
			$activeSheet->getStyle("A{$line}:M{$line}")->getFont()->setSize(10);
			$activeSheet->getStyle("A{$line}:M{$line}")->getFont()->setBold(false);
			$activeSheet->getStyle("A{$line}:M{$line}")->getAlignment()->setWrapText(true); // разрешаем перенос строк в ячейке
			// Задаем цвет текста строки
			$activeSheet->getStyle("A{$line}:M{$line}")->getFont()->getColor()->setRGB('111111');
			// Выравнивание по вертикали - середина
			$activeSheet->getStyle("A{$line}:M{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			// Выравнивание по горизонтали
			$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$activeSheet->getStyle("B{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$activeSheet->getStyle("C{$line}:E{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$activeSheet->getStyle("F{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$activeSheet->getStyle("G{$line}:J{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$activeSheet->getStyle("K{$line}:M{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			//
			// (A) ПОРЯДКОВЫЙ НОМЕР
			$activeSheet->setCellValue("A{$line}", $num);
			//
			// (B) ПРЕДМЕТ ДОГОВОРА ПОСТАВКИ
			$activeSheet->setCellValue("B{$line}", $_DOCNAME);
			//
			// (C) НАИМЕНОВАНИЕ ТОВАРА
			$activeSheet->setCellValue("C{$line}", "---");
			//
			// (D) КОД ОКПД2 ТОВАРА
			$activeSheet->setCellValue("D{$line}", "---");
			//
			// (E) ФЕДЕРАЛЬНЫЙ ОКРУГ ПОСТАВКИ
			$activeSheet->setCellValue("E{$line}", "---");
			//
			// (F) КОД ОКПД2 ТОВАРА
			$activeSheet->setCellValue("F{$line}", $_DOCZAKFULL);
			//
			// (G) ИНН ЗАКАЗЧИКА
			$activeSheet->setCellValue("G{$line}", $_DOCZAKINN);
			//
			// (H) СУММА ЭТАПА
			$activeSheet->setCellValue("H{$line}", $_SUMMASTAGE);
			$activeSheet->getStyle("H{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
			// 
			// (I) : ДАТА НАЧАЛА ЭТАПА(СПЕЦИФИКАЦИИ) / ДОГОВОРА
			mb_internal_encoding("UTF-8");
			$_tmpStageDateNach = $DOCSTAGES_ROW['dateplanbegin'] != "" ?  mb_substr(date("d.m.Y", strtotime($DOCSTAGES_ROW['dateplanbegin'])), "3") . " (ПЛ)" : mb_substr($_DOCDATE_NACH, "3");
			$activeSheet->setCellValue("I{$line}", "* " . $_tmpStageDateNach);
			// 
			// (J) : ДАТА ЗАВЕРШЕНИЯ ЭТАПА(СПЕЦИФИКАЦИИ) / ДОГОВОРА
			$activeSheet->setCellValue("J{$line}", $_DOCDATE_ZAK1);
			// 
			// (K) : НОМЕР ДОГОВОРА / СПЕЦИФИКАЦИЯ
			$activeSheet->setCellValue("K{$line}", "3-4/" . $_DOCNUM . ", спец. № " . $_NUMBERSTAGE);
			// 
			// (L) : ОТЗЫВ
			$activeSheet->setCellValue("L{$line}", "---");
			// 
			// (M) : СТАТУС
			$activeSheet->setCellValue("M{$line}", ucfirst(strtolower($_DOCSTATUS)));
			// 
			// Оформляем границы
			$activeSheet->getStyle("A{$line}:M{$line}")->applyFromArray($_BORDER_INSIDE);
			$activeSheet->getStyle("A{$line}:M{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			// Следующая строка
			$line++;

			$num++;
		}
	}
}
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Возвращаемся на 1 строку
$line = $line - 1;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
// Добавляем рамку к шапке таблицы
$activeSheet->getStyle("A{$start_table}:K{$start_table}")->applyFromArray($_BORDER_OUTSIDE_THIN);
// Добавляем рамку ко всей таблице
$activeSheet->getStyle("A{$start_table}:M{$line}")->applyFromArray($_BORDER_OUTSIDE_THIN);

// $objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());
$objPHPExcel->getActiveSheet()->setAutoFilter("A{$start_table}:M{$start_table}");

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----