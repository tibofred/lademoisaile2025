// main.js

// var $ = require('jquery');
// JS is equivalent to the normal "bootstrap" package
// no need to set this to a variable, just require it

/* fix for https://github.com/symfony/webpack-encore/pull/54 */
global.$ = global.jQuery = require('jquery');

// require('google-map');
require('bootstrap');
require('../css/global.scss');
require('../../web/assets/scss/_custom.scss');


// or you can include specific pieces
// require('bootstrap-sass/javascripts/bootstrap/tooltip');
// require('bootstrap-sass/javascripts/bootstrap/popover');

$(document).ready(function () {
    $('[data-toggle="popover"]').popover();
});
