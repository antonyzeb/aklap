<?php 
require "../conn.php";
$id_keluar=$conn->real_escape_string($_POST['id_keluar']);
$kobar=$conn->real_escape_string($_POST['kobar']);

// balikin dulu nilai qty nya sebelum di delete
$sql_back = $conn->query("SELECT * FROM detail_barang_keluar WHERE id_keluar='$id_keluar' AND kobar='$kobar' ");
while ($row = $sql_back->fetch_assoc()) {
	$id_masuk = $row['id_masuk'];
	$qty = $row['qty'];
	$sql_update_back = $conn->query("UPDATE detail_barang_masuk SET sisa = sisa + '$qty' WHERE id_masuk='$id_masuk' AND kobar='$kobar' ");
}

$sql=$conn->query("DELETE FROM detail_barang_keluar WHERE id_keluar='$id_keluar' AND kobar='$kobar' ");
?>