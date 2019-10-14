(function($) {
  'use strict';

  /**
  * Constructor.
  */
  var SimpleColorPicker = function(select, options) {
    this.init('simplecolorpicker', select, options);
    //console.log(select);
  };

  /**
  * SimpleColorPicker class.
  */
  SimpleColorPicker.prototype = {
    constructor: SimpleColorPicker,

    init: function(type, select, options) {
      var self = this;

      self.type = type;

      self.$select = $(select);
      self.$select.hide();

      self.options = $.extend({}, $.fn.simplecolorpicker.defaults, options);

      self.$colorList = null;

      if (self.options.picker === true) {

        var selectText = self.$select.find('> option:selected').text();
        self.$icon = $('<span class="simplecolorpicker icon"'
            + ' title="' + selectText + '"'
            + ' style="background-color: ' + self.$select.val() + ';"'
            + ' role="button" tabindex="0">'
            + '</span>').insertAfter(self.$select);
        self.$icon.on('click.' + self.type, $.proxy(self.showPicker, self));
        self.$picker = $('<span class="simplecolorpicker picker ' + self.options.theme + '"></span>').appendTo(document.body);
        self.$colorList = self.$picker;

        //Ocultar picker ao clicar fora
        $(document).on('mousedown.' + self.type, $.proxy(self.hidePicker, self));
        self.$picker.on('mousedown.' + self.type, $.proxy(self.mousedown, self));
      
      } else {
        self.$inline = $('<span class="simplecolorpicker inline ' + self.options.theme + '"></span>').insertAfter(self.$select);
        self.$colorList = self.$inline;
      }

      // Crie a lista de cores
      // <span class="color selected" title="Green" style="background-color: #7bd148;" role="button"></span>
      self.$select.find('> option').each(function(i) {
        var $option = $(this);
        var color = $option.val();


        var isSelected = $option.is(':selected');
        var isDisabled = $option.is(':disabled');

        var selected = '';
        if (isSelected === true) {
          selected = ' data-selected';
        }

        var disabled = '';
        if (isDisabled === true) {
          disabled = ' data-disabled';
          //console.log(disabled);
        }

        var title = '';
        if (isDisabled === false) {
          title = ' title="' + $option.text() + '"';
          //console.log(title);
        }

        var role = '';
        if (isDisabled === false) {
          role = ' role="button" tabindex="'+i+'"';
          //console.log(role);
        }

        var $colorSpan = $('<span class="color"'
          + title
          + ' style="background-color: ' + color + ';"'
          + ' data-color="' + color + '"'
          + selected
          + disabled
          + role + '>'
          + '</span>');

        self.$colorList.append($colorSpan);
        //console.log(self);
        $colorSpan.on('click.' + self.type, $.proxy(self.colorSpanClicked, self));

        var $next = $option.next();
        if ($next.is('optgroup') === true) {
          // Quebra Vertical, como hr
          self.$colorList.append('<span class="vr"></span>');
        }
      });
    },

    /**
    * Altera a cor selecionada.
    *
    * @param Colorir a cor hexadecimal para selecionar, ex: '#fbd75b'
    */
    removeChekbox: function(id, color) {

    },

    selectColor: function(color) {
      var self = this;
      //console.log(self);

      var $colorSpan = self.$colorList.find('> span.color').filter(function() {
        return $(this).data('color').toLowerCase() === color.toLowerCase();
      });

      if ($colorSpan.length > 0) {
        self.selectColorSpan($colorSpan);
      } else {
        console.error("The given color '" + color + "' could not be found");
      }
    },

    showPicker: function() {
      var pos = this.$icon.offset();
      this.$picker.css({
        // Remova alguns pixels para alinhar o ícone do selecionador com os ícones dentro do menu suspenso
        left: pos.left - 6,
        top: pos.top + this.$icon.outerHeight()
      });

      this.$picker.show(this.options.pickerDelay);
    },

    hidePicker: function() {
      this.$picker.hide(this.options.pickerDelay);
    },

    /**
    * Seleciona a extensão dada dentro $colorList.
    *
    * A extensão dada torna-se a selecionada.
    * Também altera o valor de seleção de HTML, este 'change' event.
    */
    selectColorSpan: function($colorSpan) {
      var color = $colorSpan.data('color');
      var title = $colorSpan.prop('title');

      // Marque esse intervalo como o selecionado
      if (this.options.multiple === false) {
        $colorSpan.siblings().removeAttr('data-selected');
      }
      $colorSpan.attr('data-selected', '');

      if (this.options.picker === true) {
        this.$icon.css('background-color', color);
        this.$icon.prop('title', title);
        this.hidePicker();
      }

      // Alterar o valor de seleção de HTML
      this.$select.val(color);
    },

    includesText: function(color, title)
    {
      var str = $('#'+this.options.element).html(),
      idc  = color.replace('#', '');
      if(str.includes(color) == false){
        $('#'+this.options.element).append('<input id="'+idc+'" type="checkbox" name="groups['+color+']"  value="'+title+'" checked>');
      }
    },

    removeColor: function(color)
    {
      var str = $('#'+this.options.element).html();
      $(color).remove();
    },

    /**
    * O usuário clicou em uma cor dentro $colorList.
    */
    colorSpanClicked: function(e) {
      // When a color is clicked, make it the new selected one (unless disabled)
      if ($(e.target).is('[data-disabled]') === false) {
        var id  = this.$select.trigger('change').attr('id'),
        title = $(e.target).attr('title'),
        color = $(e.target).attr('data-color');
        if ($(e.target).attr('data-selected') === undefined) {
          this.selectColorSpan($(e.target));
          this.includesText(color, title);
        } else {
          $(e.target).removeAttr('data-selected');
          var opc = $('#'+id+' option[value="'+color+'"]');
          opc.removeAttr('selected');
          this.removeColor(color);
        }       
        this.$select.trigger('change');
        $('#'+id+' option[value="'+color+'"]').attr('selected','selected');
      }
    },

    /**
    * Impede que o evento mousedown "alimente" o evento click.
    */
    mousedown: function(e) {
      e.stopPropagation();
      e.preventDefault();
    },

    destroy: function() {
      if (this.options.picker === true) {
        this.$icon.off('.' + this.type);
        this.$icon.remove();
        $(document).off('.' + this.type);
      }

      this.$colorList.off('.' + this.type);
      this.$colorList.remove();

      this.$select.removeData(this.type);
      this.$select.show();
    }
    };

  /**
  * Plugin definição.
  * Como usar: $('#id').SimpleColorPicker()
  */
  $.fn.simplecolorpicker = function(option) {
    var args = $.makeArray(arguments);
    args.shift();

    // For HTML element passed to the plugin
    return this.each(function() {
      var $this = $(this),
      data = $this.data('simplecolorpicker'),
      options = typeof option === 'object' && option;
      if (data === undefined) {
        $this.data('simplecolorpicker', (data = new SimpleColorPicker(this, options)));
      }
      if (typeof option === 'string') {
        data[option].apply(data, args);
      }
    });
  };

  /**
  * Default options.
  */
  $.fn.simplecolorpicker.defaults = {
    // Nenhum element por padrão
    element: '',
    // Nenhum theme por padrão
    theme: '',
    //Mostrar 0 picker ou torná-lo inline
    picker: false,
    // Atraso de animação em milissegundos
    pickerDelay: 0,

    multiple: false
  };

})(jQuery); 
