<?php 
require "../conn.php";
$idsup=$conn->real_escape_string($_POST['idsup']);
$sql=$conn->query("DELETE FROM suplier WHERE idsup='$idsup' ");
?>