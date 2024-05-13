<?php
	$__title = 'Договор';
	$__msg = "Редактирование разрешено";
?>
<style>
#section-doclocked > div.row { font-family:'Oswald', sans-serif }
#section-doclocked > div > div > div.media > div.media-body > h1 {
	color:#009a00;
	font-size: 2.2em;
}
#section-doclocked > div > div > div.media > div.media-body > h3 {
/* 	font-family: 'Jura', sans-serif; */
/* 	font-size: 1.0em; */
/* 	font-weight: 200; */
	color:#666;
	line-height: 1.2em;
	font-family:'Oswald', sans-serif;
	margin-bottom: 0.5em;
	font-size: 1.5em;
  font-weight: 200;
  letter-spacing: 0.05em;
}
#section-doclocked > div > div > div.media > div.media-body > h3 > span.username { color:#000; font-weight:500; padding:0 5pxж letter-spacing: 0 }
#section-doclocked > div > div > div.media > div.media-body > div > h4 {
	color:#666;
    font-weight: 300;
	margin-bottom: 0.75em;
}
#section-doclocked > div > div > div.media > div.media-body > div > p {
	color:#111;
	font-family:'Oswald', sans-serif;
    font-weight: 500;
}
#section-doclocked > div > div > div.media > div.media-body > div > p > span > a {
	text-decoration:underline;
}
#section-doclocked > div > div > div.media > div.media-body > div > p > span > a:hover {
	text-decoration:none;
}
#section-doclocked > div.media > div.media-body > ul {
	font-family: 'Oswald', sans-serif;
    font-size: 1.2em;
    font-weight: 300;
    letter-spacing: normal;
	margin-top: 5px;
	margin-left: 10px;
}
.vh-content {
    min-height: calc(100vh - 185px);
}
</style>

<?php
$query1 = mysqlQuery( "SELECT COUNT(id) as cnt FROM service_access WHERE service_name!='allservices'" );
$query2 = mysqlQuery( "SELECT service_name, service_title, access, service_path FROM service_access" );
$row1 = mysqli_fetch_array($query1, MYSQLI_ASSOC);
$_cnt = $row1['cnt'];
?>

<div id="section-doclocked" class="container">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
			<div class="space50"></div>
			<div class="media">
				<div class="media-body text-center">
					<h1 class="text-uppercase space10">Внесение изменений в договор разрешено</h1>

					<div style="background-color:#fafafa; padding:10px">
						<h4 class="text-uppercase">Вам доступны</h4>
						<p>
							<span style='color:#111; margin:0 10px'><a href="dognet-docview.php?docview_type=current">Текущие договора</a></span>
							<span style='color:#111; margin:0 10px'><a href="dognet-docview.php?docview_type=details&uniqueID=<?php echo $_GET['uniqueID']; ?>">Карточка договора</a></span>
							<span style='color:#111; margin:0 10px'><a href="dognet-docview.php?docview_type=edit&uniqueID=<?php echo $_GET['uniqueID']; ?>">Вернуться к редактированию</a></span>
						</p>
					</div>

				</div>
			</div>
			<div class="space50"></div>
		</div>
	</div>
</div>

<script type="text/javascript">
	title = '<?php echo $__title; ?>';
	msg = '<?php echo $__msg; ?>';
	document.getElementById("title").innerHTML = title;
	document.getElementById("subtitle").innerHTML = msg;
</script>
