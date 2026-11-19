<?php

namespace app\models\repositories\sprints_repository;

use app\models\database\RegistroDBInterface;
use app\models\entities\Sprint;
use app\models\mappers\SprintMappers;
use Exception;

class SprintRepository implements SprintRepositoryInterface
{
    private RegistroDBInterface $sprint_db;

    public function __construct(RegistroDBInterface $sprint_db)
    {
        $this->sprint_db = $sprint_db;
    }

    public function get_sprints(): array
    {
        $sql = "SELECT * FROM sprints ORDER BY id ASC";

        $sprints_db = $this->sprint_db->query_select($sql);

        return array_map(
            fn($row): Sprint => SprintMappers::to_entity($row),
            $sprints_db
        );
    }

    public function find_sprint_by_id(int $id): Sprint
    {
        $sql = "SELECT * FROM sprints WHERE id = $id";

        $sprints = $this->sprint_db->query_select($sql);

        if (count($sprints) === 0) {
            throw new Exception("Sprint no encontrado");
        }

        return SprintMappers::to_entity($sprints[0]);
    }

    public function find_previous_sprint(int $current_sprint_id): ?Sprint
    {
        $sql = "SELECT * FROM sprints
                WHERE id < $current_sprint_id
                ORDER BY id DESC
                LIMIT 1";

        $sprints = $this->sprint_db->query_select($sql);

        if (count($sprints) === 0) {
            return null;
        }

        return SprintMappers::to_entity($sprints[0]);
    }

    public function save_new_sprint(Sprint $sprint): bool
    {
        $nombre = addslashes($sprint->get_nombre());
        $fecha_inicio = $sprint->get_fecha_inicio();
        $fecha_fin = $sprint->get_fecha_fin();

        $sql = "INSERT INTO sprints
                (nombre, fecha_inicio, fecha_fin)
                VALUES
                ('$nombre', '$fecha_inicio', '$fecha_fin')";

        return $this->sprint_db->query($sql);
    }

    // Actualizar un sprint existente
    public function update_sprint(Sprint $sprint): bool
    {
        $id = $sprint->get_id();
        $nombre = addslashes($sprint->get_nombre());
        $fecha_inicio = $sprint->get_fecha_inicio();
        $fecha_fin = $sprint->get_fecha_fin();

        $sql = "UPDATE sprints SET
                nombre = '$nombre',
                fecha_inicio = '$fecha_inicio',
                fecha_fin = '$fecha_fin'
                WHERE id = $id";

        return $this->sprint_db->query($sql);
    }

    // Eliminar un sprint
    public function delete_sprint(int $id): bool
    {
        $sql = "DELETE FROM sprints WHERE id = $id";

        return $this->sprint_db->query($sql);
    }
}

