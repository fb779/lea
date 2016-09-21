$(function () {
    //Si el navegador es Internet Explorer, se redirecciona al módulo de Internet Explorer
    redirectBrowser();
    
    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover();
    
    $(window).scroll(function() {
        if ($(this).scrollTop() > 400) {
            $('.scrollup').fadeIn();
        } else {
            $('.scrollup').fadeOut();
        }
    });

    $('.scrollup').click(function() {
        $("html, body").animate({scrollTop: 0}, 600);
        return false;
    });
    
    $('#C1U2_DPTO').change(function () {
        $('#C1U2_DPTO option:selected').each(function () {
            var C1U2 = $('#C1U2_DPTO').val();
            if (C1U2 > 0 || C1U2 != '') {
                $.ajax ({
                    cache: false,
                    contentType: 'application/x-www-form-urlencoded;charset=UTF-8',
                    data: {'opc': 'mpio','id': C1U2},
                    dataType: 'html',
                    type: 'POST',
                    url: base_url + 'ubicacion/listaDesplegable',
                    beforeSend: function () {
                        $('#animationload').fadeIn();
                    },
                    complete: function () {
                        $('#animationload').fadeOut();
                    },
                    success: function (data) {
                        $('#C1U3_MPIO').html(data);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        bootbox.alert('Error al buscar. Intente nuevamente o actualice la p\u00e1gina.');
                        location.reload();
                    }
                });
            } else {
                var data = '<option value="">Seleccione</option>';
                $('#C1U3_MPIO').html(data);
            }
        });
    });
    
    $('#formUbicacion').validate({
        rules: {
            C1U1_NOMBRE: { required: true },
            C1U2_DPTO: { required: true },
            C1U3_MPIO: { required: true },
            C1U4_LUGAR: { required: true },
            C1U5_TERRI_ET1: { required: true },
            C1U7_DIRECCION: { required: true }
        },
        messages: {
            C1U1_NOMBRE: { required: 'Digita el nombre del LEA.' },
            C1U2_DPTO: { required: 'Selecciona el departamento.' },
            C1U3_MPIO: { required: 'Selecciona el municipio.' },
            C1U4_LUGAR: { required: 'Selecciona el lugar donde está ubicado el LEA.' },
            C1U5_TERRI_ET1: { required: 'Selecciona si está ubicado en territorialidad étnica el LEA.' },
            C1U7_DIRECCION: { required: 'Digita la dirección.' }
        },
        errorPlacement: function (error, element) {
            $("#" + element.attr("id")).show();
            $("#" + element.attr("id")).html(error);
        },
        submitHandler: function (form) {
            var validar = false;
            var C1U5 = $('input:radio[name=C1U5_TERRI_ET1]:checked').val();
            var C1U6 = $('input:radio[name=C1U6_TERRI_ET2]:checked').val();
            if(C1U5 == 1) {
                if(isNaN(C1U6)) {
                    $("#C1U6_TERRI_ET2-error").show();
                    $("#C1U6_TERRI_ET2-error").html('Selecciona la territorialidad étnica el LEA');
                } else {
                    validar = true;
                }
            } else {
                validar = true;
            }
            
            if(validar == true) {
                form.submit();
            }
        }
    });
    
    $('#btnSiguiente').click(function () {
        var na = '';
        var cadena = $('#formUbicacion').serializeArray();
        $.each(cadena, function (key, value) {
            na = value['name'];
            if ($('#' + na + '-error').length) {
                $('#' + na + '-error').html('');
                $('#' + na + '-error').hide();
            }
        });
        $('#formUbicacion').submit();
        return false;
    });
});