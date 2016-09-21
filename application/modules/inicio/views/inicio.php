<script src="<?php echo base_url("/js/inicio/inicio.js"); ?>" rel="stylesheet"></script>
<div id="page-header" class="page-header">
    <h1>eCenso</h1>
</div>
<div class="row">
    <div class="col-md-12">
        <p>A continuaci&oacute;n, encontrar&aacute;s las secciones en los cuales est&aacute; dividido el cuestionario. Es necesario que diligencies todas las preguntas de cada secci&oacute;n para poder avanzar.</p>
    </div>
    <div class="hidden-lg hidden-md hidden-sm">&nbsp;</div>	
</div>
<br/>
<div class="row">
    <div class="col-md-6">
        <div id="panelUbicacion" class="panel panel-disabled" style="cursor: pointer">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <img src="<?php echo base_url("images/hogar.png"); ?>"/>
                    </div>
                    <div class="col-xs-9">
                        <div class="huge">Ubicación</div>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer">
                    <span class="pull-left">Ubicación</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"><img id="imgmod1" src="<?php echo base_url("/images/blank.png"); ?>" height="30" width="30"/></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-md-6">
        <div id="panelPersonas" class="panel panel-disabled" style="cursor: pointer">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <img src="<?php echo base_url("images/personas.png"); ?>"/>
                    </div>
                    <div class="col-xs-9">
                        <div class="huge">Personas</div>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer">
                    <span class="pull-left">Personas</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"><img id="imgmod2" src="<?php echo base_url("/images/blank.png"); ?>" height="30" width="30"/></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>
<div class="row">
    <div id="divProgress" class="col-md-12">
        <div class="progress">
            <div id="progressbar" class="progress-bar active" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 0%"><span class="sr-only">10% Complete</span></div>
        </div>
    </div>
</div>