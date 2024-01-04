<?php

namespace App\Service;

use App\DAO\ProductDAO;
use App\DTO\ProductDTO;
use App\Service\InterfaceService;

class ProductService implements InterfaceService
{
    static function getAll()
    {
        $products = ProductDAO::getAll();
        return json_encode($products);
    }

    static function getOnly(string $id)
    {
        $product = ProductDAO::getOnly($id);

        if (!$product) return false;

        return json_encode($product->toArray());
    }

    static function create(array $params)
    {
        $product = new ProductDTO();
        $product->setTitle($params['title']);
        $product->setDescription($params['description']);
        $product->setCategoryId($params['category_id']);
        $product->setPrice($params['price']);
        ProductDAO::create($product);
    }

    static function update(string $id,  array $params)
    {
        $product = new ProductDTO();
        $product->setTitle($params['title']);
        $product->setDescription($params['description']);
        $product->setCategoryId($params['category_id']);
        $product->setPrice($params['price']);
        $product->setId($id);

        ProductDAO::update($product);
    }
    static function delete(string $id)
    {
        ProductDAO::delete($id);
    }
}
