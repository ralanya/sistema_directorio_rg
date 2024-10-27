<?php
class Estudiantes extends Controller
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
        $this->views->getView($this, "index");
    }
    
    public function listar()
    {
        $id_rol = $_SESSION['id_rol'];
        $data = $this->model->getEstudiantes();
        for ($i=0; $i < count($data); $i++) { 
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';                
                if($id_rol == 1){
                    $data[$i]['acciones'] = '<div> 
                    <button class="btn btn-warning p-1 center-block" type="button" onclick="btnDetalleEst('.$data[$i]['id'].');" title="Detalles"><i class="fas fa-eye"></i></button>          
                    <button class="btn btn-primary p-1" type="button" onclick="btnEditarEst('.$data[$i]['id'].');" title="Editar"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-danger p-1" type="button" onclick="btnEliminarEst('.$data[$i]['id'].');" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
                    </div>';
                }else if($id_rol == 2){
                    $data[$i]['acciones'] = '<div> 
                    <button class="btn btn-warning p-1 center-block" type="button" onclick="btnDetalleEst('.$data[$i]['id'].');" title="Detalles"><i class="fas fa-eye"></i></button>          
                    <button class="btn btn-primary p-1" type="button" onclick="btnEditarEst('.$data[$i]['id'].');" title="Editar"><i class="fas fa-edit"></i></button>
                    </div>';
                }
                else{
                    $data[$i]['acciones'] = '<div> 
                    <button class="btn btn-warning p-1" type="button" onclick="btnDetalleEst('.$data[$i]['id'].');" title="Detalles"><i class="fas fa-eye"></i></button>          
                    </div>';
                }             
            }else{
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                if($id_rol == 1){
                    $data[$i]['acciones'] = '<div>
                    <button class="btn btn-warning p-1" type="button" onclick="btnDetalleEst('.$data[$i]['id'].');" title="Detalles"><i class="fas fa-eye"></i></button>          
                    <button class="btn btn-success p-1" type="button" onclick="btnReingresarEst('.$data[$i]['id'].');" title="Reingresar"><i class="fas fa-sign-in-alt"></i></button>
                    </div>';
                }else{
                    $data[$i]['acciones'] = '<div>
                    <button class="btn btn-warning p-1" type="button" onclick="btnDetalleEst('.$data[$i]['id'].');" title="Detalles"><i class="fas fa-eye"></i></button>          
                    </div>';
                }
            }             
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrar()
    {
        //estudiante
        $documento = $_POST['cbodocumento'];
        $numero = $_POST['txtnumero'];
        $apellido_paterno = $_POST['txtapellidopaterno'];
        $apellido_materno = $_POST['txtapellidomaterno'];
        $nombres = $_POST['txtnombres'];
        $sexo = $_POST['cbosexo'];        
        $fecha_nacimiento = $_POST['txtfecha'];
        $telefono = $_POST['txttelefono'];
        $correo = $_POST['txtcorreo'];
        $id = $_POST['txtid']; 
        
        //matricula
        $nivel = $_POST['cbonivel'];
        $grad = $_POST['cbogrado'];
        if($grad == "3"){
            $grado = "3 AÑOS";
        }
        else if($grad == "4"){
            $grado = "4 AÑOS";
        }else{
            $grado = $grad;
        }
        $seccion = $_POST['cboseccion'];
        
        //familia
        $documentopadre = $_POST["cbodocumentopadre"];        
        $numeropadre = $_POST["txtnumeropadre"];  
        $apellidospadre = $_POST["txtapellidospadre"];  
        $nombrespadre = $_POST["txtnombrespadre"];  
        $sexopadre = $_POST["cbosexopadre"];   
        $parentescopadre = $_POST["txtparentescopadre"];   
        $telefonopadre = $_POST["txttelefonopadre"];
        $correopadre = $_POST["txtcorreopadre"];

        $documentomadre = $_POST["cbodocumentomadre"];        
        $numeromadre = $_POST["txtnumeromadre"];
        
        $apellidosmadre = $_POST["txtapellidosmadre"];  
        $nombresmadre = $_POST["txtnombresmadre"];  
        $sexomadre = $_POST["cbosexomadre"];   
        $parentescomadre = $_POST["txtparentescomadre"];   
        $telefonomadre = $_POST["txttelefonomadre"];
        $correomadre = $_POST["txtcorreomadre"];
        
        if (empty($numero) || empty($apellido_paterno) || empty($apellido_materno) 
        || empty($nombres) || empty($fecha_nacimiento)) {
            $msg = array('msg' => '(*) Los campos son obligatorios', 'icono' => 'warning');
        }else{
            if ($id == "") {
                $data = $this->model->registrarEstudiante($documento, $numero, $apellido_paterno, $apellido_materno, $nombres, $sexo, $fecha_nacimiento, $telefono, $correo);
                
                //matricula
                $id_estudiante = $this->model->getEstuCod($numero);
                $id_aula = $this->model->getAulaCod($nivel,$grado,$seccion); 
                
                if(empty($id_estudiante)){
                    $msg = array('msg' => 'Error', 'icono' => 'error');
                }
                else if(empty($id_aula)){
                    $msg = array('msg' => 'Error', 'icono' => 'error');
                }
                else{
                    $datamatricula = $this->model->RegistrarMatricula($id_estudiante['id'],$id_aula['id']);
                }
                //fin matricula

                //familia                   
                $id_estudiante = $this->model->getEstuCod($numero);                
                $data_padre = $this->model->RegistrarFamilia($documentopadre,$numeropadre,$apellidospadre,$nombrespadre,$sexopadre,$telefonopadre,$correopadre);
                $id_familia_padre = $this->model->getFamCod($numeropadre);

                if(empty($id_familia_padre)){
                    $msg = array('msg' => 'Error', 'icono' => 'error');                    
                }else if(empty($id_estudiante)){
                    $msg = array('msg' => 'Error', 'icono' => 'error');               
                }else{
                    $data_detalle_padre = $this->model->RegistrarDetalleFamilia($parentescopadre,$id_estudiante['id'],$id_familia_padre['id']);
                }                   

                $data_madre = $this->model->RegistrarFamilia($documentomadre,$numeromadre,$apellidosmadre,$nombresmadre,$sexomadre,$telefonomadre,$correomadre);
                $id_familia_madre = $this->model->getFamCod($numeromadre);   
                if(empty($id_familia_madre)){
                    $msg = array('msg' => 'Error', 'icono' => 'error');                   
                }else if(empty($id_estudiante)){
                    $msg = array('msg' => 'Error', 'icono' => 'error');               
                }else{
                    $data_detalle_madre = $this->model->RegistrarDetalleFamilia($parentescomadre,$id_estudiante['id'],$id_familia_madre['id']);
                }                    

                //fin familia
                if ($data == "ok") {
                    $msg = array('msg' => 'Estudiante registrado con éxito', 'icono' => 'success');
                }else if($data == "existe"){
                    $msg = array('msg' => 'El estudiante ya existe', 'icono' => 'warning');
                }else{
                    $msg = array('msg' => 'Error al guardar', 'icono' => 'error');
                }                              
            }else{
                $data = $this->model->modificarEstudiante($documento, $numero, $apellido_paterno, $apellido_materno, $nombres, $sexo, $fecha_nacimiento, $telefono, $correo,$id);
                
                //matricula
                $id_estudiante = $this->model->getEstuCod($numero);
                $id_aula = $this->model->getAulaCod($nivel,$grado,$seccion); 
                
                if(empty($id_estudiante)){
                    $msg = array('msg' => 'Error', 'icono' => 'error');
                }else if(empty($id_aula)){
                    $msg = array('msg' => 'Error', 'icono' => 'error');
                }else{
                    $datamatricula = $this->model->RegistrarMatricula($id_estudiante['id'],$id_aula['id']);
                }
                //fin matricula

                //familia
                $id_estudiante = $this->model->getEstuCod($numero);                
                $data_padre = $this->model->RegistrarFamilia($documentopadre,$numeropadre,$apellidospadre,$nombrespadre,$sexopadre,$telefonopadre,$correopadre);
                $id_familia_padre = $this->model->getFamCod($numeropadre);
                
                if(empty($id_familia_padre)){
                    $msg = array('msg' => 'Error', 'icono' => 'error');                     
                }else if(empty($id_estudiante)){
                    $msg = array('msg' => 'Error', 'icono' => 'error');                    
                }else{
                    $data_detalle_padre = $this->model->RegistrarDetalleFamilia($parentescopadre,$id_estudiante['id'],$id_familia_padre['id']);
                }                   

                $data_madre = $this->model->RegistrarFamilia($documentomadre,$numeromadre,$apellidosmadre,$nombresmadre,$sexomadre,$telefonomadre,$correomadre);
                $id_familia_madre = $this->model->getFamCod($numeromadre);   
                if(empty($id_familia_madre)){
                    $msg = array('msg' => 'Error', 'icono' => 'error');                     
                }else if(empty($id_estudiante)){
                    $msg = array('msg' => 'Error', 'icono' => 'error');                    
                }else{
                    $data_detalle_madre = $this->model->RegistrarDetalleFamilia($parentescomadre,$id_estudiante['id'],$id_familia_madre['id']);
                }  
                //fin familia
                
                
                if ($data == "modificado") {
                    $msg = array('msg' => 'Estudiante actualizado con éxito', 'icono' => 'success');
                }else{
                    $msg = array('msg' => 'Error al actualizar', 'icono' => 'error'); 
                }
            }            
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function editar(int $id)
    {
        $data['estudiante'] = $this->model->editarEst($id);
        $data['matricula'] = $this->model->editarMatri($id);
        $data['padre'] = $this->model->editarPad($id);        
        $data['madre'] = $this->model->editarMad($id);
        
        $aula = $this->model->editarMatri($id);
        $nivel = $aula['nivel'];
        $grado = $aula['grado'];
                
        $data['grados'] = $this->model->seachGrados($nivel);
        $data['secciones'] = $this->model->seachSecciones($nivel,$grado);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function eliminar(int $id)
    {
        $data = $this->model->accionEst(0,$id);
        if ($data == 1) {
            $msg = array('msg' => 'Estudiante eliminado con éxito', 'icono' => 'success');
        }else{
            $msg = array('msg' => 'Error al eliminar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function reingresar(int $id)
    {
        $data = $this->model->accionEst(1,$id);
        if ($data == 1) {
            $msg = array('msg' => 'Estudiante reingresado con éxito', 'icono' => 'success');
        }else{
            $msg = array('msg' => 'Error al reingresar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }  

    //COMBOX
    public function buscarGrado($nivel)
    {
        $data['detalle'] = $this->model->seachGrados($nivel);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function buscarSeccion()
    {
        $nivel = $_POST['cbonivel'];
        $grado = $_POST['cbogrado'];
        $data['detalle'] = $this->model->seachSecciones($nivel,$grado);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    
    //GENERAR PDF
    public function generarPDF()
    {
        $empresa = $this->model->getEmpresa();
        $personales = $this->model->getEstudiantes();
        
        require('Libraries/fpdf/fpdf.php');
        $pdf = new FPDF('P','mm',array(595.28,841.89));
               
        $pdf->AddPage('P', 'A4');
        $pdf->SetMargins(5, 0, 0);
        $pdf->SetTitle('Reporte Estudiante');
        $pdf->SetFont('Arial','B',14);
        $pdf->Image(base_url.'Assets/img/logo/'.$empresa['logo'], 180, 5, 14, 15);
        $pdf->Cell(180,10,'REPORTE ESTUDIANTES DE LA '.utf8_decode($empresa['nombre']), 0, 1, 'C');
        
        $pdf->SetFont('Arial','B',7);
        $pdf->Cell(34, 5, utf8_decode('Fecha y hora de impresión: '), 0, 0, 'L');
        $pdf->SetFont('Arial','',7);
        date_default_timezone_set('America/Lima'); 
        $DateAndTime = date('m-d-Y h:i:s a', time()); 
        $pdf->Cell(5, 5, $DateAndTime, 0, 1, 'L');    
               
        //Encabezado de personal
        $pdf->SetFillColor(0,0,0);
        $pdf->SetTextColor(255,255,255);
        $pdf->Cell(10,5, 'DOC', 0, 0, 'L', true);
        $pdf->Cell(15,5, utf8_decode('NÚMERO'), 0, 0, 'L', true);
        $pdf->Cell(30,5, 'APELLIDO PATERNO', 0, 0, 'L', true);
        $pdf->Cell(30,5, 'APELLIDO MATERNO', 0, 0, 'L', true);
        $pdf->Cell(40,5, 'NOMBRES', 0, 0, 'L', true);
        $pdf->Cell(10,5, 'SEXO', 0, 0, 'L', true);
        $pdf->Cell(20,5, 'F. NACIMIENTO', 0, 0, 'L', true);
        $pdf->Cell(20,5, 'GRADO', 0, 0, 'L', true);
        $pdf->Cell(20,5, utf8_decode('SECCIÓN'), 0, 1, 'L', true);
        
        $pdf->SetTextColor(0,0,0);
        foreach ($personales as $row) {
            $pdf->Cell(10,5, $row['documento'], 0, 0, 'L');
            $pdf->Cell(15,5, $row['numero'], 0, 0, 'L');
            $pdf->Cell(30,5, utf8_decode($row['apellido_paterno']), 0, 0, 'L');
            $pdf->Cell(30,5, utf8_decode($row['apellido_materno']), 0, 0, 'L');
            $pdf->Cell(40,5, utf8_decode($row['nombres']), 0, 0, 'L');
            $pdf->Cell(10,5, $row['sexo'], 0, 0, 'L');
            $fnac = date("d/m/Y", strtotime($row['fecha_nacimiento']));
            $pdf->Cell(20,5, $fnac, 0, 0, 'L');
            $pdf->Cell(20,5, utf8_decode($row['grado']), 0, 0, 'L');
            $pdf->Cell(20,5, utf8_decode($row['seccion']), 0, 1, 'L');            
        }

        $pdf->Output();
    } 
}
?>