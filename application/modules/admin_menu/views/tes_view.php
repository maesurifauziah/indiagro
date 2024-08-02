<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-6 subheader-transparent" id="kt_subheader">
        <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <!--begin::Page Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <!--begin::Page Title-->
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Metronic Image Input</h5>
                    <!--end::Page Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="" class="text-muted">Crud</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="" class="text-muted">File Upload</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="" class="text-muted">Image Input</a>
                        </li>
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page Heading-->
            </div>
            <!--end::Info-->
            <!--begin::Toolbar-->
            
            <!--end::Toolbar-->
        </div>
    </div>
    <!--end::Subheader-->
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Empty Input</h3>
                    </div>
                    <div class="card-toolbar">
                        <div class="example-tools justify-content-center">
                            <span class="example-toggle" data-toggle="tooltip" title="View code"></span>
                        </div>
                    </div>
                </div>
                <!--begin::Form-->
                <form>
                    <div class="card-body">
                        <div class="form-group row">
                           
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                               data-target="#modal-import-photo" id="import">
                               Launch demo modal</button>
                            
                        </div>
                        <!--begin::Code-->
                        <div class="example-code">
                            <ul class="example-nav nav nav-tabs nav-bold nav-tabs-line nav-tabs-line-2x">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#example_code_5_html">HTML</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#example_code_5_js">JS</a>
                                </li>
                            </ul>
                            <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
                            <div class="tab-content">
                                <div class="tab-pane active" id="example_code_5_html" role="tabpanel">
                                    <div class="example-highlight">
                                        <pre>

                                        </pre>
                                    </div>
                                </div>
                                <div class="tab-pane" id="example_code_5_js">
                                    <div class="example-highlight">
                                        <pre style="height:400px">
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Code-->
                    </div>
                </form>
                <!--end::Form-->
            </div>
        
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>

<div class="modal fade" id="modal-import-photo" data-backdrop="static" data-keyboard="false">
       <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header">
                   <h4 class="modal-title">Import File Zip</h4>
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                   </button>
               </div>
               <div class="modal-body">
                   <?=form_open('tes2/save', array('id' => 'form-import-photo', 'class' => 'form'), array('id' => 'import_photo'))?>
                   <input type="hidden" name="doc_id" id="doc_id">
                   <input type="hidden" name="type" id="type">
                   <div class="form-group">
                       
                   <div class="symbol symbol-120 border border-light">
                           <div class="symbol-label img-ipt" id='output' style="background-image: url(assets/media/users/blank.png)"></div>
                           <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow symbol-badge" style="height: 24px; width: 24px;">
                                <i class="fa fa-pen icon-sm text-muted p-2"></i>
                                <input type="file" name="photo" id="photo" accept=".png, .jpg, .jpeg" style="opacity:0">
                           </label>
                        </div>

                        
                        <!-- <div class="image-input image-input-empty image-input-outline" id="kt_image_5" style="background-image: url(assets/media/users/blank.png)">
							<div class="image-input-wrapper" id="image-ipt"></div>
							<label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
								<i class="fa fa-pen icon-sm text-muted"></i>
								<input type="file" name="photo" accept=".png, .jpg, .jpeg" />
								<input type="hidden" name="photo_remove" />
							</label>
							<span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
								<i class="ki ki-bold-close icon-xs text-muted"></i>
							</span>
							<span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove" data-toggle="tooltip" title="Remove avatar">
								<i class="ki ki-bold-close icon-xs text-muted"></i>
							</span>
						</div> -->
                   </div>
                   <?=form_close()?>
                   
               </div>
               <div class="modal-footer">
                   <button type="button" class="btn bg-gradient-primary" id="upload">Upload</button>
                   <button type="button" class="btn bg-gradient-danger" data-dismiss="modal" id="batal">Batal</button>
               </div>
           </div>
           <!-- /.modal-content -->
       </div>
       <!-- /.modal-dialog -->
   </div>