<style>.modal-backdrop{position: unset;}</style>
<div id="flushout_modal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Flushout Details</h4>
      </div>
      <div class="modal-body">
            <div class='col-md-3 col-md-offset-9'>
                <?php
                    $date_from = (!empty($date_from))? $date_from:'0';
                    $date_to = (!empty($date_to))? $date_to:'0';
                ?>
            <div class="form-group pull-right">
                <label>&nbsp;</label>
                <div class='input-group date'>
                    <a class="btn btn-success pull-right" href="{{ url('/admin/export-flushout/xlsx/'.$date_from.'/'.$date_to) }}"><i class="fas fa-download"></i> Download Flushout History Reports</a>
                </div>
            </div>
        </div>
          <table class="table table-bordered table-hover table-striped" id="flushout_table">
            <col width="30%;">
            <col width="30%;">
            <col width="10%;">
            <col width="10%;">
            <col width="20%;">
              {{-- <col width="5%;"> --}}
              <?php 
                  $total_amount = 0;
              ?>
              <thead>
                  <tr>
                      <th>Left Account ID.</th>
                      <th>Right Account ID.</th>
                      <th>Source</th>
                      <th>Amount</th>
                      <th>Pairing Date</th>
                  </tr>
              </thead>
              <tbody>
              </tbody>
              <tfoot>
                    <div id="paginate"></div>
              </tfoot>
          </table>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->