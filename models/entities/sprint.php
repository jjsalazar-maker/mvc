<?php
namespace app\models\entities;

class sprint
{
    private int $id;
    private string $nombre;
    private string $fecha_inicio;
    private string $fecha_fin;

    public function __construct(
        int $id,
        string $nombre,
        string $fecha_inicio,
        string $fecha_fin
    ) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->fecha_inicio = $fecha_inicio;
        $this->fehca_fin = $fecha_fin;
    }

    public function get_id() : int 
    {
        return $this->id;
    }

    public function get_nombre() : string 
    {
        return $this->nombre;
    }

    public function get_fecha_inicio() : string
    {
        return $this->fecha_inicio;
    }

    public function get_fecha_fin() : string 
    {
        return $this->fecha_fin;
    }


}