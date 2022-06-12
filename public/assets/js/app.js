// $(".btn-load").on("click", function () {
// 	Swal.fire({
// 		title: "Mengalihkan...",
// 		text: "Membawamu terbang ke awan",
// 		showLoaderOnConfirm: true,
// 		showConfirmButton: false,
// 		showCloseButton: false,
// 		showCancelButton: false,
// 		allowOutsideClick: false,
// 		allowEscapeKey: false,
// 		onOpen: () => {
// 			swal.showLoading();
// 		},
// 	});
// 	return true;
// });

// $('form').submit(function () {
// 	Swal.fire({
// 		text: "Loading",
// 		showLoaderOnConfirm: true,
// 		showConfirmButton: false,
// 		showCloseButton: false,
// 		showCancelButton: false,
// 		allowOutsideClick: false,
// 		allowEscapeKey: false,
// 		onOpen: () => {
// 			swal.showLoading();
// 		},
// 	});
// 	return true;
// });

$(".select2").select2();

$("#passwordtoggle").on("click", function () {
	var inputPassword = document.getElementById("password");
	if (inputPassword.type === "password") {
		inputPassword.type = "text";
		$("#icon").removeClass('fas fa-eye').addClass('fas fa-eye-slash');
	} else {
		inputPassword.type = "password";
		$("#icon").removeClass('fas fa-eye-slash').addClass('fas fa-eye');
	}
});

$(".passwordtoggle").on("click", function () {
	var inputPassword = document.getElementById("password");
	var ulangPassword = document.getElementById("password_confirmation");
	var oldPassword = document.getElementById("old_password");
	if (inputPassword.type === "password") {
		inputPassword.type = "text";
		ulangPassword.type = "text";
		oldPassword.type = "text";
		$("#icon").removeClass('fas fa-eye').addClass('fas fa-eye-slash');
		$("#icon1").removeClass('fas fa-eye').addClass('fas fa-eye-slash');
		$("#icon2").removeClass('fas fa-eye').addClass('fas fa-eye-slash');
	} else {
		inputPassword.type = "password";
		ulangPassword.type = "password";
		oldPassword.type = "password";
		$("#icon").removeClass('fas fa-eye-slash').addClass('fas fa-eye');
		$("#icon1").removeClass('fas fa-eye-slash').addClass('fas fa-eye');
		$("#icon2").removeClass('fas fa-eye-slash').addClass('fas fa-eye');
	}
});

// $('#name').on("change", function () {
// 	this.value = $('#name').val().toUpperCase();
// });