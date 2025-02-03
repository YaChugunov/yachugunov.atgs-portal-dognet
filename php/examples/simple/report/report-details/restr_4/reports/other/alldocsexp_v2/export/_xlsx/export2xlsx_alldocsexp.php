<?php
#
#
// $on_date = date("Y-m-d", strtotime($_GET['on_date']));
$on_date = $_GET['on_date'];
#
#
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
$activeSheet->getColumnDimension('A')->setWidth(13); // Номер договора
$activeSheet->getColumnDimension('B')->setWidth(15); // Дата договора
$activeSheet->getColumnDimension('C')->setWidth(8); // Номер этапа
$activeSheet->getColumnDimension('D')->setWidth(90); // Название договора / этапа
$activeSheet->getColumnDimension('E')->setWidth(21); // Тип
$activeSheet->getColumnDimension('F')->setWidth(33); // Заказчик
$activeSheet->getColumnDimension('G')->setWidth(35); // Объект
$activeSheet->getColumnDimension('H')->setWidth(12); // Срок
$activeSheet->getColumnDimension('I')->setWidth(12); // Дата СФ
$activeSheet->getColumnDimension('J')->setWidth(8); // Просрочка
#
// Для удобства заводим переменную $line, в ней будем считать номер строки
$line = 1;
#
# ----- ----- ----- ----- -----
# СТРОКА 1
# ----- ----- ----- ----- -----
// Выводим название отчета
$activeSheet->setCellValue("A{$line}", 'ДОГОВОРА С ИСТЕКШИМИ СРОКАМИ ВЫПОЛНЕНИЯ ЗА ' . $on_date . " ГОД (ВЕРСИЯ 2)");
// Задаем высоту строки
$activeSheet->getRowDimension($line)->setRowHeight(24);
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:J{$line}");
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
$activeSheet->mergeCells("C{$line}:J{$line}");
// Делаем выравнивание по центру вертикали и горизонтали
$activeSheet->getStyle("A{$line}:J{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("A{$line}:J{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Делаем текст жирным и увеличиваем шрифт.
$activeSheet->getStyle("A{$line}:J{$line}")->getFont()->setBold(true);
$activeSheet->getStyle("A{$line}:J{$line}")->getFont()->setSize(13);
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
$activeSheet->mergeCells("C{$line}:J{$line}");
// Делаем выравнивание по центру вертикали и горизонтали
$activeSheet->getStyle("A{$line}:J{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("A{$line}:J{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Делаем текст жирным и увеличиваем шрифт.
$activeSheet->getStyle("A{$line}:J{$line}")->getFont()->setBold(true);
$activeSheet->getStyle("A{$line}:J{$line}")->getFont()->setSize(13);
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
$activeSheet->mergeCells("C{$line}:J{$line}");
// Делаем выравнивание по центру вертикали и горизонтали
$activeSheet->getStyle("A{$line}:J{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("A{$line}:J{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Делаем текст жирным и увеличиваем шрифт.
$activeSheet->getStyle("A{$line}:J{$line}")->getFont()->setBold(true);
$activeSheet->getStyle("A{$line}:J{$line}")->getFont()->setSize(13);
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
$activeSheet->setCellValue("A{$line}", 'Договор');
$activeSheet->setCellValue("B{$line}", 'Дата нач');
$activeSheet->setCellValue("C{$line}", 'Этап');
$activeSheet->setCellValue("D{$line}", 'Название договора / этапа');
$activeSheet->setCellValue("E{$line}", 'Тип');
$activeSheet->setCellValue("F{$line}", 'Заказчик');
$activeSheet->setCellValue("G{$line}", 'Объект');
$activeSheet->setCellValue("H{$line}", 'Срок');
$activeSheet->setCellValue("I{$line}", 'Дата СФ');
$activeSheet->setCellValue("J{$line}", 'Нед');
// Стили для текста в шапки таблицы.
$activeSheet->getRowDimension($line)->setRowHeight(36); // высота строки
$activeSheet->getStyle("A{$line}:J{$line}")->getFont()->setSize(12); // размер шрифта
$activeSheet->getStyle("A{$line}:J{$line}")->getFont()->setBold(true); // делаем шрифт жирным
$activeSheet->getStyle("A{$line}:J{$line}")->getAlignment()->setWrapText(true); // разрешаем перенос строк в ячейке
// Выравнивание по вертикали
$activeSheet->getStyle("A{$line}:J{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Выравнивание по горизонтали
$activeSheet->getStyle("A{$line}:C{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$activeSheet->getStyle("D{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("E{$line}:J{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// Делаем заливку области ячеек
$activeSheet->getStyle("A{$line}:J{$line}")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$activeSheet->getStyle("A{$line}:J{$line}")->getFill()->getStartColor()->setRGB("31708F");
// Задаем цвет текста строки
$activeSheet->getStyle("A{$line}:J{$line}")->getFont()->getColor()->setRGB('FFFFFF');
// Оформляем границы
$activeSheet->getStyle("A{$line}:J{$line}")->applyFromArray($_BORDER_INSIDE);
$activeSheet->getStyle("A{$line}:J{$line}")->applyFromArray($_BORDER_OUTSIDE_THICK);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
$NY = $on_date + 1;
// Делаем выборку этапов по идентификатору этапа (kodkalplan)
$_sqlText = "
SELECT
	dognet_docbase.koddoc as koddoc, dognet_docbase.docnumber as docnumber, dognet_docbase.docnameshot as docnameshot, dognet_docbase.docsumma as docsumma, dognet_docbase.daynachdoc as docday, dognet_docbase.monthnachdoc as docmonth, dognet_docbase.yearnachdoc as docyear, dognet_dockalplan.idobjectready as objectready, dognet_dockalplan.kodkalplan as kodkalplan, dognet_dockalplan.numberstage as numberstage, dognet_dockalplan.nameshotstage as nameshotstage, dognet_dockalplan_progress.summastage as summastage, dognet_dockalplan_progress.srokstage_date as srokstage_date, dognet_docbase.kodobject as kodobject, sp_objects.nameobjectshot as nameobjectshot, dognet_docbase.kodstatus as kodstatus, dognet_spstatus.statusnameshot as statusnameshot, dognet_sptipdog.nametip as nametip, sp_contragents.nameshort as nameshort, dognet_docbase.kodtip as kodtip,
    dognet_kalplanchf.kodchfact as kodchfact, dognet_kalplanchf.chetfdate as chetfdate, dognet_kalplanchf.chetfnumber as chetfnumber, dognet_kalplanchf.chetfsumma as chetfsumma
	FROM dognet_dockalplan_progress
	LEFT JOIN dognet_dockalplan ON dognet_dockalplan_progress.kodkalplan = dognet_dockalplan.kodkalplan
	LEFT JOIN dognet_kalplanchf ON dognet_dockalplan_progress.kodkalplan = dognet_kalplanchf.kodkalplan
	LEFT JOIN dognet_docbase ON dognet_dockalplan_progress.koddoc = dognet_docbase.koddoc
	LEFT JOIN sp_objects ON dognet_docbase.kodobject = sp_objects.kodobject
	LEFT JOIN sp_contragents ON dognet_docbase.kodzakaz = sp_contragents.kodcontragent
	LEFT JOIN dognet_spstatus ON dognet_docbase.kodstatus = dognet_spstatus.kodstatus
	LEFT JOIN dognet_sptipdog ON dognet_docbase.kodtip = dognet_sptipdog.kodtip
	WHERE
	(
	dognet_dockalplan_progress.kodkalplan IN (SELECT kodkalplan FROM dognet_kalplanchf WHERE YEAR(chetfdate)='" . $on_date . "' AND koddel!='99' ORDER BY kodchfact DESC)
    AND YEAR(dognet_kalplanchf.chetfdate)='" . $on_date . "'
    AND	dognet_dockalplan_progress.srokstage_date!='0000-00-00' AND dognet_dockalplan_progress.srokstage_date!='NULL' AND dognet_dockalplan_progress.srokstage_date!=''
    AND dognet_docbase.kodtip IN ('245287841608965')
	)
	OR
    (
	dognet_dockalplan_progress.kodkalplan IN (SELECT kodkalplan FROM dognet_kalplanchf WHERE YEAR(chetfdate)='" . $on_date . "' AND chetfdate=(SELECT MAX(chetfdate) FROM dognet_kalplanchf WHERE kodkalplan=dognet_dockalplan_progress.kodkalplan AND YEAR(chetfdate)='" . $on_date . "') AND koddel!='99')
    AND dognet_dockalplan_progress.kodkalplan NOT IN (SELECT kodkalplan FROM dognet_kalplanchf WHERE YEAR(chetfdate)='" . $NY . "')
    AND dognet_dockalplan_progress.kodkalplan=(SELECT MAX(kodkalplan) FROM dognet_dockalplan_progress WHERE koddoc=dognet_docbase.koddoc)
    AND YEAR(dognet_kalplanchf.chetfdate)='" . $on_date . "'
    AND dognet_kalplanchf.kodchfact=(SELECT MAX(kodchfact) FROM dognet_kalplanchf WHERE kodkalplan=dognet_dockalplan.kodkalplan)
	AND dognet_dockalplan_progress.srokstage_date!='0000-00-00' AND dognet_dockalplan_progress.srokstage_date!='NULL' AND dognet_dockalplan_progress.srokstage_date!=''
    AND dognet_docbase.kodtip NOT IN ('245287841608965')
	AND dognet_docbase.kodstatus IN ('245287853877236')
	)
    ORDER BY koddoc DESC, numberstage ASC, chetfdate DESC
    ";
$_QRY = mysqlQuery($_sqlText);
//
while ($_ROW = mysqli_fetch_assoc($_QRY)) {
    $_DOCSTS = $_ROW['statusnameshot'];
    $_DOCTIP = $_ROW['nametip'];
    $_DOCZAK = $_ROW['nameshort'];
    $_DOCOBJ = $_ROW['nameobjectshot'];
    $_DOCNAME = $_ROW['docnameshot'];
    $_DOCNUM = $_ROW['docnumber'];
    //
    $_DOCDATE_NACH_DAY = ($_ROW['docday'] != "" && $_ROW['docday'] != 0) ? str_pad($_ROW['docday'], 2, '0', STR_PAD_LEFT) : "--";
    $_DOCDATE_NACH_MON = ($_ROW['docmonth'] != "" && $_ROW['docmonth'] != 0) ? str_pad($_ROW['docmonth'], 2, '0', STR_PAD_LEFT) : "--";
    $_DOCDATE_NACH_YER = ($_ROW['docyear'] != "" && $_ROW['docyear'] != 0) ? str_pad($_ROW['docyear'], 2, '0', STR_PAD_LEFT) : "----";
    $_DOCDATE = $_DOCDATE_NACH_DAY . "." . $_DOCDATE_NACH_MON . "." . $_DOCDATE_NACH_YER;
    //
    $_STAGENAME = $_ROW['nameshotstage'];
    $_STAGENUM = $_ROW['numberstage'];
    $_SUMSTAGE = $_ROW['summastage'];
    $_SROKSTAGE = $_ROW['srokstage_date'];
    $_OBJREADY = $_ROW['objectready'];

    $_CHFNUM = $_ROW['chetfnumber'];
    $_CHFDATE = $_ROW['chetfdate'];

    $datesrok = new DateTime($_ROW['srokstage_date']);
    // $datenow = new DateTime($on_date);
    $chfdate = new DateTime($_CHFDATE);
    $diff = $datesrok->diff($chfdate)->format('%R%a');

    $_PROSRO4KA = round($diff / 7);

    //** >>> UPDATE 17.09.2024
    # 1. Проверяем наличие счета-фактуры по договору в следующем за годом отчета
    # 2. Считаем сумму всех счетов-фактур по договору и сравниваем с суммой договора
    #
    $koddoc = $_ROW['koddoc'];
    $docsumma = $_ROW['docsumma'];
    $kodstatus = $_ROW['kodstatus'];
    $kodtip = $_ROW['kodtip'];
    // Статус закрыт: 245287853877236
    $kodchfact = $_ROW['kodchfact'];
    //
    // $NY = date('Y', strtotime('+1 year', strtotime($on_date)));
    $_sqlChfNY = "SELECT * FROM dognet_kalplanchf WHERE YEAR(chetfdate)='{$NY}' AND kodkalplan IN (SELECT kodkalplan FROM dognet_dockalplan WHERE koddoc='{$koddoc}')";
    $_reqChfNY = mysqlQuery("SELECT * FROM dognet_kalplanchf WHERE YEAR(chetfdate)='{$NY}' AND kodkalplan IN (SELECT kodkalplan FROM dognet_dockalplan WHERE koddoc='{$koddoc}')");
    $_rowChfSum = mysqli_fetch_assoc(mysqlQuery("SELECT SUM(chetfsumma) as sumchf FROM dognet_kalplanchf WHERE kodkalplan IN (SELECT kodkalplan FROM dognet_dockalplan WHERE koddoc='{$koddoc}')"));
    $SUMCHF = $_rowChfSum['sumchf'];
    //
    #
    //** <<< UPDATE 17.09.2024

    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    // Задаем высоту строки и шрифт
    $activeSheet->getRowDimension($line)->setRowHeight(18);
    $activeSheet->getStyle("A{$line}:J{$line}")->getFont()->setSize(10);
    $activeSheet->getStyle("A{$line}:J{$line}")->getFont()->setBold(false);
    // Задаем цвет текста строки
    $activeSheet->getStyle("A{$line}:J{$line}")->getFont()->getColor()->setRGB('111111');
    // Выравниваем строку по вертикали ( середина )
    $activeSheet->getStyle("A{$line}:J{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    // Выравнивание по горизонтали
    $activeSheet->getStyle("A{$line}:C{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $activeSheet->getStyle("D{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $activeSheet->getStyle("E{$line}:J{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $activeSheet->setCellValue("A{$line}", '3-4/' . $_DOCNUM);
    $activeSheet->setCellValue("B{$line}", $_DOCDATE);
    $activeSheet->setCellValue("C{$line}", $_STAGENUM);
    $activeSheet->setCellValue("D{$line}", $_DOCNAME . ' / ' . $_STAGENAME);
    $activeSheet->setCellValue("E{$line}", $_DOCTIP);
    $activeSheet->setCellValue("F{$line}", $_DOCZAK);
    $activeSheet->setCellValue("G{$line}", $_DOCOBJ);
    if ($_OBJREADY == '1') {
        $activeSheet->getStyle("H{$line}")->getFont()->getColor()->setRGB('D9534F');
        $activeSheet->setCellValue("H{$line}", date("d.m.Y", strtotime($_CHFDATE)));
        $activeSheet->setCellValue("J{$line}", "---");
    } else {
        $activeSheet->setCellValue("H{$line}", date("d.m.Y", strtotime($_SROKSTAGE)));
        $activeSheet->setCellValue("J{$line}", $_PROSRO4KA <= 0 ? "---" : $_PROSRO4KA);
    }
    $activeSheet->setCellValue("I{$line}", date("d.m.Y", strtotime($_CHFDATE)));
    // Оформляем границы
    $activeSheet->getStyle("A{$line}:J{$line}")->applyFromArray($_BORDER_INSIDE);
    $activeSheet->getStyle("A{$line}:J{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
    if ($_PROSRO4KA > 0) {
        // Делаем заливку области ячеек
        $activeSheet->getStyle("A{$line}:J{$line}")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $activeSheet->getStyle("A{$line}:J{$line}")->getFill()->getStartColor()->setRGB("fff0f0");
    }
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    // Следующая строка
    $line++;
}
// $activeSheet->setCellValue("A{$line}", $_sqlText);
// $line++;
// $activeSheet->setCellValue("A{$line}", $_sqlChfNY);
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Возвращаемся на 1 строку
//     $line = $line - 1;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
$end_table = $line - 1;
// Добавляем рамку к шапке таблицы
$activeSheet->getStyle("A{$start_table}:J{$start_table}")->applyFromArray($_BORDER_OUTSIDE_THIN);
// Добавляем рамку ко всей таблице
$activeSheet->getStyle("A{$start_table}:J{$end_table}")->applyFromArray($_BORDER_OUTSIDE_THIN);

// $objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());
// $objPHPExcel->getActiveSheet()->setAutoFilter("A{$start_table}:I{$start_table}");