<script type="text/javascript">
var MyTable = $('#list-data').dataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false
});

var MyTable2 = $('#list-data2').dataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false
});


window.onload = function() {
          tampilReport();
          tampilReport2();

          <?php
          if ($this->session->flashdata('msg') != '') {
               echo "effect_msg();";
          }
          ?>
}


function refresh() {
          MyTable = $('#list-data').dataTable();
}

function refresh2() {
          MyTable2 = $('#list-data2').dataTable();
}




function effect_msg_form() {
          // $('.form-msg').hide();
          $('.form-msg').show(1000);
          setTimeout(function() {
                    $('.form-msg').fadeOut(1000);
          }, 3000);
}

function effect_msg() {
          // $('.msg').hide();
          $('.msg').show(1000);
          setTimeout(function() {
                    $('.msg').fadeOut(1000);
          }, 3000);
}

function tampilReport() {
          $.get('<?php echo base_url('Report/tampil'); ?>', function(data) {
                    MyTable.fnDestroy();
                    $('#data-report').html(data);
                    refresh();
          });
}

function tampilReport2() {
          $.get('<?php echo base_url('Report/tampil2'); ?>', function(data) {
                    MyTable2.fnDestroy();
                    $('#data-report2').html(data);
                    refresh2();
          });
}



var id_report;
$(document).on("click", ".konfirmasiHapus-report", function() {
          id_report = $(this).attr("data-id");
})
$(document).on("click", ".hapus-dataReport", function() {
          var id = id_report;

          $.ajax({
                              method: "POST",
                              url: "<?php echo base_url('Report/delete'); ?>",
                              data: "id=" + id
                    })
                    .done(function(data) {
                              $('#konfirmasiHapus').modal('hide');
                              tampilReport();
                              $('.msg').html(data);
                              effect_msg();
                    })
})

$(document).on("click", ".detail-dataReport", function() {
          var id = $(this).attr("data-id");

          $.ajax({
                              method: "POST",
                              url: "<?php echo base_url('Report/detail'); ?>",
                              data: "id=" + id
                    })
                    .done(function(data) {
                              $('#tempat-modal').html(data);
                              $('#tabel-detail').dataTable({
                                        "paging": true,
                                        "lengthChange": false,
                                        "searching": true,
                                        "ordering": true,
                                        "info": true,
                                        "autoWidth": false
                              });
                              $('#detail-report').modal('show');
                    });
});



$(document).on("click", ".update-dataReport", function() {
          var id = $(this).attr("data-id");

          $.ajax({
                              method: "POST",
                              url: "<?php echo base_url('Report/update'); ?>",
                              data: "id=" + id
                    })
                    .done(function(data) {
                              $('#tempat-modal').html(data);
                              $('#update-report').modal('show');
                    });
});


$('#form-tambah-report').submit(function(e) {
          var data = $(this).serialize();

          $.ajax({
                              method: 'POST',
                              url: '<?php echo base_url('Report/prosesTambah'); ?>',
                              data: data
                    })
                    .done(function(data) {
                              var out = jQuery.parseJSON(data);

                              tampilReport();
                              if (out.status == 'form') {
                                        $('.form-msg').html(out.msg);
                                        effect_msg_form();
                              } else {
                                        document.getElementById("form-tambah-report")
                                                  .reset();
                                        $('#tambah-report').modal('hide');
                                        $('.msg').html(out.msg);
                                        effect_msg();
                              }
                    })
          e.preventDefault();
});


$(document).on('submit', '#form-update-report', function(e) {
          var data = $(this).serialize();

          $.ajax({
                              method: 'POST',
                              url: '<?php echo base_url('Report/prosesUpdate'); ?>',
                              data: data
                    })
                    .done(function(data) {
                              var out = jQuery.parseJSON(data);

                              tampilReport();
                              if (out.status == 'form') {
                                        $('.form-msg').html(out.msg);
                                        effect_msg_form();
                              } else {
                                        document.getElementById("form-update-report")
                                                  .reset();
                                        $('#update-report').modal('hide');
                                        $('.msg').html(out.msg);
                                        effect_msg();
                              }
                    })

          e.preventDefault();
});



$('#tambah-report').on('hidden.bs.modal', function() {
          $('.form-msg').html('');
})


$('#update-report').on('hidden.bs.modal', function() {
          $('.form-msg').html('');
})
</script>