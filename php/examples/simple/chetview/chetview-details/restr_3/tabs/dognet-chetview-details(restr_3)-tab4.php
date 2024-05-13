
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
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/chetview/chetview-details/restr_3/tabs/css/chetview-details-common-tab4_docs.css">

<div id="doc-details-tabs" class="doc-details-tabs" style="width:100%">
	<ul id="doc-details-tabs-menu" class="nav nav-tabs doc-details-tabs-menu">
		<li class="active"><a data-toggle="tab" href="#doc-details-tab4-3" title="">Оригиналы документов</a></li>
	</ul>
	<div class="tab-content" style="padding:5px; width:100%">
		<div class="space10"></div>
		<div id="doc-details-tab4-3" class="tab-pane fade in active">
					<div class="col-xs-hidden col-sm-12 col-md-12 col-lg-12">
						<h4 class="chetview-details-title3 text-left">Скан-копии подписанных и утвержденных документов</h4>
						<?php include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/chetview/chetview-details/restr_3/tabs/dognet-chetview-details(restr_3)-tab4_7.php"); ?>
					</div>
		</div>
	</div>
</div>
