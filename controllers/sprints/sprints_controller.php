<?php

namespace app\controllers\sprints;

use app\controllers\mappers\SprintsMapperController;
use app\models\entities\Sprint;
use app\models\repositories\sprints_repository\SprintRepositoryInterface;

class SprintsController implements SprintsControllerInterface
{
    private SprintRepositoryInterface $sprint_model;

    public function __construct(SprintRepositoryInterface $sprint_model)
    {
        $this->sprint_model = $sprint_model;
    }

    public function get_sprints_all(): array
    {
        return $this->sprint_model->get_sprints();
    }

    public function save_sprint(array $request): bool
    {
        $sprint = SprintsMapperController::to_entity($request);

        return $this->sprint_model->save_new_sprint($sprint);
    }

    public function update_sprint(array $request): bool
    {
        $sprint = SprintsMapperController::to_entity($request);

        return $this->sprint_model->update_sprint($sprint);
    }

    public function get_sprint(int $id): Sprint
    {
        return $this->sprint_model->find_sprint_by_id($id);
    }

    public function delete_sprint(int $id): bool
    {
        return $this->sprint_model->delete_sprint($id);
    }

    public function get_previous_sprint(int $current_sprint_id): ?Sprint
    {
        return $this->sprint_model->find_previous_sprint($current_sprint_id);
    }
}
