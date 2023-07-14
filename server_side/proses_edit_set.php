<?php 
require "../conn.php";
$id=$_POST['id'];
$user=$conn->real_escape_string($_POST['user']);
$lpass=$conn->real_escape_string($_POST['lpass']);
$npass=$conn->real_escape_string($_POST['nupass']);
$repass=$conn->real_escape_string($_POST['repass']);
$det=$conn->real_escape_string($_POST['det']);
$passbaru = password_hash($npass, PASSWORD_DEFAULT);
$file_name = $_FILES['image']['name'];
$file_temp = $_FILES['image']['tmp_name'];

$div = explode('.', $file_name);
$file_ext = strtolower(end($div));
$unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
$uploaded_image = "../upload/admin/".$unique_image;
$letak=$unique_image;

if (!empty($file_name)) {
        $query=$conn->query("SELECT image FROM tbl_user WHERE id = '$id'");
        $row=$query->fetch_assoc();
        $dellink = "../upload/admin/".$row['image'];
        
        if(file_exists($dellink)){
            unlink($dellink);
            move_uploaded_file($file_temp, $uploaded_image);
                $sql1=$conn->query("UPDATE tbl_user SET 
                    password='$passbaru',
                    def_pass='$npass',
                    details='$det',
                    image='$letak'
                    WHERE id ='$id'");
                  if ($sql1) {
                        echo json_encode(array("status" => TRUE));
                    }  
            }else{
                move_uploaded_file($file_temp, $uploaded_image);
                $sql2=$conn->query("UPDATE tbl_user SET 
                    password='$passbaru',
                    def_pass='$npass',
                    details='$det',
                    image='$letak'
                    WHERE id ='$id'");
                    if ($sql2) {
                        echo json_encode(array("status" => TRUE));
                    } 
            }
    }else{
        $sql3=$conn->query("UPDATE tbl_user SET 
                    password='$passbaru',
                    def_pass='$npass',
                    details='$det'
                    WHERE id ='$id'");
                    if ($sql3) {
                        echo json_encode(array("status" => TRUE));
                    } 

    }


?>
