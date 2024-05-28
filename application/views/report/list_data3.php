<?php
$current_day = date('j', strtotime('-1 day'));
$no = 1;
foreach ($trackingTrx as $row) {
?>
<tr>
          <td><?php echo $no++; ?></td>
          <td><?php echo $row['kdtk']; ?></td>
          <td><?php echo $row['nama_toko']; ?></td>
          <?php for ($day = 1; $day <= $current_day; $day++) : ?>
          <?php
                              $status = isset($row['status'][$day]) ? $row['status'][$day] : 'NOK';
                              switch ($status) {
                                        case 'On':
                                                  $color = 'green';
                                                  break;
                                        case 'Off':
                                                  $color = 'red';
                              }
                              ?>
          <td style="background-color: <?php echo $color; ?>;"><?php echo $status; ?></td>
          <?php endfor; ?>
</tr>
<?php
}
?>