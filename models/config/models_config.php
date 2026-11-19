<?php

namespace app\models\config;

use app\models\database\RegistroDB;
use app\models\database\RegistroDBInterface;
use app\models\repositories\sprints_repository\RetroRespository;
use app\models\repositories\sprints_repository\RetroRespositoryInterface;
use app\models\repositories\sprints_repository\SprintRepository;
use app\models\repositories\sprints_repository\SprintRepositoryInterface;

class ModelsConfig
{
    public static function get_registro_db(): RegistroDBInterface
    {
        return new RegistroDB();
    }

    public static function get_sprints_repository(): SprintRepositoryInterface
    {
        return new SprintRepository(ModelsConfig::get_registro_db());
    }

    public static function get_retro_repository(): RetroRespositoryInterface
    {
        return new RetroRespository(ModelsConfig::get_registro_db());
    }
}
