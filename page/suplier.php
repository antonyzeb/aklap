<?php 
include ("../conn.php");
?>
<h3><i class="fa fa-angle-right"></i>Suplier</h3>
<!-- tabel -->
<div class="row mt">
  <div class="col-md-12">
      
      <div class="content-panel">
      <div class="table-responsive">
          <table class="table table-striped table-advance table-hover" id="dataku">
            <div class="row">
                <div class="col-sm-3">
                    <h4><i class="fa fa-angle-right"></i> Data Suplier</h4> 
                </div>
                <div class="col-sm-9">
                  
                    <button class="btn btn-success btn-md" onclick="tambah()" style="float: right; margin-right: 8px;">
                      Tambahkan Data
                    </button>
                </div>
            </div>
              
              <thead>
              <tr>
                  <th><i class="fa fa-bullhorn"></i> No</th>
                  <th>Nama</th>
                  <th>HP</th>
                  <th>Alamat</th>
                  <th>Option</th>
              </tr>
              </thead>
              <tbody>
                    <?php 
                    $sql=$conn->query("
                      SELECT 
                        * FROM suplier
                      ");
               
                  $no=1;
                  while ($data = $sql->fetch_assoc()) {
                  
              ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $data['namasup']; ?></td>
                    <td><?php echo $data['hpsup']; ?></td>
                    <td><?php echo $data['alamatsup']; ?></td>
                    <td>
                        <a class="btn btn-info btn-xs" title="ubah" onclick="ubah('<?php echo $data['idsup']; ?>','<?php echo $data['namasup']; ?>','<?php echo $data['hpsup']; ?>','<?php echo $data['alamatsup']; ?>')"> <i class="fa fa-pencil"></i></a>
                      
                        <a class="btn btn-danger btn-xs" title="hapus data" onclick="hapus('<?php echo $data['idsup']; ?>')"> <i class="fa fa-trash-o"></i></a>
                    </td>                       
                    
                </tr>
                
                <?php } ?>
              </tbody>
          </table>
         </div>
      </div><!-- /content-panel -->

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Ubah Suplier</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" id="idsup" name="idsup"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Nama</label>
                            <div class="col-md-9">
                                <input name="namasup" id="namasup" placeholder="Nama Suplier" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Hp</label>
                            <div class="col-md-9">
                                <input name="hpsup" id="hpsup" placeholder="HP" class="form-control" type="number">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Alamat</label>
                            <div class="col-md-9">
                                <input name="alamatsup" id="alamatsup" placeholder="Alamat" class="form-control" type="text">
                            </div>
                        </div>
                        
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="saving()" data-dismiss="modal" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" id="cancel-btn" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script>
  var save_method;
  $('#dataku').dataTable();

   function ubah(id,nama,hp,alamat) {
    save_method = 'update';
    $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
    $('#idsup').val(id);
    $('#namasup').val(nama);
    $('#hpsup').val(hp);
    $('#alamatsup').val(alamat);
     
   }

   function tambah() {  
    save_method = 'add';
    $('#modal_form').modal('show'); 
    $('#form')[0].reset();     
   }

   function hapus(id) { 
    $.confirm({
        icon: 'fa fa-question',
        title: 'Hapus Data Suplier',
        content: 'Yakin akan menghapus data ini ?',
        type: 'dark',
        theme: 'modern',
        typeAnimated: true,
        buttons: {
            tryAgain: {
                text: 'Ok',
                btnClass: 'btn-blue',
                action: function(){
                  $.ajax({
                      url : "server_side/hapus_suplier.php",
                      type: "POST",
                      data: {idsup:id},
                      success: function(data){
                          notif_success('Berhasil hapus data suplier');
                          $('#kontenku').load('page/suplier.php');
                          
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


   function saving() {
        var url;
        if(save_method == 'add') {
            url = "server_side/tambah_suplier.php";
        } else {
            url = "server_side/ubah_suplier.php";
        }

        
        var formData = new FormData($('#form')[0]);
        if ($('#namasup').val()=='' ) {
          notif_oops('isi dulu namanya !!');
        }else{
            $.ajax({
              url : url,
              type: "POST",
              data: formData,
              contentType: false,
              processData: false,
              dataType: "JSON",
              success: function(data)
              {
                  if(data.status) //if success
                  {
                      
                      notif_success('oke berhasil');
                      // delay 1 detik
                      setTimeout(function() { $('#kontenku').load('page/suplier.php'); }, 1000);
                      
                                          
                  }else{
                    notif_oops('gagal');
                    setTimeout(function() { $('#kontenku').load('page/suplier.php'); }, 1000);
                      
                  }

                 
                  
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                  alert('error');
                  
              }
              
          });
        }
   }

    

</script>