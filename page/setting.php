<?php 
session_start();
include ("../conn.php");
include '../helpers/Format.php';

$fm=new Format();
?>
<h3><i class="fa fa-angle-right"></i>Setting User</h3>

<div class="alert alert-warning alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <strong>Perhatian! </strong>Ubah Password demi keamanan akun anda.. !!
</div>

<!-- tabel -->
<div class="row mt">
  <div class="col-md-12">
      <div class="content-panel">
      	<div class="row">
                <div class="col-sm-3">
                    <h4><i class="fa fa-angle-right"></i> Data User</h4> 
                </div>
                <div class="col-sm-9">
                <?php if ($_SESSION['id'] == 1) { ?> 
                    <button class="btn btn-success btn-md" onclick="tambah_user()" style="float: right; margin-right: 8px;">
             Tambahkan User
             </button>
             <?php } ?>
                </div>
            </div>  
            <br>	
      <div class="table-responsive">
          <table class="table table-striped table-advance table-hover">
                        
              <thead>
              <tr>
                  <th>No</th>
	                <th>Name</th>
	                <th>Email</th>
	                <th>About</th>
	                <th>Image</th>
                  <th><i class="fa fa-bookmark"></i> Option</th>
                  
              </tr>
              </thead>
              <tbody>
              <?php 
              if ($_SESSION['id'] == 1) { 
			       $sql=$conn->query("SELECT * FROM tbl_user");
			   }else{
			   		$sql=$conn->query("SELECT * FROM tbl_user WHERE id = '".$_SESSION['id']."' ");
			   }
			      $no=1;
			      while ($data = $sql->fetch_assoc()) { ?>
				  <tr>
				      <td><?php echo $no++; ?></td>
				      <td><?php echo $data['name']; ?></td>
				      <td><?php echo $data['email']; ?></td>
				      <td><?php echo $fm->textShorten($data['details'],30); ?></td>
				      <td><img src="upload/admin/<?php echo $data['image'];?>" height="50px" width="60px"></td>
				      
				      <td>
				      	<a onclick="edit_setting('<?=$data['id']?>')" class="btn btn-info btn-xs" title="edit user"> <i class="fa fa-pencil"></i></a>
				      	<?php if ($_SESSION['id'] == 1) { ?>                  		
                  		<a onclick="hapus_user('<?=$data['id']?>')" class="btn btn-danger btn-xs" title="hapus user"> <i class="fa fa-trash-o"></i></a>
                  		<?php } ?>
					  </td>
				     
				      
				  </tr>
				  
				  <?php } ?>
              </tbody>
          </table>
         </div>
      </div><!-- /content-panel -->
	  </div><!-- /col-md-12 -->
</div>


<script>
    function edit_setting(id) {
      // alert(id);
      $('#kontenku').load('page/edit_set.php?id='+id);
    }
    function tambah_user() {
    	$('#kontenku').load('page/tambah_user.php');
    }
    function hapus_user(id) {
    	$.confirm({
        icon: 'fa fa-question',
        title: 'Hapus Data User',
        content: 'Yakin akan menghapus data user dengan id '+id+ ' ?',
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
                      url:'server_side/hapus_user.php',
                      data:{id:id},
                      success: function(data){
                      	 var dataku = JSON.parse(data);
	                      if (dataku.status) {
	                          notif_success('OK Berhasil hapus data user');                           
                              $("#kontenku").load("page/setting.php");
	                      }else{
	                        notif_oops('terjadi kesalahan');                           
                            $("#kontenku").load("page/setting.php");
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