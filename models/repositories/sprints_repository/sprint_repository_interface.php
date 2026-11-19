<?php

namespace app\models\repositories\sprints_repository;

use app\models\entities\Sprint;

interface SprintRepositoryInterface
{
  public function get_sprints(): array;

  public function find_sprint_by_id(int $id): Sprint;

  public function find_previous_sprint(int $current_sprint_id): ?Sprint;

  public function save_new_sprint(Sprint $sprint): bool;

  public function update_sprint(Sprint $sprint): bool;

  public function delete_sprint(int $id): bool;
}
