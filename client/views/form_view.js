
define(['chaplin','views/base/view', 
        'models/link', 'text!templates/form.hbs'], 
        function(Chaplin,View, Link, template) {
  'use strict';

  var FormView = View.extend({
    className : 'link-form',
    id: 'site-container',
    template: template,
    autoRender:true,
    initialize :function(){
        FormView.__super__.initialize.apply(this, arguments);
        Chaplin.mediator.subscribe("PopulateEditForm", this.populateForm, this);
        this.delegate("click", "#save", this.save);
    },
    clearForm:function(){
        this.$('input#url-input').val("");
        this.$('input#title').val("");
        this.$('input#tags').val("");
        this.$('input#idInput').val("");
    },
    save :function(e){
        console.log("formView.save");
        this.urlInput = this.$('input#url-input');
        this.titleInput = this.$('input#title');
        this.tagsInput = this.$('input#tags');
        this.idInput = this.$('input#idInput');
        this.submit = this.$('#save');

        var id = this.submit.data('id')
        var params =  {
                        url: this.urlInput.val(),         
                        title: this.titleInput.val(),
                        tags: this.tagsInput.val()
                    };
        if(id !== undefined && id != ""){
           params.id = id; 
        }
        var that = this;
        var model = new Link( params );
        model.save(params, { 
            success: function(mdl){
                that.clearForm();
                that.collection.add(mdl, {at:0});
            },
            error: function(e){
                 console.log(e);
            }
        });
    },
    validate : function(e){
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
        
    }  
  });
  return FormView;
});

