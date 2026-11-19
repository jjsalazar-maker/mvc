<?php

namespace app\controllers\users;

use app\controllers\mappers\SprintsMapperController;
use app\models\entities\sprint;
use app\models\repositories\users_repository\SprintRespositoryInterface;

class SprintsController implements SprintsControllerInterface
{

    private SprintRespositoryInterface $sprint_model;

    public function __construct(SprintRespositoryInterface $sprint_model)
    {
        $this->sprint_model = $sprint_model;
    }

    public function get_sprints_all(): array
    {
        return $this->sprint_model->get_sprints();
    }

    public function save_sprint(array $request): bool
    {
        $sprint = sprintsMapperController::to_entity($request);
        return $this->sprint_model->save_new_sprint($sprint);
    }

    public function update_sprint(array $request): bool
    {
        $sprint = sprintsMapperController::to_entity($request);
        return $this->sprint_model->update_sprint($sprint);
    }

    public function get_sprint(int $id): sprint
    {
        return $this->sprint_model->find_sprint_by_id($id);
    }

    public function delete_sprint(int $id):bool{
        return $this->sprint_model->delete_sprint($id);
    }
}