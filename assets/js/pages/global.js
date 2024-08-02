"use strict";
var GlobalJS = function() {

	

	var initTable1 = function() {
		// var mini_photo = document.getElementById('mini-photo');
		// var session_photo = "<?=$this->session->userdata('photo')?>";
		
		// function onlyNumberKey(evt) {
		// 	var ASCIICode = (evt.which) ? evt.which : evt.keyCode
		// 	if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
		// 		return false;
		// 	return true;
		// }

		
		// if (session_photo == '') {
		// 	mini_photo.style="background-image: url('assets/media/users/blank.png'); "
		// } else {
		// 	mini_photo.style="background-image: url('upload/admin_user/"+session_photo+"'); "
		// }

		
	};

	return {

		//main function to initiate the module
		init: function() {
			initTable1();
		},

	};

}();

jQuery(document).ready(function() {
	GlobalJS.init();
	
});


