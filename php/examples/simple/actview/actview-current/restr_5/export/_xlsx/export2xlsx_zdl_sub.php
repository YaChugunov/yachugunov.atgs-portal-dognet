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
$activeSheet->setTitle('Субподрядчики');
#
// Колонтитулы
$activeSheet->getHeaderFooter()->setOddHeader('&L&G&B&12СПРАВКА О ЗАДОЛЖЕННОСТИ&R&G&B&12По счетам-фактурам для договоров');
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
$_BORDER_BOTTOM_THIN = array('borders'=>array('bottom'=>array('style'=>PHPExcel_Style_Border::BORDER_THIN,'color'=>array('rgb'=>'000000'))));
$_BORDER_BOTTOM_THICK = array('borders'=>array('bottom'=>array('style'=>PHPExcel_Style_Border::BORDER_THICK,'color'=>array('rgb'=>'000000'))));
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# ФОРМАТИРУЕМ ВЫХОДНУЮ ТАБЛИЦУ EXCEL
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
// Задаем ширины столбцов
$activeSheet->getColumnDimension('A')->setWidth(3); // Пусто
$activeSheet->getColumnDimension('B')->setWidth(3); // Пусто
$activeSheet->getColumnDimension('C')->setWidth(3); // Пусто
$activeSheet->getColumnDimension('D')->setWidth(3); // Пусто
$activeSheet->getColumnDimension('E')->setWidth(65); // Организация / Договор / Этап / Субподряд / Счет-фактура
$activeSheet->getColumnDimension('F')->setWidth(15); // Дата
$activeSheet->getColumnDimension('G')->setWidth(35); // Сумма ( Договор / Счёт )
$activeSheet->getColumnDimension('H')->setWidth(35); // Сумма ( Аванс / Оплата )
$activeSheet->getColumnDimension('I')->setWidth(35); // Задолженность
#
// Для удобства заводим переменную $line, в ней будем считать номер строки
$line = 1;
#
# ----- ----- ----- ----- -----
# СТРОКА 1
# ----- ----- ----- ----- -----
// Выводим название отчета
$activeSheet->setCellValue("A{$line}", 'Текущая задолженность по субподрядчикам');
// Задаем высоту строки
$activeSheet->getRowDimension($line)->setRowHeight(32);
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:I{$line}");
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
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
$line++;
$start_table = $line;
#
#
# Шапка таблицы
$activeSheet->setCellValue("A{$line}", 'ОРГАНИЗАЦИЯ / ДОГОВОР / ЭТАП / СУБПОДРЯД / СЧЁТ-ФАКТУРА');
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:E{$line}");
$activeSheet->setCellValue("F{$line}", 'ДАТА');
$activeSheet->setCellValue("G{$line}", 'СУММА ( ДОГОВОР / СЧЁТ )');
$activeSheet->setCellValue("H{$line}", 'СУММА ( АВАНС / ОПЛАТА )');
$activeSheet->setCellValue("I{$line}", 'ЗАДОЛЖЕННОСТЬ');
// Стили для текста в шапки таблицы.
$activeSheet->getRowDimension($line)->setRowHeight(32); // высота строки
$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setSize(12); // размер шрифта
$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setBold(true); // делаем шрифт жирным
$activeSheet->getStyle("A{$line}:I{$line}")->getAlignment()->setWrapText(true); // разрешаем перенос строк в ячейке
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); // выравнивание по горизонтали - лево
$activeSheet->getStyle("B{$line}:I{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // выравнивание по горизонтали - центр
$activeSheet->getStyle("A{$line}:I{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); // вырванивание по вертикали - середина
// Делаем заливку области ячеек
$activeSheet->getStyle("A{$line}:I{$line}")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$activeSheet->getStyle("A{$line}:I{$line}")->getFill()->getStartColor()->setRGB("F1F1F1");
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
$_queryStr = "SELECT * FROM dognet_spsubpodr WHERE kodsubpodr IN (SELECT kodsubpodr FROM dognet_docsubpodr WHERE sumzadolsubpodr<>'0.00' AND koddel<>'99') ORDER BY namesubpodrshot ASC";
if (checkUserRestrictions($_SESSION['id'],'dognet',5,1)==1) {
	echo "SQL-запрос (субподрядчик): ";
	echo $_queryStr;
	echo "<br>";
}
$_QRY = mysqlQuery($_queryStr);
#
$_ZADOL_SUB = 0.00;
$_SUM_SUB_CHF = 0.00;
$_SUM_SUB_INCOMING = 0.00;
#
# Запускаем цикл LVL 1
while($_ROW = mysqli_fetch_assoc($_QRY)) {
#
#
// Задаем высоту строки и шрифт
	$activeSheet->getRowDimension($line)->setRowHeight(32);
	$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setSize(13);
	$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setBold(true);
	$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setName('Arial Narrow');
// Задаем цвет заливки строки
	$activeSheet->getStyle("A{$line}:I{$line}")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$activeSheet->getStyle("A{$line}:I{$line}")->getFill()->getStartColor()->setRGB("111111");
// Задаем цвет текста строки
	$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->getColor()->setRGB('FAFAFA');
// Выравниваем строку по вертикали ( середина )
	$activeSheet->getStyle("A{$line}:I{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:I{$line}");
// Вывод данных
	$activeSheet->setCellValue("A{$line}", $_ROW['namesubpodrshot']);
// Оформляем границы
	$activeSheet->getStyle("A{$line}:I{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
	$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
# ::::: LVL 2
#
# ЗАПРОС : Определяем набор основных договоров для которых имеются этапы (koddoc IN dognet_dockalplan), для выполнения которых заключались договора-субподряда (kodkalplan IN dognet_docsubpodr) с организациями выбранными в запросе LVL 1 (kodsubpodr='".$_ROW['kodsubpodr']), по которым имеются задолженности (sumzadolsubpodr<>'0.00')
#
	$_MAINDOC_EXIST=0;
	$_queryStr = "SELECT * FROM dognet_docbase WHERE koddoc IN (SELECT koddoc FROM dognet_dockalplan WHERE kodkalplan IN (SELECT koddoc FROM dognet_docsubpodr WHERE sumzadolsubpodr<>'0.00' AND koddel<>'99' AND kodsubpodr='".$_ROW['kodsubpodr']."'))";
	$_QRY_docbase = mysqlQuery($_queryStr);
#
#
	if (mysqli_num_rows($_QRY_docbase)>0) { $_MAINDOC_EXIST=1; }
	else { $_MAINDOC_EXIST=0; }
#
#
#
#
#
	# --- ЕСЛИ СУЩЕСТВУЕТ ОСНОВНОЙ ДОГОВОР
	if ( $_MAINDOC_EXIST == 1 ) {
	#
	# Обнуляем счетчики и локальные переменные
		$_ZADOL_DOC = 0.0;
		$_SUM_DOCS_CHF = 0.0;
		$_SUM_DOCS_INCOMING = 0.0;
		$_DENED = "";
	#
	#
	# Запускаем цикл LVL 2
		while($_ROW_docbase = mysqli_fetch_assoc($_QRY_docbase)) {
		#
		# Определяем валюту договора
			$_QRY_dened = mysqlQuery( "SELECT * FROM dognet_spdened WHERE koddened='".$_ROW_docbase['koddened']."'" );
			$_ROW_dened = mysqli_fetch_assoc($_QRY_dened);
			if ($_QRY_dened) {
				$_DENED = html_entity_decode($_ROW_dened['short_code']);
			}
			else {
				$_DENED = " -.";
			}
		#
		#
		// Задаем высоту строки и шрифт
			$activeSheet->getRowDimension($line)->setRowHeight(28);
			$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setSize(12);
			$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setBold(true); // делаем шрифт жирным
		// Задаем цвет заливки строки
			$activeSheet->getStyle("A{$line}:I{$line}")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
			$activeSheet->getStyle("A{$line}:I{$line}")->getFill()->getStartColor()->setRGB("E0E0E0");
		// Задаем цвет текста строки
			$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->getColor()->setRGB('111111');
		// Выравниваем строку по вертикали ( середина )
			$activeSheet->getStyle("A{$line}:I{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		// Объединяем ячейки по горизонтали
			$activeSheet->mergeCells("A{$line}:I{$line}");
		// Вывод данных
			if ($_ROW_docbase['kodshab']==0) {
				$activeSheet->setCellValue("A{$line}", 'Счет №'.$_ROW_docbase['docnumber']);
			}
			else {
				$activeSheet->setCellValue("A{$line}", 'Договор №3-4/'.$_ROW_docbase['docnumber']." : ".$_ROW_docbase['docnameshot']);
			}
		// Оформляем границы
			$activeSheet->getStyle("A{$line}:I{$line}")->applyFromArray($_BORDER_TOP);
			$activeSheet->getStyle("A{$line}:I{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
	$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
		# Если шаблон документа предполагает договор с календарным планом, то обращаемся к таблице календарных планов по идентификатору этапа
			if (($_ROW_docbase['kodshab']==1)OR($_ROW_docbase['kodshab']==3)) {
					$_QRY_dockalplan_Str = "SELECT * FROM dognet_dockalplan WHERE koddel<>'99' AND koddoc='".$_ROW_docbase['koddoc']."' AND kodkalplan IN (SELECT koddoc FROM dognet_docsubpodr WHERE sumzadolsubpodr<>'0.00' AND koddel<>'99' AND kodsubpodr='".$_ROW['kodsubpodr']."')";
			}
		# Если шаблон документа предполагает договор без календарного плана, то обращаемся к таблице основных договоров по идентификатору основного договора
			if (($_ROW_docbase['kodshab']==2)OR($_ROW_docbase['kodshab']==4)) {
					$_QRY_dockalplan_Str = "SELECT * FROM dognet_docbase WHERE koddel<>'99' AND numberchet='' AND koddoc='".$_ROW_docbase['koddoc']."' AND (kodshab='2' OR kodshab='4') AND koddoc IN (SELECT koddoc FROM dognet_docsubpodr WHERE sumzadolsubpodr<>'0.00' AND koddel<>'99' AND kodsubpodr='".$_ROW['kodsubpodr']."')";
			}
		# Если шаблон документа это счет (numberchet<>''), то обращаемся к таблице основных договоров также по идентификатору основного договора
			if ($_ROW_docbase['kodshab']==0) {
					$_QRY_dockalplan_Str = "SELECT * FROM dognet_docbase WHERE koddel<>'99' AND numberchet<>'' AND koddoc='".$_ROW_docbase['koddoc']."' AND kodshab='0' AND koddoc IN (SELECT koddoc FROM dognet_docsubpodr WHERE sumzadolsubpodr<>'0.00' AND koddel<>'99' AND kodsubpodr='".$_ROW['kodsubpodr']."')";
			}
			$_QRY_dockalplan = mysqlQuery($_QRY_dockalplan_Str);
		#
		#
		# Обнуляем счетчик
		// Сумма всех выставленных счетов-фактур по этапу
			$_ZADOL_DOCSSUB = 0.0;
			$_SUM_DOC_CHF = 0.0;
			$_SUM_DOC_INCOMING = 0.0;
		#
		#
		# Запускаем цикл LVL 3
			while($_ROW_dockalplan = mysqli_fetch_assoc($_QRY_dockalplan)) {
			#
			# Выводим номер и название этапа (либо запись о том, что этап не создавался)
			// Задаем высоту строки и шрифт
				$activeSheet->getRowDimension($line)->setRowHeight(28);
				$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setSize(11);
				$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setBold(false);
			// Задаем цвет текста строки
				$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->getColor()->setRGB('111111');
			// Выравниваем строку по вертикали ( середина )
				$activeSheet->getStyle("A{$line}:I{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			// Объединяем ячейки по горизонтали
				$activeSheet->mergeCells("B{$line}:I{$line}");
			// Вывод данных
				$activeSheet->setCellValue("A{$line}", '');
				if (($_ROW_docbase['kodshab']==1)OR($_ROW_docbase['kodshab']==3)) {
					$activeSheet->setCellValue("B{$line}", 'Этап '.$_ROW_dockalplan['numberstage']." : ".$_ROW_dockalplan['nameshotstage']);
				}
				elseif (($_ROW_docbase['kodshab']==0)OR($_ROW_docbase['kodshab']==2)OR($_ROW_docbase['kodshab']==4)) {
					$activeSheet->setCellValue("B{$line}", 'Без этапа');
				}
			// Оформляем границы
				$activeSheet->getStyle("A{$line}:I{$line}")->applyFromArray($_BORDER_TOP);
				$activeSheet->getStyle("A{$line}:I{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
			#
			#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
	$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			#
			#
			# ДОГОВОРА СУБПОДРЯДА
			# LVL 4 ::: BEGIN
			# Эстафетный параметр - идентификатор этапа (kodkalplan)
			#
			/*
			!!!!!
			В таблице договоров субподряда поле koddoc может содержать как идентификатор договора (koddoc) из таблицы dognet_docbase (для договоров без календарного плана), так и идентификатор этапа (kodkalplan) из таблицы dognet_dockalplan (для договоров с календарным планом).
			!!!!!
			*/
			#
			# Все договора субподряда из таблицы 'dognet_docsubpodr', в которых
			# 	- есть задолженность (sumzadolsubpodr<>'0.00')
			#		- не исключены из выборки (koddel<>'99')
			# 	- в которых идентификатор попадает в выборку данного этапа - $_ROW_dockalplan['kodkalplan']
			#
			#
				$_QRY_docsubpodr_Str = "SELECT * FROM dognet_docsubpodr WHERE sumzadolsubpodr<>'0.00' AND koddel<>'99' AND koddoc='".$_ROW_dockalplan['kodkalplan']."' AND kodsubpodr='".$_ROW['kodsubpodr']."'";
				$_QRY_docsubpodr = mysqlQuery($_QRY_docsubpodr_Str);
			#
			#
			# Обнуляем счетчик
			// Сумма всех выставленных счетов-фактур по всем договорам субподряда данного этапа
				$_ZADOL_DOCSUB = 0.0;
				$_SUM_DOCSSUB_CHF = 0.0;
				$_SUM_DOCSSUB_INCOMING = 0.0;
			#
			#
			# Запускаем цикл LVL 4
				while($_ROW_docsubpodr = mysqli_fetch_assoc($_QRY_docsubpodr)) {
				#
				# Выводим номер и название договора субподряда (либо запись о том, что он отсутствует)
				// Задаем высоту строки и шрифт
					$activeSheet->getRowDimension($line)->setRowHeight(22);
					$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setSize(10);
					$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setBold(false);
				// Выравниваем строку по вертикали ( середина )
					$activeSheet->getStyle("A{$line}:I{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				// Объединяем ячейки по горизонтали
					$activeSheet->mergeCells("C{$line}:I{$line}");
				// Вывод данных
					$activeSheet->setCellValue("A{$line}", '');
					$activeSheet->setCellValue("B{$line}", '');
					if ($_ROW_docsubpodr['numberdocsubpodr']!="") {
					// Задаем цвет текста строки
						$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->getColor()->setRGB('111111');
						$activeSheet->setCellValue("C{$line}", 'Договор субподряда № '.$_ROW_docsubpodr['numberdocsubpodr']);
					}
					else {
					// Задаем цвет текста строки
						$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->getColor()->setRGB('999999');
					// Делаем шрифт курсивным
						$activeSheet->getStyle("C{$line}")->getFont()->setItalic(true);
						$activeSheet->setCellValue("C{$line}", 'Номер договора субподряда отсутствует или не задан');
					}
				// Оформляем границы
					$activeSheet->getStyle("A{$line}:I{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
				#
				#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
	$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
				#
				#
				# СЧЕТА-ФАКТУРЫ
				# LVL 5 ::: BEGIN
				# Эстафетный параметр - идентификатор договора субподряда (koddocsubpodr)
				# Все счета-фатуры к договорам субподряда из таблицы 'dognet_docchfsubpodr', в которых
				# 	- есть задолженность (sumzadolsubpodr<>'0.00')
				#		- не исключены из выборки (koddel<>'99')
				# 	- в которых идентификатор попадает в выборку данного этапа - $_ROW_dockalplan['kodkalplan']
				#
				#
					$_QRY_docchfsubpodr_Str = "SELECT * FROM dognet_docchfsubpodr WHERE koddel<>'99' AND koddocsubpodr='".$_ROW_docsubpodr['koddocsubpodr']."' AND sumzadolchfsubpodr<>'0.00'";
					$_QRY_docchfsubpodr = mysqlQuery($_QRY_docchfsubpodr_Str);
				#
				#
				# Обнуляем счетчик
				// Сумма всех выставленных счетов-фактур по отдельному договору субподряда
					$_ZADOL_CHF = 0.0;
					$_SUM_DOCSUB_CHF = 0.0;
					$_SUM_DOCSUB_INCOMING = 0.0;
				#
				#
				# Запускаем цикл LVL 5
					while($_ROW_docchfsubpodr = mysqli_fetch_assoc($_QRY_docchfsubpodr)) {
					#
					# Выводим номер и название договора субподряда (либо запись о том, что он отсутствует)
					// Задаем высоту строки и шрифт
						$activeSheet->getRowDimension($line)->setRowHeight(22);
						$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setSize(10);
						$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setBold(false);
					// Задаем цвет текста строки
						$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->getColor()->setRGB('111111');
					// Выравниваем строку по вертикали ( середина )
						$activeSheet->getStyle("A{$line}:I{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					// Выравниваем ячейку по горизонтали
						$activeSheet->getStyle("D{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
						$activeSheet->getStyle("F{$line}:I{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					// Объединяем ячейки по горизонтали
						$activeSheet->mergeCells("D{$line}:E{$line}");
					// Вывод данных
						$activeSheet->setCellValue("A{$line}", '');
						$activeSheet->setCellValue("B{$line}", '');
						$activeSheet->setCellValue("C{$line}", '');
						$activeSheet->setCellValue("D{$line}", 'Счет-фактура №'.$_ROW_docchfsubpodr['numberchfsubpodr']);
						$activeSheet->setCellValue("F{$line}", date("d.m.Y", strtotime($_ROW_docchfsubpodr['datechfsubpodr'])));
						$activeSheet->setCellValue("G{$line}", number_format($_ROW_docchfsubpodr['sumchfsubpodr'], 2, '.', ' ').$_DENED);
						$activeSheet->setCellValue("H{$line}", '');
						$activeSheet->setCellValue("I{$line}", '');
					// Оформляем границы
						$activeSheet->getStyle("A{$line}:I{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
						$activeSheet->getStyle("D{$line}:I{$line}")->applyFromArray($_BORDER_INSIDE);
					#
					#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
	$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
					#
					#
					# ОПЛАТЫ И АВАНСЫ
					# LVL 6 ::: BEGIN
					# Эстафетный параметр - идентификатор счета-фактуры (kodchfsubpodr)
					# Все оплаты и авансы по счетам-фатурам из таблицы 'dognet_reports_zadolsub_chfincoming', в которых
					#
					#
						$_QRY_chfincoming_Str = "SELECT * FROM dognet_reports_zadolsub_chfincoming WHERE kodchfsubpodr='".$_ROW_docchfsubpodr['kodchfsubpodr']."' AND (type_incoming='1' OR type_incoming='2')";
						$_QRY_chfincoming = mysqlQuery($_QRY_chfincoming_Str);
						#
						# Обнуляем счетчик
						// Сумма всех выставленных счетов-фактур по отдельному договору субподряда
							$_SUM_CHF_INCOMING = 0.0;
						#
						if (mysqli_num_rows($_QRY_chfincoming) <= 0) {
						#
						# Выводим номер и название договора субподряда (либо запись о том, что он отсутствует)
						// Задаем высоту строки и шрифт
							$activeSheet->getRowDimension($line)->setRowHeight(22);
							$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setSize(10);
							$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setBold(false);
						// Задаем цвет текста строки
							$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->getColor()->setRGB('999999');
						// Выравниваем строку по вертикали ( середина )
							$activeSheet->getStyle("A{$line}:I{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						// Объединяем ячейки по горизонтали
							$activeSheet->mergeCells("D{$line}:I{$line}");
						// Делаем шрифт курсивным
							$activeSheet->getStyle("D{$line}")->getFont()->setItalic(true);
						// Вывод данных
							$activeSheet->setCellValue("A{$line}", '');
							$activeSheet->setCellValue("B{$line}", '');
							$activeSheet->setCellValue("C{$line}", '');
							$activeSheet->setCellValue("D{$line}", 'Оплат и авансов не поступало');
						// Оформляем границы
							$activeSheet->getStyle("A{$line}:I{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
	$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
						}
						else {
						#
						# Запускаем цикл LVL 6
							while($_ROW_chfincoming = mysqli_fetch_assoc($_QRY_chfincoming)) {
							# Если ОПЛАТА
								if ($_ROW_chfincoming['type_incoming']=='1') {
								#
								# Выводим номер и название договора субподряда (либо запись о том, что он отсутствует)
								// Задаем высоту строки и шрифт
									$activeSheet->getRowDimension($line)->setRowHeight(22);
									$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setSize(10);
									$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setBold(false);
								// Задаем цвет текста строки
									$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->getColor()->setRGB('333333');
								// Выравниваем строку по вертикали ( середина )
									$activeSheet->getStyle("A{$line}:I{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
								// Выравниваем ячейку по горизонтали
									$activeSheet->getStyle("D{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
									$activeSheet->getStyle("F{$line}:I{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
								// Объединяем ячейки по горизонтали
									$activeSheet->mergeCells("D{$line}:E{$line}");
								// Вывод данных
									$activeSheet->setCellValue("A{$line}", '');
									$activeSheet->setCellValue("B{$line}", '');
									$activeSheet->setCellValue("C{$line}", '');
									$activeSheet->setCellValue("D{$line}", 'Оплата');
									$activeSheet->setCellValue("F{$line}", date("d.m.Y", strtotime($_ROW_chfincoming['date_incoming'])));
									$activeSheet->setCellValue("G{$line}", '');
									$activeSheet->setCellValue("H{$line}", number_format($_ROW_chfincoming['sum_incoming'], 2, '.', ' ').$_DENED);
									$activeSheet->setCellValue("I{$line}", '');
								}
								elseif ($_ROW_chfincoming['type_incoming']=='2') {
								#
								# Выводим номер и название договора субподряда (либо запись о том, что он отсутствует)
								// Задаем высоту строки и шрифт
									$activeSheet->getRowDimension($line)->setRowHeight(22);
									$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setSize(10);
									$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setBold(false);
								// Задаем цвет текста строки
									$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->getColor()->setRGB('333333');
								// Выравниваем строку по вертикали ( середина )
									$activeSheet->getStyle("A{$line}:I{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
								// Выравниваем ячейку по горизонтали
									$activeSheet->getStyle("D{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
									$activeSheet->getStyle("F{$line}:I{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
								// Объединяем ячейки по горизонтали
									$activeSheet->mergeCells("D{$line}:E{$line}");
								// Вывод данных
									$activeSheet->setCellValue("A{$line}", '');
									$activeSheet->setCellValue("B{$line}", '');
									$activeSheet->setCellValue("C{$line}", '');
									$activeSheet->setCellValue("D{$line}", 'Аванс');
									$activeSheet->setCellValue("F{$line}", date("d.m.Y", strtotime($_ROW_chfincoming['date_incoming'])));
									$activeSheet->setCellValue("G{$line}", '');
									$activeSheet->setCellValue("H{$line}", number_format($_ROW_chfincoming['sum_incoming'], 2, '.', ' ').$_DENED);
									$activeSheet->setCellValue("I{$line}", '');
								}
								// Оформляем границы
									$activeSheet->getStyle("A{$line}:I{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
									$activeSheet->getStyle("D{$line}:I{$line}")->applyFromArray($_BORDER_INSIDE);
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
	$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
							// +++ Суммируем оплаты и авансы по счету
								$_SUM_CHF_INCOMING += $_ROW_chfincoming['sum_incoming'];
							#
							#
							}
						}
					# // LVL 6
					#
					#
					#
					# --- Задолженность по счету-фактуре (разность суммы счета и поступлений - авансов и оплат)
						$_ZADOL_CHF = $_ROW_docchfsubpodr['sumchfsubpodr'] - $_SUM_CHF_INCOMING;
					# +++ Суммируем все счета-фактуры по отдельному договору субподряда
						$_SUM_DOCSUB_CHF += $_ROW_docchfsubpodr['sumchfsubpodr'];
					# +++ Суммируем поступления по всем счетам-фактурам по отдельному договору субподряда
						$_SUM_DOCSUB_INCOMING += $_SUM_CHF_INCOMING;
					#
					#
					#
					# Выводим номер и название договора субподряда (либо запись о том, что он отсутствует)
					// Задаем высоту строки и шрифт
						$activeSheet->getRowDimension($line)->setRowHeight(22);
						$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setSize(10);
						$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setBold(true);
					// Задаем цвет текста строки
						$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->getColor()->setRGB('111111');
					// Выравниваем строку по вертикали ( середина )
						$activeSheet->getStyle("A{$line}:I{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					// Выравниваем ячейку по горизонтали
						$activeSheet->getStyle("C{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
						$activeSheet->getStyle("G{$line}:I{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					// Объединяем ячейки по горизонтали
						$activeSheet->mergeCells("C{$line}:F{$line}");
					// Вывод данных
						$activeSheet->setCellValue("A{$line}", '');
						$activeSheet->setCellValue("B{$line}", '');
						$activeSheet->setCellValue("C{$line}", 'Итого по счету');
						$activeSheet->setCellValue("G{$line}", number_format($_ROW_docchfsubpodr['sumchfsubpodr'], 2, '.', ' ').$_DENED);
						$activeSheet->setCellValue("H{$line}", number_format($_SUM_CHF_INCOMING, 2, '.', ' ').$_DENED);
						$activeSheet->setCellValue("I{$line}", number_format($_ZADOL_CHF, 2, '.', ' ').$_DENED);
					// Оформляем границы
						$activeSheet->getStyle("A{$line}:I{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
						$activeSheet->getStyle("C{$line}:I{$line}")->applyFromArray($_BORDER_INSIDE);
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
	$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
					} // LVL 5
				#
				#
				#
				# --- Задолженность по отдельному договору субподряда (разность суммы счетов-фактур и поступлений - авансов и оплат)
					$_ZADOL_DOCSUB = $_SUM_DOCSUB_CHF - $_SUM_DOCSUB_INCOMING;
				# +++ Суммируем счета-фактуры по всем договорам субподряда отдельного этапа
					$_SUM_DOCSSUB_CHF += $_SUM_DOCSUB_CHF;
				# +++ Суммируем поступления по всем договорам субподряда отдельного этапа
					$_SUM_DOCSSUB_INCOMING += $_SUM_DOCSUB_INCOMING;
				#
				#
				#
				# Выводим номер и название договора субподряда (либо запись о том, что он отсутствует)
				// Задаем высоту строки и шрифт
					$activeSheet->getRowDimension($line)->setRowHeight(22);
					$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setSize(10);
					$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setBold(true);
				// Задаем цвет текста строки
					$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->getColor()->setRGB('111111');
				// Выравниваем строку по вертикали ( середина )
					$activeSheet->getStyle("A{$line}:I{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				// Выравниваем ячейку по горизонтали
					$activeSheet->getStyle("C{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
					$activeSheet->getStyle("G{$line}:I{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				// Объединяем ячейки по горизонтали
					$activeSheet->mergeCells("C{$line}:F{$line}");
				// Вывод данных
					$activeSheet->setCellValue("A{$line}", '');
					$activeSheet->setCellValue("B{$line}", '');
					$activeSheet->setCellValue("C{$line}", 'Итого по договору субподряда');
					$activeSheet->setCellValue("G{$line}", number_format($_SUM_DOCSUB_CHF, 2, '.', ' ').$_DENED);
					$activeSheet->setCellValue("H{$line}", number_format($_SUM_DOCSUB_INCOMING, 2, '.', ' ').$_DENED);
					$activeSheet->setCellValue("I{$line}", number_format($_ZADOL_DOCSUB, 2, '.', ' ').$_DENED);
				// Оформляем границы
					$activeSheet->getStyle("A{$line}:I{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
					$activeSheet->getStyle("C{$line}:I{$line}")->applyFromArray($_BORDER_INSIDE);
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
	$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
				} // LVL 4
			#
			#
			#
			# --- Задолженность по всем договорам субподряда (разность суммы счетов-фактур и поступлений - авансов и оплат) отдельного этапа
				$_ZADOL_DOCSSUB = $_SUM_DOCSSUB_CHF - $_SUM_DOCSSUB_INCOMING;
			# +++ Суммируем счета-фактуры по всем договорам субподряда отдельного основного договора
				$_SUM_DOC_CHF += $_SUM_DOCSSUB_CHF;
			# +++ Суммируем поступления по всем договорам субподряда отдельного основного договора
				$_SUM_DOC_INCOMING += $_SUM_DOCSSUB_INCOMING;
			#
			#
			#
			} // LVL 3
		#
		#
		#
		# --- Задолженность по всем договорам субподряда (разность суммы счетов-фактур и поступлений - авансов и оплат) отдельного основного договора
			$_ZADOL_DOC = $_SUM_DOC_CHF - $_SUM_DOC_INCOMING;
		# +++ Суммируем счета-фактуры по всем договорам отдельного субподрядчика
			$_SUM_DOCS_CHF += $_SUM_DOC_CHF;
		# +++ Суммируем поступления по всем договорам отдельного субподрядчика
			$_SUM_DOCS_INCOMING += $_SUM_DOC_INCOMING;
		#
		#
		#
		# Выводим номер и название договора субподряда (либо запись о том, что он отсутствует)
		// Задаем высоту строки и шрифт
			$activeSheet->getRowDimension($line)->setRowHeight(28);
			$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setSize(12);
			$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setBold(true);
		// Задаем цвет текста строки
			$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->getColor()->setRGB('111111');
		// Выравниваем строку по вертикали ( середина )
			$activeSheet->getStyle("A{$line}:I{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		// Выравниваем ячейку по горизонтали
			$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$activeSheet->getStyle("G{$line}:I{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		// Объединяем ячейки по горизонтали
			$activeSheet->mergeCells("A{$line}:F{$line}");
		// Вывод данных
			if ($_ROW_docbase['kodshab']==0) {
				$activeSheet->setCellValue("A{$line}", 'Итого по счету');
		  }
		  else {
				$activeSheet->setCellValue("A{$line}", 'Итого по основному договору');
		  }
			$activeSheet->setCellValue("G{$line}", number_format($_SUM_DOC_CHF, 2, '.', ' ').$_DENED);
			$activeSheet->setCellValue("H{$line}", number_format($_SUM_DOC_INCOMING, 2, '.', ' ').$_DENED);
			$activeSheet->setCellValue("I{$line}", number_format($_ZADOL_DOC, 2, '.', ' ').$_DENED);
		// Оформляем границы
			$activeSheet->getStyle("A{$line}:I{$line}")->applyFromArray($_BORDER_INSIDE);
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
	$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		} // LVL 2
	#
	}
	# --- ЕСЛИ СУЩЕСТВУЕТ ОСНОВНОЙ ДОГОВОР
#
#
#
#
#
	# --- ЕСЛИ НЕ СУЩЕСТВУЕТ ОСНОВНОЙ ДОГОВОР
	if ( $_MAINDOC_EXIST == 0 ) {
	#
	# Обнуляем счетчики и локальные переменные
		$_ZADOL_DOC = 0.0;
		$_SUM_DOCS_CHF = 0.0;
		$_SUM_DOCS_INCOMING = 0.0;
		$_DENED = " р.";
	#
	#
	// Задаем высоту строки и шрифт
		$activeSheet->getRowDimension($line)->setRowHeight(28);
		$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setSize(12);
		$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setBold(true); // делаем шрифт жирным
	// Задаем цвет заливки строки
		$activeSheet->getStyle("A{$line}:I{$line}")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$activeSheet->getStyle("A{$line}:I{$line}")->getFill()->getStartColor()->setRGB("E0E0E0");
	// Задаем цвет текста строки
		$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->getColor()->setRGB('111111');
	// Выравниваем строку по вертикали ( середина )
		$activeSheet->getStyle("A{$line}:I{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	// Объединяем ячейки по горизонтали
		$activeSheet->mergeCells("A{$line}:I{$line}");
	// Вывод данных
		$activeSheet->setCellValue("A{$line}", 'Основной договор не найден либо отсутствует');
	// Оформляем границы
		$activeSheet->getStyle("A{$line}:I{$line}")->applyFromArray($_BORDER_TOP);
		$activeSheet->getStyle("A{$line}:I{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
	$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
	#
	# Обнуляем счетчик
	// Сумма всех выставленных счетов-фактур по этапу
		$_ZADOL_DOCSSUB = 0.0;
		$_SUM_DOC_CHF = 0.0;
		$_SUM_DOC_INCOMING = 0.0;
	#
	#
	# Выводим номер и название этапа (либо запись о том, что этап не создавался)
	// Задаем высоту строки и шрифт
		$activeSheet->getRowDimension($line)->setRowHeight(28);
		$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setSize(11);
		$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setBold(false);
	// Задаем цвет текста строки
		$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->getColor()->setRGB('111111');
	// Выравниваем строку по вертикали ( середина )
		$activeSheet->getStyle("A{$line}:I{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	// Объединяем ячейки по горизонтали
		$activeSheet->mergeCells("B{$line}:I{$line}");
	// Вывод данных
		$activeSheet->setCellValue("A{$line}", '');
		$activeSheet->setCellValue("B{$line}", 'Без этапа');
	// Оформляем границы
		$activeSheet->getStyle("A{$line}:I{$line}")->applyFromArray($_BORDER_TOP);
		$activeSheet->getStyle("A{$line}:I{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
	#
	#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
	$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
# ДОГОВОРА СУБПОДРЯДА
# LVL 4 ::: BEGIN
# Договор субподряда выбираем только по идентификатору Подрядчика и наличию задолженности
#
#
			$_QRY_docsubpodr_Str = "SELECT * FROM dognet_docsubpodr WHERE sumzadolsubpodr<>'0.00' AND koddel<>'99' AND kodsubpodr='".$_ROW['kodsubpodr']."'";
			$_QRY_docsubpodr = mysqlQuery($_QRY_docsubpodr_Str);
			#
			#
			# Обнуляем счетчик
			// Сумма всех выставленных счетов-фактур по всем договорам субподряда данного этапа
				$_ZADOL_DOCSUB = 0.0;
				$_SUM_DOCSSUB_CHF = 0.0;
				$_SUM_DOCSSUB_INCOMING = 0.0;
			#
			#
			# Запускаем цикл LVL 4
				while($_ROW_docsubpodr = mysqli_fetch_assoc($_QRY_docsubpodr)) {
				#
				# Выводим номер и название договора субподряда (либо запись о том, что он отсутствует)
				// Задаем высоту строки и шрифт
					$activeSheet->getRowDimension($line)->setRowHeight(22);
					$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setSize(10);
					$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setBold(false);
				// Выравниваем строку по вертикали ( середина )
					$activeSheet->getStyle("A{$line}:I{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				// Объединяем ячейки по горизонтали
					$activeSheet->mergeCells("C{$line}:I{$line}");
				// Вывод данных
					$activeSheet->setCellValue("A{$line}", '');
					$activeSheet->setCellValue("B{$line}", '');
					if ($_ROW_docsubpodr['numberdocsubpodr']!="") {
					// Задаем цвет текста строки
						$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->getColor()->setRGB('111111');
						$activeSheet->setCellValue("C{$line}", 'Договор субподряда № '.$_ROW_docsubpodr['numberdocsubpodr']);
					}
					else {
					// Задаем цвет текста строки
						$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->getColor()->setRGB('999999');
					// Делаем шрифт курсивным
						$activeSheet->getStyle("C{$line}")->getFont()->setItalic(true);
						$activeSheet->setCellValue("C{$line}", 'Номер договора субподряда отсутствует или не задан');
					}
				// Оформляем границы
					$activeSheet->getStyle("A{$line}:I{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
				#
				#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
	$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
				#
				#
				# СЧЕТА-ФАКТУРЫ
				# LVL 5 ::: BEGIN
				# Эстафетный параметр - идентификатор договора субподряда (koddocsubpodr)
				# Все счета-фатуры к договорам субподряда из таблицы 'dognet_docchfsubpodr', в которых
				# 	- есть задолженность (sumzadolsubpodr<>'0.00')
				#		- не исключены из выборки (koddel<>'99')
				# 	- в которых идентификатор попадает в выборку данного этапа - $_ROW_dockalplan['kodkalplan']
				#
				#
					$_QRY_docchfsubpodr_Str = "SELECT * FROM dognet_docchfsubpodr WHERE koddel<>'99' AND koddocsubpodr='".$_ROW_docsubpodr['koddocsubpodr']."' AND sumzadolchfsubpodr<>'0.00'";
					$_QRY_docchfsubpodr = mysqlQuery($_QRY_docchfsubpodr_Str);
				#
				#
				# Обнуляем счетчик
				// Сумма всех выставленных счетов-фактур по отдельному договору субподряда
					$_ZADOL_CHF = 0.0;
					$_SUM_DOCSUB_CHF = 0.0;
					$_SUM_DOCSUB_INCOMING = 0.0;
				#
				#
				# Запускаем цикл LVL 5
					while($_ROW_docchfsubpodr = mysqli_fetch_assoc($_QRY_docchfsubpodr)) {
					#
					# Выводим номер и название договора субподряда (либо запись о том, что он отсутствует)
					// Задаем высоту строки и шрифт
						$activeSheet->getRowDimension($line)->setRowHeight(22);
						$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setSize(10);
						$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setBold(false);
					// Задаем цвет текста строки
						$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->getColor()->setRGB('111111');
					// Выравниваем строку по вертикали ( середина )
						$activeSheet->getStyle("A{$line}:I{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					// Выравниваем ячейку по горизонтали
						$activeSheet->getStyle("D{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
						$activeSheet->getStyle("F{$line}:I{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					// Объединяем ячейки по горизонтали
						$activeSheet->mergeCells("D{$line}:E{$line}");
					// Вывод данных
						$activeSheet->setCellValue("A{$line}", '');
						$activeSheet->setCellValue("B{$line}", '');
						$activeSheet->setCellValue("C{$line}", '');
						$activeSheet->setCellValue("D{$line}", 'Счет-фактура №'.$_ROW_docchfsubpodr['numberchfsubpodr']);
						$activeSheet->setCellValue("F{$line}", date("d.m.Y", strtotime($_ROW_docchfsubpodr['datechfsubpodr'])));
						$activeSheet->setCellValue("G{$line}", number_format($_ROW_docchfsubpodr['sumchfsubpodr'], 2, '.', ' ').$_DENED);
						$activeSheet->setCellValue("H{$line}", '');
						$activeSheet->setCellValue("I{$line}", '');
					// Оформляем границы
						$activeSheet->getStyle("A{$line}:I{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
						$activeSheet->getStyle("D{$line}:I{$line}")->applyFromArray($_BORDER_INSIDE);
					#
					#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
	$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
					#
					#
					# ОПЛАТЫ И АВАНСЫ
					# LVL 6 ::: BEGIN
					# Эстафетный параметр - идентификатор счета-фактуры (kodchfsubpodr)
					# Все оплаты и авансы по счетам-фатурам из таблицы 'dognet_reports_zadolsub_chfincoming', в которых
					#
					#
						$_QRY_chfincoming_Str = "SELECT * FROM dognet_reports_zadolsub_chfincoming WHERE kodchfsubpodr='".$_ROW_docchfsubpodr['kodchfsubpodr']."' AND (type_incoming='1' OR type_incoming='2')";
						$_QRY_chfincoming = mysqlQuery($_QRY_chfincoming_Str);
						#
						# Обнуляем счетчик
						// Сумма всех выставленных счетов-фактур по отдельному договору субподряда
							$_SUM_CHF_INCOMING = 0.0;
						#
						if (mysqli_num_rows($_QRY_chfincoming) <= 0) {
						#
						# Выводим номер и название договора субподряда (либо запись о том, что он отсутствует)
						// Задаем высоту строки и шрифт
							$activeSheet->getRowDimension($line)->setRowHeight(22);
							$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setSize(10);
							$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setBold(false);
						// Задаем цвет текста строки
							$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->getColor()->setRGB('999999');
						// Выравниваем строку по вертикали ( середина )
							$activeSheet->getStyle("A{$line}:I{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						// Объединяем ячейки по горизонтали
							$activeSheet->mergeCells("D{$line}:I{$line}");
						// Делаем шрифт курсивным
							$activeSheet->getStyle("D{$line}")->getFont()->setItalic(true);
						// Вывод данных
							$activeSheet->setCellValue("A{$line}", '');
							$activeSheet->setCellValue("B{$line}", '');
							$activeSheet->setCellValue("C{$line}", '');
							$activeSheet->setCellValue("D{$line}", 'Оплат и авансов не поступало');
						// Оформляем границы
							$activeSheet->getStyle("A{$line}:I{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
	$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
						}
						else {
						#
						# Запускаем цикл LVL 6
							while($_ROW_chfincoming = mysqli_fetch_assoc($_QRY_chfincoming)) {
							# Если ОПЛАТА
								if ($_ROW_chfincoming['type_incoming']=='1') {
								#
								# Выводим номер и название договора субподряда (либо запись о том, что он отсутствует)
								// Задаем высоту строки и шрифт
									$activeSheet->getRowDimension($line)->setRowHeight(22);
									$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setSize(10);
									$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setBold(false);
								// Задаем цвет текста строки
									$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->getColor()->setRGB('333333');
								// Выравниваем строку по вертикали ( середина )
									$activeSheet->getStyle("A{$line}:I{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
								// Выравниваем ячейку по горизонтали
									$activeSheet->getStyle("D{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
									$activeSheet->getStyle("F{$line}:I{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
								// Объединяем ячейки по горизонтали
									$activeSheet->mergeCells("D{$line}:E{$line}");
								// Вывод данных
									$activeSheet->setCellValue("A{$line}", '');
									$activeSheet->setCellValue("B{$line}", '');
									$activeSheet->setCellValue("C{$line}", '');
									$activeSheet->setCellValue("D{$line}", 'Оплата');
									$activeSheet->setCellValue("F{$line}", date("d.m.Y", strtotime($_ROW_chfincoming['date_incoming'])));
									$activeSheet->setCellValue("G{$line}", '');
									$activeSheet->setCellValue("H{$line}", number_format($_ROW_chfincoming['sum_incoming'], 2, '.', ' ').$_DENED);
									$activeSheet->setCellValue("I{$line}", '');
								}
								elseif ($_ROW_chfincoming['type_incoming']=='2') {
								#
								# Выводим номер и название договора субподряда (либо запись о том, что он отсутствует)
								// Задаем высоту строки и шрифт
									$activeSheet->getRowDimension($line)->setRowHeight(22);
									$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setSize(10);
									$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setBold(false);
								// Задаем цвет текста строки
									$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->getColor()->setRGB('333333');
								// Выравниваем строку по вертикали ( середина )
									$activeSheet->getStyle("A{$line}:I{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
								// Выравниваем ячейку по горизонтали
									$activeSheet->getStyle("D{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
									$activeSheet->getStyle("F{$line}:I{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
								// Объединяем ячейки по горизонтали
									$activeSheet->mergeCells("D{$line}:E{$line}");
								// Вывод данных
									$activeSheet->setCellValue("A{$line}", '');
									$activeSheet->setCellValue("B{$line}", '');
									$activeSheet->setCellValue("C{$line}", '');
									$activeSheet->setCellValue("D{$line}", 'Аванс');
									$activeSheet->setCellValue("F{$line}", date("d.m.Y", strtotime($_ROW_chfincoming['date_incoming'])));
									$activeSheet->setCellValue("G{$line}", '');
									$activeSheet->setCellValue("H{$line}", number_format($_ROW_chfincoming['sum_incoming'], 2, '.', ' ').$_DENED);
									$activeSheet->setCellValue("I{$line}", '');
								}
								// Оформляем границы
									$activeSheet->getStyle("A{$line}:I{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
									$activeSheet->getStyle("D{$line}:I{$line}")->applyFromArray($_BORDER_INSIDE);
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
	$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
							// +++ Суммируем оплаты и авансы по счету
								$_SUM_CHF_INCOMING += $_ROW_chfincoming['sum_incoming'];
							#
							#
							}
						}
					# // LVL 6
					#
					#
					#
					# --- Задолженность по счету-фактуре (разность суммы счета и поступлений - авансов и оплат)
						$_ZADOL_CHF = $_ROW_docchfsubpodr['sumchfsubpodr'] - $_SUM_CHF_INCOMING;
					# +++ Суммируем все счета-фактуры по отдельному договору субподряда
						$_SUM_DOCSUB_CHF += $_ROW_docchfsubpodr['sumchfsubpodr'];
					# +++ Суммируем поступления по всем счетам-фактурам по отдельному договору субподряда
						$_SUM_DOCSUB_INCOMING += $_SUM_CHF_INCOMING;
					#
					#
					#
					# Выводим номер и название договора субподряда (либо запись о том, что он отсутствует)
					// Задаем высоту строки и шрифт
						$activeSheet->getRowDimension($line)->setRowHeight(22);
						$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setSize(10);
						$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setBold(true);
					// Задаем цвет текста строки
						$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->getColor()->setRGB('111111');
					// Выравниваем строку по вертикали ( середина )
						$activeSheet->getStyle("A{$line}:I{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					// Выравниваем ячейку по горизонтали
						$activeSheet->getStyle("C{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
						$activeSheet->getStyle("G{$line}:I{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					// Объединяем ячейки по горизонтали
						$activeSheet->mergeCells("C{$line}:F{$line}");
					// Вывод данных
						$activeSheet->setCellValue("A{$line}", '');
						$activeSheet->setCellValue("B{$line}", '');
						$activeSheet->setCellValue("C{$line}", 'Итого по счету');
						$activeSheet->setCellValue("G{$line}", number_format($_ROW_docchfsubpodr['sumchfsubpodr'], 2, '.', ' ').$_DENED);
						$activeSheet->setCellValue("H{$line}", number_format($_SUM_CHF_INCOMING, 2, '.', ' ').$_DENED);
						$activeSheet->setCellValue("I{$line}", number_format($_ZADOL_CHF, 2, '.', ' ').$_DENED);
					// Оформляем границы
						$activeSheet->getStyle("A{$line}:I{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
						$activeSheet->getStyle("C{$line}:I{$line}")->applyFromArray($_BORDER_INSIDE);
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
	$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
					} // LVL 5
				#
				#
				#
				# --- Задолженность по отдельному договору субподряда (разность суммы счетов-фактур и поступлений - авансов и оплат)
					$_ZADOL_DOCSUB = $_SUM_DOCSUB_CHF - $_SUM_DOCSUB_INCOMING;
				# +++ Суммируем счета-фактуры по всем договорам субподряда отдельного этапа
					$_SUM_DOCSSUB_CHF += $_SUM_DOCSUB_CHF;
				# +++ Суммируем поступления по всем договорам субподряда отдельного этапа
					$_SUM_DOCSSUB_INCOMING += $_SUM_DOCSUB_INCOMING;
				#
				#
				#
				# Выводим номер и название договора субподряда (либо запись о том, что он отсутствует)
				// Задаем высоту строки и шрифт
					$activeSheet->getRowDimension($line)->setRowHeight(22);
					$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setSize(10);
					$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setBold(true);
				// Задаем цвет текста строки
					$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->getColor()->setRGB('111111');
				// Выравниваем строку по вертикали ( середина )
					$activeSheet->getStyle("A{$line}:I{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				// Выравниваем ячейку по горизонтали
					$activeSheet->getStyle("C{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
					$activeSheet->getStyle("G{$line}:I{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				// Объединяем ячейки по горизонтали
					$activeSheet->mergeCells("C{$line}:F{$line}");
				// Вывод данных
					$activeSheet->setCellValue("A{$line}", '');
					$activeSheet->setCellValue("B{$line}", '');
					$activeSheet->setCellValue("C{$line}", 'Итого по договору субподряда');
					$activeSheet->setCellValue("G{$line}", number_format($_SUM_DOCSUB_CHF, 2, '.', ' ').$_DENED);
					$activeSheet->setCellValue("H{$line}", number_format($_SUM_DOCSUB_INCOMING, 2, '.', ' ').$_DENED);
					$activeSheet->setCellValue("I{$line}", number_format($_ZADOL_DOCSUB, 2, '.', ' ').$_DENED);
				// Оформляем границы
					$activeSheet->getStyle("A{$line}:I{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
					$activeSheet->getStyle("C{$line}:I{$line}")->applyFromArray($_BORDER_INSIDE);
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
	$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
				} // LVL 4
		#
		#
		#
		# --- Задолженность по всем договорам субподряда (разность суммы счетов-фактур и поступлений - авансов и оплат) отдельного этапа
			$_ZADOL_DOCSSUB = $_SUM_DOCSSUB_CHF - $_SUM_DOCSSUB_INCOMING;
		# +++ Суммируем счета-фактуры по всем договорам субподряда отдельного основного договора
			$_SUM_DOC_CHF += $_SUM_DOCSSUB_CHF;
		# +++ Суммируем поступления по всем договорам субподряда отдельного основного договора
			$_SUM_DOC_INCOMING += $_SUM_DOCSSUB_INCOMING;
		#
		#
		#
		# --- Задолженность по всем договорам субподряда (разность суммы счетов-фактур и поступлений - авансов и оплат) отдельного основного договора
			$_ZADOL_DOC = $_SUM_DOC_CHF - $_SUM_DOC_INCOMING;
		# +++ Суммируем счета-фактуры по всем договорам отдельного субподрядчика
			$_SUM_DOCS_CHF += $_SUM_DOC_CHF;
		# +++ Суммируем поступления по всем договорам отдельного субподрядчика
			$_SUM_DOCS_INCOMING += $_SUM_DOC_INCOMING;
		#
		#
		#
		# Выводим номер и название договора субподряда (либо запись о том, что он отсутствует)
		// Задаем высоту строки и шрифт
			$activeSheet->getRowDimension($line)->setRowHeight(28);
			$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setSize(12);
			$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setBold(true);
		// Задаем цвет текста строки
			$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->getColor()->setRGB('111111');
		// Выравниваем строку по вертикали ( середина )
			$activeSheet->getStyle("A{$line}:I{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		// Выравниваем ячейку по горизонтали
			$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$activeSheet->getStyle("G{$line}:I{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		// Объединяем ячейки по горизонтали
			$activeSheet->mergeCells("A{$line}:F{$line}");
		// Вывод данных
			$activeSheet->setCellValue("A{$line}", 'Итого (без основного договора)');
			$activeSheet->setCellValue("G{$line}", number_format($_SUM_DOC_CHF, 2, '.', ' ').$_DENED);
			$activeSheet->setCellValue("H{$line}", number_format($_SUM_DOC_INCOMING, 2, '.', ' ').$_DENED);
			$activeSheet->setCellValue("I{$line}", number_format($_ZADOL_DOC, 2, '.', ' ').$_DENED);
		// Оформляем границы
			$activeSheet->getStyle("A{$line}:I{$line}")->applyFromArray($_BORDER_INSIDE);
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
	$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	#
	}
	# --- ЕСЛИ НЕ СУЩЕСТВУЕТ ОСНОВНОЙ ДОГОВОР
#
#
#
#
#
# --- Задолженность по всем договорам субподряда (разность суммы счетов-фактур и поступлений - авансов и оплат) отдельного основного договора
	$_ZADOL_SUB = $_SUM_DOCS_CHF - $_SUM_DOCS_INCOMING;
# +++ Суммируем счета-фактуры по всем договорам отдельного субподрядчика
	$_SUM_SUB_CHF += $_SUM_DOCS_CHF;
# +++ Суммируем поступления по всем договорам отдельного субподрядчика
	$_SUM_SUB_INCOMING += $_SUM_DOCS_INCOMING;
# Выводим номер и название договора субподряда (либо запись о том, что он отсутствует)
// Задаем высоту строки и шрифт
	$activeSheet->getRowDimension($line)->setRowHeight(28);
	$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setSize(13);
	$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->setBold(true);
// Задаем цвет текста строки
	$activeSheet->getStyle("A{$line}:I{$line}")->getFont()->getColor()->setRGB('111111');
// Задаем цвет заливки строки
	$activeSheet->getStyle("A{$line}:I{$line}")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$activeSheet->getStyle("A{$line}:I{$line}")->getFill()->getStartColor()->setRGB("D0D0D0");
// Выравниваем строку по вертикали ( середина )
	$activeSheet->getStyle("A{$line}:I{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Выравниваем ячейку по горизонтали
	$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$activeSheet->getStyle("G{$line}:I{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// Объединяем ячейки по горизонтали
	$activeSheet->mergeCells("A{$line}:F{$line}");
// Вывод данных
	$activeSheet->setCellValue("A{$line}", 'ИТОГО ПО СУБПОДРЯДЧИКУ');
	$activeSheet->setCellValue("G{$line}", number_format($_SUM_DOCS_CHF, 2, '.', ' ').$_DENED);
	$activeSheet->setCellValue("H{$line}", number_format($_SUM_DOCS_INCOMING, 2, '.', ' ').$_DENED);
	$activeSheet->setCellValue("I{$line}", number_format($_ZADOL_SUB, 2, '.', ' ').$_DENED);
// Оформляем границы
	$activeSheet->getStyle("A{$line}:I{$line}")->applyFromArray($_BORDER_TOP);
	$activeSheet->getStyle("A{$line}:I{$line}")->applyFromArray($_BORDER_INSIDE);
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
	$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
}  // LVL 1
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Возвращаемся на 1 строку
	$line = $line - 1;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
// Добавляем рамку к шапке таблицы
$activeSheet->getStyle("A{$start_table}:I{$start_table}")->applyFromArray($_BORDER_OUTSIDE_THIN);
// Добавляем рамку ко всей таблице
$activeSheet->getStyle("A{$start_table}:I{$line}")->applyFromArray($_BORDER_OUTSIDE_THIN);

?>