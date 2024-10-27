<?php
class DashboardModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    
    //DATOS EMPRESA
    public function getTotales(string $table)
    {
        $sql = "SELECT COUNT(id) as Total FROM $table WHERE estado = 1";
        $data = $this->select($sql);
        return $data;
    }
    
    public function getEstudiantesxNivel()
    {
        $sql = "SELECT a.nivel, count(m.id_estudiante)as total FROM matriculas m INNER JOIN aulas a ON m.id_aula = a.id WHERE a.nivel = 'I' 
        UNION SELECT a.nivel, count(m.id_estudiante) as total FROM matriculas m INNER JOIN aulas a ON m.id_aula = a.id WHERE a.nivel = 'P' 
        UNION SELECT a.nivel, count(m.id_estudiante) as total FROM matriculas m INNER JOIN aulas a ON m.id_aula = a.id WHERE a.nivel = 'S'";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function getCumples()
    {
        $mesconcero = date("m");
        //$mesconcero = 11;
        $sql = "SELECT p.*, DATE_FORMAT(fecha_nacimiento, '%d%-%m%-%Y') AS FNac, c.nombre FROM personales p INNER JOIN cargos c ON p.id_cargo = c.id
                WHERE MONTH(fecha_nacimiento) = $mesconcero AND p.estado = 1 ORDER BY fecha_nacimiento ASC";
        $data = $this->selectAll($sql);
        return $data;
    }    
    // public function getEstudiantesxNivel()
    // {
    //     $sql = "SELECT a.nivel, COUNT(e.id) as Total FROM estudiantes e INNER JOIN matriculas m ON e.id = m.id_estudiante
    //             INNER JOIN aulas a ON m.id_aula = a.id WHERE a.nivel = 'I' UNION
    //             SELECT a.nivel, COUNT(e.id) as Total FROM estudiantes e INNER JOIN matriculas m ON e.id = m.id_estudiante
    //             INNER JOIN aulas a ON m.id_aula = a.id WHERE a.nivel = 'P' UNION
    //             SELECT a.nivel, COUNT(e.id) as Total FROM estudiantes e INNER JOIN matriculas m ON e.id = m.id_estudiante
    //             INNER JOIN aulas a ON m.id_aula = a.id WHERE a.nivel = 'S'";
    //     $data = $this->selectAll($sql);
    //     return $data;
    // }
}
?>