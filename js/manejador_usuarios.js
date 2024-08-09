function completar_cedula(){
    var cedula = document.getElementById("txt_identificacion")
    if(cedula.value.length==3){
        cedula.value=cedula.value+"-";
    }else if(cedula.value.length==11){
        cedula.value=cedula.value+"-";
    }
}

function set_agregar(){
    var txt_nombre          = document.getElementById('txt_nombre').value;
    var txt_apellido        = document.getElementById('txt_apellido').value;
    var txt_identificacion  = document.getElementById('txt_identificacion').value;
    var txt_direccion       = document.getElementById('txt_direccion').value;
    var txt_user            = document.getElementById('txt_user').value;
    var txt_clave           = document.getElementById('txt_clave').value;
  
    
    var accion = 1;//opcion para seleccionar los datos del equipo
    $.post("../ctrl/usuarios.php"
    ,{"txt_nombre":txt_nombre 
    ,"txt_apellido":txt_apellido 
    ,"txt_identificacion":txt_identificacion 
    ,"txt_direccion":txt_direccion 
    ,"txt_user":txt_user 
    ,"txt_clave":txt_clave 
    ,"accion":accion 
    }
    ,function(respuesta){
      if(respuesta != 'AGREGADO CORRECTO'){
        alert('ERROR AGREGANDO  => '+respuesta);
      }else{
        alert('AGREGADO => '+respuesta);
        set_listado_filtrado(id);
      }
    });

  }


  function set_agregar_fila(nombre,apellido,identificacion,usuario,id){
    var tableRow = document.getElementById("lista_usuarios");
    var fila = document.createElement("tr");
    var celda1 = document.createElement("td");
    var celda2 = document.createElement("td");
    var celda3 = document.createElement("td");
    var celda4 = document.createElement("td");
    var celda5 = document.createElement("button");
    celda1.innerHTML = nombre;
    celda2.innerHTML = apellido;
    celda3.innerHTML = identificacion;
    celda4.innerHTML = usuario;
    celda5.innerHTML = 'ELIMINAR';

    celda1.onclick = function() {  alert(id); };
    celda5.onclick = function() {  alert(id); };

    fila.appendChild(celda1);
    fila.appendChild(celda2);
    fila.appendChild(celda3);
    fila.appendChild(celda4);
    fila.appendChild(celda5);
    tableRow.appendChild(fila);
}


function set_listado_filtrado(id){
  var accion = 2;//opcion para seleccionar los datos del equipo
    $.post("../ctrl/usuarios.php"
      ,{"id":id 
      ,"accion":accion 
      }
      ,function(respuesta){
          var listado_jugadores          = document.getElementById("lista_usuarios");
          listado_jugadores.innerHTML = '';
          
          try {
            var json = $.parseJSON(respuesta);
            console.log(json);
          } catch (error) {
            console.log(error);
            console.log(respuesta);
          }

          for(i=0;i<json.length;i++){
              console.log(json[i]);                
              set_agregar_fila(json[i][1],json[i][2],json[i][3],json[i][4],json[i][0]);
          }
      }); 
}