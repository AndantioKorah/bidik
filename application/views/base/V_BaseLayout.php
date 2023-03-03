<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?=TITLES?></title>
  <link rel="shortcut icon" href="<?=base_url('assets/new_login/images/logo-bidik-2.png')?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="<?=base_url('plugins/fontawesome-free/css/all.min.css')?>">
	<!-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->
	<link rel="stylesheet" href="<?=base_url('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')?>">
	<link rel="stylesheet" href="<?=base_url('plugins/icheck-bootstrap/icheck-bootstrap.min.css')?>">
	<link rel="stylesheet" href="<?=base_url('plugins/jqvmap/jqvmap.min.css')?>">
	<link rel="stylesheet" href="<?=base_url('assets/css/adminlte.min.css')?>">
	<link rel="stylesheet" href="<?=base_url('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')?>">
	<link rel="stylesheet" href="<?=base_url('plugins/daterangepicker/daterangepicker.css')?>">
	<link rel="stylesheet" href="<?=base_url('plugins/summernote/summernote-bs4.css')?>">
	<!-- <link rel="stylesheet" href="<?php// echo base_url('assets/css/font.css')?>"> -->
	<link rel="stylesheet" href="<?=base_url('assets/css/datatable.css')?>">
	<link rel="stylesheet" href="<?=base_url('assets/css/jquery.dataTables.min.css')?>">
	<link rel="stylesheet" href="<?=base_url('assets/css/responsive.dataTables.min.css')?>">
	<link rel="stylesheet" href="<?=base_url('assets/css/datatable.bootstrap.min.css')?>">

	<script src="<?=base_url('plugins/jquery/jquery.js')?>"></script>
	<script src="<?=base_url('plugins/jquery-ui/jquery-ui.js')?>"></script>
  <script src="<?=base_url('plugins/inputmask/inputmask/inputmask.js')?>"></script>
  <script src="<?=base_url('plugins/inputmask/inputmask/jquery.inputmask.js')?>"></script>

  <link href="<?=base_url('assets/css/select2.min.css')?>" rel="stylesheet" />
  <script src="<?=base_url('assets/js/select2.min.js')?>"></script>
  <script src="<?=base_url('assets/css/general.css')?>"></script>

	<link rel="stylesheet" href="<?=base_url('assets/css/bootstrap-datetimepicker.css')?>">
  <link rel="stylesheet" href="<?=base_url('assets/css/bootstrap-datepicker.css')?>">
  <script src="<?=base_url('assets/js/bootstrap-datetimepicker.js')?>"></script>
  <script src="<?=base_url('assets/js/bootstrap-datepicker.js')?>"></script>
  <link rel="stylesheet" href="<?=base_url('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')?>">


  <style>
    body{
      font-size: 15px !important;
    }

    .form-control:focus{
      border-color: #001f3f !important;
    }

    .form-control{
      color: black !important;
    }

    .btn-navy{
      color: white;
      background-color: #001f3f !important;
      text-decoration: none;
    }

    .btn-navy:hover{
      color: white;
      background-color: #05519e !important;
      text-decoration: none;
    }

    .btn-outline-navy{
      color: #001f3f;
      background-color: white !important;
      text-decoration: none;
      border-color: #001f3f;
    }

    .btn-outline-navy:hover{
      color: white;
      background-color: #001f3f !important;
      text-decoration: none;
    }
    
    .content-header{
      padding: 8px !important;
    }


  /* fixed header and coloum table */
  .tableFixHead { overflow-y: auto; height: 600px; }

  .content_table{
                     font-size: 13px;
                     /* text-align: center; */
                        }

  .tableFixHead table { 
              border: 1px solid #fff;
              font-size: 13px;
            } 
            
    .tableFixHead th { 
              background-color: #464646;
              color: #d1d1d1;
              border-top: 5px;
              padding: 8px 15px; 
              font-weight: normal;
            } 


        .tableFixHead tr:nth-child(even) th[scope=row] {
        background-color: #f2f2f2;
        color: black;
        }

    
        .tableFixHead tr:nth-child(odd) th[scope=row] {
        background-color: #fff;
        
        }

        .tableFixHead tr:nth-child(even) {
        background-color: rgba(0, 0, 0, 0.05);
        }

        .tableFixHead tr:nth-child(odd) {
        background-color: rgba(255, 255, 255, 0.05);
        }

        .tableFixHead td:nth-of-type(2) {
        width: 100px;
        }

        .tableFixHead th:nth-of-type(3),
        td:nth-of-type(3) {
        /* text-align: center; */
        } 



       /* @media screen and (width> 600px) {
        .tableFixHead th[scope=row] {
        position: -webkit-sticky;
        position: sticky;
        left: 0;
        z-index: 0;
        }
       } */

 
        /* .tableFixHead th[scope=row] {
        vertical-align: top;
        color: inherit;
        background-color: inherit;
        background: linear-gradient(90deg, transparent 0%, transparent calc(100% - .05em), #d6d6d6 calc(100% - .05em), #d6d6d6 100%);
        z-index: 0;
        }
         */

        /* .tableFixHead table:nth-of-type(2)  th:not([scope=row]):first-child {
        left: 0;
        z-index: 0;
        background: linear-gradient(90deg, #666 0%, #666 calc(100% - .05em), #ccc calc(100% - .05em), #ccc 100%);
        } */


        /* .tableFixHead th[scope=row] + td {

        }

        .tableFixHead th[scope=row] {
        z-index: 0;
        min-width: 20em;
        } */


        .cd-search{
        padding: 10px;
        border: 1px solid #ccc;
        width: 100%;
        box-sizing: border-box;
        margin-bottom: 10px;
        border-radius: 0px;
                   }

        .tableFixHead tr:nth-child(odd) td {
            background: white;
           
        }

        .tableFixHead tr:nth-child(even) td {
            background: #f2f2f2;
        }

        /* @media screen and (width> 600px) {
        .tableFixHead tr>td:first-child + td {
        position: sticky;
        left: 0;
        min-width: 20em;
        }
       } */


        /* FIXED LEFT COLOUM WITH HEADER */
        .div_maintb {
    /* height: calc(100vh - 180px);
    width: calc(100vw - 100px);
    overflow: scroll;
    border: 1px solid #6f6f6f; */
    overflow-y: auto; height: 600px;

}

.div_maintb table { 
      border: 1px solid #fff;
      font-size: 14px;
      width: 100%;
  } 
  
.div_maintb thead {
            position: sticky;
            top: 0;
            z-index: 400;
            }
   

.div_maintb th {
        background: #464646;
        color: #d1d1d1;
        width: 100px;
        min-width: 100px;
        padding: 6px;
        /* outline: 1px solid #7a7a7a; */
        font-weight: normal;
        margin-bottom:50px;
    }

    /* .div_maintb td {
        padding: 6px;
        outline: 1px solid #c3c3c3;
    } */

        /* .div_maintb th:nth-child(1),
        .div_maintb td:nth-child(1) {
            position: sticky;
            left: 0;
            width: 130px;
            min-width: 130px;
        } */

   @media screen and (width> 600px) {
          .div_maintb th:nth-child(2),
          .div_maintb td:nth-child(2) {
            position: sticky;
            left: 0;
            width: 50px;
            min-width: 50px;
        }
         }


        
    .div_maintb td:nth-child(2) {
              z-index: 200;
              min-width: 20em;
          }

      .div_maintb th:nth-child(1),
      .div_maintb th:nth-child(2) {
          z-index: 300;
      }

      .div_maintb tr:nth-child(odd) td {
      background: white;
    
      }

      .div_maintb tr:nth-child(even) td {
          background: #f2f2f2;
      }
        /* TUTUP FIXED LEFT COLOUM WITH HEADER  */


  
  /* fixed header and coloum table */
  </style>
</head>
<?php
  $params_exp_app = $this->general_library->getParams('PARAM_EXP_APP');
?>
<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse">
<div class="wrapper">
  <?php $this->load->view('partials/V_NavBar')?>      
  <?php $this->load->view('partials/V_SideBar')?>      
  <div class="content-wrapper">
    <!-- <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div>
        </div>
      </div>
    </div> -->
    <section class="content-header">
    </section>
    <section class="content">
      <div class="container-fluid">
	      <?php (isset($page_content)) ? $this->load->view($page_content) : ''?>
      </div>
    </section>
  </div>
  <?php $this->load->view('partials/V_Footer')?>
  <aside class="control-sidebar control-sidebar-dark">
  </aside>
</div>
<div class="modal fade" id="edit_data_pasien" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
          <div class="modal-header">
              <h6 class="modal-title">EDIT DATA PASIEN</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div id="edit_data_pasien_content">
          </div>
      </div>
  </div>
</div>
<div class="modal fade" id="edit_data_pendaftaran" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
          <div class="modal-header">
              <h6 class="modal-title">EDIT DATA PENDAFTARAN</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div id="edit_data_pendaftaran_content">
          </div>
      </div>
  </div>
</div>
<div id="print_div" style="display:none;"></div>
<iframe id="printing-frame" name="print_frame" src="about:blank" style="display:none;"></iframe>
<script>

function fixedHeaderTable() {
  var $th = $('.tableFixHead').find('thead th')
  $('.tableFixHead').on('scroll', function() {
  $th.css('transform', 'translateY('+ this.scrollTop +'px)');
  $th.css('zIndex', '60');
  $th.css({ 'position': 'relative' });
  });



// Search table
'use strict';

var TableFilter = (function() {
 var Arr = Array.prototype;
		var input;
  
		function onInputEvent(e) {
			input = e.target;
			var table1 = document.getElementsByClassName(input.getAttribute('data-table'));
			Arr.forEach.call(table1, function(table) {
				Arr.forEach.call(table.tBodies, function(tbody) {
					Arr.forEach.call(tbody.rows, filter);
				});
			});
		}

		function filter(row) {
			var text = row.textContent.toLowerCase();
       //console.log(text);
      var val = input.value.toLowerCase();
      //console.log(val);
			row.style.display = text.indexOf(val) === -1 ? 'none' : 'table-row';
		}

		return {
			init: function() {
				var inputs = document.getElementsByClassName('table-filter');
				Arr.forEach.call(inputs, function(input) {
					input.oninput = onInputEvent;
				});
			}
		};
 
	})();
 TableFilter.init(); 
 // Tutup Search table
}



  var live_date_time = ''
  var timertoast = 2500
  
  $(function(){
    $('.select2_this').select2()

    startTime()
    startRealTimeDate()
    startCountDownExpireApp()

    $('.format_currency_this').on('keypress', function(event){
        if(event.charCode >= 48 && event.charCode <= 57){
            return true;
        } else {
            return false;
        }
    })

    function startCountDownExpireApp(){
      var countDownDate = new Date('<?=$params_exp_app['parameter_value']?>').getTime();
      var x = setInterval(function() {
        var now = new Date().getTime();
        var distance = countDownDate - now;
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        var count_down = days + "h " + hours + "j " + minutes + "m " + seconds + "d";
        // if(days == 0){
        //   count_down = hours + "j " + minutes + "m " + seconds + "d";
        // }
        // if(hours == 0){
        //   count_down = minutes + "m " + seconds + "d";          
        // }
        // if(minutes == 0){
        //   count_down = seconds + "d";
        // }
        if (distance < 0) {
          clearInterval(x);
          count_down = "EXPIRED";
        }
        $('.count_down_exp_app').html(count_down);
        
      }, 500);
    }

    function formatRupiah(angka, prefix = "Rp ") {
        var number_string = angka.replace(/[^,\d]/g, "").toString(),
            split = number_string.split(","),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
            separator = sisa ? "." : "";
            rupiah += separator + ribuan.join(".");
        }

        rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
        return prefix == undefined ? rupiah : rupiah ? rupiah : "";
    }

    $('.format_currency_this').on('keyup', function(){
      $(this).val(formatRupiah($(this).val()))
    })
    
  })

  function countBobotNilaiKomponenKinerja(capaian){
    let bobot = 30;
    if(capaian >= 350 && capaian < 679){
        bobot = (capaian / 700) * 0.3;
        bobot = bobot * 100;
    } else if(capaian < 350) {
        bobot = 0;
    }
    return bobot;
  }

  function divLoaderNavy(message = 'Loading'){
    return '<div class="col-12 text-center" style="height: 100%; id="loader"> <i style="color: #001f3f;" class="fas fa-3x fa-spin fa-sync-alt"></i> </div>'
  }

  function cardBodyLoader(message = 'Loading'){
    return '<div class="overlay text-center" style="height: 100%; background-color: #c1c1c1;" id="loader"> <i style="color: white;" class="fas fa-3x fa-spin fa-sync-alt"></i> </div>'
  }

  function successtoast(message = ''){
    const Toast = Swal.mixin({
      toast: true,
      position: 'top',
      showConfirmButton: false,
      timer: timertoast
    });

    Toast.fire({
      icon: 'success',
      title: message
    })
  }

  function errortoast(message = ''){
    const Toast = Swal.mixin({
      toast: true,
      position: 'top',
      showConfirmButton: false,
      timer: timertoast
    });

    Toast.fire({
      icon: 'error',
      title: message
    })
  }

  function warningtoast(message = ''){
    const Toast = Swal.mixin({
      toast: true,
      position: 'top',
      showConfirmButton: false,
      timer: timertoast
    });

    Toast.fire({
      icon: 'warning',
      title: message
    })
  }

  function startTime() {
    var weekday = new Array(7);
    weekday[0] = "Minggu";
    weekday[1] = "Senin";
    weekday[2] = "Selasa";
    weekday[3] = "Rabu";
    weekday[4] = "Kamis";
    weekday[5] = "Jumat";
    weekday[6] = "Sabtu";

    var monthName = new Array(12);
    monthName[1] = "Januari";
    monthName[2] = "Februari";
    monthName[3] = "Maret";
    monthName[4] = "April";
    monthName[5] = "Mei";
    monthName[6] = "Juni";
    monthName[7] = "Juli";
    monthName[8] = "Agustus";
    monthName[9] = "September";
    monthName[10] = "Oktober";
    monthName[11] = "November";
    monthName[12] = "Desember";

    var today = new Date();
    var D = String(today.getDate()).padStart(2, '0');
    var M = String(today.getMonth() + 1).padStart(2, '0');
    var Y = today.getFullYear();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    h = checkTime(h);
    live_date_time = weekday[today.getDay()] + ', ' + D + ' ' + monthName[today.getMonth() + 1] + ' ' + Y + ' / ' + h + ":" + m + ":" + s
    $('#live_date_time').html(live_date_time)
    $('#live_date_time_welcome').html(live_date_time)
    var t = setTimeout(startTime, 500);
  }

  function startRealTimeDate() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    var D = String(today.getDate()).padStart(2, '0');
    var M = String(today.getMonth() + 1).padStart(2, '0');
    var Y = today.getFullYear();
    m = checkTime(m);
    s = checkTime(s);
    h = checkTime(h);
    live_date_time = Y + "-" + M + "-" + D + " " + h + ":" + m + ":" + s
    $('.realdatetimethis').val(live_date_time)
    var t = setTimeout(startRealTimeDate, 500);
  }

  function formatDateTime(data) {
    var today = new Date(data);
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    var D = String(today.getDate()).padStart(2, '0');
    var M = String(today.getMonth() + 1).padStart(2, '0');
    var Y = today.getFullYear();
    m = checkTime(m);
    s = checkTime(s);
    h = checkTime(h);
    format = D + "/" + M + "/" + Y + " " + h + ":" + m + ":" + s
    return format
  }

  function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
  }



$('.datepickerthis').datepicker({
    format: 'yyyy-mm-dd',
    orientation: 'bottom',
    autoclose: true,
    todayHighlight: true
});

$('.datepicker').datepicker({
    format: 'yyyy',
    viewMode: "years", 
    minViewMode: "years",
    orientation: 'bottom',
    autoclose: true
});


function getFirstDayOfMonth(year, month) {
  return new Date(year, month, 1);
}

var date = new Date();
var firstDay = getFirstDayOfMonth(
  date.getFullYear(),
  date.getMonth(),
);

  $('.datetimepickerthis').datetimepicker({
    format: 'yyyy-mm-dd hh:ii:ss',
    autoclose: true,
    todayHighlight: true,
    todayBtn: true,
    startDate: firstDay,
    endDate: new Date()
  })
  

  $('.datetimepickermaxtodaythis').datetimepicker({
    format: 'yyyy-mm-dd hh:ii:ss',
    autoclose: true,
    todayHighlight: true,
    todayBtn: true,
    endDate: new Date()
  })

 

  $('.datetimepickermaxtodaythis').on('changeDate', function (ev) {
      $(this).removeClass('realdatetimethis')
  });

  $('.datetimepickermaxtodaythis').on('click', function (ev) {
      $(this).addClass('realdatetimethis')
  });

  function select2ajax(elementid, url, value, label, minInputText = 2){
    $("#"+elementid).select2({
        tokenSeparators: [',', ' '],
        minimumInputLength: minInputText,
        minimumResultsForSearch: 10,
        ajax: {
            url: url,
            dataType: "json",
            type: "POST",
            data: function (params) {

                var queryParameters = {
                    search_param: params.term
                }
                return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.label,
                            id: item.value
                        }
                    })
                };
            }
        }
    });
  }

  function openModalEditPasien(norm = 0, callback = 0){
    $('#edit_data_pasien_content').html('')
    $('#edit_data_pasien_content').append(divLoaderNavy)
    $('#edit_data_pasien_content').load('<?=base_url("pendaftaran/C_Pendaftaran/editDataPasienForm")?>'+'/'+norm+'/'+callback, function(){
      $('#loader').hide()
    })
  }

  function openModalEditPendaftaran(id = 0, callback = 0, key_callback = 'id_m_pasien'){
    $('#edit_data_pendaftaran_content').html('')
    $('#edit_data_pendaftaran_content').append(divLoaderNavy)
    $('#edit_data_pendaftaran_content').load('<?=base_url("pendaftaran/C_Pendaftaran/editDataPendaftaran")?>'+'/'+id+'/'+callback+'/'+key_callback, function(){
      $('#loader').hide()
    })
  }

  $.widget.bridge('uibutton', $.ui.button)



                
</script>
<script src="<?=base_url('plugins/bootstrap/js/bootstrap.bundle.min.js')?>"></script>
<script src="<?=base_url('plugins/chart.js/Chart.min.js')?>"></script>
<script src="<?=base_url('plugins/sparklines/sparkline.js')?>"></script>
<!-- <script src="<?=base_url('plugins/jqvmap/jquery.vmap.min.js')?>"></script> -->
<!-- <script src="<?=base_url('plugins/jqvmap/maps/jquery.vmap.usa.js')?>"></script> -->
<script src="<?=base_url('plugins/jquery-knob/jquery.knob.min.js')?>"></script>
<script src="<?=base_url('plugins/moment/moment.min.js')?>"></script>
<script src="<?=base_url('plugins/daterangepicker/daterangepicker.js')?>"></script>
<script src="<?=base_url('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')?>"></script>
<script src="<?=base_url('plugins/summernote/summernote-bs4.min.js')?>"></script>
<script src="<?=base_url('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')?>"></script>
<script src="<?=base_url('assets/js/adminlte.js')?>"></script>
<!-- <script src="<?=base_url('assets/js/pages/dashboard.js')?>"></script> -->
<!-- <script src="<?=base_url('assets/js/demo.js')?>"></script> -->
<script src="<?=base_url('assets/js/jquery.dataTables.min.js')?>"></script>
<script src="<?=base_url('plugins/sweetalert2/sweetalert2.min.js')?>"></script>

  
</body>
</html>
