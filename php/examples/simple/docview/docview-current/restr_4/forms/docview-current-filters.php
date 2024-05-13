<?php
// ----- ----- ----- ----- -----
// Подключаем форму поиска
// :::
?>
<link rel="stylesheet"
    href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-current/restr_4/css/docview-current-filters.css">
<div id="docsearch-filters-block" class="panel-group">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" href="#docsearch-filters">Фильтры для поиска договора</a>
            </h4>
        </div>
        <div id="docsearch-filters" class="panel-collapse collapse">

            <div id="docview-current-filters" class="panel-body">
                <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                    <div class="form-group space10" style="width:100%">
                        <label for="docNumberSearch_text"><b>Номер договора :</b></label>
                        <input type="text" id="docNumberSearch_text" class="form-control" placeholder="Все номера"
                            name="docNumberSearch_text"
                            value="<?php if (isset($_SESSION['docviewCurrent']['docNumberSearch_text'])) {
                                                                                                                                                            echo ($_SESSION['docviewCurrent']['docNumberSearch_text'] != "") ? $_SESSION['docviewCurrent']['docNumberSearch_text'] : "";
                                                                                                                                                        } ?>">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                    <div class="form-group space10" style="width:100%">
                        <label for="docPartnerNumberSearch_text"><b>Номер контрагента :</b></label>
                        <input type="text" id="docPartnerNumberSearch_text" class="form-control"
                            placeholder="Все номера" name="docPartnerNumberSearch_text"
                            value="<?php if (isset($_SESSION['docviewCurrent']['docPartnerNumberSearch_text'])) {
                                                                                                                                                                        echo ($_SESSION['docviewCurrent']['docPartnerNumberSearch_text'] != "") ? $_SESSION['docviewCurrent']['docPartnerNumberSearch_text'] : "";
                                                                                                                                                                    } ?>">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                    <div class="form-group space10" style="width:100%">
                        <label for="docYearSearch_text"><b>Год начала :</b></label>
                        <input type="text" id="docYearSearch_text" class="form-control" placeholder="Все года"
                            name="docYearSearch_text"
                            value="<?php if (isset($_SESSION['docviewCurrent']['docYearSearch_text'])) {
                                                                                                                                                    echo ($_SESSION['docviewCurrent']['docYearSearch_text'] != "") ? $_SESSION['docviewCurrent']['docYearSearch_text'] : "";
                                                                                                                                                } ?>">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                    <div class="form-group space10" style="width:100%">
                        <label for="docStatusSearch_text"><b>Статус договора :</b></label>
                        <select name="docStatusSearch_text" id="docStatusSearch_text" class="form-control">
                            <option value="">Все статусы договоров</option>
                            <?php
                            $_QRY1 = mysqlQuery(" SELECT statusnameshot FROM dognet_spstatus WHERE statusnameshot<>'' ");
                            while ($_ROW1 = mysqli_fetch_assoc($_QRY1)) {
                            ?>
                            <option value='<?php echo $_ROW1["statusnameshot"]; ?>' <?php if (isset($_SESSION['docviewCurrent']['docStatusSearch_text'])) {
                                                                                            echo ($_SESSION['docviewCurrent']['docStatusSearch_text'] == $_ROW1["statusnameshot"]) ? "selected" : "";
                                                                                        } ?>>
                                <?php echo $_ROW1["statusnameshot"]; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                    <div class="form-group space10" style="width:100%">
                        <label for="docTypeSearch_text"><b>Тип договора :</b></label>
                        <select name="docTypeSearch_text" id="docTypeSearch_text" class="form-control">
                            <option value="">Все типы договоров</option>
                            <?php
                            $_QRY2 = mysqlQuery(" SELECT nametip FROM dognet_sptipdog WHERE nametip<>'' AND koddel<>99 ");
                            while ($_ROW2 = mysqli_fetch_assoc($_QRY2)) {
                            ?>
                            <option value='<?php echo $_ROW2["nametip"]; ?>' <?php if (isset($_SESSION['docviewCurrent']['docTypeSearch_text'])) {
                                                                                        echo ($_SESSION['docviewCurrent']['docTypeSearch_text'] == $_ROW2["nametip"]) ? "selected" : "";
                                                                                    } ?>>
                                <?php echo $_ROW2["nametip"]; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <?php // ----- ----- ----- ----- -----
                ?>
                <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                    <div class="input-group space10" style="width:100%">
                        <label for="docObjectSearch_text"><b>Заказчик/объект :</b></label>
                        <input type="text" id="docObjectSearch_text" class="form-control" placeholder="Все объекты"
                            name="docObjectSearch_text"
                            value="<?php if (isset($_SESSION['docviewCurrent']['docObjectSearch_text'])) {
                                                                                                                                                            echo ($_SESSION['docviewCurrent']['docObjectSearch_text'] != "") ? $_SESSION['docviewCurrent']['docObjectSearch_text'] : "";
                                                                                                                                                        } ?>">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                    <div class="input-group space10" style="width:100%">
                        <label for="docZakazSearch_text"><b>Заказчик/плательщик :</b></label>
                        <input type="text" id="docZakazSearch_text" class="form-control" placeholder="Все плательщики"
                            name="docZakazSearch_text"
                            value="<?php if (isset($_SESSION['docviewCurrent']['docZakazSearch_text'])) {
                                                                                                                                                                echo ($_SESSION['docviewCurrent']['docZakazSearch_text'] != "") ? $_SESSION['docviewCurrent']['docZakazSearch_text'] : "";
                                                                                                                                                            } ?>">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-6 col-lg-6">
                    <div class="input-group space10" style="width:100%">
                        <label for="docNameSearch_text"><b>Текст из названия договора :</b></label>
                        <input type="text" id="docNameSearch_text" class="form-control"
                            placeholder="Введите текст для поиска в названии" name="docNameSearch_text"
                            value="<?php if (isset($_SESSION['docviewCurrent']['docNameSearch_text'])) {
                                                                                                                                                                                echo ($_SESSION['docviewCurrent']['docNameSearch_text'] != "") ? $_SESSION['docviewCurrent']['docNameSearch_text'] : "";
                                                                                                                                                                            } ?>">
                    </div>
                </div>
                <?php // ----- ----- ----- ----- -----
                ?>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                    <div class="input-group space10" style="width:100%">
                        <label for="docIspolSearch_text"><b>Исполнитель :</b></label>
                        <select name="docIspolSearch_text" id="docIspolSearch_text" class="form-control">
                            <option value="">Все исполнители</option>
                            <?php
                            $_QRY3 = mysqlQuery(" SELECT ispolnamefull FROM dognet_spispol WHERE ispolnamefull<>'' AND koddel<>99 ");
                            while ($_ROW3 = mysqli_fetch_assoc($_QRY3)) {
                            ?>
                            <option value='<?php echo $_ROW3["ispolnamefull"]; ?>' <?php if (isset($_SESSION['docviewCurrent']['docIspolSearch_text'])) {
                                                                                            echo ($_SESSION['docviewCurrent']['docIspolSearch_text'] == $_ROW3["ispolnamefull"]) ? "selected" : "";
                                                                                        } ?>>
                                <?php echo $_ROW3["ispolnamefull"]; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <?php // ----- ----- ----- ----- -----
                ?>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                    <div class="input-group space10" style="width:100%">
                        <label for="docShablonSearch_text"><b>Календарный план :</b></label>
                        <select name="docShablonSearch_text" id="docShablonSearch_text" class="form-control">
                            <option value="">Все</option>
                            <option value="1">Только с календарным планом</option>
                            <option value="2">Только без календарного плана</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-5 col-md-5 col-lg-4">
                    <div class="input-group space10" style="width:100%">
                        <label for="docCreateKcpSearch_text"><b>Электронная площадка :</b></label>
                        <select name="docCreateKcpSearch_text" id="docCreateKcpSearch_text" class="form-control">
                            <option value="">Все</option>
                            <option value="1">Только подписанные на электронной площадке</option>
                            <option value="0">Исключить подписанные на электронной площадке</option>
                        </select>
                    </div>
                </div>
                <?php // ----- ----- ----- ----- -----
                ?>
            </div>
            <div class="panel-footer">
                <div class="text-right">
                    <div class="checkbox" style="float:left; text-align:left">
                        <label><input type="checkbox" id="checkbox_saveFiltersPanelState" value="1"><b>Сохранить
                                состояние фильтров</b>&nbsp;&nbsp;&nbsp;<span class="text-danger">( сброшены фильтры
                                могут быть либо вручную либо при новом входе в систему )</span></label>

                    </div>
                    <div class="input-group-btn">
                        <button id="columnSearch_btnApply" class="btn btn-default" type="button">Применить
                            фильтры</button>
                        <button id="columnSearch_btnClear" class="btn btn-default" type="button"><i
                                class="glyphicon glyphicon-remove"></i></button>
                    </div>
                </div>
            </div>
            <?php // ----- ----- ----- ----- -----
            ?>
        </div>
    </div>
</div>