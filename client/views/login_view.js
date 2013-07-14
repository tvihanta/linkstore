define([
         'chaplin',
         'views/base/view',
         'lib/utils',
         'models/login',
         'text!templates/login.hbs'], function(Chaplin,View, utils, LoginModel, template) {
  'use strict';

  var LoginView = View.extend({
    container: '#main-container',
    template: template,
    autoRender:true,
    initialize :function(){
        LoginView.__super__.initialize.apply(this, arguments);
        this.delegate("click", "#login", this.doLogin);
    },
    doLogin:function(e){
        this.usernameInput= this.$('.username');
        this.passwordInput= this.$('.psw');
        var model = new LoginModel({
                                username:this.usernameInput.val(), 
                                psw:this.passwordInput.val()
                                });
        model.save(null,{
            success: function(model, request){
                $.cookie("linksy-token", model.get("token"));
                window.location.href="#all";  

                //Chaplin.mediator.publish('loginStatus', true);
            },
            error: function(req, s, a){
              console.log("error") 
                //Chaplin.mediator.publish('loginStatus', false);
            }
        });
    }
  });
  return LoginView;
});