// Generated by CoffeeScript 1.3.3
var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['handlebars', 'chaplin', 'lib/view_helper'], function(Handlebars, Chaplin) {
  'use strict';

  var View;
  return View = (function(_super) {

    __extends(View, _super);

    function View() {
      return View.__super__.constructor.apply(this, arguments);
    }
    
    View.prototype.initialize = function(){
        Chaplin.mediator.subscribe("refreshView", this.refresh, this);
        View.__super__.initialize.apply(this, arguments);
    };

    View.prototype.getTemplateFunction = function() {
      var template, templateFunc;
      template = this.template;
      if (typeof template === 'string') {
        templateFunc = Handlebars.compile(template);
        this.constructor.prototype.template = templateFunc;
      } else {
        templateFunc = template;
      }
      return templateFunc;
    };
    
   /* View.prototype.render = function() {
      console.log("base.view.render")
      var that = this;
      try{
        this.collection.fetch({success: function(){
            console.log("success");
            View.__super__.render.apply(that, arguments);
            console.log(that.template);
            return that;
        },
        error: function(e){
            console.log(e);
            View.__super__.render.apply(that, arguments);
            return that;
        }
        });
      }catch(e){
        console.log(e);
        View.__super__.render.apply(that, arguments);
        return that;
      }
      
    };*/
    
    View.prototype.refresh = function(refreshCollection){
    
         if(typeof refreshCollection === "undefined") refreshCollection = true;
         console.log("refr"+refreshCollection);
         var that = this;
         if(typeof this.collection != "undefined" && refreshCollection){
              this.collection.fetch({
                 success: function(){
                   that.$el.remove(); 
                   that.render();
                },
                error: function(e){
                    console.log(e);
                    that.$el.remove(); 
                    that.render();
                }
            });
         }
         else if (typeof this.model != "undefined"){
              that.model = new that.model.constructor();
              that.$el.remove();
              that.render();
         }
         else{
            that.$el.remove();
              that.render();
         }
    };

    return View;

  })(Chaplin.View);
});
