
<?php

// Фиксируем номер договора, который просматриваем
$__koddoc = $_SESSION['uniqueID'];
// Определяем тип бланка на договор, который просматриваем
$query_docblankwork = mysqlQuery("SELECT kodtipblank FROM dognet_docblankwork WHERE koddoc=".$__koddoc);
$row_docblankwork = mysqli_fetch_assoc($query_docblankwork);
// Фиксируем тип бланка на договор, который просматриваем
$__kodtipblank = $row_docblankwork['kodtipblank'];

?>

<?php
// ----- ----- ----- ----- -----
// Подключаем стили для таблиц
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-details/restr_3/tabs/css/docview-details-common-tab4_docs.css">

<div id="doc-details-tabs" class="doc-details-tabs" style="width:100%">
	<ul id="doc-details-tabs-menu" class="nav nav-tabs doc-details-tabs-menu">
		<li class="active"><a data-toggle="tab" href="#doc-details-tab4-1" title="">Бланки заявок на договор</a></li>
		<li><a data-toggle="tab" href="#doc-details-tab4-2" title="">Основные документы</a></li>
		<li><a data-toggle="tab" href="#doc-details-tab4-3" title="">Оригиналы документов</a></li>
	</ul>
	<div class="tab-content" style="padding:5px; width:100%">
		<div class="space10"></div>
		<div id="doc-details-tab4-1" class="tab-pane fade in active">
				<div class="col-xs-hidden col-sm-12 col-md-4 col-lg-4">
					<h4 class="docview-details-title3 text-left">Итоговый бланк</h4>
					<?php include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/docview/docview-details/restr_3/tabs/dognet-docview-details(restr_3)-tab4_1.php"); ?>
				</div>
				<div class="col-xs-hidden col-sm-12 col-md-4 col-lg-4">
					<h4 class="docview-details-title3 text-left">Промежуточные версии</h4>
					<?php
						if (isset($_SESSION['uniqueID']) && !empty($__kodtipblank)) {
							switch ( $__kodtipblank ) {
								case 'PNR':
									include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/docview/docview-details/restr_3/tabs/dognet-docview-details(restr_3)-tab4_2.php");
									break;
								case 'POS':
									include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/docview/docview-details/restr_3/tabs/dognet-docview-details(restr_3)-tab4_3.php");
									break;
								case 'SUB':
									include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/docview/docview-details/restr_3/tabs/dognet-docview-details(restr_3)-tab4_4.php");
									break;
								default:
							}
						}
						else {
							echo "<div class='dataTables_empty' style='padding:5px'>Документов не найдено</div>";
						}
					?>
				</div>
				<div class="col-xs-hidden col-sm-12 col-md-4 col-lg-4">
					<h4 class="docview-details-title3 text-left">Вложения</h4>
					<?php include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/docview/docview-details/restr_3/tabs/dognet-docview-details(restr_3)-tab4_5.php"); ?>
				</div>
		</div>
		<div id="doc-details-tab4-2" class="tab-pane fade">
					<div class="col-xs-hidden col-sm-12 col-md-12 col-lg-12 space20">
						<h4 class="docview-details-title3 text-left">Не утвержденные документы в открытом формате</h4>
						<?php include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/docview/docview-details/restr_3/tabs/dognet-docview-details(restr_3)-tab4_6.php"); ?>
					</div>
		</div>
		<div id="doc-details-tab4-3" class="tab-pane fade">
					<div class="col-xs-hidden col-sm-12 col-md-12 col-lg-12 space20">
						<h4 class="docview-details-title3 text-left">Скан-копии подписанных и утвержденных документов</h4>
						<?php include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/docview/docview-details/restr_3/tabs/dognet-docview-details(restr_3)-tab4_7.php"); ?>
					</div>
		</div>
	</div>
</div>
