"use strict";
var KTDatatablesSearchOptionsAdvancedSearch = function() {

	
	var initTable1 = function() {
		// begin first table
		var table = $('#kt_datatable').DataTable({
			responsive: true,
			// Pagination settings
			dom: `<'row'<'col-sm-12'tr>>
			<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,

			lengthMenu: [5, 10, 25, 50],

			pageLength: 10,

			language: {
				'lengthMenu': 'Display _MENU_',
			},

			searching:true,
			searchDelay: 500,
			buttons: [
				'print',
				'copyHtml5',
				'excelHtml5',
				'csvHtml5',
				'pdfHtml5',
			],
			processing: true,
			serverSide: true,
			ajax: {
				url: HOST_URL + 'transaksi_admin/transaksi_admin_list?status_transaksi=' + $('#filter_status_transaksi').val() + "&trans_id=" + $('#filter_trans_id').val() + "&date_start=" + $('#filter_date_start').val() + "&date_end=" + $('#filter_date_end').val(),
				type: 'POST',
				data: {
					// parameters for custom backend script demo
					columnsDef: [
						'no', 
						'trans_id', 
						'nama_lengkap', 
						'tgl_checkout', 
						'total', 
						'total_batal', 
						'grand_total',
						'progress',
						'alamat_kirim',
						'status_transaksi',
						'action'
					],
				},
			},
			columns: [
				{data: 'no'},
				{data: 'trans_id'},
				{data: 'nama_lengkap'},
				{data: 'tgl_checkout'},
				{data: 'total'},
				{data: 'total_batal'},
				{data: 'grand_total'},
				{data: 'progress'},
				{data: 'alamat_kirim'},
				{data: 'status_transaksi'},
				{data: 'action', responsivePriority: -1},
			],

			columnDefs: [
				{
					targets: 0,
					orderable: false,
				},
				{
					targets: 10,
					orderable: false,
				},
				{
					targets: 9,
					render: function(data, type, full, meta) {
						var status = {
							'draft': {'title': 'Draft', 'class': ' label-light'},
							'done': {'title': 'Habis', 'class': ' label-light-success'},
							'cancel': {'title': 'Batal', 'class': ' label-light-danger'},
						};
						if (typeof status[data] === 'undefined') {
							return data;
						}
						return '<span class="label label-lg font-weight-bold' + status[data].class + ' label-inline">' + status[data].title + '</span>';
					},
				},
			],
		});

		var table2 = $('#kt_datatable2').DataTable({
				responsive: false,
				dom: `<'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
				lengthMenu: [5, 10, 25, 50],
				pageLength: 10,
				language: {
					'lengthMenu': 'Display _MENU_',
				},
				searching:true,
				searchDelay: 500,
				buttons: [
					'print',
					'copyHtml5',
					'excelHtml5',
					'csvHtml5',
					'pdfHtml5',
				],
				processing: true,
				serverSide: true,
				// scrollY: '36vh',
				// scrollY: true,
				ajax: {
					url: HOST_URL + 'transaksi_admin/transaksi_detail_admin_list',
					type: 'POST',
					data: {
						// parameters for custom backend script demo
						columnsDef: [
							'no', 
							'order_id', 
							'nama_jenis_barang',
							'harga_total',
							'qty_order',
							'status_order',
							'kurir',
							'stock',
							'action'
						],
					},
				},
				columns: [
					{data: 'no'},
					{data: 'order_id'},
					{data: 'nama_jenis_barang'},
					{data: 'harga_total'},
					{data: 'qty_order'},
					{data: 'status_order'},
					{data: 'stock', responsivePriority: -3},
					{data: 'kurir', responsivePriority: -2},
					{data: 'action', responsivePriority: -1},
				],
	
				columnDefs: [
					{
						targets: 0,
						orderable: false,
					},
					{
						targets: 6,
						orderable: false,
					},
					{
						targets: 7,
						orderable: false,
					},
					{
						targets: 5,
						render: function(data, type, full, meta) {
							var status = {
								'checkout': {'title': 'Checkout', 'class': ' label-light-success'},
								'packing': {'title': 'Packing', 'class': ' label-light-warning'},
								'pengiriman': {'title': 'Pengiriman', 'class': ' label-light-info'},
								'lunas': {'title': 'Lunas', 'class': ' label-light-warning'},
								'done': {'title': 'Done', 'class': ' label-light-primary'},
								'cancel': {'title': 'Cancel', 'class': ' label-light-danger'},
							};
							if (typeof status[data] === 'undefined') {
								return data;
							}
							return '<span class="label label-lg font-weight-bold' + status[data].class + ' label-inline">' + status[data].title + '</span>';
						},
					},
				],
			});

		

		$('#kt_search').on('click', function(e) {
			e.preventDefault();
			table.ajax.url( HOST_URL + "transaksi_admin/transaksi_admin_list?status_transaksi=" + $('#filter_status_transaksi').val() + "&trans_id=" + $('#filter_trans_id').val() + "&date_start=" + $('#filter_date_start').val() + "&date_end=" + $('#filter_date_end').val()).load();
		});
		
		$('.icon-close').on('click', function(e) {
			e.preventDefault();
			$('#modal-form2').modal('hide');
			$('#modal-form3').modal('hide');
		});
		
		$('#kt_datatable').on('click', '.detail_record', function () {
		
			$('#modal-form').modal('show');
			
			$('#trans_id').val($(this).data('trans_id'));
			table2.ajax.url( HOST_URL + "transaksi_admin/transaksi_detail_admin_list?trans_id=" + $('#trans_id').val()).load();
			
			$('#modal_title').text('No Transaksi ' + $(this).data('trans_id'));
			
			$('#detailid').val($(this).data('detailid'));
			$('#label_nama_lengkap').text($(this).data('userid') +' - '+ $(this).data('nama_lengkap'));
			$('#label_alamat_kirim').text($(this).data('alamat_kirim'));
			$('#label_no_hp').text($(this).data('no_hp'));
			$('#label_pasar').text($(this).data('pasar_desc'));
			$('#label_status_transaksi').text($(this).data('status_transaksi2'));
			if($(this).data('status_transaksi') == 'draft'){
				$('#label_status_transaksi').attr('class', 'label label-lg font-weight-bold label-light-warning label-inline text-warning');
			}
			if($(this).data('status_transaksi') == 'done'){
				$('#label_status_transaksi').attr('class', 'label label-lg font-weight-bold label-light-success label-inline text-success');
			}
			if($(this).data('status_transaksi') == 'cancel'){
				$('#label_status_transaksi').attr('class', 'label label-lg font-weight-bold label-light-danger label-inline text-danger');
			}

		
			$('#save').show();			
		});

		$('#kt_datatable2').on('click', '.set_kurir_record', function () {
			$('#transaksi_admin')[0].reset();
			$('form#transaksi_admin input').removeClass('is-invalid');
			$('form#transaksi_admin select').removeClass('is-invalid');
			$('.invalid-feedback').empty();
			$('#modal-form2').modal('show');
			$('#order_id').val($(this).data('order_id'));
			$('#kurir_id').val($(this).data('kurir_id'));
			
			$('#save').show();			
		});

		$('#kt_datatable2').on('click', '.set_stock_record', function () {
			$('#transaksi_admin_stock')[0].reset();
			$('form#transaksi_admin_stock input').removeClass('is-invalid');
			$('form#transaksi_admin_stock select').removeClass('is-invalid');
			$('.invalid-feedback').empty();
			$('#modal-form3').modal('show');
			$('#order_id_stock').val($(this).data('order_id'));
			$('#trans_id_stock').val($(this).data('trans_id'));
			$('#stock_id2').val($(this).data('stock_id')+'_'+$(this).data('qty_stock'));
			

			
			// $('#stock_id').val($(this).data('stock_id')+'_'+$(this).data('qty'));
			// $('#stock_id option:selected').val($(this).data('stock_id')+'_'+$(this).data('qty')).text($(this).data('stock_id')+'_'+$(this).data('qty')).trigger('change');

			
			$('#kode_jenis_barang').val($(this).data('kode_jenis_barang'));
			$('#qty_order').val($(this).data('qty_order'));

			$.ajax({
				url: HOST_URL + 'transaksi_admin/get_list_stock/'+$('#kode_jenis_barang').val(),
				type: "POST",
				dataType: "JSON",
				success: function(data) {
					$('#stock_id').empty();
					$('#stock_id').append('<option value="">-- Pilih Stock --</option>');
					for (var i = 0; i < data.length; i++) {
						
						$('#stock_id').append('<option id=' + data[i].stock_id + ' value=' + data[i].stock_id + '_' + data[i].qty + '>' + data[i].nama_lengkap + ' - ' +data[i].qty+'</option>');
					}
					// $('#stock_id').val($(this).data('stock_id')+'_'+$(this).data('qty_stock_format'));
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert('Error filter data');
				}
			});
			

			$('#save2').hide();
			// $('#stock_id').on( 'change', function () {
			// 	$('#stock_id2').val($('#stock_id').val());
			// } );
			if($(this).data('stock_id') == null || $(this).data('stock_id') == ''){
				
				$('#save2').show();			
			}		
		});
		
		$('#modal-form2').on('shown.bs.modal', function () {
			$(".select2-kurir").select2();
		});
		$('#modal-form3').on('shown.bs.modal', function () {
			$(".select2-stock").select2();
		});

		$('#kt_datatable2').on('click', '.packing_record', function () {
				var order_id = $(this).data('order_id');
				var stock_id = $(this).data('stock_id')+'_'+$(this).data('qty_stock');
				var qty_order = $(this).data('qty_order');
				
				Swal.fire({
					icon: 'warning',
					title: 'Anda Yakin?',
					text: 'Packing data ' + order_id,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: "Yes",
					cancelButtonText: "No",
					showCancelButton: true,
				}).then((result) => {
					if (result.value) {
						$.ajax({
							type: 'POST',
							url: HOST_URL + 'transaksi_admin/packing',
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
										text: 'Data Berhasil dipacking...',
										showConfirmButton: true
									});
									table.ajax.reload(null, false);
									table2.ajax.reload(null, false);
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
		$('#kt_datatable2').on('click', '.pengiriman_record', function () {
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
							url: HOST_URL + 'transaksi_admin/kirim',
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
									table.ajax.reload(null, false);
									table2.ajax.reload(null, false);
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
		$('#kt_datatable2').on('click', '.lunas_record', function () {
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
							url: HOST_URL + 'transaksi_admin/lunas',
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
									table.ajax.reload(null, false);
									table2.ajax.reload(null, false);
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
		$('#kt_datatable2').on('click', '.done_record', function () {
				var order_id = $(this).data('order_id');
				var trans_id = $(this).data('trans_id');
				
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
							url: HOST_URL + 'transaksi_admin/done',
							data: {
								order_id: order_id,
								trans_id: trans_id
							},
							success: function (data) {
								if (data.status) {
									Swal.fire({
										icon: 'success',
										title: 'Berhasil!',
										text: 'Data selesai diproses...',
										showConfirmButton: true
									});
									table.ajax.reload(null, false);
									table2.ajax.reload(null, false);

									if (data.status_transaksi == 'done') {
										$('#label_status_transaksi').attr('class', 'label label-lg font-weight-bold label-light-success label-inline text-success');
									}
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
		$('#kt_datatable2').on('click', '.cancel_record', function () {
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
							url: HOST_URL + 'transaksi_admin/cancel',
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
									table.ajax.reload(null, false);
									table2.ajax.reload(null, false);
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

		$("#save").click(function () {
		
			var formData = new FormData($('#transaksi_admin')[0]);
				$.ajax({
					url: HOST_URL + "transaksi_admin/save_kurir",
					type: "POST",
					data: formData,
					contentType: false,
					processData: false,
					dataType: "JSON",
					success: function(data) {
						
							if (data.status) {
								$('#modal-form2').modal('hide');
								// $('#admin_user')[0].reset();
								Swal.fire({
									icon: 'success',
									title: 'Berhasil!',
									text: 'Data Berhasil disimpan...',
									showConfirmButton: true
								});
								table2.ajax.reload(null, false);
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

		$("#save2").click(function () {
		
			var formData = new FormData($('#transaksi_admin_stock')[0]);
				$.ajax({
					url: HOST_URL + "transaksi_admin/save_stock",
					type: "POST",
					data: formData,
					contentType: false,
					processData: false,
					dataType: "JSON",
					success: function(data) {
						
							if (data.status) {
								$('#modal-form2').modal('hide');
								// $('#admin_user')[0].reset();
								Swal.fire({
									icon: 'success',
									title: 'Berhasil!',
									text: 'Data Berhasil disimpan...',
									showConfirmButton: true
								});
								table2.ajax.reload(null, false);
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


