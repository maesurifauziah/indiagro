"use strict";

var currentscrollHeight = 0;
var count = 0;
var KTDatatablesSearchOptionsAdvancedSearch = function() {

	
	var initList = function() {
		get_list_barang($('#filter_kategori').val(),$('#filter_barang').val(),$("#kt_subheader_search_form").val());

		$("#kt_subheader_search_form").keyup(function(){
			get_list_barang($('#filter_kategori').val(),$('#filter_barang').val(),$("#kt_subheader_search_form").val());
        });
		$('#filter').on('click', function(e) {
			e.preventDefault();
			get_list_barang($('#filter_kategori').val(),$('#filter_barang').val(),$("#kt_subheader_search_form").val());
		});
        
		
	};
	function get_list_barang(typeTerm, typeTerm2, searchTerm) {
		$('.product').empty();
		$.ajax({
			url: HOST_URL + 'order/get_list_barang?typeTerm='+typeTerm+"&typeTerm2="+typeTerm2+"&searchTerm="+searchTerm,
			type: "GET",
			dataType: "JSON",
			success: function(data) {
				KTApp.block('.list-order', {
					overlayColor: '#000000',
					state: 'primary',
					message: 'Processing...'
				});
	
				setTimeout(function() {
					KTApp.unblock('.list-order');
				}, 500);

				$('.product').html(data.html);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Error show data');
			}
		});
	}
	var modalForm = function() {

		$('.product').on('click', '.add_to_cart', function () {
			$('#tambah_barang_cart')[0].reset();
			$('form#tambah_barang_cart input').removeClass('is-invalid');
			$('form#tambah_barang_cart select').removeClass('is-invalid');
			$('.invalid-feedback').empty();
			$('#modal-form').modal('show');

			$('#photo_barang').attr('src', $(this).data('path_photo'));
			$('#label-nama-jenis-barang').text($(this).data('nama_jenis_barang'));
			$('#label-harga').text($(this).data('harga_format') + ' / Kg');
			$('#label-qty-stock').text($(this).data('qty_format') + ' Kg');
			$('#userid').val($(this).data('userid'));
			$('#kategori_id').val($(this).data('kategori_id'));
			$('#kode_barang').val($(this).data('kode_barang'));
			$('#kode_jenis_barang').val($(this).data('kode_jenis_barang'));
			$('#harga').val($(this).data('harga'));
			$('#qty').val($(this).data('qty'));
			
			$('#harga_total').attr('readonly', false);
			$('#qty_order').attr('readonly', false);
			$('#qty_order').attr('maxlength', ($(this).data('qty').toString()).length);

		
			var inputqty = document.getElementById('qty_order');

			inputqty.addEventListener('keyup', function() {
				var val2 = this.value;
				val2 = formatRupiah(val2);
				this.value = val2;
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
		$('#qty_order').on('keypress', function(e) {
			var ASCIICode = (e.which) ? e.which : e.keyCode
			if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
				return false;
			return true;
		});

		$("#qty_order").keyup(function(){
			$('#harga_total').val(parseInt($(this).val().replace(".", "")) * parseInt($('#harga').val()));
			if (isNaN($("#harga_total").val())){
				$("#harga_total").val(0);
			}
			if (parseInt($(this).val().replace(".", "")) > $('#qty').val()) {
				$("#qty_order").val(0);
			}
			$('#label_total').text(formatRupiah($('#harga_total').val(),'Rp.'));
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




