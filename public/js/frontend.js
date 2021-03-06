/**
 * Created by neil on 25/04/2017.
 */
// jquery code for initializing various frontend effects/plugins
$(document).ready(function () {
    $('.dont-show').css('display', 'none');
    $('.button-collapse').sideNav({
        // closeOnClick: true, // Closes side-nav on <a> clicks, useful for Angular/Meteor
        draggable: true // Choose whether you can drag to open on touch screens

    });
    $('.close-menu').on('click', function () {
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
    $('#contactForm').submit(function (e) {
        e.preventDefault();
        var url = $(this).attr('action');
        var formSerialize = $(this).serializeArray();

        var success = function (response, status, jqxhr) {
            $('#preLoader').hide();
            $('#contactSubmit').show();
            $('#contactForm')[0].reset();
            console.log(response);
            $('#message').html('<p>' + response + '</p>')
        };

        var error = function (request, status, error) {
            $('#preLoader').hide();
            $('#contactSubmit').show();
            console.log(status);
        };

        $('#preLoader').show();
        $('#contactSubmit').hide();

        $.ajax({
            type: $(this).attr('method'),
            url: url,
            data: formSerialize,
            statusCode: {
                500: function () {
                    $('#message').html('<p>Gotcha!</p>');
                    $('#contactForm').trigger('reset')
                }
            }
        }).done(success).fail(error);
    });
    $('#randomiser').on('click', function (e) {
        e.preventDefault();
        // alternative way to call the randomise function
        // $.get( '/randomise', function( data ) {
        //     $( '#randomRelease' ).html( data );
        // });

        var success = function (resp) {
            console.log(resp);
            $('#randomRelease').html(resp);
        };
        var err = function (req, status, err) {
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

        var success = function (resp) {
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
        let item = {};
        item.link = $(this).closest('.details').attr('href');
        item.title = $(this).closest('a').data('title');

        let storageArray = getStorageArray();
        storageArray.push(item);
        sessionStorage.setItem('last-viewed-items', JSON.stringify(storageArray));
    });

    let recentItemsObject = sessionStorage.getItem('last-viewed-items');
    let recentItemsArray = new Array();
    if (recentItemsObject === null) {
        $('<a>', {
            text: 'You have no recently viewed Items',
            class: 'collection-item disabled'
        }).appendTo($('.recent-item'));
    } else {
        recentItemsArray = JSON.parse(recentItemsObject);
    }

    if (recentItemsArray.length > 0) {
        recentItemsArray.forEach(function (item) {
            $('<a>', {
                href: item.link,
                text: item.title,
                class: 'collection-item'
            }).appendTo($('.recent-item'));
        });
    }

    function getStorageArray() {
        let storageArray = new Array();
        let fetchArrayObject = sessionStorage.getItem('last-viewed-items');
        if (fetchArrayObject === null) {
            return storageArray;
        }
        storageArray = JSON.parse(fetchArrayObject);

        return storageArray;
    }

    var barcode = $('#barcode').text();
    // console.log(barcode);
    $('#barcode').JsBarcode(barcode);
});

