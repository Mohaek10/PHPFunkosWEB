<?php
namespace service;
use models\Categoria;
use PDO;

require_once __DIR__ . '/../models/Categoria.php';
class CategoriaService
{
    private $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    public function findAll()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM categorias ORDER BY id ASC");
        $stmt->execute();

        $categorias = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $categoria = new Categoria(
                $row['id'],
                $row['nombre'],
                $row['created_at'],
                $row['updated_at'],
                $row['is_deleted']
            );
            $categorias[] = $categoria;
        }
        return $categorias;
    }
    public function findByName($name)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM categorias WHERE nombre = :nombre");
        $stmt->execute(['nombre' => $name]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return false;
        }
        $categoria = new Categoria(
            $row['id'],
            $row['nombre'],
            $row['created_at'],
            $row['updated_at'],
            $row['is_deleted']
        );
        return $categoria;
    }

    public function findById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM categorias WHERE id = :id");
        $stmt->execute(['id' => $id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return false;
        }
        $categoria = new Categoria(
            $row['id'],
            $row['nombre'],
            $row['created_at'],
            $row['updated_at'],
            $row['is_deleted']
        );
        return $categoria;
    }

    public function create(Categoria $categoria)
    {
        $categoria->id = Categoria::generateUUID();
        $stmt = $this->pdo->prepare("INSERT INTO categorias (id, nombre) VALUES (:id, :nombre)");
        $stmt->execute(['id' => $categoria->id, 'nombre' => $categoria->nombre]);
        return $this->findById($this->pdo->lastInsertId());
    }


    public function update($id, $nombre)
    {
        $stmt = $this->pdo->prepare("UPDATE categorias SET nombre = :nombre WHERE id = :id");
        $stmt->execute(['nombre' => $nombre, 'id' => $id]);
        return $this->findById($id);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM categorias WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }

    //Borrado lógico
    public function deleteLogical($id)
    {
        $stmt = $this->pdo->prepare("UPDATE categorias SET is_deleted = 1 WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }


}
