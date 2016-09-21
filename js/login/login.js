$(function () {
    //Si el navegador es Internet Explorer, se redirecciona al módulo de Internet Explorer
    redirectBrowser();
    
    $('#frmIngreso').validate({
        rules: {
            usuario: { required: true, email: true },
            clave: { required: true }
        },
        messages: {
            usuario: {
                required: 'Digita tu correo electr\u00f3nico.',
                email: 'No es una direcci\u00f3n de correo electr\u00f3nico v\u00e1lida',
            },
            clave: {
                required: 'Digita tu contrase\u00f1a.'
            }
        },
        errorPlacement: function (error, element) {
            element.after(error);
            error.css('display', 'inline');
            error.css('margin-left', '10px');
            error.css('color', '#FFFFFF');
        },
        submitHandler: function (form) {
            if (grecaptcha.getResponse() != '') {
                bootbox.alert('Por favor, verifica que no eres un robot.');
            } else {
                //Lanzar AJAX validacion
                $.ajax({
                    type: 'POST',
                    url: base_url+'login/userAuth',
                    data: {
                        'usuario': $('#usuario').val(),
                        'clave': $('#clave').val()
                    },
                    dataType: 'json',
                    contentType: 'application/x-www-form-urlencoded;charset=UTF-8',
                    cache: false,
                    success: function (data) {
                        if (data.result) {
                            $('#divMsgAlert').hide();
                            window.location.replace(data.url);
                        } else {
                            $('#msgError').html(data.message);
                            $('#divMsgAlert').show();
                        }
                    },
                    error: function (data) {
                        if (data != '') {
                            alert('ERROR: ' + data.status + '\n' + data.statusText + '\n' + data.responseText.trim());
                        }
                    }
                });
            }
        }
    });

    //Envia el usuario hacia el recordatorio de contraseña
    $('#btnReminder').bind('click', function () {
        var url = base_url + 'login/reminder';
        $(location).attr('href', url);
    });

    //Envia el usuario hacia el formulario de registro 
    $('#btnRegistra').bind('click', function () {
        $(location).attr('href', base_url + 'registrese');
    });
});