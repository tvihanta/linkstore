// Generated by CoffeeScript 1.3.3
var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['chaplin', 'models/base/collection'], function(Chaplin, Collection) {
  'use strict';

  var Tags;
  return Tags = (function(_super) {

    __extends(Tags, _super);

    function Tags() {
      return Tags.__super__.constructor.apply(this, arguments);
    }
    Tags.prototype.url = baseUri+"backend/index.php/tags";

    return Tags;

  })(Collection);
});
