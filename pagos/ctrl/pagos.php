<?php


if(count($_POST)>0){

    include_once("../../ctrl/conecxion.php");
    $accion        = $_POST['accion'];

    switch ($accion) {
        case 1:
            //agregado de pago y actualziacion de corte
            $id_usuario                = $_POST["id_usuario"];
            $id_persona                = $_POST["id_persona" ];
            $monto_a_pagar             = $_POST["monto_a_pagar"];                 
            $monto_adeudado            = $_POST["monto_adeudado"];      
            $monto_adefecha_cortedado  = $_POST["fecha_corte"];     
            $comentario_pago           = $_POST["comentario_pago"];     
            set_realizar_pago($id_usuario,$id_persona,$monto_a_pagar,$monto_adeudado,$monto_adefecha_cortedado,$comentario_pago);
            break;
        case 2:
                $id_cliente                = $_POST["id_persona" ];
                $fecha_ini                 = $_POST["fecha_corte" ];
                get_monto_pagado_luego_de_fecha_dada($id_cliente,$fecha_ini);
                break;
        default:
            # code...
            break;
    }    
}

function set_realizar_pago($id_usuario,$id_persona,$monto_a_pagar,$monto_adeudado,$monto_adefecha_cortedado,$comentario_pago){
    $conn = conectar();
    $date = date('Y-m-d');
    $date_fec_corte = date("Y-m-d",strtotime($monto_adefecha_cortedado)); 
    $periodicidad =get_periodisidad($id_usuario);
    $nuevo_saldo=$monto_adeudado - $monto_a_pagar;

      // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if($nuevo_saldo<=0){
        $nueva_fecha = date("Y-m-d",strtotime($date_fec_corte."+ ".$periodicidad." days")); 
        $sql="UPDATE  clientes 
        SET feccorte="."'".$nueva_fecha."'".
        " WHERE id = ".$id_persona;
   
        if ($conn->query($sql) == TRUE) {
            set_insertar_pago($id_persona,$monto_a_pagar,$comentario_pago);
        }else{
            echo 'INCORRECTO';
        }
       // echo "nueva deuda = ".$nuevo_saldo." ".$nueva_fecha;
    }else{
        set_insertar_pago($id_persona,$monto_a_pagar,$comentario_pago);
    }
  
    $conn->close();	
}

function set_insertar_pago($id_persona,$monto_a_pagar,$comentario_pago){
    $conn = conectar();
    $date = date('Y-m-d');
          // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql="INSERT INTO pagos (id_cliente,monto,fecalta,comentario) 
    VALUES ($id_persona,$monto_a_pagar,'$date','$comentario_pago')";
   
    if ($conn->query($sql) == TRUE) {
      $id=$conn->insert_id;		
      echo 'CORRECTO';
    }else{
      echo 'INCORRECTO';
    }

    $conn->close();	
}


function get_periodisidad($id_usuario){
    $conn = conectar();
    $date = date('Y-m-d');
      // Check connection
     if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
     }
  
        $sql = "SELECT  periodisidad
        FROM configuraciones
        WHERE id_usuario=$id_usuario"; 
  
      $result = $conn->query($sql);
      $periodicidad=0;     
      if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc() ) {
          $periodicidad = $row["periodisidad"];
         //$ocurrancia = array();    
         //array_push($ocurrancia,$row["periodisidad"]);
         //echo json_encode($ocurrancia);
       }	 
      }
  
      $conn->close();	
      return $periodicidad;
}

function get_monto_pagado_luego_de_fecha_dada($id_cliente,$fecha_ini){
    $conn = conectar();
    $date = date('Y-m-d');
      // Check connection
     if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
     }
  
        $sql = "SELECT  sum(monto) as total
        FROM pagos
        WHERE id_cliente=$id_cliente AND fecalta>="."'".$fecha_ini."'"; 
  
      $result = $conn->query($sql);
   
      if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc() ) {
          $monto = $row["total"];
          echo $monto;
       }	 
      }
  
      $conn->close();	
}


?>