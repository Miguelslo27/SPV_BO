$(function () {

fixFooterPos();
switchCurrencyWithPercent($('#porcentaje'), $('.input-group .input-group-addon.currency'), $('.input-group .input-group-addon.percent'));
fillCobertUnity($('#unidad_cobertura').val(), $('.unidad-cobertura'));

$(window).on('resize', function() {
	fixFooterPos();
})

$('body').on('click', '#porcentaje', function() {
	switchCurrencyWithPercent($(this), $('.input-group .input-group-addon.currency'), $('.input-group .input-group-addon.percent'));
});

$('body').on('change', '#unidad_cobertura', function() {
	fillCobertUnity($(this).val(), $('.unidad-cobertura'));
});

// Start tooltips
$('[data-toggle="tooltip"]').tooltip();

// Add behavior to table data format
$('textarea[data-type="table"]').each(function() {
	var $this       = $(this);
	var type        = $this.data('type');
	var id          = $this.attr('id');
	var aux_type_id = type + '-' + id;
	var $aux_field  = $('#' + aux_type_id);
	var txt_obj     = $this.val() != '' ? JSON.parse($this.val()) : {};

	var is_the_first = true;
	for(var prop in txt_obj) {
		if (is_the_first) {
			var $first_row = $($aux_field.find('tbody tr:visible')[0]);
			var $row_prop_key = $first_row.find('span.table-field');
			var $row_prop_val = $first_row.find('span.table-value');

			$row_prop_key.html(prop);
			$row_prop_val.html(txt_obj[prop]);

			is_the_first = false;
			continue;
		}
		// console.log(prop);
		var $row_tmplt = $aux_field.find('tbody tr.row-template');
	 	var $new_row = $row_tmplt.clone(true);
	 		$new_row.removeClass('row-template hidden');
	 		$new_row.appendTo($aux_field.find('tbody'));
	 		$new_row.tooltip('destroy');
	 		$new_row.find('a.btn.glyphicon-minus').tooltip();

	 	var $new_row_prop_key = $new_row.find('span.table-field');
		var $new_row_prop_val = $new_row.find('span.table-value');
			$new_row_prop_key.html(prop);
			$new_row_prop_val.html(txt_obj[prop]);
	}

	// TODO MIKE - Procesar los datos de la tabla
	// Por ahora sólo será table, pero ya tener en cuenta otros casos
	if (type == 'table') {
		// Asumimos que el aux_field es una tabla con un formato específico
		$aux_field
		 .find('thead th a.btn.glyphicon-plus')
		 .on('click', function(e) {
		 	e.preventDefault();

		 	// Obtengo el template row de esta tabla
		 	var $row_tmplt = $aux_field.find('tbody tr.row-template');
		 	var $new_row = $row_tmplt.clone(true);
		 		$new_row.removeClass('row-template hidden');
		 		$new_row.appendTo($aux_field.find('tbody'));
		 		$new_row.tooltip('destroy');
		 		$new_row.find('a.btn.glyphicon-minus').tooltip();
		 });

		$aux_field
		 .find('tbody td a.btn.glyphicon-minus')
		 .on('click', function(e) {
		 	e.preventDefault();

		 	var $this = $(this);
		 	var $this_table = $this.parents('tbody:first');
		 	var $table_rows = $this_table.find('tr:visible');

		 	if ($table_rows.length > 1) {
			 	var $this_row = $(this).parents('tr:first');
			 		$this_row.remove();
		 	} else {
		 		if ($('#last-row-deleteion').length) {
		 			$('#last-row-deleteion').fadeIn();
		 		} else {
			 		$('body').append(function() {
			 			return '<div id="last-row-deleteion" class="alert alert-danger" role="alert"><b>No se puede eliminar la fila.</b> La tabla no puede estar vacía.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></div>'
			 		});
		 		}
		 	}
		 })
		 .end()
		 .find('tbody td span[contenteditable="true"]')
		 .on('keypress', function(e) {
		 	if (e.keyCode == 13) {
		 		e.preventDefault();

		 		var $this = $(this);
		 		var $this_cell = $this.parents('td:first');
		 		var $this_row = $this.parents('tr:first');

		 		if ($this_cell.is(':first-child')) {
		 			$this_cell.next().find('span[contenteditable="true"]').focus();
		 		} else {
			 		var $row_tmplt = $aux_field.find('tbody tr.row-template');
				 	var $new_row = $row_tmplt.clone(true);
				 		$new_row.removeClass('row-template hidden');
				 		$new_row.appendTo($aux_field.find('tbody'));
				 		$new_row.tooltip('destroy');
				 		$new_row.find('a.btn.glyphicon-minus').tooltip();
				 		$new_row.find('td:first-child span[contenteditable="true"]').focus();
		 		}
		 	}
		 });
	}
});

$('form').on('click', '.save', function(e) {
	e.preventDefault();

	var $form = $(this).parents('form:first');
	var $tables = $form.find('textarea[data-type="table"]');

	if (!$tables.length) {
		$form.submit();
		return;
	}

	$tables.each(function() {
		var $this       = $(this);
		var type        = $this.data('type');
		var id          = $this.attr('id');
		var aux_type_id = type + '-' + id;
		var $aux_field  = $('#' + aux_type_id);

		var object = {};

		$aux_field.find('tbody tr:visible').each(function() {
			var $row = $(this);
			var prop_key = $row.find('td span.table-field').html();
			var prop_val = $row.find('td span.table-value').html();

			if ($.trim(prop_key) != '') {
				object[prop_key] = prop_val;
			}
		});

		$this.val(JSON.stringify(object));
	});

	$form.submit();
});

});

function fixFooterPos() {
	if ($('body').outerHeight() < $(window).outerHeight()) {
		$('footer').css({
			position: 'absolute',
			bottom: 0,
			left: 0,
			right: 0
		});
	} else {
		$('footer').removeAttr('style');
	}
}

function fillCobertUnity(verbose, $tarjet) {
	$tarjet.html(function() {
		var r = '';
		switch (verbose) {
			case 'mensual':
			r = 'meses';
			break;
			case 'anual':
			r = 'años';
			break;
		}
		return r;
	});
}

function switchCurrencyWithPercent($input, $currency, $percent) {
	if ($input.is(':checked')) {
		$currency.hide();
		$percent.css({ 'display': 'table-cell' });
	} else {
		$currency.css({ 'display': 'table-cell' });
		$percent.hide();
	}
}