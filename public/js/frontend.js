/**
 * Created by neil on 25/04/2017.
 */
// jquery code for initializing various frontend effects/plugins
$(document).ready(function() {
    $('.button-collapse').sideNav({
        // closeOnClick: true, // Closes side-nav on <a> clicks, useful for Angular/Meteor
        draggable: true // Choose whether you can drag to open on touch screens

    });
    $('.close-menu').on('click', function(){
        $(this).sideNav('hide');
    });
    $('.modal').modal({
            dismissible: true, // Modal can be dismissed by clicking outside of the modal
            opacity: .5, // Opacity of modal background
            inDuration: 300, // Transition in duration
            outDuration: 200, // Transition out duration
            startingTop: '4%', // Starting top style attribute
            endingTop: '10%' // Ending top style attribute
        }
    );
    $('#preLoader').hide();
    $('#contactForm').submit( function(e) {
        e.preventDefault();
        var url = $(this).attr('action');
        var formSerialize = $(this).serializeArray();
        $('#preLoader').show();
        $('#contactSubmit').hide();
        $.ajax({
            type: $(this).attr('method'),
            url: url,
            data: formSerialize,

            success: function (response)
            {
                $('#preLoader').hide();
                $('#contactSubmit').show();
                $('#contactForm')[0].reset();
                console.log(response);
                $('#message').html('<p>' + response + '</p>')
            },
            error: function(response)
            {
                $('#preLoader').hide();
                $('#contactSubmit').show();
               console.log(response);
                $('#message').html('<p>' + response + '</p>');
            }
            })
        }
    );
    $('#randomiser').on('click', function (e) {
        e.preventDefault();
        // alternative way to call the randomise function
        // $.get( '/randomise', function( data ) {
        //     $( '#randomRelease' ).html( data );
        // });

        var success = function( resp ) {
                console.log(resp);
                $('#randomRelease').html(resp);
        };
        var err = function( req, status, err ) {
            console.log(status);
            $('#randomRelease').html(status);
        };
        $.ajax({
            type: 'get',
            url: '/randomise'
            // dataType: 'json'
        }).done(success).fail(err);
    });
    Snipcart.subscribe('item.added', function (item) {

        var success = function(resp) {
            console.log(resp);
        };
        var err = function (req, status, err) {
            console.log(status);
        };
        $.ajax({
            type: 'post',
            url: '/events/item-added',
            data: item
        }).done(success).fail(err);
    });

    $('.details').on('click', function () {

        var item = $(this).closest('.details').attr('href');
        var title = $(this).closest('a').data('title');
        sessionStorage.setItem('link', item);
        sessionStorage.setItem('anchor', title);
    });

    $('.recent-item').html($('<a>', {href: sessionStorage.getItem('link'), text: sessionStorage.getItem('anchor'), class: 'collection-item'}));

    var barcode = $('#barcode').text();
    // console.log(barcode);
    $('#barcode').JsBarcode(barcode);
});

