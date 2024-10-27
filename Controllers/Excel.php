<?php
class Excel extends Controller
{
    public function __construct() {
        session_start();        
        parent::__construct();
    }
    public function index() 
    {     
        if(empty($_SESSION['activo'])){
            header("location: ".base_url);
        }   
        else if($_SESSION['id_rol'] == 1 || $_SESSION['id_rol'] == 2){
            $this->views->getView($this, "index");
        }else{
            header("location: ".base_url."Dashboard");
        }
    }
    public function registrarEst()
    {        
        if(is_array($_FILES['file-estudiante']) && count($_FILES['file-estudiante']) > 0){
            //llamamos a la libreria
            require_once 'Assets\PHPExcel\Classes\PHPExcel.php';
            $excel = $_FILES['file-estudiante'];
            $name = $excel['name'];
            $tmpname = $excel['tmp_name'];
            //crear el excel
            $leerexcel = PHPExcel_IOFactory::createReaderForFile($tmpname);

            //cargar excel
            $excelobj = $leerexcel->load($tmpname);

            //cargar en que hoja
            $hoja = $excelobj->getSheet(0);
            $filas = $hoja->getHighestRow();
            $contador1 = 0;
            $contador2 = 0;
            $contador3 = 0;
            for($row = 2; $row<=$filas;$row++){
                $documento = trim($hoja->getCell('A'.$row)->getValue());                
                $numero = trim($hoja->getCell('B'.$row)->getValue());
                $apellido_paterno = trim($hoja->getCell('C'.$row)->getValue());
                $apellido_materno = trim($hoja->getCell('D'.$row)->getValue());
                $nombres = trim($hoja->getCell('E'.$row)->getValue());
                $genero = trim($hoja->getCell('F'.$row)->getValue());
                if($genero == "Mujer"){ 
                    $sexo = "M"; 
                }else{
                    $sexo = "H"; 
                }
                $fecha_nacimiento = trim($hoja->getCell('G'.$row)->getValue());
                $telefono = trim($hoja->getCell('H'.$row)->getValue());
                $correo = trim($hoja->getCell('I'.$row)->getValue());                
                                
                if(!empty($fecha_nacimiento)){
                    if(strlen($fecha_nacimiento)<=10){
                        list($dia,$mes,$anio) = explode("/",$fecha_nacimiento);
                        $fecha_formato = $anio."-".$mes."-".$dia;
                    }else{
                        $timestamp1 = PHPExcel_Shared_Date::ExcelToPHP($fecha_nacimiento);
                        $fecha_formato = date("Y-m-d",$timestamp1);
                    }                    
                }else{
                    $fecha_formato = "";
                }                
                
                if(strlen($numero) <= "20"){
                    if($sexo == "H" || $sexo == "M"){
                        $data = $this->model->RegistrarEstudiante($documento,$numero,$apellido_paterno,$apellido_materno,$nombres,$sexo,$fecha_formato,$telefono,$correo);
                        if($data == 1){
                            $contador1++;
                        }
                        else if($data == 2){
                            $contador2++;
                        }                   
                    }
                }                
                else{
                    $contador3++;                    
                }                                 
            }   
            $msg = $contador1.",".$contador2.",".$contador3;
        }          
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();  
    }
    public function registrarMatri()
    {
        if(is_array($_FILES['file-matricula']) && count($_FILES['file-matricula']) > 0){
            //llamamos a la libreria
            require_once 'Assets\PHPExcel\Classes\PHPExcel.php';
            $excel = $_FILES['file-matricula'];
            $name = $excel['name'];
            $tmpname = $excel['tmp_name'];
            //crear el excel
            $leerexcel = PHPExcel_IOFactory::createReaderForFile($tmpname);

            //cargar excel
            $excelobj = $leerexcel->load($tmpname);

            //cargar en que hoja
            $hoja = $excelobj->getSheet(0);
            $filas = $hoja->getHighestRow();
            $contador1 = 0;
            $contador2 = 0;
            $contador3 = 0;
            $contador4 = 0;
            $contador5 = 0;

            for($row = 2; $row<=$filas;$row++){
                $numero = trim($hoja->getCell('A'.$row)->getValue());  
                $niv = trim($hoja->getCell('B'.$row)->getValue());
                if($niv == "Inicial"){ $nivel = "I"; } else if($niv == "Primaria"){ $nivel = "P"; } else if($niv == "Secundaria"){ $nivel = "S"; } else{ $nivel = "";}                  
                $grado = trim($hoja->getCell('C'.$row)->getValue());
                $seccion = trim($hoja->getCell('D'.$row)->getValue());             
                
                if(strlen($numero) <= "20"){                                        
                    $id_estudiante = $this->model->getEstuCod($numero);  
                    $id_aula = $this->model->getAulaCod($nivel,$grado,$seccion);  
                    
                    if(empty($id_estudiante)){
                        $contador4++;
                    }else if(empty($id_aula)){
                        $contador5++;
                    }else{
                        $data = $this->model->RegistrarMatricula($id_estudiante['id'],$id_aula['id']);
                        if($data == 1){
                            $contador1++;
                        }
                        else if($data == 2){
                            $contador2++;
                        }
                    }                       
                }                
                else{
                    $contador3++;                    
                }                                 
            }              
            $total_error = $contador3 + $contador4 + $contador5;
            $msg = $contador1.",".$contador2.",".$total_error;
        }          
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();  
    }

    public function registrarPers()
    {        
        if(is_array($_FILES['file-personal']) && count($_FILES['file-personal']) > 0){
            //llamamos a la libreria
            require_once 'Assets\PHPExcel\Classes\PHPExcel.php';
            $excel = $_FILES['file-personal'];
            $name = $excel['name'];
            $tmpname = $excel['tmp_name'];
            //crear el excel
            $leerexcel = PHPExcel_IOFactory::createReaderForFile($tmpname);

            //cargar excel
            $excelobj = $leerexcel->load($tmpname);

            //cargar en que hoja
            $hoja = $excelobj->getSheet(0);
            $filas = $hoja->getHighestRow();
            $contador1 = 0;
            $contador2 = 0;
            $contador3 = 0;
            $contador4 = 0;
            $contador5 = 0;
            for($row = 2; $row<=$filas;$row++){
                $documento = trim($hoja->getCell('A'.$row)->getValue());                
                $numero = trim($hoja->getCell('B'.$row)->getValue());
                $apellidos = trim($hoja->getCell('C'.$row)->getValue());
                $nombres = trim($hoja->getCell('D'.$row)->getValue());
                $genero = trim($hoja->getCell('E'.$row)->getValue());
                if($genero == "Mujer"){ 
                    $sexo = "M"; 
                }else{
                    $sexo = "H"; 
                }
                $fecha_nacimiento = trim($hoja->getCell('F'.$row)->getValue());
                $direccion = trim($hoja->getCell('G'.$row)->getValue());
                $telefono = trim($hoja->getCell('H'.$row)->getValue());
                $correo = trim($hoja->getCell('I'.$row)->getValue()); 
                $especialidad = trim($hoja->getCell('J'.$row)->getValue());   
                $cargo = trim($hoja->getCell('K'.$row)->getValue());                
                
                
                if($fecha_nacimiento == ""){
                    $fecha_formato = "";
                    
                }
                else{
                    list($dia,$mes,$anio) = explode("/",$fecha_nacimiento);
                    $fecha_formato = $anio."-".$mes."-".$dia;
                }                           
                
                if(strlen($numero) <= "20"){
                    if($sexo == "H" || $sexo == "M"){
                        //Cargos
                        $id_cargo = $this->model->getCargoCod($cargo); 
                        if($id_cargo == ""){
                            $this->model->RegistrarCargo($cargo);
                            $id_cargo = $this->model->getCargoCod($cargo); 
                        } 
                        else{
                            $id_cargo = $id_cargo; 
                        } 

                        //Registrar Personal
                        if(!empty($id_cargo)){
                            $data = $this->model->RegistrarPersonal($documento,$numero,$apellidos,$nombres,$sexo,$fecha_formato,$direccion,$telefono,$correo,$especialidad,$id_cargo['id']);
                            if($data == 1){
                                $contador1++;
                            }
                            else if($data == 2){
                                $contador2++;
                            }                            
                        }else{
                            
                            $contador4++;
                        }               
                    }
                    else{
                        $contador5++;
                    }
                }                
                else{
                    $contador3++;                    
                }                                 
            } 
            $total_error = $contador3 + $contador4 + $contador5;
             
            $msg = $contador1.",".$contador2.",".$total_error;
        }          
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();  
    }

    public function registrarFam()
    {        
        if(is_array($_FILES['file-familia']) && count($_FILES['file-familia']) > 0){
            //llamamos a la libreria
            require_once 'Assets\PHPExcel\Classes\PHPExcel.php';
            $excel = $_FILES['file-familia'];
            $name = $excel['name'];
            $tmpname = $excel['tmp_name'];
            //crear el excel
            $leerexcel = PHPExcel_IOFactory::createReaderForFile($tmpname);

            //cargar excel
            $excelobj = $leerexcel->load($tmpname);

            //cargar en que hoja
            $hoja = $excelobj->getSheet(0);
            $filas = $hoja->getHighestRow();
            $contador1_familia = 0;
            $contador2_familia = 0;
            $contador1_detalle= 0;
            $contador2_detalle = 0;
            $contador3 = 0;
            $contador4 = 0;
            $contador5 = 0;
            $contador6 = 0;
            for($row = 2; $row<=$filas;$row++){
                $documento = trim($hoja->getCell('A'.$row)->getValue());                
                $numero = trim($hoja->getCell('B'.$row)->getValue());
                $apellidos = trim($hoja->getCell('C'.$row)->getValue());
                $nombres = trim($hoja->getCell('D'.$row)->getValue());
                $genero = trim($hoja->getCell('E'.$row)->getValue());
                if($genero == "Mujer"){ 
                    $sexo = "M"; 
                }else{
                    $sexo = "H"; 
                }
                $telefono = trim($hoja->getCell('F'.$row)->getValue());
                $correo = trim($hoja->getCell('G'.$row)->getValue()); 
                $parentesco = trim($hoja->getCell('H'.$row)->getValue());   
                $n_estudiante = trim($hoja->getCell('I'.$row)->getValue());                
                
                if(strlen($numero) <= "20"){
                    if($sexo == "H" || $sexo == "M"){
                        $data_familia = $this->model->RegistrarFamilia($documento,$numero,$apellidos,$nombres,$sexo,$telefono,$correo);
                        if($data_familia == 1){
                            $contador1_familia++;
                        }
                        else if($data_familia == 2){
                            $contador2_familia++;
                        }

                        $id_familia = $this->model->getFamCod($numero);   
                        $id_estudiante = $this->model->getEstuCod($n_estudiante);   
                        
                        if(empty($id_familia)){
                            $contador4++;                     
                        }
                        else if(empty($id_estudiante)){
                            $contador5++;                     
                        }else{
                            $data_detalle = $this->model->RegistrarDetalleFamilia($parentesco,$id_estudiante['id'],$id_familia['id']);
                            if($data_detalle == 1){
                                $contador1_detalle++;
                            }
                            else if($data_detalle == 2){
                                $contador2_detalle++;
                            }                            
                        }               
                    }
                    else{
                        $contador6++;
                    }
                }                
                else{
                    $contador3++;                    
                }                                 
            } 
            $total_error = $contador3 + $contador4 + $contador5 + $contador6;
            $nuevo = $contador1_familia + $contador1_detalle;
            $actualizado = $contador2_familia + $contador2_detalle;
            $msg = $nuevo.",".$actualizado.",".$total_error;
        }          
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();  
    }
}
?>