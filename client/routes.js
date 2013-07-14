define(function() {
  'use strict';
  return function(match) {
    match('login', 'login#login');
    match('all', 'linksy#show');
    match('show/:tag', 'linksy#showTag');
    return match('all', 'linksy#show');
  };
});
