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
$activeSheet->setTitle('Незакрытые авансы на дату');
#
// Колонтитулы
$activeSheet->getHeaderFooter()->setOddHeader('&L&G&B&НЕЗАКРЫТЫЕ АВАНСЫ ПО ВСЕМ ДОГОВОРАМ&R&G&B&12На дату');
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
$_ONDATE = date("Y-m-d", strtotime($_GET['ondate']));
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# ФОРМАТИРУЕМ ВЫХОДНУЮ ТАБЛИЦУ EXCEL
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
// Задаем ширины столбцов
$activeSheet->getColumnDimension('A')->setWidth(7); // Номер этапа
$activeSheet->getColumnDimension('B')->setWidth(90); // Название этапа
$activeSheet->getColumnDimension('C')->setWidth(25); // Аванс
$activeSheet->getColumnDimension('D')->setWidth(18); // Дата аванса
$activeSheet->getColumnDimension('E')->setWidth(18); // Дата закрытия (план)
$activeSheet->getColumnDimension('F')->setWidth(20); // Сумма СФ
$activeSheet->getColumnDimension('G')->setWidth(20); // Остаток аванса
#
// Для удобства заводим переменную $line, в ней будем считать номер строки
$line = 1;
#
# ----- ----- ----- ----- -----
# СТРОКА 1
# ----- ----- ----- ----- -----
// Выводим название отчета
$activeSheet->setCellValue("A{$line}", 'СПРАВКА ОБ АВАНСАХ, НЕ ЗАКРЫТЫХ СЧЕТАМИ-ФАКТУРАМИ НА ' . date("d.m.Y", strtotime($_ONDATE)));
// Задаем высоту строки
$activeSheet->getRowDimension($line)->setRowHeight(32);
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:G{$line}");
// Делаем выравнивание по центру вертикали и горизонтали
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("A{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Делаем текст жирным и увеличиваем шрифт.
$activeSheet->getStyle("A{$line}")->getFont()->setBold(true);
$activeSheet->getStyle("A{$line}")->getFont()->setSize(14);
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
$activeSheet->mergeCells("A{$line}:G{$line}");
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
$activeSheet->mergeCells("A{$line}:G{$line}");
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
$line++;
// Выводим название отчета
$activeSheet->setCellValue("A{$line}", "Валюта - только рубли / Авансы с нулевыми остатками не отображаются");
// Задаем высоту строки
$activeSheet->getRowDimension($line)->setRowHeight(20);
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:G{$line}");
// Делаем выравнивание по центру вертикали и горизонтали
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("A{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Делаем текст жирным и увеличиваем шрифт.
$activeSheet->getStyle("A{$line}")->getFont()->setBold(false);
$activeSheet->getStyle("A{$line}")->getFont()->setSize(11);
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
$activeSheet->setCellValue("A{$line}", 'Этап');
$activeSheet->setCellValue("B{$line}", 'Наименование договора/этапа');
$activeSheet->setCellValue("C{$line}", 'Аванс' . "\n" . '(вкл. НДС)');
$activeSheet->setCellValue("D{$line}", 'Дата' . "\n" . 'аванса');
$activeSheet->setCellValue("E{$line}", "Дата договора" . "\n" . "Конец этапа");
$activeSheet->setCellValue("F{$line}", 'Зачтено' . "\n" . '(вкл. НДС)');
$activeSheet->setCellValue("G{$line}", 'Остаток ' . "\n" . '(вкл. НДС)');
// Стили для текста в шапки таблицы.
$activeSheet->getRowDimension($line)->setRowHeight(36); // высота строки
$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setSize(12); // размер шрифта
$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setBold(true); // делаем шрифт жирным
$activeSheet->getStyle("A{$line}:G{$line}")->getAlignment()->setWrapText(true); // разрешаем перенос строк в ячейке

// Вырванивание по вертикали - середина
$activeSheet->getStyle("A{$line}:G{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Выравнивание по горизонтали - середина
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// Выравнивание по горизонтали - слева
$activeSheet->getStyle("B{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
// Выравнивание по горизонтали - середина
$activeSheet->getStyle("C{$line}:G{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// Делаем заливку области ячеек
$activeSheet->getStyle("A{$line}:G{$line}")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$activeSheet->getStyle("A{$line}:G{$line}")->getFill()->getStartColor()->setRGB("31708F");
// Задаем цвет текста строки
$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->getColor()->setRGB('FFFFFF');
// Оформляем границы
$activeSheet->getStyle("A{$line}:G{$line}")->applyFromArray($_BORDER_INSIDE);
$activeSheet->getStyle("A{$line}:G{$line}")->applyFromArray($_BORDER_OUTSIDE_THICK);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
// Делаем выборку заказчиков, по чьим авансам остается задолженность
$strQuery_spzakaz = "SELECT * FROM sp_contragents
WHERE koddel<>'99' 
AND (kodcontragent IN 
(SELECT kodzakaz FROM dognet_docbase WHERE koddel<>'99' AND koddened='245296558950375' AND koddoc IN 
(SELECT koddoc FROM dognet_dockalplan WHERE koddel<>'99' AND kodkalplan IN 
(SELECT koddoc FROM dognet_docavans a WHERE a.dateavans<='{$_ONDATE}' AND a.summaavans>(SELECT coalesce(SUM(summaoplav), 0) FROM dognet_chfavans b WHERE b.dateoplav<='{$_ONDATE}' AND b.kodavans=a.kodavans))))) 
OR 
(kodcontragent IN 
(SELECT kodzakaz FROM dognet_docbase WHERE koddel<>'99' AND koddened='245296558950375' AND koddoc IN 
(SELECT koddoc FROM dognet_docavans a WHERE a.dateavans<='{$_ONDATE}' AND a.summaavans>(SELECT coalesce(SUM(summaoplav), 0) FROM dognet_chfavans b WHERE b.dateoplav<='{$_ONDATE}' AND b.kodavans=a.kodavans)))) ORDER BY nameshort ASC";

$_QRY_spzakaz = mysqlQuery($strQuery_spzakaz);

$_SUM_ALL_AV = 0.0;
$_SUM_ALL_OST = 0.0;
$_SUM_ALL_OPLAV = 0.0;
//
while ($_ROW_spzakaz = mysqli_fetch_assoc($_QRY_spzakaz)) {
	$_kodzakaz = $_ROW_spzakaz['kodcontragent'];

	$_NAMEZAKSHOT = $_ROW_spzakaz['nameshort'];
	// Задаем высоту строки и шрифт
	$activeSheet->getRowDimension($line)->setRowHeight(32);
	$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setSize(13);
	$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setBold(true);
	// Делаем заливку области ячеек
	$activeSheet->getStyle("A{$line}:G{$line}")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$activeSheet->getStyle("A{$line}:G{$line}")->getFill()->getStartColor()->setRGB("111111");
	// Задаем цвет текста строки
	$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->getColor()->setRGB('F1F1F1');
	// Объединяем ячейки по горизонтали
	$activeSheet->mergeCells("A{$line}:G{$line}");
	// Выравниваем строку по вертикали ( середина )
	$activeSheet->getStyle("A{$line}:G{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	// Выравнивание по горизонтали - слева
	$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$activeSheet->setCellValue("A{$line}", $_NAMEZAKSHOT);
	// Оформляем границы
	$activeSheet->getStyle("A{$line}:G{$line}")->applyFromArray($_BORDER_INSIDE);
	$activeSheet->getStyle("A{$line}:G{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	// Следующая строка
	$line++;
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	// Делаем выборку договоров
	$strQuery_docbase = "SELECT *	FROM dognet_docbase 
	WHERE koddened='245296558950375' 
	AND koddel<>'99' 
	AND (koddoc IN (SELECT koddoc FROM dognet_dockalplan WHERE kodkalplan IN (SELECT koddoc FROM dognet_docavans a WHERE a.dateavans<='{$_ONDATE}' AND a.summaavans>(SELECT coalesce(SUM(summaoplav), 0) FROM dognet_chfavans b WHERE b.dateoplav<='{$_ONDATE}' AND b.kodavans=a.kodavans)) AND kodzakaz='{$_kodzakaz}' AND koddel<>'99') OR koddoc IN (SELECT koddoc FROM dognet_docavans a WHERE a.dateavans<='{$_ONDATE}' AND a.summaavans>(SELECT coalesce(SUM(summaoplav), 0) FROM dognet_chfavans b WHERE b.dateoplav<='{$_ONDATE}' AND b.kodavans=a.kodavans) AND kodzakaz='{$_kodzakaz}' AND koddel<>'99'))";

	$_QRY_docbase = mysqlQuery($strQuery_docbase);

	$_SUM_ZAKAZ_AV = 0.0;
	$_SUM_ZAKAZ_OST = 0.0;
	$_SUM_ZAKAZ_OPLAV = 0.0;
	//
	while ($_ROW_docbase = mysqli_fetch_assoc($_QRY_docbase)) {
		$_kodshab = $_ROW_docbase['kodshab'];
		$_koddoc = $_ROW_docbase['koddoc'];

		$_DOCNUMBER = $_ROW_docbase['docnumber'];
		$_DOCNAMESHOT = $_ROW_docbase['docnameshot'];
		$_DOCNAMEFULL = $_ROW_docbase['docnamefullm'];

		// Задаем высоту строки и шрифт
		// Задаем высоту строки и шрифт
		if (mb_strlen($_ROW_docbase['docnameshot']) > 180) {
			$rowHeight = 96;
		} elseif ((100 < mb_strlen($_ROW_docbase['docnameshot'])) && (mb_strlen($_ROW_docbase['docnameshot']) <= 180)) {
			$rowHeight = 72;
		} elseif ((65 < mb_strlen($_ROW_docbase['docnameshot'])) && (mb_strlen($_ROW_docbase['docnameshot']) <= 100)) {
			$rowHeight = 48;
		} else {
			$rowHeight = 36;
		}
		$activeSheet->getRowDimension($line)->setRowHeight($rowHeight);
		$activeSheet->getStyle("A{$line}:B{$line}")->getFont()->setSize(12);
		$activeSheet->getStyle("C{$line}:G{$line}")->getFont()->setSize(10);
		$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setBold(true);
		// Задаем цвет заливки строки
		$activeSheet->getStyle("C{$line}:G{$line}")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$activeSheet->getStyle("C{$line}:G{$line}")->getFill()->getStartColor()->setRGB("E0E0E0");
		// Задаем цвет текста строки
		$activeSheet->getStyle("A{$line}:B{$line}")->getFont()->getColor()->setRGB('111111');
		$activeSheet->getStyle("C{$line}:G{$line}")->getFont()->getColor()->setRGB('111111');
		// Объединяем ячейки по горизонтали
		$activeSheet->mergeCells("A{$line}:B{$line}");
		// Выравниваем строку по вертикали ( середина )
		$activeSheet->getStyle("A{$line}:G{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		// Выравнивание по горизонтали - слева
		$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		// Выравнивание по горизонтали - середина
		$activeSheet->getStyle("C{$line}:G{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		// Разрешаем перенос строк в ячейке
		$activeSheet->getStyle("A{$line}:G{$line}")->getAlignment()->setWrapText(true);
		// Вывод данных
		if ($_ROW_docbase['kodshab'] == 0) {
			$activeSheet->setCellValue("A{$line}", "Счет № " . $_ROW_docbase['numberchet'] . " : " . trim($_ROW_docbase['docnameshot'], " \n\r\t\v\x00"));
		} else {
			$activeSheet->setCellValue("A{$line}", "Договор № 3-4/" . $_ROW_docbase['docnumber'] . " : " . trim($_ROW_docbase['docnameshot'], " \n\r\t\v\x00"));
		}
		$activeSheet->setCellValue("C{$line}", "Аванс" . "\n" . "(вкл. НДС)");
		$activeSheet->setCellValue("D{$line}", "Дата аванса");
		$activeSheet->setCellValue("E{$line}", "Дата договора" . "\n" . "Конец этапа");
		$activeSheet->setCellValue("F{$line}", "Зачтено");
		$activeSheet->setCellValue("G{$line}", "Остаток");
		// Оформляем границы
		$activeSheet->getStyle("A{$line}:G{$line}")->applyFromArray($_BORDER_INSIDE);
		$activeSheet->getStyle("A{$line}:G{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		// Следующая строка
		$line++;
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

		$_SUM_TOTAL_AV = 0.0;
		$_SUM_TOTAL_OST = 0.0;
		$_SUM_TOTAL_OPLAV = 0.0;

		if ($_kodshab == 1 || $_kodshab == 3) {

			// Делаем выборку этапов по идентификатору этапа (kodkalplan)
			$_strQuery_dockalplan = "SELECT * FROM dognet_dockalplan 
			WHERE koddel<>'99' 
			AND kodkalplan IN (SELECT koddoc FROM dognet_docavans a WHERE a.dateavans<='{$_ONDATE}' AND a.summaavans>(SELECT coalesce(SUM(summaoplav), 0) FROM dognet_chfavans b WHERE b.dateoplav<='{$_ONDATE}' AND b.kodavans=a.kodavans)) AND koddoc='{$_koddoc}'";
			$_QRY_dockalplan = mysqlQuery($_strQuery_dockalplan);

			while ($_ROW_dockalplan = mysqli_fetch_assoc($_QRY_dockalplan)) {
				$_kodkalplan = $_ROW_dockalplan['kodkalplan'];

				$_STAGENAME = $_ROW_dockalplan['nameshotstage'];
				$_STAGENUM = $_ROW_dockalplan['numberstage'];
				$_DATEPLAN = ($_ROW_dockalplan['dateplan'] != "") ? date("d.m.Y", strtotime($_ROW_dockalplan['dateplan'])) : "---";

				$_SUM_STAGE_AV = 0.0;
				$_SUM_STAGE_OST = 0.0;
				$_SUM_STAGE_OPLAV = 0.0;
				$_SUM_STAGE_CHF = F_REP_MAIN_SUM_STAGE_CHF($_kodkalplan, $_ONDATE);

				if (mb_strlen($_ROW_dockalplan['nameshotstage']) > 210) {
					$rowHeight = 60;
				} elseif ((120 < mb_strlen($_ROW_dockalplan['nameshotstage'])) && (mb_strlen($_ROW_dockalplan['nameshotstage']) <= 210)) {
					$rowHeight = 48;
				} elseif ((70 < mb_strlen($_ROW_dockalplan['nameshotstage'])) && (mb_strlen($_ROW_dockalplan['nameshotstage']) <= 120)) {
					$rowHeight = 36;
				} else {
					$rowHeight = 18;
				}
				// Задаем высоту строки и шрифт
				$activeSheet->getRowDimension($line)->setRowHeight($rowHeight);
				$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setSize(10);
				$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setBold(false);
				// Задаем цвет текста строки
				$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->getColor()->setRGB('111111');
				// Выравниваем строку по вертикали ( середина )
				$activeSheet->getStyle("A{$line}:G{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				// Выравнивание по горизонтали - середина
				$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				// Выравнивание по горизонтали - слева
				$activeSheet->getStyle("B{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				// Выравнивание по горизонтали - середина
				$activeSheet->getStyle("C{$line}:G{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$activeSheet->setCellValue("A{$line}", $_STAGENUM);
				$activeSheet->setCellValue("B{$line}", $_STAGENAME);
				$activeSheet->setCellValue("C{$line}", "");
				$activeSheet->setCellValue("D{$line}", "");
				$activeSheet->setCellValue("E{$line}", $_DATEPLAN);
				$activeSheet->setCellValue("F{$line}", "");
				$activeSheet->setCellValue("G{$line}", "");
				// Разрешаем перенос строк в ячейке
				$activeSheet->getStyle("B{$line}")->getAlignment()->setWrapText(true);
				// Оформляем границы
				$activeSheet->getStyle("A{$line}:G{$line}")->applyFromArray($_BORDER_INSIDE);
				$activeSheet->getStyle("A{$line}:G{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
				// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
				// Следующая строка
				$line++;

				$_strQuery_docavans = "SELECT * FROM dognet_docavans a
				WHERE a.koddel<>'99' AND a.koddoc='{$_kodkalplan}' AND a.dateavans<='{$_ONDATE}' AND a.summaavans>(SELECT coalesce(SUM(summaoplav), 0) FROM dognet_chfavans b WHERE b.dateoplav<='{$_ONDATE}' AND b.kodavans=a.kodavans)";
				$_QRY_docavans = mysqlQuery($_strQuery_docavans);

				while ($_ROW_docavans = mysqli_fetch_assoc($_QRY_docavans)) {
					// Сумма зачтенных авансов
					$_SUMOPLAV = F_REP_MAIN_SUM_AV_OPLAV($_ROW_docavans['kodavans'], $_ONDATE);
					$_AVDATE = ($_ROW_docavans['dateavans'] != "") ? date("d.m.Y", strtotime($_ROW_docavans['dateavans'])) : "---";
					$_AVSUMMA = $_ROW_docavans['summaavans'];
					$_AVOST = F_REP_MAIN_CALC_AV_AVOST($_ROW_docavans['kodavans'], $_ONDATE);
					$_AVCOMM = $_ROW_docavans['comment'];
					$_AVOPL = ($_SUMOPLAV != 0) ? $_SUMOPLAV : 0.0;
					// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
					// Задаем высоту строки и шрифт
					$activeSheet->getRowDimension($line)->setRowHeight(16);
					$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setSize(9);
					$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setBold(false);
					// Задаем цвет текста строки
					$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->getColor()->setRGB('666666');
					// Выравниваем строку по вертикали ( середина )
					$activeSheet->getStyle("A{$line}:G{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					// Выравнивание по горизонтали - слева
					$activeSheet->getStyle("B{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
					// Выравнивание по горизонтали - середина
					$activeSheet->getStyle("C{$line}:G{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					// Вывод данных
					$activeSheet->setCellValue("B{$line}", "Аванс");
					$activeSheet->setCellValue("C{$line}", $_AVSUMMA);
					$activeSheet->getStyle("C{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
					$activeSheet->setCellValue("D{$line}", $_AVDATE);
					$activeSheet->setCellValue("E{$line}", "");
					$activeSheet->setCellValue("F{$line}", $_AVOPL);
					$activeSheet->getStyle("F{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
					$activeSheet->setCellValue("G{$line}", $_AVOST);
					$activeSheet->getStyle("G{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
					// Оформляем границы
					$activeSheet->getStyle("A{$line}:G{$line}")->applyFromArray($_BORDER_INSIDE);
					$activeSheet->getStyle("A{$line}:G{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
					// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
					// Следующая строка
					$line++;
					// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
					// Суммируем счета по этапу
					$_SUM_STAGE_AV += $_AVSUMMA;
					$_SUM_STAGE_OPLAV += $_AVOPL;
					$_SUM_STAGE_OST += $_AVOST;
				}
				// Суммируем всего
				$_SUM_TOTAL_AV += $_SUM_STAGE_AV;
				$_SUM_TOTAL_OPLAV += $_SUM_STAGE_OPLAV;
				$_SUM_TOTAL_OST += $_SUM_STAGE_OST;
			}
		} else {

			$rowHeight = 18;
			$_DATEPLAN = str_pad($_ROW_docbase['daynachdoc'], 2, '0', STR_PAD_LEFT) . "." . str_pad($_ROW_docbase['monthnachdoc'], 2, '0', STR_PAD_LEFT) . "." . str_pad($_ROW_docbase['yearnachdoc'], 4, '20', STR_PAD_LEFT);

			// Задаем высоту строки и шрифт
			$activeSheet->getRowDimension($line)->setRowHeight($rowHeight);
			$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setSize(10);
			$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setBold(false);
			// Задаем цвет текста строки
			$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->getColor()->setRGB('111111');
			// Выравниваем строку по вертикали ( середина )
			$activeSheet->getStyle("A{$line}:G{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			// Выравнивание по горизонтали - середина
			$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			// Выравнивание по горизонтали - слева
			$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			// Выравнивание по горизонтали - середина
			$activeSheet->getStyle("C{$line}:G{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			// Объединяем ячейки по горизонтали
			$activeSheet->mergeCells("A{$line}:B{$line}");
			// Вывод данных
			$activeSheet->setCellValue("A{$line}", "Без этапа");
			$activeSheet->setCellValue("E{$line}", $_DATEPLAN);
			// Разрешаем перенос строк в ячейке
			$activeSheet->getStyle("A{$line}")->getAlignment()->setWrapText(true);
			// Оформляем границы
			$activeSheet->getStyle("A{$line}:G{$line}")->applyFromArray($_BORDER_INSIDE);
			$activeSheet->getStyle("A{$line}:G{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			// Следующая строка
			$line++;

			$_strQuery_docavans = "SELECT * FROM dognet_docavans a 
			WHERE a.koddel<>'99' 
			AND a.koddoc='{$_koddoc}' 
			AND a.dateavans<='{$_ONDATE}' 
			AND a.summaavans>(SELECT coalesce(SUM(summaoplav), 0) FROM dognet_chfavans b WHERE b.dateoplav<='{$_ONDATE}' AND b.kodavans=a.kodavans)";

			$_SUM_STAGE_AV = 0.0;
			$_SUM_STAGE_OST = 0.0;
			$_SUM_STAGE_OPLAV = 0.0;
			$_SUM_STAGE_CHF = F_REP_MAIN_SUM_STAGE_CHF($_koddoc, $_ONDATE);

			$_QRY_docavans = mysqlQuery($_strQuery_docavans);
			while ($_ROW_docavans = mysqli_fetch_assoc($_QRY_docavans)) {
				// Сумма зачтенных авансов
				$_SUMOPLAV = F_REP_MAIN_SUM_AV_OPLAV($_ROW_docavans['kodavans'], $_ONDATE);
				$_AVDATE = ($_ROW_docavans['dateavans'] != "") ? date("d.m.Y", strtotime($_ROW_docavans['dateavans'])) : "---";
				$_AVSUMMA = $_ROW_docavans['summaavans'];
				$_AVOST = F_REP_MAIN_CALC_AV_AVOST($_ROW_docavans['kodavans'], $_ONDATE);
				$_AVCOMM = $_ROW_docavans['comment'];
				$_AVOPL = ($_SUMOPLAV != 0) ? $_SUMOPLAV : 0.0;
				// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
				// Задаем высоту строки и шрифт
				$activeSheet->getRowDimension($line)->setRowHeight(16);
				$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setSize(9);
				$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setBold(false);
				// Задаем цвет текста строки
				$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->getColor()->setRGB('666666');
				// Выравниваем строку по вертикали ( середина )
				$activeSheet->getStyle("A{$line}:G{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				// Выравнивание по горизонтали - середина
				$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				// Выравнивание по горизонтали - слева
				$activeSheet->getStyle("B{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				// Выравнивание по горизонтали - середина
				$activeSheet->getStyle("C{$line}:G{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$activeSheet->setCellValue("A{$line}", "");
				$activeSheet->setCellValue("B{$line}", "Аванс");
				$activeSheet->setCellValue("C{$line}", $_AVSUMMA);
				$activeSheet->getStyle("C{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
				$activeSheet->setCellValue("D{$line}", $_AVDATE);
				$activeSheet->setCellValue("E{$line}", "");
				$activeSheet->setCellValue("F{$line}", $_AVOPL);
				$activeSheet->getStyle("F{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
				$activeSheet->setCellValue("G{$line}", $_AVOST);
				$activeSheet->getStyle("G{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
				// Оформляем границы
				$activeSheet->getStyle("A{$line}:G{$line}")->applyFromArray($_BORDER_INSIDE);
				$activeSheet->getStyle("A{$line}:G{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
				// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
				// Следующая строка
				$line++;
				// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
				// Суммируем счета по этапу
				$_SUM_STAGE_AV += $_AVSUMMA;
				$_SUM_STAGE_OPLAV += $_AVOPL;
				$_SUM_STAGE_OST += $_AVOST;
			}
			// Суммируем всего
			$_SUM_TOTAL_AV += $_SUM_STAGE_AV;
			$_SUM_TOTAL_OPLAV += $_SUM_STAGE_OPLAV;
			$_SUM_TOTAL_OST += $_SUM_STAGE_OST;
		}
		// Суммируем всего
		$_SUM_ZAKAZ_AV += $_SUM_TOTAL_AV;
		$_SUM_ZAKAZ_OPLAV += $_SUM_TOTAL_OPLAV;
		$_SUM_ZAKAZ_OST += $_SUM_TOTAL_OST;
		// Задаем высоту строки и шрифт
		$activeSheet->getRowDimension($line)->setRowHeight(26);
		$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setSize(11);
		$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setBold(true);
		// Задаем цвет текста строки
		$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->getColor()->setRGB('111111');
		// Объединяем ячейки по горизонтали
		$activeSheet->mergeCells("A{$line}:B{$line}");
		// Объединяем ячейки по горизонтали
		$activeSheet->mergeCells("D{$line}:E{$line}");
		// Выравниваем строку по вертикали ( середина )
		$activeSheet->getStyle("A{$line}:G{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		// Выравнивание по горизонтали - слева
		$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		// Выравнивание по горизонтали - центр
		$activeSheet->getStyle("C{$line}:G{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		if ($_ROW_docbase['kodshab'] == 0) {
			$activeSheet->setCellValue("A{$line}", "Итого по счету");
		} else {
			$activeSheet->setCellValue("A{$line}", "Итого по договору");
		}
		$activeSheet->setCellValue("C{$line}", $_SUM_TOTAL_AV);
		$activeSheet->getStyle("C{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
		$activeSheet->setCellValue("F{$line}", $_SUM_TOTAL_OPLAV);
		$activeSheet->getStyle("F{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
		$activeSheet->setCellValue("G{$line}", $_SUM_TOTAL_OST);
		$activeSheet->getStyle("G{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
		// Оформляем границы
		$activeSheet->getStyle("A{$line}:G{$line}")->applyFromArray($_BORDER_INSIDE);
		$activeSheet->getStyle("A{$line}:G{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
		# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		// Следующая строка
		$line++;
		# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	}
	// Задаем высоту строки и шрифт
	$activeSheet->getRowDimension($line)->setRowHeight(26);
	$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setSize(13);
	$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setBold(true);
	// Делаем заливку области ячеек
	$activeSheet->getStyle("A{$line}:G{$line}")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$activeSheet->getStyle("A{$line}:G{$line}")->getFill()->getStartColor()->setRGB("F1F1F1");
	// Задаем цвет текста строки
	$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->getColor()->setRGB('111111');
	// Объединяем ячейки по горизонтали
	$activeSheet->mergeCells("A{$line}:B{$line}");
	// Объединяем ячейки по горизонтали
	$activeSheet->mergeCells("D{$line}:E{$line}");
	// Выравниваем строку по вертикали ( середина )
	$activeSheet->getStyle("A{$line}:G{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	// Выравнивание по горизонтали - справа
	$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	// Выравнивание по горизонтали - центр
	$activeSheet->getStyle("C{$line}:G{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$activeSheet->setCellValue("A{$line}", "ИТОГО ПО ЗАКАЗЧИКУ");
	$activeSheet->setCellValue("C{$line}", $_SUM_ZAKAZ_AV);
	$activeSheet->getStyle("C{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
	$activeSheet->setCellValue("F{$line}", $_SUM_ZAKAZ_OPLAV);
	$activeSheet->getStyle("F{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
	$activeSheet->setCellValue("G{$line}", $_SUM_ZAKAZ_OST);
	$activeSheet->getStyle("G{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
	// Оформляем границы
	$activeSheet->getStyle("A{$line}:G{$line}")->applyFromArray($_BORDER_INSIDE);
	$activeSheet->getStyle("A{$line}:G{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	// Следующая строка
	$line++;
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	// Общий итог
	$_SUM_ALL_AV += $_SUM_ZAKAZ_AV;
	$_SUM_ALL_OPLAV += $_SUM_ZAKAZ_OPLAV;
	$_SUM_ALL_OST += $_SUM_ZAKAZ_OST;
}
// Задаем высоту строки и шрифт
$activeSheet->getRowDimension($line)->setRowHeight(32);
$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setSize(13);
$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setBold(true);
// Делаем заливку области ячеек
$activeSheet->getStyle("A{$line}:G{$line}")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$activeSheet->getStyle("A{$line}:G{$line}")->getFill()->getStartColor()->setRGB("31708F");
// Задаем цвет текста строки
$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->getColor()->setRGB('F1F1F1');
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:B{$line}");
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("D{$line}:E{$line}");
// Выравниваем строку по вертикали ( середина )
$activeSheet->getStyle("A{$line}:G{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Выравнивание по горизонтали - справа
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
// Выравнивание по горизонтали - центр
$activeSheet->getStyle("C{$line}:G{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$activeSheet->setCellValue("A{$line}", "ВСЕГО");
$activeSheet->setCellValue("C{$line}", $_SUM_ALL_AV);
$activeSheet->getStyle("C{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
$activeSheet->setCellValue("F{$line}", $_SUM_ALL_OPLAV);
$activeSheet->getStyle("F{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
$activeSheet->setCellValue("G{$line}", $_SUM_ALL_OST);
$activeSheet->getStyle("G{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
// Оформляем границы
$activeSheet->getStyle("A{$line}:G{$line}")->applyFromArray($_BORDER_INSIDE);
$activeSheet->getStyle("A{$line}:G{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
#
#
// Добавляем рамку к шапке таблицы
$activeSheet->getStyle("A{$start_table}:G{$start_table}")->applyFromArray($_BORDER_OUTSIDE_THIN);
// Добавляем рамку ко всей таблице
$activeSheet->getStyle("A{$start_table}:G{$line}")->applyFromArray($_BORDER_OUTSIDE_THIN);


// $objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());
// $objPHPExcel->getActiveSheet()->setAutoFilter("A{$start_table}:G{$start_table}");