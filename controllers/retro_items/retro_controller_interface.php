<?php

namespace app\controllers\retro_items;

use app\models\entities\retro_items;

interface RetroControllerInterface
{
    public function get_retros_all(): array;

    public function get_retros_by_sprint(int $sprint_id): array;

    public function get_acciones_by_sprint(int $sprint_id): array;

    public function get_retro(int $id): retro_items;

    public function save_retro(array $request): bool;

    public function update_retro(array $request): bool;

    public function evaluate_accion(int $id, bool $cumplida, string $fecha_revision): bool;

    public function delete_retro(int $id): bool;
}
