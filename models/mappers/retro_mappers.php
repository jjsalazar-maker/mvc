<?php

namespace app\models\mappers;

use app\models\entities\retro_items;

class RetroMappers
{
    public static function to_entity(array $row_db): retro_items
    {
        return new retro_items(
            $row_db["id"],
            $row_db["sprint id"],
            $row_db["categotia"],
            $row_db["descripcion"]
        );
    }
}