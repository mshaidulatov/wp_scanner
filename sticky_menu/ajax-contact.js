jQuery(function($){ // DOM is now read and ready to be manipulated

    function validateEmail(email) {
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }

    function valid_error(item){
        item.addClass('valid_error');
        item.css({'background' : 'pink'});
        item.css({'border' : '1px red solid'});
    }
    function valid_fine(item){
        item.removeClass('valid_error');
        item.css({'background' : '#fff'});
        item.css({'border' : '1px #ddd solid'});
    }
    function validate(item){
        // return true - прошли валидацию
        // return false - не прошли валидацию
        if(item.hasClass('required')){
            if(item.val()==''){
                valid_error(item);
                item.attr("placeholder", "Please fill");
                return false;
            }
            else {
                if(item.hasClass('data-email')){
                    if(!validateEmail(item.val())){ valid_error(item);item.attr("title", "Incorrect value"); return false;}
                    else {valid_fine(item); return true;}
                }
                else {valid_fine(item);return true;}
            }
        } else {valid_fine(item);return true;}
    }

    $(function() {
        $(".submit_contact").click(function() {
            var val_er = false; // false - ошибки нет true - ошибка
            var data_string = ''; // дл€ формировани€ строки $_POST
            var form = $(this).closest('form'); // ‘орма
            var inputs = form.find('input[type!="submit"]'); // Ёлементы input
            // console.log(form);
            // console.log(inputs);

            inputs.each(function(){
                var arrt_name = $(this).attr('id');
                var arrt_val_type = $(this).attr('data-val-type');
                if(validate($(this))){
                    data_string += $(this).attr('name')+'='+$(this).val()+'&';
                }else val_er = true; // ќшибка, ничего оне отправл€ем!!!
            });
            if ($('#mobile-contact textarea').val()){ // есть текстовое поле?
                data_string += '&message='+$('#mobile-contact textarea').val();
            }
            else { // если нет, то удал€ем последний &
                data_string = data_string.substring(0, data_string.length - 1);
            }
            if ($('#main-contact > div > textarea').val()){ // есть текстовое поле?
                data_string += '&message='+$('#main-contact textarea').val();
            }
            else { // если нет, то удал€ем последний &
                data_string = data_string.substring(0, data_string.length - 1);
            }
            if ($('#supplementary-contact textarea').val()){ // есть текстовое поле?
                data_string += '&message='+$('#supplementary-contact textarea').val();
            }
            else { // если нет, то удал€ем последний &
                data_string = data_string.substring(0, data_string.length - 1);
            }
            if (val_er == false){
                // AJAX functions
                $.ajax({
                    type: "POST",
                    url: contact_url,
                    data: data_string,
                    cache: false,
                    success: function(html){
                        if (html == 1) {
                            $('#modal-container').fadeIn("slow", function() {
                                $(this).addClass('is-active');
                                $(this).addClass('successful');
                                $('#modal-container > .modal-inner > #modal-label').html('<h1>Thank You!</h1>');
                                $('#modal-container > .modal-inner > .modal-content').html('<p>Your Message Has Been Sent Successfully.</p>');
                                $(this).attr('aria-hidden','false')
                            });
                            form[0].reset();
                            $('#modal-container > .modal-inner > footer > #close-modal').click(function() {
                                $('#modal-container').fadeOut("slow", function() {
                                    $(this).removeClass("is-active");
                                    $(this).removeClass("successful");
                                    $(this).attr('aria-hidden','true');
                                });
                            });
                            function explode(){
                                $('#modal-container').fadeOut("slow", function() {
                                    $(this).removeClass("is-active");
                                    $(this).removeClass("successful");
                                    $(this).attr('aria-hidden','true');
                                });
                            }
                            setTimeout(explode, 4000);
                        } else {
                            $('#modal-container').addClass('is-active');
                            $('#modal-container').addClass('error-appeared');
                            $('#modal-container > .modal-inner > #modal-label').html('<h1>ERROR!</h1>');
                            $('#modal-container > .modal-inner > .modal-content').html('<p>Error Happened. Please Try Again Later.</p>');
                            $('#modal-container').attr('aria-hidden','false')
                            function explode(){
                                $('#modal-container').fadeOut("slow", function() {
                                    $(this).removeClass("is-active");
                                    $(this).removeClass("error-appeared");
                                    $(this).attr('aria-hidden','true');
                                });
                            }
                            setTimeout(explode, 4000);
                        }
                    }
                });
            }
            return false;

        });
    });

});