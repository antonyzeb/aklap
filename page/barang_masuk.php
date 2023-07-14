<?php 
include ("../conn.php");
?>
<h3><i class="fa fa-angle-right"></i>Barang Masuk</h3>
<!-- tabel -->
    <div class="row mt">
      <div class="col-md-12">
        <div class="alert alert-warning alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <strong>Perhatian!</strong> Anda tidak bisa menghapus data yang sisa stoknya sudah terpakai !.
            </div>  
          <div class="content-panel">
            <div class="row">
                    <div class="col-sm-3">
                        <h4><i class="fa fa-angle-right"></i> Data Barang Masuk</h4> 
                    </div>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="cari" placeholder="Cari dengan ID Masuk" style="float: right; margin-right: 8px;">
                    </div>
                    <div class="col-sm-3">

                        <button class="btn btn-success btn-md" onclick="tambah()" style="float: right; margin-right: 8px;">
                         Tambah Barang Masuk
                         </button>
                    </div>
                </div>
                <br>
              <div id="cari_brg_masuk">
              
              <!-- pagination -->
              <div class="loading-overlay"><div class="overlay-content">Loading.....</div></div>
              <div id="posts_content">
                <?php
                //Include pagination class file
                include('../helpers/Pagination.php');
                               
                $limit = 3;
                
                //get number of rows
                $queryNum = $conn->query("SELECT COUNT(id_masuk) as postNum FROM barang_masuk");
                $resultNum = $queryNum->fetch_assoc();
                $rowCount = $resultNum['postNum'];
                
                //initialize pagination class
                $pagConfig = array('baseURL'=>'server_side/pagination_barang_masuk.php', 'totalRows'=>$rowCount, 'perPage'=>$limit, 'contentDiv'=>'posts_content');
                $pagination =  new Pagination($pagConfig);
                
                //get rows
                $query = $conn->query("SELECT * FROM barang_masuk ORDER BY id_masuk DESC LIMIT $limit");
                
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
              
               
             </div>
          </div><!-- /content-panel -->
        </div>
      </div>

    


<script>
  // Show loading overlay when ajax request starts
$( document ).ajaxStart(function() {
    $('.loading-overlay').show();
});
// Hide loading overlay when ajax request completes
$( document ).ajaxStop(function() {
    $('.loading-overlay').hide();
});


  $('#dataku').dataTable();
  function tambah(){
     $('#kontenku').load('page/barang_masuk_tambah.php');
  }
    function edit_barang_masuk(id){
     $('#kontenku').load('page/barang_masuk_edit.php?id='+id);
  }
  
  function hapus_barang_masuk(id) {
        $.confirm({
        icon: 'fa fa-question',
        title: 'Hapus Data Barang Masuk',
        content: 'Yakin akan menghapus data dengan id '+id+ ' ?',
        type: 'dark',
        theme: 'modern',
        typeAnimated: true,
        buttons: {
            tryAgain: {
                text: 'Ok',
                btnClass: 'btn-blue',
                action: function(){
                  $.ajax({
                        url : "server_side/hapus_barang_masuk.php",
                        type: "POST",
                        data: {id:id},
                        success: function(data){
                          notif_success('OK Berhasil hapus data');                           
                          $("#kontenku").load("page/barang_masuk.php");
                            
                        },
                        error: function (jqXHR, textStatus, errorThrown){
                            alert('error');
                        }
                    });
                 
                }
            },
            close: function () {              
              notif_oops('Mungkin kamu salah pencet ya..!!');

            }
        }
    });
    
  }

 $('#cari').on('keyup', function(){
    $.get('server_side/cari_barang_masuk.php?keyword='+  $('#cari').val(), function(data){
      $('#cari_brg_masuk').html(data);
    });
  });

</script>
  

