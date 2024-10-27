<?php
class Personas extends Controller
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
        $data = $this->model->getPersonas();
        for ($i=0; $i < count($data); $i++) {             
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';                
                if($id_rol == 1){
                    $data[$i]['acciones'] = '<div> 
                    <button class="btn btn-warning p-1 center-block" type="button" onclick="btnDetallePerson('.$data[$i]['id'].');" title="Detalles"><i class="fas fa-eye"></i></button>          
                    <button class="btn btn-primary p-1" type="button" onclick="btnEditarPerson('.$data[$i]['id'].');" title="Editar"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-danger p-1" type="button" onclick="btnEliminarPerson('.$data[$i]['id'].');" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
                    </div>';
                }else if($id_rol == 2){
                    $data[$i]['acciones'] = '<div> 
                    <button class="btn btn-warning p-1 center-block" type="button" onclick="btnDetallePerson('.$data[$i]['id'].');" title="Detalles"><i class="fas fa-eye"></i></button>          
                    <button class="btn btn-primary p-1" type="button" onclick="btnEditarPerson('.$data[$i]['id'].');" title="Editar"><i class="fas fa-edit"></i></button>
                    </div>';
                }
                else{
                    $data[$i]['acciones'] = '<div> 
                    <button class="btn btn-warning p-1" type="button" onclick="btnDetallePerson('.$data[$i]['id'].');" title="Detalles"><i class="fas fa-eye"></i></button>          
                    </div>';
                }             
            }else{
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                if($id_rol == 1){
                    $data[$i]['acciones'] = '<div>
                    <button class="btn btn-warning p-1" type="button" onclick="btnDetallePerson('.$data[$i]['id'].');" title="Detalles"><i class="fas fa-eye"></i></button>          
                    <button class="btn btn-success p-1" type="button" onclick="btnReingresarPerson('.$data[$i]['id'].');" title="Reingresar"><i class="fas fa-sign-in-alt"></i></button>
                    </div>';
                }else{
                    $data[$i]['acciones'] = '<div>
                    <button class="btn btn-warning p-1" type="button" onclick="btnDetallePerson('.$data[$i]['id'].');" title="Detalles"><i class="fas fa-eye"></i></button>          
                    </div>';
                }
            }                      
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrar()
    {
        $documento = $_POST['cbodocumento'];
        $numero = $_POST['txtnumero'];
        $apellidos = $_POST['txtapellidos'];
        $nombres = $_POST['txtnombres'];
        $sexo = $_POST['cbosexo'];        
        $fecha_nacimiento = $_POST['txtfecha'];
        $telefono = $_POST['txttelefono'];
        $correo = $_POST['txtcorreo'];
        $id = $_POST['txtid'];  
           
        if (empty($numero) || empty($apellidos) || empty($nombres) || empty($fecha_nacimiento)) {
            $msg = array('msg' => '(*) Los campos son obligatorios', 'icono' => 'warning');
        }else{
            if ($id == "") {
                $data = $this->model->registrarPersona($documento, $numero, $apellidos, $nombres, $sexo, $fecha_nacimiento, $telefono, $correo);
                if ($data == "ok") {
                    $msg = array('msg' => 'Persona registrado con éxito', 'icono' => 'success');
                }else if($data == "existe"){
                    $msg = array('msg' => 'La persona ya existe', 'icono' => 'warning');
                }else{
                    $msg = array('msg' => 'Error al guardar', 'icono' => 'error');
                }                              
            }else{
                $data = $this->model->modificarPersona($documento, $numero, $apellidos, $nombres, $sexo, $fecha_nacimiento, $telefono, $correo, $id);
                if ($data == "modificado") {
                    $msg = array('msg' => 'Persona actualizado con éxito', 'icono' => 'success');
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
        $data = $this->model->editarPerson($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function eliminar(int $id)
    {
        $data = $this->model->accionPerson(0,$id);
        if ($data == 1) {
            $msg = array('msg' => 'Persona eliminado con éxito', 'icono' => 'success');
        }else{
            $msg = array('msg' => 'Error al eliminar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function reingresar(int $id)
    {
        $data = $this->model->accionPerson(1,$id);
        if ($data == 1) {
            $msg = array('msg' => 'Persona reingresado con éxito', 'icono' => 'success');
        }else{
            $msg = array('msg' => 'Error al reingresar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    } 
    public function generarPDF()
    {
        $empresa = $this->model->getEmpresa();
        $personales = $this->model->getPersonas();
        
        require('Libraries/fpdf/fpdf.php');
        $pdf = new FPDF('P','mm',array(595.28,841.89));
        $pdf->AddPage('P', 'A4');
        $pdf->SetMargins(5, 0, 0);
        $pdf->SetTitle('Reporte Personal');
        $pdf->SetFont('Arial','B',14);
        $pdf->Image(base_url.'Assets/img/logo/'.$empresa['logo'], 180, 5, 14, 15);
        $pdf->Cell(180,10,'REPORTE PERSONAS EXTERNAS DE LA '.utf8_decode($empresa['nombre']), 0, 1, 'C');
        
        $pdf->SetFont('Arial','B',7);
        $pdf->Cell(34, 5, utf8_decode('Fecha y hora de impresión: '), 0, 0, 'L');
        $pdf->SetFont('Arial','',7);
        date_default_timezone_set('America/Lima'); 
        $DateAndTime = date('m-d-Y h:i:s a', time()); 
        $pdf->Cell(5, 5, $DateAndTime, 0, 1, 'L');    
               
        //Encabezado de personal
        $pdf->SetFillColor(0,0,0);
        $pdf->SetTextColor(255,255,255);
        $pdf->Cell(15,5, 'DOC', 0, 0, 'L', true);
        $pdf->Cell(20,5, utf8_decode('NÚMERO'), 0, 0, 'L', true);
        $pdf->Cell(45,5, 'APELLIDOS', 0, 0, 'L', true);
        $pdf->Cell(45,5, 'NOMBRES', 0, 0, 'L', true);
        $pdf->Cell(10,5, 'SEXO', 0, 0, 'L', true);
        $pdf->Cell(18,5, utf8_decode('TELÉFONO'), 0, 0, 'L', true);
        $pdf->Cell(45,5, 'CORREO', 0, 1, 'L', true);
        
        
        $pdf->SetTextColor(0,0,0);
        foreach ($personales as $row) {
            $pdf->Cell(15,5, $row['documento'], 0, 0, 'L');
            $pdf->Cell(20,5, $row['numero'], 0, 0, 'L');
            $pdf->Cell(45,5, utf8_decode($row['apellidos']), 0, 0, 'L');
            $pdf->Cell(45,5, utf8_decode($row['nombres']), 0, 0, 'L');
            $pdf->Cell(10,5, $row['sexo'], 0, 0, 'L');
            $pdf->Cell(18,5, $row['telefono'], 0, 0, 'L');
            $pdf->Cell(45,5, utf8_decode($row['correo']), 0, 1, 'L');            
        }
        $pdf->Output();
    } 
}
?>