/*
<div class="captcha">
                        <div class="g-recaptcha" data-sitekey="6LfcxtohAAAAAL31GKxhsYLW6padvZbGrf2IFArW"></div>   
                        </div>
*/

function CallMe() {

var captcha = grecaptcha.getResponse();
if (!captcha.length) {
	alert("Вы не прошли проверку");
	return false;
}


if ($("#phone").val() != "") {
$.ajax({
	method: "get",
	url: "/callme",
	data: {
		form_subject: $("#form_subject").val(),
		recipient: $("#recipient").val(),
		phone: $("#phone").val()
	},
	success: function (result) {
		$("#recipient").val('');
		$("#phone").val('');
	},
	error: function (result) {
		console.log('ошибка');
		console.log(result);
	}
});

$("#CallMe").modal('hide');
alert("Спасибо, наш менеджер вам скоро перезвонит");
}
else {
alert("Заполните поля");
}

}


function CallMeAgro() {

if ($("#agro_phone").val() != "") {
$.ajax({
	method: "get",
	url: "/callme",
	data: {
		form_subject: $("#agro_form_subject").val(),
		recipient: $("#agro_recipient").val(),
		phone: $("#agro_phone").val()
	},
	success: function (result) {
		$("#agro_recipient").val('');
		$("#agro_phone").val('');
	},
	error: function (result) {
		console.log('ошибка');
		console.log(result);
	}
});

$("#CallMeAgro").modal('hide');
alert("Спасибо, наш менеджер вам скоро перезвонит");
}
else {
alert("Заполните поля");
}

}




function CallMeSaturn() {

if ($("#saturn_phone").val() != "" && $("#saturn_email").val() != "" && $("#saturn_recipient").val() != "" && $("#saturn_inn").val() != "") {
$.ajax({
	method: "get",
	url: "/callme",
	data: {
		form_subject: $("#satrun_form_subject").val(),
		recipient: $("#saturn_recipient").val(),
		phone: $("#saturn_phone").val(),
		email: $("#saturn_email").val(),
		inn: $("#saturn_inn").val(),
		company: $("#saturn_company").val(),
	},
	success: function (result) {
		$("#saturn_recipient").val('');
		$("#saturn_phone").val('');
		$("#saturn_email").val('');
		$("#saturn_inn").val('');
		$("#saturn_company").val('');
	},
	error: function (result) {
		console.log('ошибка');
		console.log(result);
	}
});

$("#CallMeSaturn").modal('hide');
alert("Спасибо, наш менеджер вам скоро перезвонит");
}
else {
alert("Заполните поля");
}

}











$(document).ready(function(){
$('#phone').mask("+7 (999) 999-99-99");		
$('#agro_phone').mask("+7 (999) 999-99-99");		
$('#saturn_phone').mask("+7 (999) 999-99-99");	
});


