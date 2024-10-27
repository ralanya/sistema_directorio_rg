<?php 
    require_once "Config/Config.php";
    $ruta = !empty($_GET['url']) ? $_GET['url'] : "Home/index";
    $array = explode("/", $ruta);
    //print_r($array);
    $controller = $array[0];
    $metodo = "index";
    $parametro = "";
    if (!empty($array[1])) {
        if(!empty($array[1] != "")){
            $metodo = $array[1];
        }
    }
    if(!empty($array[2])){
        if(!empty($array[2] != "")){
            for ($i=2; $i < count($array) ; $i++) { 
                $parametro .= $array[$i]. ",";
            }  
            $parametro = trim($parametro, ",");          
        }
    }    
    require_once "Config/App/autoload.php";
    $dirContollers = "Controllers/".$controller.".php";
    if (file_exists($dirContollers)) {
        require_once $dirContollers;
        $controller = new $controller();
        if (method_exists($controller, $metodo)) {
            $controller->$metodo($parametro);
        }else{
            echo "No existe el método";
        }
    }else{
        echo "No existe el controlador";
    }
?>