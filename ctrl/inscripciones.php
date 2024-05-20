<?php

if(count($_POST)>0){
    include_once("conecxion.php");
    $accion        = $_POST['accion'];


    switch ($accion) {
        case 1:
            # opcion para agregar. 
            $inscripcion_nombres           =  $_POST['inscripcion_nombres'];      
            $inscripcion_apellidos         =  $_POST['inscripcion_apellidos'];
            $inscripcion_identificacion    =  $_POST['inscripcion_identificacion'];
            $fecha_nacimiento              =  $_POST['fecha_nacimiento'];
            $cuota                         =  $_POST['cuota'];

            //$inscripcion_nombres, $inscripcion_apellidos , $inscripcion_identificacion,$fecha_nacimiento   
            set_insertar_inscripcion($inscripcion_nombres, $inscripcion_apellidos , $inscripcion_identificacion,$fecha_nacimiento,$cuota);       
            break;
         
        case 2:
            get_total_inscritos();
            break;    
        default:
            # code...
            break;
    }
}


function set_insertar_inscripcion($inscripcion_nombres, $inscripcion_apellidos , $inscripcion_identificacion,$fecha_nacimiento,$cuota){
    $conn = conectar();
    $sql="INSERT INTO clientes (nombres,apellidos,identificacion,fecha_nacimiento,cuota) 
    VALUES ('$inscripcion_nombres', '$inscripcion_apellidos' , '$inscripcion_identificacion','$fecha_nacimiento',$cuota)";
   
    if ($conn->query($sql) == TRUE) {
      $id=$conn->insert_id;		
        echo  'AGREGADO CORRECTO';
    }else{
        echo 'AGREGADO INCORRECTO';
    }
}

function get_total_inscritos(){
    $conn = conectar();
      // Check connection
     if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
     }
  
     $sql = "SELECT count(*) as total
     from clientes " ; 
  
      $result = $conn->query($sql);
      $count=0;         
      $jugadores_array = array();   
      if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc() ) {
            $count = $row['total'];
          }		 
      }
        $conn->close();
        echo $count;
  }


?>