<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<!--begin::Subheader-->
	<div class="subheader py-2 py-lg-4 mb-5 subheader-transparent" id="kt_subheader">
		<div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
			<!--begin::Details-->
			<div class="d-flex align-items-center flex-wrap mr-2">
				<div class="row mb-6">
					<div class="col-lg-4 mb-lg-0 mb-6">
						<label>Date Start:</label>
						<input type="date" class="form-control form-control-sm text-xs" name="filter_date_start" id="filter_date_start" title="Date Start" value="<?php echo date('Y-m-01');?>" />
					</div>
					<div class="col-lg-4 mb-lg-0 mb-6">
						<label>Date End:</label>
						<input type="date" class="form-control form-control-sm text-xs" name="filter_date_end" id="filter_date_end" title="Date End" value="<?php echo date('Y-m-d');?>" />
					</div>
					<div class="col-lg-4 mb-lg-0 mb-6">
						<label>Status:</label>
						
						<select class="form-control form-control-sm text-xs" id="filter_status_order">
							<option value="packing" selected>Dikemas</option>
							<option value="pengiriman">Dikirim</option>
							<option value="lunas">Lunas</option>
							<option value="done">Selesai</option>
							<option value="cancel">Batal</option>
						</select>
					</div>
					<div class="col-lg-4 mb-lg-0 mb-0">
						<label></label>
						<button class="btn btn-primary btn-primary--icon" id="filter">
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
