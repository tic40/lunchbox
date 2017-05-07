<?php
namespace App\Entity;

class Position
{
    public $id;
    public $name;
    public $deletedAt;
    public $createdAt;
    public $updatedAt;

    public function getId()
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(string $deletedAt)
    {
        $this->deletedAt = $deletedAt;
    }

    public function isDeleted() : boolean
    {
        return empty($this->deletedAt);
    }
}
