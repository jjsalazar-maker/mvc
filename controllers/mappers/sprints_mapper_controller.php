<?php

namespace app\controllers\mappers;

use app\models\entities\sprint;

class SprintsMapperController
{
    public static function to_entity(array $request): sprint
    {
        return new User(
            empty($request['id']) ? 0 : $request['id'],
            $request['nombre'],
            $request['fecha_inicio'],
            $request['fecha_fin']
        );
    }
}
