<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ManejadoDeIncripciones 1.0</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js" type="text/javascript"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/manejador_usuarios.css">
    <script src="../js/manejador_usuarios.js"></script> 
</head>
<body>
    <main>
        <section id="seccion_nuevo_usuario" class="shadow-lg bg-white  rounded centrado_absolute">
            <form action="javascript:  set_agregar();"  class="formulario">
                <input type="text" name="txt_nombre" id="txt_nombre" placeholder="Nombres" maxlength="100" required class="form-control">
                <input type="text" name="txt_apellido" id="txt_apellido" placeholder="Apellidos" maxlength="100" required class="form-control">
                <input type="text" name="txt_identificacion" id="txt_identificacion" placeholder="001-0000000-0" class="form-control" maxlength="13" minlength="13" onkeypress="completar_cedula();" required >
                <label for="txt_direccion">Direccion</label>
                <textarea name="txt_direccion" id="txt_direccion" maxlength="100" class="form-control"></textarea>
                <label for="txt_clave">Usuario</label>
                <input type="text" name="txt_user" id="txt_user" placeholder="Usuario" maxlength="10" required class="form-control">
                <label for="txt_clave">Clave</label>
                <input type="password" name="txt_clave" id="txt_clave" placeholder="Clave" maxlength="20" required class="form-control">
        
                
                <input type="submit" value="Agregar"  class="btn btn-primary">
              
            </form>
        </section>
        <section id="seccion_listado_usuario">
             <table class="table  table-hover">
                <thead>
                  <tr>
                    <th scope="col" hidden>#</th>
                    <th scope="col">Nombres</th>
                    <th scope="col">Apellidos</th>
                    <th scope="col">Identificacion</th>
                    <th scope="col">Usuario</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody id="lista_usuarios">
                   <script>
                        set_listado_filtrado(0);
                   </script>
                </tbody>
             </table>
        </section>
    </main>
</body>
</html>