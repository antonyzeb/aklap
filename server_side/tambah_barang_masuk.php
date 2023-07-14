<?php 
require "../conn.php";
$id_masuk=$conn->real_escape_string($_POST['id_masuk']);
$kobar=$conn->real_escape_string($_POST['kobar']);
$nabar=$conn->real_escape_string($_POST['nabar']);
$qty=$conn->real_escape_string($_POST['qty']);
$harga=$conn->real_escape_string($_POST['harga']);
// cek jika ada data barang dengan kode yg dimasukkan untuk seleksi harga lama.
$cek_harga = $conn->query("SELECT harga,id_masuk FROM detail_barang_masuk WHERE kobar='$kobar' ORDER BY id_masuk DESC LIMIT 1");
if ($cek_harga->num_rows > 0) {
	$up_harga = $conn->query("UPDATE detail_barang_masuk SET harga='$harga' WHERE kobar='$kobar' AND sisa != 0 ");
}

// cekstok skrg 
$cekstok=cekstok($kobar);

// cek apakah barang sudah ada di keranjang barang masuk atau belum.
$cek_brg=$conn->query("SELECT * FROM detail_barang_masuk WHERE kobar='$kobar' AND id_masuk = '$id_masuk' ");
if ($cek_brg->num_rows > 0 ) {
	// update
	$up_isi_brg = $conn->query("UPDATE detail_barang_masuk SET qty = qty + '$qty', sisa = sisa + '$qty' WHERE kobar='$kobar' AND id_masuk='$id_masuk' ");
	$conn->query("UPDATE tbl_stok SET stok = '$cekstok' WHERE trxid='$id_masuk' AND kobar='$kobar' AND type='masuk' ");
}else{
	// insert
	$sql2=$conn->query("INSERT INTO detail_barang_masuk(id_masuk,kobar,qty,sisa,harga) VALUES('$id_masuk','$kobar','$qty','$qty','$harga')");
	$conn->query("INSERT INTO tbl_stok(stok,trxid,type,kobar) VALUES('$cekstok','$id_masuk','masuk','$kobar')");
}


?>