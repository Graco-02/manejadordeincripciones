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
        
        <div id="contenedor_formulario">
            <div id="contenedor_formulario_img_content">
                <img src="../imagenes/usuario.png" alt="" srcset="" id="usuario_logo">
                <br>
                <input type="file" name="pic" id="pic" onchange="readURL(this.value)"/>
            </div>
            <form action="javascript:  set_agregar();"  class="shadow-lg  rounded formulario">
                <br>
                 <div class="grid_comulns_2">
                    <label for="txt_nombre">Nombres</label>
                    <input type="text" name="txt_nombre" id="txt_nombre" placeholder="NOMBRES" maxlength="100" required 
                    class="input_text form-control form_content ">
                 </div>

                 <div class="grid_comulns_2">
                 <label for="txt_apellido">Apellidos</label>
                 <input type="text" name="txt_apellido" id="txt_apellido" placeholder="APELLIDOS" maxlength="100" required 
                 class="form-control form_content input_text">
                 </div>

                 <div class="grid_comulns_2">
                 <label for="txt_identificacion">Identificacion</label>
                 <input type="text" name="txt_identificacion" id="txt_identificacion" placeholder="IDENTIFICACION"
                 class="form-control form_content input_text" maxlength="13" minlength="13" onkeypress="completar_cedula();" required >
                 </div>

                 <label for="txt_direccion">Direccion</label>
                 <textarea name="txt_direccion" id="txt_direccion" maxlength="100" class="form-control form_content input_text"></textarea>

                 <div class="grid_comulns_2">
                 <label for="txt_feccorte">fecha de corte</label>
                 <input type="date" name="txt_feccorte" id="txt_feccorte"  class="form-control form_content input_text" required>
                 </div>

                 <div class="grid_comulns_2">
                    <div>
                        <label for="txt_cuota">cuota</label>  
                         <input type="number" name="txt_cuota" id="txt_cuota" class="form-control form_content input_text" value="0" required> 
                    </div>
                    <div>
                        <label for="txt_saldo">saldo</label>  
                         <input type="number" name="txt_saldo" id="txt_saldo" class="form-control form_content input_text" value="0"> 
                    </div>
                 </div>

                <br>

                 <div class="grid_comulns_2">
                     <input type="submit" value="Agregar/Modificar"  class="btn btn-primary form_content bt_withe">
                     <input value="pagar"  class="btn btn-primary form_content bt_withe" id="bt_pagar" onclick="get_ventana_pago();">
                 </div>
                 <br>
            </form>
        </div>

        <div id="contenedor_tabla">
            <div class="iten_menu_group2">
               <img src="../imagenes/tab-search.png" alt="" srcset="" id="usuario_logo" class="icono">
               <input type="text" name="txt_buscar" id="txt_buscar" placeholder="Buscar" maxlength="100" onkeypress="set_listado_filtrado();" 
               class="form-control">
            </div>

            <div class="table-responsive">
            <table class=" table-hover tabla_datos table">
                <thead class="table-light cabecera_tabla">
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
            </div>
            <div id="control_paginacion">
                <button class="rounded bt_paginacion" onclick="set_paginar_atraz();"><<</button>
                <button class="rounded bt_paginacion" onclick="set_paginar_adelante();">>></button>
            </div>
        </div>
        
    </section>

    <section class="cerrado rounded formulario_pago" id="seccion_pago"> 
        <form action="javascript: set_realizar_pago();"  class="formulario_pago_conten">
                <div class="grid_comulns_2">
                    <label for="txt_dias_atrazo">Dias en Atrazo</label>
                    <input type="number" name="txt_dias_atrazo" id="txt_dias_atrazo" placeholder="0" maxlength="100" readonly 
                    class="input_text form-control form_content ">
                </div>
                <div class="grid_comulns_2">
                    <label for="txt_monto_atrazo">Monto en Atrazo</label>
                    <input type="number" name="txt_monto_atrazo" id="txt_monto_atrazo" placeholder="0" maxlength="100" readonly 
                    class="input_text form-control form_content ">
                </div>
                <div class="grid_comulns_2">
                    <label for="txt_monto_pago">Monto del pago</label>
                    <input type="number" name="txt_monto_pago" id="txt_monto_pago" placeholder="0" maxlength="100" required 
                    class="input_text form-control form_content ">
                </div>
                <div class="grid_comulns_2">
                    <label for="txt_comentario_pago">Cometarios</label>
                    <textarea name="txt_comentario_pago" id="txt_comentario_pago" maxlength="100" class="form-control form_content input_text"></textarea>
                </div>
                <br>
                <br>
                <div class="grid_comulns_2">
                <input type="submit" value="Pagar"  class="btn btn-primary form_conten bt_withe">
                <input  value="cerrar"  class="btn btn-primary form_content bt_withe" onclick="set_cerrar_pago();">
                </div>
        </form>
    </section>

</main>
</body>
<script>get_total_inscriptos(); get_clientes_corte_vencido(); </script>
</html>
