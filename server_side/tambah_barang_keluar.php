<?php 
require "../conn.php";

$id_keluar=$conn->real_escape_string($_POST['id_keluar']);
$kobar=$conn->real_escape_string($_POST['kobar']);
$qty=$conn->real_escape_string($_POST['qty']);

// jika jumlah qtynya terpenuhi alias 0.
$query_stok_barang = $conn->query("SELECT SUM(sisa) as sisa FROM detail_barang_masuk WHERE kobar = '$kobar'");
$row = $query_stok_barang->fetch_assoc();
$data_stok = $row['sisa'];
// jika stok lebih besar atau sama dengan jumlah beli
if ($data_stok >= $qty) {


    // masukkan ke tabel barang keluar
    // $sql_barang_keluar=$conn->query("INSERT INTO barang_keluar VALUES('$id_keluar','$qty',NULL)");
        
    /* - Start code */
     $jumlah_brg_keluar = $qty;
    // jika jumlah belinya lebih besar dari 0
    if ($jumlah_brg_keluar > 0) {
      // cari pada tabel barang masuk dimana sisanya masih lebih besar dr 0
      $sqlM = $conn->query("SELECT * FROM detail_barang_masuk INNER JOIN barang_masuk
                              ON barang_masuk.id_masuk=detail_barang_masuk.id_masuk
                            WHERE kobar='$kobar' AND sisa > 0 ORDER BY tgl_masuk ASC");
      // cekstok skrg 
        $cekstok=cekstok($kobar);
        $cekharga=cekharga($kobar);
      // lakukan perulangan sampai jumlah barang yg keluar terpenuhi
      while ($row_brg_masuk = $sqlM->fetch_assoc()) {
              // id masuk disni sebagai bukti barang yg keluar diambil dr id masuk tersebut
              $id_masuk = $row_brg_masuk['id_masuk'];
              $sisa = $row_brg_masuk['sisa'];
              // jumlah barang yg keluar smentara ambil rumus min mencari selisih yg kurang untuk di tambahkan lg sampai qtynya terpenuhi
              $jml_qty_keluar_sementara = min($jumlah_brg_keluar, $sisa);
              // update nilai qty sekarang
              $jml_qty_sekarang = $sisa - $jml_qty_keluar_sementara; 
              
                
               // masukkan ke tabel detail barang keluar
                  $sqldb = $conn->query("INSERT INTO detail_barang_keluar(id_keluar,kobar,qty,id_masuk,hjual) VALUES ('$id_keluar','$kobar','$jml_qty_keluar_sementara','$id_masuk','$cekharga')");
                  $conn->query("INSERT INTO tbl_stok(stok,trxid,type,kobar) VALUES('$cekstok','$id_keluar','keluar','$kobar')");
              // update di barang masuk dikurangi stoknya
              $sqlup = $conn->query("UPDATE detail_barang_masuk SET sisa = '$jml_qty_sekarang' WHERE id_masuk = '$id_masuk' AND kobar='$kobar' ");
              // kemudian jmlbarang yg sementara keluar dikurangi dr total barang yg akan keluar
              $jumlah_brg_keluar -= $jml_qty_keluar_sementara;
              // jika barang yg keluar sudah terpenuhi maka akan break dan keluar dari perulangan.
              if ($jumlah_brg_keluar <= 0) break;
          }
        
         
    } 

    /* - Finish code */
    echo json_encode(array("status" => TRUE));
      
}else{ 

    echo json_encode(array("status" => FALSE, 'stok'=>$data_stok));
}

?>

