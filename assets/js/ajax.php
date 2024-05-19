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

// function tampilReport() {
//           $.get('<?php echo base_url('Report/tampil'); ?>', function(data) {
//                     MyTable.fnDestroy();
//                     $('#data-report').html(data);
//                     refresh();
//           });
// }

// function tampilReport2() {
//           $.get('<?php echo base_url('Report/tampil2'); ?>', function(data) {
//                     MyTable2.fnDestroy();
//                     $('#data-report2').html(data);
//                     refresh2();
//           });
// }

function tampilReport() {
          $.ajax({
                    url: '<?php echo base_url('Report/tampil'); ?>',
                    type: 'GET',
                    cache: true, // Menambah cache di AJAX call
                    success: function(data) {
                              MyTable.fnDestroy();
                              $('#data-report').html(data);
                              refresh();
                    }
          });
}

function tampilReport2() {
          $.ajax({
                    url: '<?php echo base_url('Report/tampil2'); ?>',
                    type: 'GET',
                    cache: true, // Menambah cache di AJAX call
                    success: function(data) {
                              MyTable2.fnDestroy();
                              $('#data-report2').html(data);
                              refresh2();
                    }
          });
}
</script>