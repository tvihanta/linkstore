define(['chaplin',
    'views/base/collection-view', 
    'lib/utils',
    'views/link_view',
    'text!templates/links.hbs'], 
    function(Chaplin,View, utils, LinkView, template) {
  'use strict';

  var LinksView = View.extend({
    template: template,
    className:'links',
    itemView:LinkView,
    listSelector: "#link-list",
    autoRender:true,
    initialize :function(){
          LinksView.__super__.initialize.apply(this, arguments);
        console.log("linksview.initialize");
        Chaplin.mediator.subscribe("refreshAll", function(){this.refresh();}, this);
        this.delegate("click", ".remove-link", this.removeLink);
        this.delegate("click", ".edit-link", function(e){
            var model = this.collection.get($(e.currentTarget).data('id'));
            Chaplin.mediator.publish("PopulateEditForm", model);
        });
        var that = this;
    },
    removeLink : function(e){
        console.log("removeLink");
        var link = $(e.currentTarget);
        var linkId = link.data('id');
        var modl = this.collection.get(linkId);
        console.log(modl);
        var that = this;
         modl.destroy({success:function(){
            console.log(that.collection);
            that.refresh(true);
            //Chaplin.mediator.publish("refreshView");
        }});
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
  return LinksView;
});
