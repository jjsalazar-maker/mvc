<?php

namespace app\models\repositories\users_repository;

use app\models\database\RegistroDBInterface;
use app\models\entities\retro_items;
use app\models\mappers\RetroMappers;
use Exception;

class RetroRespository implements RetroRespositoryInterface
{
    private RegistroDBInterface $retro_db;

    public function __construct(RegistroDBInterface $retro_db)
    {
        $this->retro_db = $retro_db;
    }

    public function get_retros(): array
    {
        $sql = "select * from retro_items";
        $retros_db = $this->retro_db->query_select($sql);
        return array_map(
            fn($row): retro_items => RetroMappers::to_entity($row),
            $retros_db
        );
    }

    public function get_retros_by_sprint(int $sprint_id): array
    {
        $sql = "select * from retro_items where sprint_id=$sprint_id";
        $retros_db = $this->retro_db->query_select($sql);
        return array_map(
            fn($row): retro_items => RetroMappers::to_entity($row),
            $retros_db
        );
    }

    public function get_acciones_by_sprint(int $sprint_id): array
    {
        $sql = "select * from retro_items where sprint_id=$sprint_id and categoria='accion'";
        $retros_db = $this->retro_db->query_select($sql);
        return array_map(
            fn($row): retro_items => RetroMappers::to_entity($row),
            $retros_db
        );
    }

    public function find_retro_by_id(int $id): retro_items
    {
        $sql = "select * from retro_items where id=$id";
        $retros = $this->retro_db->query_select($sql);
        if (count($retros) == 0) {
            throw new Exception("Item de retrospectiva no encontrado", 2);
        }
        return RetroMappers::to_entity($retros[0]);
    }

    public function save_new_retro(retro_items $retro): bool
    {
        $cumplida = $retro->get_cumplida() === null
            ? "NULL"
            : ($retro->get_cumplida() ? "1" : "0");
        $fecha_revision = empty($retro->get_fecha_revision())
            ? "NULL"
            : "'" . $retro->get_fecha_revision() . "'";

        $sql = "insert into retro_items (sprint_id, categoria, descripcion, cumplida, fecha_revision) values ";
        $sql .= "(" . $retro->get_sprint_id() . ", '" . $retro->get_categoria() . "', '" . $retro->get_descripcion() . "', " . $cumplida . ", " . $fecha_revision . ")";
        return $this->retro_db->query($sql);
    }

    public function update_retro(retro_items $retro): bool
    {
        $cumplida = $retro->get_cumplida() === null
            ? "NULL"
            : ($retro->get_cumplida() ? "1" : "0");
        $fecha_revision = empty($retro->get_fecha_revision())
            ? "NULL"
            : "'" . $retro->get_fecha_revision() . "'";

        $sql = "update retro_items set ";
        $sql .= "categoria='" . $retro->get_categoria() . "', ";
        $sql .= "descripcion='" . $retro->get_descripcion() . "', ";
        $sql .= "cumplida=" . $cumplida . ", ";
        $sql .= "fecha_revision=" . $fecha_revision . " ";
        $sql .= "where id=" . $retro->get_id();
        return $this->retro_db->query($sql);
    }

    public function update_cumplimiento_accion(int $id, bool $cumplida, string $fecha_revision): bool
    {
        $estado = $cumplida ? "1" : "0";
        $fecha = empty($fecha_revision) ? "NULL" : "'" . $fecha_revision . "'";

        $sql = "update retro_items set ";
        $sql .= "cumplida=" . $estado . ", ";
        $sql .= "fecha_revision=" . $fecha . " ";
        $sql .= "where id=" . $id;
        return $this->retro_db->query($sql);
    }

    public function delete_retro(int $id): bool
    {
        $sql = "delete from retro_items where id=$id";
        return $this->retro_db->query($sql);
    }
}
