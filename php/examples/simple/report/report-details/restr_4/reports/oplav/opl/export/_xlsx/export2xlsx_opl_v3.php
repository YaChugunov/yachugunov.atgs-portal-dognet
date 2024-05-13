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
$objCalc = PHPExcel_Calculation::getInstance();
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
$activeSheet->setTitle('Оплаты по договорам');
#
// Колонтитулы
$activeSheet->getHeaderFooter()->setOddHeader('&L&G&B&ОПЛАТЫ ПО ВСЕМ ДОГОВОРАМ&R&G&B&12В интервале дат');
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
$activeSheet->getColumnDimension('A')->setWidth(12);	// Номер договора - этапа
$activeSheet->getColumnDimension('B')->setWidth(8);		// Этап
$activeSheet->getColumnDimension('C')->setWidth(90);	// Название договора / этапа
$activeSheet->getColumnDimension('D')->setWidth(35);	// Заказчик
$activeSheet->getColumnDimension('E')->setWidth(35);	// Объект
$activeSheet->getColumnDimension('F')->setWidth(22);	// Тип
$activeSheet->getColumnDimension('G')->setWidth(12);	// № СФ
$activeSheet->getColumnDimension('H')->setWidth(15);	// Дата СФ / оплаты
$activeSheet->getColumnDimension('I')->setWidth(20);	// Сумма СФ
$activeSheet->getColumnDimension('J')->setWidth(20);	// Сумма оплаты
$activeSheet->getColumnDimension('K')->setWidth(35);	// Примечание
#
// Для удобства заводим переменную $line, в ней будем считать номер строки
$line = 1;
#
# ----- ----- ----- ----- -----
# СТРОКА 1
# ----- ----- ----- ----- -----
// Выводим название отчета
$activeSheet->setCellValue("A{$line}", 'ОПЛАТЫ ПО ВСЕМ ДОГОВОРАМ С ' . date("d.m.Y", strtotime($start_date)) . ' ПО ' . date("d.m.Y", strtotime($end_date)));
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
# СТРОКА 4
# ----- ----- ----- ----- -----
// Пропускаем строку
$line++;
$activeSheet->setCellValue("A{$line}", '');
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
$line++;
$start_table = $line;
// Шапка таблицы
$activeSheet->setCellValue("A{$line}", 'Договор');
$activeSheet->setCellValue("B{$line}", 'Этап');
$activeSheet->setCellValue("C{$line}", 'Наименование договора / этапа');
$activeSheet->setCellValue("D{$line}", 'Заказчик');
$activeSheet->setCellValue("E{$line}", 'Объект');
$activeSheet->setCellValue("F{$line}", 'Тип');
$activeSheet->setCellValue("G{$line}", 'СФ №');
$activeSheet->setCellValue("H{$line}", 'Дата');
$activeSheet->setCellValue("I{$line}", 'Сумма СФ');
$activeSheet->setCellValue("J{$line}", 'Сумма оплаты');
$activeSheet->setCellValue("K{$line}", 'Примечание');
// Стили для текста в шапки таблицы.
$activeSheet->getRowDimension($line)->setRowHeight(18); // высота строки
$activeSheet->getStyle("A{$line}:K{$line}")->getFont()->setSize(11); // размер шрифта
$activeSheet->getStyle("A{$line}:K{$line}")->getFont()->setBold(true); // делаем шрифт жирным
$activeSheet->getStyle("A{$line}:K{$line}")->getAlignment()->setWrapText(true); // разрешаем перенос строк в ячейке
$activeSheet->getStyle("A{$line}:K{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); // вырванивание по вертикали - середина
$activeSheet->getStyle("A{$line}:K{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); // выравнивание по горизонтали - лево
// Делаем заливку области ячеек
$activeSheet->getStyle("A{$line}:K{$line}")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$activeSheet->getStyle("A{$line}:K{$line}")->getFill()->getStartColor()->setRGB("31708F");
// Задаем цвет текста строки
$activeSheet->getStyle("A{$line}:K{$line}")->getFont()->getColor()->setRGB('FFFFFF');
// Оформляем границы
$activeSheet->getStyle("A{$line}:K{$line}")->applyFromArray($_BORDER_INSIDE);
$activeSheet->getStyle("A{$line}:K{$line}")->applyFromArray($_BORDER_OUTSIDE_THICK);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
$line++;
$itogStart = $line;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
// $activeSheet->getStyle("C{$line}:C" . $activeSheet->getHighestRow())->getAlignment()->setWrapText(true);
#
//
$_QRY_oplatachf = mysqlQuery("SELECT * FROM dognet_oplatachf WHERE koddel<>'99' AND (dateopl BETWEEN '" . $start_date . "' AND '" . $end_date . "') GROUP BY kodkalplan ORDER BY kodkalplan, dateopl DESC");
$_SUM_TOTAL = 0.0;
//
while ($_ROW_oplatachf = mysqli_fetch_assoc($_QRY_oplatachf)) {
	$_QRY_kalplanchf = mysqlQuery("SELECT * FROM dognet_kalplanchf WHERE koddel<>'99' AND kodchfact = '" . $_ROW_oplatachf['kodchfact'] . "'");
	$_SUM_ONCHF = 0.0;
	//
	while ($_ROW_kalplanchf = mysqli_fetch_assoc($_QRY_kalplanchf)) {
		// Делаем выборку этапов по идентификатору этапа (kodkalplan)
		$_QRY_dockalplan = mysqlQuery("SELECT * FROM dognet_dockalplan WHERE koddel<>'99' AND kodkalplan = " . $_ROW_kalplanchf['kodkalplan']);
		$_SUM_ONSTAGE = 0.0;
		//
		while ($_ROW_dockalplan = mysqli_fetch_assoc($_QRY_dockalplan)) {

			$DOCBASE = $db_handle->runQuery("SELECT * FROM dognet_docbase WHERE koddoc = '" . $_ROW_dockalplan['koddoc'] . "'");
			$DOCTIP = $db_handle->runQuery("SELECT nametip FROM dognet_sptipdog WHERE kodtip = '" . $DOCBASE[0]['kodtip'] . "'");
			$DOCOBJ = $db_handle->runQuery("SELECT nameobjectshot FROM sp_objects WHERE kodobject = '" . $DOCBASE[0]['kodobject'] . "'");
			$DOCZAK = $db_handle->runQuery("SELECT nameshort FROM sp_contragents WHERE kodcontragent = '" . $DOCBASE[0]['kodzakaz'] . "'");
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			$_CHFDATE = date("d.m.Y", strtotime($_ROW_kalplanchf['chetfdate']));
			$_CHFNUMBER = $_ROW_kalplanchf['chetfnumber'];
			$_CHFSUMMA = $_ROW_kalplanchf['chetfsumma'];
			$_CHFCOMM = $_ROW_kalplanchf['comment'];
			$_DOCTIP = $DOCTIP[0]['nametip'];
			$_DOCOBJ = $DOCOBJ[0]['nameobjectshot'];
			$_DOCZAK = $DOCZAK[0]['nameshort'];
			$_DOCNAME = $DOCBASE[0]['docnameshot'];
			$_DOCNUM = $DOCBASE[0]['docnumber'];
			$_STAGENAME = $_ROW_dockalplan['nameshotstage'];
			$_STAGENUM = $_ROW_dockalplan['numberstage'];
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			// Задаем высоту строки и шрифт
			$activeSheet->getRowDimension($line)->setRowHeight(-1);
			$activeSheet->getStyle("A{$line}:K{$line}")->getFont()->setSize(10);
			$activeSheet->getStyle("A{$line}:K{$line}")->getFont()->setBold(false);
			// Задаем цвет текста строки
			$activeSheet->getStyle("A{$line}:K{$line}")->getFont()->getColor()->setRGB('111111');
			// Выравниваем строку по вертикали ( середина )
			$activeSheet->getStyle("A{$line}:K{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			// Выравнивание по горизонтали - слева
			$activeSheet->getStyle("A{$line}:G{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			// Выравнивание по горизонтали - центр
			$activeSheet->getStyle("H{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			// Выравнивание по горизонтали - cktdf
			$activeSheet->getStyle("K{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$activeSheet->setCellValue("A{$line}", '3-4/' . $_DOCNUM);
			$activeSheet->setCellValue("B{$line}", $_STAGENUM);
			$activeSheet->getStyle("C{$line}")->getAlignment()->setWrapText(true);
			$activeSheet->setCellValue("C{$line}", $_DOCNAME . ' / ' . $_STAGENAME);
			$activeSheet->setCellValue("D{$line}", $_DOCZAK);
			$activeSheet->setCellValue("E{$line}", $_DOCOBJ);
			$activeSheet->setCellValue("F{$line}", $_DOCTIP);
			$activeSheet->setCellValue("G{$line}", $_CHFNUMBER);
			$activeSheet->setCellValue("H{$line}", $_CHFDATE);
			$activeSheet->setCellValue("I{$line}", $_CHFSUMMA);
			$activeSheet->getStyle("I{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
			// Выравнивание по горизонтали - справа
			$activeSheet->getStyle("I{$line}:J{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			// Выравнивание по горизонтали - слева
			$activeSheet->getStyle("K{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$activeSheet->setCellValue("K{$line}", $_CHFCOMM);
			// Оформляем границы
			$activeSheet->getStyle("A{$line}:K{$line}")->applyFromArray($_BORDER_INSIDE);
			$activeSheet->getStyle("A{$line}:K{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			// Суммируем счета по этапу
			// 			$_SUM_ONSTAGE += $_CHFSUMMA;
			// Следующая строка
			$line++;
			//
			$_OPLDATE = date("d.m.Y", strtotime($_ROW_oplatachf['dateopl']));
			$_OPLSUMMA = $_ROW_oplatachf['summaopl'];
			$_OPLCOMM = $_ROW_oplatachf['comment'];
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			// Задаем высоту строки и шрифт
			$activeSheet->getRowDimension($line)->setRowHeight(-1);
			$activeSheet->getStyle("A{$line}:K{$line}")->getFont()->setSize(10);
			$activeSheet->getStyle("G{$line}:J{$line}")->getFont()->setBold(true);
			// Задаем цвет текста строки
			$activeSheet->getStyle("A{$line}:F{$line}")->getFont()->getColor()->setRGB('FFFFFF');
			$activeSheet->getStyle("G{$line}:K{$line}")->getFont()->getColor()->setRGB('111111');
			// Объединяем ячейки по горизонтали
			// $activeSheet->mergeCells("A{$line}:H{$line}");
			// Выравниваем строку по вертикали ( середина )
			$activeSheet->getStyle("A{$line}:K{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			// Выравнивание по горизонтали - справа
			$activeSheet->getStyle("H{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$activeSheet->setCellValue("H{$line}", 'Оплата');
			// Выравнивание по горизонтали - центр
			$activeSheet->getStyle("H{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$activeSheet->setCellValue("A{$line}", '3-4/' . $_DOCNUM);
			$activeSheet->setCellValue("B{$line}", $_STAGENUM);
			$activeSheet->setCellValue("C{$line}", $_DOCNAME . ' / ' . $_STAGENAME);
			$activeSheet->setCellValue("D{$line}", $_DOCZAK);
			$activeSheet->setCellValue("E{$line}", $_DOCOBJ);
			$activeSheet->setCellValue("F{$line}", $_DOCTIP);
			$activeSheet->setCellValue("G{$line}", "Оплата");
			$activeSheet->setCellValue("H{$line}", $_OPLDATE);
			$activeSheet->setCellValue("J{$line}", $_OPLSUMMA);
			$activeSheet->getStyle("J{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
			// Выравнивание по горизонтали - справа
			$activeSheet->getStyle("I{$line}:J{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			// Выравнивание по горизонтали - слева
			$activeSheet->getStyle("K{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$activeSheet->setCellValue("K{$line}", $_OPLCOMM);
			// Оформляем границы
			// 				$activeSheet->getStyle("A{$line}:K{$line}")->applyFromArray($_BORDER_INSIDE);
			$activeSheet->getStyle("A{$line}:K{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			// Суммируем счета по этапу
			$_SUM_ONSTAGE += $_OPLSUMMA;

			$itogEnd = $line;
			// Следующая строка
			$line++;
		}
		// Суммируем всего
		$_SUM_ONCHF += $_SUM_ONSTAGE;
	}
	// Суммируем всего
	$_SUM_TOTAL += $_SUM_ONCHF;
}
// Задаем высоту строки и шрифт
$activeSheet->getRowDimension($line)->setRowHeight(22);
$activeSheet->getStyle("A{$line}:K{$line}")->getFont()->setSize(12);
$activeSheet->getStyle("A{$line}:K{$line}")->getFont()->setBold(true);
// Задаем цвет текста строки
$activeSheet->getStyle("A{$line}:K{$line}")->getFont()->getColor()->setRGB('111111');
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:I{$line}");
// Выравниваем строку по вертикали ( середина )
$activeSheet->getStyle("A{$line}:K{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Выравнивание по горизонтали - справа
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
// Выравнивание по горизонтали - слева
$activeSheet->getStyle("H{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->setCellValue("A{$line}", "Итого оплат (используется формула промежуточных итогов Excel, автоматические пересчет при фильтрации): ");
//$activeSheet->setCellValueExplicit("J{$line}", "=ПРОМЕЖУТОЧНЫЕ.ИТОГИ(109,J{$itogStart}:J{$itogEnd})");
$activeSheet->setCellValueExplicit("J{$line}", "=ПРОМЕЖУТОЧНЫЕ.ИТОГИ(109,J{$itogStart}:J{$itogEnd})", PHPExcel_Cell_DataType::TYPE_FORMULA);
//$activeSheet->getCell("J{$line}")->getCalculatedValue();
try {
	$value = $activeSheet->getCell("J{$line}")->getCalculatedValue();
	echo "Результат вычисления: " . $value;
} catch (Exception $e) {
	echo "Ошибка вычисления формулы: " . $e->getMessage();
}
$activeSheet->getStyle("J{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
// Оформляем границы
$activeSheet->getStyle("A{$line}:K{$line}")->applyFromArray($_BORDER_INSIDE);
$activeSheet->getStyle("A{$line}:K{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
// $line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
// Задаем высоту строки и шрифт
// $activeSheet->getRowDimension($line)->setRowHeight(22);
// $activeSheet->getStyle("A{$line}:K{$line}")->getFont()->setSize(12);
// $activeSheet->getStyle("A{$line}:K{$line}")->getFont()->setBold(true);
// // Задаем цвет текста строки
// $activeSheet->getStyle("A{$line}:K{$line}")->getFont()->getColor()->setRGB('111111');
// // Объединяем ячейки по горизонтали
// $activeSheet->mergeCells("A{$line}:H{$line}");
// // Выравниваем строку по вертикали ( середина )
// $activeSheet->getStyle("A{$line}:K{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// // Выравнивание по горизонтали - справа
// $activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
// // Выравнивание по горизонтали - слева
// $activeSheet->getStyle("H{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
// $activeSheet->setCellValue("A{$line}", "Расчет и вывод через скрипт отчета: ");
// $activeSheet->setCellValue("J{$line}", $_SUM_TOTAL);
// $activeSheet->getStyle("J{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
// // Оформляем границы
// $activeSheet->getStyle("A{$line}:K{$line}")->applyFromArray($_BORDER_INSIDE);
// $activeSheet->getStyle("A{$line}:K{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);


#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Возвращаемся на 1 строку
// 	$line = $line - 1;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
// Добавляем рамку к шапке таблицы
$activeSheet->getStyle("A{$start_table}:K{$start_table}")->applyFromArray($_BORDER_OUTSIDE_THIN);
// Добавляем рамку ко всей таблице
$activeSheet->getStyle("A{$start_table}:K{$line}")->applyFromArray($_BORDER_OUTSIDE_THIN);


// $objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());
$objPHPExcel->getActiveSheet()->setAutoFilter("A{$start_table}:K{$start_table}");
