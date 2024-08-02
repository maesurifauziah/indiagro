<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<!--begin::Subheader-->
	<div class="subheader py-2 py-lg-4 mb-5 subheader-transparent" id="kt_subheader">
		<div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
			<!--begin::Details-->
			<div class="d-flex align-items-center flex-wrap mr-2">
				<!--begin::Title-->
				<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5"><?=$title?></h5>
				<!--end::Title-->
				<!--begin::Separator-->
				<div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
				<!--end::Separator-->
				<!--begin::Search Form-->
				<div class="d-flex align-items-center" id="kt_subheader_search">
					<!-- <span class="text-dark-50 font-weight-bold" id="kt_subheader_total">450 Total</span> -->
					<div class="input-group " style="max-width: 200px">
						<input type="text" class="form-control" id="kt_subheader_search_form" placeholder="Search..." />
						<div class="input-group-append">
							<span class="input-group-text">
								<span class="svg-icon">
									<!--begin::Svg Icon | path:assets/media/svg/icons/General/Search.svg-->
									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
										<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											<rect x="0" y="0" width="24" height="24" />
											<path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
											<path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero" />
										</g>
									</svg>
									<!--end::Svg Icon-->
								</span>
								<!--<i class="flaticon2-search-1 icon-sm"></i>-->
							</span>
						</div>
					</div>
				</div>
				<!--end::Search Form-->
				
			</div>
			<!--end::Details-->
			<!--begin::Toolbar-->
			<div class="d-flex align-items-center">
				<!--begin::Button-->
				<a href="#" class=""></a>
				<!--begin::Dropdown-->
				<div class="dropdown dropdown-inline mr-2">
					<button type="button" class="btn btn-light-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="svg-icon svg-icon-5 svg-icon-gray-500 me-1">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
								<path d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z" fill="currentColor"></path>
							</svg>
						</span> 
						Filter
					</button>
					<form class="dropdown-menu dropdown-menu-md dropdown-menu-right">
						<div class="px-7 py-5">
							<div class="font-size-lg font-weight-bold">Filter Options</div>
						</div>
						<div class="pl-5 pr-5 pt-1 pb-1">
							<div class="row">
								
								<div class="col-12">
									<label>Kategori:</label>
									<select class="form-control" id="filter_kategori">
										<option value="all">Semua</option>
										<?php
										$data = '';
										foreach ($kategori as $list) {
											$data .='<option value="'.$list->kategori_id.'">'.$list->kategori_desc.'</option>';
										}
										echo $data;?>
									</select>
								</div>
								<div class="col-12">
									<label>Barang:</label>
									<select class="form-control" id="filter_barang">
										<option value="all">Semua</option>
										<?php
										$data = '';
										foreach ($barang as $list) {
											$data .='<option value="'.$list->kode_barang.'">'.$list->nama_barang.'</option>';
										}
										echo $data;?>
									</select>
								</div>
								<div class="col-12 mt-8">
									<button class="btn btn-primary btn-primary--icon" id="filter">
										<span>
											<i class="la la-filter"></i>
											<span>Filter</span>
										</span>
									</button>
								</div>
							</div>
						</div>

					</form>
				</div>
				<!--end::Dropdown-->
			
			</div>
			<!--end::Toolbar-->
		</div>
	</div>
	<!--end::Subheader-->
	<div class="d-flex flex-column-fluid mb-20">
		<div class="container" id="container_product">
			<div class="row product"></div>
			
			<!-- <div class="d-flex justify-content-between align-items-center flex-wrap">
				<div class="d-flex flex-wrap mr-3">
					<a href="#" class="btn btn-icon btn-sm btn-light-primary mr-2 my-1">
						<i class="ki ki-bold-double-arrow-back icon-xs"></i>
					</a>
					<a href="#" class="btn btn-icon btn-sm btn-light-primary mr-2 my-1">
						<i class="ki ki-bold-arrow-back icon-xs"></i>
					</a>
					<a href="#" class="btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1">...</a>
					<a href="#" class="btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1">23</a>
					<a href="#" class="btn btn-icon btn-sm border-0 btn-hover-primary active mr-2 my-1">24</a>
					<a href="#" class="btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1">25</a>
					<a href="#" class="btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1">26</a>
					<a href="#" class="btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1">27</a>
					<a href="#" class="btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1">28</a>
					<a href="#" class="btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1">...</a>
					<a href="#" class="btn btn-icon btn-sm btn-light-primary mr-2 my-1">
						<i class="ki ki-bold-arrow-next icon-xs"></i>
					</a>
					<a href="#" class="btn btn-icon btn-sm btn-light-primary mr-2 my-1">
						<i class="ki ki-bold-double-arrow-next icon-xs"></i>
					</a>
				</div>
				<div class="d-flex align-items-center">
					<select class="form-control form-control-sm text-primary font-weight-bold mr-4 border-0 bg-light-primary" style="width: 75px;">
						<option value="10">10</option>
						<option value="20">20</option>
						<option value="30">30</option>
						<option value="50">50</option>
						<option value="100">100</option>
					</select>
					<span class="text-muted">Displaying 10 of 230 records</span>
				</div>
			</div> -->
		</div>
	</div>
</div>


<div class="modal fade" id="modal-form" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header border-bottom-0">
				<img alt="Logo" class= "card-img-top" id="photo_barang"/>
			</div>
			<?= form_open('order/save_to_cart', array('id' => 'tambah_barang_cart', 'class' => 'form')) ?>
                <input type="hidden" name="userid" id="userid" />
                <input type="hidden" name="kategori_id" id="kategori_id" />
                <input type="hidden" name="kode_barang" id="kode_barang" />
                <input type="hidden" name="kode_jenis_barang" id="kode_jenis_barang" />
                <input type="hidden" name="harga" id="harga" />
                <input type="hidden" name="qty" id="qty" />
                <input type="hidden" name="harga_total" id="harga_total" />
                <input type="hidden" name="type" id="type">
                <div class="modal-body pt-2">
					
					<div class="form-group row mb-4">
						<h4 class="modal-title pl-2" id="label-nama-jenis-barang"></h4>
					</div>
					<div class="form-group row mb-2">
						<h6 class="pl-2 text-primary font-weight-bold text-hover-primary" id="label-harga"></h6>
					</div>
					
					<div class="form-group row mb-2">
						<label class="pl-2 text-success text-hover-success" id="label-qty-stock"></label>
					</div>
				
					<div class="row">
					    <div class="col-sm-12 pl-2 pr-2">
							<div class="input-icon input-icon-right">
							<input type="text" class="form-control" name="qty_order" id="qty_order" placeholder="Kuantiti" maxlength="4">
                                <span>Kg</span>
                            </div>
							<span id="qty_order-error" class="error invalid-feedback" style="display: block;"></span>

                        </div>
					</div>
					<div class="row">
					    <div class="col-sm-12 pl-2 pr-2 text-right">
							<label class="modal-title pl-2 font-weight-bold text-hover-dark text-dark" id="label_total">Rp. 0</label>
                        </div>
					</div>
					
				</div>
				<div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary font-weight-bold" id="save">Simpan</button>
				</div>
            <?= form_close() ?>
		</div>
	</div>
</div>