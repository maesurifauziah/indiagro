"use strict";

var currentscrollHeight = 0;
var count = 0;
var Cart = function() {

	
	var initListOrder = function() {
		get_list_order()
	};
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
	function get_list_order() {
		$('.list-order').empty();
		$.ajax({
			url: HOST_URL + 'order/get_list_order',
			type: "GET",
			dataType: "JSON",
			success: function(data) {
				$('.list-order').empty();
				$('.count-order').text('Pilih Semua ('+data.length+')');
				var photo = '';
                    for (var i = 0; i < data.length; i++) {
						// if (data[i].photo == '' || data[i].photo == null) {
						// }
						photo = data[i].photo == '' || data[i].photo == null ? '<img src="assets/media/users/blank2.png" title="" alt="">' : '<img src="'+HOST_URL+'upload/master_barang/'+data[i].photo+'" title="" alt="">';
                        $('.list-order').append(
                            '<div class="d-flex align-items-center justify-content-between p-2">'+
								'<div class="d-flex align-items-left">'+
									'<label class="checkbox pr-4">'+
										'<input type="checkbox" name="Checkboxes1">'+
										'<span></span>'+
									'</label>'+
									'<a href="#" class="symbol symbol-70 flex-shrink-0 pr-6">'+
										photo+
									'</a>'+
									'<div class="d-flex flex-column mr-2 pr-15">'+
										'<a href="#" class="font-weight-bold text-dark-75 font-size-lg text-hover-primary pr-20">'+data[i].nama_jenis_barang+'</a>'+
										'<span class="text-muted">'+formatRupiah(data[i].qty_order)+' Kg</span>'+
										'<div class="d-flex align-items-center mt-2">'+
											'<span class="font-weight-bold mr-1 text-dark-75 font-size-lg">'+formatRupiah(data[i].harga_total, 'Rp. ')+'</span>'+
										'</div>'+
									'</div>'+
								'</div>'+
								'<div class="d-flex align-items-right pr-5">'+
									'<a href="#" class="btn btn-icon btn-light-danger btn-hover-danger btn-sm">'+
										'<span class="svg-icon svg-icon-md svg-icon-danger">'+
											'<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">'+
												'<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">'+
													'<rect x="0" y="0" width="24" height="24"></rect>'+
													'<path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"></path>'+
													'<path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"></path>'+
												'</g>'+
											'</svg>'+
										'</span>'+
									'</a>'+
                        		'</div>'+
                        '</div>'+
                        '<div class="separator separator-solid"></div>'
                        );
                      
                    }
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Error show data');
			}
		});
	}




	return {

		//main function to initiate the module
		init: function() {
			initListOrder();
		},

	};

	

}();

jQuery(document).ready(function() {
	Cart.init();
	
});




