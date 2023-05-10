$(document).ready(function(){
/*"Услуга ""Аграномическое сопровождение"":
В админке делаем кнопку слева ""заказать агро сопровождение"".
Эта кнопка как заказать обратный звонок, но показываться она должна только тем регионам,
в которых есть представители. Проще всего привязать это можно к ИНН так как у каждого региона есть маска.
в каждом ИНН, первые цифры - это регион. вот по региону и можно сделать маску. 
вот регионы которые нужны (126, 26, 07, 05,95, 09). Эта кнопка у них мелькает
внизу слева или еще где нибудь на видном месте. 
Клиент из своего личного кабинета ее наживает 
и ему вылезает окно в котром уже подтянулся номер телефона из его карточки, 
вопрос подтвердите номер и внизу кнопка перезвонить. 
Типа он смотрит и подтверждает свой номер и просит перезвонить по этому агро сопровождению"*/

$.ajaxSetup({
headers:
{ 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
});

$.ajax({
method: "post",
url: "/admin/users/get_current",
//data: { id: 2369 },
success: function (response) {
	//console.log("result",response);
	let show_btn = false;

    if (response.user !==undefined) {

        if (response.user.company_inn !== undefined) {
        	let inn_array = response.user.company_inn.split("");

        	if (inn_array[0] == 1 && inn_array[1] == 2 && inn_array[2] == 6) {    
        		show_btn = true;
        	}

        	if (inn_array[0] == 2 && inn_array[1] == 6) {    
        		show_btn = true;
        	}

        	if (inn_array[0] == 0 && inn_array[1] == 7) {    
        		show_btn = true;
        	}

        	if (inn_array[0] == 0 && inn_array[1] == 5) {    
        		show_btn = true;
        	}

        	if (inn_array[0] == 9 && inn_array[1] == 5) {    
        		show_btn = true;
        	}

        	if (inn_array[0] == 0 && inn_array[1] == 9) {    
        		show_btn = true;
        	}

        	if (show_btn) {
        		$("#menu_agronomic").show();        		
        	}
        }

		if (response.user.full_name !== undefined) {
			$("#recipient").val(response.user.full_name);
            $("#agro_recipient").val(response.user.full_name);
		}

		if (response.user.phone !== undefined) {
			$("#phone").val(response.user.phone);
            $("#agro_phone").val(response.user.phone);
		}
    }
},
error: function (result) {
console.log('ошибка');
}
});


});