// ------ jquery and bootstrap basics ------
// create global $ and jQuery variables
const $ = require('jquery');
global.$ = global.jQuery = $;

global.getSlug = require('speakingurl');
require('./userfrosting/js/uf-captcha');
require('./userfrosting/js/pages/register');