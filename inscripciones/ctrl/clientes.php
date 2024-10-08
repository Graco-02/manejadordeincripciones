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
                $criterio    = $_POST["criterio"];                 
                get_lista($id,$limite,$cursor,$criterio);
            break;       
        case 3:
          $id_usuario        = $_POST["id_usuario"];
          $id_cliente        = $_POST["id_cliente"];
          get_cliente($id_usuario,$id_cliente);
          break;     
        case 4:
            # opcion para actualziar. 
                $nombres                 = $_POST["nombres"];
                $apellidos               = $_POST["apellidos" ];
                $identificacion          = $_POST["identificacion"]; 
                $direccion               = $_POST["direccion" ];
                $feccorte                = $_POST["feccorte"]; 
                $monto                   = $_POST["monto" ];
                $url_img                 = $_POST["url_img"]; 
                $usuario                 = $_POST["usuario"]; 
                $id_persona_seleccionado = $_POST["id_persona_seleccionado"]; 
                set_update_persona($nombres, $apellidos , $identificacion,$direccion,$usuario,$url_img,$feccorte,$monto, $id_persona_seleccionado);
            break;   
        case 5:
              $id_usuario   = $_POST["id_usuario"];
              get_conteo_clientes_activos($id_usuario);
              break;
        case 6:
              $id_usuario  = $_POST["id_usuario"];
              $id_persona  = $_POST["id_persona"];
              set_borrar_persona($id_persona ,$id_usuario);              
            break;        
        case 7:
              $id_usuario  = $_POST["id_usuario"];
              get_clientes_corte_vencido($id_usuario) ;            
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

function get_lista($id,$limite,$cursor,$criterio){
    $conn = conectar();
      // Check connection
     if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
     }
 
        $sql ="";
        if(strlen($criterio)==0){
          $sql = "SELECT p.id as id,p.nombres as nombres,p.apellidos as apellidos,p.identificacion as identificacion,p.direccion as direccion,c.feccorte as feccorte, c.cuota as cuota 
          FROM persona p, clientes c 
          WHERE p.id = c.id_persona and c.id_usuario=$id
          LIMIT ".$limite." OFFSET $cursor"; 
        }else{    
           $sql = "SELECT p.id as id,p.nombres as nombres,p.apellidos as apellidos,p.identificacion as identificacion,p.direccion as direccion,c.feccorte as feccorte, c.cuota as cuota 
          FROM persona p, clientes c 
          WHERE p.id = c.id_persona and c.id_usuario=$id 
          and (p.nombres like "."'%".$criterio."%'"." or p.apellidos like "."'%".$criterio."%'"." or p.identificacion like "."'%".$criterio."%'".")"." 
          LIMIT ".$limite." OFFSET $cursor"; 
        }

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


 function get_cliente($id_usuario,$id_cliente){
  $conn = conectar();
  $date = date('Y-m-d');
    // Check connection
   if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
   }

      $sql = "SELECT p.id as id,p.nombres as nombres,p.apellidos as apellidos,
      p.identificacion as identificacion,p.direccion as direccion,
      c.feccorte as feccorte, c.cuota as cuota, p.foto_url as  foto_url, conf.periodisidad, c.id as id_cliente
      FROM persona p, clientes c , configuraciones conf
      WHERE p.id = c.id_persona and c.id_usuario=$id_usuario and p.id =$id_cliente and conf.id_usuario=$id_usuario"; 

    $result = $conn->query($sql);
    $count=1;     
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc() ) {
        
       $ocurrancia = array();    
       array_push($ocurrancia,$row["nombres"]);
       array_push($ocurrancia,$row["apellidos"]);
       array_push($ocurrancia,$row["identificacion"]);
       array_push($ocurrancia,$row["direccion"]);
       array_push($ocurrancia,$row["feccorte"]);
       array_push($ocurrancia,$row["cuota"]);
       array_push($ocurrancia,$row["id"]);
       array_push($ocurrancia,$row["foto_url"]);
       
       $diff = strtotime($row["feccorte"]) - strtotime($date);
       $dias_aux = $diff/(60*60*24);
       $dias = $diff/(60*60*24);
       if($dias > ($row["periodisidad"]*-1)){
        $dias = $row["periodisidad"];
       }else{
        $dias = $dias*-1;
       }

       if($dias_aux<0){
          array_push($ocurrancia, (($dias) / $row["periodisidad"]) * $row["cuota"]);//monto en atrazo
       }else{
        array_push($ocurrancia, 0);//monto en atrazo
       }

       array_push($ocurrancia,$dias);//dias en atrazo
       array_push($ocurrancia,$row["id_cliente"]);
       echo json_encode($ocurrancia);
     }	 
    }

    $conn->close();	
}


function set_update_persona($nombres, $apellidos , $identificacion,$direccion,$usuario,$url_img,$feccorte,$monto,$id_persona){
  $conn = conectar();
  $date = date('Y-m-d');

  $sql="UPDATE  persona 
        SET nombres="."'".$nombres."'".",".
        "apellidos="."'".$apellidos."'".",".
        "identificacion="."'".$identificacion."'".",".
        "direccion="."'".$direccion."'".",".
        "foto_url="."'".$url_img."'".
        " WHERE id = ".$id_persona;
 
  if ($conn->query($sql) == TRUE) {
      $sql="UPDATE  clientes 
      SET feccorte="."'".$feccorte."'".",".
      "cuota=".$monto.
      " WHERE id_persona = ".$id_persona;

      if ($conn->query($sql) == TRUE) {
          echo  'MODIFICACION REALIZADA';
      }else{
          echo 'INCORRECTO';
      }
  }else{
      echo 'INCORRECTO';
  }
  $conn->close();	
}

function set_borrar_persona($id_persona,$usuario){
  $conn = conectar();
  $date = date('Y-m-d');

  $sql="DELETE FROM clientes WHERE id_persona =".$id_persona." AND id_usuario =".$usuario;

  if ($conn->query($sql) == TRUE) {
      $sql="DELETE FROM Persona WHERE id = ".$id_persona;

      if ($conn->query($sql) == TRUE) {
          echo  'CORRECTO';
      }else{
          echo 'INCORRECTO';
      }
  }else{
      echo 'INCORRECTO';
  }
  $conn->close();	
}

function get_conteo_clientes_activos($id_usuario){
  $conn = conectar();
    // Check connection
   if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
   }

      $sql = "SELECT  count(*) as total FROM clientes WHERE id_usuario=$id_usuario AND estado=0;"; 

    $result = $conn->query($sql);
    $count=0;     
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc() ) {
         echo $row["total"];
        }	 
    }

    $conn->close();	
}


function get_clientes_corte_vencido($id){
  $date = date('Y-m-d');
  $conn = conectar();
  // Check connection
 if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
 }

    $sql = "SELECT p.id as id,p.nombres as nombres,p.apellidos as apellidos,
    p.identificacion as identificacion,p.direccion as direccion,
    c.feccorte as feccorte, c.cuota as cuota , conf.periodisidad
    FROM persona p, clientes c , configuraciones conf
    WHERE p.id = c.id_persona and c.id_usuario=$id"; 

  $result = $conn->query($sql);
  $count=1;   
  $lista_total = array();        
  if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc() ) { 
          $diff = strtotime($row["feccorte"]) - strtotime($date);
          $dias = $diff/(60*60*24);
          if($dias<=0){
             if($dias > ($row["periodisidad"]*-1)){
              $dias = $row["periodisidad"];
             }else{
              $dias = $dias*-1;
             }

             $ocurrancia = array();   
             array_push($ocurrancia,$row["nombres"]);
             array_push($ocurrancia,$row["apellidos"]);
             array_push($ocurrancia,$row["identificacion"]);
             array_push($ocurrancia,$row["feccorte"]);
             array_push($ocurrancia,$row["cuota"]);
             array_push($ocurrancia,$row["id"]);
             array_push($ocurrancia,$row["periodisidad"]);
             array_push($ocurrancia, $dias);//dias_atrazo
             array_push($ocurrancia, (($dias) / $row["periodisidad"]) * $row["cuota"]);//monto en atrazo
             array_push($lista_total,$ocurrancia);
          }
      }	 
   echo json_encode($lista_total);
  }

  $conn->close();	
}

?>