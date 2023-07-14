<?php 
require "../conn.php";
$kobar=$conn->real_escape_string($_POST['kobar']);
$nabar=$conn->real_escape_string($_POST['nabar']);
$hargajual=$conn->real_escape_string($_POST['hargajual']);
$sql=$conn->query("UPDATE barang SET nama_barang='$nabar',hargajual='$hargajual' WHERE kobar='$kobar'");
if ($sql) {
    echo json_encode(array("status" => TRUE));
}
?>