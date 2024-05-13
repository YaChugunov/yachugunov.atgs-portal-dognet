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
$activeSheet->setTitle('Просроченные договора');
#
// Колонтитулы
$activeSheet->getHeaderFooter()->setOddHeader('&L&G&B&12ПРОСРОЧЕННЫЕ ДОГОВОРА&R&G&B&12За выбранный год');
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
// $on_date = date("Y-m-d", strtotime($_GET['on_date']));
$on_date = $_GET['on_date'];
// $shtraf = $_GET['shtraf'];
$shtraf = "";
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# ФОРМАТИРУЕМ ВЫХОДНУЮ ТАБЛИЦУ EXCEL
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
// Задаем ширины столбцов
$activeSheet->getColumnDimension('A')->setWidth(12); // Номер договора
$activeSheet->getColumnDimension('B')->setWidth(12); // Дата договора
$activeSheet->getColumnDimension('C')->setWidth(8); // Номер этапа
$activeSheet->getColumnDimension('D')->setWidth(90); // Название договора / этапа
$activeSheet->getColumnDimension('E')->setWidth(21); // Тип
$activeSheet->getColumnDimension('F')->setWidth(33); // Заказчик
$activeSheet->getColumnDimension('G')->setWidth(35); // Объект
$activeSheet->getColumnDimension('H')->setWidth(12); // Срок
$activeSheet->getColumnDimension('I')->setWidth(8); // Номер СФ
$activeSheet->getColumnDimension('J')->setWidth(12); // Дата СФ
$activeSheet->getColumnDimension('K')->setWidth(8); // Просрочка
#
// Для удобства заводим переменную $line, в ней будем считать номер строки
$line = 1;
#
# ----- ----- ----- ----- -----
# СТРОКА 1
# ----- ----- ----- ----- -----
// Выводим название отчета
$activeSheet->setCellValue("A{$line}", 'ДОГОВОРА С ИСТЕКШИМИ СРОКАМИ ВЫПОЛНЕНИЯ ЗА ' . date("Y", strtotime($on_date)) . " ГОД");
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
// Задаем высоту строки
$activeSheet->getRowDimension($line)->setRowHeight(20);
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:B{$line}");
$activeSheet->mergeCells("C{$line}:I{$line}");
// Делаем выравнивание по центру вертикали и горизонтали
$activeSheet->getStyle("A{$line}:K{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("A{$line}:K{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Делаем текст жирным и увеличиваем шрифт.
$activeSheet->getStyle("A{$line}:K{$line}")->getFont()->setBold(true);
$activeSheet->getStyle("A{$line}:K{$line}")->getFont()->setSize(13);
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
$activeSheet->getStyle("A{$line}:K{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("A{$line}:K{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Делаем текст жирным и увеличиваем шрифт.
$activeSheet->getStyle("A{$line}:K{$line}")->getFont()->setBold(true);
$activeSheet->getStyle("A{$line}:K{$line}")->getFont()->setSize(13);
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
$activeSheet->getStyle("A{$line}:K{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("A{$line}:K{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Делаем текст жирным и увеличиваем шрифт.
$activeSheet->getStyle("A{$line}:K{$line}")->getFont()->setBold(true);
$activeSheet->getStyle("A{$line}:K{$line}")->getFont()->setSize(13);
// Выводим название отчета
$activeSheet->setCellValue("A{$line}", "");
$activeSheet->setCellValue("C{$line}", "");
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
$activeSheet->setCellValue("B{$line}", 'ДАТА НАЧ');
$activeSheet->setCellValue("C{$line}", 'ЭТАП');
$activeSheet->setCellValue("D{$line}", 'НАЗВАНИЕ ДОГОВОРА / ЭТАПА');
$activeSheet->setCellValue("E{$line}", 'ТИП');
$activeSheet->setCellValue("F{$line}", 'ЗАКАЗЧИК');
$activeSheet->setCellValue("G{$line}", 'ОБЪЕКТ');
$activeSheet->setCellValue("H{$line}", 'СРОК');
$activeSheet->setCellValue("I{$line}", '№ СФ');
$activeSheet->setCellValue("J{$line}", 'ДАТА СФ');
$activeSheet->setCellValue("K{$line}", 'НЕД');
// Стили для текста в шапки таблицы.
$activeSheet->getRowDimension($line)->setRowHeight(36); // высота строки
$activeSheet->getStyle("A{$line}:K{$line}")->getFont()->setSize(12); // размер шрифта
$activeSheet->getStyle("A{$line}:K{$line}")->getFont()->setBold(true); // делаем шрифт жирным
$activeSheet->getStyle("A{$line}:K{$line}")->getAlignment()->setWrapText(true); // разрешаем перенос строк в ячейке
// Выравнивание по вертикали
$activeSheet->getStyle("A{$line}:K{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Выравнивание по горизонтали
$activeSheet->getStyle("A{$line}:C{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$activeSheet->getStyle("D{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("E{$line}:K{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
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
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
// Делаем выборку этапов по идентификатору этапа (kodkalplan)
$_QRY_dockalplan = mysqlQuery("
	SELECT
	dognet_dockalplan_progress.kodkalplan as k1, dognet_dockalplan_progress.summastage as k5, dognet_dockalplan_progress.srokstage_date as k6, dognet_dockalplan_progress.koddoc as k4,
	dognet_dockalplan.kodkalplan as k2, dognet_dockalplan.kodobject as k3, dognet_dockalplan.nameshotstage as k10, dognet_dockalplan.numberstage as k11,
	dognet_kalplanchf.kodkalplan as k7, dognet_kalplanchf.chetfdate as k8, dognet_kalplanchf.chetfnumber as k9,
	dognet_docbase.koddoc as k12, dognet_docbase.docnameshot as k13, dognet_docbase.docnumber as k14, dognet_docbase.kodstatus as k15, dognet_docbase.kodobject as k16, dognet_docbase.kodzakaz as k17, dognet_docbase.kodtip as k18, dognet_docbase.daynachdoc as k19, dognet_docbase.monthnachdoc as k20, dognet_docbase.yearnachdoc as k21
	FROM dognet_dockalplan_progress
	LEFT JOIN dognet_dockalplan ON dognet_dockalplan_progress.kodkalplan = dognet_dockalplan.kodkalplan
	LEFT JOIN dognet_kalplanchf ON (dognet_kalplanchf.kodkalplan = dognet_dockalplan_progress.kodkalplan AND YEAR(dognet_kalplanchf.chetfdate) = '" . $on_date . "' AND dognet_kalplanchf.koddel != '99')
	LEFT JOIN dognet_docbase ON dognet_docbase.koddoc = dognet_dockalplan_progress.koddoc
	WHERE
	dognet_dockalplan_progress.kodkalplan IN (SELECT kodkalplan FROM dognet_kalplanchf WHERE YEAR(chetfdate) = '" . $on_date . "' AND koddel != '99') AND
	dognet_dockalplan_progress.srokstage_date != '0000-00-00' AND dognet_dockalplan_progress.srokstage_date != 'NULL' AND dognet_dockalplan_progress.srokstage_date != ''
	ORDER BY k14 DESC, k11 ASC
	");
//
while ($_ROW_dockalplan = mysqli_fetch_assoc($_QRY_dockalplan)) {
	$DOCSTS = $db_handle->runQuery("SELECT statusnameshot FROM dognet_spstatus WHERE kodstatus = '" . $_ROW_dockalplan['k15'] . "'");
	$DOCTIP = $db_handle->runQuery("SELECT nametip FROM dognet_sptipdog WHERE kodtip = '" . $_ROW_dockalplan['k18'] . "'");
	$DOCOBJ = $db_handle->runQuery("SELECT nameobjectshot FROM sp_objects WHERE kodobject = '" . $_ROW_dockalplan['k16'] . "'");
	$DOCZAK = $db_handle->runQuery("SELECT namezakshot FROM sp_contragents WHERE kodzakaz = '" . $_ROW_dockalplan['k17'] . "'");
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	$_DOCSTS = $DOCSTS[0]['statusnameshot'];
	$_DOCTIP = $DOCTIP[0]['nametip'];
	$_DOCZAK = $DOCZAK[0]['namezakshot'];
	$_DOCOBJ = $DOCOBJ[0]['nameobjectshot'];
	$_DOCNAME = $_ROW_dockalplan['k13'];
	$_DOCNUM = $_ROW_dockalplan['k14'];
	//
	$_DOCDATE_NACH_DAY = ($_ROW_dockalplan['k19'] != "" && $_ROW_dockalplan['k19'] != 0) ? str_pad($_ROW_dockalplan['k19'], 2, '0', STR_PAD_LEFT) : "--";
	$_DOCDATE_NACH_MON = ($_ROW_dockalplan['k20'] != "" && $_ROW_dockalplan['k20'] != 0) ? str_pad($_ROW_dockalplan['k20'], 2, '0', STR_PAD_LEFT) : "--";
	$_DOCDATE_NACH_YER = ($_ROW_dockalplan['k21'] != "" && $_ROW_dockalplan['k21'] != 0) ? str_pad($_ROW_dockalplan['k21'], 2, '0', STR_PAD_LEFT) : "----";
	$_DOCDATE = $_DOCDATE_NACH_DAY . "." . $_DOCDATE_NACH_MON . "." . $_DOCDATE_NACH_YER;
	//
	$_STAGENAME = $_ROW_dockalplan['k10'];
	$_STAGENUM = $_ROW_dockalplan['k11'];
	$_SUMSTAGE = $_ROW_dockalplan['k5'];
	$_SROKSTAGE = $_ROW_dockalplan['k6'];

	$_CHFNUM = $_ROW_dockalplan['k9'];
	$_CHFDATE = $_ROW_dockalplan['k8'];

	$datesrok = new DateTime($_ROW_dockalplan['k6']);
	// $datenow = new DateTime($on_date);
	$chfdate = new DateTime($_CHFDATE);
	$diff = $datesrok->diff($chfdate)->format('%R%a');

	$_PROSRO4KA = round($diff / 7);
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	// Задаем высоту строки и шрифт
	$activeSheet->getRowDimension($line)->setRowHeight(18);
	$activeSheet->getStyle("A{$line}:K{$line}")->getFont()->setSize(10);
	$activeSheet->getStyle("A{$line}:K{$line}")->getFont()->setBold(false);
	// Задаем цвет текста строки
	$activeSheet->getStyle("A{$line}:K{$line}")->getFont()->getColor()->setRGB('111111');
	// Выравниваем строку по вертикали ( середина )
	$activeSheet->getStyle("A{$line}:K{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	// Выравнивание по горизонтали
	$activeSheet->getStyle("A{$line}:C{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$activeSheet->getStyle("D{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$activeSheet->getStyle("E{$line}:K{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$activeSheet->setCellValue("A{$line}", '3-4/' . $_DOCNUM);
	$activeSheet->setCellValue("B{$line}", $_DOCDATE);
	$activeSheet->setCellValue("C{$line}", $_STAGENUM);
	$activeSheet->setCellValue("D{$line}", $_DOCNAME . ' / ' . $_STAGENAME);
	$activeSheet->setCellValue("E{$line}", $_DOCTIP);
	$activeSheet->setCellValue("F{$line}", $_DOCZAK);
	$activeSheet->setCellValue("G{$line}", $_DOCOBJ);
	$activeSheet->setCellValue("H{$line}", date("d.m.Y", strtotime($_SROKSTAGE)));
	$activeSheet->setCellValue("I{$line}", $_CHFNUM);
	$activeSheet->setCellValue("J{$line}", date("d.m.Y", strtotime($_CHFDATE)));
	$activeSheet->setCellValue("K{$line}", $_PROSRO4KA <= 0 ? "---" : $_PROSRO4KA);
	// Оформляем границы
	$activeSheet->getStyle("A{$line}:K{$line}")->applyFromArray($_BORDER_INSIDE);
	$activeSheet->getStyle("A{$line}:K{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
	if ($_PROSRO4KA > 0) {
		// Делаем заливку области ячеек
		$activeSheet->getStyle("A{$line}:K{$line}")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$activeSheet->getStyle("A{$line}:K{$line}")->getFill()->getStartColor()->setRGB("fff0f0");
	}
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	// Следующая строка
	$line++;
}
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
// $objPHPExcel->getActiveSheet()->setAutoFilter("A{$start_table}:I{$start_table}");
