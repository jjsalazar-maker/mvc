<?php

namespace app\controllers\sprints;

use app\models\entities\sprint;

interface SprintsControllerInterface
{
    public function get_sprints_all(): array;
    public function save_sprint(array $request): bool;
    public function update_sprint(array $request): bool;
    public function get_sprint(int $id): User;
    public function delete_sprint(int $id):bool;
}