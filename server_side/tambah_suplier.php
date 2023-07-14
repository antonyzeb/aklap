<?php 
require "../conn.php";
$namasup=$conn->real_escape_string($_POST['namasup']);
$hpsup=$conn->real_escape_string($_POST['hpsup']);
$alamatsup=$conn->real_escape_string($_POST['alamatsup']);
$sql=$conn->query("INSERT INTO suplier(namasup,hpsup,alamatsup) VALUES ('$namasup','$hpsup','$alamatsup') ");
if ($sql) {
    echo json_encode(array("status" => TRUE));
}
?>