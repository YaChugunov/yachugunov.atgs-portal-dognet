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
$activeSheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 5);
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
$activeSheet->setTitle('Общая сводка');
#
// Колонтитулы
$activeSheet->getHeaderFooter()->setOddHeader('&L&G&B&12СПРАВКА О ЗАДОЛЖЕННОСТИ&R&G&B&12По счетам-фактурам');
$activeSheet->getHeaderFooter()->setOddFooter('&11&L&B' . $_SESSION["current_user_firstname"] . ' ' . $_SESSION["current_user_lastname"] . ' / ' . date('d.m.Y H:i:s') . '&R&11Страница &P из &N');
#
// Настройки шрифта
$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');
$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
// Задаем свой формат
define("PRICE_FORMAT_CMN", PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1 . "[\$ р.-419]");
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
# ФОРМАТИРУЕМ ВЫХОДНУЮ ТАБЛИЦУ EXCEL
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
// Задаем ширины столбцов
$activeSheet->getColumnDimension('A')->setWidth(70);
$activeSheet->getColumnDimension('B')->setWidth(20);
$activeSheet->getColumnDimension('C')->setWidth(5);
$activeSheet->getColumnDimension('D')->setWidth(70);
$activeSheet->getColumnDimension('E')->setWidth(20);
#
// Для удобства заводим переменную $line, в ней будем считать номер строки
$line = 1;
#
# ----- ----- ----- ----- -----
# СТРОКА 1
# ----- ----- ----- ----- -----
// Выводим название отчета
$activeSheet->setCellValue("A{$line}", 'Справка о задолженности по субподрядчикам на ' . date('d.m.Y', strtotime($_ONDATE)));
// Задаем высоту строки
$activeSheet->getRowDimension($line)->setRowHeight(32);
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:E{$line}");
// Делаем выравнивание по центру вертикали и горизонтали
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("A{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Делаем текст жирным и увеличиваем шрифт.
$activeSheet->getStyle("A{$line}")->getFont()->setBold(true);
$activeSheet->getStyle("A{$line}")->getFont()->setSize(20);
# ----- ----- ----- ----- -----
# СТРОКА 2
# ----- ----- ----- ----- -----
// Пропускаем строку
$line++;
$activeSheet->setCellValue("A{$line}", '');
// Запоминаем строку с которой начинается таблица чтобы потом сделать рамку.
$line++;
$start_table = $line;
// Шапка таблицы
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:B{$line}");
$activeSheet->setCellValue("A{$line}", 'ДОГОВОРА');
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("D{$line}:E{$line}");
$activeSheet->setCellValue("D{$line}", 'СЧЕТА И ОПЛАТА');
// Стили для текста в шапки таблицы.
$activeSheet->getRowDimension($line)->setRowHeight(32); // высота строки
$activeSheet->getStyle("A{$line}:E{$line}")->getFont()->setSize(12); // размер шрифта
$activeSheet->getStyle("A{$line}:E{$line}")->getFont()->setBold(true); // делаем шрифт жирным
// разрешаем перенос строк в ячейке
$activeSheet->getStyle("A{$line}:E{$line}")->getAlignment()->setWrapText(true);
// выравнивание по горизонтали - слева
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// выравнивание по горизонтали - центр
$activeSheet->getStyle("D{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$activeSheet->getStyle("A{$line}:E{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); // вырванивание по вертикали - середина
// Делаем заливку области ячеек
$activeSheet->getStyle("A{$line}:B{$line}")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$activeSheet->getStyle("A{$line}:B{$line}")->getFill()->getStartColor()->setRGB("F1F1F1");
$activeSheet->getStyle("D{$line}:E{$line}")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$activeSheet->getStyle("D{$line}:E{$line}")->getFill()->getStartColor()->setRGB("F1F1F1");
// Оформляем границы
// 		$activeSheet->getStyle("A{$line}:E{$line}")->applyFromArray($_BORDER_INSIDE);
// 		$activeSheet->getStyle("A{$line}:E{$line}")->applyFromArray($_BORDER_OUTSIDE_THICK);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
// Общее количество субподрядных организаций
$_QRY_SUBDOC_A = mysqlQuery("SELECT DISTINCT kodsubpodr FROM dognet_docsubpodr WHERE koddel<>'99'");
$_ROW_SUBDOC_A = mysqli_fetch_assoc($_QRY_SUBDOC_A);
$_qty_subdocA = mysqli_num_rows($_QRY_SUBDOC_A);
if (!$_QRY_SUBDOC_A) {
	echo 'Ошибка запроса: ' . mysqli_error($_ROW_SUBDOC_A) . ' Код ошибки: ' . mysqli_errno($_ROW_SUBDOC_A);
	exit;
}

// Общее количество субподрядных организаций, перед которыми есть задолженность
$_QRY_SUBDOC_B = mysqlQuery("SELECT DISTINCT kodsubpodr FROM dognet_docsubpodr WHERE koddel<>'99' AND sumzadolsubpodr>'0.00' AND koddocsubpodr IN (SELECT koddocsubpodr FROM dognet_docchfsubpodr WHERE koddel<>'99' AND sumzadolchfsubpodr>'0.00' AND datechfsubpodr<='{$_ONDATE}')");
$_ROW_SUBDOC_B = mysqli_fetch_assoc($_QRY_SUBDOC_B);
$_qty_subdocB = mysqli_num_rows($_QRY_SUBDOC_B);

// Общее количество договоров
$_QRY_SUBDOC1 = mysqlQuery("SELECT * FROM dognet_docsubpodr WHERE koddel<>'99'");
$_ROW_SUBDOC1 = mysqli_fetch_assoc($_QRY_SUBDOC1);
$_qty_subdoc1 = mysqli_num_rows($_QRY_SUBDOC1);

// Из них с задолженностью
$_QRY_SUBDOC2 = mysqlQuery("SELECT * FROM dognet_docsubpodr WHERE koddel<>'99' AND sumzadolsubpodr>'0.00' AND koddocsubpodr IN (SELECT koddocsubpodr FROM dognet_docchfsubpodr WHERE koddel<>'99' AND sumzadolchfsubpodr>'0.00' AND datechfsubpodr<='{$_ONDATE}')");
$_ROW_SUBDOC2 = mysqli_fetch_assoc($_QRY_SUBDOC2);
$_qty_subdoc2 = mysqli_num_rows($_QRY_SUBDOC2);

// Из них не закрытых
$_QRY_SUBDOC3 = mysqlQuery("SELECT koddocsubpodr, sumdocsubpodr FROM dognet_docsubpodr WHERE koddel<>'99'");
$_qty_subdoc3 = mysqli_num_rows($_QRY_SUBDOC3);
$_cnt = 0;
while ($_ROW_SUBDOC3 = mysqli_fetch_assoc($_QRY_SUBDOC3)) {
	$_koddocsubpodr = $_ROW_SUBDOC3['koddocsubpodr'];
	$_sumdocsubpodr = $_ROW_SUBDOC3['sumdocsubpodr'];
	$_QRY_SUBDOC3_1 = mysqlQuery("SELECT SUM(sumchfsubpodr) as SUM_CHF FROM dognet_docchfsubpodr WHERE koddocsubpodr='{$_koddocsubpodr}' AND koddel<>'99' AND sumzadolchfsubpodr>'0.00' AND datechfsubpodr<='{$_ONDATE}'");
	$_ROW_SUBDOC3_1 = mysqli_fetch_assoc($_QRY_SUBDOC3_1);
	$_sumchf = $_ROW_SUBDOC3_1['SUM_CHF'];
	if (($_sumdocsubpodr != '') && ($_sumdocsubpodr != 0.00) && $_sumdocsubpodr > $_sumchf) {
		$_cnt++;
	}
}
$_qty_nezakr = $_cnt;

// Сумма выставленных счетов по всем договорам
$_QRY_SUBDOC4 = mysqlQuery("SELECT SUM(sumchfsubpodr) as TOTAL_CHF FROM dognet_docchfsubpodr WHERE koddel<>'99' AND datechfsubpodr<='{$_ONDATE}'");
$_ROW_SUBDOC4 = mysqli_fetch_assoc($_QRY_SUBDOC4);
$_total_sumchf = $_ROW_SUBDOC4['TOTAL_CHF'];

// Сумма оплаченных счетов по всем договорам
$_QRY_SUBDOC5 = mysqlQuery("SELECT SUM(sumoplchfsubpodr) as TOTAL_OPLCHF FROM dognet_docoplchfsubpodr WHERE koddel<>'99' AND dateoplchfsubpodr<='{$_ONDATE}' AND koddocsubpodr IN (SELECT koddocsubpodr FROM dognet_docchfsubpodr WHERE koddel<>'99' AND datechfsubpodr<='{$_ONDATE}')");
$_ROW_SUBDOC5 = mysqli_fetch_assoc($_QRY_SUBDOC5);
$_total_sumoplchf = $_ROW_SUBDOC5['TOTAL_OPLCHF'];
// Сумма всех авансов по всем договорам
$_QRY_SUBDOC6_1 = mysqlQuery("SELECT SUM(sumavsubpodr) as TOTAL_AV FROM dognet_docavsubpodr WHERE koddel<>'99' AND dateavsubpodr<='{$_ONDATE}' AND koddocsubpodr IN (SELECT koddocsubpodr FROM dognet_docchfsubpodr WHERE koddel<>'99' AND datechfsubpodr<='{$_ONDATE}')");
$_ROW_SUBDOC6_1 = mysqli_fetch_assoc($_QRY_SUBDOC6_1);
$_total_sumav = $_ROW_SUBDOC6_1['TOTAL_AV'];
// Сумма всех полностью зачтенных авансов по всем договорам
$_QRY_SUBDOC6_2 = mysqlQuery("SELECT SUM(sumavsubpodr) as TOTAL_AVCHF FROM dognet_docavsubpodr WHERE koddel<>'99' AND useavans='2' AND kodchfsubpodr<>'' AND dateavsubpodr<='{$_ONDATE}' AND koddocsubpodr IN (SELECT koddocsubpodr FROM dognet_docchfsubpodr WHERE koddel<>'99' AND datechfsubpodr<='{$_ONDATE}')");
$_ROW_SUBDOC6_2 = mysqli_fetch_assoc($_QRY_SUBDOC6_2);
$_total_sumavchf = $_ROW_SUBDOC6_2['TOTAL_AVCHF'];
// Сумма всех частично зачтенных авансов по всем договорам
$_QRY_SUBDOC6_3 = mysqlQuery("SELECT SUM(sumavsplit) as TOTAL_AVSPLITCHF FROM dognet_docavsplitsubpodr WHERE koddel<>'99' AND kodchfsubpodr<>'' AND dateavsplit<='{$_ONDATE}' AND kodavsubpodr IN (SELECT kodavsubpodr FROM dognet_docavsubpodr WHERE koddel<>'99' AND useavans='1' AND kodchfsubpodr='' AND dateavsubpodr<='{$_ONDATE}')");
$_ROW_SUBDOC6_3 = mysqli_fetch_assoc($_QRY_SUBDOC6_3);
$_total_sumavsplitchf = $_ROW_SUBDOC6_3['TOTAL_AVSPLITCHF'];

// Сумма задолженностей по договорам субподряда по столбцу sumzadolsubpodr
$_QRY_SUBDOC7 = mysqlQuery("SELECT SUM(sumzadolsubpodr) as TOTAL_ZADOL FROM dognet_docsubpodr WHERE koddel<>'99'");
$_ROW_SUBDOC7 = mysqli_fetch_assoc($_QRY_SUBDOC7);
$_total_zadol_table = $_ROW_SUBDOC7['TOTAL_ZADOL'];
$_total_zadol_table = $_ROW_SUBDOC7['TOTAL_ZADOL'];

// Сумма выплаченных авансов
$_total_av = $_total_sumav;
// Сумма совершенных оплат
$_total_oplchf = $_total_sumoplchf;
// Сумма полностью зачтенных авансов
$_total_avchf = $_total_sumavchf;
// Сумма частично зачтенных авансов
$_total_splitchf = $_total_sumavsplitchf;
// Общая сумма зачтенная из авансов
$_total_avsplitchf = $_total_avchf + $_total_splitchf;
// Общая сумма зачтенных авансов и совершенных оплат
$_total_oplavchf = $_total_oplchf + $_total_avsplitchf;

// Расчетная общая задолженность по счетам
$_total_zadol_calc = $_total_sumchf - $_total_oplavchf;
$_itogo_calc = $_total_zadol_calc;

// Табличная общая задолженность по счетам
$_itogo_table = $_total_zadol_table;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
// Задаем высоту строки и шрифт
$activeSheet->getRowDimension($line)->setRowHeight(32);
$activeSheet->getStyle("A{$line}:B{$line}")->getFont()->setSize(11);
$activeSheet->getStyle("A{$line}:B{$line}")->getFont()->setItalic(false);
$activeSheet->getStyle("A{$line}:B{$line}")->getFont()->setBold(true);
$activeSheet->getStyle("D{$line}:E{$line}")->getFont()->setSize(11);
$activeSheet->getStyle("D{$line}:E{$line}")->getFont()->setItalic(false);
$activeSheet->getStyle("D{$line}:E{$line}")->getFont()->setBold(true);
$activeSheet->getStyle("A{$line}:E{$line}")->getFont()->setName('Arial');
// Задаем цвет текста строки
$activeSheet->getStyle("A{$line}:E{$line}")->getFont()->getColor()->setRGB('111111');
// Выравниваем строку по вертикали ( середина )
$activeSheet->getStyle("A{$line}:E{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Вывод данных
$activeSheet->setCellValue("A{$line}", "Общее количество субподрядных организаций");
$activeSheet->setCellValue("B{$line}", $_qty_subdocA);
$activeSheet->setCellValue("C{$line}", '');
$activeSheet->setCellValue("D{$line}", "Всего выставлено счетов на сумму");
$activeSheet->setCellValue("E{$line}", number_format($_total_sumchf, 2, '.', ' '));
// Выравнивание по горизонтали - центр
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("B{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$activeSheet->getStyle("D{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("E{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
// Оформляем границы
// 	$activeSheet->getStyle("A{$line}:E{$line}")->applyFromArray($_BORDER_INSIDE);
// 	$activeSheet->getStyle("A{$line}:E{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
// Задаем высоту строки и шрифт
$activeSheet->getRowDimension($line)->setRowHeight(32);
$activeSheet->getStyle("A{$line}:B{$line}")->getFont()->setSize(10);
$activeSheet->getStyle("A{$line}:B{$line}")->getFont()->setItalic(true);
$activeSheet->getStyle("A{$line}:B{$line}")->getFont()->setBold(false);
$activeSheet->getStyle("D{$line}:E{$line}")->getFont()->setSize(11);
$activeSheet->getStyle("D{$line}:E{$line}")->getFont()->setItalic(false);
$activeSheet->getStyle("D{$line}:E{$line}")->getFont()->setBold(true);
$activeSheet->getStyle("A{$line}:E{$line}")->getFont()->setName('Arial');
// Задаем цвет текста строки
$activeSheet->getStyle("A{$line}:E{$line}")->getFont()->getColor()->setRGB('111111');
// Выравниваем строку по вертикали ( середина )
$activeSheet->getStyle("A{$line}:E{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Вывод данных
$activeSheet->setCellValue("A{$line}", "- из них с задолженностью");
$activeSheet->setCellValue("B{$line}", $_qty_subdocB);
$activeSheet->setCellValue("C{$line}", '');
$activeSheet->setCellValue("D{$line}", "Всего оплачено счетов на сумму");
$activeSheet->setCellValue("E{$line}", number_format($_total_oplchf, 2, '.', ' '));
// Выравнивание по горизонтали - центр
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("B{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$activeSheet->getStyle("D{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("E{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
// Оформляем границы
// 	$activeSheet->getStyle("A{$line}:E{$line}")->applyFromArray($_BORDER_INSIDE);
// 	$activeSheet->getStyle("A{$line}:E{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
// Задаем высоту строки и шрифт
$activeSheet->getRowDimension($line)->setRowHeight(32);
$activeSheet->getStyle("A{$line}:B{$line}")->getFont()->setSize(11);
$activeSheet->getStyle("A{$line}:B{$line}")->getFont()->setItalic(false);
$activeSheet->getStyle("A{$line}:B{$line}")->getFont()->setBold(true);
$activeSheet->getStyle("D{$line}:E{$line}")->getFont()->setSize(11);
$activeSheet->getStyle("D{$line}:E{$line}")->getFont()->setItalic(false);
$activeSheet->getStyle("D{$line}:E{$line}")->getFont()->setBold(true);
$activeSheet->getStyle("A{$line}:E{$line}")->getFont()->setName('Arial');
// Задаем цвет текста строки
$activeSheet->getStyle("A{$line}:E{$line}")->getFont()->getColor()->setRGB('111111');
// Выравниваем строку по вертикали ( середина )
$activeSheet->getStyle("A{$line}:E{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Вывод данных
$activeSheet->setCellValue("A{$line}", "Общее количество договоров");
$activeSheet->setCellValue("B{$line}", $_qty_subdoc1);
$activeSheet->setCellValue("C{$line}", '');
$activeSheet->setCellValue("D{$line}", "Всего выплачено авансов на сумму");
$activeSheet->setCellValue("E{$line}", number_format($_total_av, 2, '.', ' '));
// Выравнивание по горизонтали - центр
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("B{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$activeSheet->getStyle("D{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("E{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
// Оформляем границы
// 	$activeSheet->getStyle("A{$line}:E{$line}")->applyFromArray($_BORDER_INSIDE);
// 	$activeSheet->getStyle("A{$line}:E{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
// Задаем высоту строки и шрифт
$activeSheet->getRowDimension($line)->setRowHeight(32);
$activeSheet->getStyle("A{$line}:B{$line}")->getFont()->setSize(10);
$activeSheet->getStyle("A{$line}:B{$line}")->getFont()->setItalic(true);
$activeSheet->getStyle("A{$line}:B{$line}")->getFont()->setBold(false);
$activeSheet->getStyle("D{$line}:E{$line}")->getFont()->setSize(10);
$activeSheet->getStyle("D{$line}:E{$line}")->getFont()->setItalic(true);
$activeSheet->getStyle("D{$line}:E{$line}")->getFont()->setBold(false);
$activeSheet->getStyle("A{$line}:E{$line}")->getFont()->setName('Arial');
// Задаем цвет текста строки
$activeSheet->getStyle("A{$line}:E{$line}")->getFont()->getColor()->setRGB('111111');
// Выравниваем строку по вертикали ( середина )
$activeSheet->getStyle("A{$line}:E{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Вывод данных
$activeSheet->setCellValue("A{$line}", "- из них с задолженностью");
$activeSheet->setCellValue("B{$line}", $_qty_subdoc2);
$activeSheet->setCellValue("C{$line}", '');
$activeSheet->setCellValue("D{$line}", "- из нее зачтено");
$activeSheet->setCellValue("E{$line}", number_format($_total_avsplitchf, 2, '.', ' '));
// Выравнивание по горизонтали - центр
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("B{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$activeSheet->getStyle("D{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("E{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
// Оформляем границы
// 	$activeSheet->getStyle("A{$line}:E{$line}")->applyFromArray($_BORDER_INSIDE);
// 	$activeSheet->getStyle("A{$line}:E{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
// Задаем высоту строки и шрифт
$activeSheet->getRowDimension($line)->setRowHeight(32);
$activeSheet->getStyle("A{$line}:B{$line}")->getFont()->setSize(10);
$activeSheet->getStyle("A{$line}:B{$line}")->getFont()->setItalic(true);
$activeSheet->getStyle("A{$line}:B{$line}")->getFont()->setBold(false);
$activeSheet->getStyle("D{$line}:E{$line}")->getFont()->setSize(11);
$activeSheet->getStyle("D{$line}:E{$line}")->getFont()->setItalic(false);
$activeSheet->getStyle("D{$line}:E{$line}")->getFont()->setBold(true);
$activeSheet->getStyle("A{$line}:E{$line}")->getFont()->setName('Arial');
// Задаем цвет текста строки
$activeSheet->getStyle("A{$line}:E{$line}")->getFont()->getColor()->setRGB('111111');
// Выравниваем строку по вертикали ( середина )
$activeSheet->getStyle("A{$line}:E{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Вывод данных
$activeSheet->setCellValue("A{$line}", "- из них незакрытых");
$activeSheet->setCellValue("B{$line}", $_qty_nezakr);
$activeSheet->setCellValue("C{$line}", '');
$activeSheet->setCellValue("D{$line}", "Итого закрыто по счетам");
$activeSheet->setCellValue("E{$line}", number_format($_total_oplavchf, 2, '.', ' '));
// Выравнивание по горизонтали - центр
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("B{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$activeSheet->getStyle("D{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("E{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
// Оформляем границы
// 	$activeSheet->getStyle("A{$line}:E{$line}")->applyFromArray($_BORDER_INSIDE);
// 	$activeSheet->getStyle("A{$line}:E{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
#
#
// Добавляем рамку к шапке таблицы
// $activeSheet->getStyle("A{$start_table}:B{$line}")->applyFromArray($_BORDER_OUTSIDE_THIN);
// Добавляем рамку ко всей таблице
// $activeSheet->getStyle("D{$start_table}:E{$line}")->applyFromArray($_BORDER_OUTSIDE_THIN);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
$line++;
$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
// Задаем высоту строки и шрифт
$activeSheet->getRowDimension($line)->setRowHeight(32);
$activeSheet->getStyle("A{$line}:E{$line}")->getFont()->setSize(13);
$activeSheet->getStyle("A{$line}:E{$line}")->getFont()->setItalic(true);
$activeSheet->getStyle("A{$line}:E{$line}")->getFont()->setBold(true);
// Задаем цвет текста строки
$activeSheet->getStyle("A{$line}:E{$line}")->getFont()->getColor()->setRGB('111111');
// Выравниваем строку по вертикали ( середина )
$activeSheet->getStyle("A{$line}:E{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Выравнивание по горизонтали - центр
$activeSheet->getStyle("A{$line}:B{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("D{$line}:E{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("B{$line}:E{$line}");
#
$activeSheet->setCellValue("A{$line}", "Итоговая задолженность (расчетная): ");
$activeSheet->setCellValue("B{$line}", number_format($_itogo_calc, 2, '.', ' '));
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Задаем высоту строки и шрифт
$activeSheet->getRowDimension($line)->setRowHeight(32);
$activeSheet->getStyle("A{$line}:E{$line}")->getFont()->setSize(13);
$activeSheet->getStyle("A{$line}:E{$line}")->getFont()->setItalic(true);
$activeSheet->getStyle("A{$line}:E{$line}")->getFont()->setBold(true);
// Задаем цвет текста строки
$activeSheet->getStyle("A{$line}:E{$line}")->getFont()->getColor()->setRGB('111111');
// Выравниваем строку по вертикали ( середина )
$activeSheet->getStyle("A{$line}:E{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Выравнивание по горизонтали - центр
$activeSheet->getStyle("A{$line}:B{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("D{$line}:E{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("B{$line}:E{$line}");
#
$activeSheet->setCellValue("A{$line}", "Итоговая задолженность (табличная): ");
$activeSheet->setCellValue("B{$line}", '---');
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Пропускаем строки
$line++;
$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
$activeSheet->setCellValue("A{$line}", "На следующих листах приведен список компаний-плательщиков, со стороны которых по выставленным счетам-фактурам имеются разные виды задолженностей.");
// Задаем высоту строки
$activeSheet->getRowDimension($line)->setRowHeight(32);
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:E{$line}");
// Делаем выравнивание по центру вертикали и горизонтали
$activeSheet->getStyle("A{$line}:E{$line}")->getAlignment()->setWrapText(true);
// Устанавливаем шрифт
$activeSheet->getStyle("A{$line}")->getFont()->setSize(12);
// Выравниваем строку по вертикали ( середина )
$activeSheet->getStyle("A{$line}:E{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

/*

SELECT SUM(dognet_docchfsubpodr.sumchfsubpodr) FROM dognet_docchfsubpodr WHERE koddel<>'99';
SELECT SUM(dognet_docoplchfsubpodr.sumoplchfsubpodr) FROM dognet_docoplchfsubpodr WHERE koddel<>'99';
SELECT SUM(dognet_docavsubpodr.sumavsubpodr) FROM dognet_docavsubpodr WHERE koddel<>'99';
SELECT SUM(dognet_docavsubpodr.sumavsubpodr) FROM dognet_docavsubpodr WHERE koddel<>'99' AND useavans='2' AND `kodchfsubpodr`<>'';
SELECT SUM(dognet_docavsplitsubpodr.sumavsplit) FROM dognet_docavsplitsubpodr WHERE koddel<>'99' AND `kodchfsubpodr`<>'' AND kodavsubpodr IN (SELECT kodavsubpodr FROM dognet_docavsubpodr WHERE koddel<>'99' AND useavans='1' AND `kodchfsubpodr`='');

*/