<!doctype html>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<head>
<meta charset="UTF-8">
<title>Error 404</title>
<?php
$base_url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
$base_url .= "://".$_SERVER['HTTP_HOST'];
$base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
?>
<link rel="stylesheet" type="text/css" href="<?=$base_url . 'css/custom.css'; ?>" />
<link rel="stylesheet" type="text/css" href="<?=$base_url . 'css/bootstrap/bootstrap.min.css'; ?>" />
</head>
<body>
<div id="contenedor-error">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1 class="text-center aviso-error">&iexcl;Ha ocurrido un error&#33;</h1>
      </div>
      <div class="col-md-12"> <img src="<?=$base_url . 'images/imagen-error-404.png'; ?>" class="img-responsive center-block img-error" alt="Responsive image"></div>
      <div class="col-md-12">
        <h2 class="text-center texto-error1">La p&aacute;gina solicitada</h2>
        <h3 class="text-center texto-error2">no se puede encontrar</h3>
        <div class="border-texto-error center-block" style="width:280px"></div>
        <div class="text-center">
        	<a href="javascript:history.go(-1)" class="regreso-inicio">Regresar a la p&aacute;gina anterior</a></div>
        <div class="text-center">
        	<a alt="Ir al inicio" href="<?=$base_url . 'inicio'?>" class="regreso-inicio" title="Ir al inicio">Ir al inicio</a>
        <div class="text-center">
          <p class="contacto-web">Si las dificultades persisten, p&oacute;ngase en contacto<br>
            con el administrador de este sitio.</p>
        </div>
      </div>
    </div>
  </div>
</div>
<?php //include(APPPATH . 'views/template/footer.php'); ?>
</body>
</html>