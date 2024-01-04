<?php

namespace App\DTO;

abstract class AbstractDTO 
{
    public function toArray() {
        return get_object_vars($this);
    }
}