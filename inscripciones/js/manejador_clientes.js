var id_usuario_seleccionado=0;
var id_persona_seleccionado=0;
var limite_paginacion=3;
var index_ultimo_registro=0;
var id_usuario_logueado=0;
let fichero_seleccionado ="" ;
var objectURL_aux="";
var total_inscriptos=0;
var lista_clientes_vencidos;
var cliente_selecionado;

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
            //console.log(json);//muestro en consola
            //llamo al metodo para cargar los datos del cliente seleccionado
            cliente_selecionado=json;
            set_cargar_datos_cliente_seleccionado(cliente_selecionado);
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
  id_persona_seleccionado=cliente_selecionado[6]; 

  document.getElementById("txt_nombre").value          = cliente_selecionado[0]; 
  document.getElementById("txt_apellido").value        = cliente_selecionado[1]; 
  document.getElementById("txt_identificacion").value  = cliente_selecionado[2]; 
  document.getElementById("txt_direccion").value       = cliente_selecionado[3]; 
  document.getElementById("txt_feccorte").value        = cliente_selecionado[4]; 
  document.getElementById("txt_cuota").value           = cliente_selecionado[5]; 

  if(json[7].length>0){
    //cargo la imagen desde bbdd
    $imagenPrevisualizacion.src =  "../imagenes_subidas/"+cliente_selecionado[7];
    objectURL_aux=cliente_selecionado[7];
    fichero_seleccionado=cliente_selecionado[7];
  }else{
      $imagenPrevisualizacion.src =  "../imagenes/usuario.png";
      objectURL_aux=cliente_selecionado[7];
      fichero_seleccionado=cliente_selecionado[7];
  }

  get_monto_pagado_desde();
 // console.log(cliente_selecionado[8]);//muestro en consola
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

function get_ventana_pago(){
  if(id_persona_seleccionado>0){
     document.getElementById("seccion_pago").classList.toggle("cerrado");
     document.getElementById("txt_monto_atrazo").value    = cliente_selecionado[8]; 

     if(cliente_selecionado[8]>0){
      document.getElementById("txt_dias_atrazo").value     = cliente_selecionado[9]; 
     }else{
      document.getElementById("txt_dias_atrazo").value     = 0; 
     }
  }else{
    alert("debe seleccionar un cliente primero");
  }
}

function set_cerrar_pago(){
  document.getElementById("seccion_pago").classList.toggle("cerrado");
}


function set_realizar_pago(){
  var monto_a_pagar =  document.getElementById("txt_monto_pago").value; 
  let monto_adeudado = cliente_selecionado[8];
  let fecha_corte    = cliente_selecionado[4]; 

  var comentario_pago = document.getElementById("txt_comentario_pago").value; 

  try{
    if(monto_a_pagar<=0){
        alert("debe informar un monto mayor que cero"); 
    }else{
      var accion = 1;//opcion para seleccionar los datos del equipo
        $.post("../pagos/ctrl/pagos.php"
          ,{"id_usuario":id_usuario_logueado 
          ,"id_persona":cliente_selecionado[10] //envio el id del cliente
          ,"monto_a_pagar":monto_a_pagar 
          ,"monto_adeudado":monto_adeudado 
          ,"fecha_corte":fecha_corte 
          ,"comentario_pago":comentario_pago 
          ,"accion":accion 
          }
          ,function(respuesta){
            try {
             // console.log(respuesta);//muestro en consola
              set_limpiar_campos();
              set_cerrar_pago();
              get_clientes_corte_vencido();
              if(respuesta=="CORRECTO"){
                  alert("Pago Recivido Gracias!!!");
              }
            } catch (error) {
                console.log(error);
                console.log(respuesta);
            }
          }); 
    }
  } catch (error) {
    console.log(error);
  }  
}


function set_limpiar_campos(){
  document.getElementById("txt_nombre").value          = ''; 
  document.getElementById("txt_apellido").value        = ''; 
  document.getElementById("txt_identificacion").value  = ''; 
  document.getElementById("txt_direccion").value       = ''; 
  document.getElementById("txt_feccorte").value        = ''; 
  document.getElementById("txt_cuota").value           = 0; 
  document.getElementById("txt_saldo").value           = 0; 
  id_persona_seleccionado=0;
}


function get_monto_pagado_desde(){
  //var saldo = document.getElementById("txt_saldo"); 
  let monto_adeudado = cliente_selecionado[8];
  let fecha_corte    = cliente_selecionado[4]; 
  try{
      var accion = 2;//opcion para seleccionar los datos del equipo
        $.post("../pagos/ctrl/pagos.php"
          ,{"id_persona":cliente_selecionado[10] 
          ,"fecha_corte":fecha_corte 
          ,"accion":accion 
          }
          ,function(respuesta){
            try {
              //console.log(cliente_selecionado[8]);//muestro en consola
            
              cliente_selecionado[8] = (monto_adeudado - respuesta);
              document.getElementById("txt_saldo").value   = cliente_selecionado[8]; 
            } catch (error) {
                console.log(error);
                console.log(respuesta);
            }
          }); 
  } catch (error) {
    console.log(error);
  }  
}