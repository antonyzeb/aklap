<?php 
require "../conn.php";
$id_keluar=$conn->real_escape_string($_POST['id_keluar']);
$sql=$conn->query("INSERT INTO barang_keluar VALUES('$id_keluar',NULL)");
if ($sql) {
    echo json_encode(array("status" => TRUE));
}
?>