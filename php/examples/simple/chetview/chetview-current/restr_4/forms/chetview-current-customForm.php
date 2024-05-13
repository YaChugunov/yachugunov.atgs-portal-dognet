<?php
// ----- ----- ----- ----- -----
// Подключаем стили для формы
// :::
?>
<link rel="stylesheet"
      href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/chetview/chetview-current/restr_4/css/chetview-current-customform.css">
<div id="customForm-chet-main">
    <div class="doc-current-tabs" style="width:100%">
        <ul id="" class="nav nav-tabs doc-current-tabs-menu">
            <li class="active"><a data-toggle="tab" href="#doc-editor-tab-1" title="">Название и сроки</a></li>
            <li><a data-toggle="tab" href="#doc-editor-tab-2" title="">Параметры</a></li>
            <li><a data-toggle="tab" href="#doc-editor-tab-3" title="">Финансовая часть</a></li>
            <li><a data-toggle="tab" href="#doc-editor-tab-4" title="">Комментарии</a></li>
        </ul>
        <div class="tab-content" style="padding:5px">
            <div id="doc-editor-tab-1" class="tab-pane fade in active">
                <div class="Section">
                    <div class="firstAvans" style="display:none">
                        <span id="ajaxFirstAvansOut" class=""></span>
                    </div>
                    <div class="Block60">
                        <legend>Наименование и сроки</legend>
                        <fieldset class="field40 docnumber">
                            <editor-field name="dognet_docbase.docnumber"></editor-field>
                        </fieldset>
                        <fieldset class="field30 docDateBegin">
                            <editor-field name="docDateBegin"></editor-field>
                        </fieldset>
                        <fieldset class="field30 docDateEnd" style="display:block">
                            <editor-field name="docDateEnd"></editor-field>
                        </fieldset>
                        <fieldset class="field30 docDateEndInDays" style="display:none">
                            <editor-field name="docDateEndInDays"></editor-field>
                        </fieldset>
                        <fieldset class="field30 srokindays" style="display:none">
                            <editor-field name="dognet_docbase.srokindays"></editor-field>
                        </fieldset>
                        <div id="block-chkDocDateEndInDays" class="checkbox" style="">
                            <label style="font-size:1.0rem"><input id="chkDocDateEndInDays" type="checkbox"
                                       checked="true" value=""><b>Срок окончания в днях (от 1-го аванса)</b></label>
                        </div>
                    </div>
                    <div class="Block40">
                        <legend>Тип счета</legend>
                        <fieldset class="field100 kodtip">
                            <editor-field name="dognet_docbase.kodtip"></editor-field>
                        </fieldset>
                    </div>
                    <div class="Block100">
                        <legend>Название счета</legend>
                        <fieldset class="field100 docnameshot">
                            <editor-field name="dognet_docbase.docnameshot"></editor-field>
                        </fieldset>
                    </div>
                </div>
            </div>
            <div id="doc-editor-tab-2" class="tab-pane fade">
                <div class="Section">
                    <div class="Block100">
                        <legend>Свойства договора</legend>
                        <div class="Block100">
                            <fieldset class="field60">
                                <editor-field name="dognet_docbase.kodobject"></editor-field>
                            </fieldset>
                            <fieldset class="field40 kodobjectFilter"
                                      style="padding-top:30px; padding-right:15px; padding-left:15px">
                                <input id="kodobject_filter" type="text" placeholder="Поиск в Объектах" />
                            </fieldset>
                        </div>
                        <div class="Block100">
                            <fieldset class="field60">
                                <editor-field name="dognet_docbase.kodzakaz"></editor-field>
                            </fieldset>
                            <fieldset class="field40 kodzakazFilter"
                                      style="padding-top:30px; padding-right:15px; padding-left:15px">
                                <input id="kodzakaz_filter" type="text" placeholder="Поиск в Заказчиках" />
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
            <div id="doc-editor-tab-3" class="tab-pane fade">
                <div class="Section">
                    <div class="Block100">
                        <legend>Финансы</legend>
                        <fieldset class="field40">
                            <editor-field name="dognet_docbase.docsumma"></editor-field>
                        </fieldset>
                        <fieldset class="field40">
                            <editor-field name="dognet_docbase.koddened"></editor-field>
                        </fieldset>
                        <fieldset class="field20">
                            <editor-field name="dognet_docbase.usendssumma"></editor-field>
                        </fieldset>
                    </div>
                </div>
            </div>
            <div id="doc-editor-tab-4" class="tab-pane fade">
                <div class="Section">
                    <div class="Block100">
                        <legend>Комментарий</legend>
                        <fieldset class="field100">
                            <editor-field name="dognet_docbase.comments"></editor-field>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>