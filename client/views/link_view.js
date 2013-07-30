define(['chaplin',
        'views/base/view',
         'lib/utils',
         'models/link',
         'text!templates/link.hbs'], function(Chaplin,View, utils,LinkModel, template) {
  'use strict';

  var LinkView = View.extend({
    template: template,
    autoRender:true,
    className:"row-fluid",
    initialize:function(options){
      LinkView.__super__.initialize.apply(this, arguments);
      this.model.bind("change", this.render, this);
      this.delegate("click", ".remove-link", this.removeLink);
      this.delegate("click", ".edit-link", function (e) {
            Chaplin.mediator.publish("link:edit", this.model);
      });
    },
    removeLink : function(e){
      console.log(this.model.id);
      console.log(this.model.url);
      this.model.destroy({success:function(){
        console.log("succesful delete");
      }});
    }
  });
  return LinkView;
});