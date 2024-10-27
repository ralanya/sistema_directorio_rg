<?php
class PersonasModel extends Query
{    
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

    public function getPersonas() 
    {
        $sql = "SELECT * FROM personas";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function registrarPersona(string $documento, string $numero, string $apellidos, string $nombres, string $sexo, string $fecha_nacimiento, string $telefono, string $correo)
    {        
        $verificar = "SELECT * FROM personas WHERE numero = '$numero'";
        $existe = $this->select($verificar);
        if (empty($existe)) {
            $sql = "INSERT INTO personas(documento,numero,apellidos,nombres,sexo,fecha_nacimiento,telefono,correo) VALUES(?,?,?,?,?,?,?,?)";
            $datos = array($documento, $numero, $apellidos, $nombres, $sexo, $fecha_nacimiento, $telefono, $correo);
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

    public function modificarPersona(string $documento, string $numero, string $apellidos, string $nombres, string $sexo, string $fecha_nacimiento, string $telefono, string $correo, int $id)
    {    
        $sql = "UPDATE personas SET documento = ?, numero = ?, apellidos = ?, nombres = ?, sexo = ?, fecha_nacimiento = ?, telefono = ?, correo = ? WHERE id = ?";
        $datos = array($documento, $numero, $apellidos, $nombres, $sexo, $fecha_nacimiento, $telefono, $correo, $id);
        $data = $this->save($sql,$datos);
        if ($data == 1) {
            $res = "modificado";
        }else{
            $res = "error";
        }           
        return $res;
    }

    public function editarPerson(int $id)
    {
        $sql = "SELECT * FROM personas WHERE id = $id";
        $data = $this->select($sql);
        return $data;
    }
    public function accionPerson(int $estado, int $id)
    {
        $this->id = $id;
        $this->estado = $estado;
        $sql = "UPDATE personas SET estado = ? WHERE id = ?";
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