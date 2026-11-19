-- Crear base de datos
CREATE DATABASE IF NOT EXISTS registro_retro_db;
USE registro_retro_db;

-- Tabla de Sprints
CREATE TABLE sprints (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    fecha_inicio DATE NOT NULL,
    fecha_fin DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla única para items de retrospectiva (acciones, logros, impedimentos, etc.)
CREATE TABLE retro_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sprint_id INT NOT NULL,
    categoria ENUM('accion', 'logro', 'impedimento', 'comentario', 'otro') NOT NULL,
    descripcion TEXT NOT NULL,
    cumplida BOOLEAN DEFAULT NULL, -- sólo aplica para acciones; NULL para los demás
    fecha_revision DATE DEFAULT NULL, -- fecha para revisar cumplimiento o seguimiento
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (sprint_id) REFERENCES sprints(id) ON DELETE CASCADE
);

/*
Base de Datos y Módulo de Sprints (Backend)

Conexión a BD (models/database/): listo
Crear retro_db_interface.php y retro_db.php (igual a users_db.php pero apuntando a $name_db = "registro_retro_db").
Entidad Sprint (models/entities/sprint.php):
Corregir el typo de la línea 20 ($this->fehca_fin -> $this->fecha_fin).

Mappers de Sprint: revisar
models/mappers/sprint_mappers.php: convierte $row_db en objeto Sprint.
controllers/mappers/sprints_mapper_controller.php: convierte $_POST en objeto Sprint.

Repositorio de Sprints (models/repositories/sprints_repository/): modificar
sprints_repository_interface.php y sprints_repository.php con los métodos:
get_sprints(): array (listar todos)
find_sprint_by_id(int $id): Sprint
find_previous_sprint(int $current_sprint_id): ?Sprint (busca el sprint inmediatamente anterior con WHERE id < $current_sprint_id ORDER BY id DESC LIMIT 1 para poder cargar sus acciones)
save_new_sprint(Sprint $sprint): bool
update_sprint(Sprint $sprint): bool
delete_sprint(int $id): bool

Controlador de Sprints (controllers/sprints/):
sprints_controller_interface.php y sprints_controller.php.