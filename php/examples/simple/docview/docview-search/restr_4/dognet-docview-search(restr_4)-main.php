<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/moment-with-locales.js"></script>
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/filterByText.js"></script>

<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-search/restr_4/css/docview-search-main.css">
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/docview-search/restr_4/css/docview-search-filters.css">
<?php
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
?>
<section>
	<div class="space30"></div>
	<div id="docsearch-filters-block" class="space50">
		<form class="form-horizontal" method="POST" action="dognet-docview.php?docview_type=search">
			<div id="docsearch-filters" class="">
				<div id="docview-search-filters" class="row">
					<?php // ----- ----- ----- ----- ----- 
					?>
					<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 space20">
						<div class="form-group space10" style="width:100%">
							<label for="YearSelector1"><b>Год :</b></label>
							<select id="YearSelector1" class="form-control">
								<?php
								$year0 = 2003;
								$_QRY_YMAX = mysqlQuery("SELECT MAX(yearnachdoc) as yearmax FROM dognet_docbase WHERE koddel<>'99'");
								$_ROW_YMAX = mysqli_fetch_assoc($_QRY_YMAX);
								$_yearmax = $_ROW_YMAX['yearmax'];
								for ($i = 0; $i <= ($_yearmax - $year0); $i++) {
									$year = $year0 + $i;
									$_arrYear1[$i] = $year;
									echo "<option value='{$year}'>{$year}</option>"
								?>

								<?php
								}
								?>
							</select>
						</div>
						<div class="form-group space10" style="width:100%">
							<select name="YearSelector[]" multiple="multiple" id="YearSelector" class="form-control space10">
								<?php
								// Сохраняем выбранные элементы и помещаем их в список
								if (isset($_POST['YearSelector']) && !empty($_POST['YearSelector'])) {
									for ($i = 0; $i < count($_arrYear1); $i++) {
										$selected = (in_array($_arrYear1[$i], $_POST['YearSelector']) ? 'selected="selected"' : '');
										if ($selected != "") {
											echo "<option value='$_arrYear1[$i]' $selected>$_arrYear1[$i]</option>";
										}
									}
								}
								?>
							</select>
							<div class="btn-group">
								<button class="btn btn-default" type="button" id="btn_addToList_YearSelector"><span class='glyphicon glyphicon-plus'></span></button>
								<button class="btn btn-default" type="button" id="btn_removeFromList_YearSelector"><span class='glyphicon glyphicon-minus'></span></button>
								<button class="btn btn-default" type="button" id="btn_clearList_YearSelector"><span class='glyphicon glyphicon-ban-circle'></span></button>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-5 col-md-3 col-lg-3 space20">
						<div class="form-group space10" style="width:100%">
							<label for="ZakazSelector1"><b>Заказчики :</b></label>
							<select id="ZakazSelector1" class="form-control">
								<?php
								$_QRY_ZAK = mysqlQuery(" SELECT kodcontragent, nameshort FROM sp_contragents WHERE nameshort<>'' AND koddel<>'99' ORDER BY nameshort ASC");
								while ($_ROW_ZAK = mysqli_fetch_assoc($_QRY_ZAK)) {
									$_arrZak1[] = $_ROW_ZAK['kodcontragent'];
									$_arrZak2[] = $_ROW_ZAK['nameshort'];
								?>
									<option value='<?php echo $_ROW_ZAK["kodcontragent"]; ?>'><?php echo $_ROW_ZAK["nameshort"]; ?></option>
								<?php
								}
								?>
							</select>
						</div>
						<div class="form-group space10" style="width:100%">
							<select name="ZakazSelector[]" multiple="multiple" id="ZakazSelector" class="form-control space10">
								<?php
								// Сохраняем выбранные элементы и помещаем их в список
								if (isset($_POST['ZakazSelector']) && !empty($_POST['ZakazSelector'])) {
									for ($i = 0; $i < count($_arrZak1); $i++) {
										$selected = (in_array($_arrZak1[$i], $_POST['ZakazSelector']) ? 'selected="selected"' : '');
										if ($selected != "") {
											echo "<option value='$_arrZak1[$i]' $selected>$_arrZak2[$i]</option>";
										}
									}
								}
								?>
							</select>
							<div class="btn-group">
								<button class="btn btn-default" type="button" id="btn_addToList_ZakSelector"><span class='glyphicon glyphicon-plus'></span></button>
								<button class="btn btn-default" type="button" id="btn_removeFromList_ZakSelector"><span class='glyphicon glyphicon-minus'></span></button>
								<button class="btn btn-default" type="button" id="btn_clearList_ZakSelector"><span class='glyphicon glyphicon-ban-circle'></span></button>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-5 col-md-3 col-lg-3 space20">
						<div class="form-group space10" style="width:100%">
							<label for="ObjectSelector1"><b>Объекты :</b></label>
							<select id="ObjectSelector1" class="form-control">
								<?php
								$_QRY_OBJ = mysqlQuery(" SELECT kodobject, nameobjectshot FROM sp_objects WHERE nameobjectshot<>'' AND koddel<>'99' ORDER BY nameobjectshot ASC");
								while ($_ROW_OBJ = mysqli_fetch_assoc($_QRY_OBJ)) {
									$_arrObj1[] = $_ROW_OBJ['kodobject'];
									$_arrObj2[] = $_ROW_OBJ['nameobjectshot'];
								?>
									<option value='<?php echo $_ROW_OBJ["kodobject"]; ?>'><?php echo $_ROW_OBJ["nameobjectshot"]; ?></option>
								<?php
								}
								?>
							</select>
						</div>
						<div class="form-group space10" style="width:100%">
							<select name="ObjectSelector[]" multiple="multiple" id="ObjectSelector" class="form-control space10">
								<?php
								// Сохраняем выбранные элементы и помещаем их в список
								if (isset($_POST['ObjectSelector']) && !empty($_POST['ObjectSelector'])) {
									for ($i = 0; $i < count($_arrObj1); $i++) {
										$selected = (in_array($_arrObj1[$i], $_POST['ObjectSelector']) ? 'selected="selected"' : '');
										if ($selected != "") {
											echo "<option value='$_arrObj1[$i]' $selected>$_arrObj2[$i]</option>";
										}
									}
								}
								?>
							</select>
							<div class="btn-group">
								<button class="btn btn-default" type="button" id="btn_addToList_ObjSelector"><span class='glyphicon glyphicon-plus'></span></button>
								<button class="btn btn-default" type="button" id="btn_removeFromList_ObjSelector"><span class='glyphicon glyphicon-minus'></span></button>
								<button class="btn btn-default" type="button" id="btn_clearList_ObjSelector"><span class='glyphicon glyphicon-ban-circle'></span></button>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-2 col-lg-2 space20">
						<div class="form-group space10" style="width:100%">
							<label for="TypeSelector1"><b>Тип договора :</b></label>
							<select id="TypeSelector1" class="form-control">
								<?php
								$_QRY_TIP = mysqlQuery(" SELECT kodtip, nametip FROM dognet_sptipdog WHERE nametip<>'' AND koddel<>99 ORDER BY nametip ASC");
								while ($_ROW_TIP = mysqli_fetch_assoc($_QRY_TIP)) {
									$_arrTip1[] = $_ROW_TIP['kodtip'];
									$_arrTip2[] = $_ROW_TIP['nametip'];
								?>
									<option value='<?php echo $_ROW_TIP["kodtip"]; ?>'><?php echo $_ROW_TIP["nametip"]; ?></option>
								<?php
								}
								?>
							</select>
						</div>
						<div class="form-group space10" style="width:100%">
							<select name="TypeSelector[]" multiple="multiple" id="TypeSelector" class="form-control space10">
								<?php
								// Сохраняем выбранные элементы и помещаем их в список
								if (isset($_POST['TypeSelector']) && !empty($_POST['TypeSelector'])) {
									for ($i = 0; $i < count($_arrTip1); $i++) {
										$selected = (in_array($_arrTip1[$i], $_POST['TypeSelector']) ? 'selected="selected"' : '');
										if ($selected != "") {
											echo "<option value='$_arrTip1[$i]' $selected>$_arrTip2[$i]</option>";
										}
									}
								}
								?>
							</select>
							<div class="btn-group">
								<button class="btn btn-default" type="button" id="btn_addToList_TypeSelector"><span class='glyphicon glyphicon-plus'></span></button>
								<button class="btn btn-default" type="button" id="btn_removeFromList_TypeSelector"><span class='glyphicon glyphicon-minus'></span></button>
								<button class="btn btn-default" type="button" id="btn_clearList_TypeSelector"><span class='glyphicon glyphicon-ban-circle'></span></button>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-2 col-lg-2 space20">
						<div class="form-group space10" style="width:100%">
							<label for="StatusSelector1"><b>Статус договора :</b></label>
							<select id="StatusSelector1" class="form-control">
								<?php
								$_QRY_STS = mysqlQuery(" SELECT kodstatus, statusnameshot FROM dognet_spstatus WHERE statusnameshot<>'' ORDER BY statusnameshot ASC");
								while ($_ROW_STS = mysqli_fetch_assoc($_QRY_STS)) {
									$_arrStatus1[] = $_ROW_STS['kodstatus'];
									$_arrStatus2[] = $_ROW_STS['statusnameshot'];
								?>
									<option value='<?php echo $_ROW_STS["kodstatus"]; ?>'><?php echo $_ROW_STS["statusnameshot"]; ?></option>
								<?php
								}
								?>
							</select>
						</div>
						<div class="form-group space10" style="width:100%">
							<select name="StatusSelector[]" multiple="multiple" id="StatusSelector" class="form-control space10">
								<?php
								// Сохраняем выбранные элементы и помещаем их в список
								if (isset($_POST['StatusSelector']) && !empty($_POST['StatusSelector'])) {
									for ($i = 0; $i < count($_arrStatus1); $i++) {
										$selected = (in_array($_arrStatus1[$i], $_POST['StatusSelector']) ? 'selected="selected"' : '');
										if ($selected != "") {
											echo "<option value='$_arrStatus1[$i]' $selected>$_arrStatus2[$i]</option>";
										}
									}
								}
								?>
							</select>
							<div class="btn-group">
								<button class="btn btn-default" type="button" id="btn_addToList_StatusSelector"><span class='glyphicon glyphicon-plus'></span></button>
								<button class="btn btn-default" type="button" id="btn_removeFromList_StatusSelector"><span class='glyphicon glyphicon-minus'></span></button>
								<button class="btn btn-default" type="button" id="btn_clearList_StatusSelector"><span class='glyphicon glyphicon-ban-circle'></span></button>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 space20">
						<div class="form-group space10" style="width:100%">
							<label for="IspSelector1"><b>Исполнитель (ГИП) :</b></label>
							<select id="IspSelector1" class="form-control">
								<?php
								$_QRY_ISP = mysqlQuery("SELECT kodispol, ispolnameshot FROM dognet_spispol WHERE ispolnameshot<>'' AND kodusegip='1' AND koddel<>'99' ORDER BY ispolnameshot ASC");
								while ($_ROW_ISP = mysqli_fetch_assoc($_QRY_ISP)) {
									$_arrIsp1[] = $_ROW_ISP['kodispol'];
									$_arrIsp2[] = $_ROW_ISP['ispolnameshot'];
								?>
									<option value='<?php echo $_ROW_ISP["kodispol"]; ?>'><?php echo $_ROW_ISP["ispolnameshot"]; ?></option>
								<?php
								}
								?>
							</select>
						</div>
						<div class="form-group space10" style="width:100%">
							<select name="IspSelector[]" multiple="multiple" id="IspSelector" class="form-control space10">
								<?php
								// Сохраняем выбранные элементы и помещаем их в список
								if (isset($_POST['IspSelector']) && !empty($_POST['IspSelector'])) {
									for ($i = 0; $i < count($_arrIsp1); $i++) {
										$selected = (in_array($_arrIsp1[$i], $_POST['IspSelector']) ? 'selected="selected"' : '');
										if ($selected != "") {
											echo "<option value='$_arrIsp1[$i]' $selected>$_arrIsp2[$i]</option>";
										}
									}
								}
								?>
							</select>
							<div class="btn-group">
								<button class="btn btn-default" type="button" id="btn_addToList_IspSelector"><span class='glyphicon glyphicon-plus'></span></button>
								<button class="btn btn-default" type="button" id="btn_removeFromList_IspSelector"><span class='glyphicon glyphicon-minus'></span></button>
								<button class="btn btn-default" type="button" id="btn_clearList_IspSelector"><span class='glyphicon glyphicon-ban-circle'></span></button>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 space20">
						<div class="form-group space10" style="width:100%">
							<label for="IsprukSelector1"><b>Исполнитель (рук) :</b></label>
							<select id="IsprukSelector1" class="form-control">
								<?php
								$_QRY_ISPRUK = mysqlQuery("SELECT kodispolruk, ispolrukname FROM dognet_spispolruk WHERE ispolrukname<>'' AND kodrukgip='1' AND koddel<>'99' ORDER BY ispolrukname ASC");
								while ($_ROW_ISPRUK = mysqli_fetch_assoc($_QRY_ISPRUK)) {
									$_arrIspruk1[] = $_ROW_ISPRUK['kodispolruk'];
									$_arrIspruk2[] = $_ROW_ISPRUK['ispolrukname'];
								?>
									<option value='<?php echo $_ROW_ISPRUK["kodispolruk"]; ?>'><?php echo $_ROW_ISPRUK["ispolrukname"]; ?></option>
								<?php
								}
								?>
							</select>
						</div>
						<div class="form-group space10" style="width:100%">
							<select name="IsprukSelector[]" multiple="multiple" id="IsprukSelector" class="form-control space10">
								<?php
								// Сохраняем выбранные элементы и помещаем их в список
								if (isset($_POST['IsprukSelector']) && !empty($_POST['IsprukSelector'])) {
									for ($i = 0; $i < count($_arrIspruk1); $i++) {
										$selected = (in_array($_arrIspruk1[$i], $_POST['IsprukSelector']) ? 'selected="selected"' : '');
										if ($selected != "") {
											echo "<option value='$_arrIspruk1[$i]' $selected>$_arrIspruk2[$i]</option>";
										}
									}
								}
								?>
							</select>
							<div class="btn-group">
								<button class="btn btn-default" type="button" id="btn_addToList_IsprukSelector"><span class='glyphicon glyphicon-plus'></span></button>
								<button class="btn btn-default" type="button" id="btn_removeFromList_IsprukSelector"><span class='glyphicon glyphicon-minus'></span></button>
								<button class="btn btn-default" type="button" id="btn_clearList_IsprukSelector"><span class='glyphicon glyphicon-ban-circle'></span></button>
							</div>
						</div>
					</div>
					<?php // ----- ----- ----- ----- ----- 
					?>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
						<div class="input-group-btn">
							<button id="columnSearch_btnApply" class="btn btn-default" type="submit">Применить фильтры</button>
							<button id="columnSearch_btnClear" class="btn btn-default" type="button"><i class="glyphicon glyphicon-ban-circle"></i></button>
						</div>
					</div>
					<?php // ----- ----- ----- ----- ----- 
					?>
				</div>
			</div>
		</form>
		<?php
		$_cntYearSelector = "";
		if (!empty($_POST['YearSelector']) && isset($_POST['YearSelector'])) {
			$_arrYearSelector = $_POST['YearSelector'];
			$_cntYearSelector = count($_arrYearSelector);
		}
		$_cntZakazSelector = "";
		if (!empty($_POST['ZakazSelector']) && isset($_POST['ZakazSelector'])) {
			$_arrZakazSelector = $_POST['ZakazSelector'];
			$_cntZakazSelector = count($_arrZakazSelector);
		}
		$_cntObjectSelector = "";
		if (!empty($_POST['ObjectSelector']) && isset($_POST['ObjectSelector'])) {
			$_arrObjectSelector = $_POST['ObjectSelector'];
			$_cntObjectSelector = count($_arrObjectSelector);
		}
		$_cntTypeSelector = "";
		if (!empty($_POST['TypeSelector']) && isset($_POST['TypeSelector'])) {
			$_arrTypeSelector = $_POST['TypeSelector'];
			$_cntTypeSelector = count($_arrTypeSelector);
		}
		$_cntStatusSelector = "";
		if (!empty($_POST['StatusSelector']) && isset($_POST['StatusSelector'])) {
			$_arrStatusSelector = $_POST['StatusSelector'];
			$_cntStatusSelector = count($_arrStatusSelector);
		}
		$_cntIspSelector = "";
		if (!empty($_POST['IspSelector']) && isset($_POST['IspSelector'])) {
			$_arrIspSelector = $_POST['IspSelector'];
			$_cntIspSelector = count($_arrIspSelector);
		}
		$_cntIsprukSelector = "";
		if (!empty($_POST['IsprukSelector']) && isset($_POST['IsprukSelector'])) {
			$_arrIsprukSelector = $_POST['IsprukSelector'];
			$_cntIsprukSelector = count($_arrIsprukSelector);
		}
		?>
	</div>
	<?php
	if ((isset($_POST['ZakazSelector']) && !empty($_POST['ZakazSelector'])) || (isset($_POST['ObjectSelector']) && !empty($_POST['ObjectSelector'])) || (isset($_POST['TypeSelector']) && !empty($_POST['TypeSelector'])) || (isset($_POST['StatusSelector']) && !empty($_POST['StatusSelector'])) || (isset($_POST['YearSelector']) && !empty($_POST['YearSelector'])) || (isset($_POST['IspSelector']) && !empty($_POST['IspSelector'])) || (isset($_POST['IsprukSelector']) && !empty($_POST['IsprukSelector']))) {
	?>
		<div id="docsearch-result">
			<h3 class="space30">Результаты расширенного поиска</h3>
			<div class="demo-html"></div>
			<table id="docview-doc-main" class="table table-bordered" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class=""><span class='glyphicon glyphicon-option-vertical'></span></th>
						<th class="">№</th>
						<th class="">Год</th>
						<th class="">Краткое название</th>
						<th class=""><span class='glyphicon glyphicon-list-alt'></span></th>
					</tr>
				</thead>
				<tbody>
					<?php
					# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
					# Выбираем договора
					$qryPart = "";
					#
					$_yearQueryStr = "";
					for ($i = 0; $i < $_cntYearSelector; $i++) {
						if ($i == 0) {
							$_yearQueryStr .= "(";
						}
						$_yearQueryStr .= "yearnachdoc = '";
						if ($i < ($_cntYearSelector - 1)) {
							$_yearQueryStr .= $_arrYearSelector[$i] . "' OR ";
						}
						if ($i == ($_cntYearSelector - 1)) {
							$_yearQueryStr .= $_arrYearSelector[$i] . "')";
						}
					}
					#
					$qryPart .= $_yearQueryStr;
					#
					$_kodzakazQueryStr = "";
					for ($i = 0; $i < $_cntZakazSelector; $i++) {
						if ($i == 0) {
							$_kodzakazQueryStr .= "(";
						}
						$_kodzakazQueryStr .= "kodzakaz = '";
						if ($i < ($_cntZakazSelector - 1)) {
							$_kodzakazQueryStr .= $_arrZakazSelector[$i] . "' OR ";
						}
						if ($i == ($_cntZakazSelector - 1)) {
							$_kodzakazQueryStr .= $_arrZakazSelector[$i] . "')";
						}
					}
					#
					$qryPart .= (($qryPart != "") && ($_kodzakazQueryStr != "")) ? " AND " . $_kodzakazQueryStr : $_kodzakazQueryStr;
					#
					$_kodobjectQueryStr = "";
					for ($i = 0; $i < $_cntObjectSelector; $i++) {
						if ($i == 0) {
							$_kodobjectQueryStr .= "(";
						}
						$_kodobjectQueryStr .= "kodobject = '";
						if ($i < ($_cntObjectSelector - 1)) {
							$_kodobjectQueryStr .= $_arrObjectSelector[$i] . "' OR ";
						}
						if ($i == ($_cntObjectSelector - 1)) {
							$_kodobjectQueryStr .= $_arrObjectSelector[$i] . "')";
						}
					}
					#
					$qryPart .= (($qryPart != "") && ($_kodobjectQueryStr != "")) ? " AND " . $_kodobjectQueryStr : $_kodobjectQueryStr;
					#
					$_kodtipQueryStr = "";
					for ($i = 0; $i < $_cntTypeSelector; $i++) {
						if ($i == 0) {
							$_kodtipQueryStr .= "(";
						}
						$_kodtipQueryStr .= "kodtip = '";
						if ($i < ($_cntTypeSelector - 1)) {
							$_kodtipQueryStr .= $_arrTypeSelector[$i] . "' OR ";
						}
						if ($i == ($_cntTypeSelector - 1)) {
							$_kodtipQueryStr .= $_arrTypeSelector[$i] . "')";
						}
					}
					#
					$qryPart .= (($qryPart != "") && ($_kodtipQueryStr != "")) ? " AND " . $_kodtipQueryStr : $_kodtipQueryStr;
					#
					$_kodstatusQueryStr = "";
					for ($i = 0; $i < $_cntStatusSelector; $i++) {
						if ($i == 0) {
							$_kodstatusQueryStr .= "(";
						}
						$_kodstatusQueryStr .= "kodstatus = '";
						if ($i < ($_cntStatusSelector - 1)) {
							$_kodstatusQueryStr .= $_arrStatusSelector[$i] . "' OR ";
						}
						if ($i == ($_cntStatusSelector - 1)) {
							$_kodstatusQueryStr .= $_arrStatusSelector[$i] . "')";
						}
					}
					#
					$qryPart .= (($qryPart != "") && ($_kodstatusQueryStr != "")) ? " AND " . $_kodstatusQueryStr : $_kodstatusQueryStr;
					#
					$_kodispolQueryStr = "";
					for ($i = 0; $i < $_cntIspSelector; $i++) {
						if ($i == 0) {
							$_kodispolQueryStr .= "(";
						}
						$_kodispolQueryStr .= "kodispol = '";
						if ($i < ($_cntIspSelector - 1)) {
							$_kodispolQueryStr .= $_arrIspSelector[$i] . "' OR ";
						}
						if ($i == ($_cntIspSelector - 1)) {
							$_kodispolQueryStr .= $_arrIspSelector[$i] . "')";
						}
					}
					#
					$qryPart .= (($qryPart != "") && ($_kodispolQueryStr != "")) ? " AND " . $_kodispolQueryStr : $_kodispolQueryStr;
					#
					$_kodispolrukQueryStr = "";
					for ($i = 0; $i < $_cntIsprukSelector; $i++) {
						if ($i == 0) {
							$_kodispolrukQueryStr .= "(";
						}
						$_kodispolrukQueryStr .= "kodispolruk = '";
						if ($i < ($_cntIsprukSelector - 1)) {
							$_kodispolrukQueryStr .= $_arrIsprukSelector[$i] . "' OR ";
						}
						if ($i == ($_cntIsprukSelector - 1)) {
							$_kodispolrukQueryStr .= $_arrIsprukSelector[$i] . "')";
						}
					}
					#
					$qryPart .= (($qryPart != "") && ($_kodispolrukQueryStr != "")) ? " AND " . $_kodispolrukQueryStr : $_kodispolrukQueryStr;
					#





					//
					//
					$qry = "SELECT * FROM dognet_docbase WHERE " . $qryPart . " AND kodshab<>'0' AND numberchet='' AND koddel<>'99' ORDER BY docnumber ASC";
					$_QRY_FILTER_DOCS = mysqlQuery($qry);
					/* 	$_QRY_FILTER_DOCS = mysqlQuery( "SELECT * FROM dognet_docbase WHERE koddel='99'" ); */
					if (mysqli_num_rows($_QRY_FILTER_DOCS) >= 1 && mysqli_num_rows($_QRY_FILTER_DOCS) <= 500) {
						//
						// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
						//
						while ($_ROW_FILTER_DOCS = mysqli_fetch_array($_QRY_FILTER_DOCS, MYSQLI_ASSOC)) {
							$koddoc = $_ROW_FILTER_DOCS['koddoc'];
					?>
							<tr id="docview-filter-row-<?php echo $_ROW_FILTER_DOCS['koddoc']; ?>" class="collapse in">
								<td class="docview-filter text-center" style=""><a href="#tab2-avans-row-<?php echo $_ROW_FILTER_DOCS['koddoc']; ?>" data-toggle="collapse"><span class='glyphicon glyphicon-option-vertical'></span></a></td>
								<td class="docview-filter-docnumber text-center" style=""><?php echo $_ROW_FILTER_DOCS['docnumber']; ?></td>
								<td class="docview-filter-yearnachdoc text-center" style=""><?php echo $_ROW_FILTER_DOCS['yearnachdoc']; ?></td>
								<td class="docview-filter-docnameshot text-center" style=""><?php echo $_ROW_FILTER_DOCS['docnameshot']; ?></td>
								<td class="docview-filter-url text-center" style=""><?php echo '<a href="dognet-docview.php?docview_type=details&uniqueID=' . $_ROW_FILTER_DOCS['koddoc'] . '" target="_blank"><span class="glyphicon glyphicon-list-alt"></span></a>'; ?></td>
							</tr>
						<?php
						}
					} elseif (mysqli_num_rows($_QRY_FILTER_DOCS) > 500) {
						?>
						<tr id="docview-filter-row-<?php echo $_ROW_FILTER_DOCS['koddoc']; ?>" class="collapse in">
							<td colspan="5" class="">
								<div class="text-center" style="padding:10px">
									<span style="color:#951402; font-size:1.5em; font-weight:300; font-family:'Oswald', sans-serif">Найдено более 20-ти договоров. Попробуйте сузить параметры поиска.</span>
								</div>
							</td>
						</tr>
					<?php
					} else {
					?>
						<tr id="docview-filter-row-<?php echo $_ROW_FILTER_DOCS['koddoc']; ?>" class="collapse in">
							<td colspan="5" class="">
								<div class="text-center" style="padding:10px">
									<span style="color:#951402; font-size:1.5em; font-weight:300; font-family:'Oswald', sans-serif">По выбранным критериям ни одного договора не найдено.</span>
								</div>
							</td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>

	<?php
	} else {
	?>
		<div class="text-center" style="padding:10px; border:1px #951402 solid; border-radius:5px">
			<span style="color:#951402; font-size:1.5em; font-weight:300; font-family:'Oswald', sans-serif">Ни один критерий не определен.</span>
		</div>
	<?php
	}
	?>


</section>


<script type="text/javascript">
	// YEAR SELECTOR
	// Добавить в выбранное
	$('#btn_addToList_YearSelector').click(function() {
		$('#YearSelector1 option:selected').each(function() {
			$("<option selected/>").
			val($(this).val()).
			text($(this).text()).
			appendTo("#YearSelector");
		});
	});
	// Удалить из выбранного
	$('#btn_removeFromList_YearSelector').click(function() {
		$("#YearSelector option:selected").remove();
	});
	// Очистить список
	$('#btn_clearList_YearSelector').click(function() {
		$('#YearSelector').find('option').remove();
	});
	// ----- ----- ----- ----- -----
	// ZAKAZ SELECTOR
	// Добавить в выбранное
	$('#btn_addToList_ZakSelector').click(function() {
		$('#ZakazSelector1 option:selected').each(function() {
			$("<option selected/>").
			val($(this).val()).
			text($(this).text()).
			appendTo("#ZakazSelector");
		});
	});
	// Удалить из выбранного
	$('#btn_removeFromList_ZakSelector').click(function() {
		$("#ZakazSelector option:selected").remove();
	});
	// Очистить список
	$('#btn_clearList_ZakSelector').click(function() {
		$('#ZakazSelector').find('option').remove();
	});
	// ----- ----- ----- ----- -----
	// OBJECT SELECTOR
	// Добавить в выбранное
	$('#btn_addToList_ObjSelector').click(function() {
		$('#ObjectSelector1 option:selected').each(function() {
			$("<option selected/>").
			val($(this).val()).
			text($(this).text()).
			appendTo("#ObjectSelector");
		});
	});
	// Удалить из выбранного
	$('#btn_removeFromList_ObjSelector').click(function() {
		$("#ObjectSelector option:selected").remove();
	});
	// Очистить список
	$('#btn_clearList_ObjSelector').click(function() {
		$('#ObjectSelector').find('option').remove();
	});
	// ----- ----- ----- ----- -----
	// TYPE SELECTOR
	// Добавить в выбранное
	$('#btn_addToList_TypeSelector').click(function() {
		$('#TypeSelector1 option:selected').each(function() {
			$("<option selected/>").
			val($(this).val()).
			text($(this).text()).
			appendTo("#TypeSelector");
		});
	});
	// Удалить из выбранного
	$('#btn_removeFromList_TypeSelector').click(function() {
		$("#TypeSelector option:selected").remove();
	});
	// Очистить список
	$('#btn_clearList_TypeSelector').click(function() {
		$('#TypeSelector').find('option').remove();
	});
	// ----- ----- ----- ----- -----
	// STATUS SELECTOR
	// Добавить в выбранное
	$('#btn_addToList_StatusSelector').click(function() {
		$('#StatusSelector1 option:selected').each(function() {
			$("<option selected/>").
			val($(this).val()).
			text($(this).text()).
			appendTo("#StatusSelector");
		});
	});
	// Удалить из выбранного
	$('#btn_removeFromList_StatusSelector').click(function() {
		$("#StatusSelector option:selected").remove();
	});
	// Очистить список
	$('#btn_clearList_StatusSelector').click(function() {
		$('#StatusSelector').find('option').remove();
	});
	// ----- ----- ----- ----- -----
	// ISPOL SELECTOR
	// Добавить в выбранное
	$('#btn_addToList_IspSelector').click(function() {
		$('#IspSelector1 option:selected').each(function() {
			$("<option selected/>").
			val($(this).val()).
			text($(this).text()).
			appendTo("#IspSelector");
		});
	});
	// Удалить из выбранного
	$('#btn_removeFromList_IspSelector').click(function() {
		$("#IspSelector option:selected").remove();
	});
	// Очистить список
	$('#btn_clearList_IspSelector').click(function() {
		$('#IspSelector').find('option').remove();
	});
	// ----- ----- ----- ----- -----
	// ISPOLRUK SELECTOR
	// Добавить в выбранное
	$('#btn_addToList_IsprukSelector').click(function() {
		$('#IsprukSelector1 option:selected').each(function() {
			$("<option selected/>").
			val($(this).val()).
			text($(this).text()).
			appendTo("#IsprukSelector");
		});
	});
	// Удалить из выбранного
	$('#btn_removeFromList_IsprukSelector').click(function() {
		$("#IsprukSelector option:selected").remove();
	});
	// Очистить список
	$('#btn_clearList_IsprukSelector').click(function() {
		$('#IsprukSelector').find('option').remove();
	});
	// ----- ----- ----- ----- -----
	$('#columnSearch_btnClear').click(function() {
		$('#YearSelector').find('option').remove();
		$('#ZakazSelector').find('option').remove();
		$('#ObjectSelector').find('option').remove();
		$('#TypeSelector').find('option').remove();
		$('#StatusSelector').find('option').remove();
		$('#IspSelector').find('option').remove();
		$('#IsprukSelector').find('option').remove();
	});
</script>