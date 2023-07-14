<?php 
error_reporting(1);
$conn = new mysqli("localhost","root","","appfifo");
date_default_timezone_set("Asia/Jakarta");
mysqli_set_charset($conn,"SET NAMES cp1256");
mysqli_set_charset($conn,"set characer set cp1256");

if (!function_exists('base_url')) {
    function base_url($atRoot=FALSE, $atCore=FALSE, $parse=FALSE){
        if (isset($_SERVER['HTTP_HOST'])) {
            $http = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
            $hostname = $_SERVER['HTTP_HOST'];
            $dir =  str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
            $core = preg_split('@/@', str_replace($_SERVER['DOCUMENT_ROOT'], '', realpath(dirname(__FILE__))), NULL, PREG_SPLIT_NO_EMPTY);
            $core = $core[0];
            $tmplt = $atRoot ? ($atCore ? "%s://%s/%s/" : "%s://%s/") : ($atCore ? "%s://%s/%s/" : "%s://%s%s");
            $end = $atRoot ? ($atCore ? $core : $hostname) : ($atCore ? $core : $dir);
            $base_url = sprintf( $tmplt, $http, $hostname, $end );
        }else $base_url = 'http://localhost/';
        if ($parse) {
            $base_url = parse_url($base_url);
            if (isset($base_url['path'])) if ($base_url['path'] == '/') $base_url['path'] = '';
        }
        return $base_url;
    }
}
$base_url = base_url();
function cekstok($kode){
    global $conn;
        $sql=$conn->query("
          SELECT SUM(sisa) as sisa FROM barang LEFT JOIN detail_barang_masuk ON barang.kobar = detail_barang_masuk.kobar WHERE detail_barang_masuk.kobar='$kode'
                      ");
        $dt=$sql->fetch_assoc()['sisa'];
        if ($dt==NULL) {
            $dt=0;
        }
        return $dt;
      
      }
    function cekharga($kode){
    global $conn;
        $sql=$conn->query("
          SELECT hargajual FROM barang WHERE kobar='$kode'
                      ");
        $dt=$sql->fetch_assoc()['hargajual'];
        if ($dt==NULL) {
            $dt=0;
        }
        return $dt;
      
      }

      

?>