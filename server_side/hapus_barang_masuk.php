<?php 
require "../conn.php";
$id_masuk=$conn->real_escape_string($_POST['id']);
$sql1=$conn->query("DELETE FROM detail_barang_masuk WHERE id_masuk='$id_masuk' ");
$sql2=$conn->query("DELETE FROM barang_masuk WHERE id_masuk='$id_masuk' ");
?>