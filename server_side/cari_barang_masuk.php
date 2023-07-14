<!-- pagination -->
<div class="loading-overlay"><div class="overlay-content">Loading.....</div></div>
<div id="posts_content">
  <?php
  include ("../conn.php");
  //Include pagination class file
  include('../helpers/Pagination.php');
                 
  $limit = 3;
  $keyword=$_GET['keyword'];
  //get number of rows
  $queryNum = $conn->query("SELECT COUNT(id_masuk) as postNum FROM barang_masuk WHERE id_masuk LIKE '%$keyword%' ");
  $resultNum = $queryNum->fetch_assoc();
  $rowCount = $resultNum['postNum'];
  
  //initialize pagination class
  $pagConfig = array('baseURL'=>'server_side/pagination_barang_masuk_search.php', 'totalRows'=>$rowCount, 'perPage'=>$limit, 'contentDiv'=>'posts_content');
  $pagination =  new Pagination($pagConfig);
  
  //get rows
  $query = $conn->query("SELECT * FROM barang_masuk WHERE id_masuk LIKE '%$keyword%' ORDER BY id_masuk DESC LIMIT $limit");
  
  if($query->num_rows > 0){ ?>

<table  class="table table-striped table-advance table-hover table-bordered">
  
  
  <tbody>                 
    
    <thead>
      <tr style="height: 23px;">
      <th style="width: 246px; height: 23px; text-align: center; background-color: #cff9f7;">No</th>
      <th style="width: 241px; height: 23px; text-align: center; background-color: #cff9f7;" colspan="4">ID Masuk</th>
      <th style="width: 246px; height: 23px; text-align: center; background-color: #cff9f7;">Tanggal Masuk</th>
      <th style="width: 246px; height: 23px; text-align: center; background-color: #cff9f7;">Option</th>
    </tr>
    </thead>   
    
    <?php 
   
    $no=1;
    while ($row=$query->fetch_assoc()) { ?>             
    <tr style="height: 23px;">
      <td style="width: 246px; height: 23px; text-align: center;"><?= $no++; ?></td>
      <td style="width: 241px; height: 23px; text-align: center;" colspan="4"><?=$row['id_masuk'] ?>&nbsp;&nbsp;</td>
      <td style="width: 246px; height: 23px; text-align: center;"><?=$row['tgl_masuk'] ?></td>
      <td style="width: 246px; height: 23px; text-align: center;">
        <?php $sql_cek_perm=$conn->query("SELECT qty,sisa FROM detail_barang_masuk WHERE id_masuk='".$row['id_masuk']."' ");
          $row_cek=$sql_cek_perm->fetch_assoc();
          $sisa=$row_cek['sisa'];
          $qty=$row_cek['qty'];
          if ($sisa===$qty) { ?> 
          <button type="button" class="btn btn-danger btn-xs" title="hapus barang masuk" onclick="hapus_barang_masuk('<?= $row['id_masuk']; ?>')"> <i class="fa fa-trash-o"></i></button>
          <?php } ?>
      </td>
    </tr>
   
    <tr style="height: 23px;">
      <th style="width: 241px; height: 23px; text-align: center;background-color: #fcf8b5;">#</th>
      <th style="width: 241px; height: 23px; text-align: center;background-color: #fcf8b5;">Kode Barang</th>
      <th style="width: 243px; height: 23px; text-align: center;background-color: #fcf8b5;">Qty</th>
      <th style="width: 246px; height: 23px; text-align: center;background-color: #fcf8b5;">Sisa</th>
      <th style="width: 246px; height: 23px; text-align: center;background-color: #fcf8b5;">Harga</th>
      <th style="width: 246px; height: 23px; text-align: center;background-color: #fcf8b5;" colspan="2">&nbsp;</th>
    </tr>
    <?php 
      $sql2 = $conn->query("SELECT * FROM detail_barang_masuk WHERE id_masuk='".$row['id_masuk']."' ");
      while ($row2=$sql2->fetch_assoc()) { ?>
    <tr style="height: 23px;">
      <td style="width: 241px; height: 23px; text-align: center;">-</td>
      <td style="width: 241px; height: 23px; text-align: center;"><?=$row2['kobar'] ?></td>
      <td style="width: 243px; height: 23px; text-align: center;"><?=$row2['qty'] ?></td>
      <td style="width: 246px; height: 23px; text-align: center;"><?=$row2['sisa'] ?></td>
      <td style="width: 246px; height: 23px; text-align: center;"><?=$row2['harga'] ?></td>
      <td style="width: 246px; height: 23px; text-align: center;" colspan="2">&nbsp;</td>
    </tr>
    <?php } } ?>
      
    
  </tbody>
  </table>
      <?php echo $pagination->createLinks(); ?>
  <?php } ?>
  </div>

  <!-- end pagination -->