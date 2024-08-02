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
							<a href="" class="text-muted">Log Activity</a>
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
				<div class="card-body">
					<!--begin: Search Form-->
					<form class="mb-15">
						<div class="row mb-6">
						<div class="col-lg-6 mb-lg-0 mb-6">
							<label>Date:</label>
							<div class="input-daterange input-group" id="kt_datepicker">
								<input type="date" class="form-control datatable-input" name="start" id="start" placeholder="From" value="<?=date('Y-m-d')?>" />
								<div class="input-group-append">
									<span class="input-group-text">
										<i class="la la-ellipsis-h"></i>
									</span>
								</div>
								<input type="date" class="form-control datatable-input" name="end" id="end" placeholder="To" value="<?=date('Y-m-d')?>" />
							</div>
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
                               <th>UID</th>
                               <th>Controller</th>
                               <th>IP Address</th>
                               <th>Description</th>
                               <th>DB Error</th>
                               <th>Timestamp</th>
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



