
<!DOCTYPE html>
<!--
Template Name: Metronic - Bootstrap 4 HTML, React, Angular 10 & VueJS Admin Dashboard Theme
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: https://1.envato.market/EA4JP
Renew Support: https://1.envato.market/EA4JP
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="en">
	<!--begin::Head-->
	<head><base href="../../../../">
		<meta charset="utf-8" />
		<title><?=$title?> | Indiagro</title>
		<meta name="description" content="Login page example" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<link rel="canonical" href="https://keenthemes.com/metronic" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Page Custom Styles(used by this page)-->
		<!-- <link href="<?=base_url()?>assets/css/pages/login/classic/login-4.css" rel="stylesheet" type="text/css" /> -->
		<link href="<?=base_url()?>assets/css/pages/login-4.css" rel="stylesheet" type="text/css" />
		<!--end::Page Custom Styles-->
		<!--begin::Global Theme Styles(used by all pages)-->
		<link href="<?=base_url()?>assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="<?=base_url()?>assets/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
		<link href="<?=base_url()?>assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Global Theme Styles-->
		<!--begin::Layout Themes(used by all pages)-->
		<!--end::Layout Themes-->
		<link rel="shortcut icon" href="<?=base_url()?>assets/media/logo/logo_agro_indo.png" />
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled page-loading">
		<!--begin::Main-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Login-->
			<div class="login login-4 login-signin-on d-flex flex-row-fluid" id="kt_login">
				<div class="d-flex flex-center flex-row-fluid bgi-size-cover bgi-position-top bgi-no-repeat" style="background-image: url('<?=base_url()?>assets/media/bg/bg-3.jpg');">
					<div class="login-form text-center p-7 position-relative overflow-hidden">
						<!--begin::Login Header-->
						<div class="d-flex flex-center mb-15">
							<a href="#">
								<img src="<?=base_url()?>assets/media/logo/logo_agro_indo.png" class="max-h-75px" alt="" />
							</a>
						</div>
						<!--end::Login Header-->
						<!--begin::Login Sign in form-->
						<div class="login-signin">
							<div class="mb-20">
								<h3>Masuk ke Indiagro</h3>
								<div class="text-muted font-weight-bold">Masukkan data Anda untuk masuk</div>
							</div>
							<?=form_open('auth/login', array('id' => 'kt_login_signin_form', 'class' => 'form'), array('id' => 'form_login'))?>
								<div class="form-group mb-5">
									<?=form_input($username);?>
                                    <span id="username-error" class="error invalid-feedback" style="display: block;"></span>
								</div>
								<div class="form-group mb-5">
									<?=form_input($password);?>
                                    <span id="password-error" class="error invalid-feedback" style="display: block;"></span>
                                </div>
								
								<?=form_submit('submit', 'Masuk', array('id' => 'kt_login_signin_submit', 'class' => 'btn btn-primary font-weight-bold px-9 py-4 my-3 mx-4'));?>
							<?=form_close()?>
							<div class="mt-10">
								<span class="opacity-70 mr-4">Belum punya akun?</span>
								<!-- <a href="javascript:;" id="kt_login_signup" class="text-muted text-hover-primary font-weight-bold">Daftar Sekarang!</a> -->
								<a href="javascript:;" id="kt_login_forgot" class="text-muted text-hover-primary font-weight-bold">Daftar Sekarang!</a>
							</div>
						</div>
						<!--end::Login Sign in form-->

						<!--begin::Login Sign up form-->
						<div class="login-signup">
							<div class="mb-20">
								<h3>Daftar Akun</h3>
								<div class="text-muted font-weight-bold">Masukkan detail Anda untuk membuat akun</div>
							</div>
							<?=form_open('auth/register', array('id' => 'kt_login_signup_form', 'class' => 'form'), array('id' => 'form_login'))?>
								<input type="hidden" name="userid" id="userid" />
								<input type="hidden" name="uid" id="uid"/>
								<input type="hidden" name="type" id="type" value="add">
								
								<div class="form-group mb-5">
									<?=form_input($nama_lengkap);?>
                                    <span id="nama_lengkap-error" class="error invalid-feedback" style="display: block;"></span>
								</div>
								<div class="form-group mb-5">
									<?=form_input($user_name);?>
                                    <span id="user_name-error" class="error invalid-feedback" style="display: block;"></span>
								</div>
								<div class="form-group mb-5">
									<?=form_input($password_reg);?>
                                    <span id="password_reg-error" class="error invalid-feedback" style="display: block;"></span>
								</div>
								<?=form_input($user_group);?>
								<div class="form-group mb-5">
									<select class="form-control h-auto form-control-solid py-4 px-8" name="propid" id="propid"> 
										<option value=""> -- Pilih Provinsi --</option>
										<?php
											$data = '';
											foreach ($provinsi as $list) {
												$data .='<option value="'.$list->propid.'">'.$list->propinsi_desc.'</option>';
											}
											echo $data;?>
									</select>
                                    <span id="propid-error" class="error invalid-feedback" style="display: block;"></span>
								</div>
								<div class="form-group mb-5">
									<select class="form-control h-auto form-control-solid py-4 px-8" name="kabid" id="kabid"> 
										<option value=""> -- Pilih Kabupaten/Kota --</option>
									</select>
                                    <span id="kabid-error" class="error invalid-feedback" style="display: block;"></span>
								</div>
								<div class="form-group mb-5">
									<select class="form-control h-auto form-control-solid py-4 px-8" name="kecid" id="kecid"> 
										<option value=""> -- Pilih Kecamatan --</option>
									</select>
                                    <span id="kecid-error" class="error invalid-feedback" style="display: block;"></span>
								</div>
								<div class="form-group mb-5">
									<?=form_input($kodepos);?>
                                    <span id="kodepos-error" class="error invalid-feedback" style="display: block;"></span>
								</div>
								<div class="form-group mb-5 pasar">
									<select class="form-control h-auto form-control-solid py-4 px-8" name="pasar_id" id="pasar_id"> 
										<option value=""> -- Pilih Pasar --</option>
										<?php
											$data = '';
											foreach ($pasar as $list) {
												$data .='<option value="'.$list->pasar_id.'">'.$list->pasar_desc.'</option>';
											}
											echo $data;?>
									</select>
                                    <span id="pasar_id-error" class="error invalid-feedback" style="display: block;"></span>
								</div>
								<div class="form-group mb-5">
									<?=form_textarea($alamat);?>
									<span id="alamat-error" class="error invalid-feedback" style="display: block;"></span>
								</div>
								<div class="form-group mb-5">
									<?=form_input($no_hp);?>
                                    <span id="no_hp-error" class="error invalid-feedback" style="display: block;"></span>
								</div>
								
								<div class="form-group d-flex flex-wrap flex-center mt-10">
									<!-- <button id="kt_login_signup_submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-2">Daftar</button> -->
									<?=form_submit('submit', 'Daftar', array('id' => 'kt_login_signup_submit', 'class' => 'btn btn-primary font-weight-bold px-9 py-4 my-3 mx-2'));?>
									<button id="kt_login_signup_cancel" class="btn btn-light-primary font-weight-bold px-9 py-4 my-3 mx-2">Batal</button>
								</div>
							<?=form_close()?>
						</div>
						<!--end::Login Sign up form-->
						<!--begin::Login forgot password form-->
						<div class="login-forgot">
							<div class="mb-20">
								<h3>Buat Akun Sebagai ?</h3>
								<div class="text-muted font-weight-bold">Pilih salah satu tipe user yang akan anda pakai</div>
							</div>
							<form class="form" id="kt_login_forgot_form">
								<div class="form-group mb-10">
								<button id="form_registrasi_penjual" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-4">Penjual/Petani</button>
								<button id="form_registrasi_pembeli" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-4">Pembeli/Pasar</button>
								<div class="form-group d-flex flex-wrap flex-center mt-10">
									<button id="kt_login_forgot_cancel" class="btn btn-light-primary font-weight-bold px-9 py-4 my-3 mx-2">Batal</button>
								</div>
							</form>
						</div>
						<!--end::Login forgot password form-->
					</div>
				</div>
			</div>
			<!--end::Login-->
		</div>
		<!--end::Main-->
		<script>var HOST_URL = "<?=base_url()?>"</script>
		<!--begin::Global Config(global config for global JS scripts)-->
		<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#0BB783", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#D7F9EF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>
		<!--end::Global Config-->
		<!--begin::Global Theme Bundle(used by all pages)-->
		<script src="<?=base_url()?>assets/plugins/global/plugins.bundle.js"></script>
		<script src="<?=base_url()?>assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
		<script src="<?=base_url()?>assets/js/scripts.bundle.js"></script>
		<!--end::Global Theme Bundle-->
		<!--begin::Page Scripts(used by this page)-->
		<!-- <script src="<?=base_url()?>assets/js/pages/custom/login/login-general.js"></script> -->
		<script src="<?=base_url()?>assets/js/pages/auth.js"></script>
		<!--end::Page Scripts-->
	</body>
	<!--end::Body-->
</html>