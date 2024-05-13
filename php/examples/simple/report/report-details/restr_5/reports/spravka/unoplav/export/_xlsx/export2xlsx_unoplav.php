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
$activeSheet->getHeaderFooter()->setOddFooter('&11&L&B'.$_SESSION["current_user_firstname"].' '.$_SESSION["current_user_lastname"].' / '.date('d.m.Y H:i:s').'&R&11Страница &P из &N');
#
// Настройки шрифта
$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');
$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
// Задаем свой формат
define("PRICE_FORMAT_1", PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1. "[\$ р.-419]");
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
$_BORDER_TOP_THIN = array('borders'=>array('top'=>array('style'=>PHPExcel_Style_Border::BORDER_THIN,'color'=>array('rgb'=>'000000'))));
$_BORDER_BOTTOM_THIN = array('borders'=>array('bottom'=>array('style'=>PHPExcel_Style_Border::BORDER_THIN,'color'=>array('rgb'=>'000000'))));
$_BORDER_BOTTOM_THICK = array('borders'=>array('bottom'=>array('style'=>PHPExcel_Style_Border::BORDER_THICK,'color'=>array('rgb'=>'000000'))));
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
$on_date = date("Y-m-d", strtotime($_GET['on_date']));
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# ФОРМАТИРУЕМ ВЫХОДНУЮ ТАБЛИЦУ EXCEL
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
// Задаем ширины столбцов
$activeSheet->getColumnDimension('A')->setWidth(8); // Номер этапа
$activeSheet->getColumnDimension('B')->setWidth(80); // Название этапа
$activeSheet->getColumnDimension('C')->setWidth(20); // Аванс
$activeSheet->getColumnDimension('D')->setWidth(15); // Дата аванса
$activeSheet->getColumnDimension('E')->setWidth(15); // Дата закрытия (план)
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
$activeSheet->setCellValue("A{$line}", 'СПРАВКА ОБ АВАНСАХ, НЕ ЗАКРЫТЫХ СЧЕТАМИ-ФАКТУРАМИ НА '.date("d.m.Y", strtotime($on_date)));
// Задаем высоту строки
$activeSheet->getRowDimension($line)->setRowHeight(24);
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:G{$line}");
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
$activeSheet->setCellValue("A{$line}", 'Дата отчета: '.date("d.m.Y H:i:s"));
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
$activeSheet->setCellValue("A{$line}", "Отчет составлен: ".$_SESSION['lastname']." ".$_SESSION['firstname']." ".$_SESSION['middlename']);
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
$activeSheet->setCellValue("A{$line}", 'ЭТАП');
$activeSheet->setCellValue("B{$line}", 'НАИМЕНОВАНИЕ ЭТАПА');
$activeSheet->setCellValue("C{$line}", 'АВАНС'."\n".'(вкл. НДС)');
$activeSheet->setCellValue("D{$line}", 'ДАТА'."\n".'АВАНСА');
$activeSheet->setCellValue("E{$line}", 'ДАТА'."\n".'ЗАКРЫТИЯ');
$activeSheet->setCellValue("F{$line}", 'ЗАЧТЕНО'."\n".'(вкл. НДС)');
$activeSheet->setCellValue("G{$line}", 'ОСТАТОК '."\n".'(вкл. НДС)');
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
$_QRY_spzakaz = mysqlQuery("
SELECT kodzakaz, namezakshot
FROM sp_contragents
WHERE koddel<>'99' AND kodzakaz IN 
(SELECT kodzakaz FROM dognet_docbase WHERE koddel<>'99' AND koddened = '245296558950375' AND koddoc IN 
(SELECT koddoc FROM dognet_dockalplan WHERE koddel<>'99' AND kodkalplan IN 
(SELECT koddoc FROM dognet_docavans a WHERE a.dateavans <= '".$on_date."' AND a.summaavans > (SELECT coalesce(SUM(summaoplav), 0) FROM dognet_chfavans b WHERE b.dateoplav <= '".$on_date."' AND b.kodavans = a.kodavans) )))
");
//
$_SUM_ALL_AV = 0.0;
$_SUM_ALL_OST = 0.0;
$_SUM_ALL_OPLAV = 0.0;
//
while ($_ROW_spzakaz = mysqli_fetch_assoc($_QRY_spzakaz)) {
	$_NAMEZAKSHOT = $_ROW_spzakaz['namezakshot'];
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
	$_QRY_docbase = mysqlQuery(" 
	SELECT koddoc, docnumber, docnameshot, docnamefullm, kodshab, yearnachdoc, monthnachdoc, daynachdoc
	FROM dognet_docbase
	WHERE koddened = '245296558950375' AND koddel<>'99' AND koddoc IN 
	(SELECT koddoc FROM dognet_dockalplan WHERE kodkalplan IN 
	(SELECT koddoc FROM dognet_docavans a WHERE a.dateavans <= '".$on_date."' AND a.summaavans > (SELECT coalesce(SUM(summaoplav), 0) FROM dognet_chfavans b WHERE b.dateoplav <= '".$on_date."' AND b.kodavans = a.kodavans)) AND kodzakaz = '".$_ROW_spzakaz['kodzakaz']."' AND koddel <> '99') 
	OR koddoc IN 
	(SELECT koddoc FROM dognet_docavans a WHERE a.dateavans <= '".$on_date."' AND a.summaavans > (SELECT coalesce(SUM(summaoplav), 0) FROM dognet_chfavans b WHERE b.dateoplav <= '".$on_date."' AND b.kodavans = a.kodavans) AND kodzakaz = '".$_ROW_spzakaz['kodzakaz']."' AND koddel <> '99')
	");
	
/*
	(SELECT koddoc FROM dognet_dockalplan WHERE koddel<>'99' AND kodkalplan IN (SELECT koddoc FROM dognet_docavans WHERE koddel <> '99' AND ostatokavans > 0 AND dateavans <= '".$on_date."' )) AND kodzakaz = '".$_ROW_spzakaz['kodzakaz']."' AND koddel <> '99')
	OR
	(koddoc IN (SELECT koddoc FROM dognet_docavans WHERE koddel <> '99' AND ostatokavans > 0 AND dateavans <= '".$on_date."' ) AND kodzakaz = '".$_ROW_spzakaz['kodzakaz']."' AND koddel <> '99')");
*/
	//
	$_SUM_ZAKAZ_AV = 0.0;
	$_SUM_ZAKAZ_OST = 0.0;
	$_SUM_ZAKAZ_OPLAV = 0.0;
	//
	while ($_ROW_docbase = mysqli_fetch_assoc($_QRY_docbase)) {
	$_DOCNUMBER = $_ROW_docbase['docnumber'];
	$_DOCNAMESHOT = $_ROW_docbase['docnameshot'];
	$_DOCNAMEFULL = $_ROW_docbase['docnamefullm'];
	// Задаем высоту строки и шрифт
	$activeSheet->getRowDimension($line)->setRowHeight(24);
	$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setSize(11);
	$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setBold(true);
	// Задаем цвет текста строки
	$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->getColor()->setRGB('111111');
	// Объединяем ячейки по горизонтали
	$activeSheet->mergeCells("A{$line}:G{$line}");
	// Выравниваем строку по вертикали ( середина )
	$activeSheet->getStyle("A{$line}:G{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	// Выравнивание по горизонтали - слева
	$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	// Разрешаем перенос строк в ячейке
	$activeSheet->getStyle("A{$line}")->getAlignment()->setWrapText(true);
	$activeSheet->setCellValue("A{$line}", '3-4/'.$_DOCNUMBER.' : '.$_DOCNAMESHOT);
	// Оформляем границы
	$activeSheet->getStyle("A{$line}:G{$line}")->applyFromArray($_BORDER_INSIDE);
	$activeSheet->getStyle("A{$line}:G{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Следующая строка
$line++;
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----



	if ($_ROW_docbase['kodshab']==1||$_ROW_docbase['kodshab']==3) {
		// Делаем выборку этапов по идентификатору этапа (kodkalplan)
		$_QRY_dockalplan = mysqlQuery( "SELECT * FROM dognet_dockalplan WHERE koddel<>'99' AND kodkalplan IN (SELECT koddoc FROM dognet_docavans a WHERE a.dateavans <= '".$on_date."' AND a.summaavans > (SELECT coalesce(SUM(summaoplav), 0) FROM dognet_chfavans b WHERE b.dateoplav <= '".$on_date."' AND b.kodavans = a.kodavans)) AND koddoc = '".$_ROW_docbase['koddoc']."'");
		//
		$_SUM_TOTAL_AV = 0.0;
		$_SUM_TOTAL_OST = 0.0;
		$_SUM_TOTAL_OPLAV = 0.0;
		//
		while ($_ROW_dockalplan = mysqli_fetch_assoc($_QRY_dockalplan)) {
			// Сумма счетов-фактур по этапу
			$SUMCHF = $db_handle->runQuery( "SELECT SUM(chetfsumma) as sumchf FROM dognet_kalplanchf WHERE kodkalplan = '".$_ROW_dockalplan['kodkalplan']."' AND koddel<>'99'");
			$_QRY_docavans = mysqlQuery("
			SELECT * FROM dognet_docavans a
			WHERE a.koddel<>'99' AND a.koddoc = '".$_ROW_dockalplan['kodkalplan']."' AND a.dateavans <= '".$on_date."' AND a.summaavans > (SELECT coalesce(SUM(summaoplav), 0) FROM dognet_chfavans b WHERE b.dateoplav <= '".$on_date."' AND b.kodavans = a.kodavans)
			");
			//
			$_SUM_STAGE_AV = 0.0;
			$_SUM_STAGE_OST = 0.0;
			$_SUM_STAGE_OPLAV = 0.0;
			$_SUM_STAGE_CHF = $SUMCHF[0]['sumchf'];
			//
			while($_ROW_docavans = mysqli_fetch_assoc($_QRY_docavans)) {
				// Сумма зачтенных авансов
				$SUMOPLAV = $db_handle->runQuery( "SELECT coalesce(SUM(summaoplav), 0) as sumoplav FROM dognet_chfavans WHERE kodavans = '".$_ROW_docavans['kodavans']."' AND koddel<>'99'");

				$_AVDATE = ($_ROW_docavans['dateavans']!="") ? date("d.m.Y", strtotime($_ROW_docavans['dateavans'])) : "---";
				$_AVSUMMA = $_ROW_docavans['summaavans'];
				$_AVOST = $_ROW_docavans['ostatokavans'];
				$_AVCOMM = $_ROW_docavans['comment'];
				$_STAGENAME = $_ROW_dockalplan['nameshotstage'];
				$_STAGENUM = $_ROW_dockalplan['numberstage'];
				$_DATEPLAN = ($_ROW_dockalplan['dateplan']!="") ? date("d.m.Y", strtotime($_ROW_dockalplan['dateplan'])) : "---";
				$_AVOPL = ($SUMOPLAV[0]['sumoplav']!=0) ? $SUMOPLAV[0]['sumoplav'] : 0.0;
				// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
				// Задаем высоту строки и шрифт
				$activeSheet->getRowDimension($line)->setRowHeight(18);
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
				$activeSheet->setCellValue("C{$line}", $_AVSUMMA);
					$activeSheet->getStyle("C{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
				$activeSheet->setCellValue("D{$line}", $_AVDATE);
				$activeSheet->setCellValue("E{$line}", $_DATEPLAN);
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
	}
	else {
		// Сумма счетов-фактур по этапу
		$SUMCHF = $db_handle->runQuery( "SELECT SUM(chetfsumma) as sumchf FROM dognet_kalplanchf WHERE kodkalplan = '".$_ROW_docbase['koddoc']."' AND koddel<>'99'");
		$_QRY_docavans = mysqlQuery("
		SELECT * FROM dognet_docavans a
		WHERE a.koddel<>'99' AND a.koddoc = '".$_ROW_docbase['koddoc']."' AND a.dateavans <= '".$on_date."' AND a.summaavans > (SELECT coalesce(SUM(summaoplav), 0) FROM dognet_chfavans b WHERE b.dateoplav <= '".$on_date."' AND b.kodavans = a.kodavans)
		");
		//
		$_SUM_STAGE_AV = 0.0;
		$_SUM_STAGE_OST = 0.0;
		$_SUM_STAGE_OPLAV = 0.0;
		$_SUM_STAGE_CHF = $SUMCHF[0]['sumchf'];
		//
		while($_ROW_docavans = mysqli_fetch_assoc($_QRY_docavans)) {
			// Сумма зачтенных авансов
			$SUMOPLAV = $db_handle->runQuery( "SELECT coalesce(SUM(summaoplav), 0) as sumoplav FROM dognet_chfavans WHERE kodavans = '".$_ROW_docavans['kodavans']."' AND koddel<>'99'");
			$_AVDATE = ($_ROW_docavans['dateavans']!="") ? date("d.m.Y", strtotime($_ROW_docavans['dateavans'])) : "---";
			$_AVSUMMA = $_ROW_docavans['summaavans'];
			$_AVOST = $_ROW_docavans['ostatokavans'];
			$_AVCOMM = $_ROW_docavans['comment'];
			$_STAGENAME = "Без этапа";
			$_STAGENUM = "---";
			$_DATEPLAN = $_ROW_docbase['daynachdoc'].".".$_ROW_docbase['monthnachdoc'].".".$_ROW_docbase['yearnachdoc'];
			$_AVOPL = ($SUMOPLAV[0]['sumoplav']!=0) ? $SUMOPLAV[0]['sumoplav'] : 0.0;
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			// Задаем высоту строки и шрифт
			$activeSheet->getRowDimension($line)->setRowHeight(18);
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
			$activeSheet->setCellValue("C{$line}", $_AVSUMMA);
				$activeSheet->getStyle("C{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
			$activeSheet->setCellValue("D{$line}", $_AVDATE);
			$activeSheet->setCellValue("E{$line}", $_DATEPLAN);
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
	$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setSize(12);
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
	$activeSheet->setCellValue("A{$line}", "Итого по договору");
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
	$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setSize(12);
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
