<?php

namespace models;

use Ramsey\Uuid\Uuid;
class Categoria
{
    private $id;
    private $nombre;
    private $createdat;
    private $updatedat;
    private $isDeleted;

    public function __construct($id = null, $nombre = null, $createdat = null, $updatedat = null, $isDeleted = null)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->createdat = $createdat;
        $this->updatedat= $updatedat;
        $this->isDeleted = $isDeleted;

    }

    function __getId()
    {
        return $this->id;

    }


    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    private function generateUUID()
    {
        return Uuid::uuid4()->toString();

    }



}