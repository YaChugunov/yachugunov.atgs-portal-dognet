
<?php
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
$__uniqueID = $_SESSION['uniqueID'];
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

$qry_docbase = mysqlQuery("SELECT docnumber, numberchet, docnameshot, docnamefullm, kodstatus FROM dognet_docbase WHERE koddoc=".$__uniqueID);
$row_docbase = mysqli_fetch_assoc($qry_docbase);
$_var_docnumber = $row_docbase['docnumber'];
$_var_numberchet = $row_docbase['numberchet'];
$_var_docnameshot = $row_docbase['docnameshot'];
$_var_docnamefullm = $row_docbase['docnamefullm'];
?>


<style>
#chetview-details-main-docnumber {
	border:2px #333 solid;
	border-radius:6px;
	padding:5px 10px;
}
#chetview-details-main-info {
	padding-left:20px;
}
#chetview-details-main-docnumber h3 {
	font-size: 3.0em;
	font-family:'Oswald', sans-serif;
	font-weight:500;
	white-space:nowrap;
	letter-spacing:normal;
}
#chetview-details-main-info {  }
#chetview-details-main-info span {
	font-size:2.0em;
	font-family:'Oswald', sans-serif;
	font-weight:300;
	line-height:1.2em;
	letter-spacing:normal;
}
</style>

<section id="chetview-details-main">
	<div class="media">
		<div id="chetview-details-main-docnumber" class="media-left media-middle">
			<h3>Счет&nbsp;№&nbsp;<?php echo $_var_numberchet; ?></h3>
		</div>
		<div id="chetview-details-main-info" class="media-body media-middle">
			<span><?php echo $_var_docnameshot; ?></span>
		</div>
	</div>
</section>
<div class="space20"></div>
