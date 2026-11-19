<?php

namespace app\controllers\config;

use app\controllers\retro_items\RetroController;
use app\controllers\retro_items\RetroControllerInterface;
use app\controllers\sprints\SprintsController;
use app\controllers\sprints\SprintsControllerInterface;
use app\models\config\ModelsConfig;

class ControllersConfig
{
    public static function get_sprints_controller(): SprintsControllerInterface
    {
        return new SprintsController(ModelsConfig::get_sprints_repository());
    }

    public static function get_retro_controller(): RetroControllerInterface
    {
        return new RetroController(ModelsConfig::get_retro_repository());
    }
}
