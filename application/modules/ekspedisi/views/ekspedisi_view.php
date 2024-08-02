<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<!--begin::Subheader-->
	<div class="subheader py-2 py-lg-4 mb-0 " id="kt_subheader">
		<div class="container">
			<!--begin::Details-->
			<div class="align-items-center">
				<div class="row mb-6">
					<div class="col-lg-3 mb-lg-0 mb-6">
						<label>Date Start:</label>
						<input type="date" class="form-control form-control-sm text-xs" name="filter_date_start" id="filter_date_start" title="Date Start" value="<?php echo date('Y-m-01');?>" />
					</div>
					<div class="col-lg-3 mb-lg-0 mb-6">
						<label>Date End:</label>
						<input type="date" class="form-control form-control-sm text-xs" name="filter_date_end" id="filter_date_end" title="Date End" value="<?php echo date('Y-m-d');?>" />
					</div>
					<div class="col-lg-3 mb-lg-0 mb-0">
						<label>Status:</label>
						
						<select class="form-control form-control-sm text-xs" id="filter_status_order">
							<option value="packing" selected>Dikemas</option>
							<option value="pengiriman">Dikirim</option>
							<option value="lunas">Lunas</option>
							<option value="done">Selesai</option>
							<option value="cancel">Batal</option>
						</select>
					</div>
					<div class="col-lg-3 mb-lg-0 mb-6">
						<label></label><br>
						<button class="btn btn-primary btn-primary-icon" id="filter">
							<span>
								<i class="la la-filter"></i>
								<span>Filter</span>
							</span>
						</button>
					</div>
					
				</div>
				
			</div>
			
		</div>
	</div>
	<!--end::Subheader-->
	<div class="d-flex flex-column-fluid mb-20">
		<div class="container" id="container_product">
			<div class="row product"></div>
		</div>
	</div>
</div>


<div class="modal fade" id="modal-form" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header border-bottom-0">
				<img alt="Logo" class= "card-img-top" id="photo_barang"/>
			</div>
			<?= form_open('ekspedisi/save_to_cart', array('id' => 'tambah_barang_cart', 'class' => 'form')) ?>
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