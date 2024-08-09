<?php

if(count($_POST)>0){
    include_once("conecxion.php");
    $accion        = $_POST['accion'];


    switch ($accion) {
        case 1:
            # opcion para agregar. 
            $txt_nombre          = $_POST['txt_nombre'];
            $txt_apellido        = $_POST['txt_apellido'];
            $txt_identificacion  = $_POST['txt_identificacion'];
            $txt_direccion       = $_POST['txt_direccion'];
            $txt_user            = $_POST['txt_user'];
            $txt_clave           = $_POST['txt_clave'];

            set_insertar_persona($txt_nombre, $txt_apellido , $txt_identificacion,$txt_direccion,$txt_user,$txt_clave);
            break;
         
        case 2:
            $id          = $_POST['id'];
            get_lista($id);
            break;    
        default:
            # code...
            break;
    }
}


function set_insertar_persona($txt_nombre, $txt_apellido , $txt_identificacion,$txt_direccion,$txt_user,$txt_clave){
    $conn = conectar();
    $date = date('Y-m-d');

    $sql="INSERT INTO persona (nombres,apellidos,identificacion,direccion,fecalta) 
    VALUES ('$txt_nombre', '$txt_apellido' , '$txt_identificacion','$txt_direccion','$date')";
   
    if ($conn->query($sql) == TRUE) {
      $id=$conn->insert_id;		
      set_insertar_usuario($id,$txt_user,$txt_clave);
    }else{
      echo 'AGREGADO INCORRECTO';
    }
}


function set_insertar_usuario($id_persona,$txt_user,$txt_clave){
    $conn = conectar();
    $date = date('Y-m-d');

    $sql="INSERT INTO usuarios (id_persona,username,clave,fecalta,estado) 
    VALUES ($id_persona,'$txt_user', '$txt_clave' , '$date',0)";
   
    if ($conn->query($sql) == TRUE) {
      $id=$conn->insert_id;		
        echo  'AGREGADO CORRECTO';
    }else{
        echo 'AGREGADO INCORRECTO';
    }
}


function get_lista($id){
    $conn = conectar();
      // Check connection
     if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
     }
 
     $sql = "";
     if($id>0){
        $sql = "SELECT usuarios.id as id,per.nombres as nombres,per.apellidos as apellidos,per.identificacion as identificacion,usuarios.username as username
                FROM usuarios usuarios, persona per
                WHERE usuarios.id = ".$id." AND usuarios.id_persona = per.id;
        "; 
     }else{
        $sql = "SELECT usuarios.id as id,per.nombres as nombres,per.apellidos as apellidos,per.identificacion as identificacion,usuarios.username as username
                FROM usuarios usuarios, persona per
                WHERE usuarios.id_persona = per.id;
        "; 
     }
  
      $result = $conn->query($sql);
      $count=1;   
      $lista_usuarios = array();        
      if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc() ) {
          
         $usuario = array();    
         array_push($usuario,$row["id"]);
         array_push($usuario,$row["nombres"]);
         array_push($usuario,$row["apellidos"]);
         array_push($usuario,$row["identificacion"]);
         array_push($usuario,$row["username"]);

         array_push($lista_usuarios,$usuario);
       }	 
       echo json_encode($lista_usuarios);
      }

      $conn->close();	
 }

?>