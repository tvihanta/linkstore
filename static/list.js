App.ListContactsView = Ember.View.extend({
  templateName:    'templates/links/list',
  contactsBinding: 'App.LinksController',

  //showNew: function() {
    //this.set('isNewVisible', true);
  //},

  //hideNew: function() {
    //this.set('isNewVisible', false);
  //},

  refreshListing: function() {
    App.LinksController.findAll();
  }
});
