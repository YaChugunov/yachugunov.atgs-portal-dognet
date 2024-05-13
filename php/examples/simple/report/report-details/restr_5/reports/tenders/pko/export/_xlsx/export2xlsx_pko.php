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
$activeSheet->getHeaderFooter()->setOddHeader('&L&G&B&12СВЕДЕНИЯ ОБ ОПЫТЕ ВЫПОЛНЕНИЯ РАБОТ ПО ПРЕДМЕТУ ПКО ЗА ПОСЛЕДНИЕ ТРИ ГОДА + ТЕКУЩИЙ&R&G&B&12');
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
$activeSheet->getColumnDimension('B')->setWidth(55); // Заказчик
$activeSheet->getColumnDimension('C')->setWidth(35); // Договор
$activeSheet->getColumnDimension('D')->setWidth(45); // Объект
$activeSheet->getColumnDimension('E')->setWidth(25); // Сумма общая
$activeSheet->getColumnDimension('F')->setWidth(25); // Сумма без учета субподряда (если есть)
$activeSheet->getColumnDimension('G')->setWidth(20); // Период (начало договора)
$activeSheet->getColumnDimension('H')->setWidth(20); // Период (дата последнего СФ при закрытии)
$activeSheet->getColumnDimension('I')->setWidth(20); // Год договора (опционально)
$activeSheet->getColumnDimension('J')->setWidth(30); // Год договора (опционально)
$activeSheet->getColumnDimension('K')->setWidth(50); // Комментарий (опционально)
#
// Для удобства заводим переменную $line, в ней будем считать номер строки
$line = 1;
#
# ----- ----- ----- ----- -----
# СТРОКА 1
# ----- ----- ----- ----- -----
// Выводим название отчета
$activeSheet->setCellValue("A{$line}", 'СВЕДЕНИЯ ОБ ОПЫТЕ ВЫПОЛНЕНИЯ РАБОТ ПО ПРЕДМЕТУ ПКО ЗА ПОСЛЕДНИЕ ТРИ ГОДА + ТЕКУЩИЙ');
// Задаем высоту строки
$activeSheet->getRowDimension($line)->setRowHeight(24);
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:K{$line}");
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
$activeSheet->mergeCells("A{$line}:K{$line}");
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
$activeSheet->mergeCells("A{$line}:K{$line}");
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
$activeSheet->mergeCells("C{$line}:K{$line}");
// Делаем выравнивание по центру вертикали и горизонтали
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("C{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("A{$line}:K{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Делаем текст жирным и увеличиваем шрифт.
$activeSheet->getStyle("A{$line}")->getFont()->setBold(false);
$activeSheet->getStyle("C{$line}")->getFont()->setBold(true);
$activeSheet->getStyle("A{$line}:K{$line}")->getFont()->setSize(12);
#
#
$line++;
$activeSheet->setCellValue("A{$line}", "Фильтр экспорта по статусу договора:");
$activeSheet->setCellValue("C{$line}", $_statusTitleStr);
// Задаем высоту строки
$activeSheet->getRowDimension($line)->setRowHeight(20);
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:B{$line}");
$activeSheet->mergeCells("C{$line}:K{$line}");
// Делаем выравнивание по центру вертикали и горизонтали
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("C{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("A{$line}:K{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Делаем текст жирным и увеличиваем шрифт.
$activeSheet->getStyle("A{$line}")->getFont()->setBold(false);
$activeSheet->getStyle("C{$line}")->getFont()->setBold(true);
$activeSheet->getStyle("A{$line}:K{$line}")->getFont()->setSize(12);
#
# ----- ----- ----- ----- -----
# СТРОКА ШАПКИ ТАБЛИЦЫ (строка 1)
# ----- ----- ----- ----- -----
// Пропускаем строку
$line++;
$activeSheet->setCellValue("A{$line}", '');
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
$line++;
$start_table = $line;
// Шапка таблицы
$activeSheet->setCellValue("E{$line}", 'ОБЪЕМ ВЫПОЛНЕННЫХ / ВЫПОЛНЯЕМЫХ' . "\n" . 'РАБОТ, РУБ');
// Стили для текста в шапки таблицы.
$activeSheet->getRowDimension($line)->setRowHeight(48); // высота строки
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:D{$line}");
$activeSheet->mergeCells("E{$line}:F{$line}");
$activeSheet->mergeCells("G{$line}:K{$line}");

$activeSheet->getStyle("A{$line}:K{$line}")->getFont()->setSize(12); // размер шрифта
$activeSheet->getStyle("A{$line}:K{$line}")->getFont()->setBold(true); // делаем шрифт жирным
$activeSheet->getStyle("A{$line}:K{$line}")->getAlignment()->setWrapText(true); // разрешаем перенос строк в ячейке

// Выравнивание по вертикали - середина
$activeSheet->getStyle("A{$line}:K{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Выравнивание по горизонтали - слева
$activeSheet->getStyle("A{$line}:D{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("K{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
// Выравнивание по горизонтали - центр
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$activeSheet->getStyle("E{$line}:H{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// Делаем заливку области ячеек
$activeSheet->getStyle("A{$line}:K{$line}")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$activeSheet->getStyle("A{$line}:K{$line}")->getFill()->getStartColor()->setRGB("31708F");
// Задаем цвет текста строки
$activeSheet->getStyle("A{$line}:K{$line}")->getFont()->getColor()->setRGB('FFFFFF');
// Оформляем границы
$activeSheet->getStyle("A{$line}:K{$line}")->applyFromArray($_BORDER_INSIDE);
$activeSheet->getStyle("A{$line}:K{$line}")->applyFromArray($_BORDER_OUTSIDE_THIN);
#
# ----- ----- ----- ----- -----
# СТРОКА ШАПКИ ТАБЛИЦЫ (строка 2)
# ----- ----- ----- ----- -----
$line++;
// Шапка таблицы
$activeSheet->setCellValue("A{$line}", '№' . "\n" . 'п/п');
$activeSheet->setCellValue("B{$line}", 'ЗАКАЗЧИК' . "\n" . '(ПОЛНОЕ НАИМЕНОВАНИЕ, ИНН, ОГРН, КОНТАТЫ)');
$activeSheet->setCellValue("C{$line}", 'НОМЕР, ДАТА' . "\n" . 'И ПРЕДМЕТ ДОГОВОРА');
$activeSheet->setCellValue("D{$line}", 'НАИМЕНОВАНИЕ' . "\n" . 'И ХАРАКТЕРИСТИКА ОБЪЕКТА');
$activeSheet->setCellValue("E{$line}", 'ОБЩИЙ' . "\n" . '(В СЛУЧАЕ ГЕНПОДРЯДА)');
$activeSheet->setCellValue("F{$line}", 'В Т.Ч. ВЫПОЛНЕН' . "\n" . 'СОБСТ. СИЛАМИ');
$activeSheet->setCellValue("G{$line}", 'ПЕРИОД РАБОТ' . "\n" . '(НАЧАЛО)');
$activeSheet->setCellValue("H{$line}", 'ПЕРИОД РАБОТ' . "\n" . '(КОНЕЦ)');
$activeSheet->setCellValue("I{$line}", 'ГОД ДОГОВОРА' . "\n" . '(ОПЦИОНАЛЬНО)');
$activeSheet->setCellValue("J{$line}", 'ТИП ДОГОВОРА' . "\n" . '(ОПЦИОНАЛЬНО)');
$activeSheet->setCellValue("K{$line}", 'КОММЕНТАРИЙ' . "\n" . '(ОПЦИОНАЛЬНО)');
// Стили для текста в шапки таблицы.
$activeSheet->getRowDimension($line)->setRowHeight(48); // высота строки
$activeSheet->getStyle("A{$line}:K{$line}")->getFont()->setSize(12); // размер шрифта
$activeSheet->getStyle("A{$line}:K{$line}")->getFont()->setBold(true); // делаем шрифт жирным
$activeSheet->getStyle("A{$line}:K{$line}")->getAlignment()->setWrapText(true); // разрешаем перенос строк в ячейке

// Выравнивание по вертикали - середина
$activeSheet->getStyle("A{$line}:K{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Выравнивание по горизонтали - слева
$activeSheet->getStyle("A{$line}:D{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("K{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
// Выравнивание по горизонтали - центр
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$activeSheet->getStyle("E{$line}:I{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// Делаем заливку области ячеек
$activeSheet->getStyle("A{$line}:K{$line}")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$activeSheet->getStyle("A{$line}:K{$line}")->getFill()->getStartColor()->setRGB("31708F");
// Задаем цвет текста строки
$activeSheet->getStyle("A{$line}:K{$line}")->getFont()->getColor()->setRGB('FFFFFF');
// Оформляем границы
$activeSheet->getStyle("A{$line}:K{$line}")->applyFromArray($_BORDER_INSIDE);
$activeSheet->getStyle("A{$line}:K{$line}")->applyFromArray($_BORDER_OUTSIDE_THIN);
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
// Стили для текста в шапки таблицы.
$activeSheet->getRowDimension($line)->setRowHeight(18); // высота строки
$activeSheet->getStyle("A{$line}:K{$line}")->getFont()->setSize(9); // размер шрифта
$activeSheet->getStyle("A{$line}:K{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); // вырванивание по вертикали - середина
// Выравнивание по горизонтали - центр
$activeSheet->getStyle("A{$line}:K{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// Делаем заливку области ячеек
$activeSheet->getStyle("A{$line}:K{$line}")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$activeSheet->getStyle("A{$line}:K{$line}")->getFill()->getStartColor()->setRGB("F1F1F1");
// Задаем цвет текста строки
$activeSheet->getStyle("A{$line}:K{$line}")->getFont()->getColor()->setRGB('999999');
// Оформляем границы
$activeSheet->getStyle("A{$line}:K{$line}")->applyFromArray($_BORDER_INSIDE);
$activeSheet->getStyle("A{$line}:K{$line}")->applyFromArray($_BORDER_OUTSIDE_THIN);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
$qryPart = "SELECT koddoc, kodshab, koddened, docnumber, docnameshot, docnamefull, docsumma, yearnachdoc, monthnachdoc, daynachdoc, yearenddoc, monthenddoc, dayenddoc, docnamefullm, kodzakaz, kodobject, kodispol, kodtip, kodstatus, datezakr FROM dognet_docbase WHERE yearnachdoc >= YEAR( NOW() )-3 AND ";

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
	$DOCZAK = $db_handle->runQuery("SELECT * FROM sp_contragents WHERE kodzakaz='" . $_ROW['kodzakaz'] . "'");
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
	$_DOCNAMEFULL = ($_ROW['docnamefull'] != "") ? $_ROW['docnamefull'] : "";
	$_DOCNAME = ($_DOCNAMEFULL != "") ? $_DOCNAMEFULL : $_ROW['docnameshot'];
	//
	$_DOCDATE_NACH_DAY = ($_ROW['daynachdoc'] != "" && $_ROW['daynachdoc'] != 0) ? str_pad($_ROW['daynachdoc'], 2, '0', STR_PAD_LEFT) : "--";
	$_DOCDATE_NACH_MON = ($_ROW['monthnachdoc'] != "" && $_ROW['monthnachdoc'] != 0) ? str_pad($_ROW['monthnachdoc'], 2, '0', STR_PAD_LEFT) : "--";
	$_DOCDATE_NACH_YER = ($_ROW['yearnachdoc'] != "" && $_ROW['yearnachdoc'] != 0) ? str_pad($_ROW['yearnachdoc'], 2, '0', STR_PAD_LEFT) : "----";
	$_DOCDATE_NACH = $_DOCDATE_NACH_DAY . "." . $_DOCDATE_NACH_MON . "." . $_DOCDATE_NACH_YER;
	//
	$_DOCDATE_END_DAY = ($_ROW['dayenddoc'] != "" && $_ROW['dayenddoc'] != 0) ? str_pad($_ROW['dayenddoc'], 2, '0', STR_PAD_LEFT) : "--";
	$_DOCDATE_END_MON = ($_ROW['monthenddoc'] != "" && $_ROW['monthenddoc'] != 0) ? str_pad($_ROW['monthenddoc'], 2, '0', STR_PAD_LEFT) : "--";
	$_DOCDATE_END_YER = ($_ROW['yearenddoc'] != "" && $_ROW['yearenddoc'] != 0) ? str_pad($_ROW['yearenddoc'], 2, '0', STR_PAD_LEFT) : "----";
	$_DOCDATE_END = $_DOCDATE_END_DAY . "." . $_DOCDATE_END_MON . "." . $_DOCDATE_END_YER;
	//
	$_DOCTIP = $DOCTIP[0]['nametip'];
	$_DOCSTATUS = $DOCSTATUS[0]['statusnamefull'];
	$_DOCOBJ = ($DOCOBJ[0]['nameobjectlong'] != "") ? $DOCOBJ[0]['nameobjectlong'] : $DOCOBJ[0]['nameobjectshot'];

	$_DOCZAK = $DOCZAK[0]['namezakshot'];
	$_DOCZAKFULL = ($DOCZAK[0]['namezaklong'] != "") ? $DOCZAK[0]['namezaklong'] : $DOCZAK[0]['namezakshot'];
	$_DOCZAKADDR = ($DOCZAK[0]['zakuraddress'] != "") ? "\n" . $DOCZAK[0]['zakuraddress'] : "";
	$_DOCZAKINN = ($DOCZAK[0]['zakinn'] != "") ? "\nИНН " . $DOCZAK[0]['zakinn'] : "";
	$_DOCZAKKPP = ($DOCZAK[0]['zakkpp'] != "") ? "\nКПП " . $DOCZAK[0]['zakkpp'] : "";
	$_DOCZAKRUK = ($DOCZAK[0]['director_lastname'] != "") ? "\n" . $DOCZAK[0]['director_lastname'] . " " . $DOCZAK[0]['director_firstname'] . " " . $DOCZAK[0]['director_middlename'] : "\n" . $DOCZAK[0]['zakfio'];
	$_DOCZAKDOLJ = ($DOCZAK[0]['director_post'] != "") ? "\n" . $DOCZAK[0]['director_post'] : "";
	$_DOCZAKTEL = ($DOCZAK[0]['zaktelnumber'] != "") ? "\n" . $DOCZAK[0]['zaktelnumber'] : "";

	$_DOCDATE_ZAK = (!empty($_ROW['datezakr'])) ? date("d.m.Y", strtotime($_ROW['datezakr'])) : "---";
	$_DOCYEAR_ZAK = (!empty($_ROW['datezakr'])) ? date("Y", strtotime($_ROW['datezakr'])) : "---";
	// 			$_DOCDATE_ZAK = "";
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
	// Задаем высоту строки и шрифт
	$activeSheet->getRowDimension($line)->setRowHeight(-1);
	$activeSheet->getStyle("A{$line}:K{$line}")->getFont()->setSize(11);
	$activeSheet->getStyle("A{$line}:K{$line}")->getFont()->setBold(false);
	$activeSheet->getStyle("A{$line}:K{$line}")->getAlignment()->setWrapText(true); // разрешаем перенос строк в ячейке
	// Задаем цвет текста строки
	$activeSheet->getStyle("A{$line}:K{$line}")->getFont()->getColor()->setRGB('111111');
	// Выравнивание по вертикали - середина
	$activeSheet->getStyle("A{$line}:K{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	// Выравнивание по горизонтали - слева
	$activeSheet->getStyle("B{$line}:D{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$activeSheet->getStyle("K{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	// Выравнивание по горизонтали - центр
	$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$activeSheet->getStyle("E{$line}:I{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$activeSheet->setCellValue("A{$line}", $num);
	// 
	$objRichText1 = new PHPExcel_RichText();
	$objBold = $objRichText1->createTextRun($_DOCZAKFULL . "\n");
	$objBold->getFont()->setBold(true);
	$objBold->getFont()->setSize(11);
	$objRichText1->createText($_DOCZAKADDR . $_DOCZAKINN . $_DOCZAKKPP . $_DOCZAKRUK . $_DOCZAKDOLJ . $_DOCZAKTEL);
	$activeSheet->setCellValueExplicit("B{$line}", $objRichText1, PHPExcel_Cell_DataType::TYPE_STRING);
	// 

	$activeSheet->setCellValue("C{$line}", "3-4/" . $_DOCNUM . " от " . $_DOCDATE_NACH . "\n" . $_DOCNAME);

	// 
	$objRichText2 = new PHPExcel_RichText();
	$objBold = $objRichText2->createTextRun($_DOCOBJ . "\n");
	$objBold->getFont()->setBold(true);
	$objBold->getFont()->setSize(11);
	$objRichText2->createText($_DOCNAME);
	$activeSheet->setCellValueExplicit("D{$line}", $objRichText2, PHPExcel_Cell_DataType::TYPE_STRING);
	// 

	$activeSheet->setCellValue("E{$line}", $_DOCSUM);
	$activeSheet->getStyle("E{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
	$activeSheet->setCellValue("F{$line}", ($_DOCSUM - $DOCSUB_SUM));
	$activeSheet->getStyle("F{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
	$activeSheet->setCellValue("G{$line}", $_DOCDATE_NACH);
	$activeSheet->setCellValue("H{$line}", $_DOCDATE_ZAK);
	$activeSheet->setCellValue("I{$line}", $_DOCDATE_NACH_YER);
	$activeSheet->setCellValue("J{$line}", $_DOCTIP);

	// 
	$objRichText3 = new PHPExcel_RichText();
	$objRichText3->createTextRun("СТАТУС ДОГОВОРА - ");
	$objBold = $objRichText3->createTextRun($_DOCSTATUS);
	$objBold->getFont()->setBold(true);
	$objBold->getFont()->setSize(11);
	$activeSheet->setCellValueExplicit("K{$line}", $objRichText3, PHPExcel_Cell_DataType::TYPE_STRING);
	// 

	// Оформляем границы
	$activeSheet->getStyle("A{$line}:K{$line}")->applyFromArray($_BORDER_INSIDE);
	$activeSheet->getStyle("A{$line}:K{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	// Следующая строка
	$line++;

	$num++;
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
$activeSheet->getStyle("A{$start_table}:K{$line}")->applyFromArray($_BORDER_OUTSIDE_THIN);

// $objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());
$objPHPExcel->getActiveSheet()->setAutoFilter("A{$start_table}:K{$start_table}");

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
