<?php
class Personales extends Controller
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
        $data['nombre'] = $this->model->getCargos();
        $this->views->getView($this, "index", $data);
    }    
    public function listar()
    {
        $id_rol = $_SESSION['id_rol'];
        $data = $this->model->getPersonales();
        for ($i=0; $i < count($data); $i++) {             
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';                
                if($id_rol == 1){
                    $data[$i]['acciones'] = '<div> 
                    <button class="btn btn-warning p-1 center-block" type="button" onclick="btnDetallePers('.$data[$i]['id'].');" title="Detalles"><i class="fas fa-eye"></i></button>          
                    <button class="btn btn-primary p-1" type="button" onclick="btnEditarPers('.$data[$i]['id'].');" title="Editar"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-danger p-1" type="button" onclick="btnEliminarPers('.$data[$i]['id'].');" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
                    </div>';
                }else if($id_rol == 2){
                    $data[$i]['acciones'] = '<div> 
                    <button class="btn btn-warning p-1 center-block" type="button" onclick="btnDetallePers('.$data[$i]['id'].');" title="Detalles"><i class="fas fa-eye"></i></button>          
                    <button class="btn btn-primary p-1" type="button" onclick="btnEditarPers('.$data[$i]['id'].');" title="Editar"><i class="fas fa-edit"></i></button>
                    </div>';
                }
                else{
                    $data[$i]['acciones'] = '<div> 
                    <button class="btn btn-warning p-1" type="button" onclick="btnDetallePers('.$data[$i]['id'].');" title="Detalles"><i class="fas fa-eye"></i></button>          
                    </div>';
                }             
            }else{
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                if($id_rol == 1){
                    $data[$i]['acciones'] = '<div>
                    <button class="btn btn-warning p-1" type="button" onclick="btnDetallePers('.$data[$i]['id'].');" title="Detalles"><i class="fas fa-eye"></i></button>          
                    <button class="btn btn-success p-1" type="button" onclick="btnReingresarPers('.$data[$i]['id'].');" title="Reingresar"><i class="fas fa-sign-in-alt"></i></button>
                    </div>';
                }else{
                    $data[$i]['acciones'] = '<div>
                    <button class="btn btn-warning p-1" type="button" onclick="btnDetallePers('.$data[$i]['id'].');" title="Detalles"><i class="fas fa-eye"></i></button>          
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
        $especialidad = $_POST['txtespecialidad'];
        $cargo = $_POST['cbocargo'];
        $id = $_POST['txtid'];  
           
        if (empty($numero) || empty($apellidos) || empty($nombres) || empty($fecha_nacimiento)) {
            $msg = array('msg' => '(*) Los campos son obligatorios', 'icono' => 'warning');
        }else{
            if ($id == "") {
                $data = $this->model->registrarPersonal($documento, $numero, $apellidos, $nombres, $sexo, $fecha_nacimiento, $telefono, $correo, $especialidad, $cargo);
                if ($data == "ok") {
                    $msg = array('msg' => 'Personal registrado con éxito', 'icono' => 'success');
                }else if($data == "existe"){
                    $msg = array('msg' => 'El personal ya existe', 'icono' => 'warning');
                }else{
                    $msg = array('msg' => 'Error al guardar', 'icono' => 'error');
                }                              
            }else{
                $data = $this->model->modificarPersonal($documento, $numero, $apellidos, $nombres, $sexo, $fecha_nacimiento, $telefono, $correo, $especialidad, $cargo, $id);
                if ($data == "modificado") {
                    $msg = array('msg' => 'Personal actualizado con éxito', 'icono' => 'success');
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
        $data = $this->model->editarPers($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function eliminar(int $id)
    {
        $data = $this->model->accionPers(0,$id);
        if ($data == 1) {
            $msg = array('msg' => 'Personal eliminado con éxito', 'icono' => 'success');
        }else{
            $msg = array('msg' => 'Error al eliminar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function reingresar(int $id)
    {
        $data = $this->model->accionPers(1,$id);
        if ($data == 1) {
            $msg = array('msg' => 'Personal reingresado con éxito', 'icono' => 'success');
        }else{
            $msg = array('msg' => 'Error al reingresar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    } 
    public function generarPDF()
    {
        $empresa = $this->model->getEmpresa();
        $personales = $this->model->getPersonales();
        
        require('Libraries/fpdf/fpdf.php');
        $pdf = new FPDF('P','mm',array(595.28,841.89));
        $pdf->AddPage('P', 'A4');
        $pdf->SetMargins(5, 0, 0);
        $pdf->SetTitle('Reporte Personal');
        $pdf->SetFont('Arial','B',14);
        $pdf->Image(base_url.'Assets/img/logo/'.$empresa['logo'], 180, 5, 14, 15);
        $pdf->Cell(180,10,'REPORTE PERSONAL DE LA '.utf8_decode($empresa['nombre']), 0, 1, 'C');
        
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
        $pdf->Cell(40,5, 'APELLIDOS', 0, 0, 'L', true);
        $pdf->Cell(40,5, 'NOMBRES', 0, 0, 'L', true);
        $pdf->Cell(10,5, 'SEXO', 0, 0, 'L', true);
        $pdf->Cell(35,5, 'CARGO', 0, 0, 'L', true);
        $pdf->Cell(18,5, utf8_decode('TELÉFONO'), 0, 0, 'L', true);
        $pdf->Cell(35,5, 'CORREO', 0, 1, 'L', true);
        
        
        $pdf->SetTextColor(0,0,0);
        foreach ($personales as $row) {
            $pdf->Cell(10,5, $row['documento'], 0, 0, 'L');
            $pdf->Cell(15,5, $row['numero'], 0, 0, 'L');
            $pdf->Cell(40,5, utf8_decode($row['apellidos']), 0, 0, 'L');
            $pdf->Cell(40,5, utf8_decode($row['nombres']), 0, 0, 'L');
            $pdf->Cell(10,5, $row['sexo'], 0, 0, 'L');
            $pdf->Cell(35,5, substr(utf8_decode($row['nombre']),0,20), 0, 0, 'L');
            $pdf->Cell(18,5, $row['telefono'], 0, 0, 'L');
            $pdf->Cell(35,5, utf8_decode($row['correo']), 0, 1, 'L');            
        }
        $pdf->Output();
    } 
}
?>