/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../scss/app.scss');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
const $ = require('jquery');
global.$ = global.jQuery = $;

require('bootstrap'); // Bootstrap Javascript (All)

require('./ad.js');
require('./chart.chartjs.js');
require('./chart.flot.js');
require('./chart.morris.js');
require('./chart.rickshaw.js');
require('./chart.sparkline.js');
require('./dashboard.js');
require('./jquery.vmap.sampledata.js');
require('./map.apple.js');
require('./map.bluewater.js');
require('./map.mapbox.js');
require('./map.shadesofgray.js');
require('./map.shiftworker.js');
require('./ResizeSensor.js');
require('./starlight.js');
require('./widgets.js');
require('./bootstrap-datepicker.min.js');

// console.log('Hello Webpack Encore! Edit me in assets/js/app.js');
