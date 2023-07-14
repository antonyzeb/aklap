<?php 
require "../conn.php";
$id=$conn->real_escape_string($_POST['id']);
$query=$conn->query("SELECT image FROM tbl_user WHERE id = '$id'");
$row=$query->fetch_assoc();
$dellink = "../upload/admin/".$row['image'];
if(file_exists($dellink)){
    unlink($dellink);
        $sql1=$conn->query("DELETE FROM tbl_user WHERE id='$id' ");
          if ($sql1) {
                echo json_encode(array("status" => TRUE));
            }  
}else{
        
        $sql2=$conn->query("DELETE FROM tbl_user WHERE id='$id'");
            if ($sql2) {
                echo json_encode(array("status" => TRUE));
            } 
}
?>