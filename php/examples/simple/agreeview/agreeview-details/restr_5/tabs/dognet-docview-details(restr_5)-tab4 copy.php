
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/date-de.js"></script>
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/moment-with-locales.js"></script>

<!-- Custom Table style -->
<link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/css/docview-table-details-tab4-custom.css">
<!-- Custom Form Editor style -->
<link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/css/docview-customForm-details-tab4-Editor.css">

<?php

// Фиксируем номер договора, который просматриваем
$__koddoc = $_SESSION['uniqueID'];
// Определяем тип бланка на договор, который просматриваем
$query_docblankwork = mysqlQuery("SELECT kodtipblank FROM dognet_docblankwork WHERE koddoc=".$__koddoc);
$row_docblankwork = mysqli_fetch_assoc($query_docblankwork);
// Фиксируем тип бланка на договор, который просматриваем
$__kodtipblank = $row_docblankwork['kodtipblank'];
	
?>

<style>
	#tab4_groups .panel-title {
		color:#333;
		font-family:'Oswald', sans-serif;
	  font-weight:500;
	  font-size:1.3em;
	  text-transform:uppercase;
	  letter-spacing:normal;
	  padding:0;
	}
</style>

<div class="space20"></div>
<div id="tab4_groups" class="row" style="padding:0 5px">
	<div class="col-xs-hidden col-sm-12 col-md-12 col-lg-12 space20">
		<div class="panel-group">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="media">
						<div class="media-left media-middle">
							<span class="" style="font-size:1.6em"><span class="glyphicon glyphicon-open-file"></span></span>
						</div>
						<div class="media-body media-middle">
							<h4 class="panel-title">
								<a data-toggle="collapse" href="#tab4_group1">Первичные документы</a>
							</h4>
						</div>
					</div>
				</div>
				<div id="tab4_group1" class="panel-collapse collapse in">
					<div class="col-xs-hidden col-sm-12 col-md-12 col-lg-12 space20">
						<div class="space20"></div>
						<h4 class="space10">Итоговый бланк заявки на договор</h4>
						<?php include("dognet-docview-details(restr_5)-tab4_1.php"); ?>
					</div>
					<div class="col-xs-hidden col-sm-12 col-md-6 col-lg-6 space20">
						<h4 class="space10">Промежуточные версии бланков</h4>
						<?php 
							if (isset($_SESSION['uniqueID']) && !empty($__kodtipblank)) {
								switch ( $__kodtipblank ) {
									case 'PNR':
										include("dognet-docview-details(restr_5)-tab4_2.php");
										break;
									case 'POS':
										include("dognet-docview-details(restr_5)-tab4_3.php");
										break;
									case 'SUB':
										include("dognet-docview-details(restr_5)-tab4_4.php");
										break;
									default: 
								}
							}
						?>
					</div>
					<div class="col-xs-hidden col-sm-12 col-md-6 col-lg-6 space20">
						<h4 class="space10">Вложения</h4>
						<?php include("dognet-docview-details(restr_5)-tab4_5.php"); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-hidden col-sm-12 col-md-12 col-lg-12 space20">
		<div class="panel-group">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="media">
						<div class="media-left media-middle">
							<span class="" style="font-size:1.6em"><span class="glyphicon glyphicon-open-file"></span></span>
						</div>
						<div class="media-body media-middle">
							<h4 class="panel-title">
								<a data-toggle="collapse" href="#tab4_group2">Основные документы</a>
							</h4>
						</div>
					</div>
				</div>
				<div id="tab4_group2" class="panel-collapse collapse in">
					<div class="col-xs-hidden col-sm-12 col-md-12 col-lg-12 space20">
						<div class="space20"></div>
						<h4 class="space10">Не утвержденные документы в открытом формате</h4>
						<?php include("dognet-docview-details(restr_5)-tab4_6.php"); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-hidden col-sm-12 col-md-12 col-lg-12 space20">
		<div class="panel-group">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="media">
						<div class="media-left media-middle">
							<span class="" style="font-size:1.6em"><span class="glyphicon glyphicon-open-file"></span></span>
						</div>
						<div class="media-body media-middle">
							<h4 class="panel-title">
								<a data-toggle="collapse" href="#tab4_group3">Оригиналы документов</a>
							</h4>
						</div>
					</div>
				</div>
				<div id="tab4_group3" class="panel-collapse collapse in">
					<div class="col-xs-hidden col-sm-12 col-md-12 col-lg-12 space20">
						<div class="space20"></div>
						<h4 class="space10">Скан-копии подписанных и утвержденных документов</h4>
						<?php include("dognet-docview-details(restr_5)-tab4_7.php"); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

