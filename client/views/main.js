define(['chaplin','views/base/view', 'lib/utils','text!templates/main.hbs'], 
    function(Chaplin,View, utils,template) {
  'use strict';

  var MainView = View.extend({
    container: '#main-container',
    template: template,
    containerMethod: "html",
    autoRender:true,
     regions: {
        'form':    '#form-container',
        'links':   '#links-container',
        'filters': '#filter-container',
        'tags' :   '#tag-container'
    },
    initialize:function () {
          MainView.__super__.initialize.apply(this, arguments);
          console.log("init main");  
    }    
  });
  return MainView;
});
