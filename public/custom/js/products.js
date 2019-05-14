/**
 * Created by jomeravengoza on 4/23/16.
 */

$(document).on('keyup', '#productPrice', function(){

    var thisVal = $(this).val();

    console.log(isNaN(thisVal));
    if (isNaN(thisVal)){

        $('#globalPoolPercentage').attr('disabled', 'disabled');
        $('#globalPoolCompute').text('');

        $('#rebatesPercentage').attr('disabled', 'disabled');
        $('#rebatesCompute').text('');

    } else {

        $('#globalPoolPercentage').removeAttr('disabled');
        $('#rebatesPercentage').removeAttr('disabled');
        computeProductPercentage();

    }

});

$('#productPrice').keyup();

$(document).on('keyup', '#globalPoolPercentage, #rebatesPercentage', function(){
    computeProductPercentage();
});

function computeProductPercentage(){

    var product = $('#productPrice');
    var globalPool = $('#globalPoolPercentage');
    var rebatesPercentage = $('#rebatesPercentage');

    var globalPoolLabel = $('#globalPoolCompute');
    var rebatesLabel = $('#rebatesCompute');

    if (globalPool.val() > 0 && !isNaN(globalPool.val())){

        var comp = (globalPool.val() / 100) * product.val();
        globalPoolLabel.text( comp );

    }

    if (rebatesPercentage.val() > 0 && !isNaN(rebatesPercentage.val())){

        var ncomp = (rebatesPercentage.val() / 100) * product.val();

        rebatesLabel.text(ncomp);

    }

}