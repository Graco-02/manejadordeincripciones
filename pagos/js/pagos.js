var limite_paginacion=10;
var index_ultimo_registro=0;
var id_usuario_logueado =0;

function get_listado(){
    var criterio = document.getElementById("txt_buscar").value;
    var fecha_ini = document.getElementById("fecha_ini").value; 
    var fecha_fin = document.getElementById("fecha_fin").value; 

    var accion = 3;//opcion para seleccionar los datos del equipo
    var count_mostrados=0;
      $.post("ctrl/pagos.php"
        ,{"id":id_usuario_logueado 
          ,"limite":limite_paginacion
          ,"cursor":index_ultimo_registro
          ,"criterio":criterio
          ,"fecha_ini":fecha_ini
          ,"fecha_fin":fecha_fin
        ,"accion":accion 
        }
        ,function(respuesta){
            var listado_jugadores   = document.getElementById("tabla_datos_cuerpo");   
            listado_jugadores.innerHTML = '';       
            try {
              var json = $.parseJSON(respuesta);
           //   console.log(json);//muestro en consola
              if(json.length>0){
                for(i=0;i<json.length;i++){
                   set_agregar_fila(json[i][0],json[i][1],json[i][2],json[i][3],json[i][4],json[i][5]);       
                }
              }
            } catch (error) {
                var tableRow = document.getElementById("tabla_datos_cuerpo");
                var fila = document.createElement("tr");
                var celda0 = document.createElement("td");
                celda0.innerHTML = "SIN DATOS PARA MOSTRAR";
                fila.appendChild(celda0);
                tableRow.appendChild(fila);
                console.log(error);
                console.log(respuesta);
            }
        }); 
}

function set_agregar_fila(fecha,cliente,identificacion,monto,comentario,pg_id){
    var tableRow = document.getElementById("tabla_datos_cuerpo");
    var fila = document.createElement("tr");
    var celda0 = document.createElement("td");
    var celda1 = document.createElement("td");
    var celda2 = document.createElement("td");
    var celda3 = document.createElement("td");
    var celda4 = document.createElement("td");
    var celda5 = document.createElement("button");
    celda1.innerHTML = fecha;
    celda2.innerHTML = cliente;
    celda3.innerHTML = identificacion;
    celda4.innerHTML = monto;
    celda0.innerHTML = comentario;
    celda5.innerHTML = 'ELIMINAR';

    celda1.onclick = function() {  document.getElementById("seccion_pago").classList.toggle('cerrado'); console.log('CLick');set_datos_recivo(fecha,cliente,identificacion,monto,comentario);};
    celda5.onclick = function() {   };

    fila.appendChild(celda1);
    fila.appendChild(celda2);
    fila.appendChild(celda3);
    fila.appendChild(celda4);
    fila.appendChild(celda0);
   // fila.appendChild(celda5);
    tableRow.appendChild(fila);
}

function set_datos_recivo(fecha,cliente,identificacion,monto,comentario){
    document.getElementById("cli_fecha").innerHTML          = fecha;
    document.getElementById("cli_name").innerHTML           = cliente;
    document.getElementById("cli_identificacion").innerHTML = identificacion;
    document.getElementById("cli_monto").innerHTML          = monto;
    document.getElementById("cli_comentario").innerHTML     = comentario;
}

function set_paginar_atraz(){
    index_ultimo_registro-=limite_paginacion;
    get_listado();
}
  
function set_paginar_adelante(){
     index_ultimo_registro+=limite_paginacion;
     get_listado();
}

function createPDF() {
        const page = document.getElementById('recivo_content').innerHTML;
       // console.log(page);
        var opt = {
            margin:       1,
            filename:     'myrecivo.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2 },
            jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
        };
        // Choose the element that our invoice is rendered in.
        html2pdf().set(opt).from(page).save("");
}