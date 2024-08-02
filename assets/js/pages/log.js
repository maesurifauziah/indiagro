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
				url: HOST_URL + 'log/log_list?date_start=' + $('#start').val() + '&date_end=' + $('#end').val(),
				type: 'POST',
				data: {
					// parameters for custom backend script demo
					columnsDef: [
						'no', 'uid', 'controller', 'ip_address', 'desc', 'db_error', 'timestamp'],
				},
			},
			columns: [
				{data: 'no'},
				{data: 'uid'},
				{data: 'controller'},
				{data: 'ip_address'},
				{data: 'desc'},
				{data: 'db_error'},
				// {data: 'timestamp'},
				{data: 'timestamp', responsivePriority: -1},
			],

			columnDefs: [
				{
					targets: 0,
					orderable: false,
				},
			],
		});

		$('#kt_search').on('click', function(e) {
			e.preventDefault();
			table.ajax.url( HOST_URL + "log/log_list?date_start=" + $('#start').val() + "&date_end=" + $('#end').val()).load();
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


