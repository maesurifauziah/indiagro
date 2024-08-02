
<!DOCTYPE html>

<html lang="en">
		<meta charset="utf-8" />
		<title>Indiagro | <?=$title?></title>
		<meta name="description" content="User 3 Columns listing" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<link rel="canonical" href="https://keenthemes.com/metronic" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Page Vendors Styles(used by this page)-->
		<link href="<?=base_url()?>assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Page Vendors Styles-->
		<!--begin::Global Theme Styles(used by all pages)-->
		<link href="<?=base_url()?>assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="<?=base_url()?>assets/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
		<link href="<?=base_url()?>assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
		
		<link rel="shortcut icon" href="<?=base_url()?>assets/media/logo/logo_agro_indo.png" />
		<!--begin::Page Scripts(used by this page)-->
		<?=$css?>
		<!--end::Page Scripts-->
	</head>

	<body id="kt_body" class="page-loading-enabled page-loading header-fixed header-mobile-fixed page-loading">
		
		<!-- <div class="page-loader page-loader-logo">
			<img alt="Logo" class="max-h-75px" src="assets/media/logos/logo-letter-4.png" />
			<div class="spinner spinner-primary"></div>
		</div> -->
		<div class="page-loader page-loader-base">
			<div class="blockui">
				<h4 class="text-primary">Memuat...</h4>
				<span>
					<div class="spinner spinner-primary"></div>
				</span>
			</div>
		</div>
	
		<?=$this->load->view('home/template/header-mobile');?>
		
		
		<div class="d-flex flex-column flex-root">
			<div class="d-flex flex-row flex-column-fluid page">
				<div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
					<div id="kt_header" class="header flex-column header-fixed">
						<?=$this->load->view('home/template/header-top');?>
						<?=$this->load->view('home/template/header-bottom');?>
					</div>






