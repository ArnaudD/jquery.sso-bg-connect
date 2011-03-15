/**
 *
 */

(function ($){

  var loadIframe = function (service, id) {
    $('body').append ('<iframe id="ssoBgConnect_'+id+'" src="'+service+'" width="1px" height="1px" style="visibility: hidden;"></iframe>');       
  }

  var settings = {
    services: {},
    success: '',
    servicesHandlers: {
      generic: function (serviceConf) {
        loadIframe (serviceConf.service.replace ('{%callback%}', encodeURIComponent (serviceConf.callback)), 1);
      },
      facebook: function (serviceConf) {
        var serviceUrl = 'https://www.facebook.com/login.php?api_key='
            +serviceConf.appId
            +'&v=1.0'
            +'&return_session=1'
            +'&session_version=3'
            +'&next='+encodeURIComponent (serviceConf.callback);
        // TODO handle cancel url
        loadIframe (serviceUrl, 2);
      },
      twitter: function (serviceConf) {
        /* TODO */
      },
    }
  };

  var methods = {

    /**
     * Main method
     */
    connect: function (options) {

      if (options)
        $.extend( settings, options );

      $.each (settings.services, function (index, service) {

        // If a callback has been provided, we'll append additional data
        if (service.callback) {
          if (service.callback == 'self')
            service.callback == document.location.href;
          
          service.callback += (service.callback.search (/\?/) < 0 ? '?' : '&') + 'bgConnect=1';
        }

        // call the appropriate service handler
        if (settings.servicesHandlers [service.service])
          settings.servicesHandlers [service.service] (service);
        else 
          settings.servicesHandlers.generic (service);

      });

    },

    /**
     * Method called once the user has been authenticated
     */
    finishAuthentication: function (data) { 
      if (typeof settings.success === 'function')
        settings.success (data);
      else if (typeof settings.success.length > 0)
        document.location.href = settings.success ;
      else
        history.go(0);
    },
  };

  $.ssoBgConnect = function (method) {
    
    if ( methods [method] ) {
      return methods [method].apply (this, Array.prototype.slice.call (arguments, 1));
    } else if (typeof method === 'object' || ! method) {
      return methods.connect.apply (this, arguments);
    } else {
      $.error ('Method ' +  method + ' does not exist on jQuery.ssoBgConnect');
    }    
  
  };

}) (jQuery);
