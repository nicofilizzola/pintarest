/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './scss/main.scss';

// start the Stimulus application
//import './bootstrap';
//import 'bootstrap';
//import $ from 'jquery';
const $ = require('jquery');
require('bootstrap');

/*
 * APP
 */
$('.vich-image .custom-file-input').on('change', function(event){
    var fileInput = event.currentTarget;
    $(fileInput).parent().find('label').html(fileInput.files[0].name);
})
