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
				url: HOST_URL + 'admin_group_user/admin_group_user_list',
				type: 'POST',
				data: {
					// parameters for custom backend script demo
					columnsDef: [
						'no', 'user_group', 'group_name', 'aktif', 'action',],
				},
			},
			columns: [
				{data: 'no'},
				{data: 'user_group'},
				{data: 'group_name'},
				{data: 'aktif'},
				{data: 'action', responsivePriority: -1},
			],

			// initComplete: function() {
			// 	this.api().columns().every(function() {
			// 		var column = this;

			// 		switch (column.title()) {
			// 			case 'aktif':
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
					targets: 4,
					orderable: false,
				},
				{
					targets: 3,
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
			table.ajax.url( HOST_URL + "admin_group_user/admin_group_user_list?status=" + $('#filter_status').val()).load();
		});

		$('#add').on('click', function() {
			$('#admin_group_user')[0].reset();
			$('form#admin_group_user input').removeClass('is-invalid');
			$('form#admin_group_user select').removeClass('is-invalid');
			$('.invalid-feedback').empty();
			$('#modal-form').modal('show');

			$('#type').val('add');

			$('#save').show();
			$('#group_name').attr('readonly', false);
		});

		$('#kt_datatable').on('click', '.edit_record', function () {
			$('#admin_group_user')[0].reset();
			$('form#admin_group_user input').removeClass('is-invalid');
			$('form#admin_group_user select').removeClass('is-invalid');
			$('.invalid-feedback').empty();
			$('#modal-form').modal('show');
		
			$('#type').val('edit');
			$('#user_group').val($(this).data('user_group'));
			$('#group_name').val($(this).data('group_name'));
		
			$('#save').show();
			$('#group_name').attr('readonly', false);
			// alert($(this).data('group_name'));
		});

		// $('#kt_datatable').on('click', '.non_active_record', function () {
			$('#kt_datatable').on('click', '.non_active_record', function () {
				var user_group = $(this).data('user_group');
				var group_name = $(this).data('group_name');
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
					text: label + ' data ' + group_name,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: "Yes",
					cancelButtonText: "No",
					showCancelButton: true,
				}).then((result) => {
					if (result.value) {
						$.ajax({
							type: 'POST',
							url: HOST_URL + 'admin_group_user/aktif/' + user_group,
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


		$('form#admin_group_user').on('submit', function (e) {
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
						$('#admin_group_user')[0].reset();
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


