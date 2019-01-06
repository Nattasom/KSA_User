jQuery(document).ready(function () {
    $("#form-role").validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "",
        rules: {
            code: {
                required: true,
            },
            name: {
                required: true
            },
            status: {
                required: true
            }
        },

        messages: {
            code: {
                required: "this field is required",
            },
            name: {
                required: "this field is required"
            },
            status: {
                required: "this field is required"
            }
        },

        highlight: function (element) { // hightlight error inputs
            $(element)
                .closest('.form-group').addClass('has-error'); // set error class to the control group
        },

        success: function (label) {
            label.closest('.form-group').removeClass('has-error');
            label.remove();
        },

        errorPlacement: function (error, element) {
            if ($(element).attr("name") == "password") {
                error.insertAfter(element.closest('.input-group'));
            } else {
                error.insertAfter(element.closest('.form-control'));
            }

        },
        submitHandler: function (form, event) {
            event.preventDefault();
            actionForm(form);
            //form.submit();
        }
    });

});
function actionForm(form) {
    
    var $btn = $("#btn-submit");
    var $btnback = $("#btn-back");
    var $loader = $btn.find("i.loader");
    var url = $(form).find("[name=action_url]").val();
    var action = $(form).find("[name=action]").val();

    if(action=="permission"){
        var $chk = $(".chk-action:checked");
        if($chk.length == 0){
            alert("Please check for permission");
            return;
        }
        var strsave = '';
        var row = 0;
        $chk.each(function(){
            var code = $(this).attr('data-code');
            var page = $(this).attr('data-page');
            if(row!=0){
                strsave +=',';
            }
            strsave += code+":"+page
            row++;
        });
        $("#hd-str-save").val(strsave);
    }
    var formData = new FormData(form);
    $btn.prop("disabled", true);
    $loader.removeClass("hide");
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: url,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (result) {
            console.log(result);
            if (result.status == "01") { //success
                if (action == "add") {
                    window.location = $btnback.attr("href");
                } else {
                    $("#password-group").addClass("hide");
                    $("#password").val('');
                    $('#change-password').prop('checked', false);
                    $.uniform.update();
                    $("#alert-success").removeClass("hide");
                    $("#alert-success").find("span").text(result.message);
                    // window.location.href = $(form).find("[name=current_url]").val()+"/"+$(form).find("[name=insurer_code]").val();
                    $(window).scrollTop(0);
                }
            } else {
                $("#alert-warning").removeClass("hide");
                $("#alert-warning").find("span").text(result.message);
                $(window).scrollTop(0);
            }

        }
    }).always(function () {
        $btn.prop("disabled", false);
        $loader.addClass("hide");
    });
}

