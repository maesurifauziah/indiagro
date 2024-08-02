"use strict";

var currentscrollHeight = 0;
var count = 0;
var KTDatatablesSearchOptionsAdvancedSearch = function() {

// 	filter_date_start
// filter_date_end
	var initList = function() {
		get_list_order_ready_delivery($('#filter_date_start').val(),$('#filter_date_end').val(), $('#filter_status_order').val());

		// $("#kt_subheader_search_form").keyup(function(){
		// 	get_list_order_ready_delivery($('#filter_date_start').val(),$('#filter_date_end').val());
        // });
		$('#filter').on('click', function(e) {
			e.preventDefault();
			get_list_order_ready_delivery($('#filter_date_start').val(),$('#filter_date_end').val(),$('#filter_status_order').val());
		});
        

		// $('.product').on('click', '.packing_record', function () {
		// 	var order_id = $(this).data('order_id');
			
		// 	Swal.fire({
		// 		icon: 'warning',
		// 		title: 'Anda Yakin?',
		// 		text: 'Packing data ' + order_id,
		// 		confirmButtonColor: '#3085d6',
		// 		cancelButtonColor: '#d33',
		// 		confirmButtonText: "Yes",
		// 		cancelButtonText: "No",
		// 		showCancelButton: true,
		// 	}).then((result) => {
		// 		if (result.value) {
		// 			$.ajax({
		// 				type: 'POST',
		// 				url: HOST_URL + 'ekspedisi/packing',
		// 				data: {
		// 					order_id: order_id
		// 				},
		// 				success: function (data) {
		// 					if (data.status) {
		// 						Swal.fire({
		// 							icon: 'success',
		// 							title: 'Berhasil!',
		// 							text: 'Data Berhasil dipacking...',
		// 							showConfirmButton: true
		// 						});
		// 						get_list_order_ready_delivery($('#filter_date_start').val(),$('#filter_date_end').val(),$('#filter_status_order').val());

		// 					} else {
		// 						Swal.fire({
		// 							icon: 'error',
		// 							title: 'Error!',
		// 							text: 'Data tedak tersimpan...',
		// 							showConfirmButton: true
		// 						});
		// 					}
		// 				},
		// 				error: function (jqXHR, textStatus, errorThrown) {
		// 					Swal.close();
		// 					Swal.fire({
		// 						icon: 'warning',
		// 						title: textStatus,
		// 						text: errorThrown,
		// 						showConfirmButton: true
		// 					});
		// 				}
		// 			});
		// 		}
		// 	});
		// });
		$('.product').on('click', '.pengiriman_record', function () {
				var order_id = $(this).data('order_id');
				
				Swal.fire({
					icon: 'warning',
					title: 'Anda Yakin?',
					text: 'Proses Pengiriman data ' + order_id,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: "Yes",
					cancelButtonText: "No",
					showCancelButton: true,
				}).then((result) => {
					if (result.value) {
						$.ajax({
							type: 'POST',
							url: HOST_URL + 'ekspedisi/kirim',
							data: {
								order_id: order_id
							},
							success: function (data) {
								if (data.status) {
									Swal.fire({
										icon: 'success',
										title: 'Berhasil!',
										text: 'Data Berhasil diproses kirim...',
										showConfirmButton: true
									});
									get_list_order_ready_delivery($('#filter_date_start').val(),$('#filter_date_end').val(),$('#filter_status_order').val());

								} else {
									Swal.fire({
										icon: 'error',
										title: 'Error!',
										text: 'Data tedak tersimpan...',
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
		$('.product').on('click', '.lunas_record', function () {
				var order_id = $(this).data('order_id');
				
				Swal.fire({
					icon: 'warning',
					title: 'Anda Yakin?',
					text: 'Proses Pelunasan data ' + order_id,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: "Yes",
					cancelButtonText: "No",
					showCancelButton: true,
				}).then((result) => {
					if (result.value) {
						$.ajax({
							type: 'POST',
							url: HOST_URL + 'ekspedisi/lunas',
							data: {
								order_id: order_id
							},
							success: function (data) {
								if (data.status) {
									Swal.fire({
										icon: 'success',
										title: 'Berhasil!',
										text: 'Data Berhasil diproses lunas...',
										showConfirmButton: true
									});
									get_list_order_ready_delivery($('#filter_date_start').val(),$('#filter_date_end').val(),$('#filter_status_order').val());

								} else {
									Swal.fire({
										icon: 'error',
										title: 'Error!',
										text: 'Data tedak tersimpan...',
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
		$('.product').on('click', '.done_record', function () {
				var order_id = $(this).data('order_id');
				var kode_jenis_barang = $(this).data('kode_jenis_barang');
				var qty = $(this).data('qty');
				var qty_order = $(this).data('qty_order');
				
				Swal.fire({
					icon: 'warning',
					title: 'Anda Yakin?',
					text: 'Selesai data ' + order_id,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: "Yes",
					cancelButtonText: "No",
					showCancelButton: true,
				}).then((result) => {
					if (result.value) {
						$.ajax({
							type: 'POST',
							url: HOST_URL + 'ekspedisi/done',
							data: {
								order_id: order_id,
								qty: qty,
								qty_order: qty_order,
								kode_jenis_barang: kode_jenis_barang
							},
							success: function (data) {
								if (data.status) {
									Swal.fire({
										icon: 'success',
										title: 'Berhasil!',
										text: 'Data selesai diproses...',
										showConfirmButton: true
									});
									get_list_order_ready_delivery($('#filter_date_start').val(),$('#filter_date_end').val(),$('#filter_status_order').val());

								} else {
									Swal.fire({
										icon: 'error',
										title: 'Error!',
										text: 'Data tedak tersimpan...',
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
		$('.product').on('click', '.cancel_record', function () {
				var order_id = $(this).data('order_id');
				var stock_id = $(this).data('stock_id')+'_'+$(this).data('qty_stock');
				var qty_order = $(this).data('qty_order');
				
				Swal.fire({
					icon: 'warning',
					title: 'Anda Yakin?',
					text: 'Selesai data ' + order_id,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: "Yes",
					cancelButtonText: "No",
					showCancelButton: true,
				}).then((result) => {
					if (result.value) {
						$.ajax({
							type: 'POST',
							url: HOST_URL + 'ekspedisi/cancel',
							data: {
								order_id: order_id,
								stock_id: stock_id,
								qty_order: qty_order
							},
							success: function (data) {
								if (data.status) {
									Swal.fire({
										icon: 'success',
										title: 'Berhasil!',
										text: 'Data selesai diproses...',
										showConfirmButton: true
									});
									get_list_order_ready_delivery($('#filter_date_start').val(),$('#filter_date_end').val(),$('#filter_status_order').val());

								} else {
									Swal.fire({
										icon: 'error',
										title: 'Error!',
										text: 'Data tedak tersimpan...',
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

		
		
	};
	function get_list_order_ready_delivery(date_start, date_end, status_order) {
		$('.product').empty();
		$.ajax({
			url: HOST_URL + 'ekspedisi/get_list_order_ready_delivery?date_start='+date_start+"&date_end="+date_end+"&status_order="+status_order,
			type: "GET",
			dataType: "JSON",
			success: function(data) {
				KTApp.block('.container_product', {
					overlayColor: '#000000',
					state: 'primary',
					message: 'Processing...'
				});
	
				setTimeout(function() {
					KTApp.unblock('.container_product');
				}, 500);

				$('.product').html(data.html);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Error show data');
			}
		});
	}
	var modalForm = function() {

		// $('.product').on('click', '.detail_record', function () {
		// 	alert('tes')
		// });

		


    }



	return {

		//main function to initiate the module
		init: function() {
			initList();
			modalForm();
			
		},

	};

	

}();

jQuery(document).ready(function() {
	KTDatatablesSearchOptionsAdvancedSearch.init();
	
});




