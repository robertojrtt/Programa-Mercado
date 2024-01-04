<?php

namespace App\DAO;

use App\Config\Connection;
use App\DTO\ProductDTO;

class ProductDAO
{
    static function create(ProductDTO $product)
    {
        $db = Connection::getConnection();
        $stmt = $db->prepare("INSERT INTO products (title, description, category_id, price) VALUES (?,?,?,?)");
        $stmt->bindValue(1, $product->getTitle(), \PDO::PARAM_STR);
        $stmt->bindValue(2, $product->getDescription(), \PDO::PARAM_STR);
        $stmt->bindValue(3, $product->getCategoryId(), \PDO::PARAM_STR);
        $stmt->bindValue(4, $product->getPrice(), \PDO::PARAM_STR);
        $stmt->execute();
    }

    static function update(ProductDTO $product)
    {
        $db = Connection::getConnection();
        $stmt = $db->prepare("UPDATE products SET title=?, description=?, category_id=?, price=? where id=? LIMIT 1");
        $stmt->bindValue(1, $product->getTitle(), \PDO::PARAM_STR);
        $stmt->bindValue(2, $product->getDescription(), \PDO::PARAM_STR);
        $stmt->bindValue(3, $product->getCategoryId(), \PDO::PARAM_STR);
        $stmt->bindValue(4, $product->getPrice(), \PDO::PARAM_STR);
        $stmt->bindValue(5, $product->getId(), \PDO::PARAM_STR);
        $stmt->execute();
    }

    static function delete($productID)
    {
        $db = Connection::getConnection();
        $stmt = $db->prepare("DELETE FROM products WHERE id=? LIMIT 1");
        $stmt->bindValue(1, $productID, \PDO::PARAM_INT);
        $stmt->execute();
    }

    static function getAll()
    {
        $db = Connection::getConnection();
        $str = "SELECT products.id, 
        products.title, 
        products.description, 
        products.price,
        categories.title as category, 
        categories.tax
        FROM products 
        INNER join categories on categories.id = products.category_id";
        $stmt = $db->query($str);
        $stmt->setFetchMode(\PDO::FETCH_NAMED);
        $products = $stmt->fetchAll();
        return $products;
    }

    static function getOnly($id)
    {
        $db = Connection::getConnection();
        $stmt = $db->prepare(
            "SELECT products.id, 
            products.title, 
            products.description, 
            products.price,
            categories.title as category, 
            categories.tax
            FROM products 
            INNER join categories on categories.id = products.category_id
            WHERE products.id = ?"
        );
        $stmt->bindValue(1, $id, \PDO::PARAM_STR);
        $stmt->execute();
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'App\DTO\ProductDTO');
        $product = $stmt->fetch();
        
        return $product;
    }
}
