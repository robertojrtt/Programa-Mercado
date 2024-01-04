<?php

namespace App\DTO;

use App\DTO\AbstractDTO;

class CategoryDTO extends AbstractDTO
{
    protected $id;
    protected $title;
    protected $tax;

    public function __construct()
    {
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getTax()
    {
        return $this->tax;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setTax($tax)
    {
        $this->tax = $tax;
    }
}
