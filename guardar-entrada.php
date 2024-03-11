<?php
//logica para guardar la entrada
global $db;
if (isset($_POST)){
    require_once 'includes/conexion.php';

    $titulo= isset($_POST['titulo']) ? mysqli_real_escape_string($db,  $_POST['titulo']) : false; //Si existe la variable titulo que me llega por el metodo $_post y validamos que no venga ningun caracter malicioso entramos y si no es :  false
    $descripcion = isset($_POST['descripcion']) ? mysqli_real_escape_string($db, $_POST['descripcion']) : false;
    $categoria = isset($_POST['categoria']) ? (int)$_POST['categoria'] : false; //Si existe algo en categoria que me llega $_post y casteamos para que sea un int entrar y si no : false
    $usuario = $_SESSION['usuario']['id']; //Recogemos la variable usuario de la sesion


    //Validacion

    $errores = array();
    //Comprobamos que el titulo no este vacio.
    if(empty($titulo)){
      $errores['titulo'] = 'El titulo no es valido';
    }
    //Comprobamos que la descripcion no este vacia
    if (empty($descripcion)){
        $errores['descripcion'] = 'La descripcion no es valida';
    }
    //Comprobamos que la categoria no este vacia y no es numerica
    if (empty($categoria) && !is_numeric($categoria)){
        $errores['categoria'] = 'La categoria no es valida';
    }

    //Validacion ->  Si me llegan cero errores, voy a guardar la categoria en la BD
    if (count($errores) == 0){
        $sql = "INSERT INTO entradas VALUES (null, $usuario, $categoria, '$titulo', '$descripcion', CURDATE());";
        $guardar =  mysqli_query($db, $sql);
    }else{//En caso que se produsca un error -> guardar un session de errores entrada, y luego mostrarlos posteriormente
        $_SESSION["errores_entradas"] = $errores;
    }
}
//redireccion
header("Location: index.php");