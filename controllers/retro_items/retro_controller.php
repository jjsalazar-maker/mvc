<?php

namespace app\controllers\retro_items;

use app\controllers\mappers\RetroMapperController;
use app\models\entities\retro_items;
use app\models\repositories\sprints_repository\RetroRespositoryInterface;

class RetroController implements RetroControllerInterface
{
    private RetroRespositoryInterface $retro_model;

    public function __construct(RetroRespositoryInterface $retro_model)
    {
        $this->retro_model = $retro_model;
    }

    public function get_retros_all(): array
    {
        return $this->retro_model->get_retros();
    }

    public function get_retros_by_sprint(int $sprint_id): array
    {
        return $this->retro_model->get_retros_by_sprint($sprint_id);
    }

    public function get_acciones_by_sprint(int $sprint_id): array
    {
        return $this->retro_model->get_acciones_by_sprint($sprint_id);
    }

    public function get_retro(int $id): retro_items
    {
        return $this->retro_model->find_retro_by_id($id);
    }

    public function save_retro(array $request): bool
    {
        $retro = RetroMapperController::to_entity($request);
        return $this->retro_model->save_new_retro($retro);
    }

    public function update_retro(array $request): bool
    {
        $retro = RetroMapperController::to_entity($request);
        return $this->retro_model->update_retro($retro);
    }

    public function evaluate_accion(int $id, bool $cumplida, string $fecha_revision): bool
    {
        return $this->retro_model->update_cumplimiento_accion($id, $cumplida, $fecha_revision);
    }

    public function delete_retro(int $id): bool
    {
        return $this->retro_model->delete_retro($id);
    }
}
