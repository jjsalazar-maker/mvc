<?php

namespace app\models\repositories\users_repository;

use app\models\entities\retro_items;

private int $id;
private int $sprint_id;
private string $categoria;
private string $descripcion;

interface RetroRespositoryInterface
{   
    public function find_retro(string nombre): retro_items;

    public function get_retros(): array;

    public function save_new_retro(retro_items $nombre): bool;

    public function update_sprint(sprint $nombre): bool;
    
    public function find_sprint_by_id(int $id): sprint;
    
    public function delete_sprint(int $id): bool;
}