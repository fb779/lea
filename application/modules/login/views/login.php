<script src="https://www.google.com/recaptcha/api.js?hl=es" ></script>
<div id="divLogin" class="fondoLogin">
    <div class="row margin-login" style="height: 580px; ">
        <div class="col-md-4">
            <?php if (isset($enviado) && $enviado == true) {
                echo '<p><div class="alert alert-info" role="alert">' . $mensaje . '</div></p>';
            } elseif (isset($enviado) && $enviado == false) {
                echo '<p><div class="alert alert-danger" role="alert">' . $mensaje . '</div></p>';
            } ?>
            <div class="textWhite">
                <h2>BIENVENIDO</h2>
                <h4>Al piloto de la primera estrategia de recolección de información vía web para el censo de población y vivienda del país.</h4>
                <fieldset>
                    <form id="frmIngreso" name="frmIngreso" class="form-signin" method="post" action="<?=base_url("login/userAuth"); ?>">
                        <input type="email" id="usuario" name="usuario" class="form-control" placeholder="Correo electrónico" required autofocus />
                        <br/>
                        <input type="password" id="clave" name="clave" class="form-control" placeholder="Contraseña" required />
                        <br/>
                        <div class="g-recaptcha" data-sitekey="6LcqTg4TAAAAAN5yCK3f8wmkTpkilBE8rmTQr8gV"></div>
                        <br/>
                        <button class="btn btn-success" type="submit" id="btnIngresar" name="btnIngresar">Ingresar</button>
                        <button class="btn btn-warning" type="button" id="btnReminder" name="btnReminder">¿Olvidaste tu contraseña?</button>
                        <p>&nbsp;</p>
                    </form>
                </fieldset>
            </div>
            <div id="divMsgSuccess" class="alert alert-success" <?php echo (strlen($msgSuccess) == 0) ? 'style="display: none;"' : ''; ?>>
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong id="msgSuccess"><?= $msgSuccess ?></strong>
            </div>
            <div id="divMsgAlert" class="alert alert-danger" <?php echo (strlen($msgError) == 0) ? 'style="display: none;"' : ''; ?>>
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong id="msgError"><?= $msgError ?></strong>
            </div>
        </div>	
        <div class="col-md-4 textWhite"></div>
    </div>
    <div class="row">
        <p style="text-align: justify; font-size: small;">
            La información que nos brindarás cuenta con la protección de los datos establecidos en la ley de reserva estadística. Los datos suministrados al 
        Departamento Administrativo Nacional de Estadística (DANE), en el desarrollo de censos y encuestas, no podrán darse a conocer al público ni a las 
        entidades u organismos oficiales, ni a las autoridades públicas, sino únicamente en resúmenes numéricos, que no hagan posible deducir de ellos 
        información alguna de carácter individual que pudiera utilizarse para fines comerciales, de tributación fiscal, de investigación judicial o cualquier 
        otro diferente del propiamente estadístico. Ley de Reserva Estadística (Art. 5 Ley 79 de 1993).</p>
    </div>
</div>