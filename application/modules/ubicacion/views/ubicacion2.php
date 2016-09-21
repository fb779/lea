<div class="page-header">
    <h1>eCenso / Ubicación</h1>
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
            <label><h2>Datos de ubicación 2 del LEA</h2></label>
        </div>
    </div>
    <form id="formUbicacion" name="formUbicacion" class="form-horizontal" role="form" action="" method="post">
        <input type="hidden" name="ID_UBICACION" id="ID_UBICACION" value="<?=$ID_UBICACION?>" />
        <input type="hidden" name="FK_ID_ADMIN_CONTROL" id="FK_ID_ADMIN_CONTROL" value="<?=$FK_ID_ADMIN_CONTROL?>" />
        <input type="hidden" name="pagina" id="pagina" value="2" />
        <?php foreach ($var as $k => $v) {
            echo '<div class="row"><div class="col-md-12" id="' . $v['ID_VARIABLE'] . '-col">';
            echo '<label id="' . $v['ID_VARIABLE'] . '-lbl" class="control-label" for="' . $v['ID_VARIABLE'] . '">(' . $v['ID_VARIABLE'] . ') ' . $v['DESCRIPCION'];
            if (!empty($v['AYUDA']))
                echo "&nbsp;<a href='#' data-toggle='tooltip' title='" . $v['AYUDA'] . "'>(?)</a>";
            echo "</label><br />\n";
            echo "<label id='" . $v['ID_VARIABLE'] . "-error' class='error' style='display: none; margin-left: 10px; color: rgb(255, 0, 0);' for='" . $v['ID_VARIABLE'] . "'></label><br />\n";
            if ($v['TIPO_CAMPO'] == "SELUNICA") {
                echo mostrar_select($v, $v["OPCIONES"]);
            } else if ($v['TIPO_CAMPO'] == "SELUNICA_RAD") {
                echo mostrar_radios($v, $v["OPCIONES"]);
            } else if ($v['TIPO_CAMPO'] == "TEXTO") {
                echo mostrar_input_text($v);
            }
            echo '</div></div>';
        } ?>
        <br />
        <div class="row">
            <div class="col-md-12" style="text-align: right">
                <button type="button" id="btnSiguiente" class="btn btn-sm btn-primary">Guardar y siguiente</button>
            </div>
        </div>
    </form>
</div>