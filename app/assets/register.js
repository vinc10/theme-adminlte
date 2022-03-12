// ------ jquery and bootstrap basics ------
// create global $ and jQuery variables
const $ = require('jquery');
global.$ = global.jQuery = $;

global.getSlug = require('speakingurl');
require('jquery-validation');
require('./userfrosting/js/fortress-jqueryvalidation-methods');
require('./userfrosting/js/attrchange');
// require('./userfrosting/js/uf-alerts');
require('./userfrosting/js/uf-form');
require('./userfrosting/js/uf-modal');
// require('./userfrosting/js/uf-copy');
// require('./userfrosting/js/uf-init');
require('./userfrosting/js/uf-captcha');
require('./userfrosting/js/pages/register');