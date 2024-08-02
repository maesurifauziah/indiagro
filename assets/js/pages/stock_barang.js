"use strict";

var currentscrollHeight = 0;
var count = 0;
var KTDatatablesSearchOptionsAdvancedSearch = function() {

	
	var initList = function() {
		// $('#filter_kategori').select2();
		// $('#filter_barang').select2();

		// begin first table
		get_list_barang($('#filter_kategori').val(),$('#filter_barang').val(),$('#filter_status').val(),$("#kt_subheader_search_form").val());
		// get_list_barang('',$("#kt_subheader_search_form").val());
		
		// $('#filter_kategori').on('change', function() {
			// 	get_list_barang($('#filter_kategori').val(),$("#kt_subheader_search_form").val());
		// });

		$("#kt_subheader_search_form").keyup(function(){
			get_list_barang($('#filter_kategori').val(),$('#filter_barang').val(),$('#filter_status').val(),$("#kt_subheader_search_form").val());
        });
		$('#filter').on('click', function(e) {
			e.preventDefault();
			get_list_barang($('#filter_kategori').val(),$('#filter_barang').val(),$('#filter_status').val(),$("#kt_subheader_search_form").val());
		});
        
		
	};
	function get_list_barang(typeTerm, typeTerm2, typeTerm3, searchTerm) {
		$('.product').empty();
		$.ajax({
			url: HOST_URL + 'stock_barang/get_list_barang?typeTerm='+typeTerm+"&typeTerm2="+typeTerm2+"&typeTerm3="+typeTerm3+"&searchTerm="+searchTerm,
			type: "GET",
			dataType: "JSON",
			success: function(data) {
				KTApp.block('#container_product', {
					overlayColor: '#000000',
					state: 'primary',
					message: 'Processing...'
				});
	
				setTimeout(function() {
					KTApp.unblock('#container_product');
				}, 500);

				$('.product').html(data.html);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Error show data');
			}
		});
	}
	var modalForm = function() {
		  
		$('#add').on('click', function() {
			$('#tambah_barang')[0].reset();
			$('form#tambah_barang input').removeClass('is-invalid');
			$('form#tambah_barang select').removeClass('is-invalid');
			$('.invalid-feedback').empty();
			$('#modal-form').modal('show');

			$('#type').val('add');

			$('#save').show();
			$('#kode_barang').attr('readonly', false);
			$('#nama_barang').attr('readonly', false);
			$('#kategori_id').attr('readonly', false);
			$('#harga').attr('readonly', true);
			$('#qty').attr('readonly', false);
			$('#photo').attr('readonly', false);
			$('#keterangan').attr('readonly', false);
			$('#userid').attr('readonly', false);

			if ($('#photo_name').val() == '') {
				output.style="background-image: url('assets/media/users/blank.png'); border: 3px solid #ffffff; -webkit-box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, 0.075); box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, 0.075); "
			} else {
				output.style="background-image: url('upload/stock_barang/"+$(this).data('photo_bukti_barang')+"'); border: 3px solid #ffffff; -webkit-box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, 0.075); box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, 0.075); "
			}


		});

		$('.product').on('click', '.edit_barang', function () {
			$('#tambah_barang')[0].reset();
			$('form#tambah_barang input').removeClass('is-invalid');
			$('form#tambah_barang select').removeClass('is-invalid');
			$('.invalid-feedback').empty();
			$('#modal-form').modal('show');
		
			$('#type').val('edit');

			$('#userid').val($(this).data('userid'));
			$('#stock_id').val($(this).data('stock_id'));
			$('#kategori_id').val($(this).data('kategori_id'));
			$('#kode_barang').val($(this).data('kode_barang'));
			$('#kode_jenis_barang').val($(this).data('kode_jenis_barang'));
			$('#keterangan').val($(this).data('keterangan'));
			$('#harga').val($(this).data('harga_format'));
			$('#qty').val($(this).data('qty_format'));
			$('#photo_name').val($(this).data('photo_bukti_barang'));

			if ($(this).data('photo_bukti_barang') == '') {
				output.style="background-image: url('assets/media/users/blank.png'); border: 3px solid #ffffff; -webkit-box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, 0.075); box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, 0.075); "
			} else {
				output.style="background-image: url('upload/stock_barang/"+$(this).data('photo_bukti_barang')+"'); border: 3px solid #ffffff; -webkit-box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, 0.075); box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, 0.075); "
			}

			('#save').show();
			$('#kode_barang').attr('readonly', false);
			$('#nama_barang').attr('readonly', false);
			$('#kategori_id').attr('readonly', false);
			$('#harga').attr('readonly', true);
			$('#qty').attr('readonly', false);
			$('#photo').attr('readonly', false);
			$('#keterangan').attr('readonly', false);
			$('#userid').attr('readonly', false);
		});


		$('#modal-form').on('shown.bs.modal', function () {
			$('#kategori_id').select2();
			$('#kode_barang').select2();
			$('#kode_jenis_barang').select2();

		});

		$('.product').on('click', '.add_to_cart', function () {
			$('#tambah_barang_cart')[0].reset();
			$('form#tambah_barang_cart input').removeClass('is-invalid');
			$('form#tambah_barang_cart select').removeClass('is-invalid');
			$('.invalid-feedback').empty();
			$('#modal-form2').modal('show');

			$('#label-nama-barang').text('tes');
		
		});

		$('#photo_bukti_barang').on('change', function (e) {	
			var input = e.target;

			var reader = new FileReader();
			reader.onload = function(){
			var dataURL = reader.result;
			
			output.style="background-image: url('"+dataURL+"'); border: 3px solid #ffffff; -webkit-box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, 0.075); box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, 0.075); "

			};
			reader.readAsDataURL(input.files[0]);
		});

	
		$("#save").click(function () {
			let file = $("#photo_bukti_barang")[0].files[0];
			// if (file === undefined) {
			//     $("#photo_bukti_barang").val('');
			// } else {
			//     if (file.size > 300000) {
			//         Swal.fire({
			//             icon: 'warning',
			//             title: 'Gagal!',
			//             text: 'Photo tidak boleh lebih dari 300Kb!!!',
			//             showConfirmButton: true
			//         });
			//         return;
			//     }
			// }			
		
			var formData = new FormData($('#tambah_barang')[0]);
				$.ajax({
					url: HOST_URL + "stock_barang/save",
					type: "POST",
					data: formData,
					contentType: false,
					processData: false,
					dataType: "JSON",
					success: function(data) {
						$("#save").removeAttr('disabled').text('Simpan');
							if (data.status) {
								$('#modal-form').modal('hide');
								// $('#admin_user')[0].reset();
								Swal.fire({
									icon: 'success',
									title: 'Berhasil!',
									text: 'Data Berhasil disimpan...',
									showConfirmButton: true
								});
								get_list_barang($('#filter_kategori').val(),$('#filter_barang').val(),$('#filter_status').val(),$("#kt_subheader_search_form").val());
							} else {

								if (data.invalid) {
									$.each(data.invalid, function (key, val) {
										$('[name="' + key + '"]').addClass('is-invalid');
										$('#' + key + '-error').html(val);
										if (val == '') {
											$('[name="' + key + '"]').removeClass('is-invalid');
											$('#' + key + '-error').html('');
										}
									});
								}
								
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

		$('form#tambah_barang_cart').on('submit', function (e) {
			e.preventDefault();
			e.stopImmediatePropagation();
		
			$("#save").attr('disabled', 'disabled').text('Wait...');
		
			$.ajax({
				url: $(this).attr('action'),
				data: $(this).serialize(),
				method: 'POST',
				success: function (data) {
					$("#save").removeAttr('disabled').text('Simpan');
					if (data.status) {
						$('#modal-form').modal('hide');
						$('#tambah_barang_cart')[0].reset();
						Swal.fire({
							icon: 'success',
							title: 'Berhasil!',
							text: 'Data Berhasil disimpan...',
							showConfirmButton: true
						});
						// get_list_barang($('#filter_kategori').val(),$("#kt_subheader_search_form").val());
					} else {
						if (data.invalid) {
							$.each(data.invalid, function (key, val) {
								$('[name="' + key + '"]').addClass('is-invalid');
								$('#' + key + '-error').html(val);
								if (val == '') {
									$('[name="' + key + '"]').removeClass('is-invalid');
									$('#' + key + '-error').html('');
								}
							});
						}
					}
				},
				error: function (jqXHR, textStatus, errorThrown) {
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
    }

	function formatRupiah(angka, prefix)
		{
			var number_string = angka.replace(/[^,\d]/g, '').toString(),
				split    = number_string.split(','),
				sisa     = split[0].length % 3,
				rupiah     = split[0].substr(0, sisa),
				ribuan     = split[0].substr(sisa).match(/\d{3}/gi);
				
			if (ribuan) {
				var separator = sisa ? '.' : '';
				rupiah += separator + ribuan.join('.');
			}
			
			rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
			return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
		}

	var inputForm = function() {
		$('#harga').on('keypress', function(e) {
			var ASCIICode = (e.which) ? e.which : e.keyCode
			if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
				return false;
			return true;
		});

		var inputharga = document.getElementById('harga');

		inputharga.addEventListener('keyup', function() {
			var val = this.value;
			val = formatRupiah(val);
			this.value = val;
		});
		
		$('#qty').on('keypress', function(e) {
			var ASCIICode = (e.which) ? e.which : e.keyCode
			if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
				return false;
			return true;
		});

		var inputqty = document.getElementById('qty');

		inputqty.addEventListener('keyup', function() {
			var val2 = this.value;
			val2 = formatRupiah(val2);
			this.value = val2;
		});

		$('#kategori_id').on('change', function() {
			$.ajax({
				url: HOST_URL + 'master_barang/get_barang_by_kategori/'+$('#kategori_id').val(),
				type: "POST",
				dataType: "JSON",
				success: function(data) {
					$('#kode_barang').empty();
					$('#kode_barang').append('<option value="">-- Pilih Barang --</option>');
					for (var i = 0; i < data.length; i++) {
						$('#kode_barang').append('<option id=' + data[i].kode_barang + ' value=' + data[i].kode_barang + '>' + data[i].nama_barang + '</option>');
					}
					// $('#kode_barang').change();
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert('Error filter data');
				}
			});
		});

		$("#kode_barang").on('change', function(){
			$.ajax({
				url: HOST_URL + 'master_jenis_barang/get_jenis_barang_by_barang/'+$(this).val(),
				type: "POST",
				dataType: "JSON",
				success: function(data) {
					$('#kode_jenis_barang').empty();
					$('#kode_jenis_barang').append('<option value="">-- Pilih Jenis Barang --</option>');
					for (var i = 0; i < data.length; i++) {
						$('#kode_jenis_barang').append('<option id=' + data[i].kode_jenis_barang + ' value=' + data[i].kode_jenis_barang + '>' + data[i].nama_jenis_barang + '</option>');
					}
					// $('#kode_jenis_barang').change();
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert('Error filter data');
				}
			});
        });
		$("#kode_jenis_barang").on('change', function(){
			$.ajax({
				url: HOST_URL + 'master_jenis_barang/get_detail_jenis_barang/'+$(this).val(),
				type: "GET",
				dataType: "JSON",
				success: function(data) {
					$("#harga").val(formatRupiah(data.harga))
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert('Error show data');
				}
			});
        });

		$('#filter_kategori').on('change', function() {
			$.ajax({
				url: HOST_URL + 'master_barang/get_barang_by_kategori/'+$('#filter_kategori').val(),
				type: "POST",
				dataType: "JSON",
				success: function(data) {
					$('#filter_barang').empty();
					$('#filter_barang').append('<option value="all">Semua</option>');
					for (var i = 0; i < data.length; i++) {
						$('#filter_barang').append('<option id=' + data[i].kode_barang + ' value=' + data[i].kode_barang + '>' + data[i].nama_barang + '</option>');
					}
					// $('#filter_barang').change();
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert('Error filter data');
				}
			});
		});
		
    }

	return {

		//main function to initiate the module
		init: function() {
			initList();
			modalForm();
			inputForm();
		},

	};

	

}();

jQuery(document).ready(function() {
	KTDatatablesSearchOptionsAdvancedSearch.init();
	
});




