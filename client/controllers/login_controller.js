
define([
  'chaplin', 
  'controllers/base/controller',
  'models/link_collection', 
  'views/linksy_view', 
  'views/login_view'], function(Chaplin, Controller, LinkCollection, LinksyView, LoginView) {
  'use strict';

  var LinksyController = Controller.extend({
    login :function(params){
      console.log("controller.linsky.login");
      this.view = new LoginView();
      return this;
    }
  });

  return LinksyController;
});
