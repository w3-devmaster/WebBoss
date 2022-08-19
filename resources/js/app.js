// window.$ = window.jQuery = require('jquery')
require('./bootstrap');

$('input[type="file"]').change(function (e) {
    let id = this.getAttribute('id');
    let fileName = e.target.files[0].name;
    $('.custom-file-label[for="' + id + '"]').html(fileName);
});

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})
$(function () {
    $('[data-toggle="popover"]').popover()
})
