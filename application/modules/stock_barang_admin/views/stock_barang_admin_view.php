<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<!--begin::Subheader-->
	<div class="subheader py-2 py-lg-6 subheader-transparent" id="kt_subheader">
		<div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
			<!--begin::Info-->
			<div class="d-flex align-items-center flex-wrap mr-1">
				<!--begin::Page Heading-->
				<div class="d-flex align-items-baseline flex-wrap mr-5">
					<!--begin::Page Title-->
					<h5 class="text-dark font-weight-bold my-1 mr-5"><?=$title?></h5>
					<!--end::Page Title-->
					<!--begin::Breadcrumb-->
					<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
						<li class="breadcrumb-item">
							<a href="" class="text-muted">Stock</a>
						</li>
						<li class="breadcrumb-item">
							<a href="" class="text-muted">Stock Barang Admin</a>
						</li>
					</ul>
					<!--end::Breadcrumb-->
				</div>
				<!--end::Page Heading-->
			</div>
			<!--end::Info-->
			
		</div>
	</div>
	<!--end::Subheader-->
	<!--begin::Entry-->
	<div class="d-flex flex-column-fluid gutter-b">
		<!--begin::Container-->
		<div class="container">
			<!--begin::Card-->
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<!-- <span class="card-icon">
							<i class="flaticon2-supermarket text-primary"></i>
						</span> -->
						<!-- <h3 class="card-label">Ajax Sourced Server-side Processing</h3> -->
					</div>
					<div class="card-toolbar">
						
						<!--begin::Button-->
						<a href="#" class="btn btn-primary font-weight-bolder" id="add">
						<span class="svg-icon svg-icon-md">
							<!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
							<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
								<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
									<rect x="0" y="0" width="24" height="24" />
									<circle fill="#000000" cx="9" cy="15" r="6" />
									<path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
								</g>
							</svg>
							<!--end::Svg Icon-->
						</span>Tambah Stock</a>
						<!--end::Button-->
					</div>
				</div>
				<div class="card-body">
					<!--begin: Search Form-->
					<form class="mb-15">
						<div class="row mb-6">
							<div class="col-lg-3 mb-lg-0 mb-6">
								<label>Date Start:</label>
								<input type="date" class="form-control form-control-sm text-xs" name="filter_date_start" id="filter_date_start" title="Date Start" value="<?php echo date('Y-m-01');?>" />
							</div>
							<div class="col-lg-3 mb-lg-0 mb-6">
								<label>Date End:</label>
								<input type="date" class="form-control form-control-sm text-xs" name="filter_date_end" id="filter_date_end" title="Date End" value="<?php echo date('Y-m-d');?>" />
							</div>
							<div class="col-lg-3 mb-lg-0 mb-6">
								<label>Status:</label>
								<select class="form-control form-control-sm text-xs" id="filter_status_barang">
									<option value="draft" selected>Draft</option>
									<option value="approve">Approve</option>
									<option value="sold_out">Habis</option>
									<option value="cancel">Batal</option>
								</select>
							</div>
							<div class="col-lg-3 mb-lg-0 mb-6">
								<label>Kategori:</label>
								<select class="form-control form-control-sm text-xs" id="filter_kategori">
									<option value="all">Semua</option>
									<?php
									$data = '';
									foreach ($kategori as $list) {
										$data .='<option value="'.$list->kategori_id.'">'.$list->kategori_desc.'</option>';
									}
									echo $data;?>
								</select>
							</div>
							<div class="col-lg-3 mb-lg-0 mb-6">
								<label>Barang:</label>
								<select class="form-control form-control-sm text-xs" id="filter_barang">
									<option value="all">Semua</option>
									<?php
									$data = '';
									foreach ($barang as $list) {
										$data .='<option value="'.$list->kode_barang.'">'.$list->nama_barang.'</option>';
									}
									echo $data;?>
								</select>
							</div>
							<div class="col-lg-3 mb-lg-0 mb-6 mt-8">
								<button class="btn btn-primary btn-xs" id="kt_search">
									<span>
										<i class="la la-filter"></i>
										<span>Filter</span>
									</span>
								</button>
							</div>
						</div>
					</form>
					<!--begin: Datatable-->
					<table class="table table-separate table-head-custom table-checkable" id="kt_datatable">
						<thead>
							<tr>
								<th>No</th>
                                <th>Stock ID</th>
                                <th>Tanggal Stock</th>
								<th>Penyetok</th>
                                <th>No Hp</th>
                                <th>Nama Jenis Barang</th>
								<th>Bukti Barang</th>
                                <th>Banyak Stock (Kg)</th>
								<th>Harga Per Kg</th>
                                <th>Status Barang</th>
                                <th>action</th>
							</tr>
						</thead>
						
					</table>
					<!--end: Datatable-->
				</div>
			</div>
			<!--end::Card-->
		</div>
		<!--end::Container-->
	</div>
	<!--end::Entry-->
</div>

<div class="modal fade" id="modal-form" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Stock</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
			<?= form_open('stock_barang_admin/save', array('id' => 'stock_barang_admin', 'class' => 'form')) ?>
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


