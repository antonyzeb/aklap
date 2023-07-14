<?php 
require "../conn.php";
$kobar=$conn->real_escape_string($_POST['kobar']);
$sql=$conn->query("DELETE FROM barang WHERE kobar='$kobar' ");
?>