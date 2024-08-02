<div id="kt_header_mobile" class="header-mobile bg-primary header-mobile-fixed">
	<!--begin::Logo-->
	<div class="d-flex align-items-center">
	<a href="<?=base_url()?>" class="mr-5">
			<img alt="Logo" src="<?=base_url()?>assets/media/logo/logo_agro_indo2.png" class="max-h-30px" />
		</a>
		<h3 class="text-white" style="margin-bottom: 0rem !important;">Indiagro</h3>
	</div>
	<!--end::Logo-->
	<!--begin::Toolbar-->
	<div class="d-flex align-items-center">
		<?php
			$data = "";
			if ($this->Admin_menu_model->cek_menu($this->session->userdata('user_group'), 'M0006') != null) {
					$data .='<a href="keranjang" class="btn btn-icon btn-hover-transparent-white btn-dropdown btn-lg mr-1">
					<span class="svg-icon svg-icon-xl">
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<rect x="0" y="0" width="24" height="24" />
								<path d="M12,4.56204994 L7.76822128,9.6401844 C7.4146572,10.0644613 6.7840925,10.1217854 6.3598156,9.76822128 C5.9355387,9.4146572 5.87821464,8.7840925 6.23177872,8.3598156 L11.2317787,2.3598156 C11.6315738,1.88006147 12.3684262,1.88006147 12.7682213,2.3598156 L17.7682213,8.3598156 C18.1217854,8.7840925 18.0644613,9.4146572 17.6401844,9.76822128 C17.2159075,10.1217854 16.5853428,10.0644613 16.2317787,9.6401844 L12,4.56204994 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
								<path d="M3.5,9 L20.5,9 C21.0522847,9 21.5,9.44771525 21.5,10 C21.5,10.132026 21.4738562,10.2627452 21.4230769,10.3846154 L17.7692308,19.1538462 C17.3034221,20.271787 16.2111026,21 15,21 L9,21 C7.78889745,21 6.6965779,20.271787 6.23076923,19.1538462 L2.57692308,10.3846154 C2.36450587,9.87481408 2.60558331,9.28934029 3.11538462,9.07692308 C3.23725479,9.02614384 3.36797398,9 3.5,9 Z M12,17 C13.1045695,17 14,16.1045695 14,15 C14,13.8954305 13.1045695,13 12,13 C10.8954305,13 10,13.8954305 10,15 C10,16.1045695 10.8954305,17 12,17 Z" fill="#000000" />
							</g>
						</svg>
					</span>
				</a>';
			}
			echo $data;?>
		
	
		<div class="btn btn-icon btn-hover-transparent-white w-auto d-flex align-items-center btn-lg px-2" id="kt_quick_panel_toggle">
			<div class="d-flex flex-column text-right pr-3">
				<span class="text-white opacity-50 font-weight-bold font-size-sm d-none d-md-inline"><?= ucwords(strtolower($this->session->userdata('nama_lengkap')))?></span>
				<span class="text-white font-weight-bolder font-size-sm d-none d-md-inline"></span>
			</div>
			<span class="symbol symbol-35">
				<span class="svg-icon svg-icon-1">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
						<path d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z" fill="currentColor"></path>
						<path opacity="0.3" d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z" fill="currentColor"></path>
					</svg>
				</span>
			</span>
		</div>
	</div>
	<!--end::Toolbar-->
</div>