<?php

namespace app\controllers\mappers;

use app\models\entities\Sprint;

class SprintsMapperController
{
    public static function to_entity(array $request): Sprint
    {
        return new Sprint(
            empty($request['id']) ? 0 : $request['id'],
            $request['nombre'],
            $request['fecha_inicio'],
            $request['fecha_fin']
        );
    }
}
