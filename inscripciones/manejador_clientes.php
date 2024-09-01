<?php 
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/manejador_clientes.css">
    <script src="js/manejador_clientes.js"></script> 
    <script>
         id_usuario_logueado = <?php printf($_SESSION['usuario_logeado_id'])?>;
    </script>
</head>
<body>
<main>
    <section id="menu">
         <ul id="menu_lista">
            <div class="iten_menu_group">
               <li class="iten_lista_menu">inscritos</li>   
               <span class="input-group-text" id="basic-addon1">0</span>
            </div>
            <div class="iten_menu_group">
               <li class="iten_lista_menu">pendientes</li>   
               <span class="input-group-text" id="basic-addon1">0</span>
            </div>
            <div class="iten_menu_group">
               <li class="iten_lista_menu">opcion3</li>   
               <span class="input-group-text" id="basic-addon1">@</span>
            </div>
        </ul>
    </section>

    <section id="principal_content">
        
    <div id="contenedor_formulario">
            <div id="contenedor_formulario_img_content">
                <img src="../imagenes/usuario.png" alt="" srcset="" id="usuario_logo">
                <br>
                <input type="file" name="pic" id="pic" onchange="readURL(this.value)"/>
            </div>
            <form action="javascript:  set_agregar();"  class="shadow-lg  rounded formulario">
                 <input type="text" name="txt_nombre" id="txt_nombre" placeholder="NOMBRES" maxlength="100" required 
                 class="form-control form_content">
                 <input type="text" name="txt_apellido" id="txt_apellido" placeholder="APELLIDOS" maxlength="100" required 
                 class="form-control form_content">
                <input type="text" name="txt_identificacion" id="txt_identificacion" placeholder="IDENTIFICACION"
                 class="form-control form_content" maxlength="13" minlength="13" onkeypress="completar_cedula();" required >
                 <label for="txt_direccion">Direccion</label>
                 <textarea name="txt_direccion" id="txt_direccion" maxlength="100" class="form-control form_content"></textarea>
                 <label for="txt_feccorte">fecha de corte</label>
                 <input type="date" name="txt_feccorte" id="txt_feccorte"  class="form-control form_content" required>
                 <label for="txt_cuota">monto</label>  
                 <input type="number" name="txt_cuota" id="txt_cuota" class="form-control form_content" required> 
                
                 <input type="submit" value="Agregar/Modificar"  class="btn btn-primary form_content">
            </form>
        </div>

        <div id="contenedor_tabla">
            <div class="iten_menu_group2">
               <img src="../imagenes/tab-search.png" alt="" srcset="" id="usuario_logo" class="icono">
               <input type="text" name="txt_nombre" id="txt_nombre" placeholder="001-0000000-0" maxlength="100" required 
               class="form-control">
            </div>

            <table class=" table-hover tabla_datos table">
                <thead>
                    <tr>
                        <th>nombres</th>
                        <th>apellidos</th>
                        <th>identificacion</th>
                        <th>feccorte</th>
                        <th>cuota</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="tabla_datos_cuerpo"></tbody>
                <script>
                    set_listado_filtrado();
                </script>
            </table>

            <div id="control_paginacion">
                <button class="rounded bt_paginacion" onclick="set_paginar_atraz();"><<</button>
                <button class="rounded bt_paginacion" onclick="set_paginar_adelante();">>></button>
            </div>
        </div>
        
    </section>

</main>
</body>
</html>
