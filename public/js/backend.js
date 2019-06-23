// backend js for various materialize components
$(document).ready(function() {
    $(".button-collapse").sideNav({
        closeOnClick: true,
        draggable: true
    });
    $('.close-menu').on('click', function(){
        $(this).sideNav('hide');
    });

    $('.dropdown-button').dropdown({
            inDuration: 300,
            outDuration: 400,
            constrain_width: false, // Does not change width of dropdown to that of the activator
            hover: false, // Activate on hover
            gutter: 0, // Spacing from edge
            belowOrigin: true, // Displays dropdown below the button
            alignment: 'left' // Displays dropdown with edge aligned to the left of button
        }
    );

    $('select').material_select();

    $('[data-toggle="datepicker"]').datepicker({
        format: 'yyyy-mm-dd',
    });

    $('#createReleaseFromDiscogs').on('click', function(event) {
        event.preventDefault();
        let artist = $(this).data('artist');
        let title = $(this).data('title');
        let released = $(this).data('released');
        let label = $(this).data('label');
        let catalogueNumber = $(this).data('catalogueNumber');
        let barcode = $(this).data('barcode');

        $('#create_new_release_catno').val(catalogueNumber);
        $('#create_new_release_artist').val(artist);
        $('#create_new_release_title').val(title);
        $('#create_new_release_released_on').focus();
        $('#create_new_release_released_on').val(released);
        $('#create_new_release_label').val(label);
        $('#create_new_release_barcode').focus();
        $('#create_new_release_barcode').val(barcode);
    });
});
