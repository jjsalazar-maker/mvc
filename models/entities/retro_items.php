<?php
namespace app\models\entities;

class retro_items
{
    private int $id;
    private int $sprint_id;
    private string $categoria;
    private string $descripcion;

    public function __construct(
    int $id,
    int $sprint_id,
    string $categoria,
    string $descripcion
    ){
    $this->id=$id;
    $this->sprint_id=$sprint_id;
    $this->categoria=$categoria;
    $this->descripcion=$descripcion;
    }

    public function get_retro_id(){
        return $this->id;
    }
    
    public function get_sprint_id(){
        return $this->sprint_id;
    }

    public function get_categoria(){
        return $this->categoria;
    }

    public function get_descripcion(){
        return $this->descripcion;
    }
}




/*
id INT AUTO_INCREMENT PRIMARY KEY,
    sprint_id INT NOT NULL,
    categoria ENUM('accion', 'logro', 'impedimento', 'comentario', 'otro') NOT NULL,
    descripcion TEXT NOT NULL,
    cumplida BOOLEAN DEFAULT NULL, -- sólo aplica para acciones; NULL para los demás
    fecha_revision DATE DEFAULT NULL, -- fecha para revisar cumplimiento o seguimiento