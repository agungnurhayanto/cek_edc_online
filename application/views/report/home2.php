<div class="msg">
          <?php
          if ($this->session->flashdata('berhasil')) {
                    echo '<div class="alert alert-success">' . $this->session->flashdata('berhasil') . '</div>';
          }
          if ($this->session->flashdata('gagal')) {
                    echo '<div class="alert alert-danger">' . $this->session->flashdata('gagal') . '</div>';
          }
          ?>
</div>

<div class=" box">
          <div class="box-header">

                    <div class="col-md-4">
                              <a href="<?php echo base_url('Report/export_rusak'); ?>"
                                        class="form-control btn btn-warning"><i
                                                  class="glyphicon glyphicon glyphicon-floppy-save"></i> Export Data
                                        Excel</a>
                    </div>
                    <div class="col-md-4">
                              <button class="form-control btn btn-success" data-toggle="modal"
                                        data-target="#import-edc"><i
                                                  class="glyphicon glyphicon glyphicon-floppy-open"></i> Import Edc
                                        Rusak</button>

                    </div>
                    <div class="col-md-4">

                              <a href="<?php echo base_url('Report/download_template'); ?>"
                                        class="form-control btn btn-info">
                                        <i class="glyphicon glyphicon-download"></i> Download Template Import
                              </a>
                              <h4 class="text-red">*( Sesuaikan Row Datanya Dengan Template)*</h4>
                    </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
                    <table id="list-data2" class="table table-bordered table-striped">
                              <thead>
                                        <tr>
                                                  <th style="background-color: darkcyan; color: white;">No</th>
                                                  <th style="background-color: darkcyan; color: white;">Kdtk</th>
                                                  <th style="background-color: darkcyan; color: white;">Nama Toko</th>
                                                  <th style="background-color: darkcyan; color: white;">Status Trx</th>
                                                  <th style="background-color: darkcyan; color: white;">Am</th>
                                                  <th style="background-color: darkcyan; color: white;">As</th>
                                                  <th style="background-color: darkcyan; color: white;">Tgl Cek Edp</th>
                                                  <th style="background-color: darkcyan; color: white;">Keterangan</th>

                                        </tr>
                              </thead>
                              <tbody id="data-report2">

                              </tbody>
                    </table>
          </div>
</div>



<div id="tempat-modal"></div>

<?php
$data['judul'] = 'Report';
$data['url'] = 'report/import';
echo show_my_modal('modals/modal_import', 'import-edc', $data);

?>

<script>
$(document).ready(function() {
          // Menghilangkan pesan flash setelah 5 detik
          setTimeout(function() {
                    $(".alert").fadeOut("slow");
          }, 5000);
});
</script>