<?php

namespace app\models\mappers;

use app\models\entities\sprint;

class SprintMappers
{
    public static function to_entity(array $row_db): sprint
    {
        return new sprint(
            $row_db["id"],
            $row_db["nombre"]
        );
    }
}