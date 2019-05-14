/**
 * Created by jomeravengoza on 4/22/16.
 */

$(document).on('click', '.next-step', function(){
    var thisElement = $(this);
    var next = thisElement.data('target');

    $('a[href='+next+']').click();
    return false;
});


$(document).on('click', '.back-step', function(){
    var thisElement = $(this);
    var back = thisElement.data('target');

    $('a[href='+back+']').click();
    return false;
});

$(document).on('change', '#firstName, #lastName, #username, #companyName, #phone, #address, #businessName, #entryFee, #globalPool, #maxPair', function(){

    $('#nameLabel').text( $('#firstName').val() + ' ' + $('#lastName').val());

    $('#usernameLabel').text( $('#username').val() );
    $('#companyNameLabel').text( $('#companyName').val() );
    $('#phoneLabel').text( $('#phone').val() );
    $('#addressLabel').text( $('#address').val() );
    $('#businessNameLabel').text( $('#businessName').val() );
    $('#entryFeeLabel').text( $('#entryFee').val() );
    $('#globalPoolLabel').text( $('#globalPool').val() );
    $('#maxPairLabel').text( $('#maxPair').val() );

}).trigger('change');