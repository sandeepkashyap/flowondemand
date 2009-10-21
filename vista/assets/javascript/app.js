var App = window.App || {};

/** We will put all of our variables and resources (URL-s, listings etc) **/
App.data = {};

// All widgets should be defined here
App.widgets = {};

App.extendUrl = function(url, extend_with) {
  if(!url || !extend_with) {
    return url;
  } // if

  var extended_url = url;
  var parameters = [];

  extended_url += extended_url.indexOf('?') < 0 ? '?' : '&';

  for(var i in extend_with) {
    if(typeof(extend_with[i]) == 'object') {
      for(var j in extend_with[i]) {
        parameters.push(i + '[' + j + ']' + '=' + extend_with[i][j]);
      } // for
    } else {
      parameters.push(i + '=' + extend_with[i]);
    } // if
  } // for

  return extended_url + parameters.join('&');
};


/**
 * Convert & -> &amp; < -> &lt; and > -> &gt;
 *
 * @param str
 * @return string
 */
App.clean = function(str) {
  if(typeof(str) == 'string') {
    str = str.replace(/&/g, '&amp;');
    str = str.replace(/\>/g, '&gt;');
    str = str.replace(/\</g, '&lt;');
  }

  return str;
};

/**
 * JS version of lang function / helper
 *
 * @param string content
 * @param object params
 */
App.lang = function(content, params) {
  var translation = content;

  if(typeof(App.langs) == 'object') {
    if(App.langs[content]) {
      translation = App.langs[content];
    }
  }

  if(typeof params == 'object') {
    for(key in params) {
      translation = translation.replace(':' + key, App.clean(params[key]));
    } // if
  } // if
  return translation;
};

/**
 * JavaScript implementation of isset() function
 *
 * Usage example:
 *
 * if(isset(undefined, true) || isset('Something')) {
 *   // Do stuff
 * }
 *
 * @param value
 * @return boolean
 */
App.isset = function(value) {
  return !(typeof(value) == 'undefined' || value === null);
};

/**
 * Add async variables to async link
 *
 * @param string link
 * @return string
 */
App.makeAsyncUrl = function(link) {
  if (link) {
    if (link.indexOf('?') < 0) {
      link += '?async=1&skip_layout=1'
    } else {
      link += '&async=1&skip_layout=1'
    } // if
    return link;
  } else {
    return false;
  }
};

/**
 * Convert MySQL formatted datetime string to Date() object
 *
 * @params String timestamp
 * @return Date
 */
App.mysqlToDate = function(timestamp) {
  var regex=/^([0-9]{2,4})-([0-1][0-9])-([0-3][0-9]) (?:([0-2][0-9]):([0-5][0-9]):([0-5][0-9]))?$/;
  var parts=timestamp.replace(regex, "$1 $2 $3 $4 $5 $6").split(' ');
  return new Date(parts[0], parts[1], parts[2], parts[3], parts[4], parts[5]);
};


/**
 * Parse numeric value and return integer or float
 *
 * @param String value
 * @return mixed
 */
App.parseNumeric = function(value) {
  if(typeof(value) == 'number') {
    return value;
  } else if(typeof(value) == 'string') {
    if(value.indexOf('.') > -1) {
      var separator = '.';
    } else if(value.indexOf(',') > -1) {
      var separator = ',';
    } else {
      return value == '' ? 0 : parseInt(value);
    } // if

    var separator_pos = value.indexOf(separator);
    return parseInt(value.substring(0, separator_pos)) + parseFloat('0.' + value.substring(separator_pos + 1));
  } else {
    return NaN;
  }
};

jQuery.fn.highlightFade = function() {
  return this.effect("highlight", {}, 1000)
};

function ucfirst( str ) {
  str += '';
  var f = str.charAt(0).toUpperCase();
  return f + str.substr(1);
}

// Do stuff that we need to do on every page...
$(document).ready(function() {
  App.layout.init();
});

/** Layout **/
App.layout = function() {

	return {
		init : function() {

		}
	}
}();

/**
 * Modal dialog module
 */
App.ModalDialog = function() {

  /**
   * Current dialog reference
   *
   * @var jQuery
   */
  var dialog_object;

  // Let's return public interface object
  return {

    /**
     * Show modal dialog
     *
     *
     * @param String name
     * @param String title
     * @param mixed body
     * @param mixed settings
     */
    show : function(name, title, body, settings) {
      // dialog options
      var options = {
        modal     : true,
        draggable : false,
        resizable : true,
        title     : title,
        id        : name,
        position  : 'top',
        close     : function (type,data) {
          if (settings.close) {
            settings.close();
          } // if
          dialog_object.dialog('destroy').remove();
        },
        resizeStart : function (type,data) {

        }
      };

      if (settings) {
        // width and height settings
        options.width = settings.width ? settings.width : 410;
        options.height = settings.height ? settings.height : 'auto';
        // additional buttons
        options.buttons = {};
        if (settings && settings.buttons) {
          for (var x = 0; x < settings.buttons.length; x++) {
            if (settings.buttons[x].callback) {
              var callback_function = settings.buttons[x].callback;
              options.buttons[settings.buttons[x].label] = function () {
                callback_function();
                dialog_object.dialog('close');
              } // function
            } else {
              options.buttons[settings.buttons[x].label] = function () {
                dialog_object.dialog('close');
              } // function
            } // if
          } // if
        } // if
      } // if

      options.maxWidth = options.width;
      options.minWidth = options.width;

      dialog_object = $(body).dialog(options);

      var counter = 0;
      dialog_object.parent().parent().find('.ui-dialog-buttonpane button').each(function () {
        var button = $(this);
        button.removeClass('ui-state-default').removeClass('ui-corner-all');

        var label = button.html();
        button.html('<span>' + label + '</span>');
        if (counter != 0) {
          button.addClass('alternative');
        } // if
        counter++;
      });
    },

    /**
     * Close the dialog
     */
    close : function() {
      dialog_object.dialog('destroy').remove();
    },

    /**
     * sets width of dialog
     */
    setWidth : function (width_px) {
      var dom_dialog = $('.ui-dialog');
      var position = dom_dialog.position();
      var new_left_offset = position.left - ((width_px - dom_dialog.width())/2);
      dom_dialog.css('width' , width_px+'px').css('left', new_left_offset+'px');
    },

    /**
     * Sets dialog title
     */
    setTitle : function (title) {
     var dom_dialog = $('.ui-dialog .ui-dialog-titlebar span.ui-dialog-title').html(title);
    },

    /**
     * Checks if dialog is open
     */
    isOpen : function () {
      if ($('.ui-dialog').length > 0) {
        return true;
      } else {
        return false;
      }
    }
  };

}();
