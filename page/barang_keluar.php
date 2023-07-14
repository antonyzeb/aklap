<?php 
include ("../conn.php");
?>

<!-- tabel -->
<div class="row mt">
  <div class="col-md-12">
      <div class="content-panel">
      <div class="table-responsive">
          <table class="table table-striped table-advance table-hover" id="dataku">
            <div class="row">
                <div class="col-sm-3">
                    <h4><i class="fa fa-angle-right"></i> Data Barang Keluar</h4> 
                </div>
                <div class="col-sm-9">
                
                    <button class="btn btn-success btn-md" onclick="tambah()" style="float: right; margin-right: 8px;">
             Tambahkan Barang Keluar
             </button>
                </div>
            </div>
              
              <thead>
              <tr>
                  <th><i class="fa fa-bullhorn"></i> No</th>
                  <th>ID_Keluar</th>
                  <th>Qty</th>
                  <th>Tgl Keluar</th>
                  
                  <th><i class="fa fa-bookmark"></i> Option</th>
                  
              </tr>
              </thead>
              <tbody>
              <?php 
            $sql=$conn->query("
              SELECT 
                barang_keluar.id_keluar as id_keluar,
                tgl_keluar, SUM(qty) as qty 
              FROM barang_keluar 
              INNER JOIN detail_barang_keluar 
                ON barang_keluar.id_keluar=detail_barang_keluar.id_keluar 
              GROUP BY barang_keluar.id_keluar
              ");         
            $no=1;
            while ($data = $sql->fetch_assoc()) {
            
        ?>
          <tr>
              <td><?php echo $no++; ?></td>
              <td><?php echo $data['id_keluar']; ?></td>
              <td><?php echo $data['qty']; ?></td>
              <td><?php echo $data['tgl_keluar']; ?></td>
             
              <td>
           
           <button type="button" class="btn btn-info btn-xs" title="detail barang keluar" data-toggle="modal" data-target="#details<?php echo $data['id_keluar']; ?>">
            <i class="glyphicon glyphicon-eye-open"></i>
          </button>
          <button type="button" class="btn btn-danger btn-xs" title="hapus barang keluar" onclick="hapus_barang_keluar('<?= $data['id_keluar']; ?>')">
            <i class="fa fa-trash-o"></i>
          </button>
            </td>
             
              
          </tr>
          
          <?php } ?>
              </tbody>
          </table>
         </div>
</div><!-- /content-panel -->
</div>
</div>


<!-- modal details -->
 <?php 
    $sql=$conn->query("SELECT id_keluar FROM barang_keluar");         
    $no=1;
    while ($modal = $sql->fetch_assoc()) {
    
?>
<div class="modal fade" id="details<?php echo $modal['id_keluar']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Detail Barang Keluar</h4>
      </div>
      <div class="modal-body">
           <table class="table table-striped table-advance table-hover">
                         
              <thead>
              <tr>
                  <th><i class="fa fa-bullhorn"></i> No</th>
                  <th>ID_Keluar</th>
                  <th>Kode Barang</th>
                  <th>Qty</th>
                  <th>ID Masuk</th>
                                   
              </tr>
              </thead>
              <tbody>
              <?php 
            $sqlmodal=$conn->query("SELECT * FROM detail_barang_keluar WHERE id_keluar='".$modal['id_keluar']."'");         
            $no=1;
            while ($data = $sqlmodal->fetch_assoc()) {
            
        ?>
          <tr>
              <td><?php echo $no++; ?></td>
              <td><?php echo $data['id_keluar']; ?></td>
              <td><?php echo $data['kobar']; ?></td>
              <td><?php echo $data['qty']; ?></td>
              <td><?php echo $data['id_masuk']; ?></td>      
          </tr>
          
          <?php } ?>
              </tbody>
          </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php } ?>

<!-- tutup modal details -->

<script>
   $('#dataku').dataTable();
  function tambah(){
     $('#kontenku').load('page/barang_keluar_tambah.php');
  }


  function hapus_barang_keluar(id) {
   $.confirm({
        icon: 'fa fa-question',
        title: 'Hapus Data Barang Keluar',
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
                      type:'POST',
                      url:'server_side/hapus_barang_keluar.php',
                      data:{id_keluar:id},
                      success: function(data){
                           if(data=="YES"){
                              notif_success('OK Berhasil hapus data');                           
                              $("#kontenku").load("page/barang_keluar.php");
                           }else{
                              notif_oops('terjadi kesalahan');                           
                              $("#kontenku").load("page/barang_keluar.php");
                           }
                      },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
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
</script>
  
 