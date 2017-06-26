/**
 * Created by neil on 25/04/2017.
 */
// jquery code for initializing various frontend effects/plugins
$(document).ready(function() {
    $('.button-collapse').sideNav({
        // closeOnClick: true, // Closes side-nav on <a> clicks, useful for Angular/Meteor
        draggable: true, // Choose whether you can drag to open on touch screens

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
            endingTop: '10%', // Ending top style attribute
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
                console.log(response)
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
        )

});

