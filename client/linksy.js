
define(['chaplin', 
        'views/layout', 
        'routes', 
       ], function(Chaplin, Layout, routes) {
  'use strict';

  // The application object
  // Choose a meaningful name for your application
  var LinksyApp = Chaplin.Application.extend({
    // Set your application name here so the document title is set to
    // “Controller title – Site title” (see Layout#adjustTitle)
    title: 'Chaplin Example Application',
    initialize : function() {
      
      var token = $.cookie("linksy-token");
      if(!token || token === undefined){
        window.location.href="#login";
      }

      this.initMediator();

      $.ajaxSetup({
         headers: { 'linksy-token': token }
      });
      Chaplin.mediator.globals.token = token;

      this.initDispatcher();
      this.initLayout();
     // this.initControllers();
      
      var routerOptions = {
                    pushState:false
                };
                // Register all routes and start routing
      this.initRouter(routes, routerOptions);
      this.startRouting();
    },

   /* initLayout : function() {
      return this.layout = new Layout({
        title: this.title
      });
    };*/

   /* initControllers : function() {        
        return;
    };
  */
    initMediator : function() {
      Chaplin.mediator.user = null;
      Chaplin.mediator.globals = {};
     // return Chaplin.mediator.seal();
    }

  });

  return LinksyApp;
});

