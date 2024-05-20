function abrir_formulario(){
  var div_formulario = document.getElementById('formulario_incripcion');
  div_formulario.classList.toggle('cerrado');
}

function set_validar_longitudes(){
  var inscripcion_nombres        = document.getElementById('inscripcion_nombres').value;
  var inscripcion_apellidos      = document.getElementById('inscripcion_apellidos').value;
  var inscripcion_identificacion = document.getElementById('inscripcion_identificacion').value;
  var fecha_nacimiento           = document.getElementById('fecha_nacimiento').value;
  var cuota                      = document.getElementById('cuota').value;

  if(inscripcion_nombres.length<3){
     alert("la longitud del nombre debe ser mayor o igual a 3 caracteres");
     document.getElementById('inscripcion_nombres').focus();
     return false;
  }else if(inscripcion_apellidos.length<3){
    alert("la longitud del apellido debe ser mayor o igual a 3 caracteres");
    document.getElementById('inscripcion_apellidos').focus();
    return false;
  }else if(inscripcion_identificacion.length>0 && inscripcion_identificacion.length<11){
    alert("la longitud de la identificacion debe ser mayor o igual a 11 caracteres");
    document.getElementById('inscripcion_identificacion').focus();
    return false;
  }else if(fecha_nacimiento.length>10){
    alert("debe informar fecha de nacimiento");
    document.getElementById('fecha_nacimiento').focus();
    return false;
  }else if(cuota.length<0 && cuota>0){
    alert("debe informar una cuota");
    document.getElementById('cuota').focus();
    return false;
  }

  return true;
}


function set_agregar(){
  var inscripcion_nombres        = document.getElementById('inscripcion_nombres').value;
  var inscripcion_apellidos      = document.getElementById('inscripcion_apellidos').value;
  var inscripcion_identificacion = document.getElementById('inscripcion_identificacion').value;
  var fecha_nacimiento           = document.getElementById('fecha_nacimiento').value;
  var cuota                      = document.getElementById('cuota').value;
  var cabecera_1_span_label_cantidad_txt  = document.getElementById('cabecera_1_span_label_cantidad');
  var cabecera_1_span_label_cantidad_value =  parseInt(document.getElementById('cabecera_1_span_label_cantidad').innerHTML);

  if(set_validar_longitudes()){
   
    var accion = 1;//opcion para seleccionar los datos del equipo
        $.post("ctrl/inscripciones.php"
        ,{"inscripcion_nombres":inscripcion_nombres 
        ,"inscripcion_apellidos":inscripcion_apellidos 
        ,"inscripcion_identificacion":inscripcion_identificacion 
        ,"fecha_nacimiento":fecha_nacimiento 
        ,"cuota":cuota 
        ,"accion":accion 
        }
        ,function(respuesta){
          if(respuesta != 'AGREGADO CORRECTO'){
            alert('ERROR AGREGANDO HISTORICO => '+respuesta);
          }else{
            alert('AGREGANDO => '+respuesta);
            cabecera_1_span_label_cantidad_value+=1;
            cabecera_1_span_label_cantidad_txt.innerHTML = cabecera_1_span_label_cantidad_value;
          }
        });
  }
}


function get_total_inscritos(){
  var accion = 2;//opcion para seleccionar los datos del equipo
  var cabecera_1_span_label_cantidad_txt  = document.getElementById('cabecera_1_span_label_cantidad');
  $.post("ctrl/inscripciones.php"
  ,{"accion":accion 
  }
  ,function(respuesta){
      cabecera_1_span_label_cantidad_txt.innerHTML = respuesta;
  });
}