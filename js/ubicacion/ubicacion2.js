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
    
    $('#formUbicacion').validate({
        rules: {
            C1U8_TIPO_ESTABLE: { required: true },
            C1U9_EXISTE_HOGAR: { required: true }
        },
        messages: {
            C1U8_TIPO_ESTABLE: { required: 'Selecciona el tipo de institución o establecimiento.' },
            C1U9_EXISTE_HOGAR: { required: 'Selecciona si existe o no algún hogar en esta institución o establecimiento.' }
        },
        errorPlacement: function (error, element) {
            $("#" + element.attr("id")).show();
            $("#" + element.attr("id")).html(error);
        },
        submitHandler: function (form) {
            form.submit();
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