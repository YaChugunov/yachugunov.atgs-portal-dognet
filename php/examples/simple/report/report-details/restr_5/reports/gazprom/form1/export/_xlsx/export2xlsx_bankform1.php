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
$activeSheet->getColumnDimension('B')->setWidth(40); // Заказчик
$activeSheet->getColumnDimension('C')->setWidth(30); // Источник финансирования
$activeSheet->getColumnDimension('D')->setWidth(12); // Номер договора
$activeSheet->getColumnDimension('E')->setWidth(15); // Дата заключения
$activeSheet->getColumnDimension('F')->setWidth(15); // Дата завершения
$activeSheet->getColumnDimension('G')->setWidth(75); // Титул, предмет договора
$activeSheet->getColumnDimension('H')->setWidth(18); // Сумма договора
$activeSheet->getColumnDimension('I')->setWidth(18); // Получено (сумма оплат)
$activeSheet->getColumnDimension('J')->setWidth(18); // Выполнено (сумма СФ)
$activeSheet->getColumnDimension('K')->setWidth(18); // Подписано КС2, КС3
$activeSheet->getColumnDimension('L')->setWidth(18); // Оплачено КС2, КС3
$activeSheet->getColumnDimension('M')->setWidth(18); // Удержано по гарантии
$activeSheet->getColumnDimension('N')->setWidth(18); // Получено авансов
$activeSheet->getColumnDimension('O')->setWidth(18); // Погашено авансов
$activeSheet->getColumnDimension('P')->setWidth(18); // Остаток авансов
$activeSheet->getColumnDimension('Q')->setWidth(15); // Процент субподряда
$activeSheet->getColumnDimension('R')->setWidth(45); // Банк обсл договор
$activeSheet->getColumnDimension('S')->setWidth(25); // Сумма гарантии
$activeSheet->getColumnDimension('T')->setWidth(20); // Срок гарантии
$activeSheet->getColumnDimension('U')->setWidth(35); // Задолженность по кредиту
$activeSheet->getColumnDimension('V')->setWidth(20); // Срок кредита
$activeSheet->getColumnDimension('W')->setWidth(20); // Рентабельность
#
// Для удобства заводим переменную $line, в ней будем считать номер строки
$line = 1;
#
# ----- ----- ----- ----- -----
# СТРОКА 1
# ----- ----- ----- ----- -----
// Выводим название отчета
$activeSheet->setCellValue("A{$line}", 'РЕЕСТР КОНТРАКТОВ КОМПАНИИ');
// Задаем высоту строки
$activeSheet->getRowDimension($line)->setRowHeight(24);
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:W{$line}");
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
$activeSheet->mergeCells("A{$line}:W{$line}");
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
$activeSheet->mergeCells("A{$line}:W{$line}");
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
$activeSheet->setCellValue("B{$line}", 'ЗАКАЗЧИК');
$activeSheet->setCellValue("C{$line}", 'ИСТОЧНИК ФИНАНСИРОВАНИЯ');
$activeSheet->setCellValue("D{$line}", 'НОМЕР ДОГОВОРА');
$activeSheet->setCellValue("E{$line}", 'ДАТА ЗАКЛЮЧЕНИЯ');
$activeSheet->setCellValue("F{$line}", 'ДАТА ЗАВЕРШЕНИЯ');
$activeSheet->setCellValue("G{$line}", 'ТИТУЛ' . "\n" . 'ПРЕДМЕТ ДОГОВОРА');
$activeSheet->setCellValue("H{$line}", 'СУММА' . "\n" . 'ДОГОВОРА');
$activeSheet->setCellValue("I{$line}", 'ПОЛУЧЕНО' . "\n" . 'СРЕДСТВ');
$activeSheet->setCellValue("J{$line}", 'ВЫПОЛНЕНО' . "\n" . 'ФАКТИЧЕСКИ');
$activeSheet->setCellValue("K{$line}", 'ПОДПИСАНО АКТОВ' . "\n" . 'ПОСТАВЛЕНО ПО НАКЛАДНЫМ');
$activeSheet->setCellValue("L{$line}", 'ОПЛАЧЕНО' . "\n" . '(НЕ ВКЛ АВАНСЫ)');
$activeSheet->setCellValue("M{$line}", 'УДЕРЖАНО' . "\n" . 'ПО ГАРАНТИИ');
$activeSheet->setCellValue("N{$line}", 'ПОЛУЧЕНО' . "\n" . 'АВАНСОВ');
$activeSheet->setCellValue("O{$line}", 'ПОГАШЕНО' . "\n" . 'АВАНСОВ');
$activeSheet->setCellValue("P{$line}", 'ОСТАТОК' . "\n" . 'АВАНСОВ');
$activeSheet->setCellValue("Q{$line}", 'СУБПОДРЯД' . "\n" . '(%)');
$activeSheet->setCellValue("R{$line}", 'Обслуживающий договор Банк');
$activeSheet->setCellValue("S{$line}", 'Сумма гарантии,' . "\n" . 'предоставленной в' . "\n" . 'рамках контракта');
$activeSheet->setCellValue("T{$line}", 'Дата истечения' . "\n" . 'срока действия' . "\n" . 'гарантии');
$activeSheet->setCellValue("U{$line}", 'Остаток задолженности по кредиту,' . "\n" . 'полученному под залог прав' . "\n" . 'требования по контракту');
$activeSheet->setCellValue("V{$line}", 'Дата завершения срока' . "\n" . 'действия кредита');
$activeSheet->setCellValue("W{$line}", 'Рентабельность' . "\n" . 'по договору (%)');
// Стили для текста в шапки таблицы.
$activeSheet->getRowDimension($line)->setRowHeight(42); // высота строки
$activeSheet->getStyle("A{$line}:W{$line}")->getFont()->setSize(10); // размер шрифта
$activeSheet->getStyle("A{$line}:W{$line}")->getFont()->setBold(true); // делаем шрифт жирным
$activeSheet->getStyle("A{$line}:W{$line}")->getAlignment()->setWrapText(true); // разрешаем перенос строк в ячейке
$activeSheet->getStyle("A{$line}:W{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); // вырванивание по вертикали - середина
// Выравнивание по горизонтали - слева
$activeSheet->getStyle("A{$line}:C{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("G{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("R{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
// Выравнивание по горизонтали - центр
$activeSheet->getStyle("D{$line}:F{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$activeSheet->getStyle("H{$line}:Q{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$activeSheet->getStyle("S{$line}:W{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// Делаем заливку области ячеек
$activeSheet->getStyle("A{$line}:W{$line}")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$activeSheet->getStyle("A{$line}:W{$line}")->getFill()->getStartColor()->setRGB("31708F");
// Задаем цвет текста строки
$activeSheet->getStyle("A{$line}:W{$line}")->getFont()->getColor()->setRGB('FFFFFF');
// Оформляем границы
$activeSheet->getStyle("A{$line}:W{$line}")->applyFromArray($_BORDER_INSIDE);
$activeSheet->getStyle("A{$line}:W{$line}")->applyFromArray($_BORDER_OUTSIDE_THICK);
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
$sql_query_docbase .= " OR kodstatus = '245381842747296')"; // статус "Текущий"
$sql_query_docbase .= " AND kodshab <> '0' ORDER BY docnumber ASC";
$_QRY_DOCBASE = mysqlQuery($sql_query_docbase);
$_SUM_TOTAL = 0.0;
//
$_colN = 1; // Номер строки
while ($_ROW_DOCBASE = mysqli_fetch_assoc($_QRY_DOCBASE)) {
	# ----- ----- ----- ----- -----
	#
	// Заказчик по договору
	$_QRY_ZAK = mysqlQuery("SELECT namezakshot, namezaklong FROM sp_contragents WHERE kodzakaz='" . $_ROW_DOCBASE['kodzakaz'] . "'");
	$_ROW_ZAK = mysqli_fetch_assoc($_QRY_ZAK);
	$_colZAK = $_ROW_ZAK['namezakshot'];
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
	$_colDOC = $_ROW_DOCBASE['docnameshot'];
	#
	// Сумма договора
	$_colSUMDOC = $_ROW_DOCBASE['docsumma'];
	#
	// Сумма всех этапов по договору
	$_QRY_SUMSTAGES = mysqlQuery("SELECT SUM(summastage) as sumstages FROM dognet_dockalplan WHERE koddel<>'99' AND koddoc='" . $_ROW_DOCBASE['koddoc'] . "'");
	$_ROW_SUMSTAGES = mysqli_fetch_assoc($_QRY_SUMSTAGES);
	$_colSUMSTAGES = $_ROW_SUMSTAGES['sumstages'];
	#
	# ----- ----- ----- ----- -----
	#
	$sql_query_dockalplan = "SELECT * FROM dognet_dockalplan WHERE koddel<>'99'";
	$sql_query_dockalplan .= " AND koddoc = '" . $_ROW_DOCBASE['koddoc'] . "'";
	$_QRY_STAGE = mysqlQuery($sql_query_dockalplan);
	// Сумма авансов по договору
	$_SUM_STAGE_AV = 0.0;
	$_SUM_STAGE_OSTAV = 0.0;
	$_SUM_TOTAL_AV = 0.0;
	$_SUM_TOTAL_OSTAV = 0.0;
	// Сумма СФ по договору
	$_SUM_STAGE_CHF = 0.0;
	$_SUM_TOTAL_CHF = 0.0;
	//
	$_SUM_STAGE_OPLCHF = 0.0;
	$_SUM_STAGE_OPLAVCHF = 0.0;
	$_SUM_STAGE_SUBPODR = 0.0;
	//
	$_SUM_TOTAL_OPLCHF = 0.0;
	$_SUM_TOTAL_OPLAVCHF = 0.0;
	$_SUM_TOTAL_SUBPODR = 0.0;
	# ----- ----- ----- ----- -----
	# При договоре с календарным планом
	$_AVPLANSTAGE = FALSE;
	if ($_ROW_DOCBASE['kodshab'] == 1 or $_ROW_DOCBASE['kodshab'] == 3) {
		while ($_ROW_STAGE = mysqli_fetch_assoc($_QRY_STAGE)) {
			#
			// Сумма авансов по этапу
			$_QRY_AVSUM = mysqlQuery("SELECT SUM(summaavans) as sumavans, SUM(ostatokavans) as sumostavans FROM dognet_docavans WHERE koddel<>'99' AND koddoc='" . $_ROW_STAGE['kodkalplan'] . "'");
			$_ROW_AVSUM = mysqli_fetch_assoc($_QRY_AVSUM);
			$sumavstage = $_ROW_AVSUM['sumavans'];
			$sumostavstage = $_ROW_AVSUM['sumostavans'];
			// Суммируем авансы и остатки авансов по этапам и получаем суммы по договору
			$_SUM_STAGE_AV += $sumavstage;
			$_SUM_STAGE_OSTAV += $sumostavstage;
			/*
	== Обновление от 20.09.2020 ==
	Проверяем, есть ли запланированные авансы по этапу
*/
			$_AV1PLAN = $_ROW_STAGE['useav1plan'] == '1' && $_ROW_STAGE['pravplan1stage'] != '0' && ($_ROW_STAGE['dateplanav1stage'] != NULL || $_ROW_STAGE['dateplanav1stage'] != "");
			$_AV2PLAN = $_ROW_STAGE['useav2plan'] == '1' && $_ROW_STAGE['pravplan2stage'] != '0' && ($_ROW_STAGE['dateplanav2stage'] != NULL || $_ROW_STAGE['dateplanav2stage'] != "");
			$_AV3PLAN = $_ROW_STAGE['useav3plan'] == '1' && $_ROW_STAGE['pravplan3stage'] != '0' && ($_ROW_STAGE['dateplanav3stage'] != NULL || $_ROW_STAGE['dateplanav3stage'] != "");
			$_AV4PLAN = $_ROW_STAGE['useav4plan'] == '1' && $_ROW_STAGE['pravplan4stage'] != '0' && ($_ROW_STAGE['dateplanav4stage'] != NULL || $_ROW_STAGE['dateplanav4stage'] != "");
			# --- - --- - --- - --- - ---
			// Сумма СФ по этапу
			$_QRY_CHFSUM = mysqlQuery("SELECT SUM(chetfsumma) as sumchf FROM dognet_kalplanchf WHERE koddel<>'99' AND kodkalplan='" . $_ROW_STAGE['kodkalplan'] . "'");
			$_ROW_CHFSUM = mysqli_fetch_assoc($_QRY_CHFSUM);
			$sumchfstage = $_ROW_CHFSUM['sumchf'];
			// Суммируем СФ по этапам и получаем сумму по договору
			$_SUM_STAGE_CHF += $sumchfstage;
			#
			// Сумма договоров субподряда по этапу
			$_colSUBPERC_msg = null;
			$_QRY_SUMSUB = mysqlQuery("SELECT SUM(sumdocsubpodr) as sumsubpodr FROM dognet_docsubpodr WHERE koddel<>'99' AND koddoc='" . $_ROW_STAGE['kodkalplan'] . "'");
			$_QRY_NUMSUB = mysqlQuery("SELECT koddocsubpodr FROM dognet_docsubpodr WHERE koddel<>'99' AND koddoc='" . $_ROW_STAGE['kodkalplan'] . "'");
			if (mysqli_num_rows($_QRY_NUMSUB) > 0) {
				$_ROW_SUMSUB = mysqli_fetch_assoc($_QRY_SUMSUB);
				$sumsubstage = $_ROW_SUMSUB['sumsubpodr'];
				// Суммируем субподряды по этапам и получаем сумму по договору
				$_SUM_STAGE_SUBPODR += $sumsubstage;
				$_colSUBPERC_msg = "sub_exist";
			} else {
				$_SUM_STAGE_SUBPODR = 0.0;
				$_colSUBPERC_msg = "sub_no";
			}
			#
			$_QRY_CHF = mysqlQuery("SELECT kodchfact FROM dognet_kalplanchf WHERE koddel<>'99' AND kodkalplan='" . $_ROW_STAGE['kodkalplan'] . "'");
			// Сумма оплат СФ по этапу
			$_SUM_CHF_OPL = 0.0;
			// Сумма погашенных авансов по этапу
			$_SUM_CHF_OPLAV = 0.0;
			#
			while ($_ROW_CHF = mysqli_fetch_assoc($_QRY_CHF)) {
				#
				// Сумма оплат по СФ
				$_QRY_OPLCHFSUM = mysqlQuery("SELECT SUM(summaopl) as sumoplchf FROM dognet_oplatachf WHERE koddel<>'99' AND kodchfact='" . $_ROW_CHF['kodchfact'] . "'");
				$_ROW_OPLCHFSUM = mysqli_fetch_assoc($_QRY_OPLCHFSUM);
				$sumoplchf = $_ROW_OPLCHFSUM['sumoplchf'];
				// Суммируем оплаты по СФ и получаем сумму оплат по этапу
				$_SUM_CHF_OPL += $sumoplchf;
				#
				// Сумма зачетов авансов по СФ
				$_QRY_OPLAVCHFSUM = mysqlQuery("SELECT SUM(summaoplav) as sumoplavchf FROM dognet_chfavans WHERE koddel<>'99' AND kodchfact='" . $_ROW_CHF['kodchfact'] . "'");
				$_ROW_OPLAVCHFSUM = mysqli_fetch_assoc($_QRY_OPLAVCHFSUM);
				$sumoplavchf = $_ROW_OPLAVCHFSUM['sumoplavchf'];
				// Суммируем зачеты авансов по СФ и получаем сумму зачетов по этапу
				$_SUM_CHF_OPLAV += $sumoplavchf;
			}
			$_SUM_STAGE_OPLCHF += $_SUM_CHF_OPL;
			$_SUM_STAGE_OPLAVCHF += $_SUM_CHF_OPLAV;

			$_AVPLANSTAGE = $_AV1PLAN || $_AV2PLAN || $_AV3PLAN || $_AV4PLAN;
		}
	}
	# ----- ----- ----- ----- -----
	# При договоре без календарного плана
	$_AVPLANDOC = FALSE;
	if ($_ROW_DOCBASE['kodshab'] == 2 or $_ROW_DOCBASE['kodshab'] == 4) {
		#
		// Сумма авансов по договору
		$_QRY_AVSUM = mysqlQuery("SELECT SUM(summaavans) as sumavans, SUM(ostatokavans) as sumostavans FROM dognet_docavans WHERE koddel<>'99' AND koddoc='" . $_ROW_DOCBASE['koddoc'] . "'");
		$_ROW_AVSUM = mysqli_fetch_assoc($_QRY_AVSUM);
		$sumavstage = $_ROW_AVSUM['sumavans'];
		$sumostavstage = $_ROW_AVSUM['sumostavans'];
		// Суммируем авансы по этапам и получаем сумму по договору
		$_SUM_STAGE_AV += $sumavstage;
		$_SUM_STAGE_OSTAV += $sumostavstage;
		/*
	== Обновление от 20.09.2020 ==
	Проверяем, есть ли запланированные авансы по договору
*/
		$_AV1PLAN = $_ROW_STAGE['useav1plan'] == '1' && $_ROW_STAGE['pravplan1'] != '0' && ($_ROW_STAGE['dateplanav1'] != NULL || $_ROW_STAGE['dateplanav1'] != "");
		$_AV2PLAN = $_ROW_STAGE['useav2plan'] == '1' && $_ROW_STAGE['pravplan2'] != '0' && ($_ROW_STAGE['dateplanav2'] != NULL || $_ROW_STAGE['dateplanav2'] != "");
		$_AV3PLAN = $_ROW_STAGE['useav3plan'] == '1' && $_ROW_STAGE['pravplan3'] != '0' && ($_ROW_STAGE['dateplanav3'] != NULL || $_ROW_STAGE['dateplanav3'] != "");
		$_AV4PLAN = $_ROW_STAGE['useav4plan'] == '1' && $_ROW_STAGE['pravplan4'] != '0' && ($_ROW_STAGE['dateplanav4'] != NULL || $_ROW_STAGE['dateplanav4'] != "");
		# --- - --- - --- - --- - ---
		// Сумма СФ по договору
		$_QRY_CHFSUM = mysqlQuery("SELECT SUM(chetfsumma) as sumchf FROM dognet_kalplanchf WHERE koddel<>'99' AND kodkalplan='" . $_ROW_DOCBASE['koddoc'] . "'");
		$_ROW_CHFSUM = mysqli_fetch_assoc($_QRY_CHFSUM);
		$sumchfstage = $_ROW_CHFSUM['sumchf'];
		// Суммируем СФ по этапам и получаем сумму по договору
		$_SUM_STAGE_CHF += $sumchfstage;
		#
		// Сумма договоров субподряда по этапу
		$_colSUBPERC_msg = null;
		$_QRY_SUMSUB = mysqlQuery("SELECT SUM(sumdocsubpodr) as sumsubpodr FROM dognet_docsubpodr WHERE koddel<>'99' AND koddoc='" . $_ROW_DOCBASE['koddoc'] . "'");
		$_QRY_NUMSUB = mysqlQuery("SELECT koddocsubpodr FROM dognet_docsubpodr WHERE koddel<>'99' AND koddoc='" . $_ROW_DOCBASE['koddoc'] . "'");
		if (mysqli_num_rows($_QRY_NUMSUB) > 0) {
			$_ROW_SUMSUB = mysqli_fetch_assoc($_QRY_SUMSUB);
			$sumsubstage = $_ROW_SUMSUB['sumsubpodr'];
			// Суммируем субподряды по этапам и получаем сумму по договору
			$_SUM_STAGE_SUBPODR += $sumsubstage;
			$_colSUBPERC_msg = "sub_exist";
		} else {
			$_SUM_STAGE_SUBPODR = 0.0;
			$_colSUBPERC_msg = "sub_no";
		}
		#
		$_QRY_CHF = mysqlQuery("SELECT kodchfact FROM dognet_kalplanchf WHERE koddel<>'99' AND kodkalplan='" . $_ROW_DOCBASE['koddoc'] . "'");
		// Сумма оплат СФ
		$_SUM_CHF_OPL = 0.0;
		// Сумма погашенных авансов
		$_SUM_CHF_OPLAV = 0.0;
		#
		while ($_ROW_CHF = mysqli_fetch_assoc($_QRY_CHF)) {
			#
			// Сумма оплат по СФ
			$_QRY_OPLCHFSUM = mysqlQuery("SELECT SUM(summaopl) as sumoplchf FROM dognet_oplatachf WHERE koddel<>'99' AND kodchfact='" . $_ROW_CHF['kodchfact'] . "'");
			$_ROW_OPLCHFSUM = mysqli_fetch_assoc($_QRY_OPLCHFSUM);
			$sumoplchf = $_ROW_OPLCHFSUM['sumoplchf'];
			// Суммируем оплаты по СФ и получаем сумму оплат по договору
			$_SUM_CHF_OPL += $sumoplchf;
			#
			// Сумма зачетов авансов по СФ
			$_QRY_OPLAVCHFSUM = mysqlQuery("SELECT SUM(summaoplav) as sumoplavchf FROM dognet_chfavans WHERE koddel<>'99' AND kodchfact='" . $_ROW_CHF['kodchfact'] . "'");
			$_ROW_OPLAVCHFSUM = mysqli_fetch_assoc($_QRY_OPLAVCHFSUM);
			$sumoplavchf = $_ROW_OPLAVCHFSUM['sumoplavchf'];
			// Суммируем зачеты авансов по СФ и получаем сумму зачетов по договору
			$_SUM_CHF_OPLAV += $sumoplavchf;
		}
		$_SUM_STAGE_OPLCHF += $_SUM_CHF_OPL;
		$_SUM_STAGE_OPLAVCHF += $_SUM_CHF_OPLAV;

		$_AVPLANDOC = $_AV1PLAN || $_AV2PLAN || $_AV3PLAN || $_AV4PLAN;
	}
	# ----- ----- ----- ----- -----
	#
	$_SUM_TOTAL_AV += $_SUM_STAGE_AV;
	$_SUM_TOTAL_OSTAV += $_SUM_STAGE_OSTAV;
	$_SUM_TOTAL_CHF += $_SUM_STAGE_CHF;
	$_SUM_TOTAL_OPLCHF += $_SUM_STAGE_OPLCHF;
	$_SUM_TOTAL_OPLAVCHF += $_SUM_STAGE_OPLAVCHF;
	$_SUM_TOTAL_SUBPODR += $_SUM_STAGE_SUBPODR;

	$_AVPLAN = $_AVPLANSTAGE || $_AVPLANDOC;
	#
	// Сумма авансов и остатков авансов по договору
	$_colSUMAV = $_SUM_TOTAL_AV;
	$_colSUMOSTAV = $_SUM_TOTAL_OSTAV;
	$_colFINIST = ($_SUM_TOTAL_AV != 0 || $_AVPLAN) ? "Аванс и собств. средства" : "Собств. средства";
	// Сумма СФ по договору
	$_colSUMCHF = $_SUM_TOTAL_CHF;
	// Сумма зачетов авансов по договору
	$_colSUMOPLAVCHF = $_SUM_TOTAL_OPLAVCHF;
	// Сумма оплат СФ по договору
	$_colSUMOPLCHF = $_SUM_TOTAL_OPLCHF;
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	// Задаем высоту строки и шрифт
	$activeSheet->getRowDimension($line)->setRowHeight(18);
	$activeSheet->getStyle("A{$line}:W{$line}")->getFont()->setSize(10);
	$activeSheet->getStyle("A{$line}:W{$line}")->getFont()->setBold(false);
	// Задаем цвет текста строки
	$activeSheet->getStyle("A{$line}:W{$line}")->getFont()->getColor()->setRGB('111111');
	// Выравниваем строку по вертикали ( середина )
	$activeSheet->getStyle("A{$line}:W{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	// Выравнивание по горизонтали - слева
	$activeSheet->getStyle("A{$line}:C{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$activeSheet->getStyle("G{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$activeSheet->getStyle("R{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	// Выравнивание по горизонтали - центр
	$activeSheet->getStyle("D{$line}:F{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$activeSheet->getStyle("H{$line}:Q{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$activeSheet->getStyle("S{$line}:W{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	//
	$activeSheet->setCellValue("A{$line}", $_colN);
	$activeSheet->setCellValue("B{$line}", $_colZAK);
	$activeSheet->setCellValue("C{$line}", $_colFINIST);
	$activeSheet->setCellValue("D{$line}", "3-4/" . $_colNUM);
	$activeSheet->setCellValue("E{$line}", $_colDATE1);
	$activeSheet->setCellValue("F{$line}", $_colDATE2);
	$activeSheet->setCellValue("G{$line}", $_colDOC);
	$activeSheet->setCellValue("H{$line}", $_colSUMSTAGES);
	$activeSheet->getStyle("H{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
	$activeSheet->setCellValue("I{$line}", $_colSUMOPLCHF);
	$activeSheet->getStyle("I{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
	$activeSheet->setCellValue("J{$line}", $_colSUMCHF);
	$activeSheet->getStyle("J{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
	$activeSheet->setCellValue("K{$line}", $_colSUMCHF);
	$activeSheet->getStyle("K{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
	$activeSheet->setCellValue("L{$line}", $_colSUMOPLCHF);
	$activeSheet->getStyle("L{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
	$activeSheet->setCellValue("M{$line}", "");
	$activeSheet->setCellValue("N{$line}", $_colSUMAV);
	$activeSheet->getStyle("N{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
	$activeSheet->setCellValue("O{$line}", $_colSUMOPLAVCHF);
	$activeSheet->getStyle("O{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
	$activeSheet->setCellValue("P{$line}", $_colSUMOSTAV);
	$activeSheet->getStyle("P{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
	// Процент субподряда (сумма всех субподрядов к сумме этапов)
	if ($_colSUBPERC_msg == "sub_exist") {
		if ($_colSUMSTAGES <> 0) {
			$_colSUBPERC = ($_SUM_TOTAL_SUBPODR / $_colSUMSTAGES) * 100;
			$activeSheet->setCellValue("Q{$line}", $_colSUBPERC);
			$activeSheet->getStyle("Q{$line}")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
		} else {
			$activeSheet->setCellValue("Q{$line}", "ДОГ = 0");
		}
	} else {
		$activeSheet->setCellValue("Q{$line}", "НЕТ СУБ");
	}
	$activeSheet->setCellValue("R{$line}", "");
	$activeSheet->setCellValue("S{$line}", "");
	$activeSheet->setCellValue("T{$line}", "");
	$activeSheet->setCellValue("U{$line}", "");
	$activeSheet->setCellValue("V{$line}", "");
	$activeSheet->setCellValue("W{$line}", "");
	// Оформляем границы
	$activeSheet->getStyle("A{$line}:W{$line}")->applyFromArray($_BORDER_INSIDE);
	$activeSheet->getStyle("A{$line}:W{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
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
	$activeSheet->getStyle("A{$line}:W{$line}")->getFont()->setSize(12);
	$activeSheet->getStyle("A{$line}:W{$line}")->getFont()->setBold(true);
	// Задаем цвет текста строки
	$activeSheet->getStyle("A{$line}:W{$line}")->getFont()->getColor()->setRGB('111111');
	// Объединяем ячейки по горизонтали
	$activeSheet->mergeCells("A{$line}:G{$line}");
	// Выравниваем строку по вертикали ( середина )
	$activeSheet->getStyle("A{$line}:W{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	// Выравнивание по горизонтали - центр
	$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	// Выравнивание по горизонтали - центр
	$activeSheet->getStyle("H{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$activeSheet->setCellValue("A{$line}", "ИТОГО: ");
	$activeSheet->setCellValue("H{$line}", $_SUM_TOTAL);
		$activeSheet->getStyle("H{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
	// Оформляем границы
	$activeSheet->getStyle("A{$line}:W{$line}")->applyFromArray($_BORDER_INSIDE);
	$activeSheet->getStyle("A{$line}:W{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
*/

#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Возвращаемся на 1 строку
$line = $line - 1;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
// Добавляем рамку к шапке таблицы
$activeSheet->getStyle("A{$start_table}:W{$start_table}")->applyFromArray($_BORDER_OUTSIDE_THIN);
// Добавляем рамку ко всей таблице
$activeSheet->getStyle("A{$start_table}:W{$line}")->applyFromArray($_BORDER_OUTSIDE_THIN);


// $objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());
// $objPHPExcel->getActiveSheet()->setAutoFilter("A{$start_table}:I{$start_table}");
