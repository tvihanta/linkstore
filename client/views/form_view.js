// Generated by CoffeeScript 1.3.3
var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['chaplin','views/base/view', 'models/link', 'text!templates/form.hbs'], function(Chaplin,View, Link, template) {
  'use strict';

  var FormView;
  return FormView = (function(_super) {

    __extends(FormView, _super);

    function FormView() {
      return FormView.__super__.constructor.apply(this, arguments);
    }

    FormView.prototype.template = template;
    FormView.prototype.initialize = function(){
        console.log("formView.initialize");
        FormView.__super__.initialize.apply(this, arguments);
        Chaplin.mediator.subscribe("PopulateEditForm", this.populateForm, this);
    };
    FormView.prototype.afterRender = function(){
        console.log("formView.afterRender");
        FormView.__super__.afterRender.apply(this, arguments);
        
        this.urlInput = $('input#url-input');
        this.titleInput = $('input#title');
        this.tagsInput = $('input#tags');
        this.idInput = $('input#idInput');
        this.submit = $('#save');
        
        //this.delegate("keypress", "input", this.validate);
        //this.delegate("blur", "input", this.validate);
        this.delegate("click", "#save", this.save);
    };
    
    FormView.prototype.populateForm = function(model){
        console.log("formView.populateForm");
        this.$el.remove();
        this.model = model;
        this.render();
    };
    FormView.prototype.save = function(e){
        console.log("formView.save");
        this.submit.data('id')
        var that = this;
        var model = new Link(
                    {
                        id: this.submit.data('id'),
                        url: this.urlInput.val(),         
                        title: this.titleInput.val(),
                        tags: this.tagsInput.val()
                    });
        console.log(model)
        model.save(null, { wait:true,
            success: function(){
                console.log("success");
                 that.refresh();
                 Chaplin.mediator.publish('refreshAll');
            },
            error: function(e){
                 console.log(e);
            }
        });
    };
    FormView.prototype.validate = function(e){
        console.log("formView.validate");
        var input = $(e.currentTarget);
        var valid = false;
        if (e.currentTarget.id === "url-input"){
           //console.log(input.val().length);
           //valid = (input.val().length > 0) ? true : false;
           valid = (input.val().indexOf('http://') != -1) ? true : false;
        }
        if(valid) {this.submit.removeAttr('disabled'); }
        else { this.submit.attr('disabled', 'disabled'); }
        
    };
    FormView.prototype.className = 'link-form';
    FormView.prototype.container = '#form-container';
    FormView.prototype.autoRender = true;

    return FormView;

  })(View);
});
