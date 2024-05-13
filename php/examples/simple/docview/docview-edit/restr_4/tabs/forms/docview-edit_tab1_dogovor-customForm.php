<?php
// ----- ----- ----- ----- -----
// Форма редактирования договора
// :::
?>
<link rel="stylesheet"
      href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-edit/restr_5/tabs/css/docview-edit-tab1_dogovor-customForm.css">
<div id="customForm_tab1_dogovor">
    <div class="doc-editor-tabs" style="width:100%">
        <ul id="" class="nav nav-tabs doc-editor-tabs-menu">
            <li class="active"><a data-toggle="tab" href="#doc-editor-tab1-1" title="">Параметры</a></li>
            <li><a data-toggle="tab" href="#doc-editor-tab1-2" title="">Название и сроки</a></li>
            <li><a data-toggle="tab" href="#doc-editor-tab1-3" title="">Финансовая часть</a></li>
            <li><a data-toggle="tab" href="#doc-editor-tab1-4" title="">Комментарии</a></li>
        </ul>
        <div class="tab-content" style="padding:5px">
            <div id="doc-editor-tab1-1" class="tab-pane fade in active">
                <div class="Section">
                    <div class="Block30">
                        <legend>Календарный план</legend>
                        <fieldset class="field100">
                            <editor-field name="dognet_docbase.kodshab"></editor-field>
                        </fieldset>
                    </div>
                    <div class="Block70">
                        <legend>Обоснование договора</legend>
                        <div class="Block35">
                            <div class="Block100 fieldset-table-row">
                                <div class="fieldset-table-cell" style="padding-bottom:3px">
                                    <fieldset>
                                        <editor-field name="dognet_docbase.usedocruk"></editor-field>
                                    </fieldset>
                                </div>
                                <div class="fieldset-table-cell" style="width:100%">
                                    <div>
                                        <div class="chekbox-inline-text">По указанию руководства</div>
                                    </div>
                                </div>
                            </div>
                            <div class="Block100 fieldset-table-row">
                                <div class="fieldset-table-cell" style="padding-bottom:3px">
                                    <fieldset>
                                        <editor-field name="dognet_docbase.usedoczayv"></editor-field>
                                    </fieldset>
                                </div>
                                <div class="fieldset-table-cell" style="width:100%">
                                    <div>
                                        <div class="chekbox-inline-text">На основе бланка ГИПа</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="Block65">
                            <fieldset class="field100">
                                <editor-field name="dognet_docbase.kodblankwork"></editor-field>
                            </fieldset>
                        </div>
                    </div>
                    <div class="Block70">
                        <legend>Свойства договора</legend>
                        <fieldset class="field40">
                            <editor-field name="dognet_docbase.kodobject"></editor-field>
                        </fieldset>
                        <fieldset class="field30 kodobjectFilter" style="padding-top:30px; padding-right:15px">
                            <input id="kodobject_filter" type="text" placeholder="Поиск в Объектах" />
                        </fieldset>
                        <fieldset class="field30">
                            <editor-field name="dognet_docbase.kodtip"></editor-field>
                        </fieldset>
                        <fieldset class="field40">
                            <editor-field name="dognet_docbase.kodzakaz"></editor-field>
                        </fieldset>
                        <fieldset class="field30 kodzakazFilter" style="padding-top:30px; padding-right:15px">
                            <input id="kodzakaz_filter" type="text" placeholder="Поиск в Заказчиках" />
                        </fieldset>
                        <fieldset class="field30">
                            <editor-field name="dognet_docbase.kodstatus"></editor-field>
                        </fieldset>
                        <fieldset class="field40">
                            <editor-field name="dognet_docbase.kodagent"></editor-field>
                        </fieldset>
                        <fieldset class="field30 kodagentFilter" style="padding-top:30px; padding-right:15px">
                            <input id="kodagent_filter" type="text" placeholder="Поиск в Заказчиках" />
                        </fieldset>
                    </div>
                    <div class="Block30">
                        <legend>Исполнители</legend>
                        <fieldset class="field100">
                            <editor-field name="dognet_docbase.kodispol"></editor-field>
                        </fieldset>
                        <fieldset class="field100">
                            <editor-field name="dognet_docbase.kodispolruk"></editor-field>
                        </fieldset>
                    </div>
                    <div class="Block100">
                        <legend>Специальные отметки</legend>
                        <div class="Block100 fieldset-table-row">
                            <div class="fieldset-table-cell" style="padding-bottom:3px">
                                <fieldset>
                                    <editor-field name="dognet_docbase.usecreatekcp"></editor-field>
                                </fieldset>
                            </div>
                            <div class="fieldset-table-cell" style="width:100%; padding-bottom:5px">
                                <div>
                                    <div class="chekbox-inline-text">Договор подписан на электронной площадке</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="doc-editor-tab1-2" class="tab-pane fade">
                <div class="Section">
                    <div class="Block100">
                        <legend>Наименование и сроки</legend>
                        <fieldset class="field10">
                            <editor-field name="dognet_docbase.docnumber"></editor-field>
                        </fieldset>
                        <fieldset class="field20">
                            <editor-field name="dognet_docbase.docpartnernumberSTR"></editor-field>
                        </fieldset>
                        <fieldset class="field15">
                            <editor-field name="docDateBegin"></editor-field>
                        </fieldset>
                        <fieldset class="field15">
                            <editor-field name="docDateEnd"></editor-field>
                        </fieldset>
                        <fieldset class="field100">
                            <editor-field name="dognet_docbase.docnameshot"></editor-field>
                        </fieldset>
                        <fieldset class="field100">
                            <editor-field name="dognet_docbase.docnamefullm"></editor-field>
                        </fieldset>
                    </div>
                </div>
            </div>
            <div id="doc-editor-tab1-3" class="tab-pane fade">
                <div class="Section">
                    <div class="Block40">
                        <legend>Командировки</legend>
                        <fieldset class="field60">
                            <editor-field name="dognet_docbase.usemisopl"></editor-field>
                        </fieldset>
                        <fieldset class="field40">
                            <editor-field name="dognet_docbase.docsummamis"></editor-field>
                        </fieldset>
                    </div>
                    <div class="Block40">
                        <legend>Финансы</legend>
                        <fieldset class="field40">
                            <editor-field name="dognet_docbase.koddened"></editor-field>
                        </fieldset>
                        <fieldset class="field40">
                            <editor-field name="dognet_docbase.docsumma"></editor-field>
                        </fieldset>
                        <fieldset class="field20">
                            <editor-field name="dognet_docbase.usendssumma"></editor-field>
                        </fieldset>
                    </div>
                    <div class="Block20">
                        <legend>Задолженность</legend>
                        <fieldset class="field100">
                            <editor-field name="dognet_docbase.kodstatuszdl"></editor-field>
                        </fieldset>
                    </div>
                </div>
            </div>
            <div id="doc-editor-tab1-4" class="tab-pane fade">
                <div class="Section">
                    <div class="Block100">
                        <legend>Комментарии</legend>
                        <fieldset class="field100">
                            <editor-field name="dognet_docbase.comments"></editor-field>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>