<?php 
   
   if (!file_exists('../imagenes_subidas')) {
      mkdir('../imagenes_subidas', 0777);
    }

    move_uploaded_file($_FILES['file']['tmp_name'], '../imagenes_subidas/'. $_FILES['file']['name']);
    echo $_FILES['file']['name'];
?>