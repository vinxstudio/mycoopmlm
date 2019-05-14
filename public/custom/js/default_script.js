/**
 * Created by jomeravengoza on 4/23/16.
 */

function modal(title, element){
    title = title || "no title";
    var content = $(element).html();
    $('#binarymodal').find('#modal-title').html(title);
    $('#binarymodal').find('.custom-content').html(content);
    $("#binarymodal").modal({
        "backdrop"  : "static",
        "keyboard"  : true,
        "show"      : true
    });
}

$(function(){

    var summernoteElement = $('.summernote-element');

    $('.chosen-select').chosen();

    $('.datatable').dataTable();

    $('.change-photo').click(function(){

        var changePanel = $('.change-photo-panel');
        var photoPanel = $('.photo-panel');

        photoPanel.addClass('hidden');
        changePanel.removeClass('hidden');
        return false;

    });

    $('.cancel-change-photo').click(function(){

        var changePanel = $('.change-photo-panel');
        var photoPanel = $('.photo-panel');

        photoPanel.removeClass('hidden');
        changePanel.addClass('hidden');
        return false;

    });

    if ( summernoteElement.length > 0 ){
        summernoteElement.summernote({
            toolbar: [
                [ 'style', [ 'style' ] ],
                [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
                [ 'fontname', [ 'fontname' ] ],
                [ 'fontsize', [ 'fontsize' ] ],
                [ 'color', [ 'color' ] ],
                [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
                [ 'table', [ 'table' ] ],
                [ 'insert', [ 'link'] ],
                [ 'view', [ 'undo', 'redo', 'help' ] ]
            ]
        });
    }

    $('.counter').counterUp({
        delay: 20,
        time: 2000
    });
    $('.dataTable').dataTable();

    $('.modal-close').click(function(){
        $(this).closest('.modal').modal('hide');
    });

});