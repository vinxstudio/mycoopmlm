var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

var bower_path = '../../../public/assets/global/plugins/bower_components';
var admin_assets = '../../../public/assets/admin';

elixir(function(mix) {
    mix.less('../../../public/assets/less/app.less', 'public/theme/css/app.css');


    mix.styles([
        '../../../public/assets/fonts/open-sans.css',
        '../../../public/assets/fonts/oswald.css',
        bower_path + '/bootstrap/dist/css/bootstrap.min.css',
        bower_path + '/bootstrap/dist/css/bootstrap-theme.min.css',

        bower_path + '/bootstrap-calendar/css/calendar.min.css',
        bower_path + '/bootstrap-datepicker-vitalets/css/datepicker.css',

        bower_path + '/bootstrap-daterangepicker/daterangepicker.css',
        bower_path + '/bootstrap-fileupload/css/bootstrap-fileupload.min.css',
        bower_path + '/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css',
        bower_path + '/bootstrap-tagsinput/dist/bootstrap-tagsinput.css',
        bower_path + '/fontawesome/css/font-awesome.min.css',
        bower_path + '/fontawesome/css/mixins.css',
        bower_path + '/fontawesome/css/variables.css',
    ], 'public/theme/css/bootstrap.css');

    mix.scripts([
        bower_path + '/bootstrap/dist/js/bootstrap.min.js',
        bower_path + '/bootstrap-calendar/js/calendar.min.js',
        bower_path + '/bootstrap-calendar/js/app.js',
        bower_path + '/bootstrap-daterangepicker/daterangepicker.js',
        bower_path + '/bootstrap-fileupload/js/bootstrap-fileupload.min.js',
        bower_path + '/bootstrap-maxlength/bootstrap-maxlength.min.js',
        bower_path + '/bootstrap-switch/dist/js/bootstrap-switch.min.js',
        bower_path + '/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js',
        bower_path + '/jquery-smooth-scroll/jquery.smooth-scroll.min.js',
        bower_path + '/textarea-autosize/jquery.autosize.min.js',
        bower_path + '/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js'
    ], 'public/theme/js/bootstrap.js');

    mix.scripts([
        bower_path + '/blockui/jquery.blockUI.js',
        bower_path + '/bootbox/bootbox.js',
        bower_path + '/Bootflat/bootflat/js/icheck.min.js',
        bower_path + '/Bootflat/bootflat/js/jquery.fs.selecter.min.js',
        bower_path + '/Bootflat/bootflat/js/jquery.fs.stepper.min.js',
        bower_path + '/chosen_v1.2.0/chosen.jquery.min.js',
        bower_path + '/counter-up/jquery.counterup.min.js',
        bower_path + '/datatables/js/jquery.dataTables.min.js',
        bower_path + '/datatables/js/dataTables.bootstrap.js',
        bower_path + '/datatables/js/datatables.responsive.js',
        bower_path + '/dropzone/downloads/dropzone.min.js',
        bower_path + '/eventEmitter/eventEmitter.min.js',
        bower_path + '/eventie/eventie.js',

        bower_path + '/holderjs/holder.js',
        bower_path + '/ionsound/js/jquery.ion.sound.min.js',
        bower_path + '/ionsound/js/ion.sound.min.js',
        bower_path + '/jpreloader/js/jpreloader.min.js',

        bower_path + '/typehead.js/dist/typeahead.bundle.min.js',
        bower_path + '/typehead.js/dist/bloodhound.min.js',

    ], 'public/theme/js/theme.js');

    mix.styles([
        bower_path + '/animate.css/animate.min.css',
        bower_path + '/Bootflat/bootflat/css/bootflat.min.css',
        bower_path + '/chosen_v1.2.0/chosen.min.css',
        bower_path + '/datatables/css/jquery.dataTables.min.css',
        bower_path + '/datatables/css/select.dataTables.min.css',
        bower_path + '/datatables/css/editor.dataTables.min.css',
        bower_path + '/datatables/css/dataTables.bootstrap.css',
        bower_path + '/datatables/css/buttons.dataTables.min.css',
        bower_path + '/dropzone/downloads/css/dropzone.css',
        bower_path + '/jasny-bootstrap-fileinput/css/jasny-bootstrap-fileinput.min.css',
        bower_path + '/jpreloader/css/jpreloader.css',
    ], 'public/theme/css/theme.css');

    mix.scripts([
        bower_path + '/jquery/dist/jquery.min.js',
        bower_path + '/jquery-cookie/jquery.cookie.js',
        bower_path + '/jquery-nicescroll/jquery.nicescroll.min.js',
    ], 'public/theme/js/jquery.js');

    mix.styles([
        admin_assets + '/css/components.css',
        admin_assets + '/css/plugins.css',
        admin_assets + '/css/reset.css'
    ], 'public/theme/css/components.css');

    mix.styles([
        admin_assets + '/css/layout.css',
        admin_assets + '/css/theme.css'
    ], 'public/theme/css/layout.css');

    mix.scripts([
        admin_assets + '/js/apps.js',
        admin_assets + '/js/demo.js',
    ], 'public/theme/js/mainapp.js');

});
