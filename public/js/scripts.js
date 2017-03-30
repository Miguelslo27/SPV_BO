$(function () {

fixFooterPos();
switchCurrencyType($('#moneda'));
switchCurrencyWithPercent($('#porcentaje'));
fillCobertUnity($('#unidad_cobertura').val(), $('.unidad-cobertura'));

$(window).on('resize', function() {
  fixFooterPos();
});

$('body').on('click', '#moneda', function() {
  switchCurrencyType($(this), $('.input-group .input-group-addon.currency'), $('.input-group .input-group-addon.dollar'));
});

$('body').on('click', '#porcentaje', function() {
  switchCurrencyWithPercent($(this), $('.input-group .input-group-addon.currency, .input-group .input-group-addon.dollar'), $('.input-group .input-group-addon.percent'));
});

$('body').on('click', '.file-wrap', function(e) {
  var $this = $(this),
      $target = $(e.target);

  if (!$target.hasClass('file-command')) {
    e.preventDefault();
    e.stopPropagation();

    selectFile($this);
  }
});

$('body').on('click', '.file-command.fa-trash', function(e) {
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
                '<input type="file" id="upload-new-file">' +
                '<input type="text" id="csrf_token" disabled value="' + $('#csrf_token_val').text() + '">' +
                '<input type="submit" value="Subir">' +
            '</form>';
          });
        }
       });
    }
  });
});

$('body').on('change', '#upload-new-file', function (e) {
  window.__upload_files = e.target.files;
});

$('body').on('submit', '#upload-file', function (e) {
  e.preventDefault();
  e.stopPropagation();

  var data = new FormData();

  $.each(window.__upload_files, function (k, v) {
    data.append(k, v);
  });

  data.append('_token', $(this).find('#csrf_token').val());
  console.log(data.keys());

  $.ajax({
    url: $(this).attr('action'),
    type: 'POST',
    data: data,
    cache: false,
    dataType: 'json',
    processData: false,
    contentType: false,
    success: function (data, status, xhr) {
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
            '<form action="/filesystem/add" id="upload-file">' +
                '<input type="file" id="upload-new-file">' +
                '<input type="text" id="csrf_token" disabled value="' + $('#csrf_token_val').text() + '">' +
                '<input type="submit" value="Subir">' +
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

$('body').on('change', '#unidad_cobertura', function() {
  fillCobertUnity($(this).val(), $('.unidad-cobertura'));
});

// Start tooltips
$('[data-toggle="tooltip"]').tooltip();

// process form type field if exists
$('form').find('select#tipo').each(function() {
  var $table_target = $('form').find('table#table-' + $(this).data('target')).parents('.form-group:first').parents('.row:first');
  
  if ($(this).val() == 'lista') {
    $table_target.removeClass('hidden');
    fixFooterPos();
  }

  $(this).on('change', function(e) {
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