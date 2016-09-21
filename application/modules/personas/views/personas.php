<div class="page-header">
    <h1>eCenso / Personas</h1>
</div>
<div id="divMsgSuccess" class="alert alert-success" <?php echo (strlen($msgSuccess) == 0) ? 'style="display: none;"' : ''; ?>>
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong id="msgSuccess"><?= $msgSuccess ?></strong>
</div>
<div id="divMsgAlert" class="alert alert-danger" <?php echo (strlen($msgError) == 0) ? 'style="display: none;"' : ''; ?>>
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong id="msgError"><?= $msgError ?></strong>
</div>
<div class="well">
    <div class="row">
        <div class="col-md-2">
            <img src="<?php echo base_url("images/hogar.png"); ?>"/>
        </div>
        <div class="col-md-10">
            <label><h2>Listado de residentes habituales del LEA</h2></label>
        </div>
    </div>
    <div class="row" style="margin-top: 10px;">
        <div class="col-md-12">
            <p>Verifique en la lista que se muestra en esta pantalla, si las personas que usted ingresó en la inscripción son los <a>residentes habituales</a> 
            que conforman actualmente el <a>LEA</a>. Si necesita agregar <a>residentes habituales</a> adicionales a los que se encuentran la lista, por favor 
            ingrese la información y dé clic en el botón Agregar.</p>
        </div>
    </div>
    <div class="row" style="margin-top: 10px;">
        <div class="col-md-12">
            <label>Total de RESIDENTES EN ESTA INSTITUCIÓN, que no pertenecen a hogares:</label> 
            <input type="text" name="C1PU" id="C1PU" maxlength="3" size="3" />
        </div>
    </div>
    <div class="row" style="margin-top: 10px;">
        <div class="col-md-12">
            <table id="listPersonas"></table>
            <div id="pagerPersonas"></div>
        </div>
    </div>
    <br />
    <div class="row" style="margin-top: 10px;">
        <div class="col-md-12" style="text-align: right">
            <button type="button" id="btnAgregar" class="btn btn-sm btn-primary">Agregar</button>
        </div>
    </div>
</div>