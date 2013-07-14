define(['chaplin',
        'views/base/view',
         'lib/utils',
         'models/link',
         'text!templates/link.hbs'], function(Chaplin,View, utils,LinkModel, template) {
  'use strict';

  var LinkView = View.extend({
    template: template,
    autoRender:true,
    initialize:function(options){
      LinkView.__super__.initialize.apply(this, arguments);
      this.delegate("click", ".remove-link", this.removeLink);
    },
    removeLink : function(e){
      this.model.destroy({success:function(){
        console.log("succesful delete");
      }});
    }
  });
  return LinkView;
});