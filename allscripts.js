$(document).ready(function () {
        $(function() {
    // Highlight the active nav link.
    var url = window.location.pathname;
    var filename = url.substr(url.lastIndexOf('/') + 1);
    $('.navbar a[href$="' + filename + '"]').parent().addClass("active");
});
    });
