<?php
class Dashboard extends Controller{
    public function __construct() {
        session_start();        
        parent::__construct();
    }
    public function index() 
    {     
        if(empty($_SESSION['activo'])){
            header("location: ".base_url);
        }   
        $data['Personal'] = $this->model->getTotales('personales');
        $data['Estudiantes'] = $this->model->getTotales('matriculas');
        $data['Familias'] = $this->model->getTotales('familias');
        $data['Aulas'] = $this->model->getTotales('aulas');
        $data['Cumples'] = $this->model->getCumples();
        $this->views->getView($this, "index", $data);
    }

    //GRAFICO
    public function reporteEstudiantesxNivel()
    {
        $data = $this->model->getEstudiantesxNivel();
        echo json_encode($data);
        die();
    }
}