<?php 
require "../conn.php";
$user=$_GET['user'];
$query = $conn->query("SELECT username FROM tbl_user WHERE username = '$user'");

if ($query->num_rows > 0) {
	?>
	
	<h5 style="color:red">User sudah ada, silakan coba username yg lain..</h5>
	<?php 
}else if($query->num_rows < 1 && $user != ''){
	?>
	<h5 style="color:green">username tersedia</h5>
	<?php 
}else{ ?>
	<h5 style="color:red">Username wajib diisi..</h5>
<?php }

?>