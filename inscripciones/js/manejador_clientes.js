var id_usuario_seleccionado=0;
var id_persona_seleccionado=0;
var limite_paginacion=3;
var index_ultimo_registro=0;
var id_usuario_logueado=0;
let fichero_seleccionado ="" ;
var objectURL_aux="";
var total_inscriptos=0;
var lista_clientes_vencidos;

function completar_cedula(){
    var cedula = document.getElementById("txt_identificacion")
    if(cedula.value.length==3){
        cedula.value=cedula.value+"-";
    }else if(cedula.value.length==11){
        cedula.value=cedula.value+"-";
    }
}

function set_agregar(){
  console.log("objectURL_aux = "+objectURL_aux);
  if(objectURL_aux.length >0){
    set_subir_imagen();
  }else{
    set_insertar_datos();
  }
}

function set_insertar_datos(){
  var nombres = document.getElementById("txt_nombre").value; 
  var apellidos = document.getElementById("txt_apellido").value; 
  var identificacion = document.getElementById("txt_identificacion").value; 
  var direccion = document.getElementById("txt_direccion").value; 
  var feccorte = document.getElementById("txt_feccorte").value; 
  var monto = document.getElementById("txt_cuota").value; 
  
  var accion=1;
  if(id_persona_seleccionado>0){
    accion=4;
  }

  console.log("accion a tomar = "+accion);

  $.post("ctrl/clientes.php"
    ,{"nombres":nombres 
    ,"apellidos":apellidos 
    ,"identificacion":identificacion 
    ,"direccion":direccion 
    ,"feccorte":feccorte 
    ,"monto":monto 
    ,"accion":accion 
    ,"url_img":objectURL_aux 
    ,"usuario":id_usuario_logueado 
    ,"id_persona_seleccionado":id_persona_seleccionado 
   }
    ,function(respuesta){
        var resp = respuesta.trim();
        if(resp == 'AGREGADO CORRECTO'){
            alert('AGREGADO CORRECTO');
            id_persona_seleccionado=0;
        }else if(resp == 'MODIFICACION REALIZADA'){
            alert('MODIFICACION REALIZADA');
            id_persona_seleccionado=0;
        }else{
            alert('ERROR => '+respuesta);
        }
        set_listado_filtrado();
        get_total_inscriptos();
         get_clientes_corte_vencido(); 
        
 });
}


  function set_agregar_fila(nombre,apellido,identificacion,feccorte,cuota,id){
    var tableRow = document.getElementById("tabla_datos_cuerpo");
    var fila = document.createElement("tr");
    var celda0 = document.createElement("td");
    var celda1 = document.createElement("td");
    var celda2 = document.createElement("td");
    var celda3 = document.createElement("td");
    var celda4 = document.createElement("td");
    var celda5 = document.createElement("button");
    celda1.innerHTML = nombre;
    celda2.innerHTML = apellido;
    celda3.innerHTML = identificacion;
    celda4.innerHTML = feccorte;
    celda0.innerHTML = cuota;
    celda5.innerHTML = 'ELIMINAR';
    celda5.id="eliminar";

    celda1.onclick = function() {  get_cliente(id); };
    celda5.onclick = function() {  id_persona_seleccionado=id; set_eliminar(); };

    fila.appendChild(celda1);
    fila.appendChild(celda2);
    fila.appendChild(celda3);
    fila.appendChild(celda4);
    fila.appendChild(celda0);
    fila.appendChild(celda5);
    tableRow.appendChild(fila);
}


function set_listado_filtrado(){
  var criterio = document.getElementById("txt_buscar").value;
  var accion = 2;//opcion para seleccionar los datos del equipo
  var count_mostrados=0;
    $.post("ctrl/clientes.php"
      ,{"id":id_usuario_logueado 
        ,"limite":limite_paginacion
        ,"cursor":index_ultimo_registro
        ,"criterio":criterio
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

function set_paginar_atraz(){
  index_ultimo_registro-=limite_paginacion;
  set_listado_filtrado();
}

function set_paginar_adelante(){
   index_ultimo_registro+=limite_paginacion;
   set_listado_filtrado();
}

function readURL(input) {
  const $seleccionArchivos = document.querySelector("#pic"),
  $imagenPrevisualizacion = document.querySelector("#usuario_logo");

  const archivos = $seleccionArchivos.files;
  // Si no hay archivos salimos de la función y quitamos la imagen
  if (!archivos || !archivos.length) {
    $imagenPrevisualizacion.src = "";
    return;
  }
  // Ahora tomamos el primer archivo, el cual vamos a previsualizar
  const primerArchivo = archivos[0];
  // Lo convertimos a un objeto de tipo objectURL
  const objectURL = URL.createObjectURL(primerArchivo);
  // Y a la fuente de la imagen le ponemos el objectURL
  $imagenPrevisualizacion.src = objectURL;
  objectURL_aux=objectURL;
}

function set_subir_imagen(){
  var formData = new FormData();
  var file_data = $('#pic').prop('files')[0];
  formData.append('file',file_data);

  $.ajax({
      url: '../ctrl/upload.php',
      type: 'post',
      data: formData,
      contentType: false,
      processData: false,
      success: function(response) {
          var ruta ='';
          if(file_data!=null){
              ruta=response;
             // alert("subida correcta en ruta: "+ruta);
              objectURL_aux=ruta;
              set_insertar_datos();
          }else{
               ruta = fichero_seleccionado;
               objectURL_aux=ruta;
          }

          if((fichero_seleccionado!=null && fichero_seleccionado.length>0)){
              ruta = fichero_seleccionado;
          }      
      }
  });
}

function get_cliente(id_persona){
  var accion = 3;//opcion para seleccionar los datos del equipo
  var count_mostrados=0;
    $.post("ctrl/clientes.php"
      ,{"id_usuario":id_usuario_logueado 
      ,"id_cliente":id_persona
      ,"accion":accion 
      }
      ,function(respuesta){
          try {
            var json = $.parseJSON(respuesta);
           // console.log(json);//muestro en consola
            //llamo al metodo para cargar los datos del cliente seleccionado
            set_cargar_datos_cliente_seleccionado(json);
          } catch (error) {
              console.log(error);
              console.log(respuesta);
          }
      }); 
}

function set_eliminar(){
  var accion = 6;//opcion para seleccionar los datos del equipo
    $.post("ctrl/clientes.php"
      ,{"id_persona":id_persona_seleccionado 
      ,"id_usuario":id_usuario_logueado 
      ,"accion":accion 
      }
      ,function(respuesta){
          try {
             var resp = respuesta.trim();
               if(resp == 'CORRECTO'){
                 id_persona_seleccionado=0;
                 alert('Cliente Eliminado');
                 set_listado_filtrado();
                 get_total_inscriptos(); 
                 get_clientes_corte_vencido(); 
               }else{
                console.log('ERROR => '+respuesta);
               }
          } catch (error) {
              console.log(error);
              console.log(respuesta);
          }
      }); 
}

function set_cargar_datos_cliente_seleccionado(json){
  $imagenPrevisualizacion = document.querySelector("#usuario_logo");
  id_persona_seleccionado=json[6]; 

  document.getElementById("txt_nombre").value          = json[0]; 
  document.getElementById("txt_apellido").value        = json[1]; 
  document.getElementById("txt_identificacion").value  = json[2]; 
  document.getElementById("txt_direccion").value       = json[3]; 
  document.getElementById("txt_feccorte").value        = json[4]; 
  document.getElementById("txt_cuota").value           = json[5]; 
  document.getElementById("txt_saldo").value           = json[8]; 

  if(json[7].length>0){
    //cargo la imagen desde bbdd
    $imagenPrevisualizacion.src =  "../imagenes_subidas/"+json[7];
    objectURL_aux=json[7];
    fichero_seleccionado=json[7];
}else{
    $imagenPrevisualizacion.src =  "../imagenes/usuario.png";
    objectURL_aux=json[7];
    fichero_seleccionado=json[7];
}
}


function get_total_inscriptos(){
  var accion = 5;//opcion para seleccionar los datos del equipo
  //console.log("         get_total_inscriptos();");
    $.post("ctrl/clientes.php"
      ,{"id_usuario":id_usuario_logueado 
      ,"accion":accion 
      }
      ,function(respuesta){
          try {
            total_inscriptos=respuesta;
            document.getElementById("basic-addon1").innerHTML = total_inscriptos;
            //console.log("contador = "+respuesta);
          } catch (error) {
              console.log(error);
              console.log(respuesta);
          }
      }); 
}

function get_clientes_corte_vencido(){
  var accion = 7;//opcion para seleccionar los datos del equipo
  //console.log("         get_total_inscriptos();");
    $.post("ctrl/clientes.php"
      ,{"id_usuario":id_usuario_logueado 
      ,"accion":accion 
      }
      ,function(respuesta){
        try {
          var json = $.parseJSON(respuesta);
         // console.log(json);//muestro en consola
          document.getElementById("basic-addon2").innerHTML = json.length;
          lista_clientes_vencidos = json;
        } catch (error) {
            console.log(error);
            console.log(respuesta);
        }
      }); 
}