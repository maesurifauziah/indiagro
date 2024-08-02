"use strict";
var KTDatatablesSearchOptionsAdvancedSearch = function() {

	$.fn.dataTable.Api.register('column().title()', function() {
		return $(this.header()).text().trim();
	});

	var initTable1 = function() {

		var output = document.getElementById('output');


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
				url: HOST_URL + 'master_jenis_barang/master_jenis_barang_list?status=' + $('#filter_status').val() + "&kategori=" + $('#filter_kategori').val() + "&barang=" + $('#filter_barang').val(),
				type: 'POST',
				data: {
					// parameters for custom backend script demo
					columnsDef: [
						'no', 'photo', 'kategori_desc', 'nama_barang', 'nama_jenis_barang', 'status', 'harga', 'action','kategori_desc'],
				},
			},
			columns: [
				{data: 'no'},
				{data: 'photo'},
				{data: 'kategori_desc'},
				{data: 'nama_barang'},
				{data: 'nama_jenis_barang'},
				{data: 'harga'},
				{data: 'status'},
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
					targets: 5,
					render: function(data, type, full, meta) {
						var status = {
							'y': {'title': 'Aktif', 'class': ' label-light-primary'},
							'n': {'title': 'Non Aktif', 'class': ' label-light-danger'},
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
			table.ajax.url( HOST_URL + "master_jenis_barang/master_jenis_barang_list?status=" + $('#filter_status').val() + "&kategori=" + $('#filter_kategori').val() + "&barang=" + $('#filter_barang').val()).load();
		});

		$('#add').on('click', function() {
			$('#master_jenis_barang')[0].reset();
			$('form#master_jenis_barang input').removeClass('is-invalid');
			$('form#master_jenis_barang select').removeClass('is-invalid');
			$('.invalid-feedback').empty();
			$('#modal-form').modal('show');

			$('#type').val('add');

			$('#save').show();
			$('#nama_jenis_barang').attr('readonly', false);
			$('#kategori_id').attr('readonly', false);
			$('#harga').attr('readonly', false);

			output.style="background-image: url('assets/media/users/blank.png'); border: 3px solid #ffffff; -webkit-box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, 0.075); box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, 0.075); "

		});

		$('#kt_datatable').on('click', '.edit_record', function () {
			$('#master_jenis_barang')[0].reset();
			$('form#master_jenis_barang input').removeClass('is-invalid');
			$('form#master_jenis_barang select').removeClass('is-invalid');
			$('.invalid-feedback').empty();
			$('#modal-form').modal('show');
		
			$('#type').val('edit');
			$('#kode_jenis_barang').val($(this).data('kode_jenis_barang'));
			$('#kode_barang').val($(this).data('kode_barang'));
			$('#nama_jenis_barang').val($(this).data('nama_jenis_barang'));
			$('#kategori_id').val($(this).data('kategori_id'));
			$('#harga').val($(this).data('harga-format'));
			$('#photo_nama').val($(this).data('photo'));


			if ($(this).data('photo') == '') {
				output.style="background-image: url('assets/media/users/blank.png'); border: 3px solid #ffffff; -webkit-box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, 0.075); box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, 0.075); "
			} else {
				output.style="background-image: url('upload/admin_user/"+$(this).data('photo')+"'); border: 3px solid #ffffff; -webkit-box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, 0.075); box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, 0.075); "
			}
		
			$('#save').show();
			$('#kategori_id').attr('readonly', false);
			$('#urutan').attr('readonly', false);
			// alert($(this).data('urutan'));
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
							url: HOST_URL + 'master_jenis_barang/status/' + kode_jenis_barang,
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

		$('#photo').on('change', function (e) {	
			var input = e.target;

			var reader = new FileReader();
			reader.onload = function(){
			var dataURL = reader.result;
			
			output.style="background-image: url('"+dataURL+"'); border: 3px solid #ffffff; -webkit-box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, 0.075); box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, 0.075); "

			};
			reader.readAsDataURL(input.files[0]);
		});

		$("#save").click(function () {
			let file = $("#photo")[0].files[0];
			if (file === undefined) {
				$("#photo").val('');
			} else {
				if (file.size > 300000) {
					Swal.fire({
						icon: 'warning',
						title: 'Gagal!',
						text: 'Photo tidak boleh lebih dari 300Kb!!!',
						showConfirmButton: true
					});
					return;
				}
			}			
		
			var formData = new FormData($('#master_jenis_barang')[0]);
				$.ajax({
					url: HOST_URL + "master_jenis_barang/save",
					type: "POST",
					data: formData,
					contentType: false,
					processData: false,
					dataType: "JSON",
					success: function(data) {
						$("#save").removeAttr('disabled').text('Simpan');
							if (data.status) {
								$('#modal-form').modal('hide');
								// $('#master_jenis_barang')[0].reset();
								Swal.fire({
									icon: 'success',
									title: 'Berhasil!',
									text: 'Data Berhasil disimpan...',
									showConfirmButton: true
								});
								table.ajax.reload(null, false);
							} else {
								if (data.status == false) {
									Swal.fire({
												icon: 'warning',
												title: 'Gagal!',
												text: msg,
												showConfirmButton: true
									});
								}
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


		$('form#master_jenis_barang').on('submit', function (e) {
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
						$('#master_jenis_barang')[0].reset();
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

		$('#kategori_id').on('change', function() {
			$.ajax({
				url: HOST_URL + 'master_barang/get_barang_by_kategori/'+$('#kategori_id').val(),
				type: "POST",
				dataType: "JSON",
				success: function(data) {
					$('#kode_barang').empty();
					$('#kode_barang').append('<option value="">-- Pilih Jenis Barang --</option>');
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


