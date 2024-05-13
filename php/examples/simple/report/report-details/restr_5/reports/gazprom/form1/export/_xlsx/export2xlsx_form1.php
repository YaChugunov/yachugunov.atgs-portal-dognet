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
$activeSheet->setTitle('Реестр контрактов');
#
// Колонтитулы
$activeSheet->getHeaderFooter()->setOddHeader('&L&G&B&12РЕЕСТР КОНТРАКТОВ КОМПАНИИ&R&G&B&12В интервале дат');
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
// $start_date = date("Y-m-d", strtotime($_GET['start_date']));
// $end_date = date("Y-m-d", strtotime($_GET['end_date']));
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# ФОРМАТИРУЕМ ВЫХОДНУЮ ТАБЛИЦУ EXCEL
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
// Задаем ширины столбцов
$activeSheet->getColumnDimension('A')->setWidth(5); // Номер
$activeSheet->getColumnDimension('B')->setWidth(15); // ИНН
$activeSheet->getColumnDimension('C')->setWidth(100); // Заказчик и реквизиты
$activeSheet->getColumnDimension('D')->setWidth(30); // Email
$activeSheet->getColumnDimension('E')->setWidth(100); // Наименование договора
$activeSheet->getColumnDimension('F')->setWidth(15); // Номер договора
$activeSheet->getColumnDimension('G')->setWidth(18); // Дата заключения
$activeSheet->getColumnDimension('H')->setWidth(18); // Дата завершения
$activeSheet->getColumnDimension('I')->setWidth(35); // 
$activeSheet->getColumnDimension('J')->setWidth(18); // 
$activeSheet->getColumnDimension('K')->setWidth(24); // 
$activeSheet->getColumnDimension('L')->setWidth(18); // 
$activeSheet->getColumnDimension('M')->setWidth(18); // 
$activeSheet->getColumnDimension('N')->setWidth(18); // 
$activeSheet->getColumnDimension('O')->setWidth(18); // 
$activeSheet->getColumnDimension('P')->setWidth(18); // 
$activeSheet->getColumnDimension('Q')->setWidth(30); // 
$activeSheet->getColumnDimension('R')->setWidth(45); // 
#
// Для удобства заводим переменную $line, в ней будем считать номер строки
$line = 1;
#
# ----- ----- ----- ----- -----
# СТРОКА 1
# ----- ----- ----- ----- -----
// Выводим название отчета
$activeSheet->setCellValue("A{$line}", 'ГАЗПРОМ МОНИТОРИНГ');
// Задаем высоту строки
$activeSheet->getRowDimension($line)->setRowHeight(24);
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:R{$line}");
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
$activeSheet->mergeCells("A{$line}:R{$line}");
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
$activeSheet->mergeCells("A{$line}:R{$line}");
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
$activeSheet->setCellValue("A{$line}", '№');
$activeSheet->setCellValue("B{$line}", 'ИНН заказчика');
$activeSheet->setCellValue("C{$line}", 'Наименование заказчика' . "\n" . '(реквизиты, адрес, контактный телефон заказчика, контактное лицо)');
$activeSheet->setCellValue("D{$line}", 'Адрес электронной почты' . "\n" . 'контактного лица Заказчика');
$activeSheet->setCellValue("E{$line}", 'Наименование / Предмет договора');
$activeSheet->setCellValue("F{$line}", 'Номер' . "\n" . 'договора');
$activeSheet->setCellValue("G{$line}", 'Дата заключения' . "\n" . 'договора');
$activeSheet->setCellValue("H{$line}", 'Дата окончания' . "\n" . 'выполнения работ' . "\n" . '(оказания услуг / поставки товаров)');
$activeSheet->setCellValue("I{$line}", 'Регион выполнения работ' . "\n" . '(оказания услуг / поставки товаров)');
$activeSheet->setCellValue("J{$line}", 'Роль Участника' . "\n" . '(генподрядчик / субподрядчик)');
$activeSheet->setCellValue("K{$line}", 'Наименование и вид выполненных работ /' . "\n" . 'оказанных услуг по предмету предквалификации');
$activeSheet->setCellValue("L{$line}", 'Привлекаемые субподрядчики' . "\n" . '(соисполнители) ');
$activeSheet->setCellValue("M{$line}", 'Сумма договора' . "\n" . '(тыс. руб. с НДС)');
$activeSheet->setCellValue("N{$line}", 'Размер затрат на субподряд' . "\n" . '(тыс. руб. с НДС)');
$activeSheet->setCellValue("O{$line}", 'Выполнено по договору' . "\n" . 'на начало текущего года' . "\n" . '(тыс. руб. с НДС)');
$activeSheet->setCellValue("P{$line}", 'Выполнено по договору' . "\n" . 'на отчетную дату' . "\n" . '(тыс. руб. с НДС)');
$activeSheet->setCellValue("Q{$line}", 'Численный состав' . "\n" . 'непосредственных исполнителей' . "\n" . 'выполненных работ/услуг Участника, чел.');
$activeSheet->setCellValue("R{$line}", 'Примечание');
// Стили для текста в шапки таблицы.
$activeSheet->getRowDimension($line)->setRowHeight(72); // высота строки
$activeSheet->getStyle("A{$line}:R{$line}")->getFont()->setSize(10); // размер шрифта
$activeSheet->getStyle("A{$line}:R{$line}")->getFont()->setBold(true); // делаем шрифт жирным
$activeSheet->getStyle("A{$line}:R{$line}")->getAlignment()->setWrapText(true); // разрешаем перенос строк в ячейке
$activeSheet->getStyle("A{$line}:R{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); // вырванивание по вертикали - середина
// Выравнивание по горизонтали - слева
$activeSheet->getStyle("C{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("E{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("R{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
// Выравнивание по горизонтали - центр
$activeSheet->getStyle("A{$line}:B{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$activeSheet->getStyle("D{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$activeSheet->getStyle("F{$line}:Q{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// Делаем заливку области ячеек
$activeSheet->getStyle("A{$line}:R{$line}")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$activeSheet->getStyle("A{$line}:R{$line}")->getFill()->getStartColor()->setRGB("31708F");
// Задаем цвет текста строки
$activeSheet->getStyle("A{$line}:R{$line}")->getFont()->getColor()->setRGB('FFFFFF');
// Оформляем границы
$activeSheet->getStyle("A{$line}:R{$line}")->applyFromArray($_BORDER_INSIDE);
$activeSheet->getStyle("A{$line}:R{$line}")->applyFromArray($_BORDER_OUTSIDE_THICK);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
// Делаем выборку договоров
$sql_query_docbase = "SELECT * FROM dognet_docbase WHERE koddel<>'99' AND ";
$sql_query_docbase .= " (kodstatus = '245381842145343'"; // статус "Проект"
$sql_query_docbase .= " OR kodstatus = '245267756667430'"; // статус "Подписание"
$sql_query_docbase .= " OR kodstatus = '245597345680479'"; // статус "Скан"
$sql_query_docbase .= " OR kodstatus = '245381842747296') AND "; // статус "Текущий"

$sql_query_docbase .= " (kodtip = '245287843809309'"; // статус "ПНР"
$sql_query_docbase .= " OR kodtip = '245773052282168'"; // статус "ШМР"
$sql_query_docbase .= " OR kodtip = '245691250149328'"; // статус "СМР"
$sql_query_docbase .= " OR kodtip = '245267756588371'"; // статус "Техобслуживание" !! Добавлено 05.07.2021 !!
$sql_query_docbase .= " OR kodtip = '245773055697212')"; // статус "ПНР и ШМР"

$sql_query_docbase .= " AND kodshab <> '0' ORDER BY docnumber ASC";
$_QRY_DOCBASE = mysqlQuery($sql_query_docbase);
$_SUM_TOTAL = 0.0;
//
$_colN = 1; // Номер строки
while ($_ROW_DOCBASE = mysqli_fetch_assoc($_QRY_DOCBASE)) {
	# ----- ----- ----- ----- -----
	#
	$_colZAKinn		= "";
	$_colZAKname 	= "";
	$_colZAKaddr 	= "";
	$_colZAKbank 	= "";
	$_colZAKkpp 	= "";
	$_colZAKfio 	= "";
	$_colZAKdolj 	= "";
	$_colZAKtel 	= "";
	$_colZAKmail 	= "";
	// Заказчик по договору
	$_QRY_ZAK = mysqlQuery("SELECT * FROM sp_contragents WHERE kodzakaz='" . $_ROW_DOCBASE['kodzakaz'] . "'");
	if ($_QRY_ZAK) {
		$_ROW_ZAK = mysqli_fetch_assoc($_QRY_ZAK);
		$_colZAKinn		= $_ROW_ZAK['zakinn'];
		$_colZAKname 	= $_ROW_ZAK['namezaklong'];
		$_colZAKaddr 	= $_ROW_ZAK['zakuraddress'];
		$_colZAKbank 	= $_ROW_ZAK['zakbankch'];
		$_colZAKkpp 	= $_ROW_ZAK['zakkpp'];
	}

	// Ищем контакты через бланк ГИПа
	$_QRY_DOCBLANK = mysqlQuery("SELECT kodblankwork, kodtipblank FROM dognet_docblankwork WHERE koddoc='" . $_ROW_DOCBASE['koddoc'] . "' AND kodstatusblank='DO'");
	if ($_QRY_DOCBLANK) {
		$_ROW_DOCBLANK = mysqli_fetch_assoc($_QRY_DOCBLANK);
		switch ($_ROW_DOCBLANK["kodtipblank"]) {
			case "PNR":
				$_QRY_BLANKGIP = mysqlQuery("SELECT nameendcontact, namefistcontact, namesecondcontact, numbertelrab, numbertelmob, nameemail, namedoljcontact, dopcontact1, dopcontact2 FROM dognet_blankdocpnr WHERE kodblankwork='" . $_ROW_DOCBLANK['kodblankwork'] . "' AND kodtipblank='DO'");
				if ($_QRY_BLANKGIP) {
					$_ROW_BLANKGIP = mysqli_fetch_assoc($_QRY_BLANKGIP);
					$_colZAKfio		= $_ROW_BLANKGIP['nameendcontact'] . " " . $_ROW_BLANKGIP['namefistcontact'] . " " . $_ROW_BLANKGIP['namesecondcontact'];
					$_colZAKdolj	= $_ROW_BLANKGIP['namedoljcontact'];
					$_colZAKtel		= $_ROW_BLANKGIP['numbertelrab'] . ", " . $_ROW_BLANKGIP['numbertelmob'];
					$_colZAKmail	= $_ROW_BLANKGIP['nameemail'];
				}
				break;
			case "POS":
				$_QRY_BLANKGIP = mysqlQuery("SELECT nameendcontact, namefistcontact, namesecondcontact, numbertelrab, numbertelmob, nameemail, namedoljcontact FROM dognet_blankdocpost WHERE kodblankwork='" . $_ROW_DOCBLANK['kodblankwork'] . "' AND kodtipblank='DO'");
				if ($_QRY_BLANKGIP) {
					$_ROW_BLANKGIP = mysqli_fetch_assoc($_QRY_BLANKGIP);
					$_colZAKfio		= $_ROW_BLANKGIP['nameendcontact'] . " " . $_ROW_BLANKGIP['namefistcontact'] . " " . $_ROW_BLANKGIP['namesecondcontact'];
					$_colZAKdolj	= $_ROW_BLANKGIP['namedoljcontact'];
					$_colZAKtel		= $_ROW_BLANKGIP['numbertelrab'] . ", " . $_ROW_BLANKGIP['numbertelmob'];
					$_colZAKmail	= $_ROW_BLANKGIP['nameemail'];
				}
				break;
			case "SUB":
				$_QRY_BLANKGIP = mysqlQuery("SELECT nameendcontact, namefistcontact, namesecondcontact, numbertelrab, numbertelmob, nameemail, namedoljcontact FROM dognet_blankdocsub WHERE kodblankwork='" . $_ROW_DOCBLANK['kodblankwork'] . "' AND kodtipblank='DO'");
				if ($_QRY_BLANKGIP) {
					$_ROW_BLANKGIP = mysqli_fetch_assoc($_QRY_BLANKGIP);
					$_colZAKfio		= $_ROW_BLANKGIP['nameendcontact'] . " " . $_ROW_BLANKGIP['namefistcontact'] . " " . $_ROW_BLANKGIP['namesecondcontact'];
					$_colZAKdolj	= $_ROW_BLANKGIP['namedoljcontact'];
					$_colZAKtel		= $_ROW_BLANKGIP['numbertelrab'] . ", " . $_ROW_BLANKGIP['numbertelmob'];
					$_colZAKmail	= $_ROW_BLANKGIP['nameemail'];
				}
				break;
		}
	}

	$_colZAK = $_colZAKname . ", юр. адрес: " . $_colZAKaddr . ", банк. рекв.: " . $_colZAKbank . ", конт. лицо: " . $_colZAKfio . " (" . $_colZAKtel . ", " . $_colZAKmail . ")";
	#
	// Номер договора
	$_colNUM = $_ROW_DOCBASE['docnumber'];
	#
	// Дата заключения договора
	$_colDATE1 = str_pad($_ROW_DOCBASE['daynachdoc'], 2, "0", STR_PAD_LEFT) . "." . str_pad($_ROW_DOCBASE['monthnachdoc'], 2, "0", STR_PAD_LEFT) . "." . $_ROW_DOCBASE['yearnachdoc'];
	#
	// Дата окончания договора
	$_colDATE2 = str_pad($_ROW_DOCBASE['dayenddoc'], 2, "0", STR_PAD_LEFT) . "." . str_pad($_ROW_DOCBASE['monthenddoc'], 2, "0", STR_PAD_LEFT) . "." . $_ROW_DOCBASE['yearenddoc'];
	#
	// Объект по договору
	$_QRY_OBJ = mysqlQuery("SELECT nameobjectshot, nameobjectlong FROM sp_objects WHERE kodobject='" . $_ROW_DOCBASE['kodobject'] . "'");
	$_ROW_OBJ = mysqli_fetch_assoc($_QRY_OBJ);
	$_colOBJ = $_ROW_OBJ['nameobjectshot'];
	#
	// Предмет договора
	$_colDOC = $_ROW_DOCBASE['docnamefullm'];
	#
	// Сумма договора (в тысячах рублей)
	$_colSUMDOC = $_ROW_DOCBASE['docsumma'] / 1000.00;
	#
	// Сумма всех этапов по договору
	$_QRY_SUMSTAGES = mysqlQuery("SELECT SUM(summastage) as sumstages FROM dognet_dockalplan WHERE koddel<>'99' AND koddoc='" . $_ROW_DOCBASE['koddoc'] . "'");
	$_ROW_SUMSTAGES = mysqli_fetch_assoc($_QRY_SUMSTAGES);
	$_colSUMSTAGES = $_ROW_SUMSTAGES['sumstages'];
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	// Задаем высоту строки и шрифт
	$activeSheet->getRowDimension($line)->setRowHeight(56);
	$activeSheet->getStyle("A{$line}:R{$line}")->getFont()->setSize(10);
	$activeSheet->getStyle("A{$line}:R{$line}")->getFont()->setBold(false);
	// Задаем цвет текста строки
	$activeSheet->getStyle("A{$line}:R{$line}")->getFont()->getColor()->setRGB('111111');
	// Выравниваем строку по вертикали ( середина )
	$activeSheet->getStyle("A{$line}:R{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	// Выравнивание по горизонтали - слева
	$activeSheet->getStyle("C{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$activeSheet->getStyle("E{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$activeSheet->getStyle("R{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	// Выравнивание по горизонтали - центр
	$activeSheet->getStyle("A{$line}:B{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$activeSheet->getStyle("D{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$activeSheet->getStyle("F{$line}:Q{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	//
	$activeSheet->getStyle("C{$line}")->getAlignment()->setWrapText(true);
	$activeSheet->getStyle("E{$line}")->getAlignment()->setWrapText(true);
	//
	$activeSheet->setCellValue("A{$line}", $_colN);
	$activeSheet->setCellValue("B{$line}", $_colZAKinn);
	$activeSheet->setCellValue("C{$line}", $_colZAK);
	$activeSheet->setCellValue("D{$line}", $_colZAKmail);
	$activeSheet->setCellValue("E{$line}", $_colDOC);
	$activeSheet->setCellValue("F{$line}", "3-4/" . $_colNUM);
	$activeSheet->setCellValue("G{$line}", $_colDATE1);
	$activeSheet->setCellValue("H{$line}", $_colDATE2);
	$activeSheet->setCellValue("I{$line}", $_colOBJ);
	$activeSheet->setCellValue("J{$line}", "");
	$activeSheet->setCellValue("K{$line}", "");
	$activeSheet->setCellValue("L{$line}", "");
	$activeSheet->setCellValue("M{$line}", $_colSUMDOC);
	$activeSheet->getStyle("M{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
	$activeSheet->setCellValue("N{$line}", "");
	$activeSheet->setCellValue("O{$line}", "");
	$activeSheet->setCellValue("P{$line}", "");
	$activeSheet->setCellValue("Q{$line}", "");
	$activeSheet->setCellValue("R{$line}", "");
	// Оформляем границы
	$activeSheet->getStyle("A{$line}:R{$line}")->applyFromArray($_BORDER_INSIDE);
	$activeSheet->getStyle("A{$line}:R{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
	$_colN++;
	#
	#
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	# Следующая строка
	$line++;
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	#
	#
}

/*
	// Задаем высоту строки и шрифт
	$activeSheet->getRowDimension($line)->setRowHeight(22);
	$activeSheet->getStyle("A{$line}:R{$line}")->getFont()->setSize(12);
	$activeSheet->getStyle("A{$line}:R{$line}")->getFont()->setBold(true);
	// Задаем цвет текста строки
	$activeSheet->getStyle("A{$line}:R{$line}")->getFont()->getColor()->setRGB('111111');
	// Объединяем ячейки по горизонтали
	$activeSheet->mergeCells("A{$line}:G{$line}");
	// Выравниваем строку по вертикали ( середина )
	$activeSheet->getStyle("A{$line}:R{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	// Выравнивание по горизонтали - центр
	$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	// Выравнивание по горизонтали - центр
	$activeSheet->getStyle("H{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$activeSheet->setCellValue("A{$line}", "ИТОГО: ");
	$activeSheet->setCellValue("H{$line}", $_SUM_TOTAL);
		$activeSheet->getStyle("H{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
	// Оформляем границы
	$activeSheet->getStyle("A{$line}:R{$line}")->applyFromArray($_BORDER_INSIDE);
	$activeSheet->getStyle("A{$line}:R{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
*/

#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Возвращаемся на 1 строку
$line = $line - 1;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
// Добавляем рамку к шапке таблицы
$activeSheet->getStyle("A{$start_table}:R{$start_table}")->applyFromArray($_BORDER_OUTSIDE_THIN);
// Добавляем рамку ко всей таблице
$activeSheet->getStyle("A{$start_table}:R{$line}")->applyFromArray($_BORDER_OUTSIDE_THIN);


// $objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());
// $objPHPExcel->getActiveSheet()->setAutoFilter("A{$start_table}:I{$start_table}");
