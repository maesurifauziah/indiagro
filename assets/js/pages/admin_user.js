"use strict";
var KTDatatablesSearchOptionsAdvancedSearch = function() {

	$.fn.dataTable.Api.register('column().title()', function() {
		return $(this.header()).text().trim();
	});

	var _avatar;

	var _initAvatar = function () {
		_avatar = new KTImageInput('kt_user_add_avatar');
	}

	var initTable1 = function() {
		// begin first table

		var output = document.getElementById('output');

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
				url: HOST_URL + 'admin_user/admin_user_list?status=' + $('#filter_status').val() + "&nama_lengkap=" + $('#filter_nama').val(),
				type: 'POST',
				data: {
					// parameters for custom backend script demo
					columnsDef: [
						'no', 
						'photo', 
						'userid', 
						'user_name', 
						'nama_lengkap', 
						'group_name', 
						'alamat', 
						'no_hp', 
						'aktif',
						'action',
					],
				},
			},
			columns: [
				{data: 'no'},
				{data: 'photo'},
				{data: 'userid'},
				{data: 'user_name'},
				{data: 'nama_lengkap', responsivePriority: -1},
				{data: 'group_name'},
				{data: 'alamat'},
				{data: 'propinsi_desc'},
				{data: 'kabupaten_kota'},
				{data: 'kecamatan'},
				{data: 'kodepos'},
				{data: 'pasar_desc'},
				{data: 'no_hp'},
				{data: 'aktif'},
				{data: 'action', responsivePriority: -1},
			],

			columnDefs: [
				{
					targets: 0,
					orderable: false,
				},
				{
					targets: 1,
					orderable: false,
				},
				{
					targets: 9,
					orderable: false,
				},
				{
					targets: 13,
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
			table.ajax.url( HOST_URL + "admin_user/admin_user_list?status=" + $('#filter_status').val() + "&nama_lengkap=" + $('#filter_nama').val()).load();
		});

		$('#add').on('click', function() {
			$('#admin_user')[0].reset();
			$('form#admin_user input').removeClass('is-invalid');
			$('form#admin_user select').removeClass('is-invalid');
			$('.invalid-feedback').empty();
			$('#modal-form').modal('show');

			$('#type').val('add');

			$('#save').show();
			$('#nama_lengkap').attr('readonly', false);
			$('#user_name').attr('readonly', false);
			$('#password').attr('readonly', false);
			$('#user_group').attr('readonly', false);
			$('#no_hp').attr('readonly', false);
			$('#alamat').attr('readonly', false);

			$('.pasar').hide();
			$('.password').show();
			
			output.style="background-image: url('assets/media/users/blank.png'); border: 3px solid #ffffff; -webkit-box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, 0.075); box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, 0.075); "

		});

		$('#kt_datatable').on('click', '.edit_record', function () {
			$('#admin_user')[0].reset();
			$('form#admin_user input').removeClass('is-invalid');
			$('form#admin_user select').removeClass('is-invalid');
			$('.invalid-feedback').empty();
			$('#modal-form').modal('show');
		
			$('#type').val('edit');
			$('#userid').val($(this).data('userid'));
			$('#uid').val($(this).data('uid'));
			$('#nama_lengkap').val($(this).data('nama_lengkap'));
			$('#password').val('');
			$('#user_name').val($(this).data('user_name'));
			$('#user_group').val($(this).data('user_group'));
			$('#propid').val($(this).data('propid'));
			$('#kabid').val($(this).data('kabid'));
			$('#kecid').val($(this).data('kecid'));
			$('#kodepos').val($(this).data('kodepos'));
			$('#pasar_id').val($(this).data('pasar_id'));
			$('#no_hp').val($(this).data('no_hp'));
			$('#alamat').val($(this).data('alamat'));
			$('#photo_nama').val($(this).data('photo'));

			if ($(this).data('photo') == '') {
				output.style="background-image: url('assets/media/users/blank.png'); border: 3px solid #ffffff; -webkit-box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, 0.075); box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, 0.075); "
			} else {
				output.style="background-image: url('upload/admin_user/"+$(this).data('photo')+"'); border: 3px solid #ffffff; -webkit-box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, 0.075); box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, 0.075); "
			}

			$('.pasar').hide();
			if ($('#user_group').val() == '0003') {
				$('.pasar').show();
				
			}
		
			$('#save').show();
			$('#nama_lengkap').attr('readonly', false);
			$('#user_name').attr('readonly', false);
			$('#password').attr('readonly', false);
			$('#user_group').attr('readonly', false);
			$('#no_hp').attr('readonly', false);
			$('#alamat').attr('readonly', false);

			
			$('.password').hide();

			// alert($(this).data('group_name'));
		});

		$('#modal-form').on('shown.bs.modal', function () {
			$('#user_group').select2();
			$('#propid').select2();
			$('#kabid').select2();
			$('#kecid').select2();
			$('#pasar_id').select2();
		});

		$('#propid').on('change', function() {
			$.ajax({
				url: HOST_URL + 'wilayah_kabupaten/get_kab_kot_by_propid/'+$('#propid').val(),
				type: "POST",
				dataType: "JSON",
				success: function(data) {
					$('#kabid').empty();
					$('#kabid').append('<option value="">-- Pilih Kabupaten/Kota --</option>');
					for (var i = 0; i < data.length; i++) {
						$('#kabid').append('<option id=' + data[i].kabid + ' value=' + data[i].kabid + '>' + data[i].kabupaten_kota + '</option>');
					}
					// $('#kabid').change();
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert('Error filter data');
				}
			});
		});

		$('#kabid').on('change', function() {
			$.ajax({
				url: HOST_URL + 'wilayah_kecamatan/get_kecamatan_by_kabid/'+$('#kabid').val(),
				type: "POST",
				dataType: "JSON",
				success: function(data) {
					$('#kecid').empty();
					$('#kecid').append('<option value="">-- Pilih Kecamatan --</option>');
					for (var i = 0; i < data.length; i++) {
						$('#kecid').append('<option id=' + data[i].kecid + ' value=' + data[i].kecid + '>' + data[i].kecamatan + '</option>');
					}
					// $('#kecid').change();
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert('Error filter data');
				}
			});
		});

		$('#kecid').on('change', function() {
			$.ajax({
				url: HOST_URL + 'master_pasar/get_pasar_by_kecid/'+$('#kecid').val(),
				type: "POST",
				dataType: "JSON",
				success: function(data) {
					$('#pasar_id').empty();
					$('#pasar_id').append('<option value="">-- Pilih Pasar --</option>');
					for (var i = 0; i < data.length; i++) {
						$('#pasar_id').append('<option id=' + data[i].pasar_id + ' value=' + data[i].pasar_id + '>' + data[i].pasar_desc + '</option>');
					}
					// $('#pasar_id').change();
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert('Error filter data');
				}
			});
		});
		
		$('#user_group').on('change', function() {
			$('.pasar').hide();
			if ($('#user_group').val() == '0003') {
				$('.pasar').show();
				$('#pasar_id').select2();
			}
		});

		// $('#kt_datatable').on('click', '.non_active_record', function () {
			$('#kt_datatable').on('click', '.non_active_record', function () {
				var userid = $(this).data('userid');
				var nama_lengkap = $(this).data('nama_lengkap');
				var aktif = $(this).data('aktif');
				var label = '';
				if (aktif == 'y') {
					label = 'Non Aktif';
				} else {
					label = 'Aktif';
				}
				Swal.fire({
					icon: 'warning',
					title: 'Are You Sure?',
					text: label + ' data ' + nama_lengkap,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: "Yes",
					cancelButtonText: "No",
					showCancelButton: true,
				}).then((result) => {
					if (result.value) {
						$.ajax({
							type: 'POST',
							url: HOST_URL + 'admin_user/aktif/' + userid,
							data: {
								aktif: aktif
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

			// openFile = function(event) {
			// 	var input = event.target;

			// 	var reader = new FileReader();
			// 	reader.onload = function(){
			// 	var dataURL = reader.result;
			// 	var output = document.getElementById('output');
			// 	output.src = dataURL;
			// 	};
			// 	reader.readAsDataURL(input.files[0]);
			// };

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
			
				var formData = new FormData($('#admin_user')[0]);
					$.ajax({
						url: HOST_URL + "admin_user/save",
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

		// $("#save").click(function () {
		
		// 	// let file = $("#photo")[0].files[0];
        //     // if (file === undefined) {
        //     //     Swal.fire({
        //     //         icon: 'warning',
        //     //         title: 'Gagal!',
        //     //         text: 'Silahkan pilih file zip!!!',
        //     //         showConfirmButton: true
        //     //     });
        //     //     return;
        //     // }
        

        //     var formData = new FormData($('#admin_user')[0]);

		// 	$("#save").attr('disabled', 'disabled').text('Wait...');
		
		// 	$.ajax({
		// 		url: HOST_URL + "admin_user/save",
		// 		data: formData,
		// 		method: 'POST',
		// 		success: function (data) {
		// 			$("#save").removeAttr('disabled').text('Simpan');
		// 			if (data.status) {
		// 				$('#modal-form').modal('hide');
		// 				// $('#admin_user')[0].reset();
		// 				Swal.fire({
		// 					icon: 'success',
		// 					title: 'Berhasil!',
		// 					text: 'Data Berhasil disimpan...',
		// 					showConfirmButton: true
		// 				});
		// 				table.ajax.reload(null, false);
		// 			} else {
		// 				if (data.invalid) {
		// 					$.each(data.invalid, function (key, val) {
		// 						$('[name="' + key + '"]').addClass('is-invalid');
		// 						$('#' + key + '-error').html(val);
		// 						if (val == '') {
		// 							$('[name="' + key + '"]').removeClass('is-invalid');
		// 							$('#' + key + '-error').html('');
		// 						}
		// 					});
		// 				}
		// 			}
		// 		},
		// 		error: function (jqXHR, textStatus, errorThrown) {
		// 			Swal.close();
		// 			Swal.fire({
		// 				icon: 'warning',
		// 				title: textStatus,
		// 				text: errorThrown,
		// 				showConfirmButton: true
		// 			});
		// 		}
		// 	});
		// });
		
		// $('form#admin_user').on('submit', function (e) {
		// 	e.preventDefault();
		// 	e.stopImmediatePropagation();
		
		// 	$("#save").attr('disabled', 'disabled').text('Wait...');
		
		// 	$.ajax({
		// 		url: $(this).attr('action'),
		// 		data: $(this).serialize(),
		// 		method: 'POST',
		// 		success: function (data) {
		// 			$("#save").removeAttr('disabled').text('Simpan');
		// 			if (data.status) {
		// 				$('#modal-form').modal('hide');
		// 				$('#admin_user')[0].reset();
		// 				Swal.fire({
		// 					icon: 'success',
		// 					title: 'Berhasil!',
		// 					text: 'Data Berhasil disimpan...',
		// 					showConfirmButton: true
		// 				});
		// 				table.ajax.reload(null, false);
		// 			} else {
		// 				if (data.invalid) {
		// 					$.each(data.invalid, function (key, val) {
		// 						$('[name="' + key + '"]').addClass('is-invalid');
		// 						$('#' + key + '-error').html(val);
		// 						if (val == '') {
		// 							$('[name="' + key + '"]').removeClass('is-invalid');
		// 							$('#' + key + '-error').html('');
		// 						}
		// 					});
		// 				}
		// 			}
		// 		},
		// 		error: function (jqXHR, textStatus, errorThrown) {
		// 			Swal.close();
		// 			Swal.fire({
		// 				icon: 'warning',
		// 				title: textStatus,
		// 				text: errorThrown,
		// 				showConfirmButton: true
		// 			});
		// 		}
		// 	});
		// });
		
		
	};

	return {

		//main function to initiate the module
		init: function() {
			initTable1();
			_initAvatar();
		},

	};

}();

jQuery(document).ready(function() {
	KTDatatablesSearchOptionsAdvancedSearch.init();
	
});


