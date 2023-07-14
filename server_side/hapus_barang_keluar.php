<?php 
require "../conn.php";
$id_keluar=$conn->real_escape_string($_POST['id_keluar']);
$sql=$conn->query("SELECT qty,kobar, id_masuk FROM detail_barang_keluar WHERE id_keluar='$id_keluar' ");
while ($row=$sql->fetch_assoc()) {
	  $id_masuk = $row['id_masuk'];
	  $qty=$row['qty'];
	  $kobar=$row['kobar'];


	  // update ke tabel barang masuk dengan mengembalikan stok yg dibeli ke id_masuk
	  $sql2=$conn->query("UPDATE detail_barang_masuk SET sisa = sisa + '$qty' WHERE id_masuk='$id_masuk' AND kobar='$kobar' ");
}
// setelah di update baru didelete dari tabel detail dan barang masuk
$sql3=$conn->query("DELETE FROM detail_barang_keluar WHERE id_keluar='$id_keluar' ");
$sql4=$conn->query("DELETE FROM barang_keluar WHERE id_keluar='$id_keluar' ");
if ($sql2 && $sql3 && $sql4) {
	echo "YES";
}else{
	echo "NO";
}

?>