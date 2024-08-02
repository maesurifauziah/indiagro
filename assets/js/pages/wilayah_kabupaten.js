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
				url: HOST_URL + 'wilayah_kabupaten/wilayah_kabupaten_list?status=' + $('#filter_status').val() + "&kabupaten_kota=" + $('#filter_kabupaten_kota').val(),
				type: 'POST',
				data: {
					// parameters for custom backend script demo
					columnsDef: [
						'no', 'kabid', 'kabupaten_kota', 'propinsi_desc', 'status', 'action',],
				},
			},
			columns: [
				{data: 'no'},
				{data: 'kabid'},
				{data: 'kabupaten_kota'},
				{data: 'propinsi_desc'},
				{data: 'status'},
				{data: 'action', responsivePriority: -1},
			],

			columnDefs: [
				{
					targets: 0,
					orderable: false,
				},
				{
					targets: 5,
					orderable: false,
				},
				{
					targets: 4,
					render: function(data, type, full, meta) {
						var status = {
							1: {'title': 'Aktif', 'class': ' label-light-primary'},
							0: {'title': 'Non Aktif', 'class': ' label-light-danger'},
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
			table.ajax.url( HOST_URL + "wilayah_kabupaten/wilayah_kabupaten_list?status=" + $('#filter_status').val() + "&kabupaten_kota=" + $('#filter_kabupaten_kota').val()).load();
		});

		$('#add').on('click', function() {
			$('#wilayah_kabupaten')[0].reset();
			$('form#wilayah_kabupaten input').removeClass('is-invalid');
			$('form#wilayah_kabupaten select').removeClass('is-invalid');
			$('.invalid-feedback').empty();
			$('#modal-form').modal('show');

			$('#type').val('add');

			$('#save').show();
			$('#kabupaten_kota').attr('readonly', false);
		});

		$('#kt_datatable').on('click', '.edit_record', function () {
			$('#wilayah_kabupaten')[0].reset();
			$('form#wilayah_kabupaten input').removeClass('is-invalid');
			$('form#wilayah_kabupaten select').removeClass('is-invalid');
			$('.invalid-feedback').empty();
			$('#modal-form').modal('show');
		
			$('#type').val('edit');
			$('#kabid').val($(this).data('kabid'));
			$('#tipe_kab_kota').val($(this).data('tipe_kab_kota') == '1' ? 'kabupaten' : 'kota');
			$('#kabupaten_kota').val($(this).data('kabupaten_kota'));
			$('#propid').val($(this).data('propid'));
		
			$('#save').show();
			$('#kabupaten_kota').attr('readonly', false);
			// alert($(this).data('kabupaten_kota'));
		});

		$('#modal-form').on('shown.bs.modal', function () {
			$('#propid').select2();
			$('#tipe_kab_kota').select2();
		});

		// $('#kt_datatable').on('click', '.non_active_record', function () {
			$('#kt_datatable').on('click', '.non_active_record', function () {
				var kabid = $(this).data('kabid');
				var kabupaten_kota = $(this).data('kabupaten_kota');
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
					text: label + ' data ' + kabupaten_kota,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: "Yes",
					cancelButtonText: "No",
					showCancelButton: true,
				}).then((result) => {
					if (result.value) {
						$.ajax({
							type: 'POST',
							url: HOST_URL + 'wilayah_kabupaten/status/' + kabid,
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


		$('form#wilayah_kabupaten').on('submit', function (e) {
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
						$('#wilayah_kabupaten')[0].reset();
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


