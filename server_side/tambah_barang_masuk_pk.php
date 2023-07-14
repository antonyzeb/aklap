<?php 
require "../conn.php";
$id_masuk=$conn->real_escape_string($_POST['id_masuk']);
$suplier_id=$conn->real_escape_string($_POST['suplier_id']);
$sql=$conn->query("INSERT INTO barang_masuk(id_masuk,tgl_masuk,suplier_id) VALUES('$id_masuk',NULL,'$suplier_id')");
if ($sql) {
    echo json_encode(array("status" => TRUE));
}
?>