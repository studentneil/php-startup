/**
 * Created by neil on 25/04/2017.
 */
// jquery code for initializing various frontend effects/plugins
$(document).ready(function() {
    $(".button-collapse").sideNav({
        closeOnClick: true, // Closes side-nav on <a> clicks, useful for Angular/Meteor
        draggable: true // Choose whether you can drag to open on touch screens
    });
    $('.close-menu').on('click', function(){
        $(this).sideNav('hide');
    });

});
$(window).scroll(function() {
    if ($(document).scrollTop() > 50) {
        $('nav').removeClass('shrink');
    } else {
        $('nav').addClass('shrink');
    }
});
