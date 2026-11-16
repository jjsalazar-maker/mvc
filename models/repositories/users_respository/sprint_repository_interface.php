<?php

namespace app\models\repositories\users_repository;

use app\models\entities\User;

  private int $id;
    private string $nombre;
    private string $fecha_inicio;
    private string $fecha_fin;

interface SprintRespositoryInterface
{   
    public function find_nombre(string nombre): sprint;

    public function get_sprints(): array;

    public function save_new_sprint(sprint $nombre): bool;
    public function update_sprint(sprint $nombre): bool;
    public function find_sprint_by_id(int $id): sprint;
    public function delete_sprint(int $id): bool;
}