"use strict";

// Class Definition
var KTLogin = function() {
    var _login;

    var _showForm = function(form) {
        var cls = 'login-' + form + '-on';
        var form = 'kt_login_' + form + '_form';

        _login.removeClass('login-forgot-on');
        _login.removeClass('login-signin-on');
        _login.removeClass('login-signup-on');

        _login.addClass(cls);

        KTUtil.animateClass(KTUtil.getById(form), 'animate__animated animate__backInUp');
    }

    var _handleSignInForm = function() {
        var validation;

        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validation = FormValidation.formValidation(
			KTUtil.getById('kt_login_signin_form'),
			{
				fields: {
					username: {
						validators: {
							notEmpty: {
								message: 'Username harus diisi'
							}
						}
					},
					password: {
						validators: {
							notEmpty: {
								message: 'Password harus diisi'
							}
						}
					}
				},
				plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    submitButton: new FormValidation.plugins.SubmitButton(),
                    //defaultSubmit: new FormValidation.plugins.DefaultSubmit(), // Uncomment this line to enable normal button submit after form validation
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		);

        $('#kt_login_signin_submit').on('click', function (e) {
            e.preventDefault();

            validation.validate().then(function(status) {
		        if (status == 'Valid') {
					var btnsubmit = $('#kt_login_signin_submit');
					$.ajax({
						url: $('#kt_login_signin_form').attr('action'),
						type: 'POST',
						data: $('#kt_login_signin_form').serialize(),
						success: function (data) {
							btnsubmit.val('Masuk');
							if (data.status) {
								// var go = base_url;
								var go = HOST_URL;
								window.location.href = go;
							} else {
								if (data.invalid) {
									Swal.close();
									Swal.fire({
										icon: 'warning',
										title: 'Peringatan!',
										text: "Nama Pengguna dan Password tidak valid!",
										showConfirmButton: true
									});
								}
								if (data.failed) {
									Swal.close();
									Swal.fire({
										icon: 'warning',
										title: 'Peringatan!',
										text: "Nama Pengguna dan Password tidak cocok!",
										showConfirmButton: true
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
				} else {
					swal.fire({
		                text: "Kesalahan terdeteksi, silahkan coba lagi!",
		                icon: "error",
		                buttonsStyling: false,
		                confirmButtonText: "Ok",
                        customClass: {
    						confirmButton: "btn font-weight-bold btn-light-primary"
    					}
		            }).then(function() {
						KTUtil.scrollTop();
					});
				}
		    });
        });
		
		$('.pasar').hide();

        // Handle forgot button
        $('#kt_login_forgot').on('click', function (e) {
            e.preventDefault();
            _showForm('forgot');
        });

        // Handle signup
        $('#kt_login_signup').on('click', function (e) {
            e.preventDefault();
            _showForm('signup');
        });
        // Handle signup
        $('#form_registrasi_penjual').on('click', function (e) {
            e.preventDefault();
            _showForm('signup');
			$('#user_group').val('0002');
			$('.pasar').hide();
        });
        // Handle signup
        $('#form_registrasi_pembeli').on('click', function (e) {
            e.preventDefault();
            _showForm('signup');
			$('#user_group').val('0003');
			$('.pasar').show();
        });
    }

    var _handleSignUpForm = function(e) {
		
        var validation;
        var form = KTUtil.getById('kt_login_signup_form');

        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        $('#propid').on('change', function() {
			$.ajax({
				url: HOST_URL + 'open/get_kab_kot_by_propid/'+$('#propid').val(),
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
				url: HOST_URL + 'open/get_kecamatan_by_kabid/'+$('#kabid').val(),
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
				url: HOST_URL + 'open/get_pasar_by_kecid/'+$('#kecid').val(),
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
			$.ajax({
				url: HOST_URL + 'open/get_kecamatan_by_id_row/'+$('#kecid').val(),
				type: "POST",
				dataType: "JSON",
				success: function(data) {
					$('#kodepos').empty();
					$('#kodepos').val(data);
					console.log(data);
					// for (var i = 0; i < data.length; i++) {
					// 	$('#kodepos').append('<option id=' + data[i].pasar_id + ' value=' + data[i].pasar_id + '>' + data[i].pasar_desc + '</option>');
					// }
					// $('#pasar_id').change();
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert('Error filter data');
				}
			});
			
		});
		// $('#pasar_id').on('change', function() {
		// 	$.ajax({
		// 		url: HOST_URL + 'open/get_pasar_by_kecid/'+$('#kecid').val(),
		// 		type: "POST",
		// 		dataType: "JSON",
		// 		success: function(data) {
		// 			$('#pasar_id').empty();
		// 			$('#pasar_id').append('<option value="">-- Pilih Pasar --</option>');
		// 			for (var i = 0; i < data.length; i++) {
		// 				$('#pasar_id').append('<option id=' + data[i].pasar_id + ' value=' + data[i].pasar_id + '>' + data[i].pasar_desc + '</option>');
		// 			}
		// 			// $('#pasar_id').change();
		// 		},
		// 		error: function(jqXHR, textStatus, errorThrown) {
		// 			alert('Error filter data');
		// 		}
		// 	});
		// });
		validation = FormValidation.formValidation(
			form,
			{
				fields: {
					fullname: {
						validators: {
							notEmpty: {
								message: 'Username is required'
							}
						}
					},
					email: {
                        validators: {
							notEmpty: {
								message: 'Email address is required'
							},
                            emailAddress: {
								message: 'The value is not a valid email address'
							}
						}
					},
                    password: {
                        validators: {
                            notEmpty: {
                                message: 'The password is required'
                            }
                        }
                    },
                    cpassword: {
                        validators: {
                            notEmpty: {
                                message: 'The password confirmation is required'
                            },
                            identical: {
                                compare: function() {
                                    return form.querySelector('[name="password"]').value;
                                },
                                message: 'The password and its confirm are not the same'
                            }
                        }
                    },
                    agree: {
                        validators: {
                            notEmpty: {
                                message: 'You must accept the terms and conditions'
                            }
                        }
                    },
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		);

        $('#kt_login_signup_submit').on('click', function (e) {
            e.preventDefault();

            validation.validate().then(function(status) {
		        if (status == 'Valid') {
					var btnsubmit2 = $('#kt_login_signup_submit');
					$.ajax({
						url: $('#kt_login_signup_form').attr('action'),
						type: 'POST',
						data: $('#kt_login_signup_form').serialize(),
						success: function (data) {
							btnsubmit2.val('Daftar');
							if (data.status) {
								var go2 = HOST_URL;
								window.location.href = go2;
								Swal.fire({
									icon: 'success',
									title: 'Berhasil!',
									text: 'Data Berhasil disimpan...',
									showConfirmButton: true
								});
							} else {
								if (data.invalid) {
									Swal.close();
									Swal.fire({
										icon: 'warning',
										title: 'Peringatan!',
										text: "Data yang anda masukan tidak valid!",
										showConfirmButton: true
									});
								}
								if (data.failed) {
									Swal.close();
									Swal.fire({
										icon: 'warning',
										title: 'Peringatan!',
										text: "Data yang anda masukan gagal!",
										showConfirmButton: true
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
				} else {
					swal.fire({
		                text: "Sorry, looks like there are some errors detected, please try again.",
		                icon: "error",
		                buttonsStyling: false,
		                confirmButtonText: "Ok, got it!",
                        customClass: {
    						confirmButton: "btn font-weight-bold btn-light-primary"
    					}
		            }).then(function() {
						KTUtil.scrollTop();
					});
				}
		    });
        });

        // Handle cancel button
        $('#kt_login_signup_cancel').on('click', function (e) {
            e.preventDefault();

            _showForm('signin');
        });
    }

    var _handleForgotForm = function(e) {
        var validation;

        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validation = FormValidation.formValidation(
			KTUtil.getById('kt_login_forgot_form'),
			{
				fields: {
					email: {
						validators: {
							notEmpty: {
								message: 'Email address is required'
							},
                            emailAddress: {
								message: 'The value is not a valid email address'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		);

        // Handle submit button
        $('#kt_login_forgot_submit').on('click', function (e) {
            e.preventDefault();

            validation.validate().then(function(status) {
		        if (status == 'Valid') {
                    // Submit form
                    KTUtil.scrollTop();
				} else {
					swal.fire({
		                text: "Sorry, looks like there are some errors detected, please try again.",
		                icon: "error",
		                buttonsStyling: false,
		                confirmButtonText: "Ok, got it!",
                        customClass: {
    						confirmButton: "btn font-weight-bold btn-light-primary"
    					}
		            }).then(function() {
						KTUtil.scrollTop();
					});
				}
		    });
        });

        // Handle cancel button
        $('#kt_login_forgot_cancel').on('click', function (e) {
            e.preventDefault();

            _showForm('signin');
        });
    }

    // Public Functions
    return {
        // public functions
        init: function() {
            _login = $('#kt_login');
            _handleSignInForm();
            _handleSignUpForm();
            _handleForgotForm();
        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
    KTLogin.init();
});
