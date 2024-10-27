<?php
class EstudiantesModel extends Query
{
    private $documento, $numero, $apellido_paterno, $apellido_materno, $nombres, $sexo, $fecha_nacimiento, $telefono, $correo, $id, $estado;
    public function __construct()
    {
        parent::__construct();
    }
    public function getEstudiantes() 
    {
        // $sql = "SELECT id, documento, numero, apellido_paterno, apellido_materno, 
        // nombres, sexo, DATE_FORMAT(fecha_nacimiento, '%d%-%m%-%Y') AS FNac, estado FROM estudiantes";
        $sql = "SELECT e.*, a.grado, a.seccion FROM estudiantes e INNER JOIN matriculas m ON e.id = m.id_estudiante INNER JOIN aulas a ON a.id = m.id_aula";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function getAulas() 
    {
        $sql = "SELECT * FROM aulas WHERE estado = '1'";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function getGrados() 
    {
        $sql = "SELECT DISTINCT grado FROM aulas WHERE estado = '1'";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function getSecciones() 
    {
        $sql = "SELECT DISTINCT seccion FROM aulas WHERE estado = '1'";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function registrarEstudiante(string $documento, string $numero, string $apellido_paterno, string $apellido_materno, string $nombres, string $sexo, string $fecha_nacimiento, string $telefono, string $correo)
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
                $res = "ok";
            }else{
                $res = "error";
            }
        }else{
            $res = "existe";
        }   
        return $res;
    }

    public function modificarEstudiante(string $documento, string $numero, string $apellido_paterno, string $apellido_materno, string $nombres, string $sexo, string $fecha_nacimiento, string $telefono, string $correo, int $id)
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
        $this->id = $id;
        
        $sql = "UPDATE estudiantes SET documento = ?, numero = ?, apellido_paterno = ?, apellido_materno = ?, nombres = ?, sexo = ?, fecha_nacimiento = ?, telefono = ?, correo = ? WHERE id = ?";
        $datos = array($this->documento, $this->numero, $this->apellido_paterno, $this->apellido_materno, $this->nombres, $this->sexo, $this->fecha_nacimiento, $this->telefono, $this->correo, $this->id);
        $data = $this->save($sql,$datos);
        if ($data == 1) {
            $res = "modificado";
        }else{
            $res = "error";
        }           
        return $res;
    }

    public function editarEst(int $id)
    {
        $sql = "SELECT e.* FROM estudiantes e WHERE e.id = $id";
        $data = $this->select($sql);
        return $data;
    }
    public function editarMatri(int $id)
    {
        $sql = "SELECT a.nivel, a.grado, a.seccion FROM estudiantes e 
                    INNER JOIN matriculas m ON e.id = m.id_estudiante 
                    INNER JOIN aulas a ON m.id_aula = a.id 
                    WHERE e.id = $id";
        $data = $this->select($sql);
        return $data;
    }
    public function editarPad(int $id)
    {
        $sql = "SELECT f.*, df.parentesco FROM estudiantes e 
                    INNER JOIN detalle_familias df ON e.id = df.id_estudiante
                    INNER JOIN familias f ON df.id_familia = f.id
                    WHERE f.sexo = 'H' AND e.id = $id";
        $data = $this->select($sql);
        return $data;
    }
    public function editarMad(int $id)
    {
        $sql = "SELECT f.*, df.parentesco FROM estudiantes e 
                    INNER JOIN detalle_familias df ON e.id = df.id_estudiante
                    INNER JOIN familias f ON df.id_familia = f.id
                    WHERE f.sexo = 'M' AND e.id = $id";
        $data = $this->select($sql);
        return $data;
    }
    public function accionEst(int $estado, int $id)
    {
        $this->id = $id;
        $this->estado = $estado;
        $sql = "UPDATE estudiantes SET estado = ? WHERE id = ?";
        $datos = array($this->estado, $this->id);
        $data = $this->save($sql,$datos);
        return $data;
    }

    //matricula
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

    //familia
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

    public function getFamCod(string $numero)
    {
        $sql = "SELECT * FROM familias WHERE numero = '$numero'";
        $data = $this->select($sql);
        return $data;
    }     
    
    //COMBOX
    public function seachGrados(string $nivel)
    {
        $sql = "SELECT id, grado FROM aulas WHERE nivel = '$nivel' GROUP BY grado ORDER BY id asc";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function seachSecciones(string $nivel, string $grado)
    {
        $sql = "SELECT id, seccion FROM aulas WHERE nivel = '$nivel' AND grado = '$grado' GROUP BY seccion ORDER BY id asc";
        $data = $this->selectAll($sql);
        return $data;
    }    

    //GENERAR PDF
    public function getEmpresa()
    {
        $sql = "SELECT * FROM configuracion";
        $data = $this->select($sql);
        return $data;
    }
}
?>