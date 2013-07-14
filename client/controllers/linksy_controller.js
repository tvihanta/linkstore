
define([
  'chaplin', 
  'controllers/base/controller',
  'models/link_collection', 
  'views/linksy_view', 
  'views/main',
  'views/form_view', 
  'views/login_view'], function(Chaplin, Controller, LinkCollection, 
                                LinksyView, MainView, FormView ,LoginView) {
  'use strict';

  var LinksyController = Controller.extend({
     beforeAction: function() {
      this.compose('main', new MainView());
    },
    show : function(params) {
      console.log("controllers.linksycontroller.init");
      Chaplin.mediator.publish("FilterChange", "All");
      this.collection = new LinkCollection();
      var that = this;
      that.view = new LinksyView({
                region:'links',
                collection: that.collection
             });
      this.formView = new FormView({region:"form", collection:that.collection});

      this.collection.fetch();
      return this;
    },
    showTag : function(params) {
      console.log("controllers.linksycontroller.showtag");  
      Chaplin.mediator.publish("FilterChange", params.tag);
      this.collection = new LinkCollection();
      var that = this;
      this.collection.fetch({data: {tag:params.tag},success:function(){
            return that.view = new LinksyView({
                collection: that.collection
             });
        }, error:function(){
        
        }});
      return this;
    }

  });

  return LinksyController;
});
