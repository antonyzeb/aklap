<?php 
require "../conn.php";
$idsup=$conn->real_escape_string($_POST['idsup']);
$namasup=$conn->real_escape_string($_POST['namasup']);
$hpsup=$conn->real_escape_string($_POST['hpsup']);
$alamatsup=$conn->real_escape_string($_POST['alamatsup']);
$sql=$conn->query("UPDATE suplier SET 
namasup='$namasup',
hpsup='$hpsup',
hpsup='$hpsup',
alamatsup='$alamatsup'
 WHERE idsup='$idsup'");
if ($sql) {
    echo json_encode(array("status" => TRUE));
}
?>