<?php

namespace App\DAO;

use App\Config\Connection;
use App\DTO\CategoryDTO;

class CategoryDAO
{
    static function create(CategoryDTO $category)
    {
        $db = Connection::getConnection();
        $stmt = $db->prepare("INSERT INTO categories (title, tax) VALUES (?,?)");
        $stmt->bindValue(1, $category->getTitle(), \PDO::PARAM_STR);
        $stmt->bindValue(2, $category->getTax(), \PDO::PARAM_STR);
        $stmt->execute();
    }

    static function update(CategoryDTO $category)
    {
        $db = Connection::getConnection();
        $stmt = $db->prepare("UPDATE categories SET title=?,tax=? where id=? LIMIT 1");
        $stmt->bindValue(1, $category->getTitle(), \PDO::PARAM_STR);
        $stmt->bindValue(2, $category->getTax(), \PDO::PARAM_STR);
        $stmt->bindValue(3, $category->getId(), \PDO::PARAM_INT);
        $stmt->execute();
    }

    static function delete($categoryID)
    {
        $db = Connection::getConnection();
        $stmt = $db->prepare("DELETE FROM categories WHERE id=? LIMIT 1");
        $stmt->bindValue(1, $categoryID, \PDO::PARAM_INT);
        $stmt->execute();
    }

    static function getAll()
    {
        $db = Connection::getConnection();
        $str = "SELECT * FROM categories";
        $stmt = $db->query($str);
        $stmt->setFetchMode(\PDO::FETCH_NAMED);
        $categories = $stmt->fetchAll();
        return $categories;
    }

    static function getOnly($id)
    {
        $db = Connection::getConnection();
        $stmt = $db->prepare("SELECT * FROM categories  WHERE id = (?)");
        $stmt->bindValue(1, $id, \PDO::PARAM_STR);
        $stmt->execute();
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'App\DTO\CategoryDTO');
        $category = $stmt->fetch();
        return $category;
    }
}
