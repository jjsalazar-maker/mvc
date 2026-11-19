<?php

namespace app\controllers\mappers;

use app\models\entities\retro_items;

class RetroMapperController
{
    public static function to_entity(array $request): retro_items
    {
        $cumplida = null;
        if (isset($request['cumplida']) && $request['cumplida'] !== '') {
            $cumplida = (bool)$request['cumplida'];
        }

        $fecha_revision = empty($request['fecha_revision']) ? null : $request['fecha_revision'];

        return new retro_items(
            empty($request['id']) ? 0 : (int)$request['id'],
            (int)$request['sprint_id'],
            $request['categoria'],
            $request['descripcion'],
            $cumplida,
            $fecha_revision
        );
    }
}
