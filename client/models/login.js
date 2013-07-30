define([
  'models/base/model'
], function(Model) {
  'use strict';

  var User = Model.extend({
      idAttribute: "token",
      url : baseUri+"backend/index.php/login",
      parse:function (req) {
        return req[0];
      }
  });

  return User;
});
