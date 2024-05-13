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
$activeSheet->setTitle('Авансы по договорам');
#
// Колонтитулы
$activeSheet->getHeaderFooter()->setOddHeader('&L&G&B&АВАНСЫ ПО ВСЕМ ДОГОВОРАМ&R&G&B&12В интервале дат');
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
$_BORDER_TOP_THIN = array('borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))));
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
$activeSheet->getColumnDimension('B')->setWidth(120); // Название договора / этапа
$activeSheet->getColumnDimension('C')->setWidth(35); // Заказчик
$activeSheet->getColumnDimension('D')->setWidth(35); // Объект
$activeSheet->getColumnDimension('E')->setWidth(22); // Тип
$activeSheet->getColumnDimension('F')->setWidth(15); // Дата аванса
$activeSheet->getColumnDimension('G')->setWidth(25); // Сумма аванса
$activeSheet->getColumnDimension('H')->setWidth(25); // Остаток аванса
$activeSheet->getColumnDimension('I')->setWidth(50); // Примечание
#
// Для удобства заводим переменную $line, в ней будем считать номер строки
$line = 1;
#
# ----- ----- ----- ----- -----
# СТРОКА 1
# ----- ----- ----- ----- -----
// Выводим название отчета
$activeSheet->setCellValue("A{$line}", 'АВАНСЫ ПО ВСЕМ ДОГОВОРАМ С ' . date("d.m.Y", strtotime($start_date)) . ' ПО ' . date("d.m.Y", strtotime($end_date)));
// Задаем высоту строки
$activeSheet->getRowDimension($line)->setRowHeight(24);
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:I{$line}");
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
$activeSheet->mergeCells("A{$line}:I{$line}");
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
$activeSheet->mergeCells("A{$line}:I{$line}");
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
$activeSheet->setCellValue("B{$line}", 'НАИМЕНОВАНИЕ ДОГОВОРА / ЭТАПА');
$activeSheet->setCellValue("C{$line}", 'ЗАКАЗЧИК');
$activeSheet->setCellValue("D{$line}", 'ОБЪЕКТ');
$activeSheet->setCellValue("E{$line}", 'ТИП');
$activeSheet->setCellValue("F{$line}", 'ДАТА');
$activeSheet->setCellValue("G{$line}", 'СУММА (ВКЛ НДС)');
$activeSheet->setCellValue("H{$line}", 'ОСТАТОК');
$activeSheet->setCellValue("I{$line}", 'ПРИМЕЧАНИЕ');
// Стили для текста в шапки таблицы.
$activeSheet->getRowDimension($line)->setRowHeight(18); // высота строки
$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setSize(11); // размер шрифта
$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setBold(true); // делаем шрифт жирным
$activeSheet->getStyle("A{$line}:I{$line}")->getAlignment()->setWrapText(true); // разрешаем перенос строк в ячейке
$activeSheet->getStyle("A{$line}:I{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); // вырванивание по вертикали - середина
$activeSheet->getStyle("A{$line}:I{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); // выравнивание по горизонтали - лево
// Делаем заливку области ячеек
$activeSheet->getStyle("A{$line}:I{$line}")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$activeSheet->getStyle("A{$line}:I{$line}")->getFill()->getStartColor()->setRGB("31708F");
// Задаем цвет текста строки
$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->getColor()->setRGB('FFFFFF');
// Оформляем границы
$activeSheet->getStyle("A{$line}:I{$line}")->applyFromArray($_BORDER_INSIDE);
$activeSheet->getStyle("A{$line}:I{$line}")->applyFromArray($_BORDER_OUTSIDE_THICK);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
//
$_SUM_TOTAL_AV = 0.0;
$_SUM_TOTAL_OST = 0.0;
$_SUM_TOTAL_OPLAV = 0.0;
//
$_QRY_docavans = mysqlQuery("SELECT * FROM dognet_docavans WHERE koddel<>'99' AND (dateavans BETWEEN '" . $start_date . "' AND '" . $end_date . "') ORDER BY dateavans DESC");
while ($_ROW_docavans = mysqli_fetch_assoc($_QRY_docavans)) {
	//
	// Делаем выборку этапов по идентификатору этапа (kodkalplan)
	$_QRY_dockalplan = mysqlQuery("SELECT * FROM dognet_dockalplan WHERE koddel<>'99' AND kodkalplan = '" . $_ROW_docavans['koddoc'] . "' ");
	//
	$_SUM_STAGE_AV = 0.0;
	$_SUM_STAGE_OST = 0.0;
	$_SUM_STAGE_OPLAV = 0.0;
	while ($_ROW_dockalplan = mysqli_fetch_assoc($_QRY_dockalplan)) {
		//
		$DOCBASE = $db_handle->runQuery("SELECT * FROM dognet_docbase WHERE koddoc = '" . $_ROW_dockalplan['koddoc'] . "'");
		$DOCTIP = $db_handle->runQuery("SELECT nametip FROM dognet_sptipdog WHERE kodtip = '" . $DOCBASE[0]['kodtip'] . "'");
		$DOCOBJ = $db_handle->runQuery("SELECT nameobjectshot FROM sp_objects WHERE kodobject = '" . $DOCBASE[0]['kodobject'] . "'");
		$DOCZAK = $db_handle->runQuery("SELECT namezakshot FROM sp_contragents WHERE kodzakaz = '" . $DOCBASE[0]['kodzakaz'] . "'");
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		$_AVDATE = date("d.m.Y", strtotime($_ROW_docavans['dateavans']));
		$_AVSUMMA = $_ROW_docavans['summaavans'];
		$_AVOST = $_ROW_docavans['ostatokavans'];
		$_AVCOMM = $_ROW_docavans['comment'];
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
		$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setSize(10);
		$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setBold(false);
		// Задаем цвет текста строки
		$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->getColor()->setRGB('111111');
		// Выравниваем строку по вертикали ( середина )
		$activeSheet->getStyle("A{$line}:I{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		// Выравнивание по горизонтали - центр
		$activeSheet->getStyle("A{$line}:E{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		// Выравнивание по горизонтали - центр
		$activeSheet->getStyle("F{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$activeSheet->getStyle("G{$line}:H{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		// Выравнивание по горизонтали - cktdf
		$activeSheet->getStyle("I{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$activeSheet->setCellValue("A{$line}", '3-4/' . $_DOCNUM . '-' . $_STAGENUM);
		$activeSheet->setCellValue("B{$line}", $_DOCNAME . ' / ' . $_STAGENAME);
		$activeSheet->setCellValue("C{$line}", $_DOCZAK);
		$activeSheet->setCellValue("D{$line}", $_DOCOBJ);
		$activeSheet->setCellValue("E{$line}", $_DOCTIP);
		$activeSheet->setCellValue("F{$line}", $_AVDATE);
		$activeSheet->setCellValue("G{$line}", $_AVSUMMA);
		$activeSheet->getStyle("G{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
		$activeSheet->setCellValue("H{$line}", $_AVOST);
		$activeSheet->getStyle("H{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
		$activeSheet->setCellValue("I{$line}", $_AVCOMM);
		// Оформляем границы
		$activeSheet->getStyle("A{$line}:I{$line}")->applyFromArray($_BORDER_INSIDE);
		$activeSheet->getStyle("A{$line}:I{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		// Следующая строка
		$line++;
		//
		$_QRY_chfavans = mysqlQuery("SELECT * FROM dognet_chfavans WHERE koddel<>'99' AND kodavans = '" . $_ROW_docavans['kodavans'] . "'");
		//
		$_SUM_AVANS_OPLAV = 0.0;
		//
		while ($_ROW_chfavans = mysqli_fetch_assoc($_QRY_chfavans)) {
			$_OPLAVDATE = ($_ROW_chfavans['dateoplav'] != NULL || $_ROW_chfavans['dateoplav'] != '') ? date("d.m.Y", strtotime($_ROW_chfavans['dateoplav'])) : '---';
			$_OPLAVSUMMA = $_ROW_chfavans['summaoplav'];
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			// Задаем высоту строки и шрифт
			$activeSheet->getRowDimension($line)->setRowHeight(18);
			$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setSize(10);
			$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setBold(true);
			// Задаем цвет текста строки
			$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->getColor()->setRGB('111111');
			// Объединяем ячейки по горизонтали
			$activeSheet->mergeCells("A{$line}:D{$line}");
			// Выравниваем строку по вертикали ( середина )
			$activeSheet->getStyle("A{$line}:I{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			// Выравнивание по горизонтали - справа
			$activeSheet->getStyle("E{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$activeSheet->setCellValue("E{$line}", 'ЗАЧТЕНО ');
			// Выравнивание по горизонтали - центр
			$activeSheet->getStyle("F{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$activeSheet->setCellValue("F{$line}", $_OPLAVDATE);
			// Выравнивание по горизонтали - слева
			$activeSheet->getStyle("G{$line}:I{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$activeSheet->setCellValue("G{$line}", $_OPLAVSUMMA);
			$activeSheet->getStyle("G{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
			$activeSheet->setCellValue("H{$line}", "");
			$activeSheet->setCellValue("I{$line}", "");
			// Оформляем границы
			// 				$activeSheet->getStyle("A{$line}:I{$line}")->applyFromArray($_BORDER_INSIDE);
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			// Суммируем счета по этапу
			$_SUM_AVANS_OPLAV += $_OPLAVSUMMA;
			// Следующая строка
			$line++;
		}
		$activeSheet->getStyle("A{$line}:I{$line}")->applyFromArray($_BORDER_TOP_THIN);
		// Суммируем счета по этапу
		$_SUM_STAGE_AV += $_AVSUMMA;
		$_SUM_STAGE_OST += $_AVOST;
		$_SUM_STAGE_OPLAV += $_SUM_AVANS_OPLAV;
	}
	// Суммируем всего
	$_SUM_TOTAL_AV += $_SUM_STAGE_AV;
	$_SUM_TOTAL_OST += $_SUM_STAGE_OST;
	$_SUM_TOTAL_OPLAV += $_SUM_STAGE_OPLAV;
}
// Задаем высоту строки и шрифт
$activeSheet->getRowDimension($line)->setRowHeight(22);
$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setSize(12);
$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setBold(true);
// Задаем цвет текста строки
$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->getColor()->setRGB('111111');
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:F{$line}");
// Выравниваем строку по вертикали ( середина )
$activeSheet->getStyle("A{$line}:I{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Выравнивание по горизонтали - справа
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
// Выравнивание по горизонтали - слева
$activeSheet->getStyle("H{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$activeSheet->setCellValue("A{$line}", "ИТОГО ПОЛУЧЕНО / ОСТАТОК");
$activeSheet->setCellValue("G{$line}", $_SUM_TOTAL_AV);
$activeSheet->getStyle("G{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
$activeSheet->setCellValue("H{$line}", $_SUM_TOTAL_OST);
$activeSheet->getStyle("H{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
// Оформляем границы
$activeSheet->getStyle("A{$line}:I{$line}")->applyFromArray($_BORDER_INSIDE);
$activeSheet->getStyle("A{$line}:I{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Следующая строка
$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Задаем высоту строки и шрифт
$activeSheet->getRowDimension($line)->setRowHeight(22);
$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setSize(12);
$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setBold(true);
// Задаем цвет текста строки
$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->getColor()->setRGB('111111');
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:F{$line}");
// Выравниваем строку по вертикали ( середина )
$activeSheet->getStyle("A{$line}:I{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Выравнивание по горизонтали - справа
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
// Выравнивание по горизонтали - слева
$activeSheet->getStyle("G{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$activeSheet->setCellValue("A{$line}", "ИТОГО ЗАЧТЕНО");
$activeSheet->setCellValue("G{$line}", $_SUM_TOTAL_OPLAV);
$activeSheet->getStyle("G{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
$activeSheet->setCellValue("H{$line}", "");
// Оформляем границы
$activeSheet->getStyle("A{$line}:I{$line}")->applyFromArray($_BORDER_INSIDE);
$activeSheet->getStyle("A{$line}:I{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Возвращаемся на 1 строку
// 	$line = $line - 1;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
// Добавляем рамку к шапке таблицы
$activeSheet->getStyle("A{$start_table}:I{$start_table}")->applyFromArray($_BORDER_OUTSIDE_THIN);
// Добавляем рамку ко всей таблице
$activeSheet->getStyle("A{$start_table}:I{$line}")->applyFromArray($_BORDER_OUTSIDE_THIN);


// $objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());
$objPHPExcel->getActiveSheet()->setAutoFilter("A{$start_table}:I{$start_table}");
