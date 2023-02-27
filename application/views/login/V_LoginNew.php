<!DOCTYPE html>
<html lang="en">
<head>
	<title><?=TITLES?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="shortcut icon" href="<?=base_url('assets/new_login/images/logo-bidik-2.png')?>" />
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/new_login/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/new_login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/new_login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/new_login/fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/new_login/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="assets/new_login/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/new_login/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/new_login/vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="assets/new_login/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/new_login/css/util.css">
	<link rel="stylesheet" type="text/css" href="assets/new_login/css/main.css">
	<link rel="stylesheet" href="<?=base_url('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')?>">
<!--===============================================================================================-->
</head>

<style>
	@media screen and (max-height: 700px) {
		.img_login_logo{
			width: 300px !important;
			height: 150px !important;
		}
	}

	.login-container{
		margin: 0;
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		width: 90%;
	}

	/* .showpassword::before {
		content: attr(data-content);
		position: absolute;
		max-width: 70%;
		background-color: #fff;
		border: 1px solid #c80000;
		border-radius: 2px;
		padding: 4px 30px 4px 10px;
		bottom: calc((100% - 25px) / 2);
		-webkit-transform: translateY(50%);
		-moz-transform: translateY(50%);
		-ms-transform: translateY(50%);
		-o-transform: translateY(50%);
		transform: translateY(50%);
		right: 2px;
		pointer-events: none;

		font-family: Poppins-Medium;
		color: #c80000;
		font-size: 14px;
		line-height: 1.4;
		text-align: left;

		visibility: hidden;
		opacity: 0;

		-webkit-transition: opacity 0.4s;
		-o-transition: opacity 0.4s;
		-moz-transition: opacity 0.4s;
		transition: opacity 0.4s;
	} */

</style>

<body style="background-color: #ebebeb;">
	
	<div class="limiter">
		<div class="container-login100">
			<div class="login100-more" style="background-image: url('assets/new_login/images/bg-efort.jpg');"></div>

			<div class="wrap-login100">
				<div class="login-container">
					<form class="login100-form validate-form" action="<?=base_url('login/C_Login/authenticateAdmin')?>" method="post">
						<div style="width: 100%;">
							<center>
								<span class="login100-form-title p-b-59">
									Selamat Datang!
								</span>
								<!-- <span class="login100-form-title p-b-59">
									APLIKASI PENILAIAN KINERJA PEGAWAI
								</span> -->
								<img class="img_login_logo" src="assets/new_login/images/logo-bidik-2.png" 
								style="height: 200px; 
									width: 400px;
									margin-left: -20px;
									"/>

							</center>
						</div>

						<!-- <span class="login100-form-title">
							Selamat datang!
						</span> -->

						<!-- <div class="wrap-input100 validate-input" data-validate="Name is required">
							<span class="label-input100">Full Name</span>
							<input class="input100" type="text" name="name" placeholder="Name...">
							<span class="focus-input100"></span>
						</div>

						<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
							<span class="label-input100">Email</span>
							<input class="input100" type="text" name="email" placeholder="Email addess...">
							<span class="focus-input100"></span>
						</div> -->
						
						<div class="wrap-input100 p-t-50" data-validate="Username is required">
							<span class="label-input100">Username</span>
							<input class="input100" autocomplete="off" type="text" name="username">
							<span class="focus-input100"></span>
						</div>

						<div class="wrap-input100" id="div_notshowpassword" data-content = "Show Password">
							<span class="label-input100">Password <i style="cursor: pointer;" id="showpassword" class="fa fa-eye"></i></span>
							<input class="input100" id="input_notshowpassword" autocomplete="off" type="password" name="password">
							<span class="focus-input100"></span>
						</div>

						<div style="display: none;" id="div_showpassword" class="wrap-input100" data-content = "Show Password">
							<span class="label-input100">Password <i style="cursor: pointer;" id="notshowpassword" class="fa fa-eye-slash"></i></span>
							<input class="input100" id="input_showpassword" autocomplete="off" type="text" name="password">
							<span class="focus-input100"></span>
						</div>

						<!-- <div class="wrap-input100 validate-input" data-validate = "Repeat Password is required">
							<span class="label-input100">Repeat Password</span>
							<input class="input100" type="text" name="repeat-pass" placeholder="*************">
							<span class="focus-input100"></span>
						</div> -->

						<!-- <div class="flex-m w-full p-b-33">
							<div class="contact100-form-checkbox">
								<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
								<label class="label-checkbox100" for="ckb1">
									<span class="txt1">
										I agree to the
										<a href="assets/new_login/#" class="txt2 hov1">
											Terms of User
										</a>
									</span>
								</label>
							</div>
						</div> -->

						<div class="container-login100-form-btn">
							<div class="wrap-login100-form-btn">
								<div class="login100-form-bgbtn"></div>
								<button type="submit" class="login100-form-btn">
									Sign In
									<i class="fa fa-long-arrow-right m-l-5"></i>
								</button>
							</div>

							<!-- <a href="assets/new_login/#" class="dis-block txt3 hov1 p-r-30 p-t-10 p-b-10 p-l-30">
								Sign in
								<i class="fa fa-long-arrow-right m-l-5"></i>
							</a> -->
						</div>
					</form>
					<div style="width: 100%; position: relative; float: bottom;" class="p-t-30">
						<center>
							<span class="login100-form-title-footer">
								<?=COPYRIGHT?>
							</span>
						</center>
					</div>
				</div>
			</div>
		</div>
	</div>
	
<!--===============================================================================================-->
	<script src="assets/new_login/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="assets/new_login/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="assets/new_login/vendor/bootstrap/js/popper.js"></script>
	<script src="assets/new_login/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="assets/new_login/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="assets/new_login/vendor/daterangepicker/moment.min.js"></script>
	<script src="assets/new_login/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="assets/new_login/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="assets/new_login/js/main.js"></script>

</body>
</html>
<script src="<?=base_url('plugins/sweetalert2/sweetalert2.min.js')?>"></script>
<script>

  $(function(){
	function errortoast(message = '', timertoast = 3000){
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

	console.log('message = <?=$this->session->flashdata('message');?>')

    <?php if($this->session->flashdata('message')){ ?>
		errortoast("<?=$this->session->flashdata('message')?>");
    //   $('#error_div').show()
    //   $('#error_div').append('<label>'+'<?=$this->session->flashdata('message')?>'+'</label>')
    <?php
      $this->session->set_flashdata('message', null);
    } ?>
  })

  function errortoast(message = '', timertoast = 3000){
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

  $('#showpassword').on('click', function(){
	  $('#div_showpassword').show()
	  $('#div_notshowpassword').hide()
  })

  $('#notshowpassword').on('click', function(){
	$('#div_showpassword').hide()
	  $('#div_notshowpassword').show()
  })

  $('#input_notshowpassword').on('input', function(){
	  $('#input_showpassword').val($(this).val())
  })

  $('#input_showpassword').on('input', function(){
	  $('#input_notshowpassword').val($(this).val())
  })

</script>