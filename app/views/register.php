<?php
include "../../app/controllers/registerController.php"
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Registro para Investigadores del GI</title>
        <link href="../../css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Registro de usuario</h3></div>
                                    <div class="card-body">
                                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                                        <div class="form-group">
                                                <label class="small mb-1" for="nombre_integrante">Nombre Completo</label>
                                                <input class="form-control py-4" id="nombre_integrante" name="nombre_integrante" type="text" placeholder="Ingrese su nombre completo" />
                                                <span class="msg-error"><?php echo $nombre_integrante_err?></span>
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="email">Email</label>
                                                <input class="form-control py-4" id="email" name="email" type="email" aria-describedby="emailHelp" placeholder="Ingrese su dirección de email" />
                                                <span class="msg-error"><?php echo $email_err?></span>
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="contrasenia">Contraseña</label>
                                                <input class="form-control py-4" id="contrasenia" name="contrasenia" type="password" placeholder="Ingrese su contraseña" />
                                                <span class="msg-error"><?php echo $contrasenia_err?></span>
                                            </div>
                                            <div class="form-group mt-4 mb-0">
                                                <input class="btn btn-primary btn-block" type="submit" value="Crear Cuenta">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="small"><a href="login.html">¿Ya se ha registrado? <b>Inicie sesión aquí</b></a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Universidad Autónoma del Estado de Hidalgo</div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../../js/scripts.js"></script>
    </body>
</html>
