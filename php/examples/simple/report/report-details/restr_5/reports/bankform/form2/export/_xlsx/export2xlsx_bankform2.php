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
$activeSheet->setTitle('Контрактная база за период');
#
// Колонтитулы
$activeSheet->getHeaderFooter()->setOddHeader('&L&G&B&12КОНТРАКТНАЯ БАЗА&R&G&B&12За период');
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
$activeSheet->getColumnDimension('A')->setWidth(5); // Номер
$activeSheet->getColumnDimension('B')->setWidth(50); // Заказчик
$activeSheet->getColumnDimension('C')->setWidth(20); // Номер и дата договора
$activeSheet->getColumnDimension('D')->setWidth(17); // Дата начала работ
$activeSheet->getColumnDimension('E')->setWidth(17); // Дата завершения работ
$activeSheet->getColumnDimension('F')->setWidth(75); // Титул, предмет договора
$activeSheet->getColumnDimension('G')->setWidth(22); // Сумма договора
$activeSheet->getColumnDimension('H')->setWidth(22); // Закрыто по актам ф. КС-2, КС-3 (сумма СФ)
$activeSheet->getColumnDimension('I')->setWidth(22); // Получено (сумма оплат всего)
$activeSheet->getColumnDimension('J')->setWidth(18); // Процент субподряда (%)
$activeSheet->getColumnDimension('K')->setWidth(18); // Рентабельность (%)
#
// Для удобства заводим переменную $line, в ней будем считать номер строки
$line = 1;
#
# ----- ----- ----- ----- -----
# СТРОКА 1
# ----- ----- ----- ----- -----
// Выводим название отчета
$activeSheet->setCellValue("A{$line}", 'КОНТРАКТНАЯ БАЗА ЗА ПЕРИОД (С ' . date("d.m.Y", strtotime($start_date)) . ' ПО ' . date("d.m.Y", strtotime($end_date)) . ")");
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
$activeSheet->setCellValue("A{$line}", 'По состоянию на: ' . date("d.m.Y H:i:s"));
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
$activeSheet->setCellValue("A{$line}", "Составитель отчета: " . $_SESSION['lastname'] . " " . $_SESSION['firstname'] . " " . $_SESSION['middlename']);
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
$line++;
// Выводим название отчета
$activeSheet->setCellValue("A{$line}", "Отчет составлен в рублях (с НДС)");
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
# СТРОКА 5
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
$activeSheet->setCellValue("C{$line}", 'НОМЕР' . "\n" . 'ДАТА ДОГОВОРА');
$activeSheet->setCellValue("D{$line}", 'ДАТА' . "\n" . 'НАЧАЛА');
$activeSheet->setCellValue("E{$line}", 'ДАТА' . "\n" . 'ЗАВЕРШЕНИЯ');
$activeSheet->setCellValue("F{$line}", 'ТИТУЛ,' . "\n" . 'ПРЕДМЕТ ДОГОВОРА');
$activeSheet->setCellValue("G{$line}", 'СУММА' . "\n" . 'ДОГОВОРА');
$activeSheet->setCellValue("H{$line}", 'ЗАКРЫТО ПО АКТАМ' . "\n" . 'ф. КС-2, КС-3');
$activeSheet->setCellValue("I{$line}", 'ПОЛУЧЕНО СРЕДСТВ' . "\n" . '(ВСЕГО)');
$activeSheet->setCellValue("J{$line}", 'СУБПОДРЯД' . "\n" . '(%)');
$activeSheet->setCellValue("K{$line}", 'РЕНТАБЕЛЬНОСТЬ' . "\n" . '(%)');
// Стили для текста в шапки таблицы.
$activeSheet->getRowDimension($line)->setRowHeight(36); // высота строки
$activeSheet->getStyle("A{$line}:K{$line}")->getFont()->setSize(10); // размер шрифта
$activeSheet->getStyle("A{$line}:K{$line}")->getFont()->setBold(true); // делаем шрифт жирным
$activeSheet->getStyle("A{$line}:K{$line}")->getAlignment()->setWrapText(true); // разрешаем перенос строк в ячейке
$activeSheet->getStyle("A{$line}:K{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); // вырванивание по вертикали - середина
// Выравнивание по горизонтали - слева
$activeSheet->getStyle("B{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("F{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
// Выравнивание по горизонтали - центр
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$activeSheet->getStyle("C{$line}:E{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$activeSheet->getStyle("G{$line}:K{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
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
// Подшапка таблицы
$activeSheet->setCellValue("A{$line}", '1');
$activeSheet->setCellValue("B{$line}", '2');
$activeSheet->setCellValue("C{$line}", '4');
$activeSheet->setCellValue("D{$line}", '5');
$activeSheet->setCellValue("E{$line}", '6');
$activeSheet->setCellValue("F{$line}", '7');
$activeSheet->setCellValue("G{$line}", '8');
$activeSheet->setCellValue("H{$line}", '10');
$activeSheet->setCellValue("I{$line}", '11');
$activeSheet->setCellValue("J{$line}", '18');
$activeSheet->setCellValue("K{$line}", '24');
// Стили для текста в шапки таблицы.
$activeSheet->getRowDimension($line)->setRowHeight(18); // высота строки
$activeSheet->getStyle("A{$line}:K{$line}")->getFont()->setSize(10); // размер шрифта
$activeSheet->getStyle("A{$line}:K{$line}")->getFont()->setBold(false); // делаем шрифт жирным
$activeSheet->getStyle("A{$line}:K{$line}")->getAlignment()->setWrapText(true); // разрешаем перенос строк в ячейке
$activeSheet->getStyle("A{$line}:K{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); // вырванивание по вертикали - середина
// Выравнивание по горизонтали - центр
$activeSheet->getStyle("A{$line}:K{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// Делаем заливку области ячеек
$activeSheet->getStyle("A{$line}:K{$line}")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$activeSheet->getStyle("A{$line}:K{$line}")->getFill()->getStartColor()->setRGB("31708F");
// Задаем цвет текста строки
$activeSheet->getStyle("A{$line}:K{$line}")->getFont()->getColor()->setRGB('FFFFFF');
// Оформляем границы
$activeSheet->getStyle("A{$line}:K{$line}")->applyFromArray($_BORDER_INSIDE);
// $activeSheet->getStyle("A{$line}:K{$line}")->applyFromArray($_BORDER_OUTSIDE_THICK);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
// Делаем выборку договоров
$sql_query_docbase = "SELECT * FROM dognet_docbase WHERE koddel<>'99'";
$sql_query_docbase .= " AND koddoc IN (SELECT koddoc FROM dognet_dockalplan WHERE koddel<>'99'";
$sql_query_docbase .= " AND kodkalplan IN (SELECT kodkalplan FROM dognet_kalplanchf WHERE koddel<>'99' AND (chetfdate BETWEEN '" . $start_date . "' AND '" . $end_date . "')))";
$sql_query_docbase .= " AND kodshab<>'0'";

$_QRY_DOCBASE = mysqlQuery($sql_query_docbase);
$_SUM_TOTAL = 0.0;
$_ITOGO_CHF = 0.0;
$_ITOGO_OPLCHF = 0.0;
$_ITOGO_DOC = 0.0;
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
	$sql_query_dockalplan .= " AND kodkalplan IN (SELECT kodkalplan FROM dognet_kalplanchf WHERE koddel<>'99' AND (chetfdate BETWEEN '" . $start_date . "' AND '" . $end_date . "'))";
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
	//
	$_colSUBPERC_msg = null;
	$_colSUBPERC_msg_cnt = 0;
	# ----- ----- ----- ----- -----
	# При договоре с календарным планом
	if ($_ROW_DOCBASE['kodshab'] == 1 or $_ROW_DOCBASE['kodshab'] == 3) {
		while ($_ROW_STAGE = mysqli_fetch_assoc($_QRY_STAGE)) {
			#
			// Сумма авансов по этапу
			$_QRY_AVSUM = mysqlQuery("SELECT SUM(summaavans) as sumavans, SUM(ostatokavans) as sumostavans FROM dognet_docavans WHERE koddel<>'99' AND koddoc='" . $_ROW_STAGE['kodkalplan'] . "' AND (dateavans BETWEEN '" . $start_date . "' AND '" . $end_date . "')");
			$_ROW_AVSUM = mysqli_fetch_assoc($_QRY_AVSUM);
			$sumavstage = $_ROW_AVSUM['sumavans'];
			$sumostavstage = $_ROW_AVSUM['sumostavans'];
			// Суммируем авансы и остатки авансов по этапам и получаем суммы по договору
			$_SUM_STAGE_AV += $sumavstage;
			$_SUM_STAGE_OSTAV += $sumostavstage;
			#
			// Сумма СФ по этапу
			$_QRY_CHFSUM = mysqlQuery("SELECT SUM(chetfsumma) as sumchf FROM dognet_kalplanchf WHERE koddel<>'99' AND kodkalplan='" . $_ROW_STAGE['kodkalplan'] . "' AND (chetfdate BETWEEN '" . $start_date . "' AND '" . $end_date . "')");
			$_ROW_CHFSUM = mysqli_fetch_assoc($_QRY_CHFSUM);
			$sumchfstage = $_ROW_CHFSUM['sumchf'];
			// Суммируем СФ по этапам и получаем сумму по договору
			$_SUM_STAGE_CHF += $sumchfstage;
			#
			// Сумма договоров субподряда по этапу
			$_QRY_SUMSUB = mysqlQuery("SELECT SUM(sumdocsubpodr) as sumsubpodr FROM dognet_docsubpodr WHERE koddel<>'99' AND koddoc='" . $_ROW_STAGE['kodkalplan'] . "'");
			$_QRY_NUMSUB = mysqlQuery("SELECT koddocsubpodr FROM dognet_docsubpodr WHERE koddel<>'99' AND koddoc='" . $_ROW_STAGE['kodkalplan'] . "'");
			if (mysqli_num_rows($_QRY_NUMSUB) > 0) {
				$_ROW_SUMSUB = mysqli_fetch_assoc($_QRY_SUMSUB);
				$sumsubstage = $_ROW_SUMSUB['sumsubpodr'];
				// Суммируем субподряды по этапам и получаем сумму по договору
				$_SUM_STAGE_SUBPODR += $sumsubstage;
				$_colSUBPERC_msg_cnt = $_colSUBPERC_msg_cnt + 1;
			} else {
				// $_SUM_STAGE_SUBPODR = 0.0;
			}
			$_colSUBPERC_msg = $_colSUBPERC_msg_cnt > 0 ? "sub_exist" : "sub_no";
			#
			$_QRY_CHF = mysqlQuery("SELECT * FROM dognet_kalplanchf WHERE koddel<>'99' AND (chetfdate BETWEEN '" . $start_date . "' AND '" . $end_date . "') AND kodkalplan = '" . $_ROW_STAGE['kodkalplan'] . "'");
			// Сумма оплат СФ по этапу
			$_SUM_CHF_OPL = 0.0;
			// Сумма погашенных авансов по этапу
			$_SUM_CHF_OPLAV = 0.0;
			#
			while ($_ROW_CHF = mysqli_fetch_assoc($_QRY_CHF)) {
				#
				// Сумма оплат по СФ
				$_QRY_OPLCHFSUM = mysqlQuery("SELECT SUM(summaopl) as sumoplchf FROM dognet_oplatachf WHERE koddel<>'99' AND kodchfact='" . $_ROW_CHF['kodchfact'] . "' AND (dateopl BETWEEN '" . $start_date . "' AND '" . $end_date . "')");
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
		}
	}
	# ----- ----- ----- ----- -----
	# При договоре без календарного плана
	if ($_ROW_DOCBASE['kodshab'] == 2 or $_ROW_DOCBASE['kodshab'] == 4) {
		#
		// Сумма авансов по договору
		$_QRY_AVSUM = mysqlQuery("SELECT SUM(summaavans) as sumavans, SUM(ostatokavans) as sumostavans FROM dognet_docavans WHERE koddel<>'99' AND koddoc='" . $_ROW_STAGE['kodkalplan'] . "' AND (dateavans BETWEEN '" . $start_date . "' AND '" . $end_date . "')");
		$_ROW_AVSUM = mysqli_fetch_assoc($_QRY_AVSUM);
		$sumavstage = $_ROW_AVSUM['sumavans'];
		$sumostavstage = $_ROW_AVSUM['sumostavans'];
		// Суммируем авансы по этапам и получаем сумму по договору
		$_SUM_STAGE_AV += $sumavstage;
		$_SUM_STAGE_OSTAV += $sumostavstage;
		#
		// Сумма СФ по договору
		$_QRY_CHFSUM = mysqlQuery("SELECT SUM(chetfsumma) as sumchf FROM dognet_kalplanchf WHERE koddel<>'99' AND kodkalplan='" . $_ROW_STAGE['kodkalplan'] . "' AND (chetfdate BETWEEN '" . $start_date . "' AND '" . $end_date . "')");
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
			// $_SUM_STAGE_SUBPODR = 0.0;
			$_colSUBPERC_msg = "sub_no";
		}
		#
		$_QRY_CHF = mysqlQuery("SELECT * FROM dognet_kalplanchf WHERE koddel<>'99' AND (chetfdate BETWEEN '" . $start_date . "' AND '" . $end_date . "') AND kodkalplan = '" . $_ROW_DOCBASE['koddoc'] . "'");
		// Сумма оплат СФ
		$_SUM_CHF_OPL = 0.0;
		// Сумма погашенных авансов
		$_SUM_CHF_OPLAV = 0.0;
		#
		while ($_ROW_CHF = mysqli_fetch_assoc($_QRY_CHF)) {
			#
			// Сумма оплат по СФ
			$_QRY_OPLCHFSUM = mysqlQuery("SELECT SUM(summaopl) as sumoplchf FROM dognet_oplatachf WHERE koddel<>'99' AND kodchfact='" . $_ROW_CHF['kodchfact'] . "' AND (dateopl BETWEEN '" . $start_date . "' AND '" . $end_date . "')");
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
	}
	# ----- ----- ----- ----- -----
	#
	$_SUM_TOTAL_AV += $_SUM_STAGE_AV;
	$_SUM_TOTAL_OSTAV += $_SUM_STAGE_OSTAV;
	$_SUM_TOTAL_CHF += $_SUM_STAGE_CHF;
	$_SUM_TOTAL_OPLCHF += $_SUM_STAGE_OPLCHF;
	$_SUM_TOTAL_OPLAVCHF += $_SUM_STAGE_OPLAVCHF;
	$_SUM_TOTAL_SUBPODR += $_SUM_STAGE_SUBPODR;
	#
	// Сумма авансов и остатков авансов по договору
	$_colSUMAV = $_SUM_TOTAL_AV;
	$_colSUMOSTAV = $_SUM_TOTAL_OSTAV;
	// Сумма СФ по договору
	$_colSUMCHF = $_SUM_TOTAL_CHF;
	// Сумма зачетов авансов по договору
	$_colSUMOPLAVCHF = $_SUM_TOTAL_OPLAVCHF;
	// Сумма оплат СФ по договору
	$_colSUMOPLCHF = $_SUM_TOTAL_OPLCHF;
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	// Задаем высоту строки и шрифт
	$activeSheet->getRowDimension($line)->setRowHeight(18);
	$activeSheet->getStyle("A{$line}:K{$line}")->getFont()->setSize(10);
	$activeSheet->getStyle("A{$line}:K{$line}")->getFont()->setBold(false);
	// Задаем цвет текста строки
	$activeSheet->getStyle("A{$line}:K{$line}")->getFont()->getColor()->setRGB('111111');
	// Выравниваем строку по вертикали ( середина )
	$activeSheet->getStyle("A{$line}:K{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	// Выравнивание по горизонтали - слева
	$activeSheet->getStyle("B{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$activeSheet->getStyle("F{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	// Выравнивание по горизонтали - центр
	$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$activeSheet->getStyle("C{$line}:E{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$activeSheet->getStyle("G{$line}:K{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	// Если сумма договора была нулевой, то выводим сумму этапов
	if ($_colSUMDOC == 0) {
		$_colSUMDOC = $_colSUMSTAGES;
	}
	//
	$activeSheet->setCellValue("A{$line}", $_colN);
	$activeSheet->setCellValue("B{$line}", $_colZAK);
	$activeSheet->setCellValue("C{$line}", "3-4/" . $_colNUM);
	$activeSheet->setCellValue("D{$line}", $_colDATE1);
	$activeSheet->setCellValue("E{$line}", $_colDATE2);
	$activeSheet->setCellValue("F{$line}", $_colDOC);
	$activeSheet->setCellValue("G{$line}", $_colSUMDOC);
	$activeSheet->getStyle("G{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
	$activeSheet->setCellValue("H{$line}", $_colSUMCHF);
	$activeSheet->getStyle("H{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
	$activeSheet->setCellValue("I{$line}", $_colSUMOPLCHF + $_colSUMAV);
	$activeSheet->getStyle("I{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
	// Процент субподряда (сумма всех субподрядов к сумме этапов)
	if ($_colSUBPERC_msg == "sub_exist") {
		if ($_colSUMSTAGES <> 0) {
			$_colSUBPERC = ($_SUM_TOTAL_SUBPODR / $_colSUMSTAGES) * 100;
			$activeSheet->setCellValue("J{$line}", $_colSUBPERC);
			$activeSheet->getStyle("J{$line}")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
		} else {
			$activeSheet->setCellValue("J{$line}", "ДОГ = 0");
		}
	} else {
		$activeSheet->setCellValue("J{$line}", "НЕТ СУБ");
	}
	$activeSheet->setCellValue("K{$line}", $_SUM_TOTAL_SUBPODR . " / " . $_colSUMSTAGES);
	// Оформляем границы
	$activeSheet->getStyle("A{$line}:K{$line}")->applyFromArray($_BORDER_INSIDE);
	$activeSheet->getStyle("A{$line}:K{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
	$_colN++;
	#
	#
	$_ITOGO_CHF += $_SUM_TOTAL_CHF;
	$_ITOGO_OPLCHF += $_SUM_TOTAL_OPLCHF + $_SUM_TOTAL_AV;
	$_ITOGO_DOC += $_colSUMDOC;
	#
	#
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	# Следующая строка
	$line++;
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	#
	#
}
// Задаем высоту строки и шрифт
$activeSheet->getRowDimension($line)->setRowHeight(24);
$activeSheet->getStyle("A{$line}:K{$line}")->getFont()->setSize(12);
$activeSheet->getStyle("A{$line}:K{$line}")->getFont()->setBold(true);
// Задаем цвет текста строки
$activeSheet->getStyle("A{$line}:K{$line}")->getFont()->getColor()->setRGB('111111');
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:F{$line}");
// Выравниваем строку по вертикали ( середина )
$activeSheet->getStyle("A{$line}:K{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Выравнивание по горизонтали - центр
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
// Выравнивание по горизонтали - центр
$activeSheet->getStyle("G{$line}:I{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$activeSheet->setCellValue("A{$line}", "ИТОГО: ");
$activeSheet->setCellValue("G{$line}", $_ITOGO_DOC);
$activeSheet->getStyle("G{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
$activeSheet->setCellValue("H{$line}", $_ITOGO_CHF);
$activeSheet->getStyle("H{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
$activeSheet->setCellValue("I{$line}", $_ITOGO_OPLCHF);
$activeSheet->getStyle("I{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
// Оформляем границы
$activeSheet->getStyle("A{$line}:K{$line}")->applyFromArray($_BORDER_INSIDE);
$activeSheet->getStyle("A{$line}:K{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
// Добавляем рамку к шапке таблицы
$activeSheet->getStyle("A{$start_table}:K{$start_table}")->applyFromArray($_BORDER_OUTSIDE_THIN);
// Добавляем рамку ко всей таблице
$activeSheet->getStyle("A{$start_table}:K{$line}")->applyFromArray($_BORDER_OUTSIDE_THIN);
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# СТРОКА ПОДПИСИ РУКОВОДИТЕЛЯ
#
$line++;
$line++;
$line++;
// Выводим название отчета
$activeSheet->setCellValue("A{$line}", "Руководитель предприятия: ________________ / ________________ /");
// Задаем высоту строки
$activeSheet->getRowDimension($line)->setRowHeight(20);
// Объединяем ячейки по горизонтали
// $activeSheet->mergeCells("A{$line}:K{$line}");
// Делаем выравнивание по центру вертикали и горизонтали
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("A{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Делаем текст жирным и увеличиваем шрифт.
$activeSheet->getStyle("A{$line}")->getFont()->setBold(true);
$activeSheet->getStyle("A{$line}")->getFont()->setSize(13);
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# СТРОКА ПОДПИСИ ГЛ БУХГАЛТЕРА
#
$line++;
$line++;
$line++;
// Выводим название отчета
$activeSheet->setCellValue("A{$line}", "Главный бухгалтер: ________________ / ________________ /");
// Задаем высоту строки
$activeSheet->getRowDimension($line)->setRowHeight(20);
// Объединяем ячейки по горизонтали
// $activeSheet->mergeCells("A{$line}:K{$line}");
// Делаем выравнивание по центру вертикали и горизонтали
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("A{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Делаем текст жирным и увеличиваем шрифт.
$activeSheet->getStyle("A{$line}")->getFont()->setBold(true);
$activeSheet->getStyle("A{$line}")->getFont()->setSize(13);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# СТРОКА ИСПОЛНИТЕЛЯ
#
$line++;
// Выводим название отчета
$activeSheet->setCellValue("A{$line}", "Исполнитель:");
// Задаем высоту строки
$activeSheet->getRowDimension($line)->setRowHeight(18);
// Объединяем ячейки по горизонтали
// $activeSheet->mergeCells("A{$line}:K{$line}");
// Делаем выравнивание по центру вертикали и горизонтали
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("A{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Делаем текст жирным и увеличиваем шрифт.
$activeSheet->getStyle("A{$line}")->getFont()->setBold(false);
$activeSheet->getStyle("A{$line}")->getFont()->setSize(11);
#
#
$line++;
// Выводим название отчета
$activeSheet->setCellValue("A{$line}", "Телефон:");
// Задаем высоту строки
$activeSheet->getRowDimension($line)->setRowHeight(18);
// Объединяем ячейки по горизонтали
// $activeSheet->mergeCells("A{$line}:K{$line}");
// Делаем выравнивание по центру вертикали и горизонтали
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("A{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Делаем текст жирным и увеличиваем шрифт.
$activeSheet->getStyle("A{$line}")->getFont()->setBold(false);
$activeSheet->getStyle("A{$line}")->getFont()->setSize(11);

// $objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());
// $objPHPExcel->getActiveSheet()->setAutoFilter("A{$start_table}:I{$start_table}");
