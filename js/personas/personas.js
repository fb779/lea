$(function () {
    //Si el navegador es Internet Explorer, se redirecciona al módulo de Internet Explorer
    redirectBrowser();
    
    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover();
    //Configuracion de JQGrid
    $.jgrid.defaults.width = 1150;
    $.jgrid.defaults.styleUI = 'Bootstrap';
    $.jgrid.defaults.responsive = true;
    
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
    
    $('#C1PU').bloquearTexto().maxlength(3);
    
    jQuery('#listPersonas').jqGrid({
        url: base_url + 'personas/buscarPersonas',
        editurl: base_url + 'personas/edit',
        datatype: 'json',
        mtype: 'POST',
        colNames: ['Cedula', 'Apellidos', 'Nombre(s)', 'Correo electrónico', 'Usuario', 'Horario', 'Opc.'],
        colModel: [
            {name: 'nume_docu', index: 'nume_docu', align: 'left', resizable: false, search: false, sortable: false, width: 60},
            {name: 'apellidos', index: 'apellidos', align: 'left', resizable: false, search: false, sortable: false, width: 120},
            {name: 'nombres', index: 'nombres', align: 'left', resizable: false, search: true, sortable: false, width: 120},
            {name: 'email', index: 'email', align: 'left', resizable: false, search: false, sortable: false, width: 80},
            {name: 'usuario', index: 'usuario', align: 'left', resizable: false, search: false, sortable: false, width: 40},
            {name: 'horario', index: 'horario', align: 'left', resizable: false, search: false, sortable: false, width: 40},
            {name: 'opciones', index: 'opciones', align: 'left', resizable: false, search: false, sortable: false, width: 40}
        ],
        autowidth: true,
        height: 'auto',
        pager: '#pagerPersonas',
        pginput: false,
        pgbuttons: true,
        sortorder: 'asc',
        rowNum: 50,
        viewrecords: true,
        width: 'auto',
        loadComplete: function () {
            //$('#btnBuscar').button('reset');
            $('#animationload').fadeOut();
            $('tr.jqgrow:odd').addClass('altRow');
        }
    }).navGrid('#pagerPersonas', {search: false, edit: false, add: false, del: false});
    
    $('#btnAgregar').click(function () {
        $(location).attr('href', base_url + 'personas/agregarPersona');
        return false;
    });
});