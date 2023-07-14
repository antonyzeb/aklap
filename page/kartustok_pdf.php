<?php 
include ("../conn.php");
include '../helpers/Format.php';
$fm=new Format();
extract($_GET);
$sqllimit=$conn->query("
                      SELECT detail_barang_masuk.id_masuk as ctrans,kobar,qty,tgl_masuk as tanggalnya,'masuk' as type FROM `detail_barang_masuk` LEFT JOIN barang_masuk ON detail_barang_masuk.id_masuk=barang_masuk.id_masuk 
WHERE kobar='$kobar'  AND DATE(tgl_masuk) BETWEEN '$date1' AND '$date2'

UNION ALL

SELECT detail_barang_keluar.id_keluar as ctrans,kobar,qty,tgl_keluar as tanggalnya, 'keluar' as type from detail_barang_keluar left JOIN barang_keluar on barang_keluar.id_keluar=detail_barang_keluar.id_keluar where kobar='$kobar'  AND DATE(tgl_keluar) BETWEEN '$date1' AND '$date2'


ORDER by tanggalnya LIMIT 1
                      ");
$dtl=$sqllimit->fetch_assoc();
            $firstTrxid=$dtl['ctrans'];
            $firstTrxType=$dtl['type'];
            
            $stokawal=$conn->query("
              SELECT stok FROM tbl_stok WHERE trxid='$firstTrxid' AND type='$firstTrxType' AND kobar='$kobar'
                      ")->fetch_assoc()['stok'];
$html = "
<table border='1' width='100%' style='border-collapse: collapse;'>
        <tr>
            <td colspan='6'>
            	<h1 style='text-align:center'>KARTU STOK BARANG ".ucfirst($kobar)."</h1>
                <p style='text-align:center'>Jl. ABC No 123, Jatibening, Kota Bekasi, Jawa Barat</p>
                <p style='text-align:center'>HP: 0812265xxx Email : email@abc.com Website : https://example.com</p>
                
            </td>
           
        </tr>
        <tr>
            <th style='background:#ccc;'>No</th>
            <th style='background:#ccc;'>Idtrx</th>
            <th style='background:#ccc;'>Kode Barang</th>
            <th style='background:#ccc;'>Type</th>
            <th style='background:#ccc;'>Time</th>
            <th style='background:#ccc;'>Qty</th>
        </tr>
        <tr>
        <th colspan='5'>Stok Awal</th>
        <th>".$stokawal."</th>
      </tr>
              ";
       
                $stoksekarang=$stokawal;
                $qn="
                      SELECT detail_barang_masuk.id_masuk as ctrans,kobar,qty,tgl_masuk as tanggalnya,'masuk' as type FROM `detail_barang_masuk` LEFT JOIN barang_masuk ON detail_barang_masuk.id_masuk=barang_masuk.id_masuk 
				WHERE kobar='$kobar' AND DATE(tgl_masuk) BETWEEN '$date1' AND '$date2'

				UNION ALL

				SELECT detail_barang_keluar.id_keluar as ctrans,kobar,qty,tgl_keluar as tanggalnya, 'keluar' as type from detail_barang_keluar left JOIN barang_keluar on barang_keluar.id_keluar=detail_barang_keluar.id_keluar where kobar='$kobar' AND DATE(tgl_keluar) BETWEEN '$date1' AND '$date2'


				ORDER by tanggalnya
                      ";
               $sql=$conn->query($qn);
                  $no=1;

                    
		           while ($r = $sql->fetch_assoc()) {
                    $html.="
                        <tr>
                            <td>".$no++."</td>
                            <td>".$r['ctrans']."</td>
                            <td>".$r['kobar']."</td>
                            <td>".$r['type']."</td>
                            <td>".$r['tanggalnya']."</td>
                            <td>".$r['qty']."</td>
                        </tr>";
                        if ($r['type']=='masuk') {
			              $stoksekarang+=$r['qty'];
			            }else{
			              $stoksekarang-=$r['qty'];
			             }
                  }
        $html.="
        <tr>
                  <td colspan='5'>Stok Akhir</td>
                  <td>".$stoksekarang."</td>
                </tr>
        
        </table>";
$filename = "kartustok-$kobar";

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