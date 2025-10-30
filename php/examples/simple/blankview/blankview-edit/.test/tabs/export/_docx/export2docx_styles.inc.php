<?php
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# ОБЫЧНАЯ ТАБЛИЦА (TBL)
#
# ----- ----- -----
# Обычная таблица
$_TBL_Common_1 = array(
	'width' => 100 * 50,
	'unit' => "pct",
	'cellMarginLeft' => 50,
	'cellMarginTop' => 10,
	'cellMarginRight' => 50,
	'cellMarginBottom' => 10,
	'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER,
	'layout'      => \PhpOffice\PhpWord\Style\Table::LAYOUT_FIXED
);
# ----- ----- -----
# Обычная таблица (без рамок)
$_TBL_Common_Fixed = array(
	'width' => 100 * 50,
	'unit' => "pct",
	'cellMarginLeft' => 50,
	'cellMarginTop' => 10,
	'cellMarginRight' => 50,
	'cellMarginBottom' => 10,
	'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER,
	'layout'      => \PhpOffice\PhpWord\Style\Table::LAYOUT_FIXED
);
# ----- ----- -----
# Обычная таблица (без рамок)
$_TBL_Common_Auto = array(
	'width' => 100 * 50,
	'unit' => "pct",
	'cellMarginLeft' => 50,
	'cellMarginTop' => 10,
	'cellMarginRight' => 50,
	'cellMarginBottom' => 10,
	'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER,
	'layout'      => \PhpOffice\PhpWord\Style\Table::LAYOUT_AUTO
);
$_TBL_Header = array(
	'width' => 100 * 50,
	'unit' => "pct",
	'tblHeader' => true,
	'cellSpacing' => 50,
	'cellMarginLeft' => 50,
	'cellMarginTop' => 10,
	'cellMarginRight' => 50,
	'cellMarginBottom' => 10,
	'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER,
	'layout'      => \PhpOffice\PhpWord\Style\Table::LAYOUT_FIXED
);
# ----- ----- -----
$_TBL_Header_Row = array( 'valign' => 'center', 'exactHeight' => false );
$_TBL_Header_Cell_Left = array(	'valign' => 'center',	'borderTopColor' => "111111",	'borderTopSize' => 2, 'borderLefttColor' => "111111",	'borderLeftSize' => 2, 'borderBottomColor' => "111111", 'borderBottomSize' => 2 );
$_TBL_Header_Cell = array( 'valign' => 'center', 'borderTopColor' => "111111",	'borderTopSize' => 2, 'borderLeftColor' => "111111",	'borderLeftSize' => 2, 'borderRightColor' => "111111",	'borderRightSize' => 2, 'borderBottomColor' => "111111", 'borderBottomSize' => 2 );
$_TBL_Header_Cell_Right = array(	'valign' => 'center',	'borderTopColor' => "111111",	'borderTopSize' => 2,'borderRightColor' => "111111",	'borderRightSize' => 2, 'borderBottomColor' => "111111", 'borderBottomSize' => 2 );
# ----- ----- -----
$_TBL_Body_Row = array( 'valign' => 'center', 'exactHeight' => false );
$_TBL_Body_Cell_Clear = array( 'valign' => 'center' );
$_TBL_Body_Cell_ClearT = array( 'valign' => 'top' );
$_TBL_Body_Cell_ClearB = array( 'valign' => 'bottom' );
$_TBL_Body_Cell_Left = array(	'valign' => 'center',	'borderLeftColor' => "111111",	'borderLeftSize' => 2, 'borderBottomColor' => "111111", 'borderBottomSize' => 2 );
$_TBL_Body_Cell = array( 'valign' => 'center', 'borderTopColor' => "111111",	'borderTopSize' => 2, 'borderLeftColor' => "111111",	'borderLeftSize' => 2, 'borderRightColor' => "111111",	'borderRightSize' => 2, 'borderBottomColor' => "111111", 'borderBottomSize' => 2 );
$_TBL_Body_Cell_Right = array(	'valign' => 'center',	'borderRightColor' => "111111",	'borderRightSize' => 2, 'borderBottomColor' => "111111", 'borderBottomSize' => 2 );
$_TBL_Body_Cell_B = array( 'valign' => 'center', 'borderBottomColor' => "111111", 'borderBottomSize' => 2 );
$_TBL_Body_Cell_BL = array( 'valign' => 'center', 'borderLeftColor' => "111111",	'borderLeftSize' => 2, 'borderBottomColor' => "111111", 'borderBottomSize' => 2 );
$_TBL_Body_Cell_BR = array( 'valign' => 'center', 'borderRightColor' => "111111",	'borderRightSize' => 2, 'borderBottomColor' => "111111", 'borderBottomSize' => 2 );
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# ВНУТРЕННЯЯ ТАБЛИЦА (InnerTBL)
#
# ----- ----- -----
# Обычная таблица (с рамками, для вставки внутрь)
$_InnerTBL_Common_1 = array(
	'width' => 100 * 50,
	'unit' => "pct",
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
# ----- ----- -----
# Обычная таблица (без рамок, для вставки внутрь)
$_InnerTBL_Common_0 = array(
	'width' => 100 * 50,
	'unit' => "pct",
	'cellMarginLeft' => 50,
	'cellMarginTop' => 10,
	'cellMarginRight' => 50,
	'cellMarginBottom' => 10,
	'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER
);
# ----- ----- -----
# Обычная таблица (без рамок, для вставки внутрь)
$_InnerTBL_Common_0L = array(
	'width' => 100 * 50,
	'unit' => "pct",
	'cellMarginLeft' => 50,
	'cellMarginTop' => 10,
	'cellMarginRight' => 50,
	'cellMarginBottom' => 10,
	'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::START
);
# -----
$_InnerTBL_Header = array(
	'tblHeader' => true,
	'cellSpacing' => 50,
	'cellMarginLeft' => 50,
	'cellMarginTop' => 10,
	'cellMarginRight' => 50,
	'cellMarginBottom' => 10,
	'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER
);
# ----- ----- -----
$_InnerTBL_Header_Cell = array( 'valign' => 'center' );
$_InnerTBL_Header_Row = array( 'valign' => 'center', 'exactHeight' => false );
$_InnerTBL_Body_Row = array( 'valign' => 'center', 'exactHeight' => false );
$_InnerTBL_Body_Cell_Left = array(	'valign' => 'center' );
$_InnerTBL_Body_Cell = array( 'valign' => 'center' );
$_InnerTBL_Body_Cell_Right = array(	'valign' => 'center' );
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# ШРИФТЫ
#
# ----- ----- -----
$_FONT_H14 = array('name' => "Arial", 'size' => 14);
$_FONT_H14_B = array('name' => "Arial", 'bold' => true, 'size' => 14);
$_FONT_H13 = array('name' => "Arial", 'size' => 13);
$_FONT_H13_B = array('name' => "Arial", 'bold' => true, 'size' => 13);
$_FONT_H13_UB = array('name' => "Arial", 'underline' => 'single', 'bold' => true, 'size' => 13);
$_FONT_H12 = array('name' => "Arial", 'size' => 12);
$_FONT_H12_B = array('name' => "Arial", 'bold' => true, 'size' => 12);
$_FONT_H12_CAPS_B = array('name' => "Arial", 'allCaps' => true, 'bold' => true, 'size' => 12);
$_FONT_H11 = array('name' => "Arial", 'size' => 11);
$_FONT_H11_CAPS_B = array('name' => "Arial", 'allCaps' => true, 'bold' => true, 'size' => 11);
$_FONT_H10 = array('name' => "Arial", 'italic' => true, 'allCaps' => false, 'bold' => false, 'size' => 10);
$_FONT_H10_B = array('name' => "Arial", 'bold' => true, 'size' => 10);
$_FONT_H10_I = array('name' => "Arial", 'italic' => true, 'allCaps' => false, 'bold' => false, 'size' => 10);
$_FONT_H10_BI = array('name' => "Arial", 'italic' => true, 'allCaps' => false, 'bold' => true, 'size' => 10);
$_FONT_H9 = array('name' => "Arial", 'italic' => false, 'allCaps' => false, 'bold' => false, 'size' => 9);
$_FONT_H9_I = array('name' => "Arial", 'italic' => true, 'allCaps' => false, 'bold' => false, 'size' => 9);
$_FONT_H8_CAPS = array('name' => "Arial", 'italic' => false, 'allCaps' => true, 'bold' => false, 'size' => 8);
$_FONT_H8_CAPS_B = array('name' => "Arial", 'italic' => false, 'allCaps' => true, 'bold' => true, 'size' => 8);
# ----- ----- -----
$_FONT_P13 = array('name' => "Arial", 'size' => 13);
$_FONT_P13_B = array('name' => "Arial", 'bold' => true, 'size' => 13);
$_FONT_P13_UB = array('name' => "Arial", 'underline' => 'single', 'bold' => true, 'size' => 13);
$_FONT_P12 = array('name' => "Arial", 'size' => 12);
$_FONT_P12_I = array('name' => "Arial", 'italic' => true, 'size' => 12);
$_FONT_P12_B = array('name' => "Arial", 'bold' => true, 'size' => 12);
$_FONT_P12_UB = array('name' => "Arial", 'underline' => 'single', 'bold' => true, 'size' => 12);
$_FONT_P11 = array('name' => "Arial", 'size' => 11);
$_FONT_P11_B = array('name' => "Arial", 'bold' => true, 'size' => 11);
$_FONT_P10 = array('name' => "Arial", 'size' => 10);
$_FONT_P10_B = array('name' => "Arial", 'bold' => true, 'size' => 10);
$_FONT_P10_I = array('name' => "Arial", 'italic' => true, 'size' => 10);
$_FONT_P10_UI = array('name' => "Arial", 'italic' => true, 'underline' => 'single', 'size' => 10);
$_FONT_P10_CAPS = array('name' => "Arial", 'bold' => false, 'allCaps' => true, 'size' => 10);
$_FONT_P10_CAPS_B = array('name' => "Arial", 'bold' => true, 'allCaps' => true, 'size' => 10);
$_FONT_P9 = array('name' => "Arial", 'size' => 9);
$_FONT_P9_B = array('name' => "Arial", 'bold' => true, 'size' => 9);
$_FONT_P9_U = array('name' => "Arial", 'underline' => 'single', 'size' => 9);
$_FONT_P9_UI = array('name' => "Arial", 'italic' => true, 'underline' => 'single', 'size' => 9);
$_FONT_P9_UB = array('name' => "Arial", 'underline' => 'single', 'bold' => true, 'size' => 9);
$_FONT_P9_UBI = array('name' => "Arial", 'italic' => true, 'underline' => 'single', 'bold' => true, 'size' => 9);
$_FONT_P9_CAPS = array('name' => "Arial", 'allCaps' => true, 'size' => 9);
$_FONT_P9_CAPS_UI = array('name' => "Arial", 'italic' => true, 'underline' => 'single', 'allCaps' => true, 'size' => 9);
$_FONT_P9_CAPS_UBI = array('name' => "Arial", 'italic' => true, 'underline' => 'single', 'bold' => true, 'allCaps' => true, 'size' => 9);
$_FONT_P8 = array('name' => "Arial", 'size' => 8);
$_FONT_P8_B = array('name' => "Arial", 'bold' => true, 'size' => 8);
$_FONT_P7 = array('name' => "Arial", 'size' => 7);
$_FONT_P7_I = array('name' => "Arial", 'italic' => true, 'size' => 7);
$_FONT_P2 = array('name' => "Arial", 'size' => 2);
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# ВЫРАВНИВАНИЯ
#
# ----- ----- -----
$_TXTRUN_Align_Left = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT);
$_TXTRUN_Align_Right = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::RIGHT);
$_TXTRUN_Align_Center = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);


$_TXT_INCELL_1L = array('widowControl' => false, 'indentation' => array('left' => 30, 'right' => 30), 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT, 'spacing' => 30, 'spaceBefore' => 60, 'spaceAfter' => 60);
$_TXT_INCELL_1R = array('widowControl' => false, 'indentation' => array('left' => 30, 'right' => 30), 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::RIGHT, 'spacing' => 30, 'spaceBefore' => 60, 'spaceAfter' => 60);
$_TXT_INCELL_1C = array('widowControl' => false, 'indentation' => array('left' => 30, 'right' => 30), 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spacing' => 30, 'spaceBefore' => 60, 'spaceAfter' => 60);
