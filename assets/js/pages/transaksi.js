"use strict";

var currentscrollHeight = 0;
var count = 0;
var KTDatatablesSearchOptionsAdvancedSearch = function() {

// 	filter_date_start
// filter_date_end
	var initList = function() {
		get_list_order_checkout();

		$( "div#container_product ul li" ).find( "a#checkout_nav" ).click(function(e){
			e.preventDefault();
			get_list_order_checkout();
		});
		$( "div#container_product ul li" ).find( "a#dikemas_nav" ).click(function(e){
			e.preventDefault();
			get_list_order_packing();
		});
		$( "div#container_product ul li" ).find( "a#dikirim_nav" ).click(function(e){
			e.preventDefault();
			get_list_order_pengiriman();
		});
		$( "div#container_product ul li" ).find( "a#lunas_nav" ).click(function(e){
			e.preventDefault();
			get_list_order_lunas();
		});
		$( "div#container_product ul li" ).find( "a#selesai_nav" ).click(function(e){
			e.preventDefault();
			get_list_order_done();
		});
		$( "div#container_product ul li" ).find( "a#batal_nav" ).click(function(e){
			e.preventDefault();
			get_list_order_cancel();
		});
	};
	function get_list_order_checkout() {
		$('.order-checkout').empty();
		$.ajax({
			url: HOST_URL + 'transaksi/get_list_order_checkout',
			type: "GET",
			dataType: "JSON",
			success: function(data) {
				KTApp.block('.container_product', {
					overlayColor: '#000000',
					state: 'primary',
					message: 'Processing...'
				});
	
				setTimeout(function() {
					KTApp.unblock('.container_product');
				}, 500);

				$('.order-checkout').html(data.html);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Error show data');
			}
		});
	}
	function get_list_order_packing() {
		$('.order-dikemas').empty();
		$.ajax({
			url: HOST_URL + 'transaksi/get_list_order_packing',
			type: "GET",
			dataType: "JSON",
			success: function(data) {
				KTApp.block('.container_product', {
					overlayColor: '#000000',
					state: 'primary',
					message: 'Processing...'
				});
	
				setTimeout(function() {
					KTApp.unblock('.container_product');
				}, 500);

				$('.order-dikemas').html(data.html);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Error show data');
			}
		});
	}
	function get_list_order_pengiriman() {
		$('.order-dikirim').empty();
		$.ajax({
			url: HOST_URL + 'transaksi/get_list_order_pengiriman',
			type: "GET",
			dataType: "JSON",
			success: function(data) {
				KTApp.block('.container_product', {
					overlayColor: '#000000',
					state: 'primary',
					message: 'Processing...'
				});
	
				setTimeout(function() {
					KTApp.unblock('.container_product');
				}, 500);

				$('.order-dikirim').html(data.html);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Error show data');
			}
		});
	}
	function get_list_order_lunas() {
		$('.order-lunas').empty();
		$.ajax({
			url: HOST_URL + 'transaksi/get_list_order_lunas',
			type: "GET",
			dataType: "JSON",
			success: function(data) {
				KTApp.block('.container_product', {
					overlayColor: '#000000',
					state: 'primary',
					message: 'Processing...'
				});
	
				setTimeout(function() {
					KTApp.unblock('.container_product');
				}, 500);

				$('.order-lunas').html(data.html);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Error show data');
			}
		});
	}
	function get_list_order_done() {
		$('.order-selesai').empty();
		$.ajax({
			url: HOST_URL + 'transaksi/get_list_order_done',
			type: "GET",
			dataType: "JSON",
			success: function(data) {
				KTApp.block('.container_product', {
					overlayColor: '#000000',
					state: 'primary',
					message: 'Processing...'
				});
	
				setTimeout(function() {
					KTApp.unblock('.container_product');
				}, 500);

				$('.order-selesai').html(data.html);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Error show data');
			}
		});
	}
	function get_list_order_cancel() {
		$('.order-batal').empty();
		$.ajax({
			url: HOST_URL + 'transaksi/get_list_order_cancel',
			type: "GET",
			dataType: "JSON",
			success: function(data) {
				KTApp.block('.container_product', {
					overlayColor: '#000000',
					state: 'primary',
					message: 'Processing...'
				});
	
				setTimeout(function() {
					KTApp.unblock('.container_product');
				}, 500);

				$('.order-batal').html(data.html);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Error show data');
			}
		});
	}
	
	return {

		//main function to initiate the module
		init: function() {
			initList();
			
		},

	};

	

}();

jQuery(document).ready(function() {
	KTDatatablesSearchOptionsAdvancedSearch.init();
	
});




