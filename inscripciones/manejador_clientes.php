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
    <script src="js/manejador_usuarios.js"></script> 
</head>
<body>
    <main>
        <section id="seccion_nuevo_usuario" class="flex_colum">
            <form action="javascript:  set_agregar();"  class="formulario bg-white shadow-lg  rounded">
                <input type="text" name="txt_nombre" id="txt_nombre" placeholder="Nombres" maxlength="100" required 
                class="form-control form_content">
                <input type="text" name="txt_apellido" id="txt_apellido" placeholder="Apellidos" maxlength="100" required 
                class="form-control form_content">
                <input type="text" name="txt_identificacion" id="txt_identificacion" placeholder="001-0000000-0"
                 class="form-control form_content" maxlength="13" minlength="13" onkeypress="completar_cedula();" required >
                <label for="txt_direccion">Direccion</label>
                <textarea name="txt_direccion" id="txt_direccion" maxlength="100" class="form-control form_content"></textarea>
                <label for="txt_feccorte">fecha de corte</label>
                <input type="date" name="txt_feccorte" id="txt_feccorte"  class="form-control form_content" required>
                <label for="txt_cuota">fecha de corte</label>  
                <input type="number" name="txt_cuota" id="txt_cuota" class="form-control form_content" required> 
                
                <input type="submit" value="Agregar/Modificar"  class="btn btn-primary form_content">
            </form>
            <div id="contadores" class="flex_colum bg-white shadow-lg  rounded">
                <section class="contadores_content">
                    <div class="contendor_contador contendor_contador_1" onclick="alert('');">
                        <span>INSCRIPTOS</span>
                        <p id="cont_inscriptos">0</p>
                    </div>
                    <div class="contendor_contador contendor_contador_2" onclick="alert('');">
                       <span>VENCIDOS</span>
                       <p id="cont_nopagos">0</p>
                    </div>
                    <div class="contendor_contador contendor_contador_3" onclick="alert('');">
                        <span>AL DIA</span>
                        <p id="cont_pagos">0</p>
                    </div>
                </section>
                
            </div>
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
                <tfoot>
                    <tr>
                        
                        <td></td>
                        <td><button class="btn btn-primary" onclick="index_ultimo_registro-=limite_paginacion; set_listado_filtrado(0);"><<</button></td>
                        <td></td>
                        <td><button class="btn btn-primary" onclick="index_ultimo_registro+=limite_paginacion; set_listado_filtrado(0);">>></button></td>
                        <td></td>
                        
                    </tr>
                </tfoot>
             </table>
        </section>
    </main>
</body>
</html>