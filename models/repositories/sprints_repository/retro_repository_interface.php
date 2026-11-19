<?php

namespace app\models\repositories\sprints_repository;

use app\models\entities\retro_items;

interface RetroRespositoryInterface
{
    public function get_retros(): array;

    public function get_retros_by_sprint(int $sprint_id): array;

    public function get_acciones_by_sprint(int $sprint_id): array;

    public function find_retro_by_id(int $id): retro_items;

    public function save_new_retro(retro_items $retro): bool;

    public function update_retro(retro_items $retro): bool;

    public function update_cumplimiento_accion(int $id, bool $cumplida, string $fecha_revision): bool;

    public function delete_retro(int $id): bool;
}
