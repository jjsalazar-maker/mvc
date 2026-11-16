<?php

namespace app\models\entities;

class retro_items
{
    private int $id;
    private int $sprint_id;
    private string $categoria;
    private string $descripcion;
    private bool|null $cumplida;
    private string|null $fecha_revision;

    public function __construct(
        int $id,
        int $sprint_id,
        string $categoria,
        string $descripcion,
        bool|null $cumplida = null,
        string|null $fecha_revision = null
    ) {
        $this->id = $id;
        $this->sprint_id = $sprint_id;
        $this->categoria = $categoria;
        $this->descripcion = $descripcion;
        $this->cumplida = $cumplida;
        $this->fecha_revision = $fecha_revision;
    }

    public function get_id(): int
    {
        return $this->id;
    }

    public function get_retro_id(): int
    {
        return $this->id;
    }

    public function get_sprint_id(): int
    {
        return $this->sprint_id;
    }

    public function get_categoria(): string
    {
        return $this->categoria;
    }

    public function get_descripcion(): string
    {
        return $this->descripcion;
    }

    public function get_cumplida(): bool|null
    {
        return $this->cumplida;
    }

    public function get_fecha_revision(): string|null
    {
        return $this->fecha_revision;
    }
}
