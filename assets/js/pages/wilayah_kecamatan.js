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
				url: HOST_URL + 'wilayah_kecamatan/wilayah_kecamatan_list?status=' + $('#filter_status').val() + "&kecamatan=" + $('#filter_kecamatan').val(),
				type: 'POST',
				data: {
					// parameters for custom backend script demo
					columnsDef: [
						'no', 'kecid', 'kecamatan', 'kabupaten_kota', 'kodepos', 'status', 'action',],
				},
			},
			columns: [
				{data: 'no'},
				{data: 'kecid'},
				{data: 'kecamatan'},
				{data: 'kabupaten_kota'},
				{data: 'kodepos'},
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
			table.ajax.url( HOST_URL + "wilayah_kecamatan/wilayah_kecamatan_list?status=" + $('#filter_status').val() + "&kecamatan=" + $('#filter_kecamatan').val()).load();
		});

		$('#add').on('click', function() {
			$('#wilayah_kecamatan')[0].reset();
			$('form#wilayah_kecamatan input').removeClass('is-invalid');
			$('form#wilayah_kecamatan select').removeClass('is-invalid');
			$('.invalid-feedback').empty();
			$('#modal-form').modal('show');

			$('#type').val('add');

			$('#save').show();
			$('#kabid').attr('disabled', false);
			$('#kecamatan').attr('readonly', false);
			$('#kodepos').attr('readonly', false);
		});

		$('#kt_datatable').on('click', '.edit_record', function () {
			$('#wilayah_kecamatan')[0].reset();
			$('form#wilayah_kecamatan input').removeClass('is-invalid');
			$('form#wilayah_kecamatan select').removeClass('is-invalid');
			$('.invalid-feedback').empty();
			$('#modal-form').modal('show');
		
			$('#type').val('edit');
			$('#kecid').val($(this).data('kecid'));
			$('#kabid').val($(this).data('kabid'));
			$('#kecamatan').val($(this).data('kecamatan'));
			$('#kodepos').val($(this).data('kodepos'));
		
			$('#save').show();
			$('#kabid').attr('disabled', false);
			$('#kecamatan').attr('readonly', false);
			$('#kodepos').attr('readonly', false);
		});

		$('#modal-form').on('shown.bs.modal', function () {
			$('#kabid').select2();

		});

		// $('#kt_datatable').on('click', '.non_active_record', function () {
			$('#kt_datatable').on('click', '.non_active_record', function () {
				var kecid = $(this).data('kecid');
				var kecamatan = $(this).data('kecamatan');
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
					text: label + ' data ' + kecamatan,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: "Yes",
					cancelButtonText: "No",
					showCancelButton: true,
				}).then((result) => {
					if (result.value) {
						$.ajax({
							type: 'POST',
							url: HOST_URL + 'wilayah_kecamatan/status/' + kecid,
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


		$('form#wilayah_kecamatan').on('submit', function (e) {
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
						$('#wilayah_kecamatan')[0].reset();
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


