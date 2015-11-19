$(document).ready(function(){

    $("form[name='user']").submit(function(e){
        e.preventDefault();
        /*
         * Get all form values
         */
        $form = $(this);
        var values = {};
        $.each($form.serializeArray(), function(i, field) {
            values[field.name] = field.value;
        });
        $form.find("div").removeClass("error");
        $form.find(".help-inline").text('');
        /*
         * Throw the form values to the server!
         */
        $.post($form.attr('action'), values, function(response){
            if(response['error']){
                var input = $(response['id']);
                input.parent('div').addClass('error');
                input.next('span').text(response['error']);
            }
            else {
                location.href = response['url'];
            }
        }, "json");
    });

});