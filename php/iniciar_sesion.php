<?php 
    $usuario = limpiar_cadena($_POST['login_usuario']);
    $clave = limpiar_cadena($_POST['login_clave']);

    if($usuario==""||$clave==""){
        echo '
        <div class="notificacion is-danger is-ligh">
            no has llenado los campos obligatorios
        </div>
        ';  
        exit();
    }


    $check_user=conexion();
    $check_user=$check_user->query("SELECT * FROM usuario WHERE usuario_usuario='$usuario'");
    if($check_user->rowCount()==1){

    	$check_user=$check_user->fetch();

    	if($check_user['usuario_usuario']==$usuario && password_verify($clave, $check_user['usuario_clave'])){

    		$_SESSION['id']=$check_user['usuario_id'];
    		$_SESSION['nombre']=$check_user['usuario_nombre'];
    		$_SESSION['apellido']=$check_user['usuario_apellido'];
    		$_SESSION['usuario']=$check_user['usuario_usuario'];

    		if(headers_sent()){
				echo "<script> window.location.href='index.php?vista=home'; </script>";
			}else{
				header("Location: index.php?vista=home");
			}

    	}else{
    		echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                Usuario o clave incorrectos
	            </div>
	        ';
    	}
    }else{
    	echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Usuario o clave incorrectos
            </div>
        ';
    }
    $check_user=null;