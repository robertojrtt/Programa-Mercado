<?php

namespace App\Service;

use App\DAO\CategoryDAO;
use App\DTO\CategoryDTO;
use App\Service\InterfaceService;

class CategoryService implements InterfaceService
{
    static function getAll()
    {
        $categories = CategoryDAO::getAll();
        return json_encode($categories);
    }

    static function getOnly(string $id)
    {
        $category = CategoryDAO::getOnly($id);

        if (!$category) return false;

        return json_encode($category->toArray());
    }

    static function create(array $params)
    {
        $category = new CategoryDTO();
        $category->setTax($params['tax']);
        $category->setTitle($params['title']);
        CategoryDAO::create($category);
    }

    static function update(string $id,  array $params)
    {
        $category = new CategoryDTO();
        $category->setTax($params['tax']);
        $category->setTitle($params['title']);
        $category->setId($id);

        CategoryDAO::update($category);
    }
    static function delete(string $id)
    {
        CategoryDAO::delete($id);
    }
}
