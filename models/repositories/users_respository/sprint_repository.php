<?php
namespace app\models\repositories\users_repository;

use app\models\database\SprintDBInterface;
use app\models\entities\sprint;
use app\models\mappers\UserMappers;
use Exception;

class SprintRespository implements SprintRespositoryInterface
{
    private SprintDBInterface $sprint_db;

    public function __construct(SprintDBInterface $sprint_db)
    {
        $this->sprint_db = $sprint_db;
    }

    public function find_sprint(string nombre): spirnt
    {
        $sql = "select * from usuarios where nombre='$nombre'";
        $sprints = $this->sprints_db->query_select($sql);
        if (count($users) == 0) {
            throw new Exception("sprint", 2);
        }
        return UserMappers::to_entity($users[0]);
    }

    public function get_sprints(): array
    {
        $sql = "select * from usuarios";
        $sprints_db = $this->sprints_db->query_select($sql);
        return array_map(
            fn($row): sprint => SprintMappers::to_entity($row),
            $sprints_db
        );
    }

    public function save_new_sprint(sprint $sprint): bool
    {
        $sql = "insert into sprints (nombre, fecha_incio, fecha_fin)values";
        $sql .= "('" . $sprint->get_nombre() . "','" . $sprint->get_fecha_incio() . "','" . $sprint->get_fecha_fin() . "')";
        return $this->sprints_db->query($sql);
    }

    public function update_sprint(sprint $sprint): bool
    {
        $sql = "update usuarios set ";
        $sql .= " nombre='" . $sprint->get_nombre() . "', ";
        $sql .= " username='" . $sprint->get_fecha_incio() . "' ";
        $sql .= ", password='" . $sprint->get_fecha_fin() . "' ";
        $sql .= " where id=" . $sprint->get_id();
        return $this->sprints_db->query($sql);
    }

    public function find_sprint_by_id(int $id): sprint
    {
        $sql = "select * from usuarios where id=$id";
        $sprints = $this->sprints_db->query_select($sql);
        if (count($sprints) == 0) {
            throw new Exception("sprint no encontrado", 2);
        }
        return SprintMappers::to_entity($users[0]);
    }

    public function delete_sprint(int $id): bool
    {
        $sql = "delete from usuarios where id=$id";
        return $this->sprints_db->query($sql);
    }
}
