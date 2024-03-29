<?php

namespace service;

use models\Funkos;
use PDO;
use Ramsey\Uuid\Uuid;

require_once __DIR__ . '/../models/Funkos.php';

class FunkoService
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAllWithCategoryName($searchTerm = null)
    {
        $sql = "SELECT f.*, c.nombre as categoria_nombre FROM funko f LEFT JOIN categorias c ON f.categoria_id = c.id";

        if ($searchTerm) {
            $searchTerm = '%' . strtolower($searchTerm) . '%';
            $sql .= " WHERE LOWER(f.nombre) LIKE :searchTerm";
        }
        $sql .= " ORDER BY f.id ASC";
        $stmt = $this->pdo->prepare($sql);
        if ($searchTerm) {
            $stmt->bindValue(':searchTerm', $searchTerm, PDO::PARAM_STR);
        }

        $stmt->execute();

        $funkos = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $funko = new Funkos(
                $row['id'],
                $row['nombre'],
                $row['precio'],
                $row['cantidad'],
                $row['imagen'],
                $row['createdat'],
                $row['updatedat'],
                $row['categoria_id'],
                $row['categoria_nombre'],
                $row['is_deleted']
            );
            $funkos[] = $funko;
        }
        return $funkos;
    }

    public function findById($id)
    {
        $stmt = $this->pdo->prepare("SELECT f.*, c.nombre as categoria_nombre FROM funko f LEFT JOIN categorias c ON f.categoria_id = c.id WHERE f.id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }
        return new Funkos(
            $row['id'],
            $row['nombre'],
            $row['precio'],
            $row['cantidad'],
            $row['imagen'],
            $row['createdat'],
            $row['updatedat'],
            $row['categoria_id'],
            $row['categoria_nombre'],
            $row['is_deleted']
        );
    }

    public function create(Funkos $funko)
    {
        $sql = "INSERT INTO funko (nombre, precio, cantidad, imagen, createdat, updatedat, categoria_id) VALUES ( :nombre, :precio, :cantidad, :imagen, :createdat, :updatedat, :categoria_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':nombre', $funko->nombre, PDO::PARAM_STR);
        $stmt->bindValue(':precio', $funko->precio, PDO::PARAM_STR);
        $stmt->bindValue(':cantidad', $funko->cantidad, PDO::PARAM_INT);
        $stmt->bindValue(':imagen', $funko->imagen, PDO::PARAM_STR);
        $funko->createdat = date('Y-m-d H:i:s');
        $funko->updatedat = date('Y-m-d H:i:s');
        $stmt->bindValue(':createdat', $funko->createdat, PDO::PARAM_STR);
        $stmt->bindValue(':updatedat', $funko->updatedat, PDO::PARAM_STR);
        $stmt->bindValue(':categoria_id', $funko->categoriaId, PDO::PARAM_INT);
       return $stmt->execute();
    }

    public function update(Funkos $funko)
    {
        $sql = "UPDATE funko SET 
                 nombre = :nombre, 
                 precio = :precio, 
                 cantidad = :cantidad, 
                 imagen = :imagen, 
                 updatedat = :updatedat, 
                 categoria_id = :categoria_id 
             WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':nombre', $funko->nombre, PDO::PARAM_STR);
        $stmt->bindValue(':precio', $funko->precio, PDO::PARAM_STR);
        $stmt->bindValue(':cantidad', $funko->cantidad, PDO::PARAM_INT);
        $stmt->bindValue(':imagen', $funko->imagen, PDO::PARAM_STR);
        $funko->updatedat = date('Y-m-d H:i:s');
        $stmt->bindValue(':updatedat', $funko->updatedat, PDO::PARAM_STR);
        $stmt->bindValue(':categoria_id', $funko->categoriaId, PDO::PARAM_INT);
        $stmt->bindValue(':id', $funko->id, PDO::PARAM_INT);
        return $stmt->execute();

    }

    public function delete($id)
    {
        $sql="DELETE FROM funko WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }


}