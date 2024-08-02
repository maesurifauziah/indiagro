"use strict";

// Class definition
var KTEcommerceCheckout = function () {
	// Base elements
	var _wizardEl;
	var _formEl;
	var _wizardObj;
	var _validations = [];
	var numberOfChecked = 0;
	var harga_total = 0;

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

	function formatRupiahView(angka)
	{
		return angka.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
	}
	
	function get_list_order() {
		$('.list-order').empty();
		$.ajax({
			url: HOST_URL + 'order/get_list_order',
			type: "GET",
			dataType: "JSON",
			success: function(data) {
				KTApp.block('#container_order', {
					overlayColor: '#000000',
					state: 'primary',
					message: 'Processing...'
				});
	
				setTimeout(function() {
					KTApp.unblock('#container_order');
				}, 500);

				$('.list-order').empty();
				$('#jumlah_data').val(data.length);
				$('.count-order').text('Pilih Semua ('+data.length+')');
				var data_bind = '';
				var photo = '';
                    for (var i = 0; i < data.length; i++) {
						data_bind = 'data-order_id="'+data[i].order_id+'" data-nama_jenis_barang="'+data[i].nama_jenis_barang+'"';

						photo = data[i].photo == '' || data[i].photo == null ? '<img src="assets/media/users/blank2.png" title="" alt="">' : '<img src="'+HOST_URL+'upload/master_barang/'+data[i].photo+'" title="" alt="">';
                        $('.list-order').append(
                            '<div class="d-flex align-items-center justify-content-between p-2">'+
								'<div class="d-flex align-items-left">'+
									'<label class="checkbox pr-4">'+
										'<input type="checkbox" class="data_ceklis" name="data_ceklis['+i+']" id="data_ceklis'+i+'" >'+
										'<span></span>'+
									'</label>'+
									'<a href="#" class="symbol symbol-70 flex-shrink-0 pr-6">'+
										photo+
									'</a>'+
									'<div class="d-flex flex-column mr-2 pr-15">'+
									'<input type="hidden" class="order_id" name="order_id['+i+']" id="order_id'+i+'" value="'+data[i].order_id+'">'+
									'<input type="hidden" class="userid" name="userid['+i+']" id="userid'+i+'" value="'+data[i].userid+'">'+
									'<input type="hidden" class="kategori_id" name="kategori_id['+i+']" id="kategori_id'+i+'" value="'+data[i].kategori_id+'">'+
									'<input type="hidden" class="kode_barang" name="kode_barang['+i+']" id="kode_barang'+i+'" value="'+data[i].kode_barang+'">'+
									'<input type="hidden" class="kode_jenis_barang" name="kode_jenis_barang['+i+']" id="kode_jenis_barang'+i+'" value="'+data[i].kode_jenis_barang+'">'+
									'<input type="hidden" class="harga" name="harga['+i+']" id="harga'+i+'" value="'+data[i].harga+'">'+
									'<input type="hidden" class="qty" name="qty['+i+']" id="qty'+i+'" value="'+data[i].qty+'">'+
									'<input type="hidden" class="harga_total" name="harga_total['+i+']" id="harga_total'+i+'" value="'+data[i].harga_total+'">'+
									'<input type="hidden" class="qty_order" name="qty_order['+i+']" id="qty_order'+i+'" value="'+data[i].qty_order+'">'+
									'<input type="hidden" class="photo" name="photo['+i+']" id="photo'+i+'" value="'+data[i].photo+'">'+
									'<input type="hidden" class="nama_jenis_barang" name="nama_jenis_barang['+i+']" id="nama_jenis_barang'+i+'" value="'+data[i].nama_jenis_barang+'">'+

										'<a href="#" class="font-weight-bold text-dark-75 font-size-lg text-hover-primary pr-20">'+data[i].nama_jenis_barang+'</a>'+
										'<span class="text-muted">'+formatRupiah(data[i].qty_order)+' Kg</span>'+
										'<div class="d-flex align-items-center mt-2">'+
											'<span class="font-weight-bold mr-1 text-dark-75 font-size-lg">'+formatRupiah(data[i].harga_total, 'Rp. ')+'</span>'+
										'</div>'+
									'</div>'+
								'</div>'+
								'<div class="d-flex align-items-right pr-5">'+
									'<a href="#" class="cancel-record btn btn-icon btn-light-danger btn-hover-danger btn-sm" '+data_bind+'>'+
										'<span class="svg-icon svg-icon-md svg-icon-danger">'+
											'<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">'+
												'<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">'+
													'<rect x="0" y="0" width="24" height="24"></rect>'+
													'<path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"></path>'+
													'<path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"></path>'+
												'</g>'+
											'</svg>'+
										'</span>'+
									'</a>'+
                        		'</div>'+
                        '</div>'+
                        '<div class="separator separator-solid"></div>'
                        );
                      
                    }
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Error show data');
			}
		});
	}

	$('#data_check_all').on('click', function() {
		harga_total = 0;
		
		if ($("#data_check_all").is(":checked")) {
			for (var j = 0; j <= $('#jumlah_data').val(); j++){
				$('#data_ceklis'+j).prop('checked', true);
			}
			$('.harga_total').each(function(){
				harga_total += parseInt(this.value);
			});
			$('.total_harga_order').text('Rp. '+formatRupiahView(harga_total))
			$('#total_harga_order_value').val(harga_total)
			
		} else {
			for (var j = 0; j <= $('#jumlah_data').val(); j++){
				$('#data_ceklis'+j).prop('checked', false);
			}
			$('.harga_total').each(function(){
				harga_total -= parseInt(this.value);
			});
			// $('.total_harga_order').text('Rp. '+formatRupiahView(harga_total))
			$('.total_harga_order').text('Rp. '+0)
			$('#total_harga_order_value').val(0)
		}
		numberOfChecked = $('.data_ceklis:checked').length;
		$('.count_choose').text('Total ('+numberOfChecked+')');

		
	});

	$('.list-order').on('click', '.data_ceklis', function () {
		numberOfChecked = $('.data_ceklis:checked').length;
		harga_total = 0;
		$('.count_choose').text('Total ('+numberOfChecked+')');
		var index = $('.list-order .data_ceklis').index( this );
		if ($('#data_ceklis'+index).prop('checked')){
			$('#data_ceklis'+index).prop('checked','checked');
			harga_total = parseInt($('#total_harga_order_value').val()) + parseInt($('#harga_total'+index).val());
			
		} else {
			$('#data_ceklis'+index).prop('checked', false);
			harga_total = parseInt($('#total_harga_order_value').val()) - parseInt($('#harga_total'+index).val());
		}
		
		$('.total_harga_order').text('Rp. '+formatRupiahView(harga_total))
		$('#total_harga_order_value').val(harga_total)
		
		
	});
	
	$('.list-order').on('click', '.cancel-record', function () {
		var order_id = $(this).data('order_id');
		var nama_jenis_barang = $(this).data('nama_jenis_barang');
		
		Swal.fire({
			icon: 'warning',
			title: 'Anda yakin ?',
			text: ' Batalkan Pesanan ' + nama_jenis_barang + '?',
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: "Yes",
			cancelButtonText: "No",
			showCancelButton: true,
		}).then((result) => {
			if (result.value) {
				$.ajax({
					type: 'POST',
					url: HOST_URL + 'keranjang/cancel',
					data: {
						order_id: order_id
					},
					success: function (data) {
						if (data.status) {
							Swal.fire({
								icon: 'success',
								title: 'Berhasil!',
								text: 'Data Berhasil dibatalkan...',
								showConfirmButton: true
							});
							get_list_order();
						} else {
							Swal.fire({
								icon: 'error',
								title: 'Error!',
								text: 'Data tedak dibatalkan...',
								showConfirmButton: true
							});
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
			}
		});
	});
	
	
	$('#checkout-btn').on('click', function() {
		$('#alamat_kirim_preview').text($('#alamat_kirim').val());
		$('#detail_order').empty();
		var rowids = [];
		var photo2 = '';
            $.each( $('.data_ceklis:checked'), function(index, rowId){
				var ids = this.id.split("data_ceklis")
                rowids.push(ids[1]);
            });
			
			for (var j = 0; j <= rowids.length-1; j++){

				photo2 = $('#photo'+rowids[j]).val() == '' || $('#photo'+rowids[j]).val() == null ? '<img src="assets/media/users/blank2.png" title="" alt="">' : '<img src="'+HOST_URL+'upload/master_barang/'+$('#photo'+rowids[j]).val()+'" title="" alt="">';

				$('#detail_order').append(
					'<tr class="font-weight-boldest">'+
						'<td class="border-0 pl-0 pt-7 d-flex align-items-center">'+
						'<div class="symbol symbol-60 flex-shrink-0 mr-4 bg-light">'+
							photo2+
						'</div>'+
						$('#nama_jenis_barang'+rowids[j]).val()+'</td>'+
						'<td class="text-right pt-7 align-middle">'+formatRupiah($('#qty_order'+rowids[j]).val())+'</td>'+
						'<td class="text-right pt-7 align-middle">'+formatRupiah($('#harga'+rowids[j]).val(),'Rp. ')+'</td>'+
						'<td class="text-primary pr-0 pt-7 text-right align-middle">'+formatRupiah($('#harga_total'+rowids[j]).val(), 'Rp. ')+'</td>'+
					'</tr>'
				);
			}

			$('.grand_total_preview').text(formatRupiah($('#total_harga_order_value').val(), 'Rp. '));
			// console.log(data_checkout);
	});

	$("#submit-btn").click(function () {
		var formData = new FormData($('#form_check_out')[0]);
			$.ajax({
				url: HOST_URL + "keranjang/checkout",
				type: "POST",
				data: formData,
				contentType: false,
				processData: false,
				dataType: "JSON",
				success: function(data) {
					$("#submit-btn").removeAttr('disabled').text('Buat Pesanan');
						if (data.status) {
						
							Swal.fire({
								icon: 'success',
								title: 'Berhasil!',
								text: 'Data Berhasil disimpan...',
								showConfirmButton: true
							});

							location.reload();

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

	// Private functions
	var _initWizard = function () {

		get_list_order()
		// Initialize form wizard
		_wizardObj = new KTWizard(_wizardEl, {
			startStep: 1, // initial active step number
			clickableSteps: false, // allow step clicking
			
		});
		

		// Validation before going to next page
		_wizardObj.on('change', function (wizard) {
			if (wizard.getStep() > wizard.getNewStep()) {
				return; // Skip if stepped back
			}

			if (numberOfChecked != 0 && $('#alamat_kirim').val() != '') {
				wizard.goTo(wizard.getNewStep());

				KTUtil.scrollTop();
			} else {
				Swal.fire({
					text: "Lengkapi data sebelum checkout!",
					icon: "error",
					buttonsStyling: false,
					confirmButtonText: "Ya",
					customClass: {
						confirmButton: "btn font-weight-bold btn-light"
					}
				}).then(function () {
					KTUtil.scrollTop();
				});
			}
			
			return false;  // Do not change wizard step, further action will be handled by he validator
		});

		// Change event
		_wizardObj.on('changed', function (wizard) {
			KTUtil.scrollTop();
		});

		// Submit event
		_wizardObj.on('submit', function (wizard) {
			Swal.fire({
				text: "Pesanan Anda akan diproses.",
				icon: "success",
				showCancelButton: true,
				buttonsStyling: false,
				confirmButtonText: "Ya",
				cancelButtonText: "Tidak",
				customClass: {
					confirmButton: "btn font-weight-bold btn-primary",
					cancelButton: "btn font-weight-bold btn-default"
				}
			}).then(function (result) {
				if (result.value) {
					_formEl.submit(); // Submit form
				} else if (result.dismiss === 'cancel') {
					Swal.fire({
						text: "Pesanan Dibatalkan!.",
						icon: "error",
						buttonsStyling: false,
						confirmButtonText: "Ya",
						customClass: {
							confirmButton: "btn font-weight-bold btn-primary",
						}
					});
				}
			});
		});
	}

	var _initValidation = function () {
		// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
		// Step 1
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
					
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap({
						//eleInvalidClass: '',
						eleValidClass: '',
					})
				}
			}
		));

		// Step 2
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
					// ccname: {
					// 	validators: {
					// 		notEmpty: {
					// 			message: 'Credit card name is required'
					// 		}
					// 	}
					// },
					// ccnumber: {
					// 	validators: {
					// 		notEmpty: {
					// 			message: 'Credit card number is required'
					// 		},
					// 		creditCard: {
					// 			message: 'The credit card number is not valid'
					// 		}
					// 	}
					// },
					// ccmonth: {
					// 	validators: {
					// 		notEmpty: {
					// 			message: 'Credit card month is required'
					// 		}
					// 	}
					// },
					// ccyear: {
					// 	validators: {
					// 		notEmpty: {
					// 			message: 'Credit card year is required'
					// 		}
					// 	}
					// },
					// cccvv: {
					// 	validators: {
					// 		notEmpty: {
					// 			message: 'Credit card CVV is required'
					// 		},
					// 		digits: {
					// 			message: 'The CVV value is not valid. Only numbers is allowed'
					// 		}
					// 	}
					// }
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap({
						//eleInvalidClass: '',
						eleValidClass: '',
					})
				}
			}
		));
	}

	return {
		// public functions
		init: function () {
			_wizardEl = KTUtil.getById('kt_wizard');
			_formEl = KTUtil.getById('form_check_out');

			_initWizard();
			_initValidation();
		}
	};
}();

jQuery(document).ready(function () {
	KTEcommerceCheckout.init();
});
