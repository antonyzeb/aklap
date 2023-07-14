<?php 
require "../conn.php";
$user=strtolower($conn->real_escape_string($_POST['user']));
$pass=$conn->real_escape_string($_POST['pass']);
$email=$conn->real_escape_string($_POST['email']);
$det=$conn->real_escape_string($_POST['det']);
$passbaru = password_hash($pass, PASSWORD_DEFAULT);
$file_name = $_FILES['image']['name'];
$file_temp = $_FILES['image']['tmp_name'];

$div = explode('.', $file_name);
$file_ext = strtolower(end($div));
$unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
$uploaded_image = "../upload/admin/".$unique_image;

if (!empty($file_name)) {       
        
    move_uploaded_file($file_temp, $uploaded_image);
    $sql2=$conn->query("INSERT INTO tbl_user VALUES('','$user','$user','$passbaru','$pass','$email','$det','$unique_image')");
        if ($sql2) {
            echo json_encode(array("status" => TRUE));
        } 
            
    }else{
        $sql3=$conn->query("INSERT INTO tbl_user VALUES('','$user','$user','$passbaru','$pass','$email','$det','')");
        if ($sql3) {
            echo json_encode(array("status" => TRUE));
        } 

    }


?>
