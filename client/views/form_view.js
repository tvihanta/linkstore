
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
        this.delegate("click", "#save", this.save);
        Chaplin.mediator.subscribe("link:edit", this.populateEditForm, this);
    },
    clearForm:function(){
        this.$('input#url-input').val("");
        this.$('input#title').val("");
        this.$('input#tags').val("");
        this.$('input#idInput').val("");
        this.$('#save').data('id', null);
    },
    populateEditForm:function (mdl) {
        this.model = mdl;
        this.render();
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
        model.url = baseUri+"backend/index.php/links";
        model.save(params, { 
            success: function(mdl, res, opts){
                that.clearForm();
                that.collection.add(new Link(mdl.attributes), {at:0, merge:true});
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

