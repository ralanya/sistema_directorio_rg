<?php
class ExcelModel extends Query
{
    private $documento, $numero, $apellido_paterno, $apellido_materno, $nombres, $sexo, $fecha_nacimiento, $telefono, $correo, $id, $estado;
    private $id_estudiante, $id_aula;
    private $direccion, $id_cargo, $especialidad;
    private $parentesco, $id_familia;
    public function __construct()
    {
        parent::__construct();
    }
    public function RegistrarEstudiante(string $documento, string $numero, string $apellido_paterno, string $apellido_materno, string $nombres, string $sexo, string $fecha_nacimiento, string $telefono, string $correo)
    {        
        $this->documento = $documento;
        $this->numero = $numero;
        $this->apellido_paterno = $apellido_paterno;
        $this->apellido_materno = $apellido_materno;
        $this->nombres = $nombres;
        $this->sexo = $sexo;        
        $this->fecha_nacimiento = $fecha_nacimiento;
        $this->telefono = $telefono;
        $this->correo = $correo;      
        $verificar = "SELECT * FROM estudiantes WHERE numero = '$this->numero'";
        $existe = $this->select($verificar);
        if (empty($existe)) {
            $sql = "INSERT INTO estudiantes(documento,numero,apellido_paterno,apellido_materno,nombres,sexo,fecha_nacimiento,telefono,correo) VALUES(?,?,?,?,?,?,?,?,?)";
            $datos = array($this->documento, $this->numero, $this->apellido_paterno, $this->apellido_materno, $this->nombres, $this->sexo, $this->fecha_nacimiento, $this->telefono, $this->correo);
            $data = $this->save($sql,$datos);
            if ($data == 1) {
                $res = "1";
            }            
        }else{
            $sql = "UPDATE estudiantes SET documento = ?, apellido_paterno = ?, apellido_materno = ?, nombres = ?, sexo = ?, fecha_nacimiento = ?, telefono = ?, correo = ? WHERE numero = ?";
            $datos = array($this->documento, $this->apellido_paterno, $this->apellido_materno, $this->nombres, $this->sexo, $this->fecha_nacimiento, $this->telefono, $this->correo, $this->numero);
            $data = $this->save($sql,$datos);
            if ($data == 1) {
                $res = "2";
            }          
        }
        return $res;
    }

    public function getFamCod(string $numero)
    {
        $sql = "SELECT * FROM familias WHERE numero = '$numero'";
        $data = $this->select($sql);
        return $data;
    }  

    public function getEstuCod(string $numero)
    {
        $sql = "SELECT * FROM estudiantes WHERE numero = '$numero'";
        $data = $this->select($sql);
        return $data;
    }  
    public function getAulaCod(string $nivel, string $grado, string $seccion)
    {
        $sql = "SELECT * FROM aulas WHERE nivel = '$nivel' AND grado = '$grado' AND seccion = '$seccion'";
        $data = $this->select($sql);
        return $data;
    } 
    public function RegistrarMatricula(int $id_estudiante, int $id_aula)
    {      
        $this->id_estudiante = $id_estudiante;
        $this->id_aula = $id_aula;       

        $verificar = "SELECT * FROM matriculas WHERE id_estudiante = '$this->id_estudiante'";
        $existe = $this->select($verificar);
        
        if (empty($existe)) {
            $sql = "INSERT INTO matriculas(id_estudiante,id_aula) VALUES(?,?)";
            $datos = array($this->id_estudiante, $this->id_aula);
            $data = $this->save($sql,$datos);
            if ($data == 1) {
                $res = "1";
            }            
        }else{
            $sql = "UPDATE matriculas SET id_aula = ? WHERE id_estudiante = ?";
            $datos = array($this->id_aula, $this->id_estudiante);
            $data = $this->save($sql,$datos);
            if ($data == 1) {
                $res = "2";
            }          
        }
        return $res;
    }

    public function RegistrarPersonal(string $documento, string $numero, string $apellidos, string $nombres, string $sexo, string $fecha_nacimiento, string $direccion, string $telefono, string $correo, string $especialidad, int $id_cargo)
    {        
        $this->documento = $documento;
        $this->numero = $numero;
        $this->apellidos = $apellidos;
        $this->nombres = $nombres;
        $this->sexo = $sexo;        
        $this->fecha_nacimiento = $fecha_nacimiento;
        $this->direccion = $direccion;
        $this->telefono = $telefono;
        $this->correo = $correo;   
        $this->especialidad = $especialidad;   
        $this->id_cargo = $id_cargo;      
        $verificar = "SELECT * FROM personales WHERE numero = '$this->numero'";
        $existe = $this->select($verificar);
        if (empty($existe)) {
            $sql = "INSERT INTO personales(documento,numero,apellidos,nombres,sexo,fecha_nacimiento,direccion,telefono,correo,especialidad,id_cargo) VALUES(?,?,?,?,?,?,?,?,?,?,?)";
            $datos = array($this->documento, $this->numero, $this->apellidos, $this->nombres, $this->sexo, $this->fecha_nacimiento, $this->direccion, $this->telefono, $this->correo, $this->especialidad,$this->id_cargo);
            $data = $this->save($sql,$datos);
            if ($data == 1) {
                $res = "1";
            }            
        }else{
            $sql = "UPDATE personales SET documento = ?, apellidos = ?, nombres = ?, sexo = ?, fecha_nacimiento = ?, direccion = ?, telefono = ?, correo = ?, especialidad = ?, id_cargo = ? WHERE numero = ?";
            $datos = array($this->documento, $this->apellidos, $this->nombres, $this->sexo, $this->fecha_nacimiento, $this->direccion, $this->telefono, $this->correo, $this->especialidad, $this->id_cargo, $this->numero);
            $data = $this->save($sql,$datos);
            if ($data == 1) {
                $res = "2";
            }          
        }
        return $res;
    }
    public function getCargoCod(string $cargo)
    {
        $sql = "SELECT * FROM cargos WHERE nombre = '$cargo'";
        $data = $this->select($sql);
        return $data;
    } 

    public function RegistrarCargo(string $cargo)
    {
        $sql = "INSERT INTO cargos(nombre) VALUES(?)";
        $datos = array($cargo);
        $data = $this->save($sql,$datos);
    } 

    public function RegistrarFamilia(string $documento, string $numero, string $apellidos, string $nombres, string $sexo, string $telefono, string $correo)
    {        
        $this->documento = $documento;
        $this->numero = $numero;
        $this->apellidos = $apellidos;
        $this->nombres = $nombres;
        $this->sexo = $sexo;
        $this->telefono = $telefono;
        $this->correo = $correo;     
        $verificar = "SELECT * FROM familias WHERE numero = '$this->numero'";
        $existe = $this->select($verificar);
        if (empty($existe)) {
            $sql = "INSERT INTO familias(documento,numero,apellidos,nombres,sexo,telefono,correo) VALUES(?,?,?,?,?,?,?)";
            $datos = array($this->documento, $this->numero, $this->apellidos, $this->nombres, $this->sexo, $this->telefono, $this->correo);
            $data = $this->save($sql,$datos);
            if ($data == 1) {
                $res = "1";
            }            
        }else{
            $sql = "UPDATE familias SET documento = ?, apellidos = ?, nombres = ?, sexo = ?, telefono = ?, correo = ? WHERE numero = ?";
            $datos = array($this->documento, $this->apellidos, $this->nombres, $this->sexo, $this->telefono, $this->correo, $this->numero);
            $data = $this->save($sql,$datos);
            if ($data == 1) {
                $res = "2";
            }          
        }
        return $res;
    }

    public function RegistrarDetalleFamilia(string $parentesco, int $id_estudiante, int $id_familia)
    {        
        $this->parentesco = $parentesco;
        $this->id_estudiante = $id_estudiante;
        $this->id_familia = $id_familia;  
        $verificar = "SELECT * FROM detalle_familias WHERE id_familia = '$this->id_familia'";
        $existe = $this->select($verificar);
        if (empty($existe)) {
            $sql = "INSERT INTO detalle_familias(parentesco,id_estudiante,id_familia) VALUES(?,?,?)";
            $datos = array($this->parentesco, $this->id_estudiante, $this->id_familia);
            $data = $this->save($sql,$datos);
            if ($data == 1) {
                $res = "1";
            }            
        }else{
            $sql = "UPDATE detalle_familias SET parentesco = ?, id_estudiante = ? WHERE id_familia = ?";
            $datos = array($this->parentesco, $this->id_estudiante, $this->id_familia);
            $data = $this->save($sql,$datos);
            if ($data == 1) {
                $res = "2";
            }          
        }
        return $res;
    }
}
?>