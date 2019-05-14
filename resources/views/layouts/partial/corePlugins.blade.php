



<script src="{{ url('public/assets/global/plugins/bower_components/jquery-cookie/jquery.cookie.js') }}"></script>
<script src="{{ url('public/assets/global/plugins/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ url('public/assets/global/plugins/bower_components/jquery-easing-original/jquery.easing.1.3.min.js') }}"></script>
<script src="{{ url('public/assets/global/plugins/bower_components/ionsound/js/ion.sound.min.js') }}"></script>
<script src="{{ url('public/assets/global/plugins/bower_components/waypoints/lib/jquery.waypoints.min.js') }}"></script>
<script src="{{ url('public/assets/global/plugins/bower_components/counter-up/jquery.counterup.js') }}"></script>
<script src="{{ url('public/assets/global/plugins/bower_components/bootbox.js/bootbox.js') }}"></script>
<script src="{{ url('public/assets/global/plugins/bower_components/fontawesome-free-5.0.8/svg-with-js/js/fontawesome-all.js') }}"></script>
<script src="{{ url('public/plugins/datepicker/js/moment.js') }}"></script>
<script src="{{ url('public/plugins/datepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
{{ Html::script('public/assets/global/plugins/bower_components/jquery-nicescroll/jquery.nicescroll.min.js') }}

{{ Html::script('public/assets/global/plugins/bower_components/datatables/js/jquery.dataTables.min.js') }}
{{ Html::style('public/assets/global/plugins/bower_components/datatables/css/jquery.dataTables.min.css') }}
<script src="{{ url('public/assets/global/plugins/bower_components/jasny-bootstrap-fileinput/js/jasny-bootstrap.fileinput.min.js') }}"></script>
{{ Html::script('public/assets/admin/js/apps.js') }}
{{ Html::script('public/assets/admin/js/demo.js') }}

{{ Html::style('public/assets/global/plugins/bower_components/chosen_v1.2.0/chosen.min.css') }}
{{ Html::script('public/assets/global/plugins/bower_components/chosen_v1.2.0/chosen.jquery.min.js') }}

<div id="binarymodal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- dialog body -->
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 id="modal-title" class="pull-left"></h4>
                <div class="clearfix"></div>
            </div>
            <div class="custom-content"></div>
            <div class="clearfix"></div>
            <!-- dialog buttons -->
            <div class="modal-footer"><button type="button" class="btn btn-primary modal-close">Close</button></div>
        </div>
    </div>
</div>