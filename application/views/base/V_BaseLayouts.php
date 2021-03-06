<!DOCTYPE html>

<html>

<head>
	<meta charset="utf-8">
	<title>NIKITA</title>
	<link rel="icon" type="image/png" sizes="16x16" href="">

	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
	<link rel="stylesheet" href="<?=base_url('assets/css/bootstrap.min.css')?>">
	<!-- <link rel="stylesheet" href="<?=base_url('assets/css/nikita-custom.css')?>"> -->
	<!-- <link rel="stylesheet" href="<?=base_url('assets/css/nikita-override-custom.css')?>"> -->
	<link rel="stylesheet" href="<?=base_url('assets/css/fa/css/all.min.css')?>">
	<link rel="stylesheet" href="<?=base_url('assets/css/bootstrap-datepicker.css')?>">
	<link rel="stylesheet" href="<?=base_url('assets/css/bootstrap-datepicker.min.css')?>">
  <link rel="stylesheet" href="<?=base_url('assets/css/bootstrap-datetimepicker.css')?>">
  <link rel="stylesheet" href="<?=base_url('assets/css/datatable.css')?>">
	<link rel="stylesheet" href="<?=base_url('assets/css/jquery.dataTables.min.css')?>">
	<link rel="stylesheet" href="<?=base_url('assets/css/responsive.dataTables.min.css')?>">
  <link rel="stylesheet" href="<?=base_url('assets/css/datatable.bootstrap.min.css')?>">
  
	<link rel="stylesheet" href="<?=base_url('assets/css/bootstrap-select.css')?>">
	<!-- template -->
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="<?=base_url('assets/img/apple-icon.png')?>">
	<link rel="icon" type="image/png" href="<?=base_url('assets/img/favicon.png')?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<!--     Fonts and icons     -->
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
	<!-- CSS Files -->
	<link rel="stylesheet" href="<?=base_url('assets/css/material-dashboard.css?v=2.1.2')?>">
	<!-- <link href="../assets/css/material-dashboard.css?v=2.1.2" rel="stylesheet" /> -->
	<!-- CSS Just for demo purpose, don't include it in your project -->
	<!-- <link href="../assets/demo/demo.css" rel="stylesheet" /> -->

	<script src="<?=base_url('assets/js/jquery.js')?>"></script>
	<script src="<?=base_url('assets/js/jquery-ui.js')?>"></script>
	<script src="<?=base_url('assets/js/bootstrap.min.js')?>"></script>
	<script src="<?=base_url('assets/js/bootstrap-datepicker.min.js')?>"></script>
	<script src="<?=base_url('assets/js/bootstrap-datepicker.js')?>"></script>
	<script src="<?=base_url('assets/js/bootstrap-datetimepicker.js')?>"></script> 
  <script src="<?=base_url('assets/js/datatable.js')?>"></script>
  <script src="<?=base_url('assets/js/dataTables.bootstrap4.min.js')?>"></script>
  <script src="<?=base_url('assets/js/dataTables.fixedHeader.min.js')?>"></script>
  <script src="<?=base_url('assets/js/dataTables.responsive.min.js')?>"></script>
  <script src="<?=base_url('assets/js/core/jquery.min.js')?>"></script>

  <script src="<?=base_url('assets/js/bootstrap-select.js')?>"></script>
<script src="<?=base_url('assets/js/general.js')?>"></script>

	<script>
		const base_url = "<?=base_url()?>"

	</script>
</head>
<style>
</style>		
<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="purple" data-background-color="white" data-image="../assets/img/sidebar-3.jpg">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
      <div class="logo"><a href="#" class="simple-text logo-normal">
          ADMIN POS KORS
        </a></div>
	  <!-- sidebar -->
    <?php $this->load->view('partials/V_SideBar')?>      
	  <!-- end of sidebar -->
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <?php $this->load->view('partials/V_NavBar')?>      
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
          <?php (isset($page_content)) ? $this->load->view($page_content) : ''?>          
        </div>
      </div>
      <?php $this->load->view('partials/V_Footer')?>
    </div>
  </div>
  <!-- <div class="fixed-plugin">
    <div class="dropdown show-dropdown">
      <a href="#" data-toggle="dropdown">
        <i class="fa fa-cog fa-2x"> </i>
      </a>
      <ul class="dropdown-menu">
        <li class="header-title"> Sidebar Filters</li>
        <li class="adjustments-line">
          <a href="javascript:void(0)" class="switch-trigger active-color">
            <div class="badge-colors ml-auto mr-auto">
              <span class="badge filter badge-purple" data-color="purple"></span>
              <span class="badge filter badge-azure" data-color="azure"></span>
              <span class="badge filter badge-green" data-color="green"></span>
              <span class="badge filter badge-warning" data-color="orange"></span>
              <span class="badge filter badge-danger" data-color="danger"></span>
              <span class="badge filter badge-rose active" data-color="rose"></span>
            </div>
            <div class="clearfix"></div>
          </a>
        </li>
        <li class="header-title">Images</li>
        <li class="active">
          <a class="img-holder switch-trigger" href="javascript:void(0)">
            <img src="../assets/img/sidebar-1.jpg" alt="">
          </a>
        </li>
        <li>
          <a class="img-holder switch-trigger" href="javascript:void(0)">
            <img src="../assets/img/sidebar-2.jpg" alt="">
          </a>
        </li>
        <li>
          <a class="img-holder switch-trigger" href="javascript:void(0)">
            <img src="../assets/img/sidebar-3.jpg" alt="">
          </a>
        </li>
        <li>
          <a class="img-holder switch-trigger" href="javascript:void(0)">
            <img src="../assets/img/sidebar-4.jpg" alt="">
          </a>
        </li>
        <li class="button-container">
          <a href="https://www.creative-tim.com/product/material-dashboard" target="_blank" class="btn btn-primary btn-block">Free Download</a>
        </li>
        <li class="button-container">
          <a href="https://demos.creative-tim.com/material-dashboard/docs/2.1/getting-started/introduction.html" target="_blank" class="btn btn-default btn-block">
            View Documentation
          </a>
        </li>
        <li class="button-container github-star">
          <a class="github-button" href="https://github.com/creativetimofficial/material-dashboard" data-icon="octicon-star" data-size="large" data-show-count="true" aria-label="Star ntkme/github-buttons on GitHub">Star</a>
        </li>
        <li class="header-title">Thank you for 95 shares!</li>
        <li class="button-container text-center">
          <button id="twitter" class="btn btn-round btn-twitter"><i class="fa fa-twitter"></i> &middot; 45</button>
          <button id="facebook" class="btn btn-round btn-facebook"><i class="fa fa-facebook-f"></i> &middot; 50</button>
          <br>
          <br>
        </li>
      </ul>
    </div>
  </div> -->
  <!--   Core JS Files   -->

  <script src="<?=base_url('assets/js/core/popper.min.js')?>"></script>
  <script src="<?=base_url('assets/js/core/bootstrap-material-design.min.js')?>"></script>
  <script src="<?=base_url('assets/js/plugins/perfect-scrollbar.jquery.min.js')?>"></script>
  <!-- Plugin for the momentJs  -->
  <script src="<?=base_url('assets/js/plugins/moment.min.js')?>"></script>
  <!--  Plugin for Sweet Alert -->
  <script src="<?=base_url('assets/js/plugins/sweetalert2.js')?>"></script>
  <!-- Forms Validations Plugin -->
  <script src="<?=base_url('assets/js/plugins/jquery.validate.min.js')?>"></script>
  <!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
  <script src="<?=base_url('assets/js/plugins/jquery.bootstrap-wizard.js')?>"></script>
  <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
  <script src="<?=base_url('assets/js/plugins/bootstrap-selectpicker.js')?>"></script>
  <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
  <script src="<?=base_url('assets/js/plugins/bootstrap-datetimepicker.min.js')?>"></script>
  <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
  <script src="<?=base_url('assets/js/plugins/jquery.dataTables.min.js')?>"></script>
  <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
  <script src="<?=base_url('assets/js/plugins/bootstrap-tagsinput.js')?>"></script>
  <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
  <script src="<?=base_url('assets/js/plugins/jasny-bootstrap.min.js')?>"></script>
  <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
  <script src="<?=base_url('assets/js/plugins/fullcalendar.min.js')?>"></script>
  <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
  <script src="<?=base_url('assets/js/plugins/jquery-jvectormap.js')?>"></script>
  <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
  <script src="<?=base_url('assets/js/plugins/nouislider.min.js')?>"></script>
  <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js')?>"></script> -->
  <!-- Library for adding dinamically elements -->
  <script src="<?=base_url('assets/js/plugins/arrive.min.js')?>"></script>
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chartist JS -->
  <script src="<?=base_url('assets/js/plugins/chartist.min.js')?>"></script>
  <!--  Notifications Plugin    -->
  <script src="<?=base_url('assets/js/plugins/bootstrap-notify.js')?>"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="<?=base_url('assets/js/material-dashboard.js?v=2.1.2')?>" type="text/javascript"></script>

  
</body>

</html>
