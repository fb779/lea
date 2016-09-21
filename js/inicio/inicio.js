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
        $('html, body').animate({scrollTop: 0}, 600);
        return false;
    });
    
    $.fn.bloquearPanel = function (idCampo, nombreClase) {
        $('#' + idCampo).removeClass('panel '+ nombreClase);
        $('#' + idCampo).addClass('panel panel-disabled');
        $('#' + idCampo).bind('click', function () {
            return false;
        });
    }

    $.fn.habilitarPanel = function (idCampo, nombreClase, modulo) {
        $('#' + idCampo).removeClass('panel panel-disabled');
        $('#' + idCampo).addClass('panel ' + nombreClase);
        $('#' + idCampo).bind('click', function () {
            $('html, body').scrollTop(0);
            var url = base_url + modulo;
            $(location).attr('href', url);
        });
    }
    
    $.ajax({
        type: 'POST',
        url: base_url + 'inicio/actualizarAvance',
        data: {},
        dataType: 'json',
        contentType: 'application/x-www-form-urlencoded;charset=UTF-8',
        cache: false,
        beforeSend: function () {
            $('#animationload').fadeIn();
        },
        complete: function () {
            $('#animationload').fadeOut();
        },
        success: function (data) {
            var avance = data.avance;
            var img = base_url + 'images/tick.png';
            var porcent = data.avance.toString() + '%';
            $('#progressbar').css('width', porcent);
            
            if (data.campo1 == 2) {
                $('#imgmod1').attr('src', img);
                //$('#panelUbicacion').bloquearPanel('panelUbicacion', 'panel-green');
                $('#panelUbicacion').habilitarPanel('panelUbicacion', 'panel-green', 'ubicacion');
            } else {
                $('#panelUbicacion').habilitarPanel('panelUbicacion', 'panel-green', 'ubicacion');
            }
            if (data.campo2 == 2) {
                $('#imgmod2').attr('src', img);
                //$('#panelUbicacion').bloquearPanel('panelUbicacion', 'panel-blue');
                $('#panelUbicacion').habilitarPanel('panelPersonas', 'panel-blue', 'personas');
            } else {
                $('#panelUbicacion').habilitarPanel('panelPersonas', 'panel-blue', 'personas');
            }
            
        },
        error: function (data) {
            if (data.status != 200) {
                alert('ERROR: ' + data.status + '\n' + data.statusText + '\n' + data.responseText.trim());
            }
        }
    });
});