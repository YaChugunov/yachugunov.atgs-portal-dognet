<?php
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# Какой то блок...
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
?>
<?php
if (checkIsItGIP($_SESSION['id'])==1) {
// ----- ----- ----- ----- -----
// Подключаем стили для таблицы
// :::
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/main/main/restr_3/tabs/css/gipwork-control-stages_oplataexpired.css">
<section>
	<div id="gipwork-control-stages_oplataexpired" class="" style="padding:4px 10px; border:2px #336a86 solid; border-radius:10px">
		<div class="demo-html"></div>
		<table id="gipwork-control-stages_oplataexpired-table" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
			<tbody>
				<tr>
					<td colspan="8" class="text-danger"><span style="color:#666; font-family:'Oswald', sans-serif; font-size:1.2em; font-weight:500; text-transform:uppercase; letter-spacing:0.1em">Временно недоступно :(</span></td>
				</tr>
			</tbody>
		</table>
	</div>
</section>
<?php
}
?>
