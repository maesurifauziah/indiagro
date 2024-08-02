<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<!--begin::Subheader-->
	<div class="subheader py-2 py-lg-4 subheader-transparent" id="kt_subheader">
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
									<label>Status:</label>
									<select class="form-control" id="filter_status">
										<option value="all">Semua</option>
										<option value="draft">Draft</option>
										<option value="approve">Approve</option>
										<option value="sold_out">Habis</option>
										<option value="cancel">Batal</option>
									</select>
								</div>
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
				<!--end::Button-->
				<?php if ($this->session->userdata('user_group') == '0001' || $this->session->userdata('user_group') ==  '0002' || $this->session->userdata('user_group') ==  '0005'):?>
                    <a href="#" class="btn btn-light-primary font-weight-bold" id="add" data-toggle="modal" data-target="#modal-form">Tambah Barang</a>
                <?php endif;?>
				
			</div>
			<!--end::Toolbar-->
		</div>
	</div>
	<!--end::Subheader-->
	<!--begin::Entry-->
	<div class="d-flex flex-column-fluid mb-20">
		<!--begin::Container-->
		<div class="container" id="container_product">
			<div class="row product"></div>
			
		</div>
		<!--end::Container-->
	</div>
	<!--end::Entry-->
</div>

<div class="modal fade" id="modal-form" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<div class="modal-dialog " role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Form Barang</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<i aria-hidden="true" class="ki ki-close"></i>
				</button>
			</div>
			<?= form_open('stock_barang/save', array('id' => 'tambah_barang', 'class' => 'form')) ?>
                <input type="hidden" name="userid" id="userid" />
                <input type="hidden" name="stock_id" id="stock_id">
                <input type="hidden" name="type" id="type">
                <input type="hidden" name="photo_name" id="photo_name">
                <div class="modal-body pt-2">
					<div class="form-group row mb-2">
						<label class="col-form-label text-left col-lg-3 col-sm-12">Kategori</label>
						<div class="col-lg-9 col-md-9 col-sm-12">
                            <select class="form-control" name="kategori_id" id="kategori_id"> 
                                <option value="">--Pilih Kategori--</option>
                                <?php
                                    $data = '';
                                    foreach ($kategori as $list) {
                                        $data .='<option value="'.$list->kategori_id.'">'.$list->kategori_desc.'</option>';
                                    }
                                    echo $data;?>
                            </select>
                            <span id="kategori_id-error" class="error invalid-feedback" style="display: block;"></span>
						</div>
					</div>
					<div class="form-group row mb-2">
						<label class="col-form-label text-left col-lg-3 col-sm-12">Barang</label>
						<div class="col-lg-9 col-md-9 col-sm-12">
                            <select class="form-control" name="kode_barang" id="kode_barang"> 
                                <option value="">--Pilih Barang--</option>
                                <?php
                                    $data = '';
                                    foreach ($barang as $list) {
                                        $data .='<option value="'.$list->kode_barang.'">'.$list->nama_barang.'</option>';
                                    }
                                    echo $data;?>
                            </select>
                            <span id="kode_barang-error" class="error invalid-feedback" style="display: block;"></span>
						</div>
					</div>
					<div class="form-group row mb-2">
						<label class="col-form-label text-left col-lg-3 col-sm-12">Jenis Barang</label>
						<div class="col-lg-9 col-md-9 col-sm-12">
                            <select class="form-control" name="kode_jenis_barang" id="kode_jenis_barang"> 
                                <option value="">--Pilih Jenis Barang--</option>
                                <?php
                                    $data = '';
                                    foreach ($jenis_barang as $list) {
                                        $data .='<option value="'.$list->kode_jenis_barang.'">'.$list->nama_jenis_barang.'</option>';
                                    }
                                    echo $data;?>
                            </select>
                            <span id="kode_jenis_barang-error" class="error invalid-feedback" style="display: block;"></span>
						</div>
					</div>
					<div class="form-group row mb-2">
						<label class="col-form-label text-left col-lg-3 col-sm-12">Harga Per Kg</label>
                        <div class="col-lg-9 col-md-9 col-sm-12">
                            <input type="text" class="form-control" name="harga" id="harga">
							<span id="harga-error" class="error invalid-feedback" style="display: block;"></span>
                        </div>
					</div>
					<div class="form-group row mb-2">
						<label class="col-form-label text-left col-lg-3 col-sm-12">Qty (Kg)</label>
						<div class="col-lg-9 col-md-9 col-sm-12">
                            <input type="text" class="form-control" name="qty" id="qty">
							<span id="qty-error" class="error invalid-feedback" style="display: block;"></span>
                        </div>
					</div>
					<div class="form-group row mb-2">
						<label class="col-form-label text-left col-lg-3 col-sm-12">Bukti Barang</label>
						<div class="col-lg-9 col-md-9 col-sm-12">
							<div class="symbol symbol-120 border border-light">
							<div class="symbol-label img-ipt" id='output' style="background-image: url(assets/media/users/blank.png)"></div>
							<label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow symbol-badge" style="height: 24px; width: 24px;">
									<i class="fa fa-pen icon-sm text-muted p-2"></i>
									<input type="file" name="photo_bukti_barang" id="photo_bukti_barang" accept=".png, .jpg, .jpeg" style="opacity:0">
							</label>
							</div>
							<span id="photo_bukti_barang-error" class="error invalid-feedback" style="display: block;"></span>
                        </div>
					</div>
					<div class="form-group row mb-2">
						<label class="col-form-label text-left col-lg-3 col-sm-12">Keterangan</label>
                        <div class="col-lg-9 col-md-9 col-sm-12">
                            <textarea class="form-control" name="keterangan" id="keterangan" rows="1" ></textarea>
							<span id="keterangan-error" class="error invalid-feedback" style="display: block;"></span>
                        </div>
					</div>
					<div class="form-group row mb-2">
                        <div class="col-lg-12 col-md-12 col-sm-12 text-right">
						<div class="separator separator-dashed mt-2 mb-1"></div>	
						</div>
					</div>
					<div class="form-group row">
                        <div class="col-lg-12 col-md-12 col-sm-12 text-right">
							<button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Batal</button>
                    		<button type="button" class="btn btn-primary font-weight-bold" id="save">Simpan</button>
                        </div>
					</div>
					
				</div>
				
            <?= form_close() ?>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-form2" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header border-bottom-0">
			<img alt="Logo" class= "card-img-top" src="<?=base_url()?>assets/media/users/index.jpg" />
			</div>
			<?= form_open('stock_barang/save_to_cart', array('id' => 'tambah_barang_cart', 'class' => 'form')) ?>
                <input type="hidden" name="userid" id="userid" />
                <input type="hidden" name="etalase_id" id="etalase_id">
                <input type="hidden" name="type" id="type">
                <div class="modal-body">
					
					<div class="form-group row">
					<h5 class="modal-title" id="label-nama-barang"></h5>
					</div>
					
					
					<div class="form-group row">
						<label class="col-form-label text-left col-lg-3 col-sm-12">Keterangan</label>
                        <div class="col-lg-9 col-md-9 col-sm-12">
                            <textarea class="form-control" name="keterangan" id="keterangan" rows="3" ></textarea>
							<span id="keterangan-error" class="error invalid-feedback" style="display: block;"></span>
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
