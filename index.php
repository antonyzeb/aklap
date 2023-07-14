<?php 
error_reporting(0);

include ('conn.php');

session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
}
$timeout = 60; // Set timeout satuan menit
$logout_redirect_url = "login.php"; // Set logout URL

$timeout = $timeout * 60; // Ubah menit ke detik
if (isset($_SESSION['start_time'])) {
    $elapsed_time = time() - $_SESSION['start_time'];
    if ($elapsed_time >= $timeout) {
        session_destroy();
        echo "<script> alert('Session Anda Telah Habis, Silahkan Login kembali!');
                                window.location = '$logout_redirect_url'</script>";
    }
}
$_SESSION['start_time'] = time();

include 'helpers/Format.php';

$fm=new Format();


header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache"); 
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); 
header("Cache-Control: max-age=2592000");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>FIFO Apps - Admin Panel</title>
    

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/gritter/css/jquery.gritter.css" />

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/zabuto_calendar.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/lineicons/style.css"> 
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style_pagination.css">  
     <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/fileinput/css/fileinput.min.css">
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/style-responsive.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css">
    
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/jquery-confirm/dist/jquery-confirm.min.css">
    
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
     <style>
          .option_chart{
            width: 26%; margin: auto; height: 100px; text-align:center;
          }
            .option_chart a{
              border: 1px solid gray;
              border-radius: 10px;
              padding: 10px;
              text-decoration:none;
              float:left;
              margin:4px;
              text-align:center;
              display: block;
              color: green;
            }
          </style>
  </head>

  <body>

  <section id="container" >
      <!-- **********************************************************************************************************************************************************
      TOP BAR CONTENT & NOTIFICATIONS
      *********************************************************************************************************************************************************** -->
      <!--header start-->
      <header class="header black-bg">
              <div class="sidebar-toggle-box">
                  <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
              </div>
            <!--logo start-->
            <a href="index.php" class="logo"><b>FIFO Inventory</b></a>
            <!--logo end-->
            <div class="nav notify-row" id="top_menu">
                <!--  notification start -->
                <ul class="nav top-menu">
                    <!-- settings start -->
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="fa fa-tasks"></i>
                            <span class="badge bg-theme">4</span>
                        </a>
                        <ul class="dropdown-menu extended tasks-bar">
                            <div class="notify-arrow notify-arrow-green"></div>
                            <li>
                                <p class="green">You have 4 pending tasks</p>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="task-info">
                                        <div class="desc">DashGum Admin Panel</div>
                                        <div class="percent">40%</div>
                                    </div>
                                    <div class="progress progress-striped">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                            <span class="sr-only">40% Complete (success)</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="task-info">
                                        <div class="desc">Database Update</div>
                                        <div class="percent">60%</div>
                                    </div>
                                    <div class="progress progress-striped">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                            <span class="sr-only">60% Complete (warning)</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="task-info">
                                        <div class="desc">Product Development</div>
                                        <div class="percent">80%</div>
                                    </div>
                                    <div class="progress progress-striped">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                            <span class="sr-only">80% Complete</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="task-info">
                                        <div class="desc">Payments Sent</div>
                                        <div class="percent">70%</div>
                                    </div>
                                    <div class="progress progress-striped">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: 70%">
                                            <span class="sr-only">70% Complete (Important)</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="external">
                                <a href="#">See All Tasks</a>
                            </li>
                        </ul>
                    </li>
                    <!-- settings end -->
                    <!-- inbox dropdown start-->
                    <li id="header_inbox_bar" class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="fa fa-envelope-o"></i>
                            <span class="badge bg-theme">0</span>
                        </a>
                        <ul class="dropdown-menu extended inbox">
                            <div class="notify-arrow notify-arrow-green"></div>
                            <li>
                                <p class="green">You have new messages</p>
                            </li>
                                                 
                            
                            <li>
                                <a href="?page=Inbox">See all messages</a>
                            </li>
                        </ul>
                    </li>
                    <!-- inbox dropdown end -->
                </ul>
                <!--  notification end -->
            </div>
            <div class="top-menu">
              <ul class="nav pull-right top-menu">
                    <li><a class="logout" href="logout.php">Logout</a></li>
              </ul>
            </div>
        </header>
      <!--header end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN SIDEBAR MENU
      *********************************************************************************************************************************************************** -->
      <!--sidebar start-->
      <aside>
          <div id="sidebar"  class="nav-collapse">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">
              
                  <p class="centered"><a href="?page=Profil"><img src="<?php echo base_url(); ?>assets/img/admin.jpg" class="img-circle" width="60"></a></p>
                  <h5 class="centered">Halo.. <i><?=$_SESSION['user'] ?></i></h5>
                    
                  
                   <li id="suplier">
                      <a href="#suplier">
                          <i class="fa fa-square"></i>
                          <span>Data Vendor</span>
                      </a>
                  </li>
                   <li id="stok">
                      <a href="#stok_barang">
                          <i class="fa fa-building"></i>
                          <span>Data Stok ATK</span>
                      </a>
                  </li><li id="kartustok">
                      <a href="#kartu_stok_barang">
                          <i class="fa fa-credit-card"></i>
                          <span>Kartu Stok ATK</span>
                      </a>
                  </li>
                   <li id="brg_masuk">
                      <a href="#barang_masuk">
                          <i class="fa fa-shopping-cart"></i>
                          <span>ATK Masuk</span>
                      </a>
                  </li>
                   <li id="lap_brgmasuk">
                      <a href="#lap_brgmasuk">
                          <i class="fa fa-flag-o"></i>
                          <span>Laporan ATK Masuk</span>
                      </a>
                  </li>

                   <li id="brg_keluar">
                      <a href="#barang_keluar">
                          <i class="fa fa-money"></i>
                          <span>ATK Keluar</span>
                      </a>
                  </li>
                  <li id="lap_brgkeluar">
                      <a href="#lap_brgkeluar">
                          <i class="fa fa-flag-o"></i>
                          <span>Laporan Barang Keluar</span>
                      </a>
                  </li>
                   <li id="setting">
                      <a href="#setting_user">
                          <i class="fa fa-cogs"></i>
                          <span>Setting User</span>
                      </a>
                  </li>

                  

              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>
      <!--sidebar end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">

            <div id="kontenku">
              
              
            </div>

            
      
        </section>
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->
      <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
            
             &copy;FIFO Inventory  By Antony<?php echo date('Y'); ?> - All Right Reserved
              <a href="index.php" class="go-top">
                  <i class="fa fa-angle-up"></i>
              </a>
          </div>
      </footer>
      <!--footer end-->
  </section>
    <!-- js placed at the end of the document so the pages load faster -->
     <script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery-1.8.3.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>   
    <script class="include" type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.scrollTo.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.sparkline.js"></script>
    <!--common script for all pages-->
    <script src="<?php echo base_url(); ?>assets/js/common-scripts.js"></script>    

        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/gritter-conf.js"></script>

   
    <script src="<?php echo base_url(); ?>assets/fileinput/js/fileinput.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/ckeditor/ckeditor.js"></script>

    <script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/plugins/jquery-confirm/dist/jquery-confirm.min.js"></script>
    <script type="text/javascript">
      

      $("#suplier").click(function(){
        $("#kontenku").load("<?php echo base_url(); ?>page/suplier.php");
      });
      $("#stok").click(function(){
        $("#kontenku").load("<?php echo base_url(); ?>page/stok.php");
      });
      $("#kartustok").click(function(){
        $("#kontenku").load("<?php echo base_url(); ?>page/kartustok.php");
      });
       $("#brg_masuk").click(function(){
        $("#kontenku").load("<?php echo base_url(); ?>page/barang_masuk.php");
      });
       $("#lap_brgmasuk").click(function(){
        $("#kontenku").load("<?php echo base_url(); ?>page/lap_barang_masuk.php");
      });
       $("#lap_brgkeluar").click(function(){
        $("#kontenku").load("<?php echo base_url(); ?>page/lap_barang_keluar.php");
      });
       $("#brg_keluar").click(function(){
        $("#kontenku").load("<?php echo base_url(); ?>page/barang_keluar.php");
      });
        $("#setting").click(function(){
        $("#kontenku").load("<?php echo base_url(); ?>page/setting.php");
      });
    </script>


    <script src="<?php echo base_url(); ?>assets/hc/highcharts.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/hc/exporting.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/hc/exporting.js" type="text/javascript"></script>
    <?php 

    $query_lates7days=$conn->query("
                                    SELECT
                                      DAY(MAX(tgl_keluar)) AS latest_post_day,
                                      MONTH(MAX(tgl_keluar)) AS latest_post_month,
                                      YEAR(MAX(tgl_keluar)) AS latest_post_year   
                                      FROM barang_keluar
                                  ");
    $fetch_latest=$query_lates7days->fetch_assoc();
    $latestdays=$fetch_latest['latest_post_day'];
    $latestmonth=$fetch_latest['latest_post_month'];
    $latestyear=$fetch_latest['latest_post_year'];
    $latest_date = strtotime($latestyear."-".$latestmonth."-".$latestdays);
    $selected_start_date = strtotime("-6 day", $latest_date);
    $full_selected_start_date = date("Y-m-d", $selected_start_date);
    $start_year = date("Y", $selected_start_date);
    $selected_start_date = date('d', $selected_start_date);
    $selected_end_date = $latestdays;
    $full_selected_end_date = date("Y-m-d", $latest_date);
    $year = $latestyear;
    $mon = $latestmonth;
    $mon_name_1 = $fm->getMonthName(substr($full_selected_start_date,5,2));
    $mon_name_2 = $fm->getMonthName($latestmonth);
    $start_date = $full_selected_start_date;
    $end_date = $full_selected_end_date;
    $text = "Since ".$selected_start_date." ".$mon_name_1." ".$start_year." until ".$selected_end_date." ".$mon_name_2." ".$year;
    $sql = $conn->query("SELECT           
                            *      
                            FROM barang
                        ");
    $sql_stok = $conn->query("SELECT        
                              nama_barang, COALESCE(SUM(detail_barang_masuk.sisa), 0) as sisa_stok       
                              FROM detail_barang_masuk        
                              RIGHT JOIN barang       
                              ON barang.kobar=detail_barang_masuk.kobar       
                              GROUP BY barang.kobar 
                        ");
    $sql_laba = $conn->query("SELECT DATE_FORMAT(tgl_keluar, '%Y-%m-%d') 
as tgl_keluar from barang_keluar GROUP BY DATE_FORMAT(tgl_keluar, '%Y-%m-%d')
                        "); 
    
    $data_baru=array();
    $data_baru[] = array('pendapatan'=>'Total Modal');
    $data_baru[] = array('pendapatan'=>'Total Pendapatan');
    $data_baru[] = array('pendapatan'=>'Total keuntungan bersih');

    ?>

    
   
  </body>
</html>