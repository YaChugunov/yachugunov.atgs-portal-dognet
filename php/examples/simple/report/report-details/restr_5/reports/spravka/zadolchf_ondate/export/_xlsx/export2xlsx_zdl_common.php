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
		$objPHPExcel->setActiveSheetIndex($cntsheets-1);
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
$activeSheet->getHeaderFooter()->setOddHeader('&L&G&B&12СПРАВКА О ЗАДОЛЖЕННОСТИ НА ДАТУ&R&G&B&12По счетам-фактурам');
$activeSheet->getHeaderFooter()->setOddFooter('&11&L&B'.$_SESSION["current_user_firstname"].' '.$_SESSION["current_user_lastname"].' / '.date('d.m.Y H:i:s').'&R&11Страница &P из &N');
#
// Настройки шрифта
$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');
$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
// Задаем свой формат
define("PRICE_FORMAT_CMN", PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1. "[\$ р.-419]");
// Предопределим массивы оформления границы ячеек
$_BORDER_RIGHT = array('borders'=>array('right'=>array('style'=>PHPExcel_Style_Border::BORDER_THIN,'color'=>array('rgb'=>'000000'))));
$_BORDER_RIGHT_NONE = array('borders'=>array('right'=>array('style'=>PHPExcel_Style_Border::BORDER_NONE)));
$_BORDER_LEFT = array('borders'=>array('left'=>array('style'=>PHPExcel_Style_Border::BORDER_THIN,'color'=>array('rgb'=>'000000'))));
$_BORDER_LEFT_NONE = array('borders'=>array('left'=>array('style'=>PHPExcel_Style_Border::BORDER_NONE)));
// Внешняя рамка, тонкая
$_BORDER_OUTSIDE_THIN = array('borders'=>array('outline'=>array('style'=>PHPExcel_Style_Border::BORDER_THIN,'color'=>array('rgb'=>'000000'))));
// Внешняя рамка, толстая
$_BORDER_OUTSIDE_THICK = array('borders'=>array('outline'=>array('style'=>PHPExcel_Style_Border::BORDER_THICK,'color'=>array('rgb'=>'000000'))));
// Внутренние разделители
$_BORDER_INSIDE = array('borders'=>array('inside'=>array('style'=>PHPExcel_Style_Border::BORDER_THIN,'color'=>array('rgb'=>'000000'))));
$_BORDER_INSIDE_NONE = array('borders'=>array('inside'=>array('style'=>PHPExcel_Style_Border::BORDER_NONE)));
$_BORDER_TOP = array('borders'=>array('top'=>array('style'=>PHPExcel_Style_Border::BORDER_THIN,'color'=>array('rgb'=>'000000'))));
$_BORDER_BOTTOM_THIN = array('borders'=>array('bottom'=>array('style'=>PHPExcel_Style_Border::BORDER_THIN,'color'=>array('rgb'=>'000000'))));
$_BORDER_BOTTOM_THICK = array('borders'=>array('bottom'=>array('style'=>PHPExcel_Style_Border::BORDER_THICK,'color'=>array('rgb'=>'000000'))));









# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# ФОРМАТИРУЕМ ВЫХОДНУЮ ТАБЛИЦУ EXCEL
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
// Задаем ширины столбцов
$activeSheet->getColumnDimension('A')->setWidth(70); // Вид задолженности
$activeSheet->getColumnDimension('B')->setWidth(30); // Итого по договорам
$activeSheet->getColumnDimension('C')->setWidth(30); // Итого по счетам
#
// Для удобства заводим переменную $line, в ней будем считать номер строки
$line = 1;
#
# ----- ----- ----- ----- -----
# СТРОКА 1
# ----- ----- ----- ----- -----
// Выводим название отчета
$activeSheet->setCellValue("A{$line}", 'Справка о задолженности на '.date('d.m.Y', strtotime($_ONDATE)));
// Задаем высоту строки
$activeSheet->getRowDimension($line)->setRowHeight(32);
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:C{$line}");
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
$activeSheet->setCellValue("A{$line}", 'ВИД ЗАДОЛЖЕННОСТИ');
$activeSheet->setCellValue("B{$line}", 'ИТОГО ПО ДОГОВОРАМ');
$activeSheet->setCellValue("C{$line}", 'ИТОГО ПО СЧЕТАМ');
// Стили для текста в шапки таблицы.
$activeSheet->getRowDimension($line)->setRowHeight(32); // высота строки
$activeSheet->getStyle("A{$line}:C{$line}")->getFont()->setSize(12); // размер шрифта
$activeSheet->getStyle("A{$line}:C{$line}")->getFont()->setBold(true); // делаем шрифт жирным
// разрешаем перенос строк в ячейке
$activeSheet->getStyle("A{$line}:C{$line}")->getAlignment()->setWrapText(true);
// выравнивание по горизонтали - слева
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
// выравнивание по горизонтали - центр
$activeSheet->getStyle("B{$line}:C{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$activeSheet->getStyle("A{$line}:C{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); // вырванивание по вертикали - середина
// Делаем заливку области ячеек
$activeSheet->getStyle("A{$line}:C{$line}")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$activeSheet->getStyle("A{$line}:C{$line}")->getFill()->getStartColor()->setRGB("F1F1F1");
// Оформляем границы
		$activeSheet->getStyle("A{$line}:C{$line}")->applyFromArray($_BORDER_INSIDE);
		$activeSheet->getStyle("A{$line}:C{$line}")->applyFromArray($_BORDER_OUTSIDE_THICK);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
	$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#



// Текущая задолженность
	$_QRY_DOC1 = mysqlQuery( "SELECT SUM(summazadol) as SUM_1 FROM dognet_reports_zadolchf_ondate WHERE kodstatuszdl = '1' AND koddel <> '99' AND koddoc IN (SELECT koddoc FROM dognet_docbase WHERE numberchet = '')" );
	$_ROW_DOC1 = mysqli_fetch_assoc($_QRY_DOC1);
	$_sumzadol_doc1 = $_ROW_DOC1['SUM_1'];
	$_QRY_CHT1 = mysqlQuery( "SELECT SUM(summazadol) as SUM_1 FROM dognet_reports_zadolchf_ondate WHERE kodstatuszdl = '1' AND koddel <> '99' AND koddoc IN (SELECT koddoc FROM dognet_docbase WHERE numberchet <> '')" );
	$_ROW_CHT1 = mysqli_fetch_assoc($_QRY_CHT1);
	$_sumzadol_cht1 = $_ROW_CHT1['SUM_1'];

// Судебная задолженность
	$_QRY_DOC2 = mysqlQuery( "SELECT SUM(summazadol) as SUM_2 FROM dognet_reports_zadolchf_ondate WHERE kodstatuszdl = '2' AND koddel <> '99' AND koddoc IN (SELECT koddoc FROM dognet_docbase WHERE numberchet = '')" );
	$_ROW_DOC2 = mysqli_fetch_assoc($_QRY_DOC2);
	$_sumzadol_doc2 = $_ROW_DOC2['SUM_2'];
	$_QRY_CHT2 = mysqlQuery( "SELECT SUM(summazadol) as SUM_2 FROM dognet_reports_zadolchf_ondate WHERE kodstatuszdl = '2' AND koddel <> '99' AND koddoc IN (SELECT koddoc FROM dognet_docbase WHERE numberchet <> '')" );
	$_ROW_CHT2 = mysqli_fetch_assoc($_QRY_CHT2);
	$_sumzadol_cht2 = $_ROW_CHT2['SUM_2'];

// Невозвратная задолженность
	$_QRY_DOC3 = mysqlQuery( "SELECT SUM(summazadol) as SUM_3 FROM dognet_reports_zadolchf_ondate WHERE kodstatuszdl = '3' AND koddel <> '99' AND koddoc IN (SELECT koddoc FROM dognet_docbase WHERE numberchet = '')" );
	$_ROW_DOC3 = mysqli_fetch_assoc($_QRY_DOC3);
	$_sumzadol_doc3 = $_ROW_DOC3['SUM_3'];
	$_QRY_CHT3 = mysqlQuery( "SELECT SUM(summazadol) as SUM_3 FROM dognet_reports_zadolchf_ondate WHERE kodstatuszdl = '3' AND koddel <> '99' AND koddoc IN (SELECT koddoc FROM dognet_docbase WHERE numberchet <> '')" );
	$_ROW_CHT3 = mysqli_fetch_assoc($_QRY_CHT3);
	$_sumzadol_cht3 = $_ROW_CHT3['SUM_3'];






#
#
// Задаем высоту строки и шрифт
	$activeSheet->getRowDimension($line)->setRowHeight(32);
	$activeSheet->getStyle("A{$line}:C{$line}")->getFont()->setSize(11);
	$activeSheet->getStyle("A{$line}:C{$line}")->getFont()->setBold(true);
	$activeSheet->getStyle("A{$line}:C{$line}")->getFont()->setName('Arial');
// Задаем цвет текста строки
	$activeSheet->getStyle("A{$line}:C{$line}")->getFont()->getColor()->setRGB('111111');
// Выравниваем строку по вертикали ( середина )
	$activeSheet->getStyle("A{$line}:C{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Вывод данных
	$activeSheet->setCellValue("A{$line}", "Текущая");
// Вывод данных
	$activeSheet->setCellValue("B{$line}", $_sumzadol_doc1);
	$activeSheet->setCellValue("C{$line}", $_sumzadol_cht1);
// Выравнивание по горизонтали - центр
	$activeSheet->getStyle("B{$line}:C{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// Оформляем границы
	$activeSheet->getStyle("A{$line}:C{$line}")->applyFromArray($_BORDER_INSIDE);
	$activeSheet->getStyle("A{$line}:C{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
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
	$activeSheet->getStyle("A{$line}:C{$line}")->getFont()->setSize(11);
	$activeSheet->getStyle("A{$line}:C{$line}")->getFont()->setBold(true);
	$activeSheet->getStyle("A{$line}:C{$line}")->getFont()->setName('Arial');
// Задаем цвет текста строки
	$activeSheet->getStyle("A{$line}:C{$line}")->getFont()->getColor()->setRGB('111111');
// Выравниваем строку по вертикали ( середина )
	$activeSheet->getStyle("A{$line}:C{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Вывод данных
	$activeSheet->setCellValue("A{$line}", "Судебная");
// Вывод данных
	$activeSheet->setCellValue("B{$line}", $_sumzadol_doc2);
	$activeSheet->setCellValue("C{$line}", $_sumzadol_cht2);
// Выравнивание по горизонтали - центр
	$activeSheet->getStyle("B{$line}:C{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// Оформляем границы
	$activeSheet->getStyle("A{$line}:C{$line}")->applyFromArray($_BORDER_INSIDE);
	$activeSheet->getStyle("A{$line}:C{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
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
	$activeSheet->getStyle("A{$line}:C{$line}")->getFont()->setSize(11);
	$activeSheet->getStyle("A{$line}:C{$line}")->getFont()->setBold(true);
	$activeSheet->getStyle("A{$line}:C{$line}")->getFont()->setName('Arial');
// Задаем цвет текста строки
	$activeSheet->getStyle("A{$line}:C{$line}")->getFont()->getColor()->setRGB('111111');
// Выравниваем строку по вертикали ( середина )
	$activeSheet->getStyle("A{$line}:C{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Вывод данных
	$activeSheet->setCellValue("A{$line}", "Невозвратная");
// Вывод данных
	$activeSheet->setCellValue("B{$line}", $_sumzadol_doc3);
	$activeSheet->setCellValue("C{$line}", $_sumzadol_cht3);
// Выравнивание по горизонтали - центр
	$activeSheet->getStyle("B{$line}:C{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// Оформляем границы
	$activeSheet->getStyle("A{$line}:C{$line}")->applyFromArray($_BORDER_INSIDE);
	$activeSheet->getStyle("A{$line}:C{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
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
	$activeSheet->getStyle("A{$line}:C{$line}")->getFont()->setName('Arial');
	$activeSheet->getStyle("A{$line}:C{$line}")->getFont()->setSize(13);
	$activeSheet->getStyle("A{$line}:C{$line}")->getFont()->setBold(true); // делаем шрифт жирным
// Задаем цвет заливки строки
	$activeSheet->getStyle("A{$line}:C{$line}")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$activeSheet->getStyle("A{$line}:C{$line}")->getFill()->getStartColor()->setRGB("D0D0D0");
// Задаем цвет текста строки
	$activeSheet->getStyle("A{$line}:C{$line}")->getFont()->getColor()->setRGB('111111');
// Выравниваем строку по вертикали ( середина )
	$activeSheet->getStyle("A{$line}:C{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Вывод данных
	$activeSheet->setCellValue("A{$line}", 'ИТОГО ВСЕГО');
	$activeSheet->setCellValue("B{$line}", $_sumzadol_doc1+$_sumzadol_doc2+$_sumzadol_doc3);
	$activeSheet->getStyle("B{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_CMN);
// Выравнивание по горизонтали - центр
	$activeSheet->getStyle("B{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$activeSheet->setCellValue("C{$line}", $_sumzadol_cht1+$_sumzadol_cht2+$_sumzadol_cht3);
	$activeSheet->getStyle("C{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_CMN);
// Выравнивание по горизонтали - центр
	$activeSheet->getStyle("C{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// Оформляем границы
	$activeSheet->getStyle("A{$line}:C{$line}")->applyFromArray($_BORDER_INSIDE);
	$activeSheet->getStyle("A{$line}:C{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
#
#
// Добавляем рамку к шапке таблицы
$activeSheet->getStyle("A{$start_table}:C{$start_table}")->applyFromArray($_BORDER_OUTSIDE_THIN);
// Добавляем рамку ко всей таблице
$activeSheet->getStyle("A{$start_table}:C{$line}")->applyFromArray($_BORDER_OUTSIDE_THIN);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Пропускаем строки
	$line++;
	$line++;
	$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
$activeSheet->setCellValue("A{$line}", "На следующих листах приведен список компаний-плательщиков, со стороны которых по выставленным счетам-фактурам имеются разные виды задолженностей.");
// Задаем высоту строки
$activeSheet->getRowDimension($line)->setRowHeight(32);
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:C{$line}");
// Делаем выравнивание по центру вертикали и горизонтали
$activeSheet->getStyle("A{$line}:C{$line}")->getAlignment()->setWrapText(true);
// Устанавливаем шрифт
$activeSheet->getStyle("A{$line}")->getFont()->setSize(12);
// Выравниваем строку по вертикали ( середина )
	$activeSheet->getStyle("A{$line}:C{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Пропускаем строки
	$line++;
	$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
$activeSheet->setCellValue("A{$line}", "В этом списке определены для вывода следующие виды задолженностей:");
// Задаем высоту строки
$activeSheet->getRowDimension($line)->setRowHeight(22);
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:C{$line}");
// Делаем выравнивание по центру вертикали и горизонтали
$activeSheet->getStyle("A{$line}:C{$line}")->getAlignment()->setWrapText(true);
// Устанавливаем шрифт
$activeSheet->getStyle("A{$line}")->getFont()->setSize(12);
// Выравниваем строку по вертикали ( середина )
	$activeSheet->getStyle("A{$line}:C{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
#
if ($A1) {
	$line++;
	$activeSheet->setCellValue("A{$line}", "- текущая");
	// Задаем высоту строки
	$activeSheet->getRowDimension($line)->setRowHeight(18);
	// Делаем выравнивание по центру вертикали и горизонтали
	$activeSheet->getStyle("A{$line}")->getAlignment()->setWrapText(true);
	// Устанавливаем шрифт
	$activeSheet->getStyle("A{$line}")->getFont()->setSize(11);
	$activeSheet->getStyle("A{$line}")->getFont()->setBold(true);
	// Выравниваем строку по вертикали ( середина )
		$activeSheet->getStyle("A{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
}
if ($A2) {
	$line++;
	$activeSheet->setCellValue("A{$line}", "- судебная");
	// Задаем высоту строки
	$activeSheet->getRowDimension($line)->setRowHeight(18);
	// Делаем выравнивание по центру вертикали и горизонтали
	$activeSheet->getStyle("A{$line}")->getAlignment()->setWrapText(true);
	// Устанавливаем шрифт
	$activeSheet->getStyle("A{$line}")->getFont()->setSize(11);
	$activeSheet->getStyle("A{$line}")->getFont()->setBold(true);
	// Выравниваем строку по вертикали ( середина )
		$activeSheet->getStyle("A{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
}
if ($A3) {
	$line++;
	$activeSheet->setCellValue("A{$line}", "- невозвратная");
	// Задаем высоту строки
	$activeSheet->getRowDimension($line)->setRowHeight(18);
	// Делаем выравнивание по центру вертикали и горизонтали
	$activeSheet->getStyle("A{$line}")->getAlignment()->setWrapText(true);
	// Устанавливаем шрифт
	$activeSheet->getStyle("A{$line}")->getFont()->setSize(11);
	$activeSheet->getStyle("A{$line}")->getFont()->setBold(true);
	// Выравниваем строку по вертикали ( середина )
		$activeSheet->getStyle("A{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
}
if (!($A1 OR $A2 OR $A3)) {
	$line++;
	$activeSheet->setCellValue("A{$line}", "типы документов не определены");
	// Задаем высоту строки
	$activeSheet->getRowDimension($line)->setRowHeight(18);
	// Делаем выравнивание по центру вертикали и горизонтали
	$activeSheet->getStyle("A{$line}")->getAlignment()->setWrapText(true);
	// Устанавливаем шрифт
	$activeSheet->getStyle("A{$line}")->getFont()->setSize(11);
	$activeSheet->getStyle("A{$line}")->getFont()->setBold(true);
	// Выравниваем строку по вертикали ( середина )
		$activeSheet->getStyle("A{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
}
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Пропускаем строки
	$line++;
	$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
$activeSheet->setCellValue("A{$line}", "В этом списке определены для вывода следующие типы документов:");
// Задаем высоту строки
$activeSheet->getRowDimension($line)->setRowHeight(22);
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:C{$line}");
// Делаем выравнивание по центру вертикали и горизонтали
$activeSheet->getStyle("A{$line}:C{$line}")->getAlignment()->setWrapText(true);
// Устанавливаем шрифт
$activeSheet->getStyle("A{$line}")->getFont()->setSize(12);
// Выравниваем строку по вертикали ( середина )
	$activeSheet->getStyle("A{$line}:C{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
#
if ($B1) {
	$line++;
	$activeSheet->setCellValue("A{$line}", "- договор");
	// Задаем высоту строки
	$activeSheet->getRowDimension($line)->setRowHeight(18);
	// Делаем выравнивание по центру вертикали и горизонтали
	$activeSheet->getStyle("A{$line}")->getAlignment()->setWrapText(true);
	// Устанавливаем шрифт
	$activeSheet->getStyle("A{$line}")->getFont()->setSize(11);
	$activeSheet->getStyle("A{$line}")->getFont()->setBold(true);
	// Выравниваем строку по вертикали ( середина )
		$activeSheet->getStyle("A{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
}
if ($B2) {
	$line++;
	$activeSheet->setCellValue("A{$line}", "- счет");
	// Задаем высоту строки
	$activeSheet->getRowDimension($line)->setRowHeight(18);
	// Делаем выравнивание по центру вертикали и горизонтали
	$activeSheet->getStyle("A{$line}")->getAlignment()->setWrapText(true);
	// Устанавливаем шрифт
	$activeSheet->getStyle("A{$line}")->getFont()->setSize(11);
	$activeSheet->getStyle("A{$line}")->getFont()->setBold(true);
	// Выравниваем строку по вертикали ( середина )
		$activeSheet->getStyle("A{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
}
if (!($B1 OR $B2)) {
	$line++;
	$activeSheet->setCellValue("A{$line}", "типы документов не определены");
	// Задаем высоту строки
	$activeSheet->getRowDimension($line)->setRowHeight(18);
	// Делаем выравнивание по центру вертикали и горизонтали
	$activeSheet->getStyle("A{$line}")->getAlignment()->setWrapText(true);
	// Устанавливаем шрифт
	$activeSheet->getStyle("A{$line}")->getFont()->setSize(11);
	$activeSheet->getStyle("A{$line}")->getFont()->setBold(true);
	// Выравниваем строку по вертикали ( середина )
		$activeSheet->getStyle("A{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
}
?>