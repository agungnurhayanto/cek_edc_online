<?php
$current_day = date('j', strtotime('-1 day'));

?>

<div class="msg" style="display:none;">
          <?php echo @$this->session->flashdata('msg'); ?>
</div>

<div class="box">
          <div class="box-header">

                    <div class="col-md-6">
                              <a href="<?php echo base_url('Report/export_tracking'); ?>"
                                        class="form-control btn btn-warning"><i
                                                  class="glyphicon glyphicon glyphicon-floppy-save"></i> Export Data
                                        Excel</a>
                    </div>

          </div>
          <!-- /.box-header -->
          <div class="box-body">
                    <table id="list-data3" class="table table-bordered table-striped">
                              <thead>
                                        <tr>
                                                  <th style="background-color: darkcyan; color: white;">No</th>
                                                  <th style="background-color: darkcyan; color: white;">Kdtk</th>
                                                  <th style="background-color: darkcyan; color: white;">Nama Toko</th>
                                                  <?php for ($day = 1; $day <= $current_day; $day++) : ?>
                                                  <th style="background-color: darkcyan; color: white;">
                                                            <?php echo $day; ?></th>
                                                  <?php endfor; ?>
                                        </tr>
                              </thead>
                              <tbody id="data-report3">

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