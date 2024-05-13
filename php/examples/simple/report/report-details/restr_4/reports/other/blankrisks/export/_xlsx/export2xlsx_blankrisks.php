<?php
#
#
$_YEAR = $_GET['ondate'];
#
#
$_QRY_BLANKPOS_RISK1_1 = mysqlQuery("SELECT koduserisk1 FROM dognet_blankdocpost tb1 WHERE koduserisk1='1' AND tb1.kodtipblank='DO' AND kodblankwork IN (SELECT kodblankwork FROM dognet_docblankwork tb2 WHERE tb2.kodstatusblank='DO' AND tb2.kodtipblank='POS' AND YEAR(tb2.dateblankorder)='$_YEAR' ORDER BY id DESC)");
$_POS_RISK1_1 = mysqli_num_rows($_QRY_BLANKPOS_RISK1_1);
//
$_QRY_BLANKPOS_RISK1_0 = mysqlQuery("SELECT koduserisk1 FROM dognet_blankdocpost tb1 WHERE koduserisk1='0' AND tb1.kodtipblank='DO' AND kodblankwork IN (SELECT kodblankwork FROM dognet_docblankwork tb2 WHERE tb2.kodstatusblank='DO' AND tb2.kodtipblank='POS' AND YEAR(tb2.dateblankorder)='$_YEAR' ORDER BY id DESC)");
$_POS_RISK1_0 = mysqli_num_rows($_QRY_BLANKPOS_RISK1_0);
//
$_QRY_BLANKPOS_RISK2_1 = mysqlQuery("SELECT koduserisk2 FROM dognet_blankdocpost tb1 WHERE koduserisk2='1' AND tb1.kodtipblank='DO' AND kodblankwork IN (SELECT kodblankwork FROM dognet_docblankwork tb2 WHERE tb2.kodstatusblank='DO' AND tb2.kodtipblank='POS' AND YEAR(tb2.dateblankorder)='$_YEAR' ORDER BY id DESC)");
$_POS_RISK2_1 = mysqli_num_rows($_QRY_BLANKPOS_RISK2_1);
//
$_QRY_BLANKPOS_RISK2_0 = mysqlQuery("SELECT koduserisk2 FROM dognet_blankdocpost tb1 WHERE koduserisk2='0' AND tb1.kodtipblank='DO' AND kodblankwork IN (SELECT kodblankwork FROM dognet_docblankwork tb2 WHERE tb2.kodstatusblank='DO' AND tb2.kodtipblank='POS' AND YEAR(tb2.dateblankorder)='$_YEAR' ORDER BY id DESC)");
$_POS_RISK2_0 = mysqli_num_rows($_QRY_BLANKPOS_RISK2_0);
//
$_QRY_BLANKPOS_RISK3_1 = mysqlQuery("SELECT koduserisk3 FROM dognet_blankdocpost tb1 WHERE koduserisk3='1' AND tb1.kodtipblank='DO' AND kodblankwork IN (SELECT kodblankwork FROM dognet_docblankwork tb2 WHERE tb2.kodstatusblank='DO' AND tb2.kodtipblank='POS' AND YEAR(tb2.dateblankorder)='$_YEAR' ORDER BY id DESC)");
$_POS_RISK3_1 = mysqli_num_rows($_QRY_BLANKPOS_RISK3_1);
//
$_QRY_BLANKPOS_RISK3_0 = mysqlQuery("SELECT koduserisk3 FROM dognet_blankdocpost tb1 WHERE koduserisk3='0' AND tb1.kodtipblank='DO' AND kodblankwork IN (SELECT kodblankwork FROM dognet_docblankwork tb2 WHERE tb2.kodstatusblank='DO' AND tb2.kodtipblank='POS' AND YEAR(tb2.dateblankorder)='$_YEAR' ORDER BY id DESC)");
$_POS_RISK3_0 = mysqli_num_rows($_QRY_BLANKPOS_RISK3_0);
//
//
// ===== ===== ===== ===== ===== 
//
//
$_QRY_BLANKPIR_RISK1_1 = mysqlQuery("SELECT koduserisk1 FROM dognet_blankdocpir tb1 WHERE koduserisk1='1' AND tb1.kodtipblank='DO' AND kodblankwork IN (SELECT kodblankwork FROM dognet_docblankwork tb2 WHERE tb2.kodstatusblank='DO' AND tb2.kodtipblank='PIR' AND YEAR(tb2.dateblankorder)='$_YEAR' ORDER BY id DESC)");
$_PIR_RISK1_1 = mysqli_num_rows($_QRY_BLANKPIR_RISK1_1);
//
$_QRY_BLANKPIR_RISK1_0 = mysqlQuery("SELECT koduserisk1 FROM dognet_blankdocpir tb1 WHERE koduserisk1='0' AND tb1.kodtipblank='DO' AND kodblankwork IN (SELECT kodblankwork FROM dognet_docblankwork tb2 WHERE tb2.kodstatusblank='DO' AND tb2.kodtipblank='PIR' AND YEAR(tb2.dateblankorder)='$_YEAR' ORDER BY id DESC)");
$_PIR_RISK1_0 = mysqli_num_rows($_QRY_BLANKPIR_RISK1_0);
//
$_QRY_BLANKPIR_RISK2_1 = mysqlQuery("SELECT koduserisk2 FROM dognet_blankdocpir tb1 WHERE koduserisk2='1' AND tb1.kodtipblank='DO' AND kodblankwork IN (SELECT kodblankwork FROM dognet_docblankwork tb2 WHERE tb2.kodstatusblank='DO' AND tb2.kodtipblank='PIR' AND YEAR(tb2.dateblankorder)='$_YEAR' ORDER BY id DESC)");
$_PIR_RISK2_1 = mysqli_num_rows($_QRY_BLANKPIR_RISK2_1);
//
$_QRY_BLANKPIR_RISK2_0 = mysqlQuery("SELECT koduserisk2 FROM dognet_blankdocpir tb1 WHERE koduserisk2='0' AND tb1.kodtipblank='DO' AND kodblankwork IN (SELECT kodblankwork FROM dognet_docblankwork tb2 WHERE tb2.kodstatusblank='DO' AND tb2.kodtipblank='PIR' AND YEAR(tb2.dateblankorder)='$_YEAR' ORDER BY id DESC)");
$_PIR_RISK2_0 = mysqli_num_rows($_QRY_BLANKPIR_RISK2_0);
//
$_QRY_BLANKPIR_RISK3_1 = mysqlQuery("SELECT koduserisk3 FROM dognet_blankdocpir tb1 WHERE koduserisk3='1' AND tb1.kodtipblank='DO' AND kodblankwork IN (SELECT kodblankwork FROM dognet_docblankwork tb2 WHERE tb2.kodstatusblank='DO' AND tb2.kodtipblank='PIR' AND YEAR(tb2.dateblankorder)='$_YEAR' ORDER BY id DESC)");
$_PIR_RISK3_1 = mysqli_num_rows($_QRY_BLANKPIR_RISK3_1);
//
$_QRY_BLANKPIR_RISK3_0 = mysqlQuery("SELECT koduserisk3 FROM dognet_blankdocpir tb1 WHERE koduserisk3='0' AND tb1.kodtipblank='DO' AND kodblankwork IN (SELECT kodblankwork FROM dognet_docblankwork tb2 WHERE tb2.kodstatusblank='DO' AND tb2.kodtipblank='PIR' AND YEAR(tb2.dateblankorder)='$_YEAR' ORDER BY id DESC)");
$_PIR_RISK3_0 = mysqli_num_rows($_QRY_BLANKPIR_RISK3_0);
//
$_QRY_BLANKPIR_RISK4_1 = mysqlQuery("SELECT koduserisk4 FROM dognet_blankdocpir tb1 WHERE koduserisk4='1' AND tb1.kodtipblank='DO' AND kodblankwork IN (SELECT kodblankwork FROM dognet_docblankwork tb2 WHERE tb2.kodstatusblank='DO' AND tb2.kodtipblank='PIR' AND YEAR(tb2.dateblankorder)='$_YEAR' ORDER BY id DESC)");
$_PIR_RISK4_1 = mysqli_num_rows($_QRY_BLANKPIR_RISK4_1);
//
$_QRY_BLANKPIR_RISK4_0 = mysqlQuery("SELECT koduserisk4 FROM dognet_blankdocpir tb1 WHERE koduserisk4='0' AND tb1.kodtipblank='DO' AND kodblankwork IN (SELECT kodblankwork FROM dognet_docblankwork tb2 WHERE tb2.kodstatusblank='DO' AND tb2.kodtipblank='PIR' AND YEAR(tb2.dateblankorder)='$_YEAR' ORDER BY id DESC)");
$_PIR_RISK4_0 = mysqli_num_rows($_QRY_BLANKPIR_RISK4_0);
//
$_QRY_BLANKPIR_RISK5_1 = mysqlQuery("SELECT koduserisk5 FROM dognet_blankdocpir tb1 WHERE koduserisk5='1' AND tb1.kodtipblank='DO' AND kodblankwork IN (SELECT kodblankwork FROM dognet_docblankwork tb2 WHERE tb2.kodstatusblank='DO' AND tb2.kodtipblank='PIR' AND YEAR(tb2.dateblankorder)='$_YEAR' ORDER BY id DESC)");
$_PIR_RISK5_1 = mysqli_num_rows($_QRY_BLANKPIR_RISK5_1);
//
$_QRY_BLANKPIR_RISK5_0 = mysqlQuery("SELECT koduserisk5 FROM dognet_blankdocpir tb1 WHERE koduserisk5='0' AND tb1.kodtipblank='DO' AND kodblankwork IN (SELECT kodblankwork FROM dognet_docblankwork tb2 WHERE tb2.kodstatusblank='DO' AND tb2.kodtipblank='PIR' AND YEAR(tb2.dateblankorder)='$_YEAR' ORDER BY id DESC)");
$_PIR_RISK5_0 = mysqli_num_rows($_QRY_BLANKPIR_RISK5_0);
//
//
// ===== ===== ===== ===== ===== 
//
//
$_QRY_BLANKPNR_RISK1_1 = mysqlQuery("SELECT koduserisk1 FROM dognet_blankdocpnr tb1 WHERE koduserisk1='1' AND tb1.kodtipblank='DO' AND kodblankwork IN (SELECT kodblankwork FROM dognet_docblankwork tb2 WHERE tb2.kodstatusblank='DO' AND tb2.kodtipblank='PNR' AND YEAR(tb2.dateblankorder)='$_YEAR' ORDER BY id DESC)");
$_PNR_RISK1_1 = mysqli_num_rows($_QRY_BLANKPNR_RISK1_1);
//
$_QRY_BLANKPNR_RISK1_0 = mysqlQuery("SELECT koduserisk1 FROM dognet_blankdocpnr tb1 WHERE koduserisk1='0' AND tb1.kodtipblank='DO' AND kodblankwork IN (SELECT kodblankwork FROM dognet_docblankwork tb2 WHERE tb2.kodstatusblank='DO' AND tb2.kodtipblank='PNR' AND YEAR(tb2.dateblankorder)='$_YEAR' ORDER BY id DESC)");
$_PNR_RISK1_0 = mysqli_num_rows($_QRY_BLANKPNR_RISK1_0);
//
$_QRY_BLANKPNR_RISK2_1 = mysqlQuery("SELECT koduserisk2 FROM dognet_blankdocpnr tb1 WHERE koduserisk2='1' AND tb1.kodtipblank='DO' AND kodblankwork IN (SELECT kodblankwork FROM dognet_docblankwork tb2 WHERE tb2.kodstatusblank='DO' AND tb2.kodtipblank='PNR' AND YEAR(tb2.dateblankorder)='$_YEAR' ORDER BY id DESC)");
$_PNR_RISK2_1 = mysqli_num_rows($_QRY_BLANKPNR_RISK2_1);
//
$_QRY_BLANKPNR_RISK2_0 = mysqlQuery("SELECT koduserisk2 FROM dognet_blankdocpnr tb1 WHERE koduserisk2='0' AND tb1.kodtipblank='DO' AND kodblankwork IN (SELECT kodblankwork FROM dognet_docblankwork tb2 WHERE tb2.kodstatusblank='DO' AND tb2.kodtipblank='PNR' AND YEAR(tb2.dateblankorder)='$_YEAR' ORDER BY id DESC)");
$_PNR_RISK2_0 = mysqli_num_rows($_QRY_BLANKPNR_RISK2_0);
//
$_QRY_BLANKPNR_RISK3_1 = mysqlQuery("SELECT koduserisk3 FROM dognet_blankdocpnr tb1 WHERE koduserisk3='1' AND tb1.kodtipblank='DO' AND kodblankwork IN (SELECT kodblankwork FROM dognet_docblankwork tb2 WHERE tb2.kodstatusblank='DO' AND tb2.kodtipblank='PNR' AND YEAR(tb2.dateblankorder)='$_YEAR' ORDER BY id DESC)");
$_PNR_RISK3_1 = mysqli_num_rows($_QRY_BLANKPNR_RISK3_1);
//
$_QRY_BLANKPNR_RISK3_0 = mysqlQuery("SELECT koduserisk3 FROM dognet_blankdocpnr tb1 WHERE koduserisk3='0' AND tb1.kodtipblank='DO' AND kodblankwork IN (SELECT kodblankwork FROM dognet_docblankwork tb2 WHERE tb2.kodstatusblank='DO' AND tb2.kodtipblank='PNR' AND YEAR(tb2.dateblankorder)='$_YEAR' ORDER BY id DESC)");
$_PNR_RISK3_0 = mysqli_num_rows($_QRY_BLANKPNR_RISK3_0);
//
$_QRY_BLANKPNR_RISK4_1 = mysqlQuery("SELECT koduserisk4 FROM dognet_blankdocpnr tb1 WHERE koduserisk4='1' AND tb1.kodtipblank='DO' AND kodblankwork IN (SELECT kodblankwork FROM dognet_docblankwork tb2 WHERE tb2.kodstatusblank='DO' AND tb2.kodtipblank='PNR' AND YEAR(tb2.dateblankorder)='$_YEAR' ORDER BY id DESC)");
$_PNR_RISK4_1 = mysqli_num_rows($_QRY_BLANKPNR_RISK4_1);
//
$_QRY_BLANKPNR_RISK4_0 = mysqlQuery("SELECT koduserisk4 FROM dognet_blankdocpnr tb1 WHERE koduserisk4='0' AND tb1.kodtipblank='DO' AND kodblankwork IN (SELECT kodblankwork FROM dognet_docblankwork tb2 WHERE tb2.kodstatusblank='DO' AND tb2.kodtipblank='PNR' AND YEAR(tb2.dateblankorder)='$_YEAR' ORDER BY id DESC)");
$_PNR_RISK4_0 = mysqli_num_rows($_QRY_BLANKPNR_RISK4_0);
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
$activeSheet->setTitle('Риски по заявкам ГИПов');
#
// Колонтитулы
$activeSheet->getHeaderFooter()->setOddHeader('&L&G&B&12РИСКИ НА ОСНОВЕ ЗАЯВОК ГИПОВ НА ДОГОВОРА&R&G&B&12ЗА ВЫБРАННЫЙ ГОД');
$activeSheet->getHeaderFooter()->setOddFooter('&11&L&B' . $_SESSION["firstname"] . ' ' . $_SESSION["lastname"] . ' / ' . date('d.m.Y H:i:s') . '&R&11Страница &P из &N');
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
$_BORDER_BOTTOM = array('borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))));
$_BORDER_BOTTOM_NONE = array('borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_NONE)));
$_BORDER_TOP = array('borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))));
$_BORDER_TOP_NONE = array('borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_NONE)));
// Внешняя рамка, тонкая
$_BORDER_OUTSIDE_THIN = array('borders' => array('outline' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))));
// Внешняя рамка, толстая
$_BORDER_OUTSIDE_THICK = array('borders' => array('outline' => array('style' => PHPExcel_Style_Border::BORDER_THICK, 'color' => array('rgb' => '000000'))));
$_BORDER_OUTSIDE_NONE = array('borders' => array('outline' => array('style' => PHPExcel_Style_Border::BORDER_NONE)));
// Внутренние разделители
$_BORDER_INSIDE = array('borders' => array('inside' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))));
$_BORDER_INSIDE_NONE = array('borders' => array('inside' => array('style' => PHPExcel_Style_Border::BORDER_NONE)));
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
$activeSheet->getColumnDimension('A')->setWidth(75); // Вид риска
$activeSheet->getColumnDimension('B')->setWidth(15); // Поставка : риск есть
$activeSheet->getColumnDimension('C')->setWidth(15); // Поставка : риска нет
$activeSheet->getColumnDimension('D')->setWidth(15); // ПИР : риск есть
$activeSheet->getColumnDimension('E')->setWidth(15); // ПИР : риска нет
$activeSheet->getColumnDimension('F')->setWidth(15); // Остальные работы : риск есть
$activeSheet->getColumnDimension('G')->setWidth(15); // Остальные работы : риска нет
#
// Для удобства заводим переменную $line, в ней будем считать номер строки
$line = 1;
#
# ----- ----- ----- ----- -----
# СТРОКА 1
# ----- ----- ----- ----- -----
// Выводим название отчета
$activeSheet->setCellValue("A{$line}", 'РИСКИ НА ОСНОВЕ ЗАЯВОК ГИПОВ НА ДОГОВОРА ЗА ' . $_YEAR . " ГОД");
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
// Задаем высоту строки
$activeSheet->getRowDimension($line)->setRowHeight(20);
// Делаем выравнивание по центру вертикали и горизонтали
$activeSheet->getStyle("A{$line}:G{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("A{$line}:G{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Делаем текст жирным и увеличиваем шрифт.
$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setBold(true);
$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setSize(13);
// Выводим название отчета
$activeSheet->setCellValue("A{$line}", 'Дата отчета: ' . date("d.m.Y H:i:s"));
#
# ----- ----- ----- ----- -----
# СТРОКА 3
# ----- ----- ----- ----- -----
$line++;
// Задаем высоту строки
$activeSheet->getRowDimension($line)->setRowHeight(20);
// Делаем выравнивание по центру вертикали и горизонтали
$activeSheet->getStyle("A{$line}:G{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("A{$line}:G{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Делаем текст жирным и увеличиваем шрифт.
$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setBold(true);
$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setSize(13);
// Выводим название отчета
$activeSheet->setCellValue("A{$line}", "Отчет составлен: " . $_SESSION['lastname'] . " " . $_SESSION['firstname'] . " " . $_SESSION['middlename']);
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
$activeSheet->getStyle("A{$line}:G{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("A{$line}:G{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Делаем текст жирным и увеличиваем шрифт.
$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setBold(true);
$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setSize(13);
// Выводим название отчета
$activeSheet->setCellValue("A{$line}", "");
### 
### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
### 
### 
### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
### 
$line++;
$start_table = $line;
// Шапка таблицы
$activeSheet->setCellValue("A{$line}", 'Вид риска');
$activeSheet->setCellValue("B{$line}", 'Тип работ по договору (текущему или закрытому)');
//
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("B{$line}:G{$line}");
$activeSheet->mergeCells("A{$line}:A" . ($line + 2));
// Стили для текста в шапки таблицы.
$activeSheet->getRowDimension($line)->setRowHeight(24); // высота строки
$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setSize(12); // размер шрифта
$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setBold(true); // делаем шрифт жирным
$activeSheet->getStyle("A{$line}:G{$line}")->getAlignment()->setWrapText(true); // разрешаем перенос строк в ячейке
// Выравнивание по вертикали
$activeSheet->getStyle("A{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$activeSheet->getStyle("B{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Выравнивание по горизонтали
$activeSheet->getStyle("B{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// Делаем заливку области ячеек
$activeSheet->getStyle("A{$line}")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$activeSheet->getStyle("A{$line}")->getFill()->getStartColor()->setRGB("31708F");
$activeSheet->getStyle("B{$line}")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$activeSheet->getStyle("B{$line}")->getFill()->getStartColor()->setRGB("31708F");
// Задаем цвет текста строки
$activeSheet->getStyle("A{$line}")->getFont()->getColor()->setRGB('FFFFFF');
$activeSheet->getStyle("B{$line}")->getFont()->getColor()->setRGB('FFFFFF');
// Оформляем границы
$activeSheet->getStyle("A{$line}")->applyFromArray($_BORDER_INSIDE_NONE);
$activeSheet->getStyle("A{$line}")->applyFromArray($_BORDER_OUTSIDE_NONE);
$activeSheet->getStyle("B{$line}:G{$line}")->applyFromArray($_BORDER_INSIDE);
$activeSheet->getStyle("B{$line}:G{$line}")->applyFromArray($_BORDER_OUTSIDE_THIN);
### 
### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
### 
### 
### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
### 
$line++;
### 
// Шапка таблицы
$activeSheet->setCellValue("B{$line}", 'Поставка');
$activeSheet->setCellValue("D{$line}", 'ПИР');
$activeSheet->setCellValue("F{$line}", 'Остальные работы');
//
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("B{$line}:C{$line}");
$activeSheet->mergeCells("D{$line}:E{$line}");
$activeSheet->mergeCells("F{$line}:G{$line}");
// Стили для текста в шапки таблицы.
$activeSheet->getRowDimension($line)->setRowHeight(24); // высота строки
$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setSize(12); // размер шрифта
$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setBold(true); // делаем шрифт жирным
$activeSheet->getStyle("A{$line}:G{$line}")->getAlignment()->setWrapText(true); // разрешаем перенос строк в ячейке
// Выравнивание по вертикали
$activeSheet->getStyle("B{$line}:G{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Выравнивание по горизонтали
$activeSheet->getStyle("B{$line}:G{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// Делаем заливку области ячеек
$activeSheet->getStyle("B{$line}:G{$line}")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$activeSheet->getStyle("B{$line}:G{$line}")->getFill()->getStartColor()->setRGB("31708F");
// Задаем цвет текста строки
$activeSheet->getStyle("A{$line}")->getFont()->getColor()->setRGB('111111');
$activeSheet->getStyle("B{$line}:G{$line}")->getFont()->getColor()->setRGB('FFFFFF');
// Оформляем границы
$activeSheet->getStyle("A{$line}")->applyFromArray($_BORDER_INSIDE_NONE);
$activeSheet->getStyle("A{$line}")->applyFromArray($_BORDER_OUTSIDE_NONE);
$activeSheet->getStyle("B{$line}:G{$line}")->applyFromArray($_BORDER_INSIDE);
$activeSheet->getStyle("B{$line}:G{$line}")->applyFromArray($_BORDER_OUTSIDE_THIN);
### 
### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
### 
### 
### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
### 
$line++;
###

# Шапка таблицы
$activeSheet->setCellValue("B{$line}", 'Риск есть');
$activeSheet->setCellValue("C{$line}", 'Риска нет');
$activeSheet->setCellValue("D{$line}", 'Риск есть');
$activeSheet->setCellValue("E{$line}", 'Риска нет');
$activeSheet->setCellValue("F{$line}", 'Риск есть');
$activeSheet->setCellValue("G{$line}", 'Риска нет');
#
// Стили для текста в шапки таблицы.
$activeSheet->getRowDimension($line)->setRowHeight(24); // высота строки
$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setSize(12); // размер шрифта
$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setBold(true); // делаем шрифт жирным
$activeSheet->getStyle("A{$line}:G{$line}")->getAlignment()->setWrapText(true); // разрешаем перенос строк в ячейке
// Выравнивание по вертикали
$activeSheet->getStyle("A{$line}:G{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Выравнивание по горизонтали
$activeSheet->getStyle("A{$line}:G{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// Делаем заливку области ячеек
$activeSheet->getStyle("A{$line}:G{$line}")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$activeSheet->getStyle("A{$line}:G{$line}")->getFill()->getStartColor()->setRGB("31708F");
// Задаем цвет текста строки
$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->getColor()->setRGB('FFFFFF');
// Оформляем границы
$activeSheet->getStyle("A{$line}:G{$line}")->applyFromArray($_BORDER_INSIDE);
$activeSheet->getStyle("A{$line}:G{$line}")->applyFromArray($_BORDER_OUTSIDE_THIN);
### 
### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
### 
### 
### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
### 
$line++;
###
$tblBodyStart = $line;
# Шапка таблицы
$activeSheet->setCellValue("A{$line}", 'Соблюдение сроков выполнения монтажных работ на объекте');
$activeSheet->setCellValue("B{$line}", '-');
$activeSheet->setCellValue("C{$line}", '-');
$activeSheet->setCellValue("D{$line}", '-');
$activeSheet->setCellValue("E{$line}", '-');
$activeSheet->setCellValue("F{$line}", $_PNR_RISK1_1);
$activeSheet->setCellValue("G{$line}", $_PNR_RISK1_0);
#
// Стили для текста в шапки таблицы.
$activeSheet->getRowDimension($line)->setRowHeight(24); // высота строки
$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setSize(12); // размер шрифта
$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setBold(true); // делаем шрифт жирным
$activeSheet->getStyle("A{$line}:G{$line}")->getAlignment()->setWrapText(true); // разрешаем перенос строк в ячейке
// Выравнивание по вертикали
$activeSheet->getStyle("A{$line}:G{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Выравнивание по горизонтали
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("B{$line}:G{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// Задаем цвет текста строки
$activeSheet->getStyle("A{$line}")->getFont()->getColor()->setRGB('111111');
// Оформляем границы
$activeSheet->getStyle("A{$line}")->applyFromArray($_BORDER_INSIDE);
### 
### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
### 
### 
### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
### 
$line++;
###

# Шапка таблицы
$activeSheet->setCellValue("A{$line}", 'Соблюдение сроков выполнения пуско-наладочных работ');
$activeSheet->setCellValue("B{$line}", '-');
$activeSheet->setCellValue("C{$line}", '-');
$activeSheet->setCellValue("D{$line}", '-');
$activeSheet->setCellValue("E{$line}", '-');
$activeSheet->setCellValue("F{$line}", $_PNR_RISK2_1);
$activeSheet->setCellValue("G{$line}", $_PNR_RISK2_0);
#
// Стили для текста в шапки таблицы.
$activeSheet->getRowDimension($line)->setRowHeight(24); // высота строки
$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setSize(12); // размер шрифта
$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setBold(true); // делаем шрифт жирным
$activeSheet->getStyle("A{$line}:G{$line}")->getAlignment()->setWrapText(true); // разрешаем перенос строк в ячейке
// Выравнивание по вертикали
$activeSheet->getStyle("A{$line}:G{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Выравнивание по горизонтали
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("B{$line}:G{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// Задаем цвет текста строки
$activeSheet->getStyle("A{$line}")->getFont()->getColor()->setRGB('111111');
// Оформляем границы
$activeSheet->getStyle("A{$line}")->applyFromArray($_BORDER_INSIDE);
### 
### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
### 
### 
### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
### 
$line++;
###

# Шапка таблицы
$activeSheet->setCellValue("A{$line}", 'Соблюдение сроков оплаты');
$activeSheet->setCellValue("B{$line}", $_POS_RISK2_1);
$activeSheet->setCellValue("C{$line}", $_POS_RISK2_0);
$activeSheet->setCellValue("D{$line}", $_PIR_RISK5_1);
$activeSheet->setCellValue("E{$line}", $_PIR_RISK5_0);
$activeSheet->setCellValue("F{$line}", $_PNR_RISK3_1);
$activeSheet->setCellValue("G{$line}", $_PNR_RISK3_0);
#
// Стили для текста в шапки таблицы.
$activeSheet->getRowDimension($line)->setRowHeight(24); // высота строки
$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setSize(12); // размер шрифта
$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setBold(true); // делаем шрифт жирным
$activeSheet->getStyle("A{$line}:G{$line}")->getAlignment()->setWrapText(true); // разрешаем перенос строк в ячейке
// Выравнивание по вертикали
$activeSheet->getStyle("A{$line}:G{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Выравнивание по горизонтали
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("B{$line}:G{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// Задаем цвет текста строки
$activeSheet->getStyle("A{$line}")->getFont()->getColor()->setRGB('111111');
// Оформляем границы
$activeSheet->getStyle("A{$line}")->applyFromArray($_BORDER_INSIDE);
### 
### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
### 
### 
### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
### 
$line++;
###

# Шапка таблицы
$activeSheet->setCellValue("A{$line}", 'Обеспечение ресурсами');
$activeSheet->setCellValue("B{$line}", $_POS_RISK3_1);
$activeSheet->setCellValue("C{$line}", $_POS_RISK3_0);
$activeSheet->setCellValue("D{$line}", $_PIR_RISK3_1);
$activeSheet->setCellValue("E{$line}", $_PIR_RISK3_0);
$activeSheet->setCellValue("F{$line}", $_PNR_RISK4_1);
$activeSheet->setCellValue("G{$line}", $_PNR_RISK4_0);
#
// Стили для текста в шапки таблицы.
$activeSheet->getRowDimension($line)->setRowHeight(24); // высота строки
$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setSize(12); // размер шрифта
$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setBold(true); // делаем шрифт жирным
$activeSheet->getStyle("A{$line}:G{$line}")->getAlignment()->setWrapText(true); // разрешаем перенос строк в ячейке
// Выравнивание по вертикали
$activeSheet->getStyle("A{$line}:G{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Выравнивание по горизонтали
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("B{$line}:G{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// Задаем цвет текста строки
$activeSheet->getStyle("A{$line}")->getFont()->getColor()->setRGB('111111');
// Оформляем границы
$activeSheet->getStyle("A{$line}")->applyFromArray($_BORDER_INSIDE);
### 
### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
### 
### 
### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
### 
$line++;
###

# Шапка таблицы
$activeSheet->setCellValue("A{$line}", 'Соблюдение сроков поставки');
$activeSheet->setCellValue("B{$line}", $_POS_RISK1_1);
$activeSheet->setCellValue("C{$line}", $_POS_RISK1_0);
$activeSheet->setCellValue("D{$line}", '-');
$activeSheet->setCellValue("E{$line}", '-');
$activeSheet->setCellValue("F{$line}", '-');
$activeSheet->setCellValue("G{$line}", '-');
#
// Стили для текста в шапки таблицы.
$activeSheet->getRowDimension($line)->setRowHeight(24); // высота строки
$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setSize(12); // размер шрифта
$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setBold(true); // делаем шрифт жирным
$activeSheet->getStyle("A{$line}:G{$line}")->getAlignment()->setWrapText(true); // разрешаем перенос строк в ячейке
// Выравнивание по вертикали
$activeSheet->getStyle("A{$line}:G{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Выравнивание по горизонтали
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("B{$line}:G{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// Задаем цвет текста строки
$activeSheet->getStyle("A{$line}")->getFont()->getColor()->setRGB('111111');
// Оформляем границы
$activeSheet->getStyle("A{$line}")->applyFromArray($_BORDER_INSIDE);
### 
### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
### 
### 
### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
### 
$line++;
###

# Шапка таблицы
$activeSheet->setCellValue("A{$line}", 'Осуществимость выполнения договора по срокам (для ПИР)');
$activeSheet->setCellValue("B{$line}", '-');
$activeSheet->setCellValue("C{$line}", '-');
$activeSheet->setCellValue("D{$line}", $_PIR_RISK1_1);
$activeSheet->setCellValue("E{$line}", $_PIR_RISK1_0);
$activeSheet->setCellValue("F{$line}", '-');
$activeSheet->setCellValue("G{$line}", '-');
#
// Стили для текста в шапки таблицы.
$activeSheet->getRowDimension($line)->setRowHeight(24); // высота строки
$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setSize(12); // размер шрифта
$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setBold(true); // делаем шрифт жирным
$activeSheet->getStyle("A{$line}:G{$line}")->getAlignment()->setWrapText(true); // разрешаем перенос строк в ячейке
// Выравнивание по вертикали
$activeSheet->getStyle("A{$line}:G{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Выравнивание по горизонтали
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("B{$line}:G{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// Задаем цвет текста строки
$activeSheet->getStyle("A{$line}")->getFont()->getColor()->setRGB('111111');
// Оформляем границы
$activeSheet->getStyle("A{$line}")->applyFromArray($_BORDER_INSIDE);
### 
### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
### 
### 
### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
### 
$line++;
###

# Шапка таблицы
$activeSheet->setCellValue("A{$line}", 'Полнота исходных данных (для ПИР)');
$activeSheet->setCellValue("B{$line}", '-');
$activeSheet->setCellValue("C{$line}", '-');
$activeSheet->setCellValue("D{$line}", $_PIR_RISK2_1);
$activeSheet->setCellValue("E{$line}", $_PIR_RISK2_0);
$activeSheet->setCellValue("F{$line}", '-');
$activeSheet->setCellValue("G{$line}", '-');
#
// Стили для текста в шапки таблицы.
$activeSheet->getRowDimension($line)->setRowHeight(24); // высота строки
$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setSize(12); // размер шрифта
$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setBold(true); // делаем шрифт жирным
$activeSheet->getStyle("A{$line}:G{$line}")->getAlignment()->setWrapText(true); // разрешаем перенос строк в ячейке
// Выравнивание по вертикали
$activeSheet->getStyle("A{$line}:G{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Выравнивание по горизонтали
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("B{$line}:G{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// Задаем цвет текста строки
$activeSheet->getStyle("A{$line}")->getFont()->getColor()->setRGB('111111');
// Оформляем границы
$activeSheet->getStyle("A{$line}")->applyFromArray($_BORDER_INSIDE);
### 
### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
### 
### 
### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
### 
$line++;
###

# Шапка таблицы
$activeSheet->setCellValue("A{$line}", 'Сезон технического обследования объекта (для ПИР)');
$activeSheet->setCellValue("B{$line}", '-');
$activeSheet->setCellValue("C{$line}", '-');
$activeSheet->setCellValue("D{$line}", $_PIR_RISK4_1);
$activeSheet->setCellValue("E{$line}", $_PIR_RISK4_0);
$activeSheet->setCellValue("F{$line}", '-');
$activeSheet->setCellValue("G{$line}", '-');
#
// Стили для текста в шапки таблицы.
$activeSheet->getRowDimension($line)->setRowHeight(24); // высота строки
$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setSize(12); // размер шрифта
$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setBold(true); // делаем шрифт жирным
$activeSheet->getStyle("A{$line}:G{$line}")->getAlignment()->setWrapText(true); // разрешаем перенос строк в ячейке
// Выравнивание по вертикали
$activeSheet->getStyle("A{$line}:G{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Выравнивание по горизонтали
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("B{$line}:G{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// Задаем цвет текста строки
$activeSheet->getStyle("A{$line}")->getFont()->getColor()->setRGB('111111');
// Оформляем границы
$activeSheet->getStyle("A{$line}")->applyFromArray($_BORDER_INSIDE);
### 
### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
### 
### 
### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
### 
$line++;
###
$tblBodyEnd = $line;
# Шапка таблицы
$activeSheet->setCellValue("A{$line}", 'Иное');
$activeSheet->setCellValue("B{$line}", '-');
$activeSheet->setCellValue("C{$line}", '-');
$activeSheet->setCellValue("D{$line}", '-');
$activeSheet->setCellValue("E{$line}", '-');
$activeSheet->setCellValue("F{$line}", '-');
$activeSheet->setCellValue("G{$line}", '-');
#
// Стили для текста в шапки таблицы.
$activeSheet->getRowDimension($line)->setRowHeight(24); // высота строки
$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setSize(12); // размер шрифта
$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setBold(true); // делаем шрифт жирным
$activeSheet->getStyle("A{$line}:G{$line}")->getAlignment()->setWrapText(true); // разрешаем перенос строк в ячейке
// Выравнивание по вертикали
$activeSheet->getStyle("A{$line}:G{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Выравнивание по горизонтали
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("B{$line}:G{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// Задаем цвет текста строки
$activeSheet->getStyle("A{$line}")->getFont()->getColor()->setRGB('111111');
// Оформляем границы
$activeSheet->getStyle("A{$line}")->applyFromArray($_BORDER_INSIDE);
### 
### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
### 
### 
### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
### 
$line++;
###

# Шапка таблицы
$activeSheet->setCellValue("A{$line}", 'ИТОГО');
$activeSheet->setCellValue("B{$line}", $_POS_RISK1_1 + $_POS_RISK2_1 + $_POS_RISK3_1);
$activeSheet->setCellValue("C{$line}", $_POS_RISK1_0 + $_POS_RISK2_0 + $_POS_RISK3_0);
$activeSheet->setCellValue("D{$line}", $_PIR_RISK1_1 + $_PIR_RISK2_1 + $_PIR_RISK3_1 + $_PIR_RISK4_1 + $_PIR_RISK5_1);
$activeSheet->setCellValue("E{$line}", $_PIR_RISK1_0 + $_PIR_RISK2_0 + $_PIR_RISK3_0 + $_PIR_RISK4_0 + $_PIR_RISK5_0);
$activeSheet->setCellValue("F{$line}", $_PNR_RISK1_1 + $_PNR_RISK2_1 + $_PNR_RISK3_1 + $_PNR_RISK4_1);
$activeSheet->setCellValue("G{$line}", $_PNR_RISK1_0 + $_PNR_RISK2_0 + $_PNR_RISK3_0 + $_PNR_RISK4_0);
#
// Стили для текста в шапки таблицы.
$activeSheet->getRowDimension($line)->setRowHeight(24); // высота строки
$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setSize(12); // размер шрифта
$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->setBold(true); // делаем шрифт жирным
$activeSheet->getStyle("A{$line}:G{$line}")->getAlignment()->setWrapText(true); // разрешаем перенос строк в ячейке
// Выравнивание по вертикали
$activeSheet->getStyle("A{$line}:G{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Выравнивание по горизонтали
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("B{$line}:G{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// Делаем заливку области ячеек
$activeSheet->getStyle("A{$line}:G{$line}")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$activeSheet->getStyle("A{$line}:G{$line}")->getFill()->getStartColor()->setRGB("111111");
// Задаем цвет текста строки
$activeSheet->getStyle("A{$line}:G{$line}")->getFont()->getColor()->setRGB('FFFFFF');
// Оформляем границы
$activeSheet->getStyle("A{$line}")->applyFromArray($_BORDER_INSIDE);
$activeSheet->getStyle("A{$line}")->applyFromArray($_BORDER_OUTSIDE_THIN);
### 
### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
// Делаем внутренние рамки  тела таблицы
$activeSheet->getStyle("A{$tblBodyStart}:G{$tblBodyEnd}")->applyFromArray($_BORDER_INSIDE);
// Добавляем рамку к шапке таблицы
$activeSheet->getStyle("A{$start_table}:G{$start_table}")->applyFromArray($_BORDER_OUTSIDE_THIN);
// Добавляем рамку ко всей таблице
$activeSheet->getStyle("A{$start_table}:G{$line}")->applyFromArray($_BORDER_OUTSIDE_THIN);

// $objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());
// $objPHPExcel->getActiveSheet()->setAutoFilter("A{$start_table}:I{$start_table}");