<?php

namespace app\models\database;

use mysqli;
use RuntimeException;

class RegistroDB implements RegistroDBInterface
{
    private string $host_db = "localhost";
    private string $user_db = "root";
    private string $pwd_db = "";
    private string $name_db = "registro_retro_db";
    private int $port_db = 3306;

    private mysqli $conex;

    public function __construct()
    {
        try {
            $this->conex = new mysqli(
                $this->host_db,
                $this->user_db,
                $this->pwd_db,
                $this->name_db,
                $this->port_db
            );

            $this->conex->set_charset("utf8mb4");

        } catch (\mysqli_sql_exception $e) {
            throw new RuntimeException(
                "Error de conexión: " . $e->getMessage(),
                0,
                $e
            );
        }
    }

    public function query_select(string $sql): array
    {
        $result = $this->conex->query($sql);

        $rows = [];

        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        $result->free();

        return $rows;
    }

    public function query(string $sql): bool
    {
        return $this->conex->query($sql) === true;
    }

    public function __destruct()
    {
        if (isset($this->conex)) {
            $this->conex->close();
        }
    }
}
