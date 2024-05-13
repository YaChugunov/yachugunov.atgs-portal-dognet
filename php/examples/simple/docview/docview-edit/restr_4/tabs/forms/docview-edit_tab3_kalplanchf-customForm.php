<?php
// ----- ----- ----- ----- -----
// Форма редактирования счета-фактуры
// :::
?>
<link rel="stylesheet"
    href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-edit/restr_4/tabs/css/docview-edit-tab3_kalplanchf-customForm.css">
<div id="customForm_tab3_kalplanchf">

    <div class="doc-editor-tabs" style="width:100%">
        <ul id="" class="nav nav-tabs doc-editor-tabs-menu">
            <li class="active"><a data-toggle="tab" href="#doc-editor-tab3-kalplanchf-1" title="">Параметры</a></li>
            <li><a data-toggle="tab" href="#doc-editor-tab3-kalplanchf-2" title="">Информация</a></li>
        </ul>
        <div class="tab-content" style="padding:5px">
            <div id="doc-editor-tab3-kalplanchf-1" class="tab-pane fade in active">
                <div class="Section">
                    <div class="Block100">
                        <legend>Описание</legend>
                        <fieldset class="field30">
                            <editor-field name="dognet_kalplanchf.chetfnumber"></editor-field>
                        </fieldset>
                        <fieldset class="field70">
                            <editor-field name="dognet_kalplanchf.comment"></editor-field>
                        </fieldset>
                    </div>
                    <div class="Block100">
                        <legend>Параметры</legend>
                        <fieldset class="field50">
                            <editor-field name="dognet_kalplanchf.kodkalplan"></editor-field>
                        </fieldset>
                        <fieldset class="field20">
                            <editor-field name="dognet_kalplanchf.chetfdate"></editor-field>
                        </fieldset>
                        <fieldset class="field30">
                            <editor-field name="dognet_kalplanchf.chetfsumma"></editor-field>
                        </fieldset>
                    </div>
                    <div id="check-useavans" class="Block100" style="">
                        <div class="fieldset-table-row" style="">
                            <div class="fieldset-table-cell" style="padding-bottom:3px">
                                <fieldset class="field100">
                                    <editor-field name="useavans"></editor-field>
                                </fieldset>
                            </div>
                            <div class="fieldset-table-cell" style="width:100%">
                                <div>
                                    <div class="chekbox-inline-text">Зачесть аванс сразу после добавления счета-фактуры
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="div-useavans" class="Block100" style="display:none">
                        <div class="Block55">
                            <fieldset class="field100">
                                <editor-field name="usekodavans"></editor-field>
                            </fieldset>
                        </div>
                        <div class="Block25" id="div-usesumzachet" style="display:none">
                            <fieldset class="field100">
                                <editor-field name="usesumzachet"></editor-field>
                            </fieldset>
                        </div>
                        <div class="Block20 fieldset-table-row" id="fieldset-table-row_useallostatok"
                            style="display:none; padding-top:25px">
                            <div class="fieldset-table-cell" style="padding-bottom:3px">
                                <fieldset class="field100">
                                    <editor-field name="useallostatok"></editor-field>
                                </fieldset>
                            </div>
                            <div class="fieldset-table-cell" style="width:100%">
                                <div>
                                    <div class="chekbox-inline-text">Весь остаток</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="doc-editor-tab3-kalplanchf-2" class="tab-pane fade">
                <div class="Section">
                    <div class="Block100">
                        <legend>Информация</legend>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="OutputResult"></div>

</div>