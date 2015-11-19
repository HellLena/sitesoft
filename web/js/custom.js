$(document).ready(function(){
    $(".ajax-form").submit(function(e){
        e.preventDefault();
        var form = $(this);
        var values = getFormValues(form);

        var form_name = form.attr('name');
        if(form_name == 'user') {
            form.find("div").removeClass("error");
            form.find(".help-inline").text('');
        } else if(form_name == 'post') {
            $(".alert-error").css("display","none").text('');
        }

        $.post(form.attr('action'), values, function(response){
            if(response['error']){
                var input = $(response['id']);
                input.parent('div').addClass('error');
                input.next('span').text(response['error']);
            } else if(form_name == 'user') {
                location.href = response['url'];
            } else if(form_name == 'post') {
                $(".well:first").before("<div class='well'><h5>" + response['post']['user'] +
                                         ": <small> " + response['post']['created_at']['date'] + "</small></h5>" +
                                         response['post']['post'] + "</div>");
                $(".well.empty").remove();
            }
        }, "json");
    });

    function getFormValues(form){
        var values = {};
        $.each(form.serializeArray(), function(i, field) {
            values[field.name] = field.value;
        });
        return values;
    }

});