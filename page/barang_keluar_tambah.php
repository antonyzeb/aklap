<?php 
include ("../conn.php");
?>
<!-- modal -->
<?php 
$today ='BK'.date("ymd");
// cari id transaksi terakhir yang berawalan tanggal hari ini
$query = $conn->query("SELECT max(id_keluar) AS last FROM barang_keluar WHERE id_keluar LIKE '$today%'");
$data  = $query->fetch_assoc();
$lastNoTransaksi = $data['last'];

// baca nomor urut transaksi dari id transaksi terakhir
// 9 nomor id pertama, 3 nomor id terakhir.
$lastNoUrut = substr($lastNoTransaksi, 8, 3);

$nextNoUrut = $lastNoUrut + 1;

// membuat format nomor transaksi berikutnya
$nextNoTransaksi = $today.sprintf('%03s', $nextNoUrut);
?>
<div class="form-group" style="display: none;">
  <label class="col-sm-3 control-label">ID Keluar</label>

        <div class="col-sm-9">
            <input type="text" class="form-control" name="id_keluar" id="id_keluar"  value="<?php echo $nextNoTransaksi; ?>" readonly>
        </div>
  </div>
<h3><i class="fa fa-angle-right"></i>Tambah Barang Keluar</h3>
<!-- BASIC FORM ELELEMNTS -->
<div class="row mt">
  <div class="col-lg-12">
      <div class="form-panel">
          <form class="form-horizontal style-form" id="form_barang_keluar">
              
             <div class="form-group">
              <label class="col-sm-3 control-label">Kode Barang</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="kobar" id="kobar" placeholder="Input Kode Barang">
                    </div>
              </div>
              
               <div class="form-group">
               <label class="col-sm-3 control-label">Qty</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" name="qty" id="qty" placeholder="Input Qty">
                    </div>
              </div>
              <div class="form-group">
                    
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9"> 
                      <button type="button" class="btn btn-primary" onclick="save()">Tambahkan</button>
                      <button type="button" class="btn btn-default" id="kembali" onclick="back()">Kembali</button>
                        
                      </div>
              </div>
              
              
          </form>

           <!-- tabel jual -->
          <div id="table_jual">
              <div class="row">
                  <div class="col-sm-6">
                    <h4 class="mb"><i class="fa fa-angle-right"></i> Data Barang yang akan keluar</h4>

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
                            <th><i class="fa fa-bookmark"></i> Option</th>              
                        </tr>
                        </thead>
                        <tbody>
                        
                          <tr>
                               
                              
                          </tr>
                    
                        </tbody>
                </table>
               </div>
              <!-- end table -->
          </div>
          
      </div>
  </div><!-- col-lg-12-->       
</div><!-- /row -->


<script>
  var id_keluar = $('#id_keluar').val();

  function save(){
        if ($('#kobar').val()=='' || $('#qty').val()=='' ) {
          notif_oops('isi dulu semuanya');
        }else{
            // alert(id_keluar);
            var kobar = $('#kobar').val();
            var qty = $('#qty').val();
            $.ajax({
                  url : "server_side/tambah_barang_keluar.php",
                  type: "POST",
                   data: {id_keluar:id_keluar, kobar:kobar, qty:qty},
                  success: function(data){ 

                      var dataku = JSON.parse(data);
                      if (dataku.status) {
                        load_data_jual(id_keluar);
                        bersih_form();
                      }else{
                        notif_oops('stok kurang bro.. hanya ada '+dataku.stok+ ' !');
                      }                     
                      
                      
                  },
                  error: function (jqXHR, textStatus, errorThrown){
                      alert('error');
                  }
              });
        }
        
  }

    function bersih_form() {
    $('#kobar').val('');
    $('#qty').val('');
  }

  function load_data_jual(id_keluar) {
    $('#table_jual').load('server_side/table_jual.php?id_keluar='+id_keluar);
    $('#kembali').attr('disabled',true);
      
  }


  function back(){
    $('#kontenku').load('page/barang_keluar.php');
  }

   function hapus_item_keluar(id,kode) {
    $.confirm({
        icon: 'fa fa-question',
        title: 'Hapus Data Item Barang Yg akan Keluar',
        content: 'Yakin akan menghapus data dengan kode barang '+kode+ ' ?',
        type: 'dark',
        theme: 'modern',
        typeAnimated: true,
        buttons: {
            tryAgain: {
                text: 'Ok',
                btnClass: 'btn-blue',
                action: function(){
                  $.ajax({
                      url : "server_side/hapus_barang_keluar_item.php",
                      type: "POST",
                      data: {id_keluar : id, kobar : kode},
                      success: function(data){                      
                          load_data_jual(id_keluar);                      
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

  function jual_selesai() {
    // alert(id_masuk);
     $.ajax({
            url : "server_side/tambah_barang_keluar_pk.php",
            type: "POST",
            data: {id_keluar:id_keluar},
            success: function(data){
                notif_success('berhasil transaksi penjualan');
                $("#kontenku").load("page/barang_keluar.php");
                
            },
            error: function (jqXHR, textStatus, errorThrown){
                alert('error');
            }
        });
  }
</script>
