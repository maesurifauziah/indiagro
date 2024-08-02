"use strict";
var KTDatatablesSearchOptionsAdvancedSearch = function() {

	$.fn.dataTable.Api.register('column().title()', function() {
		return $(this.header()).text().trim();
	});

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
				url: HOST_URL + 'stock_barang_admin/stock_barang_admin_list?status_barang=' + $('#filter_status_barang').val() + "&kategori=" + $('#filter_kategori').val() + "&barang=" + $('#filter_barang').val() + "&date_start=" + $('#filter_date_start').val() + "&date_end=" + $('#filter_date_end').val(),
				type: 'POST',
				data: {
					// parameters for custom backend script demo
					columnsDef: [
						'no', 
						'stock_id', 
						'createdDate', 
						'nama_lengkap', 
						'no_hp', 
						// 'nama_barang', 
						'nama_jenis_barang',
						'photo_bukti_barang',
						'qty',
						'harga',
						'status_barang',
						'action'
					],
				},
			},
			columns: [
				{data: 'no'},
				{data: 'stock_id'},
				{data: 'createdDate'},
				{data: 'nama_lengkap'},
				{data: 'no_hp'},
				// {data: 'nama_barang'},
				{data: 'nama_jenis_barang'},
				{data: 'photo_bukti_barang'},
				{data: 'qty'},
				{data: 'harga'},
				{data: 'status_barang'},
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
							'approve': {'title': 'Approve', 'class': ' label-light-primary'},
							'sold_out': {'title': 'Habis', 'class': ' label-light-success'},
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

		$('#kt_search').on('click', function(e) {
			e.preventDefault();
			table.ajax.url( HOST_URL + "stock_barang_admin/stock_barang_admin_list?status_barang=" + $('#filter_status_barang').val() + "&kategori=" + $('#filter_kategori').val() + "&barang=" + $('#filter_barang').val() + "&date_start=" + $('#filter_date_start').val() + "&date_end=" + $('#filter_date_end').val()).load();
		});

		$('#add').on('click', function() {
			$('#stock_barang_admin')[0].reset();
			$('form#stock_barang_admin input').removeClass('is-invalid');
			$('form#stock_barang_admin select').removeClass('is-invalid');
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
		});

		$('#kt_datatable').on('click', '.edit_record', function () {
			$('#stock_barang_admin')[0].reset();
			$('form#stock_barang_admin input').removeClass('is-invalid');
			$('form#stock_barang_admin select').removeClass('is-invalid');
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
			// alert($(this).data('urutan'));
		});

		
		$('#kt_datatable').on('click', '.approve_record', function () {
				var stock_id = $(this).data('stock_id');
				var nama_penyetok = $(this).data('nama_penyetok');
				var status = $(this).data('status');
				var label = '';
				
				Swal.fire({
					icon: 'warning',
					title: 'Are You Sure?',
					text: 'Approve data ' + stock_id + ' Penyetok ('+nama_penyetok+')',
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: "Yes",
					cancelButtonText: "No",
					showCancelButton: true,
				}).then((result) => {
					if (result.value) {
						$.ajax({
							type: 'POST',
							url: HOST_URL + 'stock_barang_admin/approve',
							data: {
								stock_id: stock_id
							},
							success: function (data) {
								if (data.status) {
									Swal.fire({
										icon: 'success',
										title: 'Berhasil!',
										text: 'Data Berhasil disimpan...',
										showConfirmButton: true
									});
									table.ajax.reload(null, false);
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

		$('#kt_datatable').on('click', '.soldout_record', function () {
				var stock_id = $(this).data('stock_id');
				var nama_penyetok = $(this).data('nama_penyetok');
				var status = $(this).data('status');
				var label = '';
				
				Swal.fire({
					icon: 'warning',
					title: 'Are You Sure?',
					text: 'Data ' + stock_id + ' Penyetok ('+nama_penyetok+') Habis?',
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: "Yes",
					cancelButtonText: "No",
					showCancelButton: true,
				}).then((result) => {
					if (result.value) {
						$.ajax({
							type: 'POST',
							url: HOST_URL + 'stock_barang_admin/sold_out',
							data: {
								stock_id: stock_id
							},
							success: function (data) {
								if (data.status) {
									Swal.fire({
										icon: 'success',
										title: 'Berhasil!',
										text: 'Data Berhasil disimpan...',
										showConfirmButton: true
									});
									table.ajax.reload(null, false);
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
		$('#kt_datatable').on('click', '.cancel_record', function () {
				var stock_id = $(this).data('stock_id');
				var nama_penyetok = $(this).data('nama_penyetok');
				var status = $(this).data('status');
				var label = '';
				
				Swal.fire({
					icon: 'warning',
					title: 'Are You Sure?',
					text: 'Batalkan Data ' + stock_id + ' Penyetok ('+nama_penyetok+')?',
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: "Yes",
					cancelButtonText: "No",
					showCancelButton: true,
				}).then((result) => {
					if (result.value) {
						$.ajax({
							type: 'POST',
							url: HOST_URL + 'stock_barang_admin/cancel',
							data: {
								stock_id: stock_id
							},
							success: function (data) {
								if (data.status) {
									Swal.fire({
										icon: 'success',
										title: 'Berhasil!',
										text: 'Data Berhasil disimpan...',
										showConfirmButton: true
									});
									table.ajax.reload(null, false);
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

		$('#modal-form').on('shown.bs.modal', function () {
			$('#kategori_id').select2();
			$('#kode_barang').select2();
			$('#kode_jenis_barang').select2();

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


		// $('#harga').on('keypress')
		$('#harga').on('keypress', function(e) {
			var ASCIICode = (e.which) ? e.which : e.keyCode
			if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
				return false;
			return true;
		});
		

		var myinput = document.getElementById('harga');

		myinput.addEventListener('keyup', function() {
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
		
		$('#kt_datatable').on('click', '.non_active_record', function () {
				var kode_jenis_barang = $(this).data('kode_jenis_barang');
				var nama_jenis_barang = $(this).data('nama_jenis_barang');
				var status = $(this).data('status');
				var label = '';
				if (status == 'y') {
					label = 'Non Aktif';
				} else {
					label = 'Aktif';
				}
				Swal.fire({
					icon: 'warning',
					title: 'Are You Sure?',
					text: label + ' data ' + nama_jenis_barang,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: "Yes",
					cancelButtonText: "No",
					showCancelButton: true,
				}).then((result) => {
					if (result.value) {
						$.ajax({
							type: 'POST',
							url: HOST_URL + 'stock_barang_admin/status/' + kode_jenis_barang,
							data: {
								status: status
							},
							success: function (data) {
								if (data.status) {
									Swal.fire({
										icon: 'success',
										title: 'Berhasil!',
										text: 'Data Berhasil disimpan...',
										showConfirmButton: true
									});
									table.ajax.reload(null, false);
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
		
			var formData = new FormData($('#stock_barang_admin')[0]);
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
								table.ajax.reload(null, false);
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


