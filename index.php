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
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/formulario_inscripcion.css">
    <script src="js/formulario_inscripciones.js"></script>
</head>

<body>
    <main>
    <section id="menu">
        <ul id="menu_opciones">
            <li class="opciones_menu" onclick="abrir_formulario();">
                <img src="imagenes/incripcion.png" class="iconos_menu" srcset=""><span>incripcion</span>
            </li>
            <li class="opciones_menu" onclick="alert('ventanilla de pagos')">
                <img src="imagenes/pagos.png" class="iconos_menu" srcset=""><span>pagos</span>
            </li>
        </ul>
    </section>

    <section id="cuerpo">
        <div id="cabecera" class="cabecera">
            <div id="cabecera_1" class="opciones_cabecera">
                <img src="imagenes/usuario.png" alt="" srcset="">
                <div class="cabecera_div">
                    <span class="cabecera_span_label">inscritos</span>
                    <span id="cabecera_1_span_label_cantidad" class="cabecera_1_span_label">0</span>
                </div>
            </div>

            <div id="cabecera_2" class="opciones_cabecera">
                <div class="cabecera_div">
                    <span class="cabecera_span_label">recaudado</span>
                    <span id="cabecera_2_span_label_cantidad" class="cabecera_span_label">0</span>
                </div>
            </div>
            
            <div id="cabecera_3" class="opciones_cabecera">
                <div class="cabecera_div">
                    <span class="cabecera_span_label">faltante</span>
                    <span id="cabecera_3_span_label_cantidad" class="cabecera_span_label">0</span>
                </div>
            </div>

        </div>
        <div id="cuerpo_contenido"></div>
    </section>

    <section id="formulario_incripcion" class="cerrado">
          <div id="formulario_inscripcio_cuerpo">
             <form action="" method="" class="formulario_inscripcion_formulario">
                <h1>formulario de inscripcion</h1>

                <div>

                      <div class="formulario_inscripcion_formulario_fielset">
                          <label for="inscripcion_nombres">nombres</label>
                          <input type="text" name="inscripcion_nombres" id="inscripcion_nombres" required> 
                      </div>
                      <br>
                      <div class="formulario_inscripcion_formulario_fielset">
                          <label for="inscripcion_apellidos">apellidos</label>
                          <input type="text" name="inscripcion_apellidos" id="inscripcion_apellidos" required> 
                      </div>     
                      <br>
                      <div class="formulario_inscripcion_formulario_fielset">
                          <label for="inscripcion_apellidos">identificacion</label>
                          <input type="text" name="inscripcion_identificacion" id="inscripcion_identificacion" > 
                      </div>  
                      <br>
                      <div class="formulario_inscripcion_formulario_fielset">
                          <label for="fecha_nacimiento">fecha de nacimiento</label>
                          <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" required>
                      </div>  
                      <br>  <br>
                      <button id="boton_formulario_inscripcion_envio" class="boton_formulario">enviar</button>


                </div>

            </form>
          </div>
    </section>
    
</main>
</body>


</html>