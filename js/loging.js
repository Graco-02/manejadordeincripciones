function get_validar_acceso(){
    var txt_user             = document.getElementById('txt_user').value;
    var txt_clave            = document.getElementById('txt_clave').value;

    $.post("ctrl/loging.php"
        ,{"txt_user":txt_user 
        ,"txt_clave":txt_clave 
        }
        ,function(respuesta){            
            try {
              console.log(respuesta);
              if(respuesta=="CORRECTO"){
                alert("ACCESO ACEPTADO");
                location.href="inscripciones/manejador_clientes.php";
              }else{
                  alert(respuesta);
              }
            } catch (error) {
              console.log(error);
              console.log(respuesta);
            }
        }); 
}