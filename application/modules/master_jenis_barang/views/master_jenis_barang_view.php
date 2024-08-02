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
							<a href="" class="text-muted">Admin</a>
						</li>
						<li class="breadcrumb-item">
							<a href="" class="text-muted">Master</a>
						</li>
						<li class="breadcrumb-item">
							<a href="" class="text-muted">Master Jenis Barang</a>
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
	<div class="d-flex flex-column-fluid">
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
						</span>Tambah Jenis Barang</a>
						<!--end::Button-->
					</div>
				</div>
				<div class="card-body">
					<!--begin: Search Form-->
					<form class="mb-15">
						<div class="row mb-6">
							<div class="col-lg-3 mb-lg-0 mb-6">
								<label>Status:</label>
								<select class="form-control datatable-input" data-col-index="3" id="filter_status">
									<option value="y" selected>Aktif</option>
									<option value="n">Non Aktif</option>
								</select>
							</div>
							<div class="col-lg-3 mb-lg-0 mb-6">
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
							<div class="col-lg-3 mb-lg-0 mb-6">
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
							<div class="col-lg-3 mb-lg-0 mb-6 mt-8">
								<button class="btn btn-primary btn-primary--icon" id="kt_search">
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
                                <th width="10%">Photo</th>
                                <th>Kategori</th>
                                <th>Nama Barang</th>
                                <th>Jenis Barang</th>
                                <th>Harga Per Kg</th>
                                <th>Status</th>
                                <th>Action</th>
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
	<div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Jenis Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
			<?= form_open('master_jenis_barang/save', array('id' => 'master_jenis_barang', 'class' => 'form')) ?>
			<input type="hidden" name="kode_jenis_barang" id="kode_jenis_barang" />
            <input type="hidden" name="type" id="type">
			<input type="hidden" name="photo_nama" id="photo_nama">
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12">
                        <div class="symbol symbol-120 border border-light">
                           <div class="symbol-label img-ipt" id='output' style="background-image: url(assets/media/users/blank.png)"></div>
                           <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow symbol-badge" style="height: 24px; width: 24px;">
                                <i class="fa fa-pen icon-sm text-muted p-2"></i>
                                <input type="file" name="photo" id="photo" accept=".png, .jpg, .jpeg" style="opacity:0">
                           </label>
                        </div>
                        <span id="photo-error" class="error invalid-feedback" style="display: block;"></span>
                    </div> 
                    <div class="col-sm-12">
						<label>Kategori</label> <br>
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
                    <div class="col-sm-12">
						<label>Barang</label> <br>
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
					<div class="col-sm-12">
                        <label>Jenis Barang</label>
                        <input type="text" class="form-control" name="nama_jenis_barang" id="nama_jenis_barang">
                        <span id="nama_jenis_barang-error" class="error invalid-feedback" style="display: block;"></span>
                    </div>
                    <div class="col-sm-12">
                        <label>Harga Per Kg</label>
                        <input type="text" class="form-control" name="harga" id="harga">
                        <span id="harga-error" class="error invalid-feedback" style="display: block;"></span>
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


