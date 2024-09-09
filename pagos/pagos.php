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
    <link rel="stylesheet" href="css/pagos.css">
    <script src="js/pagos.js"></script> 
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
               <script> </script>
            </div>
            <div class="iten_menu_group">
               <li class="iten_lista_menu">pendientes</li>   
               <span class="input-group-text" id="basic-addon2">0</span>
            </div>
            <div class="iten_menu_group">
               <li class="iten_lista_menu"><a href="../pagos/pagos.php" >Historico de Pagos</a></li>   
               <!--<span class="input-group-text" id="basic-addon3">@</span>-->
            </div>
        </ul>
    </section>

    <section id="principal_content">
        <div class="shadow-lg rounded" id="contenedor_formulario">
            <div class="iten_menu_group2">
                <div class="iten_menu_group2">
                    <img src="../imagenes/tab-search.png" alt="" srcset="" id="usuario_logo" class="icono">
                    <span>cliente</span>
                </div>
               <input type="text" name="txt_buscar" id="txt_buscar" placeholder="Buscar" maxlength="100" onkeypress="set_listado_filtrado();" 
               class="form-control">
            </div>

            <div class="iten_menu_group3">
                <div class="iten_menu_group2">
                    <label for="fecha_ini">Fecha de Incio</label>
                    <input type="date" name="fecha_ini" id="fecha_ini"  class="form-control">
                </div>
                <div class="iten_menu_group2">
                    <label for="fecha_fin">Fecha de Fin</label>
                    <input type="date" name="fecha_fin" id="fecha_fin"  class="form-control">
                </div>
            </div>   

            <div class="iten_menu_group3">
                <button class="form-control rounded botones">buscar</button>
            </div>
        </div>

        <div class="shadow-lg rounded " id="tabla">
            <table class=" table-hover tabla_datos table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>cliente</th>
                        <th>monto</th>
                        <th>comentario</th>
                    </tr>
                </thead>
                <tbody id="tabla_datos_cuerpo"></tbody>
            </table>
        </div>
        <div id="control_paginacion">
                <button class="rounded bt_paginacion" onclick="set_paginar_atraz();"><<</button>
                <button class="rounded bt_paginacion" onclick="set_paginar_adelante();">>></button>
        </div>
    </section>
</main>
    
</body>
</html>