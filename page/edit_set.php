
<?php 
include ("../conn.php");
$idnya = $_GET['id'];
$query = $conn->query("SELECT * FROM tbl_user WHERE id='$idnya'");    
$f=$query->fetch_assoc();
?>


<h3><i class="fa fa-angle-right"></i>Edit Setting</h3>
<div id="tes"></div>
<!-- BASIC FORM ELELEMNTS -->
<div class="row mt">
  <div class="col-lg-12">
      <div class="form-panel">
          <form  class="form-horizontal"  id="edit_setting"> 
            <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Username</label>
                  <div class="col-sm-10">
                      <input type="hidden" class="form-control" name="id" id="id" value="<?php echo $f['id']; ?>">
                      <input type="text" class="form-control" name="user" id="user" value="<?php echo $f['username']; ?>" readonly>
                  </div>
            </div>
            <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Last Password</label>
                  <div class="col-sm-10">
                      <div id="result_lastpass"></div>                     
                      <input type="Password" class="form-control" name="lpass" id="lpass" placeholder="Input Last Password">
                  </div>
            </div>
             <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">New Password</label>
                  <div class="col-sm-10">
                     
                      <input type="Password" class="form-control" name="nupass" id="nupass" placeholder="Input New Password" >
                  </div>
            </div>
             <div class="form-group">
                   
                  <label class="col-sm-2 col-sm-2 control-label">Re-Password</label>
                  <div class="col-sm-10">                     
                      <div id="result_repass"></div>
                      <input type="Password" class="form-control" name="repass" id="repass" placeholder="Input Re-Password" >
                  </div>
            </div>
             <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">About</label>
                  <div class="col-sm-10">
                      
                      <textarea class="form-control" rows="10" name="det" ><?php echo $f['details']; ?></textarea>
                  </div>
            </div>
             <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Image</label>
                  <div class="col-sm-10">
                      <div id="kv-avatar-errors-2" class="center-block" style="width:270px;display:none;"></div>
                        <div class="kv-avatar left-block" style="width:200px">
                            <input id="avatar-2" name="image" type="file" class="file-loading">
                        </div>
                  </div>
            </div>
           
            <div class="form-group">
                    
                    <div class="col-sm-2"></div>
                    <div class="col-sm-10">
                      
                      <button type="button" class="btn btn-primary" onclick="save_data()">Update</button>
                      <button type="button" class="btn btn-default" onclick="back()">Back</button>
                    </div>
              </div>
             

          </form>
      </div>
  </div><!-- col-lg-12-->       
</div><!-- /row -->




<script>

function save_data(){
      
      if ($('#user').val()=='' || $('#lpass').val()=='' || $('#nupass').val()=='' || $('#repass').val()=='') {
        notif_oops('isi dulu semuanya');
      }else{
          var formData = new FormData($('#edit_setting')[0]);
          var url = "server_side/proses_edit_set.php";
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
                      notif_success('berhasil mengubah pengaturan user');
                      $("#kontenku").load("page/setting.php");
                  }

                 
                  
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                  alert('error');
                  
              }
              
          });
      }
      
}

function back() {
  $('#kontenku').load('page/setting.php');
}


$("#avatar-2").fileinput({
overwriteInitial: true,
maxFileSize: 1500,
showClose: false,
showCaption: false,
showBrowse: false,
browseOnZoneClick: true,
removeLabel: '',
removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
removeTitle: 'Cancel or reset changes',
elErrorContainer: '#kv-avatar-errors-2',
msgErrorClass: 'alert alert-block alert-danger',
defaultPreviewContent: '<img src="upload/admin/<?php echo $f['image']; ?>" alt="Your Avatar" style="width:160px"><h6 class="text-muted">Click to select</h6>',
layoutTemplates: {main2: '{preview} ' + ' {remove} {browse}'},
allowedFileExtensions: ["jpg", "png", "gif"]
});

 
// cek re password
$('#repass').on('keyup', function(){
    var newpass = $('#nupass').val();
    var repass = $('#repass').val();
    if (newpass == repass) {
      $('#result_repass').html('');
    }else if (newpass != repass && repass !='') {
      $('#result_repass').html('<h5 style="color:red">password tidak sama</h5>');
    }else{
      $('#result_repass').html('<h5 style="color:red">password harus diisi</h5>');
    }
    
  });


// cek last password
$('#lpass').on('keyup', function(){   

    var id = $('#id').val();
    $.get('server_side/check_pass.php?id='+id+'&pass='+  $('#lpass').val(), function(data){
      $('#result_lastpass').html(data);
    });
  });





</script>