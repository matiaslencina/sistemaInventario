<?php 
    require_once "main.php";

    $product_id=limpiar_cadena($_POST['img_del_id']);

    $check_producto=conexion();
    $check_producto=$check_producto->query("SELECT * FROM producto WHERE producto_id='$product_id'");

    if($check_producto->rowCount()==1){
        $datos=$check_producto->fetch();
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                la imagen del producto no existe en el sistema
            </div>
        ';
        exit();
    }
    $check_producto=null;

    /* Directorios de imagenes */
    $img_dir='../img/producto/';
    chmod($img_dir, 0777);

    if(is_file($img_dir.$datos['producto_foto'])){
        chmod($img_dir.$datos['producto_foto'], 0777);

        if(!unlink($img_dir.$datos['producto_foto'])){
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    la imagen del producto no se pudo eliminar
                </div>
            ';
            exit();
        }
    }

    $actualizar_producto=conexion();
    $actualizar_producto=$actualizar_producto->prepare("UPDATE producto SET producto_foto=:foto WHERE producto_id=:id");

    $marcadores=[
        ":foto"=>"",
        ":id"=>$product_id
    ];
    
    if($actualizar_producto->execute($marcadores)){
        echo '
            <div class="notification is-info is-light">
                <strong>¡IMAGEN ELIMINADA!</strong><br>
                producto actualizado
            </div>
        ';
    }else{
        echo '
            <div class="notification is-warning is-light">
                <strong>¡IMAGEN ELIMINADA!</strong><br>prodcut_
            </div>
        ';
    }
    $actualizar_producto=null;