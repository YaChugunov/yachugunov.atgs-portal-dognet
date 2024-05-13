jQuery.fn.filterByText = function(editor, textbox, fieldname, selectSingleMatch) {
	return this.each(function() {
		var defVal = this.value;
		var defIndex = this.selectedIndex;
		var select = this;
		var options = [];
		$(select).find('option').each(function() {
			options.push({value: $(this).val(), text: $(this).text()});
		});
		$(select).data('options', options);
		$(textbox).bind('change keyup', function() {
			var options = $(select).empty().data('options');
			var search = $(this).val().trim();
			if (search !== '') {
// 				$(select).prepend( $('<option value="" hidden disabled selected>Поиск...</option>'));
				var regex = new RegExp(search,"gi");
				$.each(options, function(i) {
					var option = options[i];
					if(option.text.match(regex) !== null) {
						$(select).append($('<option>').text(option.text).val(option.value));
					}
				});
// ----- ----- ----- ----- -----
				var optionsA = [];
				$(select).find('option').each(function() {
					optionsA.push({value: $(this).val(), label: $(this).text()});
				});
				$(select).data('optionsA', optionsA);

				editor.field(fieldname).update(optionsA);
				$(select).prepend('<option value="" disabled selected>[ПОИСК] Найдено: '+($(select).find('option').size()-1)+'</option>');
// ----- ----- ----- ----- -----
				if (selectSingleMatch === true && $(select).children().length === 1) {
					$(select).children().get(0).selected = true;
				}
			}
			else {
				var options = $(select).empty().data('options');
				$.each(options, function(i) {
					var option = options[i];
					$(select).append(
						$('<option>').text(option.text).val(option.value)
					);
				});
// ----- ----- ----- ----- -----
				var optionsB = [];
				$(select).find('option').each(function() {
					optionsB.push({value: $(this).val(), label: $(this).text()});
				});
				$(select).data('optionsB', optionsB);
// ----- ----- ----- ----- -----
				// Выводим первоначальные значение селектора
				$(select).children().get(defIndex).selected = true;
				editor.field(fieldname).update(optionsB);
			}
		});
	});
};



