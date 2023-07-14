<?php 
require "../conn.php";
$kode =$_POST['kode'];
$data = array();
$queryResult = $conn->query("
								SELECT 
									nama_barang, barang.kobar as kobar,tgl_masuk, harga 
								FROM 
										barang  
								LEFT JOIN detail_barang_masuk
										ON barang.kobar=detail_barang_masuk.kobar
								LEFT JOIN barang_masuk ON barang_masuk.id_masuk=detail_barang_masuk.id_masuk
								WHERE barang.kobar ='$kode' 
									ORDER BY tgl_masuk DESC LIMIT 1
							");

$fetchData = $queryResult->fetch_assoc();
$data = $fetchData;
echo json_encode($data);
?>
