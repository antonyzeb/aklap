<?php 
require "../conn.php";
$id_masuk=$_GET['id_masuk'];
$query = $conn->query("SELECT * FROM detail_barang_masuk WHERE id_masuk = '$id_masuk'"); 
?>
<div class="row">
  <div class="col-sm-6">
    <h4 class="mb"><i class="fa fa-angle-right"></i> Data Barang yang akan masuk</h4>

  </div>
  <div class="col-sm-6">
    <?php if ($query->num_rows > 0) { ?>
      <button type="button" class="btn btn-success pull-right" onclick="beli_selesai()">Transaksi Selesai</button>
    <?php }else{ ?>
      <button type="button" class="btn btn-success pull-right" disabled>Transaksi Selesai</button>
    <?php } ?>
  </div>
</div>
<div class="table-responsive">
    <table class="table table-striped table-advance table-hover">         
        <thead>
        <tr>
            <th><i class="fa fa-bullhorn"></i> No</th>
            <th>Kode Barang</th>
            <th>Qty</th>
            <th>Harga</th>
            <th><i class="fa fa-bookmark"></i> Option</th>              
        </tr>
        </thead>
        <tbody>
        
          <?php
            $no=1;
            while ($row = $query->fetch_assoc()) {
              ?>
               
                          <tr>
                               <td><?=$no++; ?></td>
                               <td><?=$row['kobar']; ?></td>
                               <td><?=$row['qty']; ?></td>
                               <td><?=$row['harga']; ?></td>
                               <td>
                                  <a onclick="hapus_item('<?= $row['id_masuk'] ?>','<?=$row['kobar'] ?>')" class="btn btn-danger btn-xs" title="hapus"> <i class="fa fa-trash-o"></i></a>
                               </td>

                              
                          </tr>
                          

              <?php 

            }
          ?>
    
    </tbody>
</table>
</div>
