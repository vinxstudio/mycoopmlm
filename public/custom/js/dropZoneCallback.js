/**
 * Created by POA on 4/9/17.
 */

var dropzoneCustom = $('#dropzone-custom');
var options = {
    acceptedFiles: ".jpg,.JPEG,.png,.PNG,.JPG",
    url: dropzoneCustom.attr('action'),
    addRemoveLinks: true,
    maxFiles: 1,
    init: function () {
        this.on("success", function (file, response) {
            this.response = response;

            swal('Done!', response.message, response.status);
            if (response.status == 'success'){
                location.reload();
            }
        });
        this.on("complete", function (file) {

            if (this.response != undefined) {
                // Add Custom Remove Button
                var photo_remover = '<button data-src="' + this.response.path + '" class="dropzone-preview-remover"><i class="fa fa-close text-danger"></i></button>';
                $(file.previewElement).find('.dz-remove').html(photo_remover).addClass('remove-temp-file');
            }

            if (file.status == "error") {
                $(file.previewTemplate).remove();
                //var error_message = $(file.previewTemplate).find('.dz-error-message span').html();
                // Remove Preview Of image with errors
                dropzoneCustom.removeClass('dz-started');
                swal('Oops!', 'Something went wrong', 'error');
            }
        });
        this.on("removedfile", function (file) {

        });
    }
};

Dropzone.autoDiscover = false;
myDropzone = new Dropzone("#dropzone-custom", options);