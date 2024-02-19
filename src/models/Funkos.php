<?php

namespace models;

class Funkos
{
    private $id;
    private $nombre;
    private $precio;
    private $cantidad;
    private $imagen;
    private $createdat;
    private $updatedat;
    private $categoriaId;
    private $categoriaNombre;
    private $isDeleted;

    public function __construct($id = null, $nombre = null, $precio = null, $cantidad = null, $imagen = null, $createdat = null, $updatedat = null, $categoriaId = null, $categoriaNombre = null, $isDeleted = null)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->cantidad = $cantidad;
        $this->imagen = $imagen;
        $this->createdat = $createdat;
        $this->updatedat = $updatedat;
        $this->categoriaId = $categoriaId;
        $this->categoriaNombre = $categoriaNombre;
        $this->isDeleted = $isDeleted;
    }

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }

        return $this;
    }




}