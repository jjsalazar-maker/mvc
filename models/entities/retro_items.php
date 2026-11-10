<?php
namespace app\models\entities;

class retro_items
{
    private int $id;
    private int $sprint_id;
    private string $categoria;
    private string $descripcion;

    public function __construct(
    
    ){

    }
    
}




/*
id INT AUTO_INCREMENT PRIMARY KEY,
    sprint_id INT NOT NULL,
    categoria ENUM('accion', 'logro', 'impedimento', 'comentario', 'otro') NOT NULL,
    descripcion TEXT NOT NULL,
    cumplida BOOLEAN DEFAULT NULL, -- sólo aplica para acciones; NULL para los demás
    fecha_revision DATE DEFAULT NULL, -- fecha para revisar cumplimiento o seguimiento