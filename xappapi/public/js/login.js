$(document).ready(function(){
	$(".login_container").attr("style","width:"+$(window).outerWidth()+"px");
	$(".login_container").attr("style","height:"+$(window).outerHeight()+"px");

	if ($(window).outerHeight() > 254)
		margin_top = $(window).outerHeight()/2 - 254/2;
	else
		margin_top = 0;
	margin_top -=155;
	$(".form-login").css("top",margin_top+"px");
});
$(window).resize(function() {
	$(".login_container").attr("style","width:"+$(window).outerWidth()+"px");
	$(".login_container").attr("style","height:"+$(window).outerHeight()+"px");

	if ($(window).outerHeight() > 254)
		margin_top = $(window).outerHeight()/2 - 254/2;
	else
		margin_top = 0;
	margin_top -=155;
	$(".form-login").css("top",margin_top+"px");
});
function onModelRegisterSubmit(){

	if ($("#username_register").val() == "") return false;
	if ($("#password_register").val() == "") return false;
	if ($("#repassword_register").val() == "") return false;
	if ($("#password_register").val() != $("#repassword_register").val()) {
		alert("Invalid password");
		$("#password_register").val("");
		$("#repassword_register").val("");
		$("#password_register").focus();
		return false;
	}

	$.post("login/register", {username: $("#username_register").val(), password:$("#password_register").val()}, function (data){
		if (data == true) {
			alert("Successfully registered!");
			$("#username_register").val("");
			$("#password_register").val("");
			$("#repassword_register").val("");
			$("#username_register").focus();
		}
		else {
			alert("database register error!");
		}
	});
	return true;
}

function onLoginSubmit(){
	if ($("#username").val() == "") return false;
	if ($("#password").val() == "") return false;
	$.post(base_url+"index.php/login/loginCheck", {username: $("#username").val(), password:$("#password").val(), usergrade:'admin'}, function (data){
		if (data == true) {
			document.location.href=base_url+"index.php/users/index";
		}
		else {
			alert("Invalid username or password");
			$("#username").val("");
			$("#password").val("");
			$("#username").focus();
		}
	});
	return true;
}
$(document).ready(function(){
	$("#password").keydown(function(event) {
		if ( event.which == 13 ) {
		   onLoginSubmit('model');
		 }
	});
	$("#username").focus();
});
