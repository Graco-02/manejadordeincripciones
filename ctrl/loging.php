<?php

session_start();

if(count($_POST)>0){
    include_once("conecxion.php");

    $txt_user            = $_POST['txt_user'];
    $txt_clave           = $_POST['txt_clave'];
    set_validar_logging($txt_user,$txt_clave);
}


function set_validar_logging($user_name,$user_clave){
    $validacion = TRUE;
    //compruebo que los caracteres sean los permitidos
    set_validar_caracteres($user_name,$user_clave);

    if ($validacion  === TRUE ) {
        $hash_clave = hash('sha256', $user_clave);
        $conn = conectar();
        // Check connection
        if ($conn->connect_error) {
            $validacion=FALSE; 
            die("Connection failed: " . $conn->connect_error);
        }else{
            $sql = "SELECT  id,username,clave FROM usuarios where username='$user_name'"; 
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    if($hash_clave == $row["clave"] || $row["clave"] == $user_clave){
                        $_SESSION['usuario_logeado'] = $row["username"];
                        $_SESSION['usuario_logeado_id'] = $row["id"];
                        echo "CORRECTO";
                    } else {
                        $validacion=FALSE; 
                        echo "INCORRECTO CLAVE INCORRECTA";
                    }
                }			 
                
            } else {
                echo "INCORRECTO USUARIO INEXISTENTE";
               $validacion=FALSE; 
            }
    
            $conn->close();
        }
    }
    return $validacion;
}


function set_validar_caracteres($user_name,$user_clave){
    $validacion = TRUE;
    $permitidos = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789 ";
    for ($i=0; $i<strlen($user_name); $i++){
       if (strpos($permitidos, substr($user_name,$i,1))===false){
          echo 'NO SE ADMITEN CARATERES ILEGALES';
          $validacion = FALSE;
       }
    }

    for ($i=0; $i<strlen($user_clave); $i++){
        if (strpos($permitidos, substr($user_clave,$i,1))===false){
           echo 'NO SE ADMITEN CARATERES ILEGALES';
           $validacion = FALSE;
        }
     }

     return $validacion;
}

?>