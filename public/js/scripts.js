$(function () {

fixFooterPos();
switchCurrencyType($('#moneda'));
switchCurrencyWithPercent($('#porcentaje'));
fillCobertUnity($('#unidad_cobertura').val(), $('.unidad-cobertura'));

$(window).on('resize', function () {
  fixFooterPos();
});

$('body').on('click', '#moneda', function () {
  switchCurrencyType($(this), $('.input-group .input-group-addon.currency'), $('.input-group .input-group-addon.dollar'));
});

$('body').on('click', '#porcentaje', function () {
  switchCurrencyWithPercent($(this), $('.input-group .input-group-addon.currency, .input-group .input-group-addon.dollar'), $('.input-group .input-group-addon.percent'));
});

$('body').on('click', '.file-wrap', function (e) {
  var $this = $(this),
      $target = $(e.target);

  if (!$target.hasClass('file-command')) {
    e.preventDefault();
    e.stopPropagation();

    selectFile($this);
  }
});

$('body').on('click', '#seleccionar-archivo', function (e) {
  if ($('.file-wrap.selected-file').length) {
    $('#condiciones').val($('.file-wrap.selected-file').data('downloadpath'));
    $('.condiciones-text').text($('.file-wrap.selected-file').data('filename'));
    $('#filesystem').modal('hide');
  }
});

$('body').on('click', '.file-command.fa-trash', function (e) {
  e.preventDefault();

  // Set loading
  var _this_file = $(this).parents('.file-wrap:first');
  $(this)
   .parents('.file-wrap:first')
   .append('<div class="deleting"><span class="fa fa-spin fa-trash"></span><span class="del-text">Eliminando...</span></div>');

  // Make the request to this url
  $.get($(this).attr('href'), function (res, status) {
    if (status == 'success') {
      // On success (status 200) set of loading
      _this_file
       .find('.deleting')
       .fadeOut('fast');

      // Remove the file of the list
      _this_file
       .fadeOut('fast', function () {
        _this_file.remove();

        // Count files
        $('#filesystem .count-files').text($('#filesystem .file-wrap').length);

        if (!$('#filesystem .file-wrap').length) {
          $('#filesystem .modal-body .col-md-8 .col-commands').remove();
          $('#filesystem .modal-body .col-md-8 .col-content').html(function () {
            return '' +
            '<p>No se han encontrado archivos</p>' + 
            '<form action="/filesystem/add" id="upload-file">' +
                '<span class="btn btn-default btn-file">' +
                    '<span class="upload-file-name">Agregar archivo</span> <input type="file" id="upload-new-file">' +
                '</span>' +
                '<input type="hidden" id="csrf_token" disabled value="' + $('#csrf_token_val').text() + '"> ' +
                '<button type="submit" class="btn btn-primary fa fa-cloud-upload hidden"></button>' +
            '</form>';
          });
        }
       });
    }
  });
});

$('body').on('change', '#upload-new-file', function (e) {
  window.__upload_files = e.target.files;
  $(this)
   .parents('span:first')
   .find('.upload-file-name')
   .text(e.target.files[0].name);

  $(this)
   .parents('span:first')
   .next()
   .next()
   .removeClass('hidden');
});

$('body').on('submit', '#upload-file', function (e) {
  e.preventDefault();
  e.stopPropagation();

  var data = new FormData();

  $.each(window.__upload_files, function (k, v) {
    data.append(k, v);
  });

  data.append('_token', $(this).find('#csrf_token').val());

  $('#upload-new-file')
   .parents('span:first')
   .addClass('btn-danger')
   .find('.upload-file-name')
   .text('Subiendo archivo...');

  $('#upload-new-file')
   .parents('span:first')
   .next()
   .next()
   .addClass('hidden');

  $.ajax({
    url: $(this).attr('action'),
    type: 'POST',
    data: data,
    cache: false,
    dataType: 'json',
    processData: false,
    contentType: false,
    success: function (data, status, xhr) {
      $('#upload-new-file')
       .parents('span:first')
       .removeClass('btn-danger')
       .find('.upload-file-name')
       .text('Agregar archivo');

      var $newFile = $('' +
      '<div class="file-wrap"' +
       'data-mimetype="' + data.mimeType + '"' +
       'data-filename="' + data.name + '"' +
       'data-size="' + data.size + '"' +
       'data-lastmodified="' + data.lastModified + '"' +
       'data-viewpath="/filesystem/pdf/' + data.name + '"' +
       'data-deletepath="/filesystem/pdf/delete/' + data.name + '"' +
       'data-downloadpath="/filesystem/pdf/download/' + data.name + '"' +
       'data-toggle="tooltip"' +
       'data-placement="top"' +
       'title="' + data.name + '">' +
          '<span class="fa fa-file-' + (data.mimeType == 'application/pdf' ? 'pdf-' : '') + 'o"></span>' +
          '<span class="file-name">' +
              '<a href="/filesystem/pdf/' + data.name + '" target="_blank" class="file-link">' + data.name.slice(0, 16) + '...</a>' +
          '</span>' +
          '<span class="fa fa-check hidden"></span>' +
          '<div class="file-commands">' +
              '<div class="buttons">' +
                  '<a href="/filesystem/pdf/' + data.name + '"' +
                   'target="_blank"' +
                   'class="fa fa-eye file-command"' +
                   'data-toggle="tooltip"' +
                   'data-placement="top"' +
                   'title="Abrir"></a> ' +
                  '<a href="/filesystem/pdf/download/' + data.name + '"' +
                   'class="fa fa-cloud-download file-command"' +
                   'data-toggle="tooltip"' +
                   'data-placement="top"' +
                   'title="Descargar"></a> ' +
                  '<a href="/filesystem/pdf/delete/' + data.name + '"' +
                   'class="fa fa-trash file-command"' +
                   'data-toggle="tooltip"' +
                   'data-placement="top"' +
                   'title="Eliminar"></a>' +
              '</div>' +
          '</div>' +
      '</div>');

      if (!$('.files-container').length) {
        $('<div class="col-commands">' +
            '<span><strong>Archivos:</strong> <span class="count-files">' + 1 + '</span></span>' +
            '<form action="/filesystem/add" id="upload-file" class="pull-right">' +
                '<span class="btn btn-default btn-file">' +
                    '<span class="upload-file-name">Agregar archivo</span> <input type="file" id="upload-new-file">' +
                '</span>' +
                '<input type="hidden" id="csrf_token" disabled value="' + $('#csrf_token_val').text() + '"> ' +
                '<button type="submit" class="btn btn-primary fa fa-cloud-upload hidden"></button>' +
            '</form>' +
        '</div>').insertAfter('#filesystem .modal-body .col-md-8 .col-title');

        $('#filesystem .modal-body .col-md-8 .col-content').html('<div class="files-container"></div>');
      } else {
        $('.count-files').text($('.files-container').length + 1);
      }

      $('.files-container').append($newFile);
    },
    error: function (xhr, status, error) {
      console.log(error);
    }
  });
});

$('body').on('change', '#unidad_cobertura', function () {
  fillCobertUnity($(this).val(), $('.unidad-cobertura'));
});

// Start tooltips
$('[data-toggle="tooltip"]').tooltip();

// process form type field if exists
$('form').find('select#tipo').each(function () {
  var $table_target = $('form').find('table#object-' + $(this).data('target')).parents('.form-group:first').parents('.row:first');
  
  if ($(this).val() == 'lista') {
    $table_target.removeClass('hidden');
    fixFooterPos();
  }

  $(this).on('change', function (e) {
    // If type is 'lista' show the contents table
    // otherwise hide it
    if ($(this).val() == 'lista') {
      $table_target.removeClass('hidden');
      fixFooterPos();
    } else {
      $table_target.addClass('hidden');
    }

    if ($(this).val() == 'moneda-peso') {
      $('input[type=checkbox]#moneda').prop('checked', false);
      switchCurrencyType($('#moneda'), $('.input-group .input-group-addon.currency'), $('.input-group .input-group-addon.dollar'));
    }

    if ($(this).val() == 'moneda-dolar') {
      $('input[type=checkbox]#moneda').prop('checked', true);
      switchCurrencyType($('#moneda'), $('.input-group .input-group-addon.currency'), $('.input-group .input-group-addon.dollar'));
    }
  });
});

// Add behavior to table data format
$('textarea[data-type]').each(function () {
  var $this        = $(this);
  var type         = $this.data('type');
  var id           = $this.attr('id');
  var aux_type_id  = type + '-' + id;
  var $aux_field   = $('#' + aux_type_id);
  var json_value   = $this.val() != '' ? JSON.parse($this.val()) : ( type == 'object' ? {} : []);

  // Fill the aux field table with json values
  fillAuxFieldTable($aux_field, json_value, type);

  // Bind Events
  bindAuxFieldEvents($aux_field);
});

function fillAuxFieldTable($aux_field, json_value, type) {
  var is_the_first = true;
  var row_keys     = json_value && Array.isArray(json_value) ? Object.keys(json_value[0]) : null;

  if (!row_keys) return;

  json_value.forEach(function (row, index) {
    var $first_row   = $aux_field.find('tbody tr:visible:eq(0)');
    var $current_row = null;

    if (is_the_first) {
      $current_row = $first_row;
      is_the_first = false;
    } else {
      $current_row = addNewRow($aux_field, null, true);
    }

    row_keys.forEach(function (key, index) {
      $current_row.find('td [data-key=' + key + ']').val(row[key]);
    });
  });
}

function bindAuxFieldEvents($aux_field) {
  $aux_field
   .find('thead th a.btn.glyphicon-plus')
   .on('click', addNewRow.bind(this, $aux_field))
   .end()
   .find('tbody td a.btn.glyphicon-minus')
   .on('click', deleteRow)
   .end()
   .find('tbody td span[contenteditable="true"]')
   .on('keypress', onKeyPress.bind(this, $aux_field));
}

function addNewRow($aux_field, e, return_row) {
  if (e) e.preventDefault();

  // Obtengo el template row de esta tabla
  var $row_tmplt = $aux_field.find('tbody tr.row-template');
  var $new_row   = $row_tmplt.clone(true);
      $new_row.removeClass('row-template hidden');
      $new_row.appendTo($aux_field.find('tbody'));
      $new_row.tooltip('destroy');
      $new_row.find('a.btn.glyphicon-minus').tooltip();

  if (return_row) return $new_row;
}

function deleteRow(e) {
  e.preventDefault();

  var $this       = $(this);
  var $this_table = $this.parents('tbody:first');
  var $table_rows = $this_table.find('tr:visible');

  if ($table_rows.length > 1) {
    var $this_row = $(this).parents('tr:first');
        $this_row.remove();
  } else {
    if ($('#last-row-deleteion').length) {
      $('#last-row-deleteion').fadeIn();
    } else {
      $('body').append(function () {
        return '<div id="last-row-deleteion" class="alert alert-danger" role="alert"><b>No se puede eliminar la fila.</b> La tabla no puede estar vacía.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></div>'
      });
    }
  }
}

function onKeyPress($aux_field, e) {
  if (e.keyCode == 13) {
    e.preventDefault();

    var $this = $(this);
    var $this_cell = $this.parents('td:first');
    var $this_row = $this.parents('tr:first');

    if ($this_cell.is(':first-child')) {
      $this_cell.next().find('span[contenteditable="true"]').focus();
    } else {
      addNewRow($aux_field, e);
    }
  }
}

function onSave(e) {
  e.preventDefault();

  var $form       = $(this).parents('form:first');
  var $adv_fields = $form.find('textarea[data-type]');

  if (!$adv_fields.length) {
    $form.submit();
    return;
  }

  $adv_fields.each(function () {
    var $this       = $(this);
    var type        = $this.data('type');
    var id          = $this.attr('id');
    var aux_type_id = type + '-' + id;
    var $aux_field  = $('#' + aux_type_id);
    var $aux_rows   = $aux_field.find('tbody tr:visible');
    var json_field  = [];

    $aux_rows.each(function () {
      var $row = $(this);
      var $inputs = $row.find('td [data-key]');
      var row_obj = {};

      $inputs.each(function () {
        var $input = $(this);

        if (cleanText($input.val()) == "") return false;

        row_obj[$input.data('key')] = cleanText($input.val());
      });

      json_field.push(row_obj);
    });

    $this.val(JSON.stringify(json_field));
  });

  $form.submit();
}

$('form').on('click', '.save', onSave);

});

function cleanText(text) {
  var tagre = new RegExp("<[^>]*>", "gi");
  return $.trim(text.split(tagre).join(''));
}

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
  $tarjet.html(function () {
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

function switchCurrencyType($input) {
  var $target = $('#' + $input.data('input'));
  var $dollar = $target.prev();
  var $currency = $dollar.prev();
  var $percent = $('#porcentaje');

  if (!$percent.is(':checked')) {
    if ($input.is(':checked')) {
      $currency.hide();
      $dollar.css({ 'display': 'table-cell' });
    } else {
      $currency.css({ 'display': 'table-cell' });
      $dollar.hide();
    }
  }
}

function switchCurrencyWithPercent($input) {
  var $target = $('#' + $input.data('input'));
  var $dollar = $target.prev();
  var $currency = $target.prev().prev();
  var $percent = $target.next();
  var $currency2 = $('#moneda');

  if ($input.is(':checked')) {
    $currency2.parents('.input-group:first').hide();
    $currency.hide();
    $dollar.hide();
    $percent.css({ 'display': 'table-cell' });
  } else {
    $currency2.parents('.input-group:first').show();
    if ($('#moneda').is(':checked')) {
      $currency.hide();
      $dollar.css({ 'display': 'table-cell' });
    } else {
      $dollar.hide();
      $currency.css({ 'display': 'table-cell' });
    }
    $percent.hide();
  }
}

function selectFile($file) {
  if ($file.hasClass('selected-file')) {
    $file.removeClass('selected-file');
  } else {
    $('.file-wrap.selected-file').removeClass('selected-file');
    $file.addClass('selected-file');
  }

  $('#filesystem .modal-body .col-md-4:first .col-content').html(function () {
    return !$file.hasClass('selected-file') ? '<p>No se ha seleccionado ningún archivo</p>' : '' +
    '<div>' +
      '<p><span class="fa fa-file-' + ($file.data('mimetype') == 'application/pdf' ? 'pdf-' : '') + 'o"></span></p>' +
      '<p><strong>' + $file.data('filename') + '</strong></p>' +
      '<p><strong>Tamaño: </strong><span>' + (parseFloat($file.data('size')) / 1024).toFixed(2) + '</span></p>' +
      '<iframe src="' + $file.data('viewpath') + '" frameborder="0" width="100%" height="180px"></iframe>' +
    '</div>';
  });
}