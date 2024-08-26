<il?php
      session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ManejadoDeIncripciones 1.0</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js" type="text/javascript"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
    <link rel="stylesheet" href="css/formulario_inscripcion.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="js/loging.js"></script>
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <main>
         <section id="logging" class="shadow-lg  rounded mx-auto center display_flex">
            <img src="imagenes/loging2.png" alt="" class="img_loging">
            <form action="javascript:  get_validar_acceso();"  class="formulario">
                <label for="txt_clave">Usuario</label>
                <input type="text" name="txt_user" id="txt_user" placeholder="Usuario" maxlength="10" required class="form-control text_centrado pading_1 ">
                <label for="txt_clave">Clave</label>
                <input type="password" name="txt_clave" id="txt_clave" placeholder="Clave" maxlength="20" required class="form-control text_centrado pading_1 ">
        
                <br>
                <input type="submit" value="Acceder"  id="bt_acceder" class="btn btn-primary ancho_completo pading_1 ">
            </form>
        </section>
    </main>
</body>


</html>