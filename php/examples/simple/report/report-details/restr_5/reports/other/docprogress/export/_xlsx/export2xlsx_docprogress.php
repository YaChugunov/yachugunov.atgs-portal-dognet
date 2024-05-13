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
$activeSheet->setTitle('Выполнение по договорам');
#
// Колонтитулы
$activeSheet->getHeaderFooter()->setOddHeader('&L&G&B&12ВЫПОЛНЕНИЕ ПО ВСЕМ ДОГОВОРАМ&R&G&B&12В интервале дат');
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
$start_date = date("Y-m-d", strtotime($_GET['start_date']));
$end_date = date("Y-m-d", strtotime($_GET['end_date']));
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# ФОРМАТИРУЕМ ВЫХОДНУЮ ТАБЛИЦУ EXCEL
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
// Задаем ширины столбцов
$activeSheet->getColumnDimension('A')->setWidth(15); // Номер договора - этапа
$activeSheet->getColumnDimension('B')->setWidth(15); // Дата начала договора
$activeSheet->getColumnDimension('C')->setWidth(120); // Название договора / этапа
$activeSheet->getColumnDimension('D')->setWidth(35); // Заказчик
$activeSheet->getColumnDimension('E')->setWidth(35); // Объект
$activeSheet->getColumnDimension('F')->setWidth(22); // Тип
$activeSheet->getColumnDimension('G')->setWidth(12); // № СФ
$activeSheet->getColumnDimension('H')->setWidth(15); // Дата СФ
$activeSheet->getColumnDimension('I')->setWidth(25); // Сумма СФ
$activeSheet->getColumnDimension('J')->setWidth(50); // Примечание
#
// Для удобства заводим переменную $line, в ней будем считать номер строки
$line = 1;
#
# ----- ----- ----- ----- -----
# СТРОКА 1
# ----- ----- ----- ----- -----
// Выводим название отчета
$activeSheet->setCellValue("A{$line}", 'ВЫПОЛНЕНИЕ ПО ВСЕМ ДОГОВОРАМ С ' . date("d.m.Y", strtotime($start_date)) . ' ПО ' . date("d.m.Y", strtotime($end_date)));
// Задаем высоту строки
$activeSheet->getRowDimension($line)->setRowHeight(24);
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:J{$line}");
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
$activeSheet->mergeCells("A{$line}:J{$line}");
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
$activeSheet->mergeCells("A{$line}:J{$line}");
// Делаем выравнивание по центру вертикали и горизонтали
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("A{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Делаем текст жирным и увеличиваем шрифт.
$activeSheet->getStyle("A{$line}")->getFont()->setBold(true);
$activeSheet->getStyle("A{$line}")->getFont()->setSize(13);
#
# ----- ----- ----- ----- -----
# СТРОКА 4
# ----- ----- ----- ----- -----
// Пропускаем строку
$line++;
$activeSheet->setCellValue("A{$line}", '');
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
$line++;
$start_table = $line;
// Шапка таблицы
$activeSheet->setCellValue("A{$line}", 'ДОГОВОР');
$activeSheet->setCellValue("B{$line}", 'ДАТА');
$activeSheet->setCellValue("C{$line}", 'НАИМЕНОВАНИЕ ДОГОВОРА / ЭТАПА');
$activeSheet->setCellValue("D{$line}", 'ЗАКАЗЧИК');
$activeSheet->setCellValue("E{$line}", 'ОБЪЕКТ');
$activeSheet->setCellValue("F{$line}", 'ТИП');
$activeSheet->setCellValue("G{$line}", 'С/Ф №');
$activeSheet->setCellValue("H{$line}", 'ДАТА');
$activeSheet->setCellValue("I{$line}", 'СУММА (ВКЛ НДС)');
$activeSheet->setCellValue("J{$line}", 'ПРИМЕЧАНИЕ');
// Стили для текста в шапки таблицы.
$activeSheet->getRowDimension($line)->setRowHeight(18); // высота строки
$activeSheet->getStyle("A{$line}:J{$line}")->getFont()->setSize(11); // размер шрифта
$activeSheet->getStyle("A{$line}:J{$line}")->getFont()->setBold(true); // делаем шрифт жирным
$activeSheet->getStyle("A{$line}:J{$line}")->getAlignment()->setWrapText(true); // разрешаем перенос строк в ячейке
$activeSheet->getStyle("A{$line}:J{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); // вырванивание по вертикали - середина
$activeSheet->getStyle("A{$line}:J{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); // выравнивание по горизонтали - лево
// Делаем заливку области ячеек
$activeSheet->getStyle("A{$line}:J{$line}")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$activeSheet->getStyle("A{$line}:J{$line}")->getFill()->getStartColor()->setRGB("31708F");
// Задаем цвет текста строки
$activeSheet->getStyle("A{$line}:J{$line}")->getFont()->getColor()->setRGB('FFFFFF');
// Оформляем границы
$activeSheet->getStyle("A{$line}:J{$line}")->applyFromArray($_BORDER_INSIDE);
$activeSheet->getStyle("A{$line}:J{$line}")->applyFromArray($_BORDER_OUTSIDE_THICK);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
$_QRY_kalplanchf = mysqlQuery("SELECT * FROM dognet_kalplanchf WHERE koddel<>'99' AND (chetfdate BETWEEN '" . $start_date . "' AND '" . $end_date . "')");
$_SUM_TOTAL = 0.0;
//
while ($_ROW_kalplanchf = mysqli_fetch_assoc($_QRY_kalplanchf)) {
	// Делаем выборку этапов по идентификатору этапа (kodkalplan)
	$_QRY_dockalplan = mysqlQuery("SELECT * FROM dognet_dockalplan WHERE koddel<>'99' AND kodkalplan = '" . $_ROW_kalplanchf['kodkalplan'] . "'");
	$_SUM_ONSTAGE = 0.0;
	//
	while ($_ROW_dockalplan = mysqli_fetch_assoc($_QRY_dockalplan)) {
		$DOCBASE = $db_handle->runQuery("SELECT * FROM dognet_docbase WHERE koddoc = '" . $_ROW_dockalplan['koddoc'] . "'");
		$DOCTIP = $db_handle->runQuery("SELECT nametip FROM dognet_sptipdog WHERE kodtip = '" . $DOCBASE[0]['kodtip'] . "'");
		// $DOCOBJ = $db_handle->runQuery("SELECT nameobjectshot FROM sp_objects WHERE kodobject = '".$DOCBASE[0]['kodobject']."'");
		$DOCOBJ = $db_handle->runQuery("SELECT nameobjectshot FROM sp_objects WHERE kodobject = '" . $_ROW_dockalplan['kodobject'] . "'");
		$DOCZAK = $db_handle->runQuery("SELECT namezakshot FROM sp_contragents WHERE kodzakaz = '" . $DOCBASE[0]['kodzakaz'] . "'");
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		$_DOCDATE_DD = $DOCBASE[0]['daynachdoc'];
		$_DOCDATE_MM = str_pad($DOCBASE[0]['monthnachdoc'], 2, "0", STR_PAD_LEFT);
		$_DOCDATE_YYYY = $DOCBASE[0]['yearnachdoc'];
		$_DOCDATE = date("d.m.Y", strtotime($_DOCDATE_YYYY . "-" . $_DOCDATE_MM . "-" . $_DOCDATE_DD));
		$_CHFDATE = date("d.m.Y", strtotime($_ROW_kalplanchf['chetfdate']));
		$_CHFNUMBER = $_ROW_kalplanchf['chetfnumber'];
		$_CHFSUMMA = $_ROW_kalplanchf['chetfsumma'];
		$_CHFCOMM = $_ROW_kalplanchf['comment'];
		$_DOCTIP = $DOCTIP[0]['nametip'];
		$_DOCOBJ = $DOCOBJ[0]['nameobjectshot'];
		$_DOCZAK = $DOCZAK[0]['namezakshot'];
		$_DOCNAME = $DOCBASE[0]['docnameshot'];
		$_DOCNUM = $DOCBASE[0]['docnumber'];
		$_STAGENAME = $_ROW_dockalplan['nameshotstage'];
		$_STAGENUM = $_ROW_dockalplan['numberstage'];
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		// Задаем высоту строки и шрифт
		$activeSheet->getRowDimension($line)->setRowHeight(18);
		$activeSheet->getStyle("A{$line}:J{$line}")->getFont()->setSize(10);
		$activeSheet->getStyle("A{$line}:J{$line}")->getFont()->setBold(false);
		// Задаем цвет текста строки
		$activeSheet->getStyle("A{$line}:J{$line}")->getFont()->getColor()->setRGB('111111');
		// Выравниваем строку по вертикали ( середина )
		$activeSheet->getStyle("A{$line}:J{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		// Выравнивание по горизонтали - центр
		$activeSheet->getStyle("A{$line}:E{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$activeSheet->getStyle("H{$line}:J{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		// Выравнивание по горизонтали - центр
		$activeSheet->getStyle("F{$line}:G{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$activeSheet->setCellValue("A{$line}", '3-4/' . $_DOCNUM . '-' . $_STAGENUM);
		$activeSheet->setCellValue("B{$line}", $_DOCDATE);
		$activeSheet->setCellValue("C{$line}", $_DOCNAME . ' / ' . $_STAGENAME);
		$activeSheet->setCellValue("D{$line}", $_DOCZAK);
		$activeSheet->setCellValue("E{$line}", $_DOCOBJ);
		$activeSheet->setCellValue("F{$line}", $_DOCTIP);
		$activeSheet->setCellValue("G{$line}", $_CHFNUMBER);
		$activeSheet->setCellValue("H{$line}", $_CHFDATE);
		$activeSheet->setCellValue("I{$line}", $_CHFSUMMA);
		$activeSheet->getStyle("I{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
		$activeSheet->setCellValue("J{$line}", $_CHFCOMM);
		// Оформляем границы
		$activeSheet->getStyle("A{$line}:J{$line}")->applyFromArray($_BORDER_INSIDE);
		$activeSheet->getStyle("A{$line}:J{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		// Суммируем счета по этапу
		$_SUM_ONSTAGE += $_CHFSUMMA;
		// Следующая строка
		$line++;
	}
	// Суммируем всего
	$_SUM_TOTAL += $_SUM_ONSTAGE;
}
// Задаем высоту строки и шрифт
$activeSheet->getRowDimension($line)->setRowHeight(22);
$activeSheet->getStyle("A{$line}:J{$line}")->getFont()->setSize(12);
$activeSheet->getStyle("A{$line}:J{$line}")->getFont()->setBold(true);
// Задаем цвет текста строки
$activeSheet->getStyle("A{$line}:J{$line}")->getFont()->getColor()->setRGB('111111');
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:H{$line}");
// Выравниваем строку по вертикали ( середина )
$activeSheet->getStyle("A{$line}:J{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Выравнивание по горизонтали - центр
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
// Выравнивание по горизонтали - центр
$activeSheet->getStyle("I{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->setCellValue("A{$line}", "ИТОГО: ");
$activeSheet->setCellValue("I{$line}", $_SUM_TOTAL);
$activeSheet->getStyle("I{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
// Оформляем границы
$activeSheet->getStyle("A{$line}:J{$line}")->applyFromArray($_BORDER_INSIDE);
$activeSheet->getStyle("A{$line}:J{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Возвращаемся на 1 строку
// 	$line = $line - 1;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
// Добавляем рамку к шапке таблицы
$activeSheet->getStyle("A{$start_table}:J{$start_table}")->applyFromArray($_BORDER_OUTSIDE_THIN);
// Добавляем рамку ко всей таблице
$activeSheet->getStyle("A{$start_table}:J{$line}")->applyFromArray($_BORDER_OUTSIDE_THIN);


// $objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());
$objPHPExcel->getActiveSheet()->setAutoFilter("A{$start_table}:J{$start_table}");
