jQuery(document).ready( function () {




    //############################ {{-- Открытие модалей c INPUT через клик на ссылке --}} ############################
    $('.modalTextShow').click(function() {

        var my_target = $(this).attr("data-target");
        var my_modal = $(my_target);

        var my_name = $(this).parents("li").find('font.name');
        if (my_name.html()) {
            my_modal.find('.title').html(my_name.html());
        }

        var my_value = $(this).parents("li").find('font.value');
        var my_valueID = my_value.attr('id');

        var my_input = my_modal.find('input.modalInput');

        //задаем ID объекта куда нужно потом вернуть значение
        if (my_valueID) {
            my_input.attr('data-valueID', my_valueID);
        }

        //задаем значение по умолчанию
        if (my_value.html()) {
            my_input.val(my_value.html());
        }

        var my_placeholder = $(this).attr("data-placeholder");
        if (my_placeholder) {
            my_input.attr('placeholder', my_placeholder);
        }

        var my_mask = $(this).attr("data-mask");
        if (my_mask) {
            my_input.mask(my_mask);
        }

        if ($(this).attr("data-uppercase")) {
            my_input.keyup(function() {
                $(this).val($(this).val().toUpperCase());
            });
        }

        my_modal.modal('show');
        return false;
    });




    //############################ {{-- Открытие модалей c TEXTAREA через клик на ссылке --}} ############################
    $('.modalAreaShow').click(function() {

        var my_target = $(this).attr("data-target");
        var my_modal = $(my_target);

        var my_name = $(this).parents("li").find('font.name');
        if (my_name.html()) {
            my_modal.find('.title').html(my_name.html());
        }

        var my_value = $(this).parents("li").find('font.value');
        var my_valueID = my_value.attr('id');

        var my_textarea = my_modal.find('textarea.modalTextarea');

        //задаем ID объекта куда нужно потом вернуть значение
        if (my_valueID) {
            my_textarea.attr('data-valueID', my_valueID);
        }

        //задаем значение по умолчанию
        if (my_value.html()) {
            my_textarea.val(my_value.html());
        }

        my_modal.modal('show');
        return false;
    });





    //############################ {{-- Открытие модалей c SELECT через клик на ссылке --}} ############################
    $('.modalSelectShow').click(function() {

        var my_target = $(this).attr("data-target");
        var my_modal = $(my_target);

        var my_name = $(this).parents("li").find('font.name');
        if (my_name.html()) {
            my_modal.find('.title').html(my_name.html());
        }

        var my_value = $(this).parents("li").find('font.value');
        var my_valueID = my_value.attr('id');

        var my_select = my_modal.find('select.modalSelect');

        //задаем ID объекта куда нужно потом вернуть значение
        if (my_valueID) {
            my_select.attr('data-valueID', my_valueID);
        }

        //задаем все необходимые options
        var my_options = $(this).attr("data-options");
        if (my_options) {
            var arr = my_options.split('|');
            $(".modalSelect").append(new Option('', ''))
            arr.forEach(function(item){
                $(".modalSelect").append(new Option(item, item))
            });
        }

        //задаем значение по умолчанию
        if (my_value.html()) {
            $(".modalSelect").val( my_value.html() ).change();
        }

        my_modal.modal('show')
        return false;
    });





    //############################ {{-- При закрытии модали, мы возвращаем поле INPUT в первоначальное значение --}} ############################
    $("#AddEditRowText").on('hide.bs.modal', function (e) {

        var my_input = $(this).find('input.modalInput');
        var my_valueID = $(this).find('input.modalInput').attr('data-valueID');
        if (my_valueID) {
            $("#" + my_valueID).html( my_input.val() );
            $("." + my_valueID).html( my_input.val() );
        }

        my_input.val('');
        my_input.attr('data-valueID', '');
        my_input.attr('placeholder', '');
        my_input.unmask();
        my_input.unbind("keyup");

        $(this).find('.title').html('');
    });





    //############################ {{-- При закрытии модали, мы возвращаем поле TEXTAREA в первоначальное значение --}} ############################
    $("#AddEditRowArea").on('hide.bs.modal', function (e) {

        var my_input = $(this).find('textarea.modalTextarea');
        var my_valueID = $(this).find('textarea.modalTextarea').attr('data-valueID');
        if (my_valueID) {
            $("#" + my_valueID).html( my_input.val() );
            $("." + my_valueID).html( my_input.val() );
        }

        my_input.val('');
        my_input.attr('data-valueID', '');

        $(this).find('.title').html('');
    });




    //############################ {{-- При закрытии модали, мы возвращаем поле SELECT в первоначальное значение --}} ############################
    $("#AddEditRowSelect").on('hide.bs.modal', function (e) {

        var my_select = $(this).find('select.modalSelect');
        var my_valueID = $(this).find('select.modalSelect').attr('data-valueID');
        if (my_valueID) {
            $("#" + my_valueID).html( my_select.val() );
            $("." + my_valueID).html( my_select.val() );
        }

        my_select.val('');
        my_select.find('option').remove();

        $(this).find('.title').html('');
    });







});


