<?php
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# ОБЩИЙ СТИЛЬ ТАБЛИЦЫ
#
$_TBL_TABLEStyle = array(
	'cellMarginLeft' => 50,
	'cellMarginTop' => 10,
	'cellMarginRight' => 50,
	'cellMarginBottom' => 10,
	'borderTopColor' => "111111",
	'borderTopSize' => 2,
	'borderRightColor' => "111111",
	'borderRightSize' => 2,
	'borderLeftColor' => "111111",
	'borderLeftSize' => 2,
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2,
	'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER
);
$_TBL_TABLEStyle_Common = array(
	'cellSpacing' => 50,
	'cellMarginLeft' => 50,
	'cellMarginTop' => 10,
	'cellMarginRight' => 50,
	'cellMarginBottom' => 10,
	'borderTopColor' => "999999",
	'borderTopSize' => 2,
	'borderRightColor' => "999999",
	'borderRightSize' => 2,
	'borderLeftColor' => "999999",
	'borderLeftSize' => 2,
	'borderBottomColor' => "999999",
	'borderBottomSize' => 2,
	'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER
);
$_TBL_TABLEStyle_DocHeader = array(
	'cellSpacing' => 50,
	'cellMarginLeft' => 50,
	'cellMarginTop' => 10,
	'cellMarginRight' => 50,
	'cellMarginBottom' => 10,
	'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER
);
$_TBL_TABLEStyle_DocHeader0 = array(
	'cellSpacing' => 0,
	'cellMarginLeft' => 50,
	'cellMarginTop' => 0,
	'cellMarginRight' => 50,
	'cellMarginBottom' => 0,
	'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER
);
$_TBL_TABLEStyle_Inner = array(
	'cellSpacing' => 10,
	'cellMarginLeft' => 50,
	'cellMarginTop' => 10,
	'cellMarginRight' => 50,
	'cellMarginBottom' => 10,
	'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER
);
$_TBL_TABLEStyle_Inner0 = array(
	'cellSpacing' => 0,
	'cellMarginLeft' => 50,
	'cellMarginTop' => 0,
	'cellMarginRight' => 50,
	'cellMarginBottom' => 0,
	'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER
);
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# ШАПКА ТАБЛИЦЫ
#
// Стиль TBL.HEADER.ROW
$_TBL_HEADERStyle_Row = array(
	'tblHeader' => false
);
// Стиль TBL.HEADER.CELL-LEFT
$_TBL_BODYStyle_CellLeft_Grid5_1 = array(
	'valign' => 'center',
	'gridSpan' => 5,
	'bgColor' => 'F1F1F1',
	'borderRightColor' => "111111",
	'borderRightSize' => 2,
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2
);
// Стиль TBL.HEADER.CELL-LEFT
$_TBL_HEADERStyle_CellLeft = array(
	'valign' => 'center',
	'bgColor' => 'F1F1F1',
	'borderRightColor' => "111111",
	'borderRightSize' => 2,
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2
);
// Стиль TBL.HEADER.CELL
$_TBL_HEADERStyle_Cell = array(
	'valign' => 'center',
	'bgColor' => 'F1F1F1',
	'borderRightColor' => "111111",
	'borderRightSize' => 2,
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2
);
// Стиль TBL.HEADER.CELL Common
$_TBL_HEADERStyle_Cell_Common = array(
	'valign' => 'center',
	'bgColor' => 'F1F1F1'
);
$_TBL_HEADERStyle_Cell_DocHeader = array(
	'valign' => 'center'
);
// Стиль TBL.HEADER.CELL-LEFT
$_TBL_HEADERStyle_CellRight = array(
	'valign' => 'center',
	'bgColor' => 'F1F1F1',
	'borderLeftColor' => "111111",
	'borderLeftSize' => 2,
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2
);
// FONT TBL.HEADER.CELL
$_FontStyle_DocHeader_H1 = array('name' => "Times New Roman", 'allCaps' => true, 'bold' => true, 'size' => 12);
$_FontStyle_DocHeader_H2 = array('name' => "Times New Roman", 'allCaps' => true, 'bold' => true, 'size' => 11);
$_FontStyle_DocHeader_H3 = array('name' => "Times New Roman", 'italic' => true, 'allCaps' => false, 'bold' => false, 'size' => 10);

$_FontStyle_Doc_P9 = array('name' => "Times New Roman", 'size' => 9);
$_FontStyle_Doc_P9_Large = array('name' => "Times New Roman", 'size' => 10);
$_FontStyle_Doc_P9_B = array('name' => "Times New Roman", 'bold' => true, 'size' => 9);
$_FontStyle_Doc_P9_U = array('name' => "Times New Roman", 'underline' => 'single', 'size' => 9);
$_FontStyle_Doc_P9_UI = array('name' => "Times New Roman", 'italic' => true, 'underline' => 'single', 'size' => 9);
$_FontStyle_Doc_P9_UB = array('name' => "Times New Roman", 'underline' => 'single', 'bold' => true, 'size' => 9);
$_FontStyle_Doc_P9_UBI = array('name' => "Times New Roman", 'italic' => true, 'underline' => 'single', 'bold' => true, 'size' => 9);
$_FontStyle_Doc_P9_CAPS = array('name' => "Times New Roman", 'allCaps' => true, 'size' => 9);
$_FontStyle_Doc_P9_CAPS_UI = array('name' => "Times New Roman", 'italic' => true, 'underline' => 'single', 'allCaps' => true, 'size' => 9);
$_FontStyle_Doc_P9_CAPS_UBI = array('name' => "Times New Roman", 'italic' => true, 'underline' => 'single', 'bold' => true, 'allCaps' => true, 'size' => 9);

$_FontStyle_Doc_P10 = array('name' => "Times New Roman", 'size' => 10);
$_FontStyle_Doc_P10_Large = array('name' => "Times New Roman", 'size' => 10);
$_FontStyle_Doc_P10_B = array('name' => "Times New Roman", 'bold' => true, 'size' => 10);
$_FontStyle_Doc_P10_U = array('name' => "Times New Roman", 'underline' => 'single', 'size' => 10);
$_FontStyle_Doc_P10_UI = array('name' => "Times New Roman", 'italic' => true, 'underline' => 'single', 'size' => 10);
$_FontStyle_Doc_P10_UB = array('name' => "Times New Roman", 'underline' => 'single', 'bold' => true, 'size' => 10);
$_FontStyle_Doc_P10_UBI = array('name' => "Times New Roman", 'italic' => true, 'underline' => 'single', 'bold' => true, 'size' => 10);
$_FontStyle_Doc_P10_CAPS = array('name' => "Times New Roman", 'allCaps' => true, 'size' => 10);
$_FontStyle_Doc_P10_CAPS_UI = array('name' => "Times New Roman", 'italic' => true, 'underline' => 'single', 'allCaps' => true, 'size' => 10);
$_FontStyle_Doc_P10_CAPS_UBI = array('name' => "Times New Roman", 'italic' => true, 'underline' => 'single', 'bold' => true, 'allCaps' => true, 'size' => 10);

$_FontStyle_Doc_P11 = array('name' => "Times New Roman", 'size' => 11);
$_FontStyle_Doc_P11_Large = array('name' => "Times New Roman", 'size' => 11);
$_FontStyle_Doc_P11_B = array('name' => "Times New Roman", 'bold' => true, 'size' => 11);
$_FontStyle_Doc_P11_U = array('name' => "Times New Roman", 'underline' => 'single', 'size' => 11);
$_FontStyle_Doc_P11_UI = array('name' => "Times New Roman", 'italic' => true, 'underline' => 'single', 'size' => 11);
$_FontStyle_Doc_P11_UB = array('name' => "Times New Roman", 'underline' => 'single', 'bold' => true, 'size' => 11);
$_FontStyle_Doc_P11_UBI = array('name' => "Times New Roman", 'italic' => true, 'underline' => 'single', 'bold' => true, 'size' => 11);
$_FontStyle_Doc_P11_CAPS = array('name' => "Times New Roman", 'allCaps' => true, 'size' => 11);
$_FontStyle_Doc_P11_CAPS_UI = array('name' => "Times New Roman", 'italic' => true, 'underline' => 'single', 'allCaps' => true, 'size' => 11);
$_FontStyle_Doc_P11_CAPS_UBI = array('name' => "Times New Roman", 'italic' => true, 'underline' => 'single', 'bold' => true, 'allCaps' => true, 'size' => 11);

$_FontStyle_Doc_P7 = array('name' => "Times New Roman", 'size' => 7);
$_FontStyle_Doc_P7_I = array('name' => "Times New Roman", 'italic' => true, 'size' => 7);
$_FontStyle_Doc_P8 = array('name' => "Times New Roman", 'size' => 8, 'color' => "666666");
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# ТЕЛО ТАБЛИЦЫ
#
// Стиль TBL.BODY.ROW
$_TBL_BODYStyle_Row = array(
	'exactHeight' => false
);
// Стиль TBL.BODY
$_TBL_BODYStyle_Cell_Inner = array(
	'valign' => 'center'
);
// Стиль TBL.BODY.CELLSPAN
$_TBL_BODYStyle_Cell_ClearEmpty = array(
	'valign' => 'center',
	'bgColor' => 'FFFFFF',
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2
);
$_TBL_BODYStyle_Cell_0 = array(
	'valign' => 'center',
	'bgColor' => 'FFFFFF',
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2
);
$_TBL_BODYStyle_Cell_Grid2_0 = array(
	'valign' => 'center',
	'gridSpan' => 2,
	'bgColor' => 'FFFFFF',
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2
);
$_TBL_BODYStyle_Cell_Grid4_0 = array(
	'valign' => 'center',
	'gridSpan' => 4,
	'bgColor' => 'FFFFFF',
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2
);
$_TBL_BODYStyle_Cell_Grid5_0 = array(
	'valign' => 'center',
	'gridSpan' => 5,
	'bgColor' => 'FFFFFF',
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2
);
$_TBL_BODYStyle_Cell_Grid6_0 = array(
	'valign' => 'center',
	'gridSpan' => 6,
	'bgColor' => 'FFFFFF',
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2
);
$_TBL_BODYStyle_Cell_Grid6_ItogoSub = array(
	'valign' => 'center',
	'gridSpan' => 6,
	'bgColor' => 'D0D0D0',
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2,
	'borderRightColor' => "111111",
	'borderRightSize' => 2
);
$_TBL_BODYStyle_Cell_Grid7_ItogoSub = array(
	'valign' => 'center',
	'gridSpan' => 7,
	'bgColor' => 'D0D0D0',
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2,
	'borderRightColor' => "111111",
	'borderRightSize' => 2
);
$_TBL_BODYStyle_Cell_ItogoSub = array(
	'valign' => 'center',
	'bgColor' => 'D0D0D0',
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2
);
$_TBL_BODYStyle_Cell_Grid7_0 = array(
	'valign' => 'center',
	'gridSpan' => 7,
	'bgColor' => 'FFFFFF',
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2
);
$_TBL_BODYStyle_Cell_Grid8_0 = array(
	'valign' => 'center',
	'gridSpan' => 8,
	'bgColor' => 'FFFFFF',
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2
);
$_TBL_BODYStyle_Cell_Grid4_1 = array(
	'valign' => 'center',
	'gridSpan' => 4,
	'bgColor' => 'E0E0E0',
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2
);
$_TBL_BODYStyle_Cell_Grid8_1 = array(
	'valign' => 'center',
	'gridSpan' => 8,
	'bgColor' => 'E0E0E0',
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2
);
$_TBL_BODYStyle_Cell_Grid9_1 = array(
	'valign' => 'center',
	'gridSpan' => 9,
	'bgColor' => 'E0E0E0',
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2
);
$_TBL_BODYStyle_Cell_Grid4_2 = array(
	'valign' => 'center',
	'gridSpan' => 4,
	'bgColor' => '111111',
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2
);
$_TBL_BODYStyle_Cell_Grid8_2 = array(
	'valign' => 'center',
	'gridSpan' => 8,
	'bgColor' => '111111',
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2
);
$_TBL_BODYStyle_Cell_Grid9_2 = array(
	'valign' => 'center',
	'gridSpan' => 9,
	'bgColor' => '111111',
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2
);
$_TBL_BODYStyle_Cell_Grid4_3 = array(
	'valign' => 'center',
	'gridSpan' => 4,
	'bgColor' => 'FAFAFA',
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2
);
$_TBL_BODYStyle_Cell_Grid2_3 = array(
	'valign' => 'center',
	'gridSpan' => 2,
	'bgColor' => 'FFFFFF',
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2,
	'borderRightColor' => "111111",
	'borderRightSize' => 2
);
$_TBL_BODYStyle_Cell_Grid3_3 = array(
	'valign' => 'center',
	'gridSpan' => 3,
	'bgColor' => 'FFFFFF',
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2
);
$_TBL_BODYStyle_Cell_Grid5_3 = array(
	'valign' => 'center',
	'gridSpan' => 5,
	'bgColor' => 'FAFAFA',
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2
);
$_TBL_BODYStyle_Cell_Grid6_3 = array(
	'valign' => 'center',
	'gridSpan' => 6,
	'bgColor' => 'FFFFFF',
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2,
	'borderRightColor' => "111111",
	'borderRightSize' => 2
);
$_TBL_BODYStyle_Cell_Grid7_3 = array(
	'valign' => 'center',
	'gridSpan' => 7,
	'bgColor' => 'FFFFFF',
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2,
	'borderRightColor' => "111111",
	'borderRightSize' => 2
);
$_TBL_BODYStyle_Cell_Grid4_4 = array(
	'valign' => 'center',
	'gridSpan' => 4,
	'bgColor' => 'D0D0D0',
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2
);
$_TBL_BODYStyle_Cell_Grid3_1 = array(
	'valign' => 'center',
	'gridSpan' => 3,
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2
);
$_TBL_BODYStyle_Cell_Grid2_1 = array(
	'valign' => 'center',
	'gridSpan' => 2,
	'bgColor' => 'FFFFFF',
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2
);
$_TBL_BODYStyle_Cell_1 = array(
	'valign' => 'center',
	'bgColor' => 'FFFFFF',
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2
);
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Строка "ИТОГО ПО СЧЕТУ/ДОГОВОРУ"
#
// Ячейка 1-2
$_TBL_BODYStyle_Cell_Grid2_ItogoLvl2 = array(
	'valign' => 'center',
	'gridSpan' => 2,
	'bgColor' => 'FFFFFF',
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2
);
$_TBL_BODYStyle_Cell_Grid6_2 = array(
	'valign' => 'center',
	'gridSpan' => 2,
	'bgColor' => 'FFFFFF',
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2
);
// Ячейка 3
$_TBL_BODYStyle_Cell_3_ItogoLvl2 = array(
	'valign' => 'center',
	'bgColor' => 'FFFFFF',
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2,
	'borderRightColor' => "111111",
	'borderRightSize' => 2,
	'borderLeftColor' => "111111",
	'borderLeftSize' => 2
);
// Ячейка 4
$_TBL_BODYStyle_Cell_4_ItogoLvl2 = array(
	'valign' => 'center',
	'bgColor' => 'FFFFFF',
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2
);
$_TBL_BODYFont_Title_H2_1 = array('name' => "Times New Roman", 'allcaps' => true, 'bold' => true, 'size' => 9, 'color' => "111111");
$_TBL_BODYFont_Title_H2_2 = array('name' => "Times New Roman", 'bold' => true, 'size' => 9, 'color' => "111111");
$_TBL_BODYFont_Title_H2_2_C20607 = array('name' => "Times New Roman", 'bold' => true, 'size' => 9, 'color' => "C20607");
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Строка "ИТОГО ПО СУБПОДРЯДЧИКУ"
#
// Ячейка 1-2
$_TBL_BODYStyle_Cell_Grid2_ItogoLvl1 = array(
	'valign' => 'center',
	'gridSpan' => 2,
	'bgColor' => 'D0D0D0',
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2
);
// Ячейка 3
$_TBL_BODYStyle_Cell_3_ItogoLvl1 = array(
	'valign' => 'center',
	'bgColor' => 'D0D0D0',
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2,
	'borderRightColor' => "111111",
	'borderRightSize' => 2,
	'borderLeftColor' => "111111",
	'borderLeftSize' => 2
);
// Ячейка 4
$_TBL_BODYStyle_Cell_4_ItogoLvl1 = array(
	'valign' => 'center',
	'bgColor' => 'D0D0D0',
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2
);
// Шрифты
$_TBL_BODYFont_Title_H1_1 = array('name' => "Times New Roman Narrow", 'allcaps' => true, 'bold' => true, 'size' => 12, 'color' => "111111");
$_TBL_BODYFont_Title_H1_2 = array('name' => "Times New Roman Narrow", 'bold' => true, 'size' => 12, 'color' => "111111");
$_TBL_BODYFont_Title_H1_2_C20607 = array('name' => "Times New Roman Narrow", 'bold' => true, 'size' => 12, 'color' => "C20607");
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

$_TBL_BODYStyle_Cell_Grid2_2 = array(
	'valign' => 'center',
	'gridSpan' => 2,
	'bgColor' => 'D0D0D0',
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2
);
// Ячейка 3
$_TBL_BODYStyle_Cell_2 = array(
	'valign' => 'center',
	'bgColor' => 'D0D0D0',
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2
);
// Ячейка 4
$_TBL_BODYStyle_Cell_4 = array(
	'valign' => 'center',
	'bgColor' => 'FFFFFF',
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2
);
$_TBL_BODYStyle_Cell_3 = array(
	'valign' => 'center',
	'bgColor' => 'FFFFFF',
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2
);
// Стиль TBL.BODY.CELL-LEFT
$_TBL_BODYStyle_Cell_RightBorder = array(
	'valign' => 'center',
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2,
	'borderRightColor' => "111111",
	'borderRightSize' => 2
);
// Стиль TBL.BODY.CELL
$_TBL_BODYStyle_Cell = array(
	'valign' => 'center',
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2
);
$_TBL_BODYStyle_Cell_Grid3 = array(
	'valign' => 'center',
	'gridSpan' => 3,
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2,
	'borderRightColor' => "111111",
	'borderRightSize' => 2
);
$_TBL_BODYStyle_Cell_Grid4 = array(
	'valign' => 'center',
	'gridSpan' => 4,
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2,
	'borderRightColor' => "111111",
	'borderRightSize' => 2
);
// Стиль TBL.BODY.CELL-RIGHT
$_TBL_BODYStyle_Cell_LeftBorder = array(
	'valign' => 'center',
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2,
	'borderLeftColor' => "111111",
	'borderLeftSize' => 2
);
// FONTS TBL.BODY.CELL
$_TBL_BODYFont_H1_1 = array('name' => "Times New Roman Narrow", 'allcaps' => true, 'bold' => true, 'size' => 11, 'color' => "111111");
$_TBL_BODYFont_H1_2 = array('name' => "Times New Roman Narrow", 'allcaps' => true, 'bold' => true, 'size' => 11, 'color' => "FFFFFF");
$_TBL_BODYFont_H1_3 = array('name' => "Times New Roman", 'bold' => true, 'size' => 11, 'color' => "111111");

$_TBL_BODYFont_H2_1 = array('name' => "Times New Roman", 'bold' => true, 'size' => 9, 'color' => "111111");
$_TBL_BODYFont_H2_2 = array('name' => "Times New Roman", 'bold' => true, 'size' => 9, 'color' => "D9534F");
	$_TBL_BODYFont_H3_1 = array('name' => "Times New Roman", 'italic' => false, 'size' => 9, 'color' => "111111");
$_TBL_BODYFont = array('name' => "Times New Roman", 'bold' => false, 'size' => 8, 'color' => "666666");
$_TBL_BODYFont_S8_111111 = array('name' => "Times New Roman", 'bold' => false, 'size' => 8, 'color' => "111111");
$_TBL_BODYFont_S8B_111111 = array('name' => "Times New Roman", 'bold' => true, 'size' => 8, 'color' => "111111");
$_TBL_BODYFont_S8_C20607 = array('name' => "Times New Roman", 'bold' => false, 'size' => 8, 'color' => "C20607");
$_TBL_BODYFont_S8B_C20607 = array('name' => "Times New Roman", 'bold' => true, 'size' => 8, 'color' => "C20607");
$_TBL_BODYFont_S8B_111111_CAPS = array('name' => "Times New Roman", 'allcaps' => true, 'bold' => true, 'size' => 8, 'color' => "111111");
$_TBL_BODYFont_S8I_999999 = array('name' => "Times New Roman", 'italic' => true, 'size' => 8, 'color' => "999999");





$_TBL_BODYFont_2 = array('name' => "Times New Roman", 'bold' => false, 'size' => 10, 'color' => "333333");
// -----
$_TBL_CELLAlign_H_Left = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT);
$_TBL_CELLAlign_H_Right = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::RIGHT);
$_TBL_CELLAlign_H_Center = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);
$_TBL_CELLAlign_V_Middle = array('valign' => 'center');
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

$_TBL_BODYFont_Title_H3_1 = array('name' => "Times New Roman", 'bold' => true, 'size' => 9, 'color' => "111111");
$_TBL_BODYFont_Title_H3_2 = array('name' => "Times New Roman", 'bold' => true, 'size' => 9, 'color' => "111111");
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----


$_TBL_BODYStyle_Cell_Date = array(
	'valign' => 'center',
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2,
	'borderRightColor' => "111111",
	'borderRightSize' => 2
);
$_TBL_BODYStyle_Cell_Sum1 = array(
	'valign' => 'center',
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2,
	'borderRightColor' => "111111",
	'borderRightSize' => 2
);
$_TBL_BODYStyle_Cell_ItogoSub_Sum1 = array(
	'valign' => 'center',
	'bgColor' => 'D0D0D0',
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2,
	'borderRightColor' => "111111",
	'borderRightSize' => 2
);



?>