<?php
include ("../conn.php");
include '../helpers/Format.php';
$fm=new Format();
extract($_GET);
$html = "
<table border='1' width='100%' style='border-collapse: collapse;'>
        <tr>
            <td colspan='5'>
                <h1 style='text-align:center'>LAPORAN BARANG KELUAR PT ABC</h1>
                <p style='text-align:center'>Jl. ABC No 123, Jatibening, Kota Bekasi, Jawa Barat</p>
                <p style='text-align:center'>HP: 0812265xxx Email : email@abc.com Website : https://example.com</p>
            </td>
           
        </tr>
        <tr>
            <th style='background:#ccc;'>No</th>
            <th style='background:#ccc;'>Kode</th>
            <th style='background:#ccc;'>Tgl Keluar</th>
            <th style='background:#ccc;'>Barang</th>
            <th style='background:#ccc;'>Jumlah</th>
        </tr>";
       
                    $sql=$conn->query("
                      SELECT 
                        * FROM detail_barang_keluar a 
                        LEFT JOIN barang_keluar b ON a.id_keluar=b.id_keluar 
                        LEFT JOIN barang d ON d.kobar=a.kobar 
                        
                        WHERE DATE(tgl_keluar) BETWEEN '$date1' AND '$date2' ORDER BY tgl_keluar DESC
                        ");
               
                  $no=1;
                  $sumqty=0;
                  $sumtotharga=0;
                  while ($r = $sql->fetch_assoc()) {
                    $total=$r['qty']*$r['harga'];
                    $sumqty+=$r['qty'];
                    $sumtotharga+=$total;
                    $html.="
                        <tr>
                            <td>".$no++."</td>
                            <td>".$r['kobar']."</td>
                            <td>".$r['tgl_keluar']."</td>
                            <td>".$r['nama_barang']."</td>
                            <td>".$r['qty']."</td>
                        </tr>";
                  }
        $html.="
        <tr>
            <td colspan='4'>Total</td>
            <td>".$sumqty."</td>
        </tr>
        
        </table>";
$filename = "newpdffile";

// include autoloader
require_once '../dompdf/dompdf/autoload.inc.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();

$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream($filename,array("Attachment"=>0));