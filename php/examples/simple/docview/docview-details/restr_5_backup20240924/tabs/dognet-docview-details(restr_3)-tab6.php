<?php
$_QRY_DOC = mysqlQuery("SELECT * FROM dognet_docsubpodr WHERE koddel <> '99' AND koddoc IN (SELECT koddoc FROM dognet_docbase WHERE koddoc = " . $__uniqueID . " AND koddel<>'99')");
$_QRY_KAL = mysqlQuery("SELECT * FROM dognet_docsubpodr WHERE koddel <> '99' AND koddoc IN (SELECT kodkalplan FROM dognet_dockalplan WHERE koddoc = " . $__uniqueID . " AND koddel<>'99')");
if (mysqli_num_rows($_QRY_DOC) > 0 or mysqli_num_rows($_QRY_KAL) > 0) {
	include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/docview/docview-details/restr_3/tabs/dognet-docview-details(restr_3)-tab6_sub_main.php");
?>
<div id="doc-details-tabs" class="doc-details-tabs" style="width:100%">
  <ul id="doc-details-tabs-menu" class="nav nav-tabs doc-details-tabs-menu">
    <li class="active"><a data-toggle="tab" href="#doc-details-tab6-1" title="">Выполнение и оплата</a></li>
  </ul>
  <div class="tab-content" style="padding:5px; width:100%">
    <div id="doc-details-tab6-1" class="tab-pane fade in active">
      <?php include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/docview/docview-details/restr_3/tabs/dognet-docview-details(restr_3)-tab6_sub_child_all.php"); ?>
    </div>
    <div id="subpodr-block-legend" class="col-xs-12 col-sm-12 col-md-12 col-lg-12"
      style="margin-top:25px; border-top:1px solid #00a6dc; padding:20px">

      <div style="float: left">
        <p><span class="label label-icon"><span class="lbl lbl-light">Без зачета</span></span><span
            style="font-size:0.8em; font-family: 'HelliosCond', sans-serif; font-weight: 400; color:#8d8d8d">Аванс
            создан,
            но не определена форма его зачета</span></p>
      </div>
      <div style="float: left">
        <p><span class="label label-icon"><span class="lbl lbl-red-o">Сплит</span></span><span
            style="font-size:0.8em; font-family: 'HelliosCond', sans-serif; font-weight: 400; color:#8d8d8d">Тип
            аванса подразумевает разбитие (сплиты), но они пока не создавались</span></p>
      </div>
      <div style="float: left">
        <p><span class="label label-icon"><span class="lbl lbl-red">Сплит</span></span><span
            style="font-size:0.8em; font-family: 'HelliosCond', sans-serif; font-weight: 400; color:#8d8d8d">Из аванса
            выделены части (сплиты)</span></p>
      </div>
      <div style="float: left">
        <p><span class="label label-icon"><span class="lbl lbl-green">Зачет</span></span><span
            style="font-size:0.8em; font-family: 'HelliosCond', sans-serif; font-weight: 400; color:#8d8d8d">Аванс
            зачтен
            полностью</span></p>
      </div>
      <div style="float: left">
        <p><span class="label label-icon"><span style="color:#0085c7"
              class="glyphicon glyphicon-link"></span></span><span
            style="font-size:0.8em; font-family: 'HelliosCond', sans-serif; font-weight: 400; color:#8d8d8d">Оплата,
            аванс
            целиком
            или часть аванаса (сплит) зачтены в счет-фактуру, который выбран в соответствующей таблице</span></p>
      </div>

    </div>
  </div>
</div>
<?php
} else {
?>
<section>
  <div class="" style="padding-left:5px; padding-right:5px">
    <table id="docview-details-tab6-sub-message-table" class="table table-condensed" cellspacing="0" width="100%">
      <tbody>
        <tr>
          <td class="docview-details-td-message text-center text-danger" style="border-top:none">Договоров субподряда не
            заключалось</td>
        </tr>
      </tbody>
    </table>
  </div>
</section>
<?php
}
?>