<?php 
include ("../conn.php");
?>
<h3><i class="fa fa-angle-right"></i>Laporan Barang Keluar</h3>
<!-- tabel -->
<div class="row mt">
  <div class="col-md-12">
      
      <div class="content-panel">
        <div class="row">
                <div class="col-sm-3">
                    <h4><i class="fa fa-angle-right"></i> Data Laporan Barang Keluar</h4> 
                </div>
                <div class="col-sm-5"></div>
                <div class="col sm-4">
                    <form target="_blank" action="<?=base_url();?>keluar_pdf.php" class="">
                        <div class="forn-group">

                            <input type="date"  name="date1" required>
                            <input type="date"  name="date2" required>
                            <button class="btn btn-sm btn-success">
                                Print
                            </button>
                        </div>
                    </form>
                    </div>
            </div>
     
      </div><!-- /content-panel -->
