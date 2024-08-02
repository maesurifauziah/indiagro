"use strict";
var KTDatatablesSearchOptionsAdvancedSearch = function() {

	var initTable1 = function() {

        $("#import").click(function () {
            $('.form-group').removeClass('text-danger');
            $('.help-block').empty();
            $('#modal-import-photo').modal('show');
        
            $('#doc_id').val('');
            $('#view_doc_id').val('');
            $('#type').val('upload');

            var output = document.getElementById('output');
			output.style="background-image: url('assets/media/users/blank.png'); border: 3px solid #ffffff; -webkit-box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, 0.075); box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, 0.075); "

        });

        $("#upload").click(function () {
            let file = $("#photo")[0].files[0];
            if (file === undefined) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Gagal!',
                    text: 'Silahkan pilih file zip!!!',
                    showConfirmButton: true
                });
                return;
            }
        

            var formData = new FormData($('#form-import-photo')[0]);
                $.ajax({
                    url: HOST_URL + "tes2/save",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: "JSON",
                    success: function(data) {
                        if (data.status) {
                            $('#modal-form-master_kategori_barang').modal('hide');
                            Swal.fire({
                                        icon: 'success',
                                        title: 'Success!',
                                        text: 'Data success upload...',
                                    });
                        } else {
                            Swal.fire({
                                        icon: 'warning',
                                        title: 'Gagal!',
                                        text: 'Upload data manual gagal...',
                                        showConfirmButton: true
                                    });
                        }
                        
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.close();
                                Swal.fire({
                                    icon: 'warning',
                                    title: textStatus,
                                    text: errorThrown,
                                    showConfirmButton: true
                                });
                    }
                });
        });
        function uploadzip() {
            
        }

		$('#photo').on('change', function (e) {	
			var input = e.target;

			var reader = new FileReader();
			reader.onload = function(){
			var dataURL = reader.result;
			var output = document.getElementById('output');
			output.style="background-image: url('"+dataURL+"'); border: 3px solid #ffffff; -webkit-box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, 0.075); box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, 0.075); "

			};
			reader.readAsDataURL(input.files[0]);
		});
		
	};

	return {

		//main function to initiate the module
		init: function() {
			initTable1();
		},

	};

}();

jQuery(document).ready(function() {
	KTDatatablesSearchOptionsAdvancedSearch.init();
	
});


