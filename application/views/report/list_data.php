<?php
$no = 1;
foreach ($BcaOnline as $key => $row) {
?>
<tr>
          <td><?php echo $no++; ?></td>
          <td><?php echo $row['kdtk']; ?></td>
          <td><?php echo $row['nama_toko']; ?></td>
          <td><?php echo $row['am']; ?></td>
          <td><?php echo $row['as']; ?></td>
          <td><?php echo $row['status']; ?></td>
</tr>
<?php
}
?>