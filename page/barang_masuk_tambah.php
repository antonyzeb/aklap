<?php 
include ("../conn.php");
?>
<!-- modal -->
<?php 
$today ='BM'.date("ymd");
// cari id transaksi terakhir yang berawalan tanggal hari ini
$query = $conn->query("SELECT max(id_masuk) AS last FROM barang_masuk WHERE id_masuk LIKE '$today%'");
$data  = $query->fetch_assoc();
$lastNoTransaksi = $data['last'];

// baca nomor urut transaksi dari id transaksi terakhir
// 9 nomor id pertama, 3 nomor id terakhir.
$lastNoUrut = substr($lastNoTransaksi, 8, 3);
$nextNoUrut = $lastNoUrut + 1;

// membuat format nomor transaksi berikutnya
$nextNoTransaksi = $today.sprintf('%03s', $nextNoUrut);
?>
<h3><i class="fa fa-angle-right"></i>Tambah Barang Masuk</h3>
<!-- BASIC FORM ELELEMNTS -->
<div class="form-group" style="display: none;">
    <label class="col-sm-2 col-sm-2 control-label">ID Masuk</label>
    <div class="col-sm-4">
        <input type="text" class="form-control" name="id_masuk" id="id_masuk" value="<?php echo $nextNoTransaksi; ?>" readonly>
    </div>
</div>
<div class="row mt">
  <div class="col-lg-12">
      <div class="form-panel">
          <form class="form-horizontal style-form" id="form_tambah_barang_masuk">             
              <div class="form-group">
                  <label class="col-sm-2 control-label">Suplier</label>
                    <div class="col-sm-4">
                      <select class="form-control" name="suplier_id" id="suplier_id">
                        <option value="">Select Suplier</option>
                        <?php
                        
                          $sqlsup=$conn->query("
                      SELECT 
                        * FROM suplier
                      ");
               
                  $no=1;
                  while ($ds = $sqlsup->fetch_assoc()) {
                        ?>
                        <option value="<?=$ds['idsup']?>"><?=$ds['namasup']?></option>
                        <?php }?>
                      </select>
                    </div>

              </div>
              <div class="form-group">
                  <label class="col-sm-2 control-label">Kode Barang</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="kobar" id="kobar" placeholder="Kode Barang">
                    </div>

                    <label class="col-sm-2 control-label">Nama Barang</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="nabar" id="nabar" placeholder="Nama Barang" readonly>
                    </div>
              </div>
              
              <div class="form-group">
                    <label class="col-sm-2 control-label">Harga</label>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" name="harga" id="harga" placeholder="Input Harga">
                    </div>
                    <label class="col-sm-2 control-label">Qty</label>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" name="qty" id="qty" placeholder="Input Qty">
                    </div>
              </div>
              
              <div class="form-group">                    
                    <div class="col-sm-2"></div>
                    <div class="col-sm-10">
                      <button type="button" class="btn btn-primary" onclick="save()">Tambahkan</button>
                       <button type="button" class="btn btn-default" id="kembali" onclick="back()">Kembali</button>
                    </div>
              </div>
              
              
          </form>
           <!-- tabel beli -->
        <div id="table_beli">
           <div class="row">
            <div class="col-sm-6">
              <h4 class="mb"><i class="fa fa-angle-right"></i> Data Barang yang akan masuk</h4>

            </div>
            <div class="col-sm-6">
              <button type="button" class="btn btn-success pull-right" disabled>Transaksi Selesai</button>
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
                  
                    <tr>
                         
                        
                    </tr>
              
              </tbody>
          </table>
         </div>


        </div>
         
        <!-- end table -->
      </div>

  </div><!-- col-lg-12-->       

 


</div><!-- /row -->


<script>
  var id_masuk = $('#id_masuk').val();
  
  $("#kobar").keydown(function(event){
    if (event.keyCode == '13') {
      var kode = $('#kobar').val();
      $.ajax({
        url: "server_side/check_barang.php",
        type: "post", 
        data: {kode:kode},
        success:function(data){

        var dataku = JSON.parse(data);
        if (dataku==null) {
          notif_oops('pencarian dengan kode barang = '+kode+ ' tidak ditemukan.. coba cek lagi bro di data barangnya !!!');
          bersih_form();
        }else{
          $('#nabar').val(dataku.nama_barang);
            if (dataku.harga == null) {
              $('#harga').val('0'); 
            }else{
              $('#harga').val(dataku.harga); 
            }
        }
        

        
        }
      });
    }
  });

  function beli_selesai() {
    var suplier_id = $('#suplier_id').val();
    if (suplier_id=='' ) {
          notif_oops('isi dulu supliernya !!');
        }else{
          $.ajax({
            url : "server_side/tambah_barang_masuk_pk.php",
            type: "POST",
            data: {id_masuk:id_masuk,suplier_id:suplier_id},
            success: function(data){
                notif_success('OK berhasil transaksi pembelian');
                $("#kontenku").load("page/barang_masuk.php");
                
            },
            error: function (jqXHR, textStatus, errorThrown){
                alert('error');
            }
        });
        }
     
  }


  function bersih_form() {
    $('#kobar').val('');
    $('#nabar').val('');
    $('#qty').val('');
    $('#harga').val('');
  }

  function save(){
    
    // alert(id_masuk);
    

        if ($('#kobar').val()=='' || $('#nabar').val()=='' || $('#qty').val()=='' || $('#harga').val()=='') {
          notif_oops('isi dulu semuanya !!');



        }else{
            var kobar = $('#kobar').val();
            var nabar = $('#nabar').val();
            var qty = $('#qty').val();
            var harga = $('#harga').val();

                $.ajax({
                  url : "server_side/tambah_barang_masuk.php",
                  type: "POST",
                  data: {id_masuk : id_masuk, kobar : kobar, nabar : nabar, qty : qty, harga : harga },
                  success: function(data){                      
                      load_data_beli(id_masuk);
                      bersih_form();
                      
                  },
                  error: function (jqXHR, textStatus, errorThrown){
                      alert('error');
                  }
              });
            
        }
        
  }

  function hapus_item(id_masuk,kobar) {
    $.confirm({
        icon: 'fa fa-question',
        title: 'Hapus Data Item Barang Yg akan Masuk',
        content: 'Yakin akan menghapus data dengan kode barang '+kobar+ ' ?',
        type: 'dark',
        theme: 'modern',
        typeAnimated: true,
        buttons: {
            tryAgain: {
                text: 'Ok',
                btnClass: 'btn-blue',
                action: function(){
                 $.ajax({
                        url : "server_side/hapus_barang_masuk_item.php",
                        type: "POST",
                        data: {id_masuk : id_masuk, kobar : kobar},
                        success: function(data){                      
                            load_data_beli(id_masuk);                      
                        },
                        error: function (jqXHR, textStatus, errorThrown){
                            alert('error');
                        }
                    });
                 
                }
            },
            close: function () {              
              notif_oops('oke.. mungkin kamu hanya salah pencet !!');

            }
        }
    });            
  }

  function load_data_beli(id_masuk) {
    $('#table_beli').load('server_side/table_beli.php?id_masuk='+id_masuk);
    $('#kembali').attr('disabled',true);
      
  }
  function back(){
    $('#kontenku').load('page/barang_masuk.php');
  }
</script>