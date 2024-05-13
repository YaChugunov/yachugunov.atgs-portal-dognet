<?php
date_default_timezone_set('Europe/Moscow');

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$__title = 'Договор';
$__subtitle = "Соглашения о партнерстве";
$__subsubtitle = "Работа с соглашениями";

// PORTAL_SYSLOG('99940000', '0000000', null, null, null, null);

?>





<?php
$_QRY_MAILING_ENBL = mysqlQuery("SELECT dognet_mailing_enbl FROM users WHERE id=" . $_SESSION['id']);
$_ROW_MAILING_ENBL = mysqli_fetch_assoc($_QRY_MAILING_ENBL);
if ($_ROW_MAILING_ENBL['dognet_mailing_enbl'] == 0) {
	// include($_SERVER['DOCUMENT_ROOT']."/dognet/_assets/includes/subscribe_handler/dognetNewsletter-subscribe-popup-onload-window.php");
}



/*
// Пробегаемся по всем договорам со статусом ЗАКРЫТ и прописываем дату закрытия в 'datezakr'

	$_QRY = mysqlQuery("SELECT koddoc, kodshab FROM dognet_docbase WHERE kodstatus='245287853877236' OR kodstatus='245600252070703'");
	while($_ROW = mysqli_fetch_assoc($_QRY)) {
		$koddoc = $_ROW['koddoc'];
			if ($_ROW['kodshab']==1 || $_ROW['kodshab']==3) {
				$_QRY2 = mysqlQuery("SELECT chetfdate FROM dognet_kalplanchf WHERE kodkalplan IN (SELECT kodkalplan FROM dognet_dockalplan WHERE koddel<>'99' AND koddoc IN (SELECT koddoc FROM dognet_docbase WHERE koddel<>'99' AND koddoc='".$koddoc."')) ORDER BY chetfdate DESC LIMIT 1");
				$_ROW2 = mysqli_fetch_assoc($_QRY2);
				$chetfdate = $_ROW2['chetfdate'];
			}
			else {
				$_QRY2 = mysqlQuery("SELECT chetfdate FROM dognet_kalplanchf WHERE kodkalplan='".$koddoc."' ORDER BY chetfdate DESC LIMIT 1");
				$_ROW2 = mysqli_fetch_assoc($_QRY2);
				$chetfdate = $_ROW2['chetfdate'];
			}
			if ($chetfdate!="") {
				$_QRY0 = mysqlQuery("UPDATE dognet_docbase SET datezakr='".$chetfdate."' WHERE koddoc='".$koddoc."'");
			}
			else {
				$_QRY0 = mysqlQuery("UPDATE dognet_docbase SET datezakr=NULL WHERE koddoc='".$koddoc."'");
			}
	}
*/




?>







<div class="container">
	<div class="row common-top-block">
		<?php include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/dognet-topblock.php") ?>
	</div>
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12">
			<?php include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/_fixes-updates/dognet_fixes-updates.php"); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12">
			<?php include("dognet-agreeview-current(restr_4)-main.php"); ?>
		</div>
	</div>
</div>

<div class="space100"></div>

<script type="text/javascript">
	subtitle = '<?php echo $__subtitle; ?>';
	subsubtitle = '<?php echo $__subsubtitle; ?>';
	document.getElementById("subtitle").innerHTML = subtitle;
	document.getElementById("dognet-subsubtitle").innerHTML = subsubtitle;
</script>