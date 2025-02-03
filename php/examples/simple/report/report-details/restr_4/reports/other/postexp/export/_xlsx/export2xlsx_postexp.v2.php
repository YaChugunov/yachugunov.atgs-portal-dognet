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
$ondate = date("Y-m-d", strtotime($_GET['ondate']));
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
$activeSheet->setCellValue("A{$line}", 'Договора поставки с истёкшими сроками выполнения на ' . date("d.m.Y", strtotime($ondate)));
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
// $_QRY_MAIN = mysqlQuery("SELECT koddoc as koddoc, kodkalplan as kodkalplan, summastage as summastage, srokstage_date as srokstage_date, '1' as kodshab
// FROM dognet_dockalplan_progress WHERE srokstage_date <= '{$ondate}' AND srokstage_date != '0000-00-00' AND srokstage_date != 'NULL' AND srokstage_date != '' AND zadolsum_stage > 0 AND koddoc IN (SELECT koddoc FROM dognet_docbase WHERE (kodstatus='245381842747296' OR kodstatus='245597345680479' OR kodstatus='245267756667430' OR kodstatus='245381842145343') AND (kodtip='245287841608965' OR kodtip='245287841599652') AND koddel<>'99')
// UNION
// SELECT koddoc as koddoc, koddoc as kodkalplan, docsumma as summastage, STR_TO_DATE(CONCAT(yearenddoc,'-',monthenddoc,'-',dayenddoc), '%Y-%m-%d') as srokstage_date, kodshab as kodshab FROM dognet_docbase WHERE STR_TO_DATE(CONCAT(yearenddoc,'-',monthenddoc,'-',dayenddoc), '%Y-%m-%d') <= '{$ondate}' AND (kodstatus='') AND (yearenddoc<>'0' AND monthenddoc<>'0' AND dayenddoc<>'0') AND (kodtip='245287841608965' OR kodtip='245287841599652') AND numberchet<>'' AND kodshab='0' AND koddel<>'99'
// ORDER BY koddoc DESC");
$_SUM_SHTRAF = 0.0;
$_SUM_ONSTAGE = 0.0;
//**
$_reqMain = mysqlQuery("SELECT * FROM dognet_docbase WHERE ((numberchet='' AND kodstatus IN ('245381842747296', '245597345680479', '245267756667430', '245381842145343')) OR (numberchet!='')) AND kodtip IN ('245287841608965', '245287841599652') AND koddel!='99' ORDER BY docnumber DESC");
while ($_rowData = mysqli_fetch_assoc($_reqMain)) {
    ##
    $koddoc = !empty($_rowData['koddoc']) ? $_rowData['koddoc'] : "";
    $kodshab = !empty($_rowData['kodshab']) ? $_rowData['kodshab'] : 0;
    $kodstatus = !empty($_rowData['kodstatus']) ? $_rowData['kodstatus'] : "";
    $kodzakaz = !empty($_rowData['kodzakaz']) ? $_rowData['kodzakaz'] : "";
    $docnum = !empty($_rowData['docnumber']) ? $_rowData['docnumber'] : "";
    $docsum = !empty($_rowData['docsumma']) ? $_rowData['docsumma'] : 0;
    $docdateE_Y = !empty($_rowData['yearenddoc']) ? $_rowData['yearenddoc'] : "";
    $docdateE_M = !empty($_rowData['monthenddoc']) ? $_rowData['monthenddoc'] : "";
    $docdateE_D = !empty($_rowData['dayenddoc']) ? $_rowData['dayenddoc'] : "";
    $docdateE = !empty($docdateE_Y) && !empty($docdateE_M) && !empty($docdateE_D) ? $docdateE_Y . "-" . $docdateE_M . "-" . $docdateE_D : "";
    $docdateE = !empty($docdateE) ? date("Y-m-d", strtotime($docdateE)) : null;
    $docname = !empty($_rowData['docnameshot']) ? $_rowData['docnameshot'] : "";
    $numberchet = !empty($_rowData['numberchet']) ? $_rowData['numberchet'] : "";
    ##
    $__CREATEROW = false;
    if (in_array($kodshab, array(1, 3))) {
        $_reqStage = mysqlQuery("SELECT * FROM dognet_dockalplan WHERE srokstage_date<='{$ondate}' AND srokstage_date!='0000-00-00' AND srokstage_date IS NOT NULL AND srokstage_date!='' AND koddoc='{$koddoc}' AND koddel!='99'");
        while ($_rowStage = mysqli_fetch_assoc($_reqStage)) {
            $kodkalplan = !empty($_rowStage['kodkalplan']) ? $_rowStage['kodkalplan'] : "";
            $stagename = !empty($_rowStage['nameshotstage']) ? $_rowStage['nameshotstage'] : "";
            $stagenum = !empty($_rowStage['numberstage']) ? $_rowStage['numberstage'] : "";
            $stagesum = !empty($_rowStage['summastage']) ? $_rowStage['summastage'] : 0;
            $stagedate = !empty($_rowStage['srokstage_date']) ? $_rowStage['srokstage_date'] : "";
            #
            $_reqDocStatus = $db_handle->runQuery("SELECT * FROM dognet_spstatus WHERE kodstatus = '{$kodstatus}'");
            $statusname = !empty($_reqDocStatus[0]['statusnameshot']) ? $_reqDocStatus[0]['statusnameshot'] : "";
            #
            $_reqContragents = $db_handle->runQuery("SELECT * FROM sp_contragents WHERE kodcontragent = '{$kodzakaz}'");
            $contrname = !empty($_reqContragents[0]['nameshort']) ? $_reqContragents[0]['nameshort'] : "";
            //**
            //** Считаем выполнение по этапу
            $_reqChetf = $db_handle->runQuery("SELECT SUM(chetfsumma) as sumchfondate FROM dognet_kalplanchf WHERE kodkalplan='{$kodkalplan}' AND chetfdate<='{$ondate}'");
            $_SUMCHFONDATE = !empty($_reqChetf[0]['sumchfondate']) ? $_reqChetf[0]['sumchfondate'] : 0;
            ##
            //**
            //** - - - - - - - - - -
            $_DOCSTS = !empty($statusname) ? $statusname : "";
            $_DOCZAK = !empty($contrname) ? $contrname : "";
            $_DOCNAME = !empty($docname) ? $docname : "";
            $_DOCNUM = !empty($docnum) ? "3-4/" . $docnum : "";
            $_STAGENAME = !empty($stagename) ? " / " . $stagename : "";
            $_STAGENUM = !empty($stagenum) ? $stagenum : "";
            $_SUMSTAGE = !empty($stagesum) ? $stagesum : 0;
            $_SROKSTAGE = !empty($stagedate) ? $stagedate : "";
            //** - - - - - - - - - -
            $datesrok = new DateTime($stagedate);
            $datenow = new DateTime($ondate);
            $diff = $datesrok->diff($datenow)->format('%a');
            #
            $_PROSRO4KA = $diff;
            $_SUMSHTRAF = $_SUMSTAGE * $_PROSRO4KA * $shtraf / 100;
            $__CREATEROW = ($_SUMSTAGE - $_SUMCHFONDATE) > 0 && $datesrok <= $datenow ? true : false;
            if ($__CREATEROW) {
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
                echo $kodshab . ": " . $_DOCNUM . " ( " . $ondate . " ) >>> [" . $_SROKSTAGE . " | " . $_PROSRO4KA . "] <> " . $_SUMSTAGE . " | " . $_SUMCHFONDATE;
                echo "<br>";
            }
        }
    } elseif (in_array($kodshab, array(2, 4))) {
        #
        $_reqDocStatus = $db_handle->runQuery("SELECT * FROM dognet_spstatus WHERE kodstatus = '{$kodstatus}'");
        $statusname = !empty($_reqDocStatus[0]['statusnameshot']) ? $_reqDocStatus[0]['statusnameshot'] : "";
        #
        $_reqContragents = $db_handle->runQuery("SELECT * FROM sp_contragents WHERE kodcontragent = '{$kodzakaz}'");
        $contrname = !empty($_reqContragents[0]['nameshort']) ? $_reqContragents[0]['nameshort'] : "";
        //**
        //** Считаем выполнение по этапу
        $_reqChetf = $db_handle->runQuery("SELECT SUM(chetfsumma) as sumchfondate FROM dognet_kalplanchf WHERE kodkalplan='{$koddoc}' AND chetfdate<='{$ondate}'");
        $_SUMCHFONDATE = !empty($_reqChetf[0]['sumchfondate']) ? $_reqChetf[0]['sumchfondate'] : 0;
        ##
        //**
        //** - - - - - - - - - -
        $_DOCSTS = !empty($statusname) ? $statusname : "";
        $_DOCZAK = !empty($contrname) ? $contrname : "";
        $_DOCNAME = !empty($docname) ? $docname : "";
        $_DOCNUM = !empty($docnum) ? "3-4/" . $docnum : "";
        $_STAGENAME = "/ Договор без календарного плана";
        $_STAGENUM = "";
        $_SUMSTAGE = $docsum;
        $_SROKSTAGE = $docdateE;
        //** - - - - - - - - - -
        $datesrok = new DateTime($docdateE);
        $datenow = new DateTime($ondate);
        $diff = $datesrok->diff($datenow)->format('%a');
        #
        $_PROSRO4KA = $diff;
        $_SUMSHTRAF = $_SUMSTAGE * $_PROSRO4KA * $shtraf / 100;
        $__CREATEROW = ($_SUMSTAGE - $_SUMCHFONDATE) > 0 && $datesrok <= $datenow ? true : false;
        if ($__CREATEROW) {
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
        echo $kodshab . ": " . $_DOCNUM . " ( " . $ondate . " ) >>> [" . $_SROKSTAGE . " | " . $_PROSRO4KA . "] <> " . $_SUMSTAGE . " | " . $_SUMCHFONDATE;
        echo "<br>";
    } elseif (in_array($kodshab, array(0))) {
        #
        if (!empty($docdateE)) {
            $_reqContragents = $db_handle->runQuery("SELECT * FROM sp_contragents WHERE kodcontragent = '{$kodzakaz}'");
            $contrname = !empty($_reqContragents[0]['nameshort']) ? $_reqContragents[0]['nameshort'] : "";
            //**
            //** Считаем выполнение по этапу
            $_reqChetf = $db_handle->runQuery("SELECT SUM(chetfsumma) as sumchfondate FROM dognet_kalplanchf WHERE kodkalplan='{$koddoc}' AND chetfdate<='{$ondate}'");
            $_SUMCHFONDATE = !empty($_reqChetf[0]['sumchfondate']) ? $_reqChetf[0]['sumchfondate'] : 0;
            ##
            //**
            //** - - - - - - - - - -
            $_DOCSTS = "Без статуса";
            $_DOCZAK = $contrname;
            $_DOCNAME = $docname;
            $_DOCNUM = $numberchet;
            $_STAGENAME = "";
            $_STAGENUM = "Счёт";
            $_SUMSTAGE = $docsum;
            $_SROKSTAGE = $docdateE;
            //** - - - - - - - - - -
            $datesrok = new DateTime($docdateE);
            $datenow = new DateTime($ondate);
            $diff = $datesrok->diff($datenow)->format('%a');
            #
            $_PROSRO4KA = $diff;
            $_SUMSHTRAF = $_SUMSTAGE * $_PROSRO4KA * $shtraf / 100;
            $__CREATEROW = ($_SUMSTAGE - $_SUMCHFONDATE) > 0 && $datesrok <= $datenow ? true : false;
            if ($__CREATEROW) {
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
            echo $kodshab . ": " . $_DOCNUM . " ( " . $ondate . " ) >>> [" . $_SROKSTAGE . " | " . $_PROSRO4KA . "] <> " . $_SUMSTAGE . " | " . $_SUMCHFONDATE;
            echo "<br>";
        }
    }
    # UPD 11.03.2024 >>>
    # Если разница  суммы этапа (договора) и суммы счетов-фактур по нему не равна нулю, то выводим строки
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
//     $activeSheet->getStyle("A{$line}:I{$line}")->applyFromArray($_BORDER_INSIDE);
$activeSheet->getStyle("A{$line}:I{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Возвращаемся на 1 строку
//     $line = $line - 1;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
// Добавляем рамку к шапке таблицы
$activeSheet->getStyle("A{$start_table}:I{$start_table}")->applyFromArray($_BORDER_OUTSIDE_THIN);
// Добавляем рамку ко всей таблице
$activeSheet->getStyle("A{$start_table}:I{$line}")->applyFromArray($_BORDER_OUTSIDE_THIN);

// $objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());
// $objPHPExcel->getActiveSheet()->setAutoFilter("A{$start_table}:I{$start_table}");