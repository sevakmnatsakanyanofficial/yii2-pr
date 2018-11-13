$(document).ready(function () {

    $('#btn-about, #btn-contact-us, #btn-how-it-works').on('click', function () {
        var btnId = this.id;
        var elementId = btnId.replace('btn-', '');
        $('#' + elementId).click();
    });

    $('#about, #contact-us, #how-it-works').on('click', function () {
        $('html, body').animate({
            scrollTop: $(this).offset().top,
        }, 2000)
    });

    // toggle class scroll
    $(window).scroll(function() {
        if($(this).scrollTop() > 50) {
            $('.navbar-trans').addClass('afterscroll');
        } else {
            $('.navbar-trans').removeClass('afterscroll');
        }
    });
});