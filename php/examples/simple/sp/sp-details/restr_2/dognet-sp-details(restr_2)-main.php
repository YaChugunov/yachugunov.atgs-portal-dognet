
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/date-de.js"></script>
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/moment-with-locales.js"></script>

<?php
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
$__uniqueID = $_SESSION['uniqueID'];
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 

$qry_docbase = mysqlQuery("SELECT docnumber, docnameshot, docnamefullm, kodstatus FROM dognet_docbase WHERE koddoc=".$__uniqueID);
$row_docbase = mysqli_fetch_assoc($qry_docbase);
$_var_docnumber = $row_docbase['docnumber'];
$_var_docnameshot = $row_docbase['docnameshot'];
$_var_docnamefullm = $row_docbase['docnamefullm'];
?>


<style>
#docview-details-main-docnumber { 
	border:2px #333 solid;
	border-radius:6px;
	padding:5px 10px; 
}
#docview-details-main-info { 
	padding-left:20px;
}
#docview-details-main-docnumber h3 { 
	font-size: 3.0em;
	font-family:'Oswald', sans-serif;
	font-weight:500;
	white-space:nowrap;
	letter-spacing:normal;
}
#docview-details-main-info {  }
#docview-details-main-info span { 
	font-size:2.0em;
	font-family:'Oswald', sans-serif;
	font-weight:300;
	line-height:1.2em;
	letter-spacing:normal;
}
</style>

<div class="space50"></div>
<section id="docview-details-main">
	<div class="media">
		<div id="docview-details-main-docnumber" class="media-left media-middle">
			<h3>3-4/<?php echo $_var_docnumber; ?></h3>
		</div>
		<div id="docview-details-main-info" class="media-body media-middle">
			<span><?php echo $_var_docnamefullm; ?></span>
		</div>
	</div>
</section>
<div class="space20"></div>
