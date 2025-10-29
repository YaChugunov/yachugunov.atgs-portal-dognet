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
$activeSheet->setTitle('Незакрытые этапы');
#
// Колонтитулы
$activeSheet->getHeaderFooter()->setOddHeader('&L&G&B&12НЕЗАКРЫТЫЕ ЭТАПЫ&R&G&B&12');
$activeSheet->getHeaderFooter()->setOddFooter('&11&L&B' . $_SESSION["current_user_firstname"] . ' ' . $_SESSION["current_user_lastname"] . ' / ' . date('d.m.Y H:i:s') . '&R&11Страница &P из &N');
#
// Настройки шрифта
$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');
$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
// Задаем свой формат
define("PRICE_FORMAT_1", PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1 . "[\$ р.-419]");
// Предопределим массивы оформления границы ячеек
$_BORDER_RIGHT      = ['borders' => ['right' => ['style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => ['rgb' => '000000']]]];
$_BORDER_RIGHT_NONE = ['borders' => ['right' => ['style' => PHPExcel_Style_Border::BORDER_NONE]]];
$_BORDER_LEFT       = ['borders' => ['left' => ['style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => ['rgb' => '000000']]]];
$_BORDER_LEFT_NONE  = ['borders' => ['left' => ['style' => PHPExcel_Style_Border::BORDER_NONE]]];
// Внешняя рамка, тонкая
$_BORDER_OUTSIDE_THIN = ['borders' => ['outline' => ['style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => ['rgb' => '000000']]]];
// Внешняя рамка, толстая
$_BORDER_OUTSIDE_THICK = ['borders' => ['outline' => ['style' => PHPExcel_Style_Border::BORDER_THICK, 'color' => ['rgb' => '000000']]]];
// Внутренние разделители
$_BORDER_INSIDE       = ['borders' => ['inside' => ['style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => ['rgb' => '000000']]]];
$_BORDER_INSIDE_NONE  = ['borders' => ['inside' => ['style' => PHPExcel_Style_Border::BORDER_NONE]]];
$_BORDER_TOP          = ['borders' => ['top' => ['style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => ['rgb' => '000000']]]];
$_BORDER_BOTTOM_THIN  = ['borders' => ['bottom' => ['style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => ['rgb' => '000000']]]];
$_BORDER_BOTTOM_THICK = ['borders' => ['bottom' => ['style' => PHPExcel_Style_Border::BORDER_THICK, 'color' => ['rgb' => '000000']]]];
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
$activeSheet->getColumnDimension('A')->setWidth(15); // Номер договора
$activeSheet->getColumnDimension('B')->setWidth(20); // Тип договора
$activeSheet->getColumnDimension('C')->setWidth(8);  // Номер этапа
$activeSheet->getColumnDimension('D')->setWidth(60); // Название договора
$activeSheet->getColumnDimension('E')->setWidth(60); // Название этапа
$activeSheet->getColumnDimension('F')->setWidth(25); // Заказчик
$activeSheet->getColumnDimension('G')->setWidth(15); // Статус
$activeSheet->getColumnDimension('H')->setWidth(18); // Исполнитель
$activeSheet->getColumnDimension('I')->setWidth(12); // Срок
$activeSheet->getColumnDimension('J')->setWidth(20); // Сумма этапа
$activeSheet->getColumnDimension('K')->setWidth(20); // Сумма СФ
$activeSheet->getColumnDimension('L')->setWidth(25); // Не закрыто
$activeSheet->getColumnDimension('M')->setWidth(20); // План (в %)
$activeSheet->getColumnDimension('N')->setWidth(20); // План (в руб.)
$activeSheet->getColumnDimension('O')->setWidth(25); // Все авансы по этапу (в руб.)
$activeSheet->getColumnDimension('P')->setWidth(25); // Остаток (в руб.)
#
// Для удобства заводим переменную $line, в ней будем считать номер строки
$line = 1;
#
# ----- ----- ----- ----- -----
# СТРОКА 1
# ----- ----- ----- ----- -----
// Выводим название отчета
$activeSheet->setCellValue("A{$line}", 'НЕЗАКРЫТЫЕ ЭТАПЫ');
// Задаем высоту строки
$activeSheet->getRowDimension($line)->setRowHeight(24);
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:P{$line}");
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
$activeSheet->mergeCells("A{$line}:P{$line}");
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
$activeSheet->mergeCells("A{$line}:P{$line}");
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
$activeSheet->setCellValue("A{$line}", 'Договор');
$activeSheet->setCellValue("B{$line}", 'Тип');
$activeSheet->setCellValue("C{$line}", 'Этап');
$activeSheet->setCellValue("D{$line}", 'Название договора');
$activeSheet->setCellValue("E{$line}", 'Название этапа');
$activeSheet->setCellValue("F{$line}", 'Заказчик');
$activeSheet->setCellValue("G{$line}", 'Статус');
$activeSheet->setCellValue("H{$line}", 'Исполнитель');
$activeSheet->setCellValue("I{$line}", 'Срок');
$activeSheet->setCellValue("J{$line}", 'Сумма этапа');
$activeSheet->setCellValue("K{$line}", 'Сумма СФ');
$activeSheet->setCellValue("L{$line}", 'Не закрыто');
$activeSheet->setCellValue("M{$line}", 'План, %');
$activeSheet->setCellValue("N{$line}", 'План, руб [Б]');
$activeSheet->setCellValue("O{$line}", 'Получено, руб [А]');
$activeSheet->setCellValue("P{$line}", 'Остаток, руб. [Б]-[А]');
// Стили для текста в шапки таблицы.
$activeSheet->getRowDimension($line)->setRowHeight(18);                         // высота строки
$activeSheet->getStyle("A{$line}:P{$line}")->getFont()->setSize(11);            // размер шрифта
$activeSheet->getStyle("A{$line}:P{$line}")->getFont()->setBold(true);          // делаем шрифт жирным
$activeSheet->getStyle("A{$line}:P{$line}")->getAlignment()->setWrapText(true); // разрешаем перенос строк в ячейке

// Выравнивание по вертикали - середина
$activeSheet->getStyle("A{$line}:P{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Выравнивание по горизонтали - слева
$activeSheet->getStyle("A{$line}:F{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
// Выравнивание по горизонтали - центр
$activeSheet->getStyle("G{$line}:P{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// Делаем заливку области ячеек
$activeSheet->getStyle("A{$line}:P{$line}")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$activeSheet->getStyle("A{$line}:P{$line}")->getFill()->getStartColor()->setRGB("31708F");
// Задаем цвет текста строки
$activeSheet->getStyle("A{$line}:P{$line}")->getFont()->getColor()->setRGB('FFFFFF');
// Оформляем границы
$activeSheet->getStyle("A{$line}:P{$line}")->applyFromArray($_BORDER_INSIDE);
$activeSheet->getStyle("A{$line}:P{$line}")->applyFromArray($_BORDER_OUTSIDE_THICK);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
// Делаем выборку этапов по идентификатору этапа (kodkalplan)
// kodstatus:
// 245381842747296 - Текущий
// 245381842145343 - Проект
// 245267756667430 - Подписание
// 245597345680479 - Есть скан
$_QRY_dockalplan = mysqlQuery("SELECT
	dognet_dockalplan.koddoc, dognet_dockalplan.nameshotstage, dognet_dockalplan.numberstage, 
    dognet_dockalplan.numberstage, dognet_dockalplan.srokstage, dognet_dockalplan.idobjectready, dognet_dockalplan.pravplan1stage, 
    dognet_dockalplan_progress.srokstage_date, dognet_dockalplan_progress.summastage, dognet_dockalplan_progress.sumchfstage, 
    dognet_dockalplan_progress.zadolsum_stage, dognet_dockalplan_progress.firstdateavans, 
    dognet_dockalplan_progress.sumavstage as sumavstage, dognet_dockalplan_progress.sumoplavstage as sumoplavstage, 
    dognet_dockalplan_progress.dateplan, dognet_dockalplan_progress.idsrokstage
	FROM dognet_dockalplan INNER JOIN dognet_dockalplan_progress ON dognet_dockalplan.kodkalplan = dognet_dockalplan_progress.kodkalplan
	WHERE dognet_dockalplan.koddel<>'99' AND dognet_dockalplan.kodkalplan IN (SELECT kodkalplan FROM dognet_dockalplan_progress WHERE (summastage > sumchfstage) OR (summastage > 0 AND sumchfstage IS NULL))
    AND dognet_dockalplan.koddoc IN (SELECT koddoc FROM dognet_docbase WHERE kodstatus='245381842747296' OR kodstatus='245381842145343' OR kodstatus='245267756667430' OR kodstatus='245597345680479')
    AND dognet_dockalplan.kodkalplan NOT IN (SELECT kodkalplan FROM dognet_kalplanchf WHERE chetfsumma>0 AND kodkalplan=dognet_dockalplan.kodkalplan)");
$_SUM_TOTAL       = 0.0;
$_SUM_TOTAL_CHF   = 0.0;
$_SUM_TOTAL_ZADOL = 0.0;
//
while ($_ROW_dockalplan = mysqli_fetch_assoc($_QRY_dockalplan)) {
    $DOCBASE   = $db_handle->runQuery("SELECT * FROM dognet_docbase WHERE koddoc = '" . $_ROW_dockalplan['koddoc'] . "'");
    $DOCTIP    = $db_handle->runQuery("SELECT nametip FROM dognet_sptipdog WHERE kodtip = '" . $DOCBASE[0]['kodtip'] . "'");
    $DOCSTATUS = $db_handle->runQuery("SELECT statusnameshot FROM dognet_spstatus WHERE kodstatus = '" . $DOCBASE[0]['kodstatus'] . "'");
    $DOCOBJ    = $db_handle->runQuery("SELECT nameobjectshot FROM sp_objects WHERE kodobject = '" . $DOCBASE[0]['kodobject'] . "'");
    $DOCZAK    = $db_handle->runQuery("SELECT nameshort FROM sp_contragents WHERE kodcontragent = '" . $DOCBASE[0]['kodzakaz'] . "'");
    $DOCISP    = $db_handle->runQuery("SELECT ispolnameshot FROM dognet_spispol WHERE kodispol = '" . $DOCBASE[0]['kodispol'] . "'");
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    $_DOCTIP    = $DOCTIP[0]['nametip'];
    $_DOCSTATUS = $DOCSTATUS[0]['statusnameshot'];
    $_DOCOBJ    = $DOCOBJ[0]['nameobjectshot'];
    $_DOCZAK    = $DOCZAK[0]['nameshort'];
    $_DOCISP    = $DOCISP[0]['ispolnameshot'];
    $_DOCNAME   = $DOCBASE[0]['docnameshot'];
    $_DOCNUM    = $DOCBASE[0]['docnumber'];
    $_STAGENAME = $_ROW_dockalplan['nameshotstage'];
    $_STAGENUM  = $_ROW_dockalplan['numberstage'];
    //
    $firstdateavans = $_ROW_dockalplan['firstdateavans'];
    $srokstage      = $_ROW_dockalplan['srokstage'];
    $dateplan       = $_ROW_dockalplan['dateplan'];
    $idsrokstage    = $_ROW_dockalplan['idsrokstage'];
    $srokstage_date = $_ROW_dockalplan['srokstage_date'];
    $objectready    = $_ROW_dockalplan['idobjectready'];
    if ($srokstage != "" && $srokstage != null) {
        if ($idsrokstage == 0) {
            if ($firstdateavans != "" && $firstdateavans != null) {
                $date1 = date('Y-m-d', strtotime($firstdateavans));
                $date1 = new DateTime();
                $date1->add(new DateInterval('P' . $srokstage . 'D'));
                // $out = $date1->format('d.m.Y');
                $out = date('d.m.Y', strtotime($srokstage_date));
            } else {
                $out = "--- (" . $srokstage . ")";
            }
        } else {
            $out = date('d/m/Y', strtotime($srokstage));
            $out = $srokstage;
        }
    } else {
        $out = "!? (" . date('d.m.Y', strtotime($dateplan)) . ")";
    }
    $_STAGESROK = $out;
    //
    $_STAGESUM    = !empty($_ROW_dockalplan['summastage']) ? $_ROW_dockalplan['summastage'] : 0.0;
    $_STAGECHFSUM = $_ROW_dockalplan['sumchfstage'];
    $_STAGEZADOL  = $_ROW_dockalplan['zadolsum_stage'];
    //** ----- ----- ----- ----- -----
    //**
    //!! UPD 04.09.2025
    //** @_STAGEAV - полученный аванс (сумма всез авансов по этапу)
    //** @_PLANPERC - планируемый аванс в процентах (1-ый аванс из Планирования)
    //** @_PLANAV - планируемый аванс в рублях (@_PLANPERC * @_STAGESUM)
    //** @_STAGEAV - остаток, планируемый - оплаченный (@_PLANAV - @_STAGEAV)
    //** @_OSTAV - остаток, планируемый - оплаченный (@_PLANAV - @_STAGEAV)
    //**
    $_STAGEAV  = !empty($_ROW_dockalplan['sumavstage']) ? $_ROW_dockalplan['sumavstage'] : 0.0;
    $_PLANPERC  = !empty($_ROW_dockalplan['pravplan1stage']) ? $_ROW_dockalplan['pravplan1stage'] : 0.0;
    $_PLANAV  = ($_PLANPERC/100) * $_STAGESUM;
    $_OSTAV = $_PLANAV - $_STAGEAV;
    //** ----- ----- ----- ----- -----


    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    // Задаем высоту строки и шрифт
    $activeSheet->getRowDimension($line)->setRowHeight(18);
    $activeSheet->getStyle("A{$line}:P{$line}")->getFont()->setSize(10);
    $activeSheet->getStyle("A{$line}:P{$line}")->getFont()->setBold(false);
    // Задаем цвет текста строки
    $activeSheet->getStyle("A{$line}:P{$line}")->getFont()->getColor()->setRGB('111111');

//* Проверяем параметр этапа "По готовности объекта"
//* * 1 - да, 0 - нет
//*
    if ($objectready === '1') {
        // Делаем заливку области ячеек
        $activeSheet->getStyle("A{$line}:P{$line}")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $activeSheet->getStyle("A{$line}:P{$line}")->getFill()->getStartColor()->setRGB("FFF2CC");
    }
//* - - - - - - - - - -
    // Выравниваем строку по вертикали ( середина )
    $activeSheet->getStyle("A{$line}:P{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    // Выравнивание по горизонтали - слева
    $activeSheet->getStyle("A{$line}:F{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    // Выравнивание по горизонтали - центр
    $activeSheet->getStyle("G{$line}:P{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $activeSheet->setCellValue("A{$line}", '3-4/' . $_DOCNUM);
    $activeSheet->setCellValue("B{$line}", $_DOCTIP);
    $activeSheet->setCellValue("C{$line}", $_STAGENUM);
    $activeSheet->setCellValue("D{$line}", $_DOCNAME);
    $activeSheet->setCellValue("E{$line}", $_STAGENAME);
    $activeSheet->setCellValue("F{$line}", $_DOCZAK);
    $activeSheet->setCellValue("G{$line}", $_DOCSTATUS);
    $activeSheet->setCellValue("H{$line}", $_DOCISP);
    $activeSheet->setCellValue("I{$line}", $_STAGESROK);
    $activeSheet->setCellValue("J{$line}", $_STAGESUM);
    $activeSheet->getStyle("J{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
    $activeSheet->setCellValue("K{$line}", $_STAGECHFSUM);
    $activeSheet->getStyle("K{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
    $activeSheet->setCellValue("L{$line}", $_STAGEZADOL);
    $activeSheet->getStyle("L{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
    // ----- ----- ----- ----- -----
    //
    // UPD 04.09.2025
    $activeSheet->setCellValue("M{$line}", $_PLANPERC);
    $activeSheet->setCellValue("N{$line}", $_PLANAV);
    $activeSheet->getStyle("N{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
    $activeSheet->setCellValue("O{$line}", $_STAGEAV);
    $activeSheet->getStyle("O{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
    $activeSheet->setCellValue("P{$line}", $_OSTAV);
    $activeSheet->getStyle("P{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
    // ----- ----- ----- ----- -----
    // Оформляем границы
    $activeSheet->getStyle("A{$line}:P{$line}")->applyFromArray($_BORDER_INSIDE);
    $activeSheet->getStyle("A{$line}:P{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
    // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    // Следующая строка
    $line++;
    // Суммируем по этапам
    $_SUM_TOTAL += $_STAGESUM;
    $_SUM_TOTAL_CHF += $_STAGECHFSUM;
    $_SUM_TOTAL_ZADOL += $_STAGEZADOL;
}
// Задаем высоту строки и шрифт
$activeSheet->getRowDimension($line)->setRowHeight(22);
$activeSheet->getStyle("A{$line}:P{$line}")->getFont()->setSize(12);
$activeSheet->getStyle("A{$line}:P{$line}")->getFont()->setBold(true);
// Задаем цвет текста строки
$activeSheet->getStyle("A{$line}:P{$line}")->getFont()->getColor()->setRGB('111111');
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:J{$line}");
// Выравниваем строку по вертикали ( середина )
$activeSheet->getStyle("A{$line}:P{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Выравнивание по горизонтали - справа
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
// Выравнивание по горизонтали - центр
$activeSheet->getStyle("J{$line}:P{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$activeSheet->setCellValue("A{$line}", "ИТОГО: ");
$activeSheet->setCellValue("J{$line}", $_SUM_TOTAL);
$activeSheet->getStyle("J{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
$activeSheet->setCellValue("K{$line}", $_SUM_TOTAL_CHF);
$activeSheet->getStyle("K{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
$activeSheet->setCellValue("L{$line}", $_SUM_TOTAL_ZADOL);
$activeSheet->getStyle("L{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
// Оформляем границы
$activeSheet->getStyle("A{$line}:P{$line}")->applyFromArray($_BORDER_INSIDE);
$activeSheet->getStyle("A{$line}:P{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
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
$activeSheet->getStyle("A{$start_table}:P{$line}")->applyFromArray($_BORDER_OUTSIDE_THIN);

// $objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());
$objPHPExcel->getActiveSheet()->setAutoFilter("A{$start_table}:I{$start_table}");