<?php

namespace app\models\mappers;

use app\models\entities\retro_items;

class RetroMappers
{
    public static function to_entity(array $row_db): retro_items
    {
        return new retro_items(
            $row_db["id"],
            $row_db["sprint_id"],
            $row_db["categoria"],
            $row_db["descripcion"],
            isset($row_db["cumplida"]) ? (bool)$row_db["cumplida"] : null,
            $row_db["fecha_revision"] ?? null
        );
    }
}
