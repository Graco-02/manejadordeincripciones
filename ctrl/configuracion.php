<?php 



if(count($_POST)>0){

    include_once("conecxion.php");

    $accion = $_POST['accion'];

    switch ($accion) {
        case 1:
            $id_user        = $_POST['id_user'];
            $periodo_select = $_POST['periodo_select'];
            $cfg_feccorte   = $_POST['cfg_feccorte'];
            $cfg_cuota      = $_POST['cfg_cuota'];
            set_actualizar($id_user,$periodo_select,$cfg_feccorte,$cfg_cuota);
            break;
        default:
            # code... devuelvo los datos de configuracion del usuario
            $id_user = $_POST['id_user'];
            get_configuracion_user($id_user);
            break;
    }
}

function get_configuracion_user($id_user){
    $conn = conectar();
    // Check connection
   if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
   }

    $sql = "SELECT * FROM configuraciones WHERE id_usuario = $id_user";

    $result = $conn->query($sql);
    $count=1;   
    $lista_total = array();        
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc() ) {
        
       $ocurrancia = array();    
       array_push($ocurrancia,$row["periodisidad"]);
       array_push($ocurrancia,$row["fecha_corte"]);
       array_push($ocurrancia,$row["cuota"]);
       array_push($ocurrancia,$row["id_usuario"]);
       array_push($lista_total,$ocurrancia);
     }	 
     echo json_encode($lista_total);
    }

    $conn->close();	
}

function set_actualizar($id_user,$periodo_select,$cfg_feccorte,$cfg_cuota){
      $conn = conectar();
  $date = date('Y-m-d');

  $sql="UPDATE  configuraciones 
        SET periodisidad="."'".$periodo_select."'".",".
        "fecha_corte="."'".$cfg_feccorte."'".",".
        "cuota="."'".$cfg_cuota."'".
        " WHERE id_usuario = ".$id_user;
 
  if ($conn->query($sql) == TRUE) {
      echo  'MODIFICACION REALIZADA';
  }else{
      echo 'INCORRECTO';
  }
  $conn->close();	
}

?>