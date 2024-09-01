var id_usuario_seleccionado=0;
var id_persona_seleccionado=0;
var limite_paginacion=3;
var index_ultimo_registro=0;
var id_usuario_logueado=0;
let fichero_seleccionado ="" ;
var objectURL_aux="";

function completar_cedula(){
    var cedula = document.getElementById("txt_identificacion")
    if(cedula.value.length==3){
        cedula.value=cedula.value+"-";
    }else if(cedula.value.length==11){
        cedula.value=cedula.value+"-";
    }
}

function set_agregar(){
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
   }
    ,function(respuesta){
        var resp = respuesta.trim();
        if(resp == 'AGREGADO CORRECTO'){
            alert('AGREGADO CORRECTO');
        }else if(resp == 'MODIFICACION REALIZADA'){
            alert('MODIFICACION REALIZADA');
        }else{
            alert('ERROR => '+respuesta);
        }
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

    celda1.onclick = function() { alert(id);  };
    celda5.onclick = function() {  if(id_usuario_seleccionado>0 && id_persona_seleccionado>0){get_eliminar_usuario(id_usuario_seleccionado,id_persona_seleccionado);}else{alert("no hay seleccion")} };

    fila.appendChild(celda1);
    fila.appendChild(celda2);
    fila.appendChild(celda3);
    fila.appendChild(celda4);
    fila.appendChild(celda0);
    fila.appendChild(celda5);
    tableRow.appendChild(fila);
}


function set_listado_filtrado(){
  var accion = 2;//opcion para seleccionar los datos del equipo
  var count_mostrados=0;
    $.post("ctrl/clientes.php"
      ,{"id":id_usuario_logueado 
        ,"limite":limite_paginacion
        ,"cursor":index_ultimo_registro
      ,"accion":accion 
      }
      ,function(respuesta){
          var listado_jugadores   = document.getElementById("tabla_datos_cuerpo");
          listado_jugadores.innerHTML = '';
          
          try {
            var json = $.parseJSON(respuesta);
            console.log(json);//muestro en consola
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


function get_usuario(id){
  var accion = 3;//opcion para seleccionar los datos del equipo
    $.post("ctrl/clientes.php"
      ,{"id":id 
      ,"accion":accion 
      }
      ,function(respuesta){
          var listado_jugadores          = document.getElementById("lista_usuarios");
          listado_jugadores.innerHTML = '';
          
          try {
            var json = $.parseJSON(respuesta);
            console.log(json);
            set_usuario_from_list(json[1],json[2],json[3],json[4],json[5],json[6],json[0],json[7]);
          } catch (error) {
            console.log(error);
            console.log(respuesta);
          }


      }); 
}

function set_usuario_from_list(txt_nombre,txt_apellido,txt_identificacion,txt_direccion,txt_user,txt_clave,id,id_persona){
  
  id_usuario_seleccionado = id;
  id_persona_seleccionado = id_persona;

  var txt_nombre_caja          = document.getElementById('txt_nombre');
  var txt_apellido_caja         = document.getElementById('txt_apellido');
  var txt_identificacion_caja   = document.getElementById('txt_identificacion');
  var txt_direccion_caja        = document.getElementById('txt_direccion');
  var txt_user_caja             = document.getElementById('txt_user');
  var txt_clave_caja            = document.getElementById('txt_clave');

  txt_nombre_caja.value =  txt_nombre  ;      
  txt_apellido_caja.value =  txt_apellido;     
  txt_identificacion_caja.value = txt_identificacion;
  txt_direccion_caja.value =    txt_direccion;  
  txt_user_caja.value =        txt_user;   
  txt_clave_caja.value =    txt_clave;

  index_ultimo_registro=0;
  set_listado_filtrado(0);

}


function get_eliminar_usuario(id_usuario,id_persona){
  var accion = 4;//opcion para seleccionar los datos del equipo
    $.post("ctrl/clientes.php"
      ,{"id_usuario":id_usuario 
      ,"id_persona":id_persona 
      ,"accion":accion 
      }
      ,function(respuesta){
          try {
            console.log(respuesta);
            set_listado_filtrado(0);
            id_usuario_seleccionado=0;
            id_persona_seleccionado=0;
            document.getElementById('txt_nombre').value ="";
            document.getElementById('txt_apellido').value="";
            document.getElementById('txt_identificacion').value="";
            document.getElementById('txt_direccion').value="";
            document.getElementById('txt_user').value="";
            document.getElementById('txt_clave').value="";
            alert("ELIMINADO");
          } catch (error) {
            console.log(error);
            console.log(respuesta);
          }

      }); 
}

function set_modificar_usuario(id_usuario,id_persona,){
  var txt_nombre          = document.getElementById('txt_nombre').value;
  var txt_apellido        = document.getElementById('txt_apellido').value;
  var txt_identificacion  = document.getElementById('txt_identificacion').value;
  var txt_direccion       = document.getElementById('txt_direccion').value;
  var txt_user            = document.getElementById('txt_user').value;
  var txt_clave           = document.getElementById('txt_clave').value;

  var accion = 5;//opcion para seleccionar los datos del equipo
    $.post("ctrl/clientes.php"
      ,{"id_usuario":id_usuario 
      ,"id_persona":id_persona 
      ,"txt_nombre":txt_nombre 
      ,"txt_apellido":txt_apellido 
      ,"txt_identificacion":txt_identificacion 
      ,"txt_direccion":txt_direccion 
      ,"txt_user":txt_user 
      ,"txt_clave":txt_clave 
      ,"accion":accion 
      }
      ,function(respuesta){
          try {
            console.log(respuesta);
            index_ultimo_registro=0;
            set_listado_filtrado(0);
            alert("MODIFICADO");
          } catch (error) {
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
               ruta = fichero_seleccionado2;
               objectURL_aux=ruta;
          }

          if((fichero_seleccionado!=null && fichero_seleccionado.length>0) && user_type==1){
              ruta = fichero_seleccionado2;
          }      
      }
  });
}
