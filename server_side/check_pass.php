<?php 
require "../conn.php";
$key=$_GET['pass'];
$id=$_GET['id'];
$query = $conn->query("SELECT def_pass FROM tbl_user WHERE id = '$id'");
$data = $query->fetch_assoc();
$hash = $data['def_pass'];
// $pass1 = password_verify($key,$hash);
if ($hash===$key) {
	?>
	<!-- <h5 style="color:green">password benar</h5> -->
	<?php 
}else if($hash != $key && $key != ''){ ?>
	<h5 style="color:red">password lama salah</h5>
	<?php 
}else{
	?>
	<h5 style="color:red">password harus diisi</h5>
	<?php 
}

?>