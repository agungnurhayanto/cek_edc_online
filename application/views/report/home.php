<div class="msg" style="display:none;">
          <?php echo @$this->session->flashdata('msg'); ?>
</div>

<div class="box">
          <div class="box-header">

                    <div class="col-md-6">
                              <a href="<?php echo base_url('Report/export'); ?>" class="form-control btn btn-warning"><i
                                                  class="glyphicon glyphicon glyphicon-floppy-save"></i> Export Data
                                        Excel</a>
                    </div>
                    <div class="col-md-3">
                              <!--  <button class="form-control btn btn-default" data-toggle="modal" data-target="#import-report"><i
                              class="glyphicon glyphicon glyphicon-floppy-open"></i> Import Data Excel</button> -->
                    </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
                    <table id="list-data" class="table table-bordered table-striped">
                              <thead>
                                        <tr>
                                                  <th style="background-color: darkcyan; color: white;">No</th>
                                                  <th style="background-color: darkcyan; color: white;">Kdtk</th>
                                                  <th style="background-color: darkcyan; color: white;">Nama Toko</th>
                                                  <th style="background-color: darkcyan; color: white;">Status Trx</th>



                                        </tr>
                              </thead>
                              <tbody id="data-report">

                              </tbody>
                    </table>
          </div>
</div>


<div id="tempat-modal"></div>

<?php show_my_confirm('konfirmasiHapus', 'hapus-dataReport', 'Hapus Data Ini?', 'Ya, Hapus Data Ini'); ?>
<?php
$data['judul'] = 'Report';
$data['url'] = 'report/import';
// echo show_my_modal('modals/modal_import', 'import-report', $data);
?>