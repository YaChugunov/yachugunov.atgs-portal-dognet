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
$activeSheet->getHeaderFooter()->setOddHeader('&L&G&B&12ПРОСРОЧЕННЫЕ ДОГОВОРА ПОСТАВКИ&R&G&B&12На дату');
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
$on_date = date("Y-m-d", strtotime($_GET['on_date']));
$shtraf = $_GET['shtraf'];
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# ФОРМАТИРУЕМ ВЫХОДНУЮ ТАБЛИЦУ EXCEL
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
// Задаем ширины столбцов
$activeSheet->getColumnDimension('A')->setWidth(15); // Номер договора
$activeSheet->getColumnDimension('B')->setWidth(8); // Номер этапа
$activeSheet->getColumnDimension('C')->setWidth(85); // Название договора / этапа
$activeSheet->getColumnDimension('D')->setWidth(25); // Заказчик
$activeSheet->getColumnDimension('E')->setWidth(15); // Статус
$activeSheet->getColumnDimension('F')->setWidth(18); // (Сумма этапа - Сумма СФ)
$activeSheet->getColumnDimension('G')->setWidth(12); // Срок выполнения
$activeSheet->getColumnDimension('H')->setWidth(17); // Просрочка
$activeSheet->getColumnDimension('I')->setWidth(18); // Штраф
#
// Для удобства заводим переменную $line, в ней будем считать номер строки
$line = 1;
#
# ----- ----- ----- ----- -----
# СТРОКА 1
# ----- ----- ----- ----- -----
// Выводим название отчета
$activeSheet->setCellValue("A{$line}", 'Договора поставки с истёкшими сроками выполнения на ' . date("d.m.Y", strtotime($on_date)));
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
// Задаем высоту строки
$activeSheet->getRowDimension($line)->setRowHeight(20);
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:B{$line}");
$activeSheet->mergeCells("C{$line}:I{$line}");
// Делаем выравнивание по центру вертикали и горизонтали
$activeSheet->getStyle("A{$line}:I{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("A{$line}:I{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Делаем текст жирным и увеличиваем шрифт.
$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setBold(true);
$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setSize(13);
// Выводим название отчета
$activeSheet->setCellValue("A{$line}", 'Дата отчета:');
$activeSheet->setCellValue("C{$line}", date("d.m.Y H:i:s"));
#
# ----- ----- ----- ----- -----
# СТРОКА 3
# ----- ----- ----- ----- -----
$line++;
// Задаем высоту строки
$activeSheet->getRowDimension($line)->setRowHeight(20);
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:B{$line}");
$activeSheet->mergeCells("C{$line}:I{$line}");
// Делаем выравнивание по центру вертикали и горизонтали
$activeSheet->getStyle("A{$line}:I{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("A{$line}:I{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Делаем текст жирным и увеличиваем шрифт.
$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setBold(true);
$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setSize(13);
// Выводим название отчета
$activeSheet->setCellValue("A{$line}", "Отчет составлен:");
$activeSheet->setCellValue("C{$line}", $_SESSION['lastname'] . " " . $_SESSION['firstname'] . " " . $_SESSION['middlename']);
#
# ----- ----- ----- ----- -----
# СТРОКА 4
# ----- ----- ----- ----- -----
$line++;
// Задаем высоту строки
$activeSheet->getRowDimension($line)->setRowHeight(20);
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:B{$line}");
$activeSheet->mergeCells("C{$line}:I{$line}");
// Делаем выравнивание по центру вертикали и горизонтали
$activeSheet->getStyle("A{$line}:I{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("A{$line}:I{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Делаем текст жирным и увеличиваем шрифт.
$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setBold(true);
$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setSize(13);
// Выводим название отчета
$activeSheet->setCellValue("A{$line}", "Пенни, %");
$activeSheet->setCellValue("C{$line}", $shtraf);
#
# ----- ----- ----- ----- -----
# СТРОКА 5
# ----- ----- ----- ----- -----
// Пропускаем строку
$line++;
$activeSheet->setCellValue("A{$line}", '');
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
$line++;
$start_table = $line;
// Шапка таблицы
$activeSheet->setCellValue("A{$line}", 'ДОГОВОР');
$activeSheet->setCellValue("B{$line}", 'ЭТАП');
$activeSheet->setCellValue("C{$line}", 'НАЗВАНИЕ ДОГОВОРА / ЭТАПА');
$activeSheet->setCellValue("D{$line}", 'ЗАКАЗЧИК');
$activeSheet->setCellValue("E{$line}", 'СТАТУС');
$activeSheet->setCellValue("F{$line}", 'СУММА - СФ');
$activeSheet->setCellValue("G{$line}", 'СРОК');
$activeSheet->setCellValue("H{$line}", 'ПРОСРОЧКА');
$activeSheet->setCellValue("I{$line}", 'ШТРАФ');
// Стили для текста в шапки таблицы.
$activeSheet->getRowDimension($line)->setRowHeight(36); // высота строки
$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setSize(12); // размер шрифта
$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setBold(true); // делаем шрифт жирным
$activeSheet->getStyle("A{$line}:I{$line}")->getAlignment()->setWrapText(true); // разрешаем перенос строк в ячейке
// Выравнивание по вертикали
$activeSheet->getStyle("A{$line}:I{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Выравнивание по горизонтали
$activeSheet->getStyle("A{$line}:B{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$activeSheet->getStyle("C{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("D{$line}:I{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
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
// Делаем выборку этапов по идентификатору этапа (kodkalplan)
$_QRY_MAIN = mysqlQuery("SELECT koddoc as koddoc, kodkalplan as kodkalplan, summastage as summastage, srokstage_date as srokstage_date, '1' as kodshab 
FROM dognet_dockalplan_progress WHERE srokstage_date <= '{$on_date}' AND srokstage_date != '0000-00-00' AND srokstage_date != 'NULL' AND srokstage_date != '' AND zadolsum_stage > 0 AND koddoc IN (SELECT koddoc FROM dognet_docbase WHERE (kodstatus='245381842747296' OR kodstatus='245597345680479' OR kodstatus='245267756667430' OR kodstatus='245381842145343') AND (kodtip='245287841608965' OR kodtip='245287841599652') AND koddel<>'99') 
UNION 
SELECT koddoc as koddoc, koddoc as kodkalplan, docsumma as summastage, STR_TO_DATE(CONCAT(yearenddoc,'-',monthenddoc,'-',dayenddoc), '%Y-%m-%d') as srokstage_date, kodshab as kodshab FROM dognet_docbase WHERE STR_TO_DATE(CONCAT(yearenddoc,'-',monthenddoc,'-',dayenddoc), '%Y-%m-%d') <= '{$on_date}' AND (kodstatus='') AND (yearenddoc<>'0' AND monthenddoc<>'0' AND dayenddoc<>'0') AND (kodtip='245287841608965' OR kodtip='245287841599652') AND numberchet<>'' AND kodshab='0' AND koddel<>'99' 
ORDER BY koddoc DESC");
$_SUM_SHTRAF = 0.0;
$_SUM_ONSTAGE = 0.0;
//
while ($_ROW_MAIN = mysqli_fetch_assoc($_QRY_MAIN)) {
	$_DOCSHAB = $_ROW_MAIN['kodshab'];
	$DOCBASE = $db_handle->runQuery("SELECT * FROM dognet_docbase WHERE koddoc = '" . $_ROW_MAIN['koddoc'] . "'");
	if ($_DOCSHAB <> '0') {
		$STAGE = $db_handle->runQuery("SELECT numberstage, nameshotstage FROM dognet_dockalplan WHERE kodkalplan = '" . $_ROW_MAIN['kodkalplan'] . "'");
		$DOCSTS = $db_handle->runQuery("SELECT statusnameshot FROM dognet_spstatus WHERE kodstatus = '" . $DOCBASE[0]['kodstatus'] . "'");
		$DOCZAK = $db_handle->runQuery("SELECT nameshort FROM sp_contragents WHERE kodcontragent = '" . $DOCBASE[0]['kodzakaz'] . "'");

		$SUMCHFONDATE = $db_handle->runQuery("SELECT SUM(chetfsumma) as sumchfondate FROM dognet_kalplanchf WHERE kodkalplan = '" . $_ROW_MAIN['kodkalplan'] . "' AND chetfdate <= '" . $on_date . "'");

		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		$_DOCSTS = $DOCSTS[0]['statusnameshot'];
		$_DOCZAK = $DOCZAK[0]['nameshort'];
		$_DOCNAME = $DOCBASE[0]['docnameshot'];
		$_DOCNUM = "3-4/" . $DOCBASE[0]['docnumber'];
		$_STAGENAME = " / " . $STAGE[0]['nameshotstage'];
		$_STAGENUM = $STAGE[0]['numberstage'];
		$_SUMSTAGE = $_ROW_MAIN['summastage'];
		$_SROKSTAGE = $_ROW_MAIN['srokstage_date'];

		$_SUMCHFONDATE = $SUMCHFONDATE[0]['sumchfondate'];

		$datesrok = new DateTime($_ROW_MAIN['srokstage_date']);
		$datenow = new DateTime($on_date);
		$diff = $datesrok->diff($datenow)->format('%a');

		$_PROSRO4KA = $diff;
		$_SUMSHTRAF = $_SUMSTAGE * $_PROSRO4KA * $shtraf / 100;
	} else {
		$DOCZAK = $db_handle->runQuery("SELECT nameshort FROM sp_contragents WHERE kodcontragent = '" . $DOCBASE[0]['kodzakaz'] . "'");

		$SUMCHFONDATE = $db_handle->runQuery("SELECT SUM(chetfsumma) as sumchfondate FROM dognet_kalplanchf WHERE kodkalplan = '" . $_ROW_MAIN['koddoc'] . "' AND chetfdate <= '" . $on_date . "'");

		$_DOCSTS = "Без статуса";
		$_DOCZAK = $DOCZAK[0]['nameshort'];
		$_DOCNAME = $DOCBASE[0]['docnameshot'];
		$_DOCNUM = $DOCBASE[0]['numberchet'];
		$_STAGENAME = "";
		$_STAGENUM = "Счёт";
		$_SUMSTAGE = $DOCBASE[0]['docsumma'];
		$_SROKSTAGE = $DOCBASE[0]['yearenddoc'] . "-" . $DOCBASE[0]['monthenddoc'] . "-" . $DOCBASE[0]['dayenddoc'];

		$_SUMCHFONDATE = $SUMCHFONDATE[0]['sumchfondate'];

		// $datesrok = new DateTime($_SROKSTAGE);
		$datesrok = new DateTime($_ROW_MAIN['srokstage_date']);
		$datenow = new DateTime($on_date);
		$diff = $datesrok->diff($datenow)->format('%a');

		$_PROSRO4KA = $diff;
		$_SUMSHTRAF = $_SUMSTAGE * $_PROSRO4KA * $shtraf / 100;
	}
	# UPD 11.03.2024 >>>
	# Если разница  суммы этапа (договора) и суммы счетов-фактур по нему не равна нулю, то выводим строки
	if ($_DOCSHAB != 0 || ($_DOCSHAB == 0 && ($_SUMSTAGE - $_SUMCHFONDATE > 0))) {
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		// Задаем высоту строки и шрифт
		$activeSheet->getRowDimension($line)->setRowHeight(-1);
		$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setSize(10);
		$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setBold(false);
		// Задаем цвет текста строки
		$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->getColor()->setRGB('111111');
		// Выравниваем строку по вертикали ( середина )
		$activeSheet->getStyle("A{$line}:I{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		// Выравнивание по горизонтали
		$activeSheet->getStyle("A{$line}:B{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$activeSheet->getStyle("C{$line}")->getAlignment()->setWrapText(true)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$activeSheet->getStyle("D{$line}:I{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$activeSheet->setCellValue("A{$line}", $_DOCNUM);
		$activeSheet->setCellValue("B{$line}", $_STAGENUM);
		$activeSheet->setCellValue("C{$line}", $_DOCNAME . $_STAGENAME);
		$activeSheet->setCellValue("D{$line}", $_DOCZAK);
		$activeSheet->setCellValue("E{$line}", $_DOCSTS);
		$activeSheet->setCellValue("F{$line}", $_SUMSTAGE - $_SUMCHFONDATE);
		$activeSheet->getStyle("F{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
		$activeSheet->setCellValue("G{$line}", date("d.m.Y", strtotime($_SROKSTAGE)));
		$activeSheet->setCellValue("H{$line}", $_PROSRO4KA);
		$activeSheet->setCellValue("I{$line}", $_SUMSHTRAF);
		$activeSheet->getStyle("I{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
		// Оформляем границы
		$activeSheet->getStyle("A{$line}:I{$line}")->applyFromArray($_BORDER_INSIDE);
		$activeSheet->getStyle("A{$line}:I{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		// Суммируем счета по этапу
		$_SUM_ONSTAGE += $_SUMSHTRAF;
		// Следующая строка
		$line++;
	}
}
// Суммируем всего
$_SUM_SHTRAF += $_SUM_ONSTAGE;
// Задаем высоту строки и шрифт
$activeSheet->getRowDimension($line)->setRowHeight(32);
$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setSize(13);
$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setBold(true);
// Делаем заливку области ячеек
$activeSheet->getStyle("A{$line}:I{$line}")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$activeSheet->getStyle("A{$line}:I{$line}")->getFill()->getStartColor()->setRGB("F1F1F1");
// Задаем цвет текста строки
$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->getColor()->setRGB('111111');
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:H{$line}");
// Выравниваем строку по вертикали ( середина )
$activeSheet->getStyle("A{$line}:I{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Выравнивание по горизонтали - центр
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
// Выравнивание по горизонтали - центр
$activeSheet->getStyle("I{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$activeSheet->setCellValue("A{$line}", "ИТОГО");
$activeSheet->setCellValue("I{$line}", $_SUM_SHTRAF);
$activeSheet->getStyle("I{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
// Оформляем границы
// 	$activeSheet->getStyle("A{$line}:I{$line}")->applyFromArray($_BORDER_INSIDE);
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
// $objPHPExcel->getActiveSheet()->setAutoFilter("A{$start_table}:I{$start_table}");