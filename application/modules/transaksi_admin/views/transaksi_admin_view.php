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
								<select class="form-control form-control-sm text-xs" id="filter_status_transaksi">
									<option value="draft" selected>Draft</option>
									<option value="done">Done</option>
									<option value="cancel">Batal</option>
								</select>
							</div>
							<div class="col-lg-3 mb-lg-0 mb-6">
								<label>Transaksi ID:</label>
								<select class="form-control form-control-sm text-xs" id="filter_trans_id">
									<option value="all">Semua</option>
									<?php
									$data = '';
									foreach ($trans as $list) {
										$data .='<option value="'.$list->trans_id.'">'.$list->trans_id.'</option>';
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
                                <th>No Transaksi</th>
                                <th>Nama</th>
                                <th>Tanggal Checkout</th>
								<th>Total</th>
                                <th>Total Batal</th>
                                <th>Grand Total</th>
                                <th>Progress</th>
								<th>Alamat Kirim</th>
                                <th>Status</th>
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
	<div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title">Form Stock</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
			<input type="hidden" name="userid" id="userid" />
                <input type="hidden" name="trans_id" id="trans_id">
                <div class="modal-body pt-2">
					<div data-scroll="true" data-height="500">
					<div class="form-group row mb-0">
						<label class="pl-5"><b>Nama : </b><span class="" id="label_nama_lengkap"></span></label>						
					</div>
					<div class="form-group row mb-0">
						<label class="pl-5"><b>No Hp : </b><span class="" id="label_no_hp"></span></label>						
					</div>
					<div class="form-group row mb-0">
						<label class="pl-5"><b>Pasar : </b><span class="" id="label_pasar"></span></label>						
					</div>
					<div class="form-group row mb-0">
						<label class="pl-5"><b>Alamat : </b><span class="" id="label_alamat_kirim"></span></label>						
					</div>
					<div class="form-group row mb-0">
						<label class="pl-5"><b>Status Transaksi : </b><span class="" id="label_status_transaksi"></span></label>						
					</div>
						<table class="table table-separate table-head-custom table-checkable" id="kt_datatable2">
							<thead>
								<tr>
									<th>no</th>
									<th>order id</th>
									<th>nama jenis barang</th>
									<th>harga total</th>
									<th>qty order</th>
									<th>status order</th>
									<th>Stock</th>
									<th>Kurir</th>
									<th>action</th>
								</tr>
							</thead>
							
						</table>
					<div>
				</div>
				
        </div>
    </div>
</div>

<div class="modal fade" id="modal-form2" tabindex="-2" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content border border-primary">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Set Kurir</h6>
                <button type="button" class="close icon-close" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
				<?= form_open('transaksi_admin/save_kurir', array('id' => 'transaksi_admin', 'class' => 'form')) ?>
					<div class="row">
						<input type="hidden" name="order_id" id="order_id">
						<div class="col-sm-12">
							<select class="form-control select2-kurir" name="kurir_id" id="kurir_id"> 
								<option value="">-- Pilih Kurir --</option>
								<?php
									$data = '';
									foreach ($kurir as $list) {
										$data .='<option value="'.$list->userid.'">'.$list->nama_lengkap.'</option>';
									}
								echo $data;?>
							</select>
							<span id="kurir_id-error" class="error invalid-feedback" style="display: block;"></span>
						</div>
					</div>
				<?= form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold icon-close">Batal</button>
                <button type="button" class="btn btn-primary font-weight-bold" id="save">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-form3" tabindex="-2" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content border border-primary">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Set Stock</h6>
                <button type="button" class="close icon-close" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
				<?= form_open('transaksi_admin/save_stock', array('id' => 'transaksi_admin_stock', 'class' => 'form')) ?>
					<div class="row">
						<input type="hidden" name="order_id_stock" id="order_id_stock">
						<input type="hidden" name="trans_id_stock" id="trans_id_stock">
						<input type="hidden" name="kode_jenis_barang" id="kode_jenis_barang">
						<input type="hidden" name="qty_order" id="qty_order">
						<input type="text" name="stock_id2" id="stock_id2">
						<div class="col-sm-12">
							<select class="form-control select2-stock" name="stock_id" id="stock_id"> 
								<option value="">-- Pilih Stock --</option>
								<?php
									$data = '';
									foreach ($stock as $list) {
										$data .='<option value="'.$list->stock_id.'_'.$list->qty.'">'.$list->stock_id.' '.$list->qty.'</option>';
									}
								echo $data;?>
							</select>
							<span id="stock_id-error" class="error invalid-feedback" style="display: block;"></span>
						</div>
					</div>
				<?= form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold icon-close">Batal</button>
                <button type="button" class="btn btn-primary font-weight-bold" id="save2">Simpan</button>
            </div>
        </div>
    </div>
</div>

