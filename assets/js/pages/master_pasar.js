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
				url: HOST_URL + 'master_pasar/master_pasar_list',
				type: 'POST',
				data: {
					// parameters for custom backend script demo
// 					propinsi_desc
// kabupaten_kota
					columnsDef: [
						'no', 'pasar_id', 'pasar_desc', 'propinsi_desc', 'kabupaten_kota' ,'kecamatan' ,'status', 'action',],
				},
			},
			columns: [
				{data: 'no'},
				{data: 'pasar_id'},
				{data: 'pasar_desc'},
				{data: 'propinsi_desc'},
				{data: 'kabupaten_kota'},
				{data: 'kecamatan'},
				{data: 'status'},
				{data: 'action', responsivePriority: -1},
			],

			// initComplete: function() {
			// 	this.api().columns().every(function() {
			// 		var column = this;

			// 		switch (column.title()) {
			// 			case 'status':
			// 				var status = {
			// 					'y': {'title': 'Aktif', 'class': 'label-light-primary'},
			// 					'n': {'title': 'Non Aktif', 'class': ' label-light-danger'},
			// 				};
			// 				column.data().unique().sort().each(function(d, j) {
			// 					$('.datatable-input[data-col-index="3"]').append('<option value="' + d + '">' + status[d].title + '</option>');
			// 				});
			// 				break;
			// 		}
			// 	});
			// },

			columnDefs: [
				{
					targets: 0,
					orderable: false,
				},
				{
					targets: 7,
					orderable: false,
				},
				{
					targets: 6,
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
			table.ajax.url( HOST_URL + "master_pasar/master_pasar_list?status=" + $('#filter_status').val()).load();
		});

		$('#add').on('click', function() {
			$('#master_pasar')[0].reset();
			$('form#master_pasar input').removeClass('is-invalid');
			$('form#master_pasar select').removeClass('is-invalid');
			$('.invalid-feedback').empty();
			$('#modal-form').modal('show');

			$('#type').val('add');

			$('#save').show();
			$('#pasar_desc').attr('readonly', false);
		});

		$('#kt_datatable').on('click', '.edit_record', function () {
			$('#master_pasar')[0].reset();
			$('form#master_pasar input').removeClass('is-invalid');
			$('form#master_pasar select').removeClass('is-invalid');
			$('.invalid-feedback').empty();
			$('#modal-form').modal('show');
		
			$('#type').val('edit');
			$('#pasar_id').val($(this).data('pasar_id'));
			$('#pasar_desc').val($(this).data('pasar_desc'));
			$('#propid').val($(this).data('propid'));
			$('#kabid').val($(this).data('kabid'));
			$('#kecid').val($(this).data('kecid'));
		
			$('#save').show();
			$('#pasar_desc').attr('readonly', false);
		});

		$('#modal-form').on('shown.bs.modal', function () {
			$('#propid').select2();
			$('#kabid').select2();
			$('#kecid').select2();
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
					$('#kecid').append('<option value="">-- Pilih Kabupaten --</option>');
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

		// $('#kt_datatable').on('click', '.non_active_record', function () {
			$('#kt_datatable').on('click', '.non_active_record', function () {
				var pasar_id = $(this).data('pasar_id');
				var pasar_desc = $(this).data('pasar_desc');
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
					text: label + ' data ' + pasar_desc,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: "Yes",
					cancelButtonText: "No",
					showCancelButton: true,
				}).then((result) => {
					if (result.value) {
						$.ajax({
							type: 'POST',
							url: HOST_URL + 'master_pasar/status/' + pasar_id,
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


		$('form#master_pasar').on('submit', function (e) {
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
						$('#master_pasar')[0].reset();
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


