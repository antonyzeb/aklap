<?php 
require "../conn.php";
$id_masuk=$conn->real_escape_string($_POST['id_masuk']);
$kobar=$conn->real_escape_string($_POST['kobar']);
$sql=$conn->query("DELETE FROM detail_barang_masuk WHERE id_masuk='$id_masuk' AND kobar='$kobar' ");
?>