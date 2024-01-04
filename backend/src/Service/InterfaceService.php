<?php

namespace App\Service;

interface InterfaceService
{
    public static function getOnly(string $id);
    public static function getAll();
    public static function create(array $params);
    public static function update(string $id, array $params);
    public static function delete(string $id);
}
