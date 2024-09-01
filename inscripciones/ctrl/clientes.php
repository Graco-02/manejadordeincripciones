<?php

if(count($_POST)>0){
    include_once("../../ctrl/conecxion.php");
    $accion        = $_POST['accion'];


    switch ($accion) {
        case 1:
            # opcion para agregar. 
                $nombres        = $_POST["nombres"];
                $apellidos      = $_POST["apellidos" ];
                $identificacion = $_POST["identificacion"]; 
                $direccion      = $_POST["direccion" ];
                $feccorte       = $_POST["feccorte"]; 
                $monto          = $_POST["monto" ];
                $url_img        = $_POST["url_img"]; 
                $usuario        = $_POST["usuario"]; 

                set_insertar_persona($nombres, $apellidos , $identificacion,$direccion,$usuario,$url_img,$feccorte,$monto);
            break;
            
        case 2:
                # opcion para listar.
                $id        = $_POST["id"];
                $limite    = $_POST["limite" ];
                $cursor    = $_POST["cursor"];                 
                get_lista($id,$limite,$cursor);
            break;                 
        default:
            # code...
            break;
    }
}


function set_insertar_persona($nombres, $apellidos , $identificacion,$direccion,$usuario,$url_img,$feccorte,$monto){
    $conn = conectar();
    $date = date('Y-m-d');

    $sql="INSERT INTO persona (nombres,apellidos,identificacion,direccion,fecalta,foto_url) 
    VALUES ('$nombres', '$apellidos' , '$identificacion','$direccion','$date','$url_img')";
   
    if ($conn->query($sql) == TRUE) {
      $id=$conn->insert_id;	
      set_insertar_relacion_cliente($id,$usuario,$feccorte,$monto);	
    }else{
      echo 'AGREGADO INCORRECTO';
    }
}

function set_insertar_relacion_cliente($i_persona,$id_usuario,$feccorte,$monto){
    $conn = conectar();
    $date = date('Y-m-d');

    $sql="INSERT INTO clientes (id_persona,id_usuario,feccorte,cuota,fecalta,estado) 
    VALUES ($i_persona,$id_usuario,'$feccorte',$monto,'$date',0)";
   
    if ($conn->query($sql) == TRUE) {
      $id=$conn->insert_id;		
      echo 'AGREGADO CORRECTO';
    }else{
      echo 'AGREGADO INCORRECTO';
    }
}

function get_lista($id,$limite,$cursor){
    $conn = conectar();
      // Check connection
     if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
     }
 
        $sql = "SELECT p.id as id,p.nombres as nombres,p.apellidos as apellidos,p.identificacion as identificacion,p.direccion as direccion,c.feccorte as feccorte, c.cuota as cuota 
        FROM persona p, clientes c 
        WHERE p.id = c.id_persona and c.id_usuario=$id
        LIMIT ".$limite." OFFSET $cursor"; 

      $result = $conn->query($sql);
      $count=1;   
      $lista_total = array();        
      if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc() ) {
          
         $ocurrancia = array();    
         array_push($ocurrancia,$row["nombres"]);
         array_push($ocurrancia,$row["apellidos"]);
         array_push($ocurrancia,$row["identificacion"]);
      //   array_push($ocurrancia,$row["direccion"]);
         array_push($ocurrancia,$row["feccorte"]);
         array_push($ocurrancia,$row["cuota"]);
         array_push($ocurrancia,$row["id"]);
         array_push($lista_total,$ocurrancia);
       }	 
       echo json_encode($lista_total);
      }

      $conn->close();	
 }


?>