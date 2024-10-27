<?php
class PersonalesModel extends Query
{
    private $documento, $numero, $apellidos, $nombres, $sexo, $fecha_nacimiento, $telefono, $correo, $especialidad, $id_cargo, $id, $estado;
    
    public function __construct()
    {
        parent::__construct();
    }
    public function getCargos() 
    {
        $sql = "SELECT * FROM cargos WHERE estado = '1'";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function getPersonales() 
    {
        $sql = "SELECT p.*, c.nombre FROM personales p INNER JOIN cargos c ON p.id_cargo = c.id";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function registrarPersonal(string $documento, string $numero, string $apellidos, string $nombres, string $sexo, string $fecha_nacimiento, string $telefono, string $correo, string $especialidad, int $id_cargo)
    {
        $this->documento = $documento;
        $this->numero = $numero;
        $this->apellidos = $apellidos;
        $this->nombres = $nombres;
        $this->sexo = $sexo;        
        $this->fecha_nacimiento = $fecha_nacimiento;
        $this->telefono = $telefono;
        $this->correo = $correo;
        $this->especialidad = $especialidad;
        $this->id_cargo = $id_cargo;
        $verificar = "SELECT * FROM personales WHERE numero = '$this->numero'";
        $existe = $this->select($verificar);
        if (empty($existe)) {
            $sql = "INSERT INTO personales(documento,numero,apellidos,nombres,sexo,fecha_nacimiento,telefono,correo,especialidad,id_cargo) VALUES(?,?,?,?,?,?,?,?,?,?)";
            $datos = array($this->documento, $this->numero, $this->apellidos, $this->nombres, $this->sexo, $this->fecha_nacimiento, $this->telefono, $this->correo, $this->especialidad, $this->id_cargo);
            $data = $this->save($sql,$datos);
            if ($data == 1) {
                $res = "ok";
            }else{
                $res = "error";
            }
        }else{
            $res = "existe";
        }   
        return $res;
    }

    public function modificarPersonal(string $documento, string $numero, string $apellidos, string $nombres, string $sexo, string $fecha_nacimiento, string $telefono, string $correo, string $especialidad, int $id_cargo, int $id)
    {
        $this->documento = $documento;
        $this->numero = $numero;
        $this->apellidos = $apellidos;
        $this->nombres = $nombres;
        $this->sexo = $sexo;        
        $this->fecha_nacimiento = $fecha_nacimiento;
        $this->telefono = $telefono;
        $this->correo = $correo;
        $this->especialidad = $especialidad;
        $this->id_cargo = $id_cargo;
        $this->id = $id;
        
        $sql = "UPDATE personales SET documento = ?, numero = ?, apellidos = ?, nombres = ?, sexo = ?, fecha_nacimiento = ?, telefono = ?, correo = ?, especialidad = ?, id_cargo = ? WHERE id = ?";
        $datos = array($this->documento, $this->numero, $this->apellidos, $this->nombres, $this->sexo, $this->fecha_nacimiento, $this->telefono, $this->correo, $this->especialidad, $this->id_cargo, $this->id);
        $data = $this->save($sql,$datos);
        if ($data == 1) {
            $res = "modificado";
        }else{
            $res = "error";
        }           
        return $res;
    }

    public function editarPers(int $id)
    {
        $sql = "SELECT * FROM personales WHERE id = $id";
        $data = $this->select($sql);
        return $data;
    }
    public function accionPers(int $estado, int $id)
    {
        $this->id = $id;
        $this->estado = $estado;
        $sql = "UPDATE personales SET estado = ? WHERE id = ?";
        $datos = array($this->estado, $this->id);
        $data = $this->save($sql,$datos);
        return $data;
    }
    public function getEmpresa()
    {
        $sql = "SELECT * FROM configuracion";
        $data = $this->select($sql);
        return $data;
    }
}
?>